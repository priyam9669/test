<?php defined('BASEPATH') or exit('No direct script access allowed');

class Automation extends BASE_Controller
{

  public function __construct()
  {
    parent::__construct();
    $this->load->model('Automation_Model');
  }

    public function index() {
        
        $teams = $this->Automation_Model->allTeams();
        $data = array();
        $data['teams'] = $teams;
        $this->load->view('automation/teams', $data);
    }
    public function verifyOtp(){
        $this->load->library('phpmailer_lib');
		    // PHPMailer object
		    $mail = $this->phpmailer_lib->load();
		
			// SMTP configuration
			$mail->isSMTP();
			$mail->Host     = 'email-smtp.us-west-2.amazonaws.com';
			$mail->SMTPAuth = TRUE;
			$mail->Username = 'AKIAQW2MZUI4YS3PYWUV';
			$mail->Password = 'BMo6s0pwjnxqztbb8YQ/52ZxoX4Kg6syp6ziYTAkz4A9';
			$mail->SMTPSecure = 'tls';
			$mail->Port     = 587;
	
			$mail->setFrom('no-reply@poccomu.com', 'Poccomu');
			$mail->addReplyTo('no-reply@poccomu.com', 'Poccomu');
	
			// Add a recipient
			$mail->addAddress($this->session->userdata('email'));
	
			// Add cc or bcc 
			//$mail->addCC('cc@example.com');
			//$mail->addBCC('bcc@example.com');
	
			// Email subject
			$mail->Subject = 'OTP Atrium';
	
			// Set email format to HTML
			$mail->isHTML(TRUE);
			$otpData= $this->session->userdata('otp');
			// Email body content
			$mailContent = "<p>Here is your otp to log in, kindly verify yourself using below otp.</p>
				<p>OTP: $otpData</p>";
			$mail->Body = $mailContent;
	
			// Send email
			if(!$mail->send()){
				echo 'Message could not be sent.';
				echo 'Mailer Error: ' . $mail->ErrorInfo;
                
			}else{
                $this->load->view('automation/otp');
			}
    }
    public function checkOtp() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('otp', 'Otp', 'required|min_length[6]|max_length[6]');

        if ($this->form_validation->run() == false) {
            $this->load->view('automation/otp');
        } else {
            $userOtp = (int) $this->session->userdata('otp');
            $userTypedOtp = (int) $this->input->post('otp');
            if ($userOtp == $userTypedOtp) {
                redirect(base_url('dashboard'));
            } else {
                $this->load->view('automation/otp');
            }
        }
        
    }
    public function createTeams() {
        $this->load->library('form_validation');
            $this->form_validation->set_rules('team_name', 'Team name', 'trim|required|xss_clean|is_unique[teams.team_name]');
            if ($this->form_validation->run() == false) {
                $teams = $this->Automation_Model->allTeams();
                $data = array();
                $data['teams'] = $teams;
                $this->load->view('automation/teams', $data);
            } else {
                $formArray = array();
                $formArray['team_name'] = $this->input->post('team_name');
                $formArray['can_assign'] = 1;
                $formArray['create_user'] = $this->session->userdata('first_name');
                $formArray['create_method'] = "POST";
                $this->Automation_Model->createTeams($formArray);
                redirect(base_url('automation/index'));
                }
    }

    public function updateTeams() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('t_id', 'Team id', 'required');
        $this->form_validation->set_rules('t_name', 'Team name', 'trim|required|xss_clean|is_unique[teams.team_name]');
        if ($this->form_validation->run() == false) {
            $teams = $this->Automation_Model->allTeams();
            $data = array();
            $data['teams'] = $teams;
            $this->load->view('automation/teams', $data);
        } else {
            $formArray = array();
            $id = $this->input->post('t_id');
            $formArray['team_name'] = $this->input->post('t_name');
            $currentDate = date('Y-m-d');
            $formArray['modify_date'] = $currentDate;
            $formArray['modify_user'] = $this->session->userdata('first_name');
            $formArray['modify_method'] = "POST";
            $this->Automation_Model->updateTeams($id, $formArray);
            redirect(base_url('automation/index'));
        }
    }

    public function deleteTeams() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('td_id', 'Team id', 'required');
        if ($this->form_validation->run() == false) {
            redirect(base_url('automation/index'));
        } else {
            $formArray = array();
            $id = $this->input->post('td_id');
            $currentDate = date('Y-m-d');
            $formArray['delete_date'] = $currentDate;
            $formArray['delete_user'] = $this->session->userdata('first_name');
            $formArray['delete_method'] = "POST";
            $this->Automation_Model->updateTeams($id, $formArray);
            redirect(base_url('automation/index'));
        }
    }

    public function employee() {
        $teams = $this->Automation_Model->teamsForEmployee();
        $data = array();
        $data['teams'] = $teams;
        $this->load->view('automation/employee', $data);
    }

    public function createEmployee() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('first_name', 'First name', 'required');
        $this->form_validation->set_rules('last_name', 'Last name', 'required');
        $this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean|is_unique[login.username]');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[8]|max_length[25]|callback_check_strong_password');
        $this->form_validation->set_rules('mobile', 'Mobile', 'trim|required|xss_clean|is_unique[login.mobile]');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean|is_unique[login.email]');
        if ($this->form_validation->run() == false) {
            $teams = $this->Automation_Model->allTeams();
            $data = array();
            $data['teams'] = $teams;
            $this->load->view('automation/employee', $data);
        } else {
            $formArray = array();
            $arrData = $this->input->post('teams_list');
            $arrS = serialize($arrData);
            $formArray['first_name'] = $this->input->post('first_name');
            $formArray['last_name'] = $this->input->post('last_name');
            $formArray['username'] = trim($this->input->post('username'));
            $formArray['password'] = crypt($this->input->post('password'));
            $formArray['mobile'] = trim($this->input->post('mobile'));
            $formArray['email'] = trim($this->input->post('email'));
            $formArray['team'] = $arrS;
            $formArray['create_user'] = $this->session->userdata('first_name');
            $formArray['create_method'] = "POST";
            $parssedData = unserialize($arrS);
            if (in_array('CEO', $parssedData, true)) {
                $formArr = array();
                $team_name = "CEO";
                $formArr['team_name'] = "CEO";
                $formArr['can_assign'] = 0;
                $currentDate = date('Y-m-d');
                $formArr['modify_date'] = $currentDate;
                $formArr['modify_user'] = $this->session->userdata('first_name');
                $formArr['modify_method'] = "POST";
                $this->Automation_Model->updateTeamByName($team_name, $formArr);
                $this->Automation_Model->createEmployee($formArray);
                redirect(base_url('automation/employee'));
            } else {
                $this->Automation_Model->createEmployee($formArray);
                redirect(base_url('automation/employee'));
            }
        }
    }

    public function check_strong_password($str)
    {
       if (preg_match('/^(?=.*\d)(?=.*[@#\-_$%^&+=§!\?])(?=.*[a-z])(?=.*[A-Z])[0-9A-Za-z@#\-_$%^&+=§!\?]{8,25}$/', $str)) {
         return TRUE;
       }
       $this->form_validation->set_message('check_strong_password', 'The Password field must contain at least one lowercase charecter, uppercase charecter, digit and special charecter.');
       return FALSE;
    }

    public function employeeList() {
        $employees = $this->Automation_Model->allEmployees();
        $data = array();
        $data['employees'] = $employees;
        $this->load->view('automation/employee_list', $data);
    }

    public function updateEmployees() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('id', 'Employee id', 'required');
        $this->form_validation->set_rules('first_name', 'First name', 'required');
        $this->form_validation->set_rules('last_name', 'Last name', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required');
        $this->form_validation->set_rules('mobile', 'Mobile', 'required');
        if ($this->form_validation->run() == false) {
            redirect(base_url('automation/employeeList'));
        } else {
            $formArray = array();
            $id = $this->input->post('id');
            $formArray['first_name'] = $this->input->post('first_name');
            $formArray['last_name'] = $this->input->post('last_name');
            $formArray['email'] = $this->input->post('email');
            $formArray['mobile'] = $this->input->post('mobile');
            $currentDate = date('Y-m-d');
            $formArray['modify_date'] = $currentDate;
            $formArray['modify_user'] = $this->session->userdata('first_name');
            $formArray['modify_method'] = "POST";
            $this->Automation_Model->updateEmployee($id, $formArray);
            redirect(base_url('automation/employeeList'));
        }
    }

    public function deleteEmployee() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('e_id', 'Employee id', 'required');
        if ($this->form_validation->run() == false) {
            redirect(base_url('automation/employeeList'));
        } else {
            $formArray = array();
            $id = $this->input->post('e_id');
            $currentDate = date('Y-m-d');
            $formArray['delete_date'] = $currentDate;
            $formArray['delete_user'] = $this->session->userdata('first_name');
            $formArray['delete_method'] = "POST";
            $this->Automation_Model->updateEmployee($id, $formArray);
            redirect(base_url('automation/employeeList'));
        }
    }

    public function db() {
        $dbs = $this->Automation_Model->allDBS();
        $data = array();
        $data['dbs'] = $dbs;
        $this->load->view('automation/db', $data);
    }

    public function createDB() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('database_name', 'Database name', 'required');
        if ($this->form_validation->run() == false) {
            redirect(base_url('automation/db'));
        } else {
            $formArray = array();
            $formArray['database_name'] = $this->input->post('database_name');
            $formArray['database_status'] = $this->input->post('database_status');
            $formArray['create_user'] = $this->session->userdata('first_name');
            $formArray['create_method'] = "POST";
            $this->Automation_Model->createDBS($formArray);
            redirect(base_url('automation/db'));
            }
    }

    public function updateDB() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('db_id', 'Database id', 'required');
        $this->form_validation->set_rules('db_name', 'Database name', 'required');
        $this->form_validation->set_rules('db_status', 'Database status', 'required');
        if ($this->form_validation->run() == false) {
            redirect(base_url('automation/db'));
        } else {
            $formArray = array();
            $id = $this->input->post('db_id');
            $formArray['database_name'] = $this->input->post('db_name');
            $formArray['database_status'] = $this->input->post('db_status');
            $currentDate = date('Y-m-d');
            $formArray['modify_date'] = $currentDate;
            $formArray['modify_user'] = $this->session->userdata('first_name');
            $formArray['modify_method'] = "POST";
            $this->Automation_Model->updateDBS($id, $formArray);
            redirect(base_url('automation/db'));
        }
    }

    public function deleteDB() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('dbs_id', 'Database id', 'required');
        if ($this->form_validation->run() == false) {
            redirect(base_url('automation/db'));
        } else {
            $formArray = array();
            $id = $this->input->post('dbs_id');
            $currentDate = date('Y-m-d');
            $formArray['delete_date'] = $currentDate;
            $formArray['delete_user'] = $this->session->userdata('first_name');
            $formArray['delete_method'] = "POST";
            $this->Automation_Model->updateDBS($id, $formArray);
            redirect(base_url('automation/db'));
        }
    }

    public function versions() {
        $version_id = $this->Automation_Model->lastCreatedVersion();
        $data_id = array();
        $data_id['id'] = $version_id->id;
        $this->load->view('automation/version', $data_id);
    }

    public function allVersions() {
        $versions = $this->Automation_Model->allVersions();
        $data = array();
        $data['versions'] = $versions;
        $this->load->view('automation/version_list', $data);
    }

    public function createVersion() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('version_name', 'Version name', 'trim|required|xss_clean|is_unique[versions.version_name]');
        if ($this->form_validation->run() == false) {
            redirect(base_url('automation/versions'));
        } else {
            $formArray = array();
            $formArray['version_name'] = $this->input->post('version_name');
            $formArray['create_user'] = $this->session->userdata('first_name');
            $formArray['create_method'] = "POST";
            $this->Automation_Model->createVersions($formArray);
            redirect(base_url('automation/versions'));
            }
    }

    public function deleteVersion() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('v_id', 'Version id', 'required');
        if ($this->form_validation->run() == false) {
            redirect(base_url('automation/db'));
        } else {
            $formArray = array();
            $id = $this->input->post('v_id');
            $currentDate = date('Y-m-d');
            $formArray['delete_date'] = $currentDate;
            $formArray['delete_user'] = $this->session->userdata('first_name');
            $formArray['delete_method'] = "POST";
            $this->Automation_Model->deleteVersions($id, $formArray);
            redirect(base_url('automation/allVersions'));
        }
    }

    public function tickets() {
        $this->load->view('automation/ticket');
    }
    
    public function createTicket() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('name', 'Name', 'callback_name_check');

        if ($this->form_validation->run() == false)
        {
            print_r('Can not use such words');
        }
        else
        {
            echo '<pre>'; print_r($this->input->post());
            $this->create_ticket('',$this->input->post());
            print_r('Can use such word');
        }
    }

    public function name_check($str)
    {
        if ($str == 'test')
        {
            return FALSE;
        } else if ($str == 'db1')
        {
            return FALSE;
        } else if ($str == 'db2')
        {
            return FALSE;
        } else if ($str == 'db3')
        {
            return FALSE;
        } else if ($str == 'db4')
        {
            return FALSE;
        } else if ($str == 'carddb1')
        {
            return FALSE;
        } else if ($str == 'carddb2')
        {
            return FALSE;
        } else if ($str == 'qadb')
        {
            return FALSE;
        } else if ($str == 'validdb')
        {
            return FALSE;
        } else if ($str == 'db1ro')
        {
            return FALSE;
        } else if ($str == 'db2ro')
        {
            return FALSE;
        } else if ($str == 'db3ro')
        {
            return FALSE;
        } else if ($str == 'db4ro')
        {
            return FALSE;
        } else if ($str == 'carddb1ro')
        {
            return FALSE;
        } else if ($str == 'carddb2ro')
        {
            return FALSE;
        } else if ($str == 'qadbro')
        {
            return FALSE;
        } else if ($str == 'validdbro')
        {
            return FALSE;
        }
        else
        {
            return TRUE;
        }
    }

    public function get_OAuth(){
        //json_decode($resp)

        $url="https://accounts.zoho.in/oauth/v2/token?refresh_token=1000.8bf899b07b98b3e12bc3855d269d10b7.429ef6c1cfe6a4becb7ccd744ed9232f&client_id=1000.B9YL9IJTFDCOJXJ4VTNYSNVEYJNYJG&client_secret=7956ffb16a28f2bc5ad057c4e7c610aeac5d7f173f&scope=Desk.tickets.ALL,Desk.settings.READ,Desk.basic.READ,Desk.contacts.ALL&redirect_uri=https://zreyastechnology.com&grant_type=refresh_token";
        $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $resp2 = curl_exec($ch);
    curl_close($ch);
    echo'<pre>1';echo $resp2; //exit;
    $access_token=json_decode($resp2)->access_token;
    return $access_token;
    //$this->create_ticket($access_token);
    }

    public function create_contact($access_token,$post_data){
        //$access_token=$this->get_OAuth();
        

    $url = "https://desk.zoho.in/api/v1/contacts";
    
    
    $fields='{
  
        "lastName" : '.$post_data["last_name"].',
        
        
        "mobile" : '.$post_data["mobile"].',
        "description" : '.$post_data["ticket_details"].',
        
        
        "title" :'.$post_data["ticket_title"].',
        
        "firstName" : '.$post_data["first_name"].',
        
        
        "email" : '.$post_data["email"].'
      }';

      
    $headers = array(
    'orgId:60010811875',
     'Authorization:Zoho-oauthtoken '.$access_token
    );
    echo '<pre>'; print_r($headers);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    //curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
    $result = curl_exec($ch);
    curl_close($ch);

    echo'<pre>2';echo $result; //exit;
    return json_decode($result)->id;
    }

    public function create_ticket($access_token="",$post_data){
        $access_token=$this->get_OAuth();
        // if($access_token==''){
        //  $access_token='1000.95790243af250f56edd39a97515a2035.e96f7bf8d13c6f60bd39e3f2324f576e';
        // }
            $contact_id=$this->create_contact($access_token,$post_data);
             

    $url = "https://desk.zoho.in/api/v1/tickets";
    
    
    $fields='{
        "contactId" : "'.$contact_id.'",
        
        "subject" : '.$post_data["ticket_title"].',
        "dueDate" : "2016-06-21T16:16:16.000Z",
        "departmentId" : "52387000000010772",
        "channel" : "Email",
        "description" : '.$post_data["ticket_details"].',
        "language" : "English",
        "priority" : "High",
        "classification" : "",
        
        "phone" : '.$post_data["mobile"].',
        "category" : "general",
        "email" :  '.$post_data["email"].',
        "status" : "Open"
      }';

      
    $headers = array(
    'orgId:60010811875',
     'Authorization:Zoho-oauthtoken '.$access_token
    );
    echo '<pre>header'; print_r($headers);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    //curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
    $result = curl_exec($ch);
    curl_close($ch);

    echo'<pre>3';echo $result; exit;

    // if(json_decode($result)->errorCode=='INVALID_OAUTH'){
    //  $this->get_OAuth();

    // }
    }

}

  ?>