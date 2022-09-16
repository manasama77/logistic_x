<?php

defined('BASEPATH') or exit('No direct script access allowed');

class StockMasukController extends CI_Controller
{
    protected $datetime;

    public function __construct()
    {
        parent::__construct();
        $this->load->library('L_admin', null, 'template');
        $this->load->model('M_stock_masuk');
        $this->load->model('M_item');
        $this->load->helper('tanggal_indo_helper');
        $this->load->helper('sequence_helper');
        $this->datetime = date('Y-m-d H:i:s');
    }


    public function index()
    {
        $where = [
            'stock_in_requests.deleted_at' => null,
            'stock_in_requests.deleted_by' => null,
        ];
        $arr = $this->M_stock_masuk->get($where);

        $from_date = null;
        if ($this->input->get('from_request_datetime')) {
            $from_date = $this->input->get('from_request_datetime');
        }

        $to_date = null;
        if ($this->input->get('to_request_datetime')) {
            $to_date = $this->input->get('to_request_datetime');
        }

        $no_po = null;
        if ($this->input->get('no_po')) {
            $no_po = $this->input->get('no_po');
        }

        $no_do = null;
        if ($this->input->get('no_do')) {
            $no_do = $this->input->get('no_do');
        }

        $state = "All";
        if ($this->input->get('state') != "All") {
            $state = $this->input->get('state');
        }

        $where = [
            'deleted_at' => null,
            'deleted_by' => null,
        ];
        $item = $this->M_item->get($where);

        $item_id = "All";
        if ($this->input->get('item_id') != "All") {
            $item_id = $this->input->get('item_id');
        }

        $data = [
            'title'      => APP_NAME . ' | Stock Masuk',
            'content'    => 'management_barang/stock_masuk/main',
            'vitamin_js' => 'management_barang/stock_masuk/main_js',
            'arr'        => $arr,
            'from_date'  => $from_date,
            'to_date'    => $to_date,
            'no_po'      => $no_po,
            'no_do'      => $no_do,
            'state'      => $state,
            'item'       => $item,
            'item_id'    => $item_id,
        ];
        $this->template->render($data);
    }

    public function add()
    {
        $where = [
            'deleted_at' => null,
            'deleted_by' => null,
        ];
        $item = $this->M_item->get($where);

        $data = [
            'title'      => APP_NAME . ' | Tambah Stock Masuk',
            'content'    => 'management_barang/stock_masuk/form',
            'vitamin_js' => 'management_barang/stock_masuk/form_js',
            'item'       => $item,
        ];
        $this->template->render($data);
    }

    public function store()
    {
        $where = [
            'code'       => $this->input->post('code'),
            'deleted_at' => null,
            'deleted_by' => null,
        ];
        $check_duplikat = $this->M_core->count('stock_in_requests', $where);
        if ($check_duplikat > 0) {
            $message = "Kode Stock Masuk Telah Terdaftar";
            echo json_encode([
                'code'    => 500,
                'message' => $message,
            ]);
            exit;
        }

        $request_datetime_obj = new DateTime($this->input->post('request_date') . " " . $this->input->post('request_time'));
        $state = "Menunggu";
        if ($this->input->post('no_po')) {
            $state = "Proses";
        }

        $code = $this->input->post('code');
        if ($this->input->post('auto_generate_code') == "yes") {
            $arr_seq = $this->M_core->get('stock_in_request_sequences', 'seq', ['code_date' => date('Y-m-d')]);
            if ($arr_seq->num_rows() == 1) {
                $seq  = $arr_seq->row()->seq + 1;
                $seq  = empat_digit($seq);
                $code = "IN-" . date('Ymd') . "-" . $seq;
                $exec = $this->M_stock_masuk->up_sequence();
            } else {
                $seq  = empat_digit(1);
                $code = "IN-" . date('Ymd') . "-" . $seq;
                $exec = $this->M_core->store('stock_in_request_sequences', ['code_date' => date('Y-m-d'), 'seq' => 1]);
            }
        }


        $this->db->trans_start();
        $data = [
            'request_datetime' => $request_datetime_obj->format('Y-m-d H:i:s'),
            'code'             => $code,
            'state'            => $state,
            'description'      => $this->input->post('description'),
            'created_at'       => $this->datetime,
            'updated_at'       => $this->datetime,
            'deleted_at'       => null,
            'created_by'       => $this->session->userdata(SESI . 'id'),
            'updated_by'       => $this->session->userdata(SESI . 'id'),
            'deleted_by'       => null,
        ];
        $exec = $this->M_core->store('stock_in_requests', $data);
        if (!$exec) {
            $this->db->trans_rollback();
            $message = "Terjadi Kesalahan Ketika Input Stock Masuk " . $this->input->post('code');
            echo json_encode([
                'code'    => 500,
                'message' => $message,
            ]);
            exit;
        }
        $last_id = $this->db->insert_id();

        foreach ($this->input->post('list_item') as $key) {
            $item_id   = $key['itemId'];
            $item_name = $key['itemName'];
            $qty       = $key['qty'];

            $data = [
                'stock_in_request_id' => $last_id,
                'item_id'             => $item_id,
                'qty_request'         => $qty,
                'qty_receive'         => 0,
                'datetime_receive'    => null,
                'state_item'          => 'Menunggu',
                'description'         => null,
                'created_at'          => $this->datetime,
                'updated_at'          => $this->datetime,
                'deleted_at'          => null,
                'created_by'          => $this->session->userdata(SESI . 'id'),
                'updated_by'          => $this->session->userdata(SESI . 'id'),
                'deleted_by'          => null,
            ];
            $exec = $this->M_core->store('stock_in_request_items', $data);
            if (!$exec) {
                $this->db->trans_rollback();
                $message = "Terjadi Kesalahan Ketika Input Barang " . $item_name;
                echo json_encode([
                    'code'    => 500,
                    'message' => $message,
                ]);
                exit;
            }
        }

        $code    = 500;
        $message = "Tambah Data Gagal";
        if ($exec) {
            $code    = 200;
            $message = "Tambah Data Berhasil";
        }

        $this->db->trans_complete();

        echo json_encode([
            'code'    => $code,
            'message' => $message,
        ]);
    }

    public function edit($id)
    {
        $where = [
            'deleted_at' => null,
            'deleted_by' => null,
        ];
        $item = $this->M_item->get($where);

        $where = [
            'stock_in_requests.id'         => $id,
            'stock_in_requests.deleted_at' => null,
            'stock_in_requests.deleted_by' => null,
        ];
        $arr = $this->M_stock_masuk->get($where);

        $data = [
            'title'      => APP_NAME . ' | Edit Stock Masuk',
            'content'    => 'management_barang/stock_masuk/form_edit',
            'vitamin_js' => 'management_barang/stock_masuk/form_edit_js',
            'item'       => $item,
            'arr'        => $arr,
        ];
        $this->template->render($data);
    }

    public function update($id)
    {
        $request_date = $this->input->post('request_date');
        $request_time = $this->input->post('request_time');
        $code         = $this->input->post('code');
        $description  = $this->input->post('description');
        $list_item    = $this->input->post('list_item');

        $request_datetime_obj = new DateTime($request_date . " " . $request_time);

        $this->db->trans_start();
        $data = [
            'request_datetime' => $request_datetime_obj->format('Y-m-d H:i:s'),
            'code'             => $code,
            'description'      => $this->input->post('description'),
            'updated_at'       => $this->datetime,
            'updated_by'       => $this->session->userdata(SESI . 'id'),
        ];
        $where = ['id' => $id];
        $exec = $this->M_core->update('stock_in_requests', $data, $where);
        if (!$exec) {
            $this->db->trans_rollback();
            $message = "Terjadi Kesalahan Ketika Input Stock Masuk " . $this->input->post('code');
            echo json_encode([
                'code'    => 500,
                'message' => $message,
            ]);
            exit;
        }

        $this->M_core->delete('stock_in_request_items', ['stock_in_request_id' => $id]);

        foreach ($list_item as $key) {
            $item_id    = $key['itemId'];
            $item_name  = $key['itemName'];
            $qty        = $key['qty'];
            $state_item = 'Menunggu';

            $data = [
                'stock_in_request_id' => $id,
                'item_id'             => $item_id,
                'qty_request'         => $qty,
                'qty_receive'         => 0,
                'datetime_receive'    => null,
                'state_item'          => $state_item,
                'description'         => null,
                'created_at'          => $this->datetime,
                'updated_at'          => $this->datetime,
                'deleted_at'          => null,
                'created_by'          => $this->session->userdata(SESI . 'id'),
                'updated_by'          => $this->session->userdata(SESI . 'id'),
                'deleted_by'          => null,
            ];
            $exec = $this->M_core->store('stock_in_request_items', $data);
            if (!$exec) {
                $this->db->trans_rollback();
                $message = "Terjadi Kesalahan Ketika Input Barang " . $item_name;
                echo json_encode([
                    'code'    => 500,
                    'message' => $message,
                ]);
                exit;
            }
        }

        $code    = 500;
        $message = "Update Data Gagal";
        if ($exec) {
            $code    = 200;
            $message = "Update Data Berhasil";
        }

        $this->db->trans_complete();

        echo json_encode([
            'code'    => $code,
            'message' => $message,
        ]);
    }

    public function destroy()
    {
        $id = $this->input->post('id');

        $data = [
            'deleted_at' => $this->datetime,
            'deleted_by' => $this->session->userdata(SESI . 'id'),
        ];
        $where = ['id' => $id];
        $exec = $this->M_core->update('stock_in_requests', $data, $where);

        $code    = 500;
        $message = "Delete Data Gagal";
        if ($exec) {
            $code    = 200;
            $message = "Delete Data Berhasil";
        }

        $data = [
            'deleted_at' => $this->datetime,
            'deleted_by' => $this->session->userdata(SESI . 'id'),
        ];
        $where = ['stock_in_request_id' => $id];
        $exec = $this->M_core->update('stock_in_request_items', $data, $where);

        $code    = 500;
        $message = "Delete Data Gagal";
        if ($exec) {
            $code    = 200;
            $message = "Delete Data Berhasil";
        }

        echo json_encode([
            'code'    => $code,
            'message' => $message,
        ]);
    }

    public function get_list_item($id)
    {
        $where = [
            'stock_in_request_items.stock_in_request_id' => $id,
            'stock_in_request_items.deleted_at'          => null,
            'stock_in_request_items.deleted_by'          => null,
        ];
        $arr = $this->M_stock_masuk->get_item($where);

        echo json_encode([
            'code' => 200,
            'data' => $arr->result(),
        ]);
    }

    public function show()
    {
        $id = $this->input->get('id');

        $data = [];

        $where   = ['id' => $id];
        $request = $this->M_core->get('stock_in_requests', '*', $where);

        if ($request->num_rows() > 0) {
            foreach ($request->result() as $key1) {
                $request_datetime = $key1->request_datetime;
                $code             = $key1->code;
                $no_po            = $key1->no_po;
                $no_do            = $key1->no_do;
                $state            = $key1->state;
                $description      = $key1->description;

                $dt_obj = new DateTime($request_datetime);

                $data['request_datetime']      = $dt_obj->format("Y-m-d H:i");
                $data['request_datetime_indo'] = tanggal_jam_indo_no_dash_plain($request_datetime);
                $data['code']                  = $code;
                $data['no_po']                 = $no_po;
                $data['no_do']                 = $no_do;
                $data['state']                 = $state;
                $data['description']           = $description;
                $data['items']                 = [];

                $where     = ['stock_in_request_items.stock_in_request_id' => $id];
                $arr_items = $this->M_stock_masuk->get_item($where);

                if ($arr_items->num_rows() > 0) {
                    foreach ($arr_items->result() as $key2) {
                        $dt_obj_item = new DateTime($key2->datetime_receive);

                        $stock_in_request_item_id = $key2->stock_in_request_item_id;
                        $item_id                  = $key2->item_id;
                        $item_code                = $key2->item_code;
                        $item_name                = $key2->item_name;
                        $qty_request              = $key2->qty_request;
                        $qty_receive              = $key2->qty_receive;
                        $datetime_receive         = $dt_obj_item->format('Y-m-d H:i');
                        $description              = $key2->description;
                        $unit_name                = $key2->unit_name;
                        $state_item               = $key2->state_item;

                        $nested = [
                            'stock_in_request_item_id' => $stock_in_request_item_id,
                            'item_id'                  => $item_id,
                            'item_code'                => $item_code,
                            'item_name'                => $item_name,
                            'qty_request'              => $qty_request,
                            'qty_receive'              => $qty_receive,
                            'datetime_receive'         => $datetime_receive,
                            'description'              => $description,
                            'unit_name'                => $unit_name,
                            'state_item'               => $state_item,
                        ];

                        array_push($data['items'], $nested);
                    }
                }
            }
        }

        echo json_encode([
            'data'  => $data,
        ]);
    }

    public function update_detail()
    {
        $id                       = $this->input->post('id');
        $state                    = $this->input->post('state');
        $no_po                    = $this->input->post('no_po');
        $no_do                    = $this->input->post('no_do');
        $stock_in_request_item_id = $this->input->post('stock_in_request_item_id');
        $qty_request              = $this->input->post('qty_request');
        $qty_receive              = $this->input->post('qty_receive');
        $datetime_receive         = $this->input->post('datetime_receive');
        $state_item               = $this->input->post('state_item');

        if ($no_do) {
            if (count($qty_receive) > 0) {
                foreach ($stock_in_request_item_id as $key => $val) {
                    $x              = $this->M_core->get('stock_in_request_items', 'item_id, state_item', ['id' => $val]);
                    $item_id        = $x->row()->item_id;
                    $state_item_old = $x->row()->state_item;

                    if ($state_item_old == "Menunggu") {
                        $exec = $this->M_item->update_stock($item_id, $qty_receive[$key]);
                    }

                    $dt = new DateTime($datetime_receive[$key]);
                    $dt->createFromFormat('d-M-Y H:i', $datetime_receive[$key]);
                    $data = [
                        'qty_receive'      => $qty_receive[$key],
                        'datetime_receive' => ($datetime_receive[$key]) ? $dt->format('Y-m-d H:i:s') : null,
                        'state_item'       => $state_item[$key],
                    ];
                    $where = ['id' => $val];
                    $exec = $this->M_core->update('stock_in_request_items', $data, $where);
                }
            }
        }

        $data = [
            'no_po' => $no_po,
            'no_do' => $no_do,
            'state' => $state,
        ];
        $where = ['id' => $id];
        $exec = $this->M_core->update('stock_in_requests', $data, $where);

        echo json_encode([
            'code'    => 200,
            'message' => 'Update Success',
        ]);
    }
}
        
/* End of file  StockMasukController.php */