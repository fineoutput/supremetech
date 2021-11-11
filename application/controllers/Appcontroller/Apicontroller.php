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


// ===============  Slider =============

public function get_slider(){

            $this->db->select('*');
$this->db->from('tbl_slider');
$this->db->where('is_active',1);

$sliderdata= $this->db->get();
$slider=[];
foreach($sliderdata->result() as $data) {
$slider[] = array(
    'name'=> $data->title,
    'image'=> base_url().$data->slider_image
);
}
$res = array('message'=>"success",
    'status'=>200,
    'data'=>$slider
    );

    echo json_encode($res);

}


// ========  Category =========

public function get_category(){

            $this->db->select('*');
$this->db->from('tbl_category');
$this->db->where('is_active',1);
$categorydata= $this->db->get();
$category=[];
foreach($categorydata->result() as $data) {
$category[] = array(
     'category_id'=>$data->id,
    'categoryname'=> $data->category,
    'image'=>base_url().$data->image2

);
}
$res = array('message'=>"success",
      'status'=>200,
      'data'=>$category
      );

      echo json_encode($res);


}

//=============  subcategory ================

public function get_subcategory(){


            $this->db->select('*');
$this->db->from('tbl_subcategory');
$this->db->where('category_id',$id);
$this->db->where('is_active',1);
$subcategorydata= $this->db->get();
$subcategory=[];
foreach($subcategorydata->result() as $data) {
$subcategory[] = array(
    'subcategory'=> $data->subcategory,


);
}
$res = array('message'=>"success",
      'status'=>200,
      'data'=>$subcategory
      );

      echo json_encode($res);


}


//  ========== Product Api minorcategory =============

public function get_minorcategory_products(){



		              $this->load->helper(array('form', 'url'));
		              $this->load->library('form_validation');
		              $this->load->helper('security');
		              if($this->input->post())
		              {
		                // print_r($this->input->post());
		                // exit;
		                // $this->form_validation->set_rules('category_id', 'category_id', 'required|xss_clean|trim');
		                // $this->form_validation->set_rules('subcategory_id', 'subcategory_id', 'required|xss_clean|trim');
		                $this->form_validation->set_rules('minorcategory_id', 'minorcategory_id', 'required|xss_clean|trim');


		                if($this->form_validation->run()== TRUE)
		                {
		                  // $category_id=$this->input->post('category_id');
		                  // $subcategory_id=$this->input->post('subcategory_id');
		                  $minorcategory_id=$this->input->post('minorcategory_id');

                                  $this->db->select('*');
                      $this->db->from('tbl_products');
                      // $this->db->where('category_id',$category_id);
                      // $this->db->where('subcategory_id',$subcategory_id);
                      $this->db->where('minorcategory_id',$minorcategory_id);
                      $product_data= $this->db->get();

                               $product=[];
                              foreach ($product_data->result() as $data) {

                                  $product[] = array(
                                    'product_id'=>$data->id,
                                    'product_name'=>$data->productname,
                                    'description'=> $data->productdescription,
                                    'mrp'=> $data->mrp,
                                    'price'=>$data->sellingprice,
                                    'image'=>base_url().$data->image,
                                    // 'image1'=>$data->image1

                                  );

                              }

                    					$res = array('message'=>"success",
                    								'status'=>200,
                    					      'data'=>$product
                    								);

                    								echo json_encode($res);

                    					  }

}
}

//-------------------product api category ----------------

public function get_category_products(){



		              $this->load->helper(array('form', 'url'));
		              $this->load->library('form_validation');
		              $this->load->helper('security');
		              if($this->input->post())
		              {
		                // print_r($this->input->post());
		                // exit;
		                //$this->form_validation->set_rules('category_id', 'category_id', 'required|xss_clean|trim');
		                // $this->form_validation->set_rules('subcategory_id', 'subcategory_id', 'required|xss_clean|trim');
		                 $this->form_validation->set_rules('minorcategory_id', 'minorcategory_id', 'required|xss_clean|trim');


		                if($this->form_validation->run()== TRUE)
		                {
		                  //$category_id=$this->input->post('category_id');
		                  // $subcategory_id=$this->input->post('subcategory_id');
		                   $minorcategory_id=$this->input->post('minorcategory_id');

                                  $this->db->select('*');
                      $this->db->from('tbl_products');
                      //$this->db->where('category_id',$category_id);
                      $this->db->where('minorcategory_id',$minorcategory_id);
                      $this->db->where('is_active',1);

                      // $this->db->where('subcategory_id',$subcategory_id);

                      $product_data= $this->db->get();

                               $product=[];
                              foreach ($product_data->result() as $data) {

                                  $product[] = array(
                                    'product_id'=>$data->id,
                                    'product_name'=>$data->productname,
                                    'description'=> $data->productdescription,
                                    'mrp'=> $data->mrp,
                                    'price'=>$data->sellingprice,
                                    'image'=>base_url().$data->image,
                                    // 'image1'=>$data->image1

                                  );

                              }

                    					$res = array('message'=>"success",
                    								'status'=>200,
                    					      'data'=>$product
                    								);

                    								echo json_encode($res);

                    					  }

}
}





//-------------

//-------------------product api subcategory----------------


public function get_subcategory_products(){



$this->load->helper(array('form', 'url'));
$this->load->library('form_validation');
$this->load->helper('security');
if($this->input->post())
{
  // print_r($this->input->post());
  // exit;
  // $this->form_validation->set_rules('category_id', 'category_id', 'required|xss_clean|trim');
  $this->form_validation->set_rules('subcategory_id', 'subcategory_id', 'required|xss_clean|trim');
  // $this->form_validation->set_rules('minorcategory_id', 'minorcategory_id', 'required|xss_clean|trim');


  if($this->form_validation->run()== TRUE)
  {
    // $category_id=$this->input->post('category_id');
    $subcategory_id=$this->input->post('subcategory_id');
    // $minorcategory_id=$this->input->post('minorcategory_id');

                $this->db->select('*');
    $this->db->from('tbl_products');
    // $this->db->where('category_id',$category_id);

    $this->db->where('subcategory_id',$subcategory_id);
    // $this->db->where('minorcategory_id',$minorcategory_id);
    $this->db->where('is_active',1);
    $product_data= $this->db->get();

             $product=[];
            foreach ($product_data->result() as $data) {

                $product[] = array(
                  'product_id'=>$data->id,
                  'product_name'=>$data->productname,
                  'description'=> $data->productdescription,
                  'mrp'=> $data->mrp,
                  'price'=>$data->sellingprice,
                  'image'=>base_url().$data->image,
                  // 'image1'=>$data->image1

                );

            }

            $res = array('message'=>"success",
                  'status'=>200,
                  'data'=>$product
                  );

                  echo json_encode($res);

              }

}
}




//---------------------

// ========= Get Product Details =========================
  public function get_productdetails($id){

            $this->db->select('*');
$this->db->from('tbl_products');
$this->db->where('id',$id);
$this->db->where('is_active',1);
$productsdata= $this->db->get()->row();
if(!empty($productsdata)){

$products[] = array(
    'id'=> $productsdata->id,
    'productname'=> $productsdata->productname,
    'productimage'=> base_url().$productsdata->image,
    'mrp'=> $productsdata->mrp,
    'price'=> $productsdata->sellingprice,
    'productdescription'=> $productsdata->productdescription,
    'modelno'=> $productsdata->modelno,
    // 'inventory'=> $data->inventory
);



$res = array('message'=>"success",
      'status'=>200,
      'data'=>$products
      );

      echo json_encode($res);

    }
    else{
      $res = array('message'=>"not valid",
      'status'=>201,
);
echo json_encode($res);
    }

}

//get all category
public function get_allcategory(){

  $this->load->helper(array('form', 'url'));
  $this->load->library('form_validation');
  $this->load->helper('security');
  if($this->input->post())
  {
    // print_r($this->input->post());
    // exit;
    // $this->form_validation->set_rules('category_id', 'category_id', 'required|xss_clean|trim');
    $this->form_validation->set_rules('category_id', 'category_id', 'required|xss_clean|trim');
    // $this->form_validation->set_rules('minorcategory_id', 'minorcategory_id', 'required|xss_clean|trim');


    if($this->form_validation->run()== TRUE)
    {
      $category_id=$this->input->post('category_id');




//
//             $this->db->select('*');
// $this->db->from('tbl_category');
// $this->db->where('is_active',1);
// $categorydata= $this->db->get();
// $category=[];
// foreach($categorydata->result() as $data) {
//   $c_id=$data->id;
  $this->db->select('*');
  $this->db->from('tbl_subcategory');
  $this->db->where('category_id',$category_id);
  $sub= $this->db->get();
  $subcategory=[];
  foreach($sub->result() as $data2) {

    $this->db->select('*');
                $this->db->from('tbl_minorcategory');
                $this->db->where('category_id',$category_id);
                $this->db->where('subcategory_id',$data2->id);
                $minor_category= $this->db->get();
                $minorcategory=[];
              foreach($minor_category->result() as $m_id){
                $minorcategory[]=array(
                  'minor_id'=>$m_id->id,
                  'minor_name' =>$m_id->minorcategoryname
                );
              }



  $subcategory[] = array(
    'sub_id' => $data2->id,
      'name'=> $data2->subcategory,
      'minor_category'=>$minorcategory



  );
}
// $catt=array('name'=> $data->categoryname,'sub_name'=>$subcategory);

//   $cat[] = array(
//     'id' =>$data->id,
//     'name' =>$data->category,
//
//     'sub_category' =>$subcategory
//
// );
//
//
// }
$res = array('message'=>"success",
      'status'=>200,
      'data'=>$subcategory,
      );

      echo json_encode($res);





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


// ================= Most popular product ====================

//
// public function most_popular_product(){
//
//              $this->db->select('*');
//  $this->db->from('tbl_most_popular_product');
//  //$this->db->where('id',$usr);
//  $popular_product_data= $this->db->get();
//  $popular_product_data=[];
//
//  foreach($popular_product_data->result() as $data) {
//
//    $most_popular_product[]= array(
//
//   'p_id'=>$data->id,
//   'image'=>base_url().$data->image,
//   'image1'=>base_url().$data->image1,
//   'image2'=>base_url().$data->image2,
//   'image3'=>base_url().$data->image3,
//   'productdescription'=>$data->productdescription
// );
//
//
// }
//
// header('Access-Control-Allow-Origin: *');
// $res = array('message'=>"success",
//       'status'=>200,
//       'data'=>$most_popular_product
//       );
//
//       echo json_encode($res);
//
//
// }




//=============== surveillance  ==========

public function surveillance(){

$this->db->select('*');
$this->db->from('tbl_surveillance');
$surveillance_data= $this->db->get();
$surveillance=[];
foreach($surveillance_data->result() as $data) {
$surveillance[] = array(
'description'=>$data->description,
'image'=> base_url().$data->image,
// 'image2'=> base_url().$data->Image2

);
}
$res = array('message'=>"success",
'status'=>200,
'data'=>$surveillance
);

echo json_encode($res);


}


// ==================Biometric Api ================

// public function set_biometric(){
//
//               $this->db->select('*');
//   $this->db->from('tbl_biometric');
//   //$this->db->where('id',$usr);
//   $biometric_data= $this->db->get();
//   $biometric=[];
//
//   foreach($->result() as $data) {
//
//     $biometric[]= array(
//       'description'=>$data->description,
//       'image'=>base_url().$data->image
//     );
// }
// header('Access-Control-Allow_Origin: *');
// $res= array('message'=>succes)


// =========== Add Cart APi ===================

public function add_to_cart(){

$this->load->helper(array('form', 'url'));
$this->load->library('form_validation');
$this->load->helper('security');
if($this->input->post())
{

$headers=$this->input->request_headers();



       $phone=$headers['phone'];
        $password=$headers['authentication'];
        $token_id=$headers['token_id'];
    





$this->form_validation->set_rules('product_id', 'product_id', 'required|trim');
$this->form_validation->set_rules('quantity', 'quantity', 'required|trim');
// $this->form_validation->set_rules( $token_id, 'token_id', 'required|trim');

if($this->form_validation->run()== TRUE)
{
$product_id=$this->input->post('product_id');
$quantity=$this->input->post('quantity');
// $email_id=$this->input->post('email_id');
// $password=$this->input->post('password');
// $token_id=$this->input->post('token_id');


// --------------add to cart using email------------


if(!empty($phone)){


$this->db->select('*');
$this->db->from('tbl_users');
$this->db->where('phone',$phone);
$check_phone= $this->db->get();
$check_id=$check_phone->row();
if(!empty($check_id)){
if($check_id->authentication == $password){
$this->db->select('*');
$this->db->from('tbl_cart');
$this->db->where('user_id',$check_id->id);
$this->db->where('product_id',$product_id);
$check_cart= $this->db->get();
$cart=$check_cart->row();
if(empty($cart)){
$ip = $this->input->ip_address();
date_default_timezone_set("Asia/Calcutta");
$cur_date=date("Y-m-d H:i:s");

//----check product_id in product table-------
$this->db->select('*');
$this->db->from('tbl_products');
$this->db->where('id',$product_id);
$check_product= $this->db->get();
$check_product_id=$check_product->row();

if(!empty($check_product_id)){
$this->db->select('*');
 $this->db->from('tbl_inventory');
 $this->db->where('product_id',$product_id);
 $check_inventory= $this->db->get();
 $check_inventory_id=$check_inventory->row();

 if($check_inventory_id->quantity >= $quantity){

 }else{
    $res = array('message'=> "$check_product_id->productname Product is out of stock",
    'status'=>201
    );

    echo json_encode($res);
    exit;
 }




$data_insert = array('product_id'=>$product_id,
'quantity'=>$quantity,
'user_id'=>$check_id->id,
'token_id'=>$token_id,
'ip' =>$ip,
'date'=>$cur_date

);

$last_id=$this->base_model->insert_table("tbl_cart",$data_insert,1) ;


if(!empty($last_id)){
        $res = array('message'=>'success',
        'status'=>200
        );

        echo json_encode($res);
}else{
    $res = array('message'=>'Some error occured',
    'status'=>201
    );

    echo json_encode($res);
  }



}else{

$res = array('message'=>'product_id is not exist',
'status'=>201
);

echo json_encode($res);

}







}else{

$res = array('message'=>'Product is alredy in cart.',
'status'=>201
);

echo json_encode($res);



}

}else{
$res = array('message'=>'password not exist',
'status'=>201
);

echo json_encode($res);



}
}else{
$res = array('message'=>'phone not exist ',
'status'=>201
);

echo json_encode($res);



}
}


    else{




            $this->db->select('*');
            $this->db->from('tbl_cart');
            $this->db->where('token_id',$token_id);
            $this->db->where('product_id',$product_id);
            $check_cart= $this->db->get();
            $cart=$check_cart->row();
            if(empty($cart)){
                   $ip = $this->input->ip_address();
                  date_default_timezone_set("Asia/Calcutta");
                  $cur_date=date("Y-m-d H:i:s");

                  //----check product_id in product table-------
                              $this->db->select('*');
                              $this->db->from('tbl_products');
                              $this->db->where('id',$product_id);
                              $check_product= $this->db->get();
                              $check_product_id=$check_product->row();

                    if(!empty($check_product_id)){

                      $this->db->select('*');
                                  $this->db->from('tbl_inventory');
                                  $this->db->where('product_id',$product_id);
                                  $check_inventory= $this->db->get();
                                  $check_inventory_id=$check_inventory->row();


                                  if($check_inventory_id->quantity >= $quantity){

                                  }else{
                                     $res = array('message'=> "$check_product_id->productname Product is out of stock",
                                     'status'=>201
                                     );

                                     echo json_encode($res);
                                     exit;
                                  }



                                $data_insert = array('product_id'=>$product_id,
                                      'quantity'=>$quantity,
                                      'token_id'=>$token_id,
                                      'ip' =>$ip,
                                      'date'=>$cur_date

                                      );

                                      $last_id=$this->base_model->insert_table("tbl_cart",$data_insert,1) ;


                                      if(!empty($last_id)){
                                                  $res = array('message'=>'success',
                                                  'status'=>200
                                                  );

                                                  echo json_encode($res);
                                      }else{
                                              $res = array('message'=>'Some error occured',
                                              'status'=>201
                                              );

                                              echo json_encode($res);
                                            }
                              }else{
                                   $res = array('message'=>'Product_id not exist.',
                                   'status'=>201
                                   );

                                   echo json_encode($res);

                              }

              }else{

                          $res = array('message'=>'Product is alredy in cart.',
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

// =============view cart data ============
public function view_cart_data(){


$this->load->helper(array('form', 'url'));
$this->load->library('form_validation');
$this->load->helper('security');
// if($this->input->post())
// {

  $headers=$this->input->request_headers();
         $phone=$headers['phone'];
          $password=$headers['authentication'];
  				$token_id=$headers['token_id'];



// $this->form_validation->set_rules('email_id', 'email_id', 'xss_clean|trim');
// $this->form_validation->set_rules('password', 'password', 'xss_clean|trim');
// $this->form_validation->set_rules('token_id', 'token_id', 'required|xss_clean|trim');

// if($this->form_validation->run()== TRUE)
// {
// $email_id=$this->input->post('email_id');
// $password=$this->input->post('password');
// $token_id=$this->input->post('token_id');

//-------add to cart with email----------

if(!empty($phone)){

$this->db->select('*');
$this->db->from('tbl_users');
$this->db->where('phone',$phone);
$dsa= $this->db->get();
$user_data=$dsa->row();
if(!empty($user_data)){

if($user_data->authentication==$password){

$this->db->select('*');
$this->db->from('tbl_cart');
$this->db->where('user_id',$user_data->id);
$cart_data= $this->db->get();
$cart_check = $cart_data->row();

if(!empty($cart_check)){
$total=0;
$sub_total=0;
$cart_info = [];
foreach($cart_data->result() as $data) {


$this->db->select('*');
$this->db->from('tbl_products');
$this->db->where('id',$data->product_id);
$dsa= $this->db->get();
$product_data=$dsa->row();




$cart_info[] = array('product_id'=>$data->product_id,
'product_name'=>$product_data->productname,
'product_image'=>base_url().$product_data->image,
'quantity'=>$data->quantity,
'price'=>$product_data->sellingprice,
'total='=>$total = $product_data->sellingprice * $data->quantity

);
$sub_total= $sub_total + $total;
}

$res = array('message'=>'success',
'status'=>200,
'data'=>$cart_info,
'subtotal'=>$sub_total
);

echo json_encode($res);

}else{
$res = array('message'=>' Your cart is empty',
'status'=>201
);

echo json_encode($res);
}
}else{
$res = array('message'=>'Passwod does not match',
'status'=>201
);

echo json_encode($res);

}


}else{

$res = array('message'=>'Email is not exist',
'status'=>201
);

echo json_encode($res);
}

}

else{

if(!empty($token_id)){

$this->db->select('*');
$this->db->from('tbl_cart');
$this->db->where('token_id',$token_id);
$cart_data= $this->db->get();
$cart_check = $cart_data->row();

// print_r($cart_check);
// exit;
if(!empty($cart_check)){
$total=0;
$sub_total=0;
$cart_info= [];

$this->db->select('*');
$this->db->from('tbl_products');
$this->db->where('id',$cart_check->product_id);
$dsa= $this->db->get();
$product_data=$dsa->row();
if(!empty($product_data)){



foreach($cart_data->result() as $data) {





$cart_info[] = array('product_id'=>$data->product_id,
'product_name'=>$product_data->productname,
'product_image'=>base_url().$product_data->image,
'quantity'=>$data->quantity,
'price'=>$product_data->sellingprice,
'total='=>$total = $product_data->sellingprice * $data->quantity

);
$sub_total= $sub_total + $total;

}

$res = array('message'=>'success',
'status'=>200,
'data'=>$cart_info,
'subtotal'=>$sub_total
);

echo json_encode($res);

}else{
  $res = array('message'=>'product is not mention please check.',
  'status'=>201
  );

  echo json_encode($res);
}


}else{
$res = array('message'=>'Your cart is empty',
'status'=>201
);

echo json_encode($res);
}
}else{
$res = array('message'=>'please insert data',
'status'=>201
);

echo json_encode($res);
}

}
// }
// else{
// $res = array('message'=>validation_errors(),
// 'status'=>201
// );
//
// echo json_encode($res);
//
//
// }

// }
// else{
//
// $res = array('message'=>"Please insert some data, No data available",
// 'status'=>201
// );
//
// echo json_encode($res);
//
// }

}

//------update product cart-----
public function update_cart(){



$this->load->helper(array('form', 'url'));
$this->load->library('form_validation');
$this->load->helper('security');
if($this->input->post())
{
// print_r($this->input->post());
// exit;

$headers=$this->input->request_headers();


       $phone=$headers['phone'];
        $password=$headers['authentication'];
        $token_id=$headers['token_id'];

$this->form_validation->set_rules('product_id', 'product_id', 'required|xss_clean|trim');
$this->form_validation->set_rules('quantity', 'quantity', 'required|xss_clean|trim');
// $this->form_validation->set_rules('email_id', 'email_id', 'xss_clean|trim');
// $this->form_validation->set_rules('password', 'password', 'xss_clean|trim');
// $this->form_validation->set_rules('token_id', 'token_id', 'required|xss_clean|trim');

if($this->form_validation->run()== TRUE)
{
$product_id=$this->input->post('product_id');
$quantity=$this->input->post('quantity');
// $email_id=$this->input->post('email_id');
// $password=$this->input->post('password');
// $token_id=$this->input->post('token_id');

//-------update with email----------

if(!empty($email_id)){

$this->db->select('*');
$this->db->from('tbl_users');
$this->db->where('phone',$phone);
$dsa= $this->db->get();
$user_data=$dsa->row();
if(!empty($user_data)){

if($user_data->authentication==$password){


  $this->db->select('*');
  $this->db->from('tbl_inventory');
  $this->db->where('product_id',$product_id);
  $inventory_data= $this->db->get()->row();

  // echo $inventory_data->quantity;
  // exit;
  //----inventory_check----------

  if($inventory_data->quantity >= $quantity){

  }else{
  $res = array('message'=> " Product is out of stock",
  'status'=>201
  );

  echo json_encode($res);
  exit;

  }



$data_insert = array('product_id'=>$product_id,
'quantity'=>$quantity

);


$this->db->where(array('user_id'=>  $user_data->id,'product_id'=>$product_id));
$last_id=$this->db->update('tbl_cart', $data_insert);


if(!empty($last_id)){
$res = array('message'=>'success',
'status'=>200
);

echo json_encode($res);
}else{
$res = array('message'=>'Some error occured',
'status'=>201
);

echo json_encode($res);
}

}else{

$res = array('message'=>'Passwod does not match',
'status'=>201
);

echo json_encode($res);

}


}else{

$res = array('message'=>'phone is not exist',
'status'=>201
);

echo json_encode($res);
}

}
//-----update with token id------
else{
 if(!empty($token_id)){

  $this->db->select('*');
  $this->db->from('tbl_inventory');
  $this->db->where('product_id',$product_id);
  $inventory_data= $this->db->get()->row();

  // echo $inventory_data->quantity;
  // exit;
  //----inventory_check----------

  if($inventory_data->quantity >= $quantity){

  }else{
  $res = array('message'=> "Product is out of stock",
  'status'=>201
  );

  echo json_encode($res);
  exit;

  }



$data_insert = array('product_id'=>$product_id,
'quantity'=>$quantity

);

$this->db->where(array('token_id'=> $token_id,'product_id'=>$product_id));
$last_id=$this->db->update('tbl_cart', $data_insert);


if(!empty($last_id)){
$res = array('message'=>'success',
'status'=>200
);

echo json_encode($res);
}else{
$res = array('message'=>'Some error occured',
'status'=>201
);

echo json_encode($res);
}
}else{

  $res = array('message'=>'please enter data',
  'status'=>201
  );

  echo json_encode($res);
}


}
}else{
$res = array('message'=>validation_errors(),
'status'=>201
);

echo json_encode($res);


}

}else{

$res = array('message'=>"please insert data",
'status'=>201
);

echo json_encode($res);


}

}

// ========== cart count==============

public function cart_count(){

$this->load->helper(array('form', 'url'));
$this->load->library('form_validation');
$this->load->helper('security');
// if($this->input->post())
// {

  $headers=$this->input->request_headers();


         $phone=$headers['phone'];
          $password=$headers['authentication'];
          $token_id=$headers['token_id'];


// $this->form_validation->set_rules('token_id', 'token_id', 'required|xss_clean|trim');
// $this->form_validation->set_rules('email_id', 'email_id', 'valid_email|xss_clean|trim');
// $this->form_validation->set_rules('password', 'password', 'xss_clean|trim');

// if($this->form_validation->run()== TRUE)
// {

// $token_id=$this->input->post('token_id');
// $email_id=$this->input->post('email_id');
// $password=$this->input->post('password');

// if($token_id==NULL && $phone==NULL && $password==NULL){
// $res = array('message'=>"data is not insert",
// 'status'=>201,
//
// );
//
// echo json_encode($res);
// exit();
//
// }


if(!empty($phone) || !empty($password)){

$this->db->select('*');
$this->db->from('tbl_users');
$this->db->where('phone',$phone);
$this->db->where('authentication',$password);
$dsa= $this->db->get();
$user=$dsa->row();
if(!empty($user)){
$user_id=$user->id;
// $pass=$user->password;




$this->db->select('*');
$this->db->from('tbl_cart');
$this->db->where('user_id',$user_id);

$counting=$this->db->count_all_results();
if(!empty($counting)){



$res = array('message'=>"success",
'status'=>200,
'data'=>$counting
);

echo json_encode($res);

}else{
$res = array('message'=>"no add product cart",
'status'=>200,

);

echo json_encode($res);
exit();

}

}else{

$res = array('message'=>"email or password do not match",
'status'=>201,

);

echo json_encode($res);
exit();

}


}else{

if(!empty($token_id)){


$this->db->select('*');
$this->db->from('tbl_cart');
$this->db->where('token_id',$token_id);
$counting=$this->db->count_all_results();
if(!empty($counting)){


$fa= $counting;







$res = array('message'=>"success",
'status'=>200,
'data'=>$fa
);

echo json_encode($res);


}else{

$res = array('message'=>"token_id wrong",
'status'=>201,

);

echo json_encode($res);
exit();

}




}else{

  $res = array('message'=>"Please insert data.",
  'status'=>201,

  );

  echo json_encode($res);
}
}

// }
// else{
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
// $res = array('message'=>'No data are available',
// 'status'=>201
// );
//
// echo json_encode($res);
// }




}


//------delete product cart-----
public function delete_cart_data(){

$this->load->helper(array('form', 'url'));
$this->load->library('form_validation');
$this->load->helper('security');
if($this->input->post())
{
// print_r($this->input->post());
// exit;

$headers=$this->input->request_headers();


       $phone=$headers['phone'];
        $password=$headers['authentication'];
        $token_id=$headers['token_id'];

$this->form_validation->set_rules('product_id', 'product_id', 'required|xss_clean|trim');
// $this->form_validation->set_rules('email_id', 'email_id', 'xss_clean|trim');
// $this->form_validation->set_rules('password', 'password', 'xss_clean|trim');
// $this->form_validation->set_rules('token_id', 'token_id', 'required|xss_clean|trim');

if($this->form_validation->run()== TRUE)
{
$product_id=$this->input->post('product_id');
// $email_id=$this->input->post('email_id');
// $password=$this->input->post('password');
// $token_id=$this->input->post('token_id');

//-------delete with email----------

if(!empty($phone)){

$this->db->select('*');
$this->db->from('tbl_users');
$this->db->where('phone',$phone);
$dsa= $this->db->get();
$user_data=$dsa->row();
if(!empty($user_data)){

if($user_data->authentication==$password){

//             $this->db->select('*');
// $this->db->from('tbl_cart');
// $this->db->where('user_id',$user_data->id);
// $this->db->where('$product_id',$product_id);
// $this->db->where('$type_id',$type_id);
// $cart_data= $this->db->get()->row();

$zapak=$this->db->delete('tbl_cart', array('user_id' => $user_data->id,'product_id'=>$product_id));

// echo $zapak;
// exit;
if(!empty($zapak)){
$res = array('message'=>'success',
'status'=>200
);

echo json_encode($res);
}else{
$res = array('message'=>'Some error occured',
'status'=>201
);

echo json_encode($res);
}

}else{
$res = array('message'=>'Passwod does not match',
'status'=>201
);

echo json_encode($res);

}


}else{

$res = array('message'=>'Email is not exist',
'status'=>201
);

echo json_encode($res);
}

}
//-----delete with token id------
else{

if(!empty($token_id)){

$zapak=$this->db->delete('tbl_cart', array('token_id' => $token_id,'product_id'=>$product_id));

if(!empty($zapak)){
$res = array('message'=>'success',
'status'=>200
);

echo json_encode($res);
}else{
$res = array('message'=>'Some error occured',
'status'=>201
);

echo json_encode($res);
}

}else{
  $res = array('message'=>'please insert data',
  'status'=>201
  );

  echo json_encode($res);
}


}
}else{
$res = array('message'=>validation_errors(),
'status'=>201
);

echo json_encode($res);


}

}else{

$res = array('message'=>"please insert data",
'status'=>201
);

echo json_encode($res);


}

}
//-----------------most-popular product--------------


public function most_popular_products(){

$this->db->select('*');
$this->db->from('tbl_products');
$this->db->where('popular_product',1);
$this->db->where('is_active',1);
$productslimitdata= $this->db->get();
$products=[];
foreach($productslimitdata->result() as $limit) {

//category
//   $this->db->select('*');
//   $this->db->from('tbl_category');
//   $this->db->where('id',$limit->subcategory_id);
//   $cat= $this->db->get()->row();
//   if(!empty($cat)){
//   $c1=$cat->category;
//   }
//   else{
//   $c1="";
//   }
//
//
//   //subcategory
//   $this->db->select('*');
//   $this->db->from('tbl_subcategory');
//   $this->db->where('id',$limit->subcategory_id);
//   $sub= $this->db->get()->row();
//   if(!empty($sub)){
//   $s1=$sub->subcategory;
//   }else{
//   $s1="";
//   }
//
//   //type --
//   $this->db->select('*');
//   $this->db->from('tbl_minorcategory');
//     $this->db->where('id',$limit->minorcategory_id);
//   $minor= $this->db->get()->row();
//   if(!empty($minor)){
//     $m1=$minor->minorcategoryname;
// }else{
//   $m1="";
// }





$products[] = array(
'product_id'=>$limit->id,
'productname'=> $limit->productname,
// 'category'=> $c1,
// 'sucategory'=> $s1,
// 'minorcategory'=>$m1,
'productimage'=> base_url().$limit->image,
'productimage1'=> base_url().$limit->image1,
'productimage2'=> base_url().$limit->video1,
'productimage3'=> base_url().$limit->video2,
'mrp'=> $limit->mrp,
'price'=>$limit->sellingprice,
'productdescription'=> $limit->productdescription,
// 'colours'=> $limit->colours,
// 'inventory'=> $data->inventory
);
}


$res = array('message'=>"success",
'status'=>200,
'data'=>$products
);

echo json_encode($res);


}
//--------------------stock_get----------------

public function stock_get(){

                 $this->db->select('*');
     $this->db->from('tbl_stock');
     $this->db->where('is_active',1);
     $data= $this->db->get();
     $stock=[];
     foreach ($data->result() as $value) {
       $stock[]=array(
         'image'=>base_url().$value->image1,
         'name'=>$value->stockname,
         'message'=>$value->stockmessage

       );
     }
       $res=array(
         'message'=>"success",
         'status'=>200,
         'data'=>$stock
       );
       echo json_encode($res);





   }
//-----------------------------MOST POPULAR BRANDS-------------

public function brands_view(){

$this->db->select('*');
$this->db->from('tbl_brands');
//$this->db->where('id',$id);
$this->db->where('is_active',1);
$brands= $this->db->get();
$brands_data=[];
foreach($brands->result() as $value){
$brands_data[]=array(
'id'=>$value->id,
'name'=>$value->name,
'message'=>$value->message,
'image'=>base_url().$value->image

);
}
$res = array('message'=>"success",
'status'=>200,
'data'=>$brands_data
);

echo json_encode($res);




}
//-------------show minorcategory---------------------
public function show_minorcategory(){

     $this->db->select('*');
                 $this->db->from('tbl_minorcategory');
                 $this->db->where('is_active',1);
                 $minor_category= $this->db->get();
                 $minorcategory=[];
                foreach ($minor_category->result() as $value) {

                  $minorcategory[]=array(
                    'id'=>$value->id,
                     'minorcategory'=>$value->minorcategoryname,
                     'image'=>base_url().$value->image
                  );
              }
              $res=array(
                'message'=>"success",
                'status'=>200,
                'data'=>$minorcategory
              );
              echo json_encode($res);



}

//-----feature product--
public function feature_product(){


                   $this->db->select('*');
       $this->db->from('tbl_products');
       $this->db->where('feature_product',1);
       $this->db->where('is_active',1);
       $data= $this->db->get();
       $feature=[];
       foreach ($data->result() as $limit) {

$feature[] = array(
'product_id'=>$limit->id,
'productname'=> $limit->productname,
'productimage'=> base_url().$limit->image,
'productimage1'=> base_url().$limit->image1,
'productimage2'=> base_url().$limit->video1,
'productimage3'=> base_url().$limit->video2,
'mrp'=> $limit->mrp,
'price'=>$limit->sellingprice,
'productdescription'=> $limit->productdescription,
);


       }
         $res=array(
           'message'=>"success",
           'status'=>200,
           'data'=>$feature
         );
         echo json_encode($res);



}

//---home two images---
public function home_two_image(){
  $this->db->select('*');
$this->db->from('tbl_products');
$this->db->where('is_active',1);
$data= $this->db->get()->row();
$image=[];

$image = array(
'image1'=> base_url().$data->image,
'image2'=> base_url().$data->image1,
);

$res=array(
'message'=>"success",
'status'=>200,
'data'=>$image
);
echo json_encode($res);



}



//-------------------related product------------

public function related_products($id){

$this->db->select('*');
$this->db->from('tbl_products');
$this->db->where('id',$id);
$product_data= $this->db->get()->row();

$this->db->select('*');
$this->db->from('tbl_products');
$this->db->where('minorcategory_id',$product_data->minorcategory_id);
$related_data= $this->db->get();

$related_info = [];
foreach($related_data->result() as $data) {

if($data->id!=$id){


}
$related_info[]  = array(
'product_id'=>$data->id,
'productname'=>$data->productname,
'productimage'=>base_url().$data->image,
'productdescription'=>$data->productdescription,
'mrp'=>$data->mrp,
'price'=>$data->sellingprice
);
}

$res = array('message'=>"success",
'status'=>200,
'data'=>$related_info

);

echo json_encode($res);
exit();


}

//------calculate------------
public function calculate(){

  $this->load->helper(array('form', 'url'));
  $this->load->library('form_validation');
  $this->load->helper('security');
  // if($this->input->post())
  // {

    $headers=$this->input->request_headers();
           $phone=$headers['phone'];
            $password=$headers['authentication'];
            $token_id=$headers['token_id'];

    //
    // $this->form_validation->set_rules('phone', 'phone', 'required|xss_clean|trim');
    // $this->form_validation->set_rules('authentication', 'authentication', 'required|xss_clean|trim');
    // $this->form_validation->set_rules('token_id', 'token_id', 'required|xss_clean|trim');


    // if($this->form_validation->run()== TRUE)
    // {
      //  $phone=$this->input->post('phone');
      //  $authentication=$this->input->post('authentication');
      // $token_id=$this->input->post('token_id');
      $ip = $this->input->ip_address();
    date_default_timezone_set("Asia/Calcutta");
      $cur_date=date("Y-m-d H:i:s");

            $this->db->select('*');
$this->db->from('tbl_users');
$this->db->where('phone',$phone);
$user_data= $this->db->get()->row();

if(!empty($user_data)){

if($authentication==$user_data->authentication)
{
            $this->db->select('*');
$this->db->from('tbl_cart');
$this->db->where('user_id',$user_data->id);
$cart_data= $this->db->get();
$cart_check=$cart_data->row();

if(!empty($cart_check)){
$total=0;
$sub_total=0;
 foreach($cart_data->result() as  $data) {

               $this->db->select('*');
   $this->db->from('tbl_products');
   $this->db->where('id',$data->product_id);
   $product_data= $this->db->get()->row();

if(!empty($product_data)){

$total = $product_data->sellingprice * $data->quantity;

$sub_total = $sub_total + $total;



}

}//end of foreach
$txn_id=bin2hex(random_bytes(10));
$order1_insert = array('user_id'=>$user_data->id,
          'total_amount'=>$sub_total,
          'payment_status'=>0,
          'order_status'=>0,
          'payment_status'=>0,
          'txnid'=>$txn_id,
          'ip' =>$ip,
          'date'=>$cur_date

          );

$last_id=$this->base_model->insert_table("tbl_order1",$order1_insert,1) ;

if(!empty($last_id)){

  $this->db->select('*');
$this->db->from('tbl_cart');
$this->db->where('user_id',$user_data->id);
$cart_data1= $this->db->get();
$cart_check1=$cart_data->row();

if(!empty($cart_check1)){
  $total2=0;
 foreach($cart_data1->result() as $data1) {


               $this->db->select('*');
   $this->db->from('tbl_products');
   $this->db->where('id',$data1->product_id);
   $product_data1= $this->db->get()->row();

if(!empty($product_data1)){

if($product_data1->inventory >= $data1->quantity){

$total2 = $product_data1->sellingprice * $data1->quantity ;
$order2_insert = array('main_id'=>$last_id,
          'product_id'=>$data1->product_id,
          'quantity'=>$data1->quantity,
          'product_mrp'=>$product_data1->mrp,
          // 'gst'=>$product_data1->gst,
          // 'gst_percentage'=>$product_data1->gst_percentage,
          'total_amount'=>$total2,
          'ip' =>$ip,
          'date'=>$cur_date

          );

$last_id2=$this->base_model->insert_table("tbl_order2",$order2_insert,1) ;

}
}else{
  $res = array('message'=>"Product is out of stock! Please remove this ".$product_data1->productname,
        'status'=>201,
        );

        echo json_encode($res);
        exit;
        }
}

}//end of foreach


              $res = array('message'=>"success",
                    'status'=>200,
                    'subtotal'=>$sub_total,
                    'txn_id'=>$txn_id
                    );

                    echo json_encode($res);
                    }
}
}
}else{
  $res = array('message'=>"fail",
        'status'=>201,
        );

        echo json_encode($res);
}

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
              // $res = array('message'=>"please insert some data",
              // 'status'=>201
              // );
              //
              // echo json_encode($res);
              //
              //
              // }

}

//----promocode---
public function apply_promocode(){

  $this->load->helper(array('form', 'url'));
  $this->load->library('form_validation');
  $this->load->helper('security');
  if($this->input->post())
  {

  $this->form_validation->set_rules('phone', 'phone', 'required|xss_clean|trim');
  $this->form_validation->set_rules('authentication', 'authentication', 'required|xss_clean|trim');
  $this->form_validation->set_rules('token_id', 'token_id', 'required|xss_clean|trim');
  $this->form_validation->set_rules('txn_id', 'txn_id', 'required|xss_clean|trim');
  $this->form_validation->set_rules('promocode', 'promocode', 'required|xss_clean|trim');

  if($this->form_validation->run()== TRUE)
  {

  $phone=$this->input->post('phone');
  $authentication=$this->input->post('authentication');
  $token_id=$this->input->post('token_id');
  $txn_id=$this->input->post('txn_id');
  $promocode=$this->input->post('promocode');

  $this->db->select('*');
  $this->db->from('tbl_users');
  $this->db->where('phone',$phone);
  $user_data= $this->db->get()->row();

  if(!empty($user_data)){

  if($user_data->authentication==$authentication){

  //--------check_promocode------
  $discount = 0;
  $promocode_id=0;

  $promocode = strtoupper($promocode);
// echo $promocode;
// exit;
  $this->db->select('*');
  $this->db->from('tbl_promocode');
  $this->db->where('promocode',$promocode);
  $this->db->where('is_active',1);
  $dsa= $this->db->get();
  $promocode_data=$dsa->row();

  if(!empty($promocode_data)){

    $this->db->select('*');
    $this->db->from('tbl_order1');
    $this->db->where('txnid',$txn_id);
    $order_data= $this->db->get()->row();


    $final_amount = 0;
  $promocode_id = $promocode_data->id;
  if($promocode_data->ptype==1){

  $this->db->select('*');
  $this->db->from('tbl_order1');
  $this->db->where('user_id',$user_data->id);
  $this->db->where('promocode_id',$promocode_data->id);
  $dsa= $this->db->get();
  $promo_check=$dsa->row();

  if(empty($promo_check)){

  if($order_data->total_amount > $promocode_data->minorder){ //----checking minorder for promocode
  // echo "hii";

  $discount_amt = $order_data->total_amount * $promocode_data->giftpercent/100;
  if($discount_amt > $promocode_data->max){
  // will get max amount
  $discount =  $promocode_data->max;

  }else{

  $discount =  $discount_amt;
  }

  }//endif of minorder
  else{

  $res = array('message'=>'Please add more products for promocode',
  'status'=>201
  );

  echo json_encode($res);
  exit;
  }



  }else{
  $res = array('message'=>'Promocode is already used',
  'status'=>201
  );

  echo json_encode($res);
  exit;


  }


  }
  //-----every time promocode---
  else{
  if($order_data->total_amount > $promocode_data->minorder){ //----checking minorder for promocode
  // echo "hii";

  $discount_amt = $order_data->total_amount * $promocode_data->giftpercent/100;
  if($discount_amt > $promocode_data->max){
  // will get max amount
  $discount =  $promocode_data->max;

  }else{

  $discount =  $discount_amt;
  }

  }//endif of minorder
  else{

  $res = array('message'=>'Please add more products for promocode',
  'status'=>201
  );

  echo json_encode($res);
  exit;
  }



  }


  $final_amount = $order_data->total_amount - $discount;


  //-------table_order1 entry-------

  $update_order1_data = array(
  'promocode_id'=>$promocode_id,
  'discount'=>$discount,
  );

  $this->db->where('txnid', $txn_id);
  $last_id=$this->db->update('tbl_order1', $update_order1_data);

if(!empty($last_id)){



  $response  = array(

  'total' => $order_data->total_amount,
  'sub_total' => $final_amount,
  'promocode_discount' => $discount,
  'promocode_id' => $promocode_id,

  );


  $res = array('message'=>'success',
  'status'=>200,
  'data'=>$response
  );

  echo json_encode($res);

  }else{
  $res = array('message'=>'some eroor occured! please try again',
  'status'=>201
  );

  echo json_encode($res);
  exit;



  }


  }else{

  $res = array('message'=>'invalid promocode',
  'status'=>201
  );

  echo json_encode($res);
  exit;


  }



  }else{
  $res = array('message'=>'Wrong Authentication',
  'status'=>201
  );

  echo json_encode($res);
  }
  }else{
  header('Access-Control-Allow-Origin: *');
  $res = array('message'=>'user not found',
  'status'=>201
  );

  echo json_encode($res);

  }



}else{

  $res = array('message'=>validation_errors(),
  'status'=>201
  );

  echo json_encode($res);


  }

  }else{

  $res = array('message'=>'No data are available',
  'status'=>201
  );

  echo json_encode($res);
  }





}


//----promocode_remove-----
public function promocode_remove(){

  $this->load->helper(array('form', 'url'));
  $this->load->library('form_validation');
  $this->load->helper('security');
  if($this->input->post())
  {

  $this->form_validation->set_rules('phone', 'phone', 'required|xss_clean|trim');
  $this->form_validation->set_rules('authentication', 'authentication', 'required|xss_clean|trim');
  $this->form_validation->set_rules('token_id', 'token_id', 'required|xss_clean|trim');
  $this->form_validation->set_rules('txn_id', 'txn_id', 'required|xss_clean|trim');
  $this->form_validation->set_rules('promocode_id', 'promocode_id', 'required|xss_clean|trim');

  if($this->form_validation->run()== TRUE)
  {

  $phone=$this->input->post('phone');
  $authentication=$this->input->post('authentication');
  $token_id=$this->input->post('token_id');
  $txn_id=$this->input->post('txn_id');
  $promocode=$this->input->post('promocode');

  $this->db->select('*');
  $this->db->from('tbl_users');
  $this->db->where('phone',$phone);
  $user_data= $this->db->get()->row();

  if(!empty($user_data)){

  if($user_data->authentication==$authentication){


              $data_insert = array('promocode_id'=>0,
                        'discount'=>0,

                        );


                $this->db->where('txnid', $txn_id);
                $last_id=$this->db->update('tbl_order1', $data_insert);
  if(!empty($last_id))   {
    $this->db->select('*');
  $this->db->from('tbl_order1');
  $this->db->where('txnid',$txn_id);
  $order_data= $this->db->get()->row();

// $final_amount = $order_data->total_amount + $order_data->delivery_charge;
$response  = array(

'sub_total' => $order_data->total_amount,
'promocode_discount' => $order_data->discount,

);
$res = array('message'=>'success',
'status'=>200,
'data'=>$response,

);

echo json_encode($res);
}else{
$res = array('message'=>'some error occured',
'status'=>201
);

echo json_encode($res);
}

      }else{
      $res = array('message'=>'Wrong Password',
      'status'=>201
      );

      echo json_encode($res);
      }
      }else{
      $res = array('message'=>'user not found',
      'status'=>201
      );

      echo json_encode($res);

      }



    }else{

      $res = array('message'=>validation_errors(),
      'status'=>201
      );

      echo json_encode($res);


      }

      }else{

      $res = array('message'=>'No data are available',
      'status'=>201
      );

      echo json_encode($res);
      }




}


//with image

//get all category
public function get_allcategory_image(){

            $this->db->select('*');
$this->db->from('tbl_category');
$this->db->where('is_active',1);
$categorydata= $this->db->get();
$category=[];
foreach($categorydata->result() as $data) {
  $c_id=$data->id;
  $this->db->select('*');
  $this->db->from('tbl_subcategory');
  $this->db->where('category_id',$data->id);
  $sub= $this->db->get();
  $subcategory=[];
  foreach($sub->result() as $data2) {

    $this->db->select('*');
                $this->db->from('tbl_minorcategory');
                $this->db->where('category_id',$c_id);
                $this->db->where('subcategory_id',$data2->id);
                $minor_category= $this->db->get();
                $minorcategory=[];
              foreach($minor_category->result() as $m_id){
                $minorcategory[]=array(
                  'minor_id'=>$m_id->id,
                  'minor_name' =>$m_id->minorcategoryname
                );
              }



  $subcategory[] = array(
    'sub_id' => $data2->id,
      'name'=> $data2->subcategory,
      'minor_category'=>$minorcategory



  );
}
// $catt=array('name'=> $data->categoryname,'sub_name'=>$subcategory);

  $cat[] = array(
    'id' =>$data->id,
    'name' =>$data->category,
    'image' =>base_url().$data->image2,
    'sub_category' =>$subcategory

);


}
$res = array('message'=>"success",
      'status'=>200,
      'data'=>$cat,
      );

      echo json_encode($res);


}









}
