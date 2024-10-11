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

    $me = substr($_SERVER["PHP_SELF"], 1); // remove initial '/'
    if ($HUB_FLM->hasCustomVersion($me)) {
    	$path = $HUB_FLM->getCodeDirPath($me);
    	include_once($path);
		die;
	}

    array_push($HEADER,"<link rel='stylesheet' href='".$HUB_FLM->getStylePath("style.css")."' type='text/css' media='screen' />");
    array_push($HEADER,"<link rel='stylesheet' href='".$HUB_FLM->getStylePath("node.css")."' type='text/css' media='screen' />");
    array_push($HEADER,"<link rel='stylesheet' href='".$HUB_FLM->getStylePath("stylecustom.css")."' type='text/css' media='screen' />");

    array_push($HEADER,"<link rel='stylesheet' href='".$HUB_FLM->getStylePath("style.css")."' type='text/css' media='print' />");
    array_push($HEADER,"<link rel='stylesheet' href='".$HUB_FLM->getStylePath("node.css")."' type='text/css' media='print' />");
    array_push($HEADER,"<link rel='stylesheet' href='".$HUB_FLM->getStylePath("stylecustom.css")."' type='text/css' media='print' />");

    array_push($HEADER,"<script src='".$HUB_FLM->getCodeWebPath("ui/node.js.php")."' type='text/javascript'></script>");
    array_push($HEADER,"<script src='".$HUB_FLM->getCodeWebPath("ui/users.js.php")."' type='text/javascript'></script>");
    array_push($HEADER,"<script src='".$HUB_FLM->getCodeWebPath("ui/util.js.php")."' type='text/javascript'></script>");

    array_push($HEADER,"<script src='".$CFG->homeAddress."ui/lib/dateformat.js' type='text/javascript'></script>");

    include_once($HUB_FLM->getCodeDirPath("ui/headerreport.php"));

    $title = required_param("title", PARAM_TEXT);
    $name = required_param("name", PARAM_TEXT);
    $nodetype = required_param("nodetype", PARAM_TEXT);
    $nodeid = required_param("nodeid", PARAM_TEXT);
    $context = optional_param("context", "", PARAM_TEXT);
 ?>
<style type="text/css">
 @media print {
 	input#btnPrint {
 		display: none;
 	}
 }
</style>
<script type="text/javascript">
//<![CDATA[
var nodeid = "<?php echo $nodeid; ?>";
var nodetype = "<?php echo $nodetype; ?>";
var nodetitle = "<?php echo $title; ?>";
var nodename = "<?php echo $name; ?>";

var CURRENT_ADD_AREA_NODEID = "<?php echo $nodeid; ?>";

var challenges = {};
var issues = {};
var solutions = {};
var evidence = {};

function getChallengeConnections(nodetofocusid) {

	var allConnections = new Array();

	// GET CONNECTIONS UP FROM ME
	var args = {};
	args["nodeid"] = nodeid;
	args["start"] = 0;
    args['max'] = "-1";
    args['scope'] = "all";

    args['style'] = "short";
    args['depth'] = 4;

    args['labelmatch'] = 'false';
    args['uniquepath'] = 'true';
    args['logictype'] = 'or';

	var type = "";
	var link = "";
	if (hasClaim) {
		type += "Claim";
		link += "responds to";
	}
	if (hasClaim && hasSolution) {
		type += ",";
		link += ",";
	}
	if (hasSolution) {
		type += "Solution";
		link += "addresses";
	}

	var extra = "&nodeids[]=";
	extra += "&nodeids[]=";
	extra += "&nodeids[]=";
	extra += "&nodeids[]=";

	extra += "&nodetypes[]="+encodeURIComponent('Issue');
	extra += "&nodetypes[]="+encodeURIComponent(type);
	extra += "&nodetypes[]="+encodeURIComponent('Pro,Con,'+EVIDENCE_TYPES_STR);
	extra += "&nodetypes[]="+encodeURIComponent(RESOURCE_TYPES_STR);

	extra += "&directions[]=incoming";
	extra += "&directions[]=incoming";
	extra += "&directions[]=incoming";
	extra += "&directions[]=incoming";

	extra += "&linklabels[]="+encodeURIComponent('is related to');
	extra += "&linklabels[]="+encodeURIComponent(link);
	extra += "&linklabels[]="+encodeURIComponent('supports,challenges');
	extra += "&linklabels[]="+encodeURIComponent('is related to');

	extra += "&linkgroups[]=";
	extra += "&linkgroups[]=";
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
					allConnections.push(c);
				}
			}

			if (allConnections.length > 0) {
				processConnections(allConnections, nodetofocusid);
			} else {
				$("loadingdiv").innerHTML = "";
				$('printknowledgetree').update('<span style="margin-left:5px;"><?php echo $LNG->DEBATE_NO_DEBATES_CHALLENGE; ?></span>');
			}
		}
	});
}

function getIssueConnections(nodetofocusid) {

	var allConnections = new Array();

	// GET CONNECTIONS UP FROM ME
	var args = {}; //must be an empty object to send down the url, or all the Array functions get sent too.
	args["nodeid"] = nodeid;
	args["start"] = 0;
    args['max'] = "-1";
    args['scope'] = "all";

    args['style'] = "short";
    args['depth'] = 3;

    args['labelmatch'] = 'false';
    args['uniquepath'] = 'true';
    args['logictype'] = 'or';

	var extra = "&nodeids[]=";
	extra += "&nodeids[]=";
	extra += "&nodeids[]=";

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

	extra += "&nodetypes[]="+encodeURIComponent(type);
	extra += "&nodetypes[]="+encodeURIComponent('Pro,Con,'+EVIDENCE_TYPES_STR);
	extra += "&nodetypes[]="+encodeURIComponent(RESOURCE_TYPES_STR);

	extra += "&directions[]=incoming";
	extra += "&directions[]=incoming";
	extra += "&directions[]=incoming";

	extra += "&linklabels[]=";
	extra += "&linklabels[]="+encodeURIComponent('supports,challenges');
	extra += "&linklabels[]="; //+encodeURIComponent('is related to');

	extra += "&linkgroups[]=All";
	extra += "&linkgroups[]=";
	extra += "&linkgroups[]=All";

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
				//check for Challenges
				var hasChallenges = false;
				var levelChallenge = new Array();
				var levelIssue = new Array();
				for(var i=0; i< conns.length; i++){
					var c = conns[i].connection;
					allConnections.push(c);
				}
			}

			if (hasChallenge) {
				// GET CONNECTIONS UP FROM ME
				var args2 = {}; //must be an empty object to send down the url, or all the Array functions get sent too.
				args2["nodeid"] = nodeid;
				args2["start"] = 0;
				args2['max'] = "-1";
				args2['scope'] = "all";

				args2['style'] = "short";
				args2['depth'] = 1;

				args2['labelmatch'] = 'false';
				args2['uniquepath'] = 'true';
				args2['logictype'] = 'or';

				var extra = "&nodeids[]=";
				extra += "&nodetypes[]=Challenge";
				extra += "&directions[]=outgoing";
				extra += "&linklabels[]=is related to";
				extra += "&linkgroups[]=";

				var reqUrl = SERVICE_ROOT + "&method=getconnectionsbypathbydepth"+extra+"&" + Object.toQueryString(args2);
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
								allConnections.push(c);
							}

						}

						if (allConnections.length > 0) {
							processConnections(allConnections, nodetofocusid);
						} else {
							$("loadingdiv").innerHTML = "";
							$('printknowledgetree').update('<span style="margin-left:5px;"><?php echo $LNG->DEBATE_NO_DEBATES_ISSUE; ?></span>');
						}
					}
				});
			} else {
				if (allConnections.length > 0) {
					processConnections(allConnections, nodetofocusid);
				} else {
					$("loadingdiv").innerHTML = "";
					$('printknowledgetree').update('<span style="margin-left:5px;"><?php echo $LNG->DEBATE_NO_DEBATES_ISSUE; ?></span>');
				}
			}
		}
	});
}

function getSolutionConnections(nodetofocusid) {

	var allConnections = new Array();

	// GET CONNECTIONS UP FROM ME
	var args = {};

	args["nodeid"] = nodeid;
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


	var extra = "&nodeids[]=";
	extra += "&nodeids[]=";

	extra += "&nodetypes[]="+encodeURIComponent('Issue');
	extra += "&nodetypes[]="+encodeURIComponent('Challenge');

	extra += "&directions[]=outgoing";
	extra += "&directions[]=outgoing";

	extra += "&linklabels[]="+encodeURIComponent('addresses');
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
			//alert(conns.length);
			if (conns.length > 0) {
				for(var i=0; i< conns.length; i++){
					var c = conns[i].connection;
					allConnections.push(c);
				}
			}

			// GET CONNECTIONS DOWN FROM ME
			var args = {}; //must be an empty object to send down the url, or all the Array functions get sent too.

			args["nodeid"] = nodeid;
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

					var conns = json.connectionset[0].connections;
					if (conns.length > 0) {
						for(var i=0; i< conns.length; i++){
							var c = conns[i].connection;
							allConnections.push(c);
						}

					}

					if (allConnections.length > 0) {
						processConnections(allConnections, nodetofocusid);
					} else {
						$("loadingdiv").innerHTML = "";
						$('printknowledgetree').update('<span style="margin-left:5px;"><?php echo $LNG->DEBATE_NO_DEBATES_SOLUTION; ?></span>');
					}
				}
			});
		}
	});
}

function getClaimConnections(nodetofocusid) {
	var allConnections = new Array();

	// GET CONNECTIONS UP FROM ME
	var args = {};

	args["nodeid"] = nodeid;
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

			args["nodeid"] = nodeid;
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
						$("loadingdiv").innerHTML = "";
						$('printknowledgetree').update('<span style="margin-left:5px;"><?php echo $LNG->DEBATE_NO_DEBATES_CLAIM; ?></span>');
					}
				}
			});

		}
	});
}

function getEvidenceConnections(nodetofocusid) {
	var allConnections = new Array();

	// GET CONNECTIONS UP FROM ME
	var args = {}; //must be an empty object to send down the url, or all the Array functions get sent too.

	args["nodeid"] = nodeid;
	args["start"] = 0;
    args['max'] = "-1";
    args['scope'] = "all";
    args['style'] = "short";
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
				//check for Challenges
				var hasChallenges = false;
				var levelChallenge = new Array();
				var levelIssue = new Array();
				for(var i=0; i< conns.length; i++){
					var c = conns[i].connection;
					allConnections.push(c);
				}
			}

			// GET CONNECTIONS DOWN FROM ME
			var args2 = {}; //must be an empty object to send down the url, or all the Array functions get sent too.

			args2["nodeid"] = nodeid;
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
							allConnections.push(c);
						}

					}

					if (allConnections.length > 0) {
						processConnections(allConnections, nodetofocusid);
					} else {
						$("loadingdiv").innerHTML = "";
						$('printknowledgetree').update('<span style="margin-left:5px;"><?php echo $LNG->DEBATE_NO_DEBATES_EVIDENCE; ?></span>');
					}
				}
			});

		}
	});
}

function getResourceConnections(nodetofocusid) {
	var allConnections = new Array();

	// GET CONNECTIONS UP FROM ME
	var args = {}; //must be an empty object to send down the url, or all the Array functions get sent too.

	args["nodeid"] = nodeid;
	args["start"] = 0;
    args['max'] = "-1";
    args['scope'] = "all";
    args['style'] = "short";
    args['labelmatch'] = 'false';
    args['uniquepath'] = 'true';
    args['logictype'] = 'or';

    if (hasChallenge) {
    	args['depth'] = 4;
	} else {
	    args['depth'] = 3;
	}

	var type = "";
	var link = "";
	if (hasClaim) {
		type += "Claim";
		link += "responds to";
	}
	if (hasClaim && hasSolution) {
		type += ",";
		link += ",";
	}
	if (hasSolution) {
		type += "Solution";
		link += "addresses";
	}

	var extra = "&nodeids[]=";
	extra = "&nodeids[]=";
	extra = "&nodeids[]=";
    if (hasChallenge) {
    	extra = "&nodeids[]=";
    }

	extra += "&nodetypes[]="+encodeURIComponent('Pro,Con,'+EVIDENCE_TYPES_STR);
	extra += "&nodetypes[]="+encodeURIComponent(type);
	extra += "&nodetypes[]="+encodeURIComponent('Issue');
    if (hasChallenge) {
    	extra += "&nodetypes[]="+encodeURIComponent('Challenge');
    }

	extra += "&directions[]=outgoing";
	extra += "&directions[]=outgoing";
	extra += "&directions[]=outgoing";
    if (hasChallenge) {
    	extra += "&directions[]=outgoing";
    }

	extra += "&linklabels[]="+encodeURIComponent('is related to');
	extra += "&linklabels[]="+encodeURIComponent('supports,challenges');
	extra += "&linklabels[]="+encodeURIComponent(link);
    if (hasChallenge) {
    	extra += "&linklabels[]="+encodeURIComponent('is related to');
    }

	extra += "&linkgroups[]=";
	extra += "&linkgroups[]=";
	extra += "&linkgroups[]=";
    if (hasChallenge) {
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
			if (conns.length > 0) {
				//check for Challenges
				var hasChallenges = false;
				var levelChallenge = new Array();
				var levelIssue = new Array();
				for(var i=0; i< conns.length; i++){
					var c = conns[i].connection;
					allConnections.push(c);
				}

				processConnections(allConnections, nodetofocusid);
			} else {
				$("loadingdiv").innerHTML = "";
				$('printknowledgetree').update('<span style="margin-left:5px;"><?php echo $LNG->DEBATE_NO_DEBATES_RESOURCE; ?></span>');
			}
		}
	});
}

function getThemeConnections(nodetofocusid) {
	var allConnections = new Array();

	// GET CONNECTIONS WITH CURRENT THEME
	var args = {};
	args["start"] = 0;
    args['max'] = "-1";

    var baseStr = '';
    for (var i=0; i<BASE_TYPES.length; i++) {
    	if (BASE_TYPES[i] != "Theme"
    			&& BASE_TYPES[i] != "Idea"
    			&& BASE_TYPES[i] != "Project"
    			&& BASE_TYPES[i] != "Organization" ) {
    		if (baseStr == '') {
    			baseStr = BASE_TYPES[i]
    		} else {
    			baseStr += ','+BASE_TYPES[i];
    		}
    	}
    }

    args['filternodetypes'] = baseStr+","+RESOURCE_TYPES_STR+","+EVIDENCE_TYPES_STR;
    args['style'] = "short";
    args['orderby'] = 'date';
	args['themename'] = nodename;
	args['filterlist'] = 'is related to,supports,challenges,addresses,responds to';
	args['filtergroup'] = ''; // else list ignored.

	var reqUrl = SERVICE_ROOT + "&method=getconnectionsbyglobal&" + Object.toQueryString(args);
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


			if (allConnections.length > 0) {
				processConnections(allConnections, nodetofocusid);
			} else {
				$("loadingdiv").innerHTML = "";
				$('printknowledgetree').update('');
			}
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
		if ((hasSolution && tnRole.name == "Solution") || (hasClaim && tnRole.name == "Claim")) {
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
						next.cnode['handler'] = "";
						next.cnode['focalnodeid'] = nodeid;
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
						next.cnode['focalnodeid'] = nodeid;
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
						next.cnode['focalnodeid'] = nodeid;
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
	for (var index in evidence) {
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
	}

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
					next.cnode['handler'] = "";
					next.cnode['focalnodeid'] = nodeid;
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
					next.cnode['focalnodeid'] = nodeid;
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
					next.cnode['handler'] = "";
					next.cnode['focalnodeid'] = nodeid;
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
					next.cnode['focalnodeid'] = nodeid;
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
					next.cnode['handler'] = "";
					next.cnode['focalnodeid'] = nodeid;
					children.push(next);
					check[fN.cnode.nodeid] = next;
				}
			}
		}

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
					next.cnode['focalnodeid'] = nodeid;
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

	// PREPARE EVIDENCE
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
					next.cnode['handler'] = "";
					next.cnode['focalnodeid'] = nodeid;
					children.push(next);
					check[fN.cnode.nodeid] = next;
				}
			}
		}

		for(var ind2 in evidence){
			var nextsol = evidence[ind2];
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

	for(var index in evidence) {
		var conns = evidence[index];
		for(var i=0; i< conns.length; i++){
			var c = conns[i];
			var tN = c.to[0];
			if (tN.cnode.name != "") {
				if (!check[tN.cnode.nodeid]) {
					var next = tN;
					next.cnode['connection'] = c;
					next.cnode['focalnodeid'] = nodeid;
					next.cnode['istop'] = true;
					nodes.push(next);
					check[tN.cnode.nodeid] = next;
				}
			}
		}
	}

	evidence = nodes;
	//evidence.sort(alphanodesort);
	evidence.sort(connectiontypenodesort);
	evidence.sort(connectiontypealphanodesort);

	if (nodetofocusid === undefined) {
		nodetofocusid = "";
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
	var evidencecount = 0;
	if (evidence.length && evidence.length > 0) {
		evidencecount = evidence.length;
	}
	var debateCount = (challengescount+issuecount+solutionscount+evidencecount);
	//$('debatecount').update(debateCount);

	// DRAW CHALLENGES DOWN
	if (challenges.length > 0){
		displayReportConnectionNodes($('printknowledgetree'), challenges,parseInt(0), true, "knowledgetreereport");
	}
	// DRAW WHATS LEFT IN ISSUES DOWN
	if (issues.length > 0){
		displayReportConnectionNodes($('printknowledgetree'),issues,parseInt(0), true, "knowledgetreereport");
	}

	// DRAW WHATS LEFT IN SOLUTION/CLAIM DOWN
	if (Object.keys(solutions).length > 0) {
		displayReportConnectionNodes($('printknowledgetree'),solutions,parseInt(0), true, "knowledgetreereport");
	}

	// DRAW WHATS LEFT IN EVIDENCE DOWN
	if (Object.keys(evidence).length > 0) {
		displayReportConnectionNodes($('printknowledgetree'),evidence,parseInt(0), true, "knowledgetreereport");
	}

	$("loadingdiv").innerHTML = "";

	//checkDebateHasNode(nodetofocusid);
}

/**
*  set which tab to show and load first
*/
Event.observe(window, 'load', function() {
	document.title = nodetitle;

	var explorelink = new Element("span", {'style':'text-decoration: none'});
	explorelink.insert(nodetitle);
	$("innertitle").insert(explorelink);

	if (nodetype == 'Challenge') {
		getChallengeConnections(nodeid);
	} else if (nodetype == 'Issue') {
		getIssueConnections(nodeid);
	} else if (nodetype == 'Solution') {
		getSolutionConnections(nodeid);
	} else if (nodetype == 'Claim') {
		getClaimConnections(nodeid);
	} else if (nodetype == 'Evidence') {
		getEvidenceConnections(nodeid);
	} else if (nodetype == 'Resource') {
		getResourceConnections(nodeid);
	} else if (nodetype == 'Theme') {
		getThemeConnections(nodeid);
	}
});
//]]>
</script>

<h1 id="innertitle" style="clear:both; margin:10px;text-align:center;"></h1>

<input style="margin-left: 10px;margin-bottom:10px;" type="button" id="btnPrint" value=" <?php echo $LNG->FORM_BUTTON_PRINT_PAGE; ?> " onclick="window.print();return false;" />

<div id="printknowledgetree" style="margin: 10px;"></div>

<div id="loadingdiv" class="loading" style="clear:both; float:left"><img src='<?php echo $HUB_FLM->getImagePath("ajax-loader.gif"); ?>'/><br/><?php echo $LNG->LOADING_DATA; ?><br><center><?php echo $LNG->FORM_PRINT_LOADING_MESSAGE; ?></center></div>

</div>

<?php
    include_once($HUB_FLM->getCodeDirPath("ui/footerreport.php"));
?>