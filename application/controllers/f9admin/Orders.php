<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . 'core/CI_finecontrol.php');
class Orders extends CI_finecontrol{
function __construct()
		{
			parent::__construct();
			$this->load->model("login_model");
			$this->load->model("admin/base_model");
			$this->load->library('user_agent');
		}


    public function view_orders(){

                     if(!empty($this->session->userdata('admin_data'))){


                       $data['user_name']=$this->load->get_var('user_name');

                       // echo SITE_NAME;
                       // echo $this->session->userdata('image');
                       // echo $this->session->userdata('position');
                       // exit;

											       			$this->db->select('*');
											 $this->db->from('tbl_orders');
											 //$this->db->where('id',$usr);
											 $data['orders_data']= $this->db->get();


                       $this->load->view('admin/common/header_view',$data);
                       $this->load->view('admin/orders/view_orders');
                       $this->load->view('admin/common/footer_view');

                   }
                   else{

                      redirect("login/admin_login","refresh");
                   }

                   }

public function add_coupon(){

                 if(!empty($this->session->userdata('admin_data'))){


                   $data['user_name']=$this->load->get_var('user_name');

                   // echo SITE_NAME;
                   // echo $this->session->userdata('image');
                   // echo $this->session->userdata('position');
                   // exit;


                   $this->load->view('admin/common/header_view',$data);
                   $this->load->view('admin/coupon/add_coupon');
                   $this->load->view('admin/common/footer_view');

               }
               else{

                  redirect("login/admin_login","refresh");
               }

               }

      			public function add_coupon_data($t,$iw="")

              {

                if(!empty($this->session->userdata('admin_data'))){


          	$this->load->helper(array('form', 'url'));
            $this->load->library('form_validation');
            $this->load->helper('security');
            if($this->input->post())
            {
              // print_r($this->input->post());
              // exit;
              $this->form_validation->set_rules('promocode', 'promocode', 'required|xss_clean|trim');
              $this->form_validation->set_rules('min_cart_amount', 'min_cart_amount', 'required|xss_clean|trim');
              $this->form_validation->set_rules('discount_percent', 'discount_percent', 'required|xss_clean|trim');
							$this->form_validation->set_rules('maximum_discount', 'maximum_discount', 'required|xss_clean|trim');
              $this->form_validation->set_rules('start_date', 'start_date', 'required|xss_clean|trim');
              $this->form_validation->set_rules('end_date', 'end_date', 'required|xss_clean|trim');

              if($this->form_validation->run()== TRUE)
              {
                $promocode=$this->input->post('promocode');
                $min_cart_amount=$this->input->post('min_cart_amount');
								$discount_percent=$this->input->post('discount_percent');
								$maximum_discount=$this->input->post('maximum_discount');
                $start_date=$this->input->post('start_date');
                $end_date=$this->input->post('end_date');

                  // $ip = $this->input->ip_address();
          date_default_timezone_set("Asia/Calcutta");
                  $cur_date=date("Y-m-d H:i:s");

                  $addedby=$this->session->userdata('admin_id');

          $typ=base64_decode($t);
          if($typ==1){

          $data_insert = array('promocode'=>$promocode,
                    'min_cart_amount'=>$min_cart_amount,
                    'discount_percent'=>$discount_percent,
                    'maximum_discount'=>$maximum_discount,
                    'start_date' =>$start_date,
                    'end_date' =>$end_date,
                    'added_by' =>$addedby,
                    'is_active' =>1,
                    'date'=>$cur_date

                    );





          $last_id=$this->base_model->insert_table("tbl_coupon",$data_insert,1) ;

          }
          if($typ==2){

   $idw=base64_decode($iw);

// $this->db->select('*');
//     $this->db->from('tbl_minor_category');
//    $this->db->where('name',$name);
//     $damm= $this->db->get();
//    foreach($damm->result() as $da) {
//      $uid=$da->id;
// if($uid==$idw)
// {
//
//  }
// else{
//    echo "Multiple Entry of Same Name";
//       exit;
//  }
//     }

          $data_insert = array('promocode'=>$promocode,
                    'min_cart_amount'=>$min_cart_amount,
                    'discount_percent'=>$discount_percent,
                    'maximum_discount'=>$maximum_discount,
                    'start_date' =>$start_date,
                    'end_date' =>$end_date,
                    );




          	$this->db->where('id', $idw);
            $last_id=$this->db->update('tbl_coupon', $data_insert);

          }


                              if($last_id!=0){

                              $this->session->set_flashdata('smessage','Data inserted successfully');

                              redirect("dcadmin/coupon/view_coupon","refresh");

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


					public function update_coupon($idd){

					                 if(!empty($this->session->userdata('admin_data'))){


					                   $data['user_name']=$this->load->get_var('user_name');

					                   // echo SITE_NAME;
					                   // echo $this->session->userdata('image');
					                   // echo $this->session->userdata('position');
					                   // exit;

														  $id=base64_decode($idd);
														 $data['id']=$idd;

														 $this->db->select('*');
														             $this->db->from('tbl_coupon');
														             $this->db->where('id',$id);
														             $dsa= $this->db->get();
														             $data['coupon']=$dsa->row();


					                   $this->load->view('admin/common/header_view',$data);
					                   $this->load->view('admin/coupon/update_coupon');
					                   $this->load->view('admin/common/footer_view');

					               }
					               else{

					                  redirect("login/admin_login","refresh");
					               }

					               }

public function delete_orders($idd){

       if(!empty($this->session->userdata('admin_data'))){


         $data['user_name']=$this->load->get_var('user_name');

         // echo SITE_NAME;
         // echo $this->session->userdata('image');
         // echo $this->session->userdata('position');
         // exit;
                 									 $id=base64_decode($idd);

        if($this->load->get_var('position')=="Super Admin"){

                         									 $zapak=$this->db->delete('tbl_orders', array('id' => $id));
                         									 if($zapak!=0){

                         								 	redirect("dcadmin/orders/view_orders","refresh");
                         								 					}
                         								 					else
                         								 					{
                         								 						echo "Error";
                         								 						exit;
                         								 					}
                       }
                       else{
                       $data['e']="Sorry You Don't Have Permission To Delete Anything.";
                       	// exit;
                       	$this->load->view('errors/error500admin',$data);
                       }


             }
             else{

                 $this->load->view('admin/login/index');
             }

             }

public function updateorderStatus($idd,$t){

         if(!empty($this->session->userdata('admin_data'))){


           $data['user_name']=$this->load->get_var('user_name');

           // echo SITE_NAME;
           // echo $this->session->userdata('image');
           // echo $this->session->userdata('position');
           // exit;
           $id=base64_decode($idd);

           if($t=="active"){

             $data_update = array(
         'is_active'=>1

         );

         $this->db->where('id', $id);
        $zapak=$this->db->update('tbl_orders', $data_update);

             if($zapak!=0){
             redirect("dcadmin/orders/view_orders","refresh");
                     }
                     else
                     {
                       echo "Error";
                       exit;
                     }
           }
           if($t=="inactive"){
             $data_update = array(
          'is_active'=>0

          );

          $this->db->where('id', $id);
          $zapak=$this->db->update('tbl_orders', $data_update);

              if($zapak!=0){
              redirect("dcadmin/orders/view_orders","refresh");
                      }
                      else
                      {

          $data['e']="Error Occured";
                          	// exit;
        	$this->load->view('errors/error500admin',$data);
                      }
           }



       }
       else{

           $this->load->view('admin/login/index');
       }

       }

public function updateorderprocessStatus($idd,$status){

                if(!empty($this->session->userdata('admin_data'))){


                  $data['user_name']=$this->load->get_var('user_name');

                  // echo SITE_NAME;
                  // echo $this->session->userdata('image');
                  // echo $this->session->userdata('position');
                  // exit;
                  $id=base64_decode($idd);

                  if($status=="approved"){

                    $data_update = array(
                'order_status'=>1

                );

                $this->db->where('id', $id);
               $zapak=$this->db->update('tbl_orders', $data_update);

                    if($zapak!=0){
                    redirect("dcadmin/orders/view_orders","refresh");
                            }
                            else
                            {
                              echo "Error";
                              exit;
                            }
                  }
                  if($status=="hold"){

                    $data_update = array(
                'order_status'=>2

                );

                $this->db->where('id', $id);
               $zapak=$this->db->update('tbl_orders', $data_update);

                    if($zapak!=0){
                    redirect("dcadmin/orders/view_orders","refresh");
                            }
                            else
                            {
                              echo "Error";
                              exit;
                            }
                  }
                  if($status=="dispatch"){

                    $data_update = array(
                'order_status'=>3

                );

                $this->db->where('id', $id);
               $zapak=$this->db->update('tbl_orders', $data_update);

                    if($zapak!=0){
                    redirect("dcadmin/orders/view_orders","refresh");
                            }
                            else
                            {
                              echo "Error";
                              exit;
                            }
                  }
                  if($status=="reject"){
                    $data_update = array(
                 'order_status'=>4

                 );

                 $this->db->where('id', $id);
                 $zapak=$this->db->update('tbl_orders', $data_update);

                     if($zapak!=0){
                     redirect("dcadmin/orders/view_orders","refresh");
                             }
                             else
                             {

                 $data['e']="Error Occured";
                                 	// exit;
               	$this->load->view('errors/error500admin',$data);
                             }
                  }



              }
              else{

                  $this->load->view('admin/login/index');
              }

              }



       }

}
