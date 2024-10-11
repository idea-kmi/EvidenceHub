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

/** Holds functions for communicating with MailChimp account **/

/**
 * Subscribe and evidence hub person to the MailChimp list
 */
function subscribeMailChimpMember($name, $email) {
	global $CFG, $LNG;

	$merge_vars = breakUpName($name);

 	$api_key = $CFG->MAILCHIMP_KEY;
    $data = array(
         'email_address' => $email,
         'status' => 'pending',
         'merge_fields' => $merge_vars
    );

 	$curl = curl_init(); // initialize cURL connection

 	$url = 'https://' . substr($api_key,strpos($api_key,'-')+1) . '.api.mailchimp.com/3.0/lists/' . $CFG->MAILCHIMP_LISTID . '/members/';
	//echo $url;

    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Authorization: Basic '.base64_encode( 'user:'.$api_key )));
    curl_setopt($curl, CURLOPT_USERAGENT, 'PHP-MCAPI/2.0');
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($curl, CURLOPT_TIMEOUT, 10);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data) );

    $response = curl_exec($curl);
	$httpCode = curl_getinfo( $curl, CURLINFO_HTTP_CODE );

	//echo "<br>"."code:".$httpCode."<br>";
	//echo "response:".$response."<br>";

	curl_close($curl);
	$reply = json_decode($response);

	// 204 is a successful delete
	if($httpCode != 200 || $response === false) {
		if ($response !== false) {
			$message = $LNG->MAILCHIMP_SUBSCRIPTION_ERROR_BODY.": ".$email." : ".$reply->status." : ".$reply->title." : ".$reply->detail;
			sendMailMessage($LNG->MAILCHIMP_SUBSCRIPTION_ERROR_SUBJECT." ".$CFG->SITE_TITLE, $CFG->ERROR_ALERT_RECIPIENT, $message);
			//echo $reply;
		} else {
			sendMailMessage($LNG->MAILCHIMP_SUBSCRIPTION_ERROR_SUBJECT." ".$CFG->SITE_TITLE, $CFG->ERROR_ALERT_RECIPIENT, $email." : ".$httpCode);
		}

		return false;
	} else {
		return $reply;
	}

	return false;
}

function editMailChimpMemberName($name, $email) {
	global $CFG, $LNG;

	$merge_vars = breakUpName($name);

 	$api_key = $CFG->MAILCHIMP_KEY;
    $data = array(
         'apikey'        => $api_key,
         'email_address' => $email,
         'merge_fields' => $merge_vars
    );

 	$url = 'https://' . substr($api_key,strpos($api_key,'-')+1) . '.api.mailchimp.com/3.0/lists/' . $CFG->MAILCHIMP_LISTID . '/members/'. md5(strtolower($email));
	//echo $url;

 	$curl = curl_init(); // initialize cURL connection
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Authorization: Basic '.base64_encode( 'user:'.$api_key )));
    curl_setopt($curl, CURLOPT_USERAGENT, 'PHP-MCAPI/2.0');
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'PATCH');
    curl_setopt($curl, CURLOPT_TIMEOUT, 10);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data) );

    $response = curl_exec($curl);
	$httpCode = curl_getinfo( $curl, CURLINFO_HTTP_CODE );

	//echo "<br>"."code:".$httpCode."<br>";
	//echo "response:".$response."<br>";

	curl_close($curl);

	$reply = json_decode($response);

	if($httpCode != 200 || $response === false) {
		if ($response !== false) {
			$message = $LNG->MAILCHIMP_EDIT_ERROR_BODY.": ".$email." : ".$reply->status." : ".$reply->title." : ".$reply->detail;
			sendMailMessage($LNG->MAILCHIMP_EDIT_ERROR_SUBJECT." ".$CFG->SITE_TITLE, $CFG->ERROR_ALERT_RECIPIENT, $message);
		} else {
			sendMailMessage($LNG->MAILCHIMP_EDIT_ERROR_SUBJECT." ".$CFG->SITE_TITLE, $CFG->ERROR_ALERT_RECIPIENT, $email." : ".$httpCode);
		}
		return false;
	} else {
		return $reply;
	}

	return false;
}


function deleteMailChimpMember($email) {
	$id = md5(strtolower($email));

	return deleteMailChimpMemberFromID($id);
}

function deleteMailChimpMemberFromID($id) {
	global $CFG,$LNG;

 	$api_key = $CFG->MAILCHIMP_KEY;

 	$url = 'https://' . substr($api_key,strpos($api_key,'-')+1) . '.api.mailchimp.com/3.0/lists/' . $CFG->MAILCHIMP_LISTID . '/members/'.$id.'/actions/delete-permanent';
	//echo $url;

 	$curl = curl_init(); // initialize cURL connection
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Authorization: Basic '.base64_encode( 'user:'.$api_key )));
    curl_setopt($curl, CURLOPT_USERAGENT, 'PHP-MCAPI/2.0');
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($curl, CURLOPT_TIMEOUT, 10);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

    $response = curl_exec($curl);
	$httpCode = curl_getinfo( $curl, CURLINFO_HTTP_CODE );

	//echo "<br>"."code:".$httpCode."<br>";
	//echo "response:".$response."<br>";

	curl_close($curl);

	$reply = json_decode($response);

	// 204 is a successful delete
	if($httpCode != 204 || $response === false) {
		if ($response !== false) {
			$message = $LNG->MAILCHIMP_UNSUBSCRIBE_ERROR_BODY.": ".$email." : ".$reply->status." : ".$reply->title." : ".$reply->detail;
			sendMailMessage($LNG->MAILCHIMP_UNSUBSCRIBE_ERROR_SUBJECT." ".$CFG->SITE_TITLE, $CFG->ERROR_ALERT_RECIPIENT, $message);
		} else {
			sendMailMessage($LNG->MAILCHIMP_UNSUBSCRIBE_ERROR_SUBJECT." ".$CFG->SITE_TITLE, $CFG->ERROR_ALERT_RECIPIENT, $email." : ".$httpCode);
		}

		return false;
	} else {
		return true;
	}

	return false;
}

function unsubscribeMailChimpMember($email) {

	$id = md5(strtolower($email));
	return unsubscribeMailChimpMemberFromID($id);
}

function unsubscribeMailChimpMemberFromID($id) {
	global $CFG,$LNG;

 	$api_key = $CFG->MAILCHIMP_KEY;
    $data = array(
         'apikey' => $api_key
    );

 	$url = 'https://' . substr($api_key,strpos($api_key,'-')+1) . '.api.mailchimp.com/3.0/lists/' . $CFG->MAILCHIMP_LISTID . '/members/'. $id;
	//echo $url;

 	$curl = curl_init(); // initialize cURL connection
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Authorization: Basic '.base64_encode( 'user:'.$api_key )));
    curl_setopt($curl, CURLOPT_USERAGENT, 'PHP-MCAPI/2.0');
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'DELETE');
    curl_setopt($curl, CURLOPT_TIMEOUT, 10);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data) );

    $response = curl_exec($curl);
	$httpCode = curl_getinfo( $curl, CURLINFO_HTTP_CODE );

	//echo "<br>"."code:".$httpCode."<br>";
	//echo "response:".$response."<br>";

	curl_close($curl);

	$reply = json_decode($response);

	// 204 is a successful delete
	if($httpCode != 204 || $response === false) {
		if ($response !== false) {
			$message = $LNG->MAILCHIMP_UNSUBSCRIBE_ERROR_BODY.": ".$email." : ".$reply->status." : ".$reply->title." : ".$reply->detail;
			sendMailMessage($LNG->MAILCHIMP_UNSUBSCRIBE_ERROR_SUBJECT." ".$CFG->SITE_TITLE, $CFG->ERROR_ALERT_RECIPIENT, $message);
		} else {
			sendMailMessage($LNG->MAILCHIMP_UNSUBSCRIBE_ERROR_SUBJECT." ".$CFG->SITE_TITLE, $CFG->ERROR_ALERT_RECIPIENT, $email." : ".$httpCode);
		}

		return false;
	} else {
		return true;
	}

	return false;
}

function isMailChimpMember($email) {
	global $CFG,$LNG;

	$id = md5(strtolower($email));
 	$api_key = $CFG->MAILCHIMP_KEY;
 	$url = 'https://' . substr($api_key,strpos($api_key,'-')+1) . '.api.mailchimp.com/3.0/lists/' . $CFG->MAILCHIMP_LISTID . '/members/'.$id;

 	$curl = curl_init(); // initialize cURL connection
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Authorization: Basic '.base64_encode( 'user:'.$api_key )));
    curl_setopt($curl, CURLOPT_USERAGENT, 'PHP-MCAPI/2.0');
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
    curl_setopt($curl, CURLOPT_TIMEOUT, 10);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

    $response = curl_exec($curl);
	$httpCode = curl_getinfo( $curl, CURLINFO_HTTP_CODE );

	//echo "code:".$httpCode."<br>";
	//echo "response:".$response."<br>";

	curl_close($curl);
	if($httpCode != 200 || $response === false) {
		return false;
	} else {
		return true;
	}

	return false;
}

function getMailChimpMemberCount() {
	global $CFG;

 	$api_key = $CFG->MAILCHIMP_KEY;
    $data = array(
         'count'        => 50,
         'offset'        => 0
    );

 	$curl = curl_init(); // initialize cURL connection

 	$url = 'https://' . substr($api_key,strpos($api_key,'-')+1) . '.api.mailchimp.com/3.0/lists/' . $CFG->MAILCHIMP_LISTID . '/members/';

    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Authorization: Basic '.base64_encode( 'user:'.$api_key )));
    curl_setopt($curl, CURLOPT_USERAGENT, 'PHP-MCAPI/2.0');
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
    curl_setopt($curl, CURLOPT_TIMEOUT, 10);
    //curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data) );

    $response = curl_exec($curl);
	$httpCode = curl_getinfo( $curl, CURLINFO_HTTP_CODE );

	echo "code:".$httpCode."<br>";
	echo "response:".$response."<br>";

	curl_close($curl);

	$reply = json_decode($response);

	if($httpCode != 200 || $response === false) {
		if ($response !== false) {
			$message = "Error: ".$email." : ".$reply->status." : ".$reply->title." : ".$reply->detail;
			sendMailMessage("getAllMailChimpMembers error ".$CFG->SITE_TITLE, $CFG->ERROR_ALERT_RECIPIENT, $message);
		} else {
			sendMailMessage("getAllMailChimpMembers error ".$CFG->SITE_TITLE, $CFG->ERROR_ALERT_RECIPIENT, $httpCode);
		}
		return false;
	} else {
		return $reply;
	}
}

function getMailChimpMembers() {
	global $CFG;

 	$api_key = $CFG->MAILCHIMP_KEY;
    //$data = array(
    //     'apikey'        => $api_key,
    //     'count'        => 20,
    //     'offset'        => 0
    //);


 	$url = 'https://' . substr($api_key,strpos($api_key,'-')+1) . '.api.mailchimp.com/3.0/lists/' . $CFG->MAILCHIMP_LISTID . '/members/';

 	$curl = curl_init(); // initialize cURL connection
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Authorization: Basic '.base64_encode( 'user:'.$api_key )));
    curl_setopt($curl, CURLOPT_USERAGENT, 'PHP-MCAPI/2.0');
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
    curl_setopt($curl, CURLOPT_TIMEOUT, 10);
    //curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    //curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data) );

    $response = curl_exec($curl);
	$httpCode = curl_getinfo( $curl, CURLINFO_HTTP_CODE );

	//echo "code:".$httpCode."<br>";
	//echo "response:".$response."<br>";

	curl_close($curl);

	$reply = json_decode($response);

	if($httpCode != 200 || $response === false) {
		if ($response !== false) {
			$message = "Error: ".$email." : ".$reply->status." : ".$reply->title." : ".$reply->detail;
			sendMailMessage("getAllMailChimpMembers error ".$CFG->SITE_TITLE, $CFG->ERROR_ALERT_RECIPIENT, $message);
		} else {
			sendMailMessage("getAllMailChimpMembers error ".$CFG->SITE_TITLE, $CFG->ERROR_ALERT_RECIPIENT, $httpCode);
		}
		return false;
	} else {
		return $reply;
	}
}

function breakUpName($name) {
	$fname = $name;
	$lname = "";

	$pos = strrpos($name, " ");
	if ($pos === false) {
		$fname = $name;
		$lname = $name;
	} else {
		$fname = trim(substr($name, 0, $pos));
		$lname = trim(substr($name, $pos, strlen($name)-$pos));
	}

	$fullname = array('FNAME'=>$fname, 'LNAME'=>$lname);
	return $fullname;
}
?>
