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

include_once($HUB_FLM->getCodeDirPath("ui/networknavigationlib.php"));

/**
 * Displays the user tabs and pages
 *
 * @param string $context the context to display
 * @param string $args the url arguments
 */
function displayUserTabs($context,$args, $wasEmpty){
    global $CFG, $LNG, $USER, $CONTEXTUSER, $HUB_FLM;

     // now trigger the js to load data
     $argsStr = "{";
     $keys = array_keys($args);
     for($i=0;$i< count($keys); $i++){
         $argsStr .= '"'.$keys[$i].'":"'.$args[$keys[$i]].'"';
         if ($i != (count($keys)-1)){
             $argsStr .= ',';
         }
     }
     $argsStr .= "}";

 	if ($wasEmpty) {
     	$args["orderby"] = 'date';
    }
 	$argsStr2 = "{";
 	$keys = array_keys($args);
 	for($i=0;$i< count($keys); $i++){
 		$argsStr2 .= '"'.$keys[$i].'":"'.$args[$keys[$i]].'"';
 		if ($i != (count($keys)-1)){
 			$argsStr2 .= ',';
 		}
 	}
 	$argsStr2 .= "}";

	echo "<script type='text/javascript'>";

	echo "var CONTEXT = '".$context."';";
	echo "var NODE_ARGS = ".$argsStr.";";
	echo "var CONN_ARGS = ".$argsStr.";";
	echo "var NEIGHBOURHOOD_ARGS = ".$argsStr.";";
	echo "var NET_ARGS = ".$argsStr.";";

	echo "var USER_ARGS = ".$argsStr.";";
	echo "var ORG_ARGS = ".$argsStr.";";
	echo "var PROJECT_ARGS = ".$argsStr.";";

	echo "var ISSUE_ARGS = ".$argsStr2.";";
	echo "var CHALLENGE_ARGS = ".$argsStr2.";";
	echo "var CLAIM_ARGS = ".$argsStr2.";";
	echo "var SOLUTION_ARGS = ".$argsStr2.";";
	echo "var EVIDENCE_ARGS = ".$argsStr2.";";
	echo "var RESOURCE_ARGS = ".$argsStr2.";";
	echo "var CHAT_ARGS = ".$argsStr2.";";
	echo "var COMMENT_ARGS = ".$argsStr2.";";

	echo "CHAT_ARGS['filterlist'] = '".$CFG->LINK_COMMENT_NODE."';";
	echo "COMMENT_ARGS['includeunconnected'] = 'false';";
	echo "COMMENT_ARGS['filterlist'] = '".$CFG->LINK_COMMENT_BUILT_FROM."';";
	echo "COMMENT_ARGS['includeunconnected'] = 'true';";

	echo "</script>";

    ?>

    <div id="tabber" class="tabber-user mt-4">
        <ul id="tabs" class="nav nav-tabs">
			<li class="nav-item">
				<a class="nav-link" id="tab-home" href="#home">
					<?php echo $LNG->TAB_USER_HOME; ?>
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" id="tab-data" href="#data">
					<?php echo $LNG->TAB_USER_DATA; ?>
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" id="tab-social" href="#social">
					<?php echo $LNG->TAB_USER_SOCIAL; ?>
				</a>
			</li>
        </ul>

        <div id="tabs-content" class="tab-content p-0">
			<!-- HOME TAB PAGES -->
            <div id='tab-content-home-div' class='tabcontentouter'>
	  			<div class="peopleback row">
	  				<div class="peopleback tabtitlebar"></div>
	  			</div>
	            <div id='tab-content-home row'>
	           		<?php include($HUB_FLM->getCodeDirPath("ui/homepageuser.php")); ?>
	            </div>
			</div>

			<!-- DATA TAB PAGE -->
			<div id='tab-content-data-div' class='tabcontent'>
	  			<div class="peopleback row"></div>

            	<div id='tab-content-toolbar-data row'>
					<div id="tabber" class="border border-top-0 pt-1">
	 					<div class="row">
							<div id="datatabs">
								<ul id="tabs" class="nav nav-tabs p-2 main-nav">
									<?php if ($CFG->HAS_CHALLENGE) {
										if ($args['userid'] == $USER->userid && $USER->getIsAdmin() == "Y") { ?>
											<li class="nav-item">
												<a class="tab" id="tab-data-challenge" href="#data-challenge">
													<span class="tab tabchallenge"><?php echo $LNG->TAB_USER_CHALLENGE; ?> <span id="challenge-list-count"></span></span>
												</a>
											</li>
										<?php } 
									} ?>
									<?php if ( $CFG->issuesManaged == false || ($CFG->issuesManaged == true && $USER->getIsAdmin() == "Y") ) { ?>
										<li class="nav-item"><a class="tab" id="tab-data-issue" href="#data-issue"><span class="tab tabissue"><?php echo $LNG->TAB_USER_ISSUE; ?> <span id="issue-list-count"></span></span></a></li>
									<?php } ?>
									<?php if ($CFG->HAS_SOLUTION) { ?>
										<li class="nav-item"><a class="tab" id="tab-data-solution" href="#data-solution"><span class="tab tabsolution"><?php echo $LNG->TAB_USER_SOLUTION ?> <span id="solution-list-count"></span></span></a></li>
									<?php } ?>
									<?php if ($CFG->HAS_CLAIM) { ?>
										<li class="nav-item"><a class="tab" id="tab-data-claim" href="#data-claim"><span class="tab tabclaim"><?php echo $LNG->TAB_USER_CLAIM; ?> <span id="claim-list-count"></span></span></a></li>
									<?php } ?>
									<li class="nav-item"><a class="tab" id="tab-data-evidence" href="#data-evidence"><span class="tab tabevidence"><?php echo $LNG->TAB_USER_EVIDENCE; ?> <span id="evidence-list-count"></span></span></a></li>
									<li class="nav-item"><a class="tab" id="tab-data-resource" href="#data-resource"><span class="tab tabresource"><?php echo $LNG->TAB_USER_RESOURCE; ?> <span id="resource-list-count"></span></span></a></li>
									<li class="nav-item"><a class="tab" id="tab-data-org" href="#data-org"><span class="tab taborg"><?php echo $LNG->TAB_USER_ORG; ?> <span id="org-list-count"></span></span></a></li>
									<li class="nav-item"><a class="tab" id="tab-data-project" href="#data-project"><span class="tab tabproject"><?php echo $LNG->TAB_USER_PROJECT; ?> <span id="project-list-count"></span></span></a></li>
									<li class="nav-item"><a class="tab" id="tab-data-chat" href="#data-chat"><span class="tab tabuser"><?php echo $LNG->TAB_USER_CHAT; ?> <span id="chat-list-count"></span></span></a></li>
									<?php if ($CFG->HAS_OPEN_COMMENTS) { ?>
										<li class="nav-item"><a class="tab" id="tab-data-comment" href="#data-comment"><span class="tab tabuser"><?php echo $LNG->TAB_USER_COMMENT; ?> <span id="comment-list-count"></span></span></a></li>
									<?php } ?>
								</ul>
							</div>
							
							<div id="tab-content-data" class="tabcontentinner">
								<?php if ($CFG->HAS_CHALLENGE) { ?>
									<div id="tab-content-data-challenge-div" class="tabcontentuser issuebackpale" style="display:none">
										<div id="tab-content-challenge-title" class="challengeback tab-content-title"></div>
										<div id='tab-content-challenge-search' class="row p-2">
											<?php if(isset($USER->userid) && $USER->getIsAdmin() == "Y" && $USER->userid == $user->userid){ ?>
												<span class="toolbar addChallenge">
													<a href="javascript:loadDialog('createchallenge','<?php echo $CFG->homeAddress; ?>ui/popups/challengeadd.php', 750,600);" title='<?php echo $LNG->TAB_ADD_CHALLENGE_HINT; ?>' class="active mb-2">
														<img src="<?php echo $HUB_FLM->getImagePath('add.png'); ?>" alt="" /> 
														<?php echo $LNG->TAB_ADD_CHALLENGE_LINK; ?>
													</a>
												</span>
											<?php } ?>
											<div id="searchchallenge" class="toolbarIcons">
												<div id="challengebuttons">
													<a class="active me-3" title="<?php echo $LNG->TAB_RSS_CHALLENGE_HINT; ?>" onclick="getNodesFeed(CHALLENGE_ARGS);">
														<i class="fas fa-rss-square fa-lg" aria-hidden="true"></i> 
														<span class="sr-only">RSS feed</span>
													</a>
													<a class="active" title="<?php echo $LNG->TAB_PRINT_HINT_CHALLENGE; ?>" onclick="printNodes(CHALLENGE_ARGS, '<?php echo $LNG->TAB_PRINT_TITLE_CHALLENGE; ?>');">
														<i class="fas fa-print fa-lg" aria-hidden="true"></i> 
														<span class="sr-only">Print</span>
													</a>
												</div>
											</div>
										</div>
									</div>
									<div id="tab-content-data-challenge" class="tabcontentinner p-4"></div>
								<?php } ?>

								<div id="tab-content-data-issue-div" class="tabcontentuser issuebackpale" style="display:none">
									<div id="tab-content-issue-title" class="issueback tab-content-title"></div>
									<div id='tab-content-issue-search' class="tabcontentsearchuser row p-2">
										<?php if ( isset($USER->userid) && $USER->userid == $user->userid ) { ?>
											<span class="toolbar addChallenge">
												<a href="javascript:loadDialog('createissue','<?php echo $CFG->homeAddress; ?>ui/popups/issueadd.php', 750,600);" title='<?php echo $LNG->TAB_ADD_ISSUE_HINT; ?>' class="active mb-2">
													<img src="<?php echo $HUB_FLM->getImagePath('add.png'); ?>" alt="" /> 
													<?php echo $LNG->TAB_ADD_ISSUE_LINK; ?>
												</a>
											</span>
										<?php } ?>

										<div id="searchissue" class="toolbarIcons">
											<div class="row">
												<div class="col-lg-4 col-md-12">
													<div class="input-group">
														<input type="text" class="form-control" placeholder="<?php echo $LNG->TAB_SEARCH_ISSUE_LABEL; ?>" aria-label="<?php echo $LNG->TAB_SEARCH_ISSUE_LABEL; ?>" onkeyup="if (checkKeyPressed(event)) { $('issue-go-button').onclick();}" id="qissue" name="q" value="<?php if (isset($q)) { print( htmlspecialchars($q) ); } ?>" />
														<div id="q_choices" class="autocomplete"></div>
														<button class="btn btn-outline-dark bg-light" type="button" onclick="filterSearchIssues();"><?php echo $LNG->TAB_SEARCH_GO_BUTTON; ?></button>
														<button class="btn btn-outline-dark bg-light" type="button" onclick="ISSUE_ARGS['q'] = ''; ISSUE_ARGS['scope'] = 'all'; $('qissue').value='';if ($('scopechallangeall'))  $('scopechallangeall').checked=true; refreshIssues();"><?php echo $LNG->TAB_SEARCH_CLEAR_SEARCH_BUTTON; ?></button>
													</div>
													<?php
														// if search term is present in URL then show in search box
														$q = stripslashes(optional_param("q","",PARAM_TEXT));
														$scope = optional_param("scope","all",PARAM_TEXT);
														$tagsonly = optional_param("tagsonly","false",PARAM_TEXT);
													?>
												</div>
												<div class="col-lg-4 col-md-12">
													<div id="issuebuttons" class="rss-print-btn">
														<?php if ($CFG->hasRss) { ?>
															<a class="active me-3" title="<?php echo $LNG->TAB_RSS_ISSUE_HINT; ?>" onclick="getNodesFeed(ISSUE_ARGS);">
																<i class="fas fa-rss-square fa-lg" aria-hidden="true" ></i> 
																<span class="sr-only"><?php echo $LNG->TAB_RSS_ALT; ?></span>
															</a>
														<?php } ?>
														<a class="active" title="<?php echo $LNG->TAB_PRINT_HINT_ISSUE; ?>" onclick="printNodes(ISSUE_ARGS, '<?php echo $LNG->TAB_PRINT_TITLE_ISSUE; ?>');">
															<i class="fas fa-print fa-lg" aria-hidden="true" ></i> 
															<span class="sr-only"><?php echo $LNG->TAB_PRINT_ALT; ?></span>
														</a>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div id="tab-content-data-issue"  class="tabcontentinner p-4"></div>

								<?php if ($CFG->HAS_SOLUTION) { ?>
									<div id='tab-content-data-solution-div' class="tabcontentuser solutionbackpale" style="display:none">
										<div id="tab-content-solution-title" class="solutionback tab-content-title"></div>
										<div id='tab-content-solution-search' class='tabcontentsearchuser row p-2'>
											<?php if(isset($USER->userid) && $USER->userid == $user->userid){ ?>
												<span class="toolbar addChallenge">
													<a href="javascript:loadDialog('createsolution','<?php echo $CFG->homeAddress ?>ui/popups/solutionadd.php', 750,600);" title='<?php echo $LNG->TAB_ADD_SOLUTION_HINT; ?>' class="active mb-2">
														<img src="<?php echo $HUB_FLM->getImagePath('add.png'); ?>" alt="" /> <?php echo $LNG->TAB_ADD_SOLUTION_LINK; ?>
													</a>
												</span>
											<?php } ?>

											<div id="searchsolution" class="toolbarIcons">
												<div class="row">
													<div class="col-lg-4 col-md-12">
														<div class="input-group">
															<input type="text" class="form-control" placeholder="<?php echo $LNG->TAB_SEARCH_SOLUTION_LABEL; ?>" aria-label="<?php echo $LNG->TAB_SEARCH_SOLUTION_LABEL; ?>" onkeyup="if (checkKeyPressed(event)) { $('solution-go-button').onclick();}" id="qsolution" name="q" value="<?php print( htmlspecialchars($q) ); ?>" />
															<div id="q_choices" class="autocomplete"></div>
															<button class="btn btn-outline-dark bg-light" type="button" onclick="filterSearchSolutions();"><?php echo $LNG->TAB_SEARCH_GO_BUTTON; ?></button>
															<button class="btn btn-outline-dark bg-light" type="button" onclick="SOLUTION_ARGS['q'] = ''; SOLUTION_ARGS['scope'] = 'all'; $('qsolution').value='';if ($('scopesolutionall'))  $('scopesolutionall').checked=true; refreshSolutions();"><?php echo $LNG->TAB_SEARCH_CLEAR_SEARCH_BUTTON; ?></button>
														</div>
														<?php
															// if search term is present in URL then show in search box
															$q = stripslashes(optional_param("q","",PARAM_TEXT));
															$scope = optional_param("scopesolution","all",PARAM_TEXT);
															$tagsonly = optional_param("tagsonly","false",PARAM_TEXT);
														?>
													</div>
													<div class="col-lg-4 col-md-12">
														<div id="solutionbuttons" class="rss-print-btn">
															<?php if ($CFG->hasRss) { ?>
																<a class="active me-3" title="<?php echo $LNG->TAB_RSS_SOLUTION_HINT; ?>" onclick="getNodesFeed(SOLUTION_ARGS);">
																	<i class="fas fa-rss-square fa-lg" aria-hidden="true" ></i> 
																	<span class="sr-only"><?php echo $LNG->TAB_RSS_ALT; ?></span>
																</a>
															<?php } ?>
															<a class="active" title="<?php echo $LNG->TAB_PRINT_HINT_ISSUE; ?>" onclick="printNodes(SOLUTION_ARGS, '<?php echo $LNG->TAB_PRINT_TITLE_SOLUTION; ?>');">
																<i class="fas fa-print fa-lg" aria-hidden="true" ></i> 
																<span class="sr-only"><?php echo $LNG->TAB_PRINT_ALT; ?></span>
															</a>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div id="tab-content-data-solution" class="tabcontentinner p-4"></div>
								<?php } ?>

								<?php if ($CFG->HAS_CLAIM) { ?>
									<div id='tab-content-data-claim-div' class="tabcontentuser claimbackpale" style="display:none">
										<div id="tab-content-claim-title" class="claimback tab-content-title"></div>
										<div id='tab-content-claim-search' class="tabcontentsearchuser row p-2">
											<?php if(isset($USER->userid) && $USER->userid == $user->userid){ ?>
												<span class="toolbar addChallenge">
													<a href="javascript:loadDialog('createclaim','<?php echo $CFG->homeAddress ?>ui/popups/claimadd.php', 750,600);" title='<?php echo $LNG->TAB_ADD_CLAIM_HINT; ?>' class="active mb-2">
														<img src="<?php echo $HUB_FLM->getImagePath('add.png'); ?>" alt="" /> <?php echo $LNG->TAB_ADD_CLAIM_LINK; ?>
													</a>
												</span>
											<?php } ?>
											<div id="searchclaim" class="toolbarIcons">
												<div class="row">
													<div class="col-lg-4 col-md-12">
														<div class="input-group">
															<input type="text" class="form-control" placeholder="<?php echo $LNG->TAB_SEARCH_CLAIM_LABEL; ?>" aria-label="<?php echo $LNG->TAB_SEARCH_CLAIM_LABEL; ?>" onkeyup="if (checkKeyPressed(event)) { $('claim-go-button').onclick();}" id="qclaim" name="q" value="<?php print( htmlspecialchars($q) ); ?>" />
															<div id="q_choices" class="autocomplete"></div>
															<button class="btn btn-outline-dark bg-light" type="button" onclick="filterSearchClaims();"><?php echo $LNG->TAB_SEARCH_GO_BUTTON; ?></button>
															<button class="btn btn-outline-dark bg-light" type="button" onclick="CLAIM_ARGS['q'] = ''; CLAIM_ARGS['scope'] = 'all'; $('qclaim').value='';if ($('scopeclaimall'))  $('scopeclaimall').checked=true; refreshClaims();"><?php echo $LNG->TAB_SEARCH_CLEAR_SEARCH_BUTTON; ?></button>
														</div>
														<?php
															// if search term is present in URL then show in search box
															$q = stripslashes(optional_param("q","",PARAM_TEXT));
															$scope = optional_param("scope","all",PARAM_TEXT);
															$tagsonly = optional_param("tagsonly","false",PARAM_TEXT);
														?>
													</div>
													<div class="col-lg-4 col-md-12">
														<div id="claimbuttons" class="rss-print-btn">
															<?php if ($CFG->hasRss) { ?>
																<a class="active me-3" title="<?php echo $LNG->TAB_RSS_CLAIM_HINT; ?>" onclick="getNodesFeed(CLAIM_ARGS);">
																	<i class="fas fa-rss-square fa-lg" aria-hidden="true" ></i> 
																	<span class="sr-only"><?php echo $LNG->TAB_RSS_ALT; ?></span>
																</a>
															<?php } ?>
															<a class="active" title="<?php echo $LNG->TAB_PRINT_HINT_CLAIM; ?>" onclick="printNodes(CLAIM_ARGS, '<?php echo $LNG->TAB_PRINT_TITLE_CLAIM; ?>');">
																<i class="fas fa-print fa-lg" aria-hidden="true" ></i> 
																<span class="sr-only"><?php echo $LNG->TAB_PRINT_ALT; ?></span>
															</a>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div id="tab-content-data-claim" class="tabcontentinner p-4"></div>
								<?php } ?>

								<div id='tab-content-data-evidence-div' class="tabcontentuser evidencebackpale" style="display:none">
									<div id="tab-content-evidence-title" class="evidenceback tab-content-title"></div>
									<div id='tab-content-evidence-search' class="tabcontentsearchuser row p-2">
										<?php if(isset($USER->userid) && $USER->userid == $user->userid){ ?>
											<span class="toolbar addChallenge">
												<a href="javascript:loadDialog('createevidence','<?php echo $CFG->homeAddress ?>ui/popups/evidenceadd.php', 755,670);" title='<?php echo $LNG->TAB_ADD_EVIDENCE_HINT; ?>' class="active mb-2">
													<img src="<?php echo $HUB_FLM->getImagePath('add.png'); ?>" alt="" /> 
													<?php echo $LNG->TAB_ADD_EVIDENCE_LINK; ?>
												</a>
											</span>
										<?php } ?>

										<div id="searchevidence" class="toolbarIcons">
											<div class="row">
												<div class="col-lg-4 col-md-12">
													<div class="input-group">
														<input type="text" class="form-control" placeholder="<?php echo $LNG->TAB_SEARCH_EVIDENCE_LABEL; ?>" aria-label="<?php echo $LNG->TAB_SEARCH_EVIDENCE_LABEL; ?>" onkeyup="if (checkKeyPressed(event)) { $('evidence-go-button').onclick();}" id="qevidence" name="q" value="<?php print( htmlspecialchars($q) ); ?>" />
														<div id="q_choices" class="autocomplete"></div>
														<button class="btn btn-outline-dark bg-light" type="button" onclick="filterSearchEvidence();"><?php echo $LNG->TAB_SEARCH_GO_BUTTON; ?></button>
														<button class="btn btn-outline-dark bg-light" type="button" onclick="EVIDENCE_ARGS['q'] = ''; EVIDENCE_ARGS['scope'] = 'all'; $('qevidence').value='';if ($('scopeevidenceall'))  $('scopeevidenceall').checked=true; refreshEvidence();"><?php echo $LNG->TAB_SEARCH_CLEAR_SEARCH_BUTTON; ?></button>
													</div>
													<?php
														// if search term is present in URL then show in search box
														$q = stripslashes(optional_param("q","",PARAM_TEXT));
														$scope = optional_param("scope","all",PARAM_TEXT);
														$tagsonly = optional_param("tagsonly","false",PARAM_TEXT);
													?>
												</div>
												<div class="col-lg-4 col-md-12">
													<div id="evidencebuttons" class="rss-print-btn">
														<?php if ($CFG->hasRss) { ?>
															<a class="active me-3" title="<?php echo $LNG->TAB_RSS_EVIDENCE_HINT; ?>" onclick="getNodesFeed(EVIDENCE_ARGS);">
																<i class="fas fa-rss-square fa-lg" aria-hidden="true" ></i> 
																<span class="sr-only"><?php echo $LNG->TAB_RSS_ALT; ?></span>
															</a>
														<?php } ?>
														<a class="active" title="<?php echo $LNG->TAB_PRINT_HINT_EVIDENCE; ?>" onclick="printNodes(EVIDENCE_ARGS, '<?php echo $LNG->TAB_PRINT_TITLE_EVIDENCE; ?>');">
															<i class="fas fa-print fa-lg" aria-hidden="true" ></i> 
															<span class="sr-only"><?php echo $LNG->TAB_PRINT_ALT; ?></span>
														</a>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div id='tab-content-data-evidence' class="tabcontentinner p-4"></div>

								<div id='tab-content-data-resource-div' class="tabcontentuser resourcebackpale" style="display:none">
									<div id="tab-content-resource-title" class="resourceback tab-content-title"></div>
									<div id='tab-content-resource-search' class="tabcontentsearchuser row p-2">
										<?php if(isset($USER->userid) && $USER->userid == $user->userid){ ?>
											<span class="toolbar addChallenge">
												<a href="javascript:loadDialog('createresource','<?php echo $CFG->homeAddress ?>ui/popups/resourceadd.php', 750,600);" title='<?php echo $LNG->TAB_ADD_RESOURCE_HINT; ?>' class="active mb-2">
													<img src="<?php echo $HUB_FLM->getImagePath('add.png'); ?>" alt="" /> 
													<?php echo $LNG->TAB_ADD_RESOURCE_LINK; ?>
												</a>
											</span>
										<?php } ?>

										<div id="searchweb" class="toolbarIcons">
											<div class="row">
												<div class="col-lg-4 col-md-12">
													<div class="input-group">
														<input type="text" class="form-control" placeholder="<?php echo $LNG->TAB_SEARCH_RESOURCE_LABEL; ?>" aria-label="<?php echo $LNG->TAB_SEARCH_RESOURCE_LABEL; ?>" onkeyup="if (checkKeyPressed(event)) { $('web-go-button').onclick();}" id="qweb" name="q" value="<?php print( htmlspecialchars($q) ); ?>" />
														<div id="q_choices" class="autocomplete"></div>
														<button class="btn btn-outline-dark bg-light" type="button" onclick="filterSearchResources();"><?php echo $LNG->TAB_SEARCH_GO_BUTTON; ?></button>
														<button class="btn btn-outline-dark bg-light" type="button" onclick="RESOURCE_ARGS['q'] = ''; RESOURCE_ARGS['searchid'] = '';  RESOURCE_ARGS['scope'] = 'all'; $('qweb').value='';if ($('scopechallangeall'))  $('scopechallangeall').checked=true; refreshResources();"><?php echo $LNG->TAB_SEARCH_CLEAR_SEARCH_BUTTON; ?></button>
													</div>
													<?php
														// if search term is present in URL then show in search box
														$q = stripslashes(optional_param("q","",PARAM_TEXT));
														$scope = optional_param("scope","all",PARAM_TEXT);
														$tagsonly = optional_param("tagsonly","false",PARAM_TEXT);
													?>
												</div>
												<div class="col-lg-4 col-md-12">
													<div id="webbuttons" class="rss-print-btn">
														<?php if ($CFG->hasRss) { ?>
															<a class="active me-3" title="<?php echo $LNG->TAB_RSS_RESOURCE_HINT; ?>" onclick="getNodesFeed(RESOURCE_ARGS);">
																<i class="fas fa-rss-square fa-lg" aria-hidden="true" ></i> 
																<span class="sr-only"><?php echo $LNG->TAB_RSS_ALT; ?></span>
															</a>
														<?php } ?>
														<a class="active" title="<?php echo $LNG->TAB_PRINT_HINT_RESOURCE; ?>" onclick="printNodes(RESOURCE_ARGS, '<?php echo $LNG->TAB_PRINT_TITLE_RESOURCE; ?>');">
															<i class="fas fa-print fa-lg" aria-hidden="true" ></i> 
															<span class="sr-only"><?php echo $LNG->TAB_PRINT_ALT; ?></span>
														</a>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div id='tab-content-data-resource' class="tabcontentinner p-4"></div>

								<div id='tab-content-data-org-div' class="tabcontentuser orgbackpale" style="display:none">
									<div id="tab-content-org-title" class="orgback tab-content-title"></div>
									<div id='tab-content-org-search' class="tabcontentsearchuser row p-2">
										<?php if(isset($USER->userid) && $USER->userid == $user->userid){ ?>
											<span class="toolbar addChallenge">
												<a href="javascript:loadDialog('createorg','<?php echo $CFG->homeAddress; ?>ui/popups/organizationadd.php?type=Organization', 750,600);" title='<?php echo $LNG->TAB_ADD_ORG_HINT; ?>' class="active mb-2">
													<img src="<?php echo $HUB_FLM->getImagePath('add.png'); ?>" alt="" /> 
													<?php echo $LNG->TAB_ADD_ORG_LINK; ?>
												</a>
											</span>
										<?php } ?>

										<div id="searchorg" class="toolbarIcons">
											<div class="row">
												<div class="col-lg-4 col-md-12">
													<div class="input-group">
														<input type="text" class="form-control" placeholder="<?php echo $LNG->TAB_SEARCH_ORG_LABEL; ?>" aria-label="<?php echo $LNG->TAB_SEARCH_ORG_LABEL; ?>" onkeyup="if (checkKeyPressed(event)) { $('org-go-button').onclick();}" id="qorg" name="q" value="<?php print( htmlspecialchars($q) ); ?>" />
														<div id="q_choices" class="autocomplete"></div>
														<button class="btn btn-outline-dark bg-light" type="button" onclick="filterSearchOrgs();"><?php echo $LNG->TAB_SEARCH_GO_BUTTON; ?></button>
														<button class="btn btn-outline-dark bg-light" type="button" onclick="ORG_ARGS['q'] = ''; ORG_ARGS['scope'] = 'all'; $('qorg').value='';if ($('scopeorgall'))  $('scopeorgall').checked=true; refreshOrganizations();"><?php echo $LNG->TAB_SEARCH_CLEAR_SEARCH_BUTTON; ?></button>
													</div>
													<?php
														// if search term is present in URL then show in search box
														$q = stripslashes(optional_param("q","",PARAM_TEXT));
														$scope = optional_param("scope","all",PARAM_TEXT);
														$tagsonly = optional_param("tagsonly","false",PARAM_TEXT);
													?>
												</div>
												<div class="col-lg-4 col-md-12">
													<div id="orgbuttons" class="rss-print-btn">
														<?php if ($CFG->hasRss) { ?>
															<a class="active me-3" title="<?php echo $LNG->TAB_RSS_ORG_HINT; ?>" onclick="getNodesFeed(ORG_ARGS);">
																<i class="fas fa-rss-square fa-lg" aria-hidden="true" ></i> 
																<span class="sr-only"><?php echo $LNG->TAB_RSS_ALT; ?></span>
															</a>
														<?php } ?>
														<a class="active" title="<?php echo $LNG->TAB_PRINT_HINT_ORG; ?>" onclick="printNodes(ORG_ARGS, '<?php echo $LNG->TAB_PRINT_TITLE_ORG; ?>');">
															<i class="fas fa-print fa-lg" aria-hidden="true" ></i> 
															<span class="sr-only"><?php echo $LNG->TAB_PRINT_ALT; ?></span>
														</a>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div id='tab-content-data-org' class="tabcontentinner p-4"></div>

								<div id='tab-content-data-project-div' class="tabcontentuser projectbackpale" style="display:none">
									<div id="tab-content-project-title" class="projectback tab-content-title"></div>
									<div id='tab-content-project-search' class="tabcontentsearchuser row p-2">
										<?php if(isset($USER->userid) && $USER->userid == $user->userid){ ?>
											<span class="toolbar addChallenge">
												<a href="javascript:loadDialog('createproject','<?php echo $CFG->homeAddress; ?>ui/popups/organizationadd.php?type=Project', 750,600);" title='<?php echo $LNG->TAB_ADD_PROJECT_HINT; ?>' class="active mb-2">
													<img src="<?php echo $HUB_FLM->getImagePath('add.png'); ?>" alt="" /> 
													<?php echo $LNG->TAB_ADD_PROJECT_LINK; ?>
												</a>
											</span>
										<?php } ?>
										<div id="searchproject" class="toolbarIcons">
											<div class="row">
												<div class="col-lg-4 col-md-12">
													<div class="input-group">
														<input type="text" class="form-control" placeholder="<?php echo $LNG->TAB_SEARCH_ORG_LABEL; ?>" aria-label="<?php echo $LNG->TAB_SEARCH_ORG_LABEL; ?>" onkeyup="if (checkKeyPressed(event)) { $('project-go-button').onclick();}" id="qproject" name="q" value="<?php print( htmlspecialchars($q) ); ?>" />
														<div id="q_choices" class="autocomplete"></div>
														<button class="btn btn-outline-dark bg-light" type="button" onclick="filterSearchProjects();"><?php echo $LNG->TAB_SEARCH_GO_BUTTON; ?></button>
														<button class="btn btn-outline-dark bg-light" type="button" onclick="PROJECT_ARGS['q'] = ''; PROJECT_ARGS['scope'] = 'all'; $('qproject').value='';if ($('scopeprojectall'))  $('scopeprojectall').checked=true; refreshProjects();"><?php echo $LNG->TAB_SEARCH_CLEAR_SEARCH_BUTTON; ?></button>
													</div>
													<?php
														// if search term is present in URL then show in search box
														$q = stripslashes(optional_param("q","",PARAM_TEXT));
														$scope = optional_param("scope","all",PARAM_TEXT);
														$tagsonly = optional_param("tagsonly","false",PARAM_TEXT);
													?>
												</div>
												<div class="col-lg-4 col-md-12">
													<div id="projectbuttons" class="rss-print-btn">
														<?php if ($CFG->hasRss) { ?>
															<a class="active me-3" title="<?php echo $LNG->TAB_RSS_PROJECT_HINT; ?>" onclick="getNodesFeed(PROJECT_ARGS);">
																<i class="fas fa-rss-square fa-lg" aria-hidden="true" ></i> 
																<span class="sr-only"><?php echo $LNG->TAB_RSS_ALT; ?></span>
															</a>
														<?php } ?>
														<a class="active" title="<?php echo $LNG->TAB_PRINT_HINT_PROJECT; ?>" onclick="printNodes(PROJECT_ARGS, '<?php echo $LNG->TAB_PRINT_TITLE_PROJECT; ?>');">
															<i class="fas fa-print fa-lg" aria-hidden="true" ></i> 
															<span class="sr-only"><?php echo $LNG->TAB_PRINT_ALT; ?></span>
														</a>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div id='tab-content-data-project' class="tabcontentinner p-4"></div>


								<?php if ($CFG->HAS_OPEN_COMMENTS) { ?>
									<div id='tab-content-data-comment-div' class="tabcontentuser peoplebackpale" style="display:none">
										<div id="tab-content-comment-title" class="peopleback tab-content-title"></div>
										<div id='tab-content-search-comment' class="tabcontentsearchuser row p-2">
											<div id="searchcomment" class="toolbarIcons">
												<div class="row">
													<div class="col-lg-4 col-md-12">
														<div class="input-group">
															<input type="text" class="form-control" placeholder="<?php echo $LNG->TAB_SEARCH_COMMENT_LABEL; ?>" aria-label="<?php echo $LNG->TAB_SEARCH_COMMENT_LABEL; ?>" onkeyup="if (checkKeyPressed(event)) { $('comment-go-button').onclick();}" id="qcomment" name="q" value="<?php print( htmlspecialchars($q) ); ?>" />
															<div id="q_choices" class="autocomplete"></div>
															<button class="btn btn-outline-dark bg-light" type="button" onclick="filterSearchComments();"><?php echo $LNG->TAB_SEARCH_GO_BUTTON; ?></button>
															<button class="btn btn-outline-dark bg-light" type="button" onclick="COMMENT_ARGS['q'] = ''; COMMENT_ARGS['searchid'] = ''; COMMENT_ARGS['scope'] = 'all'; $('qcomment').value='';if ($('scopechallangeall'))  $('scopechallangeall').checked=true; refreshComments();"><?php echo $LNG->TAB_SEARCH_CLEAR_SEARCH_BUTTON; ?></button>
														</div>
														<?php
															// if search term is present in URL then show in search box
															$q = stripslashes(optional_param("q","",PARAM_TEXT));
															$scope = optional_param("scope","all",PARAM_TEXT);
															$tagsonly = optional_param("tagsonly","false",PARAM_TEXT);
														?>
													</div>
													<div class="col-lg-4 col-md-12">
														<div id="commentbuttons" class="rss-print-btn">
															<?php if ($CFG->hasRss) { ?>
																<a class="active me-3" title="<?php echo $LNG->TAB_RSS_COMMENT_HINT; ?>" onclick="getNodesFeed(COMMENT_ARGS);">
																	<i class="fas fa-rss-square fa-lg" aria-hidden="true" ></i> 
																	<span class="sr-only"><?php echo $LNG->TAB_RSS_ALT; ?></span>
																</a>
															<?php } ?>
															<a class="active" title="<?php echo $LNG->TAB_PRINT_HINT_COMMENT; ?>" onclick="printNodes(COMMENT_ARGS, '<?php echo $LNG->TAB_PRINT_TITLE_COMMENT; ?>');">
																<i class="fas fa-print fa-lg" aria-hidden="true" ></i> 
																<span class="sr-only"><?php echo $LNG->TAB_PRINT_ALT; ?></span>
															</a>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div id='tab-content-data-comment' class="tabcontentinner p-4"></div>
								<?php } ?>

								<div id='tab-content-data-chat-div' class="tabcontentuser peoplebackpale" style="display:none">
									<div id="tab-content-challenge-title" class="peopleback tab-content-title"></div>
									<div id='tab-content-search-chat' class="tabcontentsearchuser row p-2">
										<div id="searchchat" class="toolbarIcons">
											<div class="row">
												<div class="col-lg-4 col-md-12">
													<div class="input-group">
														<input type="text" class="form-control" placeholder="<?php echo $LNG->TAB_SEARCH_CHAT_LABEL; ?>" aria-label="<?php echo $LNG->TAB_SEARCH_CHAT_LABEL; ?>" onkeyup="if (checkKeyPressed(event)) { $('chat-go-button').onclick();}" id="qchat" name="q" value="<?php print( htmlspecialchars($q) ); ?>" />
														<div id="q_choices" class="autocomplete"></div>
														<button class="btn btn-outline-dark bg-light" type="button" onclick="filterSearchChats();"><?php echo $LNG->TAB_SEARCH_GO_BUTTON; ?></button>
														<button class="btn btn-outline-dark bg-light" type="button" onclick="CHAT_ARGS['q'] = ''; CHAT_ARGS['searchid'] = ''; CHAT_ARGS['scope'] = 'all'; $('qchat').value='';if ($('scopechallangeall'))  $('scopechallangeall').checked=true; refreshChats();"><?php echo $LNG->TAB_SEARCH_CLEAR_SEARCH_BUTTON; ?></button>
													</div>
													<?php
														// if search term is present in URL then show in search box
														$q = stripslashes(optional_param("q","",PARAM_TEXT));
														$scope = optional_param("scope","all",PARAM_TEXT);
														$tagsonly = optional_param("tagsonly","false",PARAM_TEXT);
													?>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div id='tab-content-data-chat' class="tabcontentinner p-4"></div>
							</div>
						</div>
					</div>
            	</div>
			</div>

            <div id='tab-content-social-div' class='tabcontent border border-top-0 p-3'>
	  			<div id="tab-content-user-bar" class="">
	  				<div class="peopleback tabtitlebar"></div>
	  			</div>
	            <div id="tab-content-social"></div>
				<div class="clearfix"></div>
			</div>
		</div>
	</div>
<?php } ?>

<script type='text/javascript'>
	function updateUserFollow() {
		$('followupdate').submit()
	}
</script>
