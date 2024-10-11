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

	$isRemote = optional_param("isremote", false,PARAM_BOOL);

	$summary = optional_param("summary","",PARAM_TEXT);
	$desc = optional_param("desc","",PARAM_HTML);

    $resourcetypesarray = optional_param("resourcetypesarray","",PARAM_TEXT);
    $resourcetitlearray = optional_param("resourcetitlearray","",PARAM_TEXT);
    $resourceurlarray = optional_param("resourceurlarray","",PARAM_URL);
    $identifierarray = optional_param("identifierarray","",PARAM_TEXT);
    $resourcenodeidsarray = optional_param("resourcenodeidsarray","",PARAM_TEXT);
    $resourcecliparray = optional_param("resourcecliparray","",PARAM_TEXT);
    $resourceclippatharray = optional_param("resourceclippatharray","",PARAM_TEXT);

	$nodetypename = optional_param("nodetypename","",PARAM_TEXT);
	$themesarray = optional_param("themesarray","",PARAM_TEXT);

    $newtags = optional_param("newtags","",PARAM_TEXT);

    $chatnodeid = optional_param("chatnodeid","",PARAM_HTML);
	$chatparentid = optional_param("chatparentid","",PARAM_HTML);

    if( isset($_POST["addevidence"]) ) {

        if ($summary == ""){
            array_push($errors, $LNG->FORM_EVIDENCE_ENTER_SUMMARY_ERROR);
        }

        if (is_countable($themesarray) && count($themesarray) <= 0){
            array_push($errors, $LNG->FORM_ERROR_THEME);
        }

 		if(empty($errors)){
			$r = getRoleByName($nodetypename);
			$roleType = $r->roleid;

			$lt = getLinkTypeByLabel('is related to');
			$linkRelated = $lt->linktypeid;

			$desc = stripslashes(trim($desc));

			$evidencenode = addNode($summary, $desc, 'N', $roleType);
			if (!$evidencenode instanceof Hub_Error) {
				if ($CFG->autoFollowingOn) {
					addFollowing($evidencenode->nodeid);
				}

				// Add any new tags
				addTagsToNode($evidencenode, $newtags);

				if (isset($themesarray) && $themesarray != "") {
					connectThemesToNode($evidencenode, $themesarray, "N");
				}

				// connect built from to the chat comment node this was created from if chatnodeid exists
				if ($chatnodeid != "") {
					connectBuiltFromChatNode($evidencenode, $chatnodeid, $chatparentid, "N");
				}

				/** ADD RESOURCES **/
				$errors = addResourcesToNode($evidencenode, $errors, $resourcenodeidsarray, $resourcetypesarray, $resourceurlarray, $resourcetitlearray, $identifierarray, $themesarray, $newtags, "N");
			}

        	if(empty($errors)){
				echo "<script type='text/javascript'>";
				if ($isRemote === false) {
					echo "try { ";
						echo "var parent=window.opener.document; ";
						echo "if (window.opener && window.opener.loadSelecteditemNew) {";
						echo "	  window.opener.loadSelecteditemNew('".$evidencenode->nodeid."','".$evidencenode->name."'); }";
						echo 'else {';
						echo '	  window.opener.location.href = "'.$CFG->homeAddress.'explore.php?id='.$evidencenode->nodeid.'"; }';
					echo "window.close();";
					echo "}";
					echo "catch(err) {";
						//CALLED FROM BOOKMARKET FROM A DIFFERNT DOMAIN
						//alert("Thank you for entering an Evidence item into the Evidence Hub");
						//echo "window.close();";

						// For IE security message avoidance
						echo "var objWin = window.self;";
						echo "objWin.open('','_self','');";
						echo "objWin.close();";
					echo "}";
				} else {
					// For IE security message avoidance
					echo "var objWin = window.self;";
					echo "objWin.open('','_self','');";
					echo "objWin.close();";
				}
				echo "</script>";
				include_once($HUB_FLM->getCodeDirPath("ui/dialogfooter.php"));
				die;
			}
		}
    } else {
    	$resourceids[0] = "";

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
// Resource and themes always start with one entry - so if the array is empty the count should still be 1
var noThemes = <?php if (is_countable($themesarray) && count($themesarray) > 0) { echo count($themesarray); } else { echo "1";}?>;
var noResources = <?php if (is_countable($resourcetypesarray) && count($resourcetypesarray) > 0) { echo count($resourcetypesarray); } else { echo "1";}?>;

function init() {
    $('dialogheader').insert('<?php echo $LNG->FORM_EVIDENCE_TITLE_ADD; ?>');
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

function checkThemeChange(num) {
	var selected = $('theme'+num+'menu').value;
	if (selected != "" && num == noThemes-1) {
		noThemes = addTheme(noThemes);
		$('theme'+noThemes+'menu').focus();
	}
}

function checkForm() {
	var checkname = ($('summary').value).trim();
	if (checkname == ""){
	   alert("<?php echo $LNG->FORM_EVIDENCE_ENTER_SUMMARY_ERROR; ?>");
	   return false;
    }
    if ($('theme0menu').value == "") {
	   alert("<?php echo $LNG->FORM_ERROR_THEME; ?>");
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
			<div class="alert alert-info">Add a contribution which can then serve as Evidence to support/counter Solutions or Claims.</div>
			<?php insertFormHeaderMessage(); ?>

			<form id="evidenceform" name="evidenceform" action="" enctype="multipart/form-data" method="post" onsubmit="return checkForm();">
				<input type="hidden" id="chatnodeid" name="chatnodeid" value="<?php echo $chatnodeid; ?>" />
				<input type="hidden" id="chatparentid" name="chatparentid" value="<?php echo $chatparentid; ?>" />

				<div class="mb-3 row">
					<label for="nodetypename" class="col-sm-3 col-form-label">
						<?php echo $LNG->FORM_LABEL_TYPE; ?>
						<a class="active" onMouseOver="showFormHint('EvidenceType', event, 'hgrhint'); return false;" onMouseOut="hideHints(); return false;" onClick="hideHints(); return false;" onkeypress="enterKeyPressed(event)">
							<i class="far fa-question-circle fa-lg me-2" aria-hidden="true" ></i> 
							<span class="sr-only">More info</span>
						</a>
						<span class="required">*</span>
					</label>
					<div class="col-sm-9">							
						<select class="form-select" aria-label="Evidence type" id="nodetypename" name="nodetypename" >
							<?php
								$count = 0;
								if (is_countable($CFG->EVIDENCE_TYPES)) {
									$count = count($CFG->EVIDENCE_TYPES);
								}
								for($i=0; $i<$count; $i++){
									$item = $CFG->EVIDENCE_TYPES[$i];
									$name = $LNG->EVIDENCE_TYPES[$i];
								?>
									<option value='<?php echo $item; ?>' <?php if ($nodetypename == $item || ($nodetypename == "" && $item == $CFG->EVIDENCE_TYPES_DEFAULT)) { echo 'selected=\"true\"'; }  ?> ><?php echo $name; ?></option>
							<?php } ?>
						</select>
					</div>
				</div>

				<?php insertSummary('EvidenceSummary', $LNG->FORM_EVIDENCE_LABEL_SUMMARY); ?>
				<?php insertDescription('EvidenceDesc'); ?>
				<?php if ($isRemote) {
						insertResourceForm('RemoteEvidenceResources');
					} else {
						insertResourceForm('Resources');
					}
				?>
				<?php insertThemes('EvidenceTheme'); ?>
				<?php insertAddTags('EvidenceTag'); ?>

				<div class="mb-3 row">
					<div class="d-grid gap-2 d-md-flex justify-content-md-center mb-3">
						<input class="btn btn-secondary" type="button" value="<?php echo $LNG->FORM_BUTTON_CANCEL; ?>" onclick="window.close();"/>
						<input class="btn btn-primary" type="submit" value="<?php echo $LNG->FORM_BUTTON_PUBLISH; ?>" id="addevidence" name="addevidence" />
					</div>
				</div>
			</form>
		</div>
	</div>
</div>

<?php
    include_once($HUB_FLM->getCodeDirPath("ui/dialogfooter.php"));
?>