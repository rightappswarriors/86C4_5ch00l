<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once FCPATH . 'vendor/autoload.php';

class Auth extends CI_Controller {

    private $client;

    public function __construct() {
        parent::__construct();
        $this->load->config('google');

        $this->client = new Google_Client();
        $this->client->setClientId($this->config->item('google_client_id'));
        $this->client->setClientSecret($this->config->item('google_client_secret'));
        $this->client->setRedirectUri($this->config->item('google_redirect_url'));

        $this->client->addScope("email");
        $this->client->addScope("profile");
    }

    public function login() {
        $loginUrl = $this->client->createAuthUrl();
        redirect($loginUrl);
    }

    public function googleCallback() {
        if ($this->input->get('code')) {

            $token = $this->client->fetchAccessTokenWithAuthCode($this->input->get('code'));
            $this->client->setAccessToken($token);

            $google_service = new Google_Service_Oauth2($this->client);
            $data = $google_service->userinfo->get();

            $email = $data->email;
            $name  = $data->name;

            $this->session->set_userdata([
                'email' => $email,
                'name'  => $name,
                'logged_in' => true
            ]);

            redirect('dashboard');
        } else {
            echo "Login failed";
        }
    }

    public function logout() {
        $this->session->sess_destroy();
        redirect('/');
    }
}