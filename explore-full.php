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
    include_once("config.php");

    $me = substr($_SERVER["PHP_SELF"], 1); // remove initial '/'
    if ($HUB_FLM->hasCustomVersion($me)) {
    	$path = $HUB_FLM->getCodeDirPath($me);
    	include_once($path);
		die;
	}

    include_once($HUB_FLM->getCodeDirPath("core/utillib.php"));

    array_push($HEADER,'<script src="'.$HUB_FLM->getCodeWebPath('ui/exploretabs.js.php').'" type="text/javascript"></script>');
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

	// default parameters
    $start = optional_param("start",0,PARAM_INT);
    $max = optional_param("max",20,PARAM_INT);
    $orderby = optional_param("orderby","date",PARAM_ALPHA);
    $sort = optional_param("sort","DESC",PARAM_ALPHA);

	// filter parameters
    $direction = optional_param("direction","right",PARAM_ALPHA);
    $filtergroup = optional_param("filtergroup","",PARAM_TEXT);
    $filterlist = optional_param("filterlist","",PARAM_TEXT);
    $filternodetypes = optional_param("filternodetypes","",PARAM_TEXT);

	// if coming from a search
    $query = stripslashes(optional_param("q","",PARAM_TEXT));
	$scope = optional_param("scope","all",PARAM_TEXT);
	$tagsonly = optional_param("tagsonly","false",PARAM_TEXT);

	// network search parameters
    $netnodeid = optional_param("netnodeid","",PARAM_TEXT);
    $netq = optional_param("netq","",PARAM_TEXT);
    $netscope = optional_param("netscope","",PARAM_TEXT);
    $netlinkgroup = optional_param("netlinkgroup","",PARAM_TEXT);
    $netdepth = optional_param("netdepth",1,PARAM_INT);
    $netdirection = optional_param("netdirection",'both',PARAM_TEXT);
    $netlabelmatch = optional_param("netlabelmatch",'false',PARAM_TEXT);

    $agentlastrun = optional_param("agentlastrun",'',PARAM_TEXT);

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

    $args["start"] = $start;
    $args["max"] = $max;
    $args["orderby"] = $orderby;
    $args["sort"] = $sort;

    $args["direction"] = $direction;
    $args["filtergroup"] = $filtergroup;
    $args["filterlist"] = $filterlist;
    $args["filternodetypes"] = $filternodetypes;

    $args["q"] = $query;
    $args["scope"] = $scope;

    $args["netnodeid"] = $netnodeid;
    $args["netq"] = $netq;
    $args["netscope"] = $netscope;
    $args["netlinkgroup"] = $netlinkgroup;
    $args["netdepth"] = $netdepth;
    $args["netdirection"] = $netdirection;
    $args["netlabelmatch"] = $netlabelmatch;

    $args["agentlastrun"] = $agentlastrun;

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

<?php if ($nodetype == 'Challenge') { ?>
	<!--div id="nodearealineartitle" class="challengeback challengeborder curvedBorder" style="color:white;clear:both; float:left;width:100%;margin:0px;padding:0px;">
		<div class="challengeback tabtitlebar" style="padding:10px;margin:0px;font-size:9pt">
			<label class="linearnodeheaderlabel", id="exploreheaderlabel">
				<a style="float:left;margin-right:5px;margin-top:3px;" href="<?php echo $CFG->homeAddress; ?>index.php?#challenge-list"><img src="<?php echo $HUB_FLM->getImagePath('listhome.png'); ?>" border="0" class="active" style="margin-right: 5px;" title="<?php echo $LNG->CHALLENGE_HOME_LIST_BUTTON_HINT; ?>" /></a>
			</label>
		</div>
	</div -->
<?php } else if ($nodetype == 'Issue') { ?>
	<!--div id="nodearealineartitle" class="issueback issueborder curvedBorder" style="color:white;clear:both; float:left;width:100%;margin:0px;padding:0px;">
		<div class="issueback tabtitlebar" style="padding:10px;margin:0px;font-size:9pt">
			<label class="linearnodeheaderlabel", id="exploreheaderlabel">
				<a style="float:left;margin-right:5px;margin-top:3px;" href="<?php echo $CFG->homeAddress; ?>index.php?#issue-list"><img src="<?php echo $HUB_FLM->getImagePath('listhome.png'); ?>" border="0" class="active" style="margin-right: 5px;" title="<?php echo $LNG->ISSUE_HOME_LIST_BUTTON_HINT; ?>" /></a>
			</label>
		</div>
	</div -->
<?php } else if ($nodetype == 'Claim') { ?>
	<!--div id="nodearealineartitle" class="claimback claimborder curvedBorder" style="color:white;clear:both; float:left;width:100%;margin:0px;padding:0px;">
		<div class="claimback tabtitlebar" style="padding:10px;margin:0px;font-size:9pt">
			<label class="linearnodeheaderlabel", id="exploreheaderlabel">
				<a style="float:left;margin-right:5px;margin-top:3px;" href="<?php echo $CFG->homeAddress; ?>index.php?#claim-list"><img src="<?php echo $HUB_FLM->getImagePath('listhome.png'); ?>" border="0" class="active" style="margin-right: 5px;" title="<?php echo $LNG->CLAIM_HOME_LIST_BUTTON_HINT; ?>" /></a>
			</label>
		</div>
	</div -->
<?php } else if ($nodetype == 'Solution') { ?>
	<!--div id="nodearealineartitle" class="solutionback solutionborder curvedBorder" style="color:white;clear:both; float:left;width:100%;margin:0px;padding:0px;">
		<div class="solutionback tabtitlebar" style="padding:10px;margin:0px;font-size:9pt">
			<label class="linearnodeheaderlabel", id="exploreheaderlabel">
				<a style="float:left;margin-right:5px;margin-top:3px;" href="<?php echo $CFG->homeAddress; ?>index.php?#solution-list"><img src="<?php echo $HUB_FLM->getImagePath('listhome.png'); ?>" border="0" class="active" style="margin-right: 5px;" title="<?php echo $LNG->SOLUTION_HOME_LIST_BUTTON_HINT; ?>" /></a>
			</label>
		</div>
	</div -->
<?php } else if ($nodetype == 'Organization') { ?>
	<!--div id="nodearealineartitle" class="orgback orgborder curvedBorder" style="color:white;clear:both; float:left;width:100%;margin:0px;padding:0px;">
		<div class="orgback tabtitlebar" style="padding:10px;margin:0px;font-size:9pt">
			<label class="linearnodeheaderlabel", id="exploreheaderlabel">
				<a style="float:left;margin-right:5px;margin-top:3px;" href="<?php echo $CFG->homeAddress; ?>index.php?#org-list"><img src="<?php echo $HUB_FLM->getImagePath('listhome.png'); ?>" border="0" class="active" style="margin-right: 5px;" title="<?php echo $LNG->ORG_HOME_LIST_BUTTON_HINT; ?>" /></a>
			</label>
		</div>
	</div -->
<?php } else if ($nodetype == 'Project') { ?>
	<!--div id="nodearealineartitle" class="projectback projectborder curvedBorder" style="color:white;clear:both; float:left;width:100%;margin:0px;padding:0px;">
		<div class="projectback tabtitlebar" style="padding:10px;margin:0px;font-size:9pt">
			<label class="linearnodeheaderlabel", id="exploreheaderlabel">
				<a style="float:left;margin-right:5px;margin-top:3px;" href="<?php echo $CFG->homeAddress; ?>index.php?#project-list"><img src="<?php echo $HUB_FLM->getImagePath('listhome.png'); ?>" border="0" class="active" style="margin-right: 5px;" title="<?php echo $LNG->PROJECT_HOME_LIST_BUTTON_HINT; ?>" /></a>
			</label>
		</div>
	</div -->
<?php } else if (in_array($nodetype, $CFG->EVIDENCE_TYPES)) { //EVIDENCE ?>
	<!--div id="nodearealineartitle" class="evidenceback evidenceborder curvedBorder" style="color:white;clear:both; float:left;width:100%;margin:0px;padding:0px;">
		<div class="evidenceback tabtitlebar" style="padding:10px;margin:0px;font-size:9pt">
			<label class="linearnodeheaderlabel", id="exploreheaderlabel">
				<a style="float:left;margin-right:5px;margin-top:3px;" href="<?php echo $CFG->homeAddress; ?>index.php?#evidence-list"><img src="<?php echo $HUB_FLM->getImagePath('listhome.png'); ?>" border="0" class="active" style="margin-right: 5px;" title="<?php echo $LNG->EVIDENCE_HOME_LIST_BUTTON_HINT; ?>" /></a>
			</label>
		</div>
	</div -->
<?php } else if (in_array($nodetype, $CFG->RESOURCE_TYPES)) { //RESOURCES ?>
	<!--div id="nodearealineartitle" class="resourceback resourceborder curvedBorder" style="color:white;clear:both; float:left;width:100%;margin:0px;padding:0px;">
		<div class="resourceback tabtitlebar" style="padding:10px;margin:0px;font-size:9pt">
			<label class="linearnodeheaderlabel", id="exploreheaderlabel">
				<a style="float:left;margin-right:5px;margin-top:3px;" href="<?php echo $CFG->homeAddress; ?>index.php?#web-list"><img src="<?php echo $HUB_FLM->getImagePath('listhome.png'); ?>" border="0" class="active" style="" title="<?php echo $LNG->RESOURCE_HOME_LIST_BUTTON_HINT; ?>" /></a>
			</label>
		</div>
	</div -->
<?php } else if ($nodetype == 'Theme') { ?>
	<!-- div id="nodearealineartitle" class="themeback themeborder curvedBorder" style="color:white;clear:both; float:left;width:100%;margin:0px;padding:0px;">
		<div class="themeback tabtitlebar" style="padding:10px;margin:0px;font-size:9pt">
			<label class="linearnodeheaderlabel", id="exploreheaderlabel">
				<a style="float:left;margin-right:5px;margin-top:3px;" href="<?php echo $CFG->homeAddress; ?>index.php?#home-list"><img src="<?php echo $HUB_FLM->getImagePath('listhome.png'); ?>" border="0" class="active" style="margin-right: 5px;" title="<?php echo $LNG->HOME_PAGE_BUTTON_HINT; ?>" /></a>
			</label>
		</div>
	</div -->
<?php } ?>

<div id="tabber" style="clear:both;float:left;width:100%">
	<?php if ($nodetype == 'Challenge') { ?>
		<li class="tab"><a class="tab" id="tab-widget" href="#widget"><span class="tab3 tabchallenge"><?php echo $LNG->VIEWS_WIDGET_TITLE;?></span></a></li>
		<li class="tab"><a class="tab" id="tab-chat" href="#chat"><span class="tab3 tabchallenge"><?php echo $LNG->VIEWS_CHAT_TITLE;?></span></a></li>
		<li class="tab"><a class="tab" id="tab-linear" href="#linear"><span class="tab3 tabchallenge"><?php echo $LNG->VIEWS_LINEAR_TITLE;?></span></a></li>
		<li class="tab"><a class="tab" id="tab-net" href="#net"><span class="tab3 tabchallenge"><?php echo $LNG->VIEWS_EVIDENCE_MAP_TITLE;?></span></a></li>
	<?php } else if ($nodetype == 'Issue') { ?>
		<a style="float:left;margin:5px;margin-right:10px;" href="<?php echo $CFG->homeAddress; ?>index.php?#evidence-list"><img src="<?php echo $HUB_FLM->getImagePath('arrow-left2.png'); ?>" border="0" class="active" style="margin-right: 5px;" title="<?php echo $LNG->EVIDENCE_HOME_LIST_BUTTON_HINT; ?>" /></a>
		<a id="tab-widget" style="float:left;margin:5px;margin-right:20px;" href="#widget"><?php echo $LNG->VIEWS_WIDGET_TITLE;?></a>
		<a id="tab-chat" style="float:left;margin:5px;margin-right:20px;" href="#chat"><?php echo $LNG->VIEWS_CHAT_TITLE;?></a>
		<a id="tab-linear" style="float:left;margin:5px;margin-right:20px;" href="#linear"><?php echo $LNG->VIEWS_LINEAR_TITLE;?></a>
		<a id="tab-net" style="float:left;margin:5px;" href="#net"><?php echo $LNG->VIEWS_EVIDENCE_MAP_TITLE;?></a>
	<?php } else if ($nodetype == 'Claim') { ?>
		<li class="tab"><a class="tab" id="tab-widget" href="#widget"><span class="tab3 tabclaim"><?php echo $LNG->VIEWS_WIDGET_TITLE;?></span></a></li>
		<li class="tab"><a class="tab" id="tab-chat" href="#chat"><span class="tab3 tabclaim"><?php echo $LNG->VIEWS_CHAT_TITLE;?></span></a></li>
		<li class="tab"><a class="tab" id="tab-linear" href="#linear"><span class="tab3 tabclaim"><?php echo $LNG->VIEWS_LINEAR_TITLE;?></span></a></li>
		<li class="tab"><a class="tab" id="tab-net" href="#net"><span class="tab3 tabclaim"><?php echo $LNG->VIEWS_EVIDENCE_MAP_TITLE;?></span></a></li>
	<?php } else if ($nodetype == 'Solution') { ?>
		<li class="tab"><a class="tab" id="tab-widget" href="#widget"><span class="tab3 tabsolution"><?php echo $LNG->VIEWS_WIDGET_TITLE;?></span></a></li>
		<li class="tab"><a class="tab" id="tab-chat" href="#chat"><span class="tab3 tabsolution"><?php echo $LNG->VIEWS_CHAT_TITLE;?></span></a></li>
		<li class="tab"><a class="tab" id="tab-linear" href="#linear"><span class="tab3 tabsolution"><?php echo $LNG->VIEWS_LINEAR_TITLE;?></span></a></li>
		<li class="tab"><a class="tab" id="tab-net" href="#net"><span class="tab3 tabsolution"><?php echo $LNG->VIEWS_EVIDENCE_MAP_TITLE;?></span></a></li>
	<?php } else if ($nodetype == 'Organization') { ?>
		<li class="tab"><a class="tab" id="tab-widget" href="#widget"><span class="tab3 taborg"><?php echo $LNG->VIEWS_WIDGET_TITLE;?></span></a></li>
		<li class="tab"><a class="tab" id="tab-chat" href="#chat"><span class="tab3 taborg"><?php echo $LNG->VIEWS_CHAT_TITLE;?></span></a></li>
		<!-- li class="tab"><a class="tab" id="tab-linear" href="#linear"><span class="tab3 taborg"><?php echo $LNG->VIEWS_LINEAR_TITLE;?></span></a></li -->
		<li class="tab"><a class="tab" id="tab-net" href="#net"><span class="tab3 taborg"><?php echo $LNG->VIEWS_ORG_MAP_TITLE;?></span></a></li>
	<?php } else if ($nodetype == 'Project') { ?>
		<li class="tab"><a class="tab" id="tab-widget" href="#widget"><span class="tab3 tabproject"><?php echo $LNG->VIEWS_WIDGET_TITLE;?></span></a></li>
		<li class="tab"><a class="tab" id="tab-chat" href="#chat"><span class="tab3 tabproject"><?php echo $LNG->VIEWS_CHAT_TITLE;?></span></a></li>
		<!-- li class="tab"><a class="tab" id="tab-linear" href="#linear"><span class="tab3 tabproject"><?php echo $LNG->VIEWS_LINEAR_TITLE;?></span></a></li -->
		<li class="tab"><a class="tab" id="tab-net" href="#net"><span class="tab3 tabproject"><?php echo $LNG->VIEWS_ORG_MAP_TITLE;?></span></a></li>
	<?php } else if (in_array($nodetype, $CFG->EVIDENCE_TYPES)) { //EVIDENCE ?>
		<li class="tab"><a class="tab" id="tab-widget" href="#widget"><span class="tab3 tabevidence"><?php echo $LNG->VIEWS_WIDGET_TITLE;?></span></a></li>
		<li class="tab"><a class="tab" id="tab-chat" href="#chat"><span class="tab3 tabevidence"><?php echo $LNG->VIEWS_CHAT_TITLE;?></span></a></li>
		<li class="tab"><a class="tab" id="tab-linear" href="#linear"><span class="tab3 tabevidence"><?php echo $LNG->VIEWS_LINEAR_TITLE;?></span></a></li>
		<li class="tab"><a class="tab" id="tab-net" href="#net"><span class="tab3 tabevidence"><?php echo $LNG->VIEWS_EVIDENCE_MAP_TITLE;?></span></a></li>
	<?php } else if (in_array($nodetype, $CFG->RESOURCE_TYPES)) { //RESOURCES ?>
		<li class="tab"><a class="tab" id="tab-widget" href="#widget"><span class="tab3 tabresource"><?php echo $LNG->VIEWS_WIDGET_TITLE;?></span></a></li>
		<li class="tab"><a class="tab" id="tab-chat" href="#chat"><span class="tab3 tabresource"><?php echo $LNG->VIEWS_CHAT_TITLE;?></span></a></li>
		<li class="tab"><a class="tab" id="tab-linear" href="#linear"><span class="tab3 tabresource"><?php echo $LNG->VIEWS_LINEAR_TITLE;?></span></a></li>
		<li class="tab"><a class="tab" id="tab-net" href="#net"><span class="tab3 tabresource"><?php echo $LNG->VIEWS_EVIDENCE_MAP_TITLE;?></span></a></li>
	<?php } else if ($nodetype == 'Theme') { ?>
		<li class="tab"><a class="tab" id="tab-widget" href="#widget"><span class="tab3 tabtheme"><?php echo $LNG->VIEWS_WIDGET_TITLE;?></span></a></li>
		<li class="tab"><a class="tab" id="tab-chat" href="#chat"><span class="tab3 tabtheme"><?php echo $LNG->VIEWS_CHAT_TITLE;?></span></a></li>
		<!-- li class="tab"><a class="tab" id="tab-linear" href="#linear"><span class="tab3 tabtheme"><?php echo $LNG->VIEWS_LINEAR_TITLE;?></span></a></li -->
		<li class="tab"><a class="tab" id="tab-net" href="#net"><span class="tab3 tabtheme"><?php echo $LNG->VIEWS_EVIDENCE_MAP_TITLE;?></span></a></li>
	<?php } ?>

	<?php if ($nodetype == 'Challenge') { ?>
	    <div id="tabs-content" class="tabcontentexplore challengeborder">
	<?php } else if ($nodetype == 'Issue') { ?>
	    <div id="tabs-content" class="tabcontentexplore issueborder">
	<?php } else if ($nodetype == 'Claim') { ?>
	    <div id="tabs-content" class="tabcontentexplore claimborder">
	<?php } else if ($nodetype == 'Solution') { ?>
	    <div id="tabs-content" class="tabcontentexplore solutionborder">
	<?php } else if ($nodetype == 'Organization') { ?>
	    <div id="tabs-content" class="tabcontentexplore orgborder">
	<?php } else if ($nodetype == 'Project') { ?>
	    <div id="tabs-content" class="tabcontentexplore projectborder">
	<?php } else if (in_array($nodetype, $CFG->EVIDENCE_TYPES)) { //EVIDENCE ?>
	    <div id="tabs-content" class="tabcontentexplore evidenceborder">
	<?php } else if (in_array($nodetype, $CFG->RESOURCE_TYPES)) { //RESOURCES ?>
	    <div id="tabs-content" class="tabcontentexplore resourceborder">
	<?php } else if ($nodetype == 'Theme') { ?>
	    <div id="tabs-content" class="tabcontentexplore themeborder">
	<?php } ?>

	<!-- CHAT PAGE -->
		<div id='tab-content-explore-chat' class='explorepagesection' style="display:none">			<?php if ($nodetype == 'Challenge') { ?>
				<div id="nodearealineartitle" class="challengeback challengeborder" style="color:white;clear:both; float:left;width:100%;margin:0px;padding:0px;">
					<div class="challengeback tabtitlebar" style="padding:10px;margin:0px;font-size:9pt">
						<label class="linearnodeheaderlabel", id="exploreheaderlabel">
						</label>
					</div>
				</div>
			<?php } else if ($nodetype == 'Issue') { ?>
				<div id="nodearealineartitle" class="issueback issueborder" style="color:white;clear:both; float:left;width:100%;margin:0px;padding:0px;">
					<div class="issueback tabtitlebar" style="padding:10px;margin:0px;font-size:9pt">
						<label class="linearnodeheaderlabel", id="exploreheaderlabel">
						</label>
					</div>
				</div>
			<?php } else if ($nodetype == 'Claim') { ?>
				<div id="nodearealineartitle" class="claimback claimborder" style="color:white;clear:both; float:left;width:100%;margin:0px;padding:0px;">
					<div class="claimback tabtitlebar" style="padding:10px;margin:0px;font-size:9pt">
						<label class="linearnodeheaderlabel", id="exploreheaderlabel">
						</label>
					</div>
				</div>
			<?php } else if ($nodetype == 'Solution') { ?>
				<div id="nodearealineartitle" class="solutionback solutionborder" style="color:white;clear:both; float:left;width:100%;margin:0px;padding:0px;">
					<div class="solutionback tabtitlebar" style="padding:10px;margin:0px;font-size:9pt">
						<label class="linearnodeheaderlabel", id="exploreheaderlabel">
						</label>
					</div>
				</div>
			<?php } else if ($nodetype == 'Organization') { ?>
				<div id="nodearealineartitle" class="orgback orgborder" style="color:white;clear:both; float:left;width:100%;margin:0px;padding:0px;">
					<div class="orgback tabtitlebar" style="padding:10px;margin:0px;font-size:9pt">
						<label class="linearnodeheaderlabel", id="exploreheaderlabel">
						</label>
					</div>
				</div>
			<?php } else if ($nodetype == 'Project') { ?>
				<div id="nodearealineartitle" class="projectback projectborder" style="color:white;clear:both; float:left;width:100%;margin:0px;padding:0px;">
					<div class="projectback tabtitlebar" style="padding:10px;margin:0px;font-size:9pt">
						<label class="linearnodeheaderlabel", id="exploreheaderlabel">
						</label>
					</div>
				</div>
			<?php } else if (in_array($nodetype, $CFG->EVIDENCE_TYPES)) { //EVIDENCE ?>
				<div id="nodearealineartitle" class="evidenceback evidenceborder" style="color:white;clear:both; float:left;width:100%;margin:0px;padding:0px;">
					<div class="evidenceback tabtitlebar" style="padding:10px;margin:0px;font-size:9pt">
						<label class="linearnodeheaderlabel", id="exploreheaderlabel">
						</label>
					</div>
				</div>
			<?php } else if (in_array($nodetype, $CFG->RESOURCE_TYPES)) { //RESOURCES ?>
				<div id="nodearealineartitle" class="resourceback resourceborder" style="color:white;clear:both; float:left;width:100%;margin:0px;padding:0px;">
					<div class="resourceback tabtitlebar" style="padding:10px;margin:0px;font-size:9pt">
						<label class="linearnodeheaderlabel", id="exploreheaderlabel">
						</label>
					</div>
				</div>
			<?php } else if ($nodetype == 'Theme') { ?>
				<div id="nodearealineartitle" class="themeback themeborder" style="color:white;clear:both; float:left;width:100%;margin:0px;padding:0px;">
					<div class="themeback tabtitlebar" style="padding:10px;margin:0px;font-size:9pt">
						<label class="linearnodeheaderlabel", id="exploreheaderlabel">
						</label>
					</div>
				</div>
			<?php } ?>

			<span id="chattoolbar" style="margin-top:3px;"></span><br/>
			<div id="chatloading" style="width:100%;clear:both;float:left;display: block;padding-top:10px;padding-left:10px;""></div>
			<div id="chatarea" style="width:100%;min-height:400px;clear:both;float:left;display: block;margin-top:5px;padding-left:10px;"></div>
		</div>

	<!-- LINEAR/DEABATE PAGES -->
       	<div id='tab-content-explore-linear' class='explorepagesection'>
			<?php if ($nodetype == 'Challenge') { ?>
				<div id="nodearealineartitle" class="challengeback challengeborder" style="color:white;clear:both; float:left;width:100%;margin:0px;padding:0px;">
					<div class="challengeback tabtitlebar" style="padding:10px;margin:0px;font-size:9pt">
						<label class="linearnodeheaderlabel", id="exploreheaderlabel">
						</label>
					</div>
				</div>
			<?php } else if ($nodetype == 'Issue') { ?>
				<div id="nodearealineartitle" class="issueback issueborder" style="color:white;clear:both; float:left;width:100%;margin:0px;padding:0px;">
					<div class="issueback tabtitlebar" style="padding:10px;margin:0px;font-size:9pt">
						<label class="linearnodeheaderlabel", id="exploreheaderlabel">
						</label>
					</div>
				</div>
			<?php } else if ($nodetype == 'Claim') { ?>
				<div id="nodearealineartitle" class="claimback claimborder" style="color:white;clear:both; float:left;width:100%;margin:0px;padding:0px;">
					<div class="claimback tabtitlebar" style="padding:10px;margin:0px;font-size:9pt">
						<label class="linearnodeheaderlabel", id="exploreheaderlabel">
						</label>
					</div>
				</div>
			<?php } else if ($nodetype == 'Solution') { ?>
				<div id="nodearealineartitle" class="solutionback solutionborder" style="color:white;clear:both; float:left;width:100%;margin:0px;padding:0px;">
					<div class="solutionback tabtitlebar" style="padding:10px;margin:0px;font-size:9pt">
						<label class="linearnodeheaderlabel", id="exploreheaderlabel">
						</label>
					</div>
				</div>
			<?php } else if ($nodetype == 'Organization') { ?>
				<div id="nodearealineartitle" class="orgback orgborder" style="color:white;clear:both; float:left;width:100%;margin:0px;padding:0px;">
					<div class="orgback tabtitlebar" style="padding:10px;margin:0px;font-size:9pt">
						<label class="linearnodeheaderlabel", id="exploreheaderlabel">
						</label>
					</div>
				</div>
			<?php } else if ($nodetype == 'Project') { ?>
				<div id="nodearealineartitle" class="projectback projectborder" style="color:white;clear:both; float:left;width:100%;margin:0px;padding:0px;">
					<div class="projectback tabtitlebar" style="padding:10px;margin:0px;font-size:9pt">
						<label class="linearnodeheaderlabel", id="exploreheaderlabel">
						</label>
					</div>
				</div>
			<?php } else if (in_array($nodetype, $CFG->EVIDENCE_TYPES)) { //EVIDENCE ?>
				<div id="nodearealineartitle" class="evidenceback evidenceborder" style="color:white;clear:both; float:left;width:100%;margin:0px;padding:0px;">
					<div class="evidenceback tabtitlebar" style="padding:10px;margin:0px;font-size:9pt">
						<label class="linearnodeheaderlabel", id="exploreheaderlabel">
						</label>
					</div>
				</div>
			<?php } else if (in_array($nodetype, $CFG->RESOURCE_TYPES)) { //RESOURCES ?>
				<div id="nodearealineartitle" class="resourceback resourceborder" style="color:white;clear:both; float:left;width:100%;margin:0px;padding:0px;">
					<div class="resourceback tabtitlebar" style="padding:10px;margin:0px;font-size:9pt">
						<label class="linearnodeheaderlabel", id="exploreheaderlabel">
						</label>
					</div>
				</div>
			<?php } else if ($nodetype == 'Theme') { ?>
				<div id="nodearealineartitle" class="themeback themeborder" style="color:white;clear:both; float:left;width:100%;margin:0px;padding:0px;">
					<div class="themeback tabtitlebar" style="padding:10px;margin:0px;font-size:9pt">
						<label class="linearnodeheaderlabel", id="exploreheaderlabel">
						</label>
					</div>
				</div>
			<?php } ?>

			<div class="linearpagediv" id="linearpagediv">
				<table style="border-collapse:collapse;cellpadding:0px;">

					<td valign="top" width="90%">
						<div style="clear:both;float:left; width 100%;margin-left:5px;">
							<div style="clear:both;float:left;margin-top:5px;margin-right:5px;">
								<h2 style="margin-bottom:5px;"><div style="font-size:13pt;font-style: italic;float:left; "><?php echo $LNG->DEBATE_TREE_HEADING; ?></div>
								<div id="toggleDebateButton" class="active" style="margin-left:30px;margin-top:2px;font-size:10pt;float:left;display:none" onClick="javascript: toggleDebateMode();" title="<?php echo $LNG->DEBATE_SWITCH_WIDER_HINT; ?>"><?php echo $LNG->DEBATE_SWITCH_WIDER_BUTTON; ?></div>
								</h2>

								<div style="clear:both;float:left;margin-bottom:5px;margin-top:5px;">
									<span style="color: dimgray; font-size:10pt; font-weight:normal"><?php echo $LNG->DEABTES_COUNT_MESSAGE_PART1; ?> <span id="debatecount" style="font-size:12pt; font-weight:bold">0</span> <?php echo $LNG->DEABTES_COUNT_MESSAGE_PART2; ?></span>
								</div>
								<div style="clear:both;float:left;margin-bottom:5px;">
									<span id="lineardebateheading" style="margin-top:3px;"></span>
								</div>
							</div>
							<div class="linearcontent" id="content-list"></div>
							<div class="linearcontent" id="content-list-expanded" style="display:none;"></div>
						</div>
					</td>

					<td id="addknowledgearea" width="395" valign="top" style="padding:0px;margin:0px;display:none">
						<div style="float:right;height:100%;width:395px;margin:0px;padding: 0px;padding-left:7px;background:white;">
							<div id="debateadddivSpacer" style="clear:both;float:left;height:0px;width:395px;"></div>

							<?php if ($nodetype == 'Challenge') { ?>
								<div id="debateadddiv" class="challengeborder" style="border-right:none;bottom:0px;background:white;float:right;width:395px;padding:5px;">
							<?php } else if ($nodetype == 'Issue') { ?>
								<div id="debateadddiv" class="issueborder" style="border-right:none;bottom:0px;background:white;float:right;width:395px;padding:5px;">
							<?php } else if ($nodetype == 'Claim') { ?>
								<div id="debateadddiv" class="claimborder" style="border-right:none;bottom:0px;background:white;float:right;width:395px;padding:5px;">
							<?php } else if ($nodetype == 'Solution') { ?>
								<div id="debateadddiv" class="solutionborder" style="border-right:none;bottom:0px;background:white;float:right;width:395px;padding:5px;">
							<?php } else if (in_array($nodetype, $CFG->EVIDENCE_TYPES)) { //EVIDENCE ?>
								<div id="debateadddiv" class="evidenceborder" style="border-right:none;bottom:0px;background:white;float:right;width:395px;padding:5px;">
							<?php } else if (in_array($nodetype, $CFG->RESOURCE_TYPES)) { //RESOURCES ?>
								<div id="debateadddiv" class="resourceborder" style="border-right:none;bottom:0px;background:white;float:right;width:395px;padding:5px;">
							<?php } else { ?>
								<div id="debateadddiv" style="bottom:0px;background:white;float:right;width:395px;padding:5px;border: 2px solid #D3D3D3;border-left:none;">
							<?php } ?>

							<div style="clear:both;float:left;margin-top:5px;width:100%">
								<h2 style="float:eflt;display:inline;font-style: italic;font-size:13pt"><?php echo $LNG->DEBATE_ADD_HEADING; ?></h2>
								<span class="active" style="float:right;" onclick="$('addknowledgearea').style.display='none';"><?php echo $LNG->FORM_BUTTON_CLOSE; ?></span>
							</div>
							<div id="debateadduparea" style="clear:both;float:left;display: block;width:390px;"></div>
							<div id="debateadduparrow" style="clear:both;float:left;margin: auto 0;width:390px;margin-left:190px;">
								<img alt="v" src="<?php echo $HUB_FLM->getImagePath('arrow-orange-down.jpg'); ?>" border="0" />
							</div>
							<div id="nodearealinear" style="clear:both;float:left;display: block;width:390px;"></div>
							<div id="debateadddownarrow" style="clear:both;float:left;width:390px;margin-left:190px;">
								<img alt="v" src="<?php echo $HUB_FLM->getImagePath('arrow-orange-down.jpg'); ?>" border="0" />
							</div>
							<div id="debateadddownarea" style="clear:both;float:left;;display: block;width:390px;"></div>
						</div>
					</td>

				</table>
			</div>
		</div>

	<!-- WIDGET PAGES -->
       	<div id='tab-content-explore-widget' class='explorepagesection' style="display:none">

			<?php if ($nodetype == 'Challenge') { ?>
				<div id="widgetareadiv" class="challengebackpale" style="clear:both; float:left;width:100%;padding:0px;">
					<table id="widgettable" style="display:block" width="100%" class="widgettable challengebackpale" cellspacing="5">
						<tr>
							<td id="widgetcolleft" width="30%" valign="top">
								<div id="extraarea" class="tabletop" style="float:left;display:block;padding:0px;margin-top:10px;"><h2 style="margin-bottom:2px;"><?php echo $LNG->EXPLORE_WIDGET_ADDITIONAL_RELATIONS_HEADING; ?></h2></div>

								<div id="orgsarea" class="tablelower" style="display: block;"></div>
								<div id="projectsarea" class="tablelower" style="display: block;"></div>
								<div id="seealsoarea" class="tablelower" style="display: block;"></div>
								<div id="themearea" class="tablelower" style="display:block"></div>
								<div id="followersarea" class="tablelower" style="display:block"></div>
							</td>
							<td id="widgetcolnode" width="40%" valign="top">
								<div id="nodearea" class="tabletop" style="display:block"></div>
							</td>
							<td id="widgetcolright" width="30%" valign="top">
								<div class="tabletop">
									<table style="border-collapse:collapse;cellpadding:0px;">
										<tr>
											<td width="10px;" valign="middle">
												<img src="<?php echo $HUB_FLM->getImagePath('arrow-orange-right-short.png'); ?>" border="0" />
											</td>
											<td width="96%">
												<div id="issuesarea" style="display: block;"></div>
											</td>
										</tr>
									</table>
								</div>

								<div id="recommendationarea" class="tablelower" style="float:left;display:block;padding:0px;margin-top:10px;"><h2 style="margin-bottom:2px;"><?php echo $LNG->EXPLORE_WIDGET_RECOMMENDATIONS_HEADING; ?></h2></div>

								<div id="suggestedorgsarea" class="tablelower" style="display:block"></div>
								<div id="suggestedissuesarea" class="tablelower" style="display:block;"></div>
							</td>
						</tr>
					</table>
				</div>
			<?php } else if ($nodetype == 'Issue') { ?>
				<div id="widgetareadiv" class="issuebackpale" style="clear:both; float:left;width:100%;">
					<table id="widgettable" style="display:block" width="100%" class="widgettable issuebackpale" cellspacing="5">
						<tr>
							<td id="widgetcolleft" width="30%" valign="top">

								<?php if ($CFG->HAS_CHALLENGE) { ?>
								<div class="tabletop">
									<table style="border-collapse:collapse;cellpadding:0px;">
										<tr>
											<td width="96%">
												<div id="challengesarea" style="display: block;"></div>
											</td>
											<td width="10px;" valign="middle">
												<img src="<?php echo $HUB_FLM->getImagePath('arrow-orange-right-short.png'); ?>" border="0" />
											</td>
										</tr>
									</table>
								</div>
								<?php } ?>

								<div id="extraarea" class="tablelower" style="float:left;display:block;padding:0px;margin-top:10px;"><h2 style="margin-bottom:2px;"><?php echo $LNG->EXPLORE_WIDGET_ADDITIONAL_RELATIONS_HEADING; ?></h2></div>

								<div id="orgsarea" class="tablelower" style="display:block"></div>
								<div id="projectsarea" class="tablelower" style="display:block"></div>
								<div id="seealsoarea" class="tablelower" style="display: block;"></div>
								<div id="themearea" class="tablelower" style="display:block"></div>
								<div id="followersarea" class="tablelower" style="display:block"></div>
							</td>
							<td id="widgetcolnode" width="40%" valign="top">
								<div id="nodearea" class="tabletop" style="display:block"></div>
							</td>
							<td id="widgetcolright" width="30%" valign="top">
								<?php if ($CFG->HAS_SOLUTION) { ?>
									<div class="tabletop" >
										<table style="border-collapse:collapse;cellpadding:0px;">
											<tr>
												<td width="10px;" valign="middle">
													<img src="<?php echo $HUB_FLM->getImagePath('arrow-orange-right-short.png'); ?>" border="0" />
												</td>
												<td width="96%">
													<div id="solutionsarea" style="display: block;"></div>
												</td>
											</tr>
										</table>
									</div>
								<?php } ?>
								<?php if ($CFG->HAS_CLAIM) { ?>
									<div class="<?php if ($CFG->HAS_CLAIM && !$CFG->HAS_SOLUTION){ echo 'tabletop'; } else { echo 'tablelower'; } ?>">
										<table style="border-collapse:collapse;cellpadding:0px;">
											<tr>
												<td width="10px;" valign="middle">
													<img src="<?php echo $HUB_FLM->getImagePath('arrow-orange-right-short.png'); ?>" border="0" />
												</td>
												<td width="96%">
													<div id="claimsarea" style="display: block;"></div>
												</td>
											</tr>
										</table>
									</div>
								<?php } ?>


								<div id="recommendationarea" class="tablelower" style="float:left;display:block;padding:0px;margin-top:10px;"><h2 style="margin-bottom:2px;"><?php echo $LNG->EXPLORE_WIDGET_RECOMMENDATIONS_HEADING; ?></h2></div>

								<div id="suggestedorgsarea" class="tablelower" style="display:block"></div>
								<?php if ($CFG->HAS_SOLUTION) { ?>
								<div id="suggestedsolutionsarea" class="tablelower" style="display: block;"></div>
								<?php } ?>
								<?php if ($CFG->HAS_CLAIM) { ?>
								<div id="suggestedclaimsarea" class="tablelower" style="display: block;"></div>
								<?php } ?>
								<div id="tagsissuesarea" class="tablelower" style="display:block"></div>
							</td>
						</tr>
					</table>
				</div>
			<?php } else if ($nodetype == 'Claim') { ?>
				<div id="widgetareadiv" class="claimbackpale" style="clear:both; float:left;width:100%;">
					<table id="widgettable" style="display:block" width="100%" class="widgettable claimbackpale" cellspacing="5">
						<tr>
							<td id="widgetcolleft" width="30%" valign="top">
								<div class="tabletop">
									<table style="border-collapse:collapse;cellpadding:0px;">
										<tr>
											<td width="96%">
												<div id="issuesarea" style="display: block;"></div>
											</td>
											<td width="10px;" valign="middle">
												<img src="<?php echo $HUB_FLM->getImagePath('arrow-orange-right-short.png'); ?>" border="0" />
											</td>
										</tr>
									</table>
								</div>

								<div id="extraarea" class="tablelower" style="float:left;display:block;padding:0px;margin-top:10px;"><h2 style="margin-bottom:2px;"><?php echo $LNG->EXPLORE_WIDGET_ADDITIONAL_RELATIONS_HEADING; ?></h2></div>
								<div id="orgsarea" class="tablelower" style="display: block;"></div>
								<div id="projectsarea" class="tablelower" style="display: block;"></div>
								<div id="seealsoarea" class="tablelower" style="display: block;"></div>
								<div id="themearea" class="tablelower" style="display: block;"></div>
								<div id="followersarea" class="tablelower" style="display:block"></div>
							</td>
							<td id="widgetcolnode" width="40%" valign="top">
								<div id="nodearea" class="tabletop" style="display: block;"></div>
							</td>
							<td id="widgetcolright" width="30%" valign="top">
								<div class="tabletop" >
									<table style="border-collapse:collapse;cellpadding:0px;">
										<tr>
											<td width="10px;" valign="middle">
												<img src="<?php echo $HUB_FLM->getImagePath('arrow-orange-right-short.png'); ?>" border="0" />
											</td>
											<td width="96%">
												<div id="prosarea" style="display: block;"></div>
											</td>
										</tr>
									</table>
								</div>
								<div class="tablelower">
									<table style="border-collapse:collapse;cellpadding:0px;">
										<tr>
											<td width="10px;" valign="middle">
												<img src="<?php echo $HUB_FLM->getImagePath('arrow-orange-right-short.png'); ?>" border="0" />
											</td>
											<td width="96%">
												<div id="consarea" style="display: block;"></div>
											</td>
										</tr>
									</table>
								</div>

								<div id="recommendationarea" class="tablelower" style="float:left;display:block;padding:0px;margin-top:10px;"><h2 style="margin-bottom:2px;"><?php echo $LNG->EXPLORE_WIDGET_RECOMMENDATIONS_HEADING; ?></h2></div>

								<div id="suggestedorgsarea" class="tablelower" style="display: block;"></div>
								<div id="suggestedissuesarea" class="tablelower" style="display: block;"></div>
							</td>
						</tr>
					</table>
				</div>
			<?php } else if ($nodetype == 'Solution') { ?>
				<div id="widgetareadiv" class="solutionbackpale" style="clear:both; float:left;width:100%;">
					<table id="widgettable" style="display:block" width="100%" class="widgettable solutionbackpale" cellspacing="5">
						<tr>
							<td id="widgetcolleft" width="30%" valign="top">
								<div class="tabletop">
									<table style="border-collapse:collapse;cellpadding:0px;">
										<tr>
											<td width="96%">
												<div id="issuesarea" style="display: block;"></div>
											</td>
											<td width="10px;" valign="middle">
												<img src="<?php echo $HUB_FLM->getImagePath('arrow-orange-right-short.png'); ?>" border="0" />
											</td>
										</tr>
									</table>
								</div>

								<div id="extraarea" class="tablelower" style="float:left;display:block;padding:0px;margin-top:10px;"><h2 style="margin-bottom:2px;"><?php echo $LNG->EXPLORE_WIDGET_ADDITIONAL_RELATIONS_HEADING; ?></h2></div>
								<div id="orgsarea" class="tablelower" style="display: block;"></div>
								<div id="projectsarea" class="tablelower" style="display: block;"></div>
								<div id="seealsoarea" class="tablelower" style="display: block;"></div>
								<div id="themearea" class="tablelower" style="display: block;"></div>
								<div id="followersarea" class="tablelower" style="display:block"></div>
							</td>
							<td id="widgetcolnode" width="40%" valign="top">
								<div id="nodearea" class="tabletop" style="display: block;"></div>
							</td>
							<td id="widgetcolright" width="30%" valign="top">
								<div class="tabletop" >
									<table style="border-collapse:collapse;cellpadding:0px;">
										<tr>
											<td width="10px;" valign="middle">
												<img src="<?php echo $HUB_FLM->getImagePath('arrow-orange-right-short.png'); ?>" border="0" />
											</td>
											<td width="96%">
												<div id="prosarea" style="display: block;"></div>
											</td>
										</tr>
									</table>
								</div>
								<div class="tablelower">
									<table style="border-collapse:collapse;cellpadding:0px;">
										<tr>
											<td width="10px;" valign="middle">
												<img src="<?php echo $HUB_FLM->getImagePath('arrow-orange-right-short.png'); ?>" border="0" />
											</td>
											<td width="96%">
												<div id="consarea" style="display: block;"></div>
											</td>
										</tr>
									</table>
								</div>

								<div id="recommendationarea" class="tablelower" style="float:left;display:block;padding:0px;margin-top:10px;"><h2 style="margin-bottom:2px;"><?php echo $LNG->EXPLORE_WIDGET_RECOMMENDATIONS_HEADING; ?></h2></div>

								<div id="suggestedorgsarea" class="tablelower" style="display: block;"></div>
								<div id="suggestedissuesarea" class="tablelower" style="display: block;"></div>
							</td>
						</tr>
					</table>
				</div>
			<?php } else if ($nodetype == 'Organization') { ?>
				<div id="widgetareadiv" class="orgbackpale" style="clear:both; float:left;width:100%;">
					<table id="widgettable" style="display:block" width="100%" class="widgettable orgbackpale" cellspacing="5">
						<tr>
							<td id="widgetcolleft" width="30%" valign="top">
								<!--  div id="commentsarea" class="tabletop" style="display: block;"></div -->
								<div id="themearea" class="tabletop" style="display: block;"></div>

								<div id="extraarea" class="tablelower" style="float:left;display:block;padding:0px;margin-top:10px;"><h2 style="margin-bottom:2px;"><?php echo $LNG->EXPLORE_WIDGET_ADDITIONAL_RELATIONS_HEADING; ?></h2></div>

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
								<div id="seealsoarea" class="tablelower" style="display: block;"></div>
							</td>
							<td id="widgetcolnode" width="40%" valign="top">
								<div id="nodearea" class="tabletop" style="display: block;"></div>
							</td>
							<td id="widgetcolright" width="30%" valign="top">
								<div id="followersarea" class="tabletop" style="display:block"></div>

								<div id="recommendationarea" class="tablelower" style="float:left;display:block;padding:0px;margin-top:10px;"><h2 style="margin-bottom:2px;"><?php echo $LNG->EXPLORE_WIDGET_RECOMMENDATIONS_HEADING; ?></h2></div>

								<div id="suggestedissuesarea" class="tablelower" style="display: block;"></div>
								<?php if ($CFG->HAS_SOLUTION) { ?>
									<div id="suggestedsolutionsarea" class="tablelower" style="display: block;"></div>
								<?php } ?>
								<?php if ($CFG->HAS_CLAIM) { ?>
									<div id="suggestedclaimsarea" class="tablelower" style="display: block;"></div>
								<?php } ?>
							</td>
						</tr>
					</table>
				</div>
			<?php } else if ($nodetype == 'Project') { ?>
				<div id="widgetareadiv" class="projectbackpale" style="clear:both; float:left;width:100%;">
					<table id="widgettable" style="display:block" width="100%" class="widgettable projectbackpale" cellspacing="5">
						<tr>
							<td id="widgetcolleft" width="30%" valign="top">
								<!-- div id="commentsarea" class="tabletop" style="display: block;"></div -->
								<div id="themearea" class="tabletop" style="display: block;"></div>

								<div id="extraarea" class="tablelower" style="float:left;display:block;padding:0px;margin-top:10px;"><h2 style="margin-bottom:2px;"><?php echo $LNG->EXPLORE_WIDGET_ADDITIONAL_RELATIONS_HEADING; ?></h2></div>

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
								<div id="seealsoarea" class="tablelower" style="display: block;"></div>
							</td>
							<td id="widgetcolnode" width="40%" valign="top">
								<div id="nodearea" class="tabletop" style="display: block;"></div>
							</td>
							<td id="widgetcolright" width="30%" valign="top">
								<div id="followersarea" class="tabletop" style="display:block"></div>

								<div id="recommendationarea" class="tablelower" style="float:left;display:block;padding:0px;margin-top:10px;"><h2 style="margin-bottom:2px;"><?php echo $LNG->EXPLORE_WIDGET_RECOMMENDATIONS_HEADING; ?></h2></div>

								<div id="suggestedissuesarea" class="tablelower" style="display: block;"></div>
								<?php if ($CFG->HAS_SOLUTION) { ?>
									<div id="suggestedsolutionsarea" class="tablelower" style="display: block;"></div>
								<?php } ?>
								<?php if ($CFG->HAS_CLAIM) { ?>
									<div id="suggestedclaimsarea" class="tablelower" style="display: block;"></div>
								<?php } ?>
							</td>
						</tr>
					</table>
				</div>
			<?php } else if (in_array($nodetype, $CFG->EVIDENCE_TYPES)) { //EVIDENCE ?>
				<div id="widgetareadiv" class="evidencebackpale" style="clear:both; float:left;width:100%;">
					<table id="widgettable" style="display:block" width="100%" class="widgettable evidencebackpale" cellspacing="5">
						<tr>
							<td id="widgetcolleft" width="30%" valign="top">

								<?php if ($CFG->HAS_SOLUTION) { ?>
									<div id="solutionsarea" class="tabletop">
										<table style="border-collapse:collapse;cellpadding:0px;">
											<tr>
												<td width="96%">
													<div id="solutionsareainner" style="display: block;"></div>
												</td>
												<td width="10px;" valign="middle">
													<img src="<?php echo $HUB_FLM->getImagePath('arrow-orange-right-short.png'); ?>" border="0" />
												</td>
											</tr>
										</table>
									</div>
								<?php } ?>
								<?php if ($CFG->HAS_CLAIM) { ?>
									<div id="claimsarea" class="<?php if ($CFG->HAS_CLAIM && !$CFG->HAS_SOLUTION){ echo 'tabletop'; } else { echo 'tablelower'; } ?>">
										<table style="border-collapse:collapse;cellpadding:0px;">
											<tr>
												<td width="96%">
													<div id="claimsareainner" style="display: block;"></div>
												</td>
												<td width="10px;" valign="middle">
													<img src="<?php echo $HUB_FLM->getImagePath('arrow-orange-right-short.png'); ?>" border="0" />
												</td>
											</tr>
										</table>
									</div>
								<?php } ?>

								<div id="extraarea" class="tablelower" style="float:left;display:block;padding:0px;margin-top:10px;"><h2 style="margin-bottom:2px;"><?php echo $LNG->EXPLORE_WIDGET_ADDITIONAL_RELATIONS_HEADING; ?></h2></div>
								<div id="orgsarea" class="tablelower" style="display: block;"></div>
								<div id="projectsarea" class="tablelower" style="display: block;"></div>
								<div id="seealsoarea" class="tablelower" style="display: block;"></div>
								<div id="themearea" class="tablelower" style="display: block;"></div>
								<div id="followersarea" class="tablelower" style="display:block"></div>
							</td>
							<td id="widgetcolnode" width="40%" valign="top">
								<div id="nodearea" class="tabletop" style="display: block;"></div>
							</td>
							<td id="widgetcolright" width="30%" valign="top">
								<div id="websitesarea" class="tabletop">
									<table style="border-collapse:collapse;cellpadding:0px;">
										<tr>
											<td width="10px;" valign="middle">
												<img src="<?php echo $HUB_FLM->getImagePath('arrow-orange-right-short.png'); ?>" border="0" />
											</td>
											<td width="96%">
												<div id="websitesareainner" style="display: block;"></div>
											</td>
										</tr>
									</table>
								</div>

								<div id="recommendationarea" class="tablelower" style="float:left;display:block;padding:0px;margin-top:10px;"><h2 style="margin-bottom:2px;"><?php echo $LNG->EXPLORE_WIDGET_RECOMMENDATIONS_HEADING; ?></h2></div>

								<div id="suggestedorgsarea" class="tablelower" style="display: block;"></div>
								<div id="suggestedissuesarea" class="tablelower" style="display: block;"></div>
								<?php if ($CFG->HAS_SOLUTION) { ?>
									<div id="suggestedsolutionsarea" class="tablelower" style="display: block;"></div>
								<?php } ?>
								<?php if ($CFG->HAS_CLAIM) { ?>
									<div id="suggestedclaimsarea" class="tablelower" style="display: block;"></div>
								<?php } ?>
							</td>
						</tr>
					</table>
				</div>
			<?php } else if (in_array($nodetype, $CFG->RESOURCE_TYPES)) { //RESOURCES ?>
				<div id="widgetareadiv" class="resourcebackpale" style="clear:both; float:left;width:100%;">
					<table id="widgettable" style="display:block" width="100%" class="widgettable resourcebackpale" cellspacing="5" border="0">
						<tr>
							<td id="widgetcolleft" width="30%" valign="top">
								<div id="themearea" class="tabletop" style="display: block;"></div>

								<div id="extraarea" class="tablelower" style="float:left;display:block;padding:0px;margin-top:10px;"><h2 style="margin-bottom:2px;"><?php echo $LNG->EXPLORE_WIDGET_ADDITIONAL_RELATIONS_HEADING; ?></h2></div>

								<div id="evidencesarea" class="tablelower" style="display: block;"></div>
								<div id="orgsarea" class="tablelower" style="display: block;"></div>
								<div id="projectsarea" class="tablelower" style="display: block;"></div>
								<div id="seealsoarea" class="tablelower" style="display: block;"></div>
							</td>
							<td id="widgetcolnode" width="40%" valign="top">
								<div id="nodearea" class="tabletop" style="display: block;"></div>
							</td>
							<td id="widgetcolright" width="30%" valign="top">
								<div id="followersarea" class="tabletop" style="display:block"></div>

								<div id="recommendationarea" class="tablelower" style="float:left;display:block;padding:0px;margin-top:10px;"><h2 style="margin-bottom:2px;"><?php echo $LNG->EXPLORE_WIDGET_RECOMMENDATIONS_HEADING; ?></h2></div>

								<div id="relatedresourcesarea" class="tablelower" style="display: block;"></div>
								<div id="suggestedorgsarea" class="tablelower" style="display: block;"></div>
								<div id="suggestedissuesarea" class="tablelower" style="display: block;"></div>
								<?php if ($CFG->HAS_SOLUTION) { ?>
									<div id="suggestedsolutionsarea" class="tablelower" style="display: block;"></div>
								<?php } ?>
								<?php if ($CFG->HAS_CLAIM) { ?>
									<div id="suggestedclaimsarea" class="tablelower" style="display: block;"></div>
								<?php } ?>
							</td>
						</tr>
					</table>
				</div>
			<?php } else if ($nodetype == 'Theme') { ?>
				<div id="widgetareadiv" class="themebackpale" style="clear:both; float:left;width:100%;">
					<table id="widgettable" style="display:block" width="100%" class="widgettable themebackpale" cellspacing="5">
						<tr>
							<td id="widgetcolleft" width="30%" valign="top">
								<!--  div id="commentsarea" class="tabletop" style="display: block;"></div -->
								<div id="orgsarea" class="tabletop" style="display: block;"></div>
								<div id="projectsarea" class="tablelower" style="display: block;"></div>
								<?php if ($CFG->HAS_CHALLENGE) { ?>
									<div id="challengesarea" class="tablelower" style="display: block;"></div>
								<?php } ?>
								<div id="issuesarea" class="tablelower" style="display: block;"></div>
								<?php if ($CFG->HAS_SOLUTION) { ?>
									<div id="solutionsarea" class="tablelower" style="display: block;"></div>
								<?php } ?>
							</td>
							<td id="widgetcolnode" width="40%" valign='top'>
								<div id="nodearea" class="tabletop" style="display: block;"></div>
							</td>
							<td id="widgetcolright" width="30%" valign="top">
								<div id="followersarea" class="tabletop" style="display: block;"></div>
								<?php if ($CFG->HAS_CLAIM) { ?>
									<div id="claimsarea" class="tablelower" style="display: block;"></div>
								<?php } ?>
								<div id="evidencearea" class="tablelower" style="display: block;"></div>
								<div id="resourcearea" class="tablelower" style="display: block;"></div>
							</td>
						</tr>
					</table>
				</div>
			<?php } ?>
		</div>

	<!-- MAP PAGES -->
       	<div id='tab-content-explore-net' class='explorepagesection' style="display:none">
			<?php if ($nodetype == 'Challenge') { ?>
				<div id="nodearealineartitle" class="challengeback challengeborder" style="color:white;clear:both; float:left;width:100%;margin:0px;padding:0px;">
					<div class="challengeback tabtitlebar" style="padding:10px;margin:0px;font-size:9pt">
						<label class="linearnodeheaderlabel", id="exploreheaderlabel">
						</label>
					</div>
				</div>
			<?php } else if ($nodetype == 'Issue') { ?>
				<div id="nodearealineartitle" class="issueback issueborder" style="color:white;clear:both; float:left;width:100%;margin:0px;padding:0px;">
					<div class="issueback tabtitlebar" style="padding:10px;margin:0px;font-size:9pt">
						<label class="linearnodeheaderlabel", id="exploreheaderlabel">
						</label>
					</div>
				</div>
			<?php } else if ($nodetype == 'Claim') { ?>
				<div id="nodearealineartitle" class="claimback claimborder" style="color:white;clear:both; float:left;width:100%;margin:0px;padding:0px;">
					<div class="claimback tabtitlebar" style="padding:10px;margin:0px;font-size:9pt">
						<label class="linearnodeheaderlabel", id="exploreheaderlabel">
						</label>
					</div>
				</div>
			<?php } else if ($nodetype == 'Solution') { ?>
				<div id="nodearealineartitle" class="solutionback solutionborder" style="color:white;clear:both; float:left;width:100%;margin:0px;padding:0px;">
					<div class="solutionback tabtitlebar" style="padding:10px;margin:0px;font-size:9pt">
						<label class="linearnodeheaderlabel", id="exploreheaderlabel">
						</label>
					</div>
				</div>
			<?php } else if ($nodetype == 'Organization') { ?>
				<div id="nodearealineartitle" class="orgback orgborder" style="color:white;clear:both; float:left;width:100%;margin:0px;padding:0px;">
					<div class="orgback tabtitlebar" style="padding:10px;margin:0px;font-size:9pt">
						<label class="linearnodeheaderlabel", id="exploreheaderlabel">
						</label>
					</div>
				</div>
			<?php } else if ($nodetype == 'Project') { ?>
				<div id="nodearealineartitle" class="projectback projectborder" style="color:white;clear:both; float:left;width:100%;margin:0px;padding:0px;">
					<div class="projectback tabtitlebar" style="padding:10px;margin:0px;font-size:9pt">
						<label class="linearnodeheaderlabel", id="exploreheaderlabel">
						</label>
					</div>
				</div>
			<?php } else if (in_array($nodetype, $CFG->EVIDENCE_TYPES)) { //EVIDENCE ?>
				<div id="nodearealineartitle" class="evidenceback evidenceborder" style="color:white;clear:both; float:left;width:100%;margin:0px;padding:0px;">
					<div class="evidenceback tabtitlebar" style="padding:10px;margin:0px;font-size:9pt">
						<label class="linearnodeheaderlabel", id="exploreheaderlabel">
						</label>
					</div>
				</div>
			<?php } else if (in_array($nodetype, $CFG->RESOURCE_TYPES)) { //RESOURCES ?>
				<div id="nodearealineartitle" class="resourceback resourceborder" style="color:white;clear:both; float:left;width:100%;margin:0px;padding:0px;">
					<div class="resourceback tabtitlebar" style="padding:10px;margin:0px;font-size:9pt">
						<label class="linearnodeheaderlabel", id="exploreheaderlabel">
						</label>
					</div>
				</div>
			<?php } else if ($nodetype == 'Theme') { ?>
				<div id="nodearealineartitle" class="themeback themeborder" style="color:white;clear:both; float:left;width:100%;margin:0px;padding:0px;">
					<div class="themeback tabtitlebar" style="padding:10px;margin:0px;font-size:9pt">
						<label class="linearnodeheaderlabel", id="exploreheaderlabel">
						</label>
					</div>
				</div>
			<?php } ?>

			<?php if ($nodetype == 'Challenge') { ?>
				<div id="tab-content-challenge-net" style="clear:both; float:left;width:100%;">
				</div>
			<?php } else if ($nodetype == 'Issue') { ?>
				<div id="tab-content-issue-net" style="clear:both; float:left;width:100%;">
				</div>
			<?php } else if ($nodetype == 'Claim') { ?>
				<div id="tab-content-claim-net" style="clear:both; float:left;width:100%;">
				</div>
			<?php } else if ($nodetype == 'Solution') { ?>
				<div id="tab-content-solution-net" style="clear:both; float:left;width:100%;">
				</div>
			<?php } else if ($nodetype == 'Organization') { ?>
				<div id="tab-content-org-net" style="clear:both; float:left;width:100%;">
				</div>
			<?php } else if ($nodetype == 'Project') { ?>
				<div id="tab-content-project-net" style="clear:both; float:left;width:100%;">
				</div>
			<?php } else if (in_array($nodetype, $CFG->EVIDENCE_TYPES)) { //EVIDENCE ?>
				<div id="tab-content-evidence-net" style="clear:both; float:left;width:100%;">
				</div>
			<?php } else if (in_array($nodetype, $CFG->RESOURCE_TYPES)) { //RESOURCES ?>
				<div id="tab-content-web-net" style="clear:both; float:left;width:100%;">
				</div>
			<?php } else if ($nodetype == 'Theme') { ?>
				<div id="tab-content-theme-net" style="clear:both; float:left;width:100%;">
				</div>
			<?php } ?>
		</div>
	</div>
</div>

<?php
    include_once($HUB_FLM->getCodeDirPath("ui/footer.php"));
?>
