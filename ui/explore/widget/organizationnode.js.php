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
var nodeid = NODE_ARGS['nodeid'];

var nodekey = "Node"+nodeid;

var claimkey = currentime+'Claim'+nodeid;
var solutionkey = currentime+'Solution'+nodeid;
var issuekey = currentime+'Issue'+nodeid;
var challengekey = currentime+'Challenge'+nodeid;
var projectkey = currentime+"Project"+nodeid;
var partnerkey = currentime+"Partner"+nodeid;
var websitekey = currentime+"Website"+nodeid;
var followkey = currentime+"Follow"+nodeid;
var themekey = currentime+"Theme"+nodeid;
var evidencekey = currentime+'Evidence'+nodeid;
var suggestedclaimkey = currentime+'SuggestedClaim'+nodeid;
var suggestedissuekey = currentime+'SuggestedIssue'+nodeid;
var suggestedsolutionkey = currentime+'SuggestedSolution'+nodeid;
var seealsokey = currentime+"SeeAlso"+nodeid;

var followisopen = false;
var themeisopen = false;
var claimisopen = false;
var solutionisopen = false;
var issueisopen = false;
var evidenceisopen = false;
var challengeisopen = false;
var projectisopen = false;
var partnerisopen = false;
var websiteisopen = false;
var seealsoisopen = false;
var suggestedclaimisopen = false;
var suggestedissueisopen = false;
var suggestedsolutionisopen = false;

var nodeheight = 500;

var followheight = 300;
var themeheight = 300;
var claimheight = 300;
var solutionheight = 300;
var issueheight = 300;
var challengeheight = 300;
var seealsoheight = 300;
var projectheight = 300;
var partnerheight = 300;
var websiteheight = 300;
var evidenceheight = 300;
var suggestedclaimheight = 300;
var suggestedissueheight = 300;
var suggestedsolutionheight = 300;

var rightColumn = {};
rightColumn[websitekey] = 'websitesarea';
rightColumn[partnerkey] = 'partnersarea';
rightColumn[projectkey] = 'projectsarea';
if (hasChallenge) {
	rightColumn[challengekey] = 'challengesarea';
}
rightColumn[issuekey] = 'issuesarea';
if (hasClaim) {
	rightColumn[claimkey] = 'claimsarea';
}
if (hasSolution) {
	rightColumn[solutionkey] = 'solutionsarea';
}
rightColumn[evidencekey] = 'evidencearea';

var extraColumn = {};
extraColumn[themekey] = 'themearea';
extraColumn[seealsokey] = 'seealsoarea';
extraColumn[followkey] = 'followersarea';

var recommendColumn = {};
<?php if ($CFG->hasRecommendations) { ?>
recommendColumn[suggestedissuekey] = 'suggestedissuesarea';
if (hasSolution) {
	recommendColumn[suggestedsolutionkey] = 'suggestedsolutionsarea';
}
if (hasClaim) {
	recommendColumn[suggestedclaimkey] = 'suggestedclaimsarea';
}
<?php } ?>

function loadOrganizationWidgetPage() {

	refreshWidgetThemes();
	refreshWidgetProjects("");
	refreshWidgetPartners("");
	refreshWidgetResources("");

	refreshWidgetFollowers();
	refreshWidgetIssues("");

	<?php if ($CFG->hasRecommendations) {
		if ($CFG->HAS_CHALLENGE) {
			echo 'refreshWidgetChallenges("");';
		}
		if ($CFG->HAS_CLAIM) {
			echo 'refreshWidgetClaims("");';
			echo "$('suggestedclaimsarea').update(buildThemeSuggestionByType(nodeid, 'Claim', '".$LNG->RECOMMENDATION_CLAIM_THEMES."', suggestedclaimheight, suggestedclaimisopen, 'recommendwidgetback', suggestedclaimkey));";
		}
		if ($CFG->HAS_SOLUTION) {
			echo 'refreshWidgetSolutions("");';
			echo "$('suggestedsolutionsarea').update(buildThemeSuggestionByType(nodeid, 'Solution', '".$LNG->RECOMMENDATION_SOLUTION_THEMES."', suggestedsolutionheight, suggestedsolutionisopen, 'recommendwidgetback', suggestedsolutionkey));";
		}
		echo "$('suggestedissuesarea').update(buildThemeSuggestionByType(nodeid, 'Issue', '".$LNG->RECOMMENDATION_ISSUE_THEMES."', suggestedissueheight, suggestedissueisopen, 'recommendwidgetback', suggestedissuekey));";
	} ?>

	refreshWidgetEvidence("");
	refreshWidgetSeeAlso("");


	refreshNodeOrganization();
	Event.observe(window,"resize",resizeWidgets);
	resizeWidgets();
};

function resizeWidgets() {
	resizeKeyWidget(followkey);
	resizeKeyWidget(themekey);

	resizeKeyWidget(issuekey);
	<?php if ($CFG->HAS_CHALLENGE) {
		echo 'resizeKeyWidget(challengekey);';
	} ?>
	<?php if ($CFG->HAS_CLAIM) {
		echo 'resizeKeyWidget(claimkey);';
	} ?>
	<?php if ($CFG->HAS_SOLUTION) {
		echo 'resizeKeyWidget(solutionkey);';
	} ?>
	resizeKeyWidget(projectkey);
	resizeKeyWidget(partnerkey);
	resizeKeyWidget(websitekey);
	resizeKeyWidget(evidencekey);
	resizeKeyWidget(seealsokey);

	<?php if ($CFG->hasRecommendations) {
	if ($CFG->HAS_CHALLENGE) {
		echo 'resizeKeyWidget(suggestedsolutionkey);';
	}
	if ($CFG->HAS_SOLUTION) {
		echo 'resizeKeyWidget(suggestedclaimkey);';
	}
	echo 'resizeKeyWidget(suggestedissuekey);';
	}?>

	resizeNodeWidget(nodekey, nodeheight);
}

function refreshNodeOrganization() {
	var nodediv = buildNodeWidgetNew(nodeObj, nodeheight, "org", nodekey, 'orgback');
	$('nodearea').update(nodediv);

	$(nodekey+'body').addClassName('widgettextcolor');
	$(nodekey+'body').addClassName('orgbackpale');

	$(nodekey+'div').addClassName('orgbackpale');
	$(nodekey+'div').addClassName('orgborder');

	$(nodekey+'headerinner').addClassName('orgback');

	var screenWidth = getWindowWidth();
	var nodeWidth = $('nodearea').offsetWidth;
	var maxWidth = nodeWidth;
	maxWidth = Math.round(screenWidth*0.5);
	if (maxWidth < nodeWidth) {
		$('widgetcolnode').style.width = maxWidth+"px";
		$('widgetcolnode').style.maxWidth = maxWidth+"px";
	}

	resizeNodeWidget(nodekey, nodeheight);
}

function refreshWidgetThemes() {
	var isopen = getIsOpen($(themekey+"body"), themeisopen);
	$('themearea').update(buildThemeWidget(nodeid, themeheight, isopen, themekey, "<?php echo $LNG->EXPLORE_orgToTheme; ?>"));
	resizeKeyWidget(themekey);

	// for refreshing after an add/delete when expaned
	if ($('seealsoarea') && $('seealsoarea').style.display == 'none') {
		adjustForExpand($(themekey+"buttonresize"), themekey, themeheight);
	}
}

function refreshWidgetFollowers() {
	var isopen = getIsOpen($(followkey+"body"), followisopen);
	$('followersarea').update(followUsersWidget(nodeid,'<?php echo $LNG->EXPLORE_orgToFollower; ?>', followheight, isopen, 'followwidgetback', followkey));
	resizeKeyWidget(followkey);

	// for refreshing after an add/delete when expaned
	if ($('suggestedissuesarea') && $('suggestedissuesarea').style.display == 'none') {
		adjustForExpand($(followkey+"buttonresize"), followkey, followheight);
	}
}

function refreshWidgetProjects(nodetofocusid) {
	var isopen = getIsOpen($(projectkey+"body"), projectisopen, nodetofocusid);
	$('projectsarea').update(buildOrgToProjectWidget(nodeid,'<?php echo $LNG->EXPLORE_orgToProject; ?>', projectheight, isopen, projectkey, nodetofocusid));
	resizeKeyWidget(projectkey);

	// for refreshing after an add/delete when expaned
	if ($('partnersarea') && $('partnersarea').style.display == 'none') {
		adjustForExpand($(projectkey+"buttonresize"), projectkey, projectheight);
	}
}

function refreshWidgetPartners(nodetofocusid) {
	var isopen = getIsOpen($(partnerkey+"body"), partnerisopen, nodetofocusid);
	$('partnersarea').update(buildOrgToOrgWidget(nodeid, "<?php echo $LNG->EXPLORE_orgToOrg; ?>", partnerheight, isopen, partnerkey, nodetofocusid));
	resizeKeyWidget(partnerkey);

	// for refreshing after an add/delete when expaned
	if ($('websitesarea') && $('websitesarea').style.display == 'none') {
		adjustForExpand($(partnerkey+"buttonresize"), partnerkey, partnerheight);
	}
}

function refreshWidgetResources(nodetofocusid) {
	var isopen = getIsOpen($(websitekey+"body"), websiteisopen, nodetofocusid);
	$('websitesarea').update(buildOrgToResourceWidget(nodeid,'<?php echo $LNG->EXPLORE_orgToResource; ?>', websiteheight, isopen, websitekey, nodetofocusid));

	resizeKeyWidget(websitekey);

	// for refreshing after an add/delete when expaned
	if ($('partnersarea') && $('partnersarea').style.display == 'none') {
		adjustForExpand($(websitekey+"buttonresize"), websitekey, websiteheight);
	}
}

function refreshWidgetEvidence(nodetofocusid) {
	var isopen = getIsOpen($(evidencekey+"body"), evidenceisopen, nodetofocusid);
	$('evidencearea').update(buildOrgToEvidenceWidget(nodeid, "<?php echo $LNG->EXPLORE_orgToEvidence; ?>", evidenceheight, isopen, evidencekey, nodetofocusid));
	resizeKeyWidget(evidencekey);

	// for refreshing after an add/delete when expaned
	if ($('challengesarea') && $('challengesarea').style.display == 'none') {
		adjustForExpand($(evidencekey+"buttonresize"), evidencekey, evidenceheight);
	}
}

function refreshWidgetChallenges(nodetofocusid) {
	var isopen = getIsOpen($(challengekey+"body"), challengeisopen, nodetofocusid);
	$('challengesarea').update(buildOrgToChallengeWidget(nodeid, '<?php echo $LNG->EXPLORE_orgToChallenge; ?>', issueheight, isopen, challengekey, nodetofocusid));
	resizeKeyWidget(challengekey);

	// for refreshing after an add/delete when expaned
	if ($('solutionsarea') && $('solutionsarea').style.display == 'none') {
		adjustForExpand($(challengekey+"buttonresize"), challengekey, challengeheight);
	}
}

function refreshWidgetIssues(nodetofocusid) {
	var isopen = getIsOpen($(issuekey+"body"), issueisopen, nodetofocusid);
	$('issuesarea').update(buildOrgToIssueWidget(nodeid, '<?php echo $LNG->EXPLORE_orgToIssue; ?>', issueheight, isopen, issuekey, nodetofocusid));
	resizeKeyWidget(issuekey);

	// for refreshing after an add/delete when expaned
	if ($('challengesarea') && $('challengesarea').style.display == 'none') {
		adjustForExpand($(issuekey+"buttonresize"), issuekey, issueheight);
	}
}

function refreshWidgetClaims(nodetofocusid) {
	var isopen = getIsOpen($(claimkey+"body"), claimisopen, nodetofocusid);
	$('claimsarea').update(buildOrgToClaimWidget(nodeid,'<?php echo $LNG->EXPLORE_orgToClaim; ?>', claimheight, isopen, claimkey, nodetofocusid));
	resizeKeyWidget(claimkey);

	// for refreshing after an add/delete when expaned
	if ($('challengesarea') && $('challengesarea').style.display == 'none') {
		adjustForExpand($(claimkey+"buttonresize"), claimkey, claimheight);
	}
}

function refreshWidgetSolutions(nodetofocusid) {
	var isopen = getIsOpen($(solutionkey+"body"), solutionisopen, nodetofocusid);
	$('solutionsarea').update(buildOrgToSolutionWidget(nodeid,'<?php echo $LNG->EXPLORE_orgToSolution; ?>', solutionheight, isopen, solutionkey, nodetofocusid));
	resizeKeyWidget(solutionkey);

	// for refreshing after an add/delete when expaned
	if ($('challengesarea') && $('challengesarea').style.display == 'none') {
		adjustForExpand($(solutionkey+"buttonresize"), solutionkey, solutionheight);
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

loadOrganizationWidgetPage();
