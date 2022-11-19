<?php

if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}
require_once(APPPATH . 'core/CI_finecontrol.php');
class State extends CI_finecontrol
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("admin/login_model");
        $this->load->model("admin/base_model");
        $this->load->library("upload");
    }
    //==============================VIEW  BRAND==================================//
    public function view_state()
    {
        if (!empty($this->session->userdata('admin_data'))) {
            $data['user_name']=$this->load->get_var('user_name');
            $this->db->select('*');
            $this->db->from('all_states');
              $this->db->order_by('id', 'desc');
            $data['state_data']= $this->db->get();
            $this->load->view('admin/common/header_view', $data);
            $this->load->view('admin/state/view_state');
            $this->load->view('admin/common/footer_view');
        } else {
            redirect("login/admin_login", "refresh");
        }
    }
    //==============================ADD BRAND==================================//
    public function add_state()
    {
        if (!empty($this->session->userdata('admin_data'))) {
            $data['user_name']=$this->load->get_var('user_name');
            $this->load->view('admin/common/header_view', $data);
            $this->load->view('admin/state/add_state');
            $this->load->view('admin/common/footer_view');
        } else {
            redirect("login/admin_login", "refresh");
        }
    }
    //==============================ADD BRAND DATA==================================//
    public function add_state_data($t, $iw="")
    {
        if (!empty($this->session->userdata('admin_data'))) {
            $this->load->helper(array('form', 'url'));
            $this->load->library('form_validation');
            $this->load->helper('security');
            if ($this->input->post()) {
                $this->form_validation->set_rules('state_name', 'state_name', 'required|xss_clean|trim');
                if ($this->form_validation->run()== true) {
                    $state_name=$this->input->post('state_name');
                    $ip = $this->input->ip_address();
                    date_default_timezone_set("Asia/Calcutta");
                    $cur_date=date("Y-m-d H:i:s");
                    $addedby=$this->session->userdata('admin_id');
                    // $cat = explode(" ", $name);
                    // $url = implode("-", $cat);
                    $typ=base64_decode($t);
                    if ($typ==1) {
                        $data_insert = array('state_name'=>$state_name,
                        // 'image'=>$nnnn,
                          'ip' =>$ip,
                                'added_by' =>$addedby,
                                'is_active' =>1,
                                'date'=>$cur_date
                                );
                        $last_id=$this->base_model->insert_table("all_states", $data_insert, 1) ;
                        if ($last_id!=0) {
                            $this->session->set_flashdata('smessage', 'Data inserted successfully');
                            redirect("dcadmin/State/view_state", "refresh");
                        } else {
                            $this->session->set_flashdata('emessage', 'Sorry error occurred');
                            redirect($_SERVER['HTTP_REFERER']);
                        }
                    }
                    if ($typ==2) {
                        $idw=base64_decode($iw);
                        $this->db->select('*');
                        $this->db->from('all_states');
                        $this->db->where('id', $idw);
                        $pro_data= $this->db->get()->row();
                        // if (empty($nnnn)) {
                        //     $nnnn=$pro_data->image;
                        // }
                        $data_insert = array('state_name'=>$state_name,
                              // 'image'=>$nnnn,
                                          );
                        $this->db->where('id', $idw);
                        $last_id=$this->db->update('all_states', $data_insert);
                        if ($last_id!=0) {
                            $this->session->set_flashdata('smessage', 'Data updated successfully');
                            redirect("dcadmin/State/view_state", "refresh");
                        } else {
                            $this->session->set_flashdata('emessage', 'Sorry error occurred');
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
    //==============================UPDATE BRAND==================================//
    public function update_state($idd)
    {
        if (!empty($this->session->userdata('admin_data'))) {
            $data['user_name']=$this->load->get_var('user_name');
            $id=base64_decode($idd);
            $data['id']=$idd;
            $this->db->select('*');
            $this->db->from('all_states');
            $this->db->where('id', $id);
            $dsa= $this->db->get();
            $data['state']=$dsa->row();
            $this->load->view('admin/common/header_view', $data);
            $this->load->view('admin/state/update_state');
            $this->load->view('admin/common/footer_view');
        } else {
            redirect("login/admin_login", "refresh");
        }
    }
    //==============================DELETE BRAND==================================//
    public function delete_state($idd)
    {
        if (!empty($this->session->userdata('admin_data'))) {
            $data['user_name']=$this->load->get_var('user_name');
            $id=base64_decode($idd);
            if ($this->load->get_var('position')=="Super Admin") {
                $zapak=$this->db->delete('all_states', array('id' => $id));
                if ($zapak!=0) {
                    redirect("dcadmin/State/view_state", "refresh");
                } else {
                    echo "Error";
                    exit;
                }
            } else {
                $data['e']="Sorry You Don't Have Permission To Delete Anything.";
                $this->load->view('errors/error500admin', $data);
            }
        } else {
            $this->load->view('admin/login/index');
        }
    }    //==============================UPDATE BRAND STATUS==================================//
    public function updatebrandStatus($idd, $t)
    {
        if (!empty($this->session->userdata('admin_data'))) {
            $data['user_name']=$this->load->get_var('user_name');
            $id=base64_decode($idd);
            if ($t=="active") {
                $data_update = array(
 'is_active'=>1
 );
                $this->db->where('id', $id);
                $zapak=$this->db->update('all_states', $data_update);
                if ($zapak!=0) {
                    redirect("dcadmin/State/view_state", "refresh");
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
                $zapak=$this->db->update('all_states', $data_update);
                if ($zapak!=0) {
                    redirect("dcadmin/State/view_state", "refresh");
                } else {
                    $data['e']="Error Occured";
                    $this->load->view('errors/error500admin', $data);
                }
            }
        } else {
            $this->load->view('admin/login/index');
        }
    }
}
//==============================END BRAND==================================//
