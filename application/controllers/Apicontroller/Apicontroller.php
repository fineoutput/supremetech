<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
class Apicontroller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("admin/login_model");
        $this->load->model("admin/base_model");
    }
    // ==================================== Home Components =========================================================
    //.Slider
    //-------------------state api--------------------
    public function all_state_get()
    {
        $this->db->select('*');
        $this->db->from('all_states');
        //$this->db->where('id',$usr);
        $data = $this->db->get();
        if (!empty($data)) {
            $address = [];
            foreach ($data->result() as $value) {
                $address[] = array(
                    'state_id' => $value->id,
                    'state' => $value->state_name,
                );
            }
            header('Access-Control-Allow-Origin: *');
            $res = array(
                'message' => 'success',
                'status' => 200,
                'data' => $address,
            );
            echo json_encode($res);
        } else {
            header('Access-Control-Allow-Origin: *');
            $res = array(
                'message' => 'some error occurred',
                'status' => 201,
            );
            echo json_encode($res);
        }
    }
    //============================get cities===========================
    public function get_cities($idd)
    {
        $this->db->select('*');
        $this->db->from('all_cities');
        $this->db->where('state_id', $idd);
        $city_data = $this->db->get();
        $city = [];
        foreach ($city_data->result() as $cities) {
            $city[] = array('id' => $cities->id, 'name' => $cities->city_name);
        }
        header('Access-Control-Allow-Origin: *');
        $res = array(
            'message' => "success",
            'status' => 200,
            'data' => $city,
        );
        echo json_encode($res);
    }
    // ===============  Slider =============
    public function get_slider()
    {
        $this->db->select('*');
        $this->db->from('tbl_slider');
        $this->db->where('is_active', 1);
        $sliderdata = $this->db->get();
        $slider = [];
        foreach ($sliderdata->result() as $data) {
            $slider[] = array(
                'link' => $data->link,
                'web_image' => base_url() . $data->web_image,
                'mob_image' => base_url() . $data->mob_image
            );
        }
        header('Access-Control-Allow-Origin: *');
        $res = array(
            'message' => "success",
            'status' => 200,
            'data' => $slider
        );
        echo json_encode($res);
    }
    // ========  Category =========
    public function get_category()
    {
        $this->db->select('*');
        $this->db->from('tbl_category');
        $this->db->where('is_active', 1);
        $categorydata = $this->db->get();
        $category = [];
        foreach ($categorydata->result() as $data) {
            $category[] = array(
                'categoryname' => $data->category
            );
        }
        header('Access-Control-Allow-Origin: *');
        $res = array(
            'message' => "success",
            'status' => 200,
            'data' => $category
        );
        echo json_encode($res);
    }
    //=============  subcategory ================
    public function get_subcategory()
    {
        $this->db->select('*');
        $this->db->from('tbl_subcategory');
        // $this->db->where('category_id', $id);
        $this->db->where('is_active', 1);
        $subcategorydata = $this->db->get();
        $subcategory = [];
        foreach ($subcategorydata->result() as $data) {
            $subcategory[] = array(
                'subcategory' => $data->subcategory,
            );
        }
        header('Access-Control-Allow-Origin: *');
        $res = array(
            'message' => "success",
            'status' => 200,
            'data' => $subcategory
        );
        echo json_encode($res);
    }
    //  ========== Product Api minorcategory =============
    public function get_minorcategory_products()
    {
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->helper('security');
        if ($this->input->post()) {
            // print_r($this->input->post());
            // exit;
            $this->form_validation->set_rules('phone', 'phone', 'xss_clean|trim');
            $this->form_validation->set_rules('authentication', 'authentication', 'xss_clean|trim');
            $this->form_validation->set_rules('minorcategory_id', 'minorcategory_id', 'required|xss_clean|trim');
            if ($this->form_validation->run() == true) {
                $phone = $this->input->post('phone');
                $authentication = $this->input->post('authentication');
                $minorcategory_id = $this->input->post('minorcategory_id');
                $T2 = 0;
                if (!empty($phone)) {
                    $this->db->select('*');
                    $this->db->from('tbl_users');
                    $this->db->where('phone', $phone);
                    $check_email = $this->db->get();
                    $check_id = $check_email->row();
                    if (!empty($check_id)) {
                        if ($check_id->authentication == $authentication) {
                            if ($check_id->type == "T2") {
                                $T2 = 1;
                            }
                        }
                    }
                }
                $this->db->select('*');
                $this->db->from('tbl_products');
                // $this->db->where('category_id',$category_id);
                // $this->db->where('subcategory_id',$subcategory_id);
                $this->db->where('is_active', 1);
                $this->db->where('minorcategory_id', $minorcategory_id);
                $product_data = $this->db->get();
                $this->db->select('*');
                $this->db->from('tbl_minorcategory');
                $this->db->where('id', $minorcategory_id);
                $get_minorcategory = $this->db->get()->row();
                if (!empty($get_minorcategory)) {
                    $minor_name = $get_minorcategory->minorcategoryname;
                }
                $product = [];
                foreach ($product_data->result() as $data) {
                    $show = 1;
                    if (!empty($data->brand) && $T2 == 1 && $data->brand != 0) {
                        $check = $this->db->get_where('tbl_brands', array('is_active' => 1, 'for_t2' => 1, 'id' => $data->brand))->result();
                        if (empty($check)) {
                            $show = 0;
                        }
                    }
                    if ($show == 0) {
                        continue;
                    }
                    $this->db->select('*');
                    $this->db->from('tbl_inventory');
                    $this->db->where('product_id', $data->id);
                    $inventory_data = $this->db->get()->row();
                    if (!empty($inventory_data)) {
                        if ($inventory_data->quantity > 0) {
                            $stock = 1;
                        } else {
                            $stock = 0;
                        }
                    } else {
                        $stock = 0;
                    }
                    $product[] = array(
                        'product_id' => $data->id,
                        'product_name' => $data->productname,
                        'description' => $data->productdescription,
                        'mrp' => $data->mrp,
                        'price' => $data->sellingprice,
                        'image' => base_url() . $data->image,
                        'max' => $data->max,
                        't2_price' => $data->t2_price,
                        't2_min' => $data->t2_min,
                        't2_max' => $data->t2_max,
                        'stock' => $stock
                    );
                }
                header('Access-Control-Allow-Origin: *');
                $res = array(
                    'message' => "success",
                    'status' => 200,
                    'data' => $product,
                    'minorcategory_name' => $minor_name
                );
                echo json_encode($res);
            }
        }
    }
    //-------------------product api category ----------------
    public function get_category_products()
    {
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->helper('security');
        if ($this->input->post()) {
            // print_r($this->input->post());
            // exit;
            $this->form_validation->set_rules('category_id', 'category_id', 'required|xss_clean|trim');
            // $this->form_validation->set_rules('subcategory_id', 'subcategory_id', 'required|xss_clean|trim');
            // $this->form_validation->set_rules('minorcategory_id', 'minorcategory_id', 'required|xss_clean|trim');
            if ($this->form_validation->run() == true) {
                $category_id = $this->input->post('category_id');
                // $subcategory_id=$this->input->post('subcategory_id');
                // $minorcategory_id=$this->input->post('minorcategory_id');
                $this->db->select('*');
                $this->db->from('tbl_products');
                $this->db->where('category_id', $category_id);
                $this->db->where('is_active', 1);
                // $this->db->where('subcategory_id',$subcategory_id);
                // $this->db->where('minorcategory_id',$minorcategory_id);
                $product_data = $this->db->get();
                $this->db->select('*');
                $this->db->from('tbl_category');
                $this->db->where('id', $category_id);
                $get_category_id = $this->db->get()->row();
                $category_name = '';
                if (!empty($get_category_id)) {
                    $category_name = $get_category_id->category;
                }
                $product = [];
                foreach ($product_data->result() as $data) {
                    $product[] = array(
                        'product_id' => $data->id,
                        'product_name' => $data->productname,
                        'description' => $data->productdescription,
                        'mrp' => $data->mrp,
                        'price' => $data->sellingprice,
                        'image' => base_url() . $data->image,
                        // 'image1'=>$data->image1
                    );
                }
                header('Access-Control-Allow-Origin: *');
                $res = array(
                    'message' => "success",
                    'status' => 200,
                    'data' => $product,
                    'category' => $category_name
                );
                echo json_encode($res);
            }
        }
    }
    //-------------
    //-------------------product api subcategory----------------
    public function get_subcategory_products()
    {
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->helper('security');
        if ($this->input->post()) {
            // print_r($this->input->post());
            // exit;
            // $this->form_validation->set_rules('category_id', 'category_id', 'required|xss_clean|trim');
            $this->form_validation->set_rules('subcategory_id', 'subcategory_id', 'required|xss_clean|trim');
            // $this->form_validation->set_rules('minorcategory_id', 'minorcategory_id', 'required|xss_clean|trim');
            if ($this->form_validation->run() == true) {
                // $category_id=$this->input->post('category_id');
                $subcategory_id = $this->input->post('subcategory_id');
                // $minorcategory_id=$this->input->post('minorcategory_id');
                $this->db->select('*');
                $this->db->from('tbl_products');
                // $this->db->where('category_id',$category_id);
                $this->db->where('subcategory_id', $subcategory_id);
                // $this->db->where('minorcategory_id',$minorcategory_id);
                $this->db->where('is_active', 1);
                $product_data = $this->db->get();
                $this->db->select('*');
                $this->db->from('tbl_subcategory');
                $this->db->where('id', $subcategory_id);
                $get_subcategory_data = $this->db->get()->row();
                if (!empty($get_subcategory_data)) {
                    $subcategory_name = $get_subcategory_data->subcategory;
                }
                $product = [];
                foreach ($product_data->result() as $data) {
                    $product[] = array(
                        'product_id' => $data->id,
                        'product_name' => $data->productname,
                        'description' => $data->productdescription,
                        'mrp' => $data->mrp,
                        'price' => $data->sellingprice,
                        'image' => base_url() . $data->image,
                        'max' => $data->max,
                        't2_price' => $data->t2_price,
                        't2_min' => $data->t2_min,
                        't2_max' => $data->t2_max,
                    );
                }
                header('Access-Control-Allow-Origin: *');
                $res = array(
                    'message' => "success",
                    'status' => 200,
                    'data' => $product,
                    'subcategory_name' => $subcategory_name
                );
                echo json_encode($res);
            }
        }
    }
    //---------------------
    // ========= Get Product Details =========================
    public function get_productdetails($id, $phone = "", $authentication = '')
    {
        $T2 = 0;
        if (!empty($phone)) {
            $this->db->select('*');
            $this->db->from('tbl_users');
            $this->db->where('phone', $phone);
            $check_email = $this->db->get();
            $check_id = $check_email->row();
            if (!empty($check_id)) {
                if ($check_id->authentication == $authentication) {
                    if ($check_id->type == "T2") {
                        $T2 = 1;
                    }
                }
            }
        }
        $this->db->select('*');
        $this->db->from('tbl_products');
        $this->db->where('id', $id);
        $this->db->where('is_active', 1);
        $productsdata = $this->db->get()->row();
        $show = 1;
        if (!empty($productsdata->brand) && $T2 == 1 && $productsdata->brand != 0) {
            $check = $this->db->get_where('tbl_brands', array('is_active' => 1, 'for_t2' => 1, 'id' => $productsdata->brand))->result();
            if (empty($check)) {
                $show = 0;
            }
        }
        if ($show == 0) {
            header('Access-Control-Allow-Origin: *');
            $res = array(
                'message' => "success",
                'status' => 200,
                'data' => []
            );
            echo json_encode($res);
            die();
        }
        if (!empty($productsdata)) {
            $this->db->select('*');
            $this->db->from('tbl_inventory');
            $this->db->where('product_id', $productsdata->id);
            $inventory_data = $this->db->get()->row();
            if (!empty($inventory_data)) {
                if ($inventory_data->quantity > 0) {
                    $stock = 1;
                } else {
                    $stock = 0;
                }
            } else {
                $stock = 0;
            }
            if (!empty($productsdata->video1)) {
                $video1 = base_url() . $productsdata->video1;
            } else {
                $video1 = "";
            }
            if (!empty($productsdata->video2)) {
                $video2 = base_url() . $productsdata->video2;
            } else {
                $video2 = "";
            }
            $products[] = array(
                'id' => $productsdata->id,
                'productname' => $productsdata->productname,
                'productimage1' => base_url() . $productsdata->image,
                'productimage2' => base_url() . $productsdata->image1,
                'productvideo1' => $video1,
                'productvideo2' => $video2,
                'mrp' => $productsdata->mrp,
                'price' => $productsdata->sellingprice,
                'productdescription' => $productsdata->productdescription,
                'modelno' => $productsdata->modelno,
                'stock' => $stock,
                'max' => $productsdata->max,
                't2_price' => $productsdata->t2_price,
                't2_min' => $productsdata->t2_min,
                't2_max' => $productsdata->t2_max,
            );
            header('Access-Control-Allow-Origin: *');
            $res = array(
                'message' => "success",
                'status' => 200,
                'data' => $products
            );
            echo json_encode($res);
        } else {
            header('Access-Control-Allow-Origin: *');
            $res = array(
                'message' => "not valid",
                'status' => 201,
            );
            echo json_encode($res);
        }
    }
    //get all category
    public function get_allcategory()
    {
        $this->db->select('*');
        $this->db->from('tbl_category');
        $this->db->where('is_active', 1);
        $categorydata = $this->db->get();
        $category = [];
        foreach ($categorydata->result() as $data) {
            $c_id = $data->id;
            $this->db->select('*');
            $this->db->from('tbl_subcategory');
            $this->db->where('category_id', $data->id);
            $this->db->where('is_active', 1);
            $sub = $this->db->get();
            $subcategory = [];
            foreach ($sub->result() as $data2) {
                $this->db->select('*');
                $this->db->from('tbl_minorcategory');
                $this->db->where('category_id', $c_id);
                $this->db->where('subcategory_id', $data2->id);
                $this->db->where('is_active', 1);
                $minor_category = $this->db->get();
                $minorcategory = [];
                foreach ($minor_category->result() as $m_id) {
                    $minorcategory[] = array(
                        'minor_id' => $m_id->id,
                        'minor_name' => $m_id->minorcategoryname
                    );
                }
                $subcategory[] = array(
                    'sub_id' => $data2->id,
                    'name' => $data2->subcategory,
                    'minor_category' => $minorcategory
                );
            }
            // $catt=array('name'=> $data->categoryname,'sub_name'=>$subcategory);
            $cat[] = array(
                'id' => $data->id,
                'name' => $data->category,
                'sub_category' => $subcategory
            );
        }
        header('Access-Control-Allow-Origin: *');
        $res = array(
            'message' => "success",
            'status' => 200,
            'data' => $cat,
        );
        echo json_encode($res);
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
    public function surveillance()
    {
        $this->db->select('*');
        $this->db->from('tbl_surveillance');
        $surveillance_data = $this->db->get();
        $surveillance = [];
        foreach ($surveillance_data->result() as $data) {
            $surveillance[] = array(
                'description' => $data->description,
                'image' => base_url() . $data->image,
                // 'image2'=> base_url().$data->Image2
            );
        }
        header('Access-Control-Allow-Origin: *');
        $res = array(
            'message' => "success",
            'status' => 200,
            'data' => $surveillance
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
    public function add_to_cart()
    {
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->helper('security');
        if ($this->input->post()) {
            $this->form_validation->set_rules('product_id', 'product_id', 'required|trim');
            $this->form_validation->set_rules('quantity', 'quantity', 'required|trim');
            $this->form_validation->set_rules('phone', 'phone', 'trim');
            $this->form_validation->set_rules('authentication', 'authentication', 'trim');
            $this->form_validation->set_rules('token_id', 'token_id', 'required|trim');
            if ($this->form_validation->run() == true) {
                $product_id = $this->input->post('product_id');
                $quantity = $this->input->post('quantity');
                $phone = $this->input->post('phone');
                $authentication = $this->input->post('authentication');
                $token_id = $this->input->post('token_id');
                // --------------add to cart using email------------
                if (!empty($phone)) {
                    $this->db->select('*');
                    $this->db->from('tbl_users');
                    $this->db->where('phone', $phone);
                    $check_email = $this->db->get();
                    $check_id = $check_email->row();
                    if (!empty($check_id)) {
                        if ($check_id->authentication == $authentication) {
                            $this->db->select('*');
                            $this->db->from('tbl_cart');
                            $this->db->where('user_id', $check_id->id);
                            $this->db->where('product_id', $product_id);
                            $check_cart = $this->db->get();
                            $cart = $check_cart->row();
                            if (empty($cart)) {
                                $ip = $this->input->ip_address();
                                date_default_timezone_set("Asia/Calcutta");
                                $cur_date = date("Y-m-d H:i:s");
                                //----check product_id in product table-------
                                $this->db->select('*');
                                $this->db->from('tbl_products');
                                $this->db->where('id', $product_id);
                                $check_product = $this->db->get();
                                $check_product_id = $check_product->row();
                                if (!empty($check_product_id)) {
                                    $this->db->select('*');
                                    $this->db->from('tbl_inventory');
                                    $this->db->where('product_id', $product_id);
                                    $check_inventory = $this->db->get();
                                    $check_inventory_id = $check_inventory->row();
                                    if ($check_inventory_id->quantity >= $quantity) {
                                    } else {
                                        header('Access-Control-Allow-Origin: *');
                                        // $res = array('message'=> "$check_product_id->productname Product is out of stock",
                                        $res = array(
                                            'message' => "Product is out of stock",
                                            'status' => 201
                                        );
                                        echo json_encode($res);
                                        exit;
                                    }
                                    if ($check_id->type == "T3") {
                                        if ($check_product_id->max >= $quantity) {
                                        } else {
                                            header('Access-Control-Allow-Origin: *');
                                            $res = array(
                                                'message' => "Maximum purchase limit exceeded",
                                                'status' => 201
                                            );
                                            echo json_encode($res);
                                            exit;
                                        }
                                    } else {
                                        if ($check_product_id->t2_min <= $quantity) {
                                        } else {
                                            header('Access-Control-Allow-Origin: *');
                                            $res = array(
                                                'message' => "Minimum purchase quantity is " . $check_product_id->t2_min,
                                                'status' => 201
                                            );
                                            echo json_encode($res);
                                            exit;
                                        }
                                        if ($check_product_id->t2_max >= $quantity) {
                                        } else {
                                            header('Access-Control-Allow-Origin: *');
                                            $res = array(
                                                'message' => "Maximum purchase limit exceeded",
                                                'status' => 201
                                            );
                                            echo json_encode($res);
                                            exit;
                                        }
                                    }
                                    $data_insert = array(
                                        'product_id' => $product_id,
                                        'quantity' => $quantity,
                                        'user_id' => $check_id->id,
                                        'token_id' => $token_id,
                                        'ip' => $ip,
                                        'date' => $cur_date
                                    );
                                    $last_id = $this->base_model->insert_table("tbl_cart", $data_insert, 1);
                                    if (!empty($last_id)) {
                                        header('Access-Control-Allow-Origin: *');
                                        $res = array(
                                            'message' => 'success',
                                            'status' => 200
                                        );
                                        echo json_encode($res);
                                    } else {
                                        header('Access-Control-Allow-Origin: *');
                                        $res = array(
                                            'message' => 'Some error occurred',
                                            'status' => 201
                                        );
                                        echo json_encode($res);
                                    }
                                } else {
                                    header('Access-Control-Allow-Origin: *');
                                    $res = array(
                                        'message' => 'product_id is not exist',
                                        'status' => 201
                                    );
                                    echo json_encode($res);
                                }
                            } else {
                                header('Access-Control-Allow-Origin: *');
                                $res = array(
                                    'message' => 'Product is already in your cart',
                                    'status' => 201
                                );
                                echo json_encode($res);
                            }
                        } else {
                            header('Access-Control-Allow-Origin: *');
                            $res = array(
                                'message' => 'Authentication not exist',
                                'status' => 201
                            );
                            echo json_encode($res);
                        }
                    } else {
                        header('Access-Control-Allow-Origin: *');
                        $res = array(
                            'message' => 'email not exist ',
                            'status' => 201
                        );
                        echo json_encode($res);
                    }
                } else {
                    $this->db->select('*');
                    $this->db->from('tbl_cart');
                    $this->db->where('token_id', $token_id);
                    $this->db->where('product_id', $product_id);
                    $check_cart = $this->db->get();
                    $cart = $check_cart->row();
                    if (empty($cart)) {
                        $ip = $this->input->ip_address();
                        date_default_timezone_set("Asia/Calcutta");
                        $cur_date = date("Y-m-d H:i:s");
                        //----check product_id in product table-------
                        $this->db->select('*');
                        $this->db->from('tbl_products');
                        $this->db->where('id', $product_id);
                        $check_product = $this->db->get();
                        $check_product_id = $check_product->row();
                        if (!empty($check_product_id)) {
                            $this->db->select('*');
                            $this->db->from('tbl_inventory');
                            $this->db->where('product_id', $product_id);
                            $check_inventory = $this->db->get();
                            $check_inventory_id = $check_inventory->row();
                            if ($check_inventory_id->quantity >= $quantity) {
                            } else {
                                header('Access-Control-Allow-Origin: *');
                                // $res = array('message'=> "$check_product_id->productname Product is out of stock",
                                $res = array(
                                    'message' => "Product is out of stock",
                                    'status' => 201
                                );
                                echo json_encode($res);
                                exit;
                            }
                            $data_insert = array(
                                'product_id' => $product_id,
                                'quantity' => $quantity,
                                'token_id' => $token_id,
                                'ip' => $ip,
                                'date' => $cur_date
                            );
                            $last_id = $this->base_model->insert_table("tbl_cart", $data_insert, 1);
                            if (!empty($last_id)) {
                                header('Access-Control-Allow-Origin: *');
                                $res = array(
                                    'message' => 'success',
                                    'status' => 200
                                );
                                echo json_encode($res);
                            } else {
                                header('Access-Control-Allow-Origin: *');
                                $res = array(
                                    'message' => 'Some error occurred',
                                    'status' => 201
                                );
                                echo json_encode($res);
                            }
                        } else {
                            header('Access-Control-Allow-Origin: *');
                            $res = array(
                                'message' => 'Product does not exist.',
                                'status' => 201
                            );
                            echo json_encode($res);
                        }
                    } else {
                        header('Access-Control-Allow-Origin: *');
                        $res = array(
                            'message' => 'Product is already in your cart',
                            'status' => 201
                        );
                        echo json_encode($res);
                    }
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
                'message' => "Insert data, No data Available",
                'status' => 201
            );
            echo json_encode($res);
        }
    }
    // =========== Move to Cart from wishlist Api ===================
    public function move_to_cart()
    {
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->helper('security');
        if ($this->input->post()) {
            $this->form_validation->set_rules('product_id', 'product_id', 'required|trim');
            $this->form_validation->set_rules('quantity', 'quantity', 'trim');
            $this->form_validation->set_rules('phone', 'phone', 'trim');
            $this->form_validation->set_rules('authentication', 'authentication', 'trim');
            $this->form_validation->set_rules('token_id', 'token_id', 'required|trim');
            if ($this->form_validation->run() == true) {
                $product_id = $this->input->post('product_id');
                $quantity = 1;
                $phone = $this->input->post('phone');
                $authentication = $this->input->post('authentication');
                $token_id = $this->input->post('token_id');
                // --------------add to cart using email------------
                if (!empty($phone)) {
                    $this->db->select('*');
                    $this->db->from('tbl_users');
                    $this->db->where('phone', $phone);
                    $check_email = $this->db->get();
                    $check_id = $check_email->row();
                    if (!empty($check_id)) {
                        if ($check_id->authentication == $authentication) {
                            $this->db->select('*');
                            $this->db->from('tbl_cart');
                            $this->db->where('user_id', $check_id->id);
                            $this->db->where('product_id', $product_id);
                            $check_cart = $this->db->get();
                            $cart = $check_cart->row();
                            if (empty($cart)) {
                                $ip = $this->input->ip_address();
                                date_default_timezone_set("Asia/Calcutta");
                                $cur_date = date("Y-m-d H:i:s");
                                //----check product_id in product table-------
                                $this->db->select('*');
                                $this->db->from('tbl_products');
                                $this->db->where('id', $product_id);
                                $check_product = $this->db->get();
                                $check_product_id = $check_product->row();
                                if (!empty($check_product_id)) {
                                    $this->db->select('*');
                                    $this->db->from('tbl_inventory');
                                    $this->db->where('product_id', $product_id);
                                    $check_inventory = $this->db->get();
                                    $check_inventory_id = $check_inventory->row();
                                    if ($check_inventory_id->quantity >= $quantity) {
                                    } else {
                                        header('Access-Control-Allow-Origin: *');
                                        $res = array(
                                            'message' => "$check_product_id->productname Product is out of stock",
                                            'status' => 201
                                        );
                                        echo json_encode($res);
                                        exit;
                                    }
                                    if ($check_product_id->max >= $quantity) {
                                    } else {
                                        header('Access-Control-Allow-Origin: *');
                                        $res = array(
                                            'message' => "Maximum purchase limit exceeded",
                                            'status' => 201
                                        );
                                        echo json_encode($res);
                                        exit;
                                    }
                                    $data_insert = array(
                                        'product_id' => $product_id,
                                        'quantity' => $quantity,
                                        'user_id' => $check_id->id,
                                        'token_id' => $token_id,
                                        'ip' => $ip,
                                        'date' => $cur_date
                                    );
                                    $last_id = $this->base_model->insert_table("tbl_cart", $data_insert, 1);
                                    $zapak = $this->db->delete('tbl_wishlist', array('user_id' => $check_id->id, 'product_id' => $product_id));
                                    if (!empty($last_id)) {
                                        header('Access-Control-Allow-Origin: *');
                                        $res = array(
                                            'message' => 'success',
                                            'status' => 200
                                        );
                                        echo json_encode($res);
                                    } else {
                                        header('Access-Control-Allow-Origin: *');
                                        $res = array(
                                            'message' => 'Some error occurred',
                                            'status' => 201
                                        );
                                        echo json_encode($res);
                                    }
                                } else {
                                    header('Access-Control-Allow-Origin: *');
                                    $res = array(
                                        'message' => 'product_id is not exist',
                                        'status' => 201
                                    );
                                    echo json_encode($res);
                                }
                            } else {
                                header('Access-Control-Allow-Origin: *');
                                $res = array(
                                    'message' => 'Product is already in your cart',
                                    'status' => 201
                                );
                                echo json_encode($res);
                            }
                        } else {
                            header('Access-Control-Allow-Origin: *');
                            $res = array(
                                'message' => 'Authentication not exist',
                                'status' => 201
                            );
                            echo json_encode($res);
                        }
                    } else {
                        header('Access-Control-Allow-Origin: *');
                        $res = array(
                            'message' => 'email not exist ',
                            'status' => 201
                        );
                        echo json_encode($res);
                    }
                } else {
                    $this->db->select('*');
                    $this->db->from('tbl_cart');
                    $this->db->where('token_id', $token_id);
                    $this->db->where('product_id', $product_id);
                    $check_cart = $this->db->get();
                    $cart = $check_cart->row();
                    if (empty($cart)) {
                        $ip = $this->input->ip_address();
                        date_default_timezone_set("Asia/Calcutta");
                        $cur_date = date("Y-m-d H:i:s");
                        //----check product_id in product table-------
                        $this->db->select('*');
                        $this->db->from('tbl_products');
                        $this->db->where('id', $product_id);
                        $check_product = $this->db->get();
                        $check_product_id = $check_product->row();
                        if (!empty($check_product_id)) {
                            $this->db->select('*');
                            $this->db->from('tbl_inventory');
                            $this->db->where('product_id', $product_id);
                            $check_inventory = $this->db->get();
                            $check_inventory_id = $check_inventory->row();
                            if ($check_inventory_id->quantity >= $quantity) {
                            } else {
                                header('Access-Control-Allow-Origin: *');
                                $res = array(
                                    'message' => "$check_product_id->productname Product is out of stock",
                                    'status' => 201
                                );
                                echo json_encode($res);
                                exit;
                            }
                            $data_insert = array(
                                'product_id' => $product_id,
                                'quantity' => $quantity,
                                'token_id' => $token_id,
                                'ip' => $ip,
                                'date' => $cur_date
                            );
                            $last_id = $this->base_model->insert_table("tbl_cart", $data_insert, 1);
                            if (!empty($last_id)) {
                                header('Access-Control-Allow-Origin: *');
                                $res = array(
                                    'message' => 'success',
                                    'status' => 200
                                );
                                echo json_encode($res);
                            } else {
                                header('Access-Control-Allow-Origin: *');
                                $res = array(
                                    'message' => 'Some error occurred',
                                    'status' => 201
                                );
                                echo json_encode($res);
                            }
                        } else {
                            header('Access-Control-Allow-Origin: *');
                            $res = array(
                                'message' => 'Product does not exist.',
                                'status' => 201
                            );
                            echo json_encode($res);
                        }
                    } else {
                        header('Access-Control-Allow-Origin: *');
                        $res = array(
                            'message' => 'Product is already in your cart',
                            'status' => 201
                        );
                        echo json_encode($res);
                    }
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
                'message' => "Insert data, No data Available",
                'status' => 201
            );
            echo json_encode($res);
        }
    }
    // =============view cart data ============
    public function view_cart_data()
    {
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->helper('security');
        if ($this->input->post()) {
            $this->form_validation->set_rules('phone', 'phone', 'xss_clean|trim');
            $this->form_validation->set_rules('authentication', 'authentication', 'xss_clean|trim');
            $this->form_validation->set_rules('token_id', 'token_id', 'required|xss_clean|trim');
            if ($this->form_validation->run() == true) {
                $phone = $this->input->post('phone');
                $authentication = $this->input->post('authentication');
                $token_id = $this->input->post('token_id');
                //-------add to cart with email----------
                if (!empty($phone)) {
                    $this->db->select('*');
                    $this->db->from('tbl_users');
                    $this->db->where('phone', $phone);
                    $dsa = $this->db->get();
                    $user_data = $dsa->row();
                    if (!empty($user_data)) {
                        if ($user_data->authentication == $authentication) {
                            $this->db->select('*');
                            $this->db->from('tbl_cart');
                            $this->db->where('user_id', $user_data->id);
                            $cart_data = $this->db->get();
                            $cart_check = $cart_data->row();
                            if (!empty($cart_check)) {
                                $total = 0;
                                $sub_total = 0;
                                $cart_info = [];
                                foreach ($cart_data->result() as $data) {
                                    $this->db->select('*');
                                    $this->db->from('tbl_products');
                                    $this->db->where('id', $data->product_id);
                                    $dsa = $this->db->get();
                                    $product_data = $dsa->row();
                                    if ($user_data->type == "T3") {
                                        $total = $product_data->sellingprice * $data->quantity;
                                    } else {
                                        $total = $product_data->t2_price * $data->quantity;
                                    }
                                    $cart_info[] = array(
                                        'product_id' => $data->product_id,
                                        'product_name' => $product_data->productname,
                                        'product_image' => base_url() . $product_data->image,
                                        'quantity' => $data->quantity,
                                        'price' => $product_data->sellingprice,
                                        'total=' => $total,
                                        'max' => $product_data->max,
                                        't2_price' => $product_data->t2_price,
                                        't2_min' => $product_data->t2_min,
                                        't2_max' => $product_data->t2_max,
                                    );
                                    $sub_total = $sub_total + $total;
                                }
                                header('Access-Control-Allow-Origin: *');
                                $res = array(
                                    'message' => 'success',
                                    'status' => 200,
                                    'data' => $cart_info,
                                    'subtotal' => $sub_total
                                );
                                echo json_encode($res);
                            } else {
                                header('Access-Control-Allow-Origin: *');
                                $res = array(
                                    'message' => 'Your cart is empty',
                                    'status' => 201
                                );
                                echo json_encode($res);
                            }
                        } else {
                            header('Access-Control-Allow-Origin: *');
                            $res = array(
                                'message' => 'Passwod does not match',
                                'status' => 201
                            );
                            echo json_encode($res);
                        }
                    } else {
                        header('Access-Control-Allow-Origin: *');
                        $res = array(
                            'message' => 'Phone does not exist',
                            'status' => 201
                        );
                        echo json_encode($res);
                    }
                } else {
                    $this->db->select('*');
                    $this->db->from('tbl_cart');
                    $this->db->where('token_id', $token_id);
                    $cart_data = $this->db->get();
                    $cart_check = $cart_data->row();
                    // print_r($cart_check);
                    // exit;
                    if (!empty($cart_check)) {
                        $total = 0;
                        $sub_total = 0;
                        $cart_info = [];
                        foreach ($cart_data->result() as $data) {
                            $this->db->select('*');
                            $this->db->from('tbl_products');
                            $this->db->where('id', $data->product_id);
                            $dsa = $this->db->get();
                            $product_data = $dsa->row();
                            $cart_info[] = array(
                                'product_id' => $data->product_id,
                                'product_name' => $product_data->productname,
                                'product_image' => base_url() . $product_data->image,
                                'quantity' => $data->quantity,
                                'price' => $product_data->sellingprice,
                                'total=' => $total = $product_data->sellingprice * $data->quantity,
                                'max' => $product_data->max,
                                't2_price' => $product_data->t2_price,
                                't2_min' => $product_data->t2_min,
                                't2_max' => $product_data->t2_max,
                            );
                            $sub_total = $sub_total + $total;
                        }
                        header('Access-Control-Allow-Origin: *');
                        $res = array(
                            'message' => 'success',
                            'status' => 200,
                            'data' => $cart_info,
                            'subtotal' => $sub_total
                        );
                        echo json_encode($res);
                    } else {
                        header('Access-Control-Allow-Origin: *');
                        $res = array(
                            'message' => 'Your cart is empty',
                            'status' => 201
                        );
                        echo json_encode($res);
                    }
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
    //------update product cart-----
    public function update_cart()
    {
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->helper('security');
        if ($this->input->post()) {
            // print_r($this->input->post());
            // exit;
            $this->form_validation->set_rules('product_id', 'product_id', 'required|xss_clean|trim');
            $this->form_validation->set_rules('quantity', 'quantity', 'required|xss_clean|trim');
            $this->form_validation->set_rules('phone', 'phone', 'xss_clean|trim');
            $this->form_validation->set_rules('authentication', 'authentication', 'xss_clean|trim');
            $this->form_validation->set_rules('token_id', 'token_id', 'required|xss_clean|trim');
            if ($this->form_validation->run() == true) {
                $product_id = $this->input->post('product_id');
                $quantity = $this->input->post('quantity');
                $phone = $this->input->post('phone');
                $authentication = $this->input->post('authentication');
                $token_id = $this->input->post('token_id');
                //-------update with email----------
                if (!empty($phone)) {
                    $this->db->select('*');
                    $this->db->from('tbl_users');
                    $this->db->where('phone', $phone);
                    $dsa = $this->db->get();
                    $user_data = $dsa->row();
                    if (!empty($user_data)) {
                        if ($user_data->authentication == $authentication) {
                            $this->db->select('*');
                            $this->db->from('tbl_inventory');
                            $this->db->where('product_id', $product_id);
                            $inventory_data = $this->db->get()->row();
                            // echo $inventory_data->quantity;
                            // exit;
                            //----inventory_check----------
                            if ($inventory_data->quantity >= $quantity) {
                            } else {
                                header('Access-Control-Allow-Origin: *');
                                $res = array(
                                    'message' => " Product is out of stock",
                                    'status' => 201
                                );
                                echo json_encode($res);
                                exit;
                            }
                            $data_insert = array(
                                'product_id' => $product_id,
                                'quantity' => $quantity
                            );
                            $this->db->where(array('user_id' =>  $user_data->id, 'product_id' => $product_id));
                            $last_id = $this->db->update('tbl_cart', $data_insert);
                            if (!empty($last_id)) {
                                header('Access-Control-Allow-Origin: *');
                                $res = array(
                                    'message' => 'success',
                                    'status' => 200
                                );
                                echo json_encode($res);
                            } else {
                                header('Access-Control-Allow-Origin: *');
                                $res = array(
                                    'message' => 'Some error occurred',
                                    'status' => 201
                                );
                                echo json_encode($res);
                            }
                        } else {
                            header('Access-Control-Allow-Origin: *');
                            $res = array(
                                'message' => 'Authentication does not match',
                                'status' => 201
                            );
                            echo json_encode($res);
                        }
                    } else {
                        header('Access-Control-Allow-Origin: *');
                        $res = array(
                            'message' => 'Phone does not exist',
                            'status' => 201
                        );
                        echo json_encode($res);
                    }
                }
                //-----update with token id------
                else {
                    $this->db->select('*');
                    $this->db->from('tbl_inventory');
                    $this->db->where('product_id', $product_id);
                    $inventory_data = $this->db->get()->row();
                    // echo $inventory_data->quantity;
                    // exit;
                    //----inventory_check----------
                    if ($inventory_data->quantity >= $quantity) {
                    } else {
                        header('Access-Control-Allow-Origin: *');
                        $res = array(
                            'message' => "Product is out of stock",
                            'status' => 201
                        );
                        echo json_encode($res);
                        exit;
                    }
                    $data_insert = array(
                        'product_id' => $product_id,
                        'quantity' => $quantity
                    );
                    $this->db->where(array('token_id' => $token_id, 'product_id' => $product_id));
                    $last_id = $this->db->update('tbl_cart', $data_insert);
                    if (!empty($last_id)) {
                        header('Access-Control-Allow-Origin: *');
                        $res = array(
                            'message' => 'success',
                            'status' => 200
                        );
                        echo json_encode($res);
                    } else {
                        header('Access-Control-Allow-Origin: *');
                        $res = array(
                            'message' => 'Some error occurred',
                            'status' => 201
                        );
                        echo json_encode($res);
                    }
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
                'message' => "please insert data",
                'status' => 201
            );
            echo json_encode($res);
        }
    }
    // ========== cart count==============
    public function cart_count()
    {
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->helper('security');
        if ($this->input->post()) {
            $this->form_validation->set_rules('token_id', 'token_id', 'xss_clean|trim');
            $this->form_validation->set_rules('phone', 'phone', 'xss_clean|trim');
            $this->form_validation->set_rules('authentication', 'authentication', 'xss_clean|trim');
            if ($this->form_validation->run() == true) {
                $token_id = $this->input->post('token_id');
                $phone = $this->input->post('phone');
                $authentication = $this->input->post('authentication');
                //-----cart count check with phone
                if (!empty($phone)) {
                    $this->db->select('*');
                    $this->db->from('tbl_users');
                    $this->db->where('phone', $phone);
                    $user_data = $this->db->get()->row();
                    if (!empty($user_data)) {
                        if ($user_data->authentication == $authentication) {
                            $this->db->select('*');
                            $this->db->from('tbl_cart');
                            $this->db->where('user_id', $user_data->id);
                            $count = $this->db->count_all_results();
                            $this->db->select('*');
                            $this->db->from('tbl_wishlist');
                            $this->db->where('user_id', $user_data->id);
                            $wishlist_count = $this->db->count_all_results();
                            if (empty($count)) {
                                $count = 0;
                            }
                            header('Access-Control-Allow-Origin: *');
                            $res = array(
                                'message' => "success",
                                'status' => 200,
                                'data' => $count,
                                'wishlist_count' => $wishlist_count
                            );
                            echo json_encode($res);
                        } else {
                            header('Access-Control-Allow-Origin: *');
                            $res = array(
                                'message' => "Wrong  Authentication",
                                'status' => 201
                            );
                            echo json_encode($res);
                        }
                    }
                }
                //----cart check with token_id
                else {
                    $this->db->select('*');
                    $this->db->from('tbl_cart');
                    $this->db->where('token_id', $token_id);
                    $count = $this->db->count_all_results();
                    if (empty($count)) {
                        $count = 0;
                    }
                    header('Access-Control-Allow-Origin: *');
                    $res = array(
                        'message' => "success",
                        'status' => 200,
                        'data' => $count
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
                'message' => 'No data available',
                'status' => 201
            );
            echo json_encode($res);
        }
    }
    //------delete product cart-----
    public function delete_cart_data()
    {
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->helper('security');
        if ($this->input->post()) {
            // print_r($this->input->post());
            // exit;
            $this->form_validation->set_rules('product_id', 'product_id', 'required|xss_clean|trim');
            $this->form_validation->set_rules('phone', 'phone', 'xss_clean|trim');
            $this->form_validation->set_rules('authentication', 'authentication', 'xss_clean|trim');
            $this->form_validation->set_rules('token_id', 'token_id', 'required|xss_clean|trim');
            if ($this->form_validation->run() == true) {
                $product_id = $this->input->post('product_id');
                $phone = $this->input->post('phone');
                $authentication = $this->input->post('authentication');
                $token_id = $this->input->post('token_id');
                //-------delete with email----------
                if (!empty($phone)) {
                    $this->db->select('*');
                    $this->db->from('tbl_users');
                    $this->db->where('phone', $phone);
                    $dsa = $this->db->get();
                    $user_data = $dsa->row();
                    if (!empty($user_data)) {
                        if ($user_data->authentication == $authentication) {
                            //             $this->db->select('*');
                            // $this->db->from('tbl_cart');
                            // $this->db->where('user_id',$user_data->id);
                            // $this->db->where('$product_id',$product_id);
                            // $this->db->where('$type_id',$type_id);
                            // $cart_data= $this->db->get()->row();
                            $zapak = $this->db->delete('tbl_cart', array('user_id' => $user_data->id, 'product_id' => $product_id));
                            // echo $zapak;
                            // exit;
                            if (!empty($zapak)) {
                                header('Access-Control-Allow-Origin: *');
                                $res = array(
                                    'message' => 'success',
                                    'status' => 200
                                );
                                echo json_encode($res);
                            } else {
                                header('Access-Control-Allow-Origin: *');
                                $res = array(
                                    'message' => 'Some error occurred',
                                    'status' => 201
                                );
                                echo json_encode($res);
                            }
                        } else {
                            header('Access-Control-Allow-Origin: *');
                            $res = array(
                                'message' => 'Passwod does not match',
                                'status' => 201
                            );
                            echo json_encode($res);
                        }
                    } else {
                        header('Access-Control-Allow-Origin: *');
                        $res = array(
                            'message' => 'Email is not exist',
                            'status' => 201
                        );
                        echo json_encode($res);
                    }
                }
                //-----delete with token id------
                else {
                    $zapak = $this->db->delete('tbl_cart', array('token_id' => $token_id, 'product_id' => $product_id));
                    if (!empty($zapak)) {
                        header('Access-Control-Allow-Origin: *');
                        $res = array(
                            'message' => 'success',
                            'status' => 200
                        );
                        echo json_encode($res);
                    } else {
                        header('Access-Control-Allow-Origin: *');
                        $res = array(
                            'message' => 'Some error occurred',
                            'status' => 201
                        );
                        echo json_encode($res);
                    }
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
                'message' => "please insert data",
                'status' => 201
            );
            echo json_encode($res);
        }
    }
    //-----------------most-popular product--------------
    public function most_popular_products($phone = "", $authentication = '')
    {
        $T2 = 0;
        if (!empty($phone)) {
            $this->db->select('*');
            $this->db->from('tbl_users');
            $this->db->where('phone', $phone);
            $check_email = $this->db->get();
            $check_id = $check_email->row();
            if (!empty($check_id)) {
                if ($check_id->authentication == $authentication) {
                    if ($check_id->type == "T2") {
                        $T2 = 1;
                    }
                }
            }
        }
        $this->db->select('*');
        $this->db->from('tbl_products');
        $this->db->where('popular_product', 1);
        $this->db->where('is_active', 1);
        $productslimitdata = $this->db->get();
        $products = [];
        foreach ($productslimitdata->result() as $limit) {
            $show = 1;
            if (!empty($limit->brand) && $T2 == 1 && $limit->brand != 0) {
                $check = $this->db->get_where('tbl_brands', array('is_active' => 1, 'for_t2' => 1, 'id' => $limit->brand))->result();
                if (empty($check)) {
                    $show = 0;
                }
            }
            if ($show == 0) {
                continue;
            }
            $this->db->select('*');
            $this->db->from('tbl_category');
            $this->db->where('id', $limit->category_id);
            $this->db->where('is_active', 1);
            $cat_check = $this->db->get()->row();
            $this->db->from('tbl_subcategory');
            $this->db->where('is_active', 1);
            $this->db->where('id', $limit->subcategory_id);
            $subcat_check = $this->db->get()->row();
            $this->db->select('*');
            $this->db->from('tbl_minorcategory');
            $this->db->where('is_active', 1);
            $this->db->where('id', $limit->minorcategory_id);
            $minorcat_check = $this->db->get()->row();
            if (!empty($cat_check) && !empty($subcat_check) && !empty($minorcat_check)) {
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
                $this->db->select('*');
                $this->db->from('tbl_inventory');
                $this->db->where('product_id', $limit->id);
                $inventory_data = $this->db->get()->row();
                if (!empty($inventory_data)) {
                    if ($inventory_data->quantity > 0) {
                        $stock = 1;
                    } else {
                        $stock = 0;
                    }
                } else {
                    $stock = 0;
                }
                $products[] = array(
                    'product_id' => $limit->id,
                    'productname' => $limit->productname,
                    // 'category'=> $c1,
                    // 'sucategory'=> $s1,
                    // 'minorcategory'=>$m1,
                    'productimage' => base_url() . $limit->image,
                    // 'productimage1'=> base_url().$limit->image1,
                    // 'productimage2'=> base_url().$limit->video1,
                    // 'productimage3'=> base_url().$limit->video2,
                    'mrp' => $limit->mrp,
                    'price' => $limit->sellingprice,
                    'productdescription' => $limit->productdescription,
                    'max' => $limit->max,
                    't2_price' => $limit->t2_price,
                    't2_min' => $limit->t2_min,
                    't2_max' => $limit->t2_max,
                    'stock' => $stock,


                    // 'inventory'=> $data->inventory
                );
            }
        }
        header('Access-Control-Allow-Origin: *');
        $res = array(
            'message' => "success",
            'status' => 200,
            'data' => $products,
            'type' => $T2 == 1 ? 'T2' : 'T3',
        );
        echo json_encode($res);
    }
    //-----------------feature product--------------
    public function featured_products($phone = "", $authentication = '')
    {
        $T2 = 0;
        if (!empty($phone)) {
            $this->db->select('*');
            $this->db->from('tbl_users');
            $this->db->where('phone', $phone);
            $check_email = $this->db->get();
            $check_id = $check_email->row();
            if (!empty($check_id)) {
                if ($check_id->authentication == $authentication) {
                    if ($check_id->type == "T2") {
                        $T2 = 1;
                    }
                }
            }
        }
        $this->db->select('*');
        $this->db->from('tbl_products');
        $this->db->where('feature_product', 1);
        $this->db->where('is_active', 1);
        $productslimitdata = $this->db->get();
        $products = [];
        foreach ($productslimitdata->result() as $limit) {
            $show = 1;
            if (!empty($limit->brand) && $T2 == 1 && $limit->brand != 0) {
                $check = $this->db->get_where('tbl_brands', array('is_active' => 1, 'for_t2' => 1, 'id' => $limit->brand))->result();
                if (empty($check)) {
                    $show = 0;
                }
            }
            if ($show == 0) {
                continue;
            }
            $this->db->select('*');
            $this->db->from('tbl_category');
            $this->db->where('id', $limit->category_id);
            $this->db->where('is_active', 1);
            $cat_check = $this->db->get()->row();
            $this->db->from('tbl_subcategory');
            $this->db->where('is_active', 1);
            $this->db->where('id', $limit->subcategory_id);
            $subcat_check = $this->db->get()->row();
            $this->db->select('*');
            $this->db->from('tbl_minorcategory');
            $this->db->where('is_active', 1);
            $this->db->where('id', $limit->minorcategory_id);
            $minorcat_check = $this->db->get()->row();
            if (!empty($cat_check) && !empty($subcat_check) && !empty($minorcat_check)) {
                $this->db->select('*');
                $this->db->from('tbl_inventory');
                $this->db->where('product_id', $limit->id);
                $inventory_data = $this->db->get()->row();
                if (!empty($inventory_data)) {
                    if ($inventory_data->quantity > 0) {
                        $stock = 1;
                    } else {
                        $stock = 0;
                    }
                } else {
                    $stock = 0;
                }
                $products[] = array(
                    'product_id' => $limit->id,
                    'productname' => $limit->productname,
                    'productimage' => base_url() . $limit->image,
                    'mrp' => $limit->mrp,
                    'price' => $limit->sellingprice,
                    'productdescription' => $limit->productdescription,
                    'max' => $limit->max,
                    't2_price' => $limit->t2_price,
                    't2_min' => $limit->t2_min,
                    't2_max' => $limit->t2_max,
                    'stock' => $stock
                );
            }
        }
        header('Access-Control-Allow-Origin: *');
        $res = array(
            'message' => "success",
            'status' => 200,
            'data' => $products
        );
        echo json_encode($res);
    }
    //--------------------stock_get----------------
    public function stock_get()
    {
        $this->db->select('*');
        $this->db->from('tbl_stock');
        $this->db->where('is_active', 1);
        $data = $this->db->get();
        $stock = [];
        foreach ($data->result() as $value) {
            $stock[] = array(
                'image' => base_url() . $value->image1,
                'background_image' => base_url() . $value->image2,
                'name' => $value->stockname,
                'message' => $value->stockmessage
            );
        }
        header('Access-Control-Allow-Origin:*');
        $res = array(
            'message' => "success",
            'status' => 200,
            'data' => $stock
        );
        echo json_encode($res);
    }
    //-----------------------------MOST POPULAR BRANDS-------------
    public function brands_view()
    {
        $this->db->select('*');
        $this->db->from('tbl_brands');
        //$this->db->where('id',$id);
        $this->db->where('is_active', 1);
        $brands = $this->db->get();
        $brands_data = [];
        foreach ($brands->result() as $value) {
            $brands_data[] = array(
                'id' => $value->id,
                'name' => $value->name,
                'message' => $value->message,
                'image' => base_url() . $value->image
            );
        }
        header('Access-Control-Allow-Origin: *');
        $res = array(
            'message' => "success",
            'status' => 200,
            'data' => $brands_data
        );
        echo json_encode($res);
    }
    //-------------show minorcategory---------------------
    public function show_minorcategory()
    {
        $this->db->select('*');
        $this->db->from('tbl_minorcategory');
        $this->db->where('is_active', 1);
        $minor_category = $this->db->get();
        $minorcategory = [];
        foreach ($minor_category->result() as $value) {
            $minorcategory[] = array(
                'id' => $value->id,
                'minorcategory' => $value->minorcategoryname,
                'image' => base_url() . $value->image
            );
        }
        header('Access-Control-Allow-Origin: *');
        $res = array(
            'message' => "success",
            'status' => 200,
            'data' => $minorcategory
        );
        echo json_encode($res);
    }
    //-------------------related product------------
    public function related_products($id, $phone = "", $authentication = '')
    {
        $T2 = 0;
        if (!empty($phone)) {
            $this->db->select('*');
            $this->db->from('tbl_users');
            $this->db->where('phone', $phone);
            $check_email = $this->db->get();
            $check_id = $check_email->row();
            if (!empty($check_id)) {
                if ($check_id->authentication == $authentication) {
                    if ($check_id->type == "T2") {
                        $T2 = 1;
                    }
                }
            }
        }
        $this->db->select('*');
        $this->db->from('tbl_products');
        $this->db->where('id', $id);
        $product_data = $this->db->get()->row();
        if (empty($product_data)) {
            $res = array(
                'message' => "success",
                'status' => 200,
                'data' => []
            );
            echo json_encode($res);
            return;
        }
        $this->db->select('*');
        $this->db->from('tbl_products');
        $this->db->where('is_active', 1);
        $this->db->where('minorcategory_id', $product_data->minorcategory_id);
        $related_data = $this->db->get();
        $related_info = [];
        foreach ($related_data->result() as $data) {
            $show = 1;
            if (!empty($data->brand) && $T2 == 1 && $data->brand != 0) {
                $check = $this->db->get_where('tbl_brands', array('is_active' => 1, 'for_t2' => 1, 'id' => $data->brand))->result();
                if (empty($check)) {
                    $show = 0;
                }
            }
            if ($show == 0) {
                continue;
            }
            $this->db->select('*');
            $this->db->from('tbl_category');
            $this->db->where('id', $data->category_id);
            $this->db->where('is_active', 1);
            $cat_check = $this->db->get()->row();
            $this->db->from('tbl_subcategory');
            $this->db->where('is_active', 1);
            $this->db->where('id', $data->subcategory_id);
            $subcat_check = $this->db->get()->row();
            $this->db->select('*');
            $this->db->from('tbl_minorcategory');
            $this->db->where('is_active', 1);
            $this->db->where('id', $data->minorcategory_id);
            $minorcat_check = $this->db->get()->row();
            if (!empty($cat_check) && !empty($subcat_check) && !empty($minorcat_check)) {
                $this->db->select('*');
                $this->db->from('tbl_inventory');
                $this->db->where('product_id', $data->id);
                $inventory_data = $this->db->get()->row();
                if (!empty($inventory_data)) {
                    if ($inventory_data->quantity > 0) {
                        $stock = 1;
                    } else {
                        $stock = 0;
                    }
                } else {
                    $stock = 0;
                }
                if ($data->id != $id) {
                    $related_info[]  = array(
                        'product_id' => $data->id,
                        'productname' => $data->productname,
                        'productimage' => base_url() . $data->image,
                        'productdescription' => $data->productdescription,
                        'mrp' => $data->mrp,
                        'price' => $data->sellingprice,
                        'max' => $data->max,
                        't2_price' => $data->t2_price,
                        't2_min' => $data->t2_min,
                        't2_max' => $data->t2_max,
                        'stock' => $stock
                    );
                }
            }
        }
        header('Access-Control-Allow-Origin: *');
        $res = array(
            'message' => "success",
            'status' => 200,
            'data' => $related_info
        );
        echo json_encode($res);
        exit();
    }
    //------calculate------------
    public function calculate()
    {
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->helper('security');
        if ($this->input->post()) {
            $this->form_validation->set_rules('phone', 'phone', 'required|xss_clean|trim');
            $this->form_validation->set_rules('authentication', 'authentication', 'required|xss_clean|trim');
            $this->form_validation->set_rules('token_id', 'token_id', 'required|xss_clean|trim');
            if ($this->form_validation->run() == true) {
                $phone = $this->input->post('phone');
                $authentication = $this->input->post('authentication');
                $token_id = $this->input->post('token_id');
                $ip = $this->input->ip_address();
                date_default_timezone_set("Asia/Calcutta");
                $cur_date = date("Y-m-d H:i:s");
                $this->db->select('*');
                $this->db->from('tbl_users');
                $this->db->where('phone', $phone);
                $user_data = $this->db->get()->row();
                if (!empty($user_data)) {
                    if ($authentication == $user_data->authentication) {
                        $this->db->select('*');
                        $this->db->from('tbl_cart');
                        $this->db->where('user_id', $user_data->id);
                        $cart_data = $this->db->get();
                        $cart_check = $cart_data->row();
                        if (!empty($cart_check)) {
                            $total = 0;
                            $sub_total = 0;
                            $weight = 0;
                            $total_weight = 0;
                            foreach ($cart_data->result() as  $data) {
                                $this->db->select('*');
                                $this->db->from('tbl_products');
                                $this->db->where('id', $data->product_id);
                                $this->db->where('is_active', 1);
                                $product_data = $this->db->get()->row();
                                if (!empty($product_data)) {
                                    if ($user_data->type == 'T3') {
                                        if ($product_data->max >= $data->quantity) {
                                        } else {
                                            header('Access-Control-Allow-Origin: *');
                                            $res = array(
                                                'message' => "Maximum purchase limit exceeded",
                                                'status' => 201
                                            );
                                            echo json_encode($res);
                                            exit;
                                        }
                                        $total = $product_data->sellingprice * $data->quantity;
                                        $sub_total = $sub_total + $total;
                                    } else {
                                        if ($product_data->t2_min <= $data->quantity) {
                                        } else {
                                            header('Access-Control-Allow-Origin: *');
                                            $res = array(
                                                'message' => "Minimum purchase quantity is " . $product_data->t2_min,
                                                'status' => 201
                                            );
                                            echo json_encode($res);
                                            exit;
                                        }
                                        if ($product_data->t2_max >= $data->quantity) {
                                        } else {
                                            header('Access-Control-Allow-Origin: *');
                                            $res = array(
                                                'message' => "Maximum purchase limit exceeded",
                                                'status' => 201
                                            );
                                            echo json_encode($res);
                                            exit;
                                        }

                                        $total = $product_data->t2_price * $data->quantity;
                                        $sub_total = $sub_total + $total;
                                    }
                                    $weight = $product_data->weight * $data->quantity;
                                    $total_weight = $total_weight + $weight;
                                } else {
                                    header('Access-Control-Allow-Origin: *');
                                    $res = array(
                                        'message' => "product not found",
                                        'status' => 201,
                                    );
                                    echo json_encode($res);
                                }
                            } //end of foreach
                            $txn_id = bin2hex(random_bytes(10));
                            $order1_insert = array(
                                'user_id' => $user_data->id,
                                'total_amount' => $sub_total,
                                'weight' => $total_weight,
                                'payment_status' => 0,
                                'order_status' => 0,
                                'payment_status' => 0,
                                'type' => $user_data->type,
                                'txnid' => $txn_id,
                                'ip' => $ip,
                                'date' => $cur_date
                            );
                            $last_id = $this->base_model->insert_table("tbl_order1", $order1_insert, 1);
                            if (!empty($last_id)) {
                                $this->db->select('*');
                                $this->db->from('tbl_cart');
                                $this->db->where('user_id', $user_data->id);
                                $cart_data1 = $this->db->get();
                                $cart_check1 = $cart_data->row();
                                if (!empty($cart_check1)) {
                                    $total2 = 0;
                                    foreach ($cart_data1->result() as $data1) {
                                        $this->db->select('*');
                                        $this->db->from('tbl_inventory');
                                        $this->db->where('product_id', $data1->product_id);
                                        $inventory_data1 = $this->db->get()->row();
                                        if (!empty($inventory_data1)) {
                                            $this->db->select('*');
                                            $this->db->from('tbl_products');
                                            $this->db->where('id', $data1->product_id);
                                            $product_data1 = $this->db->get()->row();
                                            if (!empty($product_data1)) {
                                                if ($inventory_data1->quantity >= $data1->quantity) {
                                                    if ($user_data->type == 'T3') {
                                                        $total2 = $product_data1->sellingprice * $data1->quantity;
                                                    } else {
                                                        $total2 = $product_data1->t2_price * $data1->quantity;
                                                    }
                                                    $order2_insert = array(
                                                        'main_id' => $last_id,
                                                        'product_id' => $data1->product_id,
                                                        'quantity' => $data1->quantity,
                                                        'product_mrp' => $product_data1->mrp,
                                                        // 'gst'=>$product_data1->gst,
                                                        // 'gst_percentage'=>$product_data1->gst_percentage,
                                                        'total_amount' => $total2,
                                                        'ip' => $ip,
                                                        'date' => $cur_date
                                                    );
                                                    $last_id2 = $this->base_model->insert_table("tbl_order2", $order2_insert, 1);
                                                } else {
                                                    header('Access-Control-Allow-Origin: *');
                                                    $res = array(
                                                        'message' => "Product is out of stock! Please remove this " . $product_data1->productname,
                                                        'status' => 201,
                                                    );
                                                    echo json_encode($res);
                                                    exit;
                                                }
                                            } else {
                                                header('Access-Control-Allow-Origin: *');
                                                $res = array(
                                                    'message' => "Out of stock",
                                                    'status' => 201,
                                                );
                                                echo json_encode($res);
                                                exit;
                                            }
                                        } else {
                                            header('Access-Control-Allow-Origin: *');
                                            $res = array(
                                                'message' => "product Not found",
                                                'status' => 201,
                                            );
                                            echo json_encode($res);
                                            exit;
                                        }
                                    }
                                } //end of foreach
                                $this->db->select('*');
                                $this->db->from('tbl_order1');
                                $this->db->where('user_id', $user_data->id);
                                $this->db->where('payment_status', 1);
                                $this->db->order_by('id', "DESC");
                                $address_data = $this->db->get()->row();
                                $address = [];
                                if (!empty($address_data)) {
                                    $address = array(
                                        "name" => $address_data->name,
                                        "pincode" => $address_data->pincode,
                                        // "house_no"=>$address_data->house_no,
                                        "street_address" => $address_data->street_address,
                                        "city" => $address_data->city,
                                        "state" => $address_data->state,
                                        "phone" => $address_data->phone,
                                    );
                                }
                                header('Access-Control-Allow-Origin: *');
                                $res = array(
                                    'message' => "success",
                                    'status' => 200,
                                    'total' => $sub_total,
                                    'subtotal' => $sub_total,
                                    'txn_id' => $txn_id,
                                    'address' => $address
                                );
                                echo json_encode($res);
                            } else {
                                header('Access-Control-Allow-Origin: *');
                                $res = array(
                                    'message' => "some error occurred",
                                    'status' => 201,
                                );
                                echo json_encode($res);
                            }
                        } else {
                            header('Access-Control-Allow-Origin: *');
                            $res = array(
                                'message' => "Cart is empty",
                                'status' => 201,
                            );
                            echo json_encode($res);
                        }
                    } else {
                        header('Access-Control-Allow-Origin: *');
                        $res = array(
                            'message' => "Wrong Authentication",
                            'status' => 201,
                        );
                        echo json_encode($res);
                    }
                } else {
                    header('Access-Control-Allow-Origin: *');
                    $res = array(
                        'message' => "No user found",
                        'status' => 201,
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
                'message' => "please insert some data",
                'status' => 201
            );
            echo json_encode($res);
        }
    }
    //----promocode---
    public function apply_promocode()
    {
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->helper('security');
        if ($this->input->post()) {
            $this->form_validation->set_rules('phone', 'phone', 'required|xss_clean|trim');
            $this->form_validation->set_rules('authentication', 'authentication', 'required|xss_clean|trim');
            $this->form_validation->set_rules('token_id', 'token_id', 'required|xss_clean|trim');
            $this->form_validation->set_rules('txn_id', 'txn_id', 'required|xss_clean|trim');
            $this->form_validation->set_rules('promocode', 'promocode', 'required|xss_clean|trim');
            if ($this->form_validation->run() == true) {
                $phone = $this->input->post('phone');
                $authentication = $this->input->post('authentication');
                $token_id = $this->input->post('token_id');
                $txn_id = $this->input->post('txn_id');
                $promocode = $this->input->post('promocode');
                $this->db->select('*');
                $this->db->from('tbl_users');
                $this->db->where('phone', $phone);
                $user_data = $this->db->get()->row();
                if (!empty($user_data)) {
                    if ($user_data->authentication == $authentication) {
                        //--------check_promocode------
                        $discount = 0;
                        $promocode_id = 0;
                        $promocode = strtoupper($promocode);
                        // echo $promocode;
                        // exit;
                        $this->db->select('*');
                        $this->db->from('tbl_promocode');
                        $this->db->where('promocode', $promocode);
                        $this->db->where('is_active', 1);
                        $dsa = $this->db->get();
                        $promocode_data = $dsa->row();
                        if (!empty($promocode_data)) {
                            $this->db->select('*');
                            $this->db->from('tbl_order1');
                            $this->db->where('txnid', $txn_id);
                            $order_data = $this->db->get()->row();
                            $final_amount = 0;
                            $promocode_id = $promocode_data->id;
                            if ($promocode_data->ptype == 1) {
                                $this->db->select('*');
                                $this->db->from('tbl_order1');
                                $this->db->where('user_id', $user_data->id);
                                $this->db->where('promocode_id', $promocode_data->id);
                                $dsa = $this->db->get();
                                $promo_check = $dsa->row();
                                if (empty($promo_check)) {
                                    if ($order_data->total_amount > $promocode_data->minorder) { //----checking minorder for promocode
                                        // echo "hii";
                                        $discount_amt = $order_data->total_amount * $promocode_data->giftpercent / 100;
                                        if ($discount_amt > $promocode_data->max) {
                                            // will get max amount
                                            $discount =  $promocode_data->max;
                                        } else {
                                            $discount =  $discount_amt;
                                        }
                                    } //endif of minorder
                                    else {
                                        header('Access-Control-Allow-Origin: *');
                                        $res = array(
                                            'message' => 'Please add more products for promocode',
                                            'status' => 201
                                        );
                                        echo json_encode($res);
                                        exit;
                                    }
                                } else {
                                    header('Access-Control-Allow-Origin: *');
                                    $res = array(
                                        'message' => 'Promocode is already used',
                                        'status' => 201
                                    );
                                    echo json_encode($res);
                                    exit;
                                }
                            }
                            //-----every time promocode---
                            else {
                                if ($order_data->total_amount > $promocode_data->minorder) { //----checking minorder for promocode
                                    // echo "hii";
                                    $discount_amt = $order_data->total_amount * $promocode_data->giftpercent / 100;
                                    if ($discount_amt > $promocode_data->max) {
                                        // will get max amount
                                        $discount =  $promocode_data->max;
                                    } else {
                                        $discount =  $discount_amt;
                                    }
                                } //endif of minorder
                                else {
                                    header('Access-Control-Allow-Origin: *');
                                    $res = array(
                                        'message' => 'Please add more products for promocode',
                                        'status' => 201
                                    );
                                    echo json_encode($res);
                                    exit;
                                }
                            }
                            $final_amount = $order_data->total_amount - $discount;
                            //-------table_order1 entry-------
                            $update_order1_data = array(
                                'promocode_id' => $promocode_id,
                                'discount' => $discount,
                            );
                            $this->db->where('txnid', $txn_id);
                            $last_id = $this->db->update('tbl_order1', $update_order1_data);
                            if (!empty($last_id)) {
                                $response  = array(
                                    'total' => $order_data->total_amount,
                                    'sub_total' => $final_amount,
                                    'promocode_discount' => $discount,
                                    'promocode_id' => $promocode_id,
                                );
                                header('Access-Control-Allow-Origin: *');
                                $res = array(
                                    'message' => 'success',
                                    'status' => 200,
                                    'data' => $response
                                );
                                echo json_encode($res);
                            } else {
                                header('Access-Control-Allow-Origin: *');
                                $res = array(
                                    'message' => 'some eroor occurred! please try again',
                                    'status' => 201
                                );
                                echo json_encode($res);
                                exit;
                            }
                        } else {
                            header('Access-Control-Allow-Origin: *');
                            $res = array(
                                'message' => 'invalid promocode',
                                'status' => 201
                            );
                            echo json_encode($res);
                            exit;
                        }
                    } else {
                        header('Access-Control-Allow-Origin: *');
                        $res = array(
                            'message' => 'Wrong Authentication',
                            'status' => 201
                        );
                        echo json_encode($res);
                    }
                } else {
                    header('Access-Control-Allow-Origin: *');
                    $res = array(
                        'message' => 'user not found',
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
                'message' => 'No data available',
                'status' => 201
            );
            echo json_encode($res);
        }
    }
    //----promocode_remove-----
    public function promocode_remove()
    {
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->helper('security');
        if ($this->input->post()) {
            $this->form_validation->set_rules('phone', 'phone', 'required|xss_clean|trim');
            $this->form_validation->set_rules('authentication', 'authentication', 'required|xss_clean|trim');
            $this->form_validation->set_rules('token_id', 'token_id', 'required|xss_clean|trim');
            $this->form_validation->set_rules('txn_id', 'txn_id', 'required|xss_clean|trim');
            $this->form_validation->set_rules('promocode_id', 'promocode_id', 'required|xss_clean|trim');
            if ($this->form_validation->run() == true) {
                $phone = $this->input->post('phone');
                $authentication = $this->input->post('authentication');
                $token_id = $this->input->post('token_id');
                $txn_id = $this->input->post('txn_id');
                $promocode = $this->input->post('promocode');
                $this->db->select('*');
                $this->db->from('tbl_users');
                $this->db->where('phone', $phone);
                $user_data = $this->db->get()->row();
                if (!empty($user_data)) {
                    if ($user_data->authentication == $authentication) {
                        $data_insert = array(
                            'promocode_id' => 0,
                            'discount' => 0,
                        );
                        $this->db->where('txnid', $txn_id);
                        $last_id = $this->db->update('tbl_order1', $data_insert);
                        if (!empty($last_id)) {
                            $this->db->select('*');
                            $this->db->from('tbl_order1');
                            $this->db->where('txnid', $txn_id);
                            $order_data = $this->db->get()->row();
                            // $final_amount = $order_data->total_amount + $order_data->delivery_charge;
                            $response  = array(
                                'sub_total' => $order_data->total_amount,
                                'promocode_discount' => $order_data->discount,
                            );
                            header('Access-Control-Allow-Origin: *');
                            $res = array(
                                'message' => 'success',
                                'status' => 200,
                                'data' => $response,
                            );
                            echo json_encode($res);
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
                            'message' => 'Wrong Password',
                            'status' => 201
                        );
                        echo json_encode($res);
                    }
                } else {
                    header('Access-Control-Allow-Origin: *');
                    $res = array(
                        'message' => 'user not found',
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
                'message' => 'No data available',
                'status' => 201
            );
            echo json_encode($res);
        }
    }
    //----add to wishlist--------
    public function add_to_wishlist()
    {
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->helper('security');
        if ($this->input->post()) {
            $this->form_validation->set_rules('phone', 'phone', 'required|xss_clean|trim');
            $this->form_validation->set_rules('authentication', 'authentication', 'required|xss_clean|trim');
            $this->form_validation->set_rules('token_id', 'token_id', 'required|xss_clean|trim');
            $this->form_validation->set_rules('product_id', 'product_id', 'required|xss_clean|trim');
            if ($this->form_validation->run() == true) {
                $phone = $this->input->post('phone');
                $authentication = $this->input->post('authentication');
                $token_id = $this->input->post('token_id');
                $product_id = $this->input->post('product_id');
                $ip = $this->input->ip_address();
                date_default_timezone_set("Asia/Calcutta");
                $cur_date = date("Y-m-d H:i:s");
                $this->db->select('*');
                $this->db->from('tbl_users');
                $this->db->where('phone', $phone);
                $user_data = $this->db->get()->row();
                if (!empty($user_data)) {
                    if ($user_data->authentication == $authentication) {
                        $this->db->select('*');
                        $this->db->from('tbl_wishlist');
                        $this->db->where('user_id', $user_data->id);
                        $this->db->where('product_id', $product_id);
                        $wishlist_data = $this->db->get()->row();
                        if (empty($wishlist_data)) {
                            $data_insert = array(
                                'user_id' => $user_data->id,
                                'product_id' => $product_id,
                                'ip' => $ip,
                                'date' => $cur_date
                            );
                            $last_id = $this->base_model->insert_table("tbl_wishlist", $data_insert, 1);
                            if (!empty($last_id)) {
                                header('Access-Control-Allow-Origin: *');
                                $res = array(
                                    'message' => 'success',
                                    'status' => 200
                                );
                                echo json_encode($res);
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
                                'message' => 'product is already in your wishist',
                                'status' => 201
                            );
                            echo json_encode($res);
                        }
                    } else {
                        header('Access-Control-Allow-Origin: *');
                        $res = array(
                            'message' => 'Wrong Authentication',
                            'status' => 201
                        );
                        echo json_encode($res);
                    }
                } else {
                    header('Access-Control-Allow-Origin: *');
                    $res = array(
                        'message' => 'user not found',
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
                'message' => 'No data available',
                'status' => 201
            );
            echo json_encode($res);
        }
    }
    //----remove wishlist product-----
    public function remove_wishlist_product()
    {
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->helper('security');
        if ($this->input->post()) {
            $this->form_validation->set_rules('phone', 'phone', 'required|xss_clean|trim');
            $this->form_validation->set_rules('authentication', 'authentication', 'required|xss_clean|trim');
            $this->form_validation->set_rules('token_id', 'token_id', 'required|xss_clean|trim');
            $this->form_validation->set_rules('product_id', 'product_id', 'required|xss_clean|trim');
            if ($this->form_validation->run() == true) {
                $phone = $this->input->post('phone');
                $authentication = $this->input->post('authentication');
                $token_id = $this->input->post('token_id');
                $product_id = $this->input->post('product_id');
                $ip = $this->input->ip_address();
                date_default_timezone_set("Asia/Calcutta");
                $cur_date = date("Y-m-d H:i:s");
                $this->db->select('*');
                $this->db->from('tbl_users');
                $this->db->where('phone', $phone);
                $user_data = $this->db->get()->row();
                if (!empty($user_data)) {
                    if ($user_data->authentication == $authentication) {
                        $zapak = $this->db->delete('tbl_wishlist', array('user_id' => $user_data->id, 'product_id' => $product_id));
                        if (!empty($zapak)) {
                            header('Access-Control-Allow-Origin: *');
                            $res = array(
                                'message' => 'success',
                                'status' => 200
                            );
                            echo json_encode($res);
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
                            'message' => 'Wrong Authentication',
                            'status' => 201
                        );
                        echo json_encode($res);
                    }
                } else {
                    header('Access-Control-Allow-Origin: *');
                    $res = array(
                        'message' => 'user not found',
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
                'message' => 'No data available',
                'status' => 201
            );
            echo json_encode($res);
        }
    }
    //----view wishlist-------
    public function view_wishlist()
    {
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->helper('security');
        if ($this->input->post()) {
            $this->form_validation->set_rules('phone', 'phone', 'required|xss_clean|trim');
            $this->form_validation->set_rules('authentication', 'authentication', 'required|xss_clean|trim');
            $this->form_validation->set_rules('token_id', 'token_id', 'required|xss_clean|trim');
            if ($this->form_validation->run() == true) {
                $phone = $this->input->post('phone');
                $authentication = $this->input->post('authentication');
                $token_id = $this->input->post('token_id');
                $this->db->select('*');
                $this->db->from('tbl_users');
                $this->db->where('phone', $phone);
                $user_data = $this->db->get()->row();
                if (!empty($user_data)) {
                    if ($user_data->authentication == $authentication) {
                        $this->db->select('*');
                        $this->db->from('tbl_wishlist');
                        $this->db->where('user_id', $user_data->id);
                        $wishlist_data = $this->db->get();
                        $wishlist_check = $wishlist_data->row();
                        $wishlist_info = [];
                        foreach ($wishlist_data->result() as $data) {
                            $this->db->select('*');
                            $this->db->from('tbl_products');
                            $this->db->where('id', $data->product_id);
                            $dsa = $this->db->get();
                            $product_data = $dsa->row();
                            if ($product_data->is_active == 1) {
                                $this->db->select('*');
                                $this->db->from('tbl_inventory');
                                $this->db->where('product_id', $data->product_id);
                                $inventory_data = $this->db->get()->row();
                                if (!empty($inventory_data)) {
                                    if ($inventory_data->quantity > 0) {
                                        $stock = 1;
                                    } else {
                                        $stock = 0;
                                    }
                                } else {
                                    $stock = 0;
                                }
                                $wishlist_info[] = array(
                                    'product_id' => $product_data->id,
                                    'product_name' => $product_data->productname,
                                    'product_image' => base_url() . $product_data->image,
                                    'product_mrp' => $product_data->mrp,
                                    'product_selling_price' => $product_data->sellingprice,
                                    'stock' => $stock,
                                    't2_price' => $product_data->t2_price,
                                    't2_min' => $product_data->t2_min,
                                    't2_max' => $product_data->t2_max,
                                );
                            }
                        }
                        header('Access-Control-Allow-Origin: *');
                        $res = array(
                            'message' => 'success',
                            'status' => 200,
                            'data' => $wishlist_info,
                        );
                        echo json_encode($res);
                    } else {
                        header('Access-Control-Allow-Origin: *');
                        $res = array(
                            'message' => 'Wrong Authentication',
                            'status' => 201
                        );
                        echo json_encode($res);
                    }
                } else {
                    header('Access-Control-Allow-Origin: *');
                    $res = array(
                        'message' => 'user not found',
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
                'message' => 'No data available',
                'status' => 201
            );
            echo json_encode($res);
        }
    }
    //---------------search api --------------
    public function search_product()
    {
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->helper('security');
        if ($this->input->post()) {
            // print_r($this->input->post());
            // exit;
            $this->form_validation->set_rules('phone', 'phone', 'xss_clean|trim');
            $this->form_validation->set_rules('authentication', 'authentication', 'xss_clean|trim');
            $this->form_validation->set_rules('string', 'string', 'required|xss_clean|trim');
            if ($this->form_validation->run() == true) {
                $phone = $this->input->post('phone');
                $authentication = $this->input->post('authentication');
                $string = $this->input->post('string');
                $T2 = 0;
                if (!empty($phone)) {
                    $this->db->select('*');
                    $this->db->from('tbl_users');
                    $this->db->where('phone', $phone);
                    $check_email = $this->db->get();
                    $check_id = $check_email->row();
                    if (!empty($check_id)) {
                        if ($check_id->authentication == $authentication) {
                            if ($check_id->type == "T2") {
                                $T2 = 1;
                            }
                        }
                    }
                }
                $this->db->select('*');
                $this->db->from('tbl_products');
                $this->db->like('productname', $string);
                $this->db->or_like('modelno', $string);
                $search_string = $this->db->get();
                // print_r ($string_check);
                // exit;
                $search_data = [];
                foreach ($search_string->result() as $data) {
                    if ($data->is_active == 1) {
                        $show = 1;
                        if (!empty($data->brand) && $T2 == 1 && $data->brand != 0) {
                            $check = $this->db->get_where('tbl_brands', array('is_active' => 1, 'for_t2' => 1, 'id' => $data->brand))->result();
                            if (empty($check)) {
                                $show = 0;
                            }
                        }
                        if ($show == 0) {
                            continue;
                        }
                        $this->db->select('*');
                        $this->db->from('tbl_category');
                        $this->db->where('id', $data->category_id);
                        $this->db->where('is_active', 1);
                        $cat_check = $this->db->get()->row();
                        $this->db->from('tbl_subcategory');
                        $this->db->where('is_active', 1);
                        $this->db->where('id', $data->subcategory_id);
                        $subcat_check = $this->db->get()->row();
                        $this->db->select('*');
                        $this->db->from('tbl_minorcategory');
                        $this->db->where('is_active', 1);
                        $this->db->where('id', $data->minorcategory_id);
                        $minorcat_check = $this->db->get()->row();
                        if (!empty($cat_check) && !empty($subcat_check) && !empty($minorcat_check)) {
                            $this->db->select('*');
                            $this->db->from('tbl_inventory');
                            $this->db->where('product_id', $data->id);
                            $inventory_data = $this->db->get()->row();
                            if (!empty($inventory_data)) {
                                if ($inventory_data->quantity > 0) {
                                    $stock = 1;
                                } else {
                                    $stock = 0;
                                }
                            } else {
                                $stock = 0;
                            }
                            $search_data[] = array(
                                'product_id' => $data->id,
                                'product_name' => $data->productname,
                                'produt_image' => base_url() . $data->image,
                                'productdescription' => $data->productdescription,
                                'product_mrp' => $data->mrp,
                                'product_selling_price' => $data->sellingprice,
                                'max' => $data->max,
                                't2_price' => $data->t2_price,
                                't2_min' => $data->t2_min,
                                't2_max' => $data->t2_max,
                                'stock' => $stock
                            );
                        }
                    }
                }
                header('Access-Control-Allow-Origin: *');
                $res = array(
                    'message' => "success",
                    'status' => 200,
                    'data' => $search_data
                );
                echo json_encode($res);
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
                'message' => 'No data available',
                'status' => 201
            );
            echo json_encode($res);
        }
    }
    //----view store_details-------
    public function store_details()
    {
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->helper('security');
        if ($this->input->post()) {
            $this->form_validation->set_rules('phone', 'phone', 'required|xss_clean|trim');
            $this->form_validation->set_rules('authentication', 'authentication', 'required|xss_clean|trim');
            $this->form_validation->set_rules('token_id', 'token_id', 'required|xss_clean|trim');
            if ($this->form_validation->run() == true) {
                $phone = $this->input->post('phone');
                $authentication = $this->input->post('authentication');
                $token_id = $this->input->post('token_id');
                $this->db->select('*');
                $this->db->from('tbl_users');
                $this->db->where('phone', $phone);
                $user_data = $this->db->get()->row();
                if (!empty($user_data)) {
                    if ($user_data->authentication == $authentication) {
                        $this->db->select('*');
                        $this->db->from('tbl_store');
                        $store_data = $this->db->get();
                        $store_info = [];
                        foreach ($store_data->result() as $data) {
                            $store_info[] = array(
                                'id' => $data->id,
                                'name' => $data->name,
                                'address' => $data->address,
                                'pincode' => $data->pincode,
                                'contact1' => $data->contact1,
                                'contact2' => $data->contact2,
                            );
                        }
                        header('Access-Control-Allow-Origin: *');
                        $res = array(
                            'message' => 'success',
                            'status' => 200,
                            'data' => $store_info,
                        );
                        echo json_encode($res);
                    } else {
                        header('Access-Control-Allow-Origin: *');
                        $res = array(
                            'message' => 'Wrong Authentication',
                            'status' => 201
                        );
                        echo json_encode($res);
                    }
                } else {
                    header('Access-Control-Allow-Origin: *');
                    $res = array(
                        'message' => 'user not found',
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
                'message' => 'No data available',
                'status' => 201
            );
            echo json_encode($res);
        }
    }
    //----checkout-------
    public function checkout()
    {
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->helper('security');
        if ($this->input->post()) {
            $this->form_validation->set_rules('phone', 'phone', 'required|xss_clean|trim');
            $this->form_validation->set_rules('authentication', 'authentication', 'required|xss_clean|trim');
            $this->form_validation->set_rules('token_id', 'token_id', 'required|xss_clean|trim');
            $this->form_validation->set_rules('txn_id', 'txn_id', 'required|xss_clean|trim');
            $this->form_validation->set_rules('payment_type', 'payment_type', 'required|xss_clean|trim');
            // $this->form_validation->set_rules('name', 'name', 'required|xss_clean|trim');
            // $this->form_validation->set_rules('contact', 'contact', 'required|xss_clean|trim');
            // $this->form_validation->set_rules('pincode', 'pincode', 'required|xss_clean|trim');
            // $this->form_validation->set_rules('state', 'state', 'required|xss_clean|trim');
            // $this->form_validation->set_rules('city', 'city', 'required|xss_clean|trim');
            // $this->form_validation->set_rules('house_no', 'house_no', 'required|xss_clean|trim');
            // $this->form_validation->set_rules('street_address', 'street_address', 'required|xss_clean|trim');
            // $this->form_validation->set_rules('store_id', 'store_id', 'xss_clean|trim');
            if ($this->form_validation->run() == true) {
                $phone = $this->input->post('phone');
                $authentication = $this->input->post('authentication');
                $token_id = $this->input->post('token_id');
                $txn_id = $this->input->post('txn_id');
                $payment_type = $this->input->post('payment_type');
                // $name=$this->input->post('name');
                // $contact=$this->input->post('contact');
                // $pincode=$this->input->post('pincode');
                // $state=$this->input->post('state');
                // $city=$this->input->post('city');
                // $house_no=$this->input->post('house_no');
                // $street_address=$this->input->post('street_address');
                // $store_id=$this->input->post('store_id');
                $this->load->library('upload');
                $image = "";
                if ($payment_type == 1) {
                    $img1 = 'image';
                    $file_check = ($_FILES['image']['error']);
                    if ($file_check != 4) {
                        $image_upload_folder = FCPATH . "assets/uploads/bank_receipts/";
                        if (!file_exists($image_upload_folder)) {
                            mkdir($image_upload_folder, DIR_WRITE_MODE, true);
                        }
                        $new_file_name = "bank_receipt" . date("Ymdhms");
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
                            exit;
                        } else {
                            $file_info = $this->upload->data();
                            $videoNAmePath = "assets/uploads/bank_receipts/" . $new_file_name . $file_info['file_ext'];
                            $file_info['new_name'] = $videoNAmePath;
                            // $this->step6_model->updateappIconImage($imageNAmePath,$appInfoId);
                            $image = $videoNAmePath;
                            // echo json_encode($file_info);
                        }
                    }
                }
                $this->db->select('*');
                $this->db->from('tbl_users');
                $this->db->where('phone', $phone);
                $user_data = $this->db->get()->row();
                if (!empty($user_data)) {
                    if ($user_data->authentication == $authentication) {
                        if ($user_data->is_active == 1) {
                            $this->db->select('*');
                            $this->db->from('tbl_order1');
                            $this->db->where('txnid', $txn_id);
                            $order1_data = $this->db->get()->row();
                            if (!empty($order1_data)) {
                                $this->db->select('*');
                                $this->db->from('tbl_order2');
                                $this->db->where('main_id', $order1_data->id);
                                $order2_data = $this->db->get();
                                $order2_check = $order2_data->row();
                                if (!empty($order2_check)) {
                                    //----------------inventory check---------
                                    foreach ($order2_data->result() as $data) {
                                        $this->db->select('*');
                                        $this->db->from('tbl_products');
                                        $this->db->where('id', $data->product_id);
                                        $product_data = $this->db->get()->row();
                                        $this->db->select('*');
                                        $this->db->from('tbl_inventory');
                                        $this->db->where('product_id', $data->product_id);
                                        $inventory_data = $this->db->get()->row();
                                        if ($inventory_data->quantity >= $data->quantity) {
                                        } else {
                                            header('Access-Control-Allow-Origin: *');
                                            $res = array(
                                                'message' => $product_data->productname . 'is out of stock! Please remove this before checkout',
                                                'status' => 201
                                            );
                                            echo json_encode($res);
                                            exit;
                                        }
                                        if ($user_data->type == "T3") {
                                            if ($product_data->max >= $data->quantity) {
                                            } else {
                                                header('Access-Control-Allow-Origin: *');
                                                $res = array(
                                                    'message' => 'Maximum purchase limit is ' . $product_data->max,
                                                    'status' => 201
                                                );
                                                echo json_encode($res);
                                                exit;
                                            }
                                        } else {
                                            if ($product_data->t2_min <= $data->quantity) {
                                            } else {
                                                header('Access-Control-Allow-Origin: *');
                                                $res = array(
                                                    'message' => 'Maximum purchase limit is ' . $product_data->max,
                                                    'status' => 201
                                                );
                                                echo json_encode($res);
                                                exit;
                                            }
                                            if ($product_data->t2_max >= $data->quantity) {
                                            } else {
                                                header('Access-Control-Allow-Origin: *');
                                                $res = array(
                                                    'message' => 'Maximum purchase limit is ' . $product_data->max,
                                                    'status' => 201
                                                );
                                                echo json_encode($res);
                                                exit;
                                            }
                                        }
                                    } //end of foreach
                                } //end of order2
                                $total = $order1_data->total_amount;
                                $discount = $order1_data->discount;
                                if (empty($discount)) {
                                    $discount = 0;
                                }
                                $final_amount = $total - $discount;
                                //----------order1 entry-------
                                $data_insert = array(
                                    'payment_type' => $payment_type,
                                    'name' => $user_data->name,
                                    'phone' => $user_data->phone,
                                    'pincode' => $user_data->zipcode,
                                    'state' => $user_data->state,
                                    'city' => $user_data->city,
                                    'district' => $user_data->district,
                                    // 'house_no'=>$user_data->house_no,
                                    'street_address' => $user_data->address,
                                    'final_amount' => $final_amount,
                                    'bank_receipt' => $image,
                                    // 'store_id'=>$store_id,
                                    'payment_status' => 1,
                                    'order_status' => 1,
                                    'from' => 'web'
                                );
                                $this->db->where('txnid', $txn_id);
                                $last_id = $this->db->update('tbl_order1', $data_insert);
                                //----------------inventory update---------
                                if (!empty($order2_check)) {
                                    foreach ($order2_data->result() as $data1) {
                                        $this->db->select('*');
                                        $this->db->from('tbl_inventory');
                                        $this->db->where('product_id', $data1->product_id);
                                        $product_data1 = $this->db->get()->row();
                                        $updated_inventory = $product_data1->quantity - $data1->quantity;
                                        $data_update = array('quantity' => $updated_inventory);
                                        $this->db->where('id', $product_data1->id);
                                        $last_id = $this->db->update('tbl_inventory', $data_update);
                                    } //end of foreach
                                } //end of order2
                                //------------cart clear--------------
                                $this->db->select('*');
                                $this->db->from('tbl_cart');
                                $this->db->where('user_id', $user_data->id);
                                $cart_data = $this->db->get();
                                $cart_check = $cart_data->row();
                                if (!empty($cart_check)) {
                                    foreach ($cart_data->result() as $cart) {
                                        $zapak = $this->db->delete('tbl_cart', array('id' => $cart->id));
                                    }
                                }
                            } // end of order1
                            $order_data = $this->db->get_where('tbl_order1', array('txnid' => $txn_id))->row();
                            //--- start send whatsapp msg -----
                            $this->send_whatsapp_msg_admin($order_data, $user_data->name);
                            header('Access-Control-Allow-Origin: *');
                            $res = array(
                                'message' => 'success',
                                'status' => 200,
                                'order_id' => $order1_data->id,
                                'amount' => $final_amount,
                            );
                            echo json_encode($res);
                        } else {
                            header('Access-Control-Allow-Origin: *');
                            $res = array(
                                'message' => 'Your account is blocked! Please contact to admin.',
                                'status' => 201
                            );
                            echo json_encode($res);
                        }
                    } else {
                        header('Access-Control-Allow-Origin: *');
                        $res = array(
                            'message' => 'Wrong Authentication',
                            'status' => 201
                        );
                        echo json_encode($res);
                    }
                } else {
                    header('Access-Control-Allow-Origin: *');
                    $res = array(
                        'message' => 'user not found',
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
                'message' => 'No data available',
                'status' => 201
            );
            echo json_encode($res);
        }
    }
    public function view_order()
    {
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->helper('security');
        if ($this->input->post()) {
            $this->form_validation->set_rules('phone', 'phone', 'required|xss_clean|trim');
            $this->form_validation->set_rules('authentication', 'authentication', 'required|xss_clean|trim');
            $this->form_validation->set_rules('token_id', 'token_id', 'required|xss_clean|trim');
            if ($this->form_validation->run() == true) {
                $phone = $this->input->post('phone');
                $authentication = $this->input->post('authentication');
                $token_id = $this->input->post('token_id');
                $this->db->select('*');
                $this->db->from('tbl_users');
                $this->db->where('phone', $phone);
                $user_data = $this->db->get()->row();
                if (!empty($user_data)) {
                    if ($user_data->authentication == $authentication) {
                        $this->db->select('*');
                        $this->db->from('tbl_order1');
                        $this->db->where('user_id', $user_data->id);
                        $check_data = $this->db->get()->row();
                        $viewcart = [];
                        if (!empty($check_data)) {
                            $this->db->select('*');
                            $this->db->from('tbl_order1');
                            $this->db->where('user_id', $user_data->id);
                            $this->db->where('payment_status', 1);
                            $this->db->order_by('id', "desc");
                            $data = $this->db->get();
                            foreach ($data->result() as $value) {
                                if ($value->payment_type == 1) {
                                    $payment_type = "Bank Transfer";
                                } elseif ($value->payment_type == 2) {
                                    $payment_type = "Pay After Discussion";
                                } else {
                                    $payment_type = "NA";
                                }
                                if ($value->order_status == 1 || $value->order_status == 2) {
                                    $cancel_status = 1;
                                } else {
                                    $cancel_status = 0;
                                }
                                if ($value->order_status == 1) {
                                    $order_status = "Placed";
                                } elseif ($value->order_status == 2) {
                                    $order_status = "Confirmed";
                                } elseif ($value->order_status == 3) {
                                    $order_status = "Dispatched";
                                } elseif ($value->order_status == 4) {
                                    $order_status = "Delivered";
                                } elseif ($value->order_status == 5) {
                                    $order_status = "Cancelled";
                                } elseif ($value->order_status == 6) {
                                    $order_status = "On Hold";
                                }
                                $newdate = new DateTime($value->date);
                                $d2 = $newdate->format('d-m-Y');   #d-m-Y  // March 10, 2001, 5:16 pm
                                $viewcart[] = array(
                                    'order_id' => $value->id,
                                    'order_date' => $d2,
                                    'total_amount' => $value->final_amount,
                                    'weight' => $value->weight,
                                    'payment_type' => $payment_type,
                                    'discount' => $value->discount,
                                    'order_status' => $order_status,
                                    'cancel_status' => $cancel_status,
                                );
                            }
                        }
                        header('Access-Control-Allow-Origin: *');
                        $res = array(
                            'message' => "success",
                            'status' => 200,
                            'data' => $viewcart
                        );
                        echo json_encode($res);
                    } else {
                        header('Access-Control-Allow-Origin: *');
                        $res = array(
                            'message' => 'Wrong authentication',
                            'status' => 201
                        );
                        echo json_encode($res);
                    }
                } else {
                    header('Access-Control-Allow-Origin: *');
                    $res = array(
                        'message' => 'user not found',
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
                'message' => "Please insert some data",
                'status' => 201
            );
            echo json_encode($res);
        }
    }
    //------------------------------------
    //-------------order detail-------------------
    public function orderdetail()
    {
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->helper('security');
        if ($this->input->post()) {
            $this->form_validation->set_rules('phone', 'phone', 'required|xss_clean|trim');
            $this->form_validation->set_rules('authentication', 'authentication', 'required|xss_clean|trim');
            $this->form_validation->set_rules('token_id', 'token_id', 'required|xss_clean|trim');
            $this->form_validation->set_rules('order_id', 'order_id', 'required|xss_clean|trim');
            if ($this->form_validation->run() == true) {
                $phone = $this->input->post('phone');
                $authentication = $this->input->post('authentication');
                $token_id = $this->input->post('token_id');
                $order_id = $this->input->post('order_id');
                $this->db->select('*');
                $this->db->from('tbl_users');
                $this->db->where('phone', $phone);
                $user_data = $this->db->get()->row();
                if (!empty($user_data)) {
                    if ($user_data->authentication == $authentication) {
                        $this->db->select('*');
                        $this->db->from('tbl_order2');
                        $this->db->where('main_id', $order_id);
                        $dsa = $this->db->get();
                        $da = $dsa->row();
                        $order2 = [];
                        $subtotal = 0;
                        foreach ($dsa->result() as $data) {
                            $this->db->select('*');
                            $this->db->from('tbl_products');
                            $this->db->where('id', $data->product_id);
                            $product_data = $this->db->get()->row();
                            if (!empty($product_data)) {
                                $order2[] = array(
                                    'product_id' => $product_data->id,
                                    'product_name' => $product_data->productname,
                                    'product_image' => base_url() . $product_data->image,
                                    'quantity' => $data->quantity,
                                    'price' => $data->product_mrp,
                                    'total amount' => $data->total_amount,
                                    'weight' => $product_data->weight,
                                );
                            }
                            $subtotal = $subtotal + $data->total_amount;
                        }
                        header('Access-Control-Allow-Origin: *');
                        $res = array(
                            'message' => "success",
                            'status' => 200,
                            'data' => $order2,
                            'subtotal' => $subtotal
                        );
                        echo json_encode($res);
                    } else {
                        header('Access-Control-Allow-Origin: *');
                        $res = array(
                            'message' => 'Wrong authentication',
                            'status' => 201
                        );
                        echo json_encode($res);
                    }
                } else {
                    header('Access-Control-Allow-Origin: *');
                    $res = array(
                        'message' => 'user not found',
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
                'message' => "Please insert some data",
                'status' => 201
            );
            echo json_encode($res);
        }
    }
    //footer subscription
    public function subscribe_us()
    {
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->helper('security');
        if ($this->input->post()) {
            $this->form_validation->set_rules('email', 'email', 'required|valid_email|xss_clean');
            if ($this->form_validation->run() == true) {
                $email = $this->input->post('email');
                $ip = $this->input->ip_address();
                date_default_timezone_set("Asia/Calcutta");
                $cur_date = date("Y-m-d H:i:s");
                $this->db->select('*');
                $this->db->from('tbl_subscribe_us');
                $this->db->where('email_id', $email);
                $dsa = $this->db->get();
                $da = $dsa->row();
                if (!empty($da)) {
                    header('Access-Control-Allow-Origin: *');
                    $res = array(
                        'message' => "Already applied",
                        'status' => 201
                    );
                    echo json_encode($res);
                    exit;
                }
                $data_insert = array(
                    'email_id' => $email,
                    'ip' => $ip,
                    'date' => $cur_date,
                );
                $last_id = $this->base_model->insert_table("tbl_subscribe_us", $data_insert, 1);
                if ($last_id != 0) {
                    header('Access-Control-Allow-Origin: *');
                    $res = array(
                        'message' => "success",
                        'status' => 200
                    );
                    echo json_encode($res);
                } else {
                    header('Access-Control-Allow-Origin: *');
                    $res = array(
                        'message' => "sorry error occurred",
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
                'message' => 'No data available',
                'status' => 201
            );
            echo json_encode($res);
        }
    }
    ///cancel_order
    public function cancel_order()
    {
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->helper('security');
        if ($this->input->post()) {
            $this->form_validation->set_rules('phone', 'phone', 'required|xss_clean|trim');
            $this->form_validation->set_rules('authentication', 'authentication', 'required|xss_clean|trim');
            $this->form_validation->set_rules('token_id', 'token_id', 'required|xss_clean|trim');
            $this->form_validation->set_rules('order_id', 'order_id', 'required|xss_clean|trim');
            if ($this->form_validation->run() == true) {
                $phone = $this->input->post('phone');
                $authentication = $this->input->post('authentication');
                $token_id = $this->input->post('token_id');
                $order_id = $this->input->post('order_id');
                $this->db->select('*');
                $this->db->from('tbl_users');
                $this->db->where('phone', $phone);
                $user_data = $this->db->get()->row();
                if (!empty($user_data)) {
                    if ($user_data->authentication == $authentication) {
                        $data_insert = array(
                            'order_status' => 5,
                        );
                        $this->db->where('id', $order_id);
                        $last_id = $this->db->update('tbl_order1', $data_insert);
                        $this->db->select('*');
                        $this->db->from('tbl_order2');
                        $this->db->where('main_id', $order_id);
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
                            if (!empty($last_id)) {
                                header('Access-Control-Allow-Origin: *');
                                $res = array(
                                    'message' => 'success',
                                    'status' => 200
                                );
                                echo json_encode($res);
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
                                'message' => 'Order id not found',
                                'status' => 201
                            );
                            echo json_encode($res);
                        }
                    } else {
                        header('Access-Control-Allow-Origin: *');
                        $res = array(
                            'message' => 'Wrong authantication',
                            'status' => 201
                        );
                        echo json_encode($res);
                    }
                } else {
                    header('Access-Control-Allow-Origin: *');
                    $res = array(
                        'message' => 'user not found',
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
                'message' => 'No data available',
                'status' => 201
            );
            echo json_encode($res);
        }
    }
    //------------filter-----
    public function filter()
    {
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->helper('security');
        if ($this->input->post()) {
            $this->form_validation->set_rules('brand_id', 'brand_id', 'xss_clean|trim');
            $this->form_validation->set_rules('resolution_id', 'resolution_id', 'xss_clean|trim');
            $this->form_validation->set_rules('irdistance_id', 'irdistance_id', 'xss_clean|trim');
            $this->form_validation->set_rules('cameratype_id', 'cameratype_id', 'xss_clean|trim');
            $this->form_validation->set_rules('bodymaterial_id', 'bodymaterial_id', 'xss_clean|trim');
            $this->form_validation->set_rules('videochannel_id', 'videochannel_id', 'xss_clean|trim');
            $this->form_validation->set_rules('poeports_id', 'poeports_id', 'xss_clean|trim');
            $this->form_validation->set_rules('poetype_id', 'poetype_id', 'xss_clean|trim');
            $this->form_validation->set_rules('sataports_id', 'sataports_id', 'xss_clean|trim');
            $this->form_validation->set_rules('length_id', 'length_id', 'xss_clean|trim');
            $this->form_validation->set_rules('screensize_id', 'screensize_id', 'xss_clean|trim');
            $this->form_validation->set_rules('ledtype_id', 'ledtype_id', 'xss_clean|trim');
            $this->form_validation->set_rules('size_id', 'size_id', 'xss_clean|trim');
            $this->form_validation->set_rules('lens_id', 'lens_id', 'xss_clean|trim');
            $this->form_validation->set_rules('night_vision_id', 'night_vision_id', 'xss_clean|trim');
            $this->form_validation->set_rules('audio_type_id', 'audio_type_id', 'xss_clean|trim');
            $this->form_validation->set_rules('minorcategory_id', 'minorcategory_id', 'xss_clean|trim');
            if ($this->form_validation->run() == true) {
                $minorcategory_id = $this->input->post('minorcategory_id');
                $brand_id = $this->input->post('brand_id');
                $resolution_id = $this->input->post('resolution_id');
                $irdistance_id = $this->input->post('irdistance_id');
                $cameratype_id = $this->input->post('cameratype_id');
                $bodymaterial_id = $this->input->post('bodymaterial_id');
                $videochannel_id = $this->input->post('videochannel_id');
                $poeports_id = $this->input->post('poeports_id');
                $poetype_id = $this->input->post('poetype_id');
                $sataports_id = $this->input->post('sataports_id');
                $length_id = $this->input->post('length_id');
                $screensize_id = $this->input->post('screensize_id');
                $ledtype_id = $this->input->post('ledtype_id');
                $size_id = $this->input->post('size_id');
                $lens_id = $this->input->post('lens_id');
                $night_vision_id = $this->input->post('night_vision_id');
                $audio_type_id = $this->input->post('audio_type_id');
                $brand_info = explode(',', $brand_id);
                $resolution_info = explode(',', $resolution_id);
                $irdistance_info = explode(',', $irdistance_id);
                $cameratype_info = explode(',', $cameratype_id);
                $bodymaterial_info = explode(',', $bodymaterial_id);
                $videochannel_info = explode(',', $videochannel_id);
                $poeports_info = explode(',', $poeports_id);
                $poetype_info = explode(',', $poetype_id);
                $sataports_info = explode(',', $sataports_id);
                $length_info = explode(',', $length_id);
                $screensize_info = explode(',', $screensize_id);
                $ledtype_info = explode(',', $ledtype_id);
                $size_info = explode(',', $size_id);
                $lens_info = explode(',', $lens_id);
                $night_vision_info = explode(',', $night_vision_id);
                $audio_type_info = explode(',', $audio_type_id);
                // die();
                $this->db->select('*');
                $this->db->from('tbl_products');
                $this->db->where('is_active', 1);
                $this->db->where('minorcategory_id', $minorcategory_id);
                $filter_data = $this->db->get();
                $filter_check = $filter_data->row();
                // print_r($filter_check);exit;
                // $filter_info = [];
                $send = [];
                $content = [];
                foreach ($filter_data->result() as $filterrr) {
                    if ($filterrr->is_active == 1) {
                        $this->db->select('*');
                        $this->db->from('tbl_inventory');
                        $this->db->where('product_id', $filterrr->id);
                        $inventory_data = $this->db->get()->row();
                        if (!empty($inventory_data)) {
                            if ($inventory_data->quantity > 0) {
                                $stock = 1;
                            } else {
                                $stock = 0;
                            }
                        } else {
                            $stock = 0;
                        }
                        if (empty($resolution_info[0]) && empty($irdistance_info[0]) && empty($cameratype_info[0]) && empty($bodymaterial_info[0]) && empty($videochannel_info[0]) && empty($poeports_info[0]) && empty($poetype_info[0]) && empty($sataports_info[0]) && empty($length_info[0]) && empty($screensize_info[0]) && empty($ledtype_info[0]) && empty($size_info[0]) && empty($lens_info[0]) && empty($night_vision_info[0]) && empty($audio_type_info[0])) {
                            if (!empty($brand_info[0])) {
                                foreach ($brand_info as $data0) {
                                    if ($filterrr->brand == $data0) {
                                        //    $send = [];
                                        $send[] = array(
                                            'product_id' => $filterrr->id,
                                            'product_name' => $filterrr->productname,
                                            'product_image' => base_url() . $filterrr->image,
                                            'productdescription' => $filterrr->productdescription,
                                            'price' => $filterrr->sellingprice,
                                            'max' => $filterrr->max,
                                            't2_price' => $filterrr->t2_price,
                                            't2_min' => $filterrr->t2_min,
                                            't2_max' => $filterrr->t2_max,
                                            'stock' => $stock,
                                            'brand' => $filterrr->brand,
                                            'resolution' => $filterrr->resolution,
                                            'irdistance' => $filterrr->irdistance,
                                            'cameratype' => $filterrr->cameratype,
                                            'bodymaterial' => $filterrr->bodymaterial,
                                            'videochannel' => $filterrr->videochannel,
                                            'poeports' => $filterrr->poeports,
                                            'poetype' => $filterrr->poetype,
                                            'sataports' => $filterrr->sataports,
                                            'length' => $filterrr->length,
                                            'screensize' => $filterrr->screensize,
                                            'ledtype' => $filterrr->ledtype,
                                            'size' => $filterrr->size,
                                            'lens' => $filterrr->lens,
                                            'night_vision' => $filterrr->night_vision,
                                            'audio_type' => $filterrr->audio_type,
                                        );
                                        //  array_push($content, $send);
                                    }
                                }
                            }
                        }
                        if (!empty($resolution_info[0])) {
                            foreach ($resolution_info as $data1) {
                                if ($filterrr->resolution == $data1) {
                                    //    $send = [];
                                    // echo $filterrr->resolution.$data1."--";
                                    $send[] = array(
                                        'product_id' => $filterrr->id,
                                        'product_name' => $filterrr->productname,
                                        'product_image' => base_url() . $filterrr->image,
                                        'productdescription' => $filterrr->productdescription,
                                        'price' => $filterrr->sellingprice,
                                        'max' => $filterrr->max,
                                        't2_price' => $filterrr->t2_price,
                                        't2_min' => $filterrr->t2_min,
                                        't2_max' => $filterrr->t2_max,
                                        'stock' => $stock,
                                        'brand' => $filterrr->brand,
                                        'resolution' => $filterrr->resolution,
                                        'irdistance' => $filterrr->irdistance,
                                        'cameratype' => $filterrr->cameratype,
                                        'bodymaterial' => $filterrr->bodymaterial,
                                        'videochannel' => $filterrr->videochannel,
                                        'poeports' => $filterrr->poeports,
                                        'poetype' => $filterrr->poetype,
                                        'sataports' => $filterrr->sataports,
                                        'length' => $filterrr->length,
                                        'screensize' => $filterrr->screensize,
                                        'ledtype' => $filterrr->ledtype,
                                        'size' => $filterrr->size,
                                        'lens' => $filterrr->lens,
                                        'night_vision' => $filterrr->night_vision,
                                        'audio_type' => $filterrr->audio_type,
                                    );
                                    //  array_push($content, $send);
                                }
                            }
                        }
                        if (!empty($irdistance_info[0])) {
                            foreach ($irdistance_info as $data2) {
                                if ($filterrr->irdistance == $data2) {
                                    //    $send = [];
                                    $send[] = array(
                                        'product_id' => $filterrr->id,
                                        'product_name' => $filterrr->productname,
                                        'product_image' => base_url() . $filterrr->image,
                                        'productdescription' => $filterrr->productdescription,
                                        'price' => $filterrr->sellingprice,
                                        'max' => $filterrr->max,
                                        't2_price' => $filterrr->t2_price,
                                        't2_min' => $filterrr->t2_min,
                                        't2_max' => $filterrr->t2_max,
                                        'stock' => $stock,
                                        'brand' => $filterrr->brand,
                                        'resolution' => $filterrr->resolution,
                                        'irdistance' => $filterrr->irdistance,
                                        'cameratype' => $filterrr->cameratype,
                                        'bodymaterial' => $filterrr->bodymaterial,
                                        'videochannel' => $filterrr->videochannel,
                                        'poeports' => $filterrr->poeports,
                                        'poetype' => $filterrr->poetype,
                                        'sataports' => $filterrr->sataports,
                                        'length' => $filterrr->length,
                                        'screensize' => $filterrr->screensize,
                                        'ledtype' => $filterrr->ledtype,
                                        'size' => $filterrr->size,
                                        'lens' => $filterrr->lens,
                                        'night_vision' => $filterrr->night_vision,
                                        'audio_type' => $filterrr->audio_type,
                                    );
                                    //  array_push($content, $send);
                                }
                            }
                        }
                        if (!empty($cameratype_info[0])) {
                            foreach ($cameratype_info as $data3) {
                                if ($filterrr->cameratype == $data3) {
                                    //    $send = [];
                                    $send[] = array(
                                        'product_id' => $filterrr->id,
                                        'product_name' => $filterrr->productname,
                                        'product_image' => base_url() . $filterrr->image,
                                        'productdescription' => $filterrr->productdescription,
                                        'price' => $filterrr->sellingprice,
                                        'max' => $filterrr->max,
                                        't2_price' => $filterrr->t2_price,
                                        't2_min' => $filterrr->t2_min,
                                        't2_max' => $filterrr->t2_max,
                                        'stock' => $stock,
                                        'brand' => $filterrr->brand,
                                        'resolution' => $filterrr->resolution,
                                        'irdistance' => $filterrr->irdistance,
                                        'cameratype' => $filterrr->cameratype,
                                        'bodymaterial' => $filterrr->bodymaterial,
                                        'videochannel' => $filterrr->videochannel,
                                        'poeports' => $filterrr->poeports,
                                        'poetype' => $filterrr->poetype,
                                        'sataports' => $filterrr->sataports,
                                        'length' => $filterrr->length,
                                        'screensize' => $filterrr->screensize,
                                        'ledtype' => $filterrr->ledtype,
                                        'size' => $filterrr->size,
                                        'lens' => $filterrr->lens,
                                        'night_vision' => $filterrr->night_vision,
                                        'audio_type' => $filterrr->audio_type,
                                    );
                                    //  array_push($content, $send);
                                }
                            }
                        }
                        if (!empty($bodymaterial_info[0])) {
                            foreach ($bodymaterial_info as $data4) {
                                if ($filterrr->bodymaterial == $data4) {
                                    //    $send = [];
                                    $send[] = array(
                                        'product_id' => $filterrr->id,
                                        'product_name' => $filterrr->productname,
                                        'product_image' => base_url() . $filterrr->image,
                                        'productdescription' => $filterrr->productdescription,
                                        'price' => $filterrr->sellingprice,
                                        'max' => $filterrr->max,
                                        't2_price' => $filterrr->t2_price,
                                        't2_min' => $filterrr->t2_min,
                                        't2_max' => $filterrr->t2_max,
                                        'stock' => $stock,
                                        'brand' => $filterrr->brand,
                                        'resolution' => $filterrr->resolution,
                                        'irdistance' => $filterrr->irdistance,
                                        'cameratype' => $filterrr->cameratype,
                                        'bodymaterial' => $filterrr->bodymaterial,
                                        'videochannel' => $filterrr->videochannel,
                                        'poeports' => $filterrr->poeports,
                                        'poetype' => $filterrr->poetype,
                                        'sataports' => $filterrr->sataports,
                                        'length' => $filterrr->length,
                                        'screensize' => $filterrr->screensize,
                                        'ledtype' => $filterrr->ledtype,
                                        'size' => $filterrr->size,
                                        'lens' => $filterrr->lens,
                                        'night_vision' => $filterrr->night_vision,
                                        'audio_type' => $filterrr->audio_type,
                                    );
                                    //  array_push($content, $send);
                                }
                            }
                        }
                        if (!empty($videochannel_info[0])) {
                            foreach ($videochannel_info as $data5) {
                                if ($filterrr->videochannel == $data5) {
                                    //    $send = [];
                                    $send[] = array(
                                        'product_id' => $filterrr->id,
                                        'product_name' => $filterrr->productname,
                                        'product_image' => base_url() . $filterrr->image,
                                        'productdescription' => $filterrr->productdescription,
                                        'price' => $filterrr->sellingprice,
                                        'max' => $filterrr->max,
                                        't2_price' => $filterrr->t2_price,
                                        't2_min' => $filterrr->t2_min,
                                        't2_max' => $filterrr->t2_max,
                                        'stock' => $stock,
                                        'brand' => $filterrr->brand,
                                        'resolution' => $filterrr->resolution,
                                        'irdistance' => $filterrr->irdistance,
                                        'cameratype' => $filterrr->cameratype,
                                        'bodymaterial' => $filterrr->bodymaterial,
                                        'videochannel' => $filterrr->videochannel,
                                        'poeports' => $filterrr->poeports,
                                        'poetype' => $filterrr->poetype,
                                        'sataports' => $filterrr->sataports,
                                        'length' => $filterrr->length,
                                        'screensize' => $filterrr->screensize,
                                        'ledtype' => $filterrr->ledtype,
                                        'size' => $filterrr->size,
                                        'lens' => $filterrr->lens,
                                        'night_vision' => $filterrr->night_vision,
                                        'audio_type' => $filterrr->audio_type,
                                    );
                                    //  array_push($content, $send);
                                }
                            }
                        }
                        if (!empty($poeports_info[0])) {
                            foreach ($poeports_info as $data6) {
                                if ($filterrr->poeports == $data6) {
                                    //    $send = [];
                                    $send[] = array(
                                        'product_id' => $filterrr->id,
                                        'product_name' => $filterrr->productname,
                                        'product_image' => base_url() . $filterrr->image,
                                        'productdescription' => $filterrr->productdescription,
                                        'price' => $filterrr->sellingprice,
                                        'max' => $filterrr->max,
                                        't2_price' => $filterrr->t2_price,
                                        't2_min' => $filterrr->t2_min,
                                        't2_max' => $filterrr->t2_max,
                                        'stock' => $stock,
                                        'brand' => $filterrr->brand,
                                        'resolution' => $filterrr->resolution,
                                        'irdistance' => $filterrr->irdistance,
                                        'cameratype' => $filterrr->cameratype,
                                        'bodymaterial' => $filterrr->bodymaterial,
                                        'videochannel' => $filterrr->videochannel,
                                        'poeports' => $filterrr->poeports,
                                        'poetype' => $filterrr->poetype,
                                        'sataports' => $filterrr->sataports,
                                        'length' => $filterrr->length,
                                        'screensize' => $filterrr->screensize,
                                        'ledtype' => $filterrr->ledtype,
                                        'size' => $filterrr->size,
                                        'lens' => $filterrr->lens,
                                        'night_vision' => $filterrr->night_vision,
                                        'audio_type' => $filterrr->audio_type,
                                    );
                                    //  array_push($content, $send);
                                }
                            }
                        }
                        if (!empty($poetype_info[0])) {
                            foreach ($poetype_info as $data7) {
                                if ($filterrr->poetype == $data7) {
                                    //    $send = [];
                                    $send[] = array(
                                        'product_id' => $filterrr->id,
                                        'product_name' => $filterrr->productname,
                                        'product_image' => base_url() . $filterrr->image,
                                        'productdescription' => $filterrr->productdescription,
                                        'price' => $filterrr->sellingprice,
                                        'max' => $filterrr->max,
                                        't2_price' => $filterrr->t2_price,
                                        't2_min' => $filterrr->t2_min,
                                        't2_max' => $filterrr->t2_max,
                                        'stock' => $stock,
                                        'brand' => $filterrr->brand,
                                        'resolution' => $filterrr->resolution,
                                        'irdistance' => $filterrr->irdistance,
                                        'cameratype' => $filterrr->cameratype,
                                        'bodymaterial' => $filterrr->bodymaterial,
                                        'videochannel' => $filterrr->videochannel,
                                        'poeports' => $filterrr->poeports,
                                        'poetype' => $filterrr->poetype,
                                        'sataports' => $filterrr->sataports,
                                        'length' => $filterrr->length,
                                        'screensize' => $filterrr->screensize,
                                        'ledtype' => $filterrr->ledtype,
                                        'size' => $filterrr->size,
                                        'lens' => $filterrr->lens,
                                        'night_vision' => $filterrr->night_vision,
                                        'audio_type' => $filterrr->audio_type,
                                    );
                                    //  array_push($content, $send);
                                }
                            }
                        }
                        if (!empty($sataports_info[0])) {
                            foreach ($sataports_info as $data8) {
                                if ($filterrr->sataports == $data8) {
                                    //    $send = [];
                                    $send[] = array(
                                        'product_id' => $filterrr->id,
                                        'product_name' => $filterrr->productname,
                                        'product_image' => base_url() . $filterrr->image,
                                        'productdescription' => $filterrr->productdescription,
                                        'price' => $filterrr->sellingprice,
                                        'max' => $filterrr->max,
                                        't2_price' => $filterrr->t2_price,
                                        't2_min' => $filterrr->t2_min,
                                        't2_max' => $filterrr->t2_max,
                                        'stock' => $stock,
                                        'brand' => $filterrr->brand,
                                        'resolution' => $filterrr->resolution,
                                        'irdistance' => $filterrr->irdistance,
                                        'cameratype' => $filterrr->cameratype,
                                        'bodymaterial' => $filterrr->bodymaterial,
                                        'videochannel' => $filterrr->videochannel,
                                        'poeports' => $filterrr->poeports,
                                        'poetype' => $filterrr->poetype,
                                        'sataports' => $filterrr->sataports,
                                        'length' => $filterrr->length,
                                        'screensize' => $filterrr->screensize,
                                        'ledtype' => $filterrr->ledtype,
                                        'size' => $filterrr->size,
                                        'lens' => $filterrr->lens,
                                        'night_vision' => $filterrr->night_vision,
                                        'audio_type' => $filterrr->audio_type,
                                    );
                                    //  array_push($content, $send);
                                }
                            }
                        }
                        if (!empty($length_info[0])) {
                            foreach ($length_info as $data9) {
                                if ($filterrr->length == $data9) {
                                    //    $send = [];
                                    $send[] = array(
                                        'product_id' => $filterrr->id,
                                        'product_name' => $filterrr->productname,
                                        'product_image' => base_url() . $filterrr->image,
                                        'productdescription' => $filterrr->productdescription,
                                        'price' => $filterrr->sellingprice,
                                        'max' => $filterrr->max,
                                        't2_price' => $filterrr->t2_price,
                                        't2_min' => $filterrr->t2_min,
                                        't2_max' => $filterrr->t2_max,
                                        'stock' => $stock,
                                        'brand' => $filterrr->brand,
                                        'resolution' => $filterrr->resolution,
                                        'irdistance' => $filterrr->irdistance,
                                        'cameratype' => $filterrr->cameratype,
                                        'bodymaterial' => $filterrr->bodymaterial,
                                        'videochannel' => $filterrr->videochannel,
                                        'poeports' => $filterrr->poeports,
                                        'poetype' => $filterrr->poetype,
                                        'sataports' => $filterrr->sataports,
                                        'length' => $filterrr->length,
                                        'screensize' => $filterrr->screensize,
                                        'ledtype' => $filterrr->ledtype,
                                        'size' => $filterrr->size,
                                        'lens' => $filterrr->lens,
                                        'night_vision' => $filterrr->night_vision,
                                        'audio_type' => $filterrr->audio_type,
                                    );
                                    //  array_push($content, $send);
                                }
                            }
                        }
                        if (!empty($screensize_info[0])) {
                            foreach ($screensize_info as $data10) {
                                if ($filterrr->screensize == $data10) {
                                    //    $send = [];
                                    $send[] = array(
                                        'product_id' => $filterrr->id,
                                        'product_name' => $filterrr->productname,
                                        'product_image' => base_url() . $filterrr->image,
                                        'productdescription' => $filterrr->productdescription,
                                        'price' => $filterrr->sellingprice,
                                        'max' => $filterrr->max,
                                        't2_price' => $filterrr->t2_price,
                                        't2_min' => $filterrr->t2_min,
                                        't2_max' => $filterrr->t2_max,
                                        'stock' => $stock,
                                        'brand' => $filterrr->brand,
                                        'resolution' => $filterrr->resolution,
                                        'irdistance' => $filterrr->irdistance,
                                        'cameratype' => $filterrr->cameratype,
                                        'bodymaterial' => $filterrr->bodymaterial,
                                        'videochannel' => $filterrr->videochannel,
                                        'poeports' => $filterrr->poeports,
                                        'poetype' => $filterrr->poetype,
                                        'sataports' => $filterrr->sataports,
                                        'length' => $filterrr->length,
                                        'screensize' => $filterrr->screensize,
                                        'ledtype' => $filterrr->ledtype,
                                        'size' => $filterrr->size,
                                        'lens' => $filterrr->lens,
                                        'night_vision' => $filterrr->night_vision,
                                        'audio_type' => $filterrr->audio_type,
                                    );
                                    //  array_push($content, $send);
                                }
                            }
                        }
                        if (!empty($ledtype_info[0])) {
                            foreach ($ledtype_info as $data11) {
                                if ($filterrr->ledtype == $data11) {
                                    //    $send = [];
                                    $send[] = array(
                                        'product_id' => $filterrr->id,
                                        'product_name' => $filterrr->productname,
                                        'product_image' => base_url() . $filterrr->image,
                                        'productdescription' => $filterrr->productdescription,
                                        'price' => $filterrr->sellingprice,
                                        'max' => $filterrr->max,
                                        't2_price' => $filterrr->t2_price,
                                        't2_min' => $filterrr->t2_min,
                                        't2_max' => $filterrr->t2_max,
                                        'stock' => $stock,
                                        'brand' => $filterrr->brand,
                                        'resolution' => $filterrr->resolution,
                                        'irdistance' => $filterrr->irdistance,
                                        'cameratype' => $filterrr->cameratype,
                                        'bodymaterial' => $filterrr->bodymaterial,
                                        'videochannel' => $filterrr->videochannel,
                                        'poeports' => $filterrr->poeports,
                                        'poetype' => $filterrr->poetype,
                                        'sataports' => $filterrr->sataports,
                                        'length' => $filterrr->length,
                                        'screensize' => $filterrr->screensize,
                                        'ledtype' => $filterrr->ledtype,
                                        'size' => $filterrr->size,
                                        'lens' => $filterrr->lens,
                                        'night_vision' => $filterrr->night_vision,
                                        'audio_type' => $filterrr->audio_type,
                                    );
                                    //  array_push($content, $send);
                                }
                            }
                        }
                        if (!empty($size_info[0])) {
                            foreach ($size_info as $data12) {
                                if ($filterrr->size == $data12) {
                                    //    $send = [];
                                    $send[] = array(
                                        'product_id' => $filterrr->id,
                                        'product_name' => $filterrr->productname,
                                        'product_image' => base_url() . $filterrr->image,
                                        'productdescription' => $filterrr->productdescription,
                                        'price' => $filterrr->sellingprice,
                                        'max' => $filterrr->max,
                                        't2_price' => $filterrr->t2_price,
                                        't2_min' => $filterrr->t2_min,
                                        't2_max' => $filterrr->t2_max,
                                        'stock' => $stock,
                                        'brand' => $filterrr->brand,
                                        'resolution' => $filterrr->resolution,
                                        'irdistance' => $filterrr->irdistance,
                                        'cameratype' => $filterrr->cameratype,
                                        'bodymaterial' => $filterrr->bodymaterial,
                                        'videochannel' => $filterrr->videochannel,
                                        'poeports' => $filterrr->poeports,
                                        'poetype' => $filterrr->poetype,
                                        'sataports' => $filterrr->sataports,
                                        'length' => $filterrr->length,
                                        'screensize' => $filterrr->screensize,
                                        'ledtype' => $filterrr->ledtype,
                                        'size' => $filterrr->size,
                                        'lens' => $filterrr->lens,
                                        'night_vision' => $filterrr->night_vision,
                                        'audio_type' => $filterrr->audio_type,
                                    );
                                    //  array_push($content, $send);
                                }
                            }
                        }
                        if (!empty($lens_info[0])) {
                            foreach ($lens_info as $data13) {
                                if ($filterrr->lens == $data13) {
                                    //    $send = [];
                                    $send[] = array(
                                        'product_id' => $filterrr->id,
                                        'product_name' => $filterrr->productname,
                                        'product_image' => base_url() . $filterrr->image,
                                        'productdescription' => $filterrr->productdescription,
                                        'price' => $filterrr->sellingprice,
                                        'max' => $filterrr->max,
                                        't2_price' => $filterrr->t2_price,
                                        't2_min' => $filterrr->t2_min,
                                        't2_max' => $filterrr->t2_max,
                                        'stock' => $stock,
                                        'brand' => $filterrr->brand,
                                        'resolution' => $filterrr->resolution,
                                        'irdistance' => $filterrr->irdistance,
                                        'cameratype' => $filterrr->cameratype,
                                        'bodymaterial' => $filterrr->bodymaterial,
                                        'videochannel' => $filterrr->videochannel,
                                        'poeports' => $filterrr->poeports,
                                        'poetype' => $filterrr->poetype,
                                        'sataports' => $filterrr->sataports,
                                        'length' => $filterrr->length,
                                        'screensize' => $filterrr->screensize,
                                        'ledtype' => $filterrr->ledtype,
                                        'size' => $filterrr->size,
                                        'lens' => $filterrr->lens,
                                        'night_vision' => $filterrr->night_vision,
                                        'audio_type' => $filterrr->audio_type,
                                    );
                                    //  array_push($content, $send);
                                }
                            }
                        }
                        if (!empty($night_vision_info[0])) {
                            // die();
                            foreach ($night_vision_info as $data14) {
                                if ($filterrr->night_vision == $data14) {
                                    //    $send = [];
                                    $send[] = array(
                                        'product_id' => $filterrr->id,
                                        'product_name' => $filterrr->productname,
                                        'product_image' => base_url() . $filterrr->image,
                                        'productdescription' => $filterrr->productdescription,
                                        'price' => $filterrr->sellingprice,
                                        'max' => $filterrr->max,
                                        't2_price' => $filterrr->t2_price,
                                        't2_min' => $filterrr->t2_min,
                                        't2_max' => $filterrr->t2_max,
                                        'stock' => $stock,
                                        'brand' => $filterrr->brand,
                                        'resolution' => $filterrr->resolution,
                                        'irdistance' => $filterrr->irdistance,
                                        'cameratype' => $filterrr->cameratype,
                                        'bodymaterial' => $filterrr->bodymaterial,
                                        'videochannel' => $filterrr->videochannel,
                                        'poeports' => $filterrr->poeports,
                                        'poetype' => $filterrr->poetype,
                                        'sataports' => $filterrr->sataports,
                                        'length' => $filterrr->length,
                                        'screensize' => $filterrr->screensize,
                                        'ledtype' => $filterrr->ledtype,
                                        'size' => $filterrr->size,
                                        'lens' => $filterrr->lens,
                                        'night_vision' => $filterrr->night_vision,
                                        'audio_type' => $filterrr->audio_type,
                                    );
                                    //  array_push($content, $send);
                                }
                            }
                        }
                        if (!empty($audio_type_info[0])) {
                            foreach ($audio_type_info as $data15) {
                                if ($filterrr->audio_type == $data15) {
                                    //    $send = [];
                                    $send[] = array(
                                        'product_id' => $filterrr->id,
                                        'product_name' => $filterrr->productname,
                                        'product_image' => base_url() . $filterrr->image,
                                        'productdescription' => $filterrr->productdescription,
                                        'price' => $filterrr->sellingprice,
                                        'max' => $filterrr->max,
                                        't2_price' => $filterrr->t2_price,
                                        't2_min' => $filterrr->t2_min,
                                        't2_max' => $filterrr->t2_max,
                                        'stock' => $stock,
                                        'brand' => $filterrr->brand,
                                        'resolution' => $filterrr->resolution,
                                        'irdistance' => $filterrr->irdistance,
                                        'cameratype' => $filterrr->cameratype,
                                        'bodymaterial' => $filterrr->bodymaterial,
                                        'videochannel' => $filterrr->videochannel,
                                        'poeports' => $filterrr->poeports,
                                        'poetype' => $filterrr->poetype,
                                        'sataports' => $filterrr->sataports,
                                        'length' => $filterrr->length,
                                        'screensize' => $filterrr->screensize,
                                        'ledtype' => $filterrr->ledtype,
                                        'size' => $filterrr->size,
                                        'lens' => $filterrr->lens,
                                        'night_vision' => $filterrr->night_vision,
                                        'audio_type' => $filterrr->audio_type,
                                    );
                                    //  array_push($content, $send);
                                }
                            }
                        }
                    }
                }
                // array_unique($content);
                // print_r($brand_info);exit;
                $content = [];
                //   $content = array('product_id'=>0);
                $count = 0;
                // print_r($send);die();
                foreach ($send as $object) {
                    // echo $object['product_name'];
                    $array_brand_approved = 0;
                    $array_resolution_approved = 0;
                    $array_irdistance_approved = 0;
                    $array_cameratype_approved = 0;
                    $array_bodymaterial_approved = 0;
                    $array_videochannel_approved = 0;
                    $array_poeports_approved = 0;
                    $array_poetype_approved = 0;
                    $array_sataports_approved = 0;
                    $array_length_approved = 0;
                    $array_screensize_approved = 0;
                    $array_ledtype_approved = 0;
                    $array_size_approved = 0;
                    $array_lens_approved = 0;
                    $array_night_vision_approved = 0;
                    $array_audio_type_approved = 0;
                    if (!empty($brand_info[0])) {
                        foreach ($brand_info as $brand_check) {
                            // echo $brand_check;die();
                            if ($object['brand'] == $brand_check) {
                                $array_brand_approved = 1;
                            }
                        }
                    } else {
                        $array_brand_approved = 1;
                    }
                    if (!empty($resolution_info[0])) {
                        foreach ($resolution_info as $resolution_check) {
                            if ($object['resolution'] == $resolution_check) {
                                $array_resolution_approved = 1;
                            }
                        }
                    } else {
                        $array_resolution_approved = 1;
                    }
                    if (!empty($irdistance_info[0])) {
                        foreach ($irdistance_info as $irdistance_check) {
                            if ($object['irdistance'] == $irdistance_check) {
                                $array_irdistance_approved = 1;
                            }
                        }
                    } else {
                        $array_irdistance_approved = 1;
                    }
                    if (!empty($cameratype_info[0])) {
                        foreach ($cameratype_info as $cameratype_check) {
                            if ($object['cameratype'] == $cameratype_check) {
                                $array_cameratype_approved = 1;
                            }
                        }
                    } else {
                        $array_cameratype_approved = 1;
                    }
                    if (!empty($bodymaterial_info[0])) {
                        foreach ($bodymaterial_info as $bodymaterial_check) {
                            if ($object['bodymaterial'] == $bodymaterial_check) {
                                $array_bodymaterial_approved = 1;
                            }
                        }
                    } else {
                        $array_bodymaterial_approved = 1;
                    }
                    if (!empty($videochannel_info[0])) {
                        foreach ($videochannel_info as $videochannel_check) {
                            if ($object['videochannel'] == $videochannel_check) {
                                $array_videochannel_approved = 1;
                            }
                        }
                    } else {
                        $array_videochannel_approved = 1;
                    }
                    if (!empty($poeports_info[0])) {
                        foreach ($poeports_info as $poeports_check) {
                            if ($object['poeports'] == $poeports_check) {
                                $array_poeports_approved = 1;
                            }
                        }
                    } else {
                        $array_poeports_approved = 1;
                    }
                    if (!empty($poetype_info[0])) {
                        foreach ($poetype_info as $poetype_check) {
                            if ($object['poetype'] == $poetype_check) {
                                $array_poetype_approved = 1;
                            }
                        }
                    } else {
                        $array_poetype_approved = 1;
                    }
                    if (!empty($sataports_info[0])) {
                        foreach ($sataports_info as $sataports_check) {
                            if ($object['sataports'] == $sataports_check) {
                                $array_sataports_approved = 1;
                            }
                        }
                    } else {
                        $array_sataports_approved = 1;
                    }
                    if (!empty($length_info[0])) {
                        foreach ($length_info as $length_check) {
                            if ($object['length'] == $length_check) {
                                $array_length_approved = 1;
                            }
                        }
                    } else {
                        $array_length_approved = 1;
                    }
                    if (!empty($screensize_info[0])) {
                        foreach ($screensize_info as $screensize_check) {
                            if ($object['screensize'] == $screensize_check) {
                                $array_screensize_approved = 1;
                            }
                        }
                    } else {
                        $array_screensize_approved = 1;
                    }
                    if (!empty($ledtype_info[0])) {
                        foreach ($ledtype_info as $ledtype_check) {
                            if ($object['ledtype'] == $ledtype_check) {
                                $array_ledtype_approved = 1;
                            }
                        }
                    } else {
                        $array_ledtype_approved = 1;
                    }
                    if (!empty($size_info[0])) {
                        foreach ($size_info as $size_check) {
                            if ($object['size'] == $size_check) {
                                $array_size_approved = 1;
                            }
                        }
                    } else {
                        $array_size_approved = 1;
                    }
                    if (!empty($lens_info[0])) {
                        foreach ($lens_info as $lens_check) {
                            if ($object['lens'] == $lens_check) {
                                $array_lens_approved = 1;
                            }
                        }
                    } else {
                        $array_lens_approved = 1;
                    }
                    if (!empty($night_vision_info[0])) {
                        foreach ($night_vision_info as $night_vision_check) {
                            if ($object['screensize'] == $night_vision_check) {
                                $array_night_vision_approved = 1;
                            }
                        }
                    } else {
                        $array_night_vision_approved = 1;
                    }
                    if (!empty($audio_type_info[0])) {
                        foreach ($audio_type_info as $audio_type_check) {
                            if ($object['ledtype'] == $audio_type_check) {
                                $array_audio_type_approved = 1;
                            }
                        }
                    } else {
                        $array_audio_type_approved = 1;
                    }
                    if ($array_brand_approved == 1 && $array_resolution_approved == 1 && $array_irdistance_approved == 1 && $array_cameratype_approved == 1 && $array_bodymaterial_approved == 1 && $array_videochannel_approved == 1 && $array_poeports_approved == 1 && $array_poetype_approved == 1 && $array_sataports_approved == 1 && $array_length_approved == 1 && $array_screensize_approved == 1 && $array_ledtype_approved == 1 && $array_size_approved == 1 && $array_lens_approved == 1 && $array_night_vision_approved == 1) {
                        $a = 0;
                        if ($count == 0) {
                            $content[] = array(
                                'product_id' => $object['product_id'],
                                'product_name' => $object['product_name'],
                                'product_image' => $object['product_image'],
                                'productdescription' => $object['productdescription'],
                                'max' => $object['max'],
                                't2_price' => $object['t2_price'],
                                't2_min' => $object['t2_min'],
                                't2_max' => $object['t2_max'],
                                'price' => $object['price'],
                                'stock' => $object['stock']
                            );
                        } else {
                            // print_r($content);
                            foreach ($content as $pushin) {
                                // echo $object['product_id']."-----------".$pushin['product_id']."<br />";
                                if ($pushin['product_id'] == $object['product_id']) {
                                    // echo "ji";
                                    $a = 1;
                                }
                            }
                            if ($a == 0) {
                                $content[] = array(
                                    'product_id' => $object['product_id'],
                                    'product_name' => $object['product_name'],
                                    'product_image' => $object['product_image'],
                                    'productdescription' => $object['productdescription'],
                                    'max' => $object['max'],
                                    't2_price' => $object['t2_price'],
                                    't2_min' => $object['t2_min'],
                                    't2_max' => $object['t2_max'],
                                    'price' => $object['price'],
                                    'stock' => $object['stock']
                                );
                            }
                        }
                        $count++;
                    }
                }
                // echo $count;die();
                header('Access-Control-Allow-Origin: *');
                $res = array(
                    'message' => 'success',
                    'status' => 200,
                    'data' => $content,
                );
                echo json_encode($res);
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
                'message' => 'No data available',
                'status' => 201
            );
            echo json_encode($res);
        }
    }
    public function filter_products()
    {
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->helper('security');
        if ($this->input->post()) {
            $this->form_validation->set_rules('brand_id', 'brand_id', 'xss_clean|trim');
            $this->form_validation->set_rules('resolution_id', 'resolution_id', 'xss_clean|trim');
            $this->form_validation->set_rules('irdistance_id', 'irdistance_id', 'xss_clean|trim');
            $this->form_validation->set_rules('cameratype_id', 'cameratype_id', 'xss_clean|trim');
            $this->form_validation->set_rules('bodymaterial_id', 'bodymaterial_id', 'xss_clean|trim');
            $this->form_validation->set_rules('videochannel_id', 'videochannel_id', 'xss_clean|trim');
            $this->form_validation->set_rules('poeports_id', 'poeports_id', 'xss_clean|trim');
            $this->form_validation->set_rules('poetype_id', 'poetype_id', 'xss_clean|trim');
            $this->form_validation->set_rules('sataports_id', 'sataports_id', 'xss_clean|trim');
            $this->form_validation->set_rules('length_id', 'length_id', 'xss_clean|trim');
            $this->form_validation->set_rules('screensize_id', 'screensize_id', 'xss_clean|trim');
            $this->form_validation->set_rules('ledtype_id', 'ledtype_id', 'xss_clean|trim');
            $this->form_validation->set_rules('size_id', 'size_id', 'xss_clean|trim');
            $this->form_validation->set_rules('lens_id', 'lens_id', 'xss_clean|trim');
            $this->form_validation->set_rules('night_vision_id', 'night_vision_id', 'xss_clean|trim');
            $this->form_validation->set_rules('audio_type_id', 'audio_type_id', 'xss_clean|trim');
            $this->form_validation->set_rules('minorcategory_id', 'minorcategory_id', 'required|xss_clean|trim');
            if ($this->form_validation->run() == true) {
                $minorcategory_id = $this->input->post('minorcategory_id');
                $brand_id = $this->input->post('brand_id');
                $resolution_id = $this->input->post('resolution_id');
                $irdistance_id = $this->input->post('irdistance_id');
                $cameratype_id = $this->input->post('cameratype_id');
                $bodymaterial_id = $this->input->post('bodymaterial_id');
                $videochannel_id = $this->input->post('videochannel_id');
                $poeports_id = $this->input->post('poeports_id');
                $poetype_id = $this->input->post('poetype_id');
                $sataports_id = $this->input->post('sataports_id');
                $length_id = $this->input->post('length_id');
                $screensize_id = $this->input->post('screensize_id');
                $ledtype_id = $this->input->post('ledtype_id');
                $size_id = $this->input->post('size_id');
                $lens_id = $this->input->post('lens_id');
                $night_vision_id = $this->input->post('night_vision_id');
                $audio_type_id = $this->input->post('audio_type_id');
                $brand_info = explode(',', $brand_id);
                $resolution_info = explode(',', $resolution_id);
                $irdistance_info = explode(',', $irdistance_id);
                $cameratype_info = explode(',', $cameratype_id);
                $bodymaterial_info = explode(',', $bodymaterial_id);
                $videochannel_info = explode(',', $videochannel_id);
                $poeports_info = explode(',', $poeports_id);
                $poetype_info = explode(',', $poetype_id);
                $sataports_info = explode(',', $sataports_id);
                $length_info = explode(',', $length_id);
                $screensize_info = explode(',', $screensize_id);
                $ledtype_info = explode(',', $ledtype_id);
                $size_info = explode(',', $size_id);
                $lens_info = explode(',', $lens_id);
                $night_vision_info = explode(',', $night_vision_id);
                $audio_type_info = explode(',', $audio_type_id);
                $this->db->select('*');
                $this->db->from('tbl_products');
                $this->db->where('is_active', 1);
                $this->db->where('minorcategory_id', $minorcategory_id);
                $this->db->group_start();
                foreach ($videochannel_info as $f4) {
                    if (!empty($brand_info[0])) {
                        foreach ($brand_info as $f1) {
                            $this->db->where('brand', $f1, NULL, FALSE);
                        }
                    }
                    if (!empty($resolution_info[0])) {
                        foreach ($resolution_info as $f2) {
                            $this->db->where('resolution', $f2, NULL, FALSE);
                        }
                    }
                    // if (!empty($irdistance_info[0])) {
                    //     foreach ($irdistance_info as $f3) {
                    //         $this->db->or_where('irdistance', $f3, NULL, FALSE);
                    //     }
                    // }
                    // if (!empty($cameratype_info[0])) {
                    //     foreach ($cameratype_info as $f33) {
                    //         $this->db->or_where('cameratype', $f33, NULL, FALSE);
                    //     }
                    // }
                    // if (!empty($bodymaterial_info[0])) {
                    //     foreach ($bodymaterial_info as $f44) {
                    //         $this->db->or_where('bodymaterial', $f44, NULL, FALSE);
                    //     }
                    // }
                    if (!empty($videochannel_info[0])) {
                        $this->db->where('videochannel', $f4, NULL, FALSE);
                    }
                }
                // if (!empty($poeports_info[0])) {
                //     foreach ($poeports_info as $f5) {
                //         $this->db->or_where('poeports', $f5, NULL, FALSE);
                //     }
                // }
                // if (!empty($poetype_info[0])) {
                //     foreach ($poetype_info as $f6) {
                //         $this->db->or_where('poetype', $f6, NULL, FALSE);
                //     }
                // }
                // if (!empty($sataports_info[0])) {
                //     foreach ($sataports_info as $f7) {
                //         $this->db->or_where('sataports', $f7, NULL, FALSE);
                //     }
                // }
                // if (!empty($length_info[0])) {
                //     foreach ($length_info as $f8) {
                //         $this->db->or_where('length', $f8, NULL, FALSE);
                //     }
                // }
                // if (!empty($screensize_info[0])) {
                //     foreach ($screensize as $f9) {
                //         $this->db->or_where('screensize', $f9, NULL, FALSE);
                //     }
                // }
                // if (!empty($ledtype_info[0])) {
                //     foreach ($ledtype_info as $f10) {
                //         $this->db->or_where('ledtype', $f10, NULL, FALSE);
                //     }
                // }
                // if (!empty($size_info[0])) {
                //     foreach ($size_info as $f11) {
                //         $this->db->or_where('size', $f11, NULL, FALSE);
                //     }
                // }
                // if (!empty($lens_info[0])) {
                //     foreach ($lens_info as $f12) {
                //         $this->db->or_where('lens', $f12, NULL, FALSE);
                //     }
                // }
                // if (!empty($night_vision_info[0])) {
                //     foreach ($night_vision_info as $f13) {
                //         $this->db->or_where('night_vision', $f13, NULL, FALSE);
                //     }
                // }
                // if (!empty($audio_type_info[0])) {
                //     foreach ($audio_type_info as $f14) {
                //         $this->db->or_where('audio_type', $f14, NULL, FALSE);
                //     }
                // }
                $this->db->group_end();
                $filter_data = $this->db->get();
                $filter_check = $filter_data->row();
                $final_filter = [];
                foreach ($filter_data->result() as $filter) {
                    print_r($filter);
                }
                die();
                // echo $count;die();
                header('Access-Control-Allow-Origin: *');
                $res = array(
                    'message' => 'success',
                    'status' => 200,
                    // 'data' => $content
                );
                echo json_encode($res);
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
                'message' => 'No data available',
                'status' => 201
            );
            echo json_encode($res);
        }
    }
    //------------filter-----
    public function filter_new()
    {
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->helper('security');
        if ($this->input->post()) {
            $this->form_validation->set_rules('brand_id', 'brand_id', 'xss_clean|trim');
            $this->form_validation->set_rules('resolution_id', 'resolution_id', 'xss_clean|trim');
            $this->form_validation->set_rules('irdistance_id', 'irdistance_id', 'xss_clean|trim');
            $this->form_validation->set_rules('cameratype_id', 'cameratype_id', 'xss_clean|trim');
            $this->form_validation->set_rules('bodymaterial_id', 'bodymaterial_id', 'xss_clean|trim');
            $this->form_validation->set_rules('videochannel_id', 'videochannel_id', 'xss_clean|trim');
            $this->form_validation->set_rules('poeports_id', 'poeports_id', 'xss_clean|trim');
            $this->form_validation->set_rules('poetype_id', 'poetype_id', 'xss_clean|trim');
            $this->form_validation->set_rules('sataports_id', 'sataports_id', 'xss_clean|trim');
            $this->form_validation->set_rules('length_id', 'length_id', 'xss_clean|trim');
            $this->form_validation->set_rules('screensize_id', 'screensize_id', 'xss_clean|trim');
            $this->form_validation->set_rules('ledtype_id', 'ledtype_id', 'xss_clean|trim');
            $this->form_validation->set_rules('size_id', 'size_id', 'xss_clean|trim');
            $this->form_validation->set_rules('lens_id', 'lens_id', 'xss_clean|trim');
            $this->form_validation->set_rules('night_vision_id', 'night_vision_id', 'xss_clean|trim');
            $this->form_validation->set_rules('audio_type_id', 'audio_type_id', 'xss_clean|trim');
            $this->form_validation->set_rules('minorcategory_id', 'minorcategory_id', 'required|xss_clean|trim');
            $this->form_validation->set_rules('phone', 'phone', 'xss_clean|trim');
            $this->form_validation->set_rules('authentication', 'authentication', 'xss_clean|trim');
            if ($this->form_validation->run() == true) {
                $phone = $this->input->post('phone');
                $authentication = $this->input->post('authentication');
                $minorcategory_id = $this->input->post('minorcategory_id');
                $brand_id = $this->input->post('brand_id');
                $resolution_id = $this->input->post('resolution_id');
                $irdistance_id = $this->input->post('irdistance_id');
                $cameratype_id = $this->input->post('cameratype_id');
                $bodymaterial_id = $this->input->post('bodymaterial_id');
                $videochannel_id = $this->input->post('videochannel_id');
                $poeports_id = $this->input->post('poeports_id');
                $poetype_id = $this->input->post('poetype_id');
                $sataports_id = $this->input->post('sataports_id');
                $length_id = $this->input->post('length_id');
                $screensize_id = $this->input->post('screensize_id');
                $ledtype_id = $this->input->post('ledtype_id');
                $size_id = $this->input->post('size_id');
                $lens_id = $this->input->post('lens_id');
                $night_vision_id = $this->input->post('night_vision_id');
                $audio_type_id = $this->input->post('audio_type_id');
                $brand_info = explode(',', $brand_id);
                $resolution_info = explode(',', $resolution_id);
                $irdistance_info = explode(',', $irdistance_id);
                $cameratype_info = explode(',', $cameratype_id);
                $bodymaterial_info = explode(',', $bodymaterial_id);
                $videochannel_info = explode(',', $videochannel_id);
                $poeports_info = explode(',', $poeports_id);
                $poetype_info = explode(',', $poetype_id);
                $sataports_info = explode(',', $sataports_id);
                $length_info = explode(',', $length_id);
                $screensize_info = explode(',', $screensize_id);
                $ledtype_info = explode(',', $ledtype_id);
                $size_info = explode(',', $size_id);
                $lens_info = explode(',', $lens_id);
                $night_vision_info = explode(',', $night_vision_id);
                $audio_type_info = explode(',', $audio_type_id);
                // die();
                $T2 = 0;
                if (!empty($phone)) {
                    $this->db->select('*');
                    $this->db->from('tbl_users');
                    $this->db->where('phone', $phone);
                    $check_email = $this->db->get();
                    $check_id = $check_email->row();
                    if (!empty($check_id)) {
                        if ($check_id->authentication == $authentication) {
                            if ($check_id->type == "T2") {
                                $T2 = 1;
                            }
                        }
                    }
                }
                $this->db->select('*');
                $this->db->from('tbl_products');
                $this->db->where('is_active', 1);
                $this->db->where('minorcategory_id', $minorcategory_id);
                $filter_data = $this->db->get();
                $filter_check = $filter_data->row();
                $final_filter = [];
                foreach ($filter_data->result() as $filterrr) {
                    if ($filterrr->is_active == 1) {
                        $this->db->select('*');
                        $this->db->from('tbl_inventory');
                        $this->db->where('product_id', $filterrr->id);
                        $inventory_data = $this->db->get()->row();
                        if (!empty($inventory_data)) {
                            if ($inventory_data->quantity > 0) {
                                $stock = 1;
                            } else {
                                $stock = 0;
                            }
                        } else {
                            $stock = 0;
                        }
                        //------- brand wise filter ----------------
                        if (!empty($brand_info[0])) {
                            foreach ($brand_info as $data0) {
                                if ($filterrr->brand == $data0) {
                                    $final_filter[] = array(
                                        'product_id' => $filterrr->id,
                                        'product_name' => $filterrr->productname,
                                        'product_image' => $filterrr->image,
                                        'productdescription' => $filterrr->productdescription,
                                        'price' => $filterrr->sellingprice,
                                        'max' => $filterrr->max,
                                        't2_price' => $filterrr->t2_price,
                                        't2_min' => $filterrr->t2_min,
                                        't2_max' => $filterrr->t2_max,
                                        'stock' => $stock,
                                        'brand' => $filterrr->brand,
                                        'resolution' => $filterrr->resolution,
                                        'irdistance' => $filterrr->irdistance,
                                        'cameratype' => $filterrr->cameratype,
                                        'bodymaterial' => $filterrr->bodymaterial,
                                        'videochannel' => $filterrr->videochannel,
                                        'poeports' => $filterrr->poeports,
                                        'poetype' => $filterrr->poetype,
                                        'sataports' => $filterrr->sataports,
                                        'length' => $filterrr->length,
                                        'screensize' => $filterrr->screensize,
                                        'ledtype' => $filterrr->ledtype,
                                        'size' => $filterrr->size,
                                        'lens' => $filterrr->lens,
                                        'night_vision' => $filterrr->night_vision,
                                        'audio_type' => $filterrr->audio_type,
                                    );
                                }
                            }
                        }
                        //------- without brand wise filter ----------------
                        else {
                            $final_filter[] = array(
                                'product_id' => $filterrr->id,
                                'product_name' => $filterrr->productname,
                                'product_image' => $filterrr->image,
                                'productdescription' => $filterrr->productdescription,
                                'price' => $filterrr->sellingprice,
                                'max' => $filterrr->max,
                                't2_price' => $filterrr->t2_price,
                                't2_min' => $filterrr->t2_min,
                                't2_max' => $filterrr->t2_max,
                                'stock' => $stock,
                                'brand' => $filterrr->brand,
                                'resolution' => $filterrr->resolution,
                                'irdistance' => $filterrr->irdistance,
                                'cameratype' => $filterrr->cameratype,
                                'bodymaterial' => $filterrr->bodymaterial,
                                'videochannel' => $filterrr->videochannel,
                                'poeports' => $filterrr->poeports,
                                'poetype' => $filterrr->poetype,
                                'sataports' => $filterrr->sataports,
                                'length' => $filterrr->length,
                                'screensize' => $filterrr->screensize,
                                'ledtype' => $filterrr->ledtype,
                                'size' => $filterrr->size,
                                'lens' => $filterrr->lens,
                                'night_vision' => $filterrr->night_vision,
                                'audio_type' => $filterrr->audio_type,
                            );
                        }
                    }
                }
                //--- filter other data ----
                foreach ($final_filter as $filterrr) {
                    if (!empty($resolution_info[0])) {
                        foreach ($resolution_info as $data1) {
                            if ($filterrr['resolution'] == $data1) {
                                $send[] = array(
                                    'product_id' => $filterrr['product_id'],
                                    'product_name' => $filterrr['product_name'],
                                    'product_image' => $filterrr['product_image'],
                                    'productdescription' => $filterrr['productdescription'],
                                    'price' => $filterrr['price'],
                                    'max' => $filterrr['max'],
                                    't2_price' => $filterrr['t2_price'],
                                    't2_min' => $filterrr['t2_min'],
                                    't2_max' => $filterrr['t2_max'],
                                    'stock' => $stock,
                                    'brand' => $filterrr['brand'],
                                    'resolution' => $filterrr['resolution'],
                                    'irdistance' => $filterrr['irdistance'],
                                    'cameratype' => $filterrr['cameratype'],
                                    'bodymaterial' => $filterrr['bodymaterial'],
                                    'videochannel' => $filterrr['videochannel'],
                                    'poeports' => $filterrr['poeports'],
                                    'poetype' => $filterrr['poetype'],
                                    'sataports' => $filterrr['sataports'],
                                    'length' => $filterrr['length'],
                                    'screensize' => $filterrr['screensize'],
                                    'ledtype' => $filterrr['ledtype'],
                                    'size' => $filterrr['size'],
                                    'lens' => $filterrr['lens'],
                                    'night_vision' => $filterrr['night_vision'],
                                    'audio_type' => $filterrr['audio_type'],
                                );
                            }
                        }
                    }
                    if (!empty($irdistance_info[0])) {
                        foreach ($irdistance_info as $data2) {
                            if ($filterrr['irdistance'] == $data2) {
                                $send[] = array(
                                    'product_id' => $filterrr['product_id'],
                                    'product_name' => $filterrr['product_name'],
                                    'product_image' => $filterrr['product_image'],
                                    'productdescription' => $filterrr['productdescription'],
                                    'price' => $filterrr['price'],
                                    'max' => $filterrr['max'],
                                    't2_price' => $filterrr['t2_price'],
                                    't2_min' => $filterrr['t2_min'],
                                    't2_max' => $filterrr['t2_max'],
                                    'stock' => $stock,
                                    'brand' => $filterrr['brand'],
                                    'resolution' => $filterrr['resolution'],
                                    'irdistance' => $filterrr['irdistance'],
                                    'cameratype' => $filterrr['cameratype'],
                                    'bodymaterial' => $filterrr['bodymaterial'],
                                    'videochannel' => $filterrr['videochannel'],
                                    'poeports' => $filterrr['poeports'],
                                    'poetype' => $filterrr['poetype'],
                                    'sataports' => $filterrr['sataports'],
                                    'length' => $filterrr['length'],
                                    'screensize' => $filterrr['screensize'],
                                    'ledtype' => $filterrr['ledtype'],
                                    'size' => $filterrr['size'],
                                    'lens' => $filterrr['lens'],
                                    'night_vision' => $filterrr['night_vision'],
                                    'audio_type' => $filterrr['audio_type'],
                                );
                            }
                        }
                    }
                    if (!empty($cameratype_info[0])) {
                        foreach ($cameratype_info as $data3) {
                            if ($filterrr['cameratype'] == $data3) {
                                $send[] = array(
                                    'product_id' => $filterrr['product_id'],
                                    'product_name' => $filterrr['product_name'],
                                    'product_image' => $filterrr['product_image'],
                                    'productdescription' => $filterrr['productdescription'],
                                    'price' => $filterrr['price'],
                                    'max' => $filterrr['max'],
                                    't2_price' => $filterrr['t2_price'],
                                    't2_min' => $filterrr['t2_min'],
                                    't2_max' => $filterrr['t2_max'],
                                    'stock' => $stock,
                                    'brand' => $filterrr['brand'],
                                    'resolution' => $filterrr['resolution'],
                                    'irdistance' => $filterrr['irdistance'],
                                    'cameratype' => $filterrr['cameratype'],
                                    'bodymaterial' => $filterrr['bodymaterial'],
                                    'videochannel' => $filterrr['videochannel'],
                                    'poeports' => $filterrr['poeports'],
                                    'poetype' => $filterrr['poetype'],
                                    'sataports' => $filterrr['sataports'],
                                    'length' => $filterrr['length'],
                                    'screensize' => $filterrr['screensize'],
                                    'ledtype' => $filterrr['ledtype'],
                                    'size' => $filterrr['size'],
                                    'lens' => $filterrr['lens'],
                                    'night_vision' => $filterrr['night_vision'],
                                    'audio_type' => $filterrr['audio_type'],
                                );
                            }
                        }
                    }
                    if (!empty($bodymaterial_info[0])) {
                        foreach ($bodymaterial_info as $data4) {
                            if ($filterrr['bodymaterial'] == $data4) {
                                $send[] = array(
                                    'product_id' => $filterrr['product_id'],
                                    'product_name' => $filterrr['product_name'],
                                    'product_image' => $filterrr['product_image'],
                                    'productdescription' => $filterrr['productdescription'],
                                    'price' => $filterrr['price'],
                                    'max' => $filterrr['max'],
                                    't2_price' => $filterrr['t2_price'],
                                    't2_min' => $filterrr['t2_min'],
                                    't2_max' => $filterrr['t2_max'],
                                    'stock' => $stock,
                                    'brand' => $filterrr['brand'],
                                    'resolution' => $filterrr['resolution'],
                                    'irdistance' => $filterrr['irdistance'],
                                    'cameratype' => $filterrr['cameratype'],
                                    'bodymaterial' => $filterrr['bodymaterial'],
                                    'videochannel' => $filterrr['videochannel'],
                                    'poeports' => $filterrr['poeports'],
                                    'poetype' => $filterrr['poetype'],
                                    'sataports' => $filterrr['sataports'],
                                    'length' => $filterrr['length'],
                                    'screensize' => $filterrr['screensize'],
                                    'ledtype' => $filterrr['ledtype'],
                                    'size' => $filterrr['size'],
                                    'lens' => $filterrr['lens'],
                                    'night_vision' => $filterrr['night_vision'],
                                    'audio_type' => $filterrr['audio_type'],
                                );
                            }
                        }
                    }
                    if (!empty($videochannel_info[0])) {
                        foreach ($videochannel_info as $data5) {
                            if ($filterrr['videochannel'] == $data5) {
                                $send[] = array(
                                    'product_id' => $filterrr['product_id'],
                                    'product_name' => $filterrr['product_name'],
                                    'product_image' => $filterrr['product_image'],
                                    'productdescription' => $filterrr['productdescription'],
                                    'price' => $filterrr['price'],
                                    'max' => $filterrr['max'],
                                    't2_price' => $filterrr['t2_price'],
                                    't2_min' => $filterrr['t2_min'],
                                    't2_max' => $filterrr['t2_max'],
                                    'stock' => $stock,
                                    'brand' => $filterrr['brand'],
                                    'resolution' => $filterrr['resolution'],
                                    'irdistance' => $filterrr['irdistance'],
                                    'cameratype' => $filterrr['cameratype'],
                                    'bodymaterial' => $filterrr['bodymaterial'],
                                    'videochannel' => $filterrr['videochannel'],
                                    'poeports' => $filterrr['poeports'],
                                    'poetype' => $filterrr['poetype'],
                                    'sataports' => $filterrr['sataports'],
                                    'length' => $filterrr['length'],
                                    'screensize' => $filterrr['screensize'],
                                    'ledtype' => $filterrr['ledtype'],
                                    'size' => $filterrr['size'],
                                    'lens' => $filterrr['lens'],
                                    'night_vision' => $filterrr['night_vision'],
                                    'audio_type' => $filterrr['audio_type'],
                                );
                            }
                        }
                    }
                    if (!empty($poeports_info[0])) {
                        foreach ($poeports_info as $data6) {
                            if ($filterrr['poeports'] == $data6) {
                                $send[] = array(
                                    'product_id' => $filterrr['product_id'],
                                    'product_name' => $filterrr['product_name'],
                                    'product_image' => $filterrr['product_image'],
                                    'productdescription' => $filterrr['productdescription'],
                                    'price' => $filterrr['price'],
                                    'max' => $filterrr['max'],
                                    't2_price' => $filterrr['t2_price'],
                                    't2_min' => $filterrr['t2_min'],
                                    't2_max' => $filterrr['t2_max'],
                                    'stock' => $stock,
                                    'brand' => $filterrr['brand'],
                                    'resolution' => $filterrr['resolution'],
                                    'irdistance' => $filterrr['irdistance'],
                                    'cameratype' => $filterrr['cameratype'],
                                    'bodymaterial' => $filterrr['bodymaterial'],
                                    'videochannel' => $filterrr['videochannel'],
                                    'poeports' => $filterrr['poeports'],
                                    'poetype' => $filterrr['poetype'],
                                    'sataports' => $filterrr['sataports'],
                                    'length' => $filterrr['length'],
                                    'screensize' => $filterrr['screensize'],
                                    'ledtype' => $filterrr['ledtype'],
                                    'size' => $filterrr['size'],
                                    'lens' => $filterrr['lens'],
                                    'night_vision' => $filterrr['night_vision'],
                                    'audio_type' => $filterrr['audio_type'],
                                );
                            }
                        }
                    }
                    if (!empty($poetype_info[0])) {
                        foreach ($poetype_info as $data7) {
                            if ($filterrr['poetype'] == $data7) {
                                $send[] = array(
                                    'product_id' => $filterrr['product_id'],
                                    'product_name' => $filterrr['product_name'],
                                    'product_image' => $filterrr['product_image'],
                                    'productdescription' => $filterrr['productdescription'],
                                    'price' => $filterrr['price'],
                                    'max' => $filterrr['max'],
                                    't2_price' => $filterrr['t2_price'],
                                    't2_min' => $filterrr['t2_min'],
                                    't2_max' => $filterrr['t2_max'],
                                    'stock' => $stock,
                                    'brand' => $filterrr['brand'],
                                    'resolution' => $filterrr['resolution'],
                                    'irdistance' => $filterrr['irdistance'],
                                    'cameratype' => $filterrr['cameratype'],
                                    'bodymaterial' => $filterrr['bodymaterial'],
                                    'videochannel' => $filterrr['videochannel'],
                                    'poeports' => $filterrr['poeports'],
                                    'poetype' => $filterrr['poetype'],
                                    'sataports' => $filterrr['sataports'],
                                    'length' => $filterrr['length'],
                                    'screensize' => $filterrr['screensize'],
                                    'ledtype' => $filterrr['ledtype'],
                                    'size' => $filterrr['size'],
                                    'lens' => $filterrr['lens'],
                                    'night_vision' => $filterrr['night_vision'],
                                    'audio_type' => $filterrr['audio_type'],
                                );
                            }
                        }
                    }
                    if (!empty($sataports_info[0])) {
                        foreach ($sataports_info as $data8) {
                            if ($filterrr['sataports'] == $data8) {
                                $send[] = array(
                                    'product_id' => $filterrr['product_id'],
                                    'product_name' => $filterrr['product_name'],
                                    'product_image' => $filterrr['product_image'],
                                    'productdescription' => $filterrr['productdescription'],
                                    'price' => $filterrr['price'],
                                    'max' => $filterrr['max'],
                                    't2_price' => $filterrr['t2_price'],
                                    't2_min' => $filterrr['t2_min'],
                                    't2_max' => $filterrr['t2_max'],
                                    'stock' => $stock,
                                    'brand' => $filterrr['brand'],
                                    'resolution' => $filterrr['resolution'],
                                    'irdistance' => $filterrr['irdistance'],
                                    'cameratype' => $filterrr['cameratype'],
                                    'bodymaterial' => $filterrr['bodymaterial'],
                                    'videochannel' => $filterrr['videochannel'],
                                    'poeports' => $filterrr['poeports'],
                                    'poetype' => $filterrr['poetype'],
                                    'sataports' => $filterrr['sataports'],
                                    'length' => $filterrr['length'],
                                    'screensize' => $filterrr['screensize'],
                                    'ledtype' => $filterrr['ledtype'],
                                    'size' => $filterrr['size'],
                                    'lens' => $filterrr['lens'],
                                    'night_vision' => $filterrr['night_vision'],
                                    'audio_type' => $filterrr['audio_type'],
                                );
                            }
                        }
                    }
                    if (!empty($length_info[0])) {
                        foreach ($length_info as $data9) {
                            if ($filterrr['length'] == $data9) {
                                $send[] = array(
                                    'product_id' => $filterrr['product_id'],
                                    'product_name' => $filterrr['product_name'],
                                    'product_image' => $filterrr['product_image'],
                                    'productdescription' => $filterrr['productdescription'],
                                    'price' => $filterrr['price'],
                                    'max' => $filterrr['max'],
                                    't2_price' => $filterrr['t2_price'],
                                    't2_min' => $filterrr['t2_min'],
                                    't2_max' => $filterrr['t2_max'],
                                    'stock' => $stock,
                                    'brand' => $filterrr['brand'],
                                    'resolution' => $filterrr['resolution'],
                                    'irdistance' => $filterrr['irdistance'],
                                    'cameratype' => $filterrr['cameratype'],
                                    'bodymaterial' => $filterrr['bodymaterial'],
                                    'videochannel' => $filterrr['videochannel'],
                                    'poeports' => $filterrr['poeports'],
                                    'poetype' => $filterrr['poetype'],
                                    'sataports' => $filterrr['sataports'],
                                    'length' => $filterrr['length'],
                                    'screensize' => $filterrr['screensize'],
                                    'ledtype' => $filterrr['ledtype'],
                                    'size' => $filterrr['size'],
                                    'lens' => $filterrr['lens'],
                                    'night_vision' => $filterrr['night_vision'],
                                    'audio_type' => $filterrr['audio_type'],
                                );
                            }
                        }
                    }
                    if (!empty($screensize_info[0])) {
                        foreach ($screensize_info as $data10) {
                            if ($filterrr['screensize'] == $data10) {
                                $send[] = array(
                                    'product_id' => $filterrr['product_id'],
                                    'product_name' => $filterrr['product_name'],
                                    'product_image' => $filterrr['product_image'],
                                    'productdescription' => $filterrr['productdescription'],
                                    'price' => $filterrr['price'],
                                    'max' => $filterrr['max'],
                                    't2_price' => $filterrr['t2_price'],
                                    't2_min' => $filterrr['t2_min'],
                                    't2_max' => $filterrr['t2_max'],
                                    'stock' => $stock,
                                    'brand' => $filterrr['brand'],
                                    'resolution' => $filterrr['resolution'],
                                    'irdistance' => $filterrr['irdistance'],
                                    'cameratype' => $filterrr['cameratype'],
                                    'bodymaterial' => $filterrr['bodymaterial'],
                                    'videochannel' => $filterrr['videochannel'],
                                    'poeports' => $filterrr['poeports'],
                                    'poetype' => $filterrr['poetype'],
                                    'sataports' => $filterrr['sataports'],
                                    'length' => $filterrr['length'],
                                    'screensize' => $filterrr['screensize'],
                                    'ledtype' => $filterrr['ledtype'],
                                    'size' => $filterrr['size'],
                                    'lens' => $filterrr['lens'],
                                    'night_vision' => $filterrr['night_vision'],
                                    'audio_type' => $filterrr['audio_type'],
                                );
                            }
                        }
                    }
                    if (!empty($ledtype_info[0])) {
                        foreach ($ledtype_info as $data11) {
                            if ($filterrr['ledtype'] == $data11) {
                                $send[] = array(
                                    'product_id' => $filterrr['product_id'],
                                    'product_name' => $filterrr['product_name'],
                                    'product_image' => $filterrr['product_image'],
                                    'productdescription' => $filterrr['productdescription'],
                                    'price' => $filterrr['price'],
                                    'max' => $filterrr['max'],
                                    't2_price' => $filterrr['t2_price'],
                                    't2_min' => $filterrr['t2_min'],
                                    't2_max' => $filterrr['t2_max'],
                                    'stock' => $stock,
                                    'brand' => $filterrr['brand'],
                                    'resolution' => $filterrr['resolution'],
                                    'irdistance' => $filterrr['irdistance'],
                                    'cameratype' => $filterrr['cameratype'],
                                    'bodymaterial' => $filterrr['bodymaterial'],
                                    'videochannel' => $filterrr['videochannel'],
                                    'poeports' => $filterrr['poeports'],
                                    'poetype' => $filterrr['poetype'],
                                    'sataports' => $filterrr['sataports'],
                                    'length' => $filterrr['length'],
                                    'screensize' => $filterrr['screensize'],
                                    'ledtype' => $filterrr['ledtype'],
                                    'size' => $filterrr['size'],
                                    'lens' => $filterrr['lens'],
                                    'night_vision' => $filterrr['night_vision'],
                                    'audio_type' => $filterrr['audio_type'],
                                );
                            }
                        }
                    }
                    if (!empty($size_info[0])) {
                        foreach ($size_info as $data12) {
                            if ($filterrr['size'] == $data12) {
                                $send[] = array(
                                    'product_id' => $filterrr['product_id'],
                                    'product_name' => $filterrr['product_name'],
                                    'product_image' => $filterrr['product_image'],
                                    'productdescription' => $filterrr['productdescription'],
                                    'price' => $filterrr['price'],
                                    'max' => $filterrr['max'],
                                    't2_price' => $filterrr['t2_price'],
                                    't2_min' => $filterrr['t2_min'],
                                    't2_max' => $filterrr['t2_max'],
                                    'stock' => $stock,
                                    'brand' => $filterrr['brand'],
                                    'resolution' => $filterrr['resolution'],
                                    'irdistance' => $filterrr['irdistance'],
                                    'cameratype' => $filterrr['cameratype'],
                                    'bodymaterial' => $filterrr['bodymaterial'],
                                    'videochannel' => $filterrr['videochannel'],
                                    'poeports' => $filterrr['poeports'],
                                    'poetype' => $filterrr['poetype'],
                                    'sataports' => $filterrr['sataports'],
                                    'length' => $filterrr['length'],
                                    'screensize' => $filterrr['screensize'],
                                    'ledtype' => $filterrr['ledtype'],
                                    'size' => $filterrr['size'],
                                    'lens' => $filterrr['lens'],
                                    'night_vision' => $filterrr['night_vision'],
                                    'audio_type' => $filterrr['audio_type'],
                                );
                            }
                        }
                    }
                    if (!empty($lens_info[0])) {
                        foreach ($lens_info as $data13) {
                            if ($filterrr['lens'] == $data13) {
                                $send[] = array(
                                    'product_id' => $filterrr['product_id'],
                                    'product_name' => $filterrr['product_name'],
                                    'product_image' => $filterrr['product_image'],
                                    'productdescription' => $filterrr['productdescription'],
                                    'price' => $filterrr['price'],
                                    'max' => $filterrr['max'],
                                    't2_price' => $filterrr['t2_price'],
                                    't2_min' => $filterrr['t2_min'],
                                    't2_max' => $filterrr['t2_max'],
                                    'stock' => $stock,
                                    'brand' => $filterrr['brand'],
                                    'resolution' => $filterrr['resolution'],
                                    'irdistance' => $filterrr['irdistance'],
                                    'cameratype' => $filterrr['cameratype'],
                                    'bodymaterial' => $filterrr['bodymaterial'],
                                    'videochannel' => $filterrr['videochannel'],
                                    'poeports' => $filterrr['poeports'],
                                    'poetype' => $filterrr['poetype'],
                                    'sataports' => $filterrr['sataports'],
                                    'length' => $filterrr['length'],
                                    'screensize' => $filterrr['screensize'],
                                    'ledtype' => $filterrr['ledtype'],
                                    'size' => $filterrr['size'],
                                    'lens' => $filterrr['lens'],
                                    'night_vision' => $filterrr['night_vision'],
                                    'audio_type' => $filterrr['audio_type'],
                                );
                            }
                        }
                    }
                    if (!empty($night_vision_info[0])) {
                        foreach ($night_vision_info as $data14) {
                            if ($filterrr['night_vision'] == $data14) {
                                $send[] = array(
                                    'product_id' => $filterrr['product_id'],
                                    'product_name' => $filterrr['product_name'],
                                    'product_image' => $filterrr['product_image'],
                                    'productdescription' => $filterrr['productdescription'],
                                    'price' => $filterrr['price'],
                                    'max' => $filterrr['max'],
                                    't2_price' => $filterrr['t2_price'],
                                    't2_min' => $filterrr['t2_min'],
                                    't2_max' => $filterrr['t2_max'],
                                    'stock' => $stock,
                                    'brand' => $filterrr['brand'],
                                    'resolution' => $filterrr['resolution'],
                                    'irdistance' => $filterrr['irdistance'],
                                    'cameratype' => $filterrr['cameratype'],
                                    'bodymaterial' => $filterrr['bodymaterial'],
                                    'videochannel' => $filterrr['videochannel'],
                                    'poeports' => $filterrr['poeports'],
                                    'poetype' => $filterrr['poetype'],
                                    'sataports' => $filterrr['sataports'],
                                    'length' => $filterrr['length'],
                                    'screensize' => $filterrr['screensize'],
                                    'ledtype' => $filterrr['ledtype'],
                                    'size' => $filterrr['size'],
                                    'lens' => $filterrr['lens'],
                                    'night_vision' => $filterrr['night_vision'],
                                    'audio_type' => $filterrr['audio_type'],
                                );
                            }
                        }
                    }
                    if (!empty($audio_type_info[0])) {
                        foreach ($audio_type_info as $data15) {
                            if ($filterrr['audio_type'] == $data15) {
                                $send[] = array(
                                    'product_id' => $filterrr['product_id'],
                                    'product_name' => $filterrr['product_name'],
                                    'product_image' => $filterrr['product_image'],
                                    'productdescription' => $filterrr['productdescription'],
                                    'price' => $filterrr['price'],
                                    'max' => $filterrr['max'],
                                    't2_price' => $filterrr['t2_price'],
                                    't2_min' => $filterrr['t2_min'],
                                    't2_max' => $filterrr['t2_max'],
                                    'stock' => $stock,
                                    'brand' => $filterrr['brand'],
                                    'resolution' => $filterrr['resolution'],
                                    'irdistance' => $filterrr['irdistance'],
                                    'cameratype' => $filterrr['cameratype'],
                                    'bodymaterial' => $filterrr['bodymaterial'],
                                    'videochannel' => $filterrr['videochannel'],
                                    'poeports' => $filterrr['poeports'],
                                    'poetype' => $filterrr['poetype'],
                                    'sataports' => $filterrr['sataports'],
                                    'length' => $filterrr['length'],
                                    'screensize' => $filterrr['screensize'],
                                    'ledtype' => $filterrr['ledtype'],
                                    'size' => $filterrr['size'],
                                    'lens' => $filterrr['lens'],
                                    'night_vision' => $filterrr['night_vision'],
                                    'audio_type' => $filterrr['audio_type'],
                                );
                            }
                        }
                    }
                }
                if (empty($send)) {
                    $send  = $final_filter;
                }
                // print_r($send);die();
                // ----  array sort by unique id -----------
                $temp_array = array();
                $key = "product_id";
                $i = 0;
                $key_array = array();
                foreach ($send as $val) {
                    if (!in_array($val[$key], $key_array)) {
                        $key_array[$i] = $val[$key];
                        $temp_array[$i] = $val;
                    }
                    $i++;
                }
                // print_r($temp_array);exit;
                $content = [];
                foreach ($temp_array as $object) {
                    $show = 1;
                    if (!empty($object['brand']) && $T2 == 1) {
                        $check = $this->db->get_where('tbl_brands', array('is_active' => 1, 'for_t2' => 1, 'id' => $object['brand']))->result();
                        if (empty($check)) {
                            $show = 0;
                        }
                    }
                    if ($show == 0) {
                        continue;
                    }
                    $content[] = array(
                        'product_id' => $object['product_id'],
                        'product_name' => $object['product_name'],
                        'product_image' => base_url() . $object['product_image'],
                        'productdescription' => $object['productdescription'],
                        'max' => $object['max'],
                        't2_price' => $object['t2_price'],
                        't2_min' => $object['t2_min'],
                        't2_max' => $object['t2_max'],
                        'price' => $object['price'],
                        'stock' => $object['stock']
                    );
                }
                // echo $count;die();
                header('Access-Control-Allow-Origin: *');
                $res = array(
                    'message' => 'success',
                    'status' => 200,
                    'data' => $content
                );
                echo json_encode($res);
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
                'message' => 'No data available',
                'status' => 201
            );
            echo json_encode($res);
        }
    }
    //-----------filter_data-------------------
    public function view_filter($id = '', $phone = '', $authentication = '')
    {
        if (empty($id)) {
            header('Access-Control-Allow-Origin: *');
            $res = array(
                'message' => 'success',
                'status' => 201,
                'data' => [],
            );
            echo json_encode($res);
            return;
        }
        $T2 = 0;
        if (!empty($phone)) {
            $this->db->select('*');
            $this->db->from('tbl_users');
            $this->db->where('phone', $phone);
            $check_email = $this->db->get();
            $check_id = $check_email->row();
            if (!empty($check_id)) {
                if ($check_id->authentication == $authentication) {
                    if ($check_id->type == "T2") {
                        $T2 = 1;
                    }
                }
            }
        }
        $this->db->select('*');
        $this->db->from('tbl_minorcategory');
        $this->db->where('id', $id);
        $minorcategory_data = $this->db->get()->row();
        //resoultation
        $this->db->select('*');
        $this->db->from('tbl_resolution');
        $resoulation_id = $this->db->get();
        $resolution_data = [];
        $resolution = json_decode($minorcategory_data->resolution);
        if (!empty($resolution)) {
            foreach ($resoulation_id->result() as $value) {
                $a = 0;
                foreach ($resolution as $data) {
                    if ($data == $value->id) {
                        $a = 1;
                    }
                }
                if ($a == 1) {
                    $resolution_data[] = array(
                        'id' => $value->id,
                        'name' => $value->filtername
                    );
                }
            }
        }
        //brands
        $this->db->from('tbl_brands');
        $this->db->where('is_active', 1);
        if ($T2 == 1) {
            $this->db->where('for_t2', 1);
        }
        $brands = $this->db->get();
        $brands_data = [];
        $brand = json_decode($minorcategory_data->brand);
        if (!empty($brand)) {
            foreach ($brands->result() as $value1) {
                $a = 0;
                foreach ($brand as $data) {
                    if ($data == $value1->id) {
                        $a = 1;
                    }
                }
                if ($a == 1) {
                    $brands_data[] = array(
                        'id' => $value1->id,
                        'name' => $value1->name
                    );
                }
            }
        }
        //irdistance
        $this->db->from('tbl_irdistance');
        $irdistance = $this->db->get();
        $irdistance_data = [];
        $ir_distance = json_decode($minorcategory_data->ir_distance);
        if (!empty($ir_distance)) {
            foreach ($irdistance->result() as $value2) {
                $a = 0;
                foreach ($ir_distance as $data) {
                    if ($data == $value2->id) {
                        $a = 1;
                    }
                }
                if ($a == 1) {
                    $irdistance_data[] = array(
                        'id' => $value2->id,
                        'name' => $value2->filtername
                    );
                }
            }
        }
        //cameratype
        $this->db->from('tbl_cameratype');
        $cameratype = $this->db->get();
        $cameratype_data = [];
        $camera_type = json_decode($minorcategory_data->camera_type);
        if (!empty($camera_type)) {
            foreach ($cameratype->result() as $value3) {
                $a = 0;
                foreach ($camera_type as $data) {
                    if ($data == $value3->id) {
                        $a = 1;
                    }
                }
                if ($a == 1) {
                    $cameratype_data[] = array(
                        'id' => $value3->id,
                        'name' => $value3->filtername
                    );
                }
            }
        }
        //bodymaterial
        $this->db->from('tbl_bodymaterial');
        $bodymaterial = $this->db->get();
        $bodymaterial_data = [];
        $body_materials = json_decode($minorcategory_data->body_materials);
        if (!empty($body_materials)) {
            foreach ($bodymaterial->result() as $value13) {
                $a = 0;
                foreach ($body_materials as $data) {
                    if ($data == $value13->id) {
                        $a = 1;
                    }
                }
                if ($a == 1) {
                    $bodymaterial_data[] = array(
                        'id' => $value13->id,
                        'name' => $value13->filter_name
                    );
                }
            }
        }
        //videochannel
        $this->db->from('tbl_videochannel');
        $videochannel = $this->db->get();
        $videochannel_data = [];
        $video_channel = json_decode($minorcategory_data->video_channel);
        if (!empty($video_channel)) {
            foreach ($videochannel->result() as $value4) {
                $a = 0;
                foreach ($video_channel as $data) {
                    if ($data == $value4->id) {
                        $a = 1;
                    }
                }
                if ($a == 1) {
                    $videochannel_data[] = array(
                        'id' => $value4->id,
                        'name' => $value4->filter_name
                    );
                }
            }
        }
        //poeports
        $this->db->from('tbl_poeports');
        $poeports = $this->db->get();
        $poeports_data = [];
        $poe_ports = json_decode($minorcategory_data->poe_ports);
        if (!empty($poe_ports)) {
            foreach ($poeports->result() as $value5) {
                $a = 0;
                foreach ($poe_ports as $data) {
                    if ($data == $value5->id) {
                        $a = 1;
                    }
                }
                if ($a == 1) {
                    $poeports_data[] = array(
                        'id' => $value5->id,
                        'name' => $value5->filter_name
                    );
                }
            }
        }
        //poetype
        $this->db->from('tbl_poetype');
        $poetype = $this->db->get();
        $poetype_data = [];
        $poe_type = json_decode($minorcategory_data->poe_type);
        if (!empty($poe_type)) {
            foreach ($poetype->result() as $value6) {
                $a = 0;
                foreach ($poe_type as $data) {
                    if ($data == $value6->id) {
                        $a = 1;
                    }
                }
                if ($a == 1) {
                    $poetype_data[] = array(
                        'id' => $value6->id,
                        'name' => $value6->filter_name
                    );
                }
            }
        }
        //sataports
        $this->db->from('tbl_sataports');
        $sataports = $this->db->get();
        $sataports_data = [];
        $sata_ports = json_decode($minorcategory_data->sata_ports);
        if (!empty($sata_ports)) {
            foreach ($sataports->result() as $value7) {
                $a = 0;
                foreach ($sata_ports as $data) {
                    if ($data == $value7->id) {
                        $a = 1;
                    }
                }
                if ($a == 1) {
                    $sataports_data[] = array(
                        'id' => $value7->id,
                        'name' => $value7->filter_name
                    );
                }
            }
        }
        //length
        $this->db->from('tbl_length');
        $length = $this->db->get();
        $length_data = [];
        $lengths = json_decode($minorcategory_data->length);
        if (!empty($lengths)) {
            foreach ($length->result() as $value8) {
                $a = 0;
                foreach ($lengths as $data) {
                    if ($data == $value8->id) {
                        $a = 1;
                    }
                }
                if ($a == 1) {
                    $length_data[] = array(
                        'id' => $value8->id,
                        'name' => $value8->filter_name
                    );
                }
            }
        }
        //screensize
        $this->db->from('tbl_screensize');
        $screensize = $this->db->get();
        $screensize_data = [];
        $screen_size = json_decode($minorcategory_data->screen_size);
        if (!empty($screen_size)) {
            foreach ($screensize->result() as $value9) {
                $a = 0;
                foreach ($screen_size as $data) {
                    if ($data == $value9->id) {
                        $a = 1;
                    }
                }
                if ($a == 1) {
                    $screensize_data[] = array(
                        'id' => $value9->id,
                        'name' => $value9->filter_name
                    );
                }
            }
        }
        //ledtype
        $this->db->from('tbl_ledtype');
        $ledtype = $this->db->get();
        $ledtype_data = [];
        $led_type = json_decode($minorcategory_data->led_type);
        if (!empty($led_type)) {
            foreach ($ledtype->result() as $value10) {
                $a = 0;
                foreach ($led_type as $data) {
                    if ($data == $value10->id) {
                        $a = 1;
                    }
                }
                if ($a == 1) {
                    $ledtype_data[] = array(
                        'id' => $value10->id,
                        'name' => $value10->filter_name
                    );
                }
            }
        }
        //size
        $this->db->from('tbl_size');
        $size = $this->db->get();
        $size_data = [];
        $sizeids = json_decode($minorcategory_data->size);
        if (!empty($sizeids)) {
            foreach ($size->result() as $value11) {
                $a = 0;
                foreach ($sizeids as $data) {
                    if ($data == $value11->id) {
                        $a = 1;
                    }
                }
                if ($a == 1) {
                    $size_data[] = array(
                        'id' => $value11->id,
                        'name' => $value11->filter_name
                    );
                }
            }
        }
        //lens
        $this->db->from('tbl_lens');
        $lens_datas = $this->db->get();
        $lens_data = [];
        $lens = json_decode($minorcategory_data->lens);
        if (!empty($lens)) {
            foreach ($lens_datas->result() as $value12) {
                $a = 0;
                foreach ($lens as $data) {
                    if ($data == $value12->id) {
                        $a = 1;
                    }
                }
                if ($a == 1) {
                    $lens_data[] = array(
                        'id' => $value12->id,
                        'name' => $value12->filtername
                    );
                }
            }
        }
        //audio type
        $this->db->from('tbl_audio_type');
        $audio_type_datas = $this->db->get();
        $audio_data = [];
        $audio = json_decode($minorcategory_data->audio_type);
        if (!empty($audio)) {
            foreach ($audio_type_datas->result() as $value13) {
                $a = 0;
                foreach ($audio as $data) {
                    if ($data == $value13->id) {
                        $a = 1;
                    }
                }
                if ($a == 1) {
                    $audio_data[] = array(
                        'id' => $value13->id,
                        'name' => $value13->filtername
                    );
                }
            }
        }
        //night_vision type
        $this->db->from('tbl_night_vision');
        $night_vision_datas = $this->db->get();
        $night_vision_data = [];
        $night_vision = json_decode($minorcategory_data->night_vision);
        if (!empty($night_vision)) {
            foreach ($night_vision_datas->result() as $value14) {
                $a = 0;
                foreach ($night_vision as $data) {
                    if ($data == $value14->id) {
                        $a = 1;
                    }
                }
                if ($a == 1) {
                    $night_vision_data[] = array(
                        'id' => $value14->id,
                        'name' => $value14->filtername
                    );
                }
            }
        }
        $filter_name = [];
        $filter_name[] = array(
            'brand' => $brands_data,
            'resoulation' => $resolution_data,
            'irdistance' => $irdistance_data,
            'cameratype' => $cameratype_data,
            'bodymaterial' => $bodymaterial_data,
            'videochannel' => $videochannel_data,
            'poeports' => $poeports_data,
            'poetype' => $poetype_data,
            'sataports' => $sataports_data,
            'lengths' => $length_data,
            'screensize' => $screensize_data,
            'ledtype' => $ledtype_data,
            'size' => $size_data,
            'lens' => $lens_data,
            'audio_type' => $audio_data,
            'night_vision' => $night_vision_data
        );
        header('Access-Control-Allow-Origin: *');
        $res = array(
            'message' => 'success',
            'status' => 200,
            'data' => $filter_name,
        );
        echo json_encode($res);
    }
    public function feedback()
    {
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->helper('security');
        if ($this->input->post()) {
            $this->form_validation->set_rules('name', 'name', 'required|xss_clean|trim');
            $this->form_validation->set_rules('contact', 'contact', 'required|xss_clean|trim');
            $this->form_validation->set_rules('message', 'message', 'required|xss_clean|trim');
            if ($this->form_validation->run() == true) {
                $name = $this->input->post('name');
                $contact = $this->input->post('contact');
                $message = $this->input->post('message');
                $ip = $this->input->ip_address();
                date_default_timezone_set("Asia/Calcutta");
                $cur_date = date("Y-m-d H:i:s");
                $data_insert = array(
                    'name' => $name,
                    'contact' => $contact,
                    'message' => $message,
                    'ip' => $ip,
                    'date' => $cur_date
                );
                $last_id = $this->base_model->insert_table("tbl_feedback", $data_insert, 1);
                if (!empty($last_id)) {
                    header('Access-Control-Allow-Origin: *');
                    $res = array(
                        'message' => 'success',
                        'status' => 200
                    );
                    echo json_encode($res);
                } else {
                    header('Access-Control-Allow-Origin: *');
                    $res = array(
                        'message' => 'Some error occurred',
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
    public function copy_users()
    {
        $old_data = $this->db->get_where('customer_information')->result();
        $i = 1;
        foreach ($old_data as  $old) {
            $ip = $this->input->ip_address();
            date_default_timezone_set("Asia/Calcutta");
            $cur_date = date("Y-m-d H:i:s");
            $state_data = $this->db->like('state_name', $old->state)->get_where('all_states')->result();
            if (!empty($state_data[0]->id)) {
                $state = $state_data[0]->id;
            } else {
                $state = "";
            }
            $authentication = bin2hex(random_bytes(12));
            $data_insert = array(
                'name' => $old->customer_name,
                'phone' => $old->customer_mobile,
                'email' => $old->customer_email,
                'address' => $old->customer_short_address,
                'state' => $state,
                'city' => $old->city,
                'company_name' => $old->company,
                'gstin' => $old->company_gstin,
                'zipcode' => $old->zip,
                'authentication' => $authentication,
                'ip' => $ip,
                'is_active' => 1,
                'date' => $cur_date
            );
            $last_id = $this->base_model->insert_table("tbl_users", $data_insert, 1);
            $i++;
        }
        if (!empty($last_id)) {
            header('Access-Control-Allow-Origin: *');
            $res = array(
                'message' => "Success!",
                'status' => 200
            );
            echo json_encode($res);
        } else {
            header('Access-Control-Allow-Origin: *');
            $res = array(
                'message' => "Some Error Occurred!",
                'status' => 201
            );
            echo json_encode($res);
        }
    }
    //======================== START ORDER WHATSAPP MESSAGE TO ADMIN  ==========================
    public function send_whatsapp_msg_admin($order1_data, $userName)
    {
        // $order1_data = $this->db->get_where('tbl_order1', array('id' => $id))->row();
        // log_message('error', 'ORDER - '.$order1_data);
        $other_details = "NA";
        $order2Data = $this->db->get_where('tbl_order2', array('main_id' => $order1_data->id))->result();
        $products_details = '';
        foreach ($order2Data as  $order2) {
            log_message('error', 'ORDER - '.$order2->product_id);
            $pro = $this->db->get_where('tbl_products', array('id' => $order2->product_id))->row();
            log_message('error', 'ORDER - '.$pro->productname);
            if(!empty($pro)){
                $p_name =  $pro->productname;
            }
            else{
                $p_name = "product not found";
            }
            $p2 = 'product name=' . $p_name . ' * ' . $order2->quantity;
            // log_message('error', 'ORDER -p2 '.$products_details);
            $products_details = $products_details . $p2;
            
        }
        $payment_type = $order1_data->payment_type == 1 ? "Bank Transfer" : 'Pay after discussion';
        //---- sending whatspp msg to admin -------
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://whatsapp.fineoutput.com/send_order_message',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => 'phone=' . WHATSAPP_NUMBERS . '&order_id=' . $order1_data->id . '&amount=' . $order1_data->final_amount . '&date=' . $order1_data->date . '&method=' . $payment_type . '&products=' . $products_details . '&customer_name=' . $userName . '&others=' . $other_details .  '',
            CURLOPT_HTTPHEADER => array(
                'token:' . TOKEN . '',
                'Content-Type:application/x-www-form-urlencoded',
                'Cookie:ci_session=e40e757b02bc2d8fb6f5bf9c5b7bb2ea74c897e8'
            ),
        ));
        $respons = curl_exec($curl);
        curl_close($curl);
        // print_r('phone=' . WHATSAPP_NUMBERS . '&order_id=' . $order1_data->id . '&amount=' . $order1_data->final_amount . '&date=' . $order1_data->date . '&method=' . $payment_type . '&products=' . $products_details . '&customer_name=' . $userName . '');die();
        return true;
    }
    //======================== END ORDER WHATSAPP MESSAGE TO ADMIN ==========================
}
