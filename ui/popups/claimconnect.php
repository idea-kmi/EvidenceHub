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

    include_once("../../config.php");

    $me = substr($_SERVER["PHP_SELF"], 1); // remove initial '/'
    if ($HUB_FLM->hasCustomVersion($me)) {
    	$path = $HUB_FLM->getCodeDirPath($me);
    	include_once($path);
		die;
	}

    include_once($HUB_FLM->getCodeDirPath("core/utillib.php"));

    checkLogin();

    include_once($HUB_FLM->getCodeDirPath("ui/dialogheader.php"));
	include_once($HUB_FLM->getCodeDirPath("ui/popuplib.php"));

    $errors = array();

	$filternodetypes = required_param("filternodetypes",PARAM_TEXT);
	$focalnodeid = required_param("focalnodeid",PARAM_TEXT);
	$focalnodeend = required_param("focalnodeend",PARAM_TEXT);
	$linktypename = required_param("linktypename",PARAM_TEXT);
	$focalnode = getNode($focalnodeid);

	$claim = optional_param("claim","",PARAM_TEXT);
	$nodeid = optional_param("nodeid","",PARAM_TEXT);
	//$conndesc = optional_param("conndesc", "", PARAM_TEXT);
	$conndesc = "";
	$desc = optional_param("desc","",PARAM_HTML);
	$handler = optional_param("handler","",PARAM_TEXT);

	$themesarray = optional_param("themesarray","",PARAM_TEXT);
	$theme = optional_param("theme","",PARAM_TEXT);
	if ($theme != "") {
		$themesarray[0] = $theme;
	}

    $newtags = optional_param("newtags","",PARAM_TEXT);

    if( isset($_POST["addclaim"]) ) {
        if ($claim == "" && $nodeid == ""){
            array_push($errors, $LNG->FORM_CLAIM_ENTER_SUMMARY_ERROR);
        }

        if (is_countable($themesarray) && count($themesarray) <= 0 && $nodeid == ""){
            array_push($errors,$LNG->FORM_ERROR_THEME);
        }

        if(empty($errors)){

			// GET ROLES AND LINKS FOR USER
			$r = getRoleByName("Claim");
			$roleClaim = $r->roleid;

			// CREATE THE CLAIM NODE
			if ($nodeid == "") {
				$claimnode = addNode($claim,$desc, 'N', $roleClaim);
				if (!$claimnode instanceof Hub_Error) {
					if ($CFG->autoFollowingOn) {
						addFollowing($claimnode->nodeid);
					}

					// Add any new tags
					addTagsToNode($claimnode, $newtags);

					// Add any themes
					connectThemesToNode($claimnode,$themesarray,"N");
				}
			}

			// CONNECT NODE TO FOCAL
			$r = getRoleByName($focalnode->role->name);
			$focalroleid = $r->roleid;

			$lt = getLinkTypeByLabel($linktypename);
			$linkType = $lt->linktypeid;

			if ($linktypename == "supports") {
				$r = getRoleByName('Pro');
				$focalroleid = $r->roleid;
			}
			if ($linktypename == "challenges") {
				$r = getRoleByName('Con');
				$focalroleid = $r->roleid;
			}

			if ($focalnodeend == "from") {
				$connection = addConnection($focalnodeid, $focalroleid, $linkType, $nodeid, $roleClaim, "N", $conndesc);
			} else {
				$connection = addConnection($nodeid, $roleClaim, $linkType, $focalnodeid, $focalroleid, "N", $conndesc);
			}

			echo "<script type='text/javascript'>";

			// decision just to send them to the explore page for the other end of the connection
			// echo 'window.opener.location.href = "'.$CFG->homeAddress.'explore.php?id='.$nodeid.'";';

			if (isset($handler) && $handler != "") {
				echo "window.opener.".$handler."('".$nodeid."');";
			} else {
				echo "if (window.opener && window.opener.refreshWidgetClaims) {";
				echo "	  window.opener.refreshWidgetClaims('".$nodeid."'); }";
				echo "else if (window.opener && window.opener.refreshClaims) {";
				echo "	  window.opener.refreshClaims(); }";
				echo "else {";
				echo "	  window.opener.location.reload(true); }";
			}

			echo "window.close();";
			echo "</script>";
			include_once($HUB_FLM->getCodeDirPath("ui/dialogfooter.php"));
			die;
		}
    }
?>

<?php
if(!empty($errors)){
    echo "<div class='errors'>".$LNG->FORM_ERROR_MESSAGE.":<ul>";
    foreach ($errors as $error){
        echo "<li>".$error."</li>";
    }
    echo "</ul></div>";
}
?>

<script type="text/javascript">
// Themes always start with one entry - so if the array is empty the count should still be 1
var noThemes = <?php if (is_countable($themesarray) && count($themesarray) > 0) { echo count($themesarray); } else { echo "1";}?>;

function init() {
    $('dialogheader').insert("<?php echo $LNG->FORM_CLAIM_TITLE_CONNECT; ?> <br><span style=\"font-size: 80%\">\"<?php echo addslashes( $focalnode->name ); ?>\"</span>");
}

function addSelectedNode(node) {
	$('claimdiv').style.display="none";
	$('claimlabeldiv').style.display="block";
	$('claimlabel').value = node.name;
	$('nodeid').value = node.nodeid;
	$('themediv').style.display="none";
	$('descdiv').style.display="none";
	$('tagsdiv').style.display="none";
}

function removeSelectedNode() {
	$('claimdiv').style.display="block";
	$('claimlabeldiv').style.display="none";
	$('claimlabel').value="";
	$('nodeid').value = "";
	$('themediv').style.display="block";
	$('descdiv').style.display="block";
	$('tagsdiv').style.display="block";
}

function openSelector() {
	loadDialog('selector', URL_ROOT+"ui/popups/selector.php?filternodetypes=<?php echo $filternodetypes; ?>", 420, 730);
}

function checkThemeChange(num) {
	var selected = $('theme'+num+'menu').value;
	if (selected != "" && num == noThemes-1) {
		noThemes = addTheme(noThemes);
		$('theme'+noThemes+'menu').focus();
	}
}

function checkForm() {
	var checkname = ($('claim').value).trim();
	if (checkname == "" && $('nodeid').value == ""){
		alert("<?php echo $LNG->FORM_CLAIM_ENTER_SUMMARY_ERROR; ?>");
		return false;
	} else if ($('theme0menu').value == "" && $('nodeid').value == "") {
	   	alert("<?php echo $LNG->FORM_ERROR_THEME; ?>");
	   	return false;
    }

    $('claimform').style.cursor = 'wait';
	return true;
}

window.onload = init;

</script>

<?php insertFormHeaderMessage(); ?>

<form id="claimform" name="claimform" action="" enctype="multipart/form-data" method="post" onsubmit="return checkForm();">
	<input type="hidden" id="focalnodeid" name="focalnodeid" value="<?php echo $focalnodeid; ?>" />
	<input type="hidden" id="focalnodeend" name="focalnodeend" value="<?php echo $focalnodeend; ?>" />
	<input type="hidden" id="filternodetypes" name="filternodetypes" value="<?php echo $filternodetypes; ?>" />
	<input type="hidden" id="linktypename" name="linktypename" value="<?php echo $linktypename; ?>" />
	<input type="hidden" id="nodeid" name="nodeid" value="<?php echo $nodeid; ?>" />
	<input type="hidden" id="handler" name="handler" value="<?php echo $handler; ?>" />
	<input type="hidden" id="theme" name="theme" value="<?php echo $theme; ?>" />

<h2 style="margin-left:5px;"><?php echo $LNG->FORM_CLAIM_TITLE_SECTION; ?></h2>
<div class="subformconnect">
    <div class="hgrformrow" id="claimlabeldiv" style="display: none;">
		<label class="formlabelbig" for="claimlabel"><span style="vertical-align:top"><?php echo $LNG->FORM_CLAIM_LABEL_SUMMARY; ?></span>
			<span class="active" onMouseOver="showFormHint('ClaimSummary', event, 'hgrhint'); return false;" onMouseOut="hideHints(); return false;" onClick="hideHints(); return false;" onkeypress="enterKeyPressed(event)"><img src="<?php echo $HUB_FLM->getImagePath('info.png'); ?>" border="0" style="margin-top: 2px; margin-left: 5px; margin-right: 2px;" /></span>
			<span style="font-size:14pt;margin-top:3px;vertical-align:middle;color:red;">*</span>
		</label>
		<input class="forminputmust hgrinput hgrwide" style="width:340px;" readonly id="claimlabel" name="claimlabel" value="" />
	    <span class="active" onClick="javascript: removeSelectedNode()" class="form" style="margin-left: 5px;"><?php echo $LNG->FORM_BUTTON_REMOVE_CAP; ?></span>
	    <span class="active" onClick="javascript: openSelector()" class="form" style="margin-left: 10px;"><?php echo $LNG->FORM_BUTTON_SELECT_ANOTHER; ?></span>
	</div>

    <div class="hgrformrow" id="claimdiv">
		<label  class="formlabelbig" for="claim"><span style="vertical-align:top"><?php echo $LNG->FORM_CLAIM_LABEL_SUMMARY; ?></span>
			<span class="active" onMouseOver="showFormHint('ClaimSummary', event, 'hgrhint'); return false;" onMouseOut="hideHints(); return false;" onClick="hideHints(); return false;" onkeypress="enterKeyPressed(event)"><img src="<?php echo $HUB_FLM->getImagePath('info.png'); ?>" border="0" style="margin-top: 2px; margin-left: 5px; margin-right: 2px;" /></span>
			<span style="font-size:14pt;margin-top:3px;vertical-align:middle;color:red;">*</span>
		</label>
		<input class="forminputmust hgrinput hgrwide" style="width:340px" id="claim" name="claim" value="<?php echo( $claim ); ?>" />
		<?php if ($focalnodeid != "") { ?>
		    <span class="active" onClick="javascript: openSelector()" class="form" style="margin-left: 5px;"><?php echo $LNG->FORM_CLAIM_SELECT_EXISTING; ?></span>
		<?php }; ?>
	</div>

	<?php insertDescription('ClaimDesc'); ?>

	<?php insertThemes('ClaimTheme', $theme); ?>

	<?php insertAddTags('ClaimTag'); ?>
</div>
<div style="clear:both;"></div>
<!-- h2 style="margin-left:5px;"><?php echo $LNG->FORM_CONNECT_RELEVANCE_SECTION; ?></h2>
<div class="subformconnect">
	<?php insertReason('ClaimReason'); ?>
</div -->

<div class="hgrformrow">
	<input class="submit" type="submit" value="<?php echo $LNG->FORM_BUTTON_PUBLISH; ?>" id="addclaim" name="addclaim">
	<input type="button" value="<?php echo $LNG->FORM_BUTTON_CANCEL; ?>" onclick="window.close();"/>
</div>

</form>
<?php
    include_once($HUB_FLM->getCodeDirPath("ui/dialogfooter.php"));
?>