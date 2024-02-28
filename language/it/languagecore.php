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

/**
 * languagecore.php
 *
 * Michelle Bachler (KMi)
 *
 * This file holds the default text for the main datamodel node types and link types for the Evidence Hub.
 */

/** Singular **/
$LNG->CHALLENGE_NAME = "Sfida chiave";
$LNG->CHALLENGE_NAME_SHORT = "Sfida";
$LNG->ISSUE_NAME = "Problema";
$LNG->ISSUE_NAME_SHORT = "Problema";
$LNG->ISSUESUB_NAME = 'Problema secondario';
$LNG->SOLUTION_NAME = "Soluzione";
$LNG->SOLUTION_NAME_SHORT = "Soluzione";
$LNG->CLAIM_NAME = "Affermazione";
$LNG->CLAIM_NAME_SHORT = "AffermazionResource";
$LNG->EVIDENCE_NAME = "Argomentazione";
$LNG->EVIDENCE_NAME_SHORT = "Argomentazione";
$LNG->RESOURCE_NAME = "Risorsa";
$LNG->RESOURCE_NAME_SHORT = "Risorsa";
$LNG->USER_NAME = "Utente";
$LNG->ORG_NAME = "Organizzazione";
$LNG->ORG_NAME_SHORT = "Organizzazione";
$LNG->PROJECT_NAME = "Progetto";
$LNG->PROJECT_NAME_SHORT = "Progetto";
$LNG->THEME_NAME = "Tema";
$LNG->COMMENT_NAME = "Commento";
$LNG->COMMENT_NAME_SHORT = "Commento";
$LNG->FOLLOWER_NAME = "Follower";
$LNG->CHAT_NAME = "Chat";
$LNG->NEWS_NAME = "Notizia";
$LNG->PRO_NAME = "Pro";
$LNG->CON_NAME = "Contro";

// must be in the same order as CFG->EVIDENCE_TYPES
$LNG->EVIDENCE_TYPES = array("Aneddoto","Argomento di studio","Politica","Rapporto","Risultati della ricerca");
$LNG->EVIDENCE_TYPES_SHORT = array("Aneddoto","Argomento di studio","Politica","Rapporto","Risultati della ricerca");

// must be in the same order as CFG->RESOURCE_TYPES
$LNG->RESOURCE_TYPES = array("Pubblicazione","Risorsa Web");
$LNG->RESOURCE_TYPES_SHORT = array("Pubblicazione","Risorsa Web");


/** Plural **/
$LNG->CHALLENGES_NAME = "Sfide chiave";
$LNG->CHALLENGES_NAME_SHORT = "Sfide";
$LNG->ISSUES_NAME = "Problemi";
$LNG->ISSUES_NAME_SHORT = "Problemi";
$LNG->ISSUESSUB_NAME = 'Problemi secondari';
$LNG->SOLUTIONS_NAME = "Soluzioni";
$LNG->SOLUTIONS_NAME_SHORT = "Soluzioni";
$LNG->CLAIMS_NAME = "Affermazioni";
$LNG->CLAIMS_NAME_SHORT = "Affermazioni";
$LNG->EVIDENCES_NAME = "Argomentazioni";
$LNG->EVIDENCES_NAME_SHORT = "Argomentazioni";
$LNG->RESOURCES_NAME = "Risorse";
$LNG->RESOURCES_NAME_SHORT = "Risorse";
$LNG->USERS_NAME = "Utenti";
$LNG->ORGS_NAME = "Organizzazioni";
$LNG->ORGS_NAME_SHORT = "Organizzazioni";
$LNG->PROJECTS_NAME = "Progetti";
$LNG->PROJECTS_NAME_SHORT = "Progetti";
$LNG->THEMES_NAME = "Temi";
$LNG->COMMENTS_NAME = "Commenti";
$LNG->COMMENTS_NAME_SHORT = "Commenti";
$LNG->FOLLOWERS_NAME = "Followers";
$LNG->CHATS_NAME = "Chat";
$LNG->NEWSS_NAME = "Notizia";
$LNG->PROS_NAME = "Pro";
$LNG->CONS_NAME = "Contro";

/** Link Type Name **/
$LNG->LINK_SOLUTION_ISSUE = 'si rivolge a';
$LNG->LINK_CLAIM_ISSUE = 'risponde a';
$LNG->LINK_ISSUE_CHALLENGE = 'Ã¨ collegato a';
$LNG->LINK_EVIDENCE_SOLCLAIM_PRO = 'supporta';
$LNG->LINK_EVIDENCE_SOLCLAIM_CON = 'sfida';
$LNG->LINK_ORGP_ISSUE = 'si rivolge a';
$LNG->LINK_ORGP_CHALLENGE = 'si rivolge a';
$LNG->LINK_ORGP_CLAIM = 'richiede';
$LNG->LINK_ORGP_SOLUTION = 'specifica';
$LNG->LINK_ORGP_EVIDENCE = 'specifica';
$LNG->LINK_ORGP_ORGP = 'collabora con';
$LNG->LINK_ORG_PROJECT = 'gestisce';
$LNG->LINK_COMMENT_NODE = 'si collega a';
$LNG->LINK_NODE_THEME = 'ha un tema principale';
$LNG->LINK_RESOURCE_NODE = 'si collega a';
$LNG->LINK_NODE_SEE_ALSO = 'vede anche';
$LNG->LINK_COMMENT_BUILT_FROM = 'viene da';


/** FROM DEBATEHUB **/
$LNG->ARGUMENT_NAME = "Argomento";
$LNG->DEBATE_NAME = "Dibattito";
$LNG->DEBATES_NAME = "Dibattiti";

$LNG->LINK_PRO_SOLUTION = 'supporta';
$LNG->LINK_CON_SOLUTION = 'sfida';
$LNG->LINK_BUILT_FROM = 'viene da';
?>
