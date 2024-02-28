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

$LNG->PAGE_BIBTEX_IMPORT_TITLE = 'Importing Bib TeX entries into the Evidence Hub';

$LNG->PAGE_BIBTEX_IMPORT_BODY = '<p>In order to import a <a href="http://www.bibtex.org/">Bib TeX</a> file into this Hub ';
$LNG->PAGE_BIBTEX_IMPORT_BODY .= 'the entries in the BibTeX file must have a \'url\' parameter and a \'title\' parameter, otherwise the import will ignore the entry.';

$LNG->PAGE_BIBTEX_IMPORT_BODY .= '<p>The import is processed as follows: </p>';

$LNG->PAGE_BIBTEX_IMPORT_BODY .= '<ul><li>Each entry qualifying (having a \'url\' and \'title\'), will be imported as a Resource of type <b>Publication</b></li>';
$LNG->PAGE_BIBTEX_IMPORT_BODY .= '<li>The Bib TeX entry \'title\' field will become the Resource summary.</li>';
$LNG->PAGE_BIBTEX_IMPORT_BODY .= '<li>The Bib TeX entry \'url\' field will become the Resource url.</li>';
$LNG->PAGE_BIBTEX_IMPORT_BODY .= '<li>If present, the Bib TeX entry \'DOI\' field will become the Resource DOI.</li>';
$LNG->PAGE_BIBTEX_IMPORT_BODY .= '<li>If present, the Bib TeX entry \'Author\' and \'Year\' fields will become a clip entry on the Resource.<br>';
$LNG->PAGE_BIBTEX_IMPORT_BODY .= '<li>If present, the Bib TeX entry \'Abstract\' field will become a clip entry on the Resource.<br>';
$LNG->PAGE_BIBTEX_IMPORT_BODY .= '<li>All other fields will be ignored.<br>';
$LNG->PAGE_BIBTEX_IMPORT_BODY .= '</ul>';

$LNG->PAGE_BIBTEX_IMPORT_BODY .= '<p>If you have any issues or questions please <a href="mailto:<?php echo $CFG->EMAIL_REPLY_TO; ?>">email us</a> or join our <a target="_blank" href="http://evidence-hub.net/open-source/community/">Evidence Hub Google group</a> and post them there.</p>';
?>