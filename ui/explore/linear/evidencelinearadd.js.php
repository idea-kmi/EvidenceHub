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

var debatenodeid = EVIDENCE_ARGS['nodeid'];
var debateNodeObj = nodeObj;

function loadAddAreaData() {
	$('treeaddarea').innerHTML = "";
	$('treeaddarea').style.display = "block";

	debatenodeid = CURRENT_ADD_AREA_NODEID;
	var handler="";

	var model = HUB_DATAMODEL.evidenceToResource;
	var filternodetypes = model.getOtherEnd();
	var linktypename = model.linktypes;
	var focalnodeend = model.direction;
	var hint = model.hint;
	$('treeaddarea').insert('<a style="margin-bottom:3px;clear:both;float:left;" id="addknowledge'+key+'button" title="'+hint+'" href="javascript: loadDialog(\'resourceconnect\', \''+URL_ROOT+'ui/popups/resourceconnect.php?linktypename='+linktypename+'&focalnodeid='+nodeid+'&focalnodeend='+focalnodeend+'&filternodetypes='+filternodetypes+'&handler='+handler+'\', 770,600);"><img style="vertical-align:bottom" src="<?php echo $HUB_FLM->getImagePath('add.png'); ?>" border="0" width="16" height="16" style="margin:0px;margin-left: 5px;padding:0px" /> <?php echo $LNG->NODE_DEBATE_ADD_TO_RESOURCE_MENU_TEXT; ?></a>');
}

loadAddAreaData();