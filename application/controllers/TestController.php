<?php

defined('BASEPATH') or exit('No direct script access allowed');

class TestController extends CI_Controller
{


	public function __construct()
	{
		parent::__construct();
		$this->load->library('Nested_set', null, 'Nested_set');
		$this->Nested_set->setControlParams('hie', 'lft', 'rgt', 'id', 'id_upline', 'email');
		$this->Nested_set->setPrimaryKeyColumn('id_member');
	}

	public function insert_founder()
	{
		$email = 'adam_2';

		$data_member = ['email' => $email];
		$this->M_core->store('mem', $data_member);
		$insert_id = $this->db->insert_id();

		$data_hie = [
			'id_member' => $insert_id,
			'email'     => $email,
			'depth'     => 0,
		];
		$a = $this->Nested_set->initialiseRoot($data_hie);
		echo '<pre>' . print_r($a, 1) . '</pre>';
	}


	public function insert_downline()
	{
		$id_upline    = 3;
		$where_upline = ['id_member' => $id_upline];
		$data_upline  = $this->Nested_set->getNodeWhere($where_upline);

		$email       = 'adam_2_1';
		$data_member = ['email' => $email];
		$this->M_core->store('mem', $data_member);
		$insert_id = $this->db->insert_id();

		$data_downline = [
			'id_member' => $insert_id,
			'email'     => $email,
			'depth'     => $data_upline['depth'] + 1,
		];

		$has_downline = $this->Nested_set->checkNodeHasChildren($data_upline);

		if ($has_downline === true) {
			$a = $this->Nested_set->appendNewChild($data_upline, $data_downline);
		} else {
			$a = $this->Nested_set->insertNewChild($data_upline, $data_downline);
		}

		echo '<pre>' . print_r($a, 1) . '</pre>';
	}

	public function count_downline()
	{
		$id_member    = 1;
		$where_member = ['id_member' => $id_member];
		$data_member  = $this->Nested_set->getNodeWhere($where_member);

		$a = $this->Nested_set->getNumberOfChildren($data_member);
		echo '<pre>' . print_r($a, 1) . '</pre>';
	}

	public function show_tree()
	{
		$id_member    = 1;
		$where_member = ['id_member' => $id_member];
		$data_member  = $this->Nested_set->getNodeWhere($where_member);

		$a = $this->Nested_set->getTreePreorder($data_member, false);
		echo '<pre>' . print_r($a, 1) . '</pre>';
	}

	public function show_tree_attr()
	{
		$id_member    = 1;
		$where_member = ['id_member' => $id_member];
		$data_member  = $this->Nested_set->getNodeWhere($where_member);
		// echo '<pre>' . print_r($data_member, 1) . '</pre>';

		$a = $this->Nested_set->getTreeAsHTML(['email']);
		// var_dump($a);
		echo $a;
		echo '<pre>' . print_r($a, 1) . '</pre>';
	}
}
        
    /* End of file  TestController.php */
