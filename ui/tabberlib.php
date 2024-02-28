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

	$ns = getNodesByGlobal(0,1,'date','DESC', 'News', '', 'short');
	$news = $ns->nodes;
	$CFG->HAS_NEWS = false;
	if (count($news) > 0) {
		$CFG->HAS_NEWS = true;
	}

	echo "<script type='text/javascript'>";

	$cs = getCountryList();
	$countryarrayorg = getCountriesForCloudByType('Organization', -1);
	$countryarrayproject = getCountriesForCloudByType('Project', -1);
	$countryarrayusers = getCountriesForCloudByUsers(-1);

	$orgcountrieslist = "[";
	$count = 0;
	if (is_countable($countryarrayorg)) {
		$count = count($countryarrayorg);
	}
	for($j=0;$j< $count; $j++) {
		$country = $countryarrayorg[$j];
		$orgcountrieslist .= "{";
		$keys = array_keys($country);
		for($i=0;$i< count($keys); $i++){
			if ($keys[$i] == "Country") {
				$orgcountrieslist .= '"'.$keys[$i].'":"'.addslashes($cs[$country[$keys[$i]]]).'"';
			} else {
				$orgcountrieslist .= '"'.$keys[$i].'":"'.addslashes($country[$keys[$i]]).'"';
			}

			if ($i != (count($keys)-1)){
				$orgcountrieslist .= ',';
			}
		}
		$orgcountrieslist .= "}";
		if ($j != ($count-1)){
			$orgcountrieslist .= ',';
		}
	}
	$orgcountrieslist .= "]";
	echo 'var orgcountrycloud = '.$orgcountrieslist.';';

	$projectcountrieslist = "[";
	$count2 = 0;
	if (is_countable($countryarrayproject)) {
		$count2 = count($countryarrayproject);
	}
	for($j=0;$j< $count2; $j++) {
		$country = $countryarrayproject[$j];
		$projectcountrieslist .= "{";
		$keys = array_keys($country);
		for($i=0;$i< count($keys); $i++){
			if ($keys[$i] == "Country") {
				$projectcountrieslist .= '"'.$keys[$i].'":"'.addslashes($cs[$country[$keys[$i]]]).'"';
			} else {
				$projectcountrieslist .= '"'.$keys[$i].'":"'.addslashes($country[$keys[$i]]).'"';
			}

			if ($i != (count($keys)-1)){
				$projectcountrieslist .= ',';
			}
		}
		$projectcountrieslist .= "}";
		if ($j != ($count2-1)){
			$projectcountrieslist .= ',';
		}
	}
	$projectcountrieslist .= "]";
	echo 'var projectcountrycloud = '.$projectcountrieslist.';';

	$userscountrieslist = "[";
	$count3 = 0;
	if (is_countable($countryarrayusers)) {
		$count3 = count($countryarrayusers);
	}
	for($j=0;$j< $count3; $j++) {
		$country = $countryarrayusers[$j];
		$userscountrieslist .= "{";
		$keys = array_keys($country);
		for($i=0;$i< count($keys); $i++){
			if ($keys[$i] == "Country") {
				$userscountrieslist .= '"'.$keys[$i].'":"'.addslashes($cs[$country[$keys[$i]]]).'"';
			} else {
				$userscountrieslist .= '"'.$keys[$i].'":"'.addslashes($country[$keys[$i]]).'"';
			}

			if ($i != (count($keys)-1)){
				$userscountrieslist .= ',';
			}
		}
		$userscountrieslist .= "}";
		if ($j != ($count3-1)){
			$userscountrieslist .= ',';
		}
	}
	$userscountrieslist .= "]";
	echo 'var userscountrycloud = '.$userscountrieslist.';';

	echo "\n</script>";

	include_once($HUB_FLM->getCodeDirPath("ui/networknavigationlib.php"));

	/**
	 * Tabber library
	 * Formats the output tab view in the main section of the site
	 */

	/**
	 * Displays the tabber
	 *
	 * @param string $context the context to display
	 * @param string $args the url arguments
	 */
	function display_tabber($context,$args, $wasEmpty){
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
		
		if (!isset($q)) {
			$q = "";
		}

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
		echo "var URL_ARGS = ".$argsStr2.";";
		echo "var COMMENT_ARGS = ".$argsStr2.";";
		echo "var NEWS_ARGS = ".$argsStr2.";";

		echo "COMMENT_ARGS['filterlist'] = '".$CFG->LINK_COMMENT_BUILT_FROM."';";
		echo "COMMENT_ARGS['includeunconnected'] = 'true';";

		echo "</script>";
    ?>

    <div id="tabber">
		<ul class="nav nav-tabs p-2 main-nav" id="tabs" role="tablist">
			<li class="nav-item" role="presentation"><a class="tab" id="tab-home" href="<?php echo $CFG->homeAddress; ?>#home-list"><span class="tab tabhome"><?php echo $LNG->TAB_HOME; ?></span></a></li>
			<?php if ($CFG->HAS_CHALLENGE) { ?>
				<li class="nav-item" role="presentation"><a class="tab" id="tab-challenge" href="<?php echo $CFG->homeAddress; ?>#challenge-list"><span class="tab tabchallenge"><?php echo $LNG->TAB_CHALLENGE; ?></span></a></li>
			<?php }
			if ( $CFG->issuesManaged == false ) { ?>
				<li class="nav-item" role="presentation"><a class="tab" id="tab-issue" href="<?php echo $CFG->homeAddress; ?>#issue-list"><span class="tab tabissue"><?php echo $LNG->TAB_ISSUE; ?></span></a></li>
			<?php } 
			if ($CFG->HAS_SOLUTION) { ?>
				<li class="nav-item" role="presentation"><a class="tab" id="tab-solution" href="<?php echo $CFG->homeAddress; ?>#solution-list"><span class="tab tabsolution"><?php echo $LNG->TAB_SOLUTION; ?></span></a></li>
			<?php } 
			if ($CFG->HAS_CLAIM) { ?>
				<li class="nav-item" role="presentation"><a class="tab" id="tab-claim" href="<?php echo $CFG->homeAddress; ?>#claim-list"><span class="tab tabclaim"><?php echo $LNG->TAB_CLAIM; ?></span></a></li>
			<?php } ?>

			<li class="nav-item" role="presentation"><a class="tab" id="tab-evidence" href="<?php echo $CFG->homeAddress; ?>#evidence-list"><span class="tab tabevidence"><?php echo $LNG->TAB_EVIDENCE; ?></span></a></li>
			<li class="nav-item" role="presentation"><a class="tab" id="tab-web" href="<?php echo $CFG->homeAddress; ?>#web-list"><span class="tab tabresource"><?php echo $LNG->TAB_RESOURCE; ?></span></a></li>

			<?php if ($CFG->hasSocialTab) { ?>
				<li class="nav-item" role="presentation" id="tab-social-li"><a class="tab" id="tab-social" href="#social-list"><span class="tab taborg"><span id="tab-social-text"><?php echo $LNG->TAB_SOCIAL; ?></span><img style="padding:0px; margin:0px;margin-left:5px;vertical-align:middle" id="socialmenuarrow" src="<?php echo $HUB_FLM->getImagePath('arrow-down3.png'); ?>" /></span></a></li>
			<?php } else { ?>
				<li class="nav-item" role="presentation"><a class="tab" id="tab-org" href="<?php echo $CFG->homeAddress; ?>#org-list"><span class="tab taborg"><?php echo $LNG->TAB_ORG; ?></span></a></li>
				<li class="nav-item" role="presentation"><a class="tab" id="tab-project" href="<?php echo $CFG->homeAddress; ?>#project-list"><span class="tab tabproject"><?php echo $LNG->TAB_PROJECT; ?></span></a></li>
				<li class="nav-item" role="presentation"><a class="tab" id="tab-user" href="<?php echo $CFG->homeAddress; ?>#user-list"><span class="tab tabuser"><?php echo $LNG->TAB_USER; ?></span></a></li>
			<?php }
			if ($CFG->HAS_OPEN_COMMENTS) { ?>
				<li class="nav-item" role="presentation"><a class="tab" id="tab-comment" href="<?php echo $CFG->homeAddress; ?>#comment-list"><span class="tab taborg"><?php echo $LNG->TAB_COMMENT; ?></span></a></li>
			<?php } 
			if ($CFG->HAS_NEWS) { ?>
				<li class="nav-item" role="presentation"><a class="tab" id="tab-news" href="<?php echo $CFG->homeAddress; ?>#news-list"><span class="tab taborg"><?php echo $LNG->TAB_NEWS; ?></span></a></li>
			<?php } ?>
		</ul>

        <div id="tabs-content">

			<!-- HOME TAB PAGES -->
	        <?php if ($context == $CFG->USER_CONTEXT) { ?>
            <div id="tab-content-home-div" class="tabcontentouter">
	            <div id="tab-content-home">
					<?php include($HUB_FLM->getCodeDirPath("ui/homepageuser.php")); ?>
	            </div>
			</div>
	        <?php } else { ?>
            <div id="tab-content-home-div" class="tabcontenthome">
	            <div id="tab-content-home">
					<?php include($HUB_FLM->getCodeDirPath("ui/homepage.php")); ?>
	            </div>
			</div>
			<?php } ?>

            <div id="tab-content-social-div" class="tabcontentouter">
			</div>

			<!-- CHALLENGE TAB PAGE -->
			<?php if ($CFG->HAS_CHALLENGE) { ?>

				<div class="container-fluid">
					<div class="row">

						<div id="tab-content-challenge-div" class="tabcontent" style="display:none;padding:0px;">

							<div id="tab-content-challenge-title" class="challengeback tab-content-title" ></div>

							<div id="tab-content-challenge-search" class="issuebackpale">
								<div class="col-12">
									<div class="strapline">
										<a href="javascript:void(0)" onMouseOver="showGlobalHint('ChallengesTab', event, 'hgrhint'); return false;" onMouseOut="hideHints(); return false;" onClick="hideHints(); return false;" onkeypress="enterKeyPressed(event)">
											<i class="far fa-question-circle fa-lg me-2" aria-hidden="true" ></i> 
											<span class="sr-only">More info</span>
										</a>
										<?php echo $LNG->TAB_CHALLENGE_MESSAGE; ?>
									</div>
								</div>

								<?php if(isset($USER->userid) && $USER->getIsAdmin() == "Y"){ ?>
									<div class="toolbar col-12 addChallenge">
										<a href="javascript:loadDialog('createchallenge','<?php echo $CFG->homeAddress; ?>ui/popups/challengeadd.php', 790,600);" title='<?php echo $LNG->TAB_ADD_CHALLENGE_HINT; ?>'><img src="<?php echo $HUB_FLM->getImagePath('add.png'); ?>" alt="" /> <?php echo $LNG->TAB_ADD_CHALLENGE_LINK; ?></a>
									</div>
								<?php } ?>

								<div id="searchchallenge" class="col-12 toolbarIcons">
									<div id="challengebuttons">
										<?php if ($CFG->hasRss) { ?>
											<a class="active me-3" title="<?php echo $LNG->TAB_RSS_CHALLENGE_HINT; ?>" onclick="getNodesFeed(CHALLENGE_ARGS);">
												<i class="fas fa-rss-square fa-lg" aria-hidden="true" ></i> 
												<span class="sr-only"><?php echo $LNG->TAB_RSS_ALT; ?></span>
											</a>
										<?php } ?>
										<a class="active" title="<?php echo $LNG->TAB_PRINT_HINT_CHALLENGE; ?>" onclick="printNodes(CHALLENGE_ARGS, '<?php echo $LNG->TAB_PRINT_TITLE_CHALLENGE; ?>');">
											<i class="fas fa-print fa-lg" aria-hidden="true" ></i> 
											<span class="sr-only"><?php echo $LNG->TAB_PRINT_ALT; ?></span>
										</a>
									</div>
								</div>
							</div>

							<div id="tab-content-toolbar-challenge" class="col-12">
								<div id="tabber">
									<div id="challengetabs">
										<ul id="tabs" class="tab2">
											<li class="tab">
												<a class="tab unselected" id="tab-challenge-list" href="#challenge-list">
													<?php echo $LNG->TAB_VIEW_LIST; ?> <span id="challenge-list-count"></span>
												</a>
											</li>
											<li class="tab">
												<a class="tab unselected" id="tab-challenge-overview" href="#challenge-overview">
													<?php echo $LNG->TAB_VIEW_OVERVIEW; ?>
												</a>
											</li>
										</ul>
									</div>
									<div id="tab-content-challenge" class="tabcontentouter p-4">
										<div id="tab-content-challenge-list" class="tabcontentinner"></div>
										<div id="tab-content-challenge-overview" class="tabcontentinner"></div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			<?php } ?>

			<!-- ISSUE TAB PAGE -->
			<?php if ( $CFG->issuesManaged == false ) { ?>
				<div class="container-fluid">
					<div class="row">
						<div id='tab-content-issue-div' class='tabcontent issuebackpale' style="display:none;padding:0px;">

							<div id="tab-content-issue-title" class="issueback tab-content-title"></div>

							<div id='tab-content-issue-search'>
								<div class="col-12">
									<div class="strapline">
										<a href="javascript:void(0)" onMouseOver="showGlobalHint('IssuesTab', event, 'hgrhint'); return false;" onMouseOut="hideHints(); return false;" onClick="hideHints(); return false;" onkeypress="enterKeyPressed(event)">
											<i class="far fa-question-circle fa-lg me-2" aria-hidden="true" ></i> 
											<span class="sr-only">More info</span>
										</a>
										<?php 
											if(isset($USER->userid)){
												echo $LNG->TAB_ISSUE_MESSAGE_LOGGEDIN; 
											} else {
												if ($CFG->signupstatus == $CFG->SIGNUP_OPEN) { 
													echo $LNG->TAB_ISSUE_MESSAGE_LOGGEDOUT_OPEN; 
												} else if ($CFG->signupstatus == $CFG->SIGNUP_REQUEST) { 
													echo $LNG->TAB_ISSUE_MESSAGE_LOGGEDOUT_REQUEST; 
												} else { 
													echo $LNG->TAB_ISSUE_MESSAGE_LOGGEDOUT_CLOSED; 
												} 
											} 
										?>
									</div>
								</div>

								<?php if ( isset($USER->userid) && ( $CFG->issuesManaged == false || ($CFG->issuesManaged == true && $USER->getIsAdmin() == "Y") ) ){ ?>
									<div class="toolbar col-12 addChallenge">
										<a href="javascript:loadDialog('createissue','<?php echo $CFG->homeAddress; ?>ui/popups/issueadd.php', 790,600);" title='<?php echo $LNG->TAB_ADD_ISSUE_HINT; ?>'><img src="<?php echo $HUB_FLM->getImagePath('add.png'); ?>" alt="" /> <?php echo $LNG->TAB_ADD_ISSUE_LINK; ?></a>
									</div>
								<?php } ?>

								<div id="searchissue" class="col-12 toolbarIcons">
									<div class="row">
										<div class="col-lg-4 col-md-12">
											<div class="input-group">
												<input type="text" class="form-control" placeholder="<?php echo $LNG->TAB_SEARCH_ISSUE_LABEL; ?>" aria-label="<?php echo $LNG->TAB_SEARCH_ISSUE_LABEL; ?>" onkeyup="if (checkKeyPressed(event)) { $('issue-go-button').onclick();}" id="qissue" name="q" value="<?php print( htmlspecialchars($q) ); ?>" />
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

							<div id="tab-content-toolbar-issue" class="col-12">
								<div id="tabber">
									<div id="issuetabs">
										<ul id="tabs" class="tab2">
											<li class="tab">
												<a class="tab unselected" id="tab-issue-list" href="#issue-list">
													<?php echo $LNG->TAB_VIEW_LIST; ?> <span id="issue-list-count"></span>
												</a>
											</li>
											<li class="tab">
												<a class="tab unselected" id="tab-issue-overview" href="#issue-overview">
													<?php echo $LNG->TAB_VIEW_OVERVIEW; ?>
												</a>
											</li>
										</ul>
									</div>
									<div id="tab-content-issue" class="tabcontentouter p-4">
										<div id='tab-content-issue-list' class='tabcontentinner'></div>
										<div id='tab-content-issue-overview' class='tabcontentinner'></div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			<?php } ?>

			<!-- SOLUTION TAB PAGE -->
			<?php if ($CFG->HAS_SOLUTION) { ?>
				<div class="container-fluid">
					<div class="row">
						<div id='tab-content-solution-div' class='tabcontent solutionbackpale' style="display:none;padding:0px;">

							<div id="tab-content-solution-title" class="solutionback tab-content-title"></div>

							<div id='tab-content-solution-search'>								
								<div class="col-12">
									<div class="strapline">
										<a href="javascript:void(0)" onMouseOver="showGlobalHint('SolutionsTab', event, 'hgrhint'); return false;" onMouseOut="hideHints(); return false;" onClick="hideHints(); return false;" onkeypress="enterKeyPressed(event)">
											<i class="far fa-question-circle fa-lg me-2" aria-hidden="true" ></i> 
											<span class="sr-only">More info</span>
										</a>
										<?php 
											if(isset($USER->userid)){
												echo $LNG->TAB_SOLUTION_MESSAGE_LOGGEDIN; 
											} else {
												if ($CFG->signupstatus == $CFG->SIGNUP_OPEN) { 
													echo $LNG->TAB_SOLUTION_MESSAGE_LOGGEDOUT_OPEN; 
												} else if ($CFG->signupstatus == $CFG->SIGNUP_REQUEST) { 
													echo $LNG->TAB_SOLUTION_MESSAGE_LOGGEDOUT_REQUEST; 
												} else { 
													echo $LNG->TAB_SOLUTION_MESSAGE_LOGGEDOUT_CLOSED; 
												} 
											} 
										?>
									</div>
								</div>

								<?php if(isset($USER->userid)){ ?>
									<div class="toolbar col-12 addChallenge">
										<a href="javascript:loadDialog('createsolution','<?php echo $CFG->homeAddress ?>ui/popups/solutionadd.php', 790,600);" title='<?php echo $LNG->TAB_ADD_SOLUTION_HINT; ?>'><img src="<?php echo $HUB_FLM->getImagePath('add.png'); ?>" alt="" /> <?php echo $LNG->TAB_ADD_SOLUTION_LINK; ?></a>
									</div>
								<?php } ?>

								<div id="searchsolution" class="col-12 toolbarIcons">
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
												<a class="active" title="<?php echo $LNG->TAB_PRINT_HINT_SOLUTION; ?>" onclick="printNodes(SOLUTION_ARGS, '<?php echo $LNG->TAB_PRINT_TITLE_SOLUTION; ?>');">
													<i class="fas fa-print fa-lg" aria-hidden="true" ></i> 
													<span class="sr-only"><?php echo $LNG->TAB_PRINT_ALT; ?></span>
												</a>
											</div>
										</div>
									</div>
								</div>
							</div>

							<div id='tab-content-toolbar-solution' class="col-12">
								<div id="tabber">
									<div id="solutiontabs">
										<ul id="tabs" class="tab2">
											<li class="tab">
												<a class="tab unselected" id="tab-solution-list" href="#solution-list">
													<?php echo $LNG->TAB_VIEW_LIST; ?> <span id="solution-list-count"></span>
												</a>
											</li>
											<li class="tab">
												<a class="tab unselected" id="tab-solution-overview" href="#solution-overview">
													<?php echo $LNG->TAB_VIEW_OVERVIEW; ?>
												</a>
											</li>
										</ul>
									</div>
									<div id="tab-content-solution" class="tabcontentouter p-4">
										<div id='tab-content-solution-list' class='tabcontentinner'></div>
										<div id='tab-content-solution-overview' class='tabcontentinner'></div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			<?php } ?>

			<!-- CLAIM TAB PAGE -->
			<?php if ($CFG->HAS_CLAIM) { ?>
				<div class="container-fluid">
					<div class="row">
						<div id='tab-content-claim-div' class='tabcontent claimbackpale' style="display:none;padding:0px;">

							<div id="tab-content-claim-title" class="claimback tab-content-title" ></div>

							<div id='tab-content-claim-search'>
								<div class="col-12">
									<div class="strapline">
										<a href="javascript:void(0)" onMouseOver="showGlobalHint('ClaimsTab', event, 'hgrhint'); return false;" onMouseOut="hideHints(); return false;" onClick="hideHints(); return false;" onkeypress="enterKeyPressed(event)">
											<i class="far fa-question-circle fa-lg me-2" aria-hidden="true" ></i> 
											<span class="sr-only">More info</span>
										</a>
										<?php 
											if(isset($USER->userid)){
												echo $LNG->TAB_CLAIM_MESSAGE_LOGGEDIN; 
											} else {
												if ($CFG->signupstatus == $CFG->SIGNUP_OPEN) { 
													echo $LNG->TAB_CLAIM_MESSAGE_LOGGEDOUT_OPEN; 
												} else if ($CFG->signupstatus == $CFG->SIGNUP_REQUEST) { 
													echo $LNG->TAB_CLAIM_MESSAGE_LOGGEDOUT_REQUEST; 
												} else { 
													echo $LNG->TAB_CLAIM_MESSAGE_LOGGEDOUT_CLOSED; 
												} 
											} 
										?>
									</div>
								</div>

								<?php if(isset($USER->userid)){ ?>
									<div class="toolbar col-12 addChallenge">
										<a href="javascript:loadDialog('createclaim','<?php echo $CFG->homeAddress ?>ui/popups/claimadd.php', 790,600);" title='<?php echo $LNG->TAB_ADD_CLAIM_HINT; ?>'><img src="<?php echo $HUB_FLM->getImagePath('add.png'); ?>" alt="" /> <?php echo $LNG->TAB_ADD_CLAIM_LINK; ?></a>
									</div>
								<?php } ?>

								<div id="searchclaim" class="col-12 toolbarIcons">
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

							<div id='tab-content-toolbar-claim' class="col-12">
								<div id="tabber">
									<div id="claimtabs">
										<ul id="tabs" class="tab2">
											<li class="tab">
												<a class="tab unselected" id="tab-claim-list" href="#claim-list">
													<?php echo $LNG->TAB_VIEW_LIST; ?> <span id="claim-list-count"></span>
												</a>
											</li>
											<li class="tab">
												<a class="tab unselected" id="tab-claim-overview" href="#claim-overview">
													<?php echo $LNG->TAB_VIEW_OVERVIEW; ?>
												</a>
											</li>
										</ul>
									</div>
									<div id="tab-content-claim" class="tabcontentouter p-4">
										<div id='tab-content-claim-list' class='tabcontentinner'></div>
										<div id='tab-content-claim-overview' class='tabcontentinner'></div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			<?php } ?>

			<!-- EVIDENCE TAB PAGE -->
				<div class="container-fluid">
					<div class="row">
						<div id='tab-content-evidence-div' class='tabcontent evidencebackpale' style="display:none;padding:0px;">

							<div id="tab-content-evidence-title" class="evidenceback tab-content-title"></div>

							<div id='tab-content-evidence-search'>
								<div class="col-12">
									<div class="strapline">
										<a href="javascript:void(0)" onMouseOver="showGlobalHint('EvidenceTab', event, 'hgrhint'); return false;" onMouseOut="hideHints(); return false;" onClick="hideHints(); return false;" onkeypress="enterKeyPressed(event)">
											<i class="far fa-question-circle fa-lg me-2" aria-hidden="true" ></i> 
											<span class="sr-only">More info</span>
										</a>
										<?php 
											if(isset($USER->userid)){
												echo $LNG->TAB_EVIDENCE_MESSAGE_LOGGEDIN; 
											} else {
												if ($CFG->signupstatus == $CFG->SIGNUP_OPEN) { 
													echo $LNG->TAB_EVIDENCE_MESSAGE_LOGGEDOUT_OPEN; 
												} else if ($CFG->signupstatus == $CFG->SIGNUP_REQUEST) { 
													echo $LNG->TAB_EVIDENCE_MESSAGE_LOGGEDOUT_REQUEST; 
												} else { 
													echo $LNG->TAB_EVIDENCE_MESSAG_LOGGEDOUT_CLOSED; 
												} 
											} 
										?>
									</div>
								</div>

								<?php if(isset($USER->userid)){ ?>
									<div class="toolbar col-12 addChallenge">
										<a href="javascript:loadDialog('createevidence','<?php echo $CFG->homeAddress ?>ui/popups/evidenceadd.php', 790,670);" title='<?php echo $LNG->TAB_ADD_EVIDENCE_HINT; ?>'><img src="<?php echo $HUB_FLM->getImagePath('add.png'); ?>" alt="" /> <?php echo $LNG->TAB_ADD_EVIDENCE_LINK; ?></a>
									</div>
								<?php } ?>

								<div id="searchevidence" class="col-12 toolbarIcons">
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
												<a class="active" title="<?php echo $LNG->TAB_PRINT_HINT_EVIDENCE; ?>" onclick="printNodes(EVIDENCE_ARGS, '<?php echo $LNG->TAB_PRINT_HINT_EVIDENCE; ?>');">
													<i class="fas fa-print fa-lg" aria-hidden="true" ></i> 
													<span class="sr-only"><?php echo $LNG->TAB_PRINT_ALT; ?></span>
												</a>
											</div>
										</div>
									</div>
								</div>
							</div>

							<div id='tab-content-toolbar-evidence' class="col-12">
								<div id="tabber">
									<div id="evidencetabs">
										<ul id="tabs" class="tab2">
											<li class="tab">
												<a class="tab unselected" id="tab-evidence-list" href="#evidence-list">
													<?php echo $LNG->TAB_VIEW_LIST; ?> <span id="evidence-list-count"></span>
												</a>
											</li>
											<li class="tab">
												<a class="tab unselected" id="tab-evidence-overview" href="#evidence-overview">
													<?php echo $LNG->TAB_VIEW_OVERVIEW; ?>
												</a>
											</li>
										</ul>
									</div>
									<div id="tab-content-evidence" class="tabcontentouter p-4">
										<div id='tab-content-evidence-list' class='tabcontentinner'></div>
										<div id='tab-content-evidence-overview' class='tabcontentinner'></div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

			<!-- RESOURCE TAB PAGE -->
				<div class="container-fluid">
					<div class="row">
						<div id='tab-content-web-div' class='tabcontent resourcebackpale' style="display:none;padding:0px;">

							<div id="tab-content-web-title" class="resourceback tab-content-title"></div>

							<div id='tab-content-web-search'>
								<div class="col-12">
									<div class="strapline">
										<a href="javascript:void(0)" onMouseOver="showGlobalHint('ResourcesTab', event, 'hgrhint'); return false;" onMouseOut="hideHints(); return false;" onClick="hideHints(); return false;" onkeypress="enterKeyPressed(event)">
											<i class="far fa-question-circle fa-lg me-2" aria-hidden="true" ></i> 
											<span class="sr-only">More info</span>
										</a>
										<?php 
											if(isset($USER->userid)){
												echo $LNG->TAB_RESOURCE_MESSAGE_LOGGEDIN; 
											} else {
												if ($CFG->signupstatus == $CFG->SIGNUP_OPEN) { 
													echo $LNG->TAB_RESOURCE_MESSAGE_LOGGEDOUT_OPEN; 
												} else if ($CFG->signupstatus == $CFG->SIGNUP_REQUEST) { 
													echo $LNG->TAB_RESOURCE_MESSAGE_LOGGEDOUT_REQUEST; 
												} else { 
													echo $LNG->TAB_RESOURCE_MESSAGE_LOGGEDOUT_CLOSED; 
												} 
											} 
										?>
									</div>
								</div>

								<?php if(isset($USER->userid)){ ?>
									<div class="toolbar col-12 addChallenge">
										<a href="javascript:loadDialog('createresource','<?php echo $CFG->homeAddress ?>ui/popups/resourceadd.php', 790,600);" title='<?php echo $LNG->TAB_ADD_RESOURCE_HINT; ?>'><img src="<?php echo $HUB_FLM->getImagePath('add.png'); ?>" alt="" /> <?php echo $LNG->TAB_ADD_RESOURCE_LINK; ?></a>
									</div>
								<?php } ?>

								<div id="searchweb" class="col-12 toolbarIcons">
									<div class="row">
										<div class="col-lg-4 col-md-12">
											<div class="input-group">
												<input type="text" class="form-control" placeholder="<?php echo $LNG->TAB_SEARCH_RESOURCE_LABEL; ?>" aria-label="<?php echo $LNG->TAB_SEARCH_RESOURCE_LABEL; ?>" onkeyup="if (checkKeyPressed(event)) { $('web-go-button').onclick();}" id="qweb" name="q" value="<?php print( htmlspecialchars($q) ); ?>" />
												<div id="q_choices" class="autocomplete"></div>
												<button class="btn btn-outline-dark bg-light" type="button" onclick="filterSearchWebsites();"><?php echo $LNG->TAB_SEARCH_GO_BUTTON; ?></button>
												<button class="btn btn-outline-dark bg-light" type="button" onclick="URL_ARGS['q'] = ''; URL_ARGS['scope'] = 'all'; $('qweb').value='';if ($('scopeweball'))  $('scopeweball').checked=true; refreshWebsites();"><?php echo $LNG->TAB_SEARCH_CLEAR_SEARCH_BUTTON; ?></button>
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
													<a class="active me-3" title="<?php echo $LNG->TAB_RSS_RESOURCE_HINT; ?>" onclick="getNodesFeed(URL_ARGS);">
														<i class="fas fa-rss-square fa-lg" aria-hidden="true" ></i> 
														<span class="sr-only"><?php echo $LNG->TAB_RSS_ALT; ?></span>
													</a>
												<?php } ?>
												<a class="active" title="<?php echo $LNG->TAB_PRINT_TITLE_RESOURCE; ?>" onclick="printNodes(URL_ARGS, '<?php echo $LNG->TAB_PRINT_TITLE_RESOURCE; ?>');">
													<i class="fas fa-print fa-lg" aria-hidden="true" ></i> 
													<span class="sr-only"><?php echo $LNG->TAB_PRINT_ALT; ?></span>
												</a>
											</div>
										</div>
									</div>
								</div>
							</div>

							<div id='tab-content-toolbar-web' class="col-12">
								<div id="tabber" >
									<ul id="webtabs" class="tab2">
										<li class="tab"><a class="tab unselected" id="tab-web-list" href="#web-list"><?php echo $LNG->TAB_VIEW_LIST; ?> <span id="web-list-count"></span></a></li>
										<li class="tab"><a class="tab unselected" id="tab-web-overview" href="#web-overview"><?php echo $LNG->TAB_VIEW_OVERVIEW; ?></a></li>
									</ul>
									<div id="tab-content-web" class="tabcontentouter p-4">
										<div id='tab-content-web-list' class='tabcontentinner'></div>
										<div id='tab-content-web-overview' class='tabcontentinner'></div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

			<!-- ORG TAB PAGE -->
				<div class="container-fluid">
					<div class="row">
						<div id='tab-content-org-div' class='tabcontent orgbackpale' style="display:none;padding:0px">

							<div id="tab-content-org-title" class="orgback tab-content-title"></div>

							<div id='tab-content-org-search' class="issuebackpale">
								<div class="col-12">
									<div class="strapline">
										<a href="javascript:void(0)" onMouseOver="showGlobalHint('OrganizationsTab', event, 'hgrhint'); return false;" onMouseOut="hideHints(); return false;" onClick="hideHints(); return false;" onkeypress="enterKeyPressed(event)">
											<i class="far fa-question-circle fa-lg me-2" aria-hidden="true" ></i> 
											<span class="sr-only">More info</span>
										</a>
										<?php 
											if(isset($USER->userid)){
												echo $LNG->TAB_ORG_MESSAGE_LOGGEDIN; 
											} else {
												if ($CFG->signupstatus == $CFG->SIGNUP_OPEN) { 
													echo $LNG->TAB_ORG_MESSAGE_LOGGEDOUT_OPEN; 
												} else if ($CFG->signupstatus == $CFG->SIGNUP_REQUEST) { 
													echo $LNG->TAB_ORG_MESSAGE_LOGGEDOUT_REQUEST; 
												} else { 
													echo $LNG->TAB_ORG_MESSAGE_LOGGEDOUT_CLOSED; 
												} 
											} 
										?>
									</div>
								</div>

								<?php if(isset($USER->userid)){ ?>
									<div class="toolbar col-12 addChallenge">
										<a href="javascript:loadDialog('createorg','<?php echo $CFG->homeAddress; ?>ui/popups/organizationadd.php?type=Organization', 790,600);" title='<?php echo $LNG->TAB_ADD_ORG_HINT; ?>'><img src="<?php echo $HUB_FLM->getImagePath('add.png'); ?>" alt="" /> <?php echo $LNG->TAB_ADD_ORG_LINK; ?></a>
									</div>
								<?php } ?>

								<div id="searchorg" class="col-12 toolbarIcons">
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

							<div id='tab-content-toolbar-org' class="col-12">
								<div id="tabber" >
									<div id="orgtabs">
										<ul id="tabs" class="tab2">
											<li class="tab"><a class="tab unselected" id="tab-org-list" href="#org-list"><?php echo $LNG->TAB_VIEW_LIST; ?> <span id="org-list-count"></span></a></li>
											<li class="tab"><a class="tab unselected" id="tab-org-overview" href="#org-overview"><?php echo $LNG->TAB_VIEW_OVERVIEW; ?></a></li>
											<li class="tab"><a class="tab unselected" id="tab-org-gmap" href="#org-gmap"><?php echo $LNG->TAB_VIEW_GEOMAP; ?> <span id="org-gmap-count"></span></a></li>
										</ul>
									</div>
									<div id="tab-content-org" class="tabcontentouter p-4">
										<div id='tab-content-org-list' class='tabcontentinner'></div>
										<div id='tab-content-org-overview' class='tabcontentinner'></div>
										<div id='tab-content-org-gmap' class='tabcontentinner'></div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

			<!-- PROJECT TAB PAGE -->
				<div class="container-fluid">
					<div class="row">
						<div id='tab-content-project-div' class='tabcontent projectbackpale' style="display:none;padding:0px">

							<div id="tab-content-project-title" class="projectback tab-content-title"></div>

							<div id='tab-content-project-search' >
								<div class="col-12">
									<div class="strapline">
										<a href="javascript:void(0)" onMouseOver="showGlobalHint('ProjectsTab', event, 'hgrhint'); return false;" onMouseOut="hideHints(); return false;" onClick="hideHints(); return false;" onkeypress="enterKeyPressed(event)">
											<i class="far fa-question-circle fa-lg me-2" aria-hidden="true" ></i> 
											<span class="sr-only">More info</span>
										</a>
										<?php 
											if(isset($USER->userid)){
												echo $LNG->TAB_PROJECT_MESSAGE_LOGGEDIN; 
											} else {
												if ($CFG->signupstatus == $CFG->SIGNUP_OPEN) { 
													echo $LNG->TAB_PROJECT_MESSAGE_LOGGEDOUT_OPEN; 
												} else if ($CFG->signupstatus == $CFG->SIGNUP_REQUEST) { 
													echo $LNG->TAB_PROJECT_MESSAGE_LOGGEDOUT_REQUEST; 
												} else { 
													echo $LNG->TAB_PROJECT_MESSAGE_LOGGEDOUT_CLOSED; 
												} 
											} 
										?>
									</div>
								</div>

								<?php if(isset($USER->userid)){ ?>
									<div class="toolbar col-12 addChallenge">
										<a href="javascript:loadDialog('createproject','<?php echo $CFG->homeAddress; ?>ui/popups/organizationadd.php?type=Project', 790,600);" title='<?php echo $LNG->TAB_ADD_PROJECT_HINT; ?>'><img src="<?php echo $HUB_FLM->getImagePath('add.png'); ?>" alt="" /> <?php echo $LNG->TAB_ADD_PROJECT_LINK; ?></a>
									</div>
								<?php } ?>

								<div id="searchproject" class="col-12 toolbarIcons">
									<div class="row">
										<div class="col-lg-4 col-md-12">
											<div class="input-group">
												<input type="text" class="form-control" placeholder="<?php echo $LNG->TAB_SEARCH_PROJECT_LABEL; ?>" aria-label="<?php echo $LNG->TAB_SEARCH_PROJECT_LABEL; ?>" onkeyup="if (checkKeyPressed(event)) { $('project-go-button').onclick();}" id="qproject" name="q" value="<?php print( htmlspecialchars($q) ); ?>" />
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
											<div id="orgbuttons" class="rss-print-btn">
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

							<div id='tab-content-toolbar-project' class="col-12">
								<div id="tabber" >
									<div id="projecttabs">
										<ul id="tabs" class="tab2">
											<li class="tab"><a class="tab unselected" id="tab-project-list" href="#project-list"><?php echo $LNG->TAB_VIEW_LIST; ?> <span id="project-list-count"></span></a></li>
											<li class="tab"><a class="tab unselected" id="tab-project-overview" href="#project-overview"><?php echo $LNG->TAB_VIEW_OVERVIEW; ?></a></li>
											<li class="tab"><a class="tab unselected" id="tab-project-gmap" href="#project-gmap"><?php echo $LNG->TAB_VIEW_GEOMAP; ?> <span id="project-gmap-count"></span></a></li>
										</ul>
									</div>
									<div id="tab-content-project" class="tabcontentouter p-4">
										<div id='tab-content-project-list' class='tabcontentinner'></div>
										<div id='tab-content-project-overview' class='tabcontentinner'></div>
										<div id='tab-content-project-gmap' class='tabcontentinner'></div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

			<!-- USER TAB PAGE -->
				<div class="container-fluid">
					<div class="row">
						<div id='tab-content-user-div' class='tabcontent peoplebackpale' style="display:none;padding:0px;">

							<div id="tab-content-user-title" class="peopleback"></div>

							<div id='tab-content-user-search' >
								<div class="col-12">
									<div class="strapline">
										<a href="javascript:void(0)" onMouseOver="showGlobalHint('PeopleTab', event, 'hgrhint'); return false;" onMouseOut="hideHints(); return false;" onClick="hideHints(); return false;" onkeypress="enterKeyPressed(event)">
											<i class="far fa-question-circle fa-lg me-2" aria-hidden="true" ></i> 
											<span class="sr-only">More info</span>
										</a>
										<?php echo $LNG->TAB_USER_MESSAGE; ?>
									</div>
								</div>

								<div id="searchuser" class="col-12 toolbarIcons">
									<div class="row">
										<div class="col-lg-4 col-md-12">
											<div class="input-group">
												<input type="text" class="form-control" placeholder="<?php echo $LNG->TAB_SEARCH_USER_LABEL; ?>" aria-label="<?php echo $LNG->TAB_SEARCH_USER_LABEL; ?>" onkeyup="if (checkKeyPressed(event)) { $('user-go-button').onclick();}" id="quser" name="q" value="<?php print( htmlspecialchars($q) ); ?>" />
												<div id="q_choices" class="autocomplete"></div>
												<button class="btn btn-outline-dark bg-light" type="button" onclick="filterSearchUsers();"><?php echo $LNG->TAB_SEARCH_GO_BUTTON; ?></button>
												<button class="btn btn-outline-dark bg-light" type="button" onclick="USER_ARGS['q'] = ''; USER_ARGS['scope'] = 'all'; $('quser').value=''; refreshUsers();"><?php echo $LNG->TAB_SEARCH_CLEAR_SEARCH_BUTTON; ?></button>
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

							<div id='tab-content-toolbar-user' class="col-12">
								<div id="tabber" >
									<ul id="usertabs" class="tab2">
										<li class="tab"><a class="tab unselected" id="tab-user-list" href="#user-list"><?php echo $LNG->TAB_VIEW_LIST; ?> <span id="user-list-count"></span></a></li>
										<li class="tab"><a class="tab unselected" id="tab-user-overview" href="#user-overview"><?php echo $LNG->TAB_VIEW_OVERVIEW; ?></a></li>
										<li class="tab"><a class="tab unselected" id="tab-user-net" href="<?php echo $CFG->homeAddress; ?>#user-net"><?php echo $LNG->TAB_VIEW_SOCIALMAP; ?> <span id="user-net-count"></span></a></li>
										<li class="tab"><a class="tab unselected" id="tab-user-usergmap" href="#user-usergmap"><?php echo $LNG->TAB_VIEW_GEOMAP_USER; ?> <span id="user-gmap-count"></span></a></li>
										<li class="tab"><a class="tab unselected" id="tab-user-nodegmap" href="#user-nodegmap"><?php echo $LNG->TAB_VIEW_GEOMAP_USERNODE; ?> <span id="user-nodegmap-count"></span></a></li>
									</ul>
									<div id="tab-content-user" class="tabcontentouter p-4">
										<div id='tab-content-user-list' class='tabcontentinner'></div>
										<div id='tab-content-user-overview' class='tabcontentinner'></div>
										<div id='tab-content-user-net' class='row tabcontentinner'></div>
										<div id='tab-content-user-usergmap' class='tabcontentinner'></div>
										<div id='tab-content-user-nodegmap' class='tabcontentinner'></div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

			<!-- COMMENT TAB PAGE -->
			<?php if ($CFG->HAS_OPEN_COMMENTS) { ?>
				<div class="container-fluid">
					<div class="row">
						<div id='tab-content-comment-div' class='tabcontent peoplebackpale' style="display:none;padding:0px;">

							<div id="tab-content-comment-title" class="peopleback"></div>

							<div id='tab-content-search-comment' >
								<div class="col-12">
									<div class="strapline">
										<?php 
											if(isset($USER->userid)){
												echo $LNG->TAB_COMMENT_MESSAGE_LOGGEDIN; 
											} else {
												if ($CFG->signupstatus == $CFG->SIGNUP_OPEN) { 
													echo $LNG->TAB_COMMENT_MESSAGE_LOGGEDOUT_OPEN; 
												} else if ($CFG->signupstatus == $CFG->SIGNUP_REQUEST) { 
													echo $LNG->TAB_COMMENT_MESSAGE_LOGGEDOUT_REQUEST; 
												} else { 
													echo $LNG->TAB_COMMENT_MESSAGE_LOGGEDOUT_CLOSED; 
												} 
											} 
										?>
									</div>
								</div>

								<?php if(isset($USER->userid)){ ?>
									<div class="toolbar col-12 addChallenge">
										<a href="javascript:loadDialog('createcomment','<?php echo $CFG->homeAddress; ?>ui/popups/commentadd.php', 790,500);" title='<?php echo $LNG->TAB_ADD_COMMENT_HINT; ?>'><img src="<?php echo $HUB_FLM->getImagePath('add.png'); ?>" alt="" /> <?php echo $LNG->TAB_ADD_COMMENT_LINK; ?></a>
									</div>
								<?php } ?>

								<div id="searchcomment" class="col-12 toolbarIcons">
									<div class="row">
										<div class="col-lg-4 col-md-12">
											<div class="input-group">
												<input type="text" class="form-control" placeholder="<?php echo $LNG->TAB_SEARCH_COMMENT_LABEL; ?>" aria-label="<?php echo $LNG->TAB_SEARCH_COMMENT_LABEL; ?>" onkeyup="if (checkKeyPressed(event)) { $('comment-go-button').onclick();}" id="qcomment" name="q" value="<?php print( htmlspecialchars($q) ); ?>" />
												<div id="q_choices" class="autocomplete"></div>
												<button class="btn btn-outline-dark bg-light" type="button" onclick="filterSearchComments();"><?php echo $LNG->TAB_SEARCH_GO_BUTTON; ?></button>
												<button class="btn btn-outline-dark bg-light" type="button" onclick="COMMENT_ARGS['q'] = ''; COMMENT_ARGS['scope'] = 'all'; $('qcomment').value=''; refreshComments();"><?php echo $LNG->TAB_SEARCH_CLEAR_SEARCH_BUTTON; ?></button>
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
													<a class="active me-3" title="<?php echo $LNG->TAB_RSS_COMMENT_HINT; ?>" onclick="getCommentNodesFeed(COMMENT_ARGS);">
														<i class="fas fa-rss-square fa-lg" aria-hidden="true" ></i> 
														<span class="sr-only"><?php echo $LNG->TAB_RSS_ALT; ?></span>
													</a>
												<?php } ?>
												<a class="active" title="<?php echo $LNG->TAB_PRINT_HINT_COMMENT; ?>" onclick="printCommentNodes(COMMENT_ARGS, '<?php echo $LNG->TAB_PRINT_TITLE_COMMENT; ?>');">
													<i class="fas fa-print fa-lg" aria-hidden="true" ></i> 
													<span class="sr-only"><?php echo $LNG->TAB_PRINT_ALT; ?></span>
												</a>
											</div>
										</div>
									</div>
								</div>
							</div>

							<div id='tab-content-toolbar-comment' class="col-12">
								<div id="tabber" >
									<ul id="tabs" class="tab2">
										<li class="tab"><a class="tab unselected" id="tab-comment-list" href="#comment-list"><?php echo $LNG->TAB_VIEW_LIST; ?> <span id="comment-list-count"></span></a></li>
									</ul>
									<div id="tab-content-comment" class="tabcontentouter p-4">
										<div id='tab-content-comment-list' class='tabcontentinner'></div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			<?php } ?>

			<!-- NEWS TAB PAGE -->
			<div class="container-fluid">
				<div class="row">
					<div id='tab-content-news-div' class='tabcontent peoplebackpale' style="display:none;padding:0px;">
						<div class="peopleback tab-content-title"></div>
						<div id='tab-content-news-search'>
							<div id="searchnews" class="col-12 toolbarIcons mt-3">
								<div class="row">
									<div class="col-lg-4 col-md-12">
										<div class="input-group">
											<input type="text" class="form-control" placeholder="<?php echo $LNG->TAB_SEARCH_USER_LABEL; ?>" aria-label="<?php echo $LNG->TAB_SEARCH_USER_LABEL; ?>" onkeyup="if (checkKeyPressed(event)) { $('news-go-button').onclick();}" id="qnews" name="q" value="<?php print( htmlspecialchars($q) ); ?>" />
											<div id="q_choices" class="autocomplete"></div>
											<button class="btn btn-outline-dark bg-light" type="button" onclick="filterSearchNews();"><?php echo $LNG->TAB_SEARCH_GO_BUTTON; ?></button>
											<button class="btn btn-outline-dark bg-light" type="button" onclick="NEWS_ARGS['q'] = ''; NEWS_ARGS['scope'] = 'all'; $('qnews').value=''; refreshNews();"><?php echo $LNG->TAB_SEARCH_CLEAR_SEARCH_BUTTON; ?></button>
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

						<div id='tab-content-toolbar-news' class="col-12">
							<div id="tabber" >
								<ul id="tabs" class="tab2">
									<li class="tab"><a class="tab unselected" id="tab-news-list" href="#comment-list"><?php echo $LNG->TAB_VIEW_LIST; ?> <span id="news-list-count"></span></a></li>
								</ul>
								<div id="tab-content-news" class="tabcontentouter p-4">
									<div id='tab-content-news-list' class='tabcontentinner'></div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
        </div>
    </div>

<?php } ?>

<script type='text/javascript'>
	function updateUserFollow() {
		$('followupdate').submit()
	}
</script>
