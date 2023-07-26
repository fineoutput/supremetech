<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
require_once(APPPATH . 'core/CI_finecontrol.php');
class Products extends CI_finecontrol
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("login_model");
        $this->load->model("admin/base_model");
        $this->load->library('user_agent');
        $this->load->library('upload');
    }
    public function view_products($idd)
    {
        if (!empty($this->session->userdata('admin_data'))) {
            $data['user_name'] = $this->load->get_var('user_name');
            // echo SITE_NAME;
            // echo $this->session->userdata('image');
            // echo $this->session->userdata('position');
            // exit;
            //  $id=base64_decode($idd);
            $id = base64_decode($idd);
            $data['id'] = $idd;
            $this->db->select('*');
            $this->db->from('tbl_products');
            $this->db->where('category_id', $id);
            $data['products_data'] = $this->db->get();
            //Brands
            $this->db->select('*');
            $this->db->from('tbl_brands');
            //$this->db->where('_id',$id);
            $data['brand_data'] = $this->db->get();
            //resolution
            $this->db->select('*');
            $this->db->from('tbl_resolution');
            //$this->db->where('_id',$id);
            $data['resolution_data'] = $this->db->get();
            //Lens
            $this->db->select('*');
            $this->db->from('tbl_lens');
            //$this->db->where('_id',$id);
            $data['lens_data'] = $this->db->get();
            // ir Distance
            $this->db->select('*');
            $this->db->from('tbl_irdistance');
            //$this->db->where('_id',$id);
            $data['distance_data'] = $this->db->get();
            //camera type
            $this->db->select('*');
            $this->db->from('tbl_cameratype');
            //$this->db->where('_id',$id);
            $data['camera_data'] = $this->db->get();
            // body Material
            $this->db->select('*');
            $this->db->from('tbl_bodymaterial');
            //$this->db->where('_id',$id);
            $data['body_data'] = $this->db->get();
            // video Channel
            $this->db->select('*');
            $this->db->from('tbl_videochannel');
            //$this->db->where('_id',$id);
            $data['video_data'] = $this->db->get();
            // poe Ports
            $this->db->select('*');
            $this->db->from('tbl_poeports');
            //$this->db->where('_id',$id);
            $data['port_data'] = $this->db->get();
            // SATA ports
            $this->db->select('*');
            $this->db->from('tbl_sataports');
            //$this->db->where('_id',$id);
            $data['sata_data'] = $this->db->get();
            //Length
            $this->db->select('*');
            $this->db->from('tbl_length');
            //$this->db->where('_id',$id);
            $data['length_data'] = $this->db->get();
            //screen size
            $this->db->select('*');
            $this->db->from('tbl_screensize');
            //$this->db->where('_id',$id);
            $data['screen_data'] = $this->db->get();
            //led type
            $this->db->select('*');
            $this->db->from('tbl_ledtype');
            //$this->db->where('_id',$id);
            $data['led_data'] = $this->db->get();
            //size
            $this->db->select('*');
            $this->db->from('tbl_size');
            //$this->db->where('_id',$id);
            $data['size_data'] = $this->db->get();
            //night vision
            $this->db->select('*');
            $this->db->from('tbl_night_vision');
            //$this->db->where('_id',$id);
            $data['nv_data'] = $this->db->get();
            //audio type
            $this->db->select('*');
            $this->db->from('tbl_audio_type');
            //$this->db->where('_id',$id);
            $data['audio_type_data'] = $this->db->get();
            //             $this->db->select('*');
            // $this->db->from('tbl_inventory');
            // // $this->db->where('',$usr);
            // $data['inventory_data']= $this->db->get();
            $this->load->view('admin/common/header_view', $data);
            $this->load->view('admin/products/view_products');
            $this->load->view('admin/common/footer_view');
        } else {
            redirect("login/admin_login", "refresh");
        }
    }
    public function view_product_categories()
    {
        if (!empty($this->session->userdata('admin_data'))) {
            $this->db->select('*');
            $this->db->from('tbl_category');
            $this->db->where('is_active', 1);
            $data['category_data'] = $this->db->get();
            $this->load->view('admin/common/header_view', $data);
            $this->load->view('admin/products/view_product_categories');
            $this->load->view('admin/common/footer_view');
        } else {
            redirect("login/admin_login", "refresh");
        }
    }
    public function add_products($idd)
    {
        if (!empty($this->session->userdata('admin_data'))) {
            $id = base64_decode($idd);
            $data['id'] = $idd;
            $this->db->select('*');
            $this->db->from('tbl_category');
            $this->db->where('is_active', 1);
            $data['category_data'] = $this->db->get();
            $this->db->select('*');
            $this->db->from('tbl_subcategory');
            $this->db->where('category_id', $id);
            $this->db->where('is_active', 1);
            $data['subcategory_data'] = $this->db->get();
            // $this->db->select('*');
            // $this->db->from('tbl_minorcategory');
            // $this->db->where('is_active', 1);
            // $data['minorcategory_data']= $this->db->get();
            //
            // //Brands
            // $this->db->select('*');
            // $this->db->from('tbl_brands');
            // //$this->db->where('_id',$id);
            // $data['brand_data']= $this->db->get();
            //
            // //resolution
            // $this->db->select('*');
            // $this->db->from('tbl_resolution');
            // //$this->db->where('_id',$id);
            // $data['resolution_data']= $this->db->get();
            // //Lens
            // $this->db->select('*');
            // $this->db->from('tbl_lens');
            // //$this->db->where('_id',$id);
            // $data['lens_data']= $this->db->get();
            // // ir Distance
            // $this->db->select('*');
            // $this->db->from('tbl_irdistance');
            // //$this->db->where('_id',$id);
            // $data['distance_data']= $this->db->get();
            // //camera type
            // $this->db->select('*');
            // $this->db->from('tbl_cameratype');
            // //$this->db->where('_id',$id);
            // $data['camera_data']= $this->db->get();
            //
            // // body Material
            // $this->db->select('*');
            // $this->db->from('tbl_bodymaterial');
            // //$this->db->where('_id',$id);
            // $data['body_data']= $this->db->get();
            // // video Channel
            // $this->db->select('*');
            // $this->db->from('tbl_videochannel');
            // //$this->db->where('_id',$id);
            // $data['video_data']= $this->db->get();
            // // poe Ports
            // $this->db->select('*');
            // $this->db->from('tbl_poeports');
            // //$this->db->where('_id',$id);
            // $data['port_data']= $this->db->get();
            // // SATA ports
            // $this->db->select('*');
            // $this->db->from('tbl_sataports');
            // //$this->db->where('_id',$id);
            // $data['sata_data']= $this->db->get();
            //
            // //Length
            // $this->db->select('*');
            // $this->db->from('tbl_length');
            // //$this->db->where('_id',$id);
            // $data['length_data']= $this->db->get();
            // //screen size
            // $this->db->select('*');
            // $this->db->from('tbl_screensize');
            // //$this->db->where('_id',$id);
            // $data['screen_data']= $this->db->get();
            // //led type
            // $this->db->select('*');
            // $this->db->from('tbl_ledtype');
            // //$this->db->where('_id',$id);
            // $data['led_data']= $this->db->get();
            //
            // //size
            // $this->db->select('*');
            // $this->db->from('tbl_size');
            // //$this->db->where('_id',$id);
            // $data['size_data']= $this->db->get();
            //
            // //night vision
            // $this->db->select('*');
            // $this->db->from('tbl_night_vision');
            // //$this->db->where('_id',$id);
            // $data['nv_data']= $this->db->get();
            //
            // //audio type
            // $this->db->select('*');
            // $this->db->from('tbl_audio_type');
            // //$this->db->where('_id',$id);
            // $data['audio_type_data']= $this->db->get();
            $this->load->view('admin/common/header_view', $data);
            $this->load->view('admin/products/add_products');
            $this->load->view('admin/common/footer_view');
        } else {
            redirect("login/admin_login", "refresh");
        }
    }
    public function set_filters()
    {
        $minorid = $this->input->post('minorid');
        // echo $minorid;
        $this->db->select('*');
        $this->db->from('tbl_minorcategory');
        $this->db->where('id', $minorid);
        $minor_data = $this->db->get()->row();
        $brands = [];
        $brands[] = array('id' => '', 'name' => 'None Selected');
        $brand_json = json_decode($minor_data->brand);
        // print_r($brand_json);die();
        if (!empty($brand_json)) {
            // echo "hi";
            foreach ($brand_json as $data1) {
                //Brands
                $this->db->select('*');
                $this->db->from('tbl_brands');
                $this->db->where('id', $data1);
                $brand_result = $this->db->get()->row();
                $brands[] = array('id' => $brand_result->id, 'name' => $brand_result->name);
            }
            $data['brands'] = json_encode($brands);
        } else {
            $data['brands'] = '';
        }
        //resolution
        $resolution = [];
        $resolution[] = array('id' => '', 'name' => 'None Selected');
        $resolution_json = json_decode($minor_data->resolution);
        if (!empty($resolution_json)) {
            // echo "hi";
            foreach ($resolution_json as $data2) {
                $this->db->select('*');
                $this->db->from('tbl_resolution');
                $this->db->where('id', $data2);
                $resolution_result = $this->db->get()->row();
                $resolution[] = array('id' => $resolution_result->id, 'name' => $resolution_result->filtername);
            }
            $data['resolution'] = json_encode($resolution);
        } else {
            $data['resolution'] = '';
        }
        //Lens
        $lens = [];
        $lens = array('id' => '', 'name' => 'None Selected');
        $lens_json = json_decode($minor_data->lens);
        if (!empty($lens_json)) {
            foreach ($lens_json as $data3) {
                $this->db->select('*');
                $this->db->from('tbl_lens');
                $this->db->where('id', $data3);
                $lens_result = $this->db->get()->row();
                $lens[] = array('id' => $lens_result->id, 'name' => $lens_result->filtername);
            }
            $data['lens']  = json_encode($lens);
        } else {
            $data['lens'] = '';
        }
        // ir Distance
        $irdistance = [];
        $irdistance[] = array('id' => '', 'name' => 'None Selected');
        $irdistance_json = json_decode($minor_data->ir_distance);
        if (!empty($irdistance_json)) {
            foreach ($irdistance_json as $data4) {
                $this->db->select('*');
                $this->db->from('tbl_irdistance');
                $this->db->where('id', $data4);
                $irdistance_result = $this->db->get()->row();
                $irdistance[] = array('id' => $irdistance_result->id, 'name' => $irdistance_result->filtername);
            }
            $data['irdistance'] = json_encode($irdistance);
        } else {
            $data['irdistance'] = '';
        }
        //camera type
        $camera_type = [];
        $camera_type[] = array('id' => '', 'name' => 'None Selected');
        $camera_type_json = json_decode($minor_data->camera_type);
        if (!empty($camera_type_json)) {
            foreach ($camera_type_json as $data5) {
                $this->db->select('*');
                $this->db->from('tbl_cameratype');
                $this->db->where('id', $data5);
                $camera_type_result = $this->db->get()->row();
                $camera_type[] = array('id' => $camera_type_result->id, 'name' => $camera_type_result->filtername);
            }
            $data['camera_type'] = json_encode($camera_type);
        } else {
            $data['camera_type'] = '';
        }
        // body Material
        $body_material = [];
        $body_material[] = array('id' => '', 'name' => 'None Selected');;
        $body_material_json = json_decode($minor_data->body_materials);
        if (!empty($body_material_json)) {
            foreach ($body_material_json as $data6) {
                $this->db->select('*');
                $this->db->from('tbl_bodymaterial');
                $this->db->where('id', $data6);
                $body_material_result = $this->db->get()->row();
                $body_material[] = array('id' => $body_material_result->id, 'name' => $body_material_result->filter_name);
            }
            $data['body_material'] = json_encode($body_material);
        } else {
            $data['body_material'] = '';
        }
        // video Channel
        $video_channel = [];
        $video_channel[] = array('id' => '', 'name' => 'None Selected');
        $video_channel_json = json_decode($minor_data->video_channel);
        if (!empty($video_channel_json)) {
            foreach ($video_channel_json as $data7) {
                $this->db->select('*');
                $this->db->from('tbl_videochannel');
                $this->db->where('id', $data7);
                $video_channel_result = $this->db->get()->row();
                $video_channel[] = array('id' => $video_channel_result->id, 'name' => $video_channel_result->filter_name);
            }
            $data['video_channel'] = json_encode($video_channel);
        } else {
            $data['video_channel'] = '';
        }
        // poe Ports
        $pov_ports = [];
        $pov_ports[] = array('id' => '', 'name' => 'None Selected');
        $pov_ports_json = json_decode($minor_data->poe_ports);
        if (!empty($pov_ports_json)) {
            foreach ($pov_ports_json as $data8) {
                $this->db->select('*');
                $this->db->from('tbl_poeports');
                $this->db->where('id', $data8);
                $pov_ports_result = $this->db->get()->row();
                $pov_ports[] = array('id' => $pov_ports_result->id, 'name' => $pov_ports_result->filter_name);
            }
            $data['pov_ports'] = json_encode($pov_ports);
        } else {
            $data['pov_ports'] = '';
        }
        // Poe Type
        $pov_type = [];
        $pov_type[] = array('id' => '', 'name' => 'None Selected');
        $pov_type_json = json_decode($minor_data->poe_type);
        if (!empty($pov_type_json)) {
            foreach ($pov_type_json as $data16) {
                $this->db->select('*');
                $this->db->from('tbl_poeports');
                $this->db->where('id', $data16);
                $pov_type_result = $this->db->get()->row();
                $pov_type[] = array('id' => $pov_type_result->id, 'name' => $pov_type_result->filter_name);
            }
            $data['pov_type'] = json_encode($pov_type);
        } else {
            $data['pov_type'] = '';
        }
        // SATA ports
        $sata_ports = [];
        $sata_ports[] = array('id' => '', 'name' => 'None Selected');
        $sata_ports_json = json_decode($minor_data->sata_ports);
        if (!empty($sata_ports_json)) {
            foreach ($sata_ports_json as $data9) {
                $this->db->select('*');
                $this->db->from('tbl_sataports');
                $this->db->where('id', $data9);
                $sata_ports_result = $this->db->get()->row();
                $sata_ports[] = array('id' => $sata_ports_result, 'name' => $sata_ports_result->filter_name);
            }
            $data['sata_ports'] = json_encode($sata_ports);
        } else {
            $data['sata_ports'] = '';
        }
        //Length
        $length = [];
        $length[] = array('id' => '', 'name' => 'None Selected');
        $length_json = json_decode($minor_data->length);
        if (!empty($length_json)) {
            foreach ($length_json as $data10) {
                $this->db->select('*');
                $this->db->from('tbl_length');
                $this->db->where('id', $data10);
                $length_result = $this->db->get()->row();
                $length[] = array('id' => $length_result->id, 'name' => $length_result->filter_name);
            }
            $data['length'] = json_encode($length);
        } else {
            $data['length'] = '';
        }
        //screen size
        $screen_size = [];
        $screen_size[] = array('id' => '', 'name' => 'None Selected');
        $screen_size_json = json_decode($minor_data->screen_size);
        if (!empty($screen_size_json)) {
            foreach ($screen_size_json as $data11) {
                $this->db->select('*');
                $this->db->from('tbl_screensize');
                $this->db->where('id', $data11);
                $screen_size_result = $this->db->get()->row();
                $screen_size[] = array('id' => $screen_size_result->id, 'name' => $screen_size_result->filter_name);
            }
            $data['screen_size'] = json_encode($screen_size);
        } else {
            $data['screen_size'] = '';
        }
        //led type
        $led_type = [];
        $led_type[] = array('id' => '', 'name' => 'None Selected');;
        $led_type_json = json_decode($minor_data->led_type);
        if (!empty($led_type_json)) {
            foreach ($led_type_json as $data12) {
                $this->db->select('*');
                $this->db->from('tbl_ledtype');
                $this->db->where('id', $data12);
                $led_type_result = $this->db->get()->row();
                $screen_size[] = array('id' => $led_type_result->id, 'name' => $led_type_result->filter_name);
            }
            $data['led_type'] = json_encode($led_type);
        } else {
            $data['led_type'] = '';
        }
        //size
        $size = [];
        $size[] = array('id' => '', 'name' => 'None Selected');;
        $size_json = json_decode($minor_data->size);
        if (!empty($size_json)) {
            foreach ($size_json as $data13) {
                $this->db->select('*');
                $this->db->from('tbl_size');
                $this->db->where('id', $data13);
                $size_result = $this->db->get()->row();
                $size[] = array('id' => $size_result->id, 'name' => $size_result->filter_name);
            }
            $data['size'] = json_encode($size);
        } else {
            $data['size'] = '';
        }
        //night vision
        $night_vision = [];
        $night_vision[] = array('id' => '', 'name' => 'None Selected');;
        $night_vision_json = json_decode($minor_data->night_vision);
        if (!empty($night_vision_json)) {
            foreach ($night_vision_json as $data14) {
                $this->db->select('*');
                $this->db->from('tbl_night_vision');
                $this->db->where('id', $data14);
                $night_vision_result = $this->db->get()->row();
                $night_vision[] = array('id' => $night_vision_result->id, 'name' => $night_vision_result->filtername);
            }
            $data['night_vision'] = json_encode($night_vision);
        } else {
            $data['night_vision'] = '';
        }
        //audio type
        $audio_type = [];
        $audio_type[] = array('id' => '', 'name' => 'None Selected');;
        $audio_type_json = json_decode($minor_data->audio_type);
        if (!empty($audio_type_json)) {
            foreach ($audio_type_json as $data15) {
                $this->db->select('*');
                $this->db->from('tbl_audio_type');
                $this->db->where('id', $data15);
                $audio_type_result = $this->db->get()->row();
                $audio_type[] = array('id' => $audio_type_result->id, 'name' => $audio_type_result->filtername);
            }
            $data['audio_type'] = json_encode($audio_type);
        } else {
            $data['audio_type'] = '';
        }
        $data['data'] = true;
        echo json_encode($data);
    }
    public function getSubcategory()
    {
        // $data['user_name']=$this->load->get_var('user_name');
        // echo SITE_NAME;
        // echo $this->session->userdata('image');
        // echo $this->session->userdata('position');
        // exit;
        $id = $_GET['isl'];
        $this->db->select('*');
        $this->db->from('tbl_subcategory');
        $this->db->where('category_id', $id);
        $this->db->where('is_active', 1);
        $dat = $this->db->get();
        $i = 1;
        foreach ($dat->result() as $data) {
            $igt[] = array('sub_id' => $data->id, 'sub_name' => $data->subcategory);
        }
        echo json_encode($igt);
    }
    public function getMinorcategory()
    {
        // $data['user_name']=$this->load->get_var('user_name');
        // echo SITE_NAME;
        // echo $this->session->userdata('image');
        // echo $this->session->userdata('position');
        // exit;
        $id = $_GET['isl'];
        $this->db->select('*');
        $this->db->from('tbl_minorcategory');
        $this->db->where('subcategory_id', $id);
        $this->db->where('is_active', 1);
        $dat = $this->db->get();
        $igt1 = [];
        $i = 1;
        foreach ($dat->result() as $data) {
            $igt1[] = array('min_id' => $data->id, 'min_name' => $data->minorcategoryname);
        }
        echo json_encode($igt1);
    }
    public function update_products($idd, $idd1)
    {
        if (!empty($this->session->userdata('admin_data'))) {
            $data['user_name'] = $this->load->get_var('user_name');
            // echo SITE_NAME;
            // echo $this->session->userdata('image');
            // echo $this->session->userdata('position');
            // exit;
            $id = base64_decode($idd);
            $data['id'] = $idd;
            $id1 = base64_decode($idd1);
            $data['id1'] = $idd1;
            $this->db->select('*');
            $this->db->from('tbl_products');
            $this->db->where('id', $id);
            $data['products_data'] = $this->db->get()->row();
            $products_data = $data['products_data'];
            $this->db->select('*');
            $this->db->from('tbl_category');
            $this->db->where('is_active', 1);
            $data['category_data'] = $this->db->get();
            $this->db->select('*');
            $this->db->from('tbl_subcategory');
            $this->db->where('category_id', $id1);
            $this->db->where('is_active', 1);
            $data['subcategory_data'] = $this->db->get();
            $this->db->select('*');
            $this->db->from('tbl_minorcategory');
            $this->db->where('is_active', 1);
            $data['minorcategory_data'] = $this->db->get();
            $this->db->select('*');
            $this->db->from('tbl_inventory');
            $this->db->where('product_id', $id);
            $data['inventory_data'] = $this->db->get()->row();
            $this->db->select('*');
            $this->db->from('tbl_minorcategory');
            $this->db->where('id', $products_data->minorcategory_id);
            $minor_data = $this->db->get()->row();
            $brands = [];
            $brands[] = array('id' => '', 'name' => 'None Selected');
            $brand_json = json_decode($minor_data->brand);
            // print_r($brand_json);die();
            if (!empty($brand_json)) {
                // echo "hi";
                foreach ($brand_json as $data1) {
                    //Brands
                    $this->db->select('*');
                    $this->db->from('tbl_brands');
                    $this->db->where('id', $data1);
                    $brand_result = $this->db->get()->row();
                    $brands[] = array('id' => $brand_result->id, 'name' => $brand_result->name);
                }
                $data['brands_data'] = $brands;
            } else {
                $data['brands_data'][] = array('id' => '', 'name' => 'Not Found');
            }
            //resolution
            $resolution = [];
            $resolution[] = array('id' => '', 'name' => 'None Selected');
            $resolution_json = json_decode($minor_data->resolution);
            if (!empty($resolution_json)) {
                // echo "hi";
                foreach ($resolution_json as $data2) {
                    $this->db->select('*');
                    $this->db->from('tbl_resolution');
                    $this->db->where('id', $data2);
                    $resolution_result = $this->db->get()->row();
                    $resolution[] = array('id' => $resolution_result->id, 'name' => $resolution_result->filtername);
                }
                $data['resolution_data'] = $resolution;
            } else {
                $data['resolution_data'][] = array('id' => '', 'name' => 'Not Found');
            }
            //Lens
            $lens = [];
            $lens[] = array('id' => '', 'name' => 'None Selected');
            $lens_json = json_decode($minor_data->lens);
            if (!empty($lens_json)) {
                foreach ($lens_json as $data3) {
                    $this->db->select('*');
                    $this->db->from('tbl_lens');
                    $this->db->where('id', $data3);
                    $lens_result = $this->db->get()->row();
                    $lens[] = array('id' => $lens_result->id, 'name' => $lens_result->filtername);
                }
                $data['lens_data']  = $lens;
            } else {
                $data['lens_data'][] = array('id' => '', 'name' => 'Not Found');
            }
            // ir Distance
            $irdistance = [];
            $irdistance[] = array('id' => '', 'name' => 'None Selected');
            $irdistance_json = json_decode($minor_data->ir_distance);
            if (!empty($irdistance_json)) {
                foreach ($irdistance_json as $data4) {
                    $this->db->select('*');
                    $this->db->from('tbl_irdistance');
                    $this->db->where('id', $data4);
                    $irdistance_result = $this->db->get()->row();
                    $irdistance[] = array('id' => $irdistance_result->id, 'name' => $irdistance_result->filtername);
                }
                $data['irdistance_data'] = $irdistance;
            } else {
                // $something[] = array('id'=>'', 'name'=>'Not Found');
                $data['irdistance_data'][] = array('id' => '', 'name' => 'Not Found');
            }
            //camera type
            $camera_type = [];
            $camera_type[] = array('id' => '', 'name' => 'None Selected');
            $camera_type_json = json_decode($minor_data->camera_type);
            if (!empty($camera_type_json)) {
                foreach ($camera_type_json as $data5) {
                    $this->db->select('*');
                    $this->db->from('tbl_cameratype');
                    $this->db->where('id', $data5);
                    $camera_type_result = $this->db->get()->row();
                    $camera_type[] = array('id' => $camera_type_result->id, 'name' => $camera_type_result->filtername);
                }
                $data['camera_type'] = $camera_type;
            } else {
                $data['camera_type'][] = array('id' => '', 'name' => 'Not Found');
            }
            // body Material
            $body_material = [];
            $body_material[] = array('id' => '', 'name' => 'None Selected');;
            $body_material_json = json_decode($minor_data->body_materials);
            if (!empty($body_material_json)) {
                foreach ($body_material_json as $data6) {
                    $this->db->select('*');
                    $this->db->from('tbl_bodymaterial');
                    $this->db->where('id', $data6);
                    $body_material_result = $this->db->get()->row();
                    $body_material[] = array('id' => $body_material_result->id, 'name' => $body_material_result->filter_name);
                }
                $data['body_material'] = $body_material;
            } else {
                $data['body_material'][] = array('id' => '', 'name' => 'Not Found');
            }
            // video Channel
            $video_channel = [];
            $video_channel[] = array('id' => '', 'name' => 'None Selected');
            $video_channel_json = json_decode($minor_data->video_channel);
            if (!empty($video_channel_json)) {
                foreach ($video_channel_json as $data7) {
                    $this->db->select('*');
                    $this->db->from('tbl_videochannel');
                    $this->db->where('id', $data7);
                    $video_channel_result = $this->db->get()->row();
                    $video_channel[] = array('id' => $video_channel_result->id, 'name' => $video_channel_result->filter_name);
                }
                $data['video_channel'] = $video_channel;
            } else {
                $data['video_channel'][] = array('id' => '', 'name' => 'Not Found');
            }
            // poe Ports
            $pov_ports = [];
            $pov_ports[] = array('id' => '', 'name' => 'None Selected');
            $pov_ports_json = json_decode($minor_data->poe_ports);
            if (!empty($pov_ports_json)) {
                foreach ($pov_ports_json as $data8) {
                    $this->db->select('*');
                    $this->db->from('tbl_poeports');
                    $this->db->where('id', $data8);
                    $pov_ports_result = $this->db->get()->row();
                    $pov_ports[] = array('id' => $pov_ports_result->id, 'name' => $pov_ports_result->filter_name);
                }
                $data['pov_ports'] = $pov_ports;
            } else {
                $data['pov_ports'][] = array('id' => '', 'name' => 'Not Found');
            }
            // Poe Type
            $pov_type = [];
            $pov_type[] = array('id' => '', 'name' => 'None Selected');
            $pov_type_json = json_decode($minor_data->poe_type);
            if (!empty($pov_type_json)) {
                foreach ($pov_type_json as $data16) {
                    $this->db->select('*');
                    $this->db->from('tbl_poetype');
                    $this->db->where('id', $data16);
                    $pov_type_result = $this->db->get()->row();
                    $pov_type[] = array('id' => $pov_type_result->id, 'name' => $pov_type_result->filter_name);
                }
                $data['pov_type'] = $pov_type;
            } else {
                $data['pov_type'][] = array('id' => '', 'name' => 'Not Found');
            }
            // SATA ports
            $sata_ports = [];
            $sata_ports[] = array('id' => '', 'name' => 'None Selected');
            $sata_ports_json = json_decode($minor_data->sata_ports);
            if (!empty($sata_ports_json)) {
                foreach ($sata_ports_json as $data9) {
                    $this->db->select('*');
                    $this->db->from('tbl_sataports');
                    $this->db->where('id', $data9);
                    $sata_ports_result = $this->db->get()->row();
                    $sata_ports[] = array('id' => $sata_ports_result->id, 'name' => $sata_ports_result->filter_name);
                }
                $data['sata_ports'] = $sata_ports;
            } else {
                $data['sata_ports'][] = array('id' => '', 'name' => 'Not Found');
            }
            //Length
            $length = [];
            $length[] = array('id' => '', 'name' => 'None Selected');
            $length_json = json_decode($minor_data->length);
            if (!empty($length_json)) {
                foreach ($length_json as $data10) {
                    $this->db->select('*');
                    $this->db->from('tbl_length');
                    $this->db->where('id', $data10);
                    $length_result = $this->db->get()->row();
                    $length[] = array('id' => $length_result->id, 'name' => $length_result->filter_name);
                }
                $data['length_data'] = $length;
            } else {
                $data['length_data'][] = array('id' => '', 'name' => 'Not Found');
            }
            //screen size
            $screen_size = [];
            $screen_size[] = array('id' => '', 'name' => 'None Selected');
            $screen_size_json = json_decode($minor_data->screen_size);
            if (!empty($screen_size_json)) {
                foreach ($screen_size_json as $data11) {
                    $this->db->select('*');
                    $this->db->from('tbl_screensize');
                    $this->db->where('id', $data11);
                    $screen_size_result = $this->db->get()->row();
                    $screen_size[] = array('id' => $screen_size_result->id, 'name' => $screen_size_result->filter_name);
                }
                $data['screen_size'] = $screen_size;
            } else {
                $data['screen_size'][] = array('id' => '', 'name' => 'Not Found');
            }
            //led type
            $led_type = [];
            $led_type[] = array('id' => '', 'name' => 'None Selected');;
            $led_type_json = json_decode($minor_data->led_type);
            if (!empty($led_type_json)) {
                foreach ($led_type_json as $data12) {
                    $this->db->select('*');
                    $this->db->from('tbl_ledtype');
                    $this->db->where('id', $data12);
                    $led_type_result = $this->db->get()->row();
                    $led_type[] = array('id' => $led_type_result->id, 'name' => $led_type_result->filter_name);
                }
                $data['led_type'] = $led_type;
            } else {
                $data['led_type'][] = array('id' => '', 'name' => 'Not Found');
            }
            //size
            $size = [];
            $size[] = array('id' => '', 'name' => 'None Selected');;
            $size_json = json_decode($minor_data->size);
            if (!empty($size_json)) {
                foreach ($size_json as $data13) {
                    $this->db->select('*');
                    $this->db->from('tbl_size');
                    $this->db->where('id', $data13);
                    $size_result = $this->db->get()->row();
                    $size[] = array('id' => $size_result->id, 'name' => $size_result->filter_name);
                }
                $data['size_data'] = $size;
            } else {
                $data['size_data'][] = array('id' => '', 'name' => 'Not Found');
            }
            //night vision
            $night_vision = [];
            $night_vision[] = array('id' => '', 'name' => 'None Selected');;
            $night_vision_json = json_decode($minor_data->night_vision);
            if (!empty($night_vision_json)) {
                foreach ($night_vision_json as $data14) {
                    $this->db->select('*');
                    $this->db->from('tbl_night_vision');
                    $this->db->where('id', $data14);
                    $night_vision_result = $this->db->get()->row();
                    $night_vision[] = array('id' => $night_vision_result->id, 'name' => $night_vision_result->filtername);
                }
                $data['night_vision'] = $night_vision;
            } else {
                $data['night_vision'][] = array('id' => '', 'name' => 'Not Found');
            }
            //audio type
            $audio_type = [];
            $audio_type[] = array('id' => '', 'name' => 'None Selected');;
            $audio_type_json = json_decode($minor_data->audio_type);
            if (!empty($audio_type_json)) {
                foreach ($audio_type_json as $data15) {
                    $this->db->select('*');
                    $this->db->from('tbl_audio_type');
                    $this->db->where('id', $data15);
                    $audio_type_result = $this->db->get()->row();
                    $audio_type[] = array('id' => $audio_type_result->id, 'name' => $audio_type_result->filtername);
                }
                $data['audio_type'] = $audio_type;
            } else {
                $data['audio_type'][] = array('id' => '', 'name' => 'Not Found');
            }
            $this->load->view('admin/common/header_view', $data);
            $this->load->view('admin/products/update_products');
            $this->load->view('admin/common/footer_view');
        } else {
            redirect("login/admin_login", "refresh");
        }
    }
    public function add_products_data($t, $iw = "")
    {
        if (!empty($this->session->userdata('admin_data'))) {
            $this->load->helper(array('form', 'url'));
            $this->load->library('form_validation');
            $this->load->helper('security');
            if ($this->input->post()) {
                // print_r($this->input->post());
                // exit;
                $this->form_validation->set_rules('productname', 'productname', 'required|trim');
                $this->form_validation->set_rules('category_id', 'category_id', 'required|trim');
                $this->form_validation->set_rules('subcategory_id', 'subcategory_id', 'required|trim');
                $this->form_validation->set_rules('minorcategory_id', 'minorcategory_id', 'required|trim');
                // $this->form_validation->set_rules('mrp', 'mrp', 'trim|integer');
                $this->form_validation->set_rules('sellingprice', 'sellingprice', 'trim');
                $this->form_validation->set_rules('t2_price', 't2_price', 'required|trim');
                $this->form_validation->set_rules('t2_min', 't2_min', 'required|trim');
                $this->form_validation->set_rules('t2_max', 't2_max', 'required|trim');
                // $this->form_validation->set_rules('gst', 'gst', 'trim');
                // $this->form_validation->set_rules('gstprice', 'gstprice', 'trim');
                // $this->form_validation->set_rules('sp', 'sp', 'trim');
                $this->form_validation->set_rules('productdescription', 'productdescription', 'required|trim');
                $this->form_validation->set_rules('modelno', 'modelno', 'required|trim');
                $this->form_validation->set_rules('Inventory', 'Inventory', 'required|trim|integer');
                $this->form_validation->set_rules('weight', 'weight', 'required|trim');
                $this->form_validation->set_rules('feature_product', 'feature_product', 'required|trim');
                $this->form_validation->set_rules('popular_product', 'popular_product', 'required|trim');
                //filter
                $this->form_validation->set_rules('brands', 'brands', 'trim');
                $this->form_validation->set_rules('resolution', 'resolution', 'trim');
                $this->form_validation->set_rules('lens', 'lens', 'rtrim');
                $this->form_validation->set_rules('irdistance', 'irdistance', 'trim');
                $this->form_validation->set_rules('cameratype', 'cameratype', 'trim');
                $this->form_validation->set_rules('bodymaterial', 'bodymaterial', 'trim');
                $this->form_validation->set_rules('videochannel', 'videochannel', 'trim');
                $this->form_validation->set_rules('poeports', 'poeports', 'trim');
                $this->form_validation->set_rules('poetype', 'poetype', 'trim');
                $this->form_validation->set_rules('sataports', 'sataports', 'trim');
                $this->form_validation->set_rules('length', 'length', 'trim');
                $this->form_validation->set_rules('screensize', 'screensize', 'trim');
                $this->form_validation->set_rules('ledtype', 'ledtype', 'trim');
                $this->form_validation->set_rules('size_data', 'size_data', 'trim');
                $this->form_validation->set_rules('max', 'max', 'trim');
                $this->form_validation->set_rules('nv_data', 'nv_data', 'trim');
                $this->form_validation->set_rules('audiotype', 'audiotype', 'trim');
                if ($this->form_validation->run() == true) {
                    $productname = $this->input->post('productname');
                    $category_id = $this->input->post('category_id');
                    $subcategory_id = $this->input->post('subcategory_id');
                    $minorcategory_id = $this->input->post('minorcategory_id');
                    // $mrp=$this->input->post('mrp');
                    $sellingprice = $this->input->post('sellingprice');
                    // $gst=$this->input->post('gst');
                    // $gstprice=$this->input->post('gstprice');
                    // $sp=$this->input->post('sp');
                    $productdescription = $this->input->post('productdescription');
                    $modelno = $this->input->post('modelno');
                    $inventory = $this->input->post('Inventory');
                    $weight = $this->input->post('weight');
                    $feature_product = $this->input->post('feature_product');
                    $popular_product = $this->input->post('popular_product');
                    //filter
                    $brand = $this->input->post('brands');
                    $resolution = $this->input->post('resolution');
                    $lens = $this->input->post('lens');
                    $irdistance = $this->input->post('irdistance');
                    $cameratype = $this->input->post('cameratype');
                    $bodymaterial = $this->input->post('bodymaterial');
                    $videochannel = $this->input->post('videochannel');
                    $poeports = $this->input->post('poeports');
                    $poetype = $this->input->post('poetype');
                    $sataports = $this->input->post('sataports');
                    $length = $this->input->post('length');
                    $screensize = $this->input->post('screensize');
                    $ledtype = $this->input->post('ledtype');
                    $size_data = $this->input->post('size_data');
                    $max = $this->input->post('max');
                    $nv_data = $this->input->post('nv_data');
                    $audiotype = $this->input->post('audiotype');
                    $t2_price = $this->input->post('t2_price');
                    $t2_min = $this->input->post('t2_min');
                    $t2_max = $this->input->post('t2_max');
                    // echo $nv_data;
                    // echo $audiotype;die();
                    if ($feature_product == 'yes') {
                        $feature_product = 1;
                    } else {
                        $feature_product = 0;
                    }
                    if ($popular_product == 'yes') {
                        $popular_product = 1;
                    } else {
                        $popular_product = 0;
                    }
                    $nnnn2 = '';
                    $nnnn3 = '';
                    $nnnn4 = '';
                    $nnnn5 = '';
                    $img1 = 'image';
                    $file_check = ($_FILES['image']['error']);
                    if ($file_check != 4) {
                        $image_upload_folder = FCPATH . "assets/uploads/products/";
                        if (!file_exists($image_upload_folder)) {
                            mkdir($image_upload_folder, DIR_WRITE_MODE, true);
                        }
                        $new_file_name = "products" . date("Ymdhms");
                        $this->upload_config = array(
                            'upload_path'   => $image_upload_folder,
                            'file_name' => $new_file_name,
                            'allowed_types' => 'jpg|jpeg|png',
                            'max_size'      => 25000
                        );
                        $this->upload->initialize($this->upload_config);
                        if (!$this->upload->do_upload($img1)) {
                            $upload_error = $this->upload->display_errors();
                            $this->session->set_flashdata('emessage', $upload_error);
                            redirect($_SERVER['HTTP_REFERER']);
                            // echo json_encode($upload_error);
                            // echo $upload_error;
                        } else {
                            $file_info = $this->upload->data();
                            $videoNAmePath = "assets/uploads/products/" . $new_file_name . $file_info['file_ext'];
                            $nnnn2 = $videoNAmePath;
                            // echo json_encode($file_info);
                        }
                    }
                    //-------------
                    $img3 = 'image1';
                    $file_check = ($_FILES['image1']['error']);
                    if ($file_check != 4) {
                        $image_upload_folder = FCPATH . "assets/uploads/products/";
                        if (!file_exists($image_upload_folder)) {
                            mkdir($image_upload_folder, DIR_WRITE_MODE, true);
                        }
                        $new_file_name = "products1" . date("Ymdhms");
                        $this->upload_config = array(
                            'upload_path'   => $image_upload_folder,
                            'file_name' => $new_file_name,
                            'allowed_types' => 'jpg|jpeg|png',
                            'max_size'      => 25000
                        );
                        $this->upload->initialize($this->upload_config);
                        if (!$this->upload->do_upload($img3)) {
                            $upload_error = $this->upload->display_errors();
                            $this->session->set_flashdata('emessage', $upload_error);
                            redirect($_SERVER['HTTP_REFERER']);
                            // echo json_encode($upload_error);
                            // echo $upload_error;
                        } else {
                            $file_info = $this->upload->data();
                            $videoNAmePath = "assets/uploads/products/" . $new_file_name . $file_info['file_ext'];
                            $nnnn3 = $videoNAmePath;
                            // echo json_encode($file_info);
                        }
                    }
                    $img4 = 'video1';
                    $file_check = ($_FILES['video1']['error']);
                    if ($file_check != 4) {
                        $image_upload_folder = FCPATH . "assets/uploads/products/";
                        if (!file_exists($image_upload_folder)) {
                            mkdir($image_upload_folder, DIR_WRITE_MODE, true);
                        }
                        $new_file_name = "products2" . date("Ymdhms");
                        $this->upload_config = array(
                            'upload_path'   => $image_upload_folder,
                            'file_name' => $new_file_name,
                            'allowed_types' => 'mp4|MOV|WMV|FLV|AVI|WebM|MKV',
                            'max_size'      => 25000
                        );
                        $this->upload->initialize($this->upload_config);
                        if (!$this->upload->do_upload($img4)) {
                            $upload_error = $this->upload->display_errors();
                            $this->session->set_flashdata('emessage', $upload_error);
                            redirect($_SERVER['HTTP_REFERER']);
                            // echo json_encode($upload_error);
                            // echo $upload_error;
                        } else {
                            $file_info = $this->upload->data();
                            $videoNAmePath = "assets/uploads/products/" . $new_file_name . $file_info['file_ext'];
                            $nnnn4 = $videoNAmePath;
                            // echo json_encode($file_info);
                        }
                    }
                    $img5 = 'video2';
                    $file_check = ($_FILES['video2']['error']);
                    if ($file_check != 4) {
                        $image_upload_folder = FCPATH . "assets/uploads/products/";
                        if (!file_exists($image_upload_folder)) {
                            mkdir($image_upload_folder, DIR_WRITE_MODE, true);
                        }
                        $new_file_name = "products3" . date("Ymdhms");
                        $this->upload_config = array(
                            'upload_path'   => $image_upload_folder,
                            'file_name' => $new_file_name,
                            'allowed_types' => 'mp4|MOV|WMV|FLV|AVI|WebM|MKV',
                            'max_size'      => 25000
                        );
                        $this->upload->initialize($this->upload_config);
                        if (!$this->upload->do_upload($img5)) {
                            $upload_error = $this->upload->display_errors();
                            $this->session->set_flashdata('emessage', $upload_error);
                            redirect($_SERVER['HTTP_REFERER']);
                            // echo json_encode($upload_error);
                            // echo $upload_error;
                        } else {
                            $file_info = $this->upload->data();
                            $videoNAmePath = "assets/uploads/products/" . $new_file_name . $file_info['file_ext'];
                            $nnnn5 = $videoNAmePath;
                            // echo json_encode($file_info);
                        }
                    }
                    $typ = base64_decode($t);
                    // $last_id = 0;
                    $ip = $this->input->ip_address();
                    date_default_timezone_set("Asia/Calcutta");
                    $cur_date = date("Y-m-d H:i:s");
                    $addedby = $this->session->userdata('admin_id');
                    if ($typ == 1) {
                        $data_insert = array(
                            'productname' => $productname,
                            'category_id' => $category_id,
                            'subcategory_id' => $subcategory_id,
                            'minorcategory_id' => $minorcategory_id,
                            'image' => $nnnn2,
                            'image1' => $nnnn3,
                            'video1' => $nnnn4,
                            'video2' => $nnnn5,
                            // 'mrp'=>$mrp,
                            'sellingprice' => $sellingprice,
                            't2_price' => $t2_price,
                            't2_min' => $t2_min,
                            't2_max' => $t2_max,
                            // 'gstrate'=>$gst,
                            // 'gstprice'=>$gstprice,
                            // 'sellingpricegst'=>$sp,
                            'productdescription' => $productdescription,
                            'modelno' => $modelno,
                            'weight' => $weight,
                            'feature_product' => $feature_product,
                            'popular_product' => $popular_product,
                            'brand' => $brand,
                            'resolution' => $resolution,
                            'irdistance' => $irdistance,
                            'cameratype' => $cameratype,
                            'bodymaterial' => $bodymaterial,
                            'videochannel' => $videochannel,
                            'poeports' => $poeports,
                            'poetype' => $poetype,
                            'sataports' => $sataports,
                            'length' => $length,
                            'screensize' => $screensize,
                            'ledtype' => $ledtype,
                            'size' => $size_data,
                            'lens' => $lens,
                            'max' => $max,
                            'night_vision' => $nv_data,
                            'audio_type' => $audiotype,
                            'ip' => $ip,
                            'added_by' => $addedby,
                            'is_active' => 1,
                            'date' => $cur_date
                        );
                        $last_id = $this->base_model->insert_table("tbl_products", $data_insert, 1);
                        $last_id3 = $last_id;
                        $inventory_data = array(
                            'product_id' => $last_id,
                            'quantity' => $inventory,
                            'ip' => $ip,
                            'date' => $addedby,
                            'added_by' => $cur_date
                        );
                        $last_id2 = $this->base_model->insert_table("tbl_inventory", $inventory_data, 1);
                        $this->db->select('*');
                        $this->db->from('tbl_products');
                        $this->db->where('id', $last_id3);
                        $get_products = $this->db->get()->row();
                        $c_id = $get_products->category_id;
                        $id1 = base64_encode($c_id);
                        if ($last_id != 0) {
                            $this->session->set_flashdata('smessage', 'Products inserted successfully');
                            redirect("dcadmin/Products/view_products/$id1", "refresh");
                        } else {
                            $this->session->set_flashdata('emessage', 'Sorry error occured');
                            redirect($_SERVER['HTTP_REFERER']);
                        }
                    }
                    if ($typ == 2) {
                        $idw = base64_decode($iw);
                        $this->db->select('*');
                        $this->db->from('tbl_products');
                        $this->db->where('id', $idw);
                        $dsa = $this->db->get();
                        $da = $dsa->row();
                        if (!empty($nnnn2)) {
                            $n1 = $nnnn2;
                        } else {
                            $n1 = $da->image;
                        }
                        if (!empty($nnnn3)) {
                            $n2 = $nnnn3;
                        } else {
                            $n2 = $da->image1;
                        }
                        if (!empty($nnnn4)) {
                            $n3 = $nnnn4;
                        } else {
                            $n3 = $da->video1;
                        }
                        if (!empty($nnnn5)) {
                            $n4 = $nnnn5;
                        } else {
                            $n4 = $da->video2;
                        }
                        $data_insert = array(
                            'productname' => $productname,
                            'category_id' => $category_id,
                            'subcategory_id' => $subcategory_id,
                            'minorcategory_id' => $minorcategory_id,
                            'image' => $n1,
                            'image1' => $n2,
                            'video1' => $n3,
                            'video2' => $n4,
                            // 'mrp'=>$mrp,
                            'sellingprice' => $sellingprice,
                            't2_price' => $t2_price,
                            't2_min' => $t2_min,
                            't2_max' => $t2_max,
                            // 'gstrate'=>$gst,
                            // 'gstprice'=>$gstprice,
                            // 'sellingpricegst'=>$sp,
                            'productdescription' => $productdescription,
                            'modelno' => $modelno,
                            // 'inventory'=>$inventory,
                            'weight' => $weight,
                            'feature_product' => $feature_product,
                            'popular_product' => $popular_product,
                            'brand' => $brand,
                            'resolution' => $resolution,
                            'irdistance' => $irdistance,
                            'cameratype' => $cameratype,
                            'bodymaterial' => $bodymaterial,
                            'videochannel' => $videochannel,
                            'poeports' => $poeports,
                            'poetype' => $poetype,
                            'sataports' => $sataports,
                            'length' => $length,
                            'screensize' => $screensize,
                            'ledtype' => $ledtype,
                            'size' => $size_data,
                            'lens' => $lens,
                            'max' => $max,
                            'night_vision' => $nv_data,
                            'audio_type' => $audiotype,
                        );
                        $this->db->where('id', $idw);
                        $last_id = $this->db->update('tbl_products', $data_insert);
                        $last_id3 = $idw;
                        $inventory_data = array(
                            'product_id' => $idw,
                            'quantity' => $inventory
                            // 'ip'=>$ip,
                            // 'date'=>$addedby,
                            // 'added_by'=>$cur_date
                        );
                        $this->db->where('product_id', $idw);
                        $last_id2 = $this->db->update("tbl_inventory", $inventory_data);
                        $this->db->select('*');
                        $this->db->from('tbl_products');
                        $this->db->where('id', $last_id3);
                        $get_products = $this->db->get()->row();
                        $c_id = $get_products->category_id;
                        $id1 = base64_encode($c_id);
                        if ($last_id != 0) {
                            $this->session->set_flashdata('smessage', 'Products updated successfully');
                            redirect("dcadmin/Products/view_products/$id1", "refresh");
                        } else {
                            $this->session->set_flashdata('emessage', 'Sorry error occured');
                            redirect($_SERVER['HTTP_REFERER']);
                        }
                    }
                } else {
                    $this->session->set_flashdata('emessage', validation_errors());
                    redirect($_SERVER['HTTP_REFERER']);
                }
            } else {
                $this->session->set_flashdata('emessage', 'Please insert some data, No data available');
                redirect($_SERVER['HTTP_REFERER']);
            }
        } else {
            redirect("login/admin_login", "refresh");
        }
    }
    public function updateproductsStatus($idd, $t)
    {
        if (!empty($this->session->userdata('admin_data'))) {
            $data['user_name'] = $this->load->get_var('user_name');
            // echo SITE_NAME;
            // echo $this->session->userdata('image');
            // echo $this->session->userdata('position');
            // exit;
            $id = base64_decode($idd);
            if ($t == "active") {
                $data_update = array(
                    'is_active' => 1
                );
                $this->db->where('id', $id);
                $zapak = $this->db->update('tbl_products', $data_update);
                if ($zapak != 0) {
                    $this->session->set_flashdata('smessage', 'Product status updated successfully');
                    redirect($_SERVER['HTTP_REFERER']);
                } else {
                    $this->session->set_flashdata('emessage', 'Sorry error occured');
                    redirect($_SERVER['HTTP_REFERER']);
                }
            }
            if ($t == "inactive") {
                $data_update = array(
                    'is_active' => 0
                );
                $this->db->where('id', $id);
                $zapak = $this->db->update('tbl_products', $data_update);
                $zapak = $this->db->delete('tbl_cart', array('product_id' => $id));
                $zapak = $this->db->delete('tbl_wishlist', array('product_id' => $id));
                if ($zapak != 0) {
                    $this->session->set_flashdata('smessage', 'Product status updated successfully');
                    redirect($_SERVER['HTTP_REFERER']);
                } else {
                    $this->session->set_flashdata('emessage', 'Sorry error occured');
                    redirect($_SERVER['HTTP_REFERER']);
                }
            }
        } else {
            redirect("login/admin_login", "refresh");
        }
    }
    public function delete_products($idd)
    {
        if (!empty($this->session->userdata('admin_data'))) {
            $data['user_name'] = $this->load->get_var('user_name');
            // echo SITE_NAME;
            // echo $this->session->userdata('image');
            // echo $this->session->userdata('position');
            // exit;
            $id = base64_decode($idd);
            if ($this->load->get_var('position') == "Super Admin") {
                $this->db->select('*');
                $this->db->from('tbl_products');
                $this->db->where('id', $id);
                $dsa = $this->db->get();
                $da = $dsa->row();
                // $img=$da->image;
                $zapak = $this->db->delete('tbl_products', array('id' => $id));
                $zapak = $this->db->delete('tbl_cart', array('product_id' => $id));
                $zapak = $this->db->delete('tbl_wishlist', array('product_id' => $id));
                if ($zapak != 0) {
                    // $path = FCPATH .$img;
                    //   unlink($path);
                    $this->session->set_flashdata('smessage', 'Product deleted successfully');
                    redirect($_SERVER['HTTP_REFERER']);
                } else {
                    $this->session->set_flashdata('emessage', 'Sorry error occured');
                    redirect($_SERVER['HTTP_REFERER']);
                }
            } else {
                $this->session->set_flashdata('emessage', 'Sorry you not a super admin you dont have permission to delete anything');
                redirect($_SERVER['HTTP_REFERER']);
            }
        } else {
            redirect("login/admin_login", "refresh");
        }
    }
    public function remove_video($idd, $t)
    {
        if (!empty($this->session->userdata('admin_data'))) {
            $data['user_name'] = $this->load->get_var('user_name');
            $id = base64_decode($idd);
            if ($t == "video1") {
                $data_update = array(
                    'video1' => ""
                );
                $this->db->where('id', $id);
                $zapak = $this->db->update('tbl_products', $data_update);
                if ($zapak != 0) {
                    $this->session->set_flashdata('smessage', 'Successfully Removed');
                    redirect($_SERVER['HTTP_REFERER']);
                } else {
                    $this->session->set_flashdata('emessage', 'Sorry error occured');
                    redirect($_SERVER['HTTP_REFERER']);
                }
            }
            if ($t == "video2") {
                $data_update = array(
                    'video2' => ""
                );
                $this->db->where('id', $id);
                $zapak = $this->db->update('tbl_products', $data_update);
                if ($zapak != 0) {
                    $this->session->set_flashdata('smessage', 'Successfully Removed');
                    redirect($_SERVER['HTTP_REFERER']);
                } else {
                    $this->session->set_flashdata('emessage', 'Sorry error occured');
                    redirect($_SERVER['HTTP_REFERER']);
                }
            }
        } else {
            $this->load->view('admin/login/index');
        }
    }
}
