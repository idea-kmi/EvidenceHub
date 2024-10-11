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
require_once("../config.php");
require_once($HUB_FLM->getCodeDirPath("core/mailchimp.php"));

checkLogin();

include_once($HUB_FLM->getCodeDirPath("ui/header.php"));

global $CFG, $USER;

if($USER->getIsAdmin() != "Y"){
	echo "<div class='errors'>".$LNG->FORM_ERROR_NOT_ADMIN."</div>";
	include_once($HUB_FLM->getCodeDirPath("ui/footer.php"));
	die;
}

/*
echo "<h1>Update for Auto Self Following of Chats</h1>";

if (isset($CFG->autoFollowingOn) && $CFG->autoFollowingOn) {
	$nodetypes = "Comment";

	//$count = count($CFG->BASE_TYPES);
    //for($i=0; $i<$count; $i++){
    //	if ($CFG->BASE_TYPES[$i] != "Theme" && $CFG->BASE_TYPES[$i] != "Idea") {
	//		if ($i == 0) {
	//			$nodetypes .= $CFG->BASE_TYPES[$i];
	//		} else {
	//			$nodetypes .= ",".$CFG->BASE_TYPES[$i];
	//		}
	//	}
    //}

	//$count = count($CFG->EVIDENCE_TYPES);
	//for ($i=0; $i<$count; $i++) {
	//	$nodetypes .= ",".$CFG->EVIDENCE_TYPES[$i];
	//}
	//$count = count($CFG->RESOURCE_TYPES);
	//for ($i=0; $i<$count; $i++) {
	//	$nodetypes .= ",".$CFG->RESOURCE_TYPES[$i];
	//}

	$us = getUsersByGlobal(false, 0, -1,'date','DESC','long','');
	$users = $us->users;
	$count = count($users);

	$currentuser = $USER;

	for ($i=0; $i<$count; $i++) {
		$user = $users[$i];
		if ($user->userid != $CFG->defaultUserID && $user->userid != $CFG->ADMIN_USERID) {

			$USER = $user;

			$nodeset = getNodesByUser($user->userid,0,-1,'date','DESC',$nodetypes,'','short');
			$nodes = $nodeset->nodes;
			$countj = count($nodes);
			for ($j=0; $j<$countj; $j++) {
				$node = $nodes[$j];

				// Check they are not already following their item, and if not follow it.
				$following = new Following($node->nodeid);
				$following = $following->load();
				if (!isset($following->creationdate)) {
					addFollowing($node->nodeid);
				}
			}
		}
	}

	$USER = $currentuser;
}

echo "Finished";
*/
include_once($HUB_FLM->getCodeDirPath("ui/footer.php"));
?>
