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

$LNG->PAGE_BIBTEX_IMPORT_TITLE = 'Come importare voci BiBTex nell\'Evidence Hub';

$LNG->PAGE_BIBTEX_IMPORT_BODY = '<p>Per importare un file <a href="http://www.bibtex.org/">Bib TeX</a> nella piattaforma';
$LNG->PAGE_BIBTEX_IMPORT_BODY .= 'le voci nel file BibTeX devono avere un parametro \'url\' e un parametro \'titolo\', altrimenti l\'importazione ignorerà la voce.';

$LNG->PAGE_BIBTEX_IMPORT_BODY .= '<p>L\'importazione viene elaborata come segue:</p>';

$LNG->PAGE_BIBTEX_IMPORT_BODY .= '<ul><li>Ogni voce qualificante (avente un \'url\' e un \'titolo\'), verrà importata come una Risorsa di tipo <b>Pubblicazioni</b></li>';
$LNG->PAGE_BIBTEX_IMPORT_BODY .= '<li>Il campo \'titolo\' della voce Bib TeX diventerà il riepilogo delle risorse. </li>';
$LNG->PAGE_BIBTEX_IMPORT_BODY .= '<li>Il campo \'url\' della voce Bib TeX diventerà l\'URL della risorsa. </li>';
$LNG->PAGE_BIBTEX_IMPORT_BODY .= '<li>Se presente, il campo \'DOI\' della voce Bib TeX diventerà il DOI Risorsa. </li>';
$LNG->PAGE_BIBTEX_IMPORT_BODY .= '<li>Se presenti, i campi della voce Bib TeX \'Autore\' e \'Anno\' diventeranno una voce di clip sulla Risorsa.<br>';
$LNG->PAGE_BIBTEX_IMPORT_BODY .= '<li>Se presente, il campo \'Abstract\' della voce Bib TeX diventerà una voce clip sulla Risorsa.<br>';
$LNG->PAGE_BIBTEX_IMPORT_BODY .= '<li>Tutti gli altri campi saranno ignorati. <br>';
$LNG->PAGE_BIBTEX_IMPORT_BODY .= '</ul>';

$LNG->PAGE_BIBTEX_IMPORT_BODY .= '<p>n caso di problemi o domande, per favore <a href="mailto:<?php echo $CFG->EMAIL_REPLY_TO; ?>">contattateci </a> o uniteci <a target="_blank" href="http://evidence-hub.net/open-source/community/">al gruppo Google Evidence Hub/a> e scriveteci li.</p>';
?>