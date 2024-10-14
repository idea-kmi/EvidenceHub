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

	echo "var NODE_CONTEXT = '".$CFG->NODE_CONTEXT."';";
	echo "var USER_CONTEXT = '".$CFG->USER_CONTEXT."';";
	echo "var GLOBAL_CONTEXT = '".$CFG->GLOBAL_CONTEXT."';";

    $evidenceArrayStr = "";
    $evidenceStr = "";
    $evidenceArrayName = "";
    $evidenceArrayNameShort = "";

    if (is_countable($CFG->EVIDENCE_TYPES)) {
		for($i=0;$i< count($CFG->EVIDENCE_TYPES); $i++){
			$evidenceArrayStr .= '"'.$CFG->EVIDENCE_TYPES[$i].'"';
			$evidenceStr .= $CFG->EVIDENCE_TYPES[$i];
    		$evidenceArrayName .= '"'.$LNG->EVIDENCE_TYPES[$i].'"';
    		$evidenceArrayNameShort .= '"'.$LNG->EVIDENCE_TYPES_SHORT[$i].'"';
			if ($i != (count($CFG->EVIDENCE_TYPES)-1)){
				$evidenceArrayStr .= ',';
				$evidenceStr .= ',';
				$evidenceArrayName .= ',';
				$evidenceArrayNameShort .= ',';
			}
		}
	}
    echo "var EVIDENCE_TYPES = new Array(".$evidenceArrayStr.");";
	echo "var EVIDENCE_TYPES_STR = '".$evidenceStr."';";
	echo "var EVIDENCE_TYPE_NAMES = new Array(".$evidenceArrayName.");";
	echo "var EVIDENCE_TYPE_NAMES_SHORT = new Array(".$evidenceArrayNameShort.");";

    $commentStr = "";
    if (is_countable($CFG->COMMENT_TYPES)) {
		for($j=0; $j<count($CFG->COMMENT_TYPES); $j++){
			$commentStr .= $CFG->COMMENT_TYPES[$j];
			if ($j != (count($CFG->COMMENT_TYPES)-1)) {
				$commentStr .= ',';
			}
		}
    }
    echo "var COMMENT_TYPES = '".$commentStr."';";

    $baseArray = "";
    $baseStr = "";
    if (is_countable($CFG->BASE_TYPES)) {
		for($j=0; $j<count($CFG->BASE_TYPES); $j++){
			$baseArray .= '"'.$CFG->BASE_TYPES[$j].'"';
			$baseStr .= $CFG->BASE_TYPES[$j];
			if ($j != (count($CFG->BASE_TYPES)-1)) {
				$baseArray .= ',';
				$baseStr .= ',';
			}
		}
	}
    echo "var BASE_TYPES = new Array(".$baseArray.");";
    echo "var BASE_TYPES_STR = '".$baseStr."';";

    $resArray = "";
    $resStr = "";
    $resArrayName = "";
    $resArrayNameShort = "";
    if (is_countable($CFG->RESOURCE_TYPES)) {
		for($i=0;$i< count($CFG->RESOURCE_TYPES); $i++){
			$resArray .= '"'.$CFG->RESOURCE_TYPES[$i].'"';
			$resStr .= $CFG->RESOURCE_TYPES[$i];
			$resArrayName .= '"'.$LNG->RESOURCE_TYPES[$i].'"';
			$resArrayNameShort .= '"'.$LNG->RESOURCE_TYPES_SHORT[$i].'"';
			if ($i != (count($CFG->RESOURCE_TYPES)-1)){
				$resArray .= ',';
				$resStr .= ',';
				$resArrayName .= ',';
				$resArrayNameShort .= ',';
			}
		}
	}
    echo "var RESOURCE_TYPES = new Array(".$resArray.");";
	echo "var RESOURCE_TYPES_STR = '".$resStr."';";
	echo "var RESOURCE_TYPE_NAMES = new Array(".$resArrayName.");";
	echo "var RESOURCE_TYPE_NAMES_SHORT = new Array(".$resArrayNameShort.");";

    $themeStr = "";
    if (is_countable($CFG->THEMES)) {
		for($i=0;$i< count($CFG->THEMES); $i++){
			$themeStr .= '"'.$CFG->THEMES[$i].'"';
			if ($i != (count($CFG->THEMES)-1)){
				$themeStr .= ',';
			}
		}
	}

    echo "var THEMES = new Array(".$themeStr.");";

    echo "var orgGeoLat=".$CFG->orggeomapdefaultlat.";";
    echo "var orgGeoLong=".$CFG->orggeomapdefaultlong.";";
    echo "var orgGeoZoom=".$CFG->orggeomapdefaultzoom.";";

    echo "var userGeoLat=".$CFG->usergeomapdefaultlat.";";
    echo "var userGeoLong=".$CFG->usergeomapdefaultlong.";";
    echo "var userGeoZoom=".$CFG->usergeomapdefaultzoom.";";

    echo "var userNodeGeoLat=".$CFG->usernodegeomapdefaultlat.";";
    echo "var userNodeGeoLong=".$CFG->usernodegeomapdefaultlong.";";
    echo "var userNodeGeoZoom=".$CFG->usernodegeomapdefaultzoom.";";

	// Colours for the network node backgrounds
	echo "var challengebackpale = '".$CFG->challengebackpale."';";
	echo "var issuebackpale = '".$CFG->issuebackpale."';";
	echo "var solutionbackpale = '".$CFG->solutionbackpale."';";
	echo "var claimbackpale = '".$CFG->claimbackpale."';";
	echo "var orgbackpale = '".$CFG->orgbackpale."';";
	echo "var projectbackpale = '".$CFG->projectbackpale."';";
	echo "var peoplebackpale = '".$CFG->peoplebackpale."';";
	echo "var evidencebackpale = '".$CFG->evidencebackpale."';";
	echo "var resourcebackpale = '".$CFG->resourcebackpale."';";
	echo "var themebackpale = '".$CFG->themebackpale."';";
	echo "var plainbackpale  = '".$CFG->plainbackpale."';";

	echo "var hasClaim  = ".json_encode($CFG->HAS_CLAIM).";";
	echo "var hasSolution  = ".json_encode($CFG->HAS_SOLUTION).";";
	echo "var hasChallenge  = ".json_encode($CFG->HAS_CHALLENGE).";";
	echo "var hasOpenComment  = ".json_encode($CFG->HAS_OPEN_COMMENTS).";";

	$pollrate = 60000; //defaults to 1 minute
	if (isset($CFG->chatPollingInterval) && is_int($CFG->chatPollingInterval)
			&& $CFG->chatPollingInterval > 0) {
		$pollrate = $CFG->chatPollingInterval;
	}
	echo "var chatPollingInterval = ".$pollrate.";";
?>

/**
 * Variables
 */
var URL_ROOT = "<?php print $CFG->homeAddress;?>";
var SERVICE_ROOT = URL_ROOT + "api/service.php?format=json";
var USER = "<?php print $USER->userid; ?>";
var IS_USER_ADMIN = "<?php print $USER->getIsAdmin(); ?>";
var BUILD_FROM_PERMISSIONS = '<?php echo $CFG->build_from_permissions; ?>';
var DATE_FORMAT = 'd/m/yy';
var DATE_FORMAT_PROJECT = 'd mmm yyyy';
var TIME_FORMAT = 'd/m/yy - H:MM';
var SELECTED_LINKTYES = "";
var SELECTED_NODETYPES = "";
var SELECTED_USERS = "";

var IE = 0;
var IE5 = 0;
var NS = 0;
var GECKO = 0;
var openpopups = new Array();

/** Store some variables about the browser being used.*/
if (document.all) {     // Internet Explorer Detected
	OS = navigator.platform;
	VER = new String(navigator.appVersion);
	VER = VER.substr(VER.indexOf("MSIE")+5, VER.indexOf(" "));
	if ((VER <= 5) && (OS == "Win32")) {
		IE5 = true;
	} else {
		IE = true;
	}
}
else if (document.layers) {   // Netscape Navigator Detected
	NS = true;
}
else if (document.getElementById) { // Netscape 6 Detected
	GECKO = true;
}

String.prototype.trim = function() {
	return this.replace(/^\s+|\s+$/g,"");
}

/**
 * Check to see if the enter key was pressed then fire the onlcik of that item.
 */
function enterKeyPressed(evt) {
 	var event = evt || window.event;
	var thing = event.target || event.srcElement;

	var characterCode = document.all? window.event.keyCode:event.which;
	if(characterCode == 13) {
		thing.onclick();
	}
}


/**
 * Check to see if the enter key was pressed.
 */
function checkKeyPressed(evt) {
 	var event = evt || window.event;
	var thing = event.target || event.srcElement;

	var characterCode = document.all? window.event.keyCode:event.which;
	if(characterCode == 13) {
		return true;
	} else {
		return false;
	}
}

/**
 * get the anchor (#) value from the url
 */
function getAnchorVal(defVal){
    var url = document.location;
    var strippedUrl = url.toString().split("#");
    if(strippedUrl.length > 1 && strippedUrl[1] != ""){
        return strippedUrl[1];
    } else {
        return defVal;
    }
}

/**
 * Update the address parameters for a change in state.
 */
function updateAddressParameters(args) {
	if (typeof window.history.replaceState == 'function') {
		var newUrl = createNewURL(window.location.href, args);

		//const state = {}
		//const title = '';
		//const url = newUrl;
		//window.history.pushState(state, title, url);

		window.history.replaceState("string", "Title", newUrl);
	}
}

/**
 * create a new url based on the current one but with new arguments.
 */
function createNewURL(url, args, view){
	var newURL = "";

	// Strip empty parameters to declutter query string
	var newargs = {};
	for(var index in args) {
		var value = args[index];
		// check for an empty value or the title parameter - which does not need displaying in address
		if (value && value != "" && index != "title") {
			newargs[index] = value;
		}
	}

	// check for ? otherwise split on #
    var strippedUrl = url.toString().split("?");
    if (strippedUrl.length > 1) {
    	newURL = strippedUrl[0];
    } else {
    	newURL = (url.toString().split("#"))[0];
    }

	// if the view is not passed, reappend the original hash
	// we are just chaning the parameters
	if (view === undefined) {
		var bits = url.toString().split("#");
		if (bits.length > 1) {
			view = bits[1];
		}
	}

	// if the questionmark gets added before the # it casues a page refresh when adding to history
	if (Object.keys(newargs).length > 0) {
	    newURL += "?"+Object.toQueryString(newargs);
	}
    newURL += "#"+view;
    return newURL;
}

/**
 * Open a page in the dialog window
 */
function loadDialog(windowName, url, width, height){

    if (width == null){
        width = 570;
    }
    if (height == null){
        height = 510;
    }

    var left = parseInt((screen.availWidth/2) - (width/2));
    var top  = parseInt((screen.availHeight/2) - (height/2));
    var props = "width="+width+",height="+height+",left="+left+",top="+top+",menubar=no,toolbar=no,scrollbars=yes,location=no,status=no,resizable=yes";

    //var props = "width="+width+",height="+height+",left="+left+",top="+top+",menubar=no,toolbar=no,scrollbars=yes,location=no,status=yes,resizable=yes";

    try {
    	var newWin = window.open(url, windowName, props);
    	if(newWin == null){
    		alert("<?php echo $LNG->POPUPS_BLOCK; ?>");
    	} else {
    		newWin.focus();
    	}
    } catch(err) {
    	//IE error
    	alert(err.description);
    }
}

/**
 * When closing a child window, reload the page or change the page as required.
 */
function closeDialog(gotopage){

	if(gotopage === undefined){
		gotopage="issue-list";
	}

	// try to refresh the parent page
	try {
		if (gotopage == "current") {
			window.opener.location.reload(true);
		} else if (gotopage == "conn-neighbour" || gotopage == "conn-net") {
			window.opener.location.reload(true);
		} else {
			var wohl = window.opener.location.href;
			if (wohl)
				var newurl = URL_ROOT + "user.php#" + gotopage;

			if(wohl == newurl){
				window.opener.location.reload(true);
			} else {
				window.opener.location.href = newurl;
			}
		}
	} catch(err) {
		//do nothing
	}

    window.close();
}

/**
 * Set display to 'block' for the item with the given pid
 */
function showPopup(pid){
    $(pid).setStyle({'display':'block'});
}

/**
 * Set display to 'none' for the item with the given pid
 */
function hidePopup(pid){
    $(pid).setStyle({'display':'none'});
}

/**
 * Toggle the given div between display 'block' and 'none'
 */
function toggleDiv(div) {
	var div = document.getElementById(div);
	if (div.style.display == "none") {
		div.style.display = "block";
	} else {
		div.style.display = "none";
	}
}

function toggleArrowDiv(div, arrow) {
	if ( $(div).style.display == "block") {
		$(div).style.display = "none";
		$(arrow).src='<?php echo $HUB_FLM->getImagePath("arrow-down-blue.png"); ?>';
	} else {
		$(div).style.display = "block";
		$(arrow).src='<?php echo $HUB_FLM->getImagePath("arrow-up-blue.png"); ?>';
	}
}

/**
 * Return the height of the current browser page.
 * Defaults to 500.
 */
function getWindowHeight(){
  	var viewportHeight = 500;
	if (self.innerHeight) {
		// all except Explorer
		viewportHeight = self.innerHeight;
	} else if (document.documentElement && document.documentElement.clientHeight) {
	 	// Explorer 6 Strict Mode
		viewportHeight = document.documentElement.clientHeight;
	} else if (document.body)  {
		// other Explorers
		viewportHeight = document.body.clientHeight;
	}
	return viewportHeight;
}

/**
 * Return the width of the current browser page.
 * Defaults to 500.
 */
function getWindowWidth(){
  	var viewportWidth = 500;
	if (self.innerHeight) {
		// all except Explorer
		viewportWidth = self.innerWidth;
	} else if (document.documentElement && document.documentElement.clientHeight) {
	 	// Explorer 6 Strict Mode
		viewportWidth = document.documentElement.clientWidth;
	} else if (document.body)  {
		// other Explorers
		viewportWidth = document.body.clientWidth;
	}
	return viewportWidth;
}

function getPageOffsetX() {
	var x = 0;

    if (typeof(window.pageXOffset) == 'number') {
		x = window.pageXOffset;
	} else {
        if (document.body && document.body.scrollLeft) {
			x = document.body.scrollLeft;
        } else if (document.documentElement && document.documentElement.scrollLeft) {
			x = document.documentElement.scrollLeft;
		}
	}

	return x;
}

function getPageOffsetY() {
	var y = 0;

    if (typeof(window.pageYOffset) == 'number') {
		y = window.pageYOffset;
	} else {
        if (document.body && document.body.scrollTop) {
			y = document.body.scrollTop;
        } else if (document.documentElement && document.documentElement.scrollTop) {
			y = document.documentElement.scrollTop;
		}
	}

	return y;
}

/**
 * Return the position of the given element in an x/y array.
 */
function getPosition(element) {
	var xPosition = 0;
	var yPosition = 0;

	while(element && element != null) {

		xPosition += element.offsetLeft;
		xPosition -= element.scrollLeft;
		xPosition += element.clientLeft;

		yPosition += element.offsetTop;
		yPosition += element.clientTop;

		// Messes up menu positions in Chrome if this is included.
		// Works fine on all main browsers and Chrome if it is not.
		// yPosition -= element.scrollTop;

		//alert(element.id+" :"+"element.offsetTop: "+element.offsetTop+" element.scrollTop :"+element.scrollTop+" element.clientTop :"+element.clientTop);
		//alert(element.id+" :"+xPosition+":"+yPosition);

		// if the element is a table, get the parentElement as offsetParent is wrong
		if (element.nodeName == 'TABLE') {
			var prevelement = element;
			var nextelement = element.parentNode;
			//find a div with any scroll set.
			while(nextelement != prevelement.offsetParent) {
				yPosition -= nextelement.scrollTop;
				xPosition -= nextelement.scrollLeft;
				nextelement = nextelement.parentNode;
			}
		}

		element = element.offsetParent;
	}

	return { x: xPosition, y: yPosition };
}

/**
 * Display the home page text for the nav bar.
 */
function showHomeNavText(event, type) {

	var messgeArea = "";
	if ($('globalMessage')) {
		messgeArea = $('globalMessage')
	} else if ($('resourceMessage')) {
		messgeArea = $('resourceMessage')
	}

	messgeArea.innerHTML="";
	var text = "";
	if (type == "ChallengesHome") {
		text += '<?php echo $LNG->CHALLENGE_HOME_NAV_HINT; ?>';
	}  else if (type == "IssuesHome") {
		text += '<?php echo $LNG->ISSUE_HOME_NAV_HINT; ?>';
	} else if (type == "EvidenceHome") {
		text += '<?php echo $LNG->EVIDENCE_HOME_NAV_HINT; ?>';
	}  else if (type == "ResourcesHome") {
		text = '<?php echo $LNG->RESOURCE_HOME_NAV_HINT; ?>';
	} else if (type == "ClaimsHome") {
		text += '<?php echo $LNG->CLAIM_HOME_NAV_HINT; ?>';
	} else if (type == "SolutionsHome") {
		text += '<?php echo $LNG->SOLUTION_HOME_NAV_HINT; ?>';
	} else if (type == "OrganisationsHome") {
		text += '<?php echo $LNG->ORG_HOME_NAV_HINT; ?>';
	} else if (type == "ProjectsHome") {
		text += '<?php echo $LNG->PROJECT_HOME_NAV_HINT; ?>';
	}
	if (text != "") {
		messgeArea.insert(text);
		showHint(event, 'hgrhint', 10, -10);
	}
}

/**
 * Display the home page text for the given type.
 */
function showHomeButtonText(evt, type) {

	var event = evt || window.event;
	var target = event.target || event.srcElement;
	if (target.id == 'issueaddhomelink'
		|| target.id == 'solutionaddhomelink'
			|| target.id == 'claimaddhomelink'
				|| target.id == 'evidenceaddhomelink'
					|| target.id == 'signinhome'
						|| target.id == 'signuphome') {
		return false;
	}

	if ($('homebuttonmessagediv').style.display == "block" && type == $('homebuttonmessagelasttype').value) {
		$('homebuttonmessagediv').style.display = "none";
	} else {
		$('homebuttonmessage').innerHTML="";
		$('homebuttonmessagediv').className="plainborder curvedBorder";

		var text = "";
		if (type == "issue") {
			$('solutionhomebutton').className="plainbackgradient plainborder curvedBorder homebutton1";
			$('evidencehomebutton').className="plainbackgradient plainborder curvedBorder homebutton1";
			$('homebuttonmessagediv').className="issueborder curvedBorder";
			text += '<?php echo addslashes($LNG->ISSUE_HOME_BUTTON_EXTRA); ?>';
		} else if (type == "solution") {
			$('issuehomebutton').className="plainbackgradient plainborder curvedBorder homebutton1";
			$('evidencehomebutton').className="plainbackgradient plainborder curvedBorder homebutton1";
			$('homebuttonmessagediv').className="solutionborder curvedBorder";
			text += '<?php echo addslashes($LNG->SOLUTION_HOME_BUTTON_EXTRA); ?>';
		} else if (type == "evidence") {
			$('issuehomebutton').className="plainbackgradient plainborder curvedBorder homebutton1";
			$('solutionhomebutton').className="plainbackgradient plainborder curvedBorder homebutton1";
			$('homebuttonmessagediv').className="evidenceborder curvedBorder";
			text += '<?php echo addslashes($LNG->EVIDENCE_HOME_BUTTON_EXTRA); ?>';
		}

		if (text != "") {
			$('homebuttonmessage').insert(text);
			$('homebuttonmessagediv').style.display = "block";
		} else {
			alert('** text not found **');
		}
	}

	$('homebuttonmessagelasttype').value = type;
}

/**
 * Display the home page text for the given type.
 */
function showHomeButtonText2(evt, type) {

	var event = evt || window.event;
	var target = event.target || event.srcElement;
	if (target.id == 'resourceaddhomelink'
		|| target.id == 'orgaddhomelink'
			|| target.id == 'projectaddhomelink'
				|| target.id == 'pstoryaddhomelink'
					|| target.id == 'rstoryaddhomelink'
						|| target.id == 'signinhome'
							|| target.id == 'signuphome') {
		return false;
	}

	if ($('homebuttonmessagediv2').style.display == "block" && type == $('homebuttonmessagelasttype2').value) {
		$('homebuttonmessagediv2').style.display = "none";
	} else {
		$('homebuttonmessage2').innerHTML="";
		$('homebuttonmessagediv2').className="plainborder curvedBorder";
		var text = "";
		if (type == "resource") {
			$('orghomebutton').className="plainbackgradient plainborder curvedBorder homebutton1";
			<?PHP if ($CFG->hasStories == true) { ?>
			$('storyhomebutton').className="plainbackgradient plainborder curvedBorder homebutton1";
			<?php } ?>
			$('homebuttonmessagediv2').className="resourceborder curvedBorder";
			text += '<?php echo addslashes($LNG->RESOURCE_HOME_BUTTON_EXTRA); ?>';
		} else if (type == "org") {
			$('resourcehomebutton').className="plainbackgradient plainborder curvedBorder homebutton1";
			<?PHP if ($CFG->hasStories == true) { ?>
			$('storyhomebutton').className="plainbackgradient plainborder curvedBorder homebutton1";
			<?php } ?>
			$('homebuttonmessagediv2').className="orgborder curvedBorder";
			text += '<?php echo addslashes($LNG->ORG_HOME_BUTTON_EXTRA); ?>';
		} else if (type == "story") {
			<?PHP if ($CFG->hasStories == true) { ?>
			$('resourcehomebutton').className="plainbackgradient plainborder curvedBorder homebutton1";
			$('orghomebutton').className="plainbackgradient plainborder curvedBorder homebutton1";
			$('homebuttonmessagediv2').className="themeborder curvedBorder";
			text += '<?php echo addslashes($LNG->STORY_HOME_BUTTON_EXTRA); ?>';
			<?php } ?>
		}

		if (text != "") {
			$('homebuttonmessage2').insert(text);
			$('homebuttonmessagediv2').style.display = "block";
		} else {
			alert('** text not found **');
		}
	}

	$('homebuttonmessagelasttype2').value = type;
}

/**
 * Display the home page text for the given type.
 */
function showHomeButtonText3(evt, type) {

	if ($('homebuttonmessagediv3').style.display == "block" && type == $('homebuttonmessagelasttype3').value) {
		$('homebuttonmessagediv3').style.display = "none";
	} else {
		$('homebuttonmessage3').innerHTML="";
		$('homebuttonmessagediv3').className="plainborder curvedBorder";

		var text = "";
		if (type == "challenge") {
			$('homebuttonmessagediv3').className="challengeborder curvedBorder";
			text += '<?php echo addslashes($LNG->CHALLENGE_HOME_BUTTON_EXTRA); ?>';
		}

		if (text != "") {
			$('homebuttonmessage3').insert(text);
			$('homebuttonmessagediv3').style.display = "block";
		} else {
			alert('** text not found **');
		}
	}

	$('homebuttonmessagelasttype3').value = type;
}

/**
 * Display the index page hint for the given type.
 */
function showGlobalHint(type,evt,panelName) {

	$(panelName).style.width="400px";

 	var event = evt || window.event;

	var messgeArea = "";
	if ($('globalMessage')) {
		messgeArea = $('globalMessage')
	} else if ($('resourceMessage')) {
		messgeArea = $('resourceMessage')
	}
	messgeArea.innerHTML="";

	if (type == "ChallengesTab") {
		var text = '<?php echo addslashes($LNG->CHALLENGE_TAB_INFO_HINT); ?>';
		messgeArea.insert(text);
	} else if (type == "IssuesTab") {
		var text = '<?php echo addslashes($LNG->ISSUE_TAB_INFO_HINT); ?>';
		messgeArea.insert(text);
	} else if (type == "SolutionsTab") {
		var text = '<?php echo addslashes($LNG->SOLUTION_TAB_INFO_HINT); ?>';
		messgeArea.insert(text);
	} else if (type == "ClaimsTab") {
		var text = '<?php echo addslashes($LNG->CLAIM_TAB_INFO_HINT); ?>';
		messgeArea.insert(text);
	} else if (type == "EvidenceTab") {
		var text = '<?php echo addslashes($LNG->EVIDENCE_TAB_INFO_HINT); ?>';
		messgeArea.insert(text);
	} else if (type == "ResourcesTab") {
		var text = '<?php echo addslashes($LNG->TAB_RESOURCE_INFO_HINT); ?>';
		messgeArea.insert(text);
	} else if (type == "OrganizationsTab") {
		var text = '<?php echo addslashes($LNG->TAB_ORG_INFO_HINT); ?>';
		messgeArea.insert(text);
	} else if (type == "ProjectsTab") {
		var text = '<?php echo addslashes($LNG->TAB_PROJECT_INFO_HINT); ?>';
		messgeArea.insert(text);
	}else if (type == "PeopleTab") {
		var text = '<?php echo addslashes($LNG->TAB_USER_INFO_HINT); ?>';
		messgeArea.insert(text);
	} else if (type == "MainSearch") {
		var text = '<?php echo addslashes($LNG->MAIN_SEARCH_INFO_HINT); ?>';
		messgeArea.insert(text);
	}

	showHint(event, panelName, 10, -10);
}

/**
 * Display the eplore page hint for the given field type.
 */
function showExploreHint(type,evt,panelName) {

	$(panelName).style.width="400px";

 	var event = evt || window.event;

	var messgeArea = "";
	if ($('globalMessage')) {
		messgeArea = $('globalMessage')
	} else if ($('resourceMessage')) {
		messgeArea = $('resourceMessage')
	}

	messgeArea.innerHTML="";

	if (type == "Challenges") {
		var text = '<ul style="padding-left:20px;margin-left:0px">';
		text += '<li></li>';
		text += '</ul>';
		messgeArea.insert(text);
	} else if (type == "Issues") {
		var text = '<ul style="padding-left:20px;margin-left:0px">';
		text += '<li></li>';
		text += '</ul>';
		messgeArea.insert(text);
	} else if (type == "Solutions") {
		var text = '<ul style="padding-left:20px;margin-left:0px">';
		text += '<li></li>';
		text += '</ul>';
		messgeArea.insert(text);
	} else if (type == "Claims") {
		var text = '<ul style="padding-left:20px;margin-left:0px">';
		text += '<li></li>';
		text += '</ul>';
		messgeArea.insert(text);
	} else if (type == "Evidence") {
		var text = '<ul style="padding-left:20px;margin-left:0px">';
		text += '<li></li>';
		text += '</ul>';
		messgeArea.insert(text);
	} else if (type == "Resources") {
		var text = '<ul style="padding-left:20px;margin-left:0px">';
		text += '<li></li>'
		text += '</ul>';
		messgeArea.insert(text);
	} else if (type == "Organizations") {
		var text = '<ul style="padding-left:20px;margin-left:0px">';
		text += '<li></li>';
		text += '</ul>';
		messgeArea.insert(text);
	} else if (type == "Projects") {
		var text = '<ul style="padding-left:20px;margin-left:0px">';
		text += '<li></li>';
		text += '</ul>';
		messgeArea.insert(text);
	} else if (type == "Themes") {
		var text = '<ul style="padding-left:20px;margin-left:0px">';
		text += '<li></span>';
		text += '</ul>';
		messgeArea.insert(text);
	}

	showHint(event, panelName, 10, -10);
}

function showHintText(evt, text) {
 	var event = evt || window.event;

	var messgeArea = "";
	if ($('globalMessage')) {
		messgeArea = $('globalMessage')
	} else if ($('resourceMessage')) {
		messgeArea = $('resourceMessage')
	}

	messgeArea.innerHTML="";
	messgeArea.insert(text);
	$('hgrhint').style.width="220px";
	showHint(event, 'hgrhint', 10, -10);
}

/**
 * Show a rollover hint popup div (when multiple lines needed).
 */
function showHint(evt, popupName, extraX, extraY) {
	hideHints();

 	var event = evt || window.event;
	var thing = event.target || event.srcElement;

	var viewportHeight = getWindowHeight();
	var viewportWidth = getWindowWidth();
	var panel = document.getElementById(popupName);

	if (GECKO) {

		//adjust for it going off the screen right or bottom.
		var x = event.clientX;
		var y = event.clientY;
		if ( (x+panel.offsetWidth+30) > viewportWidth) {
			x = x-(panel.offsetWidth+30);
		} else {
			x = x+10;
		}
		if ( (y+panel.offsetHeight) > viewportHeight) {
			y = y-50;
		} else {
			y = y-5;
		}

		if (panel) {
			panel.style.left = x+extraX+window.pageXOffset+"px";
			panel.style.top = y+extraY+window.pageYOffset+"px";
			panel.style.background = "#FFFED9";
			panel.style.visibility = "visible";
			openpopups.push(popupName);
		}
	}
	else if (NS) {
		//adjust for it going off the screen right or bottom.
		var x = event.pageX;
		var y = event.pageY;
		if ( (x+panel.offsetWidth+30) > viewportWidth) {
			x = x-(panel.offsetWidth+30);
		} else {
			x = x+10;
		}
		if ( (y+panel.offsetHeight) > viewportHeight) {
			y = y-50;
		} else {
			y = y-5;
		}
		document.layers[popupName].moveTo(x+extraX+window.pageXOffset+"px", y+extraY+window.pageYOffset+"px");
		document.layers[popupName].bgColor = "#FFFED9";
		document.layers[popupName].visibility = "show";
		openpopups.push(popupName);
	}
	else if (IE || IE5) {
		//adjust for it going off the screen right or bottom.
		var x = event.x;
		var y = event.clientY;
		if ( (x+panel.offsetWidth+30) > viewportWidth) {
			x = x-(panel.offsetWidth+30);
		} else {
			x = x+10;
		}
		if ( (y+panel.offsetHeight) > viewportHeight) {
			y = y-50;
		} else {
			y = y-5;
		}

		window.event.cancelBubble = true;
		document.all[popupName].style.left = x+extraX+ document.documentElement.scrollLeft+"px";
		document.all[popupName].style.top = y+extraY+ document.documentElement.scrollTop+"px";
		document.all[popupName].style.visibility = "visible";
		openpopups[openpopups.length] = popupName;
	}
	return false;
}

function hideHints() {
	var popupname;
	for (var i = 0; i < openpopups.length; i++) {
		popupname = new String (openpopups[i]);
		if (popupname) {
			var popup = document.getElementById(popupname);
			if (popup) {
				popup.style.visibility = "hidden";
			}
		}
	}
	openpopups = new Array();
	return;
}

var popupTimerHandleArray = new Array();
var popupArray = new Array();

function showBox(div) {
	hideBoxes();

    if (popupTimerHandleArray[div] != null) {
        clearTimeout(popupTimerHandleArray[div]);
        popupTimerHandleArray[div] = null;
    }

    var divObj = document.getElementById(div);
    divObj.style.display = 'block';
    popupArray.push(div);
}

function hideBox(div) {
    var popupTimerHandle = setTimeout("reallyHideBox('" + div + "');", 250);
    popupTimerHandleArray[div] = popupTimerHandle;
}

function reallyHideBox(div) {
    var divObj = document.getElementById(div);
    divObj.style.display = 'none';
}

function hideBoxes() {
	var popupname;
	for (var i = 0; i < popupArray.length; i++) {
		popupname = new String (popupArray[i]);
		var popup = document.getElementById(popupname);
		if (popup) {
			popup.style.display = "none";
		}
	}
	popupArray = new Array();
	return;
}

function radioEvidencePrompt(focalnodeid, filternodetypes, focalnodeend, handler, key, nodetofocusid, promptlabel, selectedOption, refresher) {

	$('prompttext').innerHTML="";
	$('prompttext').style.width = "380px";
	$('prompttext').style.height = "140px";

	var viewportHeight = getWindowHeight();
	var viewportWidth = getWindowWidth();
	var x = (viewportWidth-380)/2;
	var y = (viewportHeight-140)/2;

	$('prompttext').style.left = x+getPageOffsetX()+"px";
	$('prompttext').style.top = y+getPageOffsetY()+"px";

	var choicehidden = new Element('input', {'name':'radiopromptchoice','id':'radiopromptchoice','type':'hidden', 'value':'supports'});
	$('prompttext').insert(choicehidden);

	var labelobj = new Element('label', {'style':'padding-bottom:5px;font-weight:bold;font-size:12pt; color:black;'});
	labelobj.insert(promptlabel);
	$('prompttext').insert(labelobj);

	$('prompttext').insert("<br />");
	$('prompttext').insert("<br />");

	var radio = new Element('input', {'style':'vertical-align:bottom','type':'radio','name':'radioPrompt','value':'supports'});
	radio.checked = "checked";
	Event.observe(radio,'click', function() {
		if (this.checked) {
			$('radiopromptchoice').value = this.value;
		}
	});
	$('prompttext').insert(radio);
	$('prompttext').insert('<img border="0" alt="+" style="vertical-align:bottom" src="<?php echo $HUB_FLM->getImagePath("plus-16x16.png"); ?>" /><span style="color:black"> Supporting</span>');
	$('prompttext').insert("<br />");

	var radio2 = new Element('input', {'style':'vertical-align:bottom','type':'radio','name':'radioPrompt','value':'challenges'});
	Event.observe(radio2,'click', function() {
		if (this.checked) {
			$('radiopromptchoice').value = this.value;
		}
	});
	$('prompttext').insert(radio2);
	$('prompttext').insert('<img border="0" alt="-" style="vertical-align:bottom" src="<?php echo $HUB_FLM->getImagePath("minus-16x16.png"); ?>" /><span style="color:black"> Countering</span>');
	$('prompttext').insert("<br />");

	$('prompttext').insert("<br />");

    var buttonOK = new Element('input', { 'style':'clear: both;margin-top: 5px; font-size: 8pt', 'type':'button', 'value':'<?php echo $LNG->FORM_BUTTON_CONTINUE; ?>'});
	Event.observe(buttonOK,'click', function() {
		var valuechosen = $('radiopromptchoice').value;
		eval( refresher + '("'+focalnodeid+'","'+filternodetypes+'","'+focalnodeend+'","'+handler+'","'+key+'","'+nodetofocusid+'","'+valuechosen+'")' );
		textAreaCancel();
	});

    var buttonCancel = new Element('input', { 'style':'margin-left: 5px; margin-top: 5px; font-size: 8pt', 'type':'button', 'value':'<?php echo $LNG->FORM_BUTTON_CANCEL; ?>'});
	Event.observe(buttonCancel,'click', textAreaCancel);

	$('prompttext').insert(buttonOK);
	$('prompttext').insert(buttonCancel);
	$('prompttext').style.display = "block";
}

function textAreaCancel() {
	$('prompttext').style.display = "none";
	$('prompttext').update("");
}

function textAreaPrompt(messageStr, text, connid, handler, refresher) {

	$('prompttext').innerHTML="";
	$('prompttext').style.width = "400px";
	$('prompttext').style.height = "200px";

	var viewportHeight = getWindowHeight();
	var viewportWidth = getWindowWidth();
	var x = (viewportWidth-400)/2;
	var y = (viewportHeight-200)/2;
	$('prompttext').style.left = x+getPageOffsetX()+"px";
	$('prompttext').style.top = y+getPageOffsetY()+"px";

	var textarea1 = new Element('textarea', {'id':'messagetextarea','rows':'10','style':'color: black; width:390px; border: 1px solid gray; padding: 3px; overflow:hidden'});
	textarea1.value=text;

    var buttonOK = new Element('input', { 'style':'clear: both;margin-top: 5px; font-size: 8pt', 'type':'button', 'value':'<?php echo $LNG->FORM_BUTTON_PUBLISH; ?>'});
	Event.observe(buttonOK,'click', function() {
		eval( refresher + '("'+connid+'","'+textarea1.value+'","'+handler+'")' );
		textAreaCancel();
	});

    var buttonCancel = new Element('input', { 'style':'margin-left: 5px; margin-top: 5px; font-size: 8pt', 'type':'button', 'value':'<?php echo $LNG->FORM_BUTTON_CANCEL; ?>'});
	Event.observe(buttonCancel,'click', textAreaCancel);

	$('prompttext').insert(textarea1);
	$('prompttext').insert(buttonOK);
	$('prompttext').insert(buttonCancel);
	$('prompttext').style.display = "block";
}

function fadeMessage(messageStr) {
	var viewportHeight = getWindowHeight();
	var viewportWidth = getWindowWidth();
	var x = (viewportWidth-300)/2;
	var y = (viewportHeight-100)/2;
	$('message').style.left = x+getPageOffsetX()+"px";
	$('message').style.top = y+getPageOffsetY()+"px";
	$('message').update("");
	$('message').update(messageStr);
	$('message').style.display = "block";
	fadein();
    var fade=setTimeout("fadeout()",2500);
}

function fadein(){
	var element = document.getElementById("message");
	element.style.opacity = 0.0;
	fadeinloop();
}

function fadeinloop(){
	var element = document.getElementById("message");

	element.style.opacity += 0.1;
	if(element.style.opacity > 1.0) {
		element.style.opacity = 1.0;
	} else {
		setTimeout("fadeinloop()", 100);
	}
}

function fadeout(){
	var element = document.getElementById("message");
	element.style.opacity = 1.0;
	fadeoutloop();
}

function fadeoutloop(){
	var element = document.getElementById("message");

	element.style.opacity -= 0.1;
	if(element.style.opacity < 0.0) {
		element.style.opacity = 0.0;
	} else {
		setTimeout("fadeoutloop()", 100);
	}
}

function getLoading(infoText){
    var loadDiv = new Element("div",{'class':'loading'});
    loadDiv.insert("<img src='<?php echo $HUB_FLM->getImagePath('ajax-loader.gif'); ?>' alt='loading' />");
    loadDiv.insert("<br/>"+infoText);
    return loadDiv;
}

function getLoadingLine(infoText){
    var loadDiv = new Element("div",{'class':'loading'});
    loadDiv.insert("<img src='<?php echo $HUB_FLM->getImagePath('ajax-loader.gif'); ?>' alt='loading' />");
    loadDiv.insert("&nbsp;"+infoText);
    return loadDiv;
}

function nl2br (dataStr) {
	return dataStr.replace(/(\r\n|\r|\n)/g, "<br />");
}

/**
 * http://www.456bereastreet.com/archive/201105/validate_url_syntax_with_javascript/
 * MB: I modified the original as I could not get it to work as it was.
 */
function isValidURI(uri) {
    if (!uri) uri = "";

	//SERVER SIDE URL VALIDATION
	//at some point the two should match!
	//'protocol' => '((http|https|ftp|mailto)://)',
	//'access' => '(([a-z0-9_]+):([a-z0-9-_]*)@)?',
	//'sub_domain' => '(([a-z0-9_-]+\.)*)',
	//'domain' => '(([a-z0-9-]{2,})\.)',
	//'tld' =>'([a-z0-9_]+)',
	//'port'=>'(:(\d+))?',
	//'path'=>'((/[a-z0-9-_.%~]*)*)?',
	//'query'=>'(\?[^? ]*)?'

   	var schemeRE = /^([-a-z0-9]|%[0-9a-f]{2})*$/i;

   	var authorityRE = /^([-a-z0-9.]|%[0-9a-f]{2})*$/i;

   	var pathRE = /^([-a-z0-9._~:@!$&'()*+,;=\//#]|%[0-9a-f]{2})*$/i;

    var qqRE = /^([-a-z0-9._~:@!$&'\[\]()*+,;=?\/]|%[0-9a-f]{2})*$/i;
    var qfRE = /^([-a-z0-9._~:@!$&#'\[\]()*+,;=?\/]|%[0-9a-f]{2})*$/i;

    var parser = /^(?:([^:\/?]+):)?(?:\/\/([^\/?]*))?([^?]*)(?:\?([^\#]*))?(?:(.*))?/;

    var result = uri.match(parser);

    var scheme    = result[1] || null;
    var authority = result[2] || null;
    var path      = result[3] || null;
    var query     = result[4] || null;
    var fragment  = result[5] || null;

    //alert("scheme="+scheme);
    //alert("authority="+authority);
    //alert("path="+path);
    //alert("query="+query);
    //alert("fragment="+fragment);

    if (!scheme || !scheme.match(schemeRE)) {
    	//alert('scheme failed');
        return false;
    }

    if (!authority || !authority.match(authorityRE)) {
    	//alert('authority failed');
        return false;
    }
    if (path != null && !path.match(pathRE)) {
    	//alert('path failed');
        return false;
    }
    if (query && !query.match(qqRE)) {
    	//alert('query failed');
        return false;
    }
    if (fragment && !fragment.match(qfRE)) {
    	//alert('fragment failed');
        return false;
    }

    return true;
}

/**
 * http://www.wohill.com/javascript-regular-expression-for-url-check/
 */
function urlCheck(str) {
	var v = new RegExp();
	v.compile("^[A-Za-z]+://[A-Za-z0-9-_]+\\.[A-Za-z0-9-_%&\?\/.=]+$");
	if (!v.test(str)) {
		return false;
	}
	return true;
}

/**
 * Display explore page in a popup (called by applets).
 */
function viewNodeDetails(nodeid, nodetype, width, height) {
	loadDialog('details', URL_ROOT+"explore.php?id="+nodeid, width,height);
}


/**
 * Add the given connection object to the given map.
 * @param c the connection to add (json of connection returned from server).
 * @param map the name of the map applet to add the data to
 */
function addConnectionToNetworkMap(c, map) {

	var fN = c.from[0].cnode;
	var tN = c.to[0].cnode;

	var fnRole = c.fromrole[0].role;
	var fNNodeImage = "";
	if (fN.imagethumbnail != null && fN.imagethumbnail != "") {
		fNNodeImage = URL_ROOT + fN.imagethumbnail;
	} else if (fN.role[0].role.image != null && fN.role[0].role.image != "") {
		fNNodeImage = URL_ROOT + fN.role[0].role.image;
	}

	var tnRole = c.torole[0].role;
	var tNNodeImage = "";
	if (tN.imagethumbnail != null && tN.imagethumbnail != "") {
		tNNodeImage = URL_ROOT + tN.imagethumbnail;
	} else if (tN.role[0].role.image != null && tN.role[0].role.image != "") {
		tNNodeImage = URL_ROOT + tN.role[0].role.image;
	}
	var fromRole = fN.role[0].role.name;
	var toRole = tN.role[0].role.name;

	var fromDesc = "";
	if (fN.description) {
		fromDesc = fN.description;
	}
	var toDesc = "";
	if (tN.description) {
		toDesc = tN.description;
	}
	var fromName = fN.name;
	var toName = tN.name;

	// Get HEX for From Role
	var fromHEX = "";
	if (fromRole == 'Challenge') {
		fromHEX = challengebackpale;
	} else if (fromRole == 'Issue') {
		fromHEX = issuebackpale;

	} else if (fromRole == 'Claim') {
		fromHEX = claimbackpale;
	} else if (fromRole == 'Solution') {
		fromHEX = solutionbackpale;

	} else if (EVIDENCE_TYPES_STR.indexOf(fromRole) != -1) {
		fromHEX = evidencebackpale;

	} else if (fromRole == 'Project') {
		fromHEX = projectbackpale;
	} else if (fromRole == 'Organization') {
		fromHEX = orgbackpale;
	} else if (fromRole == 'Theme') {
		fromHEX = themebackpale;
	} else if (RESOURCE_TYPES_STR.indexOf(fromRole) != -1) {
		fromHEX = resourcebackpale;
	} else {
		fromHEX = plainbackpale;
	}

	// Get HEX for To Role
	var toHEX = "";
	if (toRole == 'Challenge') {
		toHEX = challengebackpale;
	} else if (toRole == 'Issue') {
		toHEX = issuebackpale;
	} else if (toRole == 'Claim') {
		toHEX = claimbackpale;
	} else if (toRole == 'Solution') {
		toHEX = solutionbackpale;
	} else if (EVIDENCE_TYPES_STR.indexOf(toRole) != -1) {
		toHEX = evidencebackpale;
	} else if (toRole == 'Project') {
		toHEX = projectbackpale;
	} else if (toRole == 'Organization') {
		toHEX = orgbackpale;
	} else if (toRole == 'Theme') {
		toHEX = themebackpale;
	} else if (RESOURCE_TYPES_STR.indexOf(toRole) != -1) {
		toHEX = resourcebackpale;
	} else {
		toHEX = plainbackpale;
	}

	if (RESOURCE_TYPES_STR.indexOf(fromRole) != -1) {
		if (fromDesc != "") {
			var tempName = fromName;
			fromName = fromDesc;
			fromDesc = tempName;
		}
	}
	if (RESOURCE_TYPES_STR.indexOf(toRole) != -1) {
		if (toDesc != "") {
			var tempName = toName;
			toName = toDesc;
			toDesc = tempName;
		}
	}

	fromRole = getNodeTitleAntecedence(fromRole, false);
	toRole = getNodeTitleAntecedence(toRole, false);

	//create from & to nodes
	$(map).addNode(fN.nodeid, fromRole+": "+fromName, fromDesc, fN.users[0].user.userid, fN.creationdate, fN.otheruserconnections, fNNodeImage, fN.users[0].user.thumb, fN.users[0].user.name, fromRole, fromHEX);
	$(map).addNode(tN.nodeid, toRole+": "+toName, toDesc, tN.users[0].user.userid, tN.creationdate, tN.otheruserconnections, tNNodeImage, tN.users[0].user.thumb, tN.users[0].user.name, toRole, toHEX);

	// add edge/conn
	var fromRoleName = fromRole;
	if (c.fromrole[0].role) {
		fromRoleName = c.fromrole[0].role.name;
	}

	var toRoleName = toRole;
	if (c.torole[0].role) {
		toRoleName = c.torole[0].role.name;
	}

	var linklabelname = c.linktype[0].linktype.label;
	linklabelname = getLinkLabelName(fN.role[0].role.name, tN.role[0].role.name, linklabelname);

	$(map).addEdge(c.connid, fN.nodeid, tN.nodeid, c.linktype[0].linktype.grouplabel, linklabelname, c.creationdate, c.userid, c.users[0].user.name, fromRoleName, toRoleName);
}

/**
 * Get the language version of the link label that should be displayed to the users.
 * Allows for local varients and internationalization.
 */
function getLinkLabelName(fromNodeTypeName, toNodeTypeName, linkName) {

	if (RESOURCE_TYPES.indexOf(fromNodeTypeName) != -1 && linkName == '<?php echo $CFG->LINK_RESOURCE_NODE; ?>') {
		return '<?php echo $LNG->LINK_RESOURCE_NODE; ?>';
	} else if (fromNodeTypeName == 'Issue' && toNodeTypeName == 'Challenge') {
		return '<?php echo $LNG->LINK_ISSUE_CHALLENGE; ?>';
	} else if (fromNodeTypeName == 'Claim' && toNodeTypeName == 'Issue') {
		return '<?php echo $LNG->LINK_CLAIM_ISSUE; ?>';
	} else if (fromNodeTypeName == 'Solution' && toNodeTypeName == 'Issue') {
		return '<?php echo $LNG->LINK_SOLUTION_ISSUE; ?>';
	} else if ((fromNodeTypeName == 'Organization' || fromNodeTypeName == 'Project')
			&& toNodeTypeName == 'Issue') {
		return '<?php echo $LNG->LINK_ORGP_ISSUE; ?>';
	} else if ((fromNodeTypeName == 'Organization' || fromNodeTypeName == 'Project')
			&& toNodeTypeName == 'Challenge') {
		return '<?php echo $LNG->LINK_ORGP_CHALLENGE; ?>';
	} else if ((fromNodeTypeName == 'Organization' || fromNodeTypeName == 'Project')
			&& toNodeTypeName == 'Claim') {
		return '<?php echo $LNG->LINK_ORGP_CLAIM; ?>';
	} else if ((fromNodeTypeName == 'Organization' || fromNodeTypeName == 'Project')
			&& toNodeTypeName == 'Solution') {
		return '<?php echo $LNG->LINK_ORGP_SOLUTION; ?>';
	} else if ((fromNodeTypeName == 'Organization' || fromNodeTypeName == 'Project')
			&& EVIDENCE_TYPES.indexOf(toNodeTypeName) != -1) {
		return '<?php echo $LNG->LINK_ORGP_EVIDENCE; ?>';
	} else if (fromNodeTypeName == 'Organization' && toNodeTypeName == 'Project') {
		return '<?php echo $LNG->LINK_ORG_PROJECT; ?>';
	} else if ((fromNodeTypeName == 'Organization' || fromNodeTypeName == 'Project')
			&& (toNodeTypeName == 'Organization' || toNodeTypeName == 'Project') ) {
		return '<?php echo $LNG->LINK_ORGP_ORGP; ?>';
	} else if (COMMENT_TYPES.indexOf(fromNodeTypeName) != -1) {
		return '<?php echo $LNG->LINK_COMMENT_NODE; ?>';
	} else if (toNodeTypeName == "Theme" && '<?php echo $CFG->LINK_NODE_THEME; ?>') {
		return '<?php echo $LNG->LINK_NODE_THEME; ?>';
	} else if (EVIDENCE_TYPES.indexOf(fromNodeTypeName) != -1 &&
				(toNodeTypeName == 'Claim' || toNodeTypeName == 'Solution')) {
		if (linkName == '<?php echo $CFG->LINK_EVIDENCE_SOLCLAIM_PRO; ?>') {
			return '<?php echo $LNG->LINK_EVIDENCE_SOLCLAIM_PRO; ?>';
		} else if (linkName == '<?php echo $CFG->LINK_EVIDENCE_SOLCLAIM_CON; ?>') {
			return '<?php echo $LNG->LINK_EVIDENCE_SOLCLAIM_CON; ?>';
		}
	} else if (linkName == '<?php echo $CFG->LINK_NODE_SEE_ALSO; ?>') {
		return '<?php echo $LNG->LINK_NODE_SEE_ALSO; ?>';
	}

	return linkName;
}

/**
 * Return the node type text to be placed before the node title
 * @param nodetype the node type for node to return the text for
 * @param withColon true if you want a colon adding after the node type name, else false.
 */
function getNodeTitleAntecedence(nodetype, withColon) {
	if (withColon == undefined) {
		withColon = true;
	}

	var title="";

	if (nodetype == 'Challenge') {
		title = "<?php echo $LNG->CHALLENGE_NAME; ?>";
	} else if (nodetype == 'Issue') {
		title = "<?php echo $LNG->ISSUE_NAME; ?>";
	} else if (nodetype == 'Claim') {
		title = "<?php echo $LNG->CLAIM_NAME; ?>";
	} else if (nodetype == 'Solution') {
		title = "<?php echo $LNG->SOLUTION_NAME; ?>";
	} else if (nodetype == 'Organization') {
		title = "<?php echo $LNG->ORG_NAME; ?>";
	} else if (nodetype == 'Project') {
		title = "<?php echo $LNG->PROJECT_NAME; ?>";
	} else if (EVIDENCE_TYPES_STR.indexOf(nodetype) != -1) { //EVIDENCE
		title = "<?php echo $LNG->EVIDENCE_NAME; ?> ("+EVIDENCE_TYPE_NAMES_SHORT[EVIDENCE_TYPES.indexOf(nodetype)]+")";
	} else if (RESOURCE_TYPES_STR.indexOf(nodetype) != -1) { //RESOURCES
		title = "<?php echo $LNG->RESOURCE_NAME; ?> ("+RESOURCE_TYPE_NAMES_SHORT[RESOURCE_TYPES.indexOf(nodetype)]+")";
	} else if (nodetype == 'Theme') {
		title = "<?php echo $LNG->THEME_NAME; ?>";
	} else if (nodetype == 'Comment') {
		title = "<?php echo $LNG->CHAT_NAME; ?>";
	} else if (nodetype == 'Idea') {
		title = "<?php echo $LNG->COMMENT_NAME; ?>";
	} else if (nodetype == 'News') {
		title = "<?php echo $LNG->NEWS_NAME; ?>";
	}

	if (withColon) {
		title += ": ";
	}

	return title;
}

function createCommentFilter(context, args) {

	var sbTool = new Element("div", {'class':'mb-3 row'});
    sbTool.insert('<label class="col-auto col-form-label"><strong><?php echo $LNG->FILTER_BY; ?></strong></label>');

	var selectWrap = new Element("div", {'class':'col-sm-5'});
	var filterMenu= new Element("select", {'class':'form-select'});

	var links = args['filterlist'];
	var includeunconnected = args['includeunconnected'];

	var option = new Element("option", {'value':'all'});
	if (links == '<?php echo $CFG->LINK_COMMENT_BUILT_FROM; ?>' && includeunconnected == 'true') {
		option.selected = true;
	}
	option.insert('<?php echo $LNG->COMMENT_FILTER_ALL ?>');
	filterMenu.insert(option);

	var option = new Element("option", {'value':'used'});
	if (links == '<?php echo $CFG->LINK_COMMENT_BUILT_FROM; ?>' && includeunconnected == 'false') {
		option.selected = true;
	}
	option.insert("<?php echo $LNG->COMMENT_FILTER_USED; ?>");
	filterMenu.insert(option);

	var option = new Element("option", {'value':'notbuiltfrom'});
	if (links == '' && includeunconnected == 'true') {
		option.selected = true;
	}
	option.insert("<?php echo $LNG->COMMENT_FILTER_UNUSED; ?>");
	filterMenu.insert(option);

	Event.observe(filterMenu,"change", function(){
		var type = this.value;

		if (type == 'notbuiltfrom' && (links != '' || includeunconnected != 'true')) {
			args['filterlist'] = "";
			args['includeunconnected'] = 'true';
			refreshComments(context, args);
		} else if (type == 'used' && (links != '<?php echo $CFG->LINK_COMMENT_BUILT_FROM; ?>' || includeunconnected != 'false')) {
			args['filterlist'] = '<?php echo $CFG->LINK_COMMENT_BUILT_FROM; ?>';
			args['includeunconnected'] = 'false';
			refreshComments(context, args);
		} else if (type == 'all' && (links != '<?php echo $CFG->LINK_COMMENT_BUILT_FROM; ?>' || includeunconnected != 'true')) {
			args['filterlist'] = '<?php echo $CFG->LINK_COMMENT_BUILT_FROM; ?>';
			args['includeunconnected'] = 'true';
			refreshComments(context, args);
		}
	});

	selectWrap.insert(filterMenu);
	sbTool.insert(selectWrap);

	return sbTool;
}

function gotoHomeList(type) {
	var reqUrl = '<?php print($CFG->homeAddress);?>index.php?#'+type+'-list';
	window.location.href = reqUrl;
	if (CONTEXT == 'global') {
		window.location.reload(true);
	}
}

function alphanodesort(a, b) {
	var nameA=a.cnode.name.toLowerCase();
	var nameB=b.cnode.name.toLowerCase();
	if (nameA < nameB) {
		return -1;
	}
	if (nameA > nameB) {
		return 1;
	}
	return 0 ;
}

function creationdatenodesortasc(a, b) {
	var nameA=a.cnode.modificationdate;
	var nameB=b.cnode.modificationdate;
	if (nameA < nameB) {
		return -1;
	}
	if (nameA > nameB) {
		return 1;
	}
	return 0 ;
}

function modedatenodesortasc(a, b) {
	var nameA=a.cnode.modificationdate;
	var nameB=b.cnode.modificationdate;
	if (nameA < nameB) {
		return -1;
	}
	if (nameA > nameB) {
		return 1;
	}
	return 0 ;
}

function modedatenodesortdesc(a, b) {
	var nameA=a.cnode.modificationdate;
	var nameB=b.cnode.modificationdate;
	if (nameA > nameB) {
		return -1;
	}
	if (nameA < nameB) {
		return 1;
	}
	return 0 ;
}


/**
 * Sort by node type in reverse alphabetical order by connections node type.
 * So we get Solutions then Claims and Pro then Con nodes, Web Resource then Publication
 */
function connectiontypenodesort(a, b) {
	var typeA = a.cnode.role[0].role.name.toLowerCase();
	var connA = a.cnode.connection;
	if (connA) {
		if (a.cnode.nodeid == connA.from[0].cnode.nodeid) {
			typeA = connA.fromrole[0].role.name.toLowerCase();
		} else {
			typeA = connA.torole[0].role.name.toLowerCase();
		}
	}
	var typeB = b.cnode.role[0].role.name.toLowerCase();
	var connB = b.cnode.connection;
	if (connB) {
		if (b.cnode.nodeid == connB.from[0].cnode.nodeid) {
			typeB = connB.fromrole[0].role.name.toLowerCase();
		} else {
			typeB = connB.torole[0].role.name.toLowerCase();
		}
	}
	if (typeA > typeB) {
		return -1;
	}
	if (typeA < typeB) {
		return 1;
	}
	return 0;
}

/**
 * Sort by node name after a sort by connection node type has been done.
 * @see connectiontypenodesort
 */
function connectiontypealphanodesort(a, b) {
	var nameA=a.cnode.name.toLowerCase();
	var nameB=b.cnode.name.toLowerCase();

	var typeA = a.cnode.role[0].role.name.toLowerCase();
	var connA = a.cnode.connection;
	if (connA) {
		if (a.cnode.nodeid == connA.from[0].cnode.nodeid) {
			typeA = connA.fromrole[0].role.name.toLowerCase();
		} else {
			typeA = connA.torole[0].role.name.toLowerCase();
		}
	}
	var typeB = b.cnode.role[0].role.name.toLowerCase();
	var connB = b.cnode.connection;
	if (connB) {
		if (b.cnode.nodeid == connB.from[0].cnode.nodeid) {
			typeB = connB.fromrole[0].role.name.toLowerCase();
		} else {
			typeB = connB.torole[0].role.name.toLowerCase();
		}
	}

	if (typeA == typeB) {
		if (nameA < nameB) {
			return -1;
		} else if (nameA > nameB) {
			return 1;
		}
	}
	return 0;
}

function removeHTMLTags(htmlString) {
	var cleanString = "";
	if(htmlString){
		var mydiv = document.createElement("div");
		mydiv.innerHTML = htmlString;
		if (document.all) {
			cleanString = mydiv.innerText;
		} else {
			cleanString = mydiv.textContent;
		}
  	}

  	return cleanString.trim();
}

/**
 * Used to switch a textarea between plain text and full HTML editor box.
 */
function switchCKEditorMode(link, divname, editorname) {
	// the previous test was not working, so just comparing title text.
	if (link.title == '<?php echo $LNG->FORM_DESC_HTML_TEXT_HINT; ?>') {
		CKEDITOR.replace(editorname, {
			on : { instanceReady : function( ev ) { this.focus(); } }
		} );

		$(divname).style.clear = 'both';
		link.innerHTML = '<?php echo $LNG->FORM_DESC_PLAIN_TEXT_LINK; ?>'
		link.title = '<?php echo $LNG->FORM_DESC_PLAIN_TEXT_HINT; ?>';
	} else {
		var ans = confirm("<?php echo $LNG->FORM_DESC_HTML_SWITCH_WARNING; ?>");
		if (ans == true) {
			if (CKEDITOR.instances[editorname]) {
				CKEDITOR.instances[editorname].destroy();
			}
			$(divname).style.clear = 'none';
			link.innerHTML = '<?php echo $LNG->FORM_DESC_HTML_TEXT_LINK; ?>';
			link.title = '<?php echo $LNG->FORM_DESC_HTML_TEXT_HINT; ?>';
			$(editorname).value = removeHTMLTags($(editorname).value);
		}
	}
}

function htmlspecialchars_decode (string, quote_style) {
  // http://kevin.vanzonneveld.net
  // +   original by: Mirek Slugen
  // +   improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
  // +   bugfixed by: Mateusz "loonquawl" Zalega
  // +      input by: ReverseSyntax
  // +      input by: Slawomir Kaniecki
  // +      input by: Scott Cariss
  // +      input by: Francois
  // +   bugfixed by: Onno Marsman
  // +    revised by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
  // +   bugfixed by: Brett Zamir (http://brett-zamir.me)
  // +      input by: Ratheous
  // +      input by: Mailfaker (http://www.weedem.fr/)
  // +      reimplemented by: Brett Zamir (http://brett-zamir.me)
  // +    bugfixed by: Brett Zamir (http://brett-zamir.me)
  // *     example 1: htmlspecialchars_decode("<p>this -&gt; &quot;</p>", 'ENT_NOQUOTES');
  // *     returns 1: '<p>this -> &quot;</p>'
  // *     example 2: htmlspecialchars_decode("&amp;quot;");
  // *     returns 2: '&quot;'
  var optTemp = 0,
    i = 0,
    noquotes = false;
  if (typeof quote_style === 'undefined') {
    quote_style = 2;
  }
  string = string.toString().replace(/&lt;/g, '<').replace(/&gt;/g, '>');
  var OPTS = {
    'ENT_NOQUOTES': 0,
    'ENT_HTML_QUOTE_SINGLE': 1,
    'ENT_HTML_QUOTE_DOUBLE': 2,
    'ENT_COMPAT': 2,
    'ENT_QUOTES': 3,
    'ENT_IGNORE': 4
  };
  if (quote_style === 0) {
    noquotes = true;
  }
  if (typeof quote_style !== 'number') { // Allow for a single string or an array of string flags
    quote_style = [].concat(quote_style);
    for (i = 0; i < quote_style.length; i++) {
      // Resolve string input to bitwise e.g. 'PATHINFO_EXTENSION' becomes 4
      if (OPTS[quote_style[i]] === 0) {
        noquotes = true;
      } else if (OPTS[quote_style[i]]) {
        optTemp = optTemp | OPTS[quote_style[i]];
      }
    }
    quote_style = optTemp;
  }
  if (quote_style & OPTS.ENT_HTML_QUOTE_SINGLE) {
    string = string.replace(/&#0*39;/g, "'"); // PHP does not currently escape if more than one 0, but it should
    // string = string.replace(/&apos;|&#x0*27;/g, "'"); // This would also be useful here, but not a part of PHP
  }
  if (!noquotes) {
    string = string.replace(/&quot;/g, '"');
  }

  // Put this in last place to avoid escape being double-decoded
  string = string.replace(/&amp;/g, '&');

  return string;
}


/**
 * Replacing function from Scriptaculous. Can now be done with css.
 * Highlight an element transitioning between two highlight colours and finally restore it to a given colour.
 * @param item, the item to tranition the background colour on.
 * @param options, the options to use - object containing 'startcolor', 'endcolor', 'restorecolor', 'duration'
 */
function highlightElement(item, options) {

	// Prevent executing on elements not in the layout flow
	if (item.style.display == 'none') { return; }

	if (!options.restorecolor)
		options.restorecolor = item.style.backgroundColor;

    item.style.backgroundColor = options['startcolor'];

	item.style.webkitTransform = 'background-color '+options.duration+'s linear';
	item.style.MozTransform = 'background-color '+options.duration+'s linear';
	item.style.msTransform = 'background-color '+options.duration+'s linear';
	item.style.OTransform = 'background-color '+options.duration+'s linear';
	item.style.transition = 'background-color '+options.duration+'s linear';

	// Needed so that initial color and transition are applied before the transition is later triggered.
    setTimeout(function() {
		 highlightElementComplete(item, options);
    }, 100);

}

function highlightElementComplete(item, options) {

	// trigger transition
	item.style.backgroundColor = options['endcolor'];

	// Put it all back to normal about when transition should end plus a bit.
	var totalwait = parseInt((options.duration+1) * 1000); //convert seconds to milliseconds
    setTimeout(function() {
		item.style.transition = 'none';
		item.style.webkitTransform = 'none';
		item.style.MozTransform = 'none';
		item.style.msTransform = 'none';
		item.style.OTransform = 'none';
   		item.style.backgroundColor = options['restorecolor'];
    },totalwait);
}

/**
 * Add new new Script tag to the current HTML page dynamically to load a local javascript file on demand.
 *
 * @param url The url to add as the src on the new script tag
 * @param id If given set as the id of the new script tag
 */
function addScriptDynamically(url, id) {

	// only allow the import of local code;
	if (url.indexOf(URL_ROOT) == 0) {
		var headarea = document.getElementsByTagName("head").item(0);
		var scriptobj = document.createElement("script");
		scriptobj.setAttribute("type", "text/javascript");
		scriptobj.setAttribute("src", url);
		if (id) {
			scriptobj.setAttribute("id", id);
		}
		headarea.appendChild(scriptobj);
	}
}