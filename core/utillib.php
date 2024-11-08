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

/**
 * Utility library
 * Misc functions that don not fit anywhere else!
 */

/**
 * Create access denied error message
 *
 * @return Error object
 */
function access_denied_error(){
    global $ERROR;
    $ERROR = new Hub_Error;
    $ERROR->createAccessDeniedError();
    return $ERROR;
}

/**
 * Create duplication error message
 *
 * @return Error object
 */
function duplication_error($error="") {
    global $ERROR;
    $ERROR = new Hub_Error;
    $ERROR->createDuplicationError();
    if ($error != "") {
	    $ERROR->message = $error;
	}
    return $ERROR;
}

/**
 * Create database error message
 *
 * @param string $error (optional error message)
 * @param string $code (optional error code)
 * @return Error object
 */
function database_error($error="", $code=""){
    global $ERROR;
    $ERROR = new Hub_Error;
    $ERROR->createDatabaseError();
    if ($error != "") {
	    $ERROR->message = $error;
	}
    if ($code != "") {
	    $ERROR->code = $code;
    }
    return $ERROR;
}

/**
 * Check whether current user is logged in or not
 *
 * @return Error object
 */
function api_check_login(){
    global $USER;
    if(!isset($USER->userid)){
         return access_denied_error();
    }
    return true;
}

/**
 * Replace chars with their JSON escaped chars. Also removes tabs and escapes line feeds etc which mess up JSON validation
 *
 * @param string $str
 * @return string
 */
function parseToJSON($str) {

	//reverse this from reading in
 	$str = str_replace('&#43;','+',$str);
	$str = str_replace('&#40;','(',$str);
	$str = str_replace('&#41;',')',$str);
	$str = str_replace('&#61;','=',$str);
    $str = str_replace("&quot;", '"', $str);
    $str = str_replace("&#039;", "'", $str);

    $str = str_replace("\r\n", "\n", $str);
    $str = str_replace("\r", "\n", $str);

    // JSON requires new line characters be escaped
    $str = str_replace("\n", "\\n", $str);

    $str = str_replace(chr(9),' ',$str);  // remove tabs
    $str = str_replace("\"",'\\"',$str); // escape double quotes
    return $str;
}

/**
 * Create a unique ID number (UUID v4)
 * Uses the paragonie library to create random numbers and the final UUID,
 * else falls back to an mt_rand version as a totally last resort which should never get reached.
 * https://paragonie.com/blog/2015/07/common-uses-for-csprngs-cryptographically-secure-pseudo-random-number-generators
 *
 * @return string in UUID v4 format
 */
function getUniqueID() {
	try {
		$array = array(
			bin2hex(random_bytes(4)),
			bin2hex(random_bytes(2)),
			bin2hex(chr((ord(random_bytes(1)) & 0x0F) | 0x40)) . bin2hex(random_bytes(1)),
			bin2hex(chr((ord(random_bytes(1)) & 0x3F) | 0x80)) . bin2hex(random_bytes(1)),
			bin2hex(random_bytes(6))
		);
		return implode('-', $array);
	}
	catch(Exception $e) {
		//http://www.php.net/manual/en/function.uniqid.php#94959
		return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
			mt_rand(0, 0xffff), mt_rand(0, 0xffff),
			mt_rand(0, 0xffff),
			mt_rand(0, 0x0fff) | 0x4000,
			mt_rand(0, 0x3fff) | 0x8000,
			mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
		);
	}
}

/**
 * Create a unique ID number (based on users IP address and current time)
 *
 * @return string
 */
function getUniqueIDOld() {

	if (isset($_SERVER['REMOTE_ADDR'])) {
		$newid = preg_replace('/([^A-Za-z0-9])/i', '', $_SERVER['REMOTE_ADDR']);
	} else {
    	$newid = 'unknownip';
    }
    if ($newid == ""){
        $newid = "unknownip";
    }
    $time =  preg_replace('/([^0-9])/i', '', microtime());
    $newid .= $time;

    return $newid;
}

/**
 * Upload an image and place in current user's uploads folder.
 * checking it's actually an image and get it resized to default image size
 * on success return file name;
 * of failure return empty string. Error message go inot $error passed in.
 *
 * @param string $field
 * @param array $errors
 * @return filename or empty string
 */
function uploadImage($field,&$errors,$imagewidth,$directory=""){
    global $CFG, $USER, $LNG, $HUB_FLM;

    if ($directory == "") {
    	if(!isset($USER->userid)){
        	array_push($errors, $LNG->CORE_UNKNOWN_USER_ERROR);
        	return "";
    	} else {
    	 $directory = $USER->userid;
    	}
    }

    if ($_FILES[$field]['tmp_name'] != "") {
        $target_path = $HUB_FLM->createUploadsDirPath($directory."/");
        if(!file_exists($target_path)){
            mkdir($target_path, 0777, true);
        }

        //$dt = time();
        //replace any non alphanum chars in filename
        //should warn user about the file type Gary 2009. 01. 13
        //$t_filename = $dt ."_". basename( preg_replace('/([^A-Za-z0-9.])/i', '',$_FILES[$field]['name']));
        $t_filename =  basename( preg_replace('/([^A-Za-z0-9.])/i', '',$_FILES[$field]['name']));

        //echo "t-filename: " . $t_filename;

        //replace the filetype with png (as the resize image code makes everything a png)
        $filename = preg_replace('/(.[B|b][m|M][p|P]$)/i', '.png', $t_filename);
        $filename = preg_replace('/(.[G|g][i|I][f|F]$)/i', '.png', $t_filename);
        $filename = preg_replace('/(.[J|j][p|P][g|G]$)/i', '.png', $t_filename);
        $filename = preg_replace('/(.[J|j][p|P][e|E][g|G]$)/i', '.png', $t_filename);

       //echo "filename: ".$filename;
       //exit();
        $target_path = $target_path . $filename;

        if(!getimagesize($_FILES[$field]['tmp_name'])){
            array_push($errors,$LNG->CORE_NOT_IMAGE_ERROR);
            return "";
        } else if (filesize($_FILES[$field]['tmp_name']) > $CFG->IMAGE_MAX_FILESIZE) {
            array_push($errors,$LNG->CORE_NOT_IMAGE_TOO_LARGE_ERROR);
            return "";
        } else if(!move_uploaded_file($_FILES[$field]['tmp_name'], $target_path)) {
            array_push($errors,$LNG->CORE_NOT_IMAGE_UPLOAD_ERROR);
            return "";
        }

		// image moved but may still be dodgy.

        //resize image
        if(!resize_image($target_path,$target_path,$imagewidth)){
            //delete the file, it could be dodgy.
			unlink($target_path);
            array_push($errors,$LNG->CORE_NOT_IMAGE_RESIZE_ERROR);
            return "";
        }
       	//create thumnail
       	if (!create_image_thumb($filename, $CFG->IMAGE_THUMB_WIDTH, $directory)){
            //delete the file, it could be dodgy.
			unlink($target_path);
       		array_push($errors,$LNG->CORE_NOT_IMAGE_SCALE_ERROR);
            return "";
       	}
        return $filename;

    }
    return "";
}


/**
 * Upload an image and place in current user's uploads folder.
 * checking it's actually an image and get it resized to the given image size
 * on success return file name;
 * of failure return empty string. Error message go into $error passed in.
 *
 * @param string $field the form field name holding the image information in the $_FILES parameter.
 * @param array $errors and array to hold error messages
 * @param string $directory the directory to place the image in.
 * @param int $maxwidth the maximum width the image can to be
 * @param int $maxheight the maximum height the image can to be
 * @return filename or empty string
 */
function uploadImageToFit($field,&$errors,$directory="",$maxwidth,$maxheight){
    global $CFG, $USER, $LNG, $HUB_FLM;

    if ($directory == "") {
    	if(!isset($USER->userid)){
        	array_push($errors, $LNG->CORE_UNKNOWN_USER_ERROR);
        	return "";
    	} else {
    	 $directory = $USER->userid;
    	}
    }

    if ($_FILES[$field]['tmp_name'] != "") {
        $target_path = $HUB_FLM->createUploadsDirPath($directory."/");
        if(!file_exists($target_path)){
            mkdir($target_path, 0777, true);
        }

        //$dt = time();
        //replace any non alphanum chars in filename
        //should warn user about the file type Gary 2009. 01. 13
        //$t_filename = $dt ."_". basename( preg_replace('/([^A-Za-z0-9.])/i', '',$_FILES[$field]['name']));
        $t_filename =  basename( preg_replace('/([^A-Za-z0-9.])/i', '',$_FILES[$field]['name']));

        //echo "t-filename: " . $t_filename;

        //replace the filetype with png (as the resize image code makes everything a png)
        $filename = preg_replace('/(.[B|b][m|M][p|P]$)/i', '.png', $t_filename);
        $filename = preg_replace('/(.[G|g][i|I][f|F]$)/i', '.png', $t_filename);
        $filename = preg_replace('/(.[J|j][p|P][g|G]$)/i', '.png', $t_filename);
        $filename = preg_replace('/(.[J|j][p|P][e|E][g|G]$)/i', '.png', $t_filename);

       //echo "filename: ".$filename;
       //exit();
        $target_path = $target_path . $filename;

        if(!getimagesize($_FILES[$field]['tmp_name'])){
            array_push($errors,$LNG->CORE_NOT_IMAGE_ERROR);
            return "";
        } else if (filesize($_FILES[$field]['tmp_name']) > $CFG->IMAGE_MAX_FILESIZE) {
            array_push($errors,$LNG->CORE_NOT_IMAGE_TOO_LARGE_ERROR);
            return "";
        } else if(!move_uploaded_file($_FILES[$field]['tmp_name'], $target_path)) {
            array_push($errors,$LNG->CORE_NOT_IMAGE_UPLOAD_ERROR);
            return "";
        }

		$imageinfo = getimagesize ($target_path);
		$width = $imageinfo[0];
		$height = $imageinfo[1];

		//scale
		if ($width > $maxwidth || $height > $maxheight) {

		    $new_width = floatval($maxwidth);
		    $new_height = $height * ($new_width/$width);

		    if($new_height < $maxheight){
				$new_height = floatval($maxheight);
				$new_width = $width * ($new_height/$height);

				if ($new_width >= $maxwidth) {
					if (!resize_image($target_path,$target_path,$maxheight)){
						//delete the file, it could be dodgy
						unlink($target_path);
						array_push($errors,$LNG->CORE_NOT_IMAGE_RESIZE_ERROR);
						return "";
					}
				}
		    } else {
				if (!resize_image($target_path,$target_path,$maxwidth)){
					//delete the file, it could be dodgy
					unlink($target_path);
					array_push($errors,$LNG->CORE_NOT_IMAGE_RESIZE_ERROR);
					return "";
				}
			}
		}

		$imageinfo = getimagesize ($target_path);
		$width = $imageinfo[0];
		$height = $imageinfo[1];

		//error_log($width);
		//error_log($height);

		if ($width < $maxwidth || $height < $maxheight) {
			if (!image_scale_up($target_path,$target_path, $maxwidth, $maxheight)){
				//delete the file, it could be dodgy
				unlink($target_path);
				array_push($errors,$LNG->CORE_NOT_IMAGE_RESIZE_ERROR);
				return "";
			}
		} else if ($width > $maxwidth || $height > $maxheight) {
			if (!crop_image($target_path,$target_path,0, 0, $maxwidth, $maxheight)){
				//delete the file, it could be dodgy
				unlink($target_path);
				array_push($errors,$LNG->CORE_NOT_IMAGE_RESIZE_ERROR);
				return "";
			}
		}

		// why create a thumbnail version?
       	if (!create_image_thumb($filename, $CFG->IMAGE_THUMB_WIDTH, $directory)){
			//delete the file, it could be dodgy
			unlink($target_path);
       		array_push($errors,$LNG->CORE_NOT_IMAGE_SCALE_ERROR);
            return "";
       	}

        return $filename;

    }
    return "";
}

/**
 * Resize an image
 *
 * @param string $in
 * @param string $out
 * @param int $size
 * @return boolean
 */
function resize_image($in,$out,$size){

	$imagetype = @exif_imagetype($in);
	if ($imagetype == IMAGETYPE_JPEG) {
		$image = @imagecreatefromjpeg($in);
	} else if ($imagetype == IMAGETYPE_GIF) {
       $image = @imagecreatefromgif($in);
    } else if ($imagetype == IMAGETYPE_PNG) {
       $image = @imagecreatefrompng($in);
    } else if ($imagetype == IMAGETYPE_BMP) {
       $image = @imagecreatefrombmp($in);
	} else {
      return false;
	}

	if ($image === FALSE) {
		return false;
	}

    $width = imagesx($image);
    $height = imagesy($image);

    //if the 'image' has no width or height it could be dodgy
    if ($width == 0 || $height == 0) {
    	return false;
    }

    $new_width = $width;
    $new_height = $height;

    if($width > 0 && $width > $size){
		$new_width = floatval($size);
		$new_height = $height * ($new_width/$width);
    }

    $image_resized = imagecreatetruecolor($new_width,$new_height);
    imagesavealpha($image_resized, true);
    $trans_colour = imagecolorallocatealpha($image_resized, 0, 0, 0, 127);
    imagefill($image_resized, 0, 0, $trans_colour);

    if (imagecopyresampled($image_resized,$image,0,0,0,0,$new_width,$new_height, $width,$height) === FALSE) {
    	return false;
    }
    if (imagepng($image_resized,$out) === FALSE) {
    	return false;
    }

    return true;
}

/**
 * Crop an image
 *
 * @param string $in
 * @param string $out
 * @param int $size
 * @return boolean
 */
function crop_image($in,$out,$x, $y, $width, $height){

	$imagetype = @exif_imagetype($in);
	if ($imagetype == IMAGETYPE_JPEG) {
		$image = @imagecreatefromjpeg($in);
	} else if ($imagetype == IMAGETYPE_GIF) {
       $image = @imagecreatefromgif($in);
    } else if ($imagetype == IMAGETYPE_PNG) {
       $image = @imagecreatefrompng($in);
    } else if ($imagetype == IMAGETYPE_BMP) {
       $image = @imagecreatefrombmp($in);
	} else {
      	return false;
	}

	if ($image === FALSE) {
		return false;
	}

    $image_cropped = imagecreatetruecolor($width,$height);
    if ($image_cropped === FALSE) {
    	return false;
    }
    if (imagecopy($image_cropped,$image, 0, 0, $x, $y, $width, $height) === FALSE) {
    	return false;
    }
    if (imagepng($image_cropped,$out) === FALSE) {
    	return false;
    }

    return true;
}

function image_scale_up($in,$out, $width, $height) {

	$imagetype = @exif_imagetype($in);
	if ($imagetype == IMAGETYPE_JPEG) {
		$image = @imagecreatefromjpeg($in);
	} else if ($imagetype == IMAGETYPE_GIF) {
       $image = @imagecreatefromgif($in);
    } else if ($imagetype == IMAGETYPE_PNG) {
       $image = @imagecreatefrompng($in);
    } else if ($imagetype == IMAGETYPE_BMP) {
       $image = @imagecreatefrombmp($in);
	} else {
      	return false;
	}

	if ($image === FALSE) {
		return false;
	}

    $actualwidth = imagesx($image);
    $actualheight = imagesy($image);

	if ($actualwidth == 0 || $actualheight == 0) {
		return false;
	}

	if ($actualwidth > $width && $actualheight > $height) {
		return true;
	}

	$image_upped = imagecreatetruecolor($width, $height);
	if ($image_upped === FALSE) {
	  	return false;
	}

	$black = imagecolorallocate($image_upped, 0, 0, 0);

	// Make the background transparent
	imagecolortransparent($image_upped, $black);

	$x = ($width - $actualwidth) / 2;
	$y = ($height - $actualheight) / 2;

    if (imagecopy($image_upped, $image, $x, $y, 0, 0, $actualwidth, $actualheight) === FALSE) {
    	return false;
    }
    if (imagepng($image_upped,$out) === FALSE) {
    	return false;
    }

    return true;
}

/**
 * Creat an thumbnail for an image
 *
 * @param string $image
 * @param int $size
 * @param string $directory
 * @return true
 */
function create_image_thumb($image_name, $size, $directory){
	global $CFG, $USER, $HUB_FLM;
    if ($directory == "") {
    	if(!isset($USER->userid)){
        	return false;
    	} else {
    	 	$directory = $USER->userid;
    	}
    }

    $target_path = $HUB_FLM->createUploadsDirPath($directory."/");

    if(!file_exists($target_path)){
        mkdir($target_path, 0777, true);
    }
	$image = $target_path . $image_name;
	$image_thumb = $target_path . str_replace('.','_thumb.',$image_name);

	if(!resize_image($image,$image_thumb,$size)){
   		return false;
	} else {
   		return true;
	}
}

/**
 * Sends an email of the specified template
 *
 * @param string $email
 * @return boolean
 */
function sendMail($template,$subject,$to,$params){
    global $CFG, $HUB_FLM;
    if($CFG->send_mail){

		//get emailhead and foot
		$headpath = $HUB_FLM->getMailTemplatePath("emailhead.txt");
		$headtemp = loadFileToString($headpath);

		$head = vsprintf($headtemp,array($HUB_FLM->getImagePath('evidence-hub-logo-email.png')));

		$footpath = $HUB_FLM->getMailTemplatePath("emailfoot.txt");
		$foottemp = loadFileToString($footpath);

		//$foot = vsprintf($foottemp,array ($CFG->homeAddress."contact.php"));
		$foot = vsprintf($foottemp,array());

		// load the template
		$templatepath = $HUB_FLM->getMailTemplatePath($template.".txt");
		$template = loadFileToString($templatepath);

		$message = $head . vsprintf($template,$params) .$foot;

		$headers = "Content-type: text/html; charset=utf-8\r\n";
		ini_set("sendmail_from", $CFG->EMAIL_FROM_ADDRESS );
		$headers .= "From: ".$CFG->EMAIL_FROM_NAME ." <".$CFG->EMAIL_FROM_ADDRESS .">\r\n";
		$headers .= "Reply-To: ".$CFG->EMAIL_REPLY_TO."\r\n";

        mail($to,$subject,$message,$headers);
    }
}

/**
 * Sends an email of the specified template
 *
 * @param string $email
 * @return boolean
 */
function sendMailMessage($subject,$to,$message){
    global $CFG, $HUB_FLM;
    if($CFG->send_mail){
		//get emailhead and foot
		$headpath = $HUB_FLM->getMailTemplatePath("emailhead.txt");
		$headtemp = loadFileToString($headpath);

		$head = vsprintf($headtemp,array($HUB_FLM->getImagePath('evidence-hub-logo-email.png')));

		$footpath = $HUB_FLM->getMailTemplatePath("emailfoot.txt");
		$foottemp = loadFileToString($footpath);
		$foot = vsprintf($foottemp,array ($CFG->homeAddress));

		$message = $head.$message.$foot;

		$headers = "Content-type: text/html; charset=utf-8\r\n";
		ini_set("sendmail_from", $CFG->EMAIL_FROM_ADDRESS );
		$headers .= "From: ".$CFG->EMAIL_FROM_NAME ." <".$CFG->EMAIL_FROM_ADDRESS .">\r\n";
		$headers .= "Reply-To: ".$CFG->EMAIL_REPLY_TO."\r\n";

        mail($to,$subject,$message,$headers);
    }
}


/**
 * Method load File into an String.
 *
 * @return string | false
 */
function loadFileToString($file) {
    // If file exists load file into String.
    if(file_exists($file)) {
        return implode('',file($file));
    } else {
        return false;
    }
}

/**
 * Deprecated - Returns a list of country names
 * Code should now reference $LNG variable directly.
 * This now just returns $LNG->COUNTRIES_LIST;
 *
 * @uses $LNG
 * @return array
 */
function getCountryList() {
    global $LNG;
	return $LNG->COUNTRIES_LIST;
}

/**
 * Geocode a location
 *
 * @uses $CFG
 * @param string $loc
 * @param string $cc country code for location
 * @return array
 */
function geoCode($loc,$cc) {
	return geoCodeAddress("","","",$loc, $cc);
}

/**
 * Geocode a location
 *
 * @uses $CFG
 * @param string $loc
 * @param string $cc country code for location
 * @return array
 */
function geoCodeAddress($address1, $address2, $postcode, $loc, $cc) {
    global $CFG;

    $geo = array("lat"=>"", "lng"=>"");

	if (isset($CFG->BINGMAPS_KEY) && $CFG->BINGMAPS_KEY !== "") {

		$address = "";
		if (isset($address1) && $address1 != "") {
			$address .= $address1.",";
		}
		if (isset($address2) && $address2 != "") {
			$address .= $address2.",";
		}
		if (isset($postcode) && $postcode != "") {
			$address .= $postcode.",";
		}
		if (isset($loc) && $loc != "") {
			$address .= $loc.",";
		}
		if (isset($cc) && $cc != "") {
			$address .= $cc.",";
		}

		// BING
		$geocodeURL = "http://dev.virtualearth.net/REST/v1/Locations?q=".urlencode($address)."&output=xml&key=".$CFG->BINGMAPS_KEY;
		//https://nominatim.org/release-docs/develop/api/Search/ - possible OpenStreet Map alternative

		// Was not working for some reason.
		//$response = callGeoURL($geocodeURL);

		$rgOutput = file_get_contents($geocodeURL);
		$geodata = new SimpleXMLElement($rgOutput);

		if (isset($geodata) && isset($geodata->ResourceSets[0]->ResourceSet[0]->Resources[0]->Location->GeocodePoint)) {
			try {
				//$geodata = json_decode($response);
				// $geoPoint = $geodata->resourceSets[0]->resources[0]->point->coordinates; // json
				//$geo["lat"] = sprintf($geoPoint[0]);
				//$geo["lng"] = sprintf($geoPoint[1]);

				$geoPoint = $geodata->ResourceSets[0]->ResourceSet[0]->Resources[0]->Location->GeocodePoint; // XML
				$geo["lat"] = $geoPoint->Latitude;
				$geo["lng"] = $geoPoint->Longitude;
			} catch (Exception $e) {
				error_log(print_r($e, true));
			}
		}
	}

    return $geo;
}

function callGeoURL($url) {

	$curl = curl_init();
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_URL, $url);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	$response = curl_exec($curl);
	$httpCode = curl_getinfo( $curl, CURLINFO_HTTP_CODE );
	curl_close($curl);

	//error_log(print_r("RESPONSE=".$response, true));
	//error_log("code=".$httpCode);

	if($httpCode != 200 || $response === false) {
		return false;
    } else {
		return $response;
	}
}

/**
 * Starts With
 *
 * @param string $haystack
 * @param string $needle
 * @return boolean
 */
function startsWith($haystack, $needle) {
    return strpos($haystack, $needle) === 0;
}

/**
 * Ends With
 *
 * @param string $haystack
 * @param string $needle
 * @return boolean
 */
function endsWith($haystack, $needle) {
    return substr($haystack, -strlen($needle)) == $needle;
}

/**
 * Remove any trailing comma from given string.
 * @param $str the string to remove the trailing comma from.
 * @return String with any trailing comma removed.
 */
function trimFinalComma($str) {
	if (substr($str, strlen($str)-1, strlen($str)) == ",") {
		$str = substr($str, 0, strlen($str)-1);
	}
	return $str;
}

/**
 * Ends With
 *
 * @param string $FullStr
 * @param string $EndStr
 * @return boolean
 */
/*function endsWith($FullStr, $EndStr){
    // Get the length of the end string
    $StrLen = strlen($EndStr);
    // Look at the end of FullStr for the substring the size of EndStr
    $FullStrEnd = substr($FullStr, strlen($FullStr) - $StrLen);
    // If it matches, it does end with EndStr
    return $FullStrEnd == $EndStr;
}*/


/**
 * Process network search results and flatten into one array.
 */
function getDepthConnectionResults(&$results, $nextArray) {
	foreach ( $nextArray as $key=>$val ){
		$count = count($val);
		for ($j = 0; $j<$count; $j++) {
			$next = $val[$j];
			if (isset($next["TripleID"])) {
				$results[count($results)] = $next;
			} else {
				getDepthConnectionResults($results, $next);
			}
		}
	}
}

/** EVIDENCE HUB SPECIFIC FUNCTIONS **/

function updateConnectionsForTypeChange($nodeid, $type) {
    global $USER,$CFG;

    $connectionSet = getConnectionsByNode($nodeid, 0, -1);
    $connections = $connectionSet->connections;
	$count = count($connections);

	for ($i= 0; $i < $count; $i++) {
		$con = $connections[$i];
		if ($con->from->nodeid == $nodeid) {
			$currentuser = $USER;
			$conUserID = $con->userid;
			$conUser = new User($conUserID);
			$conUser->load();
			$USER = $conUser;

			$r = getRoleByName($type);
			$roleid = $r->roleid;

			$con->edit($con->from->nodeid, $roleid,$con->linktype->linktypeid,$con->to->nodeid,$con->torole->roleid,$con->private,$con->description);

			$USER = $currentuser;
		} else if ($con->to->nodeid == $nodeid) {
			$currentuser = $USER;
			$conUserID = $con->userid;
			$conUser = new User($conUserID);
			$conUser->load();
			$USER = $conUser;

			$r = getRoleByName($type);
			$roleid = $r->roleid;

			$con->edit($con->from->nodeid,$con->fromrole->roleid,$con->linktype->linktypeid,$con->to->nodeid,$roleid,$con->private,$con->description);

			$USER = $currentuser;
		}
	}
}

function isProbablyHTML($str) {
	return preg_match('#(?<=<)\w+(?=[^<]*?>)#', $str);
}

function removeHTMLTags($htmlString) {
	$cleanString = "";
	if(isset($htmlString)){
		$doc = new DOMDocument();
		$doc->loadHTML($htmlString);
		$xpath = new DOMXPath($doc);
		$textnodes = $xpath->query('//text()');
		foreach ($textnodes as $textNode) {
		    $cleanString .= $textNode->data." ";
		}
  	}

  	return trim($cleanString);
}


/**
 * Return the node type text for a given node type label
 * @param $nodetype the node type for node to return the text for
 * @param $withColon true if you want a colon adding after the node type name, else false (default = true).
 */
function getNodeTypeText($nodetype, $withColon=true) {
	global $LNG, $CFG;

	$title="";

	if ($nodetype == 'Challenge') {
		$title = $LNG->CHALLENGE_NAME;
	} else if ($nodetype == 'Issue') {
		$title = $LNG->ISSUE_NAME;
	} else if ($nodetype == 'Claim') {
		$title = $LNG->CLAIM_NAME;
	} else if ($nodetype == 'Solution') {
		$title = $LNG->SOLUTION_NAME;
	} else if ($nodetype == 'Organization') {
		$title = $LNG->ORG_NAME;
	} else if ($nodetype == 'Project') {
		$title = $LNG->PROJECT_NAME;
	} else if ($nodetype == 'Evidence' || in_array($nodetype, $CFG->EVIDENCE_TYPES)) {
		$title = $LNG->EVIDENCE_NAME." (".$nodetype.")";
	} else if ($nodetype == 'Resource' || in_array($nodetype, $CFG->RESOURCE_TYPES)) {
		$title = $LNG->RESOURCE_NAME." (".$nodetype.")";
	} else if ($nodetype == 'Theme') {
		$title = $LNG->THEME_NAME;
	} else if ($nodetype == 'Comment') {
		$title = $LNG->COMMENT_NAME;
	} else if ($nodetype == 'Pro') {
		$title = $LNG->PRO_NAME;
	} else if ($nodetype == 'Con') {
		$title = $LNG->CON_NAME;
	} else if ($nodetype == 'News') {
		$title = $LNG->NEWS_NAME;
	}

	if ($withColon) {
		$title .= ": ";
	}

	return $title;
}

/**
 * Add to the log
 * @param string $action
 * @param string $type
 * @param string $id
 * @return Result or Error
 */
function addToLog($action,$type,$id){
    $l = new Log();
    return $l->add($action,$type,$id);
}

/**
 * Generate a digital random number for registration keys of the given length
 * - Original code by By Damian Dadswell -
 * @param $keylength the length of the key to generate
 * return the random number.
 */
function createRegistrationKey($keylength=20) {

	$registration = "";
	$newlength = 0;
	while($newlength < $keylength) {
		$x=1;
		$y=3;
		$part = rand($x,$y);
		if($part==1){$a=48;$b=57;}  // Numbers
		if($part==2){$a=65;$b=90;}  // UpperCase
		if($part==3){$a=97;$b=122;} // LowerCase

		$code_part=chr(rand($a,$b));

		$newlength = $newlength + 1;
		$registration = $registration.$code_part;
	}

	return $registration;

}

/**
 * Delete the given directory
 *
 * [EDITOR NOTE: "Credits to erkethan at free dot fr." - thiago]
 */
function deleteDirectory($dir) {
    if (!file_exists($dir)) return true;

    if (!is_dir($dir) || is_link($dir)) return unlink($dir);

	foreach (scandir($dir) as $item) {
		if ($item == '.' || $item == '..') continue;
		if (!deleteDirectory($dir . "/" . $item)) {
			chmod($dir . "/" . $item, 0777);
			if (!deleteDirectory($dir . "/" . $item)) return false;
		};
	}
	return rmdir($dir);
}

function getTagString($nodeid) {
	$node = getNode($nodeid);
	$tagstr = "";
	if ($nodeid != "" && !$node instanceof Hub_Error) {
		if (isset($node->tags)) {
			$tags = $node->tags;
			$tagstr = "";
			$i = 0;
			foreach($tags as $tag){
				if ($i == 0) {
					$tagstr .= $tag->name;
				} else {
					$tagstr .= ",".$tag->name;
				}
				$i++;
			}
		}
	}
	return $tagstr;
}

/**
 * What browser are they using.
 */
function getUserBrowser() {

    $u_agent = $_SERVER['HTTP_USER_AGENT'];
    $browser = '';
    if (preg_match('/MSIE/i',$u_agent)) {
        $browser = "ie";
    } elseif(preg_match('/Firefox/i',$u_agent)) {
        $browser = "firefox";
    } else if(preg_match('/Safari/i',$u_agent)) {
        $browser = "safari";
    } else if(preg_match('/Chrome/i',$u_agent)) {
        $browser = "chrome";
    } else if(preg_match('/Flock/i',$u_agent)) {
        $browser = "flock";
    } else if(preg_match('/Opera/i',$u_agent)) {
        $browser = "opera";
    }

    return $browser;
}

/**
 * Sort objects by name value. Same as nameSortASC
 */
function nameSort($a,$b) {
	return strcmp($a->name, $b->name);
}

/**
 * Sort objects by name value Ascending
 */
function nameSortASC($a,$b) {
	return strcmp($a->name, $b->name);
}

/**
 * Sort objects by name value Descending
 */
function nameSortDESC($a,$b) {
	$results = strcmp($a->name, $b->name);
	if ($results < 0) {
		return 1;
	} else if ($results > 0) {
		return -1;
	} else {
		return 0;
	}
}

/**
 * Sort objects by role name value Ascending after sending through getNodeTypeText(role, false)
 */
function roleTextSortASC($a,$b) {
	$role1 = getNodeTypeText($a->role->name, false);
	$role2 = getNodeTypeText($b->role->name, false);
	return strcmp($role1, $role2);
}

/**
 * Sort objects by role name value Descending after sending through getNodeTypeText(role, false)
 */
function roleTextSortDESC($a,$b) {
	$role1 = getNodeTypeText($a->role->name, false);
	$role2 = getNodeTypeText($b->role->name, false);
	$results = strcmp($role1, $role2);
	if ($results < 0) {
		return 1;
	} else if ($results > 0) {
		return -1;
	} else {
		return 0;
	}
}

/**
 * Sort objects by name value
 */
function nameArraySortASC($a,$b) {
	return strcmp($a['Name'], $b['Name']);
}

/**
 * Sort objects by name value
 */
function nameArraySortDESC($a,$b) {
	$results = strcmp($a['Name'], $b['Name']);
	if ($results < 0) {
		return 1;
	} else if ($results > 0) {
		return -1;
	} else {
		return 0;
	}
}

/**
 * Sort objects by name value
 */
function descArraySortASC($a,$b) {
	return strcmp($a['Description'], $b['Description']);
}

/**
 * Sort objects by name value
 */
function descArraySortDESC($a,$b) {
	$result = strcmp($a['Description'], $b['Description']);
	if ($results < 0) {
		return 1;
	} else if ($results > 0) {
		return -1;
	} else {
		return 0;
	}
}

/**
 * Sort objects by description value
 */
function descSort($a,$b) {
	if (isset($a->description) && isset($b->description)) {
		return strcmp($a->description, $b->description);
	} else {
		return 0;
	}
}

/**
 * Sort objects by title value
 */
function titleSort($a,$b) {
	if (isset($a->title) && isset($b->title)) {
		return strcmp($a->title, $b->title);
	} else {
		return 0;
	}
}

/**
 * Return a comma separated list of all node types names.
 */
function getAllNodeTypeNames() {
	global $CFG;

	$nodetypes = "";

	$count = count($CFG->BASE_TYPES);
	for($i=0; $i<$count; $i++){
		if ($CFG->BASE_TYPES[$i] != "Theme") {
			if ($i == 0) {
				$nodetypes .= $CFG->BASE_TYPES[$i];
			} else {
				$nodetypes .= ",".$CFG->BASE_TYPES[$i];
			}
		}
	}
	$count = count($CFG->EVIDENCE_TYPES);
	for ($i=0; $i<$count; $i++) {
		$nodetypes .= ",".$CFG->EVIDENCE_TYPES[$i];
	}
	$count = count($CFG->RESOURCE_TYPES);
	for ($i=0; $i<$count; $i++) {
		$nodetypes .= ",".$CFG->RESOURCE_TYPES[$i];
	}
	$count = count($CFG->COMMENT_TYPES);
	for ($i=0; $i<$count; $i++) {
		$nodetypes .= ",".$CFG->COMMENT_TYPES[$i];
	}

	return $nodetypes;
}
?>
