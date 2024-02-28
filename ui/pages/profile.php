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

    $me = substr($_SERVER["PHP_SELF"], 1); // remove initial '/'
    if ($HUB_FLM->hasCustomVersion($me)) {
    	$path = $HUB_FLM->getCodeDirPath($me);
    	include_once($path);
		die;
	}

	checkLogin();

    require_once($HUB_FLM->getCodeDirPath("core/mailchimp.php"));

    $errors = array();

    $email = optional_param("email",$USER->getEmail(),PARAM_TEXT);
    $fullname = optional_param("fullname",$USER->name,PARAM_TEXT);
    $description = optional_param("description",$USER->description,PARAM_TEXT);

    $homepage = optional_param("homepage",$USER->website,PARAM_URL);
    $homepage2 = optional_param("homepage",$USER->website,PARAM_TEXT);

    $privatedata = optional_param("defaultaccess",'N',PARAM_ALPHA);
    $mailchimpnews = optional_param("mailchimpnews","",PARAM_TEXT);
    $recentactivitiesemail = optional_param("recentactivitiesemail","",PARAM_TEXT);
    if ($recentactivitiesemail == "") {
    	$recentactivitiesemail = 'N';
    }

    $location = optional_param("location",$USER->location,PARAM_TEXT);
    $loccountry = optional_param("loccountry",$USER->countrycode,PARAM_TEXT);

    $newtags = optional_param("newtags","",PARAM_TEXT);
    $removetagsarray = optional_param("removetags","",PARAM_TEXT);

	$u = new User($USER->userid);
	$user = $u->load();
   	$tags = array();
    if(isset($user->tags)) {
    	$tags = $user->tags;
    }

    $countries = getCountryList();

	if(isset($_POST["update"])){

		$oldemail = $user->getEmail();
		$oldname = $user->name;
		$emailChanged = false;

        // check email,& full name provided
        if (!validEmail($email)) {
            array_push($errors,$LNG->PROFILE_INVALID_EMAIL_ERROR);
        } else {
            // update email address only if it has changed or it will unset the email validation
            if (strcmp($email,$oldemail) != 0) {
				if(!$user->updateEmail($email)){
					array_push($errors, $LNG->PROFILE_EMAIL_IN_USE_ERROR);
				} else {
					// If they have changed their email address, send an email addressw validation email
					$paramArray = array ($user->name,$CFG->SITE_TITLE,$CFG->homeAddress,$user->userid,$user->getRegistrationKey());
					sendMail("validate",$LNG->VALIDATE_REGISTER_SUBJECT,$user->getEmail(),$paramArray);

					include_once($HUB_FLM->getCodeDirPath("ui/header.php"));
					echo '<script type="text/javascript">';
					echo 'fadeMessage("'.$user->name.'<br><br>'.$LNG->PROFILE_EMAIL_VALIDATE_MESSAGE.'");';
					echo '</script>';

					$emailChanged = true;
				}
			}
        }

        if ($fullname == ""){
            array_push($errors,$LNG->PROFILE_FULL_NAME_ERROR);
        } else {
            $user->updateName($fullname);
        }

        // update description and homepage
        $user->updateDescription($description);

        if($homepage2 != "" && $homepage != $homepage2){
            array_push($errors, $LNG->PROFILE_HOMEPAGE_URL_ERROR);
            $homepage = $homepage2;
        } else {
            $user->updateWebsite($homepage);
        }

        $user->updatePrivate($privatedata);

        $user->updateLocation($location,$loccountry);

        // update photo
        $photofilename = uploadImage('photo',$errors,$CFG->IMAGE_WIDTH);
        if($photofilename != ""){
            $user->updatePhoto($photofilename);
        }

        // remove from this user any tags marked for removal
        if($removetagsarray != "" && is_countable($removetagsarray) && count($removetagsarray) > 0){
            for($i=0; $i<count($removetagsarray); $i++){
                if($removetagsarray[$i] != ""){
            		$user->removeTag($removetagsarray[$i]);
            	}
            }
        }

        // Add any new tags
        $newtagsarray = explode(',', $newtags);
        if(is_countable($newtagsarray) && count($newtagsarray) != 0){
            foreach($newtagsarray as $tagname){
            	$tagname = trim($tagname);
            	if ($tagname && $tagname != "") {
                	$tag = addTag($tagname);
                	if (!$tag instanceof Hub_Error && $tag->tagid) {
                		$user->addTag($tag->tagid);
                	}
            	}
            }
        }

		// Recent Activities Email
		if ($CFG->RECENT_EMAIL_SENDING_ON) {
			$olddigest = $user->recentactivitiesemail;
			if ($olddigest != $recentactivitiesemail) {
				$user->updateRecentActivitiesEmail($recentactivitiesemail);
			}
		}

		// MailChimp bit
		if ($CFG->MAILCHIMP_ON) {
			$oldmailchimpnews = $user->newsletter;

			if ($oldmailchimpnews == 'N' && $mailchimpnews == 'Y') {
				if (subscribeMailChimpMember($fullname, $email)) {
					$user->updateNewsletter($mailchimpnews);
					echo $LNG->MAILCHIMP_NEWSLETTER_FORM_SUBSCRIPTION_SUCCESS."<br><br>";
				} else {
					array_push($errors, $LNG->MAILCHIMP_NEWSLETTER_FORM_SUBSCRIPTION_FAILED);
				}
			} else if ($oldmailchimpnews == 'Y' && $mailchimpnews == 'N') {
				if (unsubscribeMailChimpMember($oldemail)) {
					$user->updateNewsletter('N');
				} else {
					array_push($errors, $LNG->MAILCHIMP_NEWSLETTER_FORM_UNSUBSCRIPTION_FAILED);
				}
			} else if ($oldmailchimpnews == 'Y' && $mailchimpnews == 'Y' && $email != $oldemail) {
				if (unsubscribeMailChimpMember($oldemail)) {
					if (!subscribeMailChimpMember($fullname, $email)) {
						array_push($errors, $LNG->MAILCHIMP_NEWSLETTER_FORM_SUBSCRIPTION_FAILED_NEW_EMAIL);
					}
				} else {
					array_push($errors, $LNG->MAILCHIMP_NEWSLETTER_FORM_UNSUBSCRIPTION_FAILED_OLD_EMAIL);
				}
			} else if ($oldmailchimpnews == 'Y' && $mailchimpnews == 'Y' && $oldname != $fullname) {
				if (!editMailChimpMemberName($fullname, $email)) {
					array_push($errors, $LNG->MAILCHIMP_NEWSLETTER_FORM_EDIT_NAME_FAILED);
				}
			}
		}

        $USER = new User($_SESSION["session_userid"]);
        $USER->load();

        if(empty($errors)){
        	if ($emailChanged) {
				$redirecturl = $CFG->homeAddress."ui/pages/logout.php";
				echo "<script type='text/javascript'>";
				echo "window.location.href = '".$redirecturl."';";
				echo "</script>";
        	} else {
				$redirecturl = $CFG->homeAddress."user.php?userid=".$user->userid;
				echo "<script type='text/javascript'>";
				echo "window.location.href = '".$redirecturl."';";
				echo "</script>";
			}
        }
    } else if (isset($_POST["validateemail"])) { //needs to be after login as it is inside that form
		// send email to validate email address
		if (!$user->isEmailValidated()) {
			$user->resetRegistrationKey();
	   		$paramArray = array ($user->name,$CFG->SITE_TITLE,$CFG->homeAddress,$user->userid,$user->getRegistrationKey());
			sendMail("validateexisting",$LNG->VALIDATE_REGISTER_SUBJECT,$user->getEmail(),$paramArray);

		    include_once($HUB_FLM->getCodeDirPath("ui/header.php"));
			echo '<script type="text/javascript">';
			echo 'fadeMessage("'.$user->name.'<br><br>'.$LNG->PROFILE_EMAIL_VALIDATE_MESSAGE.'");';
			echo '</script>';
		}
	} else {
		$recentactivitiesemail = $USER->recentactivitiesemail;

		if ($CFG->MAILCHIMP_ON) {
			$isMember = $USER->newsletter;
			//Check if they have unsubscribed through mailchimp.
			if ($isMember == 'Y') {
				if ( !isMailChimpMember($USER->getEmail()) ) {
					$USER->updateNewsletter('N');
					$isMember == 'N';
				}
			}

			$mailchimpnews = $isMember;
		}

	    include_once($HUB_FLM->getCodeDirPath("ui/header.php"));
    }

    echo '<h1>'.$LNG->PROFILE_TITLE;
    if ($USER->getAuthType() == $CFG->AUTH_TYPE_EVHUB) {
    	echo '<span style="margin-left:3-px; font-size: 10pt;"><a style="margin-left: 30px;" href="'.$CFG->homeAddress.'ui/pages/changepassword.php">'.$LNG->PROFILE_CHANGE_PASSWORD_LINK.'</a></span>';
    }
    echo '</h1>';
?>

<?php
if(!empty($errors)){
    echo "<div class='errors'>".$LNG->FORM_ERROR_MESSAGE.":<ul>";
    foreach ($errors as $error){
        echo "<li>".$error."</li>";
    }
    echo "</ul></div>";
}
?>

<script type="text/javascript">

function toggleTags() {
	if ( $("tagsdiv").style.display == "block") {
		$("tagsdiv").style.display = "none";
		$("tagsimg").src="<?php echo $HUB_FLM->getImagePath('arrow-right2.png'); ?>";
	} else {
		$("tagsdiv").style.display = "block";
		$("tagsimg").src="<?php echo $HUB_FLM->getImagePath('arrow-down2.png'); ?>";
	}
}

function checkForm() {

	var originalemail = '<?php echo $email; ?>';
	var email = ($('email').value).trim();

	if (email != originalemail){
		var ans = confirm("<?php echo $LNG->PROFILE_EMAIL_CHANGE_CONFIRM; ?>");
		if (ans){
			return true;
		} else {
			return false;
		}
	}

    $('editprofile').style.cursor = 'wait';
	return true;
}


</script>

<p><span class="required">*</span> <?php echo $LNG->FORM_REQUIRED_FIELDS; ?></p>

<form id="editprofile" name="editprofile" action="" method="post" enctype="multipart/form-data" onsubmit="return checkForm();">

    <div class="formrow">
    <label class="formlabel" for="photo"><?php echo $LNG->PROFILE_PHOTO_CURRENT_LABEL; ?></label>
    <img class="forminput" src="<?php print $USER->photo; ?>"/>
    </div>
    <div class="formrow">
    <label class="formlabel" for="photo"><?php echo $LNG->PROFILE_PHOTO_REPLACE_LABEL; ?></label>
    <input class="forminput" type="file" id="photo" name="photo" size="40">
    </div>
    <div class="formrow">
        <label class="formlabel" for="email"><?php echo $LNG->FORM_REGISTER_EMAIL; ?>
			<span class="required">*</span>
		</label>

		<?php if ($USER->getAuthType() == $CFG->AUTH_TYPE_EVHUB) { ?>
	        <input class="forminput" id="email" name="email" size="40" value="<?php print $email; ?>">

			<?php if ($user->isEmailValidated()) { ?>
				<img style="margin-left:5px;" title="<?php echo $LNG->PROFILE_EMAIL_VALIDATE_COMPLETE;?>" src="<?php echo $HUB_FLM->getImagePath('tick.png'); ?>" border="0" />
			<?php } else { ?>
				<input type="hidden" id="userid" name="userid" value="'.$user->userid.'" />
				<input type="hidden" id="validateemail" name="validateemail" value="" />
				<input type="submit" title="<?php echo $LNG->PROFILE_EMAIL_VALIDATE_HINT; ?>" id="validateemail" name="validateemail" value="<?php echo $LNG->PROFILE_EMAIL_VALIDATE_TEXT; ?>" />
			<?php } ?>
		<?php } else { ?>
	        <input disabled class="forminput" id="email" name="email" size="40" value="<?php print $email; ?>">

			<?php if ($USER->getAuthType() == 'facebook') { ?>
				<img style="margin-left:5px;" src="<?php echo $HUB_FLM->getImagePath('icons/facebook.png'); ?>" width="24" height="24" border="0" />
			<?php } else if ($USER->getAuthType() == 'google') { ?>
				<img style="margin-left:5px;" src="<?php echo $HUB_FLM->getImagePath('icons/google.png'); ?>" width="24" height="24" border="0" />
			<?php } else if ($USER->getAuthType() == 'yahoo') { ?>
				<img style="margin-left:5px;" src="<?php echo $HUB_FLM->getImagePath('icons/yahoo.png'); ?>" width="24" height="24" border="0" />
			<?php } else if ($USER->getAuthType() == 'linkedin') { ?>
				<img style="margin-left:5px;" src="<?php echo $HUB_FLM->getImagePath('icons/linkedin.png'); ?>" width="24" height="24" border="0" />
			<?php } else if ($USER->getAuthType() == 'twitter') { ?>
				<img style="margin-left:5px;" src="<?php echo $HUB_FLM->getImagePath('icons/twitter.png'); ?>" width="24" height="24" border="0" />
			<?php } ?>
		<?php } ?>

    </div>

    <div class="formrow">
        <label class="formlabel" for="fullname"><?php echo $LNG->FORM_REGISTER_NAME; ?>
			<span class="required">*</span>
        </label>
        <input class="forminput" type="text" id="fullname" name="fullname" size="40" value="<?php print $fullname; ?>">
    </div>
    <div class="formrow">
        <label class="formlabel" for="description"><?php echo $LNG->PROFILE_DESC_LABEL; ?></label>
        <textarea class="forminput" id="description" name="description" cols="40" rows="5"><?php print $description; ?></textarea>
    </div>

    <div class="formrow">
		<label class="formlabel" for="location"><?php echo $LNG->PROFILE_LOCATION; ?></label>
		<input class="forminput" id="location" name="location" style="width:160px;" value="<?php echo $location; ?>">
		<select id="loccountry" name="loccountry" style="margin-left: 5px;width:160px;">
	        <option value="" ><?php echo $LNG->PROFILE_COUNTRY; ?></option>
	        <?php
	            foreach($countries as $code=>$c){
	                echo "<option value='".$code."'";
	                if($code == $loccountry){
	                    echo " selected='true'";
	                }
	                echo ">".$c."</option>";
	            }
	        ?>
	    </select>
	</div>

	<?php if ($CFG->hasUserHomePageOption) { ?>
    <div class="formrow">
        <label class="formlabel" for="homepage"><?php echo $LNG->PROFILE_HOMEPAGE; ?></label>
        <input class="forminput" type="text" id="homepage" name="homepage" size="40" value="<?php print $homepage; ?>">
    </div>
    <?php } ?>

    <div class="formrow">
	<label class="formlabel" for="newtags"><?php echo $LNG->FORM_LABEL_TAGS; ?></label>
	<input class="forminput" style="width:290px; font-size: 10pt;" id="newtags" name="newtags" value="<?php echo $newtags; ?>" /> <?php echo $LNG->FORM_LABEL_TAGS_HINT; ?>
	</div>

	<div class="formrow">
		<?php if (is_countable($tags) && count($tags) > 0) { ?>
	    <label class="formlabel"><?php echo $LNG->FORM_LABEL_ADDED_TAGS; ?> <img style="vertical-align: bottom;" id="tagsimg" src="<?php echo $HUB_FLM->getImagePath('arrow-right2.png'); ?>" onclick="javascript: toggleTags()" border="0" alt="Tags" /></label>
		<div id="tagsdiv" class="forminput" style="display: none; float:left">
		   	<div class="subform" style="" id="tagform">
		   	<?php
		            $i = 0;
		            foreach($tags as $tag){
		              $class = "subforminput";
		              echo '<div id="tagfield'.$i.'" class="subformrow">';
	                  echo '<input type="checkbox" class="'.$class.'" id="removetags" name="removetags[]" value="'.$tag->tagid.'"';
		              if($removetagsarray != "" && is_countable($removetagsarray) && count($removetagsarray) > 0){
		                  for($j=0; $j<count($removetagsarray); $j++){
			            	  if ($removetagsarray[$j] != ""
			            		  && $removetagsarray[$j] == $tag->tagid) {
			                      echo ' checked="true"';
			            		  break;
			            	  }
		                  }
		              }
	                  echo '>&nbsp;&nbsp;'.$tag->name.'<br/>';
		              echo '</div>';
		              $i++;
		          }
		      ?>
		      <label><?php echo $LNG->FORM_LABEL_ADDED_TAGS_HINT; ?></label>
		  </div>
	   </div>
	<?php } ?>
	</div>

	<?php if ($CFG->RECENT_EMAIL_SENDING_ON) { ?>
		<div class="formrow">
			<label class="formlabel" for="recentactivitiesemail"><?php echo $LNG->RECENT_EMAIL_DIGEST_LABEL; ?></label>
			<input class="forminput" type="checkbox" name="recentactivitiesemail" <?php if ($recentactivitiesemail == 'Y') { echo "checked='true'"; } ?> value="Y" /> <?php echo $LNG->RECENT_EMAIL_DIGEST_PROFILE_MESSAGE; ?>
		</div>
	<?php } ?>

	<?php if ($CFG->MAILCHIMP_ON) { ?>
		<div class="formrow">
			<label class="formlabel" for="mailchimpnews"><?php echo $LNG->FORM_REGISTER_NEWSLETTER; ?></label>
			<input class="forminput" type="checkbox" name="mailchimpnews" <?php if ($mailchimpnews == 'Y') { echo "checked='true'"; } ?> value="Y" /> <?php echo $LNG->MAILCHIMP_NEWSLETTER_FORM_PROFILE_MESSAGE; ?>
			<br>
			<span class="forminput"><?php echo $LNG->MAILCHIMP_NEWSLETTER_FORM_MESSAGE; ?></span>
			<br>
			<?php if ($CFG->MAILCHIMP_NEWSLETTER_INFO_URL != "") { ?>
				<span class="forminput">(<a href="<?php echo $CFG->MAILCHIMP_NEWSLETTER_INFO_URL; ?>" target="_blank"><?php echo $LNG->MAILCHIMP_NEWSLETTER_FORM_FURTHER_INFO; ?></a>)</span>
			<?php } ?>
		</div>
	<?php } ?>

	<div class="formrow">
        <input class="formsubmit" type="submit" value="<?php echo $LNG->PROFILE_UPDATE_BUTTON; ?>" id="update" name="update">
    </div>
</form>


<?php
	include_once($HUB_FLM->getCodeDirPath("ui/footer.php"));
?>