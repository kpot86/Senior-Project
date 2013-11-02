<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start();

require_once("application/libraries/OAuth2/Token.php");
require_once("application/libraries/OAuth2/Client.php");
require_once("application/libraries/OAuth2/DataStore.php");
require_once("application/libraries/OAuth2/HttpClient.php");
require_once("application/libraries/OAuth2/Exception.php");
require_once("application/libraries/OAuth2/Service/Configuration.php");
require_once("application/libraries/OAuth2/DataStore/Session.php");
require_once("application/libraries/OAuth2/Service.php");

class LoginController extends CI_Controller 
{
    

    public function __construct()
    {
        parent::__construct();

        $this->load->helper('form');
    }
   
    public function index()
    {
        $this->load->view('login_index');
    }

    public function fiu_oauth2()
    {         
         $client = new OAuth2\Client(
            '10019035853.apps.googleusercontent.com',
            'MWTrFtPTn3TxUOf8q9jqPpd5',
            'http://localhost/senior-projects/login/google_oauth2_callback'
        );

        $configuration = new OAuth2\Service\Configuration(
            'https://accounts.google.com/o/oauth2/auth',
            'https://accounts.google.com/o/oauth2/auth/token'
        );

        $dataStore = new OAuth2\DataStore\Session();

        $scope = "https://www.googleapis.com/auth/userinfo.profile https://www.googleapis.com/auth/userinfo.email";

        $service = new OAuth2\Service($client, $configuration, $dataStore, $scope, 'fiu.edu');

        $service->authorize();
    }

    public function google_oauth2()
    {          
      $client = new OAuth2\Client(
            '10019035853.apps.googleusercontent.com',
            'MWTrFtPTn3TxUOf8q9jqPpd5',
            'http://srprog-spr13-01.aul.fiu.edu/senior-projects/login/google_oauth2_callback'
        );

        $configuration = new OAuth2\Service\Configuration(
            'https://accounts.google.com/o/oauth2/auth',
            'https://accounts.google.com/o/oauth2/auth/token'
        );

        $dataStore = new OAuth2\DataStore\Session();

        $scope = "https://www.googleapis.com/auth/userinfo.profile https://www.googleapis.com/auth/userinfo.email";

        $service = new OAuth2\Service($client, $configuration, $dataStore, $scope);

        $service->authorize();
    }

    public function google_oauth2_callback()
    {
        $code = $this->input->get("code");
		
        $client = new OAuth2\Client(
            '10019035853.apps.googleusercontent.com',
            'MWTrFtPTn3TxUOf8q9jqPpd5',
            'http://localhost/senior-projects/login/google_oauth2_callback'
        );

        $configuration = new OAuth2\Service\Configuration(
            'https://accounts.google.com/o/oauth2/auth',
            'https://accounts.google.com/o/oauth2/token'
        );

        $dataStore = new OAuth2\DataStore\Session();

        $scope = "https://www.googleapis.com/auth/userinfo.profile https://www.googleapis.com/auth/userinfo.email";

        $service = new OAuth2\Service($client, $configuration, $dataStore, $scope);

        $service->getAccessToken($code);

        $token = $dataStore->retrieveAccessToken();

        $userinfo = $service->callApiEndpoint('https://www.googleapis.com/oauth2/v1/userinfo');

        /* Data format returned by Google
         * '{
             "id": "112343029738132982182",
             "email": "yaneli86@gmail.com",
             "verified_email": true,
             "name": "Yaneli Fernandez Sosa",
             "given_name": "Yaneli",
             "family_name": "Fernandez Sosa"
            }
        */

        $matches = array(); 

        preg_match_all("/\"id\": \"(\d+)\"/", $userinfo, $matches);

        $id = $matches[1][0]; 

        $matches = array(); 

        preg_match_all("/\"email\": \"([a-zA-Z0-9_.-]+@[a-zA-Z0-9-]+.[a-zA-Z0-9-.]+)\"/", $userinfo, $matches);

        $email = $matches[1][0]; 

        $matches = array(); 

        preg_match_all("/\"given_name\": \"([a-zA-Z\s]+)\"/", $userinfo, $matches);

        $given_name = $matches[1][0]; 

        $matches = array(); 

        preg_match_all("/\"family_name\": \"([a-zA-Z\s-]+)\"/", $userinfo, $matches);

        $family_name = $matches[1][0]; 

        $is_google_registered = true; 

        $this->load->model('spw_user_model');
        //call API
      
       $s_url =  $this->config->item('fiu_api_url') . $email;
       $jason_return =  file_get_contents( $s_url);
       $jason_return = json_decode($jason_return);

       $panther_user_info = (object)array(
                    'valid'                 => $jason_return->valid ,
                    'id'                    => $jason_return->id,
                    'email'                 => $jason_return->email,
                    'firstName'            => $jason_return->firstName,
                    'lastName'             => $jason_return->lastName,
                    'middle'                => $jason_return->middle                   	
                    
                );
       
       
       if (! $panther_user_info->valid)
       {
             $data['credentials_error'] = "Invalid Credentials";        
             $this->load->view('login_index',$data);  
             return ; 
       }
        $spw_id = $this->spw_user_model->is_google_registered($id);

        if($spw_id == 0){
                $spw_id  = $this->spw_user_model->create_new_google_user($email, $panther_user_info->firstName, $panther_user_info->lastName, $id , "SUDENT");
                $is_google_registered = false;
        }

        $sess_array = array(
                    'id' => $spw_id,
                    'google_id' => $id, 
                    'email' => $email, 
                    'using' => 'google'
                );

        $this->session->set_userdata('logged_in', $sess_array);

        if($is_google_registered){
            redirect('home','refresh');
        }else{
            redirect('user','refresh');
        }
    }       
}
