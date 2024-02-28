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
 ?>

<div id="tagcloud" style="clear:both; float:left; width: 100%;">
	<ul>
	<?php
		$tags = array();
		//$tags = getAllThemesForCloud();
		$ns = getNodesByGlobal(0,-1,'name','ASC', 'Theme', '', 'long',"",'all',false);
		$tags = $ns->nodes;


		if (count($tags) > 0) {

			// if any items have an image use different classes.
			$i = 0;
			$hasImages = false;
			foreach($tags as $tag) {
				if (isset($tag->imageurlid) && $tag->imageurlid != "") {
					$hasImages = true;
					break;
				}
			}

			foreach($tags as $tag) {
				/*$count = $tag['UseCount'];
				if ($count == 1) {
					$count = $count ." item";
				} else {
					$count = $count ." items";
				}*/

				$colour = "";
				$colourBorder="";
				$backcolor = "";

				if ($i == 0 || $i % 4 == 0) {
					$colour = "themelist1colour";
					$colourBorder="themelist1border";
					$backcolor = "themelist1back";
				} else if ($i == 1 || $i % 4 == 1) {
					$colour = "themelist2colour";
					$colourBorder="themelist2border";
					$backcolor = "themelist2back";
				} else if ($i == 2 || $i % 4 == 2) {
					$colour = "themelist3colour";
					$colourBorder="themelist3border";
					$backcolor = "themelist3back";
				} else if ($i == 3 || $i % 4 == 3) {
					$colour = "themelist4colour";
					$colourBorder="themelist4border";
					$backcolor = "themelist4back";
				}

				$i++;

				if ($hasImages) {
					$classes = $colour." ".$backcolor." ".$colourBorder." themelist";
					$classesOver = "themelist plainbackgradient plainback plainborder";
					$classes2 = $colour." themelistinner";
					$classes2Over = "themelistinner plainbackgradient";
				} else {
					$classes = $colour." ".$backcolor." ".$colourBorder." adminlist";
					$classesOver = "adminlist plainbackgradient plainback plainborder";
					$classes2 = $colour." adminlistinner";
					$classes2Over = "adminlistinner plainbackgradient";
				}

				echo '<div class="'.$classes.'" onclick="document.location.href=\''.$CFG->homeAddress.'explore.php?id='.$tag->nodeid.'\'" onmouseover="this.className=\''.$classesOver.'\';" onmouseout="this.className=\''.$classes.'\';" title="'.$LNG->THEMELIST_ITEM_HINT.' '.$LNG->THEME_NAME.'">';
				echo '<div class="'.$classes2.'" onclick="document.location.href=\''.$CFG->homeAddress.'explore.php?id='.$tag->nodeid.'\'" onmouseover="this.className=\''.$classes2Over.'\';" onmouseout="this.className=\''.$classes2.'\';">';
				echo '<table style="text-align:center;font-weight:bold;width:100%;height:100%" class="themebutton">';
				if (isset($tag->imageurlid) && $tag->imageurlid != "") {
					echo '<tr height="100px;"><td valign="top">';
					echo '<img class="themeimage" src="'.$tag->imageurlid.'" /></td></tr>';
					echo '<tr>';
					echo '<td valign="top">'.$tag->name.'</td>';
					echo '</tr>';
				} else {
					echo '<tr>';
					echo '<td valign="middle">'.$tag->name.'</td>';
					echo '</tr>';
				}

				echo '</table>';
				echo '</div>';

				echo '</div>';
			}
		}
	?>
	</ul>
</div>
