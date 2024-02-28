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

var CURRENT_ADD_AREA = null;
var CURRENT_ADD_AREA_NODEID = null;
var CURRENT_ADD_AREA_NODE = null;
var CURRENT_ADD_AREA_HAS_UP = null

var CHAT_LOADED_ARRAY = {};
var CHAT_TIMER = null;

var DEBATE_TREE_SMALL = true;
var DEBATE_LOADED_ARRAY = {};
var DEBATE_TIMER = null;

function toggleDebateMode() {
	if ($('toggleDebateButton').innerHTML == "<?php echo $LNG->DEBATE_SWITCH_WIDER_BUTTON; ?>") {
		DEBATE_TREE_SMALL = false;
		$('toggleDebateButton').innerHTML = "<?php echo $LNG->DEBATE_SWITCH_NARROW_BUTTON; ?>";
		$('toggleDebateButton').title = "<?php echo $LNG->DEBATE_SWITCH_NARROW_HINT; ?>";
		drawDebates(false, "");
	} else {
		DEBATE_TREE_SMALL = true;
		$('toggleDebateButton').innerHTML = "<?php echo $LNG->DEBATE_SWITCH_WIDER_BUTTON; ?>";
		$('toggleDebateButton').title = "<?php echo $LNG->DEBATE_SWITCH_WIDER_HINT; ?>";
		drawDebates(false, "");
	}
}

function getExploreViz(viz) {
	if (viz == "" ||
		(viz != "linear" && viz != "widget" && viz != "net")) {

		viz = DEFAULT_VIZ;

		var allcookies = document.cookie;
		if (allcookies != null) {
			var cookiearray  = allcookies.split(';');

			for(var i=0; i<cookiearray.length; i++){
				var param = cookiearray[i].split('=');
				var name = param[0];
			    var value = param[1];
				if (name.trim() == COOKIE_NAME) {
					viz = value;
				}
			}
		}

		if (viz == "") {
			viz = DEFAULT_VIZ;
		}
	} else {
		if (viz != "net") {
			var date = new Date();
			date.setTime(date.getTime()+(365*24*60*60*1000)); // 365 days
			document.cookie = COOKIE_NAME + "=" + viz + "; expires=" + date.toGMTString();
			//document.cookie = COOKIE_NAME + "=" + viz;
		}
	}
	return viz;
}

function buildNodeTitle(from) {

	var nodeid = nodeObj.nodeid;
	var nodetype = nodeObj.role.name;
	var name = nodeObj.name;
	if (RESOURCE_TYPES_STR.indexOf(nodetype) != -1) {
		name = nodeObj.description;
	}

	var title=getNodeTitleAntecedence(nodetype, true);
	var icon = nodeObj.role.image;
	var widgetHeaderLabel = $('exploreheaderlabel');
	if (widgetHeaderLabel) {
		if (icon) {
			icon = URL_ROOT+icon;
			var iconObj = new Element('img',{'style':'text-align: middle;margin-right: 5px; width:24px; height:24px;', 'title':title, 'alt':title+' Icon', 'border':'0','src':icon});
			iconObj.align='left';
			widgetHeaderLabel.appendChild(iconObj);
		}

		widgetHeaderLabel.insert("<span style='font-size:90%;font-style:italic'>"+title+"</span> "+name);
	}

	var nodetype = nodeObj.role.name;
	var title=getNodeTitleAntecedence(nodetype);
	var type = '';
	if (nodetype == 'Challenge') {
		type = 'challenge';
	} else if (nodetype == 'Issue') {
		type = 'issue';
	} else if (nodetype == 'Claim') {
		type = 'claim';
	} else if (nodetype == 'Solution') {
		type = 'solution';
	} else if (nodetype == 'Organization') {
		type = 'org';
	} else if (nodetype == 'Project') {
		type = 'project';
	} else if (nodetype == "Theme") {
		type = 'theme'
	} else if (EVIDENCE_TYPES_STR.indexOf(type) != -1) {
		type = 'evidence';
	} else if (RESOURCE_TYPES_STR.indexOf(type) != -1) {
		type = 'web';
	} else if (nodetype == "News") {
		type = 'news';
	}

	if (type != 'news') {
		buildExploreToolbar($('headertoolbar'), title+name, type, nodeObj, from);
	}
}

function buildSearchTitle(type, query, tagsonly) {

	//var name = search;
	var widgetHeaderLabel = $('exploreheaderlabel');
	if (widgetHeaderLabel) {
		if (type == 'tree') {
			if (tagsonly == true) {
				widgetHeaderLabel.insert('<span style="font-style:italic;font-size:10pt"><?php echo $LNG->SEARCH_TREE_TITLE_TAGS; ?></span> '+query);
			} else {
				widgetHeaderLabel.insert('<span style="font-style:italic;font-size:10pt"><?php echo $LNG->SEARCH_TREE_TITLE; ?></span> '+query);
			}
		} else if (type == 'net') {
			if (tagsonly == true) {
				widgetHeaderLabel.insert('<span style="font-style:italic;font-size:10pt"><?php echo $LNG->SEARCH_NET_TITLE_TAGS; ?></span> '+query);
			} else {
				widgetHeaderLabel.insert('<span style="font-style:italic;font-size:10pt"><?php echo $LNG->SEARCH_NET_TITLE; ?></span> '+query);
			}
		}
	}
}

function buildExploreToolbar(container, name, type, node, from) {

	var nodeid = node.nodeid;

	// parent list button
	if (type == 'issue') {
		var homelink = new Element('a',{'style':'float:left;margin-right:10px;margin-top:10px;'});
		homelink.href="<?php echo $CFG->homeAddress; ?>index.php?#issue-list";
		var homebutton = new Element('img',{'class':'active','border':'0','src': '<?php echo $HUB_FLM->getImagePath("list.png"); ?>', 'style':'margin-right: 5px;', 'title':'<?php echo $LNG->ISSUE_HOME_LIST_BUTTON_HINT; ?>'});
		homelink.insert(homebutton);
		container.insert(homelink);
	} else if (type == 'challenge') {
		var homelink = new Element('a',{'style':'float:left;margin-right:10px;margin-top:10px;'});
		homelink.href="<?php echo $CFG->homeAddress; ?>index.php?#challenge-list";
		var homebutton = new Element('img',{'class':'active','border':'0','src': '<?php echo $HUB_FLM->getImagePath("list.png"); ?>', 'style':'margin-right: 5px;', 'title':'<?php echo $LNG->CHALLENGE_HOME_LIST_BUTTON_HINT; ?>'});
		homelink.insert(homebutton);
		container.insert(homelink);
	} else if (type == 'claim') {
		var homelink = new Element('a',{'style':'float:left;margin-right:10px;margin-top:10px;'});
		homelink.href="<?php echo $CFG->homeAddress; ?>index.php?#claim-list";
		var homebutton = new Element('img',{'class':'active','border':'0','src': '<?php echo $HUB_FLM->getImagePath("list.png"); ?>', 'style':'margin-right: 5px;', 'title':'<?php echo $LNG->CLAIM_HOME_LIST_BUTTON_HINT; ?>'});
		homelink.insert(homebutton);
		container.insert(homelink);
	} else if (type == 'solution') {
		var homelink = new Element('a',{'style':'float:left;margin-right:10px;margin-top:10px;'});
		homelink.href="<?php echo $CFG->homeAddress; ?>index.php?#solution-list";
		var homebutton = new Element('img',{'class':'active','border':'0','src': '<?php echo $HUB_FLM->getImagePath("list.png"); ?>', 'style':'margin-right: 5px;', 'title':'<?php echo $LNG->SOLUTION_HOME_LIST_BUTTON_HINT; ?>'});
		homelink.insert(homebutton);
		container.insert(homelink);
	} else if (type == 'org') {
		var homelink = new Element('a',{'style':'float:left;margin-right:10px;margin-top:10px;'});
		homelink.href="<?php echo $CFG->homeAddress; ?>index.php?#org-list";
		var homebutton = new Element('img',{'class':'active','border':'0','src': '<?php echo $HUB_FLM->getImagePath("list.png"); ?>', 'style':'margin-right: 5px;', 'title':'<?php echo $LNG->ORG_HOME_LIST_BUTTON_HINT; ?>'});
		homelink.insert(homebutton);
		container.insert(homelink);
	} else if (type == 'project') {
		var homelink = new Element('a',{'style':'float:left;margin-right:10px;margin-top:10px;'});
		homelink.href="<?php echo $CFG->homeAddress; ?>index.php?#project-list";
		var homebutton = new Element('img',{'class':'active','border':'0','src': '<?php echo $HUB_FLM->getImagePath("list.png"); ?>', 'style':'margin-right: 5px;', 'title':'<?php echo $LNG->PROJECT_HOME_LIST_BUTTON_HINT; ?>'});
		homelink.insert(homebutton);
		container.insert(homelink);
	} else if (type == 'evidence') {
		var homelink = new Element('a',{'style':'float:left;margin-right:10px;margin-top:10px;'});
		homelink.href="<?php echo $CFG->homeAddress; ?>index.php?#evidence-list";
		var homebutton = new Element('img',{'class':'active','border':'0','src': '<?php echo $HUB_FLM->getImagePath("list.png"); ?>', 'style':'margin-right: 5px;', 'title':'<?php echo $LNG->EVIDENCE_HOME_LIST_BUTTON_HINT; ?>'});
		homelink.insert(homebutton);
		container.insert(homelink);
	}  else if (type == 'web') {
		var homelink = new Element('a',{'style':'float:left;margin-right:10px;margin-top:10px;'});
		homelink.href="<?php echo $CFG->homeAddress; ?>index.php?#web-list";
		var homebutton = new Element('img',{'class':'active','border':'0','src': '<?php echo $HUB_FLM->getImagePath("list.png"); ?>', 'style':'margin-right: 5px;', 'title':'<?php echo $LNG->RESOURCE_HOME_LIST_BUTTON_HINT; ?>'});
		homelink.insert(homebutton);
		container.insert(homelink);
	}

	// print button
	var print = new Element("img",
		{'src': '<?php echo $HUB_FLM->getImagePath("printer.png"); ?>',
		'alt': '<?php echo $LNG->EXPLORE_PRINT_BUTTON_ALT;?>',
		'title': '<?php echo $LNG->EXPLORE_PRINT_BUTTON_HINT;?>',
		'class': 'active',
		'style': 'float:left;padding-top:0px;padding-right:10px;margin-top:10px;'});
	container.insert(print);
	Event.observe(print,'click',function(){
		 if (from == 'trees') {
			 printKnowledgeTreeExplore(NODE_ARGS, name, nodeid, node.name);
		 } else {
			 printNodeExplore(NODE_ARGS, name, nodeid);
		 }
	});

	// Add spam icon
	var spaming = new Element('img', {'style':'float:left;padding-top:0px;padding-right:10px;margin-top:10px;'});
	if (node.status == <?php echo $CFG->STATUS_SPAM; ?>) {
		spaming.setAttribute('alt', '<?php echo $LNG->SPAM_REPORTED_TEXT; ?>');
		spaming.setAttribute('title', '<?php echo $LNG->SPAM_REPORTED_HINT; ?>');
		spaming.setAttribute('src', '<?php echo $HUB_FLM->getImagePath('spam-reported.png'); ?>');
	} else if (node.status == <?php echo $CFG->STATUS_ACTIVE; ?>) {
		if(USER != ""){
			spaming.setAttribute('alt', '<?php echo $LNG->SPAM_REPORT_TEXT; ?>');
			spaming.setAttribute('title', '<?php echo $LNG->SPAM_REPORT_HINT; ?>');
			spaming.setAttribute('src', '<?php echo $HUB_FLM->getImagePath('spam.png'); ?>');
			spaming.style.cursor = 'pointer';
			Event.observe(spaming,'click',function (){ reportNodeSpamAlert(this, type, node); } );
		} else {
			spaming.setAttribute('alt', '<?php echo $LNG->SPAM_LOGIN_REPORT_TEXT; ?>');
			spaming.setAttribute('title', '<?php echo $LNG->SPAM_LOGIN_REPORT_HINT; ?>');
			spaming.setAttribute('src', '<?php echo $HUB_FLM->getImagePath('spam-disabled.png'); ?>');
			spaming.style.cursor = 'pointer';
			Event.observe(spaming,'click',function (){ $('loginsubmit').click(); return true; } );
		}
	}
	container.insert(spaming);

	// edit button
	if (USER != "") {
		var userid = node.users[0].userid;
		if (userid == USER) {
			var otheruserconnections = node.otheruserconnections;

			if (type == 'issue') {
				var edit = new Element('img',{'style':'float:left;cursor: pointer;margin-top:10px;','alt':'<?php echo $LNG->EDIT_BUTTON_TEXT;?>', 'title': '<?php echo $LNG->EDIT_BUTTON_HINT_ISSUE;?>', 'border':'0','src': '<?php echo $HUB_FLM->getImagePath("edit.png"); ?>'});
				Event.observe(edit,'click',function (){loadDialog('editissue',URL_ROOT+"ui/popups/issueedit.php?nodeid="+nodeid, 770,500)});
				container.appendChild(edit);
			} if (type == 'challenge') {
				var edit = new Element('img',{'style':'float:left;cursor: pointer;margin-top:10px;','alt':'<?php echo $LNG->EDIT_BUTTON_TEXT;?>', 'title': '<?php echo $LNG->EDIT_BUTTON_HINT_CHALLENGE;?>', 'border':'0','src': '<?php echo $HUB_FLM->getImagePath("edit.png"); ?>'});
				Event.observe(edit,'click',function (){loadDialog('editchallenge',URL_ROOT+"ui/popups/challengeedit.php?nodeid="+nodeid, 770,500)});
				container.appendChild(edit);
			} else if (type == 'claim') {
				var edit = new Element('img',{'style':'float:left;cursor: pointer;margin-top:10px;','alt':'<?php echo $LNG->EDIT_BUTTON_TEXT;?>', 'title': '<?php echo $LNG->EDIT_BUTTON_HINT_CLAIM;?>', 'border':'0','src': '<?php echo $HUB_FLM->getImagePath("edit.png"); ?>'});
				Event.observe(edit,'click',function (){loadDialog('editclaim',URL_ROOT+"ui/popups/claimedit.php?nodeid="+nodeid, 770,500)});
				container.appendChild(edit);
			} else if (type == 'solution') {
				var edit = new Element('img',{'style':'float:left;cursor: pointer;margin-top:10px;','alt':'<?php echo $LNG->EDIT_BUTTON_TEXT;?>', 'title': '<?php echo $LNG->EDIT_BUTTON_HINT_SOLUTION;?>', 'border':'0','src': '<?php echo $HUB_FLM->getImagePath("edit.png"); ?>'});
				Event.observe(edit,'click',function (){loadDialog('editsolution',URL_ROOT+"ui/popups/solutionedit.php?nodeid="+nodeid, 770,500)});
				container.appendChild(edit);
			} else if (type == 'org' || type == 'project') {
				var edit = new Element('img',{'style':'float:left;cursor: pointer;margin-top:10px;','alt':'<?php echo $LNG->EDIT_BUTTON_TEXT;?>', 'title': '<?php echo $LNG->EDIT_BUTTON_HINT_ITEM;?>', 'border':'0','src': '<?php echo $HUB_FLM->getImagePath("edit.png"); ?>'});
				Event.observe(edit,'click',function (){loadDialog('editorg',URL_ROOT+"ui/popups/organizationedit.php?nodeid="+nodeid, 770,500)});
				container.appendChild(edit);
			} else if (type == 'evidence') {
				var edit = new Element('img',{'style':'float:left;cursor: pointer;margin-top:10px;','alt':'<?php echo $LNG->EDIT_BUTTON_TEXT;?>', 'title': '<?php echo $LNG->EDIT_BUTTON_HINT_EVIDENCE;?>', 'border':'0','src': '<?php echo $HUB_FLM->getImagePath("edit.png"); ?>'});
				Event.observe(edit,'click',function (){loadDialog('editevidence',URL_ROOT+"ui/popups/evidenceedit.php?nodeid="+nodeid, 770,500)});
				container.appendChild(edit);
			}  else if (type == 'web') {
				var edit = new Element('img',{'style':'float:left;cursor: pointer;margin-top:10px;','alt':'<?php echo $LNG->EDIT_BUTTON_TEXT;?>', 'title': '<?php echo $LNG->EDIT_BUTTON_HINT_RESOURCE;?>', 'border':'0','src': '<?php echo $HUB_FLM->getImagePath("edit.png"); ?>'});
				Event.observe(edit,'click',function (){loadDialog('editresource',URL_ROOT+"ui/popups/resourceedit.php?nodeid="+nodeid, 770,500)});
				container.appendChild(edit);
			}

			if (otheruserconnections == 0) {
				var del = new Element('img',{'style':'float:left;cursor: pointer;margin-top:10px;padding-left:5px;margin-right: 10px','alt':'<?php echo $LNG->DELETE_BUTTON_ALT;?>', 'title': '<?php echo $LNG->DELETE_BUTTON_HINT;?>', 'border':'0','src': '<?php echo $HUB_FLM->getImagePath("delete.png"); ?>'});
				Event.observe(del,'click',function (){
					deleteNode(node.nodeid, node.name, node.role.name, 'gotoHomeList', type);
				});
				container.appendChild(del);
			} else {
				var del = new Element('img',{'alt':'<?php echo $LNG->NO_DELETE_BUTTON_ALT;?>', 'title': '<?php echo $LNG->NO_DELETE_BUTTON_HINT;?>', 'style':'float:left;padding-left:5px;float:left;margin-top:10px;margin-right: 10px', 'border':'0','src': '<?php echo $HUB_FLM->getImagePath("delete-off.png"); ?>'});
				container.appendChild(del);
			}
		}
	}

	// follow button
	if (USER != "") {
		var followbutton = new Element('img', {'style':'float:left;padding-top:0px;margin-top:10px;'});
		followbutton.setAttribute('src', '<?php echo $HUB_FLM->getImagePath("follow.png"); ?>');
		followbutton.setAttribute('alt', 'Follow');
		followbutton.setAttribute('id','follow'+nodeid);
		followbutton.nodeid = nodeid;
		followbutton.style.marginRight="3px";
		followbutton.style.cursor = 'pointer';

		container.insert(followbutton);

		if (node.userfollow && node.userfollow == "Y") {
			Event.observe(followbutton,'click',function (){ unfollowNode(node, this, "refreshWidgetFollowers()") } );
			followbutton.setAttribute('src', '<?php echo $HUB_FLM->getImagePath("follow.png"); ?>');
			followbutton.setAttribute('title', '<?php echo $LNG->NODE_UNFOLLOW_ITEM_HINT; ?>');
		} else {
			Event.observe(followbutton,'click',function (){ followNode(node, this, "refreshWidgetFollowers()") } );
			followbutton.setAttribute('src', '<?php echo $HUB_FLM->getImagePath("follow.png"); ?>');
			followbutton.setAttribute('title', '<?php echo $LNG->NODE_FOLLOW_ITEM_HINT; ?>');
		}
	} else {
		container.insert("<img style='float:left;padding-top:0px;margin-top:10px;cursor:pointer' onclick='$(\"loginsubmit\").click(); return true;' title='<?php echo $LNG->WIDGET_FOLLOW_SIGNIN_HINT; ?>' src='<?php echo $HUB_FLM->getImagePath("followgrey.png"); ?>' border='0' />");
	}

	// add explore button on all non explore views
	if (from != 'explore') {
		var explore = new Element('a',{'style':'float:left;margin-left:20px;margin-right:5px;margin-bottom:5px;'});
		explore.href="<?php echo $CFG->homeAddress; ?>explore.php?id="+nodeid;
		var image = new Element('img',{'class':'active','border':'0','src': '<?php echo $HUB_FLM->getImagePath("explore.png"); ?>', 'style':'margin-right: 5px;width:26px; height:26px;padding:3px;'});
		explore.insert(image);
		explore.title = '<?php echo $LNG->NODE_DETAIL_BUTTON_HINT;?>';
		container.appendChild(explore);
		//if (from == 'explore') {
		//	image.style.border = "1px dashed blue";
		//}
	}

	// Add Chat view button
	var chat = new Element('a',{'style':'float:left;margin-right:5px;margin-bottom:5px;'});
	if (from == 'explore') {
		chat.style.marginLeft ='20px';
	}
	chat.href="<?php echo $CFG->homeAddress; ?>chats.php?id="+nodeid;
	var image = new Element('img',{'class':'active','border':'0','src': '<?php echo $HUB_FLM->getImagePath("chat.png"); ?>', 'style':'margin-right: 5px;width:26px; height:26px;padding:3px;'});
	chat.insert(image);
	chat.title = '<?php echo $LNG->VIEWS_CHAT_HINT;?>';
	container.appendChild(chat);
	if (from == 'chat') {
		image.style.border = "1px dashed blue";
	}

	// Add Linear/tree view button
	if (type != 'org' && type != 'project') {
		var tree = new Element('a',{'style':'float:left;margin-right:5px;margin-bottom:5px;'});
		tree.href="<?php echo $CFG->homeAddress; ?>knowledgetrees.php?id="+nodeid;
		var image = new Element('img',{'class':'active','border':'0','src': '<?php echo $HUB_FLM->getImagePath("knowledge-tree2.png"); ?>', 'style':'margin-right: 5px;width:30px; height:30px;padding:0px;'});
		tree.insert(image);
		tree.title = '<?php echo $LNG->VIEWS_LINEAR_HINT;?>';
		container.appendChild(tree);
		if (from == 'trees') {
			image.style.border = "1px dashed blue";
		}
	}

	// Add Network view button
	var net = new Element('a',{'style':'float:left;margin-right:0px;margin-bottom:5px;'});
	net.href="<?php echo $CFG->homeAddress; ?>networkgraph.php?id="+nodeid;
	var image = new Element('img',{'class':'active','border':'0','src': '<?php echo $HUB_FLM->getImagePath("network-graph.png"); ?>', 'style':'margin-right: 5px;width:26px; height:26px;padding:3px;'});
	net.insert(image);
	net.title = '<?php echo $LNG->VIEWS_EVIDENCE_MAP_HINT;?>';
	container.appendChild(net);
	if (from == 'network') {
		image.style.border = "1px dashed blue";
	}

	// Add Debate View button only on Issues
	<?php if ($CFG->hasIssueDebateView) { ?>
		if (type == 'issue' && from != 'debate') {
			var net = new Element('a',{'style':'float:left;margin-right:0px;margin-bottom:5px;'});
			net.href="<?php echo $CFG->homeAddress; ?>debate.php?id="+nodeid;
			var image = new Element('img',{'class':'active','border':'0','src': '<?php echo $HUB_FLM->getImagePath("debate.png"); ?>', 'style':'margin-right: 5px;width:26px; height:26px;padding:3px;'});
			net.insert(image);
			net.title = '<?php echo $LNG->VIEWS_DEBATE_MAP_HINT;?>';
			container.appendChild(net);
			if (from == 'debate') {
				image.style.border = "1px dashed blue";
			}
		}
	<?php } ?>
}

function buildChatHeader() {

	var keyDiv = new Element("div", {'style':'float:left;margin-left:40px;padding:2px;'});
	keyDiv.className = 'plainborder';
	keyDiv.style.borderWidth = "1px";
	keyDiv.style.borderStyle = "dotted";
	keyDiv.insert('<?php echo $LNG->CHAT_HIGHLIGHT_NEWEST_TEXT; ?>');

	if (USER != "") {
		var toolbar = new Element("div", {'id':'commenttoolbar', 'class':'widgetheaderinner ', 'style':'padding-top:10px;padding-left:10px;'});
		var link = new Element("a", {'title':"<?php echo $LNG->CHAT_ADD_BUTTON_HINT; ?>", 'style':'float:left;cursor:pointer'});
		link.insert('<span id="linkbutton"><img style="vertical-align:bottom" src="<?php echo $HUB_FLM->getImagePath('add.png'); ?>" border="0" width="20" height="20" style="margin:0px;padding:0px" /> <?php echo $LNG->CHAT_ADD_BUTTON_TEXT; ?></span>');
		Event.observe(link,"click", function(){
			$('commenthidden').style.display = 'block';
			$('commenthidden').style.height = "95px";
			$('comment').style.height = "60px";
			$('commenttoolbar').style.display = 'none';
			$('comment').focus();
		});
		toolbar.insert(link);

		toolbar.insert(keyDiv);

		$('chattoolbar').update(toolbar);

		var hidden = new Element("div", {'class':'widgetheaderinner', 'id':'commenthidden','class':'commentdiv', 'style':'background:#E8E8E8 ;display:none;width:100%'});
		$('chattoolbar').insert(hidden);

		var box = new Element("textarea", {'value':'', 'id':'comment', 'rows':'1'});
		box.style.width = "98%";
		hidden.insert(box);

		var button = new Element("input", {'value':'<?php echo $LNG->WIDGET_ADD_BUTTON; ?>', 'type':'button', 'style':'vertical-align: bottom'});
		Event.observe(button,"click", function(){
			var comment = $('comment').value;
			$('comment').value = "";
			$("chatarea").style.display = 'block';
			$('commenthidden').style.display = 'none';
			$('commenttoolbar').style.display = 'block';
			if (comment != "") {
				var type = "Comment";
				var reqUrl = SERVICE_ROOT + "&method=connectnodetocomment&nodetypename="+type+"&nodeid="+chatnodeid+"&comment="+encodeURIComponent(comment);
				new Ajax.Request(reqUrl, { method:'get',
						onSuccess: function(transport){
							var json = transport.responseText.evalJSON();
							if(json.error){
								alert(json.error[0].message);
							} else {
								getAllChatConnections();
							}
						}
				});
			}
		});

		hidden.insert(button);

		var button = new Element("input", {'value':'<?php echo $LNG->FORM_BUTTON_CLOSE; ?>', 'type':'button', 'style':'vertical-align: bottom'});
		Event.observe(button,"click", function(){
			$('comment').value = "";
			$('chatarea').style.display = 'block';
			$('commenthidden').style.display = 'none';
			$('commenttoolbar').style.display = 'block';
		});

		hidden.insert(button);
	} else {
		var toolbar = new Element("div", {'id':'commenttoolbar', 'class':'widgetheaderinner ', 'style':'float:left;padding-top:10px;padding-left:10px;'});
		let spancontent = '<span style="float:left;cursor:pointer" onclick="$(\'loginsubmit\').click(); return true;" title="';
		spancontent += "<?php echo $LNG->WIDGET_SIGNIN_HINT; ?>";
		spancontent += '"><img style="vertical-align:bottom" src="<?php echo $HUB_FLM->getImagePath('addgrey.png'); ?>" border="0" width="16" height="16" style="margin:0px;margin-left: 5px;padding:0px" /> <?php echo $LNG->CHAT_ADD_BUTTON_TEXT; ?></span>';
		toolbar.insert(spancontent);
		toolbar.insert(keyDiv);
		$('chattoolbar').insert(toolbar);
	}
}

function checkWiderDebateStillLoading(nodetofocusid) {
	if (!DEBATE_TREE_SMALL) {
		var stillLoading = false;
		for(var ind in DEBATE_LOADED_ARRAY){
			var next = DEBATE_LOADED_ARRAY[ind];
			if (next == false) {
				stillLoading = true;
				break;
			}
		}
		if (!stillLoading) {
			clearTimeout(DEBATE_TIMER);
			$('lineardebateheading').innerHTML = "";
			checkDebateHasNode(nodetofocusid);
		} else {
			DEBATE_TIMER = setTimeout("checkWiderDebateStillLoading('"+nodetofocusid+"')", 350);
		}
	} else {
		// should never get here, but just in case;
		clearTimeout(DEBATE_TIMER);
	}
}

function checkChatStillLoading(nodetofocusid) {
	var stillLoading = false;
	for(var ind in CHAT_LOADED_ARRAY){
		var next = CHAT_LOADED_ARRAY[ind];
		if (next == false) {
			stillLoading = true;
			break;
		}
	}
	if (!stillLoading) {
		clearTimeout(CHAT_TIMER);
		$('chatloading').update("");
		checkChatHasNode();
	} else {
		CHAT_TIMER = setTimeout("checkChatStillLoading('"+nodetofocusid+"')", 350);
	}
}

/**
 * Log a known user opeing a chat page
 * @param nodeid the id of the node
 */
function logChatUserArrive(nodeid) {
	var args = {};
	args["nodeid"] = nodeid;

	var reqUrl = SERVICE_ROOT + "&method=logchatuserarrive&" + Object.toQueryString(args);
	new Ajax.Request(reqUrl, { method:'get',
		onSuccess: function(transport){
			var json = transport.responseText.evalJSON();
			if(json.error){
				alert(json.error[0].message);
				return;
			} else {
				//console.log("arrive:"+transport.responseText);
				updateCurrentChatUsers(nodeid);
			}
		}
	});

	return;
}

/**
 * Log a known user closing a chat page
 * @param nodeid the id of the node
 */
function logChatUserLeave(nodeid) {
	var args = {};
	args["nodeid"] = nodeid;

	var reqUrl = SERVICE_ROOT + "&method=logchatuserleave&" + Object.toQueryString(args);
	new Ajax.Request(reqUrl, { method:'get',
		onSuccess: function(transport){
			var json = transport.responseText.evalJSON();
			if(json.error){
				alert(json.error[0].message);
				return;
			} else {
				//console.log("leave:"+transport.responseText);
			}
		}
	});

	return;
}

/**
 * Get the Chat user presence for the given node
 * @param nodeid the id of the node
 */
function updateCurrentChatUsers(nodeid) {
	var args = {};
	args["nodeid"] = nodeid;

	var reqUrl = SERVICE_ROOT + "&method=getchatpresence&" + Object.toQueryString(args);
	new Ajax.Request(reqUrl, { method:'get',
		onSuccess: function(transport){
			var json = transport.responseText.evalJSON();
			if(json.error){
				alert(json.error[0].message);
				return;
			} else {
				var users = json.userset[0].users;
				$('current-chat-users').update("");
				displayChatUsers($('current-chat-users'),users,0);
			}
		}
	});

	return;
}
