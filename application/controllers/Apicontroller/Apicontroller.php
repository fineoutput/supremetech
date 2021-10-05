<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Apicontroller extends CI_Controller{
function __construct()
		{
			parent::__construct();
			$this->load->model("admin/login_model");
			$this->load->model("admin/base_model");
		}


// ==================================== Home Components =========================================================



// .slider


public function get_slider(){

              $this->db->select('*');
  $this->db->from('tbl_sliderpanel');
  $sliderdata= $this->db->get();
  $slider=[];
foreach($sliderdata->result() as $data) {
$slider = array(
      'name'=> $data->name,
      'image'=> base_url().$data->image
);
}
$res = array('message'=>"success",
			'status'=>200,
      'data'=>$slider
			);

			echo json_encode($res);

  }




// ========= gallery =========
public function get_gallery(){

              $this->db->select('*');
  $this->db->from('tbl_bannerimages');
  $bannerdata= $this->db->get();
  $banner=[];
foreach($bannerdata->result() as $data) {
$banner = array(
      'image'=> base_url().$data->image1,
      'image1'=> base_url().$data->image2,
      'image2'=> base_url().$data->image3,
      'image3'=> base_url().$data->image4
);
}
$res = array('message'=>"success",
			'status'=>200,
      'data'=>$banner
			);

			echo json_encode($res);

  }




//------- demo user register--------
public function add_user(){


              $this->load->helper(array('form', 'url'));
              $this->load->library('form_validation');
              $this->load->helper('security');
              if($this->input->post())
              {
                // print_r($this->input->post());
                // exit;
                $this->form_validation->set_rules('name', 'name', 'required|xss_clean|trim');
                $this->form_validation->set_rules('address', 'address', 'required|xss_clean|trim');
                $this->form_validation->set_rules('pincode', 'pincode', 'required|xss_clean|trim');
                $this->form_validation->set_rules('password', 'password', 'required|xss_clean|trim');

                if($this->form_validation->run()== TRUE)
                {
                  $name=$this->input->post('name');
                  $address=$this->input->post('address');
                  $pincode=$this->input->post('pincode');
                  $password=$this->input->post('password');

                    $ip = $this->input->ip_address();
            date_default_timezone_set("Asia/Calcutta");
                    $cur_date=date("Y-m-d H:i:s");
                    $addedby=999;

            $data_insert = array('name'=>$name,
                      'address'=>$address,
                      'pincode'=>$pincode,
                      'password'=>md5($password),
                      'ip' =>$ip,
                      'added_by' =>$addedby,
                      'is_active' =>1,
                      'date'=>$cur_date

                      );





            $last_id=$this->base_model->insert_table("tbl_users",$data_insert,1) ;

            if($last_id!=0){

              $res = array('message'=>"success",
'status'=>200
);

echo json_encode($res);

                                        }

                                        else

                                        {

                                          $res = array('message'=>"Sorry error occured",
                                          			'status'=>201
                                          			);

                                          			echo json_encode($res);




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

              $res = array('message'=>"Please insert some data, No data available",
              			'status'=>201
              			);

              			echo json_encode($res);

            }



}
// ======== Get Category =========

public function get_category(){

            $this->db->select('*');
$this->db->from('tbl_category');
$categorydata= $this->db->get();
$category=[];
foreach($categorydata->result() as $data) {
$category[] = array(
    'categoryname'=> $data->categoryname

);
}
$res = array('message'=>"success",
			'status'=>200,
      'data'=>$category
			);

			echo json_encode($res);


}

// ========= Get Products =========================
public function get_products(){

            $this->db->select('*');
$this->db->from('tbl_products');
$productsdata= $this->db->get();
$products=[];
foreach($productsdata->result() as $data) {
$products[] = array(
    'productimage'=> base_url().$data->image,
    'mrp'=> $data->mrp,
    'productdescription'=> $data->productdescription,
    'colours'=> $data->colours,
    'inventry'=> $data->inventry

);
}
$res = array('message'=>"success",
			'status'=>200,
      'data'=>$products
			);

			echo json_encode($res);


}

// ========= Get Sale =============
public function get_sale(){

            $this->db->select('*');
$this->db->from('tbl_sale');
$salesdata= $this->db->get();
$sales=[];
foreach($salesdata->result() as $data) {
$sales[] = array(
    'title'=> $data->title,
    'description'=> $data->description,
    'image'=> base_url().$data->image,
    'image1'=> base_url().$data->image1,

);
}
$res = array('message'=>"success",
			'status'=>200,
      'data'=>$sales
			);

			echo json_encode($res);


}





























}
