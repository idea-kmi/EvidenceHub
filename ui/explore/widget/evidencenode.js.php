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
    include_once("../../../config.php");

    $me = substr($_SERVER["PHP_SELF"], 1); // remove initial '/'
    if ($HUB_FLM->hasCustomVersion($me)) {
    	$path = $HUB_FLM->getCodeDirPath($me);
    	include_once($path);
		die;
	}
?>

var currentime = new Date().getTime();
var nodeid = EVIDENCE_ARGS['nodeid'];

var nodekey = "Node"+nodeid;
var followkey = currentime+"Follow"+nodeid;
var themekey = currentime+"Theme"+nodeid;
var orgkey = currentime+"Org"+nodeid;
var projectkey = currentime+"Project"+nodeid;
var suggestedclaimkey = currentime+'SuggestedClaim'+nodeid;
var suggestedissuekey = currentime+'SuggestedIssue'+nodeid;
var suggestedsolutionkey = currentime+'SuggestedSolution'+nodeid;
var suggestedorgskey = currentime+'SuggestedOrgs'+nodeid;
var seealsokey = currentime+"SeeAlso"+nodeid;
var claimkey = currentime+'Claim'+nodeid;
var solutionkey = currentime+'Solution'+nodeid;
var websitekey = currentime+"Website"+nodeid;

var followisopen = false;
var themeisopen = false;
var orgisopen = false;
var projectisopen = false;
var seealsoisopen = false;
var suggestedclaimisopen = false;
var suggestedissueisopen = false;
var suggestedsolutionisopen = false;
var suggestedorgisopen = false;
var websiteisopen = true;
var solutionisopen = true;
var claimisopen = true;

var nodeheight = 500;
var nodeheight = 500;
var solutionheight = 240;
if (!hasClaim) {
	solutionheight = 500;
}
var claimheight = 240;
if (!hasSolution) {
	solutionheight = 500;
}
var websiteheight = 550;

var followheight = 300;
var themeheight = 300;
var orgheight = 300;
var projectheight = 300;
var seealsoheight = 300;
var suggestedclaimheight = 300;
var suggestedissueheight = 300;
var suggestedsolutionheight = 300;
var suggestedorgsheight = 300;

var leftColumn = {};
if (hasSolution) {
	leftColumn[solutionkey] = 'solutionsarea';
}
if (hasClaim) {
	leftColumn[claimkey] = 'claimsarea';
}

var rightColumn = {};
rightColumn[websitekey] = 'websitesarea';

var extraColumn = {};
//extraColumn['datakey'] = 'dataarea';
extraColumn[themekey] = 'themearea';
extraColumn[seealsokey] = 'seealsoarea';
extraColumn[followkey] = 'followersarea';

var relatedColumn = {};
//relatedColumn['extrakey'] = 'extraarea';
relatedColumn[orgkey] = 'orgsarea';
relatedColumn[projectkey] = 'projectsarea';

var recommendColumn = {};
//recommendColumn['recommendationkey'] = 'recommendationarea';
<?php if ($CFG->hasRecommendations) { ?>
recommendColumn[suggestedorgskey] = 'suggestedorgsarea';
recommendColumn[suggestedissuekey] = 'suggestedissuesarea';
if (hasSolution) {
	recommendColumn[suggestedsolutionkey] = 'suggestedsolutionsarea';
}
if (hasClaim) {
	recommendColumn[suggestedclaimkey] = 'suggestedclaimsarea';
}
<?php } ?>

function loadEvidenceWidgetPage() {
	refreshWidgetResources("");

	<?php if ($CFG->HAS_CLAIM) {
		echo 'refreshWidgetClaims("");';
	} ?>

	<?php if ($CFG->HAS_SOLUTION) {
		echo 'refreshWidgetSolutions("");';
	} ?>

	refreshWidgetThemes();
	refreshWidgetFollowers();

	refreshWidgetOrganizations("");
	refreshWidgetProjects("");
	refreshWidgetSeeAlso("");

	<?php if ($CFG->hasRecommendations) { ?>
	$('suggestedorgsarea').update(buildThemeSuggestionByType(NODE_ARGS['nodeid'], 'Organization,Project', '<?php echo $LNG->RECOMMENDATION_ORG_THEMES; ?>', suggestedorgsheight, suggestedorgisopen, 'recommendwidgetback', suggestedorgskey));
	$('suggestedissuesarea').update(buildThemeSuggestionByType(NODE_ARGS['nodeid'], 'Issue', '<?php echo $LNG->RECOMMENDATION_ISSUE_THEMES; ?>', suggestedissueheight, suggestedissueisopen, 'recommendwidgetback',suggestedissuekey));
	if (hasClaim) {
		$('suggestedclaimsarea').update(buildThemeSuggestionByType(NODE_ARGS['nodeid'], 'Claim', '<?php echo $LNG->RECOMMENDATION_CLAIM_THEMES; ?>', suggestedclaimheight, suggestedclaimisopen, 'recommendwidgetback', suggestedclaimkey));
	}
	if (hasSolution) {
		$('suggestedsolutionsarea').update(buildThemeSuggestionByType(NODE_ARGS['nodeid'], 'Solution', '<?php echo $LNG->RECOMMENDATION_SOLUTION_THEMES; ?>', suggestedsolutionheight, suggestedsolutionisopen, 'recommendwidgetback',suggestedsolutionkey));
	}
	<?php } ?>

	refreshNodeEvidence();
	Event.observe(window,"resize",resizeWidgets);
	resizeWidgets();
};

function resizeWidgets() {
	resizeKeyWidget(followkey);
	resizeKeyWidget(themekey);
	resizeKeyWidget(orgkey);
	resizeKeyWidget(projectkey);
	resizeKeyWidget(seealsokey);

	resizeKeyWidget(websitekey);

	<?php if ($CFG->hasRecommendations) { ?>
	if (hasClaim) {
		resizeKeyWidget(suggestedclaimkey);
	}
	if (hasSolution) {
		resizeKeyWidget(suggestedsolutionkey);
	}
	resizeKeyWidget(suggestedissuekey);
	resizeKeyWidget(suggestedorgskey);
	<?php } ?>

	resizeNodeWidget(nodekey, nodeheight);
}

function refreshNodeEvidence() {
	var nodediv = buildNodeWidgetNew(nodeObj, nodeheight, "evidence", nodekey, 'evidenceback');
	$('nodearea').update(nodediv);

	$(nodekey+'body').addClassName('widgettextcolor');
	$(nodekey+'body').addClassName('evidencebackpale');

	$(nodekey+'div').addClassName('evidencebackpale');
	$(nodekey+'div').addClassName('evidenceborder');

	$(nodekey+'headerinner').addClassName('evidenceback');

	var screenWidth = getWindowWidth();
	var nodeWidth = $('nodearea').offsetWidth;
	var maxWidth = nodeWidth;
	maxWidth = Math.round(screenWidth*0.4);
	if (maxWidth < nodeWidth) {
		$('widgetcolnode').style.width = maxWidth+"px";
		$('widgetcolnode').style.maxWidth = maxWidth+"px";
	}

	resizeNodeWidget(nodekey, nodeheight);
}

function refreshWidgetThemes() {
	var isopen = getIsOpen($(themekey+"body"), themeisopen);
	$('themearea').update(buildThemeWidget(nodeid, themeheight, isopen, themekey, "<?php echo $LNG->EXPLORE_evidenceToTheme; ?>"));
	resizeKeyWidget(themekey);

	// for refreshing after an add/delete when expaned
	if ($('seealsoarea') && $('seealsoarea').style.display == 'none') {
		adjustForExpand($(themekey+"buttonresize"), themekey, themeheight);
	}
}

function refreshWidgetClaims(nodetofocusid) {
	var isopen = getIsOpen($(claimkey+"body"), claimisopen, nodetofocusid);
	$('claimsareainner').update(buildEvidenceToClaimWidget(nodeid, '<?php echo $LNG->EXPLORE_evidenceToClaim; ?>', claimheight, isopen, claimkey,nodetofocusid));
	resizeKeyWidget(claimkey);

	// for refreshing after an add/delete when expaned
	if ($('themearea') && $('themearea').style.display == 'none') {
		adjustForExpand($(claimkey+"buttonresize"), claimkey, claimheight);
	}
}

function refreshWidgetSolutions(nodetofocusid) {
	var isopen = getIsOpen($(solutionkey+"body"), solutionisopen, nodetofocusid);
	$('solutionsareainner').update(buildEvidenceToSolutionWidget(nodeid, '<?php echo $LNG->EXPLORE_evidenceToSolution; ?>', solutionheight, isopen, solutionkey,nodetofocusid));
	resizeKeyWidget(solutionkey);

	// for refreshing after an add/delete when expaned
	if ($('themearea') && $('themearea').style.display == 'none') {
		adjustForExpand($(solutionkey+"buttonresize"), solutionkey, solutionheight);
	}
}

function refreshWidgetResources(nodetofocusid) {
	var isopen = getIsOpen($(websitekey+"body"), websiteisopen, nodetofocusid);
	$('websitesareainner').update(buildEvidenceToResourceWidget(nodeid, "<?php echo $LNG->EXPLORE_evidenceToResource; ?>", websiteheight, isopen, websitekey, nodetofocusid));
	resizeKeyWidget(websitekey);

	// for refreshing after an add/delete when expaned
	if ($('themearea') && $('themearea').style.display == 'none') {
		adjustForExpand($(websitekey+"buttonresize"), websitekey, websiteheight);
	}
}

function refreshWidgetOrganizations(nodetofocusid) {
	var isopen = getIsOpen($(orgkey+"body"), orgisopen, nodetofocusid);
	$('orgsarea').update(builEvidenceToOrgWidget(nodeid, '<?php echo $LNG->EXPLORE_evidenceToOrg; ?>', orgheight, isopen, orgkey, nodetofocusid));
	resizeKeyWidget(orgkey);

	// for refreshing after an add/delete when expaned
	if ($('themearea') && $('themearea').style.display == 'none') {
		adjustForExpand($(orgkey+"buttonresize"), orgkey, orgheight);
	}
}

function refreshWidgetProjects(nodetofocusid) {
	var isopen = getIsOpen($(projectkey+"body"), projectisopen, nodetofocusid);
	$('projectsarea').update(builEvidenceToProjectWidget(nodeid, '<?php echo $LNG->EXPLORE_evidenceToProject; ?>', projectheight, isopen, projectkey, nodetofocusid));
	resizeKeyWidget(projectkey);

	// for refreshing after an add/delete when expaned
	if ($('themearea') && $('themearea').style.display == 'none') {
		adjustForExpand($(projectkey+"buttonresize"), projectkey, projectheight);
	}
}

function refreshWidgetFollowers() {
	var isopen = getIsOpen($(followkey+"body"), followisopen);
	$('followersarea').update(followUsersWidget(nodeid,'<?php echo $LNG->EXPLORE_evidenceToFollower; ?>', followheight, isopen, 'followwidgetback', followkey));
	resizeKeyWidget(followkey);

	// for refreshing after an add/delete when expaned
	if ($('suggestedorgsarea') && $('suggestedorgsarea').style.display == 'none') {
		adjustForExpand($(followkey+"buttonresize"), followkey, followheight);
	}
}

function refreshWidgetSeeAlso(nodetofocusid) {
	var isopen = getIsOpen($(seealsokey+"body"), seealsoisopen, nodetofocusid);
	$('seealsoarea').update(buildSeeAlsoWidget(nodeid, '<?php echo $LNG->EXPLORE_SEE_ALSO; ?>', seealsoheight, isopen, 'resourcewidgetback', seealsokey, nodetofocusid));
	resizeKeyWidget(seealsokey);

	// for refreshing after an add/delete when expaned
	if ($('themearea') && $('themearea').style.display == 'none') {
		adjustForExpand($(seealsokey+"buttonresize"), seealsokey, seealsoheight);
	}
}

loadEvidenceWidgetPage();