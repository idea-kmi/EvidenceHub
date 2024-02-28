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
	buildSearchTitle("net", NODE_ARGS['q'], NODE_ARGS['tagsonly']);

	var bObj = new JSONscriptRequest('<?php echo $HUB_FLM->getCodeWebPath("ui/networkmaps/explore-search-net.js.php"); ?>');
	bObj.buildScriptTag();
	bObj.addScriptTag();
});

</script>

<div id="nodearealineartitle" class="plainback plainborder">
	<div class="plainback tabtitlebar">
		<label class="linearnodeheaderlabel", id="exploreheaderlabel">
		</label>
	</div>
</div>

<div>
	<div id="headertoolbar"></div>
</div>

<div id="tabber">
    <div id="tabs-content" class="tabcontentexplore" style="min-height:400px;">
       	<div id='tab-content-explore-net' class='explorepagesection' style="display:block">
			<div id="tab-content-search-net"></div>
		</div>
	</div>
</div>

<?php
    include_once($HUB_FLM->getCodeDirPath("ui/footer.php"));
?>
