<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Sessions - Create/Destroy user sessions
 *
 * @version 1.0
 * @package Controllers
 * @category BASE
 * @subpackage Core
 * @uses BASE_Controller
 * @author Andre Dublin <andre@rocketpopmedia.com>
 **/
class Sessions extends BASE_Controller {
    

    /**
     * __construct
     *
     * @return void
     * @access public
     **/
    public function __construct(){
        parent::__construct();
        
        $data['title'] = 'Welcome to Atrium';
        $css = array('sessions.css');
        $data['css'] = array_merge($this->css, $css);
        $js = array('sessions.js');
        $data['js'] = array_merge($this->js, $js);
        $this->load->vars($data);
        //exit;
    }

    // --------------------------------------------------------------------

    /**
     * index - shows the login form
     *
     * @return void
     * @access public
     **/
    public function index() {
        if ($this->session->userdata('id')) {
            //var_dump($this->session->userdata('id'));
            redirect(base_url('dashboard'));
            exit;
        }
        if ($_POST) {
            $this->action = 'login';
            $post = $this->input->post(NULL, TRUE);
            $this->_login($post);
        }
        else{
            // display login form
            $this->load->view('login');
        }
    }
    

    
    /**
     * logout - destroys the session
     *
     * @return void
     * @access public
     **/
    public function logout(){
        $this->session->sess_destroy();
        redirect(base_url());
    }


    /**
     * _login - creates a new session
     *
     * @return void
     * @access private
     * @param  array $post
     **/
    private function _login($post) {
        try{
            $this->load->model('login');
            $rndno=rand(100000, 999999);
            $formArray = array();      
            $formArray['otp'] = $rndno;
            $userdata = $this->login->login($post, $formArray);
            $this->session->set_userdata($userdata);
            redirect(base_url('automation/verifyOtp'));
            exit;
        }
        catch (Exception $e){
            $data['login_error'] = $e->getMessage();
            $this->load->vars($data);
            $this->load->view('login');
        }
    }
}
/* END class Sessions extends BASE_Controller */
/* Location: ./application/controllers/sessions.php */
