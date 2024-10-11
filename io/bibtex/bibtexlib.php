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
 * Bib TeX library
 * Functions for the importing of data from Bib TeX
 */

/**
 * Import from Bib TeX file
 * An individual entry will only import if it has a url and a title.
 * This is the minimum required to add a Resource (Publication) to an Evidence Hub.
 * If it has a DOI this will be added too.
 * The Author, Year and any Abstract text will be added to the Resource description.
 *
 * @param $target_path the filepath to the Bib TeX file to import
 * @param $themesarray, the themes to add to the imported nodes
 * @&$errors the array into which to place error messages
 * @&$results the array into which to place processing messages.
 */
function importBibtex($target_path,$themesarray,&$errors,&$results){
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

	// LOAD ROLE TYPES
	$roleCache = null;
	if (is_countable($CFG->RESOURCE_TYPES)) {
		for($j=0; $j<count($CFG->RESOURCE_TYPES); $j++){
			$r = getRoleByName($CFG->RESOURCE_TYPES[$j]);
			$roleCache[$r->name] = $r;
		}
	}
	$role = "";
	if (isset($roleCache['Publication'])) {
		$role = $roleCache['Publication'];
	} else {
		$role = $roleCache[$CFG->RESOURCE_TYPES_DEFAULT];
	}

    $nodeCache = null;

	$entry = array();
	$previousElement = "";

	//process a line at a time.
	foreach (file($target_path) as $line) {
		$line = trim($line);

		//ignore enty lines
		if(strlen($line) > 0) {
			if (startsWith($line,'%')) {
				continue;
			} else if (startsWith($line, '@')) {
				// filter out @preamble, @comment, @string??

				if (!empty($entry)) {
					//array_push($results,"PROCESS ENTRY");
					processBibtextEntry($entry, $role, $themenodearray, $errors, $results);
				}

				//array_push($results,"New ENTRY");
				$entry = array();
			} else {
				$previousElement = parseBibtextLine($line, $entry, $errors, $results, $previousElement);
			}
		}
	}

	// process the last item
	if (!empty($entry)) {
		//array_push($results,"PROCESS FINAL ENTRY");
		processBibtextEntry($entry, $role, $themenodearray, $errors, $results);
	}
}

function parseBibtextLine($line, &$entry, &$errors,&$results, $previousElement) {

	//array_push($results,"NEXT LINE:".$line);

	// if it is just a } or , or }, then it will be the last line of an entry,
	// so nothing to process.
	if ($line == "}" || $line == "}," || $line == ",") {
		return "";
	}

	// strip the last comma
	if (endsWith($line, ",")) {
		$line = substr($line, 0, strlen($line)-1);

		// ONLY STRIP } or " if this is the end of the field
		// in case it is the last line and has two - check again.
		if (endsWith($line, "}")) {
			$line = substr($line, 0, strlen($line)-1);
		}
		if (endsWith($line, "\"")) {
			$line = substr($line, 0, strlen($line)-1);
		}
	} else {
		// If it is the last field of the entry it would not have a comman but could have a "} or }}
		if (endsWith($line, "\"}")) {
			$line = substr($line, 0, strlen($line)-2);
		}
		if (endsWith($line, "}}")) {
			$line = substr($line, 0, strlen($line)-2);
		}
	}

	//array_push($results,"PREVIOUS ELEMENT=".$previousElement);

	// if there is no = then this line is probably a continuence of the previous field
	// so append this string to the previous entry.
	if (strpos($line, '=') === FALSE && $previousElement != "") {
		// in case it is the last line and has two - check again.

		//array_push($results,"ADDING TO =".$previousElement);

		$value = $entry[$previousElement];
		$value .= " ".$line;
		$entry[$previousElement] = $value;

		return $previousElement;
	}

	$pos = strpos($line, '=');
	$name = strtolower(trim(substr($line, 0, $pos)));
	$value = trim(substr($line, $pos+1));

	//array_push($results,"BEFORE param=".$name." value=".$value);

	//strip enclosing brackets / speech marks from value;
	if (startsWith($value, "{")) {
		$value = substr($value, 1);
	}
	if (startsWith($value, "\"")) {
		$value = substr($value, 1);
	}

	//array_push($results,"AFTER param=".$name." value=".$value);

	if ($name == "url"
			|| $name == "author"
			|| $name == "title"
			|| $name == "doi"
			|| $name == "year"
			|| $name == "abstract") {

		$entry[$name] = $value;

		return $name;
		//array_push($results,"ADDING TO ENTRY param=".$name." value=".$value);
	}

	return "";
}

/**
 * Process a line in a Bibtext entry
 */
function processBibtextEntry($entry, $role, $themenodearray, &$errors, &$results) {

    global $CFG, $LNG;

	// if there is no url and title, ignore it. They are the minimum requirements
	if (isset($entry['url']) && isset($entry['title'])) {

		$url = $entry['url'];
		$title = $entry['title'];
		$author = "";
		$desc = "";
		if (isset($entry['author'])) {
			$author = "Author: ".$entry['author'];
		}
		if (isset($entry['year'])) {
			$author .= " (".$entry['year'].")";
		}
		if (isset($entry['abstract'])) {
			$desc = "Abstract: ".$entry['abstract'];
		}

		if ($role != "") {
			$nodeobj = addNode($url, $title,'N',$role->roleid);
			if (!$nodeobj instanceof Hub_Error) {

				// add doi if any
				if (isset($entry['doi'])) {
					$nodeobj->updateAdditionalIdentifier($entry['doi']);
				}

	    		$urlobj = new URL();
	    		$urlobj->add($url, $title, "", 'N', $author, "", "", "", "");
		    	if (!$urlobj instanceof Hub_Error) {
		    		$nodeobj->addURL($urlobj->urlid, "");
		    	}

	    		$urlobj = new URL();
	    		$urlobj->add($url, $title, "", 'N', $desc, "", "", "", "");
		    	if (!$urlobj instanceof Hub_Error) {
		    		$nodeobj->addURL($urlobj->urlid, "");
		    	}

				addThemesToNode($themenodearray, $nodeobj, $role);

				array_push($results,$LNG->IMPORT_BIBTEX_ITEM_ADDED_MESSAGE." ".$title);
			}
		}
	}
}

?>