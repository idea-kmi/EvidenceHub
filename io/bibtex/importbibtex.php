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

    include_once($HUB_FLM->getCodeDirPath("ui/dialogheader.php"));
    include_once($HUB_FLM->getCodeDirPath("io/ioutillib.php"));
    include_once($HUB_FLM->getCodeDirPath("io/bibtex/bibtexlib.php"));

    // check that user not already logged in
    if(!isset($USER->userid)){
        header('Location: index.php');
        return;
    }
    global $CFG, $USER, $LNG;

 	$themesarray = optional_param("themesarray","",PARAM_TEXT);

    echo '<h1 style="margin-left:20px;">'.$LNG->IMPORT_BIBTEX_TITLE.' <span style="margin-left: 10px;font-size:60%; font-weight:normal">(<a target="_blank" href="'.$CFG->homeAddress.'help/bibtextimport.php">'.$LNG->IMPORT_BIBTEX_HELP_LINK.'</a>)</span></h1>';

    $errors = array();

    //if submitted then process the file
    if(isset($_POST["import"])){
        //upload the file
        if ($_FILES["bibtexfile"]['name'] != "") {

            //$ext = pathinfo($_FILES['bibtexfile']['name'], PATHINFO_EXTENSION);
//			if ($ext != 'bib') {
//                 array_push($errors, $LNG->IMPORT_BIBTEX_TYPE_ERROR);
//			}

            if(empty($errors)){
				$target_path = $CFG->workdir;
				$dt = time();

				//replace any non alphanum chars in filename
				$filename = $USER->userid ."_". $dt ."_". basename( preg_replace('/([^A-Za-z0-9.])/i', '',$_FILES["bibtexfile"]['name']));
				$target_path = $target_path . $filename;

				if(!move_uploaded_file($_FILES["bibtexfile"]['tmp_name'], $target_path)) {
					array_push($errors, $LNG->IMPORT_BIBTEX_FILE_UPLOAD_ERROR);
				}

				if(empty($errors)){
					$results = array();
					importBibtex($target_path,$themesarray,$errors,$results);

					if (empty($errors)){
						echo "<div class='results' style='margin-left:20px;'>".$LNG->IMPORT_BIBTEX_SUCCESS_MESSAGE."<ul>";
						foreach ($results as $result){
							echo "<li>".$result."</li>";
						}
						echo "</ul></div>";

						echo "<a style='margin-left:20px;' href='".$CFG->homeAddress."user.php?userid=".$USER->userid."#data-resource'>".$LNG->IMPORT_BIBTEX_GOTO_RESOURCES."</a>";

						include_once($HUB_FLM->getCodeDirPath("ui/dialogfooter.php"));
						die;
					}
				}

				//delete the file
				unlink($target_path);
			}
        } else {
        	array_push($errors, $LNG->IMPORT_BIBTEX_NO_FILE);
    	}
    }

	include($HUB_FLM->getCodeDirPath("ui/popuplib.php"));
?>

<?php
    if(!empty($errors)){
        echo "<div class='errors'>".$LNG->IMPORT_BIBTEX_PROBLEMS_ERROR."<ul>";
        foreach ($errors as $error){
            echo "<li>".$error."</li>";
        }
        echo "</ul></div>";
    }
?>

<script type="text/javascript">

var noThemes = <?php echo count($themesarray);?>;

function checkThemeChange(num) {
	var selected = $('theme'+num+'menu').value;
	if (selected != "" && num == noThemes-1) {
		noThemes = addTheme(noThemes);
		$('theme'+noThemes+'menu').focus();
	}
}

function checkForm() {
	if ($('theme0menu').value == "") {
	   	alert("<?php echo $LNG->FORM_ERROR_THEME; ?>");
	   	return false;
    }

	$('mainform').style.display = "none";
	$('loadingdiv').style.display = "block";

    $('bibtextform').style.cursor = 'wait';

	return true;
}

</script>

<form id="bibtextform" action="" method="post" enctype="multipart/form-data" onsubmit="return checkForm();">

	<div style="display:block" id="mainform">
		<div style="float:left;margin:20px;"><?php echo $LNG->IMPORT_BIBTEX_FORM_MESSAGE; ?>
		<br><?php echo $LNG->IMPORT_BIBTEX_REQUIRED_FIELDS_MESSAGE_PART1; ?> <span style="font-size:14pt;margin-top:3px;vertical-align:top; font-weight:bold;color:red;">*</span> <?php echo $LNG->IMPORT_BIBTEX_REQUIRED_FIELDS_MESSAGE_PART2; ?>
		</div>

		<div class="formrow">
			<label class="formlabelbig" for="bibtexmlfile"><?php echo $LNG->IMPORT_BIBTEX_FILE_LABEL; ?>
			<span style="font-size:14pt;margin-top:3px;vertical-align:middle;color:red;">*</span></label>
			<input class="forminputmust hgrinput hgrwide" id="bibtexfile" name="bibtexfile" type="file" size="40">
		</div>

		<?php insertThemes('BibtexTheme'); ?>

		<div class="formrow">
			<input class="formsubmit" type="submit" value="<?php echo $LNG->IMPORT_BIBTEX_IMPORT_BUTTON; ?>" id="import" name="import">
		</div>
	</div>

	<div style="display:none; margin-left:20px;margin-top:20px" id="loadingdiv">
		<img src='<?php echo $HUB_FLM->getImagePath('ajax-loader.gif'); ?>'/>
 		&nbsp;<?php echo $LNG->IMPORT_BIBTEX_LOADING_DATA; ?>
	</div>
</form>


<?php
    include_once($HUB_FLM->getCodeDirPath("ui/dialogfooter.php"));
?>
