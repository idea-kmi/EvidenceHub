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
include_once("../../config.php");
include_once($HUB_FLM->getCodeDirPath("ui/headerstats.php"));

global $CFG,$LNG;

if(!$CFG->areStatsPublic && $USER->getIsAdmin() != "Y") {
	echo "<div class='errors'>".$LNG->FORM_ERROR_NOT_ADMIN."</div>";
	include_once($HUB_FLM->getCodeDirPath("ui/dialogfooter.php"));
	die;
}

$sort = optional_param("sort","name",PARAM_ALPHANUM);
$oldsort = optional_param("lastsort","",PARAM_ALPHANUM);
$direction = optional_param("lastdir","ASC",PARAM_ALPHANUM);

$sort1 = optional_param("sort1","name",PARAM_ALPHANUM);
$oldsort1 = optional_param("lastsort1","",PARAM_ALPHANUM);
$direction1 = optional_param("lastdir1","ASC",PARAM_ALPHANUM);

$startdate = $CFG->START_DATE;

$nodetypes = "";
$count = count($CFG->BASE_TYPES);
for($i=0; $i<$count; $i++){
	if ($CFG->BASE_TYPES[$i] != "Theme") {
		if ($i == 0) {
			$nodetypes .= "'".$CFG->BASE_TYPES[$i]."'";
		} else {
			$nodetypes .= ",'".$CFG->BASE_TYPES[$i]."'";
		}
	}
}
$count = count($CFG->EVIDENCE_TYPES);
for ($i=0; $i<$count; $i++) {
	$nodetypes .= ",'".$CFG->EVIDENCE_TYPES[$i]."'";
}

$count = count($CFG->RESOURCE_TYPES);
for ($i=0; $i<$count; $i++) {
	$nodetypes .= ",'".$CFG->RESOURCE_TYPES[$i]."'";
}


/***** BY CATEGORY COUNTS *****/

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
for($i=0; $i<$count; $i++){
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
for($i=0; $i<$count; $i++){
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

if ($sort) {
	if ($direction) {
		if ($oldsort === $sort) {
			if ($direction === 'ASC') {
				$direction = "DESC";
			} else {
				$direction = "ASC";
			}
		} else {
			$direction = "ASC";
		}
	} else {
		$direction = "ASC";
	}

	if ($sort == 'name') {
		if ($direction === 'ASC') {
			ksort($categoryArray);
		} else {
			krsort($categoryArray);
		}
	} else if ($sort == 'count') {
		if ($direction === 'ASC') {
			asort($categoryArray);
		} else {
			arsort($categoryArray);
		}
	}
} else {
	ksort($categoryArray);
	$sort='name';
	$direction='ASC';
}

echo '<div style="clear: both; float: left;margin-right:50px;"><table cellpadding="3">';

echo '<tr><td align="left" valign="bottom" width="60%" class="adminTableHead"><a href="newIdeas.php?&sort=name&lastsort='.$sort.'&lastdir='.$direction.'&sort1='.$sort1.'&lastsort1='.$oldsort1.'&lastdir1='.$direction1.'">'.$LNG->STATS_GLOBAL_REGISTER_HEADER_NAME.'</b>';
if ($sort === 'name') {
	if ($direction === 'ASC') {
		echo '<img border="0" src="'.$CFG->homeAddress.'images/uparrow.gif" width="16" height="8" />';
	} else {
		echo '<img border="0" src="'.$CFG->homeAddress.'images/downarrow.gif" width="16" height="8" />';
	}
}
echo '</td>';
echo '<td align="left" valign="bottom" width="40%" class="adminTableHead"><a href="newIdeas.php?&sort=count&lastsort='.$sort.'&lastdir='.$direction.'&sort1='.$sort1.'&lastsort1='.$oldsort1.'&lastdir1='.$direction1.'">'.$LNG->STATS_GLOBAL_OVERVIEW_HEADER_COUNT.'</b>';
if ($sort === 'count') {
	if ($direction === 'ASC') {
		echo '<img border="0" src="'.$CFG->homeAddress.'images/uparrow.gif" width="16" height="8" />';
	} else {
		echo '<img border="0" src="'.$CFG->homeAddress.'images/downarrow.gif" width="16" height="8" />';
	}
}
echo '</td>';
echo "</tr>";

foreach( $categoryArray as $key => $value) {
	echo '<tr><td><span>'.$key.'</span></td><td><span> = '.$value.'</span</td></tr>';
}

echo '<tr><td colspan="2"><hr class="hrline" /></td></tr>';
echo '<tr><td><span class="hometext">'.$LNG->STATS_GLOBAL_IDEAS_TOTAL_LABEL.'</span></td><td><span class="hometext"> = '.$grandtotal1.'</span</td></tr>';
echo '</table></div>';


/***** BY THEME COUNTS *****/

echo '<div style="float: left;margin-right:20px;"><table cellpadding="3" style="width:300px;">';

$nodetypes = "";
$count = count($CFG->BASE_TYPES);
for($i=0; $i<$count; $i++){
	if ($CFG->BASE_TYPES[$i] != "Theme") {
		if ($i == 0) {
			$nodetypes .= $CFG->BASE_TYPES[$i];
		} else {
			$nodetypes .= ",".$CFG->BASE_TYPES[$i];
		}
	}
}
$count = count($CFG->EVIDENCE_TYPES);
for ($i=0; $i<$count; $i++) {
	$nodetypes .= ",".$CFG->EVIDENCE_TYPES[$i];
}
$count = count($CFG->RESOURCE_TYPES);
for ($i=0; $i<$count; $i++) {
	$nodetypes .= ",".$CFG->RESOURCE_TYPES[$i];
}
$nodetypes .= ",Pro,Con";

$themes = getThemeCountsByNodeType($nodetypes, $direction1, $sort1, $oldsort1);

if ($sort1) {
	if ($direction1) {
		if ($oldsort1 === $sort1) {
			if ($direction1 === 'ASC') {
				$direction1 = "DESC";
			} else {
				$direction1 = "ASC";
			}
		} else {
			$direction1 = "ASC";
		}
	} else {
		$direction1 = "ASC";
	}
} else {
	$sort1='name';
	$direction1='ASC';
}

echo '<tr><td align="left" valign="bottom" width="60%" class="adminTableHead"><a href="newIdeas.php?&sort1=name&lastsort1='.$sort1.'&lastdir1='.$direction1.'&sort='.$sort.'&lastsort='.$oldsort.'&lastdir='.$direction.'">'.$LNG->STATS_GLOBAL_REGISTER_HEADER_NAME.'</b>';
if ($sort1 === 'name') {
	if ($direction1 === 'ASC') {
		echo '<img border="0" src="'.$CFG->homeAddress.'images/uparrow.gif" width="16" height="8" />';
	} else {
		echo '<img border="0" src="'.$CFG->homeAddress.'images/downarrow.gif" width="16" height="8" />';
	}
}
echo '</td>';
echo '<td align="left" valign="bottom" width="40%" class="adminTableHead"><a href="newIdeas.php?&sort1=count&lastsort1='.$sort1.'&lastdir1='.$direction1.'&sort='.$sort.'&lastsort='.$oldsort.'&lastdir='.$direction.'">'.$LNG->STATS_GLOBAL_OVERVIEW_HEADER_COUNT.'</b>';
if ($sort1 === 'count') {
	if ($direction1 === 'ASC') {
		echo '<img border="0" src="'.$CFG->homeAddress.'images/uparrow.gif" width="16" height="8" />';
	} else {
		echo '<img border="0" src="'.$CFG->homeAddress.'images/downarrow.gif" width="16" height="8" />';
	}
}
echo '</td>';
echo "</tr>";

$count = count($themes);
for ($i=0; $i<$count; $i++) {
	$next = $themes[$i];
	echo '<tr><td><span>'.$next['Name'].'</span></td><td><span> = '.$next['UseCount'].'</span</td></tr>';
}

echo '</table></div>';


/***** BY THEME AND BY CATEGORY *****/


$categoryArray2 = array();
if ($CFG->HAS_CHALLENGE) {
	$categoryArray2[$LNG->CHALLENGES_NAME] = getThemeCountsByNodeType('Challenge');
}

$categoryArray2[$LNG->ISSUES_NAME] = getThemeCountsByNodeType('Issue');

if ($CFG->HAS_SOLUTION) {
	$categoryArray2[$LNG->SOLUTION_NAME] = getThemeCountsByNodeType('Solution');
}

if ($CFG->HAS_CLAIM) {
	$categoryArray2[$LNG->CLAIM_NAME] = getThemeCountsByNodeType('Claim');
}

$count = count($CFG->EVIDENCE_TYPES);
$evidencetypes = "";
for ($i=0; $i<$count; $i++) {
	if ($i == 0) {
		$evidencetypes .= $CFG->EVIDENCE_TYPES[$i];
	} else {
		$evidencetypes .= ",".$CFG->EVIDENCE_TYPES[$i];
	}
}

$categoryArray2[$LNG->EVIDENCES_NAME] = getThemeCountsByNodeType($evidencetypes);

$count = count($CFG->RESOURCE_TYPES);
$resourcetypes = "";
for ($i=0; $i<$count; $i++) {
	if ($i == 0) {
		$resourcetypes .= $CFG->RESOURCE_TYPES[$i];
	} else {
		$resourcetypes .= ",".$CFG->RESOURCE_TYPES[$i];
	}
}
$categoryArray2[$LNG->RESOURCES_NAME] = getThemeCountsByNodeType($resourcetypes);
$categoryArray2[$LNG->ORGS_NAME] = getThemeCountsByNodeType('Organization');
$categoryArray2[$LNG->PROJECTS_NAME] = getThemeCountsByNodeType('Project');

echo '<div style="float: left;margin-top:10px;"><table cellpadding="3" border="1" style="border-collapse:collapse">';

$themes = getAllThemes();
$countthemes = count($themes);
$rows = array('TOP' => '<td>&nbsp;</td>');
for ($i=0; $i<$countthemes; $i++) {
	$theme = $themes[$i];
	$rows[$theme] = array();
}

foreach($categoryArray2 as $catname => $themes) {
	$rows['TOP'] .= '<td style="font-weight:bold;">'.$catname.'</td>';

	foreach($themes as $theme) {
		$themename = $theme['Name'];
		$themecount = $theme['UseCount'];

		if (array_key_exists($themename, $rows)) {
			$array = $rows[$themename];
			$array[$catname] = $themecount;
			$rows[$themename] = $array;
		} else {
			$newarray = array();
			$newarray[$catname] = $themecount;
			$rows[$themename] = $newarray;
		}
	}
}

echo "<tr>".$rows['TOP']."<td>".$LNG->STATS_GLOBAL_IDEAS_TOTAL_LABEL."</td><tr>";

foreach($rows as $themename => $catarray) {
	if ($themename != 'TOP') {
		echo '<tr><td style="font-weight:bold;">'.$themename.'</td>';

		$total = 0;

		foreach($categoryArray2 as $catname => $themes) {
			if (array_key_exists($catname, $catarray)) {
				echo "<td>".$catarray[$catname]."</td>";
				$total = $total + (int)$catarray[$catname];
			} else {
				echo "<td>0</td>";
			}
		}

		echo "<td>".$total."</td>";

		echo "</tr>";
	}
}

echo '</table></div>';

echo '<hr style="clear:both; float:left; width:100%; color:#E8E8E8; margin-top:20px;" />';

/***** MONTHLY BY CATEOGRY GRAPH *****/

$time = "months";

echo '<div style="clear: both; float: left; margin-top: 0px;"><img src="newIdeasGraph.php?time=months" /></div>';


/***** MONTHLY BY CATEOGRY TABLE ******/

$nodetypes = "";
$count = count($CFG->BASE_TYPES);
for($i=0; $i<$count; $i++){
	if ($CFG->BASE_TYPES[$i] != "Theme") {
		if ($i == 0) {
			$nodetypes .= "'".$CFG->BASE_TYPES[$i]."'";
		} else {
			$nodetypes .= ",'".$CFG->BASE_TYPES[$i]."'";
		}
	}
}
$count = count($CFG->EVIDENCE_TYPES);
for ($i=0; $i<$count; $i++) {
	$nodetypes .= ",'".$CFG->EVIDENCE_TYPES[$i]."'";
}

$count = count($CFG->RESOURCE_TYPES);
for ($i=0; $i<$count; $i++) {
	$nodetypes .= ",'".$CFG->RESOURCE_TYPES[$i]."'";
}

$evtypes = "";
$count = count($CFG->EVIDENCE_TYPES);
for($i=0; $i<$count; $i++){
	if ($i == 0) {
		$evtypes .= "'".$CFG->EVIDENCE_TYPES[$i]."'";
	} else {
		$evtypes .= ",'".$CFG->EVIDENCE_TYPES[$i]."'";
	}
}

$restypes = "";
$count = count($CFG->RESOURCE_TYPES);
for($i=0; $i<$count; $i++){
	if ($i == 0) {
		$restypes .= "'".$CFG->RESOURCE_TYPES[$i]."'";
	} else {
		$restypes .= ",'".$CFG->RESOURCE_TYPES[$i]."'";
	}
}

$day   = 24*60*60; // 24 hours * 60 minutes * 60 seconds
$week  = $day * 7;
$month = $day * 30.5;

// WE ONLY WANT THE LAST YEAR - OR PART THERE OF
if ($time === 'weeks') {
	$count = ceil((mktime()-$startdate) / $week);
	if ($count > 52) {
		$startdate =  $startdate+($WEEK*($count - 52));
		$count = 52;
	}
} else {
	$dates = new DateTime();
	$dates->setTimestamp($startdate);
	$interval = date_create('now')->diff( $dates );

	$count = $interval->m;
	$years = $interval->y;
	if (isset($years) && $years > 0) {
		$count = $count + ($interval->y * 12);
	}
	$count = $count+1; //(to get it to this month too);

	if ($count > 12) {
		$startdate = strtotime( '+'.($count - 12).' months', $startdate);
		//echo date("m / y", $startdate);
		$startdate = strtotime( 'first day of ' , $startdate);
		//echo date("m / y", $startdate);
		$count = 12;
	}
}

echo '<div style="clear:both; float:left;margin-top:20px;margin-left:50px;">';
echo '<table border="1" cellpadding="3" style="border-collapse:collapse">';
echo '<tr>';
if ($time === 'weeks') {
	echo '<th valign="top" style="font-weight:bold; width:70px;">Week</th>';
} else {
	echo '<th valign="top" style="font-weight:bold; width:70px;">Month</th>';
}

if ($CFG->HAS_CHALLENGE) {
	echo '<th valign="top" style="font-weight:bold; width:60px;">'.$LNG->CHALLENGES_NAME.'</th>';
}
echo '<td valign="top" style="font-weight:bold; width:60px;">'.$LNG->ISSUES_NAME.'</th>';
if ($CFG->HAS_SOLUTION) {
	echo '<th valign="top" style="font-weight:bold; width:60px;">'.$LNG->SOLUTIONS_NAME.'</th>';
}
if ($CFG->HAS_CLAIM) {
	echo '<th valign="top" style="font-weight:bold; width:60px;">'.$LNG->CLAIMS_NAME.'</th>';
}
echo '<th valign="top" style="font-weight:bold; width:60px;">'.$LNG->EVIDENCES_NAME.'</th>';
echo '<th valign="top" style="font-weight:bold; width:60px;">'.$LNG->RESOURCES_NAME.'</th>';
echo '<th valign="top" style="font-weight:bold; width:60px;">'.$LNG->ORGS_NAME.'</th>';
echo '<th valign="top" style="font-weight:bold; width:60px;">'.$LNG->PROJECTS_NAME.'</th>';

if ($CFG->HAS_OPEN_COMMENTS) {
	echo '<th valign="top" style="font-weight:bold; width:60px;">'.$LNG->COMMENTS_NAME.'</th>';
}
echo '<th valign="top" style="font-weight:bold; width:70px;">'.$LNG->STATS_GLOBAL_IDEAS_MONTHLY_TOTAL_LABEL.'</th>';

echo '</tr>';

$totalsArray = array();

for ($i=0; $i<$count; $i++) {
	echo '<tr>';

	$monthlytotal = 0;

	if ($i < 1) {
		$mintime= $startdate;
	} else {
		$mintime= $maxtime;
	}
	if ($time === 'weeks') {
		//$maxtime=$startdate + ($week*($i+1));
		$maxtime = strtotime( '+1 week', $mintime);
		echo '<td>'.date("m / y", $mintime).'</td>';
	} else {
		$maxtime = strtotime( '+1 month', $mintime);
		echo '<td>'.date("m / y", $mintime).'</td>';
	}

	if ($CFG->HAS_CHALLENGE) {
		$num1 = getNodeCreationCount("Challenge",$mintime, $maxtime);
		echo '<td>'.$num1.'</td>';
		if (isset($totalsArray[$LNG->CHALLENGES_NAME])) {
			$totalsArray[$LNG->CHALLENGES_NAME] += $num1;
		} else {
			$totalsArray[$LNG->CHALLENGES_NAME] = $num1;
		}
		$monthlytotal += $num1;
	}

	$num2 = getNodeCreationCount("Issue",$mintime, $maxtime);
	echo '<td>'.$num2.'</td>';
	if (isset($totalsArray[$LNG->ISSUES_NAME])) {
		$totalsArray[$LNG->ISSUES_NAME] += $num2;
	} else {
		$totalsArray[$LNG->ISSUES_NAME] = $num2;
	}
	$monthlytotal += $num2;

	if ($CFG->HAS_SOLUTION) {
		$num3 = getNodeCreationCount("Solution",$mintime, $maxtime);
		echo '<td>'.$num3.'</td>';
		if (isset($totalsArray[$LNG->SOLUTIONS_NAME])) {
			$totalsArray[$LNG->SOLUTIONS_NAME] += $num3;
		} else {
			$totalsArray[$LNG->SOLUTIONS_NAME] = $num3;
		}
		$monthlytotal += $num3;
	}

	if ($CFG->HAS_CLAIM) {
		$num4 = getNodeCreationCount("Claim",$mintime, $maxtime);
		echo '<td>'.$num4.'</td>';
		if (isset($totalsArray[$LNG->CLAIMS_NAME])) {
			$totalsArray[$LNG->CLAIMS_NAME] += $num4;
		} else {
			$totalsArray[$LNG->CLAIMS_NAME] = $num4;
		}
		$monthlytotal += $num4;
	}

	$num5 = getNodeCreationCount($evtypes,$mintime, $maxtime);
	echo '<td>'.$num5.'</td>';
	if (isset($totalsArray[$LNG->EVIDENCES_NAME])) {
		$totalsArray[$LNG->EVIDENCES_NAME] += $num5;
	} else {
		$totalsArray[$LNG->EVIDENCES_NAME] = $num5;
	}
	$monthlytotal += $num5;

	$num6 = getNodeCreationCount($restypes,$mintime, $maxtime);
	echo '<td>'.$num6.'</td>';
	if (isset($totalsArray[$LNG->RESOURCES_NAME])) {
		$totalsArray[$LNG->RESOURCES_NAME] += $num6;
	} else {
		$totalsArray[$LNG->RESOURCES_NAME] = $num6;
	}
	$monthlytotal += $num6;

	$num7 = getNodeCreationCount("Organization",$mintime, $maxtime);
	echo '<td>'.$num7.'</td>';
	if (isset($totalsArray[$LNG->ORGS_NAME])) {
		$totalsArray[$LNG->ORGS_NAME] += $num7;
	} else {
		$totalsArray[$LNG->ORGS_NAME] = $num7;
	}
	$monthlytotal += $num7;

	$num8 = getNodeCreationCount("Project",$mintime, $maxtime);
	echo '<td>'.$num8.'</td>';
	if (isset($totalsArray[$LNG->PROJECTS_NAME])) {
		$totalsArray[$LNG->PROJECTS_NAME] += $num8;
	} else {
		$totalsArray[$LNG->PROJECTS_NAME] = $num8;
	}
	$monthlytotal += $num8;

	if ($CFG->HAS_OPEN_COMMENTS) {
		$num9 = getNodeCreationCount("Idea",$mintime, $maxtime);
		echo '<td>'.$num9.'</td>';
		if (isset($totalsArray[$LNG->COMMENTS_NAME_SHORT])) {
			$totalsArray[$LNG->COMMENTS_NAME_SHORT] += $num9;
		} else {
			$totalsArray[$LNG->COMMENTS_NAME_SHORT] = $num9;
		}
		$monthlytotal += $num9;
	}
	echo '<td style="font-weight:bold;">'.$monthlytotal.'</td>';
	echo '</tr>';
}

echo '<tr>';

$grandtotal = 0;

echo '<td valign="top" style="font-weight:bold; width:70px;">Total</td>';

if ($CFG->HAS_CHALLENGE) {
	echo '<td valign="top" style="font-weight:bold; width:50px;">'.$totalsArray[$LNG->CHALLENGES_NAME].'</td>';
	$grandtotal += $totalsArray[$LNG->CHALLENGES_NAME];
}
echo '<td valign="top" style="font-weight:bold; width:50px;">'.$totalsArray[$LNG->ISSUES_NAME].'</td>';
$grandtotal += $totalsArray[$LNG->ISSUES_NAME];
if ($CFG->HAS_SOLUTION) {
	echo '<td valign="top" style="font-weight:bold; width:50px;">'.$totalsArray[$LNG->SOLUTIONS_NAME].'</td>';
	$grandtotal += $totalsArray[$LNG->SOLUTIONS_NAME];
}
if ($CFG->HAS_CLAIM) {
	echo '<td valign="top" style="font-weight:bold; width:50px;">'.$totalsArray[$LNG->CLAIMS_NAME].'</td>';
	$grandtotal += $totalsArray[$LNG->CLAIMS_NAME];
}
echo '<td valign="top" style="font-weight:bold; width:50px;">'.$totalsArray[$LNG->EVIDENCES_NAME].'</td>';
$grandtotal += $totalsArray[$LNG->EVIDENCES_NAME];
echo '<td valign="top" style="font-weight:bold; width:50px;">'.$totalsArray[$LNG->RESOURCES_NAME].'</td>';
$grandtotal += $totalsArray[$LNG->RESOURCES_NAME];
echo '<td valign="top" style="font-weight:bold; width:50px;">'.$totalsArray[$LNG->ORGS_NAME].'</td>';
$grandtotal += $totalsArray[$LNG->ORGS_NAME];
echo '<td valign="top" style="font-weight:bold; width:50px;">'.$totalsArray[$LNG->PROJECTS_NAME].'</td>';
$grandtotal += $totalsArray[$LNG->PROJECTS_NAME];

if ($CFG->HAS_OPEN_COMMENTS) {
	echo '<td valign="top" style="font-weight:bold; width:50px;">'.$totalsArray[$LNG->COMMENTS_NAME_SHORT].'</td>';
	$grandtotal += $totalsArray[$LNG->COMMENTS_NAME_SHORT];
}
echo '<td valign="top" style="font-weight:bold; width:50px;">'.$grandtotal.'</td>';

echo '</tr>';

echo '</table>';
echo '</div>';

include_once($HUB_FLM->getCodeDirPath("ui/footerstats.php"));

?>