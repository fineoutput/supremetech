<?php
if (!defined('BASEPATH')) {
  exit('No direct script access allowed');
}
class Users extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->model("admin/login_model");
    $this->load->model("admin/base_model");
  }
  public function random_strings($length_of_string)
  {
    // String of all alphanumeric character
    $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
    return substr(str_shuffle($str_result), 0, $length_of_string);
  }
  public function login()
  {
    $this->load->helper(array('form', 'url'));
    $this->load->library('form_validation');
    $this->load->helper('security');
    if ($this->input->post()) {
      // print_r($this->input->post());
      // exit;
      $this->form_validation->set_rules('phone', 'phone', 'required|xss_clean|trim');
      if ($this->form_validation->run() == true) {
        $phone = $this->input->post('phone');
        $ip = $this->input->ip_address();
        date_default_timezone_set("Asia/Calcutta");
        $cur_date = date("Y-m-d H:i:s");
        $this->db->select('*');
        $this->db->from('tbl_users');
        $this->db->where('phone', $phone);
        $dsa = $this->db->get();
        $da = $dsa->row();
        if (!empty($da)) {
          if ($da->is_active == 1) {
            $OTP = random_int(100000, 999999);
            // $OTP = 123456;
            if ($phone == 9999999999) {
              $OTP = 123456;
            }
            $contacts = $phone;
            $sms_text = urlencode('Welcome to Supreme Technocom. your OTP is ' . $OTP . '. Thanks');
            $curl = curl_init();
            curl_setopt_array($curl, array(
              CURLOPT_URL => 'https://alerts.prioritysms.com/api/web2sms.php?workingkey=A3dd249c096dabadfca43a97952624aed&to=' . $contacts . '&sender=SUPTEC&message=' . $sms_text . '',
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => '',
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 0,
              CURLOPT_FOLLOWLOCATION => true,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => 'GET',
            ));
            $response = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);
            if ($err) {
              // echo "cURL Error #:" . $err;
            } else {
              //echo $response;
            }
            $data_insert2 = array(
              'phone' => $phone,
              'otp' => $OTP,
              'status' => 0,
              'ip' => $ip,
              'date' => $cur_date
            );
            $last_id2 = $this->base_model->insert_table("tbl_otp", $data_insert2, 1);
            if (!empty($last_id2)) {
              header('Access-Control-Allow-Origin: *');
              $res = array(
                'message' => 'success',
                'code' => 200,
              );
              echo json_encode($res);
            } else {
              header('Access-Control-Allow-Origin: *');
              $res = array(
                'message' => 'some error occurred',
                'code' => 201,
              );
              echo json_encode($res);
            }
          } else {
            header('Access-Control-Allow-Origin: *');
            $res = array(
              'message' => 'Your account is inactive at the moment. Contact admin',
              'code' => 201,
            );
            echo json_encode($res);
          }
        } else {
          header('Access-Control-Allow-Origin: *');
          $res = array(
            'message' => 'User not registered! please register first',
            'code' => 201,
          );
          echo json_encode($res);
          exit;
        }
      } else {
        header('Access-Control-Allow-Origin: *');
        $res = array(
          'message' => validation_errors(),
          'status' => 201
        );
        echo json_encode($res);
      }
    } else {
      header('Access-Control-Allow-Origin: *');
      $res = array(
        'message' => "Please insert some data, No data available",
        'status' => 201
      );
      echo json_encode($res);
    }
  }
  ///-------------register_opt verify------
  public function login_otp_verify()
  {
    $this->load->helper(array('form', 'url'));
    $this->load->library('form_validation');
    $this->load->helper('security');
    if ($this->input->post()) {
      // $this->form_validation->set_rules('contact_no', 'contact_no', 'required|xss_clean');
      $this->form_validation->set_rules('phone', 'phone', 'required|xss_clean');
      $this->form_validation->set_rules('otp', 'otp', 'required|xss_clean');
      if ($this->form_validation->run() == true) {
        $phone = $this->input->post('phone');
        $input_otp = $this->input->post('otp');
        $ip = $this->input->ip_address();
        date_default_timezone_set("Asia/Calcutta");
        $cur_date = date("Y-m-d H:i:s");
        // echo $phone;exit;
        $this->db->select('*');
        $this->db->from('tbl_otp');
        $this->db->where('phone', $phone);
        $this->db->order_by('id', 'desc');
        $otp_data = $this->db->get()->row();
        if (!empty($otp_data)) {
          if ($otp_data->otp == $input_otp) {
            if ($otp_data->status == 0) {
              $data_insert = array('status' => 1,);
              $this->db->where('id', $otp_data->id);
              $last_id = $this->db->update('tbl_otp', $data_insert);
              if (!empty($last_id)) {
                $this->db->select('*');
                $this->db->from('tbl_users');
                $this->db->where('phone', $phone);
                $user_data = $this->db->get()->row();
                if ($user_data->is_active == 1) {
                  header('Access-Control-Allow-Origin: *');
                  $res = array(
                    'message' => 'success',
                    'status' => 200,
                    'name' => $user_data->name,
                    'phone' => $user_data->phone,
                    'authentication' => $user_data->authentication
                  );
                  echo json_encode($res);
                } else {
                  header('Access-Control-Allow-Origin: *');
                  $res = array(
                    'message' => 'Your account is inactive at the moment. Contact admin',
                    'status' => 201
                  );
                  echo json_encode($res);
                }
              } else {
                header('Access-Control-Allow-Origin: *');
                $res = array(
                  'message' => 'some error occurred! Please try again',
                  'status' => 201
                );
                echo json_encode($res);
              }
            } else {
              header('Access-Control-Allow-Origin: *');
              $res = array(
                'message' => 'OTP is already used',
                'status' => 201
              );
              echo json_encode($res);
            }
          } else {
            header('Access-Control-Allow-Origin: *');
            $res = array(
              'message' => 'Wrong Otp',
              'status' => 201
            );
            echo json_encode($res);
          }
        } else {
          header('Access-Control-Allow-Origin: *');
          $res = array(
            'message' => 'Otp is not valid',
            'status' => 201
          );
          echo json_encode($res);
        }
      } else {
        header('Access-Control-Allow-Origin: *');
        $res = array(
          'message' => validation_errors(),
          'status' => 201
        );
        echo json_encode($res);
      }
    } else {
      header('Access-Control-Allow-Origin: *');
      $res = array(
        'message' => 'Please insert some data, No data available',
        'status' => 201
      );
      echo json_encode($res);
    }
  }
  public function user_register()
  {
    $this->load->helper(array('form', 'url'));
    $this->load->library('form_validation');
    $this->load->helper('security');
    if ($this->input->post()) {
      // print_r($this->input->post());
      // exit;
      $this->form_validation->set_rules('name', 'name', 'required|xss_clean|trim');
      $this->form_validation->set_rules('email', 'email', 'required|xss_clean|trim|valid_email');
      // $this->form_validation->set_rules('dob', 'dob', 'required|xss_clean|trim');
      $this->form_validation->set_rules('phone', 'phone', 'required|xss_clean|trim');
      $this->form_validation->set_rules('address', 'address', 'required|xss_clean|trim');
      $this->form_validation->set_rules('state', 'state', 'required|xss_clean|trim');
      $this->form_validation->set_rules('zipcode', 'zipcode', 'required|xss_clean|trim');
      $this->form_validation->set_rules('company_name', 'company_name', 'required|xss_clean|trim');
      $this->form_validation->set_rules('district', 'district', 'required|xss_clean|trim'); //--table all_cities id
      $this->form_validation->set_rules('gstin', 'gstin', 'xss_clean|trim'); //--table all_cities id
      $this->form_validation->set_rules('city', 'city', 'required|xss_clean|trim'); //-- varchar
      // $this->form_validation->set_rules('house_no', 'house_no', 'required|xss_clean|trim');
      $this->form_validation->set_rules('token_id', 'token_id', 'required|xss_clean|trim');
      if ($this->form_validation->run() == true) {
        $name = $this->input->post('name');
        $email = $this->input->post('email');
        // $dob=$this->input->post('dob');
        $phone = $this->input->post('phone');
        $address = $this->input->post('address');
        $state = $this->input->post('state');
        $district = $this->input->post('district');
        $zipcode = $this->input->post('zipcode');
        $company_name = $this->input->post('company_name');
        $gstin = $this->input->post('gstin');
        $city = $this->input->post('city');
        // $house_no=$this->input->post('house_no');
        $token_id = $this->input->post('token_id');
        $ip = $this->input->ip_address();
        date_default_timezone_set("Asia/Calcutta");
        $cur_date = date("Y-m-d H:i:s");
        $this->load->library('upload');
        $img1 = 'image1';
        $file_check = ($_FILES['image1']['error']);
        if ($file_check != 4) {
          $image_upload_folder = FCPATH . "assets/uploads/users/";
          if (!file_exists($image_upload_folder)) {
            mkdir($image_upload_folder, DIR_WRITE_MODE, true);
          }
          $new_file_name = "users" . date("Ymdhms");
          $this->upload_config = array(
            'upload_path'   => $image_upload_folder,
            'file_name' => $new_file_name,
            'allowed_types' => 'jpg|jpeg|png',
            'max_size'      => 25000
          );
          $this->upload->initialize($this->upload_config);
          if (!$this->upload->do_upload($img1)) {
            $upload_error = $this->upload->display_errors();
            header('Access-Control-Allow-Origin: *');
            $res = array(
              'message' => $upload_error,
              'status' => 201
            );
            echo json_encode($res);
          } else {
            $file_info = $this->upload->data();
            $videoNAmePath = "assets/uploads/users/" . $new_file_name . $file_info['file_ext'];
            $file_info['new_name'] = $videoNAmePath;
            // $this->step6_model->updateappIconImage($imageNAmePath,$appInfoId);
            $image1 = $videoNAmePath;
            // echo json_encode($file_info);
          }
        }
        // $img2='image2';
        // $image2="";
        // if (!empty($img2)) {
        //     $file_check=($_FILES['image2']['error']);
        //     if ($file_check!=4) {
        //         $image_upload_folder = FCPATH . "assets/uploads/users/";
        //         if (!file_exists($image_upload_folder)) {
        //             mkdir($image_upload_folder, DIR_WRITE_MODE, true);
        //         }
        //         $new_file_name="users".date("Ymdhms");
        //         $this->upload_config = array(
        //                 'upload_path'   => $image_upload_folder,
        //                 'file_name' => $new_file_name,
        //                 'allowed_types' =>'jpg|jpeg|png',
        //                 'max_size'      => 25000
        //         );
        //         $this->upload->initialize($this->upload_config);
        //         if (!$this->upload->do_upload($img2)) {
        //             $upload_error = $this->upload->display_errors();
        //             // echo json_encode($upload_error);
        //             echo $upload_error;
        //         } else {
        //             $file_info = $this->upload->data();
        //
        //             $videoNAmePath = "assets/uploads/users/".$new_file_name.$file_info['file_ext'];
        //             $file_info['new_name']=$videoNAmePath;
        //             // $this->step6_model->updateappIconImage($imageNAmePath,$appInfoId);
        //             $image2=$videoNAmePath;
        //             // echo json_encode($file_info);
        //         }
        //     }
        // }
        $this->db->select('*');
        $this->db->from('tbl_users');
        $this->db->where('phone', $phone);
        $userdata1 = $this->db->get()->row();
        if (empty($userdata1)) {
          $data_insert = array(
            'name' => $name,
            'email' => $email,
            // 'dob'=>$dob,
            'phone' => $phone,
            'address' => $address,
            'state' => $state,
            'district' => $district,
            'zipcode' => $zipcode,
            'company_name' => $company_name,
            'gstin' => $gstin,
            'city' => $city,
            // 'house_no'=>$house_no,
            'image1' => $image1,
            // 'image2'=>$image2,
            'token_id' => $token_id,
            'ip' => $ip,
            'date' => $cur_date
          );
          $last_id = $this->base_model->insert_table("tbl_user_temp", $data_insert, 1);
          if ($last_id != 0) {
            $OTP = random_int(100000, 999999);
            // $OTP = 123456;
            $contacts = $phone;
            $sms_text = urlencode('Welcome to Supreme Technocom. your OTP is ' . $OTP . '. Thanks');
            $curl = curl_init();
            curl_setopt_array($curl, array(
              CURLOPT_URL => 'https://alerts.prioritysms.com/api/web2sms.php?workingkey=A3dd249c096dabadfca43a97952624aed&to=' . $contacts . '&sender=SUPTEC&message=' . $sms_text . '',
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => '',
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 0,
              CURLOPT_FOLLOWLOCATION => true,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => 'GET',
            ));
            $response = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);
            if ($err) {
              // echo "cURL Error #:" . $err;
            } else {
              //echo $response;
            }
            $data_insert2 = array(
              'phone' => $phone,
              'otp' => $OTP,
              'status' => 0,
              'temp_id' => $last_id,
              'ip' => $ip,
              'date' => $cur_date
            );
            $last_id2 = $this->base_model->insert_table("tbl_otp", $data_insert2, 1);
            header('Access-Control-Allow-Origin: *');
            $res = array(
              'message' => "success",
              'status' => 200
            );
            echo json_encode($res);
          } else {
            header('Access-Control-Allow-Origin: *');
            $res = array(
              'message' => "Sorry error occurred",
              'status' => 201
            );
            echo json_encode($res);
          }
        } else {
          header('Access-Control-Allow-Origin: *');
          $res = array(
            'message' => 'User already exist',
            'status' => 201
          );
          echo json_encode($res);
        }
      } else {
        header('Access-Control-Allow-Origin: *');
        $res = array(
          'message' => validation_errors(),
          'status' => 201
        );
        echo json_encode($res);
      }
    } else {
      header('Access-Control-Allow-Origin: *');
      $res = array(
        'message' => "Please insert some data, No data available",
        'status' => 201
      );
      echo json_encode($res);
    }
  }
  ///-------------register_opt verify------
  public function register_otp_verify()
  {
    $this->load->helper(array('form', 'url'));
    $this->load->library('form_validation');
    $this->load->helper('security');
    if ($this->input->post()) {
      // $this->form_validation->set_rules('contact_no', 'contact_no', 'required|xss_clean');
      $this->form_validation->set_rules('phone', 'phone', 'required|xss_clean');
      $this->form_validation->set_rules('otp', 'otp', 'required|xss_clean');
      if ($this->form_validation->run() == true) {
        $phone = $this->input->post('phone');
        $input_otp = $this->input->post('otp');
        $ip = $this->input->ip_address();
        date_default_timezone_set("Asia/Calcutta");
        $cur_date = date("Y-m-d H:i:s");
        $this->db->select('*');
        $this->db->from('tbl_otp');
        $this->db->where('phone', $phone);
        $this->db->order_by('id', 'desc');
        $otp_data = $this->db->get()->row();
        if (!empty($otp_data)) {
          if ($otp_data->status == 0) {
            if ($otp_data->otp == $input_otp) {
              $data_insert = array('status' => 1,);
              $this->db->where('id', $otp_data->id);
              $last_id = $this->db->update('tbl_otp', $data_insert);
              if (!empty($last_id)) {
                $this->db->select('*');
                $this->db->from('tbl_user_temp');
                $this->db->where('id', $otp_data->temp_id);
                $temp_data = $this->db->get()->row();
                $authentication = bin2hex(random_bytes(12));
                $data_insert = array(
                  'name' => $temp_data->name,
                  'email' => $temp_data->email,
                  // 'dob'=>$temp_data->dob,
                  'phone' => $temp_data->phone,
                  'address' => $temp_data->address,
                  'state' => $temp_data->state,
                  'district' => $temp_data->district,
                  'zipcode' => $temp_data->zipcode,
                  'company_name' => $temp_data->company_name,
                  'gstin' => $temp_data->gstin,
                  'city' => $temp_data->city,
                  'district' => $temp_data->district,
                  // 'house_no'=>$temp_data->house_no,
                  'image1' => $temp_data->image1,
                  // 'image2'=>$temp_data->image2,
                  'token_id' => $temp_data->token_id,
                  'authentication' => $authentication,
                  'ip' => $ip,
                  'is_active' => 0,
                  'date' => $cur_date
                );
                $last_id2 = $this->base_model->insert_table("tbl_users", $data_insert, 1);
                if (!empty($last_id2)) {
                  $this->db->select('*');
                  $this->db->from('tbl_cart');
                  $this->db->where('token_id', $temp_data->token_id);
                  $cart_data = $this->db->get();
                  $cart_check = $cart_data->row();
                  if (!empty($cart_check)) {
                    foreach ($cart_data->result() as $data) {
                      $data_insert = array('user_id' => $last_id2);
                      $this->db->where('token_id', $temp_data->token_id);
                      $last_id3 = $this->db->update('token_id', $data_insert);
                    }
                  }
                  header('Access-Control-Allow-Origin: *');
                  $res = array(
                    'message' => 'You have scuccessfully signed up. Please wait for admin approval',
                    'status' => 201,
                    //     'user_id'=>$last_id2,
                    // 'name'=>$temp_data->name,
                    // 'phone'=>$temp_data->phone,
                    // 'authentication'=>$authentication
                  );
                  echo json_encode($res);
                } else {
                  header('Access-Control-Allow-Origin: *');
                  $res = array(
                    'message' => 'some error occurred! Please try again',
                    'status' => 201
                  );
                  echo json_encode($res);
                }
              } else {
                header('Access-Control-Allow-Origin: *');
                $res = array(
                  'message' => 'some error occurred',
                  'status' => 201
                );
                echo json_encode($res);
              }
            } else {
              header('Access-Control-Allow-Origin: *');
              $res = array(
                'message' => 'Wrong Otp',
                'status' => 201
              );
              echo json_encode($res);
            }
          } else {
            header('Access-Control-Allow-Origin: *');
            $res = array(
              'message' => 'OTP is already used',
              'status' => 201
            );
            echo json_encode($res);
          }
        } else {
          header('Access-Control-Allow-Origin: *');
          $res = array(
            'message' => 'Otp is not valid',
            'status' => 201
          );
          echo json_encode($res);
        }
      } else {
        header('Access-Control-Allow-Origin: *');
        $res = array(
          'message' => validation_errors(),
          'status' => 201
        );
        echo json_encode($res);
      }
    } else {
      header('Access-Control-Allow-Origin: *');
      $res = array(
        'message' => 'Please insert some data, No data available',
        'status' => 201
      );
      echo json_encode($res);
    }
  }
}
