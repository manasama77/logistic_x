<?php

defined('BASEPATH') or exit('No direct script access allowed');

class SatuanBarangController extends CI_Controller
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
        $arr = $this->M_core->get('units', '*', null, 'id', 'asc');
        $data = [
            'title'      => APP_NAME . ' | Satuan Barang',
            'content'    => 'management_barang/satuan_barang/main',
            'vitamin_js' => 'management_barang/satuan_barang/main_js',
            'arr'        => $arr,
        ];
        $this->template->render($data);
    }

    public function store()
    {
        $data = [
            'name'         => $this->input->post('name'),
        ];
        $exec = $this->M_core->store('units', $data);

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
        $exec = $this->M_core->delete('units', $where);

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
            'name'         => $this->input->post('name'),
        ];
        $exec = $this->M_core->update('units', $data, $where);

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
        
/* End of file  SatuanBarangController.php */
