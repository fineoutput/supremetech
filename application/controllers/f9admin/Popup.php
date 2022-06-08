<?php

    if (! defined('BASEPATH')) {
        exit('No direct script access allowed');
    }
       require_once(APPPATH . 'core/CI_finecontrol.php');
       class Popup extends CI_finecontrol
       {
           public function __construct()
           {
               parent::__construct();
               $this->load->model("login_model");
               $this->load->model("admin/base_model");
               $this->load->library('user_agent');
               $this->load->library('upload');
           }

           public function view_popup()
           {
               if (!empty($this->session->userdata('admin_data'))) {
                   $data['user_name']=$this->load->get_var('user_name');

                   // echo SITE_NAME;
                   // echo $this->session->userdata('image');
                   // echo $this->session->userdata('position');
                   // exit;

                   $this->db->select('*');
                   $this->db->from('tbl_popup');
                   //$this->db->where('id',$usr);
                   $data['popup_data']= $this->db->get();

                   $this->load->view('admin/common/header_view', $data);
                   $this->load->view('admin/popup/view_popup');
                   $this->load->view('admin/common/footer_view');
               } else {
                   redirect("login/admin_login", "refresh");
               }
           }

           public function add_popup()
           {
               if (!empty($this->session->userdata('admin_data'))) {
                   $this->load->view('admin/common/header_view');
                   $this->load->view('admin/popup/add_popup');
                   $this->load->view('admin/common/footer_view');
               } else {
                   redirect("login/admin_login", "refresh");
               }
           }

           public function update_popup($idd)
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
                   $this->db->from('tbl_popup');
                   $this->db->where('id', $id);
                   $data['popup_data']= $this->db->get()->row();


                   $this->load->view('admin/common/header_view', $data);
                   $this->load->view('admin/popup/update_popup');
                   $this->load->view('admin/common/footer_view');
               } else {
                   redirect("login/admin_login", "refresh");
               }
           }

           public function add_popup_data($t, $iw="")
           {
               if (!empty($this->session->userdata('admin_data'))) {
                   $this->load->helper(array('form', 'url'));
                   $this->load->library('form_validation');
                   $this->load->helper('security');
                   // if($this->input->post())
                   // {
                   // print_r($this->input->post());
                   // exit;





                   // if($this->form_validation->run()== TRUE)
                   // {

                   $ip = $this->input->ip_address();
                   date_default_timezone_set("Asia/Calcutta");
                   $cur_date=date("Y-m-d H:i:s");
                   $addedby=$this->session->userdata('admin_id');

                   $typ=base64_decode($t);
                   $last_id = 0;
                   if ($typ==1) {
                       $img0='image';




                       $image_upload_folder = FCPATH . "assets/uploads/popup/";
                       if (!file_exists($image_upload_folder)) {
                           mkdir($image_upload_folder, DIR_WRITE_MODE, true);
                       }
                       $new_file_name="popup".date("Ymdhms");
                       $this->upload_config = array(
                             'upload_path'   => $image_upload_folder,
                             'file_name' => $new_file_name,
                             'allowed_types' =>'jpg|jpeg|png',
                             'max_size'      => 25000
                     );
                       $this->upload->initialize($this->upload_config);
                       if (!$this->upload->do_upload($img0)) {
                           $upload_error = $this->upload->display_errors();
                       // echo json_encode($upload_error);

           //$this->session->set_flashdata('emessage',$upload_error);
             //redirect($_SERVER['HTTP_REFERER']);
                       } else {
                           $file_info = $this->upload->data();

                           $videoNAmePath = "assets/uploads/popup/".$new_file_name.$file_info['file_ext'];
                           $file_info['new_name']=$videoNAmePath;
                           // $this->step6_model->updateappIconImage($imageNAmePath,$appInfoId);
                           $nnnn=$file_info['file_name'];
                           $nnnn0=$videoNAmePath;

                           // echo json_encode($file_info);
                       }




                       $data_insert = array(
                  'image'=>$nnnn0,

                     'ip' =>$ip,
                     'added_by' =>$addedby,
                     'is_active' =>1,
                     'date'=>$cur_date
                     );


                       $last_id=$this->base_model->insert_table("tbl_popup", $data_insert, 1) ;
                       if ($last_id!=0) {
                           $this->session->set_flashdata('smessage', 'Popup inserted successfully');
                           redirect("dcadmin/popup/view_popup", "refresh");
                       } else {
                           $this->session->set_flashdata('emessage', 'Sorry error occured');
                           redirect($_SERVER['HTTP_REFERER']);
                       }
                   }
                   if ($typ==2) {
                       $idw=base64_decode($iw);


                       $this->db->select('*');
                       $this->db->from('tbl_popup');
                       $this->db->where('id', $idw);
                       $dsa=$this->db->get();
                       $da=$dsa->row();



                       $img0='image';




                       $image_upload_folder = FCPATH . "assets/uploads/popup/";
                       if (!file_exists($image_upload_folder)) {
                           mkdir($image_upload_folder, DIR_WRITE_MODE, true);
                       }
                       $new_file_name="popup".date("Ymdhms");
                       $this->upload_config = array(
                             'upload_path'   => $image_upload_folder,
                             'file_name' => $new_file_name,
                             'allowed_types' =>'jpg|jpeg|png',
                             'max_size'      => 25000
                     );
                       $this->upload->initialize($this->upload_config);
                       if (!$this->upload->do_upload($img0)) {
                           $upload_error = $this->upload->display_errors();
                       // echo json_encode($upload_error);

           //$this->session->set_flashdata('emessage',$upload_error);
             //redirect($_SERVER['HTTP_REFERER']);
                       } else {
                           $file_info = $this->upload->data();

                           $videoNAmePath = "assets/uploads/popup/".$new_file_name.$file_info['file_ext'];
                           $file_info['new_name']=$videoNAmePath;
                           // $this->step6_model->updateappIconImage($imageNAmePath,$appInfoId);
                           $nnnn=$file_info['file_name'];
                           $nnnn0=$videoNAmePath;

                           // echo json_encode($file_info);
                       }




                       if (!empty($da)) {
                           $img = $da ->image;
                           if (!empty($img)) {
                               if (empty($nnnn0)) {
                                   $nnnn0 = $img;
                               }
                           } else {
                               if (empty($nnnn0)) {
                                   $nnnn0= "";
                               }
                           }
                       }

                       $data_insert = array(
                  'image'=>$nnnn0,

                     );
                       $this->db->where('id', $idw);
                       $last_id=$this->db->update('tbl_popup', $data_insert);
                       if ($last_id!=0) {
                           $this->session->set_flashdata('smessage', 'Popup updated successfully');
                           redirect("dcadmin/popup/view_popup", "refresh");
                       } else {
                           $this->session->set_flashdata('emessage', 'Sorry error occured');
                           redirect($_SERVER['HTTP_REFERER']);
                       }
                   }

                   //          }
      //        else{
      //
      //   $this->session->set_flashdata('emessage',validation_errors());
      // redirect($_SERVER['HTTP_REFERER']);
      //
      //        }

 //             }
 //           else{
 //
 // $this->session->set_flashdata('emessage','Please insert some data, No data available');
 //      redirect($_SERVER['HTTP_REFERER']);
 //
 //           }
               } else {
                   redirect("login/admin_login", "refresh");
               }
           }

           public function updatepopupStatus($idd, $t)
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
                       $zapak=$this->db->update('tbl_popup', $data_update);

                       if ($zapak!=0) {
                          $this->session->set_flashdata('smessage', 'Popup status updated successfully');
                           redirect("dcadmin/popup/view_popup", "refresh");
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
                       $zapak=$this->db->update('tbl_popup', $data_update);

                       if ($zapak!=0) {
                          $this->session->set_flashdata('smessage', 'Popup status updated successfully');
                           redirect("dcadmin/popup/view_popup", "refresh");
                       } else {
                           $this->session->set_flashdata('emessage', 'Sorry error occured');
                           redirect($_SERVER['HTTP_REFERER']);
                       }
                   }
               } else {
                   redirect("login/admin_login", "refresh");
               }
           }



           public function delete_popup($idd)
           {
               if (!empty($this->session->userdata('admin_data'))) {
                   $data['user_name']=$this->load->get_var('user_name');

                   // echo SITE_NAME;
                   // echo $this->session->userdata('image');
                   // echo $this->session->userdata('position');
                   // exit;
                   $id=base64_decode($idd);

                   if ($this->load->get_var('position')=="Super Admin") {

                     // $this->db->select('image');
                       // $this->db->from('tbl_popup');
                       // $this->db->where('id',$id);
                       // $dsa= $this->db->get();
                       // $da=$dsa->row();
                       // $img=$da->image;

                       $zapak=$this->db->delete('tbl_popup', array('id' => $id));
                       if ($zapak!=0) {
                           // $path = FCPATH .$img;
                           //   unlink($path);
                           $this->session->set_flashdata('smessage', 'Popup status deleted successfully');
                           redirect("dcadmin/popup/view_popup", "refresh");
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
