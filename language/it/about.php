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

$LNG->PAGE_ABOUT_TITLE = "About ".$CFG->SITE_TITLE;

$LNG->PAGE_ABOUT_BODY = '<h2>EXPLORE + SHARE</h2>';

$LNG->PAGE_ABOUT_BODY .= '<p style="width: 430px;font-weight:bold;">';
$LNG->PAGE_ABOUT_BODY .= '<span style="font-size:10pt;">La tua esperienza di esparto, ricercatore, tecnico, decisore pubblico, o portatore di interesse</span>';
if ($CFG->HAS_CHALLENGE) {
	$LNG->PAGE_ABOUT_BODY .= '<img src="'.$HUB_FLM->getImagePath('grey-dot.png').'" border="0" />';
	$LNG->PAGE_ABOUT_BODY .= '<span style="font-size:10pt;color:#4e247b">'.$LNG->CHALLENGES_NAME.'</span>';
}

$LNG->PAGE_ABOUT_BODY .= '<img src="'.$HUB_FLM->getImagePath('grey-dot.png').'" border="0" />';
$LNG->PAGE_ABOUT_BODY .= '<span style="font-size:10pt;">'.$LNG->ISSUES_NAME.'</span>';

if ($CFG->HAS_SOLUTION) {
	$LNG->PAGE_ABOUT_BODY .= '<img src="'.$HUB_FLM->getImagePath('grey-dot.png').'" border="0" />';
	$LNG->PAGE_ABOUT_BODY .= '<span style="font-size:10pt;">'.$LNG->SOLUTIONS_NAME.'</span>';
}
if ($CFG->HAS_CLAIM) {
	$LNG->PAGE_ABOUT_BODY .= '<img src="'.$HUB_FLM->getImagePath('grey-dot.png').'" border="0" />';
	$LNG->PAGE_ABOUT_BODY .= '<span style="font-size:10pt;">Research Debate - '.$LNG->CLAIMS_NAME.' pensa che la ricerca in questo campo ci permetta di fare</span>';
}
$LNG->PAGE_ABOUT_BODY .= '<img src="'.$HUB_FLM->getImagePath('grey-dot.png').'" border="0" />';
$LNG->PAGE_ABOUT_BODY .= '<span style="font-size:10pt;color:#4e247b">Supportare (e sfidare)'.$LNG->EVIDENCES_NAME.'</span>';
$LNG->PAGE_ABOUT_BODY .= '<img src="'.$HUB_FLM->getImagePath('grey-dot.png').'" border="0" />';
$LNG->PAGE_ABOUT_BODY .= '<span style="font-size:10pt;">I tuoi '.$LNG->PROJECTS_NAME.' e '.$LNG->ORGS_NAME.'</span>';
$LNG->PAGE_ABOUT_BODY .= '<img src="'.$HUB_FLM->getImagePath('grey-dot.png').'" border="0" />';
$LNG->PAGE_ABOUT_BODY .= '<span style="font-size:10pt;color:#4e247b">Le '.$LNG->RESOURCES_NAME.' rilevanti</span>';
$LNG->PAGE_ABOUT_BODY .= '</p>';

$LNG->PAGE_ABOUT_BODY .= '<h2>UNISCITI A NOI</h2>';
$LNG->PAGE_ABOUT_BODY .= '<p>The '.$CFG->SITE_TITLE.' mira a fornire un ambiente virtuale per interrogare sistematicamente questa comunità su quali sono i soggetti, i progetti, le organizzazioni, le sfide, e le proposte che la sostengono. In definitiva, questo sito Web creerà un hub di istanze che rappresenta e mappa la conoscenza collettiva intorno a questa comunità.</p>';

$LNG->PAGE_ABOUT_BODY .= '<h2>OMS</h2>';
$LNG->PAGE_ABOUT_BODY .= '<p>L\'Evidence Hub è sviluppato da ';
$LNG->PAGE_ABOUT_BODY .= '<a href="http://projects.kmi.open.ac.uk/hyperdiscourse/">Knowledge Media Institute</a> ';
$LNG->PAGE_ABOUT_BODY .= 'team (<a target="About" href="http://kmi.open.ac.uk/people/sbs">Simon Buckingham Shum</a>, ';
$LNG->PAGE_ABOUT_BODY .= '<a target="About" href="http://people.kmi.open.ac.uk/anna/index.html">Anna De Liddo</a> and ';
$LNG->PAGE_ABOUT_BODY .= '<a target="About" href="http://kmi.open.ac.uk/people/bachler">Michelle Bachler</a>) ';
$LNG->PAGE_ABOUT_BODY .= 'and is part of a family of <a href="http://evidence-hub.net/">Evidence Hubs</a>.';
$LNG->PAGE_ABOUT_BODY .= '<br />Siamo grati a <a target="About" href="http://kmi.open.ac.uk/people/harry/">Harriett Cornish</a> per il graphic design.</p> ';

// This needs to be site specific
//$LNG->PAGE_ABOUT_BODY .= '<h2>PERCHÉ</h2>';
//$LNG->PAGE_ABOUT_BODY .= '<p></p>';

$LNG->PAGE_ABOUT_BODY .= '<h2>CHE COSA</h2>';

$LNG->PAGE_ABOUT_BODY .= '<p>L\'Evidence Hub mira a fornire a ricercatori, professionisti e a tutti i soggetti interessati una mappa dinamica e vivente di dove si sta dirigendo la comunità.';
$LNG->PAGE_ABOUT_BODY .= '<br>Il nostro obiettivo è costruire un ambiente Web sociale che funzioni come un <b>Collective Evidence Hub</b> per questa comunità.';
$LNG->PAGE_ABOUT_BODY .= '</p>';

$LNG->PAGE_ABOUT_BODY .= '<p>per fare questo <a href="'.$CFG->homeAddress.'">'.$CFG->homeAddress.'</a> fornisce a studiosi, ricercatori e professionisti un ambiente in cui:';
$LNG->PAGE_ABOUT_BODY .= '<ul>';
$LNG->PAGE_ABOUT_BODY .= '<li>nuovi <b>progetti, servizi e iniziative</b> e <b>organizzazioni</b> possono essere aggiunti al network, </li>';
$LNG->PAGE_ABOUT_BODY .= '<li>nuove <b>sfide</b> e domande possono essere pubblicate, esplorate e discusse, </li>';
$LNG->PAGE_ABOUT_BODY .= '<li>nuove <b>proposte</b> per far fronte alle sfide legate allo sviluppo sostenibile possono essere formulate </li>';
$LNG->PAGE_ABOUT_BODY .= '<li>rilevanti <b>materiali</b> e <b>risorse</b> possono essere condivisi per contribuire allo sviluppo dell\'Agenda Metropolitana Urbana per lo sviluppo sostenibile</li>';
$LNG->PAGE_ABOUT_BODY .= '<li>nuove <b>idee</b> possano essere proposte e discusse </li>';
$LNG->PAGE_ABOUT_BODY .= '</ul>';
$LNG->PAGE_ABOUT_BODY .= '</p>';

$LNG->PAGE_ABOUT_BODY .= '<h2>HOW</h2>';
$LNG->PAGE_ABOUT_BODY .= '<p> L\'Evidence Hub si basa sulla ricerca sull\'intelligenza collettiva, ';
$LNG->PAGE_ABOUT_BODY .= 'processi di costruzione di senso, mappatura della conoscenza e tecnologie e fornisce';
$LNG->PAGE_ABOUT_BODY .= 'un ambiente in cui, compilando semplici moduli web, gli utenti possono aggiungere le proprie';
$LNG->PAGE_ABOUT_BODY .= 'conoscenze, idee, interpretazioni e vederle immediatamente mappate all\'interno della ';
$LNG->PAGE_ABOUT_BODY .= '</p>mappa del network';

$LNG->PAGE_ABOUT_BODY .= '<p>Aggregando ed estraendo singoli contributi forniti dall\'Evidence Hub';
$LNG->PAGE_ABOUT_BODY .= 'una visione collettiva di questa comunità. Questo quadro può essere';
$LNG->PAGE_ABOUT_BODY .= 'esplorato sotto forma di una semplice interfaccia testuale (come elenco di organizzazioni,';
if ($CFG->HAS_CHALLENGE) {
	$LNG->PAGE_ABOUT_BODY .= $LNG->CHALLENGES_NAME.', ';
}
$LNG->PAGE_ABOUT_BODY .= $LNG->ISSUES_NAME.', ';
if ($CFG->HAS_SOLUTION) {
	$LNG->PAGE_ABOUT_BODY .= $LNG->SOLUTIONS_NAME.', ';
}

if ($CFG->HAS_CLAIM) {
	$LNG->PAGE_ABOUT_BODY .= $LNG->CLAIMS_NAME.', ';
}
$LNG->PAGE_ABOUT_BODY .= $LNG->EVIDENCES_NAME.', '.$LNG->RESOURCES_NAME.', ) o in modo più visivo come mappa della rete. </p>';

$LNG->PAGE_ABOUT_BODY .= '<p>La piattaforma consente a diversi utenti di costruire progressivamente e in modo collaborativo a partire da un contenuto condiviso';
$LNG->PAGE_ABOUT_BODY .= ', facilitando così la produzione e la scoperta di conoscenza collaborativa.</p>';

$LNG->PAGE_ABOUT_BODY .= '<p>Inoltre il sistema fornisce agli utenti consigli contestuali basati su temi corrispondenti.';
$LNG->PAGE_ABOUT_BODY .= 'TCiò significa, ad esempio, che se hai presentato un reclamo, condiviso materiali o un dato';
$LNG->PAGE_ABOUT_BODY .= 'su questioni relative all\'adattamento al cambiamento climatico, altri dati rilevanti sullo stesso tema ti verranno suggeriti per l\'esplorazione.</p>';

$LNG->PAGE_ABOUT_BODY .= '<p>Il sistema consente inoltre di aggiungere facilmente prove o presentare controprove alle altre persone';
$LNG->PAGE_ABOUT_BODY .= 'favorendo così uno scambio di opinioni e di conoscenze tra persone che affrontano questioni simili.</p>';

$LNG->PAGE_ABOUT_BODY .= '<p>Infine, l\'Evidence Hub consente agli utenti di visualizzare, esplorare e far parte delle reti degli';
$LNG->PAGE_ABOUT_BODY .= 'altri soggetti che costituiscono questa comunità.</p>';

$LNG->PAGE_ABOUT_BODY .= '<p>L\'Evidence Hub fa parte della famiglia di software Cohere che sono strumenti di social web per la mappatura della conoscenza e';
$LNG->PAGE_ABOUT_BODY .= 'annotazione collaborativa sviluppata dal team di hypermedia discourse di KMi. ';

$LNG->PAGE_ABOUT_BODY .= '<ul>';
$LNG->PAGE_ABOUT_BODY .= '<li>raccogliere prove annotando risorse web gratuite, quindi utilizzando clip di testo per fondare le proprie affermazioni.</li>';
$LNG->PAGE_ABOUT_BODY .= '<li>Sfrutta la visualizzazione avanzata della rete, la ricerca e il filtraggio per interrogare ed esplorare le mappe di rete di ';
if ($CFG->HAS_CHALLENGE) {
	$LNG->PAGE_ABOUT_BODY .= $LNG->CHALLENGES_NAME.', ';
}
$LNG->PAGE_ABOUT_BODY .= $LNG->ISSUES_NAME.', ';
if ($CFG->HAS_SOLUTION) {
	$LNG->PAGE_ABOUT_BODY .= $LNG->SOLUTIONS_NAME.', ';
}

if ($CFG->HAS_CLAIM) {
	$LNG->PAGE_ABOUT_BODY .= $LNG->CLAIMS_NAME.', ';
}
$LNG->PAGE_ABOUT_BODY .= $LNG->EVIDENCES_NAME.', '.$LNG->RESOURCES_NAME.' and '.$LNG->THEMES_NAME.'.</li>';
$LNG->PAGE_ABOUT_BODY .= '<li>Sviluppa un portfolio personale di questi elementi.</li>';
$LNG->PAGE_ABOUT_BODY .= '</ul>';
$LNG->PAGE_ABOUT_BODY .= 'Questa funzionalità avanzata verrà aggiunta lentamente all\'Evidence Hub in futuro.';
$LNG->PAGE_ABOUT_BODY .= '</p>';
?>
