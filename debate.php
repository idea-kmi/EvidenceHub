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

include_once("config.php");

$me = substr($_SERVER["PHP_SELF"], 1); // remove initial '/'
if ($HUB_FLM->hasCustomVersion($me)) {
	$path = $HUB_FLM->getCodeDirPath($me);
	include_once($path);
	die;
}

global $USER;

if (!$CFG->hasIssueDebateView) {
	include_once($HUB_FLM->getCodeDirPath("ui/header.php"));
	echo "<div class='errors'>.".$LNG->DEBATE_NOT_AVAILABLE."</div>";
	include_once($HUB_FLM->getCodeDirPath("ui/footer.php"));
	die;
}

$ref = "http" . ((!empty($_SERVER["HTTPS"])) ? "s" : "") . "://".$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];

// default parameters
$start = optional_param("start",0,PARAM_INT);
$max = optional_param("max",20,PARAM_INT);
$orderby = optional_param("orderby","date",PARAM_ALPHA);
$sort = optional_param("sort","DESC",PARAM_ALPHA);

$nodeid = required_param("id",PARAM_ALPHANUMEXT);
$focusid = optional_param("focusid","",PARAM_ALPHANUMEXT);
if ($focusid != "") {
	$selectednodeid = $focusid;
} else {
	$selectednodeid = $nodeid;
}

$node = getNode($nodeid, 'long');

if($node instanceof Hub_Error){
	include_once($HUB_FLM->getCodeDirPath("ui/header.php"));
	echo "<h1>".$LNG->ITEM_NOT_FOUND_ERROR."</h1>";
	include_once($HUB_FLM->getCodeDirPath("ui/footer.php"));
	die;
} else {
	$userid = "";
	if (isset($USER->userid)) {
		$userid = $USER->userid;
	}
	//auditView($userid, $nodeid, 'explore');
}

$nodetype = $node->role->name;
if ($nodetype != "Issue") {
	//get the Issue for this node.
	if ($nodetype == "Solution") {
		$selectednodeid = $nodeid;
		$connSet = getConnectionsByNode($node->nodeid,0,1,'date','ASC', 'all','','Issue');
		if (isset($connSet->connections[0])) {
			$con = $connSet->connections[0];
			if (isset($con->to)) {
				$node = $con->to;
				if($node instanceof Hub_Error){
					include_once($HUB_FLM->getCodeDirPath("ui/header.php"));
					echo "<h1>".$LNG->ITEM_NOT_FOUND_ERROR."</h1>";
					include_once($HUB_FLM->getCodeDirPath("ui/footer.php"));
					die;
				} else {
					$nodeid = $node->nodeid;
					$node = getNode($nodeid);
					if($node instanceof Hub_Error){
						include_once($HUB_FLM->getCodeDirPath("ui/header.php"));
						echo "<h1>".$LNG->ISSUE_NAME." ".$LNG->ITEM_NOT_FOUND_ERROR."</h1>";
						include_once($HUB_FLM->getCodeDirPath("ui/footer.php"));
						die;
					}
				}
			}
		}
	} else if ($nodetype == "Pro" || $nodetype == "Con" || $nodetype == "Comment"){
		$selectednodeid = $nodeid;
		$conSetSol = getConnectionsByNode($node->nodeid,0,1,'date','ASC', 'all', '', 'Solution');
		$consol = $conSetSol->connections[0];
		$nodesol = $consol->to;
		$consSet = getConnectionsByNode($nodesol->nodeid,0,1,'date','ASC', 'all', '', 'Issue');
		if (isset($connSet->connections[0])) {
			$con = $consSet->connections[0];
			if (isset($con->to)) {
				$localnode = $con->to;
				if($localnode instanceof Hub_Error){
					include_once($HUB_FLM->getCodeDirPath("ui/header.php"));
					echo "<h1>".$LNG->ITEM_NOT_FOUND_ERROR."</h1>";
					include_once($HUB_FLM->getCodeDirPath("ui/footer.php"));
					die;
				} else {
					$nodeid = $localnode->nodeid;
					$node = getNode($nodeid);
					if($node instanceof Hub_Error){
						include_once($HUB_FLM->getCodeDirPath("ui/header.php"));
						echo "<h1>".$LNG->ITEM_NOT_FOUND_ERROR."</h1>";
						include_once($HUB_FLM->getCodeDirPath("ui/footer.php"));
						die;
					}
				}
			}
		}
	}
}

$errors = array();

$hasAddPermissions = false;
if (isset($USER->userid)) {
	$hasAddPermissions = true;
}

$args = array();
$args["nodeid"] = $nodeid;
$args["selectednodeid"] = $selectednodeid;
$args["nodetype"] = $nodetype;
$args["title"] = $node->name;
$args["start"] = $start;
$args["max"] = $max;
$args["ref"] = $ref;

$wasEmpty = false;
if ($orderby == "") {
	$args["orderby"] = 'random';
	$wasEmpty = true;
} else {
	$args["orderby"] = $orderby;
}
$args["sort"] = $sort;

$CONTEXT = $CFG->NODE_CONTEXT;

// now trigger the js to load data
$argsStr = "{";
$keys = array_keys($args);

$keycount = 0;
if (is_countable($keys)) {
	$keycount = count($keys);
}

for($i=0;$i< $keycount; $i++){
	$argsStr .= '"'.$keys[$i].'":"'.$args[$keys[$i]].'"';
	if ($i != ($keycount-1)){
		$argsStr .= ',';
	}
}
$argsStr .= "}";

array_push($HEADER,'<link rel="stylesheet" href="'.$HUB_FLM->getStylePath("debateview.css").'" type="text/css"  media="screen" />');
array_push($HEADER,'<script src="'.$HUB_FLM->getCodeWebPath('ui/debateutils.js.php').'" type="text/javascript"></script>');
array_push($HEADER,'<script src="'.$HUB_FLM->getCodeWebPath('ui/exploreutils.js.php').'" type="text/javascript"></script>');

//checkLogin();

include_once($HUB_FLM->getCodeDirPath("ui/header.php"));
include_once($HUB_FLM->getCodeDirPath("ui/popuplib.php"));

try {
	$jsonnode = json_encode($node, JSON_INVALID_UTF8_IGNORE);
} catch (Exception $e) {
	echo('Caught exception: '.$e->getMessage());
}

echo "<script type='text/javascript'>";
echo "var CONTEXT = '".$CONTEXT."';";
echo "var NODE_ARGS = ".$argsStr.";";
echo "var nodeObj = ";
echo $jsonnode;
echo ";";
echo "</script>";
?>

<script type='text/javascript'>

Event.observe(window, 'load', function() {

	//buildNodeTitle('debate');
});

</script>


<div style="display: block;">
	<div id="nodearealineartitle" class="nodearealineartitle issueback issueborder" >
		<div class="issueback tabtitlebar">
			<label class="linearnodeheaderlabel" id="exploreheaderlabel"></label>
		</div>
	</div>

	<div id="mainnodediv" class="mainnodediv"></div>

	<div id="maininner" class="maininner" >

		<div id="addnewideaarea" class="addnewideaarea boxshadowsquaregreen">
			<?php
				if (isset($USER->userid)) {
					$idea = "";
					$ideadesc = "";
			?>
				<div id="newideaform" class="newideaform">
					<h2><img src="<?php echo $HUB_FLM->getImagePath('add.png'); ?>" alt="Add" /><span><?php echo $LNG->FORM_IDEA_NEW_TITLE; ?></span></h2>
					<div id="addformdividea" class="addformdividea">
						<input type="hidden" id="nodeid" name="nodeid" value="<?php echo $nodeid; ?>" />
						<div class="mb-3 row">
							<label class="col-sm-3 col-form-label hidden" for="addideaname"><?php echo $LNG->FORM_IDEA_LABEL_TITLE; ?></label>
							<div class="col-sm-9">
								<input <?php if (!$hasAddPermissions){ echo 'disabled'; } ?> class="form-control" placeholder="<?php echo $LNG->FORM_IDEA_LABEL_TITLE; ?>" id="addideaname" name="idea" value="" />
							</div>
						</div>
						<div class="mb-3 row">
							<label class="col-sm-3 col-form-label hidden" for="addideadesc"><?php echo $LNG->FORM_IDEA_LABEL_DESC; ?></label>
							<div class="col-sm-9">
								<textarea <?php if (!$hasAddPermissions){ echo 'disabled'; } ?> class="form-control" placeholder="<?php echo $LNG->FORM_IDEA_LABEL_DESC; ?>" id="addideadesc" name="ideadesc" value=""></textarea>
							</div>
						</div>
						<div class="mb-3 row">
							<div class="d-grid gap-2 d-md-flex justify-content-md-center mb-3">
								<button <?php if (!$hasAddPermissions){ echo 'disabled'; } ?> class="btn btn-primary" id="addidea" name="addidea" onclick="addIdeaNode(nodeObj, '', 'idea', 'active', true, <?php echo $CFG->STATUS_ACTIVE; ?>)"><?php echo $LNG->FORM_BUTTON_SUBMIT; ?></button>
							</div>
						</div>
					</div>
				</div>
			<?php } else { ?>
			<div class="idea-login">
				<?php
					if ($CFG->signupstatus == $CFG->SIGNUP_OPEN) {
						echo '<a title="'.$LNG->HEADER_SIGN_IN_LINK_TEXT.'" href="'.$CFG->homeAddress.'ui/pages/login.php?ref='.urlencode($ref).'">'.$LNG->HEADER_SIGN_IN_LINK_TEXT.'</a> | <a title="'.$LNG->HEADER_SIGNUP_OPEN_LINK_TEXT.'" href="'.$CFG->homeAddress.'ui/pages/registeropen.php">'.$LNG->HEADER_SIGNUP_OPEN_LINK_TEXT.'</a> '.$LNG->SOLUTION_CREATE_LOGGED_OUT_OPEN;
					} else if ($CFG->signupstatus == $CFG->SIGNUP_REQUEST) {
						echo '<a title="'.$LNG->HEADER_SIGN_IN_LINK_TEXT.'" href="'.$CFG->homeAddress.'ui/pages/login.php?ref='.urlencode($ref).'">'.$LNG->HEADER_SIGN_IN_LINK_TEXT.'</a> | <a title="'.$LNG->HEADER_SIGNUP_OPEN_LINK_TEXT.'" href="'.$CFG->homeAddress.'ui/pages/registerrequest.php">'.$LNG->HEADER_SIGNUP_REQUEST_LINK_TEXT.'</a> '.$LNG->SOLUTION_CREATE_LOGGED_OUT_REQUEST;
					} else {
						echo '<a title="'.$LNG->HEADER_SIGN_IN_LINK_TEXT.'" href="'.$CFG->homeAddress.'ui/pages/login.php?ref='.urlencode($ref).'">'.$LNG->HEADER_SIGN_IN_LINK_TEXT.'</a> '.$LNG->SOLUTION_CREATE_LOGGED_OUT_CLOSED;
					}
				}
				?>
			</div>
		</div>
		<div id="tabber">
			<ul id="tabs" class="tab">
				<li class="tab"><a class="tab" id="tab-remaining" href="#remaining"><span class="tab tabsolution">Remaining <span id="remaining-count"></span></a></li>
				<li class="tab"><a class="tab" id="tab-removed" href="#removed"><span class="tab tabsolution">Removed <span id="removed-count"></span></a></li>
			</ul>
			<div id="tabs-content">
				<div id='tab-content-remaining-div' class='tabcontentinner' style="display:none;"></div>
				<div id='tab-content-removed-div' class='tabcontentinner' style="display:none;"></div>
			</div>
		</div>
		<div id='content-ideas-div' class='content-ideas-div'>
			<div id='tab-content-idea-list' class='tabcontentinner tab-content-idea-list'></div>
		</div>
</div>

<?php
    include_once($HUB_FLM->getCodeDirPath("ui/footer.php"));
?>
