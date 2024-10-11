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

	$tags = array();
	$errors = array();

    $countries = getCountryList();
    $newbit = array();

 	$nodeid = required_param("nodeid",PARAM_TEXT);

	$handler = optional_param("handler","", PARAM_TEXT);
	//convert brackets
	$handler = parseToJSON($handler);

 	$type = optional_param("type", "", PARAM_TEXT);
	$orgname = optional_param("orgname","",PARAM_TEXT);
	$orgcountry = optional_param("orgcountry","",PARAM_TEXT);
	$address1 = optional_param("address1","",PARAM_TEXT);
	$address2 = optional_param("address2","",PARAM_TEXT);
	$postcode = optional_param("postcode","",PARAM_TEXT);
	$city = optional_param("city","",PARAM_TEXT);
	$desc = optional_param("desc","",PARAM_HTML);
    $sdt = trim(optional_param("startdate","",PARAM_TEXT));
    $edt = trim(optional_param("enddate","",PARAM_TEXT));

    $newtags = optional_param("newtags","",PARAM_TEXT);
    $removetagsarray = optional_param("removetags","",PARAM_TEXT);

    if( isset($_POST["editorg"]) ) {

    	if ($orgname == ""){
            array_push($errors, $LNG->FORM_ORG_ENTER_SUMMARY_ERROR);
        }

        if(empty($errors)){
			$r = getRoleByName("Organization");
			$roleOrg = $r->roleid;
			if ($type == 'Project') {
				$r = getRoleByName("Project");
				$roleOrg = $r->roleid;
			}

	    	$node = new CNode($nodeid);
	    	$node->load();
			$currentType = $node->role->name;

			$orgnode = editNode($nodeid, $orgname,$desc, 'N', $roleOrg);
			$orgnode->updateLocation($city,$orgcountry,$address1,$address2,$postcode);
	        updateNodeStartDate($orgnode->nodeid,$sdt);
	        updateNodeEndDate($orgnode->nodeid,$edt);

			// remove from this node any tags marked for removal
			removeTagsFromNode($orgnode, $removetagsarray);

			// Add any new tags
			addTagsToNode($orgnode, $newtags);

			if ($currentType != $type) {
				updateConnectionsForTypeChange($nodeid, $type);
			}

			echo "<script type='text/javascript'>";

			echo "try { ";
				echo "var parent=window.opener.document; ";
				echo "if (window.opener && window.opener.loadSelecteditemNew) {";
				echo '	  window.opener.loadSelecteditemNew("'.$nodeid.'"); }';
				echo " else {";
				echo '	  window.opener.location.reload(true); }';
			echo "}";
			echo "catch(err) {";
			echo "}";

			echo "window.close();";
			echo "</script>";
			include_once($HUB_FLM->getCodeDirPath("ui/dialogfooter.php"));
			die;
        }
	} else if ($nodeid != "") {
    	$node = new CNode($nodeid);
    	$node->load();
		$orgname = $node->name;
		$desc = $node->description;
		$orgcountry = $node->countrycode;
		$address1 = $node->locationaddress1;
		$address2 = $node->locationaddress2;
		$postcode = $node->locationpostcode;
		$city = $node->location;
		$type = $node->role->name;

		if (isset($node->startdatetime)) {
        	$sdt = $node->startdatetime;
        } else {
        	$sdt = 0;
        }

        if (isset($node->enddatetime)) {
        	$edt = $node->enddatetime;
        } else {
        	$edt = 0;
        }

		if(isset($node->tags)) {
			$tags = $node->tags;
		}
    } else {
		echo "<script type='text/javascript'>";
		echo "alert('".$LNG->FORM_ORG_NOT_FOUND_ERROR_MESSAGE."');";
		echo "window.close();";
		echo "</script>";
		die;
    }

    /**********************************************************************************/
?>

<script type="text/javascript">

function init() {
    $('dialogheader').insert('<?php echo $LNG->FORM_ORG_TITLE_EDIT; ?> <?php echo $type; ?>');

	if (initialtype == 'Project') {
		document.getElementById('datediv').style.display = "block";
	} else if (initialtype == 'Organization') {
		document.getElementById('datediv').style.display = "none";
	}
}

function checkForm() {
	var checkname = ($('orgname').value).trim();
	if (checkname == ""){
	   alert("<?php echo $LNG->FORM_ORG_ENTER_SUMMARY_ERROR; ?>");
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

				<input type="hidden" id="nodeid" name="nodeid" value="<?php echo $nodeid; ?>" />
				<input type="hidden" id="handler" name="handler" value="<?php echo $handler; ?>" />

				<div class="mb-3 row">
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

				<div class="mb-3 row">
					<label class="col-sm-3 col-form-label" for="orgname">
						<?php echo $LNG->FORM_LABEL_NAME; ?>
						<a class="active" onMouseOver="showFormHint('OrgName', event, 'hgrhint'); return false;" onMouseOut="hideHints(); return false;" onClick="hideHints(); return false;" onkeypress="enterKeyPressed(event)">
							<i class="far fa-question-circle fa-lg me-2" aria-hidden="true" ></i> 
							<span class="sr-only">More info</span>
						</a>
						<span class="required">*</span>
					</label>
					<div class="col-sm-9">
						<input class="form-control" id="orgname" name="orgname" value="<?php echo($orgname); ?>" />
					</div>
				</div>

				<?php insertDescription('OrgDesc'); ?>
				<?php insertProjectDates('OrgDates'); ?>
				<?php insertLocation('Org'); ?>
				<?php insertAddTags('OrgTag'); ?>
				<?php insertTagsAdded('OrgTagAdded'); ?>

				<div class="mb-3 row">
					<div class="d-grid gap-2 d-md-flex justify-content-md-center mb-3">
						<input class="btn btn-secondary" type="button" value="<?php echo $LNG->FORM_BUTTON_CANCEL; ?>" onclick="window.close();"/>
						<input class="btn btn-primary" type="submit" value="<?php echo $LNG->FORM_BUTTON_SAVE; ?>" id="editorg" name="editorg" />
					</div>
				</div>
			</form>
		</div>
	</div>
</div>

<?php
    include_once($HUB_FLM->getCodeDirPath("ui/dialogfooter.php"));
?>