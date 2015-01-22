<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Signup extends CI_Controller {

    public function __construct()
    {
            parent::__construct();

            $this->load->library('template');

    }//end constractor

    /**
     * Frontend Function
     */
    public function index()
    {
      
        $data=  site_data();
        $data['_page_title']='Signup';

        $this->template->user_signup($data);

    }//end index

    /**
     *
     */
    public function user_registration()
    {

        $this->load->library('form_validation');


        $this->form_validation->set_rules('user_first_name', 'First Name','trim|required|max_length[50]|xss_clean');
        $this->form_validation->set_rules('user_last_name', 'Last Name','trim|required|max_length[50]|xss_clean');
        $this->form_validation->set_rules('user_email', 'User Email',   'trim|required|max_length[50]|valid_email|xss_clean|is_unique[krn_user.user_email]');
        $this->form_validation->set_rules('user_password', 'User Password',   'trim|required|max_length[50]|xss_clean|matches[user_repassword]');
        $this->form_validation->set_rules('user_repassword', 'User Confirmation',   'trim|required|max_length[50]|xss_clean');


        $data['user_email']                     = $this->input->post('user_email');
        $data['user_first_name']                = $this->input->post('user_first_name');
        $data['user_last_name']                 = $this->input->post('user_last_name');
        $data['user_password']                  = md5($this->input->post('user_password'));

//        @TODO initially user_status is 1(active) by default for development and testing basis. It must be changed in Live
//        It must be set 0(inactive) in live and should be activated via email URL link;

        $data['user_status']                    = 1; //inactive

        $date = new DateTime();
        $data['user_join_date']             = $date->format("Y-m-d H:i:s");

//        @TODO update ref_by_user_sn for activate and track user referal
//        $data['ref_by_user_sn']             = $this->session->userdata('user_sn');


        if ($this->form_validation->run() == true)
        {

            $this->load->model('user_model');

            $res = $this->user_model->signup($data);

            if($res['status']==true){

//                Prepare default subscription
                    $usersn = $res['new_id'];
                    $this->defaultSignup($usersn);

//              Say thank you and wait for activation
//                Now redirect to signin page;
                redirect('signin?status=1');

            }else{
//                Database error
//                back to signup page with error
                    echo 'Database Errro';
            }

        }else{
//            Validation error
//            back to signup page with error
            $_error =  validation_errors();

//
                $this->session->set_flashdata('errors', $_error);
                $this->session->set_flashdata('data', $data);
                redirect ('signup');

        }//END IF



        }//end function

        private function defaultSignup($usersn){

            $this->load->model('package_model');

            $res = $this->package_model->getDefaultPackage();

            if(count($res)>0){

                $date = new DateTime();

                $user_package['user_sn']                = $usersn;
                $user_package['pkg_sn']                 = $res[0]['pkg_sn'];
                $user_package['pkg_quantity']           = 1;
                $user_package['pkg_duration_type']      = $res[0]['pkg_duration_type'];
                $user_package['pkg_duration']           = $res[0]['pkg_duration'];
                $user_package['pkg_rate']               = $res[0]['pkg_rate'];

                $user_package['activate_date']          = $date->format("Y-m-d H:i:s");//timestamp


//                If Duration is 0, expire will be unlimited,
                if($res[0]['pkg_duration']==0){

                    $user_package['expire_date']            = null;
                    $user_package['warning_duration_type']  = null;
                    $user_package['warning_duration']       = null;
                    $user_package['deactive_date']          = null;

                }else{
//                  Calculate the expire date, deactivate date based on package

                    if($res[0]['pkg_duration_type']=="day"){
                        $days = $res[0]['pkg_duration'];

                        $expire_date        = mktime(0, 0, 0, date("m")  , date("d")+$days, date("Y"));
                        $deactivate_date    = mktime(0, 0, 0, date("m")+3  , date("d")+$days, date("Y"));

                    }elseif($res[0]['pkg_duration_type']=="month"){
                        $months = $res[0]['pkg_duration'];

                        $expire_date        = mktime(0, 0, 0, date("m") +$months , date("d"), date("Y"));;
                        $deactivate_date    = mktime(0, 0, 0, date("m") +$months +3 , date("d"), date("Y"));

                    }elseif($res[0]['pkg_duration_type']=="year"){
                        $years = $res[0]['pkg_duration'];

                        $expire_date        = mktime(0, 0, 0, date("m") , date("d"), date("Y")+$years );
                        $deactivate_date    = mktime(0, 0, 0, date("m")+3 , date("d"), date("Y")+$years );;
                    }

                    $user_package['expire_date']            = $expire_date;
                    $user_package['warning_duration_type']  = null;
                    $user_package['warning_duration']       = 0;
                    $user_package['deactive_date']          = $deactivate_date;

                }//end else


                $user_package['user_pkg_status']        = 1; //1 active; 0 inactive

                $user_package['pkg_agency']             = $res[0]['pkg_permission_agency'];
                $user_package['pkg_project']            = $res[0]['pkg_permission_project'];
                $user_package['pkg_member']             = $res[0]['pkg_permission_member'];
                $user_package['pkg_storage']            = $res[0]['pkg_storage'];
                $user_package['promotion_code']         = "none";
                $user_package['promotion_details']      = "";


                $user_package['add_date']               = $date->format("Y-m-d H:i:s");; //timestamp

//                Add Default Package to Database
                $add = $this->package_model->addUserPackage($user_package);

            }else{
                echo "error".PHP_EOL;
                print_r($res);
            }


        }//end function
 
    
}//end class
?>