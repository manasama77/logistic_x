<?php

defined('BASEPATH') or exit('No direct script access allowed');

class MasterSupplierController extends CI_Controller
{
    protected $datetime;

    public function __construct()
    {
        parent::__construct();
        $this->load->library('L_admin', null, 'template');
        $this->datetime = date('Y-m-d H:i:s');
    }


    public function index()
    {
        $arr = $this->M_core->get('suppliers', '*', null, 'id', 'asc');
        $data = [
            'title'      => APP_NAME . ' | Master Divisi',
            'content'    => 'management_barang/master_supplier/main',
            'vitamin_js' => 'management_barang/master_supplier/main_js',
            'arr'        => $arr,
        ];
        $this->template->render($data);
    }

    public function store()
    {
        $data = [
            'code'      => $this->input->post('code'),
            'name'      => $this->input->post('name'),
            'phone'     => $this->input->post('phone'),
            'email'     => $this->input->post('email'),
            'is_active' => $this->input->post('is_active'),
        ];
        $exec = $this->M_core->store('suppliers', $data);

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

    public function destroy()
    {
        $where = ['id' => $this->input->post('id')];
        $exec = $this->M_core->delete('suppliers', $where);

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

    public function update($id)
    {
        $where = ['id' => $id];
        $data = [
            'code'      => $this->input->post('code'),
            'name'      => $this->input->post('name'),
            'phone'     => $this->input->post('phone'),
            'email'     => $this->input->post('email'),
            'is_active' => $this->input->post('is_active'),
        ];
        $exec = $this->M_core->update('suppliers', $data, $where);

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
}
        
/* End of file  MasterSupplierController.php */
