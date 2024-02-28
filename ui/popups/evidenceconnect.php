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

	$filternodetypes = required_param("filternodetypes",PARAM_TEXT);
	$focalnodeid = required_param("focalnodeid",PARAM_TEXT);
	$focalnodeend = required_param("focalnodeend",PARAM_TEXT);
	$linktypename = required_param("linktypename",PARAM_TEXT);
	$focalnode = getNode($focalnodeid);

	$linknodetypename = optional_param("linknodetypename", "", PARAM_TEXT);
	$nodetypename = optional_param("nodetypename","", PARAM_TEXT);
	$summary = optional_param("summary","",PARAM_TEXT);
	$desc = optional_param("desc","",PARAM_HTML);
	$nodeid = optional_param("nodeid","",PARAM_TEXT);
	//$conndesc = optional_param("conndesc", "", PARAM_TEXT);
	$conndesc = "";

    $resourcetypesarray = optional_param("resourcetypesarray","",PARAM_TEXT);
    $resourcetitlearray = optional_param("resourcetitlearray","",PARAM_TEXT);
    $resourceurlarray = optional_param("resourceurlarray","",PARAM_URL);
    $identifierarray = optional_param("identifierarray","",PARAM_TEXT);
    $resourcenodeidsarray = optional_param("resourcenodeidsarray","",PARAM_TEXT);
    $resourcecliparray = optional_param("resourcecliparray","",PARAM_TEXT);
    $resourceclippatharray = optional_param("resourceclippatharray","",PARAM_TEXT);

	$handler = optional_param("handler","",PARAM_TEXT);
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

    $newtags = optional_param("newtags","",PARAM_TEXT);

    if( isset($_POST["addresource"]) ) {
        if ($summary == ""&& $nodeid == ""){
            array_push($errors, $LNG->FORM_EVIDENCE_ENTER_SUMMARY_ERROR);
        }

        if (is_countable($themesarray) && count($themesarray) <= 0 && $nodeid == ""){
            array_push($errors, $LNG->FORM_ERROR_THEME);
        }

 		if(empty($errors)){

			$r = getRoleByName($nodetypename);
			$roleType = $r->roleid;

			if ($nodeid != "") {
				$evidencenode = getNode($nodeid);
				$nodetypename = $evidencenode->role->name;
			} else if ($nodeid == "") {
				$desc = stripslashes(trim($desc));

				$evidencenode = addNode($summary, $desc, 'N', $roleType);
				if (!$evidencenode instanceof Hub_Error) {
					if ($CFG->autoFollowingOn) {
						addFollowing($evidencenode->nodeid);
					}

					$nodeid = $evidencenode->nodeid;

					// Add any new tags
					addTagsToNode($evidencenode, $newtags);

					// Add any themes
					connectThemesToNode($evidencenode,$themesarray,"N");

					/** ADD RESOURCES **/
					$errors = addResourcesToNode($evidencenode,$errors,$resourcenodeidsarray, $resourcetypesarray, $resourceurlarray, $resourcetitlearray, $identifierarray, $themesarray, $newtags, "N");
				}
			}

			if(empty($errors)){
				// CONNECT NODE TO FOCAL
				$r = getRoleByName($focalnode->role->name);
				$focalroleid = $r->roleid;

				$lt = getLinkTypeByLabel($linktypename);
				$linkType = $lt->linktypeid;

				if ($linknodetypename == "") {
					$linknodetypename = $nodetypename;
				}

				$r = getRoleByName($linknodetypename);
				$linkrole = $r->roleid;

				if ($focalnodeend == "from") {
					$connection = addConnection($focalnodeid, $focalroleid, $linkType, $nodeid, $linkrole, "N", $conndesc);
				} else {
					$connection = addConnection($nodeid, $linkrole, $linkType, $focalnodeid, $focalroleid, "N", $conndesc);
				}

				echo "<script type='text/javascript'>";

				// decision just to send them to the explore page for the other end of the connection
				// echo 'window.opener.location.href = "'.$CFG->homeAddress.'explore.php?id='.$nodeid.'";';

				if (isset($handler) && $handler != "") {
					echo "window.opener.".$handler."('".$linknodetypename."', '".$nodeid."');";
				} else {
					echo "if (window.opener && window.opener.refreshWidgetEvidence) {";
					echo "	  window.opener.refreshWidgetEvidence('".$linknodetypename."','".$nodeid."'); }";
					echo "else if (window.opener && window.opener.refreshEvidence) {";
					echo "	  window.opener.refreshEvidence(); }";
					echo "else {";
					echo "	  window.opener.location.reload(true); }";
				}

				echo "window.close();";
				echo "</script>";
				include_once($HUB_FLM->getCodeDirPath("ui/dialogfooter.php"));
				die;
			}
		}
    } else {
    	$resourceids[0] = "";
    }

	$formTitle = $LNG->FORM_EVIDENCE_TITLE_SECTION;
    if ($linknodetypename == 'Pro') {
    	$formTitle .= $LNG->FORM_EVIDENCE_TITLE_SECTION_SUPPORTING;
    } else if ($linknodetypename == 'Con') {
    	$formTitle .= $LNG->FORM_EVIDENCE_TITLE_SECTION_COUNTER;
    }
    $formTitle .= " ".$LNG->EVIDENCE_NAME;
    $formAddition = $LNG->FORM_EVIDENCE_TITLE_CONNECT;
    $formAddition .= '<br><span style="font-size: 80%">';
    $formAddition .= addslashes( $focalnode->name );
    $formAddition .= '</span>';

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
// Resource and themes always start with one entry - so if the array is empty the count should still be 1
var noThemes = <?php if (is_countable($themesarray) && count($themesarray) > 0) { echo count($themesarray); } else { echo "1";}?>;
var noResources = <?php if (is_countable($resourcetypesarray) && count($resourcetypesarray) > 0) { echo count($resourcetypesarray); } else { echo "1";}?>;

function init() {
    $('dialogheader').insert('<?php echo ($formTitle.$formAddition); ?>');
}

function addSelectedNode(node) {
	$('typediv').style.display="none";
	$('typehiddendiv').style.display="block";
	$('nodetypelabel').value=node.role[0].role.name;
	$('summary').value = node.name;
	$('summary').disabled = true;
	$('nodeid').value = node.nodeid;

	$('resourcediv').style.display="none";
	$('themediv').style.display="none";
	$('descdiv').style.display="none";
	$('tagsdiv').style.display="none";
}

function removeSelectedNode() {
	$('typediv').style.display="block";
	$('typehiddendiv').style.display="none";
	$('nodetypelabel').value='<?php echo $CFG->RESOURCE_TYPES_DEFAULT; ?>';
	$('summary').value = "";
	$('summary').disabled = false;
	$('nodeid').value = "";

	$('resourcediv').style.display="block";
	$('themediv').style.display="block";
	$('descdiv').style.display="block";
	$('tagsdiv').style.display="block";
}

function addSelectedResource(node, num) {
	$('resource'+num+'label').value=node.role[0].role.name;

	$('resourcetitle-'+num).value = node.name;
	$('resourcetitle-'+num).disabled = true;
	$('resourcenodeidsarray-'+num).value = node.nodeid;

	if ($('identifierdiv-'+num)) {
		$('identifierdiv-'+num).style.display="none";
	}

	$('typehiddendiv-'+num).style.display="block";
	$('typediv-'+num).style.display="none";
	$('resourceurldiv-'+num).style.display="none";
	$('resourcedescdiv-'+num).style.display="none";
}

function removeSelectedResource(num) {
	$('resource'+num+'menu').value='<?php echo $CFG->RESOURCE_TYPES_DEFAULT; ?>';
	$('resourcetitle-'+num).value = "";
	$('resourcetitle-'+num).disabled = false;
	$('resourcedesc-'+num).value = "";
	$('resourcenodeidsarray-'+num).value = "";

	$('typehiddendiv-'+num).style.display="none";
	$('typediv-'+num).style.display="block";
	$('resourceurldiv-'+num).style.display="block";
	$('resourcedescdiv-'+num).style.display="block";
}

function openSelector() {
	loadDialog('selector', URL_ROOT+"ui/popups/selector.php?filternodetypes=<?php echo $filternodetypes; ?>", 420, 730);
}

function checkThemeChange(num) {
	var selected = $('theme'+num+'menu').value;
	if (selected != "" && num == noThemes-1) {
		noThemes = addTheme(noThemes);
		$('theme'+noThemes+'menu').focus();
	}
}

function checkForm() {
	var checkname = ($('summary').value).trim();
	if ($('nodeid').value == "" && checkname == ""){
	   alert("<?php echo $LNG->FORM_EVIDENCE_ENTER_SUMMARY_ERROR; ?>");
	   return false;
	}
    if ($('nodeid').value == "" && $('theme0menu').value == "") {
	   alert("<?php echo $LNG->FORM_ERROR_THEME; ?>");
	   return false;
    }

    $('evidenceform').style.cursor = 'wait';

	return true;
}

window.onload = init;

</script>

<?php insertFormHeaderMessage(); ?>

<form id="evidenceform" name="evidenceform" action="" enctype="multipart/form-data" method="post" onsubmit="return checkForm();">
	<input type="hidden" id="focalnodeid" name="focalnodeid" value="<?php echo $focalnodeid; ?>" />
	<input type="hidden" id="focalnodeend" name="focalnodeend" value="<?php echo $focalnodeend; ?>" />
	<input type="hidden" id="filternodetypes" name="filternodetypes" value="<?php echo $filternodetypes; ?>" />
	<input type="hidden" id="linktypename" name="linktypename" value="<?php echo $linktypename; ?>" />
	<input type="hidden" id="linknodetypename" name="linknodetypename" value="<?php echo $linknodetypename; ?>" />
	<input type="hidden" id="nodeid" name="nodeid" value="<?php echo $nodeid; ?>" />
	<input type="hidden" id="handler" name="handler" value="<?php echo $handler; ?>" />
	<input type="hidden" id="theme" name="theme" value="<?php echo $theme; ?>" />

<h2 style="margin-left:5px;"><?php echo $formTitle; ?></h2>
<div class="subformconnect">
   <div class="hgrformrow" id="typehiddendiv" style="display:none;margin-bottom:10px;">
		<label  class="formlabelbig" for="nodetypelabel"><span style="vertical-align:top;"><?php echo $LNG->FORM_LABEL_TYPE; ?></span>
		<span class="active" onMouseOver="showFormHint('EvidenceType', event, 'hgrhint', '<?php echo $CFG->EVIDENCE_TYPES_DEFAULT;?>'); return false;" onMouseOut="hideHints(); return false;" onClick="hideHints(); return false;" onkeypress="enterKeyPressed(event)"><img src="<?php echo $HUB_FLM->getImagePath('info.png'); ?>" border="0" style="margin-top: 2px; margin-left: 5px; margin-right: 2px;" /></span>
		<span style="font-size:14pt;margin-top:3px;vertical-align:middle;color:red;">*</span>
		</label>
		<select class="subforminput hgrselect forminputmust" style="width:300px;" disabled id="nodetypelabel" name="nodetypelabel">
			<?php
				foreach($CFG->EVIDENCE_TYPES as $item){?>
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
	    <span class="active" onClick="javascript: removeSelectedNode()" class="form" style="margin-left: 15px;"><?php echo $LNG->FORM_BUTTON_REMOVE_CAP; ?></span>
	    <span class="active" onClick="javascript: openSelector()" class="form" style="margin-left: 10px;"><?php echo $LNG->FORM_BUTTON_SELECT_ANOTHER; ?></span>
   </div>

   <div class="hgrformrow" id="typediv">
		<label  class="formlabelbig" for="nodetypename"><span style="vertical-align:top"><?php echo $LNG->FORM_LABEL_TYPE; ?></span>
		<span class="active" onMouseOver="showFormHint('EvidenceType', event, 'hgrhint', '<?php echo $CFG->EVIDENCE_TYPES_DEFAULT;?>'); return false;" onMouseOut="hideHints(); return false;" onClick="hideHints(); return false;" onkeypress="enterKeyPressed(event)"><img src="<?php echo $HUB_FLM->getImagePath('info.png'); ?>" border="0" style="margin-top: 2px; margin-left: 5px; margin-right: 2px;" /></span>
		<span style="font-size:14pt;margin-top:3px;vertical-align:middle;color:red;">*</span>
		</label>
		<select class="subforminput hgrselect forminputmust" style="width:300px;" id="nodetypename" name="nodetypename">
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
		<?php if ($focalnodeid != "") { ?>
		    <span class="active" onClick="javascript: openSelector()" class="form" style="margin-left: 15px;"><?php echo $LNG->FORM_EVIDENCE_SELECT_EXISTING; ?></span>
		<?php }; ?>
   </div>

	<?php insertSummary('EvidenceSummary', $LNG->FORM_EVIDENCE_LABEL_SUMMARY); ?>

	<?php insertDescription('EvidenceDesc'); ?>

	<?php insertResourceForm('Resources'); ?>

	<?php insertThemes('EvidenceTheme', $theme); ?>

	<?php insertAddTags('EvidenceTag'); ?>
</div>

<div style="clear:both;"></div>

<?php if ($theme == "") { ?>
<!-- h2 style="margin-left:5px;"><?php echo $LNG->FORM_CONNECT_RELEVANCE_SECTION; ?></h2>
<div class="subformconnect">
	<?php insertReason('EvidenceReason'); ?>
</div -->
<?php } ?>

<div class="hgrformrow">
	<input class="submit" type="submit" value="<?php echo $LNG->FORM_BUTTON_PUBLISH; ?>" id="addresource" name="addresource">
	<input type="button" value="<?php echo $LNG->FORM_BUTTON_CANCEL; ?>" onclick="window.close();"/>
</div>

</form>

<?php
    include_once($HUB_FLM->getCodeDirPath("ui/dialogfooter.php"));
?>