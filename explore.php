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

<div class="container-fluid">
	<div class="row">
		<div class="col mt-3">
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

			<div id="tabber">
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
				<div id='tab-content-explore-widget' class='explorepagesection'>

					<?php if ($nodetype == 'Challenge') { ?>
						<div id="widgetareadiv" class="challengebackpale p-3">
							<div id="widgettable" class="widgettable row challengebackpale">
								<div id="widgetcolnode" class="col-lg col-md-12">
									<div id="nodearea" class="tabletop"></div>
								</div>
								<div id="widgetcolright" class="col-lg col-md-12">
									<div id="chatarea" class="tabletop chatarea d-grid gap-2 mb-1">
										<button onclick="location.href='<?php echo $CFG->homeAddress ?>chats.php?id=<?php echo $nodeid; ?>';" id="chatbutton" title="<?php echo $LNG->VIEWS_CHAT_HINT;?>" class="btn challengebackgradient2 active" onmouseover="$('chatbutton').className = 'btn challengebackgradient active';" onmouseout="$('chatbutton').className = 'btn challengebackgradient2 active';">
											<div class="homebutton1"><img src="<?php echo $HUB_FLM->getImagePath("chat.png"); ?>" alt="" /> Chats</div>
										</button>
									</div>
									<div class="tabletop" id="issuesarea">
										<div class="row align-items-center">
											<div class="col-auto">
												<i class="fas fa-long-arrow-alt-right" aria-hidden="true"></i>
											</div>
											<div class="col">
												<div id="issuesareainner"></div>
											</div>											
										</div>
									</div>
								</div>
							</div>

							<div id="widgetextrastable" class="widgettable row challengebackpale">
								<div class="col p-3">
									<div id="dataarea" class="tabletop mb-2"><h2><?php echo $LNG->EXPLORE_WIDGET_EXTRAS; ?></h2></div>
									<div id="themearea" class="tablelower mb-2"></div>
									<div id="seealsoarea" class="tablelower mb-2"></div>
									<div id="followersarea" class="tablelower mb-2"></div>
								</div>
								<div class="col p-3">
									<div id="extraarea" class="tabletop mb-2"><h2><?php echo $LNG->EXPLORE_WIDGET_ADDITIONAL_RELATIONS_HEADING; ?></h2></div>
									<div id="orgsarea" class="tablelower mb-2"></div>
									<div id="projectsarea" class="tablelower mb-2"></div>
								</div>
								<?php if ($CFG->hasRecommendations) { ?>
								<div class="col p-3">
									<div id="recommendationarea" class="tabletop mb-2"><h2><?php echo $LNG->EXPLORE_WIDGET_RECOMMENDATIONS_HEADING; ?></h2></div>
									<div id="suggestedorgsarea" class="tablelower mb-2"></div>
									<div id="suggestedissuesarea" class="tablelower mb-2"></div>
								</td>
								<?php } ?>
							</div>
						</div>
					<?php } else if ($nodetype == 'Issue') { ?>
						<div id="widgetareadiv" class="issuebackpale p-3">
							<div id="widgettable" class="widgettable row issuebackpale row">
								<?php if ($CFG->HAS_CHALLENGE) { ?>
									<div id="widgetcolleft" class="col-lg col-md-12 mb-3">
										<div id="chatarea" class="tabletop chatarea d-grid gap-2 mb-1">
											<button onclick="location.href='<?php echo $CFG->homeAddress ?>chats.php?id=<?php echo $nodeid; ?>';" id="chatbutton" title="<?php echo $LNG->VIEWS_CHAT_HINT;?>" class="btn issuebackgradient2 active" onmouseover="$('chatbutton').className = 'btn issuebackgradient active';" onmouseout="$('chatbutton').className = 'btn issuebackgradient2 active';">
												<div class="homebutton1"><img src="<?php echo $HUB_FLM->getImagePath("chat.png"); ?>" alt="" /> Chats</div>
											</button>
										</div>
										<div id="challengesarea" class="tablelower">								
											<div class="row align-items-center">
												<div class="col">
													<div id="challengesareainner"></div>
												</div>
												<div class="col-auto">
													<i class="fas fa-long-arrow-alt-right" aria-hidden="true"></i>
												</div>
											</div>										
										</div>
									</div>
								<?php } ?>
								<div class="col-lg col-md-12 mb-3" id="widgetcolnode">
									<div id="nodearea" class="tabletop"></div>
								</div>
								<div id="widgetcolright" class="col-lg col-md-12 mb-3">
									<?php if (!$CFG->HAS_CHALLENGE) { ?>
										<div id="chatarea" class="tabletop chatarea d-grid gap-2 mb-1">
											<button onclick="location.href='<?php echo $CFG->homeAddress ?>chats.php?id=<?php echo $nodeid; ?>';" id="chatbutton" title="<?php echo $LNG->VIEWS_CHAT_HINT;?>" class="btn issuebackgradient2 active" onmouseover="$('chatbutton').className = 'btn issuebackgradient active';" onmouseout="$('chatbutton').className = 'btn issuebackgradient2 active';">
												<div class="homebutton1"><img src="<?php echo $HUB_FLM->getImagePath("chat.png"); ?>" alt="" /> Chats</div>
											</button>
										</div>
									<?php } ?>
									<?php if ($CFG->HAS_SOLUTION) { ?>
										<div id="solutionsarea" class="<?php if (!$CFG->HAS_CHALLENGE) { echo 'tablelower'; } else { echo 'tabletop'; }?>">							
											<div class="row align-items-center">
												<div class="col-auto">
													<i class="fas fa-long-arrow-alt-right" aria-hidden="true"></i>
												</div>
												<div class="col">
													<div id="solutionsareainner"></div>
												</div>
											</div>			
										</div>
									<?php } ?>
									<?php if ($CFG->HAS_CLAIM) { ?>
										<div id="claimsarea" class="<?php if ($CFG->HAS_CLAIM && !$CFG->HAS_SOLUTION && $CFG->HAS_CHALLENGE){ echo 'tabletop'; } else { echo 'tablelower'; } ?>">
											<div class="row align-items-center">
												<div class="col-auto">
													<i class="fas fa-long-arrow-alt-right" aria-hidden="true"></i>
												</div>
												<div class="col">
													<div id="claimsareainner"></div>
												</div>
											</div>
										</div>
									<?php } ?>
								</div>
							</div>
							<div id="widgetextrastable" class="widgettable row">
								<div class="col p-3">
									<div id="dataarea" class="tabletop mb-2"><h2><?php echo $LNG->EXPLORE_WIDGET_EXTRAS; ?> asdfasdf sa</h2></div>
									<div id="themearea" class="tablelower mb-2"></div>
									<div id="seealsoarea" class="tablelower mb-2"></div>
									<div id="followersarea" class="tablelower mb-2"></div>
								</div>
								<div class="col p-3">
									<div id="extraarea" class="tabletop mb-2"><h2><?php echo $LNG->EXPLORE_WIDGET_ADDITIONAL_RELATIONS_HEADING; ?></h2></div>
									<div id="orgsarea" class="tablelower mb-2"></div>
									<div id="projectsarea" class="tablelower mb-2"></div>
								</div>
								<?php if ($CFG->hasRecommendations) { ?>
									<div class="col p-3">
										<div id="recommendationarea" class="tabletop mb-2"><h2><?php echo $LNG->EXPLORE_WIDGET_RECOMMENDATIONS_HEADING; ?></h2></div>
										<div id="suggestedorgsarea" class="tablelower mb-2"></div>
										<?php if ($CFG->HAS_SOLUTION) { ?>
											<div id="suggestedsolutionsarea" class="tablelower mb-2"></div>
										<?php } ?>
										<?php if ($CFG->HAS_CLAIM) { ?>
											<div id="suggestedclaimsarea" class="tablelower mb-2"></div>
										<?php } ?>
										<div id="tagsissuesarea" class="tablelower"></div>
									</div>
								<?php } ?>
							</div>
						</div>
					<?php } else if ($nodetype == 'Claim') { ?>
						<div id="widgetareadiv" class="claimbackpale p-3">
							<div id="widgettable" class="widgettable row claimbackpale">

								<div id="widgetcolleft" class="col-lg col-md-12">
									<div id="chatarea" class="tabletop chatarea d-grid gap-2 mb-1">
										<button onclick="location.href='<?php echo $CFG->homeAddress ?>chats.php?id=<?php echo $nodeid; ?>';" id="chatbutton" title="<?php echo $LNG->VIEWS_CHAT_HINT;?>" class="claimbackgradient2 active btn" onmouseover="$('chatbutton').className = 'claimbackgradient active btn';" onmouseout="$('chatbutton').className = 'claimbackgradient2 active btn';">
											<div class="homebutton1"><img src="<?php echo $HUB_FLM->getImagePath("chat.png"); ?>" alt="" /> Chats</div>
										</button>
									</div>
									<div class="tablelower" id="issuesarea">
										<div class="row align-items-center">
											<div class="col">
												<div id="issuesareainner"></div>
											</div>
											<div class="col-auto">
												<i class="fas fa-long-arrow-alt-right" aria-hidden="true"></i>
											</div>
										</div>
									</div>
								</div>
								
								<div class="col-lg col-md-12" id="widgetcolnode">
									<div id="nodearea" class="tabletop"></div>
								</div>

								<div id="widgetcolright" class="col-lg col-md-12">
									<div class="tabletop" id="prosarea">
										<div class="row align-items-center">
											<div class="col-auto">
												<i class="fas fa-long-arrow-alt-right text-success" aria-hidden="true"></i>
											</div>
											<div class="col">
												<div id="prosareainner"></div>
											</div>
										</div>
									</div>
									<div class="tablelower" id="consarea">
										<div class="row align-items-center">
											<div class="col-auto">
												<i class="fas fa-long-arrow-alt-right text-danger" aria-hidden="true"></i>
											</div>
											<div class="col">
												<div id="consareainner"></div>
											</div>
										</div>
									</div>
								</div>

							</div>
							<div id="widgetextrastable" class="widgettable row claimbackpale">
								<div class="col p-3">
									<div id="dataarea" class="tabletop mb-2"><h2><?php echo $LNG->EXPLORE_WIDGET_EXTRAS; ?></h2></div>
									<div id="themearea" class="tablelower mb-2"></div>
									<div id="seealsoarea" class="tablelower mb-2"></div>
									<div id="followersarea" class="tablelower mb-2"></div>
								</div>
								<div class="col p-3">
									<div id="extraarea" class="tabletop mb-2"><h2><?php echo $LNG->EXPLORE_WIDGET_ADDITIONAL_RELATIONS_HEADING; ?></h2></div>
									<div id="orgsarea" class="tablelower mb-2"></div>
									<div id="projectsarea" class="tablelower mb-2"></div>
								</div>
								<?php if ($CFG->hasRecommendations) { ?>
									<div class="col p-3">
										<div id="recommendationarea" class="tabletop mb-2"><h2><?php echo $LNG->EXPLORE_WIDGET_RECOMMENDATIONS_HEADING; ?></h2></div>
										<div id="suggestedorgsarea" class="tablelower mb-2"></div>
										<div id="suggestedissuesarea" class="tablelower mb-2"></div>
									</div>
								<?php } ?>
							</div>
						</div>
					<?php } else if ($nodetype == 'Solution') { ?>
						<div id="widgetareadiv" class="solutionbackpale p-3">
							<div id="widgettable" class="widgettable row solutionbackpale">
								<div id="widgetcolleft" class="col-lg col-md-12">
									<div id="chatarea" class="tabletop chatarea d-grid gap-2 mb-1">
										<button onclick="location.href='<?php echo $CFG->homeAddress ?>chats.php?id=<?php echo $nodeid; ?>';" id="chatbutton" title="<?php echo $LNG->VIEWS_CHAT_HINT;?>" class="btn solutionbackgradient2 active" onmouseover="$('chatbutton').className = 'btn solutionbackgradient active';" onmouseout="$('chatbutton').className = 'btn solutionbackgradient2 active';">
											<div class="homebutton1"><img src="<?php echo $HUB_FLM->getImagePath("chat.png"); ?>" alt="" /> Chats</div>
										</button>
									</div>
									<div class="tablelower" id="issuesarea">
										<div class="row align-items-center">
											<div class="col">
												<div id="issuesareainner"></div>
											</div>
											<div class="col-auto">
												<i class="fas fa-long-arrow-alt-right" aria-hidden="true"></i>
											</div>
										</div>
									</div>
								</div>
								<div class="col-lg col-md-12" id="widgetcolnode">
									<div id="nodearea" class="tabletop"></div>
								</div>
								<div id="widgetcolright" class="col-lg col-md-12">
									<div class="tabletop" id="prosarea">
										<div class="row align-items-center">
											<div class="col-auto">
												<i class="fas fa-long-arrow-alt-right text-success" aria-hidden="true"></i>
											</div>
											<div class="col">
												<div id="prosareainner"></div>
											</div>
										</div>
									</div>
									<div class="tablelower" id="consarea">
										<div class="row align-items-center">
											<div class="col-auto">
												<i class="fas fa-long-arrow-alt-right text-danger" aria-hidden="true"></i>
											</div>
											<div class="col">
												<div id="consareainner"></div>
											</div>
										</div>
									</div>
								</div>									
							</div>
							<div id="widgetextrastable" class="widgettable row solutionbackpale">
								<div class="col p-3">
									<div id="dataarea" class="tabletop mb-2"><h2><?php echo $LNG->EXPLORE_WIDGET_EXTRAS; ?></h2></div>
									<div id="themearea" class="tablelower mb-2"></div>
									<div id="seealsoarea" class="tablelower mb-2"></div>
									<div id="followersarea" class="tablelower mb-2"></div>
								</div>
								<div class="col p-3">
									<div id="extraarea" class="tabletop mb-2"><h2><?php echo $LNG->EXPLORE_WIDGET_ADDITIONAL_RELATIONS_HEADING; ?></h2></div>
									<div id="orgsarea" class="tablelower mb-2"></div>
									<div id="projectsarea" class="tablelower mb-2"></div>
								</div>
								<?php if ($CFG->hasRecommendations) { ?>
									<div class="col p-3">
										<div id="recommendationarea" class="tabletop mb-2"><h2><?php echo $LNG->EXPLORE_WIDGET_RECOMMENDATIONS_HEADING; ?></h2></div>
										<div id="suggestedorgsarea" class="tablelower mb-2"></div>
										<div id="suggestedissuesarea" class="tablelower mb-2"></div>
									</div>
								<?php } ?>
							</div>
						</div>
					<?php } else if (in_array($nodetype, $CFG->EVIDENCE_TYPES)) { //EVIDENCE ?>
						<div id="widgetareadiv" class="evidencebackpale p-3">
							<div id="widgettable" class="widgettable row evidencebackpale">
								<div id="widgetcolleft" class="col-lg col-md-12">
									<div id="chatarea" class="tabletop chatarea d-grid gap-2 mb-1">
										<button onclick="location.href='<?php echo $CFG->homeAddress ?>chats.php?id=<?php echo $nodeid; ?>';" id="chatbutton" title="<?php echo $LNG->VIEWS_CHAT_HINT;?>" class="btn evidencebackgradient2 active" onmouseover="$('chatbutton').className = 'btn evidencebackgradient active';" onmouseout="$('chatbutton').className = 'btn evidencebackgradient2 active';">
											<div class="homebutton1"><img src="<?php echo $HUB_FLM->getImagePath("chat.png"); ?>" alt="" /> Chats</div>
										</button>
									</div>
									<?php if ($CFG->HAS_SOLUTION) { ?>
										<div id="solutionsarea" class="tablelower">
											<div class="row align-items-center">
												<div class="col">
													<div id="solutionsareainner"></div>
												</div>
												<div class="col-auto">
													<i class="fas fa-long-arrow-alt-right" aria-hidden="true"></i>
												</div>
											</div>
										</div>
									<?php } ?>
									<?php if ($CFG->HAS_CLAIM) { ?>
										<div id="claimsarea" class="tablelower">
											<div class="row align-items-center">
												<div class="col">
													<div id="claimsareainner"></div>
												</div>
												<div class="col-auto">
													<i class="fas fa-long-arrow-alt-right" aria-hidden="true"></i>
												</div>
											</div>
										</div>
									<?php } ?>
								</div>
								<div class="col-lg col-md-12" id="widgetcolnode">
									<div id="nodearea" class="tabletop"></div>
								</div>
								<div id="widgetcolright" class="col-lg col-md-12">
									<div id="websitesarea" class="tabletop">
										<div class="row align-items-center">
											<div class="col-auto">
												<i class="fas fa-long-arrow-alt-right" aria-hidden="true"></i>
											</div>
											<div class="col">
												<div id="websitesareainner"></div>
											</div>
										</table>
									</div>
								</div>
							</div>
							<div id="widgetextrastable" class="widgettable row evidencebackpale">
								<div class="col p-3">
									<div id="dataarea" class="tabletop mb-2"><h2><?php echo $LNG->EXPLORE_WIDGET_EXTRAS; ?></h2></div>
									<div id="themearea" class="tablelower mb-2"></div>
									<div id="seealsoarea" class="tablelower mb-2"></div>
									<div id="followersarea" class="tablelower mb-2"></div>
								</div>
								<div class="col p-3">
									<div id="extraarea" class="tabletop mb-2"><h2><?php echo $LNG->EXPLORE_WIDGET_ADDITIONAL_RELATIONS_HEADING; ?></h2></div>
									<div id="orgsarea" class="tablelower mb-2"></div>
									<div id="projectsarea" class="tablelower mb-2"></div>
								</div>
								<?php if ($CFG->hasRecommendations) { ?>
									<div class="col p-3">
										<div id="recommendationarea" class="tabletop mb-2"><h2><?php echo $LNG->EXPLORE_WIDGET_RECOMMENDATIONS_HEADING; ?></h2></div>
										<div id="suggestedorgsarea" class="tablelower mb-2"></div>
										<div id="suggestedissuesarea" class="tablelower mb-2"></div>
										<?php if ($CFG->HAS_SOLUTION) { ?>
											<div id="suggestedsolutionsarea" class="tablelower mb-2"></div>
										<?php } ?>
										<?php if ($CFG->HAS_CLAIM) { ?>
											<div id="suggestedclaimsarea" class="tablelower mb-2"></div>
										<?php } ?>
									</div>
								<?php } ?>
							</div>
						</div>
					<?php } else if (in_array($nodetype, $CFG->RESOURCE_TYPES)) { //RESOURCES ?>
						<div id="widgetareadiv" class="resourcebackpale p-3">
							<div id="widgettable" class="widgettable row resourcebackpale">
								<div id="widgetcolleft" class="col-lg col-md-12">
									<div id="chatarea" class="tabletop chatarea d-grid gap-2 mb-1">
										<button onclick="location.href='<?php echo $CFG->homeAddress ?>chats.php?id=<?php echo $nodeid; ?>';" id="chatbutton" title="<?php echo $LNG->VIEWS_CHAT_HINT;?>" class="btn resourcebackgradient2 active" onmouseover="$('chatbutton').className = 'btn resourcebackgradient active';" onmouseout="$('chatbutton').className = 'btn resourcebackgradient2 active';">
											<div class="homebutton1"><img src="<?php echo $HUB_FLM->getImagePath("chat.png"); ?>" alt="" /> Chats</div>
										</button>		
									</div>
									<div class="tablelower" id="evidencesarea">
										<div class="row align-items-center">
											<div class="col">
												<div id="evidencesareainner"></div>
											</div>
											<div class="col-auto">
												<i class="fas fa-long-arrow-alt-right" aria-hidden="true"></i>
											</div>
										</div>
									</div>
								</div>
								<div id="widgetcolnode" class="col-lg col-md-12">
									<div id="nodearea" class="tabletop"></div>
								</div>
							</div>
							<div id="widgetextrastable" class="widgettable row resourcebackpale">
								<div class="col p-3">
									<div id="dataarea" class="tabletop mb-2"><h2><?php echo $LNG->EXPLORE_WIDGET_EXTRAS; ?></h2></div>
									<div id="themearea" class="tablelower mb-2"></div>
									<div id="seealsoarea" class="tablelower mb-2"></div>
									<div id="followersarea" class="tablelower mb-2"></div>
								</div>
								<div class="col p-3">
									<div id="extraarea" class="tabletop mb-2"><h2><?php echo $LNG->EXPLORE_WIDGET_ADDITIONAL_RELATIONS_HEADING; ?></h2></div>
									<div id="orgsarea" class="tablelower mb-2"></div>
									<div id="projectsarea" class="tablelower mb-2"></div>
									<div id="relatedresourcesarea" class="tablelower mb-2"></div>
								</div>
								<?php if ($CFG->hasRecommendations) { ?>
								<div class="col p-3">
									<div id="recommendationarea" class="tabletop mb-2"><h2><?php echo $LNG->EXPLORE_WIDGET_RECOMMENDATIONS_HEADING; ?></h2></div>
									<div id="suggestedorgsarea" class="tablelower mb-2"></div>
									<div id="suggestedissuesarea" class="tablelower mb-2"></div>
									<?php if ($CFG->HAS_SOLUTION) { ?>
										<div id="suggestedsolutionsarea" class="tablelower mb-2"></div>
									<?php } ?>
									<?php if ($CFG->HAS_CLAIM) { ?>
										<div id="suggestedclaimsarea" class="tablelower mb-2"></div>
									<?php } ?>
								</div>
								<?php } ?>
							</div>
						</div>
					<?php } else if ($nodetype == 'Organization') { ?>
						<div id="widgetareadiv" class="orgbackpale p-3">
							<div id="widgettable" class="widgettable row orgbackpale">
								<div id="widgetcolnode" class="col-lg col-md-12">
									<div id="nodearea" class="tabletop"></div>
								</div>
								<div id="widgetcolright" class="col-lg col-md-12">
									<div id="chatarea" class="tabletop chatarea d-grid gap-2 mb-1">
										<button onclick="location.href='<?php echo $CFG->homeAddress ?>chats.php?id=<?php echo $nodeid; ?>';" id="chatbutton" title="<?php echo $LNG->VIEWS_CHAT_HINT;?>" class="btn orgbackgradient2 active" onmouseover="$('chatbutton').className = 'btn orgbackgradient active';" onmouseout="$('chatbutton').className = 'btn orgbackgradient2 active';">
											<div class="homebutton1"><img src="<?php echo $HUB_FLM->getImagePath("chat.png"); ?>" alt="" /> Chats</div>
										</button>
									</div>
									<div id="extraarea" class="tablelower"><h2><?php echo $LNG->EXPLORE_WIDGET_ADDITIONAL_RELATIONS_HEADING; ?></h2></div>

									<div id="websitesarea" class="tablelower"></div>
									<div id="partnersarea" class="tablelower"></div>
									<div id="projectsarea" class="tablelower mb-2"></div>

									<?php if ($CFG->HAS_CHALLENGE) { ?>
										<div id="challengesarea" class="tablelower"></div>
									<?php }  ?>
									<div id="issuesarea" class="tablelower"></div>
									<?php if ($CFG->HAS_CLAIM) { ?>
										<div id="claimsarea" class="tablelower"></div>
									<?php } ?>
									<?php if ($CFG->HAS_SOLUTION) { ?>
										<div id="solutionsarea" class="tablelower"></div>
									<?php } ?>
									<div id="evidencearea" class="tablelower"></div>
								</div>
							</div>
							<?php if ($CFG->hasRecommendations) { ?>
								<div id="widgetextrastable" class="widgettable row orgbackpale">
							<?php } else { ?>
								<div id="widgetextrastable" class="widgettable row orgbackpale">
							<?php }?>
								<div class="col p-3">
									<div id="dataarea" class="tabletop mb-2"><h2><?php echo $LNG->EXPLORE_WIDGET_EXTRAS; ?></h2></div>
									<div id="themearea" class="tablelower mb-2"></div>
									<div id="seealsoarea" class="tablelower mb-2"></div>
									<div id="followersarea" class="tablelower mb-2"></div>
								</div>
								<?php if ($CFG->hasRecommendations) { ?>
									<div class="col p-3">
										<div id="recommendationarea" class="tabletop mb-2"><h2><?php echo $LNG->EXPLORE_WIDGET_RECOMMENDATIONS_HEADING; ?></h2></div>
										<div id="suggestedissuesarea" class="tablelower mb-2"></div>
										<?php if ($CFG->HAS_SOLUTION) { ?>
											<div id="suggestedsolutionsarea" class="tablelower mb-2"></div>
										<?php } ?>
										<?php if ($CFG->HAS_CLAIM) { ?>
											<div id="suggestedclaimsarea" class="tablelower mb-2"></div>
										<?php } ?>
									</div>
								<?php } ?>
							</div>
						</div>
					<?php } else if ($nodetype == 'Project') { ?>
						<div id="widgetareadiv" class="projectbackpale p-3">
							<div id="widgettable" class="widgettable row projectbackpale">
								<div id="widgetcolnode" class="col-lg col-md-12">
									<div id="nodearea" class="tabletop"></div>
								</div>
								<div id="widgetcolright" class="col-lg col-md-12">
									<div id="chatarea" class="tabletop chatarea d-grid gap-2 mb-1">
										<button onclick="location.href='<?php echo $CFG->homeAddress ?>chats.php?id=<?php echo $nodeid; ?>';" id="chatbutton" title="<?php echo $LNG->VIEWS_CHAT_HINT;?>" class="btn projectbackgradient2 active" onmouseover="$('chatbutton').className = 'btn projectbackgradient active';" onmouseout="$('chatbutton').className = 'btn projectbackgradient2 active';">
											<div class="homebutton1"><img src="<?php echo $HUB_FLM->getImagePath("chat.png"); ?>" alt="" /> Chats</div>
										</button>
									</div>
									<div id="extraarea" class="tablelower"><h2><?php echo $LNG->EXPLORE_WIDGET_ADDITIONAL_RELATIONS_HEADING; ?></h2></div>
									<div id="websitesarea" class="tablelower mb-2"></div>
									<div id="partnersarea" class="tablelower mb-2"></div>
									<div id="orgsarea" class="tablelower mb-2"></div>
									<?php if ($CFG->HAS_CHALLENGE) { ?>
										<div id="challengesarea" class="tablelower mb-2"></div>
									<?php } ?>
									<div id="issuesarea" class="tablelower mb-2"></div>
									<?php if ($CFG->HAS_CLAIM) { ?>
										<div id="claimsarea" class="tablelower mb-2"></div>
									<?php } ?>
									<?php if ($CFG->HAS_SOLUTION) { ?>
										<div id="solutionsarea" class="tablelower mb-2"></div>
									<?php } ?>
									<div id="evidencearea" class="tablelower mb-2"></div>
								</div>
							</div>
							<?php if ($CFG->hasRecommendations) { ?>
								<div id="widgetextrastable" class="widgettable row projectbackpale">
							<?php } else { ?>
								<div id="widgetextrastable" class="widgettable row projectbackpale">
							<?php }?>
								<div class="col p-3">
									<div id="dataarea" class="tabletop mb-2"><h2><?php echo $LNG->EXPLORE_WIDGET_EXTRAS; ?></h2></div>
									<div id="themearea" class="tablelower mb-2"></div>
									<div id="seealsoarea" class="tablelower mb-2"></div>
									<div id="followersarea" class="tablelower mb-2"></div>
								</div>
								<?php if ($CFG->hasRecommendations) { ?>
								<div class="col p-3">
									<div id="recommendationarea" class="tabletop mb-2"><h2><?php echo $LNG->EXPLORE_WIDGET_RECOMMENDATIONS_HEADING; ?></h2></div>
									<div id="suggestedissuesarea" class="tablelower mb-2"></div>
									<?php if ($CFG->HAS_SOLUTION) { ?>
										<div id="suggestedsolutionsarea" class="tablelower mb-2"></div>
									<?php } ?>
									<?php if ($CFG->HAS_CLAIM) { ?>
										<div id="suggestedclaimsarea" class="tablelower mb-2"></div>
									<?php } ?>
								</div>
								<?php } ?>
							</div>
						</div>
					<?php } else if ($nodetype == 'Theme') { ?>
						<div id="widgetareadiv" class="themebackpale p-3">
							<div id="widgettable" class="widgettable row themebackpale">
								<div id="widgetcolleft" class="col-lg col-md-12">
									<div id="chatarea" class="tabletop chatarea d-grid gap-2 mb-1">
										<button onclick="location.href='<?php echo $CFG->homeAddress ?>chats.php?id=<?php echo $nodeid; ?>';" id="chatbutton" title="<?php echo $LNG->VIEWS_CHAT_HINT;?>" class="btn themebackgradient2 active" onmouseover="$('chatbutton').className = 'btn themebackgradient active';" onmouseout="$('chatbutton').className = 'btn themebackgradient2 active';">
											<div class="homebutton1"><img src="<?php echo $HUB_FLM->getImagePath("chat.png"); ?>" alt="" /> Chats</div>
										</button>
									</div>
									<?php if ($CFG->HAS_CHALLENGE) { ?>
										<div id="challengesarea" class="tablelower mb-2"></div>
									<?php } ?>
									<div id="issuesarea" class="tablelower mb-2"></div>
									<?php if ($CFG->HAS_SOLUTION) { ?>
										<div id="solutionsarea" class="tablelower mb-2"></div>
									<?php } ?>
									<?php if ($CFG->HAS_CLAIM) { ?>
										<div id="claimsarea" class="tablelower mb-2"></div>
									<?php } ?>
								</div>
								<div id="widgetcolnode" class="col-lg col-md-12">
									<div id="nodearea" class="tabletop"></div>
								</div>
								<div id="widgetcolright" class="col-lg col-md-12">
									<div id="evidencearea" class="tabletop mb-2"></div>
									<div id="resourcearea" class="tablelower mb-2"></div>

									<div id="extraarea" class="tablelower mb-2"><h2><?php echo $LNG->EXPLORE_WIDGET_ADDITIONAL_RELATIONS_HEADING; ?></h2></div>

									<div id="orgsarea" class="tablelower mb-2"></div>
									<div id="projectsarea" class="tablelower mb-2"></div>
									<div id="followersarea" class="tablelower mb-2"></div>
								</div>
							</div>
						</div>
					<?php } else if ($nodetype == 'News') { ?>
						<div id="widgetareadiv" class="themebackpale">
							<div id="widgettable" class="widgettable row themebackpale">
								<div id="widgetcolnode" valign='top'>
									<div id="nodearea" class="tabletop" style="width:100%;display: block;"></div>
								</div>
							</div>
						</div>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
</div>

<?php
    include_once($HUB_FLM->getCodeDirPath("ui/footer.php"));
?>
