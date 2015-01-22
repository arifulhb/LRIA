<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    
    public function __construct()
    {
           parent::__construct();                        
           
           if(($this->session->userdata('is_logged_in')==TRUE) )
            {
                $this->load->library('template');
            }else{
                redirect('signin');
            } 
            
            no_cache();            

    }//end constractor
    
    public function index()
    {
                
        if($this->session->userdata('is_logged_in')==TRUE){
            $data=  site_data();

            $data['_page_title']='Dashboard';
            $data['_menu_top']  ='dash';


            if($this->session->userdata('u_status')==1){
//                ADMIN

                $this->template->dash_home($data);
                
            }else if($this->session->userdata('u_status')==0){
//              Profile Inactive
                echo "Profiel Inactive";
//                $this->template->admin_user_home($data);
            }
                      
        }else{

            //user not logged in
            //redirect to signin
            redirect('signin');
            
        }//end else
        
    }//end index
        
}//end class

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */