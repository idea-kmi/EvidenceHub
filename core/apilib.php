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
 *
 * Evidence Hub API functions
 *
 * <p>This page describes the services currently available through the Evidence Hub API. The service base URL depends on your Hub subdomain, for example:
 * <pre>
 *     <a href="http://edfutures.evidence-hub.net/api/service.php">http://edfutures.evidence-hub.net/api/service.php</a>
 * </pre>
 * where 'edfutures' should be replaced with your subdomain name. The service URL will always require a 'method' parameter.</p>
 *
 * <p>In all service calls, an optional parameter 'format' can be provided
 * to set how the output is displayed, the default is 'xml', but other options currently are 'gmap','json','list','rss', 'shortxml' and 'simile'.
 * Not all formats are available with all methods, as explained below:</p>
 * <ul>
 * <li>'xml' and 'json' formats are available to all methods</li>
 * <li>'rss' and 'shortxml' formats are only available to methods which return a NodeSet or ConnectionSet
 * <li>'gmap' and 'simile' formats are only available to methods which return a NodeSet.</li>
 * <li>'list' format is available to methods which return a NodeSet or a TagSet.</li>
 * </ul>
 *<span> If you specify 'json' as the output format, then you can (optionally) provide a parameter 'callback'.</span>
 *<br>
 *
 * <p>Although all the example services calls show the parameters passed as GET requests, parameters will be accepted as either GET or POST -
 * so the parameters can be provided in any order - not just the order in which they've been listed on this page.</p>
 *
 * <p>Some services require a valid user login to work (essentially any add, edit or delete method) and in these cases, when you call
 * the service, you must also provide a valid Evidence Hub session cookie, this can be obtained by calling the login service.
 * If you are calling the services via your web browser, you won't need to worry much about this, as your browser will automatically store and send
 * the cookie with each service call.</p>
 *
 * <p>If you are using a script to automate requests such as add or delete nodes, then rather than grabbing and resending the cookies,
 * you can obtain the sessionid from the userlogin request and then append this to each subsequent request by adding PHPSESSID={your-session-id} as an extra parameter.</p>
 *
 * <p>Example service calls (replace start of URL with your Evidence hub url):
 * <pre>
 *     <a href="http://edfutures.evidence-hub.net/api/service.php?method=getnode&amp;nodeid=131211811270778613001206700042870488149">http://edfutures.evidence-hub.net/api/service.php?method=getnode&amp;nodeid=131211811270778613001206700042870488149</a>
 *     <a href="http://edfutures.evidence-hub.net/api/service.php?method=getnodesbyuser&amp;userid=1371081452501184165093">http://edfutures.evidence-hub.net/api/service.php?method=getnodesbyuser&amp;userid=1371081452501184165093</a>
 *     <a href="http://edfutures.evidence-hub.net/api/service.php?method=getnodesbyuser&amp;userid=1371081452501184165093&amp;format=json">http://edfutures.evidence-hub.net/api/service.php?method=getnodesbyuser&amp;userid=1371081452501184165093&amp;format=json</a>
 *     <a href="http://edfutures.evidence-hub.net/api/service.php?method=getnodesbyuser&amp;userid=1371081452501184165093&amp;format=xml">http://edfutures.evidence-hub.net/api/service.php?method=getnodesbyuser&amp;userid=1371081452501184165093&amp;format=xml</a>
 * </pre>
 * </p>
 * <p>Example calls are given below for each service and it is noted which services require the user to be logged in</p>
 * <p>Note that if any required parameters are missing from a service call, then an error object will be returned detailing the missing parameter.</p>
 *
 * <p>For any datetime parameter the following formats will be accepted:</p>
 * <ul>
 * <li>14 May 2008</li>
 * <li>14-05-2008</li>
 * <li>14 May 2008 9:00</li>
 * <li>14 May 2008 9:00PM</li>
 * <li>14-05-2008 9:00PM</li>
 * <li>9:00</li>
 * <li>14 May</li>
 * <li>wed</li>
 * <li>wed 9:00</li>
 * </ul>
 * <p>and the following formats would not be accepted:</p>
 * <ul>
 * <li>14 05 2008</li>
 * <li>14/05/2008</li>
 * <li>14 05 2008 9:00</li>
 * <li>14/05/2008 9:00</li>
 * <li>14-05</li>
 * </ul>
 *
 * <p>Do not forget to encode all parameters sent on the api call. This link may be helpful for this: <a href="http://www.w3schools.com/tags/ref_urlencode.asp"/>http://www.w3schools.com/tags/ref_urlencode.asp</a></p>
 */

/**
 * @ignore
 */
require_once('accesslib.php');
/**
 * @ignore
 */
require_once('utillib.php');
/**
 * @ignore
 */
require_once('formatlib.php');
/**
 * @ignore
 */
require_once('datamodel/node.class.php');
/**
 * @ignore
 */
require_once('datamodel/nodeset.class.php');
/**
 * @ignore
 */
require_once('datamodel/url.class.php');
/**
 * @ignore
 */
require_once('datamodel/urlset.class.php');
/**
 * @ignore
 */
require_once('datamodel/user.class.php');
/**
 * @ignore
 */
require_once('datamodel/userset.class.php');
/**
 * @ignore
 */
require_once('datamodel/result.class.php');
/**
 * @ignore
 */
require_once('datamodel/connection.class.php');
/**
 * @ignore
 */
require_once('datamodel/connectionset.class.php');
/**
 * @ignore
 */
require_once('datamodel/role.class.php');
/**
 * @ignore
 */
require_once('datamodel/roleset.class.php');
/**
 * @ignore
 */
require_once('datamodel/linktype.class.php');
/**
 * @ignore
 */
require_once('datamodel/linktypeset.class.php');
/**
 * @ignore
 */
require_once('datamodel/tag.class.php');
/**
 * @ignore
 */
require_once('datamodel/tagset.class.php');
/**
 * @ignore
 */
require_once('datamodel/userscache.class.php');
/**
 * @ignore
 */
require_once('datamodel/voting.class.php');
/**
 * @ignore
 */
require_once('datamodel/following.class.php');
/**
 * @ignore
 */
require_once('datamodel/activity.class.php');
/**
 * @ignore
 */
require_once('datamodel/activityset.class.php');
/**
 * @ignore
 */
require_once('datamodel/log.class.php');
/**
 * @ignore
 */
require_once('datamodel/userauthentication.class.php');

/**
 * @ignore
 */
require_once('datamodel/group.class.php');
/**
 * @ignore
 */
require_once('datamodel/groupset.class.php');


///////////////////////////////////////////////////////////////////
// functions for nodes
///////////////////////////////////////////////////////////////////

/**
 * Vote for the node with the given nodeid
 *
 * @param string $nodeid
 * @param string $vote to make ('Y' vote or 'N' vote);
 * @return Node or Error
 */
function nodeVote($nodeid,$vote){
    $n = new CNode($nodeid);
    return $n->vote($vote);
}

/**
 * Delete Vote for the node with the given nodeid
 *
 * @param string $nodeid
 * @param string $vote to delete ('Y' vote or 'N' vote);
 * @return Node or Error
 */
function deleteNodeVote($nodeid,$vote){
    $n = new CNode($nodeid);
    return $n->deleteVote($vote);
}

/**
 * Get all the Votes for the object with the given itemid
 *
 * @param string $itemid
 * @return Voting or Error
 */
function getVotes($itemid) {
    $n = new Voting($itemid);
    return $n->load();
}

/**
 * Get a node
 *
 * @param string $nodeid
 * @param string $style (optional - default 'long') may be 'short' or 'long'
 * @return Node or Error
 */
function getNode($nodeid,$style='long'){
    $n = new CNode($nodeid);
    return $n->load($style);
}

/**
 * Add a node. Requires login
 *
 * @param string $name
 * @param string $desc
 * @param string $private optional, can be Y or N, defaults to users preferred setting
 * @param string $nodetypeid optional, the id of the nodetype this node is, defaults to 'Idea' node type id.
 * @param string $imageurlid optional, the urlid of the url for the image that is being used as this node's icon
 * @param string $imagethumbnail optional, the local server path to the thumbnail of the image used for this node
 *
 * @return Node or Error
 */
function addNode($name,$desc,$private="",$nodetypeid="",$imageurlid="",$imagethumbnail=""){
    global $USER;
    if($private == ""){
        $private = $USER->privatedata;
    }

    $n = new CNode();
    $node = $n->add($name,$desc,$private,$nodetypeid,$imageurlid,$imagethumbnail);
    return $node;
}

/**
 * Edit a node. Requires login and user must be owner of the node.
 *
 * @param string nodeid
 * @param string name
 * @param string desc
 * @param string $private optional, can be Y or N, defaults to users preferred setting
 * @param string $nodetypeid optional, the id of the nodetype this node is, defaults to 'Idea' node type id.
 * @param string $imageurlid optional, the urlid of the url for the image that is being used as this node's icon
 * @param string $imagethumbnail optional, the local server path to the thumbnail of the image used for this node
 * @return Node or Error
 */
function editNode($nodeid,$name,$desc,$private="",$nodetypeid="",$imageurlid="",$imagethumbnail=""){
    global $USER;
    if($private == ""){
        $private = $USER->privatedata;
    }

    $n = new CNode($nodeid);
    $n->load();
    $node = $n->edit($name,$desc,$private,$nodetypeid,$imageurlid,$imagethumbnail);
    return $node;
}

/**
 * update a node start date. Requires login and user must be owner of the node.
 *
 * @param string nodeid
 * @param string $startdatetime optional text representation of start date and/or time

 * @return Node or Error
 */
function updateNodeStartDate($nodeid,$startdatetime){
    global $USER;
    $n = new CNode($nodeid);
    $n->load();
    if (isset($startdatetime)) {
	    $node = $n->updateStartDate($startdatetime);
    }
    return $node;
}

/**
 * update a node end date. Requires login and user must be owner of the node.
 *
 * @param string nodeid
 * @param string $enddatetime optional text representation of start date and/or time
 * @return Node or Error
 */
function updateNodeEndDate($nodeid,$enddatetime){
    global $USER;
    $n = new CNode($nodeid);
    $n->load();
    if (isset($enddatetime)) {
	    $node = $n->updateEndDate($enddatetime);
	}
	return $node;
}

/**
 * update a node location. Requires login and user must be owner of the node.
 *
 * @param string nodeid
 * @param string $location the the or city (optional)
 * @param string $loccountry the country (optional)
 * @param string $address1 the first line of an addres e.g. house and stree (optional)
 * @param string $address2 the second line of an address, e.g. area (optional)
 * @param string $postcode the postal code of zip code (optional)
 * @return Node or Error
 */
function updateNodeLocation($nodeid,$location,$loccountry,$address1,$address2,$postcode){
    global $USER;
    $n = new CNode($nodeid);
    $n->load();
    $node = $n->updateLocation($location,$loccountry,$address1,$address2,$postcode);
    return $node;
}


/**
 * Delete a node. Requires login and user must be owner of the node.
 *
 * @param string $nodeid
 * @return Result or Error
 */
function deleteNode($nodeid){
    $n = new CNode($nodeid);
    $result = $n->delete();
    return $result;
}

/**
 * Get the nodes the current user has permission to see.
 *
 * @param integer $start (optional - default: 0)
 * @param integer $max (optional - default: 20)
 * @param string $orderby (optional, either 'date', 'nodeid', 'name', 'connectedness' or 'moddate' - default: 'date')
 * @param string $sort (optional, either 'ASC' or 'DESC' - default: 'DESC')
 * @param string $filternodetypes (optional, a list of node type names to filter by)
 * @param string $filterthemes (optional, a list of theme names to filter by)
 * @param String $style (optional - default 'long') may be 'short' or 'long'  - how much of a nodes details to load (long includes: description, tags, groups and urls).
 * @param string $q the query term(s)
 * @param string $scope (optional, either 'my' or 'all' - default: 'all')
 * @param boolean $tagsonly (optional, either true or false) if true, only return nodes where they have tags mathing the passed query terms
 * @param string $connectionfilter filter by connections. Defaults to empty string which means disregard connection count. Possible values; '','connected','unconnected'.
 * @return NodeSet or Error
 */
function getNodesByGlobal($start = 0,$max = 20 ,$orderby = 'date',$sort ='DESC', $filternodetypes="", $filterthemes="", $style='long',$q='', $scope='all',$tagsonly=false, $connectionfilter='') {
    global $CFG,$USER,$HUB_SQL;

	$currentuser = '';
	if (isset($USER->userid)) {
		$currentuser = $USER->userid;
	}

	$params = array();

	$sql = $HUB_SQL->APILIB_NODES_BY_GLOBAL_SELECT;

	// FILTER NODE TYPES
    if ($filternodetypes != "") {
        $pieces = explode(",", $filternodetypes);
        $sqlList = "";
		$loopCount = 0;
        foreach ($pieces as $value) {
        	$params[count($params)] = $value;
        	if ($loopCount == 0) {
        		$sqlList .= "?";
        	} else {
        		$sqlList .= ",?";
        	}
        	$loopCount++;
        }
        $sql .= $HUB_SQL->APILIB_FILTER_NODETYPES.$HUB_SQL->OPENING_BRACKET;
	    $sql .= $sqlList;
	    $sql .= $HUB_SQL->CLOSING_BRACKET.$HUB_SQL->AND;
    }  else {
        $sql .= $HUB_SQL->WHERE;
    }

	// SEARCH
	if (isset($q) && $q != "") {
		if ($tagsonly) {
			$pieces = explode(",", $q);
			$loopCount = 0;
        	$search = "";
			foreach ($pieces as $value) {
				$value = trim($value);
 		       	$params[count($params)] = $value;

				if ($loopCount == 0) {
					$search .= $HUB_SQL->APILIB_TAG_SEARCH;
				} else {
					$search .= $HUB_SQL->OR.$HUB_SQL->APILIB_TAG_SEARCH;
				}
				$loopCount++;
			}
			$sql .= $HUB_SQL->OPENING_BRACKET;
			$sql .= $search;
			$sql .= $HUB_SQL->CLOSING_BRACKET.$HUB_SQL->AND;
		} else {
			$querySQL = getSearchQueryString($params, $q, true, true);
			$sql .= $querySQL.$HUB_SQL->AND;
		}
	}

	// PERMISSIONS
    if($scope == 'my'){
       	$params[count($params)] = currentuser;
        $sql .= $HUB_SQL->APILIB_NODES_PERMISSIONS_MY;
    } else {
       	$params[count($params)] = 'N';
       	$params[count($params)] = $currentuser;
       	$params[count($params)] = $currentuser;
		$sql .= $HUB_SQL->APILIB_NODES_PERMISSIONS_ALL;
	}

	// FILTER THEMES
	if ($filterthemes != "") {
		$params[count($params)] = $filterthemes;
		$sql .= $HUB_SQL->AND.$HUB_SQL->APILIB_FILTER_THEMES;
	}

	if ($orderby == 'vote') {
		$sql = $HUB_SQL->APILIB_NODE_ORDERBY_VOTE_PART1.$sql.$HUB_SQL->APILIB_NODE_ORDERBY_VOTE_PART2;
	}

	if ($connectionfilter == 'unconnected') {
		$sql .= $HUB_SQL->APILIB_HAVING_UNCONNECTED;
	} else if ($connectionfilter == 'connected') {
		$sql .= $HUB_SQL->APILIB_HAVING_CONNECTED;
	}

	//error_log("Search=".$sql);

	$ns = new NodeSet();
	return $ns->load($sql,$params,$start,$max,$orderby,$sort,$style);
}

/**
 * Get the nodes for given user
 *
 * @param string $userid
 * @param integer $start (optional - default: 0)
 * @param integer $max (optional - default: 20), -1 means all
 * @param string $orderby (optional, either 'date', 'nodeid', 'name', 'connectedness' or 'moddate' - default: 'date')
 * @param string $sort (optional, either 'ASC' or 'DESC' - default: 'DESC')
 * @param string $filternodetypes (optional, a list of node type names to filter by)
 * @param string $filterthemes (optional, a list of theme names to filter by)
 * @param String $style (optional - default 'long') may be 'short' or 'long'  - how much of a nodes details to load (long includes: description, tags, groups and urls).
 * @param string $q the query term(s)
 * @param string $connectionfilter filter by connections. Defaults to empty string which means disregard connection count. Possible values; '','connected','unconnected'.
 * @return NodeSet or Error
 */
function getNodesByUser($userid,$start = 0,$max = 20 ,$orderby = 'date',$sort ='DESC', $filternodetypes="", $filterthemes, $style='long', $q="", $connectionfilter=''){
    global $CFG,$USER,$HUB_SQL;

	$currentuser = '';
	if (isset($USER->userid)) {
		$currentuser = $USER->userid;
	}

	$params = array();

    $sql = $HUB_SQL->APILIB_NODES_BY_GLOBAL_SELECT;

	// FILTER NODE TYPES
    if ($filternodetypes != "") {
        $pieces = explode(",", $filternodetypes);
        $sqlList = "";
		$loopCount = 0;
        foreach ($pieces as $value) {
        	$params[count($params)] = $value;
        	if ($loopCount == 0) {
        		$sqlList .= "?";
        	} else {
        		$sqlList .= ",?";
        	}
        	$loopCount++;
        }
        $sql .= $HUB_SQL->APILIB_FILTER_NODETYPES.$HUB_SQL->OPENING_BRACKET;
	    $sql .= $sqlList;
	    $sql .= $HUB_SQL->CLOSING_BRACKET.$HUB_SQL->AND;
    }  else {
        $sql .= $HUB_SQL->WHERE;
    }

	// FILTER BY USER
	$params[count($params)] = $userid;
    $sql .= $HUB_SQL->FILTER_USER;

	// PERMISSIONS
	$params[count($params)] = 'N';
	$params[count($params)] = $currentuser;
	$params[count($params)] = $currentuser;
    $sql .= $HUB_SQL->AND.$HUB_SQL->APILIB_NODES_PERMISSIONS_ALL;

	// SEARCH
    if (isset($q) && $q != "") {
    	$querySQL = getSearchQueryString($params,$q, true, true);
    	$sql .= $HUB_SQL->AND.$querySQL;
 	}

	// FILTER THEMES
	if ($filterthemes != "") {
		$params[count($params)] = $filterthemes;
		$sql .= $HUB_SQL->AND.$HUB_SQL->APILIB_FILTER_THEMES;
	}

	if ($orderby == 'vote') {
		$sql = $HUB_SQL->APILIB_NODE_ORDERBY_VOTE_PART1.$sql.$HUB_SQL->APILIB_NODE_ORDERBY_VOTE_PART2;
	}

	if ($connectionfilter == 'unconnected') {
		$sql .= $HUB_SQL->APILIB_HAVING_UNCONNECTED;
	} else if ($connectionfilter == 'connected') {
		$sql .= $HUB_SQL->APILIB_HAVING_CONNECTED;
	}

	//echo $sql;

    $ns = new NodeSet();
    return $ns->load($sql,$params,$start,$max,$orderby,$sort,$style);
}

/**
 * Get the nodes for given date
 *
 * @param integer $date
 * @param integer $start (optional - default: 0)
 * @param integer $max (optional - default: 20)
 * @param string $orderby (optional, either 'date', 'nodeid', 'name', 'connectedness' or 'moddate' - default: 'date')
 * @param string $sort (optional, either 'ASC' or 'DESC' - default: 'DESC')
 * @param String $style (optional - default 'long') may be 'short' or 'long'  - how much of a nodes details to load (long includes: description, tags, groups and urls).
 * @return NodeSet or Error
 */
function getNodesByDate($date,$start = 0,$max = 20 ,$orderby = 'date',$sort ='ASC', $style='long'){
    global $CFG,$USER,$HUB_SQL;

	$currentuser = '';
	if (isset($USER->userid)) {
		$currentuser = $USER->userid;
	}

	$params = array();
	$params[0] = $date;
	$params[1] = 'N';
	$params[2] = $currentuser;
	$params[3] = $currentuser;

    $sql = $HUB_SQL->APILIB_NODES_BY_DATE;
    $ns = new NodeSet();
    return $ns->load($sql,$params,$start,$max,$orderby,$sort,$style);
}

/**
 * Get the nodes for given name
 *
 * @param string $name
 * @param integer $start (optional - default: 0)
 * @param integer $max (optional - default: 20)
 * @param string $orderby (optional, either 'date', 'nodeid', 'name', 'connectedness' or 'moddate' - default: 'date')
 * @param string $sort (optional, either 'ASC' or 'DESC' - default: 'DESC')
 * @param String $style (optional - default 'long') may be 'short' or 'long'  - how much of a nodes details to load (long includes: description, tags, groups and urls).
 * @return NodeSet or Error
 */
function getNodesByName($name,$start = 0,$max = 20 ,$orderby = 'date',$sort ='ASC', $style='long'){
    global $CFG,$USER,$HUB_SQL;

	$currentuser = '';
	if (isset($USER->userid)) {
		$currentuser = $USER->userid;
	}

	$params = array();
	$params[0] = $name;
	$params[1] = 'N';
	$params[2] = $currentuser;
	$params[3] = $currentuser;

    $sql = $HUB_SQL->APILIB_NODES_BY_NAME;

    $ns = new NodeSet();
    return $ns->load($sql,$params,$start,$max,$orderby,$sort,$style);
}

/**
 * Searches nodes by node name based on the first chartacters
 *
 * @param string $q the query term(s)
 * @param string $scope (optional, either 'all' or 'my' - default: 'my')
 * @param integer $start (optional - default: 0)
 * @param integer $max (optional - default: 20)
 * @param string $orderby (optional, either 'date', 'nodeid', 'name' or 'moddate' - default: 'date')
 * @param string $sort (optional, either 'ASC' or 'DESC' - default: 'DESC')
 * @param string $filternodetypes (optional, a list of node type names to filter by)
 * @param String $style (optional - default 'long') may be 'short' or 'long'  - how much of a nodes details to load (long includes: description, tags, groups and urls).
 * @return NodeSet or Error
 */
function getNodesByFirstCharacters($q,$scope,$start = 0,$max = 20 ,$orderby = 'name',$sort ='ASC', $filternodetypes="", $style='long'){
    global $CFG,$USER,$HUB_SQL;

	$currentuser = '';
	if (isset($USER->userid)) {
		$currentuser = $USER->userid;
	}

	$params = array();

	$q = trim($q);
	$q = $DB->cleanString($q);

	$sql = $HUB_SQL->APILIB_NODES_BY_FIRST_CHARACTERS_SELECT;

	// FILTER NODE TYPES
    if ($filternodetypes != "") {
        $pieces = explode(",", $filternodetypes);
        $sqlList = "";
		$loopCount = 0;
        foreach ($pieces as $value) {
        	$params[count($params)] = $value;
        	if ($loopCount == 0) {
        		$sqlList .= "?";
        	} else {
        		$sqlList .= ",?";
        	}
        	$loopCount++;
		}
        $sql .= $HUB_SQL->APILIB_FILTER_NODETYPES.$HUB_SQL->OPENING_BRACKET;
        $sql .= $sqlList;
	    $sql .= $HUB_SQL->CLOSING_BRACKET.$HUB_SQL->AND;

        $sql .= $HUB_SQL->APILIB_NODE_NAME_STARTING_SEARCH;
        $sql .= $q;
        $sql .= $HUB_SQL->SEARCH_LIKE_FROM_END;
    } else {
        $sql .= $HUB_SQL->APILIB_NODE_NAME_STARTING_SEARCH;
        $sql .= $q;
        $sql .= $HUB_SQL->SEARCH_LIKE_FROM_END;
    }

	// PERMISSIONS
    if ($scope == 'my') {
    	$params[count($params)] = $currentuser;
        $sql .= $HUB_SQL->AND.$HUB_SQL->APILIB_NODES_PERMISSIONS_MY;
    } else {
		$params[count($params)] = 'N';
		$params[count($params)] = $currentuser;
		$params[count($params)] = $currentuser;
		$sql .= $HUB_SQL->AND.$HUB_SQL->APILIB_NODES_PERMISSIONS_ALL;
	}

	$sql .= $HUB_SQL->APILIB_NODES_BY_FIRST_CHARACTERS_PART4;

	//echo $sql;

    $ns = new NodeSet();
    return $ns->load($sql,$params,$start,$max,$orderby,$sort,$style);
}

/**
 * Get the nodes for given tagid
 *
 * @param string $tagid
 * @param integer $start (optional - default: 0)
 * @param integer $max (optional - default: 20)
 * @param string $orderby (optional, either 'date', 'nodeid', 'name', 'connectedness' or 'moddate' - default: 'date')
 * @param string $sort (optional, either 'ASC' or 'DESC' - default: 'DESC')
 * @param String $style (optional - default 'long') may be 'short' or 'long'  - how much of a nodes details to load (long includes: description, tags, groups and urls).
 * @return NodeSet or Error
 */
function getNodesByTag($tagid, $start = 0,$max = 20 ,$orderby = 'date', $sort ='ASC', $style='long'){
    global $USER,$CFG,$HUB_SQL;

	$currentuser = '';
	if (isset($USER->userid)) {
		$currentuser = $USER->userid;
	}

	$params = array();
	$params[0] = $tagid;
	$params[1] = 'N';
	$params[2] = $currentuser;
	$params[3] = $currentuser;

    $sql = $HUB_SQL->APILIB_NODES_BY_TAG;

    $ns = new NodeSet();
    return $ns->load($sql,$params,$start,$max,$orderby,$sort,$style,$style);
}

/**
 * Get the nodes for given url
 * (note that this uses the actual URL rather than the urlid)
 *
 * @param string $url
 * @param integer $start (optional - default: 0)
 * @param integer $max (optional - default: 20)
 * @param string $orderby (optional, either 'date', 'nodeid', 'name', 'connectedness' or 'moddate' - default: 'date')
 * @param string $sort (optional, either 'ASC' or 'DESC' - default: 'DESC')
 * @param string $filternodetypes (optional, a list of node type names to filter by)
 * @param String $style (optional - default 'long') may be 'short' or 'long'  - how much of a nodes details to load (long includes: description, tags, groups and urls).
 * @return NodeSet or Error
 */
function getNodesByURL($url,$start = 0,$max = 20 ,$orderby = 'date', $sort ='ASC', $filternodetypes="", $style='long'){
    global $USER,$CFG,$HUB_SQL;

	$currentuser = '';
	if (isset($USER->userid)) {
		$currentuser = $USER->userid;
	}

	$params = array();

    $sql = $HUB_SQL->APILIB_NODES_BY_URL_SELECT;

	// FILTER NODE TYPES
    if ($filternodetypes != "") {
        $pieces = explode(",", $filternodetypes);
        $sqlList = "";
		$loopCount = 0;
        foreach ($pieces as $value) {
        	$params[count($params)] = $value;
        	if ($loopCount == 0) {
        		$sqlList .= "?";
        	} else {
        		$sqlList .= ",?";
        	}
        	$loopCount++;
		}
        $sql .= $HUB_SQL->APILIB_FILTER_NODETYPES.$HUB_SQL->OPENING_BRACKET;
        $sql .= $sqlList;
	    $sql .= $HUB_SQL->CLOSING_BRACKET.$HUB_SQL->AND;
    }  else {
        $sql .= $HUB_SQL->WHERE;
    }

	$params[count($params)] = $url;
	$params[count($params)] = 'N';
	$params[count($params)] = $currentuser;
	$params[count($params)] = $currentuser;
	$params[count($params)] = 'N';
	$params[count($params)] = $currentuser;
	$params[count($params)] = $currentuser;
	$sql .= $HUB_SQL->APILIB_NODES_BY_URL_PERMISSIONS;

	//echo $sql;

    $ns = new NodeSet();
    return $ns->load($sql,$params,$start,$max,$orderby,$sort,$style,$style);
}

/**
 * Get the nodes with connections of the specified type for the given parameters
 *
 * @param integer $start (optional - default: 0)
 * @param integer $max (optional - default: 20)
 * @param string $orderby (optional, either 'date', 'name' or 'moddate' - default: 'date')
 * @param string $sort (optional, either 'ASC' or 'DESC' - default: 'DESC')
 * @param string $filtergroup (optional, either 'all','selected','positive','negative' or 'neutral', default: 'all' - to filter the results by the link type group of the connection)
 * @param string $filterlist (optional, comma separated strings of the connection labels to filter the results by, to have any effect filtergroup must be set to 'selected')
 * @param string $filternodetypes (optional, a list of node type names to filter by)
 * @param String $style (optional - default 'long') may be 'short' or 'long'
 * @param string $q the query term(s)
 * @param boolean $includeunconnected (optional - default false) may be true or false
 * @return NodeSet or Error
 */
function getConnectedNodesByGlobal($start = 0,$max = 20 ,$orderby = 'date',$sort ='ASC', $filtergroup = 'all', $filterlist = '', $filternodetypes='', $style='long', $q="", $includeunconnected=false){
    global $USER,$CFG,$DB,$HUB_SQL;

	$currentuser = '';
	if (isset($USER->userid)) {
		$currentuser = $USER->userid;
	}

	$params = array();

	$sql = $HUB_SQL->APILIB_CONNECTED_NODES_BY_GLOBAL_SELECT;

	// FILTER NODE TYPES
	if ($filternodetypes != "") {
		$innersql = getSQLForNodeTypeIDsForLabels($params,$filternodetypes);
		$sql .= $HUB_SQL->APILIB_CONNECTED_NODES_NODETYPES_PART1;
		$sql .= $innersql;
		$sql .= $HUB_SQL->APILIB_CONNECTED_NODES_NODETYPES_PART2;
	}

	// SEARCH
	if ($q != "") {
		$querySQL = getSearchQueryString($params,$q, true, true);
		$sql .= $querySQL;
		if ($querySQL != "") {
			$sql .= $HUB_SQL->AND;
		}
	}

	// PERMISSIONS
	$params[count($params)] = 'N';
	$params[count($params)] = $currentuser;
	$params[count($params)] = $currentuser;
	$sql .=  $HUB_SQL->APILIB_NODES_PERMISSIONS_ALL;

	$sql.= $HUB_SQL->AND.$HUB_SQL->OPENING_BRACKET;

	// INCLUDE UNCONNECTED
	if ($includeunconnected) {
		$sql .= $HUB_SQL->APILIB_NODES_UNCONNECTED;
	}

	// FILTER LINK TYPE
	$innersqlfilter = "";
	$linklist = array();
	if ($filtergroup != '' && $filtergroup != 'all' && $filtergroup != 'selected') {
		$innersqlfilter = getSQLForLinkTypeIDsForGroup($linklist,$filtergroup);
	} else {
		$innersqlfilter = getSQLForLinkTypeIDsForLabels($linklist,$filterlist);
	}
	if ($innersqlfilter != "") {
		if ($includeunconnected) {
			$sql .= " ".$HUB_SQL->OR." ";
		}
		$sql .= $HUB_SQL->APILIB_CONNECTED_NODES_LINKTYPES_PART1;
		$params = array_merge($params, $linklist);
		$sql .= $innersqlfilter;
		$sql .= $HUB_SQL->APILIB_CONNECTED_NODES_LINKTYPES_PART2;
		$params = array_merge($params, $linklist);
		$sql .= $innersqlfilter;
		$sql .= $HUB_SQL->APILIB_CONNECTED_NODES_LINKTYPES_PART3;
	}

	$sql .= $HUB_SQL->CLOSING_BRACKET;

	//echo $sql;

    $cs = new NodeSet();
    return $cs->load($sql,$params,$start,$max,$orderby,$sort,$style);
}

/**
 * Get the nodes with connections of the specified type for the given parameters (or no connections if requested)
 *
 * @param string $userid, the id of the user to get the nodes for.
 * @param integer $start (optional - default: 0)
 * @param integer $max (optional - default: 20)
 * @param string $orderby (optional, either 'date', 'name' or 'moddate' - default: 'date')
 * @param string $sort (optional, either 'ASC' or 'DESC' - default: 'DESC')
 * @param string $filtergroup (optional, either 'all','selected','positive','negative' or 'neutral', default: 'all' - to filter the results by the link type group of the connection)
 * @param string $filterlist (optional, comma separated strings of the connection labels to filter the results by, to have any effect filtergroup must be set to 'selected')
 * @param string $filternodetypes (optional, a list of node type names to filter by)
 * @param string $style (optional - default 'long') may be 'short' or 'long'
 * @param string $q the query term(s)
 * @param boolean $includeunconnected (optional - default false) may be true or false
 * @return NodeSet or Error
 */
function getConnectedNodesByUser($userid, $start = 0,$max = 20 ,$orderby = 'date',$sort ='ASC', $filtergroup = 'all', $filterlist = '', $filternodetypes='', $style='long', $q="", $includeunconnected=false){
    global $USER,$CFG,$DB,$HUB_SQL;

	$currentuser = '';
	if (isset($USER->userid)) {
		$currentuser = $USER->userid;
	}

	$params = array();

	$sql = $HUB_SQL->APILIB_CONNECTED_NODES_BY_GLOBAL_SELECT;

	// FILTER BY USER
	$params[0] = $userid;
	$sql .= $HUB_SQL->FILTER_USER.$HUB_SQL->AND;

	// FILTER NODE TYPES
	if ($filternodetypes != "") {
		$innersql = getSQLForNodeTypeIDsForLabels($params,$filternodetypes);
		$sql .= $HUB_SQL->APILIB_CONNECTED_NODES_NODETYPES_PART1;
		$sql .= $innersql;
		$sql .= $HUB_SQL->APILIB_CONNECTED_NODES_NODETYPES_PART2;
	}

	// SEARCH
	if ($q != "") {
		$querySQL = getSearchQueryString($params,$q, true, true);
		$sql .= $querySQL;
		if ($querySQL != "") {
			$sql .= $HUB_SQL->AND;
		}
	}

	// PERMISSIONS
	$params[count($params)] = 'N';
	$params[count($params)] = $currentuser;
	$params[count($params)] = $currentuser;
	$sql .=  $HUB_SQL->APILIB_NODES_PERMISSIONS_ALL;

	$sql.= $HUB_SQL->AND.$HUB_SQL->OPENING_BRACKET;

	// INCLUDE UNCONNECTED
	if ($includeunconnected) {
		$sql .= $HUB_SQL->APILIB_NODES_UNCONNECTED;
	}

	// FILTER LINK TYPE
	$innersqlfilter = "";
	$linklist = array();
	if ($filtergroup != '' && $filtergroup != 'all' && $filtergroup != 'selected') {
		$innersqlfilter = getSQLForLinkTypeIDsForGroup($linklist,$filtergroup);
	} else {
		$innersqlfilter = getSQLForLinkTypeIDsForLabels($linklist,$filterlist);
	}
	if ($innersqlfilter != "") {
		if ($includeunconnected) {
			$sql .= $HUB_SQL->OR;
		}
		$sql .= $HUB_SQL->APILIB_CONNECTED_NODES_LINKTYPES_PART1;
		$params = array_merge($params, $linklist);
		$sql .= $innersqlfilter;
		$sql .= $HUB_SQL->APILIB_CONNECTED_NODES_LINKTYPES_PART2;
		$params = array_merge($params, $linklist);
		$sql .= $innersqlfilter;
		$sql .= $HUB_SQL->APILIB_CONNECTED_NODES_LINKTYPES_PART3;
	}

	$sql .= $HUB_SQL->CLOSING_BRACKET;

	//echo $sql;

    $cs = new NodeSet();
    return $cs->load($sql,$params,$start,$max,$orderby,$sort,$style);
}

/**
 * Get the nodes not connected to anything the current user has permission to see.
 *
 * @param integer $start (optional - default: 0)
 * @param integer $max (optional - default: 20)
 * @param string $orderby (optional, either 'date', 'nodeid', 'name', 'connectedness' or 'moddate' - default: 'date')
 * @param string $sort (optional, either 'ASC' or 'DESC' - default: 'DESC')
 * @param string $filternodetypes (optional, a list of node type names to filter by)
 * @param string $filterthemes (optional, a list of theme names to filter by)
 * @param String $style (optional - default 'long') may be 'short' or 'long'  - how much of a nodes details to load (long includes: description, tags, groups and urls).
 * @param string $q the query term(s)
 * @param string $scope (optional, either 'my' or 'all' - default: 'all')
 * @param boolean $tagsonly (optional, either true or false) if true, only return nodes where they have tags mathing the passed query terms
 * @return NodeSet or Error
 */
function getUnconnectedNodesByGlobal($start = 0,$max = 20 ,$orderby = 'date',$sort ='DESC', $filternodetypes="", $filterthemes="", $style='long',$q='', $scope='all',$tagsonly=false) {
    global $CFG,$USER,$HUB_SQL;

	$currentuser = '';
	if (isset($USER->userid)) {
		$currentuser = $USER->userid;
	}

	$params = array();

    $sql = $HUB_SQL->APILIB_UNCONNECTED_NODES_BY_GLOBAL_SELECT;

	// FILTER NODE TYPES
    if ($filternodetypes != "") {
        $pieces = explode(",", $filternodetypes);
        $sqlList = "";
		$loopCount = 0;
        foreach ($pieces as $value) {
        	$params[count($params)] = $value;
        	if ($loopCount == 0) {
        		$sqlList .= "?";
        	} else {
        		$sqlList .= ",?";
        	}
        	$loopCount++;
        }
        $sql .= $HUB_SQL->APILIB_FILTER_NODETYPES.$HUB_SQL->OPENING_BRACKET;
	    $sql .= $sqlList;
	    $sql .= $HUB_SQL->CLOSING_BRACKET.$HUB_SQL->AND;
    }  else {
        $sql .= $HUB_SQL->WHERE;
    }

	// FILTER ON NO CONNECTIONS
	$sql .= $HUB_SQL->APILIB_NODES_NO_CONNECTIONS;
	$sql .= $HUB_SQL->AND;
	$sql .= $HUB_SQL->APILIB_NODES_UNCONNECTED;
	$sql .= $HUB_SQL->AND;

	// SEARCH
	if (isset($q) && $q != "") {
		if ($tagsonly) {
			$pieces = explode(",", $q);
			$loopCount = 0;
        	$search = "";
			foreach ($pieces as $value) {
				$value = trim($value);
 		       	$params[count($params)] = $value;

				if ($loopCount == 0) {
					$search .= $HUB_SQL->APILIB_TAG_SEARCH;
				} else {
					$search .= $HUB_SQL->OR.$HUB_SQL->APILIB_TAG_SEARCH;
				}
				$loopCount++;
			}
			$sql .= $HUB_SQL->OPENING_BRACKET;
			$sql .= $search;
			$sql .= $HUB_SQL->CLOSING_BRACKET.$HUB_SQL->AND;
		} else {
			$querySQL = getSearchQueryString($params, $q, true, true);
			$sql .= $querySQL.$HUB_SQL->AND;
		}
	}

	// PERMISSIONS
    if($scope == 'my'){
       	$params[count($params)] = $currentuser;
        $sql .= $HUB_SQL->APILIB_NODES_PERMISSIONS_MY;
    } else {
       	$params[count($params)] = 'N';
       	$params[count($params)] = $currentuser;
       	$params[count($params)] = $currentuser;
		$sql .= $HUB_SQL->APILIB_NODES_PERMISSIONS_ALL;
	}

	// FILTER THEMES
	if ($filterthemes != "") {
		$params[count($params)] = $filterthemes;
		$sql .= $HUB_SQL->AND.$HUB_SQL->APILIB_FILTER_THEMES;
	}

	// ORDER BY VOTE
	if ($orderby == 'vote') {
		$sql = $HUB_SQL->APILIB_NODE_ORDERBY_VOTE_PART1.$sql.$HUB_SQL->APILIB_NODE_ORDERBY_VOTE_PART2;
	}

	//echo $sql;

	$ns = new NodeSet();
	return $ns->load($sql,$params,$start,$max,$orderby,$sort,$style);
}

/**
 * Get the nodes not connected to anything for the given user, that current user has permission to see.
 *
 * @param string $userid
 * @param integer $start (optional - default: 0)
 * @param integer $max (optional - default: 20)
 * @param string $orderby (optional, either 'date', 'nodeid', 'name', 'connectedness' or 'moddate' - default: 'date')
 * @param string $sort (optional, either 'ASC' or 'DESC' - default: 'DESC')
 * @param string $filternodetypes (optional, a list of node type names to filter by)
 * @param string $filterthemes (optional, a list of theme names to filter by)
 * @param String $style (optional - default 'long') may be 'short' or 'long'  - how much of a nodes details to load (long includes: description, tags, groups and urls).
 * @param string $q the query term(s)
 * @param string $scope (optional, either 'my' or 'all' - default: 'all')
 * @param boolean $tagsonly (optional, either true or false) if true, only return nodes where they have tags mathing the passed query terms
 * @return NodeSet or Error
 */
function getUnconnectedNodesByUser($userid, $start = 0,$max = 20 ,$orderby = 'date',$sort ='DESC', $filternodetypes="", $filterthemes="", $style='long',$q='', $scope='all',$tagsonly=false) {
    global $CFG,$USER,$HUB_SQL;

	$currentuser = '';
	if (isset($USER->userid)) {
		$currentuser = $USER->userid;
	}

	$params = array();

    $sql = $HUB_SQL->APILIB_UNCONNECTED_NODES_BY_GLOBAL_SELECT;

	// FILTER NODE TYPES
    if ($filternodetypes != "") {
        $pieces = explode(",", $filternodetypes);
        $sqlList = "";
		$loopCount = 0;
        foreach ($pieces as $value) {
        	$params[count($params)] = $value;
        	if ($loopCount == 0) {
        		$sqlList .= "?";
        	} else {
        		$sqlList .= ",?";
        	}
        	$loopCount++;
        }
        $sql .= $HUB_SQL->APILIB_FILTER_NODETYPES.$HUB_SQL->OPENING_BRACKET;
	    $sql .= $sqlList;
	    $sql .= $HUB_SQL->CLOSING_BRACKET.$HUB_SQL->AND;
    }  else {
        $sql .= $HUB_SQL->WHERE;
    }

	// FILTER ON USER ID
    $params[count($params)] = $userid;
	$sql .= $HUB_SQL->FILTER_USER;
	$sql .= $HUB_SQL->AND;

	// FILTER ON NO CONNECTIONS
	$sql .= $HUB_SQL->APILIB_NODES_NO_CONNECTIONS;
	$sql .= $HUB_SQL->AND;
	$sql .= $HUB_SQL->APILIB_NODES_UNCONNECTED;
	$sql .= $HUB_SQL->AND;

	// SEARCH
	if (isset($q) && $q != "") {
		if ($tagsonly) {
			$pieces = explode(",", $q);
			$loopCount = 0;
        	$search = "";
			foreach ($pieces as $value) {
				$value = trim($value);
 		       	$params[count($params)] = $value;

				if ($loopCount == 0) {
					$search .= $HUB_SQL->APILIB_TAG_SEARCH;
				} else {
					$search .= $HUB_SQL->OR.$HUB_SQL->APILIB_TAG_SEARCH;
				}
				$loopCount++;
			}
			$sql .= $HUB_SQL->OPENING_BRACKET;
			$sql .= $search;
			$sql .= $HUB_SQL->CLOSING_BRACKET.$HUB_SQL->AND;
		} else {
			$querySQL = getSearchQueryString($params, $q, true, true);
			$sql .= $querySQL.$HUB_SQL->AND;
		}
	}

	// PERMISSIONS
    if($scope == 'my'){
       	$params[count($params)] = $currentuser;
        $sql .= $HUB_SQL->APILIB_NODES_PERMISSIONS_MY;
    } else {
       	$params[count($params)] = 'N';
       	$params[count($params)] = $currentuser;
       	$params[count($params)] = $currentuser;
		$sql .= $HUB_SQL->APILIB_NODES_PERMISSIONS_ALL;
	}

	// FILTER THEMES
	if ($filterthemes != "") {
		$params[count($params)] = $filterthemes;
		$sql .= $HUB_SQL->AND.$HUB_SQL->APILIB_FILTER_THEMES;
	}

	// ORDER BY VOTE
	if ($orderby == 'vote') {
		$sql = $HUB_SQL->APILIB_NODE_ORDERBY_VOTE_PART1.$sql.$HUB_SQL->APILIB_NODE_ORDERBY_VOTE_PART2;
	}

	//echo $sql;

	$ns = new NodeSet();
	return $ns->load($sql,$params,$start,$max,$orderby,$sort,$style);
}

/**
 * Get nodes which are most connected to other nodes
 *
 * @param string $scope (optional, either 'all' or 'my' - default 'all' )
 * @param integer $start (optional - default: 0)
 * @param integer $max (optional - default: 20)
 * @param String $style (optional - default 'long') may be 'short' or 'long'  - how much of a nodes details to load (long includes: description, tags, groups and urls).
 * @return NodeSet or Error
 */
function getMostConnectedNodes($scope='all', $start = 0,$max = 20, $style='long'){
    global $CFG,$USER,$HUB_SQL;

	$currentuser = '';
	if (isset($USER->userid)) {
		$currentuser = $USER->userid;
	}

	$params = array();

    $sql = $HUB_SQL->APILIB_MOST_CONNECTED_NODES_SELECT;
	$sql .= $HUB_SQL->WHERE;

	// PERMISSIONS
    if($scope == 'my'){
       	$params[count($params)] = $currentuser;
        $sql .= $HUB_SQL->APILIB_NODES_PERMISSIONS_MY;
    } else {
       	$params[count($params)] = 'N';
       	$params[count($params)] = $currentuser;
       	$params[count($params)] = $currentuser;
		$sql .= $HUB_SQL->APILIB_NODES_PERMISSIONS_ALL;
	}

    $ns = new NodeSet();
    return $ns->load($sql,$params,$start,$max,'connectedness','DESC',$style);
}


///////////////////////////////////////////////////////////////////
// functions for URLs
///////////////////////////////////////////////////////////////////


/**
 * Add a Web Resource. Requires login - combines creating a node and a URL and joining them
 *
 * @param string $url
 * @param string $title
 * @param string $desc
 * @param string $private optional, can be Y or N, defaults to users preferred setting
 * @param string $clip (optional);
 * @param string $clippath (optional)
 * @return Node or Error
 */
function addWebResource($url, $title, $desc, $private='Y', $clip="", $clippath="") {
	$r = getRoleByName('Web Resource');
	if (!$r instanceof Hub_Error) {
		$refrole = $r->roleid;
		$refnode = addNode($url, $title, $private, $refrole);
		if (!$refnode instanceof Hub_Error) {
    		$urlobj = new URL();
    		$urlobj->add($url, $title, $desc, $private, $clip, $clippath, "", "", "");
	    	if (!$urlobj instanceof Hub_Error) {
	    		$refnode->addURL($urlobj->urlid, "");
	    	}
		}
    }

    return $refnode;
}

/**
 * Edit a Resource Node and it's associated URL entry. Requires login - combines editing a node and its URL
 *
 * @param string $nodeid
 * @param string $nodetypename
 * @param string $title
 * @param string $desc
 * @param string $url
 * @param string $private optional, can be Y or N, but defaults to N in the Evidence Hub as All entries must be public.
 * @param string $identifier (optional);
 * @param string $clip (optional);
 * @param string $clippath (optional)
 * @return Node or Error
 */
function editWebResource($nodeid, $nodetypename, $title, $desc, $url, $private='N', $identifier, $clip="", $clippath="") {
	$r = getRoleByName($nodetypename);
	if (!$r instanceof Hub_Error) {
		$refroleID = $r->roleid;
		$refnode = new CNode($nodeid);
		if (!$refnode instanceof Hub_Error) {
		    $refnode->load();
		    $refnode = $refnode->edit($title,$desc,$private,$refroleID);
		}
		// Remember in this code base each Resource has to have one and only one url associated with it
		// hence we can take the first entry
		if (!$refnode instanceof Hub_Error) {
    		$urlobj = new URL($refnode->urls[0]->urlid);
    		$urlobj->load();

			// Remember the title for the url is actually stored on the description for the resource node.
			// So pass desc to update the URL title - title will be the url - I know - but it is the way it is
    		$urlobj = $urlobj->edit($url, $desc, "", $private, $clip, $clippath, "", "", $identifier);
	    	if ($urlobj instanceof Hub_Error) {
	    		error_log("edit of url for resource failed: ".$refnode->urls[0]->urlid);
	    	}
		}
    }

	$refnode->load();
    return $refnode;
}


/**
 * Go and try and automatically retrieve the title and descritpion for the given url.
 *
 * @param string $url
 * @return URL or Error
 */
function autoCompleteURLDetails($url){
    global $CFG;

	$http = array('method'  => 'GET',
            'request_fulluri' => true,
            'timeout' => '2');
	if($CFG->PROXY_HOST != ""){
		$http['proxy'] = $CFG->PROXY_HOST . ":".$CFG->PROXY_PORT;
	}
	$opts = array();
	$opts['http'] = $http;

	$context  = stream_context_create($opts);
	$content = file_get_contents($url, false, $context);

	// get title
    $start = '<title>';
    $end = '<\/title>';
    preg_match( "/$start(.*)$end/si", $content, $match );
    $title = strip_tags($match[ 1 ]);
    $title = trim($title);

    try {
    	if ($metatagarray = get_meta_tags( $url )) {
    		//$keywords = $metatagarray[ "keywords" ];
    		$description = $metatagarray[ "description" ];
    		$description = trim($description);
    	} else {
    		$description = "";

    	}
    } catch (Exception $ex) {
    	$description = $ex->getMessage();
    }

    $urlObj = new URL();
    $urlObj->title = $title;
    $urlObj->description = trim($description);

    return $urlObj;
}

/**
 * Add a URL. Requires login
 *
 * @param string $url
 * @param string $title
 * @param string $desc
 * @param string $private optional, can be Y or N, defaults to users preferred setting
 * @param string $clip (optional);
 * @param string $clippath (optional) - only used by Firefox plugin
 * @param string $cliphtml (optional) - only used by Firefox plugin
 * @param string $createdfrom (optional) - only used for Utopia, rss, compendium
 * @param string $identifier (optional) an additional identifier used for storing a DOI at present
 * @return URL or Error
 */
function addURL($url, $title, $desc, $private='Y', $clip="", $clippath="", $cliphtml="", $createdfrom="", $identifier=""){
    $urlobj = new URL();
    return $urlobj->add($url, $title, $desc, $private, $clip, $clippath, $cliphtml, $createdfrom, $identifier);
}

/**
 * Delete a URL. Requires login and user must be owner of the URL
 *
 * @param string $urlid
 * @return URL or Error
 */
function deleteURL($urlid){
    $urlObj = new URL($urlid);
    $result = $urlObj->delete();
    return $result;
}

///////////////////////////////////////////////////////////////////
// functions for node <-> URL relationships
///////////////////////////////////////////////////////////////////
/**
 * Add a URL to a Node. Requires login, user must be owner of both the node and URL
 *
 * @param string $urlid
 * @param string $nodeid
 * @param string $comments (optional)
 * @return Node or Error
 */
function addURLToNode($urlid, $nodeid, $comments=""){
    $node = new CNode($nodeid);
    $node->load();
    return $node->addURL($urlid,$comments);
}

///////////////////////////////////////////////////////////////////
// functions for connections
///////////////////////////////////////////////////////////////////

/**
 * Vote for the connection with the given connid
 *
 * @param string $connid
 * @param string $vote to make ('Y' vote or 'N' vote);
 * @return Connection or Error
 */
function connectionVote($connid,$vote){
    $c = new Connection($connid);
    return $c->vote($vote);
}

/**
 * Delete Vote for the connection with the given connid
 *
 * @param string $connid
 * @param string $vote to delete ('Y' vote or 'N' vote);
 * @return Connection or Error
 */
function deleteConnectionVote($connid,$vote){
    $c = new Connection($connid);
    return $c->deleteVote($vote);
}


/**
 * Get a Connection
 *
 * @param string $connid
 * @param String $style (optional - default 'long') may be 'short' or 'long'
 * @return Connection or Error
 */
function getConnection($connid, $style='long'){
    $c = new Connection($connid);
    $conn = $c->load($style);
    return $conn; // return the connection object
}

/**
 * Add a Connection. Requires login.<br>
 * The connections allowed by the Evidence Hub Model are as follows:<br><br>
 * Issue -> is related to -> Challenge<br>
 * Claim -> responds to -> Issue<br>
 * Solution -> addresses -> Issue<br>
 * Organization /Project -> addresses -> Issue<br>
 * Organization /Project -> addresses -> Challenge<br>
 * Organization /Project -> claims -> Claim<br>
 * Organization /Project -> specifies -> Solution<br>
 * Organization /Project -> specifies -> Evidence<br>
 * Organization /Project -> partnered with -> Partner Org/Project<br>
 * Organization -> manages -> Project<br>
 * Comment -> is related to  -> Node**<br>
 * Comment -> is related to -> Comment<br>
 * Node*** ->  has main theme -> Theme<br>
 * Node***** -> see also -> Node*****
 * Resource* ->  is related to -> Node****<br>
 * Evidence* -> supports -> Claim/Solution (The connection NodeType needs to be 'Pro')<br>
 * Evidence* -> challenges -> Claim/Solution (The connection NodeType needs to be 'Con')<br>
 *<br><br>
 * Evidence* = Case Study,Research Finding,Anecdote,Policy (or whatever your Evidence Types are as defined in the Config file).<br>
 * Resource* = Web Resource, Publication (or whatever your Resource types are, as defined in the Config file).<br>
 * Node**  =  Challenge,Organization,Project,Issue,Claim,Solution,Evidence,Theme<br>
 * Node*** = Challenge,Organization,Project,Issue,Claim,Solution,Evidence<br>
 * Node**** = Challenge,Organization,Project,Issue,Evidence<br>
 * Node***** = Challenge,Organization,Project,Issue,Claim,Solution,Evidence,Resource<br>
  * <br><br>
 * @param string $fromnodeid
 * @param string $fromroleid
 * @param string $linktypeid
 * @param string $tonodeid
 * @param string $toroleid
 * @param string $private optional, can be Y or N, defaults to users preferred setting
 * @param string $description
 * @return Connection or Error
 */
function addConnection($fromnodeid,$fromroleid,$linktypeid,$tonodeid,$toroleid,$private="",$description=""){
    global $USER, $HUB_DATAMODEL, $ERROR;

    //echo "linktypeid=".$linktypeid;
	//echo("<br>".$fromnodeid);
	//echo("<br>".$fromroleid);

	//echo("<br>".$tonodeid);
	//echo("<br>".$toroleid);

    if($private == ""){
        $private = $USER->privatedata;
    }

    // Check connection adheres to datamodel rules
    $fromNode = getNode($fromnodeid, 'short');
    $toNode = getNode($tonodeid, 'short');

	$linkType = new LinkType($linktypeid);
	$linkType->load();

    $fromRole = new Role($fromroleid);
    $fromRole->load();
    $toRole = new Role($toroleid);
    $toRole->load();

	$allowed = false;

	//echo("<br>".$fromNode->role->name);
	//echo("<br>".$fromRole->name);

	//echo("<br>".$toNode->role->name);
	//echo("<br>".$toRole->name);

	//echo $linkType->label;

	if ($fromNode instanceof Hub_Error) {
		$ERROR = new Hub_Error;
		return $ERROR->createInvalidConnectionError("fromnodeid:".$fromnodeid);
	}
	if ($toNode instanceof Hub_Error) {
		$ERROR = new Hub_Error;
		return $ERROR->createInvalidConnectionError("tonodeid:".$tonodeid);
	}

	if (!$linkType instanceof Hub_Error) {

		//error_log($fromNode->role->name);
		//error_log($fromRole->name);
		//error_log($linkType->label);
		//error_log($toRole->name);
		//error_log($toNode->role->name);

		if ($fromNode->role->name == $fromRole->name && $toNode->role->name == $toRole->name) {
			//error_log("HERE1");
			$allowed = $HUB_DATAMODEL->matchesModel($fromRole->name, $linkType->label, $toRole->name);
		} else if ($fromRole->name == 'Pro') {
			//error_log("HERE2");
			$allowed = $HUB_DATAMODEL->matchesModelPro($fromNode->role->name, $linkType->label, $toNode->role->name);
		} else if ($fromRole->name == 'Con') {
			//error_log("HERE3");
			$allowed = $HUB_DATAMODEL->matchesModelCon($fromNode->role->name, $linkType->label, $toNode->role->name);
		}

		if (!$allowed) {
			//error_log("NOT ALLOWED");
			$ERROR = new Hub_Error;
			return $ERROR->createInvalidConnectionError();
		} else {
			//error_log("ALLOWED");
	    	$cobj = new Connection();
	    	return $cobj->add($fromnodeid,$fromroleid,$linktypeid,$tonodeid,$toroleid,$private,$description);
	    }
	} else {
		//error_log("NOT ALLOWED - LINK ERROR");
		$ERROR = new Hub_Error;
		return $ERROR->createInvalidConnectionError("linktypeid".$linktypeid);
	}
}

/**
 * Edit a connection's description. Requires login and user must be owner of the connection
 *
 * @param string $connid
 * @param string $description
 * @return Connection or Error
 */
function editConnectionDescription($connid, $description=""){
    global $USER;
    $cobj = new Connection($connid);
    return $cobj->editDescription($description);
}

/**
 * Delete a connection. Requires login and user must be owner of the connection
 *
 * @param string $connid
 * @return Result or Error
 */
function deleteConnection($connid){
    $cobj = new Connection($connid);
    $result = $cobj->delete();
    return $result;
}

/**
 * Get the connections for the given parameters
 *
 * @param integer $start (optional - default: 0)
 * @param integer $max (optional - default: 20)
 * @param string $orderby (optional, either 'date', 'name' or 'moddate' - default: 'date')
 * @param string $sort (optional, either 'ASC' or 'DESC' - default: 'DESC')
 * @param string $filtergroup (optional, either 'all','selected','positive','negative' or 'neutral', default: 'all' - to filter the results by the link type group of the connection)
 * @param string $filterlist (optional, comma separated strings of the connection labels to filter the results by, to have any effect filtergroup must be set to 'selected')
 * @param string $filternodetypes (optional, a list of node type names to filter by)
 * @param string $themename the name of the theme to find connections for
 * @param String $style (optional - default 'long') may be 'short' or 'long'
 * @param string $q the query term(s)
 * @param string $scope (optional, either 'my' or 'all' - default: 'all')
 * @param boolean $tagsonly (optional, either true or false) if true, only return nodes where they have tags mathing the passed query terms
 * @return ConnectionSet or Error
 */
function getConnectionsByGlobal($start = 0,$max = 20 ,$orderby = 'date',$sort ='ASC', $filtergroup = 'all', $filterlist = '', $filternodetypes='', $themename="", $style='long', $q='', $scope='all',$tagsonly=false){
    global $USER,$CFG,$DB,$HUB_SQL;

	$currentuser = '';
	if (isset($USER->userid)) {
		$currentuser = $USER->userid;
	}

	$params = array();

	// SEARCH
	if (isset($q) && $q != "") {
    	$sql = $HUB_SQL->APILIB_CONNECTIONS_BY_GLOBAL_SELECT_SEARCH;
		if ($tagsonly) {
			$pieces = explode(",", $q);
			$loopCount = 0;
			$search = "";
			foreach ($pieces as $value) {
				$value = trim($value);
				$params[count($params)] = $value;

				if ($loopCount == 0) {
					$search .= $HUB_SQL->APILIB_TAG_SEARCH;
				} else {
					$search .= $HUB_SQL->OR.$HUB_SQL->APILIB_TAG_SEARCH;
				}
				$loopCount++;
			}
			$sql .= $HUB_SQL->OPENING_BRACKET;
			$sql .= $search;
			$sql .= $HUB_SQL->CLOSING_BRACKET.$HUB_SQL->AND;
		} else {
			$querySQL = getSearchQueryString($params, $q, true, true);
			$sql .= $querySQL;
			if ($querySQL != "") {
				$sql .= $HUB_SQL->AND;
			}
		}
		// PERMISSIONS
		$params[count($params)] = 'N';
		$params[count($params)] = $currentuser;
		$params[count($params)] = $currentuser;
		$sql .=  $HUB_SQL->APILIB_NODES_PERMISSIONS_ALL;

	    //echo $sql;

		// Get the nodeid for the nodes that match the search
		// Then used to filter connections.
		$resArray = $DB->select($sql, $params);

		// important to empty it out to use again.
		$params = array();
		$list = "";

		if ($resArray !== false) {
			$nodes = array();
			$loopCount = 0;
			$count = count($resArray);
			for ($i=0; $i < $count; $i++) {
				$array = $resArray[$i];
				$NodeID = $array['NodeID'];
				if (!isset($nodes[$NodeID])) {
					$list .= ",'".$NodeID."'";
					$nodes[$NodeID] = $NodeID;
				}
			}
			// remove first comma.
			$list = substr($list, 1);
		}

	    if($list == ""){
	        return new ConnectionSet();
	    }

		$sql = $HUB_SQL->APILIB_CONNECTIONS_BY_GLOBAL_SELECT.$HUB_SQL->APILIB_CONNECTIONS_BY_GLOBAL_SELECT_PART1;
		$sql .= $list;
    	$sql .= $HUB_SQL->APILIB_CONNECTIONS_BY_GLOBAL_SELECT_PART2;
		$sql .= $list;
		$sql .= $HUB_SQL->APILIB_CONNECTIONS_BY_GLOBAL_SELECT_PART3;
    } else {
	    $sql = $HUB_SQL->APILIB_CONNECTIONS_BY_GLOBAL_SELECT;
	}

	// FILTER BY THEME
	if ($themename != "") {
		$params[count($params)] = $themename;
		$params[count($params)] = $themename;
		$sql .= $HUB_SQL->APILIB_CONNECTIONS_BY_GLOBAL_THEME_FILTER;
	}

	// FILTER BY NODE TYPES - AND
    if ($filternodetypes != "") {
		$nodetypeArray = array();
		$innersql = getSQLForNodeTypeIDsForLabels($nodetypeArray,$filternodetypes);

		$params = array_merge($params, $nodetypeArray);
		$sql .= $HUB_SQL->APILIB_CONNECTIONS_BY_GLOBAL_NODETYPE_FILTER_PART1;
		$sql .= $innersql;

		$params = array_merge($params, $nodetypeArray);
		$sql .= $HUB_SQL->APILIB_CONNECTIONS_BY_GLOBAL_NODETYPE_FILTER_PART2;
		$sql .= $innersql;

		$sql .= $HUB_SQL->APILIB_CONNECTIONS_BY_GLOBAL_NODETYPE_FILTER_PART3;
    }

	// FILTER BY LINK TYPES
	if ($filtergroup != '' && $filtergroup != 'all' && $filtergroup != 'selected') {
		$innersql = getSQLForLinkTypeIDsForGroup($params,$filtergroup);
		$sql .= $HUB_SQL->APILIB_CONNECTIONS_BY_GLOBAL_LINKTYPE_FILTER;
		$sql .= $HUB_SQL->OPENING_BRACKET;
		$sql .= $innersql;
		$sql .= $HUB_SQL->CLOSING_BRACKET.$HUB_SQL->AND;
	} else {
		if ($filterlist != "") {
			$innersql = getSQLForLinkTypeIDsForLabels($params,$filterlist);
			$sql .= $HUB_SQL->APILIB_CONNECTIONS_BY_GLOBAL_LINKTYPE_FILTER;
			$sql .= $HUB_SQL->OPENING_BRACKET;
			$sql .= $innersql;
			$sql .= $HUB_SQL->CLOSING_BRACKET.$HUB_SQL->AND;
		}
	}

	// PERMISSIONS
	$params[count($params)] = 'N';
	$params[count($params)] = $currentuser;
	$params[count($params)] = $currentuser;
	$params[count($params)] = 'N';
	$params[count($params)] = $currentuser;
	$params[count($params)] = $currentuser;
	$params[count($params)] = 'N';
	$params[count($params)] = $currentuser;
	$params[count($params)] = $currentuser;
	$sql .= $HUB_SQL->APILIB_CONNECTIONS_BY_GLOBAL_PERMISSIONS;

	//echo $sql;

	//print_r($params);

    $cs = new ConnectionSet();
    return $cs->load($sql,$params,$start,$max,$orderby,$sort,$style);
}

/**
 * Get the connections for given user
 *
 * @param string $userid
 * @param integer $start (optional - default: 0)
 * @param integer $max (optional - default: 20)
 * @param string $orderby (optional, either 'date', 'name' or 'moddate' - default: 'date')
 * @param string $sort (optional, either 'ASC' or 'DESC' - default: 'DESC')
 * @param string $filtergroup (optional, either 'all','selected','positive','negative' or 'neutral', default: 'all' - to filter the results by the link type group of the connection)
 * @param string $filterlist (optional, comma separated strings of the connection labels to filter the results by, to have any effect filtergroup must be set to 'selected')
 * @param string $filternodetypes (optional, a list of node type names to filter by)
 * @param String $style (optional - default 'long') may be 'short' or 'long'
 * @return ConnectionSet or Error
 */
function getConnectionsByUser($userid,$start = 0,$max = 20 ,$orderby = 'date',$sort ='ASC', $filtergroup = 'all', $filterlist = '', $filternodetypes='', $style='long', $q=""){
    global $USER,$CFG,$DB,$HUB_SQL;

	$currentuser = '';
	if (isset($USER->userid)) {
		$currentuser = $USER->userid;
	}

	$params = array();

	// SEARCH
	if (isset($q) && $q != "") {
    	$sql = $HUB_SQL->APILIB_CONNECTIONS_BY_GLOBAL_SELECT_SEARCH;

		$querySQL = getSearchQueryString($params, $q, true, true);
     	$sql .= $querySQL;
     	if ($querySQL != "") {
    		$sql .= $HUB_SQL->AND;
     	}

		// FILTER BY USER
		$params[count($params)] = $userid;
        $sql .= $HUB_SQL->FILTER_USER;

		// PERMISSIONS
		$params[count($params)] = 'N';
		$params[count($params)] = $currentuser;
		$params[count($params)] = $currentuser;
		$sql .=  $HUB_SQL->APILIB_NODES_PERMISSIONS_ALL;

	    //echo $sql;

		// Get the nodeid for the nodes that match the search
		// Then used to filter connections.
		$resArray = $DB->select($sql, $params);

		// important to empty it out to use again.
		$params = array();
		$list = "";

		if ($resArray !== false) {
			$nodes = array();
			$loopCount = 0;
			$count = count($resArray);
			for ($i=0; $i < $count; $i++) {
				$array = $resArray[$i];
				$NodeID = $array['NodeID'];
				if (!isset($nodes[$NodeID])) {
					$list .= ",'".$NodeID."'";
					$nodes[$NodeID] = $NodeID;
				}
			}
			// remove first comma.
			$list = substr($list, 1);
		}

	    if($list == ""){
	        return new ConnectionSet();
	    }

		$sql = $HUB_SQL->APILIB_CONNECTIONS_BY_GLOBAL_SELECT;
		$sql .= $HUB_SQL->APILIB_CONNECTIONS_BY_USER_SELECT_PART1;
		$sql .= $list;
    	$sql .= $HUB_SQL->APILIB_CONNECTIONS_BY_USER_SELECT_PART2;
		$sql .= $list;
		$sql .= $HUB_SQL->APILIB_CONNECTIONS_BY_USER_SELECT_PART3;
    } else {
	    $sql = $HUB_SQL->APILIB_CONNECTIONS_BY_GLOBAL_SELECT;
	}

	// FILTER BY USER
	$params[count($params)] = $userid;
	$sql .= $HUB_SQL->FILTER_USER.$HUB_SQL->AND;

	// FILTER BY NODE TYPES - AND
    if ($filternodetypes != "") {
		$nodetypeArray = array();
		$innersql = getSQLForNodeTypeIDsForLabels($nodetypeArray,$filternodetypes);

		$params = array_merge($params, $nodetypeArray);
		$sql .= $HUB_SQL->APILIB_CONNECTIONS_BY_GLOBAL_NODETYPE_FILTER_PART1;
		$sql .= $innersql;

		$params = array_merge($params, $nodetypeArray);
		$sql .= $HUB_SQL->APILIB_CONNECTIONS_BY_GLOBAL_NODETYPE_FILTER_PART2;
		$sql .= $innersql;
		$sql .= $HUB_SQL->APILIB_CONNECTIONS_BY_GLOBAL_NODETYPE_FILTER_PART3;
    }

	// FILTER BY LINK TYPES
	if ($filtergroup != '' && $filtergroup != 'all' && $filtergroup != 'selected') {
		$innersql = getSQLForLinkTypeIDsForGroup($params,$filtergroup);
		$sql .= $HUB_SQL->APILIB_CONNECTIONS_BY_GLOBAL_LINKTYPE_FILTER;
		$sql .= $HUB_SQL->OPENING_BRACKET;
		$sql .= $innersql;
		$sql .= $HUB_SQL->CLOSING_BRACKET.$HUB_SQL->AND;
	} else {
		if ($filterlist != "") {
			$innersql = getSQLForLinkTypeIDsForLabels($params,$filterlist);
			$sql .= $HUB_SQL->APILIB_CONNECTIONS_BY_GLOBAL_LINKTYPE_FILTER;
			$sql .= $HUB_SQL->OPENING_BRACKET;
			$sql .= $innersql;
			$sql .= $HUB_SQL->CLOSING_BRACKET.$HUB_SQL->AND;
		}
	}

	// PERMISSIONS
	$params[count($params)] = 'N';
	$params[count($params)] = $currentuser;
	$params[count($params)] = $currentuser;
	$params[count($params)] = 'N';
	$params[count($params)] = $currentuser;
	$params[count($params)] = $currentuser;
	$params[count($params)] = 'N';
	$params[count($params)] = $currentuser;
	$params[count($params)] = $currentuser;
	$sql .= $HUB_SQL->APILIB_CONNECTIONS_BY_GLOBAL_PERMISSIONS;

    $cs = new ConnectionSet();
    return $cs->load($sql,$params,$start,$max,$orderby,$sort,$style);
}

/**
 * Get the connections for given label of the node with the given nodeid
 *
 * @param string $nodeid
 * @param integer $start (optional - default: 0)
 * @param integer $max (optional - default: 20)
 * @param string $orderby (optional, either 'vote', 'date', 'name' or 'moddate' - default: 'date')
 * @param string $sort (optional, either 'ASC' or 'DESC' - default: 'DESC')
 * @param string $filtergroup (optional, either 'all','selected','positive','negative' or 'neutral', default: 'all' - to filter the results by the link type group of the connection)
 * @param string $filterlist (optional, comma separated strings of the connection labels to filter the results by, to have any effect filtergroup must be set to 'selected')
 * @param string $filternodetypes (optional, a list of node type names to filter by)
 * @param String $style (optional - default 'long') may be 'short' or 'long'
 * @return ConnectionSet or Error
 */
function getConnectionsByNode($nodeid,$start = 0,$max = 20 ,$orderby = 'date',$sort ='ASC', $filtergroup = 'all', $filterlist = '', $filternodetypes='', $style='long'){
    global $USER,$CFG,$HUB_SQL;

	$currentuser = '';
	if (isset($USER->userid)) {
		$currentuser = $USER->userid;
	}

	$params = array();

    $list = getAggregatedNodeIDs($nodeid);
	if ($list != "") {
		$sql = $HUB_SQL->APILIB_CONNECTIONS_BY_GLOBAL_SELECT;
		$sql .= $HUB_SQL->APILIB_CONNECTIONS_BY_NODE_SELECT_PART1;
		$sql .= $list;
    	$sql .= $HUB_SQL->APILIB_CONNECTIONS_BY_NODE_SELECT_PART2;
		$sql .= $list;
		$sql .= $HUB_SQL->APILIB_CONNECTIONS_BY_NODE_SELECT_PART3;

		// FILTER BY NODE TYPES - OR
		if ($filternodetypes != "") {
			$nodetypeArray = array();
			$innersql = getSQLForNodeTypeIDsForLabels($nodetypeArray,$filternodetypes);

			$params = array_merge($params, $nodetypeArray);
			$sql .= $HUB_SQL->APILIB_CONNECTIONS_BY_NODE_NODETYPE_FILTER_PART1;
			$sql .= $innersql;

			$params = array_merge($params, $nodetypeArray);
			$sql .= $HUB_SQL->APILIB_CONNECTIONS_BY_NODE_NODETYPE_FILTER_PART2;
			$sql .= $innersql;

			$sql .= $HUB_SQL->APILIB_CONNECTIONS_BY_NODE_NODETYPE_FILTER_PART3;
		}

		// FILTER BY LINK TYPES
		if ($filtergroup != '' && $filtergroup != 'all' && $filtergroup != 'selected') {
			$innersql = getSQLForLinkTypeIDsForGroup($params,$filtergroup);
			$sql .= $HUB_SQL->APILIB_CONNECTIONS_BY_GLOBAL_LINKTYPE_FILTER;
			$sql .= $HUB_SQL->OPENING_BRACKET;
			$sql .= $innersql;
			$sql .= $HUB_SQL->CLOSING_BRACKET.$HUB_SQL->AND;
		} else {
			if ($filterlist != "") {
				$innersql = getSQLForLinkTypeIDsForLabels($params,$filterlist);
				$sql .= $HUB_SQL->APILIB_CONNECTIONS_BY_GLOBAL_LINKTYPE_FILTER;
				$sql .= $HUB_SQL->OPENING_BRACKET;
				$sql .= $innersql;
				$sql .= $HUB_SQL->CLOSING_BRACKET.$HUB_SQL->AND;
			}
		}

		// PERMISSIONS
		$params[count($params)] = 'N';
		$params[count($params)] = $currentuser;
		$params[count($params)] = $currentuser;
		$params[count($params)] = 'N';
		$params[count($params)] = $currentuser;
		$params[count($params)] = $currentuser;
		$params[count($params)] = 'N';
		$params[count($params)] = $currentuser;
		$params[count($params)] = $currentuser;
		$sql .= $HUB_SQL->APILIB_CONNECTIONS_BY_GLOBAL_PERMISSIONS;

		// ORDER BY VOTE
		if ($orderby == 'vote') {
			$sql = $HUB_SQL->APILIB_CONNECTION_ORDERBY_VOTE_PART1.$sql.$HUB_SQL->APILIB_CONNECTION_ORDERBY_VOTE_PART2;
		}

		//error_log(print_r($sql, true));

	    $cs = new ConnectionSet();
	    return $cs->load($sql,$params,$start,$max,$orderby,$sort,$style);
	} else {
		return new ConnectionSet();
	}
}

/**
 * Get the connections for given url
 *
 * @param string $url
 * @param integer $start (optional - default: 0)
 * @param integer $max (optional - default: 20)
 * @param string $orderby (optional, either 'date', 'name' or 'moddate' - default: 'date')
 * @param string $sort (optional, either 'ASC' or 'DESC' - default: 'DESC')
 * @param string $filtergroup (optional, either 'all','selected','positive','negative' or 'neutral', default: 'all' - to filter the results by the link type group of the connection)
 * @param string $filterlist (optional, comma separated strings of the connection labels to filter the results by, to have any effect filtergroup must be set to 'selected')
 * @param string $filternodetypes (optional, a list of node type names to filter by)
 * @param String $style (optional - default 'long') may be 'short' or 'long'
 * @return ConnectionSet or Error
 */
function getConnectionsByURL($url,$start = 0,$max = 20 ,$orderby = 'date',$sort ='ASC', $filtergroup = 'all', $filterlist = '', $filternodetypes='', $style='long'){
    global $USER,$CFG,$HUB_SQL;

	$currentuser = '';
	if (isset($USER->userid)) {
		$currentuser = $USER->userid;
	}

	$params = array();

    $sql = $HUB_SQL->APILIB_CONNECTIONS_BY_GLOBAL_SELECT;

	// FILTER BY NODE TYPES - AND
    if ($filternodetypes != "") {
    	$nodetypeArray = array();
		$innersql = getSQLForNodeTypeIDsForLabels($nodetypeArray,$filternodetypes);

		$params = array_merge($params, $nodetypeArray);
		$sql .= $HUB_SQL->APILIB_CONNECTIONS_BY_GLOBAL_NODETYPE_FILTER_PART1;
		$sql .= $innersql;

		$params = array_merge($params, $nodetypeArray);
		$sql .= $HUB_SQL->APILIB_CONNECTIONS_BY_GLOBAL_NODETYPE_FILTER_PART2;
		$sql .= $innersql;

		$sql .= $HUB_SQL->APILIB_CONNECTIONS_BY_GLOBAL_NODETYPE_FILTER_PART3;
    }

	// FILTER BY LINK TYPES
	if ($filtergroup != '' && $filtergroup != 'all' && $filtergroup != 'selected') {
		$innersql = getSQLForLinkTypeIDsForGroup($params,$filtergroup);
		$sql .= $HUB_SQL->APILIB_CONNECTIONS_BY_GLOBAL_LINKTYPE_FILTER;
		$sql .= $HUB_SQL->OPENING_BRACKET;
		$sql .= $innersql;
		$sql .= $HUB_SQL->CLOSING_BRACKET.$HUB_SQL->AND;
	} else {
		if ($filterlist != "") {
			$innersql = getSQLForLinkTypeIDsForLabels($params,$filterlist);
			$sql .= $HUB_SQL->APILIB_CONNECTIONS_BY_GLOBAL_LINKTYPE_FILTER;
			$sql .= $HUB_SQL->OPENING_BRACKET;
			$sql .= $innersql;
			$sql .= $HUB_SQL->CLOSING_BRACKET.$HUB_SQL->AND;
		}
	}

	// PERMISSIONS
	// for connection
	$params[count($params)] = 'N';
	$params[count($params)] = $currentuser;
	$params[count($params)] = $currentuser;

	// for from url
	$params[count($params)] = $url;
	$params[count($params)] = 'N';
	$params[count($params)] = $currentuser;
	$params[count($params)] = $currentuser;
	// for from node
	$params[count($params)] = 'N';
	$params[count($params)] = $currentuser;
	$params[count($params)] = $currentuser;

	// for to url
	$params[count($params)] = $url;
	$params[count($params)] = 'N';
	$params[count($params)] = $currentuser;
	$params[count($params)] = $currentuser;
	// for to node
	$params[count($params)] = 'N';
	$params[count($params)] = $currentuser;
	$params[count($params)] = $currentuser;

	$sql .= $HUB_SQL->APILIB_CONNECTIONS_BY_URL_PERMISSIONS;

    $cs = new ConnectionSet();
    return $cs->load($sql,$params,$start,$max,$orderby,$sort,$style);
}

/**
 * Get all the connections for the given node types and link types
 *
 * @param string $scope (either 'all' or 'my')
 * @param integer $start (optional - default: 0)
 * @param integer $max (optional - default: 20)
 * @param string $orderby (optional, either 'date', 'name' or 'moddate' - default: 'date')
 * @param string $sort (optional, either 'ASC' or 'DESC' - default: 'DESC')
 * @param string $linklabels (optional, comma separated strings of the connection labels to filter the results by, to have any effect filtergroup must be set to 'selected')
 * @param string $filternodetypes (optional, a list of node type names to filter by)
 * @param string $userid the id of the user to filter by (this will check the ownership of the nodes in the connection, not the connection itself).
 * @param String $style (optional - default 'long') may be 'short' or 'long'
 * @return ConnectionSet or Error
 */
function getConnectionsBySocial($scope,$start = 0,$max = 20 ,$orderby = 'date',$sort ='ASC', $linklabels = '', $filternodetypes='', $userid='', $style='long'){
    global $DB, $USER,$CFG,$HUB_SQL;

	$currentuser = '';
	if (isset($USER->userid)) {
		$currentuser = $USER->userid;
	}

	$params = array();

    $sql = $HUB_SQL->APILIB_CONNECTIONS_BY_SOCIAL;
    $sql .= $HUB_SQL->AND;

	// FILTER BY NODE TYPES - AND
    if ($filternodetypes != "") {
    	$nodetypeArray = array();
		$innersql = getSQLForNodeTypeIDsForLabels($nodetypeArray,$filternodetypes);

		$params = array_merge($params, $nodetypeArray);
		$sql .= $HUB_SQL->APILIB_CONNECTIONS_BY_GLOBAL_NODETYPE_FILTER_PART1;
		$sql .= $innersql;

		$params = array_merge($params, $nodetypeArray);
		$sql .= $HUB_SQL->APILIB_CONNECTIONS_BY_GLOBAL_NODETYPE_FILTER_PART2;
		$sql .= $innersql;

		$sql .= $HUB_SQL->APILIB_CONNECTIONS_BY_GLOBAL_NODETYPE_FILTER_PART3;
    }

	// FILTER BY LINK TYPES
	if ($linklabels != "") {
		$innersql = getSQLForLinkTypeIDsForLabels($params,$linklabels);
		$sql .= $HUB_SQL->APILIB_CONNECTIONS_BY_GLOBAL_LINKTYPE_FILTER;
		$sql .= $HUB_SQL->OPENING_BRACKET;
		$sql .= $innersql;
		$sql .= $HUB_SQL->CLOSING_BRACKET.$HUB_SQL->AND;
	}

	// FILTER BY USER
    if ($userid != "") {
		$params[count($params)] = $userid;
		$params[count($params)] = $userid;
    	$sql .= $HUB_SQL->APILIB_FILTER_USER_SOCIAL.$HUB_SQL->AND;
    }

	// PERMISSIONS
    if($scope == "my"){
		$params[count($params)] = $currentuser;
        $sql .= $HUB_SQL->FILTER_USER.$HUB_SQL->AND;
    }

    $params[count($params)] = 'N';
	$params[count($params)] = $currentuser;
	$params[count($params)] = $currentuser;
	$params[count($params)] = 'N';
	$params[count($params)] = $currentuser;
	$params[count($params)] = $currentuser;
	$params[count($params)] = 'N';
	$params[count($params)] = $currentuser;
	$params[count($params)] = $currentuser;
	$sql .= $HUB_SQL->APILIB_CONNECTIONS_BY_GLOBAL_PERMISSIONS;

    $cs = new ConnectionSet();

	//echo $sql;

    return $cs->load($sql,$params,$start,$max,$orderby,$sort,$style);
}

/**
 * Get all connections from the given list of connection ids.
 *
 * @param String $connectionids a comma separated list of the connection ids to get.
 * @param integer $start (optional - default: 0)
 * @param integer $max (optional - default: -1 = all)
 * @param string $orderby (optional, either 'date', 'name' or 'moddate' - default: 'date')
 * @param string $sort (optional, either 'ASC' or 'DESC' - default: 'DESC')
 * @param String $style (optional - default 'long') may be 'short' or 'long'
 * @return ConnectionSet or Error
 */
function getMultiConnections($connectionids, $start = 0,$max = -1 ,$orderby = 'date',$sort ='ASC', $style='long') {
    global $USER,$CFG,$HUB_SQL;

	$currentuser = '';
	if (isset($USER->userid)) {
		$currentuser = $USER->userid;
	}

	$params = array();

	// Loop through list of connection ids and add to array
	$pieces = explode(",", $connectionids);
	$loopCount = 0;
	$connids = "";
	foreach ($pieces as $value) {
		$value = trim($value);
		$params[count($params)] = $value;

		if ($loopCount == 0) {
			$connids .= "?";
		} else {
			$connids .= ",?";
		}
		$loopCount++;
	}

	$sql = $HUB_SQL->APILIB_CONNECTIONS_BY_MULTI_SELECT_PART1;
	$sql .= $connids;
	$sql .= $HUB_SQL->APILIB_CONNECTIONS_BY_MULTI_SELECT_PART2;

    $params[count($params)] = 'N';
	$params[count($params)] = $currentuser;
	$params[count($params)] = $currentuser;
	$params[count($params)] = 'N';
	$params[count($params)] = $currentuser;
	$params[count($params)] = $currentuser;
	$params[count($params)] = 'N';
	$params[count($params)] = $currentuser;
	$params[count($params)] = $currentuser;
	$sql .= $HUB_SQL->AND.$HUB_SQL->APILIB_CONNECTIONS_BY_GLOBAL_PERMISSIONS;

    $cs = new ConnectionSet();
    return $cs->load($sql,$params,$start,$max,$orderby,$sort,$style);
}

/**
 * Get the connections for the given network search parameters from the given node.
 *
 * @param string $nodeid the id of the node to search outward from.
 * @param string $linklabels the string of link types.
 * @param string $userid optional for searching only a specified user's data. (only used if scope is 'all') - NOT USED AT PRESENT
 * @param string $scope (either 'all' or 'my', default 'all')
 * @param string $linkgroup (optional, either Positive, Negative, or Neutral - default: empty string);
 * @param integer $depth (optional, 1-7, or 7 for full depth;
 * @param string $direction (optional, 'outgoing', 'incoming', or 'both - default: 'both',
 * @param string $labelmatch (optional, 'true', 'false' - default: false;
 * @param string $nodetypes a comman separated list of the node type names to include in the search.
 * @param String $style (optional - default 'long') may be 'short' or 'long'
 * @return ConnectionSet or Error
 */
function getConnectionsByPath($nodeid, $linklabels, $userid, $scope='all', $linkgroup='', $depth=7, $direction="both", $labelmatch='false', $nodetypes='', $style='long'){
    global $DB,$USER,$CFG;

	$searchLinkLabels = "";
	$searchLinkLabelsArray = array();
	//$searchLinkLabels = getSQLForLinkTypeIDsForLabels(&$searchLinkLabelsArray, $linklabels)

	if ($linklabels != "" && $linkgroup == "") {
		$pieces = explode(",", $linklabels);
		$loopCount = 0;
		foreach ($pieces as $value) {
			$searchLinkLabelsArray[$loopCount] = $value;
			if ($loopCount == 0) {
				$searchLinkLabels .= "?";
			} else {
				$searchLinkLabels .= ",?";
			}
			$loopCount++;
		}
	}


	$nodeTypeNames = "";
	$nodeTypeNamesArray = array();
	//$nodeTypeNames = getSQLForNodeTypeIDsForLabels($nodeTypeNamesArray,$nodetypes);

	if ($nodetypes != "") {
	    $nodeTypeNames = "";
	    $pieces = explode(",", $nodetypes);
	    $loopCount = 0;
	    foreach ($pieces as $value) {
			$nodeTypeNamesArray[$loopCount] = $value;
	        if ($loopCount == 0) {
	        	$nodeTypeNames .= "?";
	        } else {
	        	$nodeTypeNames .= ",?";
	        }
	        $loopCount++;
	    }
	}

	// GET TEXT FOR PASSED IDEA ID IF REQUIRED
	$text = "";
	if ($labelmatch == 'true') {
		$params = array();
		$params[0] = $nodeid;
		$qry = $HUB_SQL->APILIB_NODE_NAME_BY_ID_SELECT;
		$resArray = $DB->select($qry, $params);
		if ($resArray !== false && count($resArray) > 0) {
			$text = $resArray[0]['Name'];
		} else {
			return database_error();
		}
	}

	$matchesFound = array();
	if (($labelmatch == 'true' && $text != "") || ($labelmatch == 'false' && $nodeid != "")) {
		$checkConnections = array();
		$matchedConnections = array();
		if ($labelmatch == 'true') {
			$nextNodes[0] = $text;
		} else {
			$nextNodes[0] = $nodeid;
		}
		$matchesFound = searchNetworkConnections($checkConnections, $matchedConnections, $nextNodes, $searchLinkLabels, $searchLinkLabelsArray, $linkgroup, $labelmatch, $depth, 0, $direction, $nodeTypeNames, $nodeTypeNamesArray, $scope);
	}
	//return database_error($matchesFound);


	//error_log(print_r($matchesFound, true));

	$cs = new ConnectionSet($matchesFound);
	return $cs->loadConnections($matchesFound, $style);
}

/**
 * Get the connections for the given netowrk search paramters from the given node.
 *
 * @param string $logictype (either 'and' or 'or', deafult 'or').
 * @param string $scope (either 'all' or 'my', deafult 'all')
 * @param string $labelmatch (optional, 'true', 'false' - default: false;
 * @param string $nodeid the id of the node to search outward from.
 * @param integer $depth (optional, 1-7, default 1);
 * @param string $linklabels Array of strings of link types. Array length must match depth specified. Each array level is mutually exclusive with linkgroups - there can only be one.
 * @param string $linkgroups Array of either Positive, Negative, or Neutral - default: empty string). Array length must match depth specified.Each array level is mutually exclusive with linklabels - there can only be one.
 * @param string $directions Array of 'outgoing', 'incmong', or 'both - default: 'both'. Array length must match depth specified.
 * @param string $nodetypes Array of strings of node type names. Array length must match depth specified.
 * @param string $nodeids Array of strings of nodeids. Array length must match depth specified.
 * @param String $style (optional - default 'long') may be 'short' or 'long'
 * @return ConnectionSet or Error
 */
function getConnectionsByPathByDepth($logictype = 'or', $scope='all', $labelmatch='false', $nodeid, $depth=1, $linklabels, $linkgroups, $directions, $nodetypes, $nodeids, $uniquepath='true', $style='long'){
	if ($logictype == "and") {
		return getConnectionsByPathByDepthAND($scope,$labelmatch,$nodeid,$depth,$linklabels,$linkgroups,$directions,$nodetypes,$nodeids, $uniquepath, $style);
	} else {
		return getConnectionsByPathByDepthOR($scope,$labelmatch,$nodeid,$depth,$linklabels,$linkgroups,$directions,$nodetypes,$nodeids, $uniquepath, $style);
	}
}

///////////////////////////////////////////////////////////////////
// functions for roles
///////////////////////////////////////////////////////////////////

/**
 * Get a role (by name)
 *
 * @param string $rolename
 * @return Role or Error
 */
function getRoleByName($rolename){
    $r = new Role();
    return $r->loadByName($rolename);
}

///////////////////////////////////////////////////////////////////
// functions for link types
///////////////////////////////////////////////////////////////////

/**
 * Get a linktype by label
 *
 * @param string $label
 * @return LinkType or Error
 */
function getLinkTypeByLabel($label){
    $lt = new LinkType();
    return $lt->loadByLabel($label);
}

///////////////////////////////////////////////////////////////////
//functions for tags
///////////////////////////////////////////////////////////////////
/**
* Get a tag (by id)
*
* @param string $tagid
* @return Tag or Error
*/
function getTag($tagid){
	$t = new Tag($tagid);
	return $t->load();
}

/**
* Get the current user's tag list for tags used on Nodes (not on their User Profile). Login required.
*
* @return TagSet or Error
*/
function getUserTags(){
	global $CFG,$USER,$HUB_SQL;

	$currentuser = '';
	if (isset($USER->userid)) {
		$currentuser = $USER->userid;
	}

	$params = array();
	$params[0] = $currentuser;

	$sql = $HUB_SQL->APILIB_TAGS_BY_USER_SELECT;

    $ts = new TagSet();
	return $ts->load($sql, $params);
}

/**
 * Searches tags by node name based on the first chartacters
 *
 * @param string $q the query term(s)
 * @param string $scope (optional, either 'all' or 'my' - default: 'my')
 * @return TagSet or Error
 */
function getTagsByFirstCharacters($q, $scope){
    global $CFG,$USER,$HUB_SQL;

	$currentuser = '';
	if (isset($USER->userid)) {
		$currentuser = $USER->userid;
	}

	$params = array();

	// Don't want speech marks added in MySQL version
	$next = new stdClass();
	$params[0] = $next->value = $q;

    $sql = $HUB_SQL->APILIB_TAGS_BY_FIRST_CHARACTER_SELECT_PART1;
    if ($scope == 'my') {
		$params[1] = $currentuser;
    	$sql .= $HUB_SQL->AND;
        $sql .= $HUB_SQL->FILTER_USER;
    }
    $sql = $HUB_SQL->APILIB_TAGS_BY_FIRST_CHARACTER_SELECT_PART2;

    $ts = new TagSet();
    return $ts->load($sql, $params);
}

/**
* Add new tag - if the tag already exists then this
* existing tag object will be returned. Login required.
*
* @param string $tagname
* @return Role or Error
*/
function addTag($tagname){
	$tagobj = new Tag();
	return $tagobj->add($tagname);
}

/**
* Edit a tag. If that tag name already exists for this user, return an error.
* Requires login and user must be owner of the tag
*
* @param string $tagid
* @param string $tagname
* @return Tag or Error
*/
function editTag($tagid,$tagname){
	$tagobj = new Tag($tagid);
	return $tagobj->edit($tagname);
}

/**
* Delete a tag. Requires login and user must be owner of the tag.
*
* @param string $tagid
* @return Result or Error
*/
function deleteTag($tagid){
	$tagobj = new Tag($tagid);
	return $tagobj->delete();
}

///////////////////////////////////////////////////////////////////
// functions for users
///////////////////////////////////////////////////////////////////

/**
 * Get the users with the most connections (excludes groups)
 *
 * @param integer $start (optional - default: 0)
 * @param integer $max (optional - default: 20)
 * @param String $style (optional - default 'long') may be 'short' or 'long'  - how much of a users details to load (long includes: tags and groups).
 * @return UserSet or Error
 */
function getActiveConnectionUsers($start = 0,$max = 20,$style='long') {
    global $CFG,$DB,$HUB_SQL;

	$params = array();

	$sql = $HUB_SQL->APILIB_CONNECTIONS_BY_ACTIVE_USERS_SELECT;

    // ADD LIMITING
    $sql = $DB->addLimitingResults($sql, $start, $max);
	$resArray = $DB->select($sql, $params);

    $us = new UserSet();
	$count = count($resArray);
	$us->totalno = $count;
	$us->start = $start;
	$us->count = $count;
	for ($i=0; $i<$count; $i++) {
		$array = $resArray[$i];
		$u = new User($array["UserID"]);
		$us->add($u->load($style));
		$u->connectioncount = $array["num"];
	}

    return $us;
}

/**
 * Get the users with the most ideas (excludes groups)
 *
 * @param integer $start (optional - default: 0)
 * @param integer $max (optional - default: 20)
 * @param String $style (optional - default 'long') may be 'short' or 'long'  - how much of a users details to load (long includes: tags and groups).
 * @return UserSet or Error
 */
function getActiveIdeaUsers($start = 0,$max = 20,$style='long') {
    global $CFG,$DB,$HUB_SQL;

	$params = array();

	$sql = $HUB_SQL->APILIB_NODES_BY_ACTIVE_USERS_SELECT;

    // ADD LIMITING
    $sql = $DB->addLimitingResults($sql, $start, $max);

	$resArray = $DB->select($sql, $params);

    $us = new UserSet();
	$count = count($resArray);
	$us->totalno = $count;
	$us->start = $start;
	$us->count = $count;
	for ($i=0; $i<$count; $i++) {
		$array = $resArray[$i];
		$u = new User($array["UserID"]);
		$us->add($u->load($style));
		$u->ideacount = $array["num"];
	}

    return $us;
}

/**
 * Get a user
 *
 * @param string $userid
 * @param string $format (optional - default 'long') may be 'short' or 'long'
 * @return User or Error
 */
function getUser($userid,$format='long'){
    $u = new User($userid);
    return $u->load($format);
}

/**
 * Get the users following the given item
 *
 * @param string $itemid
 * @param integer $start (optional - default: 0)
 * @param integer $max (optional - default: 20)
 * @param string $orderby (optional, either 'date', 'name' or 'moddate' - default: 'date')
 * @param string $sort (optional, either 'ASC' or 'DESC' - default: 'DESC')
 * @param String $style (optional - default 'long') may be 'short' or 'long'  - how much of a user's details to load (long includes: tags and groups).
 * @return UserSet or Error
 */
function getUsersByFollowing($itemid, $start = 0,$max = 20 ,$orderby = 'date',$sort ='DESC',$style='long'){
	global $HUB_SQL;

	$params = array();
	$params[0] = $itemid;

    $sql = $HUB_SQL->APILIB_USERS_BY_FOLLOWING_SELECT;

    $us = new UserSet();
    return $us->loadFollowers($sql,$params,$start,$max,$orderby,$sort,$style);
}


/**
 * Get the users following the given item
 *
 * @param string $itemid
 * @param number $from the time from which to get their follwoing expressed in seconds
 * @param integer $start (optional - default: 0)
 * @param integer $max (optional - default: 20)
 * @param string $orderby (optional, either 'date', 'name' or 'moddate' - default: 'date')
 * @param string $sort (optional, either 'ASC' or 'DESC' - default: 'DESC')
 * @param String $style (optional - default 'long') may be 'short' or 'long'  - how much of a user's details to load (long includes: tags and groups).
 * @return UserSet or Error
 */
function getUsersByFollowingByDate($itemid, $from, $start = 0,$max = 20 ,$orderby = 'date',$sort ='DESC',$style='long'){
	global $HUB_SQL;

	$params = array();
	$params[0] = $itemid;

    $sql = $HUB_SQL->APILIB_USERS_BY_FOLLOWING_SELECT;
	if ($from > 0) {
		$params[count($params)] = $from;
		$sql .= $HUB_SQL->APILIB_USERS_BY_FOLLOWING_SELECT_DATE;
	}

    $us = new UserSet();
    return $us->loadFollowers($sql,$params,$start,$max,$orderby,$sort,$style);
}

/**
 * Get the users being most followed
 *
 * @param integer $limit (optional - default: 5)
 * @param String $style (optional - default 'long') may be 'short' or 'long'  - how much of a user's details to load (long includes: tags and groups).
 * @return UserSet or Error
 */
function getUsersByMostFollowed($limit=5,$style='long'){
	global $DB, $HUB_SQL;

	$params = array();

    $sql = $HUB_SQL->APILIB_USERS_BY_MOST_FOLLOWING_SELECT;

    // ADD LIMITING
    if ($limit > 0) {
	    $sql = $DB->addLimitingResults($sql, 0, $limit);
	}
    $us = new UserSet();
	return $us->loadFollowed($sql, $params, $style);
}

/**
 * Return the most Active users
 * @param integer $limit (optional - default: 5)
 * @param number $from the time from which to get thier activity expressed in milliseconds
 * @return ActivitySet or Error
 */
function getUsersMostActive($limit=5, $from, $style='long') {
    global $DB, $CFG, $USER,$HUB_SQL;

	$params = array();

    $as = new ActivitySet();

	$sql = $HUB_SQL->APILIB_USERS_BY_MOST_ACTIVE_SELECT;
	$sql .= $HUB_SQL->APILIB_USERS_BY_MOST_ACTIVE_SELECT_SELECT;
    $sql .= $HUB_SQL->APILIB_USERS_BY_MOST_ACTIVE_SELECT_NODE;
	if ($from > 0) {
		$params[count($params)] = $from;
		$sql .= $HUB_SQL->APILIB_USERS_BY_MOST_ACTIVE_MOD_DATE;
	}

    $sql .= $HUB_SQL->UNION;

	$sql .= $HUB_SQL->APILIB_USERS_BY_MOST_ACTIVE_SELECT_CONN;
	if ($from > 0) {
		$params[count($params)] = $from;
		$sql .= $HUB_SQL->APILIB_USERS_BY_MOST_ACTIVE_MOD_DATE;
	}

    $sql .= $HUB_SQL->UNION;

	$sql .= $HUB_SQL->APILIB_USERS_BY_MOST_ACTIVE_MODE_DATE_WHERE;
	if ($from > 0) {
		$params[count($params)] = $from;
		$sql .= $HUB_SQL->APILIB_USERS_BY_MOST_ACTIVE_MOD_DATE_VOTE;
	}

    $sql .= $HUB_SQL->UNION;

	$sql .= $HUB_SQL->APILIB_USERS_BY_MOST_ACTIVE_SELECT_FOLLOW;
	if ($from > 0) {
		$params[count($params)] = $from;
		$sql .= $HUB_SQL->APILIB_USERS_BY_MOST_ACTIVE_MOD_DATE;
	}

 	$sql .= $HUB_SQL->APILIB_USERS_BY_MOST_ACTIVE_END;
    $sql .= $HUB_SQL->APILIB_USERS_BY_MOST_ACTIVE_ORDER;

    // ADD LIMITING
    if ($limit > 0) {
	    $sql = $DB->addLimitingResults($sql, 0, $limit);
	}

    $us = new UserSet();
	return $us->loadActive($sql, $style);
}

/**
 * Get all the users the current user has permissions to see
 *
 * @param boolean $includegroups (optional - default: false)
 * @param integer $start (optional - default: 0)
 * @param integer $max (optional - default: 20)
 * @param string $orderby (optional, either 'date', 'name' or 'moddate' - default: 'date')
 * @param string $sort (optional, either 'ASC' or 'DESC' - default: 'DESC')
 * @param string $style (optional - default 'long') may be 'short' or 'long'  - how much of a user's details to load (long includes: tags and groups).
 * @param string $q the query term(s)
 * @return UserSet or Error
 */
function getUsersByGlobal($includegroups = false, $start = 0,$max = 20 ,$orderby = 'date',$sort ='DESC',$style='long',$q=''){
	global $CFG,$HUB_SQL;

	$params = array();
	$params[0] = $CFG->defaultUserID;

	$sql = $HUB_SQL->APILIB_USERS_BY_GLOBAL_SELECT;

	if ($includegroups == false) {
		$sql .= $HUB_SQL->APILIB_USERS_BY_GLOBAL_FILTER_GROUPS;
	}

	if ($q != "") {
		$querySQL = getSearchQueryString($params, $q, true, false);
     	if ($querySQL != "") {
    		$sql .= $HUB_SQL->AND;
	     	$sql .= $querySQL;
     	}
	}

    $us = new UserSet();
    return $us->load($sql,$params,$start,$max,$orderby,$sort,$style);
}

/**
 * Check that the session is active and valid for the user passed.
 * @param string $userid
 * @return User or Error
 */
function validateUserSession($userid){
    global $USER, $LNG;

	$validateSession = validateSession($userid);

	if(strcmp($validateSession,$LNG->CORE_SESSION_OK) != 0) {
		$ERROR = new Hub_Error;
		$ERROR->createValidateSessionError($validateSession);
		return $ERROR;
    }

    $user = $USER;

    return $user;
}

/**
 * Logs a user in.
 *
 * @param string $username
 * @param string $password
 * @return User or Error
 */
function login($username,$password){
	global $CFG;

    if($password == "" || $username == ""){
       $ERROR = new Hub_Error;
       $ERROR->createLoginFailedError();
       return $ERROR;
    }

    $user = userLogin($username,$password);
    if($user instanceof Hub_Error){
       	return $user;
    } else if ($user instanceof User) {
    	$user->setPHPSessID(session_id());
    	return $user;
	} else {
        $ERROR = new Hub_Error();
        return $ERROR->createLoginFailedError();
	}
}

///////////////////////////////////////////////////////////////////
// Follow functions
///////////////////////////////////////////////////////////////////

/**
 * Add a new following entry for the current user against the given itemid
 * @param string $itemid the id of the node or user to follow
 * @return Following or Error
 */
function addFollowing($itemid) {
    $f = new Following($itemid);
    return $f->add();
}

/**
 * Delete a following entry for the current user against the given itemid
 * @param string $itemid the id of the node or user to stop following
 * @return Following or Error
 */
function deleteFollowing($itemid) {
    $f = new Following($itemid);
    $f->load();
    return $f->delete();
}

///////////////////////////////////////////////////////////////////
// Evidence Hub functions
///////////////////////////////////////////////////////////////////
/**
 * Get a theme node by its name.
 *
 * @param string $nodename
 * @param string $style (optional - default 'long') may be 'short' or 'long'
 * @return Node or Error
 */
function getThemeNodeByName($name,$style='long'){
    global $DB, $CFG,$HUB_SQL;

	$n = new CNode();

	$params = array();
	$params[0] = $name;
	$params[1] = $CFG->ADMIN_USERID;

    $sql = $HUB_SQL->APILIB_THEMES_BY_NAME;
	$resArray = $DB->select($sql, $params);
	if ($resArray !== false) {
		$count = count($resArray);
		if ($count == 0) {
			 return database_error("Node not found","7002");
		} else {
			for ($i=0; $i<$count; $i++) {
				$array = $resArray[$i];
				$n->nodeid = $array['NodeID'];
				$n->load($style);
			}
		}
	} else {
		return database_error();
	}

    return $n;
}


/**
 * Connect the node with the given nodeid the to theme with the given name
 * @param nodeid the id of the node to connect.
 * @param themename the name of the theme to connect the node to.
 * @return Connection or Error
 */
function connectNodeToTheme($nodeid, $themename, $style='long') {
	global $CFG, $DB, $USER;

	$node = new CNode($nodeid);
	$node = $node->load();

	if (!$node instanceof Hub_Error) {
		$nr = getRoleByName($node->role->name);
		$noderole = $nr->roleid;

		$r = getRoleByName("Theme");
		$roleTheme = $r->roleid;

		$lt = getLinkTypeByLabel('has main theme');
		$linkid = $lt->linktypeid;

		$theme = getThemeNodeByName($themename, $style);
		$connection = addConnection($node->nodeid, $noderole, $linkid, $theme->nodeid, $roleTheme, "N");

		if ($connection && $connection->connid) {
			$tag = addTag($themename);
			$connection->addTag($tag->tagid);
		}

		return $connection;
	} else {
		return $node;
	}
}

/**
 * Connect the node with the given nodeid to the given comment
 * @param nodeid the id of the node to connect.
 * @nodetypename the node type name of the node type to make the comment
 * @param comment the comment to connecto to.
 * @param parentconnid the connection id of the top chat tree item this new comment belongs to.
 * (It has it's description updated to store the new child node id, and this will clock the modification date too,
 * so it sorts to the top in the chat tree).
 * @param parentid the node id of the item that this comment was made against - i.e. the focal item for the chat tree)
 * (it is stored in the description field of this new connection. It is used to be able to link to the parent item this comment belongs to).
 * @param String $style (optional - default 'long') may be 'short' or 'long'
 * @return Connection or Error
 */
function connectNodeToComment($nodeid, $nodetypename, $comment, $parentconnid='', $parentid='', $style='long') {
	global $DB,$CFG,$HUB_SQL;

	$node = new CNode($nodeid);
	$node = $node->load();

	$nr = getRoleByName($node->role->name);
	$noderole = $nr->roleid;

	$r = getRoleByName($nodetypename);
	$commentrole = $r->roleid;

	$lt = getLinkTypeByLabel($CFG->LINK_COMMENT_NODE);
	$linkid = $lt->linktypeid;

	$commentnode = new CNode();
	$commentnode = $commentnode->addComment($comment, "", 'N', $commentrole);

	if ($CFG->autoFollowingOn) {
		addFollowing($commentnode->nodeid);
	}

	$r = getRoleByName('Comment');
	$commentrole = $r->roleid;

	$connection = addConnection($commentnode->nodeid, $commentrole, $linkid, $node->nodeid, $noderole, "N", $parentid);

	// if we know the parent connection,
	// update it's description with this new child node id
	// The parent connection modification date will be updated too
	// so it sorts to the top and it will know the id of the new child.
	if ($parentconnid != "") {
		// need to update this date even if the owner of the chat thread is someone else thatn the current user.
		// so overriding usual checks here.

		$conn = new Connection($parentconnid);
		$conn = $conn->load();
		if (!$conn instanceof Hub_Error) {
			$description = $conn->description;
			$description = $commentnode->nodeid.":".$description;
			$dt = time();

			$params = array();
			$params[0] = $dt;
			$params[1] = $description;
			$params[2] = $parentconnid;

	        $sql = $HUB_SQL->APILIB_NODE_TO_COMMENT;
			$res = $DB->insert($sql, $params);
	        if (!$res) {
	            return database_error();
	        }
		}
	}

	return $connection;
}

/**
 * Delete the Comment node with the given nodeid
 * and update the parent chat tree connection by removing the
 * @param nodeid the id of the node to delete.
 * @param parentconnid the connection id of the top chat tree item this comment belonged to.
 * (It has it's description updated to remove the child node id, without clocking the mod date.
 * @return Connection or Error
 */
function deleteComment($nodeid, $parentconnid='') {
	global $DB,$CFG,$HUB_SQL;

	$reply = deleteNode($nodeid);

	// if we know the parent connection,
	// update it's description with this new child node id
	// The parent connection modification date will be updated too
	// so it sorts to the top and it will know the id of the new child.
	if ($parentconnid != "") {
		// need to update this date even if the owner of the chat thread is someone else thatn the current user.
		// so overriding usual checks here.

		$conn = new Connection($parentconnid);
		$conn = $conn->load();
		if (!$conn instanceof Hub_Error) {
			$description = $conn->description;
			$pos = strpos($description, $nodeid);
			if ($pos === false) {
			    // should never happen if all goes well
			} else {
				$description = str_replace($nodeid.":", "", $description);

				$params = array();
				$params[0] = $description;
				$params[1] = $parentconnid;

				$sql = $HUB_SQL->APILIB_COMMENT_DELETE;
				$res = $DB->insert($sql, $params);
				if (!$res) {
					return database_error();
				}
			}
		}
	}

	return $reply;
}


/**
 * Get the nodes of the given type connected to node for the given theme with the linktype label 'has main theme'
 *
 * @param string $theme the name of the theme to find connections for
 * @param integer $start (optional - default: 0)
 * @param integer $max (optional - default: 20)
 * @param string $orderby (optional, either 'date', 'name' or 'moddate' - default: 'date')
 * @param string $sort (optional, either 'ASC' or 'DESC' - default: 'DESC')
 * @param String $style (optional - default 'long') may be 'short' or 'long'
 * @return ConnectionSet or Error
 */
function getTypeConnectionsByTheme($theme, $type, $start = 0,$max = 20 ,$orderby = 'date',$sort ='ASC',$style='long'){
    global $USER,$CFG,$DB,$HUB_SQL;

	$currentuser = '';
	if (isset($USER->userid)) {
		$currentuser = $USER->userid;
	}

	$params = array();
	$params[0] = $theme;
	$sql = $HUB_SQL->APILIB_CONNS_BY_THEME_NODES_SELECT;
    $nodeids = "";
    $nodeArray = array();

	$resArray = $DB->select($sql, $params);
    if ($resArray !== false) {
    	$count = count($resArray);
    	for ($i=0; $i<$count;$i++) {
        	$array = $resArray[$i];
            $id = $array['NodeID'];
            $nodeArray[count($nodeArray)] = $id;
            if ($nodeids == "") {
                $nodeids .= "?";
            } else {
                $nodeids .= ",?";
            }
        }
    } else {
    	return database_error();
    }

	$params = array();

    $sql = $HUB_SQL->APILIB_CONNS_BY_THEME_SELECT.$HUB_SQL->AND;

	// FILTER BY NODE TYPE
	$nodetypeArray = array();
	$innersql = getSQLForNodeTypeIDsForLabels($nodetypeArray,$type);

	$sql .= $HUB_SQL->APILIB_CONNS_BY_THEME_NODETYPE_FILTER_PART1;
	$params = array_merge($params, $nodetypeArray);
	$sql .= $innersql;

	$sql .= $HUB_SQL->APILIB_CONNS_BY_THEME_NODETYPE_FILTER_PART2;
	$sql .= $nodeids;
	$params = array_merge($params, $nodeArray);

	$sql .= $HUB_SQL->APILIB_CONNS_BY_THEME_NODETYPE_FILTER_PART3;
	$params = array_merge($params, $nodetypeArray);
	$sql .= $innersql;

	$sql .= $HUB_SQL->APILIB_CONNS_BY_THEME_NODETYPE_FILTER_PART4;
	$sql .= $nodeids;
	$params = array_merge($params, $nodeArray);

	$sql .= $HUB_SQL->APILIB_CONNS_BY_THEME_NODETYPE_FILTER_PART5;

	$sql .= $HUB_SQL->AND;

    $params[count($params)] = 'N';
	$params[count($params)] = $currentuser;
	$params[count($params)] = $currentuser;
	$params[count($params)] = 'N';
	$params[count($params)] = $currentuser;
	$params[count($params)] = $currentuser;
	$params[count($params)] = 'N';
	$params[count($params)] = $currentuser;
	$params[count($params)] = $currentuser;
	$sql .= $HUB_SQL->APILIB_CONNECTIONS_BY_GLOBAL_PERMISSIONS;

     //echo $sql;

     $cs = new ConnectionSet();
     return $cs->load($sql,$params,$start,$max,$orderby,$sort,$style);
}

/**
 * Get the connection to theme nodes for the node with the given nodeid with the linktype label 'has main theme'
 *
 * @param string $nodeid
 * @param integer $start (optional - default: 0)
 * @param integer $max (optional - default: 20)
 * @param string $orderby (optional, either 'date', 'name' or 'moddate' - default: 'date')
 * @param string $sort (optional, either 'ASC' or 'DESC' - default: 'DESC')
 * @param String $style (optional - default 'long') may be 'short' or 'long'
 * @param string $scope (optional, either 'my' or 'all' - default: 'all')
 * @return ConnectionSet or Error
 */
function getThemeConnectionsByNode($nodeid,$start = 0,$max = 20 ,$orderby = 'date',$sort ='ASC', $style='long', $scope='all'){
    global $USER,$CFG,$HUB_SQL;

	$currentuser = '';
	if (isset($USER->userid)) {
		$currentuser = $USER->userid;
	}

	$params = array();

 	$cs = new ConnectionSet();

    $nodeids =  getAggregatedNodeIDs($nodeid);
	if ($nodeids != "") {

		$sql = $HUB_SQL->APILIB_THEME_CONNECTIONS_BY_NODE_SELECT;
		$sql .= $HUB_SQL->AND;

		// FILTER BY NODE TYPE
		$nodetypeArray = array(); // filled in the next function call.
		$innersql = getSQLForNodeTypeIDsForLabels($nodetypeArray,'Theme');

		$sql .= $HUB_SQL->APILIB_CONNS_BY_THEME_NODETYPE_FILTER_PART1;
		$params = array_merge($params, $nodetypeArray);
		$sql .= $innersql;

		$sql .= $HUB_SQL->APILIB_CONNS_BY_THEME_NODETYPE_FILTER_PART2;
		$sql .= $nodeids;

		$sql .= $HUB_SQL->APILIB_CONNS_BY_THEME_NODETYPE_FILTER_PART3;
		$params = array_merge($params, $nodetypeArray);
		$sql .= $innersql;

		$sql .= $HUB_SQL->APILIB_CONNS_BY_THEME_NODETYPE_FILTER_PART4;
		$sql .= $nodeids;

		$sql .= $HUB_SQL->APILIB_CONNS_BY_THEME_NODETYPE_FILTER_PART5;

		$sql .= $HUB_SQL->AND;

		if ($scope == 'my') {
		    $params[count($params)] = $currentuser;
			$sql .= $HUB_SQL->FILTER_USER;
		} else {
		    $params[count($params)] = 'N';
			$params[count($params)] = $currentuser;
			$params[count($params)] = $currentuser;
			$params[count($params)] = 'N';
			$params[count($params)] = $currentuser;
			$params[count($params)] = $currentuser;
			$params[count($params)] = 'N';
			$params[count($params)] = $currentuser;
			$params[count($params)] = $currentuser;
			$sql .= $HUB_SQL->APILIB_CONNECTIONS_BY_GLOBAL_PERMISSIONS;
		}

	    $cs->load($sql,$params,$start,$max,$orderby,$sort,$style);
	}

	return $cs;
}

/**
 * Get the theme nodes and their use counts for the node type with the name passed as type.
 * @param String $filternodetypes the node types to get Themes connection count for
 * @param limit the number of results to return (ordered by use count DESC)
 * @param String $style (optional - default 'long') may be 'short' or 'long'
 *
 * @return a 'NodeSet' with variable where each node has an additional property added 'usecount'.
 */
function getMostPopularThemesByType($filternodetypes, $limit, $style='short') {
	global $CFG, $DB, $USER,$HUB_SQL;

	$params = array();
	$params[0] = $CFG->ADMIN_USERID;

	$sql = $HUB_SQL->APILIB_THEMES_BY_TYPE_SELECT_PART1;

	// FILTER FROM NODE BY NODETYPES
	$nodetypeidsSql = getSQLForNodeTypeIDsForLabels($params,$filternodetypes);
	$sql .= $nodetypeidsSql;

	$sql .= $HUB_SQL->APILIB_THEMES_BY_TYPE_SELECT_PART2;

	// FILTER TO NODE BY THEMES
	$list = "";
	$count = count($CFG->THEMES);
	for ($i=0; $i<$count; $i++) {
		$params[count($params)] = $CFG->THEMES[$i];
		if ($i == 0) {
			$list .= "?";
		} else {
			$list .= ",?";
		}
	}
	$sql .= $list;
	$sql .= $HUB_SQL->APILIB_THEMES_BY_TYPE_SELECT_PART3;

    $sql .= $HUB_SQL->APILIB_THEMES_BY_TYPE_GROUP_ORDER;

    // ADD LIMITING
    if ($limit > 0) {
	    $sql = $DB->addLimitingResults($sql, 0, $limit);
	}

	//echo $sql;

	$ns = new NodeSet();
	return $ns->loadUseCount($sql,$params,$style);
}

/**
 * Get the AuditNode coun t+ the Audit Triple count + the Voting count total
 * for entries between the given dates.
 * return a TreeData object with one field called 'count' holding the total count.
 */
function getTreeData($fromdate="", $todate="") {
	global $DB,$HUB_SQL;

	$params = array();

	$fdate = "";
	$tdate = "";
	try {
		if(is_numeric($fromdate)){
			$fdate = $fromdate;
		} else if ($fromdate != "") {
			$fdate = strtotime($fromdate);
		}

		if(is_numeric($todate)){
			$tdate = $todate;
		} else if ($todate != "") {
			$tdate = strtotime($todate);
		}
	} catch (Exception $e) {
		//failed
	}

	$sql .= $HUB_SQL->APILIB_TREE_DATA_VOTING;
	if ($fdate != "" && $tdate != "") {
		$params[count($params)] = $fdate;
		$params[count($params)] = $tdate;
		$sql .= $HUB_SQL->APILIB_TREE_DATA_WHERE_FROM_TO;
	} else if ($fdate != "") {
		$params[count($params)] = $fdate;
		$sql .= $HUB_SQL->APILIB_TREE_DATA_WHERE_FROM;
	} else if ($tdate != "") {
		$params[count($params)] = $fdate;
		$sql .= $HUB_SQL->APILIB_TREE_DATA_WHERE_TO;
	}

    $sql .= $HUB_SQL->UNION;

	$sql .= $HUB_SQL->APILIB_TREE_DATA_AUDIT_NODE;
	if ($fdate != "" && $tdate != "") {
		$params[count($params)] = $fdate;
		$params[count($params)] = $tdate;
		$sql .= $HUB_SQL->APILIB_TREE_DATA_WHERE_FROM_TO;
	} else if ($fdate != "") {
		$params[count($params)] = $fdate;
		$sql .= $HUB_SQL->APILIB_TREE_DATA_WHERE_FROM;
	} else if ($tdate != "") {
		$params[count($params)] = $fdate;
		$sql .= $HUB_SQL->APILIB_TREE_DATA_WHERE_TO;
	}

    $sql .= $HUB_SQL->UNION;

	$sql .= $HUB_SQL->APILIB_TREE_DATA_AUDIT_TRIPLE;
	if ($fdate != "" && $tdate != "") {
		$params[count($params)] = $fdate;
		$params[count($params)] = $tdate;
		$sql .= $HUB_SQL->APILIB_TREE_DATA_WHERE_FROM_TO;
	} else if ($fdate != "") {
		$params[count($params)] = $fdate;
		$sql .= $HUB_SQL->APILIB_TREE_DATA_WHERE_FROM;
	} else if ($tdate != "") {
		$params[count($params)] = $fdate;
		$sql .= $HUB_SQL->APILIB_TREE_DATA_WHERE_TO;
	}

	$sql .= $HUB_SQL->APILIB_TREE_DATA_AUDIT_END;

	$answer = 0;
	$resArray = $DB->select($sql, $params);
    if ($resArray !== false) {
    	$count = count($resArray);
    	for ($i=0; $i<$count; $i++) {
        	$array = $resArray[$i];
        	$answer = $array['count'];
        }
    }

	class TreeData {
		public $count = "";
	}
	$treedata = new TreeData();
	$treedata->count = $answer;

	return $treedata;
}


///////////////////////////////////////////////////////////////////
// functions for groups
///////////////////////////////////////////////////////////////////

/**
 * Get the nodes for given group
 *
 * @param string $groupid
 * @param integer $start (optional - default: 0)
 * @param integer $max (optional - default: 20)
 * @param string $orderby (optional, either 'date', 'nodeid', 'name', 'connectedness' or 'moddate' - default: 'date')
 * @param string $sort (optional, either 'ASC' or 'DESC' - default: 'DESC')
 * @param string $filterusers (optional, a list of user ids to filter by)
 * @param string $filternodetypes (optional, a list of node type names to filter by)
 * @param string $filterthemes (optional, a list of theme names to filter by)
 * @param String $style (optional - default 'long') may be 'short' or 'long'  - how much of a nodes details to load (long includes: description, tags, groups and urls).
 * @param string $q the query term(s)
 * @return NodeSet or Error
 * @param string $connectionfilter filter by connections. Defaults to empty string which means disregard connection count. Possible values; '','connected','unconnected'.
 */
function getNodesByGroup($groupid,$start = 0,$max = 20 ,$orderby = 'date',$sort ='DESC', $filterusers='', $filternodetypes='', $filterthemes, $style='long', $q="", $connectionfilter=''){
    global $CFG,$USER,$HUB_SQL;

	$currentuser = '';
	if (isset($USER->userid)) {
		$currentuser = $USER->userid;
	}

	$params = array();

    $sql = $HUB_SQL->APILIB_NODES_BY_GROUP_SELECT;

	// FILTER NODE TYPES
    if ($filternodetypes != "") {

		// This comes first in HUB_SQL->APILIB_NODES_BY_GROUP_NODETYPE
		// Before node type list.
		$params[count($params)] = $groupid;

        $pieces = explode(",", $filternodetypes);
        $sqlList = "";
		$loopCount = 0;
        foreach ($pieces as $value) {
        	$params[count($params)] = $value;
        	if ($loopCount == 0) {
        		$sqlList .= "?";
        	} else {
        		$sqlList .= ",?";
        	}
        	$loopCount++;
		}

        $sql .= $HUB_SQL->APILIB_NODES_BY_GROUP_NODETYPE.$HUB_SQL->OPENING_BRACKET;
        $sql .= $sqlList;
	    $sql .= $HUB_SQL->CLOSING_BRACKET.$HUB_SQL->AND;
    } else {
		$params[count($params)] = $groupid;
		$HUB_SQL->APILIB_NODES_BY_GROUP_NODETYPE_NONE.$HUB_SQL->AND;
    }

    if ($filterusers != "") {
        $pieces = explode(",", $filterusers);
        $loopCount = 0;
        $searchUsers = "";
        foreach ($pieces as $value) {
        	$params[count($params)] = $value;
            if ($loopCount == 0) {
            	$searchUsers .= "?";
            } else {
            	$searchUsers .= ",?";
            }
            $loopCount++;
        }

        $sql .=  $HUB_SQL->FILTER_USERS.$HUB_SQL->OPENING_BRACKET;
        $sql .= $searchUsers;
	    $sql .= $HUB_SQL->CLOSING_BRACKET.$HUB_SQL->AND;
    }

	// SEARCH
	if ($q != "") {
		$querySQL = getSearchQueryString($params,$q, true, true);
		$sql .= $querySQL;
		if ($querySQL != "") {
			$sql .= $HUB_SQL->AND;
		}
	}

	// PERMISSIONS
	$params[count($params)] = 'N';
	$params[count($params)] = $currentuser;
	$params[count($params)] = $currentuser;
	$sql .=  $HUB_SQL->APILIB_NODES_PERMISSIONS_ALL;

	// FILTER THEMES
	if ($filterthemes != "") {
		$params[count($params)] = $filterthemes;
		$sql .= $HUB_SQL->AND.$HUB_SQL->APILIB_FILTER_THEMES;
	}

	// ORDER BY VOTE
	if ($orderby == 'vote') {
		$sql = $HUB_SQL->APILIB_NODE_ORDERBY_VOTE_PART1.$sql.$HUB_SQL->APILIB_NODE_ORDERBY_VOTE_PART2;
	}

	if ($connectionfilter == 'unconnected') {
		$sql .= $HUB_SQL->APILIB_HAVING_UNCONNECTED;
	} else if ($connectionfilter == 'connected') {
		$sql .= $HUB_SQL->APILIB_HAVING_CONNECTED;
	}

    $ns = new NodeSet();
    return $ns->load($sql,$params,$start,$max,$orderby,$sort, $style);
}

/**
 * Get a group
 *
 * @param string $groupid
 * @return Group or Error
 */
function getGroup($groupid){

    $g = new Group($groupid);
	$g->load();
    $g->loadmembers();
    return $g;
}

/**
 * Add a group to a node. Requires login, user must be the node owner and member of the group.
 *
 * @param string $nodeid
 * @param string $groupid
 * @return Node or Error
 */
function addGroupToNode($nodeid,$groupid){
    $n = new CNode($nodeid);
    $n->load();
    return $n->addGroup($groupid);
}

/**
 * Add a group to a set of nodes. Requires login, user must be the node owner and member of the group.
 *
 * @param string $nodeids
 * @param string $groupid
 * @return Result or Error
 */
function addGroupToNodes($nodeids,$groupid){
    $nodesArr = explode(",",$nodeids);
    foreach ($nodesArr as $nodeid){
        $n = new CNode($nodeid);
        $n->load();
        $n->addGroup($groupid);
    }
    return new Result("added","true");
}

/**
 * Remove a group from a node. Requires login, user must be the node owner and member of the group.
 *
 * @param string $nodeid
 * @param string $groupid
 * @return Node or Error
 */
function removeGroupFromNode($nodeid,$groupid){
    $n = new CNode($nodeid);
    $n->load();
    return $n->removeGroup($groupid);
}

/**
 * Remove a group from a set of nodes. Requires login, user must be the node owner and member of the group.
 *
 * @param string $nodeids
 * @param string $groupid
 * @return Result or Error
 */
function removeGroupFromNodes($nodeids,$groupid){
    $nodesArr = explode(",",$nodeids);
    foreach ($nodesArr as $nodeid){
        $n = new CNode($nodeid);
        $n->load();
        $n->removeGroup($groupid);
    }
    return new Result("added","true");
}

/**
 * Remove all groups from a node. Requires login, user must be the node owner.
 *
 * @param string $nodeid
 * @return Node or Error
 */
function removeAllGroupsFromNode($nodeid){
    $n = new CNode($nodeid);
    $n->load();
    return $n->removeAllGroups();
}

/**
 * Make all the users nodes and connections in a group private or public.
 * Requires login, user must be member of the group, and this will only update the nodes/connections
 * that the user is the owner of.
 *
 * @param string $groupid
 * @param string $private (must be either 'Y' or 'N')
 * @return Result or Error
 */
function setGroupPrivacy($groupid,$private){
    global $DB,$CFG,$USER,$HUB_SQL;

	$currentuser = '';
	if (isset($USER->userid)) {
		$currentuser = $USER->userid;
	}

	$params = array();
	$params[0] = $groupid;
	$params[1] = $currentuser;

    // set the nodes
    $sql = $HUB_SQL->APILIB_NODE_GROUP_PRIVACY_SELECT;
	$resArray = $DB->select($sql, $params);
	if ($resArray !== false) {
		$count = count($resArray);
		for ($i=0; $i<$count; $i++) {
			$array = $resArray[$i];
			$n = new CNode($array['NodeID']);
			$n->load();
			$n->setPrivacy($private);
		}
	}

    // set the connections
    $sql = APILIB_CONNECTION_GROUP_PRIVACY_SELECT;
	$resArray = $DB->select($sql, $params);
	if ($resArray !== false) {
		$count = count($resArray);
		for ($i=0; $i<$count; $i++) {
			$array = $resArray[$i];
			$c = new Connection($array['TripleID']);
			$c->load();
			$c->setPrivacy($private);
		}
	}

    return new Result("privacy updated","true");
}

/**
 * Add a group to a Connection. Requires login, user must be the connection owner and member of the group.
 *
 * @param string $connid
 * @param string $groupid
 * @return Connection or Error
 */
function addGroupToConnection($connid,$groupid){
    $c = new Connection($connid);
    $c->load();
    return $c->addGroup($groupid);
}

/**
 * Add a group to a set of connections. Requires login, user must be the connection owner and member of the group.
 *
 * @param string $connids
 * @param string $groupid
 * @return Result or Error
 */
function addGroupToConnections($connids,$groupid){
    $connsArr = explode(",",$connids);
    foreach ($connsArr as $connid){
        $c = new Connection($connid);
        $c->load();
        $c->addGroup($groupid);
    }
    return new Result("added","true");
}
/**
 * Remove a group from a Connection. Requires login, user must be the connection owner and member of the group.
 *
 * @param string $connid
 * @param string $groupid
 * @return Result or Error
 */
function removeGroupFromConnection($connid,$groupid){
    $c = new Connection($connid);
    $c->load();
    return $c->removeGroup($groupid);
}

/**
 * Remove a group from a set of Connections. Requires login, user must be the connections owner and member of the group.
 *
 * @param string $connids
 * @param string $groupid
 * @return Result or Error
 */
function removeGroupFromConnections($connids,$groupid){
    $connsArr = explode(",",$connids);
    foreach ($connsArr as $connid){
        $c = new Connection($connid);
   		$c->load();
        $c->removeGroup($groupid);
    }
    return new Result("removed","true");
}

/**
 * Remove all groups from a Connection. Requires login, user must be the connection owner.
 *
 * @param string $connid
 * @return Result or Error
 */
function removeAllGroupsFromConnection($connid){
    $c = new Connection($connid);
    $c->load();
    return $c->removeAllGroups();
}

/**
 * Get all groups. Requires login.
 *
 * @return GroupSet or Error
 */
function getAllGroups($limit){
    global $USER,$HUB_SQL,$DB;

 	$params = array();

    $sql = $HUB_SQL->APILIB_GET_ALL_GROUPS_SELECT;
    $sql = $DB->addLimitingResults($sql, 0, $limit);

    $gs = new GroupSet();
    return $gs->load($sql,$params);
}

/**
 * Get all groups for current user. Requires login.
 *
 * @return GroupSet or Error
 */
function getMyGroups(){
    global $USER,$HUB_SQL;

	$currentuser = '';
	if (isset($USER->userid)) {
		$currentuser = $USER->userid;
	}

	$params = array();
	$params[0] = $currentuser;

    $sql = $HUB_SQL->APILIB_GET_MY_GROUPS_SELECT;

    $gs = new GroupSet();
    return $gs->load($sql,$params);
}

/**
 * Get groups that current user is an admin for. Requires login.
 *
 * @return GroupSet or Error
 */
function getMyAdminGroups(){
    global $USER,$HUB_SQL;

	$currentuser = '';
	if (isset($USER->userid)) {
		$currentuser = $USER->userid;
	}

	$params = array();
	$params[0] = $currentuser;

    $sql = $HUB_SQL->APILIB_GET_MY_ADMIN_GROUPS_SELECT;

    $gs = new GroupSet();
    return $gs->load($sql,$params);
}

/**
 * Add a new group. Requires login.
 *
 * @param string $groupname
 * @return Group or Error
 */
function addGroup($groupname){
    $g = new Group();
    $group = $g->add($groupname);
    return $group;
}

/**
 * Delete a group. Requires login and user must be an admin for the group.
 *
 * @param string $groupid
 * @return Result or Error
 */
function deleteGroup($groupid){
    $g = new Group($groupid);
    $result = $g->delete();
    return $result;
}

/**
 * Add a user to a group. Requires login and user must be an admin for the group.
 *
 * @param string $groupid
 * @param string $userid
 * @return Group or Error
 */
function addGroupMember($groupid,$userid){
    $g = new Group($groupid);
    $g->load();
    $group = $g->addmember($userid);
    return $group;
}

/**
 * Make a user an admin of the group. Requires login and user must be an admin for the group.
 *
 * @param string $groupid
 * @param string $userid
 * @return Group or Error
 */
function makeGroupAdmin($groupid,$userid){
    $g = new Group($groupid);
    $g->load();
    $group = $g->makeadmin($userid);
    return $group;
}


/**
 * Remove a user as admin of the group. Requires login and user must be an admin for the group.
 *
 * @param string $groupid
 * @param string $userid
 * @return Group or Error
 */
function removeGroupAdmin($groupid,$userid){
    $g = new Group($groupid);
    $g->load();
    $group = $g->removeadmin($userid);
    return $group;
}

/**
 * Remove a user from a group. Requires login and user must be an admin for the group.
 *
 * @param string $groupid
 * @param string $userid
 * @return Group or Error
 */
function removeGroupMember($groupid,$userid){
    $g = new Group($groupid);
    $g->load();
    $group = $g->removemember($userid);
    return $group;
}

/**
 * Is the given user in the given group.
 *
 * @param string $groupid
 * @param string $userid
 * @return true if member else false
 */
function isGroupMember($groupid,$userid) {
    $g = new Group($groupid);
    $g->load();

    return $g->ismember($userid);
}

/**
 * Get all the groups the current user has permissions to see
 *
 * @param integer $start (optional - default: 0)
 * @param integer $max (optional - default: 20)
 * @param string $orderby (optional, either 'date', 'name' or 'moddate' - default: 'date')
 * @param string $sort (optional, either 'ASC' or 'DESC' - default: 'DESC')
 * @param string $style (optional - default 'long') may be 'short' or 'long'  - how much of a user's details to load (long includes: tags and groups).
 * @param string $q the query term(s)
 * @return GroupSet or Error
 */
function getGroupsByGlobal($start = 0,$max = 20 ,$orderby = 'date',$sort ='DESC',$style='long',$q=''){
	global $CFG,$HUB_SQL;

	$params = array();
	$params[0] = $CFG->USER_STATUS_ACTIVE;
	$params[1] = $CFG->USER_STATUS_REPORTED;
	$params[2] = $CFG->defaultUserID;

	$sql = $HUB_SQL->APILIB_GROUPS_BY_GLOBAL_PART1;

	if ($q != "") {
    	$querySQL = getSearchQueryString($params,$q, true, false);
		$sql .= $HUB_SQL->AND.$querySQL;
	}

    $gs = new GroupSet();
    return $gs->loadFromUsers($sql,$params,$start,$max,$orderby,$sort,$style);
}

/** NEW FOR DEBATE HUB **/

/**
 * Get all the connections for the given node types and link types
 *
 * @param string $groupid the id of the group to get social connections for
 * @param string $scope (either 'all' or 'my')
 * @param integer $start (optional - default: 0)
 * @param integer $max (optional - default: 20)
 * @param string $orderby (optional, either 'date', 'name' or 'moddate' - default: 'date')
 * @param string $sort (optional, either 'ASC' or 'DESC' - default: 'DESC')
 * @param string $linklabels (optional, comma separated strings of the connection labels to filter the results by)
 * @param string $filternodetypes (optional, a list of node type names to filter by)
 * @param String $style (optional - default 'long') may be 'short' or 'long'
 * @return ConnectionSet or Error
 */
function getConnectionsByGroup($groupid, $scope,$start = 0,$max = 20 ,$orderby = 'date',$sort ='ASC', $linklabels = '', $filternodetypes='', $style='long'){
    global $DB, $USER,$CFG,$HUB_SQL;

	$params = array();
	$params[0] = $groupid;

	$currentuser = '';
	if (isset($USER->userid)) {
		$currentuser = $USER->userid;
	}

	$sql = $HUB_SQL->APILIB_CONNECTIONS_BY_GROUP_SELECT;
	$sql .= $HUB_SQL->APILIB_CONNECTIONS_BY_GROUP_FILTER;

	// FILTER BY NODE TYPES - AND
    if ($filternodetypes != "") {
		$sql .= $HUB_SQL->AND;

		$nodetypeArray = array();
		$innersql = getSQLForNodeTypeIDsForLabels($nodetypeArray,$filternodetypes);

		$params = array_merge($params, $nodetypeArray);
		$sql .= $HUB_SQL->APILIB_CONNECTIONS_BY_GLOBAL_NODETYPE_FILTER_PART1;
		$sql .= $innersql;

		$params = array_merge($params, $nodetypeArray);
		$sql .= $HUB_SQL->APILIB_CONNECTIONS_BY_GLOBAL_NODETYPE_FILTER_PART2;
		$sql .= $innersql;

		$sql .= $HUB_SQL->CLOSING_BRACKET.$HUB_SQL->CLOSING_BRACKET;
    }

	// FILTER BY LINK TYPES
	if ($linklabels != "") {
		$innersql = getSQLForLinkTypeIDsForLabels($params,$linklabels);
		$sql .= $HUB_SQL->AND;
		$sql .= $HUB_SQL->APILIB_CONNECTIONS_BY_GLOBAL_LINKTYPE_FILTER;
		$sql .= $HUB_SQL->OPENING_BRACKET;
		$sql .= $innersql;
		$sql .= $HUB_SQL->CLOSING_BRACKET;
	}

	// PERMISSIONS
    if($scope == "my"){
		$params[count($params)] = $currentuser;
		$sql .= $HUB_SQL->AND;
        $sql .= $HUB_SQL->FILTER_USER;
    }

	$sql .= $HUB_SQL->AND;
    $params[count($params)] = 'N';
	$params[count($params)] = $currentuser;
	$params[count($params)] = $currentuser;
	$params[count($params)] = 'N';
	$params[count($params)] = $currentuser;
	$params[count($params)] = $currentuser;
	$params[count($params)] = 'N';
	$params[count($params)] = $currentuser;
	$params[count($params)] = $currentuser;
	$sql .= $HUB_SQL->APILIB_CONNECTIONS_BY_GLOBAL_PERMISSIONS;

    $cs = new ConnectionSet();

	//error_log(print_r($sql, true));

    return $cs->load($sql,$params,$start,$max,$orderby,$sort,$style);
}

function getAllChatConnections($focalnode, $nodetype) {
	global $CFG;

	$nodetypes = 'Comment,'.$nodetype;
	$linklabels = $CFG->LINK_COMMENT_NODE;

	return getConnectionsByPath($focalnode, $linklabels, "", 'all', '', 7, 'incoming', 'false', $nodetypes, 'long');
}

/*** FOR DEBATES ***/

/**
 * Add a node. Requires login
 *
 * @param string $name
 * @param string $desc
 * @param string $nodetypename, the name of the nodetype this node is.
 * @param string $focalnodeid, the id of the node to connect this new node to.
 * @param string $direction optional, whether the new node is a 'from' or 'to' in the connection. The focalnode then becomes the other end. Defaults to 'from';
 * @param string $private optional, can be Y or N, defaults to users preferred setting
 * @param string $imageurlid optional, the urlid of the url for the image that is being used as this node's icon
 * @param string $imagethumbnail optional, the local server path to the thumbnail of the image used for this node
 * @param string $resourcetypes optional, an array of resource types to add to this new node
 * @param string $resourceurls optional, an array of resource urls to add to this new node
 * @param string $resourcetitles optional, an array of resource title to add to this new node
 * @param string $resourcedois optional, an array of publication dois to add to this new node
 *
 * @return Node or Error
 */
function addNodeAndConnect($name,$desc,$nodetypename,$focalnodeid,$linktypename,$direction="from",$private="N",$imageurlid="",$imagethumbnail="",$resourcetypes="",$resourceurls="",$resourcetitles="",$resourcedois=""){
    global $USER, $CFG;

    if($private == ""){
        $private = $USER->privatedata;
    }
	$conndesc = "";

	$r = getRoleByName($nodetypename);
	if (!$r instanceof Hub_Error) {
		$nodetypeid = $r->roleid;

		$n = new CNode();
		$node = $n->add($name,$desc,$private,$nodetypeid,$imageurlid,$imagethumbnail);

		if (!$node instanceof Hub_Error) {

			// create and connected any resources as new resource nodes if the current node is not itself a resource node
			// else just create the url object and add to the node directly.

			if ($resourceurls != "" && !in_array($nodetypename, $CFG->RESOURCE_TYPES)) {

				$rlt = getLinkTypeByLabel($CFG->LINK_RESOURCE_NODE);
				if ($rlt instanceof Hub_Error) {
					return $rlt;
				}
				$resourcelinkType = $rlt->linktypeid;

				$countresources = 0;
				if (is_countable($resourceurls)) {
					$countresources = count($resourceurls);
				}

				for ($i=0; $i<$countresources; $i++) {
					$url = $resourceurls[$i];
					$url = trim($url);
					if ($url != "") {

						$title = $url;
						if (isset($resourcetitles[$i]) && $resourcetitles[$i] != "") {
							$title = $resourcetitles[$i];
						}
						$thisr = getRoleByName($resourcetypes[$i]);
						if ($thisr instanceof Hub_Error) {
							return $thisr;
						}
						$thisresourcenodetypeid = $thisr->roleid;

						$resourcenode = new CNode();

						// the description is used as the title in EVHub and the title as the url - but from the debate page we only have a url form field, so the title is also the description.
						// add($name,$desc="",$private,$nodetypeid="",$imageurlid="",$imagethumbnail=""){
						$resourcenode = $resourcenode->add($url,$title,$private,$thisresourcenodetypeid);
						if ($resourcenode instanceof Hub_Error) {
							return $resourcenode;
						}

						$urlobj = new URL();
						$doi = "";
						if (isset($resourcedois[$i]) && $resourcedois[$i] != null)  {
							$doi = $resourcedois[$i];
						}

						//    function add($url, $title, $desc, $private='Y', $clip="", $clippath="", $cliphtml = "", $createdfrom="", $identifier=""){
						$urlobj->add($url, $title, "", $private, "", "", "", "", $doi);
						if (!$urlobj instanceof Hub_Error) {
							$resourcenode->addURL($urlobj->urlid, "");
						}

						$connection = addConnection($resourcenode->nodeid, $thisresourcenodetypeid, $resourcelinkType, $node->nodeid, $nodetypeid, $private, "");

						if ($connection instanceof Hub_Error) {
							return $connection;
						}
					}
				}
			} else if ($resourceurls != "" && in_array($nodetypename, $CFG->RESOURCE_TYPES)) {

				$countresources = 0;
				if (is_countable($resourceurls)) {
					$countresources = count($resourceurls);
				}

				for ($i=0; $i<$countresources; $i++) {
					$url = $resourceurls[$i];
					$url = trim($url);

					if ($url != "") {
						$title = $url;
						if (isset($resourcetitles[$i]) && $resourcetitles[$i] != "") {
							$title = $resourcetitles[$i];
						}

						$urlobj = new URL();

						$doi = "";
						if (isset($resourcedois[$i]) && $resourcedois[$i] != null)  {
							$doi = $resourcedois[$i];
						}

						$urlobj->add($url, $title, "", $private, "", "", "", "", $doi);

						if (!$urlobj instanceof Hub_Error) {
							$node->addURL($urlobj->urlid, "");
						}
					}
				}
			}

			// add themes of focal node to new node
			$cs = getThemeConnectionsByNode($focalnodeid, 0, -1);

			$themesarray = array();
			for($i=0; $i< $cs->count; $i++){
				$c = $cs->connections[$i];
				$fN = $c->from;
				$tN = $c->to;

				$themenode = null;
				if ($fN->nodeid == $focalnodeid) {
					$themenode = $tN;
				} else {
					$themenode = $fN;
				}
				array_push($themesarray, $themenode->name);
			}

			foreach($themesarray as $themename){
				if (isset($themename) && $themename != "") {
					connectNodeToTheme($node->nodeid, $themename);
				}
			}

			// Connect to focal node
			$focalnode = new CNode($focalnodeid);
			$focalnode = $focalnode->load();

			if (!$focalnode instanceof Hub_Error) {

				$focalrole = getRoleByName($focalnode->role->name);
				$focalroleid = $focalrole->roleid;
				$lt = getLinkTypeByLabel($linktypename);
				$linkType = $lt->linktypeid;

				// if the connection is to an evidence, it needs to be sent as a Pro/Con nodetype for the connection - depending on the linktype being requested
				if ($linktypename == $CFG->LINK_EVIDENCE_SOLCLAIM_PRO ) {
					$role = getRoleByName("Pro");
					if (!$role instanceof Hub_Error) {
						$nodetypeid = $role->roleid;
					}
				} else if ($linktypename == $CFG->LINK_EVIDENCE_SOLCLAIM_CON ) {
					$role = getRoleByName("Con");
					if (!$role instanceof Hub_Error) {
						$nodetypeid = $role->roleid;
					}
				}

				if ($direction == 'from') {
					$connection = addConnection($node->nodeid, $nodetypeid, $linkType, $focalnodeid, $focalroleid, $private, $conndesc);
				} else {
					$connection = addConnection($focalnodeid, $focalroleid, $linkType, $node->nodeid, $nodetypeid, $private, $conndesc);
 				}

				return $connection;
			} else {
				return $focalnode;
			}

		} else {
			return $node;
		}
	} else {
		return $r;
	}
}
?>