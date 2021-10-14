<?php
     if ( ! defined('BASEPATH')) exit('No direct script access allowed');
        require_once(APPPATH . 'core/CI_finecontrol.php');
        class Inventory extends CI_finecontrol{
        function __construct()
            {
              parent::__construct();
              $this->load->model("login_model");
              $this->load->model("admin/base_model");
              $this->load->library('user_agent');
              $this->load->library('upload');
            }

          public function view_icategory(){

             if(!empty($this->session->userdata('admin_data'))){


               $data['user_name']=$this->load->get_var('user_name');

               // echo SITE_NAME;
               // echo $this->session->userdata('image');
               // echo $this->session->userdata('position');
               // exit;

                //             $this->db->select('*');
                // $this->db->from('tbl_inventory');
                // //$this->db->where('id',$usr);
                // $data['inventory_data']= $this->db->get();

                            $this->db->select('*');
                $this->db->from('tbl_category');
                //$this->db->where('id',$usr);
                $data['inventory_data']= $this->db->get();

               $this->load->view('admin/common/header_view',$data);
               $this->load->view('admin/inventory/view_icategory');
               $this->load->view('admin/common/footer_view');

           }
           else{

              redirect("login/admin_login","refresh");
           }

           }





public function view_iproducts($idd){

                 if(!empty($this->session->userdata('admin_data'))){

                   $data['user_name']=$this->load->get_var('user_name');

                   // echo SITE_NAME;
                   // echo $this->session->userdata('image');
                   // echo $this->session->userdata('position');
                   // exit;
                   $id=base64_decode($idd);


            $this->db->select('*');
$this->db->from('tbl_products');
$this->db->where('category_id',$id);
$data['product_list']= $this->db->get();



                   $this->load->view('admin/common/header_view',$data);
                   $this->load->view('admin/inventory/view_iproducts');
                   $this->load->view('admin/common/footer_view');

               }
               else{

                  redirect("login/admin_login","refresh");
               }

               }

               public function update_inventory($idd){

                                if(!empty($this->session->userdata('admin_data'))){

 $id=base64_decode($idd);
$data['id']=$idd;
// echo $id;
// exit;
//                                   $data['user_name']=$this->load->get_var('user_name');

                                  // echo SITE_NAME;
                                  // echo $this->session->userdata('image');
                                  // echo $this->session->userdata('position');
                                  // exit;
            $this->db->select('*');
$this->db->from('tbl_inventory');
$this->db->where('product_id',$id);
$data['inventory_data']= $this->db->get()->row();

                                  $this->load->view('admin/common/header_view',$data);
                                  $this->load->view('admin/inventory/update_inventory');
                                  $this->load->view('admin/common/footer_view');

                              }
                              else{

                                 redirect("login/admin_login","refresh");
                              }

                              }

            public function add_inventory_data($t)

              {

                if(!empty($this->session->userdata('admin_data'))){


            $this->load->helper(array('form', 'url'));
            $this->load->library('form_validation');
            $this->load->helper('security');
            if($this->input->post())
            {
              // print_r($this->input->post());
              // exit;
              $this->form_validation->set_rules('quantity', 'quantity', 'required|xss_clean');

              if($this->form_validation->run()== TRUE)
              {
                $quantity=$this->input->post('quantity');
                // $passw=$this->input->post('password');

                  $ip = $this->input->ip_address();
          date_default_timezone_set("Asia/Calcutta");
                  $cur_date=date("Y-m-d H:i:s");

                  $addedby=$this->session->userdata('admin_id');

          $typ=base64_decode($t);

          $data_insert = array('quantity'=>$quantity

                    );




            $this->db->where('product_id', $typ);
            $last_id=$this->db->update('tbl_inventory', $data_insert);


$this->db->select('*');
            $this->db->from('tbl_products');
            $this->db->where('id',$typ);
            $dsa= $this->db->get();
            $da=$dsa->row();
            $c=$da->category;

                              if($last_id!=0){

                              $this->session->set_flashdata('emessage','Data inserted successfully');

                              redirect("dcadmin/inventory/view_iproducts/".base64_encode($c),"refresh");

                                      }

                                      else

                                      {

                                   $this->session->set_flashdata('emessage','Sorry error occured');
                                     redirect($_SERVER['HTTP_REFERER']);


                                      }


              }
            else{

$this->session->set_flashdata('emessage',validation_errors());
     redirect($_SERVER['HTTP_REFERER']);

            }

            }
          else{

$this->session->set_flashdata('emessage','Please insert some data, No data available');
     redirect($_SERVER['HTTP_REFERER']);

          }
          }
          else{

      redirect("login/admin_login","refresh");


          }

          }





         }
