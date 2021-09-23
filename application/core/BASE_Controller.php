<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * BASE_Controller - Handles the requests to the core
 *
 * @version 1.0
 * @package Controllers
 * @subpackage BASE
 * @uses CI_Controller
 * @author Andre Dublin <andre@rocketpopmedia.com>
 **/
class BASE_Controller extends CI_Controller {

    protected $css = array();
    protected $js = array();
	/**
	 * __construct - loads the api config vars, sets and gets the user session
	 *
	 * @return void
	 * @access public
	 **/
	public function __construct() {
		parent::__construct();
        $this->class  = $this->router->class;
        $this->load->library('session');
        $this->css = array(
			'ui_theme.css',
			'application.css');
        $this->js = array(
                            'libs/jquery-1.7.2.min.js',
                            'libs/jquery-ui-1.8.18.min.js',
                            'libs/json.min.js',
                            'plugins/jquery.dataTables.min.js',
                            'plugins/jquery.fastLiveFilter.js',
                            'application.js');
        //var_dump($this->session->userdata());
        //exit;
        if (!$this->session->userdata('id') && $this->class != 'sessions') {
            redirect('/sessions');
            exit;
        }
        else if( $this->session->userdata('id')){
            $data['user_id'] =  $this->session->userdata('id');
            $data['first_name'] =  $this->session->userdata('first_name');
            $data['last_name'] =  $this->session->userdata('last_name');
            $this->load->vars($data);
        }
        
    }
    
    /**
     *
     *
     *
     */
    protected function testPrint(){
        
        foreach (func_get_args() as $arg) {
            echo "<pre>";
            print_r($arg);
            echo "</pre>";
        }
        
        exit;
    }

}