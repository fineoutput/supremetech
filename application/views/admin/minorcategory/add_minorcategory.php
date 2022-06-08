<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css">

<div class="content-wrapper">
  <section class="content-header">
    <h1>
      Add New minorcategory
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo base_url() ?>dcadmin/home"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li><a href="<?php echo base_url() ?>dcadmin/Minorcategory/view_minorcategory"><i class="fa fa-dashboard"></i> All Minor Categories </a></li>
      <li class="active">View Coupon Codes</li>
    </ol>
  </section>
  <section class="content">
    <div class="row">
      <div class="col-lg-12">

        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-money fa-fw"></i> Add New minorcategory</h3>
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
              <form action=" <?php echo base_url()  ?>dcadmin/Minorcategory/add_minorcategory_data/<?php echo base64_encode(1);  ?>" method="POST" id="slide_frm" enctype="multipart/form-data">
                <div class="table-responsive">
                  <table class="table table-hover">
                    <tr>
                      <td> <strong>Category</strong> <span style="color:red;">*</span></strong> </td>
                      <td>
                        <select class="form-control" id="cid" name="category_id">
                          <option value="">Please select category</option>

                          <?php

       foreach ($category_data->result() as $value) {?>
                          <option value="<?=$value->id;?>" required><?=$value->category;?></option>
                          <?php }?>
                        </select>

                      </td>
                    </tr>
                    <tr>
                      <td> <strong>Sub-Category</strong> <span style="color:red;">*</span></strong> </td>
                      <td>
                        <select class="form-control" id="sid" name="subcategory_id">
                          <option value="">Please select Subcategory</option>

                          <?php

   foreach ($subcategory_data->result() as $value) {?>
                          <option value="<?=$value->id;?>" required><?=$value->subcategory;?></option>
                          <?php }?>
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <td> <strong>Minor Category</strong> <span style="color:red;">*</span></strong> </td>
                      <td> <input type="text" name="minorcategoryname" class="form-control" placeholder="" required value="" /> </td>
                    </tr>
                    <tr>
                      <td> <strong>Image</strong> <span style="color:red;">*</span></strong> </td>
                      <td> <input type="file" name="fileToUpload1" class="form-control" placeholder="" required value="" /> </td>
                    </tr>

                    <tr>
                      <td> <strong>Brand</strong> </strong> </td>
                      <td>
                        <select class="selectpicker form-control" multiple="multiple" name="brand[]">
                          <?php foreach ($brand_data->result() as $value) {?>
                          <option value="<?=$value->id;?>"><?=$value->name?></option>

                          <?php } ?>
                        </select>
                      </td>
                      <td> <strong>Resolution</strong> </strong> </td>
                      <td>
                        <select class="selectpicker form-control" multiple="multiple" name="resolution[]">
                          <?php foreach ($resolution_data->result() as $value) {?>
                          <option value="<?=$value->id;?>"><?=$value->filtername?></option>

                          <?php } ?>
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <td> <strong>IR Distance</strong> </strong> </td>
                      <td>
                        <select class="selectpicker form-control" multiple="multiple" name="ir_distance[]">
                          <?php foreach ($irdistance_data->result() as $value) {?>
                          <option value="<?=$value->id;?>"><?=$value->filtername?></option>

                          <?php } ?>
                        </select>
                      </td>
                      <td> <strong>Body Type</strong> </strong> </td>
                      <td>
                        <select class="selectpicker form-control" multiple="multiple" name="camera_type[]">
                          <?php foreach ($cameratype_data->result() as $value) {?>
                          <option value="<?=$value->id;?>"><?=$value->filtername?></option>

                          <?php } ?>
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <td> <strong>Body Material</strong></strong> </td>
                      <td>
                        <select class="selectpicker form-control" multiple="multiple" name="body_materials[]">
                          <?php foreach ($bodymaterial_data->result() as $value) {?>
                          <option value="<?=$value->id;?>"><?=$value->filter_name?></option>

                          <?php } ?>
                        </select>
                      </td>
                      <td> <strong>No. of channel</strong> </strong> </td>
                      <td>
                        <select class="selectpicker form-control" multiple="multiple" name="video_channel[]">
                          <?php foreach ($videochannel_data->result() as $value) {?>
                          <option value="<?=$value->id;?>"><?=$value->filter_name?></option>

                          <?php } ?>
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <td> <strong>POE Ports</strong> </strong> </td>
                      <td>
                        <select class="selectpicker form-control" multiple="multiple" name="poe_ports[]">
                          <?php foreach ($poeports_data->result() as $value) {?>
                          <option value="<?=$value->id;?>"><?=$value->filter_name?></option>

                          <?php } ?>
                        </select>
                      </td>
                      <td> <strong>POE Types</strong> </strong> </td>
                      <td>
                        <select class="selectpicker form-control" multiple="multiple" name="poe_type[]">
                          <?php foreach ($poetype_data->result() as $value) {?>
                          <option value="<?=$value->id;?>"><?=$value->filter_name?></option>

                          <?php } ?>
                        </select>
                      </td>
                    </tr>

                    <tr>
                      <td> <strong>SATA Ports</strong> </strong> </td>
                      <td>
                        <select class="selectpicker form-control" multiple="multiple" name="sata_ports[]">
                          <?php foreach ($sataports_data->result() as $value) {?>
                          <option value="<?=$value->id;?>"><?=$value->filter_name?></option>

                          <?php } ?>
                        </select>
                      </td>
                      <td> <strong>Length</strong> </strong> </td>
                      <td>
                        <select class="selectpicker form-control" multiple="multiple" name="length[]">
                          <?php foreach ($length_data->result() as $value) {?>
                          <option value="<?=$value->id;?>"><?=$value->filter_name?></option>

                          <?php } ?>
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <td> <strong>Screen Size</strong> </strong> </td>
                      <td>
                        <select class="selectpicker form-control" multiple="multiple" name="screen_size[]">
                          <?php foreach ($screensize_data->result() as $value) {?>
                          <option value="<?=$value->id;?>"><?=$value->filter_name?></option>

                          <?php } ?>
                        </select>
                      </td>
                      <td> <strong>Features</strong> </strong> </td>
                      <td>
                        <select class="selectpicker form-control" multiple="multiple" name="led_type[]">
                          <?php foreach ($ledtype_data->result() as $value) {?>
                          <option value="<?=$value->id;?>"><?=$value->filter_name?></option>

                          <?php } ?>
                        </select>
                      </td>

                    <tr>
                      <td> <strong>Size</strong> </strong> </td>
                      <td>
                        <select class="selectpicker form-control" multiple="multiple" name="size[]">
                          <?php foreach ($size_data->result() as $value) {?>
                          <option value="<?=$value->id;?>"><?=$value->filter_name?></option>

                          <?php } ?>
                        </select>
                      </td>
                      <td> <strong>Lens</strong></strong> </td>
                      <td>
                        <select class="selectpicker form-control" multiple="multiple" name="lens[]">
                          <?php foreach ($lens_data->result() as $value) {?>
                          <option value="<?=$value->id;?>"><?=$value->filtername?></option>

                          <?php } ?>
                        </select>
                      </td>
                    </tr>

                    <tr>
                      <td> <strong>Night Vision</strong> </strong> </td>
                      <td>
                        <select class="selectpicker form-control" multiple="multiple" name="night_vision[]">
                          <?php foreach ($night_vision_data->result() as $value) {?>
                          <option value="<?=$value->id;?>"><?=$value->filtername?></option>

                          <?php } ?>
                        </select>
                      </td>
                      <td> <strong>Audio Type</strong></strong> </td>
                      <td>
                        <select class="selectpicker form-control" multiple="multiple" name="audio_type[]">
                          <?php foreach ($audio_type_data->result() as $value) {?>
                          <option value="<?=$value->id;?>"><?=$value->filtername?></option>

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
          // url:base_url+"dcadmin/products/getMinorcategory?isl="+vf,
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
