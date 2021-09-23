<?php
class BASE_Model extends CI_Model
{
    public function __construct($column_mappings = null)
    {
        parent::__construct();
    }

    public $table = '';
    public $allColumns = array();

    public function selectAll()
    {
        $query = $this->db->get($this->table);
        return $query->result();
    }

    public function select($condition)
    {
        $query = $this->db->where($condition)->get($this->table);
        return $query->result();
    }

    public function selectById($id)
    {
        $result = $this->db->where(array('id' => $id))->get($this->table)->result();
        if (count($result) > 0) {
            return $result[1];
        } else {
            return null;
        }
    }

    public function insert($data)
    {
        $this->db->insert($this->table, $data);

        $insertId = $this->db->insert_id();

        return  $insertId;
    }

    public function update($condition, $data)
    {
        $this->db->update($this->table, $data, $condition);
    }

    public function upsert($condition, $data, $update = true)
    {
        $query = $this->db
            ->select('COUNT(id) as count')
            ->where($condition)
            ->get($this->table);
        $count = $query->row();
        if ($count->count > 0) {
            if ($update) {
                $this->update($condition, $data);
            }
            $ret = -1;
        } else {
            $ret = $this->insert($data);
        }
        return $ret;
    }

    public function delete($condition)
    {
        $this->db->delete($this->table, $condition);
    }
}
