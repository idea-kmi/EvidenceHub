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
    include_once("config.php");

    $me = substr($_SERVER["PHP_SELF"], 1); // remove initial '/'
    if ($HUB_FLM->hasCustomVersion($me)) {
    	$path = $HUB_FLM->getCodeDirPath($me);
    	include_once($path);
		die;
	}

    include_once($HUB_FLM->getCodeDirPath("core/utillib.php"));
    array_push($HEADER,'<script src="'.$HUB_FLM->getCodeWebPath('ui/exploreutils.js.php').'" type="text/javascript"></script>');

    include_once($HUB_FLM->getCodeDirPath("ui/header.php"));
    include_once($HUB_FLM->getCodeDirPath("ui/datamodel.js.php"));
    include_once($HUB_FLM->getCodeDirPath("ui/history.php"));
	include_once($HUB_FLM->getCodeDirPath("ui/networknavigationlib.php"));

    $nodeid = required_param("id",PARAM_TEXT);
    $searchid = optional_param("sid","",PARAM_TEXT);
	if ($searchid != "" && isset($USER->userid)) {
		auditSearchResult($searchid, $USER->userid, $nodeid, 'N');
	}

    $chatnodeid = optional_param("chatnodeid","",PARAM_TEXT);

    $node = getNode($nodeid);

    if($node instanceof Hub_Error){
        echo "<h1>".$LNG->ITEM_NOT_FOUND_ERROR."</h1>";
        include_once($HUB_FLM->getCodeDirPath("ui/footer.php"));
        die;
    }

    $nodetype = $node->role->name;

    $args = array();

    $args["nodeid"] = $nodeid;
    $args["nodetype"] = $nodetype;
    $args["title"] = $node->name;

	$CONTEXT = $CFG->NODE_CONTEXT;

   // now trigger the js to load data
    $argsStr = "{";
    $keys = array_keys($args);
    for($i=0;$i< count($keys); $i++){
        $argsStr .= '"'.$keys[$i].'":"'.addslashes($args[$keys[$i]]).'"';
        if ($i != (count($keys)-1)){
            $argsStr .= ',';
        }
    }
    $argsStr .= "}";

    echo "<script type='text/javascript'>";
    echo "var CONTEXT = '".$CONTEXT."';";
    echo "var NODE_ARGS = ".$argsStr.";";
	echo "var URL_ARGS = ".$argsStr.";";
	echo "var USER_ARGS = ".$argsStr.";";
	echo "var ORG_ARGS = ".$argsStr.";";
	echo "var CHALLENGE_ARGS = ".$argsStr.";";
	echo "var CLAIM_ARGS = ".$argsStr.";";
	echo "var ISSUE_ARGS = ".$argsStr.";";
	echo "var SOLUTION_ARGS = ".$argsStr.";";
	echo "var EVIDENCE_ARGS = ".$argsStr.";";
	echo "var CHATNODEID = '".$chatnodeid."';";
	echo "</script>";

	try {
		$jsonnode = json_encode($node);
	} catch (Exception $e) {
		echo 'Caught exception: ',  $e->getMessage(), "<br>";
	}

	echo "<script type='text/javascript'>";
	echo "var nodeObj = ";
	echo $jsonnode;
	echo ";";
	echo "</script>";
?>

<div class="container-fluid">
	<div class="row p-3">		
		<div class="col">
			<script type='text/javascript'>
				var chatstatusnodeid='<?php echo $nodeid; ?>';
				Event.observe(window, 'load', function() {
					<?php if (isset($USER->userid)) { ?>
						logChatUserArrive(chatstatusnodeid);
					<?php } ?>

					buildNodeTitle('chat');

					if (NODE_ARGS['nodetype'] == 'Challenge') {
						addScriptDynamically(URL_ROOT+"ui/explore/chat/challengechatstree.js.php", 'explore-chatchallengetree-script');
					} else if (NODE_ARGS['nodetype'] == 'Issue') {
						addScriptDynamically(URL_ROOT+"ui/explore/chat/issuechatstree.js.php", 'explore-issuechatstree-script');
					} else if (NODE_ARGS['nodetype'] == 'Claim') {
						addScriptDynamically(URL_ROOT+"ui/explore/chat/claimchatstree.js.php", 'explore-claimchatstree-script');
					} else if (NODE_ARGS['nodetype'] == 'Solution') {
						addScriptDynamically(URL_ROOT+"ui/explore/chat/solutionchatstree.js.php", 'explore-solutionchatstree-script');
					} else if (NODE_ARGS['nodetype'] == 'Organization') {
						addScriptDynamically(URL_ROOT+"ui/explore/chat/organizationchatstree.js.php", 'explore-organizationchatstree-script');
					} else if (NODE_ARGS['nodetype'] == 'Project') {
						addScriptDynamically(URL_ROOT+"ui/explore/chat/projectchatstree.js.php", 'explore-projectchatstree-script');
					} else if (EVIDENCE_TYPES_STR.indexOf(EVIDENCE_ARGS['nodetype']) != -1) {
						addScriptDynamically(URL_ROOT+"ui/explore/chat/evidencechatstree.js.php", 'explore-evidencechatstree-script');
					} else if (RESOURCE_TYPES_STR.indexOf(URL_ARGS['nodetype']) != -1) {
						addScriptDynamically(URL_ROOT+"ui/explore/chat/resourcechatstree.js.php", 'explore-resourcechatstree-script');
					} else if (NODE_ARGS['nodetype'] == 'Theme') {
						addScriptDynamically(URL_ROOT+"ui/explore/chat/themechatstree.js.php", 'explore-themechatstree-script');
					}

				});

				/**
				 * Refresh Chats sections after update.
				 */
				function refreshExploreChats() {
					getAllChatConnections();
				}
				function chatLeave() {
					<?php if (isset($USER->userid)) { ?>
					logChatUserLeave(chatstatusnodeid);
					<?php } ?>
					return;
				}
				window.onunload = window.onbeforeunload = (function(){chatLeave();});
			</script>

			<?php if ($nodetype == 'Challenge') { ?>
				<div id="nodearealineartitle" class="challengeback challengeborder nodearealineartitle">
					<div class="challengeback tabtitlebar">
						<label class="linearnodeheaderlabel", id="exploreheaderlabel">
						</label>
					</div>
				</div>
			<?php } else if ($nodetype == 'Issue') { ?>
				<div id="nodearealineartitle" class="issueback issueborder nodearealineartitle">
					<div class="issueback tabtitlebar">
						<label class="linearnodeheaderlabel", id="exploreheaderlabel">
						</label>
					</div>
				</div>
			<?php } else if ($nodetype == 'Claim') { ?>
				<div id="nodearealineartitle" class="claimback claimborder nodearealineartitle">
					<div class="claimback tabtitlebar">
						<label class="linearnodeheaderlabel", id="exploreheaderlabel">
						</label>
					</div>
				</div>
			<?php } else if ($nodetype == 'Solution') { ?>
				<div id="nodearealineartitle" class="solutionback solutionborder nodearealineartitle">
					<div class="solutionback tabtitlebar">
						<label class="linearnodeheaderlabel", id="exploreheaderlabel">
						</label>
					</div>
				</div>
			<?php } else if ($nodetype == 'Organization') { ?>
				<div id="nodearealineartitle" class="orgback orgborder nodearealineartitle">
					<div class="orgback tabtitlebar">
						<label class="linearnodeheaderlabel", id="exploreheaderlabel">
						</label>
					</div>
				</div>
			<?php } else if ($nodetype == 'Project') { ?>
				<div id="nodearealineartitle" class="projectback projectborder nodearealineartitle">
					<div class="projectback tabtitlebar">
						<label class="linearnodeheaderlabel", id="exploreheaderlabel">
						</label>
					</div>
				</div>
			<?php } else if (in_array($nodetype, $CFG->EVIDENCE_TYPES)) { //EVIDENCE ?>
				<div id="nodearealineartitle" class="evidenceback evidenceborder nodearealineartitle">
					<div class="evidenceback tabtitlebar">
						<label class="linearnodeheaderlabel", id="exploreheaderlabel">
						</label>
					</div>
				</div>
			<?php } else if (in_array($nodetype, $CFG->RESOURCE_TYPES)) { //RESOURCES ?>
				<div id="nodearealineartitle" class="resourceback resourceborder nodearealineartitle">
					<div class="resourceback tabtitlebar">
						<label class="linearnodeheaderlabel", id="exploreheaderlabel">
						</label>
					</div>
				</div>
			<?php } else if ($nodetype == 'Theme') { ?>
				<div id="nodearealineartitle" class="themeback themeborder nodearealineartitle">
					<div class="themeback tabtitlebar">
						<label class="linearnodeheaderlabel", id="exploreheaderlabel">
						</label>
					</div>
				</div>
			<?php } ?>

			<div class="p-1 border-bottom d-block">
				<div id="headertoolbar" class="d-block"></div>
			</div>

			<div id="tabber">
				<?php if ($nodetype == 'Challenge') { ?>
					<div id="tabs-content" class="tabcontentexplore" style="min-height:400px;">
				<?php } else if ($nodetype == 'Issue') { ?>
					<div id="tabs-content" class="tabcontentexplore" style="min-height:400px;">
				<?php } else if ($nodetype == 'Claim') { ?>
					<div id="tabs-content" class="tabcontentexplore" style="min-height:400px;">
				<?php } else if ($nodetype == 'Solution') { ?>
					<div id="tabs-content" class="tabcontentexplore" style="min-height:400px;">
				<?php } else if ($nodetype == 'Organization') { ?>
					<div id="tabs-content" class="tabcontentexplore" style="min-height:400px;">
				<?php } else if ($nodetype == 'Project') { ?>
					<div id="tabs-content" class="tabcontentexplore" style="min-height:400px;">
				<?php } else if (in_array($nodetype, $CFG->EVIDENCE_TYPES)) { //EVIDENCE ?>
					<div id="tabs-content" class="tabcontentexplore" style="min-height:400px;">
				<?php } else if (in_array($nodetype, $CFG->RESOURCE_TYPES)) { //RESOURCES ?>
					<div id="tabs-content" class="tabcontentexplore" style="min-height:400px;">
				<?php } else if ($nodetype == 'Theme') { ?>
					<div id="tabs-content" class="tabcontentexplore" style="min-height:400px;">
				<?php } ?>

				<!-- CHAT PAGE -->
				<div class="row">
					<div class="col-8">
						<div id='tab-content-explore-chat' class='explorepagesection'>						
							<h2 class="mt-3"><img src="<?php echo $HUB_FLM->getImagePath("chat.png"); ?>" alt="" /> <?php echo $LNG->VIEWS_CHAT_TITLE; ?></h2>
							<span id="chattoolbar" class="d-block"></span>
							<div id="chatloading" class="d-block"></div>
							<div id="chatarea" class="d-block"></div>
						</div>
					</div>
					<div class="col-4">
						<h2 class="mt-3"><?php echo $LNG->CHAT_USER_TITLE; ?></h2>
						<div id="current-chat-users"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php
    include_once($HUB_FLM->getCodeDirPath("ui/footer.php"));
?>
