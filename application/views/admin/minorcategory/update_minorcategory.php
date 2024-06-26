<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css">

<div class="content-wrapper">
  <section class="content-header">
    <h1>
      Update Minor category
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo base_url() ?>dcadmin/home"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li><a href="<?php echo base_url() ?>dcadmin/Minorcategory/view_minorcategory"><i class="fa fa-dashboard"></i> All Minor Categories </a></li>
    </ol>
  </section>
  <section class="content">
    <div class="row">
      <div class="col-lg-12">

        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-money fa-fw"></i> Update Minor category</h3>
          </div>

          <?php if (!empty($this->session->flashdata('smessage'))) {  ?>
          <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4><i class="icon fa fa-check"></i> Alert!</h4>
            <?php echo $this->session->flashdata('smessage');  ?>
          </div>
          <?php }
                                              if (!empty($this->session->flashdata('emessage'))) {  ?>
          <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4><i class="icon fa fa-ban"></i> Alert!</h4>
            <?php echo $this->session->flashdata('emessage');  ?>
          </div>
          <?php }  ?>


          <div class="panel-body">
            <div class="col-lg-10">
              <form action=" <?php echo base_url()  ?>dcadmin/Minorcategory/add_minorcategory_data/<?php echo base64_encode(2);?>/<?=$id?>" method="POST" id="slide_frm" enctype="multipart/form-data">
                <div class="table-responsive">
                  <table class="table table-hover">
                    <tr>
                      <td> <strong>Category</strong> <span style="color:red;">*</span></strong> </td>
                      <td>
                        <select class="form-control" id="cid" name="category_id">


                          <?php

       foreach ($category_data->result() as $value) {?>
                          <option value="<?=$value->id;?>" <?php if ($minorcategory_data->category_id == $value->id) {
           echo "selected";
       } ?>><?=$value->category;?></option>
                          <?php }?>
                        </select>

                      </td>
                    </tr>
                    <tr>
                      <td> <strong>Sub-Category</strong> <span style="color:red;">*</span></strong> </td>
                      <td>
                        <select class="form-control" id="sid" name="subcategory_id">


                          <?php

   foreach ($subcategory_data->result() as $value1) {?>
                          <option value="<?=$value1->id;?>" <?php if ($minorcategory_data->subcategory_id == $value1->id) {
       echo "selected";
   } ?>><?=$value1->subcategory;?></option>
                          <?php }?>
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <td> <strong>Minor Category</strong> <span style="color:red;">*</span></strong> </td>
                      <td> <input type="text" name="minorcategoryname" class="form-control" placeholder="" value="<?=$minorcategory_data->minorcategoryname?>" /> </td>
                    </tr>
                    <tr>
                      <td> <strong>Image</strong> <span style="color:red;"><br />300X300</span></strong> </td>
                      <td> <input type="file" name="fileToUpload1" class="form-control" placeholder="" value="" />

                        <?php if ($minorcategory_data->image!="") { ?>
                        <img id="slide_img_path" height=50 width=100 src="<?php echo base_url().$minorcategory_data->image
  ?>">
                        <?php } else { ?>
                        Sorry No File Found
                        <?php } ?>



                      </td>
                    </tr>

                    <tr>
                      <td> <strong>Brand</strong> </strong> </td>
                      <td>
                        <select class="selectpicker form-control" multiple="multiple" name="brand[]">
                          <?php
                          $brands=json_decode($minorcategory_data->brand);
                          foreach ($brand_data->result() as $value) {
                            $a=0;
                            if(!empty($brands)){
                            foreach ($brands as $data) {
                            if($data==$value->id){
                              $a=1;
                            }
                          }}
                            ?>
                          <option value="<?=$value->id;?>" <?if($a==1){echo "selected" ;}?>><?=$value->name?></option>

                        <?php  }?>
                        </select>
                      </td>
                      <td> <strong>Resolution</strong> </strong> </td>
                      <td>
                        <select class="selectpicker form-control" multiple="multiple" name="resolution[]">
                          <?php
                          $resolution=json_decode($minorcategory_data->resolution);
                           foreach ($resolution_data->result() as $value) {
                             $a=0;
                             if(!empty($resolution)){
                             foreach ($resolution as $data) {
                             if($data==$value->id){
                               $a=1;
                             }
                           }}
                             ?>
                          <option value="<?=$value->id;?>" <?if($a==1){echo "selected" ;}?>><?=$value->filtername?></option>

                          <?php } ?>
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <td> <strong>IR Distance</strong> </strong> </td>
                      <td>
                        <select class="selectpicker form-control" multiple="multiple" name="ir_distance[]">
                          <?php
                          $ir_distance=json_decode($minorcategory_data->ir_distance);
                           foreach ($irdistance_data->result() as $value) {
                             $a=0;
                             if(!empty($ir_distance)){
                             foreach ($ir_distance as $data) {
                             if($data==$value->id){
                               $a=1;
                             }
                           }}
                             ?>
                          <option value="<?=$value->id;?>" <?if($a==1){echo "selected" ;}?>><?=$value->filtername?></option>

                          <?php } ?>
                        </select>
                      </td>
                      <td> <strong>Body Type</strong> </strong> </td>
                      <td>
                        <select class="selectpicker form-control" multiple="multiple" name="camera_type[]">
                          <?php
                          $camera_type=json_decode($minorcategory_data->camera_type);
                           foreach ($cameratype_data->result() as $value) {
                             $a=0;
                             if(!empty($camera_type)){
                             foreach ($camera_type as $data) {
                             if($data==$value->id){
                               $a=1;
                             }
                           }}
                             ?>
                          <option value="<?=$value->id;?>" <?if($a==1){echo "selected" ;}?>><?=$value->filtername?></option>

                          <?php } ?>
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <td> <strong>Body Material</strong> </strong> </td>
                      <td>
                        <select class="selectpicker form-control" multiple="multiple" name="body_materials[]">
                          <?php
                          $body_materials=json_decode($minorcategory_data->body_materials);

                           foreach ($bodymaterial_data->result() as $value) {
                             $a=0;
                             if(!empty($body_materials)){
                             foreach ($body_materials as $data) {
                             if($data==$value->id){
                               $a=1;
                             }
                           }}
                             ?>
                          <option value="<?=$value->id;?>" <?if($a==1){echo "selected" ;}?>><?=$value->filter_name?></option>

                          <?php } ?>
                        </select>
                      </td>
                      <td> <strong>No. of channel</strong> </strong> </td>
                      <td>
                        <select class="selectpicker form-control" multiple="multiple" name="video_channel[]">
                          <?php
                          $video_channel=json_decode($minorcategory_data->video_channel);
                           foreach ($videochannel_data->result() as $value) {
                             $a=0;
                             if(!empty($video_channel)){
                             foreach ($video_channel as $data) {
                             if($data==$value->id){
                               $a=1;
                             }
                           }}
                             ?>
                          <option value="<?=$value->id;?>" <?if($a==1){echo "selected" ;}?>><?=$value->filter_name?></option>

                          <?php } ?>
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <td> <strong>POE Ports</strong> </strong> </td>
                      <td>
                        <select class="selectpicker form-control" multiple="multiple" name="poe_ports[]">
                          <?php
                          $poe_ports=json_decode($minorcategory_data->poe_ports);
                           foreach ($poeports_data->result() as $value) {
                             $a=0;
                             if(!empty($poe_ports)){
                             foreach ($poe_ports as $data) {
                             if($data==$value->id){
                               $a=1;
                             }
                           }}
                             ?>
                          <option value="<?=$value->id;?>" <?if($a==1){echo "selected" ;}?>><?=$value->filter_name?></option>

                          <?php } ?>
                        </select>
                      </td>
                      <td> <strong>POE Types</strong> </strong> </td>
                      <td>
                        <select class="selectpicker form-control" multiple="multiple" name="poe_type[]">
                          <?php
                          $poe_type=json_decode($minorcategory_data->poe_type);
                          foreach ($poetype_data->result() as $value) {
                            $a=0;
                             if(!empty($poe_type)){
                            foreach ($poe_type as $data) {
                            if($data==$value->id){
                              $a=1;
                            }
                          }}
                            ?>
                          <option value="<?=$value->id;?>" <?if($a==1){echo "selected" ;}?>><?=$value->filter_name?></option>

                          <?php } ?>
                        </select>
                      </td>
                    </tr>

                    <tr>
                      <td> <strong>SATA Ports</strong> </strong> </td>
                      <td>
                        <select class="selectpicker form-control" multiple="multiple" name="sata_ports[]">
                          <?php
                          $sata_ports=json_decode($minorcategory_data->sata_ports);
                          foreach ($sataports_data->result() as $value) {
                            $a=0;
                             if(!empty($sata_ports)){
                             foreach ($sata_ports as $data) {
                             if($data==$value->id){
                               $a=1;
                             }
                           }}
                            ?>
                          <option value="<?=$value->id;?>" <?if($a==1){echo "selected" ;}?>><?=$value->filter_name?></option>

                          <?php } ?>
                        </select>
                      </td>
                      <td> <strong>Length</strong> </strong> </td>
                      <td>
                        <select class="selectpicker form-control" multiple="multiple" name="length[]">
                          <?php
                          $length=json_decode($minorcategory_data->length);
                          foreach ($length_data->result() as $value) {
                            $a=0;
                             if(!empty($length)){
                             foreach ($length as $data) {
                             if($data==$value->id){
                               $a=1;
                             }
                           }}
                            ?>
                          <option value="<?=$value->id;?>" <?if($a==1){echo "selected" ;}?>><?=$value->filter_name?></option>

                          <?php } ?>
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <td> <strong>Screen Size</strong> </strong> </td>
                      <td>
                        <select class="selectpicker form-control" multiple="multiple" name="screen_size[]">
                          <?php
                          $screen_size=json_decode($minorcategory_data->screen_size);
                          foreach ($screensize_data->result() as $value) {
                            $a=0;
                             if(!empty($screen_size)){
                             foreach ($screen_size as $data) {
                             if($data==$value->id){
                               $a=1;
                             }
                           }}
                            ?>
                          <option value="<?=$value->id;?>" <?if($a==1){echo "selected" ;}?>><?=$value->filter_name?></option>

                          <?php } ?>
                        </select>
                      </td>
                      <td> <strong>Features</strong> </strong> </td>
                      <td>
                        <select class="selectpicker form-control" multiple="multiple" name="led_type[]">
                          <?php
                          $led_type=json_decode($minorcategory_data->led_type);
                          foreach ($ledtype_data->result() as $value) {
                            $a=0;
                             if(!empty($led_type)){
                          foreach ($led_type as $data) {
                          if($data==$value->id){
                            $a=1;
                          }
                        }}
                            ?>
                          <option value="<?=$value->id;?>" <?if($a==1){echo "selected" ;}?>><?=$value->filter_name?></option>

                          <?php } ?>
                        </select>
                      </td>

                    <tr>
                      <td> <strong>Size</strong> </strong> </td>
                      <td>
                        <select class="selectpicker form-control" multiple="multiple" name="size[]">
                          <?php
                          $size=json_decode($minorcategory_data->size);
                           foreach ($size_data->result() as $value) {
                             $a=0;
                              if(!empty($size)){
                             foreach ($size as $data) {
                             if($data==$value->id){
                               $a=1;
                             }
                           }}
                             ?>
                          <option value="<?=$value->id;?>" <?if($a==1){echo "selected" ;}?>><?=$value->filter_name?></option>

                          <?php } ?>
                        </select>
                      </td>
                      <td> <strong>Lens</strong> </strong> </td>
                      <td>
                        <select class="selectpicker form-control" multiple="multiple" name="lens[]">
                          <?php
                          $lens=json_decode($minorcategory_data->lens);
                          foreach ($lens_data->result() as $value) {
                            $a=0;
                             if(!empty($lens)){
                            foreach ($lens as $data) {
                            if($data==$value->id){
                              $a=1;
                            }
                          }}
                            ?>
                          <option value="<?=$value->id;?>" <?if($a==1){echo "selected" ;}?>><?=$value->filtername?></option>

                          <?php } ?>
                        </select>
                      </td>
                    </tr>

                    <tr>
                      <td> <strong>Night Vision</strong> </strong> </td>
                      <td>
                        <select class="selectpicker form-control" multiple="multiple" name="night_vision[]">
                          <?php
                          $nv_data=json_decode($minorcategory_data->night_vision);
                           foreach ($night_vision_data->result() as $value) {
                             $a=0;
                              if(!empty($nv_data)){
                             foreach ($nv_data as $data) {
                             if($data==$value->id){
                               $a=1;
                             }
                           }}
                             ?>
                          <option value="<?=$value->id;?>" <?if($a==1){echo "selected" ;}?>><?=$value->filtername?></option>

                          <?php } ?>
                        </select>
                      </td>
                      <td> <strong>Audio Type</strong> </strong> </td>
                      <td>
                        <select class="selectpicker form-control" multiple="multiple" name="audio_type[]">
                          <?php
                          $audio =json_decode($minorcategory_data->audio_type);
                          foreach ($audio_type_data->result() as $value) {
                            $a=0;
                             if(!empty($audio)){
                            foreach ($audio as $data) {
                            if($data==$value->id){
                              $a=1;
                            }
                          }}
                            ?>
                          <option value="<?=$value->id;?>" <?if($a==1){echo "selected" ;}?>><?=$value->filtername?></option>

                          <?php } ?>
                        </select>
                      </td>
                    </tr>


                    <tr>
                      <td colspan="2">
                        <input type="submit" class="btn btn-success" value="save">
                      </td>
                    </tr>
                  </table>
                </div>

              </form>

            </div>



          </div>

        </div>

      </div>
    </div>
  </section>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script>


<script type="text/javascript" src=" <?php echo base_url()  ?>assets/slider/ajaxupload.3.5.js"></script>
<link href=" <?php echo base_url()  ?>assets/cowadmin/css/jqvmap.css" rel='stylesheet' type='text/css' />
<script type="text/javascript">
  $(document).ready(function() {
    $('.selectpicker').multiselect();
  });
</script>
<script>
  $(document).ready(function() {
    $("#cid").change(function() {
      var vf = $(this).val();
      // var yr = $("#year_id option:selected").val();
      if (vf == "") {
        return false;

      } else {
        $('#sid option').remove();
        var opton = "<option value=''>Please Select </option>";
        $.ajax({
          url: base_url + "dcadmin/Minorcategory/getSubcategory?isl=" + vf,
          // url:base_url+"dcadmin/Products/getMinorcategory?isl="+vf,
          data: '',
          type: "get",
          success: function(html) {
            if (html != "NA") {
              var s = jQuery.parseJSON(html);
              $.each(s, function(i) {
                opton += '<option value="' + s[i]['sub_id'] + '">' + s[i]['sub_name'] + '</option>';
              });
              $('#sid').append(opton);
              //$('#city').append("<option value=''>Please Select State</option>");

              //var json = $.parseJSON(html);
              //var ayy = json[0].name;
              //var ayys = json[0].pincode;
            } else {
              alert('No Subcategory Found');
              return false;
            }

          }

        })
      }


    })
  });
</script>
