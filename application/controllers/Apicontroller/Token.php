<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Token extends CI_Controller{
function __construct()
    {
      parent::__construct();
      $this->load->model("admin/login_model");
      $this->load->model("admin/base_model");
    }

    public function random_strings($length_of_string)
                {

                // String of all alphanumeric character
                $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';

                // Shufle the $str_result and returns substring
                // of specified length
                return substr(str_shuffle($str_result), 0, $length_of_string);
                }


                        public function get_token(){


             $txnid= $this->random_strings(30);

                        $this->db->select('*');
            $this->db->from('tbl_token');
            $this->db->where('token',$txnid);
            $this->db->where('is_active',1);
            $tt= $this->db->get()->row();


            if(!empty($tt)){
              $txnid= $this->random_strings(30);
            }
            else{
              // echo "hi";
              // exit;
              $ip = $this->input->ip_address();
            date_default_timezone_set("Asia/Calcutta");
              $cur_date=date("Y-m-d H:i:s");

                        $data_insert = array('token'=>$txnid,
                                  'ip' =>$ip,
                                  'is_active' =>1,
                                  'added_by' =>999,
                                  'date'=>$cur_date

                                  );





                        $last_id=$this->base_model->insert_table("tbl_token",$data_insert,1) ;

              $token=$txnid;
            }
            header('Access-Control-Allow-Origin: *');

            $res = array('message'=>"success",
                  'status'=>200,
                  'token'=>$token
                  );

                  echo json_encode($res);


            }
            



}
