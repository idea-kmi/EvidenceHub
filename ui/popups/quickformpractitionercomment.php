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

    $errors = array();

	$chatnodeid = required_param("chatnodeid",PARAM_TEXT);
	$chatparentid = optional_param("chatparentid","",PARAM_HTML);
	$node = getNode($chatnodeid);
	$text="";
	if (!$node instanceof Hub_Error) {
		if ($node->description == "") {
			$text = $node->name;
		} else {
			$text = $node->description;
		}
	}

    $challenges = optional_param("challenges","",PARAM_TEXT);

	$issue = optional_param("issue","",PARAM_TEXT);
	$issuedesc = optional_param("issuedesc","",PARAM_HTML);

	$solution = optional_param("solution","",PARAM_TEXT);
	$solutiondesc = optional_param("solutiondesc","",PARAM_HTML);

	$evidence = optional_param("evidence","",PARAM_TEXT);
	$evidencedesc = optional_param("evidencedesc","",PARAM_HTML);
	$evidencetype = optional_param("evidencetype","",PARAM_TEXT);

    $resourcetypesarray = optional_param("resourcetypesarray","",PARAM_TEXT);
    $resourcetitlearray = optional_param("resourcetitlearray","",PARAM_TEXT);
    $resourceurlarray = optional_param("resourceurlarray","",PARAM_URL);
    $identifierarray = optional_param("identifierarray","",PARAM_TEXT);
    $resourcenodeidsarray = optional_param("resourcenodeidsarray","",PARAM_TEXT);
    $resourcecliparray = optional_param("resourcecliparray","",PARAM_TEXT);
    $resourceclippatharray = optional_param("resourceclippatharray","",PARAM_TEXT);

    $orgitem = optional_param("orgitem","",PARAM_TEXT);

	$themesarray = optional_param("themesarray","",PARAM_TEXT);
    $newtags = optional_param("newtags","",PARAM_TEXT);

    if( isset($_POST["publish"]) ) {

    	if ($issue == "" && $issuedesc != ""){
             array_push($errors,$LNG->FORM_QUICK_ISSUE_DESC_ERROR);
        }
    	if ($solution == "" && $solutiondesc != ""){
            array_push($errors,$LNG->FORM_QUICK_SOLUTION_DESC_ERROR);
    	}
    	if ($evidence == "" && $evidencedesc != ""){
            array_push($errors,$LNG->FORM_QUICK_EVIDENCE_DESC_ERROR);
        }

        if (is_countable($themesarray) && count($themesarray) <= 0){
            array_push($errors,$LNG->FORM_ERROR_THEME);
        }

        if(empty($errors)){
			$currentUser = $USER;

			if ($chatnodeid != "") {
				$chatnode = getNode($chatnodeid);
				$charrolename = $chatnode->role->name;
				$r = getRoleByName($charrolename);
				$roleComment = $r->roleid;

				$lt = getLinkTypeByLabel($CFG->LINK_COMMENT_BUILT_FROM);
				$linkComment = $lt->linktypeid;
			}

        	/** ADD ISSUE **/
			if ($issue != "") {
				// GET ROLES AND LINKS AS USER
				$r = getRoleByName("Issue");
				$roleIssue = $r->roleid;

				// CREATE THE ISSUE NODE
				$desc = stripslashes(trim($issuedesc));
				$issuenode = addNode($issue, $desc, 'N', $roleIssue);

				if (!$issuenode instanceof Hub_Error) {
					if ($CFG->autoFollowingOn) {
						addFollowing($issuenode->nodeid);
					}

					if ($CFG->HAS_CHALLENGE && $challenges && $challenges != ""){
						$r = getRoleByName("Challenge");
						$roleChallenge = $r->roleid;
						$lt = getLinkTypeByLabel('is related to');
						$linkChallenge = $lt->linktypeid;

						foreach($challenges as $challenge){
							addConnection($issuenode->nodeid, $roleIssue, $linkChallenge, $challenge, $roleChallenge, "N");
						}
					}

					// Add a built from to the comment node this was created from if chatnodeid exists
					if ($chatnodeid != "") {
						$connection = addConnection($issuenode->nodeid, $roleIssue, $linkComment, $chatnodeid, $roleComment, "N", $chatparentid);
					}

				} else {
				   array_push($errors,$LNG->FORM_ISSUE_CREATE_ERROR_MESSAGE." ".$issuenode->message);
				}
			}

			/** ADD SOLUTION **/
        	if(empty($errors)){
        		if ($solution != "") {
					$r = getRoleByName("Solution");
					$roleSolution = $r->roleid;

					$desc = stripslashes(trim($solutiondesc));
					$solutionnode = addNode($solution,$desc, 'N', $roleSolution);

					if (!$solutionnode instanceof Hub_Error) {
						if ($CFG->autoFollowingOn) {
							addFollowing($solutionnode->nodeid);
						}

						// Add a built from to the comment node this was created from if chatnodeid exists
						if ($chatnodeid != "") {
							$connection = addConnection($solutionnode->nodeid, $roleSolution, $linkComment, $chatnodeid, $roleComment, "N", $chatparentid);
						}
					}
				}
			}

			/** ADD EVIDENCE **/
        	if(empty($errors)){
        		if ($evidence != "") {
					$r = getRoleByName($evidencetype);
					$roleEvidence = $r->roleid;

					$r = getRoleByName('Pro');
					$roleConnectionEvidence = $r->roleid;

					$desc = stripslashes(trim($evidencedesc));
					$evidencenode = addNode($evidence, $desc, 'N', $roleEvidence);

					if (!$evidencenode instanceof Hub_Error) {
						if ($CFG->autoFollowingOn) {
							addFollowing($evidencenode->nodeid);
						}

						// Add a built from to the comment node this was created from if chatnodeid exists
						if ($chatnodeid != "") {
							$connection = addConnection($evidencenode->nodeid, $roleEvidence, $linkComment, $chatnodeid, $roleComment, "N", $chatparentid);
						}
					}
				}
			}

			/** CONNECT THE ISSUE/SOLUIOTN/EVIDENCE to the Chosen ORG if any*/
        	if ( empty($errors) ) {
				if ($orgitem && $orgitem != "") {
					$orgnode = new CNode($orgitem);
					$orgnode = $orgnode->load();

					if (!$orgnode instanceof Hub_Error) {
						$r = getRoleByName($orgnode->role->name);
						$role = $r->roleid;

						if (isset($issuenode) && !$issuenode instanceof Hub_Error) {
							$lt = getLinkTypeByLabel('addresses');
							$linkOrg = $lt->linktypeid;
							$connection = addConnection($orgnode->nodeid, $role, $linkOrg, $issuenode->nodeid, $roleIssue, "N");
						} else {
  	           				//array_push($errors,"issuenode issue: ".$issuenode->message);
						}
						if (isset($solutionnode) && !$solutionnode instanceof Hub_Error) {
							$lt = getLinkTypeByLabel('specifies');
							$linkOrg = $lt->linktypeid;
							$connection = addConnection($orgnode->nodeid, $role, $linkOrg, $solutionnode->nodeid, $roleSolution, "N");
						} else {
  	           				//array_push($errors,"solutionnode issue: ".$solutionnode->message);
						}
						if (isset($evidencenode) && !$evidencenode instanceof Hub_Error) {
							$lt = getLinkTypeByLabel('specifies');
							$linkOrg = $lt->linktypeid;
							$connection = addConnection($orgnode->nodeid, $role, $linkOrg, $evidencenode->nodeid, $roleEvidence, "N");
						} else {
  	           				//array_push($errors,"evidencenode issue: ".$evidencenode->message);
						}
					} else {
  	           			//array_push($errors,"orgnode issue: ".$orgnode->message);
					}
				}
			}

			// create Admin user object
			$adminUserID = $CFG->ADMIN_USERID;
			$adminUser = new User($adminUserID);
			$adminUser->load();

			$USER = $adminUser;
			$r = getRoleByName("Theme");
			$roleTheme = $r->roleid;

			$USER = $currentUser;

			/** ADD RESOURCES **/
        	if(empty($errors)){
				$lt = getLinkTypeByLabel('is related to');
				$linkRelated = $lt->linktypeid;

				$i = 0;
                foreach($resourcetypesarray as $resourcetype) {

					// connect exisitng resource
					if (isset($resourcenodeidsarray[$i]) && $resourcenodeidsarray[$i] != "") {
						$refnode = getNode($resourcenodeidsarray[$i]);
						$r = getRoleByName($refnode->role->name);
						$refrole = $r->roleid;
						$connection = addConnection($refnode->nodeid, $refrole, $linkRelated, $evidencenode->nodeid, $roleType, "N");
					} else { // create and connect new resource

						$r = getRoleByName($resourcetype);
						$refrole = $r->roleid;

						$resourceurl = trim($resourceurlarray[$i]);
						$resourcetitle = trim($resourcetitlearray[$i]);

						// If they have entered nothing, don't do anything.
						if ($resourcetitle == "" && ($resourceurl == "http://" || $resourceurl == "")) {
							break;
						}

						//check all fields entered
						if ($resourcetitle != "" && ($resourceurl == "http://" || $resourceurl == "")){
							array_push($errors,$LNG->FORM_RESOURCE_URL_REQUIRED);
							break;
						}
						$URLValidator = new mrsnk_URL_validation($resourceurl, MRSNK_URL_DO_NOT_PRINT_ERRORS, MRSNK_URL_DO_NOT_CONNECT_2_URL);
						if($resourceurl != "" && !$URLValidator->isValid()){
							 array_push($errors,$LNG->FORM_RESOURCE_URL_FORMAT_ERROR);
							 break;
						}

						if ($resourcetitle == ""){
							$resourcetitle = $resourceurl;
						}

						$refnode = addNode($resourceurl, $resourcetitle, 'N', $refrole);
						if (!$refnode instanceof Hub_Error) {

							if ($CFG->autoFollowingOn) {
								addFollowing($refnode->nodeid);
							}

							if ($resourcetype == 'Publication') {
								$refnode->updateAdditionalIdentifier($identifierarray[$i]);
							}

							// ADD URL TO REF
							if ($resourcetype == 'Publication') {
								$urlObj = addURL($resourceurl, $resourcetitle, '', 'N', "", "", "", "cohere", $identifierarray[$i]);
							} else {
								$urlObj = addURL($resourceurl, $resourcetitle, '', 'N');
							}
							$refnode->addURL($urlObj->urlid, "");

							// CONNECT REF TO EVIDENCE
							if (isset($evidencenode) && !$evidencenode instanceof Hub_Error) {
								$connection = addConnection($refnode->nodeid, $refrole, $linkRelated, $evidencenode->nodeid, $roleEvidence, "N");
							}

							if ($themesarray && $themesarray != "") {
								$r = getRoleByName("Theme");
								$roleThemeAuthor = $r->roleid;

								$lt = getLinkTypeByLabel('has main theme');
								$linkMainTheme = $lt->linktypeid;

								foreach($themesarray as $item){
									if ($item && $item != "") {
										// GET / CREATE THEME NODE AS ADMIN
										$USER = $adminUser;
										$nextnode = addNode($item,"", 'N', $roleTheme);

										// CREATE CONNECTION FROM CHALLANGE TO REF NODE
										$USER = $currentUser;
										$nexttag2 = addTag($item);
										$connection = addConnection($refnode->nodeid, $refrole, $linkMainTheme, $nextnode->nodeid, $roleThemeAuthor, "N");
										$connection->addTag($nexttag2->tagid);
									}
								}
							}

							$USER = $currentUser;

							/** ADD TAGS TO RESOURCE **/
							// Add any new tags
							$newtagsarray = explode(',', $newtags);
							if(count($newtagsarray) != 0){
								foreach($newtagsarray as $tagname){
									if ($tagname && $tagname != "") {
										$tag = addTag($tagname);
										if ($tag && $tag->tagid) {
											$refnode->addTag($tag->tagid);
										}
									}
								}
							}

						} else {
							array_push($errors,$LNG->FORM_RESOURCE_CREATE_ERROR_MESSAGE." ".$refrole->message);
						}
					}
					$i++;
				}
			}

			if(empty($errors)){

				// CONNECT EVIDENCE TO SOLUTION
				if (isset($evidencenode) && !$evidencenode instanceof Hub_Error && isset($solutionnode) && !$solutionnode instanceof Hub_Error) {
					$lt = getLinkTypeByLabel('supports');
					$linkRelated = $lt->linktypeid;
					$connection = addConnection($evidencenode->nodeid, $roleConnectionEvidence, $linkRelated, $solutionnode->nodeid, $roleSolution, "N");
				}

				// CONNECTION SOLUTION TO ISSUE
				if (isset($solutionnode) && !$solutionnode instanceof Hub_Error && isset($issuenode) && !$issuenode instanceof Hub_Error) {
					$lt = getLinkTypeByLabel('addresses');
					$linkRelated = $lt->linktypeid;
					$connection = addConnection($solutionnode->nodeid, $roleSolution, $linkRelated, $issuenode->nodeid, $roleIssue, "N");
				}

				/** ADD THEMES TO ALL **/
				if ($themesarray && $themesarray != "") {

					$r = getRoleByName("Theme");
					$roleThemeAuthor = $r->roleid;

					$lt = getLinkTypeByLabel('has main theme');
					$linkMainTheme = $lt->linktypeid;

					foreach($themesarray as $item){
						if ($item && $item != "") {
							// GET / CREATE THEME NODE AS ADMIN
							$USER = $adminUser;
							$nextnode = addNode($item,"", 'N', $roleTheme);
							if ($nextnode instanceof Hub_Error) {
  	           					array_push($errors, $LNG->FORM_THEME_CREATE_ERROR_MESSAGE." ".$nextnode->message);
  	           					break;
							}

							// CREATE CONNECTION FROM CHALLANGE TO NODES
							$USER = $currentUser;

							$nexttag2 = addTag($item);

							if (isset($issuenode) && !$issuenode instanceof Hub_Error) {
								$connection = addConnection($issuenode->nodeid, $roleIssue, $linkMainTheme, $nextnode->nodeid, $roleThemeAuthor, "N");
								$connection->addTag($nexttag2->tagid);
							}

							if (isset($solutionnode) && !$solutionnode instanceof Hub_Error) {
								$connection = addConnection($solutionnode->nodeid, $roleSolution, $linkMainTheme, $nextnode->nodeid, $roleThemeAuthor, "N");
								$connection->addTag($nexttag2->tagid);
							}

							if (isset($evidencenode) && !$evidencenode instanceof Hub_Error) {
								$connection = addConnection($evidencenode->nodeid, $roleEvidence, $linkMainTheme, $nextnode->nodeid, $roleThemeAuthor, "N");
								$connection->addTag($nexttag2->tagid);
							}
						}
					}
				}

				$USER = $currentUser;

				/** ADD TAGS TO ALL **/
				// Add any new tags
				$newtagsarray = explode(',', $newtags);
				if(count($newtagsarray) != 0){
					foreach($newtagsarray as $tagname){
						if ($tagname && $tagname != "") {
							$tag = addTag($tagname);
							if ($tag && $tag->tagid) {
								if (isset($issuenode) && !$issuenode instanceof Hub_Error) {
									$issuenode->addTag($tag->tagid);
								}

								if (isset($solutionnode) && !$solutionnode instanceof Hub_Error) {
									$solutionnode->addTag($tag->tagid);
								}

								if (isset($evidencenode) && !$evidencenode instanceof Hub_Error) {
									$evidencenode->addTag($tag->tagid);
								}
							}
						}
					}
				}

				echo '<script type=\'text/javascript\'>';

				echo "if (window) {window.alert('".$LNG->FORM_QUICK_THANKS."')}";

				echo 'if (window.opener && window.opener.loadSelecteditemNew) {';
				echo '	  window.opener.loadSelecteditemNew("'.$issuenode->nodeid.'","'.$issuenode->name.'"); }';
				echo 'else {';

					if (isset($issuenode) && !$issuenode instanceof Hub_Error) {
						$issueset = true;
					} else {
						$issueset = false;
					}
					if (isset($solutionnode) && !$solutionnode instanceof Hub_Error) {
						$solutionset = true;
					} else {
						$solutionset = false;
					}
					if (isset($evidencenode) && !$evidencenode instanceof Hub_Error) {
						$evidenceset = true;
					} else {
						$evidenceset = false;
					}
					if (isset($refnode) && !$refnode instanceof Hub_Error) {
						$refset = true;
					} else {
						$refset = false;
					}

					if ($issueset && $solutionset && $evidenceset) {
						echo '	  window.opener.location.href = "'.$CFG->homeAddress.'knowledgetrees.php?id='.$issuenode->nodeid.'"; }';
					} else if ($solutionset && $evidenceset && $refset) {
						echo '	  window.opener.location.href = "'.$CFG->homeAddress.'knowledgetrees.php?id='.$solutionnode->nodeid.'"; }';
					} else if ($issueset && !$solutionset && !$evidenceset && !$refset) {
						echo '	  window.opener.location.href = "'.$CFG->homeAddress.'knowledgetrees.php?id='.$issuenode->nodeid.'"; }';
					} else if ($solutionset && !$issueset && !$evidenceset && !$refset) {
						echo '	  window.opener.location.href = "'.$CFG->homeAddress.'knowledgetrees.php?id='.$solutionnode->nodeid.'"; }';
					} else if ($evidenceset && !$solutionset && !$issueset && !$refset) {
						echo '	  window.opener.location.href = "'.$CFG->homeAddress.'knowledgetrees.php?id='.$evidencenode->nodeid.'"; }';
					} else if ($refset && !$evidenceset && !$solutionset && !$issueset) {
						echo '	  window.opener.location.href = "'.$CFG->homeAddress.'knowledgetrees.php?id='.$refnode->nodeid.'"; }';
					} else {
						echo '	  window.opener.location.href = "'.$CFG->homeAddress.'user.php?id='.$USER->userid.'"; }';
					}

				echo 'window.close();';
				echo '</script>';
				include_once($HUB_FLM->getCodeDirPath("ui/dialogfooter.php"));
				die;
			}
		}
    }

	$orgs = getHGWNodesByNodeType('Organization,Project');

    $challengeset = getNodesByGlobal(0, -1 ,'name', 'ASC', "Challenge", "", 'short', "", 'all',false);
	$challanges = $challengeset->nodes;

	include_once($HUB_FLM->getCodeDirPath("ui/networknavigationlib.php"));
	include_once($HUB_FLM->getCodeDirPath("ui/popuplib.php"));

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

var noThemes = <?php if (is_countable($themesarray)) { echo count($themesarray); }  else { echo "0"; }?>;
var noResources = <?php if (is_countable($resourcetypesarray)) {  echo count($resourcetypesarray);} else { echo "0"; } ?>;


function init() {
   	$('dialogheader').insert("<?php if ($CFG->HAS_SOLUTION && $CFG->HAS_CLAIM == FALSE) {echo $LNG->FORM_COMMENT_PRACTITIONER_STORY_TITLE;} else {echo $LNG->FORM_COMMENT_STORY_TITLE;} ?>");

	addResourceEvents('next4');

	Event.observe($('resourceaddbutton'),"click", function(){
		addResourceEvents('next4');
		validateResourceNext('next4');
	});
}

function checkThemeChange(num) {
	var selected = $('theme'+num+'menu').value;
	if (selected != "" && num == noThemes-1) {
		noThemes = addTheme(noThemes);
		$('theme'+noThemes-1+'menu').focus();
	}
}

function typeChanged(num) {
	var type = $('resource'+num+'menu').value;
	if (type == "Publication") {
		$('identifierdiv-'+num).style.display = "block";
	} else {
		$('identifierdiv-'+num).style.display = "none";
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
	$('resourcenodeidsarray-'+num).value = "";

	$('typehiddendiv-'+num).style.display="none";
	$('typediv-'+num).style.display="block";
	$('resourceurldiv-'+num).style.display="block";
	$('resourcedescdiv-'+num).style.display="block";
}

function openOrgAdd() {
	loadDialog('orgadd', '<?php echo $CFG->homeAddress; ?>ui/popups/organizationadd.php', 750,600);
}

function loadSelecteditemNew(nodeid, name) {
	// add to list and select
	var option = new Element("option", {'value':nodeid});
	option.selected = true;
	option.insert(name);
	$('orgitem').insert(option);

	switchSteps(5, 5);
}

function toggleChallenges() {
	if ( $("groupsdiv").style.display == "block") {
		$("groupsdiv").style.display = "none";
		$("groupsimg").src='<?php echo $HUB_FLM->getImagePath("arrow-down2.png"); ?>';
	} else {
		$("groupsdiv").style.display = "block";
		$("groupsimg").src='<?php echo $HUB_FLM->getImagePath("arrow-up2.png"); ?>';
	}
}

function checkForm() {
	if ($('issue').value == "" && $('issuedesc').value != ""){
	   	alert("<?php echo $LNG->FORM_QUICK_ISSUE_DESC_ERROR; ?>");
	   	switchSteps(5, 1);
	  	$('issue').focus();
	   	return false;
    }
	if ($('solution').value == "" && $('solutiondesc').value != ""){
		alert("<?php echo $LNG->FORM_QUICK_SOLUTION_DESC_ERROR; ?>");
		switchSteps(5, 2);
	    $('solution').focus();
		return false;
	}
	if ($('evidence').value == "" && $('evidencedesc').value != ""){
	   	alert("<?php echo $LNG->FORM_QUICK_EVIDENCE_DESC_ERROR; ?>; ");
	   	switchSteps(5, 3);
	   	$('evidence').focus();
	   	return false;
    }

    if ($('theme0menu').value == "") {
	  	alert("<?php echo $LNG->FORM_ERROR_THEME; ?>");
	  	switchSteps(5, 5);
	   	return false;
    }

    $('issueform').style.cursor = 'wait';

	return true;
}

window.onload = init;

</script>

<?php insertFormQuickHeaderMessage(); ?>

<table style="width:100%">
	<tr>
		<td>
			<h2 style="margin-bottom:0px;margin-left:5px;"><?php echo $LNG->COMMENT_NAME; ?></h2>
			<div class="" id="commenttextareadiv" style="clear:both;float:left;width:700px;padding:5px;margin-left:5px;min-height:50px;max-height:200px;overflow-y:auto;">
				<?php echo( $text ); ?>
			</div>
		</td>
	</tr>
	<tr>
		<td>
			<form style="padding:5px;padding-top:0px; margin-top:0px;" id="issueform" name="issueform" action="" enctype="multipart/form-data" method="post" onsubmit="return checkForm();">
				<input type="hidden" id="chatnodeid" name="chatnodeid" value="<?php echo $chatnodeid; ?>" />

				<div id="stepdiv1" style="display:block">
					<?php drawNetworkNavigationBarQuickFormP("Issue"); ?>

					<div class="hgrformrow" style="padding-top:0px;margin-top:0px;">
						<span class="titles"><?php echo $LNG->QUICKFORM_P_STEP1_SECTION_HEADING; ?></span><br>
						<span><?php echo $LNG->QUICKFORM_P_STEP1_SECTION_MESSAGE; ?></span>
					</div>

					<div class="hgrformrow">
						<label  class="formlabelbig" for="issue"><?php echo $LNG->FORM_ISSUE_LABEL_SUMMARY; ?>
							<a href="javascript:void(0)" onMouseOver="showFormHint('IssueQuick', event, 'hgrhint'); return false;" onMouseOut="hideHints(); return false;" onClick="hideHints(); return false;" onkeypress="enterKeyPressed(event)"><img src="<?php echo $HUB_FLM->getImagePath('info.png'); ?>" border="0" style="margin-top: 2px; margin-left: 5px; margin-right: 2px;" /></a>
							<span style="font-size:14pt;margin-top:3px;vertical-align:middle;color:red;">*</span>
						</label>
						<input class="forminputmust hgrinput hgrwide" oninput="validateSimpleNext(this, 'next1')" onkeyup="validateSimpleNext(this, 'next1')" onchange="validateSimpleNext(this, 'next1')" id="issue" name="issue" value="<?php echo( $issue ); ?>" />
					</div>

					<?php insertDescriptionMulti($issuedesc, 'issuedesc', 'IssueDesc'); ?>

					<?php if ($CFG->HAS_CHALLENGE) { insertChallenges('IssueChallenges', true); } ?>

					<div class="hgrformrow">
						<input style="float:left" type="button" value="<?php echo $LNG->FORM_BUTTON_CANCEL; ?>" onclick="window.close();"/>
						<input style="float:right;" id="next1" disabled type="button" value="<?php echo $LNG->FORM_BUTTON_NEXT; ?>" onclick="switchSteps(5, 2);"/>
				        <input style="clear:both;float:right;" type="button" value="<?php echo $LNG->FORM_BUTTON_SKIP; ?>" onclick="switchSteps(5, 2);"/>
					</div>

				</div>

				<div id="stepdiv2" style="display:none">
					<?php drawNetworkNavigationBarQuickFormP("Solution"); ?>

					<div class="hgrformrow" style="padding-top:0px;margin-top:0px;">
						<span class="titles"><?php echo $LNG->QUICKFORM_P_STEP2_SECTION_HEADING; ?></span><br>
						<span><?php echo $LNG->QUICKFORM_P_STEP2_SECTION_MESSAGE; ?></span>
					</div>

					<div class="hgrformrow">
						<label  class="formlabelbig" for="solution"><?php echo $LNG->FORM_SOLUTION_LABEL_SUMMARY; ?>
							<a href="javascript:void(0)" onMouseOver="showFormHint('SolutionQuick', event, 'hgrhint'); return false;" onMouseOut="hideHints(); return false;" onClick="hideHints(); return false;" onkeypress="enterKeyPressed(event)"><img src="<?php echo $HUB_FLM->getImagePath('info.png'); ?>" border="0" style="margin-top: 2px; margin-left: 5px; margin-right: 2px;" /></a>
							<span style="font-size:14pt;margin-top:3px;vertical-align:middle;color:red;">*</span>
						</label>
						<input class="forminputmust hgrinput hgrwide" oninput="validateSimpleNext(this, 'next2')" onkeyup="validateSimpleNext(this, 'next2')" onchange="validateSimpleNext(this, 'next2')" id="solution" name="solution" value="<?php echo( $solution ); ?>" />
					</div>

					<?php insertDescriptionMulti($solutiondesc, 'solutiondesc', 'SolutionDesc'); ?>

					<div class="hgrformrow">
						<input style="float:left;" type="button" value="<?php echo $LNG->FORM_BUTTON_BACK; ?>" onclick="switchSteps(5, 1);"/>
						<input style="float:left; margin-left:15px;" type="button" value="<?php echo $LNG->FORM_BUTTON_CANCEL; ?>" onclick="window.close();"/>
						<input style="float:right;" id="next2" disabled type="button" value="<?php echo $LNG->FORM_BUTTON_NEXT; ?>" onclick="switchSteps(5, 3);"/>
				        <input style="Clear:both;float:right;" type="button" value="<?php echo $LNG->FORM_BUTTON_SKIP; ?>" onclick="switchSteps(5, 3);"/>
					</div>

				</div>


				<div id="stepdiv3" style="display:none">
					<?php drawNetworkNavigationBarQuickFormP("Evidence"); ?>

					<div class="hgrformrow" style="padding-top:0px;margin-top:0px;">
						<span class="titles"><?php echo $LNG->QUICKFORM_P_STEP3_SECTION_HEADING; ?>
						</span><br>
						<span style="padding-right:10px;"><?php echo $LNG->QUICKFORM_P_STEP3_SECTION_MESSAGE; ?></span>
					</div>

					<div class="hgrformrow">
						<label  class="formlabelbig" for="url"><?php echo $LNG->FORM_LABEL_EVIDENCE_TYPE; ?>
							<a href="javascript:void(0)" onMouseOver="showFormHint('EvidenceTypeQuick', event, 'hgrhint'); return false;" onMouseOut="hideHints(); return false;" onClick="hideHints(); return false;" onkeypress="enterKeyPressed(event)"><img src="<?php echo $HUB_FLM->getImagePath('info.png'); ?>" border="0" style="margin-top: 2px; margin-left: 5px; margin-right: 2px;" /></a>
							<span style="font-size:14pt;margin-top:3px;vertical-align:middle;color:red;">*</span>
						</label>
						<select class="subforminput hgrselect forminputmust" id="evidencetype" name="evidencetype">
							<?php
								$count = 0;
								if (is_countable($CFG->EVIDENCE_TYPES)) {
									$count = count($CFG->EVIDENCE_TYPES);
								}
								for($i=0; $i<$count; $i++){
									$item = $CFG->EVIDENCE_TYPES[$i];
									$name = $LNG->EVIDENCE_TYPES[$i];
								?>
									<option value='<?php echo $item; ?>' <?php if ($evidencetype == $item || ($evidencetype == "" && $item == $CFG->EVIDENCE_TYPES_DEFAULT)) { echo 'selected=\"true\"'; }  ?> ><?php echo $name; ?></option>
							<?php } ?>
						</select>
					</div>

					<div class="hgrformrow">
						<label  class="formlabelbig" for="claim"><?php echo $LNG->FORM_EVIDENCE_LABEL_SUMMARY; ?>
							<a href="javascript:void(0)" onMouseOver="showFormHint('EvidenceQuickP', event, 'hgrhint'); return false;" onMouseOut="hideHints(); return false;" onClick="hideHints(); return false;" onkeypress="enterKeyPressed(event)"><img src="<?php echo $HUB_FLM->getImagePath('info.png'); ?>" border="0" style="margin-top: 2px; margin-left: 5px; margin-right: 2px;" /></a>
							<span style="font-size:14pt;margin-top:3px;vertical-align:middle;color:red;">*</span>
						</label>
						<input class="forminputmust hgrinput hgrwide" oninput="validateSimpleNext(this, 'next3')" onkeyup="validateSimpleNext(this, 'next3')" onchange="validateSimpleNext(this, 'next3')" id="evidence" name="evidence" value="<?php echo( $evidence ); ?>" />
					</div>

					<?php insertDescriptionMulti($evidencedesc, 'evidencedesc', 'EvidenceDesc'); ?>

					<div class="hgrformrow">
						<input style="float:left;" type="button" value="<?php echo $LNG->FORM_BUTTON_BACK; ?>" onclick="switchSteps(5, 2);"/>
						<input style="float:left; margin-left:15px;" type="button" value="<?php echo $LNG->FORM_BUTTON_CANCEL; ?>" onclick="window.close();"/>
						<input style="float:right" id="next3" disabled type="button" value="<?php echo $LNG->FORM_BUTTON_NEXT; ?>" onclick="switchSteps(5, 4);"/>
				        <input style="clear:both;float:right;" type="button" value="<?php echo $LNG->FORM_BUTTON_SKIP; ?>" onclick="switchSteps(5, 4);"/>
					</div>

				</div>

				<div id="stepdiv4" style="display:none; margin-bottom:0px;padding-bottom:0px;">
					<?php drawNetworkNavigationBarQuickFormP("Resource"); ?>

					<div class="hgrformrow" style="padding-top:0px;margin-top:0px;">
						<span class="titles"><?php echo $LNG->QUICKFORM_STEP4_SECTION_HEADING; ?></span><br>
						<span><?php echo $LNG->QUICKFORM_STEP4_SECTION_MESSAGE; ?></span>
					</div>

					<?php insertResourceForm('Resources', $LNG->FORM_LABEL_EVIDENCE_RESOURCES); ?>

					<div class="hgrformrow" style="margin:0px; padding:0px;">
						<input style="float:left;" type="button" value="<?php echo $LNG->FORM_BUTTON_BACK; ?>" onclick="switchSteps(5, 3);"/>
						<input style="float:left; margin-left:15px;" type="button" value="<?php echo $LNG->FORM_BUTTON_CANCEL; ?>" onclick="window.close();"/>
						<input style="float:right;" id="next4" disabled type="button" value="<?php echo $LNG->FORM_BUTTON_NEXT; ?>" onclick="switchSteps(5, 5);"/>
						<input style="clear:both;float:right;" type="button" value="<?php echo $LNG->FORM_BUTTON_SKIP; ?>" onclick="switchSteps(5, 5);"/>
					</div>
				</div>

				<div id="stepdiv5" style="display:none">
					<?php drawNetworkNavigationBarQuickFormP("Theme"); ?>

					<div class="hgrformrow" style="padding-top:0px;margin-top:0px;">
						<span class="titles"><?php echo $LNG->QUICKFORM_STEP5_SECTION_HEADING; ?></span>
					</div>

					<div class="hgrformrow" style="padding-top:0px;margin-top:0px;">
						<span><?php echo $LNG->QUICKFORM_P_STEP5_SECTION_MESSAGE_ORG; ?></span>
					</div>

					<div class="hgrformrow" id="orgdiv" style="margin-bottom:25px;">
						<label  class="formlabelbig" for="connectionform"><span style="vertical-align:top"><?php echo $LNG->FORM_LABEL_ORG_PROJECT; ?></span>
							<span class="active" onMouseOver="showFormHint('OrgQuickR', event, 'hgrhint'); return false;" onMouseOut="hideHints(); return false;" onClick="hideHints(); return false;" onkeypress="enterKeyPressed(event)"><img src="<?php echo $HUB_FLM->getImagePath('info.png'); ?>" border="0" style="margin-top: 2px; margin-left: 5px; margin-right: 2px;" /></span>
						</label>
						<select class="forminput hgrselect" style="width: 172px;z-index:+1" id="orgitem" name="orgitem" onactivate="this.style.width='auto';">
							<option value="" ><?php echo $LNG->FORM_LABEL_ORG_PROJECT_CHOICE; ?></option>
							<?php
								foreach($orgs as $org){?>
									<option value='<?php echo $org['NodeID']; ?>' <?php if ($orgitem == $org['NodeID']) { echo 'selected=\"true\"'; } ?> ><?php echo $org['Name']; ?></option>
							<?php } ?>
						</select>

						<input style="float:left; margin-left:15px;" type="button" value="<?php echo $LNG->FORM_BUTTON_ADD_NEW; ?>" onclick="openOrgAdd()"/>
					</div>
					<br>

					<div class="hgrformrow" style="padding-top:0px;margin-top:0px;">
						<span><?php echo $LNG->QUICKFORM_P_STEP5_SECTION_MESSAGE_THEME; ?></span>
					</div>

					<?php insertThemes('ThemeQuickP'); ?>

					<div class="hgrformrow">
						<span><?php echo $LNG->QUICKFORM_P_STEP5_SECTION_MESSAGE_TAG; ?></span>
					</div>

					<?php insertAddTags('TagQuickP'); ?>

					<div class="hgrformrow">
						<input style="float:left;" type="button" value="<?php echo $LNG->FORM_BUTTON_BACK; ?>" onclick="switchSteps(5, 4);"/>
						<input style="float:right;margin-right:10px;" class="submit" type="submit" value="<?php echo $LNG->FORM_BUTTON_PUBLISH; ?>" id="publish" name="publish">
						<input style="float:left; margin-left:15px;" type="button" value="<?php echo $LNG->FORM_BUTTON_CANCEL; ?>" onclick="window.close();"/>
					</div>
				</div>
			</form>
		</td>
	</tr>
</table>

<?php
    include_once($HUB_FLM->getCodeDirPath("ui/dialogfooter.php"));
?>