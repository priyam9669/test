<?php
class Login extends CI_Model{
    
    public function __construct(){
        parent::__construct();
    }
    
    public function login($data, $formArray){
        $username =  trim($data['username']);
        $password =  trim($data['password']);
        if (!strlen($password) || !strlen($username)) throw new Exception('Invalid username/password');
        $this->db->where('username', $data['username']);
        $this->db->update("login", $formArray);
        $this->db->select('id, first_name, last_name, email, otp, password')->from('login')->where('username', $data['username']);
        if (!$query = $this->db->get()) throw new Exception('System error');
        if (!$query->num_rows()) throw new Exception('Invalid username');
        $row = $query->first_row();
        //if ($row->password != crypt($data['password'], $row->password))  throw new Exception('Invalid password');
        if ($row->password !== $data['password'])  throw new Exception('Invalid password');
        
        unset ($row->password);
        return $row;
    }
}