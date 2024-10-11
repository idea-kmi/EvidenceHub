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

$LNG->PAGE_ABOUT_TITLE = "About ".$CFG->SITE_TITLE;

$LNG->PAGE_ABOUT_BODY = '<h2>ESPLORA E CONDIVIDI</h2>';

$LNG->PAGE_ABOUT_BODY .= '<p style="width: 430px;font-weight:bold;">';
$LNG->PAGE_ABOUT_BODY .= '<span style="font-size:10pt;">
La tua esperienza di esperto, ricercatore, tecnico, decisore pubblico, o portatore di interesse
</span>';
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
	$LNG->PAGE_ABOUT_BODY .= '<span style="font-size:10pt;">Dibattito sulla ricerca - '.$LNG->CLAIMS_NAME.'	pensa che la ricerca in questo campo ci permetta di fare
	</span>';
}
$LNG->PAGE_ABOUT_BODY .= '<img src="'.$HUB_FLM->getImagePath('grey-dot.png').'" border="0" />';
$LNG->PAGE_ABOUT_BODY .= '<span style="font-size:10pt;color:#4e247b">le tue '.$LNG->EVIDENCES_NAME.' favorevoli o contrarie</span>';
$LNG->PAGE_ABOUT_BODY .= '<img src="'.$HUB_FLM->getImagePath('grey-dot.png').'" border="0" />';
$LNG->PAGE_ABOUT_BODY .= '<span style="font-size:10pt;">I tuoi '.$LNG->PROJECTS_NAME.' e '.$LNG->ORGS_NAME.'</span>';
$LNG->PAGE_ABOUT_BODY .= '<img src="'.$HUB_FLM->getImagePath('grey-dot.png').'" border="0" />';
$LNG->PAGE_ABOUT_BODY .= '<span style="font-size:10pt;color:#4e247b">Le '.$LNG->RESOURCES_NAME.' rilevanti</span>';
$LNG->PAGE_ABOUT_BODY .= '</p>';

$LNG->PAGE_ABOUT_BODY .= '<h2>UNISCITI A NOI</h2>';
$LNG->PAGE_ABOUT_BODY .= '<p>
Il '.$CFG->SITE_TITLE.' vuole raccogliere istanze rilevanti per supportare Città Metropolitana di Milano nel percorso
di costruzione dell’Agenda Metropolinana Urbana per lo Sviluppo sostenibile. Questo strumento mira a fornire un ambiente virtuale per interrogare
sistematicamente questa comunità su quali sono i soggetti, i progetti, le organizzazioni, le sfide, e le proposte che la sostengono.
</p>';

$LNG->PAGE_ABOUT_BODY .= '<h2>OMS</h2>';
$LNG->PAGE_ABOUT_BODY .= '<p>L\'Evidence Hub è sviluppato da ';
$LNG->PAGE_ABOUT_BODY .= '<a href="http://projects.kmi.open.ac.uk/hyperdiscourse/">Knowledge Media Institute</a> ';
$LNG->PAGE_ABOUT_BODY .= 'team (<a target="About" href="http://kmi.open.ac.uk/people/sbs">Simon Buckingham Shum</a>, ';
$LNG->PAGE_ABOUT_BODY .= '<a target="About" href="http://people.kmi.open.ac.uk/anna/index.html">Anna De Liddo</a> and ';
$LNG->PAGE_ABOUT_BODY .= '<a target="About" href="http://kmi.open.ac.uk/people/bachler">Michelle Bachler</a>) ';
$LNG->PAGE_ABOUT_BODY .= 'ed è parte di una famiglia di <a href="http://evidence-hub.net/">Evidence Hubs</a>.';
$LNG->PAGE_ABOUT_BODY .= '<br />Siamo grati a <a target="About" href="http://kmi.open.ac.uk/people/harry/">Harriett Cornish</a> per il graphic design.</p> ';

$LNG->PAGE_ABOUT_BODY .= '<h2>COSA</h2>';

$LNG->PAGE_ABOUT_BODY .= '<p>L\'Evidence Hub mira a fornire a ricercatori, professionisti e a tutti i soggetti interessati
una mappatura dinamica e vivente di dove si sta dirigendo la comunità di soggetti attivi nella promozione di azioni in linea
con il raggiungimento di obiettivi di sostenibilità ambientale, economica e sociale.
</p>';

$LNG->PAGE_ABOUT_BODY .= '<p>
Per fare questo <a href="'.$CFG->homeAddress.'">'.$CFG->homeAddress.'</a> fornisce a studiosi, ricercatori e professionisti un ambiente in cui:
';
$LNG->PAGE_ABOUT_BODY .= '<ul>';
$LNG->PAGE_ABOUT_BODY .= '<li>segnalare e mappare nuovi <b>progetti, servizi e iniziative</b> e <b>organizzazioni</b></li>';
$LNG->PAGE_ABOUT_BODY .= '<li>pubblicare, esplorare e discutere nuove <b>sfide</b> e domande</li>';
$LNG->PAGE_ABOUT_BODY .= '<li>formulare nuove <b>proposte</b> per far fronte alle sfide legate allo sviluppo sostenibile</li>';
$LNG->PAGE_ABOUT_BODY .= '<li>condividere <b>materiali</b> e <b>risorse</b> che possono contribuire allo sviluppo dell\'Agenda Metropolitana Urbana per lo sviluppo sostenibile</li>';
$LNG->PAGE_ABOUT_BODY .= '<li>discutere  e proporre nuove <b>idee</b></li>';
$LNG->PAGE_ABOUT_BODY .= '</ul>';
$LNG->PAGE_ABOUT_BODY .= '</p>';

$LNG->PAGE_ABOUT_BODY .= '<h2>COME</h2>';

$LNG->PAGE_ABOUT_BODY .= '<p>L\'Evidence Hub si basa sulla ricerca su intelligenza collettiva, processi di
costruzione di senso, mappatura della conoscenza e tecnologie. Questo strumento fornisce un ambiente in cui,
compilando semplici moduli web, gli utenti possono aggiungere le proprie conoscenze, idee, interpretazioni e
vederle immediatamente mappate all\'interno della mappa del network.
</p>';

$LNG->PAGE_ABOUT_BODY .= '<p>
Aggregando ed estraendo singoli contributi forniti dall\'Evidence Hubuna si può ottenere una visione collettiva
di questa comunità. Questo quadro può essere esplorato sotto forma di una semplice interfaccia testuale
(come elenco di '.$LNG->ORGS_NAME.',';

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
$LNG->PAGE_ABOUT_BODY .= $LNG->EVIDENCES_NAME.', o '.$LNG->RESOURCES_NAME.') o in modo più visivo come mappa della rete.</p>';

$LNG->PAGE_ABOUT_BODY .= '<p>
La piattaforma consente a diversi utenti di costruire questa rete progressivamente a partire
da un contenuto condiviso, facilitando così la produzione e la scoperta di conoscenza collaborativa.
</p>';

$LNG->PAGE_ABOUT_BODY .= '<p>
Inoltre, il sistema fornisce agli utenti consigli contestuali basati su temi corrispondenti.
Ciò significa, ad esempio, che se hai presentato una proposta, condiviso materiali o un dato su questioni relative all\'adattamento
al cambiamento climatico, ti verranno suggeriti altri dati rilevanti sullo stesso tema.
</p>';

$LNG->PAGE_ABOUT_BODY .= '<p>
Il sistema consente inoltre di aggiungere facilmente prove o presentare controprove alle altre persone,
favorendo così uno scambio di opinioni e di conoscenze tra soggetti che affrontano questioni simili.
</p>';

$LNG->PAGE_ABOUT_BODY .= '<p>
Infine, l\'Evidence Hub consente agli utenti di visualizzare, esplorare e far parte delle reti degli
altri soggetti che costituiscono questa comunità.
</p>';

$LNG->PAGE_ABOUT_BODY .= '<p>
L\'Evidence Hub fa parte della famiglia di software Cohere che sono strumenti di social web per la mappatura
della conoscenza e annotazione collaborativa sviluppata dal team di hypermedia discourse di KMi. Questi strumenti:
';

$LNG->PAGE_ABOUT_BODY .= '<ul>';
$LNG->PAGE_ABOUT_BODY .= '<li>raccolgono prove annotando risorse web gratuite, quindi utilizzando clip di testo per fondare le proprie affermazioni</li>';
$LNG->PAGE_ABOUT_BODY .= '<li>sfrutta la visualizzazione avanzata della rete, la ricerca e il filtraggio per interrogare ed esplorare le mappe di rete di ';
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
$LNG->PAGE_ABOUT_BODY .= $LNG->EVIDENCES_NAME.', '.$LNG->RESOURCES_NAME.' e '.$LNG->THEMES_NAME.'</li>';
$LNG->PAGE_ABOUT_BODY .= '<li>
sviluppano un portfolio personale di questi elementi
</li></ul>
Questa funzionalità avanzata verrà aggiunta all\'Evidence Hub in futuro.
</p>';
?>
