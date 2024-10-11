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
?>

/**
 * Javascript functions for drawing a list of users
 */
function displayUsers(objDiv,users,start){

	var lOL = new Element("ol", {'class':'user-list-ol user-list-tab-view'});
	for(var i=0; i< users.length; i++){
		if(users[i].user){
			var iUL = new Element("li", {'id':users[i].user.userid, 'class':'user-list-li'});
			lOL.insert(iUL);
			var blobDiv = new Element("div", {'class':'user-blob'});
			var blobUser = renderUser(users[i].user);
			blobDiv.insert(blobUser);
			iUL.insert(blobDiv);
		}
	}
	objDiv.insert(lOL);
}

/**
 * Javascript functions for drawing list of users in a widget
 */
function displayWidgetUsers(objDiv,users,start){

	var lOL = new Element("ol", {'class':'user-list-ol user-dashboard-view'});
	for(var i=0; i< users.length; i++){
		if(users[i].user){
			var iUL = new Element("li", {'id':users[i].user.userid, 'class':'user-list-li'});
			lOL.insert(iUL);
			var blobDiv = new Element("div", {'class':'user-blob'});
			var blobUser = renderWidgetUser(users[i].user);
			blobDiv.insert(blobUser);
			iUL.insert(blobDiv);
		}
	}
	objDiv.insert(lOL);
}

/**
 * Javascript functions for drawing list of users on the chat page
 */
function displayChatUsers(objDiv,users,start){

	var lOL = new Element("ol", {'class':'user-list-ol chatUsers'});
	for(var i=0; i< users.length; i++){
		if(users[i].user){
			var iUL = new Element("li", {'id':users[i].user.userid, 'class':'user-list-li'});
			lOL.insert(iUL);
			var blobDiv = new Element("div", {'class':'user-blob'});
			var blobUser = renderChatUser(users[i].user);
			blobDiv.insert(blobUser);
			iUL.insert(blobDiv);
		}
	}
	objDiv.insert(lOL);
}

/**
 * Javascript functions for drawing a list of users in a report
 */
function displayReportUsers(objDiv,users,start){
	for(var i=0; i< users.length; i++){
		if(users[i].user){
			var iUL = new Element("span", {'id':users[i].user.userid, 'class':'idea-list-li'});
			objDiv.insert(iUL);
			var blobDiv = new Element("div", {'style':'margin: 2px; width: 650px'});
			var blobUser = renderReportUser(users[i].user);
			blobDiv.insert(blobUser);
			iUL.insert(blobDiv);
		}
	}
}


/**
 * Makes ajax call for the current user to follow a person with the userid of the given obj.
 */
function followUser(obj) {
	var reqUrl = SERVICE_ROOT + "&method=addfollowing&itemid="+obj.userid;
	new Ajax.Request(reqUrl, { method:'get',
		onSuccess: function(transport){
			var json = transport.responseText.evalJSON();
   			if(json.error) {
   				alert(json.error[0].message);
   				return;
   			} else {
				obj.setAttribute('src', '<?php echo $HUB_FLM->getImagePath("following.png"); ?>');
				obj.setAttribute('title', '<?php echo $LNG->USERS_UNFOLLOW; ?>');
				Event.stopObserving(obj, 'click');
				Event.observe(obj,'click', function (){ unfollowUser(this) } );
   			}
   		}
  	});
}

/**
 * Makes ajax call for the current user to unfollow a person with the userid of the given obj.
 */
function unfollowUser(obj) {
	var reqUrl = SERVICE_ROOT + "&method=deletefollowing&itemid="+obj.userid;
	new Ajax.Request(reqUrl, { method:'get',
		onSuccess: function(transport){
			var json = transport.responseText.evalJSON();
   			if(json.error) {
   				alert(json.error[0].message);
   				return;
   			} else {
				obj.setAttribute('src', '<?php echo $HUB_FLM->getImagePath("follow.png"); ?>');
				obj.setAttribute('title', '<?php echo $LNG->USERS_FOLLOW; ?>');
				Event.stopObserving(obj, 'click');
				Event.observe(obj,'click', function (){ followUser(this) } );
   			}
   		}
  	});
}


/**
 *  Makes ajax call to follow the given userid. Called from user home page follow list.
 */
function followMyUser(userid) {
	var reqUrl = SERVICE_ROOT + "&method=addfollowing&itemid="+userid;
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
 * Makes ajax call to unfollow the given userid. Called from user home page follow list.
 */
function unfollowMyUser(userid) {
	var reqUrl = SERVICE_ROOT + "&method=deletefollowing&itemid="+userid;
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
 * Send a spam alert to the server.
 */
function reportUserSpamAlert(obj, user) {
	var ans = confirm("Are you sure you want to report \n\n"+obj.label+"\n\nas a Spammer / Inappropriate?\n\n");
	if (ans){
		var reqUrl = URL_ROOT + "spamalert.php?type=user&id="+obj.id;
		new Ajax.Request(reqUrl, { method:'get',
			onError: function(error) {
			},
			onSuccess: function(transport){
				obj.setAttribute('alt', "<?php echo $LNG->SPAM_USER_REPORTED_ALT; ?>");
				obj.setAttribute('title', "<?php echo $LNG->SPAM_USER_REPORTED; ?>");
				obj.setAttribute('src', "<?php echo $HUB_FLM->getImagePath('spam-reported.png'); ?>");
				obj.style.cursor = 'auto';
				$(obj).unbind("click");
				user.status = 1;
			}
		});
	}
}

/**
 * Draw a single user item in a list.
 */
function renderUser(user){

	var uDiv = new Element("div", {"id":'context', "class": "row"});
	var cI = new Element('div', {'id':'contextimage'});

	// fake white invisible border to make IE draw the name properly at top of image area not lower down.
	var imgDiv = new Element("div",{'class':'renderUser col-auto'});

	if(user.isgroup == 'Y'){
		cI.insert("<div><a href='group.php?groupid="+ user.userid +"'><img src='"+user.photo+"'/></a></div>");
	} else {
		if (user.searchid && user.searchid != "") {
			cI.insert("<div><a href='user.php?userid="+ user.userid +"&sid="+user.searchid+"'><img src='"+user.photo+"' alt='profile image for "+ user.name +"' /></a></div>");
		} else {
			cI.insert("<div><a href='user.php?userid="+ user.userid +"'><img src='"+user.photo+"' alt='profile image for "+ user.name +"' /></a></div>");
		}
	}

	imgDiv.insert(cI);

	// Add spam icon
	var spamDiv = new Element("div");
	var spamimg = document.createElement('img');
	if(USER != ""){
		if (user.status == <?php echo $CFG->USER_STATUS_REPORTED; ?>) {
			spamimg.setAttribute('alt', "<?php echo $LNG->SPAM_USER_REPORTED_ALT; ?>");
			spamimg.setAttribute('title', "<?php echo $LNG->SPAM_USER_REPORTED; ?>");
			spamimg.setAttribute('src', '<?php echo $HUB_FLM->getImagePath("spam-reported.png"); ?>');
		} else if (user.status == <?php echo $CFG->USER_STATUS_ACTIVE; ?>) {
			spamimg.setAttribute('alt', "<?php echo $LNG->SPAM_USER_REPORT_ALT; ?>");
			spamimg.setAttribute('title', "<?php echo $LNG->SPAM_USER_REPORT; ?>");
			spamimg.setAttribute('src', '<?php echo $HUB_FLM->getImagePath("spam.png"); ?>');
			spamimg.id = user.userid;
			spamimg.label = user.name;
			Event.observe(spamimg,'click',function (){ reportUserSpamAlert(this, user) } );
		}
	} else {
		spamimg.setAttribute('alt', "<?php echo $LNG->SPAM_USER_LOGIN_REPORT_ALT; ?>");
		spamimg.setAttribute('title', "<?php echo $LNG->SPAM_USER_LOGIN_REPORT; ?>");
		spamimg.setAttribute('src', '<?php echo $HUB_FLM->getImagePath("spam-disabled.png"); ?>');
	}
	spamDiv.insert(spamimg);
	cI.insert(spamDiv);

	uDiv.insert(imgDiv);

	var uiDiv = new Element("div",{id:'contextinfo', "class":"col contextinfo"});
	uDiv.insert(uiDiv);

	if(user.isgroup == 'N'){
		var statusImg = document.createElement('img');
		statusImg.setAttribute('alt', 'Offline');
		statusImg.setAttribute('title', "<?php echo $LNG->USERS_PRESENCE_OFF; ?>");
		statusImg.setAttribute('src', URL_ROOT+'images/red-light.png');
		uiDiv.insert(statusImg);
		if (user.lastactive && user.lastactive > 0) {
			var cDate = new Date(user.lastactive*1000);
			var now = new Date();
			if ( (now.getTime() - cDate.getTime()) < (20*60*1000) ) { // 20 minutes ago
				statusImg.setAttribute('alt', 'Online');
				statusImg.setAttribute('title', "<?php echo $LNG->USERS_PRESENCE_ON; ?>");
				statusImg.setAttribute('src', URL_ROOT+'images/green-light.png');
			}
		}
	}

	if(user.isgroup == 'Y'){
		uiDiv.insert("<b><a href='group.php?groupid="+ user.userid +"'>" + user.name + "</a></b>");
	} else {
		if (user.searchid && user.searchid != "") {
			uiDiv.insert("<b><a href='user.php?userid="+ user.userid +"&sid="+user.searchid+"'>" + user.name + "</a></b>");
		} else {
			uiDiv.insert("<b><a href='user.php?userid="+ user.userid +"'>" + user.name + "</a></b>");
		}
	}

	if(USER != ""){
		var followDiv = new Element("div");
		var followbutton = document.createElement('img');
		followbutton.setAttribute('src', '<?php echo $HUB_FLM->getImagePath("follow.png"); ?>');
		followbutton.setAttribute('alt', "<?php echo $LNG->USERS_FOLLOW_ICON_ALT; ?>");
		followbutton.setAttribute('id','follow'+user.userid);
		followbutton.userid = user.userid;
		followDiv.insert(followbutton);
		if (user.userfollow && user.userfollow == "Y") {
			Event.observe(followbutton,'click',function (){ unfollowUser(this) } );
			followbutton.setAttribute('src', '<?php echo $HUB_FLM->getImagePath("following.png"); ?>');
			followbutton.setAttribute('title', "<?php echo $LNG->USERS_UNFOLLOW; ?>");
		} else {
			Event.observe(followbutton,'click',function (){ followUser(this) } );
			followbutton.setAttribute('src', '<?php echo $HUB_FLM->getImagePath("follow.png"); ?>');
			followbutton.setAttribute('title', "<?php echo $LNG->USERS_FOLLOW; ?>");
		}
		uiDiv.insert(followDiv);
	}

	var str = "<div>";
	if (user.creationdate && user.creationdate > 0) {
		var cDate = new Date(user.creationdate*1000);
		str += "<span class=\"user-date-joined\"><b><?php echo $LNG->USERS_DATE_JOINED; ?> </b>"+cDate.format(DATE_FORMAT)+"</span>";
	} else {
		var cDate = new Date(user.creationdate*1000);
		str += "<span class=\"user-date-joined\"><b><?php echo $LNG->USERS_DATE_JOINED; ?> </b>"+cDate.format(DATE_FORMAT)+"</span>";
	}

	if (user.lastactive && user.lastactive > 0) {
		var cDate = new Date(user.lastactive*1000);
		str += "<span class=\"user-last-active\"><b><?php echo $LNG->USERS_LAST_ACTIVE; ?> </b>"+cDate.format(TIME_FORMAT)+"</span>";
	} else {
		var cDate = new Date(user.lastlogin*1000);
		str += "<span class=\"user-last-login\"><b><?php echo $LNG->USERS_LAST_LOGIN; ?> </b>"+cDate.format(TIME_FORMAT)+"</span>";
	}

	uiDiv.insert(str+"</div>");

	if(user.description != ""){
		uiDiv.insert("<div>"+user.description+"</div>");
	}
	if(user.website != ""){
        uiDiv.insert("<div><a href='"+user.website+"' target='_blank'>"+user.website+"</a></div>");
    }
	if(user.tags && user.tags.length > 0) {
		var tagsStr = "<div><b><?php echo $LNG->USERS_PROFILE_TAGS; ?> </b>";
		for (var i=0 ; i< user.tags.length; i++){
			if (i > 0) {
				tagsStr += ", ";
			}
			tagsStr += user.tags[i].tag.name;
		}
		tagsStr += "</div>";
		uiDiv.insert(tagsStr);
	}

	uDiv.insert(uiDiv);
	return uDiv;

}

/**
 * Draw a single user entry in a widget list.
 */
function renderWidgetUser(user){

	var uDiv = new Element("div",{id:'context'});
	var imgDiv = new Element("div", {"class":"idea-user-image-wrap row"});
	var cI = new Element("div", {'class':'idea-user2 col-auto'});
	if(user.isgroup == 'Y'){
		cI.insert("<a href='group.php?groupid="+ user.userid +"'><img border='0' src='"+user.thumb+"' alt='profile image for "+user.name+"'/></a>");
	} else {
		cI.insert("<a href='user.php?userid="+ user.userid +"'><img border='0' src='"+user.thumb+"' alt='profile image for "+user.name+"'/></a>")
	}

	imgDiv.insert(cI);

	var uiDiv = new Element("div", {"class":"idea-user-wrap col"});
	if(user.isgroup == 'Y'){
		uiDiv.insert("<b><a href='group.php?groupid="+ user.userid +"'>" + user.name + "</a></b>");
	} else {
		uiDiv.insert("<b><a href='user.php?userid="+ user.userid +"'>" + user.name + "</a></b>");
	}
	if (user.followdate){
		var cDate = new Date(user.followdate*1000);
		uiDiv.insert("<br><b><?php echo $LNG->USERS_STARTED_FOLLOWING_ON; ?> </b>"+ cDate.format(DATE_FORMAT));
	}

	imgDiv.insert(uiDiv);
	uDiv.insert(imgDiv);

	uDiv.insert("<div style='clear:both'></div>");
	return uDiv;
}

/**
 * Draw a single user entry on a widget page.
 */
function renderChatUser(user){

	var uDiv = new Element("div",{id:'context', 'class':'chatUserList'});
	var imgDiv = new Element("div", {'class':'row'});
	var cI = new Element("div", {'class':'idea-user2 col-auto'});
	if(user.isgroup == 'Y'){
		cI.insert("<a href='group.php?groupid="+ user.userid +"'><img border='0' src='"+user.thumb+"' alt='profile image for "+user.name+"'/></a>");
	} else {
		cI.insert("<a href='user.php?userid="+ user.userid +"'><img border='0' src='"+user.thumb+"' alt='profile image for "+user.name+"'/></a>")
	}

	imgDiv.insert(cI);

	var uiDiv = new Element("div", {'class':'chatUserInfo col-auto'});
	if(user.isgroup == 'Y'){
		uiDiv.insert("<b><a href='group.php?groupid="+ user.userid +"'>" + user.name + "</a></b>");
	} else {
		uiDiv.insert("<b><a href='user.php?userid="+ user.userid +"'>" + user.name + "</a></b>");
	}
	if (user.chatlogtime){
		var cDate = new Date(user.chatlogtime*1000);
		uiDiv.insert("<br><b><?php echo $LNG->CHAT_USER_ENTRY_DATE; ?> </b>"+ cDate.format(TIME_FORMAT));
	}

	imgDiv.insert(uiDiv);
	uDiv.insert(imgDiv);

	uDiv.insert("<div style='clear:both'></div>");
	return uDiv;
}

/**
 * Draw a single user entry in a report list.
 */
function renderReportUser(user){

	var uDiv = new Element("div",{id:'context'});
	var imgDiv = new Element("div", {'style':'clear:both;float:left'});

	var uiDiv = new Element("div", {'style':'float:left;'});
	uiDiv.insert("<div style='float:left;width:600px;'>"+user.name+"</div>");

	imgDiv.insert(uiDiv);
	uDiv.insert(imgDiv);

	uDiv.insert("<div style='clear:both'></div>");
	return uDiv;
}
