<?php
class Development_amount_model extends BASE_Model
{
  public $table = 'development_amount';
  public $allColumns = array('id', 'name', 'amount');

  function saveFormBulkData($idList, $amountList)
  {
    $developerCount = count($idList);
    for ($i = 0; $i < $developerCount; $i++) {
      $this->update(array('id' => $idList[$i]), array('amount' => $amountList[$i]));
    }
  }
}
