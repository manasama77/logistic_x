<?php

defined('BASEPATH') or exit('No direct script access allowed');

class M_admin extends CI_Model
{
    public function get($where = null)
    {
        if ($where != null) {
            $this->db->where($where);
        }

        $this->db->select([
            'admins.id',
            'admins.username',
            'admins.password',
            'admins.email',
            'admins.name',
            'admins.role',
            'admins.phone',
            'admins.division_id',
            'admins.is_active',
            'divisions.name as division_name',
        ]);

        $this->db->join('divisions', 'divisions.id = admins.division_id', 'left');
        return $this->db->get('admins');
    }
}
                        
/* End of file M_admin.php */
