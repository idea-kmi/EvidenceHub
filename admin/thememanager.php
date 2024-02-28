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
    include_once("../config.php");

    $me = substr($_SERVER["PHP_SELF"], 1); // remove initial '/'
    if ($HUB_FLM->hasCustomVersion($me)) {
    	$path = $HUB_FLM->getCodeDirPath($me);
    	include_once($path);
		die;
	}

    checkLogin();
    array_push($HEADER,"<script src='".$CFG->homeAddress."ui/lib/scriptaculous/scriptaculous.js' type='text/javascript'></script>");

    include_once($HUB_FLM->getCodeDirPath("ui/dialogheader.php"));

    if($USER == null || $USER->getIsAdmin() == "N"){
        echo "<div class='errors'>.".$LNG->ADMIN_NOT_ADMINISTRATOR_MESSAGE."</div>";
        include_once($HUB_FLM->getCodeDirPath("ui/dialogfooter.php"));
        die;
	}

	//if($USER->userid != $CFG->ADMIN_USERID){
    //    echo "<div class='errors'>.".$LNG->ADMIN_NOT_ADMINISTRATOR_MESSAGE."</div>";
    //    include_once($HUB_FLM->getCodeDirPath("ui/dialogfooter.php"));
    //    die;
	//}

    $errors = array();

	$nodeid = optional_param("nodeid","",PARAM_TEXT);
	$name = optional_param("name","",PARAM_TEXT);
	$desc = optional_param("desc","",PARAM_HTML);

    if(isset($_POST["savetheme"])){
    	if ($nodeid != "") {
 	    	if ($name != "") {
				//become the theme admin user
				$currentuser = $USER;
				$themeadmin = new User($CFG->ADMIN_USERID);
				$themeadmin->load();
				$USER = $themeadmin;

	    		$r = getRoleByName('Theme');
				$roleType = $r->roleid;

				$nodeold = getNode($nodeid);
				$filename = "";
				if (isset($nodeold->filename)) {
					$filename = $nodeold->filename;
				}

           		$node = editNode($nodeid,$name,$desc,'N',$roleType,$filename, '');
				if (!$node instanceof Hub_Error) {

					$deleteimage = optional_param("imagedelete","N",PARAM_ALPHA);
					if ($deleteimage == 'Y') {
						$node->updateImage('');
					} else {
						if ($_FILES['image'.$nodeid]['error'] == 0) {
							$imagedir = $HUB_FLM->getUploadsNodeDir($nodeid);
							$image = uploadImageToFit('image'.$nodeid,$errors,$imagedir,$CFG->THEME_IMAGE_WIDTH, $CFG->THEME_IMAGE_HEIGHT);
							if($image != "") {
								$node->updateImage($image);
							}
						}
					}
				}

           		$USER = $currentuser;
	    	} else {
	            array_push($errors,$LNG->ADMIN_THEME_MISSING_NAME_ERROR);
	        }
    	} else {
            array_push($errors,$LNG->ADMIN_THEME_ID_ERROR);
    	}
    } else if(isset($_POST["addtheme"])){
    	if ($name != "") {
			//become the theme admin user
			$currentuser = $USER;
			$themeadmin = new User($CFG->ADMIN_USERID);
			$themeadmin->load();
			$USER = $themeadmin;

    		$r = getRoleByName('Theme');
    		$roleType = $r->roleid;

	       	$node = addNode($name, $desc, 'N',$roleType);

			if ($_FILES['image']['error'] == 0) {
				$imagedir = $HUB_FLM->getUploadsNodeDir($node->nodeid);
				$image = uploadImageToFit('image',$errors,$imagedir,$CFG->THEME_IMAGE_WIDTH, $CFG->THEME_IMAGE_HEIGHT);
				if($image != ""){
					$node->updateImage($image);
				}
			}

       		$USER = $currentuser;
    	} else {
            array_push($errors,$LNG->ADMIN_THEME_MISSING_NAME_ERROR);
        }
    } else if(isset($_POST["deletetheme"])){
    	if ($nodeid != "") {
			if (!adminDeleteTheme($nodeid)) {
				array_push($errors,$LNG->ADMIN_MANAGE_THEMES_DELETE_ERROR.' '.$nodeid);
			}
		} else {
			array_push($errors,$LNG->ADMIN_THEME_ID_ERROR);
		}
	}

	$ns = getNodesByGlobal(0,-1,'name','ASC', 'Theme', '', 'long');
    $nodes = $ns->nodes;
?>

<script type="text/javascript">

	function init() {
		$('dialogheader').insert('<?php echo $LNG->ADMIN_THEME_TITLE; ?>');
	}

   function deleteTheme(objno){
        var name = $('themelabelval'+objno).value;
        var answer = confirm("<?php echo $LNG->ADMIN_THEME_DELETE_QUESTION_PART1; ?> '"+name+"' <?php echo $LNG->ADMIN_THEME_DELETE_QUESTION_PART2; ?>");
        if(answer){
            var reqUrl = SERVICE_ROOT + "&method=deletenode&nodeid="+objno;

            new Ajax.Request(reqUrl, { method:'get',
                onSuccess: function(transport){
                    var json = transport.responseText.evalJSON();
                    if(json.error){
                        alert(json.error[0].message);
                        return;
                    }
                    alert("<?php echo $LNG->ADMIN_THEME_DELETE_SUCCESS_PART1; ?> "+name+" <?php echo $LNG->ADMIN_THEME_DELETE_SUCCESS_PART2; ?>");
                    window.location.href = "thememanager.php";
                }
            });

        }
    }

    function editTheme(objno){
    	cancelAddTheme();
   		cancelAllEdits();

        $('editthemeform'+objno).show();
        $('savelink'+objno).show();

        $('themelabeldiv'+objno).hide();
        $('editthemelink'+objno).hide();
        $('editlink'+objno).hide();
    }

    function cancelEditTheme(objno){
    	if ($('editthemeform'+objno)) {
         	$('editthemeform'+objno).hide();
    	}
    	if ($('savelink'+objno)) {
    		$('savelink'+objno).hide();
    	}

		if ($('themelabeldiv'+objno)) {
    		$('themelabeldiv'+objno).show();
    	}
    	if ($('editthemelink'+objno)) {
    		$('editthemelink'+objno).show();
    	}
    	if ($('editlink'+objno)) {
    		$('editlink'+objno).show();
    	}
    }

    function cancelAllEdits() {
		var array = document.getElementsByTagName('div');
		for(var i=0;i<array.length;i++) {
			if (array[i].id.startsWith('editthemeform')) {
				var objno = array[i].id.substring(13);
				cancelEditTheme(objno);
			}
		}
    }

   	function addTheme(){
   		cancelAllEdits();
    	$('newthemeform').show();
        $('addnewthemelink').hide();
	}

	function cancelAddTheme(){
        $('newthemeform').hide();
        $('addnewthemelink').show();
   	}

	window.onload = init;

	function checkFormDelete(name) {
        var ans = confirm("<?php echo $LNG->ADMIN_THEME_DELETE_QUESTION_PART1; ?> '"+name+"' <?php echo $LNG->ADMIN_THEME_DELETE_QUESTION_PART2; ?>");
		if (ans){
			return true;
		} else {
			return false;
		}
	}

</script>

<?php
if(!empty($errors)){
    echo "<div class='errors'>".$LNG->FORM_ERROR_MESSAGE.":<ul>";
    foreach ($errors as $error){
        echo "<li>".$error."</li>";
    }
    echo "</ul></div>";
}
?>


<div id="themesdiv" style="margin-left:10px;">

    <div class="formrow">
        <a id="addnewthemelink" href="javascript:addTheme()" class="form"><?php echo $LNG->ADMIN_THEME_ADD_NEW_LINK; ?></a>
    </div>

   <div id="newthemeform" class="formrow" style="display:none; clear:both;">
   		<form id="addtheme" name="addtheme" action="thememanager.php" method="post" enctype="multipart/form-data">
        <div class="subform" style="width: 620px;">

 			<div class='subformrow' style="margin-top:10px;">
 				<label class='formlabelmid' style="width: 75px" for='name'><?php echo $LNG->ADMIN_THEME_NAME_LABEL; ?></label>
 				<input type='text' class='forminput' style='width: 300px' id='name' name='name' value=''/>
 			</div>

			<div class="subformrow">
				<label class="formlabel" style="width: 75px" for="image"><?php echo $LNG->ADMIN_THEME_IMAGE_LABEL; ?></label>
				<input class="forminput" type="file" id="image" name="image" size="40">
			</div>
			<div class="subformrow">
				<label class="formlabel" style="width: 75px">&nbsp;</label>
				<span class="forminput"><?php echo $LNG->ADMIN_THEME_IMAGE_HELP; ?></span>
			</div>

            <div class='subformrow'>
				<label  class="formlabelbig" for="desc">
				<span style="vertical-align:top"><?php echo $LNG->ADMIN_THEME_DESC_LABEL; ?>
				<a id="editortogglebuttonadd" href="javascript:void(0)" style="vertical-align:top" onclick="switchCKEditorMode(this, 'textareadivadd', 'descadd')" title="<?php echo $LNG->FORM_DESC_HTML_TEXT_HINT; ?>"><?php echo $LNG->FORM_DESC_HTML_TEXT_LINK; ?></a>
				</span>
				</label>

				<div id="textareadivadd" style="clear:none;float:left;margin-top:5px;">
					<textarea rows="4" class="forminput hgrinput hgrwide" id="descadd" name="desc"></textarea>
				</div>
			</div>

            <div class="subformrow">
            	<input class="subformbutton" style="margin-left:30px; margin-top:5px;" type="submit" value="<?php echo $LNG->FORM_BUTTON_ADD; ?>" id="addtheme" name="addtheme">
                <input class="subformbutton" style="margin-left:7px;" type="button" name="cancelbutton" value="<?php echo $LNG->FORM_BUTTON_CANCEL; ?>" onclick="cancelAddTheme();">
            </div>
        </div>
        </form>
    </div>

    <div class="formrow">
        <div id="nodes" class="forminput">

        <?php
            echo "<table class='table' cellspacing='0' cellpadding='3' border='0' style='margin: 0px;'>";
            echo "<tr>";
            echo "<th width='450'>".$LNG->ADMIN_THEME_THEME_HEADING."</th>";
            echo "<th width='30'>".$LNG->ADMIN_THEME_ACTION_HEADING."</th>";
            echo "<th width='75'>".$LNG->ADMIN_THEME_ACTION_HEADING."</th>";

            echo "</tr>";
            foreach($nodes as $node){
                echo "<tr id='node-".$node->nodeid."'>";

                echo "<td id='second-".$node->nodeid."'>";

		        echo "<div class='subform' id='editthemeform".$node->nodeid."' style='width: 590px; display:none; clear:both;'>";
		   		echo '<form name="managetheme"'.$node->nodeid.' action="thememanager.php" method="post" enctype="multipart/form-data">';
		   		echo "<input name='nodeid' type='hidden' value='".$node->nodeid."' />";

		        echo "<div class='subformrow'>";

                echo "<div class='subformrow' style='margin-top:10px;'>";
		        echo "<label class='formlabel' style='width: 75px;' for='name'>".$LNG->FORM_LABEL_NAME."</label><input type='text' class='forminput' style='width:300px' id='name' name='name' value=\"".$node->name."\"/></div>";
				echo '</div>';

				if (isset($node->imageurlid) && $node->imageurlid != "") {
					echo '<div class="subformrow">';
					echo '	<label class="formlabel" style="width: 75px">'.$LNG->ADMIN_THEME_IMAGE_LABEL.'</label>';
					echo '	<div style="padding:0px;padding-left:8px;position:relative;overflow:hidden;width:'.$CFG->THEME_IMAGE_WIDTH.'px;height:'.$CFG->THEME_IMAGE_HEIGHT.';max-width:'.$CFG->THEME_IMAGE_WIDTH.'px;max-height:'.$CFG->THEME_IMAGE_HEIGHT.'px;min-width:'.$CFG->THEME_IMAGE_WIDTH.'px;min-height:'.$CFG->THEME_IMAGE_HEIGHT.'px;">';
					echo '		<img style="position:absolute; top:0px left:0px;cursor:move;" border="0" src="'.$node->imageurlid.'"/>';
					echo '	</div>';
					echo '</div>';
				}

				echo '<div class="subformrow">';
				if (isset($node->imageurlid) && $node->imageurlid != "") {
					echo '	<label class="formlabel" style="width: 75px" for="image'.$node->nodeid.'">'.$LNG->ADMIN_THEME_REPLACE_IMAGE_LABEL.'</label>';
				} else {
					echo '	<label class="formlabel" style="width: 75px" for="image'.$node->nodeid.'">'.$LNG->ADMIN_THEME_IMAGE_LABEL.'</label>';
				}
				echo '	<input class="forminput" type="file" id="image'.$node->nodeid.'" name="image'.$node->nodeid.'" size="40">';

				if (isset($node->imageurlid) && $node->imageurlid != "") {
					echo '<input id="imagedelete" class="forminput" type="checkbox" name="imagedelete" value="Y" /> '.$LNG->ADMIN_THEME_IMAGE_DELETE_LABEL;
				}

				echo '</div>';



				echo '<div class="subformrow">';
				echo '	<label class="formlabel" style="width: 75px">&nbsp;</label>';
				echo '	<span class="forminput">'.$LNG->ADMIN_THEME_IMAGE_HELP.'</span>';
				echo '</div>';

                echo "<div class='subformrow'>";
				echo '<label  class="formlabelbig" for="desc">';
				echo '<span style="vertical-align:top">'.$LNG->FORM_LABEL_DESC;
				echo '<a id="editortogglebutton" href="javascript:void(0)" style="vertical-align:top" onclick="switchCKEditorMode(this, \'textareadiv'.$node->nodeid.'\', \'desc'.$node->nodeid.'\')" title="'.$LNG->FORM_DESC_HTML_TEXT_HINT.'">'.$LNG->FORM_DESC_HTML_TEXT_LINK.'</a>';
				echo '</span>';
				echo '</label>';

				if (isProbablyHTML($node->description)) {
					 echo '<div id="textareadiv'.$node->nodeid.'" style="clear:both;float:left;margin-top:5px;">';
					 echo '	<textarea rows="4" class="ckeditor forminput hgrinput hgrwide" id="desc'.$node->nodeid.'" name="desc">'.$node->description.'</textarea>';
					 echo '</div>';
				} else {
					 echo '<div id="textareadiv'.$node->nodeid.'" style="clear:none;float:left;margin-top:5px;">';
					 echo '<textarea rows="4" class="forminput hgrinput hgrwide" id="desc'.$node->nodeid.'" name="desc">'.$node->description.'</textarea>';
					 echo '</div>';
				}

                echo "</div>";
 		        echo "<div class='subformrow' id='savelink".$node->nodeid."' style='display:none; clear:both;'>";
                echo '<input class="subformbutton" style="margin-left:30px;margin-top:5px;" type="submit" value="'.$LNG->FORM_BUTTON_SAVE.'" id="savetheme" name="savetheme" />';
                echo '<input class="subformbutton" style="margin-left:7px;" type="button" value="'.$LNG->FORM_BUTTON_CANCEL.'" onclick="javascript:cancelEditTheme(\''.$node->nodeid.'\');" />';
                echo '</div>';
                echo "</form>";
                echo "</div>";

                echo "<div id='themelabeldiv".$node->nodeid."'>";
		        echo "<span class='labelinput' style='width: 90%' id='nodelabel".$node->nodeid."'>".$node->name."</span>";
                echo "<input type='hidden' id='themelabelval".$node->nodeid."' value=\"".$node->name."\"/>";
		        echo "</div>";

                echo "</td>";

                echo "<td id='third-".$node->nodeid."'>";
                echo "<div id='editlink".$node->nodeid."'>";
  				echo "<a id='editthemelink".$node->nodeid."' href='javascript:editTheme(\"".$node->nodeid."\")' class='form'>".$LNG->ADMIN_THEME_EDIT_LINK."</a>";
                echo "</td>";

                echo "<td id='fourth-".$node->nodeid."'>";
				echo '<form id="delete-'.$node->nodeid.'" action="" enctype="multipart/form-data" method="post" onsubmit="return checkFormDelete(\''.htmlspecialchars($node->name).'\');">';
				echo '<input type="hidden" id="nodeid" name="nodeid" value="'.$node->nodeid.'" />';
				echo '<input type="hidden" id="deletetheme" name="deletetheme" value="" />';
				echo '<span class="active" onclick="if (checkFormDelete(\''.htmlspecialchars($node->name).'\')) { $(\'delete-'.$node->nodeid.'\').submit(); }" id="deletetheme" name="deletetheme">'.$LNG->ADMIN_THEME_DELETE_LINK.'</a>';
				echo '</form>';
                echo "</td>";

   				echo "</div>";
                echo "</td>";

                echo "</tr>";
            }
            echo "</table>";
        ?>
        </div>
   </div>

    <div class="formrow">
    <input type="button" value="<?php echo $LNG->FORM_BUTTON_CLOSE; ?>" onclick="window.close();"/>

    </div>

</div>


<?php
    include_once($HUB_FLM->getCodeDirPath("ui/dialogfooter.php"));
?>