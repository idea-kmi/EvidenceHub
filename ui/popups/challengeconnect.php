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

    checkLogin();

    include_once($HUB_FLM->getCodeDirPath("ui/dialogheader.php"));
	include_once($HUB_FLM->getCodeDirPath("ui/popuplib.php"));

    $errors = array();

	$filternodetypes = required_param("filternodetypes",PARAM_TEXT);
	$focalnodeid = required_param("focalnodeid",PARAM_TEXT);
	$focalnodeend = required_param("focalnodeend",PARAM_TEXT);
	$linktypename = required_param("linktypename",PARAM_TEXT);
	$focalnode = getNode($focalnodeid);

	$challenges = optional_param("challenges","",PARAM_TEXT);
	$conndesc = optional_param("conndesc", "", PARAM_TEXT);
	$handler = optional_param("handler","",PARAM_TEXT);

    if( isset($_POST["addchallenge"]) ) {
		$nodeid = "";

		if ($challenges && $challenges != ""){

			$lt = getLinkTypeByLabel($linktypename);
			$linkType = $lt->linktypeid;

			$r = getRoleByName($focalnode->role->name);
			$focalroleid = $r->roleid;

			$r = getRoleByName("Challenge");
			$roleChallenge = $r->roleid;

			$count = count($challenges);
			for($i=0; $i<$count; $i++){
				$challengeid = $challenges[$i];
				if ($challengeid != "") {

					$nodeid = $challengeid;
					//addConnection($focalnodeid, $focalroleid, $linkType, $challengeid, $roleChallenge, "N", $conndesc[$i]);

					$desc = "";

					if ($focalnodeend == "from") {
						$connection = addConnection($focalnodeid, $focalroleid, $linkType, $challengeid, $roleChallenge, "N", $desc);
					} else {
						$connection = addConnection($challengeid, $roleChallenge, $linkType, $focalnodeid, $focalroleid, "N", $desc);
					}
				}
			}
		}

		echo "<script type='text/javascript'>";

		if (isset($handler) && $handler != "") {
			echo "window.opener.".$handler."('".$nodeid."');";
		} else {
			echo "if (window.opener && window.opener.refreshWidgetChallenges) {";
			echo "	  window.opener.refreshWidgetChallenges('".$nodeid."'); }";
			echo "else if (window.opener && window.opener.refreshChallenges) {";
			echo "	  window.opener.refreshChallenges(); }";
			echo "else {";
			echo "	  window.opener.location.reload(true); }";
		}
		echo "window.close();";
		echo "</script>";
		include_once($HUB_FLM->getCodeDirPath("ui/dialogfooter.php"));
		die;
    } else {
    	$challengeset = getNodesByGlobal(0, -1 ,'name', 'ASC', "Challenge", "", 'short',"",'all');
		$challanges = $challengeset->nodes;
    }

    /**********************************************************************************/
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

function init() {
	var name = "<?php echo $LNG->FORM_TITLE_CURRENT_ITEM; ?>"
	<?php if (!$focalnode instanceof Hub_Error) { ?>
		name="<?php echo addslashes( $focalnode->name); ?>";
	<?php } ?>
    $('dialogheader').insert('<?php echo $LNG->FORM_TITLE_CHALLENGE_CONNECT; ?> <br><span style="font-size: 80%">"'+name+'"</span>');
}

function checkForm() {
	//var checkname = ($('challenge').value).trim();
	//if (checkname == "" && $('nodeid').value == ""){
	//   alert("Please enter a challenge before trying to publish");
	//   return false;
    //}

    $('challengeform').style.cursor = 'wait';

	return true;
}

window.onload = init;

</script>

<?php insertFormHeaderMessage(); ?>

<form id="challengeform" name="challengeform" action="" enctype="multipart/form-data" method="post" onsubmit="return checkForm();">
	<input type="hidden" id="focalnodeid" name="focalnodeid" value="<?php echo $focalnodeid; ?>" />
	<input type="hidden" id="focalnodeend" name="focalnodeend" value="<?php echo $focalnodeend; ?>" />
	<input type="hidden" id="filternodetypes" name="filternodetypes" value="<?php echo $filternodetypes; ?>" />
	<input type="hidden" id="linktypename" name="linktypename" value="<?php echo $linktypename; ?>" />
	<input type="hidden" id="handler" name="handler" value="<?php echo $handler; ?>" />

    <div class="formrow" style="font-weight:bold; margin-left: 10px; margin-bottom: 10px">
		<label><?php echo $LNG->CHALLENGES_NAME; ?>:
			<span class="active" onMouseOver="showFormHint('Challenges', event, 'hgrhint', '<?php echo addslashes($focalnode->name); ?>'); return false;" onMouseOut="hideHints(); return false;" onClick="hideHints(); return false;" onkeypress="enterKeyPressed(event)"><img src="<?php echo $HUB_FLM->getImagePath('info.png'); ?>" border="0" style="margin-top: 2px; margin-left: 5px; margin-right: 2px;" /></span>
			<span style="font-size:14pt;margin-top:3px;vertical-align:middle;color:red;">*</span>
		</label>
	</div>

    <div class="formrow" style="width: 600px; margin-left: 10px">
		<div id="groupsdiv" style="display: block">
			<div class="subform hgrwide" style="width: 600px;">
			<?php
                $i = 0;
                foreach($challanges as $challenge){
                    $class = "subforminput";
                    echo '<div class="subformrow">';
                    echo "<input type='checkbox' class='".$class."' id='challenges' name='challenges[]' value='".$challenge->nodeid."' ";
                    echo "/><b>".$challenge->name."</b><br/>";
					?>
					<?php
                    echo '</div>';
                    $i++;
                }
	         ?>
	         </div>
         </div>
    </div>

    <br>
    <div class="hgrformrow">
        <input class="submit" type="submit" value="<?php echo $LNG->FORM_BUTTON_PUBLISH; ?>" id="addchallenge" name="addchallenge">
        <input type="button" value="<?php echo $LNG->FORM_BUTTON_CANCEL; ?>" onclick="window.close();" />
    </div>
</form>

<?php
    include_once($HUB_FLM->getCodeDirPath("ui/dialogfooter.php"));
?>