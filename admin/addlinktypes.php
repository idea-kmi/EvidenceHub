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

checkLogin();

include_once($HUB_FLM->getCodeDirPath("ui/header.php"));

global $CFG, $USER;

if($USER->getIsAdmin() != "Y"){
	echo "<div class='errors'>".$LNG->FORM_ERROR_NOT_ADMIN."</div>";
	include_once($HUB_FLM->getCodeDirPath("ui/footer.php"));
	die;
}

echo "<h1>".$LNG->ADMIN_CREATE_LINK_TYPES_TITLE."</h1>";

/*
$us = getUsersByGlobal(false, 0, -1,'date','DESC','short','');

$users = $us->users;
$count = count($users);

$linkid = "type50";
$linkname = "built from";
$linkgroup = '13710825192142';

for ($i=0; $i<$count; $i++) {
	$user = $users[$i];
	$id = $user->userid.$linkid;
	adminCreateLinkType($user->userid, $id, $linkgroup, $linkname);
}

// now add it for the default user - or new user's won't get it.
$id = $CFG->defaultUserID.$linkid;
adminCreateLinkType($CFG->defaultUserID, $id, $linkgroup, $linkname);
*/
include_once($HUB_FLM->getCodeDirPath("ui/footer.php"));
?>
