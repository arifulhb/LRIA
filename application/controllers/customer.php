<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Customer extends CI_Controller {
    
    public function __construct()
    {
            parent::__construct();
            
            if(($this->session->userdata('is_logged_in')==TRUE) ||
                ($this->session->userdata('is_front_logged_in')==TRUE))
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

            
          //Load pagination library
            $this->load->library('pagination');

            //set pagination configuration
            $config=  getPaginationConfig();//this function is from helpers/ahb_helper.php file
            $config['base_url'] = base_url().'customer/index';
            $this->load->model('customer_model');    

            $config['total_rows'] = $this->customer_model->getTotalNum();        
            $config['use_page_numbers']=true;
            $config['per_page'] = 20;
            $config['num_links'] = 5;        
            $config['uri_segment'] = 3;                        
            $this->pagination->initialize($config);


            $data['_total_rows']=$config['total_rows'];

            if($this->uri->segment(3)!=''){

                $last=$this->uri->segment(3)*$config['per_page']>$config['total_rows']?$config['total_rows']:$this->uri->segment(3)*$config['per_page'];

                $data['_pagi_msg']=  (($this->uri->segment(3)-1)*($config['per_page']+1)).' - '.$last;            

                $data['_list']=$this->customer_model->getList($config['per_page'],($config['per_page']*($this->uri->segment(3)-1)));
            }else{                
                if($config['total_rows']>$config['per_page']){                    
                    $last=$config['per_page'];      
                }else{                    
                    $last=$config['total_rows'];      
                }

              $data['_pagi_msg'] = '1 - '.$last;              

              $data['_list']=$this->customer_model->getList($config['per_page'],$this->uri->segment(3));
            }
            
            $data['_page_title']='Customer List';
            $data['_menu_top']  ='customer';
            $data['_menu_active']  ='customer_all';
            $this->template->customer_index($data);                
        
        }else{
            //user not logged in
            //redirect to signin
            redirect('signin');
            
        }//end else
        
    }//end index
    
    public function ajax_search($keyword){
        
        if($this->session->userdata('is_logged_in')==TRUE){
            
//            $keyword    = $this->input->get('s');
//            $search_by  = $this->input->get('by');
            

            $this->load->model('customer_model');    


//              $data['_pagi_msg'] = '1 - '.$last;

              //$data['_list']=$this->customer_model->getList($config['per_page'],$this->uri->segment(3));

                $data['_list']= $this->customer_model->getAjaxSearchResult($keyword);

//                $result = Array("result"=>true,"data"=>$data['_list']);

                echo json_encode($data['_list']);
            
//           $data['_page_title']='Search Result';
//           $this->template->customer_index($data);
              
        }else{            
//            redirect('signin');
            $error = Array("result"=>false, "error"=>"Not Signed In");
            echo json_encode($error);

        }//end else
    }//end function
    
    public function add(){
        
        if($this->session->userdata('is_logged_in')==TRUE){
            $data=  site_data();
            $data['_page_title']='Add New Customer';
            $data['_action']='add';            

            $this->template->customer_add($data);                        
        
        }else{
            //user not logged in
            //redirect to signin
            redirect('signin');
            
        }//end else
        
    }//end function


    public function sync_form(){

        if($this->session->userdata('is_logged_in')==TRUE){

            $data=  site_data();

            $data['_page_title']='Customer Sync';
            $data['_menu_top']  ='customer';
            $data['_menu_active']  ='customer_sync';
            $this->template->customer_sync($data);

        }else{
            //user not logged in
            //redirect to signin
            redirect('signin');

        }//end else


    }//end function

    /*
    public function test(){
        $this->load->library('LightspeedClient');
        $this->lightspeedclient->setApiToken($this->session->userdata['api_token']);
        $this->lightspeedclient->setCompanyId($this->session->userdata['company_id']);
        $this->lightspeedclient->setServerUrl($this->session->userdata['api_endpoint']);

        $response = $this->lightspeedclient->getCustomers(0, 100);
//        $response = $this->lightspeedclient->getVersion();
//        $response = $this->lightspeedclient->getVersion();

        var_dump($response);

        exit();
    } */

    public function sync(){
        if($this->session->userdata('is_logged_in')==TRUE){

            $new_customers = Array();

            $this->load->model('customer_model');
            $client_result = $this->customer_model->getClientIds();

            $client_ids = ah_array_column($client_result,"client_id");


            $this->load->library('LightspeedClient');
            $this->lightspeedclient->setApiToken($this->session->userdata['api_token']);
            $this->lightspeedclient->setCompanyId($this->session->userdata['company_id']);
            $this->lightspeedclient->setServerUrl($this->session->userdata['api_endpoint']);

            $continue_sync  = true;
            $cust_index     = 0;
            $cust_amount    = 100;


            while($continue_sync== true) {

                $response = $this->lightspeedclient->getCustomers($cust_index, $cust_amount);

                $result = $response->result;

//                echo json_encode(Array("status"=>true, "response"=>$response,"index"=>$cust_index,"amount"=>$cust_amount
//                ,"company_id"=>$this->session->userdata['company_id'],"token"=>$this->session->userdata['api_token']));
//                $continue_sync=false;
//                exit();

                if(count($response->result)>0){


                    foreach($result as $customer){

                        if(strlen($customer->clientId) >1){

//                            $client_id =14309; //for test

                            if(in_array($customer->clientId,$client_ids)== false){
//                                Add New

                                $ar = Array();
                                $ar['cust_oid']             = $customer->clientId;
                                $ar['cust_firstname']       = $customer->firstname;
                                $ar['cust_lastname']        = $customer->lastname;
                                $ar['cust_email']           = $customer->email;
                                $ar['cust_phone_no']        = $customer->telephone;
                                $ar['cust_username']        = $customer->username;
                                $ar['cust_password']        = $customer->password;
                                $ar['cust_note']            = "Added by sync process.";

                                $ar['create_by']            = $this->session->userdata('u_sn');
                                $date = new DateTime();
                                $ar['create_date']          = $date->format("Y-m-d H:i:s");

                                array_push($new_customers,$ar);

                            }//end else


                        }//end if strlen($customer->clientId) >1

                    }//end for

//                    Continue the loop
                    $cust_index += $cust_amount;
                    $continue_sync = true;
                }
                else{
//                    Breakt the loop
                      $continue_sync = false;
                }


            }//end while


            if(is_null($new_customers)==false){

                if(count($new_customers)>0){
//                  Add New Customer in Batch to database
                        $batch_result = $this->customer_model->insert_batch($new_customers);

                        if($batch_result ==true){
                            $result = Array("status"=>true,"new_count"=>count($new_customers), "new_customers"=>$new_customers);
                        }
                        else{
                            $result = Array("status"=>false,"error"=>"New ".count($new_customers)." customers insert into database Error. ","errorType"=>"LIRA App Error");
                        }
                }else{
                    $result = Array("status"=>true,"new_count"=>0);
                }
            }
            else{
                $result = Array("status"=>true,"new_count"=>0);
            }
//            header("Content-Type: text/javascript; charset=utf-8");
            echo json_encode($result);


        }else{
//            header("Content-Type: text/javascript; charset=utf-8");
            echo json_encode(Array("status"=>false,"error"=>"User not logged in!","errorType"=>"LIRA App Validation"));
        }

    }//end function


    /**
     * VIEW CUSTOMER DATA
     */
    /*
    public function view(){
        
        if($this->session->userdata('is_logged_in')==TRUE){
 
            $data=  site_data();                        
            $data['_page_title']='Merchant Details';
            
            
            $data['_sn']=$this->uri->segment(3);
            $this->load->model('customer_model');
            $data['_record']=$this->customer_model->getRecord($data['_sn']);                                   
            $data['_linked_accounts']=$this->customer_model->getLinkAccountList($data['_sn']);

            $this->load->model('transaction_model');
            $data['_transactions']=$this->transaction_model->getAllRecordsByMerchantSn($data['_sn'],10,0);
            
            $this->template->customer_view($data);  
            
        }else{
            //user not logged in
            //redirect to signin
            redirect('signin');
            
        }//end else
        
    }//end function
    */
    /**
     * 
     */

    /**
     * SAVE A CUSTOMER
     */
    public function save(){
        
        if($this->session->userdata('is_logged_in')==TRUE){
            
        $this->load->library('form_validation');
        
        $_action = $this->input->post('_action');                
                               
        if($_action!='add'){                        
            $data['mrcnt_sn']            =$this->input->post('_sn');
        }

        $this->form_validation->set_rules('inputMerchantName', 'Merchant Name',     'trim|required|max_length[50]|xss_clean');                
        $this->form_validation->set_rules('inputMerchantEmail', 'Merchant Email',   'trim|required|max_length[50]|valid_email|xss_clean');        
        $this->form_validation->set_rules('inputPOSiOSId', 'POSiOS Company ID',     'trim|required|max_length[5]|xss_clean');
        $this->form_validation->set_rules('inputXeroApiKey', 'XERO API KEY',     'trim|max_length[255]|xss_clean');
        $this->form_validation->set_rules('inputXeroApiSecret', 'XERO API SECRET',     'trim|max_length[255]|xss_clean');
        $this->form_validation->set_rules('inputMrcntStatus', 'Merchant Status',     'trim|max_length[255]|xss_clean');

        $this->form_validation->set_rules('inputMrcntStartTime', 'Start Time',     'trim|required|max_length[11]|xss_clean');
        $this->form_validation->set_rules('inputMrcntEndTime', 'End Time',     'trim|required|max_length[11]|xss_clean');
        $this->form_validation->set_rules('inputMrcntAutoSync', 'Auto Sync',     'trim|required|max_length[1]|xss_clean');

        $data['mrcnt_name']                 = $this->input->post('inputMerchantName');                
        $data['mrcnt_email']                = $this->input->post('inputMerchantEmail');
        $data['mrcnt_pos_company_id']       = $this->input->post('inputPOSiOSId');        
        
        $data['mrcnt_xero_api_key']         = $this->input->post('inputXeroApiKey');        
        $data['mrcnt_xero_api_secret']      = $this->input->post('inputXeroApiSecret');

        $data['mrcnt_status']               = $this->input->post('inputMrcntStatus');
        $data['mrcnt_auto_sync']               = $this->input->post('inputMrcntAutoSync');

        $data['mrcnt_start_time']               = $this->input->post('inputMrcntStartTime');
        $data['mrcnt_end_time']               = $this->input->post('inputMrcntEndTime');
        $data['mrcnt_end_time_is_same_date']               = $this->input->post('inputEndTimeIsSameDay');

        $date = new DateTime();
        $data['addDate']                    = $date->format("Y-m-d H:i:s");
        $data['user_sn']                    = $this->session->userdata('user_sn');        
        
        $this->load->model('customer_model');
        
       
        if ($this->form_validation->run() == true)
        {             
            $res=false;
            
            if($_action=='add'){
                $res= $this->customer_model->insert($data); 
                
                
                if($res['status']==TRUE){
                    
                    //CREATE NEW USER FOR THE MERCHANT
                    $this->load->model('user_model');
                    $user['user_name']  = $data['mrcnt_name'];
                    $user['user_email'] = $data['mrcnt_email'];
                    $user['user_pass']  = md5($data['mrcnt_email']);
                    $user['user_type']  = 2;
                    $user['mrcnt_sn'] = $res['new_id'];

                    $this->user_model->insert($user);
                    
                    redirect('merchant/view/'.$res['new_id']);
                }else{
                    //show error message
                    echo 'show error message: customer add operation fail';
                }
                
            }else{
                //UPDATE CUSTOMER
                $id=$this->input->post('_sn');
                $res=$this->customer_model->update($data,$id);                   
                if($res==TRUE){
                    redirect('merchant/view/'.$id);
                }else{
                    //show error message
                    echo 'show error message: customer UPDATE operation fail';
                }
            }//end else
            
        }//end if
        else{
            
            //echo validation_errors();
            //exit();
             $data=  site_data();
             
            //echo 'error: '.  validation_errors();
            $data['_error']=  validation_errors();                    
            
            $_action = $this->input->post('_action');                
                               
            if($_action!='add'){                                            
                $data['_record'][0]['mrcnt_sn']=$this->input->post('_sn');
            }
            
            
            $data['_record'][0]['mrcnt_name']=$this->input->post('inputMerchantName');
            $data['_record'][0]['mrcnt_email']=$this->input->post('inputMerchantEmail');
            $data['_record'][0]['mrcnt_pos_company_id']=$this->input->post('inputPOSiOSId');
            
            $data['_record'][0]['mrcnt_xero_api_key']=$this->input->post('inputXeroApiKey');
            $data['_record'][0]['mrcnt_xero_api_secret']=$this->input->post('inputXeroApiSecret');
            
            
            if($_action=='add'){
                $data['_page_title']='Add New Customer';
                $data['_action']='add';                                                
                $this->template->customer_add($data);  
            }else{
                
                $data['_sn']=$this->input->post('_sn');
                
                $data['_page_title']='Update Customer';
                $data['_action']='update';                                                                
            }
            
        }//end else        
        
        
        }else{
            //user not logged in
            //redirect to signin
            redirect('signin');
            
        }//end else
        
    }//end function
    
    public function delete(){
        if($this->session->userdata('is_logged_in')==TRUE){
        
            $data['_sn']=$this->input->post('_sn');        
            $this->load->model('customer_model');
            $res= $this->customer_model->delete($data['_sn']);

            echo $res;
        
        }else{
            //user not logged in
            //redirect to signin
            redirect('signin');
            
        }//end else
    }//end function

}//end class