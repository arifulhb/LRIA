<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class User_model extends CI_Model
{
    //var $photo_path;
    
    public function __construct()
    {
        parent::__construct();
    }//end constract
    
    
    public function insert($data=null){
    
        $res =$this->db->insert('tblusers', $data);
        if($res==true){
            $res=array('status'=>true,'new_id'=>$this->db->insert_id());
        }else{
            
        }
        return $res;
    }//end function
        

    public function getList($per_page,$offset){
        if($offset==''){
            $offset=0;
        }
        
        $this->db->select('u.*');
        $this->db->limit($per_page,$offset);
        $this->db->from('tblusers AS u');
//        $this->db->join('tblmerchant as m','m.mrcnt_sn=u.mrcnt_sn','LEFT OUTER');
        $this->db->order_by('u.user_sn','DESC');
        $res=$this->db->get();
        
        //echo $this->db->last_query();
        return $res->result_array();
        
    }//end function
    
        
    public function signin($data){
        
        $user_email    =$data['user_email'];
        $user_pass  =md5($data['user_password']);
        
        $this->db->select('u.*');
        $this->db->from('tblusers AS u');
        $this->db->where('u.user_email',$user_email);
        $this->db->where('u.user_password',$user_pass);
        $res=$this->db->get();        
        return $res->result_array();
        
    }//end function
    
    
    public function getPartner($login_type){
        
        $this->db->select('p.partner_email AS partner_email, p.partner_password AS partner_password, p.app_id AS app_id, p.login_type, p.api_endpoint as json_url, p.company_id');
        $this->db->from('tblPartner AS p');
        $this->db->where('p.login_type',$login_type);
        $this->db->limit(1);
        $res=$this->db->get();        
        return $res->result_array();
        
    }//end function

    public function getRecord($_sn=NULL){
        
        $this->db->select('u.*');
        $this->db->from('tblusers as u');
        //$this->db->join('avcd_outlet as o','o.ol_sn=u.ol_sn','LEFT OUTER');
        $this->db->where('u.user_sn',$_sn);        
        $res=$this->db->get();
        
        return $res->result_array();
        
    }//end function
    
    public function update($data, $_sn){
        
        //$this->db->set($data);
        $this->db->where('user_sn',$_sn);   
        $res=$this->db->update('tblusers',$data);
        return $res;
        
    }//end function
    
    public function delete($data=null){
        
        $res= $this->db->delete('tblusers', array('user_sn' => $data));
        return $res;
        
    }//end function

    public function getTotalNum(){
        
        $this->db->select('user_sn');
        $this->db->from('tblusers');
        $res=$this->db->get();
        return $res->num_rows;
    }//end function
    
    public function getAllRecords(){
        $this->db->select('u.*');
        $this->db->from('`tblusers` AS u');
        //$this->db->join('`avcd_outlet` AS o','o.ol_sn=u.`ol_sn`','LEFT');
        //$this->db->order_by('ol_name');
        $res=$this->db->get();
        
        return $res->result_array();
    }//end function
     
    public function getAllRoles(){
        $this->db->select('*');
        $this->db->from('avcd_user_role');
        $this->db->order_by('rank');
        $res=$this->db->get();
        
        return $res->result_array();
    }//end function
    
    public function setToken($user_sn, $data){
        
        $this->db->where('user_sn',$user_sn);
        $res =$this->db->update('tblusers',$data);
        
        return $res;
        
    }//end function
    
    public function changepassword($data,$user_sn){
    
        $this->db->where('user_sn', $user_sn);
        $res =$this->db->update('tblusers', $data); 
        
        return $res;
    }//end function

    /**
     * Signup
     * @param null $data
     * @return array
     */
    public function signup($data = null){

        $res =$this->db->insert('krn_user', $data);
        if($res==true){
            $res=array('status'=>true,'new_id'=>$this->db->insert_id());
        }else{
            $res=array('status'=>false);
        }

        return $res;
    }//end function
    
}//end class