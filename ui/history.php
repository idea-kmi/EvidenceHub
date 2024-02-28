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

// Get Current Page Address with Complete Path
$currentUrl= 'http'.(isset($_SERVER['HTTPS']) ? 's' : '').'://'.$_SERVER['HTTP_HOST'] .$_SERVER['REQUEST_URI'];

//$_SESSION['count'] = 0;
//unset($_SESSION['hubhistory']);

//strip any search parameters etc or it will not store it uniquely
$posnext = strpos($currentUrl, '&');
if ($posnext !== false) {
	$currentUrl = substr($currentUrl, 0, $posnext);
}

// check not already in history
if (isset($_SESSION['hubhistory'])) {
	if (!in_array($currentUrl,$_SESSION['hubhistory'], true)) {
		if ($_SESSION['count'] > 19) {
			array_pop($_SESSION['hubhistory']);
		} else {
			$_SESSION['count']=$_SESSION['count']+1;
		}

		array_unshift($_SESSION['hubhistory'], $currentUrl);
	} else {
		// remove the element from where it now is and add it to the end.
		$count = count($_SESSION['hubhistory']);
		for ($i=0; $i < $count; $i++) {
			$next = $_SESSION['hubhistory'][$i];
			if ($next == $currentUrl) {
				unset($_SESSION['hubhistory'][$i]);
				break;
			}
		}
		array_unshift($_SESSION['hubhistory'], $currentUrl);
	}
} else {
	$_SESSION['count'] = 0;
	$_SESSION['hubhistory'][$_SESSION['count']]=$currentUrl;
}
?>