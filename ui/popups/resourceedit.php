<?php
/********************************************************************************
 *                                                                              *
 *  (c) Copyright 2010 - 2024 The Open University UK                            *
 *                                                                              *
 *  This software is freely distributed in accordance with                      *
 *  the GNU Lesser General Public (LGPL) license, version 3 or later            *
 *  as published by the Free Software Foundation.                               *
 *  For details see LGPL: http://www.fsf.org/licensing/licenses/lgpl.html       *
 *               and GPL: http://www.fsf.org/licensing/licenses/gpl-3.0.html    *
 *                                                                              *
 *  This software is provided by the copyright holders and contributors "as is" *
 *  and any express or implied warranties, including, but not limited to, the   *
 *  implied warranties of merchantability and fitness for a particular purpose  *
 *  are disclaimed. In no event shall the copyright owner or contributors be    *
 *  liable for any direct, indirect, incidental, special, exemplary, or         *
 *  consequential damages (including, but not limited to, procurement of        *
 *  substitute goods or services; loss of use, data, or profits; or business    *
 *  interruption) however caused and on any theory of liability, whether in     *
 *  contract, strict liability, or tort (including negligence or otherwise)     *
 *  arising in any way out of the use of this software, even if advised of the  *
 *  possibility of such damage.                                                 *
 *                                                                              *
 ********************************************************************************/
    include_once("../../config.php");

    $me = substr($_SERVER["PHP_SELF"], 1); // remove initial '/'
    if ($HUB_FLM->hasCustomVersion($me)) {
    	$path = $HUB_FLM->getCodeDirPath($me);
    	include_once($path);
		die;
	}

    checkLogin();

    include_once($HUB_FLM->getCodeDirPath("ui/dialogheader.php"));
    include_once($HUB_FLM->getCodeDirPath("core/lib/url-validation.class.php"));
	include_once($HUB_FLM->getCodeDirPath("ui/popuplib.php"));

	$tags = array();
	$errors = array();

    $nodeid = stripslashes(trim(optional_param("nodeid","",PARAM_TEXT)));

	$handler = optional_param("handler","", PARAM_TEXT);
	//convert brackets
	$handler = parseToJSON($handler);

	$nodetypename = stripslashes(trim(optional_param("nodetypename","",PARAM_TEXT)));
    $title = stripslashes(trim(optional_param("title","",PARAM_TEXT)));
    $url = trim(optional_param("url","http://",PARAM_URL));
    $identifier = stripslashes(trim(optional_param("identifier","",PARAM_TEXT)));

    $removeclipsarray = optional_param("removeclipsarray","",PARAM_TEXT);

    $newtags = optional_param("newtags","",PARAM_TEXT);
    $removetagsarray = optional_param("removetags","",PARAM_TEXT);


    if(isset($_POST["editurl"])){
        //check all fields entered
        if ($url == "http://" || $url == ""){
            array_push($errors, $LNG->FORM_RESOURCE_ENTER_URL_ERROR);
        }
        if ($title == ""){
            array_push($errors, $LNG->FORM_RESOURCE_ENTER_TITLE_ERROR);
        }

		$URLValidator = new mrsnk_URL_validation($url, MRSNK_URL_DO_NOT_PRINT_ERRORS, MRSNK_URL_DO_NOT_CONNECT_2_URL);
		if($url != "" && !$URLValidator->isValid()){
			 array_push($errors,$LNG->FORM_RESOURCE_URL_FORMAT_ERROR);
		}

        if(empty($errors)){
			$r = getRoleByName($nodetypename);
			$refrole = $r->roleid;

			if ($title == "") {
				$title = $url;
			}

            $node = getNode($nodeid);
			$oldurl = $node->name;

			$refnode = editNode($nodeid, $url, $title, 'N', $refrole);

			if ($nodetypename == 'Publication' && $identifier != "") {
				$refnode->updateAdditionalIdentifier($identifier);
			} else {
				$refnode->updateAdditionalIdentifier(""); // if they change type
			}

			// remove any clips marked for removal
			if($removeclipsarray != "" && is_countable($removeclipsarray) && count($removeclipsarray) > 0) {
				$countclips = count($removeclipsarray);
				for($i=0; $i<$countclips; $i++) {
					if($removeclipsarray[$i] != "") {
						$refnode->removeURL($removeclipsarray[$i]);
						deleteUrl($removeclipsarray[$i]);
					}
				}
			}

			// update the clips if the url has been changed
			if ($oldurl != $url) {
            	$node = getNode($nodeid);
				if($node->urls) {
					$urls = $node->urls;
					$i = 0;
					$count = count($urls);
					for ($i=0; $i<$count; $i++)	{
						$urlObj = $urls[$i];
						$urlObj->edit($url, $urlObj->title, $urlObj->description, $urlObj->private, $urlObj->clip, $urlObj->clippath, $urlObj->createdfrom, $urlObj->identifier);
					}
				}
			}

			// remove from this node any tags marked for removal
			removeTagsFromNode($refnode, $removetagsarray);

			// Add any new tags
			addTagsToNode($refnode, $newtags);

			echo "<script type='text/javascript'>";

			echo "try { ";
				echo "var parent=window.opener.document; ";
				echo "if (window.opener && window.opener.loadSelecteditemNew) {";
				echo '	  window.opener.loadSelecteditemNew("'.$nodeid.'"); }';
				echo " else {";
				echo '	  window.opener.location.reload(true); }';
			echo "}";
			echo "catch(err) {";
			echo "}";

			echo "window.close();";
			echo "</script>";
			include_once($HUB_FLM->getCodeDirPath("ui/dialogfooter.php"));
			die;
        }
    } else if($nodeid != "") {
        // load the node and set the params
        $node = getNode($nodeid);
        if (!$node instanceof CNode){
            echo $LNG->FORM_RESOURCE_NOT_FOUND;
            die;
        }
        // check user can edit this node
        try {
            $node->canedit();
        } catch (Exception $e){
            echo $LNG->FORM_RESOURCE_PERMISSION_ERROR_MESSAGE;
            die;
        }

		$url = $node->name;
		$title = $node->description;
		$nodetypeid = $node->role->roleid;
		$nodetypename = $node->role->name;

		$identifier = "";
		if (isset($node->identifier)) {
			$identifier = $node->identifier;
		}

		$tags = array();
		if(isset($node->tags)) {
			$tags = $node->tags;
		}
	} else {
		echo "<script type='text/javascript'>";
		echo "alert('".$LNG->FORM_RESOURCE_NOT_FOUND."');";
		echo "window.close();";
		echo "</script>";
		die;
    }

	if ($nodeid != "") {
	   	$node = getNode($nodeid);
		$clips = array();
		if($node->urls) {
			$urls = $node->urls;
			$i = 0;
			$count = count($urls);
			for ($i = 0; $i < $count; $i++){
				$urlObj = $urls[$i];
				if ($urlObj->clip != "") {
					$clips[count($clips)] = $urlObj;
				}
			}
		}
	}
?>

<?php
if(!empty($errors)){
    echo "<div class='errors'>".$LNG->FORM_ERROR_MESSAGE.":<ul>";
    foreach ($errors as $error){
        echo "<li>".$error."</li>";
    }
    echo "</ul></div>";
}
?>

<script type="text/javascript">
function init() {
	$('dialogheader').insert("<?php echo $LNG->FORM_RESOURCE_TITLE_EDIT; ?>");

	typeChanged();
}

function typeChanged() {
	var type = $('nodetypename').value;
	if (type == "Publication") {
		$('identifierdiv').style.display = "flex";
	} else {
		$('identifierdiv').style.display = "none";
	}
}

function checkForm() {
	if (!isValidURI($('url').value)) {
	   alert("<?php echo $LNG->FORM_RESOURCE_URL_FORMAT_ERROR; ?>");
	   return false;
	}
	var checkurl = ($('url').value).trim();
	if (checkurl == "" || $('url').value == "http://"){
	   alert("<?php echo $LNG->FORM_RESOURCE_ENTER_URL_ERROR; ?>");
	   return false;
	}
	var checktitle = ($('title').value).trim();
	if (checktitle == ""){
	   alert("<?php echo $LNG->FORM_RESOURCE_ENTER_TITLE_ERROR; ?>");
	   return false;
	}

    $('addurl').style.cursor = 'wait';

    return true;
}

window.onload = init;
</script>

<div class="container-fluid popups">
	<div class="row p-4 justify-content-center">	
		<div class="col">
			<?php insertFormHeaderMessage(); ?>

			<form id="addurl" name="addurl" action="" method="post" onsubmit="return checkForm();">
				<input type="hidden" id="nodeid" name="nodeid" value="<?php echo $nodeid; ?>" />
				<input type="hidden" id="handler" name="handler" value="<?php echo $handler; ?>" />

				<div class="mb-3 row">
					<label class="col-sm-3 col-form-label" for="nodetypename">
						<?php echo $LNG->FORM_LABEL_TYPE; ?>
						<a class="active" onMouseOver="showFormHint('ResourceType', event, 'hgrhint'); return false;" onMouseOut="hideHints(); return false;" onClick="hideHints(); return false;" onkeypress="enterKeyPressed(event)">
							<i class="far fa-question-circle fa-lg me-2" aria-hidden="true" ></i> 
							<span class="sr-only">More info</span>
						</a>
						<span class="required">*</span>
					</label>
					<div class="col-sm-9">
						<select class="form-select" onchange="typeChanged()" id="nodetypename" name="nodetypename">
							<?php
								$count = 0;
								if (is_countable($CFG->RESOURCE_TYPES)) {
									$count = count($CFG->RESOURCE_TYPES);
								}
								for($i=0; $i<$count; $i++){
									$item = $CFG->RESOURCE_TYPES[$i];
									$name = $LNG->RESOURCE_TYPES[$i];
								?>
									<option value='<?php echo $item; ?>' <?php if ( $nodetypename == $item || ($nodetypename == "" && $item == $CFG->RESOURCE_TYPES_DEFAULT) ) { echo 'selected=\"true\"'; } ?> ><?php echo $name ?></option>
							<?php } ?>
						</select>
					</div>
				</div>

				<?php insertURL('ResourceURL'); ?>
				<?php insertTitle('ResourceTitle'); ?>
				<?php insertDOI('ResourceDOI'); ?>

				<?php
				if (is_countable($clips) && count($clips) > 0) { ?>
					<div class="hgrformrow" id="clipaddeddiv">
						<label class="col-sm-3 col-form-label"><span style="vertical-align:top"><?php echo $LNG->FORM_LABEL_CLIPS; ?></span>
							<a class="active" onMouseOver="showFormHint('ResourceClips', event, 'hgrhint'); return false;" onMouseOut="hideHints(); return false;" onClick="hideHints(); return false;" onkeypress="enterKeyPressed(event)">
								<i class="far fa-question-circle fa-lg me-2" aria-hidden="true" ></i> 
								<span class="sr-only">More info</span>
							</a>
						</label>
						<div class="subform" id="tagform">
						<?php
								$i = 0;
								foreach($clips as $clip) {
								$class = "subforminput";
								echo '<div id="clipfield'.$i.'" class="subformrow" style="float:left;clear:both;">';
								echo '<div style="float:left;margin-bottom:5px"><input type="checkbox" class="'.$class.'" id="removeclipsarray" name="removeclipsarray[]" value="'.$clip->urlid.'"';
								if(is_countable($removeclipsarray) && count($removeclipsarray) > 0){
									for($j=0; $j<count($removeclipsarray); $j++){
										if (isset($removeclipsarray[$j]) && $removeclipsarray[$j] != ""
											&& $removeclipsarray[$j] == $clip->urlid) {
											echo ' checked="true"';
											break;
										}
									}
								}
								echo '></div>';
								echo '<div style="float:left; margin-left:5px;margin-bottom:5px;width:365px;">'.$clip->clip.'</div><br/>';
								echo '</div>';
								$i++;
							}
						?>
							<div class="subformrow" style="float:left;margin-top:5px;"><label><?php echo $LNG->FORM_RESOURCE_CLIPS_SELECT_TO_REMOVE; ?></label></div>
						</div>
					</div>
				<?php } ?>

				<?php insertAddTags('ResourceTag'); ?>
				<?php insertTagsAdded('ResourceTagAdded'); ?>

				<div class="mb-3 row">
					<div class="d-grid gap-2 d-md-flex justify-content-md-center mb-3">
						<input class="btn btn-secondary" type="button" value="<?php echo $LNG->FORM_BUTTON_CANCEL; ?>" onclick="window.close();"/>
						<input class="btn btn-primary" type="submit" value="<?php echo $LNG->FORM_BUTTON_SAVE; ?>" id="editurl" name="editurl" />
					</div>
				</div>
			</form>
		</div>
	</div>
</div>

<?php
    include_once($HUB_FLM->getCodeDirPath("ui/dialogfooter.php"));
?>