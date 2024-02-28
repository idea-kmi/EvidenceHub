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

	$query = stripslashes(parseToJSON(optional_param("q","",PARAM_TEXT)));
	$scope = optional_param("scope","all",PARAM_TEXT);
	$tagsonly = optional_param("tagsonly",false,PARAM_BOOL);
    $start = optional_param("start",0,PARAM_INT);
    $max = optional_param("max",20,PARAM_INT);
    $orderby = optional_param("orderby","",PARAM_ALPHA);
    $sort = optional_param("sort","DESC",PARAM_ALPHA);

	$args = array();

	$args["filternodetypes"] = '';

	$args["q"] = $query;
	$args["scope"] = $scope;
	$args["tagsonly"] = $tagsonly;

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
    echo "var nodeObj = null;";
    echo "var CONTEXT = '".$CONTEXT."';";
    echo "var NODE_ARGS = ".$argsStr.";";
	echo "</script>";
?>

<script type='text/javascript'>

Event.observe(window, 'load', function() {
	buildSearchTitle("tree", NODE_ARGS['q'], NODE_ARGS['tagsonly']);

	var bObj = new JSONscriptRequest('<?php echo $HUB_FLM->getCodeWebPath("ui/explore/linear/searchlineartree.js.php"); ?>');
	bObj.buildScriptTag();
	bObj.addScriptTag();
});

</script>

<div id="nodearealineartitle" class="plainback plainborder" style="color:white;clear:both; float:left;width:100%;margin:0px;padding:0px;">
	<div class="plainback tabtitlebar" style="padding:10px;margin:0px;font-size:9pt">
		<label class="linearnodeheaderlabel", id="exploreheaderlabel">
		</label>
	</div>
</div>

<div style="border-bottom:1px solid #E8E8E8; width:100%;clear:both; float:left;width:100%;margin:0px;padding:0px;">
	<div id="headertoolbar" style="clear:both;float:left;margin-top:10px;margin-left:5px;"></div>
</div>

<div id="tabber" style="clear:both;float:left;width:100%;">
    <div id="tabs-content" class="tabcontentexplore plainborder" style="min-height:400px;">

	<!-- LINEAR/DEABATE PAGES -->
       	<div id='tab-content-explore-linear' class='explorepagesection'>
			<div class="linearpagediv" id="linearpagediv">
				<div style="clear:both;float:left; width 100%;margin-left:5px;">
					<div style="clear:both;float:left;margin-top:5px;margin-right:5px;">
						<h2 style="margin-bottom:5px;"><div style="font-size:13pt;font-style: italic;float:left; "><?php echo $LNG->VIEWS_LINEAR_TITLE; ?></div>
						<div id="toggleDebateButton" class="active" style="margin-left:30px;margin-top:2px;font-size:10pt;float:left;display:none" onClick="javascript: toggleDebateMode();" title="<?php echo $LNG->DEBATE_SWITCH_WIDER_HINT; ?>"><?php echo $LNG->DEBATE_SWITCH_WIDER_BUTTON; ?></div>
						</h2>

						<div style="clear:both;float:left;margin-bottom:5px;margin-top:5px;">
							<span style="color: dimgray; font-size:10pt; font-weight:normal"><?php echo $LNG->DEABTES_COUNT_SEARCH_MESSAGE_PART1; ?> <span id="debatecount" style="font-size:12pt; font-weight:bold">0</span> <?php echo $LNG->DEABTES_COUNT_SEARCH_MESSAGE_PART2; ?></span>
						</div>
						<div style="clear:both;float:left;margin-bottom:5px;">
							<span id="lineardebateheading" style="margin-top:3px;"></span>
						</div>
					</div>
					<div class="linearcontent" id="content-list"></div>
					<div class="linearcontent" id="content-list-expanded" style="display:none;"></div>
				</div>
				<div id="treeaddarea" style="display:none;clear:both;float:left;margin:0px;padding: 0px;margin-top:10px;margin-left:10px;background:white;"></div>
			</div>
		</div>
	</div>
</div>

<?php
    include_once($HUB_FLM->getCodeDirPath("ui/footer.php"));
?>
