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

$LNG->PAGE_ABOUT_TITLE = "About the ".$CFG->SITE_TITLE;

$LNG->PAGE_ABOUT_BODY = '<h2>EXPLORE + SHARE</h2>';

$LNG->PAGE_ABOUT_BODY .= '<p style="width: 430px;font-weight:bold;">';
$LNG->PAGE_ABOUT_BODY .= '<span style="font-size:10pt;">your experiences in this community - as a learner, educator, researcher or policymaker</span>';
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
	$LNG->PAGE_ABOUT_BODY .= '<span style="font-size:10pt;">Research Debate - '.$LNG->CLAIMS_NAME.' you think that Research in this community\'s field allows us to make</span>';
}
$LNG->PAGE_ABOUT_BODY .= '<img src="'.$HUB_FLM->getImagePath('grey-dot.png').'" border="0" />';
$LNG->PAGE_ABOUT_BODY .= '<span style="font-size:10pt;color:#4e247b">Supporting (and challenging) '.$LNG->EVIDENCES_NAME.'</span>';
$LNG->PAGE_ABOUT_BODY .= '<img src="'.$HUB_FLM->getImagePath('grey-dot.png').'" border="0" />';
$LNG->PAGE_ABOUT_BODY .= '<span style="font-size:10pt;">'.$LNG->PROJECTS_NAME.' and '.$LNG->ORGS_NAME.'</span>';
$LNG->PAGE_ABOUT_BODY .= '<img src="'.$HUB_FLM->getImagePath('grey-dot.png').'" border="0" />';
$LNG->PAGE_ABOUT_BODY .= '<span style="font-size:10pt;color:#4e247b">Relevant '.$LNG->RESOURCES_NAME.'</span>';
$LNG->PAGE_ABOUT_BODY .= '</p>';

$LNG->PAGE_ABOUT_BODY .= '<h2>JOIN US</h2>';
$LNG->PAGE_ABOUT_BODY .= '<p>The '.$CFG->SITE_TITLE.' aims to provide an environment to systematically interrogate this community on what are the people, projects, organizations, challenges, solutions and claims that scaffold it. Ultimately this website will build an evidence hub which represents and maps the collective knowledge around this community.</p>';

$LNG->PAGE_ABOUT_BODY .= '<h2>WHO</h2>';
$LNG->PAGE_ABOUT_BODY .= '<p>The Evidence Hub is developed by the ';
$LNG->PAGE_ABOUT_BODY .= '<a href="http://projects.kmi.open.ac.uk/hyperdiscourse/">Knowledge Media Institute</a> ';
$LNG->PAGE_ABOUT_BODY .= 'team (<a target="About" href="http://kmi.open.ac.uk/people/sbs">Simon Buckingham Shum</a>, ';
$LNG->PAGE_ABOUT_BODY .= '<a target="About" href="http://people.kmi.open.ac.uk/anna/index.html">Anna De Liddo</a> and ';
$LNG->PAGE_ABOUT_BODY .= '<a target="About" href="http://kmi.open.ac.uk/people/bachler">Michelle Bachler</a>) ';
$LNG->PAGE_ABOUT_BODY .= 'and is part of a family of <a href="http://evidence-hub.net/">Evidence Hubs</a>.';
$LNG->PAGE_ABOUT_BODY .= '<br />We are indebted to <a target="About" href="http://kmi.open.ac.uk/people/harry/">Harriett Cornish</a> for graphic design.</p> ';

// This needs to be site specific
//$LNG->PAGE_ABOUT_BODY .= '<h2>WHY</h2>';
//$LNG->PAGE_ABOUT_BODY .= '<p></p>';

$LNG->PAGE_ABOUT_BODY .= '<h2>WHAT</h2>';

$LNG->PAGE_ABOUT_BODY .= '<p>The Evidence Hub aims to provide researchers and practitioner in this community with a dynamic and living map of where the community is heading.';
$LNG->PAGE_ABOUT_BODY .= '<br>We aim at building a social Web environment which works as a <b>Collective Evidence Hub</b> for this community.';
$LNG->PAGE_ABOUT_BODY .= '</p>';

$LNG->PAGE_ABOUT_BODY .= '<p>To do so <a href="'.$CFG->homeAddress.'">'.$CFG->homeAddress.'</a> provides scholars, researchers and practitioners with an environment where:';
$LNG->PAGE_ABOUT_BODY .= '<ul>';
$LNG->PAGE_ABOUT_BODY .= '<li>new <b>projects</b> and <b>organizations</b> can be added to the network, </li>';
$LNG->PAGE_ABOUT_BODY .= '<li>new <b>issues</b> and questions can be posted, explored and discussed, </li>';
$LNG->PAGE_ABOUT_BODY .= '<li>new <b>solutions</b> can be proposed to tackle the major challenges facing this community,</li>';
$LNG->PAGE_ABOUT_BODY .= '<li>relevant <b>evidence</b> and <b>Web resources</b> for this community can be shared to contribute to the evidence base,</li>';
$LNG->PAGE_ABOUT_BODY .= '<li>new <b>claims</b> can be made and investigated, that are informed by the community debate and backed by robust <b>evidence</b> in favour and against such claims.</li>';
$LNG->PAGE_ABOUT_BODY .= '</ul>';
$LNG->PAGE_ABOUT_BODY .= '</p>';

$LNG->PAGE_ABOUT_BODY .= '<h2>HOW</h2>';
$LNG->PAGE_ABOUT_BODY .= '<p>The Evidence Hub builds on research on Collective Intelligence, ';
$LNG->PAGE_ABOUT_BODY .= 'Sensemaking, Knowledge Mapping and Social Web technologies and provides ';
$LNG->PAGE_ABOUT_BODY .= 'an environment in which, by filling simple web forms, users can add their ';
$LNG->PAGE_ABOUT_BODY .= 'knowledge, ideas, interpretations, and see them instantly mapped within the ';
$LNG->PAGE_ABOUT_BODY .= 'global community network map.</p>';

$LNG->PAGE_ABOUT_BODY .= '<p>By aggregating and mining single contributions the Evidence Hub provides ';
$LNG->PAGE_ABOUT_BODY .= 'a collective picture of this community. This picture can be ';
$LNG->PAGE_ABOUT_BODY .= 'explored in form of a simple textual interface (as list of organizations, ';
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
$LNG->PAGE_ABOUT_BODY .= $LNG->EVIDENCES_NAME.', '.$LNG->RESOURCES_NAME.', ) or in a more visual way as network map.</p>';

$LNG->PAGE_ABOUT_BODY .= '<p>The platform allows different users to build progressively and collaboratively on the same ';
$LNG->PAGE_ABOUT_BODY .= 'content, thus facilitating collaborative knowledge production and discovery.</p>';

$LNG->PAGE_ABOUT_BODY .= '<p>Moreover the system provides users with contextual recommendation based on matching themes. ';
$LNG->PAGE_ABOUT_BODY .= 'This means, for example, that if you have made a claim, shared some evidence or a piece of data ';
$LNG->PAGE_ABOUT_BODY .= 'on copyright issues other relevant data on copyright will be suggested to you for exploration.</p>';

$LNG->PAGE_ABOUT_BODY .= '<p>The system also allows  you to easily add evidence or present counter-evidence to other people\'s ';
$LNG->PAGE_ABOUT_BODY .= 'claims, thus triggering conversations and knowledge sharing between people who tackle similar issues.</p>';

$LNG->PAGE_ABOUT_BODY .= '<p>Finally the Evidence Hub allows users to visualize, explore and be part of the social network of ';
$LNG->PAGE_ABOUT_BODY .= 'contributors to the Collective Intelligence Hub for this community.</p>';

$LNG->PAGE_ABOUT_BODY .= '<p>The Evidence Hub is part of the Cohere family of softwares which are social web tools for knowledge mapping and ';
$LNG->PAGE_ABOUT_BODY .= 'collaborative annotation developed by the KMi hypermedia discourse team. ';

$LNG->PAGE_ABOUT_BODY .= '<ul>';
$LNG->PAGE_ABOUT_BODY .= '<li>collect evidences by annotating free web resources, thus using clips of text to ground their claims.</li>';
$LNG->PAGE_ABOUT_BODY .= '<li>Exploit advanced network visualization, search and filtering to interrogate and explore the network maps of ';
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
$LNG->PAGE_ABOUT_BODY .= '<li>Develop a personal portfolio of these items.</li>';
$LNG->PAGE_ABOUT_BODY .= '</ul>';
$LNG->PAGE_ABOUT_BODY .= 'This advanced functionality will be slowly added to the Evidence Hub in the future.';
$LNG->PAGE_ABOUT_BODY .= '</p>';
?>