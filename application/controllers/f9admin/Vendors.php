<?php

if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}
require_once(APPPATH . 'core/CI_finecontrol.php');
class Vendors extends CI_finecontrol
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("login_model");
        $this->load->model("admin/base_model");
        $this->load->library('user_agent');
    }


    public function view_vendors()
    {
        if (!empty($this->session->userdata('admin_data'))) {
            $data['user_name']=$this->load->get_var('user_name');

            // echo SITE_NAME;
            // echo $this->session->userdata('image');
            // echo $this->session->userdata('position');
            // exit;

            $this->db->select('*');
            $this->db->from('tbl_users');
            $this->db->order_by('id', 'desc');
            //$this->db->where('id',$usr);
            $data['vendors_data']= $this->db->get();


            $this->load->view('admin/common/header_view', $data);
            $this->load->view('admin/vendors/view_vendors');
            $this->load->view('admin/common/footer_view');
        } else {
            redirect("login/admin_login", "refresh");
        }
    }

    public function add_vendors()
    {
        if (!empty($this->session->userdata('admin_data'))) {
            $data['user_name']=$this->load->get_var('user_name');

            // echo SITE_NAME;
            // echo $this->session->userdata('image');
            // echo $this->session->userdata('position');
            // exit;


            $this->load->view('admin/common/header_view', $data);
            $this->load->view('admin/vendors/add_vendors');
            $this->load->view('admin/common/footer_view');
        } else {
            redirect("login/admin_login", "refresh");
        }
    }

    public function add_vendors_data($t, $iw="")
    {
        if (!empty($this->session->userdata('admin_data'))) {
            $this->load->helper(array('form', 'url'));
            $this->load->library('form_validation');
            $this->load->helper('security');
            if ($this->input->post()) {
                // print_r($this->input->post());
                // exit;
                $this->form_validation->set_rules('firstname', 'firstname', 'required|xss_clean|trim');
                $this->form_validation->set_rules('lastname', 'lastname', 'xss_clean|trim');
                $this->form_validation->set_rules('dateofbirth', 'dateofbirth', 'required|xss_clean|trim');
                $this->form_validation->set_rules('email', 'email', 'required|valid_email|xss_clean|trim');
                $this->form_validation->set_rules('password', 'password', 'required|xss_clean|trim');
                $this->form_validation->set_rules('gstin', 'gstin', 'required|xss_clean|trim');
                $this->form_validation->set_rules('address', 'address', 'required|xss_clean|trim');
                $this->form_validation->set_rules('cityname', 'cityname', 'required|xss_clean|trim');

                if ($this->form_validation->run()== true) {
                    $firstname=$this->input->post('firstname');
                    $lastname=$this->input->post('lastname');
                    $dateofbirth=$this->input->post('dateofbirth');
                    $email=$this->input->post('email');
                    $password=$this->input->post('password');
                    $gstin=$this->input->post('gstin');
                    $address=$this->input->post('address');
                    $cityname=$this->input->post('cityname');

                    $ip = $this->input->ip_address();
                    date_default_timezone_set("Asia/Calcutta");
                    $cur_date=date("Y-m-d H:i:s");

                    $addedby=$this->session->userdata('admin_id');

                    $typ=base64_decode($t);
                    if ($typ==1) {
                        $data_insert = array('firstname'=>$firstname,
                    'lastname'=>$lastname,
                    'dateofbirth'=>$dateofbirth,
                    'email'=>$email,
                    'password'=>$password,
                    'gstin'=>$gstin,
                    'address'=>$address,
                    'cityname'=>$cityname,
                    'ip' =>$ip,
                    'added_by' =>$addedby,
                    'is_active' =>1,
                    'date'=>$cur_date

                    );





                        $last_id=$this->base_model->insert_table("tbl_vendors", $data_insert, 1) ;
												if ($last_id!=0) {
		                        $this->session->set_flashdata('smessage', 'Vendor inserted successfully');

		                        redirect("dcadmin/Vendors/view_vendors", "refresh");
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

                        $data_insert = array('firstname'=>$firstname,
                    'lastname'=>$lastname,
                    'dateofbirth'=>$dateofbirth,
                    'email'=>$email,
                    'password'=>$password,
                    'gstin'=>$gstin,
                    'address'=>$address,
                    'cityname'=>$cityname,
                    );




                        $this->db->where('id', $idw);
                        $last_id=$this->db->update('tbl_vendors', $data_insert);
												if ($last_id!=0) {
		                        $this->session->set_flashdata('smessage', 'Vendor updated successfully');

		                        redirect("dcadmin/Vendors/view_vendors", "refresh");
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


    public function update_vendors($idd)
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
            $this->db->from('tbl_vendors');
            $this->db->where('id', $id);
            $dsa= $this->db->get();
            $data['vendors']=$dsa->row();


            $this->load->view('admin/common/header_view', $data);
            $this->load->view('admin/vendors/update_vendors');
            $this->load->view('admin/common/footer_view');
        } else {
            redirect("login/admin_login", "refresh");
        }
    }

    public function delete_vendors($idd)
    {
        if (!empty($this->session->userdata('admin_data'))) {
            $data['user_name']=$this->load->get_var('user_name');

            // echo SITE_NAME;
            // echo $this->session->userdata('image');
            // echo $this->session->userdata('position');
            // exit;
            $id=base64_decode($idd);

            if ($this->load->get_var('position')=="Super Admin") {
                $zapak=$this->db->delete('tbl_vendors', array('id' => $id));
                if ($zapak!=0) {
									$this->session->set_flashdata('smessage', 'Vendor deleted successfully');
                    redirect("dcadmin/Vendors/view_vendors", "refresh");
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

    public function updatevendorsStatus($idd, $t)
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
                $zapak=$this->db->update('tbl_users', $data_update);

                if ($zapak!=0) {
									$this->session->set_flashdata('smessage', 'Vendor status updated successfully');
                    redirect("dcadmin/Vendors/view_vendors", "refresh");
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
                $zapak=$this->db->update('tbl_users', $data_update);

                if ($zapak!=0) {
									$this->session->set_flashdata('smessage', 'Vendor status updated successfully');

                    redirect("dcadmin/Vendors/view_vendors", "refresh");
                } else {
									$this->session->set_flashdata('emessage', 'Some error occured');
						redirect($_SERVER['HTTP_REFERER']);
                }
            }
        } else {
            $this->load->view('admin/login/index');
        }
    }

    public function updateVendorRequestStatus($idd, $stat)
    {
        if (!empty($this->session->userdata('admin_data'))) {
            $data['user_name']=$this->load->get_var('user_name');

            // echo SITE_NAME;
            // echo $this->session->userdata('image');
            // echo $this->session->userdata('position');
            // exit;
            $id=base64_decode($idd);

            if ($stat=="approved") {
                $data_update = array(
         'status'=>1

         );

                $this->db->where('id', $id);
                $zapak=$this->db->update('tbl_users', $data_update);

                if ($zapak!=0) {
									$this->session->set_flashdata('emessage', 'Vendor status updated sucessfully');
                    redirect("dcadmin/Vendors/view_vendors", "refresh");
                } else {
									$this->session->set_flashdata('emessage', 'Some error occured');
					redirect($_SERVER['HTTP_REFERER']);
                }
            }
            if ($stat=="pending") {
                $data_update = array(
          'status'=>2

          );

                $this->db->where('id', $id);
                $zapak=$this->db->update('tbl_users', $data_update);

                if ($zapak!=0) {
									$this->session->set_flashdata('emessage', 'Vendor status updated sucessfully');

                    redirect("dcadmin/Vendors/view_vendors", "refresh");
                } else {
									$this->session->set_flashdata('emessage', 'Some error occured');
					redirect($_SERVER['HTTP_REFERER']);
                }
            }
            if ($stat=="reject") {
                $data_update = array(
          'status'=>3

          );

                $this->db->where('id', $id);
                $zapak=$this->db->update('tbl_vendors', $data_update);

                if ($zapak!=0) {
									$this->session->set_flashdata('emessage', 'Vendor status updated sucessfully');

                    redirect("dcadmin/Vendors/view_vendors", "refresh");
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
