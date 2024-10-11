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

function loadExploreSolutionNet(){

	$("tab-content-solution-net").innerHTML = "";

	/**** CHECK GRAPH SUPPORTED ****/
	if (!isCanvasSupported()) {
		$("tab-content-solution-net").insert('<div style="float:left;font-weight:12pt;padding:10px;"><?php echo $LNG->GRAPH_NOT_SUPPORTED; ?></div>');
		return;
	}

	/**** SETUP THE GRAPH ****/

	var graphDiv = new Element('div', {'id':'graphSolutionDiv', 'style': 'clear:both;float:left'});
	var width = 4000;
	var height = 4000;

	var messagearea = new Element("div", {'id':'netsolutionmessage','class':'toolbitem','style':'float:left;clear:both;font-weight:bold'});

	graphDiv.style.width = width+"px";
	graphDiv.style.height = height+"px";

	var outerDiv = new Element('div', {'id':'graphSolutionDiv-outer', 'style': 'border:1px solid gray;clear:both;float:left;margin-left:5px;margin-bottom:5px;overflow:hidden'});
	outerDiv.insert(messagearea);
	outerDiv.insert(graphDiv);
	$("tab-content-solution-net").insert(outerDiv);

	forcedirectedGraph = createNewForceDirectedGraph('graphSolutionDiv', NODE_ARGS['nodeid']);

	// THE KEY
	var keybar = createNetworkGraphKey();
	// THE TOOLBAR
	var toolbar = createGraphToolbar(forcedirectedGraph, "tab-content-solution-net");

	$("tab-content-solution-net").insert({top: toolbar});
	$("tab-content-solution-net").insert({top: keybar});

	//event to resize
	Event.observe(window,"resize",function() {
		resizeFDGraph(forcedirectedGraph, "tab-content-solution-net", false);
	});

 	var size = calulateInitialGraphViewport("tab-content-solution-net");
	outerDiv.style.width = size.width+"px";
	outerDiv.style.height = size.height+"px";

	loadSolutionData(forcedirectedGraph, toolbar, messagearea);
}


function loadSolutionData(forcedirectedGraph, toolbar, messagearea) {

	messagearea.update(getLoadingLine("<?php echo $LNG->NETWORKMAPS_LOADING_MESSAGE; ?>"));

	var args = {}; //must be an empty object to send down the url, or all the Array functions get sent too.

	args["nodeid"] = NODE_ARGS['nodeid'];
	args["start"] = 0;
    args['max'] = "-1";
    args['scope'] = "all";

    args['style'] = "mini";
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

			var conns = json.connectionset[0].connections;
			if (conns.length > 0) {
				for(var i=0; i< conns.length; i++){
					var c = conns[i].connection;
					addConnectionToFDGraph(c, forcedirectedGraph.graph);
				}
			}

			var args = {}; //must be an empty object to send down the url, or all the Array functions get sent too.

			args["nodeid"] = NODE_ARGS['nodeid'];
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

				extra += "&linklabels[]="+encodeURIComponent('addresses');
				extra += "&linklabels[]="+encodeURIComponent('is related to');

				extra += "&linkgroups[]=";
				extra += "&linkgroups[]=";
			} else {
				args['depth'] = 1;
				extra += "&nodetypes[]="+encodeURIComponent('Issue');
				extra += "&directions[]=outgoing";
				extra += "&linklabels[]="+encodeURIComponent('addresses');
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

					var conns2 = json.connectionset[0].connections;
					if (conns2.length > 0) {
						for(var i=0; i< conns2.length; i++){
							var c = conns2[i].connection;
							addConnectionToFDGraph(c, forcedirectedGraph.graph);
						}
					}

					$('graphConnectionCount').innerHTML = "";
					$('graphConnectionCount').insert('<span class="connections-count"><?php echo $LNG->GRAPH_CONNECTION_COUNT_LABEL; ?> '+(conns.length+conns2.length)+'</span>');

					if (conns.length > 0 || (conns2 && conns2.length > 0)) {
						layoutAndAnimate(forcedirectedGraph, messagearea);
						toolbar.style.display = 'block';
					} else {
						messagearea.innerHTML="<?php echo $LNG->NETWORKMAPS_NO_RESULTS_MESSAGE; ?>";
						toolbar.style.display = 'none';
					}
				}
			});

		}
	});
}

loadExploreSolutionNet();