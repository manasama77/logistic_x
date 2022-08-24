<?php

defined('BASEPATH') or exit('No direct script access allowed');

class LogRecruitmentController extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->library('L_admin', null, 'template');
		$this->load->library('Nested_set', null, 'Nested_set');
		$this->load->helper('Time_helper');

		$this->load->model('M_member');

		$this->Nested_set->setControlParams('tree', 'lft', 'rgt', 'id', 'id_upline', 'email');
		$this->Nested_set->setPrimaryKeyColumn('id_member');
	}


	public function index()
	{
		$data_downline = array();
		$id_admin  = $this->session->userdata(SESI . 'id');

		if ($id_admin) {

			$where_founder = [
				'is_founder'  => 'yes',
				'is_active'  => 'yes',
				'deleted_at' => null,
			];
			$arr_founder = $this->M_core->get('member', 'id', $where_founder);

			foreach ($arr_founder->result() as $key) {
				$id_founder = $key->id;

				// tree member start
				$tree_downline = $this->_tree_show_downline($id_founder);

				if (count($tree_downline['result_array']) > 0) {
					usort($tree_downline['result_array'], function ($a, $b) {
						return $a['id_upline'] <=> $b['id_upline'];
					});

					foreach ($tree_downline['result_array'] as $key) {
						$id_downline    = $key['id_member'];
						$email_downline = $key['email'];
						$id_upline      = $key['id_upline'];
						$depth_downline = $key['depth'];

						// data downline start
						$arr_downline = $this->M_member->get_data_member($id_downline);

						$profile_picture_downline = $arr_downline->row()->profile_picture;
						$fullname_downline        = $arr_downline->row()->fullname;
						$phone_number_downline    = $arr_downline->row()->phone_number;
						$created_at_downline      = $arr_downline->row()->created_at;

						$arr_tree_upline = $this->M_core->get('tree', 'id_member', ['id' => $id_upline]);
						$id_upline_uuid = $arr_tree_upline->row()->id_member;

						$arr_upline      = $this->M_member->get_data_member($id_upline_uuid);

						$email_upline    = $arr_upline->row()->email;
						$fullname_upline = $arr_upline->row()->fullname;

						$pp_downline = base_url() . "public/img/pp/default_avatar.svg";
						if (is_file(FCPATH . $profile_picture_downline)) {
							$pp_downline = base_url() . 'public/img/pp/' . $profile_picture_downline;
						}

						$generation_downline = 'G' . $depth_downline;

						$created_at_human_time_downline = time_ago(new DateTime($created_at_downline));
						// data downline end

						$nested_downline = [
							'id_downline'              => $id_downline,
							'profile_picture_downline' => $pp_downline,
							'fullname_downline'        => $fullname_downline,
							'email_downline'           => $email_downline,
							'phone_number_downline'    => $phone_number_downline,
							'generation_downline'      => $generation_downline,
							'created_at_downline'      => $created_at_human_time_downline,
							'email_upline'             => $email_upline,
							'fullname_upline'          => $fullname_upline,
						];

						array_push($data_downline, $nested_downline);
					}
				}
				// tree member end
			}
		}

		$data = [
			'title'         => 'Edit Trade | Dashboard',
			'content'       => 'log/recruitment/main',
			'vitamin_js'    => 'log/recruitment/main_js',
			'data_downline' => $data_downline,
		];

		$this->template->render($data);
	}

	public function _tree_show_downline($id_member)
	{
		$where_member = ['id_member' => $id_member];
		$data_member  = $this->Nested_set->getNodeWhere($where_member);

		$exec = $this->Nested_set->getTreePreorder($data_member, true);
		// echo '<pre>' . print_r($exec, 1) . '</pre>';
		// exit;
		return $exec;
	}
}
        
/* End of file LogRecruitmentController.php */
