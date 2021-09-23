<?php

function makeCurlRequest($url, $data, $method, $headers = null)
{
  $ch = curl_init();

  if ($method == 'post') {
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
  } else if ($method == 'get') {
    if ($data) {
      curl_setopt($ch, CURLOPT_URL, $url . '?' . http_build_query($data));
    } else {
      curl_setopt($ch, CURLOPT_URL, $url);
    }
  } else {
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, strtoupper($method));
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
  }
  if (!empty($headers)) {
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
  }
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  $response = curl_exec($ch);

  $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

  curl_close($ch);

  return array($httpCode, $response);
}

function refreshToken($refreshToken)
{
  $data = array(
    'refresh_token' => $refreshToken,
    'client_id' => ZOHO_CLIENT_ID,
    'client_secret' => ZOHO_CLIENT_SECRET,
    'scope' => ZOHO_SCOPE,
    'redirect_uri' => ZOHO_REDIRECT,
    'grant_type' => 'refresh_token'
  );

  $resp = makeCurlRequest(ZOHO_ACCOUNT_API . 'token', $data, 'post');
  if ($resp[0] != 401) {
    return json_decode($resp[1], true);
  }
  return null;
}

function getAllEngineer($accessToken)
{
  $headers = array(
    "orgId: " . ZOHO_ORG_ID,
    "Authorization: Zoho-oauthtoken " . $accessToken,
  );
  $resp = makeCurlRequest(ZOHO_DESK_API . 'teams/406743000000534072/members', null, 'get', $headers);
  if ($resp[0] != 401) {
    return json_decode($resp[1], true);
  }
  return null;
}

function getAllReleaseDefs($accessToken)
{
  $headers = array(
    "orgId: " . ZOHO_ORG_ID,
    "Authorization: Zoho-oauthtoken " . $accessToken,
  );
  $resp = makeCurlRequest(ZOHO_DESK_API . 'organizationFields/406743000000325229', null, 'get', $headers);
  if ($resp[0] != 401) {
    return json_decode($resp[1], true);
  }
  return null;
}

function getAllTickets($accessToken)
{
  $headers = array(
    "orgId: " . ZOHO_ORG_ID,
    "Authorization: Zoho-oauthtoken " . $accessToken,
  );
  $resp = makeCurlRequest(ZOHO_DESK_API . 'tickets/search?status=TEST&limit=5000', null, 'get', $headers);
  if ($resp[0] != 401) {
    return json_decode($resp[1], true);
  }
  return null;
}

function updateTicket($ticketId, $ticketData, $accessToken)
{
  $headers = array(
    "orgId: " . ZOHO_ORG_ID,
    "Authorization: Zoho-oauthtoken " . $accessToken,
  );

  /* echo ZOHO_DESK_API . 'tickets/' . $ticketId . '<br><br>';
  echo $accessToken . '<br><br>';
  echo json_encode($ticketData) . '<br><br>'; */

  $resp = makeCurlRequest(ZOHO_DESK_API . 'tickets/' . $ticketId, $ticketData, 'patch', $headers);
  if ($resp[0] != 401) {
    return json_decode($resp[1], true);
  }
  return null;
}

function calculateTickets($tickets, $developmentAmounts, $internalRanks)
{
  $ATRIUM = 1;
  $STUDENT_LINK = 2;
  $INDIA_FIRM = 3;
  $V4 = 4;
  $OTHER_OUTSIDE_FIRM = 5;

  $STRATEGIC = 1;
  $TACTICAL = 2;

  $developmentAmountArr = array();
  $internalRankArr = array();

  foreach ($developmentAmounts as $developmentAmount) {
    if ($developmentAmount->amount) {
      $developmentAmountArr['id' . $developmentAmount->id] = $developmentAmount->amount;
    }
  }
  foreach ($internalRanks as $internalRank) {
    if ($internalRank->amount) {
      $internalRankArr['id' . $internalRank->id] = $internalRank->amount;
    }
  }
  $finalTickets = array();
  foreach ($tickets as $ticket) {
    $cf = $ticket['cf'];
    if ($cf) {
      $A = $cf['cf_sales_strategic'];
      $B = $cf['cf_sales_tactical'];
      $C = $cf['cf_engineering_strategic'];
      $D = $cf['cf_engineering_tactical'];
      $E = $cf['cf_support_rank'];
      $F = $cf['cf_support_tactical'];
      $G = $cf['cf_implementation_strategic'];
      $H = $cf['cf_implementation_tactical'];
      $I = $cf['cf_client_rank_1'];
      $J = $cf['cf_student_link_est_dev_hours'];
      $K = $cf['cf_other_outside_firm_est_dev_hours'];
      $L = $cf['cf_v4_est_dev_hours'];
      $M = $cf['cf_atrium_est_dev_hours'];
      $N = $cf['cf_india_firm_est_dev_hours'];
      $O = $cf['cf_other_est_dev_costs'];
      $P = $cf['cf_client_committed_release'];
      $Q = $cf['cf_engineer_assigned'];

      if ($A && $B && $C && $D && $E && $F && $G && $H && $I && $J && $K && $L && $M && $N && $O && $P && $Q) {
        $cf_overall_atrium_rank = ((($A + $C + $E + $G) / 4) * $internalRankArr['id' . $STRATEGIC]) + ((($B + $D + $F + $H) / 4) * $internalRankArr['id' . $TACTICAL]);
        $cf_combined_rank = ((($cf_overall_atrium_rank * 3) + $I) / 4);
        $cf_total_est_dev_costs = ($J * $developmentAmountArr['id' . $STUDENT_LINK]) + ($M * $developmentAmountArr['id' . $ATRIUM]) + ($N * $developmentAmountArr['id' . $INDIA_FIRM]) + ($L * $developmentAmountArr['id' . $V4]) + ($K * $developmentAmountArr['id' . $OTHER_OUTSIDE_FIRM]) + $O;
        $cf_final_cost_rank = $cf_total_est_dev_costs / 6000.00;
        $cf_final_score = $cf_final_cost_rank * $cf_combined_rank;

        $cf['cf_overall_atrium_rank'] = round($cf_overall_atrium_rank);
        $cf['cf_combined_rank'] = round($cf_combined_rank);
        $cf['cf_total_est_dev_costs'] = round($cf_total_est_dev_costs);
        $cf['cf_final_cost_rank'] = round($cf_final_cost_rank);
        $cf['cf_final_score'] = round($cf_final_score);

        $ticket['cf'] = $cf;

        $finalTickets[] = $ticket;
      }
    }
  }

  return $finalTickets;
}
