<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reservation_model extends CI_Model
{
    
    public function __construct()
    {
        parent::__construct();
    }//end constract 
    
    public function insert($data)
    {
        
        $this->db->set($data);
        $res=$this->db->insert('tblReservation');
        
        return $res;
        
    }//end function


    public function getList($per_page,$offset){
        if($offset==''){
            $offset=0;
        }

        $this->db->select("r.rsrv_sn, r.rsrv_date as rsrv_date, r.rsrv_pax, r.rsrv_note, r.cust_is_repeat, r.reservationId, r.cust_sn, c.cust_firstname, c.cust_lastname, c.cust_phone_no, c.cust_email, r.create_by, r.create_date as rcreate_date, u.user_name, floorName, tableName ");
        $this->db->from("tblReservation r");
        $this->db->join('tblusers AS u ','r.create_by =u.user_sn','LEFT');
        $this->db->join('tblCustomer AS c ','c.cust_sn =r.cust_sn','LEFT');
        $this->db->order_by('r.create_date','DESC');
        $this->db->limit($per_page,$offset);
        $res=$this->db->get();

        return $res->result_array();

    }//end function


    public function getTotalNum(){

        $this->db->select('rsrv_sn');
        $this->db->from('tblReservation');
        $res=$this->db->get();
        return $res->num_rows;
    }//end function


}//end class
