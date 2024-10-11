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

	$desc = optional_param("desc","",PARAM_HTML);
    $newtags = optional_param("newtags","",PARAM_TEXT);

    if( isset($_POST["addcomment"]) ) {
		$label = "";
		if (isProbablyHTML($desc)) {
			$label = removeHTMLTags($desc);
		} else {
			$label = $desc;
			$label = str_replace("\n", ' ', $label); // remove new lines
			$label = str_replace("\r", ' ', $label); // remove carraige return
			$label = str_replace("\t", ' ', $label); // remove tabs
		}
		trim($label);

        if ($label == ""){
            array_push($errors, $LNG->FORM_COMMENT_ENTER_SUMMARY_ERROR);
        }

        if(empty($errors)){

			$r = getRoleByName("Idea");
			$roleComment = $r->roleid;

			if (strlen($label) > 100) {
				$label = substr($label, 0, 100)."...";
			} else {
				if (!isProbablyHTML($desc)) {
					$desc = "";
				}
			}

			// CREATE THE CLAIM NODE
			$commentnode = addNode($label,$desc, 'N', $roleComment);

			// Add any new tags
			addTagsToNode($commentnode, $newtags);

			echo "<script type='text/javascript'>";

			//always refresh the whole screen (for explore header etc)
			// can be added from home page too, so just to make sure,
			echo 'if (window.opener.location.href != "'.$CFG->homeAddress.'#comment-list") {';
				echo 'window.opener.location.href = "'.$CFG->homeAddress.'#comment-list";';
			echo "}";
			echo "window.opener.location.reload(true);";
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
	function init() {
		$('dialogheader').insert('<?php echo $LNG->FORM_COMMENT_TITLE; ?>');
	}
	function checkForm() {
		var checkname = "";
		if (CKEDITOR.instances.desc) {
			checkname = CKEDITOR.instances.desc.getData();
		} else {
			checkname = ($('desc').value).trim();
		}
		checkname = removeHTMLTags(checkname);
		if (checkname == ""){
			alert("<?php echo $LNG->FORM_COMMENT_ENTER_SUMMARY_ERROR; ?>");
			return false;
		}
		$('commentform').style.cursor = 'wait';
		return true;
	}
	window.onload = init;
</script>

<div class="container-fluid popups">
	<div class="row p-4 justify-content-center">	
		<div class="col">
			<p><?php echo $LNG->FORM_COMMENT_MESSAGE; ?></p>
			<?php insertFormHeaderMessageShort(); ?>

			<form id="commentform" name="commentform" commentform="" enctype="multipart/form-data" method="post" onsubmit="return checkForm();">
				<?php insertComment('CommentDesc'); ?>
				<?php insertAddTags('CommentTag'); ?>

				<div class="mb-3 row">
					<div class="d-grid gap-2 d-md-flex justify-content-md-center mb-3">
						<input class="btn btn-secondary" type="button" value="<?php echo $LNG->FORM_BUTTON_CANCEL; ?>" onclick="window.close();"/>
						<input class="btn btn-primary" type="submit" value="<?php echo $LNG->FORM_BUTTON_PUBLISH; ?>" id="addcomment" name="addcomment" />
					</div>
				</div>
			</form>
		</div>
	</div>
</div>

<?php
    include_once($HUB_FLM->getCodeDirPath("ui/dialogfooter.php"));
?>