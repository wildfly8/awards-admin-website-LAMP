<?php

namespace Vonzo\Controllers;

class HomeController extends Controller {

    protected $account;


    public function index() {

      if ($this->globalUser) {
        $data['user'] = $this->globalUser;
      } else {
        $data['user'] = false;
      }

      return ['content' => $this->view->render($data, 'home/content')];
    }

    public function login() {
      $data = [];
      return ['content' => $this->view->render($data, 'home/login')];
    }

    public function register() {
      $data = [];
      return ['content' => $this->view->render($data, 'home/register')];
    }

    public function logout() {
      $data = [];
      $this->globalLogout(false);
      $data = [];
      return ['content' => $this->view->render($data, 'home/logout')];
      // redirect('/index');
    }

    public function login_submit() {

        $this->account = $this->model('User');

        // If the user tries to log-in
        if(isset($_POST['login'])) {
            $this->account->email = $data['email'] = $_POST['email'];
            $this->account->password = $_POST['password'];
            // Attempt to auth the user
            if (isset($_POST['remember'])) {
              $auth = $this->auth(true);
            } else {
              $auth = $this->auth(false);
            }
        } else {
          redirect('index');
        }

        // If the user has been logged-in
        if($auth) {
            redirect('dashboard');
        } else if(isset($_POST['login'])) {
            $_SESSION['message'][] = ['error', $this->lang['invalid_user_pass']];
            // $this->logout(false);
        }

        $data['page_title'] = $this->lang['login'];
        $this->view->metadata['title'] = [$this->lang['account'], $this->lang['login']];
        redirect('index');
        // return ['content' => $this->view->render($data, 'home/content')];
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
          if ($remember) {
            $cookie = setcookie("_sb_hash", $hash, time() + 30 * 24 * 60 * 60, COOKIE_PATH, null, 1);
          } else {
            $_SESSION['_sb_hash'] = $hash;
          }
          $this->account->access_token = $hash;
          return $auth;
        }
      }
      return false;
    }

}
