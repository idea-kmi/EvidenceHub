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
	include_once($HUB_FLM->getCodeDirPath("ui/popuplib.php"));

    $errors = array();

	$issue = optional_param("issue","",PARAM_TEXT);
	$desc = optional_param("desc","",PARAM_HTML);

	$themesarray = optional_param("themesarray","",PARAM_TEXT);
    $challenges = optional_param("challenges","",PARAM_TEXT);

    $resourcetypesarray = optional_param("resourcetypesarray","",PARAM_TEXT);
    $resourcetitlearray = optional_param("resourcetitlearray","",PARAM_TEXT);
    $resourceurlarray = optional_param("resourceurlarray","",PARAM_URL);
    $identifierarray = optional_param("identifierarray","",PARAM_TEXT);
    $resourcenodeidsarray = optional_param("resourcenodeidsarray","",PARAM_TEXT);
    $resourcecliparray = optional_param("resourcecliparray","",PARAM_TEXT);
    $resourceclippatharray = optional_param("resourceclippatharray","",PARAM_TEXT);

    $newtags = optional_param("newtags","",PARAM_TEXT);

    if( isset($_POST["addissue"]) ) {

        if ($issue == ""){
            array_push($errors,$LNG->FORM_ISSUE_ENTER_SUMMARY_ERROR);
        }

        if (is_countable($themesarray) && count($themesarray) <= 0){
            array_push($errors, $LNG->FORM_ERROR_THEME);
        }

        if(empty($errors)){

			// GET ROLES AND LINKS AS USER
			$r = getRoleByName("Issue");
			$roleIssue = $r->roleid;

			// CREATE THE ISSUE NODE
			$issuenode = addNode($issue, $desc, 'N', $roleIssue);

			if (!$issuenode instanceof Hub_Error) {
				if ($CFG->autoFollowingOn) {
					addFollowing($issuenode->nodeid);
				}

				// Add any new tags
				addTagsToNode($issuenode, $newtags);

				if ($CFG->HAS_CHALLENGE && $challenges && $challenges != ""){
					$r = getRoleByName("Challenge");
					$roleChallenge = $r->roleid;
					$lt = getLinkTypeByLabel('is related to');
					$linkChallenge = $lt->linktypeid;

					foreach($challenges as $challenge){
						addConnection($issuenode->nodeid, $roleIssue, $linkChallenge, $challenge, $roleChallenge, "N");
					}
				}

				// Add any themes
				connectThemesToNode($issuenode,$themesarray,"N");

				/** ADD RESOURCES **/
				if(empty($errors)){
					$errors = addResourcesToNode($issuenode,$errors,$resourcenodeidsarray, $resourcetypesarray, $resourceurlarray, $resourcetitlearray, $identifierarray, $themesarray, $newtags, "N");
				}

				if(empty($errors)){
					echo '<script type=\'text/javascript\'>';
					// For IE security message avoidance
					echo "var objWin = window.self;";
					echo "objWin.open('','_self','');";
					echo "objWin.close();";
					echo '</script>';
					include_once($HUB_FLM->getCodeDirPath("ui/dialogfooter.php"));
					die;
				}
 			} else {
  	           array_push($errors,$LNG->FORM_ISSUE_CREATE_ERROR_MESSAGE." ".$issuenode->message);
			}
		}
    }


    $challengeset = getNodesByGlobal(0, -1 ,'name', 'ASC', "Challenge", "", 'short',"",'all');
	$challanges = $challengeset->nodes;

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
   	$('dialogheader').insert('<?php echo $LNG->FORM_ISSUE_TITLE_ADD; ?>');
}

function checkThemeChange(num) {
	var selected = $('theme'+num+'menu').value;
	if (selected != "" && num == noThemes-1) {
		noThemes = addTheme(noThemes);
		$('theme'+noThemes+'menu').focus();
	}
}

function openSelector(num) {
	loadDialog('selector', URL_ROOT+"ui/popups/selector.php?num="+num+"&filternodetypes="+RESOURCE_TYPES_STR, 420, 730);
}

function addSelectedNode(node, num) {
	$('resource'+num+'label').value=node.role[0].role.name;

	$('resourcetitle-'+num).value = node.name;
	$('resourcenodeidsarray-'+num).value = node.nodeid;

	if ($('identifierdiv-'+num)) {
		$('identifierdiv-'+num).style.display="none";
	}

	$('typehiddendiv-'+num).style.display="block";
	$('typediv-'+num).style.display="none";
	$('resourceurldiv-'+num).style.display="none";
	$('resourcedescdiv-'+num).style.display="none";
}

function removeSelectedNode() {
	$('resource'+num+'menu').value='<?php echo $CFG->RESOURCE_TYPES_DEFAULT; ?>';
	$('resourcetitle-'+num).value = "";
	$('resourcedesc-'+num).value = "";
	$('resourcenodeidsarray-'+num).value = "";

	$('typehiddendiv-'+num).style.display="none";
	$('typediv-'+num).style.display="block";
	$('resourceurldiv-'+num).style.display="block";
	$('resourcedescdiv-'+num).style.display="block";
}

function checkForm() {
	var checkname = ($('issue').value).trim();
	if (checkname == ""){
	   alert("<?php echo $LNG->FORM_ISSUE_ENTER_SUMMARY_ERROR; ?>");
	   return false;
    }
    if ($('theme0menu').value == "") {
	   alert("<?php echo $LNG->FORM_ERROR_THEME; ?>");
	   return false;
    }

    $('issueform').style.cursor = 'wait';

	return true;
}

window.onload = init;

</script>

<div class="toolbarrow" style="color:#27318B; font-size: 10pt; font-weight:bold; margin-bottom: 10px;"><?php echo $LNG->FORM_ISSUE_HEADING_MESSAGE; ?></div>

<?php insertFormHeaderMessage(); ?>

<form id="issueform" name="issueform" action="" enctype="multipart/form-data" method="post" onsubmit="return checkForm();">
	<input type="hidden" id="nodeid" name="nodeid" value="<?php echo $nodeid; ?>" />

    <div class="hgrformrow">
		<label  class="formlabelbig" for="url"><?php echo $LNG->FORM_ISSUE_LABEL_SUMMARY; ?>
			<a href="javascript:void(0)" onMouseOver="showFormHint('IssueSummary', event, 'hgrhint'); return false;" onMouseOut="hideHints(); return false;" onClick="hideHints(); return false;" onkeypress="enterKeyPressed(event)"><img src="<?php echo $HUB_FLM->getImagePath('info.png'); ?>" border="0" style="margin-top: 2px; margin-left: 5px; margin-right: 2px;" /></a>
			<span style="font-size:14pt;margin-top:3px;vertical-align:middle;color:red;">*</span>
		</label>
		<input class="forminputmust hgrinput hgrwide" id="issue" name="issue" value="<?php echo( $issue ); ?>" />
	</div>

	<?php insertDescription('IssueDesc'); ?>

	<?php insertResourceForm('IssueResource'); ?>

	<?php insertThemes('IssueTheme'); ?>

	<?php insertAddTags('IssueTag'); ?>

	<?php if ($CFG->HAS_CHALLENGE) { insertChallenges('IssueChallenges', false); } ?>

    <br>
    <div class="hgrformrow">
        <input class="submit" type="submit" value="<?php echo $LNG->FORM_BUTTON_PUBLISH; ?>" id="addissue" name="addissue">
        <input type="button" value="<?php echo $LNG->FORM_BUTTON_CANCEL; ?>" onclick="window.close();"/>
    </div>
</form>

<?php
    include_once($HUB_FLM->getCodeDirPath("ui/dialogfooter.php"));
?>