<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Chat_model extends CI_Model 
{

	public function authenticate($post)
	{
		$user = $this->db->get_where('users', array('name' => $post['name']))->row_array();
		if(isset($user['password']))
		{
			$db_password = $this->encrypt->decode($user['password']);
			if($db_password == md5($post['password']))
			{
				$session = array(
					'client_id' => $user['id'],
					'client_logged_in' => true
				);
				$this->session->set_userdata($session);
				return true;
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}
	}

	public function get_messages()
	{
		$client_id = $this->session->userdata('client_id');
		$messages = $this->db->where('from', $client_id)
							 ->or_where('to', $client_id)
							 ->order_by('id', 'desc')
							 ->limit(25)
							 ->get('chat')->result_array();
		$a = 0;
		foreach($messages as $message)
		{
			//$time_diff = time() - $message['timestamp'];
			//$messages[$a]['time_since'] = ($time_diff < 172800) ? $this->time_since($message['timestamp']) : date('D M j, Y g:i a', $message['timestamp']);
			$messages[$a]['time_since'] = date('D M j, Y g:i a', $message['timestamp']);
			$messages[$a]['message'] = $this->add_emoticons($message['message']);
			$messages[$a]['from_user'] = $this->get_username($message['from']);
			$messages[$a]['to_user'] = $this->get_username($message['to']);
			$a++;
		}
		krsort($messages);
		return $messages;
	}

	public function get_older_messages($offset)
	{
		$client_id = $this->session->userdata('client_id');
		$messages_array = array();
		$messages = $this->db->where('from', $client_id)
							 ->or_where('to', $client_id)
							 ->order_by('id', 'desc')
							 ->limit(25, $offset)
							 ->get('chat')->result_array();
		$a = 0;
		foreach($messages as $message)
		{
			//$time_diff = time() - $message['timestamp'];
			//$messages[$a]['time_since'] = ($time_diff < 172800) ? $this->time_since($message['timestamp']) : date('D M j, Y g:i a', $message['timestamp']);
			$messages[$a]['time_since'] = date('D M j, Y g:i a', $message['timestamp']);
			$messages[$a]['message'] = $this->add_emoticons($message['message']);
			$messages[$a]['from_user'] = $this->get_username($message['from']);
			$messages[$a]['to_user'] = $this->get_username($message['to']);
			$a++;
		}
		krsort($messages);
		$messages_array['messages'] = $messages;
		$messages_array['count'] = $a + 1;
		$messages_array['client_id'] = $this->session->userdata('client_id');
		
		return $messages_array;
	}

	public function load_new_messages($last_id)
	{
		$client_id = $this->session->userdata('client_id');
		$messages_array = array();
		$messages = $this->db->where('id >', $last_id)
							 ->order_by('id', 'desc')
							 ->get('chat')->result_array();
		$a = 0;
		foreach($messages as $message)
		{
			$messages[$a]['time_since'] = date('D M j, Y g:i a', $message['timestamp']);
			$messages[$a]['message'] = $this->add_emoticons($message['message']);
			$messages[$a]['from_user'] = $this->get_username($message['from']);
			$messages[$a]['to_user'] = $this->get_username($message['to']);
			$a++;
		}
		krsort($messages);
		$messages_array['messages'] = $messages;
		$messages_array['count'] = $a;
		$messages_array['client_id'] = $this->session->userdata('client_id');
		
		return $messages_array;
	}

	public function add_new_comment($post)
	{
		$from = $this->session->userdata('client_id');
		$to = ($from == 1) ? 2 : 1;
		$insert_data = array(
			'from' => $from,
			'to' => $to,
			'timestamp' => time(),
			'message' => strip_tags($post['chat_text_field'])
		);
		$this->db->insert('chat', $insert_data);
	}

	private function add_emoticons($message)
	{
		$emoticons = array(
			0 => array(
				'code' => ':D',
				'image' => 'laughing'
			),
			1 => array(
				'code' => ':-D',
				'image' => 'laughing'
			),
			2 => array(
				'code' => ':)',
				'image' => 'smile'
			),
			3 => array(
				'code' => ':-)',
				'image' => 'smile'
			),
			4 => array(
				'code' => ':o',
				'image' => 'surprised'
			),
			5 => array(
				'code' => ':-o',
				'image' => 'surprised'
			),
			6 => array(
				'code' => '>:|',
				'image' => 'angry'
			),
			7 => array(
				'code' => '>|',
				'image' => 'angry'
			),
			8 => array(
				'code' => ':P',
				'image' => 'tongue'
			),
			9 => array(
				'code' => ':-P',
				'image' => 'tongue'
			),
			10 => array(
				'code' => ':(',
				'image' => 'sad'
			),
			11 => array(
				'code' => ':-(',
				'image' => 'sad'
			),
			12 => array(
				'code' => ';-)',
				'image' => 'winking'
			),
			13 => array(
				'code' => ';)',
				'image' => 'winking'
			),
			14 => array(
				'code' => '8)',
				'image' => 'nerd'
			),
			15 => array(
				'code' => '8-)',
				'image' => 'nerd'
			),
			16 => array(
				'code' => '8-D',
				'image' => 'cool'
			),
			17 => array(
				'code' => '8D',
				'image' => 'cool'
			),
			18 => array(
				'code' => ":'(",
				'image' => 'crying'
			)
		);

		foreach($emoticons as $emoticon)
		{
			if(strpos($message, $emoticon['code']) !== false)
			{
				$message = str_replace($emoticon['code'], '<img src="/skin/emoticons/'.$emoticon['image'].'.png">', $message);
			}
		}

		return $message;
	}

	private function time_since($original) 
	{
	    // array of time period chunks
	    $chunks = array(
	        array(60 * 60 * 24 * 365 , 'Year'),
	        array(60 * 60 * 24 * 30 , 'Month'),
	        array(60 * 60 * 24 * 7, 'Week'),
	        array(60 * 60 * 24 , 'Day'),
	        array(60 * 60 , 'Hour'),
	        array(60 , 'Minute'),
	    );
	    $chunks2 = array(
	    	'Years', 'Months', 'Weeks', 'Days', 'Hours', 'Minutes'
		);
		
	    $today = time(); /* Current unix time  */
	    $since = $today - $original;
	    
	    // $j saves performing the count function each time around the loop
	    for ($i = 0, $j = count($chunks); $i < $j; $i++) 
	    {
	       
	        $seconds = $chunks[$i][0];
	        $name = $chunks[$i][1];
	        $type = $chunks2[$i];
	        // finding the biggest chunk (if the chunk fits, break)
	        if (($count = floor($since / $seconds)) != 0) 
	        {
	            break;
	        }
	    }

	    $print = ($count == 1) ? '1 '.$name : $count." ".$type;
	    
	    if ($i + 1 < $j) 
	    {
	        // now getting the second item
	        $seconds2 = $chunks[$i + 1][0];
	        $name2 = $chunks[$i + 1][1];
			$type2 = $chunks2[$i + 1];
			
	        // add second item if it's greater than 0
	        if (($count2 = floor(($since - ($seconds * $count)) / $seconds2)) != 0) 
	        {
	             $print .= ($count2 == 1) ? ', 1 '.$name2 : ", $count2 ".$type2;
	        }
	    }
		
	    return $print . ' ago';
	}

	private function get_username($id)
	{
		$client_id = $this->session->userdata('client_id');
		if($client_id == $id)
		{
			return 'You';
		}
		else
		{
			$user = $this->db->get_where('users', array('id' => $id))->row_array();
			return (isset($user['name'])) ? $user['name'] : 'Deleted User';
		}
	}





}