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
var nodeid = CHALLENGE_ARGS['nodeid'];

var nodekey = "Node"+nodeid;
var issuekey = currentime+"Issue"+nodeid;
var followkey = currentime+"Follow"+nodeid;
var themekey = currentime+"Theme"+nodeid;
var orgkey = currentime+"Org"+nodeid;
var projectkey = currentime+"Project"+nodeid;
var seealsokey = currentime+"SeeAlso"+nodeid;
var suggestedorgkey = currentime+'SuggestedOrg'+nodeid;
var suggestedissuekey = currentime+'SuggestedIssue'+nodeid;

var followisopen = false;
var themeisopen = false;
var orgisopen = false;
var projectisopen = false;
var seealsoisopen = false;
var suggestedorgisopen = false;
var suggestedissueisopen = false;
var issueisopen = true;

var nodeheight = 500; //not used now
var issueheight = 500;

var followheight = 300;
var themeheight = 300;
var seealsoheight = 300;
var orgheight = 300;
var projectheight = 300;
var suggestedorgheight = 300;
var suggestedissueheight = 300;

var rightColumn = {};
rightColumn[issuekey] = 'issuesarea';

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
recommendColumn[suggestedissuekey] = 'suggestedissuesarea';
<?php } ?>

function loadChallengeWidgetPage () {

	refreshWidgetIssues();
	refreshWidgetOrganizations("");
	refreshWidgetProjects("");
	refreshWidgetSeeAlso("");

	refreshWidgetThemes();
	refreshWidgetFollowers();

	<?php if ($CFG->hasRecommendations) { ?>
	$('suggestedorgsarea').update(buildThemeSuggestionByType(nodeid, 'Organization,Project', '<?php echo $LNG->RECOMMENDATION_ORG_THEMES; ?>', suggestedorgheight, suggestedorgisopen, 'recommendwidgetback', suggestedorgkey));
	$('suggestedissuesarea').update(buildThemeSuggestionByType(nodeid, 'Issue', '<?php echo $LNG->RECOMMENDATION_ISSUE_THEMES; ?>', suggestedissueheight, suggestedissueisopen, 'recommendwidgetback', suggestedissuekey));
	<?php } ?>

	refreshNodeChallenge();
	Event.observe(window,"resize",resizeWidgets);
	resizeWidgets();
};

function resizeWidgets() {
	resizeKeyWidget(themekey);
	resizeKeyWidget(issuekey);
	resizeKeyWidget(orgkey);
	resizeKeyWidget(projectkey);
	resizeKeyWidget(seealsokey);

	resizeKeyWidget(followkey);

	<?php if ($CFG->hasRecommendations) { ?>
	resizeKeyWidget(suggestedorgkey);
	resizeKeyWidget(suggestedissuekey);
	<?php } ?>

	resizeNodeWidget(nodekey, nodeheight);
}

function refreshNodeChallenge() {
	var nodediv = buildNodeWidgetNew(nodeObj, nodeheight, "challenge", nodekey, 'challengeback');
	$('nodearea').update(nodediv);

	$(nodekey+'body').addClassName('widgettextcolor');
	$(nodekey+'body').addClassName('challengebackpale');

	$(nodekey+'div').addClassName('challengebackpale');
	$(nodekey+'div').addClassName('challengeborder');

	$(nodekey+'headerinner').addClassName('challengeback');

	// make sure width is never more than 60% of the screen area.
	var screenWidth = getWindowWidth();
	var nodeWidth = $('nodearea').offsetWidth;
	var maxWidth = nodeWidth;
	maxWidth = Math.round(screenWidth*0.6);
	if (maxWidth < nodeWidth) {
		$('widgetcolnode').style.width = maxWidth+"px";
		$('widgetcolnode').style.maxWidth = maxWidth+"px";
	}

	resizeNodeWidget(nodekey, nodeheight);
}

function refreshWidgetThemes() {
	var isopen = getIsOpen($(themekey+"body"), themeisopen);
	$('themearea').update(buildThemeWidget(nodeid, themeheight, isopen, themekey, "<?php echo $LNG->EXPLORE_challengeToTheme; ?>"));
	resizeKeyWidget(themekey);

	// for refreshing after an add/delete when expaned
	if ($('seealsoarea') && $('seealsoarea').style.display == 'none') {
		adjustForExpand($(themekey+"buttonresize"), themekey, themeheight);
	}
}

function refreshWidgetIssues(nodetofocusid) {
	var isopen = getIsOpen($(issuekey+"body"), issueisopen, nodetofocusid);
	$('issuesareainner').update(buildChallengeToIssueWidget(nodeid, '<?php echo $LNG->EXPLORE_challengeToIssue; ?>', issueheight, isopen, issuekey, nodetofocusid));
	resizeKeyWidget(issuekey);

	// for refreshing after an add/delete when expaned
	if ($('themearea') && $('themearea').style.display == 'none') {
		adjustForExpand($(issuekey+"buttonresize"), issuekey, issueheight);
	}
}

function refreshWidgetOrganizations(nodetofocusid) {
	var isopen = getIsOpen($(orgkey+"body"), orgisopen, nodetofocusid);
	$('orgsarea').update(buildChallengeToOrgWidget(nodeid,'<?php echo $LNG->EXPLORE_challengeToOrg; ?>', orgheight, isopen, orgkey, nodetofocusid));
	resizeKeyWidget(orgkey);

	// for refreshing after an add/delete when expaned
	if ($('themearea') && $('themearea').style.display == 'none') {
		adjustForExpand($(orgkey+"buttonresize"), orgkey, orgheight);
	}
}

function refreshWidgetProjects(nodetofocusid) {
	var isopen = getIsOpen($(projectkey+"body"), projectisopen, nodetofocusid);
	$('projectsarea').update(buildChallengeToProjectWidget(nodeid,'<?php echo $LNG->EXPLORE_challengeToProject; ?>', projectheight, isopen, projectkey, nodetofocusid));
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

function refreshWidgetFollowers() {
	var isopen = getIsOpen($(followkey+"body"), followisopen);
	$('followersarea').update(followUsersWidget(nodeid,'<?php echo $LNG->EXPLORE_challengeToFollower; ?>', followheight, isopen, 'followwidgetback', followkey));
	resizeKeyWidget(followkey);

	// for refreshing after an add/delete when expaned
	if ($('suggestedissuesarea') && $('suggestedissuesarea').style.display == 'none') {
		adjustForExpand($(followkey+"buttonresize"), followkey, followheight);
	}
}

loadChallengeWidgetPage();