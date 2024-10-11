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
var nodeid = CLAIM_ARGS['nodeid'];

var nodekey = "Node"+nodeid;
var suggestedorgkey = currentime+'SuggestedOrg'+nodeid;
var suggestedissuekey = currentime+'SuggestedIssues'+nodeid;
var orgkey = currentime+'Org'+nodeid;
var projectkey = currentime+'Project'+nodeid;
var issuekey = currentime+'Issue'+nodeid;
var proevidencekey = currentime+"ProEvidence"+nodeid;
var conevidencekey = currentime+"ConEvidence"+nodeid;
var followkey = currentime+"Follow"+nodeid;
var themekey = currentime+"Theme"+nodeid;
var challengekey = currentime+"Challenge"+nodeid;
var seealsokey = currentime+"SeeAlso"+nodeid;

var followisopen = false;
var themeisopen = false;
var orgisopen = false;
var projectisopen = false;
var seealsoisopen = false;
var suggestedorgisopen = false;
var suggestedissueisopen = false;
var issueisopen = true;
var proevidenceisopen = true;
var conevidenceisopen = true;

var nodeheight = 500;
var issueheight = 495;
var proevidenceheight = 240;
var conevidenceheight = 240;

var followheight = 300;
var themeheight = 300;
var orgheight = 300;
var projectheight = 300;
var seealsoheight = 300;
var suggestedorgheight = 300;
var suggestedissueheight = 300;

var leftColumn = {};
leftColumn[issuekey] = 'issuesarea';

var rightColumn = {};
rightColumn[proevidencekey] = 'prosarea';
rightColumn[conevidencekey] = 'consarea';

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
recommendColumn['recommendationkey'] = 'recommendationarea';
recommendColumn[suggestedorgkey] = 'suggestedorgsarea';
recommendColumn[suggestedissuekey] = 'suggestedissuesarea';
<?php } ?>

function loadClaimWidgetPage() {
	nodeid = CLAIM_ARGS['nodeid'];

	//refreshWidgetComments();
	refreshWidgetThemes();

	refreshWidgetEvidence("Pro", "");
	refreshWidgetEvidence("Con", "");
	refreshWidgetIssues("");

	refreshWidgetSeeAlso("");
	refreshWidgetOrganizations("");
	refreshWidgetProjects("");

	refreshWidgetFollowers();

	<?php if ($CFG->hasRecommendations) { ?>
	$('suggestedorgsarea').update(buildThemeSuggestionByType(NODE_ARGS['nodeid'], 'Organization,Project', '<?php echo $LNG->RECOMMENDATION_ORG_THEMES; ?>', suggestedorgheight, suggestedorgisopen, 'recommendwidgetback', suggestedorgkey));
	$('suggestedissuesarea').update(buildThemeSuggestionByType(NODE_ARGS['nodeid'], 'Issue', '<?php echo $LNG->RECOMMENDATION_ISSUE_THEMES; ?>', suggestedissueheight, suggestedissueisopen, 'recommendwidgetback', suggestedissuekey));
	<?php } ?>

	refreshNodeClaim();
	Event.observe(window,"resize",resizeWidgets);
	resizeWidgets();
};

function resizeWidgets() {
	resizeKeyWidget(orgkey);
	resizeKeyWidget(projectkey);

	resizeKeyWidget(followkey);
	resizeKeyWidget(themekey);
	resizeKeyWidget(seealsokey);

	resizeKeyWidget(issuekey);
	resizeKeyWidget(proevidencekey);
	resizeKeyWidget(conevidencekey);

	<?php if ($CFG->hasRecommendations) { ?>
	resizeKeyWidget(suggestedorgkey);
	resizeKeyWidget(suggestedissuekey);
	<?php } ?>

	resizeNodeWidget(nodekey, nodeheight);
}

function refreshNodeClaim() {
	var nodediv = buildNodeWidgetNew(nodeObj, nodeheight, "claim", nodekey,'claimback');
	$('nodearea').update(nodediv);

	$(nodekey+'body').addClassName('widgettextcolor');
	$(nodekey+'body').addClassName('claimbackpale');

	$(nodekey+'div').addClassName('claimbackpale');
	$(nodekey+'div').addClassName('claimborder');

	var screenWidth = getWindowWidth();
	var nodeWidth = $('nodearea').offsetWidth;
	var maxWidth = nodeWidth;
	maxWidth = Math.round(screenWidth*0.4);
	if (maxWidth < nodeWidth) {
		$('widgetcolnode').style.width = maxWidth+"px";
		$('widgetcolnode').style.maxWidth = maxWidth+"px";
	}

	$(nodekey+'headerinner').addClassName('claimback');
}

function refreshWidgetFollowers() {
	var isopen = getIsOpen($(followkey+"body"), followisopen);
	$('followersarea').update(followUsersWidget(nodeid,'<?php echo $LNG->EXPLORE_claimToFollower; ?>', followheight, isopen, 'followwidgetback', followkey));
	resizeKeyWidget(followkey);

	// for refreshing after an add/delete when expaned
	if ($('suggestedorgsarea') && $('suggestedorgsarea').style.display == 'none') {
		adjustForExpand($(followkey+"buttonresize"), followkey, followheight);
	}
}

function refreshWidgetThemes() {
	var isopen = getIsOpen($(themekey+"body"), themeisopen);
	$('themearea').update(buildThemeWidget(nodeid, themeheight, isopen, themekey, "<?php echo $LNG->EXPLORE_claimToTheme; ?>"));
	resizeKeyWidget(themekey);

	// for refreshing after an add/delete when expaned
	if ($('seealsoarea') && $('seealsoarea').style.display == 'none') {
		adjustForExpand($(themekey+"buttonresize"), themekey, themeheight);
	}
}

function refreshWidgetEvidence(type, nodetofocusid) {
	if (type == "Pro") {
		var isopen = getIsOpen($(proevidencekey+"body"), proevidenceisopen, nodetofocusid);
		$('prosareainner').update(buildEvidenceWidget(NODE_ARGS['nodeid'], "<?php echo $LNG->EXPLORE_claimToEvidenceSupport; ?>", "Pro", "supports", proevidenceheight, isopen, proevidencekey, nodetofocusid));
		resizeKeyWidget(proevidencekey);

		// for refreshing after an add/delete when expaned
		if ($('consareainner') && $('consareainner').style.display == 'none') {
			adjustForExpand($(proevidencekey+"buttonresize"), proevidencekey, proevidenceheight);
		}
	} else {
		var isopen = getIsOpen($(conevidencekey+"body"), conevidenceisopen, nodetofocusid);
		$('consareainner').update(buildEvidenceWidget(NODE_ARGS['nodeid'], "<?php echo $LNG->EXPLORE_claimToEvidenceCounter; ?>", "Con", "challenges", conevidenceheight, isopen, conevidencekey, nodetofocusid));
		resizeKeyWidget(conevidencekey);

		// for refreshing after an add/delete when expaned
		if ($('prosareainner') && $('prosareainner').style.display == 'none') {
			adjustForExpand($(conevidencekey+"buttonresize"), conevidencekey, conevidenceheight);
		}
	}
}

function refreshWidgetIssues(nodetofocusid) {
	var isopen = getIsOpen($(issuekey+"body"), issueisopen, nodetofocusid);
	$('issuesareainner').update(buildClaimToIssueWidget(NODE_ARGS['nodeid'],'<?php echo $LNG->EXPLORE_claimToIssue; ?>', issueheight, isopen, issuekey, nodetofocusid));
	resizeKeyWidget(issuekey);

	// for refreshing after an add/delete when expaned
	if ($('orgsarea') && $('orgsarea').style.display == 'none') {
		adjustForExpand($(issuekey+"buttonresize"), issuekey, issueheight);
	}
}

function refreshWidgetOrganizations(nodetofocusid) {
	var isopen = getIsOpen($(orgkey+"body"), orgisopen, nodetofocusid);
	$('orgsarea').update(buildClaimToOrgWidget(nodeid,'<?php echo $LNG->EXPLORE_claimToOrg; ?>', orgheight, isopen, orgkey, nodetofocusid));
	resizeKeyWidget(orgkey);

	// for refreshing after an add/delete when expaned
	if ($('themearea') && $('themearea').style.display == 'none') {
		adjustForExpand($(orgkey+"buttonresize"), orgkey, orgheight);
	}
}

function refreshWidgetProjects(nodetofocusid) {
	var isopen = getIsOpen($(projectkey+"body"), projectisopen, nodetofocusid);
	$('projectsarea').update(buildClaimToProjectWidget(nodeid,'<?php echo $LNG->EXPLORE_claimToProject; ?>', projectheight, isopen, projectkey, nodetofocusid));
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

loadClaimWidgetPage();