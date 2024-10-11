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

	$nodeid = optional_param("nodeid","",PARAM_ALPHANUM);
	$name = optional_param("name","",PARAM_TEXT);
	$desc = optional_param("desc","",PARAM_HTML);

    if(isset($_POST["savenews"])){
    	if ($nodeid != "") {
 	    	if ($name != "") {
				//become the news admin user
				$currentuser = $USER;
				$admin = new User($CFG->ADMIN_USERID);
				$admin->load();
				$USER = $admin;

	    		$r = getRoleByName('News');
				$roleType = $r->roleid;
           		$node = editNode($nodeid,$name,$desc,'N',$roleType);

           		$USER = $currentuser;
	    	} else {
	            array_push($errors,$LNG->ADMIN_NEWS_MISSING_NAME_ERROR);
	        }
    	} else {
            array_push($errors,$LNG->ADMIN_NEWS_ID_ERROR);
    	}
    } else if(isset($_POST["addnews"])){
    	if ($name != "") {
			//become the news admin user
			$currentuser = $USER;
			$admin = new User($CFG->ADMIN_USERID);
			$admin->load();
			$USER = $admin;

    		$r = getRoleByName('News');
    		$roleType = $r->roleid;
	       	$node = addNode($name, $desc, 'N',$roleType);

       		$USER = $currentuser;
    	} else {
            array_push($errors,$LNG->ADMIN_NEWS_MISSING_NAME_ERROR);
        }
    } else if(isset($_POST["deletenews"])){
    	if ($nodeid != "") {
			if (!adminDeleteNews($nodeid)) {
				array_push($errors,$LNG->ADMIN_MANAGE_NEWS_DELETE_ERROR.' '.$nodeid);
			}
		} else {
			array_push($errors,$LNG->ADMIN_NEWS_ID_ERROR);
		}
	}

	$ns = getNodesByGlobal(0,-1,'name','ASC', 'News', '', 'long');
    $nodes = $ns->nodes;
?>

<div class="container-fluid">
	<div class="row p-4 pt-0">
		<div class="col">
			<script type="text/javascript">
				function editNews(objno){
					cancelAddNews();
					cancelAllEdits();
					$('editnewsform'+objno).show();
					$('savelink'+objno).show();
					$('newslabeldiv'+objno).hide();
					$('editnewslink'+objno).hide();
					$('editlink'+objno).hide();
				}

				function cancelEditNews(objno){
					if ($('editnewsform'+objno)) {
						$('editnewsform'+objno).hide();
					}
					if ($('savelink'+objno)) {
						$('savelink'+objno).hide();
					}
					if ($('newslabeldiv'+objno)) {
						$('newslabeldiv'+objno).show();
					}
					if ($('editnewslink'+objno)) {
						$('editnewslink'+objno).show();
					}
					if ($('editlink'+objno)) {
						$('editlink'+objno).show();
					}
				}

				function cancelAllEdits() {
					var array = document.getElementsByTagName('div');
					for(var i=0;i<array.length;i++) {
						if (array[i].id.startsWith('editnewsform')) {
							var objno = array[i].id.substring(13);
							cancelEditNews(objno);
						}
					}
				}

				function addNews(){
					cancelAllEdits();
					$('newnewsform').show();
					$('addnewnewslink').hide();
				}

				function cancelAddNews(){
					$('newnewsform').hide();
					$('addnewnewslink').show();
				}

				window.onload = init;

				function checkFormDelete(name) {
					var ans = confirm("<?php echo $LNG->ADMIN_NEWS_DELETE_QUESTION_PART1; ?> '"+name+"' <?php echo $LNG->ADMIN_NEWS_DELETE_QUESTION_PART2; ?>");
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

			<h1 class="mb-3"><?php echo $LNG->ADMIN_NEWS_TITLE; ?></h1>

			<div id="newsdiv">
				<div class="mb-3 row">
					<div class="col-auto">
						<a id="addnewnewslink" href="javascript:addNews()" class="form"><i class="fas fa-plus-square" aria-hidden="true"></i> <?php echo $LNG->ADMIN_NEWS_ADD_NEW_LINK; ?></a>
					</div>
				</div>

				<div id="newnewsform" class="mb-3 row" style="display:none;">
					<form id="addnews" name="addnews" action="newsmanager.php" method="post" enctype="multipart/form-data">
						<div class="subform p-4 mb-3 row">
							<div class='mb-3 row'>
								<label class='col-sm-3 col-form-label'><?php echo $LNG->ADMIN_NEWS_NAME_LABEL; ?></label>
								<div class="col-sm-9"><input type='text' class='form-control' id='name' name='name' value='' aria-label="add News Article - name" /></div>
							</div>
							<div class='mb-3 row'>
								<label class="col-sm-3 col-form-label" for="descadd">
									<?php echo $LNG->ADMIN_NEWS_DESC_LABEL; ?><br />
									<a id="editortogglebuttonadd" href="javascript:void(0)" onclick="switchCKEditorMode(this, 'textareadivadd', 'descadd')" title="<?php echo $LNG->FORM_DESC_HTML_TEXT_HINT; ?>"><?php echo $LNG->FORM_DESC_HTML_TEXT_LINK; ?></a>
								</label>
								<div id="textareadivadd" class="col-sm-9">
									<textarea rows="4" class="form-control" id="descadd" name="desc"></textarea>
								</div>
							</div>
							<div class="mb-3 row">
								<div class="d-grid gap-2 d-md-flex justify-content-md-center mb-3">
									<input class="btn btn-secondary" type="button" name="cancelbutton" value="<?php echo $LNG->FORM_BUTTON_CANCEL; ?>" onclick="cancelAddNews();" />
									<input class="btn btn-primary" type="submit" value="<?php echo $LNG->FORM_BUTTON_ADD; ?>" id="addnews" name="addnews" />
								</div>
							</div>
						</div>
					</form>
				</div>

				<div class="mb-3 row">
					<div id="nodes">					
						<table class='table table-sm'>
							<tr>
								<th><?php echo $LNG->ADMIN_NEWS_TITLE_HEADING; ?></th>
								<th width="100px"><?php echo $LNG->ADMIN_NEWS_ACTION_HEADING; ?></th>
								<th width="100px"><?php echo $LNG->ADMIN_NEWS_ACTION_HEADING; ?></th>
							</tr>
							<?php foreach($nodes as $node){ ?>
								<tr id='node-<?php echo $node->nodeid; ?>'>
									<td id='second-<?php echo $node->nodeid; ?>'>
										<div class='subform m-3 p-3' id='editnewsform<?php echo $node->nodeid; ?>' style='display:none;'>

											<form name='managenews'<?php echo $node->nodeid; ?> action='newsmanager.php' method='post' enctype='multipart/form-data'>
												<input name='nodeid' type='hidden' value='<?php echo $node->nodeid; ?>' />											
												<div class='mb-3 row'>
													<label class='col-sm-3 col-form-label'><?php echo $LNG->FORM_LABEL_NAME; ?></label>
													<div class='col-sm-9'><input type='text' class='form-control' id='name' name='name' aria-label="edit name for <?php echo $node->name; ?>" value="<?php echo $node->name; ?>"/></div>
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
														<input class="btn btn-secondary" type="button" value="<?php echo $LNG->FORM_BUTTON_CANCEL; ?>" onclick="cancelEditNews('<?php echo $node->nodeid; ?>');" />
														<input class="btn btn-primary" type="submit" value="<?php echo $LNG->FORM_BUTTON_SAVE; ?>" id="savenews" name="savenews" />
													</div>
												</div>
											</form>
										</div>

										<div id='newslabeldiv<?php echo $node->nodeid; ?>'>
											<span class='labelinput' id='nodelabel<?php echo $node->nodeid; ?>'><?php echo $node->name; ?></span>
											<input type='hidden' id='newslabelval<?php echo $node->nodeid; ?>' value="<?php echo $node->name; ?>"/>
										</div>
									</td>

									<td id='third-<?php echo $node->nodeid; ?>'>
										<div id='editlink<?php echo $node->nodeid; ?>'>
											<a id='editnewslink<?php echo $node->nodeid; ?>' href='javascript:editNews("<?php echo $node->nodeid; ?>")' class='form'><?php echo $LNG->ADMIN_NEWS_EDIT_LINK; ?></a>
										</div>
									</td>

									<td id='fourth-<?php echo $node->nodeid; ?>'>
										<form id="delete-<?php echo $node->nodeid; ?>" action="" enctype="multipart/form-data" method="post" onsubmit="return checkFormDelete(\'<?php echo htmlspecialchars($node->name); ?>');">
											<input type="hidden" id="nodeid" name="nodeid" value="<?php echo $node->nodeid; ?>" />
											<input type="hidden" id="deletenews" name="deletenews" value="" />
											<span class="active" onclick="if (checkFormDelete('<?php echo htmlspecialchars($node->name); ?>')) { $('delete-<?php echo $node->nodeid; ?>').submit(); }" id="deletenews" name="deletenews"><?php echo $LNG->ADMIN_NEWS_DELETE_LINK; ?></a>
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