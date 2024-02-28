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
$LNG->CHALLENGE_NAME = "Key Challenge";
$LNG->CHALLENGE_NAME_SHORT = "Challenge";
$LNG->ISSUE_NAME = "Issue";
$LNG->ISSUE_NAME_SHORT = "Issue";
$LNG->ISSUESUB_NAME = 'Sub Issue';
$LNG->SOLUTION_NAME = "Potential Solution";
$LNG->SOLUTION_NAME_SHORT = "Solution";
$LNG->CLAIM_NAME = "Research Claim";
$LNG->CLAIM_NAME_SHORT = "Claim";
$LNG->EVIDENCE_NAME = "Evidence";
$LNG->EVIDENCE_NAME_SHORT = "Evidence";
$LNG->RESOURCE_NAME = "Resource";
$LNG->RESOURCE_NAME_SHORT = "Resource";
$LNG->USER_NAME = "User";
$LNG->ORG_NAME = "Organization";
$LNG->ORG_NAME_SHORT = "Organization";
$LNG->PROJECT_NAME = "Project";
$LNG->PROJECT_NAME_SHORT = "Project";
$LNG->THEME_NAME = "Theme";
$LNG->COMMENT_NAME = "Open Comment";
$LNG->COMMENT_NAME_SHORT = "Comment";
$LNG->FOLLOWER_NAME = "Follower";
$LNG->CHAT_NAME = "Chat";
$LNG->NEWS_NAME = "News article";
$LNG->PRO_NAME = "Supporting Evidence";
$LNG->CON_NAME = "Counter Evidence";

// must be in the same order as CFG->EVIDENCE_TYPES
$LNG->EVIDENCE_TYPES = array("Anecdote","Case Study","Policy","Report","Research Finding");
$LNG->EVIDENCE_TYPES_SHORT = array("Anecdote","Case Study","Policy","Report","Research Finding");

// must be in the same order as CFG->RESOURCE_TYPES
$LNG->RESOURCE_TYPES = array("Publication","Web Resource");
$LNG->RESOURCE_TYPES_SHORT = array("Publication","Web Resource");


/** Plural **/
$LNG->CHALLENGES_NAME = "Key Challenges";
$LNG->CHALLENGES_NAME_SHORT = "Challenges";
$LNG->ISSUES_NAME = "Issues";
$LNG->ISSUES_NAME_SHORT = "Issues";
$LNG->ISSUESSUB_NAME = 'Sub Issues';
$LNG->SOLUTIONS_NAME = "Potential Solutions";
$LNG->SOLUTIONS_NAME_SHORT = "Solutions";
$LNG->CLAIMS_NAME = "Research Claims";
$LNG->CLAIMS_NAME_SHORT = "Claims";
$LNG->EVIDENCES_NAME = "Evidence";
$LNG->EVIDENCES_NAME_SHORT = "Evidence";
$LNG->RESOURCES_NAME = "Resources";
$LNG->RESOURCES_NAME_SHORT = "Resources";
$LNG->USERS_NAME = "Users";
$LNG->ORGS_NAME = "Organizations";
$LNG->ORGS_NAME_SHORT = "Organizations";
$LNG->PROJECTS_NAME = "Projects";
$LNG->PROJECTS_NAME_SHORT = "Projects";
$LNG->THEMES_NAME = "Themes";
$LNG->COMMENTS_NAME = "Open Comments";
$LNG->COMMENTS_NAME_SHORT = "Comments";
$LNG->FOLLOWERS_NAME = "Followers";
$LNG->CHATS_NAME = "Chats";
$LNG->NEWSS_NAME = "News";
$LNG->PROS_NAME = "Supporting Evidence";
$LNG->CONS_NAME = "Counter Evidence";

/** Link Type Name **/
$LNG->LINK_SOLUTION_ISSUE = 'addresses';
$LNG->LINK_CLAIM_ISSUE = 'responds to';
$LNG->LINK_ISSUE_CHALLENGE = 'is related to';
$LNG->LINK_EVIDENCE_SOLCLAIM_PRO = 'supports';
$LNG->LINK_EVIDENCE_SOLCLAIM_CON = 'challenges';
$LNG->LINK_ORGP_ISSUE = 'addresses';
$LNG->LINK_ORGP_CHALLENGE = 'addresses';
$LNG->LINK_ORGP_CLAIM = 'claims';
$LNG->LINK_ORGP_SOLUTION = 'specifies';
$LNG->LINK_ORGP_EVIDENCE = 'specifies';
$LNG->LINK_ORGP_ORGP = 'partnered with';
$LNG->LINK_ORG_PROJECT = 'manages';
$LNG->LINK_COMMENT_NODE = 'is related to';
$LNG->LINK_NODE_THEME = 'has main theme';
$LNG->LINK_RESOURCE_NODE = 'is related to';
$LNG->LINK_NODE_SEE_ALSO = 'see also';
$LNG->LINK_COMMENT_BUILT_FROM = 'built from';


/** FROM DEBATEHUB **/
$LNG->ARGUMENT_NAME = "Argument";
$LNG->DEBATE_NAME = "Debate";
$LNG->DEBATES_NAME = "Debates";

$LNG->LINK_PRO_SOLUTION = 'supports';
$LNG->LINK_CON_SOLUTION = 'challenges';
$LNG->LINK_BUILT_FROM = 'built from';
?>