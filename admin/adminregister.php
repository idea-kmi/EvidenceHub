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

    $me = substr($_SERVER["PHP_SELF"], 1); // remove initial '/'
    if ($HUB_FLM->hasCustomVersion($me)) {
    	$path = $HUB_FLM->getCodeDirPath($me);
    	include_once($path);
		die;
	}

    checkLogin();

    include_once($HUB_FLM->getCodeDirPath("ui/headeradmin.php"));

	if($USER->getIsAdmin() != "Y"){
        echo "<div class='errors'>".$LNG->FORM_ERROR_NOT_ADMIN."</div>";
        include_once($HUB_FLM->getCodeDirPath("ui/footeradmin.php"));
        die;
	}

    $errors = array();
    $email = optional_param("email","",PARAM_TEXT);
    $password = optional_param("password","",PARAM_TEXT);
    $confirmpassword = optional_param("confirmpassword","",PARAM_TEXT);
    $fullname = optional_param("fullname","",PARAM_TEXT);

    $homepage = optional_param("homepage","",PARAM_URL);
    $homepage2 = optional_param("homepage","",PARAM_TEXT);

    $description = optional_param("description","",PARAM_TEXT);

    $location = optional_param("location","",PARAM_TEXT);
    $loccountry = optional_param("loccountry","",PARAM_TEXT);

    $privatedata = optional_param("defaultaccess","N",PARAM_ALPHA);

    if(isset($_POST["register"])){
        // check email, password & full name provided
        if (!validEmail($email)) {
            array_push($errors, $LNG->FORM_ERROR_EMAIL_INVALID);
        } else {
	        if ($fullname == ""){
	            array_push($errors, $LNG->FORM_ERROR_NAME_MISSING);
	        }
	        if ($password == ""){
	            array_push($errors, $LNG->FORM_ERROR_PASSWORD_MISSING);
	        }
	        // check password & confirm password match
	        if ($password != $confirmpassword){
	            array_push($errors, $LNG->FORM_ERROR_PASSWORD_MISMATCH);
	        }

	        // check url
	        if($homepage2 != "" && $homepage != $homepage2){
	            array_push($errors, $LNG->FORM_ERROR_URL_INVALID);
	            $homepage = $homepage2;
	        }

	        // check email not already in use
			if (empty($errors)) {
				$u = new User();
				$u->setEmail($email);
				$user = $u->getByEmail();

				if($user instanceof User){
					array_push($errors, $LNG->FORM_ERROR_EMAIL_USED);
				} else {
					// only create user if no error so far
					// create new user
					$u->add($email,$fullname,$password,$homepage,'N',$CFG->AUTH_TYPE_EVHUB,$description,$CFG->USER_STATUS_UNVALIDATED);
					$u->updatePrivate($privatedata);
					$u->updateLocation($location,$loccountry);

					//send email to welcome
					$paramArray = array ($fullname,$CFG->SITE_TITLE,$CFG->homeAddress,$u->userid,$u->getRegistrationKey(),$password);
					sendMail("validateadmin",$LNG->WELCOME_REGISTER_CLOSED_SUBJECT,$email,$paramArray);

					if(empty($errors)){
						echo "<h1>".$LNG->REGISTRATION_REQUEST_SUCCESSFUL_TITLE_ADMIN."</h1>";
						echo "<p>".$LNG->REGISTRATION_REQUEST_SUCCESSFUL_MESSAGE_ADMIN."<p><br><br>";
						echo '<div class="mb-3 row">';
						echo '<input type="button" value="'.$LNG->FORM_BUTTON_CLOSE.'" onclick="window.close();"/>';
						echo '</div>';

						include_once($HUB_FLM->getCodeDirPath("ui/footeradmin.php"));
						die;
					}
				}
			}
        }

    }

    $countries = getCountryList();
?>

<div class="container-fluid">
	<div class="row p-4 pt-0">
		<div class="col">
			<h1 class="mb-3"><?php echo $LNG->FORM_REGISTER_ADMIN_TITLE; ?></h1>

			<?php
				if(!empty($errors)){
					echo "<div class='alert alert-danger'>".$LNG->FORM_ERROR_MESSAGE."<ul>";
					foreach ($errors as $error){
						echo "<li>".$error."</li>";
					}
					echo "</ul></div>";
				}
			?>

			<p class="text-end"><span class="required">*</span> <?php echo $LNG->FORM_REQUIRED_FIELDS; ?></p>

			<form name="register" action="adminregister.php" method="post" enctype="multipart/form-data">

				<div class="mb-3 row">
					<label class="col-sm-3 col-form-label" for="email"><?php echo $LNG->FORM_REGISTER_EMAIL; ?><span class="required">*</span></label>
					<div class="col-sm-9"><input class="form-control" id="email" name="email" value="<?php print $email; ?>" /></div>
				</div>
				<div class="mb-3 row">
					<label class="col-sm-3 col-form-label" for="password"><?php echo $LNG->FORM_REGISTER_PASSWORD; ?><span class="required">*</span></label>
					<div class="col-sm-9"><input class="form-control" id="password" name="password" type="password" value="<?php print $password; ?>" /></div>
				</div>
				<div class="mb-3 row">
					<label class="col-sm-3 col-form-label" for="confirmpassword"><?php echo $LNG->FORM_REGISTER_PASSWORD_CONFIRM; ?><span class="required">*</span></label>
					<div class="col-sm-9"><input class="form-control" id="confirmpassword" name="confirmpassword" type="password" value="<?php print $confirmpassword; ?>" /></div>
				</div>
				<div class="mb-3 row">
					<label class="col-sm-3 col-form-label" for="fullname"><?php echo $LNG->FORM_REGISTER_NAME; ?><span class="required">*</span></label>
					<div class="col-sm-9"><input class="form-control" type="text" id="fullname" name="fullname" value="<?php print $fullname; ?>" /></div>
				</div>
				<div class="mb-3 row">
					<label class="col-sm-3 col-form-label" for="description"><?php echo $LNG->FORM_REGISTER_DESC; ?></label>
					<div class="col-sm-9"><textarea class="form-control" id="description" name="description" rows="5"><?php print $description; ?></textarea></div>
				</div>

				<div class="mb-3 row">
					<label class="col-sm-3 col-form-label" for="location"><?php echo $LNG->FORM_REGISTER_LOCATION; ?></label>
					<div class="col-sm-5"><input class="form-control" id="location" name="location" value="<?php echo $location; ?>" /></div>
					<div class="col-sm-4">
						<select id="loccountry" name="loccountry" class="form-select" aria-label="country">
							<option value="" ><?php echo $LNG->FORM_REGISTER_COUNTRY; ?></option>
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
				</div>

				<div class="mb-3 row">
					<label class="col-sm-3 col-form-label" for="homepage"><?php echo $LNG->FORM_REGISTER_HOMEPAGE; ?></label>
					<div class="col-sm-9"><input class="form-control" type="text" id="homepage" name="homepage" value="<?php print $homepage; ?>" /></div>
				</div>
				
				<div class="mb-3 row">
					<div class="d-grid gap-2 d-md-flex justify-content-md-center mb-3">
						<input class="btn btn-primary" type="submit" value="<?php echo $LNG->FORM_REGISTER_SUBMIT_BUTTON; ?>" id="register" name="register" />
					</div>
				</div>
			</form>
		</div>
	</div>
</div>

<?php
    include_once($HUB_FLM->getCodeDirPath("ui/footeradmin.php"));
?>