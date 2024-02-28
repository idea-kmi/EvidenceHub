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
	include_once("../../config.php");

	global $CFG;

	if($USER->getIsAdmin() == "Y") {
		include_once($HUB_FLM->getCodeDirPath("ui/headeradmin.php"));
	} else if($CFG->areStatsPublic) {
		include_once($HUB_FLM->getCodeDirPath("ui/headerstats.php"));
	} else {
		include_once($HUB_FLM->getCodeDirPath("ui/header.php"));
	}

	if(!$CFG->areStatsPublic && $USER->getIsAdmin() != "Y") {
		echo "<div class='alert alert-danger m-5'>".$LNG->FORM_ERROR_NOT_ADMIN."</div>";
		include_once($HUB_FLM->getCodeDirPath("ui/headerfooter.php"));
		die;
	}

	$tags = getTagsForCloud(-1, true);
	$tags2 = getTagsForCloud(-1, false);

?>

<?php
	if($CFG->areStatsPublic) {
		if (file_exists("menu.php") ) {
			include("menu.php");
		}
	} else if (!$CFG->areStatsPublic && $USER->getIsAdmin() == "Y") {
		if (file_exists("menu.php") ) {
			include("menu.php");
		}
	}
?>

<div class="container-fluid stats-newIdeas">
	<div class="border border-top-0 p-3 mx-4">
		<div class="row p-3">

			<div id="tagcloud" class="card shadow-sm mb-4">
				<div class="card-body">
					<ul>
						<?php
							if ($tags != null) {

								// get the count range first
								$minCount = -1;
								$maxCount = -1;
								foreach($tags as $tag) {
									$count = $tag['UseCount'];
									if ($count > $maxCount) {
										$maxCount = $count;
									}
									if ($minCount == -1) {
										$minCount = $count;
									} else if ($count < $minCount) {
										$minCount = $count;
									}
								}

								if ($maxCount < 10) {
									$range = 1;
								} else {
									$range = round(($maxCount - $minCount) / 10);
								}

								$i = 0;
								foreach($tags as $tag) {

									if (isset($tag['Name'])) {

										$cloudlistcolour = "";
										if ($i % 2) {
											$cloudlistcolour = "tagcloudcolor1";
										} else {
											$cloudlistcolour = "tagcloudcolor2";
										}
										$i++;

										$count = $tag['UseCount'];

										if ($count >= $minCount && $count < $minCount+$range) {
											echo '<li class="tag1" title="'.$count.'"><a href="'.$CFG->homeAddress.'search.php?q='.$tag['Name'].'&scope=all&tagsonly=true" class="'.$cloudlistcolour.'">'.$tag['Name'].'</a></li>';
										} else if ($count >= $minCount+($range*1) && $count < $minCount+($range*2)) {
											echo '<li class="tag2" title="'.$count.'"><a href="'.$CFG->homeAddress.'search.php?q='.$tag['Name'].'&scope=all&tagsonly=true" class="'.$cloudlistcolour.'">'.$tag['Name'].'</a></li>';
										} else if ($count >= $minCount+($range*2) && $count < $minCount+($range*3)) {
											echo '<li class="tag3" title="'.$count.'"><a href="'.$CFG->homeAddress.'search.php?q='.$tag['Name'].'&scope=all&tagsonly=true" class="'.$cloudlistcolour.'">'.$tag['Name'].'</a></li>';
										} else if ($count >= $minCount+($range*3) && $count < $minCount+($range*4)) {
											echo '<li class="tag4" title="'.$count.'"><a href="'.$CFG->homeAddress.'search.php?q='.$tag['Name'].'&scope=all&tagsonly=true" class="'.$cloudlistcolour.'">'.$tag['Name'].'</a></li>';
										} else if ($count >= $minCount+($range*4) && $count < $minCount+($range*5)) {
											echo '<li class="tag5" title="'.$count.'"><a href="'.$CFG->homeAddress.'search.php?q='.$tag['Name'].'&scope=all&tagsonly=true" class="'.$cloudlistcolour.'">'.$tag['Name'].'</a></li>';
										} else if ($count >= $minCount+($range*5) && $count < $minCount+($range*6)) {
											echo '<li class="tag6" title="'.$count.'"><a href="'.$CFG->homeAddress.'search.php?q='.$tag['Name'].'&scope=all&tagsonly=true" class="'.$cloudlistcolour.'">'.$tag['Name'].'</a></li>';
										} else if ($count >= $minCount+($range*6) && $count < $minCount+($range*7)) {
											echo '<li class="tag7" title="'.$count.'"><a href="'.$CFG->homeAddress.'search.php?q='.$tag['Name'].'&scope=all&tagsonly=true" class="'.$cloudlistcolour.'">'.$tag['Name'].'</a></li>';
										} else if ($count >= $minCount+($range*7) && $count < $minCount+($range*8)) {
											echo '<li class="tag8" title="'.$count.'"><a href="'.$CFG->homeAddress.'search.php?q='.$tag['Name'].'&scope=all&tagsonly=true" class="'.$cloudlistcolour.'">'.$tag['Name'].'</a></li>';
										} else if ($count >= $minCount+($range*8) && $count < $minCount+($range*9)) {
											echo '<li class="tag9" title="'.$count.'"><a href="'.$CFG->homeAddress.'search.php?q='.$tag['Name'].'&scope=all&tagsonly=true" class="'.$cloudlistcolour.'">'.$tag['Name'].'</a></li>';
										} else if ($count >= $minCount+($range*9))  {
											echo '<li class="tag10" title="'.$count.'"><a href="'.$CFG->homeAddress.'search.php?q='.$tag['Name'].'&scope=all&tagsonly=true" class="'.$cloudlistcolour.'">'.$tag['Name'].'</a></li>';
										}
									}
								}
							}
						?>
					</ul>
				</div>
			</div>


			<div>
				<table class="table table-sm table-striped w-25">
					<?php
						if ($tags2 != null) {
							$i = 0;
							foreach($tags2 as $tag) {

								if (isset($tag['Name'])) {
									$i++;
									$count = $tag['UseCount'];
									echo '<tr><td><a href="'.$CFG->homeAddress.'search.php?q='.$tag['Name'].'&scope=all&tagsonly=true">'.$tag['Name'].'</a></td><td>'.$count.'</td></tr>';
								}
							}
						}
					?>
				</table>
			</div>
		</div>
	</div>
</div>

<?php
	include_once($HUB_FLM->getCodeDirPath("ui/footerstats.php"));
?>