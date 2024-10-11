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
 *  are disitemed. In no event shall the copyright owner or contributors be    *
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

	checkLogin();

    include_once($HUB_FLM->getCodeDirPath("ui/dialogheader.php"));

	$tagid = required_param("tagid",PARAM_TEXT);
	$tagname = required_param("tagname",PARAM_TEXT);
	$handler = optional_param("handler","addSelectedNode",PARAM_TEXT);

	$usertags = "";
	$u = new User($USER->userid);
	$user = $u->load();
   	$tags = array();

   	$userusage = false;

    if(isset($user->tags)) {
    	$usertags = $user->tags;
    	$count = count($usertags);
    	for ($i=0; $i < $count; $i++) {
    		$nexttag = $usertags[$i];
    		if ($nexttag->name == $tagname) {
    			$userusage = true;
    		}
    	}
    }
?>

<script type="text/javascript">
   	function init(){

    	$('dialogheader').insert('<?php echo $LNG->FORM_TAG_USAGE_TITLE; ?> <?php echo addslashes($tagname); ?>');

		loadTagNodes('<?php echo $tagid; ?>', 0, 10);
	}

   /**
    *	load tag usage nodes
    */
   function loadTagNodes(tagid, start, max){
	    $("item-idea-list").innerHTML = "";

   		var reqUrl = SERVICE_ROOT + "&method=getnodesbytag&tagid="+tagid+"&start="+start+"&max="+max;
   		new Ajax.Request(reqUrl, { method:'get',
			onSuccess: function(transport){

				try {
					var json = transport.responseText.evalJSON();
				} catch(err) {
					console.log(err);
				}

				if(json.error){
					alert(json.error[0].message);
					return;
				}

				if(json.nodeset[0].nodes.length > 0){
					var total = json.nodeset[0].totalno;

					$("item-idea-list").insert(createNav(total, json.nodeset[0].count, start, max, "node"));

					displayUsageNodes($("item-idea-list"),json.nodeset[0].nodes,1);
				} else {
					$("item-idea-list").insert("<?php echo $LNG->FORM_TAG_USAGE_NO_ITEMS_MESSAGE; ?>");
				}
       		}
   		});
   	}

    /**
	 * Render a list of nodes
	 */
	function displayUsageNodes(objDiv,nodes,start){
		var lOL = new Element("ol", {'start':start, 'class':'idea-list-ol'});
		for(var i=0; i< nodes.length; i++){
			if(nodes[i].cnode){
				var iUL = new Element("li", {'id':nodes[i].cnode.nodeid, 'class':'idea-list-li', 'style':'padding-bottom: 5px;'});
				lOL.insert(iUL);
				var blobDiv = new Element("div", {'style':'margin: 2px; width: 335px'});

				var blobNode = renderNode(nodes[i].cnode, "usage", nodes[i].cnode.role[0].role, true, 'inactive');
				blobDiv.insert(blobNode);
				iUL.insert(blobDiv);
			}
		}
		objDiv.insert(lOL);
	}

	/**
	 * display Nav
	 */
	function createNav(total, count, start, max, type){

   	   var nav = new Element ("div",{'id':'page-nav', 'class':'toolbarrow', 'style':'padding-top: 3px;'});

   	   var header = createNavCounter(total, start, count);
   	   nav.insert(header);

   	   var clearnav = new Element ("div",{'style':'clear: both; margin: 3px; height: 3px;'});
   	   nav.insert(clearnav);

   	   if (total > parseInt( max )) {
   	   		//previous
   	   	    var prevSpan = new Element("span", {'id':"nav-previous"});
   	   	    if(start > 0){
   	   			prevSpan.update("<img title='<?php echo $LNG->LIST_NAV_PREVIOUS_HINT; ?>' src='<?php echo $HUB_FLM->getImagePath("arrow-left2.png"); ?>' class='toolbar' style='padding-right: 0px;' />");
   	   	        prevSpan.addClassName("active");
   	   	        Event.observe(prevSpan,"click", function(){
   	   		    	var newArr = {"max":max, "start":start};
   	   	            newArr["start"] = parseInt(start) - newArr["max"];
   	            	loadTagNodes('<?php echo($tagid); ?>', newArr["start"], newArr["max"])
   	   	        });
   	   	    } else {
   	   			prevSpan.update("<img title='<?php echo $LNG->LIST_NAV_NO_PREVIOUS_HINT; ?>' disabled src='<?php echo $HUB_FLM->getImagePath("arrow-left2-disabled.png"); ?>' class='toolbar' style='padding-right: 0px;' />");
   	   	        prevSpan.addClassName("inactive");
   	   	    }

   	   	    //pages
   	   	    var pageSpan = new Element("span", {'id':"nav-pages"});
   	   	    var totalPages = Math.ceil(total/max);
   	   	    var currentPage = (start/max) + 1;
   	   	    for (var i = 1; i<totalPages+1; i++){
   	   	    	var page = new Element("span", {'class':"nav-page"}).insert(i);
   	   	    	if(i != currentPage){
   	   		    	page.addClassName("active");
   	   		    	var newArr = {"max":max, "start":start};
   	   		    	newArr["start"] = newArr["max"] * (i-1) ;
   	   		    	Event.observe(page,"click", Pages.next.bindAsEventListener(Pages,type,newArr));
   	   	    	} else {
   	   	    		page.addClassName("currentpage");
   	   	    	}
   	   	    	pageSpan.insert(page);
   	   	    }

   	   	    //next
   	   	    var nextSpan = new Element("span", {'id':"nav-next"});
   	   	    if(parseInt(start)+parseInt(count) < parseInt(total)){
   	   		    nextSpan.update("<img title='<?php echo $LNG->LIST_NAV_NEXT_HINT; ?>' src='<?php echo $HUB_FLM->getImagePath("arrow-right2.png"); ?>' class='toolbar' style='padding-right: 0px;' />");
   	   	        nextSpan.addClassName("active");
   	   	        Event.observe(nextSpan,"click", function(){
   	   		    	var newArr = {"max":max, "start":start};
   	   	            newArr["start"] = parseInt(start) + parseInt(newArr["max"]);
   	            	loadTagNodes('<?php echo($tagid); ?>', newArr["start"], newArr["max"])
   	   	        });
   	   	    } else {
   	   		    nextSpan.update("<img title='<?php echo $LNG->LIST_NAV_NO_NEXT_HINT; ?>' src='<?php echo $HUB_FLM->getImagePath("arrow-right2-disabled.png"); ?>' class='toolbar' style='padding-right: 0px;' />");
   	   	        nextSpan.addClassName("inactive");
   	   	    }

   	   	    if( start>0 || (parseInt(start)+parseInt(count) < parseInt(total))){
   	   	    	nav.insert(prevSpan).insert(pageSpan).insert(nextSpan);
   	   	    }
   	   	}

   	   	return nav;
       }

       var Pages = {
   			next: function(e){
   				var data = $A(arguments);
   				var type = data[1];
   				var arrayData = data[2];
      	        loadTagNodes('<?php echo($tagid); ?>', arrayData['start'], arrayData['max']);
   			}
   	};

	/**
	* display nav header
	*/
	function createNavCounter(total, start, count, type){
		if(count != 0){
			var objH = new Element("span",{'class':'nav'});
			var s1 = parseInt(start)+1;
			var s2 = parseInt(start)+parseInt(count);
			objH.insert("<b>" + s1 + " <?php echo $LNG->LIST_NAV_TO; ?> " + s2 + " (" + total + ")</b>");
		} else {
			var objH = new Element("span");
			objH.insert("<p><b><?php echo $LNG->LIST_NAV_NO_ITEMS; ?></b></p>");
		}
		return objH;
	}

   	window.onload = init;


</script>
<?php if ($userusage) { echo '<div style="float:left;margin-bottom:10px;margin-left:10px;font-weight:bold">'.$LNG->USER_PROFILE_TAG_USAGE.'</div>'; } ?>
<div id="nodepicker" style="clear: both;float: left; width: 400px; margin-left: 10px; display: block;overflow:hidden;">
	<div id='item-idea-list' class='tabcontent' style="width: 390px;"></div>
</div>
<div class="formrow" style="clear:both;float:left;margin-top:20px;">
	<input type="button" value="<?php echo $LNG->FORM_BUTTON_CLOSE; ?>" onclick="window.close();"/>
</div>

<?php
    include_once($HUB_FLM->getCodeDirPath("ui/dialogfooter.php"));
?>