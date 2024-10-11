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
 ?>


<div id="tagcloud" style="background:white;clear:both; float:left; width: 100%;">
	<ul>
	<?php
		$tags = array();
		$tags = getAllThemesForCloud();

		if (count($tags) > 0) {
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
				$cloudlistcolour = "";
				if ($i % 2) {
					$cloudlistcolour = "themecloudcolor1";
				} else {
					$cloudlistcolour = "themecloudcolor2";
				}
				$i++;

				$count = $tag['UseCount'];

				if ($count >= $minCount && $count < $minCount+$range) {
					echo '<li style="font-weight:bold;" class="tag1" title="'.$count.'"><a href="'.$CFG->homeAddress.'explore.php?id='.$tag['NodeID'].'" class="'.$cloudlistcolour.'">'.$tag['Name'].'</a></li>';
				} else if ($count >= $minCount+($range*1) && $count < $minCount+($range*2)) {
					echo '<li style="font-weight:bold;" class="tag2" title="'.$count.'"><a href="'.$CFG->homeAddress.'explore.php?id='.$tag['NodeID'].'" class="'.$cloudlistcolour.'">'.$tag['Name'].'</a></li>';
				} else if ($count >= $minCount+($range*2) && $count < $minCount+($range*3)) {
					echo '<li style="font-weight:bold;" class="tag3" title="'.$count.'"><a href="'.$CFG->homeAddress.'explore.php?id='.$tag['NodeID'].'" class="'.$cloudlistcolour.'">'.$tag['Name'].'</a></li>';
				} else if ($count >= $minCount+($range*3) && $count < $minCount+($range*4)) {
					echo '<li style="font-weight:bold;" class="tag4" title="'.$count.'"><a href="'.$CFG->homeAddress.'explore.php?id='.$tag['NodeID'].'" class="'.$cloudlistcolour.'">'.$tag['Name'].'</a></li>';
				} else if ($count >= $minCount+($range*4) && $count < $minCount+($range*5)) {
					echo '<li style="font-weight:bold;" class="tag5" title="'.$count.'"><a href="'.$CFG->homeAddress.'explore.php?id='.$tag['NodeID'].'" class="'.$cloudlistcolour.'">'.$tag['Name'].'</a></li>';
				} else if ($count >= $minCount+($range*5) && $count < $minCount+($range*6)) {
					echo '<li style="font-weight:bold;" class="tag6" title="'.$count.'"><a href="'.$CFG->homeAddress.'explore.php?id='.$tag['NodeID'].'" class="'.$cloudlistcolour.'">'.$tag['Name'].'</a></li>';
				} else if ($count >= $minCount+($range*6) && $count < $minCount+($range*7)) {
					echo '<li style="font-weight:bold;" class="tag7" title="'.$count.'"><a href="'.$CFG->homeAddress.'explore.php?id='.$tag['NodeID'].'" class="'.$cloudlistcolour.'">'.$tag['Name'].'</a></li>';
				} else if ($count >= $minCount+($range*7) && $count < $minCount+($range*8)) {
					echo '<li style="font-weight:bold;" class="tag8" title="'.$count.'"><a href="'.$CFG->homeAddress.'explore.php?id='.$tag['NodeID'].'" class="'.$cloudlistcolour.'">'.$tag['Name'].'</a></li>';
				} else if ($count >= $minCount+($range*8) && $count < $minCount+($range*9)) {
					echo '<li style="font-weight:bold;" class="tag9" title="'.$count.'"><a href="'.$CFG->homeAddress.'explore.php?id='.$tag['NodeID'].'" class="'.$cloudlistcolour.'">'.$tag['Name'].'</a></li>';
				} else if ($count >= $minCount+($range*9))  {
					echo '<li style="font-weight:bold;" class="tag10" title="'.$count.'"><a href="'.$CFG->homeAddress.'explore.php?id='.$tag['NodeID'].'" class="'.$cloudlistcolour.'">'.$tag['Name'].'</a></li>';
				}
			}
		}
	?>
	</ul>
</div>
