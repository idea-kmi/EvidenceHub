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
	include_once($_SERVER['DOCUMENT_ROOT'].'/config.php');

	global $CFG;

	if($USER->getIsAdmin() == "Y") {
		include_once($HUB_FLM->getCodeDirPath("ui/headeradmin.php"));
	} else if($CFG->areStatsPublic) {
		include_once($HUB_FLM->getCodeDirPath("ui/headerstats.php"));
	} else {
		include_once($HUB_FLM->getCodeDirPath("ui/header.php"));
	}

	if(!$CFG->areStatsPublic && $USER->getIsAdmin() != "Y") {
		echo "<div class='alert alert-danger m-5'>".$LNG->FORM_ERROR_NOT_ADMIN."</div>";
		include_once($HUB_FLM->getCodeDirPath("ui/headerfooter.php"));
		die;
	}

	$sort = optional_param("sort","vote",PARAM_ALPHANUM);
	$oldsort = optional_param("lastsort","",PARAM_ALPHANUM);
	$direction = optional_param("lastdir","DESC",PARAM_ALPHANUM);

	$totalsItems = getTotalItemVotes();
	$totalsConns = getTotalConnectionVotes();
	$totals = getTotalVotes();

	$topVotedNodes = getTotalTopVotes(10);
	$topVotedForNodes = getTopNodeForVotes(10);
	$topVotedAgainstNodes = getTopNodeAgainstVotes(10);

	$topVoters = getTopVoters(10);
	$topVotersFor = getTopForVoters(10);
	$topVotersAgainst = getTopAgainstVoters(10);

	$allNodeVotes = getAllVoting($direction, $sort, $oldsort);
?>

<link rel="stylesheet" href="<?php echo $HUB_FLM->getCodeWebPath("ui/lib/DataTables/datatables.min.css"); ?>" type="text/css" />
<script src="<?php echo $CFG->homeAddress; ?>ui/lib/DataTables/datatables.js" type="text/javascript"></script>

<?php
	if($CFG->areStatsPublic) {
		if (file_exists("menu.php") ) {
			include("menu.php");
		}
	} else if (!$CFG->areStatsPublic && $USER->getIsAdmin() == "Y") {
		if (file_exists("menu.php") ) {
			include("menu.php");
		}
	}
?>

<div class="container-fluid">
	<div class="border border-top-0 p-3 mx-4">
		<div class="row p-3">
			
			<h3 class="px-0"><?php echo $LNG->STATS_GLOBAL_VOTES_MENU_TITLE; ?></h3>

			<div class="d-flex gap-3 p-0 mt-2">
				<div class="border p-2 col-2">
					<table class="table table-sm">
						<thead>
							<tr>
								<th colspan="2"><?php echo $LNG->STATS_GLOBAL_ITEM_VOTES_MENU_TITLE; ?></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td class="fw-bold" style="color:green;"><?php echo $LNG->STATS_GLOBAL_VOTES_TOP_NODES_FOR_HEADING; ?></td>
								<td class="text-end"><?php echo $totalsItems[0]['up']; ?></td>
							</tr>
							<tr>
								<td class="fw-bold" style="color:red"><?php echo $LNG->STATS_GLOBAL_VOTES_TOP_NODES_AGAINST_HEADING; ?></td>
								<td class="text-end"><?php echo $totalsItems[0]['down']; ?></td>
							</tr>
							<tr>
								<td class="fw-bold"><?php echo $LNG->STATS_GLOBAL_VOTES_TOP_NODES_TOTAL_HEADING; ?></td>
								<td class="text-end"><?php echo $totalsItems[0]['vote']; ?></td>
							</tr>
						</tbody>
					</table>
				</div>

				<div class="border p-2 col-2">
					<table class="table table-sm">
						<thead>
							<tr>
								<th colspan="2"><?php echo $LNG->STATS_GLOBAL_CONNECTION_VOTES_MENU_TITLE; ?></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td class="fw-bold" style="color:green;"><?php echo $LNG->STATS_GLOBAL_VOTES_TOP_NODES_FOR_HEADING; ?></td>
								<td class="text-end"><?php echo $totalsConns[0]['up']; ?></td>
							</tr>
							<tr>
								<td class="fw-bold" style="color:red"><?php echo $LNG->STATS_GLOBAL_VOTES_TOP_NODES_AGAINST_HEADING; ?></td>
								<td class="text-end"><?php echo $totalsConns[0]['down']; ?></td>
							</tr>
							<tr>
								<td class="fw-bold"><?php echo $LNG->STATS_GLOBAL_VOTES_TOP_NODES_TOTAL_HEADING; ?></td>
								<td class="text-end"><?php echo $totalsConns[0]['vote']; ?></td>
							</tr>
						</tbody>
					</table>
				</div>

				<div class="border p-2 col-2">
					<table class="table table-sm">
						<thead>
							<tr>
								<th colspan="2"><?php echo $LNG->STATS_GLOBAL_ALL_VOTES_MENU_TITLE; ?></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td class="fw-bold" style="color:green;"><?php echo $LNG->STATS_GLOBAL_VOTES_TOP_NODES_FOR_HEADING; ?></td>
								<td class="text-end"><?php echo $totals[0]['up']; ?></td>
							</tr>
							<tr>
								<td class="fw-bold" style="color:red"><?php echo $LNG->STATS_GLOBAL_VOTES_TOP_NODES_AGAINST_HEADING; ?></td>
								<td class="text-end"><?php echo $totals[0]['down']; ?></td>
							</tr>
							<tr>
								<td class="fw-bold"><?php echo $LNG->STATS_GLOBAL_VOTES_TOP_NODES_TOTAL_HEADING; ?></td>
								<td class="text-end"><?php echo $totals[0]['vote']; ?></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>

			<div class="d-flex flex-wrap gap-3 p-3 my-4 border-bottom border-top">
				<a name="top"></a>
				<a class="btn btn-admin" href="#voting"><?php echo $LNG->STATS_GLOBAL_VOTES_TOP_NODES; ?></a>
				<a class="btn btn-admin" href="#votingfor"><?php echo $LNG->STATS_GLOBAL_VOTES_TOP_FOR_NODES; ?></a>
				<a class="btn btn-admin" href="#votingagainst"><?php echo $LNG->STATS_GLOBAL_VOTES_TOP_AGAINST_NODES; ?></a>
				<a class="btn btn-admin" href="#voters"><?php echo $LNG->STATS_GLOBAL_VOTES_VOTERS_MENU_TITLE; ?></a>
				<a class="btn btn-admin" href="#allvotes"><?php echo $LNG->STATS_GLOBAL_VOTES_ALL_VOTES_MENU_TITLE; ?></a>
			</div>

			<div class="my-3">
				<a name="voting"></a>
				<h3 class="mb-2">
					<?php echo $LNG->STATS_GLOBAL_VOTES_TOP_NODES; ?>
					<a title="<?php echo $LNG->BACKTOTOP; ?>" href="#top" class="ms-2 backtotop">[<?php echo $LNG->BACKTOTOP; ?>]</a>
				</h3>
				<table class="table table-sm table-striped">
					<thead>
						<tr class="challengeback align-middle text-white">
							<th><?php echo $LNG->STATS_GLOBAL_VOTES_TOP_NODES_CATEGORY_HEADING; ?></th>
							<th width="50%"><?php echo $LNG->STATS_GLOBAL_VOTES_TOP_NODES_TITLE_HEADING; ?></th>
							<th class="text-end"><?php echo $LNG->STATS_GLOBAL_VOTES_ITEM_FOR_HEADING; ?></th>
							<th class="text-end"><?php echo $LNG->STATS_GLOBAL_VOTES_ITEM_AGAINST_HEADING; ?></th>
							<th class="text-end"><?php echo $LNG->STATS_GLOBAL_VOTES_CONN_FOR_HEADING; ?></th>
							<th class="text-end"><?php echo $LNG->STATS_GLOBAL_VOTES_CONN_AGAINST_HEADING; ?></th>
							<th class="text-end"><?php echo $LNG->STATS_GLOBAL_VOTES_TOP_NODES_TOTAL_HEADING; ?></th>
						</tr>
					</thead>
					<tbody>
						<?php
							$count = $topVotedNodes->count;
							for ($i = 0; $i < $count; $i++) {
								$n = $topVotedNodes->nodes[$i];
								$nodetype = $n->role->name;
								$title = $n->name;
								if (in_array($nodetype, $CFG->RESOURCE_TYPES)) {
									$title = $n['Description'];
								}
								?>
								<tr>
									<td><?php echo getNodeTypeText($nodetype, false); ?></td>
									<td><a href="<?php echo $CFG->homeAddress;?>explore.php?id=<?php echo $n->nodeid; ?>" target="_blank"><?php echo $title ?></a></td>
									<td class="text-end" style="color: green"><?php echo $n->up ?></td>
									<td class="text-end" style="color: red"><?php echo $n->down ?></td>
									<td class="text-end" style="color: green"><?php echo $n->cup ?></td>
									<td class="text-end" style="color: red"><?php echo $n->cdown ?></td>
									<td class="text-end fw-bold"><?php echo $n->vote ?></td>
								</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>

			<div class="my-3">
				<a name="votingfor"></a>
				<h3 class="mb-2"> 
					<span style="color: green;"><?php echo $LNG->STATS_GLOBAL_VOTES_TOP_FOR_NODES; ?></span>
					<a title="<?php echo $LNG->BACKTOTOP; ?>" href="#top" class="ms-2 backtotop">[<?php echo $LNG->BACKTOTOP; ?>]</a>
				</h3>
				<table class="table table-sm table-striped">
					<thead>
						<tr class="challengeback fw-bold align-middle text-white">
							<td><?php echo $LNG->STATS_GLOBAL_VOTES_TOP_NODES_CATEGORY_HEADING; ?></td>
							<td width="60%"><?php echo $LNG->STATS_GLOBAL_VOTES_TOP_NODES_TITLE_HEADING; ?></td>
							<td class="text-end"><?php echo $LNG->STATS_GLOBAL_VOTES_ITEM_FOR_HEADING; ?></td>
							<td class="text-end"><?php echo $LNG->STATS_GLOBAL_VOTES_CONN_FOR_HEADING; ?></td>
							<td class="text-end"><?php echo $LNG->STATS_GLOBAL_VOTES_TOP_NODES_TOTAL_HEADING; ?></td>
						</tr>
					</thead>
					<tbody>
						<?php
							$count = $topVotedForNodes->count;
							for ($i = 0; $i < $count; $i++) {
								$n = $topVotedForNodes->nodes[$i];
								$nodetype = $n->role->name;
								$title = $n->name;
								if (in_array($nodetype, $CFG->RESOURCE_TYPES)) {
									$title = $n->description;
								}
								?>
								<tr>
									<td><?php echo getNodeTypeText($nodetype, false); ?></td>
									<td><a href="<?php echo $CFG->homeAddress;?>explore.php?id=<?php echo $n->nodeid; ?>" target="_blank"><?php echo $title ?></a></td>
									<td class="text-end" style="color: green;"><?php echo $n->up ?></td>
									<td class="text-end" style="color: green;"><?php echo $n->cup ?></td>
									<td class="text-end fw-bold"><?php echo $n->vote ?></td>
								</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>

			<div class="my-3">
				<a name="votingagainst"></a>
				<h3 class="mb-2"> 
					<span style="color: red;"><?php echo $LNG->STATS_GLOBAL_VOTES_TOP_AGAINST_NODES; ?></span>
					<a title="<?php echo $LNG->BACKTOTOP; ?>" href="#top" class="ms-2 backtotop">[<?php echo $LNG->BACKTOTOP; ?>]</a>
				</h3>
				<table class="table table-sm table-striped">
					<thead>
						<tr class="challengeback fw-bold align-middle text-white">
							<td><?php echo $LNG->STATS_GLOBAL_VOTES_TOP_NODES_CATEGORY_HEADING; ?></td>
							<td width="60%"><?php echo $LNG->STATS_GLOBAL_VOTES_TOP_NODES_TITLE_HEADING; ?></td>
							<td class="text-end"><?php echo $LNG->STATS_GLOBAL_VOTES_ITEM_FOR_HEADING; ?></td>
							<td class="text-end"><?php echo $LNG->STATS_GLOBAL_VOTES_CONN_FOR_HEADING; ?></td>
							<td class="text-end"><?php echo $LNG->STATS_GLOBAL_VOTES_TOP_NODES_TOTAL_HEADING; ?></td>
						</tr>
					</thead>
					<tbody>
						<?php
							$count = $topVotedAgainstNodes->count;
							for ($i = 0; $i < $count; $i++) {
								$n = $topVotedAgainstNodes->nodes[$i];
								$nodetype = $n->role->name;
								$title = $n->name;
								if (in_array($nodetype, $CFG->RESOURCE_TYPES)) {
									$title = $n->description;
								}
								?>
								<tr>
									<td><?php echo getNodeTypeText($nodetype, false); ?></td>
									<td><a href="<?php echo $CFG->homeAddress;?>explore.php?id=<?php echo $n->nodeid; ?>" target="_blank"><?php echo $title ?></a></td>
									<td class="text-end" tyle="color: red;"><?php echo $n->down ?></td>
									<td class="text-end" style="color: red;"><?php echo $n->cdown ?></td>
									<td class="text-end fw-bold"><?php echo $n->vote ?></td>
								</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>

			<div class="my-3 d-flex flex-wrap justify-content-start gap-3 ps-0">
				<a name="voters"></a>
				<div class="col-3">
					<h3>
						<?php echo $LNG->STATS_GLOBAL_VOTES_TOP_VOTERS; ?>
						<a title="<?php echo $LNG->BACKTOTOP; ?>" href="#top" class="ms-2 backtotop">[<?php echo $LNG->BACKTOTOP; ?>]</a>
					</h3>
					<table class="table table-sm table-striped">
						<thead>
							<tr class="challengeback fw-bold align-middle text-white">
								<td><?php echo $LNG->STATS_GLOBAL_VOTES_TOP_NODES_TITLE_HEADING; ?></td>
								<td class="text-end"><?php echo $LNG->STATS_GLOBAL_VOTES_TOP_NODES_FOR_HEADING; ?></td>
								<td class="text-end"><?php echo $LNG->STATS_GLOBAL_VOTES_TOP_NODES_AGAINST_HEADING; ?></td>
								<td class="text-end"><?php echo $LNG->STATS_GLOBAL_VOTES_TOP_NODES_TOTAL_HEADING; ?></td>
							</tr>
						</thead>
						<tbody>
							<?php
								$count = count($topVoters);
								for ($i = 0; $i < $count; $i++) {
									$n = $topVoters[$i]; ?>
									<tr>
										<td><a href="<?php echo $CFG->homeAddress;?>user.php?id=<?php echo $n['UserID']; ?>" target="_blank"><?php echo $n['Name']; ?></a></td>
										<td class="text-end" style="color: green"><?php echo $n['up'] ?></span></td>
										<td class="text-end" style="color: red"><?php echo $n['down'] ?></span></td>
										<td class="text-end fw-bold"><?php echo $n['vote'] ?></td>
									</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
				<div class="col-3">
					<h3 style="color: green">
						<?php echo $LNG->STATS_GLOBAL_VOTES_TOP_VOTERS_FOR; ?>
						<a title="<?php echo $LNG->BACKTOTOP; ?>" href="#top" class="ms-2 backtotop">[<?php echo $LNG->BACKTOTOP; ?>]</a>
					</h3>
					<table class="table table-sm table-striped">
						<tr class="challengeback fw-bold align-middle text-white">
							<td width="55%"><?php echo $LNG->STATS_GLOBAL_VOTES_TOP_NODES_TITLE_HEADING; ?></td>
							<td class="text-end" width="10%"><?php echo $LNG->STATS_GLOBAL_VOTES_TOP_NODES_TOTAL_HEADING; ?></td>
						</tr>
						<?php
							$count = count($topVotersFor);
							for ($i = 0; $i < $count; $i++) {
								$n = $topVotersFor[$i];
								$title = $n['Name'];
								?>
								<tr>
									<td><a href="<?php echo $CFG->homeAddress;?>user.php?id=<?php echo $n['UserID']; ?>" target="_blank"><?php echo $title ?></a></td>
									<td class="text-end"><b style="color: green"><?php echo $n['vote'] ?></td>
								</tr>
						<?php } ?>
					</table>
				</div>
				<div class="col-3">
					<h3 style="color: red">
						<?php echo $LNG->STATS_GLOBAL_VOTES_TOP_VOTERS_AGAINST; ?>
						<a title="<?php echo $LNG->BACKTOTOP; ?>" href="#top" class="ms-2 backtotop">[<?php echo $LNG->BACKTOTOP; ?>]</a>
					</h3>
					<table class="table table-sm table-striped">
						<tr class="challengeback fw-bold align-middle text-white">
							<td align="left" width="55%"><?php echo $LNG->STATS_GLOBAL_VOTES_TOP_NODES_TITLE_HEADING; ?></td>
							<td class="text-end" width="10%"><?php echo $LNG->STATS_GLOBAL_VOTES_TOP_NODES_TOTAL_HEADING; ?></td>
						</tr>
						<?php
							$count = count($topVotersAgainst);
							for ($i = 0; $i < $count; $i++) {
								$n = $topVotersAgainst[$i];
								$title = $n['Name'];
								?>
								<tr>
									<td><a href="<?php echo $CFG->homeAddress;?>user.php?id=<?php echo $n['UserID']; ?>" target="_blank"><?php echo $title ?></a></td>
									<td class="text-end"><b style="color: red"><?php echo $n['vote'] ?></td>
								</tr>
						<?php } ?>
					</table>
				</div>
			</div>

			<div class="my-3">
				<a name="allvotes"></a>
				<h3>
					<?php echo $LNG->STATS_GLOBAL_VOTES_ALL_VOTING_TITLE; ?>
					<a title="<?php echo $LNG->BACKTOTOP; ?>" href="#top" class="ms-2 backtotop">[<?php echo $LNG->BACKTOTOP; ?>]</a>
				</h3>				
				<div class="adminTableDiv">						
					<table class="table table-sm table-striped table-hover compact dataTable" id="adminTableDiv">
						<thead class="table-secondary">
							<tr class="align-middle">
								<th><?= $LNG->STATS_GLOBAL_VOTES_TOP_NODES_CATEGORY_HEADING ?></th>
								<th style="max-width: 700px;"><?= $LNG->STATS_GLOBAL_VOTES_TOP_NODES_TITLE_HEADING ?></th>
								<th class="text-end"><?= $LNG->STATS_GLOBAL_VOTES_ITEM_FOR_HEADING ?></th>
								<th class="text-end"><?= $LNG->STATS_GLOBAL_VOTES_ITEM_AGAINST_HEADING ?></th>
								<th class="text-end"><?= $LNG->STATS_GLOBAL_VOTES_CONN_FOR_HEADING ?></th>
								<th class="text-end"><?= $LNG->STATS_GLOBAL_VOTES_CONN_AGAINST_HEADING ?></th>
								<th class="text-end"><?= $LNG->STATS_GLOBAL_VOTES_TOP_NODES_TOTAL_HEADING ?></th>
							</tr>
						</thead>
						<tbody>
							<?php
								$count = $allNodeVotes->count;
								for ($i = 0; $i < $count; $i++) {
									$n = $allNodeVotes->nodes[$i];
									$nodetype = $n->role->name;
									$title = $n->name;
									if (in_array($nodetype, $CFG->RESOURCE_TYPES)) {
										$title = $n->description;
									}
									?>
									<tr>
										<td><?php echo getNodeTypeText($nodetype, false); ?></td>
										<td><a href="<?php echo $CFG->homeAddress;?>explore.php?id=<?php echo $n->nodeid; ?>" target="_blank"><?php echo $title ?></a></td>
										<td class="text-end"><span style="color: green"><?php echo $n->up ?></span></td>
										<td class="text-end"><span style="color: red"><?php echo $n->down ?></span></td>
										<td class="text-end"><span style="color: green"><?php echo $n->cup ?></span></td>
										<td class="text-end"><span style="color: red"><?php echo $n->cdown ?></span></td>
										<td class="text-end"><?php echo $n->vote ?></td>
									</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
	jQuery.noConflict();
	jQuery(document).ready(function($) {
		$('#adminTableDiv').DataTable({
			"autoWidth": true,
			"responsive": true,
			"pageLength": 25,
        	"lengthMenu": [[25, 50, 100, -1], [25, 50, 100, "All"]],
			// "order": [[6, "desc"]]
		});
	});
</script>

<?php
	include_once($HUB_FLM->getCodeDirPath("ui/footerstats.php"));
?>
