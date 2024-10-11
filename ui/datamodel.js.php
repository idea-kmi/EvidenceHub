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
 * DESCRIBES THE DATAMODEL OF CONNECTIONS.
 * For the evidence hub client side code to use.
 * The model is described in both directions where the interface requires it.
 **/

   global $CFG, $LNG;
?>

<script>
var HUB_DATAMODEL = new Object();
var hint = "";

/** FOR COMPLETENESS **/
//HUB_DATAMODEL.commentToNode = new HubConnection("Comment","Challenge,Issue,Solution,Claim,Project,Organization,Theme"+EVIDENCE_TYPES_STR+","+RESOURCE_TYPES_STR, '<?php echo $CFG->LINK_COMMENT_NODE; ?>', 'from', hint, '');
//HUB_DATAMODEL.commentToComment = new HubConnection("Comment","Comment", '<?php echo $CFG->LINK_COMMENT_NODE; ?>', 'from', hint, '');
//HUB_DATAMODEL.nodeToComment = new HubConnection("Claim,Challenge,Solution,Issue,"+EVIDENCE_TYPES_STR,"Comment,Idea", '<?php echo $CFG->LINK_COMMENT_BUILT_FROM; ?>', 'from', hint, '');

// NOTE: You can also create a See Also connection to a Comment - but only through a specific mechanism.
// So it is included in the Core datamodel but not here.
hint = "<?php echo $LNG->EXPLORE_SEE_ALSO; ?>";
HUB_DATAMODEL.nodeToSeeAlso = new HubConnection("Challenge,Issue,Solution,Claim,Project,Organization"+EVIDENCE_TYPES_STR+","+RESOURCE_TYPES_STR, "Challenge,Issue,Solution,Claim,Project,Organization"+EVIDENCE_TYPES_STR+","+RESOURCE_TYPES_STR, '<?php echo $CFG->LINK_NODE_SEE_ALSO; ?>', 'from', hint, '');

HUB_DATAMODEL.pro = new HubConnection('', EVIDENCE_TYPES_STR, '<?php echo $CFG->LINK_EVIDENCE_SOLCLAIM_PRO; ?>', 'to', '', '<?php echo $CFG->proicon; ?>');
HUB_DATAMODEL.con = new HubConnection('', EVIDENCE_TYPES_STR, '<?php echo $CFG->LINK_EVIDENCE_SOLCLAIM_CON; ?>', 'to', '', '<?php echo $CFG->conicon; ?>');
HUB_DATAMODEL.nodeToTheme = new HubConnection('All', 'Theme', '<?php echo $CFG->LINK_NODE_THEME; ?>', 'to');

/** EVIDENCE AS FOCAL NODE **/
//this shows the underlying type, but the connection role type is either 'Pro' or 'Con'

hint = "<?php echo $LNG->DATAMODEL_evidenceToResource; ?>";
HUB_DATAMODEL.evidenceToResource = new HubConnection(RESOURCE_TYPES_STR, EVIDENCE_TYPES_STR, '<?php echo $CFG->LINK_RESOURCE_NODE; ?>', 'to', hint, '<?php echo $CFG->resourceicon; ?>');

hint = "<?php echo $LNG->DATAMODEL_evidenceToSolution; ?>";
HUB_DATAMODEL.evidenceToSolution = new HubConnection(EVIDENCE_TYPES_STR, 'Solution', '<?php echo $CFG->LINK_EVIDENCE_SOLCLAIM_CON; ?>,<?php echo $CFG->LINK_EVIDENCE_SOLCLAIM_PRO; ?>', 'from', hint, '<?php echo $CFG->solutionicon; ?>');

hint = "<?php echo $LNG->DATAMODEL_evidenceToClaim; ?>";
HUB_DATAMODEL.evidenceToClaim = new HubConnection(EVIDENCE_TYPES_STR, 'Claim', '<?php echo $CFG->LINK_EVIDENCE_SOLCLAIM_CON; ?>,<?php echo $CFG->LINK_EVIDENCE_SOLCLAIM_PRO; ?>', 'from', hint, '<?php echo $CFG->claimicon; ?>');

hint = "<?php echo $LNG->DATAMODEL_evidenceToOrg; ?>";
HUB_DATAMODEL.evidenceToOrg = new HubConnection('Organization', EVIDENCE_TYPES_STR, '<?php echo $CFG->LINK_ORGP_EVIDENCE; ?>', 'to', hint, '<?php echo $CFG->orgicon; ?>');

hint = "<?php echo $LNG->DATAMODEL_evidenceToProject; ?>";
HUB_DATAMODEL.evidenceToProject = new HubConnection('Project', EVIDENCE_TYPES_STR, '<?php echo $CFG->LINK_ORGP_EVIDENCE; ?>', 'to', hint, '<?php echo $CFG->projecticon; ?>');


/** RESOURCE AS FOCAL NODE **/
hint = "<?php echo $LNG->DATAMODEL_resourceToOrg; ?>";
HUB_DATAMODEL.resourceToOrg = new HubConnection(RESOURCE_TYPES_STR, 'Organization', '<?php echo $CFG->LINK_RESOURCE_NODE; ?>', 'from', hint, '<?php echo $CFG->orgicon; ?>');

hint = "<?php echo $LNG->DATAMODEL_resourceToProject; ?>";
HUB_DATAMODEL.resourceToProject = new HubConnection(RESOURCE_TYPES_STR, 'Project', '<?php echo $CFG->LINK_RESOURCE_NODE; ?>', 'from', hint, '<?php echo $CFG->projecticon; ?>');

hint = "<?php echo $LNG->DATAMODEL_resourceToEvidence; ?>";
HUB_DATAMODEL.resourceToEvidence = new HubConnection(RESOURCE_TYPES_STR, EVIDENCE_TYPES_STR, '<?php echo $CFG->LINK_RESOURCE_NODE; ?>', 'from', hint, '<?php echo $CFG->evidenceicon; ?>');


/** ORGANIZATION AS FOCAL NODE **/
hint = "<?php echo $LNG->DATAMODEL_orgToIssue; ?>";
HUB_DATAMODEL.orgToIssue = new HubConnection('Organization,Project', 'Issue', '<?php echo $CFG->LINK_ORGP_ISSUE; ?>', 'from', hint, '<?php echo $CFG->issueicon; ?>');

hint = "<?php echo $LNG->DATAMODEL_orgToClaim; ?>";
HUB_DATAMODEL.orgToClaim = new HubConnection('Organization,Project', 'Claim', '<?php echo $CFG->LINK_ORGP_CLAIM; ?>', 'from', hint, '<?php echo $CFG->claimicon; ?>');

hint = "<?php echo $LNG->DATAMODEL_orgToSolution; ?>";
HUB_DATAMODEL.orgToSolution = new HubConnection('Organization', 'Solution', '<?php echo $CFG->LINK_ORGP_SOLUTION; ?>', 'from', hint, '<?php echo $CFG->solutionicon; ?>');

hint = "<?php echo $LNG->DATAMODEL_orgToChallenge; ?>";
HUB_DATAMODEL.orgToChallenge = new HubConnection('Organization', 'Challenge', '<?php echo $CFG->LINK_ORGP_CHALLENGE; ?>', 'from', hint, '<?php echo $CFG->challengeicon; ?>');

hint = "<?php echo $LNG->DATAMODEL_orgToProject; ?>";
HUB_DATAMODEL.orgToProject = new HubConnection('Organization', 'Project', '<?php echo $CFG->LINK_ORG_PROJECT; ?>', 'from', hint, '<?php echo $CFG->projecticon; ?>');

hint = "<?php echo $LNG->DATAMODEL_orgToResource; ?>";
HUB_DATAMODEL.orgToResource = new HubConnection(RESOURCE_TYPES_STR, 'Organization', '<?php echo $CFG->LINK_RESOURCE_NODE; ?>', 'to', hint, '<?php echo $CFG->resourceicon; ?>');

hint = "<?php echo $LNG->DATAMODEL_orgToEvidence; ?>";
HUB_DATAMODEL.orgToEvidence = new HubConnection('Organization', EVIDENCE_TYPES_STR, '<?php echo $CFG->LINK_ORGP_EVIDENCE; ?>', 'from', hint, '<?php echo $CFG->evidenceicon; ?>');

hint = "<?php echo $LNG->DATAMODEL_orgToOrg; ?>";
HUB_DATAMODEL.orgToOrg = new HubConnection('Organization', 'Organization,Project', '<?php echo $CFG->LINK_ORGP_ORGP; ?>', 'from', hint, '<?php echo $CFG->orgicon; ?>');


/** PROJECT AS FOCAL NODE **/
hint = "<?php echo $LNG->DATAMODEL_projectToIssue; ?>";
HUB_DATAMODEL.projectToIssue = new HubConnection('Project', 'Issue', '<?php echo $CFG->LINK_ORGP_ISSUE; ?>', 'from', hint, '<?php echo $CFG->issueicon; ?>');

hint = "<?php echo $LNG->DATAMODEL_projectToClaim; ?>";
HUB_DATAMODEL.projectToClaim = new HubConnection('Project', 'Claim', '<?php echo $CFG->LINK_ORGP_CLAIM; ?>', 'from', hint, '<?php echo $CFG->claimicon; ?>');

hint = "<?php echo $LNG->DATAMODEL_projectToSolution; ?>";
HUB_DATAMODEL.projectToSolution = new HubConnection('OrProject', 'Solution', '<?php echo $CFG->LINK_ORGP_SOLUTION; ?>', 'from', hint, '<?php echo $CFG->solutionicon; ?>');

hint = "<?php echo $LNG->DATAMODEL_projectToChallenge; ?>";
HUB_DATAMODEL.projectToChallenge = new HubConnection('Project', 'Challenge', '<?php echo $CFG->LINK_ORGP_CHALLENGE; ?>', 'from', hint, '<?php echo $CFG->challengeicon; ?>');

hint = "<?php echo $LNG->DATAMODEL_projectToResource; ?>";
HUB_DATAMODEL.projectToResource = new HubConnection(RESOURCE_TYPES_STR, 'Project', '<?php echo $CFG->LINK_RESOURCE_NODE; ?>', 'to', hint, '<?php echo $CFG->resourceicon; ?>');

hint = "<?php echo $LNG->DATAMODEL_projectToEvidence; ?>";
HUB_DATAMODEL.projectToEvidence = new HubConnection('Project', EVIDENCE_TYPES_STR, '<?php echo $CFG->LINK_ORGP_EVIDENCE; ?>', 'from', hint, '<?php echo $CFG->evidenceicon; ?>');

hint = "<?php echo $LNG->DATAMODEL_projectToOrg; ?>";
HUB_DATAMODEL.projectToOrg = new HubConnection('Organization', 'Project', '<?php echo $CFG->LINK_ORG_PROJECT; ?>', 'to', hint, '<?php echo $CFG->orgicon; ?>');


/** ISSUE AS FOCAL NODE **/
hint = "<?php echo $LNG->DATAMODEL_issueToClaim; ?>";
HUB_DATAMODEL.issueToClaim = new HubConnection('Claim', 'Issue', '<?php echo $CFG->LINK_CLAIM_ISSUE; ?>', 'to', hint, '<?php echo $CFG->claimicon; ?>');

hint = "<?php echo $LNG->DATAMODEL_issueToSolution; ?>";
HUB_DATAMODEL.issueToSolution = new HubConnection('Solution', 'Issue', '<?php echo $CFG->LINK_SOLUTION_ISSUE; ?>', 'to', hint, '<?php echo $CFG->solutionicon; ?>');

hint = "<?php echo $LNG->DATAMODEL_issueToOrg; ?>";
HUB_DATAMODEL.issueToOrg = new HubConnection('Organization', 'Issue', '<?php echo $CFG->LINK_ORGP_ISSUE; ?>', 'to', hint, '<?php echo $CFG->orgicon; ?>');

hint = "<?php echo $LNG->DATAMODEL_issueToProject; ?>";
HUB_DATAMODEL.issueToProject = new HubConnection('Project', 'Issue', '<?php echo $CFG->LINK_ORGP_ISSUE; ?>', 'to', hint, '<?php echo $CFG->projecticon; ?>');

hint= "<?php echo $LNG->DATAMODEL_issueToChallenge; ?>";
HUB_DATAMODEL.issueToChallenge = new HubConnection('Issue', 'Challenge', '<?php echo $CFG->LINK_ISSUE_CHALLENGE; ?>', 'from', hint, '<?php echo $CFG->challengeicon; ?>');

/** CLAIM AS FOCAL NODE **/
hint = "<?php echo $LNG->DATAMODEL_claimToOrg; ?>";
HUB_DATAMODEL.claimToOrg = new HubConnection('Organization', 'Claim', '<?php echo $CFG->LINK_ORGP_CLAIM; ?>', 'to', hint, '<?php echo $CFG->orgicon; ?>');

hint = "<?php echo $LNG->DATAMODEL_claimToProject; ?>";
HUB_DATAMODEL.claimToProject = new HubConnection('Project', 'Claim', '<?php echo $CFG->LINK_ORGP_CLAIM; ?>', 'to', hint, '<?php echo $CFG->projecticon; ?>');

hint = "<?php echo $LNG->DATAMODEL_claimToIssue; ?>";
HUB_DATAMODEL.claimToIssue = new HubConnection('Claim', 'Issue', '<?php echo $CFG->LINK_CLAIM_ISSUE; ?>', 'from', hint, '<?php echo $CFG->issueicon; ?>');


/** CHALLENGE AS FOCAL NODE **/
hint = "<?php echo $LNG->DATAMODEL_challengeToIssue; ?>";
HUB_DATAMODEL.challengeToIssue = new HubConnection('Issue', 'Challenge', '<?php echo $CFG->LINK_ISSUE_CHALLENGE; ?>', 'to', hint, '<?php echo $CFG->issueicon; ?>');

hint = "<?php echo $LNG->DATAMODEL_challengeToOrg; ?>";
HUB_DATAMODEL.challengeToOrg = new HubConnection('Organization', 'Challenge', '<?php echo $CFG->LINK_ORGP_CHALLENGE; ?>', 'to', hint, '<?php echo $CFG->orgicon; ?>');

hint = "<?php echo $LNG->DATAMODEL_challengeToProject; ?>";
HUB_DATAMODEL.challengeToProject = new HubConnection('Project', 'Challenge', '<?php echo $CFG->LINK_ORGP_CHALLENGE; ?>', 'to', hint, '<?php echo $CFG->projecticon; ?>');


/** SOLUTION AS FOCAL NODE **/
hint = "<?php echo $LNG->DATAMODEL_solutionToOrg; ?>";
HUB_DATAMODEL.solutionToOrg = new HubConnection('Organization', 'Solution', '<?php echo $CFG->LINK_ORGP_SOLUTION; ?>', 'to', hint, '<?php echo $CFG->orgicon; ?>');

hint = "<?php echo $LNG->DATAMODEL_solutionToProject; ?>";
HUB_DATAMODEL.solutionToProject = new HubConnection('Project', 'Solution', '<?php echo $CFG->LINK_ORGP_SOLUTION; ?>', 'to', hint, '<?php echo $CFG->projecticon; ?>');

hint = "<?php echo $LNG->DATAMODEL_solutionToIssue; ?>";
HUB_DATAMODEL.solutionToIssue = new HubConnection('Solution', 'Issue', '<?php echo $CFG->LINK_SOLUTION_ISSUE; ?>', 'from', hint, '<?php echo $CFG->issueicon; ?>');


/**
 * The object that holds all the information about a given connection type
 */
function HubConnection(fromnodetypes, tonodetypes, linktypes, direction, hint, icon) {

	this.fromnodetypes = fromnodetypes;
	this.tonodetypes = tonodetypes;
	this.linktypes = linktypes;
	this.hint = hint;
	this.icon = icon;

	/**
	 * either 'to', or 'from' the focal node
	 * 'from' means from the focal node to another one.
	 * 'to' means to the focal node from another one.
	 */
	this.direction = direction;

	/**
	 * Get the main end of the connection (the focal node) depending on the direction.
	 */
	this.getMainEnd = function() {
		var nodetype = this.fromnodetypes;
		if (this.direction == 'to') {
			nodetype = this.tonodetypes;
		}
		return nodetype;
	}

	/**
	 * Get the other end of the connection (from the focal node) depending on the direction.
	 */
	this.getOtherEnd = function() {
		var nodetype = this.tonodetypes;
		if (this.direction == 'to') {
			nodetype = this.fromnodetypes;
		}
		return nodetype;
	}
}

</script>