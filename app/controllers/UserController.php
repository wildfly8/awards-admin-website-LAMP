<?php

namespace Vonzo\Controllers;

class UserController extends Controller {

    protected $account;

    public function index() {
      redirect('index');
    }

    public function settings() {
      $data['user'] = $this->globalUser;
      $data['page_title'] = $this->lang['account_settings'];
      $this->view->metadata['title'] = [$this->lang['account_settings']];
      return ['content' => $this->view->render($data, 'user/settings')];

    }

    public function dashboard() {
      $data['user'] = $this->globalUser;
      $data['page_title'] = $this->lang['dashboard'];
      $this->view->metadata['title'] = [$this->lang['dashboard']];
      return ['content' => $this->view->render($data, 'user/dashboard')];

    }

    public function change_password() {
      $data['user'] = $this->globalUser;
      $data['page_title'] = $this->lang['change_password'];
      $this->view->metadata['title'] = [$this->lang['change_password']];
      return ['content' => $this->view->render($data, 'user/change_password')];
    }

}
