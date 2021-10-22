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


  //  ========== Product Api =============

  public function get_all_products(){



			              $this->load->helper(array('form', 'url'));
			              $this->load->library('form_validation');
			              $this->load->helper('security');
			              if($this->input->post())
			              {
			                // print_r($this->input->post());
			                // exit;
			                $this->form_validation->set_rules('category_id', 'category_id', 'required|xss_clean|trim');
			                $this->form_validation->set_rules('subcategory_id', 'subcategory_id', 'required|xss_clean|trim');
			                $this->form_validation->set_rules('minorcategory_id', 'minorcategory_id', 'required|xss_clean|trim');


			                if($this->form_validation->run()== TRUE)
			                {
			                  $category_id=$this->input->post('category_id');
			                  $subcategory_id=$this->input->post('subcategory_id');
			                  $minorcategory_id=$this->input->post('minorcategory_id');

                                    $this->db->select('*');
                        $this->db->from('tbl_products');
                        $this->db->where('category_id',$category_id);
                        $this->db->where('subcategory_id',$subcategory_id);
                        $this->db->where('minorcategory_id',$minorcategory_id);
                        $product_data= $this->db->get();

                                 $product=[];
                                foreach ($product_data->result() as $data) {

                                    $product[] = array(
                                      'product_id'=>$data->id,
                                      'product_name'=>$data->productname,
                                      'description'=> $data->productdescription,
                                      'mrp'=> $data->mrp,
                                      'image'=>base_url().$data->image,
                                      // 'image1'=>$data->image1

                                    );

                                }

                                header('Access-Control-Allow-Origin: *');
                      					$res = array('message'=>"success",
                      								'status'=>200,
                      					      'data'=>$product
                      								);

                      								echo json_encode($res);

                      					  }

  }
}

  // ========= Get Product Details =========================
  public function get_productdetails($id){

              $this->db->select('*');
  $this->db->from('tbl_products');
  $this->db->where('id',$id);
  $productsdata= $this->db->get()->row();
  if(!empty($productsdata)){

  $products[] = array(
      'id'=> $productsdata->id,
      'productname'=> $productsdata->productname,
      'productimage'=> base_url().$productsdata->image,
      'mrp'=> $productsdata->mrp,
      'productdescription'=> $productsdata->productdescription,
      'modelno'=> $productsdata->modelno,
      // 'inventory'=> $data->inventory
  );



  header('Access-Control-Allow-Origin: *');
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

              $this->db->select('*');
  $this->db->from('tbl_category');
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
$this->form_validation->set_rules('email_id', 'email_id', 'valid_email|trim');
$this->form_validation->set_rules('password', 'password', 'trim');
$this->form_validation->set_rules('token_id', 'token_id', 'required|trim');

if($this->form_validation->run()== TRUE)
{
  $product_id=$this->input->post('product_id');
  $quantity=$this->input->post('quantity');
  $email_id=$this->input->post('email_id');
  $password=$this->input->post('password');
  $token_id=$this->input->post('token_id');


  // --------------add to cart using email------------


if(!empty($email_id)){


$this->db->select('*');
$this->db->from('tbl_users');
$this->db->where('email',$email_id);
$check_email= $this->db->get();
$check_id=$check_email->row();
if(!empty($check_id)){
if($check_id->password == $password){
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
     header('Access-Control-Allow-Origin: *');
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
          header('Access-Control-Allow-Origin: *');
          $res = array('message'=>'success',
          'status'=>200
          );

          echo json_encode($res);
}else{
      header('Access-Control-Allow-Origin: *');
      $res = array('message'=>'Some error occured',
      'status'=>201
      );

      echo json_encode($res);
    }



}else{

header('Access-Control-Allow-Origin: *');
$res = array('message'=>'product_id is not exist',
'status'=>201
);

echo json_encode($res);

}







}else{

header('Access-Control-Allow-Origin: *');
$res = array('message'=>'Product is alredy in cart.',
'status'=>201
);

echo json_encode($res);



}

}else{
header('Access-Control-Allow-Origin: *');
$res = array('message'=>'password not exist',
'status'=>201
);

echo json_encode($res);



}
}else{
header('Access-Control-Allow-Origin: *');
$res = array('message'=>'email not exist ',
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
                                      header('Access-Control-Allow-Origin: *');
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
                                                    header('Access-Control-Allow-Origin: *');
                                                    $res = array('message'=>'success',
                                                    'status'=>200
                                                    );

                                                    echo json_encode($res);
                                        }else{
                                                header('Access-Control-Allow-Origin: *');
                                                $res = array('message'=>'Some error occured',
                                                'status'=>201
                                                );

                                                echo json_encode($res);
                                              }
                                }else{
                                  header('Access-Control-Allow-Origin: *');
                                     $res = array('message'=>'Product_id not exist.',
                                     'status'=>201
                                     );

                                     echo json_encode($res);

                                }

                }else{

                        header('Access-Control-Allow-Origin: *');
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




//------update product cart-----
public function update_cart(){

$this->load->helper(array('form', 'url'));
$this->load->library('form_validation');
$this->load->helper('security');
if($this->input->post())
{
// print_r($this->input->post());
// exit;
$this->form_validation->set_rules('product_id', 'product_id', 'required|xss_clean|trim');
$this->form_validation->set_rules('quantity', 'quantity', 'required|xss_clean|trim');
$this->form_validation->set_rules('email_id', 'email_id', 'xss_clean|trim');
$this->form_validation->set_rules('password', 'password', 'xss_clean|trim');
$this->form_validation->set_rules('token_id', 'token_id', 'required|xss_clean|trim');

if($this->form_validation->run()== TRUE)
{
$product_id=$this->input->post('product_id');
$quantity=$this->input->post('quantity');
$email_id=$this->input->post('email_id');
$password=$this->input->post('password');
$token_id=$this->input->post('token_id');

//-------update with email----------

if(!empty($email_id)){

$this->db->select('*');
$this->db->from('tbl_users');
$this->db->where('email',$email_id);
$dsa= $this->db->get();
$user_data=$dsa->row();
if(!empty($user_data)){

if($user_data->password==$password){


    $this->db->select('*');
    $this->db->from('tbl_inventory');
    $this->db->where('product_id',$product_id);
    $inventory_data= $this->db->get()->row();

    // echo $inventory_data->quantity;
    // exit;
    //----inventory_check----------

    if($inventory_data->quantity >= $quantity){

    }else{
    header('Access-Control-Allow-Origin: *');
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
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Origin: *');
$res = array('message'=>'success',
'status'=>200
);

echo json_encode($res);
}else{
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Origin: *');
$res = array('message'=>'Some error occured',
'status'=>201
);

echo json_encode($res);
}

}else{

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Origin: *');
$res = array('message'=>'Passwod does not match',
'status'=>201
);

echo json_encode($res);

}


}else{

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Origin: *');
$res = array('message'=>'Email is not exist',
'status'=>201
);

echo json_encode($res);
}

}
//-----update with token id------
else{


    $this->db->select('*');
    $this->db->from('tbl_inventory');
    $this->db->where('product_id',$product_id);
    $inventory_data= $this->db->get()->row();

    // echo $inventory_data->quantity;
    // exit;
    //----inventory_check----------

    if($inventory_data->quantity >= $quantity){

    }else{
    header('Access-Control-Allow-Origin: *');
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
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Origin: *');
$res = array('message'=>'success',
'status'=>200
);

echo json_encode($res);
}else{
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Origin: *');
$res = array('message'=>'Some error occured',
'status'=>201
);

echo json_encode($res);
}


}
}else{
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Origin: *');
$res = array('message'=>validation_errors(),
'status'=>201
);

echo json_encode($res);


}

}else{

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Origin: *');
$res = array('message'=>"please insert data",
'status'=>201
);

echo json_encode($res);


}

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
$this->form_validation->set_rules('product_id', 'product_id', 'required|xss_clean|trim');
$this->form_validation->set_rules('email_id', 'email_id', 'xss_clean|trim');
$this->form_validation->set_rules('password', 'password', 'xss_clean|trim');
$this->form_validation->set_rules('token_id', 'token_id', 'required|xss_clean|trim');

if($this->form_validation->run()== TRUE)
{
$product_id=$this->input->post('product_id');
$email_id=$this->input->post('email_id');
$password=$this->input->post('password');
$token_id=$this->input->post('token_id');

//-------delete with email----------

if(!empty($email_id)){

$this->db->select('*');
$this->db->from('tbl_users');
$this->db->where('email',$email_id);
$dsa= $this->db->get();
$user_data=$dsa->row();
if(!empty($user_data)){

if($user_data->password==$password){

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
header('Access-Control-Allow-Origin: *');
$res = array('message'=>'success',
'status'=>200
);

echo json_encode($res);
}else{
header('Access-Control-Allow-Origin: *');
$res = array('message'=>'Some error occured',
'status'=>201
);

echo json_encode($res);
}

}else{
header('Access-Control-Allow-Origin: *');
$res = array('message'=>'Passwod does not match',
'status'=>201
);

echo json_encode($res);

}


}else{

header('Access-Control-Allow-Origin: *');
$res = array('message'=>'Email is not exist',
'status'=>201
);

echo json_encode($res);
}

}
//-----delete with token id------
else{


$zapak=$this->db->delete('tbl_cart', array('token_id' => $token_id,'product_id'=>$product_id));

if(!empty($zapak)){
header('Access-Control-Allow-Origin: *');
$res = array('message'=>'success',
'status'=>200
);

echo json_encode($res);
}else{
header('Access-Control-Allow-Origin: *');
$res = array('message'=>'Some error occured',
'status'=>201
);

echo json_encode($res);
}


}
}else{
header('Access-Control-Allow-Origin: *');
$res = array('message'=>validation_errors(),
'status'=>201
);

echo json_encode($res);


}

}else{

header('Access-Control-Allow-Origin: *');
$res = array('message'=>"please insert data",
'status'=>201
);

echo json_encode($res);


}

}




































}