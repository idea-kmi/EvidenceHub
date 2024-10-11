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
 * IO utility functions library
 */

/**
 * Add the given array of themes to the given node.
 */
function addThemesToNode($themenodearray, $nodeobj, $role) {

	// add themes
	if ($themenodearray && $themenodearray != "") {
		$r = getRoleByName("Theme");
		$roleThemeAuthor = $r->roleid;

		$lt = getLinkTypeByLabel('has main theme');
		$linkMainTheme = $lt->linktypeid;

		foreach($themenodearray as $next){
			if (!$next instanceof Hub_Error && $next != "") {
				$connection = addConnection($nodeobj->nodeid, $role->roleid, $linkMainTheme, $next->nodeid, $roleThemeAuthor, "N");
				if (!$connection instanceof Hub_Error && $connection != NULL) {
					$nexttag2 = addTag($next->name);
					if (isset($connection->addTag)) {
						$connection->addTag($nexttag2->tagid);
					}
				}
			}
		}
	}
}

/**
 * Breakup to get filename - check for direction of slashes which is dependent on platform.
 */
function getFileName($file) {

	$pos = strpos($file,'/');
	if($pos === false) {
		$fileArray = explode("\\\\", $file);
		$file = $fileArray[count($fileArray)-1];
	}
	else {
		$fileArray = explode("/", $file);
		$file = $fileArray[count($fileArray)-1];
	}
	return $file;
}

?>