<?php

if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}
require_once(APPPATH . 'core/CI_finecontrol.php');
class Stock extends CI_finecontrol
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("login_model");
        $this->load->model("admin/base_model");
        $this->load->library('user_agent');
    }
    public function view_stock()
    {
        if (!empty($this->session->userdata('admin_data'))) {
            $data['user_name']=$this->load->get_var('user_name');

            // echo SITE_NAME;
            // echo $this->session->userdata('image');
            // echo $this->session->userdata('position');
            // exit;
            $this->db->select('*');
            $this->db->from('tbl_stock');
            //$this->db->where('id',$usr);
            $data['stock_data']= $this->db->get();


            $this->load->view('admin/common/header_view', $data);
            $this->load->view('admin/stock/view_stock');
            $this->load->view('admin/common/footer_view');
        } else {
            redirect("login/admin_login", "refresh");
        }
    }
    public function add_stock()
    {
        if (!empty($this->session->userdata('admin_data'))) {
            $data['user_name']=$this->load->get_var('user_name');

            // echo SITE_NAME;
            // echo $this->session->userdata('image');
            // echo $this->session->userdata('position');
            // exit;


            $this->load->view('admin/common/header_view', $data);
            $this->load->view('admin/stock/add_stock');
            $this->load->view('admin/common/footer_view');
        } else {
            redirect("login/admin_login", "refresh");
        }
    }
    public function add_stock_data($t, $iw="")
    {
        if (!empty($this->session->userdata('admin_data'))) {
            $this->load->helper(array('form', 'url'));
            $this->load->library('form_validation');
            $this->load->helper('security');
            if ($this->input->post()) {
                // print_r($this->input->post());
                // exit;
                $this->form_validation->set_rules('name', 'name', 'required|customAlpha|xss_clean');
                $this->form_validation->set_rules('message', 'message', 'required|xss_clean');

                if ($this->form_validation->run()== true) {
                    $name=$this->input->post('name');
                    $message=$this->input->post('message');
                    $this->load->library('upload');

                    $img1='fileToUpload1';

                    $file_check=($_FILES['fileToUpload1']['error']);
                    if ($file_check!=4) {
                        $image_upload_folder = FCPATH . "assets/uploads/stock/";
                        if (!file_exists($image_upload_folder)) {
                            mkdir($image_upload_folder, DIR_WRITE_MODE, true);
                        }
                        $new_file_name="stock".date("Ymdhms");
                        $this->upload_config = array(
                                                            'upload_path'   => $image_upload_folder,
                                                            'file_name' => $new_file_name,
                                                            'allowed_types' =>'jpg|jpeg|png',
                                                            'max_size'      => 25000
                                                    );
                        $this->upload->initialize($this->upload_config);
                        if (!$this->upload->do_upload($img1)) {
                            $upload_error = $this->upload->display_errors();
                            // echo json_encode($upload_error);
                            echo $upload_error;
                        } else {
                            $file_info = $this->upload->data();

                            $videoNAmePath = "assets/uploads/stock/".$new_file_name.$file_info['file_ext'];
                            $file_info['new_name']=$videoNAmePath;
                            // $this->step6_model->updateappIconImage($imageNAmePath,$appInfoId);
                            //$nnnn=$file_info['file_name'];
                            $nnnn=$videoNAmePath;
                            // echo json_encode($file_info);
                        }
                    }

                    $img2='fileToUpload2';

                    $file_check=($_FILES['fileToUpload2']['error']);
                    if ($file_check!=4) {
                        $image_upload_folder = FCPATH . "assets/uploads/stock/";
                        if (!file_exists($image_upload_folder)) {
                            mkdir($image_upload_folder, DIR_WRITE_MODE, true);
                        }
                        $new_file_name="stock2".date("Ymdhms");
                        $this->upload_config = array(
                                                                                    'upload_path'   => $image_upload_folder,
                                                                                    'file_name' => $new_file_name,
                                                                                    'allowed_types' =>'jpg|jpeg|png',
                                                                                    'max_size'      => 25000
                                                                            );
                        $this->upload->initialize($this->upload_config);
                        if (!$this->upload->do_upload($img2)) {
                            $upload_error = $this->upload->display_errors();
                            // echo json_encode($upload_error);
                            echo $upload_error;
                        } else {
                            $file_info = $this->upload->data();

                            $videoNAmePath = "assets/uploads/stock/".$new_file_name.$file_info['file_ext'];
                            $file_info['new_name']=$videoNAmePath;
                            // $this->step6_model->updateappIconImage($imageNAmePath,$appInfoId);
                            //$nnnn=$file_info['file_name'];
                            $nnnn2=$videoNAmePath;
                            // echo json_encode($file_info);
                        }
                    }

                    $ip = $this->input->ip_address();
                    date_default_timezone_set("Asia/Calcutta");
                    $cur_date=date("Y-m-d H:i:s");

                    $addedby=$this->session->userdata('admin_id');

                    $typ=base64_decode($t);
                    if ($typ==1) {
                        $data_insert = array('stockname'=>$name,
                                          'stockmessage'=>$message,
                                          'image1'=>$nnnn,
                                          'image2'=>$nnnn2,
                                          'ip' =>$ip,
                                          'added_by' =>$addedby,
                                          'is_active' =>1,
                                          'date'=>$cur_date

                                          );





                        $last_id=$this->base_model->insert_table("tbl_stock", $data_insert, 1) ;
												if ($last_id!=0) {
														$this->session->set_flashdata('smessage', 'Stock inserted successfully');

														redirect("dcadmin/stock/view_stock", "refresh");
												} else {
														$this->session->set_flashdata('emessage', 'Sorry error occured');
														redirect($_SERVER['HTTP_REFERER']);
												}
                    }
                    if ($typ==2) {
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
                        $this->db->select('*');
                        $this->db->from('tbl_stock');
                        $this->db->where('id', $idw);
                        $dsa= $this->db->get();
                        $da=$dsa->row();
                        if (!empty($nnnn)) {
                            $n1=$nnnn;
                        } else {
                            $n1=$da->image1;
                        }
                        if (!empty($nnnn2)) {
                            $n2=$nnnn2;
                        } else {
                            $n2=$da->image2;
                        }


                        $data_insert = array('stockname'=>$name,
                                                                        'stockmessage'=>$message,
                                                                        'image1'=>$n1,
                                                                        'image2'=>$n2,


                                          );




                        $this->db->where('id', $idw);
                        $last_id=$this->db->update('tbl_stock', $data_insert);
												if ($last_id!=0) {
														$this->session->set_flashdata('smessage', 'Stock updated successfully');

														redirect("dcadmin/stock/view_stock", "refresh");
												} else {
														$this->session->set_flashdata('emessage', 'Sorry error occured');
														redirect($_SERVER['HTTP_REFERER']);
												}
                    }



                } else {
                    $this->session->set_flashdata('emessage', validation_errors());
                    redirect($_SERVER['HTTP_REFERER']);
                }
            } else {
                $this->session->set_flashdata('emessage', 'Please insert some data, No data available');
                redirect($_SERVER['HTTP_REFERER']);
            }
        } else {
            redirect("login/admin_login", "refresh");
        }
    }
    public function update_stock($idd)
    {
        if (!empty($this->session->userdata('admin_data'))) {
            $data['user_name']=$this->load->get_var('user_name');

            // echo SITE_NAME;
            // echo $this->session->userdata('image');
            // echo $this->session->userdata('position');
            // exit;
            $id=base64_decode($idd);
            $data['id']=$idd;
            $this->db->select('*');
            $this->db->from('tbl_stock');
            $this->db->where('id', $id);
            $data['data']= $this->db->get()->row();

            $this->load->view('admin/common/header_view', $data);
            $this->load->view('admin/stock/update_stock');
            $this->load->view('admin/common/footer_view');
        } else {
            redirect("login/admin_login", "refresh");
        }
    }
    public function updatestockStatus($idd, $t)
    {
        if (!empty($this->session->userdata('admin_data'))) {
            $data['user_name']=$this->load->get_var('user_name');

            // echo SITE_NAME;
            // echo $this->session->userdata('image');
            // echo $this->session->userdata('position');
            // exit;
            $id=base64_decode($idd);

            if ($t=="active") {
                $data_update = array(
                                     'is_active'=>1

                                     );

                $this->db->where('id', $id);
                $zapak=$this->db->update('tbl_stock', $data_update);

                if ($zapak!=0) {
									$this->session->set_flashdata('smessage', 'Stock status updated successfully');
                    redirect("dcadmin/stock/view_stock", "refresh");
                } else {
                    echo "Error";
                    exit;
                }
            }
            if ($t=="inactive") {
                $data_update = array(
                                      'is_active'=>0

                                      );

                $this->db->where('id', $id);
                $zapak=$this->db->update('tbl_stock', $data_update);

                if ($zapak!=0) {
									$this->session->set_flashdata('smessage', 'Stock status updated successfully');
                    redirect("dcadmin/stock/view_stock", "refresh");
                } else {
                    $data['e']="Error Occured";
                    // exit;
                    $this->load->view('errors/error500admin', $data);
                }
            }
        } else {
            $this->load->view('admin/login/index');
        }
    }
    public function delete_stock($idd)
    {
        if (!empty($this->session->userdata('admin_data'))) {
            $data['user_name']=$this->load->get_var('user_name');

            // echo SITE_NAME;
            // echo $this->session->userdata('image');
            // echo $this->session->userdata('position');
            // exit;
            $id=base64_decode($idd);

            if ($this->load->get_var('position')=="Super Admin") {
                $this->db->select('image1');
                $this->db->from('tbl_stock');
                $this->db->where('id', $id);
                $dsa= $this->db->get();
                $da=$dsa->row();
                $img=$da->image1;

                $zapak=$this->db->delete('tbl_stock', array('id' => $id));
                if ($zapak!=0) {
                    $path = FCPATH .$img;
                    unlink($path);
										$this->session->set_flashdata('smessage', 'Stock deleted successfully');
                    redirect("dcadmin/stock/view_stock", "refresh");
                } else {
									$this->session->set_flashdata('emessage', 'Unknown error occured');
									redirect($_SERVER['HTTP_REFERER']);
                }
            } else {
							$this->session->set_flashdata('emessage', 'Sorry You Dont Have Permission To Delete Anything');
							redirect($_SERVER['HTTP_REFERER']);
            }
        } else {
            $this->load->view('admin/login/index');
        }
    }
}
