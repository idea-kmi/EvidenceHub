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
?>

var orgmap;
//var geocoder = new google.maps.Geocoder();

function loadOrgGMap(){

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

	$("tab-content-org-gmap").update(tb3);
	*/

	$("tab-content-org-gmap").insert('<div id="my-orgmap" style="height: 400px; border: 1px solid #aaa"><?php echo $LNG->GEO_BROWSER_INCOMPATIBLE; ?></div>');
	$("tab-content-org-gmap").insert('<div id="org-gmap-loading"></div>');
	$("org-gmap-loading").insert(getLoading("<?php echo $LNG->GEO_ORG_LOADING; ?>"));

	orgmap = L.map('my-orgmap').setView([orgGeoLat, orgGeoLong], orgGeoZoom);
	L.tileLayer('<?php echo $CFG->maptilesurl; ?>', {
	   attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>',
	   maxZoom: 18,
	   crossOrigin: true
	}).addTo(orgmap);

	//orgmap.setZoom(orgGeoZoom);

	// now load in the nodes
	loadOrgMapMarkers();
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

function loadOrgMapMarkers(){
	var url = SERVICE_ROOT.replace('format=json','format=gmap');
	var args = Object.clone(ORG_ARGS);

	var types = "Organization";

	if (args['filternodetypes'] == "" || types.indexOf(args['filternodetypes']) == -1) {
		args['filternodetypes'] = types;
	}

	args["start"] = 0;
	args["max"] = -1;

	var reqUrl = url+"&method=getnodesby"+CONTEXT+"&"+Object.toQueryString(args);
	new Ajax.Request(reqUrl, { method:'get',
  			onSuccess: function(transport){

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

	      			$('org-gmap-count').innerHTML = "";

					var checker = new Array();
					var titleArray = new Array();
					var countArray = new Array();
					var countlocations = 0;

					for(var i=0; i<json.locations.length; i++){
						var data = json.locations[i];
						var key = data.lat+"-"+data.lng;

						if (!titleArray[key]) {
							if (data.city) {
								title = data.title;
								titleArray[ key ] = title;
							}
						}

						var desc = nl2br(data.desc);

						if (checker[ key ]) {
							var html = checker[key];
							var newhtml = "<div style='margin: 3px; margin-bottom:6px; clear: both;float:left;'><div style='clear:both;float:left'>";
							newhtml += "<img class='forminput' style='margin-right:5px;' src='"+data.thumb+"'/>";
							newhtml += "<a href='"+URL_ROOT+"explore.php?id="+data.id+"'>"+ data.title + "</a></div>";
							newhtml += "<div style='margin-bottom: 3px;clear:both;float:left'>"+ desc + "</div></div>";
							html += newhtml;
							checker[ key ] = html;
							countArray[ key ] = countArray[ key ] + 1;
							countlocations = countlocations +1;
						} else {
							var html = "<div style='margin: 3px; margin-bottom:6px; clear: both;float:left;'><div style='clear:both;float:left'>";
							html += "<img class='forminput' style='margin-right:5px;' src='"+data.thumb+"'/>";
							html += "<a href='"+URL_ROOT+"explore.php?id="+data.id+"'>"+ data.title + "</a></div>";
							html += "<div style='margin-bottom: 3px;clear:both;float:left'>"+ desc + "</div></div>";
							checker[key] = html;
							countArray[ key ] = 1;
							countlocations = countlocations +1;
						}
					}

	      			var checkerDone = new Array();

					for(var i=0; i<json.locations.length; i++){
						var data = json.locations[i];
						var key = data.lat+"-"+data.lng;
						if (!checkerDone[ key ]) {
							var html = "<div style='max-height:200px; overflow: auto;width: 250px;'>";
							if (countArray[ key ] > 1) {
								if (titleArray[ key ] ) {
									html += "<h2>"+'<?php echo $LNG->ORGS_NAME; ?>'+" <span id=style='color: black; font-size:10pt'>("+countArray[ key ]+")</span></h2>";
								} else {
									html += "<h2><span id=style='color: black; font-size:10pt'>("+countArray[ key ]+")</span></h2>";
								}
							}

							html += checker[ key ];
							html += "</div>";

							var title = "";
							if (titleArray[ key ]) {
								if (countArray[ key ] == 1) {
									title = titleArray[ key ];
								} else {
									title = '<?php echo $LNG->ORGS_NAME; ?>' + " (" + countArray[ key ] + ")";
								}
							} else {
								if (countArray[ key ] == 1) {
									title = data.title;
								} else {
									title = "(" + countArray[ key ] + ")";
								}
							}

							createOrgMarker(data.lat,data.lng, title, html);
							checkerDone[ key ] = 'true';
						}
					}

					$('org-gmap-count').insert("("+countlocations+")");
					DATA_LOADED.orggmap = true;
					($("org-gmap-loading")).remove();

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
function createOrgMarker(lat, lng, title, html) {

	var marker = L.marker([lat,lng], {title: title}).addTo(orgmap);
	marker.bindPopup(html); //.openPopup();
}


loadOrgGMap();