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

require_once('../core/utillib.php'); // adjust path as required to where you place this file.

echo "<center><h1>Load default data</h1></center>";

//The directory address of the webcode on the server and then the current sites uploads folder.
// It must end in a slash please.
// It is used to put/pull the user picture of the admin user in the relevant 'uploads folder'
// e.g. <server path to litemap webcode>/sites/default/uploads/
// NOTE: if you are running mutliple LiteMap instances this will be:
// e.g. <server path to litemap webcode>/sites/multi/<domain folder>/uploads/

$dirAddressUploads = '';

$databaseaddress = 'localhost'; // mostlty this will be 'localhost' depending where your database is.
$databaseuser = '';
$databasepass = '';
$databasename = '';

/// The following user emails will not be validated as they are system user accounts
/// So they can be made up or real.

// Default user
$email = '';
$password = '';
$fullname = 'Default';
$description = 'Default template user whose link and node types are copied to all new users';

// Theme user
$email2 = '';
$password2 = '';
$fullname2 = 'System Admin';
$description2 = 'This account manages the Themes and other system related items.';


$DB = new stdClass();
$DB->conn = new mysqli($databaseaddress, $databaseuser, $databasepass, $databasename);
if($DB->conn->connect_errno > 0){
	 error_log("Errno: " . $DB->conn->connect_errno);
	 error_log("Error: " . $DB->conn->connect_error);
	 die("Error Connecting to Database");
}

// Check if Users table empty. Good indication that they have not run this script yet.
$query = "SELECT * FROM Users";

$results = $DB->conn->query($query);
$resultArray = array();
while ($row = $results->fetch_assoc()) {
	array_push($resultArray, $row);
}

if (count($resultArray) > 0) {
	echo "ERROR: Your database does not appear to be empty. <br>
	The default data should only be loaded once into an empty database.<br>
	<br>Please make sure all your database tables are empty and try again.";
} else {
	/** CREATE DEFAULT USER **/

	$userid = getUniqueID();
	$photo = 'profile.png';
	$dt = time();

	$qry = "INSERT INTO Users (
			UserID,
			CreationDate,
			ModificationDate,
			Email,
			Name,
			Password,
			Website,
			Private,
			LastLogin,
			IsAdministrator,
			IsGroup,
			Description,
			Photo,
			RegistrationKey,
			ValidationKey)
		VALUES (
			'".$userid."',
			".$dt.",
			".$dt.",
			'".$DB->conn->real_escape_string($email)."',
			'".$DB->conn->real_escape_string($fullname)."',
			'".$DB->conn->real_escape_string(password_hash($password, PASSWORD_BCRYPT))."',
			'',
			'N',
			". $dt .",
			'Y',
			'N',
			'".$DB->conn->real_escape_string($description)."',
			'".$DB->conn->real_escape_string($photo)."',
			". $dt .",
			". $dt .")";

    $res = $DB->conn->query($qry);
	if( !$res ) {
		echo "error adding default user.<br/>";
	} else {
		/*** LOAD DEFAULT DATA  ***/
		// (this will go under the default template user's account. Node and link types will be copied to each new user created.
		// So before any new user's are added to the system, make sure you are happy with the default EVIDENCE and REOUSRCE types (see further down).

		$mysqli = new mysqli($databaseaddress, $databaseuser, $databasepass, $databasename);
		/* check connection */
		if (mysqli_connect_errno()) {
			echo "Failed to create multi-connection to: ".mysqli_connect_error()."<br/>";
			exit();
		}

		/*
		Table data for LinkType
		*/

		$hasmaintheme =  getUniqueID();
		$partneredwith = getUniqueID();
		$specifies = getUniqueID();
		$isrelatedtoid = getUniqueID();
		$addresses = getUniqueID();
		$claims = getUniqueID();
		$manages = getUniqueID();
		$seealsoid = getUniqueID();
		$builtfromid = getUniqueID();
		$supportsid = getUniqueID();
		$challengesid = getUniqueID();
		$respondstoid = getUniqueID();

		$qry = "INSERT INTO `LinkType` VALUES ('".$hasmaintheme."','".$userid."','#000000',NULL,NULL,'has main theme',0);";
		$qry .= "INSERT INTO `LinkType` VALUES ('".$partneredwith."','".$userid."','#000000',NULL,NULL,'partnered with',0);";
		$qry .= "INSERT INTO `LinkType` VALUES ('".$specifies."','".$userid."','#000000',NULL,NULL,'specifies',0);";
		$qry .= "INSERT INTO `LinkType` VALUES ('".$isrelatedtoid."','".$userid."','#000000',NULL,NULL,'is related to',0);";
		$qry .= "INSERT INTO `LinkType` VALUES ('".$addresses."','".$userid."','#000000',NULL,NULL,'addresses',0);";
		$qry .= "INSERT INTO `LinkType` VALUES ('".$claims."','".$userid."','#000000',NULL,NULL,'claims',0);";
		$qry .= "INSERT INTO `LinkType` VALUES ('".$manages."','".$userid."','#000000',NULL,NULL,'manages',0);";
		$qry .= "INSERT INTO `LinkType` VALUES ('".$seealsoid."','".$userid."','#000000',NULL,NULL,'see also',0);";
		$qry .= "INSERT INTO `LinkType` VALUES ('".$builtfromid."','".$userid."','#000000',NULL,NULL,'built from',0);";
		$qry .= "INSERT INTO `LinkType` VALUES ('".$supportsid."','".$userid."','#000000',NULL,NULL,'supports',0);";
		$qry .= "INSERT INTO `LinkType` VALUES ('".$respondstoid."','".$userid."','#000000',NULL,NULL,'responds to',0);";
		$qry .= "INSERT INTO `LinkType` VALUES ('".$challengesid."','".$userid."','#000000',NULL,NULL,'challenges',0);";

		if (!$mysqli->multi_query($qry)) {
			if ($mysqli->errno) {
				echo "Error adding link types: ".$mysqli->error."<br/>";
			}
		} else {
			while ($mysqli->next_result()) {;}

			/*
			Table data for LinkTypeGroup
			*/

			$positiveid = getUniqueID();
			$negativeid = getUniqueID();
			$neutralid = getUniqueID();

			$qry = "INSERT INTO `LinkTypeGroup` VALUES ('".$positiveid."','".$userid."','Positive',0);";
			$qry .= "INSERT INTO `LinkTypeGroup` VALUES ('".$negativeid."','".$userid."','Negative',0);";
			$qry .= "INSERT INTO `LinkTypeGroup` VALUES ('".$neutralid."','".$userid."','Neutral',0);";
			if (!$mysqli->multi_query($qry)) {
				if ($mysqli->errno) {
					echo "Error adding link groups: ".$mysqli->error."<br/>";
				}
			} else {
				while ($mysqli->next_result()) {;}

				/*
				Table data for LinkTypeGrouping
				*/

				$qry = "INSERT INTO `LinkTypeGrouping` VALUES ('".$positiveid."','".$supportsid."','".$userid."',0);";
				$qry .= "INSERT INTO `LinkTypeGrouping` VALUES ('".$negativeid."','".$challengesid."','".$userid."',0);";
				$qry .= "INSERT INTO `LinkTypeGrouping` VALUES ('".$neutralid."','".$hasmaintheme."','".$userid."',0);";
				$qry .= "INSERT INTO `LinkTypeGrouping` VALUES ('".$neutralid."','".$partneredwith."','".$userid."',0);";
				$qry .= "INSERT INTO `LinkTypeGrouping` VALUES ('".$neutralid."','".$specifies."','".$userid."',0);";
				$qry .= "INSERT INTO `LinkTypeGrouping` VALUES ('".$neutralid."','".$isrelatedtoid."','".$userid."',0);";
				$qry .= "INSERT INTO `LinkTypeGrouping` VALUES ('".$neutralid."','".$addresses."','".$userid."',0);";
				$qry .= "INSERT INTO `LinkTypeGrouping` VALUES ('".$neutralid."','".$claims."','".$userid."',0);";
				$qry .= "INSERT INTO `LinkTypeGrouping` VALUES ('".$neutralid."','".$manages."','".$userid."',0);";
				$qry .= "INSERT INTO `LinkTypeGrouping` VALUES ('".$neutralid."','".$seealsoid."','".$userid."',0);";
				$qry .= "INSERT INTO `LinkTypeGrouping` VALUES ('".$neutralid."','".$builtfromid."','".$userid."',0);";
				$qry .= "INSERT INTO `LinkTypeGrouping` VALUES ('".$neutralid."','".$respondstoid."','".$userid."',0);";
				if (!$mysqli->multi_query($qry)) {
					if ($mysqli->errno) {
						echo "Error adding linktypes into groups: ".$mysqli->error."<br/>";
					}
				} else {
					while ($mysqli->next_result()) {;}

					/**
					 * Table data for NodeType
					 */
					$newsid = getUniqueID();
					$challengeid = getUniqueID();
					$commentid = getUniqueID();
					$solutionid = getUniqueID();
					$issueid = getUniqueID();
					$proid = getUniqueID();
					$conid = getUniqueID();
					$ideaid = getUniqueID();
					$themeid = getUniqueID();
					$orgid = getUniqueID();
					$claimid = getUniqueID();
					$projectid = getUniqueID();
					$questionid = getUniqueID();

					/* These are core datamodel types and are required by the system */
					$qry = "INSERT INTO `NodeType` VALUES ('".$newsid."','".$userid."','News',0,'nodetypes/Default/news.png');";
					$qry .= "INSERT INTO `NodeType` VALUES ('".$challengeid."','".$userid."','Challenge',0,'nodetypes/Default/challenge.png');";
					$qry .= "INSERT INTO `NodeType` VALUES ('".$commentid."','".$userid."','Comment',0,'nodetypes/Default/comment.png');";
					$qry .= "INSERT INTO `NodeType` VALUES ('".$solutionid."','".$userid."','Solution',0,'nodetypes/Default/solution.png');";
					$qry .= "INSERT INTO `NodeType` VALUES ('".$issueid."','".$userid."','Issue',0,'nodetypes/Default/issue.png');";
					$qry .= "INSERT INTO `NodeType` VALUES ('".$proid."','".$userid."','Pro',0,'nodetypes/Default/plus-32x32.png');";
					$qry .= "INSERT INTO `NodeType` VALUES ('".$conid."','".$userid."','Con',0,'nodetypes/Default/minus-32x32.png');";
					$qry .= "INSERT INTO `NodeType` VALUES ('".$ideaid."','".$userid."','Idea',0,'nodetypes/Default/idea.png');";
					$qry .= "INSERT INTO `NodeType` VALUES ('".$themeid."','".$userid."','Theme',0,'nodetypes/Default/theme.png');";
					$qry .= "INSERT INTO `NodeType` VALUES ('".$orgid."','".$userid."','Organization',0,'nodetypes/Default/organization.png');";
					$qry .= "INSERT INTO `NodeType` VALUES ('".$claimid."','".$userid."','Claim',0,'nodetypes/Default/claim.png');";
					$qry .= "INSERT INTO `NodeType` VALUES ('".$projectid."','".$userid."','Project',0,'nodetypes/Default/project.png');";
					$qry .= "INSERT INTO `NodeType` VALUES ('".$questionid."','".$userid."','Question',0,'nodetypes/Default/question.png');";
					if (!$mysqli->multi_query($qry)) {
						if ($mysqli->errno) {
							echo "Error adding base nodetypes: ".$mysqli->error."<br/>";
						}
					} else {
						while ($mysqli->next_result()) {;}

						/**
						 * Resource Types
						 * These two are default Resource Types. Please leave these. But you can add more if you like, just remember to update the config file.
						 */
						$resourceid = getUniqueID();
						$publicationid = getUniqueID();

						$qry = "INSERT INTO `NodeType` VALUES ('".$resourceid."','".$userid."','Web Resource',0,'nodetypes/Default/reference-32x32.png');";
						$qry .= "INSERT INTO `NodeType` VALUES ('".$publicationid."','".$userid."','Publication',0,'nodetypes/Default/publication.png');";
						if (!$mysqli->multi_query($qry)) {
							if ($mysqli->errno) {
								echo "Error adding resource node types: ".$mysqli->error."<br/>";
							}
						} else {
							while ($mysqli->next_result()) {;}

							/**
							 * Evidence Types
							 * Here are some suggested Evidece Types.
							 * You can change them, extend them etc. You can change the icons and each could have their own. Check out icons in /images/nodetypes/Default/
							 */
							$anecdoteid = getUniqueID();
							$casestudy = getUniqueID();
							$policyid = getUniqueID();
							$researchid = getUniqueID();
							$reportid = getUniqueID();

							$qry = "INSERT INTO `NodeType` VALUES ('".$anecdoteid."','".$userid."','Anecdote',0,'nodetypes/Default/litertaure-alaysis.png');";
							$qry .= "INSERT INTO `NodeType` VALUES ('".$casestudy."','".$userid."','Case Study',0,'nodetypes/Default/litertaure-alaysis.png');";
							$qry .= "INSERT INTO `NodeType` VALUES ('".$policyid."','".$userid."','Policy',0,'nodetypes/Default/litertaure-alaysis.png');";
							$qry .= "INSERT INTO `NodeType` VALUES ('".$researchid."','".$userid."','Research Finding',0,'nodetypes/Default/litertaure-alaysis.png');";
							$qry .= "INSERT INTO `NodeType` VALUES ('".$reportid."','".$userid."','Report',0,'nodetypes/Default/litertaure-alaysis.png');";

							/**
							 * To add another Evidence Type, remove the 2 slashes from infront of the lines below.
							 * and replace the parts in capitals with the new Evidence Type name and it's icon filename.
							 * If necessary duplicate the two lines to add more evidence types. Change the id to $nextID2 etc.. so they can be used again later.
							 * you will also need to uncomment and complete the lines further down for adding the node to groups
							 *
							 */
							//$nextID1 = getUniqueID();
							//$qry .= "INSERT INTO `NodeType` VALUES ("'.<$next UniqueID>."','".$userid."','NAME OF NEW EVIDENCE TYPE',0,'nodetypes/Default/NEW IMAGE FILENAME');";


							if (!$mysqli->multi_query($qry)) {
								if ($mysqli->errno) {
									echo "Error adding evidence node types: ".$mysqli->error."<br/>";
								}
							} else {
								while ($mysqli->next_result()) {;}

								/*
								Table data for NodeTypeGroup
								*/
								$defaultrolegroup = getUniqueID();
								$evidencerolegroup = getUniqueID();
								$resourcerolegroup = getUniqueID();
								$systemtrolegroup = getUniqueID();

								$qry = "INSERT INTO `NodeTypeGroup` VALUES ('".$defaultrolegroup."','".$userid."','Default Roles',0);";
								$qry .= "INSERT INTO `NodeTypeGroup` VALUES ('".$evidencerolegroup."','".$userid."','Evidence',0);";
								$qry .= "INSERT INTO `NodeTypeGroup` VALUES ('".$resourcerolegroup."','".$userid."','Resources',0);";
								$qry .= "INSERT INTO `NodeTypeGroup` VALUES ('".$systemtrolegroup."','".$userid."','System',0);";

								if (!$mysqli->multi_query($qry)) {
									if ($mysqli->errno) {
										echo "Error adding nodetype groups: ".$mysqli->error."<br/>";
									}
								} else {
									while ($mysqli->next_result()) {;}

									/**
									 * Table data for NodeTypeGrouping
									 */

									/** Datamodel Types into the Default Roles group */
									$qry = "INSERT INTO `NodeTypeGrouping` VALUES ('".$defaultrolegroup."','".$challengeid."','".$userid."',0);";
									$qry .= "INSERT INTO `NodeTypeGrouping` VALUES ('".$defaultrolegroup."','".$commentid."','".$userid."',0);";
									$qry .= "INSERT INTO `NodeTypeGrouping` VALUES ('".$defaultrolegroup."','".$solutionid."','".$userid."',0);";
									$qry .= "INSERT INTO `NodeTypeGrouping` VALUES ('".$defaultrolegroup."','".$issueid."','".$userid."',0);";
									$qry .= "INSERT INTO `NodeTypeGrouping` VALUES ('".$defaultrolegroup."','".$proid."','".$userid."',0);";
									$qry .= "INSERT INTO `NodeTypeGrouping` VALUES ('".$defaultrolegroup."','".$conid."','".$userid."',0);";
									$qry .= "INSERT INTO `NodeTypeGrouping` VALUES ('".$defaultrolegroup."','".$ideaid."','".$userid."',0);";
									$qry .= "INSERT INTO `NodeTypeGrouping` VALUES ('".$defaultrolegroup."','".$themeid."','".$userid."',0);";
									$qry .= "INSERT INTO `NodeTypeGrouping` VALUES ('".$defaultrolegroup."','".$orgid."','".$userid."',0);";
									$qry .= "INSERT INTO `NodeTypeGrouping` VALUES ('".$defaultrolegroup."','".$claimid."','".$userid."',0);";
									$qry .= "INSERT INTO `NodeTypeGrouping` VALUES ('".$defaultrolegroup."','".$projectid."','".$userid."',0);";
									$qry .= "INSERT INTO `NodeTypeGrouping` VALUES ('".$defaultrolegroup."','".$questionid."','".$userid."',0);";

									/** Resource Types inot the Resources Group */
									$qry .= "INSERT INTO `NodeTypeGrouping` VALUES ('".$resourcerolegroup."','".$resourceid."','".$userid."',0);";
									$qry .= "INSERT INTO `NodeTypeGrouping` VALUES ('".$resourcerolegroup."','".$publicationid."','".$userid."',0);";

									/** Evidence Types into the Evidence Group */
									$qry .= "INSERT INTO `NodeTypeGrouping` VALUES ('".$evidencerolegroup."','".$anecdoteid."','".$userid."',0);";
									$qry .= "INSERT INTO `NodeTypeGrouping` VALUES ('".$evidencerolegroup."','".$casestudy."','".$userid."',0);";
									$qry .= "INSERT INTO `NodeTypeGrouping` VALUES ('".$evidencerolegroup."','".$policyid."','".$userid."',0);";
									$qry .= "INSERT INTO `NodeTypeGrouping` VALUES ('".$evidencerolegroup."','".$researchid."','".$userid."',0);";
									$qry .= "INSERT INTO `NodeTypeGrouping` VALUES ('".$evidencerolegroup."','".$reportid."','".$userid."',0);";

									/** News into the System Role Group */
									$qry .= "INSERT INTO `NodeTypeGrouping` VALUES ('".$systemtrolegroup."','".$newsid."','".$userid."',0);";

									/**
									 * If you have added a new Evidence Type above, please remove the 2 slashes from infront of the line below.
									 * If you have added more than one, copy the line below and edit the $nextID1 to $nextID2 etc..
									 */
									//$qry .= "INSERT INTO `NodeTypeGrouping` VALUES ('".$defaultrolegroup."','".<$next UniqueID>."','".$userid."',0);";


									if (!$mysqli->multi_query($qry)) {
										if ($mysqli->errno) {
											echo "Error adding nodetypes into nodetype groups: ".$mysqli->error."<br>";
										}
									} else {
										while ($mysqli->next_result()) {;}
										$mysqli->close();

										// add Theme System Admin user
										$userid2 = getUniqueID();
										$photo2 = 'systemadmin.png';

										$qry = "INSERT INTO Users (
												UserID,
												CreationDate,
												ModificationDate,
												Email,
												Name,
												Password,
												Website,
												Private,
												LastLogin,
												IsAdministrator,
												IsGroup,
												Description,
												Photo,
												RegistrationKey,
												ValidationKey)

											VALUES (
												'".$userid2."',
												".$dt.",
												".$dt.",
												'".$DB->conn->real_escape_string($email2)."',
												'".$DB->conn->real_escape_string($fullname2)."',
												'".$DB->conn->real_escape_string(password_hash($password2, PASSWORD_BCRYPT))."',
												'',
												'N',
												". $dt .",
												'Y',
												'N',
												'".$DB->conn->real_escape_string($description2)."',
												'".$DB->conn->real_escape_string($photo2)."',
												". $dt .",
												". $dt .")";


										$res = $DB->conn->query($qry);
										if( !$res ) {
											echo "error adding system admin user.<br>";
										} else {
											// add the default roles for System Admin user
											$sql = "INSERT INTO NodeType (NodeTypeID,UserID,Name,CreationDate,Image)
													SELECT UUID(), '".$userid2."', nt.Name, UNIX_TIMESTAMP(), nt.Image FROM NodeType nt
													WHERE nt.UserID='".$userid."'" ;

											$res = $DB->conn->query($sql);
											if (!$res){
												 echo "error adding default node type data to System Admin user.<br>";
											} else {
												//add the default groupings for these
												$sql = "INSERT INTO NodeTypeGrouping (NodeTypeGroupID, NodeTypeID, UserID, CreationDate)
														SELECT ngrp.NodeTypeGroupID, nt.NodeTypeID, nt.UserID, UNIX_TIMESTAMP() FROM NodeType nt
														INNER JOIN (SELECT ntg.NodeTypeGroupID, nt2.Name FROM NodeTypeGrouping ntg INNER JOIN NodeType nt2 ON ntg.NodeTypeID = nt2.NodeTypeID WHERE nt2.UserID='".$userid."') ngrp ON ngrp.Name = nt.Name
														WHERE nt.NodeTypeID NOT IN (SELECT NodeTypeID FROM NodeTypeGrouping)";

												$res = $DB->conn->query($sql);
												if (!$res){
													echo "error adding default node type grouping data to System Admin user.<br>";
												}
											}

											// add default link types to System Admin user
											$sql = "INSERT INTO LinkType (LinkTypeID,UserID,Label,CreationDate)
													SELECT UUID(), '".$userid2."', lt.Label, UNIX_TIMESTAMP() FROM LinkType lt
													WHERE lt.UserID='".$userid."'";


											$res = $DB->conn->query($sql);
											if (!$res){
													echo "error adding default link type data to System Admin user.<br>";
											} else {
												//add the default groupings for these
												$sql = "INSERT INTO LinkTypeGrouping (LinkTypeGroupID, LinkTypeID, UserID, CreationDate)
														SELECT lgrp.LinkTypeGroupID, lt.LinkTypeID, lt.UserID, UNIX_TIMESTAMP() FROM LinkType lt
														INNER JOIN (SELECT ltg.LinkTypeGroupID, lt2.Label FROM LinkTypeGrouping ltg INNER JOIN LinkType lt2 ON ltg.LinkTypeID = lt2.LinkTypeID WHERE lt2.UserID='".$userid."') lgrp ON lgrp.Label = lt.Label
														WHERE lt.LinkTypeID NOT IN (SELECT LinkTypeID FROM LinkTypeGrouping)";

												$res2 = $DB->conn->query($sql);
												if (!$res2){
													echo "error adding default link grouping type data to System Admin user.<br>";
												}
											}

											// add user image;
											$target_path = $dirAddressUploads.$userid2."/";
											if(!file_exists($target_path)){
												mkdir($target_path, 0777, true);
											}
											$source_file = $dirAddressUploads.$photo2;
											$target_file = $target_path.$photo2;
											if(copy($source_file, $target_file)) {
												if(resize_image($target_path,$target_path, 60)){
													$image_thumb = $target_path.str_replace('.','_thumb.',$photo2);
													resize_image($target_file, $image_thumb, 30);
												}
											}

											echo "Copy to the config the ADMIN_USERID: ".$userid2.'<br>';
											echo "Copy to the config the defaultUserID: ".$userid.'<br>';
											echo "Copy to the config the defaultRoleGroupID: ".$defaultrolegroup."<br>";
											echo "Copy to the config the evidenceRoleGroupID: ".$evidencerolegroup."<br>";
											echo "Copy to the config the resourceRoleGroupID: ".$resourcerolegroup."<br>";
											echo "Copy to the config the systemRoleGroupID: ".$systemtrolegroup."<br>";
										}
									}
								}
							}
						}
					}
				}
			}
		}
	}
}
?>
