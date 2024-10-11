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
<script type="text/javascript">

var timerLeft;
var timerRight;
var timerStep = 4;

function scrollHistoryDivLeft() {
  	$('historyBarDiv').scrollLeft -= timerStep;
  	if ($('historyBarDiv').scrollLeft < ($('historyBar').offsetWidth-$('historyBarDiv').offsetWidth)) {
  		$('historyBarRightButton').src = "<?php echo $CFG->homeAddress; ?>images/forward-arrow2.png";
  	}
  	if ($('historyBarDiv').scrollLeft == 0) {
  		$('historyBarLeftButton').src = "<?php echo $CFG->homeAddress; ?>images/back-arrow-grey.png";
  		$('historyBarLeftButton').alt = "Scroll left";
		
  		stopScrollLeft();
  	}
	timerLeft = setTimeout('scrollHistoryDivLeft()', 20);
}

function scrollHistoryDivRight() {
  	$('historyBarDiv').scrollLeft += timerStep;
  	if ($('historyBarDiv').scrollLeft > 0) {
  		$('historyBarLeftButton').src = "<?php echo $CFG->homeAddress; ?>images/back-arrow2.png";
  		$('historyBarLeftButton').alt = "Scroll left";
  	}

  	if ($('historyBarDiv').scrollLeft >= ($('historyBar').offsetWidth-$('historyBarDiv').offsetWidth)) {
  		$('historyBarRightButton').src = "<?php echo $CFG->homeAddress; ?>images/forward-arrow-grey.png";
  		$('historyBarRightButton').alt = "Scroll right";
  		stopScrollRight();
	}
	timerRight = setTimeout('scrollHistoryDivRight()', 20);
}

function stopScrollLeft() {
	if (timerLeft) {
		clearTimeout(timerLeft);
	}
}

function stopScrollRight() {
	if (timerRight) {
		clearTimeout(timerRight);
	}
}

function resizeHistoryBar() {
	if ($('historyBarDiv')) {
		var width = getWindowWidth();
		console.log(width)
		$('historyBarDiv').style.width = "70%";
		$('historyBarDiv').scrollLeft = 0;

		if ($('historyBarDiv').scrollLeft >= ($('historyBar').offsetWidth-$('historyBarDiv').offsetWidth)) {
			$('historyBarRightButton').src = "<?php echo $CFG->homeAddress; ?>images/forward-arrow-grey.png";
  			$('historyBarRightButton').alt = "Scroll right";
		}
	}
}

function hideHistoryBar() {
	$('historybarcontent').style.display="none";
	$('historyhideshowbutton').src = '<?php echo $HUB_FLM->getImagePath("arrow-down2.png"); ?>';
	$('historyhideshowbutton').onclick = function () {javascript:showHistoryBar();}
	return true;
}

function showHistoryBar() {
	$('historybarcontent').style.display="block";
	$('historyhideshowbutton').src = '<?php echo $HUB_FLM->getImagePath("arrow-up2.png"); ?>';
	$('historyhideshowbutton').onclick = function () {javascript:hideHistoryBar();}
	return true;
}

Event.observe(window,"resize",resizeHistoryBar);

</script>

<div id="sidebar-content" class="sidebar-content row">
	<?php
		$items = array();
		if (isset($_SESSION['hubhistory'])) {
			foreach($_SESSION['hubhistory'] as $next) {
				$pos = strrpos( $next , '?id=');
				if ($pos == false) {
					$pos = strrpos( $next,'userid=');
					if ($pos !== false) {
						$posnext = strrpos($next, '&');
						if ($posnext ===  false || $posnext < $pos) {
							$userid = substr($next, $pos+7);
						} else {
							$userid = substr($next, $pos+7, ($posnext-($pos+7)));
						}
						$user = getUser($userid);
						if($user instanceof User){
							$items[count($items)] = $user;
						}
					}
				} else {
					$posnext = strrpos( $next , '&');
					if ($posnext ===  false || $posnext < $pos) {
						$nodeid = substr($next, $pos+4);
					} else {
						$nodeid = substr($next, $pos+4, ($posnext-($pos+4)));
					}
					$node = getNode($nodeid);
					$node->url = $next;
					if($node instanceof CNode){
						$items[count($items)] = $node;
					}
				}
			}
		}

		$count = count($items);

		if ($count > 0) {
			echo '<div class="col-12">
					<hr />
					<div class="row p-3">
						<div class="col">
							<h2>'.$LNG->SIDEBAR_TITLE.'</h2>
						</div>
					</div>
					<div class="row p-3 justify-content-between" id="historybarcontent">
						<div class="col-auto">
							<img class="mt-4" id="historyBarLeftButton" alt="Scroll left" onmouseover="scrollHistoryDivLeft()" onmouseout="stopScrollLeft()" src="'.$CFG->homeAddress.'images/back-arrow-grey.png" />
						</div>
						<div id="historyBarDiv" class="col-10 overflow-hidden">
							<div id="historyBar" style="width:'.((($count+1)*120.5)).'px;">';

								for ($i=0; $i<$count; $i++) {
									$next = $items[$i];
									if ($next instanceof CNode) {

										$text = $next->name;
										if (in_array($next->role->name, $CFG->RESOURCE_TYPES)) {
											$text = $next->description;
										}
										$hint = $text;

										if (strlen($text) > 45) {
											$text = substr($text,0,45)."...";
										}

										$url = $next->url;
										$viewtype = "";
										if (strpos($url, 'explore.php') !== FALSE) {
											$viewtype = $LNG->VIEWS_WIDGET_TITLE;;
										} if (strpos($url, 'chats.php') !== FALSE) {
											$viewtype = $LNG->VIEWS_CHAT_TITLE;
										} if (strpos($url, 'knowledgetrees.php') !== FALSE) {
											$viewtype = $LNG->VIEWS_LINEAR_TITLE;
										} if (strpos($url, 'networkgraph.php') !== FALSE) {
											$viewtype = $LNG->VIEWS_EVIDENCE_MAP_TITLE;
										}

										echo '<div class="history-item" >';
										if ($viewtype != "") {
											echo '<span class="history-title">'.$viewtype.': </span>';
										}
										echo '<a class="itemtext" title="'.$LNG->HISTORY_ITEM_HINT.' '.$viewtype.': '.$hint.'" href="'.$url.'">';
										if (isset($next->role->image) && $next->role->image != "") {
											echo '<img alt="'.$next->role->name.' icon" class="img-fluid" src="'.$CFG->homeAddress.$next->role->image.'" />';
										}
										echo '<span>'.$text.'</span></a>';
										echo '</div>';
									} else if ($next instanceof User) {
										echo '<div class="history-user" >';
										echo '<a class="itemtext" title="'.$LNG->HISTORY_ITEM_HINT.'" href="'.$CFG->homeAddress.'user.php?userid='.$next->userid.'">';
										if (isset($next->thumb) && $next->thumb != "") {
											echo '<img alt="'.$next->name.' profile picture" class="img-fluid" src="'.$next->thumb.'" />';
										}
										echo $next->name.'</a>';
										echo '</div>';
									}
								}
						echo '</div>
						</div>';

					echo '<div class="col-auto">';
						echo '<img class="mt-4" id="historyBarRightButton" onmouseover="scrollHistoryDivRight()" onmouseout="stopScrollRight()" src="'.$CFG->homeAddress.'images/forward-arrow2.png" alt="Scroll right" />';
					echo '</div>';

			echo '</div>'; // historybarcontent
		}
	?>
</div>
