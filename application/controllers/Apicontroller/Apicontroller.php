<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Apicontroller extends CI_Controller{
function __construct()
    {
      parent::__construct();
      $this->load->model("admin/login_model");
      $this->load->model("admin/base_model");
    }


// ==================================== Home Components =========================================================


//.Slider


// =============== Get Slider =============

public function get_slider(){

              $this->db->select('*');
  $this->db->from('tbl_slider');
  $sliderdata= $this->db->get();
  $slider=[];
foreach($sliderdata->result() as $data) {
$slider[] = array(
      'name'=> $data->title,
      'image'=> base_url().$data->slider_image
);
}
header('Access-Control-Allow-Origin: *');
$res = array('message'=>"success",
      'status'=>200,
      'data'=>$slider
      );

      echo json_encode($res);

  }


  // ======== Get Category =========

  public function get_category(){

              $this->db->select('*');
  $this->db->from('tbl_category');
  $categorydata= $this->db->get();
  $category=[];
  foreach($categorydata->result() as $data) {
  $category[] = array(
      'categoryname'=> $data->category

  );
  }
  header('Access-Control-Allow-Origin: *');
  $res = array('message'=>"success",
        'status'=>200,
        'data'=>$category
        );

        echo json_encode($res);


  }

  //============= get subcategory ================

  public function get_subcategory(){


              $this->db->select('*');
  $this->db->from('tbl_subcategory');
  $this->db->where('category_id',$id);
  $subcategorydata= $this->db->get();
  $subcategory=[];
  foreach($subcategorydata->result() as $data) {
  $subcategory[] = array(
      'subcategory'=> $data->subcategory,


  );
  }
  header('Access-Control-Allow-Origin: *');
  $res = array('message'=>"success",
        'status'=>200,
        'data'=>$subcategory
        );

        echo json_encode($res);


  }


  // ========= Get Product Details =========================
  public function get_productdetails(){

              $this->db->select('*');
  $this->db->from('tbl_products');
  $productsdata= $this->db->get();
  $products=[];
  foreach($productsdata->result() as $data) {
  $products[] = array(
      'id'=> $data->id,
      'productname'=> $data->productname,
      'productimage'=> base_url().$data->image,
      'productimage1'=> base_url().$data->image1,
      'productimage2'=> base_url().$data->image2,
      'productimage3'=> base_url().$data->image3,
      'mrp'=> $data->mrp,
      'productdescription'=> $data->productdescription,
      'modelno'=> $data->modelno,
      // 'inventory'=> $data->inventory
  );
  }

  header('Access-Control-Allow-Origin: *');
  $res = array('message'=>"success",
        'status'=>200,
        'data'=>$products
        );

        echo json_encode($res);


  }

  //get all category
  public function get_allcategory(){

              $this->db->select('*');
  $this->db->from('tbl_category');
  $categorydata= $this->db->get();
  $category=[];
  foreach($categorydata->result() as $data) {

    $this->db->select('*');
    $this->db->from('tbl_subcategory');
    $this->db->where('category_id',$data->id);
    $sub= $this->db->get();
    $subcategory=[];
    foreach($sub->result() as $data2) {

    $subcategory[] = array(
      'sub_id' => $data2->id,
        'name'=> $data2->subcategory



    );
  }
  // $catt=array('name'=> $data->categoryname,'sub_name'=>$subcategory);

    $cat[] = array(
      'id' =>$data->id,
      'name' =>$data->category,
      'sub_category' =>$subcategory

  );


  }
  header('Access-Control-Allow-Origin: *');
  $res = array('message'=>"success",
        'status'=>200,
        'data'=>$cat,
        );

        echo json_encode($res);


  }

  // =========== Add Cart APi ===================

  public function add_to_cart(){

$this->load->helper(array('form', 'url'));
$this->load->library('form_validation');
$this->load->helper('security');
if($this->input->post())
{

$this->form_validation->set_rules('product_id', 'product_id', 'required|trim');
$this->form_validation->set_rules('quantity', 'quantity', 'required|trim');
$this->form_validation->set_rules('email', 'email', 'required|trim');
$this->form_validation->set_rules('password', 'password', 'required|trim');
$this->form_validation->set_rules('token_id', 'token_id', 'required|trim');

if($this->form_validation->run()== TRUE)
{
  $product_id=$this->input->post('product_id');
  $quantity=$this->input->post('quantity');
  $email=$this->input->post('email');
  $password=$this->input->post('password');
  $token_id=$this->input->post('token_id');

  if(!empty($email) || !empty($password)){

  $this->db->select('*');
              $this->db->from('tbl_users');
              $this->db->where('email',$email);
              $this->db->where('password',$password);
              $dsa= $this->db->get();
              $data=$dsa->row();
            if(!empty($data)){
              $user_id=$data->id;
              $password=$data->password;



            }else{
              $res = array('message'=>"Authentication error Occured",
        'status'=>200
        );

        echo json_encode($res);
        exit;


                  }
  $this->db->select('*');
  $this->db->from('tbl_cart');
  $this->db->where('product_id',$product_id);

  $this->db->where('user_id',$user_id);

  $dsa= $this->db->get();
  $dat=$dsa->row();
  if(!empty($dat)){
  $res = array('message'=>"Already Existing in Cart",
  'status'=>201
  );

  echo json_encode($res);
  exit();
  }else{



  $data_insert = array('product_id'=>$product_id,
  'quantity'=>$quantity,
  'user_id'=>$user_id,
  'quantity'=>$quantity,
  'token_id'=>$token_id


  );


  }


$last_id=$this->base_model->insert_table("tbl_cart",$data_insert,1) ;





if($last_id!=0){

$res = array('message'=>"success",
'status'=>200
);

echo json_encode($res);

}

else

{

$res = array('message'=>"Error Occured",
'status'=>201
);

echo json_encode($res);




}


  }
  else{


if(empty($token_id)){

$res = array('message'=>"Enter Token ",
'status'=>201
);

echo json_encode($res);
exit;
}




$this->db->select('*');
  $this->db->from('tbl_cart');
  $this->db->where('product_id',$product_id);
  $this->db->where('type_id',$type_id);


  $dsa= $this->db->get();
  $da=$dsa->row();
if(!empty($da)){
$res = array('message'=>"Already exists in Cart",
'status'=>201
);

echo json_encode($res);
exit();
}else{



$data_insert = array('product_id'=>$product_id,

      'quantity'=>$quantity,



      'token_id'=>$token_id


      );


}


$last_id=$this->base_model->insert_table("tbl_cart",$data_insert,1) ;





if($last_id!=0){

$res = array('message'=>"success",
'status'=>200
);

echo json_encode($res);

                        }

                        else

                        {

                          $res = array('message'=>" error occured",
                                'status'=>201
                                );

                                echo json_encode($res);




                        }
                      }



}
else{
$res = array('message'=>validation_errors(),
      'status'=>201
      );

      echo json_encode($res);


}

}
else{

$res = array('message'=>"Insert data, No data Available",
    'status'=>201
    );

    echo json_encode($res);

}
}


// // ========== retrieve data from cart api=======
//
//
// public function fetch_cart(){
//
//
//
// $this->load->helper(array('form', 'url'));
// $this->load->library('form_validation');
// $this->load->helper('security');
// if($this->input->post())
// {
//
// $this->form_validation->set_rules('token_id', 'token_id', 'xss_clean|trim');
// $this->form_validation->set_rules('email_id', 'email_id', 'valid_email|xss_clean|trim');
// $this->form_validation->set_rules('password', 'password', 'xss_clean|trim');
//
//
// if($this->form_validation->run()== TRUE)
// {
// $token_id=$this->input->post('token_id');
// $email_id=$this->input->post('email_id');
// $password=$this->input->post('password');
//
// if($token_id==NULL && $email_id==NULL && $password==NULL){
// echo "Inset Some Data";
// exit;
//
// }
//
// if(!empty($email_id) || !empty($password)){
//
// $this->db->select('*');
// $this->db->from('tbl_users');
// $this->db->where('email',$email_id);
// $this->db->where('password',$password);
// $dsa= $this->db->get();
// $da=$dsa->row();
// if(!empty($da)){
// $email_id=$da->id;
// $password=$da->password;
// }else{
//
// $res = array('message'=>"Authentication Error",
// 'status'=>201
// );
//
// echo json_encode($res);
// exit;
//
//
// }
//
// $this->db->select('*');
// $this->db->from('tbl_cart');
// $this->db->where('user_id',$user_id);
// $dsa4= $this->db->get();
// $da=$dsa4->row();
// if(empty($da)){
// $res = array('message'=>"No data found in database",
// 'status'=>201
// );
//
// echo json_encode($res);
// exit;
//
//
// }
//
//
//
//
// $this->db->select('*');
// $this->db->from('tbl_cart');
// $this->db->where('user_id',$user_id);
// $data= $this->db->get();
// //$ta=$data->row();
// $addcart=[];
// $subtotal=0;
//
//
// foreach ($data->result() as $value) {
//
//
//
// //product
// $this->db->select('*');
// $this->db->from('tbl_products');
// $this->db->where('id',$value->product_id);
// $dsa= $this->db->get();
// $da=$dsa->row();
// if(!empty($da)){
//
// $d3=$da->id;
// $d1=$da->name;
// $d2=$da->image;
// }else{
// $d1="";
// }
//
// //type
// $this->db->select('*');
// $this->db->from('tbl_type');
// $this->db->where('id',$value->type_id);
// $ds= $this->db->get();
// $ty=$ds->row();
// if(!empty($ty)){
// $t0=$ty->id;
// $t1=$ty->name;
// $t2=$ty->gstprice;
// $quan=$value->quantity;
// $total=$t2* $quan;
//
// }else{
// $t1="";
// $t2="";
// }
//
//
// //quantity
//
//
//
// $addcart[]=array(
// 'token_id'=>$value->token_id,
//
// 'product_id'=>$d3,
// 'product_name'=>$d1,
// 'product_image'=>$d2,
// 'type_id'=>$t0,
// 'type_Name'=>$t1,
// 'Price'=>$t2,
// 'Quantity'=>$quan,
// 'total_cost'=>$total
// );
// $subtotal= $subtotal + $total ;
//
//
//
//
//
// }
//
//
//
// }
//
//
//
// else{
//
//
// $this->db->select('*');
// $this->db->from('tbl_cart');
// $this->db->where('token_id',$token_id);
// $dsa44= $this->db->get();
// $da4=$dsa44->row();
// if(empty($da4)){
//
// $res = array('message'=>"wrong enterd token_id please check",
// 'status'=>201
// );
//
// echo json_encode($res);
// die();
//
//
// }
//
//
//
//
//
//
//
//
// $this->db->select('*');
// $this->db->from('tbl_cart');
// $this->db->where('token_id',$token_id);
// $data= $this->db->get();
// //$ta=$data->row();
// $addcart=[];
// $subtotal=0;
//
//
//
//
// foreach ($data->result() as $value) {
// //product
// $this->db->select('*');
// $this->db->from('tbl_products');
// $this->db->where('id',$value->product_id);
// $dsa= $this->db->get();
// $da=$dsa->row();
// if(!empty($da)){
//
// $d3=$value->product_id;
// $d1=$da->name;
// $d2=$da->image;
// }else{
// $d1="";
// }
//
// //type
// $this->db->select('*');
// $this->db->from('tbl_type');
// $this->db->where('id',$value->type_id);
// $ds= $this->db->get();
// $ty=$ds->row();
// if(!empty($ty)){
// $t0=$ty->id;
// $t1=$ty->name;
// $t2=$ty->gstprice;
// $quan=$value->quantity;
// $total=$t2* $quan;
//
// }else{
// $t1="";
// $t2="";
// }
//
//
// //quantity
//
//
//
// $addcart[]=array(
// 'token_id'=>$value->token_id,
//
// 'product_id'=>$d3,
// 'product_name'=>$d1,
// 'product_image'=>$d2,
// 'type_id'=>$t0,
// 'type_Name'=>$t1,
// 'Price'=>$t2,
// 'Quantity'=>$quan,
// 'total_cost'=>$total
// );
// $subtotal= $subtotal + $total ;
//
//
//
//
//
// }
//
//
//
// }
//
//
//
// header('Access-Control-Allow-Origin: *');
// $res = array('message'=>"success",
// 'status'=>200,
// 'data'=>$addcart,
// 'sub_total'=>$subtotal
// );
//
// echo json_encode($res);
//
//
// }else{
// $res = array('message'=>validation_errors(),
// 'status'=>201
// );
//
// echo json_encode($res);
//
//
// }
//
// }else{
//
// $res = array('message'=>"Enter Some data ",
// 'status'=>201
// );
//
// echo json_encode($res);
//
//
// }
//
//
//
//
//
//
//
//
//
//
// }
}
