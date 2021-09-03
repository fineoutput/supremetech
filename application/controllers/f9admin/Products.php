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
// echo "hii";
// exit;

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

 public function view_inventory($innventory_id){

									 								 if(!empty($this->session->userdata('admin_data'))){


									 									 $data['user_name']=$this->load->get_var('user_name');

									 									 // echo SITE_NAME;
									 									 // echo $this->session->userdata('image');
									 									 // echo $this->session->userdata('position');
									 									 // exit;
																		 $id=base64_decode($innventory_id);
									 								 	$data['id']=$innventory_id;


									 															$this->db->select('*');
									 									 $this->db->from('tbl_inventory');
									 									 $this->db->where('product_id',$id);
									 									 $data['inventory_data']= $this->db->get();


									 									 $this->load->view('admin/common/header_view',$data);
									 									 $this->load->view('admin/products/view_inventory');
									 									 $this->load->view('admin/common/footer_view');

									 							 }
									 							 else{

									 									redirect("login/admin_login","refresh");
									 							 }

									 							 }

public function view_productstype($idds){

						if(!empty($this->session->userdata('admin_data'))){


									$data['user_name']=$this->load->get_var('user_name');

									$id=base64_decode($idds);
								 	$data['id']=$idds;

										$this->db->select('*');
										$this->db->from('tbl_productstype');
										$this->db->where('product_id',$id);
										$data['productstype_data']= $this->db->get();


										$this->load->view('admin/common/header_view',$data);
										$this->load->view('admin/products/view_productstype');
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

								// Load library
								$this->load->library('upload');

								$img1='image';

														$file_check=($_FILES['image']['error']);
														if($file_check!=4){
														$image_upload_folder = FCPATH . "assets/uploads/products/";
															if (!file_exists($image_upload_folder))
															{
																mkdir($image_upload_folder, DIR_WRITE_MODE, true);
															}
															$new_file_name="product".date("Ymdhms");
															$this->upload_config = array(
																	'upload_path'   => $image_upload_folder,
																	'file_name' => $new_file_name,
																	'allowed_types' =>'jpg|jpeg|png',
																	'max_size'      => 25000
															);
															$this->upload->initialize($this->upload_config);
															if (!$this->upload->do_upload($img1))
															{
																$upload_error = $this->upload->display_errors();
																// echo json_encode($upload_error);
																echo $upload_error;
															}
															else
															{

																$file_info = $this->upload->data();

																$productsimg = "assets/uploads/products/".$new_file_name.$file_info['file_ext'];
																// $file_info['new_name']=$videoNAmePath;
																// // $this->step6_model->updateappIconImage($imageNAmePath,$appInfoId);
																// $videoNAmePath=$file_info['file_name'];
																// echo json_encode($file_info);
															}
														}

								// $productsimg = time() . '_' . $_FILES["image"]["name"];
								// $liciense_tmp_name = $_FILES["image"]["tmp_name"];
								// $error = $_FILES["image"]["error"];
								// $liciense_path = 'assets/admin/products/' . $productsimg;
								// move_uploaded_file($liciense_tmp_name, $liciense_path);
								// $prdctimage = $liciense_path;

                  $ip = $this->input->ip_address();
          date_default_timezone_set("Asia/Calcutta");
                  $cur_date=date("Y-m-d H:i:s");

                  $addedby=$this->session->userdata('admin_id');

          $typ=base64_decode($t);
          if($typ==1){

          $data_insert = array('title'=>$title,
                    'mrp'=>$mrp,
										'image'=>$productsimg,
                    'sell_price'=>$sell_price,
                    'description'=>$description,
                    'model_no' =>$model_no,
                    'subcategory_id' =>$subcategory_id,
										'ip'=>$ip,
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
										'image'=>$productsimg,
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

					public function add_productstype($idd){

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
																				 // print_r();


					                   $this->load->view('admin/common/header_view',$data);
					                   $this->load->view('admin/products/add_productstype');
					                   $this->load->view('admin/common/footer_view');

					               }
					               else{

					                  redirect("login/admin_login","refresh");
					               }

					               }

					      			public function add_productstype_data($t,$iw="")

					              {

					                if(!empty($this->session->userdata('admin_data'))){


					          	$this->load->helper(array('form', 'url'));
					            $this->load->library('form_validation');
					            $this->load->helper('security');
					            if($this->input->post())
					            {
					              // print_r($this->input->post());
					              // exit;
					              $this->form_validation->set_rules('product_id', 'product_id', 'required|xss_clean|trim');
					              $this->form_validation->set_rules('type', 'type', 'required|xss_clean|trim');
												$this->form_validation->set_rules('gst_percentage', 'gst_percentage', 'required|xss_clean|trim');
												$this->form_validation->set_rules('total_price', 'total_price', 'required|xss_clean|trim');

					              if($this->form_validation->run()== TRUE)
					              {
													$prdctidd = base64_decode($this->input->post('product_id'));
					                $product_id=$prdctidd;
					                $type=$this->input->post('type');
													$gst_percentage=$this->input->post('gst_percentage');
													$total_price=$this->input->post('total_price');

					                  $ip = $this->input->ip_address();
					          date_default_timezone_set("Asia/Calcutta");
					                  $cur_date=date("Y-m-d H:i:s");

					                  $addedby=$this->session->userdata('admin_id');

					          $typ=base64_decode($t);
					          if($typ==1){

					          $data_insert = array('product_id'=>$product_id,
															'gst_percentage'=>$gst_percentage,
															'total_price'=>$total_price,
					                    'type'=>$type,
															'ip'=>$ip,
					                    'added_by' =>$addedby,
					                    'is_active' =>1,
					                    'date'=>$cur_date

					                    );





					          $last_id=$this->base_model->insert_table("tbl_productstype",$data_insert,1) ;

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

					          $data_insert = array('product_id'=>$product_id,
					                    'type'=>$type,
															'total_price'=>$total_price,
															'gst_percentage'=>$gst_percentage
					                    );




					          	$this->db->where('id', $idw);
					            $last_id=$this->db->update('tbl_productstype', $data_insert);

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


public function add_inventory($ad_id){

					                 if(!empty($this->session->userdata('admin_data'))){


					                   $data['user_name']=$this->load->get_var('user_name');

														 // $data['productt_id'] = $id;

					                   // echo SITE_NAME;
					                   // echo $this->session->userdata('image');
					                   // echo $this->session->userdata('position');
					                   // exit;
														 $id=base64_decode($ad_id);
 													 	$data['id']=$ad_id;


					                   $this->load->view('admin/common/header_view',$data);
					                   $this->load->view('admin/products/add_inventory');
					                   $this->load->view('admin/common/footer_view');

					               }
					               else{

					                  redirect("login/admin_login","refresh");
					               }

					               }

public function add_inventory_data($t,$iw="")

					              {

					                if(!empty($this->session->userdata('admin_data'))){


					          	$this->load->helper(array('form', 'url'));
					            $this->load->library('form_validation');
					            $this->load->helper('security');
					            if($this->input->post())
					            {
					              // print_r($this->input->post());
					              // exit;
					              $this->form_validation->set_rules('stocks', 'stocks', 'required|xss_clean|trim');
					              $this->form_validation->set_rules('model_no', 'model_no', 'required|xss_clean|trim');
					              $this->form_validation->set_rules('colour', 'colour', 'required|xss_clean|trim');

					              if($this->form_validation->run()== TRUE)
					              {
													$productttt_ids = base64_decode($this->input->post('product_id'));
					                $stocks=$this->input->post('stocks');
					                $model_no=$this->input->post('model_no');
													$colour=$this->input->post('colour');
													$product_idds = $product_id;

					                  $ip = $this->input->ip_address();
					          date_default_timezone_set("Asia/Calcutta");
					                  $cur_date=date("Y-m-d H:i:s");

					                  $addedby=$this->session->userdata('admin_id');

					          $typ=base64_decode($t);
					          if($typ==1){

					          $data_insert = array('stocks'=>$stocks,
					                    'model_no'=>$model_no,
															'colour'=>$colour,
															'product_id'=>$productttt_ids,
															'ip'=>$ip,
					                    'added_by' =>$addedby,
					                    'is_active' =>1,
					                    'date'=>$cur_date

					                    );


					          $last_id=$this->base_model->insert_table("tbl_inventory",$data_insert,1) ;

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

					          $data_insert = array('stocks'=>$stocks,
					                    'model_no'=>$model_no,
															'colour'=>$colour,
					                    );




					          	$this->db->where('id', $idw);
					            $last_id=$this->db->update('tbl_inventory', $data_insert);

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

										public function update_inventory($idd){

																		 if(!empty($this->session->userdata('admin_data'))){


																			 $data['user_name']=$this->load->get_var('user_name');

																			 // echo SITE_NAME;
																			 // echo $this->session->userdata('image');
																			 // echo $this->session->userdata('position');
																			 // exit;

																				$id=base64_decode($idd);
																			 $data['id']=$idd;

																			 $this->db->select('*');
																									 $this->db->from('tbl_inventory');
																									 $this->db->where('id',$id);
																									 $dsa= $this->db->get();
																									 $data['inventory']=$dsa->row();


																			 $this->load->view('admin/common/header_view',$data);
																			 $this->load->view('admin/products/update_inventory');
																			 $this->load->view('admin/common/footer_view');

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

public function delete_inventory($idd){



												        if(!empty($this->session->userdata('admin_data'))){


												          $data['user_name']=$this->load->get_var('user_name');

												          // echo SITE_NAME;
												          // echo $this->session->userdata('image');
												          // echo $this->session->userdata('position');
												          // exit;
												                  									 $id=base64_decode($idd);

												         if($this->load->get_var('position')=="Super Admin"){

												             $zapak=$this->db->delete('tbl_inventory', array('id' => $id));
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

						 public function delete_productstype($idd){



						        if(!empty($this->session->userdata('admin_data'))){


						          $data['user_name']=$this->load->get_var('user_name');

						          // echo SITE_NAME;
						          // echo $this->session->userdata('image');
						          // echo $this->session->userdata('position');
						          // exit;
						                  									 $id=base64_decode($idd);

						         if($this->load->get_var('position')=="Super Admin"){

						                          									 $zapak=$this->db->delete('tbl_productstype', array('id' => $id));
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

			 public function updateproductsinventoryStatus($idd,$t){

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
			         $zapak=$this->db->update('tbl_inventory', $data_update);

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
			           $zapak=$this->db->update('tbl_inventory', $data_update);

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

							public function updateproductstypeStatus($idd,$t){

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
							        $zapak=$this->db->update('tbl_productstype', $data_update);

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
							          $zapak=$this->db->update('tbl_productstype', $data_update);

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
