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

    include_once($HUB_FLM->getCodeDirPath("core/utillib.php"));

    checkLogin();

    include_once($HUB_FLM->getCodeDirPath("ui/dialogheader.php"));
	include_once($HUB_FLM->getCodeDirPath("ui/popuplib.php"));

    $errors = array();

    $countries = getCountryList();

	$isRemote = optional_param("isremote", false,PARAM_BOOL);

	$from = optional_param("from","list",PARAM_TEXT);
	$type = optional_param("type","",PARAM_TEXT);
	$orgname = optional_param("orgname","",PARAM_TEXT);
	$orgcountry = optional_param("orgcountry","",PARAM_TEXT);
	$address1 = optional_param("address1","",PARAM_TEXT);
	$address2 = optional_param("address2","",PARAM_TEXT);
	$postcode = optional_param("postcode","",PARAM_TEXT);
	$city = optional_param("city","",PARAM_TEXT);
	$desc = optional_param("desc","",PARAM_HTML);
    $sdt = trim(optional_param("startdate","",PARAM_TEXT));
    $edt = trim(optional_param("enddate","",PARAM_TEXT));

    $resourcetypesarray = optional_param("resourcetypesarray","",PARAM_TEXT);
    $resourcetitlearray = optional_param("resourcetitlearray","",PARAM_TEXT);
    $resourceurlarray = optional_param("resourceurlarray","",PARAM_URL);
    $identifierarray = optional_param("identifierarray","",PARAM_TEXT);
    $resourcenodeidsarray = optional_param("resourcenodeidsarray","",PARAM_TEXT);
    $resourcecliparray = optional_param("resourcecliparray","",PARAM_TEXT);
    $resourceclippatharray = optional_param("resourceclippatharray","",PARAM_TEXT);

	$themesarray = optional_param("themesarray","",PARAM_TEXT);
    $newtags = optional_param("newtags","",PARAM_TEXT);

    if( isset($_POST["addorg"]) ) {

        if ($orgname == ""){
            array_push($errors, $LNG->FORM_ORG_ENTER_SUMMARY_ERROR);
        }

        if (is_countable($themesarray) && count($themesarray) <= 0){
            array_push($errors, $LNG->FORM_ERROR_THEME);
        }

        if(empty($errors)){

			$r = getRoleByName("Organization");
			$roleMainAuthor = $r->roleid;
			if ($type == 'Project') {
				$r = getRoleByName("Project");
				$roleMainAuthor = $r->roleid;
			}

			$orgnode = addNode($orgname,$desc, 'N', $roleMainAuthor);
			if (!$orgnode instanceof Hub_Error) {
				if ($CFG->autoFollowingOn) {
					addFollowing($orgnode->nodeid);
				}

				// Add any new tags
				addTagsToNode($orgnode, $newtags);

				$orgnode->updateLocation($city,$orgcountry,$address1,$address2,$postcode);

				updateNodeStartDate($orgnode->nodeid,$sdt);
				updateNodeEndDate($orgnode->nodeid,$edt);

				if (isset($themesarray) && $themesarray != "") {
					connectThemesToNode($orgnode, $themesarray, "N");
				}

				/** ADD RESOURCES **/
				$errors = addResourcesToNode($orgnode, $errors, $resourcenodeidsarray, $resourcetypesarray, $resourceurlarray, $resourcetitlearray, $identifierarray, $themesarray, $newtags, "N");

				if(empty($errors)){
					echo "<script type='text/javascript'>";

					if ($isRemote === false) {
						echo "try { ";
							echo "if (window.opener && window.opener.loadSelecteditemNew) {";
							echo "	  window.opener.loadSelecteditemNew('".$orgnode->nodeid."','".$orgnode->name."'); }";
							echo 'else {';

							if ($from == "home") {
								echo '	  window.opener.location.href = "'.$CFG->homeAddress.'"; }';
							} else {
								echo '	  window.opener.location.href = "'.$CFG->homeAddress.'explore.php?id='.$orgnode->nodeid.'"; }';
							}

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
			} else {
			     array_push($errors,$LNG->FORM_ORG_CREATE_ERROR_MESSAGE);
			}
		}
    } else {
    	$resourceids[0] = "";
    	$projectids[0] = "";
    	$challengeset = getNodesByGlobal(0, -1 ,'name', 'ASC', "Challenge", "", 'short',"",'all');
		$challanges = $challengeset->nodes;
    }

	$orgs = getHGWNodesByNodeType('Organization,Project');

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
    $('dialogheader').insert('<?php echo $LNG->FORM_ORG_TITLE_ADD; ?>');

	if (initialtype == 'Project') {
		document.getElementById('datediv').style.display = "";
	} else if (initialtype == 'Organization') {
		document.getElementById('datediv').style.display = "none";
	}
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
		$('theme'+noThemes-1+'menu').focus();
	}
}

function checkForm() {
	var checkname = ($('orgname').value).trim();
	if (checkname == ""){
	   alert("<?php echo $LNG->FORM_ORG_ENTER_SUMMARY_ERROR; ?>");
	   return false;
    } else if ($('theme0menu').value == "") {
	   alert("<?php echo $LNG->FORM_ERROR_THEME; ?>");
	   return false;
    }

    $('orgform').style.cursor = 'wait';

    return true;
}
window.onload = init;

</script>

<div class="container-fluid popups">
	<div class="row p-4 justify-content-center">	
		<div class="col">
			<?php insertFormHeaderMessage(); ?>

			<form id="orgform" name="orgform" action="" enctype="multipart/form-data" method="post" onsubmit="return checkForm();">
				<input type="hidden" id="from" name="from" value="<?php echo $from; ?>" />

				<div class="mb-3 row">
					<label class="col-sm-3 col-form-label">
						<?php echo $LNG->FORM_LABEL_TYPE; ?> 
						<a class="active" onMouseOver="showFormHint('OrgType', event, 'hgrhint'); return false;" onMouseOut="hideHints(); return false;" onClick="hideHints(); return false;" onkeypress="enterKeyPressed(event)">
							<i class="far fa-question-circle fa-lg me-2" aria-hidden="true" ></i> 
							<span class="sr-only">More info</span>
						</a>
					</label>
					<div class="col-sm-9">
						<div class="form-check form-check-inline">
							<input class="form-check-input" type="radio" name="type" id="type1" onclick="typeChangedOrg()" value="Organization" <?php if ($type == 'Organization') echo "checked"; ?> />
							<label class="form-check-label" for="type1"><?php echo $LNG->ORG_NAME; ?></label>
						</div>
						<div class="form-check form-check-inline">
							<input class="form-check-input" type="radio" name="type" id="type2" onclick="typeChangedProject()" value="Project" <?php if ($type == 'Project') echo "checked"; ?> />
							<label class="form-check-label" for="type2"><?php echo $LNG->PROJECT_NAME; ?></label>
						</div>
					</div>
				</div>	

				<div class="mb-3 row">
					<label for="orgname" class="col-sm-3 col-form-label">
						<?php echo $LNG->FORM_LABEL_NAME; ?> 
						<a class="active" onMouseOver="showFormHint('OrgName', event, 'hgrhint'); return false;" onMouseOut="hideHints(); return false;" onClick="hideHints(); return false;" onkeypress="enterKeyPressed(event)">
							<i class="far fa-question-circle fa-lg me-2" aria-hidden="true" ></i> 
							<span class="sr-only">More info</span>
						</a>						
						<span class="required">*</span>
					</label>
					<div class="col-sm-9">
						<input type="text" class="form-control" id="orgname" name="orgname" value="<?php echo( $orgname ); ?>" />
					</div>
				</div>

				<?php insertDescription('OrgDesc'); ?>
				<?php insertProjectDates('OrgDates'); ?>
				<hr id="linediv1" />
				<?php insertLocation('Org'); ?>
				<hr id="linediv2" />
				<?php insertResourceForm('OrgResources');  ?>
				<?php insertThemes('OrgTheme'); ?>
				<?php insertAddTags('OrgTag'); ?>
				<?php if ($isRemote === FALSE) { ?>
					<div class="alert alert-info" id="endmessagediv">
						<p><?php echo $LNG->FORM_ORG_PUBLISH_MESSAGE; ?></p>
					</div>
				<?php } ?>

				<div class="mb-3 row">
					<div class="d-grid gap-2 d-md-flex justify-content-md-center mb-3">
						<input class="btn btn-secondary" type="button" value="<?php echo $LNG->FORM_BUTTON_CANCEL; ?>" onclick="window.close();"/>
						<input class="btn btn-primary" type="submit" value="<?php echo $LNG->FORM_BUTTON_PUBLISH; ?>" id="addorg" name="addorg" />
					</div>
				</div>
			</form>
		</div>
	</div>
</div>

<?php
    include_once($HUB_FLM->getCodeDirPath("ui/dialogfooter.php"));
?>