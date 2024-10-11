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
?>

function getIsOpen(div, isopen, nodetofocusid) {

	if (nodetofocusid === undefined) {
		nodetofocusid = "";
	}

	if (isopen) {
		if (div && div.style.display == "none") {
			isopen = false;
		}
	} else {
		if (div && div.style.display == "flex"
				|| nodetofocusid !="") {
			isopen = true;
		}
	}
	return isopen;
}

function buildWidgetExploreNodeHeader(container, label, color, type, icon, height, key) {

	var widgetHeader = new Element("div", { 'class':'widgetheadernode row px-3 py-1 mx-0 '+color, 'id':'widgetnodeheader'});

	var widgetHeaderControlButton = new Element('img',{ 'style':'cursor: pointer;', 'alt':'<?php echo $LNG->WIDGET_RESIZE_ITEM_ALT; ?>', 'id':key+'buttonresize', 'title': '<?php echo $LNG->WIDGET_RESIZE_ITEM_HINT; ?>', 'src': '<?php echo $HUB_FLM->getImagePath("enlarge2.gif"); ?>'});
	Event.observe(widgetHeaderControlButton,'click',function (){toggleExpandWidget(this, key, height)});

	var widgetInnerHeader = new Element("div", {'class':'widgetheaderinnernode col', 'id':key+'headerinner', 'title':'<?php echo $LNG->WIDGET_EXPAND_HINT; ?>'});
	var widgetHeaderLabel = new Element("label", {'class':'widgetnodeheaderlabel col-auto', 'id':'widgetheaderlabel'});
	widgetInnerHeader.insert(widgetHeaderLabel);

	Event.observe(widgetInnerHeader,'click',function (){ toggleExpandWidget(widgetHeaderControlButton, key, height)});

	if (icon) {
		var iconObj = new Element('img',{'style':'text-align: middle;margin-right: 5px; width:24px; height:24px;', 'alt':type+' <?php echo $LNG->WIDGET_ICON_ALT; ?>', 'src':icon});
		iconObj.align='left';
		widgetHeaderLabel.appendChild(iconObj);
	}

	widgetHeaderLabel.insert(label);
	widgetHeader.insert(widgetInnerHeader);

	var widgetInnerHeaderControl = new Element("div", {'class':'widgetheadercontrol col-auto '+color});
	widgetInnerHeaderControl.insert(widgetHeaderControlButton);

	widgetHeader.insert(widgetInnerHeaderControl);

	container.insert(widgetHeader);
}

/**
 * Build the widget header area
 * @param title the title to put in the header bar
 * @param height the height if this widget
 * @param isOpen true if the widget should be draw opne, false if closed.
 * @param color the class name od the class whihc states the backgroun color for the header bar.
 * @param key the unique text string that identifies this widget from the others on the page.
 * @param withAdjust add the open and big up buttons or not.
 */
function buildWidgetHeader(title, height, isOpen, color, key, icon, withAdjust) {

	if (withAdjust === undefined) {
		withAdjust = true;
	}

	var widgetHeader = new Element("div", {'class':'row m-0 p-0 widgetheader '+color, 'id':key+"header"});

	var widgetInnerHeader = new Element("div", {'class':'widgetheaderinner col', 'id':key+"headerinner", 'title':'<?php echo $LNG->WIDGET_EXPAND_HINT; ?>'});
	var widgetHeaderLabel = new Element("label", {'class':'widgetheaderlabel widgettextcolor ', 'id':key+"headerlabel"});

	if (icon) {
		var icon = new Element('img',{'class':'widgetTitleIcon', 'alt':title+' <?php echo $LNG->WIDGET_ICON_ALT; ?>', 'src':icon});
		icon.align='left';
		widgetInnerHeader.appendChild(icon);
	}

	widgetHeaderLabel.insert("<span class='widgetcountlabel'>(0)</span>"+title);

	widgetInnerHeader.insert(widgetHeaderLabel);
	widgetHeader.insert(widgetInnerHeader);

	if (withAdjust) {
		var widgetHeaderControlButton = new Element('img',{ 'style':'cursor: pointer;', 'alt':'<?php echo $LNG->WIDGET_RESIZE_ITEM_ALT; ?>', 'id':key+'buttonresize', 'title': '<?php echo $LNG->WIDGET_RESIZE_ITEM_HINT; ?>', 'src': '<?php echo $HUB_FLM->getImagePath("enlarge2.gif"); ?>'});

		Event.observe(widgetHeaderLabel,'mouseover',function (){widgetHeaderLabel.style.cursor = 'pointer'});
		Event.observe(widgetHeaderLabel,'mouseout',function (){widgetHeaderLabel.style.cursor = 'normal'});

		Event.observe(widgetInnerHeader,'mouseover',function (){widgetInnerHeader.style.cursor = 'pointer'});
		Event.observe(widgetInnerHeader,'mouseout',function (){widgetInnerHeader.style.cursor = 'normal'});
		Event.observe(widgetInnerHeader,'click',function (){toggleExpandWidget(widgetHeaderControlButton, key, height)});
		Event.observe(widgetHeaderControlButton,'click',function (){toggleExpandWidget(this, key, height)});
		var widgetInnerHeaderControl = new Element("div", {'class':'widgetheadercontrol col-auto'});
		widgetInnerHeaderControl.insert(widgetHeaderControlButton);

		var widgetHeaderControlButton2 = new Element('img',{ 'style':'cursor: pointer;display: inline', 'alt':'<?php echo $LNG->WIDGET_OPEN_CLOSE_ALT; ?>', 'id':key+'buttonarrow', 'title': '<?php echo $LNG->WIDGET_OPEN_CLOSE_HINT; ?>', 'src': '<?php echo $HUB_FLM->getImagePath("arrow-up2.png"); ?>'});
		Event.observe(widgetHeaderControlButton2,'click',function (){toggleWidget(this, key, height)});
		widgetInnerHeaderControl.insert(widgetHeaderControlButton2);

		widgetHeader.insert(widgetInnerHeaderControl);

		if (isOpen) {
			widgetHeaderControlButton2.src='<?php echo $HUB_FLM->getImagePath("arrow-up2.png"); ?>';
		} else {
			widgetHeaderControlButton2.src='<?php echo $HUB_FLM->getImagePath("arrow-down2.png"); ?>';
		}
	}

	return widgetHeader;
}

function adjustForExpand(button, key, mainheight) {
	if (button) {
		button.src = '<?php echo $HUB_FLM->getImagePath("reduce.gif"); ?>';
	}

	if ($(key+"headerinner")) {
		$(key+"headerinner").title = '<?php echo $LNG->WIDGET_CONTRACT_HINT; ?>';
	} else if ($(key+"toolbar")) {
		$(key+"toolbar").title = '<?php echo $LNG->WIDGET_CONTRACT_HINT; ?>';
	}

	if ($(key+"buttonarrow") != null) {
		if ($(key+"body").style.display == 'none') {
			$(key+"buttonarrow").isClosed = 'true';
		} else {
			$(key+"buttonarrow").isClosed = 'false';
		}
		$(key+"buttonarrow").style.display = 'none';
	}

	var height = mainheight;

	if (key == nodekey) {
		height = 700;
	} else {
		if ($('widgetcolleft') && $('widgetcolright')) {
			var lheight = $('widgetcolleft').offsetHeight;
			var rheight = $('widgetcolright').offsetHeight;
			var height = lheight;
			if (lheight < rheight) {
				height = rheight;
			}
		} else if ($('widgetcolleft')) {
			var height = $('widgetcolleft').offsetHeight;
		} else if ($('widgetcolright')) {
			var height = $('widgetcolright').offsetHeight;
		}
	}

	$(key+"body").style.display = "block";
	$(key+"body").style.height = (height-$(key+"header").offsetHeight-15)+"px";
	if ($(key+"innerbody")) {
		$(key+"innerbody").style.height = (height-$(key+"header").offsetHeight-15)+"px";
	}
	$(key+"div").style.height = height+"px";
}

function adjustForContract(button, key, mainheight) {
	button.src = '<?php echo $HUB_FLM->getImagePath("enlarge2.gif"); ?>';

	if ($(key+"headerinner")) {
		$(key+"headerinner").title = '<?php echo $LNG->WIDGET_EXPAND_HINT; ?>';
	} else if ($(key+"toolbar")) {
		$(key+"toolbar").title = '<?php echo $LNG->WIDGET_EXPAND_HINT; ?>';
	}

	if ($(key+"buttonarrow")) {
		$(key+"buttonarrow").style.display = 'inline';
	}

	$(key+"body").style.height = (mainheight-$(key+"header").offsetHeight-10)+"px";
	if ($(key+"innerbody")) {
		$(key+"innerbody").style.height = (mainheight-$(key+"header").offsetHeight-10)+"px";
	}
	$(key+"div").style.height = mainheight+"px";

	// ADJUST IF WIDGET WAS CLOSED BEFORE EXPANDING
	if ($(key+"buttonarrow") && $(key+"buttonarrow").isClosed == 'true') {
		$(key+"body").style.display = "none";
		$(key+"buttonarrow").src = '<?php echo $HUB_FLM->getImagePath("arrow-down2.png"); ?>';
		var header = $(key+"header").offsetHeight;
		var headerinner = $(key+"headerinner").offsetHeight;
		if (header > headerinner) {
			$(key+"div").style.height = header+"px";
		} else {
			$(key+"div").style.height = headerinner+"px";
		}
	} else {
		$(key+"body").style.display = "block";
	}
}

function adjustForContractNode(button, key, mainheight) {
	button.src = '<?php echo $HUB_FLM->getImagePath("enlarge2.gif"); ?>';

	if ($(key+"headerinner")) {
		$(key+"headerinner").title = '<?php echo $LNG->WIDGET_EXPAND_HINT; ?>';
	} else if ($(key+"toolbar")) {
		$(key+"toolbar").title = '<?php echo $LNG->WIDGET_EXPAND_HINT; ?>';
	}

	$(key+"body").style.display = "block";

	var headerheight = $(key+'header').offsetHeight;
	$(key+'div').style.height = mainheight-6 +"px";
	$(key+'innerbody').style.height = mainheight-headerheight-27 +"px"; //54
	$(key+'body').style.height = mainheight-headerheight-46 +"px";
}

/**
 * Expand/contract widgets
 */
function toggleExpandWidget(button, key, mainheight) {

	if (key == nodekey) {
		if (($('widgettable').style.display == 'flex') || ($('widgettable').style.display == '')) {
			$('widgetareadiv').insert($('nodearea'));
			adjustForExpand(button, key, mainheight);
			$('widgettable').style.display='none';
			if ($('widgetextrastable')) {
				$('widgetextrastable').style.display='none';
			}
		} else {
			$('widgettable').style.display='flex';
			if ($('widgetextrastable')) {
				$('widgetextrastable').style.display='flex';
			}
			$('widgetcolnode').insert({'top':$('nodearea')});
			adjustForContractNode(button, key, mainheight);
			resizeNodeWidget(key, mainheight);
		}
	} else {
		var currentArray = "";
		if (typeof leftColumn !== 'undefined' && leftColumn.hasOwnProperty(key)) {
			currentArray = leftColumn;
		} else if (typeof rightColumn !== 'undefined' && rightColumn.hasOwnProperty(key)) {
			currentArray = rightColumn;
		} else if (typeof extraColumn !== 'undefined' && extraColumn.hasOwnProperty(key)) {
			currentArray = extraColumn;
		} else if (typeof recommendColumn !== 'undefined' && recommendColumn.hasOwnProperty(key)) {
			currentArray = recommendColumn;
		} else if (typeof relatedColumn !== 'undefined' && relatedColumn.hasOwnProperty(key)) {
			currentArray = relatedColumn;
		}

		if (currentArray != "") {
			if ($(key+"buttonarrow").style.display == 'inline') {
				for (var nextkey in currentArray) {
					if (nextkey == key) {
						$(currentArray[nextkey]).style.display = 'flex';
					} else {
						$(currentArray[nextkey]).style.display = 'none';
					}
				}
				adjustForExpand(button, key, mainheight);
			} else {
				var i = 0;
				for (var nextkey in currentArray) {
					$(currentArray[nextkey]).style.display = 'flex';
					i++;
				}
				adjustForContract(button, key, mainheight);
			}
		}
	}
}

function resizeNodeWidget(key, height) {
	if ($('widgetcolleft') && $('widgetcolright')) {
		var lheight = $('widgetcolleft').offsetHeight;
		var rheight = $('widgetcolright').offsetHeight;
		var height = lheight;
		if (lheight < rheight) {
			height = rheight;
		}
	} else if ($('widgetcolleft')) {
		height = $('widgetcolleft').offsetHeight;
	} else if ($('widgetcolright')) {
		height = $('widgetcolright').offsetHeight;
	}

	var headerheight = $(key+'header').offsetHeight;
	$(key+'div').style.height = height-6 +"px";
	if ($(key+'innerbody')) {
		$(key+'innerbody').style.height = height-headerheight-27 +"px"; //54
	}
	if ($(key+'body')) {
		$(key+'body').style.height = height-headerheight-46 +"px";
	}
}

function resizeKeyWidget(key) {
	var header = 0;
	if ($(key+"header")) {
		header = $(key+"header").offsetHeight;
	}

	var headerinner = 0;
	if ($(key+"headerinner")) {
		headerinner = $(key+"headerinner").offsetHeight;
	}

	var headerlabel = 0;
	if ($(key+"headerlabel")) {
		headerlabel = $(key+"headerlabel").offsetHeight;
	}

	if (headerinner > header) {
		$(key+"header").style.height = headerinner+"px";
	}
	if (headerlabel > headerinner) {
		$(key+"header").style.height = headerlabel+"px";
	}

	if ($(key+"body") && $(key+"div")) {
		if ($(key+"body").style.display == "none") {
			if (header > headerinner) {
				$(key+"div").style.height = header+"px";
			} else if (headerlabel > header) {
				$(key+"div").style.height = headerlabel+"px";
			} else {
				$(key+"div").style.height = headerinner+"px";
			}
		} else {
			var divheight = $(key+"div").offsetHeight;
			if (header > headerinner) {
				$(key+"body").style.height = (divheight-header-12)+"px";
			} else {
				$(key+"body").style.height = (divheight-headerinner-14)+"px";
			}
		}
	}
}

function toggleWidget(button, key, mainheight) {
	if ( $(key+"body").style.display == "flex") {
		$(key+"body").style.display = "none";
		button.isClosed = 'true';
		button.src='<?php echo $HUB_FLM->getImagePath("arrow-down2.png"); ?>';
		var header = $(key+"header").offsetHeight;
		var headerinner = $(key+"headerinner").offsetHeight;
		if (header > headerinner) {
			$(key+"div").style.height = header+"px";
		} else {
			$(key+"div").style.height = headerinner+"px";
		}
	} else {
		$(key+"body").style.display = "flex";
		button.src='<?php echo $HUB_FLM->getImagePath("arrow-up2.png"); ?>';
		button.isClosed = 'false';
		$(key+"div").style.height = mainheight+"px";

		var header = $(key+"header").offsetHeight;
		var headerinner = $(key+"headerinner").offsetHeight;
		if (header > headerinner) {
			$(key+"body").style.height = (mainheight-header-12)+"px";
		} else {
			$(key+"body").style.height = (mainheight-headerinner-12)+"px";
		}
	}
}

function buildThemeRelatedWidget(nodeid, theme, title, height, nodetype, color, key, nodetofocusid, handler, isOpen) {

	var widgetDiv = new Element("div", {'class':'widgetdiv', 'id':key+"div"});
	widgetDiv.style.height = height+"px";

	var widgetHeader = new Element("div", {'class':'widgetheader row m-0 p-0 '+color, 'id':key+"header"});

	var widgetHeaderControlButton = new Element('img',{ 'style':'cursor: pointer;', 'alt':'<?php echo $LNG->WIDGET_RESIZE_ITEM_ALT; ?>', 'id':key+'buttonresize', 'title': '<?php echo $LNG->WIDGET_RESIZE_ITEM_HINT; ?>', 'src': '<?php echo $HUB_FLM->getImagePath("enlarge2.gif"); ?>'});
	Event.observe(widgetHeaderControlButton,'click',function (){toggleExpandWidget(this, key, height)});

	var widgetInnerHeader = new Element("div", {'class':'widgetheaderinner col', 'id':key+"headerinner"});
	Event.observe(widgetInnerHeader,'mouseover',function (){widgetInnerHeader.style.cursor = 'pointer'});
	Event.observe(widgetInnerHeader,'mouseout',function (){widgetInnerHeader.style.cursor = 'normal'});
	Event.observe(widgetInnerHeader,'click',function (){toggleExpandWidget(widgetHeaderControlButton, key, height)});

	var widgetHeaderLabel = new Element("label", {'class':'widgetheaderlabel widgettextcolor', 'id':key+"headerlabel"});
	widgetHeaderLabel.insert("<span class='widgetcountlabel'>(0)</span>"+title);
	Event.observe(widgetHeaderLabel,'mouseover',function (){widgetHeaderLabel.style.cursor = 'pointer'});
	Event.observe(widgetHeaderLabel,'mouseout',function (){widgetHeaderLabel.style.cursor = 'normal'});

	widgetInnerHeader.insert(widgetHeaderLabel);
	widgetHeader.insert(widgetInnerHeader);

	var widgetInnerHeaderControl = new Element("div", {'class':'widgetheadercontrol col-auto'});

	widgetInnerHeaderControl.insert(widgetHeaderControlButton);

	var widgetHeaderControlButton2 = new Element('img',{ 'style':'display: inline; cursor: pointer;', 'alt':'<?php echo $LNG->WIDGET_OPEN_CLOSE_ALT; ?>', 'id':key+'buttonarrow', 'title': '<?php echo $LNG->WIDGET_OPEN_CLOSE_HINT; ?>', 'src': '<?php echo $HUB_FLM->getImagePath("arrow-up2.png"); ?>'});
	Event.observe(widgetHeaderControlButton2,'click',function (){toggleWidget(this, key, height)});
	widgetInnerHeaderControl.insert(widgetHeaderControlButton2);

	widgetHeader.insert(widgetInnerHeaderControl);
	widgetDiv.insert(widgetHeader);

	var widgetBody = new Element("div", {'class':'widgetbody', 'id':key+"body"});
	widgetBody.style.background = 'white';
	widgetBody.style.height = (height-42)+"px";
	widgetBody.update(getLoading("(<?php echo $LNG->WIDGET_LOADING; ?> "+title+"...)"));
	widgetDiv.insert(widgetBody);

	// If the theme has an & or something it all goes horribly wrong when eventually calling window.open.
	// The below code deals with that.
	var decodedTheme = htmlspecialchars_decode(theme);
	var encodedTheme = escape(encodeURIComponent(decodedTheme));

	if (USER != "") {
		var toolbar = new Element("div", {'class':'widgetheaderinner', 'style':'padding-top:0px;'});

		var model = HUB_DATAMODEL.nodeToTheme;
		var linktypename = model.linktypes;
		var focalnodeend = model.direction;
		var filternodetypes = nodetype;

		if (nodetype == 'Claim') {
			var hint = '<?php echo $LNG->EXPLORE_THEME_HINT_CLAIM; ?>';
			toolbar.insert('<a title="'+hint+'" href="javascript: loadDialog(\'claimconnect\', \''+URL_ROOT+'ui/popups/claimconnect.php?linktypename='+linktypename+'&focalnodeid='+nodeid+'&focalnodeend='+focalnodeend+'&filternodetypes='+filternodetypes+'&handler='+handler+'&theme='+encodedTheme+'\', 840,600);"><img style="vertical-align:bottom" src="<?php echo $HUB_FLM->getImagePath('add.png'); ?>" alt="" /> <?php echo $LNG->WIDGET_ADD_LINK; ?></a>');
		} else if (nodetype == 'Solution') {
			var hint = '<?php echo $LNG->EXPLORE_THEME_HINT_SOLUTION; ?>';
			toolbar.insert('<a title="'+hint+'" href="javascript: loadDialog(\'solutionconnect\', \''+URL_ROOT+'ui/popups/solutionconnect.php?linktypename='+linktypename+'&focalnodeid='+nodeid+'&focalnodeend='+focalnodeend+'&filternodetypes='+filternodetypes+'&handler='+handler+'&theme='+encodedTheme+'\', 840,600);"><img style="vertical-align:bottom" src="<?php echo $HUB_FLM->getImagePath('add.png'); ?>" alt="" /> <?php echo $LNG->WIDGET_ADD_LINK; ?></a>');

		<?php if ( $CFG->issuesManaged == false || ($CFG->issuesManaged == true && $USER->getIsAdmin() == "Y") ) { ?>
		} else if (nodetype == 'Issue') {
			var hint = '<?php echo $LNG->EXPLORE_THEME_HINT_ISSUE; ?>';
			var link = URL_ROOT+'ui/popups/issueconnect.php?linktypename='+linktypename+'&focalnodeid='+nodeid+'&focalnodeend='+focalnodeend+'&filternodetypes='+filternodetypes+'&handler='+handler+'&theme='+encodedTheme;
			toolbar.insert('<a title="'+hint+'" href="javascript: loadDialog(\'issueconnect\', \''+link+'\', 840,600);"><img style="vertical-align:bottom" src="<?php echo $HUB_FLM->getImagePath('add.png'); ?>" alt="" /> <?php echo $LNG->WIDGET_ADD_LINK; ?></a>');
		<?php } ?>

		} else if (nodetype == 'Challenge') {
			var hint = '<?php echo $LNG->EXPLORE_THEME_HINT_CHALLENGE; ?>';
			toolbar.insert('<a title="'+hint+'" href="javascript: loadDialog(\'challengeconnect\', \''+URL_ROOT+'ui/popups/challengeconnect.php?linktypename='+linktypename+'&focalnodeid='+nodeid+'&focalnodeend='+focalnodeend+'&filternodetypes='+filternodetypes+'&handler='+handler+'&theme='+encodedTheme+'\', 840,600);"><img style="vertical-align:bottom" src="<?php echo $HUB_FLM->getImagePath('add.png'); ?>" alt="" /> <?php echo $LNG->WIDGET_ADD_LINK; ?></a>');
		} else if (nodetype == 'Project') {
			var hint = '<?php echo $LNG->EXPLORE_THEME_HINT_PROJECT; ?>';
			toolbar.insert('<a title="'+hint+'" href="javascript: loadDialog(\'projectconnect\', \''+URL_ROOT+'ui/popups/organizationconnect.php?linktypename='+linktypename+'&focalnodeid='+nodeid+'&focalnodeend='+focalnodeend+'&filternodetypes='+filternodetypes+'&handler='+handler+'&theme='+encodedTheme+'\', 840,750);"><img style="vertical-align:bottom" src="<?php echo $HUB_FLM->getImagePath('add.png'); ?>" alt="" /> <?php echo $LNG->WIDGET_ADD_LINK; ?></a>');
		} else if (nodetype == 'Organization') {
			var hint = '<?php echo $LNG->EXPLORE_THEME_HINT_ORG; ?>';
			toolbar.insert('<a title="'+hint+'" href="javascript: loadDialog(\'orgconnect\', \''+URL_ROOT+'ui/popups/organizationconnect.php?linktypename='+linktypename+'&focalnodeid='+nodeid+'&focalnodeend='+focalnodeend+'&filternodetypes='+filternodetypes+'&handler='+handler+'&theme='+encodedTheme+'\', 840,750);"><img style="vertical-align:bottom" src="<?php echo $HUB_FLM->getImagePath('add.png'); ?>" alt="" /> <?php echo $LNG->WIDGET_ADD_LINK; ?></a>');
		} else if (nodetype == 'Organization,Project') {
			var hint = '<?php echo $LNG->EXPLORE_THEME_HINT_ORGPROJECT; ?>';
			toolbar.insert('<a title="'+hint+'" href="javascript: loadDialog(\'orgconnect\', \''+URL_ROOT+'ui/popups/organizationconnect.php?linktypename='+linktypename+'&focalnodeid='+nodeid+'&focalnodeend='+focalnodeend+'&filternodetypes='+filternodetypes+'&handler='+handler+'&theme='+encodedTheme+'\', 840,750);"><img style="vertical-align:bottom" src="<?php echo $HUB_FLM->getImagePath('add.png'); ?>" alt="" /> <?php echo $LNG->WIDGET_ADD_LINK; ?></a>');
		} else if (nodetype == RESOURCE_TYPES_STR) {
			var hint = '<?php echo $LNG->EXPLORE_THEME_HINT_RESOURCE; ?>';
			toolbar.insert('<a title="'+hint+'" href="javascript: loadDialog(\'resourceconnect\', \''+URL_ROOT+'ui/popups/resourceconnect.php?linktypename='+linktypename+'&focalnodeid='+nodeid+'&focalnodeend='+focalnodeend+'&filternodetypes='+filternodetypes+'&handler='+handler+'&theme='+encodedTheme+'\', 840,600);"><img style="vertical-align:bottom" src="<?php echo $HUB_FLM->getImagePath('add.png'); ?>" alt="" /> <?php echo $LNG->WIDGET_ADD_LINK; ?></a>');
		} else if (nodetype == EVIDENCE_TYPES_STR) {
			var hint = '<?php echo $LNG->EXPLORE_THEME_HINT_EVIDENCE; ?>';
			toolbar.insert('<a title="'+hint+'" href="javascript: loadDialog(\'evidenceconnect\', \''+URL_ROOT+'ui/popups/evidenceconnect.php?linktypename='+linktypename+'&focalnodeid='+nodeid+'&focalnodeend='+focalnodeend+'&filternodetypes='+filternodetypes+'&handler='+handler+'&theme='+encodedTheme+'\', 840,600);"><img style="vertical-align:bottom" src="<?php echo $HUB_FLM->getImagePath('add.png'); ?>" alt="" /> <?php echo $LNG->WIDGET_ADD_LINK; ?></a>');
		}

		widgetHeader.insert(toolbar);
	} else {
		var toolbar = new Element("div", {'class':'widgetheaderinner', 'style':'padding-top:0px;'});
		let alink = '<span style="cursor:pointer" onclick="$(\'loginsubmit\').click(); return true;" title="';
		alink += "<?php echo $LNG->WIDGET_SIGNIN_HINT; ?>";
		alink += '"><img style="vertical-align:bottom" src="<?php echo $HUB_FLM->getImagePath('addgrey.png'); ?>" alt="" /> <?php echo $LNG->WIDGET_ADD_LINK; ?></span>';
		toolbar.insert(alink);
		widgetHeader.insert(toolbar);
	}

	if (isOpen) {
		widgetBody.style.display = 'flex';
		widgetHeaderControlButton2.src='<?php echo $HUB_FLM->getImagePath("arrow-up2.png"); ?>';
	} else {
		widgetBody.style.display = 'none';
		widgetDiv.style.height =  widgetHeader.style.height;
		widgetHeaderControlButton2.src='<?php echo $HUB_FLM->getImagePath("arrow-down2.png"); ?>';
	}

	// LOAD DATA
	var reqUrl = SERVICE_ROOT + "&method=gettypeconnectionsbytheme&style=long";
	reqUrl += "&theme="+encodeURIComponent(decodedTheme)+"&type="+nodetype+"&scope=all&start=0&max=-1";
	new Ajax.Request(reqUrl, { method:'post',
  		onSuccess: function(transport){
  			var json = transport.responseText.evalJSON();
			if(json.error){
				alert(json.error[0].message);
				return;
			}
			var conns = json.connectionset[0].connections;
			widgetBody.update("");

			if (conns.length == 0) {
				widgetBody.update("<?php echo $LNG->WIDGET_NONE_FOUND; ?>");
			} else {
				var nodes = new Array();
				var check = new Array();

				for(var i=0; i< conns.length; i++){
					var c = conns[i].connection;
					var fN = c.from[0].cnode;
					var tN = c.to[0].cnode;

					var fnRole = c.fromrole[0].role;
					var tnRole = c.torole[0].role;

					if (fN.name != "") {
						if (!check[fN.nodeid]) {
							var next = c.from[0];
							next.cnode['connection'] = c;
							next.cnode['nodetofocusid'] = nodetofocusid;
							next.cnode['handler'] = handler;
							nodes.push(next);
							check[fN.nodeid] = fN.nodeid;
						}
					}
				}

				if (nodes.length > 0){
					displayWidgetNodes(widgetBody,nodes,parseInt(0), true, key);
					widgetHeaderLabel.update("<span class='widgetcountlabel'>("+nodes.length+")</span>"+title);
				} else {
					widgetBody.update("<?php echo $LNG->WIDGET_NONE_FOUND; ?>");
				}
			}
		}
	});

	return widgetDiv;
}

function buildThemeWidget(nodeid,height,isOpen,key, title){

	var widgetDiv = new Element("div", {'class':'widgetdiv', 'id':key+"div"});
	widgetDiv.style.height = height+"px";

	var widgetHeader = buildWidgetHeader(title, height, isOpen, 'themewidgetback', key);
	widgetDiv.insert(widgetHeader);

	var widgetBody = new Element("div", {'class':'widgetbody', 'id':key+"body"});
	widgetBody.style.height = height+"px";
	widgetBody.style.background = 'white';
	widgetBody.update(getLoading("(<?php echo $LNG->WIDGET_LOADING; ?> "+title+"...)"));
	widgetDiv.insert(widgetBody);

	if (isOpen) {
		widgetBody.style.display = 'flex';
	} else {
		widgetBody.style.display = 'none';
		widgetDiv.style.height =  widgetHeader.style.height;
	}

	// If logged in, add theme adding facility
	var toolbar = new Element("div", {'class':'widgetheaderinner row'});
	var themeAdd = new Element("select", {'class':'form-select col ms-3', 'aria-label':'select a theme', 'id':'thememenu'+nodeid });
	if (USER == "") {
		themeAdd.disabled='true';
	}

	var option = new Element("option", {'value':''});
	option.insert('<?php echo $LNG->WIDGET_THEME_SELECT_OPTION; ?>');
	themeAdd.insert(option);

	for (var i=0; i< THEMES.length; i++) {
		var option = new Element("option", {'value':THEMES[i]});
		option.insert(THEMES[i]);
		themeAdd.insert(option);
	}

	var button = new Element("input", {'value':'<?php echo $LNG->WIDGET_ADD_BUTTON; ?>', 'type':'button', 'class':'btn btn-secondary col-auto'});
	if (USER != "") {
		Event.observe(button,"click", function(){
			var themename = $('thememenu'+nodeid).value;
			if (themename != "") {
				var reqUrl = SERVICE_ROOT + "&method=connectnodetotheme&nodeid="+nodeid+"&themename="+encodeURIComponent(themename);
				new Ajax.Request(reqUrl, { method:'get',
						onSuccess: function(transport){
							var json = transport.responseText.evalJSON();
							if(json.error){
								alert(json.error[0].message);
							} else {
								refreshWidgetThemes();
							}
						}
				});
			}
		});
	} else {
		button.style.color="dimgray";
		button.style.cursor="pointer";
		button.title="<?php echo $LNG->WIDGET_SIGNIN_HINT; ?>";
		Event.observe(button,"click", function(){
			$('loginsubmit').click();
			return true;
		});
	}
	toolbar.insert(themeAdd);
	toolbar.insert(button);

	widgetHeader.insert(toolbar);

	height = height-37;

	widgetBody.style.height = (height-30)+"px";

	var reqUrl = SERVICE_ROOT + "&method=getconnectionsbynode&style=short";
	reqUrl += "&orderby=vote&sort=DESC&filterlist=has main theme&filternodetypes=Theme&scope=all&start=0&max=-1&nodeid="+nodeid;

	new Ajax.Request(reqUrl, { method:'post',
  			onSuccess: function(transport){

  				var json = transport.responseText.evalJSON();
      			if(json.error){
      				alert(json.error[0].message);
      				return;
      			}

     			widgetBody.update("");

				var conns = json.connectionset[0].connections;
				if (conns.length == 0) {
					widgetBody.update("<?php echo $LNG->WIDGET_NO_RELATED_THEMES_FOUND; ?>");
				} else {
					var nodes = new Array();
					var check = new Array();

					for(var i=0; i< conns.length; i++){
						var c = conns[i].connection;
						var fN = c.from[0].cnode;
						var tN = c.to[0].cnode;

						var fnRole = c.fromrole[0].role;
						var tnRole = c.torole[0].role;

						if (fnRole.name == 'Theme') {
							if (fN.name != "") {
								if (!check[fN.nodeid]) {
									var next = c.from[0];
									next.cnode['connection'] = c;
									next.cnode['handler'] = 'refreshWidgetThemes';
									nodes.push(next);
									check[fN.nodeid] = fN.nodeid;
								}
							}
						} else if (tnRole.name == 'Theme') {
							if (tN.name != "") {
								if (!check[tN.nodeid]) {
									var next = c.to[0];
									next.cnode['connection'] = c;
									next.cnode['handler'] = 'refreshWidgetThemes';
									nodes.push(next);
									check[tN.nodeid] = tN.nodeid;
								}
							}
						}
					}

					if (nodes.length > 0){
						displayWidgetNodes(widgetBody,nodes,parseInt(0), true, key);
						$(key+"headerlabel").update("<span class='widgetcountlabel'>("+nodes.length+")</span>"+title);
					} else {
						widgetBody.update("<?php echo $LNG->WIDGET_NO_RELATED_THEMES_FOUND; ?>");
					}
				}
			}
	});

	return widgetDiv;
}

function buildNodeWidgetNew(node, height, type, key, color) {
	var creationdate = node.creationdate;
	var positivevotes = node.positivevotes;
	var negativevotes = node.negativevotes;
	var userimage = node.users[0].thumb;
	var nodeid = node.nodeid;
	var name = node.name;
	var nodetype = node.role.name;
	var title=getNodeTitleAntecedence(nodetype);
	//if (RESOURCE_TYPES_STR.indexOf(nodetype) != -1) {
	if (type == 'web') {
		name = node.description;
	}

	var username = node.users[0].name;
	var userid = node.users[0].userid;
	var userfollow = node.userfollow;
	var otheruserconnections = node.otheruserconnections;
	var icon = URL_ROOT+node.role.image;

	var widgetDiv = new Element("div", {'class':'widgetdivnode', 'id':key+'div'});
	widgetDiv.style.height = "0px";
	var widgetBody = new Element("div", {'class':'widgetnodebody', 'id':key+'body'});
	widgetBody.style.height = "0px";
	var widgetHeader = new Element("div", {'id':key+'header', 'class':'widgetheadernode'});
	widgetDiv.insert(widgetHeader);

	buildWidgetExploreNodeHeader(widgetHeader, title+name, color, type, icon, height, key);

	var toolbar = new Element("div", {'class':'nodewidgettoolbar'});

	if (type != "news") {
		buildExploreToolbar(toolbar, title+name, type, node, 'explore');
		widgetHeader.insert(toolbar);
	}

	var spacer = new Element("hr", {'class':'widgetnodespacer'});
	widgetBody.appendChild(spacer);

	var innerwidgetBody = new Element("div", {'id':key+'innerbody', 'class':'widgetnodeinnerbody'});
	innerwidgetBody.style.height = "0px";

	var userbar = new Element("div", {'style':'float:left;clear:both;margin-bottom:5px;'} );
	var iuDiv = new Element("div", {'class':'idea-user2', 'style':'clear:both;float:left;'});
	var userimageThumb = new Element('img',{'alt':username, 'title': username, 'style':'padding-right:5px;', 'src': userimage});

	var imagelink = new Element('a', {'href':URL_ROOT+"user.php?userid="+userid, 'title':username});

	imagelink.insert(userimageThumb);
	iuDiv.update(imagelink);
	userbar.appendChild(iuDiv);

	var iuDiv = new Element("div", {'style':'float:left;margin-right:20px;'});
	var cDate = new Date(creationdate*1000);
	iuDiv.insert("<b><?php echo $LNG->NODE_ADDED_ON; ?> </b>"+ cDate.format(DATE_FORMAT) + "<br/>");
	iuDiv.insert('<b><?php echo $LNG->NODE_ADDED_BY; ?> </b>'+username+'<br/>');
	userbar.insert(iuDiv);

	innerwidgetBody.appendChild(userbar);

	if (node.imageurlid && node.imageurlid != "") {
		var iuDiv = new Element("div", {'style':'float:left'});
		var nodeimage = new Element("img", {'id':key+'nodeimg', 'src':node.imageurlid});
		iuDiv.insert(nodeimage);
		userbar.insert(iuDiv);
	}

	var detailbar = new Element("div", {'style':'float:left;clear:both;margin:0px;padding:0px;'} );
	innerwidgetBody.insert(detailbar);

	if (node.startdatetime && node.startdatetime != "" && node.role.name == 'Project') {
		var sDate = new Date(node.startdatetime*1000);
		detailbar.insert('<br /><b><?php echo $LNG->FORM_LABEL_PROJECT_STARTED_DATE; ?> </b>'+sDate.format(DATE_FORMAT_PROJECT)+'<br>');
		if (node.enddatetime && node.enddatetime != "") {
			var eDate = new Date(node.enddatetime*1000);
			detailbar.insert('<b><?php echo $LNG->FORM_LABEL_PROJECT_ENDED_DATE; ?> </b>'+eDate.format(DATE_FORMAT_PROJECT)+'<br>');
		}
	}

	if (node.identifier && node.identifier != "" && node.role.name == 'Publication') {
		detailbar.insert('<b><?php echo $LNG->FORM_LABEL_DOI; ?> </b><span>'+node.identifier+'</span><br />');
	}
	if (node.locationaddress1 && node.locationaddress1 != "") {
		detailbar.insert('<span style="float:left;font-weight:bold;width:83px;"><?php echo $LNG->FORM_LABEL_ADDRESS1; ?> </span><span>'+node.locationaddress1+'</span><br />');
	}
	if (node.locationaddress2 && node.locationaddress2 != "") {
		detailbar.insert('<span style="float:left;font-weight:bold;width:83px;"><?php echo $LNG->FORM_LABEL_ADDRESS2; ?> </span><span>'+node.locationaddress2+'</span><br />');
	}
	if (node.location && node.location != "") {
		detailbar.insert('<span style="float:left;font-weight:bold;width:83px;"><?php echo $LNG->FORM_LABEL_TOWN; ?> </span><span>'+node.location+'</span><br />');
	}
	if (node.locationpostcode && node.locationpostcode != "") {
		detailbar.insert('<span style="float:left;font-weight:bold;width:83px;"><?php echo $LNG->FORM_LABEL_POSTAL_CODE; ?> </span><span>'+node.locationpostcode+'</span><br />');
	}
	if (node.country && node.country != "") {
		detailbar.insert('<span style="float:left;font-weight:bold;width:83px;"><?php echo $LNG->FORM_LABEL_COUNTRY; ?> </span><span>'+node.country+'</span><br/>');
	}

 	// add url if a resource node
	if (type == 'web') {
		detailbar.insert('<span style="margin-right:5px;"><b><?php echo $LNG->NODE_URL_HEADING; ?> </b></span>');
		var link = new Element("a", {'href':node.name,'target':'_blank','title':'<?php echo $LNG->NODE_RESOURCE_LINK_HINT; ?>'} );
		link.insert(node.name);
		link.insert('<br />');
		detailbar.insert(link);

 		if (node.urls && node.urls.length > 0) {
 			var hasClips = false;
			var iUL = new Element("ul", {'style':'margin-top:0px;margin-bottom:0px;'});
			for (var i=0 ; i< node.urls.length; i++){
				if (node.urls[i].clip && node.urls[i].clip != "") {
					var link = new Element("li");
					link.insert(node.urls[i].clip);
					iUL.insert(link);
					hasClips = true;
				}
				if (node.urls[i].identifier) {
				 	detailbar.insert('<br><span style="margin-right:5px;"><b><?php echo $LNG->FORM_LABEL_DOI; ?></b></span> <span>'+node.urls[i].identifier+'</span>');
				}
			}

			if (hasClips) {
				detailbar.insert('<br><span style="margin-right:5px;"><b><?php echo $LNG->NODE_RESOURCE_CLIPS_HEADING; ?> </b></span>');
			}

			detailbar.insert('<br />');
 			detailbar.insert(iUL);
		}
	}

	//tags
	if(node.tags && node.tags.length > 0){
		var grpStr = "<b><?php echo $LNG->NODE_TAGS_HEADING; ?> </b>";
		for (var i=0 ; i< node.tags.length; i++){
			var tag = null;
			if (node.tags[i].name) {
				tag = node.tags[i];
			} else {
				tag = node.tags[i].tag
			}
			grpStr += '<a href="'+URL_ROOT+'search.php?q='+tag.name+'&fromid='+node.nodeid+'&scope=all&tagsonly=true">'+tag.name+'</a>';
			if (i < node.tags.length-1) {
				grpStr += ',';
			}
		}

		grpStr += '<br />';
		detailbar.insert(grpStr);
	}

	if (type != 'web' && type != "theme") {
		var commentdiv = new Element("div", { 'id':'commentdiv', 'name':'commentdiv', 'style':'clear:both;background:transparent;float:left;padding:0px;margin:0px;margin-bottom:5px;'});
		detailbar.insert(commentdiv);
		childcommentload(commentdiv, node.nodeid,"<?php echo $CFG->LINK_COMMENT_BUILT_FROM; ?>", COMMENT_TYPES+",Idea", 'commentchild', '');
	}

	if (node.description && node.description != "" && type != 'web') {
		var dStr = '<div style="margin:0px;padding=0px;margin-top:3px;" class="idea-desc"><span style="margin-top: 5px;"><b><?php echo $LNG->NODE_DESC_HEADING; ?> </b></span><br>';
		dStr += node.description;
		dStr += '</div>';
		detailbar.insert(dStr);
	}

	widgetBody.insert(innerwidgetBody);
	widgetDiv.insert(widgetBody);

	return widgetDiv;
}

function buildNodeWidgetForNews(node, height, type, key, color) {
	var creationdate = node.creationdate;
	var userimage = node.users[0].thumb;
	var nodeid = node.nodeid;
	var name = node.name;
	var nodetype = node.role.name;
	var title=getNodeTitleAntecedence(nodetype);

	var username = node.users[0].name;
	var userid = node.users[0].userid;
	var userfollow = node.userfollow;
	var otheruserconnections = node.otheruserconnections;
	var icon = URL_ROOT+node.role.image;

	var widgetDiv = new Element("div", {'class':'widgetdivnode', 'id':key+'div'});
	widgetDiv.style.height = "0px";
	var widgetBody = new Element("div", {'class':'widgetnodebody', 'id':key+'body'});
	widgetBody.style.height = "0px";
	var widgetHeader = new Element("div", {'id':key+'header', 'class':'widgetheadernode'});
	widgetDiv.insert(widgetHeader);

	buildWidgetExploreNodeHeader(widgetHeader, title+name, color, type, icon, height, key);

	var innerwidgetBody = new Element("div", {'id':key+'innerbody', 'class':'widgetnodeinnerbody'});
	innerwidgetBody.style.height = "0px";

	var userbar = new Element("div", {'style':'clear:both;margin-bottom:5px;'} );
	var iuDiv = new Element("div", {'style':''});
	var cDate = new Date(creationdate*1000);
	iuDiv.insert("<b><?php echo $LNG->NODE_NEWS_POSTED_ON; ?> </b>"+ cDate.format(DATE_FORMAT) + "<br/>");
	userbar.insert(iuDiv);

	innerwidgetBody.appendChild(userbar);

	if (node.description && node.description != "" && type != 'web') {
		var dStr = '<div style="margin:0px;padding=0px;" class="idea-desc">';
		dStr += node.description;
		dStr += '</div>';
		innerwidgetBody.insert(dStr);
	}

	widgetBody.insert(innerwidgetBody);
	widgetDiv.insert(widgetBody);

	return widgetDiv;
}

function buildNodeWidgetNewShort(node, type, key, color, border) {

	var	includemenu = true;
	var role = null;
	if(node.role[0] === undefined){
		role = node.role;
	} else {
		role = node.role[0].role;
	}

	var icon = role.image;
	var nodeid = node.nodeid;
	var name = node.name;
	if (type == 'resource') {
		name = node.description;
	}

	var nodetype = role.name;
	var title=getNodeTitleAntecedence(nodetype, false);

	var widgetDiv = new Element("div", {'class':'widgetdivnode active', 'id':key+'shortdiv', 'title':'<?php echo $LNG->WIDGET_FOCUS_NODE_HINT; ?>'});

	var widgetHeader = new Element("div", {'id':key+'shortheader', 'class':'widgetheadernode'});
	widgetDiv.insert(widgetHeader);

	var widgetHeader2 = new Element("div", { 'class':'widgetheadernode '+border+' '+color, 'id':'shortwidgetnodeheader'});

	var widgetInnerHeader = new Element("div", {'class':'widgetheaderinnernode active', 'id':'shortwidgetnodeheaderinner', 'Style':'width:90%', 'title':'<?php echo $LNG->WIDGET_FOCUS_NODE_HINT; ?>'});
	var widgetHeaderLabel = new Element("label", {'class':'widgetnodeheaderlabel2 widgettextcolor active', 'id':'shortwidgetnodeheaderlabellinear', 'title':'<?php echo $LNG->WIDGET_FOCUS_NODE_HINT; ?>'});
	if (node.nodeid == nodeObj.nodeid) {
		widgetHeaderLabel.style.color = 'white';
	}

	widgetInnerHeader.insert(widgetHeaderLabel);

	if (icon) {
		icon = URL_ROOT+icon
		var iconObj = new Element('img',{'style':'text-align: middle;margin-right: 5px; width:24px; height:24px;', 'title':title, 'alt':type+' <?php echo $LNG->WIDGET_ICON_ALT; ?>', 'src':icon});
		iconObj.align='left';
		widgetHeaderLabel.appendChild(iconObj);
	}

	widgetHeaderLabel.insert(name);
	widgetHeader2.insert(widgetInnerHeader);

	Event.observe(widgetDiv,'click',function () {
		var width = getWindowWidth()-20;
		var height = getWindowHeight()-20;
		loadDialog('details', URL_ROOT+"explore.php?id="+node.nodeid, width, height);
	});
	Event.observe(widgetInnerHeader,'click',function () {
		var width = getWindowWidth()-20;
		var height = getWindowHeight()-20;
		loadDialog('details', URL_ROOT+"explore.php?id="+node.nodeid, width, height);
	});
	Event.observe(widgetHeaderLabel,'click',function () {
		var width = getWindowWidth()-20;
		var height = getWindowHeight()-20;
		loadDialog('details', URL_ROOT+"explore.php?id="+node.nodeid, width, height);
	});

	widgetDiv.insert(widgetHeader2);

	return widgetDiv;
}

function buildThemeSuggestionByType(nodeid, type, title, height, isOpen, color, key) {

	var widgetDiv = new Element("div", {'class':'widgetdiv', 'id':key+"div"});
	widgetDiv.style.height = height+"px";

	/*****************/

	var widgetHeader = new Element("div", {'class':'widgetheader row m-0 p-0 '+color, 'id':key+"header"});

	var widgetHeaderControlButton = new Element('img',{ 'style':'display: none; cursor: pointer;', 'alt':'<?php echo $LNG->WIDGET_RESIZE_ITEM_ALT; ?>', 'id':key+'buttonresize', 'title': '<?php echo $LNG->WIDGET_RESIZE_ITEM_HINT; ?>', 'src': '<?php echo $HUB_FLM->getImagePath("enlarge2.gif"); ?>'});
	Event.observe(widgetHeaderControlButton,'click',function (){toggleExpandWidget(this, key, height)});

	var widgetInnerHeader = new Element("div", {'class':'widgetheaderinner col', 'id':key+"headerinner", 'title':'<?php echo $LNG->WIDGET_EXPAND_HINT; ?>'});

	var widgetHeaderLabel = new Element("label", {'class':'widgetheaderlabel widgettextcolor ', 'id':key+"headerlabel"});
	widgetHeaderLabel.insert(title);

	widgetInnerHeader.insert(widgetHeaderLabel);
	widgetHeader.insert(widgetInnerHeader);

	var widgetInnerHeaderControl = new Element("div", {'class':'widgetheadercontrol col-auto '});

	widgetInnerHeaderControl.insert(widgetHeaderControlButton);

	var widgetHeaderControlButton2 = new Element('img',{ 'style':'display: none; cursor: pointer;', 'alt':'<?php echo $LNG->WIDGET_OPEN_CLOSE_ALT; ?>', 'id':key+'buttonarrow', 'title': '<?php echo $LNG->WIDGET_OPEN_CLOSE_HINT; ?>', 'src': '<?php echo $HUB_FLM->getImagePath("arrow-up2.png"); ?>'});
	Event.observe(widgetHeaderControlButton2,'click',function (){toggleWidget(this, key, height)});
	widgetInnerHeaderControl.insert(widgetHeaderControlButton2);

	widgetHeader.insert(widgetInnerHeaderControl);

	if (isOpen) {
		widgetHeaderControlButton2.src='<?php echo $HUB_FLM->getImagePath("arrow-up2.png"); ?>';
	} else {
		widgetHeaderControlButton2.src='<?php echo $HUB_FLM->getImagePath("arrow-down2.png"); ?>';
	}

	widgetDiv.insert(widgetHeader);

	/*******************/

	var widgetBody = new Element("div", {'class':'widgetbody', 'id':key+"body"});
	widgetBody.style.background = "white";
	widgetBody.style.height = height+"px";
	widgetDiv.insert(widgetBody);

	var toolbar = new Element("div", {'class':'widgetheaderinner', 'style':'padding-top:0px;'});

	var loadButton = new Element("a", {'id':key+'loadbutton','href':'javascript:void(0)','title':'load '+title});
	loadButton.insert('load');
	Event.observe(loadButton,'click', function () {
		loadThemeSuggestionByType(nodeid, type, title, height, key);
	});

	widgetHeaderLabel.update("( ");
	widgetHeaderLabel.insert(loadButton);
	widgetHeaderLabel.insert(" ) "+title);

	widgetHeader.insert(toolbar);

	if (isOpen) {
		widgetBody.style.display = 'flex';
	} else {
		widgetBody.style.display = 'none';
		widgetDiv.style.height =  widgetHeader.style.height;
	}

	return widgetDiv;
}

function loadThemeSuggestionByType(nodeid, type, title, height, key) {

	$(key+"body").update(getLoading("(<?php echo $LNG->WIDGET_LOADING; ?> "+title+"...)"));
	$(key+"headerlabel").update(title+"<span class='margin-left:5px'>( <?php $LNG->WIDGET_LOADING; ?>.. )</span>");

	$(key+'buttonarrow').style.display = 'inline';
	$(key+'buttonresize').style.display = 'inline';

	Event.observe($(key+"headerinner"),'mouseover',function (){$(key+"headerinner").style.cursor = 'pointer'});
	Event.observe($(key+"headerinner"),'mouseout',function (){$(key+"headerinner").style.cursor = 'normal'});
	Event.observe($(key+"headerinner"),'click',function (){toggleExpandWidget($(key+'buttonresize'), key, height)});

	/* LOAD DATA */
	var reqUrl = SERVICE_ROOT + "&method=getconnectionsbypathbydepth&style=short";
	reqUrl += "&depth=2&labelmatch=true&scope=all&start=0&max=-1&nodeid="+nodeid;

	reqUrl += "&linklabels[]=";
	reqUrl += "&linklabels[]=";

	reqUrl += "&nodetypes[]="+encodeURIComponent('Theme');
	reqUrl += "&nodetypes[]="+encodeURIComponent(type);

	reqUrl += "&directions[]="+encodeURIComponent('outgoing');
	reqUrl += "&directions[]="+encodeURIComponent('both');

	reqUrl += "&linkgroups[]="+encodeURIComponent('All');
	reqUrl += "&linkgroups[]="+encodeURIComponent('All');

	new Ajax.Request(reqUrl, { method:'post',
  		onSuccess: function(transport){
  			var json = transport.responseText.evalJSON();
			if(json.error){
				alert(json.error[0].message);
				return;
			}
			var conns = json.connectionset[0].connections;
			$(key+"body").update("");

			if (conns.length == 0) {
				$(key+"headerlabel").update("<span class='widgetcountlabel'>(0)</span>"+title);
				$(key+"body").update("<?php echo $LNG->WIDGET_NONE_FOUND; ?>");
			} else {
				var nodes = new Array();
				var check = new Array();
				var themes = new Array();

				for(var i=0; i< conns.length; i++){
					var c = conns[i].connection;
					var fN = c.from[0].cnode;
					var tN = c.to[0].cnode;

					var fnRole = c.fromrole[0].role;
					var tnRole = c.torole[0].role;

					if (type.indexOf(fnRole.name) != -1) {
						if (fN.name != "") {
							if (!check[fN.nodeid]) {
								c.from[0].cnode.connection = c;
								nodes.push(c.from[0]);
								check[fN.nodeid] = fN.nodeid;
								themes[fN.nodeid] = tN.name;
							} else {
								if (themes[fN.nodeid].indexOf(tN.name) == -1) {
									themes[fN.nodeid] = themes[fN.nodeid]+", "+tN.name;
								}
							}

						}
					} else if (type.indexOf(tnRole.name) != -1) {
						if (tN.name != "") {
							if (!check[tN.nodeid]) {
								c.to[0].cnode.connection = c;
								nodes.push(c.to[0]);
								check[tN.nodeid] = tN.nodeid;
								themes[fN.nodeid] = fN.name;
							} else {
								if (themes[fN.nodeid].indexOf(fN.name) == -1) {
									themes[fN.nodeid] = themes[fN.nodeid]+", "+fN.name;
								}
							}
						}
					}
				}


				for(var i=0; i< nodes.length; i++){
					var node = nodes[i];
					node.cnode['commonthemes'] = themes[node.cnode.nodeid];
				}

				if (nodes.length > 0) {
					displayWidgetNodes($(key+"body"),nodes,parseInt(0), true, key);
					$(key+"headerlabel").update("<span class='widgetcountlabel'>("+nodes.length+")</span>"+title);
				} else {
					$(key+"headerlabel").update("<span class='widgetcountlabel'>(0)</span>"+title);
					$(key+"body").update("<?php echo $LNG->WIDGET_NONE_FOUND; ?>");
				}
			}
		}
	});
}


function buildEvidenceWidget(nodeid, title, nodetype, linktype, height, isOpen, key, nodetofocusid) {

	var widgetDiv = new Element("div", {'class':'widgetdiv', 'id':key+"div"});
	widgetDiv.style.height = height+"px";

	var icon = null;
	if (nodetype == 'Pro') {
		var model = HUB_DATAMODEL.pro;
		icon = model.icon
	} else {
		var model = HUB_DATAMODEL.con;
		icon = model.icon
	}

	var widgetHeader = buildWidgetHeader(title, height, isOpen, 'evidencewidgetback', key, icon);
	widgetDiv.insert(widgetHeader);

	var widgetBody = new Element("div", {'class':'widgetbody', 'id':key+"body"});
	widgetBody.style.background = "white";
	widgetBody.style.height = height+"px";
	widgetBody.update(getLoading("(<?php echo $LNG->WIDGET_LOADING_EVIDENCE; ?>)"));
	widgetDiv.insert(widgetBody);

	if (isOpen) {
		widgetBody.style.display = 'flex';
	} else {
		widgetBody.style.display = 'none';
		widgetDiv.style.height =  widgetHeader.style.height;
	}

	/* IF LOGGED IN, ADD EDITING ELEMENTS */
	if (USER != "") {
		var toolbar = new Element("div", {'class':'widgetheaderinner', 'style':'padding-top:0px;'});
		toolbar.insert('<a title="<?php echo $LNG->WIDGET_EVIDENCE_ADD_HINT; ?>" href="javascript: loadDialog(\'evidenceconnect\', \''+URL_ROOT+'ui/popups/evidenceconnect.php?linknodetypename='+nodetype+'&linktypename='+linktype+'&focalnodeid='+nodeid+'&focalnodeend=to&filternodetypes='+EVIDENCE_TYPES+'&handler=refreshWidgetEvidence&type='+nodetype+'\', 840,600);" ><img style="vertical-align:bottom" src="<?php echo $HUB_FLM->getImagePath('add.png'); ?>" alt="" /> <?php echo $LNG->WIDGET_ADD_LINK; ?></a>');
		widgetHeader.insert(toolbar);
	} else {
		var toolbar = new Element("div", {'class':'widgetheaderinner', 'style':'padding-top:0px;'});
		let spancontent = '<span style="cursor:pointer" onclick="$(\'loginsubmit\').click(); return true;" title="';
		spancontent += "<?php echo $LNG->WIDGET_SIGNIN_HINT; ?>";
		spancontent += '"><img style="vertical-align:bottom" src="<?php echo $HUB_FLM->getImagePath('addgrey.png'); ?>" alt="" /> <?php echo $LNG->WIDGET_ADD_LINK; ?></span>';
		toolbar.insert(spancontent);
		widgetHeader.insert(toolbar);
	}

	/* LOAD DATA */
	var reqUrl = SERVICE_ROOT + "&method=getconnectionsbynode&style=short";
	reqUrl += "&orderby=vote&sort=DESC&filterlist="+linktype+"&filternodetypes="+nodetype+"&scope=all&start=0&max=-1&nodeid="+nodeid;

	//alert("widget:"+reqUrl);

	new Ajax.Request(reqUrl, { method:'post',
  		onSuccess: function(transport){
  			var json = transport.responseText.evalJSON();
			if(json.error){
				alert(json.error[0].message);
				return;
			}
			var conns = json.connectionset[0].connections;
			widgetBody.update("");

			if (conns.length == 0) {
				widgetBody.update("<?php echo $LNG->WIDGET_NONE_FOUND; ?>");
			} else {
				var nodes = new Array();
				for(var i=0; i< conns.length; i++){
					var c = conns[i].connection;
					var fN = c.from[0].cnode;
					var tN = c.to[0].cnode;

					var fnRole = c.from[0].cnode.role[0].role; // c.fromrole[0].role;
					var tnRole = c.to[0].cnode.role[0].role; //c.torole[0].role;

					if (fN.nodeid != nodeid && EVIDENCE_TYPES_STR.indexOf(fnRole.name) != -1) {
						if (fN.name != "" && tN.nodeid == nodeid) {
							var next = c.from[0];
							next.cnode['parentid'] = nodeid;
							next.cnode['connection'] = c;
							next.cnode['nodetofocusid'] = nodetofocusid;
							next.cnode['handler'] = 'refreshWidgetEvidence(\''+nodetofocusid+'\', \''+nodetype+'\')';
							nodes.push(next);
						}
					}
				}

				if (nodes.length > 0){
					displayWidgetNodes(widgetBody,nodes,parseInt(0), true, key);
					$(key+"headerlabel").update("<span class='widgetcountlabel'>("+nodes.length+")</span>"+title);
				} else {
					widgetBody.update("<?php echo $LNG->WIDGET_NONE_FOUND; ?>");
				}
			}
		}
	});

	return widgetDiv;
}

function buildRelatedResourcesWidget(nodeid, title, url, height, isOpen, key) {

	var widgetDiv = new Element("div", {'class':'widgetdiv', 'id':key+"div"});
	widgetDiv.style.height = height+"px";

	// just need the Resource Icon so any model item with a resource icon will do.
	var model = HUB_DATAMODEL.evidenceToResource;
	var icon = model.icon

	var widgetHeader = buildWidgetHeader(title, height, isOpen, 'resourcewidgetback', key, icon);
	widgetDiv.insert(widgetHeader);

	var widgetBody = new Element("div", {'class':'widgetbody', 'id':key+"body"});
	widgetBody.style.background = "white";
	widgetBody.style.height = height+"px";
	widgetBody.update(getLoading("(<?php echo $LNG->WIDGET_LOADING_RESOURCE; ?>)"));
	widgetDiv.insert(widgetBody);

	if (isOpen) {
		widgetBody.style.display = 'flex';
	} else {
		widgetBody.style.display = 'none';
		widgetDiv.style.height =  widgetHeader.style.height;
	}

	var parser = /^(?:([^:\/?]+):)?(?:\/\/([^\/?]*))?([^?]*)(?:\?([^\#]*))?(?:(.*))?/;
	var result = url.match(parser);
	var scheme    = result[1] || null;
	var authority = result[2] || null;

	var query = authority;

	/* LOAD DATA */
	var reqUrl = SERVICE_ROOT + "&method=getnodesbyglobal&style=long";
	reqUrl += "&orderby=name&sort=ASC&filternodetypes="+RESOURCE_TYPES_STR+"&scope=all&start=0&max=-1&q="+encodeURIComponent(query);

	//alert("widget:"+reqUrl);

	new Ajax.Request(reqUrl, { method:'post',
  		onSuccess: function(transport){
  			var json = transport.responseText.evalJSON();
			if(json.error){
				alert(json.error[0].message);
				return;
			}

			widgetBody.update("");
			var nodes = json.nodeset[0].nodes;
			if (nodes.length > 0) {
				//filter out parent node before displaying.
				var i=0;
				var count = nodes.length;
				var nodesfiltered = new Array();
				for (i=0; i<count; i++) {
					var node = nodes[i];
					if (nodeid != node.cnode.nodeid) {
						nodesfiltered[nodesfiltered.length] = node;
					}
				}
				if (nodesfiltered.length > 0) {
					displayWidgetNodes(widgetBody,nodesfiltered,parseInt(0), true, key);
					$(key+"headerlabel").update("<span class='widgetcountlabel'>("+nodesfiltered.length+")</span>"+title);
				} else  {
					widgetBody.update("<?php echo $LNG->WIDGET_NONE_FOUND; ?>");
				}
			} else {
				widgetBody.update("<?php echo $LNG->WIDGET_NONE_FOUND; ?>");
			}
		}
	});

	return widgetDiv;
}

function buildSeeAlsoWidget(nodeid, title, height, isOpen, color, key, nodetofocusid) {

	var model = HUB_DATAMODEL.nodeToSeeAlso
	var filternodetypes = model.getOtherEnd();
	var linktypename = model.linktypes;
	var focalnodeend = model.direction;
	var hint = model.hint;

	var widgetDiv = new Element("div", {'class':'widgetdiv', 'id':key+"div"});
	widgetDiv.style.height = height+"px";

	var widgetHeader = buildWidgetHeader(title, height, isOpen, color, key);
	widgetDiv.insert(widgetHeader);

	var widgetBody = new Element("div", {'class':'widgetbody', 'id':key+"body"});
	widgetBody.style.height = height+"px";
	widgetBody.style.background = "white";
	widgetBody.update(getLoading("(<?php echo $LNG->WIDGET_LOADING_SEE_ALSO; ?>)"));
	widgetDiv.insert(widgetBody);

	if (isOpen) {
		widgetBody.style.display = 'flex';
	} else {
		widgetBody.style.display = 'none';
		widgetDiv.style.height =  widgetHeader.style.height;
	}

	if (USER != "") {
		var toolbar = new Element("div", {'class':'widgetheaderinner', 'style':'padding-top:0px;'});
		var addButton = new Element("a", {'title':hint, 'href':'#'} );
		addButton.insert('<img style="vertical-align:bottom" src="<?php echo $HUB_FLM->getImagePath('add.png'); ?>" alt="" /> <?php echo $LNG->WIDGET_ADD_LINK; ?>');
		Event.observe(addButton,'click',function () {
			loadDialog('selector', URL_ROOT+"ui/popups/selector.php?handler=addSeeAlso&filternodetypes="+filternodetypes, 420, 730);
		});
		toolbar.insert(addButton);
		widgetHeader.insert(toolbar);
	} else {
		var toolbar = new Element("div", {'class':'widgetheaderinner', 'style':'padding-top:0px;'});
		let spancontent = '<span style="cursor:pointer" onclick="$(\'loginsubmit\').click(); return true;" title="';
		spancontent += "<?php echo $LNG->WIDGET_SIGNIN_HINT; ?>";
		spancontent += '"><img style="vertical-align:bottom" src="<?php echo $HUB_FLM->getImagePath('addgrey.png'); ?>" alt="" /> <?php echo $LNG->WIDGET_ADD_LINK; ?></span>';
		toolbar.insert(spancontent);
		widgetHeader.insert(toolbar);
	}


	/* LOAD DATA */
	var reqfilternodetypes = filternodetypes+",Comment";

	var reqUrl = SERVICE_ROOT + "&method=getconnectionsbynode&style=short";
	reqUrl += "&orderby=vote&sort=DESC&filterlist="+linktypename+"&filternodetypes="+reqfilternodetypes+"&scope=all&start=0&max=-1&nodeid="+nodeid;

	new Ajax.Request(reqUrl, { method:'post',
  		onSuccess: function(transport){
  			var json = transport.responseText.evalJSON();
			if(json.error){
				alert(json.error[0].message);
				return;
			}
			var conns = json.connectionset[0].connections;
			widgetBody.update("");

			if (conns.length == 0) {
				widgetBody.update("<?php echo $LNG->WIDGET_NONE_FOUND; ?>");
			} else {
				var nodes = new Array();
				for(var i=0; i< conns.length; i++){
					var c = conns[i].connection;
					var fN = c.from[0].cnode;
					var tN = c.to[0].cnode;

					var fnRole = c.from[0].cnode.role[0].role; // c.fromrole[0].role;
					var tnRole = c.to[0].cnode.role[0].role; //c.torole[0].role;

					if (fN.nodeid == nodeid && reqfilternodetypes.indexOf(tnRole.name) != -1) {
						if (tN.name != "") {
							var next = c.to[0];
							next.cnode['parentid'] = nodeid;
							next.cnode['connection'] = c;
							next.cnode['nodetofocusid'] = nodetofocusid;
							next.cnode['handler'] = 'refreshWidgetSeeAlso(\''+nodetofocusid+'\')';
							nodes.push(next);
						}
					} else if (tN.nodeid == nodeid && reqfilternodetypes.indexOf(fnRole.name) != -1) {
						if (fN.name != "") {
							var next = c.from[0];
							next.cnode['parentid'] = nodeid;
							next.cnode['connection'] = c;
							next.cnode['nodetofocusid'] = nodetofocusid;
							next.cnode['handler'] = 'refreshWidgetSeeAlso(\''+nodetofocusid+'\')';
							nodes.push(next);
						}
					}
				}

				if (nodes.length > 0){
					displayWidgetNodes(widgetBody,nodes,parseInt(0), true, key);
					$(key+"headerlabel").update("<span class='widgetcountlabel'>("+nodes.length+")</span>"+title);
				} else {
					widgetBody.update("<?php echo $LNG->WIDGET_NONE_FOUND; ?>");
				}
			}
		}
	});

	return widgetDiv;
}

function addSeeAlso(node) {

	// Cannot add self as see also.
	if (node.nodeid != nodeObj.nodeid) {

		var model = HUB_DATAMODEL.nodeToSeeAlso
		var linktypename = model.linktypes;

		var reqUrl = SERVICE_ROOT+"&method=addconnectionlinkname";
		reqUrl += "&private=N&linktypename="+linktypename+"&fromnodeid="+nodeObj.nodeid+"&fromroleid="+nodeObj.role.roleid+"&tonodeid="+node.nodeid+"&toroleid="+node.role[0].role.roleid;

		new Ajax.Request(reqUrl, { method:'get',
	  		onSuccess: function(transport){
				try {
					var json = transport.responseText.evalJSON();
					if(json.error){
						alert(json.error[0].message);
						return;
					}

					refreshWidgetSeeAlso(node.nodeid);

				} catch(err) {
					console.log(err);
				}
	    	}
	  	});
	}
}

/**
 * Create a widget list for the Organization node to Issues
 * @param nodeid the focal node connecting
 * @param title the title to show in the widget header.
 * @param height the height to draw the widget when open.
 * @param isOpen true if the widget is open, false if it is collapsed.
 * @param key the string which is an id to identify interface elements
 * @param nodetofocusid the id of a node in the results list to focus on.
 */
function buildOrgToIssueWidget(nodeid, title, height, isOpen, key, nodetofocusid) {
	var model = HUB_DATAMODEL.orgToIssue;
	return buildActiveConnectionWidget(nodeid, model, title, height, 'refreshWidgetIssues', isOpen, 'issuewidgetback', key, nodetofocusid);
}

/**
 * Create a widget list for the Organization node to Claims
 * @param nodeid the focal node connecting
 * @param title the title to show in the widget header.
 * @param height the height to draw the widget when open.
 * @param isOpen true if the widget is open, false if it is collapsed.
 * @param key the string which is an id to identify interface elements
 * @param nodetofocusid the id of a node in the results list to focus on.
 */
function buildOrgToClaimWidget(nodeid, title, height, isOpen, key, nodetofocusid) {
	var model = HUB_DATAMODEL.orgToClaim;
	return buildActiveConnectionWidget(nodeid, model, title, height, 'refreshWidgetClaims', isOpen, 'claimwidgetback', key, nodetofocusid);
}

/**
 * Create a widget list for the Organization node to Solutions
 * @param nodeid the focal node connecting
 * @param title the title to show in the widget header.
 * @param height the height to draw the widget when open.
 * @param isOpen true if the widget is open, false if it is collapsed.
 * @param key the string which is an id to identify interface elements
 * @param nodetofocusid the id of a node in the results list to focus on.
 */
function buildOrgToSolutionWidget(nodeid, title, height, isOpen, key, nodetofocusid) {
	var model = HUB_DATAMODEL.orgToSolution;
	return buildActiveConnectionWidget(nodeid, model, title, height, 'refreshWidgetSolutions', isOpen, 'solutionwidgetback', key, nodetofocusid);
}

/**
 * Create a widget list for the Organization node to Challenges
 * @param nodeid the focal node connecting
 * @param title the title to show in the widget header.
 * @param height the height to draw the widget when open.
 * @param isOpen true if the widget is open, false if it is collapsed.
 * @param key the string which is an id to identify interface elements
 * @param nodetofocusid the id of a node in the results list to focus on.
 */
function buildOrgToChallengeWidget(nodeid, title, height, isOpen, key, nodetofocusid) {
	var model = HUB_DATAMODEL.orgToChallenge;
	return buildActiveConnectionWidget(nodeid, model, title, height, 'refreshWidgetChallenges', isOpen, 'challengewidgetback', key, nodetofocusid);
}

/**
 * Create a widget list for the Organization node to Resources
 * @param nodeid the focal node connecting
 * @param title the title to show in the widget header.
 * @param height the height to draw the widget when open.
 * @param isOpen true if the widget is open, false if it is collapsed.
 * @param key the string which is an id to identify interface elements
 * @param nodetofocusid the id of a node in the results list to focus on.
 */
function buildOrgToResourceWidget(nodeid, title, height, isOpen, key, nodetofocusid) {
	var model = HUB_DATAMODEL.orgToResource;
	return buildActiveConnectionWidget(nodeid, model, title, height, 'refreshWidgetResources', isOpen, 'resourcewidgetback', key, nodetofocusid);
}

/**
 * Create a widget list for the Organization/Project node to Organizations/Projects
 * @param nodeid the focal node connecting
 * @param title the title to show in the widget header.
 * @param height the height to draw the widget when open.
 * @param isOpen true if the widget is open, false if it is collapsed.
 * @param key the string which is an id to identify interface elements
 * @param nodetofocusid the id of a node in the results list to focus on.
 */
function buildOrgToOrgWidget(nodeid, title, height, isOpen, key, nodetofocusid) {
	var model = HUB_DATAMODEL.orgToOrg;
	return buildActiveConnectionWidget(nodeid, model, title, height, 'refreshWidgetPartners', isOpen, 'orgwidgetback', key, nodetofocusid);
}

/**
 * Create a widget list for the Project node to Issues
 * @param nodeid the focal node connecting
 * @param title the title to show in the widget header.
 * @param height the height to draw the widget when open.
 * @param isOpen true if the widget is open, false if it is collapsed.
 * @param key the string which is an id to identify interface elements
 * @param nodetofocusid the id of a node in the results list to focus on.
 */
function buildProjectToIssueWidget(nodeid, title, height, isOpen, key, nodetofocusid) {
	var model = HUB_DATAMODEL.projectToIssue;
	return buildActiveConnectionWidget(nodeid, model, title, height, 'refreshWidgetIssues', isOpen, 'issuewidgetback', key, nodetofocusid);
}

/**
 * Create a widget list for the Project node to Claims
 * @param nodeid the focal node connecting
 * @param title the title to show in the widget header.
 * @param height the height to draw the widget when open.
 * @param isOpen true if the widget is open, false if it is collapsed.
 * @param key the string which is an id to identify interface elements
 * @param nodetofocusid the id of a node in the results list to focus on.
 */
function buildProjectToClaimWidget(nodeid, title, height, isOpen, key, nodetofocusid) {
	var model = HUB_DATAMODEL.projectToClaim;
	return buildActiveConnectionWidget(nodeid, model, title, height, 'refreshWidgetClaims', isOpen, 'claimwidgetback', key, nodetofocusid);
}

/**
 * Create a widget list for the Project node to Solutions
 * @param nodeid the focal node connecting
 * @param title the title to show in the widget header.
 * @param height the height to draw the widget when open.
 * @param isOpen true if the widget is open, false if it is collapsed.
 * @param key the string which is an id to identify interface elements
 * @param nodetofocusid the id of a node in the results list to focus on.
 */
function buildProjectToSolutionWidget(nodeid, title, height, isOpen, key, nodetofocusid) {
	var model = HUB_DATAMODEL.projectToSolution;
	return buildActiveConnectionWidget(nodeid, model, title, height, 'refreshWidgetSolutions', isOpen, 'solutionwidgetback', key, nodetofocusid);
}

/**
 * Create a widget list for the Project node to Challenges
 * @param nodeid the focal node connecting
 * @param title the title to show in the widget header.
 * @param height the height to draw the widget when open.
 * @param isOpen true if the widget is open, false if it is collapsed.
 * @param key the string which is an id to identify interface elements
 * @param nodetofocusid the id of a node in the results list to focus on.
 */
function buildProjectToChallengeWidget(nodeid, title, height, isOpen, key, nodetofocusid) {
	var model = HUB_DATAMODEL.projectToChallenge;
	return buildActiveConnectionWidget(nodeid, model, title, height, 'refreshWidgetChallenges', isOpen, 'challengewidgetback', key, nodetofocusid);
}

/**
 * Create a widget list for the Project node to Resources
 * @param nodeid the focal node connecting
 * @param title the title to show in the widget header.
 * @param height the height to draw the widget when open.
 * @param isOpen true if the widget is open, false if it is collapsed.
 * @param key the string which is an id to identify interface elements
 * @param nodetofocusid the id of a node in the results list to focus on.
 */
function buildProjectToResourceWidget(nodeid, title, height, isOpen, key, nodetofocusid) {
	var model = HUB_DATAMODEL.projectToResource;
	return buildActiveConnectionWidget(nodeid, model, title, height, 'refreshWidgetResources', isOpen, 'resourcewidgetback', key, nodetofocusid);
}

/**
 * Create a widget list for the Organization nodes managing a Project
 * @param nodeid the focal node connecting
 * @param title the title to show in the widget header.
 * @param height the height to draw the widget when open.
 * @param isOpen true if the widget is open, false if it is collapsed.
 * @param key the string which is an id to identify interface elements
 * @param nodetofocusid the id of a node in the results list to focus on.
 */
function buildProjectToOrgWidget(nodeid, title, height, isOpen, key, nodetofocusid) {
	var model = HUB_DATAMODEL.projectToOrg;
	return buildActiveConnectionWidget(nodeid, model, title, height, 'refreshWidgetOrganizations', isOpen, 'orgwidgetback', key, nodetofocusid);
}

/**
 * Create a widget list for the Organization node to Projects
 * @param nodeid the focal node connecting
 * @param title the title to show in the widget header.
 * @param height the height to draw the widget when open.
 * @param isOpen true if the widget is open, false if it is collapsed.
 * @param key the string which is an id to identify interface elements
 * @param nodetofocusid the id of a node in the results list to focus on.
 */
function buildOrgToProjectWidget(nodeid, title, height, isOpen, key, nodetofocusid) {
	var model = HUB_DATAMODEL.orgToProject;
	return buildActiveConnectionWidget(nodeid, model, title, height, 'refreshWidgetProjects', isOpen, 'orgwidgetback', key, nodetofocusid);
}

/**
 * Create a widget list for the Issue node to Claims
 * @param nodeid the focal node connecting
 * @param title the title to show in the widget header.
 * @param height the height to draw the widget when open.
 * @param isOpen true if the widget is open, false if it is collapsed.
 * @param key the string which is an id to identify interface elements
 * @param nodetofocusid the id of a node in the results list to focus on.
 */
function buildIssueToClaimWidget(nodeid, title, height, isOpen, key, nodetofocusid) {
	var model = HUB_DATAMODEL.issueToClaim;
	return buildActiveConnectionWidget(nodeid, model, title, height, 'refreshWidgetClaims', isOpen, 'claimwidgetback', key, nodetofocusid, 'vote');
}

/**
 * Create a widget list for the Issue node to Solutions
 * @param nodeid the focal node connecting
 * @param title the title to show in the widget header.
 * @param height the height to draw the widget when open.
 * @param isOpen true if the widget is open, false if it is collapsed.
 * @param key the string which is an id to identify interface elements
 * @param nodetofocusid the id of a node in the results list to focus on.
 */
function buildIssueToSolutionWidget(nodeid, title, height, isOpen, key, nodetofocusid) {
	var model = HUB_DATAMODEL.issueToSolution;
	return buildActiveConnectionWidget(nodeid, model, title, height, 'refreshWidgetSolutions', isOpen, 'solutionwidgetback', key, nodetofocusid, 'vote');
}

/**
 * Create a widget list for the Issue node to Organizations
 * @param nodeid the focal node connecting
 * @param title the title to show in the widget header.
 * @param height the height to draw the widget when open.
 * @param isOpen true if the widget is open, false if it is collapsed.
 * @param key the string which is an id to identify interface elements
 * @param nodetofocusid the id of a node in the results list to focus on.
 */
function buildIssueToOrgWidget(nodeid, title, height, isOpen, key, nodetofocusid) {
	var model = HUB_DATAMODEL.issueToOrg;
	return buildActiveConnectionWidget(nodeid, model, title, height, 'refreshWidgetOrganizations', isOpen, 'orgwidgetback', key, nodetofocusid);
}

/**
 * Create a widget list for the Issue node to Projects
 * @param nodeid the focal node connecting
 * @param title the title to show in the widget header.
 * @param height the height to draw the widget when open.
 * @param isOpen true if the widget is open, false if it is collapsed.
 * @param key the string which is an id to identify interface elements
 * @param nodetofocusid the id of a node in the results list to focus on.
 */
function buildIssueToProjectWidget(nodeid, title, height, isOpen, key, nodetofocusid) {
	var model = HUB_DATAMODEL.issueToProject;
	return buildActiveConnectionWidget(nodeid, model, title, height, 'refreshWidgetProjects', isOpen, 'orgwidgetback', key, nodetofocusid);
}

/**
 * Create a widget list for the Issue node to Challenges
 * @param nodeid the focal node connecting
 * @param title the title to show in the widget header.
 * @param height the height to draw the widget when open.
 * @param isOpen true if the widget is open, false if it is collapsed.
 * @param key the string which is an id to identify interface elements
 * @param nodetofocusid the id of a node in the results list to focus on.
 */
function buildIssueToChallengeWidget(nodeid, title, height, isOpen, key, nodetofocusid) {
	var model = HUB_DATAMODEL.issueToChallenge;
	return buildActiveConnectionWidget(nodeid, model, title, height, 'refreshWidgetChallenges', isOpen, 'challengewidgetback', key, nodetofocusid);
}

/**
 * Create a widget list for the Claim node to Orgs
 * @param nodeid the focal node connecting
 * @param title the title to show in the widget header.
 * @param height the height to draw the widget when open.
 * @param isOpen true if the widget is open, false if it is collapsed.
 * @param key the string which is an id to identify interface elements
 * @param nodetofocusid the id of a node in the results list to focus on.
 */
function buildClaimToOrgWidget(nodeid, title, height, isOpen, key, nodetofocusid) {
	var model = HUB_DATAMODEL.claimToOrg;
	return buildActiveConnectionWidget(nodeid, model, title, height, 'refreshWidgetOrganizations', isOpen, 'orgwidgetback', key, nodetofocusid);
}

/**
 * Create a widget list for the Claim node to Projects
 * @param nodeid the focal node connecting
 * @param title the title to show in the widget header.
 * @param height the height to draw the widget when open.
 * @param isOpen true if the widget is open, false if it is collapsed.
 * @param key the string which is an id to identify interface elements
 * @param nodetofocusid the id of a node in the results list to focus on.
 */
function buildClaimToProjectWidget(nodeid, title, height, isOpen, key, nodetofocusid) {
	var model = HUB_DATAMODEL.claimToProject;
	return buildActiveConnectionWidget(nodeid, model, title, height, 'refreshWidgetProjects', isOpen, 'orgwidgetback', key, nodetofocusid);
}

/**
 * Create a widget list for the Claim node to Issues
 * @param nodeid the focal node connecting
 * @param title the title to show in the widget header.
 * @param height the height to draw the widget when open.
 * @param isOpen true if the widget is open, false if it is collapsed.
 * @param key the string which is an id to identify interface elements
 * @param nodetofocusid the id of a node in the results list to focus on.
 */
function buildClaimToIssueWidget(nodeid, title, height, isOpen, key, nodetofocusid) {
	var model = HUB_DATAMODEL.claimToIssue;
	return buildActiveConnectionWidget(nodeid, model, title, height, 'refreshWidgetIssues', isOpen, 'issuewidgetback', key, nodetofocusid);
}

/**
 * Create a widget list for the Challenge node to Issues
 * @param nodeid the focal node connecting
 * @param title the title to show in the widget header.
 * @param height the height to draw the widget when open.
 * @param isOpen true if the widget is open, false if it is collapsed.
 * @param key the string which is an id to identify interface elements
 * @param nodetofocusid the id of a node in the results list to focus on.
 */
function buildChallengeToIssueWidget(nodeid, title, height, isOpen, key, nodetofocusid) {
	var model = HUB_DATAMODEL.challengeToIssue;
	return buildActiveConnectionWidget(nodeid, model, title, height, 'refreshWidgetIssues', isOpen, 'issuewidgetback', key, nodetofocusid);
}

/**
 * Create a widget list for the Key Challenge node to Organizations
 * @param nodeid the focal node connecting
 * @param title the title to show in the widget header.
 * @param height the height to draw the widget when open.
 * @param isOpen true if the widget is open, false if it is collapsed.
 * @param key the string which is an id to identify interface elements
 * @param nodetofocusid the id of a node in the results list to focus on.
 */
function buildChallengeToOrgWidget(nodeid, title, height, isOpen, key, nodetofocusid) {
	var model = HUB_DATAMODEL.challengeToOrg;
	return buildActiveConnectionWidget(nodeid, model, title, height, 'refreshWidgetOrganizations', isOpen, 'orgwidgetback', key, nodetofocusid);
}

/**
 * Create a widget list for the Key Challenge node to Projects
 * @param nodeid the focal node connecting
 * @param title the title to show in the widget header.
 * @param height the height to draw the widget when open.
 * @param isOpen true if the widget is open, false if it is collapsed.
 * @param key the string which is an id to identify interface elements
 * @param nodetofocusid the id of a node in the results list to focus on.
 */
function buildChallengeToProjectWidget(nodeid, title, height, isOpen, key, nodetofocusid) {
	var model = HUB_DATAMODEL.challengeToProject;
	return buildActiveConnectionWidget(nodeid, model, title, height, 'refreshWidgetProjects', isOpen, 'orgwidgetback', key, nodetofocusid);
}

/**
 * Create a widget list for the Solutions node to Organizations
 * @param nodeid the focal node connecting
 * @param title the title to show in the widget header.
 * @param height the height to draw the widget when open.
 * @param isOpen true if the widget is open, false if it is collapsed.
 * @param key the string which is an id to identify interface elements
 * @param nodetofocusid the id of a node in the results list to focus on.
 */
function buildSolutionToOrgWidget(nodeid, title, height, isOpen, key, nodetofocusid) {
	var model = HUB_DATAMODEL.solutionToOrg;
	return buildActiveConnectionWidget(nodeid, model, title, height, 'refreshWidgetOrganizations', isOpen, 'orgwidgetback', key, nodetofocusid);
}

/**
 * Create a widget list for the Solutions node to Projects
 * @param nodeid the focal node connecting
 * @param title the title to show in the widget header.
 * @param height the height to draw the widget when open.
 * @param isOpen true if the widget is open, false if it is collapsed.
 * @param key the string which is an id to identify interface elements
 * @param nodetofocusid the id of a node in the results list to focus on.
 */
function buildSolutionToProjectWidget(nodeid, title, height, isOpen, key, nodetofocusid) {
	var model = HUB_DATAMODEL.solutionToProject;
	return buildActiveConnectionWidget(nodeid, model, title, height, 'refreshWidgetProjects', isOpen, 'orgwidgetback', key, nodetofocusid);
}

/**
 * Create a widget list for the Solutions node to Issues
 * @param nodeid the focal node connecting
 * @param title the title to show in the widget header.
 * @param height the height to draw the widget when open.
 * @param isOpen true if the widget is open, false if it is collapsed.
 * @param key the string which is an id to identify interface elements
 * @param nodetofocusid the id of a node in the results list to focus on.
 */
function buildSolutionToIssueWidget(nodeid, title, height, isOpen, key, nodetofocusid) {
	var model = HUB_DATAMODEL.solutionToIssue;
	return buildActiveConnectionWidget(nodeid, model, title, height, 'refreshWidgetIssues', isOpen, 'issuewidgetback', key, nodetofocusid);
}

/**
 * Create a widget list for the Solutions node to Resources
 * @param nodeid the focal node connecting
 * @param title the title to show in the widget header.
 * @param height the height to draw the widget when open.
 * @param isOpen true if the widget is open, false if it is collapsed.
 * @param key the string which is an id to identify interface elements
 * @param nodetofocusid the id of a node in the results list to focus on.
 */
function buildEvidenceToResourceWidget(nodeid, title, height, isOpen, key, nodetofocusid) {
	var model = HUB_DATAMODEL.evidenceToResource;
	return buildActiveConnectionWidget(nodeid, model, title, height, 'refreshWidgetResources', isOpen, 'resourcewidgetback', key, nodetofocusid);
}

/**
 * Create a widget list for the Evidence node to Claims
 * @param nodeid the focal node connecting
 * @param title the title to show in the widget header.
 * @param height the height to draw the widget when open.
 * @param isOpen true if the widget is open, false if it is collapsed.
 * @param key the string which is an id to identify interface elements
 * @param nodetofocusid the id of a node in the results list to focus on.
 */
function buildEvidenceToClaimWidget(nodeid, title, height, isOpen, key, nodetofocusid) {
	var model = HUB_DATAMODEL.evidenceToClaim;
	return buildActiveConnectionWidget(nodeid, model, title, height, "refreshWidgetClaims", isOpen, 'claimwidgetback', key, nodetofocusid);
}

/**
 * Create a widget list for the Evidence node to Solutions
 * @param nodeid the focal node connecting
 * @param title the title to show in the widget header.
 * @param height the height to draw the widget when open.
 * @param isOpen true if the widget is open, false if it is collapsed.
 * @param key the string which is an id to identify interface elements
 * @param nodetofocusid the id of a node in the results list to focus on.
 */
function buildEvidenceToSolutionWidget(nodeid, title, height, isOpen, key, nodetofocusid) {
	var model = HUB_DATAMODEL.evidenceToSolution;
	return buildActiveConnectionWidget(nodeid, model, title, height, "refreshWidgetSolutions", isOpen, 'solutionwidgetback', key, nodetofocusid);
}

/**
 * Create a widget list for the Resource node to Organizations
 * @param nodeid the focal node connecting
 * @param title the title to show in the widget header.
 * @param height the height to draw the widget when open.
 * @param isOpen true if the widget is open, false if it is collapsed.
 * @param key the string which is an id to identify interface elements
 * @param nodetofocusid the id of a node in the results list to focus on.
 */
function buildResourceToOrgWidget(nodeid, title, height, isOpen, key, nodetofocusid) {
	var model = HUB_DATAMODEL.resourceToOrg;
	return buildActiveConnectionWidget(nodeid, model, title, height, "refreshWidgetOrganizations", isOpen, 'orgwidgetback', key, nodetofocusid);
}
/**
 * Create a widget list for the Resource node to Projects
 * @param nodeid the focal node connecting
 * @param title the title to show in the widget header.
 * @param height the height to draw the widget when open.
 * @param isOpen true if the widget is open, false if it is collapsed.
 * @param key the string which is an id to identify interface elements
 * @param nodetofocusid the id of a node in the results list to focus on.
 */
function buildResourceToProjectWidget(nodeid, title, height, isOpen, key, nodetofocusid) {
	var model = HUB_DATAMODEL.resourceToProject;
	return buildActiveConnectionWidget(nodeid, model, title, height, "refreshWidgetProjects", isOpen, 'orgwidgetback', key, nodetofocusid);
}

/**
 * Create a widget list for the Resource node to Evidence
 * @param nodeid the focal node connecting
 * @param title the title to show in the widget header.
 * @param height the height to draw the widget when open.
 * @param isOpen true if the widget is open, false if it is collapsed.
 * @param key the string which is an id to identify interface elements
 * @param nodetofocusid the id of a node in the results list to focus on.
 */
function buildResourceToEvidenceWidget(nodeid, title, height, isOpen, key, nodetofocusid) {
	var model = HUB_DATAMODEL.resourceToEvidence;
	return buildActiveConnectionWidget(nodeid, model, title, height, "refreshWidgetEvidence", isOpen, 'evidencewidgetback', key, nodetofocusid);
}

/**
 * Create a widget list for the Org/Project node to Evidence
 * @param nodeid the focal node connecting
 * @param title the title to show in the widget header.
 * @param height the height to draw the widget when open.
 * @param isOpen true if the widget is open, false if it is collapsed.
 * @param key the string which is an id to identify interface elements
 * @param nodetofocusid the id of a node in the results list to focus on.
 */
function buildOrgToEvidenceWidget(nodeid, title, height, isOpen, key, nodetofocusid) {
	var model = HUB_DATAMODEL.orgToEvidence;
	return buildActiveConnectionWidget(nodeid, model, title, height, "refreshWidgetEvidence", isOpen, 'evidencewidgetback', key, nodetofocusid);
}

/**
 * Create a widget list for the Org node to Evidence
 * @param nodeid the focal node connecting
 * @param title the title to show in the widget header.
 * @param height the height to draw the widget when open.
 * @param isOpen true if the widget is open, false if it is collapsed.
 * @param key the string which is an id to identify interface elements
 * @param nodetofocusid the id of a node in the results list to focus on.
 */
function builEvidenceToOrgWidget(nodeid, title, height, isOpen, key, nodetofocusid) {
	var model = HUB_DATAMODEL.evidenceToOrg;
	return buildActiveConnectionWidget(nodeid, model, title, height, "refreshWidgetOrganizations", isOpen, 'orgwidgetback', key, nodetofocusid);
}

/**
 * Create a widget list for the Project node to Evidence
 * @param nodeid the focal node connecting
 * @param title the title to show in the widget header.
 * @param height the height to draw the widget when open.
 * @param isOpen true if the widget is open, false if it is collapsed.
 * @param key the string which is an id to identify interface elements
 * @param nodetofocusid the id of a node in the results list to focus on.
 */
function builEvidenceToProjectWidget(nodeid, title, height, isOpen, key, nodetofocusid) {
	var model = HUB_DATAMODEL.evidenceToProject;
	return buildActiveConnectionWidget(nodeid, model, title, height, "refreshWidgetProjects", isOpen, 'orgwidgetback', key, nodetofocusid);
}

/**
 * Create a widget list for the given parameters.
 * @param focalnodeid the focal node to get connections for.
 * @param model the model with the connection logic for the current requirements.
 * @param title the title to show in the widget header.
 * @param height the height to draw the widget when open.
 * @param handler the function to call to refresh the list.
 * @param isOpen true if the widget is open, false if it is collapsed.
 * @param color the background color for the widget header.
 * @param key the string which is an id to identify interface elements.
 * @param nodetofocusid the id of a node in the results list to focus on.
 * @param orderby the sort for the list.
 */
function buildActiveConnectionWidget(focalnodeid, model, title, height, handler, isOpen, color, key, nodetofocusid, orderby, icon) {

	var filternodetypes = model.getOtherEnd();
	var linktypename = model.linktypes;
	var focalnodeend = model.direction;
	var hint = model.hint;
	var icon = model.icon;

	if (!orderby) {
		orderby='date';
	}

	var widgetDiv = new Element("div", {'class':'widgetdiv', 'id':key+"div"});
	widgetDiv.style.height = height+"px";

	/*
	Event.observe(widgetDiv,'mouseover',function () {
		toggleExpandWidget(this, key, height);
	});
	Event.observe(widgetDiv,'mouseout',function () {
		toggleExpandWidget(this, key, height);
	});
	*/

	var widgetHeader = buildWidgetHeader(title, height, isOpen, color, key, icon);

	var bodyheight = height;
	if (USER != "") {
		var toolbar = new Element("div", {'class':'widgetheaderinner', 'style':'padding-top:0px;'});

		if (filternodetypes == 'Claim') {
			if (linktypename == 'challenges,supports') {
				var promptlabel = "<?php echo $LNG->WIDGET_HOW_EVIDENCE_RELATES_MESSAGE; ?>";
				var selectedOption = "supports";
				var refresher = "openClaimFromEvidencePopupWidget";
				var addButton = new Element("a", {'id':'addknowledge'+key+'button', 'title':hint, 'href':'#'} );
				addButton.insert('<img style="vertical-align:bottom" src="<?php echo $HUB_FLM->getImagePath('add.png'); ?>" alt="" /> <?php echo $LNG->WIDGET_ADD_LINK; ?>');
				Event.observe(addButton,'click',function () {
					radioEvidencePrompt(focalnodeid, filternodetypes, focalnodeend, handler, key, nodetofocusid, promptlabel, selectedOption, refresher);
				});
				toolbar.insert(addButton);
			} else {
				toolbar.insert('<a id="addknowledge'+key+'button" title="'+hint+'" href="javascript: loadDialog(\'claimconnect\', \''+URL_ROOT+'ui/popups/claimconnect.php?linktypename='+linktypename+'&focalnodeid='+focalnodeid+'&focalnodeend='+focalnodeend+'&filternodetypes='+filternodetypes+'&handler='+handler+'\', 840,600);"><img style="vertical-align:bottom" src="<?php echo $HUB_FLM->getImagePath('add.png'); ?>" alt="" /> <?php echo $LNG->WIDGET_ADD_LINK; ?></a>');
			}
		} else if (filternodetypes == 'Solution') {
			if (linktypename == 'challenges,supports') {
				var promptlabel = "<?php echo $LNG->WIDGET_HOW_EVIDENCE_RELATES_MESSAGE; ?>";
				var selectedOption = "supports";
				var refresher = "openSolutionFromEvidencePopupWidget";
				var addButton = new Element("a", {'id':'addknowledge'+key+'button', 'title':hint, 'href':'#'} );
				addButton.insert('<img style="vertical-align:bottom" src="<?php echo $HUB_FLM->getImagePath('add.png'); ?>" alt="" /> <?php echo $LNG->WIDGET_ADD_LINK; ?>');
				Event.observe(addButton,'click',function () {
					radioEvidencePrompt(focalnodeid, filternodetypes, focalnodeend, handler, key, nodetofocusid, promptlabel, selectedOption, refresher);
				});
				toolbar.insert(addButton);
			} else {
				toolbar.insert('<a id="addknowledge'+key+'button" title="'+hint+'" href="javascript: loadDialog(\'solutionconnect\', \''+URL_ROOT+'ui/popups/solutionconnect.php?linktypename='+linktypename+'&focalnodeid='+focalnodeid+'&focalnodeend='+focalnodeend+'&filternodetypes='+filternodetypes+'&handler='+handler+'\', 840,600);"><img style="vertical-align:bottom" src="<?php echo $HUB_FLM->getImagePath('add.png'); ?>" alt="" /> <?php echo $LNG->WIDGET_ADD_LINK; ?></a>');
			}

		<?php if ( $CFG->issuesManaged == false || ($CFG->issuesManaged == true && $USER->getIsAdmin() == "Y") ) { ?>
			} else if (filternodetypes == 'Issue') {
				toolbar.insert('<a id="addknowledge'+key+'button" title="'+hint+'" href="javascript: loadDialog(\'issueconnect\', \''+URL_ROOT+'ui/popups/issueconnect.php?linktypename='+linktypename+'&focalnodeid='+focalnodeid+'&focalnodeend='+focalnodeend+'&filternodetypes='+filternodetypes+'&handler='+handler+'\', 840,600);"><img style="vertical-align:bottom" src="<?php echo $HUB_FLM->getImagePath('add.png'); ?>" alt="" /> <?php echo $LNG->WIDGET_ADD_LINK; ?></a>');
		<?php } ?>

		} else if (filternodetypes == 'Challenge') {
			toolbar.insert('<a id="addknowledge'+key+'button" title="'+hint+'" href="javascript: loadDialog(\'challengeconnect\', \''+URL_ROOT+'ui/popups/challengeconnect.php?linktypename='+linktypename+'&focalnodeid='+focalnodeid+'&focalnodeend='+focalnodeend+'&filternodetypes='+filternodetypes+'&handler='+handler+'\', 840,600);"><img style="vertical-align:bottom" src="<?php echo $HUB_FLM->getImagePath('add.png'); ?>" alt="" /> <?php echo $LNG->WIDGET_ADD_LINK; ?></a>');
		} else if (filternodetypes == 'Project') {
			toolbar.insert('<a id="addknowledge'+key+'button" title="'+hint+'" href="javascript: loadDialog(\'projectconnect\', \''+URL_ROOT+'ui/popups/organizationconnect.php?linktypename='+linktypename+'&focalnodeid='+focalnodeid+'&focalnodeend='+focalnodeend+'&filternodetypes='+filternodetypes+'&handler='+handler+'\', 840,750);"><img style="vertical-align:bottom" src="<?php echo $HUB_FLM->getImagePath('add.png'); ?>" alt="" /> <?php echo $LNG->WIDGET_ADD_LINK; ?></a>');
		} else if (filternodetypes == 'Organization') {
			toolbar.insert('<a id="addknowledge'+key+'button" title="'+hint+'" href="javascript: loadDialog(\'orgconnect\', \''+URL_ROOT+'ui/popups/organizationconnect.php?linktypename='+linktypename+'&focalnodeid='+focalnodeid+'&focalnodeend='+focalnodeend+'&filternodetypes='+filternodetypes+'&handler='+handler+'\', 840,750);"><img style="vertical-align:bottom" src="<?php echo $HUB_FLM->getImagePath('add.png'); ?>" alt="" /> <?php echo $LNG->WIDGET_ADD_LINK; ?></a>');
		} else if (filternodetypes == 'Organization,Project') {
			if (linktypename == 'partnered with') {
				toolbar.insert('<a id="addknowledge'+key+'button" title="'+hint+'" href="javascript: loadDialog(\'orgconnect\', \''+URL_ROOT+'ui/popups/organizationconnect.php?linktypename='+linktypename+'&focalnodeid='+focalnodeid+'&focalnodeend='+focalnodeend+'&filternodetypes='+filternodetypes+'&handler='+handler+'\', 840,750);"><img style="vertical-align:bottom" src="<?php echo $HUB_FLM->getImagePath('add.png'); ?>" alt="" /> <?php echo $LNG->WIDGET_ADD_LINK; ?></a>');
			} else {
				toolbar.insert('<a id="addknowledge'+key+'button" title="'+hint+'" href="javascript: loadDialog(\'orgconnect\', \''+URL_ROOT+'ui/popups/organizationconnect.php?linktypename='+linktypename+'&focalnodeid='+focalnodeid+'&focalnodeend='+focalnodeend+'&filternodetypes='+filternodetypes+'&handler='+handler+'\', 840,750);"><img style="vertical-align:bottom" src="<?php echo $HUB_FLM->getImagePath('add.png'); ?>" alt="" /> <?php echo $LNG->WIDGET_ADD_LINK; ?></a>');
			}
		} else if (filternodetypes == RESOURCE_TYPES_STR) {
			toolbar.insert('<a id="addknowledge'+key+'button" title="'+hint+'" href="javascript: loadDialog(\'resourceconnect\', \''+URL_ROOT+'ui/popups/resourceconnect.php?linktypename='+linktypename+'&focalnodeid='+focalnodeid+'&focalnodeend='+focalnodeend+'&filternodetypes='+filternodetypes+'&handler='+handler+'\', 840,600);"><img style="vertical-align:bottom" src="<?php echo $HUB_FLM->getImagePath('add.png'); ?>" alt="" /> <?php echo $LNG->WIDGET_ADD_LINK; ?></a>');
		} else if (filternodetypes == EVIDENCE_TYPES_STR) {
			toolbar.insert('<a id="addknowledge'+key+'button" title="'+hint+'" href="javascript: loadDialog(\'evidenceconnect\', \''+URL_ROOT+'ui/popups/evidenceconnect.php?linktypename='+linktypename+'&focalnodeid='+focalnodeid+'&focalnodeend='+focalnodeend+'&filternodetypes='+filternodetypes+'&handler='+handler+'\', 840,600);"><img style="vertical-align:bottom" src="<?php echo $HUB_FLM->getImagePath('add.png'); ?>" alt="" /> <?php echo $LNG->WIDGET_ADD_LINK; ?></a>');
		}

		widgetHeader.insert(toolbar);
		bodyheight = height-82;
	} else {
		bodyheight = height-42;
		var toolbar = new Element("div", {'class':'widgetheaderinner', 'style':'padding-top:0px;'});
		let spancontent = '<span style="cursor:pointer" onclick="$(\'loginsubmit\').click(); return true;" title="';
		spancontent += "<?php echo $LNG->WIDGET_SIGNIN_HINT; ?>";
		spancontent += '"><img style="vertical-align:bottom" src="<?php echo $HUB_FLM->getImagePath('addgrey.png'); ?>" alt="" /> <?php echo $LNG->WIDGET_ADD_LINK; ?></span>';
		toolbar.insert(spancontent);
		widgetHeader.insert(toolbar);
	}

	widgetDiv.insert(widgetHeader);

	var widgetBody = new Element("div", {'class':'widgetbody', 'id':key+"body"});
	widgetBody.style.background = "white";
	widgetBody.style.height = bodyheight+"px";
	if (isOpen) {
		widgetBody.style.display = 'flex';
		widgetDiv.style.height = height+"px";
	} else {
		widgetBody.style.display = 'none';
		widgetDiv.style.height =  widgetHeader.style.height;
	}

	//widgetBody.style.background = 'white';

	var reqUrl = SERVICE_ROOT + "&method=getconnectionsbynode&style=long";
	reqUrl += "&orderby="+orderby+"&sort=DESC&filtergroup=selected&filterlist="+linktypename+"&filternodetypes="+filternodetypes+"&scope=all&start=0&max=-1&nodeid="+focalnodeid;

	//alert(reqUrl);

	new Ajax.Request(reqUrl, { method:'post',
  		onSuccess: function(transport){
  			var json = transport.responseText.evalJSON();
			if(json.error){
				alert(json.error[0].message);
				return;
			}
			var conns = json.connectionset[0].connections;
			widgetBody.update("");

			if (conns.length == 0) {
				widgetBody.update("<?php echo $LNG->WIDGET_NONE_FOUND; ?>");
			} else {
				var nodes = new Array();
				for(var i=0; i< conns.length; i++){
					var c = conns[i].connection;
					var fN = c.from[0].cnode;
					var tN = c.to[0].cnode;

					if (fN.nodeid != focalnodeid) {
						if (fN.name != "") {
							var next = c.from[0];
							next.cnode['connection'] = c;
							next.cnode['handler'] = handler;
							next.cnode['nodetofocusid'] = nodetofocusid;
							nodes.push(next);
						}
					} else if (tN.nodeid != focalnodeid) {
						if (tN.name != "") {
							var next = c.to[0];
							next.cnode['connection'] = c;
							next.cnode['handler'] = handler;
							next.cnode['nodetofocusid'] = nodetofocusid;
							nodes.push(next);
						}
					}
				}

				if (nodes.length > 0){
					displayWidgetNodes(widgetBody,nodes,parseInt(0), true, key);
					$(key+"headerlabel").update("<span class='widgetcountlabel'>("+nodes.length+")</span>"+title);
				} else {
					widgetBody.update("<?php echo $LNG->WIDGET_NONE_FOUND; ?>");
				}
			}
		}
	});

	widgetBody.update(getLoading("(<?php echo $LNG->WIDGET_LOADING; ?> "+title+"...)"));

	widgetDiv.insert(widgetBody);

	return widgetDiv;
}

function openClaimFromEvidencePopupWidget(focalnodeid, filternodetypes, focalnodeend, handler, key, nodetofocusid, linktypename) {
	loadDialog('claimconnect', URL_ROOT+'ui/popups/claimconnect.php?linktypename='+linktypename+'&focalnodeid='+focalnodeid+'&focalnodeend='+focalnodeend+'&filternodetypes='+filternodetypes+'&handler='+handler, 840,600);
}

function openSolutionFromEvidencePopupWidget(focalnodeid, filternodetypes, focalnodeend, handler, key, nodetofocusid, linktypename) {
	loadDialog('solutionconnect', URL_ROOT+'ui/popups/solutionconnect.php?linktypename='+linktypename+'&focalnodeid='+focalnodeid+'&focalnodeend='+focalnodeend+'&filternodetypes='+filternodetypes+'&handler='+handler, 840,600);
}

function closeComment(key) {
	$(key+"body").style.display = 'block';
	$('commenthidden').style.display = 'none';
	$('commenttoolbar').style.display = 'block';
	$(key+"buttonresize").style.display = 'inline';
	if ($(key+"headerinner").title == 'Expand') {
		$(key+"buttonarrow").style.display = 'inline';
	}
}

function buildCommentWidget(focalnodeid, title, height, isOpen, color, key) {

	var widgetDiv = new Element("div", {'class':'widgetdiv', 'id':key+"div"});
	widgetDiv.style.height = height+"px";

	var widgetHeader = buildWidgetHeader(title, height, isOpen, color, key);

	widgetDiv.insert(widgetHeader);

	var widgetBody = new Element("div", {'class':'widgetbody', 'id':key+"body"});
	widgetBody.style.background = "white";
	widgetBody.style.height = height+"px";
	widgetBody.update(getLoading("(<?php echo $LNG->WIDGET_LOADING; ?> "+title+"...)"));
	widgetDiv.insert(widgetBody);

	if (isOpen) {
		widgetBody.style.display = 'flex';
	} else {
		widgetBody.style.display = 'none';
		widgetDiv.style.height =  widgetHeader.style.height;
	}

	/* IF LOGGED IN, ADD EDITING ELEMENTS */
	if (USER != "") {
		var toolbar = new Element("div", {'id':'commenttoolbar', 'class':'widgetheaderinner col '+color, 'style':'padding-top:0px;'});
		var link = new Element("a", {'title':"<?php echo $LNG->WIDGET_ADD_COMMENT_HINT; ?>", 'style':'cursor:pointer'});
		link.insert('<span id="linkbutton"><img style="vertical-align:bottom" src="<?php echo $HUB_FLM->getImagePath('add.png'); ?>" alt="" /> <?php echo $LNG->WIDGET_ADD_LINK; ?></span>');
		Event.observe(link,"click", function(){

			//check if the widget if closed, and if it is, open it first
			if (widgetBody.style.display != "flex") {
				toggleWidget($(key+'buttonarrow'), key, height);
			}

			$('commenthidden').style.display = 'block';
			$('commenthidden').style.height = ($(key+"body").offsetHeight+3)+"px";
			$('comment').style.height = ($(key+"body").offsetHeight-40)+"px";
			$(key+"body").style.display = 'none';
			$('commenttoolbar').style.display = 'none';
			$(key+"buttonarrow").style.display = 'none';
			$(key+"buttonresize").style.display = 'none';
		});
		toolbar.insert(link);
		widgetHeader.insert(toolbar);

		var hidden = new Element("div", {'class':'widgetheaderinner', 'id':'commenthidden','class':'commentdiv', 'style':'background:#E8E8E8 ;display:none'});
		hidden.style.width = "97%";
		widgetHeader.insert(hidden);

		var box = new Element("textarea", {'value':'', 'id':'comment', 'rows':'1'});
		box.style.width = "97%";
		hidden.insert(box);

		var button = new Element("input", {'value':'<?php echo $LNG->WIDGET_ADD_BUTTON; ?>', 'type':'button', 'style':'vertical-align: bottom'});
		Event.observe(button,"click", function(){
			var comment = $('comment').value;
			$(key+"body").style.display = 'block';
			$('commenthidden').style.display = 'none';
			$('commenttoolbar').style.display = 'block';
			if (comment != "") {
				var type = "Comment";
				var reqUrl = SERVICE_ROOT + "&method=connectnodetocomment&nodetypename="+type+"&nodeid="+focalnodeid+"&comment="+encodeURIComponent(comment);
				new Ajax.Request(reqUrl, { method:'get',
						onSuccess: function(transport){
							var json = transport.responseText.evalJSON();
							if(json.error){
								alert(json.error[0].message);
							} else {
								getAllChatConnections();
							}
						}
				});
			}
		});

		hidden.insert(button);

		var button = new Element("input", {'value':'<?php echo $LNG->FORM_BUTTON_CLOSE; ?>', 'type':'button', 'style':'vertical-align: bottom'});
		Event.observe(button,"click", function(){
			closeComment(key);
		});

		hidden.insert(button);
	} else {
		var toolbar = new Element("div", {'class':'widgetheaderinner', 'style':'padding-top:0px;'});
		let spancontent = '<span style="cursor:pointer" onclick="$(\'loginsubmit\').click(); return true;" title="';
		spancontent += "<?php echo $LNG->WIDGET_SIGNIN_HINT; ?>";
		spancontent += '"><img style="vertical-align:bottom" src="<?php echo $HUB_FLM->getImagePath('addgrey.png'); ?>" alt="" /> <?php echo $LNG->WIDGET_ADD_LINK; ?></span>';
		toolbar.insert(spancontent);
		widgetHeader.insert(toolbar);
	}

	/* LOAD DATA */
	var reqUrl = SERVICE_ROOT + "&method=getconnectionsbynode&style=short";
	reqUrl += "&orderby=vote&sort=DESC&filtergroup=selected&filterlist=supports,challenges,is related to&filternodetypes=Pro,Con,Comment,Question&scope=all&start=0&max=-1&nodeid="+focalnodeid;
	new Ajax.Request(reqUrl, { method:'post',
  		onSuccess: function(transport){
  			var json = transport.responseText.evalJSON();
			if(json.error){
				alert(json.error[0].message);
				return;
			}
			var conns = json.connectionset[0].connections;
			widgetBody.update("");

			if (conns.length == 0) {
				widgetBody.update("<?php echo $LNG->WIDGET_NONE_FOUND2; ?>");
			} else {
				var nodes = new Array();
				for(var i=0; i< conns.length; i++){
					var c = conns[i].connection;
					var fN = c.from[0].cnode;
					var tN = c.to[0].cnode;

					var fnRole = c.from[0].cnode.role[0].role; // c.fromrole[0].role;
					var tnRole = c.to[0].cnode.role[0].role; //c.torole[0].role;

					if (fN.nodeid != focalnodeid && COMMENT_TYPES.indexOf(fnRole.name) != -1) {
						if (fN.name != "") {
							var next = c.from[0];
							next.cnode['connection'] = c;
							next.cnode['parentid'] = focalnodeid;
							next.cnode['handler'] = 'getAllChatConnections';
							nodes.push(next);
						}
					}
				}

				if (nodes.length > 0){
					displayWidgetNodes(widgetBody,nodes,parseInt(0), true, key);
					$(key+"headerlabel").update("<span class='widgetcountlabel'>("+nodes.length+")</span>"+title);
				} else {
					widgetBody.update("<?php echo $LNG->WIDGET_NONE_FOUND2; ?>");
				}
			}
		}
	});

	return widgetDiv;
}

function followUsersWidget(focalnodeid, title, height, isOpen, color, key) {

	var widgetDiv = new Element("div", {'class':'widgetdiv', 'id':key+"div"});
	widgetDiv.style.height = height+"px";

// WIDGET HEADER
	var widgetHeader = new Element("div", {'class':'widgetheader row m-0 p-0 '+color, 'id':key+"header"});

	var widgetInnerHeader = new Element("div", {'class':'widgetheaderinner col', 'id':key+"headerinner", 'title':'<?php echo $LNG->WIDGET_EXPAND_HINT; ?>'});
	var widgetHeaderLabel = new Element("label", {'class':'widgetheaderlabel widgettextcolor ', 'id':key+"headerlabel"});

	if (icon) {
		var icon = new Element('img',{'style':'text-align: middle;margin-right: 5px; width:24px; height:24px;', 'alt':title+' <?php echo $LNG->WIDGET_ICON_ALT; ?>', 'src':icon});
		icon.align='left';
		widgetInnerHeader.appendChild(icon);
	}

	var followbutton = new Element('img', {'style':'margin-right:5px;vertical-align:bottom'});
	followbutton.setAttribute('src', '<?php echo $HUB_FLM->getImagePath("follow_bit.png"); ?>');
	followbutton.setAttribute('alt', '');
	widgetInnerHeader.insert(followbutton);

	widgetHeaderLabel.insert("<span class='widgetcountlabel'>(0)</span>"+title);

	widgetInnerHeader.insert(widgetHeaderLabel);
	widgetHeader.insert(widgetInnerHeader);

	var widgetHeaderControlButton = new Element('img',{ 'style':'cursor: pointer;', 'alt':'<?php echo $LNG->WIDGET_RESIZE_ITEM_ALT; ?>', 'id':key+'buttonresize', 'title': '<?php echo $LNG->WIDGET_RESIZE_ITEM_HINT; ?>', 'src': '<?php echo $HUB_FLM->getImagePath("enlarge2.gif"); ?>'});

	Event.observe(widgetHeaderLabel,'mouseover',function (){widgetHeaderLabel.style.cursor = 'pointer'});
	Event.observe(widgetHeaderLabel,'mouseout',function (){widgetHeaderLabel.style.cursor = 'normal'});

	Event.observe(widgetInnerHeader,'mouseover',function (){widgetInnerHeader.style.cursor = 'pointer'});
	Event.observe(widgetInnerHeader,'mouseout',function (){widgetInnerHeader.style.cursor = 'normal'});
	Event.observe(widgetInnerHeader,'click',function (){toggleExpandWidget(widgetHeaderControlButton, key, height)});
	Event.observe(widgetHeaderControlButton,'click',function (){toggleExpandWidget(this, key, height)});
	var widgetInnerHeaderControl = new Element("div", {'class':'widgetheadercontrol col-auto'});
	widgetInnerHeaderControl.insert(widgetHeaderControlButton);

	var widgetHeaderControlButton2 = new Element('img',{ 'style':'cursor: pointer;display: inline', 'alt':'<?php echo $LNG->WIDGET_OPEN_CLOSE_ALT; ?>', 'id':key+'buttonarrow', 'title': '<?php echo $LNG->WIDGET_OPEN_CLOSE_HINT; ?>', 'src': '<?php echo $HUB_FLM->getImagePath("arrow-up2.png"); ?>'});
	Event.observe(widgetHeaderControlButton2,'click',function (){toggleWidget(this, key, height)});
	widgetInnerHeaderControl.insert(widgetHeaderControlButton2);

	widgetHeader.insert(widgetInnerHeaderControl);

	if (isOpen) {
		widgetHeaderControlButton2.src='<?php echo $HUB_FLM->getImagePath("arrow-up2.png"); ?>';
	} else {
		widgetHeaderControlButton2.src='<?php echo $HUB_FLM->getImagePath("arrow-down2.png"); ?>';
	}

	//var widgetHeader = buildWidgetHeader(title, height, isOpen, color, key);
	widgetDiv.insert(widgetHeader);

	var widgetBody = new Element("div", {'class':'widgetbody', 'id':key+"body"});
	widgetBody.style.background = "white";
	widgetBody.style.height = height+"px";
	widgetBody.update(getLoading("(<?php echo $LNG->WIDGET_LOADING_FOLLOWERS; ?>)"));
	widgetDiv.insert(widgetBody);

	if (isOpen) {
		widgetBody.style.display = 'flex';
	} else {
		widgetBody.style.display = 'none';
		widgetDiv.style.height =  widgetHeader.offsetHeight;
	}

	loadfollowUsersWidget(focalnodeid, title, key, widgetBody);

	return widgetDiv;
}

function loadfollowUsersWidget(focalnodeid, title, key, widgetBody) {

	if (!widgetBody) {
		widgetBody = $(key+'body')
	}

	/* LOAD DATA */
	var reqUrl = SERVICE_ROOT + "&method=getusersbyfollowing&itemid="+focalnodeid;
	new Ajax.Request(reqUrl, { method:'post',
  		onSuccess: function(transport){
  			var json = transport.responseText.evalJSON();
			if(json.error){
				alert(json.error[0].message);
				return;
			}
			var users = json.userset[0].users;
			widgetBody.update("");

			if (users.length == 0) {
				widgetBody.update("<?php echo $LNG->WIDGET_NO_FOLLOWERS_FOUND; ?>");
			} else {
				displayWidgetUsers(widgetBody,users,parseInt(0));
			}
			$(key+"headerlabel").update("<span class='widgetcountlabel'>("+users.length+")</span>"+title);
		}
	});
}


/****************************************/
/*		OverView Page Widgets			*/
/****************************************/

function overviewUserWidget(context, args, title, orderby, sort, count, width, height, buttontitle, key, hinttype, filtertype) {

	var set = new Element("fieldset", {'class':'overviewfieldset'});
	var legend = new Element("legend", {'class':'overviewlegend widgettextcolor'});

	legend.insert(title);
	set.insert(legend);
	var main = new Element("div", {"class":"mb-2", 'style':'height: '+height+'px; overflow-y: auto; overflow-x: hidden; '});
	main.insert(getLoading("(<?php echo $LNG->WIDGET_LOADING; ?> "+title+"...)"));
	set.insert(main);

	var args2 = Object.clone(args);
	args2["start"] = 0;
	args2["max"] = count;
	args2["orderby"] = orderby;
	args2["sort"] = sort;

	var reqUrl = SERVICE_ROOT + "&method=getusersby" + context + "&" + Object.toQueryString(args2);

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

			main.innerHTML="";

			if(json.userset[0].count != 0){
				var users = json.userset[0].users;

				displayWidgetUsers(main,users,parseInt(args['start'])+1);
			} else {
				main.innerHTML="";
				main.insert("<?php echo $LNG->WIDGET_NO_RESULTS_FOUND; ?>");
			}
    	}
  	});

	var allbutton = new Element("a", {'href':'#'+key+'-list', 'class':'active', 'title':'<?php echo $LNG->WIDGET_CLICK_EXPLORE_HINT; ?> '+hinttype, 'style':'clear: both; float:right; font-weight:bold; margin: 5px;margin-top:0px;'});
	allbutton.insert(buttontitle);
	Event.observe(allbutton,'click',function(){
		if (filtertype) {
			// only used on org page.
			ORG_ARGS['filternodetypes'] = filtertype;
		}
		setTabPushed( $('tab-'+key+'-list-obj'), key+'-list');
	});
	set.insert(allbutton);

	return set;
}

function overviewActiveUserWidget(context, args, title, orderby, sort, count, width, height, buttontitle, key, hinttype, filtertype) {

	var set = new Element("fieldset", {'class':'overviewfieldset'});
	var legend = new Element("legend", {'class':'overviewlegend widgettextcolor'});

	legend.insert(title);
	set.insert(legend);
	var main = new Element("div", {'style':'height: '+height+'px; overflow-y: auto; overflow-x: hidden;'});
	main.insert(getLoading("(<?php echo $LNG->WIDGET_LOADING; ?> "+title+"...)"));
	set.insert(main);

	var args2 = Object.clone(args);
	args2["limit"] = count

   	/*
   	  "month"  => 2419200,  // seconds in a month  (4 weeks)
   	  "week"   => 604800,  // seconds in a week   (7 days)
   	  "day"    => 86400,    // seconds in a day    (24 hours)
   	*/

	var now = (new Date().getTime());
	var from = (now/1000) - (2419200);
	args2["from"] = from;
	var reqUrl = SERVICE_ROOT + "&method=getusersmostactive&" + Object.toQueryString(args2);

	//var reqUrl = SERVICE_ROOT + "&method=getactiveconnectionusers&" + Object.toQueryString(args2);

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

			main.innerHTML="";

			if(json.userset[0].count != 0){
				var users = json.userset[0].users;
				displayWidgetUsers(main,users,parseInt(args['start'])+1);
			} else {
				main.innerHTML="";
				main.insert("<?php echo $LNG->WIDGET_NO_RESULTS_FOUND; ?>");
			}
    	}
  	});

	var allbutton = new Element("a", {'href':'#'+key+'-list', 'class':'active', 'title':'<?php echo $LNG->WIDGET_CLICK_EXPLORE_HINT; ?> '+hinttype, 'style':'clear: both; float:right; font-weight:bold; margin: 5px;margin-top:0px;'});
	allbutton.insert(buttontitle);
	Event.observe(allbutton,'click',function(){
		if (filtertype) {
			// only used on org page.
			ORG_ARGS['filternodetypes'] = filtertype;
		}
		setTabPushed( $('tab-'+key+'-list-obj'), key+'-list');
	});
	set.insert(allbutton);

	return set;
}

function overviewFollowedUserWidget(context, args, title, orderby, sort, count, width, height, buttontitle, key, hinttype, filtertype) {

	var set = new Element("fieldset", {'class':'overviewfieldset'});
	var legend = new Element("legend", {'class':'overviewlegend widgettextcolor'});
	legend.insert(title);
	set.insert(legend);
	var main = new Element("div", {'style':'height: '+height+'px; overflow-y: auto; overflow-x: hidden;'});
	main.insert(getLoading("(<?php echo $LNG->WIDGET_LOADING; ?> "+title+"...)"));
	set.insert(main);

	var args2 = Object.clone(args);
	args2["limit"] = count;

	var reqUrl = SERVICE_ROOT + "&method=getusersbymostfollowed&" + Object.toQueryString(args2);

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

			if(json.userset[0].count != 0){
				var users = json.userset[0].users;

				main.innerHTML="";
				displayWidgetUsers(main,users,parseInt(args['start'])+1);
			} else {
				main.innerHTML="";
				main.insert("<?php echo $LNG->WIDGET_NO_RESULTS_FOUND; ?>");
			}
    	}
  	});

	var allbutton = new Element("a", {'href':'#'+key+'-list', 'class':'active', 'title':'<?php echo $LNG->WIDGET_CLICK_EXPLORE_HINT; ?> '+hinttype, 'style':'clear: both; float:right; font-weight:bold; margin: 5px;margin-top:0px;'});
	allbutton.insert(buttontitle);
	Event.observe(allbutton,'click',function(){
		if (filtertype) {
			// only used on org page.
			ORG_ARGS['filternodetypes'] = filtertype;
		}
		setTabPushed( $('tab-'+key+'-list-obj'), key+'-list');
	});
	set.insert(allbutton);

	return set;
}

function overviewNodeWidget(context, args, title, filternodetypes, orderby, sort, count, width, height, buttontitle, key, hinttype, uniqueid, filtertype) {

	if (uniqueid == undefined) {
		uniqueid = 'something';
	}

	var set = new Element("fieldset", {'class':'overviewfieldset'});
	var legend = new Element("legend", {'class':'overviewlegend widgettextcolor'});
	legend.insert(title);
	set.insert(legend);
	var main = new Element("div", {'style':'height: '+height+'px; overflow-y: auto; overflow-x: hidden;padding-right:5px;'});
	main.insert(getLoading("(<?php echo $LNG->WIDGET_LOADING; ?> "+title+"...)"));
	set.insert(main);

	var args2 = Object.clone(args);
	args2['filternodetypes'] = filternodetypes;
	args2["start"] = 0;
	args2["max"] = count;
	args2["orderby"] = orderby;
	args2["sort"] = sort;

	var reqUrl = SERVICE_ROOT + "&method=getnodesby" + context + "&" + Object.toQueryString(args2);

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
				displayNodes(main,nodes,parseInt(args['start'])+1, true, uniqueid,false);
			} else {
				main.innerHTML="";
				main.insert("<?php echo $LNG->WIDGET_NO_RESULTS_FOUND; ?>");
			}
    	}
  	});

	if (buttontitle && buttontitle != "") {
		var allbutton = new Element("a", {'href':'#'+key+'-list', 'class':'active', 'title':'<?php echo $LNG->WIDGET_CLICK_EXPLORE_HINT; ?> '+hinttype, 'style':'clear: both; float:right; font-weight:bold; margin: 5px;margin-top:0px;'});
		allbutton.insert(buttontitle);
		Event.observe(allbutton,'click',function(){
			setTabPushed( $('tab-'+key+'-list-obj'), key+'-list');
		});
		set.insert(allbutton);
	}

	return set;
}

function overviewHomeNodeWidget(context, args, filternodetypes, orderby, sort, count, width, height, uniqueid) {

	if (uniqueid == undefined) {
		uniqueid = 'homelist';
	}

	var main = new Element("div", {'class':'overview-home-node-widget'});
	main.insert(getLoading("(<?php echo $LNG->WIDGET_LOADING; ?>...)"));

	var args2 = Object.clone(args);
	args2['filternodetypes'] = filternodetypes;
	args2["start"] = 0;
	args2["max"] = count;
	args2["orderby"] = orderby;
	args2["sort"] = sort;

	var reqUrl = SERVICE_ROOT + "&method=getnodesby" + context + "&" + Object.toQueryString(args2);

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
				displayHomeNodes(main,nodes,parseInt(args['start'])+1, true, uniqueid);
			} else {
				main.innerHTML="";
			}
    	}
  	});

	return main;
}

function overviewThemeWidget(context, args, title, filternodetypes, count, width, height, buttontitle, key, hinttype) {

	var set = new Element("fieldset", {'class':'overviewfieldset'});
	var legend = new Element("legend", {'class':'overviewlegend widgettextcolor'});
	legend.insert(title);
	set.insert(legend);

	var main = new Element("div", {'style':'height: '+height+'px; overflow-y: auto; overflow-x: hidden; padding-top: 10px; padding-left:10px;'});
	main.insert(getLoading("(<?php echo $LNG->WIDGET_LOADING; ?> "+title+"...)"));
	set.insert(main);

	var args2 = Object.clone(args);
	args2['filternodetypes'] = filternodetypes;
	args2["limit"] = count;

	var reqUrl = SERVICE_ROOT + "&method=getmostpopularthemesbytype&" + Object.toQueryString(args2);

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

			main.innerHTML="";

			var count = json.nodeset[0].nodes.length;
			if(count > 0){
				var nodes = json.nodeset[0].nodes;

				//displayWidgetNodes(main,nodes,parseInt(0), true);

				for (var i=0; i<=count; i++) {
					var node = nodes[i].cnode;

					var count = node.usecount;
					var nodeid = node.nodeid;
					var name = node.name;
					var role = node.role[0].role;

					var divarea = new Element("div", {'style':'width:'+width-50+'px;clear:both;float:left; margin-left: 5px; margin-top:5px;font-weight:bold;'});

	 				var nodeicon = new Element('img',{'alt':role.name, 'title':role.name, 'style':'float:left;width:20px;height:20px;margin-top:3px;padding-right:5px;','align':'left','src': URL_ROOT + role.image});
					var popthemeanchor = new Element("a", {'class':'itemtext', 'title':count+" : Click to explore", 'href':URL_ROOT+'explore.php?id='+nodeid, 'style':'float:left; margin-left: 5px; margin-top:5px; margin-bottom:10px;'});
					popthemeanchor.insert(name);

					divarea.insert(nodeicon);
					divarea.insert(popthemeanchor);

					main.insert(divarea);
				}
			} else {
				main.innerHTML="";
				main.insert("<?php echo $LNG->WIDGET_NO_RESULTS_FOUND; ?>");
			}
    	}
  	});

	/*
	var allthemeanchor = new Element("a", {'href':'#'+key+'-net', 'class':'active', 'title':'<?php echo $LNG->WIDGET_THEME_EXPLORE_HINT; ?> '+hinttype, 'style':'clear: both; float:right; font-weight:bold; margin: 5px;margin-top:0px;'});
	allthemeanchor.insert('Explore all');
	Event.observe(allthemeanchor,'click',function(){
		setTabPushed( $('tab-'+key+'-list-obj'), key+'-net');
	});
	set.insert(allthemeanchor);
	*/

	return set;
}

/** TAGS WIDGET **/

function buildTagSuggestionByType(nodeid, type, tags, title, height, isOpen, color, key) {

	var widgetDiv = new Element("div", {'class':'widgetdiv '+color, 'id':key+"div"});
	widgetDiv.style.height = height+"px";

	/*****************/

	var widgetHeader = new Element("div", {'class':'test1 widgetheader '+color, 'id':key+"header"});

	var widgetHeaderControlButton = new Element('img',{ 'style':'display: none; cursor: pointer;', 'alt':'<?php echo $LNG->WIDGET_RESIZE_ITEM_ALT; ?>', 'id':key+'buttonresize', 'title': '<?php echo $LNG->WIDGET_RESIZE_ITEM_HINT; ?>', 'src': '<?php echo $HUB_FLM->getImagePath("enlarge2.gif"); ?>'});
	Event.observe(widgetHeaderControlButton,'click',function (){toggleExpandWidget(this, key, height)});

	var widgetInnerHeader = new Element("div", {'class':'widgetheaderinner col', 'id':key+"headerinner", 'title':'<?php echo $LNG->WIDGET_EXPAND_HINT; ?>'});

	var widgetHeaderLabel = new Element("label", {'class':'widgetheaderlabel widgettextcolor', 'id':key+"headerlabel"});
	widgetHeaderLabel.insert(title);

	widgetInnerHeader.insert(widgetHeaderLabel);
	widgetHeader.insert(widgetInnerHeader);

	var widgetInnerHeaderControl = new Element("div", {'class':'widgetheadercontrol'});

	widgetInnerHeaderControl.insert(widgetHeaderControlButton);

	var widgetHeaderControlButton2 = new Element('img',{ 'style':'display: none; cursor: pointer;', 'alt':'<?php echo $LNG->WIDGET_OPEN_CLOSE_ALT; ?>', 'id':key+'buttonarrow', 'title': '<?php echo $LNG->WIDGET_OPEN_CLOSE_HINT; ?>', 'src': '<?php echo $HUB_FLM->getImagePath("arrow-up2.png"); ?>'});
	Event.observe(widgetHeaderControlButton2,'click',function (){toggleWidget(this, key, height)});
	widgetInnerHeaderControl.insert(widgetHeaderControlButton2);

	widgetHeader.insert(widgetInnerHeaderControl);

	if (isOpen) {
		widgetHeaderControlButton2.src='<?php echo $HUB_FLM->getImagePath("arrow-up2.png"); ?>';
	} else {
		widgetHeaderControlButton2.src='<?php echo $HUB_FLM->getImagePath("arrow-down2.png"); ?>';
	}

	widgetDiv.insert(widgetHeader);

	/*******************/

	var widgetBody = new Element("div", {'class':'widgetbody', 'id':key+"body"});
	widgetBody.style.background = "white";
	widgetBody.style.height = height+"px";
	widgetDiv.insert(widgetBody);

	var toolbar = new Element("div", {'class':'widgetheaderinner', 'style':'padding-top:0px;'});

	var loadButton = new Element("a", {'id':key+'loadbutton','href':'javascript:void(0)','title':'<?php echo $LNG->WIDGET_LOAD; ?> '+title});
	loadButton.insert('load');
	Event.observe(loadButton,'click', function () {
		loadTagSuggestionByType(nodeid, type, tags, title, height, key);
	});

	widgetHeaderLabel.update("( ");
	widgetHeaderLabel.insert(loadButton);
	widgetHeaderLabel.insert(" ) "+title);

	widgetHeader.insert(toolbar);

	if (isOpen) {
		widgetBody.style.display = 'flex';
	} else {
		widgetBody.style.display = 'none';
		widgetDiv.style.height =  widgetHeader.style.height;
	}

	return widgetDiv;
}

function loadTagSuggestionByType(nodeid, type, tags, title, height, key) {

	$(key+"body").update(getLoading("(<?php echo $LNG->WIDGET_LOADING; ?> "+title+"...)"));
	$(key+"headerlabel").update(title+"<span style='margin-left:5px;'>( <?php echo $LNG->WIDGET_LOADING; ?>... )</span>");

	$(key+'buttonarrow').style.display = 'inline';
	$(key+'buttonresize').style.display = 'inline';

	Event.observe($(key+"headerinner"),'mouseover',function (){widgetInnerHeader.style.cursor = 'pointer'});
	Event.observe($(key+"headerinner"),'mouseout',function (){widgetInnerHeader.style.cursor = 'normal'});
	Event.observe($(key+"headerinner"),'click',function (){toggleExpandWidget($(key+'buttonresize'), key, height)});

	/* LOAD DATA */

	var reqUrl = SERVICE_ROOT + "&method=getnodesbyglobal&style=long";
	reqUrl += "&orderby=name&sort=ASC&scope=all&start=0&max=-1&nodeid="+nodeid;
	reqUrl += "&filternodetypes="+encodeURIComponent(type);
	reqUrl += "&tagsonly=true";
	reqUrl += "&q="+encodeURIComponent(tags);

	if (tags != "") {

		new Ajax.Request(reqUrl, { method:'post',
			onSuccess: function(transport){
				var json = transport.responseText.evalJSON();
				if(json.error){
					alert(json.error[0].message);
					return;
				}
				var nodes = json.nodeset[0].nodes;
				$(key+"body").update("");

				if (nodes.length == 0) {
					$(key+"body").update("<?php echo $LNG->WIDGET_NONE_FOUND;?>");
				} else {
					var finalnodes = new Array();
					var check = new Array();
					//var tags = new Array();

					for(var i=0; i< nodes.length; i++){
						var n = nodes[i].cnode;

						if (!check[n.nodeid]) {
							finalnodes.push(nodes[i]);
							check[n.nodeid] = n.nodeid;
							//themes[fN.nodeid] = tN.name;
						} else {
							/*if (themes[fN.nodeid].indexOf(tN.name) == -1) {
								themes[fN.nodeid] = themes[fN.nodeid]+", "+tN.name;
							}*/
						}
					}

					/*for(var i=0; i< finalnodes.length; i++){
						var node = finalnodes[i];
						node.cnode['commontags'] = tags[node.cnode.nodeid];
					}*/

					if (finalnodes.length > 0) {
						displayWidgetNodes($(key+"body"),finalnodes,parseInt(0), true, key);
						$(key+"headerlabel").update("<span class='widgetcountlabel'>("+finalnodes.length+")</span>"+title);
					} else {
						$(key+"body").update("No "+title+" found");
						$(key+"headerlabel").update("<span class='widgetcountlabel'>(0)</span>"+title);
					}
				}
			}
		});
	} else {
		$(key+"body").update("<?php echo $LNG->WIDGET_NONE_FOUND;?>");
		$(key+"headerlabel").update("<span class='widgetcountlabel'>(0)</span>"+title);
	}
}
