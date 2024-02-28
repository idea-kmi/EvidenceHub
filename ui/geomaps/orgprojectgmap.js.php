<?php
/********************************************************************************
 *                                                                              *
 *  (c) Copyright 2021 The Open University UK                                   *
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

var orgprojectmap;
//var geocoder = new google.maps.Geocoder();

function loadOrgProjectGMap(){

	/*
	var tb3 = new Element("div", {'style':'height:40px;'});
	tb3.insert(createThemeFilter(CONTEXT, ORG_ARGS, 'orgs'));
	tb3.insert(createCountryFilter(CONTEXT, ORG_ARGS));

	var print = new Element("img",
		{'src': '<?php echo $HUB_FLM->getImagePath("printer.png"); ?>',
		'alt': 'Print map',
		'title': 'Print map',
		'class': 'active',
		'style': 'padding-top:0px;padding-left:10px;'});
	tb3.insert(print);
	Event.observe(print,'click',function(){
		var call =  URL_ROOT+"ui/popups/printorggeomap.html";
		loadDialog('printnodes', call, 800, 700);
	});

	$("tab-content-orgproject-gmap").update(tb3);
	*/

	$("tab-content-orgproject-gmap").insert('<div id="my-orgprojectmap" style="height: 800px; border: 1px solid #aaa"><?php echo $LNG->GEO_BROWSER_INCOMPATIBLE; ?></div>');
	$("tab-content-orgproject-gmap").insert('<div id="orgproject-gmap-loading"></div>');
	$("orgproject-gmap-loading").insert(getLoading("<?php echo $LNG->GEO_LOADING; ?>"));

	orgprojectmap = L.map('my-orgprojectmap').setView([orgGeoLat, orgGeoLong], orgGeoZoom);
	L.tileLayer('<?php echo $CFG->maptilesurl; ?>', {
	   attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>',
	   maxZoom: 18,
	   crossOrigin: true
	}).addTo(orgprojectmap);

	orgprojectmap.setZoom(orgGeoZoom);

	// now load in the nodes
	loadOrgProjectMapMarkers();
}

function zoomToCountryOrg(country) {
	// Remove everything after comma as it seem to break Google geocode.
	// Bit before comma is enough as it is country name.
	/*
	var ind = country.indexOf(",");
	if (ind != -1) {
		country=country.substr(0, ind);
	}

	if (country == "") { //reset to default
		map.setCenter(new google.maps.LatLng(orgGeoLat, orgGeoLong));
		map.setZoom(orgGeoZoom);
	} else {
		geocoder.geocode( {'address':country}, function(results, status) {
			if (status == google.maps.GeocoderStatus.OK) {
				var bounds = results[0].geometry.bounds;
				mapBounds = new google.maps.LatLngBounds(new google.maps.LatLng(bounds.max_lat, bounds.max_lon));
				mapBounds.extend(new google.maps.LatLng(bounds.min_lat, bounds.min_lon));
				orgmap.fitBounds(bounds);
			}
		});
	}
	*/
}

function loadOrgProjectMapMarkers(){
	var url = SERVICE_ROOT.replace('format=json','format=gmap');
	var args = Object.clone(ORG_ARGS);

	var types = "Organization,Project";
	args['filternodetypes'] = types;

	args["start"] = 0;
	args["max"] = -1;

	var reqUrl = url+"&method=getnodesby"+CONTEXT+"&"+Object.toQueryString(args);
	new Ajax.Request(reqUrl, { method:'get',
  			onSuccess: function(transport){

					//console.log(transport.responseText);

  					try {
  						var json = transport.responseText.evalJSON();
  					} catch(e) {
  						alert("<?php echo $LNG->GEO_LOADING_ERROR; ?>");
  						($("org-gmap-loading")).remove();
  						return;
  					}

	      			if(json.error){
	      				alert("Json error");
	      				alert(json.error[0].message);
	      				($("org-gmap-loading")).remove();
	      				return;
	      			}

	      			$('orgproject-gmap-count').innerHTML = "";

					var checker = new Array();
					var titleArray = new Array();
					var countArrayOrg = new Array();
					var countArrayProject = new Array();
					var countlocations = 0;

					for(var i=0; i<json.locations.length; i++){
						var data = json.locations[i];
						var key = data.lat+"-"+data.lng;

						if (!(key in countArrayOrg)) {
							countArrayOrg[ key ] = 0;
						}

						if (!(key in countArrayProject)) {
							countArrayProject[ key ] = 0;
						}

						if (!titleArray[key]) {
							if (data.city) {
								title = data.title;
								titleArray[ key ] = title;
							}
						}

						var desc = nl2br(data.desc);

						if (checker[ key ]) {
							var html = checker[key];
							var newhtml = "<div style='margin: 3px; margin-bottom:6px; clear: both;float:left;'><div style='clear:both;float:left;'>";
							newhtml += "<img class='forminput' style='margin-right:5px;' src='"+data.thumb+"'/>";
							newhtml += "<a href='"+URL_ROOT+"explore.php?id="+data.id+"'>"+ data.title + "</a></div>";
							newhtml += "<div style='margin-bottom: 3px;clear:both;float:left'>"+ data.nodetype + "</div>";
							newhtml += "<div style='margin-bottom: 3px;clear:both;float:left'>"+ desc + "</div></div>";
							html += newhtml;
							checker[ key ] = html;
							if (data.nodetype == 'Organization') {
								countArrayOrg[ key ] = countArrayOrg[ key ] + 1;
							} else {
								countArrayProject[ key ] = countArrayProject[ key ] + 1;
							}
							countlocations = countlocations +1;
						} else {
							var html = "<div style='margin: 3px; margin-bottom:6px;clear: both;float:left;'><div style='clear:both;float:left'>";
							html += "<img class='forminput' style='margin-right:5px;' src='"+data.thumb+"'/>";
							html += "<a href='"+URL_ROOT+"explore.php?id="+data.id+"'>"+ data.title + "</a></div>";
							html += "<div style='margin-bottom: 3px;clear:both;float:left'>"+ data.nodetype + "</div>";
							html += "<div style='margin-bottom: 3px;clear:both;float:left'>"+ desc + "</div></div>";
							checker[key] = html;
							if (data.nodetype == 'Organization') {
								countArrayOrg[ key ] = countArrayOrg[ key ] + 1;
							} else {
								countArrayProject[ key ] = countArrayProject[ key ] + 1;
							}
							countlocations = countlocations +1;
						}
					}

	      			var checkerDone = new Array();

					for(var i=0; i<json.locations.length; i++){
						var data = json.locations[i];
						var key = data.lat+"-"+data.lng;

						if (!checkerDone[ key ]) {
							var html = "<div style='max-height:200px; overflow: auto;width: 250px;'>";
							if (countArrayOrg[ key ] > 1 || countArrayProject[ key ] > 1) {
								if (titleArray[ key ] ) {
									if (countArrayOrg[ key ] > 1) {
										html += "<h2>"+'<?php echo $LNG->ORGS_NAME; ?>'+" <span id=style='color: black; font-size:10pt'>("+countArrayOrg[ key ]+")</span></h2>";
									}
									if (countArrayProject[ key ] > 1) {
										html += "<h2>"+'<?php echo $LNG->PROJECTS_NAME; ?>'+" <span id=style='color: black; font-size:10pt'>("+countArrayProject[ key ]+")</span></h2>";
									}
								} else {
									const count = countArrayOrg[ key ]+countArrayProject[ key ];
									html += "<h2><span id=style='color: black; font-size:10pt'>("+count+")</span></h2>";
								}
							}

							html += checker[ key ];
							html += "</div>";

							var title = "";
							if (titleArray[ key ]) {
								if ( (countArrayOrg[ key ] == 1 && countArrayProject[ key ] == 0)
								 		|| (countArrayProject[ key ] == 1 && countArrayOrg ==0) ) {
									title = titleArray[ key ];
								} else {
									if (data.nodetype == 'Organization') {
										title = '<?php echo $LNG->ORGS_NAME; ?>' + " (" + countArrayOrg[ key ] + ")";
									} else {
										title = '<?php echo $LNG->PROJECTS_NAME; ?>' + " (" + countArrayProject[ key ] + ")";
									}
								}
							} else {
								if (countArrayOrg[ key ] > 1 || countArrayProject[ key ] > 1) {
									title = data.title;
								} else {
									const count = countArrayOrg[ key ]+countArrayProject[ key ];
									title = "(" + count + ")";
								}
							}

							let icon;

							if (countArrayOrg[ key ] >= 1 && countArrayProject[ key ] == 0) {
								icon = new L.Icon({
								  iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-blue.png',
								  shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
								  iconSize: [25, 41],
								  iconAnchor: [12, 41],
								  popupAnchor: [1, -34],
								  shadowSize: [41, 41]
								});
							} else if (countArrayProject[ key ] >= 1 && countArrayOrg[ key ] == 0) {
								icon = new L.Icon({
								  iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-green.png',
								  shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
								  iconSize: [25, 41],
								  iconAnchor: [12, 41],
								  popupAnchor: [1, -34],
								  shadowSize: [41, 41]
								});
							} else {
								icon = new L.Icon({
								  iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-orange.png',
								  shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
								  iconSize: [25, 41],
								  iconAnchor: [12, 41],
								  popupAnchor: [1, -34],
								  shadowSize: [41, 41]
								});
							}

							createOrgProjectMarker(data.lat,data.lng, title, html, icon);
							checkerDone[ key ] = 'true';
						}
					}

					$('orgproject-gmap-count').insert("("+countlocations+")");
					DATA_LOADED.orgprojectgmap = true;
					($("orgproject-gmap-loading")).remove();

					if (ORG_ARGS['zoomtocountry'] && ORG_ARGS['zoomtocountry'] != 'undefined' && ORG_ARGS['zoomtocountry'] != "") {
						zoomToCountryOrg(ORG_ARGS['zoomtocountry']);
					}
    		},
    		onFailure: function(){
    			alert('<?php echo $LNG->GEO_LOADING_ERROR_FAILURE; ?>')
    		}
  		});
}

/**
 * Create a marker with correct listener event
 */
function createOrgProjectMarker(lat, lng, title, html, icon) {

	var marker = L.marker([lat,lng], {title: title, icon: icon}).addTo(orgprojectmap);
	marker.bindPopup(html); //.openPopup();
}

loadOrgProjectGMap();
