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
?>

var nodemap;
//var geocoder = new google.maps.Geocoder();

function loadUserNodeMap(){

	/*
	var tb3 = new Element("div", {'style':'height:40px;'});
	tb3.insert(createThemeFilter(CONTEXT, USER_ARGS, 'user'));
	tb3.insert(createNodeTypeFilter(CONTEXT, USER_ARGS));
	tb3.insert(createCountryFilter(CONTEXT, USER_ARGS));

	var print = new Element("img",
		{'src': '<?php echo $HUB_FLM->getImagePath("printer.png"); ?>',
		'alt': 'Print map',
		'title': 'Print map',
		'class': 'active',
		'style': 'padding-top:0px;padding-left:10px;'});
	tb3.insert(print);
	Event.observe(print,'click',function(){
		var call =  URL_ROOT+"ui/popups/printusernodegeomap.html";
		loadDialog('printnodes', call, 800, 700);
	});

	$("tab-content-user-nodegmap").update(tb3);
	*/

	$("tab-content-user-nodegmap").insert('<div id="my-usernodemap" style="height: 400px; border: 1px solid #aaa"><?php echo $LNG->GEO_BROWSER_INCOMPATIBLE; ?></div>');
	$("tab-content-user-nodegmap").insert('<div id="user-nodegmap-loading"></div>');
	$("user-nodegmap-loading").insert(getLoading("<?php echo $LNG->GEO_USER_NODE_LOADING; ?>"));

	nodemap = L.map('my-usernodemap').setView([userNodeGeoLat, userNodeGeoLong], userNodeGeoZoom);
	L.tileLayer('<?php echo $CFG->maptilesurl; ?>', {
	   attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>',
	   maxZoom: 18,
	   crossOrigin: true
	}).addTo(nodemap);

	//nodemap.setZoom(userNodeGeoZoom);

	// now load in the nodes
	loadUserNodeMapMarkers();
}

function zoomToCountryUserNode(country) {
	// Remove everything after comma as it seem to break Google geocode.
	// Bit before comma is enough as it is country name.
	/*
	var ind = country.indexOf(",");
	if (ind != -1) {
		country=country.substr(0, ind);
	}

   	geocoder.geocode( {'address':country}, function(results, status) {
		if (status == google.maps.GeocoderStatus.OK) {
			var bounds = results[0].geometry.bounds;
			mapBounds = new google.maps.LatLngBounds(new google.maps.LatLng(bounds.max_lat, bounds.max_lon));
			mapBounds.extend(new google.maps.LatLng(bounds.min_lat, bounds.min_lon));
			nodemap.fitBounds(bounds);
		}
	});
	*/
}

function refreshUserNodeGmap() {
	//google.maps.event.trigger(nodemap, 'resize');
}

function loadUserNodeMapMarkers(){
	var url = SERVICE_ROOT.replace('format=json','format=gmap');
	var args = Object.clone(USER_ARGS);

	var types = "Issue,"+RESOURCE_TYPES_STR+","+EVIDENCE_TYPES_STR;
	if (hasClaim) {
		types += ",Claim";
	}
	if (hasSolution) {
		types += ",Solution";
	}
	if (hasChallenge) {
		types += ",Challenge";
	}

	if (args['filternodetypes'] == "" || types.indexOf(args['filternodetypes']) == -1) {
		args['filternodetypes'] = types;
	}

	args["start"] = 0;
	args["max"] = -1;
	args["orderby"] = "date"; //orderride logindate for users

	var reqUrl = url+"&method=getnodesby"+CONTEXT+"&"+Object.toQueryString(args);
	new Ajax.Request(reqUrl, { method:'get',
  			onSuccess: function(transport){
  					try {
  						var json = transport.responseText.evalJSON();
  					} catch(e) {
  						alert("<?php echo $LNG->GEO_LOADING_ERROR; ?>");
  						($("user-nodegmap-loading")).remove();
  						return;
  					}

	      			if(json.error){
	      				alert("Json error");
	      				alert(json.error[0].message);
	      				($("user-nodegmap-loading")).remove();
	      				return;
	      			}

	      			$('user-nodegmap-count').innerHTML = "";

					var checker = new Array();
					var titleArray = new Array();
					var countArray = new Array();
					var countlocations = 0;

					for(var i=0; i<json.locations.length; i++){
 						var data = json.locations[i];

 						/**
 						 * This was changed to group by country-city names
 						 * becuase Milton Keynes was stored as two differrent long/lats but only very slightly. Maybe other's might be too.
 						 * So you could not see the second ball. This way it puts them together.
 						 * If user's ever get full addresses, this will need to be changed back.
 						 */
						//var key = data.lat+"-"+data.lng;
						var key = data.country+"-"+data.city;

						if (!titleArray[key]) {
							if (data.city) {
								title = data.city;
								titleArray[ key ] = title;
							}
						}

						var desc = nl2br(data.desc);

						if (checker[ key ]) {
							var html = checker[key];
							var newhtml = "<div style='margin: 3px; margin-bottom:6px; clear: both;float:left;'><div style='clear:both;float:left'><img width='20' height='20' class='forminput' style='margin-right:5px;' src='"+data.thumb+"'/>";
							newhtml += "<a href='"+URL_ROOT+"explore.php?id="+data.id+"'>"+ data.title + "</a></div>";
							if (data.user) {
								newhtml += "<div style='clear:both'>- "+data.user+"</div>";
							}
							newhtml += "<div style='margin-top: 3px;margin-bottom: 3px;clear:both;float:left'>"+ desc + "</div></div>";
							html += newhtml;
							checker[ key ] = html;
							countArray[ key ] = countArray[ key ] + 1;
							countlocations = countlocations +1;
						} else {
							var html = "<div style='margin: 3px; margin-bottom:6px; clear: both;float:left;'><div style='clear:both;float:left'><img width='20' height='20' class='forminput' style='margin-right:5px;' src='"+data.thumb+"'/>";
							html += "<a href='"+URL_ROOT+"explore.php?id="+data.id+"'>"+ data.title + "</a></div>";
							if (data.user) {
								html += "<div style='clear:both'>- "+data.user+"</div>";
							}
							html += "<div style='margin-top: 3px;margin-bottom: 3px;clear:both;float:left'>"+ desc + "</div></div>";
							checker[ key ] = html;
							countArray[ key ] = 1;
							countlocations = countlocations +1;
						}
					}

	      			var checkerDone = new Array();

					for(var i=0; i<json.locations.length; i++){
						var data = json.locations[i];

 						/**
 						 * This was changed to group by country-city names
 						 * becuase Milton Keynes was stored as two differrent long/lats but only very slightly. Maybe other's might be too.
 						 * So you could not see the second ball. This way it puts them together.
 						 * If user's ever get full addresses, this will need to be changed back.
 						 */
						//var key = data.lat+"-"+data.lng;
						var key = data.country+"-"+data.city;

						if (!checkerDone[ key ]) {
							var html = "<div style='max-height:200px; overflow-y: auto; width: 350px;'>";
							if (titleArray[ key ]) {
								html += "<h2>"+titleArray[ key ]+" <span id=style='color: black; font-size:10pt'>("+countArray[ key ]+")</span></h2>";
							} else {
								html += "<h2><span id=style='color: black; font-size:10pt'>("+countArray[ key ]+")</span></h2>";
							}

							html += checker[ key ];
							html += "</div>";

							var title = "";
							if (titleArray[ key ]) {
								title = titleArray[ key ] + " (" + countArray[ key ] + ")";
							} else {
								title = "(" + countArray[ key ] + ")";
							}

							createUserNodeMarker(data.lat,data.lng, title, html);
							checkerDone[ key ] = 'true';
						}
					}

					$('user-nodegmap-count').insert("("+countlocations+")");

					DATA_LOADED.usernodegmap = true;
					($("user-nodegmap-loading")).remove();

					if (USER_ARGS['zoomtocountry'] != 'undefined' && USER_ARGS['zoomtocountry'] != "") {
						zoomToCountryUserNode(USER_ARGS['zoomtocountry']);
					}
    		},
    		onFailure: function(e){
    			console.log(e);
    			alert('<?php echo $LNG->GEO_LOADING_ERROR_FAILURE; ?>')
    		}
  		});
}

/**
 * Create a marker with correct listener event
 */
function createUserNodeMarker(lat, lng, title, html) {
	var marker = L.marker([lat,lng], {title: title}).addTo(nodemap);
	marker.bindPopup(html); //.openPopup();
}

loadUserNodeMap();