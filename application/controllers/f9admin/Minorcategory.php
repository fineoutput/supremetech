<?php

    if (! defined('BASEPATH')) {
        exit('No direct script access allowed');
    }
       require_once(APPPATH . 'core/CI_finecontrol.php');
       class Minorcategory extends CI_finecontrol
       {
           public function __construct()
           {
               parent::__construct();
               $this->load->model("login_model");
               $this->load->model("admin/base_model");
               $this->load->library('user_agent');
               $this->load->library('upload');
           }

           public function view_minorcategory()
           {
               if (!empty($this->session->userdata('admin_data'))) {
                   $data['user_name']=$this->load->get_var('user_name');

                   // echo SITE_NAME;
                   // echo $this->session->userdata('image');
                   // echo $this->session->userdata('position');
                   // exit;

                   $this->db->select('*');
                   $this->db->from('tbl_minorcategory');
                   //$this->db->where('id',$usr);
                   $data['minorcategory_data']= $this->db->get();

                   $this->load->view('admin/common/header_view', $data);
                   $this->load->view('admin/minorcategory/view_minorcategory');
                   $this->load->view('admin/common/footer_view');
               } else {
                   redirect("login/admin_login", "refresh");
               }
           }

           public function add_minorcategory()
           {
               if (!empty($this->session->userdata('admin_data'))) {
                   $this->db->select('*');
                   $this->db->from('tbl_category');
                   $this->db->where('is_active', 1);
                   $data['category_data']= $this->db->get();

                   $this->db->select('*');
                   $this->db->from('tbl_brands');
                   $this->db->where('is_active', 1);
                   $data['brand_data']= $this->db->get();

                   $this->db->select('*');
                   $this->db->from('tbl_resolution');
                   $data['resolution_data']= $this->db->get();

                   $this->db->select('*');
                   $this->db->from('tbl_irdistance');
                   $data['irdistance_data']= $this->db->get();

                   $this->db->select('*');
                   $this->db->from('tbl_cameratype');
                   $data['cameratype_data']= $this->db->get();

                   $this->db->select('*');
                   $this->db->from('tbl_bodymaterial');
                   $data['bodymaterial_data']= $this->db->get();

                   $this->db->select('*');
                   $this->db->from('tbl_videochannel');
                   $data['videochannel_data']= $this->db->get();

                   $this->db->select('*');
                   $this->db->from('tbl_poeports');
                   $data['poeports_data']= $this->db->get();

                   $this->db->select('*');
                   $this->db->from('tbl_poetype');
                   $data['poetype_data']= $this->db->get();

                   $this->db->select('*');
                   $this->db->from('tbl_sataports');
                   $data['sataports_data']= $this->db->get();

                   $this->db->select('*');
                   $this->db->from('tbl_length');
                   $data['length_data']= $this->db->get();

                   $this->db->select('*');
                   $this->db->from('tbl_screensize');
                   $data['screensize_data']= $this->db->get();

                   $this->db->select('*');
                   $this->db->from('tbl_ledtype');
                   $data['ledtype_data']= $this->db->get();

                   $this->db->select('*');
                   $this->db->from('tbl_size');
                   $data['size_data']= $this->db->get();

                   $this->db->select('*');
                   $this->db->from('tbl_lens');
                   $data['lens_data']= $this->db->get();

                   $this->db->select('*');
                   $this->db->from('tbl_night_vision');
                   $data['night_vision_data']= $this->db->get();

                   $this->db->select('*');
                   $this->db->from('tbl_audio_type');
                   $data['audio_type_data']= $this->db->get();

                   $this->db->select('*');
                   $this->db->from('tbl_subcategory');
                   //$this->db->where('id',$usr);
                   $data['subcategory_data']= $this->db->get();


                   $this->load->view('admin/common/header_view', $data);
                   $this->load->view('admin/minorcategory/add_minorcategory');
                   $this->load->view('admin/common/footer_view');
               } else {
                   redirect("login/admin_login", "refresh");
               }
           }
           public function getSubcategory()
           {

                                  // $data['user_name']=$this->load->get_var('user_name');

               // echo SITE_NAME;
               // echo $this->session->userdata('image');
               // echo $this->session->userdata('position');
               // exit;

               $id=$_GET['isl'];
               $this->db->select('*');
               $this->db->from('tbl_subcategory');
               $this->db->where('category_id', $id);
               $this->db->where('is_active', 1);

               $dat= $this->db->get();

               $i=1;
               foreach ($dat->result() as $data) {
                   $igt[] = array('sub_id' =>$data->id ,'sub_name'=>$data->subcategory);
               }


               echo json_encode($igt);
           }

           public function update_minorcategory($idd)
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
                   $this->db->from('tbl_subcategory');
                   // $this->db->where('id',$id);
                   $data['subcategory_data']= $this->db->get();

                   $this->db->select('*');
                   $this->db->from('tbl_category');
                   //$this->db->where('id',$usr);
                   $data['category_data']= $this->db->get();

                   $this->db->select('*');
                   $this->db->from('tbl_minorcategory');
                   $this->db->where('id', $id);
                   $data['minorcategory_data']= $this->db->get()->row();


                   $this->db->select('*');
                   $this->db->from('tbl_brands');
                   $this->db->where('is_active', 1);
                   $data['brand_data']= $this->db->get();

                   $this->db->select('*');
                   $this->db->from('tbl_resolution');
                   $data['resolution_data']= $this->db->get();

                   $this->db->select('*');
                   $this->db->from('tbl_irdistance');
                   $data['irdistance_data']= $this->db->get();

                   $this->db->select('*');
                   $this->db->from('tbl_cameratype');
                   $data['cameratype_data']= $this->db->get();

                   $this->db->select('*');
                   $this->db->from('tbl_bodymaterial');
                   $data['bodymaterial_data']= $this->db->get();

                   $this->db->select('*');
                   $this->db->from('tbl_videochannel');
                   $data['videochannel_data']= $this->db->get();

                   $this->db->select('*');
                   $this->db->from('tbl_poeports');
                   $data['poeports_data']= $this->db->get();

                   $this->db->select('*');
                   $this->db->from('tbl_poetype');
                   $data['poetype_data']= $this->db->get();

                   $this->db->select('*');
                   $this->db->from('tbl_sataports');
                   $data['sataports_data']= $this->db->get();

                   $this->db->select('*');
                   $this->db->from('tbl_length');
                   $data['length_data']= $this->db->get();

                   $this->db->select('*');
                   $this->db->from('tbl_screensize');
                   $data['screensize_data']= $this->db->get();

                   $this->db->select('*');
                   $this->db->from('tbl_ledtype');
                   $data['ledtype_data']= $this->db->get();

                   $this->db->select('*');
                   $this->db->from('tbl_size');
                   $data['size_data']= $this->db->get();

                   $this->db->select('*');
                   $this->db->from('tbl_lens');
                   $data['lens_data']= $this->db->get();

                   $this->db->select('*');
                   $this->db->from('tbl_night_vision');
                   $data['night_vision_data']= $this->db->get();

                   $this->db->select('*');
                   $this->db->from('tbl_audio_type');
                   $data['audio_type_data']= $this->db->get();

                   $this->db->select('*');
                   $this->db->from('tbl_subcategory');
                   //$this->db->where('id',$usr);
                   $data['subcategory_data']= $this->db->get();


                   $this->load->view('admin/common/header_view', $data);
                   $this->load->view('admin/minorcategory/update_minorcategory');
                   $this->load->view('admin/common/footer_view');
               } else {
                   redirect("login/admin_login", "refresh");
               }
           }

           public function add_minorcategory_data($t, $iw="")
           {
               if (!empty($this->session->userdata('admin_data'))) {
                   $this->load->helper(array('form', 'url'));
                   $this->load->library('form_validation');
                   $this->load->helper('security');
                   if ($this->input->post()) {
                       // print_r($this->input->post());
                       // exit;
                       $this->form_validation->set_rules('category_id', 'category_id', 'required|trim');
                       $this->form_validation->set_rules('subcategory_id', 'subcategory_id', 'required|trim');
                       $this->form_validation->set_rules('minorcategoryname', 'minorcategoryname', 'trim');
                       //------filters
                       $this->form_validation->set_rules('brand[]', 'brand', 'trim');
                       $this->form_validation->set_rules('resolution[]', 'resolution', 'trim');
                       $this->form_validation->set_rules('ir_distance[]', 'ir_distance', 'trim');
                       $this->form_validation->set_rules('camera_type[]', 'camera_type', 'trim');
                       $this->form_validation->set_rules('body_materials[]', 'body_materials', 'trim');
                       $this->form_validation->set_rules('video_channel[]', 'video_channel', 'trim');
                       $this->form_validation->set_rules('poe_ports[]', 'poe_ports', 'trim');
                       $this->form_validation->set_rules('poe_type[]', 'poe_type', 'trim');
                       $this->form_validation->set_rules('sata_ports[]', 'sata_ports', 'trim');
                       $this->form_validation->set_rules('length[]', 'length', 'trim');
                       $this->form_validation->set_rules('screen_size[]', 'screen_size', 'trim');
                       $this->form_validation->set_rules('led_type[]', 'led_type', 'trim');
                       $this->form_validation->set_rules('size[]', 'size', 'trim');
                       $this->form_validation->set_rules('lens[]', 'lens', 'trim');
                       $this->form_validation->set_rules('night_vision[]', 'night_vision', 'trim');
                       $this->form_validation->set_rules('audio_type[]', 'audio_type', 'trim');





                       if ($this->form_validation->run()== true) {
                           $category_id=$this->input->post('category_id');
                           $subcategory_id=$this->input->post('subcategory_id');
                           $minorcategoryname=$this->input->post('minorcategoryname');

                           $brand=json_encode($this->input->post('brand[]'));
                           $resolution=json_encode($this->input->post('resolution[]'));
                           $ir_distance=json_encode($this->input->post('ir_distance[]'));
                           $camera_type=json_encode($this->input->post('camera_type[]'));
                           $body_materials=json_encode($this->input->post('body_materials[]'));
                           $video_channel=json_encode($this->input->post('video_channel[]'));
                           $poe_ports=json_encode($this->input->post('poe_ports[]'));
                           $poe_type=json_encode($this->input->post('poe_type[]'));
                           $sata_ports=json_encode($this->input->post('sata_ports[]'));
                           $length=json_encode($this->input->post('length[]'));
                           $screen_size=json_encode($this->input->post('screen_size[]'));
                           $led_type=json_encode($this->input->post('led_type[]'));
                           $size=json_encode($this->input->post('size[]'));
                           $lens=json_encode($this->input->post('lens[]'));
                           $night_vision=json_encode($this->input->post('night_vision[]'));
                           $audio_type=json_encode($this->input->post('audio_type[]'));

                           $img1='fileToUpload1';

                           $file_check=($_FILES['fileToUpload1']['error']);
                           if ($file_check!=4) {
                               $image_upload_folder = FCPATH . "assets/uploads/minorcategory/";
                               if (!file_exists($image_upload_folder)) {
                                   mkdir($image_upload_folder, DIR_WRITE_MODE, true);
                               }
                               $new_file_name="minorcategory".date("Ymdhms");
                               $this->upload_config = array(
                                    'upload_path'   => $image_upload_folder,
                                    'file_name' => $new_file_name,
                                    'allowed_types' =>'jpg|jpeg|png',
                                    'max_size'      => 25000
                            );
                               $this->upload->initialize($this->upload_config);
                               if (!$this->upload->do_upload($img1)) {
                                   $upload_error = $this->upload->display_errors();
                                   $this->session->set_flashdata('emessage', $upload_error);
                                   redirect($_SERVER['HTTP_REFERER']);
                               } else {
                                   $file_info = $this->upload->data();

                                   $videoNAmePath = "assets/uploads/minorcategory/".$new_file_name.$file_info['file_ext'];
                                   $file_info['new_name']=$videoNAmePath;
                                   // $this->step6_model->updateappIconImage($imageNAmePath,$appInfoId);
                                   //$nnnn=$file_info['file_name'];
                                   $nnnn1=$videoNAmePath;
                                   // echo json_encode($file_info);
                               }
                           }

                           $ip = $this->input->ip_address();
                           date_default_timezone_set("Asia/Calcutta");
                           $cur_date=date("Y-m-d H:i:s");
                           $addedby=$this->session->userdata('admin_id');

                           $typ=base64_decode($t);
                           $last_id = 0;
                           if ($typ==1) {
                               $data_insert = array(
                  'category_id'=>$category_id,
  'subcategory_id'=>$subcategory_id,
  'minorcategoryname'=>$minorcategoryname,
  'brand'=>$brand,
  'resolution'=>$resolution,
  'ir_distance'=>$ir_distance,
  'camera_type'=>$camera_type,
  'body_materials'=>$body_materials,
  'video_channel'=>$video_channel,
  'poe_ports'=>$poe_ports,
  'poe_type'=>$poe_type,
  'sata_ports'=>$sata_ports,
  'length'=>$length,
  'screen_size'=>$screen_size,
  'led_type'=>$led_type,
  'size'=>$size,
  'lens'=>$lens,
  'night_vision'=>$night_vision,
  'audio_type'=>$audio_type,
  'image'=>$nnnn1,


                     'ip' =>$ip,
                     'added_by' =>$addedby,
                     'is_active' =>1,
                     'date'=>$cur_date
                     );


                               $last_id=$this->base_model->insert_table("tbl_minorcategory", $data_insert, 1) ;
                               if ($last_id!=0) {
                                   $this->session->set_flashdata('smessage', 'Minorcategory inserted successfully');
                                   redirect("dcadmin/Minorcategory/view_minorcategory", "refresh");
                               } else {
                                   $this->session->set_flashdata('emessage', 'Sorry error occured');
                                   redirect($_SERVER['HTTP_REFERER']);
                               }
                           }
                           if ($typ==2) {
                               $idw=base64_decode($iw);


                               $this->db->select('*');
                               $this->db->from('tbl_minorcategory');
                               $this->db->where('id', $idw);
                               $dsa=$this->db->get();
                               $da=$dsa->row();

                               if (!empty($nnnn1)) {
                                   $n1=$nnnn1;
                               } else {
                                   $n1=$da->image;
                               }




                               $data_insert = array(
                  'category_id'=>$category_id,
  'subcategory_id'=>$subcategory_id,
  'minorcategoryname'=>$minorcategoryname,
  'brand'=>$brand,
  'resolution'=>$resolution,
  'ir_distance'=>$ir_distance,
  'camera_type'=>$camera_type,
  'body_materials'=>$body_materials,
  'video_channel'=>$video_channel,
  'poe_ports'=>$poe_ports,
  'poe_type'=>$poe_type,
  'sata_ports'=>$sata_ports,
  'length'=>$length,
  'screen_size'=>$screen_size,
  'led_type'=>$led_type,
  'size'=>$size,
  'lens'=>$lens,
  'night_vision'=>$night_vision,
  'audio_type'=>$audio_type,
  'image'=>$n1

                     );
                               $this->db->where('id', $idw);
                               $last_id=$this->db->update('tbl_minorcategory', $data_insert);
                               if ($last_id!=0) {
                                   $this->session->set_flashdata('smessage', 'Minorcategory updated successfully');
                                   redirect("dcadmin/Minorcategory/view_minorcategory", "refresh");
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

           public function updateminorcategoryStatus($idd, $t)
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
                       $zapak=$this->db->update('tbl_minorcategory', $data_update);

                       if ($zapak!=0) {
                           $this->session->set_flashdata('smessage', 'Minorcategory status updated successfully');
                           redirect("dcadmin/Minorcategory/view_minorcategory", "refresh");
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
                       $zapak=$this->db->update('tbl_minorcategory', $data_update);

                       if ($zapak!=0) {
                           $this->session->set_flashdata('smessage', 'Minorcategory status updated successfully');

                           redirect("dcadmin/Minorcategory/view_minorcategory", "refresh");
                       } else {
                           $this->session->set_flashdata('emessage', 'Sorry error occured');
                           redirect($_SERVER['HTTP_REFERER']);
                       }
                   }
               } else {
                   redirect("login/admin_login", "refresh");
               }
           }



           public function delete_minorcategory($idd)
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
                       $this->db->from('tbl_minorcategory');
                       $this->db->where('id', $id);
                       $dsa= $this->db->get();
                       $da=$dsa->row();


                       $zapak=$this->db->delete('tbl_minorcategory', array('id' => $id));
                       $this->db->select('*');
                       $this->db->from('tbl_products');
                       $this->db->where('minorcategory_id', $id);
                       $product_data = $this->db->get();
                       foreach($product_data->result() as $pro){
                        $zapak=$this->db->delete('tbl_cart', array('product_id' => $id));
                        $zapak=$this->db->delete('tbl_wishlist', array('product_id' => $id));
                       }
                       $zapak=$this->db->delete('tbl_products', array('minorcategory_id' => $id));
                       if ($zapak!=0) {
                           $this->session->set_flashdata('smessage', 'Minorcategory deleted successfully');

                           redirect("dcadmin/Minorcategory/view_minorcategory", "refresh");
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
