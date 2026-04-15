<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once FCPATH . 'vendor/facebook/graph-sdk/src/Facebook/autoload.php';

class FacebookAuth extends CI_Controller {

    private $fb;

    public function __construct() {
        parent::__construct();
        $this->load->config('facebook');
        $this->load->model('login_model');

        $this->fb = new Facebook\Facebook([
            'app_id' => $this->config->item('facebook_app_id'),
            'app_secret' => $this->config->item('facebook_app_secret'),
            'default_graph_version' => 'v5.0',
        ]);
    }

    public function index() {
        $this->login();
    }

    public function login() {
        $helper = $this->fb->getRedirectLoginHelper();
        $permissions = $this->config->item('facebook_permissions');
        $redirectUrl = $this->config->item('facebook_login_redirect_url');
        
        $loginUrl = $helper->getLoginUrl($redirectUrl, $permissions);
        redirect($loginUrl);
    }

    public function callback() {
        $helper = $this->fb->getRedirectLoginHelper();

        try {
            $accessToken = $helper->getAccessToken();
        } catch (\Facebook\Exceptions\FacebookResponseException $e) {
            $this->session->set_flashdata('message', 'Facebook login failed. Please try again.');
            redirect('login');
            return;
        } catch (\Facebook\Exceptions\FacebookSDKException $e) {
            $this->session->set_flashdata('message', 'Facebook login failed. Please try again.');
            redirect('login');
            return;
        }

        if (!isset($accessToken)) {
            if ($helper->getError()) {
                $this->session->set_flashdata('message', 'Facebook login failed. Please try again.');
            } else {
                $this->session->set_flashdata('message', 'Facebook login failed. Please try again.');
            }
            redirect('login');
            return;
        }

        try {
            $response = $this->fb->get('/me?fields=id,email,name', $accessToken);
            $user = $response->getGraphUser();
        } catch (\Facebook\Exceptions\FacebookResponseException $e) {
            $this->session->set_flashdata('message', 'Facebook login failed. Please try again.');
            redirect('login');
            return;
        } catch (\Facebook\Exceptions\FacebookSDKException $e) {
            $this->session->set_flashdata('message', 'Facebook login failed. Please try again.');
            redirect('login');
            return;
        }

        $email = isset($user['email']) ? trim($user['email']) : '';

        if ($email === '') {
            $this->session->set_flashdata('message', 'Facebook account has no email address.');
            redirect('login');
            return;
        }

        $result = $this->login_model->can_login_google($email);
        if ($result) {
            redirect('dashboard');
            return;
        }

        $this->session->set_flashdata('message', 'This Facebook account is not registered in the portal.');
        redirect('login');
    }

    public function logout() {
        $this->session->sess_destroy();
        redirect('/');
    }
}