<?php

defined('BASEPATH') or exit('No direct script access allowed');

class M_Test extends CI_Model
{

	public function get_max_right_upline($right_upline)
	{
		$this->db->select('max(`right`) max_right', false);
		$this->db->where('right <=', $right_upline);
		return $this->db->get('hie');
	}
}
                        
/* End of file M_Test.php */
