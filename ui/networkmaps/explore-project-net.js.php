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

    include_once("../../config.php");
?>

var forcedirectedGraph = null;

function loadExploreProjectNet() {

	$("tab-content-project-net").innerHTML = "";

	/**** CHECK GRAPH SUPPORTED ****/
	if (!isCanvasSupported()) {
		$("tab-content-project-net").insert('<div style="float:left;font-weight:12pt;padding:10px;"><?php echo $LNG->GRAPH_NOT_SUPPORTED; ?></div>');
		return;
	}

	/**** SETUP THE GRAPH ****/

	var graphDiv = new Element('div', {'id':'graphProjectDiv', 'style': 'clear:both;float:left'});
	var width = 4000;
	var height = 4000;

	var messagearea = new Element("div", {'id':'netprojectmessage','class':'toolbitem','style':'float:left;clear:both;font-weight:bold'});

	graphDiv.style.width = width+"px";
	graphDiv.style.height = height+"px";

	var outerDiv = new Element('div', {'id':'graphProjectDiv-outer', 'style': 'border:1px solid gray;clear:both;float:left;margin-left:5px;margin-bottom:5px;overflow:hidden'});
	outerDiv.insert(messagearea);
	outerDiv.insert(graphDiv);
	$("tab-content-project-net").insert(outerDiv);

	forcedirectedGraph = createNewForceDirectedGraph('graphProjectDiv', NODE_ARGS['nodeid']);

	// THE KEY
	var keybar = createNetworkOrgGraphKey();
	// THE TOOLBAR
	var toolbar = createGraphToolbar(forcedirectedGraph, "tab-content-project-net");

	$("tab-content-project-net").insert({top: toolbar});
	$("tab-content-project-net").insert({top: keybar});

	//event to resize
	Event.observe(window,"resize",function() {
		resizeFDGraph(forcedirectedGraph, "tab-content-project-net", false);
	});

 	var size = calulateInitialGraphViewport("tab-content-project-net");
	outerDiv.style.width = size.width+"px";
	outerDiv.style.height = size.height+"px";

	loadProjectData(forcedirectedGraph, toolbar, messagearea);
}

function loadProjectData(forcedirectedGraph, toolbar, messagearea) {

	messagearea.update(getLoadingLine("<?php echo $LNG->NETWORKMAPS_LOADING_MESSAGE; ?>"));

	var args = {}; //must be an empty object to send down the url, or all the Array functions get sent too.

	args["nodeid"] = NODE_ARGS['nodeid'];
	args["start"] = 0;
    args['max'] = "-1";
    args['scope'] = "all";

    args['style'] = "mini";
    args['depth'] = 2;

    args['labelmatch'] = 'false';
    args['uniquepath'] = 'true';
    args['logictype'] = 'or';

	var extra = "&nodeids[]=";
	extra = "&nodeids[]=";

	var type = "";
	var link = "";
	if (hasChallenge) {
		type += "Challenge";
	}
	if (hasClaim) {
		if (type != "") {
			type +=",";
		}
		type += "Claim";
		if (link != "") {
			link +=",";
		}
		link += "responds to";
	}
	if (hasSolution) {
		if (type != "") {
			type +=",";
		}
		type += "Solution";
	}

	extra += "&nodetypes[]=Organization,Project,Issue,"+EVIDENCE_TYPES_STR+","+type;
	extra += "&nodetypes[]=Organization,Project";

	extra += "&directions[]=both";
	extra += "&directions[]=both";

	extra += "&linklabels[]="+encodeURIComponent('manages,partnered with,is related to,specifies,addresses'+link);
	extra += "&linklabels[]="+encodeURIComponent('manages,partnered with');

	extra += "&linkgroups[]=";
	extra += "&linkgroups[]=";

	/*extra += "&linklabels[]=";
	extra += "&linklabels[]=";

	extra += "&linkgroups[]=All";
	extra += "&linkgroups[]=All";
	*/

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

			$('graphConnectionCount').innerHTML = "";
			$('graphConnectionCount').insert('<span class="connections-count"><?php echo $LNG->GRAPH_CONNECTION_COUNT_LABEL; ?> '+conns.length+'</span>');

			if (conns.length > 0) {
				for(var i=0; i< conns.length; i++){
					var c = conns[i].connection;
					addConnectionToFDGraph(c, forcedirectedGraph.graph);
				}
				layoutAndAnimate(forcedirectedGraph, messagearea);
				toolbar.style.display = 'block';
			} else {
				messagearea.innerHTML="<?php echo $LNG->NETWORKMAPS_NO_RESULTS_MESSAGE; ?>";
				toolbar.style.display = 'none';
			}
		}
	});
}

loadExploreProjectNet();