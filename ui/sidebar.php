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
  		stopScrollLeft();
  	}
	timerLeft = setTimeout('scrollHistoryDivLeft()', 20);
}

function scrollHistoryDivRight() {
  	$('historyBarDiv').scrollLeft += timerStep;
  	if ($('historyBarDiv').scrollLeft > 0) {
  		$('historyBarLeftButton').src = "<?php echo $CFG->homeAddress; ?>images/back-arrow2.png";
  	}

  	if ($('historyBarDiv').scrollLeft >= ($('historyBar').offsetWidth-$('historyBarDiv').offsetWidth)) {
  		$('historyBarRightButton').src = "<?php echo $CFG->homeAddress; ?>images/forward-arrow-grey.png";
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
		$('historyBarDiv').style.width = width-160+"px";
		$('historyBarDiv').scrollLeft = 0;

		if ($('historyBarDiv').scrollLeft >= ($('historyBar').offsetWidth-$('historyBarDiv').offsetWidth)) {
			$('historyBarRightButton').src = "<?php echo $CFG->homeAddress; ?>images/forward-arrow-grey.png";
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

<div id="sidebar-content">

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
	echo '<div style="float:left;clear:both;margin-left:15px;margin-top:10px;">';
	echo '<h2 style="margin:0px;">'.$LNG->SIDEBAR_TITLE;
	echo '</h2>';
	echo '</div>';

	echo '<div style="padding:0px; margin:0px;float:left;clear:both;padding:3px;margin-left:15px;margin-top:3px;" id="historybarcontent">';

	echo '<div style="clear:both;float:left;height:80px">';
	echo '<img style="margin-top:20px; margin-right:5px;" id="historyBarLeftButton" onmouseover="scrollHistoryDivLeft()" onmouseout="stopScrollLeft()" src="'.$CFG->homeAddress.'images/back-arrow-grey.png" />';
	echo '</div>';

	echo '<div id="historyBarDiv" style="width: 750px;overflow-x:hidden;overflow-y:hidden;height:90px;float:left;/*border: 2px solid lightgray;*/">';
	echo '<div id="historyBar" style="float:left;width:'.((($count+1)*120.5)).'px;">';

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

			echo '<div style="background: white;overflow:hidden;padding:5px;float:left;';
			echo 'border-right: 1px solid lightgray;';
			echo 'height:75px;width:120px;">';
			if ($viewtype != "") {
				echo '<span style="font-weight:bold; color:black;">'.$viewtype.': </span>';
			}
			echo '<a class="itemtext" title="'.$LNG->HISTORY_ITEM_HINT.' '.$viewtype.': '.$hint.'" href="'.$url.'">';
			if (isset($next->role->image) && $next->role->image != "") {
				echo '<img title="'.$next->role->name.'" style="width:20px;height:20px;margin-top:2px;padding-right:3px;" align="left" border="0" src="'.$CFG->homeAddress.$next->role->image.'" />';
			}
			echo '<span>'.$text.'</span></a>';
			echo '</div>';
		} else if ($next instanceof User) {
			echo '<div style="background: white;overflow:hidden;padding:5px;float:left;';
			echo 'border-right: 1px solid lightgray;';
			echo 'height:75px;width:120px;">';
			echo '<a class="itemtext" title="'.$LNG->HISTORY_ITEM_HINT.'" href="'.$CFG->homeAddress.'user.php?userid='.$next->userid.'">';
			if (isset($next->thumb) && $next->thumb != "") {
				echo '<img title="'.$next->name.'" style="margin-top:2px;padding-right:3px;" align="left" border="0" src="'.$next->thumb.'" />';
			}
			echo $next->name.'</a>';
			echo '</div>';
		}
	}
	echo '</div></div>';

	echo '<div style="float:left;height:80px">';
	echo '<img style="margin-left:5px;margin-top:20px;" id="historyBarRightButton" onmouseover="scrollHistoryDivRight()" onmouseout="stopScrollRight()" src="'.$CFG->homeAddress.'images/forward-arrow2.png" />';
	echo '</div>';


	echo '</div>'; // historybarcontent

/*
	echo '<div id="sidebar-header">';
	echo '<h2 style="font-size:11pt;margin-left:0px;margin-bottom:3px;">'.$LNG->SIDEBAR_TITLE.'</h2>';
	echo '</div>';

	//echo '<div id="sidebar-open" style="width: 10px;display:block"><img src="'.$HUB_FLM->getImagePath('arrow-right2.png').'" border="0" onclick="javascript:showSideBar();" /></div>';


	echo '<div id="sidebar-content" style="width:100%;height:80px;float:left;clear:both;padding:1px;margin-top:0px;">';

	echo '<div style="float:left;width:50px;height:70px;">';
	echo '<img style="margin-top:5px; margin-left:5px;margin-bottom:5px;" id="historyBarLeftButton" onmouseover="scrollHistoryDivUp()" onmouseout="stopScrollUp()" src="'.$HUB_FLM->getImagePath('left-arrow-grey.png').'" />';
	echo '</div>';

	echo '<div id="historyBarDiv" style="width: 100%;height:80px;overflow-x:hidden;overflow-y:hidden;float:left;border: 2px solid #D3D3D3">';
	echo '<div id="historyBar" style="float:left;height:'.((($count)*80)).'px;">';

	for ($i=0; $i<$count; $i++) {
		$next = $items[$i];
		if ($next instanceof CNode) {
			echo '<div style="background: white;overflow:hidden;padding:5px;float:left;';
			echo 'border-bottom: 1px solid #D3D3D3;';
			echo 'height:70px;width:110px;">';
			echo '<a class="itemtext" style="font-size:8pt" title="Click to explore" href="'.$CFG->homeAddress.'explore.php?id='.$next->nodeid.'">';
			if (isset($next->role->image) && $next->role->image != "") {
				echo '<img title="'.$next->role->name.'" style="width:20px;height:20px;margin-top:2px;padding-right:3px;" align="left" border="0" src="'.$CFG->homeAddress.$next->role->image.'" />';
			}
			echo $next->name.'</a>';
			echo '</div>';
		} else if ($next instanceof User) {
			echo '<div style="background: white;overflow:hidden;padding:5px;float:left;';
			echo 'border-bottom: 1px solid #D3D3D3;';
			echo 'height:70px;width:110px;">';
			echo '<a class="itemtext" style="font-size:8pt" title="Click to explore" href="'.$CFG->homeAddress.'user.php?userid='.$next->userid.'">';
			if (isset($next->thumb) && $next->thumb != "") {
				echo '<img title="'.$next->name.'" style="margin-top:2px;padding-right:3px;" align="left" border="0" src="'.$next->thumb.'" />';
			}
			echo $next->name.'</a>';
			echo '</div>';
		}
	}
	echo '</div></div>';

	echo '<div style="float:left;width:50px;height:70px">';
	echo '<img style="margin-left:45px;margin-top:5px;" id="historyBarRightButton" onmouseover="scrollHistoryDivDown()" onmouseout="stopScrollDown()" src="'.$HUB_FLM->getImagePath('right-arrow2.png').'" />';
	echo '</div>';
	echo '</div>';
*/
}
?>

</div>
