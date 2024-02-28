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

if ($CFG->privateSite) {
	checklogin();
}

$query = stripslashes(parseToJSON(optional_param("q","",PARAM_TEXT)));
// need to do parseToJSON to convert any '+' symbols as they are now used in searches.

$scope = optional_param("scope","all",PARAM_TEXT);
$tagsonly = optional_param("tagsonly",false,PARAM_BOOL);

if( isset($_POST["loginsubmit"]) ) {
    $url = "http" . ((!empty($_SERVER["HTTPS"])) ? "s" : "") . "://".$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
    header('Location: '.$CFG->homeAddress.'ui/pages/login.php?ref='.urlencode($url));
}

include_once($HUB_FLM->getCodeDirPath("core/statslib.php"));

global $HUB_FLM;

?>
<!DOCTYPE html>
<html>
<!-- !DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd" -->
<!-- html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<title><?php echo $CFG->SITE_TITLE; ?></title>

<link rel="stylesheet" href="<?php echo $HUB_FLM->getStylePath("style.css"); ?>" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php echo $HUB_FLM->getStylePath("stylecustom.css"); ?>" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php echo $HUB_FLM->getStylePath("tabber.css"); ?>" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php echo $HUB_FLM->getStylePath("node.css"); ?>" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php echo $HUB_FLM->getStylePath("widget.css"); ?>" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php echo $HUB_FLM->getStylePath("networknav.css"); ?>" type="text/css" media="screen" />

<link rel="icon" href="<?php echo $HUB_FLM->getImagePath("favicon.ico"); ?>" type="images/x-icon" />

<script src="<?php echo $HUB_FLM->getCodeWebPath('ui/util.js.php'); ?>" type="text/javascript"></script>
<script src="<?php echo $HUB_FLM->getCodeWebPath('ui/node.js.php'); ?>" type="text/javascript"></script>

<script src="<?php echo $CFG->homeAddress; ?>ui/lib/prototype.js" type="text/javascript"></script>
<script src="<?php echo $CFG->homeAddress; ?>ui/lib/dateformat.js" type="text/javascript"></script>

<?php
$custom = $HUB_FLM->getCodeDirPath("ui/headerstatsCustom.php");
if (file_exists($custom)) {
    include_once($custom);
}
?>

<?php
    global $HEADER,$BODY_ATT, $CFG;
    if(is_array($HEADER)){
        foreach($HEADER as $header){
            echo $header;
        }
    }
?>
</head>

<body>

<!-- div style="width:98%;height:60px;">
	<table style="border-collapse: collapse;padding:0px;margin:0px;width:100%;margin-left:10px;">
	<tr>
	<td width="20%">
    	<a title="<?php echo $LNG->HEADER_LOGO_HINT; ?>" href="<?php print($CFG->homeAddress);?>" style="font-size: 10pt; margin-bottom:3px;">
        <img border="0" alt="<?php echo $LNG->HEADER_LOGO_ALT; ?>" src="<?php echo $HUB_FLM->getImagePath('evidence-hub-logo-dialog.png'); ?>" />
        </a>
   </td>
	<td>
		<a href="<?php print($CFG->homeAddress);?>" title="<?php echo $LNG->HEADER_HOME_ICON_HINT; ?>" style="font-size: 10pt; margin-left:5px;">
		<img border="0" width="20" height="20" alt="<?php echo $LNG->HEADER_HOME_ICON_ALT; ?>" src="<?php echo $HUB_FLM->getImagePath('home.png'); ?>" />
		</a>
   </td>
   <td align="left">
		<h1 style="margin: 0px; padding: 0px;margin-left:40px;margin-top:5px;">Evidence Hub Global Analytics</h1>
   </td>
   </tr>
   </table>
</div -->

<div id="header" class="headerback" style="margin-bottom:0px;padding-bottom:0px">
    <div id="logo" style="padding-top:0px;">
    	<a title="<?php echo $LNG->HEADER_LOGO_HINT; ?>" href="<?php print($CFG->homeAddress);?>" style="font-size: 10pt; margin-bottom:3px;">
        <img border="0" alt="<?php echo $LNG->HEADER_LOGO_ALT; ?>" src="<?php echo $HUB_FLM->getImagePath('evidence-hub-logo-header.png'); ?>" />
        </a>
    </div>
    <div style="float: left; padding-top:16px;margin-left:5px;">
		<div style="padding-bottom:12px;">
			<span style="color:gray;font-size: 12pt;font-weight: bold"><?php echo $LNG->HEADER_VERSION_TEXT; ?></span>
		</div>
		<div style="padding-left:23px;">
			<a href="<?php print($CFG->homeAddress);?>" title="<?php echo $LNG->HEADER_HOME_ICON_HINT; ?>" style="font-size: 10pt; margin-bottom:3px;">
			<img border="0" width="20" height="20" alt="<?php echo $LNG->HEADER_HOME_ICON_ALT; ?>" src="<?php echo $HUB_FLM->getImagePath('home.png'); ?>" />
			</a>
		</div>
	</div>
    <div style="float: right;">
		<div style="float:right;">
			<div id="menu">
				<div style="float:left;">
				<?php
					global $USER;
					if(isset($USER->userid)){
						/*if($USER->name == ""){
							$name = $USER->getEmail();
						} else {
							$name = $USER->name;
						}*/
						$name = $LNG->HEADER_MY_HUB_LINK;
						echo "<a title='".$LNG->HEADER_USER_HOME_LINK_HINT."' href='".$CFG->homeAddress."user.php?userid=".$USER->userid."#home-list'>". $name ."</a> | <a title='".$LNG->HEADER_EDIT_PROFILE_LINK_HINT."' href='".$CFG->homeAddress."ui/pages/profile.php'>".$LNG->HEADER_EDIT_PROFILE_LINK_TEXT."</a> | <a title='".$LNG->HEADER_SIGN_OUT_LINK_HINT."' href='".$CFG->homeAddress."ui/pages/logout.php'>".$LNG->HEADER_SIGN_OUT_LINK_TEXT."</a> ";
					} else {
						echo "<form style='margin:0px; padding:0px;padding-right:3px; float:left;' id='loginform' action='' method='post'><input style='margin:0px; padding:0px;margin-bottom:3px; border:0px solid white; background:white;font-family: Arial, Helvetica, sans-serif; font-size: 10pt;' id='loginsubmit' name='loginsubmit' type='submit' value='".$LNG->HEADER_SIGN_IN_LINK_TEXT."' class='active' title='".$LNG->HEADER_SIGN_IN_LINK_HINT."'></input></form>";
						if ($CFG->signupstatus == $CFG->SIGNUP_OPEN) {
							echo " | <a title='".$LNG->HEADER_SIGNUP_OPEN_LINK_HINT."' href='".$CFG->homeAddress."ui/pages/registeropen.php'>".$LNG->HEADER_SIGNUP_OPEN_LINK_TEXT."</a> ";
						} else if ($CFG->signupstatus == $CFG->SIGNUP_REQUEST) {
							echo " | <a title='".$LNG->HEADER_SIGNUP_REQUEST_LINK_HINT."' href='".$CFG->homeAddress."ui/pages/registerrequest.php'>".$LNG->HEADER_SIGNUP_REQUEST_LINK_TEXT."</a> ";
						}
					}
				?>
				| <a title="<?php echo $LNG->HEADER_ABOUT_PAGE_LINK_HINT; ?>" href='<?php echo $CFG->homeAddress; ?>ui/pages/about.php'><?php echo $LNG->HEADER_ABOUT_PAGE_LINK_TEXT; ?></a>
				| <a title="<?php echo $LNG->HEADER_HELP_PAGE_LINK_HINT; ?>" href='<?php echo $CFG->homeAddress; ?>help/'><?php echo $LNG->HEADER_HELP_PAGE_LINK_TEXT; ?></a>

				<?php
				if($USER->getIsAdmin() == "Y"){
					echo "| <a title='".$LNG->HEADER_ADMIN_PAGE_LINK_HINT."' href='".$CFG->homeAddress."admin/index.php'>".$LNG->HEADER_ADMIN_PAGE_LINK_TEXT." </a>";
				}
				?>

				</div>
			</div>

			<div id="search" style="width:380px;">
				<form name="search" action="<?php print($CFG->homeAddress);?>search.php" method="get" id="searchform">
					<label for="q" style="float: left; margin-right: 3px; margin-top: 3px;font-weight:bold"><a href="javascript:void(0)" onMouseOver="showGlobalHint('MainSearch', event, 'hgrhint'); return false;" onMouseOut="hideHints(); return false;" onClick="hideHints(); return false;" onkeypress="enterKeyPressed(event)"><img style="vertical-align:bottom" src="<?php echo $HUB_FLM->getImagePath('info.png'); ?>" border="0" style="margin:0px;margin-left: 5px;padding:0px" /></a>
					<?php echo $LNG->HEADER_SEARCH_BOX_LABEL; ?></label>
					<div style="float: left;">
						<input type="text" style=" margin-right:3px; width:250px" placeholder="<?php echo htmlspecialchars($LNG->DEFAULT_SEARCH_TEXT); ?>" id="q" name="q" value="<?php print( htmlspecialchars($query) ); ?>"/>
						<div style="clear: both;">
							<input type="checkbox" name="tagsonly" value="true" <?php if ($tagsonly){ echo "checked='checked'";}?>/> <?php echo $LNG->HEADER_SEARCH_TAGS_ONLY_LABEL; ?> &nbsp;
						</div>

						<div id="q_choices" class="autocomplete" style="display:none"></div>
					</div>
					<div style="float:left;"><img src="<?php echo $HUB_FLM->getImagePath('search.png'); ?>" class="active" width="20" height="20" onclick="javascript: document.forms['search'].submit();" title="<?php echo $LNG->HEADER_SEARCH_RUN_ICON_HINT; ?>" alt="<?php echo $LNG->HEADER_SEARCH_RUN_ICON_ALT; ?>" /></div>
				 </form>
			 </div>
		</div>
     </div>
</div>

<center>
	<h1 style="padding:0px;margin:0px"><?php echo $LNG->STATS_GLOBAL_TITLE; ?></h1>
</center>

<div id="main" style="margin-top:10px;">
<div style="float: left; width: 98%;padding:0px;">
<div style="float:left;width:100%;">
    <?php
        include("menu.php");
    ?>
</div>
<div style="width:100%;clear:both;float:left;padding:10px;padding-left:20px;">