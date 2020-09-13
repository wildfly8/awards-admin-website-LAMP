<?php

namespace Vonzo\Controllers;

use Vonzo\Libraries\ReCaptcha;
use Vonzo\Libraries\ReCaptchaResponse;

class AjaxController extends Controller {

    public function index() {
        redirect();
    }

    public function edit_award() {
      if ($this->globalUser == null) {
        redirect("index");
        return;
      }
      if($_SESSION['token_id'] != $_POST['token_id']){
        $return['status'] = "bad";
        $return['message'] = "Token mismatch. Try refreshing the page.";
        echo json_encode($return);
        return;
      }

      $award_id = securityCheck($this->db, $_POST['award_id']);
      $edit_award_name_input = securityCheck($this->db, $_POST['edit_award_name_input']);
      $edit_award_type_input = securityCheck($this->db, $_POST['edit_award_type_input']);

      $awardModel = $this->model('Award');
      $awardModel->editAward($award_id, $edit_award_name_input, $edit_award_type_input);

      $return['status'] = 'good';
      echo json_encode($return);
    }

    public function new_award() {
      if ($this->globalUser == null) {
        redirect("index");
        return;
      }
      if($_SESSION['token_id'] != $_POST['token_id']){
        $return['status'] = "bad";
        $return['message'] = "Token mismatch. Try refreshing the page.";
        echo json_encode($return);
        return;
      }

      $award_name = securityCheck($this->db, $_POST['award_name']);
      $award_type = securityCheck($this->db, $_POST['award_type']);
      $award_show_year_id = securityCheck($this->db, $_POST['award_show_year_id']);

      $awardModel = $this->model('Award');
      $awardShowYearModel = $this->model('AwardShowYear');
      $awardShowModel = $this->model('AwardShow');
      $xAwardShowYear = $awardShowYearModel->getShowYearById($award_show_year_id);
      $xAwardShow = $awardShowModel->getShowById($xAwardShowYear['award_show_id']);
      // $awardFinder = $awardModel->getAwardByName($award_name);
      // if (! $awardFinder) {
        $awardModel->insertNewAward($xAwardShowYear, $xAwardShow, $award_name, $award_type);
      // } else {
      //
      // }

      $data['show'] = $awardShowModel->getShowById($xAwardShowYear['award_show_id']);
      $data['show_year'] = $awardShowYearModel->getShowYearById($award_show_year_id);

      $return['listAwardsChecklist'] = $awardModel->listAwardCheckboxesByAwardIdByArray($data['show']['awards_array'], $data['show_year']['this_years_awards_id_array']);
      $return['status'] = 'good';
      echo json_encode($return);
    }

    public function add_network_submit() {
      if ($this->globalUser == null) {
        redirect("index");
        return;
      }
      if($_SESSION['token_id'] != $_POST['token_id']){
        $return['status'] = "bad";
        $return['message'] = "Token mismatch. Try refreshing the page.";
        echo json_encode($return);
        return;
      }
      $network_name = securityCheck($this->db, $_POST['network_name']);
      $networkModel = $this->model('Network');
      $new_network_id = $networkModel->insertNewNetwork($network_name);
      $return['status'] = 'good';
      if ($new_network_id) {
        $return['url'] = URL_PATH.'/admin/networks/'.$new_network_id;
      }
      echo json_encode($return);
    }
    public function network_name_check() {
      if ($this->globalUser == null) {
        redirect("index");
        return;
      }
      if($_SESSION['token_id'] != $_POST['token_id']){
        $return['status'] = "bad";
        $return['message'] = "Token mismatch. Try refreshing the page.";
        echo json_encode($return);
        return;
      }
      $network_name = securityCheck($this->db, $_POST['network_name']);
      $networkModel = $this->model('Network');
      $doesNameExist = $networkModel->doesNetworkNameExist($network_name);
      $return['status'] = 'good';
      if ($doesNameExist) {
        $return['html'] = '<a data-nd target="_blank" href="'.URL_PATH.'/admin/networks/'.$doesNameExist['id'].'">'.$doesNameExist['company_name'].'</a>';
      }
      echo json_encode($return);
    }

    public function add_product_submit() {
      if ($this->globalUser == null) {
        redirect("index");
        return;
      }
      if($_SESSION['token_id'] != $_POST['token_id']){
        $return['status'] = "bad";
        $return['message'] = "Token mismatch. Try refreshing the page.";
        echo json_encode($return);
        return;
      }
      $product_name = securityCheck($this->db, $_POST['product_name']);
      $productModel = $this->model('Product');
      $new_product_id = $productModel->insertNewProduct($product_name);
      $return['status'] = 'good';
      if ($new_product_id) {
        $return['url'] = URL_PATH.'/admin/products/'.$new_product_id;
      }
      echo json_encode($return);
    }
    public function product_name_check() {
      if ($this->globalUser == null) {
        redirect("index");
        return;
      }
      if($_SESSION['token_id'] != $_POST['token_id']){
        $return['status'] = "bad";
        $return['message'] = "Token mismatch. Try refreshing the page.";
        echo json_encode($return);
        return;
      }
      $product_name = securityCheck($this->db, $_POST['product_name']);
      $productModel = $this->model('Product');
      $doesNameExist = $productModel->doesProductNameExist($product_name);
      $return['status'] = 'good';
      if ($doesNameExist) {
        $return['html'] = '<a data-nd target="_blank" href="'.URL_PATH.'/admin/products/'.$doesNameExist['id'].'">'.$doesNameExist['company_name'].'</a>';
      }
      echo json_encode($return);
    }

    public function add_studio_submit() {
      if ($this->globalUser == null) {
        redirect("index");
        return;
      }
      if($_SESSION['token_id'] != $_POST['token_id']){
        $return['status'] = "bad";
        $return['message'] = "Token mismatch. Try refreshing the page.";
        echo json_encode($return);
        return;
      }
      $studio_name = securityCheck($this->db, $_POST['studio_name']);
      $studioModel = $this->model('Studio');
      $new_studio_id = $studioModel->insertNewStudio($studio_name);
      $return['status'] = 'good';
      if ($new_studio_id) {
        $return['url'] = URL_PATH.'/admin/studios/'.$new_studio_id;
      }
      echo json_encode($return);
    }
    public function studio_name_check() {
      if ($this->globalUser == null) {
        redirect("index");
        return;
      }
      if($_SESSION['token_id'] != $_POST['token_id']){
        $return['status'] = "bad";
        $return['message'] = "Token mismatch. Try refreshing the page.";
        echo json_encode($return);
        return;
      }
      $studio_name = securityCheck($this->db, $_POST['studio_name']);
      $studioModel = $this->model('Studio');
      $doesNameExist = $studioModel->doesStudioNameExist($studio_name);
      $return['status'] = 'good';
      if ($doesNameExist) {
        $return['html'] = '<a data-nd target="_blank" href="'.URL_PATH.'/admin/studios/'.$doesNameExist['id'].'">'.$doesNameExist['company_name'].'</a>';
      }
      echo json_encode($return);
    }

    public function add_vendor_submit() {
      if ($this->globalUser == null) {
        redirect("index");
        return;
      }
      if($_SESSION['token_id'] != $_POST['token_id']){
        $return['status'] = "bad";
        $return['message'] = "Token mismatch. Try refreshing the page.";
        echo json_encode($return);
        return;
      }
      $vendor_name = securityCheck($this->db, $_POST['vendor_name']);
      $vendorModel = $this->model('Vendor');
      $new_vendor_id = $vendorModel->insertNewVendor($vendor_name);
      $return['status'] = 'good';
      if ($new_vendor_id) {
        $return['url'] = URL_PATH.'/admin/vendors/'.$new_vendor_id;
      }
      echo json_encode($return);
    }
    public function vendor_name_check() {
      if ($this->globalUser == null) {
        redirect("index");
        return;
      }
      if($_SESSION['token_id'] != $_POST['token_id']){
        $return['status'] = "bad";
        $return['message'] = "Token mismatch. Try refreshing the page.";
        echo json_encode($return);
        return;
      }
      $vendor_name = securityCheck($this->db, $_POST['vendor_name']);
      $vendorModel = $this->model('Vendor');
      $doesNameExist = $vendorModel->doesVendorNameExist($vendor_name);
      $return['status'] = 'good';
      if ($doesNameExist) {
        $return['html'] = '<a data-nd target="_blank" href="'.URL_PATH.'/admin/vendors/'.$doesNameExist['id'].'">'.$doesNameExist['company_name'].'</a>';
      }
      echo json_encode($return);
    }

    public function add_person_submit() {
      if ($this->globalUser == null) {
        redirect("index");
        return;
      }
      if($_SESSION['token_id'] != $_POST['token_id']){
        $return['status'] = "bad";
        $return['message'] = "Token mismatch. Try refreshing the page.";
        echo json_encode($return);
        return;
      }

      $full_name = securityCheck($this->db, $_POST['full_name']);
      $suffix = securityCheck($this->db, $_POST['suffix']);
      $first_name = securityCheck($this->db, $_POST['first_name']);
      $middle_name = securityCheck($this->db, $_POST['middle_name']);
      $last_name = securityCheck($this->db, $_POST['last_name']);
      $dob = securityCheck($this->db, $_POST['dob']);
      $dod = securityCheck($this->db, $_POST['dod']);
      $detailed_desc = securityCheck($this->db, $_POST['detailed_desc']);
      $internal_notes = securityCheck($this->db, $_POST['internal_notes']);


      $peopleModel = $this->model('People');
      $new_person_id = $peopleModel->insertNewPerson($full_name, $suffix, $first_name, $middle_name, $last_name, $dob, $dod, $detailed_desc, $internal_notes);

      $return['status'] = 'good';
      if ($new_person_id) {
        $return['url'] = URL_PATH.'/admin/people/'.$new_person_id;
      }
      echo json_encode($return);
    }
    public function person_name_check() {
      if ($this->globalUser == null) {
        redirect("index");
        return;
      }
      if($_SESSION['token_id'] != $_POST['token_id']){
        $return['status'] = "bad";
        $return['message'] = "Token mismatch. Try refreshing the page.";
        echo json_encode($return);
        return;
      }

      $full_name = securityCheck($this->db, $_POST['full_name']);

      $peopleModel = $this->model('People');
      $doesNameExist = $peopleModel->doesPersonFullNameExist($full_name);

      $return['status'] = 'good';
      // $reutrn['found'] = $doesNameExist;
      if ($doesNameExist) {
        $return['html'] = '<a data-nd target="_blank" href="'.URL_PATH.'/admin/people/'.$doesNameExist['id'].'">'.$doesNameExist['full_name'].'</a>';
      }
      echo json_encode($return);
    }

    public function new_media() {
      if ($this->globalUser == null) {
        redirect("index");
        return;
      }
      if($_SESSION['token_id'] != $_POST['token_id']){
        $return['status'] = "bad";
        $return['message'] = "Token mismatch. Try refreshing the page.";
        echo json_encode($return);
        return;
      }

      $media_type = securityCheck($this->db, $_POST['media_type']);
      $media_type_id = securityCheck($this->db, $_POST['media_type_id']);
      $media_title = securityCheck($this->db, $_POST['media_title']);
      $media_source = securityCheck($this->db, $_POST['media_source']);
      $media_caption = securityCheck($this->db, $_POST['media_caption']);
      $attachments = securityCheck($this->db, $_POST['attachments']);

      $mediaModel = $this->model('Media');
      $mediaModel->insertNewMedia($media_type, $media_type_id, $media_title, $media_source, $media_caption, $attachments);

      $return['status'] = "good";
      echo json_encode($return);
    }

    public function notification_settings() {

      if ($this->globalUser == null) {
        redirect("index");
      } else if($_SESSION['token_id'] != $_POST['token_id']){
        $return['status'] = "bad";
        $return['message'] = "Token mismatch. Try refreshing the page.";
      } else {
        $type = securityCheck($this->db, $_POST['type']);
        $status = securityCheck($this->db, $_POST['status']);
        if ($status == "off") {
          $status = "N";
        } else if ($status == "on") {
          $status = "Y";
        }

        $userModel = $this->Model('User');
        $userModel->updateEmailNotificationStatus($this->globalUser, $status);
        $return['status'] = "good";

      }
      echo json_encode($return);

    } // end notification_settings function

    public function change_password() {
      if ($this->globalUser == null) {
        redirect("index");
      } else if($_SESSION['token_id'] != $_POST['token_id']){
        $return['status'] = "bad";
        $return['message'] = "Token mismatch. Try refreshing the page.";
      } else {
        $newPassword = securityCheck($this->db, $_POST['np']);
        $currentPassword = securityCheck($this->db, $_POST['cp']);
        $userModel = $this->model('User');
        $success = $userModel->changePassword($currentPassword, $newPassword, $this->globalUser);
        if ($success) {
          $return['status'] = 'good';
        } else {
          $return['status'] = 'bad';
          $return['message'] = "It looks like your current password doesn't match.";
        }
      }
      echo json_encode($return);

    }

    public function login() {
      $this->account = $this->model('User');
      if (! isset($_SESSION['token_id']) || ! isset($_POST['token_id'])) {
        $return['status'] = "bad";
        $return['message'] = "Token mismatch. Refresh the page and try again.";
        echo json_encode($return);
        return;
      }
      if ($_SESSION['token_id'] != $_POST['token_id']){
        $return['status'] = "bad";
        $return['message'] = "Token mismatch. Refresh the page and try again.";
        echo json_encode($return);
        return;
      }

      if(isset($_POST['email']) && isset($_POST['password'])) {
            $this->account->email = $data['email'] = $_POST['email'];
            $this->account->password = $_POST['password'];
            // Attempt to auth the user
            if (isset($_POST['remember'])) {
              $auth = $this->auth(true);
            } else {
              $auth = $this->auth(false);
            }
        } else {
            $return['status'] = "bad";
          	$return['message'] = "Please fill out all the fields.";
            echo json_encode($return);
            return;
        }

        // If the user has been logged-in
        if(isset($auth) && $auth) {
          $return['status'] = "good";
        } else {
          $return['status'] = "bad";
          $return['message'] = "Invalid username and password.";
        }

        echo json_encode($return);

    }

    public function register() {
      $userModel = $this->model('User');

      $username = securityCheck($this->db, $_POST['username']);
      $email = securityCheck($this->db, $_POST['email']);
      $password = securityCheck($this->db, $_POST['password']);

      if(! isset($_SESSION['token_id']) && $_SESSION['token_id'] != $_POST['token_id']){
        $return['status'] = "bad";
      	$return['message'] = "Token mismatch. Try refreshing the page.";

      } else if (isset($_POST["g-recaptcha-response"])) {
        $reCaptcha = new ReCaptcha(GOOGLE_SECRET_KEY);
        $response = $reCaptcha->verifyResponse(
            $_SERVER["REMOTE_ADDR"],
            $_POST["g-recaptcha-response"]
        );
        if ($response == null || !$response->success) {
          $return['status'] = "bad";
          $return['status'] = "Please confirm you're not a robot.";

        } else if ($userModel->doesUserEmailExist($email) == true) {
          $return['status'] = "bad";
          $return['message'] = "A user with this email already exists.";

        } else if ($userModel->doesUsernameExist($username) == true) {
          $return['status'] = "bad";
          $return['message'] = "This username is already taken.";

        } else {
          $xNewUser = $userModel->insertNewUser($username, $email, $password);
          if($xNewUser){
            $hash = password_hash($email.generateSalt().time().generateSalt(), PASSWORD_DEFAULT);
            $userModel->setAccessToken($hash);
            $_SESSION['_sb_hash'] = $hash;
            setcookie('_sb_hash', $hash, time() + (86400 * 30), "/"); // 86400 = 1 day
            $userModel->access_token = $hash;

            $return['status'] = "good";

          } else {
            $return['status'] = "bad";
            $return['message'] = "Something went wrong. Please refresh the page and try again. If this issue persists please contact support.";
          }
        }
      } else {
        $return['status'] = "bad";
        $return['status'] = "Please confirm you're not a robot.";
      }

      echo json_encode($return);
		}

    public function upload() {

      $valid_extensions = array('jpeg', 'jpg', 'png', 'pdf', 'gif'); // valid extensions
      // error_log($_SERVER["DOCUMENT_ROOT"]);
      $path = $_SERVER["DOCUMENT_ROOT"].'/public/uploads/'; // upload directory
      if (!file_exists($path)) {
          mkdir($path, 0777);
      }

      $return['msg'] = "error";

      if($_SESSION['token_id'] != $_POST['token_id']){
      	$return['msg'] = "token";

      } else if (isset($_FILES['image'])) {
      	$img = $_FILES['image']['name'];
      	$tmp = $_FILES['image']['tmp_name'];
      	// get uploaded file's extension
      	$ext = strtolower(pathinfo($img, PATHINFO_EXTENSION));
      	// can upload same image using rand function
      	$final_image = rand(1000,1000000).$img;
      	// check's valid format
      	if(in_array($ext, $valid_extensions))
      	{
      		$path = $path.strtolower($final_image);
      		if(move_uploaded_file($tmp,$path))
      		{
      			$fullPath = URL_PATH."/uploads/".strtolower($final_image);
            // $partialPath = "/uploads/".$this->globalUser->id."/".strtolower($final_image);
            $partialPath = strtolower($final_image);
            $return['file_name'] = $img;
            $return['partial_path'] = $partialPath;
      			$return['full_path'] = $fullPath;
            // $return['path'] = $urlPath;
            $return['msg'] = "good";
      		}
      	} else {
      		$return['msg'] = "extension";
      	}

      } else if (isset($_POST['blob'])) {

        $img = $_POST['blobName'];
        $ext = strtolower(pathinfo($img, PATHINFO_EXTENSION));
        $final_image = rand(1000,1000000).$img;

        // if(in_array($ext, $valid_extensions))
      	// {
      		$filePath = $path.strtolower($final_image);
          $imageData = base64_decode($_POST['blob']);
          file_put_contents($filePath, $imageData);
          $fullPath = URL_PATH."/uploads/".strtolower($final_image);
          $partialPath = strtolower($final_image);
          $return['file_name'] = $img;
          $return['partial_path'] = $partialPath;
          $return['full_path'] = $fullPath;
          $return['msg'] = "good";
        // } else {
        //   $return['msg'] = "extension";
        // }

      } else {
        $return['msg'] = "empty";
      }

      echo json_encode($return);

    }

    function delete_upload() {
      if($_SESSION['token_id'] != $_POST['token_id']){
      	$return['msg'] = "token";
      } else if (isset($_POST["path"])) {
        $getFile = securityCheck($this->db, $_POST['path']);
        $path = $_SERVER["DOCUMENT_ROOT"].'/public/uploads/'; // upload directory
        unlink($path.$getFile);
        $return['msg'] ="good";
      } else {
        $return['msg'] = "empty";
      }
      echo json_encode($return);
    }

    /**
     * Check whether the user can be authed or not
     *
     * @return	array | bool
     */
    private function auth($remember) {
      $auth = $this->account->get(0);
      if ($auth) {
        if (password_verify($this->account->password, $auth['password'])) {
          $hash = password_hash($this->account->email.generateSalt().time().generateSalt(), PASSWORD_DEFAULT);
          $this->account->setAccessToken($hash);
          // if ($remember) {
          //   $cookie = setcookie("_sb_hash", $hash, time() + 30 * 24 * 60 * 60, COOKIE_PATH, null, 1);
          // } else {
            $_SESSION['_sb_hash'] = $hash;
          // }
          $this->account->access_token = $hash;
          return $auth;
        }
      }
      return false;
    }























  ///////////////////////////////////
  ////// LEGACY AJAX PHP WHEN TIME REFACTOR
  public function c_ajax() {

    if ($_POST['path'] == "new_internal_note") {
    	$type = securityCheck($this->db, $_POST['type']);
    	$the_note = securityCheck($this->db, $_POST['the_note']);
    	$associated_id = securityCheck($this->db, $_POST['associated_id']);
    	mysqli_query($this->db, 'INSERT INTO `z_internal_notes` (type, associated_id, the_note)
    	VALUES("'.$type.'",'.$associated_id.',"'.$the_note.'")');
    	$return['status'] = "good";
    	$return['html'] = '<tr><td>Now</td><td>Anonymous</td><td>'.$the_note.'</td></tr>';
    	echo json_encode($return);
    }

    if ($_POST['path'] == "edit_person") {
    	$person_id = securityCheck($this->db, $_POST['person_id']);
    	$p_first_name = securityCheck($this->db, $_POST['p_first_name']);
    	$p_middle_name = securityCheck($this->db, $_POST['p_middle_name']);
    	$p_last_name = securityCheck($this->db, $_POST['p_last_name']);
    	$p_dob = securityCheck($this->db, $_POST['p_dob']);
      $p_dod = securityCheck($this->db, $_POST['p_dod']);
      if ($p_dob != "") {
        $p_dob = date("n/j/Y", strtotime($p_dob));
      }
      if ($p_dod != "") {
        $p_dod = date("n/j/Y", strtotime($p_dod));
      }
    	$p_detailed_desc = securityCheck($this->db, $_POST['p_detailed_desc']);
    	$p_internal_notes = securityCheck($this->db, $_POST['p_internal_notes']);
    	$p_suffix = securityCheck($this->db, $_POST['p_suffix']);

      $full_name = "";
      if ($p_suffix != "") {
        $full_name .= $p_suffix . " ";
      }
      if ($p_first_name != "") {
        $full_name .= $p_first_name . " ";
      }
      if ($p_middle_name != "") {
        $full_name .= $p_middle_name . " ";
      }
      if ($p_last_name != "") {
        $full_name .= $p_last_name . " ";
      }
      error_log($full_name);
    	// $full_name = $p_suffix . " " . $p_first_name . " " . $p_middle_name . " " . $p_last_name;
    	$q = 'UPDATE `z_person` SET
    				`full_name` = "'.$full_name.'",
    				`first_name` = "'.$p_first_name.'",
    				`middle_name` = "'.$p_middle_name.'",
    				`last_name` = "'.$p_last_name.'",
    				`dob` = "'.$p_dob.'",
    				`dod` = "'.$p_dod.'",
    				`detailed_desc` = "'.$p_detailed_desc.'",
    				`internal_notes` = "'.$p_internal_notes.'",
    				`suffix` = "'.$p_suffix.'"
    				WHERE id = ' . $person_id;
    	mysqli_query($this->db, $q);
    	$return['status'] = "good";
    	echo json_encode($return);
    }

    if ($_POST['path'] == "edit_awards_to_award_show_year") {
    	$award_show_year_id = securityCheck($this->db, $_POST['award_show_year_id']);
    	$award_checkbox = securityCheck($this->db, $_POST['award_checkbox']);
    	$q = 'UPDATE `z_award_show_year` SET `this_years_awards_id_array` = "'.$award_checkbox.'" WHERE id = ' . $award_show_year_id;
    	mysqli_query($this->db, $q);
    	$return['status'] = "good";
    	echo json_encode($return);
    }

    if ($_POST['path'] == "edit_award_show_year") {
    	$award_show_year_id = securityCheck($this->db, $_POST['award_show_year_id']);
    	$asy_title = securityCheck($this->db, $_POST['asy_title']);
    	$asy_show_number = securityCheck($this->db, $_POST['asy_show_number']);
    	$ns_eligibility_date_from = securityCheck($this->db, $_POST['ns_eligibility_date_from']);
    	$ns_eligibility_date_to = securityCheck($this->db, $_POST['ns_eligibility_date_to']);
    	$ns_ceremony_date = securityCheck($this->db, $_POST['ns_ceremony_date']);
    	$new_as_visible_to_public = securityCheck($this->db, $_POST['new_as_visible_to_public']);
    	$asy_year_existing = securityCheck($this->db, $_POST['asy_year_existing']);
    	$asy_ceremony_date = securityCheck($this->db, $_POST['asy_ceremony_date']);
    	$asy_ceremony_year = securityCheck($this->db, $_POST['asy_ceremony_year']);
    	$asy_ceremony_venue = securityCheck($this->db, $_POST['asy_ceremony_venue']);
    	$asy_hosts = securityCheck($this->db, $_POST['asy_hosts']);
    	$ns_network_select = securityCheck($this->db, $_POST['ns_network_select']);
    	$ns_hours = securityCheck($this->db, $_POST['ns_hours']);
    	$ns_minutes = securityCheck($this->db, $_POST['ns_minutes']);
    	$asy_viewership = securityCheck($this->db, $_POST['asy_viewership']);
    	$asy_viewship_source = securityCheck($this->db, $_POST['asy_viewship_source']);
    	// $asy_internal_notes = securityCheck($this->db, $_POST['asy_internal_notes']);

    	$ns_ceremony_date = date("n/j/Y", strtotime($ns_ceremony_date));

    	$q = 'UPDATE `z_award_show_year` SET
    				`show_title` = "'.$asy_title.'",
    				`show_year_number` = "'.$asy_show_number.'",
    				`eligibility_date_start` = "'.$ns_eligibility_date_from.'",
    				`eligibility_date_end` = "'.$ns_eligibility_date_to.'",
    				`ceremony_date` = "'.$ns_ceremony_date.'",
    				`visible_to_public` = "'.$new_as_visible_to_public.'",
    				`year_existing` = "'.$asy_year_existing.'",
    				`ceremony_date_existing` = "'.$asy_ceremony_date.'",
    				`ceremony_date_year_existing` = "'.$asy_ceremony_year.'",
    				`ceremony_venue` = "'.$asy_ceremony_venue.'",
    				`hosts_array` = "'.$asy_hosts.'",
    				`network` = "'.$ns_network_select.'",
    				`duration_hours` = "'.$ns_hours.'",
    				`duration_minutes` = "'.$ns_minutes.'",
    				`viewership` = "'.$asy_viewership.'",
    				`viewership_source` = "'.$asy_viewship_source.'"
    				WHERE id = '.$award_show_year_id;
    	// 				`internal_notes` = "'.$asy_internal_notes.'"
    	mysqli_query($this->db, $q);
    	$return['status'] = "good";
    	echo json_encode($return);
    }

    if ($_POST['path'] == "add_new_award_show_year") {
    	$award_show_id = securityCheck($this->db, $_POST['award_show_id']);
    	$asy_title = securityCheck($this->db, $_POST['asy_title']);
    	$asy_show_number = securityCheck($this->db, $_POST['asy_show_number']);
    	$ns_eligibility_date_from = securityCheck($this->db, $_POST['ns_eligibility_date_from']);
    	$ns_eligibility_date_to = securityCheck($this->db, $_POST['ns_eligibility_date_to']);
    	$ns_ceremony_date = securityCheck($this->db, $_POST['ns_ceremony_date']);
    	$new_as_visible_to_public = securityCheck($this->db, $_POST['new_as_visible_to_public']);
    	$asy_year_existing = securityCheck($this->db, $_POST['asy_year_existing']);
    	$asy_ceremony_date = securityCheck($this->db, $_POST['asy_ceremony_date']);
    	$asy_ceremony_year = securityCheck($this->db, $_POST['asy_ceremony_year']);
    	$asy_ceremony_venue = securityCheck($this->db, $_POST['asy_ceremony_venue']);
    	$asy_hosts = securityCheck($this->db, $_POST['asy_hosts']);
    	$ns_network_select = securityCheck($this->db, $_POST['ns_network_select']);
    	$ns_hours = securityCheck($this->db, $_POST['ns_hours']);
    	$ns_minutes = securityCheck($this->db, $_POST['ns_minutes']);
    	$asy_viewership = securityCheck($this->db, $_POST['asy_viewership']);
    	$asy_viewship_source = securityCheck($this->db, $_POST['asy_viewship_source']);
    	$asy_internal_notes = securityCheck($this->db, $_POST['asy_internal_notes']);

    	$ns_ceremony_date = date("n/j/Y", strtotime($ns_ceremony_date));

    	$return['status'] = "";

    	$q = 'SELECT * FROM `z_award_show` WHERE `award_show_id` = '.$award_show_id.' AND `show_title` = "'.$asy_title.'"';
    	$doesAwardNameExist = mysqli_num_rows(mysqli_query($this->db, $q));
    	if ($doesAwardNameExist > 0) {
    		$return['status'] = "bad";
    		$return['message'] = "The show title has already been taken for this award show.";
    	}

    	$q = 'SELECT * FROM `z_award_show` WHERE `award_show_id` = '.$award_show_id.' AND `show_year_number` = "'.$asy_show_number.'"';
    	$doesAwardNameExist = mysqli_num_rows(mysqli_query($this->db, $q));
    	if ($doesAwardNameExist > 0) {
    		$return['status'] = "bad";
    		$return['message'] = "The show year number has already been taken for this award show.";
    	}

    	$q = 'SELECT * FROM `z_award_show` WHERE `award_show_id` = '.$award_show_id.' AND `eligibility_date_start` = "'.$ns_eligibility_date_from.'"';
    	$doesAwardNameExist = mysqli_num_rows(mysqli_query($this->db, $q));
    	if ($doesAwardNameExist > 0) {
    		$return['status'] = "bad";
    		$return['message'] = "The eligibility date from has already been taken for this award show.";
    	}

    	$q = 'SELECT * FROM `z_award_show` WHERE `award_show_id` = '.$award_show_id.' AND `eligibility_date_end` = "'.$ns_eligibility_date_to.'"';
    	$doesAwardNameExist = mysqli_num_rows(mysqli_query($this->db, $q));
    	if ($doesAwardNameExist > 0) {
    		$return['status'] = "bad";
    		$return['message'] = "The eligibility date to has already been taken for this award show.";
    	}

    	$q = 'SELECT * FROM `z_award_show` WHERE `award_show_id` = '.$award_show_id.' AND `ceremony_date` = "'.$ns_ceremony_date.'"';
    	$doesAwardNameExist = mysqli_num_rows(mysqli_query($this->db, $q));
    	if ($doesAwardNameExist > 0) {
    		$return['status'] = "bad";
    		$return['message'] = "The ceremony date to has already been taken for this award show.";
    	}

    	if ($return['status'] != "bad") {
    		// $duration = ((int) $ns_hours * 60)
    		mysqli_query($this->db, 'INSERT INTO `z_award_show_year` (award_show_id, show_title, show_year_number, eligibility_date_start, eligibility_date_end, ceremony_date, visible_to_public, year_existing, ceremony_date_existing, ceremony_date_year_existing, ceremony_venue, hosts_array, network, duration_hours, duration_minutes, viewership, viewership_source, internal_notes) VALUES("'.$award_show_id.'","'.$asy_title.'","'.$asy_show_number.'","'.$ns_eligibility_date_from.'","'.$ns_eligibility_date_to.'","'.$ns_ceremony_date.'","'.$new_as_visible_to_public.'","'.$asy_year_existing.'","'.$asy_ceremony_date.'","'.$asy_ceremony_year.'","'.$asy_ceremony_venue.'","'.$asy_hosts.'","'.$ns_network_select.'","'.$ns_hours.'","'.$ns_minutes.'","'.$asy_viewership.'","'.$asy_viewship_source.'","'.$asy_internal_notes.'")');
    		$return['status'] = "good";
    	}


    	echo json_encode($return);

    }


    if ($_POST['path'] == "add_new_award_show") {
    	$award_show_full_name = securityCheck($this->db, $_POST['award_show_full_name']);
    	$award_show_short_name = securityCheck($this->db, $_POST['award_show_short_name']);
    	$award_show_abbreviation = securityCheck($this->db, $_POST['award_show_abbreviation']);
    	$award_show_website_url = securityCheck($this->db, $_POST['award_show_website_url']);
    	$award_show_admin_flag = securityCheck($this->db, $_POST['award_show_admin_flag']);
    	$award_show_admin_notes = securityCheck($this->db, $_POST['award_show_admin_notes']);

    	$return['status'] = "";

    	$q = 'SELECT * FROM `z_award_show` WHERE `full_name` = "'.$award_show_full_name.'"';
    	$doesAwardNameExist = mysqli_num_rows(mysqli_query($this->db, $q));
    	if ($doesAwardNameExist > 0) {
    		$return['status'] = "bad";
    		$return['message'] = "The award show full name is already taken.";
    	}

    	$q = 'SELECT * FROM `z_award_show` WHERE `short_name` = "'.$award_show_short_name.'"';
    	$doesAwardNameExist = mysqli_num_rows(mysqli_query($this->db, $q));
    	if ($doesAwardNameExist > 0) {
    		$return['status'] = "bad";
    		$return['message'] = "The award show short name is already taken.";
    	}

    	$q = 'SELECT * FROM `z_award_show` WHERE `abbreviation` = "'.$award_show_abbreviation.'"';
    	$doesAwardNameExist = mysqli_num_rows(mysqli_query($this->db, $q));
    	if ($doesAwardNameExist > 0) {
    		$return['status'] = "bad";
    		$return['message'] = "The award show abbreviation is already taken.";
    	}

    	if ($return['status'] != "bad") {
    		mysqli_query($this->db, 'INSERT INTO `z_award_show` (full_name, short_name, abbreviation, show_website_url, internal_notes, admin_flag) VALUES("'.$award_show_full_name.'","'.$award_show_short_name.'","'.$award_show_abbreviation.'","'.$award_show_website_url.'","'.$award_show_admin_flag.'","'.$award_show_admin_notes.'")');
    		$return['status'] = "good";
    	}

    	echo json_encode($return);
    }

    if ($_POST['path'] == "edit_award_show") {
    	$edit_award_show_full_name = securityCheck($this->db, $_POST['edit_award_show_full_name']);
    	$edit_award_show_short_name = securityCheck($this->db, $_POST['edit_award_show_short_name']);
    	$edit_award_show_abbreviation = securityCheck($this->db, $_POST['edit_award_show_abbreviation']);
    	$edit_award_show_website_url = securityCheck($this->db, $_POST['edit_award_show_website_url']);
    	$edit_award_show_visible_to_public = securityCheck($this->db, $_POST['edit_award_show_visible_to_public']);
    	$edit_award_show_id = securityCheck($this->db, $_POST['edit_award_show_id']);

    	mysqli_query($this->db, 'UPDATE `z_award_show` SET `full_name` = "'.$edit_award_show_full_name.'", `short_name` = "'.$edit_award_show_short_name.'", `abbreviation` = "'.$edit_award_show_abbreviation.'", `show_website_url` = "'.$edit_award_show_website_url.'", `visible_to_public` = "'.$edit_award_show_visible_to_public.'" WHERE `id` = ' . $edit_award_show_id);

    	$return['status'] = "good";
    	echo json_encode($return);
    }

  } // end ajax c_ajax function


}
