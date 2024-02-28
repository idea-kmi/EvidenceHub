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
 * Functions for the search results page 'search.php'.
 */

/**
 *	Add the filter and sort controls for the page.
 */
function addControls(container) {
	var tb3 = new Element("div", {'class':'toolbarrowsearch'});
	var sortOpts = {date: '<?php echo $LNG->SORT_CREATIONDATE; ?>', name: '<?php echo $LNG->SORT_TITLE; ?>', moddate: '<?php echo $LNG->SORT_MODDATE; ?>',connectedness:'<?php echo $LNG->SORT_CONNECTIONS; ?>', vote:'<?php echo $LNG->SORT_VOTES; ?>'};
	tb3.insert(displaySortForm(sortOpts));
	tb3.insert(createThemeFilter());
	container.insert(tb3);
}

function buildSearchToolbar(container, query, tagsonly) {

	addControls(container);

	/*var print = new Element("img",
		{'src': '<?php echo $HUB_FLM->getImagePath("printer.png"); ?>',
		'alt': '<?php echo $LNG->EXPLORE_PRINT_BUTTON_ALT;?>',
		'title': '<?php echo $LNG->EXPLORE_PRINT_BUTTON_HINT;?>',
		'class': 'active',
		'style': 'float:left;padding-top:0px;padding-right:10px;margin-top:10px;'});
	container.insert(print);
	Event.observe(print,'click',function(){
		 printNodeExplore(NODE_ARGS, name, nodeid);
	});
	*/

	var tree = new Element('a',{'style':'float:left;margin-right:15px;margin-bottom:5px;'});
	tree.href="<?php echo $CFG->homeAddress; ?>knowledgetreessearch.php?q="+query+"&tagsonly="+tagsonly;
	var image = new Element('img',{'class':'active','border':'0','src': '<?php echo $HUB_FLM->getImagePath("knowledge-tree.png"); ?>', 'style':'margin-right: 5px;width:26px; height:26px;padding:3px;'});
	tree.insert(image);
	tree.title = '<?php echo $LNG->VIEWS_LINEAR_TITLE;?>';
	container.appendChild(tree);

	var net = new Element('a',{'style':'float:left;margin-right:0px;margin-bottom:5px;'});
	net.href="<?php echo $CFG->homeAddress; ?>networkgraphsearch.php?q="+query+"&tagsonly="+tagsonly;
	var image = new Element('img',{'class':'active','border':'0','src': '<?php echo $HUB_FLM->getImagePath("network-graph.png"); ?>', 'style':'margin-right: 5px;width:26px; height:26px;padding:3px;'});
	net.insert(image);
	net.title = '<?php echo $LNG->VIEWS_EVIDENCE_MAP_TITLE;?>';
	container.appendChild(net);
}

/**
 *	load next/previous set of challenge search result nodes
 */
function loadchallenges(context,args){

	args['filternodetypes'] = "Challenge";

	$("content-challenge-list").update(getLoading("<?php echo $LNG->LOADING_CHALLENGES; ?>"));

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

			//display nav
			var total = json.nodeset[0].totalno;

			if(json.nodeset[0].nodes.length > 0){

				//preprosses nodes to add searchid if it is there
				if (args['searchid'] && args['searchid'] != "") {
					var nodes = json.nodeset[0].nodes;
					var count = nodes.length;
					for (var i=0; i<count; i++) {
						var node = nodes[i];
						node.cnode.searchid = args['searchid'];
					}
				}

				//set the count in tab header
				$('challenge-list-count').innerHTML = "";
				$('challenge-list-count-main').innerHTML = "";
				$('content-challenge-list').innerHTML = "";
				$('challenge-list-title').innerHTML = "";

				$('content-challenge-main').style.display = "block";

				if (total > parseInt( args["max"] )) {
					$("content-challenge-list").update(createNav(total,json.nodeset[0].start,json.nodeset[0].count,args,context,"challenges"));
				}

				$('challenge-list-count').insert(json.nodeset[0].totalno);
				$('challenge-list-count-main').insert(json.nodeset[0].totalno);

				if (json.nodeset[0].nodes.length > 1) {
					$("challenge-list-title").insert("<?php echo $LNG->CHALLENGES_NAME; ?>");
				} else {
					$("challenge-list-title").insert("<?php echo $LNG->CHALLENGE_NAME; ?>");
				}

				displaySearchNodes($("content-challenge-list"),json.nodeset[0].nodes,parseInt(args['start'])+1, true);

				if (total > parseInt( args["max"] )) {
					$("content-challenge-list").insert(createNav(total,json.nodeset[0].start,json.nodeset[0].count,args,context,"challenges"));
				}
			} else {
				$('content-challenge-main').style.display = "none";
				$('challenge-result-menu').href = "javascript:return false";
				$('challenge-result-menu').className = 'inactive';
				$('challenge-list-count-main').innerHTML = "";
				$('challenge-list-count-main').insert('0');
			}
		}
	});
}

/**
 *	load next/previous set of organisation nodes
 */
function loadorgs(context,args){

	var types = "Organization";

	if (args['filternodetypes'] == "" || types.indexOf(args['filternodetypes']) == -1) {
		args['filternodetypes'] = types;
	}

	$('content-org-main').style.display = "block";
	$("content-org-list").update(getLoading("<?php echo $LNG->LOADING_ORGS; ?>"));

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

			var total = json.nodeset[0].totalno;

			//display nodes
			if(json.nodeset[0].nodes.length > 0){

				//preprosses nodes to add searchid if it is there
				if (args['searchid'] && args['searchid'] != "") {
					var nodes = json.nodeset[0].nodes;
					var count = nodes.length;
					for (var i=0; i<count; i++) {
						var node = nodes[i];
						node.cnode.searchid = args['searchid'];
					}
				}

				//set the count in tab header
				$('org-list-count').innerHTML = "";
				$('org-list-count-main').innerHTML = "";
				$('content-org-list').innerHTML = "";
				$('org-list-title').innerHTML = "";

				if (total > parseInt( args["max"] )) {
					$("content-org-list").update(createNav(total,json.nodeset[0].start,json.nodeset[0].count,args,context,"orgs"));
				}

				$('content-org-main').style.display = "block";
				$('org-result-menu').href = "#orgresult";
				$('org-result-menu').className = '';

				$('org-list-count').insert(json.nodeset[0].totalno);
				$('org-list-count-main').insert(json.nodeset[0].totalno);

				if (json.nodeset[0].nodes.length > 1) {
					$("org-list-title").insert("<?php echo $LNG->ORGS_NAME; ?>");
				} else {
					$("org-list-title").insert("<?php echo $LNG->ORG_NAME; ?>");
				}
				displaySearchNodes($("content-org-list"),json.nodeset[0].nodes,parseInt(args['start'])+1, true);

				if (total > parseInt( args["max"] )) {
					$("content-org-list").insert(createNav(total,json.nodeset[0].start,json.nodeset[0].count,args,context,"orgs"));
				}
			} else {
				$('content-org-main').style.display = "none";
				$('org-result-menu').href = "javascript:return false";
				$('org-result-menu').className = 'inactive';
				$('org-list-count-main').innerHTML = "";
				$('org-list-count-main').insert('0');
			}
		}
	});
}

/**
 *	load projects for the given search
 */
function loadprojects(context,args){

	var types = "Project";

	if (args['filternodetypes'] == "" || types.indexOf(args['filternodetypes']) == -1) {
		args['filternodetypes'] = types;
	}

	$('content-project-main').style.display = "block";
	$("content-project-list").update(getLoading("<?php echo $LNG->LOADING_PROJECTS; ?>"));

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

			var total = json.nodeset[0].totalno;

			//display nodes
			if(json.nodeset[0].nodes.length > 0){

				//preprosses nodes to add searchid if it is there
				if (args['searchid'] && args['searchid'] != "") {
					var nodes = json.nodeset[0].nodes;
					var count = nodes.length;
					for (var i=0; i<count; i++) {
						var node = nodes[i];
						node.cnode.searchid = args['searchid'];
					}
				}

				//set the count in tab header
				$('project-list-count').innerHTML = "";
				$('project-list-count-main').innerHTML = "";
				$('content-project-list').innerHTML = "";
				$('project-list-title').innerHTML = "";

				if (total > parseInt( args["max"] )) {
					$("content-project-list").update(createNav(total,json.nodeset[0].start,json.nodeset[0].count,args,context,"orgs"));
				}

				$('content-project-main').style.display = "block";
				$('project-result-menu').href = "#projectresult";
				$('project-result-menu').className = '';

				$('project-list-count').insert(json.nodeset[0].totalno);
				$('project-list-count-main').insert(json.nodeset[0].totalno);

				if (json.nodeset[0].nodes.length > 1) {
					$("project-list-title").insert("<?php echo $LNG->PROJECTS_NAME; ?>");
				} else {
					$("project-list-title").insert("<?php echo $LNG->PROJECT_NAME; ?>");
				}
				displaySearchNodes($("content-project-list"),json.nodeset[0].nodes,parseInt(args['start'])+1, true);

				if (total > parseInt( args["max"] )) {
					$("content-project-list").insert(createNav(total,json.nodeset[0].start,json.nodeset[0].count,args,context,"orgs"));
				}
			} else {
				$('content-project-main').style.display = "none";
				$('project-result-menu').href = "javascript:return false";
				$('project-result-menu').className = 'inactive';
				$('project-list-count-main').innerHTML = "";
				$('project-list-count-main').insert('0');
			}
		}
	});
}

/**
 *	load next/previous set of nodes
 */
function loadissues(context,args){
	args['filternodetypes'] = "Issue";

	$("content-issue-list").update(getLoading("<?php echo $LNG->LOADING_ISSUES; ?>"));

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

			//display nav
			var total = json.nodeset[0].totalno;

			//display nodes
			if(json.nodeset[0].nodes.length > 0){

				//preprosses nodes to add searchid if it is there
				if (args['searchid'] && args['searchid'] != "") {
					var nodes = json.nodeset[0].nodes;
					var count = nodes.length;
					for (var i=0; i<count; i++) {
						var node = nodes[i];
						node.cnode.searchid = args['searchid'];
					}
				}

				//set the count in header
				$('issue-list-count').innerHTML = "";
				$('issue-list-count-main').innerHTML = "";
				$('content-issue-list').innerHTML = "";
				$('issue-list-title').innerHTML = "";

				$('content-issue-main').style.display = "block";
				$('issue-result-menu').href = "#issueresult";
				$('issue-result-menu').className = '';

				if (total > parseInt( args["max"] )) {
					$("content-issue-list").update(createNav(total,json.nodeset[0].start,json.nodeset[0].count,args,context,"issues"));
				}

				$('issue-list-count').insert(json.nodeset[0].totalno);
				$('issue-list-count-main').insert(json.nodeset[0].totalno);

				if (json.nodeset[0].nodes.length > 1) {
					$("issue-list-title").insert("<?php echo $LNG->ISSUES_NAME; ?>");
				} else {
					$("issue-list-title").insert("<?php echo $LNG->ISSUE_NAME; ?>");
				}

				displaySearchNodes($("content-issue-list"),json.nodeset[0].nodes,parseInt(args['start'])+1, true);

				if (total > parseInt( args["max"] )) {
					$("content-issue-list").insert(createNav(total,json.nodeset[0].start,json.nodeset[0].count,args,context,"issues"));
				}
			} else {
				$('content-issue-main').style.display = "none";
				$('issue-result-menu').href = "javascript:return false";
				$('issue-result-menu').className = 'inactive';
				$('issue-list-count-main').innerHTML = "";
				$('issue-list-count-main').insert('0');
			}
		}
	});
}

/**
 *	load next/previous set of nodes
 */
function loadsolutions(context,args){
	args['filternodetypes'] = "Solution";

	$("content-solution-list").update(getLoading("<?php echo $LNG->LOADING_SOLUTIONS; ?>"));

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

			var total = json.nodeset[0].totalno;

			if(json.nodeset[0].nodes.length > 0){

				//preprosses nodes to add searchid if it is there
				if (args['searchid'] && args['searchid'] != "") {
					var nodes = json.nodeset[0].nodes;
					var count = nodes.length;
					for (var i=0; i<count; i++) {
						var node = nodes[i];
						node.cnode.searchid = args['searchid'];
					}
				}

				//set the count in header
				$('solution-list-count').innerHTML = "";
				$('solution-list-count-main').innerHTML = "";
				$('content-solution-list').innerHTML = "";
				$('solution-list-title').innerHTML = "";

				$('content-solution-main').style.display = "block";
				$('solution-result-menu').href = "#solutionresult";
				$('solution-result-menu').className = '';

				if (total > parseInt( args["max"] )) {
					$("content-solution-list").update(createNav(total,json.nodeset[0].start,json.nodeset[0].count,args,context,"solutions"));
				}

				$('solution-list-count').insert(json.nodeset[0].totalno);
				$('solution-list-count-main').insert(json.nodeset[0].totalno);

				if (json.nodeset[0].nodes.length > 1) {
					$("solution-list-title").insert("<?php echo $LNG->SOLUTIONS_NAME; ?>");
				} else {
					$("solution-list-title").insert("<?php echo $LNG->SOLUTION_NAME; ?>");
				}
				displaySearchNodes($("content-solution-list"),json.nodeset[0].nodes,parseInt(args['start'])+1, true);

				if (total > parseInt( args["max"] )) {
					$("content-solution-list").insert(createNav(total,json.nodeset[0].start,json.nodeset[0].count,args,context,"solutions"));
				}
			} else {
				$('content-solution-main').style.display = "none";
				$('solution-result-menu').href = "javascript:return false";
				$('solution-result-menu').className = 'inactive';
				$('solution-list-count-main').innerHTML = "";
				$('solution-list-count-main').insert('0');
			}
		}
	});
}

/**
 *	load next/previous set of nodes
 */
function loadclaims(context,args){
	args['filternodetypes'] = "Claim";

	$("content-claim-list").update(getLoading("<?php echo $LNG->LOADING_CLAIMS; ?>"));

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

			var total = json.nodeset[0].totalno;

			if(json.nodeset[0].nodes.length > 0){

				//preprosses nodes to add searchid if it is there
				if (args['searchid'] && args['searchid'] != "") {
					var nodes = json.nodeset[0].nodes;
					var count = nodes.length;
					for (var i=0; i<count; i++) {
						var node = nodes[i];
						node.cnode.searchid = args['searchid'];
					}
				}

				//set the count in header
				$('claim-list-count').innerHTML = "";
				$('claim-list-count-main').innerHTML = "";
				$('content-claim-list').innerHTML = "";
				$('claim-list-title').innerHTML = "";

				$('content-claim-main').style.display = "block";
				$('claim-result-menu').href = "#claimresult";
				$('claim-result-menu').className = '';

				if (total > parseInt( args["max"] )) {
					$("content-claim-list").update(createNav(total,json.nodeset[0].start,json.nodeset[0].count,args,context,"claims"));
				}

				$('claim-list-count').insert(json.nodeset[0].totalno);
				$('claim-list-count-main').insert(json.nodeset[0].totalno);

				if (json.nodeset[0].nodes.length > 1) {
					$("claim-list-title").insert("<?php echo $LNG->CLAIMS_NAME; ?>");
				} else {
					$("claim-list-title").insert("<?php echo $LNG->CLAIM_NAME; ?>");
				}
				displaySearchNodes($("content-claim-list"),json.nodeset[0].nodes,parseInt(args['start'])+1, true);

				if (total > parseInt( args["max"] )) {
					$("content-claim-list").insert(createNav(total,json.nodeset[0].start,json.nodeset[0].count,args,context,"claims"));
				}
			}  else {
				$('content-claim-main').style.display = "none";
				$('claim-result-menu').href = "javascript:return false";
				$('claim-result-menu').className = 'inactive';
				$('claim-list-count-main').innerHTML = "";
				$('claim-list-count-main').insert('0');
			}
		}
	});
}

/**
 *	load next/previous set of evidence nodes
 */
function loadevidence(context,args) {

	var types = EVIDENCE_TYPES_STR;

	if (args['filternodetypes'] == "" || types.indexOf(args['filternodetypes']) == -1) {
		args['filternodetypes'] = types;
	}

	$("content-evidence-list").update(getLoading("<?php echo $LNG->LOADING_EVIDENCES; ?>"));

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

			var total = json.nodeset[0].totalno;

			if(json.nodeset[0].nodes.length > 0){

				//preprosses nodes to add searchid if it is there
				if (args['searchid'] && args['searchid'] != "") {
					var nodes = json.nodeset[0].nodes;
					var count = nodes.length;
					for (var i=0; i<count; i++) {
						var node = nodes[i];
						node.cnode.searchid = args['searchid'];
					}
				}

				//set the count in header
				$('evidence-list-count').innerHTML = "";
				$('evidence-list-count-main').innerHTML = "";
				$('content-evidence-list').innerHTML = "";
				$('evidence-list-title').innerHTML = "";

				$('content-evidence-main').style.display = "block";
				$('evidence-result-menu').href = "#evidenceresult";
				$('evidence-result-menu').className = '';

				if (total > parseInt( args["max"] )) {
					$("content-evidence-list").update(createNav(total,json.nodeset[0].start,json.nodeset[0].count,args,context,"evidence"));
				}

				$('evidence-list-count').insert(json.nodeset[0].totalno);
				$('evidence-list-count-main').insert(json.nodeset[0].totalno);

				$("evidence-list-title").insert("<?php echo $LNG->EVIDENCE_NAME; ?>");

				displaySearchNodes($("content-evidence-list"),json.nodeset[0].nodes,parseInt(args['start'])+1, true);

				if (total > parseInt( args["max"] )) {
					$("content-evidence-list").insert(createNav(total,json.nodeset[0].start,json.nodeset[0].count,args,context,"evidence"));
				}
			} else {
				$('content-evidence-main').style.display = "none";
				$('evidence-result-menu').href = "javascript:return false";
				$('evidence-result-menu').className = 'inactive';
				$('evidence-list-count-main').innerHTML = "";
				$('evidence-list-count-main').insert('0');
			}
		}
	});
}

/**
 *	load next/previous set of urls
 */
function loadurls(context,args){
	var types = RESOURCE_TYPES_STR;

	if (args['filternodetypes'] == "" || types.indexOf(args['filternodetypes']) == -1) {
		args['filternodetypes'] = types;
	}

	$("content-web-list").update(getLoading("<?php echo $LNG->LOADING_RESOURCES; ?>"));

	var reqUrl = SERVICE_ROOT + "&method=getnodesby" + context + "&" + Object.toQueryString(args);
	new Ajax.Request(reqUrl, { method:'get',
		onSuccess: function(transport){
			var json = transport.responseText.evalJSON();
			if(json.error){
				alert(json.error[0].message);
				return;
			}


			var total = json.nodeset[0].totalno;

			if(total > 0){

				//preprosses nodes to add searchid if it is there
				if (args['searchid'] && args['searchid'] != "") {
					var nodes = json.nodeset[0].nodes;
					var count = nodes.length;
					for (var i=0; i<count; i++) {
						var node = nodes[i];
						node.cnode.searchid = args['searchid'];
					}
				}

				//set the count in header
				$('web-list-count').innerHTML = "";
				$('web-list-count-main').innerHTML = "";
				$('content-web-list').innerHTML = "";
				$('web-list-title').innerHTML = "";

				$('content-web-main').style.display = "block";
				$('web-result-menu').href = "#webresult";
				$('web-result-menu').className = '';

				if (total > parseInt( args["max"] )) {
					$("content-web-list").update(createNav(total,json.nodeset[0].start,json.nodeset[0].count,args,context,"urls"));
				}

				$('web-list-count').insert(json.nodeset[0].totalno);
				$('web-list-count-main').insert(json.nodeset[0].totalno);

				if (json.nodeset[0].nodes.length > 1) {
					$("web-list-title").insert("<?php echo $LNG->RESOURCES_NAME; ?>");
				} else {
					$("web-list-title").insert("<?php echo $LNG->RESOURCE_NAME; ?>");
				}
				displaySearchNodes($("content-web-list"),json.nodeset[0].nodes,parseInt(args['start'])+1, true);

				if (total > parseInt( args["max"] )) {
					$("content-web-list").insert(createNav(total,json.nodeset[0].start,json.nodeset[0].count,args,context,"urls"));
				}
			} else {
				$('content-web-main').style.display = "none";
				$('web-result-menu').href = "javascript:return false";
				$('web-result-menu').className = 'inactive';
				$('web-list-count-main').innerHTML = "";
				$('web-list-count-main').insert('0');
			}
		}
	});
}

/**
 *	load next/previous set of people and groups
 */
function loadusers(context,args){

	$("content-user-list").update(getLoading("<?php echo $LNG->LOADING_USERS; ?>"));

	var reqUrl = SERVICE_ROOT + "&method=getusersby" + context + "&includegroups=false&" + Object.toQueryString(args);

	new Ajax.Request(reqUrl, { method:'get',
		onError: function(error) {
			alert(error);
		},
		onSuccess: function(transport){
			var json = transport.responseText.evalJSON();
			if(json.error){
				alert(json.error[0].message);
				return;
			}

			var total = json.userset[0].totalno;

			if(json.userset[0].count > 0){

				//preprosses nodes to add searchid if it is there
				if (args['searchid'] && args['searchid'] != "") {
					var users = json.userset[0].users;
					var count = users.length;
					for (var i=0; i<count; i++) {
						var user = users[i].user;
						user.searchid = args['searchid'];
					}
				}

				//set the count in header
				$('user-list-count').innerHTML = "";
				$('user-list-count-main').innerHTML = "";
				$('content-user-list').innerHTML = "";
				$('user-list-title').innerHTML = "";

				$('user-result-menu').href = "#userresult";
				$('user-result-menu').className = '';

				$('content-user-main').style.display = "block";

				if (total > parseInt( args["max"] )) {
					$("content-user-list").update(createNav(total,json.userset[0].start,json.userset[0].count,args,context,"users"));
				}

				$('user-list-count').insert(json.userset[0].totalno);
				$('user-list-count-main').insert(json.userset[0].totalno);

				if (json.userset[0].users.length > 1) {
					$("user-list-title").insert("<?php echo $LNG->USERS_NAME; ?>");
				} else {
					$("user-list-title").insert("<?php echo $LNG->USER_NAME; ?>");
				}

				if (json.userset[0].users.length > 1) {
					var tb2 = new Element("div", {'class':'toolbarrow'});
					var sortOpts = {date: '<?php echo $LNG->SORT_CREATIONDATE; ?>', name: '<?php echo $LNG->SORT_NAME; ?>', moddate: '<?php echo $LNG->SORT_MODDATE; ?>'};
					tb2.insert(displaySortForm(sortOpts,args,'user',reorderUsers));
					$("content-user-list").insert(tb2);
					$("content-user-list").insert("<br><br>");
				}

				displayUsers($("content-user-list"),json.userset[0].users,parseInt(args['start'])+1);

				if (total > parseInt( args["max"] )) {
					$("content-user-list").insert(createNav(total,json.userset[0].start,json.userset[0].count,args,context,"users"));
				}
			} else {
				$('content-user-main').style.display = "none";
				$('user-result-menu').href = "javascript:return false";
				$('user-result-menu').className = 'inactive';
				$('user-list-count-main').innerHTML = "";
				$('user-list-count-main').insert('0');
			}
		}
	});
}

/**
 *	load chat nodes for search
 */
function loadchat(context,args) {

	var types = 'Comment';

	if (args['filternodetypes'] == "" || types.indexOf(args['filternodetypes']) == -1) {
		args['filternodetypes'] = types;
	}

	$("content-chat-list").update(getLoading("<?php echo $LNG->LOADING_RESOURCES; ?>"));

	var reqUrl = SERVICE_ROOT + "&method=getnodesby" + context + "&" + Object.toQueryString(args);
	new Ajax.Request(reqUrl, { method:'get',
		onSuccess: function(transport){
			var json = transport.responseText.evalJSON();
			if(json.error){
				alert(json.error[0].message);
				return;
			}

			var total = json.nodeset[0].totalno;

			if(total > 0){

				//preprosses nodes to add searchid if it is there
				if (args['searchid'] && args['searchid'] != "") {
					var nodes = json.nodeset[0].nodes;
					var count = nodes.length;
					for (var i=0; i<count; i++) {
						var node = nodes[i];
						node.cnode.searchid = args['searchid'];
					}
				}

				//set the count in header
				$('chat-list-count').innerHTML = "";
				$('chat-list-count-main').innerHTML = "";
				$('content-chat-list').innerHTML = "";
				$('chat-list-title').innerHTML = "";

				$('content-chat-main').style.display = "block";
				$('chat-result-menu').href = "#chatresult";
				$('chat-result-menu').className = '';

				if (total > parseInt( args["max"] )) {
					$("content-chat-list").update(createNav(total,json.nodeset[0].start,json.nodeset[0].count,args,context,"chats"));
				}

				$('chat-list-count').insert(json.nodeset[0].totalno);
				$('chat-list-count-main').insert(json.nodeset[0].totalno);

				if (json.nodeset[0].nodes.length > 1) {
					$("chat-list-title").insert("<?php echo $LNG->CHATS_NAME; ?>");
				} else {
					$("chat-list-title").insert("<?php echo $LNG->CHAT_NAME; ?>");
				}
				displaySearchNodes($("content-chat-list"),json.nodeset[0].nodes,parseInt(args['start'])+1, true);

				if (total > parseInt( args["max"] )) {
					$("content-chat-list").insert(createNav(total,json.nodeset[0].start,json.nodeset[0].count,args,context,"chats"));
				}
			} else {
				$('content-chat-main').style.display = "none";
				$('chat-result-menu').href = "javascript:return false";
				$('chat-result-menu').className = 'inactive';
				$('chat-list-count-main').innerHTML = "";
				$('chat-list-count-main').insert('0');
			}
		}
	});
}

/**
 *	load comment nodes for search
 */
function loadcomment(context,args) {

	var types = 'Idea';

	if (args['filternodetypes'] == "" || types.indexOf(args['filternodetypes']) == -1) {
		args['filternodetypes'] = types;
	}

	$("content-comment-list").update(getLoading("<?php echo $LNG->LOADING_RESOURCES; ?>"));

	var reqUrl = SERVICE_ROOT + "&method=getnodesby" + context + "&" + Object.toQueryString(args);
	new Ajax.Request(reqUrl, { method:'get',
		onSuccess: function(transport){
			var json = transport.responseText.evalJSON();
			if(json.error){
				alert(json.error[0].message);
				return;
			}

			var total = json.nodeset[0].totalno;

			if(total > 0){

				//preprosses nodes to add searchid if it is there
				if (args['searchid'] && args['searchid'] != "") {
					var nodes = json.nodeset[0].nodes;
					var count = nodes.length;
					for (var i=0; i<count; i++) {
						var node = nodes[i];
						node.cnode.searchid = args['searchid'];
					}
				}

				//set the count in header
				$('comment-list-count').innerHTML = "";
				$('comment-list-count-main').innerHTML = "";
				$('content-comment-list').innerHTML = "";
				$('comment-list-title').innerHTML = "";

				$('content-comment-main').style.display = "block";
				$('comment-result-menu').href = "#commentresult";
				$('comment-result-menu').className = '';

				if (total > parseInt( args["max"] )) {
					$("content-comment-list").update(createNav(total,json.nodeset[0].start,json.nodeset[0].count,args,context,"comment"));
				}

				$('comment-list-count').insert(json.nodeset[0].totalno);
				$('comment-list-count-main').insert(json.nodeset[0].totalno);

				if (json.nodeset[0].nodes.length > 1) {
					$("comment-list-title").insert("<?php echo $LNG->COMMENTS_NAME; ?>");
				} else {
					$("comment-list-title").insert("<?php echo $LNG->COMMENT_NAME; ?>");
				}
				displaySearchNodes($("content-comment-list"),json.nodeset[0].nodes,parseInt(args['start'])+1, true);

				if (total > parseInt( args["max"] )) {
					$("content-comment-list").insert(createNav(total,json.nodeset[0].start,json.nodeset[0].count,args,context,"comment"));
				}
			} else {
				$('content-comment-main').style.display = "none";
				$('comment-result-menu').href = "javascript:return false";
				$('comment-result-menu').className = 'inactive';
				$('comment-list-count-main').innerHTML = "";
				$('comment-list-count-main').insert('0');
			}
		}
	});
}

/**
 *	load news nodes for search
 */
function loadnews(context,args) {

	var types = 'News';

	if (args['filternodetypes'] == "" || types.indexOf(args['filternodetypes']) == -1) {
		args['filternodetypes'] = types;
	}

	$("content-news-list").update(getLoading("<?php echo $LNG->LOADING_ITEMS; ?>"));

	var reqUrl = SERVICE_ROOT + "&method=getnodesby" + context + "&" + Object.toQueryString(args);
	new Ajax.Request(reqUrl, { method:'get',
		onSuccess: function(transport){
			var json = transport.responseText.evalJSON();
			if(json.error){
				alert(json.error[0].message);
				return;
			}

			var total = json.nodeset[0].totalno;

			if(total > 0){

				//preprosses nodes to add searchid if it is there
				if (args['searchid'] && args['searchid'] != "") {
					var nodes = json.nodeset[0].nodes;
					var count = nodes.length;
					for (var i=0; i<count; i++) {
						var node = nodes[i];
						node.cnode.searchid = args['searchid'];
					}
				}

				//set the count in header
				$('news-list-count').innerHTML = "";
				$('news-list-count-main').innerHTML = "";
				$('content-news-list').innerHTML = "";
				$('news-list-title').innerHTML = "";

				$('content-news-main').style.display = "block";
				$('news-result-menu').href = "#newsresult";
				$('news-result-menu').className = '';

				if (total > parseInt( args["max"] )) {
					$("content-news-list").update(createNav(total,json.nodeset[0].start,json.nodeset[0].count,args,context,"news"));
				}

				$('news-list-count').insert(json.nodeset[0].totalno);
				$('news-list-count-main').insert(json.nodeset[0].totalno);

				if (json.nodeset[0].nodes.length > 1) {
					$("news-list-title").insert("<?php echo $LNG->NEWSS_NAME; ?>");
				} else {
					$("news-list-title").insert("<?php echo $LNG->NEWS_NAME; ?>");
				}
				displaySearchNodes($("content-news-list"),json.nodeset[0].nodes,parseInt(args['start'])+1, true);

				if (total > parseInt( args["max"] )) {
					$("content-news-list").insert(createNav(total,json.nodeset[0].start,json.nodeset[0].count,args,context,"news"));
				}
			} else {
				$('content-news-main').style.display = "none";
				$('news-result-menu').href = "javascript:return false";
				$('news-result-menu').className = 'inactive';
				$('news-list-count-main').innerHTML = "";
				$('news-list-count-main').insert('0');
			}
		}
	});
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
 * show the sort form
 */
function displayUserSortForm(sortOpts,args,tab,handler){

	var sbTool = new Element("span", {'class':'sortback toolbar2'});
    sbTool.insert("<?php echo $LNG->SORT_BY; ?>: ");

    var selOrd = new Element("select");
    selOrd.id = "select-orderby-"+tab;
    selOrd.className = "toolbar";
    selOrd.name = "orderby";
 	Event.observe(selOrd,'change',handler);
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
    sortBy.id = "select-sort-"+tab;
    sortBy.className = "toolbar";
    sortBy.name = "sort";
 	Event.observe(sortBy,'change',handler);
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
 * Handle when the sort menus are changed
 */
function handleSort() {
	// used as global holding space
	NODE_ARGS['start'] = 0;
	NODE_ARGS['sort'] = $('select-sort-node').options[$('select-sort-node').selectedIndex].value;
	NODE_ARGS['orderby'] = $('select-orderby-node').options[$('select-orderby-node').selectedIndex].value;

	CHALLENGE_ARGS['start'] = 0;
	CHALLENGE_ARGS['sort'] = NODE_ARGS['sort'];
	CHALLENGE_ARGS['orderby'] = NODE_ARGS['orderby'];
	loadchallenges(CONTEXT,CHALLENGE_ARGS);

	ISSUE_ARGS['start'] = 0;
	ISSUE_ARGS['sort'] = NODE_ARGS['sort'];
	ISSUE_ARGS['orderby'] = NODE_ARGS['orderby'];
	loadissues(CONTEXT,ISSUE_ARGS);

	SOLUTION_ARGS['start'] = 0;
	SOLUTION_ARGS['sort'] = NODE_ARGS['sort'];
	SOLUTION_ARGS['orderby'] = NODE_ARGS['orderby'];
	loadsolutions(CONTEXT,SOLUTION_ARGS);

	CLAIM_ARGS['start'] = 0;
	CLAIM_ARGS['sort'] = NODE_ARGS['sort'];
	CLAIM_ARGS['orderby'] = NODE_ARGS['orderby'];
	loadclaims(CONTEXT,CLAIM_ARGS);

	EVIDENCE_ARGS['start'] = 0;
	EVIDENCE_ARGS['sort'] = NODE_ARGS['sort'];
	EVIDENCE_ARGS['orderby'] = NODE_ARGS['orderby'];
	loadevidence(CONTEXT,EVIDENCE_ARGS);

	URL_ARGS['start'] = 0;
	URL_ARGS['sort'] = NODE_ARGS['sort'];
	URL_ARGS['orderby'] = NODE_ARGS['orderby'];
	loadurls(CONTEXT,URL_ARGS);

	ORG_ARGS['start'] = 0;
	ORG_ARGS['sort'] = NODE_ARGS['sort'];
	ORG_ARGS['orderby'] = NODE_ARGS['orderby'];
	loadorgs(CONTEXT,ORG_ARGS);

	PROJECT_ARGS['start'] = 0;
	PROJECT_ARGS['sort'] = NODE_ARGS['sort'];
	PROJECT_ARGS['orderby'] = NODE_ARGS['orderby'];
	loadprojects(CONTEXT,PROJECT_ARGS);

	CHAT_ARGS['start'] = 0;
	CHAT_ARGS['sort'] = NODE_ARGS['sort'];
	CHAT_ARGS['orderby'] = NODE_ARGS['orderby'];
	loadchats(CONTEXT,CHAT_ARGS);

	COMMENT_ARGS['start'] = 0;
	COMMENT_ARGS['sort'] = NODE_ARGS['sort'];
	COMMENT_ARGS['orderby'] = NODE_ARGS['orderby'];
	loadcomments(CONTEXT,COMMENT_ARGS);

	NEWS_ARGS['start'] = 0;
	NEWS_ARGS['sort'] = NODE_ARGS['sort'];
	NEWS_ARGS['orderby'] = NODE_ARGS['orderby'];
	loadnews(CONTEXT,NEWS_ARGS);
}

/**
 * show the sort form
 */
function displaySortForm(sortOpts){

	var sbTool = new Element("span", {'class':'sortback toolbar2'});
    sbTool.insert("<?php echo $LNG->SORT_BY; ?>: ");

    var selOrd = new Element("select");
    selOrd.id = "select-orderby-node";
    selOrd.className = "toolbar";
    selOrd.name = "orderby";
    sbTool.insert(selOrd);
 	Event.observe(selOrd,'change',handleSort);
    for(var key in sortOpts){
        var opt = new Element("option");
        opt.value=key;
        opt.insert(sortOpts[key].valueOf());
        selOrd.insert(opt);
        if(NODE_ARGS.orderby == key){
        	opt.selected = true;
        }
    }
    var sortBys = {ASC: '<?php echo $LNG->SORT_ASC; ?>', DESC: '<?php echo $LNG->SORT_DESC; ?>'};
    var sortBy = new Element("select");
    sortBy.id = "select-sort-node";
    sortBy.className = "toolbar";
    sortBy.name = "sort";
    sbTool.insert(sortBy);
 	Event.observe(sortBy,'change',handleSort);
    for(var key in sortBys){
        var opt = new Element("option");
        opt.value=key;
        opt.insert(sortBys[key]);
        sortBy.insert(opt);
        if(NODE_ARGS.sort == key){
        	opt.selected = true;
        }
    }

    return sbTool;
}

function createThemeFilter() {

	var sbTool = new Element("span", {'class':'themebackpale toolbar2'});
    sbTool.insert("<?php echo $LNG->FILTER_BY; ?>: ");

	var filterMenu= new Element("select", {'class':'subforminput hgrselecthgrselect toolbar'});

	var option = new Element("option", {'value':''});
	option.insert('<?php echo $LNG->FILTER_THEMES_ALL; ?>');
	filterMenu.insert(option);

	var i=0;
	for(i=0; i<THEMES.length; i++){
		var option = new Element("option", {'value':THEMES[i]});
		if (NODE_ARGS['filterthemes'] && NODE_ARGS['filterthemes'] == THEMES[i]) {
			option.selected = true;
		}
		option.insert(THEMES[i]);
		filterMenu.insert(option);
	}

	Event.observe(filterMenu,"change", function(){
		var theme = this.value;

		// Used as global holding space
		NODE_ARGS['filterthemes'] = theme;

		CHALLENGE_ARGS['filterthemes'] = theme;
 		loadchallenges(CONTEXT,CHALLENGE_ARGS);

		ISSUE_ARGS['filterthemes'] = theme;
		loadissues(CONTEXT, ISSUE_ARGS);

		SOLUTION_ARGS['filterthemes'] = theme;
		loadsolutions(CONTEXT,SOLUTION_ARGS);

		CLAIM_ARGS['filterthemes'] = theme;
		loadclaims(CONTEXT,CLAIM_ARGS);

		EVIDENCE_ARGS['filterthemes'] = theme;
		loadevidence(CONTEXT,EVIDENCE_ARGS);

		URL_ARGS['filterthemes'] = theme;
		loadurls(CONTEXT,URL_ARGS);

		ORG_ARGS['filterthemes'] = theme;
		loadorgs(CONTEXT,ORG_ARGS);

		PROJECTS_ARGS['filterthemes'] = theme;
		loadprojects(CONTEXT,PROJECT_ARGS);
	});

	sbTool.insert(filterMenu);

	return sbTool;
}

/**
 * display Nav
 */
function createNav(total, start, count, argArray, context, type){

	var nav = new Element ("div",{'id':'page-nav', 'class':'toolbarrow', 'style':'padding-top: 8px; padding-bottom: 8px;'});

	var header = createNavCounter(total, start, count, type);
	nav.insert(header);

	if (total > parseInt( argArray["max"] )) {
		//previous
	    var prevSpan = new Element("span", {'id':"nav-previous"});
	    if(start > 0){
			prevSpan.update("<img alt='<?php echo $LNG->LIST_NAV_PREVIOUS_HINT; ?>' title='<?php echo $LNG->LIST_NAV_PREVIOUS_HINT; ?>' src='<?php echo $HUB_FLM->getImagePath("arrow-left2.png"); ?>' class='toolbar' style='padding-right: 0px;' />");
	        prevSpan.addClassName("active");
	        Event.observe(prevSpan,"click", function(){
	            var newArr = argArray;
	            newArr["start"] = parseInt(start) - newArr["max"];
	            eval("load"+type+"(context,newArr)");
	        });
	    } else {
			prevSpan.update("<img alt='<?php echo $LNG->LIST_NAV_NO_PREVIOUS_HINT; ?>' title='<?php echo $LNG->LIST_NAV_NO_PREVIOUS_HINT; ?>' disabled src='<?php echo $HUB_FLM->getImagePath("arrow-left2-disabled.png"); ?>' class='toolbar' style='padding-right: 0px;' />");
	        prevSpan.addClassName("inactive");
	    }

	    //pages
	    var pageSpan = new Element("span", {'id':"nav-pages"});
	    var totalPages = Math.ceil(total/argArray["max"]);
	    var currentPage = (start/argArray["max"]) + 1;
	    for (var i = 1; i<totalPages+1; i++){
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
	    var nextSpan = new Element("span", {'id':"nav-next"});
	    if(parseInt(start)+parseInt(count) < parseInt(total)){
		    nextSpan.update("<img alt='<?php echo $LNG->LIST_NAV_NEXT_HINT; ?>' title='<?php echo $LNG->LIST_NAV_NEXT_HINT; ?>' src='<?php echo $HUB_FLM->getImagePath('arrow-right2.png'); ?>' class='toolbar' style='padding-right: 0px;' />");
	        nextSpan.addClassName("active");
	        Event.observe(nextSpan,"click", function(){
	            var newArr = argArray;
	            newArr["start"] = parseInt(start) + parseInt(newArr["max"]);
	            eval("load"+type+"(context, newArr)");
	        });
	    } else {
		    nextSpan.update("<img alt='<?php echo $LNG->LIST_NAV_NO_NEXT_HINT; ?>' title='<?php echo $LNG->LIST_NAV_NO_NEXT_HINT; ?>' src='<?php echo $HUB_FLM->getImagePath('arrow-right2-disabled.png'); ?>' class='toolbar' style='padding-right: 0px;' />");
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
        objH.insert("<b>" + s1 + " to " + s2 + " (" + total + ")</b>");
    }
    return objH;
}

var Pages = {
	next: function(e){
		var data = $A(arguments);
		eval("load"+data[1]+"(data[2],data[3])");
	}
};