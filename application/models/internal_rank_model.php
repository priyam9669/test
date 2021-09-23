<?php
class Internal_rank_model extends BASE_Model
{
  public $table = 'internal_rank';
  public $allColumns = array('id', 'name', 'amount');

  function saveFormBulkData($idList, $amountList)
  {
    $developerCount = count($idList);
    for ($i = 0; $i < $developerCount; $i++) {
      $this->update(array('id' => $idList[$i]), array('amount' => $amountList[$i]));
    }
  }
}
