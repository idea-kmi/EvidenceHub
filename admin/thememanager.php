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

    include_once($HUB_FLM->getCodeDirPath("ui/headeradmin.php"));

    if($USER == null || $USER->getIsAdmin() == "N"){
        echo "<div class='errors'>.".$LNG->ADMIN_NOT_ADMINISTRATOR_MESSAGE."</div>";
        include_once($HUB_FLM->getCodeDirPath("ui/footeradmin.php"));
        die;
	}

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

<div class="container-fluid">
	<div class="row p-4 pt-0">
		<div class="col">
			<script type="text/javascript">

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
					echo "<div class='alert alert-danger'>".$LNG->FORM_ERROR_MESSAGE.":<ul>";
					foreach ($errors as $error){
						echo "<li>".$error."</li>";
					}
					echo "</ul></div>";
				}
			?>

			<h1 class="mb-3"><?php echo $LNG->ADMIN_THEME_TITLE; ?></h1>

			<div id="themesdiv">
				<div class="mb-3 row">
					<div class="col-auto">
						<a id="addnewthemelink" href="javascript:addTheme()" class="form"><i class="fas fa-plus-square" aria-hidden="true"></i> <?php echo $LNG->ADMIN_THEME_ADD_NEW_LINK; ?></a>
					</div>
				</div>

				<div id="newthemeform" class="mb-3 row" style="display:none;">
					<form id="addtheme" name="addtheme" action="thememanager.php" method="post" enctype="multipart/form-data">
						<div class="subform p-4 mb-3 row">
							<div class="mb-3 row">
								<label class='col-sm-3 col-form-label'><?php echo $LNG->ADMIN_THEME_NAME_LABEL; ?></label>
								<div class="col-sm-9"><input type='text' class='form-control' id='name' name='name' value='' aria-label="add new theme - name" /></div>
							</div>
							<div class="mb-3 row">
								<label class="col-sm-3 col-form-label" for="image"><?php echo $LNG->ADMIN_THEME_IMAGE_LABEL; ?></label>
								<div class="col-sm-9">
									<input class="form-control" type="file" id="image" name="image" />
									<p class="text-end"><?php echo $LNG->ADMIN_THEME_IMAGE_HELP; ?></p>
								</div>
							</div>							
							<div class="mb-3 row">
								<label  class="col-sm-3 col-form-label" for="descadd">
									<?php echo $LNG->ADMIN_THEME_DESC_LABEL; ?><br />
									<a id="editortogglebuttonadd" href="javascript:void(0)" onclick="switchCKEditorMode(this, 'textareadivadd', 'descadd')" title="<?php echo $LNG->FORM_DESC_HTML_TEXT_HINT; ?>"><?php echo $LNG->FORM_DESC_HTML_TEXT_LINK; ?></a>								
								</label>
								<div id="textareadivadd" class="col-sm-9">
									<textarea rows="4" class="form-control" id="descadd" name="desc"></textarea>
								</div>
							</div>
							<div class="mb-3 row">
								<div class="d-grid gap-2 d-md-flex justify-content-md-center mb-3">
									<input class="btn btn-secondary" type="button" value="<?php echo $LNG->FORM_BUTTON_CANCEL; ?>" onclick="cancelAddTheme();" name="cancelbutton" />
									<input class="btn btn-primary" type="submit" value="<?php echo $LNG->FORM_BUTTON_ADD; ?>" id="addtheme" name="addtheme" />
								</div>
							</div>
						</div>
					</form>
				</div>

				<div class="row mb-3">
					<div id="nodes">					
						<table class='table table-sm'>
							<tr>
								<th><?php echo $LNG->ADMIN_THEME_THEME_HEADING; ?></th>
								<th width="100px"><?php echo $LNG->ADMIN_THEME_ACTION_HEADING; ?></th>
								<th width="100px"><?php echo $LNG->ADMIN_THEME_ACTION_HEADING; ?></th>
							</tr>
							<?php foreach($nodes as $node){ ?>
								<tr id='node-<?php echo $node->nodeid; ?>'>
									<td id='second-<?php echo $node->nodeid; ?>'>
										<div class='subform m-3 p-3' id='editthemeform<?php echo $node->nodeid; ?>' style='display:none;'>
											<form name='managetheme'<?php echo $node->nodeid; ?> action='thememanager.php' method='post' enctype='multipart/form-data'>
												<input name='nodeid' type='hidden' value='<?php echo $node->nodeid; ?>' />											
												<div class='mb-3 row'>
													<label class='col-sm-3 col-form-label'><?php echo $LNG->FORM_LABEL_NAME; ?></label>
													<div class='col-sm-9'><input type='text' class='form-control' id='name' name='name' aria-label="edit name for <?php echo $node->name; ?>" value="<?php echo $node->name; ?>"/></div>
												</div>

												<?php if (isset($node->imageurlid) && $node->imageurlid != "") { ?>												
													<div class="mb-3 row">
														<label class="col-sm-3 col-form-label"><?php echo $LNG->ADMIN_THEME_IMAGE_LABEL; ?></label>
														<div class="col-sm-9">
															<div style="width:<?php echo $CFG->THEME_IMAGE_WIDTH; ?>px; height:<?php echo $CFG->THEME_IMAGE_HEIGHT; ?>;">
																<img class="img-fluid" src="<?php echo $node->imageurlid; ?>" alt="" />
															</div>
														</div>
													</div>
												<?php  } ?>

												<div class="mb-3 row">
													<?php if (isset($node->imageurlid) && $node->imageurlid != "") { ?>
														<label class="col-sm-3 col-form-label" for="image<?php echo $node->nodeid; ?>"><?php echo $LNG->ADMIN_THEME_REPLACE_IMAGE_LABEL; ?></label>
													<?php } else { ?>
														<label class="col-sm-3 col-form-label" for="image<?php echo $node->nodeid; ?>"><?php echo $LNG->ADMIN_THEME_IMAGE_LABEL; ?></label>
													<?php } ?>
													<div class="col-sm-7">
														<input class="form-control" type="file" id="image<?php echo $node->nodeid; ?>" name="image<?php echo $node->nodeid; ?>" />
														<span><?php echo $LNG->ADMIN_THEME_IMAGE_HELP; ?></span>
													</div>

													<?php if (isset($node->imageurlid) && $node->imageurlid != "") { ?>
														<div class="col-sm-2">
															<div class="form-check pt-2">
																<label class="form-check-label">
																	<input class="form-check-input" type="checkbox" name="imagedelete" value="Y" id="imagedelete" aria-label="delete image imageurlid">
																	<?php echo $LNG->ADMIN_THEME_IMAGE_DELETE_LABEL; ?>
																</label>
															</div>
														</div>
													<?php } ?>
												</div>

												<div class="mb-3 row">
													<label class="col-sm-3 col-form-label" for="desc<?php echo $node->nodeid; ?>">
														<?php echo $LNG->FORM_LABEL_DESC; ?><br />
														<a id="editortogglebutton" href="javascript:void(0)" onclick="switchCKEditorMode(this, 'textareadiv<?php echo $node->nodeid; ?>', 'desc<?php echo $node->nodeid; ?>')" title="<?php echo $LNG->FORM_DESC_HTML_TEXT_HINT; ?>"><?php echo $LNG->FORM_DESC_HTML_TEXT_LINK; ?></a>
													</label>
													<?php if (isProbablyHTML($node->description)) { ?>
														<div id="textareadiv<?php echo $node->nodeid; ?>" class="col-sm-9">
															<textarea rows="4" class="ckeditor form-control" id="desc<?php echo $node->nodeid; ?>" name="desc"><?php echo $node->description; ?></textarea>
														</div>
													<?php } else { ?>
														<div id="textareadiv<?php echo $node->nodeid; ?>" class="col-sm-9">
															<textarea rows="4" class="form-control" id="desc<?php echo $node->nodeid; ?>" name="desc"><?php echo $node->description; ?></textarea>
														</div>
													<?php } ?>
												</div>
												
												<div class="mb-3 row" id="savelink<?php echo $node->nodeid; ?>" style="display:none; clear:both;">
													<div class="d-grid gap-2 d-md-flex justify-content-md-center mb-3">
														<input class="btn btn-secondary" type="button" value="<?php echo $LNG->FORM_BUTTON_CANCEL; ?>" onclick="cancelEditTheme('<?php echo $node->nodeid; ?>');" />
														<input class="btn btn-primary" type="submit" value="<?php echo $LNG->FORM_BUTTON_SAVE; ?>" id="savetheme" name="savetheme" />
													</div>
												</div>
											</form>
										</div>

										<div id='themelabeldiv<?php echo $node->nodeid; ?>'>
											<span class='labelinput' id='nodelabel<?php echo $node->nodeid; ?>'><?php echo $node->name; ?></span>
											<input type='hidden' id='themelabelval<?php echo $node->nodeid; ?>' value="<?php echo $node->name; ?>"/>
										</div>
									</td>

									<td id='third-<?php echo $node->nodeid; ?>'>
										<div id='editlink<?php echo $node->nodeid; ?>'>
											<a id='editthemelink<?php echo $node->nodeid; ?>' href='javascript:editTheme("<?php echo $node->nodeid; ?>")' class='form'><?php echo $LNG->ADMIN_THEME_EDIT_LINK; ?></a>
										</div>
									</td>

									<td id='fourth-<?php echo $node->nodeid; ?>'>
										<form id="delete-<?php echo $node->nodeid; ?>" action="" enctype="multipart/form-data" method="post" onsubmit="return checkFormDelete('<?php echo htmlspecialchars($node->name); ?>');">
											<input type="hidden" id="nodeid" name="nodeid" value="<?php echo $node->nodeid; ?>" />
											<input type="hidden" id="deletetheme" name="deletetheme" value="" />
											<span class="active" onclick="if (checkFormDelete('<?php echo htmlspecialchars($node->name); ?>')) { $('delete-<?php echo $node->nodeid; ?>').submit(); }" id="deletetheme" name="deletetheme"><?php echo $LNG->ADMIN_THEME_DELETE_LINK; ?></a>
										</form>
									</td>
								</tr>
							<?php } ?>
						</table>
					</div>
				</div>
			</div>					
		</div>
	</div>
</div>

<?php
    include_once($HUB_FLM->getCodeDirPath("ui/footeradmin.php"));
?>