<?php
/********************************************************************************
 *                                                                              *
 *  (c) Copyright 2015 The Open University UK                                   *
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

var TABS = {"remaining":true, "removed":true};
var DEFAULT_TAB = 'remaining';
var CURRENT_TAB = DEFAULT_TAB;
var DATA_LOADED = {"remaining":false, "removed":false};

var stpRemaining = setTabPushed.bindAsEventListener($('tab-remaining'),'remaining');
var stpRemoved = setTabPushed.bindAsEventListener($('tab-removed'),'removed');

/**
 *	Intial data and mode
 */
Event.observe(window, 'load', function() {
	if ($('addnewideaarea')) { $('addnewideaarea').style.display = 'block'; }

	refreshMainIssue();

	if ($('tabber')) {
		$('tabber').style.display = 'none';
	}
	refreshSolutions();
});

/**
 *	switch between tabs
 */
function setTabPushed(e) {

	var data = $A(arguments);
	var tab = data[1];

	// Check tab is know else default to default
	if (!TABS.hasOwnProperty(tab)) {
		tab = DEFAULT_TAB;
	}
	for (i in TABS){
		if ($("tab-"+i)) {
			if(tab == i){
				if($("tab-"+i)) {
					$("tab-"+i).removeClassName("unselected");
					$("tab-"+i).addClassName("current");
					if ($("tab-content-"+i+"-div")) {
						$("tab-content-"+i+"-div").show();
					}
				}
			} else {
				if($("tab-"+i)) {
					$("tab-"+i).removeClassName("current");
					$("tab-"+i).addClassName("unselected");
					if ($("tab-content-"+i+"-div")) {
						$("tab-content-"+i+"-div").hide();
					}
				}
			}
		}
	}

	CURRENT_TAB = tab;
	if (tab == "remaining") {
		$('tab-remaining').setAttribute("href",'#remaining');
		Event.stopObserving('tab-remaining','click');
		Event.observe('tab-remaining','click', stpRemaining);
		if(!DATA_LOADED.remaining) {
			loadsolutions(CONTEXT,NODE_ARGS);
			loadremovedsolutions(CONTEXT,NODE_ARGS);
		}
	} else if (tab == "removed") {
		$('tab-removed').setAttribute("href",'#removed');
		Event.stopObserving('tab-removed','click');
		Event.observe('tab-removed','click', stpRemoved);
	}
}

function refreshMainIssue() {
	var itemobj = renderIssueNode("760","", nodeObj, 'mainnode', nodeObj.role, true, 'active', false, false, false, true, true);
	$('mainnodediv').update(itemobj);
}

function hasClass(obj, className) {
    var classNames = obj.className.split(' ');
    for (var i = 0; i < classNames.length; i++) {
        if (classNames[i].toLowerCase() == className.toLowerCase()) {
            return true;
        }
    }
    return false;
}

function insertArgumentLink(uniQ, type) {

	var argumentLinkDiv = $('linksdiv'+type+uniQ);
	var count = parseInt(argumentLinkDiv.linkcount);
	count = count+1;
	argumentLinkDiv.linkcount = count;

	var weblink = new Element("input", {
		'class':'hgrinput',
		'placeholder':'<?php echo $LNG->FORM_LINK_LABEL; ?>',
		'id':'argumentlink'+type+uniQ+count,
		'name':'argumentlink'+type+uniQ+'[]',
		'value':'',
		'style':'margin-bottom:3px;'
	});

	argumentLinkDiv.insert(weblink);
	weblink.focus();
}

function insertIdeaLink(uniQ, type) {

	var argumentLinkDiv = $('linksdiv'+type+uniQ);
	var count = parseInt(argumentLinkDiv.linkcount);
	count = count+1;
	argumentLinkDiv.linkcount = count;

	var weblink = new Element("input", {
		'class':'forminput hgrwide',
		'placeholder':'<?php echo $LNG->FORM_LINK_LABEL; ?>',
		'id':'argumentlink'+type+uniQ+count,
		'name':'argumentlink'+type+uniQ+'[]',
		'value':'',
		'style':'height:16px;margin-bottom:3px;'
	});

	argumentLinkDiv.insert(weblink);
	weblink.focus();
}

function removeArgumentLink(uniQ, type) {
	var linkItemDiv = $('linkitemdiv'+type+uniQ);
	linkItemDiv.remove();
}

function toggleNewIdea() {
	if ($('addformdividea').style.display == 'none') {
		$('addformdividea').style.display='block';
		$('newideadivbutton').src='<?php echo $HUB_FLM->getImagePath("arrow-up2.png"); ?>';
	} else {
		$('addformdividea').style.display='none';
		$('newideadivbutton').src='<?php echo $HUB_FLM->getImagePath("arrow-down2.png"); ?>';
	}
}

function editInline(objno, type){
	cancelAllEdits(type);

	if ($('editformdiv'+type+objno)) {
		$('editformdiv'+type+objno).show();
	}
	if ($('textdiv'+type+objno)) {
		$('textdiv'+type+objno).hide();
	}

	if ($('editformvotediv'+type+objno)) {
		$('editformvotediv'+type+objno).hide();
	}
	if ($('editformuserdiv'+type+objno)) {
		$('editformuserdiv'+type+objno).hide();
	}
}

function cancelAllEdits(type) {
	var array = document.getElementsByTagName('div');
	for(var i=0;i<array.length;i++) {
		if (array[i].id.startsWith('editform'+type)) {
			var objno = array[i].id.substring(12);
			cancelEditAction(objno, type);
		}
	}
}

function cancelEditAction(objno, type){
	if ($('editformdiv'+type+objno)) {
		$('editformdiv'+type+objno).hide();
	}
	if ($('textdiv'+type+objno)) {
		$('textdiv'+type+objno).show();
	}
	if ($('editformvotediv'+type+objno)) {
		$('editformvotediv'+type+objno).show();
	}
	if ($('editformuserdiv'+type+objno)) {
		$('editformuserdiv'+type+objno).show();
	}

	if (type == "argument") {

	}
}

function checkIdeaAddForm() {
	var checkname = ($('idea').value).trim();
	if (checkname == ""){
	   alert("<?php echo $LNG->FORM_SOLUTION_ENTER_SUMMARY_ERROR; ?>");
	   return false;
    }

    $('ideaform').style.cursor = 'wait';

	return true;
}

function checkProAddForm(nodeid) {
	var checkname = ($('proarg'+nodeid).value).trim();
	if (checkname == ""){
	   alert("<?php echo $LNG->FORM_PRO_ENTER_SUMMARY_ERROR; ?>");
	   return false;
    }
    $('proform'+nodeid).style.cursor = 'wait';

	return true;
}

function checkConAddForm(nodeid) {
	var checkname = ($('conarg'+nodeid).value).trim();
	if (checkname == ""){
	   alert("<?php echo $LNG->FORM_CON_ENTER_SUMMARY_ERROR; ?>");
	   return false;
    }
    $('conform'+nodeid).style.cursor = 'wait';

	return true;
}

/**
 *	Called by forms to refresh the solution view
 */
function refreshSolutions() {
	loadsolutions(CONTEXT,NODE_ARGS);
}

/**
 *	load next/previous set of nodes
 */
function loadsolutions(context,args){

	var focalnodeid = args['nodeid'];
	var title = "<?php echo $LNG->SOLUTIONS_NAME; ?>";

	//return getConnectionsByNode($issueid, 0, -1, $orderby, $sort, 'selected', 'responds to', 'Solution', 'long', $status);


	var reqUrl = SERVICE_ROOT;
	var container = $('tab-content-idea-list');
	reqUrl = reqUrl + "&method=getconnectionsbynode&style=long";
	reqUrl += "&orderby="+args['orderby']+"&sort="+args['sort']+"&filternodetypes="+"Solution"+"&nodeid="+focalnodeid;

	container.update(getLoading("<?php echo $LNG->LOADING_SOLUTIONS; ?>"));

	//var time = Math.round(+new Date()/1000);
	new Ajax.Request(reqUrl, { method:'post',
  		onSuccess: function(transport){
  			var json = transport.responseText.evalJSON();
			if(json.error){
				alert(json.error[0].message);
				return;
			}

			var conns = json.connectionset[0].connections;
			//alert("conns="+conns.length);

			if (conns.length == 0) {
				container.update("<?php echo $LNG->WIDGET_NONE_FOUND_PART1; ?> "+title+" <?php echo $LNG->WIDGET_NONE_FOUND_PART2; ?>");
			} else {
				var nodes = new Array();
				var nodeids = "";
				for(var i=0; i< conns.length; i++){
					var c = conns[i].connection;
					var fN = c.from[0].cnode;
					var tN = c.to[0].cnode;

					if (fN.nodeid != focalnodeid) {
						if (fN.name != "") {
							var next = c.from[0];
							if (next.cnode.status != 2) {
								next.cnode['connection'] = c;
								next.cnode['parentid'] = focalnodeid;
								next.cnode['handler'] = '';
								if (args['searchid'] && args['searchid'] != "") {
									next.cnode.searchid = args['searchid'];
								}
								if (args['groupid'] && args['groupid'] != "") {
									next.cnode.groupid = args['groupid'];
								} else {
									next.cnode.groupid = "";
								}

								nodes.push(next);
								nodeids  = nodeids+","+next.cnode.nodeid;
							}
						}
					} else if (tN.nodeid != focalnodeid) {
						if (tN.name != "") {
							var next = c.to[0];
							if (next.cnode.status != 2) {
								next.cnode['connection'] = c;
								next.cnode['parentid'] = focalnodeid;
								next.cnode['handler'] = '';
								if (args['searchid'] && args['searchid'] != "") {
									next.cnode.searchid = args['searchid'];
								}
								if (args['groupid'] && args['groupid'] != "") {
									next.cnode.groupid = args['groupid'];
								}
								nodes.push(next);
								nodeids  = nodeids+","+next.cnode.nodeid;
							}
						}
					}
				}
				if (nodes.length > 0) {
					if ($('remaining-count')) {
						$('remaining-count').update('('+nodes.length+')');
						$('removed-count').update('('+(parseInt(json.connectionset[0].totalno)-nodes.length)+')');
					}

					// Audit ideas viewed
					/*
					nodeids = nodeids.substr(1); // remove first comma
					var reqUrl = SERVICE_ROOT + "&method=auditnodeviewmulti&nodeids="+nodeids+"&viewtype=list";
					new Ajax.Request(reqUrl, { method:'post',
						onSuccess: function(transport){
							var json = transport.responseText.evalJSON();
							if(json.error){
								//alert(json.error[0].message);
							}
						}
					});
					*/

					// clear list
					container.update("");

					var tb3 = new Element("div", {'class':'toolbarrow'});
					//var sortOpts = {date: '<?php echo $LNG->SORT_CREATIONDATE; ?>', moddate: '<?php echo $LNG->SORT_MODDATE; ?>', random:'<?php echo $LNG->SORT_RANDOM; ?>'};
					var sortOpts = {date: '<?php echo $LNG->SORT_CREATIONDATE; ?>', fromname: '<?php echo $LNG->SORT_TITLE; ?>'};
					tb3.insert(displaySortForm(sortOpts,args,'solution',reorderSolutions));

					container.insert(tb3);

					displayIdeaList(container,nodes,parseInt(0), true, 'explore');

					// Set Idea count on Issue
					$('debatestatsideas'+focalnodeid).update(json.connectionset[0].totalno);
					if ($('debatestatsideasnow'+focalnodeid)) {
						$('debatestatsideasnow'+focalnodeid).update(nodes.length);
					}

				} else {
					container.update("<?php echo $LNG->WIDGET_NONE_FOUND_PART1; ?> "+title+" <?php echo $LNG->WIDGET_NONE_FOUND_PART2; ?>");
				}
			}
		}
	});

	DATA_LOADED.remaining = true;
}

/**
 *	load removed solutions
 */
function loadremovedsolutions(context,args){

	var container = $('tab-content-removed-div');
	container.update(getLoading("<?php echo $LNG->LOADING_SOLUTIONS; ?>"));

	var focalnodeid = args['nodeid'];
	var title = "<?php echo $LNG->SOLUTIONS_NAME; ?>";
	var reqUrl = SERVICE_ROOT + "&method=getdebateideaconnectionsremoved&style=long&issueid="+focalnodeid;

	//alert(reqUrl);
	new Ajax.Request(reqUrl, { method:'post',
  		onSuccess: function(transport){
  			var json = transport.responseText.evalJSON();
			if(json.error){
				alert(json.error[0].message);
				return;
			}

			var conns = json.connectionset[0].connections;
			//alert("conns="+conns.length);

			if (conns.length == 0) {
				container.update("<?php echo $LNG->WIDGET_NONE_FOUND_PART1; ?> "+title+" <?php echo $LNG->WIDGET_NONE_FOUND_PART2; ?>");
			} else {
				var nodes = new Array();
				var nodeids = "";
				for(var i=0; i< conns.length; i++){
					var c = conns[i].connection;
					var fN = c.from[0].cnode;
					var tN = c.to[0].cnode;
					if (fN.nodeid != focalnodeid) {
						if (fN.name != "") {
							var next = c.from[0];
							if (next.cnode.status != 2) {
								next.cnode['connection'] = c;
								next.cnode['parentid'] = focalnodeid;
								next.cnode['handler'] = '';
								if (args['searchid'] && args['searchid'] != "") {
									next.cnode.searchid = args['searchid'];
								}
								if (args['groupid'] && args['groupid'] != "") {
									next.cnode.groupid = args['groupid'];
								} else {
									next.cnode.groupid = "";
								}


								nodes.push(next);
								nodeids  = nodeids+","+next.cnode.nodeid;
							}
						}
					} else if (tN.nodeid != focalnodeid) {
						if (tN.name != "") {
							var next = c.to[0];
							if (next.cnode.status != 2) {
								next.cnode['connection'] = c;
								next.cnode['parentid'] = focalnodeid;
								next.cnode['handler'] = '';
								if (args['searchid'] && args['searchid'] != "") {
									next.cnode.searchid = args['searchid'];
								}
								if (args['groupid'] && args['groupid'] != "") {
									next.cnode.groupid = args['groupid'];
								}
								nodes.push(next);
								nodeids  = nodeids+","+next.cnode.nodeid;
							}
						}
					}
				}
				if (nodes.length > 0) {
					$('removed-count').update('('+nodes.length+')');

					// Audit ideas viewed
					/*
					nodeids = nodeids.substr(1); // remove first comma
					var reqUrl = SERVICE_ROOT + "&method=auditnodeviewmulti&nodeids="+nodeids+"&viewtype=list";
					new Ajax.Request(reqUrl, { method:'post',
						onSuccess: function(transport){
							var json = transport.responseText.evalJSON();
							if(json.error){
								//alert(json.error[0].message);
							}
						}
					});
					*/

					container.update("");
					displayRemovedIdeaList(container,nodes,parseInt(0), true, 'explore-removed');
				} else {
					container.update("<?php echo $LNG->WIDGET_NONE_FOUND_PART1; ?> "+title+" <?php echo $LNG->WIDGET_NONE_FOUND_PART2; ?>");
				}
			}
		}
	});

	DATA_LOADED.removed = true;
}

//(node, uniQ, 'argument', role.name, type, includeUser, status)

function editArgumentNode(node, uniQ, type, nodetype, actiontype, includeUser, status) {

	var nodeid = $('edit'+type+'id'+uniQ).value;
	var nodetypeid = $('edit'+type+'nodetypeid'+uniQ).value;
	var name = ($('edit'+type+'name'+uniQ).value).trim();
	var desc = $('edit'+type+'desc'+uniQ).value;

	// check form has title at least
	if(name == ""){
		if (nodetype == 'Con') {
	   		alert("<?php echo $LNG->FORM_CON_ENTER_SUMMARY_ERROR; ?>");
	   	} else {
	   		alert("<?php echo $LNG->FORM_PRO_ENTER_SUMMARY_ERROR; ?>");
	   	}
		return;
	} else {
	    $('editformdiv'+type+uniQ).style.cursor = 'wait';
		editExploreNode(node, nodeid, nodetypeid, name, desc, type, uniQ, actiontype, includeUser, status, nodetype);
	}
}

function editIdeaNode(orinode, uniQ, type, actiontype, includeUser, status) {

	var nodeid = $('edit'+type+'id'+uniQ).value;
	var nodetypeid = $('edit'+type+'nodetypeid'+uniQ).value;
	var name = ($('edit'+type+'name'+uniQ).value).trim();
	var desc = $('edit'+type+'desc'+uniQ).value;

	// check form has title at least
	if(name == ""){
		alert("<?php echo $LNG->FORM_SOLUTION_ENTER_SUMMARY_ERROR; ?>");
		return;
	} else {
	    $('editformdiv'+type+uniQ).style.cursor = 'wait';
		editExploreNode(orinode, nodeid, nodetypeid, name, desc, type, uniQ, actiontype, includeUser, status);
	}
}

function editExploreNode(orinode, nodeid, nodetypeid, name, desc, type, uniQ, actiontype, includeUser, status, nodetype) {

	var reqUrl = SERVICE_ROOT + "&method=editnode&nodeid=" + encodeURIComponent(nodeid);
	reqUrl += "&name="+ encodeURIComponent(name);
	reqUrl += "&desc="+ encodeURIComponent(desc);
	reqUrl += "&private="+orinode.private; //keep privacy - can't edit that in debate view.
	reqUrl += "&style=long";
	reqUrl += "&nodetypeid="+encodeURIComponent(nodetypeid);

	// Get the current list of urls/resources if any



	var resourceIDsArray = [];
	var resourceTypesArray = [];
	var resourceURLsArray = [];
	var resourceTitlesArray = [];
	var resourceDoisArray = [];

	var resourceNodeIDS = {};
	var newResources = [];

	if (nodetype) {
		const lowernodetype = nodetype.toLowerCase();

		resourceIDsArray = document.getElementsByName('resourcenodeidsarray'+'edit'+lowernodetype+uniQ+'[]');
		resourceTypesArray = document.getElementsByName('resourcetypesarray'+'edit'+lowernodetype+uniQ+'[]');
		resourceURLsArray = document.getElementsByName('resourceurlarray'+'edit'+lowernodetype+uniQ+'[]');
		resourceTitlesArray = document.getElementsByName('resourcetitlearray'+'edit'+lowernodetype+uniQ+'[]');
		resourceDoisArray = document.getElementsByName('identifierarray'+'edit'+lowernodetype+uniQ+'[]');

		/*
		console.log("HERE 1");
		console.log(resourceIDsArray);
		console.log(resourceTypesArray);
		console.log(resourceURLsArray);
		console.log(resourceTitlesArray);
		console.log(resourceDoisArray);
		console.log("HERE 1a");
		*/

		if (resourceURLsArray && resourceURLsArray.length > 0) {

			// Check any associated resource urls are valid else return an error.
			// also small amount of pre-processing for later.
			var count = resourceURLsArray.length;
			for(let i=0; i<count; i++) {
				let resourceurlelement = resourceURLsArray[i];
				let resourceidelement = resourceIDsArray[i];
				if (resourceurlelement) {
					const nodeid = resourceidelement.value;
					if (nodeid && nodeid != "") {
						resourceNodeIDS[nodeid] = i; // not a new resource
					} else {
						newResources.push(i); // a new resource
					}

					let url = resourceurlelement.value;
					if (url) {
						url = url.trim();
						if (url != "") {
							if (!isValidURI(url)) {
								alert("<?php echo $LNG->FORM_LINK_INVALID_PART1; ?>"+url+"<?php echo $LNG->FORM_LINK_INVALID_PART2; ?>");
								return;
							}
						}
					}
				}
			}
		}

		//console.log(resourceNodeIDS);
		//console.log(newResources);
		//console.log("HERE 1b");
	}

	// request the edit of the main node
	new Ajax.Request(reqUrl, { method:'post',
		onSuccess: async function(transport){
			//now refresh the page
			$('editformdiv'+type+uniQ).style.cursor = 'pointer';

			// get returned new node so I can get nodeid;
			var json = transport.responseText.evalJSON();
			if(json.error){
				alert(json.error[0].message);
				return;
			}
			var node = json.cnode[0];

			try {
				clearSelections();

				// FOR EVIDENCE NODES - PROCESS RESOURCES
				// check for changes on resources
				if (type == 'argument' && orinode.resourcenodes) {

					// See which of the current resources have been removed or have been edited
					for(let i=0; i < orinode.resourcenodes.length; i++){
						if(orinode.resourcenodes[i].urls
								&& orinode.resourcenodes[i].urls
								&& orinode.resourcenodes[i].urls.length > 0){

							// a resource node only has one url
							var nextResource = orinode.resourcenodes[i];
							var next = nextResource.urls[0];
							var urlid = next.url.urlid;
							var url = next.url.url;

							if (resourceNodeIDS.hasOwnProperty(nextResource.nodeid)) {

								//console.log("IN EDIT");

								// Check if an existing resource has been edited
								const num = resourceNodeIDS[nextResource.nodeid];

								const rtitle = resourceTitlesArray[num].value;
								const rtype = resourceTypesArray[num].value;
								const rurl = resourceURLsArray[num].value;
								const rdoi = resourceDoisArray[num].value;

								// Resource nodes have title in description and url in title
								if (nextResource.name != rurl || nextResource.description != rtitle
										|| nextResource.role[0].role.name != rtype || nextResource.urls[0].url.identifier != rdoi) {

									//console.log("Wanting to edit resource: "+nextResource.nodeid);

									await editResourceNode(orinode, nextResource.nodeid, rtype, rurl, rtitle, rurl, rdoi);
								}
							} else {
								//console.log("IN DELETE");

								// the resource needs to be removed from the node.
								// leave the resource node in case connected elsewhere? Evidence Hub has seperate resource node lists to handle deletion.
								// But will user be aware?
								//console.log("wanting to delete connection: "+orinode.resourcenodes[i].connid);

								await removeConnection(orinode.resourcenodes[i].connid);
							}
						}
					}

					// ADD NEW RESOURCES
					//So anything left in newResources needs to be added and connected
					for(let i=0; i < newResources.length; i++){
						let num = newResources[i];

						const rtitle = resourceTitlesArray[num].value;
						const rtype = resourceTypesArray[num].value;
						const rurl = resourceURLsArray[num].value;
						const rdoi = resourceDoisArray[num].value;

						try {
							let connection = await addResourceNode(orinode, rtype, '<?php echo $CFG->LINK_RESOURCE_NODE; ?>', rurl, rtitle, rdoi, status);
							if (connection !== null) {
								// do something?
								console.log(connection);
							}
						} catch(e) {
							console.log(e);
						}
					}
				}

				orinode.name = name; // update in case changed
				orinode.description = desc; // update in case changed

				$('edit'+type+'name'+uniQ).value = name; // update hidden edit form
				$('edit'+type+'desc'+uniQ).value = desc; // update hidden edit form
				$('editformdiv'+type+uniQ).style.display = "none"; // make sure form hidden

				if (type == 'idea') {
					var blobNode = renderIdeaList(orinode, uniQ, orinode.role[0].role, includeUser, actiontype, status);
					$('ideablobdiv'+uniQ).update(blobNode);
				} else if (type == 'argument') {
					NODE_ARGS['selectednodeid'] = orinode.nodeid;
					var blobNode = await renderArgumentNode(orinode, uniQ, orinode.role[0].role, includeUser, actiontype, status, nodetype);
					$('argumentblobdiv'+uniQ).update(blobNode);
				}
			} catch(err) {
				console.log(err);
				//do nothing
			}
   		},
   		onFailure: function(transport) {
   		    $('editformdiv'+type+uniQ).style.cursor = 'pointer';
   			alert("FAILED");
   		}
 	});
}

async function editResourceNode(parentnode, nodeid, nodetypename, title, desc, url, identifier) {

	return new Promise( ( resolve, reject ) => {

		var reqUrl = SERVICE_ROOT + "&method=editresource";
		reqUrl += "&nodeid="+ encodeURIComponent(nodeid);
		reqUrl += "&nodetypename="+ encodeURIComponent(nodetypename);
		reqUrl += "&title="+ encodeURIComponent(title);
		reqUrl += "&desc="+ encodeURIComponent(desc);
		reqUrl += "&url="+ encodeURIComponent(url);
		reqUrl += "&identifier="+ encodeURIComponent(identifier);
		reqUrl += "&private=N"; //Always public data in an evidence hub

		//console.log(reqUrl);

		new Ajax.Request(reqUrl, { method:'post',
			onSuccess: function(transport){
				var json = transport.responseText.evalJSON();
				if(json.error){
					alert(json.error[0].message);
					reject(null);
				}
				var refnode = json.cnode[0];
				resolve(refnode);
			},
			onFailure: function(response) {
				console.log(response);
				reject(null);
			}
		});
	});
}

async function addResourceNode(parentnode, nodetypename, linktypename, name, desc, identifier, status) {

	return new Promise( ( resolve, reject ) => {

		var reqUrl = SERVICE_ROOT + "&method=addnodeandconnect";
		reqUrl += "&name="+ encodeURIComponent(name);
		reqUrl += "&desc="+ encodeURIComponent(desc);
		reqUrl += "&nodetypename="+encodeURIComponent(nodetypename);
		reqUrl += "&linktypename="+encodeURIComponent(linktypename);
		reqUrl += "&private=N"; //Always public data in an evidence hub
		reqUrl += "&direction=from";
		if (parentnode && parentnode.nodeid != "") {
			reqUrl += "&focalnodeid="+parentnode.nodeid;
		} else {
			alert("Parent node id node found");
			return;
		}

		reqUrl += "&resourceurls[0]="+encodeURIComponent(name);
		reqUrl += "&resourcetypes[0]="+encodeURIComponent(nodetypename);
		reqUrl += "&resourcetitles[0]="+encodeURIComponent(desc);
		reqUrl += "&resourcedois[0]="+encodeURIComponent(identifier);

		//console.log(reqUrl);

		new Ajax.Request(reqUrl, { method:'post',
			onSuccess: function(transport){
				var json = transport.responseText.evalJSON();
				if(json.error){
					alert(json.error[0].message);
					reject(null);
				}
				var connection = json.connection[0];
				resolve(connection);
			},
			onFailure: function(response) {
				console.log(response);
				reject(null);
			}
		});
	});
}

/**
 * remove the given connection
 */
async function removeConnection(connid){

	return new Promise( ( resolve, reject ) => {

		var reqUrl = SERVICE_ROOT + "&method=deleteconnection&connid="+connid;
		//console.log(reqUrl);

		new Ajax.Request(reqUrl, { method:'post',
			onSuccess: function(transport){
				var json = transport.responseText.evalJSON();
				if(json.error){
					alert(json.error[0].message);
					reject();
				}
				//new Result("deleted","true")
				//if (json.result)
					resolve();
				//}
			},
			onFailure: function(response) {
				console.log(response);
			 	reject();
			}
		});
	});
}

function addArgumentNode(parentnode, uniQ, type, nodetypename, actiontype, includeUser, status) {

	var name = ($('add'+type+'name'+uniQ).value).trim();
	var desc = $('add'+type+'desc'+uniQ).value;
	var linktypename = '<?php echo $CFG->LINK_EVIDENCE_SOLCLAIM_PRO; ?>';
	if (type == 'con') {
		linktypename = '<?php echo $CFG->LINK_EVIDENCE_SOLCLAIM_CON; ?>';
	}

	// check form has title at least
	if(name == ""){
		if (type == 'con') {
	   		alert("<?php echo $LNG->FORM_CON_ENTER_SUMMARY_ERROR; ?>");
	   	} else {
	   		alert("<?php echo $LNG->FORM_PRO_ENTER_SUMMARY_ERROR; ?>");
	   	}
		return;
	} else {
	    $('addformdiv'+type+uniQ).style.cursor = 'wait';
		addExploreNode(parentnode, nodetypename, linktypename, name, desc, type, uniQ, actiontype, includeUser, status);
	}
}

function addIdeaNode(parentnode, uniQ, type, actiontype, includeUser, status) {

	var name = ($('add'+type+'name'+uniQ).value).trim();
	var desc = $('add'+type+'desc'+uniQ).value;

	var nodetypename = 'Solution';
	var linktypename = '<?php echo $CFG->LINK_SOLUTION_ISSUE; ?>';

	// check form has title at least
	if(name == ""){
		alert("<?php echo $LNG->FORM_SOLUTION_ENTER_SUMMARY_ERROR; ?>");
		return;
	} else {
	    $('addformdiv'+type+uniQ).style.cursor = 'wait';
		addExploreNode(parentnode, nodetypename, linktypename, name, desc, type, uniQ, actiontype, includeUser, status);
	}
}

function addExploreNode(parentnode, nodetypename, linktypename, name, desc, type, uniQ, actiontype, includeUser, status) {

	var reqUrl = SERVICE_ROOT + "&method=addnodeandconnect";
	reqUrl += "&name="+ encodeURIComponent(name);
	reqUrl += "&desc="+ encodeURIComponent(desc);
	reqUrl += "&nodetypename="+encodeURIComponent(nodetypename);
	reqUrl += "&linktypename="+encodeURIComponent(linktypename);
	reqUrl += "&private="+parentnode.private; // inherit privacy from parent node.
	reqUrl += "&direction=from";
	if (parentnode && parentnode.nodeid != "") {
		reqUrl += "&focalnodeid="+parentnode.nodeid;
	} else {
		alert("Parent node id node found");
		return;
	}
	if (NODE_ARGS['groupid'] && NODE_ARGS['groupid'] != "") {
		reqUrl += "&groupid="+NODE_ARGS['groupid'];
	}

	//console.log(reqUrl);

	//does it have any resources?
	var resourceTypesArray = document.getElementsByName('resourcetypesarray'+type+uniQ+'[]');
	var resourceURLsArray = document.getElementsByName('resourceurlarray'+type+uniQ+'[]');
	var resourceTitlesArray = document.getElementsByName('resourcetitlearray'+type+uniQ+'[]');
	var resourceDoisArray = document.getElementsByName('identifierarray'+type+uniQ+'[]');

	var count = resourceURLsArray.length;

	var j=0;
	for(var i=0; i<count; i++) {
		var resource = resourceURLsArray[i];
		if (resource) {
			var url = resource.value;
			if (url) {
				url = url.trim();
				if (url != "") {
					if (isValidURI(url)) {

						reqUrl += "&resourceurls["+j+"]="+encodeURIComponent(url);

						let resourcetype = "<?php echo $CFG->RESOURCE_TYPES_DEFAULT; ?>";
						if (typeof(resourceTypesArray[i]) != "undefined") {
							resourcetype = resourceTypesArray[i].value;
						}
						reqUrl += "&resourcetypes["+j+"]="+encodeURIComponent(resourcetype);

						let resourcetitle = "";
						if (typeof(resourceTitlesArray[i]) != "undefined") {
							resourcetitle = resourceTitlesArray[i].value;
						} else {
							resourcetitle = url;
						}
						reqUrl += "&resourcetitles["+j+"]="+encodeURIComponent(resourcetitle);

						let resourcedoi = "";
						if (typeof(resourceDoisArray[i]) != "undefined") {
							resourcedoi = resourceDoisArray[i].value;
						}
						reqUrl += "&resourcedois["+j+"]="+encodeURIComponent(resourcedoi);
						j++;
					} else {
						alert("<?php echo $LNG->FORM_LINK_INVALID_PART1; ?>"+url+"<?php echo $LNG->FORM_LINK_INVALID_PART2; ?>");
						return;
					}
				}
			}
		}
	}

	//console.log(reqUrl);

	new Ajax.Request(reqUrl, { method:'post',
		onSuccess: function(transport){

			$('addformdiv'+type+uniQ).style.cursor = 'pointer';
			var json = transport.responseText.evalJSON();
			if(json.error){
				alert(json.error[0].message);
				return;
			}
			var connection = json.connection[0];

			// if they add an idea/pro/con, make sure they follow the issue
			if (nodeObj && nodeObj.role
					&& nodeObj.role.name && nodeObj.role.name == 'Issue'
						&& !nodeObj.userfollow || nodeObj.userfollow == "N") {

				followNode(nodeObj, null, 'refreshMainIssue');
			}

			// Add Resources

			// change the sort if idea added
			if (type == 'idea') {
				NODE_ARGS['orderby'] = 'date';
				NODE_ARGS['sort'] = 'DESC';
			}

			try {
				clearSelections();

				var fromnode = connection.from[0].cnode;
				fromnode['connection'] = connection;
				fromnode['parentid'] = parentnode.nodeid;
				fromnode['handler'] = '';

				if (NODE_ARGS['searchid'] && NODE_ARGS['searchid'] != "") {
					fromnode.searchid = NODE_ARGS['searchid'];
				}
				if (NODE_ARGS['groupid'] && NODE_ARGS['groupid'] != "") {
					fromnode.groupid = NODE_ARGS['groupid'];
				}

				NODE_ARGS['selectednodeid'] = fromnode.nodeid;

				// clear form
				$('add'+type+'name'+uniQ).value = "";
				$('add'+type+'desc'+uniQ).value = "";

				//clear the resources
				for(var k=0; k<count; k++) {
					$('resourcetitle-'+type+uniQ+k).value = "";
					$('resourceurl-'+type+uniQ+k).value = "";
					$('identifier-'+type+uniQ+k).value = "";
					$('resource'+type+uniQ+k+'menu').value = "<?php echo $CFG->RESOURCE_TYPES_DEFAULT; ?>";
					$('identifierdiv-'+type+uniQ+k).style.display = "none";
					if (k > 0) {
						$('resourceform'+type+uniQ).removeChild($('resourcefield'+type+uniQ+k));
					}
				}

				if (type == 'idea') {
					//$('newideaform').style.display = "none";
					refreshSolutions();
				} else if (type == 'con') {
					$('counterkidsdiv'+uniQ).loaded = 'false';

					loadChildArguments('counterkidsdiv'+uniQ, parentnode.nodeid, '<?php echo $LNG->CONS_NAME; ?>', linktypename, "Con", parentnode.parentid, uniQ, 'count-counter', actiontype, status, $('votebardiv'+uniQ));
					//recalculatePeople();
				} else if (type == 'pro') {
					$('supportkidsdiv'+uniQ).loaded = 'false';
					loadChildArguments('supportkidsdiv'+uniQ, parentnode.nodeid, '<?php echo $LNG->PROS_NAME; ?>', linktypename, "Pro", parentnode.parentid, uniQ, 'count-support', actiontype, status, $('votebardiv'+uniQ));
					//recalculatePeople();
				}

				if ($('health-debate')) {
					loadContributionStats();
				}

			} catch(err) {
				//do nothing
			}
   		},
   		onFailure: function(transport) {
   		    $('editformdiv'+type+uniQ).style.cursor = 'pointer';
   			alert("FAILED");
   		}
 	});
}

function clearSelections() {
	var items = document.getElementsByName('idearowitem');
	var count = items.length;
	for (var i=0; i<count; i++) {
		var item = items[i];
		item.className = "";
		item.style.background = "transparent";
	}
	items = document.getElementsByName('argumentrowitem');
	count = items.length;
	for (var i=0; i<count; i++) {
		var item = items[i];
		item.className = "";
		item.style.background = "transparent";
	}
}

/**
 *	Reorder the solutions tab
 */
function reorderSolutions(){
	// change the sort and orderby ARG values
	NODE_ARGS['start'] = 0;
	NODE_ARGS['sort'] = $('select-sort-solution').options[$('select-sort-solution').selectedIndex].value;
	NODE_ARGS['orderby'] = $('select-orderby-solution').options[$('select-orderby-solution').selectedIndex].value;

	loadsolutions(CONTEXT,NODE_ARGS);
}


/**
 *	Reorder the solutions tab
 */
function reorderRemovedSolutions(){
	// change the sort and orderby ARG values
	NODE_ARGS['start'] = 0;
	NODE_ARGS['sort'] = $('select-sort-removed').options[$('select-sort-removed').selectedIndex].value;
	NODE_ARGS['orderby'] = $('select-orderby-removed').options[$('select-orderby-removed').selectedIndex].value;
	DATA_LOADED.removed = false;

	loadremovedsolutions(CONTEXT,NODE_ARGS);
}

/**
 *	Filter the solutions by search criteria
 */
function filterSearchSolutions() {
	NODE_ARGS['q'] = $('qsolution').value;
	var scope = 'all';
	if ($('scopesolutionmy') && $('scopesolutionmy').selected) {
		scope = 'my';
	}
	NODE_ARGS['scope'] = scope;

	/*
	if (USER != "") {
		var reqUrl = SERVICE_ROOT + "&method=auditsearch&type=solution&format=text&q="+NODE_ARGS['q'];
		new Ajax.Request(reqUrl, { method:'get',
			onError: function(error) {
				alert(error);
			},
	  		onSuccess: function(transport){
				var searchid = transport.responseText;
				if (searchid != "") {
					NODE_ARGS['searchid'] = searchid;
				}
				DATA_LOADED.solution = false;
				setTabPushed($('tab-solution-list-obj'),'solution-list');
			}
		});
	} else {
	*/
		DATA_LOADED.solution = false;
		setTabPushed($('tab-solution-list-obj'),'solution-list');
	//}
}

/**
 * Sort by node type in reverse alphabetical order by connections node type.
 */
function connectiontypenodesort(a, b) {
	var typeA = a.cnode.role[0].role.name.toLowerCase();
	var connA = a.cnode.connection;
	if (connA) {
		if (a.cnode.nodeid == connA.from[0].cnode.nodeid) {
			typeA = connA.fromrole[0].role.name.toLowerCase();
		} else {
			typeA = connA.torole[0].role.name.toLowerCase();
		}
	}
	var typeB = b.cnode.role[0].role.name.toLowerCase();
	var connB = b.cnode.connection;
	if (connB) {
		if (b.cnode.nodeid == connB.from[0].cnode.nodeid) {
			typeB = connB.fromrole[0].role.name.toLowerCase();
		} else {
			typeB = connB.torole[0].role.name.toLowerCase();
		}
	}
	if (typeA > typeB) {
		return -1;
	}
	if (typeA < typeB) {
		return 1;
	}
	return 0;
}

/**
 * Sort by node name after a sort by connection node type has been done.
 * @see connectiontypenodesort
 */
function connectiontypealphanodesort(a, b) {
	var nameA=a.cnode.name.toLowerCase();
	var nameB=b.cnode.name.toLowerCase();

	var typeA = a.cnode.role[0].role.name.toLowerCase();
	var connA = a.cnode.connection;
	if (connA) {
		if (a.cnode.nodeid == connA.from[0].cnode.nodeid) {
			typeA = connA.fromrole[0].role.name.toLowerCase();
		} else {
			typeA = connA.torole[0].role.name.toLowerCase();
		}
	}
	var typeB = b.cnode.role[0].role.name.toLowerCase();
	var connB = b.cnode.connection;
	if (connB) {
		if (b.cnode.nodeid == connB.from[0].cnode.nodeid) {
			typeB = connB.fromrole[0].role.name.toLowerCase();
		} else {
			typeB = connB.torole[0].role.name.toLowerCase();
		}
	}

	if (typeA == typeB) {
		if (nameA < nameB) {
			return -1;
		} else if (nameA > nameB) {
			return 1;
		}
	}
	return 0;
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
			prevSpan.update("<img title='<?php echo $LNG->LIST_NAV_PREVIOUS_HINT; ?>' src='<?php echo $HUB_FLM->getImagePath("arrow-left2.png"); ?>' class='toolbar' style='padding-right: 0px;' />");
	        prevSpan.addClassName("active");
	        Event.observe(prevSpan,"click", function(){
	            var newArr = argArray;
	            newArr["start"] = parseInt(start) - newArr["max"];
	            eval("load"+type+"(context,newArr)");
	        });
	    } else {
			prevSpan.update("<img title='<?php echo $LNG->LIST_NAV_NO_PREVIOUS_HINT; ?>' disabled src='<?php echo $HUB_FLM->getImagePath("arrow-left2-disabled.png"); ?>' class='toolbar' style='padding-right: 0px;' />");
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
		    nextSpan.update("<img title='<?php echo $LNG->LIST_NAV_NEXT_HINT; ?>' src='<?php echo $HUB_FLM->getImagePath('arrow-right2.png'); ?>' class='toolbar' style='padding-right: 0px;' />");
	        nextSpan.addClassName("active");
	        Event.observe(nextSpan,"click", function(){
	            var newArr = argArray;
	            newArr["start"] = parseInt(start) + parseInt(newArr["max"]);
	            eval("load"+type+"(context, newArr)");
	        });
	    } else {
		    nextSpan.update("<img title='<?php echo $LNG->LIST_NAV_NO_NEXT_HINT; ?>' src='<?php echo $HUB_FLM->getImagePath('arrow-right2-disabled.png'); ?>' class='toolbar' style='padding-right: 0px;' />");
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
     	objH.insert("<p><b><?php echo $LNG->LIST_NAV_NO_SOLUTION; ?></b></p>");
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
 *	Reorder the solutions list
 */
function reorderSolutions(){
 	// change the sort and orderby ARG values
 	NODE_ARGS['start'] = 0;
 	NODE_ARGS['sort'] = $('select-sort-solution').options[$('select-sort-solution').selectedIndex].value;
 	NODE_ARGS['orderby'] = $('select-orderby-solution').options[$('select-orderby-solution').selectedIndex].value;

	loadsolutions(CONTEXT,NODE_ARGS);
}

/**
 * show the sort form
 */
function displaySortForm(sortOpts,args,tab,handler){

	var sbTool = new Element("span", {'class':'sortback toolbar2'});
    sbTool.insert("<?php echo $LNG->SORT_BY; ?> ");

    var selOrd = new Element("select");
 	Event.observe(selOrd,'change',handler);
    selOrd.id = "select-orderby-"+tab;
    selOrd.className = "toolbar";
    selOrd.name = "orderby";
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
    sortBy.className = "toolbar";
    sortBy.name = "sort";
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