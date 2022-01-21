<?php
    if ( ! defined('BASEPATH')) exit('No direct script access allowed');
       require_once(APPPATH . 'core/CI_finecontrol.php');
       class Products extends CI_finecontrol{
       function __construct()
           {
             parent::__construct();
             $this->load->model("login_model");
             $this->load->model("admin/base_model");
             $this->load->library('user_agent');
             $this->load->library('upload');
           }

         public function view_products($idd){

            if(!empty($this->session->userdata('admin_data'))){


              $data['user_name']=$this->load->get_var('user_name');

              // echo SITE_NAME;
              // echo $this->session->userdata('image');
              // echo $this->session->userdata('position');
              // exit;
              //  $id=base64_decode($idd);

 $id=base64_decode($idd);
 $data['id']=$idd;

                           $this->db->select('*');
               $this->db->from('tbl_products');
               $this->db->where('category_id',$id);
               $data['products_data']= $this->db->get();

               //             $this->db->select('*');
               // $this->db->from('tbl_inventory');
               // // $this->db->where('',$usr);
               // $data['inventory_data']= $this->db->get();

              $this->load->view('admin/common/header_view',$data);
              $this->load->view('admin/products/view_products');
              $this->load->view('admin/common/footer_view');

          }
          else{

             redirect("login/admin_login","refresh");
          }

          }
          public function view_product_categories(){

             if(!empty($this->session->userdata('admin_data'))){

               $this->db->select('*');
              $this->db->from('tbl_category');
               $this->db->where('is_active',1);
                $data['category_data']= $this->db->get();


               $this->load->view('admin/common/header_view',$data);
               $this->load->view('admin/products/view_product_categories');
               $this->load->view('admin/common/footer_view');

           }
           else{

              redirect("login/admin_login","refresh");
           }

           }

              public function add_products($idd){

                 if(!empty($this->session->userdata('admin_data'))){

 $id=base64_decode($idd);
$data['id']=$idd;


            $this->db->select('*');
$this->db->from('tbl_category');
$this->db->where('is_active',1);
$data['category_data']= $this->db->get();

            $this->db->select('*');
$this->db->from('tbl_subcategory');
$this->db->where('category_id',$id);
$this->db->where('is_active',1);
$data['subcategory_data']= $this->db->get();

            $this->db->select('*');
$this->db->from('tbl_minorcategory');
$this->db->where('is_active',1);
$data['minorcategory_data']= $this->db->get();

//Brands
$this->db->select('*');
            $this->db->from('tbl_brands');
            //$this->db->where('_id',$id);
            $data['brand_data']= $this->db->get();

//resolution
$this->db->select('*');
            $this->db->from('tbl_resolution');
            //$this->db->where('_id',$id);
            $data['resolution_data']= $this->db->get();
//Lens
$this->db->select('*');
            $this->db->from('tbl_lens');
            //$this->db->where('_id',$id);
            $data['lens_data']= $this->db->get();
// ir Distance
$this->db->select('*');
            $this->db->from('tbl_irdistance');
            //$this->db->where('_id',$id);
            $data['distance_data']= $this->db->get();
//camera type
$this->db->select('*');
            $this->db->from('tbl_cameratype');
            //$this->db->where('_id',$id);
            $data['camera_data']= $this->db->get();

  // body Material
  $this->db->select('*');
              $this->db->from('tbl_bodymaterial');
              //$this->db->where('_id',$id);
              $data['body_data']= $this->db->get();
  // video Channel
  $this->db->select('*');
              $this->db->from('tbl_videochannel');
              //$this->db->where('_id',$id);
              $data['video_data']= $this->db->get();
// poe Ports
$this->db->select('*');
            $this->db->from('tbl_poeports');
            //$this->db->where('_id',$id);
            $data['port_data']= $this->db->get();
  // SATA ports
  $this->db->select('*');
              $this->db->from('tbl_sataports');
              //$this->db->where('_id',$id);
              $data['sata_data']= $this->db->get();

  //Length
  $this->db->select('*');
              $this->db->from('tbl_length');
              //$this->db->where('_id',$id);
              $data['length_data']= $this->db->get();
//screen size
$this->db->select('*');
            $this->db->from('tbl_screensize');
            //$this->db->where('_id',$id);
            $data['screen_data']= $this->db->get();
//led type
$this->db->select('*');
            $this->db->from('tbl_ledtype');
            //$this->db->where('_id',$id);
            $data['led_data']= $this->db->get();

//size
$this->db->select('*');
            $this->db->from('tbl_size');
            //$this->db->where('_id',$id);
            $data['size_data']= $this->db->get();

                   $this->load->view('admin/common/header_view',$data);
                   $this->load->view('admin/products/add_products');
                   $this->load->view('admin/common/footer_view');

               }
               else{

                  redirect("login/admin_login","refresh");
               }

               }

public function getSubcategory(){

                   // $data['user_name']=$this->load->get_var('user_name');

                   // echo SITE_NAME;
                   // echo $this->session->userdata('image');
                   // echo $this->session->userdata('position');
                   // exit;

$id=$_GET['isl'];
            $this->db->select('*');
$this->db->from('tbl_subcategory');
$this->db->where('category_id',$id);
$this->db->where('is_active',1);

$dat= $this->db->get();

$i=1; foreach($dat->result() as $data) {

$igt[] = array('sub_id' =>$data->id ,'sub_name'=>$data->subcategory);

}


echo json_encode($igt);


               }
               public function getMinorcategory(){

                                  // $data['user_name']=$this->load->get_var('user_name');

                                  // echo SITE_NAME;
                                  // echo $this->session->userdata('image');
                                  // echo $this->session->userdata('position');
                                  // exit;

               $id=$_GET['isl'];
                           $this->db->select('*');
               $this->db->from('tbl_minorcategory');
               $this->db->where('subcategory_id',$id);
               $this->db->where('is_active',1);
               $dat= $this->db->get();
$igt1=[];
               $i=1; foreach($dat->result() as $data) {

               $igt1[] = array('min_id' =>$data->id ,'min_name'=>$data->minorcategoryname);

               }


               echo json_encode($igt1);


                              }

               public function update_products($idd,$idd1){

                   if(!empty($this->session->userdata('admin_data'))){


                     $data['user_name']=$this->load->get_var('user_name');

                     // echo SITE_NAME;
                     // echo $this->session->userdata('image');
                     // echo $this->session->userdata('position');
                     // exit;

                      $id=base64_decode($idd);
                     $data['id']=$idd;

                     $id1=base64_decode($idd1);
                    $data['id1']=$idd1;

                            $this->db->select('*');
                            $this->db->from('tbl_products');
                            $this->db->where('id',$id);
                            $data['products_data']= $this->db->get()->row();


                            $this->db->select('*');
                            $this->db->from('tbl_category');
                            $this->db->where('is_active',1);
                            $data['category_data']= $this->db->get();

                                        $this->db->select('*');
                            $this->db->from('tbl_subcategory');
                            $this->db->where('category_id',$id1);
                            $this->db->where('is_active',1);
                            $data['subcategory_data']= $this->db->get();

                                        $this->db->select('*');
                            $this->db->from('tbl_minorcategory');
                            $this->db->where('is_active',1);
                            $data['minorcategory_data']= $this->db->get();

                                        $this->db->select('*');
                            $this->db->from('tbl_inventory');
                            $this->db->where('product_id',$id);
                            $data['inventory_data']= $this->db->get()->row();

                            //Brands
                            $this->db->select('*');
                                        $this->db->from('tbl_brands');
                                        //$this->db->where('_id',$id);
                                        $data['brand_data']= $this->db->get();

                            //resolution
                            $this->db->select('*');
                                        $this->db->from('tbl_resolution');
                                        //$this->db->where('_id',$id);
                                        $data['resolution_data']= $this->db->get();
                            //Lens
                            $this->db->select('*');
                                        $this->db->from('tbl_lens');
                                        //$this->db->where('_id',$id);
                                        $data['lens_data']= $this->db->get();
                            // ir Distance
                            $this->db->select('*');
                                        $this->db->from('tbl_irdistance');
                                        //$this->db->where('_id',$id);
                                        $data['distance_data']= $this->db->get();
                            //camera type
                            $this->db->select('*');
                                        $this->db->from('tbl_cameratype');
                                        //$this->db->where('_id',$id);
                                        $data['camera_data']= $this->db->get();

                              // body Material
                              $this->db->select('*');
                                          $this->db->from('tbl_bodymaterial');
                                          //$this->db->where('_id',$id);
                                          $data['body_data']= $this->db->get();
                              // video Channel
                              $this->db->select('*');
                                          $this->db->from('tbl_videochannel');
                                          //$this->db->where('_id',$id);
                                          $data['video_data']= $this->db->get();
                            // poe Ports
                            $this->db->select('*');
                                        $this->db->from('tbl_poeports');
                                        //$this->db->where('_id',$id);
                                        $data['port_data']= $this->db->get();
                              // SATA ports
                              $this->db->select('*');
                                          $this->db->from('tbl_sataports');
                                          //$this->db->where('_id',$id);
                                          $data['sata_data']= $this->db->get();

                              //Length
                              $this->db->select('*');
                                          $this->db->from('tbl_length');
                                          //$this->db->where('_id',$id);
                                          $data['length_data']= $this->db->get();
                            //screen size
                            $this->db->select('*');
                                        $this->db->from('tbl_screensize');
                                        //$this->db->where('_id',$id);
                                        $data['screen_data']= $this->db->get();
                            //led type
                            $this->db->select('*');
                                        $this->db->from('tbl_ledtype');
                                        //$this->db->where('_id',$id);
                                        $data['led_data']= $this->db->get();

                            //size
                            $this->db->select('*');
                                        $this->db->from('tbl_size');
                                        //$this->db->where('_id',$id);
                                        $data['size_data']= $this->db->get();




                     $this->load->view('admin/common/header_view',$data);
                     $this->load->view('admin/products/update_products');
                     $this->load->view('admin/common/footer_view');

                 }
                 else{

                    redirect("login/admin_login","refresh");
                 }

                 }

             public function add_products_data($t,$iw="")

               {

                 if(!empty($this->session->userdata('admin_data'))){


             $this->load->helper(array('form', 'url'));
             $this->load->library('form_validation');
             $this->load->helper('security');
             if($this->input->post())
             {
               // print_r($this->input->post());
               // exit;
  $this->form_validation->set_rules('productname', 'productname', 'required|trim');
  $this->form_validation->set_rules('category_id', 'category_id', 'required|trim');
  $this->form_validation->set_rules('subcategory_id', 'subcategory_id', 'required|trim');
  $this->form_validation->set_rules('minorcategory_id', 'minorcategory_id', 'required|trim');
  $this->form_validation->set_rules('mrp', 'mrp', 'trim|integer');
  $this->form_validation->set_rules('sellingprice', 'sellingprice', 'trim');
  $this->form_validation->set_rules('gst', 'gst', 'trim');
  $this->form_validation->set_rules('gstprice', 'gstprice', 'trim');
  $this->form_validation->set_rules('sp', 'sp', 'required|trim');

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




               if($this->form_validation->run()== TRUE)
               {
  $productname=$this->input->post('productname');
  $category_id=$this->input->post('category_id');
  $subcategory_id=$this->input->post('subcategory_id');
  $minorcategory_id=$this->input->post('minorcategory_id');
  $mrp=$this->input->post('mrp');
  $sellingprice=$this->input->post('sellingprice');
  $gst=$this->input->post('gst');
  $gstprice=$this->input->post('gstprice');
  $sp=$this->input->post('sp');

  $productdescription=$this->input->post('productdescription');
  $modelno=$this->input->post('modelno');
  $inventory=$this->input->post('Inventory');
  $weight=$this->input->post('weight');
  $feature_product=$this->input->post('feature_product');
  $popular_product=$this->input->post('popular_product');

  //filter
  $brand=$this->input->post('brands');
  $resolution=$this->input->post('resolution');
  $lens=$this->input->post('lens');
  $irdistance=$this->input->post('irdistance');
  $cameratype=$this->input->post('cameratype');
  $bodymaterial=$this->input->post('bodymaterial');
  $videochannel=$this->input->post('videochannel');
  $poeports=$this->input->post('poeports');
  $poetype=$this->input->post('poetype');
  $sataports=$this->input->post('sataports');
  $length=$this->input->post('length');
  $screensize=$this->input->post('screensize');
  $ledtype=$this->input->post('ledtype');
  $size_data=$this->input->post('size_data');
  $max=$this->input->post('max');



  if($feature_product == 'yes'){
     $feature_product=1;

  }else{
    $feature_product=0;
  }

  if($popular_product == 'yes'){
     $popular_product=1;

  }else{
    $popular_product=0;
  }





$img2='image';




                  $image_upload_folder = FCPATH . "assets/uploads/products/";
                     if (!file_exists($image_upload_folder))
                     {
                         mkdir($image_upload_folder, DIR_WRITE_MODE, true);
                     }
                     $new_file_name="products".date("Ymdhms");
                     $this->upload_config = array(
                             'upload_path'   => $image_upload_folder,
                             'file_name' => $new_file_name,
                             'allowed_types' =>'jpg|jpeg|png',
                             'max_size'      => 25000
                     );
                     $this->upload->initialize($this->upload_config);

                         if (!$this->upload->do_upload($img2))
                         {
                           $nnnn2="";

                         }
                         else
                         {
                         $file_info = $this->upload->data();

                         $videoNAmePath = "assets/uploads/products/".$new_file_name.$file_info['file_ext'];
                         $file_info['new_name']=$videoNAmePath;
                         // $this->step6_model->updateappIconImage($imageNAmePath,$appInfoId);
                         $nnnn=$file_info['file_name'];
                         $nnnn2=$videoNAmePath;

                         // echo json_encode($file_info);
                       }



//-------------





$img3='image1';




         $image_upload_folder = FCPATH . "assets/uploads/products/";
                     if (!file_exists($image_upload_folder))
                     {
                         mkdir($image_upload_folder, DIR_WRITE_MODE, true);
                     }
                     $new_file_name="products1".date("Ymdhms");
                     $this->upload_config = array(
                             'upload_path'   => $image_upload_folder,
                             'file_name' => $new_file_name,
                             'allowed_types' =>'jpg|jpeg|png',
                             'max_size'      => 25000
                     );
                     $this->upload->initialize($this->upload_config);

                     if (!$this->upload->do_upload($img3))
                     {
                       $nnnn3="";

                     }
                     else
                     {


                         $file_info = $this->upload->data();

                         $videoNAmePath = "assets/uploads/products/".$new_file_name.$file_info['file_ext'];
                         $file_info['new_name']=$videoNAmePath;
                         // $this->step6_model->updateappIconImage($imageNAmePath,$appInfoId);
                         $nnnn=$file_info['file_name'];
                         $nnnn3=$videoNAmePath;

                         // echo json_encode($file_info);
                       }





$img4='video1';




         $image_upload_folder = FCPATH . "assets/uploads/products/";
                     if (!file_exists($image_upload_folder))
                     {
                         mkdir($image_upload_folder, DIR_WRITE_MODE, true);
                     }
                     $new_file_name="products2".date("Ymdhms");
                     $this->upload_config = array(
                             'upload_path'   => $image_upload_folder,
                             'file_name' => $new_file_name,
                             'allowed_types' =>'mp4|MOV|WMV|FLV|AVI|WebM|MKV',
                             'max_size'      => 25000
                     );
                     $this->upload->initialize($this->upload_config);
                     if (!$this->upload->do_upload($img4))
                     {
                       $nnnn4="";

                     }
                     else
                     {


                         $file_info = $this->upload->data();

                         $videoNAmePath = "assets/uploads/products/".$new_file_name.$file_info['file_ext'];
                         $file_info['new_name']=$videoNAmePath;
                         // $this->step6_model->updateappIconImage($imageNAmePath,$appInfoId);
                         $nnnn=$file_info['file_name'];
                         $nnnn4=$videoNAmePath;

                         // echo json_encode($file_info);
                       }





$img5='video2';




         $image_upload_folder = FCPATH . "assets/uploads/products/";
                     if (!file_exists($image_upload_folder))
                     {
                         mkdir($image_upload_folder, DIR_WRITE_MODE, true);
                     }
                     $new_file_name="products3".date("Ymdhms");
                     $this->upload_config = array(
                             'upload_path'   => $image_upload_folder,
                             'file_name' => $new_file_name,
                             'allowed_types' =>'mp4|MOV|WMV|FLV|AVI|WebM|MKV',
                             'max_size'      => 25000
                     );
                     $this->upload->initialize($this->upload_config);
                     if (!$this->upload->do_upload($img5))
                     {
                       $nnnn5="";

                     }
                     else
                     {


                         $file_info = $this->upload->data();

                         $videoNAmePath = "assets/uploads/products/".$new_file_name.$file_info['file_ext'];
                         $file_info['new_name']=$videoNAmePath;
                         // $this->step6_model->updateappIconImage($imageNAmePath,$appInfoId);
                         $nnnn=$file_info['file_name'];
                         $nnnn5=$videoNAmePath;

                         // echo json_encode($file_info);
                       }


                     $typ=base64_decode($t);
                     // $last_id = 0;



                                        $ip = $this->input->ip_address();
                                        date_default_timezone_set("Asia/Calcutta");
                                        $cur_date=date("Y-m-d H:i:s");
                                        $addedby=$this->session->userdata('admin_id');

                     if($typ==1){





           $data_insert = array(
                  'productname'=>$productname,
                  'category_id'=>$category_id,
  'subcategory_id'=>$subcategory_id,
  'minorcategory_id'=>$minorcategory_id,
  'image'=>$nnnn2,
  'image1'=>$nnnn3,
  'video1'=>$nnnn4,
  'video2'=>$nnnn5,
  'mrp'=>$mrp,
  'sellingprice'=>$sellingprice,
  'gstrate'=>$gst,
  'gstprice'=>$gstprice,
  'sellingpricegst'=>$sp,

  'productdescription'=>$productdescription,
  'modelno'=>$modelno,
  'weight'=>$weight,

  'feature_product'=>$feature_product,
  'popular_product'=>$popular_product,
  'brand'=>$brand,
  'resolution'=>$resolution,
  'irdistance'=>$irdistance,
  'cameratype'=>$cameratype,
  'bodymaterial'=>$bodymaterial,
  'videochannel'=>$videochannel,
  'poeports'=>$poeports,
  'poetype'=>$poetype,
  'sataports'=>$sataports,
  'length'=>$length,
  'screensize'=>$screensize,
  'ledtype'=>$ledtype,
  'size'=>$size_data,
  'lens'=>$lens,
  'max'=>$max,



                     'ip' =>$ip,
                     'added_by' =>$addedby,
                     'is_active' =>1,
                     'date'=>$cur_date
                     );


           $last_id=$this->base_model->insert_table("tbl_products",$data_insert,1) ;
           $last_id3=$last_id;

          $inventory_data = array(
            'product_id'=> $last_id,
            'quantity'=>$inventory,
            'ip'=>$ip,
            'date'=>$addedby,
            'added_by'=>$cur_date

          );
          $last_id2=$this->base_model->insert_table("tbl_inventory",$inventory_data,1) ;

           }
           if($typ==2){

    $idw=base64_decode($iw);


 $this->db->select('*');
 $this->db->from('tbl_products');
 $this->db->where('id',$idw);
 $dsa=$this->db->get();
 $da=$dsa->row();

if(!empty($nnnn2)){
  $n1=$nnnn2;

}else{
  $n1=$da->image;
}


if(!empty($nnnn3)){
  $n2=$nnnn3;

}else{
  $n2=$da->image1;
}


if(!empty($nnnn4)){
  $n3=$nnnn4;

}else{
  $n3=$da->video1;
}

if(!empty($nnnn5)){
  $n4=$nnnn5;

}else{
  $n4=$da->video2;
}






$data_insert = array(
       'productname'=>$productname,
       'category_id'=>$category_id,
'subcategory_id'=>$subcategory_id,
'minorcategory_id'=>$minorcategory_id,
'image'=>$n1,
'image1'=>$n2,
'video1'=>$n3,
'video2'=>$n4,
'mrp'=>$mrp,
'sellingprice'=>$sellingprice,
'gstrate'=>$gst,
'gstprice'=>$gstprice,
'sellingpricegst'=>$sp,
'productdescription'=>$productdescription,
'weight'=>$modelno,
// 'inventory'=>$inventory,
'weight'=>$weight,
'feature_product'=>$feature_product,
'popular_product'=>$popular_product,

'brand'=>$brand,
'resolution'=>$resolution,
'irdistance'=>$irdistance,
'cameratype'=>$cameratype,
'bodymaterial'=>$bodymaterial,
'videochannel'=>$videochannel,
'poeports'=>$poeports,
'poetype'=>$poetype,
'sataports'=>$sataports,
'length'=>$length,
'screensize'=>$screensize,
'ledtype'=>$ledtype,
'size'=>$size_data,
'lens'=>$lens,
'max'=>$max


                     );

             $this->db->where('id', $idw);
             $last_id=$this->db->update('tbl_products', $data_insert);
$last_id3=$idw;
             $inventory_data = array(
               'product_id'=> $idw,
               'quantity'=>$inventory
               // 'ip'=>$ip,
               // 'date'=>$addedby,
               // 'added_by'=>$cur_date

             );
             $this->db->where('product_id', $idw);
             $last_id2=$this->db->update("tbl_inventory",$inventory_data) ;
           }
    $this->db->select('*');
                $this->db->from('tbl_products');
                $this->db->where('id',$last_id3);
                $get_products= $this->db->get()->row();

            $c_id= $get_products->category_id;
           $id1=base64_encode($c_id);




                       if($last_id!=0){
                               $this->session->set_flashdata('smessage','Data inserted successfully');
                                redirect("dcadmin/products/view_products/$id1","refresh");
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

               public function updateproductsStatus($idd,$t){

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
                       $zapak=$this->db->update('tbl_products', $data_update);

                            if($zapak!=0){
                              $this->session->set_flashdata('smessage','Update successfully');
                                redirect($_SERVER['HTTP_REFERER']);
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
                         $zapak=$this->db->update('tbl_products', $data_update);

                             if($zapak!=0){
                               $this->session->set_flashdata('smessage','Update successfully');
                                 redirect($_SERVER['HTTP_REFERER']);
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



               public function delete_products($idd){

                      if(!empty($this->session->userdata('admin_data'))){

                        $data['user_name']=$this->load->get_var('user_name');

                        // echo SITE_NAME;
                        // echo $this->session->userdata('image');
                        // echo $this->session->userdata('position');
                        // exit;
                        $id=base64_decode($idd);

                       if($this->load->get_var('position')=="Super Admin"){

                     $this->db->select('*');
                     $this->db->from('tbl_products');
                     $this->db->where('id',$id);
                     $dsa= $this->db->get();
                     $da=$dsa->row();
                     // $img=$da->image;

 $zapak=$this->db->delete('tbl_products', array('id' => $id));
 if($zapak!=0){
        // $path = FCPATH .$img;
        //   unlink($path);
        $this->session->set_flashdata('smessage','Delete successfully');
          redirect($_SERVER['HTTP_REFERER']);
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

      ?>
