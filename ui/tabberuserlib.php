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

    <div id="tabber" style="clear:both;float:left; width: 100%;">
        <ul id="tabs" class="tab">
			<li class="tab"><a class="tab" id="tab-home" href="#home"><span class="tab tabuser"><?php echo $LNG->TAB_USER_HOME; ?></span></a></li>
			<li class="tab"><a class="tab" id="tab-data" href="#data"><span class="tab tabuser"><?php echo $LNG->TAB_USER_DATA; ?></span></a></li>
			<li class="tab"><a class="tab" id="tab-social" href="#social"><span class="tab tabuser"><?php echo $LNG->TAB_USER_SOCIAL; ?></span></a></li>
        </ul>
        <div id="tabs-content" style="float: left; width: 100%;">

			<!-- HOME TAB PAGES -->
            <div id='tab-content-home-div' class='tabcontentouter' style='width: 100%;background: white;padding:0px;margin:0px;'>
	  			<div class="peopleback" style="clear:both;float:left;width:100%;margin:0px;">
	  				<div class="peopleback tabtitlebar" style="padding:4px;margin:0px;font-size:9pt"></div>
	  			</div>
	            <div id='tab-content-home'>
	            <?php include($HUB_FLM->getCodeDirPath("ui/homepageuser.php")); ?>
	            </div>
			</div>

			<!-- DATA TAB PAGE -->
			<div id='tab-content-data-div' class='tabcontent' style="display:none;padding:0px;margin:0px;">
	  			<div class="peopleback" style="height:8px;clear:both;float:left;width:100%;margin:0px;"></div>

            	<div id='tab-content-toolbar-data' style='clear:both; float:left; width: 100%; height: 100%'>
					<div id="tabber" style="width:100%">

						<div id="datatabs">
							<ul id="tabs" class="tab2">
								<?php if ($CFG->HAS_CHALLENGE) {
									if ($args['userid'] == $USER->userid && $USER->getIsAdmin() == "Y") { ?>
									<li class="tab"><a class="tab" id="tab-data-challenge" href="#data-challenge"><span class="tab tabchallenge"><?php echo $LNG->TAB_USER_CHALLENGE; ?> <span id="challenge-list-count"></span></span></a></li>
								<?php } } ?>
								<?php if ( $CFG->issuesManaged == false || ($CFG->issuesManaged == true && $USER->getIsAdmin() == "Y") ) { ?>
									<li class="tab"><a class="tab" id="tab-data-issue" href="#data-issue"><span class="tab tabissue"><?php echo $LNG->TAB_USER_ISSUE; ?> <span id="issue-list-count"></span></span></a></li>
								<?php } ?>
								<?php if ($CFG->HAS_SOLUTION) { ?>
									<li class="tab"><a class="tab" id="tab-data-solution" href="#data-solution"><span class="tab tabsolution"><?php echo $LNG->TAB_USER_SOLUTION ?> <span id="solution-list-count"></span></span></a></li>
								<?php } ?>
								<?php if ($CFG->HAS_CLAIM) { ?>
									<li class="tab"><a class="tab" id="tab-data-claim" href="#data-claim"><span class="tab tabclaim"><?php echo $LNG->TAB_USER_CLAIM; ?> <span id="claim-list-count"></span></span></a></li>
								<?php } ?>
								<li class="tab"><a class="tab" id="tab-data-evidence" href="#data-evidence"><span class="tab tabevidence"><?php echo $LNG->TAB_USER_EVIDENCE; ?> <span id="evidence-list-count"></span></span></a></li>
								<li class="tab"><a class="tab" id="tab-data-resource" href="#data-resource"><span class="tab tabresource"><?php echo $LNG->TAB_USER_RESOURCE; ?> <span id="resource-list-count"></span></span></a></li>
								<li class="tab"><a class="tab" id="tab-data-org" href="#data-org"><span class="tab taborg"><?php echo $LNG->TAB_USER_ORG; ?> <span id="org-list-count"></span></span></a></li>
								<li class="tab"><a class="tab" id="tab-data-project" href="#data-project"><span class="tab tabproject"><?php echo $LNG->TAB_USER_PROJECT; ?> <span id="project-list-count"></span></span></a></li>
								<li class="tab"><a class="tab" id="tab-data-chat" href="#data-chat"><span class="tab tabuser"><?php echo $LNG->TAB_USER_CHAT; ?> <span id="chat-list-count"></span></span></a></li>
								<?php if ($CFG->HAS_OPEN_COMMENTS) { ?>
									<li class="tab"><a class="tab" id="tab-data-comment" href="#data-comment"><span class="tab tabuser"><?php echo $LNG->TAB_USER_COMMENT; ?> <span id="comment-list-count"></span></span></a></li>
								<?php } ?>
							</ul>
						</div>

						<div id="tab-content-data" class="tabcontentinner" style="width:100%">
							<?php if ($CFG->HAS_CHALLENGE) { ?>
	           					<div id="tab-content-data-challenge-div" class="tabcontentuser challengebackpale" style="display:none">
									<div id="tab-content-challenge-title" class="challengeback" style="height:2px;clear:both;float:left;width:100%;margin:0px;"></div>
									<div id='tab-content-challenge-search' style='margin:5px;padding-top:1px;clear:both; float:left; width: 100%;'>
										<?php if(isset($USER->userid) && $USER->getIsAdmin() == "Y" && $USER->userid == $user->userid){ ?>
										<span class="toolbar" style="margin-top:0px;">
											<a style="font-size: 12pt" href="javascript:loadDialog('createchallenge','<?php echo $CFG->homeAddress; ?>ui/popups/challengeadd.php', 750,600);" title='<?php echo $LNG->TAB_ADD_CHALLENGE_HINT; ?>'><img style="vertical-align:bottom" src="<?php echo $HUB_FLM->getImagePath('add.png'); ?>" border="0" style="margin:0px;margin-left: 5px;padding:0px" /> <?php echo $LNG->TAB_ADD_CHALLENGE_LINK; ?></a>
										</span>
										<?php } ?>

										<div id="searchchallenge" style="float:left;margin-left: 10px;">
											<div style="float:left;margin-left: 10px;" id="challengebuttons">
												<img src="<?php echo $HUB_FLM->getImagePath('feed-icon-20x20.png'); ?>" alt="<?php echo $LNG->TAB_RSS_ALT; ?>" title="<?php echo $LNG->TAB_RSS_CHALLENGE_HINT; ?>" class="active" style="padding-top:0px;padding-left:10px;" border="0" onclick="javascript: getNodesFeed(CHALLENGE_ARGS);" />
												<img src="<?php echo $HUB_FLM->getImagePath('printer.png'); ?>" alt="<?php echo $LNG->TAB_PRINT_ALT; ?>" title="<?php echo $LNG->TAB_PRINT_HINT_CHALLENGE; ?>" class="active" style="padding-top:0px;padding-left:10px;" border="0" onclick="javascript: printNodes(CHALLENGE_ARGS, '<?php echo $LNG->TAB_PRINT_TITLE_CHALLENGE; ?>');" />
											</div>
										</div>
									</div>

	           						<div id="tab-content-data-challenge" class="tabcontentinner"></div>
	           					</div>
							<?php } ?>


           					<div id="tab-content-data-issue-div" class="tabcontentuser issuebackpale" style="display:none">
								<div id="tab-content-issue-title" class="issueback" style="height:2px;clear:both;float:left;width:100%;margin:0px;"></div>
								<div id='tab-content-issue-search' class="tabcontentsearchuser">
									<?php if ( isset($USER->userid) && $USER->userid == $user->userid ) { ?>
										<span class="toolbar" style="margin-top:0px;">
											<a style="font-size: 12pt" href="javascript:loadDialog('createissue','<?php echo $CFG->homeAddress; ?>ui/popups/issueadd.php', 750,600);" title='<?php echo $LNG->TAB_ADD_ISSUE_HINT; ?>'><img style="vertical-align:bottom" src="<?php echo $HUB_FLM->getImagePath('add.png'); ?>" border="0" style="margin:0px;margin-left: 5px;padding:0px" /> <?php echo $LNG->TAB_ADD_ISSUE_LINK; ?></a>
										</span>
									<?php } ?>
									<div id="searchissue" style="float:left;margin-left: 10px;">
										<label for="q" style="float: left; margin-right: 3px; margin-top: 3px;"><?php echo $LNG->TAB_SEARCH_ISSUE_LABEL; ?></label>

										<?php
											// if search term is present in URL then show in search box
											$q = stripslashes(optional_param("q","",PARAM_TEXT));
											$scope = optional_param("scope","all",PARAM_TEXT);
											$tagsonly = optional_param("tagsonly","false",PARAM_TEXT);
										?>

										<div style="float: left;">
											<input type="text" style="margin-right:3px; width:250px" onkeyup="if (checkKeyPressed(event)) { $('issue-go-button').onclick();}" id="qissue" name="q" value="<?php print( htmlspecialchars($q) ); ?>"/>
											<div style="clear: both;"></div>
											<div id="q_choices" class="autocomplete" style="border-color: white;"></div>
										 </div>
										<div style="float:left;">
											<img id="issue-go-button" src="<?php echo $HUB_FLM->getImagePath('search.png'); ?>" class="active" width="20" height="20" onclick="javascript: filterSearchIssues();" title="<?php echo $LNG->TAB_SEARCH_GO_BUTTON; ?>" alt="<?php echo $LNG->TAB_SEARCH_GO_BUTTON; ?>" />
										</div>
										<div style="float:left;margin-left: 10px;">
											<img src="<?php echo $HUB_FLM->getImagePath('search-clear.png'); ?>" class="active" width="20" height="20" onclick="javascript: ISSUE_ARGS['q'] = ''; ISSUE_ARGS['scope'] = 'all'; $('qissue').value='';if ($('scopechallangeall'))  $('scopechallangeall').checked=true; refreshIssues();" title="<?php echo $LNG->TAB_SEARCH_CLEAR_SEARCH_BUTTON; ?>" alt="<?php echo $LNG->TAB_SEARCH_CLEAR_SEARCH_BUTTON; ?>" />
										</div>
										<div style="float:left;margin-left: 10px;" id="issuebuttons">
											<img src="<?php echo $HUB_FLM->getImagePath('feed-icon-20x20.png'); ?>" alt="<?php echo $LNG->TAB_RSS_ALT; ?>" title="<?php echo $LNG->TAB_RSS_ISSUE_HINT; ?>" class="active" style="padding-top:0px;padding-left:10px;" border="0" onclick="javascript: getNodesFeed(ISSUE_ARGS);" />
											<img src="<?php echo $HUB_FLM->getImagePath('printer.png'); ?>" alt="<?php echo $LNG->TAB_PRINT_ALT; ?>" title="<?php echo $LNG->TAB_PRINT_HINT_ISSUE; ?>" class="active" style="padding-top:0px;padding-left:10px;" border="0" onclick="javascript: printNodes(ISSUE_ARGS, '<?php echo $LNG->TAB_PRINT_TITLE_ISSUE; ?>');" />
										</div>
									 </div>
								</div>
           						<div id="tab-content-data-issue"  class="tabcontentinner"></div>
           					</div>

							<?php if ($CFG->HAS_SOLUTION) { ?>
								<div id='tab-content-data-solution-div' class="tabcontentuser solutionbackpale" style="display:none">
									<div id="tab-content-solution-title" class="solutionback" style="height:2px;clear:both;float:left;width:100%;margin:0px;"></div>
									<div id='tab-content-solution-search' class='tabcontentsearchuser'>
										<?php if(isset($USER->userid) && $USER->userid == $user->userid){ ?>
										<span class="toolbar" style="margin-top:0px;">
											<a style="font-size: 12pt" href="javascript:loadDialog('createsolution','<?php echo $CFG->homeAddress ?>ui/popups/solutionadd.php', 750,600);" title='<?php echo $LNG->TAB_ADD_SOLUTION_HINT; ?>'><img style="vertical-align:bottom" src="<?php echo $HUB_FLM->getImagePath('add.png'); ?>" border="0" style="margin:0px;margin-left: 5px;padding:0px" /> <?php echo $LNG->TAB_ADD_SOLUTION_LINK; ?></a>
										</span>
										<?php } ?>

										<div id="searchsolution" style="float:left;margin-left: 10px;">
											<label for="q" style="float: left; margin-right: 3px; margin-top: 3px;"><?php echo $LNG->TAB_SEARCH_SOLUTION_LABEL; ?></label>

											<?php
												// if search term is present in URL then show in search box
												$q = stripslashes(optional_param("q","",PARAM_TEXT));
												$scope = optional_param("scopesolution","all",PARAM_TEXT);
												$tagsonly = optional_param("tagsonly","false",PARAM_TEXT);
											?>

											<div style="float: left;">
												<input type="text" style="margin-right:3px; width:250px" onkeyup="if (checkKeyPressed(event)) { $('solution-go-button').onclick();}" id="qsolution" name="q" value="<?php print( htmlspecialchars($q) ); ?>"/>
												<div style="clear: both;"></div>
												<div id="q_choices" class="autocomplete" style="border-color: white;"></div>
											</div>
											<div style="float:left;">
												<img id="solution-go-button" src="<?php echo $HUB_FLM->getImagePath('search.png'); ?>" class="active" width="20" height="20" onclick="javascript: filterSearchSolutions();" title="<?php echo $LNG->TAB_SEARCH_GO_BUTTON; ?>" alt="<?php echo $LNG->TAB_SEARCH_GO_BUTTON; ?>" />
											</div>
											<div style="float:left;margin-left: 10px;">
												<img src="<?php echo $HUB_FLM->getImagePath('search-clear.png'); ?>" class="active" width="20" height="20" onclick="javascript: SOLUTION_ARGS['q'] = ''; SOLUTION_ARGS['scope'] = 'all';$('qsolution').value='';if ($('scopesolutionall'))  $('scopesolutionall').checked=true;  refreshSolutions();" title="<?php echo $LNG->TAB_SEARCH_CLEAR_SEARCH_BUTTON; ?>" alt="<?php echo $LNG->TAB_SEARCH_CLEAR_SEARCH_BUTTON; ?>" />
											</div>
											<div style="float:left;margin-left: 10px;" id="solutionbuttons">
												<img src="<?php echo $HUB_FLM->getImagePath('feed-icon-20x20.png'); ?>" alt="<?php echo $LNG->TAB_RSS_ALT; ?>" title="<?php echo $LNG->TAB_RSS_SOLUTION_HINT; ?>" class="active" style="padding-top:0px;padding-left:10px;" border="0" onclick="javascript: getNodesFeed(SOLUTION_ARGS);" />
												<img src="<?php echo $HUB_FLM->getImagePath('printer.png'); ?>" alt="<?php echo $LNG->TAB_PRINT_ALT; ?>" title="<?php echo $LNG->TAB_PRINT_HINT_SOLUTION; ?>" class="active" style="padding-top:0px;padding-left:10px;" border="0" onclick="javascript: printNodes(SOLUTION_ARGS, '<?php echo $LNG->TAB_PRINT_TITLE_SOLUTION; ?>');" />
											</div>
										 </div>
									</div>

	           						<div id="tab-content-data-solution" class="tabcontentinner"></div>
	           					</div>
							<?php } ?>

							<?php if ($CFG->HAS_CLAIM) { ?>
	           					<div id='tab-content-data-claim-div' class="tabcontentuser claimbackpale" style="display:none">
									<div id="tab-content-claim-title" class="claimback" style="height:2px;clear:both;float:left;width:100%;margin:0px;"></div>
									<div id='tab-content-claim-search' class="tabcontentsearchuser">
										<?php if(isset($USER->userid) && $USER->userid == $user->userid){ ?>
										<span class="toolbar" style="margin-top:0px;">
											<a style="font-size: 12pt" href="javascript:loadDialog('createclaim','<?php echo $CFG->homeAddress ?>ui/popups/claimadd.php', 750,600);" title='<?php echo $LNG->TAB_ADD_CLAIM_HINT; ?>'><img style="vertical-align:bottom" src="<?php echo $HUB_FLM->getImagePath('add.png'); ?>" border="0" style="margin:0px;margin-left: 5px;padding:0px" /> <?php echo $LNG->TAB_ADD_CLAIM_LINK; ?></a>
										</span>
										<?php } ?>

										<div id="searchclaim" style="float:left;margin-left: 10px;">
											<label for="q" style="float: left; margin-right: 3px; margin-top: 3px;"><?php echo $LNG->TAB_SEARCH_CLAIM_LABEL; ?></label>

											<?php
												// if search term is present in URL then show in search box
												$q = stripslashes(optional_param("q","",PARAM_TEXT));
												$scope = optional_param("scope","all",PARAM_TEXT);
												$tagsonly = optional_param("tagsonly","false",PARAM_TEXT);
											?>

											<div style="float: left;">
												<input type="text" style="margin-right:3px; width:250px" onkeyup="if (checkKeyPressed(event)) { $('claim-go-button').onclick();}" id="qclaim" name="q" value="<?php print( htmlspecialchars($q) ); ?>"/>
												<div style="clear: both;"></div>
												<div id="q_choices" class="autocomplete" style="border-color: white;"></div>
											</div>
											<div style="float:left;">
												<img id="claim-go-button" src="<?php echo $HUB_FLM->getImagePath('search.png'); ?>" class="active" width="20" height="20" onclick="filterSearchClaims();" title="<?php echo $LNG->TAB_SEARCH_GO_BUTTON; ?>" alt="<?php echo $LNG->TAB_SEARCH_GO_BUTTON; ?>" />
											</div>
											<div style="float:left;margin-left: 10px;">
												<img src="<?php echo $HUB_FLM->getImagePath('search-clear.png'); ?>" class="active" width="20" height="20" onclick="javascript: CLAIM_ARGS['q'] = ''; CLAIM_ARGS['scope'] = 'all';$('qclaim').value='';if ($('scopeclaimall'))  $('scopeclaimall').checked=true;  refreshClaims();" title="<?php echo $LNG->TAB_SEARCH_CLEAR_SEARCH_BUTTON; ?>" alt="<?php echo $LNG->TAB_SEARCH_CLEAR_SEARCH_BUTTON; ?>" />
											</div>
											<div style="float:left;margin-left: 10px;" id="claimbuttons">
												<img src="<?php echo $HUB_FLM->getImagePath('feed-icon-20x20.png'); ?>" alt="<?php echo $LNG->TAB_RSS_ALT; ?>" title="<?php echo $LNG->TAB_RSS_CLAIM_HINT; ?>" class="active" style="padding-top:0px;padding-left:10px;" border="0" onclick="javascript: getNodesFeed(CLAIM_ARGS);" />
												<img src="<?php echo $HUB_FLM->getImagePath('printer.png'); ?>" alt="<?php echo $LNG->TAB_PRINT_ALT; ?>" title="<?php echo $LNG->TAB_PRINT_HINT_CLAIM; ?>" class="active" style="padding-top:0px;padding-left:10px;" border="0" onclick="javascript: printNodes(CLAIM_ARGS, '<?php echo $LNG->TAB_PRINT_TITLE_CLAIM; ?>');" />
											</div>
										</div>
									</div>

	           						<div id='tab-content-data-claim' style='background: white; clear:both; float:left; width:100%'></div>
	           					</div>
							<?php } ?>

							<div id='tab-content-data-evidence-div' class="tabcontentuser evidencebackpale" style="display:none">
								<div id="tab-content-evidence-title" class="evidenceback" style="height:2px;clear:both;float:left;width:100%;margin:0px;"></div>
								<div id='tab-content-evidence-search' class="tabcontentsearchuser">
									<?php if(isset($USER->userid) && $USER->userid == $user->userid){ ?>
									<span class="toolbar" style="margin-top:0px;">
										<a style="font-size: 12pt" href="javascript:loadDialog('createevidence','<?php echo $CFG->homeAddress ?>ui/popups/evidenceadd.php', 755,670);" title='<?php echo $LNG->TAB_ADD_EVIDENCE_HINT; ?>'><img style="vertical-align:bottom" src="<?php echo $HUB_FLM->getImagePath('add.png'); ?>" border="0" style="margin:0px;margin-left: 5px;padding:0px" /> <?php echo $LNG->TAB_ADD_EVIDENCE_LINK; ?></a>
									</span>
									<?php } ?>

									<div id="searchevidence" style="float:left;margin-left:10px;">
										<label for="q" style="float: left; margin-right: 3px; margin-top: 3px;"><?php echo $LNG->TAB_SEARCH_EVIDENCE_LABEL; ?></label>

										<?php
											// if search term is present in URL then show in search box
											$q = stripslashes(optional_param("q","",PARAM_TEXT));
											$scope = optional_param("scope","all",PARAM_TEXT);
											$tagsonly = optional_param("tagsonly","false",PARAM_TEXT);
										?>

										<div style="float: left;">
											<input type="text" style="margin-right:3px; width:250px" onkeyup="if (checkKeyPressed(event)) { $('evidence-go-button').onclick();}" id="qevidence" name="q" value="<?php print( htmlspecialchars($q) ); ?>"/>
											<div style="clear: both;"></div>
											<div id="q_choices" class="autocomplete" style="border-color: white;"></div>
										</div>
										<div style="float:left;">
											<img id="evidence-go-button" src="<?php echo $HUB_FLM->getImagePath('search.png'); ?>" class="active" width="20" height="20" onclick="javascript: filterSearchEvidence();" title="<?php echo $LNG->TAB_SEARCH_GO_BUTTON; ?>" alt="<?php echo $LNG->TAB_SEARCH_GO_BUTTON; ?>" />
										</div>
										<div style="float:left;margin-left: 10px;">
											<img src="<?php echo $HUB_FLM->getImagePath('search-clear.png'); ?>" class="active" width="20" height="20" onclick="javascript: EVIDENCE_ARGS['q'] = ''; EVIDENCE_ARGS['scope'] = 'all';$('qevidence').value='';if ($('scopeevidenceall'))  $('scopeevidenceall').checked=true;  refreshEvidence();" title="<?php echo $LNG->TAB_SEARCH_CLEAR_SEARCH_BUTTON; ?>" alt="<?php echo $LNG->TAB_SEARCH_CLEAR_SEARCH_BUTTON; ?>" />
										</div>
										<div style="float:left;margin-left: 10px;" id="evidencebuttons">
											<img src="<?php echo $HUB_FLM->getImagePath('feed-icon-20x20.png'); ?>" alt="<?php echo $LNG->TAB_RSS_ALT; ?>" title="<?php echo $LNG->TAB_RSS_EVIDENCE_HINT; ?>" class="active" style="padding-top:0px;padding-left:10px;" border="0" onclick="javascript: getNodesFeed(EVIDENCE_ARGS);" />
											<img src="<?php echo $HUB_FLM->getImagePath('printer.png'); ?>" alt="<?php echo $LNG->TAB_PRINT_ALT; ?>" title="<?php echo $LNG->TAB_PRINT_HINT_EVIDENCE; ?>" class="active" style="padding-top:0px;padding-left:10px;" border="0" onclick="javascript: printNodes(EVIDENCE_ARGS, '<?php echo $LNG->TAB_PRINT_TITLE_EVIDENCE; ?>');" />
										</div>
									</div>
								</div>

           						<div id='tab-content-data-evidence' class="tabcontentinner"></div>
           					</div>

           					<div id='tab-content-data-resource-div' class="tabcontentuser resourcebackpale" style="display:none">
								<div id="tab-content-resource-title" class="resourceback" style="height:2px;clear:both;float:left;width:100%;margin:0px;"></div>
								<div id='tab-content-resource-search' class="tabcontentsearchuser">
									<?php if(isset($USER->userid) && $USER->userid == $user->userid){ ?>
									<span class="toolbar" style="margin-top:0px;">
										<a style="font-size: 12pt" href="javascript:loadDialog('createresource','<?php echo $CFG->homeAddress ?>ui/popups/resourceadd.php', 750,600);" title='<?php echo $LNG->TAB_ADD_RESOURCE_HINT; ?>'><img style="vertical-align:bottom" src="<?php echo $HUB_FLM->getImagePath('add.png'); ?>" border="0" style="margin:0px;margin-left: 5px;padding:0px" /> <?php echo $LNG->TAB_ADD_RESOURCE_LINK; ?></a>
									</span>
									<?php } ?>

									<div id="searchweb" style="float:left;margin-left: 10px;">
										<label for="q" style="float: left; margin-right: 3px; margin-top: 3px;"><?php echo $LNG->TAB_SEARCH_RESOURCE_LABEL; ?></label>

										<?php
											// if search term is present in URL then show in search box
											$q = stripslashes(optional_param("q","",PARAM_TEXT));
											$scope = optional_param("scope","all",PARAM_TEXT);
											$tagsonly = optional_param("tagsonly","false",PARAM_TEXT);
										?>

										<div style="float: left;">
											<input type="text" style=" margin-right:3px; width:250px" onkeyup="if (checkKeyPressed(event)) { $('web-go-button').onclick();}" id="qweb" name="q" value="<?php print( htmlspecialchars($q) ); ?>"/>
											<div style="clear: both;"></div>
											<div id="q_choices" class="autocomplete" style="border-color: white;"></div>
										</div>
										<div style="float:left;">
											<img id="web-go-button" src="<?php echo $HUB_FLM->getImagePath('search.png'); ?>" class="active" width="20" height="20" onclick="javascript: filterSearchResources();" title="<?php echo $LNG->TAB_SEARCH_GO_BUTTON; ?>" alt="<?php echo $LNG->TAB_SEARCH_GO_BUTTON; ?>" />
										</div>
										<div style="float:left;margin-left: 10px;">
											<img src="<?php echo $HUB_FLM->getImagePath('search-clear.png'); ?>" class="active" width="20" height="20" onclick="javascript: RESOURCE_ARGS['q'] = ''; RESOURCE_ARGS['searchid'] = ''; RESOURCE_ARGS['scope'] = 'all'; $('qweb').value=''; refreshResources();" title="<?php echo $LNG->TAB_SEARCH_CLEAR_SEARCH_BUTTON; ?>" alt="<?php echo $LNG->TAB_SEARCH_CLEAR_SEARCH_BUTTON; ?>" />
										</div>
										<div style="float:left;margin-left: 10px;" id="webbuttons">
											<img src="<?php echo $HUB_FLM->getImagePath('feed-icon-20x20.png'); ?>" alt="<?php echo $LNG->TAB_RSS_ALT; ?>" title="<?php echo $LNG->TAB_RSS_RESOURCE_HINT; ?>" class="active" style="padding-top:0px;padding-left:10px;" border="0" onclick="javascript: getNodesFeed(RESOURCE_ARGS);" />
											<img src="<?php echo $HUB_FLM->getImagePath('printer.png'); ?>" alt="<?php echo $LNG->TAB_PRINT_ALT; ?>" title="<?php echo $LNG->TAB_PRINT_HINT_RESOURCE; ?>" class="active" style="padding-top:0px;padding-left:10px;" border="0" onclick="javascript: printNodes(RESOURCE_ARGS, '<?php echo $LNG->TAB_PRINT_TITLE_RESOURCE; ?>');" />
										</div>
									</div>
								</div>
           						<div id='tab-content-data-resource' class="tabcontentinner"></div>
           					</div>

           					<div id='tab-content-data-org-div' class="tabcontentuser orgbackpale" style="display:none">
								<div id="tab-content-org-title" class="orgback" style="height:2px;clear:both;float:left;width:100%;margin:0px;"></div>
								<div id='tab-content-org-search' class="tabcontentsearchuser">
									<?php if(isset($USER->userid) && $USER->userid == $user->userid){ ?>
									<span class="toolbar" style="margin-top:0px;">
										<a style="font-size: 12pt" href="javascript:loadDialog('createorg','<?php echo $CFG->homeAddress; ?>ui/popups/organizationadd.php?type=Organization', 750,600);" title='<?php echo $LNG->TAB_ADD_ORG_HINT; ?>'><img style="vertical-align:bottom" src="<?php echo $HUB_FLM->getImagePath('add.png'); ?>" border="0" style="margin:0px;margin-left: 5px;padding:0px" /> <?php echo $LNG->TAB_ADD_ORG_LINK; ?></a>
									</span>
									<?php } ?>

									<div id="searchorg" style="float:left;margin-left: 10px;">
										<label for="q" style="float: left; margin-right: 3px; margin-top: 3px;"><?php echo $LNG->TAB_SEARCH_ORG_LABEL; ?></label>
										<?php
											// if search term is present in URL then show in search box
											$q = stripslashes(optional_param("q","",PARAM_TEXT));
											$scope = optional_param("scope","all",PARAM_TEXT);
											$tagsonly = optional_param("tagsonly","false",PARAM_TEXT);
										?>
										<div style="float: left;">
											<input type="text" style="margin-right:3px; width:250px" onkeyup="if (checkKeyPressed(event)) { $('org-go-button').onclick();}" id="qorg" name="q" value="<?php print( htmlspecialchars($q) ); ?>"/>
											<div style="clear: both;"></div>
											<div id="q_choices" class="autocomplete" style="border-color: white;"></div>
										</div>
										<div style="float:left;">
											<img id="org-go-button" src="<?php echo $HUB_FLM->getImagePath('search.png'); ?>" class="active" width="20" height="20" onclick="javascript: filterSearchOrgs();" title="<?php echo $LNG->TAB_SEARCH_GO_BUTTON; ?>" alt="<?php echo $LNG->TAB_SEARCH_GO_BUTTON; ?>" />
										</div>
										<div style="float:left;margin-left: 10px;">
											<img src="<?php echo $HUB_FLM->getImagePath('search-clear.png'); ?>" class="active" width="20" height="20" onclick="javascript: ORG_ARGS['q'] = ''; ORG_ARGS['scope'] = 'all'; $('qorg').value='';if ($('scopeorgall'))  $('scopeorgall').checked=true; refreshOrganizations();" title="<?php echo $LNG->TAB_SEARCH_CLEAR_SEARCH_BUTTON; ?>" alt="<?php echo $LNG->TAB_SEARCH_CLEAR_SEARCH_BUTTON; ?>" />
										</div>
										<div style="float:left;margin-left: 10px;" id="orgbuttons">
											<img src="<?php echo $HUB_FLM->getImagePath('feed-icon-20x20.png'); ?>" alt="<?php echo $LNG->TAB_RSS_ALT; ?>" title="<?php echo $LNG->TAB_RSS_ORG_HINT; ?>" class="active" style="padding-top:0px;padding-left:10px;" border="0" onclick="javascript: getNodesFeed(ORG_ARGS);" />
											<img src="<?php echo $HUB_FLM->getImagePath('printer.png'); ?>" alt="<?php echo $LNG->TAB_PRINT_ALT; ?>" title="<?php echo $LNG->TAB_PRINT_HINT_ORG; ?>" class="active" style="padding-top:0px;padding-left:10px;" border="0" onclick="javascript: printNodes(ORG_ARGS, '<?php echo $LNG->TAB_PRINT_TITLE_ORG; ?>');" />
										</div>
									</div>
								</div>

           						<div id='tab-content-data-org' class="tabcontentinner"></div>
           					</div>

           					<div id='tab-content-data-project-div' class="tabcontentuser projectbackpale" style="display:none">
								<div id="tab-content-project-title" class="projectback" style="height:2px;clear:both;float:left;width:100%;margin:0px;"></div>
								<div id='tab-content-project-search' class="tabcontentsearchuser">
									<?php if(isset($USER->userid) && $USER->userid == $user->userid){ ?>
									<span class="toolbar" style="margin-top:0px;">
										<a style="font-size: 12pt" href="javascript:loadDialog('createproject','<?php echo $CFG->homeAddress; ?>ui/popups/organizationadd.php?type=Project', 750,600);" title='<?php echo $LNG->TAB_ADD_PROJECT_HINT; ?>'><img style="vertical-align:bottom" src="<?php echo $HUB_FLM->getImagePath('add.png'); ?>" border="0" style="margin:0px;margin-left: 5px;padding:0px" /> <?php echo $LNG->TAB_ADD_PROJECT_LINK; ?></a>
									</span>
									<?php } ?>

									<div id="searchproject" style="float:left;margin-left: 10px;">
										<label for="q" style="float: left; margin-right: 3px; margin-top: 3px;"><?php echo $LNG->TAB_SEARCH_ORG_LABEL; ?></label>
										<?php
											// if search term is present in URL then show in search box
											$q = stripslashes(optional_param("q","",PARAM_TEXT));
											$scope = optional_param("scope","all",PARAM_TEXT);
											$tagsonly = optional_param("tagsonly","false",PARAM_TEXT);
										?>
										<div style="float: left;">
											<input type="text" style="margin-right:3px; width:250px" onkeyup="if (checkKeyPressed(event)) { $('project-go-button').onclick();}" id="qproject" name="q" value="<?php print( htmlspecialchars($q) ); ?>"/>
											<div style="clear: both;"></div>
											<div id="q_choices" class="autocomplete" style="border-color: white;"></div>
										</div>
										<div style="float:left;">
											<img id="project-go-button" src="<?php echo $HUB_FLM->getImagePath('search.png'); ?>" class="active" width="20" height="20" onclick="javascript: filterSearchProjects();" title="<?php echo $LNG->TAB_SEARCH_GO_BUTTON; ?>" alt="<?php echo $LNG->TAB_SEARCH_GO_BUTTON; ?>" />
										</div>
										<div style="float:left;margin-left: 10px;">
											<img src="<?php echo $HUB_FLM->getImagePath('search-clear.png'); ?>" class="active" width="20" height="20" onclick="javascript: PROJECT_ARGS['q'] = ''; PROJECT_ARGS['scope'] = 'all'; $('qproject').value='';if ($('scopeprojectall'))  $('scopeprojectall').checked=true; refreshProjects();" title="<?php echo $LNG->TAB_SEARCH_CLEAR_SEARCH_BUTTON; ?>" alt="<?php echo $LNG->TAB_SEARCH_CLEAR_SEARCH_BUTTON; ?>" />
										</div>
										<div style="float:left;margin-left: 10px;" id="projectbuttons">
											<img src="<?php echo $HUB_FLM->getImagePath('feed-icon-20x20.png'); ?>" alt="<?php echo $LNG->TAB_RSS_ALT; ?>" title="<?php echo $LNG->TAB_RSS_PROJECT_HINT; ?>" class="active" style="padding-top:0px;padding-left:10px;" border="0" onclick="javascript: getNodesFeed(PROJECT_ARGS);" />
											<img src="<?php echo $HUB_FLM->getImagePath('printer.png'); ?>" alt="<?php echo $LNG->TAB_PRINT_ALT; ?>" title="<?php echo $LNG->TAB_PRINT_HINT_PROJECT; ?>" class="active" style="padding-top:0px;padding-left:10px;" border="0" onclick="javascript: printNodes(PROJECT_ARGS, '<?php echo $LNG->TAB_PRINT_TITLE_PROJECT; ?>');" />
										</div>
									</div>
								</div>

           						<div id='tab-content-data-project' class="tabcontentinner"></div>
           					</div>


							<?php if ($CFG->HAS_OPEN_COMMENTS) { ?>
           					<div id='tab-content-data-comment-div' class="tabcontentuser peoplebackpale" style="display:none">
								<div id="tab-content-comment-title" class="peopleback" style="height:2px;clear:both;float:left;width:100%;margin:0px;"></div>
								<div id='tab-content-search-comment' class="tabcontentsearchuser">
									<div id="searchcomment" style="float:left;margin-left:10px;">
										<label for="q" style="float: left; margin-right: 3px; margin-top: 3px;"><?php echo $LNG->TAB_SEARCH_COMMENT_LABEL; ?></label>

										<?php
											// if search term is present in URL then show in search box
											$q = stripslashes(optional_param("q","",PARAM_TEXT));
											$scope = optional_param("scope","all",PARAM_TEXT);
											$tagsonly = optional_param("tagsonly","false",PARAM_TEXT);
										?>

										<div style="float: left;">
											<input type="text" style="margin-right:3px; width:250px" onkeyup="if (checkKeyPressed(event)) { $('comment-go-button').onclick();}" id="qcomment" name="q" value="<?php print( htmlspecialchars($q) ); ?>"/>
											<div style="clear: both;">
											</div>
											<div id="q_choices" class="autocomplete" style="border-color: white;"></div>
										 </div>
										<div style="float:left;">
											<img id="comment-go-button" src="<?php echo $HUB_FLM->getImagePath('search.png'); ?>" class="active" width="20" height="20" onclick="javascript: filterSearchComments();" title="<?php echo $LNG->TAB_SEARCH_GO_BUTTON; ?>" alt="<?php echo $LNG->TAB_SEARCH_GO_BUTTON; ?>" />
										</div>
										<div style="float:left;margin-left: 10px;">
											<img src="<?php echo $HUB_FLM->getImagePath('search-clear.png'); ?>" class="active" width="20" height="20" onclick="javascript: COMMENT_ARGS['q'] = ''; COMMENT_ARGS['searchid'] = ''; COMMENT_ARGS['scope'] = 'all';$('qcomment').value=''; refreshComments();" title="<?php echo $LNG->TAB_SEARCH_CLEAR_SEARCH_BUTTON; ?>" alt="<?php echo $LNG->TAB_SEARCH_CLEAR_SEARCH_BUTTON; ?>" />
										</div>
									 </div>
									<div style="float:left;margin-left: 10px;" id="orgbuttons">
										<img src="<?php echo $HUB_FLM->getImagePath('feed-icon-20x20.png'); ?>" alt="<?php echo $LNG->TAB_RSS_ALT; ?>" title="<?php echo $LNG->TAB_RSS_COMMENT_HINT; ?>" class="active" style="padding-top:0px;padding-left:10px;" border="0" onclick="javascript: getCommentNodesFeed(COMMENT_ARGS);" />
										<img src="<?php echo $HUB_FLM->getImagePath('printer.png'); ?>" alt="<?php echo $LNG->TAB_PRINT_ALT; ?>" title="<?php echo $LNG->TAB_PRINT_HINT_COMMENT; ?>" class="active" style="padding-top:0px;padding-left:10px;" border="0" onclick="javascript: printCommentNodes(COMMENT_ARGS, '<?php echo $LNG->TAB_PRINT_TITLE_COMMENT; ?>');" />
									</div>
								</div>

           						<div id='tab-content-data-comment' class="tabcontentinner"></div>
           					</div>
           					<?php } ?>

           					<div id='tab-content-data-chat-div' class="tabcontentuser peoplebackpale" style="display:none">
								<div id="tab-content-challenge-title" class="peopleback" style="height:2px;clear:both;float:left;width:100%;margin:0px;"></div>
								<div id='tab-content-search-chat' class="tabcontentsearchuser">
									<div id="searchchat" style="float:left;margin-left:10px;">
										<label for="q" style="float: left; margin-right: 3px; margin-top: 3px;"><?php echo $LNG->TAB_SEARCH_CHAT_LABEL; ?></label>

										<?php
											// if search term is present in URL then show in search box
											$q = stripslashes(optional_param("q","",PARAM_TEXT));
											$scope = optional_param("scope","all",PARAM_TEXT);
											$tagsonly = optional_param("tagsonly","false",PARAM_TEXT);
										?>

										<div style="float: left;">
											<input type="text" style="margin-right:3px; width:250px" onkeyup="if (checkKeyPressed(event)) { $('chat-go-button').onclick();}" id="qchat" name="q" value="<?php print( htmlspecialchars($q) ); ?>"/>
											<div style="clear: both;">
											</div>
											<div id="q_choices" class="autocomplete" style="border-color: white;"></div>
										 </div>
										<div style="float:left;">
											<img id="chat-go-button" src="<?php echo $HUB_FLM->getImagePath('search.png'); ?>" class="active" width="20" height="20" onclick="javascript: filterSearchChats();" title="<?php echo $LNG->TAB_SEARCH_GO_BUTTON; ?>" alt="<?php echo $LNG->TAB_SEARCH_GO_BUTTON; ?>" />
										</div>
										<div style="float:left;margin-left: 10px;">
											<img src="<?php echo $HUB_FLM->getImagePath('search-clear.png'); ?>" class="active" width="20" height="20" onclick="javascript: CHAT_ARGS['q'] = ''; CHAT_ARGS['searchid'] = ''; CHAT_ARGS['scope'] = 'all';$('qchat').value=''; refreshChats();" title="<?php echo $LNG->TAB_SEARCH_CLEAR_SEARCH_BUTTON; ?>" alt="<?php echo $LNG->TAB_SEARCH_CLEAR_SEARCH_BUTTON; ?>" />
										</div>
									 </div>
								</div>

           						<div id='tab-content-data-chat' class="tabcontentinner"></div>
           					</div>

						</div>
					</div>
            	</div>
			</div>

            <div id='tab-content-social-div' class='tabcontent' style='width: 100%;background: white;padding:0px;'>
	  			<div id="tab-content-user-bar" class="peopleback plainborder-bottom" style="clear:both;float:left;width:100%;margin:0px;">
	  				<div class="peopleback tabtitlebar" style="padding:4px;margin:0px;font-size:9pt"></div>
	  			</div>
	            <div id="tab-content-social" style="clear:both;float:left;width:100%;padding:5px;"></div>
			</div>
		</div>
	</div>
<?php } ?>

<script type='text/javascript'>
	function updateUserFollow() {
		$('followupdate').submit()
	}
</script>
