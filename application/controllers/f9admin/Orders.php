<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
require_once(APPPATH . 'core/CI_finecontrol.php');
class Orders extends CI_finecontrol
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("login_model");
        $this->load->model("admin/base_model");
        $this->load->library('user_agent');
        $this->load->library('upload');
    }

    public function view_orders()
    {
        if (!empty($this->session->userdata('admin_data'))) {
            $data['user_name'] = $this->load->get_var('user_name');

            // echo SITE_NAME;
            // echo $this->session->userdata('image');
            // echo $this->session->userdata('position');
            // exit;
            $this->db->select('*');
            $this->db->from('tbl_order1');
            $this->db->where("order_status", 1);
            $this->db->order_by("id", "desc");


            $data['order_data'] = $this->db->get();

            $this->load->view('admin/common/header_view', $data);
            $this->load->view('admin/order/view_order');
            $this->load->view('admin/common/footer_view');
        } else {
            redirect("login/admin_login", "refresh");
        }
    }

    public function view_accept_order()
    {
        if (!empty($this->session->userdata('admin_data'))) {
            $data['user_name'] = $this->load->get_var('user_name');

            if (empty($_GET['year'])) {
                $year = 2024; // Set default value to 2024
            } else {
                $year = $_GET['year']; // Use the value from the URL parameter
            }

            // echo SITE_NAME;
            // echo $this->session->userdata('image');
            // echo $this->session->userdata('position');
            // exit;
            // $this->db->select('*');
            // $this->db->from('tbl_order1');
            // $this->db->where('order_status', 2);
            // $this->db->where("YEAR(date)", $year);
            // $this->db->order_by("id", "desc");
            // $data['order_data'] = $this->db->get();
            // $this->load->library('pagination');
            // $config['total_rows'] = $this->db->count_all_results('tbl_order1');
            // $config['per_page'] = 10; // Number of records per page
            // $config['uri_segment'] = 3; // URI segment containing the page number

            // $this->pagination->initialize($config);

            // $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
            // $this->db->select('*');
            // $this->db->from('tbl_order1');
            // $this->db->where('order_status', 2);
            // $this->db->where("YEAR(date)", $year);
            // $this->db->order_by("id", "desc");
            // $this->db->limit($config['per_page'], $page);
            // $data['order_data'] = $this->db->get();

            // $data['pagination'] = $this->pagination->create_links();



            $this->load->view('admin/common/header_view', $data);
            $this->load->view('admin/order/view_accept_order_new');
            $this->load->view('admin/common/footer_view');
        } else {
            redirect("login/admin_login", "refresh");
        }
    }
    public function update_order_status($idd, $t)
    {
        if (!empty($this->session->userdata('admin_data'))) {
            $data['user_name'] = $this->load->get_var('user_name');

            // echo SITE_NAME;
            // echo $this->session->userdata('image');
            // echo $this->session->userdata('position');
            // exit;
            $id = base64_decode($idd);

            if ($t == "accept") {
                $data_update = array(
                    'order_status' => 2

                );

                $this->db->where('id', $id);
                $zapak = $this->db->update('tbl_order1', $data_update);

                if ($zapak != 0) {
                    $this->session->set_flashdata('smessage', 'Order status updated successfully');
                    redirect($_SERVER['HTTP_REFERER']);
                } else {
                    echo "Error";
                    exit;
                }
            }
            if ($t == "hold") {
                $data_update = array(
                    'order_status' => 6

                );

                $this->db->where('id', $id);
                $zapak = $this->db->update('tbl_order1', $data_update);

                if ($zapak != 0) {
                    $this->session->set_flashdata('smessage', 'Order status updated successfully');
                    redirect($_SERVER['HTTP_REFERER']);
                } else {
                    echo "Error";
                    exit;
                }
            }
        } else {
            $this->load->view('admin/login/index');
        }
    }
    public function update_cancel_status($idd, $t)
    {
        if (!empty($this->session->userdata('admin_data'))) {
            $data['user_name'] = $this->load->get_var('user_name');

            // echo SITE_NAME;
            // echo $this->session->userdata('image');
            // echo $this->session->userdata('position');
            // exit;
            $id = base64_decode($idd);
            if ($t == "Cancel") {
                $this->db->select('*');
                $this->db->from('tbl_order2');
                $this->db->where('main_id', $id);
                $data_order1 = $this->db->get();

                if (!empty($data_order1)) {
                    foreach ($data_order1->result() as $data) {
                        $this->db->select('*');
                        $this->db->from('tbl_inventory');
                        $this->db->where('product_id', $data->product_id);
                        $data_inventory = $this->db->get()->row();

                        $total_quantity = $data->quantity + $data_inventory->quantity;



                        $data_update = array(
                            'quantity' => $total_quantity
                        );
                        $this->db->where('product_id', $data->product_id);
                        $last_id2 = $this->db->update('tbl_inventory', $data_update);
                    }
                }



                $data_update = array(
                    'order_status' => 5

                );

                $this->db->where('id', $id);
                $zapak = $this->db->update('tbl_order1', $data_update);

                if ($zapak != 0) {
                    $this->session->set_flashdata('smessage', 'Order status updated successfully');
                    redirect($_SERVER['HTTP_REFERER']);
                } else {
                    echo "Error";
                    exit;
                }
            }
        } else {
            $this->load->view('admin/login/index');
        }
    }

    public function update_dispatch_status($idd, $t)
    {
        if (!empty($this->session->userdata('admin_data'))) {
            $data['user_name'] = $this->load->get_var('user_name');

            // echo SITE_NAME;
            // echo $this->session->userdata('image');
            // echo $this->session->userdata('position');
            // exit;
            $id = base64_decode($idd);

            if ($t == "dispatch") {
                $data_update = array(
                    'order_status' => 3

                );

                $this->db->where('id', $id);
                $zapak = $this->db->update('tbl_order1', $data_update);

                if ($zapak != 0) {
                    $this->session->set_flashdata('smessage', 'Order status updated successfully');
                    redirect($_SERVER['HTTP_REFERER']);
                } else {
                    echo "Error";
                    exit;
                }
            }
        } else {
            $this->load->view('admin/login/index');
        }
    }

    public function update_completed_status($idd, $t)
    {
        if (!empty($this->session->userdata('admin_data'))) {
            $data['user_name'] = $this->load->get_var('user_name');

            // echo SITE_NAME;
            // echo $this->session->userdata('image');
            // echo $this->session->userdata('position');
            // exit;
            $id = base64_decode($idd);

            if ($t == "completed") {
                $data_update = array(
                    'order_status' => 4

                );

                $this->db->where('id', $id);
                $zapak = $this->db->update('tbl_order1', $data_update);

                if ($zapak != 0) {
                    $this->session->set_flashdata('smessage', 'Order status updated successfully');
                    redirect($_SERVER['HTTP_REFERER']);
                } else {
                    echo "Error";
                    exit;
                }
            }
        } else {
            $this->load->view('admin/login/index');
        }
    }



    public function view_product_status($idd)
    {
        if (!empty($this->session->userdata('admin_data'))) {
            $data['user_name'] = $this->load->get_var('user_name');

            // echo SITE_NAME;
            // echo $this->session->userdata('image');
            // echo $this->session->userdata('position');
            // exit;
            $id = base64_decode($idd);



            $this->db->select('*');
            $this->db->from('tbl_order2');
            $this->db->where('main_id', $id);
            $data['status_product'] = $this->db->get();


            $this->load->view('admin/common/header_view', $data);
            $this->load->view('admin/order/view_product_order');
            $this->load->view('admin/common/footer_view');
        } else {
            redirect("login/admin_login", "refresh");
        }
    }
    public function view_completed_orders()
    {
        if (!empty($this->session->userdata('admin_data'))) {
            $data['user_name'] = $this->load->get_var('user_name');

            // echo SITE_NAME;
            // echo $this->session->userdata('image');
            // echo $this->session->userdata('position');
            // exit;
            $this->db->select('*');
            $this->db->from('tbl_order1');
            $this->db->where('order_status', 4);
            $this->db->order_by("id", "desc");

            $data['order_data'] = $this->db->get();


            $this->load->view('admin/common/header_view', $data);
            $this->load->view('admin/order/view_complete_order');
            $this->load->view('admin/common/footer_view');
        } else {
            redirect("login/admin_login", "refresh");
        }
    }
    public function view_dispatched_orders()
    {
        if (!empty($this->session->userdata('admin_data'))) {
            $data['user_name'] = $this->load->get_var('user_name');

            // echo SITE_NAME;
            // echo $this->session->userdata('image');
            // echo $this->session->userdata('position');
            // exit;
            $this->db->select('*');
            $this->db->from('tbl_order1');
            $this->db->where('order_status', 3);
            $this->db->order_by("id", "desc");
            $data['order_data'] = $this->db->get();

            $this->load->view('admin/common/header_view', $data);
            $this->load->view('admin/order/view_dispatched_order');
            $this->load->view('admin/common/footer_view');
        } else {
            redirect("login/admin_login", "refresh");
        }
    }



    public function view_cancel_orders()
    {
        if (!empty($this->session->userdata('admin_data'))) {
            $data['user_name'] = $this->load->get_var('user_name');

            // echo SITE_NAME;
            // echo $this->session->userdata('image');
            // echo $this->session->userdata('position');
            // exit;
            $this->db->select('*');
            $this->db->from('tbl_order1');
            $this->db->where('order_status', 5);
            $this->db->order_by("id", "desc");
            $data['order_data'] = $this->db->get();

            $this->load->view('admin/common/header_view', $data);
            $this->load->view('admin/order/view_cancel_order');
            $this->load->view('admin/common/footer_view');
        } else {
            redirect("login/admin_login", "refresh");
        }
    }

    public function view_order_bill($main_id)
    {
        if (!empty($this->session->userdata('admin_data'))) {
            $this->db->select('*');
            $this->db->from('tbl_order1');
            $this->db->where('id', base64_decode($main_id));
            $data['order1_data'] = $this->db->get()->row();

            $this->db->select('*');
            $this->db->from('tbl_order2');
            $this->db->where('main_id', base64_decode($main_id));
            $data['order2_data'] = $this->db->get();
            if (!empty($data['order1_data'])) {
                //$this->load->view('admin/common/header_view',$data);
                $this->load->view('admin/order/order_bill', $data);
                //$this->load->view('admin/common/footer_view');
            } else {
                redirect("dcadmin/home", "refresh");
            }
        } else {
            redirect("login/admin_login", "refresh");
        }
    }

    //---view hold orders///
    public function view_hold_orders()
    {
        if (!empty($this->session->userdata('admin_data'))) {
            $data['user_name'] = $this->load->get_var('user_name');


            $this->db->select('*');
            $this->db->from('tbl_order1');
            $this->db->where('order_status', 6);
            $this->db->order_by("id", "desc");
            $data['order_data'] = $this->db->get();


            $this->load->view('admin/common/header_view', $data);
            $this->load->view('admin/order/hold_orders');
            $this->load->view('admin/common/footer_view');
        } else {
            redirect("login/admin_login", "refresh");
        }
    }

    public function get_accept_order()
    {

        // Get DataTables parameters
        $draw = $this->input->post('draw');
        $start = $this->input->post('start');
        $length = $this->input->post('length');
        // $status = $this->input->post('status');
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
        $this->db->from('tbl_order1');
        if (!empty($columnName)) {
            switch ($columnName) {
                case 1:
                    $this->db->order_by('id', $columnDirection);
                    break;
                case 2:
                    $this->db->order_by('name', $columnDirection);
                    break;
                case 3:
                    $this->db->order_by('total_amount', $columnDirection);
                    break;
                case 4:
                    $this->db->order_by('weight', $columnDirection);
                    break;
                case 5:
                    $this->db->order_by('phone', $columnDirection);
                    break;
                case 6:
                    $this->db->order_by('street_address', $columnDirection);
                    break;
                case 8:
                    $this->db->order_by('district', $columnDirection);
                    break;
                case 9:
                    $this->db->order_by('city', $columnDirection);
                    break;
                case 10:
                    $this->db->order_by('state', $columnDirection);
                    break;
                case 12:
                    $this->db->order_by('pincode', $columnDirection);
                    break;
                case 13:
                    $this->db->order_by('payment_type', $columnDirection);
                    break;
                case 14:
                    $this->db->order_by('date', $columnDirection);
                    break;
                case 15:
                    $this->db->order_by('date', $columnDirection);
                    break;
                case 16:
                    $this->db->order_by('bank_receipt', $columnDirection);
                    break;
                    case 17:
                        $this->db->order_by('order_status', $columnDirection);
                        break;
                default:
                    $this->db->order_by('id', 'desc');
            }
        }
         $this->db->where('order_status', 2);
        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('name', $search);
            $this->db->or_like('phone', $search);
            // $this->db->or_like('dob', $search);
            $this->db->or_like('street_address', $search);
            $this->db->or_like('district', $search);
            $this->db->or_like('pincode', $search);
            $this->db->or_like('id', $search);
            $this->db->or_like('city', $search);
            // $this->db->or_like('type', $search);
            // Add more columns as needed for searching
            $this->db->group_end();
        }
        $this->db->limit($length, $start);
        $da1 = $this->db->get();
        $i = $start + 1;
        //   print_r($start);
        // die();
        foreach ($da1->result() as $da2) {
            if (!empty($da2->district)) {
                $dict =  $da2->district;
            } else {
                $dict = 'No District Found';
            }
            if ($da2->order_status == 2) {
                $order_status = '<p class="label bg-green">ACCEPTED</p>';
            } else {
                $order_status = '<p class="label bg-yellow">Inactive</p>';
            }
            if($da2->date){
                $this->db->select('*');
                          $this->db->from('tbl_order2');
                          $this->db->where('main_id', $da2->id);
                          $check_order2 = $this->db->get()->row();
                          if (!empty($check_order2)) {
                            $orderdate =  $check_order2->date;
                          } else {
                            $orderdate =  "no date found";
                          }
            }
               $this->db->select('*');
                          $this->db->from('all_cities');
                          $this->db->where('id', $da2->district);
                          $city_data = $this->db->get()->row();
                          if (!empty($city_data)) {
                            $dict =  $city_data->city_name;
                          } else {
                            $dict = "Not Found";
                          }

                          $this->db->select('*');
                          $this->db->from('all_states');
                          $this->db->where('id', $da2->state);
                          $state_data = $this->db->get()->row();
                          if (!empty($state_data)) {
                            $state = $state_data->state_name;
                          }
                          else{
                            $state = "Not Found";
                          }

                          $type = $da2->payment_type;
                          $n1 = "";
                          if ($type == 2) {
                            $n1 = "Pay after discussion";
                          }
                          if ($type == 1) {
                            $n1 = "Bank Transfer";
                          }
                          if ($da2->bank_receipt) { 
                            $bank = '<img src="' . base_url() . $da2->bank_receipt . '" width="220" height="220">';
                        } else {
                            $bank = "NA";
                        }



            $btn = '<div class="btn-group" id="btns' . $i . '">
            <div class="btn-group">
              <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false"> Action <span class="caret"></span></button>
              <ul class="dropdown-menu" role="menu">';
            $btn .= ' <li><a href="' . base_url() . 'dcadmin/Orders/update_dispatch_status/' . base64_encode($da2->id) .'/dispatch' .'">Dispatch order</a></li>';
            $btn .= ' <li><a href="' . base_url() . 'dcadmin/Orders/view_order_bill/' . base64_encode($da2->id) . '">View bill</a></li>';
            $btn .= '<li><a href="' . base_url() . 'dcadmin/Orders/view_product_status/' . base64_encode($da2->id) . '">View Order Details</a></li>';
            
           
            $btn .= '</ul>
            </div>
          </div>';
            $btn .=  '<div style="display:none" id="cnfbox' . $i . '">
          <p> Are you sure delete this </p>
          <a href="' . base_url() . 'dcadmin/Vendors/delete_vendors/' . base64_encode($da2->id) . '" class="btn btn-danger">Yes</a>
          <a href="javasript:;" class="cans btn btn-default" mydatas="' . $i . '">No</a>
        </div>';
            $arr2[] = array($i, $da2->id, $da2->name, $da2->total_amount, $da2->weight,$da2->phone,$da2->street_address, $dict, $da2->city, $state, $da2->pincode, $n1, $orderdate, $da2->date,$bank, $order_status, $btn);
            $i++;
        }
        // Get total records without filtering
        $this->db->select('COUNT(id) as total');
        $this->db->from('tbl_order1');
        $this->db->where('order_status', 2);
        ///$this->db->where('is_active', $status);
        $totalRecords = $this->db->get()->row()->total;
        // Get total records with filtering
        $this->db->select('COUNT(id) as total');
        $this->db->from('tbl_order1');
        $this->db->where('order_status', 2);
        // Modified: Add search condition for total filtered records
        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('name', $search);
            // $this->db->or_like('company_name', $search);
            // $this->db->or_like('email', $search);
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
}
