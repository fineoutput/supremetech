<?php

    if (! defined('BASEPATH')) {
        exit('No direct script access allowed');
    }
       require_once(APPPATH . 'core/CI_finecontrol.php');
       class Brands extends CI_finecontrol
       {
           public function __construct()
           {
               parent::__construct();
               $this->load->model("login_model");
               $this->load->model("admin/base_model");
               $this->load->library('user_agent');
               $this->load->library('upload');
           }

           public function view_brands()
           {
               if (!empty($this->session->userdata('admin_data'))) {
                   $data['user_name']=$this->load->get_var('user_name');

                   // echo SITE_NAME;
                   // echo $this->session->userdata('image');
                   // echo $this->session->userdata('position');
                   // exit;

                   $this->db->select('*');
                   $this->db->from('tbl_brands');
                   //$this->db->where('id',$usr);
                   $data['brands_data']= $this->db->get();

                   $this->load->view('admin/common/header_view', $data);
                   $this->load->view('admin/brands/view_brands');
                   $this->load->view('admin/common/footer_view');
               } else {
                   redirect("login/admin_login", "refresh");
               }
           }

           public function add_brands()
           {
               if (!empty($this->session->userdata('admin_data'))) {
                   $this->load->view('admin/common/header_view');
                   $this->load->view('admin/brands/add_brands');
                   $this->load->view('admin/common/footer_view');
               } else {
                   redirect("login/admin_login", "refresh");
               }
           }

           public function update_brands($idd)
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
                   $this->db->from('tbl_brands');
                   $this->db->where('id', $id);
                   $data['brands_data']= $this->db->get()->row();


                   $this->load->view('admin/common/header_view', $data);
                   $this->load->view('admin/brands/update_brands');
                   $this->load->view('admin/common/footer_view');
               } else {
                   redirect("login/admin_login", "refresh");
               }
           }

           public function add_brands_data($t, $iw="")
           {
               if (!empty($this->session->userdata('admin_data'))) {
                   $this->load->helper(array('form', 'url'));
                   $this->load->library('form_validation');
                   $this->load->helper('security');
                   if ($this->input->post()) {
                       // print_r($this->input->post());
                       // exit;
                       $this->form_validation->set_rules('name', 'name', 'required');
                       $this->form_validation->set_rules('message', 'message', 'required');
                       $this->form_validation->set_rules('for_t2', 'for t2', 'required');





                       if ($this->form_validation->run()== true) {
                           $name=$this->input->post('name');
                           $message=$this->input->post('message');
                           $for_t2=$this->input->post('for_t2');

                           $ip = $this->input->ip_address();
                           date_default_timezone_set("Asia/Calcutta");
                           $cur_date=date("Y-m-d H:i:s");
                           $addedby=$this->session->userdata('admin_id');

                           $typ=base64_decode($t);
                           $last_id = 0;
                           if ($typ==1) {


                               $img2='image';

                               $file_check=($_FILES['image']['error']);
                               if($file_check!=4){
                             	$image_upload_folder = FCPATH . "assets/uploads/brands/";
                     						if (!file_exists($image_upload_folder))
                     						{
                     							mkdir($image_upload_folder, DIR_WRITE_MODE, true);
                     						}
                     						$new_file_name="brands".date("Ymdhms");
                     						$this->upload_config = array(
                     								'upload_path'   => $image_upload_folder,
                     								'file_name' => $new_file_name,
                     								'allowed_types' =>'jpg|jpeg|png',
                     								'max_size'      => 25000
                     						);
                     						$this->upload->initialize($this->upload_config);
                     						if (!$this->upload->do_upload($img2))
                     						{
                     							$upload_error = $this->upload->display_errors();
                                   $this->session->set_flashdata('emessage',$upload_error);
                                      redirect($_SERVER['HTTP_REFERER']);
                     							// echo json_encode($upload_error);
                     							// echo $upload_error;
                     						}
                     						else
                     						{

                     							$file_info = $this->upload->data();

                     							$videoNAmePath = "assets/uploads/brands/".$new_file_name.$file_info['file_ext'];
                     							$nnnn2=$videoNAmePath;
                     							// echo json_encode($file_info);
                     						}
                               }




                               $data_insert = array(
                  'name'=>$name,
  'message'=>$message,
  'image'=>$nnnn2,
  'for_t2'=>$for_t2,

                     'ip' =>$ip,
                     'added_by' =>$addedby,
                     'is_active' =>1,
                     'date'=>$cur_date
                     );


                               $last_id=$this->base_model->insert_table("tbl_brands", $data_insert, 1) ;

                               if ($last_id!=0) {
                                   $this->session->set_flashdata('smessage', 'Brands inserted successfully');
                                   redirect("dcadmin/Brands/view_brands", "refresh");
                               } else {
                                   $this->session->set_flashdata('emessage', 'Sorry error occured');
                                   redirect($_SERVER['HTTP_REFERER']);
                               }
                           }
                           if ($typ==2) {
                               $idw=base64_decode($iw);


                               $this->db->select('*');
                               $this->db->from('tbl_brands');
                               $this->db->where('id', $idw);
                               $dsa=$this->db->get();
                               $da=$dsa->row();



                               $img2='image';

                               $file_check=($_FILES['image']['error']);
                               if($file_check!=4){
                             	$image_upload_folder = FCPATH . "assets/uploads/brands/";
                     						if (!file_exists($image_upload_folder))
                     						{
                     							mkdir($image_upload_folder, DIR_WRITE_MODE, true);
                     						}
                     						$new_file_name="brands".date("Ymdhms");
                     						$this->upload_config = array(
                     								'upload_path'   => $image_upload_folder,
                     								'file_name' => $new_file_name,
                     								'allowed_types' =>'jpg|jpeg|png',
                     								'max_size'      => 25000
                     						);
                     						$this->upload->initialize($this->upload_config);
                     						if (!$this->upload->do_upload($img2))
                     						{
                     							$upload_error = $this->upload->display_errors();
                                   $this->session->set_flashdata('emessage',$upload_error);
                                      redirect($_SERVER['HTTP_REFERER']);
                     							// echo json_encode($upload_error);
                     							// echo $upload_error;
                     						}
                     						else
                     						{
                     							$file_info = $this->upload->data();
                     							$videoNAmePath = "assets/uploads/brands/".$new_file_name.$file_info['file_ext'];
                     							$nnnn2=$videoNAmePath;
                     							// echo json_encode($file_info);
                     						}
                               }




                               if (!empty($da)) {
                                   $img = $da ->image;
                                   if (!empty($img)) {
                                       if (empty($nnnn2)) {
                                           $nnnn2 = $img;
                                       }
                                   } else {
                                       if (empty($nnnn2)) {
                                           $nnnn2= "";
                                       }
                                   }
                               }

                               $data_insert = array(
                  'name'=>$name,
  'message'=>$message,
  'image'=>$nnnn2,
  'for_t2'=>$for_t2,

                     );
                               $this->db->where('id', $idw);
                               $last_id=$this->db->update('tbl_brands', $data_insert);

                               if ($last_id!=0) {
                                   $this->session->set_flashdata('smessage', 'Brands updated successfully');
                                   redirect("dcadmin/Brands/view_brands", "refresh");
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

           public function updatebrandsStatus($idd, $t)
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
                       $zapak=$this->db->update('tbl_brands', $data_update);

                       if ($zapak!=0) {
                           $this->session->set_flashdata('smessage', 'Brands status updated successfully');
                           redirect("dcadmin/Brands/view_brands", "refresh");
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
                       $zapak=$this->db->update('tbl_brands', $data_update);

                       if ($zapak!=0) {
                           $this->session->set_flashdata('smessage', 'Brands status updated successfully');
                           redirect("dcadmin/Brands/view_brands", "refresh");
                       } else {
                           $this->session->set_flashdata('emessage', 'Sorry error occured');
                           redirect($_SERVER['HTTP_REFERER']);
                       }
                   }
               } else {
                   redirect("login/admin_login", "refresh");
               }
           }



           public function delete_brands($idd)
           {
               if (!empty($this->session->userdata('admin_data'))) {
                   $data['user_name']=$this->load->get_var('user_name');

                   // echo SITE_NAME;
                   // echo $this->session->userdata('image');
                   // echo $this->session->userdata('position');
                   // exit;
                   $id=base64_decode($idd);

                   if ($this->load->get_var('position')=="Super Admin") {
                       $this->db->select('image');
                       $this->db->from('tbl_brands');
                       $this->db->where('id', $id);
                       $dsa= $this->db->get();
                       $da=$dsa->row();
                       $img=$da->image;

                       $zapak=$this->db->delete('tbl_brands', array('id' => $id));
                       if ($zapak!=0) {
                           $path = FCPATH .$img;
                           unlink($path);
                           $this->session->set_flashdata('smessage', 'Brands deleted successfully');
                           redirect("dcadmin/Brands/view_brands", "refresh");
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
