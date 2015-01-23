<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller {

    
    public function __construct()
    {
        parent::__construct();
//        if(($this->session->userdata('is_logged_in')==TRUE))
//        {
//            $this->load->library('template');
//        }else{
//            redirect('signin');
//        }            
        
        $this->load->library('template');
        no_cache();

    }//end constractor
    
    public function index()
    {
        if($this->session->userdata('is_logged_in')==TRUE){
            
            if($this->session->userdata('user_type')==2){
                redirect('dash');
            }
        $data=  site_data();

        $data['_menu_top']='user';
        $data['_menu_active']='user_list';

      //set pagination configuration

        //Load pagination library
        $this->load->library('pagination');

        $config=  getPaginationConfig();//this function is from helpers/ahb_helper.php file
        $config['base_url'] = base_url().'user/index';
        $this->load->model('user_model');    

        $config['total_rows'] = $this->user_model->getTotalNum();        
        $config['use_page_numbers']=true;
        $config['per_page'] = 20;
        $config['num_links'] = 5;        
        $config['uri_segment'] = 3;                        
        $this->pagination->initialize($config);

        
        $data['_total_rows']=$config['total_rows'];

        if($this->uri->segment(3)!=''){
            
            $last=$this->uri->segment(3)*$config['per_page']>$config['total_rows']?$config['total_rows']:$this->uri->segment(3)*$config['per_page'];

            $data['_pagi_msg']=  (($this->uri->segment(3)-1)*($config['per_page']+1)).' - '.$last;            
            
            $data['_list']=$this->user_model->getList($config['per_page'],($config['per_page']*($this->uri->segment(3)-1)));
        }else{                
            if($config['total_rows']>$config['per_page']){                    
                $last=$config['per_page'];      
            }else{                    
                $last=$config['total_rows'];      
            }

          $data['_pagi_msg'] = '1 - '.$last;              

          $data['_list']=$this->user_model->getList($config['per_page'],$this->uri->segment(3));
        }
        
        $data['_page_title']='User';
        $this->template->user_index($data);                        
        
        
        }else{
            //user not logged in
            //redirect to signin
            redirect('signin');
            
        }//end else
        
    }//end index
    
    public function add(){
        
        if($this->session->userdata('is_logged_in')==TRUE){
        
        $data=  site_data();
        $data['_page_title']='Add User';
        $data['_menu_top']  ='user';
        $data['_menu_active']  ='user_add';
//        $this->load->model('outlet_model');
//        $data['_outlets']=$this->outlet_model->getAllRecords();
        
        $this->load->model('user_model');        
//        $data['_roles']=$this->user_model->getAllRoles();
        $data['_action']='add';
        $this->template->user_add($data);                        
        
        }else{
            //user not logged in
            //redirect to signin
            redirect('signin');
            
        }//end else
        
    }//end function
    
    public function save(){
        
        if($this->session->userdata('is_logged_in')==TRUE){
        
        $this->load->library('form_validation');
        $_action=$this->input->post('_action');
        
        if($_action=='add'){
//            $this->form_validation->set_rules('inputUserEmail', 'User Email', 'trim|required|max_length[250]|xss_clean|valid_email|is_unique[tblusers.user_email]');
            $this->form_validation->set_rules('inputUsername', 'Username', 'trim|required|max_length[10]|xss_clean|is_unique[tblusers.username]');
            $data['username']     = $this->input->post('inputUsername');
        }
        $this->form_validation->set_rules('inputUserName', 'Name', 'trim|required|max_length[250]|xss_clean');
        $this->form_validation->set_rules('inputUserEmail', 'User Email', 'trim|max_length[50]|xss_clean|valid_email');


        $data['user_name']      = $this->input->post('inputUserName');
        $data['user_email']    = $this->input->post('inputUserEmail');
        $data['user_status']    = 1;

        if ($this->form_validation->run() == true)
        {                         
            $res=false;
            $this->load->model('user_model');

            if($_action=='add'){
                //add only when add new data
                $data['user_password']      = md5($this->input->post('inputUsername'));

                
                $res= $this->user_model->insert($data);    
                if($res['status']==TRUE){
                    redirect('user/index/');
//                    redirect('user/index/'.$res['new_id']);
                }else{
                    //show error message
                }
            }else{
                $id=$this->input->post('_sn');
                $res=$this->user_model->update($data,$id);                   
                if($res==TRUE){
                    redirect('user/all/');
                }else{
                    //show error message
                }
            }//end else
            
            //RETURN THE RESULT            
            //return $res;
            
        }//end if
        else{
            
            //echo validation_errors();
            //exit();
             $data=  site_data();
             
            //echo 'error: '.  validation_errors();
            $data['_error']=  validation_errors();
            $data['_record'][0]['user_name']=$this->input->post('inputUserName');
            //$data['_record'][0]['ol_sn']=$this->input->post('inputOutlet');
            //$data['_record'][0]['user_pin']=$this->input->post('inputOutletPin');
            $data['_record'][0]['user_type']=$this->input->post('inputUserRole');
            $data['_record'][0]['user_email'] = $this->input->post('inputUserEmail');
            //$data['_record'][0]['user_sn'] = $this->input->post('user_sn');
            
            $_action=$this->input->post('_action');                       
            
            if($_action=='add'){                
                $data['_page_title']='Add User';
                $data['_action']='add';                                                                
                
                $this->template->user_add($data);  
            }else{
                
                $data['_sn']=$this->input->post('_sn');
                
                $data['_page_title']='Update User';
                $data['_action']='update';                                
                $data['_country']=  getCountry();
                $this->template->user_edit($data);  
            }
            
        }//end else    
        
        }else{
            //user not logged in
            //redirect to signin
            redirect('signin');
            
        }//end else
        
    }//end function
    
    public function ajax_delete(){
        
        if($this->session->userdata('is_logged_in')==TRUE){
       
            $data['_sn']=$this->input->post('user_id');
            $this->load->model('user_model');
            $res= $this->user_model->delete($data['_sn']);

            if($res==true){
                echo json_encode(Array("status"=>true));
            }
            else{
                $error = Array("status"=>false,"error"=>"Database Operation Failed!","errorType"=>"LIRA Database Error");
                echo json_encode($error);
            }
        }else{
            //user not logged in
            //redirect to signin
//            redirect('signin');
            $error = Array("status"=>false,"error"=>"User not logged in","errorType"=>"LIRA App Error");
            echo json_encode($error);
        }//end else
        
    }//end function
    
    public function details(){
        
        if($this->session->userdata('is_logged_in')==TRUE){
        $data=  site_data();
        $data['_page_title']='User Profile';
        $data['_menu_top'] = 'user';
        
        $this->load->model('user_model');
        $id=$this->uri->segment(3);
        $data['_record']=$this->user_model->getRecord($id);
        
        $this->template->user_profile($data);  
        
        
        }else{
            //user not logged in
            //redirect to signin
            redirect('signin');
            
        }//end else
        
    }//end function
        
    public function edit(){
        if($this->session->userdata('is_logged_in')==TRUE){
            
            $data=  site_data();
            $data['_page_title']='User Edit';
            $data['_menu_top']  = 'user';

            $this->load->model('user_model');
            $data['_sn']=$this->uri->segment(3);
            $data['_record']=$this->user_model->getRecord($data['_sn']);
            $data['_action']='update';

            //$this->load->model('outlet_model');        
            //$data['_outlets']=$this->outlet_model->getAllRecords();

            //$this->load->model('user_model');        
            //$data['_roles']=$this->user_model->getAllRoles();

            $this->template->user_edit($data);  
        
        
        }else{
            //user not logged in
            //redirect to signin
            redirect('signin');
            
        }//end else
    }//end function
    
    public function signout()
    {        
        //$this->cache->clean();
        
        delete_cookie('posios2xero_pos_api_partner_email'); 
        delete_cookie('posios2xero_pos_api_partner_pass'); 
        delete_cookie('posios2xero_pos_api_partner_appid'); 
        delete_cookie('posios2xero_pos_api_token'); 
        
        
        $this->session->sess_destroy();
        $this->session->set_userdata(array('is_logged_in'=>'','user_name'=>''));
        redirect('dashboard');
        
    }//end function


    public function cpvalidation(){
    
        if($this->session->userdata('is_logged_in')==TRUE){
            
            
            $this->load->library('form_validation');
            
            $this->form_validation->set_rules('newPassword', 'Password',      'trim|max_length[12]|matches[confirmPassword]|xss_clean');
            $this->form_validation->set_rules('confirmPassword', 'Confirm Password', 'trim|required|max_length[12]|xss_clean');
            $this->form_validation->set_rules('user_sn', 'User SN', 'trim|required|max_length[12]|xss_clean');

            if ($this->form_validation->run() == true)
            {             
                $this->load->model('user_model');
                $data['user_password'] =md5($this->input->post('newPassword'));
                
                $res=$this->user_model->changepassword($data,$this->session->userdata('u_sn'));
                
                if($res==TRUE){

//                    $this->session->set_flashdata('cp',true);

                    echo json_encode(Array('status'=>true));

//                    redirect('user/all');
                }else{
                    echo json_encode(Array('status'=>false,'error'=>'Database Error!'));
                }
                
            }else{
                //PASSWORD DOESNT MATCH, RETURN ERROR
                //echo validation_errors();
//                $this->session->set_flashdata('cp',true);
//                $this->session->set_flashdata('_error',  validation_errors());
//                redirect('user/changepassword');
                $errors = validation_errors();

                echo json_encode(Array('status'=>false, 'error'=>$errors));


            }//end else
            
        }else{
            redirect('signin');
        }
        
        
        
    }//end function

}//end class
