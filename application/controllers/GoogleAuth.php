<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once FCPATH . 'vendor/autoload.php';

class GoogleAuth extends CI_Controller {

    private $client;

    public function __construct() {
        parent::__construct();
        $this->load->config('google');
        $this->load->model('login_model');

        $this->client = new Google_Client;
        $this->client->setClientId($this->config->item('google_client_id'));
        $this->client->setClientSecret($this->config->item('google_client_secret'));
        $this->client->setRedirectUri($this->config->item('google_redirect_url'));

        $this->client->addScope("email");
        $this->client->addScope("profile");
    }

    public function index() {
        $this->login();
    }

    public function login() {
        $loginUrl = $this->client->createAuthUrl();
        redirect($loginUrl);
    }

    public function callback() {
        if ($this->input->get('code')) {

            try {
                $this->client->authenticate($this->input->get('code'));
                $token = $this->client->getAccessToken();
            } catch (Exception $e) {
                $this->session->set_flashdata('message', 'Google login failed. Please try again.');
                redirect('login');
                return;
            }

            if (empty($token)) {
                $this->session->set_flashdata('message', 'Google login failed. Please try again.');
                redirect('login');
                return;
            }

            $this->client->setAccessToken($token);

            $google_service = new Google_Service_Oauth2($this->client);
            $data = $google_service->userinfo->get();

            $email = isset($data->email) ? trim($data->email) : '';

            if ($email === '') {
                $this->session->set_flashdata('message', 'Google account has no email address.');
                redirect('login');
                return;
            }

            $result = $this->login_model->can_login_google($email);
            if ($result) {
                redirect('dashboard');
                return;
            }

            $this->session->set_flashdata('message', 'This Google account is not registered in the portal.');
            redirect('login');
            return;
        }

        $this->session->set_flashdata('message', 'Google login failed. Please try again.');
        redirect('login');
    }

    public function googleCallback() {
        $this->callback();
    }

    public function logout() {
        $this->session->sess_destroy();
        redirect('/');
    }
}
