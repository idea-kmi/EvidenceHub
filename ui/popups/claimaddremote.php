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

    include_once($HUB_FLM->getCodeDirPath("core/utillib.php"));

    checkLogin();

    include_once($HUB_FLM->getCodeDirPath("ui/dialogheader.php"));
	include_once($HUB_FLM->getCodeDirPath("ui/popuplib.php"));

    $errors = array();

	$claim = optional_param("claim","",PARAM_TEXT);
	$desc = optional_param("desc","",PARAM_HTML);

	$evidence = optional_param("evidence","",PARAM_TEXT);
	$evidencetype = optional_param("evidencetype","",PARAM_TEXT);
	$evidencedesc = optional_param("evidencedesc","",PARAM_HTML);
	$evidencenodeid = optional_param("evidencenodeid","",PARAM_TEXT);

    $resourcetypesarray = optional_param("resourcetypesarray","",PARAM_TEXT);
    $resourcetitlearray = optional_param("resourcetitlearray","",PARAM_TEXT);
    $resourceurlarray = optional_param("resourceurlarray","",PARAM_URL);
    $identifierarray = optional_param("identifierarray","",PARAM_TEXT);
    $resourcenodeidsarray = optional_param("resourcenodeidsarray","",PARAM_TEXT);
    $resourcecliparray = optional_param("resourcecliparray","",PARAM_TEXT);
    $resourceclippatharray = optional_param("resourceclippatharray","",PARAM_TEXT);

	$themesarray = optional_param("themesarray","",PARAM_TEXT);
    $newtags = optional_param("newtags","",PARAM_TEXT);

    if( isset($_POST["addclaim"]) ) {

        if ($claim == ""){
            array_push($errors, $LNG->FORM_CLAIM_ENTER_SUMMARY_ERROR);
        }

        if (is_countable($themesarray) && count($themesarray) <= 0){
            array_push($errors,$LNG->FORM_ERROR_THEME);
        }

        if(empty($errors)){

			// GET ROLES AND LINKS FOR USER
			$r = getRoleByName("Claim");
			$roleClaim = $r->roleid;

			// CREATE THE CLAIM NODE
			$claimnode = addNode($claim,$desc, 'N', $roleClaim);

			if (!$claimnode instanceof Hub_Error) {
				if ($CFG->autoFollowingOn) {
					addFollowing($claimnode->nodeid);
				}

				// add themes
				connectThemesToNode($claimnode, $themesarray,"N");

				// Add any new tags
				addTagsToNode($claimnode, $newtags);


				$r = getRoleByName('Pro');
				$roleConnectionEvidence = $r->roleid;

				/** ADD EVIDENCE **/
				if(empty($errors) && $evidencenodeid != "") {
					$evidencenode = getNode($evidencenodeid);
					$evidencenode->load();
					$roleEvidence = $evidencenode->role->roleid;

				} else if (empty($errors) && $evidence != "" && $evidencetype != ""){
					$r = getRoleByName($evidencetype);
					$roleEvidence = $r->roleid;

					$desc = stripslashes(trim($evidencedesc));
					$evidencenode = addNode($evidence, $desc, 'N', $roleEvidence);
					if (!$evidencenode instanceof Hub_Error) {
						if ($CFG->autoFollowingOn) {
							addFollowing($evidencenode->nodeid);
						}
					}
				}

				if (isset($evidencenode) && !$evidencenode instanceof Hub_Error) {

					/** ADD RESOURCES **/
					$errors = addResourcesToNode($evidencenode,$errors,$resourcenodeidsarray, $resourcetypesarray, $resourceurlarray, $resourcetitlearray, $identifierarray, $themesarray, $newtags, "N");

					if(empty($errors)){

						// CONNECT EVIDENCE TO CLAIM
						$lt = getLinkTypeByLabel('supports');
						$linkRelated = $lt->linktypeid;
						$connection = addConnection($evidencenode->nodeid, $roleConnectionEvidence, $linkRelated, $claimnode->nodeid, $roleClaim, "N");

						// add themes
						connectThemesToNode($evidencenode, $themesarray,"N");

						// Add any new tags
						addTagsToNode($evidencenode, $newtags);


						echo "<script type='text/javascript'>";
						// For IE security message avoidance
						echo "var objWin = window.self;";
						echo "objWin.open('','_self','');";
						echo "objWin.close();";
						echo "</script>";
						include_once($HUB_FLM->getCodeDirPath("ui/dialogfooter.php"));
						die;
					}
				}
			} else {
  	           array_push($errors, $LNG->FORM_CLAIM_CREATE_ERROR_MESSAGE.": ".$claimnode->message);
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
// Resource and themes always start with one entry - so if the array is empty the count should still be 1
var noThemes = <?php if (is_countable($themesarray) && count($themesarray) > 0) { echo count($themesarray); } else { echo "1";}?>;
var noResources = <?php if (is_countable($resourcetypesarray) && count($resourcetypesarray) > 0) { echo count($resourcetypesarray); } else { echo "1";}?>;

function init() {
    $('dialogheader').insert('<?php echo $LNG->FORM_CLAIM_TITLE_ADD; ?>');
}

function checkThemeChange(num) {
	var selected = $('theme'+num+'menu').value;
	if (selected != "" && num == noThemes-1) {
		noThemes = addTheme(noThemes);
		$('theme'+noThemes+'menu').focus();
	}
}

function addSelectedNode(node) {
	$('typediv').style.display="none";
	$('typehiddendiv').style.display="block";
	$('nodetypelabel').value=node.role[0].role.name;
	$('evidence').value = node.name;
	$('evidence').disabled = true;
	$('evidencedescdiv').style.display="none";
	$('evidencenodeid').value = node.nodeid;
}

function removeSelectedNode() {
	$('typediv').style.display="block";
	$('typehiddendiv').style.display="none";
	$('nodetypelabel').value='<?php echo $CFG->EVIDENCE_TYPES_DEFAULT; ?>';
	$('evidencetype').value = '<?php echo $CFG->EVIDENCE_TYPES_DEFAULT; ?>';
	$('evidence').value = "";
	$('evidence').disabled = false;
	$('evidencedescdiv').style.display="block";
	$('evidencenodeid').value = "";
}

function openSelector() {
	loadDialog('selector', URL_ROOT+"ui/popups/selector.php?filternodetypes="+EVIDENCE_TYPES_STR, 420, 730);
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

function checkForm() {
	var checkname = ($('claim').value).trim();
	if (checkname == ""){
		alert("<?php echo $LNG->FORM_CLAIM_ENTER_SUMMARY_ERROR; ?>");
		return false;
	} else if ($('theme0menu').value == "") {
	   	alert("<?php echo $LNG->FORM_ERROR_THEME; ?>");
	   	return false;
    }

    $('claimform').style.cursor = 'wait';
	return true;
}

window.onload = init;

</script>

<?php insertFormHeaderMessage(); ?>

<form id="claimform" name="claimform" action="" enctype="multipart/form-data" method="post" onsubmit="return checkForm();">
	<input type="hidden" id="evidencenodeid" name="evidencenodeid" value="<?php echo $evidencenodeid; ?>" />

    <div class="hgrformrow">

		<label  class="formlabelbig" for="claim"><?php echo $LNG->FORM_CLAIM_LABEL_SUMMARY; ?>:
			<a href="javascript:void(0)" onMouseOver="showFormHint('ClaimSummary', event, 'hgrhint'); return false;" onMouseOut="hideHints(); return false;" onClick="hideHints(); return false;" onkeypress="enterKeyPressed(event)"><img src="<?php echo $HUB_FLM->getImagePath('info.png'); ?>" border="0" style="margin-top: 2px; margin-left: 5px; margin-right: 2px;" /></a>
			<span style="font-size:14pt;margin-top:3px;vertical-align:middle;color:red;">*</span>
		</label>
		<input class="forminputmust hgrinput hgrwide" id="claim" name="claim" value="<?php echo( $claim ); ?>" />
	</div>

	<?php insertDescriptionMulti($desc, 'desc', 'ClaimDesc'); ?>

	<div style="clear:both;"></div>
	<br>
	<hr class="hrline">

    <div class="hgrformrow">
		<span class="titles"><?php echo $LNG->FORM_CLAIM_REMOTE_MESSAGE_LINE1; ?></span><br>
    	<span><?php echo $LNG->FORM_CLAIM_REMOTE_MESSAGE_LINE2; ?>:<br>
			<?php echo $LNG->FORM_CLAIM_REMOTE_MESSAGE_LINE3; ?><br>
			<?php echo $LNG->FORM_CLAIM_REMOTE_MESSAGE_LINE4; ?>
		</span>
	</div>

   <div class="hgrformrow" id="typehiddendiv" style="display:none">
		<label  class="formlabelbig" for="nodetypelabel"><span style="vertical-align:top"><?php echo $LNG->FORM_LABEL_TYPE; ?></span>
		<span class="active" onMouseOver="showFormHint('RemoteEvidenceType', event, 'hgrhint', '<?php echo $CFG->EVIDENCE_TYPES_DEFAULT;?>'); return false;" onMouseOut="hideHints(); return false;" onClick="hideHints(); return false;" onkeypress="enterKeyPressed(event)"><img src="<?php echo $HUB_FLM->getImagePath('info.png'); ?>" border="0" style="margin-top: 2px; margin-left: 5px; margin-right: 2px;" /></span>
		<span style="font-size:14pt;margin-top:3px;vertical-align:middle;color:red;">*</span>
		</label>
		<select class="subforminput hgrselect forminputmust" disabled id="nodetypelabel" name="nodetypelabel">
			<?php
				foreach($CFG->EVIDENCE_TYPES as $item){?>
					<option value='<?php echo addslashes($item); ?>' <?php if ( $evidencetype == $item || ($evidencetype == "" && $item == $CFG->EVIDENCE_TYPES_DEFAULT)) { echo 'selected=\"true\"'; }  ?> ><?php echo $item ?></option>
			<?php } ?>
		</select>
	    <span class="active" onClick="javascript: removeSelectedNode()" class="form" style="margin-left: 15px;"><?php echo $LNG->FORM_BUTTON_REMOVE_CAP; ?></span>
	    <span class="active" onClick="javascript: openSelector()" class="form" style="margin-left: 10px;"><?php echo $LNG->FORM_BUTTON_SELECT_ANOTHER; ?></span>
   </div>

   <div class="hgrformrow" id="typediv">
		<label  class="formlabelbig" for="nodetypename"><span style="vertical-align:top"><?php echo $LNG->FORM_LABEL_TYPE; ?></span>
		<span class="active" onMouseOver="showFormHint('RemoteEvidenceType', event, 'hgrhint', '<?php echo $CFG->EVIDENCE_TYPES_DEFAULT;?>'); return false;" onMouseOut="hideHints(); return false;" onClick="hideHints(); return false;" onkeypress="enterKeyPressed(event)"><img src="<?php echo $HUB_FLM->getImagePath('info.png'); ?>" border="0" style="margin-top: 2px; margin-left: 5px; margin-right: 2px;" /></span>
		<span style="font-size:14pt;margin-top:3px;vertical-align:middle;color:red;">*</span>
		</label>
		<select class="subforminput hgrselect forminputmust" id="evidencetype" name="evidencetype">
			<?php
				foreach($CFG->EVIDENCE_TYPES as $item){?>
					<option value='<?php echo addslashes($item); ?>' <?php if ($evidencetype == $item || ($evidencetype == "" && $item == $CFG->EVIDENCE_TYPES_DEFAULT)) { echo 'selected=\"true\"'; }  ?> ><?php echo $item ?></option>
			<?php } ?>
		</select>
	    <span class="active" onClick="javascript: openSelector()" class="form" style="margin-left: 15px;"><?php echo $LNG->FORM_EVIDENCE_SELECT_EXISTING; ?></span>
   </div>

   	<div class="hgrformrow">
		<label  class="formlabelbig" for="claim"><?php echo $LNG->FORM_SUPPORTING_EVIDENCE_LABEL; ?>:
			<a href="javascript:void(0)" onMouseOver="showFormHint('RemoteEvidenceClaim', event, 'hgrhint'); return false;" onMouseOut="hideHints(); return false;" onClick="hideHints(); return false;" onkeypress="enterKeyPressed(event)"><img src="<?php echo $HUB_FLM->getImagePath('info.png'); ?>" border="0" style="margin-top: 2px; margin-left: 5px; margin-right: 2px;" /></a>
		</label>
		<input class="forminput hgrinput hgrwide" id="evidence" name="evidence" value="<?php echo( $evidence ); ?>" />
	</div>

	<?php insertDescriptionMulti($evidencedesc, 'evidencedesc', 'RemoteEvidenceDesc'); ?>

	<?php insertResourceForm('Resources');  ?>

	<hr class="hrline" style="clear: both;">

	<?php insertThemes('ClaimTheme'); ?>

	<?php insertAddTags('ClaimTag'); ?>

    <br>
    <div class="hgrformrow">
        <input class="submit" type="submit" value="<?php echo $LNG->FORM_BUTTON_PUBLISH; ?>" id="addclaim" name="addclaim">
        <input type="button" value="<?php echo $LNG->FORM_BUTTON_CANCEL; ?>" onclick="window.close();"/>
    </div>
</form>

<?php
    include_once($HUB_FLM->getCodeDirPath("ui/dialogfooter.php"));
?>