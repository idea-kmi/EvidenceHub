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
include_once($HUB_FLM->getCodeDirPath("ui/headerstats.php"));
//include_once($HUB_FLM->getCodeDirPath("core/statslib.php"));

global $CFG;

if(!$CFG->areStatsPublic && $USER->getIsAdmin() != "Y") {
	echo "<div class='errors'>".$LNG->FORM_ERROR_NOT_ADMIN."</div>";
	include_once($HUB_FLM->getCodeDirPath("ui/dialogfooter.php"));
	die;
}

$err = "";

$tag = getTagsForCloud(1);
$theme = getAllThemesForCloud(1);

$nodetypes = "";
$count = count($CFG->BASE_TYPES);
for($i=0; $i<$count; $i++){
	if ($CFG->BASE_TYPES[$i] != "Theme") {
		if ($i == 0) {
			$nodetypes .= "'".$CFG->BASE_TYPES[$i]."'";
		} else {
			$nodetypes .= ",'".$CFG->BASE_TYPES[$i]."'";
		}
	}
}
$count = count($CFG->EVIDENCE_TYPES);
for ($i=0; $i<$count; $i++) {
	$nodetypes .= ",'".$CFG->EVIDENCE_TYPES[$i]."'";
}
$count = count($CFG->RESOURCE_TYPES);
for ($i=0; $i<$count; $i++) {
	$nodetypes .= ",'".$CFG->RESOURCE_TYPES[$i]."'";
}
$count = count($CFG->COMMENT_TYPES);
for ($i=0; $i<$count; $i++) {
	$nodetypes .= ",'".$CFG->COMMENT_TYPES[$i]."'";
}

$nodetypes .= ",'Pro'";
$nodetypes .= ",'Con'";

// MOST USED LinkType
$linkData = getMostUsedLinkType();
$linkCount = 0;
$linkName = 'error';
if (count($linkData) > 1) {
	$linkCount = $linkData[0];
	$linkName = $linkData[1];
}

// MOST USED ROLE
$nodeTypeData = getMostUsedNodeType($nodetypes);
$roleCount = 0;
$roleName = 'error';
if (count($nodeTypeData) > 1) {
	$roleCount = $nodeTypeData[0];
	$roleName = $nodeTypeData[1];
}

/** MOST CONNECTED NODES - WITH PRIVACY CHECKING **/
$mostconidea = "";
$mostcontype = "";
$mostconideaCount = 0;

$mostConnArrray = getMostConnectedNode($nodetypes);
if (count($mostConnArrray) == 3) {
	$mostconidea = $mostConnArrray[0];
	$mostcontype = $mostConnArrray[1];
	$mostconideaCount = $mostConnArrray[2];
}

$reply = getLinkTypeUsage();
$linktypeUse = array();
$linktypeName = array();
if (count($reply) == 2) {
	$linktypeUse = $reply[0];
	$linktypeName = $reply[1];
}
?>

<script type="text/javascript">

function init() {
	loadActiveConnectionUsersStats();
	loadActiveIdeaUsersStats();
}

function loadActiveConnectionUsersStats() {
	var reqUrl = SERVICE_ROOT + "&method=getactiveconnectionusers&max=10";
	new Ajax.Request(reqUrl, { method:'get',
  			onSuccess: function(transport){
  				var json = transport.responseText.evalJSON();
      			if(json.error){
      				alert(json.error[0].message);
      				return;
      			}
      			var users = json.userset[0].users;
      			if(users.length > 0){
					var lOL = new Element("ol", {'class':'user-list-ol'});
					lOL.style.margin="0px";
					for(var i=0; i< users.length; i++){
						if(users[i].user){
							var iUL = new Element("li", {'id':users[i].user.userid, 'class':'user-list-li'});
							iUL.style.clear = "both";
							iUL.style.height="36px";
							lOL.insert(iUL);

							var user = users[i].user;

							if(user.isgroup == 'Y'){
								iUL.insert("<a style='float:left; padding-right: 3px;' href='group.php?groupid="+ user.userid +"'><img src='"+user.thumb+"' border='0' /></a>");
							} else {
								iUL.insert("<a style='float:left; padding-right: 3px;' href='user.php?userid="+ user.userid +"'><img src='"+user.thumb+"' border='0' /></a>")
							}

							if(user.isgroup == 'Y'){
								iUL.insert("<b style='float:left;'><a href='"+URL_ROOT+"group.php?groupid="+ user.userid +"'>" + user.name + "</a></b>");
							} else {
								iUL.insert("<b style='float:left;'><a href='"+URL_ROOT+"user.php?userid="+ user.userid +"'>" + user.name + "</a></b>");
							}
							iUL.insert("<br><span style='clear:top; font-size: 80%'>Connection count: "+user.connectioncount+"</span>");
						}
					}

					$('content-stats-users').insert(lOL);
      			}
      		}
      	});
}

function loadActiveIdeaUsersStats() {
	var reqUrl = SERVICE_ROOT + "&method=getactiveideausers&max=10";
	new Ajax.Request(reqUrl, { method:'get',
  			onSuccess: function(transport){
  				var json = transport.responseText.evalJSON();
      			if(json.error){
      				alert(json.error[0].message);
      				return;
      			}
      			var users = json.userset[0].users;
      			if(users.length > 0){
					var lOL = new Element("ol", {'class':'user-list-ol'});
					lOL.style.margin="0px";
					for(var i=0; i< users.length; i++){
						if(users[i].user){
							var iUL = new Element("li", {'id':users[i].user.userid, 'class':'user-list-li'});
							iUL.style.clear = "both";
							iUL.style.height="36px";
							lOL.insert(iUL);

							var user = users[i].user;

							if(user.isgroup == 'Y'){
								iUL.insert("<a style='float:left; padding-right: 3px;' href='group.php?groupid="+ user.userid +"'><img src='"+user.thumb+"' border='0' /></a>");
							} else {
								iUL.insert("<a style='float:left; padding-right: 3px;' href='user.php?userid="+ user.userid +"'><img src='"+user.thumb+"' border='0' /></a>")
							}

							if(user.isgroup == 'Y'){
								iUL.insert("<b style='float:left;'><a href='"+URL_ROOT+"group.php?groupid="+ user.userid +"'>" + user.name + "</a></b>");
							} else {
								iUL.insert("<b style='float:left;'><a href='"+URL_ROOT+"user.php?userid="+ user.userid +"'>" + user.name + "</a></b>");
							}
							iUL.insert("<br><span style='clear:top; font-size: 80%'>Idea count: "+user.ideacount+"</span>");
						}
					}
					$('content-stats-ideas').insert(lOL);
      			}
      		}
      	});
}

window.onload = init();


</script>

<div style="float:left;width:100%">

	<?php if ($err != "") {
		echo $err;
	}
	?>

	<?php if (isset($USER->userid)){
		echo "<h3>".$LNG->STATS_GLOBAL_OVERVIEW_YOUR_STATS_PART1." <a title='".$LNG->HEADER_USER_HOME_LINK_HINT."' href='".$CFG->homeAddress."user.php?userid=".$USER->userid."#home-list'>". $LNG->STATS_GLOBAL_OVERVIEW_YOUR_STATS_PART2 ."</a></h3>";
	} ?>

	<table cellspacing="5">
		<tr>
			<td width="25%"><b><?php echo $LNG->STATS_GLOBAL_OVERVIEW_HEADER_TYPE; ?></b></td>
			<td width="65%"><b><?php echo $LNG->STATS_GLOBAL_OVERVIEW_HEADER_NAME; ?></b></td>
			<td width="10%"><b><?php echo $LNG->STATS_GLOBAL_OVERVIEW_HEADER_COUNT; ?></b></td>
		</tr>
		<tr>
			<td colspan="3" valign="top" style="border-top: 1px solid #666666 "></td>
		</tr>
		<tr>
			<td><b><?php echo $LNG->STATS_GLOBAL_OVERVIEW_USED_LINKS_LABEL; ?></b></td>
			<td style="color: #666666 "><?php echo $linkName ?></td>
			<td><?php echo $linkCount ?></td>
		</tr>
		<tr>
			<td><b><?php echo $LNG->STATS_GLOBAL_OVERVIEW_USED_IDEAS_LABEL; ?></b></td>
			<td style="color: #666666 "><?php echo getNodeTypeText($roleName, false); ?></td>
			<td><?php echo $roleCount ?></td>
		</tr>
		<tr>
			<td><b><?php echo $LNG->STATS_GLOBAL_OVERVIEW_CONNECTED_IDEA_LABEL; ?></b></td>
			<td style="color: #666666 "><?php echo getNodeTypeText($mostcontype)." ".$mostconidea; ?></td>
			<td><?php echo $mostconideaCount ?></td>
		</tr>
		<tr>
			<td><b><?php echo $LNG->STATS_GLOBAL_OVERVIEW_USED_TAG_LABEL; ?></b></td>
			<td style="color: #666666 "><?php if (count($tag) > 0) { echo $tag[0]['Name'];} ?></td>
			<td><?php if (count($tag) > 0) { echo $tag[0]['UseCount'];} ?></td>
		</tr>
		<tr>
			<td><b><?php echo $LNG->STATS_GLOBAL_OVERVIEW_USED_THEME_LABEL; ?></b></td>
			<td style="color: #666666 "><?php if (count($theme) > 0) { echo $theme[0]['Name']; } ?></td>
			<td><?php if (count($theme) > 0) { echo $theme[0]['UseCount']; } ?></td>
		</tr>
	</table>

	<div style="clear: both; float: left; margin-top: 20px; margin-right: 30px; ">
		<div style="float: left;margin-right: 20px;">
		<div style="margin-bottom:10px; height: 20px; background:#F8EAF3; padding-left: 5px; padding-top: 4px; "><strong><?php echo $LNG->STATS_GLOBAL_OVERVIEW_TOP_CONN_BUILDERS; ?></strong></div>
		<div id="content-stats-users" style="border: 1px solid #d3e8e8; width: 320px; overflow: auto;"></div>
		</div>

		<div style="float: left;">
		<div style="margin-bottom:10px; height: 20px; background:#F8EAF3; padding-left: 5px; padding-top: 4px; "><strong><?php echo $LNG->STATS_GLOBAL_OVERVIEW_TOP_IDEA_CREATORS; ?></strong></div>
		<div id="content-stats-ideas" style="border: 1px solid #d3e8e8; width: 320px; overflow: auto;"></div>
		</div>
	</div>

	<div style="clear:both;"></div>

	<div style="margin-bottom:10px; margin-top:30px; height: 20px; background:#F8EAF3; padding-left: 5px; padding-top: 4px; "><strong><?php echo $LNG->STATS_GLOBAL_OVERVIEW_TOP_CONN_BUILDERS_LINKS; ?></strong></div>
	<div>
	<table border="1" cellspacing="2" cellpadding="3" style="border-collapse:collapse;" >
	<?php
		$count = count($linktypeUse);
		if ($count > 0) {
		    $headings = '<tr style="background-color: #308D88; color: white">';
			$main = "";
		    for ($i = 0; $i < $count; $i++) {
			    $main .= "<tr>";
			    $nextArray = $linktypeUse[$i];
		    	foreach ($nextArray as $key => $value) {
		    		if ($i==0) {
			    		$userid = str_replace("_", "", $key);
			    		if (isset($linktypeName[$userid])) {
							$name = $linktypeName[$userid];
						} else {
							$name = $key;
						}
			    	    $headings .= "<td>".$name."</td>";
			    	}

					$main .= '<td align="right">'.$value.'</td>';
				}
			    $main .= "</tr>";
		    }

		    $headings .= "</tr>";

		    echo $headings;
		    echo $main;
		}
	?>
	</table>
	</div>
</div>

</div>

<?php
	include_once($HUB_FLM->getCodeDirPath("ui/footerstats.php"));
?>