<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Customer_model extends CI_Model
{

    
    public function __construct()
    {
        parent::__construct();
    }//end constract
    
    /**
     * INSERT DATA INTO DATABASE
     * 
     * @param type $data
     * @return boolean
     */
    public function insert($data=null){
    
        $res =$this->db->insert('tblCustomer', $data);
        if($res==true){
            $res=array('status'=>true,'new_id'=>$this->db->insert_id());
        }else{
            $res=array('status'=>FALSE);
        }
        return $res;
    }//end function

    public function insert_batch($data=null){

        $res = $this->db->insert_batch('tblCustomer', $data);

        return $res;

    }//end function

    public function update_batch($data=null){

        $result = $this->db->update_batch('tblCustomer', $data, 'cust_client_id');
        return $result;

    }//end function

    public function search($keyword, $limit, $offset){
        
        if($offset==''){
            $offset=0;
        }

        $this->db->select("c.*, u.user_name");
        $this->db->from("tblCustomer AS c");
        $this->db->join("tblusers as u", "u.user_sn=c.create_by");
        $this->db->like("c.cust_firstname", $keyword);
        $this->db->or_like("c.cust_lastname", $keyword);
        $this->db->or_like("c.cust_phone_no", $keyword);
        $this->db->or_like("c.cust_email", $keyword);
        $this->db->limit($offset, $limit);

        $res = $this->db->get();

        return $res->result_array();
        
    }//end function

    public function getTotalSearchNum($keyword){

        $this->db->select("c.cust_sn");
        $this->db->from("tblCustomer AS c");
        $this->db->like("c.cust_firstname", $keyword);
        $this->db->or_like("c.cust_lastname", $keyword);
        $this->db->or_like("c.cust_phone_no", $keyword);

        $res = $this->db->get();
        return $res->num_rows();
    }

    /*
     * Get all client ids
     * Primary use in Customer Sync function
     */
    public function getClientIds(){

        $this->db->select("cust_client_id as client_id");
        $this->db->from("tblCustomer");
        $this->db->where("cust_client_id !=", "");
        $result = $this->db->get();

        return $result->result_array();

    }//end function


    public function getAjaxSearchResult($keyword){


        $sql='SELECT c.* ';
        $sql.='FROM tblCustomer AS c ';
        $sql.='WHERE c.cust_firstname LIKE "%'.$keyword.'%" OR c.cust_lastname LIKE "%'.$keyword.'%" '.' OR c.cust_phone_no LIKE "%'.$keyword.'%" ';
        $sql.='ORDER BY c.cust_firstname ';

        $res=$this->db->query($sql);

        return $res->result_array();


    }//end function

          

    public function getList($per_page,$offset){
        if($offset==''){
            $offset=0;
        }

        $this->db->select("c.cust_sn, c.cust_firstname, c.cust_lastname, c.cust_phone_no, c.cust_email, c.create_by, c.create_date, u.user_name, c.cust_oid");
        $this->db->from("tblCustomer c");
        $this->db->join('tblusers AS u ','c.create_by =u.user_sn','LEFT');
        $this->db->order_by('c.create_date','DESC');
        $this->db->limit($per_page,$offset);
        $res=$this->db->get();

        return $res->result_array();
        
    }//end function

        
    public function getRecord($_sn=NULL){
        
        $sql='SELECT * ';        
        $sql.='FROM tblCustomer ';
        $sql.='WHERE cust_sn ='.$_sn;
        $res=$this->db->query($sql);
        
        
        return $res->result_array();
        
    }//end function

    public function updateByClientId($data, $clientId){

        $this->db->where('cust_client_id',$clientId);
        $res=$this->db->update('tblCustomer',$data);
        return $res;

    }//end function

    
    public function update($data, $_sn){

        $this->db->where('cust_sn',$_sn);   
        $res=$this->db->update('tblCustomer',$data);
        return $res;
        
    }//end function
    
    

    public function delete($data=null){

        $res = $this->db->delete('avcd_customer', array('cust_sn' => $data));
        
        return $res;
        
    }//end function

    public function getTotalNum(){
        
        $this->db->select('cust_sn');
        $this->db->from('tblCustomer');
        $res=$this->db->get();
        return $res->num_rows;
    }//end function
    
    public function getTotalNumFilter($filter){
        
        $this->db->select('cust_sn');
        $this->db->from('tblCustomer');        
        $this->db->where('create_date >=',$filter['from'].' 00:00:00 ');
        $this->db->where('create_date <=',$filter['to'].' 23:59:59 ');
        $res=$this->db->get();
        return $res->num_rows;

    }//end function
    
    public function getAllRecords(){
        $this->db->select('*');
        $this->db->from('tblCustomer');
        $this->db->order_by('create_date');
        $res=$this->db->get();
        
        return $res->result_array();
    }//end function
     

}//end class