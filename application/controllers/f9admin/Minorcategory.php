<?php
    if ( ! defined('BASEPATH')) exit('No direct script access allowed');
       require_once(APPPATH . 'core/CI_finecontrol.php');
       class Minorcategory extends CI_finecontrol{
       function __construct()
           {
             parent::__construct();
             $this->load->model("login_model");
             $this->load->model("admin/base_model");
             $this->load->library('user_agent');
             $this->load->library('upload');
           }

         public function view_minorcategory(){

            if(!empty($this->session->userdata('admin_data'))){


              $data['user_name']=$this->load->get_var('user_name');

              // echo SITE_NAME;
              // echo $this->session->userdata('image');
              // echo $this->session->userdata('position');
              // exit;

                           $this->db->select('*');
               $this->db->from('tbl_minorcategory');
               //$this->db->where('id',$usr);
               $data['minorcategory_data']= $this->db->get();

              $this->load->view('admin/common/header_view',$data);
              $this->load->view('admin/minorcategory/view_minorcategory');
              $this->load->view('admin/common/footer_view');

          }
          else{

             redirect("login/admin_login","refresh");
          }

          }

              public function add_minorcategory(){

                 if(!empty($this->session->userdata('admin_data'))){

            $this->db->select('*');
$this->db->from('tbl_category');
//$this->db->where('id',$usr);
$data['category_data']= $this->db->get();

            $this->db->select('*');
$this->db->from('tbl_subcategory');
//$this->db->where('id',$usr);
$data['subcategory_data']= $this->db->get();


                   $this->load->view('admin/common/header_view',$data);
                   $this->load->view('admin/minorcategory/add_minorcategory');
                   $this->load->view('admin/common/footer_view');

               }
               else{

                  redirect("login/admin_login","refresh");
               }

               }
               public function getSubcategory(){

                                  // $data['user_name']=$this->load->get_var('user_name');

                                  // echo SITE_NAME;
                                  // echo $this->session->userdata('image');
                                  // echo $this->session->userdata('position');
                                  // exit;

               $id=$_GET['isl'];
                           $this->db->select('*');
               $this->db->from('tbl_subcategory');
               $this->db->where('category_id',$id);
               $dat= $this->db->get();

               $i=1; foreach($dat->result() as $data) {

               $igt[] = array('sub_id' =>$data->id ,'sub_name'=>$data->subcategory);

               }


               echo json_encode($igt);


                              }

               public function update_minorcategory($idd){

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
                            // $this->db->where('id',$id);
                            $data['subcategory_data']= $this->db->get();

                                        $this->db->select('*');
                            $this->db->from('tbl_category');
                            //$this->db->where('id',$usr);
                            $data['category_data']= $this->db->get();

                                        $this->db->select('*');
                            $this->db->from('tbl_minorcategory');
                            $this->db->where('id',$id);
                            $data['minorcategory_data']= $this->db->get()->row();


                     $this->load->view('admin/common/header_view',$data);
                     $this->load->view('admin/minorcategory/update_minorcategory');
                     $this->load->view('admin/common/footer_view');

                 }
                 else{

                    redirect("login/admin_login","refresh");
                 }

                 }

             public function add_minorcategory_data($t,$iw="")

               {

                 if(!empty($this->session->userdata('admin_data'))){


             $this->load->helper(array('form', 'url'));
             $this->load->library('form_validation');
             $this->load->helper('security');
             if($this->input->post())
             {
               // print_r($this->input->post());
               // exit;
  $this->form_validation->set_rules('category_id', 'category_id', 'required|trim');
  $this->form_validation->set_rules('subcategory_id', 'subcategory_id', 'required|trim');
  $this->form_validation->set_rules('minorcategoryname', 'minorcategoryname', 'trim');





               if($this->form_validation->run()== TRUE)
               {
  $category_id=$this->input->post('category_id');
  $subcategory_id=$this->input->post('subcategory_id');
  $minorcategoryname=$this->input->post('minorcategoryname');

  $img1='fileToUpload1';

              $file_check=($_FILES['fileToUpload1']['error']);
              if($file_check!=4){
            	$image_upload_folder = FCPATH . "assets/uploads/minorcategory/";
    						if (!file_exists($image_upload_folder))
    						{
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
    						if (!$this->upload->do_upload($img1))
    						{
    							$upload_error = $this->upload->display_errors();
    							// echo json_encode($upload_error);
    							echo $upload_error;
    						}
    						else
    						{

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
           if($typ==1){



           $data_insert = array(
                  'category_id'=>$category_id,
  'subcategory_id'=>$subcategory_id,
  'minorcategoryname'=>$minorcategoryname,
  'image'=>$nnnn1,


                     'ip' =>$ip,
                     'added_by' =>$addedby,
                     'is_active' =>1,
                     'date'=>$cur_date
                     );


           $last_id=$this->base_model->insert_table("tbl_minorcategory",$data_insert,1) ;

           }
           if($typ==2){

    $idw=base64_decode($iw);


 $this->db->select('*');
 $this->db->from('tbl_minorcategory');
 $this->db->where('id',$idw);
 $dsa=$this->db->get();
 $da=$dsa->row();

if(!empty($nnnn1)){
  $n1=$nnnn1;
}else{
  $n1=$da->image;
}




           $data_insert = array(
                  'category_id'=>$category_id,
  'subcategory_id'=>$subcategory_id,
  'minorcategoryname'=>$minorcategoryname,
  'image'=>$n1

                     );
             $this->db->where('id', $idw);
             $last_id=$this->db->update('tbl_minorcategory', $data_insert);
           }
                       if($last_id!=0){
                               $this->session->set_flashdata('smessage','Data inserted successfully');
                               redirect("dcadmin/minorcategory/view_minorcategory","refresh");
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

               public function updateminorcategoryStatus($idd,$t){

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
                       $zapak=$this->db->update('tbl_minorcategory', $data_update);

                            if($zapak!=0){
                            redirect("dcadmin/minorcategory/view_minorcategory","refresh");
                                    }
                                    else
                                    {
        $this->session->set_flashdata('emessage','Sorry error occured');
          redirect($_SERVER['HTTP_REFERER']);
                                    }
                          }
                          if($t=="inactive"){
                            $data_update = array(
                         'is_active'=>0

                         );

                         $this->db->where('id', $id);
                         $zapak=$this->db->update('tbl_minorcategory', $data_update);

                             if($zapak!=0){
                             redirect("dcadmin/minorcategory/view_minorcategory","refresh");
                                     }
                                     else
                                     {

                $this->session->set_flashdata('emessage','Sorry error occured');
                  redirect($_SERVER['HTTP_REFERER']);
                                     }
                          }



                      }
                      else{

                         redirect("login/admin_login","refresh");

                      }

                      }



               public function delete_minorcategory($idd){

                      if(!empty($this->session->userdata('admin_data'))){

                        $data['user_name']=$this->load->get_var('user_name');

                        // echo SITE_NAME;
                        // echo $this->session->userdata('image');
                        // echo $this->session->userdata('position');
                        // exit;
                        $id=base64_decode($idd);

                       if($this->load->get_var('position')=="Super Admin"){

                     $this->db->select('*');
                     $this->db->from('tbl_minorcategory');
                     $this->db->where('id',$id);
                     $dsa= $this->db->get();
                     $da=$dsa->row();


 $zapak=$this->db->delete('tbl_minorcategory', array('id' => $id));
 if($zapak!=0){

        redirect("dcadmin/minorcategory/view_minorcategory","refresh");
                }
                else
                {
                   $this->session->set_flashdata('emessage','Sorry error occured');
                   redirect($_SERVER['HTTP_REFERER']);
                }
            }
            else{
             $this->session->set_flashdata('emessage','Sorry you not a super admin you dont have permission to delete anything');
               redirect($_SERVER['HTTP_REFERER']);
            }


                            }
                            else{

                        redirect("login/admin_login","refresh");

                            }

                            }
                      }

      ?>
