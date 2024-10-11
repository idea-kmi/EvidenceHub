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
/**
 * Compendium library
 * Functions for the importing of data exchange with Compendium
 */

/**
 * Import from Compendium XML in pure Compendium node structure (not Evidence Hub Compendium XML)
 * The Compendium XML must be using the default IBIS Node Types (not stencils)
 * and the default IBIS link types for challenges, supports, as type numbers are processed.
 *
 * The Mapping is:
 *
 * Compendium Question -> Evidence Hub Issue
 * Compendium Answer -> Evidence Hub Solution
 * Compendium Pro -> Evidence Hub Evidence - default for Hub (supports link)
 * Compendium Con -> Evidence HubEvidence - default for Hub  (challenges link)
 * Compendium Reference -> Evidence Hub Resource - default for Hub
 *
 * The above are connected with usual Evidence Hub sematic links if they are in the usual pattern:
 * Issue -> Solution -> Evidence -> Resource
 * else they are connected as a 'see also' on the Compendium To Node in the connection.
 *
 * Compendium Note -> Evidence Hub Comment
 *   (If the note is not connected to anything, add as comment on parent map/list - now Issue)
 *
 * Compendium Argument -> Evidence Hub Evidence
 *   (connected with a 'see also' link to Compendium To Node)
 * Compendium Decision -> Evidence Hub Evidence
 *   (connected with a 'see also' link to Compendium To Node)
 *
 * Compendium Map -> Evidence Hub Issue
 *   (connected to all the child Issues in the map with a "see also" on Map)
 * Compendium List -> Evidence Hub Issue
 *   (connected to all the children in the list with a "see also" on List)
 *
 * @param $xml the XML document of the imported file
 * @param $themenodearray, the themes to add to the imported nodes
 * @&$errors the array into which to place error messages
 * @&$results the array into which to place processing messages.
 */
function importPureCompendiumXML($xml,$themesarray, &$errors,&$results){

    global $CFG, $LNG, $USER;

    $themenodearray = NULL;

    // preprocess themes
    if ($themesarray && $themesarray != "") {
		$i = 0;
		foreach($themesarray as $item){
			if ($item && $item != "") {
				$next = getThemeNodeByName($item,'short');
				if (!$next instanceof Hub_Error) {
					$themenodearray[$i] = $next;
					$i++;
				}
			}
		}
	}

    $codeCache = null;
    $codes = $xml->getElementsByTagName( "code" );
    foreach ($codes as $code) {
        $id = $code->getAttribute('id');
        $name = $code->getAttribute('name');
        $codeCache[$id] = $name;
    }

    $lt = getLinkTypeByLabel('addresses');
    $ADDRESSES = $lt->linktypeid;
    $lt = getLinkTypeByLabel('is related to');
    $IS_RELATED_TO = $lt->linktypeid;
    $lt = getLinkTypeByLabel('challenges');
    $CHALLENGES = $lt->linktypeid;
    $lt = getLinkTypeByLabel('supports');
    $SUPPORTS = $lt->linktypeid;
    $lt = getLinkTypeByLabel('responds to');
    $RESPONDS_TO = $lt->linktypeid;
    $lt = getLinkTypeByLabel('see also');
    $SEE_ALSO = $lt->linktypeid;

	// LOAD ROLE TYPES
	$roleCache = null;
	if (is_countable($CFG->BASE_TYPES)) {
		for($j=0; $j<count($CFG->BASE_TYPES); $j++){
			$r = getRoleByName($CFG->BASE_TYPES[$j]);
			$roleCache[$r->name] = $r;
		}
	}
	if (is_countable($CFG->EVIDENCE_TYPES)) {
		for($j=0; $j<count($CFG->EVIDENCE_TYPES); $j++){
			$r = getRoleByName($CFG->EVIDENCE_TYPES[$j]);
			$roleCache[$r->name] = $r;
		}
	}
	if (is_countable($CFG->RESOURCE_TYPES)) {
		for($j=0; $j<count($CFG->RESOURCE_TYPES); $j++){
			$r = getRoleByName($CFG->RESOURCE_TYPES[$j]);
			$roleCache[$r->name] = $r;
		}
	}
	if (is_countable($CFG->COMMENT_TYPES)) {
		for($j=0; $j<count($CFG->COMMENT_TYPES); $j++){
			$r = getRoleByName($CFG->COMMENT_TYPES[$j]);
			$roleCache[$r->name] = $r;
		}
	}

	$anwserTypeName = '';
	$anwserTypeLink = '';
	if ($CFG->HAS_SOLUTION) {
		$anwserTypeName = 'Solution';
		$anwserTypeLink = $ADDRESSES;
	} else {
		$anwserTypeName = 'Claim';
		$anwserTypeLink = $RESPONDS_TO;
	}

    $r = getRoleByName('Pro');
    $roleCache[$r->name] = $r;
	$r = getRoleByName('Con');
    $roleCache[$r->name] = $r;

    $model = $xml->documentElement;
    $rootview = $model->getAttribute('rootview');
    array_push($results,"RootView= ".$rootview);

    $nodes = $xml->getElementsByTagName( "node" );
    //array_push($results,"NODE COUNT START: ".$nodes->length);

    $nodeCache = null;
    $incount = 0;
    $outcount = 0;
    foreach ($nodes as $node) {
		$incount++;

        $id = $node->getAttribute('id');

        if (strcmp($id, $rootview) == 1) {

	        $type = $node->getAttribute('type');
	        $label = $node->getAttribute('label');
	        $ref = "";
	        $detail = "";

	        $details = $node->getElementsByTagName( "details" );
	        foreach($details as $page) {
	            $detail .= $page->nodeValue."\r\n\r\n";
	        }
	        $detail = trim($detail);

	        $label = trim($label);
	        if ($label == "") {
	             $label = "untitled - ".getUniqueID();
	        }

	        if (strlen($label) > 100) {
	        	$labelall = $label;
	        	$label = substr($labelall, 0, 100)."...";
	        	$detail = substr($labelall, 100)."\r\n\r\n".$detail;
	        }

			$role = null;
	        if ($type == "3" || $type == "13") { // question
	            $role = $roleCache['Issue'];
	        } else if ($type == "4" || $type == "14") { // answer
	            $role = $roleCache[$anwserTypeName];
	        } else if ($type == "6" || $type == "16") { //pro
	            $role = $roleCache[$CFG->EVIDENCE_TYPES_DEFAULT];
	        } else if ($type == "7" || $type == "17") { //con
	            $role = $roleCache[$CFG->EVIDENCE_TYPES_DEFAULT];
	        } else if ($type == "1" || $type == "11") { // list
	            $role = $roleCache['Issue'];
	        } else if ($type == "2" || $type == "12" || $type == "22") { // Map
	            $role = $roleCache['Issue'];
	        } else if ($type == "5" || $type == "15") { // Argument
	            $role = $roleCache[$CFG->EVIDENCE_TYPES_DEFAULT];
	        } else if ($type == "8" || $type == "18") { // Decision
	            $role = $roleCache[$CFG->EVIDENCE_TYPES_DEFAULT];
	        } else if ($type == "9" || $type == "19") { // Reference
	            $role = $roleCache[$CFG->RESOURCE_TYPES_DEFAULT];
	        } else if ($type == "10" || $type == "20") { // Note
	           	$role = $roleCache['Comment'];
	        } else {
	            // Ignore
	        }

	        if ($role != null) {
				if ($role->name == $CFG->RESOURCE_TYPES_DEFAULT) {
					$sources = $node->getElementsByTagName( "source" );
					if ($sources == null || $sources->item(0)->nodeValue == "") {
						$source = $label;
					} else {
						$source = $sources->item(0)->nodeValue;
					}

					// check if it's a URL
					if (substr($source, 0, 3) == "www") {
						$source = "http://".$source;
					}

					$source = clean_param($source, PARAM_URL);
					if ($source != "") {
						if (substr($source, 0, 7) == "http://" ||
							substr($source, 0, 8) == "https://" ||
							substr($source, 0, 7) == "feed://") {

							$ref = $source;
							$detail = $label;
							$label = $ref;
						} else {
							continue; // can't add a resource without a url
						}
					} else {
						continue; // can't add a resource without a url
					}
				}

				$nodeobj = addNode($label,$detail,'N',$role->roleid);
				if (!$nodeobj instanceof Hub_Error) {
					$newnodeid = $nodeobj->nodeid;

					// add tags
					$coderefs = $node->getElementsByTagName( "coderef" );
					foreach($coderefs as $coderef) {
						$nexttag = $codeCache[$coderef->getAttribute('coderef')];
						$tag = addTag($nexttag);
						if (!$tag instanceof Hub_Error) {
							$nodeobj->addTag($tag->tagid);
						}
					}

					// add themes
					addThemesToNode($themenodearray, $nodeobj, $role);

					$nextnode['id'] = $id;
					$nextnode['label'] = $label;
					$nextnode['detail'] = $detail;
					$nextnode['ref'] = $ref;
					$nextnode['oldtype'] = $type;
					$nextnode['type'] = $role->name;
					$nextnode['typeid'] = $role->roleid;
					$nextnode['newID'] = $newnodeid;

					array_push($results,$LNG->IMPORT_COMPENDIUM_IDEA_ADDED_MESSAGE." ".$label);
					$nodeCache[$id] = $nextnode;
					$outcount++;
				} else {
					array_push($results,"node creation error for: ".$label);
				}
	        } else {
				array_push($results,"Role not found for: ".$label);
	       }
        }
    }

    array_push($results,"NODE COUNT IN: ".$incount);
    array_push($results,"NODE COUNT OUT: ".$outcount);

   	// LOAD CONNECTIONS
    $linkCache = null;

    $linkLoop = 0;
    $links = $xml->getElementsByTagName( "link" );
    foreach ($links as $link) {
        $from = $link->getAttribute('from');
        $to = $link->getAttribute('to');
        $type = $link->getAttribute('type');

        $nextLink['from'] = $from;
        $nextLink['to'] = $to;
        $nextLink['type'] = $type;

        $linkCache[$linkLoop] = $nextLink;
        $linkLoop ++;
    }

    // Now bring in View relations as links
    $views = $xml->getElementsByTagName( "view" );
    foreach ($views as $view) {
        $to = $view->getAttribute('noderef');
        $from = $view->getAttribute('viewref');

        // Only add if noderef is now an Issue node.
        // viewref should be an issue definately.
        if (isset($nodeCache[$from]) && isset($nodeCache[$to])) {
        	$fromNode = $nodeCache[$from];
        	$toNode = $nodeCache[$to];

        	if ($fromNode['type'] == 'Issue' && $toNode['type'] == 'Issue') {
	        	$nextLink['from'] = $from;
	        	$nextLink['to'] = $to;
	        	$nextLink['type'] = '0';

	        	$linkCache[$linkLoop] = $nextLink;
	        	$linkLoop ++;
	        } else {
	        	// List parents will always have disconnected nodes. All should be 'See Also' links
	        	if ($fromNode['oldtype'] == "1" || $fromNode['oldtype'] == "11") {
		        	$nextLink['from'] = $from;
		        	$nextLink['to'] = $to;
		        	$nextLink['type'] = '0';
		        	$nextLink['link'] = $SEE_ALSO;

		        	$linkCache[$linkLoop] = $nextLink;
		        	$linkLoop ++;
	        	} else { // it's a map
	 	       		// Free Floating Children should be added as a 'see also' on the parent map.
	        		// Loop through links and check if noderef found in a connection.
	        		// If not 'see also' add connection to parent map.
	        		$found = false;
	 			   	foreach($linkCache as $next) {
				        $fromid = $next['from'];
				        $toid = $next['to'];
				        if ($to == $toid || $to == $fromid) {
				        	$found = true;
				        	break;
				        }
					}
					if (!$found) {
			        	$nextLink['from'] = $from;
			        	$nextLink['to'] = $to;
			        	$nextLink['type'] = '0';
			        	$nextLink['link'] = $SEE_ALSO;

			        	$linkCache[$linkLoop] = $nextLink;
			        	$linkLoop ++;
					}
	        	}
	        }
        }
    }

	if (!$linkCache){
		array_push($errors, $LNG->IMPORT_COMPENDIUM_NO_LINKS_ERROR);
		return;
	}

	// LOAD LINKS
	//Solution -> addresses -> Issue
	//Evidence(default type) -> supports -> Claim/Solution (Pro)
	//Evidence(default type) -> challenges -> Claim/Solution (Con)
	//Resource (default type) ->  is related to -> Node*4
	//Comment-> is related to  -> Node**
	//Node*5 -> see also -> Node*6
    //
    //Node**   Issue,Solution,Evidence(Anecdote),Web Resource
	//Node*4  (RESOURCE) = Issue,Evidence(Anecdote)
	//Node*5  (SEE ALSO - FROM) = Issue,Solution,Evidence(Anecdote)
	//Node*6  (SEE ALSO - TO) = Issue,Solution,Evidence(Anecdote),Web Resource

    foreach($linkCache as $next) {

    	if (isset($nodeCache[$next['from']]) && isset($nodeCache[$next['to']])) {

	        $fromNode = $nodeCache[$next['from']];
	        $toNode = $nodeCache[$next['to']];

	        if ($fromNode != null && $toNode != null) {

	            $fromNodeID = $fromNode['newID'];
	            $toNodeID = $toNode['newID'];

	            if ($fromNodeID != null && $toNodeID != null) {

	                // ADD ANY ASSOCIATED URLS TO THE NODES IF THEY ARE OF TYPE REFERENCE
	                if ($fromNode['ref'] != null && $fromNode['type'] == $CFG->RESOURCE_TYPES_DEFAULT) {
	                    $url = addURL($fromNode['ref'], $fromNode['ref'], "",'N');
	                    addURLToNode($url->urlid, $fromNodeID);
	                }
	                if ($toNode['ref'] != null && $toNode['type'] == $CFG->RESOURCE_TYPES_DEFAULT) {
	                	$url = addURL($toNode['ref'], $toNode['ref'], "",'N');
	                    addURLToNode($url->urlid,$toNodeID);
	                }

	                $groupid = $CFG->defaultRoleGroupID;

	                $fromRoleID = $fromNode['typeid'];
	                $fromNodeType = $fromNode['type'];

	                $toRoleID = $toNode['typeid'];
	                $toNodeType = $toNode['type'];

	                $linkLabelID = "";

	                if (isset($next['link'])) { // the 'see also' links from views
	                	$linkLabelID = $next['link'];
	                } else {
						// EVIDENCE LINKING
						if ($fromNodeType == $CFG->EVIDENCE_TYPES_DEFAULT && $toNodeType == 'Solution' ) {
							if ($fromNode['oldtype'] == "6" || $fromNode['oldtype'] == "16") { //pro
								$linkLabelID = $SUPPORTS;
								$role = $roleCache['Pro'];
								$fromRoleID = $role->roleid;
							} else if ($fromNode['oldtype'] == "7" || $fromNode['oldtype'] == "17") { //con
								$linkLabelID = $CHALLENGES;
								$role = $roleCache['Con'];
								$fromRoleID = $role->roleid;
							} else { // to cover Decisions and Arguments
								$linkLabelID = $SEE_ALSO;
							}
						} else if ($fromNodeType == $anwserTypeName &&
								($toNodeType == 'Issue' && ($toNode['oldtype'] == "3" || $toNode['oldtype'] == "13") ) ) {
							$linkLabelID = $anwserTypeLink;

						// RESOURCE LINKING TO A NODE
						} else if ($fromNodeType == $CFG->RESOURCE_TYPES_DEFAULT && $toNodeType == $CFG->EVIDENCE_TYPES_DEFAULT) {
							$linkLabelID = $IS_RELATED_TO;

						// COMMENTS TO ALL NODES
						} else if ( ($fromNodeType == "Comment")
								&& ( $toNodeType == $CFG->EVIDENCE_TYPES_DEFAULT
										|| $toNodeType == $CFG->RESOURCE_TYPES_DEFAULT
										|| $toNodeType == $anwserTypeName
										|| $toNodeType == 'Issue') ) {

							$linkLabelID = $IS_RELATED_TO;
						} else {
							$linkLabelID = $SEE_ALSO;
						}
	                }

	                // ADD NEW CONNECTION
	                if ($linkLabelID != "" && $fromRoleID != "" && $toRoleID != "") {
	                	$c = addConnection($fromNodeID, $fromRoleID, $linkLabelID, $toNodeID,$toRoleID, "N");
						array_push($results, $LNG->IMPORT_COMPENDIUM_CONNECTION_MESSAGE_PART1." ". $fromNode['label']."' ".$LNG->IMPORT_COMPENDIUM_CONNECTION_MESSAGE_PART2." ''". $toNode['label']."'");
					}
	            }
            }
        }
    }
}

/**
 * Import from Compendium XML designed for Evidence hub rules.
 *
 * @param $xml the XML document of the imported file
 * @&$errors the array into which to place error messages
 * @&$results the array into which to place processing messages.
 */
function importCompendiumXML($xml,&$errors,&$results){

    global $CFG, $LNG, $USER;

    $codeCache = null;
    $codes = $xml->getElementsByTagName( "code" );
    foreach ($codes as $code) {
        $id = $code->getAttribute('id');
        $name = $code->getAttribute('name');
        $codeCache[$id] = $name;
    }

	// LOAD LINKS

    $lt = getLinkTypeByLabel('has main theme');
    $HAS_THEME = $lt->linktypeid;
    $lt = getLinkTypeByLabel('partnered with');
    $PARTNERED_WITH = $lt->linktypeid;
    $lt = getLinkTypeByLabel('specifies');
    $SPECIFIES = $lt->linktypeid;
    $lt = getLinkTypeByLabel('claims');
    $CLAIMS = $lt->linktypeid;
    $lt = getLinkTypeByLabel('addresses');
    $ADDRESSES = $lt->linktypeid;
    $lt = getLinkTypeByLabel('is related to');
    $IS_RELATED_TO = $lt->linktypeid;
    $lt = getLinkTypeByLabel('challenges');
    $CHALLENGES = $lt->linktypeid;
    $lt = getLinkTypeByLabel('supports');
    $SUPPORTS = $lt->linktypeid;
    $lt = getLinkTypeByLabel('responds to');
    $RESPONDS_TO = $lt->linktypeid;

    // Can't currently guess this as the rules clash with 'partnered with'
    //$lt = getLinkTypeByLabel('manages');
    //$MANAGES = $lt->linktypeid;

	// LOAD ROLE TYPES
	$roleCache = null;
	if (is_countable($CFG->BASE_TYPES)) {
		for($j=0; $j<count($CFG->BASE_TYPES); $j++){
			$r = getRoleByName($CFG->BASE_TYPES[$j]);
			$file = getFileName($r->image);
			$roleCache[$file] = $r;
		}
	}
	if (is_countable($CFG->EVIDENCE_TYPES)) {
		for($j=0; $j<count($CFG->EVIDENCE_TYPES); $j++){
			$r = getRoleByName($CFG->EVIDENCE_TYPES[$j]);
			$file = getFileName($r->image);
			$roleCache[$file] = $r;
		}
	}
	if (is_countable($CFG->RESOURCE_TYPES)) {
		for($j=0; $j<count($CFG->RESOURCE_TYPES); $j++){
			$r = getRoleByName($CFG->RESOURCE_TYPES[$j]);
			$file = getFileName($r->image);
			$roleCache[$file] = $r;
		}
	}
	if (is_countable($CFG->COMMENT_TYPES)) {
		for($j=0; $j<count($CFG->COMMENT_TYPES); $j++){
			$r = getRoleByName($CFG->COMMENT_TYPES[$j]);
			$file = getFileName($r->image);
			$roleCache[$file] = $r;
		}
	}
    $r = getRoleByName('Pro');
    $file = getFileName($r->image);
    $roleCache[$file] = $r;

	$r = getRoleByName('Con');
    $file = getFileName($r->image);
    $roleCache[$file] = $r;

	// THEMES
	$themeNodeCache = null;

    $nodeCache = null;

    $model = $xml->documentElement;
    $rootview = $model->getAttribute('rootview');

    $nodes = $xml->getElementsByTagName( "node" );
    foreach ($nodes as $node) {
        $id = $node->getAttribute('id');

        // We don't want to import the parent view
        if (strcmp($id, $rootview) == 1) {

            $type = $node->getAttribute('type');
            $label = $node->getAttribute('label');
            $detail = "";
            $ref = "";

            $details = $node->getElementsByTagName( "details" );
            foreach($details as $page) {
                $detail .= $page->nodeValue."\r\n\r\n";
            }
            $detail = trim($detail);

            $label = trim($label);
            if ($label == "") {
                $label = "untitled - ".getUniqueID();
            }

            $images = $node->getElementsByTagName( "image" );
            if ($images != null) {
               	$image = $images->item(0)->nodeValue;
				$file = getFileName($image);

				if (isset($roleCache[$file])) {
					$role = $roleCache[$file];
					$nodetypeName = $role->name;
					$nodeTypeID = $role->roleid;

					$newnodeid = "";

					if ($nodetypeName == 'Theme') {
						$theme = getThemeNodeByName($label, 'short');
						if ($theme instanceof CNode) {
							$newnodeid = $theme->nodeid;
						}
					} else if ($nodetypeName == 'Organization' || $nodetypeName == 'Project') {
						$nodeSet = getNodesByName($label, 0,1,'date','ASC','short');
						if ($nodeSet->count > 0) {
							$newnode = $nodeSet->nodes[0];
							$newnodeid = $newnode->nodeid;
						}
					}

					if (in_array($nodetypeName, $CFG->RESOURCE_TYPES)) {
						$sources = $node->getElementsByTagName( "source" );
						if ($sources == null || $sources->item(0)->nodeValue == "") {
							$source = $label;
						} else {
							$source = $sources->item(0)->nodeValue;
						}

						// check if it's a URL
						if (substr($source, 0, 3) == "www") {
							$source = "http://".$source;
						}

						$source = clean_param($source, PARAM_URL);
						if ($source != "") {
							if (substr($source, 0, 7) == "http://" ||
								substr($source, 0, 8) == "https://" ||
								substr($source, 0, 7) == "feed://") {

								$ref = $source;
								$detail = $label;
								$label = $ref;
							} else {
								continue; // can't add a resource without a url
							}
						} else {
							continue; // can't add a resource without a url
						}
					}

					if ($newnodeid == "") {
						$nodeobj = addNode($label,$detail,'N',$nodeTypeID);
						$newnodeid = $nodeobj->nodeid;

						// add tags
						$coderefs = $node->getElementsByTagName( "coderef" );
						foreach($coderefs as $coderef) {
							$nexttag = $codeCache[$coderef->getAttribute('coderef')];
							$tag = addTag($nexttag);
							$nodeobj->addTag($tag->tagid);
						}
					}

					$nextnode['id'] = $id;
					$nextnode['label'] = $label;
					$nextnode['detail'] = $detail;
					$nextnode['ref'] = $ref;
					$nextnode['type'] = $nodetypeName;
					$nextnode['typeid'] = $nodeTypeID;
					$nextnode['newID'] = $newnodeid;

					array_push($results,$LNG->IMPORT_COMPENDIUM_IDEA_ADDED_MESSAGE." ".$label);
					$nodeCache[$id] = $nextnode;
				}
			}
        }
    }

    $linkCache = null;

    $linkLoop = 0;
    $links = $xml->getElementsByTagName( "link" );
    foreach ($links as $link) {
        $id = $link->getAttribute('id');
        $from = $link->getAttribute('from');
        $to = $link->getAttribute('to');
        $type = $link->getAttribute('type');
        $label = $link->getAttribute('label');

        $nextLink['id'] = $id;
        $nextLink['from'] = $from;
        $nextLink['to'] = $to;
        $nextLink['label'] = $label;
        $nextLink['type'] = $type;

        $linkCache[$linkLoop] = $nextLink;
        $linkLoop ++;
    }

	if (!$linkCache){
		array_push($errors, $LNG->IMPORT_COMPENDIUM_NO_LINKS_ERROR);
		return;
	}

    foreach($linkCache as $next) {

        $fromNode = $nodeCache[$next['from']];
        $toNode = $nodeCache[$next['to']];

        if ($fromNode != null && $toNode != null) {

            $fromNodeID = $fromNode['newID'];
            $toNodeID = $toNode['newID'];

            if ($fromNodeID != null && $toNodeID != null) {

                // ADD ANY ASSOCIATED URLS TO THE NODES IF THEY ARE OF TYPE REFERENCE
                if ($fromNode['ref'] != null && in_array($fromNode['type'], $CFG->RESOURCE_TYPES)) {
                    $url = addURL($fromNode['ref'], $fromNode['ref'], "",'N');
                    addURLToNode($url->urlid, $fromNodeID);
                }
                if ($toNode['ref'] != null && in_array($toNode['type'], $CFG->RESOURCE_TYPES)) {
                	$url = addURL($toNode['ref'], $toNode['ref'], "",'N');
                    addURLToNode($url->urlid,$toNodeID);
                }

                $groupid = $CFG->defaultRoleGroupID;

                $fromRoleID = $fromNode['typeid'];
                $fromNodeType = $fromNode['type'];

                $toRoleID = $toNode['typeid'];
                $toNodeType = $toNode['type'];

                $linkLabelID = "";

				if ( ($fromNodeType == 'Organization' || $fromNodeType == 'Project')
						&& $toNodeType == 'Issue') {
					$linkLabelID = $ADDRESSES;
				} else if (($fromNodeType == 'Organization' || $fromNodeType == 'Project')
						&& $toNodeType == 'Claim') {
					$linkLabelID = $CLAIMS;
				} else if (($fromNodeType == 'Organization' || $fromNodeType == 'Project')
						&& $toNodeType == 'Solution') {
					$linkLabelID = $SPECIFIES;
				} else if (($fromNodeType == 'Organization' || $fromNodeType == 'Project')
						&& ($toNodeType == 'Organization' || $toNodeType == 'Project')) {
					$linkLabelID = $PARTNERED_WITH;

				// EVIDENCE LINKING
				} else if (in_array($fromNodeType, $CFG->EVIDENCE_TYPES)
						&& ($toNodeType == 'Claim' || $toNodeType == 'Solution') ) {

					if ($next['type'] == '40') {
						$linkLabelID = $SUPPORTS;
						$role = $roleCache['plus-32x32.png'];
						$fromRoleID = $role->roleid;
					} else if ($next['type'] == '42') {
						$linkLabelID = $CHALLENGES;
						$role = $roleCache['minus-32x32.png'];
						$fromRoleID = $role->roleid;
					}
					if ($fromRoleID == "") {
						if ($next['label'] == 'challenges') {
							$linkLabelID = $CHALLENGES;
							$role = $roleCache['minus-32x32.png'];
							$fromRoleID = $role->roleid;
						} else {
							$linkLabelID = $SUPPORTS;
							$role = $roleCache['plus-32x32.png'];
							$fromRoleID = $role->roleid;
						}
					}
				} else if ($fromNodeType == 'Claim' && ($toNodeType == 'Issue' || $toNodeType == 'Challenge')) {
					$linkLabelID = $RESPONDS_TO;
				} else if ($fromNodeType == 'Solution' && ($toNodeType == 'Issue' || $toNodeType == 'Challenge')) {
					$linkLabelID = $ADDRESSES;
				} else if ($fromNodeType == 'Issue' && $toNodeType == 'Challenge') {
					$linkLabelID = $IS_RELATED_TO;
				} else if (($fromNodeType == 'Organization' || $fromNodeType == 'Project')
						&& $toNodeType == 'Challenge') {
					$linkLabelID = $ADDRESSES;

				// RESOURCE LINKING TO A NODE (switch if connection reversed)
				} else if (in_array($fromNodeType, $CFG->RESOURCE_TYPES)
								&& ($toNodeType == 'Organization'
								|| $toNodeType == 'Project'
								|| $toNodeType == 'Challenge'
								|| $toNodeType == 'Issue'
								|| in_array($toNodeType, $CFG->EVIDENCE_TYPES)) ) {

					$linkLabelID = $IS_RELATED_TO;
				} else if (in_array($toNodeType, $CFG->RESOURCE_TYPES)
								&& ($fromNodeType == 'Organization'
								|| $fromNodeType == 'Project'
								|| $fromNodeType == 'Issue'
								|| $fromNodeType == 'Challenge'
								|| in_array($fromNodeType, $CFG->EVIDENCE_TYPES)) ) {

					$linkLabelID = $IS_RELATED_TO;

					// swap nodeids and roles
					$tempNodeID = $fromNodeID;
					$fromNodeID = $toNodeID;
					$toNodeID = $tempNodeID;

					$tempRoleID = $fromRoleID;
					$fromRoleID = $toRoleID;
					$toRoleID = $tempRoleID;

				// THEMES TO ALL NODES (switch if connection reversed)
				} else if ( (in_array($fromNodeType, $CFG->EVIDENCE_TYPES)
							|| in_array($fromNodeType, $CFG->RESOURCE_TYPES)
							|| in_array($fromNodeType, $CFG->BASE_TYPES)
							&& $fromNodeType != 'Theme')
								 && $toNodeType == 'Theme') {
					$linkLabelID = $HAS_THEME;
				} else if ( (in_array($toNodeType, $CFG->EVIDENCE_TYPES)
							|| in_array($toNodeType, $CFG->RESOURCE_TYPES)
							|| in_array($toNodeType, $CFG->BASE_TYPES)
							&& $toNodeType != 'Theme' )
								&& $fromNodeType == 'Theme') {

					$linkLabelID = $HAS_THEME;

					// swap nodeids and roles
					$tempNodeID = $fromNodeID;
					$fromNodeID = $toNodeID;
					$toNodeID = $tempNodeID;

					$tempRoleID = $fromRoleID;
					$fromRoleID = $toRoleID;
					$toRoleID = $tempRoleID;

				// COMMENTS TO ALL NODES
				} else if ( in_array($fromNodeType, $CFG->COMMENT_TYPES)
						&& ( in_array($toNodeType, $CFG->EVIDENCE_TYPES)
								|| in_array($toNodeType, $CFG->RESOURCE_TYPES)
								|| in_array($toNodeType, $CFG->BASE_TYPES) ) ) {
					$linkLabelID = $IS_RELATED_TO;

					$role = $roleCache['comment.png'];
					$fromRoleID = $role->roleid;
				}

                // ADD NEW CONNECTION
                if ($linkLabelID != "" && $fromRoleID != "" && $toRoleID != "") {
                	$c = addConnection($fromNodeID, $fromRoleID, $linkLabelID, $toNodeID,$toRoleID, "N");
					array_push($results, $LNG->IMPORT_COMPENDIUM_CONNECTION_MESSAGE_PART1." ". $fromNode['label']."' ".$LNG->IMPORT_COMPENDIUM_CONNECTION_MESSAGE_PART2." ''". $toNode['label']."'");
				}
            }
        }
    }
}
?>