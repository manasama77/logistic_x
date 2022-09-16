<?php

defined('BASEPATH') or exit('No direct script access allowed');

class M_stock_masuk extends CI_Model
{

    public function get($where = null)
    {
        $this->db->select([
            'stock_in_requests.id',
            'stock_in_requests.code',
            'stock_in_requests.no_po',
            'stock_in_requests.no_do',
            'stock_in_requests.request_datetime',
            'stock_in_requests.state',
            'stock_in_requests.description',
        ]);

        if ($where) {
            $this->db->where($where);
        }

        if ($this->input->get('from_request_datetime')) {
            $from_request_datetime = new DateTime($this->input->get('from_request_datetime'));
            $this->db->where('stock_in_requests.request_datetime >=', $from_request_datetime->format('Y-m-d H:i:s'));
        }

        if ($this->input->get('to_request_datetime')) {
            $to_request_datetime = new DateTime($this->input->get('to_request_datetime'));
            $this->db->where('stock_in_requests.request_datetime <=', $to_request_datetime->format('Y-m-d H:i:s'));
        }

        if ($this->input->get('no_po')) {
            $this->db->like('stock_in_requests.no_po', $this->input->get('no_po'));
        }

        if ($this->input->get('no_do')) {
            $this->db->like('stock_in_requests.no_do', $this->input->get('no_do'));
        }

        if ($this->input->get('state') != "All") {
            $this->db->like('stock_in_requests.state', $this->input->get('state'));
        }

        if ($this->input->get('item_id') != "All") {
            $this->db->join('stock_in_request_items', 'stock_in_request_items.stock_in_request_id = stock_in_requests.id', 'left');
            $this->db->where_in('stock_in_request_items.item_id', $this->input->get('item_id'));
        }

        $this->db->group_by('stock_in_requests.id');
        $stock_in_requests = $this->db->get('stock_in_requests');

        $data = [];

        foreach ($stock_in_requests->result() as $stock_in_request) {
            $id                        = $stock_in_request->id;
            $code                      = $stock_in_request->code;
            $no_po                     = $stock_in_request->no_po;
            $no_do                     = $stock_in_request->no_do;
            $request_datetime          = $stock_in_request->request_datetime;
            $request_datetime_formated = tanggal_jam_indo_no_dash_plain($stock_in_request->request_datetime);
            $state                     = $stock_in_request->state;
            $description               = $stock_in_request->description;
            $items                     = '';
            $qty_requests              = '';
            $qty_receives              = '';
            $datetime_receives         = '';

            $this->db->select([
                'items.code as item_code',
                'items.name as item_name',
                'stock_in_request_items.qty_request',
                'stock_in_request_items.qty_receive',
                'stock_in_request_items.datetime_receive',
                'units.name as unit_name',
            ]);
            $this->db->join('items', 'items.id = stock_in_request_items.item_id', 'left');
            $this->db->join('units', 'units.id = items.unit_id', 'left');
            $this->db->where('stock_in_request_items.stock_in_request_id', $id);
            if ($this->input->get('item_id') != "All") {
                $this->db->like('stock_in_request_items.item_id', $this->input->get('item_id'));
            }
            $stock_in_request_items = $this->db->get('stock_in_request_items');

            foreach ($stock_in_request_items->result() as $stock_in_request_item) {
                $item_code                 = $stock_in_request_item->item_code;
                $item_name                 = $stock_in_request_item->item_name;
                $qty_request               = number_format($stock_in_request_item->qty_request, 0);
                $qty_receive               = $stock_in_request_item->qty_receive;
                $datetime_receive_formated = ($stock_in_request_item->datetime_receive) ? full_tanggal_jam_indo_no_dash($stock_in_request_item->datetime_receive) : null;
                $unit_name                 = $stock_in_request_item->unit_name;

                $items             .= "($item_code) $item_name, <br />";
                $qty_requests      .= "$qty_request $unit_name, <br />";
                $qty_receives      .= "$qty_receive $unit_name, <br />";
                $datetime_receives .= "$datetime_receive_formated, <br />";
            }

            $items             = rtrim($items, ', <br />');
            $qty_requests      = rtrim($qty_requests, ', <br />');
            $qty_receives      = rtrim($qty_receives, ', <br />');
            $datetime_receives = rtrim($datetime_receives, ', <br />');

            $nested = [
                'id'                        => $id,
                'code'                      => $code,
                'no_po'                     => $no_po,
                'no_do'                     => $no_do,
                'request_datetime'          => $request_datetime,
                'request_datetime_formated' => $request_datetime_formated,
                'state'                     => $state,
                'description'               => $description,
                'items'                     => $items,
                'qty_requests'              => $qty_requests,
                'qty_receives'              => $qty_receives,
                'datetime_receives'         => $datetime_receives,
            ];

            array_push($data, $nested);
        }

        return $data;
    }

    public function up_sequence()
    {
        $this->db->set('seq', 'seq + 1', false);
        $this->db->where('code_date', date('Y-m-d'));
        return $this->db->update('stock_in_request_sequences');
    }

    public function get_item($where)
    {
        $this->db->select([
            'stock_in_request_items.id as stock_in_request_item_id',
            'stock_in_request_items.item_id',
            'items.code as item_code',
            'items.name as item_name',
            'stock_in_request_items.qty_request',
            'stock_in_request_items.qty_receive',
            'stock_in_request_items.datetime_receive',
            'stock_in_request_items.description',
            'stock_in_request_items.state_item',
            'units.name as unit_name',
        ]);
        $this->db->join('items', 'items.id = stock_in_request_items.item_id', 'left');
        $this->db->join('units', 'units.id = items.unit_id', 'left');
        $this->db->where($where);
        $stock_in_request_items = $this->db->get('stock_in_request_items');

        return $stock_in_request_items;
    }
}
                        
/* End of file M_stock_masuk.php */
