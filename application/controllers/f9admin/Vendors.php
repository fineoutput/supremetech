<?php
if (!defined('BASEPATH')) {
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
            $data['user_name'] = $this->load->get_var('user_name');
            // echo SITE_NAME;
            // echo $this->session->userdata('image');
            // echo $this->session->userdata('position');
            // exit;
            // $this->db->select('*');
            // $this->db->from('tbl_users');
            // $this->db->order_by('id', 'desc');
            // $this->db->where('is_active', 1);
            // $data['vendors_data'] = $this->db->get();
            $data['heading'] = "Accepted";
            $data['is_active'] = 1;
            $this->load->view('admin/common/header_view', $data);
            $this->load->view('admin/vendors/view_vendors');
            $this->load->view('admin/common/footer_view');
        } else {
            redirect("login/admin_login", "refresh");
        }
    }
    public function view_pending_vendors()
    {
        if (!empty($this->session->userdata('admin_data'))) {
            $data['user_name'] = $this->load->get_var('user_name');
            // echo SITE_NAME;
            // echo $this->session->userdata('image');
            // echo $this->session->userdata('position');
            // exit;
            // $this->db->select('*');
            // $this->db->from('tbl_users');
            // $this->db->order_by('id', 'desc');
            // $this->db->where('is_active', 0);
            // $data['vendors_data'] = $this->db->get();
            $data['heading'] = "Pending";
            $data['is_active'] = 0;

            $this->load->view('admin/common/header_view', $data);
            $this->load->view('admin/vendors/view_vendors');
            $this->load->view('admin/common/footer_view');
        } else {
            redirect("login/admin_login", "refresh");
        }
    }
    public function get_vendors()
    {
        // Get DataTables parameters
        $draw = $this->input->post('draw');
        $start = $this->input->post('start');
        $length = $this->input->post('length');
        $status = $this->input->post('status');
        $search = $this->input->post('search')['value'];
        $orderBy = $this->input->post('order')[0];
        $columnIndex = $orderBy['column'];
        $columnName = $this->input->post('columns')[$columnIndex]['data'];
        $columnDirection = $this->input->post('order')[0]['dir'];
        // echo $columnName;
        // echo $columnDirection;
        // die();
        $arr2 = [];
        $this->db->select('*');
        $this->db->from('tbl_users');
        if (!empty($columnName)) {
            switch ($columnName) {
                case 1:
                    $this->db->order_by('name', $columnDirection);
                    break;
                case 2:
                    $this->db->order_by('company_name', $columnDirection);
                    break;
                case 3:
                    $this->db->order_by('email', $columnDirection);
                    break;
                case 4:
                    $this->db->order_by('address', $columnDirection);
                    break;
                case 5:
                    $this->db->order_by('district', $columnDirection);
                    break;
                case 6:
                    $this->db->order_by('city', $columnDirection);
                    break;
                case 8:
                    $this->db->order_by('zipcode', $columnDirection);
                    break;
                case 9:
                    $this->db->order_by('phone', $columnDirection);
                    break;
                case 10:
                    $this->db->order_by('gst', $columnDirection);
                    break;
                case 12:
                    $this->db->order_by('date', $columnDirection);
                    break;
                case 13:
                    $this->db->order_by('type', $columnDirection);
                    break;
                case 14:
                    $this->db->order_by('is_active', $columnDirection);
                    break;
                default:
                    $this->db->order_by('id', 'desc');
            }
        }
        $this->db->where('is_active', $status);
        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('name', $search);
            $this->db->or_like('phone', $search);
            $this->db->or_like('dob', $search);
            $this->db->or_like('address', $search);
            $this->db->or_like('district', $search);
            $this->db->or_like('zipcode', $search);
            $this->db->or_like('company_name', $search);
            $this->db->or_like('city', $search);
            $this->db->or_like('type', $search);
            // Add more columns as needed for searching
            $this->db->group_end();
        }
        $this->db->limit($length, $start);
        $da1 = $this->db->get();
        $i = $start + 1;
        //   print_r($status);
        // die();
        foreach ($da1->result() as $da2) {
            $this->db->select('*');
            $this->db->from('all_cities');
            $this->db->where('id', $da2->district);
            $district_data = $this->db->get()->row();
            if (!empty($district_data)) {
                $dict =  $district_data->city_name;
            } else {
                $dict = 'No District Found';
            }
            $this->db->select('*');
            $this->db->from('all_states');
            $this->db->where('id', $da2->state);
            $state_data = $this->db->get()->row();
            if (!empty($state_data)) {
                $state =  $state_data->state_name;
            } else {
                $state =  'No State Found';
            }
            if ($da2->image1 != "") {
                $path  = base_url() . $da2->image1;
                $image = '<img id="slide_img_path" height=50 width=100 src="' . $path . '">';
            } else {
                $image = "Sorry No File Found";
            }
            if ($da2->type == 'T2') {
                $type = '<p class="label bg-primary">T2</p>';
            } else if ($da2->type == 'T3') {
                $type = '<p class="label bg-red">T3</p>';
            }
            if ($da2->is_active == 1) {
                $is_active = '<p class="label bg-green">Active</p>';
            } else {
                $is_active = '<p class="label bg-yellow">Inactive</p>';
            }
            $btn = '<div class="btn-group" id="btns' . $i . '">
            <div class="btn-group">
              <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false"> Action <span class="caret"></span></button>
              <ul class="dropdown-menu" role="menu">';
            if ($da2->is_active == 1) {
                $btn .= '<li><a href="' . base_url() . 'dcadmin/Vendors/updatevendorsStatus/' . base64_encode($da2->id) . '/inactive">Inactive</a></li>';
            } else {
                $btn .= '<li><a href="' . base_url() . 'dcadmin/Vendors/updatevendorsStatus/' . base64_encode($da2->id) . '/active">Active</a></li>';
            }
            if ($da2->type == 'T2') {
                $btn .= '<li><a href="' . base_url() . 'dcadmin/Vendors/updateVendorsType/' . base64_encode($da2->id) . '/T3">Mark T3</a></li>';
            } elseif ($da2->type == 'T3') {
                $btn .= '<li><a href="' . base_url() . 'dcadmin/Vendors/updateVendorsType/' . base64_encode($da2->id) . '/T2">Mark T2</a></li>';
            } else {
                $btn .= '<li><a href="' . base_url() . 'dcadmin/Vendors/updateVendorsType/' . base64_encode($da2->id) . '/T2">Mark T2</a></li>';
                $btn .= '<li><a href="' . base_url() . 'dcadmin/Vendors/updateVendorsType/' . base64_encode($da2->id) . '/T3">Mark T3</a></li>';
            }
            $btn .= ' <li><a href="javascript:;" class="dCnf" mydata="' . $i . '"">Delete</a></li>';
            $btn .= '<li><a href="' . base_url() . 'dcadmin/Vendors/update_vendors/' . base64_encode($da2->id) . '">Edit</a></li>';



            $btn .= '</ul>
            </div>
          </div>';
          $btn .=  '<div style="display:none" id="cnfbox' . $i . '">
          <p> Are you sure delete this </p>
          <a href="' . base_url() . 'dcadmin/Vendors/delete_vendors/' . base64_encode($da2->id) . '" class="btn btn-danger">Yes</a>
          <a href="javasript:;" class="cans btn btn-default" mydatas="' . $i . '">No</a>
        </div>';
            $arr2[] = array($i, $da2->name, $da2->company_name, $da2->email, $da2->address, $dict, $da2->city, $state, $da2->zipcode, $da2->phone, $da2->gstin, $image, $da2->date, $type, $is_active, $btn);
            $i++;
        }
        // Get total records without filtering
        $this->db->select('COUNT(id) as total');
        $this->db->from('tbl_users');
        $this->db->where('is_active', $status);
        $totalRecords = $this->db->get()->row()->total;
        // Get total records with filtering
        $this->db->select('COUNT(id) as total');
        $this->db->from('tbl_users');
        $this->db->where('is_active', $status);
        // Modified: Add search condition for total filtered records
        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('name', $search);
            $this->db->or_like('company_name', $search);
            $this->db->or_like('email', $search);
            // Add more columns as needed for searching
            $this->db->group_end();
        }

        $filteredRecords = $this->db->get()->row()->total;

        // Modified: Create the final response array
        $response = array(
            'draw' => $draw,
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $filteredRecords,
            'data' => $arr2
        );
        // print_r($response);
        // die();
        // Modified: Output JSON response
        echo json_encode($response);
        exit;
    }
    public function add_vendors()
    {
        if (!empty($this->session->userdata('admin_data'))) {
            $data['user_name'] = $this->load->get_var('user_name');
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
    public function add_vendors_data($t, $iw = "")
    {
        if (!empty($this->session->userdata('admin_data'))) {
            $this->load->helper(array('form', 'url'));
            $this->load->library('form_validation');
            $this->load->helper('security');
            if ($this->input->post()) {
                // print_r($this->input->post());
                // exit;
                $this->form_validation->set_rules('name', 'name', 'required|xss_clean|trim');
                // $this->form_validation->set_rules('lastname', 'lastname', 'xss_clean|trim');
                // $this->form_validation->set_rules('dateofbirth', 'dateofbirth', 'required|xss_clean|trim');
                $this->form_validation->set_rules('email', 'email', 'required|valid_email|xss_clean|trim');
                // $this->form_validation->set_rules('password', 'password', 'required|xss_clean|trim');
                $this->form_validation->set_rules('gstin', 'gstin', 'required|xss_clean|trim');
                $this->form_validation->set_rules('address', 'address', 'required|xss_clean|trim');
                $this->form_validation->set_rules('city', 'city', 'required|xss_clean|trim');
                if ($this->form_validation->run() == true) {
                    $name = $this->input->post('name');
                    // $lastname=$this->input->post('lastname');
                    // $dateofbirth=$this->input->post('dateofbirth');
                    $email = $this->input->post('email');
                    // $password=$this->input->post('password');
                    $gstin = $this->input->post('gstin');
                    $address = $this->input->post('address');
                    $city = $this->input->post('city');
                    $ip = $this->input->ip_address();
                    date_default_timezone_set("Asia/Calcutta");
                    $cur_date = date("Y-m-d H:i:s");
                    $addedby = $this->session->userdata('admin_id');
                    $this->load->library('upload');
                    $img1 = 'image1';
                    $nnnn = '';
                    $file_check = ($_FILES['image1']['error']);
                    if ($file_check != 4) {
                        $image_upload_folder = FCPATH . "assets/uploads/vendor/";
                        if (!file_exists($image_upload_folder)) {
                            mkdir($image_upload_folder, DIR_WRITE_MODE, true);
                        }
                        $new_file_name = "vendor" . date("Ymdhms");
                        $this->upload_config = array(
                            'upload_path'   => $image_upload_folder,
                            'file_name' => $new_file_name,
                            'allowed_types' => 'jpg|jpeg|png',
                            'max_size'      => 25000
                        );
                        $this->upload->initialize($this->upload_config);
                        if (!$this->upload->do_upload($img1)) {
                            $upload_error = $this->upload->display_errors();
                            $this->session->set_flashdata('emessage', $upload_error);
                            redirect($_SERVER['HTTP_REFERER']);
                        } else {
                            $file_info = $this->upload->data();
                            $videoNAmePath = "assets/uploads/vendor/" . $new_file_name . $file_info['file_ext'];
                            $nnnn = $videoNAmePath;
                        }
                    }
                    $typ = base64_decode($t);
                    if ($typ == 1) {
                        $data_insert = array(
                            'name' => $name,
                            // 'lastname'=>$lastname,
                            // 'dateofbirth'=>$dateofbirth,
                            'email' => $email,
                            'password' => $password,
                            'gstin' => $gstin,
                            'address' => $address,
                            'city' => $city,
                            'image1' => $nnnn,
                            'ip' => $ip,
                            'added_by' => $addedby,
                            'is_active' => 1,
                            'date' => $cur_date
                        );
                        $last_id = $this->base_model->insert_table("tbl_users", $data_insert, 1);
                        if ($last_id != 0) {
                            $this->session->set_flashdata('smessage', 'Vendor inserted successfully');
                            redirect("dcadmin/Vendors/view_vendors", "refresh");
                        } else {
                            $this->session->set_flashdata('emessage', 'Sorry error occured');
                            redirect($_SERVER['HTTP_REFERER']);
                        }
                    }
                    if ($typ == 2) {
                        $idw = base64_decode($iw);
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
                        $data_insert = array(
                            'name' => $name,
                            // 'lastname'=>$lastname,
                            // 'dateofbirth'=>$dateofbirth,
                            'email' => $email,
                            // 'password'=>$password,
                            'gstin' => $gstin,
                            'address' => $address,
                            'image1' => $nnnn,
                            'city' => $city,
                        );
                        $this->db->where('id', $idw);
                        $last_id = $this->db->update('tbl_users', $data_insert);
                        if ($last_id != 0) {
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
            $data['user_name'] = $this->load->get_var('user_name');
            // echo SITE_NAME;
            // echo $this->session->userdata('image');
            // echo $this->session->userdata('position');
            // exit;
            $id = base64_decode($idd);
            $data['id'] = $idd;
            $this->db->select('*');
            $this->db->from('tbl_users');
            $this->db->where('id', $id);
            $dsa = $this->db->get();
            $data['vendors'] = $dsa->row();
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
            $data['user_name'] = $this->load->get_var('user_name');
            // echo SITE_NAME;
            // echo $this->session->userdata('image');
            // echo $this->session->userdata('position');
            // exit;
            $id = base64_decode($idd);
            // echo $id;die();
            if ($this->load->get_var('position') == "Super Admin") {
                $zapak = $this->db->delete('tbl_users', array('id' => $id));
                if ($zapak != 0) {
                    $this->session->set_flashdata('smessage', 'Vendor deleted successfully');
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
    public function updatevendorsStatus($idd, $t)
    {
        if (!empty($this->session->userdata('admin_data'))) {
            $data['user_name'] = $this->load->get_var('user_name');
            // echo SITE_NAME;
            // echo $this->session->userdata('image');
            // echo $this->session->userdata('position');
            // exit;
            $id = base64_decode($idd);
            if ($t == "active") {
                $data_update = array(
                    'is_active' => 1
                );
                $this->db->where('id', $id);
                $zapak = $this->db->update('tbl_users', $data_update);
                if ($zapak != 0) {
                    $this->session->set_flashdata('smessage', 'Vendor status updated successfully');
                    redirect("dcadmin/Vendors/view_pending_vendors", "refresh");
                } else {
                    $this->session->set_flashdata('emessage', 'Some error occured');
                    redirect($_SERVER['HTTP_REFERER']);
                }
            }
            if ($t == "inactive") {
                $data_update = array(
                    'is_active' => 0
                );
                $this->db->where('id', $id);
                $zapak = $this->db->update('tbl_users', $data_update);
                if ($zapak != 0) {
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
    public function updateVendorsType($idd, $t)
    {
        if (!empty($this->session->userdata('admin_data'))) {
            $data['user_name'] = $this->load->get_var('user_name');
            // echo SITE_NAME;
            // echo $this->session->userdata('image');
            // echo $this->session->userdata('position');
            // exit;
            $id = base64_decode($idd);
            if ($t == "T2") {
                $data_update = array(
                    'type' => 'T2'
                );
                $this->db->where('id', $id);
                $zapak = $this->db->update('tbl_users', $data_update);
                if ($zapak != 0) {
                    $this->session->set_flashdata('smessage', 'Vendor status updated successfully');
                    redirect($_SERVER['HTTP_REFERER']);
                } else {
                    $this->session->set_flashdata('emessage', 'Some error occured');
                    redirect($_SERVER['HTTP_REFERER']);
                }
            }
            if ($t == "T3") {
                $data_update = array(
                    'type' => 'T3'
                );
                $this->db->where('id', $id);
                $zapak = $this->db->update('tbl_users', $data_update);
                if ($zapak != 0) {
                    $this->session->set_flashdata('smessage', 'Vendor status updated successfully');
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
    public function updateVendorRequestStatus($idd, $stat)
    {
        if (!empty($this->session->userdata('admin_data'))) {
            $data['user_name'] = $this->load->get_var('user_name');
            // echo SITE_NAME;
            // echo $this->session->userdata('image');
            // echo $this->session->userdata('position');
            // exit;
            $id = base64_decode($idd);
            if ($stat == "approved") {
                $data_update = array(
                    'status' => 1
                );
                $this->db->where('id', $id);
                $zapak = $this->db->update('tbl_users', $data_update);
                if ($zapak != 0) {
                    $this->session->set_flashdata('emessage', 'Vendor status updated sucessfully');
                    redirect("dcadmin/Vendors/view_vendors", "refresh");
                } else {
                    $this->session->set_flashdata('emessage', 'Some error occured');
                    redirect($_SERVER['HTTP_REFERER']);
                }
            }
            if ($stat == "pending") {
                $data_update = array(
                    'status' => 2
                );
                $this->db->where('id', $id);
                $zapak = $this->db->update('tbl_users', $data_update);
                if ($zapak != 0) {
                    $this->session->set_flashdata('emessage', 'Vendor status updated sucessfully');
                    redirect("dcadmin/Vendors/view_vendors", "refresh");
                } else {
                    $this->session->set_flashdata('emessage', 'Some error occured');
                    redirect($_SERVER['HTTP_REFERER']);
                }
            }
            if ($stat == "reject") {
                $data_update = array(
                    'status' => 3
                );
                $this->db->where('id', $id);
                $zapak = $this->db->update('tbl_vendors', $data_update);
                if ($zapak != 0) {
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
