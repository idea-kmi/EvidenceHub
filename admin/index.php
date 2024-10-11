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
    include_once("../config.php");

    $me = substr($_SERVER["PHP_SELF"], 1); // remove initial '/'
    if ($HUB_FLM->hasCustomVersion($me)) {
    	$path = $HUB_FLM->getCodeDirPath($me);
    	include_once($path);
		die;
	}

	checkLogin();

    include_once($HUB_FLM->getCodeDirPath("ui/headeradmin.php"));

    if($USER == null || $USER->getIsAdmin() == "N"){
        //reject user
        echo $LNG->ADMIN_NOT_ADMINISTRATOR_MESSAGE;
        include_once($HUB_FLM->getCodeDirPath("ui/footeradmin.php"));
        die;
    }

	$registeredUsers = getRegisteredUsers($direction, $sort, $oldsort);
	$countUsers = 0;
	if (is_countable($registeredUsers)) {
		$countUsers = count($registeredUsers);
	}

	// Item created counts
	$grandtotal1 = 0;
	$categoryArray = array();

	if ($CFG->HAS_CHALLENGE) {
		$count = getNodeCreationCount("Challenge",$startdate);
		$categoryArray[$LNG->CHALLENGES_NAME] = $count;
		$grandtotal1 += $count;
	}

	$count = getNodeCreationCount("Issue",$startdate);
	$categoryArray[$LNG->ISSUES_NAME] = $count;
	$grandtotal1 += $count;

	if ($CFG->HAS_SOLUTION) {
		$count = getNodeCreationCount("Solution",$startdate);
		$categoryArray[$LNG->SOLUTION_NAME] = $count;
		$grandtotal1 += $count;
	}

	if ($CFG->HAS_CLAIM) {
		$count = getNodeCreationCount("Claim",$startdate);
		$categoryArray[$LNG->CLAIMS_NAME] = $count;
		$grandtotal1 += $count;
	}

	$evidencetypes = "";
	$count = count($CFG->EVIDENCE_TYPES);
	for($i = 0; $i < $count; $i++){
		if ($i == 0) {
			$evidencetypes .= $CFG->EVIDENCE_TYPES[$i];
		} else {
			$evidencetypes .= ",".$CFG->EVIDENCE_TYPES[$i];
		}
	}

	$count = getNodeCreationCount($evidencetypes,$startdate);
	$categoryArray[$LNG->EVIDENCES_NAME] = $count;
	$grandtotal1 += $count;

	$resourcetypes = "";
	$count = count($CFG->RESOURCE_TYPES);
	for($i=0; $i < $count; $i++){
		if ($i == 0) {
			$resourcetypes .= $CFG->RESOURCE_TYPES[$i];
		} else {
			$resourcetypes .= ",".$CFG->RESOURCE_TYPES[$i];
		}
	}
	$count = getNodeCreationCount($resourcetypes,$startdate);
	$categoryArray[$LNG->RESOURCES_NAME] = $count;
	$grandtotal1 += $count;

	$count = getNodeCreationCount("Organization",$startdate);
	$categoryArray[$LNG->ORGS_NAME] = $count;
	$grandtotal1 += $count;

	$count = getNodeCreationCount("Project",$startdate);
	$categoryArray[$LNG->PROJECTS_NAME] = $count;
	$grandtotal1 += $count;

	if ($CFG->HAS_OPEN_COMMENTS) {
		$count = getNodeCreationCount("Idea",$startdate);
		$categoryArray[$LNG->COMMENT_NAME] = $count;
		$grandtotal1 += $count;
	}
?>

<div class="container-fluid admin-index">
	<div class="row p-4 pt-0">
		<div class="col">

			<h1 class="mb-3"><?php echo $LNG->ADMIN_TITLE; ?></h1>

			<div class="d-flex">
				<div class="w-100 p-4 ps-0">

					<div class="row mb-3">
						<!-- Card -->
						<div class="col-xl-2 col-md-6 mb-4">
							<div class="card border-0 border-start border-primary shadow h-100 py-2">
								<div class="card-body">
									<a href="<?= $CFG->homeAddress ?>admin/userslist.php">
										<div class="row no-gutters align-items-center">
											<div class="col mr-2">
												<div class="text-xs fw-bold text-primary text-uppercase mb-1"><?= $LNG->USERS_NAME ?></div>
												<div class="h5 mb-0 fw-bold text-gray-800"><?= $countUsers ?></div>
											</div>
											<div class="col-auto">
												<i class="fas fa-user fa-2x text-gray-300"></i>
											</div>
										</div>
									</a>
								</div>
							</div>
						</div>
					</div>

					<div class="row mb-3">
						<h3 class="mb-3 d-flex align-items-center gap-3">
							<?php echo $LNG->STATS_GLOBAL_TAB_IDEAS; ?>
							<span class="badge rounded-pill" style="background-color: #4E725F; font-size: 0.7em;"><?=$grandtotal1?></span>
						</h3>
						
						<?php foreach( $categoryArray as $key => $value) { ?>
							
							<!-- Card -->
							<div class="col-xl-2 col-md-6 mb-4">
								<div class="card border-0 border-start border-success shadow h-100 py-2">
									<div class="card-body">
										<div class="row no-gutters align-items-center">
											<div class="col mr-2">
												<div class="text-xs fw-bold text-success text-uppercase mb-1" style="font-size: 0.9em;"><?= $key ?></div>
												<div class="h5 mb-0 fw-bold text-gray-800"><?=  $value ?></div>
											</div>
											<div class="col-auto">
												<img src="<?= $next[2] ?>" alt="" />
											</div>
										</div>
									</div>
								</div>
							</div>
						<?php } ?>
					</div>
				</div>
			</div>

		</div>
	</div>
</div>

<?php
	include_once($HUB_FLM->getCodeDirPath("ui/footeradmin.php"));
?>

