<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Logout extends CI_Controller 
{
	/**
    * Class constructor
    */
	function __construct()
    {
        parent::__construct();
    }

	/**
    * method index
    * destroy 2 sessions and redirect user back to login form
    * flash successful logout message
    * @return void
    */
	public function index()
	{
		$session = array('client_logged_in' => NULL, 'client_id' => NULL);
		$this->session->unset_userdata($session);
        $this->session->set_flashdata('flash_message', '<p class="alert alert-info"><i class="icon-info-sign"></i> You\'ve been logged out.</p>');
		redirect(base_url());
	}

}