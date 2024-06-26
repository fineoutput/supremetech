<?php

if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}
require_once(APPPATH . 'core/CI_finecontrol.php');
class Slider extends CI_finecontrol
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("login_model");
        $this->load->model("admin/base_model");
        $this->load->library('user_agent');
    }


    public function view_slider()
    {
        if (!empty($this->session->userdata('admin_data'))) {
            $data['user_name']=$this->load->get_var('user_name');

            // echo SITE_NAME;
            // echo $this->session->userdata('image');
            // echo $this->session->userdata('position');
            // exit;

            $this->db->select('*');
            $this->db->from('tbl_slider');
            //$this->db->where('id',$usr);
            $data['slider_data']= $this->db->get();


            $this->load->view('admin/common/header_view', $data);
            $this->load->view('admin/slider/view_slider');
            $this->load->view('admin/common/footer_view');
        } else {
            redirect("login/admin_login", "refresh");
        }
    }

    public function add_slider()
    {
        if (!empty($this->session->userdata('admin_data'))) {
            $data['user_name']=$this->load->get_var('user_name');

            // echo SITE_NAME;
            // echo $this->session->userdata('image');
            // echo $this->session->userdata('position');
            // exit;


            $this->load->view('admin/common/header_view', $data);
            $this->load->view('admin/slider/add_slider');
            $this->load->view('admin/common/footer_view');
        } else {
            redirect("login/admin_login", "refresh");
        }
    }

    public function add_slider_data($t, $iw="")
    {
        if (!empty($this->session->userdata('admin_data'))) {
            $this->load->helper(array('form', 'url'));
            $this->load->library('form_validation');
            $this->load->helper('security');
            // if ($this->input->post()) {
            //     $this->form_validation->set_rules('link', 'link', 'xss_clean|trim');
            //
            //     if ($this->form_validation->run()== true) {
            //         $link=$this->input->post('link');

                    // Load library
                    $this->load->library('upload');

                    $img1='web_image';

                    $file_check=($_FILES['web_image']['error']);
                    if ($file_check!=4) {
                        $image_upload_folder = FCPATH . "assets/uploads/slider/";
                        if (!file_exists($image_upload_folder)) {
                            mkdir($image_upload_folder, DIR_WRITE_MODE, true);
                        }
                        $new_file_name="web_slider".date("Ymdhms");
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

                            $web_image = "assets/uploads/slider/".$new_file_name.$file_info['file_ext'];
                        }
                    }
                    $img2='mob_image';

                    $file_check=($_FILES['mob_image']['error']);
                    if ($file_check!=4) {
                        $image_upload_folder = FCPATH . "assets/uploads/slider/";
                        if (!file_exists($image_upload_folder)) {
                            mkdir($image_upload_folder, DIR_WRITE_MODE, true);
                        }
                        $new_file_name="mob_slider".date("Ymdhms");
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

                            $mob_image = "assets/uploads/slider/".$new_file_name.$file_info['file_ext'];
                        }
                    }



                    $ip = $this->input->ip_address();
                    date_default_timezone_set("Asia/Calcutta");
                    $cur_date=date("Y-m-d H:i:s");

                    $addedby=$this->session->userdata('admin_id');

                    $typ=base64_decode($t);
                    if ($typ==1) {
                        $data_insert = array(
                          // 'link'=>$link,
                    'web_image'=>$web_image,
                    'mob_image'=>$mob_image,
                    'added_by' =>$addedby,
                    'is_active' =>1,
                    'date'=>$cur_date
                    );





                        $last_id=$this->base_model->insert_table("tbl_slider", $data_insert, 1) ;

                        if ($last_id!=0) {
                            $this->session->set_flashdata('smessage', 'Slider inserted successfully');

                            redirect("dcadmin/Slider/view_slider", "refresh");
                        } else {
                            $this->session->set_flashdata('emessage', 'Sorry error occured');
                            redirect($_SERVER['HTTP_REFERER']);
                        }
                    }
                    if ($typ==2) {
                        $idw=base64_decode($iw);
                        $this->db->select('*');
                        $this->db->from('tbl_slider');
                        $this->db->where('id', $idw);
                        $sliderdata= $this->db->get()->row();

                        if (empty($web_image)) {
                            $web_image = $sliderdata->web_image;
                        }
                        if (empty($mob_image)) {
                            $mob_image = $sliderdata->mob_image;
                        }
                        $data_insert = array(
                          // 'link'=>$link,
                            'web_image'=>$web_image,
                            'mob_image'=>$mob_image,
                          );



                        $this->db->where('id', $idw);
                        $last_id=$this->db->update('tbl_slider', $data_insert);

                        if ($last_id!=0) {
                            $this->session->set_flashdata('smessage', 'Slider updated successfully');

                            redirect("dcadmin/Slider/view_slider", "refresh");
                        } else {
                            $this->session->set_flashdata('emessage', 'Sorry error occured');
                            redirect($_SERVER['HTTP_REFERER']);
                        }
                    }
            //     } else {
            //         $this->session->set_flashdata('emessage', validation_errors());
            //         redirect($_SERVER['HTTP_REFERER']);
            //     }
            // } else {
            //     $this->session->set_flashdata('emessage', 'Please insert some data, No data available');
            //     redirect($_SERVER['HTTP_REFERER']);
            // }
        } else {
            redirect("login/admin_login", "refresh");
        }
    }


    public function update_slider($idd)
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
            $this->db->from('tbl_slider');
            $this->db->where('id', $id);
            $dsa= $this->db->get();
            $data['slider']=$dsa->row();


            $this->load->view('admin/common/header_view', $data);
            $this->load->view('admin/slider/update_slider');
            $this->load->view('admin/common/footer_view');
        } else {
            redirect("login/admin_login", "refresh");
        }
    }

    public function delete_slider($idd)
    {
        if (!empty($this->session->userdata('admin_data'))) {
            $data['user_name']=$this->load->get_var('user_name');

            // echo SITE_NAME;
            // echo $this->session->userdata('image');
            // echo $this->session->userdata('position');
            // exit;
            $id=base64_decode($idd);

            if ($this->load->get_var('position')=="Super Admin") {
                $zapak=$this->db->delete('tbl_slider', array('id' => $id));
                if ($zapak!=0) {
                    $this->session->set_flashdata('smessage', 'Slider deleted successfully');
                    redirect($_SERVER['HTTP_REFERER']);
                } else {
                    echo "Error";
                    exit;
                }
            } else {
                $this->session->set_flashdata('emessage', 'Sorry You Dont Have Permission To Delete Anything');
                redirect($_SERVER['HTTP_REFERER']);
            }
        } else {
            $this->load->view('admin/login/index');
        }
    }

    public function updatesliderStatus($idd, $t)
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
                $zapak=$this->db->update('tbl_slider', $data_update);

                if ($zapak!=0) {
                    $this->session->set_flashdata('smessage', 'Slider status updated successfully');
                    redirect($_SERVER['HTTP_REFERER']);
                } else {
                    $this->session->set_flashdata('emessage', 'Some error occured');
                    redirect($_SERVER['HTTP_REFERER']);
                }
            }
            if ($t=="inactive") {
                $data_update = array(
          'is_active'=>0

          );

                $this->db->where('id', $id);
                $zapak=$this->db->update('tbl_slider', $data_update);

                if ($zapak!=0) {
                    $this->session->set_flashdata('smessage', 'Slider status updated successfully');
                    redirect($_SERVER['HTTP_REFERER']);
                } else {
                    $this->session->set_flashdata('emessage', 'Some error occured');
                    redirect($_SERVER['HTTP_REFERER']);
                }
            }
        } else {
            $this->load->view('admin/login/index');
        }
    }
}
