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

<div id='tab-content-home-overview' class="user-tabs2 border border-top-0 p-3 pt-1">
	<div class="row">
		<?php
			$user = $CONTEXTUSER; //$args['user'];
			$userid = $args['userid'];
			// Toolbar area.
			if(isset($USER->userid) && $USER->userid == $userid) { ?>
				<ul class="nav nav-pills mt-1 justify-content-end">
					<li class="nav-item ">
						<a class="nav-link" title="<?php echo $LNG->HEADER_EDIT_PROFILE_LINK_HINT; ?>" href="<?php echo $CFG->homeAddress; ?>ui/pages/profile.php">
							<?php echo $LNG->HEADER_EDIT_PROFILE_LINK_TEXT; ?>
						</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" title="<?php echo $LNG->USER_HOME_MANAGE_TAGS_HINT; ?>" href="javascript:loadDialog('managetags','<?php echo $CFG->homeAddress; ?>ui/popups/tagmanager.php');">
							<?php echo $LNG->USER_HOME_MANAGE_TAGS_LINK; ?>
						</a>
					</li>
					
					<?php if ($CFG->hasCompendiumImport) { ?>
						<li class="nav-item">
							<a class="nav-link" href="<?php echo $CFG->homeAddress; ?>io/compendium/importcompendiumpure.php"><?php echo $LNG->USER_HOME_IMPORT_COMPENDIUM_LINK; ?></a>
						</li>
					<?php } ?>

					<?php if ($CFG->hasBibTexImport) { ?>
						<li class="nav-item">
							<a class="nav-link" href="<?php echo $CFG->homeAddress; ?>io/bibtex/importbibtex.php"><?php echo $LNG->USER_HOME_IMPORT_BIBTEX_LINK; ?></a>
						</li>
					<?php } ?>
					<li class="nav-item pt-1">
						<form id="removeaccountform" action="" method="post" onsubmit="return checkDeleteAccountForm();">
							<input id="removeaccountsubmit" name="removeaccountsubmit" type="submit" value="<?php echo $LNG->USER_HOME_REMOVE_ACCOUNT_LINK; ?>" class="btn btn-danger btn-sm" title="<?php echo $LNG->USER_HOME_REMOVE_ACCOUNT_LINK_HINT; ?>"></input>
						</form>
					</li>
				</ul>
			<?php } ?>
	</div>

	<h2><?php echo $LNG->USER_HOME_PROFILE_HEADING; ?></h2>

	<dl class="row">
		<?php 
			if($user->location != ""){			
				if (isset($user->country) && $user->country != "") { ?>
					<dt class="col-sm-3"><?php echo $LNG->USER_HOME_LOCATION_LABEL; ?></dt>
					<dd class="col-sm-9"><?php echo $user->location; ?>, <?php echo $user->country; ?></dd>
				<?php } else { ?>
					<dt class="col-sm-3"><?php echo $LNG->USER_HOME_LOCATION_LABEL; ?></dt>
					<dd class="col-sm-9"><?php echo $user->location; ?></dd>
				<?php }
			}

			if (sizeof($tags) > 0) { ?>
				<dt class="col-sm-3"><?php echo $LNG->NODE_TAGS_HEADING; ?></dt>
				<dd class="col-sm-9">
					<?php echo $LNG->NODE_TAGS_HEADING; ?>
					<?php
						$i=0;
						foreach($tags as $tag){
							if ($i > 0) {
								echo ', ';
							}
							echo $tag->name;
							$i++;
						}
					?>
				</dd>
			<?php }

			if($user->website != ""){ ?>
				<dt class="col-sm-3"><?php echo $LNG->PROFILE_HOMEPAGE; ?></dt>
				<dd class="col-sm-9"><a href='<?php echo $user->website; ?>'><?php echo $user->website; ?></a></dd>
			<?php }
			if($user->description != ""){ ?>
				<dt class="col-sm-3"><?php echo $LNG->PROFILE_DESC_LABEL; ?></dt>
				<dd class="col-sm-9"><?php echo $user->description; ?></dd>
			<?php }
		?>
	</dl>

	<?php if ($CFG->areStatsPublic || (isset($USER->userid) && $USER->getIsAdmin() == "Y") || (isset($USER->userid) && $USER->userid == $userid)) { ?>
		<p class="text-end"><a class="active" title="<?php echo $LNG->USER_HOME_ANALYTICS_LINK_HINT; ?>" href="javascript:loadDialog('viewuseranalytics','<?php echo $CFG->homeAddress; ?>ui/stats/userContextStats.php?userid=<?php echo $user->userid; ?>', 800, 600);"><?php echo $LNG->USER_HOME_ANALYTICS_LINK_TEXT; ?></a></p>
	<?php } ?>

	<hr class="hrline" />

	<?php $nodeArray = getUserNodeTypeCreationCounts($user->userid); ?>

	<h2><?php echo $LNG->USER_HOME_VIEW_CONTENT_HEADING; ?></h2>
	<table class="table table-sm">
		<tr class="challengeback" style="color: white">
			<td><strong><?php echo $LNG->USER_HOME_TABLE_ITEM_TYPE; ?></strong></td>
			<td class="text-end"><strong><?php echo $LNG->USER_HOME_TABLE_CREATION_COUNT; ?></strong></td>
			<td class="text-end"><strong><?php echo $LNG->USER_HOME_TABLE_VIEW; ?></strong></td>
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
				<td class="text-end"><?php echo $c ?></td>
				<td class="text-end"><?php
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
		<p class="text-end">
			<a class="active" title="<?php echo $LNG->USER_REPORT_MY_DATA_LINK_HINT; ?>" href="javascript:loadDialog('viewuseranalytics','<?php echo $CFG->homeAddress; ?>ui/popups/printusernodes.php?userid=<?php echo $user->userid; ?>', 800, 600);">
				<img style="padding-right:5px;" alt="<?php echo $LNG->EXPLORE_PRINT_BUTTON_ALT;?>" src="<?php echo $HUB_FLM->getImagePath("printer.png"); ?>" /><?php echo $LNG->USER_REPORT_MY_DATA_LINK; ?>
			</a>
		</p>
	<?php } ?>

	<p class="text-end"><a class="active" title="<?php echo $LNG->USER_HOME_VIEW_ACTIVITIES_HINT; ?>" href="javascript:loadDialog('viewuseractivity','<?php echo $CFG->homeAddress; ?>ui/popups/activityviewerusers.php?fromtime=0&userid=<?php echo $userid; ?>', 800, 600);"><?php echo $LNG->USER_HOME_VIEW_ACTIVITIES_LINK; ?></a></p>

	<hr class="hrline" />

	<div class="row">
		<div class="col">
			<h2><?php echo $LNG->USER_HOME_FOLLOWING_HEADING; ?></h2>
			<div class="mb-2">
				<form id="followupdate" action="" enctype="multipart/form-data" method="post">
					<?php if(isset($USER->userid) && $USER->userid == $userid && $CFG->send_mail){
						if ($USER->followsendemail == 'Y') { ?>
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="checkbox" value="Y" id="followsendemail" name="followsendemail" onclick="updateUserFollow()" checked />
								<label class="form-check-label" for="followsendemail">
									<?php echo $LNG->USER_HOME_ACTIVITY_ALERT; ?>
								</label>
							</div>
						<?php } else { ?>
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="checkbox" value="Y" id="followsendemail" name="followsendemail" onclick="updateUserFollow()" />
								<label class="form-check-label" for="followsendemail">
									<?php echo $LNG->USER_HOME_ACTIVITY_ALERT; ?>
								</label>
							</div>
						<?php } ?>
						<div class="form-check form-check-inline">
							<input class="form-check-input" type="radio" name="followruninterval" id="followruninterval-daily" value="daily" onclick="updateUserFollow()" <?php if ($USER->followruninterval == 'daily'){ ?> checked <?php } ?> />
							<label class="form-check-label" for="followruninterval-daily">
								<?php echo $LNG->USER_HOME_EMAIL_DAILY; ?>
							</label>
						</div>
						<div class="form-check form-check-inline">
							<input class="form-check-input" type="radio" name="followruninterval" id="followruninterval-weekly" value="weekly" onclick="updateUserFollow()" <?php if ($USER->followruninterval == 'weekly'){ ?> checked <?php } ?> />
							<label class="form-check-label" for="followruninterval-weekly">
								<?php echo $LNG->USER_HOME_EMAIL_WEEKLY; ?>
							</label>
						</div>
						<div class="form-check form-check-inline">
							<input class="form-check-input" type="radio" name="followruninterval" id="followruninterval-monthly" value="monthly" onclick="updateUserFollow()" <?php if ($USER->followruninterval == 'monthly'){ ?> checked <?php } ?> />
							<label class="form-check-label" for="followruninterval-monthly">
								<?php echo $LNG->USER_HOME_EMAIL_MONTHLY; ?>
							</label>
						</div>
					<?php }	?>
				</form>
			</div>
			<table class="table table-sm">
				<tr class="challengeback" style="color: white">
					<td><strong><?php echo $LNG->USER_HOME_TABLE_TYPE; ?></strong></td>
					<td><strong><?php echo $LNG->USER_HOME_TABLE_NAME; ?></strong></td>
					<?php if ($USER->userid == $userid) {?>
						<td class="text-end"><strong><?php echo $LNG->USER_HOME_TABLE_ACTION; ?></strong></td>
					<?php } ?>
					<td class="text-end"><strong><?php echo $LNG->USER_HOME_TABLE_ACTION; ?></strong></td>
					<td class="text-end"><strong><?php echo $LNG->USER_HOME_TABLE_VIEW; ?></strong></td>
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
						<td style="color: #666666;"><?php echo $LNG->USER_HOME_PERSON_LABEL; ?></td>
						<td><?php echo $name ?></td>
						<?php if ($USER->userid == $userid) {?>
							<td class="text-end">
								<a class="active" href="javascript:unfollowMyUser('<?php echo $nextuserid; ?>');"><?php echo $LNG->USER_HOME_UNFOLLOW_LINK; ?></a>
							</td>
						<?php } ?>
						<td class="text-end">
							<a class="active" href="<?php echo $CFG->homeAddress; ?>user.php?userid=<?php echo $nextuserid; ?>"><?php echo $LNG->USER_HOME_EXPLORE_LINK; ?></a>
						</td>
						<td class="text-end">
							<a class="active" href="javascript:loadDialog('viewuseractivity','<?php echo $CFG->homeAddress; ?>ui/popups/activityviewerusers.php?userid=<?php echo $nextuserid; ?>', 800, 600);"><?php echo $LNG->USER_HOME_ACTIVITY_LINK; ?></a>
						</td>
					</tr>
					<?php }
						if ($i > 0) {
							$followingCount = $i;
						}

						$itemArray = getItemsBeingFollowedByMe($userid);
						$nodeType = "";
						$i=0;

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
									<td><?php echo $name ?></td>
									<?php if ($USER->userid == $userid) {?>
										<td class="text-end">
											<a class="active" href="javascript:unfollowMyNode('<?php echo $nodeid; ?>');"><?php echo $LNG->USER_HOME_UNFOLLOW_LINK; ?></a>
										</td>
									<?php } ?>
									<td class="text-end">
										<?php
											echo '<a class="active" href="'.$CFG->homeAddress.'explore.php?id='.$nodeid.'">'.$LNG->USER_HOME_EXPLORE_LINK.'</a>';
										?>
									</td>
									<td class="text-end">
										<a class="active" href="javascript:loadDialog('viewactivity','<?php echo $CFG->homeAddress; ?>ui/popups/activityviewer.php?nodeid=<?php echo $nodeid; ?>', 800, 600);"><?php echo $LNG->USER_HOME_ACTIVITY_LINK; ?></a>
									</td>
								</tr>
							<?php }
						} ?>
			</table>
		</div>
		<div class="col">
			<h2><?php echo $LNG->USER_HOME_FOLLOWERS_HEADING; ?></h2>
			<p class="mb-2">&nbsp;</p>
			<table class="table table-sm">
				<tr class="challengeback" style="color: white;">
					<td><strong><?php echo $LNG->USER_HOME_TABLE_PICTURE; ?></strong></td>
					<td><strong><?php echo $LNG->USER_HOME_TABLE_NAME; ?></strong></td>
					<td class="text-end"><strong><?php echo $LNG->USER_HOME_TABLE_VIEW; ?></strong></td>
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
										<img src="<?php echo $nextuser->thumb;?>" />
									</a>
								</td>
								<td><?php echo $nextuser->name ?></td>
								<td class="text-end">
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

	<div class="row">
		<div class="col">
			<h2><?php echo $LNG->TAB_USER_DATA; ?></h2>

			<table class="table table-sm">
				<tr class="challengeback" style="color: white">
					<td width="20%"><strong><?php echo $LNG->USER_HOME_TABLE_TYPE; ?></strong></td>
					<td width="50%"><strong><?php echo $LNG->USER_HOME_TABLE_NAME; ?></strong></td>
					<?php if ($USER->userid == $userid) {?>
						<td width="10%"><strong><?php echo $LNG->USER_HOME_TABLE_ACTION; ?></strong></td>
					<?php } ?>
					<td width="10%"><strong><?php echo $LNG->USER_HOME_TABLE_ACTION; ?></strong></td>
					<td width="10%"><strong><?php echo $LNG->USER_HOME_TABLE_VIEW; ?></strong></td>
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
							<td><?php echo $name ?></td>

							<?php if ($USER->userid == $userid) {?>
							<td>
								<a class="active" href="javascript:unfollowMyNode('<?php echo $nodeid; ?>');"><?php echo $LNG->USER_HOME_UNFOLLOW_LINK; ?></a>
							</td>
							<?php } ?>

							<td>
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
							<td>
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
	</div>
</div>