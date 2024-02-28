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


/**
 * Add a list of themes to the given node
 *
 * @param string $node, the node to connect the themes to
 * @param array $themesarray, an array of theme names to connect.
 * @param string $private, "Y" if the connection is private or "N" if it is public
 */
function connectThemesToNode($node,$themesarray,$private){
	global $CFG, $USER;

	if (isset($themesarray) && $themesarray != "") {

		$currentUser = $USER;

		// in case not owned by current user - always fetch again
		$role = getRoleByName($node->role->name);
		$roleID = $role->roleid;

		// create Admin user object
		$adminUserID = $CFG->ADMIN_USERID;
		$adminUser = new User($adminUserID);
		$adminUser->load();

		$USER = $adminUser;
		$r = getRoleByName("Theme");
		$roleTheme = $r->roleid;

		$USER = $currentUser;

		$r = getRoleByName("Theme");
		$roleThemeAuthor = $r->roleid;

		$lt = getLinkTypeByLabel($CFG->LINK_NODE_THEME);
		$linkMainTheme = $lt->linktypeid;

		foreach($themesarray as $item){
			if ($item && $item != "") {
				// GET / CREATE THEME NODE AS ADMIN
				$USER = $adminUser;
				$nextnode = addNode($item,"", 'N', $roleTheme);

				// CREATE CONNECTION FROM PARENT NODE TO THEME NODE
				$USER = $currentUser;

				$nexttag2 = addTag($item);
				$connection = addConnection($node->nodeid, $roleID, $linkMainTheme, $nextnode->nodeid, $roleThemeAuthor, $private);
				$connection->addTag($nexttag2->tagid);
			}
		}

		$USER = $currentUser;
	}
}

/**
 * Connect a node to the chat is was built from
 *
 * @param object $node, the node to connect the chat node
 * @param string $chatnodeid, the node id of the chat node to connect the node to
 * @param string $chatparentid, the parent chat node id of the chat node to connect the node to
 * @param string $private, "Y" if the connection is private or "N" if it is public
 *
 * @return Node or Error
 */
function connectBuiltFromChatNode($node, $chatnodeid, $chatparentid, $private) {
	global $CFG;

	// Add a see also to the chat comment node this was cread from if chatnodeid exists
	if ($chatnodeid != "") {
		// get the current users role id for the nodetype regardless of the parent node owner
		$role = getRoleByName($node->role->name);
		$roleID = $role->roleid;

		$chatnode = getNode($chatnodeid);
		$chatrolename = $chatnode->role->name;

		$r = getRoleByName($chatrolename);
		$roleCommentID = $r->roleid;

		$lt = getLinkTypeByLabel($CFG->LINK_COMMENT_BUILT_FROM);
		$linkCommentID = $lt->linktypeid;

		$connection = addConnection($node->nodeid, $roleID, $linkCommentID, $chatnodeid, $roleCommentID, $private, $chatparentid);
	}
}

/**
 * Connect a list of nodes to the given parent node
 *
 * @param string $parentnode, the node to connect the nodes to
 * @param array $nodearray, and array of nodeids to connct to the parent node
 * @param string $linktypename, the name of the linktype to use
 * @param string $direction, linking 'from'/'to' the parent node
 * @param string $private, "Y" if the connection is private or "N" if it is public
 *
 * @return Node or Error
 */
function connectNodesToNode($parentnode,$nodearray,$linktypename,$direction, $private) {

	$lt = getLinkTypeByLabel($linktypename);
	$linktypeid = $lt->linktypeid;

	// must get the role id for the current user
	$role = getRoleByName($parentnode->role->name);
	$roleID = $role->roleid;

	foreach($nodearray as $nodeid){

		if (isset($nodeid) && $nodeid != "") {
			$nextnode = getNode($nodeid);

			// must get the role id for the current user
			$role = getRoleByName($nextnode->role->name);
			$nextRoleID = $role->roleid;

			if (!$nextnode instanceof HUB_ERROR) {

				// if 'from' the connections are from the parent node to the child nodes,
				// else if 'to' the connections are from the child nodes to the parent node.
				if ($direction == 'from') {
					$connection = addConnection($parentnode->nodeid, $roleID, $linktypeid, $nodeid, $nextRoleID, $private);
				} else {
					$connection = addConnection($nodeid, $nextRoleID, $linktypeid, $parentnode->nodeid, $roleID, $private);
				}
			}
		}
	}

	$parentnode;
}

/**
 * Remove a list of tags from the given node
 *
 * @param object $node, the node to remove tags from
 * @param array $tags, and array of tagids to remove from the node
 *
 * @return Node or Error
 */
function removeTagsFromNode($node, $removetagsarray) {
	if($removetagsarray != "" && is_countable($removetagsarray) && count($removetagsarray) > 0){
		for($i=0; $i<count($removetagsarray); $i++){
			if($removetagsarray[$i] != ""){
				$node->removeTag($removetagsarray[$i]);
			}
		}
	}
}

/**
 * Connect a list of tags to the given node
 *
 * @param object $node, the node to connect the tags to
 * @param array $tags, and array of tag names to connect to the node
 *
 * @return Node or Error
 */
function addTagsToNode($node, $tags) {
	$newtagsarray = explode(',', $tags);
	if(count($newtagsarray) != 0){
		foreach($newtagsarray as $tagname){
			if (isset($tagname) && $tagname != "") {
				$tag = addTag($tagname);
				if (!$tag instanceof HUB_ERROR && isset($tag) && isset($tag->tagid)) {
					$node->addTag($tag->tagid);
				}
			}
		}
	}
}

/**
 * Connect a list of resources to the given node
 *
 * @param string $node, the node to connect the resources to
 * @param string $error, an error array, that may be added to and is returned at the end
 * @param array $resourcenodeidsarray, and array of resource ids to connect to the node
 * @param array $resourcetypesarray, and array of resource types to connect to the node
 * @param array $resourceurlarray, and array of resource urls to connect to the node
 * @param array $resourcetitlearray, and array of resource titles to connect to the node
 * @param array $identifierarray, and array of resource identifiers
 * @param array $themesarray, an array of theme names to connect to the new resource nodes.
 * @param array $tags, and array of tag names to connect to the node
 * @param string $private, "Y" if the nodes and connections are private or "N" if they are public
 *
 * @return $errors array
 */
function addResourcesToNode($node,$errors,$resourcenodeidsarray, $resourcetypesarray, $resourceurlarray, $resourcetitlearray, $identifierarray, $themesarray, $tags, $private) {
	global $LNG, $CFG, $USER;

	$lt = getLinkTypeByLabel('is related to');
	$linkRelated = $lt->linktypeid;

	// must get the role id for the current user
	$role = getRoleByName($node->role->name);
	$roleID = $role->roleid;

	$i = 0;
	foreach($resourcetypesarray as $resourcetype) {

		// connect exisitng resource
		if (isset($resourcenodeidsarray[$i]) && $resourcenodeidsarray[$i] != "") {

			$refnode = getNode($resourcenodeidsarray[$i]);
			$r = getRoleByName($refnode->role->name);
			$refRoleID = $r->roleid;

			$connection = addConnection($refnode->nodeid, $refRoleID, $linkRelated, $node->nodeid, $roleMainAuthor, $private);

		} else { // create and connect new resources

			$r = getRoleByName($resourcetype);
			$refRoleID = $r->roleid;

			$resourceurl = trim($resourceurlarray[$i]);
			$resourcetitle = trim($resourcetitlearray[$i]);

			// If they have entered nothing, don't do anything.
			if ($resourcetitle == "" && ($resourceurl == "http://" || $resourceurl == "")) {
				break;
			}

			//check all fields entered
			if ($resourcetitle != "" && ($resourceurl == "http://" || $resourceurl == "")){
				array_push($errors, $LNG->FORM_RESOURCE_URL_REQUIRED);
				break;
			}
			$URLValidator = new mrsnk_URL_validation($resourceurl, MRSNK_URL_DO_NOT_PRINT_ERRORS, MRSNK_URL_DO_NOT_CONNECT_2_URL);
			if($resourceurl != "" && !$URLValidator->isValid()){
				 array_push($errors, $LNG->FORM_RESOURCE_URL_FORMAT_ERROR);
				 break;
			}

			if ($resourcetitle == ""){
				$resourcetitle = $resourceurl;
			}

			$refnode = addNode($resourceurl, $resourcetitle, $private, $refRoleID);
			if (!$refnode instanceof Hub_Error) {

				if ($CFG->autoFollowingOn) {
					addFollowing($refnode->nodeid);
				}

				if ($resourcetype == 'Publication') {
					$refnode->updateAdditionalIdentifier($identifierarray[$i]);
				}

				// ADD URL TO REF and ORG
				$clip = "";
				$clippath = "";
				$identifier="";
				if (isset($resourcecliparray[$i])) {
					$clip = $resourcecliparray[$i];
				}
				if (isset($resourceclippatharray[$i])) {
					$clippath = $resourceclippatharray[$i];
				}
				if (isset($identifierarray[$i])) {
					$identifier= $identifierarray[$i];
				}

				$urlObj = addURL($resourceurl, $resourcetitle, "", $private, $clip, $clippath, "", "cohere", $identifier);
				$refnode->addURL($urlObj->urlid, "");

				// CONNECT RESOURCE NOD TO MAIN NODE
				$connection = addConnection($refnode->nodeid, $refRoleID, $linkRelated, $node->nodeid, $roleID, $private);

				// ADD THEMES TO RESOURCE NODE
				if (isset($themesarray) && $themesarray != "") {
					connectThemesToNode($refnode, $themesarray, $private);
				}

				// ADD TAGS TO RESOURCE NODE
				addTagsToNode($refnode, $tags);

			} else {
				array_push($errors,$LNG->FORM_RESOURCE_CREATE_ERROR_MESSAGE." ".$refrole->message);
			}
		}

		$i++;
	}

	return $errors;
}

function insertFormHeaderMessage() {
	global $LNG; ?>
	<p style="clear:both;margin-left: 10px;"><?php echo $LNG->FORM_HEADER_MESSAGE; ?>
	<br><?php echo $LNG->FORM_REQUIRED_FIELDS_MESSAGE_PART1; ?> <span style="font-size:14pt;margin-top:3px;vertical-align:top; font-weight:bold;color:red;">*</span> <?php echo $LNG->FORM_REQUIRED_FIELDS_MESSAGE_PART2; ?><?php echo $LNG->FORM_REQUIRED_FIELDS_MESSAGE_PART3; ?>
	</p>
<?php }

function insertFormHeaderMessageShort() {
	global $LNG; ?>
	<p style="clear:both;margin-left: 10px;"><?php echo $LNG->FORM_HEADER_MESSAGE; ?>
	<br><?php echo $LNG->FORM_REQUIRED_FIELDS_MESSAGE_PART1; ?> <span style="font-size:14pt;margin-top:3px;vertical-align:top; font-weight:bold;color:red;">*</span> <?php echo $LNG->FORM_REQUIRED_FIELDS_MESSAGE_PART2; ?><?php echo $LNG->FORM_REQUIRED_FIELDS_MESSAGE_PART4; ?>
	</p>
<?php }

function insertFormQuickHeaderMessage() {
	global $LNG; ?>
	<p style="clear:both;margin-left: 10px;"><?php echo $LNG->FORM_QUICK_HEADER_MESSAGE; ?>
	<br><?php echo $LNG->FORM_QUICK_REQUIRED_FIELDS_MESSAGE_PART1; ?> <span style="font-size:14pt;margin-top:3px;vertical-align:top; font-weight:bold;color:red;">*</span> <?php echo $LNG->FORM_QUICK_REQUIRED_FIELDS_MESSAGE_PART2; ?>
	</p>
<?php }

function insertSummary($hintname, $title = "") {
	global $summary, $CFG, $LNG, $HUB_FLM;
	if ($title == "") {
		$title = $LNG->FORM_LABEL_SUMMARY;
	}
	?>
   <div class="hgrformrow" id="summarydiv">
		<label  class="formlabelbig" for="summary"><span style="vertical-align:top"><?php echo $title; ?></span>
			<span class="active" onMouseOver="showFormHint('<?php echo $hintname; ?>', event, 'hgrhint'); return false;" onMouseOut="hideHints(); return false;" onClick="hideHints(); return false;" onkeypress="enterKeyPressed(event)"><img src="<?php echo $HUB_FLM->getImagePath('info.png'); ?>" border="0" style="margin-top: 2px; margin-left: 5px; margin-right: 2px;" /></span>
			<span style="font-size:14pt;margin-top:3px;vertical-align:middle;color:red;">*</span>
		</label>
		<input class="forminputmust hgrinput hgrwide" id="summary" name="summary" value="<?php echo( $summary ); ?>" />
	</div>
<?php }

function insertComment($hintname) {
	global $desc, $CFG, $LNG, $HUB_FLM; ?>
    <div class="hgrformrow" id="descdiv">
		<label  class="formlabelbig" for="desc">
			<span style="vertical-align:top"><?php echo $LNG->FORM_LABEL_COMMENT; ?>
			<a id="editortogglebutton" href="javascript:void(0)" style="vertical-align:top" onclick="switchCKEditorMode(this, 'textareadiv', 'desc')" title="<?php echo $LNG->FORM_DESC_HTML_TEXT_HINT; ?>"><?php echo $LNG->FORM_DESC_HTML_TEXT_LINK; ?></a>
			</span>
            <span class="active" onMouseOver="showFormHint('<?php echo $hintname; ?>', event, 'hgrhint'); return false;" onMouseOut="hideHints(); return false;" onClick="hideHints(); return false;" onkeypress="enterKeyPressed(event)"><img src="<?php echo $HUB_FLM->getImagePath('info.png'); ?>" border="0" style="margin-top: 2px; margin-left: 5px; margin-right: 2px;" /></span>
			<span style="font-size:14pt;margin-top:3px;vertical-align:middle;color:red;">*</span>
		</label>
		<?php if (isProbablyHTML($desc)) { ?>
			<div id="textareadiv" style="clear:both;float:left;">
				<textarea rows="4" class="ckeditor forminput hgrinput hgrwide" id="desc" name="desc"><?php echo( $desc ); ?></textarea>
			</div>
		<?php } else { ?>
			<div id="textareadiv" style="clear:none;float:left;">
				<textarea rows="12" class="forminput hgrinput hgrwide" id="desc" name="desc"><?php echo( $desc ); ?></textarea>
			</div>
		<?php } ?>
	</div>
<?php }

function insertDescription($hintname) {
	global $desc, $CFG, $LNG, $HUB_FLM; ?>
    <div class="hgrformrow" id="descdiv">
		<label  class="formlabelbig" for="desc">
			<span style="vertical-align:top"><?php echo $LNG->FORM_LABEL_DESC; ?>
			<a id="editortogglebutton" href="javascript:void(0)" style="vertical-align:top" onclick="switchCKEditorMode(this, 'textareadiv', 'desc')" title="<?php echo $LNG->FORM_DESC_HTML_TEXT_HINT; ?>"><?php echo $LNG->FORM_DESC_HTML_TEXT_LINK; ?></a>
			</span>
			<span class="active" onMouseOver="showFormHint('<?php echo $hintname; ?>', event, 'hgrhint'); return false;" onMouseOut="hideHints(); return false;" onClick="hideHints(); return false;" onkeypress="enterKeyPressed(event)"><img src="<?php echo $HUB_FLM->getImagePath('info.png'); ?>" border="0" style="margin-top: 2px; margin-left: 5px; margin-right: 2px;" /></span>
			<span style="font-size:14pt;margin-top:3px;vertical-align:middle;color:white;">*</span>
		</label>
		<?php if (isProbablyHTML($desc)) { ?>
			<div id="textareadiv" style="clear:both;float:left;">
				<textarea rows="4" class="ckeditor forminput hgrinput hgrwide" id="desc" name="desc"><?php echo( $desc ); ?></textarea>
			</div>
		<?php } else { ?>
			<div id="textareadiv" style="clear:none;float:left;">
				<textarea rows="4" class="forminput hgrinput hgrwide" id="desc" name="desc"><?php echo( $desc ); ?></textarea>
			</div>
		<?php } ?>
	</div>
<?php }

function insertDescriptionMulti($idtext, $idname, $hintname) {
	global $CFG, $LNG, $HUB_FLM; ?>
    <div class="hgrformrow">
		<label  class="formlabelbig" for="desc">
			<span style="vertical-align:top"><?php echo $LNG->FORM_LABEL_DESC; ?>
			<a id="editortogglebutton<?php echo $idname;?>" href="javascript:void(0)" style="vertical-align:top" onclick="switchCKEditorMode(this, 'textareadiv<?php echo $idname; ?>', '<?php echo $idname; ?>')" title="<?php echo $LNG->FORM_DESC_HTML_TEXT_HINT; ?>"><?php echo $LNG->FORM_DESC_HTML_TEXT_LINK; ?></a>
			</span>
			<span class="active" onMouseOver="showFormHint('<?php echo $hintname; ?>', event, 'hgrhint'); return false;" onMouseOut="hideHints(); return false;" onClick="hideHints(); return false;" onkeypress="enterKeyPressed(event)"><img src="<?php echo $HUB_FLM->getImagePath('info.png'); ?>" border="0" style="margin-top: 2px; margin-left: 5px; margin-right: 2px;" /></span>
			<span style="font-size:14pt;margin-top:3px;vertical-align:middle;color:white;">*</span>
		</label>
		<?php if (isProbablyHTML($idtext)) { ?>
			<div id="textareadiv<?php echo $idname; ?>" style="clear:both;float:left;">
				<textarea rows="4" class="ckeditor forminput hgrinput hgrwide" id="<?php echo $idname; ?>" name="<?php echo $idname; ?>"><?php echo( $idtext ); ?></textarea>
			</div>
		<?php } else { ?>
			<div id="textareadiv<?php echo $idname; ?>" style="clear:none;float:left;">
				<textarea rows="4" class="forminput hgrinput hgrwide" id="<?php echo $idname; ?>" name="<?php echo $idname; ?>"><?php echo( $idtext ); ?></textarea>
			</div>
		<?php } ?>
	</div>
<?php }

function insertReason($hintname) {
	global $focalnode, $conndesc, $CFG, $LNG, $HUB_FLM; ?>
    <div class="hgrformrow" id="reasondiv">
		<label  class="formlabelbig" for="desc"><span style="vertical-align:top"><?php echo $LNG->FORM_RELEVANCE_LABEL; ?><br>"<?php if (strlen($focalnode->name) > 50) { echo addslashes(substr($focalnode->name, 0, 50))."..."; } else { echo addslashes($focalnode->name); } ?>" ?:</span>
			<span class="active" onMouseOver="showFormHint('<?php echo $hintname; ?>', event, 'hgrhint', '<?php echo addslashes($focalnode->name);?>'); return false;" onMouseOut="hideHints(); return false;" onClick="hideHints(); return false;" onkeypress="enterKeyPressed(event)"><img src="<?php echo $HUB_FLM->getImagePath('info.png'); ?>" border="0" style="margin-top: 2px; margin-left: 5px; margin-right: 2px;" /></span>
		</label>
		<textarea rows="4" class="forminput hgrinput hgrwide" id="conndesc" name="conndesc"><?php echo( $conndesc ); ?></textarea>
	</div>
<?php }


function insertUrl($hintname) {
	global $url, $CFG, $LNG, $HUB_FLM; ?>

	<div class="formrow" id="urldiv">
		<label  class="formlabelbig" for="url"><span style="vertical-align:top"><?php echo $LNG->FORM_LABEL_URL; ?></span>
			<span class="active" onMouseOver="showFormHint('<?php echo $hintname; ?>', event, 'hgrhint'); return false;" onMouseOut="hideHints(); return false;" onClick="hideHints(); return false;" onkeypress="enterKeyPressed(event)"><img src="<?php echo $HUB_FLM->getImagePath('info.png'); ?>" border="0" style="margin-top: 2px; margin-left: 5px; margin-right: 2px;" /></span>
			<span style="font-size:14pt;margin-top:3px;vertical-align:middle;color:red;">*</span>
		</label>
     	<input class="forminputmust inputshort" id="url" name="url" value="<?php echo( htmlspecialchars($url) ); ?>">
		<img class="active" style="vertical-align: middle; padding-bottom: 2px;" title="<?php echo $LNG->FORM_AUTOCOMPLETE_TITLE_HINT; ?>" src="<?php echo $HUB_FLM->getImagePath('autofill.png'); ?>" onClick="autoCompleteWebsiteDetails()" onkeypress="enterKeyPressed(event)" />
    </div>
<?php }


function insertTitle($hintname) {
	global $title, $CFG, $LNG, $HUB_FLM; ?>

    <div class="formrow" id="titlediv">
		<label  class="formlabelbig" for="title"><span style="vertical-align:top"><?php echo $LNG->FORM_LABEL_TITLE; ?></span>
			<span class="active" onMouseOver="showFormHint('<?php echo $hintname; ?>', event, 'hgrhint'); return false;" onMouseOut="hideHints(); return false;" onClick="hideHints(); return false;" onkeypress="enterKeyPressed(event)"><img src="<?php echo $HUB_FLM->getImagePath('info.png'); ?>" border="0" style="margin-top: 2px; margin-left: 5px; margin-right: 2px;" /></span>
			<span style="font-size:14pt;margin-top:3px;vertical-align:middle;color:red;">*</span>
		</label>
        <input class="forminputmust input" id="title" name="title" value="<?php echo( $title ); ?>">
    </div>
<?php }


function insertDOI($hintname) {
	global $identifier, $nodetypename, $CFG, $LNG, $HUB_FLM; ?>

    <div id='identifierdiv' class="formrow" style="display: <?php if (isset($nodetypename) && $nodetypename == 'Publication') { echo 'block'; }  else { echo 'none'; } ?>">
		<label  class="formlabelbig" for="identifier"><span style="vertical-align:top"><?php echo $LNG->FORM_LABEL_DOI; ?>
			<span class="active" onMouseOver="showFormHint('<?php echo $hintname; ?>', event, 'hgrhint'); return false;" onMouseOut="hideHints(); return false;" onClick="hideHints(); return false;" onkeypress="enterKeyPressed(event)"><img src="<?php echo $HUB_FLM->getImagePath('info.png'); ?>" border="0" style="margin-top: 2px; margin-left: 5px; margin-right: 2px;" /></span>
		</label>
        <input class="forminput input" id="identifier" name="identifier" value="<?php echo( $identifier ); ?>">
    </div>
<?php }


function insertThemes($hintname, $theme="") {
	global $themesarray, $CFG, $LNG, $HUB_FLM;
?>
   <div class="hgrformrow" id="themediv">
		<div style="display: block; float:left">
			<label  class="formlabelbig" for="url"><span style="vertical-align:top"><?php echo $LNG->FORM_LABEL_THEME; ?></span>
			    <span class="active" onMouseOver="showFormHint('<?php echo $hintname; ?>', event, 'hgrhint'); return false;" onMouseOut="hideHints(); return false;" onClick="hideHints(); return false;" onkeypress="enterKeyPressed(event)"><img src="<?php echo $HUB_FLM->getImagePath('info.png'); ?>" border="0" style="margin-top: 2px; margin-left: 5px; margin-right: 2px;" /></span>
				<span style="font-size:14pt;margin-top:3px;vertical-align:middle;color:red;">*</span>
			</label>
	        <div class="hgrsubform" id="themeform" style="background: lightyellow">
	  			<?php
	  				$count = 1; // needs to add at least one on new add form
	  				if (is_countable($themesarray)) {
	  					$count = count($themesarray);
	  				}
	                for($i=0; $i<$count; $i++){
	                    if($i != 0){
	                        echo '<hr id="themehr<?php echo $i; ?>" class="urldivider"/>';
	                    }
	            ?>

	            <div id="themefield<?php echo $i; ?>" class="subformrow">
					<select class="subforminput hgrselect" <?php if (isset($theme) && $theme !="") { echo "disabled"; } ?> onchange="checkThemeChange('<?php echo $i; ?>')" id="theme<?php echo $i; ?>menu" name="themesarray[]">
				        <option value="" ><?php echo $LNG->THEME_NAME; ?>...</option>
				    	<?php
				    		foreach($CFG->THEMES as $item){?>
				    	        <option value='<?php echo addslashes($item); ?>' <?php if (isset($themesarray[$i]) && $themesarray[$i] == $item) { echo 'selected=\"true\"'; } ?> ><?php echo $item ?></option>
					    <?php } ?>
				    </select>
				    <?php if ($theme == "") { ?>
		    			<a href="javascript:removeMultiple('theme', <?php echo $i; ?>)" class="form" style="margin-left: 5px;"><?php echo $LNG->FORM_BUTTON_REMOVE; ?></a>
		    		<?php } else { ?>
		    			<div class="form" style="clear:both"></div>
		    		<?php }  ?>
				</div>
	            <?php
		           }
		        ?>
			</div>
	        <div class="formrow">
	    		<span class="formsubmit form active" style="margin-left: 190px;" onclick="noThemes = addTheme(noThemes);"><?php echo $LNG->FORM_BUTTON_ADD_ANOTHER." ".$LNG->THEME_NAME; ?></span>
	    	</div>
		</div>
	</div>
<?php }


function insertAddTags($hintname) {
	global $CFG, $newtags, $LNG, $HUB_FLM; ?>

    <div class="hgrformrow" style="margin-bottom: 10px;" id="tagsdiv">
        <label class="formlabelbig" for="newtags"><span style="vertical-align:top"><?php echo $LNG->FORM_LABEL_TAGS; ?></span>
            <span class="active" onMouseOver="showFormHint('<?php echo $hintname; ?>', event, 'hgrhint'); return false;" onMouseOut="hideHints(); return false;" onClick="hideHints(); return false;" onkeypress="enterKeyPressed(event)"><img src="<?php echo $HUB_FLM->getImagePath('info.png'); ?>" border="0" style="margin-top: 2px; margin-left: 5px; margin-right: 2px;" /></span>
        </label>
   		<input class="forminput" style="width:290px; font-size: 10pt;" id="newtags" name="newtags" value="<?php echo $newtags; ?>" /> <?php echo $LNG->FORM_LABEL_TAGS_HINT; ?>
    </div>
<?php }


function insertTagsAdded($hintname) {

	global $CFG, $LNG, $tags, $removetagsarray, $HUB_FLM;

	if (is_countable($tags) && count($tags) > 0) { ?>
		<div class="hgrformrow" id="tagaddeddiv">
			<label class="formlabelbig" for="newtags"><span style="vertical-align:top"><?php echo $LNG->FORM_LABEL_ADDED_TAGS; ?></span>
				<span class="active" onMouseOver="showFormHint('<?php echo $hintname; ?>', event, 'hgrhint'); return false;" onMouseOut="hideHints(); return false;" onClick="hideHints(); return false;" onkeypress="enterKeyPressed(event)"><img src="<?php echo $HUB_FLM->getImagePath('info.png'); ?>" border="0" style="margin-top: 2px; margin-left: 5px; margin-right: 2px;" /></span>
			</label>
			<div class="subform" id="tagform">
			<?php
					$i = 0;
					foreach($tags as $tag){
					  $class = "subforminput";
					  echo '<div id="tagfield'.$i.'" class="subformrow">';
					  echo '<input type="checkbox" class="'.$class.'" id="removetags" name="removetags[]" value="'.$tag->tagid.'"';
					  if(is_countable($removetagsarray) && count($removetagsarray) > 0){
						  for($j=0; $j<count($removetagsarray); $j++){
							  if (isset($removetagsarray[$j]) && $removetagsarray[$j] != ""
								  && $removetagsarray[$j] == $tag->tagid) {
								  echo ' checked="true"';
								  break;
							  }
						  }
					  }
					  echo '>&nbsp;&nbsp;'.$tag->name.'<br/>';
					  echo '</div>';
					  $i++;
				  }
			  ?>
				 <label><?php echo $LNG->FORM_LABEL_ADDED_TAGS_HINT; ?></label>
			</div>
		</div>
	<?php }
}

/**
 * Insert the project dates form fields
 * @param hintname the string representing the key to call the rollover hint for the field.
 */
function insertProjectDates($hintname) {
	global $CFG,$LNG, $sdt,$edt, $HUB_FLM; ?>

    <div id="datediv" class="hgrformrow" style="display: block;">
		<label  class="formlabelbig" for="startdate"><?php echo $LNG->FORM_LABEL_PROJECT_STARTED_DATE; ?>
			<a href="javascript:void(0)" onMouseOver="showFormHint('<?php echo $hintname; ?>', event, 'hgrhint'); return false;" onMouseOut="hideHints(); return false;" onClick="hideHints(); return false;" onkeypress="enterKeyPressed(event)"><img src="<?php echo $HUB_FLM->getImagePath('info.png'); ?>" border="0" style="margin-top: 2px; margin-left: 5px; margin-right: 2px;" /></a>
		</label>
		<input class="forminput dateinput" id="startdate" name="startdate" value="<?php if($sdt){echo date('d M Y G:i',$sdt);} ?>">
        <img src="<?php echo $CFG->homeAddress; ?>ui/lib/datetimepicker/images2/cal.gif" onclick="javascript:NewCssCal('<?php echo $CFG->homeAddress; ?>ui/lib/datetimepicker/images2/','startdate','DDMMMYYYY')" style="cursor:pointer"/>

		<label style="padding-left:10px;" for="enddate"><b> <?php echo $LNG->FORM_LABEL_PROJECT_ENDED_DATE; ?> </b></label>
		<input class="dateinput" id="enddate" name="enddate" value="<?php if($edt){echo date('d M Y G:i',$edt);} ?>">
        <img src="<?php echo $CFG->homeAddress; ?>ui/lib/datetimepicker/images2/cal.gif" onclick="javascript:NewCssCal('<?php echo $CFG->homeAddress; ?>ui/lib/datetimepicker/images2/','enddate','DDMMMYYYY')" style="cursor:pointer"/>
	</div>
<?php }

/**
 * Inser the location form fields
 * @param hintstem the string representing the type of item. Used to form the hint rolloever key.
 */
function insertLocation($hintstem) {
	global $CFG, $LNG, $address1, $address2, $city, $postcode, $orgcountry, $countries, $HUB_FLM;?>

	<div id="locationdiv">
		<label class="formlabelbig"><span style="vertical-align:top"><?php echo $LNG->FORM_LABEL_LOCATION; ?></span></label>
		<div id="address1div" class="hgrformrow">
			<div style="display: block; clear:both;float:left">
				<label class="formlabelbig" for="address1"><span style="vertical-align:top"><?php echo $LNG->FORM_LABEL_ADDRESS1; ?></span></label>
				<input class="forminput" id="address1" name="address1" style="width:250px;" value="<?php echo $address1; ?>">
			</div>
		</div>
		<div id="address2div" class="hgrformrow">
			<div style="display: block; float:left">
				<label class="formlabelbig" for="address2"><span style="vertical-align:top"><?php echo $LNG->FORM_LABEL_ADDRESS2; ?></span></label>
				<input class="forminput" id="address2" name="address2" style="width:250px;" value="<?php echo $address2; ?>">
			</div>
		</div>
		<div id="citydiv" class="hgrformrow">
			<div style="display: block; float:left">
				<label class="formlabelbig" for="city"><span style="vertical-align:top"><?php echo $LNG->FORM_LABEL_TOWN; ?></span>
					<span class="active" onMouseOver="showFormHint('<?php echo $hintstem; ?>Town', event, 'hgrhint'); return false;" onMouseOut="hideHints(); return false;" onClick="hideHints(); return false;" onkeypress="enterKeyPressed(event)"><img src="<?php echo $HUB_FLM->getImagePath('info.png'); ?>" border="0" style="margin-top: 2px; margin-left: 5px; margin-right: 2px;" /></span>
				</label>
				<input class="forminput" id="city" name="city" style="width:250px;" value="<?php echo $city; ?>">
			</div>
		</div>
		<div id="postcodediv" class="hgrformrow">
			<div style="display: block; float:left">
				<label class="formlabelbig" for="postcode"><span style="vertical-align:top"><?php echo $LNG->FORM_LABEL_POSTAL_CODE; ?></span></label>
				<input class="forminput" id="postcode" name="postcode" style="width:250px;" value="<?php echo $postcode; ?>">
			</div>
		</div>
		<div id="countrydiv" class="hgrformrow">
			<div style="display: block; float:left">
				<label class="formlabelbig" for="orgcountry"><span style="vertical-align:top"><?php echo $LNG->FORM_LABEL_COUNTRY; ?></span>
					<span class="active" onMouseOver="showFormHint('<?php echo $hintstem; ?>Country', event, 'hgrhint'); return false;" onMouseOut="hideHints(); return false;" onClick="hideHints(); return false;" onkeypress="enterKeyPressed(event)"><img src="<?php echo $HUB_FLM->getImagePath('info.png'); ?>" border="0" style="margin-top: 2px; margin-left: 5px; margin-right: 2px;" /></span>
				</label>
				<select class="forminput" id="orgcountry" name="orgcountry" style="margin-left: 5px;width:160px;">
					<option value="" ><?php echo $LNG->FORM_LABEL_COUNTRY_CHOICE; ?></option>
					<?php
						foreach($countries as $code=>$c){
							echo "<option value='".$code."'";
							if($code == $orgcountry || ($orgcountry == "" && $c == $CFG->defaultcountry)){
								echo " selected='true'";
							}
							echo ">".$c."</option>";
						}
					?>
				</select>
			</div>
		</div>
	</div>
<?php }

function insertChallenges($hintname, $withLabel) {
	global $CFG,$LNG, $focalnodeid, $LNG, $HUB_FLM;

    $challengeset = getNodesByGlobal(0, -1 ,'name', 'ASC', "Challenge", "", 'short',"",'all');
	$challanges = $challengeset->nodes;

	if ($withLabel) { ?>
		<label id="challengelabel" style="float:left; margin-top:10px;"><span style="vertical-align:top;"><?php echo $LNG->FORM_LABEL_CHALLENGES_TOGGLE; ?></span>
			<span class="active" onMouseOver="showFormHint('<?php echo $hintname; ?>', event, 'hgrhint'); return false;" onMouseOut="hideHints(); return false;" onClick="hideHints(); return false;" onkeypress="enterKeyPressed(event)"><img src="<?php echo $HUB_FLM->getImagePath('info.png'); ?>" border="0" style="margin-top: 2px; margin-left: 5px; margin-right: 2px;" /></span>
			<img style="vertical-align: bottom" id="groupsimg" src="<?php echo $HUB_FLM->getImagePath('arrow-down-blue.png'); ?>" onclick="javascript: toggleChallenges()" border="0" alt="<?php echo $LNG->CHALLENGES_NAME; ?>" />
		</label>
	<?php } ?>

	<?php if (!$withLabel) { ?>
		<div style="float:left;height:10px;"></div>
	<?php } ?>


 	<div class="formrow" id="challengediv">
		<div id="groupsdiv" style="display: <?php if ($withLabel) { echo 'none'; } else { echo 'block'; }?>">

			<?php if ($withLabel) { ?>
				<label  class="formlabelbig" for="challengeschoices"><?php echo $LNG->FORM_LABEL_CHALLENGES; ?></label>
			<?php } ?>

			<?php if (!$withLabel) { ?>
				<label class="formlabelbig" for="challengeschoices"><span style="vertical-align:top"><?php echo $LNG->CHALLENGES_NAME; ?>:</span>
					<span class="active" onMouseOver="showFormHint('<?php echo $hintname; ?>', event, 'hgrhint'); return false;" onMouseOut="hideHints(); return false;" onClick="hideHints(); return false;" onkeypress="enterKeyPressed(event)"><img src="<?php echo $HUB_FLM->getImagePath('info.png'); ?>" border="0" style="margin-top: 2px; margin-left: 5px; margin-right: 2px;" /></span>
				</label>
			<?php } ?>

			<div class="subform hgrwide" id="challengeschoices">
			<?php
                $i = 0;
                foreach($challanges as $challenge){
                	if ($focalnodeid != $challenge->nodeid) {
						echo '<div class="subformrow">';
						echo "<input type='checkbox' class='subforminput' id='challenges' name='challenges[]' value='".$challenge->nodeid."'";
						echo ">".$challenge->name."<br/>";
						echo '</div>';
						$i++;
					}
                }
	         ?>
	         </div>
         </div>
    </div>
<?php }

function insertResourceForm($hintname, $title = "") {
	global $CFG, $LNG, $HUB_FLM, $resourceurlarray, $resourcetypesarray, $resourcetitlearray, $identifierarray, $resourcenodeidsarray, $resourcecliparray, $resourceclippatharray;

	if ($title == "") {
		$title = $LNG->FORM_LABEL_RESOURCES;
	}
	?>

    <div class="hgrformrow" id="resourceformrow">
		<div id="resourcediv" style="display: block; float:left;margin-bottom:10px;">

			<label  class="formlabelbig" for="resourceform"><?php echo $title; ?>
			    <a href="javascript:void(0)" onMouseOver="showFormHint('<?php echo $hintname; ?>', event, 'hgrhint'); return false;" onMouseOut="hideHints(); return false;" onClick="hideHints(); return false;" onkeypress="enterKeyPressed(event)"><img src="<?php echo $HUB_FLM->getImagePath('info.png'); ?>" border="0" style="margin-top: 2px; margin-left: 5px; margin-right: 2px;" /></a>
			</label>

	        <div class="hgrsubform" id="resourceform">
	            <?php
	            	// if no resources, popuplate the first empty one ready to be filled in
	            	if ($resourceurlarray == "") {
	            		$resourceurlarray = array();
	            		$resourceurlarray[0] = "https://";
	            	}

	            	$count = 0;
	            	if (is_countable($resourceurlarray)) {
	            		$count = count($resourceurlarray);
	            	}

	                for($i=0; $i<$count; $i++){
	                    if($i != 0){
	                        echo '<hr id="resourcehr<?php echo $i; ?>" class="urldivider"/>';
	                    }
	            ?>
	                <div id="resourcefield<?php echo $i; ?>" class="subformrow">

					   <input type="hidden" id="resourcenodeidsarray-<?php echo $i; ?>" name="resourcenodeidsarray[]" value="<?php if (isset($resourcecliparray[$i])) { echo $resourcenodeidsarray[$i]; } ?>" />
					   <input type="hidden" id="resourcecliparray-<?php echo $i; ?>" name="resourcecliparray[]" value="<?php if (isset($resourcecliparray[$i])) { echo $resourcecliparray[$i]; } ?>" />
					   <input type="hidden" id="resourceclippatharray-<?php echo $i; ?>" name="resourceclippatharray[]" value="<?php if (isset($resourcecliparray[$i])) { echo $resourceclippatharray[$i]; } ?>" />

					   <div class="hgrformrow" id="typehiddendiv-<?php echo $i; ?>" style="display:none">
							<label  class="hgrsubformlabel" for="connection-<?php echo $i; ?>"><?php echo $LNG->FORM_LABEL_TYPE; ?></label>
							<select disabled onchange="typeChangedResource('<?php echo $i; ?>')" class="subforminput hgrselect" style="width: 172px" id="resource<?php echo $i; ?>label" name="resourcetypeslabelarray[]">
						    	<?php
									$countj = 0;
									if (is_countable($CFG->RESOURCE_TYPES)) {
										$countj = count($CFG->RESOURCE_TYPES);
									}
									for($j=0; $j<$countj; $j++){
										$item = $CFG->RESOURCE_TYPES[$j];
										$name = $LNG->RESOURCE_TYPES[$j]; ?>
						    	        <option value='<?php echo $item; ?>' <?php if ( (isset($resourcetypesarray[$i]) && $resourcetypesarray[$i] == $item) || (isset($resourcetypesarray[$i]) && $resourcetypesarray[$i] == "" && $item == $CFG->RESOURCE_TYPES_DEFAULT)) { echo 'selected=\"true\"'; } ?> ><?php echo $name ?></option>
						    	<?php } ?>
						    </select>
							<span class="active" onClick="javascript: removeSelectedResource(<?php echo $i; ?>)" class="form" style="margin-left: 15px;"><?php echo $LNG->FORM_BUTTON_REMOVE; ?></span>
							<span class="active" onClick="javascript: openResourceSelector(<?php echo $i; ?>)" class="form" style="margin-left: 10px;"><?php echo $LNG->FORM_BUTTON_CHANGE; ?></span>
					   </div>

					   <div class="hgrformrow" id="typediv-<?php echo $i; ?>">
							<label  class="hgrsubformlabel" for="connection-<?php echo $i; ?>"><?php echo $LNG->FORM_LABEL_TYPE; ?>
								<a href="javascript:void(0)" onMouseOver="showFormHint('ResourceType', event, 'hgrhint'); return false;" onMouseOut="hideHints(); return false;" onClick="hideHints(); return false;" onkeypress="enterKeyPressed(event)"><img src="<?php echo $HUB_FLM->getImagePath('info.png'); ?>" border="0" style="margin-top: 2px; margin-left: 5px; margin-right: 2px;" /></a>
								<span style="font-size:14pt;margin-top:3px;vertical-align:middle;color:red;">*</span>
								</label>
							<select onchange="typeChangedResource('<?php echo $i; ?>')" class="subforminput hgrselect forminputmust" style="width: 172px" id="resource<?php echo $i; ?>menu" name="resourcetypesarray[]">
						    	<?php
									$countj = 0;
									if (is_countable($CFG->RESOURCE_TYPES)) {
										$countj = count($CFG->RESOURCE_TYPES);
									}
									for($j=0; $j<$countj; $j++){
										$item = $CFG->RESOURCE_TYPES[$j];
										$name = $LNG->RESOURCE_TYPES[$j]; ?>
						    	        <option value='<?php echo $item; ?>' <?php if ( (isset($resourcetypesarray[$i]) && $resourcetypesarray[$i] == $item) || (isset($resourcetypesarray[$i]) && $resourcetypesarray[$i] == "" && $item == $CFG->RESOURCE_TYPES_DEFAULT)) { echo 'selected=\"true\"'; } ?> ><?php echo $name ?></option>
						    	<?php } ?>
						    </select>
							<span class="active" onClick="javascript: openResourceSelector('<?php echo $i; ?>')" class="form" style="margin-left: 15px;"><?php echo $LNG->FORM_RESOURCE_SELECT_EXISTING; ?></span>
					   </div>

						<div class="hgrsubformrow" id="resourceurldiv-<?php echo $i; ?>">
							<label  class="hgrsubformlabel" for="resourceurl-<?php echo $i; ?>"><?php echo $LNG->FORM_LABEL_URL; ?>
								<a href="javascript:void(0)" onMouseOver="showFormHint('ResourceURL', event, 'hgrhint'); return false;" onMouseOut="hideHints(); return false;" onClick="hideHints(); return false;" onkeypress="enterKeyPressed(event)"><img src="<?php echo $HUB_FLM->getImagePath('info.png'); ?>" border="0" style="margin-top: 2px; margin-left: 5px; margin-right: 2px;" /></a>
								<span style="font-size:14pt;margin-top:3px;vertical-align:middle;color:red;">*</span>
							</label>
							<input class="subforminput forminputmust" style="width: 320px;" id="resourceurl-<?php echo $i; ?>" name="resourceurlarray[]" value="<?php echo( htmlspecialchars($resourceurlarray[$i]) ); ?>">
							<img class="active" style="vertical-align: middle; padding-bottom: 2px;" title="<?php echo $LNG->FORM_AUTOCOMPLETE_TITLE_HINT; ?>" src="<?php echo $HUB_FLM->getImagePath('autofill.png'); ?>" onClick="autoCompleteWebsiteDetailsMulti(<?php echo $i; ?>)" onkeypress="enterKeyPressed(event)" />
						</div>

						<div class="hgrsubformrow">
							<label  class="hgrsubformlabel" for="resourcetitle-<?php echo $i; ?>"><?php echo $LNG->FORM_LABEL_TITLE; ?>
								<a href="javascript:void(0)" onMouseOver="showFormHint('ResourceTitle', event, 'hgrhint'); return false;" onMouseOut="hideHints(); return false;" onClick="hideHints(); return false;" onkeypress="enterKeyPressed(event)"><img src="<?php echo $HUB_FLM->getImagePath('info.png'); ?>" border="0" style="margin-top: 2px; margin-left: 5px; margin-right: 2px;" /></a>
								<span style="font-size:14pt;margin-top:3px;vertical-align:middle;color:red;">*</span>
							</label>
							<input class="subforminput forminputmust" style="width: 350px;" id="resourcetitle-<?php echo $i; ?>" name="resourcetitlearray[]" value="<?php if (isset($resourcetitlearray[$i])) { echo( $resourcetitlearray[$i] ); } ?>">
						</div>
						<div id='identifierdiv-<?php echo $i; ?>' class="hgrsubformrow" style="display:<?php if (isset($resourcetypesarray[$i])  && $resourcetypesarray[$i] == "Publication" ) { echo 'block';} else { echo 'none'; } ?>">
							<label  class="hgrsubformlabel" for="identifier-<?php echo $i; ?>"><?php echo $LNG->FORM_LABEL_DOI; ?>
								<a href="javascript:void(0)" onMouseOver="showFormHint('ResourceDOI', event, 'hgrhint'); return false;" onMouseOut="hideHints(); return false;" onClick="hideHints(); return false;" onkeypress="enterKeyPressed(event)"><img src="<?php echo $HUB_FLM->getImagePath('info.png'); ?>" border="0" style="margin-top: 2px; margin-left: 5px; margin-right: 2px;" /></a>
							</label>
							<input class="subforminput" style="width: 350px;" id="identifier-<?php echo $i; ?>" name="identifierarray[]" value="<?php if (isset($identifierarray[$i])) { echo( $identifierarray[$i] ); } ?>">
						</div>

						<?php if (isset($resourcecliparray[$i]) && $resourcecliparray[$i] != "") { ?>
							<div class="hgrsubformrow"  id="resourcedescdiv-<?php echo $i; ?>">
								<label  class="hgrsubformlabel" for="resourcecliparray-<?php echo $i; ?>"><?php echo $LNG->FORM_LABEL_CLIP; ?>
									<a href="javascript:void(0)" onMouseOver="showFormHint('ResourceClip', event, 'hgrhint'); return false;" onMouseOut="hideHints(); return false;" onClick="hideHints(); return false;" onkeypress="enterKeyPressed(event)"><img src="<?php echo $HUB_FLM->getImagePath('info.png'); ?>" border="0" style="margin-top: 2px; margin-left: 5px; margin-right: 2px;" /></a>
								</label>
								<textarea class="forminput hgrinput" readonly style="border: none" id="resourcecliparray-<?php echo $i; ?>" name="resourcecliparray[]" rows="3"><?php echo( $resourcecliparray[$i] ); ?></textarea>
								<a href="javascript:removeMultiple('resource', <?php echo $i; ?>)" class="form"><?php echo $LNG->FORM_BUTTON_REMOVE; ?></a>
							</div>
						<?php } else { ?>
							<div class="hgrsubformrow"  id="resourcedescdiv-<?php echo $i; ?>">
								<input type="hidden" id="resourcecliparray-<?php echo $i; ?>" name="resourcecliparray[]" value="<?php if (isset($resourcecliparray[$i])) { echo $resourcecliparray[$i]; } ?>" />
								<a id="resourceremovebutton-<?php echo $i; ?>" href="javascript:void(0)" onclick="javascript:removeMultiple('resource', <?php echo $i; ?>)" class="form" style="clear:both;float:right"><?php echo $LNG->FORM_BUTTON_REMOVE; ?></a><br>
							</div>
						<?php } ?>
	                </div>
	            <?php
	                }
	            ?>

	        </div>
	        <div class="formrow">
	        	<span id="resourceaddbutton" class="formsubmit form active" style="margin-left: 190px;" onclick="javascript:noResources = addResource(noResources);"><?php echo $LNG->FORM_BUTTON_ADD_ANOTHER." ".$LNG->RESOURCE_NAME; ?></span>
	        </div>
	    </div>
	</div>
<?php }

function insertProjectForm($hintname, $title = "") {
	global $CFG, $LNG, $HUB_FLM, $projectnamesarray, $projectnodeidsarray;

	?>

    <div class="hgrformrow" id="projectsformrow">
		<div id="projectsdiv" style="display: block; float:left;margin-bottom:10px;">

			<label  class="formlabelbig" for="projectform"><span id="projectformlabel"><?php echo $title; ?></span>
			    <a href="javascript:void(0)" onMouseOver="showFormHint('<?php echo $hintname; ?>', event, 'hgrhint'); return false;" onMouseOut="hideHints(); return false;" onClick="hideHints(); return false;" onkeypress="enterKeyPressed(event)"><img src="<?php echo $HUB_FLM->getImagePath('info.png'); ?>" border="0" style="margin-top: 2px; margin-left: 5px; margin-right: 2px;" /></a>
			</label>

	        <div class="hgrsubform" id="projectform">
	            <?php
	            	$count = 0;
	            	if (is_countable($projectnodeidsarray)) {
	            		$count = count($projectnodeidsarray);
	            	}

                    if ($count == 0) {
	            ?>
	                <div id="projectfield0" class="subformrow" style="padding-bottom:5px;padding-top:5px;">
						<span id="projectaddbutton" class="formsubmit form active" onclick="javascript:openProjectSelector(0);"><?php echo $LNG->FORM_PROJECT_SELECT_EXISTING; ?></span>
					</div>
	            <?php
	                } else {

						for($i=0; $i<$count; $i++){
					?>
						<div id="projectfield<?php echo $i; ?>" class="subformrow" style="padding-bottom:5px;padding-top:5px;">
							<input type="hidden" id="projectnodeidsarray-<?php echo $i; ?>" name="projectnodeidsarray[]" value="<?php if (isset($projectnodeidsarray[$i])) { echo $projectnodeidsarray[$i]; } ?>" />
							<input readonly style="width: 360px;" id="projectnamesarray-<?php echo $i; ?>" name="projectnamesarray[]" value="<?php if (isset($projectnamesarray[$i])) { echo( $projectnamesarray[$i] ); } ?>">
							<span class="active" onClick="javascript: removeSelectedNode('Project',<?php echo $i; ?>)" class="form" style="margin-left: 15px;"><?php echo $LNG->FORM_BUTTON_REMOVE; ?></span>
						</div>

	            	<?php	} ?>
						<div id="projectfield<?php echo $count; ?>" class="subformrow" style="padding-bottom:5px;padding-top:5px;">
							<div id="projectaddbutton" class="formsubmit form active" onclick="javascript:openProjectSelector(0);"><?php echo $LNG->FORM_PROJECT_SELECT_EXISTING; ?></div>
						</div>
	            <?php } ?>
	        </div>
	    </div>
	</div>
<?php }

function insertOrganizationForm($hintname, $title = "") {
	global $CFG, $LNG, $HUB_FLM, $orgnamesarray, $orgnodeidsarray;

	?>

    <div class="hgrformrow" id="orgsformrow">
		<div id="orgsdiv" style="display: block; float:left;margin-bottom:10px;">

			<label  class="formlabelbig" for="orgform"><span id="orgformlabel"><?php echo $title; ?></span>
			    <a href="javascript:void(0)" onMouseOver="showFormHint('<?php echo $hintname; ?>', event, 'hgrhint'); return false;" onMouseOut="hideHints(); return false;" onClick="hideHints(); return false;" onkeypress="enterKeyPressed(event)"><img src="<?php echo $HUB_FLM->getImagePath('info.png'); ?>" border="0" style="margin-top: 2px; margin-left: 5px; margin-right: 2px;" /></a>
			</label>

	        <div class="hgrsubform" id="orgform">
	            <?php
	            	$count = 0;
	            	if (is_countable($orgnodeidsarray)) {
	            		$count = count($orgnodeidsarray);
	            	}

                    if ($count == 0) {
	            ?>
	                <div id="orgfield0" class="subformrow" style="padding-bottom:5px;padding-top:5px;">
						<span id="orgaddbutton" class="formsubmit form active" onclick="javascript:openOrganizationSelector(0);"><?php echo $LNG->FORM_ORG_SELECT_EXISTING; ?></span>
					</div>
	            <?php
	                } else {

						for($i=0; $i<$count; $i++){
					?>
						<div id="orgfield<?php echo $i; ?>" class="subformrow" style="padding-bottom:5px;padding-top:5px;">
							<input type="hidden" id="orgnodeidsarray-<?php echo $i; ?>" name="orgnodeidsarray[]" value="<?php if (isset($orgnodeidsarray[$i])) { echo $orgnodeidsarray[$i]; } ?>" />
							<input readonly style="width: 360px;" id="orgnamesarray-<?php echo $i; ?>" name="orgnamesarray[]" value="<?php if (isset($orgnamesarray[$i])) { echo( $orgnamesarray[$i] ); } ?>">
							<span class="active" onClick="javascript: removeSelectedNode('Organization',<?php echo $i; ?>)" class="form" style="margin-left: 15px;"><?php echo $LNG->FORM_BUTTON_REMOVE; ?></span>
						</div>

	            	<?php	} ?>
						<div id="orgfield<?php echo $count; ?>" class="subformrow" style="padding-bottom:5px;padding-top:5px;">
							<div id="orgaddbutton" class="formsubmit form active" onclick="javascript:openOrganizationSelector(0);"><?php echo $LNG->FORM_ORG_SELECT_EXISTING; ?></div>
						</div>
	            <?php } ?>
	        </div>
	    </div>
	</div>
<?php }

function insertEvidenceForm($hintname, $title = "") {
	global $CFG, $LNG, $HUB_FLM, $evidencenamesarray, $evidencenodeidsarray;

	?>

    <div class="hgrformrow" id="evidenceformrow">
		<div id="evidencediv" style="display: block; float:left;margin-bottom:10px;">

			<label  class="formlabelbig" for="evidenceform"><?php echo $title; ?>
			    <a href="javascript:void(0)" onMouseOver="showFormHint('<?php echo $hintname; ?>', event, 'hgrhint'); return false;" onMouseOut="hideHints(); return false;" onClick="hideHints(); return false;" onkeypress="enterKeyPressed(event)"><img src="<?php echo $HUB_FLM->getImagePath('info.png'); ?>" border="0" style="margin-top: 2px; margin-left: 5px; margin-right: 2px;" /></a>
			</label>

	        <div class="hgrsubform" id="evidenceform">
	            <?php
	            	$count = 0;
	            	if (is_countable($evidencenodeidsarray)) {
	            		$count = count($evidencenodeidsarray);
	            	}

                    if ($count == 0) {
	            ?>
	                <div id="evidencefield0" class="subformrow" style="padding-bottom:5px;padding-top:5px;">
						<span id="evidenceaddbutton" class="formsubmit form active" onclick="javascript:openEvidenceSelector(0);"><?php echo $LNG->FORM_EVIDENCE_SELECT_EXISTING; ?></span>
					</div>
	            <?php
	                } else {

						for($i=0; $i<$count; $i++){
					?>
						<div id="evidencefield<?php echo $i; ?>" class="subformrow" style="padding-bottom:5px;padding-top:5px;">
							<input type="hidden" id="evidencenodeidsarray-<?php echo $i; ?>" name="evidencenodeidsarray[]" value="<?php if (isset($evidencenodeidsarray[$i])) { echo $evidencenodeidsarray[$i]; } ?>" />
							<input readonly style="width: 360px;" id="evidencenamesarray-<?php echo $i; ?>" name="evidencenamesarray[]" value="<?php if (isset($evidencenamesarray[$i])) { echo( $evidencenamesarray[$i] ); } ?>">
							<span class="active" onClick="javascript: removeSelectedNode('Evidence',<?php echo $i; ?>)" class="form" style="margin-left: 15px;"><?php echo $LNG->FORM_BUTTON_REMOVE; ?></span>
						</div>

	            	<?php	} ?>
						<div id="evidencefield<?php echo $count; ?>" class="subformrow" style="padding-bottom:5px;padding-top:5px;">
							<div id="evidenceaddbutton" class="formsubmit form active" onclick="javascript:openEvidenceSelector(0);"><?php echo $LNG->FORM_EVIDENCE_SELECT_EXISTING; ?></div>
						</div>
	            <?php } ?>
	        </div>
	    </div>
	</div>
<?php }


function insertSeeAlso($hintname, $title = "") {
	global $CFG, $LNG, $HUB_FLM, $relatedurlarray, $relatedtitlearray, $relatednodeidsarray;

	if ($title == "") {
		$title = $LNG->FORM_LABEL_SEE_ALSO;
	}
	?>

    <div class="hgrformrow">
		<div id="relateddiv" style="display: block; float:left;margin-bottom:10px;">

			<label  class="formlabelbig" for="relatedform"><?php echo $title; ?>
			    <a href="javascript:void(0)" onMouseOver="showFormHint('<?php echo $hintname; ?>', event, 'hgrhint'); return false;" onMouseOut="hideHints(); return false;" onClick="hideHints(); return false;" onkeypress="enterKeyPressed(event)"><img src="<?php echo $HUB_FLM->getImagePath('info.png'); ?>" border="0" style="margin-top: 2px; margin-left: 5px; margin-right: 2px;" /></a>
			</label>

	        <div class="hgrsubform" id="relatedform">
	            <?php
	            	$count = 0;
	            	if (is_countable($relatedtitlearray)) {
	            		$count = count($relatedtitlearray);
	            	}
	                for($i=0; $i<$count; $i++){
	                    if($i != 0){
	                        echo '<hr id="relatedhr<?php echo $i; ?>" class="urldivider"/>';
	                    }
	            ?>
	                <div id="relatedfield<?php echo $i; ?>" class="subformrow">

					   <input type="hidden" id="relatednodeidsarray-<?php echo $i; ?>" name="relatednodeidsarray[]" value="<?php echo $relatednodeidsarray[$i]; ?>" />
					   <div class="hgrformrow" id="relatedhiddendiv-<?php echo $i; ?>" style="display:none">
							<input class="subforminput forminputmust" style="width: 320px;" id="$relatedtitle-<?php echo $i; ?>" name="$relatedtitlearray[]" value="<?php echo( htmlspecialchars($relatedtitlearray[$i]) ); ?>">
							<span class="active" onClick="javascript: removeSelectedRelatedItem(<?php echo $i; ?>)" class="form" style="margin-left: 15px;"><?php echo $LNG->FORM_BUTTON_REMOVE; ?></span>
							<span class="active" onClick="javascript: openRelatedItemSelector(<?php echo $i; ?>)" class="form" style="margin-left: 10px;"><?php echo $LNG->FORM_BUTTON_CHANGE; ?></span>
					   </div>

					   <div class="hgrformrow" id="relateddiv-<?php echo $i; ?>">
							<input class="subforminput forminputmust" style="width: 320px;" id="$relatedtitle-<?php echo $i; ?>" name="$relatedtitlearray[]" value="<?php echo( htmlspecialchars($relatedtitlearray[$i]) ); ?>">
							<span class="active" onClick="javascript: openRelatedItemSelector('<?php echo $i; ?>')" class="form" style="margin-left: 15px;"><?php echo $LNG->FORM_SELECT_EXISTING_ITEM; ?></span>
					   </div>
	                </div>
	            <?php
	                }
	            ?>

	        </div>
	        <div class="formrow">
	        	<span class="formsubmit form active" style="margin-left: 170px;" onclick="javascript:noRelated = addRelated(noRelated);"><?php echo $LNG->FORM_BUTTON_ADD_ANOTHER; ?></span>
	        </div>
	    </div>
	</div>
<?php }

function insertProjectsManaged($hintname) {
	global $CFG, $LNG, $projectids, $projectdescs, $projectnames, $HUB_FLM; ?>

    <div class="hgrformrow" id="projectdiv">
		<div id="projectsdiv" style="display: block; float:left">
			<span class="active" onClick="javascript: openProjectSelector(0)" class="form" style="margin-left: 10px;"><?php echo $LNG->FORM_BUTTON_CHANGE; ?></span>
			<label  class="formlabelbig" for="url"><span style="vertical-align:top"><?php echo $LNG->PROJECTS_NAME; ?></span>
			<span class="active" onMouseOver="showFormHint('<?php echo $hintname; ?>', event, 'hgrhint'); return false;" onMouseOut="hideHints(); return false;" onClick="hideHints(); return false;" onkeypress="enterKeyPressed(event)"><img src="<?php echo $HUB_FLM->getImagePath('info.png'); ?>" border="0" style="margin-top: 2px; margin-left: 5px; margin-right: 2px;" /></span>
			</label>
	        <div class="hgrsubform" id="projectform">

	            <?php
	                // output rows for each project
					if (is_countable($projectids)) {
						$count = count($projectids);
						for($i=0; $i<$count; $i++){
							if($i != 0){
								echo '<hr id="projecthr<?php echo $i; ?>" class="urldivider"/>';
							}
	            ?>
	                <div id="projectfield<?php echo $i; ?>" class="subformrow">
						<input type="hidden" id="projectids-<?php echo $i; ?>" name="projectids[]" value="<?php echo $projectids[$i]; ?>" />
						<input type="hidden" id="projectdescs-<?php echo $i; ?>" name="projectdescs[]" value="<?php echo $projectdescs[$i]; ?>" />

	              		<input type="button" id="projectadd-<?php echo $i; ?>" title="<?php echo $LNG->FORM_BUTTON_SELECT_MANAGED_PROJECT_HINT; ?>" onclick="javascript: openProjectPicker('<?php echo $i; ?>');" value="<?php echo $LNG->FORM_BUTTON_SELECT_MANAGED_PROJECT_TEXT; ?>" />
	                    <input readonly class="subforminput hgrinput" style="background: white;border: none;width:325px" id="projectnames-<?php echo $i; ?>" name="$projectnames[]" value="<?php echo $projectnames[$i]; ?>" />
	                    <input type="button" id="projectremove-<?php echo $i; ?>" style="visibility:hidden;margin-left:3px;" onclick="javascript:removeMultiple('project', <?php echo $i; ?>)" class="form" value="<?php echo $LNG->FORM_BUTTON_REMOVE;?>" />
	                </div>
	            <?php
	                	}
	                }
	            ?>

	        </div>
	        <div class="formrow">
	        	<span class="formsubmit form" style="margin-left: 170px;"><?php echo $LNG->FORM_MANAGED_PROJECTS_HINT; ?></span>
	        </div>
	    </div>
	</div>
<?php }

function insertPartners($hintname) {
	global $CFG, $LNG, $partnersarray, $orgs, $LNG, $HUB_FLM; ?>

    <div class="hgrformrow" id="partnerdiv">
		<div style="display: block; float:left">
			<label  class="formlabelbig" for="connectionform"><span style="vertical-align:top"><?php echo $LNG->FORM_LABEL_PARTNERS; ?></span>
			    <span class="active" onMouseOver="showFormHint('<?php echo $hintname; ?>', event, 'hgrhint'); return false;" onMouseOut="hideHints(); return false;" onClick="hideHints(); return false;" onkeypress="enterKeyPressed(event)"><img src="<?php echo $HUB_FLM->getImagePath('info.png'); ?>" border="0" style="margin-top: 2px; margin-left: 5px; margin-right: 2px;" /></span>
			</label>
	        <div class="hgrsubform" id="partnerform">
	            <?php
	                for($i=0; $i<count($partnersarray); $i++){
	                    if($i != 0){
	                        echo '<hr id="partnerhr<?php echo $i; ?>" class="urldivider"/>';
	                    }
	            ?>
	                <div id="partnerfield<?php echo $i; ?>" class="subformrow">
	    	            <div class="subformrow">
							<select onchange="this.style.width='172px'; checkPartnerChange('<?php echo $i; ?>')" class="subforminput hgrselect" style="width: 172px;z-index:+1" id="partner<?php echo $i; ?>menu" name="partnersarray[]" onactivate="this.style.width='auto';">
						        <option value="" ><?php echo $LNG->FORM_LABEL_PARTNERS_CHOICE; ?></option>
						    	<?php
						    	    foreach($orgs as $org){?>
						    	        <option value='<?php echo $org['NodeID']; ?>' <?php if ($partnersarray[$i] == $org['NodeID']) { echo 'selected=\"true\"'; } ?> ><?php echo $org['Name']; ?></option>
						    	<?php } ?>
						    </select>
		    				<a href="javascript:removeMultiple('partner', <?php echo $i; ?>)" class="form" style="margin-left: 5px;"><?php echo $LNG->FORM_BUTTON_REMOVE; ?></a>
						</div>
	                </div>
	            <?php
	                }
	            ?>

	        </div>
	        <div class="formrow">
	        	<span id="addpartner" class="formsubmit form active" style="margin-left: 170px;" onclick="noPartners = addPartner(noPartners);"><?php echo $LNG->FORM_BUTTON_ADD_ANOTHER; ?></span>
	        </div>
	    </div>
	</div>
<?php }

?>

