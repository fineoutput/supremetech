<?php

if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}
require_once(APPPATH . 'core/CI_finecontrol.php');
class Push_notifi extends CI_finecontrol
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("login_model");
        $this->load->model("admin/base_model");
        $this->load->library('user_agent');
        $this->load->library('upload');
    }

    public function view_push_notifi()
    {
        if (!empty($this->session->userdata('admin_data'))) {
            $data['user_name']=$this->load->get_var('user_name');

            // echo SITE_NAME;
            // echo $this->session->userdata('image');
            // echo $this->session->userdata('position');
            // exit;

            $this->db->select('*');
            $this->db->from('tbl_push_notifi');
            //$this->db->where('id',$usr);
            $this->db->order_by('id', 'desc');
            $data['push_notifi_data']= $this->db->get();

            $this->load->view('admin/common/header_view', $data);
            $this->load->view('admin/push_notifi/view_push_notifi');
            $this->load->view('admin/common/footer_view');
        } else {
            redirect("login/admin_login", "refresh");
        }
    }

    public function add_push_notifi()
    {
        if (!empty($this->session->userdata('admin_data'))) {
            $this->load->view('admin/common/header_view');
            $this->load->view('admin/push_notifi/add_push_notifi');
            $this->load->view('admin/common/footer_view');
        } else {
            redirect("login/admin_login", "refresh");
        }
    }

    public function update_push_notifi($idd)
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
            $this->db->from('tbl_push_notifi');
            $this->db->where('id', $id);
            $data['push_notifi_data']= $this->db->get()->row();


            $this->load->view('admin/common/header_view', $data);
            $this->load->view('admin/push_notifi/update_push_notifi');
            $this->load->view('admin/common/footer_view');
        } else {
            redirect("login/admin_login", "refresh");
        }
    }

    public function add_push_notifi_data($t, $iw="")
    {
        if (!empty($this->session->userdata('admin_data'))) {
            $this->load->helper(array('form', 'url'));
            $this->load->library('form_validation');
            $this->load->helper('security');
            if ($this->input->post()) {
                // print_r($this->input->post());
                // exit;
                $this->form_validation->set_rules('title', 'title', 'required');
                $this->form_validation->set_rules('content', 'content', 'trim');
                if ($this->form_validation->run()== true) {
                    $title=$this->input->post('title');
                    $content=$this->input->post('content');

                    $ip = $this->input->ip_address();
                    date_default_timezone_set("Asia/Calcutta");
                    $cur_date=date("Y-m-d H:i:s");
                    $addedby=$this->session->userdata('admin_id');

                    $typ=base64_decode($t);
                    $last_id = 0;
                    if ($typ==1) {
                        $img0='image';
                        $nnnn0 = '';
                        $image_upload_folder = FCPATH . "assets/uploads/push_notifi/";
                        if (!file_exists($image_upload_folder)) {
                            mkdir($image_upload_folder, DIR_WRITE_MODE, true);
                        }
                        $new_file_name="push_notifi".date("Ymdhms");
                        $this->upload_config = array(
'upload_path'   => $image_upload_folder,
'file_name' => $new_file_name,
'allowed_types' =>'jpg|jpeg|png',
'max_size'      => 25000
);
                        $this->upload->initialize($this->upload_config);
                        if (!$this->upload->do_upload($img0)) {
                            $upload_error = $this->upload->display_errors();
                        // $this->session->set_flashdata('emessage', $upload_error);
// redirect($_SERVER['HTTP_REFERER']);
                        } else {
                            $file_info = $this->upload->data();

                            $videoNAmePath = "assets/uploads/push_notifi/".$new_file_name.$file_info['file_ext'];
                            $file_info['new_name']=$videoNAmePath;
                            // $this->step6_model->updateappIconImage($imageNAmePath,$appInfoId);
                            $nnnn=$file_info['file_name'];
                            $nnnn0=$videoNAmePath;
                        }

                        $data_insert = array(
'title'=>$title,
'image'=>$nnnn0,
'content'=>$content,

'ip' =>$ip,
'added_by' =>$addedby,
'is_active' =>1,
'date'=>$cur_date
);
                        $last_id=$this->base_model->insert_table("tbl_push_notifi", $data_insert, 1) ;

                        if ($last_id!=0) {
                            //----sent push notification to user---------



                            $url = 'https://fcm.googleapis.com/fcm/send';
                            $msg2 = array(
                                'title'=>$title,
                                'body'=>$content,
                                'image'=>base_url().$nnnn0,
                                'picture'=>base_url().$nnnn0,
                                "sound" => "default"
                                );




                            // echo $user_device_tokens->device_token; die();



                            $fields = array(
'to'=>"/topics/all",
'notification'=>$msg2,
'priority'=>'high'
);



                            $fields = json_encode($fields);



                            $headers = array(
'Authorization: key=' . AUTHORIZATION_KEY_PUSH,
'Content-Type: application/json'
);



                            $ch = curl_init();
                            curl_setopt($ch, CURLOPT_URL, $url);
                            curl_setopt($ch, CURLOPT_POST, true);
                            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);



                            $result = curl_exec($ch);
                            // echo $fields;
                            curl_close($ch);
                            $this->session->set_flashdata('smessage', 'Push notification inserted successfully');
                            redirect("dcadmin/Push_notifi/view_push_notifi", "refresh");
                        } else {
                            $this->session->set_flashdata('emessage', 'Sorry error occured');
                            redirect($_SERVER['HTTP_REFERER']);
                        }
                    }
                    if ($typ==2) {
                        $idw=base64_decode($iw);


                        $this->db->select('*');
                        $this->db->from('tbl_push_notifi');
                        $this->db->where('id', $idw);
                        $dsa=$this->db->get();
                        $da=$dsa->row();



                        $img0='image';




                        $image_upload_folder = FCPATH . "assets/uploads/push_notifi/";
                        if (!file_exists($image_upload_folder)) {
                            mkdir($image_upload_folder, DIR_WRITE_MODE, true);
                        }
                        $new_file_name="push_notifi".date("Ymdhms");
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

                            $videoNAmePath = "assets/uploads/push_notifi/".$new_file_name.$file_info['file_ext'];
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
'content'=>$content,

);
                        $this->db->where('id', $idw);
                        $last_id=$this->db->update('tbl_push_notifi', $data_insert);
                        if ($last_id!=0) {
                            $this->session->set_flashdata('smessage', 'Push notification updated successfully');
                            redirect("dcadmin/Push_notifi/view_push_notifi", "refresh");
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

    public function updatepush_notifiStatus($idd, $t)
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
                $zapak=$this->db->update('tbl_push_notifi', $data_update);

                if ($zapak!=0) {
                    $this->session->set_flashdata('smessage', 'Push notification status updated successfully');
                    redirect("dcadmin/Push_notifi/view_push_notifi", "refresh");
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
                $zapak=$this->db->update('tbl_push_notifi', $data_update);

                if ($zapak!=0) {
                    $this->session->set_flashdata('smessage', 'Push notification status updated successfully');
                    redirect("dcadmin/Push_notifi/view_push_notifi", "refresh");
                } else {
                    $this->session->set_flashdata('emessage', 'Sorry error occured');
                    redirect($_SERVER['HTTP_REFERER']);
                }
            }
        } else {
            redirect("login/admin_login", "refresh");
        }
    }



    public function delete_push_notifi($idd)
    {
        if (!empty($this->session->userdata('admin_data'))) {
            $data['user_name']=$this->load->get_var('user_name');


            $id=base64_decode($idd);

            if ($this->load->get_var('position')=="Super Admin") {
                $this->db->from('tbl_push_notifi');
                $this->db->where('id', $id);
                $dsa= $this->db->get();
                $da=$dsa->row();


                $zapak=$this->db->delete('tbl_push_notifi', array('id' => $id));
                if ($zapak!=0) {
                    $this->session->set_flashdata('smessage', 'Push notification deleted successfully');
                    redirect("dcadmin/Push_notifi/view_push_notifi", "refresh");
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
