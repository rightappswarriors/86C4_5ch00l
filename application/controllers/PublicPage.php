<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PublicPage extends CI_Controller {
    
    public function privacypolicy()
    {
        $this->load->view('facebook/privacy_policy');
    }
}