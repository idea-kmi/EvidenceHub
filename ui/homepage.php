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
<div class="container-fluid">
	<div class="row">		
		<!-- LEFT COLUMN -->
		<div class="col-lg-9 col-md-12">
			<div class="row p-3">
				<div class="col">
					<h1><?php echo $LNG->HOMEPAGE_TITLE; ?></h1>
					<p>
						<?php echo $LNG->HOMEPAGE_FIRST_PARA; ?><br />
						<span id="homeintrobutton" class="active" onclick="if ($('homeintromore').style.display == 'none') { $('homeintromore').style.display = 'block'; $('homeintrobutton').innerHTML = '<?php echo $LNG->HOMEPAGE_READ_LESS; ?>'; } else { $('homeintromore').style.display = 'none';  $('homeintrobutton').innerHTML = '<?php echo $LNG->HOMEPAGE_KEEP_READING; ?>';}"><?php echo $LNG->HOMEPAGE_KEEP_READING; ?></span>
					</p>

					<div id="homeintromore" style="display:none;">
						<p><?php echo $LNG->HOMEPAGE_SECOND_PARA_PART2; ?></p>
						<p><?php echo $LNG->HOMEPAGE_CATEGORIES_CONNECT_MESSAGE; ?></p>
					</div>

					<?php if ($CFG->HAS_OPEN_COMMENTS) { ?>
						<p><?php echo $LNG->FORM_COMMENT_MESSAGE; ?></p>
						<?php if(isset($USER->userid)){ ?>
							<p>
								<a href="javascript:loadDialog('createcomment','<?php echo $CFG->homeAddress; ?>ui/popups/commentadd.php', 750,500);" title='<?php echo $LNG->TAB_ADD_COMMENT_HINT; ?>'><img src="<?php echo $HUB_FLM->getImagePath('add.png'); ?>" alt="" /> <?php echo $LNG->TAB_ADD_COMMENT_LINK; ?></a>
							</p>
						<?php } else {
							if ($CFG->signupstatus == $CFG->SIGNUP_OPEN) { ?>
								<p><strong><?php echo $LNG->TAB_COMMENT_MESSAGE_LOGGEDOUT_OPEN; ?></strong></p>
							<?php } else if ($CFG->signupstatus == $CFG->SIGNUP_REQUEST) { ?>
								<p><strong><?php echo $LNG->TAB_COMMENT_MESSAGE_LOGGEDOUT_REQUEST; ?></strong></p>
							<?php } else { ?>
								<p><strong><?php echo $LNG->TAB_COMMENT_MESSAGE_LOGGEDOUT_CLOSED; ?></strong></p>
							<?php } ?>
						<?php } ?>
					<?php } ?>
				</div>

				<div class="col-auto">
					<img src="<?php echo $HUB_FLM->getImagePath('jigsaw-image.png'); ?>" alt="" height="175" />
				</div>
			</div>

			<hr />

			<div class="row p-3">
				<h2><?php echo $LNG->HOMEPAGE_CATEGORIES_CONNECT_TITLE; ?> <span class="fs-6 text-dark"><?php echo $LNG->HOMEPAGE_CATEGORIES_CONNECT_HINT; ?></span></h2>
				<?php drawNetworkNavigationBarHome('none'); ?>
			</div>
			
			<hr />
			
			<div class="row p-3">
				<h2><?php echo $LNG->HOMEPAGE_THEME_TITLE; ?></h2>
				<?php include($HUB_FLM->getCodeDirPath('ui/themelist.php')); ?>
			</div>
			
			<hr />

			<div class="row p-3">
				<?php if (count($news) > 0) { ?>
					<div class="col">
						<h2><?php echo $LNG->HOME_MOSTRECENT_TITLE; ?></h2>
						<div id="tab-content-home-overview" class="tab-content-home-overview"></div>
					</div>
					<div class="col">
						<h2><?php echo $LNG->HOME_NEWS_TITLE; ?></h2>
						<div class="tab-content-home-news">
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

								echo '<p><strong><a href="'.$link.'" title="'.$title.'">'.$title.'</a></strong><br />';
								echo '<small><em>'.$LNG->NODE_NEWS_POSTED_ON.' '.$date.'</em></small></p>';
								echo '<p style="margin-bottom:20px;">'.$description.'</p>';
							}
							?>
						</div>
					</div>
				<?php } else { ?>
					<div class="col">
						<h2><?php echo $LNG->HOME_MOSTRECENT_TITLE; ?></h2>
						<div id="tab-content-home-overview" class="tab-content-home-overview"></div>
					</div>
				<?php } ?>
			</div>

			<hr />

			<div class="row p-3">
				<div class="col">
					<h2><?php echo $LNG->HOMEPAGE_GEOMAP_TITLE; ?> <span class="fs-6 text-dark"><?php echo $LNG->HOMEPAGE_GEOMAP_MESSAGE; ?></span></h2>
					<div class="active geomap-wrapper" onclick="setTabPushed($('tab-org-gmap-obj'),'org-gmap');" title="click to go to active view" style="background-image:url('<?php echo $HUB_FLM->getImagePath("bigmap.png"); ?>');"></div>
				</div>
			</div>
		</div>

		<!-- RIGHT COLUMN -->
		<div class="col-lg-3 col-md-12">
			<div class="mt-3 main-sidebar">
				<iframe width="100%" height="175" src="<?php echo $CFG->welcomeMovie; ?>" frameallowfullscreen></iframe>
				<div class="d-block">
					<?php echo $LNG->HOMEPAGE_QUICKGUIDE_LABEL; ?> <span><a href="/help/index.php" title="<?php echo $LNG->HOMEPAGE_QUICKGUIDE_HINT; ?>"><i><?php echo $LNG->HOMEPAGE_QUICKGUIDE_LINK; ?></i></a></span><span style="font-size: 10pt"></span>
				</div>

				<div class="d-block my-2">
					<h2 class="h5"><?php echo $LNG->HOMEPAGE_TOOLS_TITLE; ?></h2>
					<a href="<?php echo $CFG->homeAddress; ?>help/builderhelp.php" target="_blank"><?php echo $LNG->HOMEPAGE_TOOLS_LINK; ?></a>
					<?php if ($CFG->areStatsPublic || (isset($USER->userid) && $USER->getIsAdmin() == "Y")) { ?>
						<a href="<?php echo $CFG->homeAddress; ?>ui/stats/" target="_blank"><?php echo $LNG->HOMEPAGE_STATS_LINK; ?></a>
					<?php } ?>
				</div>

				<?php if ($CFG->hasStories) { ?>
					<div class="d-block my-2">
						<h2 class="h5"><?php echo $LNG->HOMEPAGE_STORIES_TITLE; ?></h2>
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

				<div class="d-block my-2">
					<h2 class="h5"><?php echo $LNG->HOMEPAGE_TAG_TITLE_PART1.' '.$CFG->homeTagCount.' '.$LNG->HOMEPAGE_TAG_TITLE_PART2 ?></h2>
					<?php
						include($HUB_FLM->getCodeDirPath('ui/tagcloud.php'));
					?>
				</div>
			</div>
		</div>
	</div>
</div>
