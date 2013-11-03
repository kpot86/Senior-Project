<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
session_start();

class AdminController extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('flash_message');
        $this->load->model('spw_user_model');
    }

    public function index() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('email_address', 'Email Address', 'required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
        $data = array();

        if ($this->form_validation->run() == true) {
            $data['credentials_error'] = "";
            $this->load->model('spw_user_model');
            $res = $this->spw_user_model->verify_user($this->input->post('email_address'), $this->input->post('password'));


            if ($res !== false) {
                $role = 'STUDENT';

                foreach ($res as $row) {
                    $role = $row->role;                    
                }

                if ($role == 'STUDENT') {
                    //verify againgst API

                    $s_url = $this->config->item('fiu_api_url') . $this->input->post('email_address');
                    $jason_return = file_get_contents($s_url);
                    $jason_return = json_decode($jason_return);

                    $panther_user_info = (object) array(
                                'valid' => $jason_return->valid,
                                'id' => $jason_return->id,
                                'email' => $jason_return->email,
                                'firstName' => $jason_return->firstName,
                                'lastName' => $jason_return->lastName,
                                'middle' => $jason_return->middle
                    );
                    if (!$panther_user_info->valid) {
                        $data['credentials_error'] = "Invalid Credentials";
                    } else {
                        //
                        foreach ($res as $row) {

                            $sess_array = array(
                                'id' => $row->id,
                                'email' => $row->email,
                                'using' => 'fiu_senior_project',
                                'role' => $row->role
                            );
                            $this->session->set_userdata('logged_in', $sess_array);
                        }
                        redirect('home', 'refresh');
                    }
                } 
                else
                {
                    //
                        foreach ($res as $row) {

                            $sess_array = array(
                                'id' => $row->id,
                                'email' => $row->email,
                                'using' => 'fiu_senior_project',
                                'role' => $row->role
                            );
                            $this->session->set_userdata('logged_in', $sess_array);
                        }
                        redirect('home', 'refresh');
                }              
               
            }
            else
            {     $data['credentials_error'] = "Invalid Credentials"; }
            
        }
        $this->load->view('login_index', $data);
    }

    public function admin_dashboard() {
        $this->load->view('admin_dashboard');
    }

    public function register_professor() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('email_address', 'Email Address', 'required|valid_email');
        $this->form_validation->set_rules('password_1', 'Password', 'required|min_length[6]');
        $this->form_validation->set_rules('password_2', 'Password', 'required|min_length[6]');
        $data = array();

        if ($this->form_validation->run() !== false) {
            $this->load->model('spw_user_model');

            $res = $this->spw_user_model->is_spw_registered($this->input->post('email_address'));
            if ($res == false) {
                $this->spw_user_model->create_new_professor_user($this->input->post('email_address'), $this->input->post('password_1'));
                $msg = 'Successfully created a new professor user with the email: ' . $this->input->post('email_address');
                setFlashMessage($this, $msg);
                /*
                  $sess_array = array(
                  'id' => $new_user_id,
                  'email' => $this->input->post('email_address'),
                  'using' => 'fiu_senior_project',
                  );
                  $this->session->set_userdata('logged_in', $sess_array);

                  redirect('user','refresh'); */
            } else {
                $msg = 'ERROR: Cannot create a professor with the email: ' . $this->input->post('email_address') . ' 
                    <br>User with this email already exists';
                setFlashMessage($this, $msg);
                $data['already_registered'] = true;
            }
        }
        redirect('admin/admin_dashboard');
    }

    //need a fucntion that will retrieve all the users that are currently in the system
    public function activate_deactive_users() {
        
        $updates = 0;
        if ($this->input->post('action') === 'Deactivate') {
            if (is_array($this->input->post('users'))) {
                //retrieve all the ids from the array
                foreach ($this->input->post('users') as $key => $value) {
                    $this->spw_user_model->change_status_to_inactive($value);
                    $updates++;
                }
                
                $msg = 'Successfully deactivated ' . $updates . ' user(s)'; 
                setFlashMessage($this, $msg);
            }
        } else if ($this->input->post('action') === 'Activate') {
            if (is_array($this->input->post('users'))) {
                //retrieve all the ids from the array
                foreach ($this->input->post('users') as $key => $value) {
                    $this->spw_user_model->change_status_to_active($value);
                    $updates++;
                }
                
                $msg = 'Successfully activated ' . $updates . ' user(s)'; 
                setFlashMessage($this, $msg);
            }
        }

        redirect('admin/admin_dashboard');
    }

}