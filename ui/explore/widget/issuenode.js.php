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
var nodeid = ISSUE_ARGS['nodeid'];

var nodekey = "Node"+nodeid;
var followkey = currentime+"Follow"+nodeid;
var themekey = currentime+"Theme"+nodeid;
var orgkey = currentime+"Org"+nodeid;
var projectkey = currentime+"Project"+nodeid;
var tagissuekey = currentime+'TagIssue'+nodeid;
var suggestedorgkey = currentime+'SuggestedOrg'+nodeid;
var suggestedclaimkey = currentime+'SuggestedClaim'+nodeid;
var suggestedsolutionkey = currentime+'SuggestedSolution'+nodeid;
var seealsokey = currentime+"SeeAlso"+nodeid;
var challengekey = currentime+"Challenge"+nodeid;
var solutionkey = currentime+"Solution"+nodeid;
var claimkey = currentime+"Claim"+nodeid;

var followisopen = false;
var themeisopen = false;
var orgisopen = false;
var projectisopen = false;
var suggestedorgisopen = false;
var suggestedclaimisopen = false;
var suggestedsolutionisopen = false;
var tagsissueisopen = false;
var seealsoisopen = false;
var challengeisopen = true;
var solutionisopen = true;
var claimisopen = true;

var nodeheight = 500;
var challengeheight = 495;
var solutionheight = 240;
if (!hasClaim) {
	solutionheight = 500;
}
var claimheight = 240;
if (!hasSolution) {
	solutionheight = 500;
}

var followheight = 300;
var themeheight = 300;
var orgheight = 300;
var projectheight = 300;
var seealsoheight = 300;
var issueheight = 300;
var suggestedorgheight = 300;
var suggestedclaimheight = 300;
var suggestedsolutionheight = 300;
var tagissueheight = 300;


var leftColumn = {};
if (hasChallenge) {
	leftColumn[challengekey] = 'challengesarea';
}

var rightColumn = {};
if (hasSolution) {
	rightColumn[solutionkey] = 'solutionsarea';
}
if (hasClaim) {
	rightColumn[claimkey] = 'claimsarea';
}

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
recommendColumn[suggestedorgkey] = 'suggestedorgsarea';
if (hasSolution) {
	recommendColumn[suggestedsolutionkey] = 'suggestedsolutionsarea';
}
if (hasClaim) {
	recommendColumn[suggestedclaimkey] = 'suggestedclaimsarea';
}
recommendColumn[tagissuekey] = 'tagsissuesarea';
<?php } ?>


function loadIssueWidgetPage() {
	nodeid = ISSUE_ARGS['nodeid'];

	refreshWidgetFollowers();

	if (hasChallenge) {
		refreshWidgetChallenges("");
	}
	if (hasSolution) {
		refreshWidgetSolutions("");
	}
	if (hasClaim) {
		refreshWidgetClaims("");
	}

	refreshWidgetOrganizations("");
	refreshWidgetProjects("");
	refreshWidgetSeeAlso("");

	refreshWidgetThemes();

	<?php if ($CFG->hasRecommendations) { ?>
	$('suggestedorgsarea').update(buildThemeSuggestionByType(nodeid, 'Organization,Project', '<?php echo $LNG->RECOMMENDATION_ORG_THEMES; ?>', suggestedorgheight, suggestedorgisopen, 'recommendwidgetback', suggestedorgkey));
	if (hasClaim) {
		$('suggestedclaimsarea').update(buildThemeSuggestionByType(nodeid, 'Claim', '<?php echo $LNG->RECOMMENDATION_CLAIM_THEMES; ?>', suggestedclaimheight, suggestedclaimisopen, 'recommendwidgetback', suggestedclaimkey));
	}
	if (hasSolution) {
		$('suggestedsolutionsarea').update(buildThemeSuggestionByType(nodeid, 'Solution', '<?php echo $LNG->RECOMMENDATION_SOLUTION_THEMES; ?>', suggestedsolutionheight, suggestedsolutionisopen, 'recommendwidgetback', suggestedsolutionkey));
	}
	$('tagsissuesarea').update(buildTagSuggestionByType(nodeid, 'Issue', NODE_ARGS['tags'], '<?php echo $LNG->RECOMMENDATION_ISSUE_TAGS; ?>', tagissueheight, tagsissueisopen, 'recommendwidgetback', tagissuekey));
	<?php } ?>

	refreshNodeIssue();
	Event.observe(window,"resize",resizeWidgets);
	resizeWidgets();
};

function resizeWidgets() {

	if (hasChallenge) {
		resizeKeyWidget(challengekey);
	}
	if (hasClaim) {
		resizeKeyWidget(claimkey);
	}
	if (hasSolution) {
		resizeKeyWidget(solutionkey);
	}

	resizeKeyWidget(followkey);
	resizeKeyWidget(themekey);
	resizeKeyWidget(orgkey);
	resizeKeyWidget(projectkey);
	resizeKeyWidget(tagissuekey);
	resizeKeyWidget(seealsokey);

	<?php if ($CFG->hasRecommendations) { ?>
	resizeKeyWidget(suggestedorgkey);
	if (hasClaim) {
		resizeKeyWidget(suggestedclaimkey);
	}
	if (hasSolution) {
		resizeKeyWidget(suggestedsolutionkey);
	}
	<?php } ?>

	resizeNodeWidget(nodekey, nodeheight);
}

function refreshNodeIssue() {
	var nodediv = buildNodeWidgetNew(nodeObj, nodeheight, "issue", nodekey, 'issueback');
	$('nodearea').update(nodediv);

	$(nodekey+'body').addClassName('widgettextcolor');
	$(nodekey+'body').addClassName('issuebackpale');

	$(nodekey+'div').addClassName('issuebackpale');
	$(nodekey+'div').addClassName('issueborder');

	//$(nodekey+'headerinner').addClassName('issueback');

	// make sure width is never more than 70/40% of the screen area.
	var screenWidth = getWindowWidth();
	var nodeWidth = $('nodearea').offsetWidth;
	var maxWidth = nodeWidth;
	if (hasChallenge) {
		maxWidth = Math.round(screenWidth*0.4);
	} else {
		maxWidth = Math.round(screenWidth*0.7);
	}
	if (maxWidth < nodeWidth) {
		$('widgetcolnode').style.width = maxWidth+"px";
		$('widgetcolnode').style.maxWidth = maxWidth+"px";
	}

	resizeNodeWidget(nodekey, nodeheight);
}

function refreshWidgetFollowers() {
	var isopen = getIsOpen($(followkey+"body"), followisopen);
	$('followersarea').update(followUsersWidget(nodeid,'<?php echo $LNG->EXPLORE_issueToFollower; ?>', followheight, isopen, 'followwidgetback', followkey));
	resizeKeyWidget(followkey);

	// for refreshing after an add/delete when expaned
	if ($('tagsissuesarea') && $('tagsissuesarea').style.display == 'none') {
		adjustForExpand($(followkey+"buttonresize"), followkey, followheight);
	}
}

function refreshWidgetThemes() {
	var isopen = getIsOpen($(themekey+"body"), themeisopen);
	$('themearea').update(buildThemeWidget(nodeid, themeheight, isopen, themekey, "<?php echo $LNG->EXPLORE_issueToTheme; ?>"));
	resizeKeyWidget(themekey);

	// for refreshing after an add/delete when expaned
	if ($('seealsoarea') && $('seealsoarea').style.display == 'none') {
		adjustForExpand($(solutionkey+"buttonresize"), solutionkey, themeheight);
	}
}

function refreshWidgetChallenges(nodetofocusid) {
	var isopen = getIsOpen($(challengekey+"body"), challengeisopen, nodetofocusid);
	$('challengesareainner').update(buildIssueToChallengeWidget(nodeid,'<?php echo $LNG->EXPLORE_issueToChallenge; ?>', challengeheight, isopen, challengekey, nodetofocusid));
	resizeKeyWidget(challengekey);

	// for refreshing after an add/delete when expaned
	if ($('themearea') && $('themearea').style.display == 'none') {
		adjustForExpand($(challengekey+"buttonresize"), challengekey, challengeheight);
	}
}

function refreshWidgetClaims(nodetofocusid) {
	var isopen = getIsOpen($(claimkey+"body"), claimisopen, nodetofocusid);
	$('claimsareainner').update(buildIssueToClaimWidget(NODE_ARGS['nodeid'], '<?php echo $LNG->EXPLORE_issueToClaim; ?>', claimheight, isopen, claimkey, nodetofocusid));
	resizeKeyWidget(claimkey);

	// for refreshing after an add/delete when expaned
	if ($('themearea') && $('themearea').style.display == 'none') {
		adjustForExpand($(claimkey+"buttonresize"), claimkey, claimheight);
	}
}

function refreshWidgetSolutions(nodetofocusid) {
	var isopen = getIsOpen($(solutionkey+"body"), solutionisopen, nodetofocusid);
	$('solutionsareainner').update(buildIssueToSolutionWidget(NODE_ARGS['nodeid'], '<?php echo $LNG->EXPLORE_issueToSolution; ?>', solutionheight, isopen, solutionkey, nodetofocusid));
	resizeKeyWidget(solutionkey);

	// for refreshing after an add/delete when expaned
	if ($('themearea') && $('themearea').style.display == 'none') {
		adjustForExpand($(solutionkey+"buttonresize"), solutionkey, solutionheight);
	}
}

function refreshWidgetOrganizations(nodetofocusid) {
	var isopen = getIsOpen($(orgkey+"body"), orgisopen, nodetofocusid);
	$('orgsarea').update(buildIssueToOrgWidget(nodeid,'<?php echo $LNG->EXPLORE_issueToOrg; ?>', orgheight, isopen, orgkey, nodetofocusid));
	resizeKeyWidget(orgkey);

	// for refreshing after an add/delete when expaned
	if ($('themearea') && $('themearea').style.display == 'none') {
		adjustForExpand($(orgkey+"buttonresize"), orgkey, orgheight);
	}
}

function refreshWidgetProjects(nodetofocusid) {
	var isopen = getIsOpen($(projectkey+"body"), projectisopen, nodetofocusid);
	$('projectsarea').update(buildIssueToProjectWidget(nodeid,'<?php echo $LNG->EXPLORE_issueToProject; ?>', projectheight, isopen, projectkey, nodetofocusid));
	resizeKeyWidget(projectkey);

	// for refreshing after an add/delete when expaned
	if ($('themearea') && $('themearea').style.display == 'none') {
		adjustForExpand($(projectkey+"buttonresize"), projectkey, projectheight);
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

loadIssueWidgetPage();
