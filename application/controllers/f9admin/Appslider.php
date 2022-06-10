<?php

    if (! defined('BASEPATH')) {
        exit('No direct script access allowed');
    }
       require_once(APPPATH . 'core/CI_finecontrol.php');
       class Appslider extends CI_finecontrol
       {
           public function __construct()
           {
               parent::__construct();
               $this->load->model("login_model");
               $this->load->model("admin/base_model");
               $this->load->library('user_agent');
               $this->load->library('upload');
           }

           public function view_appslider()
           {
               if (!empty($this->session->userdata('admin_data'))) {
                   $data['user_name']=$this->load->get_var('user_name');

                   // echo SITE_NAME;
                   // echo $this->session->userdata('image');
                   // echo $this->session->userdata('position');
                   // exit;

                   $this->db->select('*');
                   $this->db->from('tbl_appslider');
                   //$this->db->where('id',$usr);
                   $data['appslider_data']= $this->db->get();

                   $this->load->view('admin/common/header_view', $data);
                   $this->load->view('admin/appslider/view_appslider');
                   $this->load->view('admin/common/footer_view');
               } else {
                   redirect("login/admin_login", "refresh");
               }
           }

           public function add_appslider()
           {
               if (!empty($this->session->userdata('admin_data'))) {
                   $this->load->view('admin/common/header_view');
                   $this->load->view('admin/appslider/add_appslider');
                   $this->load->view('admin/common/footer_view');
               } else {
                   redirect("login/admin_login", "refresh");
               }
           }

           public function update_appslider($idd)
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
                   $this->db->from('tbl_appslider');
                   $this->db->where('id', $id);
                   $data['appslider_data']= $this->db->get()->row();


                   $this->load->view('admin/common/header_view', $data);
                   $this->load->view('admin/appslider/update_appslider');
                   $this->load->view('admin/common/footer_view');
               } else {
                   redirect("login/admin_login", "refresh");
               }
           }

           public function add_appslider_data($t, $iw="")
           {
               if (!empty($this->session->userdata('admin_data'))) {
                   $this->load->helper(array('form', 'url'));
                   $this->load->library('form_validation');
                   $this->load->helper('security');
                   if ($this->input->post()) {
                       // print_r($this->input->post());
                       // exit;
                       $this->form_validation->set_rules('title', 'title', 'required');





                       if ($this->form_validation->run()== true) {
                           $title=$this->input->post('title');

                           $ip = $this->input->ip_address();
                           date_default_timezone_set("Asia/Calcutta");
                           $cur_date=date("Y-m-d H:i:s");
                           $addedby=$this->session->userdata('admin_id');

                           $typ=base64_decode($t);
                           $last_id = 0;
                           if ($typ==1) {
                               $img1='image';




                               $image_upload_folder = FCPATH . "assets/uploads/appslider/";
                               if (!file_exists($image_upload_folder)) {
                                   mkdir($image_upload_folder, DIR_WRITE_MODE, true);
                               }
                               $new_file_name="appslider".date("Ymdhms");
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

           //$this->session->set_flashdata('emessage',$upload_error);
             //redirect($_SERVER['HTTP_REFERER']);
                               } else {
                                   $file_info = $this->upload->data();

                                   $videoNAmePath = "assets/uploads/appslider/".$new_file_name.$file_info['file_ext'];
                                   $file_info['new_name']=$videoNAmePath;
                                   // $this->step6_model->updateappIconImage($imageNAmePath,$appInfoId);
                                   $nnnn=$file_info['file_name'];
                                   $nnnn1=$videoNAmePath;

                                   // echo json_encode($file_info);
                               }




                               $data_insert = array(
                  'title'=>$title,
  'image'=>$nnnn1,

                     'ip' =>$ip,
                     'added_by' =>$addedby,
                     'is_active' =>1,
                     'date'=>$cur_date
                     );


                               $last_id=$this->base_model->insert_table("tbl_appslider", $data_insert, 1) ;
                               if ($last_id!=0) {
                                   $this->session->set_flashdata('smessage', 'Appslider inserted successfully');
                                   redirect("dcadmin/Appslider/view_appslider", "refresh");
                               } else {
                                   $this->session->set_flashdata('emessage', 'Sorry error occured');
                                   redirect($_SERVER['HTTP_REFERER']);
                               }
                           }
                           if ($typ==2) {
                               $idw=base64_decode($iw);


                               $this->db->select('*');
                               $this->db->from('tbl_appslider');
                               $this->db->where('id', $idw);
                               $dsa=$this->db->get();
                               $da=$dsa->row();



                               $img1='image';




                               $image_upload_folder = FCPATH . "assets/uploads/appslider/";
                               if (!file_exists($image_upload_folder)) {
                                   mkdir($image_upload_folder, DIR_WRITE_MODE, true);
                               }
                               $new_file_name="appslider".date("Ymdhms");
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

           //$this->session->set_flashdata('emessage',$upload_error);
             //redirect($_SERVER['HTTP_REFERER']);
                               } else {
                                   $file_info = $this->upload->data();

                                   $videoNAmePath = "assets/uploads/appslider/".$new_file_name.$file_info['file_ext'];
                                   $file_info['new_name']=$videoNAmePath;
                                   // $this->step6_model->updateappIconImage($imageNAmePath,$appInfoId);
                                   $nnnn=$file_info['file_name'];
                                   $nnnn1=$videoNAmePath;

                                   // echo json_encode($file_info);
                               }




                               if (!empty($da)) {
                                   $img = $da ->image;
                                   if (!empty($img)) {
                                       if (empty($nnnn1)) {
                                           $nnnn1 = $img;
                                       }
                                   } else {
                                       if (empty($nnnn1)) {
                                           $nnnn1= "";
                                       }
                                   }
                               }

                               $data_insert = array(
                  'title'=>$title,
  'image'=>$nnnn1,

                     );
                               $this->db->where('id', $idw);
                               $last_id=$this->db->update('tbl_appslider', $data_insert);
                               if ($last_id!=0) {
                                   $this->session->set_flashdata('smessage', 'Appslider updated successfully');
                                   redirect("dcadmin/Appslider/view_appslider", "refresh");
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

           public function updateappsliderStatus($idd, $t)
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
                       $zapak=$this->db->update('tbl_appslider', $data_update);

                       if ($zapak!=0) {
                           redirect("dcadmin/Appslider/view_appslider", "refresh");
                       } else {
                           $this->session->set_flashdata('emessage', 'Sorry error occured');
                           redirect($_SERVER['HTTP_REFERER']);
                       }
                   }
                   if ($t=="inactive") {
                       $data_update = array(
                         'is_active'=>0

                         );

                       $this->db->where('id', $id);
                       $zapak=$this->db->update('tbl_appslider', $data_update);

                       if ($zapak!=0) {
                           redirect("dcadmin/Appslider/view_appslider", "refresh");
                       } else {
                           $this->session->set_flashdata('emessage', 'Sorry error occured');
                           redirect($_SERVER['HTTP_REFERER']);
                       }
                   }
               } else {
                   redirect("login/admin_login", "refresh");
               }
           }



           public function delete_appslider($idd)
           {
               if (!empty($this->session->userdata('admin_data'))) {
                   $data['user_name']=$this->load->get_var('user_name');

                   // echo SITE_NAME;
                   // echo $this->session->userdata('image');
                   // echo $this->session->userdata('position');
                   // exit;
                   $id=base64_decode($idd);

                   if ($this->load->get_var('position')=="Super Admin") {
                       $this->db->select('*');
                       $this->db->from('tbl_appslider');
                       $this->db->where('id', $id);
                       $dsa= $this->db->get();
                       $da=$dsa->row();
                       // $img=$da->image;

                       $zapak=$this->db->delete('tbl_appslider', array('id' => $id));
                       if ($zapak!=0) {
                           // $path = FCPATH .$img;
                           //   unlink($path);
                           redirect("dcadmin/Appslider/view_appslider", "refresh");
                       } else {
                           $this->session->set_flashdata('emessage', 'Sorry error occured');
                           redirect($_SERVER['HTTP_REFERER']);
                       }
                   } else {
                       $this->session->set_flashdata('emessage', 'Sorry you not a super admin you dont have permission to delete anything');
                       redirect($_SERVER['HTTP_REFERER']);
                   }
               } else {
                   redirect("login/admin_login", "refresh");
               }
           }
       }
