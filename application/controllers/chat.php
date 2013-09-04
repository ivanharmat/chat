<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Chat extends CI_Controller {

	function __construct()
    {
        parent::__construct();
        $this->load->model('chat_model');
    }

	public function index()
	{
		$data = array(
			'main_content' => 'chat/index',
			'js' => array('chat'),
			'common' => $this->general_model->load_common_data()
		);
		$data['client_logged_in'] = ($this->session->userdata('client_logged_in') === TRUE) ? true : false;

		if($data['client_logged_in'])
		{
			$data['messages'] = $this->chat_model->get_messages();
		}

		$this->load->view('common/template', $data);
	}

	public function authenticate()
	{
		if($this->input->is_ajax_request())
		{
			sleep(1);
			$post = $this->input->post(NULL, TRUE);
			$data = array();
			$data['success'] = $this->chat_model->authenticate($post);
			echo json_encode($data);
		}
	}

	public function load_older_messages()
	{
		if($this->input->is_ajax_request())
		{
			sleep(1);
			$get = $this->input->get(NULL, TRUE);
			$messages = $this->chat_model->get_older_messages($get['offset']);

			echo json_encode($messages);
		}
	}

	public function load_new_messages()
	{
		if($this->input->is_ajax_request())
		{
			sleep(1);
			$get = $this->input->get(NULL, TRUE);
			$messages = $this->chat_model->load_new_messages($get['last_id']);

			echo json_encode($messages);
		}
	}

	public function new_comment()
	{
		if($this->input->is_ajax_request())
		{
			sleep(1);
			$post = $this->input->post(NULL, TRUE);
			$this->chat_model->add_new_comment($post);
		}
	}


}

/* End of file chat.php */
/* Location: ./application/controllers/chat.php */