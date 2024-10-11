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
    include_once("../../../config.php");

    $me = substr($_SERVER["PHP_SELF"], 1); // remove initial '/'
    if ($HUB_FLM->hasCustomVersion($me)) {
    	$path = $HUB_FLM->getCodeDirPath($me);
    	include_once($path);
		die;
	}
?>

var debatenodeid = URL_ARGS['nodeid'];
var debateNodeObj = nodeObj;

function loadAddAreaData() {
	$('treeaddarea').innerHTML = "";
	$('treeaddarea').style.display = "block";

	debatenodeid = CURRENT_ADD_AREA_NODEID;
	debateNodeObj = CURRENT_ADD_AREA_NODE;

	var exploreButton = new Element("a", {'style':'margin-bottom:5px;clear:both;float:left;font-size:10pt', 'title':'<?php echo $LNG->NODE_DETAIL_BUTTON_HINT; ?>'} );
	exploreButton.insert("<?php echo $LNG->NODE_DETAIL_BUTTON_TEXT; ?>");
	if (debateNodeObj.searchid && debateNodeObj.searchid != "") {
		exploreButton.href= "explore.php?id="+debatenodeid+"&sid="+debateNodeObj.searchid;
	} else {
		exploreButton.href= "explore.php?id="+debatenodeid;
	}
	$('treeaddarea').appendChild(exploreButton);

};

loadAddAreaData();