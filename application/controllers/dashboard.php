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
class Dashboard extends BASE_Controller {
    

    /**
     * __construct
     *
     * @return void
     * @access public
     **/
    public function __construct(){
        parent::__construct();
        $this->load->model('Automation_Model');
        
        $data['title'] = 'Welcome to Atrium';
        $css = array('dashboard.css');
        $data['css'] = array_merge($this->css, $css);
        $js = array('dashboard.js');
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
        //print_r($this->session);
        $employee = $this->Automation_Model->getOneEmployee($this->session->userdata('id'));
        $parssedData = unserialize($employee->team);
        if (in_array('Engineering', $parssedData, true)) {
            $data['is_engineer']=1;
            $this->load->view('dashboard', $data);
        } else {
            $data['is_engineer']=0;
            $this->load->view('dashboard', $data);
        }
    }
    // public function index() {
    //     $listing = preg_grep('/^([^.])/', scandir('/var/www'));
	//     $listing = preg_grep('/^(?!.*test).*$/', $listing);
    //     $directories = array();
    //     $release = array();
    //     $this->load->config('exclude');
    //     $this->load->config('urls');
    //     $excluded_dirs = $this->config->item('directories');
    //     $urls = $this->config->item('url');
    //     //$this->testPrint($excluded_dirs, $listing);
        
    //     foreach ($listing as $directory){
    //         if (is_dir('/srv/www/'. $directory) && !in_array($directory, $excluded_dirs)) $directories[] = $directory;
    //     }
    //     //$directories =  array('atriumu', 'testu', 'uga');
	// //$this->testPrint($directories);
    //     $connection_data = array();
    //     $version = array();
    //     $connection_keys = array();
    //     $key_set = false;
    //     $connection_list = array(0=>'all connections');
    //     foreach ($directories as $directory){
    //         if (!file_exists ('/srv/www/'.$directory. '/api/application/config/database.php')) continue;
    //         include ('/srv/www/'.$directory. '/api/application/config/database.php');
    //         $version[$directory] = str_ireplace('web_', '',  basename(readlink('/srv/www/'.$directory. '/web')));
    //         $release[$directory] = date("Y-m-d H:i", filemtime('/srv/www/'.$directory. '/web'));

    //         $db_name = $directory. '_db';
    //         $this->$db_name = $this->load->database($db['core'], true);
    //         $this->$db_name->select("i.id, i.name,  t.title as connection_type, i.enabled, i.uses_readers, te.name as default_tender, r.description as default_reader, i.security_key, 'N/A' AS url, i.delete_date", false)
    //                         ->from('integrations i')
    //                         //->where('i.delete_date IS NULL')
    //                         ->join('connection_types t', 'i.type = t.id', 'left')
    //                         ->join('readers r', 'i.default_reader = r.id', 'left')
    //                         ->join('tenders te', 'i.default_tender = te.id', 'left')
    //                         ->order_by('i.name');
    //         if (!$query = $this->$db_name->get()) {
    //             //print_r ($this->$db_name->last_query());
    //             //print_r ($this->$db_name->last_error());
    //             //var_dump($db['core']);
    //             //print_r ($db_name);
    //             continue; // skip
    //         }
            
    //         $connection_data[$directory] =  array();
            
    //         foreach ($query->result() as $data){
    //             $id = $data->id;
    //             $delete_date = $data->delete_date;
    //             $connection_list[$id] = $data->name;
    //             if(isset($urls[$id])){
    //                 if(is_array($urls[$id])){
    //                     $data->url = '';
    //                     foreach ($urls[$id] as $url){
    //                         $data->url .= 'https://api'.$directory. '.atriumcampus.com/integrations/'. $url. '<br/>';
    //                     }
    //                     trim($data->url, '<br/>');
    //                 }
    //                 else{
    //                     $data->url = 'https://api'.$directory. '.atriumcampus.com/integrations/' .$urls[$id];
                        
    //                 }
    //             }
    //             unset($data->delete_date);
    //             if (!$delete_date)  $connection_data[$directory][] = $data;
    //             if(!$key_set) $connection_keys = array_keys((array) $data);
    //         }
    //         //$this->testPrint($connection_data[$directory], $connection_keys);
    //     }
    //     $data = array(
    //         'connection_data' => $connection_data,
    //         'connection_keys' => $connection_keys,
    //         'connection_list' => $connection_list,
    //         'version'         => $version,
    //         'release'         => $release,
    //     );
    //     //$this->testPrint($connection_list);
    //     //exit;
    //     $this->load->vars($data);
    //     $this->load->view('dashboard');
    //     //exit;
    // }
    
    // public function show_readers($instance, $conn_id){
        
    //     try{
    //         // this is for safety
    //         $listing = preg_grep('/^([^.])/', scandir('/srv/www'));
    //         $this->load->config('exclude');
    //         $this->load->config('urls');
    //         $excluded_dirs = $this->config->item('directories');
    //         $validated =  false;
    //         foreach ($listing as $directory){
    //             if (!file_exists ('/srv/www/'.$directory. '/api/application/config/database.php')) continue;
    //             if (is_dir('/srv/www/'. $directory) && !in_array($directory, $excluded_dirs) && $directory == $instance) {
    //                 $validated = true;
    //                 break;
    //             }
    //         }
    //         if (!$validated) throw new Exception('This is not allowed');
    //         if (!ctype_digit($conn_id)) throw new Exception('This is not allowed');
    //         include ('/srv/www/'.$instance. '/api/application/config/database.php');
    //         $db_name = $instance. '_db';
    //         $this->$db_name = $this->load->database($db['core'], true);
    //         $this->$db_name->select("r.description,  r.integration_label as terminal_id, l.description as location, c.description as campus, i.name as connection", false)
    //                         ->from('readers r')
    //                         ->where('r.delete_date IS NULL')
    //                         ->where("r.system_id = $conn_id")
    //                         ->join('integrations i', 'r.system_id = i.id', 'left')
    //                         ->join('locations l', 'r.location_id = l.id', 'left')
    //                         ->join('campuses  c', 'l.campus_id = c.id', 'left')
    //                         ->order_by('r.description');
    //         if (!$query = $this->$db_name->get()) throw new Exception("Information not available right now");
    //         if (!$query->num_rows()) throw new Exception("No reader is currently setup");
    //         $data['reader_data'] = $query->result_array();
    //         $data['reader_keys'] = array_keys((array)$query->first_row());
    //         //$this->testPrint($data);
    //         $response = $this->load->view("show_readers", $data, true);
    //         //echo "$instance, $conn_id";
    //     }
    //     catch(Exception $e){
    //         $response = $e->getMessage();
    //     }
    //     echo $response;
    // }
}
