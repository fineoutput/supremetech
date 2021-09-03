<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . 'core/CI_finecontrol.php');
class Vendors extends CI_finecontrol{
function __construct()
		{
			parent::__construct();
			$this->load->model("login_model");
			$this->load->model("admin/base_model");
			$this->load->library('user_agent');
		}


    public function view_vendors(){

                     if(!empty($this->session->userdata('admin_data'))){


                       $data['user_name']=$this->load->get_var('user_name');

                       // echo SITE_NAME;
                       // echo $this->session->userdata('image');
                       // echo $this->session->userdata('position');
                       // exit;

											       			$this->db->select('*');
											 $this->db->from('tbl_vendors');
											 //$this->db->where('id',$usr);
											 $data['vendors_data']= $this->db->get();


                       $this->load->view('admin/common/header_view',$data);
                       $this->load->view('admin/vendors/view_vendors');
                       $this->load->view('admin/common/footer_view');

                   }
                   else{

                      redirect("login/admin_login","refresh");
                   }

                   }

public function add_sellers(){

                 if(!empty($this->session->userdata('admin_data'))){


                   $data['user_name']=$this->load->get_var('user_name');

                   // echo SITE_NAME;
                   // echo $this->session->userdata('image');
                   // echo $this->session->userdata('position');
                   // exit;


                   $this->load->view('admin/common/header_view',$data);
                   $this->load->view('admin/vendors/add_vendors');
                   $this->load->view('admin/common/footer_view');

               }
               else{

                  redirect("login/admin_login","refresh");
               }

               }

      			public function add_seller_data($t,$iw="")

              {

                if(!empty($this->session->userdata('admin_data'))){


          	$this->load->helper(array('form', 'url'));
            $this->load->library('form_validation');
            $this->load->helper('security');
            if($this->input->post())
            {
              // print_r($this->input->post());
              // exit;
              $this->form_validation->set_rules('name', 'name', 'required|xss_clean|trim');
              $this->form_validation->set_rules('email', 'email', 'required|valid_email|xss_clean|trim');
              $this->form_validation->set_rules('phone', 'phone', 'required|xss_clean|trim');
							$this->form_validation->set_rules('address', 'address', 'required|xss_clean|trim');

              if($this->form_validation->run()== TRUE)
              {
                $name=$this->input->post('name');
                $email=$this->input->post('email');
								$phone=$this->input->post('phone');
								$address=$this->input->post('address');

                  $ip = $this->input->ip_address();
          date_default_timezone_set("Asia/Calcutta");
                  $cur_date=date("Y-m-d H:i:s");

                  $addedby=$this->session->userdata('admin_id');

          $typ=base64_decode($t);
          if($typ==1){

          $data_insert = array('name'=>$name,
                    'phone'=>$phone,
                    'address'=>$address,
                    'email'=>$email,
                    'ip' =>$ip,
                    'added_by' =>$addedby,
                    'is_active' =>1,
                    'date'=>$cur_date

                    );





          $last_id=$this->base_model->insert_table("tbl_sellers",$data_insert,1) ;

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

          $data_insert = array('name'=>$name,
                    'phone'=>$phone,
                    'address'=>$address,
                    'email'=>$email
                    );




          	$this->db->where('id', $idw);
            $last_id=$this->db->update('tbl_sellers', $data_insert);

          }


                              if($last_id!=0){

                              $this->session->set_flashdata('smessage','Data inserted successfully');

                              redirect("dcadmin/sellers/view_sellers","refresh");

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


					public function update_sellers($idd){

					                 if(!empty($this->session->userdata('admin_data'))){


					                   $data['user_name']=$this->load->get_var('user_name');

					                   // echo SITE_NAME;
					                   // echo $this->session->userdata('image');
					                   // echo $this->session->userdata('position');
					                   // exit;

														  $id=base64_decode($idd);
														 $data['id']=$idd;

														 $this->db->select('*');
														             $this->db->from('tbl_vendors');
														             $this->db->where('id',$id);
														             $dsa= $this->db->get();
														             $data['vendors']=$dsa->row();


					                   $this->load->view('admin/common/header_view',$data);
					                   $this->load->view('admin/vendors/update_vendors');
					                   $this->load->view('admin/common/footer_view');

					               }
					               else{

					                  redirect("login/admin_login","refresh");
					               }

					               }

public function delete_vendors($idd){

       if(!empty($this->session->userdata('admin_data'))){


         $data['user_name']=$this->load->get_var('user_name');

         // echo SITE_NAME;
         // echo $this->session->userdata('image');
         // echo $this->session->userdata('position');
         // exit;
                 									 $id=base64_decode($idd);

        if($this->load->get_var('position')=="Super Admin"){

                         									 $zapak=$this->db->delete('tbl_vendors', array('id' => $id));
                         									 if($zapak!=0){

                         								 	redirect("dcadmin/vendors/view_vendors","refresh");
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

public function updatevendorsStatus($idd,$t){

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
        $zapak=$this->db->update('tbl_vendors', $data_update);

             if($zapak!=0){
             redirect("dcadmin/vendors/view_vendors","refresh");
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
          $zapak=$this->db->update('tbl_vendors', $data_update);

              if($zapak!=0){
              redirect("dcadmin/vendors/view_vendors","refresh");
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

public function updateVendorRequestStatus($idd,$stat){

         if(!empty($this->session->userdata('admin_data'))){


           $data['user_name']=$this->load->get_var('user_name');

           // echo SITE_NAME;
           // echo $this->session->userdata('image');
           // echo $this->session->userdata('position');
           // exit;
           $id=base64_decode($idd);

           if($stat=="approved"){

             $data_update = array(
         'status'=>1

         );

         $this->db->where('id', $id);
        $zapak=$this->db->update('tbl_vendors', $data_update);

             if($zapak!=0){
             redirect("dcadmin/vendors/view_vendors","refresh");
                     }
                     else
                     {
                       echo "Error";
                       exit;
                     }
           }
           if($stat=="pending"){
             $data_update = array(
          'status'=>2

          );

          $this->db->where('id', $id);
          $zapak=$this->db->update('tbl_vendors', $data_update);

              if($zapak!=0){
              redirect("dcadmin/vendors/view_vendors","refresh");
                      }
                      else
                      {

          $data['e']="Error Occured";
                          	// exit;
        	$this->load->view('errors/error500admin',$data);
                      }
           }
					 if($stat=="reject"){
             $data_update = array(
          'status'=>3

          );

          $this->db->where('id', $id);
          $zapak=$this->db->update('tbl_vendors', $data_update);

              if($zapak!=0){
              redirect("dcadmin/vendors/view_vendors","refresh");
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
