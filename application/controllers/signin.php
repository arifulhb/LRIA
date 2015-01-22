<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Signin extends CI_Controller {

    public function __construct()
    {
            parent::__construct();
            $this->load->library('template');

    }//end constractor

    public function index()
    {
      
        $data=  site_data();
        $data['_page_title']='Signin';

        $this->template->user_login($data);

    }//end index
    
     public function validation(){
        
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('signinEmail', 'User Email', 'trim|required|xss_clean|valid_email');
        $this->form_validation->set_rules('signinPassword', 'Password', 'trim|required|xss_clean');
                
        if($this->form_validation->run()==TRUE){

            $data['user_email']=$this->input->post('signinEmail');
            $data['user_password']=$this->input->post('signinPassword');
            
            $this->load->model('user_model');            
            $user=$this->user_model->signin($data);
            
             if(count($user)==1){

//                 TODO $login_type Argument of getPartner: 0 = dev/test; 1=live;
                 $partner= $this->user_model->getPartner(0);


//                 var_dump($partner[0]);

//                 exit();
                 $params= Array( 'url'      => $partner[0]['json_url'],
                                 'email'    => $partner[0]['partner_email'],
                                 'password' => $partner[0]['partner_password'],
                                 'appid'    => $partner[0]['app_id']
                 );

//                 print_r("Params");
//                 print_r($partner);

                 $this->load->library('LightspeedClient',array($params));


                 $api_token          = $this->lightspeedclient->getApiToken();
//                 $client_token       = $this->lightspeedclient->generateClientToken();
                 $client_token      ='';

//                 $this->lightspeedclient->setCompanyId( $partner[0]['company_id']);
//                 echo 'API TOKEN: '.PHP_EOL;
//                 var_dump($api_token);

//                 $slots = $this->lightspeedclient->getCustomers();
////
//                 echo 'getCustomers: '.PHP_EOL;
//                 var_dump($slots);
//                 exit();

                //pass                                 
                    $user_ses = array(
                            'u_sn'           => $user[0]['user_sn'],
                            'u_email'        => $user[0]['user_email'],
                            'u_first_name'   => $user[0]['user_name'],
                            'u_status'       => $user[0]['user_status'],   //1 is dash 2 is merchant
                            'client_token'   => $client_token,
                            'api_token'      => $api_token,
                            'company_id'      => $partner[0]['company_id'],
                            'is_logged_in'   => true
                    );

//                 print_r($user_ses);
//                 exit();


                 $this->session->set_userdata($user_ses);


                    redirect('dashboard');
            
            }else{
                //Signin Auth fail
                //echo 'signin auth fail';                
                $this->session->set_flashdata('signinEmail', $data['signinEmail']);
                $this->session->set_flashdata('notice', 'User or Password does not match!' );
                redirect ('signin');
            }
                                    
            
        }//end run validation
        else{
            //if validatin fail
            echo 'do what to do in validation fail<br>';

        }//end if validation fail
                                                      
        
    }//end function
    
 
    
}//end class
?>