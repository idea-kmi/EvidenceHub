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

checkLogin();

include_once($HUB_FLM->getCodeDirPath("ui/header.php"));

global $CFG, $USER;

if($USER->getIsAdmin() != "Y"){
	echo "<div class='errors'>".$LNG->FORM_ERROR_NOT_ADMIN."</div>";
	include_once($HUB_FLM->getCodeDirPath("ui/footer.php"));
	die;
}

echo "<h1>".$LNG->ADMIN_CREATE_NODE_TYPES_TITLE."</h1>";

//remember this does not get the default user.
/*
$us = getUsersByGlobal(false, 0, -1,'date','DESC','short','');

$users = $us->users;
$count = count($users);

$nodename = "Media Source"; //
$image = 'nodetypes/Default/litertaure-analysis.png';

//$nodename = "Webpage"; //
//$image = 'nodetypes/Default/litertaure-analysis.png';

//$nodegroupid = $CFG->defaultRoleGroupID;
//$nodegroupid = $CFG->systemRoleGroupID;
$nodegroupid = $CFG->evidenceRoleGroupID;

for ($i=0; $i<$count; $i++) {
	$user = $users[$i];
	$userid=$user->userid;

	$id = getUniqueID();
	adminCreateNodeType($userid, $id, $nodegroupid, $nodename, $image);
}

// Now add for the default user (not on the above list), so all new user's get this too.
$id = getUniqueID();
adminCreateNodeType($CFG->defaultUserID, $id, $nodegroupid, $nodename, $image);
*/
include_once($HUB_FLM->getCodeDirPath("ui/footer.php"));
?>
