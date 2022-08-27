<?php

defined('BASEPATH') or exit('No direct script access allowed');

class MasterBarangController extends CI_Controller
{
    protected $datetime;

    public function __construct()
    {
        parent::__construct();
        $this->load->library('L_admin', null, 'template');
        $this->load->model('M_item');
        $this->datetime = date('Y-m-d H:i:s');
    }


    public function index()
    {
        $where = [
            'deleted_at' => null,
            'deleted_by' => null,
        ];
        $arr = $this->M_item->get($where);
        $data = [
            'title'      => APP_NAME . ' | Master Barang',
            'content'    => 'management_barang/master_barang/main',
            'vitamin_js' => 'management_barang/master_barang/main_js',
            'arr'        => $arr,
        ];
        $this->template->render($data);
    }

    public function add()
    {
        $category = $this->M_core->get('categories', '*', null, 'name', 'asc');
        $unit     = $this->M_core->get('units', '*', null, 'name', 'asc');
        $supplier = $this->M_core->get('suppliers', '*', null, 'name', 'asc');
        $location = $this->M_core->get('locations', '*', null, 'name', 'asc');

        $data = [
            'title'      => APP_NAME . ' | Tambah Master Barang',
            'content'    => 'management_barang/master_barang/form',
            'vitamin_js' => 'management_barang/master_barang/form_js',
            'category'   => $category,
            'unit'       => $unit,
            'supplier'   => $supplier,
            'location'   => $location,
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
        $check_duplikat = $this->M_core->count('items', $where);
        if ($check_duplikat > 0) {
            $message = "Kode Barang Telah Terdaftar";
            echo json_encode([
                'code'    => 500,
                'message' => $message,
            ]);
            exit;
        }

        $image_path = null;

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
        }

        $data = [
            'code'        => $this->input->post('code'),
            'name'        => $this->input->post('name'),
            'merk'        => $this->input->post('merk'),
            'qty'         => 0,
            'image_path'  => $image_path,
            'category_id' => $this->input->post('category_id'),
            'unit_id'     => $this->input->post('unit_id'),
            'location_id' => $this->input->post('location_id'),
            'supplier_id' => $this->input->post('supplier_id'),
            'created_at'  => $this->datetime,
            'updated_at'  => $this->datetime,
            'deleted_at'  => null,
            'created_by'  => $this->session->userdata(SESI . 'id'),
            'updated_by'  => $this->session->userdata(SESI . 'id'),
            'deleted_by'  => null,
        ];
        $exec = $this->M_core->store('items', $data);

        $code    = 500;
        $message = "Tambah Data Gagal";
        if ($exec) {
            $code    = 200;
            $message = "Tambah Data Berhasil";
        }

        echo json_encode([
            'code'    => $code,
            'message' => $message,
        ]);
    }

    public function edit($id)
    {
        $arr      = $this->M_core->get('items', '*', ['items.id' => $id], 'id', 'asc');
        $category = $this->M_core->get('categories', '*', null, 'name', 'asc');
        $unit     = $this->M_core->get('units', '*', null, 'name', 'asc');
        $supplier = $this->M_core->get('suppliers', '*', null, 'name', 'asc');
        $location = $this->M_core->get('locations', '*', null, 'name', 'asc');

        $data = [
            'title'      => APP_NAME . ' | Edit Master Barang',
            'content'    => 'management_barang/master_barang/form_edit',
            'vitamin_js' => 'management_barang/master_barang/form_edit_js',
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
            $check_duplikat = $this->M_core->count('items', $where);
            if ($check_duplikat > 0) {
                $message = "Kode Barang Telah Terdaftar";
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
        $exec = $this->M_core->update('items', $data, $where);

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
        $exec = $this->M_core->update('items', $data, $where);

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
        
/* End of file  MasterBarangController.php */
