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

    $countries = getCountryList();

	$filternodetypes = required_param("filternodetypes",PARAM_TEXT);
	$focalnodeid = required_param("focalnodeid",PARAM_TEXT);
	$focalnodeend = required_param("focalnodeend",PARAM_TEXT);
	$linktypename = required_param("linktypename",PARAM_TEXT);
	$focalnode = getNode($focalnodeid);

	$nodeid = optional_param("nodeid","",PARAM_TEXT);
	//$conndesc = optional_param("conndesc", "", PARAM_TEXT);
	$conndesc = "";

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

    if( isset($_POST["addorg"]) ) {

    	if ($nodeid == "" && $orgname == ""){
            array_push($errors, $LNG->FORM_ORG_ENTER_SUMMARY_ERROR);
        }

        if ($nodeid == "" && is_countable($themesarray) && count($themesarray) <= 0){
            array_push($errors, $LNG->FORM_ERROR_THEME);
        }

        if(empty($errors)){

			// GET ROLES AND LINKS FOR AUTHOR
			$r = getRoleByName("Organization");
			$roleMainAuthor = $r->roleid;
			if ($type == 'Project') {
				$r = getRoleByName("Project");
				$roleMainAuthor = $r->roleid;
			}

			$r = getRoleByName($CFG->RESOURCE_TYPES_DEFAULT);
			$roleRefAuthor = $r->roleid;
			$lt = getLinkTypeByLabel('partnered with');
			$linkPartner = $lt->linktypeid;
			$lt = getLinkTypeByLabel('is related to');
			$linkRelated = $lt->linktypeid;

			if ($nodeid != "") {
				$orgnode = getNode($nodeid);
				$r = getRoleByName($orgnode->role->name);
				$roleMainAuthor = $r->roleid;
			} else if ($nodeid == "") {
				$orgnode = addNode($orgname,$desc, 'N', $roleMainAuthor);
				if (!$orgnode instanceof Hub_Error) {
					if ($CFG->autoFollowingOn) {
						addFollowing($orgnode->nodeid);
					}

					$nodeid = $orgnode->nodeid;

					$orgnode->updateLocation($city,$orgcountry,$address1,$address2,$postcode);

					updateNodeStartDate($orgnode->nodeid,$sdt);
					updateNodeEndDate($orgnode->nodeid,$edt);

					// Add any new tags
					addTagsToNode($orgnode, $newtags);

					// Add any themes
					connectThemesToNode($orgnode,$themesarray,"N");

					/** ADD RESOURCES **/
					$errors = addResourcesToNode($orgnode,$errors,$resourcenodeidsarray, $resourcetypesarray, $resourceurlarray, $resourcetitlearray, $identifierarray, $themesarray, $newtags, "N");
				}
			}

			if(empty($errors)){
				// CONNECT NODE TO FOCAL
				$r = getRoleByName($focalnode->role->name);
				$focalroleid = $r->roleid;

				$lt = getLinkTypeByLabel($linktypename);
				$linkType = $lt->linktypeid;

				if ($focalnodeend == "from") {
					$connection = addConnection($focalnodeid, $focalroleid, $linkType, $nodeid, $roleMainAuthor, "N", $conndesc);
				} else {
					$connection = addConnection($nodeid, $roleMainAuthor, $linkType, $focalnodeid, $focalroleid, "N", $conndesc);
				}

				echo "<script type='text/javascript'>";

				// decision just to send them to the explore page for the other end of the connection
				// echo 'window.opener.location.href = "'.$CFG->homeAddress.'explore.php?id='.$nodeid.'";';

				if (isset($handler) && $handler != "") {
					echo "window.opener.".$handler."('".$nodeid."');";
				} else {
					echo "if (window.opener && window.opener.refreshWidgetPartners) {";
					echo "	  window.opener.refreshWidgetPartners('".$nodeid."'); }";
					echo "else if (window.opener && window.opener.refreshWidgetOrganizations) {";
					echo "	  window.opener.refreshWidgetOrganizations('".$nodeid."'); }";
					echo "else if (window.opener && window.opener.refreshOrganizations) {";
					echo "	  window.opener.refreshOrganizations(); }";
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

var nodeType = '<?php echo $filternodetypes; ?>';

function init() {

	if (nodeType == 'Project') {
	    $('dialogheader').insert("<?php echo $LNG->FORM_TITLE_PROJECT_CONNECT; ?><br><span style=\"font-size: 80%\">\"<?php echo addslashes( $focalnode->name ); ?>\"</span>");
	    $('type2').click();
		$('typediv').style.display="none";
	} else if (nodeType == 'Organization') {
	    $('dialogheader').insert("<?php echo $LNG->FORM_TITLE_ORG_CONNECT; ?><br><span style=\"font-size: 80%\">\"<?php echo addslashes( $focalnode->name ); ?>\"</span>");
	    $('type1').click();
		$('typediv').style.display="none";
	} else {
    	$('dialogheader').insert("<?php echo $LNG->FORM_TITLE_ORGPROJECT_CONNECT; ?><br><span style=\"font-size: 80%\">\"<?php echo( $focalnode->name ); ?>\"</span>");
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

	$('typehiddendiv-'+num).style.display="flex";
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
	$('typediv-'+num).style.display="flex";
	$('resourceurldiv-'+num).style.display="flex";
	$('resourcedescdiv-'+num).style.display="flex";
}

function addSelectedNode(node) {
	$('nodeid').value = node.nodeid;

	$('labeldiv').style.display="flex";
	$('orglabel').value = node.name;

	$('typediv').style.display="none";
	$('namediv').style.display="none";
	$('descdiv').style.display="none";
	$('datediv').style.display="none";
	$('locationdiv').style.display="none";
	$('resourcediv').style.display="none";
	$('themediv').style.display="none";
	$('linediv1').style.display="none";
	$('linediv2').style.display="none";
	$('tagsdiv').style.display="none";


	if ($('endmessagediv')) {
		$('endmessagediv').style.display="none";
	}
}

function removeSelectedNode() {
	$('nodeid').value = "";

	$('labeldiv').style.display="none";
	$('orglabel').value="";

	if (nodeType == 'Project') {
		$('typediv').style.display="none";
	} else {
		$('typediv').style.display="flex";
	}
	$('namediv').style.display="flex";
	$('descdiv').style.display="flex";
	$('datediv').style.display="flex";
	$('locationdiv').style.display="flex";
	$('resourcediv').style.display="flex";
	$('themediv').style.display="flex";
	$('linediv1').style.display="flex";
	$('linediv2').style.display="flex";
	$('tagsdiv').style.display="flex";

	if ($('endmessagediv')) {
		$('endmessagediv').style.display="flex";
	}
}

function openSelector() {
	loadDialog('selector', URL_ROOT+"ui/popups/selector.php?filternodetypes=<?php echo $filternodetypes; ?>", 420, 730);
}

function checkThemeChange(num) {
	var selected = $('theme'+num+'menu').value;
	if (selected != "" && num == noThemes-1) {
		noThemes = addTheme(noThemes);
	}
}

function checkForm() {
	if ($('orgname').value == "" && $('nodeid').value == ""){
	   alert("<?php echo $LNG->FORM_ORG_ENTER_SUMMARY_ERROR; ?>");
	   return false;
    } else if ($('theme0menu').value == "" && $('nodeid').value == "") {
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
				<input type="hidden" id="focalnodeid" name="focalnodeid" value="<?php echo $focalnodeid; ?>" />
				<input type="hidden" id="focalnodeend" name="focalnodeend" value="<?php echo $focalnodeend; ?>" />
				<input type="hidden" id="filternodetypes" name="filternodetypes" value="<?php echo $filternodetypes; ?>" />
				<input type="hidden" id="linktypename" name="linktypename" value="<?php echo $linktypename; ?>" />
				<input type="hidden" id="nodeid" name="nodeid" value="<?php echo $nodeid; ?>" />
				<input type="hidden" id="handler" name="handler" value="<?php echo $handler; ?>" />
				<input type="hidden" id="theme" name="theme" value="<?php echo $theme; ?>" />

				<div class="mb-3 row" id="typediv">
					<label class="col-sm-3 col-form-label">
						<?php echo $LNG->FORM_LABEL_TYPE; ?>
						<a class="active" onMouseOver="showFormHint('OrgType', event, 'hgrhint'); return false;" onMouseOut="hideHints(); return false;" onClick="hideHints(); return false;" onkeypress="enterKeyPressed(event)">
							<i class="far fa-question-circle fa-lg me-2" aria-hidden="true" ></i> 
							<span class="sr-only">More info</span>
						</a>
						<span class="required">*</span>
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

				<div class="mb-3 row" id="labeldiv" style="display: none;">
					<label class="col-sm-3 col-form-label" for="orglabel">
						<?php echo $LNG->FORM_LABEL_NAME; ?>
						<a class="active" onMouseOver="showFormHint('OrgName', event, 'hgrhint'); return false;" onMouseOut="hideHints(); return false;" onClick="hideHints(); return false;" onkeypress="enterKeyPressed(event)">
							<i class="far fa-question-circle fa-lg me-2" aria-hidden="true" ></i> 
							<span class="sr-only">More info</span>
						</a>
						<span class="required">*</span>
					</label>
					<div class="col-sm-6">
						<input class="form-control" id="orglabel" name="orglabel" value="" />
					</div>
					<div class="col-sm-3 pt-2">
						<span class="active d-inline-block me-2" onClick="javascript: removeSelectedNode()"><?php echo $LNG->FORM_BUTTON_REMOVE_CAP; ?></span>
						<span class="active d-inline-block ms-2" onClick="javascript: openSelector()"><?php echo $LNG->FORM_BUTTON_SELECT_ANOTHER; ?></span>
					</div>
				</div>

				<div class="mb-3 row" id="namediv">
					<label class="col-sm-3 col-form-label" for="orgname">
						<?php echo $LNG->FORM_LABEL_NAME; ?>
						<a class="active" onMouseOver="showFormHint('OrgName', event, 'hgrhint'); return false;" onMouseOut="hideHints(); return false;" onClick="hideHints(); return false;" onkeypress="enterKeyPressed(event)">
							<i class="far fa-question-circle fa-lg me-2" aria-hidden="true" ></i> 
							<span class="sr-only">More info</span>
						</a>
						<span class="required">*</span>
					</label>
					<div class="col-sm-6">
						<input class="form-control" id="orgname" name="orgname" value="<?php echo( $orgname ); ?>" />
					</div>
					<?php if ($focalnodeid != "") { ?>
						<div class="col-sm-3 pt-2">
							<span class="active" onClick="javascript: openSelector()"><?php echo $LNG->FORM_ORG_SELECT_EXISTING; ?></span>
						</div>
					<?php }; ?>
				</div>

				<?php insertDescription('OrgDesc'); ?>
				<?php insertProjectDates('OrgDates'); ?>
				<hr class="hrline" id="linediv1" />
				<?php insertLocation('Org'); ?>
				<hr class="hrline" id="linediv2" />
				<?php insertResourceForm('OrgResources');  ?>
				<?php insertThemes('OrgTheme', $theme); ?>
				<?php insertAddTags('OrgTag'); ?>

				<div class="alert alert-info" id="endmessagediv">
					<span><?php echo $LNG->FORM_ORG_PUBLISH_MESSAGE; ?></span>
				</div>

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