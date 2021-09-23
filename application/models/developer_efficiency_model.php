<?php
class Developer_efficiency_model extends BASE_Model
{

  public $table = 'developer_efficiency';
  public $allColumns = array('id', 'developer_name', 'efficiency', 'zoho_id');

  function saveFormBulkData($idList, $efficiencyList)
  {
    $developerCount = count($idList);
    for ($i = 0; $i < $developerCount; $i++) {
      $this->update(array('id' => $idList[$i]), array('efficiency' => $efficiencyList[$i]));
    }
  }

  function saveZohoData($items)
  {
    $zohoIds = array();
    foreach ($items as $item) {
      $zohoIds[] = $item['id'];
      $this->upsert(array('zoho_id' => $item['id']), array(
        'developer_name' => trim($item['firstName'] . ' ' . $item['lastName']),
        'zoho_id' => $item['id']
      ));
    }
    $this->db->where_not_in('zoho_id', $zohoIds)->delete($this->table);
  }
}
