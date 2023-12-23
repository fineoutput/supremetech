<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Fineoutput extends CI_Controller
{
  function __construct()
  {
    parent::__construct();
    $this->load->model("admin/login_model");
    $this->load->model("admin/base_model");
    $this->load->library('user_agent');
    $this->load->library('upload');
  }

  public function dailymsg()
  {

    date_default_timezone_set("Asia/Calcutta");
    $cur_date = date("d-m-Y h-i-a");
    $today = date('d-m-Y h-i-a');
    $next_day = date('d-m-Y h-i-a', strtotime("+1 day"));
    $prev_day = date('Y-m-d', strtotime("-1 day"));
    $prev_date = date('d-m-Y', strtotime("-1 day"));
    $prev_day2 = date('Y-m-d', strtotime("-2 day"));


    //same day orders
    $this->db->select('*');
    $this->db->from('tbl_order1');
    $this->db->where('payment_status', 1);
    $this->db->like('date', $prev_day);
    $order1_data = $this->db->get()->result();



    //prev day orders
    $this->db->select('*');
    $this->db->from('tbl_order1');
    $this->db->where('payment_status', 1);
    $this->db->like('date', $prev_day2);
    $olddate_data = $this->db->get()->result();

    $t1 = count($order1_data);
    $t2 = count($olddate_data);
    $t3 = $t1 - $t2;

    //same day users
    $this->db->select('*');
    $this->db->from('tbl_users');
    $this->db->like('date', $prev_day);
    $users1_data = $this->db->get()->result();

    //prev day users
    $this->db->select('*');
    $this->db->from('tbl_users');
    $this->db->like('date', $prev_day2);
    $users2_data = $this->db->get()->result();

    $u1 = count($users1_data);
    $u2 = count($users2_data);
    $u3 = $u1 - $u2;


    //accepted orders
    $this->db->select('*');
    $this->db->from('tbl_order1');
    $this->db->where('order_status', 1);
    $this->db->where('payment_status', 1);
    $this->db->like('date', $prev_day);
    $accepted1_data = $this->db->get()->result();

    //rejectedorders
    $this->db->select('*');
    $this->db->from('tbl_order1');
    $this->db->where('order_status', 5);
    $this->db->where('payment_status', 1);
    $this->db->like('date', $prev_day);
    $rejected1_data = $this->db->get()->result();

    $a1 = count($accepted1_data);
    $r2 = count($rejected1_data);


    $tlamount = 0;

    $i = 1;
    foreach ($order1_data as $data1) {

      $final_amount = $data1->final_amount;
      $tlamount = $tlamount + $final_amount;
    }

    $tprev_dayamount = 0;
    $i = 1;
    foreach ($olddate_data as $data2) {

      $prevday_data = $data2->final_amount;
      $tprev_dayamount = $tprev_dayamount + $prevday_data;
    }
    $tmt = $tlamount - $tprev_dayamount;

    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://www.fineoutput.com/Whatsapp/send_daily_message',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',

      CURLOPT_MAXREDIRS => 10,

      CURLOPT_TIMEOUT => 0,

      CURLOPT_FOLLOWLOCATION => true,

      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,

      CURLOPT_CUSTOMREQUEST => 'POST',

      CURLOPT_POSTFIELDS => 'phone=' . WHATSAPP_NUMBERS3 . '&new_users=' . $u1 . '&new_orders=' . $t1 . '&date=' . $prev_date . '&accepted_orders=' . $a1 . '&rejected_orders=' . $r2 . '&total_amount=' . $tlamount . '&inc_new_users=' . $u3 . '&inc_new_orders=' . $t3 . '&inc_total_amount=' . $tmt . '',

      CURLOPT_HTTPHEADER => array(
        'token:' . TOKEN,
        'Content-Type:application/x-www-form-urlencoded',
        'Cookie:ci_session=7b4cfa415a2842ad1c7c131aaeceb30647f01f9b'
      ),
    ));
    $response = curl_exec($curl);
    curl_close($curl);
    echo $response;
  }
  public function weeklymsg()
  {


    date_default_timezone_set("Asia/Calcutta");
    $cur_date = date("Y-m-d");
    //$today = date('d-m-Y h-i-a');
    //$next_day = date('d-m-Y h-i-a', strtotime("+1 day"));
    $prev_day = date('Y-m-d', strtotime("-1 day")); //25
    //$prev_date = date('d-m-Y', strtotime("-1 day"));
    $prev_day2 = date('Y-m-d', strtotime("-7 day")); //19


    $prev_day3 = date('Y-m-d', strtotime("-8 day"));
    $prev_day4 = date('Y-m-d', strtotime("-14 day"));


    //count 7 first day total orders

    $this->db->select('*');
    $this->db->from('tbl_order1');
    $this->db->where('payment_status', 1);
    $this->db->order_by('id', 'DESC');
    $prev7data = $this->db->get();
    $arr1 = array();
    $arr2 = array();

    $tlamount = 0;

    $i = 1;
    foreach ($prev7data->result() as $data7day) {

      $da1 = $data7day->date;

      $timestamp = strtotime($da1);
      $new_date = date('Y-m-d', $timestamp);

      if (($new_date <= $prev_day) && ($new_date >= $prev_day2)) {

        $arr1[] = $data7day->id;
      }
      if (($new_date <= $prev_day3) && ($new_date >= $prev_day4)) {

        $arr2[] = $data7day->id;
      }
    }
    $t1 = count($arr1);
    $t2 = count($arr2);

    //increase decrease order differece 1 and 2 week
    $t3 = $t1 - $t2;

    //count 1 and 2 week total users
    $this->db->select('*');
    $this->db->from('tbl_users');
    $this->db->order_by('id', 'DESC');
    $prev7data_users = $this->db->get();
    $urr1 = array();
    $urr2 = array();

    $i = 1;
    foreach ($prev7data_users->result() as $data7day_users) {

      $dau1 = $data7day_users->date;
      $timestamp_users = strtotime($dau1);
      $new_dateusers = date('Y-m-d', $timestamp_users);

      // echo $new_date;exit;
      if (($new_dateusers <= $prev_day) && ($new_dateusers >= $prev_day2)) {

        $urr1[] = $data7day_users->id;
      }
      if (($new_dateusers <= $prev_day3) && ($new_dateusers >= $prev_day4)) {

        $urr2[] = $data7day_users->id;
      }
    }

    $u1 = count($urr1);
    $u2 = count($urr2);
    //increase decrease users differece 1 and 2 week
    $u3 = $u1 - $u2;


    $tlamount = 0;
    $acc_data1 = 0;
    $rej_data1 = 0;
    //accfepted rejected total payment
    //for 1 week

    foreach ($arr1 as $arrs1) {

      //accepted && rejected
      $this->db->select('*');
      $this->db->from('tbl_order1');
      $this->db->where('id', $arrs1);
      $accp = $this->db->get();
      $dataa1 = $accp->row();
      $resulta = $dataa1->order_status;;
      if ($resulta == 1) {
        $acc_data1 = $acc_data1 + 1;
      } else if ($resulta == 5) {
        $rej_data1 = $rej_data1 + 1;
      }

      //amount
      $this->db->select('*');
      $this->db->from('tbl_order1');
      $this->db->where('id', $arrs1);
      $dsa = $this->db->get();
      $data1 = $dsa->row();
      $final_amount = $data1->final_amount;
      $tlamount = $tlamount + $final_amount;
    }
    $a1 = $acc_data1;
    $r2 = $rej_data1;


    $tprev_dayamount = 0;
    $rej_data2 = 0;
    $acc_data2 = 0;
    //for 2 week
    foreach ($arr2 as $arrs2) {
      //accepted && rejected
      $this->db->select('*');
      $this->db->from('tbl_order1');
      $this->db->where('id', $arrs2);
      $acca2 = $this->db->get();
      $dataa2 = $acca2->row();
      $resulta2 = $dataa2->order_status;;
      if ($resulta2 == 1) {
        $acc_data2 = $acc_data2 + 1;
      } else if ($resulta2 == 5) {
        $rej_data2 = $rej_data2 + 1;
      }

      //amount
      $this->db->select('*');
      $this->db->from('tbl_order1');
      $this->db->where('id', $arrs2);
      $dsa = $this->db->get();
      $data2 = $dsa->row();
      $prevday_data = $data2->final_amount;
      $tprev_dayamount = $tprev_dayamount + $prevday_data;
    }
    $a3 = $acc_data2;
    $r4 = $rej_data2;

    $d_date = $prev_day . "-" . $prev_day2;

    $tmt = $tlamount - $tprev_dayamount;






    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://www.fineoutput.com/Whatsapp/send_weekly_message',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',

      CURLOPT_MAXREDIRS => 10,

      CURLOPT_TIMEOUT => 0,

      CURLOPT_FOLLOWLOCATION => true,

      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,

      CURLOPT_CUSTOMREQUEST => 'POST',

      CURLOPT_POSTFIELDS => 'phone=' . WHATSAPP_NUMBERS3 . '&new_users=' . $u1 . '&new_orders=' . $t1 . '&date=' . $d_date . '&accepted_orders=' . $a1 . '&rejected_orders=' . $r2 . '&total_amount=' . $tlamount . '&inc_new_users=' . $u3 . '&inc_new_orders=' . $t3 . '&inc_total_amount=' . $tmt . '',

      CURLOPT_HTTPHEADER => array(
        'token:' . TOKEN,
        'Content-Type:application/x-www-form-urlencoded',
        'Cookie:ci_session=7b4cfa415a2842ad1c7c131aaeceb30647f01f9b'
      ),
    ));
    $response = curl_exec($curl);
    curl_close($curl);
    echo $response;
  }
}
