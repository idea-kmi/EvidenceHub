<?php
/********************************************************************************
 *                                                                              *
 *  (c) Copyright 2024 The Open University UK                                   *
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

/** UNTIL PHP 7.3 - supply own function **/
if (!function_exists('is_countable')) {
    function is_countable($var) {
        return (is_array($var) || $var instanceof Countable);
    }
}

/** SETUP THE FILE LOCATION MANAGER **/
	unset($HUB_FLM);
	require_once("core/filelocationmanager.class.php");
	// instantiate the file location manager
	if (isset($CFG->uitheme)) {
		$HUB_FLM = new FileLocationManager($CFG->uitheme);
	} else {
		$HUB_FLM = new FileLocationManager();
	}
	global $HUB_FLM;


/** SETUP STATIC CONFIG VARIABLES **/

	$CFG->VERSION = '2.0';

	$CFG->HAS_SOLUTION = in_array('Solution', $CFG->BASE_TYPES);
	$CFG->HAS_CLAIM = in_array('Claim', $CFG->BASE_TYPES);
	$CFG->HAS_CHALLENGE = in_array('Challenge', $CFG->BASE_TYPES);
	$CFG->HAS_OPEN_COMMENTS = in_array('Idea', $CFG->BASE_TYPES);

	// historical when we had different Comment types. Could be phased out of the code now
	$CFG->COMMENT_TYPES = array("Comment");

	$CFG->actionAdd = "add";
	$CFG->actionEdit = "edit";
	$CFG->actionDelete = "delete";

	/**
	 * This is a legacy item. This is still required by the delete role code!
	 * MB:look at removing
	 */
	$CFG->DEFAULT_NODE_TYPE = "Issue"; // This is still required by delete role!

	$CFG->AUTH_TYPE_EVHUB = "evhub";

	$CFG->STATUS_ACTIVE = 0;
	$CFG->STATUS_SPAM = 1;

	$CFG->USER_STATUS_ACTIVE = 0;
	$CFG->USER_STATUS_REPORTED = 1;
	$CFG->USER_STATUS_UNVALIDATED = 2;
	$CFG->USER_STATUS_UNAUTHORIZED = 3;
	$CFG->USER_STATUS_SUSPENDED = 4;

	$CFG->GLOBAL_CONTEXT = "global";
	$CFG->USER_CONTEXT = "user";
	$CFG->NODE_CONTEXT = "node";

	$CFG->LINK_PRO_SOLUTION = 'supports';
	$CFG->LINK_CON_SOLUTION = 'challenges';

	$CFG->IMAGE_MAX_FILESIZE = 1000000;
	$CFG->IMAGE_MAX_HEIGHT = 100;
	$CFG->IMAGE_WIDTH = 60;
	$CFG->IMAGE_HEIGHT = 90;
	$CFG->IMAGE_THUMB_WIDTH = 30;
	$CFG->ICON_WIDTH = 32;
	$CFG->DEFAULT_USER_PHOTO= 'profile.png';
	$CFG->DEFAULT_GROUP_PHOTO= 'groupprofile.png';

	// For calling the geo api to get location for addresses
	// NOT SURE THIS IS USED ANYMORE?
	$CFG->GOOLGE_SERVER_SIDE_API_KEY = "<***Add your google api key***>";

	/**
	 * The file paths for the node type icons used.
	 * These are currently only referenced in ui/datamodel.js.php
	 */
	$CFG->challengeicon = $HUB_FLM->getImagePath("nodetypes/Default/challenge.png");
	$CFG->issueicon = $HUB_FLM->getImagePath("nodetypes/Default/issue.png");
	$CFG->claimicon = $HUB_FLM->getImagePath("nodetypes/Default/claim.png");
	$CFG->solutionicon = $HUB_FLM->getImagePath("nodetypes/Default/solution.png");
	$CFG->evidenceicon = $HUB_FLM->getImagePath("nodetypes/Default/litertaure-alaysis.png");
	$CFG->resourceicon = $HUB_FLM->getImagePath("nodetypes/Default/reference-32x32.png");
	$CFG->orgicon = $HUB_FLM->getImagePath("nodetypes/Default/organization.png");
	$CFG->projecticon = $HUB_FLM->getImagePath("nodetypes/Default/project.png");
	$CFG->proicon = $HUB_FLM->getImagePath("nodetypes/Default/plus-32x32.png");
	$CFG->conicon = $HUB_FLM->getImagePath("nodetypes/Default/minus-32x32.png");
	$CFG->themeicon = $HUB_FLM->getImagePath("nodetypes/Default/theme.png");

	/** EDIT THIS LINE **/
	$CFG->maptilesurl = "<***url to your tilecache***>";

/** CREATE ALL OTHER GLOBAL VARIABLES AND INITIALIZE THEM AND LOAD LIBRARIES **/

	require_once('core/sanitise.php');
 	require_once("language/language.php");
 	require_once("core/databases/sqlstatements.php");
	require_once("core/datamodel/datamodel.class.php");
    require_once('core/accesslib.php');

    startSession();

    unset($USER);
	unset($HUB_DATAMODEL);

    global $CFG;
    global $LNG;
    global $USER;
    global $HEADER;
    global $BODY_ATT;
    global $CONTEXT;
    global $HUB_DATAMODEL;
    global $HUB_SQL;

    $HEADER = array();

/**CREATE THE DATAMODEL CLASS INSTANCE */
	$HUB_DATAMODEL = new DataModel();
	$HUB_DATAMODEL->load();

/** SETUP THE DATABASE MANAGER **/
	unset($DB);
	require_once("core/databases/databasemanager.class.php");
	// instantiate the database
	if (isset($CFG->databasetype) && $CFG->databasetype != "") {
		$DB = new DatabaseManager($CFG->databasetype);
	} else {
		$DB = new DatabaseManager();
	}
    global $DB;

    require_once('core/datamodel/error.class.php');
    require_once('core/apilib.php');
    require_once('core/auditlib.php');

    if (isset($_SESSION["session_userid"]) && $_SESSION["session_userid"] != "") {
    	$USER = new User($_SESSION["session_userid"]);
    	$USER->load();
    } else {
    	$USER = new User();
    }

    // load Themes from Database
    // NOTE: all themes own by admin users so not duplicated
    // If this changes then this code needs to call a function for get distinct by labels
	$ns = getNodesByGlobal(0,-1,'name','ASC', 'Theme', '', 'long',"",'all',false);
	$nodes = $ns->nodes;

	$CFG->THEMES = array();
	foreach($nodes as $node) {
		array_push($CFG->THEMES, $node->name);
	}
?>
