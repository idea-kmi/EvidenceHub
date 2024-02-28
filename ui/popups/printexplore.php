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

    $me = substr($_SERVER["PHP_SELF"], 1); // remove initial '/'
    if ($HUB_FLM->hasCustomVersion($me)) {
    	$path = $HUB_FLM->getCodeDirPath($me);
    	include_once($path);
		die;
	}

    array_push($HEADER,"<link rel='stylesheet' href='".$HUB_FLM->getStylePath("style.css")."' type='text/css' media='screen' />");
    array_push($HEADER,"<link rel='stylesheet' href='".$HUB_FLM->getStylePath("stylecustom.css")."' type='text/css' media='screen' />");

    array_push($HEADER,"<link rel='stylesheet' href='".$HUB_FLM->getStylePath("style.css")."' type='text/css' media='print' />");
    array_push($HEADER,"<link rel='stylesheet' href='".$HUB_FLM->getStylePath("stylecustom.css")."' type='text/css' media='print' />");

    array_push($HEADER,"<script src='".$HUB_FLM->getCodeWebPath("ui/node.js.php")."' type='text/javascript'></script>");
    array_push($HEADER,"<script src='".$HUB_FLM->getCodeWebPath("ui/users.js.php")."' type='text/javascript'></script>");

    array_push($HEADER,"<script src='".$CFG->homeAddress."ui/lib/dateformat.js' type='text/javascript'></script>");

    include_once($HUB_FLM->getCodeDirPath("ui/headerreport.php"));

    $dataurl = required_param("url", PARAM_URL);
    $title = required_param("title", PARAM_TEXT);
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
var dataurl = "<?php echo $dataurl; ?>";
var nodeid = "<?php echo $nodeid; ?>";
var nodetitle = "<?php echo $title; ?>";

function getNode(){

	new Ajax.Request(dataurl, { method:'post',
			onSuccess: function(transport){
				var json = transport.responseText.evalJSON();
				if(json.error){
					alert(json.error[0].message);
					return;
				}

				$("printexplore").innerHTML = "";

				if(json.cnode[0]) {
					var node = json.cnode[0];
					var user = node.users[0].user;
					var role = node.role[0].role.name;
					var nodeid = node.nodeid;

					var creationdate = node.creationdate;
					var description = node.description;

					var username = user.name;
					var userid = user.userid;
					var userimage = user.thumb;

					var explorelink = new Element("span", {'style':'text-decoration: none'});
					explorelink.insert("<?php echo $title; ?>");
					$("innertitle").insert(explorelink);

					var innerwidgetBody = new Element("div", {'id':'innerwidgetnodebody'});
					innerwidgetBody.style.marginBottom = "15px";
					innerwidgetBody.style.marginTop = "15px";

					var userbar = new Element("div", {'style':'clear:both;'} );
					var iuDiv = new Element("div", {'class':'idea-user2', 'style':'clear:both;float:left;'});
					var userimageThumb = new Element('img',{'alt':username, 'title': username, 'style':'padding-right:5px;', 'border':'0','src': userimage});
					var imagelink = new Element('a', {
						'href':URL_ROOT+"user.php?userid="+userid,
						'title':username});
					imagelink.insert(userimageThumb);
					iuDiv.update(imagelink);
					userbar.appendChild(iuDiv);

					var iuDiv = new Element("div", {'style':''});
					var cDate = new Date(creationdate*1000);
					iuDiv.insert("<b><?php echo $LNG->NODE_ADDED_ON; ?> </b>"+ cDate.format(DATE_FORMAT) + "<br/>");
					iuDiv.insert('<b><?php echo $LNG->NODE_ADDED_BY; ?> </b>'+username+'<br/>');
					userbar.insert(iuDiv);

					innerwidgetBody.appendChild(userbar);

					if (node.startdatetime && node.startdatetime != "" && node.role.name == 'Project') {
						var sDate = new Date(node.startdatetime*1000);
						innerwidgetBody.insert('<br /><b><?php echo $LNG->FORM_LABEL_PROJECT_STARTED_DATE; ?> </b>'+sDate.format(DATE_FORMAT_PROJECT)+'<br>');
						if (node.enddatetime && node.enddatetime != "") {
							var eDate = new Date(node.enddatetime*1000);
							innerlinearDetails.insert('<b><?php echo $LNG->FORM_LABEL_PROJECT_ENDED_DATE; ?> </b>'+eDate.format(DATE_FORMAT_PROJECT)+'<br>');
						}
					}

					if (node.identifier && node.identifier != "" && node.role.name == 'Publication') {
						innerwidgetBody.insert('<b><?php echo $LNG->FORM_LABEL_DOI; ?> </b><span>'+node.identifier+'</span><br>');
					}
					if (node.locationaddress1 && node.locationaddress1 != "") {
						innerwidgetBody.insert('<br /><span style="clear:both;float:left;font-weight:bold;width:83px;">Address1: </span><span>'+node.locationaddress1+'</span>');
					}
					if (node.locationaddress2 && node.locationaddress2 != "") {
						innerwidgetBody.insert('<br /><span style="clear:both;float:left;font-weight:bold;width:83px;">Address2: </span><span>'+node.locationaddress2+'</span>');
					}
					if (node.location && node.location != "") {
						innerwidgetBody.insert('<br /><span style="clear:both;float:left;font-weight:bold;width:83px;">City: </span><span>'+node.location+'</span>');
					}
					if (node.locationpostcode && node.locationpostcode != "") {
						innerwidgetBody.insert('<br /><span style="clear:both;float:left;font-weight:bold;width:83px;">Postal Code: </span><span>'+node.locationpostcode+'</span>');
					}
					if (node.country && node.country != "") {
						innerwidgetBody.insert('<br /><span style="clear:both;float:left;font-weight:bold;width:83px;">Country: </span><span>'+node.country+'</span><br>');
					}

					// Add Tags
					if(node.tags && node.tags.length > 0){
						var grpStr = "<div style='clear:both;float:left;padding:0px; margin:0px; margin-top:10px;'><b><?php echo $LNG->NODE_TAGS_HEADING; ?> </b>";
						for (var i=0 ; i< node.tags.length; i++){
							var tag = null;
							if (node.tags[i].name) {
								tag = node.tags[i];
							} else {
								tag = node.tags[i].tag
							}
							grpStr += tag.name;
							if (i < node.tags.length-1) {
								grpStr += ', ';
							}
						}

						grpStr += '</div>';
						innerwidgetBody.insert(grpStr);
					}

					if (RESOURCE_TYPES_STR.indexOf(role) != -1) {
						innerwidgetBody.insert('<div style="clear:both;float:left;margin-top:5px;"><b><?php echo $LNG->NODE_URL_HEADING; ?> </b><a href="node.name" target="_blank">'+node.name+'</a></div>');

						if (node.urls && node.urls.length > 0) {
							var hasClips = false;
							var iULDiv = new Element("div", {'style':'clear:both;float:left;margin:0px;padding:0px;'});
							var iUL = new Element("ul", {});
							for (var i=0 ; i< node.urls.length; i++){
								if (node.urls[i].url.clip && node.urls[i].url.clip != "") {
									var link = new Element("li");
									link.insert(node.urls[i].url.clip);
									iUL.insert(link);
									hasClips = true;
								}
							}

							if (hasClips) {
								iULDiv.insert('<span style="margin-right:5px;"><b><?php echo $LNG->NODE_RESOURCE_CLIPS_HEADING; ?> </b></span><br>');
								iULDiv.insert(iUL);
								innerwidgetBody.insert(iULDiv);
							}
						}
					} else {
						if (description && description != "") {
							innerwidgetBody.insert('<div style="clear:both;float:left;margin-top:5px;"><b>Description: </b><br><div class="idea-desc">'+description+'</div></div>');
						}
					}
					$('printexplore').update(innerwidgetBody);

					if (role != "Theme") {
						getThemes(role);
					} else {
						if (hasChallenge) {
							loadThemeRelatedData(role, node.name, 'Challenge', '<?php echo $LNG->FORM_PRINT_THEME_CHALLENGE_HEADING; ?>');
						} else {
							loadThemeRelatedData(role, node.name, 'Issue', '<?php echo $LNG->FORM_PRINT_THEME_ISSUE_HEADING; ?>');
						}
					}
				}
			}
		});
}

function getThemes(role){

	var reqUrl = SERVICE_ROOT + "&method=getconnectionsbynode&style=short";
	reqUrl += "&orderby=vote&sort=DESC&filterlist=has main theme&filternodetypes=Theme&scope=all&start=0&max=-1&nodeid="+nodeid;

	new Ajax.Request(reqUrl, { method:'post',
			onSuccess: function(transport){

				var json = transport.responseText.evalJSON();
				if(json.error){
					alert(json.error[0].message);
					return;
				}

				var conns = json.connectionset[0].connections;
				if (conns.length == 0) {
					//$('printexplore').insert("No related <?php echo $LNG->THEMES_NAME; ?> found");
				} else {
					var nodes = new Array();
					var check = new Array();

					for(var i=0; i< conns.length; i++){
						var c = conns[i].connection;
						var fN = c.from[0].cnode;
						var tN = c.to[0].cnode;

						var fnRole = c.fromrole[0].role;
						var tnRole = c.torole[0].role;

						if (fnRole.name == 'Theme') {
							if (fN.name != "") {
								if (!check[fN.nodeid]) {
									var next = c.from[0];
									next.cnode['connection'] = c;
									nodes.push(next);
									check[fN.nodeid] = fN.nodeid;
								}
							}
						} else if (tnRole.name == 'Theme') {
							if (tN.name != "") {
								if (!check[tN.nodeid]) {
									var next = c.to[0];
									next.cnode['connection'] = c;
									nodes.push(next);
									check[tN.nodeid] = tN.nodeid;
								}
							}
						}
					}

					if (nodes.length > 0){
						$('printexplore').insert('<h2 style="clear:both; padding-top: 10px;"><?php echo $LNG->THEMES_NAME; ?></h2>');

						var grpStr = "";
						for (var i=0 ; i< nodes.length; i++){
							var node = nodes[i];
							grpStr += node.cnode.name;
							if (i < nodes.length-1) {
								grpStr += ', ';
							}
						}
						$('printexplore').insert(grpStr);

						//displayReportNodes($('printexplore'),nodes,parseInt(0), true);
					} else {
						//$('printexplore').insert("No related <?php echo $LNG->THEMES_NAME; ?> found");
					}
				}

				if (role == 'Organization' || role == 'Project') {
					loadURLs(role);
				} else if (role == 'Issue') {
					if (hasSolution) {
						loadSolutionsProposed(role);
					} else if (hasClaim) {
						loadClaimsResponding(role);
					}
				} else if (role == 'Challenge') {
					loadIssuesRelated(role);
				} else if (role == 'Solution') {
					loadEvidence(role, "Pro", "supports", "<?php echo $LNG->FORM_PRINT_SOLUTION_EVIDENCE_PRO_HEADING; ?>")
				} else if (role == 'Claim') {
					loadEvidence(role, "Pro", "supports", "<?php echo $LNG->FORM_PRINT_CLAIM_EVIDENCE_PRO_HEADING; ?>")
				} else if (EVIDENCE_TYPES.indexOf(role) != -1) {
					loadURLs(role);
				} else if (RESOURCE_TYPES.indexOf(role) != -1) {
					loadEvidence(role, "Pro,Con", "supports,challenges", "<?php echo $LNG->FORM_PRINT_RESOURCE_EVIDENCE_HEADING; ?>")
				}
			}
	});
}

function loadURLs(role) {

	var reqUrl = SERVICE_ROOT + "&method=getconnectionsbynode&style=long";
	reqUrl += "&filterlist=is related to&filternodetypes="+RESOURCE_TYPES_STR+"&scope=all&start=0&max=-1&nodeid="+nodeid;

	new Ajax.Request(reqUrl, { method:'post',
		onSuccess: function(transport){
			var json = transport.responseText.evalJSON();
			if(json.error){
				alert(json.error[0].message);
				return;
			}
			var conns = json.connectionset[0].connections;

			if (conns.length == 0) {
				//$('printexplore').insert("No related urls found");
			} else {
				var nodes = new Array();
				var check = new Array();

				for(var i=0; i< conns.length; i++){
					var c = conns[i].connection;
					var fN = c.from[0].cnode;
					var tN = c.to[0].cnode;

					var fnRole = c.fromrole[0].role;
					var tnRole = c.torole[0].role;

					if (RESOURCE_TYPES.indexOf(fnRole.name) != -1 && fN.nodeid != nodeid) {
						if (fN.name != "") {
							if (!check[fN.nodeid]) {
								var next = c.from[0];
								next.cnode['connection'] = c;
								nodes.push(next);
								check[fN.nodeid] = fN.nodeid;
							}
						}
					} else if (RESOURCE_TYPES.indexOf(tnRole.name) != -1 && tN.nodeid != nodeid) {
						if (tN.name != "") {
							if (!check[tN.nodeid]) {
								var next = c.to[0];
								next.cnode['connection'] = c;
								nodes.push(next);
								check[tN.nodeid] = tN.nodeid;
							}
						}
					}
				}

				if (nodes.length > 0){
					$('printexplore').insert('<h2 style="clear:both; padding-top: 15px;"><?php echo $LNG->FORM_PRINT_RESOURCES_HEADING; ?></h2>');
					displayReportNodes($('printexplore'),nodes,parseInt(0), true);
				} else {
					//$('printexplore').insert("No related web resources found");
				}
			}

			if (role == 'Organization' || role == 'Project') {
				if (hasChallenge) {
					loadChallengesAddressed(role, '<?php echo $LNG->PRINT_FORM_ORGP_CHALLENGE_HEADING; ?>');
				} else {
					loadIssuesAddressed(role);
				}
			} else if (EVIDENCE_TYPES.indexOf(role) != -1) {
				if(hasSolution) {
					loadRelatedSolutions(role);
				} else if (hasClaim) {
					loadRelatedClaims(role);
				}
			} else if (role = "Challenge") {
				//$('printexplore').insert('<h2 style="clear:both; padding-top: 15px;">The Following Share <?php echo $LNG->THEMES_NAME; ?></h2>');
				//loadSolutionsSharedThemes(role);
				loadComments(role);
			}
		}
	});
}

function loadChallengesAddressed(role, title) {
	loadConnectionData(role, 'Challenge','addresses',title);
}

function loadRelatedKeyChallenges(role) {
	loadConnectionData(role, 'Challenge','is related to','<?php echo $LNG->FORM_PRINT_CHALLENGE_RESOURCE_HEADING; ?>');
}

function loadParentKeyChallenges(role) {
	loadConnectionData(role, 'Challenge','is related to','<?php echo $LNG->FORM_PRINT_CHALLENGE_ISSUE_HEADING; ?>');
}

function loadClaimsMade(role) {
	loadConnectionData(role, 'Claim','claims','<?php echo $LNG->FORM_PRINT_ORGP_CLAIM_HEADING; ?>');
}

function loadProposedSolutions(role) {
	loadConnectionData(role, 'Challenge','addresses','<?php echo $LNG->FORM_PRINT_CHALLENGE_SOLUTION_HEADING; ?>');
}

function loadSolutionsProposed(role) {
	loadConnectionData(role, 'Solution','addresses','<?php echo $LNG->FORM_PRINT_ISSUE_SOLUTION_HEADING; ?>');
}

function loadSolutionsSpecified(role) {
	loadConnectionData(role, 'Solution','specifies','<?php echo $LNG->FORM_PRINT_ORGP_SOLUTION_HEADING; ?>');
}

function loadClaimsResponding(role) {
	loadConnectionData(role, 'Claim','responds to','<?php echo $LNG->FORM_PRINT_ISSUE_CLAIM_HEADING; ?>');
}

function loadOrgsAddressing(role) {
	loadConnectionData(role, 'Organization,Project','addresses','<?php echo $LNG->FORM_PRINT_ORGP_ADDRESSING_HEADING; ?>');
}

function loadOrgsSpecifies(role) {
	loadConnectionData(role, 'Organization,Project','specifies','<?php echo $LNG->FORM_PRINT_ORGP_SPECIFY_HEADING; ?>');
}

function loadOrgsClaiming(role) {
	loadConnectionData(role, 'Organization,Project','claims','<?php echo $LNG->FORM_PRINT_CLAIM_ORGP_HEADING; ?>');
}

function loadOrgsLinked(role) {
	loadConnectionData(role, 'Organization,Project','is related to','<?php echo $LNG->FORM_PRINT_ORGP_RESOURCE_HEADING; ?>');
}

function loadRelatedIssues(role) {
	loadConnectionData(role, 'Issue','is related to','<?php echo $LNG->FORM_PRINT_ISSUE_RESOURCE_HEADING; ?>');
}

function loadIssuesRelated(role) {
	loadConnectionData(role, 'Issue','is related to','<?php echo $LNG->FORM_PRINT_ISSUE_CHALLENGE_HEADING; ?>');
}

function loadAddressedIssues(role) {
	loadConnectionData(role, 'Issue','addresses','<?php echo $LNG->FORM_PRINT_ISSUE_SOLUTION_HEADING; ?>');
}

function loadIssuesAddressed(role) {
	loadConnectionData(role, 'Issue','addresses','<?php echo $LNG->FORM_PRINT_SOLUTION_ISSUE_HEADING; ?>');
}

function loadIssuesRespondedTo(role) {
	loadConnectionData(role, 'Issue','responds to','<?php echo $LNG->FORM_PRINT_CLAIM_ISSUE_HEADING; ?>');
}

function loadProjectsManaged(role) {
	loadConnectionData(role, 'Project','manages','<?php echo $LNG->FORM_PRINT_ORG_PROJECT_HEADING; ?>');
}

function loadRelatedSolutions(role) {
	loadConnectionData(role, 'Solution','challenges,supports','<?php echo $LNG->FORM_PRINT_EVIDENCE_SOLUTION_HEADING; ?>');
}

function loadRelatedClaims(role) {
	loadConnectionData(role, 'Claim','challenges,supports','<?php echo $LNG->FORM_PRINT_EVIDENCE_CLAIM_HEADING; ?>');
}

function loadThemeRelatedData(role, theme, nodetype, title) {

	var reqUrl = SERVICE_ROOT + "&method=gettypeconnectionsbytheme&style=long";
	reqUrl += "&theme="+theme+"&type="+nodetype+"&scope=all&start=0&max=-1";
	//alert(reqUrl);
	new Ajax.Request(reqUrl, { method:'post',
  		onSuccess: function(transport){
  			var json = transport.responseText.evalJSON();
			if(json.error){
				alert(json.error[0].message);
				return;
			}
			var conns = json.connectionset[0].connections;

			if (conns.length == 0) {
				//$('printexplore').insert("No "+title+" found");
			} else {
				var nodes = new Array();
				var check = new Array();

				//alert(conns.length);

				for(var i=0; i< conns.length; i++){
					var c = conns[i].connection;
					var fN = c.from[0].cnode;
					var tN = c.to[0].cnode;

					var fnRole = c.fromrole[0].role;
					var tnRole = c.torole[0].role;

					if (fN.name != "") {
						if (!check[fN.nodeid]) {
							var next = c.from[0];
							next.cnode['connection'] = c;
							nodes.push(next);
							check[fN.nodeid] = fN.nodeid;
						}
					}
				}

				if (nodes.length > 0){
					$('printexplore').insert('<h2 style="clear:both; padding-top: 15px;">'+title+'</h2>');
					displayReportNodes($('printexplore'),nodes,parseInt(0), true);
				} else {
					//$('printexplore').insert("No "+title+" found");
				}
			}

			if (nodetype == 'Challenge') {
				loadThemeRelatedData(role, theme, 'Issue', '<?php echo $LNG->FORM_PRINT_THEME_ISSUE_HEADING; ?>');
			} else if (nodetype == 'Issue') {
				loadThemeRelatedData(role, theme, 'Solution', '<?php echo $LNG->FORM_PRINT_THEME_SOLTUION_HEADING; ?>');
			} else if (nodetype == 'Solution') {
				loadThemeRelatedData(role, theme, 'Claim', '<?php echo $LNG->FORM_PRINT_THEME_CLAIM_HEADING; ?>');
			} else if (nodetype == 'Claim') {
				loadThemeRelatedData(role, theme, EVIDENCE_TYPES, '<?php echo $LNG->FORM_PRINT_THEME_EVIDENCE_HEADING; ?>');
			} else if (nodetype == EVIDENCE_TYPES_STR) {
				loadThemeRelatedData(role, theme, RESOURCE_TYPES_STR, '<?php echo $LNG->FORM_PRINT_THEME_RESOURCE_HEADING; ?>');
			}  else if (nodetype == RESOURCE_TYPES_STR) {
				loadThemeRelatedData(role, theme, 'Organization,Project', '<?php echo $LNG->FORM_PRINT_THEME_ORGP_HEADING; ?>');
			} else if (nodetype == 'Organization,Project') {
				loadComments(role);
			}
		}
	});
}

function loadConnectionData(role, filternodetypes, linktypename, title, orderby) {

	if (!orderby) {
		orderby='date';
	}

	var reqUrl = SERVICE_ROOT + "&method=getconnectionsbynode&style=short";
	reqUrl += "&orderby="+orderby+"&sort=DESC&filtergroup=selected&filterlist="+linktypename+"&filternodetypes="+filternodetypes+"&scope=all&start=0&max=-1&nodeid="+nodeid;

	//alert(reqUrl);

	new Ajax.Request(reqUrl, { method:'post',
  		onSuccess: function(transport){
  			var json = transport.responseText.evalJSON();
			if(json.error){
				alert(json.error[0].message);
				return;
			}
			var conns = json.connectionset[0].connections;

			if (conns.length == 0) {
				//$('printexplore').insert("No "+title+" listed");
			} else {
				var nodes = new Array();
				for(var i=0; i< conns.length; i++){
					var c = conns[i].connection;
					var fN = c.from[0].cnode;
					var tN = c.to[0].cnode;

					if (fN.nodeid != nodeid) {
						if (fN.name != "") {
							var next = c.from[0];
							next.cnode['connection'] = c;
							nodes.push(next);
						}
					} else if (tN.nodeid != nodeid) {
						if (tN.name != "") {
							var next = c.to[0];
							next.cnode['connection'] = c;
							nodes.push(next);
						}
					}
				}

				if (nodes.length > 0){
					$('printexplore').insert('<h2 style="clear:both; padding-top: 15px;">'+title+'</h2>');
					displayReportNodes($('printexplore'),nodes,parseInt(0), true);
				}
			}

			if (role == 'Organization' || role == 'Project') {
				if (filternodetypes == 'Challenge') {
					loadIssuesAddressed(role);
				} else if (filternodetypes == 'Issue') {
					if (hasSolution) {
						loadSolutionsSpecified(role);
					} else if (hasClaim) {
						loadClaimsMade(role);
					}
				} else if (filternodetypes == 'Solution') {
					if (hasClaim) {
						loadClaimsMade(role);
					} else {
						if (role == 'Organization') {
							loadProjectsManaged(role);
						} else {
							loadPartners(role);
						}
					}
				} else if (filternodetypes == 'Claim') {
					if (role == 'Organization') {
						loadProjectsManaged(role);
					} else {
						loadPartners(role);
					}
				} else if (filternodetypes == 'Project') {
					loadPartners(role);
				}
			} else if (role == 'Issue') {
				if (filternodetypes == 'Solution') {
					if (hasClaim) {
						loadClaimsResponding(role);
					} else {
						loadOrgsAddressing(role);
					}
				} else if (filternodetypes == 'Claim') {
					loadOrgsAddressing(role);
				} else if (filternodetypes == 'Organization,Project') {
					if (hasChallenge) {
						loadParentKeyChallenges(role);
					} else {
						loadComments(role);
					}
				} else if (filternodetypes == 'Challenge') {
					//$('printexplore').insert('<h2 style="clear:both; padding-top: 15px;">The Following Share <?php echo $LNG->THEMES_NAME; ?></h2>');
					//loadSolutionsSharedThemes(role);
					loadComments(role);
				}
			} else if (role == 'Challenge') {
				if (filternodetypes == 'Issue') {
					loadOrgsAddressing(role);
 				} else if (filternodetypes == 'Organization,Project') {
					loadURLs(role);
				}
			} else if (role == 'Solution') {
				if (filternodetypes == 'Challenge') {
					loadOrgsSpecifies(role);
				} else if (filternodetypes == 'Organization,Project') {
					loadAddressedIssues(role);
				} else if (filternodetypes == 'Issue') {
					//$('printexplore').insert('<h2 style="clear:both; padding-top: 15px;">The Following Share <?php echo $LNG->THEMES_NAME; ?></h2>');
					//loadChallengesSharedThemes(role);
					loadComments(role);
				}
			} else if (role == 'Claim') {
				if (filternodetypes == 'Challenge') {
					loadIssuesRespondedTo(role);
				} else if (filternodetypes == 'Issue') {
					loadOrgsClaiming(role);
				} else if (filternodetypes == 'Organization,Project') {
					//$('printexplore').insert('<h2 style="clear:both; padding-top: 15px;">The Following Share <?php echo $LNG->THEMES_NAME; ?></h2>');
					//loadChallengesSharedThemes(role);
					loadComments(role);
				}
			} else if (EVIDENCE_TYPES.indexOf(role) != -1) {
				if (filternodetypes == 'Solution') {
					if (hasClaim) {
						loadRelatedClaims(role);
					} else {
						//$('printexplore').insert('<h2 style="clear:both; padding-top: 15px;">The Following Share <?php echo $LNG->THEMES_NAME; ?></h2>');
						//loadChallengesSharedThemes(role);
						loadComments(role);
					}
				} else if (filternodetypes == 'Claim') {
					//$('printexplore').insert('<h2 style="clear:both; padding-top: 15px;">The Following Share <?php echo $LNG->THEMES_NAME; ?></h2>');
					//loadChallengesSharedThemes(role);
					loadComments(role);
				}
			} else if (role == 'Theme') {

			} else if (RESOURCE_TYPES.indexOf(role) != -1) {
				if (filternodetypes == 'Organization,Project') {
					if (hasChallenge) {
						loadRelatedKeyChallenges(role);
					} else {
						loadRelatedIssues(role);
					}
				} else if (filternodetypes == 'Challenge') {
					loadRelatedIssues(role);
				} else if (filternodetypes == 'Issue') {
					loadComments(role);
				}
			}
		}
	});
}

function loadPartners(role) {

	var reqUrl = SERVICE_ROOT + "&method=getconnectionsbynode&style=short";
	reqUrl += "&filterlist=partnered with&filternodetypes=Organization,Project&scope=all&start=0&max=-1&nodeid="+nodeid;

	new Ajax.Request(reqUrl, { method:'post',
		onSuccess: function(transport){
			var json = transport.responseText.evalJSON();
			if(json.error){
				alert(json.error[0].message);
				return;
			}
			var conns = json.connectionset[0].connections;

			if (conns.length == 0) {
				//$('printexplore').insert("No Partners listed");
			} else {
				var nodes = new Array();
				var check = new Array();

				for(var i=0; i< conns.length; i++){
					var c = conns[i].connection;
					var fN = c.from[0].cnode;
					var tN = c.to[0].cnode;

					var fnRole = c.fromrole[0].role;
					var tnRole = c.torole[0].role;

					if ((fnRole.name == 'Organization' || fnRole.name == 'Project') && fN.nodeid != nodeid) {
						if (fN.name != "") {
							if (!check[fN.nodeid]) {
								var next = c.from[0];
								next.cnode['connection'] = c;
								nodes.push(next);
								check[fN.nodeid] = fN.nodeid;
							}
						}
					} else if ((tnRole.name == 'Organization' || tnRole.name == 'Project') && tN.nodeid != nodeid) {
						if (tN.name != "") {
							if (!check[tN.nodeid]) {
								var next = c.to[0];
								next.cnode['connection'] = c;
								nodes.push(next);
								check[tN.nodeid] = tN.nodeid;
							}
						}
					}
				}

				if (nodes.length > 0){
					$('printexplore').insert('<h2 style="clear:both; padding-top: 15px;"><?php echo $LNG->FORM_PRINT_PARTNERS_HEADING; ?></h2>');
					displayReportNodes($('printexplore'),nodes,parseInt(0), true);
				} else {
					//$('printexplore').insert("No Partners listed");
				}
			}

			if (role == 'Organization' || role == 'Project') {
				//$('printexplore').insert('<h2 style="clear:both; padding-top: 15px;">The Following Share <?php echo $LNG->THEMES_NAME; ?></h2>');
				//loadChallengesSharedThemes(role);
				loadComments(role);
			}
		}
	});
}

function loadEvidence(role, nodetype, linktype, title) {

	var reqUrl = SERVICE_ROOT + "&method=getconnectionsbynode&style=short";
	reqUrl += "&orderby=vote&sort=DESC&filterlist="+linktype+"&filternodetypes="+nodetype+"&scope=all&start=0&max=-1&nodeid="+nodeid;
	new Ajax.Request(reqUrl, { method:'post',
  		onSuccess: function(transport){
  			var json = transport.responseText.evalJSON();
			if(json.error){
				alert(json.error[0].message);
				return;
			}
			var conns = json.connectionset[0].connections;

			if (conns.length == 0) {
				//$('printexplore').insert("No "+title+" listed");
			} else {
				var nodes = new Array();
				for(var i=0; i< conns.length; i++){
					var c = conns[i].connection;
					var fN = c.from[0].cnode;
					var tN = c.to[0].cnode;

					var fnRole = c.from[0].cnode.role[0].role; // c.fromrole[0].role;
					var tnRole = c.to[0].cnode.role[0].role; //c.torole[0].role;

					if (fN.nodeid != nodeid && EVIDENCE_TYPES.indexOf(fnRole.name) != -1) {
						if (fN.name != "") {
							var next = c.from[0];
							next.cnode['parentid'] = nodeid;
							next.cnode['connection'] = c;
							nodes.push(next);
						}
					} else if (tN.nodeid != nodeid && EVIDENCE_TYPES.indexOf(fnRole.name) != -1) {
						if (tN.name != "") {
							var next = c.to[0];
							next.cnode['parentid'] = nodeid;
							next.cnode['connection'] = c;
							nodes.push(next);
						}
					}
				}

				if (nodes.length > 0){
					$('printexplore').insert('<h2 style="clear:both; padding-top: 15px;">'+title+'</h2>');
					displayReportNodes($('printexplore'),nodes,parseInt(0), true);
				} else {
					//$('printexplore').insert("No "+title+" listed");
				}
			}

			if (role == 'Solution') {
				if (nodetype == "Pro") {
					loadEvidence(role, "Con", "challenges", "<?php echo $LNG->FORM_PRINT_SOLUTION_EVIDENCE_CON_HEADING; ?>")
				} else if (nodetype == "Con") {
					loadOrgsSpecifies(role);
				}
			} else if (role == 'Claim') {
				if (nodetype == "Pro") {
					loadEvidence(role, "Con", "challenges", "<?php echo $LNG->FORM_PRINT_CLAIM_EVIDENCE_CON_HEADING; ?>")
				} else if (nodetype == "Con") {
					loadIssuesRespondedTo(role);
				}
			} else if (role == 'Theme') {

			} else if (RESOURCE_TYPES.indexOf(role) != -1) {
				loadOrgsLinked(role);
			}

		}
	});
}

function loadChallengesSharedThemes(role) {
	loadSharedThemes(role, 'Challenge', 'Challenges');
}

function loadSolutionsSharedThemes(role) {
	loadSharedThemes(role, 'Solution', '<?php echo $LNG->FORM_PRINT_SHARED_THEMES_SOLUTION_HDEAING; ?>');
}

function loadClaimsSharedThemes(role) {
	loadSharedThemes(role, 'Claim', '<?php echo $LNG->FORM_PRINT_SHARED_THEMES_CLAIM_HDEAING; ?>');
}

function loadIssuesSharedThemes(role) {
	loadSharedThemes(role, 'Issue', '<?php echo $LNG->FORM_PRINT_SHARED_THEMES_ISSUE_HDEAING; ?>');
}

function loadOrgSharedThemes(role) {
	loadSharedThemes(role, 'Organization,Project', '<?php echo $LNG->FORM_PRINT_SHARED_THEMES_ORGP_HDEAING; ?>');
}

function loadSharedThemes(role, type, title) {

	// LOAD DATA
	var reqUrl = SERVICE_ROOT + "&method=getconnectionsbypathbydepth&style=short";
	reqUrl += "&depth=2&labelmatch=true&scope=all&start=0&max=-1&nodeid="+nodeid;

	reqUrl += "&linklabels[]=";
	reqUrl += "&linklabels[]=";

	reqUrl += "&nodetypes[]="+encodeURIComponent('Theme');
	reqUrl += "&nodetypes[]="+encodeURIComponent(type);

	reqUrl += "&directions[]="+encodeURIComponent('outgoing');
	reqUrl += "&directions[]="+encodeURIComponent('both');

	reqUrl += "&linkgroups[]="+encodeURIComponent('All');
	reqUrl += "&linkgroups[]="+encodeURIComponent('All');

	new Ajax.Request(reqUrl, { method:'post',
  		onSuccess: function(transport){
  			var json = transport.responseText.evalJSON();
			if(json.error){
				alert(json.error[0].message);
				return;
			}
			var conns = json.connectionset[0].connections;

			if (conns.length > 0) {
				var nodes = new Array();
				var check = new Array();
				var themes = new Array();

				for(var i=0; i< conns.length; i++){
					var c = conns[i].connection;
					var fN = c.from[0].cnode;
					var tN = c.to[0].cnode;

					var fnRole = c.fromrole[0].role;
					var tnRole = c.torole[0].role;

					if (type.indexOf(fnRole.name) != -1) {
						if (fN.name != "") {
							if (!check[fN.nodeid]) {
								nodes.push(c.from[0]);
								check[fN.nodeid] = fN.nodeid;
								themes[fN.nodeid] = tN.name;
							} else {
								if (themes[fN.nodeid].indexOf(tN.name) == -1) {
									themes[fN.nodeid] = themes[fN.nodeid]+", "+tN.name;
								}
							}

						}
					} else if (type.indexOf(tnRole.name) != -1) {
						if (tN.name != "") {
							if (!check[tN.nodeid]) {
								nodes.push(c.to[0]);
								check[tN.nodeid] = tN.nodeid;
								themes[fN.nodeid] = fN.name;
							} else {
								if (themes[fN.nodeid].indexOf(fN.name) == -1) {
									themes[fN.nodeid] = themes[fN.nodeid]+", "+fN.name;
								}
							}
						}
					}
				}

				for(var i=0; i< nodes.length; i++){
					var node = nodes[i];
					node.cnode['commonthemes'] = themes[node.cnode.nodeid];
				}

				if (nodes.length > 0) {
					$('printexplore').insert('<h3 style="clear:both; padding-top: 5px;">'+title+'</h3>');
					displayReportNodes($('printexplore'),nodes,parseInt(0), true);
				} else {
					$('printexplore').insert("<?php echo $LNG->FORM_PRINT_NONE_FOUND_PART1; ?> "+title+" <?php echo $LNG->FORM_PRINT_NONE_FOUND_PART2; ?>");
				}
			}

			if (role == 'Organization' || role == 'Project') {
				if (type == 'Challenge') {
					loadSolutionsSharedThemes(role);
				} else if (type == 'Solution') {
					loadClaimsSharedThemes(role);
				} else if (type == 'Claim') {
					loadComments(role);
				}
			} else if (role == 'Challenge') {
				if (type == 'Solution') {
					loadClaimsSharedThemes(role);
				} else if (type == 'Claim') {
					loadOrgSharedThemes(role);
				} else if (type == 'Organization,Project') {
					loadIssuesSharedThemes(role);
				} else if (type == 'Issue') {
					loadComments(role);
				}
			} else if (role == 'Issue') {
				if (type == 'Solution') {
					loadClaimsSharedThemes(role);
				} else if (type == 'Claim') {
					loadOrgSharedThemes(role);
				} else if (type == 'Organization,Project') {
					loadComments(role);
				}
			} else if (role == 'Solution') {
				if (type == 'Challenge') {
					loadOrgSharedThemes(role);
				} else if (type == 'Organization,Project') {
					loadComments(role);
				}
			} else if (role == 'Claim') {
				if (type == 'Challenge') {
					loadOrgSharedThemes(role);
				} else if (type == 'Organization,Project') {
					loadComments(role);
				}
			} else if (EVIDENCE_TYPES.indexOf(role) != -1) {
				if (type == 'Challenge') {
					loadSolutionsSharedThemes(role);
				} else if (type == 'Solution') {
					loadClaimsSharedThemes(role);
				} else if (type == 'Claim') {
					loadOrgSharedThemes(role);
				} else if (type == 'Organization,Project') {
					loadComments(role);
				}
			} else if (role == 'Theme') {
				//
			}

		}
	});
}

function loadComments(role) {

	var reqUrl = SERVICE_ROOT + "&method=getconnectionsbynode&style=short";
	reqUrl += "&orderby=vote&sort=DESC&filtergroup=selected&filterlist=supports,challenges,is related to&filternodetypes=Pro,Con,Comment,Question&scope=all&start=0&max=-1&nodeid="+nodeid;
	new Ajax.Request(reqUrl, { method:'post',
  		onSuccess: function(transport){
  			var json = transport.responseText.evalJSON();
			if(json.error){
				alert(json.error[0].message);
				return;
			}
			var conns = json.connectionset[0].connections;
			if (conns.length > 0) {
				var nodes = new Array();
				for(var i=0; i< conns.length; i++){
					var c = conns[i].connection;
					var fN = c.from[0].cnode;
					var tN = c.to[0].cnode;

					var fnRole = c.from[0].cnode.role[0].role;
					var tnRole = c.to[0].cnode.role[0].role;

					if (fN.nodeid != nodeid && COMMENT_TYPES.indexOf(fnRole.name) != -1) {
						if (fN.name != "") {
							var next = c.from[0];
							next.cnode['connection'] = c;
							nodes.push(next);
						}
					} else if (tN.nodeid != nodeid && COMMENT_TYPES.indexOf(tnRole.name) != -1) {
						if (tN.name != "") {
							var next = c.to[0];
							next.cnode['connection'] = c;
							nodes.push(next);
						}
					}
				}

				if (nodes.length > 0){
					$('printexplore').insert('<h2 style="clear:both; padding-top: 15px;"><?php echo $LNG->FORM_PRINT_COMMENTS_HEADING; ?></h2>');
					displayReportNodes($('printexplore'),nodes,parseInt(0), true);
				}
			}

			// all load followers after comments
			if (role == 'Organization' || role == 'Project') {
				loadFollowers(role);
			} else if (role == 'Challenge') {
				loadFollowers(role);
			} else if (role == 'Issue') {
				loadFollowers(role);
			} else if (role == 'Solution') {
				loadFollowers(role);
			} else if (role == 'Claim') {
				loadFollowers(role);
			} else if (EVIDENCE_TYPES.indexOf(role) != -1) {
				loadFollowers(role);
			} else if (RESOURCE_TYPES.indexOf(role) != -1) {
				loadFollowers(role);
			} else if (role == 'Theme') {
				loadFollowers(role);
			}
		}
	});
}

function loadFollowers(role) {
	var reqUrl = SERVICE_ROOT + "&method=getusersbyfollowing&itemid="+nodeid;
	new Ajax.Request(reqUrl, { method:'post',
  		onSuccess: function(transport){
  			var json = transport.responseText.evalJSON();
			if(json.error){
				alert(json.error[0].message);
				return;
			}
			var users = json.userset[0].users;

			if (users.length > 0) {
				$('printexplore').insert('<h2 style="clear:both; padding-top: 15px;"><?php echo $LNG->FORM_PRINT_FOLLOWERS_HEADING; ?></h2>');
				displayReportUsers($('printexplore'),users,parseInt(0));
			}

			$("loadingdiv").innerHTML = "";
		}
	});
}

/**
*  set which tab to show and load first
*/
Event.observe(window, 'load', function() {
	document.title = nodetitle;
	getNode();
});
//]]>
</script>

<h1 id="innertitle" style="clear:both; margin:10px;text-align:center;"></h1>

<input style="margin-left: 10px;margin-bottom:10px;" type="button" id="btnPrint" value=" <?php echo $LNG->FORM_BUTTON_PRINT_PAGE; ?> " onclick="window.print();return false;" />

<div id="printexplore" style="margin: 10px;"></div>

<div id="loadingdiv" class="loading" style="clear:both; float:left"><img src='<?php echo $HUB_FLM->getImagePath("ajax-loader.gif"); ?>'/><br/><?php echo $LNG->LOADING_DATA; ?><br><center><?php echo $LNG->FORM_PRINT_LOADING_MESSAGE; ?></center></div>

</div>

<?php
    include_once($HUB_FLM->getCodeDirPath("ui/footerreport.php"));
?>