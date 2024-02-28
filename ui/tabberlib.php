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

    <div id="tabber" style="clear:both;float:left; width: 100%;">
        <ul id="tabs" class="tab">
			<li class="tab"><a class="tab" id="tab-home" href="<?php echo $CFG->homeAddress; ?>#home-list"><span class="tab"><?php echo $LNG->TAB_HOME; ?></span></a></li>
			<?php if ($CFG->HAS_CHALLENGE) { ?>
				<li class="tab"><a class="tab" id="tab-challenge" href="<?php echo $CFG->homeAddress; ?>#challenge-list"><span class="tab tabchallenge"><?php echo $LNG->TAB_CHALLENGE; ?></span></a></li>
			<?php } ?>

			<?php if ( $CFG->issuesManaged == false ) { ?>
				<li class="tab"><a class="tab" id="tab-issue" href="<?php echo $CFG->homeAddress; ?>#issue-list"><span class="tab tabissue"><?php echo $LNG->TAB_ISSUE; ?></span></a></li>
			<?php } ?>


			<?php if ($CFG->HAS_SOLUTION) { ?>
				<li class="tab"><a class="tab" id="tab-solution" href="<?php echo $CFG->homeAddress; ?>#solution-list"><span class="tab tabsolution"><?php echo $LNG->TAB_SOLUTION; ?></span></a></li>
			<?php } ?>

			<?php if ($CFG->HAS_CLAIM) { ?>
				<li class="tab"><a class="tab" id="tab-claim" href="<?php echo $CFG->homeAddress; ?>#claim-list"><span class="tab tabclaim"><?php echo $LNG->TAB_CLAIM; ?></span></a></li>
			<?php } ?>

			<li class="tab"><a class="tab" id="tab-evidence" href="<?php echo $CFG->homeAddress; ?>#evidence-list"><span class="tab tabevidence"><?php echo $LNG->TAB_EVIDENCE; ?></span></a></li>
			<li class="tab"><a class="tab" id="tab-web" href="<?php echo $CFG->homeAddress; ?>#web-list"><span class="tab tabresource"><?php echo $LNG->TAB_RESOURCE; ?></span></a></li>

			<?php if ($CFG->hasSocialTab) { ?>
				<li class="tab" id="tab-social-li" style="float:left;"><a class="tab" id="tab-social" href="#social-list"><span class="tab taborg"><span id="tab-social-text"><?php echo $LNG->TAB_SOCIAL; ?></span><img style="padding:0px; margin:0px;margin-left:5px;vertical-align:middle" id="socialmenuarrow" border="0" src="<?php echo $HUB_FLM->getImagePath('arrow-down3.png'); ?>" /></span></a></li>
			<?php } else { ?>
				<li class="tab"><a class="tab" id="tab-org" href="<?php echo $CFG->homeAddress; ?>#org-list"><span class="tab taborg"><?php echo $LNG->TAB_ORG; ?></span></a></li>
				<li class="tab"><a class="tab" id="tab-project" href="<?php echo $CFG->homeAddress; ?>#project-list"><span class="tab tabproject"><?php echo $LNG->TAB_PROJECT; ?></span></a></li>
				<li cass="tab"><a class="tab" id="tab-user" href="<?php echo $CFG->homeAddress; ?>#user-list"><span class="tab tabuser"><?php echo $LNG->TAB_USER; ?></span></a></li>
			<?php } ?>

			<?php if ($CFG->HAS_OPEN_COMMENTS) { ?>
				<li class="tab"><a class="tab" id="tab-comment" href="<?php echo $CFG->homeAddress; ?>#comment-list"><span class="tab taborg"><?php echo $LNG->TAB_COMMENT; ?></span></a></li>
			<?php } ?>

			<?php if ($CFG->HAS_NEWS) { ?>
				<li class="tab"><a class="tab" id="tab-news" href="<?php echo $CFG->homeAddress; ?>#news-list"><span class="tab taborg"><?php echo $LNG->TAB_NEWS; ?></span></a></li>
			<?php } ?>
        </ul>

        <div id="tabs-content" style="float: left; width: 100%;">

			<!-- HOME TAB PAGES -->
	        <?php if ($context == $CFG->USER_CONTEXT) { ?>
            <div id='tab-content-home-div' class='tabcontentouter'>
	            <div id='tab-content-home'>
					<?php include($HUB_FLM->getCodeDirPath("ui/homepageuser.php")); ?>
	            </div>
			</div>
	        <?php } else { ?>
            <div id='tab-content-home-div' class='tabcontenthome'>
	            <div id='tab-content-home'>
					<?php include($HUB_FLM->getCodeDirPath("ui/homepage.php")); ?>
	            </div>
			</div>
			<?php } ?>

            <div id='tab-content-social-div' class='tabcontentouter'>
			</div>

			<!-- CHALLENGE TAB PAGE -->
			<?php if ($CFG->HAS_CHALLENGE) { ?>
			<div id='tab-content-challenge-div' class='tabcontent issuebackpale' style="display:none;padding:0px;">

	  			<div id="tab-content-challenge-title" class="challengeback" style="height:10px;clear:both;float:left;width:100%;margin:0px;">
	  				<!-- div class="challengeback tabtitlebar" style="padding:4px;margin:0px;font-size:9pt"><?php echo $LNG->TAB_CHALLENGE_STRAPLINE; ?><a href="javascript:void(0)" onMouseOver="showGlobalHint('ChallengesTab', event, 'hgrhint'); return false;" onMouseOut="hideHints(); return false;" onClick="hideHints(); return false;" onkeypress="enterKeyPressed(event)"><img style="vertical-align:bottom" src="<?php echo $HUB_FLM->getImagePath('info.png'); ?>" border="0" style="margin:0px;margin-left: 5px;padding:0px" /></a></div -->
	  			</div>

				<!-- ?php drawNetworkNavigationBar('Challenge'); ? -->

            	<div id='tab-content-challenge-search' style='margin:5px;padding-top:1px;clear:both; float:left; width: 100%;'>
	  				<div class="strapline">
	  				<a style="margin-right: 10px;" href="javascript:void(0)" onMouseOver="showGlobalHint('ChallengesTab', event, 'hgrhint'); return false;" onMouseOut="hideHints(); return false;" onClick="hideHints(); return false;" onkeypress="enterKeyPressed(event)"><img style="vertical-align:bottom" src="<?php echo $HUB_FLM->getImagePath('info.png'); ?>" border="0" /></a>
	  				<?php echo $LNG->TAB_CHALLENGE_MESSAGE; ?>
	  				</div>

					<?php if(isset($USER->userid) && $USER->getIsAdmin() == "Y"){ ?>
					<span class="toolbar" style="margin-top:0px;">
						<a style="font-size: 12pt" href="javascript:loadDialog('createchallenge','<?php echo $CFG->homeAddress; ?>ui/popups/challengeadd.php', 790,600);" title='<?php echo $LNG->TAB_ADD_CHALLENGE_HINT; ?>'><img style="vertical-align:bottom" src="<?php echo $HUB_FLM->getImagePath('add.png'); ?>" border="0" style="margin:0px;margin-left: 5px;padding:0px" /> <?php echo $LNG->TAB_ADD_CHALLENGE_LINK; ?></a>
					</span>
					<?php } ?>

					<div id="searchchallenge" style="float:left;margin-left: 10px;">
						<div style="float:left;margin-left: 10px;" id="challengebuttons">
							<?php if ($CFG->hasRss) { ?>
								<img src="<?php echo $HUB_FLM->getImagePath('feed-icon-20x20.png'); ?>" alt="<?php echo $LNG->TAB_RSS_ALT; ?>" title="<?php echo $LNG->TAB_RSS_CHALLENGE_HINT; ?>" class="active" style="padding-top:0px;padding-left:10px;" border="0" onclick="javascript: getNodesFeed(CHALLENGE_ARGS);" />
							<?php } ?>
							<img src="<?php echo $HUB_FLM->getImagePath('printer.png'); ?>" alt="<?php echo $LNG->TAB_PRINT_ALT; ?>" title="<?php echo $LNG->TAB_PRINT_HINT_CHALLENGE; ?>" class="active" style="padding-top:0px;padding-left:10px;" border="0" onclick="javascript: printNodes(CHALLENGE_ARGS, '<?php echo $LNG->TAB_PRINT_TITLE_CHALLENGE; ?>');" />
						</div>
					</div>
            	</div>

            	<div id='tab-content-toolbar-challenge' style='clear:both; float:left; width: 100%; height: 100%'>
					<div id="tabber" style="width:100%">
						<div id="challengetabs">
							<ul id="tabs" class="tab2">
								<li class="tab"><a class="tab unselected" id="tab-challenge-list" href="#challenge-list"><span class="tab2"><?php echo $LNG->TAB_VIEW_LIST; ?> <span id="challenge-list-count"></span></span></a></li>
								<li class="tab"><a class="tab unselected" id="tab-challenge-overview" href="#challenge-overview"><span class="tab2"><?php echo $LNG->TAB_VIEW_OVERVIEW; ?> </span></a></li>
								<!-- li class="tab"><a class="tab unselected" id="tab-challenge-net" href="#challenge-net"><span class="tab2"><?php echo $LNG->TAB_VIEW_THEME_MAP; ?> <span id="challenge-net-count"></span></span></a></li -->
							</ul>
						</div>
						<div id="tab-content-challenge" class="tabcontentouter">
           					<div id='tab-content-challenge-list' class='tabcontentinner'></div>
           					<div id='tab-content-challenge-overview' class='tabcontentinner'></div>
           					<!-- div id='tab-content-challenge-net' class='tabcontentinner'></div -->
						</div>
					</div>
            	</div>

			</div>
			<?php } ?>

			<!-- ISSUE TAB PAGE -->
			<?php if ( $CFG->issuesManaged == false ) { ?>
            <div id='tab-content-issue-div' class='tabcontent issuebackpale' style="display:none;padding:0px;">

	  			<div id="tab-content-issue-title" class="issueback" style="height:10px;clear:both;float:left;width:100%;margin:0px;">
	  				<!-- div class="issueback tabtitlebar" style="padding:4px;margin:0px;font-size:9pt"><?php echo $LNG->TAB_ISSUE_STRAPLINE;?> <a href="javascript:void(0)" onMouseOver="showGlobalHint('IssuesTab', event, 'hgrhint'); return false;" onMouseOut="hideHints(); return false;" onClick="hideHints(); return false;" onkeypress="enterKeyPressed(event)"><img style="vertical-align:bottom" src="<?php echo $HUB_FLM->getImagePath('info.png'); ?>" border="0" style="margin-left: 5px;" /></a></div -->
	  			</div>

				<!-- ?php drawNetworkNavigationBar('Issue'); ? -->

            	<div id='tab-content-issue-search' style='margin:5px;padding-top:1px;clear:both; float:left; width: 100%;'>
					<div class="strapline">
					<a style="margin-right: 10px;" href="javascript:void(0)" onMouseOver="showGlobalHint('IssuesTab', event, 'hgrhint'); return false;" onMouseOut="hideHints(); return false;" onClick="hideHints(); return false;" onkeypress="enterKeyPressed(event)"><img style="vertical-align:bottom" src="<?php echo $HUB_FLM->getImagePath('info.png'); ?>" border="0" /></a>
					<?php if(isset($USER->userid)){ ?>
						<?php echo $LNG->TAB_ISSUE_MESSAGE_LOGGEDIN; ?>
					<?php } else {
						if ($CFG->signupstatus == $CFG->SIGNUP_OPEN) { ?>
							<?php echo $LNG->TAB_ISSUE_MESSAGE_LOGGEDOUT_OPEN; ?>
						<?php } else if ($CFG->signupstatus == $CFG->SIGNUP_REQUEST) { ?>
							<?php echo $LNG->TAB_ISSUE_MESSAGE_LOGGEDOUT_REQUEST; ?>
						<?php } else { ?>
							<?php echo $LNG->TAB_ISSUE_MESSAGE_LOGGEDOUT_CLOSED; ?>
						<?php } ?>
					<?php } ?>
					</div>

					<?php if ( isset($USER->userid) && ( $CFG->issuesManaged == false || ($CFG->issuesManaged == true && $USER->getIsAdmin() == "Y") ) ){ ?>
					<span class="toolbar" style="margin-top:0px;">
						<a style="font-size: 12pt" href="javascript:loadDialog('createissue','<?php echo $CFG->homeAddress; ?>ui/popups/issueadd.php', 790,600);" title='<?php echo $LNG->TAB_ADD_ISSUE_HINT; ?>'><img style="vertical-align:bottom" src="<?php echo $HUB_FLM->getImagePath('add.png'); ?>" border="0" style="margin:0px;margin-left: 5px;padding:0px" /> <?php echo $LNG->TAB_ADD_ISSUE_LINK; ?></a>
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
							<?php if ($CFG->hasRss) { ?>
								<img src="<?php echo $HUB_FLM->getImagePath('feed-icon-20x20.png'); ?>" alt="<?php echo $LNG->TAB_RSS_ALT; ?>" title="<?php echo $LNG->TAB_RSS_ISSUE_HINT; ?>" class="active" style="padding-top:0px;padding-left:10px;" border="0" onclick="javascript: getNodesFeed(ISSUE_ARGS);" />
							<?php } ?>
							<img src="<?php echo $HUB_FLM->getImagePath('printer.png'); ?>" alt="<?php echo $LNG->TAB_PRINT_ALT; ?>" title="<?php echo $LNG->TAB_PRINT_HINT_ISSUE; ?>" class="active" style="padding-top:0px;padding-left:10px;" border="0" onclick="javascript: printNodes(ISSUE_ARGS, '<?php echo $LNG->TAB_PRINT_TITLE_ISSUE; ?>');" />
						</div>
					 </div>
            	</div>

            	<div id='tab-content-toolbar-issue' style='clear:both; float:left; width: 100%; height: 100%'>
					<div id="tabber" style="width:100%">
						<div id="issuetabs">
							<ul id="tabs" class="tab2">
								<li class="tab"><a class="tab unselected" id="tab-issue-list" href="#issue-list"><span class="tab2"><?php echo $LNG->TAB_VIEW_LIST; ?> <span id="issue-list-count"></span></span></a></li>
								<li class="tab"><a class="tab unselected" id="tab-issue-overview" href="#issue-overview"><span class="tab2"><?php echo $LNG->TAB_VIEW_OVERVIEW; ?> </span></a></li>
								<!-- li class="tab"><a class="tab unselected" id="tab-issue-net" href="#issue-net"><span class="tab2"><?php echo $LNG->TAB_VIEW_THEME_MAP; ?> <span id="issue-net-count"></span></span></a></li -->
							</ul>
						</div>
						<div id="tab-content-issue" class="tabcontentouter">
          					<div id='tab-content-issue-list' class='tabcontentinner'></div>
            				<div id='tab-content-issue-overview' class='tabcontentinner'></div>
           					<!-- div id='tab-content-issue-net' class='tabcontentinner'></div -->
						</div>
					</div>
            	</div>
			</div>
			<?php } ?>


			<!-- SOLUTION TAB PAGE -->
			<?php if ($CFG->HAS_SOLUTION) { ?>

        	<div id='tab-content-solution-div' class='tabcontent solutionbackpale' style="display:none;padding:0px;">

	  			<div id="tab-content-solution-title" class="solutionback" style="height:10px;clear:both;float:left;width:100%;margin:0px;">
	  				<!-- div class="solutionback tabtitlebar" style="padding:4px;margin:0px;font-size:9pt"><?php echo $LNG->TAB_SOLUTION_STRAPLINE;?> <a href="javascript:void(0)" onMouseOver="showGlobalHint('SolutionsTab', event, 'hgrhint'); return false;" onMouseOut="hideHints(); return false;" onClick="hideHints(); return false;" onkeypress="enterKeyPressed(event)"><img style="vertical-align:bottom" src="<?php echo $HUB_FLM->getImagePath('info.png'); ?>" border="0" style="margin-left: 5px;" /></a></div -->
	  			</div>

				<!-- ?php drawNetworkNavigationBar('Solution'); ? -->

            	<div id='tab-content-solution-search' style='margin:5px;clear:both; float:left; padding-top: 1px; width: 100%;'>
					<div class="strapline">
					<a style="margin-right: 10px;" href="javascript:void(0)" onMouseOver="showGlobalHint('SolutionsTab', event, 'hgrhint'); return false;" onMouseOut="hideHints(); return false;" onClick="hideHints(); return false;" onkeypress="enterKeyPressed(event)"><img style="vertical-align:bottom" src="<?php echo $HUB_FLM->getImagePath('info.png'); ?>" border="0" /></a>
					<?php if(isset($USER->userid)){ ?>
						<?php echo $LNG->TAB_SOLUTION_MESSAGE_LOGGEDIN; ?>
					<?php } else {
						if ($CFG->signupstatus == $CFG->SIGNUP_OPEN) { ?>
							<?php echo $LNG->TAB_SOLUTION_MESSAGE_LOGGEDOUT_OPEN; ?>
						<?php } else if ($CFG->signupstatus == $CFG->SIGNUP_REQUEST) { ?>
							<?php echo $LNG->TAB_SOLUTION_MESSAGE_LOGGEDOUT_REQUEST; ?>
						<?php } else { ?>
							<?php echo $LNG->TAB_SOLUTION_MESSAGE_LOGGEDOUT_CLOSED; ?>
						<?php } ?>
					<?php } ?>
					</div>

					<?php if(isset($USER->userid)){ ?>
					<span class="toolbar" style="margin-top:0px;">
						<a style="font-size: 12pt" href="javascript:loadDialog('createsolution','<?php echo $CFG->homeAddress ?>ui/popups/solutionadd.php', 790,600);" title='<?php echo $LNG->TAB_ADD_SOLUTION_HINT; ?>'><img style="vertical-align:bottom" src="<?php echo $HUB_FLM->getImagePath('add.png'); ?>" border="0" style="margin:0px;margin-left: 5px;padding:0px" /> <?php echo $LNG->TAB_ADD_SOLUTION_LINK; ?></a>
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
							<?php if ($CFG->hasRss) { ?>
								<img src="<?php echo $HUB_FLM->getImagePath('feed-icon-20x20.png'); ?>" alt="<?php echo $LNG->TAB_RSS_ALT; ?>" title="<?php echo $LNG->TAB_RSS_SOLUTION_HINT; ?>" class="active" style="padding-top:0px;padding-left:10px;" border="0" onclick="javascript: getNodesFeed(SOLUTION_ARGS);" />
							<?php } ?>
							<img src="<?php echo $HUB_FLM->getImagePath('printer.png'); ?>" alt="<?php echo $LNG->TAB_PRINT_ALT; ?>" title="<?php echo $LNG->TAB_PRINT_HINT_SOLUTION; ?>" class="active" style="padding-top:0px;padding-left:10px;" border="0" onclick="javascript: printNodes(SOLUTION_ARGS, '<?php echo $LNG->TAB_PRINT_TITLE_SOLUTION; ?>');" />
						</div>
					 </div>
            	</div>

            	<div id='tab-content-toolbar-solution' style='clear:both; float:left; width: 100%; height: 100%'>
					<div id="tabber" style="width:100%">
						<div id="solutiontabs">
							<ul id="tabs" class="tab2">
								<li class="tab"><a class="tab unselected" id="tab-solution-list" href="#solution-list"><span class="tab2"><?php echo $LNG->TAB_VIEW_LIST; ?> <span id="solution-list-count"></span></span></a></li>
								<li class="tab"><a class="tab unselected" id="tab-solution-overview" href="#solution-overview"><span class="tab2"><?php echo $LNG->TAB_VIEW_OVERVIEW; ?> </span></a></li>
								<!-- li class="tab"><a class="tab unselected" id="tab-solution-net" href="#solution-net"><span class="tab2"><?php echo $LNG->TAB_VIEW_THEME_MAP; ?> <span id="solution-net-count"></span></span></a></li -->
							</ul>
						</div>
						<div id="tab-content-solution" class="tabcontentouter">
           					<div id='tab-content-solution-list' class='tabcontentinner'></div>
           					<div id='tab-content-solution-overview' class='tabcontentinner'></div>
           					<!-- div id='tab-content-solution-net' class='tabcontentinner'></div -->
						</div>
					</div>
            	</div>
			</div>
			<?php } ?>


			<!-- CLAIM TAB PAGE -->
			<?php if ($CFG->HAS_CLAIM) { ?>
            <div id='tab-content-claim-div' class='tabcontent claimbackpale' style="display:none;padding:0px;">

	  			<div id="tab-content-claim-title" class="claimback" style="height:10px;clear:both;float:left;width:100%;margin:0px;">
  				<!-- div class="claimback tabtitlebar" style="padding:4px;margin:0px;font-size:9pt"><?php echo $LNG->TAB_CLAIM_STRAPLINE; ?> <a href="javascript:void(0)" onMouseOver="showGlobalHint('ClaimsTab', event, 'hgrhint'); return false;" onMouseOut="hideHints(); return false;" onClick="hideHints(); return false;" onkeypress="enterKeyPressed(event)"><img style="vertical-align:bottom" src="<?php echo $HUB_FLM->getImagePath('info.png'); ?>" border="0" style="margin-left: 5px;" /></a></div -->
	  			</div>

				<!-- ?php drawNetworkNavigationBar('Claim'); ? -->

            	<div id='tab-content-claim-search' style='margin:5px; padding-top: 1px; clear:both; float:left;width: 100%;'>
					<div class="strapline">
					<a style="margin-right: 10px;" href="javascript:void(0)" onMouseOver="showGlobalHint('ClaimsTab', event, 'hgrhint'); return false;" onMouseOut="hideHints(); return false;" onClick="hideHints(); return false;" onkeypress="enterKeyPressed(event)"><img style="vertical-align:bottom" src="<?php echo $HUB_FLM->getImagePath('info.png'); ?>" border="0" /></a>

					<?php if(isset($USER->userid)){ ?>
						<?php echo $LNG->TAB_CLAIM_MESSAGE_LOGGEDIN; ?>
					<?php } else {
						if ($CFG->signupstatus == $CFG->SIGNUP_OPEN) { ?>
							<?php echo $LNG->TAB_CLAIM_MESSAGE_LOGGEDOUT_OPEN; ?>
						<?php } else if ($CFG->signupstatus == $CFG->SIGNUP_REQUEST) { ?>
							<?php echo $LNG->TAB_CLAIM_MESSAGE_LOGGEDOUT_REQUEST; ?>
						<?php } else { ?>
							<?php echo $LNG->TAB_CLAIM_MESSAGE_LOGGEDOUT_CLOSED; ?>
						<?php } ?>
					<?php } ?>
					</div>

					<?php if(isset($USER->userid)){ ?>
					<span class="toolbar" style="margin-top:0px;">
						<a style="font-size: 12pt" href="javascript:loadDialog('createclaim','<?php echo $CFG->homeAddress ?>ui/popups/claimadd.php', 790,600);" title='<?php echo $LNG->TAB_ADD_CLAIM_HINT; ?>'><img style="vertical-align:bottom" src="<?php echo $HUB_FLM->getImagePath('add.png'); ?>" border="0" style="margin:0px;margin-left: 5px;padding:0px" /> <?php echo $LNG->TAB_ADD_CLAIM_LINK; ?></a>
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
							<?php if ($CFG->hasRss) { ?>
								<img src="<?php echo $HUB_FLM->getImagePath('feed-icon-20x20.png'); ?>" alt="<?php echo $LNG->TAB_RSS_ALT; ?>" title="<?php echo $LNG->TAB_RSS_CLAIM_HINT; ?>" class="active" style="padding-top:0px;padding-left:10px;" border="0" onclick="javascript: getNodesFeed(CLAIM_ARGS);" />
							<?php } ?>
							<img src="<?php echo $HUB_FLM->getImagePath('printer.png'); ?>" alt="<?php echo $LNG->TAB_PRINT_ALT; ?>" title="<?php echo $LNG->TAB_PRINT_HINT_CLAIM; ?>" class="active" style="padding-top:0px;padding-left:10px;" border="0" onclick="javascript: printNodes(CLAIM_ARGS, '<?php echo $LNG->TAB_PRINT_TITLE_CLAIM; ?>');" />
						</div>
					</div>
            	</div>

            	<div id='tab-content-toolbar-claim' style='clear:both; float:left; width: 100%; height: 100%'>
					<div id="tabber" style="width:100%">
						<div id="claimtabs">
							<ul id="tabs" class="tab2">
								<li class="tab"><a class="tab unselected" id="tab-claim-list" href="#claim-list"><span class="tab2"><?php echo $LNG->TAB_VIEW_LIST; ?> <span id="claim-list-count"></span></span></a></li>
								<li class="tab"><a class="tab unselected" id="tab-claim-overview" href="#claim-overview"><span class="tab2"><?php echo $LNG->TAB_VIEW_OVERVIEW; ?> </span></a></li>
								<!-- li class="tab"><a class="tab unselected" id="tab-claim-net" href="#claim-net"><span class="tab2"><?php echo $LNG->TAB_VIEW_THEME_MAP; ?> <span id="claim-net-count"></span></span></a></li -->
							</ul>
						</div>
						<div id="tab-content-claim" class="tabcontentouter">
           					<div id='tab-content-claim-list' class='tabcontentinner'></div>
           					<div id='tab-content-claim-overview' class='tabcontentinner'></div>
           					<!-- div id='tab-content-claim-net' class='tabcontentinner'></div -->
						</div>
					</div>
            	</div>
			</div>
			<?php } ?>

			<!-- EVIDENCE TAB PAGE -->
            <div id='tab-content-evidence-div' class='tabcontent evidencebackpale' style="display:none;padding:0px;">

	  			<div id="tab-content-evidence-title" class="evidenceback" style="height:10px;clear:both;float:left;width:100%;margin:0px;">
	  				<!-- div class="evidenceback tabtitlebar" style="padding:4px;margin:0px;font-size:9pt"><?php echo $LNG->TAB_EVIDENCE_STRAPLINE; ?> <a href="javascript:void(0)" onMouseOver="showGlobalHint('EvidenceTab', event, 'hgrhint'); return false;" onMouseOut="hideHints(); return false;" onClick="hideHints(); return false;" onkeypress="enterKeyPressed(event)"><img style="vertical-align:bottom" src="<?php echo $HUB_FLM->getImagePath('info.png'); ?>" border="0" style="margin-left: 5px;" /></a></div -->
	  			</div>

				<!-- ?php drawNetworkNavigationBar('Evidence'); ? -->

  				<div id='tab-content-evidence-search' style='margin:5px;width:98%;padding-top: 1px; clear:both; float:left; width: 100%;'>
  					<div class="strapline">
  					<a style="margin-right: 10px;" href="javascript:void(0)" onMouseOver="showGlobalHint('EvidenceTab', event, 'hgrhint'); return false;" onMouseOut="hideHints(); return false;" onClick="hideHints(); return false;" onkeypress="enterKeyPressed(event)"><img style="vertical-align:bottom" src="<?php echo $HUB_FLM->getImagePath('info.png'); ?>" border="0" /></a>
					<?php if(isset($USER->userid)){ ?>
						<?php echo $LNG->TAB_EVIDENCE_MESSAGE_LOGGEDIN; ?>
					<?php } else {
						if ($CFG->signupstatus == $CFG->SIGNUP_OPEN) { ?>
							<?php echo $LNG->TAB_EVIDENCE_MESSAGE_LOGGEDOUT_OPEN; ?>
						<?php } else if ($CFG->signupstatus == $CFG->SIGNUP_REQUEST) { ?>
							<?php echo $LNG->TAB_EVIDENCE_MESSAGE_LOGGEDOUT_REQUEST; ?>
						<?php } else { ?>
							<?php echo $LNG->TAB_EVIDENCE_MESSAG_LOGGEDOUT_CLOSED; ?>
						<?php } ?>
					<?php } ?>
					</div>

					<?php if(isset($USER->userid)){ ?>
					<span class="toolbar" style="margin-top:0px;">
						<a style="font-size: 12pt" href="javascript:loadDialog('createevidence','<?php echo $CFG->homeAddress ?>ui/popups/evidenceadd.php', 790,670);" title='<?php echo $LNG->TAB_ADD_EVIDENCE_HINT; ?>'><img style="vertical-align:bottom" src="<?php echo $HUB_FLM->getImagePath('add.png'); ?>" border="0" style="margin:0px;margin-left: 5px;padding:0px" /> <?php echo $LNG->TAB_ADD_EVIDENCE_LINK; ?></a>
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
							<?php if ($CFG->hasRss) { ?>
								<img src="<?php echo $HUB_FLM->getImagePath('feed-icon-20x20.png'); ?>" alt="<?php echo $LNG->TAB_RSS_ALT; ?>" title="<?php echo $LNG->TAB_RSS_EVIDENCE_HINT; ?>" class="active" style="padding-top:0px;padding-left:10px;" border="0" onclick="javascript: getNodesFeed(EVIDENCE_ARGS);" />
							<?php } ?>
							<img src="<?php echo $HUB_FLM->getImagePath('printer.png'); ?>" alt="<?php echo $LNG->TAB_PRINT_ALT; ?>" title="<?php echo $LNG->TAB_PRINT_HINT_EVIDENCE; ?>" class="active" style="padding-top:0px;padding-left:10px;" border="0" onclick="javascript: printNodes(EVIDENCE_ARGS, '<?php echo $LNG->TAB_PRINT_TITLE_EVIDENCE; ?>');" />
						</div>
					</div>
            	</div>

            	<div id='tab-content-toolbar-evidence' style='clear:both; float:left; width: 100%; height: 100%'>
					<div id="tabber" style="width:100%">
						<div id="evidencetabs">
							<ul id="tabs" class="tab2">
								<li class="tab"><a class="tab unselected" id="tab-evidence-list" href="#evidence-list"><span class="tab2"><?php echo $LNG->TAB_VIEW_LIST; ?> <span id="evidence-list-count"></span></span></a></li>
								<li class="tab"><a class="tab unselected" id="tab-evidence-overview" href="#evidence-overview"><span class="tab2"><?php echo $LNG->TAB_VIEW_OVERVIEW; ?> </span></a></li>
								<!-- li class="tab"><a class="tab unselected" id="tab-evidence-net" href="#evidence-net"><span class="tab2"><?php echo $LNG->TAB_VIEW_THEME_MAP; ?> <span id="evidence-net-count"></span></span></a></li -->
							</ul>
						</div>
						<div id="tab-content-evidence" class="tabcontentouter">
           					<div id='tab-content-evidence-list' class='tabcontentinner'></div>
           					<div id='tab-content-evidence-overview' class='tabcontentinner'></div>
           					<!-- div id='tab-content-evidence-net' class='tabcontentinner'></div -->
						</div>
					</div>
            	</div>
			</div>

			<!-- RESOURCE TAB PAGE -->
            <div id='tab-content-web-div' class='tabcontent resourcebackpale' style="display:none;padding:0px;">

	  			<div id="tab-content-web-title" class="resourceback" style="height:10px;clear:both;float:left;width:100%;margin:0px;">
	  				<!-- div class="resourceback tabtitlebar" style="padding:4px;margin:0px;font-size:9pt"><?php echo $LNG->TAB_RESOURCE_STRAPLINE; ?> <a href="javascript:void(0)" onMouseOver="showGlobalHint('ResourcesTab', event, 'hgrhint'); return false;" onMouseOut="hideHints(); return false;" onClick="hideHints(); return false;" onkeypress="enterKeyPressed(event)"><img style="vertical-align:bottom" src="<?php echo $HUB_FLM->getImagePath('info.png'); ?>" border="0" style="margin-left: 5px;" /></a></div -->
	  			</div>

				<!-- ?php drawNetworkNavigationBar('Resource'); ? -->

            	<div id='tab-content-web-search' style='margin:5px; padding-top: 1px; clear:both; float:left;width: 100%;'>
					<div class="strapline">
					<a style="margin-right: 10px;" href="javascript:void(0)" onMouseOver="showGlobalHint('ResourcesTab', event, 'hgrhint'); return false;" onMouseOut="hideHints(); return false;" onClick="hideHints(); return false;" onkeypress="enterKeyPressed(event)"><img style="vertical-align:bottom" src="<?php echo $HUB_FLM->getImagePath('info.png'); ?>" border="0" /></a>
					<?php if(isset($USER->userid)){ ?>
						<?php echo $LNG->TAB_RESOURCE_MESSAGE_LOGGEDIN; ?>
					<?php } else {
						if ($CFG->signupstatus == $CFG->SIGNUP_OPEN) { ?>
							<?php echo $LNG->TAB_RESOURCE_MESSAGE_LOGGEDOUT_OPEN; ?>
						<?php } else if ($CFG->signupstatus == $CFG->SIGNUP_REQUEST) { ?>
							<?php echo $LNG->TAB_RESOURCE_MESSAGE_LOGGEDOUT_REQUEST; ?>
						<?php } else { ?>
							<?php echo $LNG->TAB_RESOURCE_MESSAGE_LOGGEDOUT_CLOSED; ?>
						<?php } ?>
					<?php } ?>
					</div>

					<?php if(isset($USER->userid)){ ?>
					<span class="toolbar" style="margin-top:0px;">
						<a style="font-size: 12pt" href="javascript:loadDialog('createresource','<?php echo $CFG->homeAddress ?>ui/popups/resourceadd.php', 790,600);" title='<?php echo $LNG->TAB_ADD_RESOURCE_HINT; ?>'><img style="vertical-align:bottom" src="<?php echo $HUB_FLM->getImagePath('add.png'); ?>" border="0" style="margin:0px;margin-left: 5px;padding:0px" /> <?php echo $LNG->TAB_ADD_RESOURCE_LINK; ?></a>
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
							<img id="web-go-button" src="<?php echo $HUB_FLM->getImagePath('search.png'); ?>" class="active" width="20" height="20" onclick="javascript: filterSearchWebsites();" title="<?php echo $LNG->TAB_SEARCH_GO_BUTTON; ?>" alt="<?php echo $LNG->TAB_SEARCH_GO_BUTTON; ?>" />
						</div>
						<div style="float:left;margin-left: 10px;">
							<img src="<?php echo $HUB_FLM->getImagePath('search-clear.png'); ?>" class="active" width="20" height="20" onclick="javascript: URL_ARGS['q'] = ''; URL_ARGS['scope'] = 'all';$('qweb').value='';if ($('scopeweball'))  $('scopeweball').checked=true; refreshWebsites();" title="<?php echo $LNG->TAB_SEARCH_CLEAR_SEARCH_BUTTON; ?>" alt="<?php echo $LNG->TAB_SEARCH_CLEAR_SEARCH_BUTTON; ?>" />
						</div>
						<div style="float:left;margin-left: 10px;" id="webbuttons">
							<?php if ($CFG->hasRss) { ?>
								<img src="<?php echo $HUB_FLM->getImagePath('feed-icon-20x20.png'); ?>" alt="<?php echo $LNG->TAB_RSS_ALT; ?>" title="<?php echo $LNG->TAB_RSS_RESOURCE_HINT; ?>" class="active" style="padding-top:0px;padding-left:10px;" border="0" onclick="javascript: getNodesFeed(URL_ARGS);" />
							<?php } ?>
							<img src="<?php echo $HUB_FLM->getImagePath('printer.png'); ?>" alt="<?php echo $LNG->TAB_PRINT_ALT; ?>" title="<?php echo $LNG->TAB_PRINT_HINT_RESOURCE; ?>" class="active" style="padding-top:0px;padding-left:10px;" border="0" onclick="javascript: printNodes(URL_ARGS, '<?php echo $LNG->TAB_PRINT_TITLE_RESOURCE; ?>');" />
						</div>
					</div>
            	</div>

            	<div id='tab-content-toolbar-web' style='clear:both; float:left; width: 100%; height: 100%'>
					<div id="tabber" style="width:100%">
						<ul id="webtabs" class="tab2">
							<li class="tab"><a class="tab unselected" id="tab-web-list" href="#web-list"><span class="tab2"><?php echo $LNG->TAB_VIEW_LIST; ?> <span id="web-list-count"></span></span></a></li>
							<li class="tab"><a class="tab unselected" id="tab-web-overview" href="#web-overview"><span class="tab2"><?php echo $LNG->TAB_VIEW_OVERVIEW; ?> </span></a></li>
							<!-- li class="tab"><a class="tab unselected" id="tab-web-net" href="#web-net"><span class="tab2"><?php echo $LNG->TAB_VIEW_THEME_MAP; ?> <span id="web-net-count"></span></span></a></li -->
						</ul>
						<div id="tab-content-web" class="tabcontentouter">
           					<div id='tab-content-web-list' class='tabcontentinner'></div>
           					<div id='tab-content-web-overview' class='tabcontentinner'></div>
           					<!-- div id='tab-content-web-net' class='tabcontentinner'></div -->
						</div>
					</div>
            	</div>
			</div>

			<!-- ORG TAB PAGE -->
            <div id='tab-content-org-div' class='tabcontent orgbackpale' style="display:none;padding:0px">

	  			<div id="tab-content-org-title" class="orgback" style="height:10px;clear:both;float:left;width:100%;margin:0px;">
	  				<!-- div class="orgback tabtitlebar" style="padding:4px;margin:0px;font-size:9pt"><?php echo $LNG->TAB_ORG_STRAPLINE; ?> <a href="javascript:void(0)" onMouseOver="showGlobalHint('OrganizationsTab', event, 'hgrhint'); return false;" onMouseOut="hideHints(); return false;" onClick="hideHints(); return false;" onkeypress="enterKeyPressed(event)"><img style="vertical-align:bottom" src="<?php echo $HUB_FLM->getImagePath('info.png'); ?>" border="0" style="margin-left: 5px;" /></a></div -->
	  			</div>
				<!-- ?php drawNetworkNavigationBarOrg('Org'); ? -->

            	<div id='tab-content-org-search' style='margin:5px; padding-top:1px;clear:both; float:left; width: 100%;'>
					<div class="strapline">
					<a style="margin-right: 10px;" href="javascript:void(0)" onMouseOver="showGlobalHint('OrganizationsTab', event, 'hgrhint'); return false;" onMouseOut="hideHints(); return false;" onClick="hideHints(); return false;" onkeypress="enterKeyPressed(event)"><img style="vertical-align:bottom" src="<?php echo $HUB_FLM->getImagePath('info.png'); ?>" border="0" /></a>
					<?php if(isset($USER->userid)){ ?>
						<?php echo $LNG->TAB_ORG_MESSAGE_LOGGEDIN; ?>
					<?php } else {
						if ($CFG->signupstatus == $CFG->SIGNUP_OPEN) { ?>
							<?php echo $LNG->TAB_ORG_MESSAGE_LOGGEDOUT_OPEN; ?>
						<?php } else if ($CFG->signupstatus == $CFG->SIGNUP_REQUEST) { ?>
							<?php echo $LNG->TAB_ORG_MESSAGE_LOGGEDOUT_REQUEST; ?>
						<?php } else { ?>
							<?php echo $LNG->TAB_ORG_MESSAGE_LOGGEDOUT_CLOSED; ?>
						<?php } ?>
					<?php } ?>
					</div>

					<?php if(isset($USER->userid)){ ?>
					<span class="toolbar" style="margin-top:0px;">
						<a style="font-size: 12pt" href="javascript:loadDialog('createorg','<?php echo $CFG->homeAddress; ?>ui/popups/organizationadd.php?type=Organization', 790,600);" title='<?php echo $LNG->TAB_ADD_ORG_HINT; ?>'><img style="vertical-align:bottom" src="<?php echo $HUB_FLM->getImagePath('add.png'); ?>" border="0" style="margin:0px;margin-left: 5px;padding:0px" /> <?php echo $LNG->TAB_ADD_ORG_LINK; ?></a>
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
						<?php if ($CFG->hasRss) { ?>
							<img src="<?php echo $HUB_FLM->getImagePath('feed-icon-20x20.png'); ?>" alt="<?php echo $LNG->TAB_RSS_ALT; ?>" title="<?php echo $LNG->TAB_RSS_ORG_HINT; ?>" class="active" style="padding-top:0px;padding-left:10px;" border="0" onclick="javascript: getNodesFeed(ORG_ARGS);" />
						<?php } ?>
						<img src="<?php echo $HUB_FLM->getImagePath('printer.png'); ?>" alt="<?php echo $LNG->TAB_PRINT_ALT; ?>" title="<?php echo $LNG->TAB_PRINT_HINT_ORG; ?>" class="active" style="padding-top:0px;padding-left:10px;" border="0" onclick="javascript: printNodes(ORG_ARGS, '<?php echo $LNG->TAB_PRINT_TITLE_ORG; ?>');" />
					</div>
				</div>
         		</div>

            	<div id='tab-content-toolbar-org' style='clear:both; float:left; width: 100%; height: 100%'>
					<div id="tabber" style="width:100%">
						<div id="orgtabs">
							<ul id="tabs" class="tab2">
								<li class="tab"><a class="tab unselected" id="tab-org-list" href="#org-list"><span class="tab2"><?php echo $LNG->TAB_VIEW_LIST; ?> <span id="org-list-count"></span></span></a></li>
								<li class="tab"><a class="tab unselected" id="tab-org-overview" href="#org-overview"><span class="tab2"><?php echo $LNG->TAB_VIEW_OVERVIEW; ?> </span></a></li>
								<!-- li class="tab"><a class="tab unselected" id="tab-org-net" href="#org-net"><span class="tab2"><?php echo $LNG->TAB_VIEW_THEME_MAP; ?> <span id="org-net-count"></span></span></a></li -->
								<li class="tab"><a class="tab unselected" id="tab-org-gmap" href="#org-gmap"><span class="tab2"><?php echo $LNG->TAB_VIEW_GEOMAP; ?> <span id="org-gmap-count"></span></span></a></li>
							</ul>
						</div>
						<div id="tab-content-org" class="tabcontentouter">
           					<div id='tab-content-org-list' class='tabcontentinner'></div>
           					<div id='tab-content-org-overview' class='tabcontentinner'></div>
           					<!-- div id='tab-content-org-net' class='tabcontentinner'></div -->
           					<div id='tab-content-org-gmap' class='tabcontentinner'></div>
						</div>
					</div>
            	</div>
            </div>

			<!-- PROJECT TAB PAGE -->
            <div id='tab-content-project-div' class='tabcontent projectbackpale' style="display:none;padding:0px">

	  			<div id="tab-content-project-title" class="projectback" style="height:10px;clear:both;float:left;width:100%;margin:0px;">
	  				<!-- div class="projectback tabtitlebar" style="padding:4px;margin:0px;font-size:9pt"><?php echo $LNG->TAB_PROJECT_STRAPLINE; ?> <a href="javascript:void(0)" onMouseOver="showGlobalHint('ProjectsTab', event, 'hgrhint'); return false;" onMouseOut="hideHints(); return false;" onClick="hideHints(); return false;" onkeypress="enterKeyPressed(event)"><img style="vertical-align:bottom" src="<?php echo $HUB_FLM->getImagePath('info.png'); ?>" border="0" style="margin-left: 5px;" /></a></div -->
	  			</div>

            	<div id='tab-content-project-search' style='margin:5px; padding-top:1px;clear:both; float:left; width: 100%;'>
					<div class="strapline">
					<a style="margin-right: 10px;" href="javascript:void(0)" onMouseOver="showGlobalHint('ProjectsTab', event, 'hgrhint'); return false;" onMouseOut="hideHints(); return false;" onClick="hideHints(); return false;" onkeypress="enterKeyPressed(event)"><img style="vertical-align:bottom" src="<?php echo $HUB_FLM->getImagePath('info.png'); ?>" border="0" /></a>
					<?php if(isset($USER->userid)){ ?>
						<?php echo $LNG->TAB_PROJECT_MESSAGE_LOGGEDIN; ?>
					<?php } else {
						if ($CFG->signupstatus == $CFG->SIGNUP_OPEN) { ?>
							<?php echo $LNG->TAB_PROJECT_MESSAGE_LOGGEDOUT_OPEN; ?>
						<?php } else if ($CFG->signupstatus == $CFG->SIGNUP_REQUEST) { ?>
							<?php echo $LNG->TAB_PROJECT_MESSAGE_LOGGEDOUT_REQUEST; ?>
						<?php } else { ?>
							<?php echo $LNG->TAB_PROJECT_MESSAGE_LOGGEDOUT_CLOSED; ?>
						<?php } ?>
					<?php } ?>
					</div>

					<?php if(isset($USER->userid)){ ?>
					<span class="toolbar" style="margin-top:0px;">
						<a style="font-size: 12pt" href="javascript:loadDialog('createproject','<?php echo $CFG->homeAddress; ?>ui/popups/organizationadd.php?type=Project', 790,600);" title='<?php echo $LNG->TAB_ADD_PROJECT_HINT; ?>'><img style="vertical-align:bottom" src="<?php echo $HUB_FLM->getImagePath('add.png'); ?>" border="0" style="margin:0px;margin-left: 5px;padding:0px" /> <?php echo $LNG->TAB_ADD_PROJECT_LINK; ?></a>
					</span>
					<?php } ?>

					<div id="searchproject" style="float:left;margin-left: 10px;">
						<label for="q" style="float: left; margin-right: 3px; margin-top: 3px;"><?php echo $LNG->TAB_SEARCH_PROJECT_LABEL; ?></label>
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
						<div style="float:left;margin-left: 10px;" id="orgbuttons">
							<?php if ($CFG->hasRss) { ?>
								<img src="<?php echo $HUB_FLM->getImagePath('feed-icon-20x20.png'); ?>" alt="<?php echo $LNG->TAB_RSS_ALT; ?>" title="<?php echo $LNG->TAB_RSS_PROJECT_HINT; ?>" class="active" style="padding-top:0px;padding-left:10px;" border="0" onclick="javascript: getNodesFeed(PROJECT_ARGS);" />
							<?php } ?>
							<img src="<?php echo $HUB_FLM->getImagePath('printer.png'); ?>" alt="<?php echo $LNG->TAB_PRINT_ALT; ?>" title="<?php echo $LNG->TAB_PRINT_HINT_PROJECT; ?>" class="active" style="padding-top:0px;padding-left:10px;" border="0" onclick="javascript: printNodes(PROJECT_ARGS, '<?php echo $LNG->TAB_PRINT_TITLE_PROJECT; ?>');" />
						</div>
					</div>
         		</div>

            	<div id='tab-content-toolbar-project' style='clear:both; float:left; width: 100%; height: 100%'>
					<div id="tabber" style="width:100%">
						<div id="projecttabs">
							<ul id="tabs" class="tab2">
								<li class="tab"><a class="tab unselected" id="tab-project-list" href="#project-list"><span class="tab2"><?php echo $LNG->TAB_VIEW_LIST; ?> <span id="project-list-count"></span></span></a></li>
								<li class="tab"><a class="tab unselected" id="tab-project-overview" href="#project-overview"><span class="tab2"><?php echo $LNG->TAB_VIEW_OVERVIEW; ?> </span></a></li>
								<!-- li class="tab"><a class="tab unselected" id="tab-project-net" href="#project-net"><span class="tab2"><?php echo $LNG->TAB_VIEW_THEME_MAP; ?> <span id="project-net-count"></span></span></a></li -->
								<li class="tab"><a class="tab unselected" id="tab-project-gmap" href="#project-gmap"><span class="tab2"><?php echo $LNG->TAB_VIEW_GEOMAP; ?> <span id="project-gmap-count"></span></span></a></li>
							</ul>
						</div>
						<div id="tab-content-project" class="tabcontentouter">
           					<div id='tab-content-project-list' class='tabcontentinner'></div>
           					<div id='tab-content-project-overview' class='tabcontentinner'></div>
           					<!-- div id='tab-content-project-net' class='tabcontentinner'></div -->
           					<div id='tab-content-project-gmap' class='tabcontentinner'></div>
						</div>
					</div>
            	</div>
            </div>

			<!-- USER TAB PAGE -->
            <div id='tab-content-user-div' class='tabcontent peoplebackpale' style="display:none;padding:0px;">

	  			<div id="tab-content-user-title" class="peopleback" style="height:10px;clear:both;float:left;width:100%;margin:0px;">
	  				<!-- div class="peopleback tabtitlebar" style="padding:4px;margin:0px;font-size:9pt"><?php echo $LNG->TAB_USER_STRAPLINE; ?> <a href="javascript:void(0)" onMouseOver="showGlobalHint('PeopleTab', event, 'hgrhint'); return false;" onMouseOut="hideHints(); return false;" onClick="hideHints(); return false;" onkeypress="enterKeyPressed(event)"><img style="vertical-align:bottom" src="<?php echo $HUB_FLM->getImagePath('info.png'); ?>" border="0" style="margin-left: 5px;" /></a></div -->
	  			</div>

            	<div id='tab-content-user-search' style='margin:5px; margin-bottom:10px;padding-top: 1px;clear:both; float:left; width: 100%;'>
	  				<div class="strapline">
	  				<a style="margin-right: 10px;" href="javascript:void(0)" onMouseOver="showGlobalHint('PeopleTab', event, 'hgrhint'); return false;" onMouseOut="hideHints(); return false;" onClick="hideHints(); return false;" onkeypress="enterKeyPressed(event)"><img style="vertical-align:bottom" src="<?php echo $HUB_FLM->getImagePath('info.png'); ?>" border="0" /></a>
	  				<?php echo $LNG->TAB_USER_MESSAGE; ?>
	  				</div>

					<div id="searchuser" style="float:left;margin-left:10px;">

						<label for="q" style="float: left; margin-right: 3px; margin-top: 3px;"><?php echo $LNG->TAB_SEARCH_USER_LABEL; ?></label>

						<?php
							// if search term is present in URL then show in search box
							$q = stripslashes(optional_param("q","",PARAM_TEXT));
							$scope = optional_param("scope","all",PARAM_TEXT);
							$tagsonly = optional_param("tagsonly","false",PARAM_TEXT);
						?>

						<div style="float: left;">
							<input type="text" style="margin-right:3px; width:250px" onkeyup="if (checkKeyPressed(event)) { $('user-go-button').onclick();}" id="quser" name="q" value="<?php print( htmlspecialchars($q) ); ?>"/>
							<div style="clear: both;">
							</div>
							<div id="q_choices" class="autocomplete" style="border-color: white;"></div>
						</div>
						<div style="float:left;">
							<img id="user-go-button" src="<?php echo $HUB_FLM->getImagePath('search.png'); ?>" class="active" width="20" height="20" onclick="javascript: filterSearchUsers();" title="<?php echo $LNG->TAB_SEARCH_GO_BUTTON; ?>" alt="<?php echo $LNG->TAB_SEARCH_GO_BUTTON; ?>" />
						</div>
						<div style="float:left;margin-left: 10px;">
							<img src="<?php echo $HUB_FLM->getImagePath('search-clear.png'); ?>" class="active" width="20" height="20" onclick="javascript: USER_ARGS['q'] = ''; USER_ARGS['scope'] = 'all';$('quser').value=''; refreshUsers();" title="<?php echo $LNG->TAB_SEARCH_CLEAR_SEARCH_BUTTON; ?>" alt="<?php echo $LNG->TAB_SEARCH_CLEAR_SEARCH_BUTTON; ?>" />
						</div>
					 </div>
            	</div>

            	<div id='tab-content-toolbar-user' style='clear:both; float:left; width: 100%; height: 100%'>
					<div id="tabber" style="width:100%">
						<ul id="usertabs" class="tab2">
							<li class="tab"><a class="tab unselected" id="tab-user-list" href="#user-list"><span class="tab2"><?php echo $LNG->TAB_VIEW_LIST; ?> <span id="user-list-count"></span></span></a></li>
							<li class="tab"><a class="tab unselected" id="tab-user-overview" href="#user-overview"><span class="tab2"><?php echo $LNG->TAB_VIEW_OVERVIEW; ?> </span></a></li>
							<li class="tab"><a class="tab unselected" id="tab-user-net" href="<?php echo $CFG->homeAddress; ?>#user-net"><span class="tab2"><?php echo $LNG->TAB_VIEW_SOCIALMAP; ?> <span id="user-net-count"></span></span></a></li>
							<li class="tab"><a class="tab unselected" id="tab-user-usergmap" href="#user-usergmap"><span class="tab2"><?php echo $LNG->TAB_VIEW_GEOMAP_USER; ?> <span id="user-gmap-count"></span></span></a></li>
							<li class="tab"><a class="tab unselected" id="tab-user-nodegmap" href="#user-nodegmap"><span class="tab2"><?php echo $LNG->TAB_VIEW_GEOMAP_USERNODE; ?> <span id="user-nodegmap-count"></span></span></a></li>
						</ul>
						<div id="tab-content-user" class="tabcontentouter">
           					<div id='tab-content-user-list' class='tabcontentinner'></div>
           					<div id='tab-content-user-overview' class='tabcontentinner'></div>
           					<div id='tab-content-user-net' class='tabcontentinner'></div>
           					<div id='tab-content-user-usergmap' class='tabcontentinner'></div>
           					<div id='tab-content-user-nodegmap' class='tabcontentinner'></div>
						</div>
					</div>
            	</div>
            </div>

			<!-- COMMENT TAB PAGE -->
			<?php if ($CFG->HAS_OPEN_COMMENTS) { ?>
            <div id='tab-content-comment-div' class='tabcontent peoplebackpale' style="display:none;padding:0px;">

	  			<div id="tab-content-comment-title" class="peopleback" style="height:10px;clear:both;float:left;width:100%;margin:0px;">
					<?php if ($context == $CFG->USER_CONTEXT) { ?>
					<!-- div style="padding:4px;margin:0px;"><?php echo $LNG->TAB_COMMENT_USER_STRAPLINE; ?></div -->
					 <?php } else { ?>
						<!-- div style="padding:4px;margin:0px;"><?php echo $LNG->TAB_COMMENT_STRAPLINE; ?></div -->
					 <?php } ?>
	  			</div>

            	<div id='tab-content-search-comment' style='margin:5px; margin-bottom:10px;padding-top: 1px;clear:both; float:left; width: 100%;'>
	  				<div class="strapline">
					<?php if(isset($USER->userid)){ ?>
						<?php echo $LNG->TAB_COMMENT_MESSAGE_LOGGEDIN; ?>
					<?php } else {
						if ($CFG->signupstatus == $CFG->SIGNUP_OPEN) { ?>
							<?php echo $LNG->TAB_COMMENT_MESSAGE_LOGGEDOUT_OPEN; ?>
						<?php } else if ($CFG->signupstatus == $CFG->SIGNUP_REQUEST) { ?>
							<?php echo $LNG->TAB_COMMENT_MESSAGE_LOGGEDOUT_REQUEST; ?>
						<?php } else { ?>
							<?php echo $LNG->TAB_COMMENT_MESSAGE_LOGGEDOUT_CLOSED; ?>
						<?php } ?>
					<?php } ?>
	  				</div>

					<?php if(isset($USER->userid)){ ?>
					<span class="toolbar" style="margin-top:0px;">
						<a style="font-size: 12pt" href="javascript:loadDialog('createcomment','<?php echo $CFG->homeAddress; ?>ui/popups/commentadd.php', 790,500);" title='<?php echo $LNG->TAB_ADD_COMMENT_HINT; ?>'><img style="vertical-align:bottom" src="<?php echo $HUB_FLM->getImagePath('add.png'); ?>" border="0" style="margin:0px;margin-left: 5px;padding:0px" /> <?php echo $LNG->TAB_ADD_COMMENT_LINK; ?></a>
					</span>
					<?php } ?>

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
							<img src="<?php echo $HUB_FLM->getImagePath('search-clear.png'); ?>" class="active" width="20" height="20" onclick="javascript: COMMENT_ARGS['q'] = ''; COMMENT_ARGS['scope'] = 'all';$('qcomment').value=''; refreshComments();" title="<?php echo $LNG->TAB_SEARCH_CLEAR_SEARCH_BUTTON; ?>" alt="<?php echo $LNG->TAB_SEARCH_CLEAR_SEARCH_BUTTON; ?>" />
						</div>
					 </div>
					<div style="float:left;margin-left: 10px;" id="orgbuttons">
						<?php if ($CFG->hasRss) { ?>
							<img src="<?php echo $HUB_FLM->getImagePath('feed-icon-20x20.png'); ?>" alt="<?php echo $LNG->TAB_RSS_ALT; ?>" title="<?php echo $LNG->TAB_RSS_COMMENT_HINT; ?>" class="active" style="padding-top:0px;padding-left:10px;" border="0" onclick="javascript: getCommentNodesFeed(COMMENT_ARGS);" />
						<?php } ?>
						<img src="<?php echo $HUB_FLM->getImagePath('printer.png'); ?>" alt="<?php echo $LNG->TAB_PRINT_ALT; ?>" title="<?php echo $LNG->TAB_PRINT_HINT_COMMENT; ?>" class="active" style="padding-top:0px;padding-left:10px;" border="0" onclick="javascript: printCommentNodes(COMMENT_ARGS, '<?php echo $LNG->TAB_PRINT_TITLE_COMMENT; ?>');" />
					</div>
            	</div>

            	<div id='tab-content-toolbar-comment' style='clear:both; float:left; width: 100%; height: 100%'>
					<div id="tabber" style="width:100%">
						<ul id="tabs" class="tab2">
							<li class="tab"><a class="tab unselected" id="tab-comment-list" href="#comment-list"><span class="tab2"><?php echo $LNG->TAB_VIEW_LIST; ?> <span id="comment-list-count"></span></span></a></li>
						</ul>
						<div id="tab-content-comment" class="tabcontentouter">
           					<div id='tab-content-comment-list' class='tabcontentinner'></div>
						</div>
					</div>
            	</div>
            </div>
			<?php } ?>

			<!-- NEWS TAB PAGE -->
            <div id='tab-content-news-div' class='tabcontent peoplebackpale' style="display:none;padding:0px;">
	  			<div class="peopleback" style="height:10px;clear:both;width:100%;margin:0px;">
	  			&nbsp;
	  			<div>

	           	<div id='tab-content-news-search' style='margin:5px; margin-bottom:10px;padding-top: 1px;clear:both; float:left; width: 100%;'>
					<div id="searchnews" style="float:left;margin-left:10px;">
						<label for="q" style="float: left; margin-right: 3px; margin-top: 3px;"><?php echo $LNG->TAB_SEARCH_USER_LABEL; ?></label>
						<?php
							// if search term is present in URL then show in search box
							$q = stripslashes(optional_param("q","",PARAM_TEXT));
							$scope = optional_param("scope","all",PARAM_TEXT);
							$tagsonly = optional_param("tagsonly","false",PARAM_TEXT);
						?>
						<div style="float: left;">
							<input type="text" style="margin-right:3px; width:250px" onkeyup="if (checkKeyPressed(event)) { $('news-go-button').onclick();}" id="qnews" name="q" value="<?php print( htmlspecialchars($q) ); ?>"/>
							<div style="clear: both;">
							</div>
							<div id="q_choices" class="autocomplete" style="border-color: white;"></div>
						</div>
						<div style="float:left;">
							<img id="news-go-button" src="<?php echo $HUB_FLM->getImagePath('search.png'); ?>" class="active" width="20" height="20" onclick="javascript: filterSearchNews();" title="<?php echo $LNG->TAB_SEARCH_GO_BUTTON; ?>" alt="<?php echo $LNG->TAB_SEARCH_GO_BUTTON; ?>" />
						</div>
						<div style="float:left;margin-left: 10px;">
							<img src="<?php echo $HUB_FLM->getImagePath('search-clear.png'); ?>" class="active" width="20" height="20" onclick="javascript: NEWS_ARGS['q'] = ''; NEWS_ARGS['scope'] = 'all';$('qnews').value=''; refreshNews();" title="<?php echo $LNG->TAB_SEARCH_CLEAR_SEARCH_BUTTON; ?>" alt="<?php echo $LNG->TAB_SEARCH_CLEAR_SEARCH_BUTTON; ?>" />
						</div>
					 </div>
            	</div>

            	<div id='tab-content-toolbar-news' style='clear:both; float:left; width: 100%; height: 100%'>
					<div id="tabber" style="width:100%">
						<ul id="tabs" class="tab2">
							<li class="tab"><a class="tab unselected" id="tab-news-list" href="#comment-list"><span class="tab2"><?php echo $LNG->TAB_VIEW_LIST; ?> <span id="news-list-count"></span></span></a></li>
						</ul>
						<div id="tab-content-news" class="tabcontentouter">
           					<div id='tab-content-news-list' class='tabcontentinner'></div>
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
