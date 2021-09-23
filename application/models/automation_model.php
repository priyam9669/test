<?php
class Automation_Model extends BASE_Model {

    function createTeams($formArray) {
        $this->db->insert("teams",$formArray);
    }

    function allTeams() {
        return $teams = $this->db->where('delete_date', NULL)->get("teams")->result_array();
    }

    function updateTeams($id, $formArray) {
        $this->db->where('id', $id);
        $this->db->update("teams", $formArray);
    }

    function updateTeamByName($team_name, $formArray) {
        $this->db->where("team_name", $team_name);
        $this->db->update("teams", $formArray);
    }

    function teamsForEmployee() {
        $condition = array('delete_date ' => NULL , 'can_assign' => 1);
        return $teams = $this->db->where($condition)->get("teams")->result_array();
    }

    function createEmployee($formArray) {
        $this->db->insert("login",$formArray);
    }

    function allEmployees() {
        return $employees = $this->db->where('delete_date', NULL)->get("login")->result_array();
    }

    function getOneEmployee($id) {
        return $employees = $this->db->where('id', $id)->get("login")->row();
    }

    function updateEmployee($id, $formArray) {
        $this->db->where('id', $id);
        $this->db->update("login", $formArray);
    }

    function createDBS($formArray) {
        $this->db->insert("dbs",$formArray);
    }

    function allDBS() {
        return $dbs = $this->db->where('delete_date', NULL)->get("dbs")->result_array();
    }

    function updateDBS($id, $formArray) {
        $this->db->where('id', $id);
        $this->db->update("dbs", $formArray);
    }

    function lastCreatedVersion() {
        return $versions = $this->db->order_by('id',"desc")->limit(1)->get('versions')->row();
    }

    function allVersions() {
        return $teams = $this->db->where('delete_date', NULL)->get("versions")->result_array();
    }

    function createVersions($formArray) {
        $this->db->insert("versions",$formArray);
    }

    function deleteVersions($id, $formArray) {
        $this->db->where('id', $id);
        $this->db->update("versions", $formArray);
    }
}
?>