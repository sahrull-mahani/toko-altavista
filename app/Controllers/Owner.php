<?php

namespace App\Controllers;

use App\Models\OwnerM;

class Owner extends BaseController
{
    protected $ownerm;
    function __construct()
    {
        $this->ownerm = new OwnerM();
    }
    public function index()
    {
        $this->data = array('title' => 'Owner | Admin', 'breadcome' => 'Owner', 'url' => 'owner/', 'm_owner' => 'active', 'session' => $this->session);

        echo view('App\Views\owner\owner_list', $this->data);
    }

    public function ajax_request()
    {
        $list = $this->ownerm->get_datatables();
        $data = array();
        $no = isset($_GET['offset']) ? $_GET['offset'] + 1 : 1;
        foreach ($list as $rows) {
            $row = array();
            $row['id'] = $rows->id;
            $row['nomor'] = $no++;
            $row['nama'] = $rows->nama;
            $data[] = $row;
        }
        $output = array(
            "total" => $this->ownerm->total(),
            "totalNotFiltered" => $this->ownerm->countAllResults(),
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
            $this->data['form_input'][] = view('App\Views\owner\form_input', $data);
        }
        $status['html']         = view('App\Views\owner\form_modal', $this->data);
        $status['modal_title']  = 'Tambah Data Owner';
        $status['modal_size']   = 'modal-lg';
        echo json_encode($status);
    }
    public function edit()
    {
        $id = $this->request->getPost('id');
        $this->data = array('action' => 'update', 'btn' => '<i class="fas fa-edit"></i> Edit');
        foreach ($id as $ids) {
            $get = $this->ownerm->find($ids);
            $data = array(
                'nama' => '<b>' . $get->nama . '</b>',
                'get' => $get,
            );
            $this->data['form_input'][] = view('App\Views\owner\form_input', $data);
        }
        $status['html']         = view('App\Views\owner\form_modal', $this->data);
        $status['modal_title']  = 'Update Data Owner';
        $status['modal_size']   = 'modal-lg';
        echo json_encode($status);
    }
    public function save()
    {
        switch ($this->request->getPost('action')) {
            case 'insert':
                $nama = $this->request->getPost('nama');
                $data = array();
                foreach ($nama as $key => $val) {
                    $get = $this->ownerm->where('nama', $val)->countAllResults();
                    if ($get > 0) continue;
                    array_push($data, array(
                        'nama' => $this->request->getPost('nama')[$key],
                    ));
                }
                if (empty($data)) {
                    $status['type'] = 'error';
                    $status['text'] = ['NAMA' => 'Ada nama yang sudah terdaftar!!'];
                    return json_encode($status);
                }
                if ($this->ownerm->insertBatch($data)) {
                    $status['type'] = 'success';
                    $status['text'] = 'Data Owner Tersimpan';
                } else {
                    $status['type'] = 'error';
                    $status['text'] = $this->ownerm->errors();
                }
                echo json_encode($status);
                break;
            case 'update':
                $id = $this->request->getPost('id');
                $data = array();
                foreach ($id as $key => $val) {
                    $get = $this->ownerm->find($val);
                    $nama = $this->request->getPost('nama')[$key];
                    if ($get->nama != $nama) {
                        $validationRules = [
                            'nama'    => [
                                'rules'  => "is_unique[owner.nama]",
                                'errors' => [
                                    'is_unique' => 'nama sudah terdaftar.',
                                ],
                            ],
                        ];
                        $this->ownerm->setValidationRules($validationRules);
                    }
                    array_push($data, array(
                        'id' => $val,
                        'nama' => $this->request->getPost('nama')[$key],
                    ));
                }
                if ($this->ownerm->updateBatch($data, 'id')) {
                    $status['type'] = 'success';
                    $status['text'] = 'Data Owner Telah Di Ubah';
                } else {
                    $status['type'] = 'error';
                    $status['text'] = $this->ownerm->errors();
                }
                echo json_encode($status);
                break;
            case 'delete':
                if ($this->ownerm->delete($this->request->getPost('id'))) {
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

/* End of file Owner.php */
/* Location: ./app/controllers/Owner.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2022-12-30 01:12:47 */
/* http://harviacode.com */