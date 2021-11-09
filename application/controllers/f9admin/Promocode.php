<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . 'core/CI_finecontrol.php');
class Promocode extends CI_finecontrol{
function __construct()
{
parent::__construct();
$this->load->model("login_model");
$this->load->model("admin/base_model");
$this->load->library('user_agent');
$this->load->library('upload');
}

public function view_promocode(){

if(!empty($this->session->userdata('admin_data'))){


$data['user_name']=$this->load->get_var('user_name');

// echo SITE_NAME;
// echo $this->session->userdata('image');
// echo $this->session->userdata('position');
// exit;

$this->db->select('*');
$this->db->from('tbl_promocode');
//$this->db->where('id',$usr);
$data['promocode_data']= $this->db->get();

$this->load->view('admin/common/header_view',$data);
$this->load->view('admin/promocode/view_promocode');
$this->load->view('admin/common/footer_view');

}
else{

redirect("login/admin_login","refresh");
}

}

public function add_promocode(){

if(!empty($this->session->userdata('admin_data'))){

$this->load->view('admin/common/header_view');
$this->load->view('admin/promocode/add_promocode');
$this->load->view('admin/common/footer_view');

}
else{

redirect("login/admin_login","refresh");
}

}

public function update_promocode($idd){

if(!empty($this->session->userdata('admin_data'))){


$data['user_name']=$this->load->get_var('user_name');

// echo SITE_NAME;
// echo $this->session->userdata('image');
// echo $this->session->userdata('position');
// exit;

$id=base64_decode($idd);
$data['id']=$idd;

$this->db->select('*');
$this->db->from('tbl_promocode');
$this->db->where('id',$id);
$data['promocode_data']= $this->db->get()->row();


$this->load->view('admin/common/header_view',$data);
$this->load->view('admin/promocode/update_promocode');
$this->load->view('admin/common/footer_view');

}
else{

redirect("login/admin_login","refresh");
}

}

public function add_promocode_data($t,$iw="")

{

if(!empty($this->session->userdata('admin_data'))){


$this->load->helper(array('form', 'url'));
$this->load->library('form_validation');
$this->load->helper('security');
if($this->input->post())
{
// print_r($this->input->post());
// exit;
$this->form_validation->set_rules('promocode', 'promocode', 'required');
$this->form_validation->set_rules('ptype', 'ptype', '');
$this->form_validation->set_rules('giftpercent', 'giftpercent', 'required');
$this->form_validation->set_rules('minorder', 'minorder', 'required');
$this->form_validation->set_rules('max', 'max', 'required');
if($this->form_validation->run()== TRUE)
{
$promocode=$this->input->post('promocode');
$ptype=$this->input->post('ptype');
$giftpercent=$this->input->post('giftpercent');
$minorder=$this->input->post('minorder');
$max=$this->input->post('max');


$ip = $this->input->ip_address();
date_default_timezone_set("Asia/Calcutta");
$cur_date=date("Y-m-d H:i:s");
$addedby=$this->session->userdata('admin_id');

$typ=base64_decode($t);
$last_id = 0;
if($typ==1){



$data_insert = array(
'promocode'=>$promocode,
'ptype'=>$ptype,
'giftpercent'=>$giftpercent,
'minorder'=>$minorder,
'max'=>$max,

'ip' =>$ip,
'added_by' =>$addedby,
'is_active' =>1,
'date'=>$cur_date
);


$last_id=$this->base_model->insert_table("tbl_promocode",$data_insert,1) ;

}
if($typ==2){

$idw=base64_decode($iw);


$this->db->select('*');
$this->db->from('tbl_promocode');
$this->db->where('id',$idw);
$dsa=$this->db->get();
$da=$dsa->row();





$data_insert = array(
'promocode'=>$promocode,
'ptype'=>$ptype,
'giftpercent'=>$giftpercent,
'minorder'=>$minorder,
'max'=>$max,

);
$this->db->where('id', $idw);
$last_id=$this->db->update('tbl_promocode', $data_insert);
}
if($last_id!=0){
$this->session->set_flashdata('smessage','Data inserted successfully');
redirect("dcadmin/promocode/view_promocode","refresh");
}
else
{

$this->session->set_flashdata('emessage','Sorry error occured');
redirect($_SERVER['HTTP_REFERER']);
}
}
else{

$this->session->set_flashdata('emessage',validation_errors());
redirect($_SERVER['HTTP_REFERER']);

}

}
else{

$this->session->set_flashdata('emessage','Please insert some data, No data available');
redirect($_SERVER['HTTP_REFERER']);

}
}
else{

redirect("login/admin_login","refresh");


}

}

public function updatepromocodeStatus($idd,$t){

if(!empty($this->session->userdata('admin_data'))){


$data['user_name']=$this->load->get_var('user_name');

// echo SITE_NAME;
// echo $this->session->userdata('image');
// echo $this->session->userdata('position');
// exit;
$id=base64_decode($idd);

if($t=="active"){

$data_update = array(
'is_active'=>1

);

$this->db->where('id', $id);
$zapak=$this->db->update('tbl_promocode', $data_update);

if($zapak!=0){
redirect("dcadmin/promocode/view_promocode","refresh");
}
else
{
$this->session->set_flashdata('emessage','Sorry error occured');
redirect($_SERVER['HTTP_REFERER']);
}
}
if($t=="inactive"){
$data_update = array(
'is_active'=>0

);

$this->db->where('id', $id);
$zapak=$this->db->update('tbl_promocode', $data_update);

if($zapak!=0){
redirect("dcadmin/promocode/view_promocode","refresh");
}
else
{

$this->session->set_flashdata('emessage','Sorry error occured');
redirect($_SERVER['HTTP_REFERER']);
}
}



}
else{

redirect("login/admin_login","refresh");

}

}



public function delete_promocode($idd){

if(!empty($this->session->userdata('admin_data'))){

$data['user_name']=$this->load->get_var('user_name');

// echo SITE_NAME;
// echo $this->session->userdata('image');
// echo $this->session->userdata('position');
// exit;
$id=base64_decode($idd);

if($this->load->get_var('position')=="Super Admin"){

$zapak=$this->db->delete('tbl_promocode', array('id' => $id));
if($zapak!=0){

redirect("dcadmin/promocode/view_promocode","refresh");
}
else
{
$this->session->set_flashdata('emessage','Sorry error occured');
redirect($_SERVER['HTTP_REFERER']);
}
}
else{
$this->session->set_flashdata('emessage','Sorry you not a super admin you dont have permission to delete anything');
redirect($_SERVER['HTTP_REFERER']);
}


}
else{

redirect("login/admin_login","refresh");

}

}
}
