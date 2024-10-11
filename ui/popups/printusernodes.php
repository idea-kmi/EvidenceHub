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

    $me = substr($_SERVER["PHP_SELF"], 1); // remove initial '/'
    if ($HUB_FLM->hasCustomVersion($me)) {
    	$path = $HUB_FLM->getCodeDirPath($me);
    	include_once($path);
		die;
	}

    array_push($HEADER,"<link rel='stylesheet' href='".$HUB_FLM->getStylePath("style.css")."' type='text/css' media='screen' />");
    array_push($HEADER,"<link rel='stylesheet' href='".$HUB_FLM->getStylePath("stylecustom.css")."' type='text/css' media='screen' />");

    array_push($HEADER,"<link rel='stylesheet' href='".$HUB_FLM->getStylePath("style.css")."' type='text/css' media='print' />");
    array_push($HEADER,"<link rel='stylesheet' href='".$HUB_FLM->getStylePath("stylecustom.css")."' type='text/css' media='print' />");

    array_push($HEADER,"<script src='".$HUB_FLM->getCodeWebPath("ui/node.js.php")."' type='text/javascript'></script>");
    array_push($HEADER,"<script src='".$HUB_FLM->getCodeWebPath("ui/users.js.php")."' type='text/javascript'></script>");
    array_push($HEADER,"<script src='".$CFG->homeAddress."ui/lib/dateformat.js' type='text/javascript'></script>");

    include_once($HUB_FLM->getCodeDirPath("ui/headerreport.php"));

    $userid = required_param("userid", PARAM_TEXT);
    $user = getUser($userid);
    $title = $user->name;
    $dataurl = $CFG->homeAddress."api/service.php?format=json&method=getnodesbyuser&userid=".$userid;
 ?>
<style type="text/css">
 @media print {
 input#btnPrint {
 display: none;
 }
 }
</style>
<script type="text/javascript">
	document.title = '<?php echo $title."_".$LNG->USER_REPORT_MY_DATA_TITLE; ?>';

	function getNodes(){

		//load Issues
		var dataurl = '<?php echo $dataurl; ?>'+'&filternodetypes=Issue';
		new Ajax.Request(dataurl, { method:'post',
			onSuccess: function(transport){
				var json = transport.responseText.evalJSON();
				if(json.error){
					alert(json.error[0].message);
					return;
				}
				$("issuedata").innerHTML = "";
				if(json.nodeset[0].nodes.length > 0) {
					var lOL = displayReportNodes($("issuedata"), json.nodeset[0].nodes, 1);
				} else {
					$("printnodesissues").style.display = 'none';
				}
			}
		});

		//load Solutions
		dataurl = '<?php echo $dataurl; ?>'+'&filternodetypes=Solution';
		new Ajax.Request(dataurl, { method:'post',
			onSuccess: function(transport){
				var json = transport.responseText.evalJSON();
				if(json.error){
					alert(json.error[0].message);
					return;
				}

				$("solutiondata").innerHTML = "";
				if(json.nodeset[0].nodes.length > 0) {
					var lOL = displayReportNodes($("solutiondata"), json.nodeset[0].nodes, 1);
				} else {
					$("printnodessolutions").style.display = 'none';
				}
			}
		});


		//load Evidence
		dataurl = '<?php echo $dataurl; ?>'+'&filternodetypes='+EVIDENCE_TYPES_STR;
		new Ajax.Request(dataurl, { method:'post',
			onSuccess: function(transport){
				var json = transport.responseText.evalJSON();
				if(json.error){
					alert(json.error[0].message);
					return;
				}

				$("evidencesdata").innerHTML = "";
				if(json.nodeset[0].nodes.length > 0) {
					var lOL = displayReportNodes($("evidencesdata"), json.nodeset[0].nodes, 1);
				} else {
					$("printnodesevidences").style.display = 'none';
				}
			}
		});

		//load Resources
		dataurl = '<?php echo $dataurl; ?>'+'&filternodetypes='+RESOURCE_TYPES_STR;
		new Ajax.Request(dataurl, { method:'post',
			onSuccess: function(transport){
				var json = transport.responseText.evalJSON();
				if(json.error){
					alert(json.error[0].message);
					return;
				}

				$("resourcedata").innerHTML = "";
				if(json.nodeset[0].nodes.length > 0) {
					var lOL = displayReportNodes($("resourcedata"), json.nodeset[0].nodes, 1);
				} else {
					$("printnodesresources").style.display = 'none';
				}
			}
		});

		//load Organizations
		dataurl = '<?php echo $dataurl; ?>'+'&filternodetypes=Organization';
		new Ajax.Request(dataurl, { method:'post',
			onSuccess: function(transport){
				var json = transport.responseText.evalJSON();
				if(json.error){
					alert(json.error[0].message);
					return;
				}

				$("orgdata").innerHTML = "";
				if(json.nodeset[0].nodes.length > 0) {
					var lOL = displayReportNodes($("orgdata"), json.nodeset[0].nodes, 1);
				} else {
					$("printnodesorgs").style.display = 'none';
				}
			}
		});

		//load Projects
		dataurl = '<?php echo $dataurl; ?>'+'&filternodetypes=Project';
		new Ajax.Request(dataurl, { method:'post',
			onSuccess: function(transport){
				var json = transport.responseText.evalJSON();
				if(json.error){
					alert(json.error[0].message);
					return;
				}

				$("projectdata").innerHTML = "";
				if(json.nodeset[0].nodes.length > 0) {
					var lOL = displayReportNodes($("projectdata"), json.nodeset[0].nodes, 1);
				} else {
					$("printnodesprojects").style.display = 'none';
				}
			}
		});
   }

    Event.observe(window, 'load', function() {
        getNodes();

    	$('usertitle').insert('<img src="<?php echo $user->thumb; ?>" style="padding-right:10px;" /><span style="font-size:12pt;font-weight:bold"><?php echo $title; ?></span>');

    	var heading = '<?php echo $LNG->USER_REPORT_MY_DATA_TITLE ?><br>';
	    $('reportheading').insert(heading);
    });
</script>

<br>
<div style="float:left;width:100%;margin:10px;">

<input type="button" id="btnPrint" value=" <?php echo $LNG->FORM_BUTTON_PRINT_PAGE; ?> " onclick="window.print();return false;" />

<center><h1 id="reportheading"></h1></center>

<span id="usertitle" style="width:100%;"></span>

<h2 id="printnodesissues" style="clear:both;padding-top:10px;"><?php echo $LNG->ISSUES_NAME; ?></h2>
<p id="issuedata"><img src='<?php echo $HUB_FLM->getImagePath("ajax-loader.gif"); ?>'/><br/><?php echo $LNG->LOADING_ISSUES; ?></p>

<h2 id="printnodessolutions" style="clear:both;padding-top:10px;"><?php echo $LNG->SOLUTIONS_NAME; ?></h2>
<p id="solutiondata"><img src='<?php echo $HUB_FLM->getImagePath("ajax-loader.gif"); ?>'/><br/><?php echo $LNG->LOADING_SOLUTIONS; ?></p>

<h2 id="printnodesevidences" style="clear:both;padding-top:10px;"><?php echo $LNG->EVIDENCES_NAME; ?></h2>
<p id="evidencesdata"><img src='<?php echo $HUB_FLM->getImagePath("ajax-loader.gif"); ?>'/><br/><?php echo $LNG->LOADING_EVIDENCES; ?></p>

<h2 id="printnodesresources" style="clear:both;padding-top:10px;"><?php echo $LNG->RESOURCES_NAME; ?></h2>
<p id="resourcedata"><img src='<?php echo $HUB_FLM->getImagePath("ajax-loader.gif"); ?>'/><br/><?php echo $LNG->LOADING_RESOURCES; ?></p>

<h2 id="printnodesorgs" style="clear:both;padding-top:10px;"><?php echo $LNG->ORGS_NAME; ?></h2>
<p id="orgdata"><img src='<?php echo $HUB_FLM->getImagePath("ajax-loader.gif"); ?>'/><br/><?php echo $LNG->LOADING_ORGS; ?></p>

<h2 id="printnodesprojects" style="clear:both;padding-top:10px;"><?php echo $LNG->PROJECTS_NAME; ?></h2>
<p id="projectdata"><img src='<?php echo $HUB_FLM->getImagePath("ajax-loader.gif"); ?>'/><br/><?php echo $LNG->LOADING_PROJECTS; ?></p>

<?php
    include_once($HUB_FLM->getCodeDirPath("ui/footerreport.php"));
?>