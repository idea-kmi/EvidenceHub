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
 /** Author: Michelle Bachler, KMi, The Open University **/

/**
 * REST service API
 *
 * All the methods listed are are available to users through REST-style URL calls
 * The methods should call the corresponding methods in the PHP API (core/apilib.php)
 *
 */

include_once($_SERVER['DOCUMENT_ROOT'].'/config.php');
global $USER,$CFG,$LNG;

//send the header info
set_restapi_header();

// If this system has been set to be a private Site that means all access requires login.
// So unless your API request is to login, check they are logged in before proceeding.
if ($CFG->privateSite) { // && (!isset($USER->userid) || $USER->userid == "")) {
    global $ERROR;
    $ERROR = new Hub_Error;
    $ERROR->createAccessDeniedError();
	include($HUB_FLM->getCodeDirPath("core/formaterror.php"));
    die;
}

$request = $_SERVER['REQUEST_URI'];

//error_log("JSONLD not FOUND: resapi for ".$request);
error_log("resapi for ".$request);

$responseParsed = parse_url($request);

// get any query parameters (id and or callback)
$cipher;
$unobfuscationid="";
$callback = "";
if (isset($responseParsed["query"])) {
	$query = $responseParsed["query"];
	//error_log($query);
	if (isset($query) && $query !="") {
		$queryBitsArray = explode('&', $query);
		$countq = count($queryBitsArray);
		for ($q=0; $q<$countq; $q++) {
			$nextbit = $queryBitsArray[$q];
			$nextArray = explode('=', $nextbit);
			if (count($nextArray) > 1 && $nextArray[0] == 'id') {
				$unobfuscationid = $nextArray[1];
			} else if (count($nextArray) > 1 && $nextArray[0] == 'callback') {
				$callback = $nextArray[1];
			}
		}
	}
}


$path = $responseParsed["path"];

error_log("STARTING API CALL:".$path);
error_log("PATH:".print_r($path, true));
error_log("PARSED:".print_r($responseParsed, true));
error_log("REQUEST:".$request);

//strip any leading and trailing '/'
if ($path[0] == '/') {
	$path = substr($path, 1);
}
if (substr($path, -1, 1) == '/') {
	$path = substr($path, 0, strlen($path)-1);
}
$parts = explode('/', $path);

//error_log("PARTS:".print_r($parts, true));

$area = $parts[0];
if ($area != 'api') {
	global $ERROR;
	$ERROR = new Hub_Error;
	$ERROR->createAccessDeniedError();
	include($HUB_FLM->getCodeDirPath("core/formaterror.php"));
	die;
}

$type = check_param($parts[1], PARAM_ALPHA);
$len = count($parts);
$cipher = "";

// Do we have a data unobfuscation id to get the cipher key?
if ($unobfuscationid != "" && $type != "unobfuscatedusers") {
	$keyArray = getObfuscationKeyByDataID($unobfuscationid, $request);
	if (!$keyArray instanceof Hub_Error) {
		$key = $keyArray['ObfuscationKey'];
		$iv = $keyArray['ObfuscationIV'];
		//error_log("key for data=".$key);
		//error_log("iv for data=".$iv);
		if (isset($key) && isset($iv)) {
			$cipher = new Cipher();
			$cipher->setKey($key);
			$cipher->setIV($iv);
		}
	} else {
		return $keyArray;
	}
}

if ($cipher == "" && $type != "unobfuscatedusers") {
	error_log("Creating new Cipher");
	$salt = openssl_random_pseudo_bytes(32);
	$cipher = new Cipher($salt);
}

//error_log(print_r($type, true));
//error_log(print_r($len, true));
//error_log("Help3:".print_r(memory_get_usage(), true));

$response = "";
switch($type) {

	/*
	case "users":
		if ($len == 2) {
			$response = getUsersByGlobal(false,0, -1,'name','ASC');
			break;
		} else if ($len == 3) {
			$id = check_param($parts[2], PARAM_TEXT);
			$response = getUser($id);
		}
		break;
	*/

	case "unobfuscatedusers":
		if ($len == 2) {
			if (isset($unobfuscationid) && $unobfuscationid != "") {
				$keyArray = getObfuscationKey($unobfuscationid, $request);
				if (!$keyArray instanceof Hub_Error) {
					$key = $keyArray['ObfuscationKey'];
					$iv = $keyArray['ObfuscationIV'];
					//error_log("key for users=".$key);
					//error_log("iv for users=".$iv);
					if (isset($key) && isset($iv)) {
						$cipher = new Cipher();
						$cipher->setKey($key);
						$cipher->setIV($iv);
					}
				}

				if ($cipher == "") {
					error_log("unobfuscation key invalid or expired");
					global $ERROR;
					$ERROR = new Hub_Error;
					$ERROR->createAccessDeniedError();
					include($HUB_FLM->getCodeDirPath("core/formaterror.php"));
					die;
				} else {
					$userset = new UnobfuscatedUserSet();
					$userset->cipher = $cipher;

					// add users
					$users = getObfuscationUsers($unobfuscationid);
					//error_log("Users=".print_r($users, true));

					$userArray = explode(',', $users);

					$count = count($userArray);
					for($i=0; $i<$count; $i++) {
						$userid = $userArray[$i];
						if ($userid == 'anonymous') {
							$user = new User($userid);
							$user->name = $LNG->STATS_ACTIVITY_USER_ANONYMOUS_NAME;
						} else {
							$user = getUser($userid);
						}
						//error_log($userid);
						//error_log(print_r($user, true));
						$userset->add($user);
					}
					$response = $userset;
				}
			} else {
				global $ERROR;
				$ERROR = new Hub_Error;
				$ERROR->createAccessDeniedError();
				include($HUB_FLM->getCodeDirPath("core/formaterror.php"));
				die;
			}
		}
		break;

	case "connections":
		if ($len == 2) {
			$connset = getConnectionsByGlobal(0,-1,'date','ASC');
			$connset->cipher = $cipher;

			if (isset($unobfuscationid) && $unobfuscationid != "") {
				$connset->unobfuscationid = $unobfuscationid;
			}

			$response = $connset;
			break;
		} else if ($len == 3) {
			//$id = check_param($parts[2], PARAM_TEXT);
			//$response = getConnection($id);
		}
		break;
	case "urls":
		if ($len == 2) {
			$urlset = getURLsByGlobal(0,-1,'date','ASC');
			$urlset->cipher = $cipher;

			if (isset($unobfuscationid) && $unobfuscationid != "") {
				$urlset->unobfuscationid = $unobfuscationid;
			}

			$response = $userset;
			break;
		} else if ($len == 3) {
			$id = check_param($parts[2], PARAM_TEXT);
			$url =  getURL($id);
			$url->cipher = $cipher;

			if (isset($unobfuscationid) && $unobfuscationid != "") {
				$users = $url->userid;
				setObfuscationUsers($unobfuscationid, $users);
			}

			$response = $url;
		}
		break;

	case "nodes":
		if ($len == 2) {
			$nodeset = getNodesByGlobal(0,-1,'date','ASC');
			$nodeset->cipher = $cipher;

			if (isset($unobfuscationid) && $unobfuscationid != "") {
				$nodeset->unobfuscationid = $unobfuscationid;
			}

			$response = $nodeset;
			break;
		} else if ($len == 3) {
			$id = check_param($parts[2], PARAM_TEXT);
			$node = getNode($id);
			$node->cipher = $cipher;

			if (isset($unobfuscationid) && $unobfuscationid != "") {
				$node->unobfuscationid = $unobfuscationid;
			}

			$response = $node;
		}
		break;

	case "views":
		$checkNodes = array();
		// All Isses Grouped and not grouped
		if ($len == 2) {
			$viewSet = new ViewSet();
			$viewSet->cipher = $cipher;

			if (isset($unobfuscationid) && $unobfuscationid != "") {
				$viewSet->unobfuscationid = $unobfuscationid;
			}

			$allIssues = getNodesByGlobal(0,-1,'date','ASC', "Issue");

			if (!$allIssues instanceof Hub_Error) {
				$count = count($allIssues->nodes);

				for ($i=0; $i<$count; $i++) {
					$issue = $allIssues->nodes[$i];
					if (!$issue instanceof Hub_Error) {
						$conSet = getView($issue->nodeid, 'long');
						if (!$conSet instanceof Hub_Error) {
							$view = new View($issue->nodeid);
							$countj = count($conSet->connections);
							for ($j=0; $j<$countj;$j++) {
								$con = $conSet->connections[$j];
								$view->addConnection($con);
								$from = $con->from;
								if (in_array($from->nodeid, $checkNodes) === FALSE) {
									$checkNodes[$from->nodeid] = $from->nodeid;
									$view->addNode($from);
								}

								$to = $con->to;
								if (in_array($to->nodeid, $checkNodes) === FALSE) {
									$checkNodes[$to->nodeid] = $to->nodeid;
									$view->addNode($to);
								}
							}
							$viewSet->add($view);
						}
					}
				}
				$response = $viewSet;
			} else {
				$response = "";
			}
		} else if ($len > 2){
			$id = check_param($parts[2], PARAM_TEXT);

			$view = new View($id);
			$view->cipher = $cipher;

			if (isset($unobfuscationid) && $unobfuscationid != "") {
				$view->unobfuscationid = $unobfuscationid;
			}

			$conSet = getView($id, 'long');

			$node = getNode($id);

			if (isset($node->groups) ) {
				$groupid = "";
				$groups = $node->groups;
				// there should only be one group per node.
				if (count($groups) > 0) {
					$groupid = $groups[0]->groupid;
				}
				$view->conversationid = $groupid;
			} else {
				$view->conversationid = $id;
			}

			if (!$conSet instanceof Hub_Error) {
				$countj = count($conSet->connections);
				for ($j=0; $j<$countj; $j++) {
					$con = $conSet->connections[$j];
					$view->addConnection($con);
					$from = $con->from;
					if (in_array($from->nodeid, $checkNodes) === FALSE) {
						$checkNodes[$from->nodeid] = $from->nodeid;
						$view->addNode($from);
					}

					$to = $con->to;
					if (in_array($to->nodeid, $checkNodes) === FALSE) {
						$checkNodes[$to->nodeid] = $to->nodeid;
						$view->addNode($to);
					}
				}

				if ($len == 4) {
					$subtype = check_param($parts[3], PARAM_ALPHA);
					$view->filter = $subtype;
				}
				$response = $view;
			} else {
				$response = "";
			}
		} else {
			global $ERROR;
			$ERROR = new Hub_Error;
			$ERROR->createAccessDeniedError();
			include($HUB_FLM->getCodeDirPath("core/formaterror.php"));
			die;
		}

		break;
	case "conversations":
		if ($len == 2) {
			$groupset = getConversationSetData($parts);
			$groupset->cipher = $cipher;

			if (isset($unobfuscationid) && $unobfuscationid != "") {
				$groupset->unobfuscationid = $unobfuscationid;
			}

			$response = $groupset;
		} else if ($len > 2){
			$id = check_param($parts[2], PARAM_TEXT);

			$group = getConversationData($id);
			$group->cipher = $cipher;

			if (isset($unobfuscationid) && $unobfuscationid != "") {
				$group->unobfuscationid = $unobfuscationid;
			}

			if ($len == 4) {
				$subtype = check_param($parts[3], PARAM_ALPHA);
				$group->filter = $subtype;
			}
			$response = $group;
		} else {
			global $ERROR;
			$ERROR = new Hub_Error;
			$ERROR->createAccessDeniedError();
			include($HUB_FLM->getCodeDirPath("core/formaterror.php"));
			die;
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

// finally format the output
$jsonld = format_output_rest($response);

if ($callback != '') {
	$reply = $callback."(".$jsonld.");";
	echo $reply;
} else {
	echo $jsonld;
}


/** HELP FUNCTIONS **/

/**
 * Return a ConversationSet for all challenges in the database;
 */
function getConversationSetData($parts) {

	$conversationSet = new ConversationSet();

	$allChallenges = getNodesByGlobal(0,-1,'date','ASC', "Challenge");
	if (!$allChallenges instanceof Hub_Error) {
		$count = count($allChallenges->nodes);

		for ($i=0; $i<$count; $i++) {
			$challenge = $allChallenges->nodes[$i];
			if (!$challenge instanceof Hub_Error) {
				$conversation = getConversationData($challenge->nodeid, $parts);
				if ($conversation instanceof Conversation) {
					$conversationSet->add($conversation);
				}
			}
		}
	}

	return $conversationSet;
}

function getConversationData($id, $parts) {
	$conversation = new Conversation($id);
	$view = new View($id);

	$checkNodes = array();
	$checkConns = array();
	$conSet = getConversation($id, 'long');
	if (!$conSet instanceof Hub_Error) {
		$countj = count($conSet->connections);
		if ($countj > 1) {
			for ($j=0; $j<$countj; $j++) {
				$con = $conSet->connections[$j];
				$view->addConnection($con);
				$from = $con->from;
				if (in_array($from->nodeid, $checkNodes) === FALSE) {
					$checkNodes[$from->nodeid] = $from->nodeid;
					$view->addNode($from);
				}

				$to = $con->to;
				if (in_array($to->nodeid, $checkNodes) === FALSE) {
					$checkNodes[$to->nodeid] = $to->nodeid;
					$view->addNode($to);
				}
			}

			if (count($parts) >3) {
				$subtype = check_param($parts[3], PARAM_ALPHA);
				$view->filter = $subtype;
			}
			$conversation->view = $view;
		} else {
			return "";
		}
	} else {
		return "";
	}

	return $conversation;
}

/** HELPER STORAGE CLASSES **/

class Conversation {
	public $id;
	public $view;

    /**
     * Constructor
     *
     * @param string $id (optional)
     * @return View (this)
     */
    function Conversation($id = ""){
        if ($id != "") {
            $this->id = $id;
        }
        return $this;
    }
}

class ConversationSet {
    public $conversations;
    public $count = 0;

    function ConversationSet() {
        $this->conversations = array();
    }

    /**
     * add a Conversation to the set
     *
     * @param Conversation $conversation
     */
    function add($conversation){
        array_push($this->conversations,$conversation);
        $this->count = count($this->conversations);
    }
}

class UnobfuscatedUserSet {
    public $cipher;
    public $users;
    public $count = 0;

    function UnobfuscatedUserSet() {
        $this->users = array();
    }

    /**
     * add a User to the set
     *
     * @param User $user
     */
    function add($user){
        array_push($this->users,$user);
        $this->count = count($this->users);
    }
}

class ViewConnection {
	public $connection;

    function ViewConnection($con) {
    	$this->connection = $con;
    }
}

class ViewNode {
	public $node;

    function ViewNode($node) {
    	$this->node = $node;
    }
}

class ViewSet {
    public $views;
    public $count = 0;

    function ViewSet() {
        $this->views = array();
    }

    /**
     * add a View to the set
     *
     * @param View $view
     */
    function add($view){
        array_push($this->views,$view);
        $this->count = count($this->views);
    }
}

class View {

    public $nodeid;
    public $viewnode;
	public $connections;
	public $nodes;

    /**
     * Constructor
     *
     * @param string $nodeid (optional)
     * @return View (this)
     */
    function View($nodeid = ""){
        if ($nodeid != "") {
            $this->nodeid = $nodeid;
			$this->viewnode = new CNode($this->nodeid);
			$this->viewnode = $this->viewnode->load();
        }
        $this->connections = array();
        $this->nodes = array();
        return $this;
    }

    /**
     * add a CNode to the set
     *
     * @param CNode $node
     */
    function addNode($node){
    	$viewnode = new ViewNode($node);
        array_push($this->nodes,$viewnode);
    }

    /**
     * add a Connection to the set
     *
     * @param Connection $con
     */
    function addConnection($con) {
    	$viewcon = new ViewConnection($con);
        array_push($this->connections,$viewcon);
    }
}

?>