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
?>

<!DOCTYPE html>
<html>
	<head>

		<?php if ($CFG->GOOGLE_ANALYTICS4_ON) { ?>
			<!-- Google tag (gtag.js) -->
			<script async src="https://www.googletagmanager.com/gtag/js?id=<?php print($CFG->GOOGLE_ANALYTICS4_KEY);?>"></script>
			<script>
			window.dataLayer = window.dataLayer || [];
			function gtag(){dataLayer.push(arguments);}
			gtag('js', new Date());

			gtag('config', '<?php print($CFG->GOOGLE_ANALYTICS4_KEY);?>');
			</script>
		<?php } ?>

		<?php if ($CFG->GOOGLE_ANALYTICS_ON) { ?>
			<!-- Google analytics -->
			<script>
				(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
				(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
				m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
				})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

				ga('create', '<?php print($CFG->GOOGLE_ANALYTICS_KEY);?>', '<?php print($CFG->GOOGLE_ANALYTICS_DOMAIN);?>');
				ga('require', 'linkid', 'linkid.js');
				ga('send', 'pageview');
			</script>
		<?php } ?>

		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<title><?php echo $CFG->SITE_TITLE; ?></title>
		<link rel="stylesheet" href="<?php echo $HUB_FLM->getStylePath("tabber.css"); ?>" type="text/css" media="screen" />
		<link rel="stylesheet" href="<?php echo $HUB_FLM->getStylePath("node.css"); ?>" type="text/css" media="screen" />
		<link rel="stylesheet" href="<?php echo $HUB_FLM->getStylePath("dialogstyle.css"); ?>" type="text/css" media="screen" />
		<link rel="stylesheet" href="<?php echo $HUB_FLM->getStylePath("stylecustom.css"); ?>" type="text/css" media="screen" />
		<link rel="stylesheet" href="<?php echo $HUB_FLM->getStylePath("widget.css"); ?>" type="text/css" media="screen" />

		<link rel="icon" href="<?php echo $HUB_FLM->getImagePath("favicon.ico"); ?>" type="images/x-icon" />

		<script src="<?php echo $HUB_FLM->getCodeWebPath('ui/util.js.php'); ?>" type="text/javascript"></script>
		<script src="<?php echo $HUB_FLM->getCodeWebPath('ui/node.js.php'); ?>" type="text/javascript"></script>

		<script src="<?php echo $CFG->homeAddress; ?>ui/lib/prototype.js" type="text/javascript"></script>
		<script src="<?php echo $CFG->homeAddress; ?>ui/lib/dateformat.js" type="text/javascript"></script>

		<?php
		$custom = $HUB_FLM->getCodeDirPath("ui/headerreportCustom.php");
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

	<body style="background:white">
		<table style="border-collapse: collapse;padding:0px;margin:0px;width:90%">
		<tr>
		<td width="20%">
			<a id="dialoglogo" title="<?php echo $LNG->HEADER_LOGO_HINT; ?>" href="<?php print($CFG->homeAddress);?>" style="font-size: 10pt; margin-bottom:3px;">
			<img border="0" style="float: left;" alt="<?php echo $LNG->HEADER_LOGO_ALT; ?>" src="<?php echo $HUB_FLM->getImagePath('evidence-hub-logo-dialog.png'); ?>" />
			</a>
	   </td>
	   <td width="80%">
			<h1 style="text-align:center; margin: 0px; padding: 0px;margin-top:10px;" id="dialogheader"></h1>
	   </td>
	   </tr>
	   </table>

		<div id="main">
