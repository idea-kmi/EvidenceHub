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

    include_once("../config.php");

    $countries = getCountryList();

?>

//this list the tabs
var TABS = {"home":true, "data":true, "social":true};

var DATAVIZ = {<?php if ($CFG->HAS_CHALLENGE) { echo '"challenge":true, '; } ?>"issue":true, <?php if ($CFG->HAS_SOLUTION) { echo '"solution":true, '; } ?> <?php if ($CFG->HAS_CLAIM) { echo '"claim":true,'; } ?> "evidence":true, "resource":true, "project":true, "org":true, "chat":true <?php if ($CFG->HAS_OPEN_COMMENTS) { echo ',"comment":true'; } ?>};

var DEFAULT_TAB = 'home';
var DEFAULT_VIZ = 'list';

var CURRENT_VIZ = DEFAULT_VIZ;
var CURRENT_TAB = DEFAULT_TAB;

var DATA_LOADED = {"home":false, "org":false, "project":false, "challenge":false, "issue":false, "solution":false, "claim":false, "evidence":false, "resource":false, "comment":false, "chat":false};

//define events for clicking on the tabs
var stpHome = setTabPushed.bindAsEventListener($('tab-home-list-obj'),'home');
var stpData = setTabPushed.bindAsEventListener($('tab-data-list-obj'),'data');
var stpSocial = setTabPushed.bindAsEventListener($('tab-social-list-obj'),'social');

<?php if ($CFG->HAS_CHALLENGE) { ?>
	var stpChallengeList = setTabPushed.bindAsEventListener($('tab-challenge-list-obj'),'data-challenge');
<?php } ?>
<?php if ($CFG->HAS_SOLUTION) { ?>
	var stpSolutionList = setTabPushed.bindAsEventListener($('tab-solution-list-obj'),'data-solution');
<?php } ?>
<?php if ($CFG->HAS_CLAIM) { ?>
	var stpClaimList = setTabPushed.bindAsEventListener($('tab-claim-list-obj'),'data-claim');
<?php } ?>

var stpOrgList = setTabPushed.bindAsEventListener($('tab-org-list-obj'),'data-org');
var stpProjectList = setTabPushed.bindAsEventListener($('tab-project-list-obj'),'data-project');
var stpIssueList = setTabPushed.bindAsEventListener($('tab-issue-list-obj'),'data-issue');
var stpEvidenceList = setTabPushed.bindAsEventListener($('tab-evidence-list-obj'),'data-evidence');
var stpResourceList = setTabPushed.bindAsEventListener($('tab-resource-list-obj'),'data-resource');

<?php if ($CFG->HAS_OPEN_COMMENTS) { ?>
	var stpCommentList = setTabPushed.bindAsEventListener($('tab-comment-list-obj'),'data-comment');
<?php } ?>

var stpChatList = setTabPushed.bindAsEventListener($('tab-chat-list-obj'),'data-chat');

/**
 *	set which tab to show and load first
 */
Event.observe(window, 'load', function() {

	// add events for clicking on the main tabs
	Event.observe('tab-home','click', stpHome);
	Event.observe('tab-data','click', stpData);
	Event.observe('tab-social','click', stpSocial);

	if (hasChallenge && $("tab-data-challenge")) {
		Event.observe('tab-data-challenge','click', stpChallengeList);
	}
	if (hasSolution) {
		Event.observe('tab-data-solution','click', stpSolutionList);
	}
	if (hasClaim) {
		Event.observe('tab-data-claim','click', stpClaimList);
	}
	if ($("tab-data-comment")) {
		Event.observe('tab-data-comment','click', stpCommentList);
	}
	Event.observe('tab-data-chat','click', stpChatList);
	Event.observe('tab-data-org','click', stpOrgList);
	Event.observe('tab-data-project','click', stpProjectList);
	Event.observe('tab-data-issue','click', stpIssueList);
	Event.observe('tab-data-evidence','click', stpEvidenceList);
	Event.observe('tab-data-resource','click', stpResourceList);

	setTabPushed($('tab-'+getAnchorVal(DEFAULT_TAB + "-" + DEFAULT_VIZ)),getAnchorVal(DEFAULT_TAB + "-" + DEFAULT_VIZ));
});

/**
 *	switch between tabs
 */
function setTabPushed(e) {

	var data = $A(arguments);
	var tabID = data[1];

	// get tab and the visualisation from the #
	var parts = tabID.split("-");
	var tab = parts[0];
	var viz="";
	if (parts.length > 1) {
		viz = parts[1];
	}
	var page=1;
	if (parts.length > 2) {
		page = parseInt(parts[2]);
	}

	// Check tab is know else default to default
	if (!TABS.hasOwnProperty(tab)) {
		tab = DEFAULT_TAB;
		viz = DEFAULT_VIZ;
	}

	var i="";
	for (i in TABS){

		if ($("tab-"+i)) {
			if(tab == i){
				if($("tab-"+i)) {
					$("tab-"+i).addClassName("active");
					if ($("tab-content-"+i+"-div")) {
						$("tab-content-"+i+"-div").show();
					}
				}
			} else {
				if($("tab-"+i)) {
					$("tab-"+i).removeClassName("active");
					if ($("tab-content-"+i+"-div")) {
						$("tab-content-"+i+"-div").hide();
					}
				}
			}
		}
	}



	if (tab =="data") {
		if (viz == "") {
			viz = "issue";
		}

		for (i in DATAVIZ){
			if(viz == i){
				if ($("tab-"+tab+"-"+i)) {
					$("tab-"+tab+"-"+i).addClassName("active");
					$("tab-content-"+tab+"-"+i+"-div").show();
					$("tab-content-"+tab+"-"+i).show();
				}
			} else {
				if ($("tab-"+tab+"-"+i)) {
					$("tab-"+tab+"-"+i).removeClassName("active");
					$("tab-content-"+tab+"-"+i+"-div").hide();
					$("tab-content-"+tab+"-"+i).hide();
				}
			}
		}
	}

	CURRENT_TAB = tab;
	CURRENT_VIZ = viz;

	//LOAD DATA IF REQUIRED
	if (tab == "social") {
		if (!DATA_LOADED.social) {
			loadUserHomeNet();
		}
	} else if (tab == "data") {
		switch(viz){
			case 'challenge':
				$('tab-data').setAttribute("href",'#data-challenge');
				StopObservingDataTab();
				Event.observe('tab-data','click', stpChallengeList);
				if(!DATA_LOADED.challenge){
					CHALLENGE_ARGS['start'] = (page-1) * CHALLENGE_ARGS['max'];
					loadchallenges(CONTEXT,CHALLENGE_ARGS);
				} else {
					updateAddressParameters(CHALLENGE_ARGS);
				}
				break;
			case 'org':
				$('tab-data').setAttribute("href",'#data-org');
				StopObservingDataTab();
				Event.observe('tab-data','click', stpOrgList);
				if(!DATA_LOADED.org){
					ORG_ARGS['start'] = (page-1) * ORG_ARGS['max'];
					loadorgs(CONTEXT,ORG_ARGS);
				} else {
					updateAddressParameters(ORG_ARGS);
				}
				break;
			case 'project':
				$('tab-data').setAttribute("href",'#data-project');
				StopObservingDataTab();
				Event.observe('tab-data','click', stpProjectList);
				if(!DATA_LOADED.project){
					PROJECT_ARGS['start'] = (page-1) * PROJECT_ARGS['max'];
					loadprojects(CONTEXT,PROJECT_ARGS);
				} else {
					updateAddressParameters(PROJECT_ARGS);
				}
				break;
			case 'issue':
				$('tab-data').setAttribute("href",'#data-issue');
				StopObservingDataTab();
				Event.observe('tab-data','click', stpIssueList);
				if(!DATA_LOADED.issue){
					ISSUE_ARGS['start'] = (page-1) * ISSUE_ARGS['max'];
					loadissues(CONTEXT,ISSUE_ARGS);
				} else {
					updateAddressParameters(ISSUE_ARGS);
				}
				break;
			case 'solution':
				$('tab-data').setAttribute("href",'#data-solution');
				StopObservingDataTab();
				Event.observe('tab-data','click', stpSolutionList);
				if(!DATA_LOADED.solution){
					SOLUTION_ARGS['start'] = (page-1) * SOLUTION_ARGS['max'];
					loadsolutions(CONTEXT,SOLUTION_ARGS);
				} else {
					updateAddressParameters(SOLUTION_ARGS);
				}
				break;
			case 'claim':
				$('tab-data').setAttribute("href",'#data-claim');
				StopObservingDataTab();
				Event.observe('tab-data','click', stpClaimList);
				if(!DATA_LOADED.claim){
					CLAIM_ARGS['start'] = (page-1) * CLAIM_ARGS['max'];
					loadclaims(CONTEXT,CLAIM_ARGS);
				} else {
					updateAddressParameters(CLAIM_ARGS);
				}
				break;
			case 'evidence':
				$('tab-data').setAttribute("href",'#data-evidence');
				StopObservingDataTab();
				Event.observe('tab-data','click', stpEvidenceList);
				if(!DATA_LOADED.evidence){
					EVIDENCE_ARGS['start'] = (page-1) * EVIDENCE_ARGS['max'];
					loadevidence(CONTEXT,EVIDENCE_ARGS);
				} else {
					updateAddressParameters(EVIDENCE_ARGS);
				}
				break;
			case 'resource':
				$('tab-data').setAttribute("href",'#data-resource');
				StopObservingDataTab();
				Event.observe('tab-data','click', stpResourceList);
				if(!DATA_LOADED.resource){
					RESOURCE_ARGS['start'] = (page-1) * RESOURCE_ARGS['max'];
					loadresources(CONTEXT,RESOURCE_ARGS);
				} else {
					updateAddressParameters(RESOURCE_ARGS);
				}
				break;
			case 'comment':
				$('tab-data').setAttribute("href",'#data-comment');
				StopObservingDataTab();
				Event.observe('tab-data','click', stpCommentList);
				if(!DATA_LOADED.comment){
					COMMENT_ARGS['start'] = (page-1) * COMMENT_ARGS['max'];
					loadcomments(CONTEXT,COMMENT_ARGS);
				} else {
					updateAddressParameters(COMMENT_ARGS);
				}
				break;
			case 'chat':
				$('tab-data').setAttribute("href",'#data-chat');
				StopObservingDataTab();
				Event.observe('tab-data','click', stpChatList);
				if(!DATA_LOADED.chat){
					CHAT_ARGS['start'] = (page-1) * CHAT_ARGS['max'];
					loadchats(CONTEXT,CHAT_ARGS);
				} else {
					updateAddressParameters(CHAT_ARGS);
				}
				break;
		}
	}
}

function StopObservingDataTab() {
	Event.stopObserving('tab-data','click');
}

function refreshChallenges() {
	loadchallenges(CONTEXT,CHALLENGE_ARGS);
}

function refreshIssues() {
	loadissues(CONTEXT,ISSUE_ARGS);
}

function refreshSolutions() {
	loadsolutions(CONTEXT,ISSUE_ARGS);
}

function refreshClaims() {
	loadclaims(CONTEXT,CLAIM_ARGS);
}

function refreshEvidence() {
	loadevidence(CONTEXT,EVIDENCE_ARGS);
}

function refreshResources() {
	loadresources(CONTEXT,RESOURCE_ARGS);
}
function refreshWebsites() {
	loadresources(CONTEXT,RESOURCE_ARGS);
}

function refreshOrganizations() {
	loadorgs(CONTEXT,ORG_ARGS);
}

function refreshProjects() {
	loadprojects(CONTEXT,PROJECT_ARGS);
}

function refreshComments() {
	loadcomments(CONTEXT,COMMENT_ARGS);
}

function refreshChats() {
	loadchats(CONTEXT,CHAT_ARGS);
}

function refreshData() {
	switch(CURRENT_VIZ){
		case 'challenge':
			loadchallenges(CONTEXT,CHALLENGE_ARGS);
			break;
		case 'issue':
			loadissues(CONTEXT,ISSUE_ARGS);
			break;
		case 'solution':
			loadsolutions(CONTEXT,ISSUE_ARGS);
			break;
		case 'claim':
			loadclaims(CONTEXT,CLAIM_ARGS);
			break;
		case 'evidence':
			loadevidence(CONTEXT,EVIDENCE_ARGS);
			break;
		case 'resource':
			loadresources(CONTEXT,RESOURCE_ARGS);
			break;
		case 'org':
			loadorgs(CONTEXT,ORG_ARGS);
			break;
		case 'project':
			loadprojects(CONTEXT,PROJECT_ARGS);
			break;
		case 'comment':
			loadcomments(CONTEXT,COMMENT_ARGS);
			break;
		case 'chat':
			loadchats(CONTEXT,CHAT_ARGS);
			break;
		default:
	}
}

// LOAD LISTS///

/**
 *	load next/previous set of nodes
 */
function loadchallenges(context,args){
	args['filternodetypes'] = "Challenge";

	updateAddressParameters(args);

	$("tab-content-data-challenge").update(getLoading("<?php echo$LNG->LOADING_CHALLENGES; ?>"));

	var reqUrl = SERVICE_ROOT + "&method=getnodesby" + context + "&" + Object.toQueryString(args);

	new Ajax.Request(reqUrl, { method:'get',
  			onSuccess: function(transport){

  				try {
  					var json = transport.responseText.evalJSON();
  				} catch(err) {
  					console.log(err);
  				}

      			if(json.error){
      				alert(json.error[0].message);
      				return;
      			}

      			//set the count in tab header
      			//$('challenge-list-count').innerHTML = "";
      			//$('challenge-list-count').insert("("+json.nodeset[0].totalno+")");

      			//$('challengebuttons').innerHTML = "";

				//display nav
				var total = json.nodeset[0].totalno;
				if (CURRENT_TAB == 'data') {
					var currentPage = (json.nodeset[0].start/args["max"]) + 1;
					window.location.hash = CURRENT_TAB+"-"+CURRENT_VIZ+"-"+currentPage;
				}
				$("tab-content-data-challenge").update(createNav(total,json.nodeset[0].start,json.nodeset[0].count,args,context,"challenges"));

				//display nodes
				if(json.nodeset[0].nodes.length > 0){
					//preprosses nodes to add searchid if it is there
					if (args['searchid'] && args['searchid'] != "") {
						var nodes = json.nodeset[0].nodes;
						var count = nodes.length;
						for (var i=0; i < count; i++) {
							var node = nodes[i];
							node.cnode.searchid = args['searchid'];
						}
					}

					var tb3 = new Element("div", {'class':'toolbarrow'});

					var sortOpts = {date: '<?php echo $LNG->SORT_CREATIONDATE; ?>', name: '<?php echo $LNG->SORT_TITLE; ?>', moddate: '<?php echo $LNG->SORT_MODDATE; ?>',connectedness:'<?php echo $LNG->SORT_CONNECTIONS; ?>', vote:'<?php echo $LNG->SORT_VOTES; ?>'};
					tb3.insert(displaySortForm(sortOpts,args,'challenge',reorderChallenges));

					tb3.insert(createThemeFilter(context, args, 'challenges'));
					tb3.insert(createConnectedFilter(context, args, 'challenges'));

					$("tab-content-data-challenge").insert(tb3);

					displayNodes($("tab-content-data-challenge"),json.nodeset[0].nodes,parseInt(args['start'])+1, true);
				} else {
					var tb3 = new Element("div", {'class':'toolbarrow'});
					tb3.insert(createThemeFilter(context, args, 'challenges'));
					tb3.insert(createConnectedFilter(context, args, 'challenges'));
					$("tab-content-data-challenge").insert(tb3);
				}

				//display nav
				if (total > parseInt( args["max"] )) {
					$("tab-content-data-challenge").insert(createNav(total,json.nodeset[0].start,json.nodeset[0].count,args,context,"challenges"));
				}
    		}
  		});
  	DATA_LOADED.challenge = true;
  	DATA_LOADED.challengesimile = false;
}

/**
 *	load next/previous set of organisation nodes
 */
function loadorgs(context,args){

	var types = "Organization";

	if (args['filternodetypes'] == "" || types.indexOf(args['filternodetypes']) == -1) {
		args['filternodetypes'] = types;
	}
	updateAddressParameters(args);

	$("tab-content-data-org").update(getLoading("<?php echo $LNG->LOADING_ORGS; ?>"));

	var reqUrl = SERVICE_ROOT + "&method=getnodesby" + context + "&" + Object.toQueryString(args);

	new Ajax.Request(reqUrl, { method:'get',
  			onSuccess: function(transport){

  				try {
  					var json = transport.responseText.evalJSON();
  				} catch(err) {
  					console.log(err);
  				}

      			if(json.error){
      				alert(json.error[0].message);
      				return;
      			}

      			//set the count in tab header
      			//$('org-list-count').innerHTML = "";
      			//$('org-list-count').insert("("+json.nodeset[0].totalno+")");

      			//$('orgbuttons').innerHTML = "";

				var total = json.nodeset[0].totalno;
				if (CURRENT_TAB == 'data') {
					var currentPage = (json.nodeset[0].start/args["max"]) + 1;
					window.location.hash = CURRENT_TAB+"-"+CURRENT_VIZ+"-"+currentPage;
				}
				var navbar = createNav(total,json.nodeset[0].start,json.nodeset[0].count,args,context,"orgs")

				$("tab-content-data-org").update(navbar);

				//display nodes
				if(json.nodeset[0].nodes.length > 0){
					//preprosses nodes to add searchid if it is there
					if (args['searchid'] && args['searchid'] != "") {
						var nodes = json.nodeset[0].nodes;
						var count = nodes.length;
						for (var i=0; i < count; i++) {
							var node = nodes[i];
							node.cnode.searchid = args['searchid'];
						}
					}

					var tb3 = new Element("div", {'class':'toolbarrow'});

					var sortOpts = {date: '<?php echo $LNG->SORT_CREATIONDATE; ?>', name: '<?php echo $LNG->SORT_TITLE; ?>', moddate: '<?php echo $LNG->SORT_MODDATE; ?>',connectedness:'<?php echo $LNG->SORT_CONNECTIONS; ?>'};
					tb3.insert(displaySortForm(sortOpts,args,'org',reorderOrgs));
					tb3.insert(createThemeFilter(context, args, 'orgs'));
					tb3.insert(createConnectedFilter(context, args, 'orgs'));

					$("tab-content-data-org").insert(tb3);
					displayNodes($("tab-content-data-org"),json.nodeset[0].nodes,parseInt(args['start'])+1, true);
				} else {
					var tb3 = new Element("div", {'class':'toolbarrow'});
					tb3.insert(createThemeFilter(context, args, 'orgs'));
					tb3.insert(createConnectedFilter(context, args, 'orgs'));
					$("tab-content-data-org").insert(tb3);
				}

				//display nav
				if (total > parseInt( args["max"] )) {
					$("tab-content-data-org").insert(createNav(total,json.nodeset[0].start,json.nodeset[0].count,args,context,"orgs"));
				}
    		}
  		});
  	DATA_LOADED.org = true;
}

/**
 *	load next/previous set of project nodes
 */
function loadprojects(context,args){

	var types = "Project";

	if (args['filternodetypes'] == "" || types.indexOf(args['filternodetypes']) == -1) {
		args['filternodetypes'] = types;
	}
	updateAddressParameters(args);

	$("tab-content-data-project").update(getLoading("<?php echo $LNG->LOADING_PROJECTS; ?>"));

	var reqUrl = SERVICE_ROOT + "&method=getnodesby" + context + "&" + Object.toQueryString(args);

	new Ajax.Request(reqUrl, { method:'get',
  			onSuccess: function(transport){

  				try {
  					var json = transport.responseText.evalJSON();
  				} catch(err) {
  					console.log(err);
  				}

      			if(json.error){
      				alert(json.error[0].message);
      				return;
      			}

      			//set the count in tab header
      			//$('project-list-count').innerHTML = "";
      			//$('project-list-count').insert("("+json.nodeset[0].totalno+")");

      			//$('projectbuttons').innerHTML = "";

				var total = json.nodeset[0].totalno;
				if (CURRENT_TAB == 'data') {
					var currentPage = (json.nodeset[0].start/args["max"]) + 1;
					window.location.hash = CURRENT_TAB+"-"+CURRENT_VIZ+"-"+currentPage;
				}
				var navbar = createNav(total,json.nodeset[0].start,json.nodeset[0].count,args,context,"projects")

				$("tab-content-data-project").update(navbar);

				//display nodes
				if(json.nodeset[0].nodes.length > 0){
					//preprosses nodes to add searchid if it is there
					if (args['searchid'] && args['searchid'] != "") {
						var nodes = json.nodeset[0].nodes;
						var count = nodes.length;
						for (var i=0; i < count; i++) {
							var node = nodes[i];
							node.cnode.searchid = args['searchid'];
						}
					}

					var tb3 = new Element("div", {'class':'toolbarrow'});

					var sortOpts = {date: '<?php echo $LNG->SORT_CREATIONDATE; ?>', name: '<?php echo $LNG->SORT_TITLE; ?>', moddate: '<?php echo $LNG->SORT_MODDATE; ?>',connectedness:'<?php echo $LNG->SORT_CONNECTIONS; ?>'};
					tb3.insert(displaySortForm(sortOpts,args,'project',reorderProjects));
					tb3.insert(createThemeFilter(context, args, 'projects'));
					tb3.insert(createConnectedFilter(context, args, 'projects'));

					$("tab-content-data-project").insert(tb3);
					displayNodes($("tab-content-data-project"),json.nodeset[0].nodes,parseInt(args['start'])+1, true);
				} else {
					var tb3 = new Element("div", {'class':'toolbarrow'});
					tb3.insert(createThemeFilter(context, args, 'projects'));
					tb3.insert(createConnectedFilter(context, args, 'projects'));
					$("tab-content-data-project").insert(tb3);
				}

				//display nav
				if (total > parseInt( args["max"] )) {
					$("tab-content-data-project").insert(createNav(total,json.nodeset[0].start,json.nodeset[0].count,args,context,"projects"));
				}
    		}
  		});
  	DATA_LOADED.project = true;
}

/**
 *	load next/previous set of nodes
 */
function loadissues(context,args){
	args['filternodetypes'] = "Issue";
	updateAddressParameters(args);

	$("tab-content-data-issue").update(getLoading("<?php echo $LNG->LOADING_ISSUES; ?>"));

	var reqUrl = SERVICE_ROOT + "&method=getnodesby" + context + "&" + Object.toQueryString(args);

	new Ajax.Request(reqUrl, { method:'get',
  			onSuccess: function(transport){

  				try {
  					var json = transport.responseText.evalJSON();
  				} catch(err) {
  					console.log(err);
  				}

      			if(json.error){
      				alert(json.error[0].message);
      				return;
      			}

      			//set the count in tab header
      			//$('issue-list-count').innerHTML = "";
      			//$('issue-list-count').insert("("+json.nodeset[0].totalno+")");

      			//$('issuebuttons').innerHTML = "";

				//display nav
				var total = json.nodeset[0].totalno;
				if (CURRENT_TAB == 'data') {
					var currentPage = (json.nodeset[0].start/args["max"]) + 1;
					window.location.hash = CURRENT_TAB+"-"+CURRENT_VIZ+"-"+currentPage;
				}
				$("tab-content-data-issue").update(createNav(total,json.nodeset[0].start,json.nodeset[0].count,args,context,"issues"));

				//display nodes
				if(json.nodeset[0].nodes.length > 0){
					//preprosses nodes to add searchid if it is there
					if (args['searchid'] && args['searchid'] != "") {
						var nodes = json.nodeset[0].nodes;
						var count = nodes.length;
						for (var i=0; i < count; i++) {
							var node = nodes[i];
							node.cnode.searchid = args['searchid'];
						}
					}

					var tb3 = new Element("div", {'class':'toolbarrow'});

					var sortOpts = {date: '<?php echo $LNG->SORT_CREATIONDATE; ?>', name: '<?php echo $LNG->SORT_TITLE; ?>', moddate: '<?php echo $LNG->SORT_MODDATE; ?>',connectedness:'<?php echo $LNG->SORT_CONNECTIONS; ?>', vote:'<?php echo $LNG->SORT_VOTES; ?>'};
					tb3.insert(displaySortForm(sortOpts,args,'issue',reorderIssues));
					tb3.insert(createThemeFilter(context, args, 'issues'));
					tb3.insert(createConnectedFilter(context, args, 'issues'));

					$("tab-content-data-issue").insert(tb3);

					displayNodes($("tab-content-data-issue"),json.nodeset[0].nodes,parseInt(args['start'])+1, true);
				} else {
					var tb3 = new Element("div", {'class':'toolbarrow'});
					tb3.insert(createThemeFilter(context, args, 'issues'));
					tb3.insert(createConnectedFilter(context, args, 'issues'));
					$("tab-content-data-issue").insert(tb3);
				}

				//display nav
				if (total > parseInt( args["max"] )) {
					$("tab-content-data-issue").insert(createNav(total,json.nodeset[0].start,json.nodeset[0].count,args,context,"issues"));
				}
    		}
  		});
  	DATA_LOADED.issue = true;
}

/**
 *	load next/previous set of nodes
 */
function loadsolutions(context,args){
	args['filternodetypes'] = "Solution";
	updateAddressParameters(args);

	$("tab-content-data-solution").update(getLoading("<?php echo $LNG->LOADING_SOLUTIONS; ?>"));

	var reqUrl = SERVICE_ROOT + "&method=getnodesby" + context + "&" + Object.toQueryString(args);

	new Ajax.Request(reqUrl, { method:'get',
  			onSuccess: function(transport){

  				try {
  					var json = transport.responseText.evalJSON();
  				} catch(err) {
  					console.log(err);
  				}

      			if(json.error){
      				alert(json.error[0].message);
      				return;
      			}

      			//set the count in tab header
      			//$('solution-list-count').innerHTML = "";
      			//$('solution-list-count').insert("("+json.nodeset[0].totalno+")");

      			//$('solutionbuttons').innerHTML = "";

				//display nav
				var total = json.nodeset[0].totalno;
				if (CURRENT_TAB == 'data') {
					var currentPage = (json.nodeset[0].start/args["max"]) + 1;
					window.location.hash = CURRENT_TAB+"-"+CURRENT_VIZ+"-"+currentPage;
				}
				$("tab-content-data-solution").update(createNav(total,json.nodeset[0].start,json.nodeset[0].count,args,context,"solutions"));

				if(json.nodeset[0].nodes.length > 0){
					//preprosses nodes to add searchid if it is there
					if (args['searchid'] && args['searchid'] != "") {
						var nodes = json.nodeset[0].nodes;
						var count = nodes.length;
						for (var i=0; i < count; i++) {
							var node = nodes[i];
							node.cnode.searchid = args['searchid'];
						}
					}

					var tb3 = new Element("div", {'class':'toolbarrow'});

					var sortOpts = {date: '<?php echo $LNG->SORT_CREATIONDATE; ?>', name: '<?php echo $LNG->SORT_TITLE; ?>', moddate: '<?php echo $LNG->SORT_MODDATE; ?>',connectedness:'<?php echo $LNG->SORT_CONNECTIONS; ?>', vote:'<?php echo $LNG->SORT_VOTES; ?>'};
					tb3.insert(displaySortForm(sortOpts,args,'solution',reorderSolutions));
					tb3.insert(createThemeFilter(context, args, 'solutions'));
					tb3.insert(createConnectedFilter(context, args, 'solutions'));

					$("tab-content-data-solution").insert(tb3);
					displayNodes($("tab-content-data-solution"),json.nodeset[0].nodes,parseInt(args['start'])+1, true);
				} else {
					var tb3 = new Element("div", {'class':'toolbarrow'});
					tb3.insert(createThemeFilter(context, args, 'solutions'));
					tb3.insert(createConnectedFilter(context, args, 'solutions'));
					$("tab-content-data-solution").insert(tb3);
				}

				//display nav
				if (total > parseInt( args["max"] )) {
					$("tab-content-data-solution").insert(createNav(total,json.nodeset[0].start,json.nodeset[0].count,args,context,"solutions"));
				}
    		}
  		});
  	DATA_LOADED.solution = true;
}

/**
 *	load next/previous set of nodes
 */
function loadclaims(context,args){
	args['filternodetypes'] = "Claim";
	updateAddressParameters(args);

	$("tab-content-data-claim").update(getLoading("<?php echo $LNG->LOADING_CLAIMS; ?>"));

	var reqUrl = SERVICE_ROOT + "&method=getnodesby" + context + "&" + Object.toQueryString(args);

	new Ajax.Request(reqUrl, { method:'get',
  			onSuccess: function(transport){

  				try {
  					var json = transport.responseText.evalJSON();
  				} catch(err) {
  					console.log(err);
  				}

      			if(json.error){
      				alert(json.error[0].message);
      				return;
      			}

      			//set the count in tab header
      			//$('claim-list-count').innerHTML = "";
      			//$('claim-list-count').insert("("+json.nodeset[0].totalno+")");

  				//$('claimbuttons').innerHTML = "";

				//display nav
				var total = json.nodeset[0].totalno;
				if (CURRENT_TAB == 'data') {
					var currentPage = (json.nodeset[0].start/args["max"]) + 1;
					window.location.hash = CURRENT_TAB+"-"+CURRENT_VIZ+"-"+currentPage;
				}
				$("tab-content-data-claim").update(createNav(total,json.nodeset[0].start,json.nodeset[0].count,args,context,"claims"));

				if(json.nodeset[0].nodes.length > 0){
					//preprosses nodes to add searchid if it is there
					if (args['searchid'] && args['searchid'] != "") {
						var nodes = json.nodeset[0].nodes;
						var count = nodes.length;
						for (var i=0; i < count; i++) {
							var node = nodes[i];
							node.cnode.searchid = args['searchid'];
						}
					}

					var tb3 = new Element("div", {'class':'toolbarrow'});

					var sortOpts = {date: '<?php echo $LNG->SORT_CREATIONDATE; ?>', name: '<?php echo $LNG->SORT_TITLE; ?>', moddate: '<?php echo $LNG->SORT_MODDATE; ?>',connectedness:'<?php echo $LNG->SORT_CONNECTIONS; ?>', vote:'<?php echo $LNG->SORT_VOTES; ?>'};
					tb3.insert(displaySortForm(sortOpts,args,'claim',reorderClaims));
					tb3.insert(createThemeFilter(context, args, 'claims'));
					tb3.insert(createConnectedFilter(context, args, 'claims'));

					$("tab-content-data-claim").insert(tb3);
					displayNodes($("tab-content-data-claim"),json.nodeset[0].nodes,parseInt(args['start'])+1, true);
				} else {
					var tb3 = new Element("div", {'class':'toolbarrow'});
					tb3.insert(createThemeFilter(context, args, 'claims'));
					tb3.insert(createConnectedFilter(context, args, 'claims'));
					$("tab-content-data-claim").insert(tb3);
				}

				//display nav
				if (total > parseInt( args["max"] )) {
					$("tab-content-data-claim").insert(createNav(total,json.nodeset[0].start,json.nodeset[0].count,args,context,"claims"));
				}
    		}
  		});
  	DATA_LOADED.claim = true;
}

/**
 *	load next/previous set of evidence nodes
 */
function loadevidence(context,args) {

	var types = EVIDENCE_TYPES_STR;

	if (args['filternodetypes'] == "" || types.indexOf(args['filternodetypes']) == -1) {
		args['filternodetypes'] = types;
	}
	updateAddressParameters(args);

	$("tab-content-data-evidence").update(getLoading("<?php echo $LNG->LOADING_EVIDENCES; ?>"));

	var reqUrl = SERVICE_ROOT + "&method=getnodesby" + context + "&" + Object.toQueryString(args);

	new Ajax.Request(reqUrl, { method:'get',
  			onSuccess: function(transport){

  				try {
  					var json = transport.responseText.evalJSON();
  				} catch(err) {
  					console.log(err);
  				}

      			if(json.error){
      				alert(json.error[0].message);
      				return;
      			}

      			//set the count in tab header
      			//$('evidence-list-count').innerHTML = "";
      			//$('evidence-list-count').insert("("+json.nodeset[0].totalno+")");

      			//$('evidencebuttons').innerHTML = "";

				//display nav
				var total = json.nodeset[0].totalno;
				if (CURRENT_TAB == 'data') {
					var currentPage = (json.nodeset[0].start/args["max"]) + 1;
					window.location.hash = CURRENT_TAB+"-"+CURRENT_VIZ+"-"+currentPage;
				}
				$("tab-content-data-evidence").update(createNav(total,json.nodeset[0].start,json.nodeset[0].count,args,context,"evidence"));

				if(json.nodeset[0].nodes.length > 0){
					//preprosses nodes to add searchid if it is there
					if (args['searchid'] && args['searchid'] != "") {
						var nodes = json.nodeset[0].nodes;
						var count = nodes.length;
						for (var i=0; i < count; i++) {
							var node = nodes[i];
							node.cnode.searchid = args['searchid'];
						}
					}

					var tb3 = new Element("div", {'class':'toolbarrow'});

					var sortOpts = {date: '<?php echo $LNG->SORT_CREATIONDATE; ?>', name: '<?php echo $LNG->SORT_TITLE; ?>', moddate: '<?php echo $LNG->SORT_MODDATE; ?>',connectedness:'<?php echo $LNG->SORT_CONNECTIONS; ?>', vote:'<?php echo $LNG->SORT_VOTES; ?>'};
					tb3.insert(displaySortForm(sortOpts,args,'evidence',reorderEvidence));
					tb3.insert(createThemeFilter(context, args, 'evidence'));
					tb3.insert(createEvidenceFilter(context, args));
					tb3.insert(createConnectedFilter(context, args, 'evidence'));

					$("tab-content-data-evidence").insert(tb3);
					displayNodes($("tab-content-data-evidence"),json.nodeset[0].nodes,parseInt(args['start'])+1, true);
				} else {
					// in case caused by filter.
					var tb3 = new Element("div", {'class':'toolbarrow'});
					tb3.insert(createThemeFilter(context, args, 'evidence'));
					tb3.insert(createEvidenceFilter(context, args));
					tb3.insert(createConnectedFilter(context, args, 'evidence'));
					$("tab-content-data-evidence").insert(tb3);
				}

				//display nav
				if (total > parseInt( args["max"] )) {
					$("tab-content-data-evidence").insert(createNav(total,json.nodeset[0].start,json.nodeset[0].count,args,context,"evidence"));
				}
    		}
  		});
  	DATA_LOADED.evidence = true;
}

/**
 *	load next/previous set of urls
 */
function loadresources(context,args){
	var types = RESOURCE_TYPES_STR;

	if (args['filternodetypes'] == "" || types.indexOf(args['filternodetypes']) == -1) {
		args['filternodetypes'] = types;
	}
	updateAddressParameters(args);

	$("tab-content-data-resource").update(getLoading("<?php echo $LNG->LOADING_RESOURCES; ?>"));

	var reqUrl = SERVICE_ROOT + "&method=getnodesby" + context + "&" + Object.toQueryString(args);
	new Ajax.Request(reqUrl, { method:'get',
  			onSuccess: function(transport){
  				var json = transport.responseText.evalJSON();
      			if(json.error){
      				alert(json.error[0].message);
      				return;
      			}

      			//set the count in tab header
      			//$('resource-list-count').innerHTML = "";
      			//$('resource-list-count').insert("("+json.nodeset[0].totalno+")");

      			//$('webbuttons').innerHTML = "";

				//display nav
				var total = json.nodeset[0].totalno;
				if (CURRENT_TAB == 'data') {
					var currentPage = (json.nodeset[0].start/args["max"]) + 1;
					window.location.hash = CURRENT_TAB+"-"+CURRENT_VIZ+"-"+currentPage;
				}
				$("tab-content-data-resource").update(createNav(total,json.nodeset[0].start,json.nodeset[0].count,args,context,"urls"));
				$("tab-content-data-resource").insert('<div style="clear: both; margin:0px; padding: 0px;"></div>');

				if(total > 0){
					//preprosses nodes to add searchid if it is there
					if (args['searchid'] && args['searchid'] != "") {
						var nodes = json.nodeset[0].nodes;
						var count = nodes.length;
						for (var i=0; i < count; i++) {
							var node = nodes[i];
							node.cnode.searchid = args['searchid'];
						}
					}

					var tb2 = new Element("div", {'class':'toolbarrow'});

					var sortOpts = {date: '<?php echo $LNG->SORT_CREATIONDATE; ?>', name: '<?php echo $LNG->SORT_TITLE; ?>', moddate: '<?php echo $LNG->SORT_MODDATE; ?>',connectedness:'<?php echo $LNG->SORT_CONNECTIONS; ?>'};
					tb2.insert(displaySortForm(sortOpts,args,'urls',reorderURLs));
					tb2.insert(createThemeFilter(context, args, 'web'));
					tb2.insert(createResourceFilter(context, args));
					tb2.insert(createConnectedFilter(context, args, 'web'));

					$("tab-content-data-resource").insert(tb2);
					displayNodes($("tab-content-data-resource"),json.nodeset[0].nodes,parseInt(args['start'])+1, true);
				} else {
					// in case caused by filter.
					var tb2 = new Element("div", {'class':'toolbarrow'});

					tb2.insert(createThemeFilter(context, args, 'web'));
					tb2.insert(createResourceFilter(context, args));
					tb2.insert(createConnectedFilter(context, args, 'web'));

					$("tab-content-data-resource").insert(tb2);
				}

				//display nav
				if (total > parseInt( args["max"] )) {
					$("tab-content-data-resource").insert(createNav(total,json.nodeset[0].start,json.nodeset[0].count,args,context,"urls"));
				}

    		}
  		});
	DATA_LOADED.resource = true;
}

/**
 *	load next/previous set of chat comment nodes
 */
function loadchats(context,args) {

	args['filternodetypes'] = 'Comment';
	args['filterlist'] = '<?php echo $CFG->LINK_COMMENT_NODE; ?>';
	updateAddressParameters(args);

	$("tab-content-data-chat").update(getLoading("<?php echo $LNG->LOADING_CHATS; ?>"));

	var reqUrl = SERVICE_ROOT + "&method=getconnectednodesby" + context + "&filtergroup=selected&filterlist=<?php echo $CFG->LINK_COMMENT_NODE; ?>&" + Object.toQueryString(args);
	$('chat-list-count').innerHTML = "";

	//alert(reqUrl);
	new Ajax.Request(reqUrl, { method:'post',
  		onSuccess: function(transport){

			try {
				var json = transport.responseText.evalJSON();
			} catch(err) {
				console.log(err);
			}

			if(json.error){
				alert(json.error[0].message);
				return;
			}

			var count = 0;
			if (json.nodeset[0].totalno) {
				count = json.nodeset[0].totalno;
			}

			//set the count in tab header
			//if ($('chat-list-count')) {
			//	$('chat-list-count').innerHTML = "";
			//	$('chat-list-count').insert("("+count+")");
			//}

			var nodes = json.nodeset[0].nodes;

			//display nav
			var total = json.nodeset[0].totalno;
			if (CURRENT_TAB == 'data') {
				var currentPage = (json.nodeset[0].start/args["max"]) + 1;
				window.location.hash = CURRENT_TAB+"-"+CURRENT_VIZ+"-"+currentPage;
			}
			$("tab-content-data-chat").update(createNav(total,json.nodeset[0].start,json.nodeset[0].count,args,context,"chats"));

			if(nodes.length > 0){
				//preprosses nodes to add searchid if it is there
				if (args['searchid'] && args['searchid'] != "") {
					var count = nodes.length;
					for (var i=0; i < count; i++) {
						var node = nodes[i];
						node.cnode.searchid = args['searchid'];
					}
				}

				var tb3 = new Element("div", {'class':'toolbarrow'});

				var sortOpts = {date: '<?php echo $LNG->SORT_CREATIONDATE; ?>', name: '<?php echo $LNG->SORT_TITLE; ?>'};
				tb3.insert(displaySortForm(sortOpts,args,'chat',reorderChats));

				$("tab-content-data-chat").insert(tb3);

				displayNodes($("tab-content-data-chat"),nodes,parseInt(args['start'])+1, true);
			}

			//display nav
			if (total > parseInt( args["max"] )) {
				$("tab-content-data-chat").insert(createNav(total,json.nodeset[0].start,json.nodeset[0].count,args,context,"chats"));
			}
		}
	});

  	DATA_LOADED.chat = true;
}

/**
 *	load next/previous set of comment nodes
 */
function loadcomments(context,args) {
	args['filternodetypes'] = 'Idea';
	updateAddressParameters(args);

	$("tab-content-data-comment").update(getLoading("<?php echo $LNG->LOADING_COMMENTS; ?>"));

	var reqUrl = SERVICE_ROOT + "&method=getconnectednodesby" + context + "&" + Object.toQueryString(args);

	//alert(reqUrl);
	new Ajax.Request(reqUrl, { method:'post',
		onSuccess: function(transport){
			try {
				var json = transport.responseText.evalJSON();
			} catch(err) {
				console.log(err);
			}

			if(json.error){
				alert(json.error[0].message);
				return;
			}

			var count = 0;
			if (json.nodeset[0].totalno) {
				count = json.nodeset[0].totalno;
			}

			//set the count in tab header
			//if ($('comment-list-count')) {
			//	$('comment-list-count').innerHTML = "";
			//	$('comment-list-count').insert("("+count+")");
			//}

			var nodes = json.nodeset[0].nodes;

			//display nav
			var total = json.nodeset[0].totalno;
			if (CURRENT_TAB == 'data') {
				var currentPage = (json.nodeset[0].start/args["max"]) + 1;
				window.location.hash = CURRENT_TAB+"-"+CURRENT_VIZ+"-"+currentPage;
			}
			$("tab-content-data-comment").update(createNav(total,json.nodeset[0].start,json.nodeset[0].count,args,context,"comments"));

			if(nodes.length > 0){
				//preprosses nodes to add searchid if it is there
				if (args['searchid'] && args['searchid'] != "") {
					var count = nodes.length;
					for (var i=0; i < count; i++) {
						var node = nodes[i];
						node.cnode.searchid = args['searchid'];
					}
				}

				var tb3 = new Element("div", {'class':'toolbarrow'});

				var sortOpts = {date: '<?php echo $LNG->SORT_CREATIONDATE; ?>', name: '<?php echo $LNG->SORT_TITLE; ?>'};
				tb3.insert(displaySortForm(sortOpts,args,'comment',reorderComments));

				var filter = createCommentFilter(context, args);
				tb3.insert(filter);

				$("tab-content-data-comment").insert(tb3);

				displayNodes($("tab-content-data-comment"),nodes,parseInt(args['start'])+1, true);
			} else {
				var tb3 = new Element("div", {'class':'toolbarrow'});
				var filter = createCommentFilter(context, args);
				tb3.insert(filter);
				$("tab-content-data-comment").insert(tb3);
			}

			//display nav
			if (total > parseInt( args["max"] )) {
				$("tab-content-data-comment").insert(createNav(total,json.nodeset[0].start,json.nodeset[0].count,args,context,"comments"));
			}
		}
	});

  	DATA_LOADED.comment = true;
}

/**
 *	Reorder the challenge tab
 */
function reorderChallenges(){
 	// change the sort and orderby ARG values
 	CHALLENGE_ARGS['start'] = 0;
 	CHALLENGE_ARGS['sort'] = $('select-sort-challenge').options[$('select-sort-challenge').selectedIndex].value;
 	CHALLENGE_ARGS['orderby'] = $('select-orderby-challenge').options[$('select-orderby-challenge').selectedIndex].value;

 	loadchallenges(CONTEXT,CHALLENGE_ARGS);
}

/**
 *	Reorder the org tab
 */
function reorderOrgs(){
	// change the sort and orderby ARG values
	ORG_ARGS['start'] = 0;
	ORG_ARGS['sort'] = $('select-sort-org').options[$('select-sort-org').selectedIndex].value;
	ORG_ARGS['orderby'] = $('select-orderby-org').options[$('select-orderby-org').selectedIndex].value;

	loadorgs(CONTEXT,ORG_ARGS);
}

/**
 *	Reorder the project tab
 */
function reorderProjects(){
	// change the sort and orderby ARG values
	PROJECT_ARGS['start'] = 0;
	PROJECT_ARGS['sort'] = $('select-sort-project').options[$('select-sort-project').selectedIndex].value;
	PROJECT_ARGS['orderby'] = $('select-orderby-project').options[$('select-orderby-project').selectedIndex].value;

	loadprojects(CONTEXT,PROJECT_ARGS);
}

/**
*	Reorder the issue tab
*/
function reorderIssues(){
 	// change the sort and orderby ARG values
 	ISSUE_ARGS['start'] = 0;
 	ISSUE_ARGS['sort'] = $('select-sort-issue').options[$('select-sort-issue').selectedIndex].value;
 	ISSUE_ARGS['orderby'] = $('select-orderby-issue').options[$('select-orderby-issue').selectedIndex].value;

 	loadissues(CONTEXT,ISSUE_ARGS);
}


/**
 *	Reorder the solutions tab
 */
function reorderSolutions(){
	// change the sort and orderby ARG values
	SOLUTION_ARGS['start'] = 0;
	SOLUTION_ARGS['sort'] = $('select-sort-solution').options[$('select-sort-solution').selectedIndex].value;
	SOLUTION_ARGS['orderby'] = $('select-orderby-solution').options[$('select-orderby-solution').selectedIndex].value;

	loadsolutions(CONTEXT,SOLUTION_ARGS);
}

/**
 *	Reorder the claims tab
 */
function reorderClaims(){
	// change the sort and orderby ARG values
	CLAIM_ARGS['start'] = 0;
	CLAIM_ARGS['sort'] = $('select-sort-claim').options[$('select-sort-claim').selectedIndex].value;
	CLAIM_ARGS['orderby'] = $('select-orderby-claim').options[$('select-orderby-claim').selectedIndex].value;

	loadclaims(CONTEXT,CLAIM_ARGS);
}

/**
 *	Reorder the evidence tab
 */
function reorderEvidence(){
	// change the sort and orderby ARG values
	EVIDENCE_ARGS['start'] = 0;
	EVIDENCE_ARGS['sort'] = $('select-sort-evidence').options[$('select-sort-evidence').selectedIndex].value;
	EVIDENCE_ARGS['orderby'] = $('select-orderby-evidence').options[$('select-orderby-evidence').selectedIndex].value;

	loadevidence(CONTEXT,EVIDENCE_ARGS);
}

/**
 *	Reorder the urls tab
 */
function reorderURLs(){
	// change the sort and orderby ARG values
	RESOURCE_ARGS['start'] = 0;
	RESOURCE_ARGS['sort'] = $('select-sort-urls').options[$('select-sort-urls').selectedIndex].value;
	RESOURCE_ARGS['orderby'] = $('select-orderby-urls').options[$('select-orderby-urls').selectedIndex].value;

	loadresources(CONTEXT,RESOURCE_ARGS);
}

/**
 *	Reorder the users tab
 */
function reorderUsers(){
	// change the sort and orderby ARG values
	USER_ARGS['start'] = 0;
	USER_ARGS['sort'] = $('select-sort-user').options[$('select-sort-user').selectedIndex].value;
	USER_ARGS['orderby'] = $('select-orderby-user').options[$('select-orderby-user').selectedIndex].value;

	loadusers(CONTEXT,USER_ARGS);
}

/**
 *	Reorder the chats tab
 */
function reorderChats(){
	// change the sort and orderby ARG values
	CHAT_ARGS['start'] = 0;
	CHAT_ARGS['sort'] = $('select-sort-chat').options[$('select-sort-chat').selectedIndex].value;
	CHAT_ARGS['orderby'] = $('select-orderby-chat').options[$('select-orderby-chat').selectedIndex].value;

	loadchats(CONTEXT,CHAT_ARGS);
}

/**
 *	Reorder the comments tab
 */
function reorderComments(){
	// change the sort and orderby ARG values
	COMMENT_ARGS['start'] = 0;
	COMMENT_ARGS['sort'] = $('select-sort-comment').options[$('select-sort-comment').selectedIndex].value;
	COMMENT_ARGS['orderby'] = $('select-orderby-comment').options[$('select-orderby-comment').selectedIndex].value;

	loadcomments(CONTEXT,COMMENT_ARGS);
}

/**
 *	Filter the websites tab
 */
function filterWebsites() {

	if (SELECTED_USERS != "") {
		RESOURCE_ARGS['filterusers'] = SELECTED_USERS;
	}

	DATA_LOADED.url = false;
	loadresources(CONTEXT,RESOURCE_ARGS);
}

/**
 *	Filter the challenges by search criteria
 */
 function filterSearchChallenges() {
 	CHALLENGE_ARGS['q'] = $('qchallenge').value;
 	var scope = 'all';
 	CHALLENGE_ARGS['scope'] = scope;

	if (USER != "") {
		var reqUrl = SERVICE_ROOT + "&method=auditsearch&typeitemid="+CHALLENGE_ARGS['userid']+"&type=userchallenge&format=text&q="+CHALLENGE_ARGS['q'];
		new Ajax.Request(reqUrl, { method:'get',
			onError: function(error) {
				alert(error);
			},
	  		onSuccess: function(transport){
				var searchid = transport.responseText;
				if (searchid != "") {
					CHALLENGE_ARGS['searchid'] = searchid;
				}
				DATA_LOADED.challenge = false;
				setTabPushed($('tab-challenge-list-obj'),'data-challenge');
			}
		});
	} else {
		DATA_LOADED.challenge = false;
		setTabPushed($('tab-challenge-list-obj'),'data-challenge');
	}
 }

/**
 *	Filter the orgs by search criteria
 */
function filterSearchOrgs() {
	ORG_ARGS['q'] = $('qorg').value;
	var scope = 'all';
	ORG_ARGS['scope'] = scope;

	if (USER != "") {
		var reqUrl = SERVICE_ROOT + "&method=auditsearch&typeitemid="+ORG_ARGS['userid']+"&type=userorg&format=text&q="+ORG_ARGS['q'];
		new Ajax.Request(reqUrl, { method:'get',
			onError: function(error) {
				alert(error);
			},
	  		onSuccess: function(transport){
				var searchid = transport.responseText;
				if (searchid != "") {
					ORG_ARGS['searchid'] = searchid;
				}
				DATA_LOADED.org = false;
				setTabPushed($('tab-org-list-obj'),'data-org');
			}
		});
	} else {
		DATA_LOADED.org = false;
		setTabPushed($('tab-org-list-obj'),'data-org');
	}
}

/**
 *	Filter the projects by search criteria
 */
function filterSearchProjects() {
	PROJECT_ARGS['q'] = $('qorg').value;
	var scope = 'all';
	PROJECT_ARGS['scope'] = scope;

	if (USER != "") {
		var reqUrl = SERVICE_ROOT + "&method=auditsearch&typeitemid="+PROJECT_ARGS['userid']+"&type=userorg&format=text&q="+PROJECT_ARGS['q'];
		new Ajax.Request(reqUrl, { method:'get',
			onError: function(error) {
				alert(error);
			},
	  		onSuccess: function(transport){
				var searchid = transport.responseText;
				if (searchid != "") {
					PROJECT_ARGS['searchid'] = searchid;
				}
				DATA_LOADED.project = false;
				setTabPushed($('tab-project-list-obj'),'data-project');
			}
		});
	} else {
		DATA_LOADED.project = false;
		setTabPushed($('tab-project-list-obj'),'data-org');
	}
}


/**
 *	Filter the issues by search criteria
 */
function filterSearchIssues() {
	ISSUE_ARGS['q'] = $('qissue').value;
	var scope = 'all';
	ISSUE_ARGS['scope'] = scope;

	if (USER != "") {
		var reqUrl = SERVICE_ROOT + "&method=auditsearch&typeitemid="+ISSUE_ARGS['userid']+"&type=userissue&format=text&q="+ISSUE_ARGS['q'];
		new Ajax.Request(reqUrl, { method:'get',
			onError: function(error) {
				alert(error);
			},
	  		onSuccess: function(transport){
				var searchid = transport.responseText;
				if (searchid != "") {
					ISSUE_ARGS['searchid'] = searchid;
				}
				DATA_LOADED.issue = false;
				setTabPushed($('tab-issue-list-obj'),'data-issue');
			}
		});
	} else {
		DATA_LOADED.issue = false;
		setTabPushed($('tab-issue-list-obj'),'data-issue');
	}
}

/**
 *	Filter the solutions by search criteria
 */
function filterSearchSolutions() {
	SOLUTION_ARGS['q'] = $('qsolution').value;
	var scope = 'all';
	SOLUTION_ARGS['scope'] = scope;

	if (USER != "") {
		var reqUrl = SERVICE_ROOT + "&method=auditsearch&typeitemid="+SOLUTION_ARGS['userid']+"&type=usersolution&format=text&q="+SOLUTION_ARGS['q'];
		new Ajax.Request(reqUrl, { method:'get',
			onError: function(error) {
				alert(error);
			},
	  		onSuccess: function(transport){
				var searchid = transport.responseText;
				if (searchid != "") {
					SOLUTION_ARGS['searchid'] = searchid;
				}
				DATA_LOADED.solution = false;
				setTabPushed($('tab-solution-list-obj'),'data-solution');
			}
		});
	} else {
		DATA_LOADED.solution = false;
		setTabPushed($('tab-solution-list-obj'),'data-solution');
	}
}

/**
 *	Filter the claims by search criteria
 */
function filterSearchClaims() {
	CLAIM_ARGS['q'] = $('qclaim').value;
	var scope = 'all';
	CLAIM_ARGS['scope'] = scope;

	if (USER != "") {
		var reqUrl = SERVICE_ROOT + "&method=auditsearch&typeitemid="+CLAIM_ARGS['userid']+"&type=userclaim&format=text&q="+CLAIM_ARGS['q'];
		new Ajax.Request(reqUrl, { method:'get',
			onError: function(error) {
				alert(error);
			},
	  		onSuccess: function(transport){
				var searchid = transport.responseText;
				if (searchid != "") {
					CLAIM_ARGS['searchid'] = searchid;
				}
				DATA_LOADED.claim = false;
				setTabPushed($('tab-claim-list-obj'),'data-claim');
			}
		});
	} else {
		DATA_LOADED.claim = false;
		setTabPushed($('tab-claim-list-obj'),'data-claim');
	}
}

/**
 *	Filter the evidence by search criteria
 */
function filterSearchEvidence() {
	EVIDENCE_ARGS['q'] = $('qevidence').value;
	var scope = 'all';
	EVIDENCE_ARGS['scope'] = scope;
	if (SELECTED_NODETYPES != "") {
		NODE_ARGS['filternodetypes'] = SELECTED_NODETYPES;
	}

	if (USER != "") {
		var reqUrl = SERVICE_ROOT + "&method=auditsearch&typeitemid="+EVIDENCE_ARGS['userid']+"&type=userevidence&format=text&q="+EVIDENCE_ARGS['q'];
		new Ajax.Request(reqUrl, { method:'get',
			onError: function(error) {
				alert(error);
			},
	  		onSuccess: function(transport){
				var searchid = transport.responseText;
				if (searchid != "") {
					EVIDENCE_ARGS['searchid'] = searchid;
				}
				DATA_LOADED.evidence = false;
				setTabPushed($('tab-evidence-list-obj'),'data-evidence');
			}
		});
	} else {
		DATA_LOADED.evidence = false;
		setTabPushed($('tab-evidence-list-obj'),'data-evidence');
	}
}

/**
 *	Filter the websites by search criteria
 */
function filterSearchResources() {
	RESOURCE_ARGS['q'] = $('qweb').value;
	var scope = 'all';
	RESOURCE_ARGS['scope'] = scope;

	if (USER != "") {
		var reqUrl = SERVICE_ROOT + "&method=auditsearch&typeitemid="+RESOURCE_ARGS['userid']+"&type=userresource&format=text&q="+CLAIM_ARGS['q'];
		new Ajax.Request(reqUrl, { method:'get',
			onError: function(error) {
				alert(error);
			},
	  		onSuccess: function(transport){
				var searchid = transport.responseText;
				if (searchid != "") {
					RESOURCE_ARGS['searchid'] = searchid;
				}
				DATA_LOADED.resource = false;
				setTabPushed($('tab-resource-list-obj'),'data-resource');
			}
		});
	} else {
		DATA_LOADED.resource = false;
		setTabPushed($('tab-resource-list-obj'),'data-resource');
	}
}

/**
 *	Filter the users by search criteria
 */
function filterSearchComments() {
	COMMENT_ARGS['q'] = $('qcomment').value;
	var scope = 'all';
	COMMENT_ARGS['scope'] = scope;

	if (USER != "") {
		var reqUrl = SERVICE_ROOT + "&method=auditsearch&typeitemid="+NODE_ARGS['userid']+"&type=usercomment&format=text&q="+NODE_ARGS['q'];
		new Ajax.Request(reqUrl, { method:'get',
			onError: function(error) {
				alert(error);
			},
	  		onSuccess: function(transport){
				var searchid = transport.responseText;
				if (searchid != "") {
					COMMENT_ARGS['searchid'] = searchid;
				}
				DATA_LOADED.comment = false;
				setTabPushed($('tab-comment-list-obj'),'data-comment');
			}
		});
	} else {
		DATA_LOADED.comment = false;
		setTabPushed($('tab-comment-list-obj'),'data-comment');
	}
}

/**
 *	Filter the users by search criteria
 */
function filterSearchChats() {
	CHAT_ARGS['q'] = $('qchat').value;
	var scope = 'all';
	CHAT_ARGS['scope'] = scope;

	if (USER != "") {
		var reqUrl = SERVICE_ROOT + "&method=auditsearch&typeitemid="+NODE_ARGS['userid']+"&type=userchat&format=text&q="+NODE_ARGS['q'];
		new Ajax.Request(reqUrl, { method:'get',
			onError: function(error) {
				alert(error);
			},
	  		onSuccess: function(transport){
				var searchid = transport.responseText;
				if (searchid != "") {
					CHAT_ARGS['searchid'] = searchid;
				}
				DATA_LOADED.chat = false;
				setTabPushed($('tab-chat-list-obj'),'data-chat');
			}
		});
	} else {
		DATA_LOADED.chat = false;
		setTabPushed($('tab-chat-list-obj'),'data-chat');
	}
}

/**
 * show the sort form
 */
function displaySortForm(sortOpts,args,tab,handler){

	var sbTool = new Element("span", {'class':'sortback toolbar2  col-auto'});
    sbTool.insert("<?php echo $LNG->SORT_BY; ?> ");

    var selOrd = new Element("select");
 	Event.observe(selOrd,'change',handler);
    selOrd.id = "select-orderby-"+tab;
    selOrd.className = "toolbar form-select";
    selOrd.name = "orderby";
    selOrd.setAttribute("aria-label","Sort by");
    sbTool.insert(selOrd);
    for(var key in sortOpts){
        var opt = new Element("option");
        opt.value=key;
        opt.insert(sortOpts[key].valueOf());
        selOrd.insert(opt);
        if(args.orderby == key){
        	opt.selected = true;
        }
    }
    var sortBys = {ASC: '<?php echo $LNG->SORT_ASC; ?>', DESC: '<?php echo $LNG->SORT_DESC; ?>'};
    var sortBy = new Element("select");
 	Event.observe(sortBy,'change',handler);
    sortBy.id = "select-sort-"+tab;
    sortBy.className = "toolbar form-select";
    sortBy.name = "sort";
    sortBy.setAttribute("aria-label","Order by");
    sbTool.insert(sortBy);
    for(var key in sortBys){
        var opt = new Element("option");
        opt.value=key;
        opt.insert(sortBys[key]);
        sortBy.insert(opt);
        if(args.sort == key){
        	opt.selected = true;
        }
    }

    return sbTool;
}

/**
 * Called by the node type popup after node types have been selected.
 */
function setSelectedNodeTypes(types) {
	SELECTED_NODETYPES = types;

	if ($('select-filter-conn')) {
		$('select-filter-conn').options[0].selected = true;
	} else if ($('select-filter-neighbourhood')) {
		$('select-filter-neighbourhood').options[0].selected = true;
	} else if ($('nodetypegroups')) {
		($('nodetypegroups')).options[0].selected = true;
	}
}

/**
 * Called by the link type popup after link types have been selected.
 */
function setSelectedLinkTypes(types) {
	SELECTED_LINKTYES = types;

	if ($('select-filter-conn')) {
		$('select-filter-conn').options[0].selected = true;
	} else if ($('select-filter-neighbourhood')) {
		$('select-filter-neighbourhood').options[0].selected = true;
	} else if ($('linktypegroups')) {
		($('linktypegroups')).options[0].selected = true;
	}
}

/**
 * Called by the users popup after users have been selected.
 */
function setSelectedUsers(types) {
	SELECTED_USERS = types;
}

function createThemeFilter(context, args, type) {

	var sbTool = new Element("span", {'class':'toolbar2 col-auto'});
    sbTool.insert("<?php echo $LNG->FILTER_BY; ?> ");

	var filterMenu= new Element("select", {'class':'subforminput hgrselecthgrselect toolbar form-select'});	
    filterMenu.setAttribute("aria-label","Filter by");

	var option = new Element("option", {'value':''});
	option.insert('<?php echo $LNG->FILTER_THEMES_ALL; ?>');
	filterMenu.insert(option);

	for(var i=0; i < THEMES.length; i++){
		var option = new Element("option", {'value':THEMES[i]});
		if (args['filterthemes'] && args['filterthemes'] == THEMES[i]) {
			option.selected = true;
		}
		option.insert(THEMES[i]);
		filterMenu.insert(option);
	}

	Event.observe(filterMenu,"change", function(){
		var theme = this.value;
		args['filterthemes'] = theme;
		if( type == 'orgs') {
			refreshOrganizations();
		} else if (type == 'projects') {
			refreshProjects();
		} else if (type == 'claims') {
			refreshClaims();
		} else if (type == 'evidence') {
			refreshEvidence();
		} else if (type == 'issues') {
			refreshIssues();
		} else if (type == 'solutions') {
			refreshSolutions();
		} else if (type == 'web') {
			refreshWebsites();
		} else if (type == 'challenges') {
			refreshChallenges();
		} else if (type == 'user') {
			refreshUsers();
		}
	});

	sbTool.insert(filterMenu);

	return sbTool;
}

function createThemeFilterNet(context, args, type) {

	var sbTool = new Element("span", {'class':'toolbar2 col-auto'});
    sbTool.insert("<?php echo $LNG->FILTER_THEME_LABEL; ?> ");

	var filterMenu= new Element("select", {'class':'subforminput hgrselecthgrselect toolbar form-select'});
	filterMenu.setAttribute("aria-label","Filter by");

	var option = new Element("option", {'value':''});
	option.insert('<?php echo $LNG->FILTER_ALSO_SELECT_THEME; ?>');
	filterMenu.insert(option);

	for(var i=0; i < THEMES.length; i++){
		var option = new Element("option", {'value':THEMES[i]});
		if (args['filterthemes'] && args['filterthemes'] == THEMES[i]) {
			option.selected = true;
		}
		option.insert(THEMES[i]);
		filterMenu.insert(option);
	}

	Event.observe(filterMenu,"change", function(){
		var theme = this.value;
		if (theme == "") {
			args['filterthemes'] = "";
			if( type == 'orgs') {
				checkIsActiveOrgMessage();
			} else if (type == 'projects') {
				checkIsActiveProjectMessage();
			} else if (type == 'claims') {
				checkIsActiveClaimMessage();
			} else if (type == 'evidence') {
				checkIsActiveEvidenceMessage();
			} else if (type == 'issues') {
				checkIsActiveIssueMessage();
			} else if (type == 'solutions') {
				checkIsActiveSolutionMessage();
			} else if (type == 'web') {
				checkIsActiveWebMessage();
			} else if (type == 'challenges') {
				checkIsActiveChallengeMessage();
			}
		} else {
			args['filterthemes'] = theme;
			if( type == 'orgs') {
				refreshOrganizations();
			} else if (type == 'projects') {
				refreshProjects();
			} else if (type == 'claims') {
				refreshClaims();
			} else if (type == 'evidence') {
				refreshEvidence();
			} else if (type == 'issues') {
				refreshIssues();
			} else if (type == 'solutions') {
				refreshSolutions();
			} else if (type == 'web') {
				refreshWebsites();
			} else if (type == 'challenges') {
				refreshChallenges();
			}
		}
	});

	sbTool.insert(filterMenu);

	return sbTool;
}

function createEvidenceFilter(context, args) {
	var sbTool = new Element("span", {'class':'toolbar2 col-auto'});
    sbTool.insert("<?php echo $LNG->FILTER_BY; ?> ");

	var resourceFilterMenu= new Element("select", {'class':'subforminput hgrselecthgrselect toolbar form-select'});
	resourceFilterMenu.setAttribute("aria-label","Filter by");

	var option = new Element("option", {'value':''});
	option.insert('<?php echo $LNG->FILTER_TYPES_ALL; ?>');
	resourceFilterMenu.insert(option);

	for(var i=0; i < EVIDENCE_TYPES.length; i++){
		var option = new Element("option", {'value':EVIDENCE_TYPES[i]});
		if (args['filternodetypes'] == EVIDENCE_TYPES[i]) {
			option.selected = true;
		}
		option.insert(EVIDENCE_TYPES[i]);
		resourceFilterMenu.insert(option);
	}

	Event.observe(resourceFilterMenu,"change", function(){

		switch(CURRENT_VIZ){
			case 'net':
				if (args['filterthemes'] && args['filterthemes'] != "") {
					var type = this.value;
					args['filternodetypes'] = type;
					refreshEvidence();
				} else {
					alert('<?php echo $LNG->FILTER_ALSO_SELECT_THEME; ?>');
					break;
				}
			default :
				var type = this.value;
				args['filternodetypes'] = type;
				refreshEvidence();
			break;
		}
	});

	sbTool.insert(resourceFilterMenu);

	return sbTool;
}


function createResourceFilter(context, args) {
	var sbTool = new Element("span", {'class':'toolbar2 col-auto'});
    sbTool.insert("<?php echo $LNG->FILTER_BY; ?> ");

	var resourceFilterMenu= new Element("select", {'class':'subforminput hgrselecthgrselect toolbar form-select'});
	resourceFilterMenu.setAttribute("aria-label","Filter by");

	var option = new Element("option", {'value':''});
	option.insert('<?php echo $LNG->FILTER_TYPES_ALL; ?>');
	resourceFilterMenu.insert(option);

	for(var i=0; i < RESOURCE_TYPES.length; i++){
		var option = new Element("option", {'value':RESOURCE_TYPES[i]});
		if (args['filternodetypes'] == RESOURCE_TYPES[i]) {
			option.selected = true;
		}
		option.insert(RESOURCE_TYPES[i]);
		resourceFilterMenu.insert(option);
	}

	Event.observe(resourceFilterMenu,"change", function(){
		switch(CURRENT_VIZ){
			case 'net':
				if (args['filterthemes'] && args['filterthemes'] != "") {
					var type = this.value;
					args['filternodetypes'] = type;
					refreshWebsites();
				} else {
					alert('<?php echo $LNG->FILTER_ALSO_SELECT_THEME; ?>');
					break;
				}
			default :
				var type = this.value;
				args['filternodetypes'] = type;
				refreshWebsites();
			break;
		}
	});

	sbTool.insert(resourceFilterMenu);

	return sbTool;
}

function createNodeTypeFilter(context, args) {

	var sbTool = new Element("span", {'class':'toolbar2 col-auto'});
    sbTool.insert("<?php echo $LNG->FILTER_BY; ?> ");

	var filterMenu= new Element("select", {'class':'subforminput hgrselecthgrselect toolbar form-select'});
	filterMenu.setAttribute("aria-label","Filter by");

	var option = new Element("option", {'value':''});
	option.insert('<?php echo $LNG->FILTER_TYPES_ALL; ?>');
	filterMenu.insert(option);

	if (hasChallenge) {
		var option2 = new Element("option", {'value':'Challenge'});
		if (args['filternodetypes'] == "Challenge") {
			option2.selected = true;
		}
		option2.insert("<?php echo $LNG->CHALLENGE_NAME; ?>");
		filterMenu.insert(option2);
	}

	var option = new Element("option", {'value':'Issue'});
	if (args['filternodetypes'] == "Issue") {
		option.selected = true;
	}
	option.insert("<?php echo $LNG->ISSUE_NAME; ?>");
	filterMenu.insert(option);

	if (hasClaim) {
		var option2 = new Element("option", {'value':'Claim'});
		if (args['filternodetypes'] == "Claim") {
			option2.selected = true;
		}
		option2.insert("<?php echo $LNG->CLAIM_NAME; ?>");
		filterMenu.insert(option2);
	}
	if (hasSolution) {
		var option2 = new Element("option", {'value':'Solution'});
		if (args['filternodetypes'] == "Solution") {
			option2.selected = true;
		}
		option2.insert("<?php echo $LNG->SOLUTION_NAME; ?>");
		filterMenu.insert(option2);
	}

	var option = new Element("option", {'value':EVIDENCE_TYPES_STR});
	if (args['filternodetypes'] == EVIDENCE_TYPES_STR) {
		option.selected = true;
	}
	option.insert("<?php echo $LNG->EVIDENCE_NAME; ?>");
	filterMenu.insert(option);

	var option = new Element("option", {'value':RESOURCE_TYPES_STR});
	if (args['filternodetypes'] == RESOURCE_TYPES_STR) {
		option.selected = true;
	}
	option.insert("<?php echo $LNG->RESOURCE_NAME; ?>");
	filterMenu.insert(option);

	Event.observe(filterMenu,"change", function(){
		switch(CURRENT_VIZ){
			case 'nodegmap':
				var linktype = this.value;
				args['filternodetypes'] = linktype;
				refreshUsers();
			break;
		}
	});

	sbTool.insert(filterMenu);

	return sbTool;
}

function createConnectedFilter(context, args, type) {

	var sbTool = new Element("span", {'class':'toolbar2 col-auto'});
    sbTool.insert("<?php echo $LNG->FILTER_BY; ?> ");

	var filterMenu= new Element("select", {'class':'subforminput hgrselecthgrselect toolbar form-select'});
	filterMenu.setAttribute("aria-label","Filter by");

	var option = new Element("option", {'value':''});
	option.insert('<?php echo $LNG->ALL_ITEMS_FILTER; ?>');
	filterMenu.insert(option);

	var option = new Element("option", {'value':'connected'});
	if (args['filterbyconnection'] && args['filterbyconnection'] == "connected") {
		option.selected = true;
	}
	option.insert("<?php echo $LNG->CONNECTED_ITEMS_FILTER; ?>");
	filterMenu.insert(option);

	var option2 = new Element("option", {'value':'unconnected'});
	if (args['filterbyconnection'] && args['filterbyconnection'] == "unconnected") {
		option2.selected = true;
	}
	option2.insert("<?php echo $LNG->UNCONNECTED_ITEMS_FILTER; ?>");
	filterMenu.insert(option2);

	Event.observe(filterMenu,"change", function(){
		var selection = this.value;
		args['filterbyconnection'] = selection;

		if( type == 'orgs') {
			refreshOrganizations();
		} else if (type == 'projects') {
			refreshProjects();
		} else if (type == 'claims') {
			refreshClaims();
		} else if (type == 'evidence') {
			refreshEvidence();
		} else if (type == 'issues') {
			refreshIssues();
		} else if (type == 'solutions') {
			refreshSolutions();
		} else if (type == 'web') {
			refreshWebsites();
		} else if (type == 'challenges') {
			refreshChallenges();
		}
	});

	sbTool.insert(filterMenu);
	return sbTool;

}

/**
 * display Nav
 */
function createNav(total, start, count, argArray, context, type){

	var nav = new Element ("div",{'id':'page-nav', 'class':'toolbarrow pb-3' });

	var header = createNavCounter(total, start, count, type);
	nav.insert(header);

	if (total > parseInt( argArray["max"] )) {
		//previous
	    var prevSpan = new Element("span", {'id':"nav-previous", "class": "page-nav page-chevron"});
	    if(start > 0){
			prevSpan.update("<i class=\"fas fa-chevron-left fa-lg\" aria-hidden=\"true\"></i><span class=\"sr-only\"><?php echo $LNG->LIST_NAV_PREVIOUS_HINT; ?></span>");
	        prevSpan.addClassName("active");
	        Event.observe(prevSpan,"click", function(){
	            var newArr = argArray;
	            newArr["start"] = parseInt(start) - newArr["max"];
	            eval("load"+type+"(context,newArr)");
	        });
	    } else {
			prevSpan.update("<i disabled class=\"fas fa-chevron-left fa-lg\" aria-hidden=\"true\"></i><span class=\"sr-only\"><?php echo $LNG->LIST_NAV_NO_PREVIOUS_HINT; ?></span>");
	        prevSpan.addClassName("inactive");
	    }

	    //pages
	    var pageSpan = new Element("span", {'id':"nav-pages", "class": "page-nav"});
	    var totalPages = Math.ceil(total/argArray["max"]);
	    var currentPage = (start/argArray["max"]) + 1;
	    for (var i = 1; i < totalPages+1; i++){
	    	var page = new Element("span", {'class':"nav-page"}).insert(i);
	    	if(i != currentPage){
		    	page.addClassName("active");
		    	var newArr = Object.clone(argArray);
		    	newArr["start"] = newArr["max"] * (i-1) ;
		    	Event.observe(page,"click", Pages.next.bindAsEventListener(Pages,type,context,newArr));
	    	} else {
	    		page.addClassName("currentpage");
	    	}
	    	pageSpan.insert(page);
	    }

	    //next
	    var nextSpan = new Element("span", {'id':"nav-next", "class": "page-nav page-chevron"});
	    if(parseInt(start)+parseInt(count) < parseInt(total)){
			nextSpan.update("<i class=\"fas fa-chevron-right fa-lg\" aria-hidden=\"true\"></i><span class=\"sr-only\"><?php echo $LNG->LIST_NAV_NEXT_HINT; ?></span>");
	        nextSpan.addClassName("active");
	        Event.observe(nextSpan,"click", function(){
	            var newArr = argArray;
	            newArr["start"] = parseInt(start) + parseInt(newArr["max"]);
	            eval("load"+type+"(context, newArr)");
	        });
	    } else {
			nextSpan.update("<i class=\"fas fa-chevron-right fa-lg\" aria-hidden=\"true\" disabled></i><span class=\"sr-only\"><?php echo $LNG->LIST_NAV_NO_NEXT_HINT; ?></span>");
	        nextSpan.addClassName("inactive");
	    }

	    if( start>0 || (parseInt(start)+parseInt(count) < parseInt(total))){
	    	nav.insert(prevSpan).insert(pageSpan).insert(nextSpan);
	    }
	}

	return nav;
}

/**
 * display nav header
 */
function createNavCounter(total, start, count, type){

    if(count != 0){
    	var objH = new Element("span",{'class':'nav'});
    	var s1 = parseInt(start)+1;
    	var s2 = parseInt(start)+parseInt(count);
        objH.insert("<b>" + s1 + " <?php echo $LNG->LIST_NAV_TO; ?> " + s2 + " (" + total + ")</b>");
    } else {
    	var objH = new Element("span");
        if (CONTEXT == 'user' &&  USER_ARGS.userid == USER){
        	switch(type){
         		case 'challenge':
        			objH.insert("<b><?php echo $LNG->LIST_NAV_USER_NO_CHALLENGE; ?></b>");
        			break;
        		case 'orgs':
        			objH.insert("<p><b><?php echo $LNG->LIST_NAV_USER_NO_ORG; ?></b></p>");
        			break;
        		case 'projects':
        			objH.insert("<p><b><?php echo $LNG->LIST_NAV_USER_NO_PROJECT; ?></b></p>");
        			break;
        		case 'issues':
        			objH.insert("<p><b><?php echo $LNG->LIST_NAV_USER_NO_ISSUE; ?></b></p>");
        			break;
        		case 'solutions':
        			objH.insert("<p><b><?php echo $LNG->LIST_NAV_USER_NO_SOLUTION; ?></b></p>");
        			break;
        		case 'claims':
        			objH.insert("<p><b><?php echo $LNG->LIST_NAV_USER_NO_CLAIM; ?></b></p>");
        			break;
        		case 'evidence':
        			objH.insert("<p><b><?php echo $LNG->LIST_NAV_USER_NO_EVIDENCE; ?></b></p>");
        			break;
        		case 'urls':
        			objH.insert("<p><b><?php echo $LNG->LIST_NAV_USER_NO_RESOURCE; ?></b></p>");
        			break;
        		case 'comments':
					objH.insert("<p><b><?php echo $LNG->LIST_NAV_USER_NO_COMMENT; ?></b></p>");
        			break;
        		case 'chats':
					objH.insert("<p><b><?php echo $LNG->LIST_NAV_USER_NO_CHAT; ?></b></p>");
        			break;
        	}
        } else {
        	switch(type){
        		case 'challenge':
        			objH.insert("<b><?php echo $LNG->LIST_NAV_NO_CHALLENGE; ?></b>");
        			break;
        		case 'evidence':
        			objH.insert("<b><?php echo $LNG->LIST_NAV_NO_EVIDENCE; ?></b>");
        			break;
        		case 'orgs':
        			objH.insert("<b><?php echo $LNG->LIST_NAV_NO_ORGS; ?></b>");
        			break;
        		case 'projects':
        			objH.insert("<b><?php echo $LNG->LIST_NAV_NO_PROJECTS; ?></b>");
        			break;
        		case 'urls':
        			objH.insert("<b><?php echo $LNG->LIST_NAV_NO_RESOURCE; ?></b>");
        			break;
        		case 'issues':
        			objH.insert("<p><b><?php echo $LNG->LIST_NAV_NO_ISSUE; ?></b></p>");
        			break;
        		case 'solutions':
        			objH.insert("<p><b><?php echo $LNG->LIST_NAV_NO_SOLUTION; ?></b></p>");
        			break;
        		case 'claims':
        			objH.insert("<p><b><?php echo $LNG->LIST_NAV_NO_CLAIM; ?></b></p>");
        			break;
        		default:
        			objH.insert("<b><?php echo $LNG->LIST_NAV_NO_ITEMS; ?></b>");
        	}
        }
    }
    return objH;
}

var Pages = {
	next: function(e){
		var data = $A(arguments);
		eval("load"+data[1]+"(data[2],data[3])");
	}
};

/**
 * load JS file for creating the connection network (applet) for a users social network
 */
function loadUserHomeNet(){
	addScriptDynamically('<?php echo $HUB_FLM->getCodeWebPath("ui/networkmaps/social-user-net.js.php"); ?>', 'social-user-net-script');
}