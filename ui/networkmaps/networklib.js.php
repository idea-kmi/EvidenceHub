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

    include_once("../../config.php");
?>

var SELECTED_GRAPH_NODE = "";

function createSocialNetworkGraphKey() {
	var tb1 = new Element("div", {'id':'graphkeydivtoolbar','class':'toolbarrow col-12'});

	var key = new Element("div", {'id':'key','class':'row mb-3'});
	var text = "";
	text += '<div class="col-auto"><span class="networkmaps-key key-social-most"><?php echo $LNG->NETWORKMAPS_KEY_SOCIAL_MOST; ?></span></div>';
	text += '<div class="col-auto"><span class="networkmaps-key key-social-high"><?php echo $LNG->NETWORKMAPS_KEY_SOCIAL_HIGHLY; ?></span></div>';
	text += '<div class="col-auto"><span class="networkmaps-key key-social-moderate"><?php echo $LNG->NETWORKMAPS_KEY_SOCIAL_MODERATELY; ?></span></div>';
	text += '<div class="col-auto"><span class="networkmaps-key key-social-slight"><?php echo $LNG->NETWORKMAPS_KEY_SOCIAL_SLIGHTLY; ?></span></div>';
	text += '<div class="col-auto"><span class="networkmaps-key key-social-selected"><?php echo $LNG->NETWORKMAPS_KEY_SELECTED_ITEM; ?></span></div>';

	key.insert(text);

	var count = new Element("div", {'id':'graphConnectionCount','class':'col-auto'});
	key.insert(count);
	tb1.insert(key);

	return tb1;
}

/**
 * Create the key for the graph node types etc...
 * @return a div holding the graph key.
 */
function createNetworkGraphKey() {
	var tb1 = new Element("div", {'id':'graphkeydivtoolbar','class':'toolbarrow col-12'});

	var key = new Element("div", {'id':'key','class':'row mb-3'});
	var text = "";
	if (hasChallenge) {
		text += '<div class="col-auto"><span class="networkmaps-key" style="background: '+challengebackpale+';"><?php echo $LNG->CHALLENGE_NAME_SHORT; ?></span></div>';
	}
	text+= '<div class="col-auto"><span class="networkmaps-key" style="background:'+issuebackpale+';"><?php echo $LNG->ISSUE_NAME_SHORT; ?></span></div>';
	if (hasClaim){
		text += '<div class="col-auto"><span class="networkmaps-key" style="background: '+claimbackpale+';"><?php echo $LNG->CLAIM_NAME_SHORT; ?></span></div>';
	}
	if (hasSolution) {
		text += '<div class="col-auto"><span class="networkmaps-key" style="background: '+solutionbackpale+';"><?php echo $LNG->SOLUTION_NAME_SHORT; ?></span></div>';
	}

	text += '<div class="col-auto"><span class="networkmaps-key" style="background: '+evidencebackpale+';"><?php echo $LNG->EVIDENCE_NAME_SHORT; ?></span></div>';
	text += '<div class="col-auto"><span class="networkmaps-key" style="background:'+resourcebackpale+';"><?php echo $LNG->RESOURCE_NAME_SHORT; ?></span></div>';
	text += '<div class="col-auto"><span class="networkmaps-key" style="border: 3px solid yellow;"><?php echo $LNG->NETWORKMAPS_KEY_SELECTED_ITEM; ?></span></div>';
	text += '<div class="col-auto"><span class="networkmaps-key" style="border: 3px solid #606060;"><?php echo $LNG->NETWORKMAPS_KEY_FOCAL_ITEM; ?></span></div>';

	key.insert(text);

	var count = new Element("div", {'id':'graphConnectionCount','class':'col-auto'});
	key.insert(count);
	tb1.insert(key);

	return tb1;
}

/**
 * Create the key for the graph node types etc...
 * @return a div holding the graph key.
 */
function createNetworkOrgGraphKey() {
	var tb1 = new Element("div", {'id':'graphkeydivtoolbar','class':'toolbarrow'});

	var key = new Element("div", {'id':'key','class':'row mb-3'});
	var text = "";
	if (hasChallenge) {
		text += '<div class="col-auto"><span style="background: '+challengebackpale+';"><?php echo $LNG->CHALLENGE_NAME_SHORT; ?></span></div>';
	}
	text+= '<div class="col-auto"><span style="background:'+issuebackpale+';"><?php echo $LNG->ISSUE_NAME_SHORT; ?></span></div>';
	if (hasClaim){
		text += '<div class="col-auto"><span style="background: '+claimbackpale+';"><?php echo $LNG->CLAIM_NAME_SHORT; ?></span></div>';
	}
	if (hasSolution) {
		text += '<div class="col-auto"><span style="background: '+solutionbackpale+';"><?php echo $LNG->SOLUTION_NAME_SHORT; ?></span></div>';
	}

	text += '<div class="col-auto"><span style="background: '+evidencebackpale+';"><?php echo $LNG->EVIDENCE_NAME_SHORT; ?></span></div>';
	text += '<div class="col-auto"><span style="background:'+resourcebackpale+';"><?php echo $LNG->RESOURCE_NAME_SHORT; ?></span></div>';
	text += '<div class="col-auto"><span style="background:'+orgbackpale+';"><?php echo $LNG->ORG_NAME; ?></span></div>';
	text += '<div class="col-auto"><span style="background:'+projectbackpale+';"><?php echo $LNG->PROJECT_NAME; ?></span></div>';
	text += '<div class="col-auto"><span style="border: 3px solid yellow;"><?php echo $LNG->NETWORKMAPS_KEY_SELECTED_ITEM; ?></span></div>';
	text += '<div style="float:left;"><span style="border: 3px solid #606060;"><?php echo $LNG->NETWORKMAPS_KEY_FOCAL_ITEM; ?></span></div>';

	key.insert(text);
	tb1.insert(key);

	var count = new Element("div", {'id':'graphConnectionCount','class':'col-auto'});
	tb1.insert(count);

	return tb1;
}

/**
 * Create the basic graph toolbar for all network graphs
 */
function createBasicGraphToolbar(forcedirectedGraph, contentarea) {

	var tb2 = new Element("div", {'id':'graphmaintoolbar','class':'graphmaintoolbar toolbarrow col-12'});

	var button = new Element("button", {'id':'expandbutton','title':'<?php echo $LNG->NETWORKMAPS_RESIZE_MAP_HINT; ?>', "class":"d-none"});
	var icon = new Element("img", {'id':'expandicon', 'src':"<?php echo $HUB_FLM->getImagePath('enlarge2.gif'); ?>", 'title':'<?php echo $LNG->NETWORKMAPS_RESIZE_MAP_HINT; ?>'});
	button.insert(icon);
	tb2.insert(button);

	var link = new Element("a", {'id':'expandlink', 'title':'<?php echo $LNG->NETWORKMAPS_RESIZE_MAP_HINT; ?>', "class":"col-auto map-btn"});
	link.insert('<span id="linkbuttonsvn"><i class="fas fa-expand-alt fa-lg" aria-hidden="true"></i> <?php echo $LNG->NETWORKMAPS_ENLARGE_MAP_LINK; ?></span>');

	var handler = function() {
		if ($('header').style.display == "none") {
			$('linkbuttonsvn').update('<i class="fas fa-expand-alt fa-lg" aria-hidden="true"></i> <?php echo $LNG->NETWORKMAPS_ENLARGE_MAP_LINK; ?>');
			reduceMap(contentarea, forcedirectedGraph);
		} else {
			$('linkbuttonsvn').update('<i class="fas fa-compress-alt fa-lg" aria-hidden="true"></i> <?php echo $LNG->NETWORKMAPS_REDUCE_MAP_LINK; ?>');
			enlargeMap(contentarea, forcedirectedGraph);
		}
	};
	Event.observe(link,"click", handler);
	Event.observe(button,"click", handler);
	tb2.insert(link);

	var zoomOut = new Element("button", {'class':'btn btn-link', 'title':'<?php echo $LNG->GRAPH_ZOOM_OUT_HINT;?>'});
	zoomOut.insert('<span><i class="fas fa-search-minus fa-lg" aria-hidden="true"></i> <?php echo $LNG->GRAPH_ZOOM_OUT_HINT; ?></span>');


	var zoomOuthandler = function() {
		zoomFD(forcedirectedGraph, 5.0);
	};
	Event.observe(zoomOut,"click", zoomOuthandler);
	tb2.insert(zoomOut);

	var zoomIn = new Element("button", {'class':'btn btn-link', 'title':'<?php echo $LNG->GRAPH_ZOOM_IN_HINT;?>'});
	zoomIn.insert('<span><i class="fas fa-search-plus fa-lg" aria-hidden="true"></i> <?php echo $LNG->GRAPH_ZOOM_IN_HINT; ?></span>');
	var zoomInhandler = function() {
		zoomFD(forcedirectedGraph, -5.0);
	};
	Event.observe(zoomIn,"click", zoomInhandler);
	tb2.insert(zoomIn);

	var zoom1to1 = new Element("button", {'class':'btn btn-link', 'title':'<?php echo $LNG->GRAPH_ZOOM_ONE_TO_ONE_HINT;?>'});
	zoom1to1.insert('<span><i class="fas fa-search fa-lg" aria-hidden="true"></i> 1:1 focus</span>');

	var zoom1to1handler = function() {
		zoomFDFull(forcedirectedGraph);
	};
	Event.observe(zoom1to1,"click", zoom1to1handler);
	tb2.insert(zoom1to1);

	var zoomFit = new Element("button", {'class':'btn btn-link', 'title':'<?php echo $LNG->GRAPH_ZOOM_FIT_HINT;?>'});
	zoomFit.insert('<span><i class="fas fa-expand fa-lg" aria-hidden="true"></i> Fit all</span>');

	var zoomFithandler = function() {
		zoomFDFit(forcedirectedGraph);
	};
	Event.observe(zoomFit,"click", zoomFithandler);
	tb2.insert(zoomFit);

	var printButton = new Element("button", {'class':'btn btn-link', 'title':'<?php echo $LNG->GRAPH_PRINT_HINT;?>'});
	printButton.insert('<span><i class="fas fa-print fa-lg" aria-hidden="true"></i> <?php echo $LNG->GRAPH_PRINT_HINT; ?></span>');
	var printButtonhandler = function() {
		printCanvas(forcedirectedGraph);
	};
	Event.observe(printButton,"click", printButtonhandler);
	tb2.insert(printButton);

	return tb2;
}

/**
 * Create the graph toolbar for Social network graphs
 */
function createSocialGraphToolbar(forcedirectedGraph,contentarea) {

	var tb2 = createBasicGraphToolbar(forcedirectedGraph,contentarea);

	var button3 = new Element("button", {'id':'viewdetailbutton','class':'d-none','title':'<?php echo $LNG->NETWORKMAPS_SOCIAL_ITEM_HINT; ?>'});
	tb2.insert(button3);

	var view3 = new Element("a", {'id':'viewdetaillink', "class":"map-btn", 'title':"<?php echo $LNG->NETWORKMAPS_SOCIAL_ITEM_HINT; ?>"});
	view3.insert('<span id="viewbuttons"><i class="fas fa-user fa-lg" aria-hidden="true"></i> <?php echo $LNG->NETWORKMAPS_SOCIAL_ITEM_LINK; ?></span>');
	var handler3 = function() {
		var node = getSelectFDNode(forcedirectedGraph);
		if (node != null && node != "") {
			var userid = node.getData('oriuser').userid;
			if (userid != "") {
				viewUserHome(userid);
			} else {
				alert("<?php echo $LNG->NETWORKMAPS_SELECTED_NODEID_ERROR; ?>");
			}
		}
	};
	Event.observe(button3,"click", handler3);
	Event.observe(view3,"click", handler3);
	tb2.insert(view3);

	var hint2 = "<?php echo $LNG->NETWORKMAPS_SOCIAL_CONNECTION_HINT; ?>";
	var link2 = "<?php echo $LNG->NETWORKMAPS_SOCIAL_CONNECTION_LINK; ?>";

	var button2 = new Element("button", {'id':'viewdetailbutton',"class":"d-none",'title':hint2});
	tb2.insert(button2);

	// console.log(hint);
	var view = new Element("a", {'id':'viewdetaillink', "class":"map-btn", 'title': hint2});

	var spancontent = "";
	view.insert("<span id=\"viewbuttons\"><i class=\"fas fa-link fa-lg\" aria-hidden=\"true\"></i> "+link2+"</span>");
	var handler2 = function() {
		var adj = getSelectFDLink(forcedirectedGraph);
		var connectionids = adj.getData('connections');
		if (connectionids != "") {
			showMultiConnections(connectionids);
		} else {
			alert("<?php echo $LNG->NETWORKMAPS_SELECTED_NODEID_ERROR; ?>");
		}
	};
	Event.observe(button2,"click", handler2);
	Event.observe(view,"click", handler2);
	tb2.insert(view);

	return tb2;
}

/**
 * Create the graph toolbar for Node network graphs
 */
function createGraphToolbar(forcedirectedGraph,contentarea) {

	var tb2 = createBasicGraphToolbar(forcedirectedGraph,contentarea);

	var hint2 = "<?php echo $LNG->NETWORKMAPS_EXPLORE_ITEM_HINT; ?>";
	var link2 = "<?php echo $LNG->NETWORKMAPS_EXPLORE_ITEM_LINK; ?>";

	var button2 = new Element("button", {'id':'viewdetailbutton','class':'btn btn-link','title':hint2});
	button2.insert("<span id=\"viewdetailicon\"><i class=\"far fa-lightbulb fa-lg\" aria-hidden=\"true\"></i> <span id=\"viewdetaillink\">"+link2+"</span></span>");
	tb2.insert(button2);

	var handler2 = function() {
		var node = getSelectFDNode(forcedirectedGraph);
		if (node != null && node != "") {
			var nodeid = node.id;
			var nodetype = node.getData('nodetype');
			var width = getWindowWidth();
			var height = getWindowHeight()-20;
			viewNodeDetails(nodeid, nodetype, width, height);
		} else {
			alert("<?php echo $LNG->NETWORKMAPS_SELECTED_NODEID_ERROR; ?>");
		}
	};
	Event.observe(button2,"click", handler2);

	var hint3 = "<?php echo $LNG->NETWORKMAPS_EXPLORE_AUTHOR_HINT; ?>";
	var link3 = "<?php echo $LNG->NETWORKMAPS_EXPLORE_AUTHOR_LINK; ?>";

	var button3 = new Element("button", {'id':'viewdetailbutton','class':'btn btn-link','title':hint3});
	button3.insert("<span id=\"viewdetailicon\"><i class=\"fas fa-user fa-lg\" aria-hidden=\"true\"></i> <span id=\"viewdetaillink\">"+link3+"</span></span>");
	tb2.insert(button3);

	var handler3 = function() {
		var node = getSelectFDNode(forcedirectedGraph);
		if (node != null && node != "") {
			var userid = node.getData('oriuser').userid;
			if (userid != "") {
				viewUserHome(userid);
			} else {
				alert("<?php echo $LNG->NETWORKMAPS_SELECTED_NODEID_ERROR; ?>");
			}
		}
	};
	Event.observe(button3,"click", handler3);

	return tb2;
}

/**
 * Calulate the width and height of the visible graph area
 * depending if it is reduced or enlarged at present.
 */
function resizeFDGraph(graphview, contentarea, withInner){
	if ($('header')&& $('header').style.display == "none") {
		var width = $(contentarea).offsetWidth - 35;
		var height = getWindowHeight();
		//alert(height);

		if ($('graphkeydivtoolbar')) {
			height -= $('graphkeydivtoolbar').offsetHeight;
		}
		if ($('graphmaintoolbar')) {
			height -= $('graphmaintoolbar').offsetHeight;
		}
		//if ($('nodearealineartitle')) {
		//	height -= $('nodearealineartitle').offsetHeight;
		//}
		height -= 20;

		//alert(height);

		$(graphview.config.injectInto+'-outer').style.width = width+"px";
		$(graphview.config.injectInto+'-outer').style.height = height+"px";

		//if (withInner) {
			resizeFDGraphCanvas(graphview, width, height);
		//}
	} else {
		var size = calulateInitialGraphViewport(contentarea)
		$(graphview.config.injectInto+'-outer').style.width = size.width+"px";
		$(graphview.config.injectInto+'-outer').style.height = size.height+"px";

		//if (withInner) {
			resizeFDGraphCanvas(graphview, width, height);
		//}
	}

	// GRAB FOCUS
	graphview.canvas.getPos(true);
}


function calulateInitialGraphViewport(areaname) {
	var w = $(areaname).offsetWidth - 30;
	var h = getWindowHeight();
	//alert(h);

	if ($('header')) {
		h -= $('header').offsetHeight;
	}

	// The explore views toolbar
	if ($('nodearealineartitle')) {
		h -= $('nodearealineartitle').offsetHeight;
	}
	if ($('headertoolbar')) {
		h -= $('headertoolbar').offsetHeight;
		h -= 30;
	}

	if ($('graphkeydivtoolbar')) {
		h -= $('graphkeydivtoolbar').offsetHeight;
	}
	if ($('graphmaintoolbar')) {
		h -= $('graphmaintoolbar').offsetHeight;
	}

	// Main social Network
	if ($('tabs')) { // +user social uses this
		h -= $('tabs').offsetHeight;
	}
	if ($('tab-content-user-title')) {
		h -= $('tab-content-user-title').offsetHeight;
		h -= 35;
	}
	if ($('tab-content-user-search')) {
		h -= $('tab-content-user-search').offsetHeight;
	}
	if ($('usertabs')) {
		h -= $('usertabs').offsetHeight;
	}

	// User social network
	if ($('context')) {
		h -= $('context').offsetHeight;
	}
	if ($('tab-content-user-bar')) {
		h -= $('tab-content-user-bar').offsetHeight;
		h -= 20;
	}

	//alert(h);
	return {width:w, height:h};
}

/**
 * Called to set the screen to standard view
 */
function reduceMap(contentarea, forcedirectedGraph) {

	if ($('header')) {
		$('header').style.display="flex";
	}

	// The explore views toolbar
	if ($('headertoolbar')) {
		$('headertoolbar').style.display="flex";
	}
	if ($('nodearealineartitle')) {
		$('nodearealineartitle').style.display="flex";
	}

	// Main social Network
	if ($('tabs')) { // +user social uses this
		$('tabs').style.display="flex";
	}
	if ($('tab-content-user-title')) {
		$('tab-content-user-title').style.display="flex";
	}
	if ($('tab-content-user-search')) {
		$('tab-content-user-search').style.display="flex";
	}
	if ($('usertabs')) {
		$('usertabs').style.display="flex";
	}

	// User social network
	if ($('context')) {
		$('context').style.display="flex";
	}
	if ($('tab-content-user-bar')) {
		$('tab-content-user-bar').style.display="flex";
	}

	resizeFDGraph(forcedirectedGraph, contentarea, true);
}

/**
 * Called to remove some screen realestate to increase map area.
 */
function enlargeMap(contentarea, forcedirectedGraph) {

	if ($('header')) {
		$('header').style.display="none";
	}

	// The explore views toolbar
	if ($('headertoolbar')) {
		$('headertoolbar').style.display="none";
	}
	if ($('nodearealineartitle')) {
		$('nodearealineartitle').style.display="none";
	}

	// Main social Network
	if ($('tabs')) { // +user social uses this
		$('tabs').style.display="none";
	}
	if ($('tab-content-user-title')) {
		$('tab-content-user-title').style.display="none";
	}
	if ($('tab-content-user-search')) {
		$('tab-content-user-search').style.display="none";
	}
	if ($('usertabs')) {
		$('usertabs').style.display="none";
	}

	// User social network
	if ($('context')) {
		$('context').style.display="none";
	}
	if ($('tab-content-user-bar')) {
		$('tab-content-user-bar').style.display="none";
	}

	resizeFDGraph(forcedirectedGraph, contentarea, true);
}

/**
 * Called by the Applet to open the applet help
 */
function showHelp() {
    loadDialog('help', URL_ROOT+'help/networkmap.php');
}

/**
 * Called by the Applet to go to the home page of the given userid
 */
function viewUserHome(userid) {
	var width = getWindowWidth();
	var height = getWindowHeight()-20;

	loadDialog('userdetails', URL_ROOT+"user.php?userid="+userid, width,height);
}

/**
 * Called by the Applet to go to the multi connection expanded view for the given connection
 */
function showMultiConnections(connectionids) {
	loadDialog("multiconnections", URL_ROOT+"ui/popups/showmulticonns.php?connectionids="+connectionids, 790, 450);
}

/**
 * Check if the current brwoser supports HTML5 Canvas.
 * Return true if it does, else false.
 */
function isCanvasSupported(){
  	var elem = document.createElement('canvas');
  	return !!(elem.getContext && elem.getContext('2d'));
}
