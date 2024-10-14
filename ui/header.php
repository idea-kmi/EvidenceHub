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

	if ($CFG->privateSite) {
		checklogin();
	}

	$query = stripslashes(parseToJSON(optional_param("q","",PARAM_TEXT)));
	// need to do parseToJSON to convert any '+' symbols as they are now used in searches.
	$scope = optional_param("scope","all",PARAM_ALPHA);
	$tagsonly = optional_param("tagsonly",false,PARAM_BOOL);

	if( isset($_POST["loginsubmit"]) ) {
		$url = "http" . ((!empty($_SERVER["HTTPS"])) ? "s" : "") . "://".$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
		header('Location: '.$CFG->homeAddress.'ui/pages/login.php?ref='.urlencode($url));
	}

	global $HUB_FLM;
?>

<!DOCTYPE html>
<html lang="en">
	<head>

		<?php if ($CFG->GOOGLE_ANALYTICS_ON && isset(CFG->GOOGLE_SITE_TAG) && CFG->GOOGLE_SITE_TAG !="") { ?>

			<!-- Google tag (gtag.js) -->
			<script async src="https://www.googletagmanager.com/gtag/js?id=<?php print($CFG->GOOGLE_SITE_TAG);?>"></script>
			<script>
			window.dataLayer = window.dataLayer || [];
			function gtag(){dataLayer.push(arguments);}
			gtag('js', new Date());

			gtag('config', '<?php print($CFG->GOOGLE_SITE_TAG);?>');
			</script>

		<?php } ?>


		<?php if ($CFG->GOOGLE_ANALYTICS_ON && isset(CFG->GOOGLE_ANALYTICS_KEY) && CFG->GOOGLE_ANALYTICS_KEY !="") { ?>

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

		<meta http-equiv="Content-Type" content="text/html" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta charset="utf-8">
    	<meta name="viewport" content="width=device-width, initial-scale=1">
		<title><?php echo $CFG->SITE_TITLE; ?></title>

		<link rel="icon" href="<?php echo $HUB_FLM->getImagePath("favicon.ico"); ?>" type="images/x-icon" />

		<link rel="stylesheet" href="<?php echo $HUB_FLM->getStylePath("bootstrap.css"); ?>" type="text/css" />
		<link rel="stylesheet" href="<?php echo $HUB_FLM->getStylePath("all.css"); ?>" type="text/css" />
		<link rel="stylesheet" href="<?php echo $HUB_FLM->getStylePath("style.css"); ?>" type="text/css" media="screen" />
		<link rel="stylesheet" href="<?php echo $HUB_FLM->getStylePath("stylecustom.css"); ?>" type="text/css" media="screen" />
		<link rel="stylesheet" href="<?php echo $HUB_FLM->getStylePath("node.css"); ?>" type="text/css" media="screen" />
		<link rel="stylesheet" href="<?php echo $HUB_FLM->getStylePath("tabber.css"); ?>" type="text/css" media="screen" />
		<link rel="stylesheet" href="<?php echo $HUB_FLM->getStylePath("networknav.css"); ?>" type="text/css" media="screen" />
		<link rel="stylesheet" href="<?php echo $HUB_FLM->getStylePath("widget.css"); ?>" type="text/css" media="screen" />
		<link rel="stylesheet" href="<?php echo $HUB_FLM->getCodeWebPath("ui/lib/jit-2.0.2/Jit/css/base.css"); ?>" type="text/css" />
		<link rel="stylesheet" href="<?php echo $HUB_FLM->getCodeWebPath("ui/lib/jit-2.0.2/Jit/css/ForceDirected.css"); ?>" type="text/css" />

		<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A==" crossorigin=""/>

		<script src="<?php echo $HUB_FLM->getCodeWebPath('ui/util.js.php'); ?>" type="text/javascript"></script>
		<script src="<?php echo $HUB_FLM->getCodeWebPath('ui/node.js.php'); ?>" type="text/javascript"></script>
		<script src="<?php echo $HUB_FLM->getCodeWebPath('ui/users.js.php'); ?>" type="text/javascript"></script>
		<script src="<?php echo $HUB_FLM->getCodeWebPath('ui/widget.js.php'); ?>" type="text/javascript"></script>

		<script src="<?php echo $CFG->homeAddress; ?>ui/lib/prototype.js" type="text/javascript"></script>
		<script src="<?php echo $CFG->homeAddress; ?>ui/lib/dateformat.js" type="text/javascript"></script>
		<script src="<?php echo $CFG->homeAddress; ?>ui/lib/jit-2.0.2/Jit/jit.js" type="text/javascript"></script>
		<script src="<?php echo $CFG->homeAddress; ?>ui/networkmaps/forcedirectedlib.js.php" type="text/javascript"></script>
		<script src="<?php echo $CFG->homeAddress; ?>ui/networkmaps/socialforcedirectedlib.js.php" type="text/javascript"></script>
		<script src="<?php echo $CFG->homeAddress; ?>ui/networkmaps/networklib.js.php" type="text/javascript"></script>

		<script src="<?php echo $HUB_FLM->getCodeWebPath('ui/lib/bootstrap/bootstrap.bundle.min.js'); ?>" type="text/javascript"></script>

		<!-- Make sure you put this AFTER Leaflet's CSS -->
		<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js" integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA==" crossorigin=""></script>

		<script type="text/javascript">
			window.name="coheremain";

			function updateuserstatus() {
				new Ajax.Request(URL_ROOT+'updateuserstatus.php', { method:'get' });
			}

			function init(){
				updateuserstatus();
				setInterval("updateuserstatus()", 600000); // Update every 10 minute

				var args = new Object();
				args['filternodetypes'] = "Project,Organization,Issue,Solution,Claim,"+EVIDENCE_TYPES;

				<?php if ($CFG->hasRss) { ?>
					var feed = new Element("img",
						{'src': '<?php echo $HUB_FLM->getImagePath("feed-icon-20x20.png"); ?>',
						'title': '<?php echo $LNG->HEADER_RSS_FEED_ICON_HINT; ?>',
						'alt': '<?php echo $LNG->HEADER_RSS_FEED_ICON_ALT; ?>',
						'class': 'active',
						'style': 'padding-top:0px;'});
					Event.observe(feed,'click',function(){
						getNodesFeed(args);
					});

					$('rssbuttonfred').insert(feed);
				<?php } ?>

				resizeHistoryBar();
			}

			window.onload = init;
		</script>

		<?php
			$custom = $HUB_FLM->getCodeDirPath("ui/headerCustom.php");
			if (file_exists($custom)) {
				include_once($custom);
			}
		?>

		<?php
			global $HEADER,$BODY_ATT;
			if(is_array($HEADER)){
				foreach($HEADER as $header){
					echo $header;
				}
			}
		?>
	</head>
	<body <?php echo $BODY_ATT; ?> id="cohere-body">

		<nav class="py-2 bg-light border-bottom">
			<div class="container-fluid d-flex flex-wrap justify-content-end">
				<ul class="nav" id="menu">
					<?php
						global $USER;
						if(isset($USER->userid)){
							$name = $LNG->HEADER_MY_HUB_LINK; ?>

							<li class="nav-item"><a title='<?php echo $LNG->HEADER_USER_HOME_LINK_HINT; ?>' href='<?php echo $CFG->homeAddress; ?>user.php?userid=<?php echo $USER->userid; ?>#home-list' class="nav-link link-dark px-2"><?php echo $name ?></a>
							</li><li class="nav-item"><a title='<?php echo $LNG->HEADER_EDIT_PROFILE_LINK_HINT; ?>' href='<?php echo $CFG->homeAddress; ?>ui/pages/profile.php' class="nav-link link-dark px-2"><?php echo $LNG->HEADER_EDIT_PROFILE_LINK_TEXT; ?></a>
							</li><li class="nav-item"><a title='<?php echo $LNG->HEADER_SIGN_OUT_LINK_HINT; ?>' href='<?php echo $CFG->homeAddress; ?>ui/pages/logout.php' class="nav-link link-dark px-2"><?php echo $LNG->HEADER_SIGN_OUT_LINK_TEXT; ?></a></li>
						<?php } else { ?>
							<li class="nav-item">
								<form id='loginform' action='' method='post'>
									<input class="nav-link link-dark px-2" id='loginsubmit' name='loginsubmit' type='submit' value='<?php echo $LNG->HEADER_SIGN_IN_LINK_TEXT; ?>' class='active' title='<?php echo $LNG->HEADER_SIGN_IN_LINK_HINT; ?>'></input>
								</form>
							</li>
							<?php if ($CFG->signupstatus == $CFG->SIGNUP_OPEN) { ?>
								<li class="nav-item"><a title='<?php echo $LNG->HEADER_SIGNUP_OPEN_LINK_HINT; ?>' href='<?php echo $CFG->homeAddress; ?>ui/pages/registeropen.php' class="nav-link link-dark px-2"><?php echo $LNG->HEADER_SIGNUP_OPEN_LINK_TEXT; ?></a></li>
							<?php } else if ($CFG->signupstatus == $CFG->SIGNUP_REQUEST) { ?>
								<li class="nav-item"><a title='<?php echo $LNG->HEADER_SIGNUP_REQUEST_LINK_HINT; ?>' href='<?php echo $CFG->homeAddress; ?>ui/pages/registerrequest.php' class="nav-link link-dark px-2"><?php echo $LNG->HEADER_SIGNUP_REQUEST_LINK_TEXT; ?></a></li>
							<?php }
						}
					?>
					<li class="nav-item"><a title="<?php echo $LNG->HEADER_ABOUT_PAGE_LINK_HINT; ?>" href='<?php echo $CFG->homeAddress; ?>ui/pages/about.php' class="nav-link link-dark px-2"><?php echo $LNG->HEADER_ABOUT_PAGE_LINK_TEXT; ?></a></li>
					<li class="nav-item"><a title="<?php echo $LNG->HEADER_HELP_PAGE_LINK_HINT; ?>" href='<?php echo $CFG->homeAddress; ?>help/' class="nav-link link-dark px-2"><?php echo $LNG->HEADER_HELP_PAGE_LINK_TEXT; ?></a></li>
					<?php
						if($USER->getIsAdmin() == "Y"){ ?>
							<li class="nav-item"><a title='<?php echo $LNG->HEADER_ADMIN_PAGE_LINK_HINT; ?>' href='<?php echo $CFG->homeAddress; ?>admin/index.php' class="nav-link link-dark px-2"><?php echo $LNG->HEADER_ADMIN_PAGE_LINK_TEXT; ?> </a></li>
						<?php }
					?>
					<?php if ($CFG->hasRss) { ?>
						<div style="float:right;padding-left:10px;padding-top:0px;" id="rssbuttonfred"></div>
					<?php } ?>
				</ul>
			</div>
		</nav>

		<header class="py-3 mb-0 border-bottom" id="header">
			<div class="container-fluid d-flex flex-wrap justify-content-center">
				<div id="logo" class="d-flex align-items-center mb-3 mb-lg-0 me-lg-auto text-dark text-decoration-none">
					<a href="<?php print($CFG->homeAddress);?>" title="<?php echo $LNG->HEADER_LOGO_HINT; ?>" class="text-decoration-none">
						<img alt="<?php echo $LNG->HEADER_LOGO_ALT; ?>" src="<?php echo $HUB_FLM->getImagePath('evidence-hub-logo-header.png'); ?>" />
					</a>
				</div>
				<div class="col-12 col-lg-auto mb-3 mb-lg-0" id="search">
					<form name="search" action="<?php print($CFG->homeAddress);?>search.php" method="get" id="searchform" class="col-12 col-lg-auto mb-3 mb-lg-0">
						<div class="input-group mb-3">
							<a href="javascript:void(0)" onMouseOver="showGlobalHint('MainSearch', event, 'hgrhint'); return false;" onfocus="showGlobalHint('MainSearch', event, 'hgrhint'); return false;" onMouseOut="hideHints(); return false;" onClick="hideHints(); return false;" onkeypress="enterKeyPressed(event)" class="m-2 help-hint" aria-label="<?php echo $LNG->HEADER_SEARCH_RUN_ICON_HINT; ?>">
								<i class="fas fa-info-circle fa-lg" title="Search Info"></i>
							</a>
							<label class="d-none" for="q"><?php echo $LNG->HEADER_SEARCH_BOX_LABEL; ?></label>
							<input type="text" class="form-control" aria-label="Search" placeholder="<?php echo htmlspecialchars($LNG->DEFAULT_SEARCH_TEXT); ?>" id="q" name="q" value="<?php print( htmlspecialchars($query) ); ?>" />
  							<button class="btn btn-outline-secondary" type="button" onclick="javascript: document.forms['search'].submit();" >Search</button>
						</div>
						<div class="form-check">
							<input class="form-check-input" type="checkbox" name="tagsonly" value="true" id="tagsonly" <?php if ($tagsonly){ echo "checked='checked'";}?> />
							<label class="form-check-label" for="tagsonly"><?php echo $LNG->HEADER_SEARCH_TAGS_ONLY_LABEL; ?></label>
						</div>
						<div id="q_choices" class="autocomplete" style="display:none"></div>
					</form>
				</div>
			</div>
		</header>
		<div id="message" class="messagediv"></div>
		<div id="prompttext" class="prompttext"></div>
		<div id="hgrhint" class="hintRollover">
			<span id="globalMessage"></span>
		</div>
		<div id="main" class="main">
			<div id="contentwrapper" class="contentwrapper">
				<div id="content" class="content">
					<div class="c_innertube">
