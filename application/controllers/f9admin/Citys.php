<?php

if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}
require_once(APPPATH . 'core/CI_finecontrol.php');
class Citys extends CI_finecontrol
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("admin/login_model");
        $this->load->model("admin/base_model");
        $this->load->library("upload");
    }
    //==============================VIEW  BRAND TYPE==================================//
    public function view_city($idd)
    {
        if (!empty($this->session->userdata('admin_data'))) {
            $data['user_name']=$this->load->get_var('user_name');
            $data['user_name']=$this->load->get_var('user_name');
            $id=base64_decode($idd);
            $data['id']=$idd;
            $this->db->order_by('id', 'desc');
            $this->db->select('*');
            $this->db->from('all_cities');
            $this->db->where('state_id', $id);

            $data['citys_data']= $this->db->get();

            $this->db->select('*');
            $this->db->from('all_states');
            $this->db->where('id', $id);
            $state = $this->db->get()->row();
            $data['state_id'] = $state->id;
            $data['heading'] = $state->state_name;

            $this->load->view('admin/common/header_view', $data);
            $this->load->view('admin/citys/view_city');
            $this->load->view('admin/common/footer_view');
        } else {
            redirect("login/admin_login", "refresh");
        }
    }
    //==============================ADD BRAND TYPE==================================//
    public function add_city($state_id)
    {
        if (!empty($this->session->userdata('admin_data'))) {
            $data['user_name']=$this->load->get_var('user_name');
            $id=base64_decode($state_id);
            $data['id']=$state_id;
            $this->db->select('*');
            $this->db->from('all_states');
            $this->db->where('id', $id);
            $state_data = $this->db->get()->row();
            $this->load->view('admin/common/header_view', $data);
            $this->load->view('admin/citys/add_city');
            $this->load->view('admin/common/footer_view');
        } else {
            redirect("login/admin_login", "refresh");
        }
    }
    //==============================ADD BRAND TYPE DATA==================================//
    public function add_city_data($t, $iw="")
    {
        if (!empty($this->session->userdata('admin_data'))) {
            $this->load->helper(array('form', 'url'));
            $this->load->library('form_validation');
            $this->load->helper('security');
            if ($this->input->post()) {
                $this->form_validation->set_rules('state_id', 'state_id', 'required|xss_clean|trim');
                $this->form_validation->set_rules('city_name', 'city_name', 'required|xss_clean|trim');
                if ($this->form_validation->run()== true) {
                    $state_id=$this->input->post('state_id');
                    $city_name=$this->input->post('city_name');
                    $ip = $this->input->ip_address();
                    date_default_timezone_set("Asia/Calcutta");
                    $cur_date=date("Y-m-d H:i:s");
                    $addedby=$this->session->userdata('admin_id');
                    // $cat = explode(" ", $name);
                    // $url = implode("-", $cat);
                    $typ=base64_decode($t);
                    if ($typ==1) {
                        $data_insert = array('state_id'=>base64_decode($state_id),
                        'city_name'=>$city_name,
                          'ip' =>$ip,
                                'added_by' =>$addedby,
                                'is_active' =>1,
                                'date'=>$cur_date
                                );
                        $last_id=$this->base_model->insert_table("all_cities", $data_insert, 1) ;
                        if ($last_id!=0) {
                            $this->session->set_flashdata('smessage', 'Data inserted successfully');
                            redirect("dcadmin/Citys/view_city/".$state_id, "refresh");
                        } else {
                            $this->session->set_flashdata('emessage', 'Sorry error occurred');
                            redirect($_SERVER['HTTP_REFERER']);
                        }
                    }
                    if ($typ==2) {
                        $idw=base64_decode($iw);
                        $this->db->select('*');
                        $this->db->from('all_cities');
                        $this->db->where('id', $idw);
                        $pro_data= $this->db->get()->row();
                        $data_insert = array('state_id'=>base64_decode($state_id),
                        'name'=>$name
                                          );
                        $this->db->where('id', $idw);
                        $last_id=$this->db->update('all_cities', $data_insert);
                        if ($last_id!=0) {
                            $this->session->set_flashdata('smessage', 'Data updated successfully');
                            redirect("dcadmin/Citys/view_city/".base64_encode($state_id), "refresh");
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
    //==============================UPDATE BRAND TYPE==================================//
    public function update_city($idd)
    {
        if (!empty($this->session->userdata('admin_data'))) {
            $data['user_name']=$this->load->get_var('user_name');
            $id=base64_decode($idd);
            $data['id']=$idd;
            $this->db->select('*');
            $this->db->from('all_cities');
            $this->db->where('id', $id);
            $dsa= $this->db->get();
            $data['Citys']=$dsa->row();
            $this->load->view('admin/common/header_view', $data);
            $this->load->view('admin/Citys/update_city');
            $this->load->view('admin/common/footer_view');
        } else {
            redirect("login/admin_login", "refresh");
        }
    }
    //==============================DELETE BRAND TYPE==================================//
    public function delete_Citys($idd)
    {
        if (!empty($this->session->userdata('admin_data'))) {
            $data['user_name']=$this->load->get_var('user_name');
            $id=base64_decode($idd);
            $this->db->select('*');
            $this->db->from('all_cities');
            $this->db->where('id', $id);
            $type_data = $this->db->get()->row();
            if ($this->load->get_var('position')=="Super Admin") {
                $zapak=$this->db->delete('all_cities', array('id' => $id));
                if ($zapak!=0) {
                    $this->session->set_flashdata('smessage', 'Data deleted successfully');
                    redirect("dcadmin/Citys/view_city/".$idd, "refresh");
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
    }
    //==========================UPDATE BRAND TYPE STATUS================================//
    public function updateCitysStatus($idd, $t)
    {
        if (!empty($this->session->userdata('admin_data'))) {
            $id=base64_decode($idd);
            $id=base64_decode($idd);
            $this->db->select('*');
            $this->db->from('all_cities');
            $this->db->where('id', $id);
            $type_data = $this->db->get()->row();
            if ($t=="active") {
                $data_update = array(
                'is_active'=>1
 );
                $this->db->where('id', $id);
                $zapak=$this->db->update('all_cities', $data_update);
                if ($zapak!=0) {
                    redirect("dcadmin/Citys/view_city/".base64_encode($type_data->state_id), "refresh");
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
                $zapak=$this->db->update('all_cities', $data_update);
                if ($zapak!=0) {
                    redirect("dcadmin/Citys/view_city/".base64_encode($type_data->state_id), "refresh");
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
                $zapak=$this->db->update('all_cities', $data_update);
                $this->session->set_flashdata('smessage', 'Data updated successfully');
                if ($zapak!=0) {
                    redirect("dcadmin/Citys/view_city/".base64_encode($type_data->state_id), "refresh");
                } else {
                    $data['e']="Error occurred";
                    $this->load->view('errors/error500admin', $data);
                }
            }
        } else {
            $this->load->view('admin/login/index');
        }
    }
}
//==============================END BRAND TYPE==================================//
