<?php

defined('BASEPATH') or exit('No direct script access allowed');

class M_item extends CI_Model
{

    public function get($where = null)
    {
        $this->db->select([
            'items.id',
            'items.code',
            'items.name',
            'items.merk',
            'items.qty',
            'items.image_path',
            'items.category_id',
            'items.unit_id',
            'items.location_id',
            'items.supplier_id',
            'categories.name as category_name',
            'units.name as unit_name',
            'locations.name as location_name',
            'suppliers.name as supplier_name',
        ]);

        if ($where) {
            $this->db->where($where);
        }
        $this->db->join('categories', 'categories.id = items.category_id', 'left');
        $this->db->join('units', 'units.id = items.unit_id', 'left');
        $this->db->join('locations', 'locations.id = items.location_id', 'left');
        $this->db->join('suppliers', 'suppliers.id = items.supplier_id', 'left');
        return $this->db->get('items');
    }

    public function update_stock($id, $qty)
    {
        $this->db->set('qty', 'qty + ' . $qty, FALSE);
        $this->db->set('updated_at', date('Y-m-d H:i:s'));
        $this->db->set('updated_by', $this->session->userdata(SESI . 'id'));
        $this->db->where('id', $id);
        return $this->db->update('items');
    }
}
                        
/* End of file M_item.php */
