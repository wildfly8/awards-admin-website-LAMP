<?php

namespace Vonzo\Models;

class User extends Model {

    public $id;
    public $role;
    public $username;
    public $password;
		public $email;
    public $phone;
    public $phoneVerification;
		public $emailVerified;
    public $emailNotifications;
    public $phoneNotifications;
    public $country;
    public $accessToken;
    public $profilePicture;
    public $reputation;
    public $comments;
    public $commentReplies;
    public $commentReactions;
    public $comment_votes;
    public $votes;
    public $balance;
    public $privacyOpt;
    public $regIp;
    public $lastIp;
		public $created;

    public function setUserModel($xData) {
      $this->id = $xData['id'];
      $this->role = $xData['role'];
      $this->username = $xData['username'];
      $this->password = $xData['password'];
      $this->email = $xData['email'];
      $this->phone = $xData['phone'];
      $this->phoneVerification = $xData['phoneVerification'];
      $this->emailVerified = $xData['emailVerified'];
      $this->emailNotifications = $xData['emailNotifications'];
      $this->phoneNotifications = $xData['phoneNotifications'];
      $this->country = $xData['country'];
      $this->accessToken = $xData['access_token'];
      $this->profilePicture = $xData['profilePicture'];
      $this->ip = $xData['ip'];
      $this->created = $xData['created'];
    }

    /**
     * START THE DB CALLS
     */

    public function changePassword($currentPassword, $newPassword, $user) {
      if (password_verify($currentPassword, $user->password)) {
        $password = password_hash($newPassword, PASSWORD_DEFAULT);
        $query = $this->db->prepare("UPDATE `users` SET `password` = ? WHERE `id` = ?");
        $query->bind_param('si', $password, $user->id);
        $result = $query->execute();
        $query->close();
        return true;
      }
      return false;
    }

    public function getUserByUsername($username) {
      $query = $this->db->prepare("SELECT * FROM `users` WHERE `username` = ?");
      $query->bind_param('s', $username);
      $query->execute();
      $result = $query->get_result()->fetch_assoc();
      $query->close();
      return $result;
    }

    public function get($type = null) {
      if ($type == 1) {
        $query = $this->db->prepare("SELECT * FROM `users` WHERE `access_token` = ?");
        $query->bind_param('s', $_SESSION['_sb_hash']);
      } else if($type == 2) {
        $query = $this->db->prepare("SELECT * FROM `users` WHERE `access_token` = ?");
        $query->bind_param('s', $_COOKIE['_sb_hash']);
      } else {
        $query = $this->db->prepare("SELECT * FROM `users` WHERE `email` = ?");
        $query->bind_param('s', $this->email);
      }
      $query->execute();
      $result = $query->get_result()->fetch_assoc();
      $query->close();
      return $result;
    }

    public function getUserById($userId){
      $query = $this->db->prepare("SELECT * FROM `users` WHERE `id` = ?");
      $query->bind_param('s', $userId);
      $query->execute();
      $result = $query->get_result()->fetch_assoc();
      $query->close();
      return $result;
    }

    public function doesUserEmailExist($email) {
      $query = $this->db->prepare("SELECT * FROM `users` WHERE `email` = ?");
      $query->bind_param('s', $email);
      $query->execute();
      $result = $query->get_result();
      $query->close();
      if($result->num_rows == 0) {
        return false;
      } else {
        return true;
      }
    }

    public function isCorrectPassword($currentPassword, $userId) {
      $currentPassword = password_hash($currentPassword, PASSWORD_DEFAULT);
      $query = $this->db->prepare("SELECT * FROM `users` WHERE `password` = ? AND `id` = ?");
      $query->bind_param('si', $currentPassword, $userId);
      $query->execute();
      $result = $query->get_result();
      $query->close();
      // error_log($result->num_rows);
      if($result->num_rows == 0) {
        return false;
      } else {
        return true;
      }
    }

    public function doesUsernameExist($username) {
      $query = $this->db->prepare("SELECT * FROM `users` WHERE `username` = ?");
      $query->bind_param('s', $username);
      $query->execute();
      $result = $query->get_result();
      $query->close();
      if($result->num_rows == 0) {
        return false;
      } else {
        return true;
      }
    }

    public function insertNewUser($username, $email, $password) {

      $password = password_hash($password, PASSWORD_DEFAULT);
      $email_verified = randomString(10);

      $query = $this->db->prepare("INSERT INTO `users` (`username`, `password`, `email`, `emailVerified`) VALUES (?, ?, ?, ?);");
      $query->bind_param('ssss', $username, $password, $email, $email_verified);
      $query->execute();
      $query->close();

      $this->email = $email;
      $this->password = $password;
      $auth = $this->get(0);

      return $auth;
    }

    public function updateEmailNotificationStatus($user, $status) {
      $query = $this->db->prepare("UPDATE `users` SET `emailNotifications` = ? WHERE `id` = ?");
      $query->bind_param('si', $status, $user->id);
      $query->execute();
      $query->close();
    }

    public function password($params) {
        $query = $this->db->prepare("UPDATE `users` SET `password` = ? WHERE `email` = ?");
        $query->bind_param('ss', $params['password'], $this->email);
        $query->execute();
        $query->close();
    }

    public function setAccessToken($hash) {
      $query = $this->db->prepare("UPDATE `users` SET `access_token` = ? WHERE `email` = ?");
      $query->bind_param('ss', $hash, $this->email);
      $query->execute();
      $query->close();
    }


}
