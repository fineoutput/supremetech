<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . 'core/CI_finecontrol.php');
class Messages extends CI_finecontrol{
function __construct()
		{
			parent::__construct();
			$this->load->model("login_model");
			$this->load->model("admin/base_model");
			$this->load->library('user_agent');
		}

public function index(){

                 if(!empty($this->session->userdata('admin_data'))){


                   $data['user_name']=$this->load->get_var('user_name');

                   // echo SITE_NAME;
                   // echo $this->session->userdata('image');
                   // echo $this->session->userdata('position');
                   // exit;
            $this->db->select('*');
						$this->db->from('tbl_team');
						// $this->db->where('id',$usr);
						$data['team_data']= $this->db->get();

                   $this->load->view('admin/common/header_view',$data);
                   $this->load->view('admin/messages/view_messages');
                   $this->load->view('admin/common/footer_view');

               }
               else{

                   $this->load->view('admin/login/index');
               }

               }

							 public function view_team_messages($idd){

							                  if(!empty($this->session->userdata('admin_data'))){

							 $id=base64_decode($idd);
							                    $data['user_name']=$this->load->get_var('user_name');
																	$usr_id=$this->session->userdata('user_id');

																		$data['id']=$id;
																		// echo $data['id'];
																		$data['usr_id']=$usr_id;
																		// echo $data['usr_id'];
								      			$this->db->select('*');
								$this->db->from('tbl_team_messages');
								$this->db->or_where('from_id', $usr_id);
								$this->db->or_where('from_id', $id);
								$this->db->or_where('to_id', $id);
								$this->db->or_where('to_id', $usr_id);
								// $where = "from_id=$id AND to_id=$usr_id OR from_id=$usr_id AND to_id=$id";
								// $this->db->where($where);
								$data['team_msg']= $this->db->get();

								$this->db->select('*');
								$this->db->from('tbl_team');
								// $this->db->where('id',$usr);
								$data['team_data']= $this->db->get();
							                    // echo SITE_NAME;
							                    // echo $this->session->userdata('image');
							                    // echo $this->session->userdata('position');
							                    // exit;


							                    $this->load->view('admin/common/header_view',$data);
							                    $this->load->view('admin/messages/view_team_messages');
							                    $this->load->view('admin/common/footer_view');

							                }
							                else{

							                    $this->load->view('admin/login/index');
							                }

							                }



							public function send_msg($t)

							              {

							 if(!empty($this->session->userdata('admin_data'))){


							          	$this->load->helper(array('form', 'url'));
							            $this->load->library('form_validation');
							            $this->load->helper('security');
							            if($this->input->post())
							            {
							              // print_r($this->input->post());
							              // exit;
							              $this->form_validation->set_rules('msg', 'Message', 'required|xss_clean');
							              // $this->form_validation->set_rules('password', 'password Number', 'required|xss_clean');
							              // $this->form_validation->set_rules('college_type', 'University Type', 'required');
							              if($this->form_validation->run()== TRUE)
							              {
							                $msg=$this->input->post('msg');
							                // $passw=$this->input->post('password');
							$idd=base64_decode($t);
							                  $ip = $this->input->ip_address();
							          date_default_timezone_set("Asia/Calcutta");
							                  $cur_date=date("Y-m-d H:i:s");

							                  $addedby=$this->session->userdata('user_id');

							          // $typ=base64_decode($t);


							          $data_insert = array('from_id'=>$addedby,
							                    'to_id'=>$idd,
							                    'msg'=>$msg,
							                    'ip' =>$ip,
							                    // 'added_by' =>$addedby,
							                    'seen' =>0,
							                    'date'=>$cur_date

							                    );





							          $last_id=$this->base_model->insert_table("tbl_team_messages",$data_insert,1) ;




							                              if($last_id!=0){



							                              redirect("admin/messages/view_team_messages/".$t,"refresh");

							                                      }

							                                      else

							                                      {

							                                        echo "Error";

							                                        exit;



							                                      }


							              }
							            else{
							              echo validation_error();
							              exit;
							            }




							            }
							          else{
							            echo "Please insert some data, No data available";
							            exit;
							          }
							          }



							          else{

							          $this->load->view('admin/login/index');

							          }

							          }



public function seen(){

                 if(!empty($this->session->userdata('admin_data'))){


                   $data['user_name']=$this->load->get_var('user_name');

                   // echo SITE_NAME;
                   // echo $this->session->userdata('image');
                   // echo $this->session->userdata('position');
                   // exit;
									 $addedby=$this->session->userdata('user_id');

					 // $typ=base64_decode($t);


					 $data555 = array('seen'=>1
										 );


										 $this->db->where('to_id', $addedby);
				 						$zapak=$this->db->update('tbl_team_messages', $data555);

										if(!empty($zapak)){
											echo "success";
										}
										else{
											echo "Not okay";
										}

                   // $this->load->view('admin/common/header_view',$data);
                   // $this->load->view('admin/dash');
                   // $this->load->view('admin/common/footer_view');

               }
               else{

                   $this->load->view('admin/login/index');
               }

               }

}
