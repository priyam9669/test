<?php defined('BASEPATH') or exit('No direct script access allowed');

class Roadmap extends BASE_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->model('Developer_efficiency_model');
    $this->load->model('Development_amount_model');
    $this->load->model('Internal_rank_model');
    $this->load->model('Release_definition_model');
    $this->load->model('Token_model');
  }

  public function index()
  {
    if ($this->session->userdata('id')) {
      $devEfficiencyList = $this->Developer_efficiency_model->selectAll();
      $releaseDefList = $this->Release_definition_model->selectAll();
      $internalRankList = $this->Internal_rank_model->selectAll();
      $devAmountList = $this->Development_amount_model->selectAll();

      $this->load->view('roadmap', ['devEfficiencyList' => $devEfficiencyList, 'internalRankList' => $internalRankList, 'devAmountList' => $devAmountList, 'releaseDefList' => $releaseDefList]);
    } else {
      // display login form
      redirect(base_url('sessions'));
    }
  }

  public function updateSettings()
  {
    if ($this->input->is_ajax_request()) {
      $this->load->library('form_validation');

      $postData = array();
      $res = array();

      $this->form_validation->set_rules('developer_efficiency[]', 'Developer Efficiency', 'trim|required|numeric|greater_than[0]');
      $this->form_validation->set_rules('internal_rank_amount[]', 'Internal Rank Settings', 'trim|required|numeric|greater_than[0]');
      $this->form_validation->set_rules('dev_per_hour_amount[]', 'Development Amount Per Hour Settings', 'trim|required|numeric|greater_than[0]');
      $this->form_validation->set_rules('release_enddate[0]', 'Release Definition End Date', 'trim|callback_compareReleaseDates');

      if ($this->form_validation->run() == false) {
        $res = array("status" => false, "type" => "error", "message" => validation_errors());
      } else {
        $postData = $this->input->post(null, true);
        $this->Developer_efficiency_model->saveFormBulkData($postData['developer_id'], $postData['developer_efficiency']);
        $this->Release_definition_model->saveFormBulkData($postData['release_date_id'], $postData['release_startdate'], $postData['release_enddate']);

        $res = array("status" => true, "type" => "", "message" => "Settings Saved Successfully");
      }
      echo json_encode($res);
    } else {
      die('Not Allowed');
    }
  }

  public function compareReleaseDates()
  {
    $postData = $this->input->post(null, true);
    $error = 0;

    $releaseStartDates = $postData["release_startdate"];
    $releaseEndDates = $postData["release_enddate"];

    foreach ($releaseStartDates as $releaseStartDateKey => $releaseStartDateValue) {
      $startDateVal = strtotime($releaseStartDateValue);
      $endDateVal = strtotime($releaseEndDates[$releaseStartDateKey]);
      if ($startDateVal > $endDateVal) {
        $error = $error + 1;
      }
    }

    if ($error == 0) {
      return true;
    } else {
      $this->form_validation->set_message('compareReleaseDates', 'End Date must be greater than Start Date');
      return false;
    }
  }

  public function refreshZohoData()
  {
    if ($this->input->is_ajax_request()) {
      $this->load->helper('zoho');

      $token = $this->Token_model->selectAll()[0];
      $refreshToken = $token->refresh_token;
      $accessToken = $token->access_token;
      $tokenId = $token->id;

      $developerList = getAllEngineer($accessToken);
      if (!$developerList) {
        $token = refreshToken($refreshToken);
        $this->Token_model->updateAccessToken($tokenId, $accessToken);
        $accessToken = $token['access_token'];

        $developerList = getAllEngineer($accessToken);
      }
      $this->Developer_efficiency_model->saveZohoData($developerList['members']);

      $releaseDefs = getAllReleaseDefs($accessToken);
      $this->Release_definition_model->saveZohoData($releaseDefs['allowedValues']);
    } else {
      die('Not Allowed');
    }
  }

  public function calculateRoadMap()
  {
    if ($this->input->is_ajax_request()) {
      $postData = $this->input->post(null, true);
      $releaseDef = $postData['release_def'];
      if (empty($releaseDef)) {
        die('Not Allowed');
      }
      $error = $this->calculateRoadMapWithRelease($releaseDef);
      if ($error) {
        die($error);
      }

      echo json_encode(array("status" => true, "type" => "", "message" => "Roadmap updated successfully."));
    } else {
      die('Not Allowed');
    }
  }

  private function calculateRoadMapWithRelease($releaseDef)
  {
    $this->load->helper('zoho');

    $releaseDefDB = $this->Release_definition_model->select(array('name' => $releaseDef));
    if (count($releaseDefDB) == 0) {
      return json_encode(array("status" => false, "type" => "error", "message" => "Release definition not found."));
    }
    $releaseDefDB = $releaseDefDB[0];
    $startDate = $releaseDefDB->start_date;
    $endDate = $releaseDefDB->end_date;
    if (empty($startDate) || empty($endDate)) {
      return json_encode(array("status" => false, "type" => "error", "message" => "Release definition not configured properly."));
    }
    $startDate = DateTime::createFromFormat('Y-m-d', $startDate);
    $endDate = DateTime::createFromFormat('Y-m-d', $endDate);

    $token = $this->Token_model->selectAll()[0];
    $refreshToken = $token->refresh_token;
    $accessToken = $token->access_token;
    $tokenId = $token->id;
    // list all the tickets
    $ticketList = getAllTickets($accessToken);
    if (!$ticketList) {
      $token = refreshToken($refreshToken);
      $this->Token_model->updateAccessToken($tokenId, $accessToken);
      $accessToken = $token['access_token'];

      $ticketList = getAllTickets($accessToken);
    }
    $ticketList = calculateTickets($ticketList['data'], $this->Development_amount_model->selectAll(), $this->Internal_rank_model->selectAll());

    $developers = $this->Developer_efficiency_model->selectAll();
    $ticketsByDeveloper = array();
    $ticketsByDeveloperWithClientCommit = array();
    $filteredDevelopers = array();
    foreach ($developers as $developer) {
      if ($developer->efficiency) {
        $ticketsByDeveloper[$developer->developer_name] = array();
        $ticketsByDeveloperWithClientCommit[$developer->developer_name] = array();
        $filteredDevelopers[$developer->developer_name] = $developer->efficiency;
      }
    }

    // divide the tickets by developer
    foreach ($ticketList as $ticket) {
      $cf_engineer_assigned = trim($ticket['cf']['cf_engineer_assigned']);
      if (isset($ticketsByDeveloper[$cf_engineer_assigned])) {
        if (trim($ticket['cf']['cf_client_committed_release']) == $releaseDef) {
          $ticketsByDeveloperWithClientCommit[$cf_engineer_assigned][] = $ticket;
        } else {
          $ticketsByDeveloper[$cf_engineer_assigned][] = $ticket;
        }
      } else {
        // this ticket wouldn't be considered in release def so write it to zoho
        updateTicket($ticket['id'], array('cf' => $ticket['cf']), $accessToken);
      }
    }

    // sort the tickets by final score
    function compareScore($t1, $t2)
    {
      return $t2['cf']['cf_final_score'] > $t1['cf']['cf_final_score'];
    }
    function getNextValidDay(&$date)
    {
      $wd = $date->format('w');
      if ($wd == 6) {
        $date->add(new DateInterval('P2D'));
      } else if ($wd == 5) {
        $date->add(new DateInterval('P3D'));
      } else {
        $date->add(new DateInterval('P1D'));
      }
    }
    foreach ($filteredDevelopers as $developer => $efficiency) {
      $ticketsWithClientCommit = $ticketsByDeveloperWithClientCommit[$developer];
      $tickets = $ticketsByDeveloper[$developer];

      if (count($ticketsWithClientCommit) > 1) {
        usort($ticketsWithClientCommit, 'compareScore');
      }
      if (count($tickets) > 1) {
        usort($tickets, 'compareScore');
      }
      // tickets sorted now assign the dates
      $finalTickets = array_merge($ticketsWithClientCommit, $tickets);
      $lastDate = clone $startDate;
      $lastDate->sub(new DateInterval('P1D'));
      $releaseDefDBLocal = $releaseDefDB;
      $releaseDefLocal = $releaseDef;
      $endDateLocal = $endDate;
      foreach ($finalTickets as &$ticket) {
        getNextValidDay($lastDate);
        $ticket['cf']['cf_estimated_start_date'] = $lastDate->format('Y-m-d');
        $days = ceil(($ticket['cf']['cf_atrium_est_dev_hours'] / 8) / $efficiency);
        for ($i = 0; $i < $days; $i++) {
          getNextValidDay($lastDate);
        }
        $ticket['cf']['cf_estimated_end_date'] = $lastDate->format('Y-m-d');
        if ($lastDate >= $endDateLocal) {
          $releaseDefDBLocal = null;
          $endDateLocal = null;
          while (empty($endDateLocal)) {
            $releaseDefDBLocal = $this->Release_definition_model->getNextRelease($lastDate);
            if ($releaseDefDBLocal) {
              $endDateLocal = $releaseDefDBLocal->end_date;
            }
          }
          if (!empty($endDateLocal)) {
            $releaseDefLocal = $releaseDefDBLocal->name;
            $ticket['cf']['cf_assigned_release'] = $releaseDefLocal;
            $releaseDefLocal = DateTime::createFromFormat('Y-m-d', $releaseDefLocal);
          } else {
            break;
          }
        } else {
          $ticket['cf']['cf_assigned_release'] = $releaseDefLocal;
        }
      }
      // upload the tickets to zoho
      foreach ($finalTickets as $ticket) {
        updateTicket($ticket['id'], array('cf' => $ticket['cf']), $accessToken);
      }
    }

    return null;
  }
}
