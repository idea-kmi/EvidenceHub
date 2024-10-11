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
var orgkey = currentime+'Org'+nodeid;
var projectkey = currentime+'Project'+nodeid;
var followkey = currentime+"Follow"+nodeid;
var themekey = currentime+"Theme"+nodeid;
var relatedkey = currentime+"RelatedReources"+nodeid;
var seealsokey = currentime+"SeeAlso"+nodeid;
var suggestedorgkey = currentime+'SuggestedOrg'+nodeid;
var suggestedissuekey = currentime+'SuggestedIssue'+nodeid;
var suggestedsolutionkey = currentime+'SuggestedSolution'+nodeid;
var suggestedclaimkey = currentime+'SuggestedClaim'+nodeid;
var evidencekey = currentime+"Evidence"+nodeid;

var followisopen = false;
var themeisopen = false;
var orgisopen = false;
var projectisopen = false;
var relatedisopen = false;
var seealsoisopen = false;
var suggestedorgisopen = false;
var suggestedissueisopen = false;
var suggestedsolutionisopen = false;
var suggestedclaimisopen = false;
var evidenceisopen = true;

var nodeheight = 500;
var evidenceheight = 495;

var followheight = 300;
var themeheight = 300;
var orgheight = 300;
var projectheight = 300;
var relatedheight = 300;
var seealsoheight = 300;
var suggestedorgheight = 300;
var suggestedissueheight = 300;
var suggestedsolutionheight = 300;
var suggestedclaimheight = 300;

var leftColumn = {};
leftColumn[evidencekey] = 'evidencesarea';

var extraColumn = {};
extraColumn[themekey] = 'themearea';
extraColumn[seealsokey] = 'seealsoarea';
extraColumn[followkey] = 'followersarea';

var relatedColumn = {};
relatedColumn[orgkey] = 'orgsarea';
relatedColumn[projectkey] = 'projectsarea';
relatedColumn[relatedkey] = 'relatedresourcesarea';

var recommendColumn = {};
<?php if ($CFG->hasRecommendations) { ?>
recommendColumn[suggestedorgkey] = 'suggestedorgsarea';
recommendColumn[suggestedissuekey] = 'suggestedissuesarea';
if (hasSolution) {
	recommendColumn[suggestedsolutionkey] = 'suggestedsolutionsarea';
}
if (hasClaim) {
	recommendColumn[suggestedclaimkey] = 'suggestedclaimsarea';
}
<?php } ?>

function loadResourceWidgetPage() {

	refreshWidgetEvidence();

	refreshWidgetThemes();
	refreshWidgetFollowers();

	refreshWidgetOrganizations("");
	refreshWidgetProjects("");

	drawRelatedResources();
	refreshWidgetSeeAlso("");

	<?php if ($CFG->hasRecommendations) { ?>
	$('suggestedorgsarea').update(buildThemeSuggestionByType(NODE_ARGS['nodeid'], 'Organization,Project', '<?php echo $LNG->RECOMMENDATION_ORG_THEMES; ?>', suggestedorgheight, suggestedorgisopen, 'recommendwidgetback', suggestedorgkey));
	$('suggestedissuesarea').update(buildThemeSuggestionByType(NODE_ARGS['nodeid'], 'Issue', '<?php echo $LNG->RECOMMENDATION_ISSUE_THEMES; ?>', suggestedissueheight, suggestedissueisopen, 'recommendwidgetback', suggestedissuekey));

	if (hasSolution) {
		$('suggestedsolutionsarea').update(buildThemeSuggestionByType(NODE_ARGS['nodeid'], 'Solution', '<?php echo $LNG->RECOMMENDATION_SOLUTION_THEMES; ?>', suggestedsolutionheight, suggestedsolutionisopen, 'recommendwidgetback', suggestedsolutionkey));
	}
	if (hasClaim) {
		$('suggestedclaimsarea').update(buildThemeSuggestionByType(NODE_ARGS['nodeid'], 'Claim', '<?php echo $LNG->RECOMMENDATION_CLAIM_THEMES; ?>', suggestedclaimheight, suggestedclaimisopen, 'recommendwidgetback', suggestedclaimkey));
	}
	<?php } ?>

	refreshNodeResource();
	Event.observe(window,"resize",resizeWidgets);
	resizeWidgets();
};

function resizeWidgets() {
	resizeKeyWidget(evidencekey);
	resizeKeyWidget(themekey);
	resizeKeyWidget(orgkey);
	resizeKeyWidget(projectkey);

	resizeKeyWidget(followkey);
	resizeKeyWidget(relatedkey);

	<?php if ($CFG->hasRecommendations) { ?>
	resizeKeyWidget(suggestedorgkey);
	resizeKeyWidget(suggestedissuekey);
	if (hasSolution) {
		resizeKeyWidget(suggestedsolutionkey);
	}
	if (hasClaim) {
		resizeKeyWidget(suggestedclaimkey);
	}
	<?php } ?>

	resizeNodeWidget(nodekey, nodeheight);
}

function refreshNodeResource() {
	var nodediv = buildNodeWidgetNew(nodeObj, nodeheight, "web", nodekey, 'resourceback');
	$('nodearea').update(nodediv);

	$(nodekey+'body').addClassName('widgettextcolor');
	$(nodekey+'body').addClassName('resourcebackpale');

	$(nodekey+'div').addClassName('resourcebackpale');
	$(nodekey+'div').addClassName('resourceborder');

	$(nodekey+'headerinner').addClassName('resourceback');

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

function refreshWidgetEvidence(type, nodetofocusid) {
	var isopen = getIsOpen($(evidencekey+"body"), evidenceisopen);
	$('evidencesareainner').update(buildResourceToEvidenceWidget(nodeid,'<?php echo $LNG->EXPLORE_resourceToEvidence; ?>', evidenceheight, isopen, evidencekey, nodetofocusid));
	resizeKeyWidget(evidencekey);

	// for refreshing after an add/delete when expaned
	if ($('themearea') && $('themearea').style.display == 'none') {
		adjustForExpand($(evidencekey+"buttonresize"), evidencekey, evidenceheight);
	}
}

function refreshWidgetFollowers() {
	var isopen = getIsOpen($(followkey+"body"), followisopen);
	$('followersarea').update(followUsersWidget(nodeid,'<?php echo $LNG->EXPLORE_resourceToFollower; ?>', followheight, isopen, 'followwidgetback', followkey));
	resizeKeyWidget(followkey);

	// for refreshing after an add/delete when expaned
	if ($('themearea') && $('themearea').style.display == 'none') {
		adjustForExpand($(followkey+"buttonresize"), followkey, followheight);
	}
}

function refreshWidgetThemes() {
	var isopen = getIsOpen($(themekey+"body"), themeisopen);
	$('themearea').update(buildThemeWidget(nodeid, themeheight, isopen, themekey, "<?php echo $LNG->EXPLORE_resourceToTheme; ?>"));
	resizeKeyWidget(themekey);

	// for refreshing after an add/delete when expaned
	if ($('seealsoarea') && $('seealsoarea').style.display == 'none') {
		adjustForExpand($(themekey+"buttonresize"), themekey, themeheight);
	}
}

function refreshWidgetOrganizations(nodetofocusid) {
	var isopen = getIsOpen($(orgkey+"body"), orgisopen, nodetofocusid);
	$('orgsarea').update(buildResourceToOrgWidget(nodeid,'<?php echo $LNG->EXPLORE_resourceToOrg; ?>', orgheight, isopen, orgkey, nodetofocusid));
	resizeKeyWidget(orgkey);

	// for refreshing after an add/delete when expaned
	if ($('themearea') && $('themearea').style.display == 'none') {
		adjustForExpand($(orgkey+"buttonresize"), orgkey, orgheight);
	}
}

function refreshWidgetProjects(nodetofocusid) {
	var isopen = getIsOpen($(projectkey+"body"), projectisopen, nodetofocusid);
	$('projectsarea').update(buildResourceToProjectWidget(nodeid,'<?php echo $LNG->EXPLORE_resourceToProject; ?>', projectheight, isopen, projectkey, nodetofocusid));
	resizeKeyWidget(projectkey);

	// for refreshing after an add/delete when expaned
	if ($('themearea') && $('themearea').style.display == 'none') {
		adjustForExpand($(projectkey+"buttonresize"), projectkey, projectheight);
	}
}

function drawRelatedResources() {
	$('relatedresourcesarea').update(buildRelatedResourcesWidget(nodeid, "<?php echo $LNG->EXPLORE_resourceToResource; ?>", nodeObj.name, relatedheight, false, relatedkey));
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

loadResourceWidgetPage();