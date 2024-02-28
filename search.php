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

	$searchid = optional_param("sid","",PARAM_TEXT);
	$query = stripslashes(parseToJSON(optional_param("q","",PARAM_TEXT)));

	// need to do parseToJSON to convert any '+' symbols as they are now used in searches.

	$scope = optional_param("scope","all",PARAM_TEXT);
	$tagsonly = optional_param("tagsonly",false,PARAM_BOOL);

	// default parameters
	$start = optional_param("start",0,PARAM_INT);
	$max = optional_param("max",20,PARAM_INT);
	$orderby = optional_param("orderby","",PARAM_ALPHA);
	$sort = optional_param("sort","DESC",PARAM_ALPHA);

	if ($searchid == "" && isset($USER->userid)) {
		$fromid = optional_param("fromid",'',PARAM_TEXT);
		$tagsonlyoption = 'N';
		if ($tagsonly) {
			$tagsonlyoption = 'Y';
		}
		$searchid = auditSearch($USER->userid, $query, $tagsonlyoption, 'main', $fromid);
		if ($searchid != "") {
			header("Location: ".$CFG->homeAddress."search.php?sid=".$searchid."&q=".$query."&scope=".$scope."&tagsonly=".$tagsonly);
			//echo "<meta http-equiv='refresh' content='0; url=".$CFG->homeAddress."search.php?searchid=".$searchid."&q=".$query."&scope=".$scope."&tagsonly=".$tagsonly."'></meta>";
			die;
		}
	}

	include_once($HUB_FLM->getCodeDirPath("core/utillib.php"));
	array_push($HEADER,'<script src="'.$HUB_FLM->getCodeWebPath('ui/searchlib.js.php').'" type="text/javascript"></script>');
	include_once($HUB_FLM->getCodeDirPath("ui/header.php"));

	$args = array();

	$args["filternodetypes"] = '';

	$args["q"] = $query;
	$args["scope"] = $scope;
	$args["tagsonly"] = $tagsonly;
	$args["searchid"] = $searchid;

	$args["start"] = $start;
	$args["max"] = $max;

	if ($orderby == "") {
		$args["orderby"] = 'date';
	} else {
		$args["orderby"] = $orderby;
	}
	$args["sort"] = $sort;

	$CONTEXT = $CFG->GLOBAL_CONTEXT;

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
	echo "var SOLUTION_ARGS = ".$argsStr.";";
	echo "var ISSUE_ARGS = ".$argsStr.";";
	echo "var EVIDENCE_ARGS = ".$argsStr.";";
	echo "var PROJECT_ARGS = ".$argsStr.";";
	echo "var CHAT_ARGS = ".$argsStr.";";
	echo "var COMMENT_ARGS = ".$argsStr.";";
	echo "var NEWS_ARGS = ".$argsStr.";";
	echo "</script>";
?>

<div class="container-fluid">
	<div class="row p-3">		
		<div class="col">
			<?php
				if ($query == ""){
					echo "<h1>".$LNG->SEARCH_TITLE_ERROR."</h1><br/>";
					echo $LNG->SEARCH_ERROR_EMPTY;
					include_once($HUB_FLM->getCodeDirPath("ui/footer.php"));
					return;
				}
			?>

			<script type="text/javascript">
				Event.observe(window, 'load', function() {
					buildSearchToolbar($("content-controls"), NODE_ARGS['q'], NODE_ARGS['tagsonly'])
					//addControls();

					<?php if ($CFG->HAS_CHALLENGE) {
						echo 'loadchallenges(CONTEXT,CHALLENGE_ARGS);';
					} ?>

					loadissues(CONTEXT,ISSUE_ARGS);

					<?php if ($CFG->HAS_SOLUTION) {
						echo 'loadsolutions(CONTEXT,SOLUTION_ARGS);';
					} ?>


					<?php if ($CFG->HAS_CLAIM) {
						echo 'loadclaims(CONTEXT,CLAIM_ARGS);';
					} ?>

					loadevidence(CONTEXT,EVIDENCE_ARGS);
					loadurls(CONTEXT,URL_ARGS);
					loadorgs(CONTEXT,ORG_ARGS);
					loadprojects(CONTEXT,PROJECT_ARGS);
					loadchat(CONTEXT,CHAT_ARGS);

					<?php if ($CFG->HAS_OPEN_COMMENTS) {
					echo 'loadcomment(CONTEXT,COMMENT_ARGS);';
					} ?>


					loadnews(CONTEXT,NEWS_ARGS);
					loadusers(CONTEXT,USER_ARGS);
				});
			</script>

			<a name="top"></a>
			<div id="CONTEXT">
				<?php if ($tagsonly) { ?>
					<h1><?php echo $LNG->SEARCH_TITLE_TAGS; ?> <?php print( htmlspecialchars($query) ); ?></h1>
				<?php } else { ?>
					<h1><?php echo $LNG->SEARCH_TITLE; ?> <?php print( htmlspecialchars($query) ); ?></h1>
				<?php } ?>
			</div>

			<div id="context">
				<div class="row">
					<div id="content-controls"></div>
				</div>

				<div id="q_results" name="q_results" class="row searchResultsMenu">
					<?php if ($CFG->HAS_CHALLENGE) { ?>
						<div class="col-auto"><a id="challenge-result-menu" href="#challengeresult"><?php echo $LNG->CHALLENGES_NAME; ?>: <span id="challenge-list-count-main"></span></a><span class="ms-4">|</span></div>
					<?php } ?>
					<div class="col-auto"><a id="issue-result-menu" href="#issueresult"><?php echo $LNG->ISSUES_NAME; ?>: <span id="issue-list-count-main"></span></a><span class="ms-4">|</span></div>
					<?php if ($CFG->HAS_SOLUTION) { ?>
						<div class="col-auto"><a id="solution-result-menu" href="#solutionresult"><?php echo $LNG->SOLUTIONS_NAME; ?>: <span id="solution-list-count-main"></span></a><span class="ms-4">|</span></div>
					<?php } ?>
					<?php if ($CFG->HAS_CLAIM) { ?>
						<div class="col-auto"><a id="claim-result-menu" href="#claimresult"><?php echo $LNG->CLAIMS_NAME; ?>: <span id="claim-list-count-main"></span></a><span class="ms-4">|</span></div>
					<?php } ?>
					<div class="col-auto"><a id="evidence-result-menu" href="#evidenceresult"><?php echo $LNG->EVIDENCES_NAME; ?>: <span id="evidence-list-count-main"></span></a><span class="ms-4">|</span></div>
					<div class="col-auto"><a id="web-result-menu" href="#webresult"><?php echo $LNG->RESOURCES_NAME; ?>: <span id="web-list-count-main"></span></a><span class="ms-4">|</span></div>
					<div class="col-auto"><a id="org-result-menu" href="#orgresult"><?php echo $LNG->ORGS_NAME; ?>: <span id="org-list-count-main"></span></a><span class="ms-4">|</span></div>
					<div class="col-auto"><a id="project-result-menu" href="#projectresult"><?php echo $LNG->PROJECTS_NAME; ?>: <span id="project-list-count-main"></span></a><span class="ms-4">|</span></div>
					<div class="col-auto"><a id="chat-result-menu" href="#chatresult"><?php echo $LNG->CHATS_NAME; ?>: <span id="chat-list-count-main"></span></a><span class="ms-4">|</span></div>
					<?php if ($CFG->HAS_OPEN_COMMENTS) { ?>
						<div class="col-auto"><a id="comment-result-menu" href="#commentresult"><?php echo $LNG->COMMENTS_NAME; ?>: <span id="comment-list-count-main"></span></a><span class="ms-4">|</span></div>
					<?php } ?>
					<div class="col-auto"><a id="news-result-menu" href="#newsresult"><?php echo $LNG->NEWSS_NAME; ?>: <span id="news-list-count-main"></span></a><span class="ms-4">|</span></div>
					<?php if (!$tagsonly) { ?>
						<div class="col-auto"><a id="user-result-menu" href="#userresult"><?php echo $LNG->USERS_NAME; ?>: <span id="user-list-count-main"></span></a></div>
					<?php } ?>
				</div>

				<?php if ($CFG->HAS_CHALLENGE) { ?>
				<div id="content-challenge-main" class="searchresultblock">
					<a name="challengeresult"></a>
					<div class="strapline searchresulttitle"><span id="challenge-list-count">0</span> <span id="challenge-list-title"><?php echo $LNG->CHALLENGES_NAME; ?></span><a title="<?php echo $LNG->SEARCH_BACKTOTOP; ?>" href="#top"><img alt="<?php echo $LNG->SEARCH_BACKTOTOP_IMG_ALT; ?>" class="searchresultuparrow" border="0" src="<?php echo $HUB_FLM->getImagePath("arrow-up2.png"); ?>" /></a></div>
					<div class="searchresultcontent" id="content-challenge-list"></div>
				</div>
				<?php } ?>

				<div id="content-issue-main" class="searchresultblock">
					<a name="issueresult"></a>
					<div class="strapline searchresulttitle"><span id="issue-list-count">0</span> <span id="issue-list-title"><?php echo $LNG->ISSUES_NAME; ?></span><a title="<?php echo $LNG->SEARCH_BACKTOTOP; ?>" href="#top"><img alt="<?php echo $LNG->SEARCH_BACKTOTOP_IMG_ALT; ?>" class="searchresultuparrow" border="0" src="<?php echo $HUB_FLM->getImagePath("arrow-up2.png"); ?>" /></a></div>
					<div class="searchresultcontent" id="content-issue-list"></div>
				</div>

				<?php if ($CFG->HAS_SOLUTION) { ?>
				<div id="content-solution-main" class="searchresultblock">
					<a name="solutionresult"></a>
					<div class="strapline searchresulttitle"><span id="solution-list-count">0</span> <span id="solution-list-title"><?php echo $LNG->SOLUTIONS_NAME; ?></span><a title="<?php echo $LNG->SEARCH_BACKTOTOP; ?>" href="#top"><img alt="<?php echo $LNG->SEARCH_BACKTOTOP_IMG_ALT; ?>" class="searchresultuparrow" border="0" src="<?php echo $HUB_FLM->getImagePath("arrow-up2.png"); ?>" /></a></div>
					<div class="searchresultcontent" id="content-solution-list"></div>
				</div>
				<?php } ?>

				<?php if ($CFG->HAS_CLAIM) { ?>
				<div id="content-claim-main" class="searchresultblock">
					<a name="claimresult"></a>
					<div class="strapline searchresulttitle"><span id="claim-list-count">0</span> <span id="claim-list-title"><?php echo $LNG->CLAIMS_NAME; ?></span><a title="<?php echo $LNG->SEARCH_BACKTOTOP; ?>" href="#top"><img alt="<?php echo $LNG->SEARCH_BACKTOTOP_IMG_ALT; ?>" class="searchresultuparrow" border="0" src="<?php echo $HUB_FLM->getImagePath("arrow-up2.png"); ?>" /></a></div>
					<div class="searchresultcontent" id="content-claim-list"></div>
				</div>
				<?php } ?>

				<div id="content-evidence-main" class="searchresultblock">
					<a name="evidenceresult"></a>
					<div class="strapline searchresulttitle"><span id="evidence-list-count">0</span> <span id="evidence-list-title"><?php echo $LNG->EVIDENCES_NAME; ?></span><a title="<?php echo $LNG->SEARCH_BACKTOTOP; ?>" href="#top"><img alt="<?php echo $LNG->SEARCH_BACKTOTOP_IMG_ALT; ?>" class="searchresultuparrow" border="0" src="<?php echo $HUB_FLM->getImagePath("arrow-up2.png"); ?>" /></a></div>
					<div class="searchresultcontent" id="content-evidence-list"></div>
				</div>

				<div id="content-web-main" class="searchresultblock">
					<a name="webresult"></a>
					<div class="strapline searchresulttitle"><span id="web-list-count">0</span> <span id="web-list-title"><?php echo $LNG->RESOURCES_NAME; ?></span><a title="<?php echo $LNG->SEARCH_BACKTOTOP; ?>" href="#top"><img alt="<?php echo $LNG->SEARCH_BACKTOTOP_IMG_ALT; ?>" class="searchresultuparrow" border="0" src="<?php echo $HUB_FLM->getImagePath("arrow-up2.png"); ?>" /></a></div>
					<div class="searchresultcontent" id="content-web-list"></div>
				</div>

				<div id="content-org-main" class="searchresultblock">
					<a name="orgresult"></a>
					<div class="strapline searchresulttitle"><span id="org-list-count">0</span> <span id="org-list-title"><?php echo $LNG->ORGS_NAME; ?></span><a title="<?php echo $LNG->SEARCH_BACKTOTOP; ?>" href="#top"><img alt="<?php echo $LNG->SEARCH_BACKTOTOP_IMG_ALT; ?>" class="searchresultuparrow" border="0" src="<?php echo $HUB_FLM->getImagePath("arrow-up2.png"); ?>" /></a></div>
					<div class="searchresultcontent" id="content-org-list"></div>
				</div>

				<div id="content-project-main" class="searchresultblock">
					<a name="projectresult"></a>
					<div class="strapline searchresulttitle"><span id="project-list-count">0</span> <span id="project-list-title"><?php echo $LNG->PROJECTS_NAME; ?></span><a title="<?php echo $LNG->SEARCH_BACKTOTOP; ?>" href="#top"><img alt="<?php echo $LNG->SEARCH_BACKTOTOP_IMG_ALT; ?>" class="searchresultuparrow" border="0" src="<?php echo $HUB_FLM->getImagePath("arrow-up2.png"); ?>" /></a></div>
					<div class="searchresultcontent" id="content-project-list"></div>
				</div>

				<div id="content-chat-main" class="searchresultblock">
					<a name="chatresult"></a>
					<div class="strapline searchresulttitle"><span id="chat-list-count">0</span> <span id="chat-list-title"><?php echo $LNG->CHATS_NAME; ?></span><a title="<?php echo $LNG->SEARCH_BACKTOTOP; ?>" href="#top"><img alt="<?php echo $LNG->SEARCH_BACKTOTOP_IMG_ALT; ?>" class="searchresultuparrow" border="0" src="<?php echo $HUB_FLM->getImagePath("arrow-up2.png"); ?>" /></a></div>
					<div class="searchresultcontent" id="content-chat-list"></div>
				</div>

				<?php if ($CFG->HAS_OPEN_COMMENTS) { ?>
				<div id="content-comment-main" class="searchresultblock">
					<a name="commentresult"></a>
					<div class="strapline searchresulttitle"><span id="comment-list-count">0</span> <span id="comment-list-title"><?php echo $LNG->COMMENTS_NAME; ?></span><a title="<?php echo $LNG->SEARCH_BACKTOTOP; ?>" href="#top"><img alt="<?php echo $LNG->SEARCH_BACKTOTOP_IMG_ALT; ?>" class="searchresultuparrow" border="0" src="<?php echo $HUB_FLM->getImagePath("arrow-up2.png"); ?>" /></a></div>
					<div class="searchresultcontent" id="content-comment-list"></div>
				</div>
				<?php } ?>

				<div id="content-news-main" class="searchresultblock">
					<a name="newsresult"></a>
					<div class="strapline searchresulttitle"><span id="news-list-count">0</span> <span id="news-list-title"><?php echo $LNG->NEWSS_NAME; ?></span><a title="<?php echo $LNG->SEARCH_BACKTOTOP; ?>" href="#top"><img alt="<?php echo $LNG->SEARCH_BACKTOTOP_IMG_ALT; ?>" class="searchresultuparrow" border="0" src="<?php echo $HUB_FLM->getImagePath("arrow-up2.png"); ?>" /></a></div>
					<div class="searchresultcontent" id="content-news-list"></div>
				</div>

				<?php if (!$tagsonly) { ?>
				<div id="content-user-main" class="searchresultblock">
					<a name="userresult"></a>
					<fieldset class="overviewfieldset">
						<legend class="overviewlegend widgettextcolor"><span id="user-list-count">0</span> <span id="user-list-title"><?php echo $LNG->USERS_NAME; ?></span><a title="<?php echo $LNG->SEARCH_BACKTOTOP; ?>" href="#top"><img alt="<?php echo $LNG->SEARCH_BACKTOTOP_IMG_ALT; ?>" class="searchresultuparrow" border="0" src="<?php echo $HUB_FLM->getImagePath("arrow-up2.png"); ?>" /></a></legend>
						<div id="content-user-list"></div>
					</fieldset>
				</div>
				<?php } ?>
			</div>
		</div>
	</div>
</div>

<?php
	include_once($HUB_FLM->getCodeDirPath("ui/footer.php"));
?>
