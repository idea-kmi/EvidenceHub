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
	include_once("../../config.php");

	global $CFG, $DB;

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

	$sort = optional_param("sort","date",PARAM_ALPHANUM);
	$oldsort = optional_param("lastsort","date",PARAM_ALPHANUM);
	$direction = optional_param("lastdir","ASC",PARAM_ALPHANUM);

	$params = array();

?>

<script type="text/javascript">

	var context = '<?php echo $CFG->GLOBAL_CONTEXT; ?>';

	function init() {
		$("tab-connections-overview").innerHTML = "";

		var nextrow = new Element("div", {'class':'d-flex flex-wrap gap-3 justify-content-start'});

		if (hasChallenge) {
			//CHALLENGES
			var connectedchallenges = new Element("div", {'class':''});
			var set = overviewNodeWidget(context, '<?php echo $LNG->OVERVIEW_CHALLENGE_MOSTCONNECTED_TITLE; ?>', "Challenge", 'connectedness', 'DESC', '5', 350, 190, '<?php echo $LNG->OVERVIEW_BUTTON_EXPLOREALL; ?>', 'challenge', '<?php echo $LNG->CHALLENGES_NAME; ?>', 'mostconnected');
			connectedchallenges.insert(set);
			nextrow.insert(connectedchallenges);
		}

		// ISSUES
		var connectedissues = new Element("div", {'class':''});
		var set = overviewNodeWidget(context, '<?php echo $LNG->OVERVIEW_ISSUE_MOSTCONNECTED_TITLE; ?>', "Issue", 'connectedness', 'DESC', '5', 350, 190, '<?php echo $LNG->OVERVIEW_BUTTON_EXPLOREALL; ?>', 'issue', '<?php echo $LNG->ISSUES_NAME; ?>', 'mostconnected');
		connectedissues.insert(set);
		nextrow.insert(connectedissues);

		if (hasSolution) {
			// SOLUTIONS
			var connectedsolutions = new Element("div", {'class':''});
			var set = overviewNodeWidget(context, '<?php echo $LNG->OVERVIEW_SOLUTION_MOSTCONNECTED_TITLE; ?>', "Solution", 'connectedness', 'DESC', '5', 350, 190, '<?php echo $LNG->OVERVIEW_BUTTON_EXPLOREALL; ?>', 'solution', '<?php echo $LNG->SOLUTIONS_NAME; ?>', 'mostconnected');
			connectedsolutions.insert(set);
			nextrow.insert(connectedsolutions);
		}

		// CLAIMS
		if (hasClaim) {
			var connectedclaims = new Element("div", {'class':''});
			var set = overviewNodeWidget(context, '<?php echo $LNG->OVERVIEW_CLAIM_MOSTCONNECTED_TITLE; ?>', "Claim", 'connectedness', 'DESC', '5', 350, 190, '<?php echo $LNG->OVERVIEW_BUTTON_EXPLOREALL; ?>', 'claim', '<?php echo $LNG->CLAIMS_NAME; ?>', 'mostconnected');
			connectedclaims.insert(set);
			nextrow.insert(connectedclaims);
		}

		// EVIDENCE
		var connectedevidence = new Element("div", {'class':''});
		var set = overviewNodeWidget(context, '<?php echo $LNG->OVERVIEW_EVIDENCE_MOSTCONNECTED_TITLE; ?>', EVIDENCE_TYPES_STR, 'connectedness', 'DESC', '5', 350, 190, '<?php echo $LNG->OVERVIEW_BUTTON_EXPLOREALL; ?>', 'evidence', '<?php echo $LNG->EVIDENCES_NAME; ?>', 'mostconnected');
		connectedevidence.insert(set);
		nextrow.insert(connectedevidence);

		// RESOURCE
		var connectedresource = new Element("div", {'class':''});
		var set = overviewNodeWidget(context, '<?php echo $LNG->OVERVIEW_RESOURCE_MOSTCONNECTED_TITLE; ?>', RESOURCE_TYPES_STR, 'connectedness', 'DESC', '5', 350, 190, '<?php echo $LNG->OVERVIEW_BUTTON_EXPLOREALL; ?>', 'web', '<?php echo $LNG->RESOURCES_NAME; ?>', 'mostconnected');
		connectedresource.insert(set);
		nextrow.insert(connectedresource);

		// PROJECT
		var connectedprojects = new Element("div", {'class':''});
		var set2 = overviewNodeWidget(context, '<?php echo $LNG->OVERVIEW_PROJECT_MOSTCONNECTED_TITLE; ?>', "Project", 'connectedness', 'DESC', '5', 350, 190, '<?php echo $LNG->OVERVIEW_BUTTON_EXPLOREALL; ?>', 'project', '<?php echo $LNG->PROJECTS_NAME; ?>','connectedprojects', 'Project');
		connectedprojects.insert(set2);
		nextrow.insert(connectedprojects);

		// ORG
		var connectedorgs = new Element("div", {'class':''});
		var set = overviewNodeWidget(context, '<?php echo $LNG->OVERVIEW_ORG_MOSTCONNECTED_TITLE; ?>', "Organization", 'connectedness', 'DESC', '5', 350, 190, '<?php echo $LNG->OVERVIEW_BUTTON_EXPLOREALL; ?>', 'org', '<?php echo $LNG->ORGS_NAME; ?>', 'connectorg', 'Organization');
		connectedorgs.insert(set);
		nextrow.insert(connectedorgs);


		$("tab-connections-overview").insert( nextrow );
	}

	function overviewNodeWidget(context, title, filternodetypes, orderby, sort, count, width, height, buttontitle, key, hinttype, uniqueid, filtertype) {

		if (uniqueid == undefined) {
			uniqueid = 'something';
		}

		var set = new Element("fieldset", {'class':'overviewfieldset', 'style':'width: '+width+'px;'});
		var legend = new Element("legend", {'class':'overviewlegend widgettextcolor'});
		legend.insert(title);
		set.insert(legend);
		var main = new Element("div", {'style':'height: '+height+'px; overflow-y: auto; overflow-x: hidden;padding-right:5px;'});
		main.insert(getLoading("(<?php echo $LNG->WIDGET_LOADING; ?> "+title+"...)"));
		set.insert(main);

		var args = new Object();
		args['filternodetypes'] = filternodetypes;
		args["start"] = 0;
		args["max"] = count;
		args["orderby"] = orderby;
		args["sort"] = sort;

		var reqUrl = SERVICE_ROOT + "&method=getnodesby" + context + "&" + Object.toQueryString(args);

		new Ajax.Request(reqUrl, { method:'get',
			onSuccess: function(transport){
				try {
					var json = transport.responseText.evalJSON();
					if(json.error){
						alert(json.error[0].message);
						return;
					}
				} catch(err) {
					console.log(err);
				}

				if(json.nodeset[0].count != 0){
					var nodes = json.nodeset[0].nodes;

					main.innerHTML="";
					displayConnectionStatNodes(main,nodes,parseInt(args['start'])+1, true, uniqueid);
				} else {
					main.innerHTML="";
					main.insert("<?php echo $LNG->WIDGET_NO_RESULTS_FOUND; ?>");
				}
			}
		});

		if (buttontitle && buttontitle != "") {
			var allbutton = new Element("a", {'href':'#'+key+'-list', 'class':'active', 'title':'<?php echo $LNG->WIDGET_CLICK_EXPLORE_HINT; ?> '+hinttype, 'style':'clear: both; float:right; font-weight:bold; margin: 5px;margin-top:0px;'});
			allbutton.insert(buttontitle);
			Event.observe(allbutton,'click',function() {

				window.location.href = "<?php echo $CFG->homeAddress; ?>"+"#"+key;
			});
			set.insert(allbutton);
		}

		return set;
	}

	window.onload = init;

</script>

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
			<div class="col-12">
				<div id="tab-connections-overview" class="tabcontentinner"></div>

				<?php
					$err = "";
					if( !$DB->conn ) {
						$err = $DB->conn->connect_error;
					} else {
						$qry = " SELECT
							(SELECT Node.Name FROM Node WHERE NodeID = Triple.ToID) AS ToName,
							(SELECT NodeType.Name FROM NodeType WHERE NodeTypeID = Triple.ToContextTypeID) AS ToType,
							(SELECT Users.Name FROM Node LEFT JOIN Users ON Node.UserID = Users.UserID WHERE NodeID = Triple.ToID ) AS ToAuthor,
							(SELECT Node.Name FROM Node WHERE NodeID = Triple.FromID) AS FromName,
							(SELECT NodeType.Name FROM NodeType WHERE NodeTypeID = Triple.FromContextTypeID) AS FromType,
							(SELECT Users.Name FROM Node LEFT JOIN Users ON Node.UserID = Users.UserID WHERE NodeID = Triple.FromID ) AS FromAuthor,
							LinkType.Label AS LinkLabel,
							Triple.CreationDate,
							Users.Name AS ConnectionAuthor FROM Triple
							LEFT JOIN Users ON Triple.UserID = Users.UserID
							LEFT JOIN LinkType ON Triple.LinkTypeID = LinkType.LinkTypeID
							WHERE LinkType.Label <> '".$CFG->LINK_NODE_THEME."'";

							$qry .= ' order by Triple.CreationDate DESC';
							$sort='date';
							$direction='DESC';
					}
				?>

				<div class="adminTableDiv my-5">			
					<table class="table table-sm table-striped table-hover compact dataTable" id="adminTableDiv">
						<thead class="table-light">
							<tr class="align-middle">
								<th style="min-width: 200px;">Connection Author</th>
								<th style="min-width: 100px;">Date</th>
								<th style="max-width: 500px;">From Idea</th>
								<th>From Type</th>
								<th style="min-width: 200px;">From Idea Author</th>
								<th>Link Type</th>
								<th style="max-width: 500px;">To Idea</th>
								<th>To Type</th>
								<th style="min-width: 200px;">To Idea Author</th>
							</tr>
						</thead>
						<tbody>
							<?php
								$resArray = $DB->select($qry, $params);
								if ($resArray !== false && is_countable($resArray)) {
									$count = count($resArray);
									for ($i = 0; $i < $count; $i++) {
										$array = $resArray[$i];
										$date = $array['CreationDate'];
										$prettydate = date( 'd M Y', $date); 
									?>

										<tr>
											<td valign="top">
												<?php echo $array['ConnectionAuthor']; ?>
											</td>
											<td valign="top" data-search="<?= $prettydate ?>" data-order="<?= $date ?>">
												<?= $prettydate ?>
											</td>
											<td valign="top">
												<?php echo $array['FromName']; ?>
											</td>
											<td valign="top">
												<?php echo getNodeTypeText($array['FromType'], false); ?>
											</td>
											<td valign="top">
												<?php echo $array['FromAuthor']; ?>
											</td>
											<td valign="top">
												<?php echo $array['LinkLabel']; ?>
											</td>
											<td valign="top">
												<?php echo $array['ToName']; ?>
											</td>
											<td valign="top">
												<?php echo getNodeTypeText($array['ToType'], false); ?>
											</td>
											<td valign="top">
												<?php echo $array['ToAuthor']; ?>
											</td>
										</tr>
									<?php }
								}
							?>
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
			"columnDefs": [
				{ "orderable": false, "targets": 0 }
			],
			"order": [[5, "desc"]]
		});
	});
</script>

<?php
	include_once($HUB_FLM->getCodeDirPath("ui/footerstats.php"));
?>