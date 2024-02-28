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
		document.getElementById('datediv').style.display = "block";
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

<?php insertFormHeaderMessage(); ?>

<form id="orgform" name="orgform" action="" enctype="multipart/form-data" method="post" onsubmit="return checkForm();">
	<input type="hidden" id="from" name="from" value="<?php echo $from; ?>" />

	<div class="hgrformrow">
		<div style="display: block; float:left; margin:0px; padding: 0px;">
			<label class="formlabelbig" for="type2"><span style="vertical-align:top"><?php echo $LNG->FORM_LABEL_TYPE; ?></span>
				<span class="active" onMouseOver="showFormHint('OrgType', event, 'hgrhint'); return false;" onMouseOut="hideHints(); return false;" onClick="hideHints(); return false;" onkeypress="enterKeyPressed(event)"><img src="<?php echo $HUB_FLM->getImagePath('info.png'); ?>" border="0" style="margin-top: 2px; margin-left: 5px; margin-right: 2px;" /></span>
				<span style="font-size:14pt;margin-top:3px;vertical-align:middle;color:red;">*</span>
			</label>
			<input style="margin-left: 5px; margin-top: 0px" onclick="typeChangedOrg()" type="radio" name="type" id="type1" value="Organization" <?php if ($type == 'Organization' || $type == '') echo "checked"; ?>> <?php echo $LNG->ORG_NAME; ?>
			<input type="radio" name="type" id="type2" onclick="typeChangedProject()" value="Project" <?php if ($type == 'Project') echo "checked"; ?> > <?php echo $LNG->PROJECT_NAME; ?><br>
		</div>
	</div>

    <div class="hgrformrow">
		<label  class="formlabelbig" for="orgname"><span style="vertical-align:top"><?php echo $LNG->FORM_LABEL_NAME; ?></span>
			<span class="active" onMouseOver="showFormHint('OrgName', event, 'hgrhint'); return false;" onMouseOut="hideHints(); return false;" onClick="hideHints(); return false;" onkeypress="enterKeyPressed(event)"><img src="<?php echo $HUB_FLM->getImagePath('info.png'); ?>" border="0" style="margin-top: 2px; margin-left: 5px; margin-right: 2px;" /></span>
			<span style="font-size:14pt;margin-top:3px;vertical-align:middle;color:red;">*</span>
		</label>
		<input class="forminputmust hgrinput hgrwide" id="orgname" name="orgname" value="<?php echo( $orgname ); ?>" />
	</div>

	<?php insertDescription('OrgDesc'); ?>

	<?php insertProjectDates('OrgDates'); ?>

	<div class="hgrformrow" id="linediv1">
		<hr class="hrline" />
	</div>

	<?php insertLocation('Org'); ?>

	<div class="hgrformrow" id="linediv2">
		<hr class="hrline" />
	</div>

	<?php insertResourceForm('OrgResources');  ?>

	<?php insertThemes('OrgTheme'); ?>

	<?php insertAddTags('OrgTag'); ?>

	<?php if ($isRemote === FALSE) { ?>
   	<div class="hgrformrow" id="endmessagediv">
		<span><?php echo $LNG->FORM_ORG_PUBLISH_MESSAGE; ?></span>
	</div>
	<?php } ?>

    <div class="hgrformrow">
        <input class="submit" type="submit" value="<?php echo $LNG->FORM_BUTTON_PUBLISH; ?>" id="addorg" name="addorg">
        <input type="button" value="<?php echo $LNG->FORM_BUTTON_CANCEL; ?>" onclick="window.close();"/>
    </div>
</form>

<?php
    include_once($HUB_FLM->getCodeDirPath("ui/dialogfooter.php"));
?>