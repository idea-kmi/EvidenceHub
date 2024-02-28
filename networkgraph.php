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

	// network search parameters
    //$netnodeid = optional_param("netnodeid","",PARAM_TEXT);
    //$netq = optional_param("netq","",PARAM_TEXT);
    //$netscope = optional_param("netscope","",PARAM_TEXT);
    //$netlinkgroup = optional_param("netlinkgroup","",PARAM_TEXT);
    //$netdepth = optional_param("netdepth",1,PARAM_INT);
    //$netdirection = optional_param("netdirection",'both',PARAM_TEXT);
    //$netlabelmatch = optional_param("netlabelmatch",'false',PARAM_TEXT);
    //$agentlastrun = optional_param("agentlastrun",'',PARAM_TEXT);

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

    //$args["netnodeid"] = $netnodeid;
    //$args["netq"] = $netq;
    //$args["netscope"] = $netscope;
    //$args["netlinkgroup"] = $netlinkgroup;
    //$args["netdepth"] = $netdepth;
    //$args["netdirection"] = $netdirection;
    //$args["netlabelmatch"] = $netlabelmatch;
    //$args["agentlastrun"] = $agentlastrun;

    $args["title"] = $node->name;
    //$args["tags"] = $tags;

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
	echo "var USER_ARGS = ".$argsStr.";";
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
	buildNodeTitle('network');

	if (NODE_ARGS['nodetype'] == 'Challenge') {
		addScriptDynamically('<?php echo $HUB_FLM->getCodeWebPath("ui/networkmaps/explore-challenge-net.js.php"); ?>', 'explore-challenge-net-script');
	} else if (NODE_ARGS['nodetype'] == 'Issue') {
		addScriptDynamically('<?php echo $HUB_FLM->getCodeWebPath("ui/networkmaps/explore-issue-net.js.php"); ?>', 'explore-issue-net-script');
	} else if (NODE_ARGS['nodetype'] == 'Claim') {
		addScriptDynamically('<?php echo $HUB_FLM->getCodeWebPath("ui/networkmaps/explore-claim-net.js.php"); ?>', 'explore-claim-net-script');
	} else if (NODE_ARGS['nodetype'] == 'Solution') {
		addScriptDynamically('<?php echo $HUB_FLM->getCodeWebPath("ui/networkmaps/explore-solution-net.js.php"); ?>', 'explore-solution-net-script');
	} else if (NODE_ARGS['nodetype'] == 'Organization') {
		addScriptDynamically('<?php echo $HUB_FLM->getCodeWebPath("ui/networkmaps/explore-org-net.js.php"); ?>', 'explore-org-net-script');
	} else if (NODE_ARGS['nodetype'] == 'Project') {
		addScriptDynamically('<?php echo $HUB_FLM->getCodeWebPath("ui/networkmaps/explore-project-net.js.php"); ?>', 'explore-project-net-script');
	} else if (EVIDENCE_TYPES_STR.indexOf(NODE_ARGS['nodetype']) != -1) { //EVIDENCE
		addScriptDynamically('<?php echo $HUB_FLM->getCodeWebPath("ui/networkmaps/explore-evidence-net.js.php"); ?>', 'explore-evidence-net-script');
	} else if (RESOURCE_TYPES_STR.indexOf(NODE_ARGS['nodetype']) != -1) { //RESOURCES
		addScriptDynamically('<?php echo $HUB_FLM->getCodeWebPath("ui/networkmaps/explore-resource-net.js.php"); ?>', 'explore-resource-net-script');
	} else if (NODE_ARGS['nodetype'] == 'Theme') {
		addScriptDynamically('<?php echo $HUB_FLM->getCodeWebPath("ui/networkmaps/explore-theme-net.js.php"); ?>', 'explore-theme-net-script');
	}
});

</script>

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

<div style="border-bottom:1px solid #E8E8E8; width:100%;clear:both; float:left;width:100%;margin:0px;padding:0px;">
	<div id="headertoolbar" style="clear:both;float:left;margin-top:10px;margin-left:5px;"></div>
</div>

<div id="tabber" style="clear:both;float:left;width:100%;">
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

	<!-- MAP PAGES -->
       	<div id='tab-content-explore-net' class='explorepagesection' style="display:block">
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
