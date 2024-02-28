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

global $HUB_FLM;
include($HUB_FLM->getCodeDirPath("ui/popuplib.php"));

$ns = getNodesByGlobal(0,20,'date','DESC', 'News', '', 'long');
$news = $ns->nodes;

?>
<div style="float:left;height:100%; width:100%;">

	<!-- LEFT COLUMN -->
	<div style="float:left; width 100%;margin-right: 210px;">
		<div style="float:left;width: 99%;font-weight:normal;padding: 5px;margin-top:0px;font-size:11pt;">

			<div style="float:left;padding-left:10px;">
				<div style="float:left;margin-right:220px;">
					<h1><?php echo $LNG->HOMEPAGE_TITLE; ?></h1>
					<p><?php echo $LNG->HOMEPAGE_FIRST_PARA; ?><br>
					<span id="homeintrobutton" class="active" style="font-weight:normal;text-decoration:underline" onclick="if ($('homeintromore').style.display == 'none') { $('homeintromore').style.display = 'block'; $('homeintrobutton').innerHTML = '<?php echo $LNG->HOMEPAGE_READ_LESS; ?>'; } else { $('homeintromore').style.display = 'none';  $('homeintrobutton').innerHTML = '<?php echo $LNG->HOMEPAGE_KEEP_READING; ?>';}"><?php echo $LNG->HOMEPAGE_KEEP_READING; ?></span>
					</p>

					<div id="homeintromore" style="float:left;clear:both;width:100%;display:none;margin:0px;padding:0px">
						<?php echo $LNG->HOMEPAGE_SECOND_PARA_PART2; ?>

						<p><?php echo $LNG->HOMEPAGE_CATEGORIES_CONNECT_MESSAGE; ?></p>
					</div>

					<?php if ($CFG->HAS_OPEN_COMMENTS) { ?>
						<p><?php echo $LNG->FORM_COMMENT_MESSAGE; ?></p>
						<?php if(isset($USER->userid)){ ?>
							<span class="toolbar" style="margin-top:0px;">
								<a style="font-size: 12pt" href="javascript:loadDialog('createcomment','<?php echo $CFG->homeAddress; ?>ui/popups/commentadd.php', 750,500);" title='<?php echo $LNG->TAB_ADD_COMMENT_HINT; ?>'><img style="vertical-align:bottom" src="<?php echo $HUB_FLM->getImagePath('add.png'); ?>" border="0" style="margin:0px;margin-left: 5px;padding:0px" /> <?php echo $LNG->TAB_ADD_COMMENT_LINK; ?></a>
							</span>
						<?php } else {
							if ($CFG->signupstatus == $CFG->SIGNUP_OPEN) { ?>
								<span class="toolbar" style="margin:0px;padding:0px;"><?php echo $LNG->TAB_COMMENT_MESSAGE_LOGGEDOUT_OPEN; ?></span>
							<?php } else if ($CFG->signupstatus == $CFG->SIGNUP_REQUEST) { ?>
								<span class="toolbar" style="margin:0px;padding:0px;"><?php echo $LNG->TAB_COMMENT_MESSAGE_LOGGEDOUT_REQUEST; ?></span>
							<?php } else { ?>
								<span class="toolbar" style="margin:0px;padding:0px;"><?php echo $LNG->TAB_COMMENT_MESSAGE_LOGGEDOUT_CLOSED; ?></span>
							<?php } ?>
						<?php } ?>
					<?php } ?>

				</div>

				<div style="float:right;margin-left:-220px;">
					<div style="clear:both; float: left;margin-top:10px;margin-bottom:0px;">
						<img border="0" src="<?php echo $HUB_FLM->getImagePath('jigsaw-image.png'); ?>" height="175" />
					</div>
				</div>
			</div>

			<div style="clear:both; float: left;margin-left:10px;margin-top:15px;">
				<h2 style="font-size:14pt;margin-bottom:5px;margin-left:0px;"><?php echo $LNG->HOMEPAGE_CATEGORIES_CONNECT_TITLE; ?> <span style="margin-left:20px;font-size:10pt;font-weight:normal;color:dimgray"><?php echo $LNG->HOMEPAGE_CATEGORIES_CONNECT_HINT; ?></span></h2>
				<?php drawNetworkNavigationBarHome('none'); ?>
			</div>

			<div style="float:left;width:100%;margin-top:10px;margin-left:5px;">
				<h2 style="font-size:14pt;margin-bottom:5px;margin-left:5px;"><?php echo $LNG->HOMEPAGE_THEME_TITLE; ?></h2>
				<?php
					include($HUB_FLM->getCodeDirPath('ui/themelist.php'));
				?>
			</div>

			<table style="float:left;margin-top:15px;margin-left:5px;width:100%">
				<tr>
					<?php if (count($news) > 0) { ?>
					<td width="50%" valign="bottom">
						<h2 style="font-size:14pt;"><?php echo $LNG->HOME_MOSTRECENT_TITLE; ?></h2>
					</td>
					<td width="50%" valign="bottom">
						<h2 style="font-size:14pt;"><?php echo $LNG->HOME_NEWS_TITLE; ?></h2>
					</td>
					<?php } else { ?>
					<td width="100%" valign="bottom">
						<h2 style="font-size:14pt;"><?php echo $LNG->HOME_MOSTRECENT_TITLE; ?></h2>
					</td>
					<?php } ?>
				<tr>
					<?php if (count($news) > 0) { ?>
					<td width="50%" valign="top">
						<div style="float:left;width:100%;">
							<div id="tab-content-home-overview" style="border:2px solid #E8E8E8;">
							</div>
						</div>
					</td>
					<td width="50%" valign="top">
						<div style="float:left;width:100%;">
							<div style="border:2px solid #E8E8E8; padding-left:5px; padding-right:5px; height: 220px; overflow-y: auto; overflow-x: auto;">
								<?php
								foreach($news as $node){
									$description = $node->description;
									if (isProbablyHTML($description)) {
										$description = removeHTMLTags($description);
									}
									if (strlen($description) > 100) {
										$description = substr($description, 0, 100).'...';
									}

									$title = str_replace(' & ', ' &amp; ', $node->name);
									$link = $CFG->homeAddress."explore.php?id=".$node->nodeid;
									$description = $description;
									$date = date('l F d, Y', $node->creationdate);

									echo '<p style="margin-top:3px; margin-bottom:5px;"><strong><a href="'.$link.'" title="'.$title.'">'.$title.'</a></strong><br />';
									echo '<small><em>'.$LNG->NODE_NEWS_POSTED_ON.' '.$date.'</em></small></p>';
									echo '<p style="margin-bottom:20px;">'.$description.'</p>';
								}
								?>
							</div>
						</div>
					</td>
					<?php } else { ?>
					<td width="100%" valign="top">
						<div style="float:left;width:100%;">
							<div id="tab-content-home-overview" style="border:2px solid #E8E8E8;">
							</div>
						</div>
					</td>
					<?php } ?>
				</tr>
			</table>

			<!-- div id="tab-content-home-recent" style="float:left;width:100%;margin-top:10px;margin-left:5px;">
				<h2 style="font-size:14pt;margin-bottom:5px;margin-left:5px;"><?php echo $LNG->HOME_MOSTRECENT_TITLE; ?></h2>
				<div id="tab-content-home-overview" style="border:2px solid #E8E8E8;">
				</div>
			</div -->

			<div style="margin-top:15px;float:left; clear:both;width:100%; height: 120px;overflow:hidden;margin-left:10px;">
				<h2 style="font-size:14pt;"><?php echo $LNG->HOMEPAGE_GEOMAP_TITLE; ?><span style="font-style: italic; color: Gray; font-size: 10pt"> <?php echo $LNG->HOMEPAGE_GEOMAP_MESSAGE; ?></span></h2>
				<div class="active" onclick="setTabPushed($('tab-org-gmap-obj'),'org-gmap');" title="click to go to active view" style="background-image:url('<?php echo $HUB_FLM->getImagePath("bigmap.png"); ?>');float:left;width:100%;height:210px; overflow:hidden;padding-right:5px;"></div>
			</div>

		</div>

	</div>

	<!-- RIGHT COLUMN -->
	<div style="float: right; width:195px; margin-left: -210px; padding: 5px;background: white;">

		<iframe style="border:1px solid white;padding-top:10px;padding-bottom:5px; float:left;" width="200" height="175" src="<?php echo $CFG->welcomeMovie; ?>" frameborder="0" allowfullscreen></iframe>
		<div style="clear:both; float: left;width:100%">
			<?php echo $LNG->HOMEPAGE_QUICKGUIDE_LABEL; ?> <span style="font-size:12pt;"><a href="/help/index.php" title="<?php echo $LNG->HOMEPAGE_QUICKGUIDE_HINT; ?>"><i><?php echo $LNG->HOMEPAGE_QUICKGUIDE_LINK; ?></i></a></span><span style="font-size: 10pt"></span>
		</div>

		<div style="clear:both; float: left;margin-bottom:5px;margin-top:15px;padding-top:3px;">
			<h2 style="margin-bottom: 0px;font-size:12pt;"><?php echo $LNG->HOMEPAGE_TOOLS_TITLE; ?></h2>
			<a href="<?php echo $CFG->homeAddress; ?>help/builderhelp.php" target="_blank"><?php echo $LNG->HOMEPAGE_TOOLS_LINK; ?></a>
			<?php if ($CFG->areStatsPublic || (isset($USER->userid) && $USER->getIsAdmin() == "Y")) { ?>
				<a href="<?php echo $CFG->homeAddress; ?>ui/stats/" target="_blank"><?php echo $LNG->HOMEPAGE_STATS_LINK; ?></a>
			<?php } ?>
		</div>

		<?php if ($CFG->hasStories) { ?>
			<div style="clear:both; float: left;margin-bottom:5px;margin-top:0px;padding-top:3px;">
				<h2 style="margin-bottom: 0px;font-size:12pt;"><?php echo $LNG->HOMEPAGE_STORIES_TITLE; ?></h2>
				<?php if ($CFG->HAS_SOLUTION && $CFG->HAS_CLAIM == FALSE) { ?>
					<a id="pstoryaddhomelink" href="javascript:loadDialog('createpractitionerstory','<?php echo $CFG->homeAddress; ?>ui/popups/quickformpractitioner.php', 750,750);" title='<?php echo $LNG->HOMEPAGE_STORIES_HINT; ?>'><?php echo $LNG->HOMEPAGE_STORIES_LINK; ?></a>
				<?php } ?>
				<?php if ($CFG->HAS_SOLUTION && $CFG->HAS_CLAIM) { ?>
					<a id="pstoryaddhomelink" href="javascript:loadDialog('createpractitionerstory','<?php echo $CFG->homeAddress; ?>ui/popups/quickformpractitioner.php', 750,750);" title='<?php echo $LNG->HOMEPAGE_STORIES_PRACTITIONER_HINT; ?>'><?php echo $LNG->HOMEPAGE_STORIES_PRACTITIONER_LINK; ?></a>
					<?php echo $LNG->HOMEPAGE_STORIES_OR;  ?>
					<a id="rstoryaddhomelink" href="javascript:loadDialog('createreseacherstory','<?php echo $CFG->homeAddress; ?>ui/popups/quickformresearcher.php', 750,750);" title='<?php echo $LNG->HOMEPAGE_STORIES_RESEARCHER_HINT; ?>'><?php echo $LNG->HOMEPAGE_STORIES_RESEARCHER_LINK; ?></a>
				<?php } ?>
				<?php if ($CFG->HAS_CLAIM && $CFG->HAS_SOLUTION === FALSE) { ?>
					<a id="rstoryaddhomelink" href="javascript:loadDialog('createreseacherstory','<?php echo $CFG->homeAddress; ?>ui/popups/quickformresearcher.php', 750,750);" title='<?php echo $LNG->HOMEPAGE_STORIES_HINT; ?>'><?php echo $LNG->HOMEPAGE_STORIES_LINK; ?></a>
				<?php } ?>
			</div>
		<?php } ?>

		<div style="clear:both; float: left;margin-top: 10px; width: 190px;">
			<h2 style="margin-bottom: 0px;font-size:12pt;"><?php echo $LNG->HOMEPAGE_TAG_TITLE_PART1.' '.$CFG->homeTagCount.' '.$LNG->HOMEPAGE_TAG_TITLE_PART2 ?></h2>
			<?php
				include($HUB_FLM->getCodeDirPath('ui/tagcloud.php'));
			?>
		</div>
	</div>
</div>
