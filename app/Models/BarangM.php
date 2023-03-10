<?php

namespace App\Models;

use CodeIgniter\Model;

class BarangM extends Model
{
    protected $table = 'barang';
    protected $allowedFields = array('type', 'id_owner', 'kode_barang', 'nama_barang', 'harga', 'stok');
    protected $returnType     = 'object';
    protected $useSoftDeletes = false;

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules = [
        'type' => 'required|max_length[4]',
        'id_owner' => 'max_length[11]',
        'kode_barang' => 'required|max_length[50]',
        'nama_barang' => 'required|max_length[150]',
        'harga' => 'required|max_length[20]',
        'stok' => 'required|max_length[10]',
    ];

    protected $validationMessages = [
        'type' => ['required' => 'tidak boleh kosong', 'max_length' => 'Maximal 4 Karakter'],
        'id_owner' => ['max_length' => 'Maximal 11 Karakter'],
        'kode_barang' => ['required' => 'tidak boleh kosong', 'max_length' => 'Maximal 50 Karakter'],
        'nama_barang' => ['required' => 'tidak boleh kosong', 'max_length' => 'Maximal 150 Karakter'],
        'harga' => ['required' => 'tidak boleh kosong', 'max_length' => 'Maximal 20 Karakter'],
        'stok' => ['required' => 'tidak boleh kosong', 'max_length' => 'Maximal 10 Karakter'],
    ];
    private function _get_datatables()
    {
        $column_search = array('type', 'id_owner', 'kode_barang', 'nama_barang', 'harga', 'stok');
        $i = 0;
        foreach ($column_search as $item) { // loop column 
            if ($_GET['search']) {
                if ($i === 0) {
                    $this->groupStart();
                    $this->like($item, $_GET['search']);
                } else {
                    $this->orLike($item, $_GET['search']);
                }
                if (count($column_search) - 1 == $i)
                    $this->groupEnd();
            }
            $i++;
        }
        if (isset($_GET['order'])) {
            $this->orderBy($_GET['sort'], $_GET['order']);
        } else {
            $this->orderBy('id', 'asc');
        }

        $this->select('barang.*, o.nama');
        $this->join('owner o', 'o.id = barang.id_owner');
    }
    public function get_datatables()
    {
        $this->_get_datatables();
        $limit = isset($_GET['limit']) ? $_GET['limit'] : 0;
        $offset = isset($_GET['offset']) ? $_GET['offset'] : 0;
        return $this->findAll($limit, $offset);
    }
    public function total()
    {
        $this->_get_datatables();
        if ($this->tempUseSoftDeletes) {
            $this->where($this->table . '.' . $this->deletedField, null);
        }
        return $this->get()->getNumRows();
    }
}
/* End of file BarangM.php */
/* Location: ./app/models/BarangM.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2022-12-30 01:38:28 */