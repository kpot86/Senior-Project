<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( !function_exists('getCurrentUserHeaderName'))
{
    function getCurrentUserHeaderName($sender_controller)
    {
        if (is_test($sender_controller))
        {
            return 'Camilo';
        }
        else
        {
            $CI = get_instance();

            $CI->load->model('spw_user_model');

            $session_data = $sender_controller->session->userdata('logged_in');
            $user_id = $session_data['id'];
            return $CI->spw_user_model->get_first_name($user_id);
        }
    }
}

if ( !function_exists('getCurrentUserHeaderImg'))
{
    function getCurrentUserHeaderImg($sender_controller)
    {
        if (is_test($sender_controller))
        {
            return 'https://si0.twimg.com/profile_images/635660229/camilin87_bigger.jpg';
        }
        else
        {
            $CI = get_instance();

            $CI->load->model('spw_user_model');

            $session_data = $sender_controller->session->userdata('logged_in');
            $user_id = $session_data['id'];
            return $CI->spw_user_model->get_picture($user_id);
        }
    }
}

if ( !function_exists('getCurrentUserHeaderFullName'))
{
    function getCurrentUserHeaderFullName($sender_controller)
    {
        if (is_test($sender_controller))
        {
            return 'Camilo Sanchez';
        }
        else
        {
            $CI = get_instance();

            $CI->load->model('spw_user_model');

            $session_data = $sender_controller->session->userdata('logged_in');
            $user_id = $session_data['id'];
            return $CI->spw_user_model->get_fullname($user_id);
        }
    }
}

if ( !function_exists('isHeadProfessor'))
{
    function isHeadProfessor($sender_controller)
    {
        if (is_test($sender_controller))
        {
            return true;
        }
        else
        {
            $CI = get_instance();
            //load the current user model
            $CI->load->model('spw_user_model');

            $session_data = $sender_controller->session->userdata('logged_in');
            $user_id = $session_data['id'];
            //call the function that determines if the current user is the head professor
            return $CI->spw_user_model->is_head_professor($user_id);
        }
    }
}

?>
