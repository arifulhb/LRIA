<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reservation extends CI_Controller {

    
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


      //set pagination configuration

        //Load pagination library
        $this->load->library('pagination');

        $config=  getPaginationConfig();//this function is from helpers/ahb_helper.php file
        $config['base_url'] = base_url().'reservation/index';
        $this->load->model('reservation_model');

        $config['total_rows'] = $this->reservation_model->getTotalNum();
        $config['use_page_numbers']=true;
        $config['per_page'] = 20;
        $config['num_links'] = 5;        
        $config['uri_segment'] = 3;                        
        $this->pagination->initialize($config);

        
        $data['_total_rows']=$config['total_rows'];

        if($this->uri->segment(3)!=''){
            
            $last=$this->uri->segment(3)*$config['per_page']>$config['total_rows']?$config['total_rows']:$this->uri->segment(3)*$config['per_page'];

            $data['_pagi_msg']=  (($this->uri->segment(3)-1)*($config['per_page']+1)).' - '.$last;            
            
            $data['_list']=$this->reservation_model->getList($config['per_page'],($config['per_page']*($this->uri->segment(3)-1)));
        }else{                
            if($config['total_rows']>$config['per_page']){                    
                $last=$config['per_page'];      
            }else{                    
                $last=$config['total_rows'];      
            }

          $data['_pagi_msg'] = '1 - '.$last;              

          $data['_list']=$this->reservation_model->getList($config['per_page'],$this->uri->segment(3));
        }
        
        $data['_page_title']='Reservation List';
        $data['_menu_top']='reservation';
        $data['_menu_active']='reservation_list';
        $this->template->reservation_index($data);
        
        
        }else{
            //user not logged in
            //redirect to signin
            redirect('signin');
            
        }//end else
        
    }//end index
    
    public function add_form(){
        
        if($this->session->userdata('is_logged_in')==TRUE){
        
        $data=  site_data();
        $data['_page_title']='New Reservation';
        $data['_menu_top']  ='reservation';
        $data['_menu_active']  ='reservation_add';

        
//        $this->load->model('reservation_model');

        $data['_action']='add';
        $this->template->reservationr_add($data);
        
        }else{
            //user not logged in
            //redirect to signin
            redirect('signin');
            
        }//end else
        
    }//end function

    public function getClient(){

        $this->load->library('LightspeedClient');
        $this->lightspeedclient->setApiToken($this->session->userdata['api_token']);
        $this->lightspeedclient->setCompanyId($this->session->userdata['company_id']);
        $result = $this->lightspeedclient->getCustomers();

        /*
//        $this->lightspeedclient->setApiToken($this->session->userdata['api_token']);
        $this->lightspeedclient->generateClientToken();

//        $this->lightspeedclient->setCompanyId($this->session->userdata['company_id']);

        $result = $this->lightspeedclient->getClient();


        echo json_encode($this->lightspeedclient->getClientToken());
        */

//        $client["firstname"]    =   "Adrian";
//        $client["lastname"]     =   "Ling";
//        $client["email"]        =   "adrian@gmail.com";
//        $client["username"]     =   "adrian@gmail.com";
//        $client["password"]     =   "Abcd@1234";
//        $result = $this->lightspeedclient->addClient($client);
//
//
        echo json_encode($result);


    }//end function

    public function getSlots(){


            $this->load->library('LightspeedClient');

            $this->lightspeedclient->setApiToken($this->session->userdata['api_token']);
            $this->lightspeedclient->setCompanyId(32);
            $result = $this->lightspeedclient->getReservationSlots();


            echo json_encode($result);


    }//end function getReservationSlots

    public function ajax_getFloors(){

        if($this->session->userdata('is_logged_in')==TRUE){

            $this->load->library('LightspeedClient');
            $this->lightspeedclient->setApiToken($this->session->userdata['api_token']);
            $this->lightspeedclient->setCompanyId($this->session->userdata['company_id']);
            $this->lightspeedclient->setServerUrl($this->session->userdata['api_endpoint']);

            $floors = $this->lightspeedclient->getFloor();

            if(isset($floors->result)){
                echo json_encode($floors->result);
            }else{
                echo json_encode(Array());
            }
        }
        else{
            $error = Array("status"=>false,"error"=>"User Not Loggedin","errorType"=>"Applicatino Error");
            json_encode($error);
        }

    }//end function


    public function ajax_save(){

        if($this->session->userdata('is_logged_in')==TRUE){

            $this->load->library('LightspeedClient');
            $this->lightspeedclient->setApiToken($this->session->userdata['api_token']);
            $this->lightspeedclient->setCompanyId($this->session->userdata['company_id']);
            $this->lightspeedclient->setServerUrl($this->session->userdata['api_endpoint']);

            $response                   = null;
            $cust_sn                    = null; //collection from database after add


            $lr_cust_oid                = $this->input->post("lr_cust_oid");

            $cust_is_repeat     = false;
            $cust_ls_response   = null;




            if(strlen($lr_cust_oid)>0){
//                USE lr_OID AND Add reservation
                $cust_is_repeat = true;

                $reservation['clientId']    = $lr_cust_oid; //clientId

                $cust_sn                    = $this->input->post("cust_sn");

            }else{
//                Add New Customer and Add Reservation
                $cust_is_repeat = false;

                $this->load->library('form_validation');

                $this->form_validation->set_rules('cust_phone', 'User Handphone', 'trim|required|max_length[15]|xss_clean|is_unique[tblCustomer.cust_phone_no]');
                $this->form_validation->set_rules('cust_firstname', 'User Firstname', 'trim|required|max_length[50]|xss_clean');
                $this->form_validation->set_rules('cust_lastname', 'User Lastname', 'trim|required|max_length[50]|xss_clean');
                $this->form_validation->set_rules('cust_email', 'User Email', 'trim|required|max_length[50]|xss_clean|valid_email');

                $customer['firstname']      = $this->input->post("cust_firstname");
                $customer['lastname']       = $this->input->post("cust_lastname");
                $customer['email']          = $this->input->post("cust_email");
                $customer['username']       = $this->input->post("cust_email");
                $customer['telephone']      = $this->input->post("cust_phone");

                $customer['password']       = 'Abc@1234';

                if ($this->form_validation->run() == true)
                {

    //              @todo add to Lightspeed
                    $cust_ls_response = $this->lightspeedclient->addClient($customer);


                    if(is_null($cust_ls_response)){

                        $error = Array("status"=>false,"error"=>"<i class='fa fa-warning'></i> Can not add new customer and reservation to Lightspeed","errorType"=>"Lightspeed Server not responding");

                        echo json_encode($error);
                        exit();
                    }

//                    $cust_ls_response['result']=true;
                    if(isset($cust_ls_response->result)){

    //                    Added Successfully
                        $lr_cust_oid                    = $cust_ls_response->result;


                        $addCustomer['cust_oid']        = $cust_ls_response->result;


                        $addCustomer['cust_firstname']  = $customer['firstname'];
                        $addCustomer['cust_lastname']   = $customer['lastname'];
                        $addCustomer['cust_phone_no']   = $customer['telephone'];
                        $addCustomer['cust_email']      = $customer['email'];
                        $addCustomer['cust_username']   = $customer['email'];
                        $addCustomer['cust_password']   = $customer['password'];


                        $addCustomer['create_by']       = $this->session->userdata('u_sn');
                        $addCustomer['create_date']     = date("Y-m-d H:i:s",strtotime("now"));

                        $this->load->model('customer_model');

                        $cust_result = $this->customer_model->insert($addCustomer);
                        if($cust_result['status']==true){
                            $cust_sn = $cust_result['new_id'];
                        }//end if

//                        $res = Array("status"=>false,"error"=> "custsn : ".$cust_sn,"error_type"=>"app test","result"=>$cust_result);
//                        echo json_encode($res);
//                        exit();

                    }
                    else{
    //                    Error
                        $error = get_object_vars($cust_ls_response);
                        $error = Array("status"=>false, "error" => "<i class='fa fa-warning'></i> ".$error['error']->msg,"errorType"=>"Lightspeed Api Validation");

                        echo json_encode($error);

                        exit();

                    }//end else

                $reservation['clientId']            = $lr_cust_oid; //clientId

//              Add Else here
                }
                else{

                    $vErrors = validation_errors();

                    $error = Array("status"=>false, "error" => $vErrors,"errorType"=>"LIRA App Validation");

                    echo json_encode($error);

                    exit();
                }

            }//end else

//            $res = Array("status"=>false,"error"=> "custsn : ".$cust_sn,"error_type"=>"app test exit");
//            echo json_encode($res);
//            exit();

//            $reservation['clientId']            = '14309'; //customerId
            $reservation['seats']            = $this->input->post("res_pax"); //pax

            $res_date   =$this->input->post("res_date");
            $cdate = explode("-",convertMyDate($res_date));
            $res_time   = explode(":",$this->input->post("res_time"));
            $res_long_start_date =  mktime($res_time[0], $res_time[1], '00', $cdate[1],$cdate[2], $cdate[0]);
            $res_long_end_date =  mktime($res_time[0], $res_time[1]+60, '00', $cdate[1],$cdate[2], $cdate[0]);


            $reservation['startTime']           = $res_long_start_date *1000; //start date + time
            $reservation['endTime']             = $res_long_end_date * 1000; //start date + time
            $reservation['telephone']           = "012456789"; //start date + time

//            echo json_encode(Array("start date"=>date("d,m,Y H:i:s",$res_long_start_date),
//                                    "end date"=>date("d,m,Y H:i:s",$res_long_end_date)));
//            exit();


            $reservation['floorId']               = $this->input->post("res_floor"); //floorId
            $reservation['tableId']               = $this->input->post("res_table"); //res_table
            $reservation['notes']               = $this->input->post("res_note"); //notes
            $reservation['companyId']           = $this->session->userdata['company_id']; //company id

            /* Status Code
            0: Status Unknown, 1: Status Canceled, 2: Status On Hold 3: Status To Check, 4: Status Confirmed, 5: Status Seated */
            $reservation['statusId']            = 4 ;//status confirmed


//            @todo add to lightspeed
            $reservation_result = $this->lightspeedclient->addReservation($reservation);


            if(is_null($reservation_result)){

                $error = Array("status"=>false,"error"=>"<i class='fa fa-warning'></i> Can not add new reservation to Lightspeed.","errorType"=>"Lightspeed Server not responding");

                echo json_encode($error);

                exit();
            }

//            echo json_encode(Array( "reservation_result"=>$reservation_result));
//
//            exit();

            if(isset($reservation_result->result)){


//                echo json_encode(Array("customerId"=>$reservation_result->result->customerId,
//                                    "reservatinId"=>$reservation_result->result->reservationId));
//                exit();

//                echo json_encode(Array( "reservation_result"=>$reservation_result));
                $this->load->model('reservation_model');

//              Add Reservation to Database
                $rdata['cust_sn']       = $cust_sn;
                $rdata['rsrv_date']     = date("Y-m-d H:i:s",$res_long_start_date);
                $rdata['rsrv_pax']      = $reservation['seats'];
                $rdata['rsrv_note']     = $reservation['notes'];

                $rdata['customerId']        = $reservation_result->result->customerId;
                $rdata['reservationId']     = $reservation_result->result->reservationId;
                $rdata['modificationTime']  = $reservation_result->result->modificationTime;


                $rdata['cust_is_repeat']     = $cust_is_repeat;

                $rdata['create_date']   = date("Y-m-d H:i:s",strtotime("now"));
                $rdata['create_by']     = $this->session->userdata('u_sn');
//
                $rresult = $this->reservation_model->insert($rdata);

                $response = Array("status"=>true, "lsResponse"=>$reservation_result, "dbInsertObject"=>$rdata , "dbInsertStatus"=>$rresult);
//                $response = Array("status"=>true, "lsResponse"=>$reservation_result, "dbInsertObject"=>$rdata );

            }else{

                if(is_null($reservation_result)){
                    $response = Array("status"=>false,"error"=>"<i class='fa fa-warning'></i> Couldn't Save in Lightspeed","errorType"=>"Lightspeed Server Error");
                }else{
                    $error = get_object_vars($reservation_result);
                    $response = Array("status"=>false,"error"=>$error['error']->msg,"errorType"=>"Lightspeed Error");
                }
//                echo json_encode($response);
            }


            echo json_encode($response);

            exit();
//            echo date("Y-m-d H:i:s",strtotime($reservation['startTime']));
//            echo date("Y-m-d H:i:s",$reservation['startTime']);
//            exit();


//
//            if(isset($reservation_result->result)){
//
////            @TODO add reservation to our database
//
//
//            } else{
////                echo an error message from the $reservation_result
//                $error = get_object_vars($reservation_result);
//                $response = Array("status"=>false,"error"=>$error,"errorType"=>"Lightspeed Error");
//
//            }//end else


//            echo json_encode($response);


        }else{
            $error = Array("status"=>false,"error"=>"User not logged in","errorType"=>"Application Error");
            echo json_encode($error);
        }

    }//end function


    public function save(){
        
        if($this->session->userdata('is_logged_in')==TRUE){
        
        $this->load->library('form_validation');
        $_action=$this->input->post('_action');
        
        if($_action=='add'){
            $this->form_validation->set_rules('inputUserEmail', 'User Email', 'trim|required|max_length[250]|xss_clean|valid_email|is_unique[tblusers.user_email]');
            $data['user_email']     = $this->input->post('inputUserEmail');
        }
        $this->form_validation->set_rules('inputUserName', 'User Name', 'trim|required|max_length[250]|xss_clean');
                
        

        $data['user_name']      = $this->input->post('inputUserName');
        $data['user_status']    = 1;
        
        if ($this->form_validation->run() == true)
        {                         
            $res=false;
            $this->load->model('user_model');

            if($_action=='add'){
                //add only when add new data
                $data['user_password']      = md5($this->input->post('inputUserEmail'));

                
                $res= $this->user_model->insert($data);    
                if($res['status']==TRUE){
                    redirect('user/profile/'.$res['new_id']);
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
    
    public function delete_form(){
        
        if($this->session->userdata('is_logged_in')==TRUE){
       
            $data['_sn']=$this->input->post('_sn');        
            $this->load->model('user_model');
            $res= $this->user_model->delete($data['_sn']);

            echo $res;
        }else{
            //user not logged in
            //redirect to signin
            redirect('signin');
            
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
        
    public function edit_form(){
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
    


}//end class
