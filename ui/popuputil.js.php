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
   include_once("../config.php");
?>

/**
 * Display the form hint for the given field type.
 * Returns true if the hint was found and displayed else false.
 */
function showFormHint(type, evt, panelName, extra) {

 	var event = evt || window.event;

	$("resourceMessage").innerHTML="";

	//Challenge
	if (type == "ChallengeSummary") {
		$("resourceMessage").insert("<?php echo $LNG->CHALLENGE_SUMMARY_FORM_HINT; ?>");
	} else if (type == "ChallengeTheme") {
		$("resourceMessage").insert("<?php echo $LNG->CHALLENGE_THEME_FORM_HINT; ?>");
	} else if (type == "ChallengeDesc") {
		$("resourceMessage").insert("<?php echo $LNG->CHALLENGE_DESC_FORM_HINT; ?>");
	} else if (type == "ChallengeTag") {
		$("resourceMessage").insert("<?php echo $LNG->CHALLENGE_TAG_FORM_HINT; ?>");
 	} else if (type == "ChallengeTagAdded") {
		$("resourceMessage").insert("<?php echo $LNG->CHALLENGE_TAGADDED_FORM_HINT; ?>");
 	} else if (type == "ChallengeReason") {
		$("resourceMessage").insert("<?php echo $LNG->CHALLENGE_REASON_FORM_HINT; ?>"+extra);
	} else if (type == "Challenges") {
		$("resourceMessage").insert("<?php echo $LNG->CHALLENGES_FORM_HINT; ?>"+extra);

	// Issues
	} else if (type == "IssueSummary") {
		$("resourceMessage").insert("<?php echo $LNG->ISSUE_SUMMARY_FORM_HINT; ?>");
	} else if (type == "IssueDesc") {
		$("resourceMessage").insert("<?php echo $LNG->ISSUE_DESC_FORM_HINT; ?>");
	} else if (type == "IssueChallenges") {
		$("resourceMessage").insert("<?php echo $LNG->ISSUE_CHALLENGES_FORM_HINT; ?>");
	} else if (type == "IssueTheme") {
		$("resourceMessage").insert("<?php echo $LNG->ISSUE_THEME_FORM_HINT; ?>");
	} else if (type == "IssueTag") {
		$("resourceMessage").insert("<?php echo $LNG->ISSUE_TAG_FORM_HINT; ?>");
	} else if (type == "IssueTagAdded") {
		$("resourceMessage").insert("<?php echo $LNG->ISSUE_TAGADDED_FORM_HINT; ?>");
	} else if (type == "IssueReason") {
		$("resourceMessage").insert("<?php echo $LNG->ISSUE_REASON_FORM_HINT; ?>"+extra);
	} else if (type == "IssueOtherChallenge") {
		$("resourceMessage").insert("<?php echo $LNG->ISSUE_OTHERCHALLENGE_FORM_HINT; ?>");
	} else if (type == "IssueResource") {
		$("resourceMessage").insert("<?php echo $LNG->ISSUE_RESOURCE_FORM_HINT; ?>");

	// Solutions
	} else if (type == "SolutionSummary") {
		$("resourceMessage").insert("<?php echo $LNG->SOLUTION_SUMMARY_FORM_HINT; ?>");
	} else if (type == "SolutionTheme") {
		$("resourceMessage").insert("<?php echo $LNG->THEME_SUMMARY_FORM_HINT; ?>");
	} else if (type == "SolutionPro") {
		$("resourceMessage").insert("<?php echo $LNG->SOLUTION_PRO_FORM_HINT; ?>");
	} else if (type == "SolutionCon") {
		$("resourceMessage").insert("<?php echo $LNG->SOLUTION_CON_FORM_HINT; ?>");
	} else if (type == "SolutionDesc") {
		$("resourceMessage").insert("<?php echo $LNG->SOLUTION_DESC_FORM_HINT; ?>");
	} else if (type == "SolutionTag") {
		$("resourceMessage").insert("<?php echo $LNG->SOLUTION_TAG_FORM_HINT; ?>");
	} else if (type == "SolutionTagAdded") {
		$("resourceMessage").insert("<?php echo $LNG->SOLUTION_TAGADDED_FORM_HINT; ?>");
 	} else if (type == "SolutionReason") {
		$("resourceMessage").insert("<?php echo $LNG->SOLUTION_REASON_FORM_HINT; ?>"+extra);

	// Claims
	} else if (type == "ClaimSummary") {
		$("resourceMessage").insert("<?php echo $LNG->CLAIM_SUMMARY_FORM_HINT; ?>");
	} else if (type == "ClaimTheme") {
		$("resourceMessage").insert("<?php echo $LNG->CLAIM_THEME_FORM_HINT; ?>");
	} else if (type == "ClaimDesc") {
		$("resourceMessage").insert("<?php echo $LNG->CLAIM_DESC_FORM_HINT; ?>");
	} else if (type == "ClaimReason") {
		$("resourceMessage").insert("<?php echo $LNG->CLAIM_RESAON_FORM_HINT; ?>"+extra);
	} else if (type == "ClaimTag") {
		$("resourceMessage").insert("<?php echo $LNG->CLAIM_TAG_FORM_HINT; ?>");
	} else if (type == "ClaimTagAdded") {
		$("resourceMessage").insert("<?php echo $LNG->CLAIM_TAGADDED_FORM_HINT; ?>");

	// Evidence
	} else if (type == "EvidenceSummary") {
		$("resourceMessage").insert("<?php echo $LNG->EVIDENCE_SUMMARY_FORM_HINT; ?>");
	} else if (type == "EvidenceDesc") {
		$("resourceMessage").insert("<?php echo $LNG->EVIDENCE_DESC_FORM_HINT; ?>");
	} else if (type == "EvidenceWebsites") {
		$("resourceMessage").insert("<?php echo $LNG->EVIDENCE_WEBSITE_FORM_HINT; ?>");
	} else if (type == "EvidenceTheme") {
		$("resourceMessage").insert("<?php echo $LNG->EVIDENCE_THEME_FORM_HINT; ?>");
	} else if (type == "EvidenceType") {
		$("resourceMessage").insert("<?php echo $LNG->EVIDENCE_TYPE_FORM_HINT; ?>");
 	} else if (type == "EvidenceTag") {
		$("resourceMessage").insert("<?php echo $LNG->EVIDENCE_TAG_FORM_HINT; ?>");
 	} else if (type == "EvidenceTagAdded") {
		$("resourceMessage").insert("<?php echo $LNG->EVIDENCE_TAGADDED_FORM_HINT; ?>");
	} else if (type == "EvidenceReason") {
		$("resourceMessage").insert("<?php echo $LNG->EVIDENCE_REASON_FORM_HINT; ?>"+extra);
	} else if (type == "EvidenceProjects") {
		$("resourceMessage").insert("<?php echo $LNG->EVIDENCE_PROJECT_FORM_HINT; ?>");
	} else if (type == "EvidenceOrganizations") {
		$("resourceMessage").insert("<?php echo $LNG->EVIDENCE_ORG_FORM_HINT; ?>");

	// Resource
	} else if (type == "Resources") {
		$("resourceMessage").insert("<?php echo $LNG->RESOURCES_FORM_HINT; ?>");
	} else if (type == "RemoteEvidenceResources") {
		$("resourceMessage").insert("<?php echo $LNG->RESOURCES_REMOTE_FORM_HINT; ?>");
	} else if (type == "OrgResources") {
		$("resourceMessage").insert("<?php echo $LNG->RESOURCES_ORG_FORM_HINT; ?>");
	} else if (type == "ResourceClip") {
		$("resourceMessage").insert("<?php echo $LNG->RESOURCES_CLIP_FORM_HINT; ?>");
	} else if (type == "ResourceType") {
		$("resourceMessage").insert("<?php echo $LNG->RESOURCES_TYPE_FORM_HINT; ?>");
	} else if (type == "ResourceTheme") {
		$("resourceMessage").insert("<?php echo $LNG->RESOURCES_THEME_FORM_HINT; ?>");
	} else if (type == "ResourceTitle") {
		$("resourceMessage").insert("<?php echo $LNG->RESOURCES_TITLE_FORM_HINT; ?>");
	} else if (type == "ResourceURL") {
		$("resourceMessage").insert("<?php echo $LNG->RESOURCES_URL_FORM_HINT; ?>");
	} else if (type == "ResourceDOI") {
		$("resourceMessage").insert("<?php echo $LNG->RESOURCES_DOI_FORM_HINT; ?>");
	} else if (type == "ResourceTag") {
		$("resourceMessage").insert("<?php echo $LNG->RESOURCES_TAG_FORM_HINT; ?>");
 	} else if (type == "ResourceTagAdded") {
		$("resourceMessage").insert("<?php echo $LNG->RESOURCES_TAGADDED_FORM_HINT; ?>");
	} else if (type == "ResourceReason") {
		$("resourceMessage").insert("<?php echo $LNG->RESOURCES_REASON_FORM_HINT; ?>"+extra);
	} else if (type == "ResourceProjects") {
		$("resourceMessage").insert("<?php echo $LNG->RESOURCE_PROJECT_FORM_HINT; ?>"+extra);
	} else if (type == "ResourceOrganizations") {
		$("resourceMessage").insert("<?php echo $LNG->RESOURCE_ORG_FORM_HINT; ?>"+extra);

	// organization / project
	} else if (type == "OrgType") {
		$("resourceMessage").insert("<?php echo $LNG->ORG_TYPE_FORM_HINT; ?>");
	} else if (type == "OrgTown") {
		$("resourceMessage").insert("<?php echo $LNG->ORG_TOWN_FORM_HINT; ?>");
	} else if (type == "OrgCountry") {
		$("resourceMessage").insert("<?php echo $LNG->ORG_COUNTRY_FORM_HINT; ?>");
	} else if (type == "OrgTheme") {
		$("resourceMessage").insert("<?php echo $LNG->ORG_THEME_FORM_HINT; ?>");
	} else if (type == "OrgName") {
		$("resourceMessage").insert("<?php echo $LNG->ORG_NAME_FORM_HINT; ?>");
	} else if (type == "OrgPartner") {
		$("resourceMessage").insert("<?php echo $LNG->ORG_PARTNER_FORM_HINT; ?>");
	} else if (type == "OrgDesc") {
		$("resourceMessage").insert("<?php echo $LNG->ORG_DESC_FORM_HINT; ?>");
	} else if (type == "OrgWebsites") {
		$("resourceMessage").insert("<?php echo $LNG->ORG_WEBSITE_FORM_HINT; ?>");
	} else if (type == "OrgDates") {
		$("resourceMessage").insert("<?php echo $LNG->ORG_DATE_FORM_HINT; ?>");
	} else if (type == "OrgChallenges") {
		$("resourceMessage").insert("<?php echo $LNG->ORG_CHALLENGES_FORM_HINT; ?>");
	} else if (type == "OrgProjects") {
		$("resourceMessage").insert("<?php echo $LNG->ORG_PROJECT_FORM_HINT; ?>");
	} else if (type == "OrgTag") {
		$("resourceMessage").insert("<?php echo $LNG->ORG_TAG_FORM_HINT; ?>");
 	} else if (type == "OrgTagAdded") {
		$("resourceMessage").insert("<?php echo $LNG->ORG_TAGADDED_FORM_HINT; ?>");
	} else if (type == "OrgReason") {
		$("resourceMessage").insert("<?php echo $LNG->ORG_REASON_FORM_HINT; ?>"+extra);
	} else if (type == "OrgProject") {
		$("resourceMessage").insert("<?php echo $LNG->ORG_PROJECTS_FORM_HINT; ?>");
	} else if (type == "OrgOrg") {
		$("resourceMessage").insert("<?php echo $LNG->ORG_ORGS_FORM_HINT; ?>");

	// Comments
 	} else if (type == "CommentTag") {
		$("resourceMessage").insert("<?php echo $LNG->COMMENT_TAG_FORM_HINT; ?>");
 	} else if (type == "CommentTagsAdded") {
		$("resourceMessage").insert("<?php echo $LNG->COMMENT_TAGADDED_FORM_HINT; ?>");
	} else if (type == "CommentDesc") {
		$("resourceMessage").insert("<?php echo $LNG->COMMENT_DESC_FORM_HINT; ?>");


	// REMOTE FORMS
 	} else if (type == "RemoteEvidenceSolution") {
		$("resourceMessage").insert("<?php echo $LNG->REMOTE_EVIDENCE_SOLUTION_FORM_HINT; ?>");
	} else if (type == "RemoteEvidenceClaim") {
		$("resourceMessage").insert("<?php echo $LNG->REMOTE_EVIDENCE_CLAIM_FORM_HINT; ?>");
	} else if (type == "RemoteEvidenceDesc") {
		$("resourceMessage").insert("<?php echo $LNG->REMOTE_EVIDENCE_DESC_FORM_HINT; ?>");
	} else if (type == "RemoteEvidenceType") {
		$("resourceMessage").insert("<?php echo $LNG->REMOTE_EVIDENCE_TYPE_FORM_HINT; ?>");

	// QUICK FORMS
	} else if (type == "ThemeQuickP") {
		$("resourceMessage").insert("<?php echo $LNG->THEME_P_QUICKFORM_HINT; ?>");
	} else if (type == "ThemeQuickR") {
		$("resourceMessage").insert("<?php echo $LNG->THEME_R_QUICKFORM_HINT; ?>");
	} else if (type == "TagQuickP") {
		$("resourceMessage").insert("<?php echo $LNG->TAG_P_QUICKFORM_HINT; ?>");
	} else if (type == "TagQuickR") {
		$("resourceMessage").insert("<?php echo $LNG->TAG_R_QUICKFORM_HINT; ?>");
	} else	if (type == "IssueQuick") {
		$("resourceMessage").insert("<?php echo $LNG->ISSUE_SUMMARY_QUICKFORM_HINT; ?>");
	} else if (type == "SolutionQuick") {
		$("resourceMessage").insert("<?php echo $LNG->SOLUTION_SUMMARY_QUICKFORM_HINT; ?>");
	} else if (type == "ClaimQuick") {
		$("resourceMessage").insert("<?php echo $LNG->CLAIM_SUMMARY_QUICKFORM_HINT; ?>");
	} else if (type == "EvidenceQuickP") {
		$("resourceMessage").insert("<?php echo $LNG->EVIDENCE_P_QUICKFORM_HINT; ?>");
	} else if (type == "EvidenceQuickR") {
		$("resourceMessage").insert("<?php echo $LNG->EVIDENCE_R_QUICKFORM_HINT; ?>");
	} else if (type == "EvidenceTypeQuick") {
		$("resourceMessage").insert("<?php echo $LNG->EVIDENCE_TYPE_QUICKFORM_HINT; ?>");
	} else if (type == "OrgQuickP") {
		$("resourceMessage").insert("<?php echo $LNG->ORG_P_QUICKFORM_HINT; ?>");
	} else if (type == "OrgQuickR") {
		$("resourceMessage").insert("<?php echo $LNG->ORG_R_QUICKFORM_HINT; ?>");

	// OTHER
	} else if (type == "CompendiumTheme") {
		$("resourceMessage").insert("<?php echo $LNG->IMPORT_COMPENDIUM_THEME_FORM_HINT; ?>");
	} else if (type == "BibtexTheme") {
		$("resourceMessage").insert("<?php echo $LNG->IMPORT_BIBTEX_THEME_FORM_HINT; ?>");
	} else {
		return false;
	}



	showHint(event, panelName, 10, -10);

	return true;
}

/**
 * Display the quick form navigation hint for the given field type.
 * Returns true if the hint was found and displayed else false.
 */
function showQuickFormNavHint(type, evt, panelName, extra) {

 	var event = evt || window.event;

	$("resourceMessage").innerHTML="";

	if (type == "IssueQuickForm") {
		$('resourceMessage').insert("<?php echo $LNG->ISSUE_QUICKFORM_NAV_HINT; ?>");
	} else if (type == "SolutionQuickForm") {
		$('resourceMessage').insert("<?php echo $LNG->SOLUTION_QUICKFORM_NAV_HINT; ?>");
	} else if (type == "ClaimQuickForm") {
		$('resourceMessage').insert("<?php echo $LNG->CLAIM_QUICKFORM_NAV_HINT; ?>");
	} else if (type == "EvidenceQuickForm") {
		$('resourceMessage').insert("<?php echo $LNG->EVIDENCE_QUICKFORM_NAV_HINT; ?>");
	} else if (type == "ResourceQuickForm") {
		$('resourceMessage').insert("<?php echo $LNG->RESOURCE_QUICKFORM_NAV_HINT; ?>");
	} else if (type == "ThemeQuickForm") {
		$('resourceMessage').insert("<?php echo $LNG->THEME_QUICKFORM_NAV_HINT; ?>");
	} else {
		return false;
	}

	showHint(event, panelName, 10, -10);


	return true;
}

/**
 * Remove the given multiple for the given type at the given index
 */
function removeMultiple(key, i) {
	var answer = confirm("<?php echo $LNG->FORM_REMOVE_MULTI; ?>");
    if(answer){
		if ($(key+'form') && $(key+'field'+i)) {
		    if(	$(key+'form').childElements()[0].nodeName.toUpperCase() != "HR"){
			    $(key+'field'+i).remove();
			    try {
			        $(key+'hr'+ i).remove();
			    } catch (err) {
			        // do nowt
			    }
			    if($(key+'form').childElements()[0] && $(key+'form').childElements()[0].nodeName.toUpperCase() == "HR"){
			        $(key+'form').childElements()[0].remove();
			    }
		    }
		}
    }
    return;
}

/**
 * Add another resource block
 */
function addResource(noResources) {
	if($('resourceform').childElements().length != 0){
	    $('resourceform').insert('<hr id="resourcehr'+noResources+'" class="urldivider"/>');
	}

	var newitem = '<div id="resourcefield'+noResources+'" class="subformrow">';

    newitem += '<input type="hidden" id="resourcenodeidsarray-'+noResources+'" name="resourcenodeidsarray[]" value="" />';

	newitem += '<div class="subformrow" id="typehiddendiv-'+noResources+'" style="display:none">';
	newitem += '<label  class="hgrsubformlabel" for="connection-'+noResources+'"><?php echo $LNG->FORM_LABEL_TYPE; ?>';
	newitem += '</label>';
	newitem += '<select disabled onchange="typeChangedResource(\''+noResources+'\')" class="subforminput hgrselect" style="width: 172px" id="resource'+noResources+'label" name="resourcetypeslabelarray[]">';
	const count = RESOURCE_TYPES.length;
	for(let i=0; i<count; i++){
		let item = RESOURCE_TYPES[i];
		if (item == '<?php echo $CFG->RESOURCE_TYPES_DEFAULT; ?>') {
			newitem += '<option selected="true" value="'+item+'">'+RESOURCE_TYPE_NAMES[i]+'</option>';
		} else {
			newitem += '<option value="'+item+'">'+RESOURCE_TYPE_NAMES[i]+'</option>';
		}
	}
	newitem += '</select>';
	newitem += '<span class="active" onClick="javascript: removeSelectedResource(\''+noResources+'\')" class="form" style="margin-left: 15px;"><?php echo $LNG->FORM_BUTTON_REMOVE; ?></span>';
	newitem += '<span class="active" onClick="javascript: openResourceSelector(\''+noResources+'\')" class="form" style="margin-left: 10px;"><?php echo $LNG->FORM_BUTTON_CHANGE; ?></span>';
	newitem += '</div>';

	newitem += '<div class="subformrow" id="typediv-'+noResources+'">';
	newitem += '<label  class="hgrsubformlabel"><?php echo $LNG->FORM_LABEL_TYPE; ?>';
	newitem += '<a href="javascript:void(0)" onMouseOver="showFormHint(\'ResourceType\', event, \'hgrhint\'); return false;" onMouseOut="hideHints(); return false;" onClick="hideHints(); return false;" onkeypress="enterKeyPressed(event)"><img src="<?php echo $HUB_FLM->getImagePath('info.png'); ?>" border="0" style="margin-top: 2px; margin-left: 5px; margin-right: 2px;" /></a>';
	newitem += '<span style="font-size:14pt;margin-top:3px;vertical-align:middle;color:red;">*</span>';
	newitem += '</label>';
	newitem += '<select onchange="typeChangedResource(\''+noResources+'\')" class="subforminput hgrselect forminputmust" style="width: 172px" id="resource'+noResources+'menu" name="resourcetypesarray[]">';

	for(let i=0; i<count; i++){
		let item = RESOURCE_TYPES[i];
		if (item == '<?php echo $CFG->RESOURCE_TYPES_DEFAULT; ?>') {
			newitem += '<option selected="true" value="'+item+'">'+RESOURCE_TYPE_NAMES[i]+'</option>';
		} else {
			newitem += '<option value="'+item+'">'+RESOURCE_TYPE_NAMES[i]+'</option>';
		}
	}

	newitem += '</select>';
	newitem += '<span class="active" onClick="javascript: openResourceSelector(\''+noResources+'\')" class="form" style="margin-left: 15px;"><?php echo $LNG->FORM_RESOURCE_SELECT_EXISTING; ?></span>';
	newitem += '</div>';

	newitem += '<div class="hgrsubformrow" id="resourceurldiv-'+noResources+'">';
	newitem += '<label  class="hgrsubformlabel" for="resourceurl-'+noResources+'"><?php echo $LNG->FORM_LABEL_URL; ?>';
	newitem += '<a href="javascript:void(0)" onMouseOver="showFormHint(\'ResourceURL\', event, \'hgrhint\'); return false;" onMouseOut="hideHints(); return false;" onClick="hideHints(); return false;" onkeypress="enterKeyPressed(event)"><img src="<?php echo $HUB_FLM->getImagePath('info.png'); ?>" border="0" style="margin-top: 2px; margin-left: 5px; margin-right: 2px;" /></a>';
	newitem += '<span style="font-size:14pt;margin-top:3px;vertical-align:middle;color:red;">*</span>';
	newitem += '</label>';
	newitem += '<input class="subforminput forminputmust" style="width: 320px;" id="resourceurl-'+noResources+'" name="resourceurlarray[]" value="http://">';
	newitem += '<img class="active" style="vertical-align: middle; padding-bottom: 2px; margin-left:4px;" title="<?php echo $LNG->FORM_AUTOCOMPLETE_TITLE_HINT; ?>" src="<?php echo $HUB_FLM->getImagePath('autofill.png'); ?>" onClick="autoCompleteWebsiteDetailsMulti(\''+noResources+'\')" onkeypress="enterKeyPressed(event)" />';
	newitem += '</div>';

	newitem += '<div class="hgrsubformrow">';
	newitem += '<label  class="hgrsubformlabel" for="resourcetitle-'+noResources+'"><?php echo $LNG->FORM_LABEL_TITLE; ?>';
	newitem += '<a href="javascript:void(0)" onMouseOver="showFormHint(\'ResourceTitle\', event, \'hgrhint\'); return false;" onMouseOut="hideHints(); return false;" onClick="hideHints(); return false;" onkeypress="enterKeyPressed(event)"><img src="<?php echo $HUB_FLM->getImagePath('info.png'); ?>" border="0" style="margin-top: 2px; margin-left: 5px; margin-right: 2px;" /></a>';
	newitem += '<span style="font-size:14pt;margin-top:3px;vertical-align:middle;color:red;">*</span>';
	newitem += '</label>';
	newitem += '<input class="subforminput forminputmust" style="width: 350px;" id="resourcetitle-'+noResources+'" name="resourcetitlearray[]" value="">';
	newitem += '</div>';

	newitem += '<div id="identifierdiv-'+noResources+'" class="hgrsubformrow" style="display: none;">';
	newitem += '<label  class="hgrsubformlabel" for="identifier-'+noResources+'"><?php echo $LNG->FORM_LABEL_DOI; ?>';
	newitem += '<a href="javascript:void(0)" onMouseOver="showFormHint(\'DOI\', event, \'hgrhint\'); return false;" onMouseOut="hideHints(); return false;" onClick="hideHints(); return false;" onkeypress="enterKeyPressed(event)"><img src="<?php echo $HUB_FLM->getImagePath('info.png'); ?>" border="0" style="margin-top: 2px; margin-left: 5px; margin-right: 2px;" /></a>';
	newitem += '</label>';
	newitem += '<input class="subforminput" style="width: 350px;" id="identifier-'+noResources+'" name="identifierarray[]" value="">';
	newitem += '</div>';

	newitem += '<div class="hgrsubformrow" id="resourcedescdiv-'+noResources+'">';
	newitem += '<input type="hidden" id="resourcecliparray-'+noResources+'" name="resourcecliparray[]" value="" />';
	newitem += '<a id="resourceremovebutton-'+noResources+'" href="javascript:void(0)" onclick="javascript:removeMultiple(\'resource\', \''+noResources+'\')" class="form" style="clear:both;float:right"><?php echo $LNG->FORM_BUTTON_REMOVE; ?></a><br>';
	newitem += '</div>';

	newitem += '</div>';

	$('resourceform').insert(newitem);

	noResources++;

	return noResources;
}

function addResourceEvents(targetname) {
	for (var i=0; i<noResources; i++) {
		if ($('resourceremovebutton-'+i)) {
			Event.observe($('resourceremovebutton-'+i),"click", function(){
				validateResourceNext(targetname);
			});
			Event.stopObserving('resourceremovebutton-'+i,'keyup');
			Event.observe($('resourceremovebutton-'+i),"keyup", function(){
				validateResourceNext(targetname);
			});
		}

		if ($('resourceurl-'+i)) {
			Event.stopObserving('resourceurl-'+i,'input');
			Event.stopObserving('resourceurl-'+i,'change');
			Event.stopObserving('resourceurl-'+i,'keyup');
			Event.observe($('resourceurl-'+i),"input", function(){
				validateResourceNext(targetname);
			});
			Event.observe($('resourceurl-'+i),"change", function(){
				validateResourceNext(targetname);
			});
			Event.observe($('resourceurl-'+i),"keyup", function(){
				validateResourceNext(targetname);
			});
		}

		if ($('resourcetitle-'+i)) {
			Event.stopObserving('resourcetitle-'+i,'input');
			Event.stopObserving('resourcetitle-'+i,'change');
			Event.stopObserving('resourcetitle-'+i,'keyup');
			Event.observe($('resourcetitle-'+i),"input", function(){
				validateResourceNext(targetname);
			});
			Event.observe($('resourcetitle-'+i),"change", function(){
				validateResourceNext(targetname);
			});
			Event.observe($('resourcetitle-'+i),"keyup", function(){
				validateResourceNext(targetname);
			});
		}
	}
}

function validateResourceNext(targetname) {
	var allBlank = true;
	for (var i=0; i<noResources; i++) {
		if ($('resourceurl-'+i)) {
			if ( $('resourceurl-'+i).value.trim() != ''
				&& $('resourceurl-'+i).value.trim() != 'http://'
				&& $('resourcetitle-'+i).value.trim() != '') {
				allBlank = false;
			}
		}
	}

	if ($(targetname)) {
		if (!allBlank) {
			$(targetname).removeAttribute('disabled');
		} else {
			$(targetname).setAttribute('disabled', 'true');
		}
	}
}

function validateSimpleNext(obj, targetname) {
	if (obj.value.trim() != '') {
		$(targetname).removeAttribute('disabled');
	} else {
		$(targetname).setAttribute('disabled', 'true');
	}
}

function openResourceSelector(num) {
	loadDialog('selector', URL_ROOT+"ui/popups/selector.php?num="+num+"&handler=addSelectedResource&filternodetypes="+encodeURIComponent(RESOURCE_TYPES_STR), 420, 730);
}

/**
 * Add another related item block
 */
function addSeeAlso(noRelated) {
	if($('relatedform')) {
		if ($('relatedform').childElements().length != 0){
		    $('relatedform').insert('<hr id="relatedhr'+noRelated+'" class="urldivider"/>');
		}

		var newitem = '<div id="relatedfield'+noRelated+'" class="subformrow">';

		newitem += '<input type="hidden" id="relatednodeidsarray-'+noRelated+'" name="relatednodeidsarray[]" value="" />';

		newitem += '<div class="subformrow" id="relatedhiddendiv-'+noRelated+'" style="display:none">';
		newitem += '<input class="subforminput forminputmust" style="width: 320px;" id="relatedtitle-'+noRelated+'" name="relatedtitlearray[]" value="">';
		newitem += '<span class="active" onClick="javascript: removeSelectedRelatedItem(\''+noRelated+'\')" class="form" style="margin-left: 15px;"><?php echo $LNG->FORM_BUTTON_REMOVE; ?></span>';
		newitem += '<span class="active" onClick="javascript: openRelatedItemSelector(\''+noRelated+'\')" class="form" style="margin-left: 10px;"><?php echo $LNG->FORM_BUTTON_CHANGE; ?></span>';
		newitem += '</div>';

		newitem += '<div class="subformrow" id="typediv-'+noRelated+'">';
		newitem += '<input class="subforminput forminputmust" style="width: 320px;" id="relatedtitle-'+noRelated+'" name="relatedtitlearray[]" value="">';
		newitem += '<span class="active" onClick="javascript: openRelatedItemSelector(\''+noRelated+'\')" class="form" style="margin-left: 15px;"><?php echo $LNG->FORM_RESOURCE_SELECT_EXISTING; ?></span>';
		newitem += '</div>';

		newitem += '</div>';

		$('relatedform').insert(newitem);
		noRelated++;
	}

	return noRelated;
}

function openRelatedItemSelector(num) {
	loadDialog('selector', URL_ROOT+"ui/popups/selector.php?num="+num+"&handler=addSelectedRelatedItem&filternodetypes="+encodeURIComponent(BASE_TYPES_STR)+","+encodeURIComponent(EVIDENCE_TYPES_STR)+","+encodeURIComponent(RESOURCE_TYPES_STR), 420, 730);
}


//add another theme field
function addTheme(noThemes) {
	if($('themeform').childElements().length != 0){
        $('themeform').insert('<hr id="themehr'+noThemes+'" class="urldivider"/>');
    }

	var newitem =  '<div id="themefield'+noThemes+'" class="subformrow">';

	newitem += '<select class="subforminput hgrselect" onchange="checkThemeChange('+noThemes+')" id="theme'+noThemes+'menu" name="themesarray[]">';
	newitem += "<option value='' ><?php echo $LNG->THEME_NAME; ?>...</option>";
	<?php
        foreach($CFG->THEMES as $item){?>
            newitem += '<option value="<?php echo addslashes($item); ?>"><?php echo addslashes($item) ?></option>';
    <?php } ?>
	newitem += '</select>';
	newitem += '<a href="javascript:removeMultiple(\'theme\', '+noThemes+')" class="form" style="margin-left: 5px;"><?php echo $LNG->FORM_BUTTON_REMOVE; ?></a>';

	newitem += '</div>';

    $('themeform').insert(newitem);

    noThemes++;

    return noThemes;
}

//add another url field
function addURL(noURLs){
	if($('urlform').childElements().length != 0){
        $('urlform').insert('<hr id="urlhr'+noURLs+'" class="urldivider"/>');
    }

	var newitem = '<div id="urlfield'+noURLs+'" class="subformrow">';
	newitem += '<input type="hidden" id="resourceids-'+noURLs+'" name="resourceids[]" value="" />';
	newitem += '<input type="hidden" id="resourcedescs-'+noURLs+'" name="resourcedescs[]" value="" />';
 	newitem += '<input type="button" id="resourceadd-'+noURLs+'" title="<?php echo $LNG->FORM_SELECT_RESOURCE_HINT; ?>" onclick="javascript: openPicker(\''+noURLs+'\');" value="<?php echo $LNG->FORM_BUTTON_ADD; ?>" />';
	newitem += '<input readonly class="subforminput hgrinput" style="background: white;border:none;width:332px;" id="resourcenames-'+noURLs+'" name="$resourcenames[]" value="" />';
	newitem += '<input type="button" id="resourceremove-'+noURLs+'" style="visibility:hidden;margin-left:3px;" onclick="javascript:removeMultiple(\'url\', '+noURLs+')" class="form" value="<?php echo $LNG->FORM_BUTTON_REMOVE; ?>" />';
	newitem += '</div>';

    $('urlform').insert(newitem);

    noURLs++;

    return noURLs;
}

// add a Project
function addProject(noProjects, nodename, nodeid){

	// Add the new item into the current box
	if ($('projectfield'+noProjects)) {
		$('projectfield'+noProjects).innerHTML = "";
	}

	let	newitem = '<input type="hidden" id="projectnodeidsarray-'+noProjects+'" name="projectnodeidsarray[]" value="'+nodeid+'" />';
	newitem += '<input readonly class="subforminput forminputmust" style="width: 360px;" id="projectnamesarray-'+noProjects+'" name="projectnamesarray[]" value="'+nodename+'" />';
	newitem += '<span class="active" onClick="javascript: removeSelectedNode(\'Project\','+noProjects+')" class="form" style="margin-left: 15px;"><?php echo $LNG->FORM_BUTTON_REMOVE; ?></span>';

	$('projectfield'+noProjects).insert(newitem);

	// Add the new selector section
	noProjects++;

	let	newselector = '<div id="projectfield'+noProjects+'" class="subformrow" style="padding-bottom:5px;padding-top:5px;">';
	newselector += '<div id="projectaddbutton" class="formsubmit form active" onclick="javascript:openProjectSelector('+noProjects+');"><?php echo $LNG->FORM_PROJECT_SELECT_EXISTING; ?></div>';
	newselector += '</div>';

	$('projectform').insert(newselector);

    return noProjects;
}

// remove a Project
function removeProject(removeProjectNo){

	let removed = false;
	if($('projectform').childElements().length != 1){
		var parent = document.getElementById('projectform');
		var child = document.getElementById('projectfield'+removeProjectNo);

		if (child) {
			parent.removeChild(child);
		}
		removed = true;
	}
    return removed;
}


// add an Organization
function addOrganization(noOrganisations, nodename, nodeid){

	// Add the new item into the current box
	if ($('orgfield'+noOrganisations)) {
		$('orgfield'+noOrganisations).innerHTML = "";
	}

	let	newitem = '<input type="hidden" id="orgnodeidsarray-'+noOrganisations+'" name="orgnodeidsarray[]" value="'+nodeid+'" />';
	newitem += '<input readonly class="subforminput forminputmust" style="width: 360px;" id="orgnamesarray-'+noOrganisations+'" name="orgnamesarray[]" value="'+nodename+'" />';
	newitem += '<span class="active" onClick="javascript: removeSelectedNode(\'Organization\','+noOrganisations+')" class="form" style="margin-left: 15px;"><?php echo $LNG->FORM_BUTTON_REMOVE; ?></span>';

	$('orgfield'+noOrganisations).insert(newitem);

	// Add the new selector section
	noOrganisations++;

	let	newselector = '<div id="orgfield'+noOrganisations+'" class="subformrow" style="padding-bottom:5px;padding-top:5px;">';
	newselector += '<div id="orgaddbutton" class="formsubmit form active" onclick="javascript:openOrganizationSelector('+noOrganisations+');"><?php echo $LNG->FORM_ORG_SELECT_EXISTING; ?></div>';
	newselector += '</div>';

	$('orgform').insert(newselector);

    return noOrganisations;
}

// remove an Organization
function removeOrganization(removeOrgNo){

	let removed = false;
	if($('orgform').childElements().length != 1){
		var parent = document.getElementById('orgform');
		var child = document.getElementById('orgfield'+removeOrgNo);

		if (child) {
			parent.removeChild(child);
		}
		removed = true;
	}
    return removed;
}


// add an Evidence item
function addEvidence(noEvidence, nodename, nodeid){

	// Add the new item into the current box
	if ($('evidencefield'+noEvidence)) {
		$('evidencefield'+noEvidence).innerHTML = "";
	}

	let	newitem = '<input type="hidden" id="evidencenodeidsarray-'+noEvidence+'" name="evidencenodeidsarray[]" value="'+nodeid+'" />';
	newitem += '<input readonly class="subforminput forminputmust" style="width: 360px;" id="evidencenamesarray-'+noEvidence+'" name="evidencenamesarray[]" value="'+nodename+'" />';
	newitem += '<span class="active" onClick="javascript: removeSelectedNode(\'Evidence\','+noEvidence+')" class="form" style="margin-left: 15px;"><?php echo $LNG->FORM_BUTTON_REMOVE; ?></span>';

	$('evidencefield'+noEvidence).insert(newitem);

	// Add the new selector section
	noEvidence++;

	let	newselector = '<div id="evidencefield'+noEvidence+'" class="subformrow" style="padding-bottom:5px;padding-top:5px;">';
	newselector += '<div id="evidenceaddbutton" class="formsubmit form active" onclick="javascript:openEvidenceSelector('+noEvidence+');"><?php echo $LNG->FORM_EVIDENCE_SELECT_EXISTING; ?></div>';
	newselector += '</div>';

	$('evidenceform').insert(newselector);

    return noEvidence;
}

// remove an Evidence item
function removeEvidence(removeEvidenceNo){

	let removed = false;
	if($('evidenceform').childElements().length != 1){
		var parent = document.getElementById('evidenceform');
		var child = document.getElementById('evidencefield'+removeEvidenceNo);

		if (child) {
			parent.removeChild(child);
		}
		removed = true;
	}
    return removed;
}

/*function addProject(noProjects){
	if($('projectform').childElements().length != 0){
        $('projectform').insert('<hr id="projecthr'+noProjects+'" class="projectdivider"/>');
    }

	var newitem = '<div id="projectfield'+noProjects+'" class="subformrow">';
	newitem += '<input type="hidden" id="projectids-'+noProjects+'" name="projectids[]" value="" />';
	newitem += '<input type="hidden" id="projectdescs-'+noProjects+'" name="projectdescs[]" value="" />';
 	newitem += '<input type="button" id="projectadd-'+noProjects+'" onclick="javascript: openProjectPicker(\''+noProjects+'\');" value="<?php echo $LNG->FORM_BUTTON_ADD; ?>" />';
	newitem += '<input readonly class="subforminput hgrinput" style="background: white;border:none;width:332px;" id="projectnames-'+noProjects+'" name="$projectnames[]" value="" />';
	newitem += '<input type="button" id="projectremove-'+noProjects+'" style="visibility:hidden;margin-left:3px;" onclick="javascript:removeMultiple(\'project\', '+noProjects+')" class="form" value="<?php echo $LNG->FORM_BUTTON_REMOVE; ?>" />';
	newitem += '</div>';

    $('projectform').insert(newitem);

    noProjects++;

    return noProjects;
}*/

//add a partner organization
function addPartner(noPartners) {
	if($('partnerform').childElements().length != 0){
        $('partnerform').insert('<hr id="partnerhr'+noPartners+'" class="urldivider"/>');
    }

	var newitem =  '<div id="partnerfield'+noPartners+'" class="subformrow">';

	newitem += '<select onchange="this.style.width=\'172px\'; partnerNameIssue(\'partner'+noPartners+'\')" class="subforminput hgrselect" style="width: 172px;z-index:+1" id="partner'+noPartners+'menu" name="partnersarray[]" onactivate="this.style.width=\'auto\';">';
	newitem += '<option value="" ><?php echo $LNG->ORG_NAME; ?>/<?php echo $LNG->PROJECT_NAME; ?>...</option>';
	<?php
		global $orgs;
		if (isset($orgs)) {
			foreach($orgs as $org){?>
				newitem += "<option value="<?php echo $org['NodeID']; ?>"><?php echo $org['Name']; ?></option>";
	<?php } } ?>
	newitem += '</select>';
	newitem += '<a href="javascript:removeMultiple(\'partner\', '+noPartners+')" class="form" style="margin-left: 5px;"><?php echo $LNG->FORM_BUTTON_REMOVE; ?></a>';

	newitem += '</div>';

    $('partnerform').insert(newitem);

    noPartners++;

    return noPartners;
}

function toggleChallenges() {
	if ( $("groupsdiv").style.display == "block") {
		$("groupsdiv").style.display = "none";
		$("groupsimg").src="<?php echo $HUB_FLM->getImagePath("arrow-down-blue.png"); ?>";
	} else {
		$("groupsdiv").style.display = "block";
		$("groupsimg").src="<?php echo $HUB_FLM->getImagePath("arrow-up-blue.png"); ?>";
	}
}

function typeChangedResource(num) {
	var type = $('resource'+num+'menu').value;
	if (type == "Publication") {
		$('identifierdiv-'+num).style.display = "block";
	} else {
		$('identifierdiv-'+num).style.display = "none";
	}
}

function typeChangedProject() {
	if ($('datediv')) {
		$('datediv').style.display = "block";
	}
	if ($('projectdiv')) {
		$('projectdiv').style.display = "none";
	}
}

function typeChangedOrg() {
	if ($('startdate')) {
		$('startdate').value="";
	}
	if ($('enddate')) {
		$('enddate').value="";
	}

	if ($('datediv')) {
		$('datediv').style.display = "none";
	}
	if ($('projectdiv')) {
		$('projectdiv').style.display = "block";
	}
}


/**
 * Fetch the website title and description from the website page for the url passed.
 */
function autoCompleteWebsiteDetails() {
	var urlvalue = $('url').value;
	if (urlvalue == "" || urlvalue == "http://") {
		alert("<?php echo $LNG->ENTER_URL_FIRST; ?>");
		return;
	}

	var reqUrl = SERVICE_ROOT + "&method=autocompleteurldetails&url="+encodeURIComponent(urlvalue);
    new Ajax.Request(reqUrl, { method:'get',
        onSuccess: function(transport){
            var json = transport.responseText.evalJSON();
            if(json.error){
                //alert(json.error[0].message);
                return;
            }
			$('title').value = json.url[0].title;
   		}
    });
}

/**
 * Fetch the website title and description from the website page for the url passed.
 */
function autoCompleteWebsiteDetailsMulti(num) {
	var urlvalue = $('resourceurl-'+num).value;
	if (urlvalue == "" || urlvalue == "http://") {
		alert("<?php echo $LNG->ENTER_URL_FIRST; ?>");
		return;
	}

	var reqUrl = SERVICE_ROOT + "&method=autocompleteurldetails&url="+encodeURIComponent(urlvalue);
    new Ajax.Request(reqUrl, { method:'get',
        onSuccess: function(transport){
            var json = transport.responseText.evalJSON();
            if(json.error){
                //alert(json.error[0].message);
                return;
            }
			$('resourcetitle-'+num).value = json.url[0].title;
   		}
    });
}

/**
 * Hide all other steps apart from stepshow.
 */
function switchSteps(stepcount, stepshow) {
	for (var count=1; count<= stepcount; count++) {
		$('stepdiv'+count).style.display = "none";
	}

	$('stepdiv'+stepshow).style.display = "block";
}