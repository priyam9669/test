<?php defined('BASEPATH') or exit('No direct script access allowed');

class Release_definition_model extends BASE_Model
{

  public $table = 'release_definition';
  public $allColumns = array('id', 'name', 'start_date', 'end_date');

  function saveFormBulkData($idList, $startDateList, $endDateList)
  {
    $developerCount = count($idList);
    for ($i = 0; $i < $developerCount; $i++) {
      $this->update(array('id' => $idList[$i]), array('start_date' => $startDateList[$i], 'end_date' => $endDateList[$i]));
    }
  }

  function saveZohoData($items)
  {
    $names = array();
    foreach ($items as $item) {
      if ($item['value'] != '-None-') {
        $name = trim($item['value']);
        $names[] = $name;
        $this->upsert(array('name' => $name), array(
          'name' => $name
        ), false);
      }
    }
    $this->db->where_not_in('name', $names)->delete($this->table);
  }

  function getNextRelease($date)
  {
    $result = $this->db->where($this->table . '.start_date >', $date->format('Y-m-d'))
      ->oder_by('start_date', 'ASC')
      ->limit(1)
      ->get($this->table)->result();

    if (count($result) > 0) {
      return $result[1];
    } else {
      return null;
    }
  }
}
