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

var challenges = {};
var issues = {};
var solutions = {};
var evidence = {};

var linearnodeid = CLAIM_ARGS['nodeid'];
var linearnodekey = 'claim';

var nodekey = "Node"+linearnodeid;

var narrowloaded = false;
var widerloaded = false;
var narrownodetofocusid = "";
var widernodetofocusid = "";

function loadClaimLinearPage() {
	getConnections("");
};

function getConnections(nodetofocusid) {
	if (DEBATE_TREE_SMALL) {
		$('content-list').update(getLoading("<?php echo $LNG->DEBATE_LOADING; ?>"));
	}

	var allConnections = new Array();

	// GET CONNECTIONS UP FROM ME
	var args = {};

	args["nodeid"] = linearnodeid;
	args["start"] = 0;
	args['max'] = "-1";
	args['scope'] = "all";
	args['style'] = "short";
	args['labelmatch'] = 'false';
	args['uniquepath'] = 'false';
	args['logictype'] = 'or';

	var extra = "&nodeids[]=";
	if (hasChallenge) {
		args['depth'] = 2;

		extra += "&nodeids[]=";

		extra += "&nodetypes[]="+encodeURIComponent('Issue');
		extra += "&nodetypes[]="+encodeURIComponent('Challenge');

		extra += "&directions[]=outgoing";
		extra += "&directions[]=outgoing";

		extra += "&linklabels[]="+encodeURIComponent('responds to');
		extra += "&linklabels[]="+encodeURIComponent('is related to');

		extra += "&linkgroups[]=";
		extra += "&linkgroups[]=";
	} else {
		args['depth'] = 1;
		extra += "&nodetypes[]="+encodeURIComponent('Issue');
		extra += "&directions[]=outgoing";
		extra += "&linklabels[]="+encodeURIComponent('responds to');
		extra += "&linkgroups[]=";
	}

	var reqUrl = SERVICE_ROOT + "&method=getconnectionsbypathbydepth"+extra+"&" + Object.toQueryString(args);
	//alert(reqUrl);
	new Ajax.Request(reqUrl, { method:'post',
		onSuccess: function(transport){
			var json = null;
			try {
				json = transport.responseText.evalJSON();
			} catch(e) {
				alert(e);
			}
			if(json.error){
				alert(json.error[0].message);
				return;
			}

			var conns = json.connectionset[0].connections;
			//alert(conns.length);
			if (conns.length > 0) {
				for(var i=0; i< conns.length; i++){
					var c = conns[i].connection;
					allConnections.push(c);
				}
			}

			// GET CONNECTIONS DOWN FROM ME
			var args = {}; //must be an empty object to send down the url, or all the Array functions get sent too.

			args["nodeid"] = SOLUTION_ARGS['nodeid'];
			args["start"] = 0;
			args['max'] = "-1";
			args['scope'] = "all";

			args['style'] = "short";
			args['depth'] = 2;

			args['labelmatch'] = 'false';
			args['uniquepath'] = 'false';
			args['logictype'] = 'or';

			var extra = "&nodeids[]=";
			extra += "&nodeids[]=";

			extra += "&nodetypes[]="+encodeURIComponent('Pro,Con,'+EVIDENCE_TYPES_STR);
			extra += "&nodetypes[]="+encodeURIComponent(RESOURCE_TYPES_STR);

			extra += "&directions[]=incoming";
			extra += "&directions[]=both";

			extra += "&linklabels[]="+encodeURIComponent('supports,challenges');
			extra += "&linklabels[]="+encodeURIComponent('is related to');

			extra += "&linkgroups[]=";
			extra += "&linkgroups[]=";

			var reqUrl = SERVICE_ROOT + "&method=getconnectionsbypathbydepth"+extra+"&" + Object.toQueryString(args);
			//alert(reqUrl);
			new Ajax.Request(reqUrl, { method:'post',
				onSuccess: function(transport){
					var json = null;
					try {
						json = transport.responseText.evalJSON();
					} catch(e) {
						alert(e);
					}
					if(json.error){
						alert(json.error[0].message);
						return;
					}

					var conns2 = json.connectionset[0].connections;
					//alert(conns2.length);
					if (conns2.length > 0) {
						for(var i=0; i< conns2.length; i++){
							var c = conns2[i].connection;
							allConnections.push(c);
						}
					}

					if (allConnections.length > 0) {
						processConnections(allConnections, nodetofocusid);
					} else {
						if (DEBATE_TREE_SMALL) {
							$('content-list').update('<span style="margin-left:5px;"><?php echo $LNG->DEBATE_NO_DEBATES_CLAIM; ?></span>');
						} else {
							$('content-list-expanded').update('<span style="margin-left:5px;"><?php echo $LNG->DEBATE_NO_DEBATES_CLAIM; ?></span>');
						}

						CURRENT_ADD_AREA_NODEID = CLAIM_ARGS['nodeid'];
						CURRENT_ADD_AREA_NODE = nodeObj;
						addScriptDynamically('<?php echo $HUB_FLM->getCodeWebPath("ui/explore/linear/claimlinearadd.js.php"); ?>', 'explore-linear-claim-script');
					}
				}
			});

		}
	});
}

function processConnections(allConnections, nodetofocusid) {

// GROUP CONNECTIONS INTO THE 4 LEVELS
	challenges = {};
	issues = {};
	solutions = {};
	evidence = {};

	var left = new Array();

	for(var i=0; i< allConnections.length; i++) {

		var c = allConnections[i];
		//var fN = c.from[0].cnode;
		var tN = c.to[0].cnode;
		//var fnRole = c.fromrole[0].role;
		var tnRole = c.to[0].cnode.role[0].role;
		if (tnRole.name == "Challenge") {
			if (challenges.hasOwnProperty(tN.nodeid)) {
				challenges[tN.nodeid].push(c);
			} else {
				var next = new Array();
				next.push(c);
				challenges[tN.nodeid] = next;
			}
		} else {
			left.push(c);
		}
	}

	//alert("challenges:"+Object.keys(challenges).length);

	var stillLeft = new Array();
	for(var i=0; i< left.length; i++){
		var c = left[i];
		//var fN = c.from[0].cnode;
		var tN = c.to[0].cnode;
		//var fnRole = c.fromrole[0].role;
		var tnRole = c.to[0].cnode.role[0].role;
		if (tnRole.name == "Issue") {
			if (issues.hasOwnProperty(tN.nodeid)) {
				issues[tN.nodeid].push(c);
			} else {
				var next = new Array();
				next.push(c);
				issues[tN.nodeid] = next;
			}
		} else {
			stillLeft.push(c);
		}
	}

	//alert("issues:"+Object.keys(issues).length);

	var stillLeft2 = new Array();
	for(var i=0; i< stillLeft.length; i++){
		var c = stillLeft[i];
		//var fN = c.from[0].cnode;
		var tN = c.to[0].cnode;
		//var fnRole = c.fromrole[0].role;
		var tnRole = c.to[0].cnode.role[0].role;
		if (tnRole.name == "Claim") {
			if (solutions.hasOwnProperty(tN.nodeid)) {
				solutions[tN.nodeid].push(c);
			} else {
				var next = new Array();
				next.push(c);
				solutions[tN.nodeid] = next;
			}
		} else {
			stillLeft2.push(c);
		}
	}

	//alert("solutions:"+Object.keys(solutions).length);

	var stillLeft3 = new Array();
	for(var i=0; i< stillLeft2.length; i++){
		var c = stillLeft2[i];
		//var fN = c.from[0].cnode;
		var tN = c.to[0].cnode;
		//var fnRole = c.fromrole[0].role;
		var tnRole = c.to[0].cnode.role[0].role;
		if (EVIDENCE_TYPES_STR.indexOf(tnRole.name) != -1) {
			if (evidence.hasOwnProperty(tN.nodeid)) {
				evidence[tN.nodeid].push(c);
			} else {
				var next = new Array();
				next.push(c);
				evidence[tN.nodeid] = next;
			}
		} else {
			stillLeft3.push(c);
		}
	}

	//alert("evidence:"+Object.keys(evidence).length);
	//alert("still left:"+stillLeft3.length);

	//Object.clone(EVIDENCE_ARGS);


// ADD CHILDREN LISTS TO PARENTS

	if (Object.keys(evidence).length > 0) {
		for(var index in evidence) {
			var children = new Array();
			var check = new Array();
			var conns = evidence[index];
			for(var i=0; i< conns.length; i++){
				var c = conns[i];
				var fN = c.from[0];
				if (fN.cnode.name != "") {
					if (!check[fN.cnode.nodeid]) {
						var next = fN;
						next.cnode['connection'] = c;
						next.cnode['handler'] = ""; //handler;
						next.cnode['focalnodeid'] = linearnodeid;
						children.push(next);
						check[fN.cnode.nodeid] = next;
					}
				}
			}

			children.sort(connectiontypenodesort);
			children.sort(connectiontypealphanodesort);

			// Add the children lists to the parent nodes
			for(var ind2 in solutions){
				var nextsol = solutions[ind2];
				for(var i=0; i< nextsol.length; i++){
					var c = nextsol[i];
					var fromid = c.from[0].cnode.nodeid;
					if (fromid == index) {
						c.from[0].cnode.children = children;
					}
				}
			}
		}
	}

	if (Object.keys(solutions).length > 0) {
		for(var index in solutions) {
			var children = new Array();
			var check = new Array();
			var conns = solutions[index];
			for(var i=0; i< conns.length; i++){
				var c = conns[i];
				var fN = c.from[0];
				if (fN.cnode.name != "") {
					if (!check[fN.cnode.nodeid]) {
						var next = fN;
						next.cnode['connection'] = c;
						next.cnode['handler'] = ""; //handler;
						next.cnode['focalnodeid'] = linearnodeid;
						children.push(next);
						check[fN.cnode.nodeid] = next;
					}
				}
			}

			children.sort(connectiontypenodesort);
			children.sort(connectiontypealphanodesort);

			for(var ind2 in issues){
				var nextsol = issues[ind2];
				for(var i=0; i< nextsol.length; i++){
					var c = nextsol[i];
					var fromid = c.from[0].cnode.nodeid;
					if (fromid == index) {
						c.from[0].cnode.children = children;
					}
				}
			}
		}
	}

	if (Object.keys(issues).length > 0) {
		for(var index in issues) {
			var children = new Array();
			var check = new Array();
			var conns = issues[index];
			for(var i=0; i< conns.length; i++){
				var c = conns[i];
				var fN = c.from[0];
				if (fN.cnode.name != "") {
					if (!check[fN.cnode.nodeid]) {
						var next = fN;
						next.cnode['connection'] = c;
						next.cnode['handler'] = ""; //handler;
						next.cnode['focalnodeid'] = linearnodeid;
						children.push(next);
						check[fN.cnode.nodeid] = next;
					}
				}
			}

			children.sort(connectiontypenodesort);
			children.sort(connectiontypealphanodesort);

			for(var ind2 in challenges){
				var nextsol = challenges[ind2];
				for(var i=0; i< nextsol.length; i++){
					var c = nextsol[i];
					var fromid = c.from[0].cnode.nodeid;
					if (fromid == index) {
						c.from[0].cnode.children = children;
					}
				}
			}
		}
	}

// CLEAR BUCKETS OF ITEMS IN CONVERSATIONS ABOVE

	/*for (var index in evidence) {
		for(var ind2 in solutions){
			var conns = solutions[ind2];
			for(var i=0; i< conns.length; i++){
				var c = conns[i];
				var fN = c.from[0];
				if (index == fN.cnode.nodeid) {
					delete evidence[index];
				}
			}
		}
	}*/

	for (var index in solutions) {
		for(var ind2 in issues){
			var conns = issues[ind2];
			for(var i=0; i< conns.length; i++){
				var c = conns[i];
				var fN = c.from[0];
				if (index == fN.cnode.nodeid) {
					delete solutions[index];
				}
			}
		}
	}
	for (var index in issues) {
		for(var ind2 in challenges){
			var conns = challenges[ind2];
			for(var i=0; i< conns.length; i++){
				var c = conns[i];
				var fN = c.from[0];
				if (index == fN.cnode.nodeid) {
					delete issues[index];
				}
			}
		}
	}

// PREPARE FOR DRAWING

	// PREPARE CHALLENGES
	for(var index in challenges) {
		//array for evidence to resource connections
		// extract the list of solution nodes as children for the issues
		var children = new Array();
		var check = new Array();
		var conns = challenges[index];
		for(var i=0; i< conns.length; i++){
			var c = conns[i];
			var fN = c.from[0];
			if (fN.cnode.name != "") {
				if (!check[fN.cnode.nodeid]) {
					var next = fN;
					next.cnode['connection'] = c;
					next.cnode['handler'] = ""; //handler;
					next.cnode['focalnodeid'] = linearnodeid;
					children.push(next);
					check[fN.cnode.nodeid] = next;
				}
			}
		}

		children.sort(alphanodesort);

		for(var ind2 in challenges){
			var nextsol = challenges[ind2];
			for(var i=0; i< nextsol.length; i++){
				var c = nextsol[i];
				var toid = c.to[0].cnode.nodeid;
				if (toid == index) {
					c.to[0].cnode.children = children;
				}
			}
		}
	}

	var nodes = new Array();
	var check = new Array();

	for(var index in challenges) {
		var conns = challenges[index];
		for(var i=0; i< conns.length; i++){
			var c = conns[i];
			var tN = c.to[0];
			if (tN.cnode.name != "") {
				if (!check[tN.cnode.nodeid]) {
					var next = tN;
					next.cnode['connection'] = c;
					//next.cnode['handler'] = handler;
					next.cnode['focalnodeid'] = linearnodeid;
					next.cnode['istop'] = true;
					nodes.push(next);
					check[tN.cnode.nodeid] = next;
				}
			}
		}
	}
	challenges = nodes;
	challenges.sort(alphanodesort);

	// PREPARE ISSUES
	for(var index in issues) {
		var children = new Array();
		var check = new Array();
		var conns = issues[index];
		for(var i=0; i< conns.length; i++){
			var c = conns[i];
			var fN = c.from[0];
			if (fN.cnode.name != "") {
				if (!check[fN.cnode.nodeid]) {
					var next = fN;
					next.cnode['connection'] = c;
					next.cnode['handler'] = ""; //handler;
					next.cnode['focalnodeid'] = linearnodeid;
					children.push(next);
					check[fN.cnode.nodeid] = next;
				}
			}
		}

		children.sort(connectiontypenodesort);
		children.sort(connectiontypealphanodesort);

		for(var ind2 in issues){
			var nextsol = issues[ind2];
			for(var i=0; i< nextsol.length; i++){
				var c = nextsol[i];
				var toid = c.to[0].cnode.nodeid;
				if (toid == index) {
					c.to[0].cnode.children = children;
				}
			}
		}
	}

	var nodes = new Array();
	var check = new Array();

	for(var index in issues) {
		var conns = issues[index];
		for(var i=0; i< conns.length; i++){
			var c = conns[i];
			var tN = c.to[0];
			if (tN.cnode.name != "") {
				if (!check[tN.cnode.nodeid]) {
					var next = tN;
					next.cnode['connection'] = c;
					//next.cnode['handler'] = handler;
					next.cnode['focalnodeid'] = linearnodeid;
					next.cnode['istop'] = true;
					nodes.push(next);
					check[tN.cnode.nodeid] = next;
				}
			}
		}
	}

	issues = nodes;
	issues.sort(alphanodesort);

	// PREPARE SOLUTIONS
	for(var index in solutions) {
		var children = new Array();
		var check = new Array();
		var conns = solutions[index];
		for(var i=0; i< conns.length; i++){
			var c = conns[i];
			var fN = c.from[0];
			if (fN.cnode.name != "") {
				if (!check[fN.cnode.nodeid]) {
					var next = fN;
					next.cnode['connection'] = c;
					next.cnode['handler'] = ""; //handler;
					next.cnode['focalnodeid'] = linearnodeid;
					children.push(next);
					check[fN.cnode.nodeid] = next;
				}
			}
		}

		children.sort(connectiontypenodesort);
		children.sort(connectiontypealphanodesort);

		for(var ind2 in solutions){
			var nextsol = solutions[ind2];
			for(var i=0; i< nextsol.length; i++){
				var c = nextsol[i];
				var toid = c.to[0].cnode.nodeid;
				if (toid == index) {
					c.to[0].cnode.children = children;
				}
			}
		}
	}

	var nodes = new Array();
	var check = new Array();

	for(var index in solutions) {
		var conns = solutions[index];
		for(var i=0; i< conns.length; i++){
			var c = conns[i];
			var tN = c.to[0];
			if (tN.cnode.name != "") {
				if (!check[tN.cnode.nodeid]) {
					var next = tN;
					next.cnode['connection'] = c;
					//next.cnode['handler'] = handler;
					next.cnode['focalnodeid'] = linearnodeid;
					next.cnode['istop'] = true;
					nodes.push(next);
					check[tN.cnode.nodeid] = next;
				}
			}
		}
	}

	solutions = nodes;
	//solutions.sort(alphanodesort);
	solutions.sort(connectiontypenodesort);
	solutions.sort(connectiontypealphanodesort);

	drawDebates(true, nodetofocusid);
}

function drawDebates(reload, nodetofocusid) {

	if (challenges.length > 0 || issues.length > 0 || solutions.length > 0) {
		$('toggleDebateButton').style.display = 'block';
	}

	// Count the number of debates and display
	var challengescount = 0;
	if (challenges.length && challenges.length > 0) {
		challengescount = challenges.length;
	}
	var issuecount = 0;
	if (issues.length && issues.length > 0) {
		issuecount = issues.length;
	}
	var solutionscount = 0;
	if (solutions.length && solutions.length > 0) {
		solutionscount = solutions.length;
	}
	var debateCount = (challengescount+issuecount+solutionscount);
	$('debatecount').update(debateCount);

	if ( DEBATE_TREE_SMALL && (!narrowloaded || reload)) {
		$('content-list-expanded').style.display = "none";
		$('content-list').style.display = "block";
		$('content-list').innerHTML="";
		narrowloaded = true
		// DRAW CHALLENGES DOWN
		if (challenges.length > 0){
			displayConnectionNodes($('content-list'),challenges,parseInt(0), true, linearnodekey+"narrow");
		}

		// DRAW ISSUES DOWN
		if (issues.length > 0){
			displayConnectionNodes($('content-list'),issues,parseInt(0), true, linearnodekey+"narrow");
		}

		// DRAW SOLUTIONS DOWN
		if (solutions.length > 0){
			displayConnectionNodes($('content-list'),solutions,parseInt(0), true, linearnodekey+"narrow");
		}

		if (nodetofocusid == "" && narrownodetofocusid != "") {
			nodetofocusid = narrownodetofocusid;
			narrownodetofocusid = "";
		}

		checkDebateHasNode(nodetofocusid);

		// Refresh the wider view if required.
		// Only if this function has been called from a data reload
		// reload = false means it comes from a toggle
		if (reload) {
			widerloaded = false;
			widernodetofocusid = nodetofocusid;
		}
	} else if (DEBATE_TREE_SMALL && narrowloaded) {
		$('content-list-expanded').style.display = "none";
		$('content-list').style.display = "block";
		checkHasNarrowGotSelected();
	} else if (!DEBATE_TREE_SMALL && (!widerloaded || reload)) {
		$('content-list').style.display = "none";
		$('content-list-expanded').style.display = "block";
		$('content-list-expanded').innerHTML="";

		if (nodetofocusid == "" && widernodetofocusid != "") {
			nodetofocusid = widernodetofocusid;
			widernodetofocusid = "";
		}

		$('lineardebateheading').insert(getLoading("<?php echo $LNG->DEBATE_WIDER_LOADING; ?>"));
    	DEBATE_TIMER = setTimeout("checkWiderDebateStillLoading('"+nodetofocusid+"')", 350);

		widerloaded = true
		// DRAW CHALLENGES DOWN
		if (challenges.length > 0){
			displayConnectionNodes($('content-list-expanded'),challenges,parseInt(0), true, linearnodekey+"expanded");
		}

		// DRAW ISSUES DOWN
		if (issues.length > 0){
			displayConnectionNodes($('content-list-expanded'),issues,parseInt(0), true, linearnodekey+"expanded");
		}

		// DRAW SOLUTIONS DOWN
		if (solutions.length > 0){
			displayConnectionNodes($('content-list-expanded'),solutions,parseInt(0), true, linearnodekey+"expanded");
		}

		// Refresh the narrower view if required.
		// Only if this function has been called from a data reload
		// reload = false means it comes from a toggle
		if (reload) {
			narrowloaded = false;
			narrownodetofocusid = nodetofocusid;
		}
	} else if (!DEBATE_TREE_SMALL && widerloaded) {
		$('content-list').style.display = "none";
		$('content-list-expanded').style.display = "block";
	}



}

loadClaimLinearPage();