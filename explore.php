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

    array_push($HEADER,'<script src="'.$HUB_FLM->getCodeWebPath('ui/exploreutils.js.php').'" type="text/javascript"></script>');

    include_once($HUB_FLM->getCodeDirPath("core/utillib.php"));
    include_once($HUB_FLM->getCodeDirPath("ui/header.php"));
    include_once($HUB_FLM->getCodeDirPath("ui/datamodel.js.php"));
    include_once($HUB_FLM->getCodeDirPath("ui/history.php"));
	include_once($HUB_FLM->getCodeDirPath("ui/networknavigationlib.php"));

    $nodeid = required_param("id",PARAM_TEXT);
    $searchid = optional_param("sid","",PARAM_TEXT);
	if ($searchid != "" && isset($USER->userid)) {
		auditSearchResult($searchid, $USER->userid, $nodeid, 'N');
	}

    $node = getNode($nodeid);

    if($node instanceof Hub_Error){
        echo "<h1>".$LNG->ITEM_NOT_FOUND_ERROR."</h1>";
        include_once($HUB_FLM->getCodeDirPath("ui/footer.php"));
        die;
    }

	$tags = "";
	if (isset($node->tags)) {
		$nodetags = $node->tags;
		$i=0;
		foreach ($nodetags as $tag) {
			if ($i = 0) {
				$tags .= $tag->name;
			} else {
				$tags .= ",".$tag->name;
			}
			$i++;
		}
	}

    $nodetype = $node->role->name;

    $args = array();

    $args["nodeid"] = $nodeid;
    $args["nodetype"] = $nodetype;
    $args["title"] = $node->name;
    $args["tags"] = $tags;

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

<script type='text/javascript'>

Event.observe(window, 'load', function() {

	if (NODE_ARGS['nodetype'] == 'Challenge') {
		addScriptDynamically('<?php echo $HUB_FLM->getCodeWebPath("ui/explore/widget/challengenode.js.php"); ?>', 'explore-challengenode-script');
	} else if (NODE_ARGS['nodetype'] == 'Issue') {
		addScriptDynamically('<?php echo $HUB_FLM->getCodeWebPath("ui/explore/widget/issuenode.js.php"); ?>', 'explore-issuenode-script');
	} else if (NODE_ARGS['nodetype'] == 'Claim') {
		addScriptDynamically('<?php echo $HUB_FLM->getCodeWebPath("ui/explore/widget/claimnode.js.php"); ?>', 'explore-claimnode-script');
	} else if (NODE_ARGS['nodetype'] == 'Solution') {
		addScriptDynamically('<?php echo $HUB_FLM->getCodeWebPath("ui/explore/widget/solutionnode.js.php"); ?>', 'explore-solutionnode-script');
	} else if (NODE_ARGS['nodetype'] == 'Organization') {
		addScriptDynamically('<?php echo $HUB_FLM->getCodeWebPath("ui/explore/widget/organizationnode.js.php"); ?>', 'explore-organizationnode-script');
	} else if (NODE_ARGS['nodetype'] == 'Project') {
		addScriptDynamically('<?php echo $HUB_FLM->getCodeWebPath("ui/explore/widget/projectnode.js.php"); ?>', 'explore-projectnode-script');
	} else if (EVIDENCE_TYPES_STR.indexOf(EVIDENCE_ARGS['nodetype']) != -1) {
		addScriptDynamically('<?php echo $HUB_FLM->getCodeWebPath("ui/explore/widget/evidencenode.js.php"); ?>', 'explore-evidencenode-script');
	} else if (RESOURCE_TYPES_STR.indexOf(URL_ARGS['nodetype']) != -1) {
		addScriptDynamically('<?php echo $HUB_FLM->getCodeWebPath("ui/explore/widget/resourcenode.js.php"); ?>', 'explore-resourcenode-script');
	} else if (NODE_ARGS['nodetype'] == 'Theme') {
		addScriptDynamically('<?php echo $HUB_FLM->getCodeWebPath("ui/explore/widget/themenode.js.php"); ?>', 'explore-themenode-script');
	} else if (NODE_ARGS['nodetype'] == 'News') {
		addScriptDynamically('<?php echo $HUB_FLM->getCodeWebPath("ui/explore/widget/newsnode.js.php"); ?>', 'explore-newsnode-script');
	}
});

/**
 * Refresh widget Challenges sections after update.
 * @param nodetofocusid the id of a node in the results list to focus on.
 */
function refreshExploreChallenges(nodetofocusid) {
	refreshWidgetChallenges(nodetofocusid);
}

/**
 * Refresh widget Issues sections after update.
 * @param nodetofocusid the id of a node in the results list to focus on.
 */
function refreshExploreIssues(nodetofocusid) {
	refreshWidgetIssues(nodetofocusid);
}

/**
 * Refresh widget Solutions sections after update.
 * @param nodetofocusid the id of a node in the results list to focus on.
 */
function refreshExploreSolutions(nodetofocusid) {
	refreshWidgetSolutions(nodetofocusid);
}

/**
 * Refresh widget Claims sections after update.
 * @param nodetofocusid the id of a node in the results list to focus on.
 */
function refreshExploreClaims(nodetofocusid) {
	refreshWidgetClaims(nodetofocusid);
}

/**
 * Refresh widget Evidence sections after update.
 * @param nodetofocusid the id of a node in the results list to focus on.
 */
function refreshExploreEvidence(nodetofocusid, type) {
	refreshWidgetEvidence(nodetofocusid, type);
}

/**
 * Refresh widget Resource sections after update.
 * @param nodetofocusid the id of a node in the results list to focus on.
 */
function refreshExploreResources(nodetofocusid) {
	refreshWidgetResources(nodetofocusid);
}

/**
 * Refresh widget Organizations sections after update.
 * @param nodetofocusid the id of a node in the results list to focus on.
 */
function refreshExploreOrganizations(nodetofocusid) {
	refreshWidgetOrganizations(nodetofocusid);
}

/**
 * Refresh widget Projects sections after update.
 * @param nodetofocusid the id of a node in the results list to focus on.
 */
function refreshExploreProjects(nodetofocusid) {
	refreshWidgetProjects(nodetofocusid);
}

/**
 * Refresh widget Partners sections after update.
 * @param nodetofocusid the id of a node in the results list to focus on.
 */
function refreshExplorePartners(nodetofocusid) {
	refreshWidgetPartners(nodetofocusid);
}

/**
 * Refresh widget Themes sections after update.
 * @param nodetofocusid the id of a node in the results list to focus on.
 */
function refreshExploreThemes() {
	refreshWidgetThemes();
}

/**
 * Refresh widget Comments sections after update.
 * @param nodetofocusid the id of a node in the results list to focus on.
 */
function refreshExploreComments() {
	refreshWidgetComments();
}

/**
 * Refresh linear and widget Followers sections after update.
 * @param nodetofocusid the id of a node in the results list to focus on.
 */
function refreshExploreFollowers() {
	refreshWidgetFollowers();
}

</script>

<?php if ($nodetype == 'Challenge') { ?>
	<!-- div style="float:left;clear:both;">
		<a style="float:left;margin:5px;margin-right:10px;" href="<?php echo $CFG->homeAddress; ?>index.php?#challenge-list"><img src="<?php echo $HUB_FLM->getImagePath('arrow-left2.png'); ?>" border="0" class="active" style="margin-right: 5px;" title="<?php echo $LNG->CHALLENGE_HOME_LIST_BUTTON_HINT; ?>" /></a>
		<span style="float:left;margin:5px;margin-right:20px;"><?php echo $LNG->VIEWS_WIDGET_TITLE;?></span>
		<a style="float:left;margin:5px;margin-right:20px;" href="<?php echo $CFG->homeAddress; ?>chats.php?id=<?php echo $nodeid; ?>"><?php echo $LNG->VIEWS_CHAT_TITLE;?></a>
		<a style="float:left;margin:5px;margin-right:20px;" href="<?php echo $CFG->homeAddress; ?>knowledgetrees.php?id=<?php echo $nodeid; ?>"><?php echo $LNG->VIEWS_LINEAR_TITLE;?></a>
		<a style="float:left;margin:5px;" href="<?php echo $CFG->homeAddress; ?>networkgraph.php?id=<?php echo $nodeid; ?>"><?php echo $LNG->VIEWS_EVIDENCE_MAP_TITLE;?></a>
	</div -->
<?php } else if ($nodetype == 'Issue') { ?>
	<!-- div style="float:left;clear:both;">
		<a style="float:left;margin:5px;margin-right:10px;" href="<?php echo $CFG->homeAddress; ?>index.php?#issue-list"><img src="<?php echo $HUB_FLM->getImagePath('arrow-left2.png'); ?>" border="0" class="active" style="margin-right: 5px;" title="<?php echo $LNG->ISSUE_HOME_LIST_BUTTON_HINT; ?>" /></a>
		<span style="float:left;margin:5px;margin-right:20px;"><?php echo $LNG->VIEWS_WIDGET_TITLE;?></span>
		<a style="float:left;margin:5px;margin-right:20px;" href="<?php echo $CFG->homeAddress; ?>chats.php?id=<?php echo $nodeid; ?>"><?php echo $LNG->VIEWS_CHAT_TITLE;?></a>
		<a style="float:left;margin:5px;margin-right:20px;" href="<?php echo $CFG->homeAddress; ?>knowledgetrees.php?id=<?php echo $nodeid; ?>"><?php echo $LNG->VIEWS_LINEAR_TITLE;?></a>
		<a style="float:left;margin:5px;" href="<?php echo $CFG->homeAddress; ?>networkgraph.php?id=<?php echo $nodeid; ?>"><?php echo $LNG->VIEWS_EVIDENCE_MAP_TITLE;?></a>
	</div -->
<?php } else if ($nodetype == 'Claim') { ?>
	<!-- div style="float:left;clear:both;">
		<a style="float:left;margin:5px;margin-right:10px;" href="<?php echo $CFG->homeAddress; ?>index.php?#claim-list"><img src="<?php echo $HUB_FLM->getImagePath('arrow-left2.png'); ?>" border="0" class="active" style="margin-right: 5px;" title="<?php echo $LNG->CLAIM_HOME_LIST_BUTTON_HINT; ?>" /></a>
		<span style="float:left;margin:5px;margin-right:20px;"><?php echo $LNG->VIEWS_WIDGET_TITLE;?></span>
		<a style="float:left;margin:5px;margin-right:20px;" href="<?php echo $CFG->homeAddress; ?>chats.php?id=<?php echo $nodeid; ?>"><?php echo $LNG->VIEWS_CHAT_TITLE;?></a>
		<a style="float:left;margin:5px;margin-right:20px;" href="<?php echo $CFG->homeAddress; ?>knowledgetrees.php?id=<?php echo $nodeid; ?>"><?php echo $LNG->VIEWS_LINEAR_TITLE;?></a>
		<a style="float:left;margin:5px;" href="<?php echo $CFG->homeAddress; ?>networkgraph.php?id=<?php echo $nodeid; ?>"><?php echo $LNG->VIEWS_EVIDENCE_MAP_TITLE;?></a>
	</div -->
<?php } else if ($nodetype == 'Solution') { ?>
	<!-- div style="float:left;clear:both;">
		<a style="float:left;margin:5px;margin-right:10px;" href="<?php echo $CFG->homeAddress; ?>index.php?#solution-list"><img src="<?php echo $HUB_FLM->getImagePath('arrow-left2.png'); ?>" border="0" class="active" style="margin-right: 5px;" title="<?php echo $LNG->SOLUTION_HOME_LIST_BUTTON_HINT; ?>" /></a>
		<span style="float:left;margin:5px;margin-right:20px;"><?php echo $LNG->VIEWS_WIDGET_TITLE;?></span>
		<a style="float:left;margin:5px;margin-right:20px;" href="<?php echo $CFG->homeAddress; ?>chats.php?id=<?php echo $nodeid; ?>"><?php echo $LNG->VIEWS_CHAT_TITLE;?></a>
		<a style="float:left;margin:5px;margin-right:20px;" href="<?php echo $CFG->homeAddress; ?>knowledgetrees.php?id=<?php echo $nodeid; ?>"><?php echo $LNG->VIEWS_LINEAR_TITLE;?></a>
		<a style="float:left;margin:5px;" href="<?php echo $CFG->homeAddress; ?>networkgraph.php?id=<?php echo $nodeid; ?>"><?php echo $LNG->VIEWS_EVIDENCE_MAP_TITLE;?></a>
	</div -->
<?php } else if ($nodetype == 'Organization') { ?>
	<!-- div style="float:left;clear:both;">
		<a style="float:left;margin:5px;margin-right:10px;" href="<?php echo $CFG->homeAddress; ?>index.php?#org-list"><img src="<?php echo $HUB_FLM->getImagePath('arrow-left2.png'); ?>" border="0" class="active" style="margin-right: 5px;" title="<?php echo $LNG->ORG_HOME_LIST_BUTTON_HINT; ?>" /></a>
		<span style="float:left;margin:5px;margin-right:20px;"><?php echo $LNG->VIEWS_WIDGET_TITLE;?></span>
		<a style="float:left;margin:5px;margin-right:20px;" href="<?php echo $CFG->homeAddress; ?>chats.php?id=<?php echo $nodeid; ?>"><?php echo $LNG->VIEWS_CHAT_TITLE;?></a>
		<a style="float:left;margin:5px;" href="<?php echo $CFG->homeAddress; ?>networkgraph.php?id=<?php echo $nodeid; ?>"><?php echo $LNG->VIEWS_EVIDENCE_MAP_TITLE;?></a>
	</div -->
<?php } else if ($nodetype == 'Project') { ?>
	<!-- div style="float:left;clear:both;">
		<a style="float:left;margin:5px;margin-right:10px;" href="<?php echo $CFG->homeAddress; ?>index.php?#project-list"><img src="<?php echo $HUB_FLM->getImagePath('arrow-left2.png'); ?>" border="0" class="active" style="margin-right: 5px;" title="<?php echo $LNG->PROJECT_HOME_LIST_BUTTON_HINT; ?>" /></a>
		<span style="float:left;margin:5px;margin-right:20px;"><?php echo $LNG->VIEWS_WIDGET_TITLE;?></span>
		<a style="float:left;margin:5px;margin-right:20px;" href="<?php echo $CFG->homeAddress; ?>chats.php?id=<?php echo $nodeid; ?>"><?php echo $LNG->VIEWS_CHAT_TITLE;?></a>
		<a style="float:left;margin:5px;" href="<?php echo $CFG->homeAddress; ?>networkgraph.php?id=<?php echo $nodeid; ?>"><?php echo $LNG->VIEWS_EVIDENCE_MAP_TITLE;?></a>
	</div -->
<?php } else if (in_array($nodetype, $CFG->EVIDENCE_TYPES)) { //EVIDENCE ?>
	<!-- div style="float:left;clear:both;">
		<a style="float:left;margin:5px;margin-right:10px;" href="<?php echo $CFG->homeAddress; ?>index.php?#evidence-list"><img src="<?php echo $HUB_FLM->getImagePath('arrow-left2.png'); ?>" border="0" class="active" style="margin-right: 5px;" title="<?php echo $LNG->EVIDENCE_HOME_LIST_BUTTON_HINT; ?>" /></a>
		<span style="float:left;margin:5px;margin-right:20px;"><?php echo $LNG->VIEWS_WIDGET_TITLE;?></span>
		<a style="float:left;margin:5px;margin-right:20px;" href="<?php echo $CFG->homeAddress; ?>chats.php?id=<?php echo $nodeid; ?>"><?php echo $LNG->VIEWS_CHAT_TITLE;?></a>
		<a style="float:left;margin:5px;margin-right:20px;" href="<?php echo $CFG->homeAddress; ?>knowledgetrees.php?id=<?php echo $nodeid; ?>"><?php echo $LNG->VIEWS_LINEAR_TITLE;?></a>
		<a style="float:left;margin:5px;" href="<?php echo $CFG->homeAddress; ?>networkgraph.php?id=<?php echo $nodeid; ?>"><?php echo $LNG->VIEWS_EVIDENCE_MAP_TITLE;?></a>
	</div -->
<?php } else if (in_array($nodetype, $CFG->RESOURCE_TYPES)) { //RESOURCES ?>
	<!-- div style="float:left;clear:both;">
		<a style="float:left;margin:5px;margin-right:10px;" href="<?php echo $CFG->homeAddress; ?>index.php?#web-list"><img src="<?php echo $HUB_FLM->getImagePath('arrow-left2.png'); ?>" border="0" class="active" style="" title="<?php echo $LNG->RESOURCE_HOME_LIST_BUTTON_HINT; ?>" /></a>
		<span style="float:left;margin:5px;margin-right:20px;"><?php echo $LNG->VIEWS_WIDGET_TITLE;?></span>
		<a style="float:left;margin:5px;margin-right:20px;" href="<?php echo $CFG->homeAddress; ?>chats.php?id=<?php echo $nodeid; ?>"><?php echo $LNG->VIEWS_CHAT_TITLE;?></a>
		<a style="float:left;margin:5px;margin-right:20px;" href="<?php echo $CFG->homeAddress; ?>knowledgetrees.php?id=<?php echo $nodeid; ?>"><?php echo $LNG->VIEWS_LINEAR_TITLE;?></a>
		<a style="float:left;margin:5px;" href="<?php echo $CFG->homeAddress; ?>networkgraph.php?id=<?php echo $nodeid; ?>"><?php echo $LNG->VIEWS_EVIDENCE_MAP_TITLE;?></a>
	</div -->
<?php } else if ($nodetype == 'Theme') { ?>
	<!-- div style="float:left;clear:both;">
		<a style="float:left;margin-right:5px;margin-top:3px;" href="<?php echo $CFG->homeAddress; ?>index.php?#home-list"><img src="<?php echo $HUB_FLM->getImagePath('arrow-left2.png'); ?>" border="0" class="active" style="margin-right: 5px;" title="<?php echo $LNG->HOME_PAGE_BUTTON_HINT; ?>" /></a>
		<span style="float:left;margin:5px;margin-right:20px;"><?php echo $LNG->VIEWS_WIDGET_TITLE;?></span>
		<a style="float:left;margin:5px;margin-right:20px;" href="<?php echo $CFG->homeAddress; ?>chats.php?id=<?php echo $nodeid; ?>"><?php echo $LNG->VIEWS_CHAT_TITLE;?></a>
		<a style="float:left;margin:5px;" href="<?php echo $CFG->homeAddress; ?>networkgraph.php?id=<?php echo $nodeid; ?>"><?php echo $LNG->VIEWS_EVIDENCE_MAP_TITLE;?></a>
	</div -->
<?php } ?>

<div id="tabber" style="clear:both;float:left;width:100%">

	<?php if ($nodetype == 'Challenge') { ?>
	    <div id="tabs-content" class="tabcontentexplore " style="min-height:400px;">
	<?php } else if ($nodetype == 'Issue') { ?>
	    <div id="tabs-content" class="tabcontentexplore " style="min-height:400px;">
	<?php } else if ($nodetype == 'Claim') { ?>
	    <div id="tabs-content" class="tabcontentexplore " style="min-height:400px;">
	<?php } else if ($nodetype == 'Solution') { ?>
	    <div id="tabs-content" class="tabcontentexplore " style="min-height:400px;">
	<?php } else if ($nodetype == 'Organization') { ?>
	    <div id="tabs-content" class="tabcontentexplore " style="min-height:400px;">
	<?php } else if ($nodetype == 'Project') { ?>
	    <div id="tabs-content" class="tabcontentexplore " style="min-height:400px;">
	<?php } else if (in_array($nodetype, $CFG->EVIDENCE_TYPES)) { //EVIDENCE ?>
	    <div id="tabs-content" class="tabcontentexplore " style="min-height:400px;">
	<?php } else if (in_array($nodetype, $CFG->RESOURCE_TYPES)) { //RESOURCES ?>
	    <div id="tabs-content" class="tabcontentexplore " style="min-height:400px;">
	<?php } else if ($nodetype == 'Theme') { ?>
	    <div id="tabs-content" class="tabcontentexplore " style="min-height:400px;">
	<?php } else if ($nodetype == 'News') { ?>
	    <div id="tabs-content" class="tabcontentexplore " style="min-height:400px;">
	<?php } ?>

	<!-- WIDGET PAGES -->
       	<div id='tab-content-explore-widget' class='explorepagesection' style="display:block">

			<?php if ($nodetype == 'Challenge') { ?>
				<div id="widgetareadiv" class="challengebackpale" style="clear:both; float:left;width:100%;padding:0px;">
					<table id="widgettable" style="display:block" width="100%" class="widgettable challengebackpale" cellspacing="5">
						<tr>
							<td id="widgetcolnode" width="60%" valign="top">
								<div id="nodearea" class="tabletop" style="display:block"></div>
							</td>
							<td id="widgetcolright" width="40%" valign="top">
								<div id="chatearea" class="tabletop" style="display: block;">
									<button onclick="location.href='<?php echo $CFG->homeAddress ?>chats.php?id=<?php echo $nodeid; ?>';" id="chatbutton" title="<?php echo $LNG->VIEWS_CHAT_HINT;?>" class="challengebackgradient2 active" onmouseover="$('chatbutton').className = 'challengebackgradient active';" onmouseout="$('chatbutton').className = 'challengebackgradient2 active';" style="height:40px; width:100%;">
										<div style="float:left;"><img src="<?php echo $HUB_FLM->getImagePath("chat.png"); ?>" border="0" /></div>
										<div class="homebutton1" style="margin-left:20px; margin-top:7px;float:left;font-size:12pt;font-weight:bold;">Chats</div>
									</button>
								</div>
								<div class="tabletop" id="issuesarea">
									<table style="border-collapse:collapse;cellpadding:0px;">
										<tr>
											<td width="10px;" valign="middle">
												<img src="<?php echo $HUB_FLM->getImagePath('neutral_arrow_sm.png'); ?>" border="0" />
											</td>
											<td width="96%">
												<div id="issuesareainner" style="display: block;"></div>
											</td>
										</tr>
									</table>
								</div>
							</td>
						</tr>
					</table>
					<table id="widgetextrastable" style="display:block" width="100%" class="widgettable challengebackpale" cellspacing="5">
						<tr>
							<td width="33%" valign="top">
								<div id="dataarea" class="tabletop" style="float:left;display:block;padding:0px;"><h2 style="margin-bottom:2px;"><?php echo $LNG->EXPLORE_WIDGET_EXTRAS; ?></h2></div>
								<div id="themearea" class="tablelower" style="display:block"></div>
								<div id="seealsoarea" class="tablelower" style="display: block;"></div>
								<div id="followersarea" class="tablelower" style="display:block"></div>
							</td>
							<td width="33%" valign="top">
								<div id="extraarea" class="tabletop" style="float:left;display:block;padding:0px;"><h2 style="margin-bottom:2px;"><?php echo $LNG->EXPLORE_WIDGET_ADDITIONAL_RELATIONS_HEADING; ?></h2></div>
								<div id="orgsarea" class="tablelower" style="display: block;"></div>
								<div id="projectsarea" class="tablelower" style="display: block;"></div>
							</td>
							<?php if ($CFG->hasRecommendations) { ?>
							<td width="33%" valign="top">
								<div id="recommendationarea" class="tabletop" style="float:left;display:block;padding:0px;"><h2 style="margin-bottom:2px;"><?php echo $LNG->EXPLORE_WIDGET_RECOMMENDATIONS_HEADING; ?></h2></div>
								<div id="suggestedorgsarea" class="tablelower" style="display:block"></div>
								<div id="suggestedissuesarea" class="tablelower" style="display:block;"></div>
							</td>
							<?php } ?>
						</tr>
					</table>
				</div>
			<?php } else if ($nodetype == 'Issue') { ?>
				<div id="widgetareadiv" class="issuebackpale" style="clear:both; float:left;width:100%;">
					<table id="widgettable" style="display:block" width="100%" class="widgettable issuebackpale" cellspacing="5">
						<tr width="100%" style="width:100%">
							<?php if ($CFG->HAS_CHALLENGE) { ?>
							<td id="widgetcolleft" width="30%" valign="top">
								<div id="chatearea" class="tabletop" style="display: block;">
									<button onclick="location.href='<?php echo $CFG->homeAddress ?>chats.php?id=<?php echo $nodeid; ?>';" id="chatbutton" title="<?php echo $LNG->VIEWS_CHAT_HINT;?>" class="issuebackgradient2 active" onmouseover="$('chatbutton').className = 'issuebackgradient active';" onmouseout="$('chatbutton').className = 'issuebackgradient2 active';" style="height:40px; width:100%;">
										<div style="float:left;"><img src="<?php echo $HUB_FLM->getImagePath("chat.png"); ?>" border="0" /></div>
										<div class="homebutton1" style="margin-left:20px; margin-top:7px;float:left;font-size:12pt;font-weight:bold;">Chats</div>
									</button>
								</div>
								<div id="challengesarea" class="tablelower">
									<table style="border-collapse:collapse;cellpadding:0px;">
										<tr>
											<td width="100%">
												<div id="challengesareainner" style="display: block;"></div>
											</td>
											<td width="10px;" valign="middle">
												<img src="<?php echo $HUB_FLM->getImagePath('neutral_arrow_sm.png'); ?>" border="0" />
											</td>
										</tr>
									</table>
								</div>
							</td>
							<?php } ?>

							<td <?php if (!$CFG->HAS_CHALLENGE) { echo 'colspan="2" width="70%"'; } else { echo 'width="40%"'; }?> id="widgetcolnode" valign="top">
								<div id="nodearea" class="tabletop" style="display:block"></div>
							</td>

							<td id="widgetcolright" width="30%" valign="top">
								<?php if (!$CFG->HAS_CHALLENGE) { ?>
								<div id="chatearea" class="tabletop" style="display: block;">
									<button onclick="location.href='<?php echo $CFG->homeAddress ?>chats.php?id=<?php echo $nodeid; ?>';" id="chatbutton" title="<?php echo $LNG->VIEWS_CHAT_HINT;?>" class="issuebackgradient2 active" onmouseover="$('chatbutton').className = 'issuebackgradient active';" onmouseout="$('chatbutton').className = 'issuebackgradient2 active';" style="height:40px; width:100%;">
										<div style="float:left;"><img src="<?php echo $HUB_FLM->getImagePath("chat.png"); ?>" border="0" /></div>
										<div class="homebutton1" style="margin-left:20px; margin-top:7px;float:left;font-size:12pt;font-weight:bold;">Chats</div>
									</button>
								</div>
								<?php } ?>
								<?php if ($CFG->HAS_SOLUTION) { ?>
									<div id="solutionsarea" class="<?php if (!$CFG->HAS_CHALLENGE) { echo 'tablelower'; } else { echo 'tabletop'; }?>" style="float:left;display:block;height:100%">
										<table style="border-collapse:collapse;cellpadding:0px;" style="height:100%">
											<tr>
												<td width="10px;" valign="middle">
													<img src="<?php echo $HUB_FLM->getImagePath('neutral_arrow_sm.png'); ?>" border="0" />
												</td>
												<td width="96%">
													<div id="solutionsareainner" style="display: block;"></div>
												</td>
											</tr>
										</table>
									</div>
								<?php } ?>
								<?php if ($CFG->HAS_CLAIM) { ?>
									<div id="claimsarea" style="width:100%" class="<?php if ($CFG->HAS_CLAIM && !$CFG->HAS_SOLUTION && $CFG->HAS_CHALLENGE){ echo 'tabletop'; } else { echo 'tablelower'; } ?>">
										<table style="border-collapse:collapse;cellpadding:0px;">
											<tr>
												<td width="10px;" valign="middle">
													<img src="<?php echo $HUB_FLM->getImagePath('neutral_arrow_sm.png'); ?>" border="0" />
												</td>
												<td width="96%">
													<div id="claimsareainner" style="display: block;"></div>
												</td>
											</tr>
										</table>
									</div>
								<?php } ?>
							</td>
						</tr>
					</table>
					<table id="widgetextrastable" style="display:block" width="100%" class="widgettable" cellspacing="5">
						<tr>
							<td width="33%" valign="top">
								<div id="dataarea" class="tabletop" style="float:left;display:block;padding:0px;"><h2 style="margin-bottom:2px;"><?php echo $LNG->EXPLORE_WIDGET_EXTRAS; ?></h2></div>

								<div id="themearea" class="tablelower" style="display:block"></div>
								<div id="seealsoarea" class="tablelower" style="display: block;"></div>
								<div id="followersarea" class="tablelower" style="display:block"></div>
							</td>
							<td width="33%" valign="top">
								<div id="extraarea" class="tabletop" style="float:left;display:block;padding:0px;"><h2 style="margin-bottom:2px;"><?php echo $LNG->EXPLORE_WIDGET_ADDITIONAL_RELATIONS_HEADING; ?></h2></div>

								<div id="orgsarea" class="tablelower" style="display:block"></div>
								<div id="projectsarea" class="tablelower" style="display:block"></div>
							</td>
							<?php if ($CFG->hasRecommendations) { ?>
							<td width="33%" valign="top">
								<div id="recommendationarea" class="tabletop" style="float:left;display:block;padding:0px;"><h2 style="margin-bottom:2px;"><?php echo $LNG->EXPLORE_WIDGET_RECOMMENDATIONS_HEADING; ?></h2></div>

								<div id="suggestedorgsarea" class="tablelower" style="display:block"></div>
								<?php if ($CFG->HAS_SOLUTION) { ?>
								<div id="suggestedsolutionsarea" class="tablelower" style="display: block;"></div>
								<?php } ?>
								<?php if ($CFG->HAS_CLAIM) { ?>
								<div id="suggestedclaimsarea" class="tablelower" style="display: block;"></div>
								<?php } ?>
								<div id="tagsissuesarea" class="tablelower" style="display:block"></div>
							</td>
							<?php } ?>
						</tr>
					</table>
				</div>
			<?php } else if ($nodetype == 'Claim') { ?>
				<div id="widgetareadiv" class="claimbackpale" style="clear:both; float:left;width:100%;">
					<table id="widgettable" style="display:block" width="100%" class="widgettable claimbackpale" cellspacing="5">
						<tr>
							<td id="widgetcolleft" width="30%" valign="top">
								<div id="chatearea" class="tabletop" style="display: block;">
									<button onclick="location.href='<?php echo $CFG->homeAddress ?>chats.php?id=<?php echo $nodeid; ?>';" id="chatbutton" title="<?php echo $LNG->VIEWS_CHAT_HINT;?>" class="claimbackgradient2 active" onmouseover="$('chatbutton').className = 'claimbackgradient active';" onmouseout="$('chatbutton').className = 'claimbackgradient2 active';" style="height:40px; width:100%;">
										<div style="float:left;"><img src="<?php echo $HUB_FLM->getImagePath("chat.png"); ?>" border="0" /></div>
										<div class="homebutton1" style="margin-left:20px; margin-top:7px;float:left;font-size:12pt;font-weight:bold;">Chats</div>
									</button>
								</div>
								<div class="tablelower" id="issuesarea">
									<table style="border-collapse:collapse;cellpadding:0px;">
										<tr>
											<td width="96%">
												<div id="issuesareainner" style="display: block;"></div>
											</td>
											<td width="10px;" valign="middle">
												<img src="<?php echo $HUB_FLM->getImagePath('neutral_arrow_sm.png'); ?>" border="0" />
											</td>
										</tr>
									</table>
								</div>
							</td>
							<td id="widgetcolnode" width="40%" valign="top">
								<div id="nodearea" class="tabletop" style="display: block;"></div>
							</td>
							<td id="widgetcolright" width="30%" valign="top">
								<div class="tabletop" id="prosarea">
									<table style="border-collapse:collapse;cellpadding:0px;">
										<tr>
											<td width="10px;" valign="middle">
												<img src="<?php echo $HUB_FLM->getImagePath('positive_arrow_sm.png'); ?>" border="0" />
											</td>
											<td width="96%">
												<div id="prosareainner" style="display: block;"></div>
											</td>
										</tr>
									</table>
								</div>
								<div class="tablelower" id="consarea">
									<table style="border-collapse:collapse;cellpadding:0px;">
										<tr>
											<td width="10px;" valign="middle">
												<img src="<?php echo $HUB_FLM->getImagePath('negative_arrow_sm.png'); ?>" border="0" />
											</td>
											<td width="96%">
												<div id="consareainner" style="display: block;"></div>
											</td>
										</tr>
									</table>
								</div>
							</td>
						</tr>
					</table>
					<table id="widgetextrastable" style="display:block" width="100%" class="widgettable claimbackpale" cellspacing="5">
						<tr>
							<td width="33%" valign="top">
								<div id="dataarea" class="tabletop" style="float:left;display:block;padding:0px;"><h2 style="margin-bottom:2px;"><?php echo $LNG->EXPLORE_WIDGET_EXTRAS; ?></h2></div>
								<div id="themearea" class="tablelower" style="display: block;"></div>
								<div id="seealsoarea" class="tablelower" style="display: block;"></div>
								<div id="followersarea" class="tablelower" style="display:block"></div>
							</td>
							<td width="33%" valign="top">
								<div id="extraarea" class="tabletop" style="float:left;display:block;padding:0px;"><h2 style="margin-bottom:2px;"><?php echo $LNG->EXPLORE_WIDGET_ADDITIONAL_RELATIONS_HEADING; ?></h2></div>
								<div id="orgsarea" class="tablelower" style="display: block;"></div>
								<div id="projectsarea" class="tablelower" style="display: block;"></div>
							</td>
							<?php if ($CFG->hasRecommendations) { ?>
							<td width="33%" valign="top">
								<div id="recommendationarea" class="tabletop" style="float:left;display:block;padding:0px;"><h2 style="margin-bottom:2px;"><?php echo $LNG->EXPLORE_WIDGET_RECOMMENDATIONS_HEADING; ?></h2></div>
								<div id="suggestedorgsarea" class="tablelower" style="display: block;"></div>
								<div id="suggestedissuesarea" class="tablelower" style="display: block;"></div>
							</td>
							<?php } ?>
						</tr>
					</table>
				</div>
			<?php } else if ($nodetype == 'Solution') { ?>
				<div id="widgetareadiv" class="solutionbackpale" style="clear:both; float:left;width:100%;">
					<table id="widgettable" style="display:block" width="100%" class="widgettable solutionbackpale" cellspacing="5">
						<tr>
							<td id="widgetcolleft" width="30%" valign="top">
								<div id="chatearea" class="tabletop" style="display: block;">
									<button onclick="location.href='<?php echo $CFG->homeAddress ?>chats.php?id=<?php echo $nodeid; ?>';" id="chatbutton" title="<?php echo $LNG->VIEWS_CHAT_HINT;?>" class="solutionbackgradient2 active" onmouseover="$('chatbutton').className = 'solutionbackgradient active';" onmouseout="$('chatbutton').className = 'solutionbackgradient2 active';" style="height:40px; width:100%;">
										<div style="float:left;"><img src="<?php echo $HUB_FLM->getImagePath("chat.png"); ?>" border="0" /></div>
										<div class="homebutton1" style="margin-left:20px; margin-top:7px;float:left;font-size:12pt;font-weight:bold;">Chats</div>
									</button>
								</div>
								<div class="tablelower" id="issuesarea">
									<table style="border-collapse:collapse;cellpadding:0px;">
										<tr>
											<td width="96%">
												<div id="issuesareainner" style="display: block;"></div>
											</td>
											<td width="10px;" valign="middle">
												<img src="<?php echo $HUB_FLM->getImagePath('neutral_arrow_sm.png'); ?>" border="0" />
											</td>
										</tr>
									</table>
								</div>
							</td>
							<td id="widgetcolnode" width="40%" valign="top">
								<div id="nodearea" class="tabletop" style="display: block;"></div>
							</td>
							<td id="widgetcolright" width="30%" valign="top">
								<div class="tabletop" id="prosarea">
									<table style="border-collapse:collapse;cellpadding:0px;">
										<tr>
											<td width="10px;" valign="middle">
												<img src="<?php echo $HUB_FLM->getImagePath('positive_arrow_sm.png'); ?>" border="0" />
											</td>
											<td width="96%">
												<div id="prosareainner" style="display: block;"></div>
											</td>
										</tr>
									</table>
								</div>
								<div class="tablelower" id="consarea">
									<table style="border-collapse:collapse;cellpadding:0px;">
										<tr>
											<td width="10px;" valign="middle">
												<img src="<?php echo $HUB_FLM->getImagePath('negative_arrow_sm.png'); ?>" border="0" />
											</td>
											<td width="96%">
												<div id="consareainner" style="display: block;"></div>
											</td>
										</tr>
									</table>
								</div>
							</td>
						</tr>
					</table>

					<table id="widgetextrastable" style="display:block" width="100%" class="widgettable solutionbackpale" cellspacing="5">
						<tr>
							<td width="33%" valign="top">
								<div id="dataarea" class="tabletop" style="float:left;display:block;padding:0px;"><h2 style="margin-bottom:2px;"><?php echo $LNG->EXPLORE_WIDGET_EXTRAS; ?></h2></div>
								<div id="themearea" class="tablelower" style="display: block;"></div>
								<div id="seealsoarea" class="tablelower" style="display: block;"></div>
								<div id="followersarea" class="tablelower" style="display:block"></div>
							</td>
							<td width="33%" valign="top">
								<div id="extraarea" class="tabletop" style="float:left;display:block;padding:0px;"><h2 style="margin-bottom:2px;"><?php echo $LNG->EXPLORE_WIDGET_ADDITIONAL_RELATIONS_HEADING; ?></h2></div>
								<div id="orgsarea" class="tablelower" style="display: block;"></div>
								<div id="projectsarea" class="tablelower" style="display: block;"></div>
							</td>
							<?php if ($CFG->hasRecommendations) { ?>
							<td width="33%" valign="top">
								<div id="recommendationarea" class="tabletop" style="float:left;display:block;padding:0px;"><h2 style="margin-bottom:2px;"><?php echo $LNG->EXPLORE_WIDGET_RECOMMENDATIONS_HEADING; ?></h2></div>
								<div id="suggestedorgsarea" class="tablelower" style="display: block;"></div>
								<div id="suggestedissuesarea" class="tablelower" style="display: block;"></div>
							</td>
							<?php } ?>
						</tr>
					</table>
				</div>
			<?php } else if (in_array($nodetype, $CFG->EVIDENCE_TYPES)) { //EVIDENCE ?>
				<div id="widgetareadiv" class="evidencebackpale" style="clear:both; float:left;width:100%;">

					<table id="widgettable" style="clear:both;display:block" width="100%" class="widgettable evidencebackpale" cellspacing="5">
						<tr>
							<td id="widgetcolleft" width="30%" valign="top">
								<div id="chatearea" class="tabletop" style="display: block;">
									<button onclick="location.href='<?php echo $CFG->homeAddress ?>chats.php?id=<?php echo $nodeid; ?>';" id="chatbutton" title="<?php echo $LNG->VIEWS_CHAT_HINT;?>" class="evidencebackgradient2 active" onmouseover="$('chatbutton').className = 'evidencebackgradient active';" onmouseout="$('chatbutton').className = 'evidencebackgradient2 active';" style="height:40px; width:100%;">
										<div style="float:left;"><img src="<?php echo $HUB_FLM->getImagePath("chat.png"); ?>" border="0" /></div>
										<div class="homebutton1" style="margin-left:20px; margin-top:7px;float:left;font-size:12pt;font-weight:bold;">Chats</div>
									</button>
								</div>
								<?php if ($CFG->HAS_SOLUTION) { ?>
									<div id="solutionsarea" class="tablelower">
										<table style="border-collapse:collapse;cellpadding:0px;">
											<tr>
												<td width="96%">
													<div id="solutionsareainner" style="display: block;"></div>
												</td>
												<td width="10px;" valign="middle">
													<img src="<?php echo $HUB_FLM->getImagePath('neutral_arrow_sm.png'); ?>" border="0" />
												</td>
											</tr>
										</table>
									</div>
								<?php } ?>
								<?php if ($CFG->HAS_CLAIM) { ?>
									<div id="claimsarea" class="tablelower">
										<table style="border-collapse:collapse;cellpadding:0px;">
											<tr>
												<td width="96%">
													<div id="claimsareainner" style="display: block;"></div>
												</td>
												<td width="10px;" valign="middle">
													<img src="<?php echo $HUB_FLM->getImagePath('neutral_arrow_sm.png'); ?>" border="0" />
												</td>
											</tr>
										</table>
									</div>
								<?php } ?>
							</td>
							<td id="widgetcolnode" width="40%" valign="top">
								<div id="nodearea" class="tabletop" style="display: block;"></div>
							</td>
							<td id="widgetcolright" width="30%" valign="top">
								<div id="websitesarea" class="tabletop">
									<table style="border-collapse:collapse;cellpadding:0px;">
										<tr>
											<td width="10px;" valign="middle">
												<img src="<?php echo $HUB_FLM->getImagePath('neutral_arrow_sm.png'); ?>" border="0" />
											</td>
											<td width="96%">
												<div id="websitesareainner" style="display: block;"></div>
											</td>
										</tr>
									</table>
								</div>
							</td>
						</tr>
					</table>
					<table id="widgetextrastable" style="display:block" width="100%" class="widgettable evidencebackpale" cellspacing="5">
						<tr>
							<td width="33%" valign="top">
								<div id="dataarea" class="tabletop" style="float:left;display:block;padding:0px;"><h2 style="margin-bottom:2px;"><?php echo $LNG->EXPLORE_WIDGET_EXTRAS; ?></h2></div>
								<div id="themearea" class="tablelower" style="display: block;"></div>
								<div id="seealsoarea" class="tablelower" style="display: block;"></div>
								<div id="followersarea" class="tablelower" style="display:block"></div>
							</td>
							<td width="33%" valign="top">
								<div id="extraarea" class="tabletop" style="float:left;display:block;padding:0px;"><h2 style="margin-bottom:2px;"><?php echo $LNG->EXPLORE_WIDGET_ADDITIONAL_RELATIONS_HEADING; ?></h2></div>
								<div id="orgsarea" class="tablelower" style="display: block;"></div>
								<div id="projectsarea" class="tablelower" style="display: block;"></div>
							</td>
							<?php if ($CFG->hasRecommendations) { ?>
							<td width="33%" valign="top">
								<div id="recommendationarea" class="tabletop" style="float:left;display:block;padding:0px;"><h2 style="margin-bottom:2px;"><?php echo $LNG->EXPLORE_WIDGET_RECOMMENDATIONS_HEADING; ?></h2></div>
								<div id="suggestedorgsarea" class="tablelower" style="display: block;"></div>
								<div id="suggestedissuesarea" class="tablelower" style="display: block;"></div>
								<?php if ($CFG->HAS_SOLUTION) { ?>
									<div id="suggestedsolutionsarea" class="tablelower" style="display: block;"></div>
								<?php } ?>
								<?php if ($CFG->HAS_CLAIM) { ?>
									<div id="suggestedclaimsarea" class="tablelower" style="display: block;"></div>
								<?php } ?>
							</td>
							<?php } ?>
						</tr>
					</table>
				</div>
			<?php } else if (in_array($nodetype, $CFG->RESOURCE_TYPES)) { //RESOURCES ?>
				<div id="widgetareadiv" class="resourcebackpale" style="clear:both; float:left;width:100%;">
					<table id="widgettable" style="display:block" width="100%" class="widgettable resourcebackpale" cellspacing="5" border="0">
						<tr>
							<td id="widgetcolleft" width="40%" valign="top">
								<div id="chatearea" class="tabletop" style="display: block;">
									<button onclick="location.href='<?php echo $CFG->homeAddress ?>chats.php?id=<?php echo $nodeid; ?>';" id="chatbutton" title="<?php echo $LNG->VIEWS_CHAT_HINT;?>" class="resourcebackgradient2 active" onmouseover="$('chatbutton').className = 'resourcebackgradient active';" onmouseout="$('chatbutton').className = 'resourcebackgradient2 active';" style="height:40px; width:100%;">
										<div style="float:left;"><img src="<?php echo $HUB_FLM->getImagePath("chat.png"); ?>" border="0" /></div>
										<div class="homebutton1" style="margin-left:20px; margin-top:7px;float:left;font-size:12pt;font-weight:bold;">Chats</div>
									</button>		
								</div>
								<div class="tablelower" id="evidencesarea">
									<table style="border-collapse:collapse;cellpadding:0px;">
										<tr>
											<td width="96%">
												<div id="evidencesareainner" style="display: block;"></div>
											</td>
											<td width="10px;" valign="middle">
												<img src="<?php echo $HUB_FLM->getImagePath('neutral_arrow_sm.png'); ?>" border="0" />
											</td>
										</tr>
									</table>
								</div>
							</td>
							<td id="widgetcolnode" width="60%" valign="top">
								<div id="nodearea" class="tabletop" style="display: block;"></div>
							</td>
						</tr>
					</table>
					<table id="widgetextrastable" style="display:block" width="100%" class="widgettable resourcebackpale" cellspacing="5">
						<tr>
							<td width="33%" valign="top">
								<div id="dataarea" class="tabletop" style="float:left;display:block;padding:0px;"><h2 style="margin-bottom:2px;"><?php echo $LNG->EXPLORE_WIDGET_EXTRAS; ?></h2></div>
								<div id="themearea" class="tablelower" style="display: block;"></div>
								<div id="seealsoarea" class="tablelower" style="display: block;"></div>
								<div id="followersarea" class="tablelower" style="display:block"></div>
							</td>
							<td width="33%" valign="top">
								<div id="extraarea" class="tabletop" style="float:left;display:block;padding:0px;"><h2 style="margin-bottom:2px;"><?php echo $LNG->EXPLORE_WIDGET_ADDITIONAL_RELATIONS_HEADING; ?></h2></div>
								<div id="orgsarea" class="tablelower" style="display: block;"></div>
								<div id="projectsarea" class="tablelower" style="display: block;"></div>
								<div id="relatedresourcesarea" class="tablelower" style="display: block;"></div>
							</td>
							<?php if ($CFG->hasRecommendations) { ?>
							<td width="33%" valign="top">
								<div id="recommendationarea" class="tabletop" style="float:left;display:block;padding:0px;"><h2 style="margin-bottom:2px;"><?php echo $LNG->EXPLORE_WIDGET_RECOMMENDATIONS_HEADING; ?></h2></div>
								<div id="suggestedorgsarea" class="tablelower" style="display: block;"></div>
								<div id="suggestedissuesarea" class="tablelower" style="display: block;"></div>
								<?php if ($CFG->HAS_SOLUTION) { ?>
									<div id="suggestedsolutionsarea" class="tablelower" style="display: block;"></div>
								<?php } ?>
								<?php if ($CFG->HAS_CLAIM) { ?>
									<div id="suggestedclaimsarea" class="tablelower" style="display: block;"></div>
								<?php } ?>
							</td>
							<?php } ?>
						</tr>
					</table>
				</div>
			<?php } else if ($nodetype == 'Organization') { ?>
				<div id="widgetareadiv" class="orgbackpale" style="clear:both; float:left;width:100%;">
					<table id="widgettable" style="display:block" width="100%" class="widgettable orgbackpale" cellspacing="5">
						<tr>
							<td id="widgetcolnode" width="50%" valign="top">
								<div id="nodearea" class="tabletop" style="display: block;"></div>
							</td>
							<td id="widgetcolright" width="50%" valign="top">
								<div id="chatearea" class="tabletop" style="display: block;">
									<button onclick="location.href='<?php echo $CFG->homeAddress ?>chats.php?id=<?php echo $nodeid; ?>';" id="chatbutton" title="<?php echo $LNG->VIEWS_CHAT_HINT;?>" class="orgbackgradient2 active" onmouseover="$('chatbutton').className = 'orgbackgradient active';" onmouseout="$('chatbutton').className = 'orgbackgradient2 active';" style="height:40px; width:100%;">
										<div style="float:left;"><img src="<?php echo $HUB_FLM->getImagePath("chat.png"); ?>" border="0" /></div>
										<div class="homebutton1" style="margin-left:20px; margin-top:7px;float:left;font-size:12pt;font-weight:bold;">Chats</div>
									</button>
								</div>
								<div id="extraarea" class="tablelower" style="float:left;display:block;padding:0px;"><h2 style="margin-bottom:2px;"><?php echo $LNG->EXPLORE_WIDGET_ADDITIONAL_RELATIONS_HEADING; ?></h2></div>

								<div id="websitesarea" class="tablelower" style="display: block;"></div>
								<div id="partnersarea" class="tablelower" style="display: block;"></div>
								<div id="projectsarea" class="tablelower" style="display: block;"></div>

								<?php if ($CFG->HAS_CHALLENGE) { ?>
									<div id="challengesarea" class="tablelower" style="display: block;"></div>
								<?php }  ?>
								<div id="issuesarea" class="tablelower" style="display: block;"></div>
								<?php if ($CFG->HAS_CLAIM) { ?>
									<div id="claimsarea" class="tablelower" style="display: block;"></div>
								<?php } ?>
								<?php if ($CFG->HAS_SOLUTION) { ?>
									<div id="solutionsarea" class="tablelower" style="display: block;"></div>
								<?php } ?>
								<div id="evidencearea" class="tablelower" style="display: block;"></div>
							</td>
						</tr>
					</table>
					<?php if ($CFG->hasRecommendations) { ?>
						<table id="widgetextrastable" style="display:block" width="100%" class="widgettable orgbackpale" cellspacing="5">
					<?php } else { ?>
						<table id="widgetextrastable" style="display:block" width="50%" class="widgettable orgbackpale" cellspacing="5">
					<?php }?>
						<tr>
							<td width="50%" valign="top">
								<div id="dataarea" class="tabletop" style="float:left;display:block;padding:0px;"><h2 style="margin-bottom:2px;"><?php echo $LNG->EXPLORE_WIDGET_EXTRAS; ?></h2></div>
								<div id="themearea" class="tablelower" style="display: block;"></div>
								<div id="seealsoarea" class="tablelower" style="display: block;"></div>
								<div id="followersarea" class="tablelower" style="display:block"></div>
							</td>
							<?php if ($CFG->hasRecommendations) { ?>
							<td width="50%" valign="top">
								<div id="recommendationarea" class="tabletop" style="float:left;display:block;padding:0px;"><h2 style="margin-bottom:2px;"><?php echo $LNG->EXPLORE_WIDGET_RECOMMENDATIONS_HEADING; ?></h2></div>
								<div id="suggestedissuesarea" class="tablelower" style="display: block;"></div>
								<?php if ($CFG->HAS_SOLUTION) { ?>
									<div id="suggestedsolutionsarea" class="tablelower" style="display: block;"></div>
								<?php } ?>
								<?php if ($CFG->HAS_CLAIM) { ?>
									<div id="suggestedclaimsarea" class="tablelower" style="display: block;"></div>
								<?php } ?>
							</td>
							<?php } ?>
						</tr>
					</table>

				</div>
			<?php } else if ($nodetype == 'Project') { ?>
				<div id="widgetareadiv" class="projectbackpale" style="clear:both; float:left;width:100%;">
					<table id="widgettable" style="display:block" width="100%" class="widgettable projectbackpale" cellspacing="5">
						<tr>
							<td id="widgetcolnode" width="50%" valign="top">
								<div id="nodearea" class="tabletop" style="display: block;"></div>
							</td>
							<td id="widgetcolright" width="50%" valign="top">
								<div id="chatearea" class="tabletop" style="display: block;">
									<button onclick="location.href='<?php echo $CFG->homeAddress ?>chats.php?id=<?php echo $nodeid; ?>';" id="chatbutton" title="<?php echo $LNG->VIEWS_CHAT_HINT;?>" class="projectbackgradient2 active" onmouseover="$('chatbutton').className = 'projectbackgradient active';" onmouseout="$('chatbutton').className = 'projectbackgradient2 active';" style="height:40px; width:100%;">
										<div style="float:left;"><img src="<?php echo $HUB_FLM->getImagePath("chat.png"); ?>" border="0" /></div>
										<div class="homebutton1" style="margin-left:20px; margin-top:7px;float:left;font-size:12pt;font-weight:bold;">Chats</div>
									</button>
								</div>
								<div id="extraarea" class="tablelower" style="float:left;display:block;padding:0px;"><h2 style="margin-bottom:2px;"><?php echo $LNG->EXPLORE_WIDGET_ADDITIONAL_RELATIONS_HEADING; ?></h2></div>

								<div id="websitesarea" class="tablelower" style="display: block;"></div>
								<div id="partnersarea" class="tablelower" style="display: block;"></div>
								<div id="orgsarea" class="tablelower" style="display: block;"></div>

								<?php if ($CFG->HAS_CHALLENGE) { ?>
									<div id="challengesarea" class="tablelower" style="display: block;"></div>
								<?php } ?>
								<div id="issuesarea" class="tablelower" style="display: block;"></div>
								<?php if ($CFG->HAS_CLAIM) { ?>
									<div id="claimsarea" class="tablelower" style="display: block;"></div>
								<?php } ?>
								<?php if ($CFG->HAS_SOLUTION) { ?>
									<div id="solutionsarea" class="tablelower" style="display: block;"></div>
								<?php } ?>
								<div id="evidencearea" class="tablelower" style="display: block;"></div>
							</td>
						</tr>
					</table>
					<?php if ($CFG->hasRecommendations) { ?>
						<table id="widgetextrastable" style="display:block" width="100%" class="widgettable projectbackpale" cellspacing="5">
					<?php } else { ?>
						<table id="widgetextrastable" style="display:block" width="50%" class="widgettable projectbackpale" cellspacing="5">
					<?php }?>
						<tr>
							<td width="50%" valign="top">
								<div id="dataarea" class="tabletop" style="float:left;display:block;padding:0px;"><h2 style="margin-bottom:2px;"><?php echo $LNG->EXPLORE_WIDGET_EXTRAS; ?></h2></div>
								<div id="themearea" class="tablelower" style="display: block;"></div>
								<div id="seealsoarea" class="tablelower" style="display: block;"></div>
								<div id="followersarea" class="tablelower" style="display:block"></div>
							</td>
							<?php if ($CFG->hasRecommendations) { ?>
							<td width="50%" valign="top">
								<div id="recommendationarea" class="tabletop" style="float:left;display:block;padding:0px;"><h2 style="margin-bottom:2px;"><?php echo $LNG->EXPLORE_WIDGET_RECOMMENDATIONS_HEADING; ?></h2></div>
								<div id="suggestedissuesarea" class="tablelower" style="display: block;"></div>
								<?php if ($CFG->HAS_SOLUTION) { ?>
									<div id="suggestedsolutionsarea" class="tablelower" style="display: block;"></div>
								<?php } ?>
								<?php if ($CFG->HAS_CLAIM) { ?>
									<div id="suggestedclaimsarea" class="tablelower" style="display: block;"></div>
								<?php } ?>
							</td>
							<?php } ?>
						</tr>
					</table>
				</div>
			<?php } else if ($nodetype == 'Theme') { ?>
				<div id="widgetareadiv" class="themebackpale" style="clear:both; float:left;width:100%;">
					<table id="widgettable" style="display:block" width="100%" class="widgettable themebackpale" cellspacing="5">
						<tr>
							<td id="widgetcolleft" width="30%" valign="top">
								<div id="chatearea" class="tabletop" style="display: block;">
									<button onclick="location.href='<?php echo $CFG->homeAddress ?>chats.php?id=<?php echo $nodeid; ?>';" id="chatbutton" title="<?php echo $LNG->VIEWS_CHAT_HINT;?>" class="themebackgradient2 active" onmouseover="$('chatbutton').className = 'themebackgradient active';" onmouseout="$('chatbutton').className = 'themebackgradient2 active';" style="height:40px; width:100%;">
										<div style="float:left;"><img src="<?php echo $HUB_FLM->getImagePath("chat.png"); ?>" border="0" /></div>
										<div class="homebutton1" style="margin-left:20px; margin-top:7px;float:left;font-size:12pt;font-weight:bold;">Chats</div>
									</button>
								</div>

								<?php if ($CFG->HAS_CHALLENGE) { ?>
									<div id="challengesarea" class="tablelower" style="display: block;"></div>
								<?php } ?>
								<div id="issuesarea" class="tablelower" style="display: block;"></div>
								<?php if ($CFG->HAS_SOLUTION) { ?>
									<div id="solutionsarea" class="tablelower" style="display: block;"></div>
								<?php } ?>
								<?php if ($CFG->HAS_CLAIM) { ?>
									<div id="claimsarea" class="tablelower" style="display: block;"></div>
								<?php } ?>
							</td>
							<td id="widgetcolnode" width="40%" valign='top'>
								<div id="nodearea" class="tabletop" style="display: block;"></div>
							</td>
							<td id="widgetcolright" width="30%" valign="top">
								<div id="evidencearea" class="tabletop" style="display: block;"></div>
								<div id="resourcearea" class="tablelower" style="display: block;"></div>

								<div id="extraarea" class="tablelower" style="float:left;display:block;padding:0px;margin-top:10px;"><h2 style="margin-bottom:2px;"><?php echo $LNG->EXPLORE_WIDGET_ADDITIONAL_RELATIONS_HEADING; ?></h2></div>

								<div id="orgsarea" class="tablelower" style="display: block;"></div>
								<div id="projectsarea" class="tablelower" style="display: block;"></div>
								<div id="followersarea" class="tablelower" style="display: block;"></div>
							</td>
						</tr>
					</table>
				</div>
			<?php } else if ($nodetype == 'News') { ?>
				<div id="widgetareadiv" class="themebackpale" style="clear:both; float:left;width:100%;">
					<table id="widgettable" style="display:block" width="100%" class="widgettable themebackpale" cellspacing="5">
						<tr>
							<td id="widgetcolnode" valign='top'>
								<div id="nodearea" class="tabletop" style="width:100%;display: block;"></div>
							</td>
						</tr>
					</table>
				</div>
			<?php } ?>
		</div>

	</div>
</div>

<?php
    include_once($HUB_FLM->getCodeDirPath("ui/footer.php"));
?>
