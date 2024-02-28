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
    include_once($HUB_FLM->getCodeDirPath("core/lib/url-validation.class.php"));
	include_once($HUB_FLM->getCodeDirPath("ui/popuplib.php"));

	$errors = array();

	$filternodetypes = required_param("filternodetypes",PARAM_TEXT);
	$focalnodeid = required_param("focalnodeid",PARAM_TEXT);
	$focalnodeend = required_param("focalnodeend",PARAM_TEXT);
	$linktypename = required_param("linktypename",PARAM_TEXT);
	$focalnode = getNode($focalnodeid);

    $nodetypename = stripslashes(trim(optional_param("nodetypename","",PARAM_TEXT)));
    $title = stripslashes(trim(optional_param("title","",PARAM_TEXT)));
    $url = trim(optional_param("url","http://",PARAM_URL));
    $clip = stripslashes(trim(optional_param("clip","",PARAM_TEXT)));
    $clippath = stripslashes(trim(optional_param("clippath","",PARAM_TEXT)));
	$nodeid = optional_param("nodeid","",PARAM_TEXT);
	//$conndesc = optional_param("conndesc", "", PARAM_TEXT);
	$conndesc = "";
    $identifier = stripslashes(trim(optional_param("identifier","",PARAM_TEXT)));

	$themesarray = optional_param("themesarray","",PARAM_TEXT);
	$theme = optional_param("theme","",PARAM_TEXT);
	if ($theme != "") {
		if ($themesarray != "" && count($themesarray) > 0) {
			//need to add back in the passed theme as disabled selects don't get passed from the form
			array_splice($themesarray, 0, 0, $theme);
		} else {
			$themesarray = [];
			$themesarray[0] = $theme;
		}
	}

	$handler = optional_param("handler","",PARAM_TEXT);
    $newtags = optional_param("newtags","",PARAM_TEXT);

    if(isset($_POST["addurl"])){
        //check all fields entered
        if (($url == "http://" || $url == "") && $nodeid == ""){
            array_push($errors, $LNG->FORM_RESOURCE_ENTER_URL_ERROR);
        }
        if ($title == "" && $nodeid == ""){
            array_push($errors, $LNG->FORM_RESOURCE_ENTER_TITLE_ERROR);
        }

        if (is_countable($themesarray) && count($themesarray) <= 0 && $nodeid == ""){
            array_push($errors, $LNG->FORM_ERROR_THEME);
        }

        $URLValidator = new mrsnk_URL_validation($url, MRSNK_URL_DO_NOT_PRINT_ERRORS, MRSNK_URL_DO_NOT_CONNECT_2_URL);
        if($nodeid == "" && $url != "" && !$URLValidator->isValid()){
             array_push($errors,$LNG->FORM_RESOURCE_URL_FORMAT_ERROR);
		}

        if(empty($errors)){
			$r = getRoleByName($nodetypename);
			$refrole = $r->roleid;

			if ($nodeid != "") {
				$refnode = getNode($nodeid);
				$r = getRoleByName($refnode->role->name);
				$refrole = $r->roleid;
			} else if ($nodeid == "") {
				if ($title == "") {
					$title = $url;
				}

				$refnode = addNode($url, $title, 'N', $refrole);
				if (!$refnode instanceof Hub_Error) {
					if ($CFG->autoFollowingOn) {
						addFollowing($refnode->nodeid);
					}

					$nodeid = $refnode->nodeid;
					if ($nodetypename == 'Publication') {
						$refnode->updateAdditionalIdentifier($identifier);
					}

					// ADD URL TO REF
					$urlObj = addURL($url, $title, '', 'N', $clip, $clippath, "", "cohere", $identifier);
					$refnode->addURL($urlObj->urlid, "");

					// Add any new tags
					addTagsToNode($refnode, $newtags);

					// Add any themes
					connectThemesToNode($refnode,$themesarray,"N");
				}
			}

			// CONNECT NODE TO FOCAL
			$r = getRoleByName($focalnode->role->name);
			$focalroleid = $r->roleid;

			$lt = getLinkTypeByLabel($linktypename);
			$linkType = $lt->linktypeid;

			if ($focalnodeend == "from") {
				$connection = addConnection($focalnodeid, $focalroleid, $linkType, $nodeid, $refrole, "N", $conndesc);
			} else {
				$connection = addConnection($nodeid, $refrole, $linkType, $focalnodeid, $focalroleid, "N", $conndesc);
			}

			echo "<script type='text/javascript'>";

			// decision just to send them to the explore page for the other end of the connection
			// echo 'window.opener.location.href = "'.$CFG->homeAddress.'explore.php?id='.$nodeid.'";';

			if (isset($handler) && $handler != "") {
				echo "window.opener.".$handler."('".$nodeid."');";
			} else {
				echo "if (window.opener && window.opener.refreshWidgetResources) {";
				echo "	  window.opener.refreshWidgetResources('".$nodeid."'); }";
				echo "else if (window.opener && window.opener.refreshWebsites) {";
				echo "	  window.opener.refreshWebsites(); }";
				echo "else {";
				echo "	  window.opener.location.reload(true); }";
			}

			echo "window.close();";
			echo "</script>";
			include_once($HUB_FLM->getCodeDirPath("ui/dialogfooter.php"));
			die;
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
// Themes always start with one entry - so if the array is empty the count should still be 1
var noThemes = <?php if (is_countable($themesarray) && count($themesarray) > 0) { echo count($themesarray); } else { echo "1";}?>;


function init() {
    $('dialogheader').insert("<?php echo $LNG->FORM_RESOURCE_TITLE_CONNECT; ?><br><span style='font-size: 80%'>\"<?php echo addslashes( $focalnode->name ); ?>\"</span>");
}

function addSelectedNode(node) {
	$('typediv').style.display="none";
	$('typehiddendiv').style.display="block";
	$('nodetypelabel').value=node.role[0].role.name;
	$('title').value = node.description;
	$('nodeid').value = node.nodeid;

	if ($('identifierdiv')) {
		$('identifierdiv').style.display="none";
	}
	$('urldiv').style.display="none";
	$('themediv').style.display="none";
	$('tagsdiv').style.display="none";
}

function removeSelectedNode() {
	$('typediv').style.display="block";
	$('typehiddendiv').style.display="none";
	$('nodetypelabel').value='<?php echo $CFG->RESOURCE_TYPES_DEFAULT; ?>';
	$('title').value = "";
	$('nodeid').value = "";

	$('urldiv').style.display="block";
	$('themediv').style.display="block";
	$('tagsdiv').style.display="block";
}

function openSelector() {
	loadDialog('selector', URL_ROOT+"ui/popups/selector.php?filternodetypes=<?php echo $filternodetypes; ?>", 420, 730);
}

function typeChanged() {
	var type = $('nodetypename').value;
	if (type == "Publication") {
		$('identifierdiv').style.display = "block";
	} else {
		$('identifierdiv').style.display = "none";
	}
}

function checkThemeChange(num) {
	var selected = $('theme'+num+'menu').value;
	if (selected != "" && num == noThemes-1) {
		noThemes = addTheme(noThemes);
		$('theme'+noThemes+'menu').focus();
	}
}

function checkForm() {
	if ($('nodeid').value == "" && !urlCheck($('url').value)) {
	   alert("<?php echo $LNG->FORM_RESOURCE_URL_FORMAT_ERROR; ?>");
	   return false;
	}
	var checkurl = ($('url').value).trim();
	if ($('nodeid').value == "" && (checkurl == "" || $('url').value == "http://")){
	   alert("<?php echo $LNG->FORM_RESOURCE_ENTER_URL_ERROR; ?>");
	   return false;
	}
	var checktitle = ($('title').value).trim();
	if ($('nodeid').value == "" && checktitle == ""){
	   alert("<?php echo $LNG->FORM_RESOURCE_ENTER_TITLE_ERROR; ?>");
	   return false;
	}
	if ($('nodeid').value == "" && $('theme0menu').value == "") {
	   	alert("<?php echo $LNG->FORM_ERROR_THEME; ?>");
	   	return false;
    }

    $('addurl').style.cursor = 'wait';

    return true;
}

window.onload = init;
</script>

<?php insertFormHeaderMessage(); ?>

<form id="addurl" name="addurl" action="" method="post" onsubmit="return checkForm();">

	<input type="hidden" id="focalnodeid" name="focalnodeid" value="<?php echo $focalnodeid; ?>" />
	<input type="hidden" id="focalnodeend" name="focalnodeend" value="<?php echo $focalnodeend; ?>" />
	<input type="hidden" id="filternodetypes" name="filternodetypes" value="<?php echo $filternodetypes; ?>" />
	<input type="hidden" id="linktypename" name="linktypename" value="<?php echo $linktypename; ?>" />
	<input type="hidden" id="nodeid" name="nodeid" value="<?php echo $nodeid; ?>" />
	<input type="hidden" id="handler" name="handler" value="<?php echo $handler; ?>" />
    <input type="hidden" id="clip" name="clip" value="<?php echo $clip; ?>" />
   	<input type="hidden" id="clippath" name="clippath" value="<?php echo $clippath; ?>" />
	<input type="hidden" id="theme" name="theme" value="<?php echo $theme; ?>" />

<h2 style="margin-left:5px;"><?php echo $LNG->FORM_RESOURCE_TITLE_SECTION; ?></h2>
<div class="subformconnect" style="float:left;margin-bottom:10px;padding-bottom:10px;">
     <div class="formrow" id="typehiddendiv" style="display:none;margin-bottom:10px;">
		<label  class="formlabelbig" for="nodetypelabel"><span style="vertical-align:top">Type:</span>
			<span class="active" onMouseOver="showFormHint('ResourceType', event, 'hgrhint'); return false;" onMouseOut="hideHints(); return false;" onClick="hideHints(); return false;" onkeypress="enterKeyPressed(event)"><img src="<?php echo $HUB_FLM->getImagePath('info.png'); ?>" border="0" style="margin-top: 2px; margin-left: 5px; margin-right: 2px;" /></span>
			<span style="font-size:14pt;margin-top:3px;vertical-align:middle;color:red;">*</span>
		</label>
 		<select class="forminput hgrselect forminputmust" disabled id="nodetypelabel" name="nodetypelabel">
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
	    <span class="active" onClick="javascript: removeSelectedNode()" class="form" style="margin-left: 15px;">Remove</span>
	    <span class="active" onClick="javascript: openSelector()" class="form" style="margin-left: 10px;">Select Another</span>
    </div>


 	<div class="formrow" id="typediv">
		<label  class="formlabelbig" for="nodetypename"><span style="vertical-align:top"><?php echo $LNG->FORM_LABEL_TYPE; ?></span>
			<span class="active" onMouseOver="showFormHint('ResourceType', event, 'hgrhint'); return false;" onMouseOut="hideHints(); return false;" onClick="hideHints(); return false;" onkeypress="enterKeyPressed(event)"><img src="<?php echo $HUB_FLM->getImagePath('info.png'); ?>" border="0" style="margin-top: 2px; margin-left: 5px; margin-right: 2px;" /></span>
			<span style="font-size:14pt;margin-top:3px;vertical-align:middle;color:red;">*</span>
		</label>
		<select class="forminput hgrselect forminputmust" onchange="typeChanged()" id="nodetypename" name="nodetypename">
			<?php
				foreach($CFG->RESOURCE_TYPES as $item){?>
    	        	<option value='<?php echo $item; ?>' <?php if ( $nodetypename == $item || ($nodetypename == "" && $item == $CFG->RESOURCE_TYPES_DEFAULT) ) { echo 'selected=\"true\"'; } ?> ><?php echo $item ?></option>
			<?php } ?>
		</select>
		<?php if ($focalnodeid != "") { ?>
		    <span class="active" onClick="javascript: openSelector()" class="form" style="margin-left: 15px;"><?php echo $LNG->FORM_RESOURCE_SELECT_EXISTING; ?></span>
		<?php }; ?>
   </div>

    <?php insertUrl('ResourceURL'); ?>

    <?php insertTitle('ResourceTitle'); ?>

    <?php insertDOI('ResourceDOI'); ?>

	<?php insertThemes('ResourceTheme', $theme); ?>

	<?php insertAddTags('ResourceTag'); ?>

</div>
<div style="clear:both;"></div>

<?php if ($theme == "") { ?>
<!-- h2 style="margin-left:5px;"><?php echo $LNG->FORM_CONNECT_RELEVANCE_SECTION; ?></h2>
<div class="subformconnect">
	<?php insertReason('ResourceReason'); ?>
</div -->
<?php } ?>

<div class="formrow" style="margin-top:10px;">
	<input class="submit" type="submit" value="<?php echo $LNG->FORM_BUTTON_PUBLISH; ?>" id="addurl" name="addurl">
	<input type="button" value="<?php echo $LNG->FORM_BUTTON_CANCEL; ?>" onclick="window.close();"/>
</div>

</form>

<?php
    include_once($HUB_FLM->getCodeDirPath("ui/dialogfooter.php"));
?>