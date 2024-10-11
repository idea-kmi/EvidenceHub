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

    if(isset($_POST["deletenode"])){
		$nodeid = optional_param("nodeid","",PARAM_ALPHANUM);
    	if ($nodeid != "") {
    		$node = new CNode($nodeid);
	   		$node->delete();
    	} else {
            array_push($errors,$LNG->SPAM_ADMIN_ID_ERROR);
    	}
    } else if(isset($_POST["restorenode"])){
		$nodeid = optional_param("nodeid","",PARAM_ALPHANUM);
    	if ($nodeid != "") {
    		$node = new CNode($nodeid);
	   		$node->updateStatus($CFG->STATUS_ACTIVE);
    	} else {
            array_push($errors,$LNG->SPAM_ADMIN_ID_ERROR);
    	}
    }

	$ns = getNodesByStatus($CFG->STATUS_SPAM, 0,-1,'name','ASC','long');
    $nodes = $ns->nodes;

    $count = count($nodes);
    for ($i=0; $i<$count;$i++) {
    	$node = $nodes[$i];
    	$reporterid = getSpamReporter($node->nodeid);
    	if ($reporterid != false) {
    		$reporter = new User($reporterid);
    		$reporter = $reporter->load();
    		$node->reporter = $reporter;
    	}
    }

?>

<div class="container-fluid">
	<div class="row p-4 pt-0">
		<div class="col">
			<script type="text/javascript">				
				function getParentWindowHeight(){
					var viewportHeight = 900;
					if (window.opener.innerHeight) {
						viewportHeight = window.opener.innerHeight;
					} else if (window.opener.document.documentElement && document.documentElement.clientHeight) {
						viewportHeight = window.opener.document.documentElement.clientHeight;
					} else if (window.opener.document.body)  {
						viewportHeight = window.opener.document.body.clientHeight;
					}
					return viewportHeight;
				}

				function getParentWindowWidth(){
					var viewportWidth = 700;
					if (window.opener.innerHeight) {
						viewportWidth = window.opener.innerWidth;
					} else if (window.opener.document.documentElement && document.documentElement.clientHeight) {
						viewportWidth = window.opener.document.documentElement.clientWidth;
					} else if (window.opener.document.body)  {
						viewportWidth = window.opener.document.body.clientWidth;
					}
					return viewportWidth;
				}

				function viewSpamUserDetails(userid) {
					var width = window.screen.width - 400;
					var height = window.screen.height - 400;

					loadDialog('user', URL_ROOT+"user.php?userid="+userid, width, height);
				}

				function viewSpamItemDetails(nodeid, nodetype) {
					var width = window.screen.width - 400;
					var height = window.screen.height - 400;

					loadDialog('details', URL_ROOT+"explore.php?id="+nodeid, width, height);
				}

				function checkFormRestore(name) {
					var ans = confirm("<?php echo $LNG->SPAM_ADMIN_RESTORE_CHECK_MESSAGE; ?>\n\n"+name+"\n\n");
					if (ans){
						return true;
					} else {
						return false;
					}
				}

				function checkFormDelete(name) {
					var ans = confirm("<?php echo $LNG->SPAM_ADMIN_DELETE_CHECK_MESSAGE; ?>\n\n"+name+"\n\n");
					if (ans){
						return true;
					} else {
						return false;
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

			<h1 class="mb-3"><?php echo $LNG->SPAM_ADMIN_TITLE; ?></h1>

			<div id="spamdiv">
				<div class="mb-3 row">
					<div id="nodes">
						<?php if (count($nodes) == 0) { ?>
							<p><?php echo $LNG->SPAM_ADMIN_NONE_MESSAGE; ?></p>
						<?php } else { ?>
							<table class='table table-sm'>
								<tr>
									<th width='50%'><?php echo $LNG->SPAM_ADMIN_TABLE_HEADING1; ?></th>
									<th width='10%'><?php echo $LNG->SPAM_ADMIN_TABLE_HEADING2; ?></th>
									<th width='10%'><?php echo $LNG->SPAM_ADMIN_TABLE_HEADING2; ?></th>
									<th width='10%'><?php echo $LNG->SPAM_ADMIN_TABLE_HEADING2; ?></th>
									<th width='20%'><?php echo $LNG->SPAM_ADMIN_TABLE_HEADING0; ?></th>
								</tr>

								<?php foreach($nodes as $node){ ?>
									<tr>
										<td>
											<?php echo $node->name; ?>
										</td>
										<td>
											<a class="active" onclick="viewSpamItemDetails('<?php echo $node->nodeid; ?>', '<?php echo $node->role->name; ?>');"><?php echo $LNG->SPAM_ADMIN_VIEW_BUTTON; ?></a>
										</td>
										<td>
											<form id="second-<?php echo $node->nodeid; ?>" action="" enctype="multipart/form-data" method="post" onsubmit="return checkFormRestore('<?php echo htmlspecialchars($node->name); ?>');">
												<input type="hidden" id="nodeid" name="nodeid" value="<?php echo $node->nodeid; ?>" />
												<input type="hidden" id="restorenode" name="restorenode" value="" />
												<a class="active" onclick="if (checkFormRestore('<?php echo htmlspecialchars($node->name); ?>')){ $('second-<?php echo $node->nodeid; ?>').submit(); }" id="restorenode" name="restorenode"><?php echo $LNG->SPAM_ADMIN_RESTORE_BUTTON; ?></a>
											</form>
										</td>
										<td>
											<form id="third-<?php echo $node->nodeid; ?>" action="" enctype="multipart/form-data" method="post" onsubmit="return checkFormDelete('<?php echo htmlspecialchars($node->name); ?>');">
												<input type="hidden" id="nodeid" name="nodeid" value="<?php echo $node->nodeid; ?>" />
												<input type="hidden" id="deletenode" name="deletenode" value="" />
												<a class="active" onclick="if (checkFormDelete('<?php echo htmlspecialchars($node->name); ?>')) { $('third-<?php echo $node->nodeid; ?>').submit(); }" id="deletenode" name="deletenode"><?php echo $LNG->SPAM_ADMIN_DELETE_BUTTON; ?></a>
											</form>
										</td>
										<td>
											<?php if (isset($node->reporter)) { ?>
												<a href="<?= $CFG->homeAddress ?>user.php?userid=<?= $node->reporter->userid ?>" class="active" target="_blank"><?= $node->reporter->name ?></a>
											<?php } else {										
												echo $LNG->CORE_UNKNOWN_USER_ERROR;
											} ?>
										</td>
									</tr>
								<?php } ?>
							</table>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php
    include_once($HUB_FLM->getCodeDirPath("ui/footeradmin.php"));
?>