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

$LNG->PAGE_HELP_TITLE = "Aiuto";

$LNG->PAGE_HELP_BODY = '<p>
L\'Evidence Hub è costituito da una serie di elementi che rappresentano le principali tipologie di informazioni che possono essere aggiunte al Sito.
';

$LNG->PAGE_HELP_BODY .= '<br />Queste sono: ';
if ($CFG->HAS_CHALLENGE) {
	$LNG->PAGE_HELP_BODY .= $LNG->CHALLENGES_NAME.', ';
}
$LNG->PAGE_HELP_BODY .= $LNG->ISSUES_NAME.', ';
if ($CFG->HAS_SOLUTION) {
	$LNG->PAGE_HELP_BODY .= $LNG->SOLUTIONS_NAME.', ';
}
if ($CFG->HAS_CLAIM) {
	$LNG->PAGE_HELP_BODY .= $LNG->CLAIMS_NAME.', ';
}
$LNG->PAGE_HELP_BODY .=  $LNG->RESOURCES_NAME.', '.$LNG->PROJECTS_NAME.', '.$LNG->ORGS_NAME.'.</p>';

$LNG->PAGE_HELP_BODY .= '<p>
Di seguito vedrai un elenco di riquadri colorati che descrivono ciascuna di queste categorie.
Se fai clic su una casella, verrà visualizzato un pannello a discesa con le informazioni di aiuto su una categoria.
</p>';

$LNG->PAGE_HELP_BODY .= '<p>
La casella in basso a destra rappresenta un diverso tipo di informazioni chiamate "Storie". Una storia è una catena di connessioni
';
if ($CFG->HAS_CHALLENGE) {
	$LNG->PAGE_HELP_BODY .= $LNG->CHALLENGES_NAME.'&gt;';
}
$LNG->PAGE_HELP_BODY .= $LNG->ISSUES_NAME.'&gt;';
if ($CFG->HAS_SOLUTION) {
	$LNG->PAGE_HELP_BODY .= $LNG->SOLUTIONS_NAME;
}
if ($CFG->HAS_SOLUTION && $CFG->HAS_CLAIM) {
	$LNG->PAGE_HELP_BODY .= '/';
}
if ($CFG->HAS_CLAIM) {
	$LNG->PAGE_HELP_BODY .= $LNG->CLAIMS_NAME;
}
$LNG->PAGE_HELP_BODY .= '&gt;'.$LNG->EVIDENCES_NAME.'&gt;'.$LNG->RESOURCES_NAME;
$LNG->PAGE_HELP_BODY .= ' che può essere aggiunta in una volta all\'Evidence Hub utilizzando un\'interfaccia Wizard. ';
$LNG->PAGE_HELP_BODY .= 'Fare clic sulla casella "Storie" per ulteriori informazioni e collegamenti al modulo della procedura guidata per aggiungere una nuova storia.';


$LNG->PAGE_HELP_BODY .= '</p>';

$LNG->PAGE_HELP_BODY .= '<div style="float:left;width:99%;padding-top:10px;margin-bottom:20px;">';

if ($CFG->HAS_CHALLENGE) {
	$LNG->PAGE_HELP_BODY .= '<table cellspacing="10" style="margin: 0 auto;border-spacing:10px 0px;width: 100%;">';
	$LNG->PAGE_HELP_BODY .= '<tr>';
	$LNG->PAGE_HELP_BODY .= '<td width="33%">&nbsp;</td>';
	$LNG->PAGE_HELP_BODY .= '<td width="33%">';
	$LNG->PAGE_HELP_BODY .= '<div id="challengehomebutton" style="cursor:pointer;height:174px; padding:5px; font-weight:bold;" class="plainbackgradient plainborder curvedBorder homebutton1" onmouseover="this.className=\'challengebackgradient challengeborder curvedBorder homebutton1\';" onmouseout="if ($(\'homebuttonmessagediv3\').style.display == \'none\' || $(\'homebuttonmessagelasttype3\').value != \'challenge\') {this.className=\'plainbackgradient plainborder curvedBorder homebutton1\';}" title="Clicca qui per visualizzare/nascondere ulteriori informazioni" onclick="showHomeButtonText3(event, \'challenge\');">';
	$LNG->PAGE_HELP_BODY .= '<div style="margin: 0 auto; width:64px;margin-bottom:5px;">';
	$LNG->PAGE_HELP_BODY .= '<img src="'.$HUB_FLM->getImagePath('nodetypes/Default/challenge64px.png').'" border="0" />';
	$LNG->PAGE_HELP_BODY .= '</div>';
	$LNG->PAGE_HELP_BODY .= '<div style="margin: 0 auto;padding:0px;"><center><h2>'.$LNG->CHALLENGES_NAME.'</h2></center><center>Clicca qui per saperne di più.</center></div>';
	$LNG->PAGE_HELP_BODY .= '</div>';
	$LNG->PAGE_HELP_BODY .= '</td>';
	$LNG->PAGE_HELP_BODY .= '<td width="33%">&nbsp;</td>';
	$LNG->PAGE_HELP_BODY .= '</tr>';
	$LNG->PAGE_HELP_BODY .= '</table>';

	$LNG->PAGE_HELP_BODY .= '<table style="margin: 0 auto;padding-right:15px;width:100%;margin-bottom:10px;">';
	$LNG->PAGE_HELP_BODY .= '<tr>';
	$LNG->PAGE_HELP_BODY .= '<td>';
	$LNG->PAGE_HELP_BODY .= '<div id="homebuttonmessagediv3" class="plainborder curvedBorder" style="clear:both;float:left;width:99%;display:none;margin-left:10px;">';
	$LNG->PAGE_HELP_BODY .= '<input type="hidden" id="homebuttonmessagelasttype3" value="" />';
	$LNG->PAGE_HELP_BODY .= '<div style="clear:both;float:left;padding:10px;padding-top:0px;" id="homebuttonmessage3"></div>';
	$LNG->PAGE_HELP_BODY .= '</div>';
	$LNG->PAGE_HELP_BODY .= '</td>';
	$LNG->PAGE_HELP_BODY .= '</tr>';
	$LNG->PAGE_HELP_BODY .= '</table>';
}

$LNG->PAGE_HELP_BODY .= '<table cellspacing="10" style="margin: 0 auto;border-spacing:10px 0px;width: 100%;">';
$LNG->PAGE_HELP_BODY .= '<tr>';
$LNG->PAGE_HELP_BODY .= '<td width="33%">';
$LNG->PAGE_HELP_BODY .= '<div id="issuehomebutton" style="cursor:pointer;height:174px; padding:5px; font-weight:bold;" class="plainbackgradient plainborder curvedBorder homebutton1" onmouseover="this.className=\'issuebackgradient issueborder curvedBorder homebutton1\';" onmouseout="if ($(\'homebuttonmessagediv\').style.display == \'none\' || $(\'homebuttonmessagelasttype\').value != \'issue\') {this.className=\'plainbackgradient plainborder curvedBorder homebutton1\';}" title="Clicca qui per visualizzare/nascondere ulteriori informazioni" onclick="showHomeButtonText(event, \'issue\');">';
$LNG->PAGE_HELP_BODY .= '<div style="margin: 0 auto; width:64px;margin-bottom:5px;">';
$LNG->PAGE_HELP_BODY .= '<img src="'.$HUB_FLM->getImagePath('nodetypes/Default/issue64px.png').'" border="0" />';
$LNG->PAGE_HELP_BODY .= '</div>';

$LNG->PAGE_HELP_BODY .= '<div style="padding:0px;"><center><h2>'.$LNG->ISSUES_NAME.'</h2></center>';
$LNG->PAGE_HELP_BODY .= '<center>Clicca qui per saperne di più.</center>';
$LNG->PAGE_HELP_BODY .= '</div>';
$LNG->PAGE_HELP_BODY .= '</div>';
$LNG->PAGE_HELP_BODY .= '</td>';

$LNG->PAGE_HELP_BODY .= '<td width="33%">';
$LNG->PAGE_HELP_BODY .= '<div id="solutionhomebutton" style="cursor:pointer;height:174px; padding:5px; font-weight:bold;" class="plainbackgradient plainborder curvedBorder homebutton1" onmouseover="this.className=\'solutionbackgradient solutionborder curvedBorder homebutton1\';" onmouseout="if ($(\'homebuttonmessagediv\').style.display == \'none\' || $(\'homebuttonmessagelasttype\').value != \'solutin\') {this.className=\'plainbackgradient plainborder curvedBorder homebutton1\';}" title="Clicca qui per visualizzare/nascondere ulteriori informazioni" onclick="showHomeButtonText(event, \'solution\');">';
if ($CFG->HAS_SOLUTION && $CFG->HAS_CLAIM) {
	$LNG->PAGE_HELP_BODY .= '<div style="margin: 0 auto; width:140px;margin-bottom:5px;">';
} else {
	$LNG->PAGE_HELP_BODY .= '<div style="margin: 0 auto; width:64px;margin-bottom:5px;">';
}
if ($CFG->HAS_SOLUTION) {
	$LNG->PAGE_HELP_BODY .= '<img src="'.$HUB_FLM->getImagePath('nodetypes/Default/solution64px.png').'" border="0" />';
}
if ($CFG->HAS_CLAIM) {
	$LNG->PAGE_HELP_BODY .= '<img src="'.$HUB_FLM->getImagePath('nodetypes/Default/claim64px.png').'" border="0" />';
}
$LNG->PAGE_HELP_BODY .= '</div>';

$LNG->PAGE_HELP_BODY .= '<div style="padding:0px;width:100%"> ';
$LNG->PAGE_HELP_BODY .= '<center><h2>';
if ($CFG->HAS_SOLUTION) {
	$LNG->PAGE_HELP_BODY .= $LNG->SOLUTIONS_NAME;
}
if ($CFG->HAS_SOLUTION  && $CFG->HAS_CLAIM) {
	$LNG->PAGE_HELP_BODY .= ' and ';

}
if ($CFG->HAS_CLAIM) {
	$LNG->PAGE_HELP_BODY .= $LNG->CLAIMS_NAME;
}
$LNG->PAGE_HELP_BODY .= '</h2></center>';
$LNG->PAGE_HELP_BODY .= '<center>Clicca in questa casella per saperne di più.</center>';
$LNG->PAGE_HELP_BODY .= '</div>';
$LNG->PAGE_HELP_BODY .= '</div>';
$LNG->PAGE_HELP_BODY .= '</td>';


$LNG->PAGE_HELP_BODY .= '<td width="33%">';
$LNG->PAGE_HELP_BODY .= '<div id="evidencehomebutton" style="cursor:pointer;height:174px; padding:5px; font-weight:bold;" class="plainbackgradient plainborder curvedBorder homebutton1" onmouseover="this.className=\'evidencebackgradient evidenceborder curvedBorder homebutton1\';" onmouseout="if ($(\'homebuttonmessagediv\').style.display == \'none\' || $(\'homebuttonmessagelasttype\').value != \'evidence\') {this.className=\'plainbackgradient plainborder curvedBorder homebutton1\'}" title="Clicca qui per visualizzare/nascondere ulteriori informazioni" onclick="showHomeButtonText(event, \'evidence\');">';
$LNG->PAGE_HELP_BODY .= '<div style="margin: 0 auto; width:64px;margin-bottom:5px;">';
$LNG->PAGE_HELP_BODY .= '<img src="'.$HUB_FLM->getImagePath('nodetypes/Default/literature-analysis64px.png').'" border="0" />';
$LNG->PAGE_HELP_BODY .= '</div>';
$LNG->PAGE_HELP_BODY .= '<div style="padding:0px;">';
$LNG->PAGE_HELP_BODY .= '<center><h2>'.$LNG->EVIDENCES_NAME.'</h2></center>';
$LNG->PAGE_HELP_BODY .= '<center>Clicca qui per saperne di più.</center>';
$LNG->PAGE_HELP_BODY .= '</div>';
$LNG->PAGE_HELP_BODY .= '</div>';
$LNG->PAGE_HELP_BODY .= '</td>';

$LNG->PAGE_HELP_BODY .= '</tr>';

$LNG->PAGE_HELP_BODY .= '</table>';

$LNG->PAGE_HELP_BODY .= '<table style="margin: 0 auto;padding-right:15px;width:100%;margin-bottom:10px;width: 100%;">';
$LNG->PAGE_HELP_BODY .= '<tr>';
$LNG->PAGE_HELP_BODY .= '<td>';
$LNG->PAGE_HELP_BODY .= '<div id="homebuttonmessagediv" class="plainborder curvedBorder" style="clear:both;float:left;width:99%;display:none;margin-left:10px;">';
$LNG->PAGE_HELP_BODY .= '<input type="hidden" id="homebuttonmessagelasttype" value="" />';
$LNG->PAGE_HELP_BODY .= '<div style="clear:both;float:left;padding:10px;padding-top:0px;" id="homebuttonmessage"></div>';
$LNG->PAGE_HELP_BODY .= '</div>';
$LNG->PAGE_HELP_BODY .= '</td>';
$LNG->PAGE_HELP_BODY .= '</tr>';
$LNG->PAGE_HELP_BODY .= '</table>';

$LNG->PAGE_HELP_BODY .= '<table cellspacing="10" style="margin: 0 auto;border-spacing:10px 0px;width:100%">';
$LNG->PAGE_HELP_BODY .= '<tr>';

$LNG->PAGE_HELP_BODY .= '<td width="33%">';
$LNG->PAGE_HELP_BODY .= '<div id="resourcehomebutton" style="cursor:pointer;height:174px; padding:5px; font-weight:bold;" class="plainbackgradient plainborder curvedBorder homebutton1" onmouseover="this.className=\'resourcebackgradient resourceborder curvedBorder homebutton1\';" onmouseout="if ($(\'homebuttonmessagediv2\').style.display == \'none\' || $(\'homebuttonmessagelasttype2\').value != \'resource\') {this.className=\'plainbackgradient plainborder curvedBorder homebutton1\';}" title="Clicca qui per visualizzare/nascondere ulteriori informazioni" onclick="showHomeButtonText2(event, \'resource\');">';
$LNG->PAGE_HELP_BODY .= '<div style="margin: 0 auto; width:64px;margin-bottom:5px;">';
$LNG->PAGE_HELP_BODY .= '<img src="'.$HUB_FLM->getImagePath('nodetypes/Default/reference64px.png').'" border="0" />';
$LNG->PAGE_HELP_BODY .= '</div>';
$LNG->PAGE_HELP_BODY .= '<div style="padding:0px;"><center><h2>'.$LNG->RESOURCES_NAME.'</h2></center>';
$LNG->PAGE_HELP_BODY .= '<center>Clicca qui per saperne di più.</center>';
$LNG->PAGE_HELP_BODY .= '</div>';
$LNG->PAGE_HELP_BODY .= '</div>';
$LNG->PAGE_HELP_BODY .= '</td>';

$LNG->PAGE_HELP_BODY .= '<td width="33%">';
$LNG->PAGE_HELP_BODY .= '<div id="orghomebutton" style="cursor:pointer;height:174px; padding:5px; font-weight:bold;" class="plainbackgradient plainborder curvedBorder homebutton1" onmouseover="this.className=\'orgbackgradient orgborder curvedBorder homebutton2\';" onmouseout="if ($(\'homebuttonmessagediv2\').style.display == \'none\' || $(\'homebuttonmessagelasttype2\').value != \'org\') {this.className=\'plainbackgradient plainborder curvedBorder homebutton1\';}" title="Clicca qui per visualizzare/nascondere ulteriori informazioni" onclick="showHomeButtonText2(event, \'org\');">';
$LNG->PAGE_HELP_BODY .= '<div style="margin: 0 auto; width:64px;margin-bottom:5px;">';
$LNG->PAGE_HELP_BODY .= '<img src="'.$HUB_FLM->getImagePath('nodetypes/Default/country64px.png').'" border="0" />';
$LNG->PAGE_HELP_BODY .= '</div>';
$LNG->PAGE_HELP_BODY .= '<div style="padding:0px;"><center><h2>'.$LNG->ORGS_NAME.' and '.$LNG->PROJECTS_NAME.'</h2></center>';
$LNG->PAGE_HELP_BODY .= '<center>Clicca qui per saperne di più.</center>';
$LNG->PAGE_HELP_BODY .= '</div>';
$LNG->PAGE_HELP_BODY .= '</div>';
$LNG->PAGE_HELP_BODY .= '</td>';

if ($CFG->hasStories) {
	$LNG->PAGE_HELP_BODY .= '<td width="33%">';
	$LNG->PAGE_HELP_BODY .= '<div id="storyhomebutton" style="cursor:pointer;height:174px; padding:5px; font-weight:bold;" class="plainbackgradient plainborder curvedBorder homebutton1" onmouseover="this.className=\'themebackgradient themeborder curvedBorder homebutton1\';" onmouseout="if ($(\'homebuttonmessagediv2\').style.display == \'none\' || $(\'homebuttonmessagelasttype2\').value != \'story\') {this.className=\'plainbackgradient plainborder curvedBorder homebutton1\';}" title="Clicca qui per visualizzare/nascondere ulteriori informazioni" onclick="showHomeButtonText2(event, \'story\');">';
	$LNG->PAGE_HELP_BODY .= '<div style="margin: 0 auto; width:64px;margin-bottom:5px;">';
	$LNG->PAGE_HELP_BODY .= '<img src="'.$HUB_FLM->getImagePath('nodetypes/Default/story64px.png').'" width="64" height="64" border="0" />';
	$LNG->PAGE_HELP_BODY .= '</div>';
	$LNG->PAGE_HELP_BODY .= '<div style="padding:0px;"><center><h2>Stories</h2></center>';
	$LNG->PAGE_HELP_BODY .= '<center>Clicca qui per saperne di più</center>';
	$LNG->PAGE_HELP_BODY .= '</div>';
	$LNG->PAGE_HELP_BODY .= '</div>';
	$LNG->PAGE_HELP_BODY .= '</td>';
}

$LNG->PAGE_HELP_BODY .= '</tr>';
$LNG->PAGE_HELP_BODY .= '</table>';

$LNG->PAGE_HELP_BODY .= '<table style="margin: 0 auto;padding-right:15px;width:100%;">';
$LNG->PAGE_HELP_BODY .= '<tr>';
$LNG->PAGE_HELP_BODY .= '<td>';
$LNG->PAGE_HELP_BODY .= '<div id="homebuttonmessagediv2" class="plainborder curvedBorder" style="clear:both;float:left;width:99%;display:none;margin-left:10px;">';
$LNG->PAGE_HELP_BODY .= '<input type="hidden" id="homebuttonmessagelasttype2" value="" />';
$LNG->PAGE_HELP_BODY .= '<div style="clear:both;float:left;padding:10px;padding-top:0px;" id="homebuttonmessage2"></div>';
$LNG->PAGE_HELP_BODY .= '</div>';
$LNG->PAGE_HELP_BODY .= '</td>';
$LNG->PAGE_HELP_BODY .= '</tr>';
$LNG->PAGE_HELP_BODY .= '</table>';
$LNG->PAGE_HELP_BODY .= '</div>';

$LNG->PAGE_HELP_BODY .= '<h2>Come le categorie sono connesse <span style="padding-left:20px;font-weight:normal;font-size:9pt;color:dimgray">(rollover icons to view more information)</span></h2>';
$LNG->PAGE_HELP_BODY .= '<div style="clear:both;float:left;width:100%;padding:0px;margin-bottom:15px;margin-top:5px;" >
		<div style="float:left;">
		<fieldset class="curvedBorder" style="background:white;">';

if ($CFG->HAS_CHALLENGE ) {
	$LNG->PAGE_HELP_BODY .= '<div class="navnetworkicon">
			<span class="navnetworklink" onMouseOut="hideHints(); return false;" onMouseOver="showHomeNavText(event, \'ChallengesHome\'); return false;" onClick="hideHints();" onkeypress="enterKeyPressed(event)">
				<center>
				<img class="navnetworkimage" src="'.$CFG->challengeicon.'" width="20" height="20" border="0" />
				<br><span class="<?php if ($nodetype == \'Challenge\') { echo \'navnetworktextselected\'; } else { echo \'navnetworktext\'; }?>">'.$LNG->CHALLENGE_NAME.'</span>
				</center>
			</span>
		</div>
		<div class="navnetworkarrow">
			<img src="'.$HUB_FLM->getImagePath('arrow-orange-right.jpg').'" border="0" />
		</div>';
}

$LNG->PAGE_HELP_BODY .= '<div class="navnetworkicon">
			<span class="navnetworklink" onMouseOut="hideHints(); return false;" onMouseOver="showHomeNavText(event, \'IssuesHome\'); return false;" onClick="hideHints();" onkeypress="enterKeyPressed(event)">
				<center>
				<img class="navnetworkimage" src="'.$CFG->issueicon.'" width="20" height="20" border="0" />
				<br><span class="<?php if ($nodetype == \'Issue\') { echo \'navnetworktextselected\'; } else { echo \'navnetworktext\'; }?>">'.$LNG->ISSUE_NAME.'</span>
				</center>
			</span>
		</div>
		<div class="navnetworkarrow">
			<img src="'.$HUB_FLM->getImagePath('arrow-orange-right.jpg').'" border="0" />
		</div>';

if ($CFG->HAS_SOLUTION) {
	$LNG->PAGE_HELP_BODY .= '<div class="navnetworkicon">
			<span class="navnetworklink" onMouseOut="hideHints(); return false;" onMouseOver="showHomeNavText(event, \'SolutionsHome\'); return false;" onClick="hideHints();" onkeypress="enterKeyPressed(event)">
				<center>
				<img class="navnetworkimage" src="'.$CFG->solutionicon.'" width="20" height="20" border="0" />
				<br><span class="<?php if ($nodetype == \'Solution\') { echo \'navnetworktextselected\'; } else { echo \'navnetworktext\'; }?>">'.$LNG->SOLUTION_NAME.'</span>
				</center>
			</span>
		</div>';
}

if ($CFG->HAS_SOLUTION && $CFG->HAS_CLAIM) {
	$LNG->PAGE_HELP_BODY .= '<div class="navnetworkdivider">
			<span style="font-weight:bold;clear:both">/</span>
		</div>';
}

if ($CFG->HAS_CLAIM) {
	$LNG->PAGE_HELP_BODY .= '<div class="navnetworkicon">
			<span class="navnetworklink" onMouseOut="hideHints(); return false;" onMouseOver="showHomeNavText(event, \'ClaimsHome\'); return false;" onClick="hideHints();" onkeypress="enterKeyPressed(event)">
				<center>
				<img class="navnetworkimage" src="'.$CFG->claimicon.'" width="20" height="20" border="0" />
				<br><span class="<?php if ($nodetype == \'Claim\') { echo \'navnetworktextselected\'; } else { echo \'navnetworktext\'; }?>">'.$LNG->CLAIM_NAME.'</span>
				</center>
			</span>
		</div>';
}

$LNG->PAGE_HELP_BODY .= '<div class="navnetworkarrow">
			<img src="'.$HUB_FLM->getImagePath('arrow-orange-right.jpg').'" border="0" />
		</div>
		<div class="navnetworkicon">
			<span class="navnetworklink" onMouseOut="hideHints(); return false;" onMouseOver="showHomeNavText(event, \'EvidenceHome\'); return false;" onClick="hideHints();" onkeypress="enterKeyPressed(event)">
				<center>
				<img class="navnetworkimage" src="'.$CFG->evidenceicon.'" width="20" height="20" border="0" />
				<br><span class="<?php if ($nodetype == \'Evidence\') { echo \'navnetworktextselected\'; } else { echo \'navnetworktext\'; }?>">'.$LNG->EVIDENCE_NAME.'</span>
				</center>
			</span>
		</div>
		<div class="navnetworkarrow">
			<img src="'.$HUB_FLM->getImagePath('arrow-orange-right.jpg').'" border="0" />
		</div>
		<div class="navnetworkicon">
			<span class="navnetworklink" onMouseOut="hideHints(); return false;" onMouseOver="showHomeNavText(event, \'ResourcesHome\'); return false;" onClick="hideHints();" onkeypress="enterKeyPressed(event)">
				<center>
				<img class="navnetworkimage" src="'.$CFG->resourceicon.'" width="20" height="20" border="0" />
				<br><span class="<?php if ($nodetype == \'Resource\') { echo \'navnetworktextselected\'; } else { echo \'navnetworktext\'; }?>">'.$LNG->RESOURCE_NAME.'</span>
				</center>
			</span>
		</div>
		</fieldset>
		</div>

		<div style="float:left;margin-top:27px;">
			<img src="'.$HUB_FLM->getImagePath('arrow-orange-right-selected.png').'" border="0" />
		</div>

		<div style="float:left;">
 		<fieldset class="curvedBorder" style="background:white;">
		<div style="float:left;padding:0px;margin-bottom:0px;background:white;" class="curvedBorder">
			<div class="navnetworkicon">
				<span class="navnetworklink" onMouseOut="hideHints(); return false;" onMouseOver="showHomeNavText(event, \'OrganisationsHome\'); return false;" onClick="hideHints();" onkeypress="enterKeyPressed(event)">
					<center>
					<img class="navnetworkimage" src="'.$CFG->orgicon.'" width="20" height="20" border="0" />
					<br><span class="<?php if ($nodetype == \'Organisation\') { echo \'navnetworktextselected\'; } else { echo \'navnetworktext\'; }?>">'.$LNG->ORG_NAME.'</span>
					</center>
				</span>
			</div>
			<div class="navnetworkarrow">
				<img src="'.$HUB_FLM->getImagePath('arrow-orange-right.jpg').'" border="0" />
			</div>
			<div class="navnetworkicon">
				<span class="navnetworklink" onMouseOut="hideHints(); return false;" onMouseOver="showHomeNavText(event, \'ProjectsHome\'); return false;" onClick="hideHints();" onkeypress="enterKeyPressed(event)">
					<center>
					<img class="navnetworkimage" src="'.$CFG->projecticon.'" width="20" height="20" border="0" />
					<br><span class="<?php if ($nodetype == \'Project\') { echo \'navnetworktextselected\'; } else { echo \'navnetworktext\'; }?>">'.$LNG->PROJECT_NAME.'</span>
					</center>
				</span>
			</div>
		</div>
		</fieldset>
		</div>
	</div>';

$LNG->PAGE_HELP_BODY .= '<h2>Esplora i '.$LNG->THEMES_NAME.': gli SDGs e la School of Sustainability</h2>';

$LNG->PAGE_HELP_BODY .= '<p>
L\'Evidence Hub dispone di un sistema di raggruppamento che consente agli utenti di raggruppare le informazioni attorno ad un '.$LNG->THEME_NAME.'.
</p>';
$LNG->PAGE_HELP_BODY .= '<p>
I '.$LNG->THEMES_NAME.' sono mostrati nella homepage come un elenco di riquadri colorati. Se clicchi su un tema vedrai tutte le informazioni attorno ad un(';
if ($CFG->HAS_CHALLENGE) {
	$LNG->PAGE_HELP_BODY .= $LNG->CHALLENGES_NAME.', ';
}

$LNG->PAGE_HELP_BODY .= $LNG->ISSUES_NAME.', ';
if ($CFG->HAS_SOLUTION) {
	$LNG->PAGE_HELP_BODY .= $LNG->SOLUTIONS_NAME.', ';
}
if ($CFG->HAS_CLAIM) {
	$LNG->PAGE_HELP_BODY .= $LNG->CLAIMS_NAME.', ';
}
$LNG->PAGE_HELP_BODY .=  $LNG->RESOURCES_NAME.', '.$LNG->PROJECTS_NAME.', '.$LNG->ORGS_NAME.' ecc.) relative a quel tema.</p>';

$LNG->PAGE_HELP_BODY .= '<p>
La lista di '.$LNG->THEMES_NAME.' è decisa dall\'amministratore dell\'Evidence Hub.
</p>';
$LNG->PAGE_HELP_BODY .= '<p>
I '.$LNG->THEMES_NAME.' mirano a rappresentare gli argomenti di livello superiore di interesse per la
comunità, mentre per la categorizzazione di livello inferiore gli utenti possono aggiungere tag,
che vengono visualizzati anche nella homepage di Evidence Hub come tag cloud.
</p>';

$LNG->PAGE_HELP_BODY .= '<h2>Segui quello che ti interessa</h2>';

$LNG->PAGE_HELP_BODY .= '<p>Interessato a qualcosa di specifico? Puoi seguire qualsiasi persona, '.$LNG->ORG_NAME_SHORT.', '.$LNG->PROJECT_NAME_SHORT.', '.$LNG->THEME_NAME.', ';
if ($CFG->HAS_CHALLENGE) {
	$LNG->PAGE_HELP_BODY .= $LNG->CHALLENGE_NAME.', ';
}

$LNG->PAGE_HELP_BODY .= $LNG->ISSUE_NAME.', ';
if ($CFG->HAS_SOLUTION) {
	$LNG->PAGE_HELP_BODY .= $LNG->SOLUTION_NAME.', ';
}
if ($CFG->HAS_CLAIM) {
	$LNG->PAGE_HELP_BODY .= $LNG->CLAIM_NAME.', ';
}
$LNG->PAGE_HELP_BODY .=  $LNG->EVIDENCE_NAME.' nell\'Evidence Hub</p>';

$LNG->PAGE_HELP_BODY .= '<p>Puoi seguire qualsiasi nodo nell\'hub facendo clic sull\'icona Segui <img border="0" src="'.$HUB_FLM->getImagePath('follow.png').'"/></p>';
$LNG->PAGE_HELP_BODY .= '<p>Quando inizi a seguire un nodo, le attività relative a quel nodo verranno elencate nella tua home page.</p>';
$LNG->PAGE_HELP_BODY .= '<p>Puoi anche scegliere di ricevere un riepilogo e-mail giornaliero/settimanale/mensile di tutte le attività relative agli elementi e alle persone che segui.</p>';
$LNG->PAGE_HELP_BODY .= '<p>Seguendo un elemento nell\'hub delle prove verrai aggiunto anche all\'elenco dei follower mostrato nella pagina di esplorazione di quell\'elemento.</p>';

$LNG->PAGE_HELP_BODY .= '<p>Se desideri segnalare un bug o  hai suggerimenti per migliorare all\'Evidence Hub, o altre domande sul sito, per favore <a href="mailto:'.$CFG->EMAIL_REPLY_TO.'">contattaci</a>.</p>';
?>
