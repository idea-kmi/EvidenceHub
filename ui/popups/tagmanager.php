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

    $errors = array();

	$tagid = optional_param("tagid","",PARAM_ALPHANUM);
	$tagname = optional_param("tagname","",PARAM_TEXT);

    if(isset($_POST["savetag"])){
    	if ($tagid != "") {
            $origtag = getTag($tagid);
 	    	if ($tagname != "") {
                $result = editTag($tagid, $tagname);
                if ($result instanceof Hub_Error) {
	            	array_push($errors,$result->message);
                }
	    	} else {
	            array_push($errors,$LNG->FORM_TAG_MANAGER_NAME_ERROR);
	        }
    	} else {
            array_push($errors,$LNG->FORM_TAG_MANAGER_TAGID_ERROR);
    	}
    }

    $ts = getUserTags();
    $tags = $ts->tags;
?>

<script type="text/javascript">

	function init() {
	  	$('dialogheader').insert('<?php echo $LNG->FORM_TAG_MANAGER_TITLE; ?>');
	}

   	function deleteTag(objno){
        var name = $('taglabelval'+objno).value;
        var message = "<?php echo $LNG->FORM_TAG_MANAGER_DELETE_MESSAGE_PART1; ?> \'";
        message += name;
        message += "\' <?php echo $LNG->FORM_TAG_MANAGER_DELETE_MESSAGE_PART2; ?>";
        var answer = confirm(message);
        if(answer){
            var reqUrl = SERVICE_ROOT + "&method=deletetag&tagid="+objno;

            new Ajax.Request(reqUrl, { method:'get',
                onSuccess: function(transport){
                    var json = transport.responseText.evalJSON();
                    if(json.error){
                        alert(json.error[0].message);
                        return;
                    }
                    window.location.href = "<?php echo $CFG->homeAddress; ?>ui/popups/tagmanager.php";
                }
            });
        }
    }

	function viewTagUsage(objno) {
        var name = $('taglabelval'+objno).value;
		loadDialog('tagusageviewer','<?php echo $CFG->homeAddress; ?>ui/popups/tagusageviewer.php?tagid='+objno+'&tagname='+name);
	}

    function editTag(objno){
   		cancelAllEdits();

        $('edittagform'+objno).show();
        $('savelink'+objno).show();

        $('taglabeldiv'+objno).hide();
        $('edittaglink'+objno).hide();
        $('editlink'+objno).hide();
    }

    function cancelEditTag(objno){
         $('edittagform'+objno).hide();
         if ($('savelink'+objno)) {
        	 $('savelink'+objno).hide();
         }

       	 $('taglabeldiv'+objno).show();
         if ($('edittaglink'+objno)) {
        	 $('edittaglink'+objno).show();
         }
         if ($('editlink'+objno)) {
        	 $('editlink'+objno).show();
         }
    }

    function cancelAllEdits() {
    	var array = document.getElementsByTagName('div');
    	for(var i=0;i<array.length;i++) {
    		if (array[i].id.startsWith('edittagform')) {
    			var objno = array[i].id.substring(11);
    			cancelEditTag(objno);
    		}
    	}
    }

    window.onload = init;

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

<div id="tagsdiv">
    <div class="formrow">
        <div id="tags" class="forminput">
        <?php
            echo "<table class='table' cellspacing='0' cellpadding='3' border='1' style='margin: 0px;'>";

        echo "<tr>";
            echo "<th width='330'>".$LNG->FORM_TAG_MANAGER_NAME_LABEL."</th>";
            echo "<th width='170'>".$LNG->FORM_TAG_MANAGER_ACTIONS_LABEL."</th>";
            echo "</tr>";

            foreach($tags as $tag){
                echo "<tr id='tag-".$tag->tagid."'>";
                echo "<td id='second-".$tag->tagid."'>";

		        echo "<div class='subform' id='edittagform".$tag->tagid."' style='width: 310px; display:none; clear:both;'>";
		   		echo '<form name="managetags"'.$tag->tagid.' action="tagmanager.php" method="post" enctype="multipart/form-data">';
		   		echo "<input name='tagid' type='hidden' value='".$tag->tagid."' />";
		        echo "<div class='subformrow'><label class='formlabel' style='width: 50px' for='tagname'>".$LNG->FORM_TAG_MANAGER_NAME_LABEL."</label><input type='text' class='forminput' size='35' id='tagname' name='tagname' value=\"".$tag->name."\"/></div>";
  		        echo "<div class='subformrow' id='savelink".$tag->tagid."' style='display:none; clear:both;'>";
                echo '<input class="subformbutton" style="margin-left:54px;" type="submit" value="'.$LNG->FORM_BUTTON_SAVE.'" id="savetag" name="savetag" />';
                echo '<input class="subformbutton" style="margin-left:7px;" type="button" value="'.$LNG->FORM_BUTTON_CANCEL.'" onclick="javascript:cancelEditTag(\''.$tag->tagid.'\');" />';
                echo '</div>';
                echo "</form>";
                echo "</div>";

                echo "<div id='taglabeldiv".$tag->tagid."'>";
		        echo "<span class='labelinput' style='width: 90%' id='taglabel".$tag->tagid."'>".$tag->name."</span>";
                echo "<input type='hidden' id='taglabelval".$tag->tagid."' value=\"".$tag->name."\"/>";
		        echo "</div>";

                echo "</td>";

                echo "<td id='third-".$tag->tagid."'>";
                echo "<div id='editlink".$tag->tagid."'>";
				echo "<a id='edittaglink".$tag->tagid."' href='javascript:editTag(\"".$tag->tagid."\")' class='form'>".$LNG->FORM_TAG_MANAGER_EDIT_LINK."</a><span style='margin-left:7px;margin-right:7px;'>|</span>";
 				echo "<a id='viewtagusage".$tag->tagid."' href='javascript:viewTagUsage(\"".$tag->tagid."\")' class='form'>".$LNG->FORM_TAG_MANAGER_VIEW_USAGE_LINK."</a><span style='margin-left:7px;margin-right:7px;'>|</span>";
 				echo "<a id='deletetaglink".$tag->tagid."' href='javascript:deleteTag(\"".$tag->tagid."\")' class='form'>".$LNG->FORM_TAG_MANAGER_DELETE_LINK."</a>";
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