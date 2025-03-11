<?php

namespace App\Models;

use CodeIgniter\Model;

class CommonModel extends Model
{
  public function insertValue($table, $data)
  {
    $builder = $this->db->table($table);
    $builder->insert($data);
    return true;
  }
  public function updateValue($table, $where, $data)
  {
    $builder = $this->db->table($table);
    $builder->where($where);
    $builder->update($data);
    return true;
  }
  public function deleteValue($table, $where)
  {
    $builder = $this->db->table($table);
    $builder->where($where);
    $builder->delete();
    return true;
  }
  public function selectRecord($table, $where = array())
  {
    $builder = $this->db->table($table);
    $builder->where($where);
    $result = $builder->get();
    return $result->getResult();
  }
  public function selectRow($table, $where = array())
  {
    $builder = $this->db->table($table);
    $builder->where($where);
    $result = $builder->get();
    return $result->getRow();
  }
}