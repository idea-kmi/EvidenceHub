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

$LNG->PAGE_COMPENDIUM_IMPORT_TITLE = 'Come importare mappe concettuali in Evidence Hub';

$LNG->PAGE_COMPENDIUM_IMPORT_BODY = '<p>Per importare <a href="http://compendium.open.ac.uk/institute/">Compendium</a> XML export file ';
$LNG->PAGE_COMPENDIUM_IMPORT_BODY .= 'La mappa concettuale che Ã¨ stata esportata deve aver utilizzato i nodi di tipo IBIS di default (non stencil set items), ';
$LNG->PAGE_COMPENDIUM_IMPORT_BODY .= 'e i tipi di collegamento IBIS predefiniti, poichÃ© i numeri id sottostanti per questi vengono elaborati nell\'importazione per identificare i loro tipi.</p>';

$LNG->PAGE_COMPENDIUM_IMPORT_BODY .= '<p>L\'importazione viene elaborata come segue:</p>';

$LNG->PAGE_COMPENDIUM_IMPORT_BODY .= '<ul><li>Compendium Question -> Evidence Hub Issue</li>';
$LNG->PAGE_COMPENDIUM_IMPORT_BODY .= '<li>Compendium Answer -> Evidence Hub Solution (or if Solution is switched off, Claim)</li>';
$LNG->PAGE_COMPENDIUM_IMPORT_BODY .= '<li>Compendium Pro -> Evidence Hub Evidence - the default Evidence type set for your Hub (using a supports link)</li>';
$LNG->PAGE_COMPENDIUM_IMPORT_BODY .= '<li>Compendium Con -> Evidence Hub Evidence - the default Evidence type set for your Hub (using a challenges link)</li>';
$LNG->PAGE_COMPENDIUM_IMPORT_BODY .= '<li>Compendium Reference -> Evidence Hub Resource  - the default Resource type set for your Hub<br>';
$LNG->PAGE_COMPENDIUM_IMPORT_BODY .= '<br>The above are connected with the usual Evidence Hub sematic links if they are in the usual pattern:<br>';
$LNG->PAGE_COMPENDIUM_IMPORT_BODY .= 'Question <--- Answer <--- Pro/Con <--- Reference<br>';
$LNG->PAGE_COMPENDIUM_IMPORT_BODY .= 'Issue <--- Solution <--- Evidence <--- Resource<br><br>';
$LNG->PAGE_COMPENDIUM_IMPORT_BODY .= 'otherwise they are connected as a "see also" link coming from the Compendium To Node in the connection.<br>';
$LNG->PAGE_COMPENDIUM_IMPORT_BODY .= '<b>NOTE: the link direction is important. They must follow the above direction, otherwise it will default to "see also" relation</b>.<br><br></li>';
$LNG->PAGE_COMPENDIUM_IMPORT_BODY .= '<li>Compendium Note -> Evidence Hub Comment';
$LNG->PAGE_COMPENDIUM_IMPORT_BODY .= '<br>&nbsp;&nbsp;&nbsp;(if the note is not connected to anything it is added as a Comment on the parent map/list - now Issue)</li>';
$LNG->PAGE_COMPENDIUM_IMPORT_BODY .= '<li>Compendium Argument -> Evidence Hub Evidence';
$LNG->PAGE_COMPENDIUM_IMPORT_BODY .= '<br>&nbsp;&nbsp;&nbsp;(connected with a "see also" link to the Compendium To Node)</li>';
$LNG->PAGE_COMPENDIUM_IMPORT_BODY .= '<li>Compendium Decision -> Evidence Hub Evidence';
$LNG->PAGE_COMPENDIUM_IMPORT_BODY .= '<br>&nbsp;&nbsp;&nbsp;(connected with a "see also" link to the Compendium To Node)</li>';
$LNG->PAGE_COMPENDIUM_IMPORT_BODY .= '<li>Compendium Map -> Evidence Hub Issue';
$LNG->PAGE_COMPENDIUM_IMPORT_BODY .= '<br>&nbsp;&nbsp;&nbsp;(connected to all the child Issues in the map with a "see also" against the Map)</li>';
$LNG->PAGE_COMPENDIUM_IMPORT_BODY .= '<li>Compendium List -> Evidence Hub Issue';
$LNG->PAGE_COMPENDIUM_IMPORT_BODY .= '<br>&nbsp;&nbsp;&nbsp;(connected to all the children in the list with a "see also" against the List)</li></ul>';

$LNG->PAGE_COMPENDIUM_IMPORT_BODY .= '<p>If you have any issues or questions please <a href="mailto:<?php echo $CFG->EMAIL_REPLY_TO; ?>">email us</a> or join our <a target="_blank" href="http://evidence-hub.net/open-source/community/">Evidence Hub Google group</a> and post them there.</p>';
?>