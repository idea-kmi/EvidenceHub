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

    $countries = getCountryList();
	$ns = getNodesByGlobal(0,1,'date','DESC', 'News', '', 'short');
	$news = $ns->nodes;

	$CFG->HAS_NEWS = false;
	if (count($news) > 0) {
		$CFG->HAS_NEWS = true;
	}
?>
var COOKIE_NAME = 'evidencehubmainviz';

//this list the tabs
var TABS = {"home":true,<?php if ($CFG->HAS_CHALLENGE) { echo '"challenge":true, '; } ?> "social":true, "org":true,"project":true,<?php if ( $CFG->issuesManaged == false ) { echo '"issue":true, '; } ?><?php if ($CFG->HAS_SOLUTION) { echo '"solution":true, '; } ?>"evidence":true, "web":true, <?php if ($CFG->HAS_CLAIM) { echo '"claim":true,'; } ?>"user":true <?php if ($CFG->HAS_OPEN_COMMENTS) { echo ',"comment":true'; } ?><?php if ($CFG->HAS_NEWS) { echo ',"news":true'; } ?> };

var VIZ = {"overview":true,"list":true};
var USERVIZ = {"overview":true,"list":true, "usergmap":true, "nodegmap":true, "net":true};
var ORGVIZ = {"overview":true, "list":true, "gmap":true};
var COMMENTVIZ = {"list":true};
var NEWSVIZ = {"list":true};

var DEFAULT_TAB = 'home';
var DEFAULT_VIZ = 'list';

var CURRENT_VIZ = DEFAULT_VIZ;
var CURRENT_TAB = DEFAULT_TAB;

var DATA_LOADED = {"home":false, "org":false, "project":false, "projectoverview":false, "orgoverview":false, "challenge":false, "challengeoverview":false, "issue":false, "issueoverview":false, "solution":false, "solutionoverview":false, "claim":false, "claimoverview":false, "evidence":false, "evidenceoverview":false, "url":false, "urloverview":false, "user":false, "useroverview":false, "orgsimile":false,"issuesimile":false,"claimsimile":false,"evidencesimile":false,"orggmap":false,"projectgmap":false,"issuegmap":false,"claimgmap":false,"evidencegmap":false,"usergmap":false,"nodegmap":false, "commentlist":false, "newslist":false};

var NEGATIVE_LINKGROUP_NAME = "Negative";
var POSITIVE_LINKGROUP_NAME = "Positive";
var NEUTRAL_LINKGROUP_NAME = "Neutral";

//define events for clicking on the tabs
var stpHomeOverview = setTabPushed.bindAsEventListener($('tab-home-list-obj'),'home-overview');
var stpHomeList = setTabPushed.bindAsEventListener($('tab-home-list-obj'),'home-list');
var stpHomeNet = setTabPushed.bindAsEventListener($('tab-home-list-obj'),'home-net');

<?php if ($CFG->HAS_CHALLENGE) { ?>
	var stpChallengeList = setTabPushed.bindAsEventListener($('tab-challenge-list-obj'),'challenge-list');
	var stpChallengeNet = setTabPushed.bindAsEventListener($('tab-challenge-list-obj'),'challenge-net');
	var stpChallengeOverview = setTabPushed.bindAsEventListener($('tab-challenge-list-obj'),'challenge-overview');
<?php } ?>

var stpOrgList = setTabPushed.bindAsEventListener($('tab-org-list-obj'),'org-list');
var stpOrgGMap = setTabPushed.bindAsEventListener($('tab-org-list-obj'),'org-gmap');
var stpOrgNet = setTabPushed.bindAsEventListener($('tab-org-list-obj'),'org-net');
var stpOrgOverview = setTabPushed.bindAsEventListener($('tab-org-list-obj'),'org-overview');

var stpProjectList = setTabPushed.bindAsEventListener($('tab-project-list-obj'),'project-list');
var stpProjectGMap = setTabPushed.bindAsEventListener($('tab-project-list-obj'),'project-gmap');
var stpProjectNet = setTabPushed.bindAsEventListener($('tab-project-list-obj'),'project-net');
var stpProjectOverview = setTabPushed.bindAsEventListener($('tab-project-list-obj'),'project-overview');

<?php if ( $CFG->issuesManaged == false ) { ?>
	var stpIssueList = setTabPushed.bindAsEventListener($('tab-issue-list-obj'),'issue-list');
	var stpIssueGMap = setTabPushed.bindAsEventListener($('tab-issue-list-obj'),'issue-gmap');
	var stpIssueNet = setTabPushed.bindAsEventListener($('tab-issue-list-obj'),'issue-net');
	var stpIssueOverview = setTabPushed.bindAsEventListener($('tab-issue-list-obj'),'issue-overview');
<?php } ?>

<?php if ($CFG->HAS_SOLUTION) { ?>
	var stpSolutionList = setTabPushed.bindAsEventListener($('tab-solution-list-obj'),'solution-list');
	var stpSolutionGMap = setTabPushed.bindAsEventListener($('tab-solution-list-obj'),'solution-gmap');
	var stpSolutionNet = setTabPushed.bindAsEventListener($('tab-solution-list-obj'),'solution-net');
	var stpSolutionOverview = setTabPushed.bindAsEventListener($('tab-solution-list-obj'),'solution-overview');
<?php } ?>
<?php if ($CFG->HAS_CLAIM) { ?>
	var stpClaimList = setTabPushed.bindAsEventListener($('tab-claim-list-obj'),'claim-list');
	var stpClaimGMap = setTabPushed.bindAsEventListener($('tab-claim-list-obj'),'claim-gmap');
	var stpClaimNet = setTabPushed.bindAsEventListener($('tab-claim-list-obj'),'claim-net');
	var stpClaimOverview = setTabPushed.bindAsEventListener($('tab-claim-list-obj'),'claim-overview');
<?php } ?>

var stpEvidenceList = setTabPushed.bindAsEventListener($('tab-evidence-list-obj'),'evidence-list');
var stpEvidenceGMap = setTabPushed.bindAsEventListener($('tab-evidence-list-obj'),'evidence-gmap');
var stpEvidenceNet = setTabPushed.bindAsEventListener($('tab-evidence-list-obj'),'evidence-net');
var stpEvidenceOverview = setTabPushed.bindAsEventListener($('tab-evidence-list-obj'),'evidence-overview');

var stpWebList = setTabPushed.bindAsEventListener($('tab-web-list-obj'),'web-list');
var stpWebNet = setTabPushed.bindAsEventListener($('tab-web-list-obj'),'web-net');
var stpWebOverview = setTabPushed.bindAsEventListener($('tab-web-list-obj'),'web-overview');

var stpUserList = setTabPushed.bindAsEventListener($('tab-user-list-obj'),'user-list');
var stpUserGMap = setTabPushed.bindAsEventListener($('tab-user-list-obj'),'user-usergmap');
var stpUserOverview = setTabPushed.bindAsEventListener($('tab-user-list-obj'),'user-overview');
var stpUserNet = setTabPushed.bindAsEventListener($('tab-user-list-obj'),'user-net');
var stpUserNodeGMap = setTabPushed.bindAsEventListener($('tab-user-list-obj'),'user-nodegmap');

<?php if ($CFG->HAS_OPEN_COMMENTS) { ?>
	var stpCommentList = setTabPushed.bindAsEventListener($('tab-comment-list-obj'),'comment-list');
<?php } ?>

<?php if ($CFG->HAS_NEWS) { ?>
	var stpNewsList = setTabPushed.bindAsEventListener($('tab-news-list-obj'),'news-list');
<?php } ?>

/**
 *	set which tab to show and load first
 */
Event.observe(window, 'load', function() {

	// add events for clicking on the main tabs
	Event.observe('tab-home','click', stpHomeList);

	<?php if ( $CFG->issuesManaged == false ) { ?>
		Event.observe('tab-issue','click', stpIssueOverview);
	<?php } ?>

	Event.observe('tab-evidence','click', stpEvidenceOverview);
	Event.observe('tab-web','click', stpWebOverview);

	if (hasChallenge && $("tab-challenge")) {
		Event.observe('tab-challenge','click', stpChallengeOverview);
	}
	if (hasSolution) {
		Event.observe('tab-solution','click', stpSolutionOverview);
	}
	if (hasClaim) {
		Event.observe('tab-claim','click', stpClaimOverview);
	}
	if ($("tab-user")) {
		Event.observe('tab-user','click', stpUserOverview);
	}

	<?php if ($CFG->HAS_OPEN_COMMENTS) { ?>
	if ($("tab-comment")) {
		Event.observe('tab-comment','click', stpCommentList);
	}
	<?php } ?>

	<?php if ($CFG->HAS_NEWS) { ?>
	if ($("tab-news")) {
		Event.observe('tab-news','click', stpNewsList);
	}
	<?php } ?>

	if ($("tab-org")) {
		Event.observe('tab-org','click', stpOrgOverview);
	}
	if ($("tab-project")) {
		Event.observe('tab-project','click', stpProjectOverview);
	}

	// add events for clicking on the viz tabs
	if (hasChallenge && $("tab-challenge")) {
		Event.observe('tab-challenge-list','click', stpChallengeList);
		Event.observe('tab-challenge-overview','click', stpChallengeOverview);
		//Event.observe('tab-challenge-net','click', stpChallengeNet);
	}

	Event.observe('tab-org-overview','click', stpOrgOverview);
	Event.observe('tab-org-list','click', stpOrgList);
	//Event.observe('tab-org-net','click', stpOrgNet);
	Event.observe('tab-org-gmap','click', stpOrgGMap);

	Event.observe('tab-project-overview','click', stpProjectOverview);
	Event.observe('tab-project-list','click', stpProjectList);
	//Event.observe('tab-project-net','click', stpProjectNet);
	Event.observe('tab-project-gmap','click', stpProjectGMap);

	<?php if ( $CFG->issuesManaged == false ) { ?>
		Event.observe('tab-issue-overview','click', stpIssueOverview);
		Event.observe('tab-issue-list','click', stpIssueList);
		//Event.observe('tab-issue-net','click', stpIssueNet);
	<?php } ?>

	if (hasSolution) {
		Event.observe('tab-solution-overview','click', stpSolutionOverview);
		Event.observe('tab-solution-list','click', stpSolutionList);
		//Event.observe('tab-solution-net','click', stpSolutionNet);
	}

	if (hasClaim) {
		Event.observe('tab-claim-overview','click', stpClaimOverview);
		Event.observe('tab-claim-list','click', stpClaimList);
		//Event.observe('tab-claim-net','click', stpClaimNet);
	}

	Event.observe('tab-evidence-overview','click', stpEvidenceOverview);
	Event.observe('tab-evidence-list','click', stpEvidenceList);
	//Event.observe('tab-evidence-net','click', stpEvidenceNet);

	Event.observe('tab-web-overview','click', stpWebOverview);
	Event.observe('tab-web-list','click', stpWebList);
	//Event.observe('tab-web-net','click', stpWebNet);

	if ($("tab-user-overview")) {
		Event.observe('tab-user-overview','click', stpUserOverview);
	}
	if ($("tab-user-list")) {
		Event.observe('tab-user-list','click', stpUserList);
	}
	if ($("tab-user-usergmap")) {
		Event.observe('tab-user-usergmap','click', stpUserGMap);
	}
	if ($("tab-user-nodegmap")) {
		Event.observe('tab-user-nodegmap','click', stpUserNodeGMap);
	}
	if ($("tab-user-net")) {
		Event.observe('tab-user-net','click', stpUserNet);
	}

	<?php if ($CFG->HAS_OPEN_COMMENTS) { ?>
	if ($("tab-comment-list")) {
		Event.observe('tab-comment-list','click', stpCommentList);
	}
	<?php } ?>

	<?php if ($CFG->HAS_NEWS) { ?>
	if ($("tab-news-list")) {
		Event.observe('tab-news-list','click', stpNewsList);
	}
	<?php } ?>

	<?php if ($CFG->hasSocialTab) { ?>
		// create the social menu
		var socialsubmenu = new Element("div", {'id':'socialsubmenu', 'style':'z-index:100; left:-1px;top:-1px;clear:both;position:absolute;display:none;padding:5px;width:140px;border:1px solid gray;background:white'} );
		var posme = getPosition($("tab-social-li"));
		var x=posme.x;
		var y=posme.y+23;
		socialsubmenu.style.left = x+"px";
		socialsubmenu.style.top = y+"px";

		var orgtab = new Element('span',{'class':'active', 'style':'margin-bottom:3px;clear:both;float:left;'});
		orgtab.insert("<?php echo $LNG->TAB_ORG; ?>");
		Event.observe(orgtab,'click',function (){
			hideBox('socialsubmenu');
			setTabPushed($('tab-org-list-obj'), 'org-overview');
		});
		socialsubmenu.insert(orgtab);

		var projecttab = new Element('span',{'class':'active', 'style':'margin-bottom:3px;clear:both;float:left;'});
		projecttab.insert("<?php echo $LNG->TAB_PROJECT; ?>");
		Event.observe(projecttab,'click',function (){
			hideBox('socialsubmenu');
			setTabPushed($('tab-project-list-obj'), 'project-overview');
		});
		socialsubmenu.insert(projecttab);

		var usertab = new Element('span',{'class':'active', 'style':'margin-bottom:3px;clear:both;float:left;'});
		usertab.insert("<?php echo $LNG->TAB_USER; ?>");
		Event.observe(usertab,'click',function (){
			hideBox('socialsubmenu');
			setTabPushed($('tab-user-list-obj'), 'user-overview');
		});
		socialsubmenu.insert(usertab);

		Event.observe(socialsubmenu,'mouseout',function (event){
			hideBox('socialsubmenu');
		});
		Event.observe(socialsubmenu,'mouseover',function (event){
			showBox('socialsubmenu');
		});

		$("tab-social-li").appendChild(socialsubmenu);

		Event.observe($("socialmenuarrow"),'mouseover',function (event){
			showBox('socialsubmenu');
		});
		Event.observe($("socialmenuarrow"),'mouseout',function (event){
			hideBox('socialsubmenu');
		});
	<?php } ?>

	//var viz = getViz("");
	//setTabPushed($('tab-'+getAnchorVal(DEFAULT_TAB + "-" + viz)),getAnchorVal(DEFAULT_TAB + "-" + viz));

	setTabPushed($('tab-'+getAnchorVal(DEFAULT_TAB + "-" + DEFAULT_VIZ)),getAnchorVal(DEFAULT_TAB + "-" + DEFAULT_VIZ));
});

/**
 * Return the viz and store in cookie
 */
function getViz(viz) {

	//alert("BEFORE:"+viz);

	if (viz == "" ||
		(viz != 'list' && viz != "overview" && viz != "net" && viz != "usergmap" && viz != "gmap")) {
		viz = DEFAULT_VIZ;

		var allcookies = document.cookie;
		if (allcookies != null) {
			var cookiearray  = allcookies.split(';');

			for(var i=0; i < cookiearray.length; i++){
				var param = cookiearray[i].split('=')
				var name = param[0];
			    var value = param[1];
				if (name.trim() == COOKIE_NAME) {
					//alert("COOKIE:"+value);
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
		}
	}

	//alert("AFTER:"+viz);

	return viz;
}

/**
 *	switch between tabs
 */
function setTabPushed(e) {

	var data = $A(arguments);
	var tabID = data[1];

	// Social Sign On bug - returns strange #_=_ when calling index page
	if (tabID == '_=_') {
		tabID = 'home-overview';
		window.location.hash = tabID;
		if (typeof window.history.replaceState == 'function') {
			window.history.replaceState("string", "Title", "#home-overview");
		}
	}

	// get tab and the visualisation from the #
	var parts = tabID.split("-");
	var tab = parts[0];
	var viz="";
	if (parts.length > 1) {
		viz = parts[1];
	}
	var page=1;
	if (parts.length > 2) {
		page = parseInt(parts[2]);
	}

	//viz = getViz(viz);

	// Check tab is know else default to default
	if (!TABS.hasOwnProperty(tab)) {
		tab = DEFAULT_TAB;
		viz = DEFAULT_VIZ;
	}

	var i="";

	var temptab = tab;
	<?php if ($CFG->hasSocialTab) { ?>
		if (tab == "org" || tab == "project" || tab == "user") {
			temptab = "social";
		}
	<?php } ?>

	for (i in TABS){
		if(temptab == i){
			if($("tab-"+i)) {
				$("tab-"+i).removeClassName("unselected");
				$("tab-"+i).addClassName("current");
			}
		} else {
			if($("tab-"+i)) {
				$("tab-"+i).removeClassName("current");
				$("tab-"+i).addClassName("unselected");
			}
		}

		if(tab == i){
			if ($("tab-content-"+i+"-div")) {
				$("tab-content-"+i+"-div").show();
			}
		} else {
			if ($("tab-content-"+i+"-div")) {
				$("tab-content-"+i+"-div").hide();
			}
		}
	}

	if (tab == 'issue' || tab == 'solution' || tab == 'claim' || (tab == 'challenge' && hasChallenge)
		|| tab == 'evidence' || tab == 'web') {
		for (i in VIZ){
			if(viz == i){
				$("tab-"+tab+"-"+i).removeClassName("unselected");
				$("tab-"+tab+"-"+i).addClassName("current");
				$("tab-content-"+tab+"-"+i).show();
			} else {
				$("tab-"+tab+"-"+i).removeClassName("current");
				$("tab-"+tab+"-"+i).addClassName("unselected");
				$("tab-content-"+tab+"-"+i).hide();
			}
		}
	} else if (tab == 'org' || tab == 'project') {
		<?php if ($CFG->hasSocialTab) { ?>
			if (tab == 'project') {
				$('tab-social-text').innerHTML = "<?php echo $LNG->TAB_SOCIAL; ?>-<?php echo $LNG->TAB_PROJECT; ?>";
				$('tab-social').setAttribute("href","#project-overview");
			} else {
				$('tab-social-text').innerHTML = "<?php echo $LNG->TAB_SOCIAL; ?>-<?php echo $LNG->TAB_ORG; ?>";
				$('tab-social').setAttribute("href","#org-overview");
			}
		<?php } ?>

		for (i in ORGVIZ){
			if(viz == i){
				if ($("tab-"+tab+"-"+i)) {
					$("tab-"+tab+"-"+i).removeClassName("unselected");
					$("tab-"+tab+"-"+i).addClassName("current");
				}
				if ($("tab-content-"+tab+"-"+i)) {
					$("tab-content-"+tab+"-"+i).show();
				}
			} else {
				if ($("tab-"+tab+"-"+i)) {
					$("tab-"+tab+"-"+i).removeClassName("current");
					$("tab-"+tab+"-"+i).addClassName("unselected");
				}
				if ($("tab-content-"+tab+"-"+i)) {
					$("tab-content-"+tab+"-"+i).hide();
				}
			}
		}
	} else if (tab == 'user') {
		<?php if ($CFG->hasSocialTab) { ?>
			$('tab-social-text').innerHTML = "<?php echo $LNG->TAB_SOCIAL; ?>-<?php echo $LNG->TAB_USER; ?>";
			$('tab-social').setAttribute("href","#user-overview");
		<?php } ?>

		for (i in USERVIZ){
			if(viz == i){
				if ($("tab-"+tab+"-"+i)) {
					$("tab-"+tab+"-"+i).removeClassName("unselected");
					$("tab-"+tab+"-"+i).addClassName("current");
				}
				if ($("tab-content-"+tab+"-"+i)) {
					$("tab-content-"+tab+"-"+i).show();
				}
			} else {
				if ($("tab-"+tab+"-"+i)) {
					$("tab-"+tab+"-"+i).removeClassName("current");
					$("tab-"+tab+"-"+i).addClassName("unselected");
				}
				if ($("tab-content-"+tab+"-"+i)) {
					$("tab-content-"+tab+"-"+i).hide();
				}
			}
		}
	} else if (tab == 'comment' && $("tab-comment")) {
		for (i in COMMENTVIZ){
			if(viz == i){
				$("tab-"+tab+"-"+i).removeClassName("unselected");
				$("tab-"+tab+"-"+i).addClassName("current");
				$("tab-content-"+tab+"-"+i).show();
			} else {
				$("tab-"+tab+"-"+i).removeClassName("current");
				$("tab-"+tab+"-"+i).addClassName("unselected");
				$("tab-content-"+tab+"-"+i).hide();
			}
		}
	} else if (tab == 'news' && $("tab-news")) {
		for (i in NEWSVIZ){
			if(viz == i){
				$("tab-"+tab+"-"+i).removeClassName("unselected");
				$("tab-"+tab+"-"+i).addClassName("current");
				$("tab-content-"+tab+"-"+i).show();
			} else {
				$("tab-"+tab+"-"+i).removeClassName("current");
				$("tab-"+tab+"-"+i).addClassName("unselected");
				$("tab-content-"+tab+"-"+i).hide();
			}
		}
	}

	if (tab == 'user') {
		USER_ARGS['orderby'] = 'lastactive';
	}

	CURRENT_TAB = tab;
	CURRENT_VIZ = viz;

	switch(viz){
		case 'gmap':
			switch(tab) {
				case 'org':
					<?php if ($CFG->hasSocialTab) { ?>
						$('tab-social').setAttribute("href","#org-gmap");
						Event.stopObserving('tab-social','click');
						Event.observe('tab-social','click', stpOrgGMap);
					<?php } else { ?>
						$('tab-org').setAttribute("href","#org-gmap");
						Event.stopObserving('tab-org','click');
						Event.observe('tab-org','click', stpOrgGMap);
					<?php } ?>

					if(!DATA_LOADED.orggmap){
						loadOrgNodesGMap();
					} else {
						updateAddressParameters(ORG_ARGS);
						if (ORG_ARGS['zoomtocountry'] != 'undefined') {
							zoomToCountryOrg(ORG_ARGS['zoomtocountry']);
						}
					}
					break;
				case 'project':
					<?php if ($CFG->hasSocialTab) { ?>
						$('tab-social').setAttribute("href","#project-gmap");
						Event.stopObserving('tab-social','click');
						Event.observe('tab-social','click', stpProjectGMap);
					<?php } else { ?>
						$('tab-project').setAttribute("href","#project-gmap");
						Event.stopObserving('tab-project','click');
						Event.observe('tab-project','click', stpProjectGMap);
					<?php } ?>

					if(!DATA_LOADED.projectgmap){
						loadProjectNodesGMap();
					} else {
						updateAddressParameters(PROJECT_ARGS);
						if (PROJECT_ARGS['zoomtocountry'] != 'undefined') {
							zoomToCountryProject(PROJECT_ARGS['zoomtocountry']);
						}

					}
					break;
				}
			break;
		case 'usergmap':
			<?php if ($CFG->hasSocialTab) { ?>
				$('tab-social').setAttribute("href","#user-usergmap");
				Event.stopObserving('tab-social','click');
				Event.observe('tab-social','click', stpUserGMap);
			<?php } else { ?>
				$('tab-user').setAttribute("href","#user-usergmap");
				Event.stopObserving('tab-user','click');
				Event.observe('tab-user','click', stpUserGMap);
			<?php } ?>

			if(!DATA_LOADED.usergmap){
				loadUserGMap();
			} else {
				updateAddressParameters(USER_ARGS);
				if (USER_ARGS['zoomtocountry'] != 'undefined') {
					zoomToCountryUser(USER_ARGS['zoomtocountry']);
				}
			}
			//DATA_LOADED.user = false;
			break;

		case 'nodegmap':
			<?php if ($CFG->hasSocialTab) { ?>
				$('tab-social').setAttribute("href","#user-nodegmap");
				Event.stopObserving('tab-social','click');
				Event.observe('tab-social','click', stpUserNodeGMap);
			<?php } else {?>
				$('tab-user').setAttribute("href","#user-nodegmap");
				Event.stopObserving('tab-user','click');
				Event.observe('tab-user','click', stpUserNodeGMap);
			<?php } ?>

			if(!DATA_LOADED.nodegmap){
				loadUserNodeGMap();
			} else {
				updateAddressParameters(USER_ARGS);
				if (USER_ARGS['zoomtocountry'] != 'undefined') {
					zoomToCountryUserNode(USER_ARGS['zoomtocountry']);
				}
			}
			//DATA_LOADED.user = false;
			break;

		case 'list':
			switch(tab) {
				case 'home':
					$('tab-home').setAttribute("href",'#home-list');
					Event.observe('tab-home','click', stpHomeList);
					if(!DATA_LOADED.home){
						NODE_ARGS['start'] = (page-1) * NODE_ARGS['max'];
						loadhome(CONTEXT,NODE_ARGS);
					}
					break;
				case 'challenge':
					$('tab-challenge').setAttribute("href", '#challenge-list');
					Event.stopObserving('tab-challenge','click');
					Event.observe('tab-challenge','click', stpChallengeList);
					if(!DATA_LOADED.challenge){
						CHALLENGE_ARGS['start'] = (page-1) * CHALLENGE_ARGS['max'];
						loadchallenges(CONTEXT,CHALLENGE_ARGS);
					} else {
						updateAddressParameters(CHALLENGE_ARGS);
					}
					break;
				case 'org':
					<?php if ($CFG->hasSocialTab) { ?>
						$('tab-social').setAttribute("href",'#org-list');
						Event.stopObserving('tab-social','click');
						Event.observe('tab-social','click', stpOrgList);
					<?php } else { ?>
						$('tab-org').setAttribute("href",'#org-list');
						Event.stopObserving('tab-org','click');
						Event.observe('tab-org','click', stpOrgList);
					<?php } ?>

					if(!DATA_LOADED.org){
						ORG_ARGS['start'] = (page-1) * ORG_ARGS['max'];
						loadorgs(CONTEXT,ORG_ARGS);
					} else {
						updateAddressParameters(ORG_ARGS);
					}
					break;
				case 'project':
					<?php if ($CFG->hasSocialTab) { ?>
						$('tab-social').setAttribute("href","#project-list");
						Event.stopObserving('tab-social','click');
						Event.observe('tab-social','click', stpProjectList);
					<?php } else { ?>
						$('tab-project').setAttribute("href","#project-list");
						Event.stopObserving('tab-project','click');
						Event.observe('tab-project','click', stpProjectList);
					<?php } ?>

					if(!DATA_LOADED.project){
						PROJECT_ARGS['start'] = (page-1) * PROJECT_ARGS['max'];
						loadprojects(CONTEXT,PROJECT_ARGS);
					} else {
						updateAddressParameters(PROJECT_ARGS);
					}
					break;
				case 'issue':
					$('tab-issue').setAttribute("href",'#issue-list');
					Event.stopObserving('tab-issue','click');
					Event.observe('tab-issue','click', stpIssueList);
					if(!DATA_LOADED.issue){
						ISSUE_ARGS['start'] = (page-1) * ISSUE_ARGS['max'];
						loadissues(CONTEXT,ISSUE_ARGS);
					} else {
						updateAddressParameters(ISSUE_ARGS);
					}
					break;
				case 'solution':
					$('tab-solution').setAttribute("href",'#solution-list');
					Event.stopObserving('tab-solution','click');
					Event.observe('tab-solution','click', stpSolutionList);
					if(!DATA_LOADED.solution){
						SOLUTION_ARGS['start'] = (page-1) * SOLUTION_ARGS['max'];
						loadsolutions(CONTEXT,SOLUTION_ARGS);
					} else {
						updateAddressParameters(SOLUTION_ARGS);
					}
					break;
				case 'claim':
					$('tab-claim').setAttribute("href",'#claim-list');
					Event.stopObserving('tab-claim','click');
					Event.observe('tab-claim','click', stpClaimList);
					if(!DATA_LOADED.claim){
						CLAIM_ARGS['start'] = (page-1) * CLAIM_ARGS['max'];
						loadclaims(CONTEXT,CLAIM_ARGS);
					} else {
						updateAddressParameters(CLAIM_ARGS);
					}
					break;
				case 'evidence':
					$('tab-evidence').setAttribute("href",'#evidence-list');
					Event.stopObserving('tab-evidence','click');
					Event.observe('tab-evidence','click', stpEvidenceList);
					if(!DATA_LOADED.evidence){
						EVIDENCE_ARGS['start'] = page-1 * EVIDENCE_ARGS['max'];
						loadevidence(CONTEXT,EVIDENCE_ARGS);
					} else {
						updateAddressParameters(EVIDENCE_ARGS);
					}
					break;
				case 'web':
					$('tab-web').setAttribute("href",'#web-list');
					Event.stopObserving('tab-web','click');
					Event.observe('tab-web','click', stpWebList);
					if(!DATA_LOADED.url){
						URL_ARGS['start'] = (page-1) * URL_ARGS['max'];
						loadurls(CONTEXT,URL_ARGS);
					} else {
						updateAddressParameters(URL_ARGS);
					}
					break;
				case 'user':
					<?php if ($CFG->hasSocialTab) { ?>
						$('tab-social').setAttribute("href",'#user-list');
						Event.stopObserving('tab-social','click');
						Event.observe('tab-social','click', stpUserList);
					<?php } else { ?>
						$('tab-user').setAttribute("href",'#user-list');
						Event.stopObserving('tab-user','click');
						Event.observe('tab-user','click', stpUserList);
					<?php } ?>

					if(!DATA_LOADED.user){
						USER_ARGS['start'] = (page-1) * USER_ARGS['max'];
						loadusers(CONTEXT,USER_ARGS);
					} else {
						updateAddressParameters(USER_ARGS);
					}
					break;
				case 'comment':
					$('tab-comment').setAttribute("href",'#comment-list');
					Event.observe('tab-comment','click', stpCommentList);
					if(!DATA_LOADED.commentlist){
						COMMENT_ARGS['start'] = (page-1) * COMMENT_ARGS['max'];
						loadcomments(CONTEXT,COMMENT_ARGS);
					} else {
						updateAddressParameters(COMMENT_ARGS);
					}
					break;
				case 'news':
					$('tab-news').setAttribute("href",'#news-list');
					Event.observe('tab-news','click', stpNewsList);
					if(!DATA_LOADED.newslist){
						NEWS_ARGS['start'] = (page-1) * NEWS_ARGS['max'];
						loadnews(CONTEXT,NEWS_ARGS);
					} else {
						updateAddressParameters(NEWS_ARGS);
					}
					break;
				}
			break;

		case 'overview':
			switch(tab){
				case 'home':
					updateAddressParameters({});
					// HERE ALSO FOR BACKWARD COMPATIBILITY
					$('tab-home').setAttribute("href","#home-list");
					Event.observe('tab-home','click', stpHomeList);
					if(!DATA_LOADED.home){
						loadhome(CONTEXT,NODE_ARGS);
					}
					break;
				case 'org':
					updateAddressParameters({});
					<?php if ($CFG->hasSocialTab) { ?>
						$('tab-social').setAttribute("href","<?php echo $CFG->homeAddress;?>#org-overview");
						Event.stopObserving('tab-social','click');
						Event.observe('tab-social','click', stpOrgOverview);
					<?php } else { ?>
						$('tab-org').setAttribute("href","<?php echo $CFG->homeAddress;?>#org-overview");
						Event.stopObserving('tab-org','click');
						Event.observe('tab-org','click', stpOrgOverview);
					<?php } ?>
					if(!DATA_LOADED.orgoverview){
						loadOrgOverview(CONTEXT,ORG_ARGS);
					}
					break;
				case 'project':
					updateAddressParameters({});
					<?php if ($CFG->hasSocialTab) { ?>
						$('tab-social').setAttribute("href","<?php echo $CFG->homeAddress;?>#project-overview");
						Event.stopObserving('tab-social','click');
						Event.observe('tab-social','click', stpProjectOverview);
					<?php } else { ?>
						$('tab-project').setAttribute("href","<?php echo $CFG->homeAddress;?>#project-overview");
						Event.stopObserving('tab-project','click');
						Event.observe('tab-project','click', stpProjectOverview);
					<?php } ?>
					if(!DATA_LOADED.projectoverview){
						loadProjectOverview(CONTEXT,PROJECT_ARGS);
					}
					break;
				case 'challenge':
					updateAddressParameters({});
					$('tab-challenge').setAttribute("href","<?php echo $CFG->homeAddress;?>#challenge-overview");
					Event.stopObserving('tab-challenge','click');
					Event.observe('tab-challenge','click', stpChallengeOverview);
					if(!DATA_LOADED.challengeoverview){
						loadChallengeOverview(CONTEXT,CHALLENGE_ARGS);
					}
					break;
				case 'issue':
					updateAddressParameters({});
					$('tab-issue').setAttribute("href","<?php echo $CFG->homeAddress;?>#issue-overview");
					Event.stopObserving('tab-issue','click');
					Event.observe('tab-issue','click', stpIssueOverview);
					if(!DATA_LOADED.issueoverview){
						loadIssueOverview(CONTEXT,ISSUE_ARGS);
					}
					break;
				case 'solution':
					updateAddressParameters({});
					$('tab-solution').setAttribute("href","<?php echo $CFG->homeAddress;?>#solution-overview");
					Event.stopObserving('tab-solution','click');
					Event.observe('tab-solution','click', stpSolutionOverview);
					if(!DATA_LOADED.solutionoverview){
						loadSolutionOverview(CONTEXT,SOLUTION_ARGS);
					}
					break;
				case 'claim':
					updateAddressParameters({});
					$('tab-claim').setAttribute("href","<?php echo $CFG->homeAddress;?>#claim-overview");
					Event.stopObserving('tab-claim','click');
					Event.observe('tab-claim','click', stpClaimOverview);
					if(!DATA_LOADED.claimoverview){
						loadClaimOverview(CONTEXT,CLAIM_ARGS);
					}
					break;
				case 'evidence':
					updateAddressParameters({});
					$('tab-evidence').setAttribute("href","<?php echo $CFG->homeAddress;?>#evidence-overview");
					Event.stopObserving('tab-evidence','click');
					Event.observe('tab-evidence','click', stpEvidenceOverview);
					if(!DATA_LOADED.evidenceoverview){
						loadEvidenceOverview(CONTEXT,EVIDENCE_ARGS);
					}
					break;
				case 'web':
					updateAddressParameters({});
					$('tab-web').setAttribute("href","<?php echo $CFG->homeAddress;?>#web-overview");
					Event.stopObserving('tab-web','click');
					Event.observe('tab-web','click', stpWebOverview);
					if(!DATA_LOADED.urloverview){
						loadWebOverview(CONTEXT,URL_ARGS);
					}
					break;
				case 'user':
					updateAddressParameters({});
					<?php if ($CFG->hasSocialTab) { ?>
						$('tab-social').setAttribute("href","<?php echo $CFG->homeAddress;?>#user-overview");
						Event.stopObserving('tab-social','click');
						Event.observe('tab-social','click', stpUserOverview);
					<?php } else { ?>
						$('tab-user').setAttribute("href","<?php echo $CFG->homeAddress;?>#user-overview");
						Event.stopObserving('tab-user','click');
						Event.observe('tab-user','click', stpUserOverview);
					<?php } ?>
					if(!DATA_LOADED.useroverview){
						loadUserOverview(CONTEXT,USER_ARGS);
					}
					break;
			}
			break;

		case 'net':
			switch(tab){
				case 'org':
					<?php if ($CFG->hasSocialTab) { ?>
						$('tab-social').setAttribute("href","#org-net");
						Event.stopObserving('tab-social','click');
						Event.observe('tab-social','click', stpOrgNet);
					<?php } else { ?>
						$('tab-org').setAttribute("href","#org-net");
						Event.stopObserving('tab-org','click');
						Event.observe('tab-org','click', stpOrgNet);
					<?php } ?>
					loadOrgNet(CONTEXT,ORG_ARGS);
					//DATA_LOADED.org = false;
					break;
				case 'project':
					<?php if ($CFG->hasSocialTab) { ?>
						$('tab-social').setAttribute("href","#project-net");
						Event.stopObserving('tab-social','click');
						Event.observe('tab-social','click', stpProjectNet);
					<?php } else { ?>
						$('tab-project').setAttribute("href","#project-net");
						Event.stopObserving('tab-project','click');
						Event.observe('tab-project','click', stpProjectNet);
					<?php } ?>
					loadProjectNet(CONTEXT,PROJECT_ARGS);
					//DATA_LOADED.project = false;
					break;
				case 'challenge':
					$('tab-challenge').setAttribute("href","#challenge-net");
					Event.stopObserving('tab-challenge','click');
					Event.observe('tab-challenge','click', stpChallengeNet);
					loadChallengeNet(CONTEXT,CHALLENGE_ARGS);
					//DATA_LOADED.challenge = false;
					break;
				case 'issue':
					$('tab-issue').setAttribute("href","#issue-net");
					Event.stopObserving('tab-issue','click');
					Event.observe('tab-issue','click', stpIssueNet);
					loadIssueNet(CONTEXT,ISSUE_ARGS);
					//DATA_LOADED.issue = false;
					break;
				case 'solution':
					$('tab-solution').setAttribute("href","#solution-net");
					Event.stopObserving('tab-solution','click');
					Event.observe('tab-solution','click', stpSolutionNet);
					loadSolutionNet(CONTEXT,SOLUTION_ARGS);
					//DATA_LOADED.solution = false;
					break;
				case 'claim':
					$('tab-claim').setAttribute("href","#claim-net");
					Event.stopObserving('tab-claim','click');
					Event.observe('tab-claim','click', stpClaimNet);
					loadClaimNet(CONTEXT,CLAIM_ARGS);
					//DATA_LOADED.claim = false;
					break;
				case 'evidence':
					$('tab-evidence').setAttribute("href","#evidence-net");
					Event.stopObserving('tab-evidence','click');
					Event.observe('tab-evidence','click', stpEvidenceNet);
					loadEvidenceNet(CONTEXT,EVIDENCE_ARGS);
					//DATA_LOADED.evidence = false;
					break;
				case 'web':
					$('tab-web').setAttribute("href","#web-net");
					Event.stopObserving('tab-web','click');
					Event.observe('tab-web','click', stpWebNet);
					loadWebNet(CONTEXT,URL_ARGS);
					//DATA_LOADED.web = false;
					break;
				case 'user':
					<?php if ($CFG->hasSocialTab) { ?>
						$('tab-social').setAttribute("href","<?php echo $CFG->homeAddress; ?>#user-net");
						Event.stopObserving('tab-social','click');
						Event.observe('tab-social','click', stpUserNet);
					<?php } else { ?>
						$('tab-user').setAttribute("href","<?php echo $CFG->homeAddress; ?>#user-net");
						Event.stopObserving('tab-user','click');
						Event.observe('tab-user','click', stpUserNet);
					<?php } ?>
					loadUserNet(CONTEXT,USER_ARGS);
					//DATA_LOADED.usernet = false;
					break;
				}
			break;
		default:
			//alert("default");
	}
}


/**
 *	Called by forms to refresh the challenges view
 */
function refreshChallenges() {
	switch(CURRENT_VIZ){
		case 'list':
			loadchallenges(CONTEXT,CHALLENGE_ARGS);
			break;
		case 'net':
			loadChallengeNet(CONTEXT,CHALLENGE_ARGS);
			break;
		default:
	}
}

/**
 *	Called to refresh the current org view
 */
function refreshOrganizations() {
	switch(CURRENT_VIZ){
		case 'list':
			loadorgs(CONTEXT,ORG_ARGS);
			break;
		case 'net':
			if ($('CohereOrgNet')) {
				loadOrgThemeApplet();
			} else {
				loadOrgNet(CONTEXT,ORG_ARGS);
			}
			break;
		case 'gmap':
			loadOrgNodesGMap(CONTEXT,ORG_ARGS);
			break;
		default:
	}
}

/**
 *	Called to refresh the current project view
 */
function refreshProjects() {
	switch(CURRENT_VIZ){
		case 'list':
			loadprojects(CONTEXT,PROJECT_ARGS);
			break;
		case 'net':
			if ($('CohereProjectNet')) {
				loadProjectThemeApplet();
			} else {
				loadProjectNet(CONTEXT,PROJECT_ARGS);
			}
			break;
		case 'gmap':
			loadProjectNodesGMap(CONTEXT,PROJECT_ARGS);
			break;
		default:
	}
}


/**
 *	Called by forms to refresh the issues view
 */
function refreshIssues() {
	switch(CURRENT_VIZ){
		case 'list':
			loadissues(CONTEXT,ISSUE_ARGS);
			break;
		case 'net':
			if ($('CohereIssueNet')) {
				loadIssueThemeApplet();
			} else {
				loadIssueNet(CONTEXT,ISSUE_ARGS);
			}
			break;
		default:
	}
}

/**
 *	Called by forms to refresh the solution view
 */
function refreshSolutions() {
	switch(CURRENT_VIZ){
		case 'list':
			loadsolutions(CONTEXT,SOLUTION_ARGS);
			break;
		case 'net':
			if ($('CohereSolutionNet')) {
				loadSolutionThemeApplet();
			} else {
				loadSolutionNet(CONTEXT,SOLUTION_ARGS);
			}
			break;
		default:
	}
}

/**
 *	Called by forms to refresh the claims view
 */
function refreshClaims() {
	switch(CURRENT_VIZ){
		case 'list':
			loadclaims(CONTEXT,CLAIM_ARGS);
			break;
		case 'net':
			if ($('CohereClaimNet')) {
				loadClaimThemeApplet();
			} else {
				loadClaimNet(CONTEXT,CLAIM_ARGS);
			}
			break;
		default:
	}
}

/**
 *	Called by forms to refresh the evidence view
 */
function refreshEvidence() {
	switch(CURRENT_VIZ){
		case 'list':
			loadevidence(CONTEXT,EVIDENCE_ARGS);
			break;
		case 'net':
			if ($('CohereEvidenceNet')) {
				loadEvidenceThemeApplet();
			} else {
				loadEvidenceNet(CONTEXT,EVIDENCE_ARGS);
			}
			break;
		default:
	}
}
function refreshWebsites() {
	switch(CURRENT_VIZ){
		case 'list':
			loadurls(CONTEXT,URL_ARGS);
			break;
		case 'net':
			if ($('CohereResourceNet')) {
				loadResourceThemeApplet();
			} else {
				loadResourceNet(CONTEXT,URL_ARGS);
			}
			break;
		default:
	}
}

function refreshUsers() {
	switch(CURRENT_VIZ){
		case 'list':
			loadusers(CONTEXT,USER_ARGS);
			break;
		case 'usergmap':
			loadUserGMap();
			break;
		case 'nodegmap':
			loadUserNodeGMap();
			break;
		default:
	}
}

function refreshComments() {
	loadcomments(CONTEXT,COMMENT_ARGS);
}

function refreshNews() {
	loadnews(CONTEXT,NEWS_ARGS);
}

/**
 *	load next/previous set of organisation nodes
 */
function loadhome(context,args){
	loadHomePageOverview(context, args)
	//$("tab-content-home").update("Home page");
}

// LOAD OVERVIEWS

/**
 * Create the Home Overview page
 * @param context the current context
 * @param args the array of parameters for this category
 */
function loadHomePageOverview(context, args) {
	if ($("tab-content-home-overview")) {
		$("tab-content-home-overview").innerHTML = "";
		var widget = overviewHomeNodeWidget(context, args, BASE_TYPES_STR+','+RESOURCE_TYPES_STR+','+EVIDENCE_TYPES_STR, 'date', 'DESC', '10', 230, 220, 'mostrecent');
		if (widget.innerHTML == "") {
			$("tab-content-home-recent").style.display = "none";
		} else {
			$("tab-content-home-overview").insert( widget );
			DATA_LOADED.homeoverview = true;
		}
	}
}

/**
 * Create the Key Challenge Overview page
 * @param context the current context
 * @param args the array of parameters for this category
 */
function loadChallengeOverview(context, args) {

	$("tab-content-challenge-overview").innerHTML = "";

	var row1 = new Element("div", {"class":"tab-content-overview row mb-3"});

	var recentorgs = new Element("div", {"class":"col-md-6 col-sm-12"});
	var set = overviewNodeWidget(context, args, '<?php echo $LNG->OVERVIEW_CHALLENGE_MOSTRECENT_TITLE; ?>', "Challenge", 'date', 'DESC', '5', 350, 190, '<?php echo $LNG->OVERVIEW_BUTTON_EXPLOREALL; ?>', 'challenge', '<?php echo $LNG->CHALLENGES_NAME; ?>', 'mostrecent');

	recentorgs.insert(set);

	var connectedorgs = new Element("div", {"class":"col-md-6 col-sm-12"});
	var set = overviewNodeWidget(context, args, '<?php echo $LNG->OVERVIEW_CHALLENGE_MOSTCONNECTED_TITLE; ?>', "Challenge", 'connectedness', 'DESC', '5', 350, 190, '<?php echo $LNG->OVERVIEW_BUTTON_EXPLOREALL; ?>', 'challenge', '<?php echo $LNG->CHALLENGES_NAME; ?>', 'mostconnected');
	connectedorgs.insert(set);

	row1.insert(recentorgs);
	row1.insert(connectedorgs);

	var row2 = new Element("div", {"class":"tab-content-overview row mb-3"});

	var voted = new Element("div", {"class":"col-md-6 col-sm-12"});
	var set3 = overviewNodeWidget(context, args, '<?php echo $LNG->OVERVIEW_CHALLENGE_MOSTVOTED_TITLE; ?>', "Challenge", 'vote', 'DESC', '5', 350, 190, '<?php echo $LNG->OVERVIEW_BUTTON_EXPLOREALL; ?>', 'challenge', '<?php echo $LNG->CHALLENGES_NAME; ?>', 'mostvoted');
	voted.insert(set3);

	var poptheme = new Element("div", {"class":"col-md-6 col-sm-12"});
	var set2 = overviewThemeWidget(context, args, '<?php echo $LNG->OVERVIEW_CHALLENGE_POPULARTHEMES_TITLE; ?>', 'Challenge', '5', 350, 201, '<?php echo $LNG->OVERVIEW_BUTTON_EXPLOREALL; ?>', 'challenge', '<?php echo $LNG->CHALLENGES_NAME; ?>', 'mostthemes');
	poptheme.insert(set2);

	row2.insert(voted);
	row2.insert(poptheme);
	$("tab-content-challenge-overview").insert( row1 );
	$("tab-content-challenge-overview").insert( row2 );

	DATA_LOADED.challengeoverview = true;
}

/**
 * Create the Issue Overview page
 * @param context the current context
 * @param args the array of parameters for this category
 */
function loadIssueOverview(context, args) {

	$("tab-content-issue-overview").innerHTML = "";

	var row1 = new Element("div", {"class":"tab-content-overview row mb-3"});

	var recentorgs = new Element("div", {"class":"col-md-6 col-sm-12"});
	var set = overviewNodeWidget(context, args, '<?php echo $LNG->OVERVIEW_ISSUE_MOSTRECENT_TITLE; ?>', "Issue", 'date', 'DESC', '5', 350, 190, '<?php echo $LNG->OVERVIEW_BUTTON_EXPLOREALL; ?>', 'issue', '<?php echo $LNG->ISSUES_NAME; ?>', 'mostrecent');
	recentorgs.insert(set);

	var connectedorgs = new Element("div", {"class":"col-md-6 col-sm-12"});
	var set = overviewNodeWidget(context, args, '<?php echo $LNG->OVERVIEW_ISSUE_MOSTCONNECTED_TITLE; ?>', "Issue", 'connectedness', 'DESC', '5', 350, 190, '<?php echo $LNG->OVERVIEW_BUTTON_EXPLOREALL; ?>', 'issue', '<?php echo $LNG->ISSUES_NAME; ?>', 'mostconnected');
	connectedorgs.insert(set);

	row1.insert(recentorgs);
	row1.insert(connectedorgs);

	var row2 = new Element("div", {"class":"tab-content-overview row mb-3"});

	var voted = new Element("div", {"class":"col-md-6 col-sm-12"});
	var set3 = overviewNodeWidget(context, args, '<?php echo $LNG->OVERVIEW_ISSUE_MOSTVOTED_TITLE; ?>', "Issue", 'vote', 'DESC', '5', 350, 190, '<?php echo $LNG->OVERVIEW_BUTTON_EXPLOREALL; ?>', 'issue', '<?php echo $LNG->ISSUES_NAME; ?>', 'mostvoted');
	voted.insert(set3);

	var poptheme = new Element("div", {"class":"col-md-6 col-sm-12"});
	var set2 = overviewThemeWidget(context, args, '<?php echo $LNG->OVERVIEW_ISSUE_POPULARTHEMES_TITLE; ?>', 'Issue', '5', 350, 201, '<?php echo $LNG->OVERVIEW_BUTTON_EXPLOREALL; ?>', 'issue', '<?php echo $LNG->ISSUES_NAME; ?>', 'mostthemes');
	poptheme.insert(set2);

	row2.insert(voted);
	row2.insert(poptheme);
	$("tab-content-issue-overview").insert( row1 );
	$("tab-content-issue-overview").insert( row2 );

	DATA_LOADED.issueoverview = true;
}

/**
 * Create the Solution Overview page
 * @param context the current context
 * @param args the array of parameters for this category
 */
function loadSolutionOverview(context, args) {

	$("tab-content-solution-overview").innerHTML = "";

	var row1 = new Element("div", {"class":"tab-content-overview row mb-3"});

	var recent = new Element("div", {"class":"col-md-6 col-sm-12"});
	var set = overviewNodeWidget(context, args, '<?php echo $LNG->OVERVIEW_SOLUTION_MOSTRECENT_TITLE; ?>', "Solution", 'date', 'DESC', '5', 350, 190, '<?php echo $LNG->OVERVIEW_BUTTON_EXPLOREALL; ?>', 'solution', '<?php echo $LNG->SOLUTIONS_NAME; ?>', 'mostrecent');
	recent.insert(set);

	var connected = new Element("div", {"class":"col-md-6 col-sm-12"});
	var set = overviewNodeWidget(context, args, '<?php echo $LNG->OVERVIEW_SOLUTION_MOSTCONNECTED_TITLE; ?>', "Solution", 'connectedness', 'DESC', '5', 350, 190, '<?php echo $LNG->OVERVIEW_BUTTON_EXPLOREALL; ?>', 'solution', '<?php echo $LNG->SOLUTIONS_NAME; ?>', 'mostconnected');
	connected.insert(set);

	row1.insert(recent);
	row1.insert(connected);

	var row2 = new Element("div", {"class":"tab-content-overview row mb-3"});

	var voted = new Element("div", {"class":"col-md-6 col-sm-12"});
	var set3 = overviewNodeWidget(context, args, '<?php echo $LNG->OVERVIEW_SOLUTION_MOSTVOTED_TITLE; ?>', "Solution", 'vote', 'DESC', '5', 350, 190, '<?php echo $LNG->OVERVIEW_BUTTON_EXPLOREALL; ?>', 'solution', '<?php echo $LNG->SOLUTIONS_NAME; ?>', 'mostvoted');
	voted.insert(set3);

	var poptheme = new Element("div", {"class":"col-md-6 col-sm-12"});
	var set2 = overviewThemeWidget(context, args, '<?php echo $LNG->OVERVIEW_SOLUTION_POPULARTHEMES_TITLE; ?>', 'Solution', '5', 350, 201, '<?php echo $LNG->OVERVIEW_BUTTON_EXPLOREALL; ?>', 'solution', '<?php echo $LNG->SOLUTIONS_NAME; ?>', 'mostthemes');
	poptheme.insert(set2);

	row2.insert(voted);
	row2.insert(poptheme);
	$("tab-content-solution-overview").insert( row1 );
	$("tab-content-solution-overview").insert( row2 );

	DATA_LOADED.solutionoverview = true;
}

/**
 * Create the Claim Overview page
 * @param context the current context
 * @param args the array of parameters for this category
 */
function loadClaimOverview(context, args) {

	$("tab-content-claim-overview").innerHTML = "";

	var row1 = new Element("div", {"class":"tab-content-overview row mb-3"});

	var recent = new Element("div", {"class":"col-md-6 col-sm-12"});
	var set = overviewNodeWidget(context, args, '<?php echo $LNG->OVERVIEW_CLAIM_MOSTRECENT_TITLE; ?>', "Claim", 'date', 'DESC', '5', 350, 190, '<?php echo $LNG->OVERVIEW_BUTTON_EXPLOREALL; ?>', 'claim', '<?php echo $LNG->CLAIMS_NAME; ?>', 'mostrecent');
	recent.insert(set);
	row1.insert(recent);

	var connected = new Element("div", {"class":"col-md-6 col-sm-12"});
	var set = overviewNodeWidget(context, args, '<?php echo $LNG->OVERVIEW_CLAIM_MOSTCONNECTED_TITLE; ?>', "Claim", 'connectedness', 'DESC', '5', 350, 190, '<?php echo $LNG->OVERVIEW_BUTTON_EXPLOREALL; ?>', 'claim', '<?php echo $LNG->CLAIMS_NAME; ?>', 'mostconnected');
	connected.insert(set);
	row1.insert(connected);

	var row2 = new Element("div", {"class":"tab-content-overview row mb-3"});

	var voted = new Element("div", {"class":"col-md-6 col-sm-12"});
	var set3 = overviewNodeWidget(context, args, '<?php echo $LNG->OVERVIEW_CLAIM_MOSTVOTED_TITLE; ?>', "Claim", 'vote', 'DESC', '5', 350, 190, '<?php echo $LNG->OVERVIEW_BUTTON_EXPLOREALL; ?>', 'claim', '<?php echo $LNG->CLAIMS_NAME; ?>', 'mostvoted');
	voted.insert(set3);
	row2.insert(voted);

	var poptheme = new Element("div", {"class":"col-md-6 col-sm-12"});
	var set2 = overviewThemeWidget(context, args, '<?php echo $LNG->OVERVIEW_CLAIM_POPULARTHEMES_TITLE; ?>', 'Claim', '5', 350, 201, '<?php echo $LNG->OVERVIEW_BUTTON_EXPLOREALL; ?>', 'claim', '<?php echo $LNG->CLAIMS_NAME; ?>', 'mostthemes');
	poptheme.insert(set2);
	row2.insert(poptheme);

	$("tab-content-claim-overview").insert( row1 );
	$("tab-content-claim-overview").insert( row2 );

	DATA_LOADED.claimoverview = true;
}

/**
 * Create the Evidence Overview page
 * @param context the current context
 * @param args the array of parameters for this category
 */
function loadEvidenceOverview(context, args) {

	$("tab-content-evidence-overview").innerHTML = "";

	var row1 = new Element("div", {"class":"tab-content-overview row mb-3"});

	var recent = new Element("div", {"class":"col-md-6 col-sm-12"});
	var set = overviewNodeWidget(context, args, '<?php echo $LNG->OVERVIEW_EVIDENCE_MOSTRECENT_TITLE; ?>', EVIDENCE_TYPES_STR, 'date', 'DESC', '5', 350, 190, '<?php echo $LNG->OVERVIEW_BUTTON_EXPLOREALL; ?>', 'evidence', '<?php echo $LNG->EVIDENCES_NAME; ?>', 'mostrecent');
	recent.insert(set);
	row1.insert(recent);

	var connected = new Element("div", {"class":"col-md-6 col-sm-12"});
	var set = overviewNodeWidget(context, args, '<?php echo $LNG->OVERVIEW_EVIDENCE_MOSTCONNECTED_TITLE; ?>', EVIDENCE_TYPES_STR, 'connectedness', 'DESC', '5', 350, 190, '<?php echo $LNG->OVERVIEW_BUTTON_EXPLOREALL; ?>', 'evidence', '<?php echo $LNG->EVIDENCES_NAME; ?>', 'mostconnected');
	connected.insert(set);
	row1.insert(connected);

	var row2 = new Element("div", {"class":"tab-content-overview row mb-3"});

	var voted = new Element("div", {"class":"col-md-6 col-sm-12"});
	var set3 = overviewNodeWidget(context, args, '<?php echo $LNG->OVERVIEW_EVIDENCE_MOSTVOTED_TITLE; ?>', EVIDENCE_TYPES_STR, 'vote', 'DESC', '5', 350, 190, '<?php echo $LNG->OVERVIEW_BUTTON_EXPLOREALL; ?>', 'evidence', '<?php echo $LNG->EVIDENCES_NAME; ?>', 'mostvoted');
	voted.insert(set3);
	row2.insert(voted);

	var poptheme = new Element("div", {"class":"col-md-6 col-sm-12"});
	var set2 = overviewThemeWidget(context, args, '<?php echo $LNG->OVERVIEW_EVIDENCE_POPULARTHEMES_TITLE; ?>', EVIDENCE_TYPES_STR, '5', 350, 201, '<?php echo $LNG->OVERVIEW_BUTTON_EXPLOREALL; ?>', 'evidence', '<?php echo $LNG->EVIDENCES_NAME; ?>', 'mostthemes');
	poptheme.insert(set2);
	row2.insert(poptheme);

	$("tab-content-evidence-overview").insert( row1 );
	$("tab-content-evidence-overview").insert( row2 );

	DATA_LOADED.evidenceoverview = true;
}

/**
 * Create the Resources Overview page
 * @param context the current context
 * @param args the array of parameters for this category
 */
function loadWebOverview(context, args) {

	$("tab-content-web-overview").innerHTML = "";

	var row1 = new Element("div", {"class":"tab-content-overview row mb-3"});

	var recent = new Element("div", {"class":"col-md-6 col-sm-12"});
	var set = overviewNodeWidget(context, args, '<?php echo $LNG->OVERVIEW_RESOURCE_MOSTRECENT_TITLE; ?>', RESOURCE_TYPES_STR, 'date', 'DESC', '5', 350, 190, '<?php echo $LNG->OVERVIEW_BUTTON_EXPLOREALL; ?>', 'web', '<?php echo $LNG->RESOURCES_NAME; ?>', 'mostrecent');
	recent.insert(set);
	row1.insert(recent);

	var connected = new Element("div", {"class":"col-md-6 col-sm-12"});
	var set = overviewNodeWidget(context, args, '<?php echo $LNG->OVERVIEW_RESOURCE_MOSTCONNECTED_TITLE; ?>', RESOURCE_TYPES_STR, 'connectedness', 'DESC', '5', 350, 190, '<?php echo $LNG->OVERVIEW_BUTTON_EXPLOREALL; ?>', 'web', '<?php echo $LNG->RESOURCES_NAME; ?>', 'mostconnected');
	connected.insert(set);
	row1.insert(connected);

	var row2 = new Element("div", {"class":"tab-content-overview row mb-3"});

	var poptheme = new Element("div", {"class":"col-md-6 col-sm-12"});
	var set2 = overviewThemeWidget(context, args, '<?php echo $LNG->OVERVIEW_RESOURCE_POPULARTHEMES_TITLE; ?>', RESOURCE_TYPES_STR, '5', 350, 191, '<?php echo $LNG->OVERVIEW_BUTTON_EXPLOREALL; ?>', 'web', '<?php echo $LNG->RESOURCES_NAME; ?>', 'mostthemes');
	poptheme.insert(set2);
	row2.insert(poptheme);

	$("tab-content-web-overview").insert( row1 );
	$("tab-content-web-overview").insert( row2 );

	DATA_LOADED.weboverview = true;
}

/**
 * Create the Users Overview page
 * @param context the current context
 * @param args the array of parameters for this category
 */
function loadUserOverview(context, args) {
	$("tab-content-user-overview").innerHTML = "";

	var row1 = new Element("div", {"class":"tab-content-overview row mb-3"});

	var recentusers = new Element("div", {"class":"col-md-6 col-sm-12"});
	var set = overviewUserWidget(context, args, "<?php echo $LNG->OVERVIEW_USER_MOSTRECENT_TITLE; ?>", 'date', 'DESC', '5', 350, 190, "<?php echo $LNG->OVERVIEW_BUTTON_EXPLOREALL; ?>", 'user', '<?php echo $LNG->USERS_NAME;?>');
	recentusers.insert(set);
	row1.insert(recentusers);

	var followedusers = new Element("div", {"class":"col-md-6 col-sm-12"});
	var set = overviewFollowedUserWidget(context, args, "<?php echo $LNG->OVERVIEW_USER_MOSTFOLLOWED_TITLE; ?>", 'date', 'DESC', '5', 350, 190, "<?php echo $LNG->OVERVIEW_BUTTON_EXPLOREALL; ?>", 'user', '<?php echo $LNG->USERS_NAME;?>');
	followedusers.insert(set);
	row1.insert(followedusers);

	var row2 = new Element("div", {"class":"tab-content-overview row mb-3"});

	var activeusers = new Element("div", {"class":"col-md-6 col-sm-12"});
	var set = overviewActiveUserWidget(context, args, "<?php echo $LNG->OVERVIEW_USER_MOSTACTIVE_TITLE; ?>", 'date', 'DESC', '5', 350, 190, "<?php echo $LNG->OVERVIEW_BUTTON_EXPLOREALL; ?>", 'user', '<?php echo $LNG->USERS_NAME;?>');
	activeusers.insert(set);
	row2.insert(activeusers);

	var usercountries = new Element("div", {"class":"col-md-6 col-sm-12"});

	var set2 = new Element("fieldset", {'class':'overviewfieldset'});
	var legend2 = new Element("legend", {'class':'overviewlegend widgettextcolor'});
	legend2.insert("<?php echo $LNG->OVERVIEW_USER_COUNTRIES_TITLE; ?>");
	set2.insert(legend2);

	var main2 = new Element("div", {"class":"overviewDiv", 'style':'height: 190px; overflow-y: auto; overflow-x: hidden;'});
	var tagcloud = new Element("div", {'id':'tagcloud', "class": "user-tagcloud" });
	tagcloud.insert(createCountryCloud(userscountrycloud, 'users'));
	main2.insert(tagcloud);
	set2.insert(main2);

	var buttondiv = new Element("div", {'style':'width: 100%; clear:both;float:left;'});
	var allbutton = new Element("span", {'class':'active', 'title':"<?php echo $LNG->OVERVIEW_USER_COUNTRIES_HINT; ?>", 'style':'float:right; font-weight:bold; margin: 5px;margin-top:0px;'});
	allbutton.insert("<?php echo $LNG->OVERVIEW_BUTTON_VIEWONMAP; ?>");
	Event.observe(allbutton,'click',function(){
		setTabPushed( $('tab-user-list-obj'), 'user-usergmap');
	});
	buttondiv.insert(allbutton);
	set2.insert(buttondiv);

	usercountries.insert(set2);
	row2.insert(usercountries);

	$("tab-content-user-overview").insert( row1 );
	$("tab-content-user-overview").insert( row2 );

	DATA_LOADED.useroverview = true;
}

/**
 * Create the Organization/Project Overview page
 * @param context the current context
 * @param args the array of parameters for this category
 */
function loadOrgOverview(context, args) {

	$("tab-content-org-overview").innerHTML = "";

	var row1 = new Element("div", {"class":"tab-content-overview row mb-3"});

	var recentorgs = new Element("div", {"class":"col-md-6 col-sm-12"});
	var set = overviewNodeWidget(context, args, '<?php echo $LNG->OVERVIEW_ORG_MOSTRECENT_TITLE; ?>', "Organization", 'date', 'DESC', '5', 350, 190, '<?php echo $LNG->OVERVIEW_BUTTON_EXPLOREALL; ?>', 'org', '<?php echo $LNG->ORGS_NAME; ?>', 'recentorg', 'Organization');
	recentorgs.insert(set);
	row1.insert(recentorgs);

	var connectedorgs = new Element("div", {"class":"col-md-6 col-sm-12"});
	var set = overviewNodeWidget(context, args, '<?php echo $LNG->OVERVIEW_ORG_MOSTCONNECTED_TITLE; ?>', "Organization", 'connectedness', 'DESC', '5', 350, 190, '<?php echo $LNG->OVERVIEW_BUTTON_EXPLOREALL; ?>', 'org', '<?php echo $LNG->ORGS_NAME; ?>', 'connectorg', 'Organization');
	connectedorgs.insert(set);
	row1.insert(connectedorgs);

	var row2 = new Element("div", {"class":"tab-content-overview row mb-3"});

	var orgcountries = new Element("div", {"class":"col-md-6 col-sm-12"});

	var set2 = new Element("fieldset", {'class':'overviewfieldset'});
	var legend2 = new Element("legend", {'class':'overviewlegend widgettextcolor'});
	legend2.insert('<?php echo $LNG->OVERVIEW_ORG_COUNTRIES_TITLE; ?>');
	set2.insert(legend2);

	var main2 = new Element("div", {"class":"overviewDiv", 'style':'height: 190px; overflow-y: auto; overflow-x: hidden;'});
	var tagcloud = new Element("div", {'id':'tagcloud','style':'width: 350px;'});
	tagcloud.insert(createCountryCloud(orgcountrycloud, 'orgs'));
	main2.insert(tagcloud);
	set2.insert(main2);

	var buttondiv = new Element("div", {'style':'width: 100%; clear:both;float:left;'});
	var allbutton = new Element("span", {'class':'active', 'title':'<?php echo $LNG->OVERVIEW_ORG_COUNTRIES_HINT; ?>', 'style':'float:right; font-weight:bold; margin: 5px;margin-top:0px;'});
	allbutton.insert('<?php echo $LNG->OVERVIEW_BUTTON_VIEWONMAP; ?>');
	Event.observe(allbutton,'click',function(){
		ORG_ARGS['filternodetypes'] = 'Project';
		setTabPushed( $('tab-org-list-obj'), 'org-gmap');
	});
	buttondiv.insert(allbutton);
	set2.insert(buttondiv);

	orgcountries.insert(set2);
	row2.insert(orgcountries);

	var poptheme = new Element("div", {"class":"col-md-6 col-sm-12"});
	var set2 = overviewThemeWidget(context, args, '<?php echo $LNG->OVERVIEW_ORG_POPULARTHEMES_TITLE; ?>', 'Organization', '5', 350, 201, '<?php echo $LNG->OVERVIEW_BUTTON_EXPLOREALL; ?>', 'org', '<?php echo $LNG->ORGS_NAME; ?>', 'mostthemes');
	poptheme.insert(set2);
	row2.insert(poptheme);

	$("tab-content-org-overview").insert( row1 );
	$("tab-content-org-overview").insert( row2 );

	DATA_LOADED.orgoverview = true;
}

/**
 * Create the Project Overview page
 * @param context the current context
 * @param args the array of parameters for this category
 */
function loadProjectOverview(context, args) {

	$("tab-content-project-overview").innerHTML = "";

	var row1 = new Element("div", {"class":"tab-content-overview row mb-3"});

	var recentprojects = new Element("div", {"class":"col-md-6 col-sm-12"});
	var set2 = overviewNodeWidget(context, args, '<?php echo $LNG->OVERVIEW_PROJECT_MOSTRECENT_TITLE; ?>', "Project", 'date', 'DESC', '5', 350, 190, '<?php echo $LNG->OVERVIEW_BUTTON_EXPLOREALL; ?>', 'project', '<?php echo $LNG->PROJECTS_NAME; ?>', 'recentprojects', 'Project');
	recentprojects.insert(set2);
	row1.insert(recentprojects);

	var connectedprojects = new Element("div", {"class":"col-md-6 col-sm-12"});
	var set2 = overviewNodeWidget(context, args, '<?php echo $LNG->OVERVIEW_PROJECT_MOSTCONNECTED_TITLE; ?>', "Project", 'connectedness', 'DESC', '5', 350, 190, '<?php echo $LNG->OVERVIEW_BUTTON_EXPLOREALL; ?>', 'project', '<?php echo $LNG->PROJECTS_NAME; ?>','connectedprojects', 'Project');
	connectedprojects.insert(set2);
	row1.insert(connectedprojects);

	var row2 = new Element("div", {"class":"tab-content-overview row mb-3"});

	var projectcountries = new Element("div", {"class":"col-md-6 col-sm-12"});

	var set2 = new Element("fieldset", {'class':'overviewfieldset'});
	var legend2 = new Element("legend", {'class':'overviewlegend widgettextcolor'});
	legend2.insert('<?php echo $LNG->OVERVIEW_PROJECT_COUNTRIES_TITLE; ?>');
	set2.insert(legend2);

	var main2 = new Element("div", {'id':'tagcloud', 'style':'width:100%; float:left; height: 190px; overflow-y: auto; overflow-x: none; margin-left;5px;margin-top: 5px;'});
	main2.insert(createCountryCloud(projectcountrycloud, 'projects'));
	set2.insert(main2);

	var buttondiv2 = new Element("div", {'style':'width: 100%; clear:both;float:left;'});
	var allbutton = new Element("span", {'class':'active', 'title':'<?php echo $LNG->OVERVIEW_PROJECT_COUNTRIES_HINT; ?>', 'style':'float:right; font-weight:bold; margin: 5px;margin-top:0px;'});
	allbutton.insert('<?php echo $LNG->OVERVIEW_BUTTON_VIEWONMAP; ?>');
	Event.observe(allbutton,'click',function(){
		PROJECT_ARGS['filternodetypes'] = 'Project';
		setTabPushed( $('tab-project-list-obj'), 'project-gmap');
	});
	buttondiv2.insert(allbutton);
	set2.insert(buttondiv2);

	projectcountries.insert(set2);
	row2.insert(projectcountries);

	var poptheme2 = new Element("div", {"class":"col-md-6 col-sm-12"});
	var set2 = overviewThemeWidget(context, args, '<?php echo $LNG->OVERVIEW_PROJECT_POPULARTHEMES_TITLE; ?>', 'Project', '5', 350, 211, '<?php echo $LNG->OVERVIEW_BUTTON_EXPLOREALL; ?>', 'project', '<?php echo $LNG->PROJECTS_NAME; ?>', 'mostthemes');
	poptheme2.insert(set2);
	row2.insert(poptheme2);

	$("tab-content-project-overview").insert( row1 );
	$("tab-content-project-overview").insert( row2 );

	DATA_LOADED.projectoverview = true;
}

function gotoCountry(type, country) {
	if (type == 'orgs') {
		ORG_ARGS['filternodetypes'] = 'Project';
		ORG_ARGS['zoomtocountry'] = country;
		<?php if ($CFG->hasSocialTab) { ?>
			$('tab-social').setAttribute("href","#org-gmap");
			Event.stopObserving('tab-social','click');
			Event.observe('tab-social','click', stpOrgGMap);
		<?php } else { ?>
			$('tab-org').setAttribute("href","#org-gmap");
			Event.stopObserving('tab-org','click');
			Event.observe('tab-org','click', stpOrgGMap);
		<?php } ?>
		setTabPushed( $('tab-org-list-obj'), 'org-gmap');
	} else if (type == 'projects') {
		PROJECT_ARGS['filternodetypes'] = 'Project';
		PROJECT_ARGS['zoomtocountry'] = country;
		<?php if ($CFG->hasSocialTab) { ?>
			$('tab-social').setAttribute("href","#project-gmap");
			Event.stopObserving('tab-social','click');
			Event.observe('tab-social','click', stpProjectGMap);
		<?php } else { ?>
			$('tab-project').setAttribute("href","#project-gmap");
			Event.stopObserving('tab-project','click');
			Event.observe('tab-project','click', stpProjectGMap);
		<?php } ?>
		setTabPushed( $('tab-project-list-obj'), 'project-gmap');
	} else if (type == 'users') {
		USER_ARGS['zoomtocountry'] = country;
		<?php if ($CFG->hasSocialTab) { ?>
			$('tab-social').setAttribute("href","#user-usergmap");
			Event.stopObserving('tab-social','click');
			Event.observe('tab-social','click', stpUserGMap);
		<?php } else { ?>
			$('tab-user').setAttribute("href","#user-usergmap");
			Event.stopObserving('tab-user','click');
			Event.observe('tab-user','click', stpUserGMap);
		<?php } ?>
		setTabPushed( $('tab-org-list-obj'), 'user-usergmap');
	}
}


function createCountryCloud(countries, type) {

	var cloud = "<ul>";

	var count = countries.length;
	if (count > 0) {
		var minCount = -1;
		var maxCount = -1;
		var range = 0;
		for( var i=0; i < count; i++) {
			var item = countries[i];
			var itemcount = item['UseCount'];
			if (itemcount > maxCount) {
				maxCount = itemcount;
			}
			if (minCount == -1) {
				minCount = itemcount;
			} else if (itemcount < minCount) {
				minCount = itemcount;
			}
		}

		if (maxCount < 10) {
			range = 1;
		} else {
			range = Math.round((maxCount - minCount) / 10);
		}

		for( var i=0; i < count; i++) {
			var item = countries[i];

			var cloudlistcolour = "";

			if ( (i % 2) == 1 ) {
				cloudlistcolour = "countrycloudcolor1";
			} else {
				cloudlistcolour = "countrycloudcolor2";
			}

			var itemcount = item['UseCount'];

			if (itemcount >= minCount && itemcount < minCount+range) {
				cloud +='<li onclick="gotoCountry(\''+type+'\', \''+item['Country']+'\')" class="tag1 still '+cloudlistcolour+'" title="'+itemcount+'">'+item['Country']+'</li>';
			} else if (itemcount >= minCount+(range*1) && itemcount < minCount+(range*2)) {
				cloud +='<li onclick="gotoCountry(\''+type+'\', \''+item['Country']+'\')" class="tag2 still '+cloudlistcolour+'" title="'+itemcount+'">'+item['Country']+'</li>';
			} else if (itemcount >= minCount+(range*2) && itemcount < minCount+(range*3)) {
				cloud +='<li  onclick="gotoCountry(\''+type+'\', \''+item['Country']+'\')" class="tag3 still '+cloudlistcolour+'" title="'+itemcount+'">'+item['Country']+'</li>';
			} else if (itemcount >= minCount+(range*3) && itemcount < minCount+(range*4)) {
				cloud +='<li onclick="gotoCountry(\''+type+'\', \''+item['Country']+'\')" class="tag4 still '+cloudlistcolour+'" title="'+itemcount+'">'+item['Country']+'</li>';
			} else if (itemcount >= minCount+(range*4) && itemcount < minCount+(range*5)) {
				cloud +='<li onclick="gotoCountry(\''+type+'\', \''+item['Country']+'\')" class="tag5 still '+cloudlistcolour+'" title="'+itemcount+'">'+item['Country']+'</li>';
			} else if (itemcount >= minCount+(range*5) && itemcount < minCount+(range*6)) {
				cloud +='<li onclick="gotoCountry(\''+type+'\', \''+item['Country']+'\')" class="tag6 still '+cloudlistcolour+'" title="'+itemcount+'">'+item['Country']+'</li>';
			} else if (itemcount >= minCount+(range*6) && itemcount < minCount+(range*7)) {
				cloud +='<li onclick="gotoCountry(\''+type+'\', \''+item['Country']+'\')" class="tag7 still '+cloudlistcolour+'" title="'+itemcount+'">'+item['Country']+'</li>';
			} else if (itemcount >= minCount+(range*7) && itemcount < minCount+(range*8)) {
				cloud +='<li onclick="gotoCountry(\''+type+'\', \''+item['Country']+'\')" class="tag8 still '+cloudlistcolour+'" title="'+itemcount+'">'+item['Country']+'</li>';
			} else if (itemcount >= minCount+(range*8) && itemcount < minCount+(range*9)) {
				cloud +='<li onclick="gotoCountry(\''+type+'\', \''+item['Country']+'\')" class="tag9 still '+cloudlistcolour+'" title="'+itemcount+'">'+item['Country']+'</li>';
			} else if (itemcount >= minCount+(range*9))  {
				cloud +='<li onclick="gotoCountry(\''+type+'\', \''+item['Country']+'\')" class="tag10 still '+cloudlistcolour+'" title="'+itemcount+'">'+item['Country']+'</li>';
			}
		}
	}

	cloud += "</ul>";

	return cloud;
}

// LOAD LISTS///

/**
 *	load next/previous set of nodes
 */
function loadchallenges(context,args){
	args['filternodetypes'] = "Challenge";

	updateAddressParameters(args);

	$("tab-content-challenge-list").update(getLoading("<?php echo$LNG->LOADING_CHALLENGES; ?>"));

	var reqUrl = SERVICE_ROOT + "&method=getnodesby" + context + "&" + Object.toQueryString(args);

	new Ajax.Request(reqUrl, { method:'get',
  			onSuccess: function(transport){

  				try {
  					var json = transport.responseText.evalJSON();
  				} catch(err) {
  					console.log(err);
  				}

      			if(json.error){
      				alert(json.error[0].message);
      				return;
      			}

      			//set the count in tab header
      			//$('challenge-list-count').innerHTML = "";
      			//$('challenge-list-count').insert("("+json.nodeset[0].totalno+")");

      			//$('challengebuttons').innerHTML = "";

				//display nav
				var total = json.nodeset[0].totalno;
				if (CURRENT_VIZ == 'list') {
					var currentPage = (json.nodeset[0].start/args["max"]) + 1;
					window.location.hash = CURRENT_TAB+"-"+CURRENT_VIZ+"-"+currentPage;
				}
				$("tab-content-challenge-list").update(createNav(total,json.nodeset[0].start,json.nodeset[0].count,args,context,"challenges"));

				//display nodes
				if(json.nodeset[0].nodes.length > 0){
					//preprosses nodes to add searchid if it is there
					if (args['searchid'] && args['searchid'] != "") {
						var nodes = json.nodeset[0].nodes;
						var count = nodes.length;
						for (var i=0; i < count; i++) {
							var node = nodes[i];
							node.cnode.searchid = args['searchid'];
						}
					}

					var tb3 = new Element("div", {'class':'toolbarrow row'});

					var sortOpts = {date: '<?php echo $LNG->SORT_CREATIONDATE; ?>', name: '<?php echo $LNG->SORT_TITLE; ?>', moddate: '<?php echo $LNG->SORT_MODDATE; ?>',connectedness:'<?php echo $LNG->SORT_CONNECTIONS; ?>', vote:'<?php echo $LNG->SORT_VOTES; ?>'};
					tb3.insert(displaySortForm(sortOpts,args,'challenge',reorderChallenges));
					tb3.insert(createThemeFilter(context, args, 'challenges'));
					tb3.insert(createConnectedFilter(context, args, 'challenges'));

					$("tab-content-challenge-list").insert(tb3);

					displayNodes($("tab-content-challenge-list"),json.nodeset[0].nodes,parseInt(args['start'])+1, true);
				} else {
					var tb3 = new Element("div", {'class':'toolbarrow row'});
					tb3.insert(createThemeFilter(context, args, 'challenges'));
					tb3.insert(createConnectedFilter(context, args, 'challenges'));
					$("tab-content-challenge-list").insert(tb3);
				}

				//display nav
				if (total > parseInt( args["max"] )) {
					$("tab-content-challenge-list").insert(createNav(total,json.nodeset[0].start,json.nodeset[0].count,args,context,"challenges"));
				}
    		}
  		});
  	DATA_LOADED.challenge = true;
  	DATA_LOADED.challengesimile = false;
}

/**
 *	load next/previous set of organisation nodes
 */
function loadorgs(context,args){

	var types = "Organization";

	if (args['filternodetypes'] == "" || types.indexOf(args['filternodetypes']) == -1) {
		args['filternodetypes'] = types;
	}

	updateAddressParameters(args);

	$("tab-content-org-list").update(getLoading("<?php echo $LNG->LOADING_ORGS; ?>"));

	var reqUrl = SERVICE_ROOT + "&method=getnodesby" + context + "&" + Object.toQueryString(args);

	new Ajax.Request(reqUrl, { method:'get',
  			onSuccess: function(transport){

  				try {
  					var json = transport.responseText.evalJSON();
  				} catch(err) {
  					console.log(err);
  				}

      			if(json.error){
      				alert(json.error[0].message);
      				return;
      			}

      			//set the count in tab header
      			//$('org-list-count').innerHTML = "";
      			//$('org-list-count').insert("("+json.nodeset[0].totalno+")");

      			//$('orgbuttons').innerHTML = "";

				var total = json.nodeset[0].totalno;
				if (CURRENT_VIZ == 'list') {
					var currentPage = (json.nodeset[0].start/args["max"]) + 1;
					window.location.hash = CURRENT_TAB+"-"+CURRENT_VIZ+"-"+currentPage;
				}
				var navbar = createNav(total,json.nodeset[0].start,json.nodeset[0].count,args,context,"orgs")

				$("tab-content-org-list").update(navbar);

				//display nodes
				if(json.nodeset[0].nodes.length > 0){
					//preprosses nodes to add searchid if it is there
					if (args['searchid'] && args['searchid'] != "") {
						var nodes = json.nodeset[0].nodes;
						var count = nodes.length;
						for (var i=0; i < count; i++) {
							var node = nodes[i];
							node.cnode.searchid = args['searchid'];
						}
					}

					var tb3 = new Element("div", {'class':'toolbarrow row'});

					var sortOpts = {date: '<?php echo $LNG->SORT_CREATIONDATE; ?>', name: '<?php echo $LNG->SORT_TITLE; ?>', moddate: '<?php echo $LNG->SORT_MODDATE; ?>',connectedness:'<?php echo $LNG->SORT_CONNECTIONS; ?>'};
					tb3.insert(displaySortForm(sortOpts,args,'org',reorderOrgs));
					tb3.insert(createThemeFilter(context, args, 'orgs'));
					tb3.insert(createConnectedFilter(context, args, 'orgs'));

					$("tab-content-org-list").insert(tb3);
					displayNodes($("tab-content-org-list"),json.nodeset[0].nodes,parseInt(args['start'])+1, true);
				} else {
					var tb3 = new Element("div", {'class':'toolbarrow row'});
					tb3.insert(createThemeFilter(context, args, 'orgs'));
					tb3.insert(createConnectedFilter(context, args, 'orgs'));
					$("tab-content-org-list").insert(tb3);
				}

				//display nav
				if (total > parseInt( args["max"] )) {
					$("tab-content-org-list").insert(createNav(total,json.nodeset[0].start,json.nodeset[0].count,args,context,"orgs"));
				}
    		}
  		});
  	DATA_LOADED.org = true;
  	DATA_LOADED.orgsimile = false;
}

/**
 *	load next/previous set of project nodes
 */
function loadprojects(context,args){

	var types = "Project";

	if (args['filternodetypes'] == "" || types.indexOf(args['filternodetypes']) == -1) {
		args['filternodetypes'] = types;
	}

	updateAddressParameters(args);

	$("tab-content-project-list").update(getLoading("<?php echo $LNG->LOADING_PROJECTS; ?>"));

	var reqUrl = SERVICE_ROOT + "&method=getnodesby" + context + "&" + Object.toQueryString(args);

	new Ajax.Request(reqUrl, { method:'get',
  			onSuccess: function(transport){

  				try {
  					var json = transport.responseText.evalJSON();
  				} catch(err) {
  					console.log(err);
  				}

      			if(json.error){
      				alert(json.error[0].message);
      				return;
      			}

      			//set the count in tab header
      			//$('project-list-count').innerHTML = "";
      			//$('project-list-count').insert("("+json.nodeset[0].totalno+")");
      			//$('orgbuttons').innerHTML = "";

				var total = json.nodeset[0].totalno;
				if (CURRENT_VIZ == 'list') {
					var currentPage = (json.nodeset[0].start/args["max"]) + 1;
					window.location.hash = CURRENT_TAB+"-"+CURRENT_VIZ+"-"+currentPage;
				}
				var navbar = createNav(total,json.nodeset[0].start,json.nodeset[0].count,args,context,"projects")

				$("tab-content-project-list").update(navbar);

				//display nodes
				if(json.nodeset[0].nodes.length > 0){
					//preprosses nodes to add searchid if it is there
					if (args['searchid'] && args['searchid'] != "") {
						var nodes = json.nodeset[0].nodes;
						var count = nodes.length;
						for (var i=0; i < count; i++) {
							var node = nodes[i];
							node.cnode.searchid = args['searchid'];
						}
					}

					var tb3 = new Element("div", {'class':'toolbarrow row'});

					var sortOpts = {date: '<?php echo $LNG->SORT_CREATIONDATE; ?>', name: '<?php echo $LNG->SORT_TITLE; ?>', moddate: '<?php echo $LNG->SORT_MODDATE; ?>',connectedness:'<?php echo $LNG->SORT_CONNECTIONS; ?>'};
					tb3.insert(displaySortForm(sortOpts,args,'project',reorderProjects));
					tb3.insert(createThemeFilter(context, args, 'projects'));
					tb3.insert(createConnectedFilter(context, args, 'projects'));

					$("tab-content-project-list").insert(tb3);
					displayNodes($("tab-content-project-list"),json.nodeset[0].nodes,parseInt(args['start'])+1, true);
				} else {
					var tb3 = new Element("div", {'class':'toolbarrow row'});
					tb3.insert(createThemeFilter(context, args, 'projects'));
					tb3.insert(createConnectedFilter(context, args, 'projects'));
					$("tab-content-project-list").insert(tb3);
				}

				//display nav
				if (total > parseInt( args["max"] )) {
					$("tab-content-org-list").insert(createNav(total,json.nodeset[0].start,json.nodeset[0].count,args,context,"projects"));
				}
    		}
  		});
  	DATA_LOADED.project = true;
}

/**
 *	load next/previous set of nodes
 */
function loadissues(context,args){
	args['filternodetypes'] = "Issue";

	updateAddressParameters(args);

	$("tab-content-issue-list").update(getLoading("<?php echo $LNG->LOADING_ISSUES; ?>"));

	var reqUrl = SERVICE_ROOT + "&method=getnodesby" + context + "&" + Object.toQueryString(args);

	new Ajax.Request(reqUrl, { method:'get',
  			onSuccess: function(transport){

  				try {
  					var json = transport.responseText.evalJSON();
  				} catch(err) {
  					console.log(err);
  				}

      			if(json.error){
      				alert(json.error[0].message);
      				return;
      			}

      			//set the count in tab header
      			//$('issue-list-count').innerHTML = "";
      			//$('issue-list-count').insert("("+json.nodeset[0].totalno+")");

      			//$('issuebuttons').innerHTML = "";

				//display nav
				var total = json.nodeset[0].totalno;
				if (CURRENT_VIZ == 'list') {
					var currentPage = (json.nodeset[0].start/args["max"]) + 1;
					window.location.hash = CURRENT_TAB+"-"+CURRENT_VIZ+"-"+currentPage;
				}
				$("tab-content-issue-list").update(createNav(total,json.nodeset[0].start,json.nodeset[0].count,args,context,"issues"));

				//display nodes
				if(json.nodeset[0].nodes.length > 0){

					//preprosses nodes to add searchid if it is there
					if (args['searchid'] && args['searchid'] != "") {
						var nodes = json.nodeset[0].nodes;
						var count = nodes.length;
						for (var i=0; i < count; i++) {
							var node = nodes[i];
							node.cnode.searchid = args['searchid'];
						}
					}

					var tb3 = new Element("div", {'class':'toolbarrow row'});

					var sortOpts = {date: '<?php echo $LNG->SORT_CREATIONDATE; ?>', name: '<?php echo $LNG->SORT_TITLE; ?>', moddate: '<?php echo $LNG->SORT_MODDATE; ?>',connectedness:'<?php echo $LNG->SORT_CONNECTIONS; ?>', vote:'<?php echo $LNG->SORT_VOTES; ?>'};
					tb3.insert(displaySortForm(sortOpts,args,'issue',reorderIssues));
					tb3.insert(createThemeFilter(context, args, 'issues'));
					tb3.insert(createConnectedFilter(context, args, 'issues'));

					$("tab-content-issue-list").insert(tb3);

					displayNodes($("tab-content-issue-list"),json.nodeset[0].nodes,parseInt(args['start'])+1, true);
				} else {
					var tb3 = new Element("div", {'class':'toolbarrow row'});
					tb3.insert(createThemeFilter(context, args, 'issues'));
					tb3.insert(createConnectedFilter(context, args, 'issues'));
					$("tab-content-issue-list").insert(tb3);
				}

				//display nav
				if (total > parseInt( args["max"] )) {
					$("tab-content-issue-list").insert(createNav(total,json.nodeset[0].start,json.nodeset[0].count,args,context,"issues"));
				}
    		}
  		});
  	DATA_LOADED.issue = true;
  	DATA_LOADED.issuesimile = false;
}

/**
 *	load next/previous set of nodes
 */
function loadsolutions(context,args){
	args['filternodetypes'] = "Solution";

	updateAddressParameters(args);

	$("tab-content-solution-list").update(getLoading("<?php echo $LNG->LOADING_SOLUTIONS; ?>"));

	var reqUrl = SERVICE_ROOT + "&method=getnodesby" + context + "&" + Object.toQueryString(args);

	new Ajax.Request(reqUrl, { method:'get',
  			onSuccess: function(transport){

  				try {
  					var json = transport.responseText.evalJSON();
  				} catch(err) {
  					console.log(err);
  				}

      			if(json.error){
      				alert(json.error[0].message);
      				return;
      			}

      			//set the count in tab header
      			//$('solution-list-count').innerHTML = "";
      			//$('solution-list-count').insert("("+json.nodeset[0].totalno+")");

      			//$('solutionbuttons').innerHTML = "";

				//display nav
				var total = json.nodeset[0].totalno;
				if (CURRENT_VIZ == 'list') {
					var currentPage = (json.nodeset[0].start/args["max"]) + 1;
					window.location.hash = CURRENT_TAB+"-"+CURRENT_VIZ+"-"+currentPage;
				}
				$("tab-content-solution-list").update(createNav(total,json.nodeset[0].start,json.nodeset[0].count,args,context,"solutions"));

				if(json.nodeset[0].nodes.length > 0){
					//preprosses nodes to add searchid if it is there
					if (args['searchid'] && args['searchid'] != "") {
						var nodes = json.nodeset[0].nodes;
						var count = nodes.length;
						for (var i=0; i < count; i++) {
							var node = nodes[i];
							node.cnode.searchid = args['searchid'];
						}
					}

					var tb3 = new Element("div", {'class':'toolbarrow row'});

					var sortOpts = {date: '<?php echo $LNG->SORT_CREATIONDATE; ?>', name: '<?php echo $LNG->SORT_TITLE; ?>', moddate: '<?php echo $LNG->SORT_MODDATE; ?>',connectedness:'<?php echo $LNG->SORT_CONNECTIONS; ?>', vote:'<?php echo $LNG->SORT_VOTES; ?>'};
					tb3.insert(displaySortForm(sortOpts,args,'solution',reorderSolutions));
					tb3.insert(createThemeFilter(context, args, 'solutions'));
					tb3.insert(createConnectedFilter(context, args, 'solutions'));

					$("tab-content-solution-list").insert(tb3);
					displayNodes($("tab-content-solution-list"),json.nodeset[0].nodes,parseInt(args['start'])+1, true);
				} else {
					var tb3 = new Element("div", {'class':'toolbarrow row'});
					tb3.insert(createThemeFilter(context, args, 'solutions'));
					tb3.insert(createConnectedFilter(context, args, 'solutions'));
					$("tab-content-solution-list").insert(tb3);
				}

				//display nav
				if (total > parseInt( args["max"] )) {
					$("tab-content-solution-list").insert(createNav(total,json.nodeset[0].start,json.nodeset[0].count,args,context,"solutions"));
				}
    		}
  		});
  	DATA_LOADED.solution = true;
  	DATA_LOADED.solutionsimile = false;
}

/**
 *	load next/previous set of nodes
 */
function loadclaims(context,args){
	args['filternodetypes'] = "Claim";

	updateAddressParameters(args);

	$("tab-content-claim-list").update(getLoading("<?php echo $LNG->LOADING_CLAIMS; ?>"));

	var reqUrl = SERVICE_ROOT + "&method=getnodesby" + context + "&" + Object.toQueryString(args);

	new Ajax.Request(reqUrl, { method:'get',
  			onSuccess: function(transport){

  				try {
  					var json = transport.responseText.evalJSON();
  				} catch(err) {
  					console.log(err);
  				}

      			if(json.error){
      				alert(json.error[0].message);
      				return;
      			}

      			//set the count in tab header
      			//$('claim-list-count').innerHTML = "";
      			//$('claim-list-count').insert("("+json.nodeset[0].totalno+")");

  				//$('claimbuttons').innerHTML = "";

				//display nav
				var total = json.nodeset[0].totalno;
				if (CURRENT_VIZ == 'list') {
					var currentPage = (json.nodeset[0].start/args["max"]) + 1;
					window.location.hash = CURRENT_TAB+"-"+CURRENT_VIZ+"-"+currentPage;
				}
				$("tab-content-claim-list").update(createNav(total,json.nodeset[0].start,json.nodeset[0].count,args,context,"claims"));

				if(json.nodeset[0].nodes.length > 0){
					//preprosses nodes to add searchid if it is there
					if (args['searchid'] && args['searchid'] != "") {
						var nodes = json.nodeset[0].nodes;
						var count = nodes.length;
						for (var i=0; i < count; i++) {
							var node = nodes[i];
							node.cnode.searchid = args['searchid'];
						}
					}

					var tb3 = new Element("div", {'class':'toolbarrow row'});

					var sortOpts = {date: '<?php echo $LNG->SORT_CREATIONDATE; ?>', name: '<?php echo $LNG->SORT_TITLE; ?>', moddate: '<?php echo $LNG->SORT_MODDATE; ?>',connectedness:'<?php echo $LNG->SORT_CONNECTIONS; ?>', vote:'<?php echo $LNG->SORT_VOTES; ?>'};
					tb3.insert(displaySortForm(sortOpts,args,'claim',reorderClaims));
					tb3.insert(createThemeFilter(context, args, 'claims'));
					tb3.insert(createConnectedFilter(context, args, 'claims'));

					$("tab-content-claim-list").insert(tb3);
					displayNodes($("tab-content-claim-list"),json.nodeset[0].nodes,parseInt(args['start'])+1, true);
				} else {
					var tb3 = new Element("div", {'class':'toolbarrow row'});
					tb3.insert(createThemeFilter(context, args, 'claims'));
					tb3.insert(createConnectedFilter(context, args, 'claims'));
					$("tab-content-claim-list").insert(tb3);
				}

				//display nav
				if (total > parseInt( args["max"] )) {
					$("tab-content-claim-list").insert(createNav(total,json.nodeset[0].start,json.nodeset[0].count,args,context,"claims"));
				}
    		}
  		});
  	DATA_LOADED.claim = true;
  	DATA_LOADED.claimsimile = false;
}

/**
 *	load next/previous set of evidence nodes
 */
function loadevidence(context,args) {

	var types = EVIDENCE_TYPES_STR;

	if (args['filternodetypes'] == "" || types.indexOf(args['filternodetypes']) == -1) {
		args['filternodetypes'] = types;
	}

	updateAddressParameters(args);

	$("tab-content-evidence-list").update(getLoading("<?php echo $LNG->LOADING_EVIDENCES; ?>"));

	var reqUrl = SERVICE_ROOT + "&method=getnodesby" + context + "&" + Object.toQueryString(args);

	new Ajax.Request(reqUrl, { method:'get',
  			onSuccess: function(transport){

  				try {
  					var json = transport.responseText.evalJSON();
  				} catch(err) {
  					console.log(err);
  				}

      			if(json.error){
      				alert(json.error[0].message);
      				return;
      			}

      			//set the count in tab header
      			//$('evidence-list-count').innerHTML = "";
      			//$('evidence-list-count').insert("("+json.nodeset[0].totalno+")");

      			//$('evidencebuttons').innerHTML = "";

				//display nav
				var total = json.nodeset[0].totalno;
				if (CURRENT_VIZ == 'list') {
					var currentPage = (json.nodeset[0].start/args["max"]) + 1;
					window.location.hash = CURRENT_TAB+"-"+CURRENT_VIZ+"-"+currentPage;
				}

				$("tab-content-evidence-list").update(createNav(total,json.nodeset[0].start,json.nodeset[0].count,args,context,"evidence"));

				if(json.nodeset[0].nodes.length > 0){
					//preprosses nodes to add searchid if it is there
					if (args['searchid'] && args['searchid'] != "") {
						var nodes = json.nodeset[0].nodes;
						var count = nodes.length;
						for (var i=0; i < count; i++) {
							var node = nodes[i];
							node.cnode.searchid = args['searchid'];
						}
					}

					var tb3 = new Element("div", {'class':'toolbarrow row'});

					var sortOpts = {date: '<?php echo $LNG->SORT_CREATIONDATE; ?>', name: '<?php echo $LNG->SORT_TITLE; ?>', moddate: '<?php echo $LNG->SORT_MODDATE; ?>',connectedness:'<?php echo $LNG->SORT_CONNECTIONS; ?>', vote:'<?php echo $LNG->SORT_VOTES; ?>'};
					tb3.insert(displaySortForm(sortOpts,args,'evidence',reorderEvidence));

					tb3.insert(createThemeFilter(context, args, 'evidence'));
					tb3.insert(createEvidenceFilter(context, args));
					tb3.insert(createConnectedFilter(context, args, 'evidence'));

					$("tab-content-evidence-list").insert(tb3);
					displayNodes($("tab-content-evidence-list"),json.nodeset[0].nodes,parseInt(args['start'])+1, true);
				} else {
					// in case caused by filter.
					var tb3 = new Element("div", {'class':'toolbarrow row'});
					tb3.insert(createThemeFilter(context, args, 'evidence'));
					tb3.insert(createEvidenceFilter(context, args));
					tb3.insert(createConnectedFilter(context, args, 'evidence'));
					$("tab-content-evidence-list").insert(tb3);
				}

				//display nav
				if (total > parseInt( args["max"] )) {
					$("tab-content-evidence-list").insert(createNav(total,json.nodeset[0].start,json.nodeset[0].count,args,context,"evidence"));
				}
    		}
  		});
  	DATA_LOADED.evidence = true;
  	DATA_LOADED.evidencesimile = false;
}

/**
 *	load next/previous set of urls
 */
function loadurls(context,args){
	var types = RESOURCE_TYPES_STR;

	if (args['filternodetypes'] == "" || types.indexOf(args['filternodetypes']) == -1) {
		args['filternodetypes'] = types;
	}

	updateAddressParameters(args);

	$("tab-content-web-list").update(getLoading("<?php echo $LNG->LOADING_RESOURCES; ?>"));

	var reqUrl = SERVICE_ROOT + "&method=getnodesby" + context + "&" + Object.toQueryString(args);

	new Ajax.Request(reqUrl, { method:'get',
  			onSuccess: function(transport){
  				var json = transport.responseText.evalJSON();
      			if(json.error){
      				alert(json.error[0].message);
      				return;
      			}

      			//set the count in tab header
      			//$('web-list-count').innerHTML = "";
      			//$('web-list-count').insert("("+json.nodeset[0].totalno+")");

      			//$('webbuttons').innerHTML = "";

				//display nav
				var total = json.nodeset[0].totalno;

				if (CURRENT_VIZ == 'list') {
					var currentPage = (json.nodeset[0].start/args["max"]) + 1;
					window.location.hash = CURRENT_TAB+"-"+CURRENT_VIZ+"-"+currentPage;
				}

				$("tab-content-web-list").update(createNav(total,json.nodeset[0].start,json.nodeset[0].count,args,context,"urls"));
				$("tab-content-web-list").insert('<div style="clear: both; margin:0px; padding: 0px;"></div>');

				if(total > 0){
					//preprosses nodes to add searchid if it is there
					if (args['searchid'] && args['searchid'] != "") {
						var nodes = json.nodeset[0].nodes;
						var count = nodes.length;
						for (var i=0; i < count; i++) {
							var node = nodes[i];
							node.cnode.searchid = args['searchid'];
						}
					}

					var tb2 = new Element("div", {'class':'toolbarrow row'});

					var sortOpts = {date: '<?php echo $LNG->SORT_CREATIONDATE; ?>', name: '<?php echo $LNG->SORT_TITLE; ?>', moddate: '<?php echo $LNG->SORT_MODDATE; ?>',connectedness:'<?php echo $LNG->SORT_CONNECTIONS; ?>'};
					tb2.insert(displaySortForm(sortOpts,args,'urls',reorderURLs));

					tb2.insert(createThemeFilter(context, args, 'web'));
					tb2.insert(createResourceFilter(context, args));
					tb2.insert(createConnectedFilter(context, args, 'web'));

					$("tab-content-web-list").insert(tb2);
					displayNodes($("tab-content-web-list"),json.nodeset[0].nodes,parseInt(args['start'])+1, true);
				} else {
					// in case caused by filter.
					var tb2 = new Element("div", {'class':'toolbarrow row'});

					tb2.insert(createThemeFilter(context, args, 'web'));
					tb2.insert(createResourceFilter(context, args));
					tb2.insert(createConnectedFilter(context, args, 'web'));

					$("tab-content-web-list").insert(tb2);
				}

				//display nav
				if (total > parseInt( args["max"] )) {
					$("tab-content-web-list").insert(createNav(total,json.nodeset[0].start,json.nodeset[0].count,args,context,"urls"));
				}

    		}
  		});
	DATA_LOADED.url = true;
}

/**
 *	load next/previous set of users
 */
function loadusers(context,args){

	updateAddressParameters(args);

	$("tab-content-user-list").update(getLoading("<?php echo $LNG->LOADING_USERS; ?>"));

	var reqUrl = SERVICE_ROOT + "&method=getusersby" + context + "&includegroups=false&" + Object.toQueryString(args);

	new Ajax.Request(reqUrl, { method:'get',
			onError: function(error) {
				alert(error);
			},
  			onSuccess: function(transport){
  				var json = transport.responseText.evalJSON();
      			if(json.error){
      				alert(json.error[0].message);
      				return;
      			}

      			//set the count in tab header
      			//$('user-list-count').innerHTML = "";
      			//$('user-list-count').insert("("+json.userset[0].totalno+")");

				$("tab-content-user-list").innerHTML = "";

				var tb1 = new Element("div", {'class':'toolbarrow row'});
				$("tab-content-user-list").insert(tb1);

				//display nav
				var total = json.userset[0].totalno;

				if (CURRENT_VIZ == 'list') {
					var currentPage = (json.userset[0].start/args["max"]) + 1;
					window.location.hash = CURRENT_TAB+"-"+CURRENT_VIZ+"-"+currentPage;
				}

				$("tab-content-user-list").update(createNav(total,json.userset[0].start,json.userset[0].count,args,context,"users"));
				$("tab-content-user-list").insert('<div style="clear: both; margin:0px; padding: 0px;"></div>');

				if(json.userset[0].count > 0){
					//preprosses nodes to add searchid if it is there
					if (args['searchid'] && args['searchid'] != "") {
						var users = json.userset[0].users;
						var count = users.length;
						for (var i=0; i < count; i++) {
							var user = users[i].user;
							user.searchid = args['searchid'];
						}
					}

					var tb2 = new Element("div", {'class':'toolbarrow row'});
					var sortOpts = {lastactive: '<?php echo $LNG->SORT_LAST_ACTIVE; ?>', name: '<?php echo $LNG->SORT_NAME; ?>', date: '<?php echo $LNG->SORT_DATE_JOINED; ?>'};
					tb2.insert(displaySortForm(sortOpts,args,'user',reorderUsers));
					$("tab-content-user-list").insert(tb2);
					$("tab-content-user-list").insert("<br><br>");
					displayUsers($("tab-content-user-list"),json.userset[0].users,parseInt(args['start'])+1);
				}

				//display nav
				if (total > parseInt( args["max"] )) {
					$("tab-content-user-list").insert(createNav(total,json.userset[0].start,json.userset[0].count,args,context,"users"));
				}
    		}
  		});
  	DATA_LOADED.user = true;
}

/**
 *	load next/previous set of comment nodes
 */
function loadcomments(context,args) {

	var types = 'Idea';

	if (args['filternodetypes'] == "" || types.indexOf(args['filternodetypes']) == -1) {
		args['filternodetypes'] = types;
	}

	updateAddressParameters(args);

	$("tab-content-comment-list").update(getLoading("<?php echo $LNG->LOADING_COMMENTS; ?>"));

	var reqUrl = SERVICE_ROOT + "&method=getconnectednodesby" + context + "&" + Object.toQueryString(args);

	//alert(reqUrl);
	new Ajax.Request(reqUrl, { method:'post',
		onSuccess: function(transport){

			try {
				var json = transport.responseText.evalJSON();
			} catch(err) {
				console.log(err);
			}

			if(json.error){
				alert(json.error[0].message);
				return;
			}

			var count = 0;
			if (json.nodeset[0].totalno) {
				count = json.nodeset[0].totalno;
			}

			//set the count in tab header
			//if ($('comment-list-count')) {
			//	$('comment-list-count').innerHTML = "";
			//	$('comment-list-count').insert("("+count+")");
			//}

			var nodes = json.nodeset[0].nodes;

			//display nav
			var total = json.nodeset[0].totalno;

			if (CURRENT_VIZ == 'list') {
				var currentPage = (json.nodeset[0].start/args["max"]) + 1;
				window.location.hash = CURRENT_TAB+"-"+CURRENT_VIZ+"-"+currentPage;
			}

			$("tab-content-comment-list").update(createNav(total,json.nodeset[0].start,json.nodeset[0].count,args,context,"comments"));

			if(nodes.length > 0){
				//preprosses nodes to add searchid if it is there
				if (args['searchid'] && args['searchid'] != "") {
					var count = nodes.length;
					for (var i=0; i < count; i++) {
						var node = nodes[i];
						node.cnode.searchid = args['searchid'];
					}
				}

				var tb3 = new Element("div", {'class':'toolbarrow row'});

				var sortOpts = {date: '<?php echo $LNG->SORT_CREATIONDATE; ?>', name: '<?php echo $LNG->SORT_TITLE; ?>'};
				tb3.insert(displaySortForm(sortOpts,args,'comment',reorderComments));

				var filter = createCommentFilter(context, args);
				tb3.insert(filter);

				$("tab-content-comment-list").insert(tb3);

				displayNodes($("tab-content-comment-list"),nodes,parseInt(args['start'])+1, true);
			} else {
				var tb3 = new Element("div", {'class':'toolbarrow row'});
				var filter = createCommentFilter(context, args);
				tb3.insert(filter);
				$("tab-content-comment-list").insert(tb3);
			}

			//display nav
			if (total > parseInt( args["max"] )) {
				$("tab-content-comment-list").insert(createNav(total,json.nodeset[0].start,json.nodeset[0].count,args,context,"comments"));
			}
		}
	});

  	DATA_LOADED.commentlist = true;
}


/**
 *	load next/previous set of news nodes
 */
function loadnews(context,args) {

	var types = 'News';
	args['filternodetypes'] = types;
	updateAddressParameters(args);

	$("tab-content-news-list").update(getLoading("<?php echo $LNG->LOADING_NEWS; ?>"));

	var reqUrl = SERVICE_ROOT + "&method=getnodesby" + context + "&" + Object.toQueryString(args);
	//alert(reqUrl);
	new Ajax.Request(reqUrl, { method:'post',
		onSuccess: function(transport){

			try {
				var json = transport.responseText.evalJSON();
			} catch(err) {
				console.log(err);
			}

			if(json.error){
				alert(json.error[0].message);
				return;
			}

			var count = 0;
			if (json.nodeset[0].totalno) {
				count = json.nodeset[0].totalno;
			}

			var nodes = json.nodeset[0].nodes;

			//display nav
			var total = json.nodeset[0].totalno;

			if (CURRENT_VIZ == 'list') {
				var currentPage = (json.nodeset[0].start/args["max"]) + 1;
				window.location.hash = CURRENT_TAB+"-"+CURRENT_VIZ+"-"+currentPage;
			}

			$("tab-content-news-list").update(createNav(total,json.nodeset[0].start,json.nodeset[0].count,args,context,"comments"));

			if(nodes.length > 0){
				//preprosses nodes to add searchid if it is there
				if (args['searchid'] && args['searchid'] != "") {
					var count = nodes.length;
					for (var i=0; i < count; i++) {
						var node = nodes[i];
						node.cnode.searchid = args['searchid'];
					}
				}

				var tb3 = new Element("div", {'class':'toolbarrow row'});

				var sortOpts = {date: '<?php echo $LNG->SORT_CREATIONDATE; ?>', name: '<?php echo $LNG->SORT_TITLE; ?>'};
				tb3.insert(displaySortForm(sortOpts,args,'news',reorderNews));

				$("tab-content-news-list").insert(tb3);

				displayNewsNodes($("tab-content-news-list"),nodes);
			}

			//display nav
			if (total > parseInt( args["max"] )) {
				$("tab-content-news-list").insert(createNav(total,json.nodeset[0].start,json.nodeset[0].count,args,context,"news"));
			}
		}
	});

  	DATA_LOADED.newslist = true;
}

/**
 *	Reorder the challenge tab
 */
function reorderChallenges(){
 	// change the sort and orderby ARG values
 	CHALLENGE_ARGS['start'] = 0;
 	CHALLENGE_ARGS['sort'] = $('select-sort-challenge').options[$('select-sort-challenge').selectedIndex].value;
 	CHALLENGE_ARGS['orderby'] = $('select-orderby-challenge').options[$('select-orderby-challenge').selectedIndex].value;

 	loadchallenges(CONTEXT,CHALLENGE_ARGS);
}

/**
 *	Reorder the org tab
 */
function reorderOrgs(){
	// change the sort and orderby ARG values
	ORG_ARGS['start'] = 0;
	ORG_ARGS['sort'] = $('select-sort-org').options[$('select-sort-org').selectedIndex].value;
	ORG_ARGS['orderby'] = $('select-orderby-org').options[$('select-orderby-org').selectedIndex].value;

	loadorgs(CONTEXT,ORG_ARGS);
}

/**
 *	Reorder the projects tab
 */
function reorderProjects(){
	// change the sort and orderby ARG values
	PROJECT_ARGS['start'] = 0;
	PROJECT_ARGS['sort'] = $('select-sort-project').options[$('select-sort-project').selectedIndex].value;
	PROJECT_ARGS['orderby'] = $('select-orderby-project').options[$('select-orderby-project').selectedIndex].value;

	loadprojects(CONTEXT,PROJECT_ARGS);
}

/**
*	Reorder the issue tab
*/
function reorderIssues(){
 	// change the sort and orderby ARG values
 	ISSUE_ARGS['start'] = 0;
 	ISSUE_ARGS['sort'] = $('select-sort-issue').options[$('select-sort-issue').selectedIndex].value;
 	ISSUE_ARGS['orderby'] = $('select-orderby-issue').options[$('select-orderby-issue').selectedIndex].value;

 	loadissues(CONTEXT,ISSUE_ARGS);
}


/**
 *	Reorder the solutions tab
 */
function reorderSolutions(){
	// change the sort and orderby ARG values
	SOLUTION_ARGS['start'] = 0;
	SOLUTION_ARGS['sort'] = $('select-sort-solution').options[$('select-sort-solution').selectedIndex].value;
	SOLUTION_ARGS['orderby'] = $('select-orderby-solution').options[$('select-orderby-solution').selectedIndex].value;

	loadsolutions(CONTEXT,SOLUTION_ARGS);
}

/**
 *	Reorder the claims tab
 */
function reorderClaims(){
	// change the sort and orderby ARG values
	CLAIM_ARGS['start'] = 0;
	CLAIM_ARGS['sort'] = $('select-sort-claim').options[$('select-sort-claim').selectedIndex].value;
	CLAIM_ARGS['orderby'] = $('select-orderby-claim').options[$('select-orderby-claim').selectedIndex].value;

	loadclaims(CONTEXT,CLAIM_ARGS);
}

/**
 *	Reorder the evidence tab
 */
function reorderEvidence(){
	// change the sort and orderby ARG values
	EVIDENCE_ARGS['start'] = 0;
	EVIDENCE_ARGS['sort'] = $('select-sort-evidence').options[$('select-sort-evidence').selectedIndex].value;
	EVIDENCE_ARGS['orderby'] = $('select-orderby-evidence').options[$('select-orderby-evidence').selectedIndex].value;

	loadevidence(CONTEXT,EVIDENCE_ARGS);
}

/**
 *	Reorder the urls tab
 */
function reorderURLs(){
	// change the sort and orderby ARG values
	URL_ARGS['start'] = 0;
	URL_ARGS['sort'] = $('select-sort-urls').options[$('select-sort-urls').selectedIndex].value;
	URL_ARGS['orderby'] = $('select-orderby-urls').options[$('select-orderby-urls').selectedIndex].value;

	loadurls(CONTEXT,URL_ARGS);
}

/**
 *	Reorder the users tab
 */
function reorderUsers(){
	// change the sort and orderby ARG values
	USER_ARGS['start'] = 0;
	USER_ARGS['sort'] = $('select-sort-user').options[$('select-sort-user').selectedIndex].value;
	USER_ARGS['orderby'] = $('select-orderby-user').options[$('select-orderby-user').selectedIndex].value;

	loadusers(CONTEXT,USER_ARGS);
}

/**
 *	Reorder the comments tab
 */
function reorderComments(){
	// change the sort and orderby ARG values
	COMMENT_ARGS['start'] = 0;
	COMMENT_ARGS['sort'] = $('select-sort-comment').options[$('select-sort-comment').selectedIndex].value;
	COMMENT_ARGS['orderby'] = $('select-orderby-comment').options[$('select-orderby-comment').selectedIndex].value;

	loadcomments(CONTEXT,COMMENT_ARGS);
}

/**
 *	Reorder the news tab
 */
function reorderNews(){
	// change the sort and orderby ARG values
	NEWS_ARGS['start'] = 0;
	NEWS_ARGS['sort'] = $('select-sort-news').options[$('select-sort-news').selectedIndex].value;
	NEWS_ARGS['orderby'] = $('select-orderby-news').options[$('select-orderby-news').selectedIndex].value;

	loadnews(CONTEXT,NEWS_ARGS);
}

/**
 *	Filter the challenges by search criteria
 */
 function filterSearchChallenges() {
 	CHALLENGE_ARGS['q'] = $('qchallenge').value;
 	var scope = 'all';
 	if ($('scopechallengemy') && $('scopechallengemy').selected) {
 		scope = 'my';
 	}
 	CHALLENGE_ARGS['scope'] = scope;

	var reqUrl = SERVICE_ROOT + "&method=auditsearch&type=challenge&format=text&q="+CHALLENGE_ARGS['q'];
	new Ajax.Request(reqUrl, { method:'get',
		onError: function(error) {
			alert(error);
		},
  		onSuccess: function(transport){
  			/*var json = transport.responseText.evalJSON();
      		if(json.error){
      			alert(json.error[0].message);
      			return;
      		}*/
      		alert(transport.responseText);

			DATA_LOADED.challenge = false;
			setTabPushed($('tab-challenge-list-obj'),'challenge-list');

		}
	});
 }

/**
 *	Filter the orgs by search criteria
 */
function filterSearchOrgs() {
	ORG_ARGS['q'] = $('qorg').value;
	var scope = 'all';
	if ($('scopeorgmy') && $('scopeorgmy').selected) {
		scope = 'my';
	}
	ORG_ARGS['scope'] = scope;

	if (USER != "") {
		var reqUrl = SERVICE_ROOT + "&method=auditsearch&type=org&format=text&q="+ORG_ARGS['q'];
		new Ajax.Request(reqUrl, { method:'get',
			onError: function(error) {
				alert(error);
			},
	  		onSuccess: function(transport){
				var searchid = transport.responseText;
				if (searchid != "") {
					ORG_ARGS['searchid'] = searchid;
				}
				var currentLocation = getAnchorVal();
				if (currentLocation == "org-gmap") {
					DATA_LOADED.orggmap = false;
					setTabPushed($('tab-org-list-obj'),'org-gmap');
				} else {
					DATA_LOADED.org = false;
					setTabPushed($('tab-org-list-obj'),'org-list');
				}
			}
		});
	} else {
		var currentLocation = getAnchorVal();
		if (currentLocation == "org-gmap") {
			DATA_LOADED.orggmap = false;
			setTabPushed($('tab-org-list-obj'),'org-gmap');
		} else {
			DATA_LOADED.org = false;
			setTabPushed($('tab-org-list-obj'),'org-list');
		}
	}
}

/**
 *	Filter the project by search criteria
 */
function filterSearchProjects() {
	PROJECT_ARGS['q'] = $('qproject').value;
	var scope = 'all';
	if ($('scopeprojectmy') && $('scopeprojectmy').selected) {
		scope = 'my';
	}
	PROJECT_ARGS['scope'] = scope;

	if (USER != "") {
		var reqUrl = SERVICE_ROOT + "&method=auditsearch&type=project&format=text&q="+PROJECT_ARGS['q'];
		new Ajax.Request(reqUrl, { method:'get',
			onError: function(error) {
				alert(error);
			},
	  		onSuccess: function(transport){
				var searchid = transport.responseText;
				if (searchid != "") {
					PROJECT_ARGS['searchid'] = searchid;
				}
				var currentLocation = getAnchorVal();
				if (currentLocation == "project-gmap") {
					DATA_LOADED.projectgmap = false;
					setTabPushed($('tab-project-list-obj'),'project-gmap');
				} else {
					DATA_LOADED.project = false;
					setTabPushed($('tab-project-list-obj'),'project-list');
				}
			}
		});
	} else {
		var currentLocation = getAnchorVal();
		if (currentLocation == "project-gmap") {
			DATA_LOADED.projectgmap = false;
			setTabPushed($('tab-project-list-obj'),'project-gmap');
		} else {
			DATA_LOADED.project = false;
			setTabPushed($('tab-project-list-obj'),'project-list');
		}
	}
}


/**
 *	Filter the issues by search criteria
 */
function filterSearchIssues() {
	ISSUE_ARGS['q'] = $('qissue').value;
	var scope = 'all';
	if ($('scopeissuemy') && $('scopeissuemy').selected) {
		scope = 'my';
	}
	ISSUE_ARGS['scope'] = scope;

	if (USER != "") {
		var reqUrl = SERVICE_ROOT + "&method=auditsearch&type=issue&format=text&q="+ISSUE_ARGS['q'];
		new Ajax.Request(reqUrl, { method:'get',
			onError: function(error) {
				alert(error);
			},
	  		onSuccess: function(transport){
				var searchid = transport.responseText;
				if (searchid != "") {
					ISSUE_ARGS['searchid'] = searchid;
				}
				DATA_LOADED.issue = false;
				setTabPushed($('tab-issue-list-obj'),'issue-list');
			}
		});
	} else {
		DATA_LOADED.issue = false;
		setTabPushed($('tab-issue-list-obj'),'issue-list');
	}
}

/**
 *	Filter the solutions by search criteria
 */
function filterSearchSolutions() {
	SOLUTION_ARGS['q'] = $('qsolution').value;
	var scope = 'all';
	if ($('scopesolutionmy') && $('scopesolutionmy').selected) {
		scope = 'my';
	}
	SOLUTION_ARGS['scope'] = scope;

	if (USER != "") {
		var reqUrl = SERVICE_ROOT + "&method=auditsearch&type=solution&format=text&q="+SOLUTION_ARGS['q'];
		new Ajax.Request(reqUrl, { method:'get',
			onError: function(error) {
				alert(error);
			},
	  		onSuccess: function(transport){
				var searchid = transport.responseText;
				if (searchid != "") {
					SOLUTION_ARGS['searchid'] = searchid;
				}
				DATA_LOADED.solution = false;
				setTabPushed($('tab-solution-list-obj'),'solution-list');
			}
		});
	} else {
		DATA_LOADED.solution = false;
		setTabPushed($('tab-solution-list-obj'),'solution-list');
	}
}

/**
 *	Filter the claims by search criteria
 */
function filterSearchClaims() {
	CLAIM_ARGS['q'] = $('qclaim').value;
	var scope = 'all';
	if ($('scopeclaimmy') && $('scopeclaimmy').selected) {
		scope = 'my';
	}
	CLAIM_ARGS['scope'] = scope;

	if (USER != "") {
		var reqUrl = SERVICE_ROOT + "&method=auditsearch&type=claim&format=text&q="+CLAIM_ARGS['q'];
		new Ajax.Request(reqUrl, { method:'get',
			onError: function(error) {
				alert(error);
			},
	  		onSuccess: function(transport){
				var searchid = transport.responseText;
				if (searchid != "") {
					CLAIM_ARGS['searchid'] = searchid;
				}
				DATA_LOADED.claim = false;
				setTabPushed($('tab-claim-list-obj'),'claim-list');
			}
		});
	} else {
		DATA_LOADED.claim = false;
		setTabPushed($('tab-claim-list-obj'),'claim-list');
	}
}

/**
 *	Filter the evidence by search criteria
 */
function filterSearchEvidence() {
	EVIDENCE_ARGS['q'] = $('qevidence').value;
	var scope = 'all';
	if ($('scopeevidencemy') && $('scopeevidencemy').selected) {
		scope = 'my';
	}
	if (SELECTED_NODETYPES != "") {
		NODE_ARGS['filternodetypes'] = SELECTED_NODETYPES;
	}
	EVIDENCE_ARGS['scope'] = scope;

	if (USER != "") {
		var reqUrl = SERVICE_ROOT + "&method=auditsearch&type=evidence&format=text&q="+EVIDENCE_ARGS['q'];
		new Ajax.Request(reqUrl, { method:'get',
			onError: function(error) {
				alert(error);
			},
	  		onSuccess: function(transport){
				var searchid = transport.responseText;
				if (searchid != "") {
					EVIDENCE_ARGS['searchid'] = searchid;
				}
				DATA_LOADED.evidence = false;
				setTabPushed($('tab-evidence-list-obj'),'evidence-list');
			}
		});
	} else {
		DATA_LOADED.evidence = false;
		setTabPushed($('tab-evidence-list-obj'),'evidence-list');
	}
}

/**
 *	Filter the websites by search criteria
 */
function filterSearchWebsites() {
	URL_ARGS['q'] = $('qweb').value;
	var scope = 'all';
	if ($('scopewebmy') && $('scopewebmy').selected) {
		scope = 'my';
	}
	URL_ARGS['scope'] = scope;

	if (USER != "") {
		var reqUrl = SERVICE_ROOT + "&method=auditsearch&type=resource&format=text&q="+URL_ARGS['q'];
		new Ajax.Request(reqUrl, { method:'get',
			onError: function(error) {
				alert(error);
			},
	  		onSuccess: function(transport){
				var searchid = transport.responseText;
				if (searchid != "") {
					URL_ARGS['searchid'] = searchid;
				}
				DATA_LOADED.url = false;
				setTabPushed($('tab-web-list-obj'),'web-list');
			}
		});
	} else {
		DATA_LOADED.url = false;
		setTabPushed($('tab-web-list-obj'),'web-list');
	}
}

/**
 *	Filter the users by search criteria
 */
function filterSearchUsers() {
	USER_ARGS['q'] = $('quser').value;
	CURRENT_VIZ = 'list';
	var currentLocation = getAnchorVal();

	if (USER != "") {
		var reqUrl = SERVICE_ROOT + "&method=auditsearch&type=user&format=text&q="+USER_ARGS['q'];
		new Ajax.Request(reqUrl, { method:'get',
			onError: function(error) {
				alert(error);
			},
	  		onSuccess: function(transport){
				var searchid = transport.responseText;
				if (searchid != "") {
					USER_ARGS['searchid'] = searchid;
				}
				if (currentLocation == "user-usergmap") {
					DATA_LOADED.usergmap = false;
					setTabPushed($('tab-user-list-obj'),'user-usergmap');
				} else {
					DATA_LOADED.user = false;
					setTabPushed($('tab-user-list-obj'),'user-list');
				}
			}
		});
	} else {
		if (currentLocation == "user-usergmap") {
			DATA_LOADED.usergmap = false;
			setTabPushed($('tab-user-list-obj'),'user-usergmap');
		} else {
			DATA_LOADED.user = false;
			setTabPushed($('tab-user-list-obj'),'user-list');
		}
	}
}

/**
 *	Filter the comments by search criteria
 */
function filterSearchComments() {
	COMMENT_ARGS['q'] = $('qcomment').value;
	CURRENT_VIZ = 'list';

	if (USER != "") {
		var reqUrl = SERVICE_ROOT + "&method=auditsearch&type=comment&format=text&q="+NODE_ARGS['q'];
		new Ajax.Request(reqUrl, { method:'get',
			onError: function(error) {
				alert(error);
			},
	  		onSuccess: function(transport){
				var searchid = transport.responseText;
				if (searchid != "") {
					COMMENT_ARGS['searchid'] = searchid;
				}
				DATA_LOADED.commentlist = false;
				setTabPushed($('tab-comment-list-obj'),'comment-list');
			}
		});
	} else {
		DATA_LOADED.commentlist = false;
		setTabPushed($('tab-comment-list-obj'),'comment-list');
	}
}

/**
 *	Filter the news by search criteria
 */
function filterSearchNews() {
	NEWS_ARGS['q'] = $('qnews').value;
	CURRENT_VIZ = 'list';

	if (USER != "") {
		var reqUrl = SERVICE_ROOT + "&method=auditsearch&type=news&format=text&q="+NODE_ARGS['q'];
		new Ajax.Request(reqUrl, { method:'get',
			onError: function(error) {
				alert(error);
			},
	  		onSuccess: function(transport){
				var searchid = transport.responseText;
				if (searchid != "") {
					NEWS_ARGS['searchid'] = searchid;
				}
				DATA_LOADED.newslist = false;
				setTabPushed($('tab-news-list-obj'),'news-list');
			}
		});
	} else {
		DATA_LOADED.newslist = false;
		setTabPushed($('tab-news-list-obj'),'news-list');
	}
}

/**
 *	Filter the websites tab
 */
function filterWebsites() {

	if (SELECTED_USERS != "") {
		URL_ARGS['filterusers'] = SELECTED_USERS;
	}

	DATA_LOADED.url = false;
	loadurls(CONTEXT,URL_ARGS);
}


/**
 * show the sort form
 */
function displaySortForm(sortOpts,args,tab,handler){

	var sbTool = new Element("span", {'class':'sortback toolbar2 col-auto'});
    sbTool.insert("<?php echo $LNG->SORT_BY; ?> ");

    var selOrd = new Element("select");
 	Event.observe(selOrd,'change',handler);
    selOrd.id = "select-orderby-"+tab;
    selOrd.className = "toolbar form-select";
    selOrd.name = "orderby";
    selOrd.setAttribute("aria-label","Sort by");
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
    sortBy.className = "toolbar form-select";
    sortBy.name = "sort";
    sortBy.setAttribute("aria-label","Order by");
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

/**
 * Called by the node type popup after node types have been selected.
 */
function setSelectedNodeTypes(types) {
	SELECTED_NODETYPES = types;

	if ($('select-filter-conn')) {
		$('select-filter-conn').options[0].selected = true;
	} else if ($('select-filter-neighbourhood')) {
		$('select-filter-neighbourhood').options[0].selected = true;
	} else if ($('nodetypegroups')) {
		($('nodetypegroups')).options[0].selected = true;
	}
}

/**
 * Called by the link type popup after link types have been selected.
 */
function setSelectedLinkTypes(types) {
	SELECTED_LINKTYES = types;

	if ($('select-filter-conn')) {
		$('select-filter-conn').options[0].selected = true;
	} else if ($('select-filter-neighbourhood')) {
		$('select-filter-neighbourhood').options[0].selected = true;
	} else if ($('linktypegroups')) {
		($('linktypegroups')).options[0].selected = true;
	}
}

/**
 * Called by the users popup after users have been selected.
 */
function setSelectedUsers(types) {
	SELECTED_USERS = types;
}

function createOrgFilter(context, args) {

	var sbTool = new Element("span", {'class':'toolbar2 col-auto'});
    sbTool.insert("<?php echo $LNG->FILTER_BY; ?> ");

	var filterMenu= new Element("select", {'class':'subforminput hgrselecthgrselect toolbar form-select'});	
    filterMenu.setAttribute("aria-label","Filter by");

	var option = new Element("option", {'value':''});
	option.insert('<?php echo $LNG->FILTER_TYPES_ALL; ?>');
	filterMenu.insert(option);

	var option = new Element("option", {'value':'Organization'});
	if (args['filternodetypes'] == "Organization") {
		option.selected = true;
	}
	option.insert("<?php echo $LNG->ORG_NAME; ?>");
	filterMenu.insert(option);

	var option2 = new Element("option", {'value':'Project'});
	if (args['filternodetypes'] == "Project") {
		option2.selected = true;
	}
	option2.insert("<?php echo $LNG->PROJECT_NAME; ?>");
	filterMenu.insert(option2);

	Event.observe(filterMenu,"change", function(){
		switch(CURRENT_VIZ){
			case 'net':
				if (args['filterthemes'] && args['filterthemes'] != "") {
					var linktype = this.value;
					args['filternodetypes'] = linktype;
					refreshOrganizations();
				} else {
					alert('<?php echo $LNG->FILTER_ALSO_SELECT_THEME; ?>');
					break;
				}
			default :
				var linktype = this.value;
				args['filternodetypes'] = linktype;
				refreshOrganizations();
			break;
		}
	});

	sbTool.insert(filterMenu);

	return sbTool;
}

function createThemeFilter(context, args, type) {

	var sbTool = new Element("span", {'class':'toolbar2 col-auto'});
    sbTool.insert("<?php echo $LNG->FILTER_BY; ?> ");

	var filterMenu= new Element("select", {'class':'subforminput hgrselecthgrselect toolbar form-select'});
	filterMenu.setAttribute("aria-label","Filter by");

	var option = new Element("option", {'value':''});
	option.insert('<?php echo $LNG->FILTER_THEMES_ALL; ?>');
	filterMenu.insert(option);

	for(var i=0; i < THEMES.length; i++){
		var option = new Element("option", {'value':THEMES[i]});
		if (args['filterthemes'] && args['filterthemes'] == THEMES[i]) {
			option.selected = true;
		}
		option.insert(THEMES[i]);
		filterMenu.insert(option);
	}

	Event.observe(filterMenu,"change", function(){
		var theme = this.value;
		args['filterthemes'] = theme;

		if( type == 'orgs') {
			refreshOrganizations();
		} else if (type == 'projects') {
			refreshProjects();
		} else if (type == 'claims') {
			refreshClaims();
		} else if (type == 'evidence') {
			refreshEvidence();
		} else if (type == 'issues') {
			refreshIssues();
		} else if (type == 'solutions') {
			refreshSolutions();
		} else if (type == 'web') {
			refreshWebsites();
		} else if (type == 'challenges') {
			refreshChallenges();
		} else if (type == 'user') {
			refreshUsers();
		}
	});

	sbTool.insert(filterMenu);

	return sbTool;
}

function createThemeFilterNet(context, args, type) {

	var sbTool = new Element("span", {'class':'toolbar2 col-auto'});
    sbTool.insert("<?php echo $LNG->FILTER_THEME_LABEL; ?> ");

	var filterMenu= new Element("select", {'class':'subforminput hgrselecthgrselect toolbar form-select'});
	filterMenu.setAttribute("aria-label","Filter by");

	var option = new Element("option", {'value':''});
	option.insert('<?php echo $LNG->FILTER_ALSO_SELECT_THEME; ?>');
	filterMenu.insert(option);

	for(var i=0; i < THEMES.length; i++){
		var option = new Element("option", {'value':THEMES[i]});
		if (args['filterthemes'] && args['filterthemes'] == THEMES[i]) {
			option.selected = true;
		}
		option.insert(THEMES[i]);
		filterMenu.insert(option);
	}

	Event.observe(filterMenu,"change", function(){
		var theme = this.value;
		if (theme == "") {
			args['filterthemes'] = "";

			if( type == 'orgs') {
				checkIsActiveOrgMessage();
			} else if (type == 'projects') {
				checkIsActiveProjectMessage();
			} else if (type == 'claims') {
				checkIsActiveClaimMessage();
			} else if (type == 'evidence') {
				checkIsActiveEvidenceMessage();
			} else if (type == 'issues') {
				checkIsActiveIssueMessage();
			} else if (type == 'solutions') {
				checkIsActiveSolutionMessage();
			} else if (type == 'web') {
				checkIsActiveWebMessage();
			} else if (type == 'challenges') {
				checkIsActiveChallengeMessage();
			}
		} else {
			args['filterthemes'] = theme;

			if( type == 'orgs') {
				refreshOrganizations();
			} else if (type == 'projects') {
				refreshProjects();
			} else if (type == 'claims') {
				refreshClaims();
			} else if (type == 'evidence') {
				refreshEvidence();
			} else if (type == 'issues') {
				refreshIssues();
			} else if (type == 'solutions') {
				refreshSolutions();
			} else if (type == 'web') {
				refreshWebsites();
			} else if (type == 'challenges') {
				refreshChallenges();
			}
		}
	});

	sbTool.insert(filterMenu);

	return sbTool;
}

function createEvidenceFilter(context, args) {
	var sbTool = new Element("span", {'class':'toolbar2 col-auto'});
    sbTool.insert("<?php echo $LNG->FILTER_BY; ?> ");

	var resourceFilterMenu= new Element("select", {'class':'subforminput hgrselecthgrselect toolbar form-select'});
	resourceFilterMenu.setAttribute("aria-label","Filter by");

	var option = new Element("option", {'value':''});
	option.insert('<?php echo $LNG->FILTER_TYPES_ALL; ?>');
	resourceFilterMenu.insert(option);

	for(var i=0; i < EVIDENCE_TYPES.length; i++){
		var option = new Element("option", {'value':EVIDENCE_TYPES[i]});
		if (args['filternodetypes'] == EVIDENCE_TYPES[i]) {
			option.selected = true;
		}
		option.insert(EVIDENCE_TYPE_NAMES[i]);
		resourceFilterMenu.insert(option);
	}

	Event.observe(resourceFilterMenu,"change", function(){

		switch(CURRENT_VIZ){
			case 'net':
				if (args['filterthemes'] && args['filterthemes'] != "") {
					var type = this.value;
					args['filternodetypes'] = type;
					refreshEvidence();
				} else {
					alert('<?php echo $LNG->FILTER_ALSO_SELECT_THEME; ?>');
					break;
				}
			default :
				var type = this.value;
				args['filternodetypes'] = type;
				refreshEvidence();
			break;
		}
	});

	sbTool.insert(resourceFilterMenu);

	return sbTool;
}


function createResourceFilter(context, args) {
	var sbTool = new Element("span", {'class':'toolbar2 col-auto'});
    sbTool.insert("<?php echo $LNG->FILTER_BY; ?> ");

	var resourceFilterMenu= new Element("select", {'class':'subforminput hgrselecthgrselect toolbar form-select'});
	resourceFilterMenu.setAttribute("aria-label","Filter by");

	var option = new Element("option", {'value':''});
	option.insert('<?php echo $LNG->FILTER_TYPES_ALL; ?>');
	resourceFilterMenu.insert(option);

	for(var i=0; i < RESOURCE_TYPES.length; i++){
		var option = new Element("option", {'value':RESOURCE_TYPES[i]});
		if (args['filternodetypes'] == RESOURCE_TYPES[i]) {
			option.selected = true;
		}
		option.insert(RESOURCE_TYPE_NAMES[i]);
		resourceFilterMenu.insert(option);
	}

	Event.observe(resourceFilterMenu,"change", function(){
		switch(CURRENT_VIZ){
			case 'net':
				if (args['filterthemes'] && args['filterthemes'] != "") {
					var type = this.value;
					args['filternodetypes'] = type;
					refreshWebsites();
				} else {
					alert('<?php echo $LNG->FILTER_ALSO_SELECT_THEME; ?>');
					break;
				}
			default :
				var type = this.value;
				args['filternodetypes'] = type;
				updateAddressParameters(args);
				refreshWebsites();
			break;
		}
	});

	sbTool.insert(resourceFilterMenu);

	return sbTool;
}

function createNodeTypeFilter(context, args) {

	var sbTool = new Element("span", {'class':'toolbar2 col-auto'});
    sbTool.insert("<?php echo $LNG->FILTER_BY; ?> ");

	var filterMenu= new Element("select", {'class':'subforminput hgrselecthgrselect toolbar form-select'});
	filterMenu.setAttribute("aria-label","Filter by");

	var option = new Element("option", {'value':''});
	option.insert('<?php echo $LNG->FILTER_TYPES_ALL; ?>');
	filterMenu.insert(option);

	if (hasChallenge) {
		var option2 = new Element("option", {'value':'Challenge'});
		if (args['filternodetypes'] == "Challenge") {
			option2.selected = true;
		}
		option2.insert("<?php echo $LNG->CHALLENGE_NAME; ?>");
		filterMenu.insert(option2);
	}

	var option = new Element("option", {'value':'Issue'});
	if (args['filternodetypes'] == "Issue") {
		option.selected = true;
	}
	option.insert("<?php echo $LNG->ISSUE_NAME; ?>");
	filterMenu.insert(option);

	if (hasClaim) {
		var option2 = new Element("option", {'value':'Claim'});
		if (args['filternodetypes'] == "Claim") {
			option2.selected = true;
		}
		option2.insert("<?php echo $LNG->CLAIM_NAME; ?>");
		filterMenu.insert(option2);
	}
	if (hasSolution) {
		var option2 = new Element("option", {'value':'Solution'});
		if (args['filternodetypes'] == "Solution") {
			option2.selected = true;
		}
		option2.insert("<?php echo $LNG->SOLUTION_NAME; ?>");
		filterMenu.insert(option2);
	}

	var option = new Element("option", {'value':EVIDENCE_TYPES_STR});
	if (args['filternodetypes'] == EVIDENCE_TYPES_STR) {
		option.selected = true;
	}
	option.insert("<?php echo $LNG->EVIDENCE_NAME; ?>");
	filterMenu.insert(option);

	var option = new Element("option", {'value':RESOURCE_TYPES_STR});
	if (args['filternodetypes'] == RESOURCE_TYPES_STR) {
		option.selected = true;
	}
	option.insert("<?php echo $LNG->RESOURCE_NAME; ?>");
	filterMenu.insert(option);

	Event.observe(filterMenu,"change", function(){
		switch(CURRENT_VIZ){
			case 'nodegmap':
				var linktype = this.value;
				args['filternodetypes'] = linktype;
				refreshUsers();
			break;
		}
	});

	sbTool.insert(filterMenu);

	return sbTool;
}

function createCountryFilter(context, args) {
	var sbTool = new Element("span", {'class':'toolbar2 col-auto'});
    sbTool.insert("<?php echo $LNG->ZOOM_TO; ?> ");

	var filterMenu= new Element("select", {'class':'subforminput hgrselecthgrselect toolbar form-select'});
	filterMenu.setAttribute("aria-label","Filter by");

	var option = new Element("option", {'value':''});
	option.insert('<?php echo $LNG->FILTER_COUNTRY_DEFAULT; ?>');
	filterMenu.insert(option);

	<?php
		foreach($countries as $code=>$c) { ?>
			var option = new Element("option", {'value':"<?php echo $c; ?>"});
			if (args['zoomtocountry'] && args['zoomtocountry'] == "<?php echo $c; ?>") {
				option.selected = true;
			}
			option.insert("<?php echo $c; ?>");
			filterMenu.insert(option);
	<?php } ?>

	Event.observe(filterMenu,"change", function(){
		var selected = this.value;
		args['zoomtocountry'] = selected;
		updateAddressParameters(args);
		switch(CURRENT_VIZ){
			case 'nodegmap':
				zoomToCountryUserNode(selected);
			case 'usergmap':
				zoomToCountryUser(selected);
			case 'gmap':
				if (CURRENT_TAB == 'org') {
					zoomToCountryOrg(selected);
				} else if (CURRENT_TAB == 'project') {
					zoomToCountryProject(selected);
				}
			break;
		}
	});

	sbTool.insert(filterMenu);
	return sbTool;
}

function createConnectedFilter(context, args, type) {

	var sbTool = new Element("span", {'class':'toolbar2 col-auto'});
    sbTool.insert("<?php echo $LNG->FILTER_BY; ?> ");

	var filterMenu= new Element("select", {'class':'subforminput hgrselecthgrselect toolbar form-select'});
	filterMenu.setAttribute("aria-label","Filter by");

	var option = new Element("option", {'value':''});
	option.insert('<?php echo $LNG->ALL_ITEMS_FILTER; ?>');
	filterMenu.insert(option);

	var option = new Element("option", {'value':'connected'});
	if (args['filterbyconnection'] && args['filterbyconnection'] == "connected") {
		option.selected = true;
	}
	option.insert("<?php echo $LNG->CONNECTED_ITEMS_FILTER; ?>");
	filterMenu.insert(option);

	var option2 = new Element("option", {'value':'unconnected'});
	if (args['filterbyconnection'] && args['filterbyconnection'] == "unconnected") {
		option2.selected = true;
	}
	option2.insert("<?php echo $LNG->UNCONNECTED_ITEMS_FILTER; ?>");
	filterMenu.insert(option2);

	Event.observe(filterMenu,"change", function(){
		var selection = this.value;
		args['filterbyconnection'] = selection;

		if( type == 'orgs') {
			refreshOrganizations();
		} else if (type == 'projects') {
			refreshProjects();
		} else if (type == 'claims') {
			refreshClaims();
		} else if (type == 'evidence') {
			refreshEvidence();
		} else if (type == 'issues') {
			refreshIssues();
		} else if (type == 'solutions') {
			refreshSolutions();
		} else if (type == 'web') {
			refreshWebsites();
		} else if (type == 'challenges') {
			refreshChallenges();
		}
	});

	sbTool.insert(filterMenu);
	return sbTool;

}

/**
 * display Nav
 */
function createNav(total, start, count, argArray, context, type){

	var nav = new Element ("div",{'id':'page-nav', 'class':'toolbarrow pb-3' });

	var header = createNavCounter(total, start, count, type);
	nav.insert(header);

	if (total > parseInt( argArray["max"] )) {
		//previous
	    var prevSpan = new Element("span", {'id':"nav-previous", "class": "page-nav page-chevron"});
	    if(start > 0){
			prevSpan.update("<i class=\"fas fa-chevron-left fa-lg\" aria-hidden=\"true\"></i><span class=\"sr-only\"><?php echo $LNG->LIST_NAV_PREVIOUS_HINT; ?></span>");
	        prevSpan.addClassName("active");
	        Event.observe(prevSpan,"click", function(){
	            var newArr = argArray;
	            newArr["start"] = parseInt(start) - newArr["max"];
	            eval("load"+type+"(context,newArr)");
	        });
	    } else {
			prevSpan.update("<i disabled class=\"fas fa-chevron-left fa-lg\" aria-hidden=\"true\"></i><span class=\"sr-only\"><?php echo $LNG->LIST_NAV_NO_PREVIOUS_HINT; ?></span>");
	        prevSpan.addClassName("inactive");
	    }

	    //pages
	    var pageSpan = new Element("span", {'id':"nav-pages", "class": "page-nav"});
	    var totalPages = Math.ceil(total/argArray["max"]);
	    var currentPage = (start/argArray["max"]) + 1;
	    for (var i = 1; i < totalPages+1; i++){
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
	    var nextSpan = new Element("span", {'id':"nav-next", "class": "page-nav page-chevron"});
	    if(parseInt(start)+parseInt(count) < parseInt(total)){
			nextSpan.update("<i class=\"fas fa-chevron-right fa-lg\" aria-hidden=\"true\"></i><span class=\"sr-only\"><?php echo $LNG->LIST_NAV_NEXT_HINT; ?></span>");
	        nextSpan.addClassName("active");
	        Event.observe(nextSpan,"click", function(){
	            var newArr = argArray;
	            newArr["start"] = parseInt(start) + parseInt(newArr["max"]);
	            eval("load"+type+"(context, newArr)");
	        });
	    } else {
			nextSpan.update("<i class=\"fas fa-chevron-right fa-lg\" aria-hidden=\"true\" disabled></i><span class=\"sr-only\"><?php echo $LNG->LIST_NAV_NO_NEXT_HINT; ?></span>");
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
        if (CONTEXT == 'user' &&  USER_ARGS.userid == USER){
        	switch(type){
         		case 'challenge':
        			objH.insert("<b><?php echo $LNG->LIST_NAV_USER_NO_CHALLENGE; ?></b>");
        			break;
        		case 'orgs':
        			objH.insert("<p><b><?php echo $LNG->LIST_NAV_USER_NO_ORG; ?></b></p>");
        			break;
        		case 'projects':
        			objH.insert("<p><b><?php echo $LNG->LIST_NAV_USER_NO_PROJECT; ?></b></p>");
        			break;
        		case 'issues':
        			objH.insert("<p><b><?php echo $LNG->LIST_NAV_USER_NO_ISSUE; ?></b></p>");
        			break;
        		case 'solutions':
        			objH.insert("<p><b><?php echo $LNG->LIST_NAV_USER_NO_SOLUTION; ?></b></p>");
        			break;
        		case 'claims':
        			objH.insert("<p><b><?php echo $LNG->LIST_NAV_USER_NO_CLAIM; ?></b></p>");
        			break;
        		case 'evidence':
        			objH.insert("<p><b><?php echo $LNG->LIST_NAV_USER_NO_EVIDENCE; ?></b></p>");
        			break;
        		case 'urls':
        			objH.insert("<p><b><?php echo $LNG->LIST_NAV_USER_NO_RESOURCE; ?></b></p>");
        			break;
        		case 'comment':
					objH.insert("<p><b><?php echo $LNG->LIST_NAV_USER_NO_COMMENT; ?></b></p>");
        			break;
        	}
        } else {
        	switch(type){
        		case 'challenge':
        			objH.insert("<b><?php echo $LNG->LIST_NAV_NO_CHALLENGE; ?></b>");
        			break;
        		case 'evidence':
        			objH.insert("<b><?php echo $LNG->LIST_NAV_NO_EVIDENCE; ?></b>");
        			break;
        		case 'orgs':
        			objH.insert("<b><?php echo $LNG->LIST_NAV_NO_ORGS; ?></b>");
        			break;
        		case 'projects':
        			objH.insert("<b><?php echo $LNG->LIST_NAV_NO_PROJECTS; ?></b>");
        			break;
        		case 'urls':
        			objH.insert("<b><?php echo $LNG->LIST_NAV_NO_RESOURCE; ?></b>");
        			break;
        		case 'issues':
        			objH.insert("<p><b><?php echo $LNG->LIST_NAV_NO_ISSUE; ?></b></p>");
        			break;
        		case 'solutions':
        			objH.insert("<p><b><?php echo $LNG->LIST_NAV_NO_SOLUTION; ?></b></p>");
        			break;
        		case 'claims':
        			objH.insert("<p><b><?php echo $LNG->LIST_NAV_NO_CLAIM; ?></b></p>");
        			break;
        		case 'news':
					objH.insert("<p><b><?php echo $LNG->LIST_NAV_USER_NO_NEWS; ?></b></p>");
        			break;
        		default:
        			objH.insert("<b><?php echo $LNG->LIST_NAV_NO_ITEMS; ?></b>");
        	}
        }
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
 * load JS file for creating the connection network (applet)
 */
function loadChallengeNet(){
	addScriptDynamically('<?php echo $HUB_FLM->getCodeWebPath("ui/networkmaps/conn-challenge-net.js.php"); ?>', 'conn-challenge-net-script');
}

/**
 * Load JS files for creating google map
 */
function loadOrgNodesGMap(){
	updateAddressParameters(ORG_ARGS);

	addScriptDynamically('<?php echo $HUB_FLM->getCodeWebPath("ui/geomaps/orggmap.js.php"); ?>', 'geomaps-orggmap-script');

    DATA_LOADED.orggmap = true;
}

/**
 * Load JS files for creating google map
 */
function loadProjectNodesGMap(){
	updateAddressParameters(PROJECT_ARGS);

	addScriptDynamically('<?php echo $HUB_FLM->getCodeWebPath("ui/geomaps/projectgmap.js.php"); ?>', 'geomaps-projectgmap-script');

    DATA_LOADED.projectgmap = true;
}

/**
 * Load JS files for creating google map
 */
function loadUserGMap() {
	updateAddressParameters(USER_ARGS);

	addScriptDynamically('<?php echo $HUB_FLM->getCodeWebPath("ui/geomaps/usergmap.js.php"); ?>', 'geomaps-usergmap-script');

    DATA_LOADED.usergmap = true;
}

/**
 * Load JS files for creating google map
 */
function loadUserNodeGMap(){
	updateAddressParameters(USER_ARGS);

	addScriptDynamically('<?php echo $HUB_FLM->getCodeWebPath("ui/geomaps/usernodegmap.js.php"); ?>', 'geomaps-usernodegmap-script');

    DATA_LOADED.nodegmap = true;
}

/**
 * load JS file for creating the connection network (applet) for Organizations
 */
function loadOrgNet(){
	addScriptDynamically('<?php echo $HUB_FLM->getCodeWebPath("ui/networkmaps/conn-orgtheme-net.js.php"); ?>', 'conn-orgtheme-net-script');
}

/**
 * load JS file for creating the connection network (applet) for Projects
 */
function loadProjectNet(){
	addScriptDynamically('<?php echo $HUB_FLM->getCodeWebPath("ui/networkmaps/conn-projecttheme-net.js.php"); ?>', 'conn-projecttheme-net-script');
}

/**
 * load JS file for creating the connection network (applet) for Issues
 */
function loadIssueNet(){
	addScriptDynamically('<?php echo $HUB_FLM->getCodeWebPath("ui/networkmaps/conn-issue-net.js.php"); ?>', 'conn-issue-net-script');
}

/**
 * load JS file for creating the connection network (applet) for Solutions
 */
function loadSolutionNet(){
	addScriptDynamically('<?php echo $HUB_FLM->getCodeWebPath("ui/networkmaps/conn-solution-net.js.php"); ?>', 'conn-solution-net-script');
}

/**
 * load JS file for creating the connection network (applet) for Claims
 */
function loadClaimNet(){
	addScriptDynamically('<?php echo $HUB_FLM->getCodeWebPath("ui/networkmaps/conn-claim-net.js.php"); ?>', 'conn-claim-net-script');
}

/**
 * load JS file for creating the connection network (applet) for Evidence
 */
function loadEvidenceNet(){
	addScriptDynamically('<?php echo $HUB_FLM->getCodeWebPath("ui/networkmaps/conn-evidence-net.js.php"); ?>', 'conn-evidence-net-script');
}

/**
 * load JS file for creating the connection network (applet) for Reources
 */
function loadWebNet(){
	addScriptDynamically('<?php echo $HUB_FLM->getCodeWebPath("ui/networkmaps/conn-resource-net.js.php"); ?>', 'conn-resource-net-script');
}

/**
 * load JS file for creating the connection network (applet) for user social network
 */
function loadUserNet(){
	addScriptDynamically('<?php echo $HUB_FLM->getCodeWebPath("ui/networkmaps/social-net.js.php"); ?>', 'social-net-script');
}