<?php
/********************************************************************************
 *                                                                              *
 *  (c) Copyright 2013 The Open University UK                                   *
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
	include_once($HUB_FLM->getCodeDirPath("ui/popuplib.php"));

    $errors = array();
	$tags = array();

	$nodeid = required_param("nodeid",PARAM_TEXT);

	$handler = optional_param("handler","", PARAM_TEXT);
	//convert brackets
	$handler = parseToJSON($handler);

	$nodetypename = optional_param("nodetypename", "", PARAM_TEXT);
	$summary = optional_param("summary","",PARAM_TEXT);
	$desc = optional_param("desc","",PARAM_HTML);

    $newtags = optional_param("newtags","",PARAM_TEXT);
    $removetagsarray = optional_param("removetags","",PARAM_TEXT);

    if( isset($_POST["editevidence"])) {

        if ($summary == ""){
            array_push($errors, $LNG->FORM_EVIDENCE_ENTER_SUMMARY_ERROR);
        }

 		if(empty($errors)){
			$r = getRoleByName("Reference");
			$roleRef = $r->roleid;

			$r = getRoleByName($nodetypename);
			$roleType = $r->roleid;

			$lt = getLinkTypeByLabel('is related to');
			$linkRelated = $lt->linktypeid;

			$desc = stripslashes(trim($desc));

			$evidencenode = editNode($nodeid, $summary, $desc, 'N', $roleType);
		    if ($evidencenode instanceof Hub_Error){
				array_push($errors, $LNG->FORM_EVIDENCE_ALREADY_EXISTS);
			} else {
				// remove from this node any tags marked for removal
				removeTagsFromNode($evidencenode, $removetagsarray);

				// Add any new tags
				addTagsToNode($evidencenode, $newtags);

				echo "<script type='text/javascript'>";

				echo "try { ";
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
		}
    } else if ($nodeid != "") {
		$node = new CNode($nodeid);
		$node->load();
		$summary = $node->name;
		$desc = $node->description;
		$nodetypename = $node->role->name;

		if(isset($node->tags)) {
			$tags = $node->tags;
		}
	} else {
		echo "<script type='text/javascript'>";
		echo "alert('".$LNG->FORM_EVIDENCE_NOT_FOUND."');";
		echo "window.close();";
		echo "</script>";
		die;
	}

    /**********************************************************************************/
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
    $('dialogheader').insert('<?php echo $LNG->FORM_EVIDENCE_TITLE_EDIT; ?>');
}

function checkForm() {
	var checkname = ($('summary').value).trim();
	if (checkname == ""){
		  alert("<?php echo $LNG->FORM_EVIDENCE_ENTER_SUMMARY_ERROR; ?>");
	      return false;
	}

    $('evidenceform').style.cursor = 'wait';

	return true;
}

window.onload = init;

</script>

<div class="container-fluid popups">
	<div class="row p-4 justify-content-center">	
		<div class="col">
			<?php insertFormHeaderMessage(); ?>

			<form id="evidenceform" name="evidenceform" action="" enctype="multipart/form-data" method="post" onsubmit="return checkForm();">
				<input type="hidden" id="nodeid" name="nodeid" value="<?php echo $nodeid; ?>" />
				<input type="hidden" id="handler" name="handler" value="<?php echo $handler; ?>" />

				<div class="mb-3 row">
					<label class="col-sm-3 col-form-label" for="nodetypename">
						<?php echo $LNG->FORM_LABEL_TYPE; ?>
						<a class="active" onMouseOver="showFormHint('EvidenceType', event, 'hgrhint', '<?php echo $CFG->EVIDENCE_TYPES_DEFAULT;?>'); return false;" onMouseOut="hideHints(); return false;" onClick="hideHints(); return false;" onkeypress="enterKeyPressed(event)">
							<i class="far fa-question-circle fa-lg me-2" aria-hidden="true" ></i> 
							<span class="sr-only">More info</span>
						</a>
						<span class="required">*</span>
					</label>
					<div class="col-sm-9">
						<select class="form-select" id="nodetypename" name="nodetypename">
							<?php
								$count = 0;
								if (is_countable($CFG->EVIDENCE_TYPES)) {
									$count = count($CFG->EVIDENCE_TYPES);
								}
								for($i=0; $i<$count; $i++){
									$item = $CFG->EVIDENCE_TYPES[$i];
									$name = $LNG->EVIDENCE_TYPES[$i];
									error_log($name);
								?>
									<option value='<?php echo $item; ?>' <?php if ($nodetypename == $item || ($nodetypename == "" && $item == $CFG->EVIDENCE_TYPES_DEFAULT)) { echo 'selected=\"true\"'; }  ?> ><?php echo $name; ?></option>
							<?php } ?>
						</select>
					</div>
				</div>

				<?php insertSummary('EvidenceSummary', $LNG->FORM_EVIDENCE_LABEL_SUMMARY); ?>
				<?php insertDescription('EvidenceDesc'); ?>
				<?php insertAddTags('EvidenceTag'); ?>
				<?php insertTagsAdded('EvidenceTagAdded'); ?>

				<div class="mb-3 row">
					<div class="d-grid gap-2 d-md-flex justify-content-md-center mb-3">
						<input class="btn btn-secondary" type="button" value="<?php echo $LNG->FORM_BUTTON_CANCEL; ?>" onclick="window.close();"/>
						<input class="btn btn-primary" type="submit" value="<?php echo $LNG->FORM_BUTTON_SAVE; ?>" id="editevidence" name="editevidence" />
					</div>
				</div>
			</form>
		</div>
	</div>
</div>


<?php
    include_once($HUB_FLM->getCodeDirPath("ui/dialogfooter.php"));
?>