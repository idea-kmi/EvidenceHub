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

    array_push($HEADER,'<script src="'.$HUB_FLM->getCodeWebPath('ui/tabber.js.php').'" type="text/javascript"></script>');

   	$CONTEXT = $CFG->GLOBAL_CONTEXT;

    include_once($HUB_FLM->getCodeDirPath("ui/header.php"));
    include_once($HUB_FLM->getCodeDirPath("ui/tabberlib.php"));

	// default parameters
    $start = optional_param("start",0,PARAM_INT);
    $max = optional_param("max",20,PARAM_INT);
    $orderby = optional_param("orderby","",PARAM_ALPHA);
    $sort = optional_param("sort","DESC",PARAM_ALPHA);

	// filter parameters
    $filtergroup = optional_param("filtergroup","",PARAM_TEXT);
    $filterlist = optional_param("filterlist","",PARAM_TEXT);
    $filternodetypes = optional_param("filternodetypes","",PARAM_TEXT);
    $filterthemes = optional_param("filterthemes","",PARAM_TEXT);
    $filterbyconnection = optional_param("filterbyconnection","",PARAM_TEXT);
    $zoomtocountry = optional_param("zoomtocountry","",PARAM_TEXT);

	// if coming from a search
    $q = stripslashes(optional_param("q","",PARAM_TEXT));

    // not currently used in inner searches
	//$scope = optional_param("scope","all",PARAM_TEXT);
	//$tagsonly = optional_param("tagsonly","false",PARAM_TEXT);
?>
    <!-- div id="context" style="margin-bottom: 5px;">&nbsp;</div -->
    <div style="clear:both;"></div>
<?php
    $args = array();

    $args["start"] = $start;
    $args["max"] = $max;

    $wasEmpty = false;
    if ($orderby == "") {
   		$args["orderby"] = 'date';
   		$wasEmpty = true;
   	} else {
   		$args["orderby"] = $orderby;
   	}
    $args["sort"] = $sort;

    $args["filtergroup"] = $filtergroup;
    $args["filterlist"] = $filterlist;
    $args["filternodetypes"] = $filternodetypes;
	$args["filterthemes"] = $filterthemes;
	$args["filterbyconnection"] = $filterbyconnection;
	$args["zoomtocountry"] = $zoomtocountry;

    $args["q"] = $q;

    //$args["scope"] = $scope; //not used in inner searches
    //$args["tagsonly"] = $tagsonly; //not used in inner searches

    //$args["title"] = "";//$LNG->INDEX_ALL_DATA; - not sure of the point of this and it clutters quiery string

    display_tabber($CFG->GLOBAL_CONTEXT,$args, $wasEmpty);

    include_once($HUB_FLM->getCodeDirPath("ui/footer.php"));
?>