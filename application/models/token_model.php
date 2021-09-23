<?php
class Token_model extends BASE_Model
{
  public $table = 'tokens';
  public $allColumns = array('id', 'access_token', 'refresh_token');

  function hasToken()
  {
    $query = $this->db
      ->select('COUNT(id) as count')
      ->get($this->table);
    $count = $query->row();
    return $count->count > 0;
  }

  function updateAccessToken($id, $accessToken)
  {
    $this->update(array('id' => $id), array('access_token' => $accessToken));
  }
}
