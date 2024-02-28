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

	$from = optional_param("from","list",PARAM_TEXT);

	$issue = optional_param("issue","",PARAM_TEXT);
	$desc = optional_param("desc","",PARAM_HTML);

	$themesarray = optional_param("themesarray","",PARAM_TEXT);
    $challenges = optional_param("challenges","",PARAM_TEXT);

    $newtags = optional_param("newtags","",PARAM_TEXT);

    $chatnodeid = optional_param("chatnodeid","",PARAM_HTML);
	$chatparentid = optional_param("chatparentid","",PARAM_HTML);

    if( isset($_POST["addissue"]) ) {

        if ($issue == ""){
            array_push($errors, $LNG->FORM_ISSUE_ENTER_SUMMARY_ERROR);
        }

        if (is_countable($themesarray) && count($themesarray) <= 0){
            array_push($errors,$LNG->FORM_ERROR_THEME);
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

				//error_log(print_r($issuenode, true));

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

				if (isset($themesarray) && $themesarray != "") {
					connectThemesToNode($issuenode, $themesarray, "N");
				}

				// connect built from to the chat comment node this was created from if chatnodeid exists
				if ($chatnodeid != "") {
					connectBuiltFromChatNode($issuenode, $chatnodeid, $chatparentid, "N");
				}

				echo '<script type=\'text/javascript\'>';
				echo "try { ";
					echo "var parent=window.opener.document; ";
					echo 'if (window.opener && window.opener.loadSelecteditemNew) {';
					echo '	  window.opener.loadSelecteditemNew("'.$issuenode->nodeid.'","'.$issuenode->name.'"); }';
					echo 'else {';

					if ($from == "home") {
						echo '	  window.opener.location.href = "'.$CFG->homeAddress.'"; }';
					} else {
						echo '	  window.opener.location.href = "'.$CFG->homeAddress.'explore.php?id='.$issuenode->nodeid.'"; }';
					}

					//echo 'else if (window.opener && window.opener.refreshIssues) {';
					//echo '  window.opener.refreshIssues(); }';
				echo "}";
				echo "catch(err) {";
					//CALLED FROM BOOKMARKET FROM A DIFFERNT DOMAIN
					//message about successfully saving?
					//echo "window.close();";
				echo "}";
				echo "window.close();";
				echo '</script>';
				include_once($HUB_FLM->getCodeDirPath("ui/dialogfooter.php"));
				die;
 			} else {
  	           array_push($errors, $LNG->FORM_ISSUE_CREATE_ERROR_MESSAGE." ".$issuenode->message);
			}
		}
    } else {
		if ($chatnodeid != "") {
			$newtags = getTagString($chatnodeid);
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
   	$('dialogheader').insert('<?php echo $LNG->FORM_ISSUE_TITLE_ADD; ?>');
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

<div class="container-fluid popups">
	<div class="row p-4 justify-content-center">	
		<div class="col">
			<div class="alert alert-info"><?php echo $LNG->FORM_ISSUE_HEADING_MESSAGE; ?></div>
			<?php insertFormHeaderMessage(); ?>

			<form id="issueform" name="issueform" action="" enctype="multipart/form-data" method="post" onsubmit="return checkForm();">
				<input type="hidden" id="chatnodeid" name="chatnodeid" value="<?php echo $chatnodeid; ?>" />
				<input type="hidden" id="chatparentid" name="chatparentid" value="<?php echo $chatparentid; ?>" />
				<input type="hidden" id="from" name="from" value="<?php echo $from; ?>" />

				<div class="mb-3 row">
					<label for="issue" class="col-sm-3 col-form-label">
						<?php echo $LNG->FORM_ISSUE_LABEL_SUMMARY; ?> 
						<a class="active" onMouseOver="showFormHint('IssueSummary', event, 'hgrhint'); return false;" onMouseOut="hideHints(); return false;" onClick="hideHints(); return false;" onkeypress="enterKeyPressed(event)">
							<i class="far fa-question-circle fa-lg me-2" aria-hidden="true" ></i> 
							<span class="sr-only">More info</span>
						</a>
						<span class="required">*</span>
					</label>
					<div class="col-sm-9">
						<input type="text" class="form-control" id="issue" name="issue" value="<?php print $issue; ?>" />
					</div>
				</div>

				<?php insertDescription('IssueDesc'); ?>
				<?php insertThemes('IssueTheme'); ?>
				<?php insertAddTags('IssueTag'); ?>
				<?php if ($CFG->HAS_CHALLENGE) { insertChallenges('IssueChallenges', false); } ?>

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