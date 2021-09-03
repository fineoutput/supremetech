<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . 'core/CI_finecontrol.php');
class Category extends CI_finecontrol{
function __construct()
		{
			parent::__construct();
			$this->load->model("login_model");
			$this->load->model("admin/base_model");
			$this->load->library('user_agent');
		}


    public function view_category(){

                     if(!empty($this->session->userdata('admin_data'))){


                       $data['user_name']=$this->load->get_var('user_name');

                       // echo SITE_NAME;
                       // echo $this->session->userdata('image');
                       // echo $this->session->userdata('position');
                       // exit;

											       			$this->db->select('*');
											 $this->db->from('tbl_category');
											 //$this->db->where('id',$usr);
											 $data['category_data']= $this->db->get();


                       $this->load->view('admin/common/header_view',$data);
                       $this->load->view('admin/category/view_category');
                       $this->load->view('admin/common/footer_view');

                   }
                   else{

                      redirect("login/admin_login","refresh");
                   }

                   }

public function view_subcategory($idd){

							                      if(!empty($this->session->userdata('admin_data'))){


							                        $data['user_name']=$this->load->get_var('user_name');

							                        // echo SITE_NAME;
							                        // echo $this->session->userdata('image');
							                        // echo $this->session->userdata('position');
							                        // exit;

							 											       			$this->db->select('*');
							 											 $this->db->from('tbl_subcategory');
							 											 $this->db->where('category_id',$idd);
							 											 $data['subcategory_data']= $this->db->get();

																		 // print_r($data);
																		 // die;


							                        $this->load->view('admin/common/header_view',$data);
							                        $this->load->view('admin/category/view_subcategory');
							                        $this->load->view('admin/common/footer_view');

							                    }
							                    else{

							                       redirect("login/admin_login","refresh");
							                    }

							                    }

public function add_subcategory(){

				if(!empty($this->session->userdata('admin_data'))){


						$data['user_name']=$this->load->get_var('user_name');

						// echo SITE_NAME;
						// echo $this->session->userdata('image');
						// echo $this->session->userdata('position');
						// exit;

						$this->db->select('*');
						$this->db->from('tbl_category');
						// $this->db->where('category_id',$idd);
						$data['categories_data']= $this->db->get();


						$this->load->view('admin/common/header_view',$data);
						$this->load->view('admin/category/add_subcategory');
						$this->load->view('admin/common/footer_view');

					}
					else{

							redirect("login/admin_login","refresh");
					}

				}

				public function add_subcategory_data($t,$iw="")

					{

						if(!empty($this->session->userdata('admin_data'))){


							$this->load->helper(array('form', 'url'));
							$this->load->library('form_validation');
							$this->load->helper('security');
							if($this->input->post())
							{

								$this->form_validation->set_rules('title', 'title', 'required|xss_clean|trim');
								$this->form_validation->set_rules('category_id', 'category_id', 'required|xss_clean|trim');

								if($this->form_validation->run()== TRUE)
								{
									$subtitle=$this->input->post('title');
									$category_id=$this->input->post('category_id');

									$subimage = time() . '_' . $_FILES["subimage"]["name"];
									$liciense_tmp_name = $_FILES["subimage"]["tmp_name"];
									$error = $_FILES["subimage"]["error"];
									$liciense_path = 'assets/admin/category/' . $subimage;
									move_uploaded_file($liciense_tmp_name, $liciense_path);
									$categoryimage = $liciense_path;



							// $ip = $this->input->ip_address();
			date_default_timezone_set("Asia/Calcutta");
							$cur_date=date("Y-m-d H:i:s");

							$addedby=$this->session->userdata('admin_id');

			$typ=base64_decode($t);
			if($typ==1){

			$data_insert = array('title'=>$subtitle,
								'image'=>$categoryimage,
								'category_id'=>$category_id,
								'added_by' =>$addedby,
								'is_active' =>1,
								'date'=>$cur_date
								);





			$last_id=$this->base_model->insert_table("tbl_subcategory",$data_insert,1) ;

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

			$data_insert = array('title'=>$subtitle,
								'image'=>$categoryimage,
								'category_id'=>$category_id
								);




				$this->db->where('id', $idw);
				$last_id=$this->db->update('tbl_subcategory', $data_insert);

			}


													if($last_id!=0){

													$this->session->set_flashdata('smessage','Data inserted successfully');

													redirect("dcadmin/category/view_category","refresh");

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


public function add_category(){

                 if(!empty($this->session->userdata('admin_data'))){


                   $data['user_name']=$this->load->get_var('user_name');

                   // echo SITE_NAME;
                   // echo $this->session->userdata('image');
                   // echo $this->session->userdata('position');
                   // exit;


                   $this->load->view('admin/common/header_view',$data);
                   $this->load->view('admin/category/add_category');
                   $this->load->view('admin/common/footer_view');

               }
               else{

                  redirect("login/admin_login","refresh");
               }

               }

      			public function add_category_data($t,$iw="")

              {

                if(!empty($this->session->userdata('admin_data'))){


          	$this->load->helper(array('form', 'url'));
            $this->load->library('form_validation');
            $this->load->helper('security');
            if($this->input->post())
            {

              $this->form_validation->set_rules('title', 'title', 'required|xss_clean|trim');

              if($this->form_validation->run()== TRUE)
              {
                $title=$this->input->post('title');

                  $banner = time() . '_' . $_FILES["image"]["name"];
					        $liciense_tmp_name = $_FILES["image"]["tmp_name"];
					        $error = $_FILES["image"]["error"];
					        $liciense_path = 'assets/admin/category/' . $banner;
					        move_uploaded_file($liciense_tmp_name, $liciense_path);
					        $image = $liciense_path;



                  $ip = $this->input->ip_address();
          date_default_timezone_set("Asia/Calcutta");
                  $cur_date=date("Y-m-d H:i:s");

                  $addedby=$this->session->userdata('admin_id');

          $typ=base64_decode($t);
          if($typ==1){

          $data_insert = array('title'=>$title,
                    'image'=>$image,
                    'added_by' =>$addedby,
                    'is_active' =>1,
                    'date'=>$cur_date
                    );





          $last_id=$this->base_model->insert_table("tbl_category",$data_insert,1) ;

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

          $data_insert = array('Title'=>$title,
                    'image'=>$image,
                    );




          	$this->db->where('id', $idw);
            $last_id=$this->db->update('tbl_category', $data_insert);

          }


                              if($last_id!=0){

                              $this->session->set_flashdata('smessage','Data inserted successfully');

                              redirect("dcadmin/category/view_category","refresh");

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

					public function update_subcategory($idd){

					                 if(!empty($this->session->userdata('admin_data'))){


					                   $data['user_name']=$this->load->get_var('user_name');

					                   // echo SITE_NAME;
					                   // echo $this->session->userdata('image');
					                   // echo $this->session->userdata('position');
					                   // exit;

														  $id=base64_decode($idd);
														 $data['id']=$idd;

														 $this->db->select('*');
														             $this->db->from('tbl_subcategory');
														             $this->db->where('id',$id);
														             $dsa= $this->db->get();
														             $data['subcategory']=$dsa->row();

																				 $this->db->select('*');
														 						$this->db->from('tbl_category');
														 						// $this->db->where('category_id',$idd);
														 						$data['addcategories_data']= $this->db->get();


					                   $this->load->view('admin/common/header_view',$data);
					                   $this->load->view('admin/category/update_subcategory');
					                   $this->load->view('admin/common/footer_view');

					               }
					               else{

					                  redirect("login/admin_login","refresh");
					               }

					               }


					public function update_category($idd){

					                 if(!empty($this->session->userdata('admin_data'))){


					                   $data['user_name']=$this->load->get_var('user_name');

					                   // echo SITE_NAME;
					                   // echo $this->session->userdata('image');
					                   // echo $this->session->userdata('position');
					                   // exit;

														  $id=base64_decode($idd);
														 $data['id']=$idd;

														 $this->db->select('*');
														             $this->db->from('tbl_category');
														             $this->db->where('id',$id);
														             $dsa= $this->db->get();
														             $data['category']=$dsa->row();


					                   $this->load->view('admin/common/header_view',$data);
					                   $this->load->view('admin/category/update_category');
					                   $this->load->view('admin/common/footer_view');

					               }
					               else{

					                  redirect("login/admin_login","refresh");
					               }

					               }

public function delete_category($idd){

       if(!empty($this->session->userdata('admin_data'))){


         $data['user_name']=$this->load->get_var('user_name');

         // echo SITE_NAME;
         // echo $this->session->userdata('image');
         // echo $this->session->userdata('position');
         // exit;
                 									 $id=base64_decode($idd);

        if($this->load->get_var('position')=="Super Admin"){

                         									 $zapak=$this->db->delete('tbl_category', array('id' => $id));
                         									 if($zapak!=0){

                         								 	redirect("dcadmin/category/view_category","refresh");
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

						 public function delete_subcategory($idd){

						        if(!empty($this->session->userdata('admin_data'))){


						          $data['user_name']=$this->load->get_var('user_name');

						          // echo SITE_NAME;
						          // echo $this->session->userdata('image');
						          // echo $this->session->userdata('position');
						          // exit;
						                  									 $id=base64_decode($idd);

						         if($this->load->get_var('position')=="Super Admin"){

						                          									 $zapak=$this->db->delete('tbl_subcategory', array('id' => $id));
						                          									 if($zapak!=0){

						                          								 	redirect("dcadmin/category/view_category","refresh");
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

public function updatecategoryStatus($idd,$t){

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
        $zapak=$this->db->update('tbl_category', $data_update);

             if($zapak!=0){
             redirect("dcadmin/category/view_category","refresh");
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
          $zapak=$this->db->update('tbl_category', $data_update);

              if($zapak!=0){
              redirect("dcadmin/category/view_category","refresh");
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

			 public function updatesubcategoryStatus($idd,$sub){

			          if(!empty($this->session->userdata('admin_data'))){


			            $data['user_name']=$this->load->get_var('user_name');

			            // echo SITE_NAME;
			            // echo $this->session->userdata('image');
			            // echo $this->session->userdata('position');
			            // exit;
			            $id=base64_decode($idd);

			            if($sub=="active"){

			              $data_update = array(
			          'is_active'=>1

			          );

			          $this->db->where('id', $id);
			         $zapak=$this->db->update('tbl_subcategory', $data_update);

			              if($zapak!=0){
			              redirect("dcadmin/category/view_category","refresh");
			                      }
			                      else
			                      {
			                        echo "Error";
			                        exit;
			                      }
			            }
			            if($sub=="inactive"){
			              $data_update = array(
			           'is_active'=>0

			           );

			           $this->db->where('id', $id);
			           $zapak=$this->db->update('tbl_subcategory', $data_update);

			               if($zapak!=0){
			               redirect("dcadmin/category/view_category","refresh");
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
