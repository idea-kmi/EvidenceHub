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
    include_once($HUB_FLM->getCodeDirPath("core/lib/url-validation.class.php"));
	include_once($HUB_FLM->getCodeDirPath("ui/popuplib.php"));

	$errors = array();

	$isRemote = optional_param("isremote", false,PARAM_BOOL);

    $nodetypename = stripslashes(trim(optional_param("nodetypename","",PARAM_TEXT)));
    $title = stripslashes(trim(optional_param("title","",PARAM_TEXT)));
    $url = trim(optional_param("url","http://",PARAM_URL));
    $clip = stripslashes(trim(optional_param("clip","",PARAM_TEXT)));
    $clippath = stripslashes(trim(optional_param("clippath","",PARAM_TEXT)));
    $identifier = stripslashes(trim(optional_param("identifier","",PARAM_TEXT)));
	$themesarray = optional_param("themesarray","",PARAM_TEXT);

    $newtags = optional_param("newtags","",PARAM_TEXT);

    if(isset($_POST["addurl"])){
        //check all fields entered
        if ($url == "http://" || $url == ""){
            array_push($errors, $LNG->FORM_RESOURCE_ENTER_URL_ERROR);
        }
        if ($title == ""){
            array_push($errors, $LNG->FORM_RESOURCE_ENTER_TITLE_ERROR);
        }

        if (is_countable($themesarray) && count($themesarray) <= 0){
            array_push($errors, $LNG->FORM_ERROR_THEME);
        }

        $URLValidator = new mrsnk_URL_validation($url, MRSNK_URL_DO_NOT_PRINT_ERRORS, MRSNK_URL_DO_NOT_CONNECT_2_URL);
        if($url != "" && !$URLValidator->isValid()){
             array_push($errors, $LNG->FORM_RESOURCE_URL_FORMAT_ERROR);
		}

        if(empty($errors)){

			$r = getRoleByName($nodetypename);
			$refrole = $r->roleid;

			$refnode = addNode($url, $title, 'N', $refrole);
			if (!$refnode instanceof Hub_Error) {
				if ($CFG->autoFollowingOn) {
					addFollowing($refnode->nodeid);
				}

				if ($nodetypename == 'Publication') {
					$refnode->updateAdditionalIdentifier($identifier);
				}

				// Add any new tags
				addTagsToNode($refnode, $newtags);

				// ADD URL TO REF
				$urlObj = addURL($url, $title, '', 'N', $clip, $clippath, "", "cohere", $identifier);
				$refnode->addURL($urlObj->urlid, "");

				if (isset($themesarray) && $themesarray != "") {
					connectThemesToNode($refnode, $themesarray, "N");
				}

				echo "<script type='text/javascript'>";

				if ($isRemote === false) {
					echo "try { ";
						echo "var parent=window.opener.document; ";
						echo "if (window.opener && window.opener.loadSelecteditemNew) {";
						echo "	  window.opener.loadSelecteditemNew('".$refnode->nodeid."','".$refnode->name."'); }";
						echo 'else {';
						echo '	  window.opener.location.href = "'.$CFG->homeAddress.'explore.php?id='.$refnode->nodeid.'"; }';
						echo "window.close();";
					echo "}";
					echo "catch(err) {";
						//CALLED FROM BOOKMARKET FROM A DIFFERNT DOMAIN
						//alert("Thank you for entering a Resource into the Evidence Hub");
						//echo "window.close();";

						// For IE security message avoidance
						echo "var objWin = window.self;";
						echo "objWin.open('','_self','');";
						echo "objWin.close();";
					echo "}";
				} else {
					// For IE security message avoidance
					echo "var objWin = window.self;";
					echo "objWin.open('','_self','');";
					echo "objWin.close();";
				}
				echo "</script>";
				include_once($HUB_FLM->getCodeDirPath("ui/dialogfooter.php"));
				die;

			} else {
  	           array_push($errors, $LNG->FORM_RESOURCE_CREATE_ERROR_MESSAGE." ".$refnode->message);
			}
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
	$('dialogheader').insert('<?php echo $LNG->FORM_RESOURCE_TITLE_ADD; ?>');
}

function typeChanged() {
	var type = $('nodetypename').value;
	if (type == "Publication") {
		$('identifierdiv').style.display = "block";
	} else {
		$('identifierdiv').style.display = "none";
	}
}

function checkThemeChange(num) {
	var selected = $('theme'+num+'menu').value;
	if (selected != "" && num == noThemes-1) {
		noThemes = addTheme(noThemes);
		$('theme'+noThemes+'menu').focus();
	}
}

function checkForm() {
	if (!isValidURI($('url').value)) {
	   alert("<?php echo $LNG->FORM_RESOURCE_URL_FORMAT_ERROR; ?>");
	   return false;
	}
	var checkurl = ($('url').value).trim();
	if (checkurl == "" || $('url').value == "http://"){
	   alert("<?php echo $LNG->FORM_RESOURCE_ENTER_URL_ERROR; ?>");
	   return false;
	}
	var checktitle = ($('title').value).trim();
	if (checktitle == ""){
	   alert("<?php echo $LNG->FORM_RESOURCE_ENTER_TITLE_ERROR; ?>");
	   return false;
	}
	if ($('theme0menu').value == "") {
	   	alert("<?php echo $LNG->FORM_ERROR_THEME; ?>");
	   	return false;
    }

    $('addurl').style.cursor = 'wait';

    return true;
}

window.onload = init;
</script>

<?php insertFormHeaderMessage(); ?>

<form id="addurl" name="addurl" action="" method="post" onsubmit="return checkForm();">

   	<input type="hidden" id="clippath" name="clippath" value="<?php echo $clippath; ?>" />

   	<div class="formrow">
		<label  class="formlabelbig" for="nodetypename"><span style="vertical-align:top"><?php echo $LNG->FORM_LABEL_TYPE; ?></span>
			<span class="active" onMouseOver="showFormHint('ResourceType', event, 'hgrhint'); return false;" onMouseOut="hideHints(); return false;" onClick="hideHints(); return false;" onkeypress="enterKeyPressed(event)"><img src="<?php echo $HUB_FLM->getImagePath('info.png'); ?>" border="0" style="margin-top: 2px; margin-left: 5px; margin-right: 2px;" /></span>
			<span style="font-size:14pt;margin-top:3px;vertical-align:middle;color:red;">*</span>
		</label>
		<select class="forminput hgrselect forminputmust" onchange="typeChanged()" id="nodetypename" name="nodetypename">
			<?php
				$count = 0;
				if (is_countable($CFG->RESOURCE_TYPES)) {
					$count = count($CFG->RESOURCE_TYPES);
				}
				for($i=0; $i<$count; $i++){
					$item = $CFG->RESOURCE_TYPES[$i];
					$name = $LNG->RESOURCE_TYPES[$i];
				?>
    	        	<option value='<?php echo $item; ?>' <?php if ( $nodetypename == $item || ($nodetypename == "" && $item == $CFG->RESOURCE_TYPES_DEFAULT) ) { echo 'selected=\"true\"'; } ?> ><?php echo $name ?></option>
			<?php } ?>
		</select>
   	</div>

    <?php insertUrl('ResourceURL'); ?>

    <?php insertTitle('ResourceTitle'); ?>

    <?php insertDOI('ResourceDOI'); ?>

	<?php if ($clip != "") { ?>
		<div class="formrow">
			<label  class="formlabelbig" for="clip"><?php echo $LNG->FORM_LABEL_CLIP; ?>
				<a href="javascript:void(0)" onMouseOver="showFormHint('ResourceClip', event, 'hgrhint'); return false;" onMouseOut="hideHints(); return false;" onClick="hideHints(); return false;" onkeypress="enterKeyPressed(event)"><img src="<?php echo $HUB_FLM->getImagePath('info.png'); ?>" border="0" style="margin-top: 2px; margin-left: 5px; margin-right: 2px;" /></a>
			</label>
			<textarea class="forminput hgrinput" readonly style="border: none" id="clip" name="clip" rows="3"><?php echo($clip); ?></textarea>
		</div>
	<?php } ?>

	<?php insertThemes('ResourceTheme'); ?>

	<?php insertAddTags('ResourceTag'); ?>

  </div>

 <div class="formrow">
	<span class="formsubmit"></span>
	</div>
   <div class="formrow">
        <input class="formsubmit" type="submit" value="<?php echo $LNG->FORM_BUTTON_PUBLISH; ?>" id="addurl" name="addurl">
        <input type="button" value="<?php echo $LNG->FORM_BUTTON_CANCEL; ?>" onclick="window.close();"/>
    </div>
</form>

<?php
    include_once($HUB_FLM->getCodeDirPath("ui/dialogfooter.php"));
?>