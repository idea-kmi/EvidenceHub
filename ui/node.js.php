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
   include_once("../config.php");
   include_once($HUB_FLM->getCodeDirPath("ui/popuplib.php"));
?>

/**
 * Javascript functions for nodes
 */

/**
 * Render a list of nodes
 */
function displayWidgetNodes(objDiv,nodes,start,includeUser,uniqueid){
	if (uniqueid == undefined) {
		uniqueid = 'widget-list';
	}
	var lOL = new Element("ol", {'start':start, 'class':'idea-list-ol'});
	for(var i=0; i < nodes.length; i++){
		if(nodes[i].cnode){
			var iUL = new Element("li", {'id':nodes[i].cnode.nodeid, 'class':'idea-list-li'});
			lOL.insert(iUL);
			var blobDiv = new Element("div", {'class':'idea-blob-list'});
			var blobNode = renderWidgetListNodeMini(nodes[i].cnode, uniqueid+i+start, nodes[i].cnode.role[0].role,includeUser);
			blobDiv.insert(blobNode);
			iUL.insert(blobDiv);
		}
	}
	objDiv.insert(lOL);
}

/**
 * Render a list of nodes in the Chat tree
 */
function displayChatNodes(objDiv,nodes,start,includeUser,uniqueid, childCountSpan){
	if (uniqueid == undefined) {
		uniqueid = 'widget-list';
	}
	var lOL = new Element("ol", {'start':start, 'class':'idea-list-ol'});
	for(var i=0; i < nodes.length; i++){
		if(nodes[i].cnode){
			var iUL = new Element("li", {'id':nodes[i].cnode.nodeid, 'class':'idea-list-li'});
			lOL.insert(iUL);
			var blobDiv = new Element("div", {'class':'idea-blob-list'});
			var blobNode = renderChatNode(nodes[i].cnode, uniqueid+i+start, nodes[i].cnode.role[0].role,includeUser,'active', childCountSpan);
			blobDiv.insert(blobNode);
			iUL.insert(blobDiv);
		}
	}
	objDiv.insert(lOL);
}

/**
 * Render a list of connection nodes
 */
function displayConnectionNodes(objDiv, nodes,start,includeUser,uniqueid, childCountSpan, parentrefreshhandler){
	if (uniqueid == undefined) {
		uniqueid = 'idea-list';
	}

	var lOL = new Element("ol", {'start':start, 'class':'idea-list-ol'});
	for(var i=0; i < nodes.length; i++){
		if(nodes[i].cnode){
			var iUL = new Element("li", {'id':nodes[i].cnode.nodeid, 'class':'idea-list-li'});
			lOL.insert(iUL);
			var blobDiv = new Element("div", {'class':'idea-blob-list'});
			var blobNode = renderConnectionNode(nodes[i].cnode, uniqueid,nodes[i].cnode.role[0].role,includeUser,'active', childCountSpan, parentrefreshhandler);
			blobDiv.insert(blobNode);
			iUL.insert(blobDiv);
		}
	}

	objDiv.insert(lOL);
}

/**
 * Render a list of nodes
 */
function displayHomeNodes(objDiv,nodes,start,includeUser,uniqueid){
	if (uniqueid == undefined) {
		uniqueid = 'home-list';
	}
	var lOL = new Element("ol", {'start':start, 'class':'idea-list-ol'});
	for(var i=0; i < nodes.length; i++){
		if(nodes[i].cnode){
			var iUL = new Element("li", {'id':nodes[i].cnode.nodeid, 'class':'idea-list-li'});
			lOL.insert(iUL);
			var blobDiv = new Element("div", {'class':'idea-blob-list'});
			var blobNode = renderNodeMini(nodes[i].cnode, uniqueid+i+start,nodes[i].cnode.role[0].role,includeUser,'active', "", false, false);
			blobDiv.insert(blobNode);
			iUL.insert(blobDiv);
		}
	}
	objDiv.insert(lOL);
}

/**
 * Render a list of nodes
 */
function displayNodes(objDiv,nodes,start,includeUser,uniqueid,includevoting){
	if (uniqueid == undefined) {
		uniqueid = 'idea-list';
	}
	if (includevoting == undefined) {
		includevoting = true;
	}
	var lOL = new Element("ol", {'start':start, 'class':'idea-list-ol'});
	for(var i=0; i < nodes.length; i++){
		if(nodes[i].cnode){
			var iUL = new Element("li", {'id':nodes[i].cnode.nodeid, 'class':'idea-list-li'});
			lOL.insert(iUL);
			var blobDiv = new Element("div", {'class':'idea-blob-list'});
			var blobNode = renderNodeMini(nodes[i].cnode, uniqueid+i+start,nodes[i].cnode.role[0].role,includeUser,'active', "", false, includevoting);
			blobDiv.insert(blobNode);
			iUL.insert(blobDiv);
		}
	}
	objDiv.insert(lOL);
}

/**
 * Render a list of nodes
 */
function displayNewsNodes(objDiv,nodes){
	for(var i=0; i < nodes.length; i++){
		if(nodes[i].cnode){
			objDiv.insert(renderNodeNews(nodes[i].cnode));
		}
	}
}

/**
 * Render a list of nodes for the Connectedness stats boxes
 */
function displayConnectionStatNodes(objDiv,nodes,start,includeUser,uniqueid){
	if (uniqueid == undefined) {
		uniqueid = 'idea-list';
	}
	var lOL = new Element("ol", {'start':start, 'class':'idea-list-ol'});
	for(var i=0; i < nodes.length; i++){
		if(nodes[i].cnode){
			var iUL = new Element("li", {'id':nodes[i].cnode.nodeid, 'class':'idea-list-li'});
			lOL.insert(iUL);
			var blobDiv = new Element("div", {'class':'idea-blob-list'});
			var blobNode = renderNode(nodes[i].cnode, uniqueid+i+start,nodes[i].cnode.role[0].role,includeUser,'active', "", true);
			blobDiv.insert(blobNode);
			iUL.insert(blobDiv);
		}
	}
	objDiv.insert(lOL);
}


/**
 * Render a list of nodes
 */
function displaySearchNodes(objDiv,nodes,start,includeUser,uniqueid){
	if (uniqueid == undefined) {
		uniqueid = 'search-list';
	}

	for(var i=0; i < nodes.length; i++){
		if(nodes[i].cnode){
			var blobDiv = new Element("div", {'class':'idea-blob-list'});
			var blobNode = renderNodeMini(nodes[i].cnode, uniqueid+i+start,nodes[i].cnode.role[0].role,includeUser,'active', "", false, false);
			objDiv.insert(blobNode);
		}
	}
}

/**
 * Render a list of nodes
 */
function displayReportNodes(objDiv,nodes,start){
	for(var i=0; i <  nodes.length; i++){
		if(nodes[i].cnode){
			var iUL = new Element("span", {'id':nodes[i].cnode.nodeid, 'class':'idea-list-li', 'style':'padding-bottom: 5px;'});
			objDiv.insert(iUL);
			var blobDiv = new Element("div", {'style':'margin: 2px; width: 650px'});
			var blobNode = renderReportNode(nodes[i].cnode,'idea-list'+i+start, nodes[i].cnode.role[0].role);
			blobDiv.insert(blobNode);
			iUL.insert(blobDiv);
		}
	}
}


/**
 * Render a list of connection nodes for the print of the knowledge trees
 */
function displayReportConnectionNodes(objDiv, nodes,start,includeUser,uniqueid){
	if (uniqueid == undefined) {
		uniqueid = 'knowledgetreereport';
	}

	var lOL = new Element("div", {'start':start, 'class':'idea-list-ol', 'style':'float:left;margin-top:0px;padding-top: 0px;padding-bottom:0px;'});
	for(var i=0; i <  nodes.length; i++){
		if(nodes[i].cnode){
			var blobDiv = new Element("div", {'class':'idea-blob-list', 'style':'clear:both;float:left;margin: 0px; padding: 0px;'});
			var blobNode = renderReportConnectionNode(nodes[i].cnode, uniqueid,nodes[i].cnode.role[0].role,includeUser);
			blobDiv.insert(blobNode);
			lOL.insert(blobDiv);
		}
	}

	objDiv.insert(lOL);
}


/**
 * Render the given node.
 * Used for Activities, Multi connection Viewer, Stats pages etc. where the node is drawn as a Cohere style box.
 *
 * @param node the node object to render
 * @param uniQ is a unique id element prepended to the nodeid to form an overall unique id within the currently visible site elements
 * @param role the role object for this node
 * @param includemenu whether to include the drop-down menu
 * @param type defaults to 'active', but can be 'inactive' so nothing is clickable
 * 			or a specialized type for some of the popups
 */
function renderNodeFromLocalJSon(node, uniQ, role, includemenu, type) {

	if (type === undefined) {
		type = "active";
	}
	if (includemenu === undefined) {
		includemenu = true;
	}
	if(role === undefined){
		role = node.role[0];
	}
	var user = null;
	// JSON structure different if coming from popup where json_encode used.
	if (node.users[0].userid) {
		user = node.users[0];
	} else {
		user = node.users[0].user;
	}

	var breakout = "";

	//needs to check if embedded as a snippet
	if(top.location != self.location){
		breakout = " target='_blank'";
	}

	// used mostly for getting data from Audit history. So nodes repeated a lot.
	// creation date will be the same, but modification date will be different for each duplicated node in the Audit
	uniQ = node.modificationdate+node.nodeid + uniQ;

	var iDiv = new Element("div", {'class':'idea-container'});
	var ihDiv = new Element("div", {'class':'idea-header'});
	var itDiv = new Element("div", {'class':'idea-title'});

	var nodeTable = document.createElement( 'table' );
	nodeTable.className = "toConnectionsTable";
	if (type == "connselect") {
		nodeTable.style.cursor = 'pointer';
		Event.observe(nodeTable,'click',function (){
			loadConnectionNode(node, role);
		});
	}

	var row = nodeTable.insertRow(-1);
	var leftCell = row.insertCell(-1);
	leftCell.vAlign="top";
	leftCell.align="left";
	var rightCell = row.insertCell(-1);
	rightCell.vAlign="top";
	rightCell.align="right";

	//get url for any saved image.

	//add left side with icon image and node text.
	var alttext = getNodeTitleAntecedence(role.name, false);
	if (node.imagethumbnail != null && node.imagethumbnail != "") {
		var originalurl = "";
		if(node.urls && node.urls.length > 0){
			for (var i=0 ; i <  node.urls.length; i++){
				var urlid = node.urls[i].url.urlid;
				if (urlid == node.imageurlid) {
					originalurl = node.urls[i].url.url;
					break;
				}
			}
		}
		if (originalurl == "") {
			originalurl = node.imagethumbnail;
		}
		var iconlink = new Element('a', {
			'href':originalurl,
			'title':"<?php echo $LNG->NODE_TYPE_ICON_HINT; ?>", 'target': '_blank' });
 		var nodeicon = new Element('img',{'alt':"<?php echo $LNG->NODE_TYPE_ICON_HINT; ?>", 'style':'padding-right:5px;', 'src': URL_ROOT + node.imagethumbnail});
 		iconlink.insert(nodeicon);
 		itDiv.insert(iconlink);
 		itDiv.insert(alttext+": ");
	} else if (role.image != null && role.image != "") {
 		var nodeicon = new Element('img',{'alt':alttext, 'title':alttext, 'style':'padding-right:5px;', 'src': URL_ROOT + role.image});
		itDiv.insert(nodeicon);
	} else {
 		itDiv.insert(alttext+": ");
	}

	if (RESOURCE_TYPES_STR.indexOf(role.name) != -1) {
		itDiv.insert("<span>"+node.description+"</span>");
	} else {
		itDiv.insert("<span>"+node.name+"</span>");
	}

	leftCell.appendChild(itDiv);

	// Add right side with user image and date below
	var iuDiv = new Element("div", {'class':'idea-user'});

	var userimageThumb = new Element('img',{'alt':user.name, 'title': user.name, 'style':'padding-right:5px;','align':'right', 'src': user.thumb});

	if (type == "active") {
		var imagelink = new Element('a', {
			'target':'_blank',
			'href':URL_ROOT+"user.php?userid="+user.userid,
			'title':user.name});
		if (breakout != "") {
			imagelink.target = "_blank";
		}
		imagelink.insert(userimageThumb);
		iuDiv.update(imagelink);
	} else {
		iuDiv.insert(userimageThumb)
	}

	var modDate = new Date(node.creationdate*1000);
	if (modDate) {
		var fomatedDate = modDate.format(DATE_FORMAT);
		iuDiv.insert("<div style='clear: both;'>"+fomatedDate+"</span>");
	}

	rightCell.appendChild(iuDiv);
	ihDiv.insert(nodeTable);

	if (COMMENT_TYPES.indexOf(role.name) == -1) {
		var iwDiv = new Element("div", {'class':'idea-wrapper'});
		var imDiv = new Element("div", {'class':'idea-main'});
		var idDiv = new Element("div", {'class':'idea-detail'});
		var headerDiv = new Element("div", {'class':'idea-menus', 'style':'width: 100%'});
		idDiv.insert(headerDiv);

		if (type == 'active') {
			var exploreButton = new Element("a", {'title':'<?php echo $LNG->NODE_EXPLORE_BUTTON_HINT; ?>'} );
			exploreButton.insert("<?php echo $LNG->NODE_EXPLORE_BUTTON_TEXT;?>");
			exploreButton.href= URL_ROOT+"explore.php?id="+node.nodeid;
			exploreButton.target = 'coheremain';

			headerDiv.appendChild(exploreButton);
		}

		imDiv.insert(idDiv);
		iwDiv.insert(imDiv);
		iwDiv.insert('<div style="clear:both;"></div>');
	}

	iDiv.insert(ihDiv);
	iDiv.insert('<div style="clear:both;"></div>');
	iDiv.insert(iwDiv);

	return iDiv;
}

/**
 * Render the given node for drawing on the item Picker list.
 * @param node the node object to render
 * @param role the role object for this node
 * @param includemenu whether to include the drop-down menu (and bookmark and spam buttons)
 * @param type defaults to 'active', but can be 'inactive' so nothing is clickable
 * 			or a specialized type for some of the popups
 */
function renderPickerNode(node, role,includeUser){

	if(role === undefined){
		role = node.role[0].role;
	}

	var user = null;
	// JSON structure different if coming from popup where json_encode used.
	if (node.users[0].userid) {
		user = node.users[0];
	} else {
		user = node.users[0].user;
	}

	var iDiv = new Element("div", {'style':'padding:0px;margin:0px;', 'class':'pickerNode'});
	var ihDiv = new Element("div", {'style':'padding:0px;margin:0px;'});
	var itDiv = new Element("div", {'class':'idea-title'});

	var nodeTable = document.createElement( 'table' );
	nodeTable.className = "toConnectionsTable";
	nodeTable.style.cursor = 'pointer';

	var row = nodeTable.insertRow(-1);
	var leftCell = row.insertCell(-1);
	leftCell.vAlign="top";
	leftCell.align="left";

	var rightCell = row.insertCell(-1);
	rightCell.vAlign="top";
	rightCell.align="right";

	var alttext = getNodeTitleAntecedence(role.name, false);
	if (role.image != null && role.image != "") {
		var nodeicon = new Element('img',{'alt':alttext, 'title':alttext, 'style':'padding-right:5px;','src': URL_ROOT + role.image});
		itDiv.insert(nodeicon);
	} else {
		itDiv.insert(alttext+": ");
	}

	Event.observe(itDiv,'click',function (){
		loadSelecteditem(node);
	});

	if (RESOURCE_TYPES_STR.indexOf(role.name) != -1) {
		itDiv.insert("<span class='itemtext' style='line-height:1.8em' title='Select this item'>"+node.description+"</span>");
	} else {
		itDiv.insert("<span class='itemtext' style='line-height:1.8em' title='Select this item'>"+node.name+"</span>");
	}

	leftCell.appendChild(itDiv);

	if (includeUser) {
		var iuDiv = new Element("div", {'class':'idea-user2'});
		var userimageThumb = new Element('img',{'alt':user.name, 'title': user.name, 'style':'padding-right:5px;','align':'right', 'src': user.thumb});
		iuDiv.insert(userimageThumb)
		rightCell.appendChild(iuDiv);
	}

	ihDiv.insert(nodeTable);

	iDiv.insert(ihDiv);
	iDiv.insert('<div style="clear:both;"></div>');

	var iwDiv = new Element("div", {'class':'idea-wrapper'});
	iwDiv.insert('<div style="clear:both;"></div>');
	iDiv.insert(iwDiv);

	return iDiv;
}

/**
 * Render the given News node.
 * @param node the node object do render
 */
function renderNodeNews(node){

	var description = node.description;
	description = removeHTMLTags(description);
	if (description.length > 100) {
		description = description.substr(0, 100)+'...';
	}

	var title = node.name.replace(' & ',' &amp; ');
	var link = '<?php echo $CFG->homeAddress; ?>explore.php?id='+node.nodeid;
	var cDate = new Date(node.creationdate*1000);
	var date = cDate.format('mmmm d, yyyy');

	var div = new Element("div", {'class':'d-block'});
	var para1 = new Element("p", {'class':'row newsText'});

	var role = node.role[0].role;
	if (role.image != null && role.image != "") {
		var nodeicon = new Element('img',{'alt':role.name, 'title':role.name, 'class':'col-auto', 'style':'max-width: 45px;','src': URL_ROOT + role.image});
		para1.insert(nodeicon);
	}

	var strong = new Element("strong",{'class':'col p-0'});
	para1.insert(strong);

	var anchor = new Element("a");
	anchor.href = link;
	anchor.insert(title);

	strong.insert(anchor);
	strong.insert('<br />');

	var small = new Element("small", {'class':'col-12'});
	para1.insert(small);
	var em = new Element("em");

	em.insert('<?php echo $LNG->NODE_NEWS_POSTED_ON; ?> '+date);
	small.insert(em);
	para1.insert(small);
	div.insert(para1);
	return div;
}

/**
 * Render the given node.
 * @param node the node object do render
 * @param uniQ is a unique id element prepended to the nodeid to form an overall unique id within the currently visible site elements
 * @param role the role object for this node. Defaults to the node role.
 * @param includeUser whether to include the user image and link. Defaults to true.
 * @param type defaults to 'active', but can be 'inactive' so nothing is clickable.
 * 			or a specialized type for some of the popups
 * @param parentrefreshhandler a statment to eval after actions have occurred to refresh this list. Defaults to empty string.
 * @param includeconnectedness should the connectedness count be included - defaults to false.
 * @param includevoting should the voting buttons be included - defaults to true.
 */
function renderNodeMini(node, uniQ, role, includeUser, type, parentrefreshhandler, includeconnectedness, includevoting){

	if(role === undefined){
		role = node.role[0].role;
	}
	if(includeUser === undefined){
		includeUser = true;
	}
	if (type === undefined) {
		type = "active";
	}
	if (parentrefreshhandler === undefined) {
		parentrefreshhandler = "";
	}
	if (includeconnectedness === undefined) {
		includeconnectedness = false;
	}
	if (includevoting === undefined) {
		includevoting = true;
	}

	var user = null;
	// JSON structure different if coming from popup where json_encode used.
	if (node.users[0].userid) {
		user = node.users[0];
	} else {
		user = node.users[0].user;
	}

	uniQ = node.nodeid + uniQ;

	var breakout = "";

	//needs to check if embedded as a snippet
	if(top.location != self.location){
		breakout = " target='_blank'";
	}

	var iDiv = new Element("div", {'class':'m-0 p-0'});
	var ihDiv = new Element("div", {'class':'m-0 p-0'});
	var itDiv = new Element("div", {'class':'idea-title', 'style':''});

	var nodeTable = document.createElement( 'table' );
	nodeTable.className = "toConnectionsTable table table-borderless ";

	itDiv.insert(nodeTable);

	var row = nodeTable.insertRow(-1);

	if (includevoting == true && type == 'active') {
		if (COMMENT_TYPES.indexOf(role.name) == -1 && role.name != "Idea") {
			// ADD VOTING ACTION
			if (role.name == 'Claim'
				|| role.name == 'Issue'
				|| role.name == 'Solution'
				|| role.name == 'Challenge'
				|| EVIDENCE_TYPES_STR.indexOf(role.name) != -1) {

				var voteCell = row.insertCell(-1);
				voteCell.className = "voting-td";

				var voteDiv = new Element("div", {'class':'voting'});
				voteCell.insert(voteDiv);

				// vote for
				var voteforimg = document.createElement('img');
				voteforimg.setAttribute('src', '<?php echo $HUB_FLM->getImagePath("thumb-up-grey3.png"); ?>');
				voteforimg.setAttribute('alt', '<?php echo $LNG->NODE_VOTE_FOR_ICON_ALT; ?>');
				voteforimg.setAttribute('id','nodefor'+node.nodeid);
				voteforimg.nodeid = node.nodeid;
				voteforimg.vote='Y';
				voteDiv.insert(voteforimg);
				if (!node.positivevotes) {
					node.positivevotes = 0;
				}

				if(USER != ""){
					voteforimg.style.cursor = 'pointer';
					if (node.uservote && node.uservote == 'Y') {
						Event.observe(voteforimg,'click',function (){ deleteNodeVote(this) } );
						voteforimg.setAttribute('src', '<?php echo $HUB_FLM->getImagePath("thumb-up-filled3.png"); ?>');
						voteforimg.setAttribute('title', '<?php echo $LNG->NODE_VOTE_REMOVE_HINT; ?>');
					} else if (!node.uservote || node.uservote != 'Y') {
						Event.observe(voteforimg,'click',function (){ nodeVote(this) } );
						voteforimg.setAttribute('src', '<?php echo $HUB_FLM->getImagePath("thumb-up-empty3.png"); ?>');
						voteforimg.setAttribute('title', '<?php echo $LNG->NODE_VOTE_FOR_ADD_HINT; ?>');
					}
					voteDiv.insert('<span id="nodevotefor'+node.nodeid+'">'+node.positivevotes+'</span>');
				} else {
					voteforimg.setAttribute('title', '<?php echo $LNG->NODE_VOTE_FOR_LOGIN_HINT; ?>');
					voteDiv.insert('<span id="nodevotefor'+node.nodeid+'">'+node.positivevotes+'</span>');
				}

				// vote against
				var voteagainstimg = document.createElement('img');
				voteagainstimg.setAttribute('src', '<?php echo $HUB_FLM->getImagePath("thumb-down-grey3.png"); ?>');
				voteagainstimg.setAttribute('alt', '<?php echo $LNG->NODE_VOTE_AGAINST_ICON_ALT; ?>');
				voteagainstimg.setAttribute('id', 'nodeagainst'+node.nodeid);
				voteagainstimg.nodeid = node.nodeid;
				voteagainstimg.vote='N';
				voteDiv.insert(voteagainstimg);
				if (!node.negativevotes) {
					node.negativevotes = 0;
				}
				if(USER != ""){
					voteagainstimg.style.cursor = 'pointer';
					if (node.uservote && node.uservote == 'N') {
						Event.observe(voteagainstimg,'click',function (){ deleteNodeVote(this) } );
						voteagainstimg.setAttribute('src', '<?php echo $HUB_FLM->getImagePath("thumb-down-filled3.png"); ?>');
						voteagainstimg.setAttribute('title', '<?php echo $LNG->NODE_VOTE_REMOVE_HINT; ?>');
					} else if (!node.uservote || node.uservote != 'N') {
						Event.observe(voteagainstimg,'click',function (){ nodeVote(this) } );
						voteagainstimg.setAttribute('src', '<?php echo $HUB_FLM->getImagePath("thumb-down-empty3.png"); ?>');
						voteagainstimg.setAttribute('title', '<?php echo $LNG->NODE_VOTE_AGAINST_ADD_HINT; ?>');
					}
					voteDiv.insert('<span id="nodevoteagainst'+node.nodeid+'">'+node.negativevotes+'</span>');
				} else {
					voteagainstimg.setAttribute('title', '<?php echo $LNG->NODE_VOTE_AGAINST_LOGIN_HINT; ?>');
					voteDiv.insert('<span id="nodevoteagainst'+node.nodeid+'">'+node.negativevotes+'</span>');
				}
			}
		}
	}

	var textCell = row.insertCell(-1);

	var alttext = getNodeTitleAntecedence(role.name, false);
	if (role.image != null && role.image != "") {
		var nodeicon = new Element('img',{'alt':alttext, 'class':'node-image-icon', 'src': URL_ROOT + role.image});
		textCell.insert(nodeicon);
	} else {
		textCell.insert(alttext+": ");
	}

	var title = node.name;
	if (RESOURCE_TYPES_STR.indexOf(role.name) != -1) {
		title=node.description;
	}

	if (COMMENT_TYPES.indexOf(role.name) != -1 || role.name == "Idea") {
		textCell.insert("<span class='itemtext' id='desctoggle"+uniQ+"' title='<?php echo $LNG->NODE_TOGGLE_HINT; ?>' onClick='ideatoggle2(\"desc"+uniQ+"\",\""+uniQ+"\", \""+node.nodeid+"\",\"desc\",\""+role.name+"\")'>"+title+"</span>");
	} else {
		var exploreButton = new Element('a', {'title':'<?php echo $LNG->NODE_DETAIL_BUTTON_HINT; ?>', 'id':'desctoggle'+uniQ, 'style':'line-height:1.8em;font-weight:normal', 'class':'itemtext'});
		if (node.searchid && node.searchid != "") {
			exploreButton.href= "<?php echo $CFG->homeAddress; ?>explore.php?id="+node.nodeid+"&sid="+node.searchid;
		} else {
			exploreButton.href= "<?php echo $CFG->homeAddress; ?>explore.php?id="+node.nodeid;
		}
		exploreButton.insert(title);
		textCell.insert(exploreButton);
	}


	// ADD MENU ACTIONS
	if (type == 'active') {
		if (COMMENT_TYPES.indexOf(role.name) != -1 || role.name == "Idea") {

			var toolbarCell = row.insertCell(-1);
			toolbarCell.vAlign="middle";
			toolbarCell.align="left";
			if (USER != "" && ((
					(BUILD_FROM_PERMISSIONS == "all") ||
					(BUILD_FROM_PERMISSIONS == "user" && USER == user.userid) ||
					(BUILD_FROM_PERMISSIONS == "admin" && IS_USER_ADMIN == "Y")) || USER == user.userid
				)){

				var menuButton = new Element('img',{'alt':'>', 'class':'menuicon', 'src': '<?php echo $HUB_FLM->getImagePath("menuicon.png"); ?>'});
				toolbarCell.appendChild(menuButton);
				Event.observe(menuButton,'mouseout',function (event){
					hideBox('toolbardiv'+uniQ);
				});
				Event.observe(menuButton,'mouseover',function (event) {
					var position = getPosition(this);
					var panel = $('toolbardiv'+uniQ);
					var panelWidth = 140;

					var viewportHeight = getWindowHeight();
					var viewportWidth = getWindowWidth();

					var x = position.x;
					var y = position.y;toolbardiv

					if ( (x+panelWidth+30) > viewportWidth) {
						x = x-(panelWidth+30);
					} else {
						x = x+10;
					}

					x = x+30+getPageOffsetX();

					panel.style.left = x+"px";
					panel.style.top = y+"px";

					showBox('toolbardiv'+uniQ);
				});

				var toolbarDiv = new Element("div", {'id':'toolbardiv'+uniQ, 'class':'toolbarDiv', 'style':'left:-1px;top:-1px;clear:both;position:absolute;display:none;z-index:60;padding:5px;width:140px;border:1px solid gray;background:white'} );
				Event.observe(toolbarDiv,'mouseout',function (event){
					hideBox('toolbardiv'+uniQ);
				});
				Event.observe(toolbarDiv,'mouseover',function (event){ showBox('toolbardiv'+uniQ); });
				toolbarCell.appendChild(toolbarDiv);

				if (USER == user.userid) {

					var editButton = new Element("span", {'class':'active d-block', 'title':'<?php echo $LNG->NODE_EDIT_RESOURCE_ICON_HINT; ?>'} );
					editButton.insert("<?php echo $LNG->NODE_EDIT_ICON_ALT; ?>");
					Event.observe(editButton,'click',function (){loadDialog('editcomment',URL_ROOT+"ui/popups/commentedit.php?handler="+parentrefreshhandler+"&nodeid="+node.nodeid, 750,500)});
					toolbarDiv.appendChild(editButton);

					if (node.otheruserconnections == 0) {
						var delButton = new Element("span", {'class':'active d-block', 'title':'<?php echo $LNG->NODE_DELETE_ICON_HINT; ?>'} );
						delButton.insert("<?php echo $LNG->NODE_DELETE_ICON_ALT; ?>");
						Event.observe(delButton,'click',function (){deleteNode(node.nodeid,node.name,role.name,parentrefreshhandler)});
						toolbarDiv.appendChild(delButton);
					} else {
						var delButton = new Element("span", {'style':'margin-bottom:5px; display: block;', 'title':'<?php echo $LNG->NODE_NO_DELETE_ICON_HINT; ?>'} );
						delButton.insert("<?php echo $LNG->NODE_DELETE_ICON_ALT; ?>");
						toolbarDiv.appendChild(delButton);
					}
				}

				if (USER != "" && (
						(BUILD_FROM_PERMISSIONS == "all") ||
						(BUILD_FROM_PERMISSIONS == "user" && USER == user.userid) ||
						(BUILD_FROM_PERMISSIONS == "admin" && IS_USER_ADMIN == "Y")
					)){

					if (USER == user.userid) {
						toolbarDiv.appendChild(createMenuSpacer());
					}

					var details = node.description;
					if (node.description == "") {
						details = node.name;
					}

					<?php if ($CFG->HAS_CHALLENGE && $USER->getIsAdmin() == "Y") { ?>
						var addButton = new Element("span", {'class':'active d-block', 'title':'<?php echo $LNG->CHAT_CONVERT_TO_CHALLENGE_HINT; ?>'} );
						addButton.insert("<?php echo $LNG->CHAT_CONVERT_TO_CHALLENGE_TEXT; ?>");
						Event.observe(addButton,'click',function (){loadDialog('addchallenge',URL_ROOT+"ui/popups/challengeadd.php?handler="+node.handler+"&chatnodeid="+node.nodeid+"&desc="+encodeURIComponent(details), 750,500)});
						toolbarDiv.appendChild(addButton);
					<?php } ?>

					<?php  if ( $CFG->issuesManaged == false || ($CFG->issuesManaged == true && $USER->getIsAdmin() == "Y") ) { ?>
						var addButton = new Element("span", {'class':'active d-block', 'title':'<?php echo $LNG->CHAT_CONVERT_TO_ISSUE_HINT; ?>'} );
						addButton.insert("<?php echo $LNG->CHAT_CONVERT_TO_ISSUE_TEXT; ?>");
						Event.observe(addButton,'click',function (){loadDialog('addissue',URL_ROOT+"ui/popups/issueadd.php?handler="+node.handler+"&chatnodeid="+node.nodeid+"&desc="+encodeURIComponent(details), 750,500)});
						toolbarDiv.appendChild(addButton);
					<?php } ?>

					if (hasClaim) {
						var addButton = new Element("span", {'class':'active d-block', 'title':'<?php echo $LNG->CHAT_CONVERT_TO_CLAIM_HINT; ?>'} );
						addButton.insert("<?php echo $LNG->CHAT_CONVERT_TO_CLAIM_TEXT; ?>");
						Event.observe(addButton,'click',function (){loadDialog('addclaim',URL_ROOT+"ui/popups/claimadd.php?handler="+node.handler+"&chatnodeid="+node.nodeid+"&desc="+encodeURIComponent(details), 750,500)});
						toolbarDiv.appendChild(addButton);
					}
					if (hasSolution) {
						var addButton = new Element("span", {'class':'active d-block', 'title':'<?php echo $LNG->CHAT_CONVERT_TO_SOLUTION_HINT; ?>'} );
						addButton.insert("<?php echo $LNG->CHAT_CONVERT_TO_SOLUTION_TEXT; ?>");
						Event.observe(addButton,'click',function (){loadDialog('addsolution',URL_ROOT+"ui/popups/solutionadd.php?handler="+node.handler+"&chatnodeid="+node.nodeid+"&desc="+encodeURIComponent(details), 750,500)});
						toolbarDiv.appendChild(addButton);
					}

					var addButton = new Element("span", {'class':'active d-block', 'title':'<?php echo $LNG->CHAT_CONVERT_TO_EVIDENCE_HINT; ?>'} );
					addButton.insert("<?php echo $LNG->CHAT_CONVERT_TO_EVIDENCE_TEXT; ?>");
					Event.observe(addButton,'click',function (){loadDialog('addevidence',URL_ROOT+"ui/popups/evidenceadd.php?handler="+node.handler+"&chatnodeid="+node.nodeid+"&desc="+encodeURIComponent(details), 750,500)});
					toolbarDiv.appendChild(addButton);

					<?php if ($CFG->hasStories) { ?>
						toolbarDiv.appendChild(createMenuSpacer());

						<?php if ($CFG->HAS_SOLUTION && $CFG->HAS_CLAIM == FALSE) { ?>
							var addButton = new Element("span", {'class':'active d-block', 'title':'<?php echo $LNG->COMMENT_CONVERT_TO_STORY_HINT; ?>'} );
							addButton.insert("<?php echo $LNG->COMMENT_CONVERT_TO_STORY; ?>");
							Event.observe(addButton,'click',function (){loadDialog('commentbuilderp',URL_ROOT+"ui/popups/quickformpractitionercomment.php?handler="+node.handler+"&chatnodeid="+node.nodeid, 750,750)});
							toolbarDiv.appendChild(addButton);
						<?php } ?>
						<?php if ($CFG->HAS_SOLUTION && $CFG->HAS_CLAIM) { ?>
							var addButton = new Element("span", {'class':'active d-block', 'title':'<?php echo $LNG->COMMENT_CONVERT_TO_PRACTITIONER_STORY_HINT; ?>'} );
							addButton.insert("<?php echo $LNG->COMMENT_CONVERT_TO_RESEARCHER_STORY; ?>");
							Event.observe(addButton,'click',function (){loadDialog('commentbuilderp',URL_ROOT+"ui/popups/quickformpractitionercomment.php?handler="+node.handler+"&chatnodeid="+node.nodeid, 750,750)});
							toolbarDiv.appendChild(addButton);

							var addButton = new Element("span", {'class':'active d-block', 'title':'<?php echo $LNG->COMMENT_CONVERT_TO_RESEARCHER_STORY_HINT; ?>'} );
							addButton.insert("<?php echo $LNG->COMMENT_CONVERT_TO_PRACTITIONER_STORY; ?>");
							Event.observe(addButton,'click',function (){loadDialog('commentbuilderr',URL_ROOT+"ui/popups/quickformresearchercomment.php?handler="+node.handler+"&chatnodeid="+node.nodeid, 750,750)});
							toolbarDiv.appendChild(addButton);
						<?php } ?>
						<?php if ($CFG->HAS_CLAIM && $CFG->HAS_SOLUTION === FALSE) { ?>
							var addButton = new Element("span", {'class':'active d-block', 'title':'<?php echo $LNG->COMMENT_CONVERT_TO_STORY_HINT; ?>'} );
							addButton.insert("<?php echo $LNG->COMMENT_CONVERT_TO_STORY; ?>");
							Event.observe(addButton,'click',function (){loadDialog('commentbuilderr',URL_ROOT+"ui/popups/quickformresearchercomment.php?handler="+node.handler+"&chatnodeid="+node.nodeid, 750,750)});
							toolbarDiv.appendChild(addButton);
						<?php } ?>
					<?php } ?>
				}
			}
		}
	}

	ihDiv.insert(itDiv);

	if (COMMENT_TYPES.indexOf(role.name) != -1 || role.name == "Idea") {
		var iwDiv = new Element("div", {'class':'idea-wrapper'});
		var imDiv = new Element("div", {'class':'idea-main'});
		var idDiv = new Element("div", {'class':'idea-detail'});

		var expandDiv = new Element("div", {'id':'desc'+uniQ,'class':'ideadata', 'style':'display:none;'} );

		var nodeTable = document.createElement( 'table' );
		nodeTable.className = "toConnectionsTable";

		expandDiv.insert(nodeTable);

		var row = nodeTable.insertRow(-1);
		var nextCell = row.insertCell(-1);
		nextCell.vAlign="middle";
		nextCell.align="left";

		// USER ICON NAME AND CREATIONS DATES
		var userbar = new Element("div", {'class':'userbar'} );

		if (includeUser == true) {

			// Add right side with user image and date below
			var iuDiv = new Element("div", {'class':'idea-user2', 'style':'clear:both;float:left;'});

			var userimageThumb = new Element('img',{'alt':user.name, 'title': user.name, 'style':'padding-right:5px;', 'src': user.thumb});

			if (type == "active") {
				var imagelink = new Element('a', {
					'href':URL_ROOT+"user.php?userid="+user.userid,
					'title':user.name});
				if (breakout != "") {
					imagelink.target = "_blank";
				}
				imagelink.insert(userimageThumb);
				iuDiv.update(imagelink);
			} else {
				iuDiv.insert(userimageThumb)
			}

			userbar.appendChild(iuDiv);
		}

		var iuDiv = new Element("div", {'style':'float:left;'});

		var dStr = "";

		var cDate = new Date(node.creationdate*1000);
		dStr += "<b><?php echo $LNG->NODE_ADDED_ON; ?> </b>"+ cDate.format(DATE_FORMAT) + "<br/>";
		dStr += "<b><?php echo $LNG->NODE_ADDED_BY; ?> </b>"+ user.name + "";

		iuDiv.insert(dStr);
		userbar.insert(iuDiv);

		nextCell.appendChild(userbar);

		// META DATA - DESCRIPTION, TAGS, URLS, LOCATION ETC

		// add url if a resource node
		if (RESOURCE_TYPES_STR.indexOf(role.name) != -1) {
			expandDiv.insert('<span style="margin-right:5px;"><b><?php echo $LNG->NODE_URL_HEADING; ?></b></span>');
			var link = new Element("a", {'href':node.name,'target':'_blank','title':'<?php echo $LNG->NODE_RESOURCE_LINK_HINT; ?>'} );
			link.insert(node.name);
			expandDiv.insert(link);

			if (node.urls && node.urls.length > 0) {
				var hasClips = false;
				var iUL = new Element("ul", {});
				for (var i=0 ; i <  node.urls.length; i++){
					if (node.urls[i].url.clip && node.urls[i].url.clip != "") {
						var link = new Element("li");
						link.insert(node.urls[i].url.clip);
						iUL.insert(link);
						hasClips = true;
					}
					if (node.urls[i].url.identifier && node.urls[i].url.identifier != "" && role.name == 'Publication') {
						expandDiv.insert('<br><span style="margin-right:5px;"><b><?php echo $LNG->FORM_LABEL_DOI; ?> </b></span><span>'+node.urls[i].url.identifier+'</span>');
					}
				}

				if (hasClips) {
					expandDiv.insert('<br><span style="margin-right:5px;"><b><?php echo $LNG->NODE_RESOURCE_CLIPS_HEADING; ?> </b></span><br>');
				}

				expandDiv.insert(iUL);
			}
		}

		//tags
		if(node.tags && node.tags.length > 0){
			var grpStr = "<div style='padding:0px; margin-top:5px;margin-bottom:5px;'><b><?php echo $LNG->NODE_TAGS_HEADING; ?> </b>";
			for (var i=0 ; i <  node.tags.length; i++){
				var tag = null;
				if (node.tags[i].name) {
					tag = node.tags[i];
				} else {
					tag = node.tags[i].tag
				}

				if (type == "active") {
					grpStr += '<a href="'+URL_ROOT+'search.php?q='+tag.name+'&fromid='+node.nodeid+'&scope=all&tagsonly=true">'+tag.name+'</a>';
				} else {
					grpStr += tag.name;
				}
				if (i < node.tags.length-1) {
					grpStr += ',';
				}
			}

			grpStr += '</div>';
			expandDiv.insert(grpStr);
		}

		var searchid="";
		if (node.searchid) {
			searchid = node.searchid;
		}

		if (COMMENT_TYPES.indexOf(role.name) != -1 || role.name == "Idea") {
			var commentdiv = new Element("div", { 'id':'commentdiv'+uniQ, 'name':'commentdiv', 'class':'d-block commentdiv'});
			expandDiv.insert(commentdiv);
			if (role.name == "Idea") {
				childcommentload(commentdiv, node.nodeid, "<?php echo $CFG->LINK_COMMENT_BUILT_FROM; ?>", "Solution,Issue,Challenge,Claim,"+EVIDENCE_TYPES_STR, uniQ, searchid);
			} else {
				childchatusageload(commentdiv, node.nodeid,"<?php echo $CFG->LINK_COMMENT_NODE; ?>", EVIDENCE_TYPES_STR+","+BASE_TYPES_STR+","+COMMENT_TYPES, uniQ, searchid);
			}
		} else if (EVIDENCE_TYPES.indexOf(role.name) != -1 || role.name == "Challenge" || role.name == "Issue" || role.name == "Solution" || role.name == "Claim") {
			var commentdiv = new Element("div", { 'id':'commentdiv'+uniQ, 'name':'commentdiv', 'class':'commentdiv'});
			expandDiv.insert(commentdiv);
			childcommentload(commentdiv, node.nodeid,"<?php echo $CFG->LINK_COMMENT_BUILT_FROM; ?>", COMMENT_TYPES+",Idea", uniQ, searchid);
		}

		var dStr = "";

		if (RESOURCE_TYPES_STR.indexOf(role.name) == -1) {
			if(node.description || node.hasdesc){
				dStr += '<div style="margin:0px;padding=0px;" class="idea-desc" id="desc'+uniQ+'div"><span style="margin-top: 5px;"><b><?php echo $LNG->NODE_DESC_HEADING; ?> </b></span><br>';
				if (node.description && node.description != "") {
					expandDiv.description = true;
					dStr += node.description;
				}
				dStr += '</div>';
				expandDiv.insert(dStr);
			}
		}

		// CHILD LISTS
		if (role.name == 'Challenge') {
			expandDiv.insert('<div style="clear:both;"></div>');

			var issueStr = "<span style='font-weight:bold;display:none;float:left;margin-top:5px;' id='toggleissue"+uniQ+"'";
			issueStr += ">";
			issueStr += "<?php echo $LNG->NODE_CHILDREN_ISSUE; ?>";
			issueStr += " (<span id='countissue"+uniQ+"'>0</span>) ";

			expandDiv.insert(issueStr);
			var issueDiv = new Element("div", {'id':'issue'+uniQ, 'style':'clear:both;float:left;margin-left:5px;margin-bottom:5px;color:Gray;display:none;'} );
			expandDiv.insert(issueDiv);

			expandDiv.insert('<div style="clear:both;"></div>');

			var solutionStr = "<span style='font-weight:bold;display:none;float:left;margin-top:5px;' id='togglesolution"+uniQ+"'";
			solutionStr += ">";
			solutionStr += "<?php echo $LNG->NODE_CHILDREN_SOLUTION; ?>";
			solutionStr += " (<span id='countsolution"+uniQ+"'>0</span>) ";

			expandDiv.insert(solutionStr);
			var solutionDiv = new Element("div", {'id':'solution'+uniQ, 'style':'clear:both;float:left;margin-left:5px;margin-bottom:5px;color:Gray;display:none;'} );
			expandDiv.insert(solutionDiv);

			expandDiv.insert('<div style="clear:both;"></div>');

			var claimStr = "<span style='font-weight:bold;display:none;float:left;margin-top:5px;' id='toggleclaim"+uniQ+"'";
			claimStr += ">";
			claimStr += "<?php echo $LNG->NODE_CHILDREN_CLAIM; ?>";
			claimStr += " (<span id='countclaim"+uniQ+"'>0</span>) ";

			expandDiv.insert(claimStr);
			var claimDiv = new Element("div", {'id':'claim'+uniQ, 'style':'clear:both;float:left;margin-left:5px;margin-bottom:5px;color:Gray;display:none;'} );
			expandDiv.insert(claimDiv);

			expandDiv.insert('<div style="clear:both;"></div>');
		} else if (role.name == 'Issue') {
			expandDiv.insert('<div style="clear:both;"></div>');

			var solutionStr = "<span style='font-weight:bold;display:none;float:left;margin-top:5px;' id='togglesolution"+uniQ+"'";
			solutionStr += "'>";
			solutionStr += "<?php echo $LNG->NODE_CHILDREN_SOLUTION; ?>";
			solutionStr += " (<span id='countsolution"+uniQ+"'>0</span>) ";

			expandDiv.insert(solutionStr);
			var solutionDiv = new Element("div", {'id':'solution'+uniQ, 'style':'clear:both;float:left;margin-left:5px;margin-bottom:5px;color:Gray;display:none;'} );
			expandDiv.insert(solutionDiv);

			expandDiv.insert('<div style="clear:both;"></div>');

			var claimStr = "<span style='font-weight:bold;display:none;float:left;margin-top:5px;' id='toggleclaim"+uniQ+"'";
			claimStr += ">";
			claimStr += "<?php echo $LNG->NODE_CHILDREN_CLAIM; ?>";
			claimStr += " (<span id='countclaim"+uniQ+"'>0</span>) ";

			expandDiv.insert(claimStr);
			var claimDiv = new Element("div", {'id':'claim'+uniQ, 'style':'clear:both;float:left;margin-left:5px;margin-bottom:5px;color:Gray;display:none;'} );
			expandDiv.insert(claimDiv);

			expandDiv.insert('<div style="clear:both;"></div>');
		} else if (role.name == 'Claim' || role.name == 'Solution') {
			expandDiv.insert('<div style="clear:both;"></div>');

			var supportStr = "<span style='font-weight:bold;display:none;float:left;margin-top:5px;' id='togglesupport"+uniQ+"'";
			supportStr += ">";
			supportStr += "<?php echo $LNG->NODE_CHILDREN_EVIDENCE_PRO; ?>";
			supportStr += " (<span id='countsupport"+uniQ+"'>0</span>) ";

			expandDiv.insert(supportStr);
			var supportDiv = new Element("div", {'id':'support'+uniQ, 'style':'clear:both;float:left;margin-left:5px;margin-bottom:5px;color:Gray;display:none;'} );
			expandDiv.insert(supportDiv);

			expandDiv.insert('<div style="clear:both;"></div>');

			var opposeStr = "<span style='font-weight:bold;display:none;float:left;margin-top:5px;' id='toggleoppose"+uniQ+"'";
			opposeStr += ">";
			opposeStr += "<?php echo $LNG->NODE_CHILDREN_EVIDENCE_CON; ?>";
			opposeStr += " (<span id='countoppose"+uniQ+"'>0</span>) ";

			expandDiv.insert(opposeStr);
			var opposingDiv = new Element("div", {'id':'oppose'+uniQ, 'style':'clear:both;float:left;margin-left:5px;margin-bottom:5px;color:Gray;display:none;'} );
			expandDiv.insert(opposingDiv);

			expandDiv.insert('<div style="clear:both;"></div>');
		} else if (EVIDENCE_TYPES_STR.indexOf(role.name) != -1) {
			expandDiv.insert('<div style="clear:both;"></div>');

			var resourceStr = "<span style='font-weight:bold;display:none;float:left;margin-top:5px;' id='toggleresource"+uniQ+"'";
			resourceStr += ">";
			resourceStr += "<?php echo $LNG->NODE_CHILDREN_RESOURCES; ?>";
			resourceStr += " (<span id='countresource"+uniQ+"'>0</span>) ";

			expandDiv.insert(resourceStr);
			var resourceDiv = new Element("div", {'id':'resource'+uniQ, 'style':'clear:both;float:left;margin-bottom:5px;color:Gray;display:none;'} );
			expandDiv.insert(resourceDiv);

			expandDiv.insert('<div style="clear:both;"></div>');

		} else if (role.name == 'Comment' && node.connection) {
			var tN = node.connection.to[0].cnode;
			var tRole = tN.role[0].role;
			var title=tN.name;
			if (RESOURCE_TYPES_STR.indexOf(tRole.name) != -1) {
				title = tN.description;
			}

			if (tN.role[0].role.name == "Comment") {
				var nextStr = "<span style='font-weight:bold;float:left;margin-top:5px;'>";
				nextStr += "<?php echo $LNG->NODE_COMMENT_PARENT; ?> ";
				nextStr += "<span>"+title+"</span>";
				nextStr += "</span>";
				expandDiv.insert(nextStr);
				if (node.connection.parentnode) {
					var nextStr = "<span style='font-weight:bold;clear:both;float:left;margin-top:5px;'>";
					nextStr += "<?php echo $LNG->CHAT_COMMENT_PARENT_TREE; ?> ";
					nextStr += "</span>";
					expandDiv.insert(nextStr);
					var icon = getNodeIconElement(node.connection.parentnode[0].cnode);
					var title = node.connection.parentnode[0].cnode.name;
					var parentid = node.connection.parentnode[0].cnode.nodeid;
					var exploreButton = new Element("a", {'class':'d-block','title':'<?php echo $LNG->NODE_CHAT_BUTTON_HINT; ?>'} );
					if (icon != null) {
						exploreButton.insert(icon);
						exploreButton.insert('<span class="col-auto">'+title+'</span>');
					} else {
						exploreButton.insert(title);
					}
					exploreButton.href= "chats.php?chatnodeid="+node.nodeid+"&id="+parentid;
					expandDiv.insert(exploreButton);
				}
			} else {
				var nextStr = "<span style='font-weight:bold;float:left;margin-top:5px;'>";
				nextStr += "<?php echo $LNG->NODE_COMMENT_PARENT; ?> ";
				nextStr += "</span>";
				expandDiv.insert(nextStr);

				var icon = getNodeIconElement(tN);
				var exploreButton = new Element("a", {'class':'d-block','title':'<?php echo $LNG->NODE_CHAT_BUTTON_HINT; ?>'} );
				if (icon != null) {
					exploreButton.insert(icon);
					exploreButton.insert('<span class="col-auto">'+title+'</span>');
				} else {
					exploreButton.insert(title);
				}
				exploreButton.href= "chats.php?chatnodeid="+node.nodeid+"&id="+tN.nodeid;
				expandDiv.insert(exploreButton);
			}
		}

		idDiv.insert(expandDiv);
		imDiv.insert(idDiv);
		iwDiv.insert(imDiv);
	}

	iDiv.insert(ihDiv);
	iDiv.insert(iwDiv);

	return iDiv;
}

/**
 * Render the given node.
 * @param node the node object do render
 * @param uniQ is a unique id element prepended to the nodeid to form an overall unique id within the currently visible site elements
 * @param role the role object for this node
 * @param includeUser whether to include the user image and link
 * @param type defaults to 'active', but can be 'inactive' so nothing is clickable
 * 			or a specialized type for some of the popups
 * @param parentrefreshhandler a statment to eval after actions have occurred to refresh this list.
 * @param includeconnectedness should the connectedness count be included - defaults to false.
 */
function renderNode(node, uniQ, role, includeUser, type, parentrefreshhandler, includeconnectedness){

	if (type === includeconnectedness) {
		includeconnectedness = false;
	}

	if (type === undefined) {
		type = "active";
	}

	if(role === undefined){
		role = node.role[0].role;
	}

	var user = null;
	// JSON structure different if coming from popup where json_encode used.
	if (node.users[0].userid) {
		user = node.users[0];
	} else {
		user = node.users[0].user;
	}

	uniQ = node.nodeid + uniQ;

	var breakout = "";

	//needs to check if embedded as a snippet
	if(top.location != self.location){
		breakout = " target='_blank'";
	}

	var iDiv = new Element("div", {'style':'padding:0px;margin:0px;'});
	var ihDiv = new Element("div", {'style':'padding:0px;margin:0px;'});
	var itDiv = new Element("div", {'class':'idea-title', 'style':''});

	var nodeTable = document.createElement( 'table' );
	nodeTable.className = "toConnectionsTable";

	itDiv.insert(nodeTable);

	var row = nodeTable.insertRow(-1);
	var textCell = row.insertCell(-1);
	textCell.vAlign="middle";
	textCell.align="left";

	var alttext = getNodeTitleAntecedence(role.name, false);
	if (node.imagethumbnail != null && node.imagethumbnail != "") {
		var originalurl = "";
		if(node.urls && node.urls.length > 0){
			for (var i=0 ; i <  node.urls.length; i++){
				var urlid = node.urls[i].url.urlid;
				if (urlid == node.imageurlid) {
					originalurl = node.urls[i].url.url;
					break;
				}
			}
		}
		if (originalurl == "") {
			originalurl = node.imagethumbnail;
		}
		var iconlink = new Element('a', {
			'href':originalurl,
			'title':"<?php echo $LNG->NODE_TYPE_ICON_HINT; ?>", 'target': '_blank' });
		var nodeicon = new Element('img',{'alt':"<?php echo $LNG->NODE_TYPE_ICON_HINT; ?>", 'style':'width:auto;height:20px;margin-top:0;padding-right:10px;', 'src': URL_ROOT + node.imagethumbnail});
		iconlink.insert(nodeicon);
		textCell.insert(iconlink);
		textCell.insert(alttext+": ");
	} else if (role.image != null && role.image != "") {
		var nodeicon = new Element('img',{'alt':alttext, 'title':alttext, 'style':'width:auto;height:20px;margin-top:0;padding-right:10px;','src': URL_ROOT + role.image});
		textCell.insert(nodeicon);
	} else {
		textCell.insert(alttext+": ");
	}

	var title = node.name;
	if (RESOURCE_TYPES_STR.indexOf(role.name) != -1) {
		title=node.description;
	}

	textCell.insert("<span class='itemtext' style='line-height:1.8em' id='desctoggle"+uniQ+"' title='<?php echo $LNG->NODE_TOGGLE_HINT; ?>' onClick='ideatoggle2(\"desc"+uniQ+"\",\""+uniQ+"\", \""+node.nodeid+"\",\"desc\",\""+role.name+"\")'>"+title+"</span>");

	if (includeconnectedness && node.connectedness) {
		var countCell = row.insertCell(-1);
		countCell.vAlign="middle";
		countCell.align="left";
		countCell.insert("("+node.connectedness+")");
	}

	var toolbarCell = row.insertCell(-1);
	toolbarCell.vAlign="middle";
	toolbarCell.align="left";

	// ADD MENU ACTIONS
	if (type == 'active') {
		if (COMMENT_TYPES.indexOf(role.name) != -1 || role.name == "Idea") {
			if (USER != "" && ((
					(BUILD_FROM_PERMISSIONS == "all") ||
					(BUILD_FROM_PERMISSIONS == "user" && USER == user.userid) ||
					(BUILD_FROM_PERMISSIONS == "admin" && IS_USER_ADMIN == "Y")) || USER == user.userid
				)){

				var menuButton = new Element('img',{'alt':'>', 'class':'menuicon','src': '<?php echo $HUB_FLM->getImagePath("menuicon.png"); ?>'});
				toolbarCell.appendChild(menuButton);
				Event.observe(menuButton,'mouseout',function (event){
					hideBox('toolbardiv'+uniQ);
				});
				Event.observe(menuButton,'mouseover',function (event) {
					var position = getPosition(this);
					var panel = $('toolbardiv'+uniQ);
					var panelWidth = 140;

					var viewportHeight = getWindowHeight();
					var viewportWidth = getWindowWidth();

					var x = position.x;
					var y = position.y;

					if ( (x+panelWidth+30) > viewportWidth) {
						x = x-(panelWidth+30);
					} else {
						x = x+10;
					}

					x = x+30+getPageOffsetX();

					panel.style.left = x+"px";
					panel.style.top = y+"px";

					showBox('toolbardiv'+uniQ);
				});

				var toolbarDiv = new Element("div", {'id':'toolbardiv'+uniQ, 'class':'toolbarDiv', 'style':'left:-1px;top:-1px;clear:both;position:absolute;display:none;z-index:60;padding:5px;width:140px;border:1px solid gray;background:white'} );
				Event.observe(toolbarDiv,'mouseout',function (event){
					hideBox('toolbardiv'+uniQ);
				});
				Event.observe(toolbarDiv,'mouseover',function (event){ showBox('toolbardiv'+uniQ); });
				toolbarCell.appendChild(toolbarDiv);

				if (USER == user.userid) {

					var editButton = new Element("span", {'class':'active d-block', 'title':'<?php echo $LNG->NODE_EDIT_RESOURCE_ICON_HINT; ?>'} );
					editButton.insert("<?php echo $LNG->NODE_EDIT_ICON_ALT; ?>");
					Event.observe(editButton,'click',function (){loadDialog('editcomment',URL_ROOT+"ui/popups/commentedit.php?handler="+parentrefreshhandler+"&nodeid="+node.nodeid, 750,500)});
					toolbarDiv.appendChild(editButton);

					if (node.otheruserconnections == 0) {
						var delButton = new Element("span", {'class':'active d-block', 'title':'<?php echo $LNG->NODE_DELETE_ICON_HINT; ?>'} );
						delButton.insert("<?php echo $LNG->NODE_DELETE_ICON_ALT; ?>");
						Event.observe(delButton,'click',function (){deleteNode(node.nodeid,node.name,role.name,parentrefreshhandler)});
						toolbarDiv.appendChild(delButton);
					} else {
						var delButton = new Element("span", {'style':'margin-bottom:5px; display: block;', 'title':'<?php echo $LNG->NODE_NO_DELETE_ICON_HINT; ?>'} );
						delButton.insert("<?php echo $LNG->NODE_DELETE_ICON_ALT; ?>");
						toolbarDiv.appendChild(delButton);
					}
				}

				if (USER != "" && (
						(BUILD_FROM_PERMISSIONS == "all") ||
						(BUILD_FROM_PERMISSIONS == "user" && USER == user.userid) ||
						(BUILD_FROM_PERMISSIONS == "admin" && IS_USER_ADMIN == "Y")
					)){

					if (USER == user.userid) {
						toolbarDiv.appendChild(createMenuSpacer());
					}

					var details = node.description;
					if (node.description == "") {
						details = node.name;
					}

					<?php if ($CFG->HAS_CHALLENGE && $USER->getIsAdmin() == "Y") { ?>
						var addButton = new Element("span", {'class':'active d-block', 'title':'<?php echo $LNG->CHAT_CONVERT_TO_CHALLENGE_HINT; ?>'} );
						addButton.insert("<?php echo $LNG->CHAT_CONVERT_TO_CHALLENGE_TEXT; ?>");
						Event.observe(addButton,'click',function (){loadDialog('addchallenge',URL_ROOT+"ui/popups/challengeadd.php?handler="+node.handler+"&chatnodeid="+node.nodeid+"&desc="+encodeURIComponent(details), 750,500)});
						toolbarDiv.appendChild(addButton);
					<?php } ?>

					<?php  if ( $CFG->issuesManaged == false || ($CFG->issuesManaged == true && $USER->getIsAdmin() == "Y") ) { ?>
						var addButton = new Element("span", {'class':'active d-block', 'title':'<?php echo $LNG->CHAT_CONVERT_TO_ISSUE_HINT; ?>'} );
						addButton.insert("<?php echo $LNG->CHAT_CONVERT_TO_ISSUE_TEXT; ?>");
						Event.observe(addButton,'click',function (){loadDialog('addissue',URL_ROOT+"ui/popups/issueadd.php?handler="+node.handler+"&chatnodeid="+node.nodeid+"&desc="+encodeURIComponent(details), 750,500)});
						toolbarDiv.appendChild(addButton);
					<?php } ?>

					if (hasClaim) {
						var addButton = new Element("span", {'class':'active d-block', 'title':'<?php echo $LNG->CHAT_CONVERT_TO_CLAIM_HINT; ?>'} );
						addButton.insert("<?php echo $LNG->CHAT_CONVERT_TO_CLAIM_TEXT; ?>");
						Event.observe(addButton,'click',function (){loadDialog('addclaim',URL_ROOT+"ui/popups/claimadd.php?handler="+node.handler+"&chatnodeid="+node.nodeid+"&desc="+encodeURIComponent(details), 750,500)});
						toolbarDiv.appendChild(addButton);
					}
					if (hasSolution) {
						var addButton = new Element("span", {'class':'active d-block', 'title':'<?php echo $LNG->CHAT_CONVERT_TO_SOLUTION_HINT; ?>'} );
						addButton.insert("<?php echo $LNG->CHAT_CONVERT_TO_SOLUTION_TEXT; ?>");
						Event.observe(addButton,'click',function (){loadDialog('addsolution',URL_ROOT+"ui/popups/solutionadd.php?handler="+node.handler+"&chatnodeid="+node.nodeid+"&desc="+encodeURIComponent(details), 750,500)});
						toolbarDiv.appendChild(addButton);
					}

					var addButton = new Element("span", {'class':'active d-block', 'title':'<?php echo $LNG->CHAT_CONVERT_TO_EVIDENCE_HINT; ?>'} );
					addButton.insert("<?php echo $LNG->CHAT_CONVERT_TO_EVIDENCE_TEXT; ?>");
					Event.observe(addButton,'click',function (){loadDialog('addevidence',URL_ROOT+"ui/popups/evidenceadd.php?handler="+node.handler+"&chatnodeid="+node.nodeid+"&desc="+encodeURIComponent(details), 750,500)});
					toolbarDiv.appendChild(addButton);

					<?php if ($CFG->hasStories) { ?>
						toolbarDiv.appendChild(createMenuSpacer());

						<?php if ($CFG->HAS_SOLUTION && $CFG->HAS_CLAIM == FALSE) { ?>
							var addButton = new Element("span", {'class':'active d-block', 'title':'<?php echo $LNG->COMMENT_CONVERT_TO_STORY_HINT; ?>'} );
							addButton.insert("<?php echo $LNG->COMMENT_CONVERT_TO_STORY; ?>");
							Event.observe(addButton,'click',function (){loadDialog('commentbuilderp',URL_ROOT+"ui/popups/quickformpractitionercomment.php?handler="+node.handler+"&chatnodeid="+node.nodeid, 750,750)});
							toolbarDiv.appendChild(addButton);
						<?php } ?>
						<?php if ($CFG->HAS_SOLUTION && $CFG->HAS_CLAIM) { ?>
							var addButton = new Element("span", {'class':'active d-block', 'title':'<?php echo $LNG->COMMENT_CONVERT_TO_PRACTITIONER_STORY_HINT; ?>'} );
							addButton.insert("<?php echo $LNG->COMMENT_CONVERT_TO_RESEARCHER_STORY; ?>");
							Event.observe(addButton,'click',function (){loadDialog('commentbuilderp',URL_ROOT+"ui/popups/quickformpractitionercomment.php?handler="+node.handler+"&chatnodeid="+node.nodeid, 750,750)});
							toolbarDiv.appendChild(addButton);

							var addButton = new Element("span", {'class':'active d-block', 'title':'<?php echo $LNG->COMMENT_CONVERT_TO_RESEARCHER_STORY_HINT; ?>'} );
							addButton.insert("<?php echo $LNG->COMMENT_CONVERT_TO_PRACTITIONER_STORY; ?>");
							Event.observe(addButton,'click',function (){loadDialog('commentbuilderr',URL_ROOT+"ui/popups/quickformresearchercomment.php?handler="+node.handler+"&chatnodeid="+node.nodeid, 750,750)});
							toolbarDiv.appendChild(addButton);
						<?php } ?>
						<?php if ($CFG->HAS_CLAIM && $CFG->HAS_SOLUTION === FALSE) { ?>
							var addButton = new Element("span", {'class':'active d-block', 'title':'<?php echo $LNG->COMMENT_CONVERT_TO_STORY_HINT; ?>'} );
							addButton.insert("<?php echo $LNG->COMMENT_CONVERT_TO_STORY; ?>");
							Event.observe(addButton,'click',function (){loadDialog('commentbuilderr',URL_ROOT+"ui/popups/quickformresearchercomment.php?handler="+node.handler+"&chatnodeid="+node.nodeid, 750,750)});
							toolbarDiv.appendChild(addButton);
						<?php } ?>
					<?php } ?>
				}
			}
		} else {

			var menuButton = new Element('img',{'alt':'>', 'class':'menuicon', 'src': '<?php echo $HUB_FLM->getImagePath("menuicon.png"); ?>'});
			toolbarCell.appendChild(menuButton);
			Event.observe(menuButton,'mouseout',function (event){
				hideBox('toolbardiv'+uniQ);
			});
			Event.observe(menuButton,'mouseover',function (event) {
				var position = getPosition(this);
				var panel = $('toolbardiv'+uniQ);
				var panelWidth = 175;

				var viewportHeight = getWindowHeight();
				var viewportWidth = getWindowWidth();

				var x = position.x;
				var y = position.y;

				if ( (x+panelWidth+30) > viewportWidth) {
					x = x-(panelWidth+30);
				} else {
					x = x+10;
				}

				x = x+30+getPageOffsetX();

				panel.style.left = x+"px";
				panel.style.top = y+"px";

				closeSubmenus(uniQ);
				showBox('toolbardiv'+uniQ, event);
			});

			var toolbarDiv = new Element("div", {'id':'toolbardiv'+uniQ, 'class':'toolbarDiv connectionsToolbar', 'style':'left:-1px;top:-1px;clear:both;position:absolute;display:none;z-index:60;padding:5px;width:175px;border:1px solid gray;background:white;'} );
			Event.observe(toolbarDiv,'mouseout',function (event){
				hideBox('toolbardiv'+uniQ);
			});
			Event.observe(toolbarDiv,'mouseover',function (event){ showBox('toolbardiv'+uniQ); });
			toolbarCell.appendChild(toolbarDiv);

			createExploreMenuOption(toolbarDiv, node, role, uniQ);
			createConnectionMenuOption(toolbarDiv, node, role, uniQ);

			// IF OWNER ADD EDIT / DEL ACTIONS
			if (USER == user.userid) {
				createEditMenuOption(toolbarDiv, node, role, parentrefreshhandler, user);

				if (node.otheruserconnections == 0) {
					var deletename = node.name;
					if (RESOURCE_TYPES_STR.indexOf(role.name) != -1) {
						deletename = node.description;
					}
					var delButton = new Element("span", {'class':'active d-block', 'title':'<?php echo $LNG->NODE_DELETE_ICON_HINT; ?>'} );
					delButton.insert("<?php echo $LNG->NODE_DELETE_ICON_ALT; ?>");
					Event.observe(delButton,'click',function (){deleteNode(node.nodeid,deletename,role.name,parentrefreshhandler)});
					toolbarDiv.appendChild(delButton);
				} else {
					var delButton = new Element("span", {'style':'margin-bottom:5px;', 'title':'<?php echo $LNG->NODE_NO_DELETE_ICON_HINT; ?>'} );
					delButton.insert("<?php echo $LNG->NODE_DELETE_ICON_ALT; ?>");
					toolbarDiv.appendChild(delButton);
				}
			}

			<?php if ($CFG->SPAM_ALERT_ON) { ?>
				toolbarDiv.insert(createSpamMenuOption(node, role));
			<?php } ?>

			// ADD VOTING ACTION
			if (role.name == 'Claim'
				|| role.name == 'Issue'
				|| role.name == 'Solution'
				|| role.name == 'Challenge'
				|| EVIDENCE_TYPES_STR.indexOf(role.name) != -1) {

				var voteDiv = new Element("div", {'class':'voteDiv d-flex mt-1'});
				voteDiv.insert('<span style="margin-right:5px;"><?php echo $LNG->NODE_VOTE_MENU_TEXT; ?></span>');
				toolbarDiv.insert(voteDiv);

				// vote for
				var voteforimg = document.createElement('img');
				voteforimg.setAttribute('src', '<?php echo $HUB_FLM->getImagePath("thumb-up-grey3.png"); ?>');
				voteforimg.setAttribute('alt', '<?php echo $LNG->NODE_VOTE_FOR_ICON_ALT; ?>');
				voteforimg.setAttribute('id','nodefor'+node.nodeid);
				voteforimg.nodeid = node.nodeid;
				voteforimg.vote='Y';
				voteforimg.style.verticalAlign="bottom";
				voteforimg.style.marginRight="3px";
				voteDiv.insert(voteforimg);
				if (!node.positivevotes) {
					node.positivevotes = 0;
				}

				if(USER != ""){
					voteforimg.style.cursor = 'pointer';
					if (node.uservote && node.uservote == 'Y') {
						Event.observe(voteforimg,'click',function (){ deleteNodeVote(this) } );
						voteforimg.setAttribute('src', '<?php echo $HUB_FLM->getImagePath("thumb-up-filled3.png"); ?>');
						voteforimg.setAttribute('title', '<?php echo $LNG->NODE_VOTE_REMOVE_HINT; ?>');
					} else if (!node.uservote || node.uservote != 'Y') {
						Event.observe(voteforimg,'click',function (){ nodeVote(this) } );
						voteforimg.setAttribute('src', '<?php echo $HUB_FLM->getImagePath("thumb-up-empty3.png"); ?>');
						voteforimg.setAttribute('title', '<?php echo $LNG->NODE_VOTE_FOR_ADD_HINT; ?>');
					}
					voteDiv.insert('<b><span id="nodevotefor'+node.nodeid+'">'+node.positivevotes+'</span></b>');
				} else {
					voteforimg.setAttribute('title', '<?php echo $LNG->NODE_VOTE_FOR_LOGIN_HINT; ?>');
					voteDiv.insert('<b><span id="nodevotefor'+node.nodeid+'">'+node.positivevotes+'</span></b>');
				}

				// vote against
				var voteagainstimg = document.createElement('img');
				voteagainstimg.setAttribute('src', '<?php echo $HUB_FLM->getImagePath("thumb-down-grey3.png"); ?>');
				voteagainstimg.setAttribute('alt', '<?php echo $LNG->NODE_VOTE_AGAINST_ICON_ALT; ?>');
				voteagainstimg.setAttribute('id', 'nodeagainst'+node.nodeid);
				voteagainstimg.nodeid = node.nodeid;
				voteagainstimg.vote='N';
				voteagainstimg.style.verticalAlign="bottom";
				voteagainstimg.style.marginRight="3px";
				voteDiv.insert(voteagainstimg);
				if (!node.negativevotes) {
					node.negativevotes = 0;
				}
				if(USER != ""){
					voteagainstimg.style.cursor = 'pointer';
					if (node.uservote && node.uservote == 'N') {
						Event.observe(voteagainstimg,'click',function (){ deleteNodeVote(this) } );
						voteagainstimg.setAttribute('src', '<?php echo $HUB_FLM->getImagePath("thumb-down-filled3.png"); ?>');
						voteagainstimg.setAttribute('title', '<?php echo $LNG->NODE_VOTE_REMOVE_HINT; ?>');
					} else if (!node.uservote || node.uservote != 'N') {
						Event.observe(voteagainstimg,'click',function (){ nodeVote(this) } );
						voteagainstimg.setAttribute('src', '<?php echo $HUB_FLM->getImagePath("thumb-down-empty3.png"); ?>');
						voteagainstimg.setAttribute('title', '<?php echo $LNG->NODE_VOTE_AGAINST_ADD_HINT; ?>');
					}
					voteDiv.insert('<b><span id="nodevoteagainst'+node.nodeid+'">'+node.negativevotes+'</span></b>');
				} else {
					voteagainstimg.setAttribute('title', '<?php echo $LNG->NODE_VOTE_AGAINST_LOGIN_HINT; ?>');
					voteDiv.insert('<b><span id="nodevoteagainst'+node.nodeid+'">'+node.negativevotes+'</span></b>');
				}
			}
		}
	}

	ihDiv.insert(itDiv);

	var iwDiv = new Element("div", {'class':'idea-wrapper'});
	var imDiv = new Element("div", {'class':'idea-main'});
	var idDiv = new Element("div", {'class':'idea-detail'});

	var expandDiv = new Element("div", {'id':'desc'+uniQ,'class':'ideadata', 'style':'display:none;'} );

	var nodeTable = document.createElement( 'table' );
	nodeTable.className = "toConnectionsTable";
	expandDiv.insert(nodeTable);

	var row = nodeTable.insertRow(-1);
	var nextCell = row.insertCell(-1);
	nextCell.vAlign="middle";
	nextCell.align="left";

	// USER ICON NAME AND CREATIONS DATES
	var userbar = new Element("div", {'class':'userbar'} );

	if (includeUser == true) {

		// Add right side with user image and date below
		var iuDiv = new Element("div", {'class':'idea-user2', 'style':'clear:both;float:left;'});

		var userimageThumb = new Element('img',{'alt':user.name, 'title': user.name, 'style':'padding-right:5px;', 'src': user.thumb});

		if (type == "active") {
			var imagelink = new Element('a', {
				'href':URL_ROOT+"user.php?userid="+user.userid,
				'title':user.name});
			if (breakout != "") {
				imagelink.target = "_blank";
			}
			imagelink.insert(userimageThumb);
			iuDiv.update(imagelink);
		} else {
			iuDiv.insert(userimageThumb)
		}

		userbar.appendChild(iuDiv);
	}

	var iuDiv = new Element("div", {'style':'float:left;'});

	var dStr = "";

	var cDate = new Date(node.creationdate*1000);
	dStr += "<b><?php echo $LNG->NODE_ADDED_ON; ?> </b>"+ cDate.format(DATE_FORMAT) + "<br/>";
	dStr += "<b><?php echo $LNG->NODE_ADDED_BY; ?> </b>"+ user.name + "";

	iuDiv.insert(dStr);
	userbar.insert(iuDiv);

	nextCell.appendChild(userbar);

	// META DATA - DESCRIPTION, TAGS, URLS, LOCATION ETC

 	// add url if a resource node
 	if (RESOURCE_TYPES_STR.indexOf(role.name) != -1) {
		expandDiv.insert('<span style="margin-right:5px;"><b><?php echo $LNG->NODE_URL_HEADING; ?></b></span>');
		var link = new Element("a", {'href':node.name,'target':'_blank','title':'<?php echo $LNG->NODE_RESOURCE_LINK_HINT; ?>'} );
		link.insert(node.name);
		expandDiv.insert(link);

 		if (node.urls && node.urls.length > 0) {
 			var hasClips = false;
			var iUL = new Element("ul", {});
			for (var i=0 ; i <  node.urls.length; i++){
				if (node.urls[i].url.clip && node.urls[i].url.clip != "") {
					var link = new Element("li");
					link.insert(node.urls[i].url.clip);
					iUL.insert(link);
					hasClips = true;
				}
				if (node.urls[i].url.identifier && node.urls[i].url.identifier != "" && role.name == 'Publication') {
					expandDiv.insert('<br><span style="margin-right:5px;"><b><?php echo $LNG->FORM_LABEL_DOI; ?> </b></span><span>'+node.urls[i].url.identifier+'</span>');
				}
			}

			if (hasClips) {
				expandDiv.insert('<br><span style="margin-right:5px;"><b><?php echo $LNG->NODE_RESOURCE_CLIPS_HEADING; ?> </b></span><br>');
			}
			expandDiv.insert(iUL);
		}
	}

	//tags
	if(node.tags && node.tags.length > 0){
		var grpStr = "<div style='padding:0px; margin-top:5px;margin-bottom:5px;'><b><?php echo $LNG->NODE_TAGS_HEADING; ?> </b>";
		for (var i=0 ; i <  node.tags.length; i++){
			var tag = null;
			if (node.tags[i].name) {
				tag = node.tags[i];
			} else {
				tag = node.tags[i].tag
			}

			if (type == "active") {
				grpStr += '<a href="'+URL_ROOT+'search.php?q='+tag.name+'&fromid='+node.nodeid+'&scope=all&tagsonly=true">'+tag.name+'</a>';
			} else {
				grpStr += tag.name;
			}
			if (i < node.tags.length-1) {
				grpStr += ',';
			}
		}

		grpStr += '</div>';
		expandDiv.insert(grpStr);
	}

	var searchid="";
	if (node.searchid) {
		searchid = node.searchid;
	}

	if (COMMENT_TYPES.indexOf(role.name) != -1 || role.name == "Idea") {
		var commentdiv = new Element("div", { 'id':'commentdiv'+uniQ, 'name':'commentdiv', 'class':'d-block commentdiv'});
		expandDiv.insert(commentdiv);
		if (role.name == "Idea") {
			childcommentload(commentdiv, node.nodeid, "<?php echo $CFG->LINK_COMMENT_BUILT_FROM; ?>", "Solution,Issue,Challenge,Claim,"+EVIDENCE_TYPES_STR, uniQ, searchid);
		} else {
			childchatusageload(commentdiv, node.nodeid,"<?php echo $CFG->LINK_COMMENT_NODE; ?>", EVIDENCE_TYPES_STR+","+BASE_TYPES_STR+","+COMMENT_TYPES, uniQ, searchid);
		}
	} else if (EVIDENCE_TYPES.indexOf(role.name) != -1 || role.name == "Challenge" || role.name == "Issue" || role.name == "Solution" || role.name == "Claim") {
		var commentdiv = new Element("div", { 'id':'commentdiv'+uniQ, 'name':'commentdiv', 'class':'d-block commentdiv'});
		expandDiv.insert(commentdiv);
		childcommentload(commentdiv, node.nodeid,"<?php echo $CFG->LINK_COMMENT_BUILT_FROM; ?>", COMMENT_TYPES+",Idea", uniQ, searchid);
	}

	var dStr = "";

	if (RESOURCE_TYPES_STR.indexOf(role.name) == -1) {
		if(node.description || node.hasdesc){
			dStr += '<div style="margin:0px;padding=0px;" class="idea-desc" id="desc'+uniQ+'div"><span style="margin-top: 5px;"><b><?php echo $LNG->NODE_DESC_HEADING; ?> </b></span><br>';
			if (node.description && node.description != "") {
				expandDiv.description = true;
				dStr += node.description;
			}
			dStr += '</div>';
			expandDiv.insert(dStr);
		}
	}

	// CHILD LISTS
	if (role.name == 'Challenge') {
		expandDiv.insert('<div style="clear:both;"></div>');

		var issueStr = "<span style='font-weight:bold;display:none;float:left;margin-top:5px;' id='toggleissue"+uniQ+"'";
		issueStr += ">";
		issueStr += "<?php echo $LNG->NODE_CHILDREN_ISSUE; ?>";
		issueStr += " (<span id='countissue"+uniQ+"'>0</span>) ";

		expandDiv.insert(issueStr);
		var issueDiv = new Element("div", {'id':'issue'+uniQ, 'style':'clear:both;float:left;margin-left:5px;margin-bottom:5px;color:Gray;display:none;'} );
		expandDiv.insert(issueDiv);

		expandDiv.insert('<div style="clear:both;"></div>');

		var solutionStr = "<span style='font-weight:bold;display:none;float:left;margin-top:5px;' id='togglesolution"+uniQ+"'";
		solutionStr += ">";
		solutionStr += "<?php echo $LNG->NODE_CHILDREN_SOLUTION; ?>";
		solutionStr += " (<span id='countsolution"+uniQ+"'>0</span>) ";

		expandDiv.insert(solutionStr);
		var solutionDiv = new Element("div", {'id':'solution'+uniQ, 'style':'clear:both;float:left;margin-left:5px;margin-bottom:5px;color:Gray;display:none;'} );
		expandDiv.insert(solutionDiv);

		expandDiv.insert('<div style="clear:both;"></div>');

		var claimStr = "<span style='font-weight:bold;display:none;float:left;margin-top:5px;' id='toggleclaim"+uniQ+"'";
		claimStr += ">";
		claimStr += "<?php echo $LNG->NODE_CHILDREN_CLAIM; ?>";
		claimStr += " (<span id='countclaim"+uniQ+"'>0</span>) ";

		expandDiv.insert(claimStr);
		var claimDiv = new Element("div", {'id':'claim'+uniQ, 'style':'clear:both;float:left;margin-left:5px;margin-bottom:5px;color:Gray;display:none;'} );
		expandDiv.insert(claimDiv);

		expandDiv.insert('<div style="clear:both;"></div>');
	} else if (role.name == 'Issue') {
		expandDiv.insert('<div style="clear:both;"></div>');

		var solutionStr = "<span style='font-weight:bold;display:none;float:left;margin-top:5px;' id='togglesolution"+uniQ+"'";
		solutionStr += "'>";
		solutionStr += "<?php echo $LNG->NODE_CHILDREN_SOLUTION; ?>";
		solutionStr += " (<span id='countsolution"+uniQ+"'>0</span>) ";

		expandDiv.insert(solutionStr);
		var solutionDiv = new Element("div", {'id':'solution'+uniQ, 'style':'clear:both;float:left;margin-left:5px;margin-bottom:5px;color:Gray;display:none;'} );
		expandDiv.insert(solutionDiv);

		expandDiv.insert('<div style="clear:both;"></div>');

		var claimStr = "<span style='font-weight:bold;display:none;float:left;margin-top:5px;' id='toggleclaim"+uniQ+"'";
		claimStr += ">";
		claimStr += "<?php echo $LNG->NODE_CHILDREN_CLAIM; ?>";
		claimStr += " (<span id='countclaim"+uniQ+"'>0</span>) ";

		expandDiv.insert(claimStr);
		var claimDiv = new Element("div", {'id':'claim'+uniQ, 'style':'clear:both;float:left;margin-left:5px;margin-bottom:5px;color:Gray;display:none;'} );
		expandDiv.insert(claimDiv);

		expandDiv.insert('<div style="clear:both;"></div>');
	} else if (role.name == 'Claim' || role.name == 'Solution') {
		expandDiv.insert('<div style="clear:both;"></div>');

		var supportStr = "<span style='font-weight:bold;display:none;float:left;margin-top:5px;' id='togglesupport"+uniQ+"'";
		supportStr += ">";
		supportStr += "<?php echo $LNG->NODE_CHILDREN_EVIDENCE_PRO; ?>";
		supportStr += " (<span id='countsupport"+uniQ+"'>0</span>) ";

		expandDiv.insert(supportStr);
		var supportDiv = new Element("div", {'id':'support'+uniQ, 'style':'clear:both;float:left;margin-left:5px;margin-bottom:5px;color:Gray;display:none;'} );
		expandDiv.insert(supportDiv);

		expandDiv.insert('<div style="clear:both;"></div>');

		var opposeStr = "<span style='font-weight:bold;display:none;float:left;margin-top:5px;' id='toggleoppose"+uniQ+"'";
		opposeStr += ">";
		opposeStr += "<?php echo $LNG->NODE_CHILDREN_EVIDENCE_CON; ?>";
		opposeStr += " (<span id='countoppose"+uniQ+"'>0</span>) ";

		expandDiv.insert(opposeStr);
		var opposingDiv = new Element("div", {'id':'oppose'+uniQ, 'style':'clear:both;float:left;margin-left:5px;margin-bottom:5px;color:Gray;display:none;'} );
		expandDiv.insert(opposingDiv);

		expandDiv.insert('<div style="clear:both;"></div>');
	} else if (EVIDENCE_TYPES_STR.indexOf(role.name) != -1) {
		expandDiv.insert('<div style="clear:both;"></div>');

		var resourceStr = "<span style='font-weight:bold;display:none;float:left;margin-top:5px;' id='toggleresource"+uniQ+"'";
		resourceStr += ">";
		resourceStr += "<?php echo $LNG->NODE_CHILDREN_RESOURCES; ?>";
		resourceStr += " (<span id='countresource"+uniQ+"'>0</span>) ";

		expandDiv.insert(resourceStr);
		var resourceDiv = new Element("div", {'id':'resource'+uniQ, 'style':'clear:both;float:left;margin-bottom:5px;color:Gray;display:none;'} );
		expandDiv.insert(resourceDiv);

		expandDiv.insert('<div style="clear:both;"></div>');

	} else if (role.name == 'Comment' && node.connection) {
		var tN = node.connection.to[0].cnode;
		var tRole = tN.role[0].role;
		var title=tN.name;
		if (RESOURCE_TYPES_STR.indexOf(tRole.name) != -1) {
			title = tN.description;
		}

		if (tN.role[0].role.name == "Comment") {
			var nextStr = "<span style='font-weight:bold;float:left;margin-top:5px;'>";
			nextStr += "<?php echo $LNG->NODE_COMMENT_PARENT; ?> ";
			nextStr += "<span>"+title+"</span>";
			nextStr += "</span>";
			expandDiv.insert(nextStr);
			if (node.connection.parentnode) {
				var nextStr = "<span style='font-weight:bold;clear:both;float:left;margin-top:5px;'>";
				nextStr += "<?php echo $LNG->CHAT_COMMENT_PARENT_TREE; ?> ";
				nextStr += "</span>";
				expandDiv.insert(nextStr);
				var icon = getNodeIconElement(node.connection.parentnode[0].cnode);
				var title = node.connection.parentnode[0].cnode.name;
				var parentid = node.connection.parentnode[0].cnode.nodeid;
				var exploreButton = new Element("a", {'class':'d-block','title':'<?php echo $LNG->NODE_CHAT_BUTTON_HINT; ?>'} );
				if (icon != null) {
					exploreButton.insert(icon);
					exploreButton.insert('<span class="col-auto">'+title+'</span>');
				} else {
					exploreButton.insert(title);
				}
				exploreButton.href= "chats.php?chatnodeid="+node.nodeid+"&id="+parentid;
				expandDiv.insert(exploreButton);
			}
		} else {
			var nextStr = "<span style='font-weight:bold;float:left;margin-top:5px;'>";
			nextStr += "<?php echo $LNG->NODE_COMMENT_PARENT; ?> ";
			nextStr += "</span>";
			expandDiv.insert(nextStr);

			var icon = getNodeIconElement(tN);
			var exploreButton = new Element("a", {'class':'d-block','title':'<?php echo $LNG->NODE_CHAT_BUTTON_HINT; ?>'} );
			if (icon != null) {
				exploreButton.insert(icon);
				exploreButton.insert('<span class="col-auto">'+title+'</span>');
			} else {
				exploreButton.insert(title);
			}
			exploreButton.href= "chats.php?chatnodeid="+node.nodeid+"&id="+tN.nodeid;
			expandDiv.insert(exploreButton);
		}
	}

	idDiv.insert(expandDiv);
	imDiv.insert(idDiv);
	iwDiv.insert(imDiv);
	iDiv.insert(ihDiv);
	iDiv.insert(iwDiv);

	return iDiv;
}

/**
 * Render the given node from an associated connection in the knowledge tree.
 * @param node the node object do render
 * @param uniQ is a unique id element prepended to the nodeid to form an overall unique id within the currently visible site elements
 * @param role the role object for this node
 * @param includeUser whether to include the user image and link
 * @param type defaults to 'active', but can be 'inactive' so nothing is clickable
 * 			or a specialized type for some of the popups
 * @param childCountSpan The element into which to put the running total of children in this conneciotn tree..
 * @param parentrefreshhandler a statment to eval after actions have occurred to refresh this list.
 */
function renderConnectionNode(node, uniQ, role, includeUser, type, childCountSpan, parentrefreshhandler){

	if (type === undefined) {
		type = "active";
	}

	if (childCountSpan === undefined) {
		childCountSpan = null;
	}

	var originaluniQ = uniQ;

	if(role === undefined){
		role = node.role[0].role;
	}

	var nodeuser = null;
	// JSON structure different if coming from popup where json_encode used.
	if (node.users[0].userid) {
		nodeuser = node.users[0];
	} else {
		nodeuser = node.users[0].user;
	}
	var connection = node.connection;
	var user = null;
	if (connection) {
		user = connection.users[0].user;
	}
	//needs to check if embedded as a snippet
	var breakout = "";
	if(top.location != self.location){
		breakout = " target='_blank'";
	}

	var focalnodeid = "";
	if (node.focalnodeid) {
		focalnodeid = node.focalnodeid;
	}
	var focalrole = "";
	var connrole = role;
	var otherend = "";
	if (connection) {
		uniQ = connection.connid+uniQ;
		var fN = connection.from[0].cnode;
		var tN = connection.to[0].cnode;
		if (node.nodeid == fN.nodeid) {
			connrole = connection.fromrole[0].role;
			focalrole = tN.role[0].role;
			otherend = tN;
		} else {
			connrole = connection.torole[0].role;
			focalrole = fN.role[0].role;
			otherend = fN;
		}
	} else {
		uniQ = node.nodeid + uniQ;
	}

	var iDiv = new Element("div", {'class':'d-block'});
	var ihDiv = new Element("div", {'class':'d-block'});
	var itDiv = new Element("div", {'class':'idea-title'});

	var nodeTable = document.createElement( 'table' );
	nodeTable.className = "toConnectionsTable";

	itDiv.insert(nodeTable);

	var row = nodeTable.insertRow(-1);

	// ADD THE ARROW IF REQUIRED
	if (node.istop) {
		var expandArrow = null;
		if (EVIDENCE_TYPES_STR.indexOf(role.name) != -1 || role.name == "Challenge"
			|| role.name == "Issue" || role.name == "Solution" || role.name == "Claim") {

			var arrowCell = row.insertCell(-1);

			if (DEBATE_TREE_OPEN_ARRAY["desc"+uniQ] && DEBATE_TREE_OPEN_ARRAY["desc"+uniQ] == true) {
				expandArrow = new Element('span', {'id':'explorearrow'+uniQ });
				expandArrow = new Element('img',{'id':'explorearrow'+uniQ, 'name':'explorearrow', 'class':'explorearrow', 'alt':'>', 'title':"<?php echo $LNG->NODE_DEBATE_TOGGLE; ?>",'src': '<?php echo $HUB_FLM->getImagePath("arrow-down-blue.png"); ?>'});
				expandArrow.uniqueid = uniQ;
			} else {
				expandArrow = new Element('span', {'id':'explorearrow'+uniQ });
				expandArrow = new Element('img',{'id':'explorearrow'+uniQ, 'name':'explorearrow', 'class':'explorearrow', 'alt':'>', 'title':"<?php echo $LNG->NODE_DEBATE_TOGGLE; ?>",'src': '<?php echo $HUB_FLM->getImagePath("arrow-right-blue.png"); ?>'});
				expandArrow.uniqueid = uniQ;
			}
			Event.observe(expandArrow,'click',function (){ toggleDebate("treedesc"+uniQ,uniQ);});
			arrowCell.insert(expandArrow);
		}
	} else {
		var lineCell = row.insertCell(-1);
		lineCell.width="15px;"
		lineCell.vAlign="middle";
		var lineDiv = new Element('div',{'class':'graylinewide', 'style':'float:left;width:100%;'});
		lineCell.insert(lineDiv);
	}

	var textCell = row.insertCell(-1);
	textCell.vAlign="middle";
	textCell.align="left";
	var textCellDiv = new Element("div", { 'id':'textDivCell'+uniQ, 'name':'textDivCell', 'class':'textDivCell whiteborder'});
	textCellDiv.nodeid = node.nodeid;
	textCellDiv.focalnodeid = node.focalnodeid;
	textCellDiv.nodetype = role.name;
	textCellDiv.parentuniQ = originaluniQ;
	if (connection) {
		textCellDiv.connection = connection;
	}

	if (node.nodeid == CURRENT_ADD_AREA_NODEID) {
		var bordercolor = 'plainborder';
		var backcolor = 'focusedback';
		var nodetype = role.name;
		if (nodetype == 'Challenge') {
			bordercolor = 'challengeborder';
			if (node.nodeid == node.focalnodeid) {
				backcolor = 'challengeback';
			}
		} else if (nodetype == 'Issue') {
			bordercolor = 'issueborder';
			if (node.nodeid == node.focalnodeid) {
				backcolor = 'issueback';
			}
		} else if (nodetype == 'Claim') {
			bordercolor = 'claimborder';
			if (node.nodeid == node.focalnodeid) {
				backcolor = 'claimback';
			}
		} else if (nodetype == 'Solution') {
			bordercolor = 'solutionborder';
			if (node.nodeid == node.focalnodeid) {
				backcolor = 'solutionback';
			}
		} else if (EVIDENCE_TYPES_STR.indexOf(nodetype) != -1) {
			bordercolor = 'evidenceborder';
			if (node.nodeid == node.focalnodeid) {
				backcolor = 'evidenceback';
			}
		} else if (RESOURCE_TYPES_STR.indexOf(nodetype) != -1) {
			bordercolor = 'resourceborder';
			if (node.nodeid == node.focalnodeid) {
				backcolor = 'resourceback';
			}
		}

		//if (node.nodeid == node.focalnodeid) {
		//	bordercolor = 'selectedborder';
		//}

		textCellDiv = new Element("div", { 'id':'textDivCell'+uniQ, 'name':'textDivCell', 'class':'textDivCell '+backcolor+' '+bordercolor});
		textCellDiv.nodeid = node.nodeid;
		textCellDiv.nodetype = role.name;
		textCellDiv.focalnodeid = node.focalnodeid;
		textCellDiv.parentuniQ = originaluniQ;
		if (connection) {
			textCellDiv.connection = connection;
		}
	} else if (node.nodeid == node.focalnodeid) {
		var bordercolor = 'plainborder';
		var backcolor = 'whiteback';
		var nodetype = role.name;
		if (nodetype == 'Challenge') {
			bordercolor = 'challengeborder';
			backcolor = 'challengeback';
		} else if (nodetype == 'Issue') {
			bordercolor = 'issueborder';
			backcolor = 'issueback';
		} else if (nodetype == 'Claim') {
			bordercolor = 'claimborder';
			backcolor = 'claimback';
		} else if (nodetype == 'Solution') {
			bordercolor = 'solutionborder';
			backcolor = 'solutionback';
		} else if (EVIDENCE_TYPES_STR.indexOf(nodetype) != -1) {
			bordercolor = 'evidenceborder';
			backcolor = 'evidenceback';
		} else if (RESOURCE_TYPES_STR.indexOf(nodetype) != -1) {
			bordercolor = 'resourceborder';
			backcolor = 'resourceback';
		}
		textCellDiv = new Element("div", { 'id':'textDivCell'+uniQ, 'name':'textDivCell', 'class':'textDivCell '+backcolor+' '+bordercolor});
		textCellDiv.nodeid = node.nodeid;
		textCellDiv.nodetype = role.name;
		textCellDiv.focalnodeid = node.focalnodeid;
		textCellDiv.parentuniQ = originaluniQ;
		if (connection) {
			textCellDiv.connection = connection;
		}
	}

	var toolbarCell = row.insertCell(-1);
	toolbarCell.vAlign="middle";
	toolbarCell.align="left";
	toolbarCell.width="80";

	textCell.insert(textCellDiv);

	var cDate = new Date(connection.creationdate*1000);
	var dStr = "<?php echo $LNG->NODE_CONNECTED_BY; ?> "+user.name+ " on "+cDate.format(DATE_FORMAT)+' - <?php echo $LNG->NODE_TOGGLE_HINT;?>'

	// ADD THE NODE ICON
	var nodeArea = new Element("a", {'class':'itemtext', 'name':'nodeArea','title':dStr} );
	nodeArea.nodeid = node.nodeid;
	nodeArea.focalnodeid = node.focalnodeid;
	var alttext = getNodeTitleAntecedence(role.name, false);
	if (node.imagethumbnail != null && node.imagethumbnail != "") {
		var originalurl = "";
		if(node.urls && node.urls.length > 0){
			for (var i=0 ; i <  node.urls.length; i++){
				var urlid = node.urls[i].url.urlid;
				if (urlid == node.imageurlid) {
					originalurl = node.urls[i].url.url;
					break;
				}
			}
		}
		if (originalurl == "") {
			originalurl = node.imagethumbnail;
		}
		var iconlink = new Element('a', {
			'href':originalurl,
			'title':"<?php echo $LNG->NODE_TYPE_ICON_HINT; ?>", 'target': '_blank' });
		var nodeicon = new Element('img',{'alt':"<?php echo $LNG->NODE_TYPE_ICON_HINT; ?>", 'src': URL_ROOT + node.imagethumbnail});
		iconlink.insert(nodeicon);
		nodeArea.insert(iconlink);
		nodeArea.insert(alttext+": ");
	} else if (connrole.image != null && connrole.image != "") {
		var nodeicon = new Element('img',{'alt':alttext, 'title':alttext,'src': URL_ROOT + connrole.image});
		nodeArea.insert(nodeicon);
	} else {
		nodeArea.insert(alttext+": ");
	}

	// ADD THE NODE LABEL
	textCellDiv.appendChild(nodeArea);
	if (type == 'active' && role.name != 'Comment') {
		if (node.nodeid == CURRENT_ADD_AREA_NODEID) {
			if (node.nodeid == node.focalnodeid) {
				nodeArea.className = "itemtextwhite";
			} else {
				nodeArea.className = "itemtext selectedlabel";
			}
		} else {
			if (node.nodeid == node.focalnodeid) {
				nodeArea.className = "itemtextwhite";
			} else {
				nodeArea.className = "itemtext unselectedlabel";
			}
		}

		var nodeextra = getNodeTitleAntecedence(role.name, true);
		if (RESOURCE_TYPES_STR.indexOf(connrole.name) != -1) {
			nodeArea.insert("<span style='font-style:italic'>"+nodeextra+"</span>"+node.description);
		} else {
			nodeArea.insert("<span style='font-style:italic'>"+nodeextra+"</span>"+node.name);
		}

		nodeArea.href= "#";
		Event.observe(nodeArea,'click',function (){
			ideatoggle3("desc"+uniQ, uniQ, node.nodeid,"desc",role.name);
		});
	} else if (type == 'active' && role.name == 'Comment' && connection && CONTEXT == USER_CONTEXT) {
		nodeArea.insert(node.name);
		nodeArea.href= "explore.php?id="+connection.to[0].cnode.nodeid;
	}

	if (node.istop) {
		var expandArrow = null;
		if (EVIDENCE_TYPES_STR.indexOf(role.name) != -1 || role.name == "Challenge"
			|| role.name == "Issue" || role.name == "Solution" || role.name == "Claim") {

			var childCount = new Element('div',{'class':'toptreecount', 'title':'<?php echo $LNG->NODE_DEBATE_TREE_COUNT_HINT; ?>'});
			childCount.insert("(");
			childCountSpan = new Element('span',{'name':'toptreecount'});
			childCountSpan.id = 'toptreecount'+uniQ;
			childCountSpan.insert(1);
			childCountSpan.uniqueid = uniQ;
			childCount.insert(childCountSpan);
			childCount.insert(")");
			toolbarCell.insert(childCount);
		}
	}

	// ADD ACTION MENU
	var menuButton = null;
	if (type == 'active') {
		menuButton = new Element('img',{'alt':'>', 'class':'menuicon', 'src': '<?php echo $HUB_FLM->getImagePath("add.png"); ?>'});
		toolbarCell.appendChild(menuButton);
		Event.observe(menuButton,'mouseout',function (event){
			hideBox('toolbardiv'+uniQ);
		});
		Event.observe(menuButton,'mouseover',function (event) {

			var position = getPosition(this);
			var panel = $('toolbardiv'+uniQ);
			var panelWidth = 185;

			var viewportHeight = getWindowHeight();
			var viewportWidth = getWindowWidth();

			var x = position.x;
			var y = position.y;

			if ( (x+panelWidth+30) > viewportWidth) {
				x = x-(panelWidth+30);
			} else {
				x = x+10;
			}

			x = x+30+getPageOffsetX();

			panel.style.left = x+"px";
			panel.style.top = y+"px";

			showBox('toolbardiv'+uniQ);
		});

		var toolbarDiv = new Element("div", {'id':'toolbardiv'+uniQ, 'class':'toolbarDiv', 'style':'left:-1px;top:-1px;clear:both;position:absolute;display:none;z-index:60;padding:5px 15px;border:1px solid gray;background:white'} );
		Event.observe(toolbarDiv,'mouseout',function (event){
			hideBox('toolbardiv'+uniQ);
		});
		Event.observe(toolbarDiv,'mouseover',function (event){ showBox('toolbardiv'+uniQ); });
		toolbarCell.appendChild(toolbarDiv);

		var key="";
		var handler = "";
		var nodetofocusid = "";
		var nodeid = node.nodeid;

		// ADD BUTTON
		if (RESOURCE_TYPES_STR.indexOf(role.name) == -1 || (nodeObj && node.nodeid == nodeObj.nodeid)) {
			if (USER != "") {

				var theme = "";
				if (nodeObj && nodeObj.role.name == 'Theme') {
					var decodedTheme = htmlspecialchars_decode(nodeObj.name);
					theme = escape(encodeURIComponent(decodedTheme));
				}

				if (role.name == 'Claim') {
					var linktype = '<?php echo $CFG->LINK_EVIDENCE_SOLCLAIM_PRO; ?>';
					toolbarDiv.insert('<a class="d-block" title="<?php echo $LNG->WIDGET_EVIDENCE_ADD_HINT; ?>" href="javascript: loadDialog(\'evidenceconnect\', \''+URL_ROOT+'ui/popups/evidenceconnect.php?linknodetypename=Pro&linktypename='+linktype+'&focalnodeid='+node.nodeid+'&focalnodeend=to&filternodetypes='+EVIDENCE_TYPES+'&handler=&type=Pro&theme='+theme+'\', 770,600);" ><img style="vertical-align:middle;" src="<?php echo $HUB_FLM->getImagePath('add.png'); ?>" border="0" width="16" height="16" style="margin:0px;margin-left: 5px;padding:0px" alt="add" /> <?php echo $LNG->NODE_DEBATE_ADD_TO_PRO_MENU_TEXT; ?></a>');

					var linktype = '<?php echo $CFG->LINK_EVIDENCE_SOLCLAIM_CON; ?>';
					toolbarDiv.insert('<a class="d-block" title="<?php echo $LNG->WIDGET_EVIDENCE_ADD_HINT; ?>" href="javascript: loadDialog(\'evidenceconnect\', \''+URL_ROOT+'ui/popups/evidenceconnect.php?linknodetypename=Con&linktypename='+linktype+'&focalnodeid='+node.nodeid+'&focalnodeend=to&filternodetypes='+EVIDENCE_TYPES+'&handler=&type=Con&theme='+theme+'\', 770,600);" ><img style="vertical-align:middle;" src="<?php echo $HUB_FLM->getImagePath('add.png'); ?>" border="0" width="16" height="16" style="margin:0px;margin-left: 5px;padding:0px" alt="add" /> <?php echo $LNG->NODE_DEBATE_ADD_TO_CON_MENU_TEXT; ?></a>');
				} else if (role.name == 'Solution') {
					var linktype = '<?php echo $CFG->LINK_EVIDENCE_SOLCLAIM_PRO; ?>';
					toolbarDiv.insert('<a class="d-block" title="<?php echo $LNG->WIDGET_EVIDENCE_ADD_HINT; ?>" href="javascript: loadDialog(\'evidenceconnect\', \''+URL_ROOT+'ui/popups/evidenceconnect.php?linknodetypename=Pro&linktypename='+linktype+'&focalnodeid='+node.nodeid+'&focalnodeend=to&filternodetypes='+EVIDENCE_TYPES+'&handler=&type=Pro&theme='+theme+'\', 770,600);" ><img style="vertical-align:middle;" src="<?php echo $HUB_FLM->getImagePath('add.png'); ?>" border="0" width="16" height="16" style="margin:0px;margin-left: 5px;padding:0px" alt="add" /> <?php echo $LNG->NODE_DEBATE_ADD_TO_PRO_MENU_TEXT; ?></a>');

					var linktype = '<?php echo $CFG->LINK_EVIDENCE_SOLCLAIM_CON; ?>';
					toolbarDiv.insert('<a class="d-block" title="<?php echo $LNG->WIDGET_EVIDENCE_ADD_HINT; ?>" href="javascript: loadDialog(\'evidenceconnect\', \''+URL_ROOT+'ui/popups/evidenceconnect.php?linknodetypename=Con&linktypename='+linktype+'&focalnodeid='+node.nodeid+'&focalnodeend=to&filternodetypes='+EVIDENCE_TYPES+'&handler=&type=Con&theme='+theme+'\', 770,600);" ><img style="vertical-align:middle;" src="<?php echo $HUB_FLM->getImagePath('add.png'); ?>" border="0" width="16" height="16" style="margin:0px;margin-left: 5px;padding:0px" alt="add" /> <?php echo $LNG->NODE_DEBATE_ADD_TO_CON_MENU_TEXT; ?></a>');
				} else if (role.name == 'Challenge') {

					// hide the issue add button if issues are managed
					<?php if ( $CFG->issuesManaged == false || ($CFG->issuesManaged == true && $USER->getIsAdmin() == "Y") ) { ?>
						var model = HUB_DATAMODEL.challengeToIssue;
						var filternodetypes = model.getOtherEnd();
						var linktypename = model.linktypes;
						var focalnodeend = model.direction;
						var hint = model.hint;
						toolbarDiv.insert('<a class="d-block" id="addknowledge'+key+'button" title="'+hint+'" href="javascript: loadDialog(\'issueconnect\', \''+URL_ROOT+'ui/popups/issueconnect.php?linktypename='+linktypename+'&focalnodeid='+nodeid+'&focalnodeend='+focalnodeend+'&filternodetypes='+filternodetypes+'&handler=&theme='+theme+'\', 770,600);"><img style="vertical-align:middle;" src="<?php echo $HUB_FLM->getImagePath('add.png'); ?>" border="0" width="16" height="16" style="margin:0px;margin-left: 5px;padding:0px" alt="add" /> <?php echo $LNG->NODE_DEBATE_ADD_TO_ISSUE_MENU_TEXT; ?></a>');
					<?php } ?>

				} else if (role.name == 'Issue') {
					if (hasClaim && hasSolution) {
						var model = HUB_DATAMODEL.issueToSolution;
						var filternodetypes = model.getOtherEnd();
						var linktypename = model.linktypes;
						var focalnodeend = model.direction;
						var hint = model.hint;
						toolbarDiv.insert('<a class="d-block" id="addknowledge'+key+'button" title="'+hint+'" href="javascript: loadDialog(\'solutionconnect\', \''+URL_ROOT+'ui/popups/solutionconnect.php?linktypename='+linktypename+'&focalnodeid='+nodeid+'&focalnodeend='+focalnodeend+'&filternodetypes='+filternodetypes+'&handler=&theme='+theme+'\', 770,600);"><img style="vertical-align:middle;" src="<?php echo $HUB_FLM->getImagePath('add.png'); ?>" border="0" width="16" height="16" style="margin:0px;margin-left: 5px;padding:0px" alt="add" /> <?php echo $LNG->NODE_DEBATE_ADD_TO_SOLUTION_MENU_TEXT; ?></a>');

						var model = HUB_DATAMODEL.issueToClaim;
						var filternodetypes = model.getOtherEnd();
						var linktypename = model.linktypes;
						var focalnodeend = model.direction;
						var hint = model.hint;
						toolbarDiv.insert('<a class="d-block" id="addknowledge'+key+'button" title="'+hint+'" href="javascript: loadDialog(\'claimconnect\', \''+URL_ROOT+'ui/popups/claimconnect.php?linktypename='+linktypename+'&focalnodeid='+nodeid+'&focalnodeend='+focalnodeend+'&filternodetypes='+filternodetypes+'&handler=&theme='+theme+'\', 770,600);"><img style="vertical-align:middle;" src="<?php echo $HUB_FLM->getImagePath('add.png'); ?>" border="0" width="16" height="16" style="margin:0px;margin-left: 5px;padding:0px" alt="add" /> <?php echo $LNG->NODE_DEBATE_ADD_TO_CLAIM_MENU_TEXT; ?></a>');

					} else if (hasSolution) {
						var model = HUB_DATAMODEL.issueToSolution;
						var filternodetypes = model.getOtherEnd();
						var linktypename = model.linktypes;
						var focalnodeend = model.direction;
						var hint = model.hint;
						toolbarDiv.insert('<a class="d-block" id="addknowledge'+key+'button" title="'+hint+'" href="javascript: loadDialog(\'solutionconnect\', \''+URL_ROOT+'ui/popups/solutionconnect.php?linktypename='+linktypename+'&focalnodeid='+nodeid+'&focalnodeend='+focalnodeend+'&filternodetypes='+filternodetypes+'&handler=&theme='+theme+'\', 770,600);"><img style="vertical-align:middle;" src="<?php echo $HUB_FLM->getImagePath('add.png'); ?>" border="0" width="16" height="16" style="margin:0px;margin-left: 5px;padding:0px" alt="add" /> <?php echo $LNG->NODE_DEBATE_ADD_TO_SOLUTION_MENU_TEXT; ?></a>');
					} else if (hasClaim) {
						var model = HUB_DATAMODEL.issueToClaim;
						var filternodetypes = model.getOtherEnd();
						var linktypename = model.linktypes;
						var focalnodeend = model.direction;
						var hint = model.hint;
						toolbarDiv.insert('<a class="d-block" id="addknowledge'+key+'button" title="'+hint+'" href="javascript: loadDialog(\'claimconnect\', \''+URL_ROOT+'ui/popups/claimconnect.php?linktypename='+linktypename+'&focalnodeid='+nodeid+'&focalnodeend='+focalnodeend+'&filternodetypes='+filternodetypes+'&handler=&theme='+theme+'\', 770,600);"><img style="vertical-align:middle;" src="<?php echo $HUB_FLM->getImagePath('add.png'); ?>" border="0" width="16" height="16" style="margin:0px;margin-left: 5px;padding:0px" alt="add" /> <?php echo $LNG->NODE_DEBATE_ADD_TO_CLAIM_MENU_TEXT; ?></a>');
					}
				} else if (EVIDENCE_TYPES_STR.indexOf(role.name) != -1) {
					var model = HUB_DATAMODEL.evidenceToResource;
					var filternodetypes = model.getOtherEnd();
					var linktypename = model.linktypes;
					var focalnodeend = model.direction;
					let hint = model.hint;
					let alink = '<a class="d-block" id="addknowledge'+key+'button" title="';
					alink += hint;
					alink += '" href="javascript: loadDialog(\'resourceconnect\', \''+URL_ROOT+'ui/popups/resourceconnect.php?linktypename='+linktypename+'&focalnodeid='+nodeid+'&focalnodeend='+focalnodeend+'&filternodetypes='+filternodetypes+'&handler=&theme='+theme+'\', 770,600);"><img style="vertical-align:middle;" src="<?php echo $HUB_FLM->getImagePath('add.png'); ?>" border="0" width="16" height="16" style="margin:0px;margin-left: 5px;padding:0px" alt="add" /> <?php echo $LNG->NODE_DEBATE_ADD_TO_RESOURCE_MENU_TEXT; ?></a>';
					toolbarDiv.insert(alink);
				}
			} else {
				let alink = '<span style="clear:both;float:left;cursor:pointer" onclick="$(\'loginsubmit\').click(); return true;" title="';
				alink += "<?php echo $LNG->WIDGET_SIGNIN_HINT; ?>";
				alinkg += '"><img style="vertical-align:middle;" src="<?php echo $HUB_FLM->getImagePath('addgrey.png'); ?>" border="0" width="16" height="16" style="margin:0px;margin-left: 5px;padding:0px" /> <?php echo $LNG->NODE_DEBATE_ADD_TO_MENU_TEXT; ?></span>';
				toolbarDiv.insert(alink);
			}
		}


		if (toolbarDiv.innerHTML != "" && (USER == nodeuser.userid ||
			(connection && USER == connection.users[0].user.userid &&
				node.nodeid == connection.from[0].cnode.nodeid))) {
			toolbarDiv.appendChild(createMenuSpacer());
		}


		if (USER == nodeuser.userid) {
			createEditMenuOption(toolbarDiv, node, role, parentrefreshhandler, nodeuser);
		}

		if (connection && USER == connection.users[0].user.userid &&
				node.nodeid == connection.from[0].cnode.nodeid) {

			if (COMMENT_TYPES.indexOf(role.name) == -1 ) {
				var parentname = otherend.name;
				if (parentname.length > 50) {
					parentname = parentname.substr(0, 50)+"...";
				}
				parentname = " "+parentname;

				var del = new Element('span',{'class':'active d-block','title':"<?php echo $LNG->NODE_DISCONNECT_TREE_MENU_HINT; ?> "+parentname});
				del.insert("<?php echo $LNG->NODE_DISCONNECT_MENU_TEXT; ?>");
				del.connid = connection.connid;
				var fromName = node.name;
				if (RESOURCE_TYPES_STR.indexOf(role.name) != -1) {
					fromName = node.description;
				}
				var toName = connection.to[0].cnode.name;
				if (RESOURCE_TYPES_STR.indexOf(connection.to[0].cnode.role[0].role.name) != -1) {
					toName = connection.to[0].cnode.description;
				}

				Event.observe(del,'click',function (){deleteNodeConnection(this.connid, fromName, toName, node.handler)});
				toolbarDiv.insert(del);
			}

			if (connection.description == ""
				&& (COMMENT_TYPES.indexOf(role.name) == -1
				&& role.name != "Theme" && focalrole.name != "Theme")) {
				var extra = getNodeTitleAntecedence(connection.from[0].cnode.role[0].role.name, false);
				var addRelevance = new Element('a',{'class':'d-block', 'href':'#', 'title':"<?php echo $LNG->NODE_RELEVANCE_ADD_MENU_HINT; ?> "+extra});
				addRelevance.insert("<?php echo $LNG->NODE_RELEVANCE_ADD_MENU_TEXT; ?>");
				addRelevance.connid = connection.connid;
				Event.observe(addRelevance,'click',function () { editConnectionDescription(this.connid, "") });
				toolbarDiv.insert(addRelevance);
			} else if (connection.description != ""
				&& (COMMENT_TYPES.indexOf(role.name) == -1
				&& role.name != "Theme" && focalrole.name != "Theme")) {
				var extra = getNodeTitleAntecedence(connection.from[0].cnode.role[0].role.name, false);
				var editRelevance = new Element('a',{'class':'d-block','href':'#', 'title':"<?php echo $LNG->NODE_RELEVANCE_EDIT_MENU_HINT; ?> "+extra});
				editRelevance.insert("<?php echo $LNG->NODE_RELEVANCE_EDIT_MENU_TEXT; ?>");
				editRelevance.connid = connection.connid;
				Event.observe(editRelevance,'click',function () { editConnectionDescription(this.connid, connection.description) });
				toolbarDiv.insert(editRelevance);
			}
		}

		// Add voting icons
		if (connection && connection.linktype[0].linktype.label != '<?php echo $CFG->LINK_NODE_SEE_ALSO; ?>') {
			if ( (EVIDENCE_TYPES_STR.indexOf(role.name) != -1 && (connection.torole[0].role.name == "Claim" || connection.torole[0].role.name == "Solution"))
				|| (role.name == 'Claim' && (connection.torole[0].role.name == "Issue" || connection.torole[0].role.name == "Challenge"))
				|| (role.name == 'Solution' && (connection.torole[0].role.name == "Issue" || connection.torole[0].role.name == "Challenge"))
				)  {

				if (connection && USER != connection.users[0].user.userid &&
						node.nodeid != connection.from[0].cnode.nodeid) {
					toolbarDiv.appendChild(createMenuSpacer());
				}

				var voteDiv = new Element("span", {'class':'d-block'});
				voteDiv.insert('<span><?php echo $LNG->NODE_VOTE_MENU_TEXT; ?></span>');
				Event.observe(voteDiv,'mouseover',function (event){ showBox('toolbardiv'+uniQ); });
				toolbarDiv.insert(voteDiv);

				var toRoleName = getNodeTitleAntecedence(connection.torole[0].role.name, false);

				// vote for
				var voteforimg = document.createElement('img');
				voteforimg.setAttribute('src', '<?php echo $HUB_FLM->getImagePath("thumb-up-grey.png"); ?>');
				voteforimg.setAttribute('alt', '<?php echo $LNG->NODE_VOTE_FOR_ICON_ALT; ?>');
				voteforimg.setAttribute('id', connection.connid+'for');
				voteforimg.nodeid = node.nodeid;
				voteforimg.connid = connection.connid;
				voteforimg.vote='Y';
				voteforimg.style.verticalAlign="bottom";
				voteforimg.style.marginRight="3px";
				voteforimg.style.marginLeft="10px";
				voteDiv.insert(voteforimg);
				if (!connection.positivevotes) {
					connection.positivevotes = 0;
				}
				if(USER != ""){
					voteforimg.style.cursor = 'pointer';
					if (role.name == 'Solution') {
						voteforimg.oldtitle = '<?php echo $LNG->NODE_VOTE_FOR_SOLUTION_HINT; ?> '+toRoleName;
					} else if (role.name == 'Claim') {
						voteforimg.oldtitle = '<?php echo $LNG->NODE_VOTE_FOR_CLAIM_HINT; ?> '+toRoleName;
					} else if (EVIDENCE_TYPES_STR.indexOf(role.name) != -1 && connection.torole[0].role.name == "Solution") {
						voteforimg.oldtitle = '<?php echo $LNG->NODE_VOTE_FOR_EVIDENCE_SOLUTION_HINT; ?> '+toRoleName;
					} else if (EVIDENCE_TYPES_STR.indexOf(role.name) != -1 && connection.torole[0].role.name == "Claim") {
						voteforimg.oldtitle = '<?php echo $LNG->NODE_VOTE_FOR_EVIDENCE_CLAIM_HINT; ?> '+toRoleName;
					} else {
						voteforimg.oldtitle = '<?php echo $LNG->NODE_VOTE_FOR_ADD_HINT; ?>';
					}
					if (connection.uservote && connection.uservote == 'Y') {
						Event.observe(voteforimg,'click',function (){ deleteConnectionVote(this) } );
						voteforimg.setAttribute('src', '<?php echo $HUB_FLM->getImagePath("thumb-up-filled.png"); ?>');
						voteforimg.setAttribute('title', '<?php echo $LNG->NODE_VOTE_REMOVE_HINT; ?>');
					} else if (!connection.uservote || connection.uservote != 'Y') {
						Event.observe(voteforimg,'click',function (){ connectionVote(this) } );
						voteforimg.setAttribute('src', '<?php echo $HUB_FLM->getImagePath("thumb-up-empty.png"); ?>');
						voteforimg.setAttribute('title', voteforimg.oldtitle);
					}
					voteDiv.insert('<b><span id="'+connection.connid+'votefor">'+connection.positivevotes+'</span></b>');
				} else {
					voteforimg.setAttribute('title', '<?php echo $LNG->NODE_VOTE_FOR_LOGIN_HINT; ?>');
					voteDiv.insert('<b><span id="'+connection.connid+'votefor">'+connection.positivevotes+'</span></b>');
				}

				// vote against
				var voteagainstimg = document.createElement('img');
				voteagainstimg.setAttribute('src', '<?php echo $HUB_FLM->getImagePath("thumb-down-grey.png"); ?>');
				voteagainstimg.setAttribute('alt', '<?php echo $LNG->NODE_VOTE_AGAINST_ICON_ALT; ?>');
				voteagainstimg.setAttribute('id', connection.connid+'against');
				voteagainstimg.nodeid = node.nodeid;
				voteagainstimg.connid = connection.connid;
				voteagainstimg.vote='N';
				voteagainstimg.style.verticalAlign="bottom";
				voteagainstimg.style.marginRight="3px";
				voteDiv.insert(voteagainstimg);
				if (!connection.negativevotes) {
					connection.negativevotes = 0;
				}
				if(USER != ""){
					voteagainstimg.style.cursor = 'pointer';
					if (role.name == 'Solution') {
						voteagainstimg.oldtitle = '<?php echo $LNG->NODE_VOTE_AGAINST_SOLUTION_HINT; ?> '+toRoleName;
					} else if (role.name == 'Claim') {
						voteagainstimg.oldtitle = '<?php echo $LNG->NODE_VOTE_AGAINST_CLAIM_HINT; ?> '+toRoleName;
					} else if (EVIDENCE_TYPES_STR.indexOf(role.name) != -1 && connection.torole[0].role.name == "Solution") {
						voteagainstimg.oldtitle = '<?php echo $LNG->NODE_VOTE_AGAINST_EVIDENCE_SOLUTION_HINT; ?> '+toRoleName;
					} else if (EVIDENCE_TYPES_STR.indexOf(role.name) != -1 && connection.torole[0].role.name == "Claim") {
						voteagainstimg.oldtitle = '<?php echo $LNG->NODE_VOTE_AGAINST_EVIDENCE_CLAIM_HINT; ?> '+toRoleName;
					} else {
						voteagainstimg.oldtitle = '<?php echo $LNG->NODE_VOTE_AGAINST_ADD_HINT; ?>';
					}
					if (connection.uservote && connection.uservote == 'N') {
						Event.observe(voteagainstimg,'click',function (){ deleteConnectionVote(this) } );
						voteagainstimg.setAttribute('src', '<?php echo $HUB_FLM->getImagePath("thumb-down-filled.png"); ?>');
						voteagainstimg.setAttribute('title', '<?php echo $LNG->NODE_VOTE_REMOVE_HINT; ?>');
					} else if (!connection.uservote || connection.uservote != 'N') {
						Event.observe(voteagainstimg,'click',function (){ connectionVote(this) } );
						voteagainstimg.setAttribute('src', '<?php echo $HUB_FLM->getImagePath("thumb-down-empty.png"); ?>');
						voteagainstimg.setAttribute('title', voteagainstimg.oldtitle);
					}
					voteDiv.insert('<b><span id="'+connection.connid+'voteagainst">'+connection.negativevotes+'</span></b>');
				} else {
					voteagainstimg.setAttribute('title', 'Login to Demote this');
					voteDiv.insert('<b><span id="'+connection.connid+'voteagainst">'+connection.negativevotes+'</span></b>');
				}
			}
		}

		if (toolbarDiv.innerHTML != "") {
			toolbarDiv.appendChild(createMenuSpacer());
		}

		if (connection.description != "" && node.nodeid == connection.from[0].cnode.nodeid
			&& (COMMENT_TYPES.indexOf(role.name) == -1
			&& role.name != "Theme" && focalrole.name != "Theme")
		) {
			var extra = getNodeTitleAntecedence(connection.from[0].cnode.role[0].role.name, false);
			var addRelevance = new Element('a',{'style':'margin-bottom:5px;float:left;clear:both','href':'#', 'title':"<?php echo $LNG->NODE_RELEVANCE_VIEW_MENU_HINT; ?> "+extra});
			addRelevance.insert("<?php echo $LNG->NODE_RELEVANCE_VIEW_MENU_TEXT; ?>");
			addRelevance.connid = connection.connid;
			Event.observe(addRelevance,'click',function () { viewConnectionDescription(connection.description) });
			toolbarDiv.insert(addRelevance);
		}

		var exploreButton = new Element("a", {'class':'d-block','title':"<?php echo $LNG->NODE_DETAIL_BUTTON_HINT; ?>"} );
		Event.observe(exploreButton,'click',function () {
			var width = getWindowWidth()-20;
			var height = getWindowHeight()-20;
			loadDialog('details', URL_ROOT+"explore.php?id="+node.nodeid, width, height);
		});
		Event.observe(exploreButton,'mouseover',function (event){ showBox('toolbardiv'+uniQ); });
		exploreButton.insert("<?php echo $LNG->NODE_DETAIL_MENU_TEXT; ?>");
		exploreButton.href= "#";
		toolbarDiv.appendChild(exploreButton);

		if (nodeObj && node.nodeid != nodeObj.nodeid) {
			var exploreButton = new Element("a", {'class':'d-block','title':"<?php echo $LNG->NODE_DEBATE_REFOCUS_MENU_HINT; ?>"} );
			exploreButton.href= URL_ROOT+"knowledgetrees.php?id="+node.nodeid;
			exploreButton.insert("<?php echo $LNG->NODE_DEBATE_REFOCUS_MENU_TEXT; ?>");
			toolbarDiv.appendChild(exploreButton);
		}

		var connector = new Element('a',{'class':'d-block','title':"<?php echo $LNG->NODE_VIEW_CONNECTOR_MENU_HINT; ?> "+user.name});
		connector.insert("<?php echo $LNG->NODE_VIEW_CONNECTOR_MENU_TEXT; ?>");
		connector.href = URL_ROOT+"user.php?userid="+user.userid,
		toolbarDiv.appendChild(connector);

		<?php if ($CFG->SPAM_ALERT_ON) { ?>
			toolbarDiv.insert(createSpamMenuOption(node, role));
		<?php } ?>
	}

	ihDiv.insert(itDiv);

	var iwDiv = new Element("div", {'class':'idea-wrapper'});
	var imDiv = new Element("div", {'class':'idea-main'});
	var idDiv = new Element("div", {'class':'idea-detail'});

	var expandDiv = new Element("div", {'id':'treedesc'+uniQ,'class':'ideadata', 'style':'padding:left:0px;margin-left:0px;color:Gray;'} );
	if (node.istop) {
		if (DEBATE_TREE_OPEN_ARRAY["treedesc"+uniQ] && DEBATE_TREE_OPEN_ARRAY["treedesc"+uniQ] == true) {
			expandDiv.style.display = 'block';
		} else {
			expandDiv.style.display = 'none';
		}
	} else {
		expandDiv.style.display = 'block';
	}
	var hint = alttext+": "+node.name;
	if (RESOURCE_TYPES_STR.indexOf(role.name) != -1) {
		hint = node.description;
	}
	hint += " <?php echo $LNG->NODE_GOTO_PARENT_HINT; ?>"

	/**
	 * This is for the rollover hint around the vertical line - background image 21px wide 1px line in middle
	 * This was the only way to get it to work in all four main browsers!!!!!
   	 **/
	var expandTable = document.createElement( 'table', {'style':'empty-cells:show;border-collapse:collapse;'} );
	expandTable.height="100%";
	//expandTable.border="1";
	var expandrow = expandTable.insertRow(-1);
	expandrow.style.height="100%";
	if (node.istop) {
		expandTable.style.marginLeft = "5px";
	} else {
		expandTable.style.marginLeft = "20px";
	}

	var lineCell = expandrow.insertCell(-1);
	lineCell.style.borderLeft = "1px solid white"; // needed for IE to draw the background image
	lineCell.width="5px;";
	lineCell.style.marginLeft="3px";

	lineCell.title=hint;
	lineCell.className="grayline";
	Event.observe(lineCell,'click',function (){
		var pos = getPosition(textCellDiv);
		window.scroll(0,pos.y-3);
	});

	var childCell = expandrow.insertCell(-1);
	childCell.vAlign="top";
	childCell.align="left";
	childCell.style.padding="0px";
	childCell.style.margin="0px";

	expandDiv.insert(expandTable);

	if (node.istop) {
		expandDiv.style.marginLeft = "22px";
	} else {
		expandDiv.style.marginLeft = "4px";
	}

	/** EXPAND DIV **/
	var innerexpandDiv = new Element("div", {'id':'desc'+uniQ,'class':'ideadata', 'style':'display:none;'} );

	var nodeTable = document.createElement( 'table' );
	nodeTable.className = "toConnectionsTable";

	innerexpandDiv.insert(nodeTable);

	var row = nodeTable.insertRow(-1);
	var nextCell = row.insertCell(-1);
	nextCell.vAlign="middle";
	nextCell.align="left";

	// USER ICON NAME AND CREATIONS DATES
	var userbar = new Element("div", {'class':'userbar'} );
	if (includeUser == true) {
		// Add right side with user image and date below
		var iuDiv = new Element("div", {'class':'idea-user2', 'style':'clear:both;float:left;'});
		var userimageThumb = new Element('img',{'alt':nodeuser.name, 'title': nodeuser.name, 'style':'padding-right:5px;', 'src': nodeuser.thumb});
		if (type == "active") {
			var imagelink = new Element('a', {
				'href':URL_ROOT+"user.php?userid="+nodeuser.userid,
				'title':nodeuser.name});
			if (breakout != "") {
				imagelink.target = "_blank";
			}
			imagelink.insert(userimageThumb);
			iuDiv.update(imagelink);
		} else {
			iuDiv.insert(userimageThumb)
		}
		userbar.appendChild(iuDiv);
	}

	var iuDiv = new Element("div", {'style':'float:left;'});

	var dStr = "";
	var cDate = new Date(node.creationdate*1000);
	dStr += "<b><?php echo $LNG->NODE_ADDED_ON; ?> </b>"+ cDate.format(DATE_FORMAT) + "<br/>";
	dStr += "<b><?php echo $LNG->NODE_ADDED_BY; ?> </b>"+ nodeuser.name + "";
	iuDiv.insert(dStr);

	userbar.insert(iuDiv);

	nextCell.appendChild(userbar);

	// META DATA - DESCRIPTION, TAGS, URLS, LOCATION ETC

 	// add url if a resource node
 	if (RESOURCE_TYPES_STR.indexOf(role.name) != -1) {
		innerexpandDiv.insert('<span style="margin-right:5px;"><b><?php echo $LNG->NODE_URL_HEADING; ?></b></span>');
		var link = new Element("a", {'href':node.name,'target':'_blank','title':'<?php echo $LNG->NODE_RESOURCE_LINK_HINT; ?>'} );
		link.insert(node.name);
		innerexpandDiv.insert(link);

 		if (node.urls && node.urls.length > 0) {
 			var hasClips = false;
			var iUL = new Element("ul", {});
			for (var i=0 ; i <  node.urls.length; i++){
				if (node.urls[i].url.clip && node.urls[i].url.clip != "") {
					var link = new Element("li");
					link.insert(node.urls[i].url.clip);
					iUL.insert(link);
					hasClips = true;
				}
				if (node.urls[i].url.identifier && node.urls[i].url.identifier != "" && role.name == 'Publication') {
					expandDiv.insert('<br><span style="margin-right:5px;"><b><?php echo $LNG->FORM_LABEL_DOI; ?> </b></span><span>'+node.urls[i].url.identifier+'</span>');
				}
			}

			if (hasClips) {
				innerexpandDiv.insert('<br><span style="margin-right:5px;"><b><?php echo $LNG->NODE_RESOURCE_CLIPS_HEADING; ?> </b></span><br>');
			}

			innerexpandDiv.insert(iUL);
		}
	}

	//tags
	if(node.tags && node.tags.length > 0){
		var grpStr = "<div style='padding:0px; margin-top:5px;margin-bottom:5px;'><b><?php echo $LNG->NODE_TAGS_HEADING; ?> </b>";
		for (var i=0 ; i <  node.tags.length; i++){
			var tag = null;
			if (node.tags[i].name) {
				tag = node.tags[i];
			} else {
				tag = node.tags[i].tag
			}

			if (type == "active") {
				grpStr += '<a href="'+URL_ROOT+'search.php?q='+tag.name+'&fromid='+node.nodeid+'&scope=all&tagsonly=true">'+tag.name+'</a>';
			} else {
				grpStr += tag.name;
			}
			if (i < node.tags.length-1) {
				grpStr += ',';
			}
		}

		grpStr += '</div>';
		innerexpandDiv.insert(grpStr);
	}

	if (connection && connection.description != ""
		&& (COMMENT_TYPES.indexOf(role.name) == -1 && role.name != "Theme")
			&& node.nodeid == connection.from[0].cnode.nodeid) {
		innerexpandDiv.insert('<span style="margin-top: 5px;"><b><?php echo $LNG->NODE_RELEVANCE_HEADING; ?> </b>'+connection.description+'</span>');
		innerexpandDiv.insert('<br>');
	}

	var dStr = "";

	if (RESOURCE_TYPES_STR.indexOf(role.name) == -1) {
		if(node.description || node.hasdesc){
			dStr += '<div style="margin:0px;padding=0px;" class="idea-desc" id="desc'+uniQ+'div"><span style="margin-top: 5px;"><b><?php echo $LNG->NODE_DESC_HEADING; ?> </b></span><br>';
			if (node.description && node.description != "") {
				innerexpandDiv.description = true;
				dStr += node.description;
			}
			dStr += '</div>';
			innerexpandDiv.insert(dStr);
		}
	}

	// CHILD LISTS
	if (node.children && DEBATE_TREE_SMALL) {
		var nodes = node.children
		if (nodes.length > 0) {
			childCell.insert('<div style="clear:both;"></div>');
			var childrenDiv = new Element("div", {'id':'children'+uniQ, 'style':'clear:both;float:left;margin-left:0px;padding-left:0px;margin-bottom:5px;color:Gray;display:block;'} );
			childCell.insert(childrenDiv);
			childCell.insert('<div style="clear:both;"></div>');
			if (expandArrow) {
				expandArrow.style.visibility = 'visible';
			}
			var parentrefreshhanlder = "";
			//"refreshchildren(\'children"+uniQ+"\', \'"+nodeid+"\', \'"+title+"\', \'"+linktype+"\', \'"+role.name+"\')";

			if (node.istop) {
				childCountSpan.update(nodes.length+1);
			} else {
				if (childCountSpan != null) {
					var countnow = parseInt(childCountSpan.innerHTML);
					var finalcount = countnow+nodes.length;
					childCountSpan.innerHTML = finalcount;
				}
			}
			displayConnectionNodes(childrenDiv, nodes, parseInt(0), true, uniQ, childCountSpan, parentrefreshhanlder);
		}
	} else if (DEBATE_TREE_SMALL == false) {
		if (role.name == 'Challenge') {
			childCell.insert('<div style="clear:both;"></div>');
			var issueDiv = new Element("div", {'id':'issue'+uniQ, 'style':'clear:both;float:left;padding-left:10px;margin-bottom:5px;color:Gray;display:block;'} );
			childCell.insert(issueDiv);
			childload(issueDiv, node.nodeid, "Issues", "is related to", "Issue", focalnodeid, uniQ, childCountSpan);
			childCell.insert('<div style="clear:both;"></div>');
		} else if (role.name == 'Issue') {
			childCell.insert('<div style="clear:both;"></div>');
			var solutionDiv = new Element("div", {'id':'solution'+uniQ, 'style':'clear:both;float:left;padding-left:10px;margin-bottom:5px;color:Gray;display:block;'} );
			childCell.insert(solutionDiv);
			childload(solutionDiv ,node.nodeid,"Solutions", "addresses", "Solution", focalnodeid, uniQ, childCountSpan);
			childCell.insert('<div style="clear:both;"></div>');
			var claimDiv = new Element("div", {'id':'claim'+uniQ, 'style':'clear:both;float:left;padding-left:10px;margin-bottom:5px;color:Gray;display:block;'} );
			childCell.insert(claimDiv);
			childload(claimDiv, node.nodeid,"Claims", "responds to", "Claim", focalnodeid, uniQ, childCountSpan);
			childCell.insert('<div style="clear:both;"></div>');
		} else if (role.name == 'Claim' || role.name == 'Solution') {
			childCell.insert('<div style="clear:both;"></div>');
			var supportDiv = new Element("div", {'id':'support'+uniQ, 'style':'clear:both;float:left;padding-left:10px;margin-bottom:5px;color:Gray;display:block;'} );
			childCell.insert(supportDiv);
			childload(supportDiv, node.nodeid,"Supporting Evidence", "supports", "Pro", focalnodeid, uniQ, childCountSpan);
			childCell.insert('<div style="clear:both;"></div>');
			var opposingDiv = new Element("div", {'id':'oppose'+uniQ, 'style':'clear:both;float:left;padding-left:10px;margin-bottom:5px;color:Gray;display:block;'} );
			childCell.insert(opposingDiv);
			childload(opposingDiv, node.nodeid, "Counter Evidence", "challenges", "Con", node.focalnodeid, uniQ, childCountSpan);
			childCell.insert('<div style="clear:both;"></div>');
		} else if (EVIDENCE_TYPES_STR.indexOf(role.name) != -1) {
			childCell.insert('<div style="clear:both;"></div>');
			var resourceDiv = new Element("div", {'id':'resource'+uniQ, 'style':'clear:both;float:left;padding-left:10px;margin-bottom:5px;color:Gray;display:block;'} );
			childCell.insert(resourceDiv);
			childload(resourceDiv, node.nodeid,"Resources", "is related to", RESOURCE_TYPES_STR, focalnodeid, uniQ, childCountSpan);
			childCell.insert('<div style="clear:both;"></div>');
		} else {
			lineCell.className=""; // "1px solid white"; // hide the dot
		}
	} else {
		lineCell.className=""; // = "1px solid white"; // hide the dot
	}

	idDiv.insert(innerexpandDiv);
	idDiv.insert(expandDiv);
	imDiv.insert(idDiv);
	iwDiv.insert(imDiv);
	iDiv.insert(ihDiv);
	iDiv.insert(iwDiv);

	return iDiv;
}

/**
 * Render the given node from an associated connection of the knowledge tree in a print page.
 * @param node the node object do render
 * @param uniQ is a unique id element prepended to the nodeid to form an overall unique id within the currently visible site elements
 * @param role the role object for this node
 * @param includeUser whether to include the user image and link
 * @param type defaults to 'active', but can be 'inactive' so nothing is clickable
 * 			or a specialized type for some of the popups
 */
function renderReportConnectionNode(node, uniQ, role, includeUser){

	var originaluniQ = uniQ;

	if(role === undefined){
		role = node.role[0].role;
	}

	var nodeuser = null;
	// JSON structure different if coming from popup where json_encode used.
	if (node.users[0].userid) {
		nodeuser = node.users[0];
	} else {
		nodeuser = node.users[0].user;
	}
	var connection = node.connection;
	var user = null;
	if (connection) {
		user = connection.users[0].user;
	}

	var focalnodeid = "";
	if (node.focalnodeid) {
		focalnodeid = node.focalnodeid;
	}
	var focalrole = "";
	var connrole = role;
	var otherend = "";
	if (connection) {
		uniQ = connection.connid+uniQ;
		var fN = connection.from[0].cnode;
		var tN = connection.to[0].cnode;
		if (node.nodeid == fN.nodeid) {
			connrole = connection.fromrole[0].role;
			focalrole = tN.role[0].role;
			otherend = tN;
		} else {
			connrole = connection.torole[0].role;
			focalrole = fN.role[0].role;
			otherend = fN;
		}
	} else {
		uniQ = node.nodeid + uniQ;
	}

	var iDiv = new Element("div", {'style':'padding:0px;margin:0px;'});
	var ihDiv = new Element("div", {'style':'padding:0px;margin:0px;'});
	var itDiv = new Element("div", {'class':'idea-title','style':'padding:0px;'});

	var nodeTable = document.createElement( 'table' );
	nodeTable.className = "toConnectionsTable";
	itDiv.insert(nodeTable);

	var row = nodeTable.insertRow(-1);

	if (!node.istop) {
		var lineCell = row.insertCell(-1);
		lineCell.width="15px;"
		lineCell.vAlign="middle";
	}

	var textCell = row.insertCell(-1);
	textCell.vAlign="middle";
	textCell.align="left";
	var textCellDiv = new Element("div", { 'id':'textDivCell'+uniQ, 'name':'textDivCell', 'class':'whiteborder', 'style':'float:left;padding:3px;'});
	textCellDiv.nodeid = node.nodeid;
	textCellDiv.focalnodeid = node.focalnodeid;
	textCellDiv.nodetype = role.name;
	textCellDiv.parentuniQ = originaluniQ;
	if (connection) {
		textCellDiv.connection = connection;
	}

	var toolbarCell = row.insertCell(-1);
	toolbarCell.vAlign="middle";
	toolbarCell.align="left";
	toolbarCell.width="80";

	textCell.insert(textCellDiv);

	var cDate = new Date(connection.creationdate*1000);
	var dStr = "<?php echo $LNG->NODE_CONNECTED_BY; ?> "+user.name+ " on "+cDate.format(DATE_FORMAT)+' - <?php echo $LNG->NODE_TOGGLE_HINT;?>'

	// ADD THE NODE ICON
	var nodeArea = new Element("span", {'class':'itemtextblackinactive', 'name':'nodeArea', 'style':'float:left;padding-top:2px;'} );
	nodeArea.nodeid = node.nodeid;
	nodeArea.focalnodeid = node.focalnodeid;
	var alttext = getNodeTitleAntecedence(role.name, false);

	// ADD THE NODE LABEL
	textCellDiv.appendChild(nodeArea);
	if (role.name != 'Comment') {
		var nodeextra = getNodeTitleAntecedence(role.name, true);
		if (node.nodeid == CURRENT_ADD_AREA_NODEID) {
			if (RESOURCE_TYPES_STR.indexOf(connrole.name) != -1) {
				nodeArea.insert("<h1 style='font-size:12pt'><b><b><span style='font-style:italic'>"+nodeextra+"</span>"+node.description+"</b></h1>");
			} else {
				nodeArea.insert("<h1 style='font-size:12pt'><b><span style='font-style:italic'>"+nodeextra+"</span>"+node.name+"</b></h1>");
			}
		} else {
			if (RESOURCE_TYPES_STR.indexOf(connrole.name) != -1) {
				nodeArea.insert("<b><span style='font-style:italic'>"+nodeextra+"</span>"+node.description+"</b>");
			} else {
				nodeArea.insert("<b><span style='font-style:italic'>"+nodeextra+"</span>"+node.name+"</b>");
			}
		}

		// get descriptions as they don't come over by default in connections
		if (node.hasdesc){
			var reqUrl = SERVICE_ROOT + "&method=getnode&nodeid=" + encodeURIComponent(node.nodeid);
			new Ajax.Request(reqUrl, { method:'get',
				onSuccess: function(transport){
					var json = transport.responseText.evalJSON();
					if(json.error){
						alert(json.error[0].message);
						return;
					}

					Element.insert($("desc"+uniQ+"div"), json.cnode[0].description);
				}
			});
		}
	}

	if (node.istop) {
		var expandArrow = null;
		if (EVIDENCE_TYPES_STR.indexOf(role.name) != -1 || role.name == "Challenge"
			|| role.name == "Issue" || role.name == "Solution" || role.name == "Claim") {

			var childCount = new Element('div',{'class':'toptreecount', 'title':'<?php echo $LNG->NODE_DEBATE_TREE_COUNT_HINT; ?>'});
		}
	}

	ihDiv.insert(itDiv);

	var iwDiv = new Element("div", {'class':'idea-wrapper'});
	var imDiv = new Element("div", {'class':'idea-main'});
	var idDiv = new Element("div", {'class':'idea-detail'});

	var expandDiv = new Element("div", {'id':'treedesc'+uniQ, 'style':'padding:left:0px;margin-left:0px;color:black;'} );
	expandDiv.style.display = 'block';
	var hint = alttext+": "+node.name;
	if (RESOURCE_TYPES_STR.indexOf(role.name) != -1) {
		hint = node.description;
	}
	hint += " <?php echo $LNG->NODE_GOTO_PARENT_HINT; ?>"

	/**
	 * This is for the rollover hint around the vertical line - background image 21px wide 1px line in middle
	 * This was the only way to get it to work in all four main browsers!!!!!
   	 **/
	var expandTable = document.createElement( 'table', {'style':'empty-cells:show;border-collapse:collapse;'} );
	expandTable.height="100%";
	var expandrow = expandTable.insertRow(-1);
	expandrow.style.height="100%";
	if (node.istop) {
		expandTable.style.marginLeft = "5px";
	} else {
		expandTable.style.marginLeft = "20px";
	}

	var lineCell = expandrow.insertCell(-1);
	lineCell.style.borderLeft = "1px solid white"; // needed for IE to draw the background image
	lineCell.width="5px;";
	lineCell.style.marginLeft="3px";

	var childCell = expandrow.insertCell(-1);
	childCell.vAlign="top";
	childCell.align="left";
	childCell.style.padding="0px";
	childCell.style.margin="0px";

	expandDiv.insert(expandTable);

	if (node.istop) {
		expandDiv.style.marginLeft = "22px";
	} else {
		expandDiv.style.marginLeft = "4px";
	}

	/** EXPAND DIV **/
	var innerexpandDiv = new Element("div", {'id':'desc'+uniQ,'class':'ideadata', 'style':'padding-left:20px;color:black;display:block;'} );

	var nodeTable = document.createElement( 'table' );
	nodeTable.className = "toConnectionsTable";

	innerexpandDiv.insert(nodeTable);

	var row = nodeTable.insertRow(-1);
	var nextCell = row.insertCell(-1);
	nextCell.vAlign="middle";
	nextCell.align="left";

	// USER ICON NAME AND CREATIONS DATES
	var userbar = new Element("div", {'class':'userbar'} );
	if (includeUser == true) {
		// Add right side with user image and date below
		var iuDiv = new Element("div", {'class':'idea-user2', 'style':'clear:both;float:left;'});
		var userimageThumb = new Element('img',{'alt':nodeuser.name, 'title': nodeuser.name, 'style':'padding-right:5px;', 'src': nodeuser.thumb});
		iuDiv.insert(userimageThumb)
		userbar.appendChild(iuDiv);
	}

	var iuDiv = new Element("div", {'style':'float:left;'});

	var dStr = "";
	var cDate = new Date(node.creationdate*1000);
	dStr += "<?php echo $LNG->NODE_ADDED_ON; ?> "+ cDate.format(DATE_FORMAT) + "<br/>";
	dStr += "<?php echo $LNG->NODE_ADDED_BY; ?> "+ nodeuser.name + "";
	iuDiv.insert(dStr);

	userbar.insert(iuDiv);

	nextCell.appendChild(userbar);

	// META DATA - DESCRIPTION, TAGS, URLS, LOCATION ETC

 	// add url if a resource node
 	if (RESOURCE_TYPES_STR.indexOf(role.name) != -1) {
		innerexpandDiv.insert('<span style="margin-right:5px;"><?php echo $LNG->NODE_URL_HEADING; ?></span>');
		var link = new Element("a", {'href':node.name,'target':'_blank','title':'<?php echo $LNG->NODE_RESOURCE_LINK_HINT; ?>'} );
		link.insert(node.name);
		innerexpandDiv.insert(link);

 		if (node.urls && node.urls.length > 0) {
 			var hasClips = false;
			var iUL = new Element("ul", {});
			for (var i=0 ; i <  node.urls.length; i++){
				if (node.urls[i].url.clip && node.urls[i].url.clip != "") {
					var link = new Element("li");
					link.insert(node.urls[i].url.clip);
					iUL.insert(link);
					hasClips = true;
				}
				if (node.urls[i].url.identifier && node.urls[i].url.identifier != "" && role.name == 'Publication') {
					innerexpandDiv.insert('<br><span style="margin-right:5px;"><b><?php echo $LNG->FORM_LABEL_DOI; ?> </b></span><span>'+node.urls[i].url.identifier+'</span>');
				}
			}

			if (hasClips) {
				innerexpandDiv.insert('<br><span style="margin-right:5px;"><?php echo $LNG->NODE_RESOURCE_CLIPS_HEADING; ?> </span><br>');
			}

			innerexpandDiv.insert(iUL);
		}
	}

	//tags
	if(node.tags && node.tags.length > 0){
		var grpStr = "<div style='padding:0px; margin-top:5px;margin-bottom:5px;'><?php echo $LNG->NODE_TAGS_HEADING; ?> ";
		for (var i=0 ; i <  node.tags.length; i++){
			var tag = null;
			if (node.tags[i].name) {
				tag = node.tags[i];
			} else {
				tag = node.tags[i].tag
			}

			grpStr += tag.name;
			if (i < node.tags.length-1) {
				grpStr += ',';
			}
		}

		grpStr += '</div>';
		innerexpandDiv.insert(grpStr);
	}

	if (connection && connection.description != ""
		&& (COMMENT_TYPES.indexOf(role.name) == -1 && role.name != "Theme")
			&& node.nodeid == connection.from[0].cnode.nodeid) {
		innerexpandDiv.insert('<span style="margin-top: 5px;"><?php echo $LNG->NODE_RELEVANCE_HEADING; ?> '+connection.description+'</span>');
		innerexpandDiv.insert('<br>');
	}

	var dStr = "";

	if (RESOURCE_TYPES_STR.indexOf(role.name) == -1) {
		if(node.description || node.hasdesc){
			dStr += '<div style="margin:0px;padding=0px;" class="idea-desc" id="desc'+uniQ+'div"><span style="margin-top: 5px;"><?php echo $LNG->NODE_DESC_HEADING; ?> </span>';
			if (node.description && node.description != "") {
				innerexpandDiv.description = true;
				dStr += node.description;
			}
			dStr += '</div>';
			innerexpandDiv.insert(dStr);
		}
	}

	// CHILD LISTS
	if (node.children) {
		var nodes = node.children
		if (nodes.length > 0) {
			childCell.insert('<div style="clear:both;"></div>');
			var childrenDiv = new Element("div", {'id':'children'+uniQ, 'style':'clear:both;float:left;margin-left:0px;padding-left:0px;margin-bottom:5px;color:Gray;display:block;'} );
			childCell.insert(childrenDiv);
			childCell.insert('<div style="clear:both;"></div>');

			displayReportConnectionNodes(childrenDiv, nodes, parseInt(0), true, uniQ);
		}
	}

	idDiv.insert(innerexpandDiv);
	idDiv.insert(expandDiv);
	imDiv.insert(idDiv);
	iwDiv.insert(imDiv);
	iDiv.insert(ihDiv);
	iDiv.insert(iwDiv);

	return iDiv;
}

/**
 * Render the given node from an associated connection in the debate tree.
 * @param node the node object do render
 * @param uniQ is a unique id element prepended to the nodeid to form an overall unique id within the currently visible site elements
 * @param role the role object for this node
 * @param includeUser whether to include the user image and link
 * @param type defaults to 'active', but can be 'inactive' so nothing is clickable
 * 			or a specialized type for some of the popups
 */
function renderChatNode(node, uniQ, role, includeUser, type, childCountSpan){

	if (type === undefined) {
		type = "active";
	}

	if (childCountSpan === undefined) {
		childCountSpan = null;
	}

	var originaluniQ = uniQ;

	if(role === undefined){
		role = node.role[0].role;
	}
	var user = null;
	// JSON structure different if coming from popup where json_encode used.
	if (node.users[0].userid) {
		user = node.users[0];
	} else {
		user = node.users[0].user;
	}
	var connection = node.connection;
	if (connection) {
		user = connection.users[0].user;
	}
	//needs to check if embedded as a snippet
	var breakout = "";
	if(top.location != self.location){
		breakout = " target='_blank'";
	}

	var focalnodeid = "";
	if (node.focalnodeid) {
		focalnodeid = node.focalnodeid;
	}
	var focalrole = "";
	var connrole = role;
	var otherend = "";
	if (connection) {
		uniQ = connection.connid+uniQ;
		var fN = connection.from[0].cnode;
		var tN = connection.to[0].cnode;
		if (node.nodeid == fN.nodeid) {
			connrole = connection.fromrole[0].role;
			focalrole = tN.role[0].role;
			otherend = tN;
		} else {
			connrole = connection.torole[0].role;
			focalrole = fN.role[0].role;
			otherend = fN;
		}
	} else {
		uniQ = node.nodeid + uniQ;
	}

	var iDiv = new Element("div", {'style':'padding:0px;margin:0px;'});
	var ihDiv = new Element("div", {'style':'padding:0px;margin:0px;'});
	var itDiv = new Element("div", {'class':'idea-title','style':'padding:0px;'});

	var nodeTable = document.createElement( 'table' );
	nodeTable.className = "toConnectionsTable";

	itDiv.insert(nodeTable);

	var row = nodeTable.insertRow(-1);

	// ADD THE ARROW IF REQUIRED
	if (node.istop) {
		var expandArrow = null;
		var arrowCell = row.insertCell(-1);
		arrowCell.width = "25px"

		if (CHAT_TREE_OPEN_ARRAY["chat"+uniQ] && CHAT_TREE_OPEN_ARRAY["chat"+uniQ] == true) {
			expandArrow = new Element('img',{'id':'explorechatarrow'+uniQ, 'name':'explorechatarrow', 'alt':'>', 'title':'<?php echo $LNG->CHAT_TREE_TOGGLE; ?>','src': '<?php echo $HUB_FLM->getImagePath("arrow-down-blue.png"); ?>'});
			expandArrow.uniqueid = uniQ;
		} else {
			expandArrow = new Element('img',{'id':'explorechatarrow'+uniQ, 'name':'explorechatarrow', 'alt':'>', 'title':'<?php echo $LNG->CHAT_TREE_TOGGLE; ?>','src': '<?php echo $HUB_FLM->getImagePath("arrow-right-blue.png"); ?>'});
			expandArrow.uniqueid = uniQ;
		}
		Event.observe(expandArrow,'click',function (){ toggleChat("chat"+uniQ,uniQ, false);});
		arrowCell.insert(expandArrow);
	} else {
		var lineCell = row.insertCell(-1);
		lineCell.style.borderLeft = "1px solid white"; // needed for IE to draw the background image
		lineCell.width="15px;"
		lineCell.vAlign="middle";
		var lineDiv = new Element('div',{'class':'graylinewide', 'style':'float:left;width:100%;'});
		lineCell.insert(lineDiv);
	}

	var textCell = row.insertCell(-1);
	textCell.vAlign="middle";
	textCell.align="left";
	var textCellDiv = new Element("div", { 'id':'textChatDivCell'+uniQ, 'name':'textChatDivCell', 'class':'whiteborder textChatDivCell'});
	textCellDiv.nodeid = node.nodeid;
	textCellDiv.focalnodeid = node.focalnodeid;
	textCellDiv.nodetype = role.name;
	textCellDiv.parentuniQ = originaluniQ;
	if (connection) {
		textCellDiv.connection = connection;
	}

	var toolbarCell = row.insertCell(-1);
	toolbarCell.vAlign="middle";
	toolbarCell.align="left";
	toolbarCell.width="100";

	textCell.insert(textCellDiv);

	var cDate = new Date(connection.creationdate*1000);
	var dStr = "<?php echo $LNG->NODE_REPLY_ON; ?> "+cDate.format(TIME_FORMAT);

	// ADD THE NODE ICON - User IMAGE
	var nodeArea = new Element("span", {'name':'nodeArea' ,'title':dStr} );
	nodeArea.nodeid = node.nodeid;
	nodeArea.focalnodeid = node.focalnodeid;
	var alttext = getNodeTitleAntecedence(role.name, false);

	var userimageThumb = new Element('img',{'alt':user.name, 'title': user.name, 'class':'userChat', 'src': user.thumb});
	if (type == "active") {
		var imagelink = new Element('a', {
			'href':URL_ROOT+"user.php?userid="+user.userid,
			'title':user.name});
		if (breakout != "") {
			imagelink.target = "_blank";
		}
		imagelink.insert(userimageThumb);
		nodeArea.update(imagelink);
	} else {
		nodeArea.insert(userimageThumb)
	}

	nodeArea.insert(node.name);
	textCellDiv.appendChild(nodeArea);

	// if this node is the latest node added to the tree - highlight it
	// parentnode in the case of the chat topic connection, is the newest node added, rather than the parent connection.
	if (node.chattopic.parentnode &&
		node.chattopic.parentnode[0].cnode.nodeid == node.nodeid) {
		textCellDiv.className = 'plainborder recentReply';
	}
	if (CHATNODEID != "" && CHATNODEID == node.nodeid) {
		textCellDiv.className = textCellDiv.className + ' selectedback';
	}

	// ADD THE MENU ICON IF REQUIRED
	var menuButton = null;
	var toolbarDiv = new Element("div", {'id':'toolbardiv'+uniQ, 'class':'toolbarDiv', 'style':'left:-1px;top:-1px;clear:both;position:absolute;display:none;z-index:60;padding:5px;width:130px;border:1px solid gray;background:white'} );

	Event.observe(toolbarDiv,'mouseout',function (event){
		hideBox('toolbardiv'+uniQ);
	});
	Event.observe(toolbarDiv,'mouseover',function (event){ showBox('toolbardiv'+uniQ); });

	if (node.istop) {
		var expandArrow = null;
		var childCount = new Element('div',{'class':'toptreecount', 'title':'<?php echo $LNG->CHAT_TREE_COUNT_HINT; ?>'});
		childCount.insert("(");
		childCountSpan = new Element('span',{'name':'topchattreecount'});
		childCountSpan.id = 'topchattreecount'+uniQ;
		childCountSpan.insert(0);
		childCountSpan.uniqueid = uniQ;
		childCount.insert(childCountSpan);
		childCount.insert(")");
		toolbarCell.insert(childCount);
	}

	var delButton = null;

	// ADD ACTION MENU
	if (type == 'active') {
		menuButton = new Element('img',{'alt':'>', 'class':'menuicon', 'src': '<?php echo $HUB_FLM->getImagePath("menuicon.png"); ?>'});
		toolbarCell.appendChild(menuButton);
		Event.observe(menuButton,'mouseout',function (event){
			hideBox('toolbardiv'+uniQ);
		});
		Event.observe(menuButton,'mouseover',function (event) {

			var position = getPosition(this);
			var panel = $('toolbardiv'+uniQ);
			var panelWidth = 150;

			var viewportHeight = getWindowHeight();
			var viewportWidth = getWindowWidth();

			var x = position.x;
			var y = position.y;

			if ( (x+panelWidth+30) > viewportWidth) {
				x = x-(panelWidth+30);
			} else {
				x = x+10;
			}

			x = x+30+getPageOffsetX();

			panel.style.left = x+"px";
			panel.style.top = y+"px";

			showBox('toolbardiv'+uniQ);
		});

		var toolbarDiv = new Element("div", {'id':'toolbardiv'+uniQ, 'class':'toolbarDiv', 'style':'left:-1px;top:-1px;clear:both;position:absolute;display:none;z-index:60;padding:5px;width:150px;border:1px solid gray;background:white'} );
		Event.observe(toolbarDiv,'mouseout',function (event){
			hideBox('toolbardiv'+uniQ);
		});
		Event.observe(toolbarDiv,'mouseover',function (event){ showBox('toolbardiv'+uniQ); });
		toolbarCell.appendChild(toolbarDiv);

		if (USER != "") {
			var addButton = new Element("a", {'class':'d-block', 'title':'<?php echo $LNG->CHAT_REPLY_TO_MENU_HINT; ?>'} );
			Event.observe(addButton,'click',function () {
				hideBox('toolbardiv'+uniQ);

				$('prompttext').innerHTML="";

				var viewportHeight = getWindowHeight();
				var viewportWidth = getWindowWidth();
				var x = (viewportWidth-400)/2;
				var y = (viewportHeight-200)/2;
				
				var innerPromptDiv = new Element('div', {'class':'prompttext-inner'});

				var textarea1 = new Element('textarea', {'id':'messagetextarea','rows':'5','class':'form-control'});
				var buttonOK = new Element('input', { 'class':'btn btn-primary', 'type':'button', 'value':'<?php echo $LNG->WIDGET_ADD_BUTTON; ?>'});
				Event.observe(buttonOK,'click', function() {
					var comment = textarea1.value;
					if (comment != "") {
						var type = "Comment";

						var parentconnid = node.chattopic.connid;

						var reqUrl = SERVICE_ROOT + "&method=connectnodetocomment&nodetypename="+type+"&nodeid="+node.nodeid+"&parentconnid="+parentconnid+"&parentid="+nodeObj.nodeid+"&comment="+encodeURIComponent(comment);
						new Ajax.Request(reqUrl, { method:'get',
								onSuccess: function(transport){
									var json = transport.responseText.evalJSON();
									if(json.error){
										alert(json.error[0].message);
									} else {
										var from = json.connection[0].from[0].cnode;
										CHATNODEID = from.nodeid;
										refreshExploreChats();
									}
								},
						});
					}
					$('prompttext').style.display = "none";
					$('prompttext').update("");
					var backDrop = document.getElementById("backDrop");
					backDrop.remove(); 
				});

				var buttonCancel = new Element('input', { 'class':'btn btn-secondary', 'type':'button', 'value':'<?php echo $LNG->FORM_BUTTON_CLOSE; ?>'});
				Event.observe(buttonCancel,'click', function() {
					$('prompttext').style.display = "none";
					$('prompttext').update("");
					
					var backDrop = document.getElementById("backDrop");
					backDrop.remove(); 
				});

				var footerPromptDiv = new Element('div', {'class':'prompttext-footer'});

				footerPromptDiv.insert(buttonOK);
				footerPromptDiv.insert(buttonCancel);
				
				innerPromptDiv.insert(textarea1);
				innerPromptDiv.insert(footerPromptDiv);
				$('prompttext').insert(innerPromptDiv);
				$('prompttext').style.display = "block";

				document.body.classList.add("modal-open");

				var backDrop = new Element('div', {'class':'modal-backdrop fade show', 'id':'backDrop'});
				document.body.insert(backDrop);

				textarea1.focus();
			});
			Event.observe(addButton,'mouseover',function (event){ showBox('toolbardiv'+uniQ); });
			addButton.insert("<?php echo $LNG->CHAT_REPLY_TO_MENU_TEXT; ?>");
			addButton.href= "#";
			toolbarDiv.appendChild(addButton);

			if (connection && USER == connection.users[0].user.userid
				&&  node.nodeid == connection.from[0].cnode.nodeid) {

				var parentname = otherend.name;
				if (parentname.length > 50) {
					parentname = parentname.substr(0, 50)+"...";
				}
				parentname = " "+parentname;

				delButton = new Element('span',{'id':'chatremove'+uniQ, 'class':'active', 'style':'display:none;','title':"<?php echo $LNG->DELETE_BUTTON_HINT; ?> "});
				delButton.insert("<?php echo $LNG->DELETE_BUTTON_ALT; ?>");
				delButton.connid = connection.connid;

				var parentconnid = node.chattopic.connid
				Event.observe(delButton,'click',function (){deleteChatNode(node.nodeid, node.name, node.handler, parentconnid)});
				toolbarDiv.insert(delButton);
			}

			<?php if ($CFG->SPAM_ALERT_ON) { ?>
				toolbarDiv.insert(createSpamMenuOption(node, role));
			<?php } ?>

			if (USER != "" && (
					(BUILD_FROM_PERMISSIONS == "all") ||
					(BUILD_FROM_PERMISSIONS == "user" && USER == user.userid) ||
					(BUILD_FROM_PERMISSIONS == "admin" && IS_USER_ADMIN == "Y")
				)){
				toolbarDiv.appendChild(createMenuSpacer());

				<?php if ($CFG->HAS_CHALLENGE && $USER->getIsAdmin() == "Y") { ?>
					var addButton = new Element("span", {'class':'active d-block', 'title':'<?php echo $LNG->CHAT_CONVERT_TO_CHALLENGE_HINT; ?>'} );
					addButton.insert("<?php echo $LNG->CHAT_CONVERT_TO_CHALLENGE_TEXT; ?>");
					Event.observe(addButton,'click',function (){loadDialog('addchallenge',URL_ROOT+"ui/popups/challengeadd.php?handler="+node.handler+"&chatnodeid="+node.nodeid+"&chatparentid=+"+nodeObj.nodeid+"&challenge="+encodeURIComponent(node.name), 750,500)});
					toolbarDiv.appendChild(addButton);
				<?php } ?>

				<?php  if ( $CFG->issuesManaged == false || ($CFG->issuesManaged == true && $USER->getIsAdmin() == "Y") ) { ?>
					var addButton = new Element("span", {'class':'active d-block', 'title':'<?php echo $LNG->CHAT_CONVERT_TO_ISSUE_HINT; ?>'} );
					addButton.insert("<?php echo $LNG->CHAT_CONVERT_TO_ISSUE_TEXT; ?>");
					Event.observe(addButton,'click',function (){loadDialog('addissue',URL_ROOT+"ui/popups/issueadd.php?handler="+node.handler+"&chatnodeid="+node.nodeid+"&chatparentid=+"+nodeObj.nodeid+"&issue="+encodeURIComponent(node.name), 750,500)});
					toolbarDiv.appendChild(addButton);
				<?php } ?>

				if (hasClaim) {
					var addButton = new Element("span", {'class':'active d-block', 'title':'<?php echo $LNG->CHAT_CONVERT_TO_CLAIM_HINT; ?>'} );
					addButton.insert("<?php echo $LNG->CHAT_CONVERT_TO_CLAIM_TEXT; ?>");
					Event.observe(addButton,'click',function (){loadDialog('addclaim',URL_ROOT+"ui/popups/claimadd.php?handler="+node.handler+"&chatnodeid="+node.nodeid+"&chatparentid=+"+nodeObj.nodeid+"&claim="+encodeURIComponent(node.name), 750,500)});
					toolbarDiv.appendChild(addButton);
				}
				if (hasSolution) {
					var addButton = new Element("span", {'class':'active d-block', 'title':'<?php echo $LNG->CHAT_CONVERT_TO_SOLUTION_HINT; ?>'} );
					addButton.insert("<?php echo $LNG->CHAT_CONVERT_TO_SOLUTION_TEXT; ?>");
					Event.observe(addButton,'click',function (){loadDialog('addsolution',URL_ROOT+"ui/popups/solutionadd.php?handler="+node.handler+"&chatnodeid="+node.nodeid+"&chatparentid=+"+nodeObj.nodeid+"&solution="+encodeURIComponent(node.name), 750,500)});
					toolbarDiv.appendChild(addButton);
				}

				var addButton = new Element("span", {'class':'active d-block', 'title':'<?php echo $LNG->CHAT_CONVERT_TO_EVIDENCE_HINT; ?>'} );
				addButton.insert("<?php echo $LNG->CHAT_CONVERT_TO_EVIDENCE_TEXT; ?>");
				Event.observe(addButton,'click',function (){loadDialog('addevidence',URL_ROOT+"ui/popups/evidenceadd.php?handler="+node.handler+"&chatnodeid="+node.nodeid+"&chatparentid=+"+nodeObj.nodeid+"&summary="+encodeURIComponent(node.name), 750,500)});
				toolbarDiv.appendChild(addButton);
			}
		} else {
			var button = new Element("span");
			button.style.color="dimgray";
			button.style.cursor="pointer";
			button.title="<?php echo $LNG->WIDGET_SIGNIN_HINT; ?>";
			button.insert("<?php echo $LNG->CHAT_REPLY_TO_MENU_TEXT; ?>");
			Event.observe(button,"click", function(){
				$('loginsubmit').click();
				return true;
			});
			toolbarDiv.appendChild(button);
		}
	}

	ihDiv.insert(itDiv);

	var iwDiv = new Element("div", {'class':'idea-wrapper'});
	var imDiv = new Element("div", {'class':'idea-main'});
	var idDiv = new Element("div", {'class':'idea-detail'});

	var expandDiv = new Element("div", {'id':'chat'+uniQ,'class':'ideadata', 'style':'padding:left:0px;margin-left:0px;color:Gray;'} );
	if (node.istop) {
		if (CHAT_TREE_OPEN_ARRAY["chat"+uniQ] && CHAT_TREE_OPEN_ARRAY["chat"+uniQ] == true) {
			expandDiv.style.display = 'block';
		} else {
			expandDiv.style.display = 'none';
		}
	} else {
		expandDiv.style.display = 'block';
	}
	var hint = node.name+" <?php echo $LNG->NODE_GOTO_PARENT_HINT; ?>"

	/**
	 * This is for the rollover hint around the vertical line - background image 21px wide 1px line in middle
	 * This was the only way to get it to work in all four main browsers!!!!!

   	 **/
	var expandTable = document.createElement( 'table', {'style':'empty-cells:show;border-collapse:collapse;'} );
	expandTable.height="100%";
	var expandrow = expandTable.insertRow(-1);
	expandrow.style.height="100%";
	if (node.istop) {
		expandTable.style.marginLeft = "9px";
	} else {
		expandTable.style.marginLeft = "26px";
	}

	var lineCell = expandrow.insertCell(-1);
	lineCell.style.borderLeft = "1px solid white"; // needed for IE to draw the background image
	lineCell.width="5px;";
	lineCell.style.marginLeft="3px";
	lineCell.title=hint;
	lineCell.className="grayline";
	Event.observe(lineCell,'click',function (){
		var pos = getPosition(textCellDiv);
		window.scroll(0,pos.y-3);
	});

	var childCell = expandrow.insertCell(-1);
	childCell.vAlign="top";
	childCell.align="left";
	childCell.style.padding="0px";
	childCell.style.margin="0px";

	expandDiv.insert(expandTable);

	if (node.istop) {
		expandDiv.style.marginLeft = "22px";
	} else {
		expandDiv.style.marginLeft = "4px";
	}

	// CHECK FOR / LOAD CHILD LISTS
	if (node.children) {
		var nodes = node.children;
		nodes.sort(creationdatenodesortasc);
		if (nodes.length > 0){
			// process the child list adding properties.
			for (var i=0; i < nodes.length; i++) {
				var nextchild = nodes[i];
				nextchild.cnode['parentid'] = node.nodeid;
				nextchild.cnode['chattopic'] = node.chattopic;
			}

			childCell.insert('<div style="clear:both;"></div>');
			var childrenDiv = new Element("div", {'id':'children'+uniQ, 'style':'clear:both;float:left;margin-left:0px;padding-left:0px;margin-bottom:5px;color:Gray;display:block;'} );
			childCell.insert(childrenDiv);
			childCell.insert('<div style="clear:both;"></div>');

			var parentrefreshhanlder = "";
			if (node.istop) {
				childCountSpan.update(nodes.length);
				if ($('explorechatarrow'+uniQ)) {
					$('explorechatarrow'+uniQ).style.visibility = 'visible';
				}
			} else {
				if (childCountSpan != null) {
					var countnow = parseInt(childCountSpan.innerHTML);
					var finalcount = countnow+nodes.length;
					childCountSpan.innerHTML = finalcount;
				}
			}
			displayChatNodes(childrenDiv, nodes, parseInt(0), true, uniQ, childCountSpan);
		} else {
			if (delButton) {
				delButton.style.display = "block";
			}
		}
	} else {
		if (delButton) {
			delButton.style.display = "block";
		}
	}

	idDiv.insert(expandDiv);
	imDiv.insert(idDiv);
	iwDiv.insert(imDiv);
	iDiv.insert(ihDiv);
	iDiv.insert(iwDiv);

	return iDiv;
}

/**
 * Render the given node from an associated connection.
 * @param node the node object do render
 * @param uniQ is a unique id element prepended to the nodeid to form an overall unique id within the currently visible site elements
 * @param role the role object for this node
 * @param includeUser whether to include the user image and link
 * @param type defaults to 'active', but can be 'inactive' so nothing is clickable
 * 			or a specialized type for some of the popups
 */
function renderWidgetListNode(node, uniQ, role, includeUser, type){

	if (type === undefined) {
		type = "active";
	}

	if(role === undefined){
		role = node.role[0].role;
	}

	var nodeuser = null;
	// JSON structure different if coming from popup where json_encode used.
	if (node.users[0].userid) {
		nodeuser = node.users[0];
	} else {
		nodeuser = node.users[0].user;
	}
	var user = null;
	var connection = node.connection;
	if (connection) {
		user = connection.users[0].user;
	}

	var breakout = "";

	//needs to check if embedded as a snippet
	if(top.location != self.location){
		breakout = " target='_blank'";
	}

	var focalrole = "";
	if (connection) {
		uniQ = connection.connid+uniQ;
		var fN = connection.from[0].cnode;
		var tN = connection.to[0].cnode;
		if (node.nodeid == fN.nodeid) {
			focalrole = tN.role[0].role;
		} else {
			focalrole = fN.role[0].role;
		}
	} else {
		uniQ = node.nodeid + uniQ;
	}

	var iDiv = new Element("div", {'style':'padding:0px;margin:0px;'});
	var ihDiv = new Element("div", {'style':'padding:0px;margin:0px;'});
	var itDiv = new Element("div", {'class':'idea-title'});
	ihDiv.insert(itDiv);

	var nodeTable = document.createElement( 'table' );
	nodeTable.className = "toConnectionsTable";

	itDiv.insert(nodeTable);

	var row = nodeTable.insertRow(-1);
	var textCell = row.insertCell(-1);
	textCell.vAlign="middle";
	textCell.align="left";

	var alttext = getNodeTitleAntecedence(role.name, false);
	if (node.imagethumbnail != null && node.imagethumbnail != "") {
		var originalurl = "";
		if(node.urls && node.urls.length > 0){
			for (var i=0 ; i <  node.urls.length; i++){
				var urlid = node.urls[i].url.urlid;
				if (urlid == node.imageurlid) {
					originalurl = node.urls[i].url.url;
					break;
				}
			}
		}
		if (originalurl == "") {
			originalurl = node.imagethumbnail;
		}
		var iconlink = new Element('a', {
			'href':originalurl,
			'title':"<?php echo $LNG->NODE_TYPE_ICON_HINT; ?>", 'target': '_blank' });
 		var nodeicon = new Element('img',{'alt':"<?php echo $LNG->NODE_TYPE_ICON_HINT; ?>", 'style':'width:20px;height:20px;padding-right:5px;', 'src': URL_ROOT + node.imagethumbnail});
 		iconlink.insert(nodeicon);
 		textCell.insert(iconlink);
 		textCell.insert(alttext+": ");
	} else if (role.image != null && role.image != "") {
 		var nodeicon = new Element('img',{'alt':alttext, 'title':alttext, 'style':'width:20px;height:20px;margin-left:10px;margin-right:5px;','src': URL_ROOT + role.image});
		textCell.insert(nodeicon);
	} else {
 		textCell.insert(alttext+": ");
	}

	if (RESOURCE_TYPES_STR.indexOf(role.name) != -1) {
		textCell.insert("<span class='itemtext' style='line-height:1.8em' id='desctoggle"+uniQ+"' onClick='ideatoggle3(\"desc"+uniQ+"\",\""+uniQ+"\", \""+node.nodeid+"\",\"desc\",\""+role.name+"\")'>"+node.description+"</span>");
	} else {
		textCell.insert("<span class='itemtext' style='line-height:1.8em' id='desctoggle"+uniQ+"' onClick='ideatoggle3(\"desc"+uniQ+"\",\""+uniQ+"\", \""+node.nodeid+"\",\"desc\",\""+role.name+"\")'>"+node.name+"</span>");
	}

	if (connection) {
		var cDate = new Date(connection.creationdate*1000);
		var dStr = "<?php echo $LNG->NODE_CONNECTED_BY; ?> "+user.name+ " on "+cDate.format(DATE_FORMAT)+' - <?php echo $LNG->NODE_TOGGLE_HINT;?>';
		textCell.title = dStr;
	}

	var toolbarCell = row.insertCell(-1);
	toolbarCell.vAlign="middle";
	toolbarCell.align="left";

	// ADD ACTION MENU / ITEMS
	if (type == 'active') {
		if (COMMENT_TYPES.indexOf(role.name) == -1 ) {
			var menuButton = new Element('img',{'alt':'>', 'class':'menuicon','src': '<?php echo $HUB_FLM->getImagePath("menuicon.png"); ?>'});
			toolbarCell.appendChild(menuButton);
			Event.observe(menuButton,'mouseout',function (event){
				hideBox('toolbardiv'+uniQ);
			});
			Event.observe(menuButton,'mouseover',function (event) {

				var position = getPosition(this);
				var panel = $('toolbardiv'+uniQ);
				var panelWidth = 130;

				var viewportHeight = getWindowHeight();
				var viewportWidth = getWindowWidth();

				var x = position.x;
				var y = position.y;

				if ( (x+panelWidth+30) > viewportWidth) {
					x = x-(panelWidth+30);
				} else {
					x = x+10;
				}

				x = x+30+getPageOffsetX();

				panel.style.left = x+"px";
				panel.style.top = y+"px";

				showBox('toolbardiv'+uniQ);
			});

			var toolbarDiv = new Element("div", {'id':'toolbardiv'+uniQ, 'class':'toolbarDiv', 'style':'left:-1px;top:-1px;clear:both;position:absolute;display:none;z-index:60;padding:5px;width:130px;border:1px solid gray;background:white'} );
			Event.observe(toolbarDiv,'mouseout',function (event){
				hideBox('toolbardiv'+uniQ);
			});
			Event.observe(toolbarDiv,'mouseover',function (event){ showBox('toolbardiv'+uniQ); });
			toolbarCell.appendChild(toolbarDiv);

			if (RESOURCE_TYPES_STR.indexOf(role.name) != -1) {
				var link = new Element("a", {'href':node.name,'title':'<?php echo $LNG->NODE_URL_LINK_HINT; ?>', 'target':'_blank', 'style':'margin-bottom:5px;clear:both;float:left;'} );
				link.insert("<?php echo $LNG->NODE_URL_LINK_TEXT; ?>");
				toolbarDiv.insert(link);
			}

			var exploreButton = new Element("a", {'class':'d-block','title':"<?php echo $LNG->NODE_DETAIL_BUTTON_HINT; ?>"} );
			exploreButton.insert("<?php echo $LNG->NODE_DETAIL_BUTTON_TEXT; ?>");
			exploreButton.href= "explore.php?id="+node.nodeid;
			toolbarDiv.appendChild(exploreButton);

			if (role.name != 'Theme' && role.name != 'Organization' && role.name != 'Project') {
				var exploreButton = new Element("a", {'class':'d-block','title':"<?php echo $LNG->NODE_DEBATE_BUTTON_HINT; ?>"} );
				exploreButton.insert("<?php echo $LNG->NODE_DEBATE_BUTTON_TEXT; ?>");
				exploreButton.href= "knowledgetrees.php?id="+node.nodeid;
				toolbarDiv.appendChild(exploreButton);
			}

			var exploreButton = new Element("a", {'class':'d-block','title':"<?php echo $LNG->NODE_CHAT_BUTTON_HINT; ?>"} );
			exploreButton.insert("<?php echo $LNG->NODE_CHAT_BUTTON_TEXT; ?>");
			exploreButton.href= "chats.php?id="+node.nodeid;
			toolbarDiv.appendChild(exploreButton);

			var exploreButtonNet = new Element("a", {'class':'d-block','title':"<?php echo $LNG->NODE_MAP_BUTTON_HINT; ?>"} );
			exploreButtonNet.insert("<?php echo $LNG->NODE_MAP_BUTTON_TEXT; ?>");
			exploreButtonNet.href= "networkgraph.php?id="+node.nodeid;
			toolbarDiv.appendChild(exploreButtonNet);

			toolbarDiv.appendChild(createMenuSpacer());

			if (USER == nodeuser.userid) {
				createEditMenuOption(toolbarDiv, node, role, "", nodeuser);
			}

			if (connection && USER == connection.users[0].user.userid) {

				var del = new Element("span", {'class':'active d-block', 'title':"<?php echo $LNG->NODE_DISCONNECT_LINK_HINT; ?>"} );
				del.insert("<?php echo $LNG->NODE_DISCONNECT_LINK_TEXT; ?>");
				del.connid = connection.connid;

				var parentname = "";
				if (node.nodeid == connection.from[0].cnode.nodeid) {
					parentname = connection.to[0].cnode.name;
					if (RESOURCE_TYPES_STR.indexOf(connection.to[0].cnode.role[0].role.name) != -1) {
						parentname = connection.to[0].cnode.description;
					}
				} else {
					parentname = connection.from[0].cnode.name;
					if (RESOURCE_TYPES_STR.indexOf(connection.from[0].cnode.role[0].role.name) != -1) {
						parentname = connection.from[0].cnode.description;
					}
				}

				var fromName = node.name;
				if (RESOURCE_TYPES_STR.indexOf(role.name) != -1) {
					fromName = node.description;
				}
				var toName = parentname;

				Event.observe(del,'click',function (){ deleteNodeConnection(this.connid, fromName, toName, node.handler)});
				toolbarDiv.insert(del);

				if (connection.description == ""
					&& (COMMENT_TYPES.indexOf(role.name) == -1
					&& role.name != "Theme" && focalrole.name != "Theme")
				) {
					var addRelevance = new Element("span", {'class':'active d-block', 'title':"<?php echo $LNG->NODE_RELEVANCE_ADD_ICON_HINT; ?>"} );
					addRelevance.insert("<?php echo $LNG->NODE_RELEVANCE_ADD_MENU_TEXT; ?>");
					addRelevance.connid = connection.connid;
					var handler = new function() {
						location.reload();
					}
					Event.observe(addRelevance,'click',function () { editConnectionDescription(this.connid, "", handler) });
					toolbarDiv.appendChild(addRelevance);
				} else if (connection.description != ""
					&& (COMMENT_TYPES.indexOf(role.name) == -1
					&& role.name != "Theme" && focalrole.name != "Theme")
				) {
					var editRelevance = new Element("span", {'class':'active d-block', 'title':"<?php echo $LNG->NODE_RELEVANCE_EDIT_LINK_HINT; ?>"} );
					editRelevance.insert("<?php echo $LNG->NODE_RELEVANCE_EDIT_LINK_TEXT; ?>");
					editRelevance.connid = connection.connid;
					var handler = new function() {
						location.reload();
					}
					Event.observe(editRelevance,'click',function (){ editConnectionDescription(this.connid, connection.description, handler) });
					toolbarDiv.appendChild(editRelevance);
				}

			}

			var connector = new Element('a',{'class':'d-block','title':"<?php echo $LNG->NODE_VIEW_CONNECTOR_MENU_HINT; ?> "+user.name});
			connector.insert("<?php echo $LNG->NODE_VIEW_CONNECTOR_MENU_TEXT; ?>");
			connector.href = URL_ROOT+"user.php?userid="+user.userid,
			toolbarDiv.appendChild(connector);

			<?php if ($CFG->SPAM_ALERT_ON) { ?>
				toolbarDiv.insert(createSpamMenuOption(node, role));
			<?php } ?>

			// Add voting icons
			if (connection && connection.linktype[0].linktype.label != '<?php echo $CFG->LINK_NODE_SEE_ALSO; ?>') {
				if ( (EVIDENCE_TYPES_STR.indexOf(role.name) != -1 && (connection.torole[0].role.name == "Claim" || connection.torole[0].role.name == "Solution"))
					|| (role.name == 'Claim' && (connection.torole[0].role.name == "Issue" || connection.torole[0].role.name == "Challenge"))
					|| (role.name == 'Solution' && (connection.torole[0].role.name == "Issue" || connection.torole[0].role.name == "Challenge"))
					)  {

					var voteDiv = new Element("div", {'class':'voteDiv d-flex mt-1'});
					voteDiv.insert('<span style="margin-right:5px;"><?php echo $LNG->NODE_VOTE_MENU_TEXT; ?></span>');
					toolbarDiv.insert(voteDiv);

					var toRoleName = getNodeTitleAntecedence(connection.torole[0].role.name, false);

					// vote for
					var voteforimg = document.createElement('img');
					voteforimg.setAttribute('src', '<?php echo $HUB_FLM->getImagePath("thumb-up-grey.png"); ?>');
					voteforimg.setAttribute('alt', '<?php echo $LNG->NODE_VOTE_FOR_ICON_ALT; ?>');
					voteforimg.setAttribute('id', connection.connid+'for');
					voteforimg.nodeid = node.nodeid;
					voteforimg.connid = connection.connid;
					voteforimg.vote='Y';
					voteforimg.style.verticalAlign="bottom";
					voteforimg.style.marginRight="3px";
					voteDiv.insert(voteforimg);
					if (!connection.positivevotes) {
						connection.positivevotes = 0;
					}
					if(USER != ""){
						voteforimg.style.cursor = 'pointer';
						if (role.name == 'Solution') {
							voteforimg.oldtitle = '<?php echo $LNG->NODE_VOTE_FOR_SOLUTION_HINT; ?> '+toRoleName;
						} else if (role.name == 'Claim') {
							voteforimg.oldtitle = '<?php echo $LNG->NODE_VOTE_FOR_CLAIM_HINT; ?> '+toRoleName;
						} else if (EVIDENCE_TYPES_STR.indexOf(role.name) != -1 && connection.torole[0].role.name == "Solution") {
							voteforimg.oldtitle = '<?php echo $LNG->NODE_VOTE_FOR_EVIDENCE_SOLUTION_HINT; ?> '+toRoleName;
						} else if (EVIDENCE_TYPES_STR.indexOf(role.name) != -1 && connection.torole[0].role.name == "Claim") {
							voteforimg.oldtitle = '<?php echo $LNG->NODE_VOTE_FOR_EVIDENCE_CLAIM_HINT; ?> '+toRoleName;
						} else {
							voteforimg.oldtitle = '<?php echo $LNG->NODE_VOTE_FOR_ADD_HINT; ?>';
						}
						if (connection.uservote && connection.uservote == 'Y') {
							Event.observe(voteforimg,'click',function (){ deleteConnectionVote(this) } );
							voteforimg.setAttribute('src', '<?php echo $HUB_FLM->getImagePath("thumb-up-filled.png"); ?>');
							voteforimg.setAttribute('title', '<?php echo $LNG->NODE_VOTE_REMOVE_HINT; ?>');
						} else if (!connection.uservote || connection.uservote != 'Y') {
							Event.observe(voteforimg,'click',function (){ connectionVote(this) } );
							voteforimg.setAttribute('src', '<?php echo $HUB_FLM->getImagePath("thumb-up-empty.png"); ?>');
							voteforimg.setAttribute('title', voteforimg.oldtitle);
						}
						voteDiv.insert('<b><span id="'+connection.connid+'votefor">'+connection.positivevotes+'</span></b>');
					} else {
						voteforimg.setAttribute('title', '<?php echo $LNG->NODE_VOTE_FOR_LOGIN_HINT; ?>');
						voteDiv.insert('<b><span id="'+connection.connid+'votefor">'+connection.positivevotes+'</span></b>');
					}

					// vote against
					var voteagainstimg = document.createElement('img');
					voteagainstimg.setAttribute('src', '<?php echo $HUB_FLM->getImagePath("thumb-down-grey.png"); ?>');
					voteagainstimg.setAttribute('alt', '<?php echo $LNG->NODE_VOTE_AGAINST_ICON_ALT; ?>');
					voteagainstimg.setAttribute('id', connection.connid+'against');
					voteagainstimg.nodeid = node.nodeid;
					voteagainstimg.connid = connection.connid;
					voteagainstimg.vote='N';
					voteagainstimg.style.verticalAlign="bottom";
					voteagainstimg.style.marginRight="3px";
					voteDiv.insert(voteagainstimg);
					if (!connection.negativevotes) {
						connection.negativevotes = 0;
					}
					if(USER != ""){
						voteagainstimg.style.cursor = 'pointer';
						if (role.name == 'Solution') {
							voteagainstimg.oldtitle = '<?php echo $LNG->NODE_VOTE_AGAINST_SOLUTION_HINT; ?> '+toRoleName;
						} else if (role.name == 'Claim') {
							voteagainstimg.oldtitle = '<?php echo $LNG->NODE_VOTE_AGAINST_CLAIM_HINT; ?> '+toRoleName;
						} else if (EVIDENCE_TYPES_STR.indexOf(role.name) != -1 && connection.torole[0].role.name == "Solution") {
							voteagainstimg.oldtitle = '<?php echo $LNG->NODE_VOTE_AGAINST_EVIDENCE_SOLUTION_HINT; ?> '+toRoleName;
						} else if (EVIDENCE_TYPES_STR.indexOf(role.name) != -1 && connection.torole[0].role.name == "Claim") {
							voteagainstimg.oldtitle = '$LNG->NODE_VOTE_AGAINST_EVIDENCE_CLAIM_HINT '+toRoleName;
						} else {
							voteagainstimg.oldtitle = '<?php echo $LNG->NODE_VOTE_AGAINST_ADD_HINT; ?>';
						}
						if (connection.uservote && connection.uservote == 'N') {
							Event.observe(voteagainstimg,'click',function (){ deleteConnectionVote(this) } );
							voteagainstimg.setAttribute('src', '<?php echo $HUB_FLM->getImagePath("thumb-down-filled.png"); ?>');
							voteagainstimg.setAttribute('title', '<?php echo $LNG->NODE_VOTE_REMOVE_HINT; ?>');
						} else if (!connection.uservote || connection.uservote != 'N') {
							Event.observe(voteagainstimg,'click',function (){ connectionVote(this) } );
							voteagainstimg.setAttribute('src', '<?php echo $HUB_FLM->getImagePath("thumb-down-empty.png"); ?>');
							voteagainstimg.setAttribute('title', voteagainstimg.oldtitle);
						}
						voteDiv.insert('<b><span id="'+connection.connid+'voteagainst">'+connection.negativevotes+'</span></b>');
					} else {
						voteagainstimg.setAttribute('title', '<?php echo $LNG->NODE_VOTE_AGAINST_LOGIN_HINT; ?>');
						voteDiv.insert('<b><span id="'+connection.connid+'voteagainst">'+connection.negativevotes+'</span></b>');
					}
				}
			}
		}
	}

	ihDiv.insert(itDiv);

	var iwDiv = new Element("div", {'class':'idea-wrapper'});
	var imDiv = new Element("div", {'class':'idea-main'});
	var idDiv = new Element("div", {'class':'idea-detail'});

	var expandDiv = new Element("div", {'id':'desc'+uniQ,'class':'ideadata', 'style':'display:none;'} );

	if (node.nodetofocusid && node.nodetofocusid != "" && node.nodetofocusid == node.nodeid) {
		expandDiv.style.display="block";
		loadDescriptionRef(node.nodeid, "desc"+uniQ, role.name);
	}

	var nodeTable = document.createElement( 'table' );
	nodeTable.className = "toConnectionsTable";

	expandDiv.insert(nodeTable);

	var row = nodeTable.insertRow(-1);
	var nextCell = row.insertCell(-1);
	nextCell.vAlign="middle";
	nextCell.align="left";

	var userbar = new Element("div", {'style':'clear:both;float:left;'} );
	if (includeUser == true) {
		// Add right side with user image and date below
		var iuDiv = new Element("div", {'class':'idea-user2', 'style':'float:left;'});

		var userimageThumb = new Element('img',{'alt':nodeuser.name, 'title': nodeuser.name, 'style':'padding-left:5px;', 'src': nodeuser.thumb});
		if (type == "active") {
			var imagelink = new Element('a', {
				'href':URL_ROOT+"user.php?userid="+nodeuser.userid,
				'title':nodeuser.name});
			if (breakout != "") {
				imagelink.target = "_blank";
			}
			imagelink.insert(userimageThumb);
			iuDiv.update(imagelink);
		} else {
			iuDiv.insert(userimageThumb)
		}

		userbar.appendChild(iuDiv);
	}

	var iuDiv = new Element("div", {'style':'float:left;'});

	var dStr = "";
	var cDate = new Date(node.creationdate*1000);
	dStr += "<b><?php echo $LNG->NODE_ADDED_ON; ?> </b>"+ cDate.format(DATE_FORMAT) + "<br/>";
	dStr += "<b><?php echo $LNG->NODE_ADDED_BY; ?> </b>"+ nodeuser.name + "";

	iuDiv.insert(dStr);
	userbar.insert(iuDiv);

	nextCell.appendChild(userbar);

	if (node.commonthemes) {
		expandDiv.insert("<br><b><?php echo $LNG->NODE_SHARED_THEMES; ?> </b>"+ node.commonthemes + "<br/><br/>");
	}

	if (connection && connection.description != ""
		&& (COMMENT_TYPES.indexOf(role.name) == -1
			&& role.name != "Theme" && focalrole.name != "Theme")) {
		expandDiv.insert('<span style="margin-top: 5px;"><b><?php echo $LNG->NODE_RELEVANCE_HEADING; ?> </b>'+connection.description+'</span>');
		expandDiv.insert('<br>');
	}

	if (RESOURCE_TYPES_STR.indexOf(role.name) == -1) {
		if(node.description || node.hasdesc){
			var dStr = '<div style="margin:0px;padding=0px;margin-top:5px;" class="idea-desc" id="desc'+uniQ+'div"><span style="margin-top: 5px;"><b><?php echo $LNG->NODE_DESC_HEADING; ?> </b></span><br>';
			if (node.description && node.description != "") {
				expandDiv.description = true;
				dStr += node.description;
			}
			dStr += '</div>';
			expandDiv.insert(dStr);
		}
	}

	// CHILD LISTS
	if (role.name == 'Challenge') {
		expandDiv.insert('<div style="clear:both;"></div>');

		var issueStr = "<span style='font-weight:bold;display:none;float:left;margin-top:5px;' id='toggleissue"+uniQ+"'";
		issueStr += ">";
		issueStr += "<?php echo $LNG->NODE_CHILDREN_ISSUE; ?>";
		issueStr += " (<span id='countissue"+uniQ+"'>0</span>) ";

		expandDiv.insert(issueStr);
		var issueDiv = new Element("div", {'id':'issue'+uniQ, 'style':'clear:both;float:left;margin-left:5px;margin-bottom:5px;color:Gray;display:none;'} );
		expandDiv.insert(issueDiv);

		expandDiv.insert('<div style="clear:both;"></div>');

		var solutionStr = "<span style='font-weight:bold;display:none;float:left;margin-top:5px;' id='togglesolution"+uniQ+"'";
		solutionStr += ">";
		solutionStr += "<?php echo $LNG->NODE_CHILDREN_SOLUTION; ?>";
		solutionStr += " (<span id='countsolution"+uniQ+"'>0</span>) ";

		expandDiv.insert(solutionStr);
		var solutionDiv = new Element("div", {'id':'solution'+uniQ, 'style':'clear:both;float:left;margin-left:5px;margin-bottom:5px;color:Gray;display:none;'} );
		expandDiv.insert(solutionDiv);

		expandDiv.insert('<div style="clear:both;"></div>');

		var claimStr = "<span style='font-weight:bold;display:none;float:left;margin-top:5px;' id='toggleclaim"+uniQ+"'";
		claimStr += ">";
		claimStr += "<?php echo $LNG->NODE_CHILDREN_CLAIM; ?>";
		claimStr += " (<span id='countclaim"+uniQ+"'>0</span>) ";

		expandDiv.insert(claimStr);
		var claimDiv = new Element("div", {'id':'claim'+uniQ, 'style':'clear:both;float:left;margin-left:5px;margin-bottom:5px;color:Gray;display:none;'} );
		expandDiv.insert(claimDiv);

		expandDiv.insert('<div style="clear:both;"></div>');
	} else if (role.name == 'Issue') {
		expandDiv.insert('<div style="clear:both;"></div>');

		var solutionStr = "<span style='font-weight:bold;display:none;float:left;margin-top:5px;' id='togglesolution"+uniQ+"'";
		solutionStr += "'>";
		solutionStr += "<?php echo $LNG->NODE_CHILDREN_SOLUTION; ?>";
		solutionStr += " (<span id='countsolution"+uniQ+"'>0</span>) ";

		expandDiv.insert(solutionStr);
		var solutionDiv = new Element("div", {'id':'solution'+uniQ, 'style':'clear:both;float:left;margin-left:5px;margin-bottom:5px;color:Gray;display:none;'} );
		expandDiv.insert(solutionDiv);

		expandDiv.insert('<div style="clear:both;"></div>');

		var claimStr = "<span style='font-weight:bold;display:none;float:left;margin-top:5px;' id='toggleclaim"+uniQ+"'";
		claimStr += ">";
		claimStr += "<?php echo $LNG->NODE_CHILDREN_CLAIM; ?>";
		claimStr += " (<span id='countclaim"+uniQ+"'>0</span>) ";

		expandDiv.insert(claimStr);
		var claimDiv = new Element("div", {'id':'claim'+uniQ, 'style':'clear:both;float:left;margin-left:5px;margin-bottom:5px;color:Gray;display:none;'} );
		expandDiv.insert(claimDiv);

		expandDiv.insert('<div style="clear:both;"></div>');
	} else if (role.name == 'Claim' || role.name == 'Solution') {
		expandDiv.insert('<div style="clear:both;"></div>');

		var supportStr = "<span style='font-weight:bold;display:none;float:left;margin-top:5px;' id='togglesupport"+uniQ+"'";
		supportStr += ">";
		supportStr += "<?php echo $LNG->NODE_CHILDREN_EVIDENCE_PRO; ?>";
		supportStr += " (<span id='countsupport"+uniQ+"'>0</span>) ";

		expandDiv.insert(supportStr);
		var supportDiv = new Element("div", {'id':'support'+uniQ, 'style':'clear:both;float:left;margin-left:5px;margin-bottom:5px;color:Gray;display:none;'} );
		expandDiv.insert(supportDiv);

		expandDiv.insert('<div style="clear:both;"></div>');

		var opposeStr = "<span style='font-weight:bold;display:none;float:left;margin-top:5px;' id='toggleoppose"+uniQ+"'";
		opposeStr += ">";
		opposeStr += "<?php echo $LNG->NODE_CHILDREN_EVIDENCE_CON; ?>";
		opposeStr += " (<span id='countoppose"+uniQ+"'>0</span>) ";

		expandDiv.insert(opposeStr);
		var opposingDiv = new Element("div", {'id':'oppose'+uniQ, 'style':'clear:both;float:left;margin-left:5px;margin-bottom:5px;color:Gray;display:none;'} );
		expandDiv.insert(opposingDiv);

		expandDiv.insert('<div style="clear:both;"></div>');
	} else if (EVIDENCE_TYPES_STR.indexOf(role.name) != -1) {
		expandDiv.insert('<div style="clear:both;"></div>');

		var resourceStr = "<span style='font-weight:bold;display:none;float:left;margin-top:5px;' id='toggleresource"+uniQ+"'";
		resourceStr += ">";
		resourceStr += "<?php echo $LNG->NODE_CHILDREN_RESOURCES; ?>";
		resourceStr += " (<span id='countresource"+uniQ+"'>0</span>) ";

		expandDiv.insert(resourceStr);
		var resourceDiv = new Element("div", {'id':'resource'+uniQ, 'style':'clear:both;float:left;margin-bottom:5px;color:Gray;display:none;'} );
		expandDiv.insert(resourceDiv);

		expandDiv.insert('<div style="clear:both;"></div>');
	} else if (role.name == 'Comment' && node.connection) {
		var tN = node.connection.to[0].cnode;
		var tRole = tN.role[0].role;
		var title=tN.name;
		if (RESOURCE_TYPES_STR.indexOf(tRole.name) != -1) {
			title = tN.description;
		}

		if (tN.role[0].role.name == "Comment") {
			if (node.connection.parentnode) {
				var nextStr = "<span style='font-weight:bold;clear:both;float:left;margin-top:5px;'>";
				nextStr += "<?php echo $LNG->CHAT_COMMENT_PARENT_FOCUS; ?> ";
				nextStr += "</span>";
				expandDiv.insert(nextStr);

				var title = node.connection.parentnode[0].cnode.name;
				var parentid = node.connection.parentnode[0].cnode.nodeid;
				var exploreButton = new Element("a", {'class':'d-block','title':'<?php echo $LNG->NODE_CHAT_BUTTON_HINT; ?>'} );
				exploreButton.insert(title);
				exploreButton.href= "chats.php?chatnodeid="+node.nodeid+"&id="+parentid;
				expandDiv.insert(exploreButton);
			}
		} else {
			var nextStr = "<span style='font-weight:bold;float:left;margin-top:5px;'>";
			nextStr += "<?php echo $LNG->NODE_COMMENT_PARENT; ?> ";
			nextStr += "</span>";
			expandDiv.insert(nextStr);

			var exploreButton = new Element("a", {'class':'d-block','title':'<?php echo $LNG->NODE_CHAT_BUTTON_HINT; ?>'} );
			exploreButton.insert(title);
			exploreButton.href= "chats.php?chatnodeid="+node.nodeid+"&id="+tN.nodeid;
			expandDiv.insert(exploreButton);
		}
	}

	idDiv.insert(expandDiv);

	imDiv.insert(idDiv);

	iwDiv.insert(imDiv);
	iDiv.insert(ihDiv);
	iDiv.insert(iwDiv);

	return iDiv;
}
/**
 * Render the given node from an associated connection.
 * @param node the node object do render
 * @param uniQ is a unique id element prepended to the nodeid to form an overall unique id within the currently visible site elements
 * @param role the role object for this node
 * @param includeUser whether to include the user image and link
 * @param type defaults to 'active', but can be 'inactive' so nothing is clickable
 * 			or a specialized type for some of the popups
 */
function renderWidgetListNodeMini(node, uniQ, role, includeUser, type){

	if (type === undefined) {
		type = "active";
	}

	if(role === undefined){
		role = node.role[0].role;
	}

	var nodeuser = null;
	// JSON structure different if coming from popup where json_encode used.
	if (node.users[0].userid) {
		nodeuser = node.users[0];
	} else {
		nodeuser = node.users[0].user;
	}
	var user = null;
	var connection = node.connection;
	if (connection) {
		user = connection.users[0].user;
	}

	var breakout = "";

	//needs to check if embedded as a snippet
	if(top.location != self.location){
		breakout = " target='_blank'";
	}

	var focalrole = "";
	if (connection) {
		uniQ = connection.connid+uniQ;
		var fN = connection.from[0].cnode;
		var tN = connection.to[0].cnode;
		if (node.nodeid == fN.nodeid) {
			focalrole = tN.role[0].role;
		} else {
			focalrole = fN.role[0].role;
		}
	} else {
		uniQ = node.nodeid + uniQ;
	}

	var nodeTable = document.createElement('table');
	nodeTable.className = "toConnectionsTable";
	var row = nodeTable.insertRow(-1);

	// VOTING
	if (type == 'active') {
		// Add voting icons
		if (connection && connection.linktype[0].linktype.label != '<?php echo $CFG->LINK_NODE_SEE_ALSO; ?>') {
			if ( (EVIDENCE_TYPES_STR.indexOf(role.name) != -1 && (connection.torole[0].role.name == "Claim" || connection.torole[0].role.name == "Solution"))
				|| (role.name == 'Claim' && (connection.torole[0].role.name == "Issue" || connection.torole[0].role.name == "Challenge"))
				|| (role.name == 'Solution' && (connection.torole[0].role.name == "Issue" || connection.torole[0].role.name == "Challenge"))
				)  {

				var voteCell = row.insertCell(-1);
				voteCell.vAlign="top";
				voteCell.align="left";

				var voteDiv = new Element("div", {'class':'voteDiv d-flex mt-1'});
				voteCell.insert(voteDiv);

				var toRoleName = getNodeTitleAntecedence(connection.torole[0].role.name, false);

				// vote for
				var voteforimg = document.createElement('img');
				voteforimg.setAttribute('src', '<?php echo $HUB_FLM->getImagePath("thumb-up-grey.png"); ?>');
				voteforimg.setAttribute('alt', '<?php echo $LNG->NODE_VOTE_FOR_ICON_ALT; ?>');
				voteforimg.setAttribute('id', connection.connid+'for');
				voteforimg.nodeid = node.nodeid;
				voteforimg.connid = connection.connid;
				voteforimg.vote='Y';
				voteDiv.insert(voteforimg);
				if (!connection.positivevotes) {
					connection.positivevotes = 0;
				}
				if(USER != ""){
					voteforimg.style.cursor = 'pointer';
					if (role.name == 'Solution') {
						voteforimg.oldtitle = '<?php echo $LNG->NODE_VOTE_FOR_SOLUTION_HINT; ?> '+toRoleName;
					} else if (role.name == 'Claim') {
						voteforimg.oldtitle = '<?php echo $LNG->NODE_VOTE_FOR_CLAIM_HINT; ?> '+toRoleName;
					} else if (EVIDENCE_TYPES_STR.indexOf(role.name) != -1 && connection.torole[0].role.name == "Solution") {
						voteforimg.oldtitle = '<?php echo $LNG->NODE_VOTE_FOR_EVIDENCE_SOLUTION_HINT; ?> '+toRoleName;
					} else if (EVIDENCE_TYPES_STR.indexOf(role.name) != -1 && connection.torole[0].role.name == "Claim") {
						voteforimg.oldtitle = '<?php echo $LNG->NODE_VOTE_FOR_EVIDENCE_CLAIM_HINT; ?> '+toRoleName;
					} else {
						voteforimg.oldtitle = '<?php echo $LNG->NODE_VOTE_FOR_ADD_HINT; ?>';
					}
					if (connection.uservote && connection.uservote == 'Y') {
						Event.observe(voteforimg,'click',function (){ deleteConnectionVote(this) } );
						voteforimg.setAttribute('src', '<?php echo $HUB_FLM->getImagePath("thumb-up-filled.png"); ?>');
						voteforimg.setAttribute('title', '<?php echo $LNG->NODE_VOTE_REMOVE_HINT; ?>');
					} else if (!connection.uservote || connection.uservote != 'Y') {
						Event.observe(voteforimg,'click',function (){ connectionVote(this) } );
						voteforimg.setAttribute('src', '<?php echo $HUB_FLM->getImagePath("thumb-up-empty.png"); ?>');
						voteforimg.setAttribute('title', voteforimg.oldtitle);
					}
					voteDiv.insert('<b><span id="'+connection.connid+'votefor">'+connection.positivevotes+'</span></b>');
				} else {
					voteforimg.setAttribute('title', '<?php echo $LNG->NODE_VOTE_FOR_LOGIN_HINT; ?>');
					voteDiv.insert('<b><span id="'+connection.connid+'votefor">'+connection.positivevotes+'</span></b>');
				}

				// vote against
				var voteagainstimg = document.createElement('img');
				voteagainstimg.setAttribute('src', '<?php echo $HUB_FLM->getImagePath("thumb-down-grey.png"); ?>');
				voteagainstimg.setAttribute('alt', '<?php echo $LNG->NODE_VOTE_AGAINST_ICON_ALT; ?>');
				voteagainstimg.setAttribute('id', connection.connid+'against');
				voteagainstimg.nodeid = node.nodeid;
				voteagainstimg.connid = connection.connid;
				voteagainstimg.vote='N';
				voteDiv.insert(voteagainstimg);
				if (!connection.negativevotes) {
					connection.negativevotes = 0;
				}
				if(USER != ""){
					voteagainstimg.style.cursor = 'pointer';
					if (role.name == 'Solution') {
						voteagainstimg.oldtitle = '<?php echo $LNG->NODE_VOTE_AGAINST_SOLUTION_HINT; ?> '+toRoleName;
					} else if (role.name == 'Claim') {
						voteagainstimg.oldtitle = '<?php echo $LNG->NODE_VOTE_AGAINST_CLAIM_HINT; ?> '+toRoleName;
					} else if (EVIDENCE_TYPES_STR.indexOf(role.name) != -1 && connection.torole[0].role.name == "Solution") {
						voteagainstimg.oldtitle = '<?php echo $LNG->NODE_VOTE_AGAINST_EVIDENCE_SOLUTION_HINT; ?> '+toRoleName;
					} else if (EVIDENCE_TYPES_STR.indexOf(role.name) != -1 && connection.torole[0].role.name == "Claim") {
						voteagainstimg.oldtitle = '$LNG->NODE_VOTE_AGAINST_EVIDENCE_CLAIM_HINT '+toRoleName;
					} else {
						voteagainstimg.oldtitle = '<?php echo $LNG->NODE_VOTE_AGAINST_ADD_HINT; ?>';
					}
					if (connection.uservote && connection.uservote == 'N') {
						Event.observe(voteagainstimg,'click',function (){ deleteConnectionVote(this) } );
						voteagainstimg.setAttribute('src', '<?php echo $HUB_FLM->getImagePath("thumb-down-filled.png"); ?>');
						voteagainstimg.setAttribute('title', '<?php echo $LNG->NODE_VOTE_REMOVE_HINT; ?>');
					} else if (!connection.uservote || connection.uservote != 'N') {
						Event.observe(voteagainstimg,'click',function (){ connectionVote(this) } );
						voteagainstimg.setAttribute('src', '<?php echo $HUB_FLM->getImagePath("thumb-down-empty.png"); ?>');
						voteagainstimg.setAttribute('title', voteagainstimg.oldtitle);
					}
					voteDiv.insert('<b><span id="'+connection.connid+'voteagainst">'+connection.negativevotes+'</span></b>');
				} else {
					voteagainstimg.setAttribute('title', '<?php echo $LNG->NODE_VOTE_AGAINST_LOGIN_HINT; ?>');
					voteDiv.insert('<b><span id="'+connection.connid+'voteagainst">'+connection.negativevotes+'</span></b>');
				}
			}
		}
	}

	var textCell = row.insertCell(-1);
	textCell.vAlign="middle";
	textCell.align="left";
	textCell.width="90%";

	var alttext = getNodeTitleAntecedence(role.name, false);
	if (role.image != null && role.image != "") {
 		var nodeicon = new Element('img',{'alt':alttext, 'title':alttext, 'style':'width:20px;height:20px;margin-left:10px;margin-right:5px;','src': URL_ROOT + role.image});
		textCell.insert(nodeicon);
	} else {
 		textCell.insert(alttext+": ");
	}

	var title = node.name;
	if (RESOURCE_TYPES_STR.indexOf(role.name) != -1) {
		title=node.description;
	}

	var exploreButton = new Element('a', {'class':'itemtext', 'id':'desctoggle'+uniQ, 'style':'line-height:1.8em;'});
	if (node.searchid && node.searchid != "") {
		exploreButton.href= "<?php echo $CFG->homeAddress; ?>explore.php?id="+node.nodeid+"&sid="+node.searchid;
	} else {
		exploreButton.href= "<?php echo $CFG->homeAddress; ?>explore.php?id="+node.nodeid;
	}
	exploreButton.insert(title);
	textCell.insert(exploreButton);

	if (connection) {
		var cDate = new Date(connection.creationdate*1000);
		var dStr = "<?php echo $LNG->NODE_CONNECTED_BY; ?> "+user.name+ " on "+cDate.format(DATE_FORMAT)+' - <?php echo $LNG->NODE_DETAIL_BUTTON_HINT;?>';
		textCell.title = dStr;
	}


	if (connection && USER == connection.users[0].user.userid) {

		var delCell = row.insertCell(-1);
		delCell.vAlign="middle";
		delCell.align="right";
		delCell.width="20";

		var del = new Element("span", {'class':'active d-block', 'title':"<?php echo $LNG->NODE_DISCONNECT_LINK_HINT; ?>"} );
		del.insert('<img src="<?php echo $HUB_FLM->getImagePath("delete.png"); ?>" alt="" />');
		del.connid = connection.connid;

		var parentname = "";
		if (node.nodeid == connection.from[0].cnode.nodeid) {
			parentname = connection.to[0].cnode.name;
			if (RESOURCE_TYPES_STR.indexOf(connection.to[0].cnode.role[0].role.name) != -1) {
				parentname = connection.to[0].cnode.description;
			}
		} else {
			parentname = connection.from[0].cnode.name;
			if (RESOURCE_TYPES_STR.indexOf(connection.from[0].cnode.role[0].role.name) != -1) {
				parentname = connection.from[0].cnode.description;
			}
		}

		var fromName = node.name;
		if (RESOURCE_TYPES_STR.indexOf(role.name) != -1) {
			fromName = node.description;
		}
		var toName = parentname;

		Event.observe(del,'click',function (){ deleteNodeConnection(this.connid, fromName, toName, node.handler)});
		delCell.insert(del);
	}

	return nodeTable;
}

/**
 * Render the given node for a report.
 * @param node the node object do render
 * @param uniQ is a unique id element prepended to the nodeid to form an overall unique id within the currently visible site elements
 * @param role the role object for this node
 */
function renderReportNode(node, uniQ, role){

	if(role === undefined){
		role = node.role[0].role;
	}

	var user = null;
	// JSON structure different if coming from popup where json_encode used.
	if (node.users[0].userid) {
		user = node.users[0];
	} else {
		user = node.users[0].user;
	}

	var breakout = "";

	//needs to check if embedded as a snippet
	if(top.location != self.location){
		breakout = " target='_blank'";
	}
	uniQ = node.nodeid + uniQ;
	var iDiv = new Element("div", {'style':'clear:both;float:left; margin-bottom:10px'});
	var itDiv = new Element("div", {'style':'float:left;'});

	//get url for any saved image.
	//add left side with icon image and node text.
	var alttext = getNodeTitleAntecedence(role.name, false);
	if (role.image != null && role.image != "") {
		var nodeicon = new Element('img',{'alt':alttext, 'title':alttext, 'style':'width:16px;height:16px;margin-right:5px;','width':'16','height':'16', 'src': URL_ROOT + role.image});
		itDiv.insert(nodeicon);
	} else {
		itDiv.insert(alttext+": ");
	}

	if (RESOURCE_TYPES_STR.indexOf(role.name) != -1) {
		if (node.description != "") {
			iDiv.insert(itDiv);
			var str = node.description;
			if (node.urls && node.urls.length > 0) {
				str += '<br><?php echo $LNG->NODE_URL_HEADING; ?> <a href="'+node.urls[0].url.url+'">'+node.urls[0].url.url+'</a>';
			}

			iDiv.insert(str);
		}
	} else {
		if (node.name != "") {
			iDiv.insert(itDiv);
			var str = "<div style='float:left;width:600px;'>"+node.name;
			str += "</div>";
			iDiv.insert(str);
		}
	}

	return iDiv;
}


/*** HELPER FUNCTIONS ***/

var DEBATE_TREE_OPEN_ARRAY = {};

/**
 * Open and close the knowledge tree
 */
function toggleDebate(section, uniQ) {
    $(section).toggle();

    if($(section).visible()){
    	DEBATE_TREE_OPEN_ARRAY[section] = true;
    	$('explorearrow'+uniQ).src='<?php echo $HUB_FLM->getImagePath("arrow-down-blue.png"); ?>';
	} else {
    	DEBATE_TREE_OPEN_ARRAY[section] = false;
		$('explorearrow'+uniQ).src='<?php echo $HUB_FLM->getImagePath("arrow-right-blue.png"); ?>';
	}
}

var CHAT_TREE_OPEN_ARRAY = {};

/**
 * Open and close the chat tree
 */
function toggleChat(section, uniQ, forceOpen) {
	if (forceOpen) {
		$(section).style.display = "block";
	} else {
    	$(section).toggle();
    }

    if($(section).visible() || forceOpen){
    	CHAT_TREE_OPEN_ARRAY[section] = true;
    	$('explorechatarrow'+uniQ).src='<?php echo $HUB_FLM->getImagePath("arrow-down-blue.png"); ?>';
	} else {
    	CHAT_TREE_OPEN_ARRAY[section] = false;
		$('explorechatarrow'+uniQ).src='<?php echo $HUB_FLM->getImagePath("arrow-right-blue.png"); ?>';
	}
}


/**
 * Open and close the meta data sections - get additional stuff if required.
 */
function ideatoggle2(section, uniQ, id, sect, rolename) {
    $(section).toggle();

    if(sect == "desc" && $(section).visible() && !$(section).description){
		var reqUrl = SERVICE_ROOT + "&method=getnode&nodeid=" + encodeURIComponent(id);
		new Ajax.Request(reqUrl, { method:'get',
			onSuccess: function(transport){
				var json = transport.responseText.evalJSON();
				if(json.error){
					alert(json.error[0].message);
					return;
				}

				Element.insert($(section+'div'), {'bottom':json.cnode[0].description});
				$(section).description = 'true';
			}
		});
	}
}

/**
 * Open and close the meta data sections - get additional stuff if required.
 */
function ideatoggle3(section, uniQ, id, sect, rolename) {
    $(section).toggle();
    if($('open'+section)){
        if($(section).visible()){
            $('open'+section).update("&laquo; ");
        } else {
            $('open'+section).update("&raquo;");
        }
	}

    if(sect == "desc" && $(section).visible() && !$(section).description){
		var reqUrl = SERVICE_ROOT + "&method=getnode&nodeid=" + encodeURIComponent(id);
		new Ajax.Request(reqUrl, { method:'get',
			onSuccess: function(transport){
				var json = transport.responseText.evalJSON();
				if(json.error){
					alert(json.error[0].message);
					return;
				}

				Element.insert($(section+'div'), {'bottom':json.cnode[0].description});
				$(section).description = 'true';
			}
		});
	}
}

function loadDescriptionRef(id, section, rolename) {
	if (EVIDENCE_TYPES_STR.indexOf(rolename) != -1) { // EVIDENCE
		loadReference(section+"ref", id);
	}
}

/**
 * Open and close the meta data sections - get details if required.
 */
function ideatoggle(section, id, sect){
    $(section).toggle();
    if($('open'+section)){
        if($(section).visible()){
            $('open'+section).update("-");
        } else {
            $('open'+section).update("+");
        }
    }
    //if it is the description
    if(sect == "desc" && $(section).visible() && !$(section).description){
    	var reqUrl = SERVICE_ROOT + "&method=getnode&nodeid=" + encodeURIComponent(id);
		new Ajax.Request(reqUrl, { method:'get',
  			onSuccess: function(transport){
  				var json = transport.responseText.evalJSON();
      			if(json.error){
      				alert(json.error[0].message);
      				return;
      			}


      			Element.insert($(section), {'bottom':json.cnode[0].description});
      			$(section).description = 'true';
    		}
  		});
    }
}

/**
 * Open and close the meta data sections
 */
function justideatoggle(section){
    $(section).toggle();
    if($('open'+section)){
        if($(section).visible()){
            $('open'+section).update("-");
        } else {
            $('open'+section).update("+");
        }
    }
}

/**
 * Fetch the refence for an Evidence node
 */
function loadReference(section, nodeid) {

    if($(section) && !$(section).reference){
    	var reqUrl = SERVICE_ROOT + "&method=getconnectionsbynode&style=long&filternodetypes="+RESOURCE_TYPES+"&filterlist="+encodeURIComponent('is related to')+"&start=0&max=-1&nodeid=" + encodeURIComponent(nodeid);
		new Ajax.Request(reqUrl, { method:'get',
  			onSuccess: function(transport){
  				var json = transport.responseText.evalJSON();
      			if(json.error){
      				alert(json.error[0].message);
      				return;
      			}

				var url = "";
				var refNode = "";

				var conns = json.connectionset[0].connections;
				var nodes = new Array();
				var j=0;
				for(var i=0; i <  conns.length; i++){
					var c = conns[i].connection;
					var fN = c.from[0].cnode;
					var tN = c.to[0].cnode;

					var fnRole = c.fromrole[0].role;
					var tnRole = c.torole[0].role;

					if (RESOURCE_TYPES.indexOf(fnRole.name) && fN.nodeid != nodeid) {
						if (fN.name != "") {
							nodes[j] = fN;
							j++;
						}
					} else if (RESOURCE_TYPES.indexOf(tnRole.name) && tN.nodeid != nodeid) {
						if (tN.name != "") {
							nodes[j] = tN;
							j++;
						}
					}
				}

				for(var i=0; i <  nodes.length; i++){
					var node = nodes[i];
					if (node.urls && node.urls.length > 0) {
						var iUL = new Element("li", {});
						var link = new Element("a", {'href':node.urls[0].url.url,'target':'_blank','title':'<?php echo $LNG->NODE_RESOURCE_LINK_HINT; ?>'} );
						link.insert(node.urls[0].url.title);
						iUL.insert(link);
						$(section).insert(iUL);
					}
      			}

      			$(section).reference = 'true';
    		}
  		});
    }
}


/**
 * Open and close the evidence - get data if required.
 */
function childtoggle(section, nodeid, title, linktype, nodetype){
    $(section).toggle();

    if($('open'+section)){
        if($(section).visible()){
            $('open'+section).update("-");
        } else {
            $('open'+section).update("+");
        }
    }

    childload(section, nodeid, title, linktype, nodetype);
 }

/**
 * load data if required as per parameters.
 */
function childloadcount(section, nodeid, linktype, nodetype){
	var reqUrl = SERVICE_ROOT + "&method=getconnectionsbynode&style=long";
	reqUrl += "&filterlist="+encodeURIComponent(linktype)+"&filternodetypes="+nodetype+"&scope=all&start=0&max=0&nodeid="+nodeid;

	new Ajax.Request(reqUrl, { method:'post',
		onSuccess: function(transport){
			var json = transport.responseText.evalJSON();
			if(json.error){
				alert(json.error[0].message);
				return;
			}
			var count = json.connectionset[0].totalno;

			if (count > 0) {
				$("toggle"+section).style.display = 'block';
				$("count"+section).update(count);
			} else {
				$("toggle"+section).style.display = 'none';
			}
		}
	});
}

/**
 * Refresh child list
 */
function refreshchildren(section, nodeid, title, linktype, nodetype) {
	$(section).loaded = 'false';
	childload(section, nodeid, title, linktype, nodetype);
}

/**
 * load child list, if required as per parameters.
 */
function childload(section, nodeid, title, linktype, nodetype, focalnodeid, uniQ, childCountSpan){

	if (!DEBATE_TREE_SMALL) {
		DEBATE_LOADED_ARRAY['nodeid'+uniQ] = false;
	}

	if (typeof section === "string") {
		section = $(section);
	}

    if(section.visible() && (!section.loaded || section.loaded == 'false')){
		var reqUrl = SERVICE_ROOT + "&method=getconnectionsbynode&style=long";
		reqUrl += "&filterlist="+encodeURIComponent(linktype)+"&filternodetypes="+nodetype+"&scope=all&start=0&max=-1&nodeid="+nodeid;

		new Ajax.Request(reqUrl, { method:'post',
			onSuccess: function(transport){
				var json = transport.responseText.evalJSON();
				if(json.error){
					alert(json.error[0].message);
					return;
				}
				var conns = json.connectionset[0].connections;
				section.update("");

				if (!DEBATE_TREE_SMALL) {
					DEBATE_LOADED_ARRAY['nodeid'+uniQ] = true;
				}

				if (conns.length == 0) {
					section.style.display = 'none';
				} else {
					var nodes = new Array();
					for(var i=0; i <  conns.length; i++){
						var c = conns[i].connection;
						var fN = c.from[0].cnode;
						var tN = c.to[0].cnode;

						var fnRole = c.fromrole[0].role;
						var tnRole = c.torole[0].role;

						if ((fnRole.name == nodetype || nodetype.indexOf(fnRole.name) != -1) && fN.nodeid != nodeid) {
							if (fN.name != "") {
								var next = c.from[0];
								next.cnode['parentid'] = nodeid;
								next.cnode['connection'] = c;
								next.cnode['focalnodeid'] = focalnodeid;
								nodes.push(next);
							}
						} else if ((tnRole.name == nodetype || nodetype.indexOf(tnRole.name) != -1) && tN.nodeid != nodeid) {
							if (tN.name != "") {
								var next = c.to[0];
								next.cnode['parentid'] = nodeid;
								next.cnode['connection'] = c;
								next.cnode['focalnodeid'] = focalnodeid;
								nodes.push(next);
							}
						}
					}

					if (nodes.length > 0){
						if ($('explorearrow'+uniQ)) {
							$('explorearrow'+uniQ).style.visibility = 'visible';
						}

						// ONLY SORT OF TYPE IS RESOURCES - ALL OTHERS SHOULD BE SPLIT CORRECTLY
						if (nodetype == RESOURCE_TYPES_STR) {
							nodes.sort(connectiontypenodesort);
							nodes.sort(connectiontypealphanodesort);
						}

						if (childCountSpan != null) {
							var countnow = parseInt(childCountSpan.innerHTML);
							var finalcount = countnow+nodes.length;
							childCountSpan.innerHTML = finalcount;
						}

						var parentrefreshhanlder = "";
						displayConnectionNodes(section, nodes, parseInt(0), true, uniQ, childCountSpan, parentrefreshhanlder);
					}

					section.loaded = 'true';
				}
			}
		});
	} else {
		childloadcount(section, nodeid, linktype, nodetype);
	}
}

/**
 * load comments built from data, if required as per parameters.
 */
function childcommentload(section, nodeid, linktype, nodetype, uniQ, searchid){

	if (typeof section === "string") {
		section = $(section);
	}

	var	title= "<?php echo $LNG->FORM_COMMENT_CHILD_TITLE; ?>";
	if (nodetype == COMMENT_TYPES+",Idea") {
		title= "<?php echo $LNG->FORM_COMMENT_PARENT_TITLE; ?>";
	}

    if(!section.loaded || section.loaded == 'false'){
		var reqUrl = SERVICE_ROOT + "&method=getconnectionsbynode&style=long";
		reqUrl += "&filterlist="+encodeURIComponent(linktype)+"&filternodetypes="+nodetype+"&scope=all&start=0&max=-1&nodeid="+nodeid;

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
					for(var i=0; i <  conns.length; i++){
						var c = conns[i].connection;
						var fN = c.from[0].cnode;
						var tN = c.to[0].cnode;

						var fnRole = c.fromrole[0].role;
						var tnRole = c.torole[0].role;

						if ((tnRole.name == nodetype || nodetype.indexOf(tnRole.name) != -1) && tN.nodeid != nodeid) {
							if (tN.name != "") {
								var next = c.to[0];
								next.cnode['parentid'] = nodeid;
								next.cnode['connection'] = c;
								nodes.push(next);
							}
						} else if ((fnRole.name == nodetype || nodetype.indexOf(fnRole.name) != -1) && fN.nodeid != nodeid) {
							if (fN.name != "") {
								var next = c.from[0];
								next.cnode['parentid'] = nodeid;
								next.cnode['connection'] = c;
								next.cnode['direction'] = "from";
								nodes.push(next);
							}
						}
					}

					if (nodes.length > 0) {
						section.insert("<b>"+title+"</b><br>");

						var count = nodes.length;
						for (var i=0; i < count; i++) {
							var node = nodes[i];
							node = node.cnode;

							var rolename = node.role[0].role.name;
							var icon = getNodeIconElement(node);

							var nodeTable = document.createElement( 'table' );
							nodeTable.width="100%";
							section.insert(nodeTable);
							var row = nodeTable.insertRow(-1);
							var iconCell = row.insertCell(-1);
							iconCell.vAlign="top";
							iconCell.align="left";
							var textCell = row.insertCell(-1);
							textCell.vAlign="middle";
							textCell.align="left";

							if (rolename != "Comment" && rolename != "Idea") {
								if (icon != null) {
									iconCell.insert(icon);
								}
								var exploreButton = new Element("a", {'style':'clear:both;float:left;;', 'title':'<?php echo $LNG->NODE_EXPLORE_BUTTON_HINT; ?>'} );
								exploreButton.insert(node.name);
								if (searchid != "") {
									exploreButton.href= "explore.php?id="+node.nodeid+"&sid="+searchid;
								} else {
									exploreButton.href= "explore.php?id="+node.nodeid;
								}
								textCell.insert(exploreButton);
							} else {
								if (icon != null) {
									iconCell.insert(icon);
								}

								if (rolename == "Idea") {
									var exploreButton = new Element("a", {'style':'clear:both;float:left;', 'title':'<?php echo $LNG->BUILT_FROM_ITEM_HINT; ?>'} );
									exploreButton.insert(node.name);
									if (searchid != "") {
										exploreButton.href= "explore.php?id="+node.nodeid+"&sid="+searchid;
									} else {
										exploreButton.href= "index.php?q="+encodeURIComponent(node.name)+"&sid="+node.searchid+"#comment-list";
									}
									textCell.insert(exploreButton);
								} else {
									var exploreDiv = new Element("div", {'style':'clear:both;float:left;', 'title':'<?php echo $LNG->BUILT_FROM_ITEM_HINT; ?>'} );
									var textdiv = new Element("div", {'style':'margin-top:3px;margin-bottom:5px;clear:both;float:left;;'} );
									textdiv.insert(node.name);
									var innerdiv = new Element("div", {'style':'clear:both;float:left;;'} );
									exploreDiv.insert(textdiv);
									exploreDiv.insert(innerdiv);
									textCell.insert(exploreDiv);
									childchatusageload(innerdiv, node.nodeid,"<?php echo $CFG->LINK_COMMENT_NODE; ?>", EVIDENCE_TYPES_STR+","+BASE_TYPES_STR+","+COMMENT_TYPES, uniQ+node.nodeid, searchid);
								}
							}
						}
					}

					section.loaded = 'true';
				}

				//if ($('loading'+uniQ)) {
				//	$('loading'+uniQ).remove();
				//}
			}
		});
	}
}

/**
 * load child list, if required as per parameters.
 */
function childchatusageload(section, nodeid, linktype, nodetype, uniQ, searchid){

	if (typeof section === "string") {
		section = $(section);
	}

    if(!section.loaded || section.loaded == 'false'){

    	//if (section.innerHTML == "" && (!section.loaded || section.loaded == 'false')) {
		//	var hourglass = getLoadingLine("<?php echo $LNG->COMMENT_LOADING_MESSAGE; ?>");
		//	hourglass.id="loading"+uniQ;
    	//	section.insert(hourglass);
    	//}

		var reqUrl = SERVICE_ROOT + "&method=getconnectionsbynode&style=long";
		reqUrl += "&filterlist="+encodeURIComponent(linktype)+"&filternodetypes="+nodetype+"&scope=all&start=0&max=-1&nodeid="+nodeid;
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
					for(var i=0; i <  conns.length; i++){
						var c = conns[i].connection;
						var fN = c.from[0].cnode;
						var tN = c.to[0].cnode;

						var fnRole = c.fromrole[0].role;
						var tnRole = c.torole[0].role;

						// only want to get the To end
						if ((tnRole.name == nodetype || nodetype.indexOf(tnRole.name) != -1) && tN.nodeid != nodeid) {
							if (tN.name != "") {
								var next = c.to[0];
								next.cnode['parentid'] = nodeid;
								next.cnode['connection'] = c;
								nodes.push(next);
							}
						}
					}

					if (nodes.length > 0) {
						var	title="<?php echo $LNG->CHAT_COMMENT_PARENT_TREE; ?>";
						section.insert('<span class="d-block">'+title+'</span>');

						var count = nodes.length;
						for (var i=0; i < count; i++) {
							var node = nodes[i];
							node = node.cnode;

							var role = node.role[0].role;
							var name = node.name
							if (RESOURCE_TYPES_STR.indexOf(role.name) != -1) {
								name = node.description;
							}

							if (role.name == "Comment") {
								if (node.connection.parentnode) {
									var icon = getNodeIconElement(node.connection.parentnode[0].cnode);
									var innertitle = node.connection.parentnode[0].cnode.name;
									var parentid = node.connection.parentnode[0].cnode.nodeid;
									var exploreButton = new Element("a", {'class':'d-block','title':'<?php echo $LNG->NODE_CHAT_BUTTON_HINT; ?>'} );
									if (icon != null) {
										exploreButton.insert(icon);
										exploreButton.insert('<span class="col-auto">'+innertitle+'</span>');
									} else {
										exploreButton.insert(innertitle);
									}
									if (searchid != "") {
										exploreButton.href= "chats.php?chatnodeid="+nodeid+"&id="+parentid+"&sid="+searchid;
									} else {
										exploreButton.href= "chats.php?chatnodeid="+nodeid+"&id="+parentid;
									}

									section.insert(exploreButton);
								}
								var nextStr = "<span class='fw-bold nodeComment'>";
								nextStr += "<?php echo $LNG->NODE_COMMENT_PARENT; ?> ";
								nextStr += "<span style='font-weight:normal'>"+name+"</span>";
								nextStr += "</span>";
								section.insert(nextStr);
							} else {
								var icon = getNodeIconElement(node);
								var exploreButton = new Element("a", {'class':'d-block','title':'<?php echo $LNG->NODE_CHAT_BUTTON_HINT; ?>'} );
								if (icon != null) {
									exploreButton.insert(icon);
									exploreButton.insert('<span class="col-auto">'+name+'</span>');
								} else {
									exploreButton.insert(name);
								}

								if (searchid != "") {
									exploreButton.href= "chats.php?chatnodeid="+nodeid+"&id="+node.nodeid+"&sid="+searchid;
								} else {
									exploreButton.href= "chats.php?chatnodeid="+nodeid+"&id="+node.nodeid;
								}

								section.insert(exploreButton);

								var nextStr = "<span class='fw-bold nodeComment'>";
								nextStr += "<?php echo $LNG->NODE_COMMENT_PARENT; ?> ";
								nextStr += "<span style='font-weight:normal'>"+name+"</span>";
								nextStr += "</span>";
								section.insert(nextStr);
							}
						}
					}

					section.loaded = 'true';
				}
			}
		});
	}
}


/**
 * load child list on chat page, if required as per parameters.
 */
function childchatload(section, nodeid, title, linktype, nodetype, chattopic, focalnodeid, uniQ, childCountSpan){

	CHAT_LOADED_ARRAY['nodeid'+uniQ] = false;

	if (typeof section === "string") {
		section = $(section);
	}

    if($(section).visible() && (!$(section).loaded || $(section).loaded == 'false')){

		var reqUrl = SERVICE_ROOT + "&method=getconnectionsbynode&style=long&sort=ASC&orderby=date";
		reqUrl += "&filterlist="+encodeURIComponent('<?php echo $CFG->LINK_COMMENT_NODE; ?>')+"&filternodetypes=Comment&scope=all&start=0&max=-1&nodeid="+nodeid;

		new Ajax.Request(reqUrl, { method:'post',
			onSuccess: function(transport){
				var json = transport.responseText.evalJSON();
				if(json.error){
					alert(json.error[0].message);
					return;
				}

				CHAT_LOADED_ARRAY['nodeid'+uniQ] = true;

				var conns = json.connectionset[0].connections;
				section.update("");

				if (conns.length == 0) {
					//section.style.display = 'none';
					if ($('chat'+uniQ)) {
						$('chat'+uniQ).style.display = 'none';
					}
				} else {
					var nodes = new Array();
					for(var i=0; i <  conns.length; i++){
						var c = conns[i].connection;
						var fN = c.from[0].cnode;
						var tN = c.to[0].cnode;

						var fnRole = c.fromrole[0].role;
						var tnRole = c.torole[0].role;

						var fnRole = c.from[0].cnode.role[0].role; // c.fromrole[0].role;
						var tnRole = c.to[0].cnode.role[0].role; //c.torole[0].role;

						if (fN.nodeid != nodeid && COMMENT_TYPES.indexOf(fnRole.name) != -1) {
							if (fN.name != "") {
								var next = c.from[0];
								next.cnode['parentid'] = nodeid;
								next.cnode['chattopic'] = chattopic;
								next.cnode['connection'] = c;
								next.cnode['handler'] = 'refreshExploreChats';
								nodes.push(next);
							}
						}
					}

					if (nodes.length > 0){
						if ($('explorechatarrow'+uniQ)) {
							$('explorechatarrow'+uniQ).style.visibility = 'visible';
						}

						if ($('chatremove'+uniQ)) {
							$('chatremove'+uniQ).style.display = "none";
						}
						if (childCountSpan != null) {
							var countnow = parseInt(childCountSpan.innerHTML);
							var finalcount = countnow+nodes.length;
							childCountSpan.innerHTML = finalcount;
						}
						displayChatNodes(section, nodes, parseInt(0), true, uniQ, childCountSpan);
					} else {
						if ($('chat'+uniQ)) {
							$('chat'+uniQ).style.display = 'none';
						}
						section.style.display = 'none';
					}

					section.loaded = 'true';
				}
			}
		});
	} else {
		//childloadcount(section, nodeid, linktype, nodetype);
	}
}


/**
 * Delete the selected node
 */
function deleteNode(nodeid, name, type, handler, handlerparam){
	var typename = getNodeTitleAntecedence(type, false);
	if (type == "") {
		typename = '<?php echo $LNG->NODE_DELETE_CHECK_MESSAGE_ITEM; ?>';
	}

	var ans = confirm("<?php echo $LNG->NODE_DELETE_CHECK_MESSAGE; ?> "+typename+": '"+htmlspecialchars_decode(name)+"'?");
	if(ans){
		var reqUrl = SERVICE_ROOT + "&method=deletenode&nodeid=" + encodeURIComponent(nodeid);
		new Ajax.Request(reqUrl, { method:'get',
  			onSuccess: function(transport){

  				var json = transport.responseText.evalJSON();

      			if(json.error){
      				alert(json.error[0].message);
      				return;
      			}

				//now refresh the page
				if (handler) {

					if (typeof handler == 'string') {
						var pos = handler.indexOf(")");
						if (pos != -1) {
							eval ( handler );
						} else {
							if (handlerparam) {
								eval( handler + "('"+handlerparam+"')" );
							} else {
								eval( handler + "()" );
							}
						}
					} else if (typeof handler == 'function') {
						if (handlerparam) {
							handler(handlerparam);
						} else {
							handler();
						}
					} else {
						console.log(typeof handler);
					}
				} else {
					try {
						// If you are deleting the currently viewed item
						if (nodeid == NODE_ARGS['nodeid']) {
							window.location.href = "<?php echo $CFG->homeAddress;?>";
						} else {
							window.location.reload(true);
						}
					} catch(err) {
						//do nothing
					}
				}
    		}
  		});

	}
}

function nodeVote(obj) {
	var reqUrl = SERVICE_ROOT + "&method=nodevote&vote="+obj.vote+"&nodeid="+obj.nodeid;
	new Ajax.Request(reqUrl, { method:'get',
		onSuccess: function(transport){
			var json = transport.responseText.evalJSON();
   			if(json.error) {
   				alert(json.error[0].message);
   				return;
   			} else {
   				if (obj.vote == 'Y') {

  					$$("#nodevotefor"+obj.nodeid).each(function(elmt) { elmt.innerHTML = json.cnode[0].positivevotes; });

   					$$("#nodefor"+obj.nodeid).each(function(elmt) {
   						elmt.setAttribute('src', '<?php echo $HUB_FLM->getImagePath("thumb-up-filled3.png"); ?>');
   						elmt.setAttribute('title', '<?php echo $LNG->NODE_VOTE_REMOVE_HINT; ?>');
   						Event.stopObserving(elmt, 'click');
   						Event.observe(elmt,'click', function (){deleteNodeVote(this);});
   					});

  					$$("#nodevoteagainst"+obj.nodeid).each(function(elmt) { elmt.innerHTML = json.cnode[0].negativevotes; });

  					$$("#nodeagainst"+obj.nodeid).each(function(elmt) {
  						elmt.setAttribute('src', '<?php echo $HUB_FLM->getImagePath("thumb-down-empty3.png"); ?>');
  						elmt.setAttribute('title', '<?php echo $LNG->NODE_VOTE_AGAINST_ADD_HINT; ?>');
  						Event.stopObserving(elmt, 'click');
  						Event.observe(elmt,'click', function (){nodeVote(this) } );
  					});
				} else if (obj.vote == 'N') {
					$$("#nodevoteagainst"+obj.nodeid).each(function(elmt) { elmt.innerHTML = json.cnode[0].negativevotes; });

   					$$("#nodeagainst"+obj.nodeid).each(function(elmt) {
   						elmt.setAttribute('src', '<?php echo $HUB_FLM->getImagePath("thumb-down-filled3.png"); ?>');
   						elmt.setAttribute('title', '<?php echo $LNG->NODE_VOTE_REMOVE_HINT; ?>');
   						Event.stopObserving(elmt, 'click');
   						Event.observe(elmt,'click', function (){deleteNodeVote(this) } );
   					});

  					$$("#nodevotefor"+obj.nodeid).each(function(elmt) { elmt.innerHTML = json.cnode[0].positivevotes; });

  					$$("#nodefor"+obj.nodeid).each(function(elmt) {
  						elmt.setAttribute('src', '<?php echo $HUB_FLM->getImagePath("thumb-up-empty3.png"); ?>');
  						elmt.setAttribute('title', '<?php echo $LNG->NODE_VOTE_FOR_ADD_HINT; ?>');
  						Event.stopObserving(elmt, 'click');
  						Event.observe(elmt,'click', function (){nodeVote(this) } );
  					});
				}
   			}
   		}
  	});
}

function deleteNodeVote(obj) {
	var reqUrl = SERVICE_ROOT + "&method=deletenodevote&vote="+obj.vote+"&nodeid="+obj.nodeid;
	new Ajax.Request(reqUrl, { method:'get',
		onSuccess: function(transport){
			var json = transport.responseText.evalJSON();
   			if(json.error) {
   				alert(json.error[0].message);
   				return;
   			} else {
   				if (obj.vote == 'Y') {

  					$$("#nodevotefor"+obj.nodeid).each(function(elmt) { elmt.innerHTML = json.cnode[0].positivevotes; });

   					$$("#nodefor"+obj.nodeid).each(function(elmt) {
   						elmt.setAttribute('src', '<?php echo $HUB_FLM->getImagePath("thumb-up-empty3.png"); ?>');
   						elmt.setAttribute('title', '<?php echo $LNG->NODE_VOTE_FOR_ADD_HINT; ?>');
   						Event.stopObserving(elmt, 'click');
   						Event.observe(elmt,'click', function (){nodeVote(this);});
   					});

  					$$("#nodevoteagainst"+obj.nodeid).each(function(elmt) { elmt.innerHTML = json.cnode[0].negativevotes; });

  					$$("#nodeagainst"+obj.nodeid).each(function(elmt) {
  						elmt.setAttribute('src', '<?php echo $HUB_FLM->getImagePath("thumb-down-empty3.png"); ?>');
  						elmt.setAttribute('title', '<?php echo $LNG->NODE_VOTE_AGAINST_ADD_HINT; ?>');
  						Event.stopObserving(elmt, 'click');
  						Event.observe(elmt,'click', function (){nodeVote(this) } );
  					});

					$(obj.nodeid+obj.uniqueid+'nodeagainst').setAttribute('src', '<?php echo $HUB_FLM->getImagePath("thumb-down-empty3.png"); ?>');
					$(obj.nodeid+obj.uniqueid+'nodeagainst').setAttribute('title', '<?php echo $LNG->NODE_VOTE_AGAINST_ADD_HINT; ?>');
					Event.stopObserving($(obj.nodeid+obj.uniqueid+'nodeagainst'), 'click');
					Event.observe($(obj.nodeid+obj.uniqueid+'nodeagainst'),'click', function (){ connectionVote(this) } );

				} if (obj.vote == 'N') {
					$$("#nodevoteagainst"+obj.nodeid).each(function(elmt) { elmt.innerHTML = json.cnode[0].negativevotes; });

   					$$("#nodeagainst"+obj.nodeid).each(function(elmt) {
   						elmt.setAttribute('src', '<?php echo $HUB_FLM->getImagePath("thumb-down-empty3.png"); ?>');
   						elmt.setAttribute('title', '<?php echo $LNG->NODE_VOTE_AGAINST_ADD_HINT; ?>');
   						Event.stopObserving(elmt, 'click');
   						Event.observe(elmt,'click', function (){nodeVote(this) } );
   					});

  					$$("#nodevotefor"+obj.nodeid).each(function(elmt) { elmt.innerHTML = json.cnode[0].positivevotes; });

  					$$("#nodefor"+obj.nodeid).each(function(elmt) {
  						elmt.setAttribute('src', '<?php echo $HUB_FLM->getImagePath("thumb-up-empty3.png"); ?>');
  						elmt.setAttribute('title', '<?php echo $LNG->NODE_VOTE_FOR_ADD_HINT; ?>');
  						Event.stopObserving(elmt, 'click');
  						Event.observe(elmt,'click', function (){nodeVote(this) } );
  					});
				}
   			}
   		}
  	});
}

function followNode(node, obj, handler) {

	let nodeid = node.nodeid;
	if (obj && obj.nodeid) {
		nodeid = obj.nodeid;
	}

	var reqUrl = SERVICE_ROOT + "&method=addfollowing&itemid="+nodeid;
	new Ajax.Request(reqUrl, { method:'get',
		onSuccess: function(transport){
			var json = transport.responseText.evalJSON();
   			if(json.error) {
   				alert(json.error[0].message);
   				return;
   			} else {
   				node.userfollow = "Y";

				if (handler) {
					if (typeof handler === 'string') {
						var pos = handler.indexOf(")");
						if (pos != -1) {
							eval ( handler );
						} else {
							eval( handler + "()" );
						}
					} else if (typeof handler == 'function') {
						handler();
					}

					if (obj) {
						obj.setAttribute('src', '<?php echo $HUB_FLM->getImagePath("following.png"); ?>');
						obj.setAttribute('title', '<?php echo $LNG->NODE_UNFOLLOW_ITEM_HINT; ?>');
						Event.stopObserving(obj, 'click');
						Event.observe(obj,'click', function (){ unfollowNode(node, this, handler) } );
					}
				}
   			}
   		}
  	});
}

function unfollowNode(node, obj, handler) {

	let nodeid = node.nodeid;
	if (obj && obj.nodeid) {
		nodeid = obj.nodeid;
	}

	var reqUrl = SERVICE_ROOT + "&method=deletefollowing&itemid="+nodeid;
	new Ajax.Request(reqUrl, { method:'get',
		onSuccess: function(transport){
			var json = transport.responseText.evalJSON();
   			if(json.error) {
   				alert(json.error[0].message);
   				return;
   			} else {
   				node.userfollow = "N";

				if (handler) {
					if (typeof handler === 'string') {
						var pos = handler.indexOf(")");
						if (pos != -1) {
							eval ( handler );
						} else {
							eval( handler + "()" );
						}
					} else if (typeof handler == 'function') {
						handler();
					}

					if (obj) {
						obj.setAttribute('src', '<?php echo $HUB_FLM->getImagePath("follow.png"); ?>');
						obj.setAttribute('title', '<?php echo $LNG->NODE_FOLLOW_ITEM_HINT; ?>');
						Event.stopObserving(obj, 'click');
						Event.observe(obj,'click', function (){ followNode(node, this, handler) } );
					}
				}
   			}
   		}
  	});
}

/**
 * Called from user home page follow list.
 */
function unfollowMyNode(nodeid) {
	var reqUrl = SERVICE_ROOT + "&method=deletefollowing&itemid="+nodeid;
	new Ajax.Request(reqUrl, { method:'get',
		onSuccess: function(transport){
			var json = transport.responseText.evalJSON();
   			if(json.error) {
   				alert(json.error[0].message);
   				return;
   			} else {
				try {
					window.location.reload(true);
				} catch(err) {
					//do nothing
				}
   			}
   		}
  	});
}

/**
 *	show an RSS feed of the nodes for the given arguments
 */
function getNodesFeed(nodeargs) {
	var url = SERVICE_ROOT.replace('format=json','format=rss');
	var args = Object.clone(nodeargs);
	args["start"] = 0;
	args["style"] = 'long';
	var reqUrl = url+"&method=getnodesby"+CONTEXT+"&"+Object.toQueryString(args);
	window.location.href = reqUrl;
}

/**
 *	show an RSS feed of the nodes for the given arguments
 */
function getCommentNodesFeed(nodeargs) {
	var url = SERVICE_ROOT.replace('format=json','format=rss');
	var args = Object.clone(nodeargs);
	args["start"] = 0;
	args["style"] = 'long';
	var reqUrl = url+"&method=getconnectednodesby"+CONTEXT+"&"+Object.toQueryString(args);
	window.location.href = reqUrl;
}

/**
 * Print current node list in new popup window
 */
function printNodes(nodeargs, title) {
	var url = SERVICE_ROOT;

	var args = Object.clone(nodeargs);
	args["start"] = 0;
	args["max"] = -1;
	args["style"] = 'long';

	var reqUrl = url+"&method=getnodesby"+CONTEXT+"&"+Object.toQueryString(args);
	var urlcall =  URL_ROOT+"ui/popups/printnodes.php?context="+CONTEXT+"&title="+title+"&filternodetypes="+args['filternodetypes']+"&url="+encodeURIComponent(reqUrl);

	loadDialog('printnodes', urlcall, 800, 700);
}


/**
 * Print current node list in new popup window
 */
function printCommentNodes(nodeargs, title) {
	var url = SERVICE_ROOT;

	var args = Object.clone(nodeargs);
	args["start"] = 0;
	args["max"] = -1;
	args["style"] = 'long';

	var reqUrl = url+"&method=getconnectednodesby"+CONTEXT+"&"+Object.toQueryString(args);
	var urlcall =  URL_ROOT+"ui/popups/printnodes.php?context="+CONTEXT+"&title="+title+"&filternodetypes="+args['filternodetypes']+"&url="+encodeURIComponent(reqUrl);

	loadDialog('printnodes', urlcall, 800, 700);
}

/**
 * Print current explore page in new popup window
 */
function printNodeExplore(nodeargs, title, nodeid){
	var url = SERVICE_ROOT;

	var args = Object.clone(nodeargs);
	args["start"] = 0;
	args["max"] = -1;
	args["style"] = 'long';

	var reqUrl = url+"&method=getnode&"+Object.toQueryString(args);
	var urlcall =  URL_ROOT+"ui/popups/printexplore.php?context="+CONTEXT+"&title="+encodeURIComponent(title)+"&nodeid="+nodeid+"&url="+encodeURIComponent(reqUrl);

	loadDialog('printexplore', urlcall, 800, 700);
}

/**
 * Print current knowledge tree explore page in new popup window
 */
function printKnowledgeTreeExplore(nodeargs, title, nodeid, name){
	var url = SERVICE_ROOT;

	var args = Object.clone(nodeargs);
	args["start"] = 0;
	args["max"] = -1;
	args["style"] = 'long';

	var urlcall =  URL_ROOT+"ui/popups/printknowledgetree.php?context="+CONTEXT+"&title="+encodeURIComponent(title)+"&nodetype="+args['nodetype']+"&nodeid="+nodeid+"&name="+encodeURIComponent(name);

	loadDialog('printknowledgetree', urlcall, 800, 700);
}

// NODE CONNECTION FUNCTIONS

function connectionVote(obj) {
	var reqUrl = SERVICE_ROOT + "&method=connectionvote&vote="+obj.vote+"&connid="+obj.connid;
	new Ajax.Request(reqUrl, { method:'get',
		onSuccess: function(transport){
			var json = transport.responseText.evalJSON();
   			if(json.error) {
   				alert(json.error[0].message);
   				return;
   			} else {
   				if (obj.vote == 'Y') {
					$(obj.connid+'votefor').innerHTML = json.connection[0].positivevotes;
					obj.setAttribute('src', '<?php echo $HUB_FLM->getImagePath("thumb-up-filled.png"); ?>');
					obj.setAttribute('title', '<?php echo $LNG->NODE_VOTE_REMOVE_HINT; ?>');
					Event.stopObserving(obj, 'click');
					Event.observe(obj,'click', function (){ deleteConnectionVote(this) } );

					$(obj.connid+'voteagainst').innerHTML = json.connection[0].negativevotes;
					$(obj.connid+'against').setAttribute('src', '<?php echo $HUB_FLM->getImagePath("thumb-down-empty.png"); ?>');
					$(obj.connid+'against').setAttribute('title', $(obj.connid+'against').oldtitle);
					Event.stopObserving($(obj.connid+'against'), 'click');
					Event.observe($(obj.connid+'against'),'click', function (){ connectionVote(this) } );
				} else if (obj.vote == 'N') {
					$(obj.connid+'voteagainst').innerHTML = json.connection[0].negativevotes;
					obj.setAttribute('src', '<?php echo $HUB_FLM->getImagePath("thumb-down-filled.png"); ?>');
					obj.setAttribute('title', '<?php echo $LNG->NODE_VOTE_REMOVE_HINT; ?>');
					Event.stopObserving(obj, 'click');
					Event.observe(obj,'click', function (){ deleteConnectionVote(this) } );

					$(obj.connid+'votefor').innerHTML = json.connection[0].positivevotes;
					$(obj.connid+'for').setAttribute('src', '<?php echo $HUB_FLM->getImagePath("thumb-up-empty.png"); ?>');
					$(obj.connid+'for').setAttribute('title', $(obj.connid+'for').oldtitle);
					Event.stopObserving($(obj.connid+'for'), 'click');
					Event.observe($(obj.connid+'for'),'click', function (){ connectionVote(this) } );
				}
   			}
   		}
  	});
}

function deleteConnectionVote(obj) {
	var reqUrl = SERVICE_ROOT + "&method=deleteconnectionvote&vote="+obj.vote+"&connid="+obj.connid;
	new Ajax.Request(reqUrl, { method:'get',
		onSuccess: function(transport){
			var json = transport.responseText.evalJSON();
   			if(json.error) {
   				alert(json.error[0].message);
   				return;
   			} else {
   				if (obj.vote == 'Y') {
					$(obj.connid+'votefor').innerHTML = json.connection[0].positivevotes;
					obj.setAttribute('src', '<?php echo $HUB_FLM->getImagePath("thumb-up-empty.png"); ?>');
					obj.setAttribute('title', obj.oldtitle);
					Event.stopObserving(obj, 'click');
					Event.observe(obj,'click', function (){ connectionVote(this) } );

					$(obj.connid+'voteagainst').innerHTML = json.connection[0].negativevotes;
					$(obj.connid+'against').setAttribute('src', '<?php echo $HUB_FLM->getImagePath("thumb-down-empty.png"); ?>');
					$(obj.connid+'against').setAttribute('title', $(obj.connid+'against').oldtitle);
					Event.stopObserving($(obj.connid+'against'), 'click');
					Event.observe($(obj.connid+'against'),'click', function (){ connectionVote(this) } );
				} if (obj.vote == 'N') {
					$(obj.connid+'voteagainst').innerHTML = json.connection[0].negativevotes;
					obj.setAttribute('src', '<?php echo $HUB_FLM->getImagePath("thumb-down-empty.png"); ?>');
					obj.setAttribute('title', obj.oldtitle);
					Event.stopObserving(obj, 'click');
					Event.observe(obj,'click', function (){ connectionVote(this) } );

					$(obj.connid+'votefor').innerHTML = json.connection[0].positivevotes;
					$(obj.connid+'for').setAttribute('src', '<?php echo $HUB_FLM->getImagePath("thumb-up-empty.png"); ?>');
					$(obj.connid+'for').setAttribute('title', $(obj.connid+'for').oldtitle);
					Event.stopObserving($(obj.connid+'for'), 'click');
					Event.observe($(obj.connid+'for'),'click', function (){ connectionVote(this) } );
				}
   			}
   		}
  	});
}

/**
 * Edit the connection description for the given connection id.
 */
function editConnectionDescription(connid, desc, handler) {
	textAreaPrompt('<?php echo $LNG->NODE_CONNECTION_RELEVANCE_MESSAGE; ?>', desc, connid, handler, 'processConnectionDesciption');
}

/**
 * View the connection description.
 */
function viewConnectionDescription(desc) {
	alert(desc);
}

/**
 * Save the  edit of the connection description for the given connection id.
 */
function processConnectionDesciption(connid, desc, handler) {
	var reqUrl = SERVICE_ROOT + "&method=editconnectiondescription&description="+encodeURIComponent(desc)+"&connid=" + encodeURIComponent(connid);
	new Ajax.Request(reqUrl, { method:'get',
		onSuccess: function(transport){
			var json = transport.responseText.evalJSON();
			if(json.error){
				alert(json.error[0].message);
				return;
			}
			if (handler === 'undefined' || handler === undefined) {
				try {
					window.location.reload(true);
				} catch(err) {
					//do nothing
				}
			} else {
				var pos = handler.indexOf(")");
				if (pos != -1) {
					eval ( handler );
				} else {
					eval( handler + "()" );
				}
			}
		}
	});
}

/**
 * Delete the connection for the given connection id.
 */
function deleteNodeConnection(connid, childname, parentname, handler) {
	var ans = confirm("<?php echo $LNG->NODE_DISCONNECT_CHECK_MESSAGE_PART1; ?> \n\n'"+htmlspecialchars_decode(childname)+"'\n\n <?php echo $LNG->NODE_DISCONNECT_CHECK_MESSAGE_PART2; ?> \n\n'"+htmlspecialchars_decode(parentname)+"' <?php echo $LNG->NODE_DISCONNECT_CHECK_MESSAGE_PART3; ?>");
	if(ans){
		var reqUrl = SERVICE_ROOT + "&method=deleteconnection&connid=" + encodeURIComponent(connid);
		new Ajax.Request(reqUrl, { method:'get',
  			onSuccess: function(transport){
  				var json = transport.responseText.evalJSON();
      			if(json.error){
      				alert(json.error[0].message);
      				return;
      			}

				if (handler) {
					var pos = handler.indexOf(")");
					if (pos != -1) {
						eval ( handler );
					} else {
						eval( handler + "()" );
					}
				} else {
					try {
						window.location.reload(true);
					} catch(err) {
						//do nothing
					}
				}
    		}
  		});
	}
}

/**
 * Delete the connection for the given connection id for a chat item.
 */
function deleteChatNode(nodeid, name, handler, parentconnid) {
	var ans = confirm("<?php echo $LNG->CHAT_DELETE_CHECK_MESSAGE_PART1; ?> '"+htmlspecialchars_decode(name)+"'<?php echo $LNG->CHAT_DELETE_CHECK_MESSAGE_PART2; ?>");
	if(ans){
		var reqUrl = SERVICE_ROOT + "&method=deletecomment&nodeid=" +encodeURIComponent(nodeid)+"&parentconnid="+encodeURIComponent(parentconnid);
		new Ajax.Request(reqUrl, { method:'get',
  			onSuccess: function(transport){
  				var json = transport.responseText.evalJSON();
      			if(json.error){
      				alert(json.error[0].message);
      				return;
      			}

				if (handler) {
					var pos = handler.indexOf(")");
					if (pos != -1) {
						eval ( handler );
					} else {
						eval( handler + "()" );
					}
				} else {
					try {
						window.location.reload(true);
					} catch(err) {
						//do nothing
					}
				}
    		}
  		});
	}
}

/**
 * Redraw the nodes borders when a different node is selected for connecting.
 */
function refreshTextDivCell() {

	var cellsArray = document.getElementsByName('textDivCell');
	var count = cellsArray.length;
	var next = null;

	for (var i=0; i < count; i++) {
		next = cellsArray[i];

		if (next.nodeid == CURRENT_ADD_AREA_NODEID) {
			var bordercolor = 'plainborder';
			var backcolor = 'focusedback';
			if (next.nodetype == 'Challenge') {
				bordercolor = 'challengeborder';
				if (next.nodeid == next.focalnodeid) {
					backcolor = 'challengeback';
				}
			} else if (next.nodetype == 'Issue') {
				bordercolor = 'issueborder';
				if (next.nodeid == next.focalnodeid) {
					backcolor = 'issueback';
				}
			} else if (next.nodetype == 'Claim') {
				bordercolor = 'claimborder';
				if (next.nodeid == next.focalnodeid) {
					backcolor = 'claimback';
				}
			} else if (next.nodetype == 'Solution') {
				bordercolor = 'solutionborder';
				if (next.nodeid == next.focalnodeid) {
					backcolor = 'solutionback';
				}
			} else if (EVIDENCE_TYPES_STR.indexOf(next.nodetype) != -1) {
				bordercolor = 'evidenceborder';
				if (next.nodeid == next.focalnodeid) {
					backcolor = 'evidenceback';
				}
			} else if (RESOURCE_TYPES_STR.indexOf(next.nodetype) != -1) {
				bordercolor = 'resourceborder';
				if (next.nodeid == next.focalnodeid) {
					backcolor = 'resourceback';
				}
			}

			//if (next.nodeid == next.focalnodeid) {
				//bordercolor = 'selectedborder';
			//}

			next.className = backcolor+' '+bordercolor;
		} else if (next.nodeid == next.focalnodeid) {
			var bordercolor = 'plainborder';
			var backcolor = 'whiteback';
			if (next.nodetype == 'Challenge') {
				bordercolor = 'challengeborder';
				backcolor = 'challengeback';
			} else if (next.nodetype == 'Issue') {
				bordercolor = 'issueborder';
				backcolor = 'issueback';
			} else if (next.nodetype == 'Claim') {
				bordercolor = 'claimborder';
				backcolor = 'claimback';
			} else if (next.nodetype == 'Solution') {
				bordercolor = 'solutionborder';
				backcolor = 'solutionback';
			} else if (EVIDENCE_TYPES_STR.indexOf(next.nodetype) != -1) {
				bordercolor = 'evidenceborder';
				backcolor = 'evidenceback';
			} else if (RESOURCE_TYPES_STR.indexOf(next.nodetype) != -1) {
				bordercolor = 'resourceborder';
				backcolor = 'resourceback';
			}
			next.className = backcolor+' '+bordercolor;
		} else {
			next.className = 'whiteborder';
		}
	}

	var nodeAreaArray = document.getElementsByName('nodeArea');
	count = nodeAreaArray.length;
	next = null;
	for (var i=0; i < count; i++) {
		next = nodeAreaArray[i];
		if (next.nodeid == next.focalnodeid) {
			continue;
		}

		if (next.nodeid == CURRENT_ADD_AREA_NODEID) {
			if (next.nodeid == next.focalnodeid) {
				next.className = 'itemtextwhite';
			} else {
				next.className = 'itemtext selectedlabel';
			}
		} else {
			next.className = 'itemtext unselectedlabel';
		}
	}
}

/**
 * does the narrow debate tree contain the currently selected node?.
 * If not, display a helpful message to the user.
 * (a node on the expanded tree may have been selected that is not in the narrow view).
 */
function checkHasNarrowGotSelected() {

}

/**
 * does the debate tree contain the passed node?.
 * If not, ask user if they want to refocus the debate on the given nodeid.
 * If yes, scroll to the first occurrence and add a 'New' message to the title.
 */
function checkDebateHasNode(nodetofocusid) {

	if (nodetofocusid === undefined) {
		nodetofocusid = "";
	}

	if (nodetofocusid != "") {

		// Are all the debates closed?
		// If so we want to open the ones the new node is in.
		var allClosed = true;
		var arrowsArray = document.getElementsByName('explorearrow');
		var uniQArray = new Array();
		var uniQArrayToOpen = new Array();
		var nextarrow = null;
		var countarrow = arrowsArray.length;
		for (var i=0; i < countarrow; i++) {
			nextarrow = arrowsArray[i];
			var uniQ = nextarrow.uniqueid;
			uniQArray.push(uniQ);
			if ($("treedesc"+uniQ) && $("treedesc"+uniQ).style.display == 'block') {
				allClosed = false;
				break;
			}
		}

		//alert(allClosed);

		var cellsArray = document.getElementsByName('textDivCell');
		var count = cellsArray.length;
		var next = null;

		var found = false;
		var foundCell = null;

		for (var i=0; i < count; i++) {
			next = cellsArray[i];

			if (next.connection) {
				var fNnodeid = next.connection.from[0].cnode.nodeid;
				var tNnodeid = next.connection.to[0].cnode.nodeid;

				if ( (nodetofocusid == fNnodeid && tNnodeid == CURRENT_ADD_AREA_NODEID)
					|| (nodetofocusid == tNnodeid && fNnodeid == CURRENT_ADD_AREA_NODEID)) {

					if (next.nodeid == nodetofocusid) {
						if (allClosed) {
							for (var j=0; j<uniQArray.length; j++) {
								var nextuniq = uniQArray[j];
								if (next.id.indexOf(nextuniq) != -1) {
									uniQArrayToOpen.push(nextuniq);
									break;
								}
							}
						}
						if (next.style.borderColor != "red"){
							next.style.borderColor = "red";
							next.insert('<span style="clear:both;float:left;color: red; margin-top:5px;margin-left:5px;"><?php echo $LNG->DEBATE_HIGHLIGHT_ADDED_TEXT; ?></span>');
						}
					} else {
						if (allClosed) {
							for (var j=0; j<uniQArray.length;j++) {
								var nextuniq = uniQArray[j];
								if (nextuniq.indexOf(next.parentuniQ) != -1) {
									uniQArrayToOpen.push(next.parentuniQ);
									break;
								}
							}
						}
						if ($('textDivCell'+next.parentuniQ) && $('textDivCell'+next.parentuniQ).style.borderColor != "red"){
							$('textDivCell'+next.parentuniQ).style.borderColor = "red";
							$('textDivCell'+next.parentuniQ).insert('<span style="float:left;color: red; margin-top:5px;margin-left:5px;"><?php echo $LNG->DEBATE_HIGHLIGHT_ADDED_TEXT; ?></span>');
						}
					}
				}else {
					// If coming from an edit it will not match the CURRENT_ADD_AREA_NODEID
					if ( (nodetofocusid == fNnodeid) || (nodetofocusid == tNnodeid)) {

						if (next.nodeid == nodetofocusid) {
							if (allClosed) {
								for (var j=0; j<uniQArray.length; j++) {
									var nextuniq = uniQArray[j];
									if (next.id.indexOf(nextuniq) != -1) {
										uniQArrayToOpen.push(nextuniq);
										break;
									}
								}
							}
							if (next.style.borderColor != "red"){
								next.style.borderColor = "red";
								next.insert('<span style="clear:both;float:left;color: red; margin-top:5px;margin-left:5px;"><?php echo $LNG->DEBATE_HIGHLIGHT_ADDED_TEXT; ?></span>');
							}
						} else {
							if (allClosed) {
								for (var j=0; j<uniQArray.length;j++) {
									var nextuniq = uniQArray[j];
									if (nextuniq.indexOf(next.parentuniQ) != -1) {
										uniQArrayToOpen.push(next.parentuniQ);
										break;
									}
								}
							}
							if ($('textDivCell'+next.parentuniQ) && $('textDivCell'+next.parentuniQ).style.borderColor != "red"){
								$('textDivCell'+next.parentuniQ).style.borderColor = "red";
								$('textDivCell'+next.parentuniQ).insert('<span style="float:left;color: red; margin-top:5px;margin-left:5px;"><?php echo $LNG->DEBATE_HIGHLIGHT_ADDED_TEXT; ?></span>');
							}
						}
					}
				}
			}

			if (!found) {
				if (DEBATE_TREE_SMALL) {
					if (next.id.indexOf('narrow') != -1) {
						if (next.nodeid == nodetofocusid) {
							foundCell = next;
							found = true;
						}
					}
				} else {
					if (next.nodeid == nodetofocusid) {
						found = true;
						foundCell = next;
					}
				}
			}
		}

		if (!found) {
			var reply = confirm("<?php echo $LNG->DEBATE_MISSING_ADDED_ITEM_QUESTION; ?>");
			if (reply == true) {
				window.location.href="<?php echo $CFG->homeAddress; ?>/knowledgetrees.php?id="+nodetofocusid;
			}
		} else {
			//open the required debates
			if (allClosed) {
				for (var i=0; i < uniQArrayToOpen.length; i++) {
					var nextuniq = uniQArrayToOpen[i];
					if ($("treedesc"+nextuniq)) {
						toggleDebate("treedesc"+nextuniq, nextuniq);
					}
				}
			}

			var pos = getPosition(foundCell);
			window.scroll(0,pos.y-100);
		}
	} else {
		var arrowsArray = document.getElementsByName('explorearrow');
		var countarrow = arrowsArray.length;
		if (countarrow <= <?php echo $CFG->debateCountOpen; ?>) {
			nextarrow = arrowsArray[0];
			var uniQ = nextarrow.uniqueid;
			var countnow = parseInt($('toptreecount'+uniQ).innerHTML);
			if (countnow < <?php echo $CFG->debateChildCountOpen; ?> || countarrow == 1) {
				toggleDebate("treedesc"+uniQ, uniQ);
			}
		}
	}
}

/**
 * does the chat tree contain anything?
 * If not, hide the arrows.
 */
function checkChatHasNode(nodetofocusid) {

	if (CHATNODEID != "") {

		// Are all the chats closed?
		// If so we want to open the one the chat node is in.
		var uniQArray = new Array();
		var uniQArrayToOpen = new Array();

		var allClosed = true;
		var arrowsArray = document.getElementsByName('explorechatarrow');
		var nextarrow = null;
		var countarrow = arrowsArray.length;
		for (var i=0; i < countarrow; i++) {
			nextarrow = arrowsArray[i];
			var uniQ = nextarrow.uniqueid;
			uniQArray.push(uniQ);
			if ($("chat"+uniQ) && $("chat"+uniQ).style.display == 'block') {
				allClosed = false;
			}
			var countnow = parseInt($('topchattreecount'+uniQ).innerHTML);
			if (countnow == 0) {
				nextarrow.style.display = "none";
			} else {
				nextarrow.style.display = "block";
			}
		}

		//alert(allClosed);

		var cellsArray = document.getElementsByName('textChatDivCell');
		var count = cellsArray.length;
		var next = null;

		var found = false;
		var foundCell = null;

		for (var i=0; i < count; i++) {
			next = cellsArray[i];

			if (next.nodeid == CHATNODEID) {
				if (allClosed) {
					for (var j=0; j<uniQArray.length; j++) {
						var nextuniq = uniQArray[j];
						if (next.id.indexOf(nextuniq) != -1) {
							uniQArrayToOpen.push(nextuniq);
							found = true;
							foundCell = next;
							break;
						}
					}
				}
			}
		}

		//open the required chat
		if (allClosed) {
			for (var i=0; i < uniQArrayToOpen.length; i++) {
				var nextuniq = uniQArrayToOpen[i];
				if ($("chat"+nextuniq)) {
					toggleChat("chat"+nextuniq, nextuniq, false);
				}
			}
		}

		var pos = getPosition(foundCell);
		window.scroll(0,pos.y-100);
	} else {
		var arrowsArray = document.getElementsByName('explorechatarrow');
		var nextarrow = null;
		var countarrow = arrowsArray.length;
		for (var i=0; i < countarrow; i++) {
			nextarrow = arrowsArray[i];
			var uniQ = nextarrow.uniqueid;
			var countnow = parseInt($('topchattreecount'+uniQ).innerHTML);
			if (countnow == 0) {
				nextarrow.style.display = "none";
			} else {
				nextarrow.style.display = "block";
			}

			if (i == 0) {
				if (typeof CHAT_TREE_OPEN_ARRAY["chat"+uniQ] === 'undefined') {
					if (CHAT_TREE_OPEN_ARRAY["chat"+uniQ] == true) {
						toggleChat("chat"+uniQ, uniQ, true);
					}
				} else if (countarrow <= <?php echo $CFG->chatCountOpen; ?>) {
					if (countnow > 0 && countnow < <?php echo $CFG->chatChildCountOpen; ?>) {
						toggleChat("chat"+uniQ, uniQ, true);
					}
				}
			}
		}
	}
}

function highlightDebateAddArea() {
	//$('debateadddiv').style.border = '2px solid yellow';
	$('debateadddiv').style.background = '#F9FABC';
    var fade=setTimeout("new function(){/*$('debateadddiv').style.border = '2px solid #D3D3D3';*/$('debateadddiv').style.background = 'white';}",1500);
}

/**
 * Send a spam alert to the server.
 */
function reportNodeSpamAlert(obj, nodetype, node) {

	var name = node.name;
	if (RESOURCE_TYPES_STR.indexOf(nodetype) != -1) {
		name = node.description;
	}

	var ans = confirm("<?php echo $LNG->SPAM_CONFIRM_MESSAGE_PART1; ?>\n\n"+name+"\n\n<?php echo $LNG->SPAM_CONFIRM_MESSAGE_PART2; ?>\n\n");
	if (ans){
		var reqUrl = URL_ROOT + "spamalert.php?type=idea&id="+node.nodeid;
		new Ajax.Request(reqUrl, { method:'get',
			onError: function(error) {
		   		alert(error);
			},
			onSuccess: function(transport){
				node.status = 1;
				obj.title = '<?php echo $LNG->SPAM_REPORTED_HINT; ?>';
				if (obj.alt) {
					obj.alt = '<?php echo $LNG->SPAM_REPORTED_TEXT; ?>';
					obj.src= '<?php echo $HUB_FLM->getImagePath('spam-reported.png'); ?>';
					obj.style.cursor = 'auto';
					Event.stopObserving(obj, 'click');
				} else {
					obj.innerHTML = '<?php echo $LNG->SPAM_REPORTED_TEXT; ?>';
				}
				obj.className = "";
				fadeMessage(name+"<br><br><?php echo $LNG->SPAM_SUCCESS_MESSAGE; ?>");
			}
		});
	}
}

/**
 * Create a span menu option to report spam / show spam reported / or say login to report.
 *
 * @param node the node to report
 */
function createSpamMenuOption(node, nodetype) {

	var spaming = new Element("span", {'class':'active d-block'} );

	if (node.status == <?php echo $CFG->STATUS_SPAM; ?>) {
		spaming.insert("<?php echo $LNG->SPAM_REPORTED_TEXT; ?>");
		spaming.title = '<?php echo $LNG->SPAM_REPORTED_HINT; ?>';
		spaming.className = "";
	} else if (node.status == <?php echo $CFG->STATUS_ACTIVE; ?>) {
		if (USER != "") {
			spaming.insert("<?php echo $LNG->SPAM_REPORT_TEXT; ?>");
			spaming.title = '<?php echo $LNG->SPAM_REPORT_HINT; ?>';
			Event.observe(spaming,'click',function (){ reportNodeSpamAlert(this, nodetype, node); } );
		} else {
			spaming.insert("<?php echo $LNG->SPAM_LOGIN_REPORT_TEXT; ?>");
			spaming.title = '<?php echo $LNG->SPAM_LOGIN_REPORT_TEXT; ?>';
			Event.observe(spaming,'click',function (){ $('loginsubmit').click(); return true; } );
		}
	}

	return spaming;
}

function getNodeIconElement(node) {
	var role = node.role[0].role;
	if (node.imagethumbnail != null && node.imagethumbnail != "") {
		var originalurl = "";
		if(node.urls && node.urls.length > 0){
			for (var i=0 ; i <  node.urls.length; i++){
				var urlid = node.urls[i].url.urlid;
				if (urlid == node.imageurlid) {
					originalurl = node.urls[i].url.url;
					break;
				}
			}
		}
		if (originalurl == "") {
			originalurl = node.imagethumbnail;
		}
		var iconlink = new Element('a', {
			'href':originalurl,
			'title':"<?php echo $LNG->NODE_TYPE_ICON_HINT; ?>", 'target': '_blank' });
		var nodeicon = new Element('img',{'alt':"<?php echo $LNG->NODE_TYPE_ICON_HINT; ?>", 'class':'nodeIcon', 'src': URL_ROOT + node.imagethumbnail});
		iconlink.insert(nodeicon);

		return iconlink;
	} else if (role.image != null && role.image != "") {
		var alttext = getNodeTitleAntecedence(role.name, false);
		var nodeicon = new Element('img',{'alt':alttext, 'class':'nodeIcon','src': URL_ROOT + role.image});
		return nodeicon;
	}
	return null;
}


/**
 * Create a menu spacer line
 */
function createMenuSpacer() {
	var spacer = new Element("hr", {'class':'hrline-slim', 'style':'margin-bottom:10px;width:100%'} );
	return spacer;
}

/**
 * Create an edit menu option
 *
 * @param toolbarDiv the div to add the menu optioj to
 * @param node the node to connect
 * @param role the node type of the node
 * @param parentrefreshhandler the name of the function that handles the refresh after edit.
 * @param user the user wanting to edit this item.
 */
function createEditMenuOption(toolbarDiv, node, role, parentrefreshhandler, user) {
	// IF OWNER ADD EDIT / DEL ACTIONS
	if (USER == user.userid) {
		if (role.name == 'Issue') {
			var editButton = new Element("span", {'class':'active d-block', 'title':'<?php echo $LNG->NODE_EDIT_ISSUE_ICON_HINT; ?>'} );
			editButton.insert("<?php echo $LNG->NODE_EDIT_ICON_ALT; ?>");
			Event.observe(editButton,'click',function (){loadDialog('editissue',URL_ROOT+"ui/popups/issueedit.php?handler="+parentrefreshhandler+"&nodeid="+node.nodeid, 750,500)});
			toolbarDiv.appendChild(editButton);
		} else if (role.name == 'Challenge') {
			var editButton = new Element("span", {'class':'active d-block', 'title':'<?php echo $LNG->NODE_EDIT_CHALLENGE_ICON_HINT; ?>'} );
			editButton.insert("<?php echo $LNG->NODE_EDIT_ICON_ALT; ?>");
			Event.observe(editButton,'click',function (){loadDialog('editchallenge',URL_ROOT+"ui/popups/challengeedit.php?handler="+parentrefreshhandler+"&nodeid="+node.nodeid, 750,500)});
			toolbarDiv.appendChild(editButton);
		} else if (role.name == 'Claim') {
			var editButton = new Element("span", {'class':'active d-block', 'title':'<?php echo $LNG->NODE_EDIT_CLAIM_ICON_HINT; ?>'} );
			editButton.insert("<?php echo $LNG->NODE_EDIT_ICON_ALT; ?>");
			Event.observe(editButton,'click',function (){loadDialog('editclaim',URL_ROOT+"ui/popups/claimedit.php?handler="+parentrefreshhandler+"&nodeid="+node.nodeid, 750,500)});
			toolbarDiv.appendChild(editButton);
		} else if (role.name == 'Solution') {
			var editButton = new Element("span", {'class':'active d-block', 'title':'<?php echo $LNG->NODE_EDIT_SOLUTION_ICON_HINT; ?>'} );
			editButton.insert("<?php echo $LNG->NODE_EDIT_ICON_ALT; ?>");
			Event.observe(editButton,'click',function (){loadDialog('editsolution',URL_ROOT+"ui/popups/solutionedit.php?handler="+parentrefreshhandler+"&nodeid="+node.nodeid, 750,500)});
			toolbarDiv.appendChild(editButton);
		} else if (role.name == 'Organization') {
			var editButton = new Element("span", {'class':'active d-block', 'title':'<?php echo $LNG->NODE_EDIT_ORG_ICON_HINT; ?>'} );
			editButton.insert("<?php echo $LNG->NODE_EDIT_ICON_ALT; ?>");
			Event.observe(editButton,'click',function (){loadDialog('editorg',URL_ROOT+"ui/popups/organizationedit.php?handler="+parentrefreshhandler+"&nodeid="+node.nodeid, 750,500)});
			toolbarDiv.appendChild(editButton);
		} else if (role.name == 'Project') {
			var editButton = new Element("span", {'class':'active d-block', 'title':'<?php echo $LNG->NODE_EDIT_PROJECT_ICON_HINT; ?>'} );
			editButton.insert("<?php echo $LNG->NODE_EDIT_ICON_ALT; ?>");
			Event.observe(editButton,'click',function (){loadDialog('editorg',URL_ROOT+"ui/popups/organizationedit.php?handler="+parentrefreshhandler+"&nodeid="+node.nodeid, 750,500)});
			toolbarDiv.appendChild(editButton);
		} else if (EVIDENCE_TYPES_STR.indexOf(role.name) != -1) { //EVIDENCE
			var editButton = new Element("span", {'class':'active d-block', 'title':'<?php echo $LNG->NODE_EDIT_EVIDENCE_ICON_HINT; ?>'} );
			editButton.insert("<?php echo $LNG->NODE_EDIT_ICON_ALT; ?>");
			Event.observe(editButton,'click',function (){loadDialog('editevidence',URL_ROOT+"ui/popups/evidenceedit.php?handler="+parentrefreshhandler+"&nodetypename="+role.name+"&nodeid="+node.nodeid, 750,500)});
			toolbarDiv.appendChild(editButton);
		} else if (RESOURCE_TYPES_STR.indexOf(role.name) != -1) { //RESOURCES
			var editButton = new Element("span", {'class':'active d-block', 'title':'<?php echo $LNG->NODE_EDIT_RESOURCE_ICON_HINT; ?>'} );
			editButton.insert("<?php echo $LNG->NODE_EDIT_ICON_ALT; ?>");
			Event.observe(editButton,'click',function (){loadDialog('editresource',URL_ROOT+"ui/popups/resourceedit.php?handler="+parentrefreshhandler+"&nodetypename="+role.name+"&nodeid="+node.nodeid, 750,500)});
			toolbarDiv.appendChild(editButton);
		}
	}
}

/**
 * Create a explore menu option
 *
 * @param toolbarDiv the div to add the menu optioj to
 * @param node the node to connect
 * @param role the node type of the node
 * @param uniQ the unique id added to interface elements for this node option.
 */
function createExploreMenuOption(toolbarDiv, node, role, uniQ) {

	var exploreButton = new Element("div", {'class':'active','style':'font-style:italic;margin-bottom:5px;'} );

	exploreButton.insert("<?php echo $LNG->NODE_EXPLORE_BUTTON_TEXT; ?>");
	toolbarDiv.appendChild(exploreButton);
	var exploresubmenu = createExploreSubMenu(node, role, uniQ)
	exploreButton.appendChild(exploresubmenu);

	Event.observe(exploreButton,'mouseover',function (event){
	    exploresubmenu.style.display = 'block';
	});
}

/**
 * Create a explore sub menu options.
 *
 * @param node the node to connect
 * @param role the node type of the node
 * @param uniQ the unique id added to interface elements for this node option.
 */
function createExploreSubMenu(node, role, uniQ) {

	var exploresubmenu = new Element("div", {'id':'exploresubmenu'+uniQ, 'style':'font-style:normal;clear:both;display:none;padding:5px;padding-top:2px;margin-left:30px;'} );

	var exploreButton = new Element("a", {'class':'d-block','title':"<?php echo $LNG->NODE_DETAIL_BUTTON_HINT; ?>"} );
	exploreButton.insert("<?php echo $LNG->NODE_DETAIL_BUTTON_TEXT; ?>");
	if (node.searchid && node.searchid != "") {
		exploreButton.href= "<?php echo $CFG->homeAddress; ?>explore.php?id="+node.nodeid+"&sid="+node.searchid;
	} else {
		exploreButton.href= "<?php echo $CFG->homeAddress; ?>explore.php?id="+node.nodeid;
	}
	exploresubmenu.appendChild(exploreButton);

	if (role.name != 'Theme' && role.name != 'Organization' && role.name != 'Project') {
		var exploreButton = new Element("a", {'class':'d-block','title':"<?php echo $LNG->NODE_DEBATE_BUTTON_HINT; ?>"} );
		exploreButton.insert("<?php echo $LNG->NODE_DEBATE_BUTTON_TEXT; ?>");
		if (node.searchid && node.searchid != "") {
			exploreButton.href= "<?php echo $CFG->homeAddress; ?>knowledgetrees.php?id="+node.nodeid+"&sid="+node.searchid;
		} else {
			exploreButton.href= "<?php echo $CFG->homeAddress; ?>knowledgetrees.php?id="+node.nodeid;
		}
		exploresubmenu.appendChild(exploreButton);
	}

	var exploreButton = new Element("a", {'class':'d-block','title':"<?php echo $LNG->NODE_CHAT_BUTTON_HINT; ?>"} );
	exploreButton.insert("<?php echo $LNG->NODE_CHAT_BUTTON_TEXT; ?>");
	if (node.searchid && node.searchid != "") {
		exploreButton.href= "<?php echo $CFG->homeAddress; ?>chats.php?id="+node.nodeid+"&sid="+node.searchid;
	} else {
		exploreButton.href= "<?php echo $CFG->homeAddress; ?>chats.php?id="+node.nodeid;
	}
	exploresubmenu.appendChild(exploreButton);

	exploreButton = new Element("a", {'class':'d-block','title':"<?php echo $LNG->NODE_MAP_BUTTON_HINT; ?>"} );
	exploreButton.insert("<?php echo $LNG->NODE_MAP_BUTTON_TEXT; ?>");
	if (node.searchid && node.searchid != "") {
		exploreButton.href= "<?php echo $CFG->homeAddress; ?>networkgraph.php?id="+node.nodeid+"&sid="+node.searchid;
	} else {
		exploreButton.href= "<?php echo $CFG->homeAddress; ?>networkgraph.php?id="+node.nodeid;
	}
	exploresubmenu.appendChild(exploreButton);

	if (RESOURCE_TYPES_STR.indexOf(role.name) != -1) {
		var link = new Element("a", {'href':node.name,'title':"<?php echo $LNG->NODE_URL_LINK_HINT; ?>", 'target':'_blank', 'style':'margin-bottom:5px;clear:both;float:left;'} );
		link.insert("<?php echo $LNG->NODE_URL_LINK_TEXT; ?>");
		exploresubmenu.insert(link);
	}

	return exploresubmenu;
}


/**
 * Create a 'connect To' menu option.
 *
 * @param toolbarDiv the div to add the menu optioj to
 * @param node the node to connect
 * @param role the node type of the node
 * @param uniQ the unique id added to interface elements for this node option.
 */
function createConnectionMenuOption(toolbarDiv, node, role, uniQ) {

	if (USER != "") {
		var connectButton = new Element("div", {'class':'active','style':'font-style:italic;margin-bottom:5px;'} );
		connectButton.insert("<?php echo $LNG->CONNECTION_MENU_OPTION_TEXT; ?>");
		toolbarDiv.appendChild(connectButton);
		var connectionsubmenu = createConnectionSubMenu(node, role, uniQ)
		connectButton.appendChild(connectionsubmenu);
		Event.observe(connectButton,'mouseover',function (event){
		    connectionsubmenu.style.display = 'block';
		});
	} else {
		var connectButton = new Element("div", {'class':'active d-block'} );
		connectButton.insert("<?php echo $LNG->CONNECTION_MENU_OPTION_LOGIN_TEXT; ?>");
		connectButton.title = '<?php echo $LNG->CONNECTION_MENU_OPTION_LOGIN_HINT; ?>';
		Event.observe(connectButton,'click',function (){ $('loginsubmit').click(); return true; } );
		toolbarDiv.appendChild(connectButton);
	}
}

/**
 * Create a connection sub menu options.
 *
 * @param node the node to connect
 * @param role the node type of the node
 * @param uniQ the unique id added to interface elements for this node option.
 */
function createConnectionSubMenu(node, role, uniQ) {

	var connectionsubmenu = new Element("div", {'id':'connectionsubmenu'+uniQ, 'style':'font-style:normal;clear:both;display:none;padding:5px;padding-top:2px;margin-left:30px;'} );

	var type = role.name;
	if (type == "Challenge") {
		var exploreButton = new Element("a", {'style':'margin-bottom:5px; display: block;'} );
		exploreButton.insert("<?php echo $LNG->ISSUES_NAME; ?>");
		if (node.searchid && node.searchid != "") {
			exploreButton.href= "<?php echo $CFG->homeAddress; ?>knowledgetrees.php?id="+node.nodeid+"&sid="+node.searchid;
		} else {
			exploreButton.href= "<?php echo $CFG->homeAddress; ?>knowledgetrees.php?id="+node.nodeid;
		}
		connectionsubmenu.appendChild(exploreButton);

		var exploreButton = new Element("a", {'style':'margin-bottom:5px; display: block;'} );
		exploreButton.insert("<?php echo $LNG->ORGS_NAME; ?>");
		if (node.searchid && node.searchid != "") {
			exploreButton.href= "<?php echo $CFG->homeAddress; ?>explore.php?id="+node.nodeid+"&sid="+node.searchid;
		} else {
			exploreButton.href= "<?php echo $CFG->homeAddress; ?>explore.php?id="+node.nodeid;
		}
		connectionsubmenu.insert(exploreButton);

		var exploreButton = new Element("a", {'style':'margin-bottom:5px; display: block;'} );
		exploreButton.insert("<?php echo $LNG->PROJECTS_NAME; ?>");
		if (node.searchid && node.searchid != "") {
			exploreButton.href= "<?php echo $CFG->homeAddress; ?>explore.php?id="+node.nodeid+"&sid="+node.searchid;
		} else {
			exploreButton.href= "<?php echo $CFG->homeAddress; ?>explore.php?id="+node.nodeid;
		}
		connectionsubmenu.insert(exploreButton);

	} else if (type == "Issue") {
		if (hasChallenge) {
			var exploreButton = new Element("a", {'style':'margin-bottom:5px; display: block;'} );
			exploreButton.insert("<?php echo $LNG->CHALLENGES_NAME; ?>");
			if (node.searchid && node.searchid != "") {
				exploreButton.href= "<?php echo $CFG->homeAddress; ?>explore.php?id="+node.nodeid+"&sid="+node.searchid;
			} else {
				exploreButton.href= "<?php echo $CFG->homeAddress; ?>explore.php?id="+node.nodeid;
			}
			connectionsubmenu.appendChild(exploreButton);
		}
		if (hasSolution) {
			var exploreButton = new Element("a", {'style':'margin-bottom:5px; display: block;'} );
			exploreButton.insert("<?php echo $LNG->SOLUTIONS_NAME; ?>");
			if (node.searchid && node.searchid != "") {
				exploreButton.href= "<?php echo $CFG->homeAddress; ?>knowledgetrees.php?id="+node.nodeid+"&sid="+node.searchid;
			} else {
				exploreButton.href= "<?php echo $CFG->homeAddress; ?>knowledgetrees.php?id="+node.nodeid;
			}
			connectionsubmenu.appendChild(exploreButton);
		}
		if (hasClaim) {
			var exploreButton = new Element("a", {'style':'margin-bottom:5px; display: block;'} );
			exploreButton.insert("<?php echo $LNG->CLAIMS_NAME; ?>");
			if (node.searchid && node.searchid != "") {
				exploreButton.href= "<?php echo $CFG->homeAddress; ?>knowledgetrees.php?id="+node.nodeid+"&sid="+node.searchid;
			} else {
				exploreButton.href= "<?php echo $CFG->homeAddress; ?>knowledgetrees.php?id="+node.nodeid;
			}
			connectionsubmenu.appendChild(exploreButton);
		}

		var exploreButton = new Element("a", {'style':'margin-bottom:5px; display: block;'} );
		exploreButton.insert("<?php echo $LNG->ORGS_NAME; ?>");
		if (node.searchid && node.searchid != "") {
			exploreButton.href= "<?php echo $CFG->homeAddress; ?>explore.php?id="+node.nodeid+"&sid="+node.searchid;
		} else {
			exploreButton.href= "<?php echo $CFG->homeAddress; ?>explore.php?id="+node.nodeid;
		}
		connectionsubmenu.insert(exploreButton);

		var exploreButton = new Element("a", {'style':'margin-bottom:5px; display: block;'} );
		exploreButton.insert("<?php echo $LNG->PROJECTS_NAME; ?>");
		if (node.searchid && node.searchid != "") {
			exploreButton.href= "<?php echo $CFG->homeAddress; ?>explore.php?id="+node.nodeid+"&sid="+node.searchid;
		} else {
			exploreButton.href= "<?php echo $CFG->homeAddress; ?>explore.php?id="+node.nodeid;
		}
		connectionsubmenu.insert(exploreButton);

	} else if (type == "Solution" || type == "Claim") {
		var exploreButton = new Element("a", {'style':'margin-bottom:5px; display: block;'} );
		exploreButton.insert("<?php echo $LNG->ISSUES_NAME; ?>");
		if (node.searchid && node.searchid != "") {
			exploreButton.href= "<?php echo $CFG->homeAddress; ?>explore.php?id="+node.nodeid+"&sid="+node.searchid;
		} else {
			exploreButton.href= "<?php echo $CFG->homeAddress; ?>explore.php?id="+node.nodeid;
		}
		connectionsubmenu.appendChild(exploreButton);

		var exploreButton = new Element("a", {'style':'margin-bottom:5px; display: block;'} );
		exploreButton.insert("<?php echo $LNG->EVIDENCES_NAME; ?>");
		if (node.searchid && node.searchid != "") {
			exploreButton.href= "<?php echo $CFG->homeAddress; ?>knowledgetrees.php?id="+node.nodeid+"&sid="+node.searchid;
		} else {
			exploreButton.href= "<?php echo $CFG->homeAddress; ?>knowledgetrees.php?id="+node.nodeid;
		}
		connectionsubmenu.appendChild(exploreButton);

		var exploreButton = new Element("a", {'style':'margin-bottom:5px; display: block;'} );
		exploreButton.insert("<?php echo $LNG->ORGS_NAME; ?>");
		if (node.searchid && node.searchid != "") {
			exploreButton.href= "<?php echo $CFG->homeAddress; ?>explore.php?id="+node.nodeid+"&sid="+node.searchid;
		} else {
			exploreButton.href= "<?php echo $CFG->homeAddress; ?>explore.php?id="+node.nodeid;
		}
		connectionsubmenu.insert(exploreButton);

		var exploreButton = new Element("a", {'style':'margin-bottom:5px; display: block;'} );
		exploreButton.insert("<?php echo $LNG->PROJECTS_NAME; ?>");
		if (node.searchid && node.searchid != "") {
			exploreButton.href= "<?php echo $CFG->homeAddress; ?>explore.php?id="+node.nodeid+"&sid="+node.searchid;
		} else {
			exploreButton.href= "<?php echo $CFG->homeAddress; ?>explore.php?id="+node.nodeid;
		}
		connectionsubmenu.insert(exploreButton);

	} else if (EVIDENCE_TYPES_STR.indexOf(type) != -1) {
		if (hasSolution) {
			var exploreButton = new Element("a", {'style':'margin-bottom:5px; display: block;'} );
			exploreButton.insert("<?php echo $LNG->SOLUTIONS_NAME; ?>");
			if (node.searchid && node.searchid != "") {
				exploreButton.href= "<?php echo $CFG->homeAddress; ?>explore.php?id="+node.nodeid+"&sid="+node.searchid;
			} else {
				exploreButton.href= "<?php echo $CFG->homeAddress; ?>explore.php?id="+node.nodeid;
			}
			connectionsubmenu.appendChild(exploreButton);
		}
		if (hasClaim) {
			var exploreButton = new Element("a", {'style':'margin-bottom:5px; display: block;'} );
			exploreButton.insert("<?php echo $LNG->CLAIMS_NAME; ?>");
			if (node.searchid && node.searchid != "") {
				exploreButton.href= "explore.php?id="+node.nodeid+"&sid="+node.searchid;
			} else {
				exploreButton.href= "explore.php?id="+node.nodeid;
			}
			connectionsubmenu.appendChild(exploreButton);
		}
		var exploreButton = new Element("a", {'style':'margin-bottom:5px; display: block;'} );
		exploreButton.insert("<?php echo $LNG->RESOURCES_NAME; ?>");
		if (node.searchid && node.searchid != "") {
			exploreButton.href= "<?php echo $CFG->homeAddress; ?>knowledgetrees.php?id="+node.nodeid+"&sid="+node.searchid;
		} else {
			exploreButton.href= "<?php echo $CFG->homeAddress; ?>knowledgetrees.php?id="+node.nodeid;
		}
		connectionsubmenu.appendChild(exploreButton);

		var exploreButton = new Element("a", {'style':'margin-bottom:5px; display: block;'} );
		exploreButton.insert("<?php echo $LNG->ORGS_NAME; ?>");
		if (node.searchid && node.searchid != "") {
			exploreButton.href= "<?php echo $CFG->homeAddress; ?>explore.php?id="+node.nodeid+"&sid="+node.searchid;
		} else {
			exploreButton.href= "<?php echo $CFG->homeAddress; ?>explore.php?id="+node.nodeid;
		}
		connectionsubmenu.insert(exploreButton);

		var exploreButton = new Element("a", {'style':'margin-bottom:5px; display: block;'} );
		exploreButton.insert("<?php echo $LNG->PROJECTS_NAME; ?>");
		if (node.searchid && node.searchid != "") {
			exploreButton.href= "<?php echo $CFG->homeAddress; ?>explore.php?id="+node.nodeid+"&sid="+node.searchid;
		} else {
			exploreButton.href= "<?php echo $CFG->homeAddress; ?>explore.php?id="+node.nodeid;
		}
		connectionsubmenu.insert(exploreButton);

	} else if (RESOURCE_TYPES_STR.indexOf(type) != -1) {
		var exploreButton = new Element("a", {'style':'margin-bottom:5px; display: block;'} );
		exploreButton.insert("<?php echo $LNG->EVIDENCES_NAME; ?>");
		if (node.searchid && node.searchid != "") {
			exploreButton.href= "<?php echo $CFG->homeAddress; ?>explore.php?id="+node.nodeid+"&sid="+node.searchid;
		} else {
			exploreButton.href= "<?php echo $CFG->homeAddress; ?>explore.php?id="+node.nodeid;
		}
		connectionsubmenu.appendChild(exploreButton);

		var exploreButton = new Element("a", {'style':'margin-bottom:5px; display: block;'} );
		exploreButton.insert("<?php echo $LNG->ORGS_NAME; ?>");
		if (node.searchid && node.searchid != "") {
			exploreButton.href= "<?php echo $CFG->homeAddress; ?>explore.php?id="+node.nodeid+"&sid="+node.searchid;
		} else {
			exploreButton.href= "<?php echo $CFG->homeAddress; ?>explore.php?id="+node.nodeid;
		}
		connectionsubmenu.insert(exploreButton);

		var exploreButton = new Element("a", {'style':'margin-bottom:5px; display: block;'} );
		exploreButton.insert("<?php echo $LNG->PROJECTS_NAME; ?>");
		if (node.searchid && node.searchid != "") {
			exploreButton.href= "<?php echo $CFG->homeAddress; ?>explore.php?id="+node.nodeid+"&sid="+node.searchid;
		} else {
			exploreButton.href= "<?php echo $CFG->homeAddress; ?>explore.php?id="+node.nodeid;
		}
		connectionsubmenu.insert(exploreButton);

	} else if (type == "Organization" || type == "Project") {
		var exploreButton = new Element("a", {'style':'margin-bottom:5px; display: block;'} );
		exploreButton.insert("<?php echo $LNG->EXPLORE_PARTNERS; ?>");
		if (node.searchid && node.searchid != "") {
			exploreButton.href= "<?php echo $CFG->homeAddress; ?>explore.php?id="+node.nodeid+"&sid="+node.searchid;
		} else {
			exploreButton.href= "<?php echo $CFG->homeAddress; ?>explore.php?id="+node.nodeid;
		}
		connectionsubmenu.insert(exploreButton);

		var exploreButton = new Element("a", {'style':'margin-bottom:5px; display: block;'} );
		if (type == "Organization") {
			exploreButton.insert("<?php echo $LNG->EXPLORE_PROJECTS_MANAGED; ?>");
		} else {
			exploreButton.insert("<?php echo $LNG->EXPLORE_MANAGING_ORGS; ?>");
		}
		if (node.searchid && node.searchid != "") {
			exploreButton.href= "<?php echo $CFG->homeAddress; ?>explore.php?id="+node.nodeid+"&sid="+node.searchid;
		} else {
			exploreButton.href= "<?php echo $CFG->homeAddress; ?>explore.php?id="+node.nodeid;
		}
		connectionsubmenu.insert(exploreButton);

		if (hasChallenge) {
			var exploreButton = new Element("a", {'style':'margin-bottom:5px; display: block;'} );
			exploreButton.insert("<?php echo $LNG->CHALLENGES_NAME; ?>");
			if (node.searchid && node.searchid != "") {
				exploreButton.href= "<?php echo $CFG->homeAddress; ?>explore.php?id="+node.nodeid+"&sid="+node.searchid;
			} else {
				exploreButton.href= "<?php echo $CFG->homeAddress; ?>explore.php?id="+node.nodeid;
			}
			connectionsubmenu.insert(exploreButton);
		}
		var exploreButton = new Element("a", {'style':'margin-bottom:5px; display: block;'} );
		exploreButton.insert("<?php echo $LNG->ISSUES_NAME; ?>");
		if (node.searchid && node.searchid != "") {
			exploreButton.href= "<?php echo $CFG->homeAddress; ?>explore.php?id="+node.nodeid+"&sid="+node.searchid;
		} else {
			exploreButton.href= "<?php echo $CFG->homeAddress; ?>explore.php?id="+node.nodeid;
		}
		connectionsubmenu.insert(exploreButton);
		if (hasSolution) {
			var exploreButton = new Element("a", {'style':'margin-bottom:5px; display: block;'} );
			exploreButton.insert("<?php echo $LNG->SOLUTIONS_NAME; ?>");
			if (node.searchid && node.searchid != "") {
				exploreButton.href= "<?php echo $CFG->homeAddress; ?>explore.php?id="+node.nodeid+"&sid="+node.searchid;
			} else {
				exploreButton.href= "<?php echo $CFG->homeAddress; ?>explore.php?id="+node.nodeid;
			}
			connectionsubmenu.insert(exploreButton);
		}
		if (hasClaim) {
			var exploreButton = new Element("a", {'style':'margin-bottom:5px; display: block;'} );
			exploreButton.insert("<?php echo $LNG->CLAIMS_NAME; ?>");
			if (node.searchid && node.searchid != "") {
				exploreButton.href= "<?php echo $CFG->homeAddress; ?>explore.php?id="+node.nodeid+"&sid="+node.searchid;
			} else {
				exploreButton.href= "<?php echo $CFG->homeAddress; ?>explore.php?id="+node.nodeid;
			}
			connectionsubmenu.insert(exploreButton);
		}

		var exploreButton = new Element("a", {'style':'margin-bottom:5px; display: block;'} );
		exploreButton.insert("<?php echo $LNG->EVIDENCES_NAME; ?>");
		if (node.searchid && node.searchid != "") {
			exploreButton.href= "<?php echo $CFG->homeAddress; ?>explore.php?id="+node.nodeid+"&sid="+node.searchid;
		} else {
			exploreButton.href= "<?php echo $CFG->homeAddress; ?>explore.php?id="+node.nodeid;
		}
		connectionsubmenu.insert(exploreButton);

		var exploreButton = new Element("a", {'style':'margin-bottom:5px; display: block;'} );
		exploreButton.insert("<?php echo $LNG->RESOURCES_NAME; ?>");
		if (node.searchid && node.searchid != "") {
			exploreButton.href= "<?php echo $CFG->homeAddress; ?>explore.php?id="+node.nodeid+"&sid="+node.searchid;
		} else {
			exploreButton.href= "<?php echo $CFG->homeAddress; ?>explore.php?id="+node.nodeid;
		}
		connectionsubmenu.insert(exploreButton);

	}

	return connectionsubmenu;
}



function closeSubmenus(uniQ) {
	if ($('connectionsubmenu'+uniQ)) {
		$('connectionsubmenu'+uniQ).style.display = 'none';
	}
	if ($('exploresubmenu'+uniQ)) {
		$('exploresubmenu'+uniQ).style.display = 'none';
	}
}



/*****************/
/** FOR DEBATES **/
/*****************/

/**
 * Render the given node.
 * @param width the width of the node box (e.g. 200px or 20%)
 * @param height the height of the node box (e.g. 200px or 20%)
 * @param node the node object do render
 * @param uniQ is a unique id element prepended to the nodeid to form an overall unique id within the currently visible site elements
 * @param role the role object for this node. Defaults to the node role.
 * @param includeUser whether to include the user image and link. Defaults to true.
 * @param type defaults to 'active', but can be 'inactive' so nothing is clickable.
 * 			or a specialized type for some of the popups
 * @param includeconnectedness should the connectedness count be included - defaults to false.
 * @param includevoting should the voting buttons be included - defaults to true.
 * @param cropdesc whether to crop the description text.
 * @param mainheading whether or not the title is a main heading instead of a link.
 * @param includestats whether or not to include the stats list below this Debate.
 */
function renderIssueNode(width, height, node, uniQ, role, includeUser, type, includeconnectedness, includevoting, cropdesc, mainheading, includestats){

	var iDiv = new Element("div", {'class':'mainnodewrapper'});

	let key = "Node"+node.nodeid;
	let thistype = 'issue';
	let color = 'issueback';

	var creationdate = node.creationdate;
	var positivevotes = node.positivevotes;
	var negativevotes = node.negativevotes;
	var userimage = node.users[0].thumb;
	var nodeid = node.nodeid;
	var name = node.name;
	var nodetype = node.role.name;
	var title=getNodeTitleAntecedence(nodetype);

	var username = node.users[0].name;
	var userid = node.users[0].userid;
	var userfollow = node.userfollow;
	var otheruserconnections = node.otheruserconnections;
	var icon = URL_ROOT+node.role.image;

	var widgetDiv = new Element("div", {'class':'widgetdivnode', 'id':key+'div'});
	var widgetBody = new Element("div", {'class':'widgetnodebody', 'id':key+'body'});
	var widgetHeader = new Element("div", {'id':key+'header', 'class':'widgetheadernode'});
	widgetDiv.insert(widgetHeader);

	var widgetHeaderLabel = new Element("label", {'class':'linearnodeheaderlabel', 'id':'widgetheaderlabel'});
	widgetHeaderLabel.insert("<i>"+title+"</i>"+name);

	let exploreheaderlabel = $('exploreheaderlabel');
	if (icon) {
		var iconObj = new Element('img',{'style':'text-align: middle;margin-right: 5px; width:24px; ', 'alt':type+' <?php echo $LNG->WIDGET_ICON_ALT; ?>', 'src':icon});
		iconObj.align='left';
		exploreheaderlabel.appendChild(iconObj);
	}

	exploreheaderlabel.appendChild(widgetHeaderLabel);

	var toolbar = new Element("div", {'class':'nodewidgettoolbar', 'style':'margin-bottom:5px;'});
	buildExploreToolbar(toolbar, title+name, thistype, node, 'debate');
	widgetHeader.insert(toolbar);

	var spacer = new Element("hr", {'class':'widgetnodespacer'});
	widgetBody.appendChild(spacer);

	var innerwidgetBody = new Element("div", {'id':key+'innerbody', 'class':'widgetnodeinnerbody'});

	var userbar = new Element("div", {'class':'debate-user'} );
	var detailbar = new Element("div", {'class':'issue-details'} );
	detailbar.insert("<h2>"+title+name+"</h2>");
	innerwidgetBody.insert(detailbar);

	var iuDiv = new Element("div", {'class':'idea-user2'});
	var userimageThumb = new Element('img',{'alt':username, 'title': username, 'style':'padding-right:5px;','src': userimage});

	var imagelink = new Element('a', {'href':URL_ROOT+"user.php?userid="+userid, 'title':username});

	imagelink.insert(userimageThumb);
	iuDiv.update(imagelink);
	detailbar.appendChild(iuDiv);

	var iuDiv = new Element("div", {'class':'issue-user-details'});
	var cDate = new Date(creationdate*1000);
	iuDiv.insert('<p class="debate-info"><strong><?php echo $LNG->NODE_ADDED_ON; ?></strong><span>'+ cDate.format(DATE_FORMAT) + '</span></p>');
	iuDiv.insert('<p class="debate-info"><strong><?php echo $LNG->NODE_ADDED_BY; ?></strong><span>'+username+'</span></p>');

	if (node.imageurlid && node.imageurlid != "") {
		var iuDiv = new Element("div", {'style':'float:left'});
		var nodeimage = new Element("img", {'id':key+'nodeimg', 'src':node.imageurlid});
		iuDiv.insert(nodeimage);
		iuDiv.insert(iuDiv);
	}

	if (node.startdatetime && node.startdatetime != "" && node.role.name == 'Project') {
		var sDate = new Date(node.startdatetime*1000);
		iuDiv.insert('<p class="debate-info"><strong><?php echo $LNG->FORM_LABEL_PROJECT_STARTED_DATE; ?></strong><span>'+sDate.format(DATE_FORMAT_PROJECT)+'</span></p>');
		if (node.enddatetime && node.enddatetime != "") {
			var eDate = new Date(node.enddatetime*1000);
			iuDiv.insert('<p class="debate-info"><strong><?php echo $LNG->FORM_LABEL_PROJECT_ENDED_DATE; ?></strong><span>'+eDate.format(DATE_FORMAT_PROJECT)+'</span></p>');
		}
	}

	if (node.identifier && node.identifier != "" && node.role.name == 'Publication') {
		iuDiv.insert('<p class="debate-info"><strong><?php echo $LNG->FORM_LABEL_DOI; ?></strong><span>'+node.identifier+'</span></p>');
	}
	if (node.locationaddress1 && node.locationaddress1 != "") {
		iuDiv.insert('<span style="float:left;font-weight:bold;width:83px;"><?php echo $LNG->FORM_LABEL_ADDRESS1; ?> </span><span>'+node.locationaddress1+'</span><br />');
	}
	if (node.locationaddress2 && node.locationaddress2 != "") {
		iuDiv.insert('<span style="float:left;font-weight:bold;width:83px;"><?php echo $LNG->FORM_LABEL_ADDRESS2; ?> </span><span>'+node.locationaddress2+'</span><br />');
	}
	if (node.location && node.location != "") {
		iuDiv.insert('<span style="float:left;font-weight:bold;width:83px;"><?php echo $LNG->FORM_LABEL_TOWN; ?> </span><span>'+node.location+'</span><br />');
	}
	if (node.locationpostcode && node.locationpostcode != "") {
		iuDiv.insert('<span style="float:left;font-weight:bold;width:83px;"><?php echo $LNG->FORM_LABEL_POSTAL_CODE; ?> </span><span>'+node.locationpostcode+'</span><br />');
	}
	if (node.country && node.country != "") {
		iuDiv.insert('<span style="float:left;font-weight:bold;width:83px;"><?php echo $LNG->FORM_LABEL_COUNTRY; ?> </span><span>'+node.country+'</span><br/>');
	}

	//tags
	if(node.tags && node.tags.length > 0){
		var grpStr = "<p class='debate-info'><strong><?php echo $LNG->NODE_TAGS_HEADING; ?> </strong>";
		for (var i=0 ; i <  node.tags.length; i++){
			var tag = null;
			if (node.tags[i].name) {
				tag = node.tags[i];
			} else {
				tag = node.tags[i].tag
			}
			grpStr += '<a href="'+URL_ROOT+'search.php?q='+tag.name+'&fromid='+node.nodeid+'&scope=all&tagsonly=true">'+tag.name+'</a>';
			if (i < node.tags.length-1) {
				grpStr += ',';
			}
		}

		grpStr += '</p>';
		iuDiv.insert(grpStr);
	}

	if (thistype != 'web' && thistype != "theme") {
		var commentdiv = new Element("div", { 'id':'commentdiv', 'name':'commentdiv', 'class':'commentdiv d-block'});
		iuDiv.insert(commentdiv);
		childcommentload(commentdiv, node.nodeid,"<?php echo $CFG->LINK_COMMENT_BUILT_FROM; ?>", COMMENT_TYPES+",Idea", 'commentchild', '');
	}

	if (node.description && node.description != "" && thistype != 'web') {
		var dStr = '<div class="debate-info debate-desc"><strong><?php echo $LNG->NODE_DESC_HEADING; ?> </strong><span>';
		dStr += node.description;
		dStr += '</span></div><div style="clear:both;"></div>';
		iuDiv.insert(dStr);
	}

	detailbar.insert(iuDiv);
	innerwidgetBody.appendChild(detailbar);
	widgetBody.insert(innerwidgetBody);
	widgetDiv.insert(widgetBody);

	iDiv.insert(widgetDiv);

	return iDiv;
}

/**
 * Render a list of nodes
 */
function displayIdeaList(objDiv,nodes,start,includeUser,uniqueid,type,status){

	if (includeUser == undefined) {
		includeUser = true;
	}
	if (type == undefined) {
		type = 'active';
	}
	if (uniqueid == undefined) {
		uniqueid = 'idea-list';
	}
	if (status == undefined) {
		status = <?php echo $CFG->STATUS_ACTIVE; ?>;
	}

	var myuniqueid = "";
	var lOL = new Element("ol", {'start':start, 'class':'idea-list-ol'});
	for(var i=0; i < nodes.length; i++){
		var node = nodes[i].cnode;
		if(node){
			myuniqueid = uniqueid+i+start;
			var connection = node.connection;
			if (connection) {
				myuniqueid = node.nodeid + connection.connid+myuniqueid;
			} else {
				myuniqueid = node.nodeid + myuniqueid;
			}

			var iUL = new Element("li", {'id':node.nodeid, 'class':'idea-list-li'});
			lOL.insert(iUL);
			var blobDiv = new Element("div", {'id':'ideablobdiv'+myuniqueid, 'class':'idea-blob-list'});


			try {
				var blobNode = renderIdeaList(node, myuniqueid, node.role[0].role,includeUser,type,status, i);
				blobDiv.insert(blobNode);
				iUL.insert(blobDiv);
			}
			catch(err) {
			  	console.log(err);
			}

		}
	}

	objDiv.insert(lOL);
}

/**
 * Render the given node from an associated idea connection.
 * @param node the node object do render
 * @param uniQ is a unique id element prepended to the nodeid to form an overall unique id within the currently visible site elements
 * @param role the role object for this node
 * @param includeUser whether to include the user image and link
 * @param type defaults to 'active', but can be 'inactive' so nothing is clickable
 * 			or a specialized type for some of the popups
 * @param status, active nodes or retired nodes. (active = 0, spam = 1, retired = 2.
 */
function renderIdeaList(node, uniQ, role, includeUser, type, status, i){

	if (i === undefined) {
	i = -1;
	}

	if (type === undefined) {
		type = "active";
	}

	if(role === undefined){
		role = node.role[0].role;
	}

	if (status == undefined) {
		status = <?php echo $CFG->STATUS_ACTIVE; ?>;
	}

	var nodeuser = null;
	// JSON structure different if coming from popup where json_encode used.
	if (node.users[0].userid) {
		nodeuser = node.users[0];
	} else {
		nodeuser = node.users[0].user;
	}
	var user = null;
	var connection = node.connection;
	if (connection) {
		user = connection.users[0].user;
	}

	var breakout = "";

	//needs to check if embedded as a snippet
	if(top.location != self.location){
		breakout = " target='_blank'";
	}

	var focalrole = "";
	if (connection) {
		var fN = connection.from[0].cnode;
		var tN = connection.to[0].cnode;
		if (node.nodeid == fN.nodeid) {
			focalrole = tN.role[0].role;
		} else {
			focalrole = fN.role[0].role;
		}
	}

	var itDiv = new Element("div", {'class':'idea-title boxshadowsquaredarker'});

	var nodeTable = new Element('table');
	nodeTable.className = "toConnectionsTable table";
	itDiv.insert(nodeTable);

	var row = nodeTable.insertRow(-1);
	row.setAttribute('name','idearowitem');
	row.setAttribute('id','idearowitem'+uniQ);
	row.setAttribute('uniQ',uniQ);
	row.setAttribute('nodeid',node.nodeid);

	if (node.nodeid == NODE_ARGS['selectednodeid']) {
		//alert("hightlighting!!");
		//row.className = "selectedback";
		var options = new Array();
		options['startcolor'] = '#FAFB7D';
		options['endcolor'] = '#FDFDE3';
		options['restorecolor'] = 'transparent';
		options['duration'] = 5;
		highlightElement(row, options);
	} else {
		row.className = "transparent";
	}
	//row.style.borderBottom = "3px solid #4E725F";

	//update stats
	if (node.parentid) {
		if (connection) {
			var votestats = $('debatestatsvotes'+node.parentid);
			if (votestats) {
				votestats.votes[node.nodeid] = parseInt(parseInt(connection.positivevotes)+parseInt(connection.negativevotes));
			}
		}
	}

	if (includeUser == true) {
		var userCell = row.insertCell(-1);
		userCell.setAttribute('style','width:40px;');
		userCell.setAttribute('style','max-width:40px;');
		userCell.vAlign="top";
		userCell.align="left";
		userCell.width="40";
		if (connection) {
			var cDate = new Date(connection.creationdate*1000);
			var dStr = "<?php echo $LNG->NODE_ADDED_BY; ?> "+nodeuser.name+ " on "+cDate.format(DATE_FORMAT)
			userCell.title = dStr;
		}

		// Add right side with user image and date below
		var iuDiv = new Element("div", {
			'id':'editformuserdividea'+uniQ,
			'class':'idea-user2',
			'style':'float:left;'
		});

		var userimageThumb = new Element('img',{'alt':nodeuser.name, 'style':'padding-left:5px;padding-top:5px;', 'src': nodeuser.thumb});
		if (type == "active") {
			var imagelink = new Element('a', {
				'href':URL_ROOT+"user.php?userid="+nodeuser.userid
				});
			if (breakout != "") {
				imagelink.target = "_blank";
			}
			imagelink.insert(userimageThumb);
			iuDiv.update(imagelink);
		} else {
			iuDiv.insert(userimageThumb)
		}

		userCell.insert(iuDiv);
	}

	var textCell = row.insertCell(-1);
	//textCell.setAttribute('style','width:85%');
	textCell.vAlign="top";
	textCell.align="left";
	textCell.setAttribute('width','95%');

	var textDiv = new Element("div", {
		'id':'textdividea'+uniQ,
		'class':'textdividea'
	});
	textCell.insert(textDiv);

	var title = node.name;

	var textspan = new Element("a", {
		'id':'desctoggle'+uniQ,
		'class':'idearowtitle debatetext',
		'href': URL_ROOT+"explore.php?id="+node.nodeid,
		'title':'<?php echo $LNG->NODE_DETAIL_BUTTON_HINT; ?>',
	});

	textspan.insert(title);
	textspan.datadisabled = false;
	textDiv.insert(textspan);
	/*
	Event.observe(textspan,'click',function (){
		if (textspan.datadisabled == false) {
			ideatoggle('arguments'+uniQ, uniQ, node.nodeid, 'arguments', role.name);
		}
	});
	*/

	if (USER == nodeuser.userid && type == 'active') {
		var editbutton = new Element("img", {
			'class':'imagebuttonfaded',
			'src':'<?php echo $HUB_FLM->getImagePath("edit.png"); ?>',
			'title':'<?php echo $LNG->NODE_EDIT_SOLUTION_ICON_HINT; ?>',
		});
		textDiv.insert(editbutton);
		Event.observe(editbutton,'click',function (){
			editInline(uniQ, 'idea');
		});

		if (!node.otheruserconnections || node.otheruserconnections == 0) {
			var deletename = node.name;
			var del = new Element('img',{'class':'delete-solution','alt':'<?php echo $LNG->DELETE_BUTTON_ALT;?>', 'src': '<?php echo $HUB_FLM->getImagePath("delete.png"); ?>'});
			Event.observe(del,'click',function (){
				var callback = function () {
					refreshSolutions();
				}
				deleteNode(node.nodeid, deletename, role.name, callback);
			});
			textDiv.insert(del);
		} else {
			var del = new Element('img',{'class':'delete-solution', 'alt':'<?php echo $LNG->NO_DELETE_BUTTON_ALT;?>', 'title': '<?php echo $LNG->NO_DELETE_BUTTON_HINT;?>', 'src': '<?php echo $HUB_FLM->getImagePath("delete-off.png"); ?>'});
			textDiv.insert(del);
		}
	}

	if(node.description || node.hasdesc){
		var dStr = '<div class="idea-desc" id="desc'+uniQ+'div">';
		if (node.description && node.description != "") {
			dStr += node.description;
		}
		dStr += '</div>';
		textDiv.insert(dStr);
	}

	var argumentLink = new Element("span", {
		'name':'ideaargumentlink',
		'id':'ideaargumentlink'+uniQ,
		'class':'active ideaargumentlink',
		'style':'clear:both;float:left;display:block;;margin-top:7px;font-weight:bold;',
		'title':'<?php echo $LNG->IDEA_ARGUMENTS_HINT; ?>',
	});

	argumentLink.nodeid = node.nodeid;
	argumentLink.datadisabled = false;
	Event.observe(argumentLink,'click',function (){
		if (argumentLink.datadisabled == false) {
			ideatoggle('arguments'+uniQ, uniQ, node.nodeid, 'arguments', role.name);
		}
	});

	if (USER == '') {
		argumentLink.insert('<img src="<?php echo $HUB_FLM->getImagePath('add.png'); ?>" border="0" style="width:16px;height:16px;vertical-align:bottom;padding-right:3px;" alt="add" />');
	}

	argumentLink.insert('<?php echo $LNG->EVIDENCES_NAME; ?> (');
	var argumentCount = new Element("span", {
		'id':'ideaargumentcount'+node.nodeid,
	});

	//alert(node.childrencount);

	argumentCount.insert(node.childrencount);
	argumentLink.insert(argumentCount);
	argumentLink.insert(')');

	textDiv.insert(argumentLink);

	<?php if (!isset($USER->userid)) {
		?>
	if (USER == '') {
			var signinlink = new Element("a", {
				'href':'<?php echo $CFG->homeAddress."ui/pages/login.php?ref="; ?>'+NODE_ARGS["ref"],
				'title':'<?php echo $LNG->DEBATE_CONTRIBUTE_LINK_HINT; ?>',
				'class':'lightgreenbutton',
				'style':'float:left;margin-left:30px;;margin-top:2px;',
			});
			signinlink.insert('<?php echo $LNG->DEBATE_CONTRIBUTE_LINK_TEXT; ?>');
			textDiv.insert(signinlink);
		}
	<?php } ?>

	/** ADD THE EDIT FORM FOR THE IDEA **/
	if (USER == user.userid && type == 'active') {
		var editDiv = new Element("fieldset", {
			'name':'editformdividea',
			'id':'editformdividea'+uniQ,
			'class':'editformdividea',
			'style':'clear:both;float:left;display:none;'
		});

		var legend = new Element("legend", {});
		var legendtitle = new Element("h2", {'style':'margin-bottom:0px;',});
		legendtitle.insert('<?php echo $LNG->EXPLORE_EDITING_ARGUMENT_TITLE; ?>');
		legend.insert(legendtitle);
		editDiv.insert(legend);

		var editideaid = new Element("input", {
			'name':'editideaid',
			'id':'editideaid'+uniQ,
			'type':'hidden',
			'value':node.nodeid,
		});
		editDiv.insert(editideaid);
		var editnodetypeid = new Element("input", {
			'name':'editideanodetypeid',
			'id':'editideanodetypeid'+uniQ,
			'type':'hidden',
			'value':role.roleid,
		});
		editDiv.insert(editnodetypeid);

		var rowDiv1 = new Element("div", {
			'class':'mb-3 row',
		});
		editDiv.insert(rowDiv1);
		var editideaname = new Element("input", {
			'class':'form-control',
			'placeholder':'<?php echo $LNG->FORM_IDEA_LABEL_TITLE; ?>',
			'id':'editideaname'+uniQ,
			'name':'editideaname',
			'value':node.name,
		});
		rowDiv1.insert(editideaname);

		var rowDiv2 = new Element("div", {
			'class':'mb-3 row',
		});
		editDiv.insert(rowDiv2);
		var editideadesc = new Element("textarea", {
			'rows':'3',
			'class':'form-control',
			'placeholder':'<?php echo $LNG->FORM_IDEA_LABEL_DESC; ?>',
			'id':'editideadesc'+uniQ,
			'name':'editideadesc',
		});
		editideadesc.insert(node.description);
		rowDiv2.insert(editideadesc);

		var rowDiv4 = new Element("div", {
			'class':'mb-3 row',
			'id':'linksdivedit'+uniQ,
			'style':'margin-bottom:0px;padding-bottom:0px;'
		});
		rowDiv4.linkcount = 0;
		editDiv.insert(rowDiv4);

		var rowDiv3 = new Element("div", {
			'class':'mb-3 row',
		});
		editDiv.insert(rowDiv3);
		var editideasave = new Element("input", {
			'type':'button',
			'class':'submitright',
			'id':'editidea',
			'name':'editidea',
			'value':'<?php echo $LNG->FORM_BUTTON_SAVE; ?>',
		});
		Event.observe(editideasave,'click',function (){
			editIdeaNode(node, uniQ, 'idea', type, includeUser, status);
		});

		rowDiv3.insert(editideasave);
		var editideacancel = new Element("input", {
			'type':'button',
			'class':'submitright',
			'id':'cancelidea',
			'name':'editidea',
			'value':'<?php echo $LNG->FORM_BUTTON_CANCEL; ?>',
			'style':'margin-right:10px;',
		});
		Event.observe(editideacancel,'click',function (){
			cancelEditAction(uniQ, 'idea');
		});

		rowDiv3.insert(editideacancel);

		textCell.insert(editDiv);
	}

	/** PRO AND CON LISTS **/

	var kidsTable = new Element('table', {
		'name':'ideaforagainstdiv',
		'id':'ideaforagainstdiv'+uniQ,
		'nodeid':node.nodeid,
		'id':'arguments'+uniQ,
		'class':'ideaforagainsttable',
		'style':'display:none;'
	});
	itDiv.insert(kidsTable);
	//kidsTable.border = "1";

	var row = kidsTable.insertRow(-1);
	row.width="100%";

	var forCell = row.insertCell(-1);
	forCell.vAlign="top";
	forCell.align="left";

	var forHeading = new Element('h3');
	forHeading.style.marginBottom = "2px";
	forHeading.style.marginTop = "5px";
	forHeading.style.color = "green";
	forHeading.style.fontWeight = "normal";
	forHeading.insert('<?php echo $LNG->NODE_CHILDREN_EVIDENCE_PRO; ?> (');
	var forCount = new Element('span', {'id':'count-support'+uniQ});
	forCount.insert('0');
	forHeading.insert(forCount);
	forHeading.insert(')');
	forCell.insert(forHeading);

	var forKidsDiv = new Element('div', {'id':'supportkidsdiv'+uniQ, 'class':'supportkidsdiv'});
	forKidsDiv.style.borderTop = "1px solid #D8D8D8";
	forCell.insert(forKidsDiv);

	if (type == 'active' && USER != '') {
		var addProDiv = new Element("div", {
			'name':'addformdivpro',
			'id':'addformdivpro'+uniQ,
			'class':'addformdivpro'
		});
		addProDiv.insert('<h3><?php echo $LNG->DEBATE_ADD_EVIDENCE_PRO_HEADING; ?></h3>');

		var rowDiv0 = new Element("div", {
			'class':'mb-3 row',
		});
		addProDiv.insert(rowDiv0);

		var addpronevtype = new Element("select", {
			'class':'form-select',
			'id':'pronodetypename'+uniQ,
			'name':'pronodetypename'
		});
		rowDiv0.insert(addpronevtype);
		var addpronevtypeelement = null;
		<?php
			$count = 0;
			if (is_countable($CFG->EVIDENCE_TYPES)) {
				$count = count($CFG->EVIDENCE_TYPES);
			}
			for($i=0; $i < $count; $i++){
				$item = $CFG->EVIDENCE_TYPES[$i];
				$name = $LNG->EVIDENCE_TYPES[$i]; ?>
				addpronevtypeelement = new Element("option", {
					'value':'<?php echo $item; ?>',
				});
				addpronevtypeelement.insert("<?php echo $name; ?>");
				addpronevtype.insert(addpronevtypeelement);
		<?php } ?>

		var rowDiv1 = new Element("div", {
			'class':'mb-3 row',
		});
		addProDiv.insert(rowDiv1);

		var addproname = new Element("input", {
			'class':'form-control',
			'placeholder':'<?php echo $LNG->FORM_PRO_LABEL_TITLE; ?>',
			'id':'addproname'+uniQ,
			'name':'addproname',
			'value':'',
		});
		rowDiv1.insert(addproname);

		var rowDiv2 = new Element("div", {
			'class':'mb-3 row',
		});
		addProDiv.insert(rowDiv2);
		var addprodesc = new Element("textarea", {
			'rows':'3',
			'class':'form-control',
			'placeholder':'<?php echo $LNG->FORM_PRO_LABEL_DESC; ?>',
			'id':'addprodesc'+uniQ,
			'name':'addprodesc',
		});
		rowDiv2.insert(addprodesc);

		var rowDiv3 = new Element("div", {
			'id':'linksdivpro'+uniQ,
			'style':'margin-bottom:0px;padding-bottom:0px;'
		});
		rowDiv3.linkcount = 0;
		addProDiv.insert(rowDiv3);

		let rowDiv4 = new Element("div", {'id' : 'row4resourceareapro'+uniQ,  'class': 'formrowsm', 'style':'margin:0px;padding:0px;'});
		addProDiv.insert(rowDiv4);

		let resourcelabel = new Element("label", {'for':'resourceformlabelpro'+uniQ, 'style': 'font-weight:bold'});
		resourcelabel.insert("<?php echo $LNG->FORM_LABEL_RESOURCES; ?>");
		rowDiv4.insert(resourcelabel);

		let rowDiv5 = new Element("div", {
			'class':'mb-3 row',
		});
		addProDiv.insert(rowDiv5);

		let resourceform = new Element("div", {'id' : 'resourceformpro'+uniQ});
		resourceform.noResources = 1;
		rowDiv5.insert(resourceform);

		const newitem = getArgumentResource('resourceformpro'+uniQ, 'pro'+uniQ, 0);
		resourceform.insert(newitem);

		let rowDiv6 = new Element("div", {
			'class':'mb-3 row',
		});
		addProDiv.insert(rowDiv6);

		let addURL = new Element("a", {
			'class':'hgrinput',
			'href':'javascript:void(0)',
			'style':'margin-top:0px;padding-top:0px;'
		});
		addURL.insert("<?php echo $LNG->FORM_MORE_LINKS_BUTTONS; ?>");
		Event.observe(addURL,'click',function (){
			addArgumentResource('resourceformpro'+uniQ, 'pro'+uniQ);
		});
		rowDiv6.insert(addURL);

		let rowDiv7 = new Element("div", {
			'class':'mb-3 row',
		});
		addProDiv.insert(rowDiv7);
		var addprosave = new Element("input", {
			'type':'button',
			'class':'btn btn-primary',
			'id':'addprosave'+uniQ,
			'name':'addprosave',
			'value':"<?php echo $LNG->FORM_BUTTON_SUBMIT; ?>",
		});
		Event.observe(addprosave,'click',function (){
			// get type from selection in form
			const evtype = $('connodetypename'+uniQ).value;
			addArgumentNode(node, uniQ, 'pro', evtype, type, includeUser, status);
		});
		rowDiv7.insert(addprosave);

		forCell.insert(addProDiv);
	}

	var conCell = row.insertCell(-1);
	conCell.vAlign="top";
	conCell.align="left";

	var conHeading = new Element('h3');
	conHeading.style.marginBottom = "2px";
	conHeading.style.marginTop = "5px";
	conHeading.style.color = "red";
	conHeading.style.fontWeight = "normal";
	conHeading.insert('<?php echo $LNG->NODE_CHILDREN_EVIDENCE_CON; ?> (');
	var conCount = new Element('span', {'id':'count-counter'+uniQ});
	conCount.insert('0');
	conHeading.insert(conCount);
	conHeading.insert(')');
	conCell.insert(conHeading);

	var conKidsDiv = new Element('div', {'id':'counterkidsdiv'+uniQ, 'class':'counterkidsdiv'});
	conKidsDiv.style.borderTop = "1px solid #D8D8D8";
	conCell.insert(conKidsDiv);

	if (type == 'active' && USER) {

		var addConDiv = new Element("div", {
			'name':'addformdivcon',
			'id':'addformdivcon'+uniQ,
			'class':'addformdivcon'
		});
		addConDiv.insert('<h3><?php echo $LNG->DEBATE_ADD_EVIDENCE_CON_HEADING; ?></h3>');

		var rowDiv0 = new Element("div", {
			'class':'mb-3 row',
		});
		addConDiv.insert(rowDiv0);

		var addconevtype = new Element("select", {
			'class':'form-select',
			'id':'connodetypename'+uniQ,
			'name':'connodetypename'
		});
		rowDiv0.insert(addconevtype);
		var addconnevtypeelement = null;
		<?php
			$count = 0;
			if (is_countable($CFG->EVIDENCE_TYPES)) {
				$count = count($CFG->EVIDENCE_TYPES);
			}
			for($i=0; $i < $count; $i++){
				$item = $CFG->EVIDENCE_TYPES[$i];
				$name = $LNG->EVIDENCE_TYPES[$i]; ?>
				addconnevtypeelement = new Element("option", {
					'value':'<?php echo $item; ?>',
				});
				addconnevtypeelement.insert("<?php echo $name; ?>");
				addconevtype.insert(addconnevtypeelement);
		<?php } ?>

		var rowDiv1 = new Element("div", {
			'class':'mb-3 row',
		});
		addConDiv.insert(rowDiv1);

		var addconname = new Element("input", {
			'class':'form-control',
			'placeholder':'<?php echo $LNG->FORM_CON_LABEL_TITLE; ?>',
			'id':'addconname'+uniQ,
			'name':'addconname',
			'value':'',
		});
		rowDiv1.insert(addconname);

		var rowDiv2 = new Element("div", {
			'class':'mb-3 row',
		});
		addConDiv.insert(rowDiv2);
		var addcondesc = new Element("textarea", {
			'rows':'3',
			'class':'form-control',
			'placeholder':'<?php echo $LNG->FORM_CON_LABEL_DESC; ?>',
			'id':'addcondesc'+uniQ,
			'name':'addcondesc',
		});
		rowDiv2.insert(addcondesc);

		let rowDiv4 = new Element("div", {'id' : 'row4resourceareacon'+uniQ,  'class': 'formrowsm', 'style':'margin:0px;padding:0px;'});
		addConDiv.insert(rowDiv4);

		let resourcelabel = new Element("label", {'for':'resourceformlabelcon'+uniQ, 'style': 'font-weight:bold'});
		resourcelabel.insert("<?php echo $LNG->FORM_LABEL_RESOURCES; ?>");
		rowDiv4.insert(resourcelabel);

		let rowDiv5 = new Element("div", {
			'class':'mb-3 row',
		});
		addConDiv.insert(rowDiv5);

		let resourceform = new Element("div", {'id' : 'resourceformcon'+uniQ});
		resourceform.noResources = 1;
		rowDiv5.insert(resourceform);

		const newitem = getArgumentResource('resourceformcon'+uniQ, 'con'+uniQ, 0);
		resourceform.insert(newitem);

		let rowDiv6 = new Element("div", {
			'class':'mb-3 row',
		});
		addConDiv.insert(rowDiv6);

		let addURL = new Element("a", {
			'class':'hgrinput',
			'href':'javascript:void(0)',
			'style':'margin-top:0px;padding-top:0px;'
		});
		addURL.insert("<?php echo $LNG->FORM_MORE_LINKS_BUTTONS; ?>");
		Event.observe(addURL,'click',function (){
			//insertArgumentLink(uniQ, 'con');
			addArgumentResource('resourceformcon'+uniQ, 'con'+uniQ);
		});
		rowDiv6.insert(addURL);

		let rowDiv7 = new Element("div", {
			'class':'mb-3 row',
		});
		addConDiv.insert(rowDiv7);
		var addconsave = new Element("input", {
			'type':'button',
			'class':'btn btn-primary',
			'id':'addconsave'+uniQ,
			'name':'addconsave',
			'value':"<?php echo $LNG->FORM_BUTTON_SUBMIT; ?>",
		});
		Event.observe(addconsave,'click',function (){
			// get type from selection in form
			const evtype = $('connodetypename'+uniQ).value;

			addArgumentNode(node, uniQ, 'con', evtype, type, includeUser, status);
		});
		rowDiv7.insert(addconsave);

		conCell.insert(addConDiv);
	}

	votebarDiv = ""

	loadChildArguments(forKidsDiv, node.nodeid, '<?php echo $LNG->PROS_NAME; ?>', '<?php echo $CFG->LINK_EVIDENCE_SOLCLAIM_PRO; ?>', "Pro", node.parentid, uniQ, 'count-support', type, status, votebarDiv);
	loadChildArguments(conKidsDiv, node.nodeid, '<?php echo $LNG->CONS_NAME; ?>', '<?php echo $CFG->LINK_EVIDENCE_SOLCLAIM_CON; ?>', "Con", node.parentid, uniQ, 'count-counter', type, status, votebarDiv);

	return itDiv;
}

/**
 * load child list, if required as per parameters.
 */
function loadChildArguments(section, nodeid, title, linktype, nodetype, focalnodeid, uniQ, countArea, type, status, votebar){

	if (typeof section === "string") {
		section = $(section);
	}

	if (section.loaded == undefined) {
		section.loaded = 'false';
	}

	if (status == undefined) {
		status = <?php echo $CFG->STATUS_ACTIVE; ?>;
	}

    if(section.visible() && (!section.loaded || section.loaded == 'false')){

    	section.update(getLoading("<?php echo $LNG->LOADING_ITEMS; ?>"));

		var reqUrl = SERVICE_ROOT + "&method=getconnectionsbynode&style=long&sort=ASC&orderby=date&status="+status;
		reqUrl += "&filterlist="+encodeURIComponent(linktype)+"&filternodetypes="+nodetype+"&scope=all&start=0&max=-1&nodeid="+nodeid;

		//alert(reqUrl);

		new Ajax.Request(reqUrl, { method:'post',
			onSuccess: function(transport){
				var json = transport.responseText.evalJSON();
				if(json.error){
					alert(json.error[0].message);
					return;
				}
				var conns = json.connectionset[0].connections;
				section.update("");
				if ($('ideaargumentcount'+nodeid)) {
					$('ideaargumentcount'+nodeid).update(0);
				}
				if ($(countArea+uniQ)) {
					$(countArea+uniQ).update(0);
				}

				//alert(conns.length);

				var nodes = new Array();
				var otherend = "";
				var positivevotes = 0;
				var negativevotes = 0;

				if (conns.length > 0) {
					for(var i=0; i <  conns.length; i++){
						var c = conns[i].connection;

						var fN = c.from[0].cnode;
						var tN = c.to[0].cnode;

						var fnRole = c.fromrole[0].role;
						var tnRole = c.torole[0].role;

						if (fN.nodeid == NODE_ARGS['selectednodeid']) {
							otherend = tN.nodeid;
						}
						if (tN.nodeid == NODE_ARGS['selectednodeid']) {
							otherend = fN.nodeid;
						}

						if ((fnRole.name == nodetype || nodetype.indexOf(fnRole.name) != -1) && fN.nodeid != nodeid) {
							if (fN.name != "") {
								var next = c.from[0];
								next.cnode['parentid'] = nodeid;
								next.cnode['parentuniq'] = uniQ;
								next.cnode['connection'] = c;

								if (focalnodeid) {
									next.cnode['focalnodeid'] = focalnodeid;
								}
								nodes.push(next);
							}
						} else if ((tnRole.name == nodetype || nodetype.indexOf(tnRole.name) != -1) && tN.nodeid != nodeid) {
							if (tN.name != "") {
								var next = c.to[0];
								next.cnode['parentid'] = nodeid;
								next.cnode['parentuniq'] = uniQ;
								next.cnode['connection'] = c;

								if (focalnodeid) {
									next.cnode['focalnodeid'] = focalnodeid;
								}
								nodes.push(next);
							}
						}
					}
					section.loaded = 'true';
				}

				if ($(countArea+uniQ)) {
					$(countArea+uniQ).update(nodes.length);
				}

				var otherAmount = 0;
				if (nodetype == "Pro" && $('count-counter'+uniQ)) {
					otherAmount = parseInt($('count-counter'+uniQ).innerHTML);
				} else if ($('count-support'+uniQ)) {
					otherAmount = parseInt($('count-support'+uniQ).innerHTML);
				}

				if ($('ideaargumentcount'+nodeid)) {
					$('ideaargumentcount'+nodeid).update(otherAmount+nodes.length);
				}

				if (nodes.length > 0){
					displayArgumentNodes(section, nodes, parseInt(0), true, uniQ, type, status, nodetype);

					// for View auditing on toggle
					if ($('arguments'+uniQ)) {
						if (nodetype == "Con") {
							$('arguments'+uniQ).connodes = nodes;
						} else {
							$('arguments'+uniQ).pronodes = nodes;
						}
					}
				}

				if (otherend != "") {
					openSelectedItem(otherend, 'arguments');
				}
			}
		});
	}
}

/**
 * Render a list of Pro and Con nodes
 */
async function displayArgumentNodes(objDiv,nodes,start,includeUser,uniqueid, type, status, nodetype){

	if (includeUser == undefined) {
		includeUser = true;
	}
	if (type == undefined) {
		type = 'active';
	}
	if (uniqueid == undefined) {
		uniqueid = 'widget-list';
	}
	if (status == undefined) {
		status = <?php echo $CFG->STATUS_ACTIVE; ?>;
	}
	var myuniqueid = "";
	var lOL = new Element("ol", {'start':start, 'class':'idea-list-ol'});

	for(var i=0; i < nodes.length; i++){
		var node = nodes[i].cnode;
		//console.log(node);
		if(node){
			myuniqueid = uniqueid+i+start;
			var connection = node.connection;
			if (connection) {
				myuniqueid = node.nodeid + connection.connid+myuniqueid;
			} else {
				myuniqueid = node.nodeid + myuniqueid;
			}

			var iUL = new Element("li", {'id':nodes[i].cnode.nodeid, 'class':'idea-list-li'});

			if (nodes[i].cnode.nodeid == NODE_ARGS['selectednodeid']) {
				//row.className = "selectedback";
				var options = new Array();
				options['startcolor'] = '#FAFB7D';
				options['endcolor'] = '#FDFDE3';
				options['restorecolor'] = 'white';
				options['duration'] = 5;
				highlightElement(iUL, options);
			}

			lOL.insert(iUL);
			var blobDiv = new Element("div", {'id':'argumentblobdiv'+myuniqueid, 'class':'idea-blob-list argumentblobdiv'});
			var blobNode = await renderArgumentNode(nodes[i].cnode, myuniqueid, nodes[i].cnode.role[0].role, includeUser, type, status, nodetype);
			blobDiv.insert(blobNode);
			iUL.insert(blobDiv);
		}
	}
	objDiv.insert(lOL);
}

/**
 * Render the given node from an associated connection.
 * @param node the node object to render
 * @param uniQ is a unique id element prepended to the nodeid to form an overall unique id within the currently visible site elements
 * @param role the role object for this node
 * @param includeUser whether to include the user image and link
 * @param type defaults to 'active', but can be 'inactive' so nothing is clickable
 * 			or a specialized type for some of the popups
 */
async function renderArgumentNode(node, uniQ, role, includeUser, type, status, nodetype){

	if (type === undefined) {
		type = "active";
	}

	if(role === undefined){
		role = node.role[0].role;
	}

	if (status == undefined) {
		status = <?php echo $CFG->STATUS_ACTIVE; ?>;
	}

	var nodeuser = null;
	// JSON structure different if coming from popup where json_encode used.
	if (node.users[0].userid) {
		nodeuser = node.users[0];
	} else {
		nodeuser = node.users[0].user;
	}

	var user = null;
	var connection = node.connection;
	if (connection) {
		user = connection.users[0].user;
	}

	var breakout = "";

	//needs to check if embedded as a snippet
	if(top.location != self.location){
		breakout = " target='_blank'";
	}

	var focalrole = "";
	var otherend = "";
	if (connection) {
		var fN = connection.from[0].cnode;
		var tN = connection.to[0].cnode;
		if (node.nodeid == fN.nodeid) {
			focalrole = tN.role[0].role;
			otherend = tN;
		} else {
			focalrole = fN.role[0].role;
			otherend = fN;
		}
	}

	var nodeTable = new Element('table');
	nodeTable.className = "toConnectionsTable table";

	var row = nodeTable.insertRow(-1);
	row.setAttribute('name','argumentrowitem');
	row.setAttribute('id','argumentrowitem'+uniQ);
	row.setAttribute('uniQ',uniQ);
	row.setAttribute('nodeid',node.nodeid);
	row.setAttribute('parentid',node.parentid);

	var textCell = row.insertCell(-1);
	textCell.vAlign="top";
	textCell.align="left";

	var textDiv = new Element("div", {
		'id':'textdivargument'+uniQ,
		'class':'textdivargument'
	});
	textCell.insert(textDiv);

	var title = node.name;

	var textspan = new Element("a", {
		'id':'desctoggle'+uniQ,
		'class':'itemtext',
		'title':'<?php echo $LNG->NODE_DETAIL_BUTTON_HINT; ?>',
		'href': URL_ROOT+"explore.php?id="+node.nodeid,
	});
	textspan.insert(title);
	textDiv.insert(textspan);

	if (USER == nodeuser.userid && type == "active") {
		var editbutton = new Element("img", {

			'class':'imagebuttonfaded',
			'src':'<?php echo $HUB_FLM->getImagePath("edit.png"); ?>',
			'title':'<?php echo $LNG->NODE_EDIT_EVIDENCE_ICON_HINT; ?>',
		});
		textDiv.insert(editbutton);
		Event.observe(editbutton,'click',function (){
			editInline(uniQ, 'argument');
		});

		var deletename = node.name;
		var del = new Element('img',{'style':'cursor: pointer;padding-left:5px;','alt':'<?php echo $LNG->DELETE_BUTTON_ALT;?>', 'src': '<?php echo $HUB_FLM->getImagePath("delete.png"); ?>'});
		Event.observe(del,'click',function (){
			var callback = function () {
				if (nodetype == "Con") {
					$('counterkidsdiv'+node.parentuniq).loaded = 'false';
					loadChildArguments('counterkidsdiv'+node.parentuniq, node.parentid, '<?php echo $LNG->CONS_NAME; ?>', '<?php echo $CFG->LINK_CON_SOLUTION; ?>', 'Con', node.parentid, node.parentuniq, 'count-counter', type, status, $('votebardiv'+node.parentuniq));
					refreshStats();
				} else if (nodetype == 'Pro') {
					$('supportkidsdiv'+node.parentuniq).loaded = 'false';
					loadChildArguments('supportkidsdiv'+node.parentuniq, node.parentid, '<?php echo $LNG->PROS_NAME; ?>', '<?php echo $CFG->LINK_PRO_SOLUTION; ?>', 'Pro', node.parentid, node.parentuniq, 'count-support', type, status, $('votebardiv'+node.parentuniq));
					refreshStats();
				}
			}
			deleteNode(node.nodeid, deletename, role.name, callback);
		});
		textDiv.insert(del);
	}

	try {
	    const resourcenodes = await loadChildResources(node.nodeid, status);
	    //console.log(resourcenodes);
	    node.resourcenodes = resourcenodes;
	    //console.log(node.resourcenodes);
	} catch(err) {
		console.log(err);
  	}

	if (node.resourcenodes && node.resourcenodes.length > 0) {
		var menuButton = new Element('img',{'alt':'>', 'style':'margin-left:10px;width:16px;height:16px;','src': '<?php echo $HUB_FLM->getImagePath("nodetypes/Default/reference-32x32.png"); ?>'});
		textDiv.appendChild(menuButton);
		Event.observe(menuButton,'mouseout',function (event){
			hideBox('toolbardiv'+uniQ);
		});
		Event.observe(menuButton,'mouseover',function (event) {
			var position = getPosition(this);
			var panel = $('toolbardiv'+uniQ);
			var panelWidth = 200;

			var viewportHeight = getWindowHeight();
			var viewportWidth = getWindowWidth();

			var x = position.x;
			var y = position.y;

			if ( (x+panelWidth+30) > viewportWidth) {
				x = x-(panelWidth+30);
			} else {
				x = x+10;
			}

			x = x+30+getPageOffsetX();

			panel.style.left = x+"px";
			panel.style.top = y+"px";

			//console.log(panel)

			showBox('toolbardiv'+uniQ);
		});
		var toolbarDiv = new Element("div", {'id':'toolbardiv'+uniQ, 'class':'toolbarDiv', 'style':'left:-1px;top:-1px;clear:both;position:absolute;display:none;z-index:60;padding:5px;border:1px solid gray;background:white'} );
		Event.observe(toolbarDiv,'mouseout',function (event){
			hideBox('toolbardiv'+uniQ);
		});
		Event.observe(toolbarDiv,'mouseover',function (event){ showBox('toolbardiv'+uniQ); });
		textDiv.appendChild(toolbarDiv);

		for(var i=0; i < node.resourcenodes.length; i++){
			if(node.resourcenodes[i].urls
					&& node.resourcenodes[i].urls
					&& node.resourcenodes[i].urls.length > 0){

				const next = node.resourcenodes[i].urls[0];
				const url = next.url.url;

				let weblink = new Element("a", {'style':'clear:both;float:left;margin-bottom:6px;','target':'_blank'});
				weblink.href = url;
				let resourcetype = "<?php echo $CFG->RESOURCE_TYPES_DEFAULT; ?>";
				if (RESOURCE_TYPES.indexOf(node.resourcenodes[i].role[0].role.name)!= -1) {
					resourcetype = RESOURCE_TYPE_NAMES[RESOURCE_TYPES.indexOf(node.resourcenodes[i].role[0].role.name)]
				}
				weblink.insert(next.url.title+' ('+resourcetype+")");

				toolbarDiv.insert(weblink);
			}
		}
	}

	if(node.description || node.hasdesc){
		var dStr = '<div style="clear:both;margin:0px;padding:0px;margin-top:3px;;" class="idea-desc" id="desc'+uniQ+'div"><span style="margin-top: 5px;">';
		if (node.description && node.description != "") {
			dStr += node.description;
		}
		dStr += '</div>';
		textDiv.insert(dStr);
	}

	// VOTING

	if (includeUser == true) {
		var userCell = row.insertCell(-1);

		if (connection) {
			var cDate = new Date(connection.creationdate*1000);
			var dStr = "<?php echo $LNG->NODE_ADDED_BY; ?> "+user.name+ " on "+cDate.format(DATE_FORMAT)
			userCell.title = dStr;
		}

		// Add right side with user image and date below
		var iuDiv = new Element("div", {
			'id':'editformuserdivargument'+uniQ,
			'class':'idea-user2'
		});

		var userimageThumb = new Element('img',{'alt':nodeuser.name, 'src': nodeuser.thumb});
		if (type == "active") {
			var imagelink = new Element('a', {
				'href':URL_ROOT+"user.php?userid="+nodeuser.userid
				});
			if (breakout != "") {
				imagelink.target = "_blank";
			}
			imagelink.insert(userimageThumb);
			iuDiv.update(imagelink);
		} else {
			iuDiv.insert(userimageThumb)
		}

		userCell.insert(iuDiv);
	}

	var row2 = nodeTable.insertRow(-1);
	var editCell = row2.insertCell(-1);

	/** ADD THE EDIT FORM FOR THE ARGUMENT **/
	if (USER == user.userid && type == 'active') {

		var editDiv = new Element("div", {
			'class':'addformdivedit',
			'id':'editformdivargument'+uniQ,
			'style':'display:none'
		});
		editCell.insert(editDiv);

		var legendtitle = new Element("h2", {'style':'margin-bottom:10px;',});
		legendtitle.insert('<?php echo $LNG->EXPLORE_EDITING_ARGUMENT_TITLE; ?>');
		editDiv.insert(legendtitle);

		var editargumentid = new Element("input", {
			'name':'editargumentid',
			'id':'editargumentid'+uniQ,
			'type':'hidden',
			'value':node.nodeid,
		});
		editDiv.insert(editargumentid);
		var editargumentroleid = new Element("input", {
			'name':'editargumentnodetypeid',
			'id':'editargumentnodetypeid'+uniQ,
			'type':'hidden',
			'value':role.roleid,
		});
		editDiv.insert(editargumentroleid);

		var rowDiv1 = new Element("div", {
			'class':'mb-3 row',
			'style':'padding-top:0px;',
		});
		editDiv.insert(rowDiv1);
		var editargumentname = new Element("input", {
			'class':'hgrinput',
			'placeholder':'<?php echo $LNG->FORM_IDEA_LABEL_TITLE; ?>',
			'id':'editargumentname'+uniQ,
			'name':'editargumentname',
			'value':node.name,
		});
		rowDiv1.insert(editargumentname);

		var rowDiv2 = new Element("div", {
			'class':'mb-3 row',
		});
		editDiv.insert(rowDiv2);
		var editargumentdesc = new Element("textarea", {
			'rows':'3',
			'class':'hgrinput',
			'placeholder':'<?php echo $LNG->FORM_IDEA_LABEL_DESC; ?>',
			'id':'editargumentdesc'+uniQ,
			'name':'editargumentdesc',
		});
		editargumentdesc.insert(node.description);
		rowDiv2.insert(editargumentdesc);

		var rowDiv = new Element("div", {
			'class':'mb-3 row',
			'id':'linksdivedit'+uniQ,
			'style':'margin-bottom:0px;padding-bottom:0px;'
		});
		rowDiv.linkcount = 0;
		editDiv.insert(rowDiv);

		let resourcelabel = new Element("label", {'for':'resourceformlabelpro'+uniQ, 'style': 'font-weight:bold'});
		resourcelabel.insert('<?php echo $LNG->FORM_LABEL_RESOURCES; ?>');
		rowDiv.insert(resourcelabel);

		if (node.resourcenodes && node.resourcenodes.length > 0) {
			rowDiv.linkcount = node.resourcenodes.length-1;
			for(var i=0; i <  node.resourcenodes.length; i++){

				if(node.resourcenodes[i].urls
						&& node.resourcenodes[i].urls
						&& node.resourcenodes[i].urls.length > 0){

					rowDiv.noResources = 0;
					const newitem = getArgumentResource('linksdivedit'+uniQ, 'edit'+nodetype.toLowerCase()+uniQ, rowDiv.noResources, node.resourcenodes[i]);
					rowDiv.noResources ++;
					rowDiv.insert(newitem);
				}
			}
		} else {
			rowDiv.noResources = 0;
			const newitem = getArgumentResource('linksdivedit'+uniQ, 'edit'+nodetype.toLowerCase()+uniQ, rowDiv.noResources);
			rowDiv.noResources ++;
			rowDiv.insert(newitem);
		}

		var rowDiv5 = new Element("div", {
			'class':'mb-3 row',
		});
		editDiv.insert(rowDiv5);

		var addURL = new Element("a", {
			'class':'hgrinput',
			'href':'javascript:void(0)',
			'style':'margin-top:0px;padding-top:0px;;'
		});

		addURL.insert("<?php echo $LNG->FORM_MORE_LINKS_BUTTONS; ?>");
		Event.observe(addURL,'click',function (){
			addArgumentResource('linksdivedit'+uniQ, 'edit'+nodetype.toLowerCase()+uniQ);
			//insertArgumentLink(uniQ, 'edit');
		});
		rowDiv5.insert(addURL);

		var rowDiv6 = new Element("div", {
			'class':'mb-3 row',
		});
		editDiv.insert(rowDiv6);

		var editargumentsave = new Element("input", {
			'type':'button',
			'id':'editargument',
			'name':'editargument',
			'value':"<?php echo $LNG->FORM_BUTTON_SAVE; ?>",
		});
		Event.observe(editargumentsave,'click',function () {
			editArgumentNode(node, uniQ, 'argument', nodetype, type, includeUser, status);
		});
		rowDiv6.insert(editargumentsave);

		var editargumentcancel = new Element("input", {
			'type':'button',
			'id':'cancelargument',
			'name':'editargument',
			'value':"<?php echo $LNG->FORM_BUTTON_CANCEL; ?>",
			'style':'margin-top:10px;',
		});
		Event.observe(editargumentcancel,'click',function (){
			cancelEditAction(uniQ, 'argument');
		});

		rowDiv6.insert(editargumentcancel);
	}

	return nodeTable;
}


/**
 * Add another resource block
 */
function addArgumentResource(section, uniQ) {

	let noResources = 0;
	if ($(section).noResources) {
		noResources = $(section).noResources;
	} else {
		$(section).noResources = 0;
	}

	const newitem = getArgumentResource(section, uniQ, noResources);
	$(section).insert(newitem);

	noResources++;
	$(section).noResources = noResources;
}

function getArgumentResource(section, uniQ, noResources, node) {

	let uniQid = uniQ;
	if (node) {
		uniQid = node.nodeid+uniQ;
	}

	var newitem = '<div id="resourcefield'+uniQ+noResources+'" class="row p-4 border border-secondary mb-2">';

	if (node) {
	    newitem += '<input type="hidden" id="resourcenodeidsarray-'+uniQid+noResources+'" name="resourcenodeidsarray'+uniQ+'[]" value="'+node.nodeid+'" />';
	} else {
	    newitem += '<input type="hidden" id="resourcenodeidsarray-'+uniQid+noResources+'" name="resourcenodeidsarray'+uniQ+'[]" value="" />';
	}

	newitem += '<div class="row mb-3" id="typediv-'+uniQ+noResources+'">';
	newitem += '<select onchange="typeChangedArgumentResource(\''+uniQ+'\', \''+noResources+'\')" class="form-select" id="resource'+uniQid+noResources+'menu" name="resourcetypesarray'+uniQ+'[]">';

	let count = RESOURCE_TYPES.length;
	for(let i=0; i < count; i++){
		let item = RESOURCE_TYPES[i];
		if ( (node && item == node.role[0].role.name) || (!node && item == '<?php echo $CFG->RESOURCE_TYPES_DEFAULT; ?>') ) {
			newitem += '<option selected="true" value="'+item+'">'+RESOURCE_TYPE_NAMES[i]+'</option>';
		} else {
			newitem += '<option value="'+item+'">'+RESOURCE_TYPE_NAMES[i]+'</option>';
		}
	}
	newitem += '</select>';
	newitem += '</div>';

	newitem += '<div class="row mb-3" id="resourceurldiv-'+uniQid+noResources+'">';
	if (node) {
		newitem += '<input class="form-control" id="resourceurl-'+uniQid+noResources+'" name="resourceurlarray'+uniQ+'[]" value="'+node.name+'">';
	} else {
		newitem += '<input placeholder="https://" title="Resource URL" class="form-control" id="resourceurl-'+uniQid+noResources+'" name="resourceurlarray'+uniQ+'[]" value="">';
	}
	newitem += '</div>';

	newitem += '<div class="row mb-3">';
	if (node) {
		newitem += '<input placeholder="<?php echo $LNG->FORM_EVIDENCE_RESOURCE_TITLE; ?>" title="<?php echo $LNG->FORM_EVIDENCE_RESOURCE_TITLE; ?>" class="form-control" id="resourcetitle-'+uniQid+noResources+'" name="resourcetitlearray'+uniQ+'[]" value="'+node.description+'">';
	} else {
		newitem += '<input placeholder="<?php echo $LNG->FORM_EVIDENCE_RESOURCE_TITLE; ?>" title="<?php echo $LNG->FORM_EVIDENCE_RESOURCE_TITLE; ?>" class="form-control" id="resourcetitle-'+uniQid+noResources+'" name="resourcetitlearray'+uniQ+'[]" value="">';
	}
	newitem += '</div>';

	if (node && node.role[0].role.name == "Publication") {
		newitem += '<div class="row mb-3" id="identifierdiv-'+uniQ+noResources+'" style="display: block;">';
		newitem += '<input placeholder="<?php echo $LNG->FORM_EVIDENCE_RESOURCE_DOI; ?>" title="<?php echo $LNG->FORM_EVIDENCE_RESOURCE_DOI; ?>" class="form-control" id="identifier-'+uniQid+noResources+'" name="identifierarray'+uniQ+'[]" value="'+node.urls[0].url.identifier+'">';
		newitem += '</div>';
	} else {
		newitem += '<div class="row mb-3" id="identifierdiv-'+uniQ+noResources+'" style="display: none;">';
		newitem += '<input placeholder="<?php echo $LNG->FORM_EVIDENCE_RESOURCE_DOI; ?>" title="<?php echo $LNG->FORM_EVIDENCE_RESOURCE_DOI; ?>" class="form-control" id="identifier-'+uniQid+noResources+'" name="identifierarray'+uniQ+'[]" value="">';
		newitem += '</div>';
	}

	newitem += '<div class="d-inline-block text-end" id="resourcedescdiv-'+uniQid+noResources+'">';
	newitem += '<a id="resourceremovebutton-'+noResources+'" href="javascript:void(0)" onclick="javascript:removeArgumentResource(\''+section+'\', \''+uniQ+'\', \''+noResources+'\')" class="me-2"><?php echo $LNG->FORM_BUTTON_REMOVE; ?></a><br>';
	newitem += '</div>';

	newitem += '</div>';

	return newitem;
}

function typeChangedArgumentResource(uniQ, num) {

	var type = $('resource'+uniQ+num+'menu').value;
	if (type == "Publication") {
		$('identifierdiv-'+uniQ+num).style.display = "block";
	} else {
		$('identifierdiv-'+uniQ+num).style.display = "none";
	}
}


function removeArgumentResource(section, uniQ, i) {
	var answer = confirm("<?php echo $LNG->FORM_REMOVE_MULTI; ?>");
    if(answer){
		if ($(section) && $('resourcefield'+uniQ+i)) {
			console.log($(section).childElements());
		    if(	$(section).childElements().length > 0){
			    $('resourcefield'+uniQ+i).remove();
		    }
		}
    }
    return;
}


/**
 * load child list of resources, if required as per parameters.
 */
async function loadChildResources(nodeid, status){

	return new Promise( ( resolve, reject ) => {

		var reqUrl = SERVICE_ROOT + "&method=getconnectionsbynode&style=long&sort=ASC&orderby=date&status="+status;
		reqUrl += "&filterlist="+"<?php echo $CFG->LINK_RESOURCE_NODE; ?>"+"&filternodetypes="+RESOURCE_TYPES_STR+"&scope=all&start=0&max=-1&nodeid="+nodeid;

		//console.log(reqUrl);

		new Ajax.Request(reqUrl, { method:'post',
			onSuccess: function(transport){
				var json = transport.responseText.evalJSON();
				if(json.error){
					alert(json.error[0].message);
					reject(new Array());
				}
				var conns = json.connectionset[0].connections;
				//console.log(conns.length);

				var nodes = new Array();
				if (conns.length > 0) {
					for(var i=0; i < conns.length; i++){
						var c = conns[i].connection;

						var fN = c.from[0].cnode;
						var tN = c.to[0].cnode;

						if (fN.nodeid == nodeid) {
							tN.connid = c.connid;
							nodes.push(tN);
						}
						if (tN.nodeid == nodeid) {
							fN.connid = c.connid;
							nodes.push(fN);
						}
					}
				}

				resolve(nodes);
			},
			onFailure: function(response) {
				console.log(response);
			 	reject(new Array());
			}
		});
	});
}

function ideatoggle(section, uniQ, id, sect, rolename, focalnodeid) {

   if ($(section).style.display == 'block') {
   		$(section).style.display = 'none';
   } else if ($(section).style.display == 'none') {
   		$(section).style.display = 'block';
   }

	//Audit viewing of child lists only if opening area
	if ($(section).style.display == 'block') {
		if (sect == "arguments") {
			if ($(section).pronodes) {
				var nodes = $(section).pronodes;
				var count = nodes.length;
				var nodeids = "";
				for (var i=0; i < count; i++) {
					var node = nodes[i];
					if (i == 0) {
						nodeids = nodeids + node.cnode.nodeid;
					} else {
						nodeids = nodeids+","+node.cnode.nodeid;
					}
				}
				var reqUrl = SERVICE_ROOT + "&method=auditnodeviewmulti&nodeids="+nodeids+"&viewtype=list";
				new Ajax.Request(reqUrl, { method:'post',
					onSuccess: function(transport){
						var json = transport.responseText.evalJSON();
						if(json.error){
							alert(json.error[0].message);
						}
					}
				});
			}

			if ($(section).connodes) {
				var nodes = $(section).connodes;
				var count = nodes.length;
				var nodeids = "";
				for (var i=0; i < count;i++) {
					var node = nodes[i];
					if (i == 0) {
						nodeids = nodeids + node.cnode.nodeid;
					} else {
						nodeids = nodeids + ","+node.cnode.nodeid;
					}
				}
				var reqUrl = SERVICE_ROOT + "&method=auditnodeviewmulti&nodeids="+nodeids+"&viewtype=list";
				new Ajax.Request(reqUrl, { method:'post',
					onSuccess: function(transport){
						var json = transport.responseText.evalJSON();
						if(json.error){
							alert(json.error[0].message);
						}
					}
				});
			}
		}
	}

	if ($('idearowitem'+uniQ)) {
		if( ($('comments'+uniQ) && $('comments'+uniQ).style.display == 'none' && $('arguments'+uniQ).style.display == 'none') || (!$('comments'+uniQ) && $('arguments'+uniQ).style.display == 'none') ){
			$('idearowitem'+uniQ).style.background = "transparent";
		} else {
			$('idearowitem'+uniQ).style.background = "#E8E8E8";
   		}
   	}
}