<?php

defined('BASEPATH') or exit('No direct script access allowed');

class M_log_send_email_admin extends CI_Model
{
	protected $table;


	public function __construct()
	{
		parent::__construct();
		$this->table = "log_send_email_admin";
	}


	public function write_log($to = null, $subject = null, $message = null, $status = null): bool
	{
		if (is_null($to) === TRUE && is_null($subject) === TRUE && is_null($message) === TRUE) {
			return true;
		}

		$data = [
			'mail_to'      => $to,
			'mail_subject' => $subject,
			'mail_message' => $message,
			'is_success'   => $status,
		];
		return $this->db->insert($this->table, $data);
	}
}
                        
/* End of file M_log_send_email_admin.php */
