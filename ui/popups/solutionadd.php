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
 *  are dissolutioned. In no event shall the copyright owner or contributors be    *
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

	$solution = optional_param("solution","",PARAM_TEXT);
	$desc = optional_param("desc","",PARAM_HTML);

	$themesarray = optional_param("themesarray","",PARAM_TEXT);

    $newtags = optional_param("newtags","",PARAM_TEXT);

	$chatnodeid = optional_param("chatnodeid","",PARAM_HTML);
	$chatparentid = optional_param("chatparentid","",PARAM_HTML);

    if( isset($_POST["addsolution"]) ) {

        if ($solution == ""){
            array_push($errors, $LNG->FORM_SOLUTION_ENTER_SUMMARY_ERROR);
        }

        if (is_countable($themesarray) && count($themesarray) <= 0){
            array_push($errors, $LNG->FORM_ERROR_THEME);
        }

        if(empty($errors)){

			// GET ROLES AND LINKS FOR USER
			$r = getRoleByName("Solution");
			$roleSolution = $r->roleid;

			// CREATE THE solution NODE
			$solutionnode = addNode($solution,$desc, 'N', $roleSolution);
			if (!$solutionnode instanceof Hub_Error) {
				if ($CFG->autoFollowingOn) {
					addFollowing($solutionnode->nodeid);
				}

				// Add any new tags
				addTagsToNode($solutionnode, $newtags);

				// add themes
				if (isset($themesarray) && $themesarray != "") {
					connectThemesToNode($solutionnode, $themesarray, "N");
				}

				// connect built from to the chat comment node this was created from if chatnodeid exists
				if ($chatnodeid != "") {
					connectBuiltFromChatNode($solutionnode, $chatnodeid, $chatparentid, "N");
				}

				echo "<script type='text/javascript'>";
				echo "try { ";
					echo "var parent=window.opener.document; ";
					echo "if (window.opener && window.opener.loadSelecteditemNew) {";
					echo "	  window.opener.loadSelecteditemNew('".$solutionnode->nodeid."','".$solutionnode->name."'); }";
					echo 'else {';
					echo '	  window.opener.location.href = "'.$CFG->homeAddress.'explore.php?id='.$solutionnode->nodeid.'"; }';
				echo "}";
				echo "catch(err) {";
					//CALLED FROM BOOKMARKET FROM A DIFFERNT DOMAIN
					//message about successfully saving?
					//echo "window.close();";
				echo "}";
				echo "window.close();";
				echo "</script>";
				include_once($HUB_FLM->getCodeDirPath("ui/dialogfooter.php"));
				die;
			} else {
  	           array_push($errors, $LNG->FORM_SOLUTION_CREATE_ERROR_MESSAGE.": ".$solutionnode->message);
			}
		}
    } else {
		if ($chatnodeid != "") {
			$newtags = getTagString($chatnodeid);
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
    $('dialogheader').insert('<?php echo $LNG->FORM_SOLUTION_TITLE_ADD; ?>');
}

function checkThemeChange(num) {
	var selected = $('theme'+num+'menu').value;
	if (selected != "" && num == noThemes-1) {
		noThemes = addTheme(noThemes);
		$('theme'+noThemes+'menu').focus();
	}
}

function checkForm() {
	var checkname = ($('solution').value).trim();
	if (checkname == ""){
		alert("<?php echo $LNG->FORM_SOLUTION_ENTER_SUMMARY_ERROR; ?>");
		return false;
	} else if ($('theme0menu').value == "") {
	   	alert("<?php echo $LNG->FORM_ERROR_THEME; ?>");
	   	return false;
    }

    $('solutionform').style.cursor = 'wait';
	return true;
}

window.onload = init;

</script>

<div class="container-fluid popups">
	<div class="row p-4 justify-content-center">	
		<div class="col">
			<?php insertFormHeaderMessage(); ?>

			<form id="solutionform" name="solutionform" action="" enctype="multipart/form-data" method="post" onsubmit="return checkForm();">
				<input type="hidden" id="chatnodeid" name="chatnodeid" value="<?php echo $chatnodeid; ?>" />
				<input type="hidden" id="chatparentid" name="chatparentid" value="<?php echo $chatparentid; ?>" />

				<div class="mb-3 row">
					<label for="solution" class="col-sm-3 col-form-label">
						<?php echo $LNG->FORM_SOLUTION_LABEL_SUMMARY; ?>
						<a class="active" onMouseOver="showFormHint('SolutionSummary', event, 'hgrhint'); return false;" onMouseOut="hideHints(); return false;" onClick="hideHints(); return false;" onkeypress="enterKeyPressed(event)">
							<i class="far fa-question-circle fa-lg me-2" aria-hidden="true" ></i> 
							<span class="sr-only">More info</span>
						</a>
						<span class="required">*</span>
					</label>
					<div class="col-sm-9">
						<input type="text" class="form-control" id="solution" name="solution" value="<?php print $solution; ?>" />
					</div>
				</div>

				<?php insertDescription('SolutionDesc'); ?>
				<?php insertThemes('SolutionTheme'); ?>
				<?php insertAddTags('SolutionTag'); ?>

				<div class="mb-3 row">
					<div class="d-grid gap-2 d-md-flex justify-content-md-center mb-3">
						<input class="btn btn-secondary" type="button" value="<?php echo $LNG->FORM_BUTTON_CANCEL; ?>" onclick="window.close();"/>
						<input class="btn btn-primary" type="submit" value="<?php echo $LNG->FORM_BUTTON_PUBLISH; ?>" id="addsolution" name="addsolution" />
					</div>
				</div>
			</form>
		</div>
	</div>
</div>

<?php
    include_once($HUB_FLM->getCodeDirPath("ui/dialogfooter.php"));
?>