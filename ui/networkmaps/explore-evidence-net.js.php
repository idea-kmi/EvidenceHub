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

var forcedirectedGraph = null;

function loadExploreEvidenceNet(){

	$("tab-content-evidence-net").innerHTML = "";

	/**** CHECK GRAPH SUPPORTED ****/
	if (!isCanvasSupported()) {
		$("tab-content-evidence-net").insert('<div style="float:left;font-weight:12pt;padding:10px;"><?php echo $LNG->GRAPH_NOT_SUPPORTED; ?></div>');
		return;
	}

	/**** SETUP THE GRAPH ****/

	var graphDiv = new Element('div', {'id':'graphEvidenceDiv', 'style': 'clear:both;float:left'});
	var width = 4000;
	var height = 4000;

	var messagearea = new Element("div", {'id':'netevidencemessage','class':'toolbitem','style':'float:left;clear:both;font-weight:bold'});

	graphDiv.style.width = width+"px";
	graphDiv.style.height = height+"px";

	var outerDiv = new Element('div', {'id':'graphEvidenceDiv-outer', 'style': 'border:1px solid gray;clear:both;float:left;margin-left:5px;margin-bottom:5px;overflow:hidden'});
	outerDiv.insert(messagearea);
	outerDiv.insert(graphDiv);
	$("tab-content-evidence-net").insert(outerDiv);

	forcedirectedGraph = createNewForceDirectedGraph('graphEvidenceDiv', NODE_ARGS['nodeid']);

	// THE KEY
	var keybar = createNetworkGraphKey();
	// THE TOOLBAR
	var toolbar = createGraphToolbar(forcedirectedGraph, "tab-content-evidence-net");

	$("tab-content-evidence-net").insert({top: toolbar});
	$("tab-content-evidence-net").insert({top: keybar});

	//event to resize
	Event.observe(window,"resize",function() {
		resizeFDGraph(forcedirectedGraph, "tab-content-evidence-net", false);
	});

 	var size = calulateInitialGraphViewport("tab-content-evidence-net");
	outerDiv.style.width = size.width+"px";
	outerDiv.style.height = size.height+"px";

	loadEvidenceData(forcedirectedGraph, toolbar, messagearea);
}

function loadEvidenceData(forcedirectedGraph, toolbar, messagearea) {

	messagearea.update(getLoadingLine("<?php echo $LNG->NETWORKMAPS_LOADING_MESSAGE; ?>"));

	var args = {}; //must be an empty object to send down the url, or all the Array functions get sent too.

	args["nodeid"] = NODE_ARGS['nodeid'];
	args["start"] = 0;
    args['max'] = "-1";
    args['scope'] = "all";
    args['style'] = "mini";
    args['labelmatch'] = 'false';
    args['uniquepath'] = 'true';
    args['logictype'] = 'or';

    if (hasChallenge) {
	    args['depth'] = 3;
	} else {
	    args['depth'] = 2;
	}

	var type = "";
	if (hasClaim) {
		type += "Claim";
	}
	if (hasClaim && hasSolution) {
		type += ",";
	}
	if (hasSolution) {
		type += "Solution";
	}

	var extra = "&nodeids[]=";
	extra += "&nodeids[]=";
	if (hasChallenge) {
		extra += "&nodeids[]=";
	}

	extra += "&nodetypes[]="+encodeURIComponent(type);
	extra += "&nodetypes[]="+encodeURIComponent('Issue');
	if (hasChallenge) {
		extra += "&nodetypes[]="+encodeURIComponent('Challenge');
	}

	extra += "&directions[]=outgoing";
	extra += "&directions[]=outgoing";
	if (hasChallenge) {
		extra += "&directions[]=outgoing";
	}

	extra += "&linklabels[]="+encodeURIComponent('supports,challenges');
	extra += "&linklabels[]=";
	if (hasChallenge) {
		extra += "&linklabels[]=";
	}

	extra += "&linkgroups[]=";
	extra += "&linkgroups[]=All";
	if (hasChallenge) {
		extra += "&linkgroups[]=All";
	}

	var reqUrl = SERVICE_ROOT + "&method=getconnectionsbypathbydepth"+extra+"&" + Object.toQueryString(args);
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
			//alert("connection count = "+conns.length);
			if (conns.length > 0) {
				for(var i=0; i< conns.length; i++){
					var c = conns[i].connection;
					addConnectionToFDGraph(c, forcedirectedGraph.graph);
				}
			}

			// ADD SECOND CALL.
			var args2 = {}; //must be an empty object to send down the url, or all the Array functions get sent too.

			args2["nodeid"] = NODE_ARGS['nodeid'];
			args2["start"] = 0;
			args2['max'] = "-1";
			args2['scope'] = "all";

			args2['style'] = "long";
			args2['depth'] = 1;

			args2['labelmatch'] = 'false';
			args2['uniquepath'] = 'true';
			args2['logictype'] = 'or';

			var extra2 = "&nodeids[]=";
			extra2 += "&nodetypes[]="+encodeURIComponent(RESOURCE_TYPES_STR);
			extra2 += "&directions[]=incoming";
			extra2 += "&linklabels[]="+encodeURIComponent('is related to');
			extra2 += "&linkgroups[]=";

			var reqUrl = SERVICE_ROOT + "&method=getconnectionsbypathbydepth"+extra2+"&" + Object.toQueryString(args2);

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
					//alert("connection count2 = "+conns2.length);
					if (conns2.length > 0) {
						for(var i=0; i< conns2.length; i++){
							var c2 = conns2[i].connection;
							addConnectionToFDGraph(c2, forcedirectedGraph.graph);
						}
					}

					$('graphConnectionCount').innerHTML = "";
					$('graphConnectionCount').insert('<span style="font-size:10pt;color:black;float:left;margin-left:20px"><?php echo $LNG->GRAPH_CONNECTION_COUNT_LABEL; ?> '+(conns.length+conns2.length)+'</span>');

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

loadExploreEvidenceNet();