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
/**
 * sql-audit.php
 *
 * Michelle Bachler (KMi)
 *
 */

$HUB_SQL->AUDIT_NODE_INSERT = "INSERT into AuditNode (UserID, NodeID, Name, Description, ModificationDate, ChangeType, NodeXML)
								values (?, ?, ?, ?, ?, ?, ?)";
$HUB_SQL->AUDIT_URL_INSERT = "INSERT into AuditURL (UserID, URLID, URL, Title, Description, Clip, ClipPath, ClipHTML, ModificationDate, ChangeType, URLXML)
								values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$HUB_SQL->AUDIT_TRIPLE_INSERT = "INSERT into AuditTriple (TripleID, UserID, LinkTypeID, FromID, ToID, Label, FromContextTypeID, ToContextTypeID, ModificationDate, ChangeType, TripleXML)
								values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$HUB_SQL->AUDIT_SEARCH_INSERT = "INSERT into AuditSearch (SearchID, UserID, SearchText, ModificationDate, TagsOnly, Type, TypeItemID)
            					values (?, ?, ?, ?, ?, ?, ?)";
$HUB_SQL->AUDIT_SEARCH_RESULT_INSERT = "INSERT into AuditSearchResult (SearchID, UserID, ItemID, ModificationDate, IsUser)
            					values (?, ?, ?, ?, ?)";
$HUB_SQL->AUDIT_SPAM_REPORTS_INSERT = "INSERT into AuditSpamReports (ReporterID, ItemID, CreationDate, Type)
            					values (?, ?, ?, ?)";
$HUB_SQL->AUDIT_VOTE_INSERT = "INSERT into AuditVoting (UserID, ItemID, VoteType, ModificationDate, ChangeType)
            					values (?, ?, ?, ?, ?)";

$HUB_SQL->AUDIT_SPAM_REPORTS_SELECT = "Select ReporterID from AuditSpamReports where ItemId=? order by CreationDate DESC";

$HUB_SQL->AUDIT_NODE_VIEW_INSERT ="INSERT into AuditNodeView (UserID, NodeID, ModificationDate, ViewType)
            					values (?, ?, ?, ?)";
?>