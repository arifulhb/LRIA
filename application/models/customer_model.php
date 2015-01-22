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
    
    public function search($keyword, $search_by,$limit,$offset){
        
        if($offset==''){
            $offset=0;
        }
        
        $sql='SELECT c.cust_sn, c.cust_card_id, cust_first_name, cust_last_name, cust_mobile, cust_car_no, IFNULL(UNIX_TIMESTAMP(c.date_added),0) as date_added, ';
        $sql.='(SELECT GROUP_CONCAT(n.cmpn_name SEPARATOR ", ") FROM avcd_subscription AS s LEFT OUTER JOIN avcd_campaign AS n ON n.cmpn_sn=s.cmpn_sn WHERE s.cust_sn=c.cust_sn ) AS cmpn_name ';
        $sql.='FROM (avcd_customer AS c) ';
        //$sql.='';        
        switch ($search_by):
            case 'name':
                $sql.='WHERE c.cust_first_name LIKE "%'.$keyword.'%" OR c.cust_last_name LIKE"%'.$keyword.'%" ';
                
                break;
            case 'nric':
                $sql.='LEFT OUTER JOIN avcd_customer_id AS i ON i.cust_sn = c.cust_sn ';
                $sql.='WHERE c.cust_card_id LIKE "%'.$keyword.'%" ';
                $sql.='OR i.cust_card_id LIKE  "%'.$keyword.'%" ';
                break;
            case 'card_number':
                $sql.='WHERE c.cust_id LIKE "%'.$keyword.'%" ';
                break;
            case 'car_number':
                $sql.='WHERE c.cust_car_no LIKE "%'.$keyword.'%" ';
                break;
        endswitch;
                $sql.='GROUP BY c.cust_sn ';
                $sql.='ORDER BY c.cust_first_name ';
                $sql.='LIMIT '.$offset.', '.$limit;
                
         $res=$this->db->query($sql);
         
         //echo 'SQL: '.$this->db->last_query();         
         //exit();
         
         return $res->result_array();
        
    }//end function

    /*
     * Get all client ids
     * Primary use in Customer Sync function
     */
    public function getClientIds(){

        $this->db->select("cust_oid as client_id");
        $this->db->from("tblCustomer");
        $this->db->where("cust_oid !=", "");
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
    
    public function getTotalSearchNum($keyword, $search_by){
        
        
        $sql='SELECT cust_sn ';
        //$sql.='(SELECT GROUP_CONCAT(n.cmpn_name SEPARATOR ", ") FROM avcd_subscription AS s LEFT OUTER JOIN avcd_campaign AS n ON n.cmpn_sn=s.cmpn_sn WHERE s.cust_sn=c.cust_sn ) AS cmpn_name ';
        $sql.='FROM (avcd_customer AS c) ';
        //$sql.='';        
        switch ($search_by):
            case 'name':
                $sql.='WHERE c.cust_first_name LIKE "%'.$keyword.'%" OR c.cust_last_name LIKE"%'.$keyword.'%" ';
                
                break;
            case 'nric':
                $sql.='WHERE c.cust_card_id LIKE "%'.$keyword.'%" ';
                break;
            case 'card_number':
                $sql.='WHERE c.cust_id LIKE "%'.$keyword.'%" ';
                break;
            case 'car_number':
                $sql.='WHERE c.cust_car_no LIKE "%'.$keyword.'%" ';
                break;
        endswitch;
                //$sql.='GROUP BY c.cust_sn ';                  
         $res=$this->db->query($sql);
         
         //echo 'SQL: '.$this->db->last_query();
         
         return $res->num_rows();
        
    }//end function

          

    public function getList($per_page,$offset){
        if($offset==''){
            $offset=0;
        }

        $this->db->select("c.cust_sn, c.cust_firstname, c.cust_lastname, c.cust_phone_no, c.cust_email, c.create_by, c.create_date, u.user_name");
        $this->db->from("tblCustomer c");
        $this->db->join('tblusers AS u ','c.create_by =u.user_sn','LEFT');
        $this->db->order_by('c.create_date','DESC');
        $this->db->limit($per_page,$offset);
        $res=$this->db->get();

        return $res->result_array();
        
    }//end function
    
//    public function getListFilter($per_page,$offset,$filter){
//
//        if($offset==''){
//            $offset=0;
//        }
//
//        $sql='SELECT `cust_sn`, `cust_card_id`, `cust_first_name`, `cust_last_name`, `cust_mobile`, `cust_car_no`, IFNULL(UNIX_TIMESTAMP(c.date_added),0) as date_added, cust_additional,';
//        $sql.='(SELECT GROUP_CONCAT(n.cmpn_name SEPARATOR ", ") FROM avcd_subscription AS s LEFT OUTER JOIN avcd_campaign AS n ON n.cmpn_sn=s.cmpn_sn WHERE s.cust_sn=c.cust_sn ) AS cmpn_name ';
//        $sql.='FROM (`avcd_customer` AS c) ';
//        $sql.='WHERE c.date_added >= "'.$filter['from'].' 00:00:00" ';
//        $sql.='AND c.date_added <= "'.$filter['to'].' 23:59:59" ';
//        $sql.='GROUP BY `c`.`cust_sn` ';
//        $sql.='ORDER BY `c`.`date_added` DESC ';
//        $sql.=' LIMIT '.$offset.','.$per_page;
//        $res=$this->db->query($sql);
//        //echo $this->db->last_query();
//        //print_r($res->result_array());
//        //exit();
//        return $res->result_array();
//
//    }//end function
    
   
        
    public function getRecord($_sn=NULL){
        
        $sql='SELECT * ';        
        $sql.='FROM tblCustomer ';
        $sql.='WHERE cust_sn ='.$_sn;
        $res=$this->db->query($sql);
        
        
        return $res->result_array();
        
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