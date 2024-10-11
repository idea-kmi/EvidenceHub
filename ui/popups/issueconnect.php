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

	$filternodetypes = required_param("filternodetypes",PARAM_TEXT);
	$focalnodeid = required_param("focalnodeid",PARAM_TEXT);
	$focalnodeend = required_param("focalnodeend",PARAM_TEXT);
	$linktypename = required_param("linktypename",PARAM_TEXT);

	$focalnode = getNode($focalnodeid);

	$issue = optional_param("issue","",PARAM_TEXT);
	$nodeid = optional_param("nodeid","",PARAM_TEXT);
	//$conndesc = optional_param("conndesc", "", PARAM_TEXT);
	$conndesc = "";
	$desc = optional_param("desc","",PARAM_HTML);

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

	$challenges = optional_param("challenges","",PARAM_TEXT);

	$handler = optional_param("handler","",PARAM_TEXT);
    $newtags = optional_param("newtags","",PARAM_TEXT);

    if( isset($_POST["addissue"]) ) {

        if ($issue == "" && $nodeid == ""){
            array_push($errors,$LNG->FORM_ISSUE_ENTER_SUMMARY_ERROR);
        }

        if (is_countable($themesarray) && count($themesarray) <= 0 && $nodeid == ""){
            array_push($errors,$LNG->FORM_ERROR_THEME);
        }

        if(empty($errors)){

			// GET ROLES AND LINKS AS USER
			$r = getRoleByName("Issue");
			$roleIssue = $r->roleid;

			// CREATE THE ISSUE NODE IF NEW
			if ($nodeid == "") {
				$issuenode = addNode($issue,$desc, 'N', $roleIssue);
				if (!$issuenode instanceof Hub_Error) {
					if ($CFG->autoFollowingOn) {
						addFollowing($issuenode->nodeid);
					}

					$nodeid = $issuenode->nodeid;

					// Add any new tags
					addTagsToNode($issuenode, $newtags);

					if ($CFG->HAS_CHALLENGE && $challenges && $challenges != ""){
						$r = getRoleByName("Challenge");
						$roleChallenge = $r->roleid;
						$lt = getLinkTypeByLabel('is related to');
						$linkChallenge = $lt->linktypeid;

						foreach($challenges as $challenge){
							addConnection($nodeid, $roleIssue, $linkChallenge, $challenge, $roleChallenge, "N");
						}
					}

					// Add any themes
					connectThemesToNode($issuenode,$themesarray,"N");
				}
			}

			// CONNECT NODE TO FOCAL
			$r = getRoleByName($focalnode->role->name);
			$focalroleid = $r->roleid;

			$lt = getLinkTypeByLabel($linktypename);
			if (!$lt instanceof HubError) {
				$linkType = $lt->linktypeid;

				if ($focalnodeend == "from") {
					$connection = addConnection($focalnodeid, $focalroleid, $linkType, $nodeid, $roleIssue, "N", $conndesc);
				} else {
					$connection = addConnection($nodeid, $roleIssue, $linkType, $focalnodeid, $focalroleid, "N", $conndesc);
				}
			} else {
				array_push($errors,"Link Type not found: ".$linktypename);
			}

			echo "<script type='text/javascript'>";

			// decision just to send them to the explore page for the other end of the connection
			// echo 'window.opener.location.href = "'.$CFG->homeAddress.'explore.php?id='.$nodeid.'";';

			if (isset($handler) && $handler != "") {
				echo "window.opener.".$handler."('".$nodeid."');";
			} else {
				echo "if (window.opener && window.opener.refreshWidgetIssues) {";
				echo "	  window.opener.refreshWidgetIssues('".$nodeid."'); }";
				echo "else if (window.opener && window.opener.refreshIssues) {";
				echo "	  window.opener.refreshIssues(); }";
				echo "else {";
				echo "	  window.opener.location.reload(true); }";
			}

			echo "window.close();";
			echo "</script>";
			include_once($HUB_FLM->getCodeDirPath("ui/dialogfooter.php"));
			die;
		}
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
// Themes always start with one entry - so if the array is empty the count should still be 1
var noThemes = <?php if (is_countable($themesarray) && count($themesarray) > 0) { echo count($themesarray); } else { echo "1";}?>;

function init() {
    $('dialogheader').insert('<?php echo $LNG->FORM_ISSUE_TITLE_CONNECT; ?><br><span style="font-size: 80%">"<?php echo addslashes( $focalnode->name ); ?>"</span>');
}

function addSelectedNode(node) {
	$('issuediv').style.display="none";
	$('issuelabeldiv').style.display="block";
	$('issuelabel').value = node.name;
	$('nodeid').value = node.nodeid;
	$('themediv').style.display="none";
	$('descdiv').style.display="none";
	$('tagsdiv').style.display="none";
	if ($('challengediv')) {
		$('challengediv').style.display="none";
	}
}

function removeSelectedNode() {
	$('issuediv').style.display="block";
	$('issuelabeldiv').style.display="none";
	$('issuelabel').value="";
	$('nodeid').value = "";
	$('themediv').style.display="block";
	$('descdiv').style.display="block";
	$('tagsdiv').style.display="block";
	if ($('challengediv')) {
		$('challengediv').style.display="block";
	}
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
	var checkname = ($('issue').value).trim();
	if (checkname == "" && $('nodeid').value == ""){
	   alert("<?php echo $LNG->FORM_ISSUE_ENTER_SUMMARY_ERROR; ?>");
	   $('issue').focus();
	   return false;
    }
	if ($('theme0menu').value == "" && $('nodeid').value == "") {
	   alert("<?php echo $LNG->FORM_ERROR_THEME; ?>");
	   $('theme0menu').focus();
	   return false;
    }

    $('issueform').style.cursor = 'wait';

	return true;
}

window.onload = init;

</script>

<div class="container-fluid popups">
	<div class="row p-4 justify-content-center">	
		<div class="col">
			<div class="alert alert-info">Add a question you are investigating or a issue you think the community has to tackle.</div>
			<?php insertFormHeaderMessage(); ?>

			<form id="issueform" name="issueform" action="" enctype="multipart/form-data" method="post" onsubmit="return checkForm();">
				<input type="hidden" id="focalnodeid" name="focalnodeid" value="<?php echo $focalnodeid; ?>" />
				<input type="hidden" id="focalnodeend" name="focalnodeend" value="<?php echo $focalnodeend; ?>" />
				<input type="hidden" id="filternodetypes" name="filternodetypes" value="<?php echo $filternodetypes; ?>" />
				<input type="hidden" id="linktypename" name="linktypename" value="<?php echo $linktypename; ?>" />
				<input type="hidden" id="handler" name="handler" value="<?php echo $handler; ?>" />
				<input type="hidden" id="nodeid" name="nodeid" value="<?php echo $nodeid; ?>" />
				<input type="hidden" id="theme" name="theme" value="<?php echo $theme; ?>" />
	
				<div class="mb-3 row" id="issuelabeldiv" style="display: none;">
					<label for="issuelabel" class="col-sm-3 col-form-label">
						<?php echo $LNG->FORM_ISSUE_LABEL_SUMMARY; ?> 
						<a class="active" onMouseOver="showFormHint('IssueSummary', event, 'hgrhint'); return false;" onMouseOut="hideHints(); return false;" onClick="hideHints(); return false;" onkeypress="enterKeyPressed(event)">
							<i class="far fa-question-circle fa-lg me-2" aria-hidden="true" ></i> 
							<span class="sr-only">More info</span>
						</a>
						<span class="required">*</span>
					</label>	
					<div class="col-sm-6">
						<input class="form-control" readonly id="issuelabel" name="issuelabel" value="" />
					</div>
					<div class="col-sm-3 pt-2">		
						<span class="active" onClick="javascript: removeSelectedNode()" class="form" style="margin-left: 5px;"><?php echo $LNG->FORM_BUTTON_REMOVE_CAP; ?></span>
						<span class="active" onClick="javascript: openSelector()" class="form" style="margin-left: 10px;"><?php echo $LNG->FORM_BUTTON_SELECT_ANOTHER; ?></span>	
					</div>
				</div>
				
				<div class="mb-3 row" id="issuediv">
					<label for="issue" class="col-sm-3 col-form-label">
						<?php echo $LNG->FORM_ISSUE_LABEL_SUMMARY; ?> 
						<a class="active" onMouseOver="showFormHint('IssueSummary', event, 'hgrhint'); return false;" onMouseOut="hideHints(); return false;" onClick="hideHints(); return false;" onkeypress="enterKeyPressed(event)">
							<i class="far fa-question-circle fa-lg me-2" aria-hidden="true" ></i> 
							<span class="sr-only">More info</span>
						</a>
						<span class="required">*</span>
					</label>	
					<div class="col-sm-6">
						<input class="form-control" id="issue" name="issue" value="<?php echo( $issue ); ?>" />	
					</div>
					<?php if ($focalnodeid != "") { ?>	
						<div class="col-sm-3 pt-2">	
							<span class="active" onClick="javascript: openSelector()" class="form" style="margin-left: 5px;"><?php echo $LNG->FORM_ISSUE_SELECT_EXISTING; ?></span>	
						</div>
					<?php }; ?>
				</div>	

				<?php insertDescription('IssueDesc'); ?>
				<?php insertThemes('IssueTheme', $theme); ?>
				<?php insertAddTags('IssueTag'); ?>
				<?php if ($CFG->HAS_CHALLENGE) { insertChallenges('IssueChallenges', true); } ?>
				<?php if ($theme == "") { insertReason('IssueReason'); } ?>
				
				<div class="mb-3 row">
					<div class="d-grid gap-2 d-md-flex justify-content-md-center mb-3">
						<input class="btn btn-secondary" type="button" value="<?php echo $LNG->FORM_BUTTON_CANCEL; ?>" onclick="window.close();"/>
						<input class="btn btn-primary" type="submit" value="<?php echo $LNG->FORM_BUTTON_PUBLISH; ?>" id="addissue" name="addissue" />
					</div>
				</div>
			</form>
		</div>
	</div>
</div>

<?php
    include_once($HUB_FLM->getCodeDirPath("ui/dialogfooter.php"));
?>