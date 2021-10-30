<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . 'core/CI_finecontrol.php');
class Orders extends CI_finecontrol{
function __construct()
{
parent::__construct();
$this->load->model("login_model");
$this->load->model("admin/base_model");
$this->load->library('user_agent');
$this->load->library('upload');
}

//new_orders method
public function new_orders(){

if(!empty($this->session->userdata('admin_data'))){

$this->db->select('*');
$this->db->from('tbl_order1');
$this->db->where('order_status',1);
$this->db->or_where('order_status',2);
$this->db->order_by("id", "desc");
$data['orders_data']= $this->db->get();

$data['page_title'] = ' New Orders';

$this->load->view('admin/common/header_view',$data);
$this->load->view('admin/orders/view_orders');
$this->load->view('admin/common/footer_view');

}
else{

redirect("login/admin_login","refresh");
}

}

//dispatched_orders method

public function dispatched_orders(){

if(!empty($this->session->userdata('admin_data'))){

$this->db->select('*');
$this->db->from('tbl_order1');
$this->db->where('order_status',3);
$this->db->order_by("id", "desc");
$data['orders_data']= $this->db->get();

$data['page_title'] = ' Dispatched Orders';

$this->load->view('admin/common/header_view',$data);
$this->load->view('admin/orders/view_orders');
$this->load->view('admin/common/footer_view');

}
else{

redirect("login/admin_login","refresh");
}

}

//completed_orders method

public function completed_orders(){

if(!empty($this->session->userdata('admin_data'))){

$this->db->select('*');
$this->db->from('tbl_order1');
$this->db->where('order_status',4);
// $this->db->or_where('order_status',5);
$data['orders_data']= $this->db->get();

$data['page_title'] = ' Completed Orders';

$this->load->view('admin/common/header_view',$data);
$this->load->view('admin/orders/view_orders');
$this->load->view('admin/common/footer_view');

}
else{

redirect("login/admin_login","refresh");
}

}

//rejected_orders method


public function rejected_orders(){

if(!empty($this->session->userdata('admin_data'))){

$this->db->select('*');
$this->db->from('tbl_order1');
$this->db->where('order_status',5);
$data['orders_data']= $this->db->get();

$data['page_title'] = ' Rejected Orders';

$this->load->view('admin/common/header_view',$data);
$this->load->view('admin/orders/view_orders');
$this->load->view('admin/common/footer_view');

}
else{

redirect("login/admin_login","refresh");
}

}


//view orders

public function view_orders(){

if(!empty($this->session->userdata('admin_data'))){

$data['page_title'] = ' All Orders';
$this->db->select('*');
$this->db->from('tbl_order1');
//$this->db->order_by("id", "desc");
//$this->db->where('id',$usr);
$data['orders_data']= $this->db->get();

$this->load->view('admin/common/header_view',$data);
$this->load->view('admin/order/view_order');
$this->load->view('admin/common/footer_view');

}
else{

redirect("login/admin_login","refresh");
}

}

public function updateordersStatus($idd,$t){

if(!empty($this->session->userdata('admin_data'))){

$id=base64_decode($idd);
$typ = base64_decode($t);

// $id=$idd;
// $typ = $t;

if($typ == '5'){
$this->db->select('*');
$this->db->from('tbl_order2');
$this->db->where('main_id',$id);
$d1= $this->db->get();

$ip = $this->input->ip_address();
date_default_timezone_set("Asia/Calcutta");
$cur_date=date("Y-m-d H:i:s");
$addedby=$this->session->userdata('admin_id');

foreach($d1->result() as $dd1) {
$o_product_name = '';
$o_product_qty = '';
if(!empty($dd1)){
$o_product_qty = $dd1->quantity;

$this->db->select('*');
$this->db->from('tbl_inventory');
$this->db->where('product_id',$dd1->product_id);
$this->db->where('unit_id',$dd1->unit_id);
$dsa= $this->db->get()->row();
if(!empty($dsa)){

$db_pro_stock = $dsa->stock;
$total_pro_stock = $db_pro_stock + $o_product_qty;

$data_update = array(
'stock'=>$total_pro_stock
);
$this->db->where('id', $dsa->id);
$last_id=$this->db->update('tbl_inventory', $data_update);

$data_transaction_insert2 = array(
'product_id'=>$dd1->product_id,
'unit_id'=>$dd1->unit_id,
'stock'=>$db_pro_stock,
'type'=>1,
'ip' =>$ip,
'added_by' =>$addedby,
'is_active' =>1,
'date'=>$cur_date
);


$this->base_model->insert_table("tbl_inventory_transaction",$data_transaction_insert2,1);


}

}
}
}
// if $t - 5
// id -> tbl_order2 foreach
// qty -> product
// inventory -> add again in stock

date_default_timezone_set("Asia/Calcutta");
$cur_date=date("Y-m-d H:i:s");

if($typ == 5){
  $data_update = array(
  'order_status'=>$typ,
  'last_update_date'=>$cur_date,
  'cancel_order_type'=> 2
  );

}else{
  $data_update = array(
  'order_status'=>$typ,
  'last_update_date'=>$cur_date
  );

}

$this->db->where('id', $id);
$zapak=$this->db->update('tbl_order1', $data_update);

if($zapak!=0){


  if($typ == 2){
  // echo "2";
    $this->db->select('*');
  $this->db->from('tbl_order1');
  $this->db->where('id',$id);
  $order1data= $this->db->get()->row();

  if(!empty($order1data)){
  $this->db->select('*');
  $this->db->from('tbl_users_device_token');
  $this->db->where('user_id',$order1data->user_id);
  $user_device_tokens= $this->db->get()->row();

  if(!empty($user_device_tokens)){

// echo $user_device_tokens->device_token;

//success notification code

$url = 'https://fcm.googleapis.com/fcm/send';

$title="Order C Cancelled";
$message="Your order has been cancelled successfully by admin. ";


$msg2 = array(
'body'=>$title,
'title'=>$message,
"sound" => "default"
);


$fields = array(
// 'to'=>"/topics/all",
'to'=>$user_device_tokens->device_token,
'notification'=>$msg2,
'priority'=>'high'
);

$fields = json_encode ( $fields );

$headers = array (
'Authorization: key=' . "AAAAWlT0RSA:APA91bHgSPLXkn_RDZ7C3KcGChZKEVM-J9DLMya1exCG1Dbd1cQtG3nKVG4jxFhhrad_7aWOvbRblCbC9KLcMuzkxkquBlKUwcfnVaNZZkA_l7k1md9j9gazWGQfWJ_S1-j_--5870RS",
'Content-Type: application/json'
);

$ch = curl_init ();
curl_setopt ( $ch, CURLOPT_URL, $url );
curl_setopt ( $ch, CURLOPT_POST, true );
curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
curl_setopt ( $ch, CURLOPT_POSTFIELDS, $fields );

$result = curl_exec ( $ch );
// echo $fields;
// echo $result;
curl_close ( $ch );

  //End success notification code

  }
  }


  }


if($typ == 3){
// echo "3" die();
  $this->db->select('*');
$this->db->from('tbl_order1');
$this->db->where('id',$id);
$order1data= $this->db->get()->row();

if(!empty($order1data)){
$this->db->select('*');
$this->db->from('tbl_users_device_token');
$this->db->where('user_id',$order1data->user_id);
$user_device_tokens= $this->db->get()->row();

if(!empty($user_device_tokens)){


//success notification code

$url = 'https://fcm.googleapis.com/fcm/send';

$title="Order C Cancelled";
$message="Your order has been cancelled successfully by admin. ";


$msg2 = array(
'body'=>$title,
'title'=>$message,
 "sound" => "default"
);


$fields = array(
// 'to'=>"/topics/all",
'to'=>$user_device_tokens->device_token,
'notification'=>$msg2,
'priority'=>'high'
);

$fields = json_encode ( $fields );

$headers = array (
'Authorization: key=' . "AAAAWlT0RSA:APA91bHgSPLXkn_RDZ7C3KcGChZKEVM-J9DLMya1exCG1Dbd1cQtG3nKVG4jxFhhrad_7aWOvbRblCbC9KLcMuzkxkquBlKUwcfnVaNZZkA_l7k1md9j9gazWGQfWJ_S1-j_--5870RS",
'Content-Type: application/json'
);

$ch = curl_init ();
curl_setopt ( $ch, CURLOPT_URL, $url );
curl_setopt ( $ch, CURLOPT_POST, true );
curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
curl_setopt ( $ch, CURLOPT_POSTFIELDS, $fields );

$result = curl_exec ( $ch );
// echo $fields;
// echo $result;
curl_close ( $ch );



}
}


}



if($typ == 4){
// echo "4" die();
  $this->db->select('*');
$this->db->from('tbl_order1');
$this->db->where('id',$id);
$order1data= $this->db->get()->row();

if(!empty($order1data)){
$this->db->select('*');
$this->db->from('tbl_users_device_token');
$this->db->where('user_id',$order1data->user_id);
$user_device_tokens= $this->db->get()->row();

if(!empty($user_device_tokens)){

//success notification code

$url = 'https://fcm.googleapis.com/fcm/send';

$title="Order Delivered";
$message="Your order has been delivered successfully. ";


$msg2 = array(
'body'=>$title,
'title'=>$message,
"sound" => "default"
);


$fields = array(
// 'to'=>"/topics/all",
'to'=>$user_device_tokens->device_token,
'notification'=>$msg2,
'priority'=>'high'
);

$fields = json_encode ( $fields );

$headers = array (
'Authorization: key=' . "AAAAWlT0RSA:APA91bHgSPLXkn_RDZ7C3KcGChZKEVM-J9DLMya1exCG1Dbd1cQtG3nKVG4jxFhhrad_7aWOvbRblCbC9KLcMuzkxkquBlKUwcfnVaNZZkA_l7k1md9j9gazWGQfWJ_S1-j_--5870RS",
'Content-Type: application/json'
);

$ch = curl_init ();
curl_setopt ( $ch, CURLOPT_URL, $url );
curl_setopt ( $ch, CURLOPT_POST, true );
curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
curl_setopt ( $ch, CURLOPT_POSTFIELDS, $fields );

$result = curl_exec ( $ch );
// echo $fields;
// echo $result;
curl_close ( $ch );

//End success notification code
}
}


}


if($typ == 5){

  $this->db->select('*');
$this->db->from('tbl_order1');
$this->db->where('id',$id);
$order1data= $this->db->get()->row();

if(!empty($order1data)){
$this->db->select('*');
$this->db->from('tbl_users_device_token');
$this->db->where('user_id',$order1data->user_id);
$user_device_tokens= $this->db->get()->row();

if(!empty($user_device_tokens)){

//success notification code

$url = 'https://fcm.googleapis.com/fcm/send';

$title="Order Cancelled";
$message="Your order ".$id." has been cancelled successfully by admin. ";


$msg2 = array(
'body'=>$title,
'title'=>$message,
"sound" => "default"
);


$fields = array(
// 'to'=>"/topics/all",
'to'=>$user_device_tokens->device_token,
'notification'=>$msg2,
'priority'=>'high'
);

$fields = json_encode ( $fields );

$headers = array (
'Authorization: key=' . "AAAAWlT0RSA:APA91bHgSPLXkn_RDZ7C3KcGChZKEVM-J9DLMya1exCG1Dbd1cQtG3nKVG4jxFhhrad_7aWOvbRblCbC9KLcMuzkxkquBlKUwcfnVaNZZkA_l7k1md9j9gazWGQfWJ_S1-j_--5870RS",
'Content-Type: application/json'
);

$ch = curl_init ();
curl_setopt ( $ch, CURLOPT_URL, $url );
curl_setopt ( $ch, CURLOPT_POST, true );
curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
curl_setopt ( $ch, CURLOPT_POSTFIELDS, $fields );

$result = curl_exec ( $ch );
// echo $fields;
// echo $result;
curl_close ( $ch );

//End success notification code
}
}


}


redirect("dcadmin/orders/new_orders","refresh");
}
else
{
$this->session->set_flashdata('emessage','Sorry error occured');
redirect($_SERVER['HTTP_REFERER']);
}
}
else{
redirect("login/admin_login","refresh");
}
}

public function view_ordered_product_details($main_id){

if(!empty($this->session->userdata('admin_data'))){

$this->db->select('*');
$this->db->from('tbl_order2');
$this->db->where('main_id',base64_decode($main_id));
$data['ordered_product_details_data']= $this->db->get();

$this->load->view('admin/common/header_view',$data);
$this->load->view('admin/orders/view_ordered_product_details');
$this->load->view('admin/common/footer_view');

}
else{

redirect("login/admin_login","refresh");
}

}


//Order bill

public function view_order_bill($main_id){

            if(!empty($this->session->userdata('admin_data'))){

              $this->db->select('*');
               $this->db->from('tbl_order1');
               $this->db->where('id',base64_decode($main_id));
               $data['order1_data']= $this->db->get()->row();

              $this->db->select('*');
               $this->db->from('tbl_order2');
               $this->db->where('main_id',base64_decode($main_id));
               $data['order2_data']= $this->db->get();


              // $this->load->view('admin/common/header_view',$data);
              $this->load->view('admin/orders/order_bill',$data);
              // $this->load->view('admin/common/footer_view');

          }
          else{

              $this->load->view('admin/login/index');
          }

          }


public function test_notify(){



//success notification code

$url = 'https://fcm.googleapis.com/fcm/send';

$title="Order C Cancelled";
$message="Your order has been cancelled successfully by admin. ";


$msg2 = array(
'body'=>$title,
'title'=>$message,
"sound" => "default"
);


$fields = array(
// 'to'=>"/topics/all",
'to'=>"ex5LVdZgQ-qyOn0Q2HaK-F:APA91bHLxMRId0SuzDDUW52u89E9DFQ0JWPc-6bhlaqpDshG8dJXLZzae2ahKl4opZTl_Am-9tfuyjyAYyy49QfcvoiqPxFao5Gn4m1D7g884IoXLdotnR9OVxAIMsYnEvzS2jOwzvvy",
'notification'=>$msg2,
'priority'=>'high'
);

$fields = json_encode ( $fields );

$headers = array (
'Authorization: key=' . "AAAAWlT0RSA:APA91bHgSPLXkn_RDZ7C3KcGChZKEVM-J9DLMya1exCG1Dbd1cQtG3nKVG4jxFhhrad_7aWOvbRblCbC9KLcMuzkxkquBlKUwcfnVaNZZkA_l7k1md9j9gazWGQfWJ_S1-j_--5870RS",
'Content-Type: application/json'
);

$ch = curl_init ();
curl_setopt ( $ch, CURLOPT_URL, $url );
curl_setopt ( $ch, CURLOPT_POST, true );
curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
curl_setopt ( $ch, CURLOPT_POSTFIELDS, $fields );

$result = curl_exec ( $ch );
// echo $fields;
// echo $result;
curl_close ( $ch );



}






public function transfer_to_deliver($order_id_encoded){

if(!empty($this->session->userdata('admin_data'))){

$data['order_id_encoded'] = $order_id_encoded;
$this->db->select('*');
$this->db->from('tbl_delivery_users');
$data['delivery_users_data']= $this->db->get();

$this->load->view('admin/common/header_view',$data);
$this->load->view('admin/orders/transfer_to_deliver');
$this->load->view('admin/common/footer_view');

}
else{

redirect("login/admin_login","refresh");
}

}

public function transfer_order_process($delivery_user_id_encoded , $order_id_encoded){

if(!empty($this->session->userdata('admin_data'))){

$delivery_user_id = base64_decode($delivery_user_id_encoded);
$order_id = base64_decode($order_id_encoded);
$ip = $this->input->ip_address();
date_default_timezone_set("Asia/Calcutta");
$cur_date=date("Y-m-d H:i:s");
$addedby=$this->session->userdata('admin_id');


$last_id = 0;
$data_insert = array(
'order_id'=>$order_id,
'delivery_user_id'=>$delivery_user_id,
'status'=>0,
'ip' =>$ip,
'added_by' =>$addedby,
'date'=>$cur_date
);


$last_id=$this->base_model->insert_table("tbl_transfer_orders",$data_insert,1);

$data_update = array(
'delivery_status'=>1
);
$this->db->where('id', $order_id);
$this->db->update('tbl_order1', $data_update);



if($last_id!=0){


$this->db->select('*');
$this->db->from('tbl_order1');
$this->db->where('id',$order_id);
$order_user_data= $this->db->get()->row();
if(!empty($order_user_data))  {
$user_idd =$order_user_data->user_id;
}

$this->db->select('*');
$this->db->from('tbl_delivery_users');
$this->db->where('id',$delivery_user_id);
$delivery_user_data= $this->db->get()->row();

if(!empty($delivery_user_data)){
$delivery_user_email= $delivery_user_data->email;

$this->db->select('*');
$this->db->from('tbl_delivery_users_device_token');
$this->db->where('email',$delivery_user_email);
$delivery_user_device_tokens= $this->db->get();

foreach ($delivery_user_device_tokens->result() as $user_device_token) {
// code...

//success notification code

$url = 'https://fcm.googleapis.com/fcm/send';

$title="New Order Arrived";
$message="New delivery order transfered to you from admin, Please check.";


$msg2 = array(
 'body'=>$title,
'title'=>$message,
"sound" => "default"
);


$fields = array(
 //'to'=>"/topics/all",
 'to'=>$user_device_token->device_token,
'notification'=>$msg2,
'priority'=>'high'
);

$fields = json_encode ( $fields );

$headers = array (
'Authorization: key=' . "AAAAWlT0RSA:APA91bHgSPLXkn_RDZ7C3KcGChZKEVM-J9DLMya1exCG1Dbd1cQtG3nKVG4jxFhhrad_7aWOvbRblCbC9KLcMuzkxkquBlKUwcfnVaNZZkA_l7k1md9j9gazWGQfWJ_S1-j_--5870RS",
'Content-Type: application/json'
);

$ch = curl_init ();
curl_setopt ( $ch, CURLOPT_URL, $url );
curl_setopt ( $ch, CURLOPT_POST, true );
curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
curl_setopt ( $ch, CURLOPT_POSTFIELDS, $fields );

$result = curl_exec ( $ch );
// echo $fields;
// echo $result;
curl_close ( $ch );

//End success notification code
}


$data_insert_notify = array(
'notification_type'=>2,
'notification_title'=>"Order Transfered",
'user_id'=>$user_idd,
'description' =>"this order id no: ".$order_id." Order Transfered Successfully.",
'is_read' =>0,
'ip' =>$ip,
'date'=>$cur_date
);


$this->base_model->insert_table("tbl_notification",$data_insert_notify,1);


}



$this->session->set_flashdata('smessage','Order Transfered successfully');
redirect("dcadmin/orders/new_orders","refresh");
}
else
{

$this->session->set_flashdata('emessage','Sorry error occured');
redirect($_SERVER['HTTP_REFERER']);
}



}
else{

redirect("login/admin_login","refresh");
}

}




public function excel_export(){

if(!empty($this->session->userdata('admin_data'))){

$this->load->library('excel');

// Read an Excel File
$tmpfname = "example.xls";
$excelReader = PHPExcel_IOFactory::createReaderForFile($tmpfname);
$objPHPExcel = $excelReader->load($tmpfname);

// Set document properties
$objPHPExcel->getProperties()->setCreator("Furkan Kahveci")
->setLastModifiedBy("Furkan Kahveci")
->setTitle("Office 2007 XLS Test Document")
->setSubject("Office 2007 XLS Test Document")
->setDescription("Description for Test Document")
->setKeywords("phpexcel office codeigniter php")
->setCategory("Test result file");

// Create a first sheet
$objPHPExcel->setActiveSheetIndex(0);
$objPHPExcel->getActiveSheet()->setCellValue('A1', "User name");
$objPHPExcel->getActiveSheet()->setCellValue('B1', "Address");
$objPHPExcel->getActiveSheet()->setCellValue('C1', "Mobile");
$objPHPExcel->getActiveSheet()->setCellValue('D1', "Zipcode ");
$objPHPExcel->getActiveSheet()->setCellValue('E1', "Payment Type");
$objPHPExcel->getActiveSheet()->setCellValue('F1', "Expected Delivery Date");
$objPHPExcel->getActiveSheet()->setCellValue('G1', "Slot Time");
$objPHPExcel->getActiveSheet()->setCellValue('H1', "Order Date");
$objPHPExcel->getActiveSheet()->setCellValue('I1', "Product Name ");
$objPHPExcel->getActiveSheet()->setCellValue('J1', "Unit");
$objPHPExcel->getActiveSheet()->setCellValue('K1', "Qty");
$objPHPExcel->getActiveSheet()->setCellValue('L1', "Amount");
$objPHPExcel->getActiveSheet()->setCellValue('M1', "Total Qty Amount");
$objPHPExcel->getActiveSheet()->setCellValue('N1', "Promocode");
$objPHPExcel->getActiveSheet()->setCellValue('O1', "Total Amount");

// Hide F and G column

// Set auto size
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setAutoSize(true);

// Add data
$this->db->select('*');
$this->db->from('tbl_order1');
$this->db->where('order_status',2);
$this->db->order_by('id',"DESC");
$datas= $this->db->get();
// echo $datas= $this->db->count_all_results();
// die();
// if(!empty($datas->result())){


$i=2; foreach($datas->result() as $data) {


// for ($i = 2; $i <= 50; $i++)
// {

$this->db->select('*');
$this->db->from('tbl_users');
$this->db->where('id',$data->user_id);
$user_dsa= $this->db->get()->row();
if(!empty($user_dsa)){

$a1= $user_dsa->first_name." ".$user_dsa->last_name ;
}
else{
$a1= "N/A";
}
// exit;


$addr_city = "N/A";

$addr_state = "N/A";

$addr_zipcode = "N/A";
$this->db->select('*');
$this->db->from('tbl_user_address');
$this->db->where('id',$data->address_id);
$address_sa= $this->db->get()->row();
if(!empty($address_sa)){
$addr_city = $address_sa->city;
$addr_state = $address_sa->state;
$addr_zipcode = $address_sa->zipcode;
$adr= $address_sa->address;
}
else{
$adr= "No Address Available";
}


$this->db->select('*');
$this->db->from('tbl_users');
$this->db->where('id',$data->user_id);
$user_dsas= $this->db->get()->row();
if(!empty($user_dsas)){

$con= $user_dsas->contact;
}
else{
$con= "N/A";
}

if($data->payment_type == 1){
$paym= "Cash On Delivery";
}
if($data->payment_type == 2){
$paym= "Online Payment";
}


$d_newdate = new DateTime($data->delivery_date);
$del_date = $d_newdate->format('j F, Y');


if($data->delivery_slot_id != 0 ){
$this->db->select('*');
$this->db->from('tbl_delivery_slots');
$this->db->where('id',$data->delivery_slot_id);
$slots_data= $this->db->get()->row();
if(!empty($slots_data)){
$slott= date("h:i a", strtotime($slots_data->from_time))."to".   date("h:i a", strtotime($slots_data->to_time));
}
else{
$slott= "No slot time available";
}
}else{
$slott= "N/A";

}


$newdate = new DateTime($data->date);
$order_date= $newdate->format('j F, Y, g:i a');


$promocode_name= "";

$this->db->select('*');
$this->db->from('tbl_promocode_applied');
$this->db->where('order_id',$data->id);
$this->db->where('user_id',$data->user_id);
$order_promocode= $this->db->get()->row();

if(!empty($order_promocode)){
$this->db->select('*');
$this->db->from('tbl_promocode');
$this->db->where('id',$order_promocode->promocode_id);
$order_promocode= $this->db->get()->row();
if(!empty($order_promocode)){
$promocode_name= $order_promocode->promocode;
}
else{
$promocode_name= "";
}

}
else{
$promocode_name= "";
}
$promocode_name= "";

$this->db->select('*');
$this->db->from('tbl_promocode_applied');
$this->db->where('order_id',$data->id);
$this->db->where('user_id',$data->user_id);
$order_promocode= $this->db->get()->row();

if(!empty($order_promocode)){
$this->db->select('*');
$this->db->from('tbl_promocode');
$this->db->where('id',$order_promocode->promocode_id);
$order_promocode= $this->db->get()->row();
if(!empty($order_promocode)){
$promocode_name= $order_promocode->promocode;
// $promocode_gift_am= $order_promocode->;
}
else{
$promocode_name= "";
}

}
else{
$promocode_name= "No Promocode";
}


$tottle_am= $data->total_amount;


$objPHPExcel->getActiveSheet()->setCellValue('A' . $i,$a1)
->setCellValue('B' . $i, $adr)
->setCellValue('C' . $i, $con)
->setCellValue('D' . $i, $addr_zipcode)
->setCellValue('E' . $i, $paym)
->setCellValue('F' . $i, $del_date)
->setCellValue('G' . $i, $slott)
->setCellValue('H' . $i, $order_date)
->setCellValue('N' . $i, $promocode_name)
->setCellValue('O' . $i, $tottle_am);

          $this->db->select('*');
$this->db->from('tbl_order2');
$this->db->where('main_id',$data->id);
$datas2= $this->db->get();

foreach($datas2->result() as $data2) {

$this->db->select('*');
$this->db->from('tbl_product');
$this->db->where('id',$data2->product_id);
// $this->db->where("is_active", 1);
$this->db->where("is_cat_delete", 0);
$prod_dsas= $this->db->get()->row();
if(!empty($prod_dsas)){

// $pro_name[]=$prod_dsas->name;
$d4=$prod_dsas->name;
// $qty[]= $order2pro->quantity;
}else{
$d4="Product not found";
}

$d2=$data2->unit_id;
$d3=$data2->quantity;


$this->db->select('*');
    $this->db->from('tbl_units');
    $this->db->where('id',$d2);
    $dsa= $this->db->get();
    $da=$dsa->row();
    if(!empty($da)){
    $t1=$da->name;

    }
    else{
      $t1="Type not found";

    }

$this->db->select('*');
$this->db->from('tbl_product_units');
$this->db->where('unit_id',$d2);
$this->db->where('product_id',$data2->product_id);
$unitss_data= $this->db->get()->row();

if(!empty($unitss_data)){
// $pro_selling= $unitss_data->selling_price;
// $total_qty_prices= $pro_selling * $d3;

$total_qty_prices= $data2->amount;
$pro_selling= $total_qty_prices / $d3;
}else{

$total_qty_prices= "";
$pro_selling= "";
}


$objPHPExcel->getActiveSheet()    ->setCellValue('I' . $i, $d4)
->setCellValue('J' . $i, $t1)
->setCellValue('K' . $i, $d3)
->setCellValue('L' . $i, $pro_selling)
->setCellValue('M' . $i, $total_qty_prices);
// ->setCellValue('H' . $i, $order_date)
// ->setCellValue('H' . $i, $order_date)
// ->setCellValue('H' . $i, $order_date)
$i++;
}


$i++;
}



// Set Font Color, Font Style and Font Alignment
     $stil=array(
         'borders' => array(
           'allborders' => array(
             'style' => PHPExcel_Style_Border::BORDER_THIN,
             'color' => array('rgb' => '000000')
           )
         ),
         'alignment' => array(
           'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
         )
     );
     $objPHPExcel->getActiveSheet()->getStyle('A:O')->applyFromArray($stil);
// }
// Set Font Color, Font Style and Font Alignment
// $stil=array(
//     'borders' => array(
//       'allborders' => array(
//         'style' => PHPExcel_Style_Border::BORDER_THIN,
//         'color' => array('rgb' => '000000')
//       )
//     ),
//     'alignment' => array(
//       'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
//     )
// );
// $objPHPExcel->getActiveSheet()->getStyle('A3:E3')->applyFromArray($stil);

// Merge Cells
// $objPHPExcel->getActiveSheet()->mergeCells('A5:E5');
// $objPHPExcel->getActiveSheet()->setCellValue('A5', "MERGED CELL");
// $objPHPExcel->getActiveSheet()->getStyle('A5:E5')->applyFromArray($stil);

// Save Excel xls File
$filename="filename.xls";
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
// exit;
ob_end_clean();
header('Content-type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename='.$filename);
$objWriter->save('php://output');

}
else{

redirect("login/admin_login","refresh");
}

}



}

?>
