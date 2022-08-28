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
                $seq = $arr_seq->row()->seq + 1;
                $seq = empat_digit($seq);
                $code = "IN-" . date('Ymd') . "-" . $seq;
                $exec = $this->M_stock_masuk->up_sequence();
            } else {
                $seq = empat_digit(1);
                $code = "IN-" . date('Ymd') . "-" . $seq;
                $exec = $this->M_core->store('stock_in_request_sequences', ['code_date' => date('Y-m-d'), 'seq' => 1]);
            }
        }


        $this->db->trans_start();
        $data = [
            'request_datetime' => $request_datetime_obj->format('Y-m-d H:i:s'),
            'code'             => $code,
            'no_po'            => $this->input->post('no_po'),
            'no_do'            => $this->input->post('no_do'),
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
        $arr      = $this->M_core->get('stock_in_requests', '*', ['stock_in_requests.id' => $id], 'id', 'asc');
        $category = $this->M_core->get('categories', '*', null, 'name', 'asc');
        $unit     = $this->M_core->get('units', '*', null, 'name', 'asc');
        $supplier = $this->M_core->get('suppliers', '*', null, 'name', 'asc');
        $location = $this->M_core->get('locations', '*', null, 'name', 'asc');

        $data = [
            'title'      => APP_NAME . ' | Edit Stock Masuk',
            'content'    => 'management_barang/stock_masuk/form_edit',
            'vitamin_js' => 'management_barang/stock_masuk/form_edit_js',
            'arr'        => $arr,
            'category'   => $category,
            'unit'       => $unit,
            'supplier'   => $supplier,
            'location'   => $location,
        ];
        $this->template->render($data);
    }

    public function update($id)
    {
        if ($this->input->post('code') != $this->input->post('code_old')) {
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
        }

        $image_path = $this->input->post('image_path_old');

        if ($_FILES['image_path']['size'] > 0) {
            $this->load->library('upload');
            if (!$this->upload->do_upload('image_path')) {
                $message = $this->upload->display_errors();
                echo json_encode([
                    'code'    => 500,
                    'message' => $message,
                ]);
                exit;
            }

            $uploaded_data = $this->upload->data();
            $image_path    = $uploaded_data['file_name'];
            unlink("public/img/barang/" . $this->input->post('image_path_old'));
        }

        $data = [
            'code'        => $this->input->post('code'),
            'name'        => $this->input->post('name'),
            'merk'        => $this->input->post('merk'),
            'image_path'  => $image_path,
            'category_id' => $this->input->post('category_id'),
            'unit_id'     => $this->input->post('unit_id'),
            'location_id' => $this->input->post('location_id'),
            'supplier_id' => $this->input->post('supplier_id'),
            'updated_at'  => $this->datetime,
            'updated_by'  => $this->session->userdata(SESI . 'id'),
        ];
        $where = ['id' => $id];
        $exec = $this->M_core->update('stock_in_requests', $data, $where);

        $code    = 500;
        $message = "Update Data Gagal";
        if ($exec) {
            $code    = 200;
            $message = "Update Data Berhasil";
        }

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

        echo json_encode([
            'code'    => $code,
            'message' => $message,
        ]);
    }
}
        
/* End of file  StockMasukController.php */
