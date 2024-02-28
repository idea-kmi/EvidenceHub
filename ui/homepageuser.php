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
 global $user, $LNG;

$tags = array();

if(isset($user->tags)) {
	$tags = $user->tags;
}

if( isset($_POST["removeaccountsubmit"]) ) {
	$userid = $args['userid'];
	if(isset($USER->userid) && $USER->userid == $userid){
		// Email to administrator about account deletion request.
		$headpath = $HUB_FLM->getMailTemplatePath("emailhead.txt");
		$headtemp = loadFileToString($headpath);
		$head = vsprintf($headtemp,array($HUB_FLM->getImagePath('evidence-hub-logo-email.png')));

		$footpath = $HUB_FLM->getMailTemplatePath("emailfoot.txt");
		$foottemp = loadFileToString($footpath);
		$foot = vsprintf($foottemp,array ($CFG->homeAddress));

		$message = "<br /><br />Account deletetion request from: <br /><br />".$USER->userid." : ".$USER->name;
		$message = $head.$message.$foot;

		$headers = "Content-type: text/html; charset=utf-8\r\n";
		ini_set("sendmail_from", $CFG->EMAIL_FROM_ADDRESS );
		$headers .= "From: ".$CFG->EMAIL_FROM_NAME ." <".$CFG->EMAIL_FROM_ADDRESS .">\r\n";
		$headers .= "Reply-To: ".$CFG->EMAIL_REPLY_TO."\r\n";
		mail($CFG->ERROR_ALERT_RECIPIENT,"Account Deletion Request: ".$CFG->SITE_TITLE,$message,$headers);

		echo '<script type="text/javascript">alert("'.$LNG->USER_HOME_REMOVE_ACCOUNT_EMAIL_CONFIRMATION.'");</script>';
	}
}

?>
<script type="text/javascript">
function checkDeleteAccountForm() {
	var reply = confirm("<?php echo $LNG->USER_HOME_REMOVE_ACCOUNT_CONFIRM; ?>");
	if (reply == true) {
		return true;
	} else {
		return false
	}
}
</script>

<div id='tab-content-home-overview' style='background: white; clear:both; float:left; padding-left:5px;width:100%;'>
<?php
	$user = $CONTEXTUSER; //$args['user'];
	$userid = $args['userid'];
	// Toolbar area.
	if(isset($USER->userid) && $USER->userid == $userid){
		echo '<div style="padding:5px;padding-bottom:0px;">';

		echo '<a title="'.$LNG->HEADER_EDIT_PROFILE_LINK_HINT.'" href="'.$CFG->homeAddress.'ui/pages/profile.php">'.$LNG->HEADER_EDIT_PROFILE_LINK_TEXT.'</a>';

		echo '<a title="'.$LNG->USER_HOME_MANAGE_TAGS_HINT.'" style="margin-left:30px;" href="javascript:loadDialog(\'managetags\',\''.$CFG->homeAddress.'ui/popups/tagmanager.php\');">'.$LNG->USER_HOME_MANAGE_TAGS_LINK.'</a>';

		if ($CFG->hasCompendiumImport) {
			echo '<a style="margin-left: 30px;" href="'.$CFG->homeAddress.'io/compendium/importcompendiumpure.php">'.$LNG->USER_HOME_IMPORT_COMPENDIUM_LINK.'</a>';
		}

		if ($CFG->hasBibTexImport) {
			echo '<a style="margin-left: 30px;" href="'.$CFG->homeAddress.'io/bibtex/importbibtex.php">'.$LNG->USER_HOME_IMPORT_BIBTEX_LINK.'</a>';
		}

		echo '<form style="float:right; margin-left: 30px;" id="removeaccountform" action="" method="post" onsubmit="return checkDeleteAccountForm();">
			<input id="removeaccountsubmit" name="removeaccountsubmit" type="submit" value="'.$LNG->USER_HOME_REMOVE_ACCOUNT_LINK.'" class="active" title="'.$LNG->USER_HOME_REMOVE_ACCOUNT_LINK_HINT.'"></input>
			</form>';

		echo '</div>';

		echo '<hr class="hrline" style="float:left;clear:both;width: 100%;margin-left:-5px;" />';
	}

	echo '<h3 style="margin-top:5px;padding-top:0px;">'.$LNG->USER_HOME_PROFILE_HEADING.'</h3>';

	if($user->location != ""){
		echo "<p>".$LNG->USER_HOME_LOCATION_LABEL." ".$user->location;
		if (isset($user->country) && $user->country != "") {
			echo ", ".$user->country."</p>";
		} else {
			echo "</p>";
		}
	}

	if (sizeof($tags) > 0) { ?>
		<p><?php echo $LNG->NODE_TAGS_HEADING; ?>
			<?php
				$i=0;
				foreach($tags as $tag){
					if ($i > 0) {
						echo ',';
					}
					echo $tag->name;
					$i++;
				}
			  ?>
	   </p>
	<?php }

	if($user->website != ""){
		echo "<p>".$LNG->PROFILE_HOMEPAGE." <a href='".$user->website."'>".$user->website."</a></p>";
	}
	if($user->description != ""){
		echo "<p>".$LNG->PROFILE_DESC_LABEL." ".$user->description."</p>";
	}
	?>

	<?php if ($CFG->areStatsPublic || (isset($USER->userid) && $USER->getIsAdmin() == "Y") || (isset($USER->userid) && $USER->userid == $userid)) { ?>
		<h3 style="font-size:14px"><a class="active" title="<?php echo $LNG->USER_HOME_ANALYTICS_LINK_HINT; ?>" href="javascript:loadDialog('viewuseranalytics','<?php echo $CFG->homeAddress; ?>ui/stats/userContextStats.php?userid=<?php echo $user->userid; ?>', 800, 600);"><?php echo $LNG->USER_HOME_ANALYTICS_LINK_TEXT; ?></a></h3>
	<?php } ?>

	<hr class="hrline" style="height:1px; width: 100%;margin-left:-5px;" />

	<?php
	$nodeArray = getUserNodeTypeCreationCounts($user->userid);
	?>

	<h3><?php echo $LNG->USER_HOME_VIEW_CONTENT_HEADING; ?></h3>
	<table cellspacing="2" cellpadding="3" style="border-collapse:collapse;" width="300">
		<tr class="challengeback" style="color: white">
			<td width="40%"><b><?php echo $LNG->USER_HOME_TABLE_ITEM_TYPE; ?></b></td>
			<td align="right" width="30%"><b><?php echo $LNG->USER_HOME_TABLE_CREATION_COUNT; ?></b></td>
			<td align="right" width="10%"><b><?php echo $LNG->USER_HOME_TABLE_VIEW; ?></b></td>
		</tr>
		<tr>
			<td colspan="3" valign="top" style="border-top: 1px solid #666666 "></td>
		</tr>

		<?php $i=0; foreach($nodeArray as $n=>$c) {
			if ( $n == 'Issue' && ( $CFG->issuesManaged == false || ($CFG->issuesManaged == true && $USER->getIsAdmin() == "Y"))
				|| $n == 'Evidence'
				|| $n == 'Resource'
				|| ($CFG->HAS_CHALLENGE && $n == 'Challenge')
				|| ($CFG->HAS_CLAIM && $n == 'Claim')
				|| ($CFG->HAS_SOLUTION && $n == 'Solution')
				|| $n == 'Organization'
				|| $n == 'Project'
				|| $n == 'Comment'
				|| $n == 'Idea') {

				$i++;
		?>
			<tr>
				<td style="color: #666666 "><?php
					if ($n == 'Resource') {
						echo $LNG->RESOURCE_NAME;
					} else if ($n == 'Evidence') {
						echo $LNG->EVIDENCE_NAME;
					} else if ($n == 'Issue' && ( $CFG->issuesManaged == false || ($CFG->issuesManaged == true && $USER->getIsAdmin() == "Y"))) {
						echo $LNG->ISSUE_NAME;
					} else if ($n == 'Solution' && $CFG->HAS_SOLUTION) {
						echo $LNG->SOLUTION_NAME;
					} else if ($n == 'Claim' && $CFG->HAS_CLAIM) {
						echo $LNG->CLAIM_NAME;
					} else if ($n == 'Organization') {
						echo $LNG->ORG_NAME;
					} else if ($n == 'Project') {
						echo $LNG->PROJECT_NAME;
					} else if ($n == 'Comment') {
						echo $LNG->CHAT_NAME;
					} else if ($n == 'Idea') {
						echo $LNG->COMMENT_NAME;
					} else if ($n == 'Challenge' && $CFG->HAS_CHALLENGE) {
						echo $LNG->CHALLENGE_NAME;
					}
					?>
				</td>
				<td align="right"><?php echo $c ?></td>
				<td align="right"><?php
					if ($n == 'Resource') {
						echo '<a href="#data-resource" class="active" onclick="setTabPushed($(\'tab-web-list-obj\'),\'data-resource\');">'.$LNG->USER_HOME_TABLE_VIEW.'</a>';
					} else if ($n == 'Evidence') {
						echo '<a href="#data-evidence" class="active" onclick="setTabPushed($(\'tab-evidence-list-obj\'),\'data-evidence\');">'.$LNG->USER_HOME_TABLE_VIEW.'</a>';
					} else if ($n == 'Issue' && ( $CFG->issuesManaged == false || ($CFG->issuesManaged == true && $USER->getIsAdmin() == "Y"))) {
						echo '<a href="#data-issue" class="active" onclick="setTabPushed($(\'tab-issue-list-obj\'),\'data-issue\');">'.$LNG->USER_HOME_TABLE_VIEW.'</a>';
					} else if ($n == 'Solution' && $CFG->HAS_SOLUTION) {
						echo '<a href="#data-solution" class="active" onclick="setTabPushed($(\'tab-solution-list-obj\'),\'data-solution\');">'.$LNG->USER_HOME_TABLE_VIEW.'</a>';
					} else if ($n == 'Claim' && $CFG->HAS_CLAIM) {
						echo '<a href="#data-claim" class="active" onclick="setTabPushed($(\'tab-claim-list-obj\'),\'data-claim\');">'.$LNG->USER_HOME_TABLE_VIEW.'</a>';
					} else if ($n == 'Organization') {
						echo '<a href="#data-org" class="active" onclick="setTabPushed($(\'tab-org-list-obj\'),\'data-org\');">'.$LNG->USER_HOME_TABLE_VIEW.'</a>';
					} else if ($n == 'Project') {
						echo '<a href="#data-org" class="active" onclick="setTabPushed($(\'tab-project-list-obj\'),\'data-project\');">'.$LNG->USER_HOME_TABLE_VIEW.'</a>';
					} else if ($n == 'Comment') {
						echo '<a href="#data-chat" class="active" onclick="setTabPushed($(\'tab-chat-list-obj\'),\'data-chat\');">'.$LNG->USER_HOME_TABLE_VIEW.'</a>';
					} else if ($n == 'Idea') {
						echo '<a href="#data-comment" class="active" onclick="setTabPushed($(\'tab-comment-list-obj\'),\'data-comment\');">'.$LNG->USER_HOME_TABLE_VIEW.'</a>';
					} else if ($n == 'Challenge' && $CFG->HAS_CHALLENGE) {
						echo '<a href="#data-challenge" class="active" onclick="setTabPushed($(\'tab-challenge-list-obj\'),\'data-challenge\');">'.$LNG->USER_HOME_TABLE_VIEW.'</a>';
					}
					?>
				</td>
			</tr>
		<?php }
		}

		if ($i == 0) {
			echo "<tr>";
			echo "<td colspan='3'>You have done no activities yet.</td>";
			echo "</tr>";
		}
		?>
	</table>

	<?php if ((isset($USER->userid) && $USER->getIsAdmin() == "Y") || (isset($USER->userid) && $USER->userid == $userid)) { ?>
		<h3 style="font-size:14px"><a class="active" title="<?php echo $LNG->USER_REPORT_MY_DATA_LINK_HINT; ?>" href="javascript:loadDialog('viewuseranalytics','<?php echo $CFG->homeAddress; ?>ui/popups/printusernodes.php?userid=<?php echo $user->userid; ?>', 800, 600);"><img style="padding-right:5px;" alt="<?php echo $LNG->EXPLORE_PRINT_BUTTON_ALT;?>" src="<?php echo $HUB_FLM->getImagePath("printer.png"); ?>" border="0" /><?php echo $LNG->USER_REPORT_MY_DATA_LINK; ?></a></h3>
	<?php } ?>


	<h3 style="font-size:14px"><a class="active" title="<?php echo $LNG->USER_HOME_VIEW_ACTIVITIES_HINT; ?>" href="javascript:loadDialog('viewuseractivity','<?php echo $CFG->homeAddress; ?>ui/popups/activityviewerusers.php?fromtime=0&userid=<?php echo $userid; ?>', 800, 600);"><?php echo $LNG->USER_HOME_VIEW_ACTIVITIES_LINK; ?></a></h3>

	<hr class="hrline" style="margin-top:15px; height:1px; width: 100%;margin-left:-5px;" />

	<div style="clear:both;float:left; width: 100%; height:100%;margin-top:0px;padding-top:0px;">
		<div style="clear:both; float:left; margin-right: 15px;padding-bottom:20px;">
		<h3 style="margin-top:5px;padding-top:0px;"><?php echo $LNG->USER_HOME_FOLLOWING_HEADING; ?></h3>

		<form id="followupdate" action="" enctype="multipart/form-data" method="post">
		<?php if(isset($USER->userid) && $USER->userid == $userid && $CFG->send_mail){

			if ($USER->followsendemail == 'Y') {
				echo '<p><input id="followsendemail" name="followsendemail" type="checkbox" checked="checked value="Y" onclick="updateUserFollow()">'.$LNG->USER_HOME_ACTIVITY_ALERT.'</input>';
			} else {
				echo '<p><input id="followsendemail" name="followsendemail" type="checkbox" value="Y" onclick="updateUserFollow()">'.$LNG->USER_HOME_ACTIVITY_ALERT.'</input>';
			}

			echo '&nbsp;&nbsp;<input type="radio" onclick="updateUserFollow()" id="followruninterval" name="followruninterval" value="daily" ';
			if ($USER->followruninterval == 'daily'){
				echo 'checked="checked"';
			}
			echo '/> '.$LNG->USER_HOME_EMAIL_DAILY.'&nbsp;';
			echo '&nbsp;&nbsp;<input type="radio" onclick="updateUserFollow()" id="followruninterval" name="followruninterval" value="weekly" ';
			if ($USER->followruninterval == 'weekly'){
				echo 'checked="checked"';
			}
			echo '/> '.$LNG->USER_HOME_EMAIL_WEEKLY.'&nbsp;';
			echo '<input type="radio" onclick="updateUserFollow()" id="followruninterval" name="followruninterval" value="monthly" ';
			if ($USER->followruninterval == 'monthly'){
				echo 'checked="checked"';
			}
			echo '/> '.$LNG->USER_HOME_EMAIL_MONTHLY.'&nbsp;';
		}
		?>

		</form>

		<table cellspacing="2" cellpadding="3" style="border-collapse:collapse;" width="600">
			<tr class="challengeback" style="color: white">
				<td width="20%"><b><?php echo $LNG->USER_HOME_TABLE_TYPE; ?></b></td>
				<td align="left" width="50%"><b><?php echo $LNG->USER_HOME_TABLE_NAME; ?></b></td>
				<?php if ($USER->userid == $userid) {?>
					<td align="right" width="10%"><b><?php echo $LNG->USER_HOME_TABLE_ACTION; ?></b></td>
				<?php } ?>
				<td align="right" width="10%"><b><?php echo $LNG->USER_HOME_TABLE_ACTION; ?></b></td>
				<td align="right" width="10%"><b><?php echo $LNG->USER_HOME_TABLE_VIEW; ?></b></td>
			</tr>
			<tr>
				<td colspan="5" valign="top" style="border-top: 1px solid #666666"></td>
			</tr>

		<?php

		$followingCount = 0;

		$userArray = getUsersBeingFollowedByMe($user->userid);

		$i=0;
		$count = count($userArray);
		for ($j=0; $j<$count; $j++) {
			$next = $userArray[$j];
			$i++;

			$name = $next['Name'];
			$nextuserid = $next['UserID'];
			?>
			<tr>
				<td style="color: #666666 "><?php echo $LNG->USER_HOME_PERSON_LABEL; ?></td>
				<td align="left"><?php echo $name ?></td>

				<?php if ($USER->userid == $userid) {?>
				<td align="right">
					<a class="active" href="javascript:unfollowMyUser('<?php echo $nextuserid; ?>');"><?php echo $LNG->USER_HOME_UNFOLLOW_LINK; ?></a>
				</td>
				<?php } ?>
				<td align="right">
					<a class="active" href="<?php echo $CFG->homeAddress; ?>user.php?userid=<?php echo $nextuserid; ?>"><?php echo $LNG->USER_HOME_EXPLORE_LINK; ?></a>
				</td>
				<td align="right">
					<a class="active" href="javascript:loadDialog('viewuseractivity','<?php echo $CFG->homeAddress; ?>ui/popups/activityviewerusers.php?userid=<?php echo $nextuserid; ?>', 800, 600);"><?php echo $LNG->USER_HOME_ACTIVITY_LINK; ?></a>
				</td>
			</tr>
		<?php
		}

		if ($i > 0) {
			$followingCount = $i;
		}

		$itemArray = getItemsBeingFollowedByMe($userid);
		$nodeType = "";
		$i=0;
		if ($count > 0) {
			echo '<tr><td colspan="5"><hr class="hrline" style="height:1px; width: 100%" /></td></td>';
		}

		// Split into mine and other people items
		$myItemsArray = array();
		$othersItemsArray = array();
		$count2 = count($itemArray);
		for ($j = 0; $j<$count2; $j++) {
			$nextitem = $itemArray[$j];
			if ($nextitem['UserID'] == $args['userid']) {
				array_push($myItemsArray, $nextitem);
			} else {
				array_push($othersItemsArray, $nextitem);
			}
		}

		$countj = count($othersItemsArray);
		for ($j = 0; $j<$countj; $j++) {
			$nextitem = $othersItemsArray[$j];
			$n = $nextitem['NodeType'];

			if ( ($nodeType != "" && $n != $nodeType && $i > 0) ) {
				echo '<tr><td colspan="5"><hr class="hrline" style="height:1px; width: 100%" /></td></td>';
			}

			$nodeType = $n;

			$name = $nextitem['Name'];
			$nodeid = $nextitem['NodeID'];

			if (in_array($n, $CFG->EVIDENCE_TYPES)
			|| in_array($n, $CFG->BASE_TYPES)
			|| in_array($n, $CFG->RESOURCE_TYPES)
			|| $n == 'Comment') {
				$i++;
				?>
				<tr>
					<td style="color: #666666 "><?php
						if (in_array($n, $CFG->RESOURCE_TYPES)) {
							echo $LNG->RESOURCE_NAME." (".$n.")";
						} else if (in_array($n, $CFG->EVIDENCE_TYPES)) {
							echo $LNG->EVIDENCE_NAME." (".$n.")";
						} else if ($n == 'Issue') {
							echo $LNG->ISSUE_NAME;
						} else if ($n == 'Solution' && $CFG->HAS_SOLUTION) {
							echo $LNG->SOLUTION_NAME;
						} else if ($n == 'Claim' && $CFG->HAS_CLAIM) {
							echo $LNG->CLAIM_NAME;
						} else if ($n == 'Organization') {
							echo $LNG->ORG_NAME;
						} else if ($n == 'Project') {
							echo $LNG->PROJECT_NAME;
						} else if ($n == 'Idea') {
							echo $LNG->COMMENT_NAME;
						} else if ($n == 'Challenge' && $CFG->HAS_CHALLENGE) {
							echo $LNG->CHALLENGE_NAME;
						} else if ($n == 'Theme') {
							echo $LNG->THEME_NAME;
						} else if ($n == 'Comment') {
							echo $LNG->CHAT_NAME;
						}
						?>
					</td>
					<td align="left"><?php echo $name ?></td>

					<?php if ($USER->userid == $userid) {?>
					<td align="right">
						<a class="active" href="javascript:unfollowMyNode('<?php echo $nodeid; ?>');"><?php echo $LNG->USER_HOME_UNFOLLOW_LINK; ?></a>
					</td>
					<?php } ?>

					<td align="right"><?php
						echo '<a class="active" href="'.$CFG->homeAddress.'explore.php?id='.$nodeid.'">'.$LNG->USER_HOME_EXPLORE_LINK.'</a>';
					?>
					</td>
					<td align="right">
						<a class="active" href="javascript:loadDialog('viewactivity','<?php echo $CFG->homeAddress; ?>ui/popups/activityviewer.php?nodeid=<?php echo $nodeid; ?>', 800, 600);"><?php echo $LNG->USER_HOME_ACTIVITY_LINK; ?></a>
					</td>
				</tr>
		<?php }
		} ?>
		</table>

		<h3 style="margin-top:5px;padding-top:30px;"><?php echo $LNG->TAB_USER_DATA; ?></h4>

		<table cellspacing="2" cellpadding="3" style="border-collapse:collapse;" width="600">
			<tr class="challengeback" style="color: white">
				<td width="20%"><b><?php echo $LNG->USER_HOME_TABLE_TYPE; ?></b></td>
				<td align="left" width="50%"><b><?php echo $LNG->USER_HOME_TABLE_NAME; ?></b></td>
				<?php if ($USER->userid == $userid) {?>
					<td align="right" width="10%"><b><?php echo $LNG->USER_HOME_TABLE_ACTION; ?></b></td>
				<?php } ?>
				<td align="right" width="10%"><b><?php echo $LNG->USER_HOME_TABLE_ACTION; ?></b></td>
				<td align="right" width="10%"><b><?php echo $LNG->USER_HOME_TABLE_VIEW; ?></b></td>
			</tr>
			<tr>
				<td colspan="5" valign="top" style="border-top: 1px solid #666666"></td>
			</tr>

		<?php

		$countk = count($myItemsArray);
		for ($k = 0; $k<$countk; $k++) {
			$nextitem = $myItemsArray[$k];
			$n = $nextitem['NodeType'];

			if ( ($nodeType != "" && $n != $nodeType && $k > 0) ) {
				echo '<tr><td colspan="5"><hr class="hrline" style="height:1px; width: 100%" /></td></td>';
			}

			$nodeType = $n;

			$name = $nextitem['Name'];
			$nodeid = $nextitem['NodeID'];

			if (in_array($n, $CFG->EVIDENCE_TYPES)
				|| in_array($n, $CFG->BASE_TYPES)
				|| in_array($n, $CFG->RESOURCE_TYPES)
				|| $n == 'Comment') {
				$i++;
				?>
				<tr>
					<td style="color: #666666 "><?php
						if (in_array($n, $CFG->RESOURCE_TYPES)) {
							echo $LNG->RESOURCE_NAME." (".$n.")";
						} else if (in_array($n, $CFG->EVIDENCE_TYPES)) {
							echo $LNG->EVIDENCE_NAME." (".$n.")";
						} else if ($n == 'Issue' && ( $CFG->issuesManaged == false || ($CFG->issuesManaged == true && $USER->getIsAdmin() == "Y"))) {
							echo $LNG->ISSUE_NAME;
						} else if ($n == 'Solution' && $CFG->HAS_SOLUTION) {
							echo $LNG->SOLUTION_NAME;
						} else if ($n == 'Claim' && $CFG->HAS_CLAIM) {
							echo $LNG->CLAIM_NAME;
						} else if ($n == 'Organization') {
							echo $LNG->ORG_NAME;
						} else if ($n == 'Project') {
							echo $LNG->PROJECT_NAME;
						} else if ($n == 'Idea') {
							echo $LNG->COMMENT_NAME;
						} else if ($n == 'Challenge' && $CFG->HAS_CHALLENGE) {
							echo $LNG->CHALLENGE_NAME;
						} else if ($n == 'Theme') {
							echo $LNG->THEME_NAME;
						} else if ($n == 'Comment') {
							echo $LNG->CHAT_NAME;
						}
						?>
					</td>
					<td align="left"><?php echo $name ?></td>

					<?php if ($USER->userid == $userid) {?>
					<td align="right">
						<a class="active" href="javascript:unfollowMyNode('<?php echo $nodeid; ?>');"><?php echo $LNG->USER_HOME_UNFOLLOW_LINK; ?></a>
					</td>
					<?php } ?>

					<td align="right">
					<?php if ($n != 'Comment') {
						echo '<a class="active" href="'.$CFG->homeAddress.'explore.php?id='.$nodeid.'">'.$LNG->USER_HOME_EXPLORE_LINK.'</a>';
					} else {
						$connset = getConnectionsByNode($nodeid);
						$cons = $connset->connections;
						$parentnode = "";
						if (count($cons) > 0) {
							$connection = $cons[0];
							$parentnode = $connection->to;
							if (isset($connection->parentnode)) {
								$parentnode = $connection->parentnode;
							}
						}
						if ($parentnode != "") {
							echo '<a class="active" href="'.$CFG->homeAddress.'chats.php?chatnodeid='.$nodeid.'&id='.$parentnode->nodeid.'">'.$LNG->USER_HOME_EXPLORE_LINK.'</a>';
						}
					}?>
					</td>
					<td align="right">
						<a class="active" href="javascript:loadDialog('viewactivity','<?php echo $CFG->homeAddress; ?>ui/popups/activityviewer.php?nodeid=<?php echo $nodeid; ?>', 800, 600);"><?php echo $LNG->USER_HOME_ACTIVITY_LINK; ?></a>
					</td>
				</tr>
		<?php }
		}

		if ($i > 0) {
			$followingCount .= $i;
		}

		if ($followingCount == 0) {
			echo "<tr>";
			echo "<td colspan='5'><?php echo $LNG->USER_HOME_NOT_FOLLOWING_MESSAGE; ?></td>";
			echo "</tr>";
		}
		?>

		</table>
		</div>

		<div style="float:left;">
			<h3 style="margin-top:5px;padding-top:0px;"><?php echo $LNG->USER_HOME_FOLLOWERS_HEADING; ?></h3>
			<table cellspacing="2" cellpadding="3" style="border-collapse:collapse;" width="300">
				<tr class="challengeback" style="color: white;">
					<td align="left" width="20%"><b><?php echo $LNG->USER_HOME_TABLE_PICTURE; ?></b></td>
					<td align="left" width="60%"><b><?php echo $LNG->USER_HOME_TABLE_NAME; ?></b></td>
					<td align="right" width="20%"><b><?php echo $LNG->USER_HOME_TABLE_VIEW; ?></b></td>
				</tr>
				<tr>
					<td colspan="3" valign="top" style="border-top: 1px solid #666666 "></td>
				</tr>

			<?php
			$i=0;
			$userSet = getUsersByFollowing($userid, 0, -1,'date','DESC');
			if ($userSet->count > 0) {
				for ($j=0; $j < $userSet->count; $j++) {
					$nextuser = $userSet->users[$j];
					$i++;
					?>
					<tr>
						<td style="color: #666666 ">
							<a class="active" href="<?php echo $CFG->homeAddress; ?>user.php?userid=<?php echo $nextuser->userid; ?>">
								<img src="<?php echo $nextuser->thumb;?>" border='0' />
							</a>
						</td>
						<td align="left"><?php echo $nextuser->name ?></td>
						<td align="right">
							<a class="active" href="<?php echo $CFG->homeAddress; ?>user.php?userid=<?php echo $nextuser->userid; ?>">Explore</a>
						</td>
					</tr>
				<?php
				}
			}

			if ($i == 0) {
				echo "<tr><td colspan='3'>".$LNG->USER_HOME_NO_FOLLOWERS_MESSAGE."</td></tr>";
			}

			?>
			</table>
		</div>
	</div>
</div>