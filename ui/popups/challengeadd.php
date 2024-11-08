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

    if($USER == null || $USER->getIsAdmin() == "N"){
	    //reject user
	    echo $LNG->FORM_ERROR_NOT_ADMIN;
	    include_once($HUB_FLM->getCodeDirPath("ui/dialogfooter.php"));
	    die;
	} else {
		$challenge = optional_param("challenge","",PARAM_TEXT);
		$desc = optional_param("desc","",PARAM_HTML);

		$chatnodeid = optional_param("chatnodeid","",PARAM_HTML);
		$chatparentid = optional_param("chatparentid","",PARAM_HTML);

		$themesarray = optional_param("themesarray","",PARAM_TEXT);
	    $newtags = optional_param("newtags","",PARAM_TEXT);

		if( isset($_POST["addchallenge"]) ) {

			if ($challenge == ""){
				array_push($errors,$LNG->FORM_CHALLENGE_ENTER_SUMMARY_ERROR);
			}

			if (is_countable($themesarray) && count($themesarray) <= 0){
				array_push($errors,$LNG->$LNG->FORM_ERROR_THEME);
			}

			if(empty($errors)){

				// GET ROLES AND LINKS AS USER
				$r = getRoleByName("Challenge");
				$roleChallenge = $r->roleid;

				// CREATE THE CHALLENGE NODE
				$challengenode = addNode($challenge,$desc, 'N', $roleChallenge);
				if (!$challengenode instanceof Hub_Error) {

					if ($CFG->autoFollowingOn) {
						addFollowing($challengenode->nodeid);
					}

					// Add any new tags
					addTagsToNode($challengenode, $newtags);

					if (isset($themesarray) && $themesarray != "") {
						connectThemesToNode($challengenode, $themesarray, "N");
					}

					// connect built from to the chat comment node this was created from if chatnodeid exists
					if ($chatnodeid != "") {
						connectBuiltFromChatNode($challengenode, $chatnodeid, $chatparentid);
					}
				}

				echo '<script type=\'text/javascript\'>';
				echo 'if (window.opener && window.opener.loadSelecteditemNew) {';
				echo '	  window.opener.loadSelecteditemNew("'.$challengenode->nodeid.'","'.$challengenode->name.'"); }';
				echo 'else {';
				echo '	  window.opener.location.href = "'.$CFG->homeAddress.'explore.php?id='.$challengenode->nodeid.'"; }';
				echo 'window.close();';
				echo '</script>';
				include_once($HUB_FLM->getCodeDirPath("ui/dialogfooter.php"));
				die;
			}
		} else {
			if ($chatnodeid != "") {
				$newtags = getTagString($chatnodeid);
			}
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
   	$('dialogheader').insert('<?php echo $LNG->FORM_TITLE_CHALLENGE_ADD; ?>');
}

function checkThemeChange(num) {
	var selected = $('theme'+num+'menu').value;
	if (selected != "" && num == noThemes-1) {
		noThemes = addTheme(noThemes);
		$('theme'+noThemes+'menu').focus();
	}
}

function checkForm() {
	var checkname = ($('challenge').value).trim();
	if (checkname == ""){
	   alert("<?php echo $LNG->FORM_CHALLENGE_ENTER_SUMMARY_ERROR; ?>");
	   return false;
    } else if ($('theme0menu').value == "") {
	   alert("<?php echo $LNG->FORM_ERROR_THEME; ?>");
	   return false;
    }

    $('challengeform').style.cursor = 'wait';

	return true;
}

window.onload = init;

</script>

<div class="container-fluid popups">
	<div class="row p-4 justify-content-center">	
		<div class="col">
			<div class="alert alert-info"><?php echo $LNG->FORM_MESSAGE_CHALLENGE; ?></div>
			<?php insertFormHeaderMessage(); ?>

			<form id="challengeform" name="challengeform" action="" enctype="multipart/form-data" method="post" onsubmit="return checkForm();">
				<input type="hidden" id="chatnodeid" name="chatnodeid" value="<?php echo $chatnodeid; ?>" />
				<input type="hidden" id="chatparentid" name="chatparentid" value="<?php echo $chatparentid; ?>" />

				<div class="mb-3 row">
					<label for="challenge" class="col-sm-3 col-form-label">
						<?php echo $LNG->FORM_LABEL_CHALLENGE_SUMMARY; ?> 
						<a class="active" onMouseOver="showFormHint('ChallengeSummary', event, 'hgrhint'); return false;" onMouseOut="hideHints(); return false;" onClick="hideHints(); return false;" onkeypress="enterKeyPressed(event)">
							<i class="far fa-question-circle fa-lg me-2" aria-hidden="true" ></i> 
							<span class="sr-only">More info</span>
						</a>
						<span class="required">*</span>
					</label>
					<div class="col-sm-9">
						<input type="text" class="form-control" id="challenge" name="challenge" value="<?php print $challenge; ?>" />
					</div>
				</div>

				<?php insertDescription('ChallengeDesc'); ?>
				<?php insertThemes('ChallengeTheme'); ?>
				<?php insertAddTags('ChallengeTag'); ?>

				<div class="mb-3 row">
					<div class="d-grid gap-2 d-md-flex justify-content-md-center mb-3">
						<input class="btn btn-secondary" type="button" value="<?php echo $LNG->FORM_BUTTON_CANCEL; ?>" onclick="window.close();"/>
						<input class="btn btn-primary" type="submit" value="<?php echo $LNG->FORM_BUTTON_PUBLISH; ?>" id="addchallenge" name="addchallenge" />
					</div>
				</div>
			</form>
		</div>
	</div>
</div>

<?php
    include_once($HUB_FLM->getCodeDirPath("ui/dialogfooter.php"));
?>