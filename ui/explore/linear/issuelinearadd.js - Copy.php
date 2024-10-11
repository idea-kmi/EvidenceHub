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
?>

var currentime = new Date().getTime();
var debatenodeid = ISSUE_ARGS['nodeid'];
var debatenodekey = 'issue';
var debateNodeObj = nodeObj;

var challengeisopen = true;
var claimisopen = true;
var solutionisopen = true;

var nodekey = "AddNode"+debatenodeid;
var challengekey = currentime+"AddChallenge"+debatenodeid;
var claimkey = currentime+"AddClaim"+debatenodeid;
var solutionkey = currentime+"AddSolution"+debatenodeid;

var claimheight = 200;
var solutionheight = 200;
var challengeheight = 200;

var upArea = {};
if (CURRENT_ADD_AREA_HAS_UP) {
	upArea[challengekey] = 'debateadduparea';
	upArea['debateadduparrow'] = 'debateadduparrow';
}

var downArea = {};
<?php if ($CFG->HAS_SOLUTION) { ?>
	downArea[solutionkey] = 'solutionsarea';
<?php } ?>
<?php if ($CFG->HAS_CLAIM) { ?>
	downArea[claimkey] = 'claimsarea';
<?php } ?>

downArea['debateadddownarrow'] = 'debateadddownarrow';

function loadAddAreaData () {
	debateNodeObj = CURRENT_ADD_AREA_NODE;
	debatenodeid = CURRENT_ADD_AREA_NODEID;

	$('debateadduparea').innerHTML = "";
	$('debateadddownarea').innerHTML = "";

	$('debateadddownarea').style.display = "block";
	$('debateadddownarrow').style.display = "block";

	//UP
	if (hasChallenge && CURRENT_ADD_AREA_HAS_UP) {
		$('debateadduparea').style.display = "block";
		$('debateadduparrow').style.display = "block";
		refreshWidgetChallenges("");
	} else {
		$('debateadduparea').style.display = "none";
		$('debateadduparrow').style.display = "none";
	}

	refreshNodeIssueWidget();

	//DOWN
	if (hasSolution && hasClaim) {
		var claimsarea = new Element("div", {'id':'claimsarea', 'style':'padding-right:10px;width:190px;float:left;display: block;'});
		$('debateadddownarea').update(claimsarea);
		var solutionsarea = new Element("div", {'id':'solutionsarea', 'style':'width:190px;float:left;display: block;'});
		$('debateadddownarea').insert(solutionsarea);
		refreshWidgetClaims("");
		refreshWidgetSolutions("");
	} else if (hasSolution && !hasClaim) {
		var solutionsarea = new Element("div", {'id':'solutionsarea', 'style':'width:390px;float:left;display: block;'});
		$('debateadddownarea').insert(solutionsarea);
		refreshWidgetSolutions("");
	} else if (hasClaim && !hasSolution) {
		var claimsarea = new Element("div", {'id':'claimsarea', 'style':'width:390px;float:left;display: block;'});
		$('debateadddownarea').update(claimsarea);
		refreshWidgetClaims("");
	}

	if (hasChallenge && CURRENT_ADD_AREA_HAS_UP) {
		resizeKeyWidget(challengekey);
	}
	if (hasClaim) {
		resizeKeyWidget(claimkey);
	}
	if (hasSolution) {
		resizeKeyWidget(solutionkey);
	}

	/*
	if (!hasChallenge && hasSolution && !hasClaim) {
		$('addknowledge'+solutionkey+'button').click();
	} else if (!hasChallenge && hasClaim && !hasSolution) {
		$('addknowledge'+claimkey+'button').click();
	}
	*/
};

function refreshNodeIssueWidget() {
	var border = 'issueborder curvedBorder';
	var backcolor = 'focusedback';
	if (debateNodeObj.nodeid == nodeObj.nodeid) {
		backcolor = 'issueback';
	}
	var nodediv = buildNodeWidgetNewShort(debateNodeObj, "issue", nodekey, backcolor, border);

	$('nodearealinear').update(nodediv);
}

function refreshWidgetChallenges(nodetofocusid) {
	var isopen = getIsOpen($(challengekey+"body"), challengeisopen, nodetofocusid);
	$('debateadduparea').update(buildIssueToChallengeWidget(debatenodeid,'<?php echo $LNG->EXPLORE_issueToChallenge; ?>', challengeheight, isopen, challengekey, nodetofocusid));
	resizeKeyWidget(challengekey);

	// for refreshing after an add/delete when expaned
	if ($('nodearealinear') && $('nodearealinear').style.display == 'none') {
		adjustForExpand($(challengekey+"buttonresize"), challengekey, challengeheight);
	}
}

function refreshWidgetClaims(nodetofocusid) {
	var isopen = getIsOpen($(claimkey+"body"), claimisopen, nodetofocusid);
	$('claimsarea').update(buildIssueToClaimWidget(debatenodeid, '<?php echo $LNG->EXPLORE_issueToClaim; ?>', claimheight, isopen, claimkey, nodetofocusid));
	resizeKeyWidget(claimkey);

	// for refreshing after an add/delete when expaned
	if ($('solutionsarea') && $('solutionsarea').style.display == 'none') {
		adjustForExpand($(claimkey+"buttonresize"), claimkey, claimheight);
	}
}

function refreshWidgetSolutions(nodetofocusid) {
	var isopen = getIsOpen($(solutionkey+"body"), solutionisopen, nodetofocusid);
	$('solutionsarea').update(buildIssueToSolutionWidget(debatenodeid, '<?php echo $LNG->EXPLORE_issueToSolution; ?>', solutionheight, isopen, solutionkey, nodetofocusid));
	resizeKeyWidget(solutionkey);

	// for refreshing after an add/delete when expaned
	if ($('claimsarea') && $('claimsarea').style.display == 'none') {
		adjustForExpand($(solutionkey+"buttonresize"), solutionkey, solutionheight);
	}
}

loadAddAreaData();
