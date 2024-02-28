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

function drawNetworkNavigationBar($nodetype) {
	global $CFG,$LNG,$CONTEXT,$USER,$CONTEXTUSER,$HUB_FLM; ?>

	<div style="clear:both;float:left;height:60px;width:100%;padding:0px;padding-left:10px; margin-bottom:0px;background:white;border-bottom:1px solid #E8E8E8;border-top:1px solid #E8E8E8" >

		<?php if ($CFG->HAS_CHALLENGE ) { ?>
			<div class="navnetworkicon">
				<?php if ($CONTEXT != $CFG->USER_CONTEXT || ($CONTEXTUSER->userid == $USER->userid && $USER->getIsAdmin() == "Y")) { ?>
					<a class="navnetworklink" href="#challenge-list" onclick="setTabPushed($('tab-challenge-list-obj'),'challenge-list');" title="<?php echo $LNG->CHALLENGE_HOME_LIST_BUTTON_HINT; ?>">
				<?php } else { ?>
					<span title="You cannot navigate to a user <?php echo $LNG->CHALLENGE_NAME; ?> List in this view">
				<?php } ?>

				<center>
				<img class="navnetworkimage" src="<?php echo $CFG->challengeicon ?>" width="20" height="20" />
				<br /><span class="<?php if ($nodetype == 'Challenge') { echo 'navnetworktextselected'; } else { echo 'navnetworktext'; }?>"><?php echo $LNG->CHALLENGE_NAME; ?></span>
				</center>

			<?php if ($CONTEXT != $CFG->USER_CONTEXT || ($CONTEXTUSER->userid == $USER->userid && $USER->getIsAdmin() == "Y")) { ?>
				</a>
			<?php } else { ?>
				</span>
			<?php } ?>
		</div>

		<div class="navnetworkarrow">
			<?php if ($nodetype == 'Challenge' || $nodetype == 'Issue') {?>
				<img src="<?php echo $HUB_FLM->getImagePath('arrow-orange-right-selected.png'); ?>" />
			<?php } else { ?>
				<img src="<?php echo $HUB_FLM->getImagePath('arrow-orange-right.png'); ?>" />
			<?php } ?>
		</div>
		<?php } ?>

		<div class="navnetworkicon">
			<a class="navnetworklink" href="#issue-list" onclick="setTabPushed($('tab-issue-list-obj'),'issue-list');" title="<?php echo $LNG->ISSUE_HOME_LIST_BUTTON_HINT; ?>">
				<center>
				<img class="navnetworkimage" src="<?php echo $CFG->issueicon; ?>" width="20" height="20" />
				<br /><span class="<?php if ($nodetype == 'Issue') { echo 'navnetworktextselected'; } else { echo 'navnetworktext'; }?>"><?php echo $LNG->ISSUE_NAME; ?></span>
				</center>
			</a>
		</div>
		<div class="navnetworkarrow">
			<?php if ($nodetype == 'Claim' || $nodetype == 'Solution' || $nodetype == 'Issue') {?>
				<img src="<?php echo $HUB_FLM->getImagePath('arrow-orange-right-selected.png'); ?>" />
			<?php } else { ?>
				<img src="<?php echo $HUB_FLM->getImagePath('arrow-orange-right.png'); ?>" />
			<?php } ?>
		</div>

		<?php if ($CFG->HAS_SOLUTION) { ?>
		<div class="navnetworkicon">
			<a class="navnetworklink" href="#solution-list" onclick="setTabPushed($('tab-solution-list-obj'),'solution-list');" title="<?php echo $LNG->SOLUTION_HOME_LIST_BUTTON_HINT; ?>">
				<center>
				<img class="navnetworkimage" src="<?php echo $CFG->solutionicon; ?>" width="20" height="20" />
				<br /><span class="<?php if ($nodetype == 'Solution') { echo 'navnetworktextselected'; } else { echo 'navnetworktext'; }?>"><?php echo $LNG->SOLUTION_NAME; ?></span>
				</center>
			</a>
		</div>
		<?php } ?>

		<?php if ($CFG->HAS_SOLUTION && $CFG->HAS_CLAIM) { ?>
		<div class="navnetworkdivider">
			<span style="font-weight:bold;clear:both">/</span>
		</div>
		<?php } ?>

		<?php if ($CFG->HAS_CLAIM) { ?>
		<div class="navnetworkicon">
			<a class="navnetworklink" href="#claim-list" onclick="setTabPushed($('tab-claim-list-obj'),'claim-list');" title="<?php echo $LNG->CLAIM_HOME_LIST_BUTTON_HINT; ?>">
				<center>
				<img class="navnetworkimage" src="<?php echo $CFG->claimicon; ?>" width="20" height="20" />
				<br /><span class="<?php if ($nodetype == 'Claim') { echo 'navnetworktextselected'; } else { echo 'navnetworktext'; }?>"><?php echo $LNG->CLAIM_NAME; ?></span>
				</center>
			</a>
		</div>
		<?php } ?>

		<div class="navnetworkarrow">
			<?php if ($nodetype == 'Claim' || $nodetype == 'Solution' || $nodetype == 'Evidence') {?>
				<img src="<?php echo $HUB_FLM->getImagePath('arrow-orange-right-selected.png'); ?>" />
			<?php } else { ?>
				<img src="<?php echo $HUB_FLM->getImagePath('arrow-orange-right.png'); ?>" />
			<?php } ?>
		</div>
		<div class="navnetworkicon">
			<a class="navnetworklink" href="#evidence-list" onclick="setTabPushed($('tab-evidence-list-obj'),'evidence-list');" title="<?php echo $LNG->EVIDENCE_HOME_LIST_BUTTON_HINT; ?>">
				<center>
				<img class="navnetworkimage" src="<?php echo $CFG->evidenceicon; ?>" width="20" height="20" />
				<br /><span class="<?php if ($nodetype == 'Evidence') { echo 'navnetworktextselected'; } else { echo 'navnetworktext'; }?>"><?php echo $LNG->EVIDENCE_NAME; ?></span>
				</center>
			</a>
		</div>
		<div class="navnetworkarrow">
			<?php if ($nodetype == 'Resource' || $nodetype == 'Evidence') {?>
				<img src="<?php echo $HUB_FLM->getImagePath('arrow-orange-right-selected.png'); ?>" />
			<?php } else { ?>
				<img src="<?php echo $HUB_FLM->getImagePath('arrow-orange-right.png'); ?>" />
			<?php } ?>
		</div>
		<div class="navnetworkicon">
			<a class="navnetworklink" href="#web-list" onclick="setTabPushed($('tab-web-list-obj'),'web-list');" title="<?php echo $LNG->RESOURCE_HOME_LIST_BUTTON_HINT; ?>">
				<center>
				<img class="navnetworkimage" src="<?php echo $CFG->resourceicon; ?>" width="20" height="20" />
				<br /><span class="<?php if ($nodetype == 'Resource') { echo 'navnetworktextselected'; } else { echo 'navnetworktext'; }?>"><?php echo $LNG->RESOURCE_NAME; ?></span>
				</center>
			</a>
		</div>
	</div>

<?php }


function drawNetworkNavigationBarHome($nodetype = "") {
	global $CFG,$LNG,$HUB_FLM; ?>
	<div class="row text-center">
		<div class="col-auto">
			<fieldset class="curvedBorder">
				<legend class="d-none"></legend>
				<?php if ($CFG->HAS_CHALLENGE ) { ?>
					<div class="navnetworkicon">
						<span class="navnetworklink active" onMouseOut="hideHints(); return false;" onMouseOver="showHomeNavText(event, 'ChallengesHome'); return false;" onClick="hideHints(); setTabPushed($('tab-challenge-list-obj'),'challenge-list');" onkeypress="enterKeyPressed(event)">
							<img class="navnetworkimage" src="<?php echo $CFG->challengeicon; ?>" width="20" height="20" alt="" />
							<br /><span class="<?php if ($nodetype == 'Challenge') { echo 'navnetworktextselected'; } else { echo 'navnetworktext'; }?>"><?php echo $LNG->CHALLENGE_NAME; ?></span>
						</span>
					</div>
					<div class="navnetworkarrow">
						<img src="<?php echo $HUB_FLM->getImagePath('arrow-orange-right.jpg'); ?>" alt="" />
					</div>
				<?php } ?>

				<div class="navnetworkicon">
					<span class="navnetworklink active" onMouseOut="hideHints(); return false;" onMouseOver="showHomeNavText(event, 'IssuesHome'); return false;" onClick="hideHints(); setTabPushed($('tab-issue-list-obj'),'issue-list');" onkeypress="enterKeyPressed(event)">
						<img class="navnetworkimage" src="<?php echo $CFG->issueicon; ?>" width="20" height="20" alt="" />
						<br /><span class="<?php if ($nodetype == 'Issue') { echo 'navnetworktextselected'; } else { echo 'navnetworktext'; }?>"><?php echo $LNG->ISSUE_NAME; ?></span>
					</span>
				</div>
				<div class="navnetworkarrow">
					<img src="<?php echo $HUB_FLM->getImagePath('arrow-orange-right.jpg'); ?>" alt="" />
				</div>
				<?php if ($CFG->HAS_SOLUTION) { ?>
					<div class="navnetworkicon">
						<span class="navnetworklink active" onMouseOut="hideHints(); return false;" onMouseOver="showHomeNavText(event, 'SolutionsHome'); return false;" onClick="hideHints(); setTabPushed($('tab-solution-list-obj'),'solution-list');" onkeypress="enterKeyPressed(event)">
							<img class="navnetworkimage" src="<?php echo $CFG->solutionicon; ?>" width="20" height="20" alt="" />
							<br /><span class="<?php if ($nodetype == 'Solution') { echo 'navnetworktextselected'; } else { echo 'navnetworktext'; }?>"><?php echo $LNG->SOLUTION_NAME; ?></span>
						</span>
					</div>
				<?php } ?>

				<?php if ($CFG->HAS_SOLUTION && $CFG->HAS_CLAIM) { ?>
					<div class="navnetworkdivider">
						<span>/</span>
					</div>
				<?php } ?>

				<?php if ($CFG->HAS_CLAIM) { ?>
					<div class="navnetworkicon">
						<span class="navnetworklink active" onMouseOut="hideHints(); return false;" onMouseOver="showHomeNavText(event, 'ClaimsHome'); return false;" onClick="hideHints(); setTabPushed($('tab-claim-list-obj'),'claim-list');" onkeypress="enterKeyPressed(event)">
							<img class="navnetworkimage" src="<?php echo $CFG->claimicon; ?>" width="20" height="20" alt="" />
							<br /><span class="<?php if ($nodetype == 'Claim') { echo 'navnetworktextselected'; } else { echo 'navnetworktext'; }?>"><?php echo $LNG->CLAIM_NAME; ?></span>
						</span>
					</div>
				<?php } ?>
				<div class="navnetworkarrow">
					<img src="<?php echo $HUB_FLM->getImagePath('arrow-orange-right.jpg'); ?>" alt="" />
				</div>
				<div class="navnetworkicon">
					<span class="navnetworklink active" onMouseOut="hideHints(); return false;" onMouseOver="showHomeNavText(event, 'EvidenceHome'); return false;" onClick="hideHints(); setTabPushed($('tab-evidence-list-obj'),'evidence-list');" onkeypress="enterKeyPressed(event)">
						<img class="navnetworkimage" src="<?php echo $CFG->evidenceicon; ?>" width="20" height="20" alt="" />
						<br /><span class="<?php if ($nodetype == 'Evidence') { echo 'navnetworktextselected'; } else { echo 'navnetworktext'; }?>"><?php echo $LNG->EVIDENCE_NAME; ?></span>
					</span>
				</div>
				<div class="navnetworkarrow">
					<img src="<?php echo $HUB_FLM->getImagePath('arrow-orange-right.jpg'); ?>" alt="" />
				</div>
				<div class="navnetworkicon">
					<span class="navnetworklink active" onMouseOut="hideHints(); return false;" onMouseOver="showHomeNavText(event, 'ResourcesHome'); return false;" onClick="hideHints(); setTabPushed($('tab-web-list-obj'),'web-list');" onkeypress="enterKeyPressed(event)">
						<img class="navnetworkimage" src="<?php echo $CFG->resourceicon; ?>" width="20" height="20" alt="" />
						<br /><span class="<?php if ($nodetype == 'Resource') { echo 'navnetworktextselected'; } else { echo 'navnetworktext'; }?>"><?php echo $LNG->RESOURCE_NAME; ?></span>
					</span>
				</div>
			</fieldset>
		</div>

		<div class="col-auto">
			<div class="pt-4">
				<img src="<?php echo $HUB_FLM->getImagePath('arrow-orange-right-selected.png'); ?>" alt="" />
			</div>
		</div>

		<div class="col-auto">
			<fieldset class="curvedBorder">
				<legend class="d-none"></legend>
				<div class="navnetworkicon">
					<span class="navnetworklink active" onMouseOut="hideHints(); return false;" onMouseOver="showHomeNavText(event, 'OrganisationsHome'); return false;" onClick="hideHints(); setTabPushed($('tab-org-list-obj'),'org-list');" onkeypress="enterKeyPressed(event)">
						<img class="navnetworkimage" src="<?php echo $CFG->evidenceicon; ?>" width="20" height="20" alt="" />
						<br /><span class="<?php if ($nodetype == 'Organisation') { echo 'navnetworktextselected'; } else { echo 'navnetworktext'; }?>"><?php echo $LNG->ORG_NAME; ?></span>
					</span>
				</div>
				<div class="navnetworkarrow">
					<img src="<?php echo $HUB_FLM->getImagePath('arrow-orange-right.jpg'); ?>" alt="" />
				</div>
				<div class="navnetworkicon">
					<span class="navnetworklink active" onMouseOut="hideHints(); return false;" onMouseOver="showHomeNavText(event, 'ProjectsHome'); return false;" onClick="hideHints(); setTabPushed($('tab-project-list-obj'),'project-list');" onkeypress="enterKeyPressed(event)">
						<img class="navnetworkimage" src="<?php echo $CFG->resourceicon; ?>" width="20" height="20" alt="" />
						<br /><span class="<?php if ($nodetype == 'Project') { echo 'navnetworktextselected'; } else { echo 'navnetworktext'; }?>"><?php echo $LNG->PROJECT_NAME; ?></span>
					</span>
				</div>
			</fieldset>
		</div>
	</div>

<?php }


function drawNetworkNavigationBarOrg($nodetype) {
	global $CFG,$LNG,$HUB_FLM;?>


	<script type='text/javascript'>
	function filterOrgsFromNav(objname, type) {
		if ($(objname).className == 'navnetworktextselected') {
			$('project-nav-text').className = 'navnetworktext';
			$('org-nav-text').className = 'navnetworktext';
			ORG_ARGS['filternodetypes'] = "";
			refreshOrganizations();
		} else {
			$('project-nav-text').className = 'navnetworktext';
			$('org-nav-text').className = 'navnetworktext';

			switch(CURRENT_VIZ){
				case 'net':
					if (ORG_ARGS['filterthemes'] && ORG_ARGS['filterthemes'] != "") {
						ORG_ARGS['filternodetypes'] = type;
						refreshOrganizations();
						$(objname).className = 'navnetworktextselected';
					} else {
						alert('Please also select a theme');
						break;
					}
				default :
					ORG_ARGS['filternodetypes'] = type;
					refreshOrganizations();
					$(objname).className = 'navnetworktextselected';
				break;
			}
		}
	}
	</script>

	<div style="clear:both;float:left;height:60px;width:100%;padding:0px;margin-bottom:0px;background:white;border-bottom:2px solid #D3D3D3;border-top:2px solid #D3D3D3" >
		<div class="navnetworkiconfirst">
			<a class="navnetworklink" href="#org-list" onclick="filterOrgsFromNav('org-nav-text', 'Organization');" title="<?php echo $LNG->NAV_FILTER_ORG_HINT; ?>">
				<center>
				<img class="navnetworkimage" src="<?php echo $CFG->evidenceicon; ?>" width="20" height="20" />
				<br /><span id="org-nav-text" class="<?php if ($nodetype == 'none') { echo 'navnetworktextselected'; } else { echo 'navnetworktext'; }?>"><?php echo $LNG->ORG_NAME; ?></span>
				</center>
			</a>
		</div>
		<div class="navnetworkarrow">
			<img src="<?php echo $HUB_FLM->getImagePath('arrow-orange-right.jpg'); ?>" />
		</div>
		<div class="navnetworkicon">
			<a class="navnetworklink" href="#org-list" onclick="filterOrgsFromNav('project-nav-text', 'Project');" title="<?php echo $LNG->NAV_FILTER_PROJECT_HINT; ?>">
				<center>
				<img class="navnetworkimage" src="<?php echo $CFG->resourceicon; ?>" width="20" height="20" />
				<br /><span id="project-nav-text" class="<?php if ($nodetype == 'none') { echo 'navnetworktextselected'; } else { echo 'navnetworktext'; }?>"><?php echo $LNG->PROJECT_NAME; ?></span>
				</center>
			</a>
		</div>
	</div>
<?php }


function drawNetworkNavigationBarExplore($nodetype) {
	global $CFG,$LNG,$HUB_FLM; ?>

	<div style="clear:both;float:left;height:60px;width:100%;padding:0px;margin-bottom:10px;background:white;border-bottom:2px solid #D3D3D3;border-top:2px solid #D3D3D3" >

		<?php if ($CFG->HAS_CHALLENGE) { ?>
		<div class="navnetworkiconfirst">
			<a class="navnetworklink" href="<?php echo $CFG->homeAddress; ?>#challenge-list" title="<?php echo $LNG->CHALLENGE_HOME_LIST_BUTTON_HINT; ?>">
				<center>
				<img class="navnetworkimage" src="<?php echo $CFG->challengeicon; ?>" width="20" height="20" />
				<br /><span class="<?php if ($nodetype == 'Challenge') { echo 'navnetworktextselected'; } else { echo 'navnetworktext'; }?>"><?php echo $LNG->CHALLENGE_NAME; ?></span>
				</center>
			</a>
		</div>
		<div class="navnetworkarrow">
			<img src="<?php echo $HUB_FLM->getImagePath('arrow-orange-right.jpg'); ?>" />
		</div>
		<?php } ?>

		<?php if ($CFG->HAS_CHALLENGE) { ?>
			<div class="navnetworkicon">
		<?php } else { ?>
			<div class="navnetworkiconfirst">
		<?php } ?>
			<a class="navnetworklink" href="<?php echo $CFG->homeAddress; ?>#issue-list" title="<?php echo $LNG->ISSUE_HOME_LIST_BUTTON_HINT; ?>">
				<center>
				<img class="navnetworkimage" src="<?php echo $CFG->issueicon; ?>" width="20" height="20" />
				<br /><span class="<?php if ($nodetype == 'Issue') { echo 'navnetworktextselected'; } else { echo 'navnetworktext'; }?>"><?php echo $LNG->ISSUE_NAME; ?></span>
				</center>
			</a>
		</div>
		<div class="navnetworkarrow">
			<img src="<?php echo $HUB_FLM->getImagePath('arrow-orange-right.jpg'); ?>" />
		</div>
		<?php if ($CFG->HAS_SOLUTION) { ?>
		<div class="navnetworkicon">
			<a class="navnetworklink" href="<?php echo $CFG->homeAddress; ?>#solution-list" title="<?php echo $LNG->SOLUTION_HOME_LIST_BUTTON_HINT; ?>">
				<center>
				<img class="navnetworkimage" src="<?php echo $CFG->solutionicon; ?>" width="20" height="20" />
				<br /><span class="<?php if ($nodetype == 'Solution') { echo 'navnetworktextselected'; } else { echo 'navnetworktext'; }?>"><?php echo $LNG->SOLUTION_NAME; ?></span>
				</center>
			</a>
		</div>
		<?php } ?>

		<?php if ($CFG->HAS_SOLUTION && $CFG->HAS_CLAIM) { ?>
		<div class="navnetworkdivider">
			<span style="font-weight:bold;clear:both">/</span>
		</div>
		<?php } ?>

		<?php if ($CFG->HAS_CLAIM) { ?>
		<div class="navnetworkicon">
			<a class="navnetworklink" href="<?php echo $CFG->homeAddress; ?>#claim-list" title="<?php echo $LNG->CLAIM_HOME_LIST_BUTTON_HINT; ?>">
				<center>
				<img class="navnetworkimage" src="<?php echo $CFG->claimicon; ?>" width="20" height="20" />
				<br /><span class="<?php if ($nodetype == 'Claim') { echo 'navnetworktextselected'; } else { echo 'navnetworktext'; }?>"><?php echo $LNG->CLAIM_NAME; ?></span>
				</center>
			</a>
		</div>
		<?php } ?>
		<div class="navnetworkarrow">
			<img src="<?php echo $HUB_FLM->getImagePath('arrow-orange-right.jpg'); ?>" />
		</div>
		<div class="navnetworkicon">
			<a class="navnetworklink" href="<?php echo $CFG->homeAddress; ?>#evidence-list" title="<?php echo $LNG->EVIDENCE_HOME_LIST_BUTTON_HINT; ?>">
				<center>
				<img class="navnetworkimage" src="<?php echo $CFG->evidenceicon; ?>" width="20" height="20" />
				<br /><span class="<?php if (in_array($nodetype, $CFG->EVIDENCE_TYPES)) { echo 'navnetworktextselected'; } else { echo 'navnetworktext'; }?>"><?php echo $LNG->EVIDENCE_NAME; ?></span>
				</center>
			</a>
		</div>
		<div class="navnetworkarrow">
			<img src="<?php echo $HUB_FLM->getImagePath('arrow-orange-right.jpg'); ?>" />
		</div>
		<div class="navnetworkicon">
			<a class="navnetworklink" href="<?php echo $CFG->homeAddress; ?>#web-list" title="<?php echo $LNG->RESOURCE_HOME_LIST_BUTTON_HINT; ?>">
				<center>
				<img class="navnetworkimage" src="<?php echo $CFG->resourceicon; ?>" width="20" height="20" />
				<br /><span class="<?php if (in_array($nodetype, $CFG->RESOURCE_TYPES)) { echo 'navnetworktextselected'; } else { echo 'navnetworktext'; }?>"><?php echo $LNG->RESOURCE_NAME; ?></span>
				</center>
			</a>
		</div>
	</div>
<?php }

function drawNetworkNavigationBarExploreOrg($nodetype) {
	global $CFG,$LNG,$HUB_FLM; ?>

	<div style="clear:both;float:left;height:60px;width:100%;padding:0px;margin-bottom:10px;background:white;border-bottom:2px solid #D3D3D3;border-top:2px solid #D3D3D3" >
		<div class="navnetworkiconfirst">
			<a class="navnetworklink"  href="<?php echo $CFG->homeAddress; ?>index.php?filternodetypes=Organization#org-list" title="<?php echo $LNG->ORG_HOME_LIST_BUTTON_HINT; ?>">
				<center>
				<img class="navnetworkimage" src="<?php echo $CFG->evidenceicon; ?>" width="20" height="20" />
				<br /><span class="<?php if ($nodetype == 'Organization') { echo 'navnetworktextselected'; } else { echo 'navnetworktext'; }?>"><?php echo $LNG->ORG_NAME; ?></span>
				</center>
			</a>
		</div>
		<div class="navnetworkarrow">
			<img src="<?php echo $HUB_FLM->getImagePath('arrow-orange-right.jpg'); ?>" />
		</div>
		<div class="navnetworkicon">
			<a class="navnetworklink" href="<?php echo $CFG->homeAddress; ?>index.php?filternodetypes=Project#org-list" title="<?php echo $LNG->ORG_HOME_LIST_BUTTON_HINT; ?>">
				<center>
				<img class="navnetworkimage" src="<?php echo $CFG->resourceicon; ?>" width="20" height="20" />
				<br /><span class="<?php if ($nodetype == 'Project') { echo 'navnetworktextselected'; } else { echo 'navnetworktext'; }?>"><?php echo $LNG->PROJECT_NAME; ?></span>
				</center>
			</a>
		</div>

	</div>
<?php }

function drawNetworkNavigationBarQuickFormP($nodetype) {
	global $CFG,$LNG,$HUB_FLM; ?>

	<div style="clear:both;float:left;height:75px;width:710px;margin:0px;padding:0px;background:white;border-top:2px solid #D3D3D3;border-bottom:2px solid #D3D3D3;margin-top:0px;margin-bottom:20px;" >
		<div class="navnetworkiconfirst">
			<span class="navnetworklink" onclick="switchSteps(5, 1)" title="<?php echo $LNG->QUICKFORM_STEP1_HINT; ?>">
				<center>
				<img class="navnetworkimage" src="<?php echo $CFG->issueicon; ?>" width="20" height="20" />
				<br /><span class="<?php if ($nodetype == 'Issue') { echo 'navnetworktextselected'; } else { echo 'navnetworktext'; }?>" style="font-size:8pt"><?php echo $LNG->QUICKFORM_STEP1; ?></span>
				</center>
			</span>
		</div>
		<div class="navnetworkarrowshort">
			<img src="<?php echo $HUB_FLM->getImagePath('arrow-orange-right.jpg'); ?>" />
		</div>
		<div class="navnetworkicon">
			<span class="navnetworklink" onclick="switchSteps(5, 2)" title="<?php echo $LNG->QUICKFORM_P_STEP2_HINT; ?>">
				<center>
				<img class="navnetworkimage" src="<?php echo $CFG->solutionicon; ?>" width="20" height="20" />
				<br /><span class="<?php if ($nodetype == 'Solution') { echo 'navnetworktextselected'; } else { echo 'navnetworktext'; }?>" style="font-size:8pt"><?php echo $LNG->QUICKFORM_P_STEP2; ?></span>
				</center>
			</span>
		</div>
		<div class="navnetworkarrowshort">
			<img src="<?php echo $HUB_FLM->getImagePath('arrow-orange-right.jpg'); ?>" />
		</div>
		<div class="navnetworkicon">
			<span class="navnetworklink" onclick="switchSteps(5, 3)" title="<?php echo $LNG->QUICKFORM_STEP3_HINT; ?>">
				<center>
				<img class="navnetworkimage" src="<?php echo $CFG->evidenceicon; ?>" width="20" height="20" />
				<br /><span class="<?php if ($nodetype == 'Evidence') { echo 'navnetworktextselected'; } else { echo 'navnetworktext'; }?>" style="font-size:8pt"><?php echo $LNG->QUICKFORM_STEP3; ?></span>
				</center>
			</span>
		</div>
		<div class="navnetworkarrowshort">
			<img src="<?php echo $HUB_FLM->getImagePath('arrow-orange-right.jpg'); ?>" />
		</div>
		<div class="navnetworkicon">
			<span class="navnetworklink" onclick="switchSteps(5, 4)" title="<?php echo $LNG->QUICKFORM_STEP4_HINT; ?>">
				<center>
				<img class="navnetworkimage" src="<?php echo $CFG->resourceicon; ?>" width="20" height="20" />
				<br /><span class="<?php if ($nodetype == 'Resource') { echo 'navnetworktextselected'; } else { echo 'navnetworktext'; }?>" style="font-size:8pt"><?php echo $LNG->QUICKFORM_STEP4; ?><br /><?php echo $LNG->QUICKFORM_OPTIONAL; ?></span>
				</center>
			</span>
		</div>
		<div class="navnetworkarrowshort">
			<img src="<?php echo $HUB_FLM->getImagePath('arrow-orange-right.jpg'); ?>" />
		</div>
		<div class="navnetworkicon">
			<span class="navnetworklink" onclick="switchSteps(5, 5)" title="<?php echo $LNG->QUICKFORM_STEP5_HINT; ?>">
				<center>
				<img class="navnetworkimage" src="<?php echo $CFG->themeicon; ?>" width="20" height="20" />
				<br /><span class="<?php if ($nodetype == 'Theme') { echo 'navnetworktextselected'; } else { echo 'navnetworktext'; }?>" style="font-size:8pt"><?php echo $LNG->QUICKFORM_STEP5; ?><br /><?php echo $LNG->QUICKFORM_STEP5b; ?></span>
				</center>
			</span>
		</div>
	</div>

<?php }

function drawNetworkNavigationBarQuickFormR($nodetype) {
	global $CFG,$LNG,$HUB_FLM; ?>

	<div style="clear:both;float:left;height:75px;width:710px;;margin:0;padding:0px;margin-bottom:0px;background:white;border-top:2px solid #D3D3D3;border-bottom:2px solid #D3D3D3;margin-top:0px;margin-bottom:20px;" >
		<div class="navnetworkiconfirst">
			<span class="navnetworklink" onclick="switchSteps(5, 1)" title="<?php echo $LNG->QUICKFORM_STEP1_HINT; ?>">
				<center>
				<img class="navnetworkimage" src="<?php echo $CFG->issueicon; ?>" width="20" height="20" />
				<br /><span class="<?php if ($nodetype == 'Issue') { echo 'navnetworktextselected'; } else { echo 'navnetworktext'; }?>" style="font-size:8pt"><?php echo $LNG->QUICKFORM_STEP1; ?></span>
				</center>
			</span>
		</div>
		<div class="navnetworkarrowshort">
			<img src="<?php echo $HUB_FLM->getImagePath('arrow-orange-right.jpg'); ?>" />
		</div>
		<div class="navnetworkicon">
			<span class="navnetworklink" onclick="switchSteps(5, 2)" title="<?php echo $LNG->QUICKFORM_R_STEP2_HINT; ?>">
				<center>
				<img class="navnetworkimage" src="<?php echo $CFG->claimicon; ?>" width="20" height="20" />
				<br /><span class="<?php if ($nodetype == 'Claim') { echo 'navnetworktextselected'; } else { echo 'navnetworktext'; }?>" style="font-size:8pt"><?php echo $LNG->QUICKFORM_R_STEP2; ?></span>
				</center>
			</span>
		</div>
		<div class="navnetworkarrowshort">
			<img src="<?php echo $HUB_FLM->getImagePath('arrow-orange-right.jpg'); ?>" />
		</div>
		<div class="navnetworkicon">
			<span class="navnetworklink" onclick="switchSteps(5, 3)" title="<?php echo $LNG->QUICKFORM_STEP3_HINT; ?>">
				<center>
				<img class="navnetworkimage" src="<?php echo $CFG->evidenceicon; ?>" width="20" height="20" />
				<br /><span class="<?php if ($nodetype == 'Evidence') { echo 'navnetworktextselected'; } else { echo 'navnetworktext'; }?>" style="font-size:8pt"><?php echo $LNG->QUICKFORM_STEP3; ?></span>
				</center>
			</span>
		</div>
		<div class="navnetworkarrowshort">
			<img src="<?php echo $HUB_FLM->getImagePath('arrow-orange-right.jpg'); ?>" />
		</div>
		<div class="navnetworkicon">
			<span class="navnetworklink" onclick="switchSteps(5, 4)" title="<?php echo $LNG->QUICKFORM_STEP4_HINT; ?>">
				<center>
				<img class="navnetworkimage" src="<?php echo $CFG->resourceicon; ?>" width="20" height="20" />
				<br /><span class="<?php if ($nodetype == 'Resource') { echo 'navnetworktextselected'; } else { echo 'navnetworktext'; }?>" style="font-size:8pt"><?php echo $LNG->QUICKFORM_STEP4; ?><br /><?php echo $LNG->QUICKFORM_OPTIONAL; ?></span>
				</center>
			</span>
		</div>
		<div class="navnetworkarrowshort">
			<img src="<?php echo $HUB_FLM->getImagePath('arrow-orange-right.jpg'); ?>" />
		</div>
		<div class="navnetworkicon">
			<span class="navnetworklink" onclick="switchSteps(5, 5)" title="<?php echo $LNG->QUICKFORM_STEP5_HINT; ?>">
				<center>
				<img class="navnetworkimage" src="<?php echo $CFG->themeicon; ?>" width="20" height="20" />
				<br /><span class="<?php if ($nodetype == 'Theme') { echo 'navnetworktextselected'; } else { echo 'navnetworktext'; }?>" style="font-size:8pt"><?php echo $LNG->QUICKFORM_STEP5; ?><br /><?php echo $LNG->QUICKFORM_STEP5b; ?></span>
				</center>
			</span>
		</div>
	</div>

<?php }

?>

