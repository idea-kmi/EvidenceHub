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
var evidencekey = currentime+"Evidence"+nodeid;
var resourcekey = currentime+"Resource"+nodeid;
var orgkey = currentime+"Org"+nodeid;
var projectkey = currentime+"Project"+nodeid;
var challengekey = currentime+"Challenge"+nodeid;
var followkey = currentime+"Follow"+nodeid;

var followisopen = false;
var orgisopen = false;
var projectisopen = false;
var challengeisopen = true;
var issueisopen = true;
var solutionisopen = true;
var claimisopen = true;
var evidenceisopen = true;
var resourceisopen = true;

var nodeheight = 500; // not used now

var followheight = 189;
var evidenceheight = 189;
var resourceheight = 189;
var orgheight = 189;
var projectheight = 189;
var issueheight = 189;
var solutionheight = 189;
var challengeheight = 189;
var claimheight = 189;


var leftColumn = {};
<?php if ($CFG->HAS_CHALLENGE) { ?>
	leftColumn[challengekey] = 'challengesarea';
<?php }  ?>
leftColumn[issuekey] = 'issuesarea';
<?php if ($CFG->HAS_SOLUTION) { ?>
	leftColumn[solutionkey] = 'solutionsarea';
<?php }  ?>
<?php if ($CFG->HAS_CLAIM) { ?>
	leftColumn[claimkey] = 'claimsarea';
<?php }  ?>

var rightColumn = {};
rightColumn['extrakey'] = 'extraarea';
rightColumn[evidencekey] = 'evidencearea';
rightColumn[resourcekey] = 'resourcearea';
rightColumn[orgkey] = 'orgsarea';
rightColumn[projectkey] = 'projectsarea';
rightColumn[followkey] = 'followersarea';


function loadThemeWidgetPage() {
	refreshWidgetFollowers();

	if (hasChallenge) {
		refreshWidgetChallenges("");
	}
	if (hasClaim) {
		refreshWidgetClaims("");
	}
	if (hasSolution) {
		refreshWidgetSolutions("");
	}

	refreshWidgetIssues("");
	refreshWidgetEvidence("");
	refreshWidgetResources("");
	refreshWidgetOrganizations("");
	refreshWidgetProjects("");

	refreshNodeTheme();
	Event.observe(window,"resize",resizeWidgets);
	resizeWidgets();
};

function resizeWidgets() {
	resizeKeyWidget(followkey);
	if (hasChallenge) {
		resizeKeyWidget(challengekey);
	}
	if (hasClaim) {
		resizeKeyWidget(claimkey);
	}
	if (hasSolution) {
		resizeKeyWidget(solutionkey);
	}
	resizeKeyWidget(issuekey);
	resizeKeyWidget(evidencekey);
	resizeKeyWidget(orgkey);
	resizeKeyWidget(projectkey);
	resizeKeyWidget(resourcekey);

	resizeNodeWidget(nodekey, nodeheight);
}

function refreshNodeTheme() {
	var nodediv = buildNodeWidgetNew(nodeObj, nodeheight, "theme", nodekey, 'themeback');
	$('nodearea').update(nodediv);

	$(nodekey+'body').addClassName('widgettextcolor');
	$(nodekey+'body').addClassName('themebackpale');

	$(nodekey+'div').addClassName('themebackpale');
	$(nodekey+'div').addClassName('themeborder');

	//$(nodekey+'headerinner').addClassName('themeback');

	resizeNodeWidget(nodekey, nodeheight);
}

// LEFT COLUMN

function refreshWidgetChallenges(nodetofocusid) {
	var isopen = getIsOpen($(challengekey+"body"), challengeisopen, nodetofocusid);
	$('challengesarea').update(buildThemeRelatedWidget(nodeid,  NODE_ARGS['title'], '<?php echo $LNG->EXPLORE_themeToChallenge; ?>', challengeheight, 'Challenge', 'challengewidgetback', challengekey, nodetofocusid, 'refreshExploreChallenges', isopen));
	resizeKeyWidget(challengekey);

	// for refreshing after an add/delete when expaned
	if ($('issuesarea') && $('issuesarea').style.display == 'none') {
		adjustForExpand($(challengekey+"buttonresize"), challengekey, challengeheight);
	}
}

function refreshWidgetIssues(nodetofocusid) {
	var isopen = getIsOpen($(issuekey+"body"), issueisopen, nodetofocusid);
	$('issuesarea').update(buildThemeRelatedWidget(nodeid,  NODE_ARGS['title'], '<?php echo $LNG->EXPLORE_themeToIssue; ?>', issueheight, 'Issue', 'issuewidgetback', issuekey, nodetofocusid, 'refreshExploreIssues', isopen));
	resizeKeyWidget(issuekey);

	// for refreshing after an add/delete when expaned
	if ($('orgsarea') && $('orgsarea').style.display == 'none') {
		adjustForExpand($(issuekey+"buttonresize"), issuekey, issueheight);
	}
}

function refreshWidgetOrganizations(nodetofocusid) {
	var isopen = getIsOpen($(orgkey+"body"), orgisopen, nodetofocusid);
	$('orgsarea').update(buildThemeRelatedWidget(nodeid, NODE_ARGS['title'], '<?php echo $LNG->EXPLORE_themeToOrg; ?>', orgheight, 'Organization', 'orgwidgetback', orgkey, nodetofocusid, 'refreshExploreOrganizations', isopen));
	resizeKeyWidget(orgkey);

	// for refreshing after an add/delete when expaned
	if ($('issuesarea') && $('issuesarea').style.display == 'none') {
		adjustForExpand($(orgkey+"buttonresize"), orgkey, orgheight);
	}
}

function refreshWidgetProjects(nodetofocusid) {
	var isopen = getIsOpen($(projectkey+"body"), projectisopen, nodetofocusid);
	$('projectsarea').update(buildThemeRelatedWidget(nodeid, NODE_ARGS['title'], '<?php echo $LNG->EXPLORE_themeToProject; ?>', projectheight, 'Project', 'projectwidgetback', projectkey, nodetofocusid, 'refreshExploreProjects', isopen));
	resizeKeyWidget(projectkey);

	// for refreshing after an add/delete when expaned
	if ($('issuesarea') && $('issuesarea').style.display == 'none') {
		adjustForExpand($(projectkey+"buttonresize"), projectkey, projectheight);
	}
}

function refreshWidgetSolutions(nodetofocusid) {
	var isopen = getIsOpen($(solutionkey+"body"), solutionisopen, nodetofocusid);
	$('solutionsarea').update(buildThemeRelatedWidget(nodeid,  NODE_ARGS['title'], '<?php echo $LNG->EXPLORE_themeToSolution; ?>', solutionheight, 'Solution', 'resourcewidgetback', solutionkey, nodetofocusid, 'refreshExploreSolutions', isopen));
	resizeKeyWidget(solutionkey);

	// for refreshing after an add/delete when expaned
	if ($('issuesarea') && $('issuesarea').style.display == 'none') {
		adjustForExpand($(solutionkey+"buttonresize"), solutionkey, solutionheight);
	}
}

//RIGHT COLUMN

function refreshWidgetClaims(nodetofocusid) {
	var isopen = getIsOpen($(claimkey+"body"), claimisopen, nodetofocusid);
	$('claimsarea').update(buildThemeRelatedWidget(nodeid,  NODE_ARGS['title'], '<?php echo $LNG->EXPLORE_themeToClaim; ?>', claimheight, 'Claim', 'claimwidgetback', claimkey, nodetofocusid, 'refreshExploreClaims', isopen));
	resizeKeyWidget(claimkey);

	// for refreshing after an add/delete when expaned
	if ($('evidencearea') && $('evidencearea').style.display == 'none') {
		adjustForExpand($(claimkey+"buttonresize"), claimkey, claimheight);
	}
}

function refreshWidgetEvidence(nodetofocusid){
	var isopen = getIsOpen($(evidencekey+"body"), evidenceisopen, nodetofocusid);
	$('evidencearea').update(buildThemeRelatedWidget(nodeid,  NODE_ARGS['title'], '<?php echo $LNG->EXPLORE_themeToEvidence; ?>', evidenceheight, EVIDENCE_TYPES_STR, 'evidencewidgetback', evidencekey, nodetofocusid, 'refreshExploreEvidence', isopen));
	resizeKeyWidget(evidencekey);

	// for refreshing after an add/delete when expaned
	if ($('followersarea') && $('followersarea').style.display == 'none') {
		adjustForExpand($(evidencekey+"buttonresize"), evidencekey, evidenceheight);
	}
}

function refreshWidgetResources(nodetofocusid) {
	var isopen = getIsOpen($(resourcekey+"body"), resourceisopen, nodetofocusid);
	$('resourcearea').update(buildThemeRelatedWidget(nodeid,  NODE_ARGS['title'], '<?php echo $LNG->EXPLORE_themeToResource; ?>', resourceheight, RESOURCE_TYPES_STR, 'resourcewidgetback', resourcekey, nodetofocusid, 'refreshExploreResources', isopen));
	resizeKeyWidget(resourcekey);

	// for refreshing after an add/delete when expaned
	if ($('evidencearea') && $('evidencearea').style.display == 'none') {
		adjustForExpand($(resourcekey+"buttonresize"), resourcekey, resourceheight);
	}
}

function refreshWidgetFollowers() {
	var isopen = getIsOpen($(followkey+"body"), followisopen);
	$('followersarea').update(followUsersWidget(NODE_ARGS['nodeid'],'<?php echo $LNG->EXPLORE_themeToFollower; ?>', followheight, isopen, 'followwidgetback', followkey));
	resizeKeyWidget(followkey);

	// for refreshing after an add/delete when expaned
	if ($('evidencearea') && $('evidencearea').style.display == 'none') {
		adjustForExpand($(followkey+"buttonresize"), followkey, followheight);
	}
}

loadThemeWidgetPage();