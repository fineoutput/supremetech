<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . 'core/CI_finecontrol.php');
class Products extends CI_finecontrol{
function __construct()
		{
			parent::__construct();
			$this->load->model("login_model");
			$this->load->model("admin/base_model");
			$this->load->library('user_agent');
		}


    public function view_products(){

                     if(!empty($this->session->userdata('admin_data'))){


                       $data['user_name']=$this->load->get_var('user_name');

                       // echo SITE_NAME;
                       // echo $this->session->userdata('image');
                       // echo $this->session->userdata('position');
                       // exit;

											       			$this->db->select('*');
											 $this->db->from('tbl_products');
											 //$this->db->where('id',$usr);
											 $data['product_data']= $this->db->get();


                       $this->load->view('admin/common/header_view',$data);
                       $this->load->view('admin/products/view_products');
                       $this->load->view('admin/common/footer_view');

                   }
                   else{

                      redirect("login/admin_login","refresh");
                   }

                   }

public function add_products(){

                 if(!empty($this->session->userdata('admin_data'))){


                   $data['user_name']=$this->load->get_var('user_name');

                   // echo SITE_NAME;
                   // echo $this->session->userdata('image');
                   // echo $this->session->userdata('position');
                   // exit;
                            $this->db->select('*');
                  $this->db->from('tbl_subcategory');
                  //$this->db->where('id',$usr);
                  $data['subcategories_data']= $this->db->get();


                   $this->load->view('admin/common/header_view',$data);
                   $this->load->view('admin/products/add_products');
                   $this->load->view('admin/common/footer_view');

               }
               else{

                  redirect("login/admin_login","refresh");
               }

               }

      			public function add_product_data($t,$iw="")

              {

                if(!empty($this->session->userdata('admin_data'))){


          	$this->load->helper(array('form', 'url'));
            $this->load->library('form_validation');
            $this->load->helper('security');
            if($this->input->post())
            {
              // print_r($this->input->post());
              // exit;
              $this->form_validation->set_rules('title', 'title', 'required|xss_clean|trim');
              $this->form_validation->set_rules('mrp', 'mrp', 'required|xss_clean|trim');
              $this->form_validation->set_rules('sell_price', 'sell_price', 'required|xss_clean|trim');
							$this->form_validation->set_rules('description', 'description', 'required|xss_clean|trim');
              $this->form_validation->set_rules('model_no', 'model_no', 'required|xss_clean|trim');
              $this->form_validation->set_rules('subcategory_id', 'subcategory_id', 'required|xss_clean|trim');

              if($this->form_validation->run()== TRUE)
              {
                $title=$this->input->post('title');
                $mrp=$this->input->post('mrp');
								$sell_price=$this->input->post('sell_price');
								$description=$this->input->post('description');
                $model_no=$this->input->post('model_no');
                $subcategory_id=$this->input->post('subcategory_id');

                  // $ip = $this->input->ip_address();
          date_default_timezone_set("Asia/Calcutta");
                  $cur_date=date("Y-m-d H:i:s");

                  $addedby=$this->session->userdata('admin_id');

          $typ=base64_decode($t);
          if($typ==1){

          $data_insert = array('title'=>$title,
                    'mrp'=>$mrp,
                    'sell_price'=>$sell_price,
                    'description'=>$description,
                    'model_no' =>$model_no,
                    'subcategory_id' =>$subcategory_id,
                    'added_by' =>$addedby,
                    'is_active' =>1,
                    'date'=>$cur_date

                    );





          $last_id=$this->base_model->insert_table("tbl_products",$data_insert,1) ;

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

          $data_insert = array('title'=>$title,
                    'mrp'=>$mrp,
                    'sell_price'=>$sell_price,
                    'description'=>$description,
                    'model_no' =>$model_no,
                    'subcategory_id' =>$subcategory_id,
                    );




          	$this->db->where('id', $idw);
            $last_id=$this->db->update('tbl_products', $data_insert);

          }


                              if($last_id!=0){

                              $this->session->set_flashdata('smessage','Data inserted successfully');

                              redirect("dcadmin/products/view_products","refresh");

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


					public function update_products($idd){

					                 if(!empty($this->session->userdata('admin_data'))){


					                   $data['user_name']=$this->load->get_var('user_name');

					                   // echo SITE_NAME;
					                   // echo $this->session->userdata('image');
					                   // echo $this->session->userdata('position');
					                   // exit;

														  $id=base64_decode($idd);
														 $data['id']=$idd;

														 $this->db->select('*');
														             $this->db->from('tbl_products');
														             $this->db->where('id',$id);
														             $dsa= $this->db->get();
														             $data['product']=$dsa->row();

                                         $this->db->select('*');
                              $this->db->from('tbl_subcategory');
                               //$this->db->where('id',$usr);
                              $data['addsubcategories_data']= $this->db->get();


					                   $this->load->view('admin/common/header_view',$data);
					                   $this->load->view('admin/products/update_products');
					                   $this->load->view('admin/common/footer_view');

					               }
					               else{

					                  redirect("login/admin_login","refresh");
					               }

					               }

public function delete_products($idd){

       if(!empty($this->session->userdata('admin_data'))){


         $data['user_name']=$this->load->get_var('user_name');

         // echo SITE_NAME;
         // echo $this->session->userdata('image');
         // echo $this->session->userdata('position');
         // exit;
                 									 $id=base64_decode($idd);

        if($this->load->get_var('position')=="Super Admin"){

                         									 $zapak=$this->db->delete('tbl_products', array('id' => $id));
                         									 if($zapak!=0){

                         								 	redirect("dcadmin/products/view_products","refresh");
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

public function updateproductsStatus($idd,$t){

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
        $zapak=$this->db->update('tbl_products', $data_update);

             if($zapak!=0){
             redirect("dcadmin/products/view_products","refresh");
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
          $zapak=$this->db->update('tbl_products', $data_update);

              if($zapak!=0){
              redirect("dcadmin/products/view_products","refresh");
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
