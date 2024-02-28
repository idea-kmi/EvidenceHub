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
/**
 * REST service API
 *
 * All the methods listed are are available to users through REST-style URL calls
 * The methods should call the corresponding methods in the PHP API (core/apilib.php)
 *
 */

include_once('../config.php');

global $USER,$CFG,$LNG;

//send the header info
set_service_header();

$method = optional_param("method","",PARAM_ALPHA);

// If this system has been set to be a private Site that means all access requires login.
// So unless your API request is to login, check they are logged in before proceeding.
if ($CFG->privateSite && $method != "login" && (!isset($USER->userid) || $USER->userid == "")) {
    global $ERROR;
    $ERROR = new Hub_Error;
    $ERROR->createAccessDeniedError();
	include($HUB_FLM->getCodeDirPath("core/formaterror.php"));
    die;
}

// optional params for ordering, max no and sorting sets of objects and filtering
$start = optional_param("start",0,PARAM_INT);
$max = optional_param("max",20,PARAM_INT);
$o = optional_param("orderby","date",PARAM_ALPHA);
$s = optional_param("sort","DESC",PARAM_ALPHA);
$filterlinkgroup = optional_param("filtergroup","all", PARAM_TEXT);
$filterlinktypes = optional_param("filterlist","", PARAM_TEXT);
$filternodetypes = optional_param('filternodetypes', '', PARAM_TEXT);
$filterthemes = optional_param('filterthemes', '', PARAM_TEXT);
$style= optional_param('style','long',PARAM_TEXT);

// this needs to be locked down, as the Evidence Hub is an open system and does not give this choice as Cohere does.
$private = "N";

//check start and max are more than 0!
if($start < 0){
    $start = 0;
}
if ($max < -1 ){
    $max = -1;
}

$response = "";
switch($method) {

	/** LOGIN IN / OUT **/
    case "validatesession":
        $userid = required_param('userid',PARAM_TEXT);
        $response = validateUserSession($userid);
        break;
    case "login":
        $username = required_param('username',PARAM_TEXT);
        $password = required_param('password',PARAM_TEXT);
        $response = login($username,$password);
        break;
    case "logout":
        clearSession();
        $response = new Result("logout","logged out");
        break;

    /** NODES **/
    case "getnode":
        $nodeid = required_param('nodeid',PARAM_TEXT);
        $response = getNode($nodeid,$style);
        break;
 	case "addnode":
        $name = required_param('name',PARAM_TEXT);
        $desc = required_param('desc',PARAM_HTML);
        $nodetypeid = optional_param('nodetypeid',"",PARAM_TEXT);
        $imageurlid = optional_param('imageurlid',"",PARAM_TEXT);
        $imagethumbnail = optional_param('imagethumbnail',"",PARAM_TEXT);
        $response = addNode($name,$desc,$private,$nodetypeid,$imageurlid,$imagethumbnail);
        break;
 	case "addnodeandconnect":
        $name = required_param('name',PARAM_TEXT);
        $desc = required_param('desc',PARAM_HTML);
        $nodetypename = required_param('nodetypename',PARAM_TEXT);
        $focalnodeid = required_param('focalnodeid',PARAM_ALPHANUMEXT);
        $linktypename = required_param('linktypename',PARAM_TEXT);
        $direction = optional_param('direction','from',PARAM_ALPHA);
        $imageurlid = optional_param('imageurlid',"",PARAM_TEXT);
        $imagethumbnail = optional_param('imagethumbnail',"",PARAM_TEXT);
        $resourcetypes = optional_param('resourcetypes',"",PARAM_TEXT);
        $resourceurls = optional_param('resourceurls',"",PARAM_TEXT);
        $resourcetitles = optional_param('resourcetitles',"",PARAM_TEXT);
        $resourcedois = optional_param('resourcedois',"",PARAM_TEXT);
        $response = addNodeAndConnect($name,$desc,$nodetypename,$focalnodeid,$linktypename,$direction,$private,$imageurlid,$imagethumbnail,$resourcetypes,$resourceurls,$resourcetitles,$resourcedois);
        break;
    case "editnode":
        $nodeid = required_param('nodeid',PARAM_TEXT);
        $name = required_param('name',PARAM_TEXT);
        $desc = required_param('desc',PARAM_HTML);
        $nodetypeid = optional_param('nodetypeid',"",PARAM_TEXT);
        $response = editNode($nodeid,$name,$desc,$private,$nodetypeid);
        break;
    case "updatenodestartdate":
        $nodeid = required_param('nodeid',PARAM_TEXT);
        $startdatetime = optional_param('startdatetime',"",PARAM_TEXT);
        $response = updateNodeStartDate($nodeid,$startdatetime);
        break;
    case "updatenodeenddate":
        $nodeid = required_param('nodeid',PARAM_TEXT);
        $enddatetime = optional_param('enddatetime',"",PARAM_TEXT);
        $response = updateNodeEndDate($nodeid,$enddatetime);
        break;
    case "updatenodelocation":
        $nodeid = required_param('nodeid',PARAM_TEXT);
        $location = optional_param('location',"",PARAM_TEXT);
        $loccountry = optional_param('loccountry',"",PARAM_TEXT);
        $address1 = optional_param('address1',"",PARAM_TEXT);
        $address2 = optional_param('address2',"",PARAM_TEXT);
        $postcode = optional_param('postcode',"",PARAM_TEXT);
        $response = updateNodeLocation($nodeid,$location,$loccountry,$address1,$address2,$postcode);
        break;
    case "deletenode":
        $nodeid = required_param('nodeid',PARAM_TEXT);
        $response = deleteNode($nodeid);
        break;
    case "getnodesbydate":
        $date = required_param('date',PARAM_INT);
        $response = getNodesByDate($date,$start,$max,$o,$s,$style);
        break;
    case "getnodesbyname":
        $name = required_param('name',PARAM_TEXT);
        $response = getNodesByName($name,$start,$max,$o,$s,$style);
        break;
    case "getnodesbytag":
        $tagid= required_param('tagid',PARAM_TEXT);
        $response = getNodesByTag($tagid,$start,$max,$o,$s,$style);
        break;
    case "getnodesbyurl":
        $url= required_param('url',PARAM_URL);
        $response = getNodesByURL($url,$start,$max,$o,$s,$filternodetypes,$style);
        break;
    case "getnodesbyuser":
        $userid = required_param('userid',PARAM_TEXT);
        $query = optional_param('q', "",PARAM_TEXT);
        $connectionfilter = optional_param('filterbyconnection','',PARAM_ALPHA);
        $response = getNodesByUser($userid,$start,$max,$o,$s,$filternodetypes,$filterthemes,$style, $query, $connectionfilter);
        break;
    case "getnodesbyglobal":
        $query = optional_param('q', "",PARAM_TEXT);
        $scope = optional_param('scope','all',PARAM_TEXT);
        $tagsonly = optional_param('tagsonly',false,PARAM_BOOL);
        $connectionfilter = optional_param('filterbyconnection','',PARAM_ALPHA);
        $response = getNodesByGlobal($start,$max,$o,$s,$filternodetypes,$filterthemes,$style,$query,$scope,$tagsonly,$connectionfilter);
        break;
    case "getunconnectednodesbyglobal":
        $query = optional_param('q', "",PARAM_TEXT);
        $scope = optional_param('scope','all',PARAM_TEXT);
        $tagsonly = optional_param('tagsonly',false,PARAM_BOOL);
        $response = getUnconnectedNodesByGlobal($start,$max,$o,$s,$filternodetypes,$filterthemes,$style,$query,$scope,$tagsonly);
        break;
    case "getunconnectednodesbyuser":
        $userid = required_param('userid',PARAM_TEXT);
        $query = optional_param('q', "",PARAM_TEXT);
        $scope = optional_param('scope','all',PARAM_TEXT);
        $tagsonly = optional_param('tagsonly',false,PARAM_BOOL);
        $response = getUnconnectedNodesByUser($userid,$start,$max,$o,$s,$filternodetypes,$filterthemes,$style,$query,$scope,$tagsonly);
        break;
    case "getconnectednodesbyglobal":
        $query = optional_param('q', "",PARAM_TEXT);
        $includeunconnected = optional_param('includeunconnected', false,PARAM_BOOL);
        $response = getConnectedNodesByGlobal($start,$max,$o,$s,$filterlinkgroup,$filterlinktypes,$filternodetypes,$style,$query,$includeunconnected);
        break;
    case "getconnectednodesbyuser":
        $userid = required_param('userid',PARAM_TEXT);
        $query = optional_param('q', "",PARAM_TEXT);
        $includeunconnected = optional_param('includeunconnected', false,PARAM_BOOL);
        $response = getConnectedNodesByUser($userid,$start,$max,$o,$s,$filterlinkgroup,$filterlinktypes,$filternodetypes,$style,$query,$includeunconnected);
        break;
    case "getmostconnectednodes":
        $scope = optional_param('scope','my',PARAM_TEXT);
        $response = getMostConnectedNodes($scope,$start,$max,$style);
        break;
    case "getnodesbyfirstcharacters":
        $query = required_param('q',PARAM_TEXT);
        $scope = optional_param('scope','my',PARAM_TEXT);
        $response = getNodesByFirstCharacters($query,$scope,$start,$max,"name","ASC",$filternodetypes,$style);
        break;

	/** RESOURCE **/
    case "addwebresource":
        $url = required_param('url',PARAM_URL);
        $title = required_param('title',PARAM_TEXT);
        $desc = required_param('desc',PARAM_TEXT);
        $clip = optional_param('clip',"",PARAM_TEXT);
        $clippath = urldecode(optional_param('clippath',"",PARAM_HTML));
        $response = addWebResource($url, $title, $desc, $private,$clip, $clippath);
        break;
    case "editresource":
        $nodeid = required_param('nodeid',PARAM_TEXT);
        $nodetypename = required_param('nodetypename',PARAM_TEXT);
        $title = required_param('title',PARAM_TEXT);
        $desc = required_param('desc',PARAM_TEXT);
        $url = required_param('url',PARAM_URL);
        $identifier = optional_param('identifier',"",PARAM_TEXT);
        $clip = optional_param('clip',"",PARAM_TEXT);
        $clippath = urldecode(optional_param('clippath',"",PARAM_HTML));

        $response = editWebResource($nodeid, $nodetypename, $title, $desc, $url, $private, $identifier, $clip, $clippath);
        break;

    /** URLS **/
    case "autocompleteurldetails":
        $url= required_param('url',PARAM_URL);
        $response = autoCompleteURLDetails($url);
        break;
    case "addurl":
        $url = required_param('url',PARAM_URL);
        $title = required_param('title',PARAM_TEXT);
        $desc = required_param('desc',PARAM_TEXT);
        $clip = optional_param('clip',"",PARAM_TEXT);
        $clippath = urldecode(optional_param('clippath',"",PARAM_HTML));
        //$cliphtml = urldecode(optional_param('cliphtml',"",PARAM_HTML));
        $cliphtml = "";
        $response = addURL($url, $title, $desc, $private,$clip, $clippath, $cliphtml);
        break;
    case "deleteurl":
        $urlid = required_param('urlid',PARAM_TEXT);
        $response = deleteURL($urlid);
        break;

    /** CONNECTING NODE AND URL **/
    case "addurltonode":
        $urlid = required_param('urlid',PARAM_TEXT);
        $nodeid = required_param('nodeid',PARAM_TEXT);
        $comments = optional_param("comments","",PARAM_TEXT);
        $response = addURLToNode($urlid,$nodeid,$comments);
        break;

    /** CONNECTIONS **/
    case "getconnection":
        $connid = required_param('connid',PARAM_TEXT);
        $response = getConnection($connid,$style);
        break;
    case "getconnectionsbyuser":
        $query = required_param('q',PARAM_TEXT);
        $userid = required_param('userid',PARAM_TEXT);
        $response = getConnectionsByUser($userid,$start,$max,$o,$s,$filterlinkgroup,$filterlinktypes,$filternodetypes,$style,$query);
        break;
    case "getconnectionsbyglobal":
        $query = optional_param('q', "",PARAM_TEXT);
        $scope = optional_param('scope','all',PARAM_TEXT);
        $tagsonly = optional_param('tagsonly',false,PARAM_BOOL);
        $themename = optional_param('themename','',PARAM_TEXT);
        $response = getConnectionsByGlobal($start,$max,$o,$s,$filterlinkgroup,$filterlinktypes,$filternodetypes,$themename,$style,$query,$scope,$tagsonly);
        break;
    case "getconnectionsbynode":
        $nodeid = required_param('nodeid',PARAM_TEXT);
        $response = getConnectionsByNode($nodeid,$start,$max,$o,$s,$filterlinkgroup,$filterlinktypes,$filternodetypes,$style);
        break;
   	case "getconnectionsbyurl":
        $url= required_param('url',PARAM_TEXT);
        $response = getConnectionsByURL($url,$start,$max,$o,$s,$filterlinkgroup,$filterlinktypes,$filternodetypes,$style);
        break;
    case "getconnectionsbysocial":
        $linklabels = required_param('linklabels',PARAM_TEXT);
        $filternodetypes = required_param('filternodetypes',PARAM_TEXT);
        $scope = optional_param('scope','all',PARAM_TEXT);
        $userid = optional_param('userid', '', PARAM_TEXT);
        $response = getConnectionsBySocial($scope,$start,$max,$o,$s,$linklabels,$filternodetypes,$userid,$style);
        break;
    case "getmulticonnections":
        $connectionids = parseToJSON(required_param('connectionids',PARAM_TEXT)); // needs this parsing to convert single speech marks back.
        $response = getMultiConnections($connectionids,$start,$max,$o,$s,$style);
    	break;
    case "getconnectionsbypath":
        $nodeid = required_param('nodeid',PARAM_TEXT);
        $linklabels = required_param('linklabels',PARAM_TEXT);
        $scope = optional_param('scope','all',PARAM_TEXT);
        $userid = ""; //optional_param('userid','',PARAM_TEXT);
        $linkgroup = optional_param('linkgroup','',PARAM_TEXT);
        $depth = optional_param('depth','7',PARAM_INT);
        $direction = optional_param('direction','both',PARAM_TEXT);
        $labelmatch = optional_param('labelmatch','false',PARAM_TEXT);
        $nodetypes = optional_param('nodetypes',null,PARAM_TEXT);
        $response = getConnectionsByPath($nodeid,$linklabels,$userid,$scope,$linkgroup,$depth,$direction,$labelmatch,$nodetypes,$style);
        break;
    case "getconnectionsbypathbydepth":
        $nodeid = optional_param('nodeid','',PARAM_TEXT);
        $searchid = optional_param('searchid','', PARAM_TEXT);
        $scope = optional_param('scope','all',PARAM_TEXT);
        $labelmatch = optional_param('labelmatch','false',PARAM_TEXT);
        $depth = optional_param('depth','7',PARAM_INT);
        $linklabels = optional_param('linklabels',null,PARAM_TEXT);
        $linkgroups = optional_param('linkgroups',null,PARAM_TEXT);
        $directions = optional_param('directions',null,PARAM_TEXT);
        $nodetypes = optional_param('nodetypes',null,PARAM_TEXT);
        $nodeids = optional_param('nodeids',null,PARAM_TEXT);
        $logictype = optional_param('logictype','or',PARAM_TEXT);
        $uniquepath = optional_param('uniquepath','false',PARAM_TEXT);
        $response = getConnectionsByPathByDepth($logictype,$scope,$labelmatch,$nodeid,$depth,$linklabels,$linkgroups,$directions,$nodetypes,$nodeids, $uniquepath, $style);
	    break;
 	case "addconnection":
        $fromnodeid = required_param('fromnodeid',PARAM_TEXT);
        $fromroleid = required_param('fromroleid',PARAM_TEXT);
        $linktypeid = required_param('linktypeid',PARAM_TEXT);
        $tonodeid = required_param('tonodeid',PARAM_TEXT);
        $toroleid = required_param('toroleid',PARAM_TEXT);
        $description = optional_param('description',"",PARAM_TEXT);
        $response = addConnection($fromnodeid,$fromroleid,$linktypeid,$tonodeid,$toroleid,$private,$description);
        break;
 	case "addconnectionlinkname":
        $fromnodeid = required_param('fromnodeid',PARAM_TEXT);
        $fromroleid = required_param('fromroleid',PARAM_TEXT);
        $linktypename = required_param('linktypename',PARAM_TEXT);
        $tonodeid = required_param('tonodeid',PARAM_TEXT);
        $toroleid = required_param('toroleid',PARAM_TEXT);
        $description = optional_param('description',"",PARAM_TEXT);

        $link = getLinkTypeByLabel($linktypename);
        if (!$link instanceof Hub_Error) {
        	$response = addConnection($fromnodeid,$fromroleid,$link->linktypeid,$tonodeid,$toroleid,$private,$description);
        } else {
			$ERROR = new Hub_Error;
			return $ERROR->createInvalidConnectionError();
        }
        break;
   case "editconnectiondescription":
        $connid = required_param('connid',PARAM_TEXT);
        $description = optional_param('description',"",PARAM_TEXT);
        $response = editConnectionDescription($connid,$description);
        break;
    case "deleteconnection":
        $connid = required_param('connid',PARAM_TEXT);
        $response = deleteConnection($connid);
        break;

    /** ROLES aka NODE TYPES **/
    case "getrolebyname":
        $rolename = required_param('rolename',PARAM_TEXT);
        $response = getRoleByName($rolename);
        break;

    /** LINK TYPES **/
    case "getlinktypebylabel":
        $label = required_param('label',PARAM_TEXT);
        $response = getLinkTypeByLabel($label);
        break;

    /** USERS **/
	case "getuser":
		$userid = required_param('userid',PARAM_TEXT);
		$response = getUser($userid,$style);
		break;
    case "getactiveconnectionusers":
    	$response = getActiveConnectionUsers($start,$max,$style);
    	break;
    case "getactiveideausers":
    	$response = getActiveIdeaUsers($start,$max,$style);
    	break;
    case "getusersbyfollowing":
        $itemid = required_param('itemid',PARAM_TEXT);
        $response = getUsersByFollowing($itemid,$start,$max,$o,$s,$style);
        break;
    case "getusersbyfollowingbydate":
        $itemid = required_param('itemid',PARAM_TEXT);
        $from = required_param('from',PARAM_INT);
        $response = getUsersByFollowingByDate($itemid,$from,$start,$max,$o,$s,$style);
        break;
    case "getusersbymostfollowed":
        $limit = required_param('limit',PARAM_TEXT);
    	$response = getUsersByMostFollowed($limit,$style);
    	break;
    case "getusersmostactive":
        $limit = required_param('limit',PARAM_TEXT);
        $from = required_param('from',PARAM_INT);
    	$response = getUsersMostActive($limit, $from, $style);
    	break;
    case "getusersbyglobal":
        $includegroups = optional_param('includegroups',false,PARAM_BOOL);
        $query = optional_param('q', "", PARAM_TEXT);
        $response = getUsersByGlobal($includegroups, $start,$max,$o,$s,$style,$query);
        break;

    /** TAGS **/
    case "gettag":
        $tagid = required_param('tagid',PARAM_TEXT);
        $response = getTag($tagid);
        break;
    case "getusertags":
        $response = getUserTags();
        break;
    case "addtag":
        $tagname = required_param('tagname',PARAM_TEXT);
        $response = addTag($tagname);
        break;
    case "edittag":
        $tagid = required_param('tagid',PARAM_TEXT);
        $tagname = required_param('tagname',PARAM_TEXT);
        $response = editTag($tagid,$tagname);
        break;
    case "deletetag":
        $tagid = required_param('tagid',PARAM_TEXT);
        $response = deleteTag($tagid);
        break;
    case "gettagsbyfirstcharacters":
        $query = required_param('q',PARAM_TEXT);
        $scope = optional_param('scope','my',PARAM_TEXT);
        $response = getTagsByFirstCharacters($query,$scope);
        break;

    /** VOTING **/
	case "nodevote":
        $vote = required_param('vote',PARAM_TEXT);
        $nodeid = required_param('nodeid',PARAM_TEXT);
        $response = nodeVote($nodeid, $vote);
		break;
	case "deletenodevote":
        $vote = required_param('vote',PARAM_TEXT);
        $nodeid = required_param('nodeid',PARAM_TEXT);
        $response = deleteNodeVote($nodeid, $vote);
		break;
	case "connectionvote":
        $vote = required_param('vote',PARAM_TEXT);
        $connid = required_param('connid',PARAM_TEXT);
        $response = connectionVote($connid, $vote);
		break;
	case "deleteconnectionvote":
        $vote = required_param('vote',PARAM_TEXT);
        $connid = required_param('connid',PARAM_TEXT);
        $response = deleteConnectionVote($connid, $vote);
		break;
	case "getvotes":
        $itemid = required_param('itemid',PARAM_TEXT);
        $response = getVotes($itemid);
		break;

	/** FOLLOWING **/
	case "addfollowing":
        $itemid = required_param('itemid',PARAM_TEXT);
        $response = addFollowing($itemid);
		break;
	case "deletefollowing":
        $itemid = required_param('itemid',PARAM_TEXT);
        $response = deleteFollowing($itemid);
		break;

   	/** ADDED FOR EVIDENCE HUB **/
   	case "getthemeconnectionsbynode":
        $nodeid = required_param('nodeid',PARAM_TEXT);
        $scope = optional_param('scope','all',PARAM_TEXT);
        $response = getThemeConnectionsByNode($nodeid,$start,$max,$o,$s,$style,$scope);
    	break;
   	case "gettypeconnectionsbytheme":
        $theme = required_param('theme',PARAM_TEXT);
 		$type = required_param('type',PARAM_TEXT);
 		$response = getTypeConnectionsByTheme($theme,$type, $start,$max,$o,$s,$style);
    	break;
    case "getmostpopularthemesbytype":
        $filternodetypes = required_param('filternodetypes',PARAM_TEXT);
        $limit = required_param('limit',PARAM_TEXT);
   		$response = getMostPopularThemesByType($filternodetypes, $limit, $style);
   		break;
	case "connectnodetotheme":
        $themename = required_param('themename',PARAM_TEXT);
        $nodeid = required_param('nodeid',PARAM_TEXT);
   		$response = connectNodeToTheme($nodeid, $themename, $style);
   		break;
	case "getthemenodebyname":
        $name = required_param('name',PARAM_TEXT);
		$response = getNodeByName($name, $style);
 		break;
 	case "deletecomment":
        $nodeid = required_param('nodeid',PARAM_TEXT);
        $parentconnid = optional_param('parentconnid', "", PARAM_TEXT);
        $response = deleteComment($nodeid, $parentconnid);
   		break;
 	case "connectnodetocomment":
        $comment = required_param('comment',PARAM_TEXT);
        $nodeid = required_param('nodeid',PARAM_TEXT);
        $nodetypename = required_param('nodetypename',PARAM_TEXT);

        $parentconnid = optional_param('parentconnid',"", PARAM_TEXT);
        $parentid = optional_param('parentid',"", PARAM_TEXT);

        $response = connectNodeToComment($nodeid, $nodetypename, $comment, $parentconnid, $parentid, $style);
   		break;
 	case "auditsearch":
        $query = required_param('q',PARAM_TEXT);
        $tagsonlyoption = optional_param('tagsonly','N',PARAM_TEXT);
		$type = optional_param('type','main',PARAM_ALPHA);
		$typeitemid = optional_param('typeitemid','',PARAM_TEXT);
		$searchid = "";
        if (isset($USER->userid)) {
 			$searchid = auditSearch($USER->userid, $query, $tagsonlyoption, $type, $typeitemid);
        }
 		$response = $searchid;
 		break;
 	case "gettreedata":
		$fromdate = optional_param('fromdate','',PARAM_TEXT);
		$todate = optional_param('todate','',PARAM_TEXT);
        $response = getTreeData($fromdate, $todate);
 		break;

 	case "logchatuserarrive":
        $nodeid = required_param('nodeid',PARAM_TEXT);
        if (isset($USER->userid) && $USER->userid != "") {
            if(!file_exists($CFG->dirAddress.$CFG->domainfolder.'uploads/chats/')){
	            mkdir($CFG->dirAddress.$CFG->domainfolder.'uploads/chats/', 0770, true);
	        }

			if (file_exists($CFG->dirAddress.$CFG->domainfolder.'uploads/chats/'.$nodeid.'.json')) {
				$file = $CFG->dirAddress.$CFG->domainfolder.'uploads/chats/'.$nodeid.'.json';
				$userArray = json_decode(file_get_contents($file), TRUE);
				$userArray[$USER->userid] = time();
				$content = json_encode($userArray);
				file_put_contents($file, $content);
			} else {
				$file = $CFG->dirAddress.$CFG->domainfolder.'uploads/chats/'.$nodeid.'.json';
				$userArray[$USER->userid] = time();
				$content = json_encode($userArray);
				file_put_contents($file, $content);
			}
        }
  		$response = "{'chat':'logged'}";
		break;

 	case "logchatuserleave":
        $nodeid = required_param('nodeid',PARAM_TEXT);
        error_log("LEAVE:".$nodeid);
        if (isset($USER->userid) && $USER->userid != "") {
            if(!file_exists($CFG->dirAddress.$CFG->domainfolder.'uploads/chats/')){
	            mkdir($CFG->dirAddress.$CFG->domainfolder.'uploads/chats/', 0770, true);
	        }

			if (file_exists($CFG->dirAddress.$CFG->domainfolder.'uploads/chats/'.$nodeid.'.json')) {
				$file = $CFG->dirAddress.$CFG->domainfolder.'uploads/chats/'.$nodeid.'.json';
				$userArray = json_decode(file_get_contents($file), TRUE);
				if (array_key_exists($USER->userid, $userArray)) {
				    unset($userArray[$USER->userid]);
					$content = json_encode($userArray);
					file_put_contents($file, $content);
				}
			}
        }
 		$response = "{'chat':'logged'}";

 		break;

 	case "getchatpresence":
        $nodeid = required_param('nodeid',PARAM_TEXT);
		$response = "";
        if (isset($USER->userid) && $USER->userid != "") {
			if (file_exists($CFG->dirAddress.$CFG->domainfolder.'uploads/chats/'.$nodeid.'.json')) {
				$file = $CFG->dirAddress.$CFG->domainfolder.'uploads/chats/'.$nodeid.'.json';
				$userArray = json_decode(file_get_contents($file), TRUE);
				$users = new UserSet();
				foreach ($userArray as $user => $time) {
					// check time and remove old entries
					// if more than 8 hours old, probably not really still on chat page
					$oldtime = time() - (8 * 60 * 60);
					if ($time < $oldtime) {
						unset($userArray[$user]);
					} else {
						$next = new User($user);
						$next->chatlogtime = $time;
						$next = $next->load();
						$users->add($next);
					}
				}
				$content = json_encode($userArray);
				file_put_contents($file, $content);
				$response = $users;
			}
		}
 		break;

    default:
        //error as method not defined.
        global $ERROR;
        $ERROR = new Hub_Error;
        $ERROR->createInvalidMethodError();
        include($HUB_FLM->getCodeDirPath("core/formaterror.php"));
        die;
}

// finally format the output based on the format param in url
echo format_output($response);
?>