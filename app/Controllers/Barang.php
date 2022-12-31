<?php

namespace App\Controllers;

use App\Models\BarangM;
use App\Models\OwnerM;

class Barang extends BaseController
{
    protected $barangm;
    function __construct()
    {
        $this->barangm = new BarangM();
        $this->ownerm = new OwnerM();
    }
    public function index()
    {
        $this->data = array('title' => 'Barang | Admin', 'breadcome' => 'Barang', 'url' => 'barang/', 'm_barang' => 'active', 'session' => $this->session);

        echo view('App\Views\barang\barang_list', $this->data);
    }

    public function ajax_request()
    {
        $list = $this->barangm->get_datatables();
        $data = array();
        $no = isset($_GET['offset']) ? $_GET['offset'] + 1 : 1;
        foreach ($list as $rows) {
            $row = array();
            $row['id'] = $rows->id;
            $row['nomor'] = $no++;
            $row['type'] = $rows->type;
            $row['id_owner'] = $rows->nama;
            $row['kode_barang'] = $rows->kode_barang;
            $row['nama_barang'] = $rows->nama_barang;
            $row['harga'] = $rows->harga;
            $row['stok'] = $rows->stok;
            $data[] = $row;
        }
        $output = array(
            "total" => $this->barangm->total(),
            "totalNotFiltered" => $this->barangm->countAllResults(),
            "rows" => $data,
        );
        echo json_encode($output);
    }
    public function create()
    {
        $this->data = array('action' => 'insert', 'btn' => '<i class="fas fa-save"></i> Save');
        $num_of_row = $this->request->getPost('num_of_row');
        for ($x = 1; $x <= $num_of_row; $x++) {
            $data['nama'] = 'Data ' . $x;
            $data['pemilik'] = $this->ownerm->findAll();
            $this->data['form_input'][] = view('App\Views\barang\form_input', $data);
        }
        $status['html']         = view('App\Views\barang\form_modal', $this->data);
        $status['modal_title']  = 'Tambah Data Barang';
        $status['modal_size']   = 'modal-lg';
        echo json_encode($status);
    }
    public function edit()
    {
        $id = $this->request->getPost('id');
        $this->data = array('action' => 'update', 'btn' => '<i class="fas fa-edit"></i> Edit');
        foreach ($id as $ids) {
            $get = $this->barangm->find($ids);
            $data = array(
                'nama' => '<b>' . $get->nama_barang . '</b>',
                'get' => $get,
                'pemilik'=>$this->ownerm->findAll(),
            );
            $this->data['form_input'][] = view('App\Views\barang\form_input', $data);
        }
        $status['html']         = view('App\Views\barang\form_modal', $this->data);
        $status['modal_title']  = 'Update Data Barang';
        $status['modal_size']   = 'modal-lg';
        echo json_encode($status);
    }
    public function save()
    {
        switch ($this->request->getPost('action')) {
            case 'insert':
                $nama = $this->request->getPost('id');
                $data = array();
                foreach ($nama as $key => $val) {
                    $kodeBarang = $this->request->getPost('kode_barang')[$key];
                    if ($this->barangm->where('kode_barang', $kodeBarang)->first()) continue;
                    array_push($data, array(
                        'type' => $this->request->getPost('type')[$key],
                        'id_owner' => $this->request->getPost('id_owner')[$key],
                        'kode_barang' => $kodeBarang,
                        'nama_barang' => $this->request->getPost('nama_barang')[$key],
                        'harga' => (int)filter_var($this->request->getPost('harga')[$key], FILTER_SANITIZE_NUMBER_INT),
                        'stok' => $this->request->getPost('stok')[$key],
                    ));
                }
                if (empty($data)) {
                    $status['type'] = 'error';
                    $status['text'] = ['KODE BARANG' => 'Ada kode barang yang sudah terdaftar!!'];
                    return json_encode($status);
                }
                if ($this->barangm->insertBatch($data)) {
                    $status['type'] = 'success';
                    $status['text'] = 'Data Barang Tersimpan';
                } else {
                    $status['type'] = 'error';
                    $status['text'] = $this->barangm->errors();
                }
                echo json_encode($status);
                break;
            case 'update':
                $id = $this->request->getPost('id');
                $data = array();
                foreach ($id as $key => $val) {
                    $get = $this->barangm->find($val);
                    $kode_barang = $this->request->getPost('kode_barang')[$key];
                    if ($get->kode_barang != $kode_barang) {
                        $validationRules = [
                            'kode_barang'    => [
                                'rules'  => "is_unique[barang.kode_barang]",
                                'errors' => [
                                    'is_unique' => 'kode barang sudah terdaftar sudah terdaftar.',
                                ],
                            ],
                        ];
                        $this->barangm->setValidationRules($validationRules);
                    }
                    array_push($data, array(
                        'id' => $val,
                        'type' => $this->request->getPost('type')[$key],
                        'id_owner' => $this->request->getPost('id_owner')[$key],
                        'kode_barang' => $kode_barang,
                        'nama_barang' => $this->request->getPost('nama_barang')[$key],
                        'harga' => (int)filter_var($this->request->getPost('harga')[$key], FILTER_SANITIZE_NUMBER_INT),
                        'stok' => $this->request->getPost('stok')[$key],
                    ));
                }
                if ($this->barangm->updateBatch($data, 'id')) {
                    $status['type'] = 'success';
                    $status['text'] = 'Data Barang Telah Di Ubah';
                } else {
                    $status['type'] = 'error';
                    $status['text'] = $this->barangm->errors();
                }
                echo json_encode($status);
                break;
            case 'delete':
                if ($this->barangm->delete($this->request->getPost('id'))) {
                    $status['type'] = 'success';
                    $status['text'] = '<strong>Deleted..!</strong>Berhasil dihapus';
                } else {
                    $status['type'] = 'error';
                    $status['text'] = '<strong>Oh snap!</strong> Proses hapus data gagal.';
                }
                echo json_encode($status);
                break;
        }
    }
}

/* End of file Barang.php */
/* Location: ./app/controllers/Barang.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2022-12-30 01:38:28 */
/* http://harviacode.com */