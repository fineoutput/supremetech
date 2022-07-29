<div class="content-wrapper">
  <section class="content-header">
    <h1>
      Add New Products
    </h1>

  </section>
  <section class="content">
    <div class="row">
      <div class="col-lg-12">

        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-money fa-fw"></i> Add New Products</h3>
          </div>

          <? if(!empty($this->session->flashdata('smessage'))){  ?>
          <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4><i class="icon fa fa-check"></i> Alert!</h4>
            <? echo $this->session->flashdata('smessage');  ?>
          </div>
          <? }
                                              if(!empty($this->session->flashdata('emessage'))){  ?>
          <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4><i class="icon fa fa-ban"></i> Alert!</h4>
            <? echo $this->session->flashdata('emessage');  ?>
          </div>
          <? }  ?>


          <div class="panel-body">
            <div class="col-lg-10">
              <form action=" <?php echo base_url()  ?>dcadmin/Products/add_products_data/<? echo base64_encode(1);  ?>" method="POST" id="slide_frm" enctype="multipart/form-data">
                <div class="table-responsive">
                  <table class="table table-hover">


                    <tr>
                      <td> <strong>Product Name</strong> <span style="color:red;">*</span> </td>
                      <td> <input type="text" name="productname" class="form-control" placeholder="" required value="" /> </td>
                    </tr>

                    <input type="hidden" name="category_id" value="<?=base64_decode($id)?>">

                    <!-- <tr>
<td> <strong>Category </strong>  <span style="color:red;">*</span> </td>
<td>
    <select class="form-control" id="cid" name="category_id">
      <option value="">Please select category</option>

      <?

       foreach($category_data->result() as $value) {?>
         <option value="<?=$value->id;?>"><?=$value->category;?></option>
       <? }?>
    </select>
  </td>
</tr> -->

                    <tr>
                      <td> <strong>Subcategory </strong> <span style="color:red;">*</span> </td>
                      <td>
                        <select class="form-control" id="sid" name="subcategory_id" required>
                          <option value="">Please select subcategory</option>
                          <?

       foreach($subcategory_data->result() as $value) {?>
                          <option value="<?=$value->id;?>"><?=$value->subcategory;?></option>
                          <? }?>
                        </select>


                      </td>
                    </tr>
                    <tr>
                      <td> <strong>Minor Category</strong> <span style="color:red;">*</span> </td>
                      <td>
                        <select class="form-control" id="mid" name="minorcategory_id" required>
                          <option>Select Subcategory First</option>
                        </select>
                      </td>
                    </tr>

                    <tr>
                      <td> <strong>Image</strong> <span style="color:red;">*<br />1447X799</span> </td>
                      <td> <input type="file" name="image" required class="form-control" placeholder="" value="" /> </td>
                    </tr>
                    <tr>
                      <td> <strong>Image1</strong> <span style="color:red;">*<br />1447X799</span> </td>
                      <td> <input type="file" name="image1" required class="form-control" placeholder="" value="" /> </td>
                    </tr>
                    <tr>
                      <td> <strong>Video1</strong>  <span style="color:red;">*<br />Landscape</span> </td>
                      <td> <input type="file" name="video1" class="form-control" placeholder="" value="" /> </td>
                    </tr>
                    <tr>
                      <td> <strong>Video2</strong> <span style="color:red;">*<br />Landscape</span> </td>
                      <td> <input type="file" name="video2" class="form-control" placeholder="" value="" /> </td>
                    </tr>
                    <!-- <tr>
                      <td> <strong>Price</strong> <span style="color:red;">*</span> </td>
                      <td> <input type="number" name="mrp" required class="form-control" id="mrp" placeholder="" value="" /> </td>
                    </tr> -->
                    <!-- <tr> -->
                    <tr>
                      <td> <strong>Price</strong> <span style="color:red;">*</span> </td>
                      <td> <input type="number" required name="sellingprice" class="form-control" id="sellingprice" placeholder="" value="" /> </td>
                    </tr>
                    <!-- <tr>
<td> <strong>Gst %</strong>  <span style="color:red;"></span> </td>
<td> <input type="number" name="gst" id="gst"  class="form-control" placeholder=""  value="" />  </td>
</tr>
  <tr>
<td> <strong>Gst Price</strong>  <span style="color:red;"></span> </td>
<td> <input type="text" name="gstprice" id="gstprice"  class="form-control" placeholder=""  value="" />  </td>
</tr>
  <tr>
<td> <strong>Selling price</strong>  <span style="color:red;">*</span> </td>
<td> <input type="number" name="sp" id="sp" class="form-control" placeholder="" required value="" />  </td>
</tr> -->
                    <tr>
                      <td> <strong>Product Description</strong> <span style="color:red;">*</span> </td>
                      <td> <textarea name="productdescription" required id="editor1" rows="3" cols="80"></textarea> </td>
                    </tr>
                    <tr>
                      <td> <strong>Model No.</strong> <span style="color:red;">*</span> </td>
                      <td> <input type="text" name="modelno" class="form-control" placeholder="" required value="" /> </td>
                    </tr>
                    <tr>
                      <td> <strong>Inventory</strong> <span style="color:red;">*</span> </td>
                      <td> <input type="number" name="Inventory" class="form-control" placeholder="" required value="" /> </td>
                    </tr>
                    <tr>
                      <td> <strong>Weight</strong> <span style="color:red;">*<br/>in grams</span> </td>
                      <td> <input type="text" onkeypress="return valide_weight(event)" name="weight" class="form-control" placeholder="" required value="" /> </td>
                    </tr>
                    <tr>
                      <td> <strong>Featured Product</strong> <span style="color:red;">*</span> </td>
                      <td> <select class="form-control" id="featurepid" name="feature_product"> />
                        <option value="no">No</option>
                          <option value="yes">Yes</option>
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <td> <strong>Popular Product</strong> <span style="color:red;">*</span> </td>
                      <td> <select class="form-control" id="polpularpid" name="popular_product"> />
                        <option value="no">No</option>
                          <option value="yes">Yes</option>
                        </select>
                      </td>
                    </tr>




                    <tr>
                      <td> <strong>Brand</strong> <span style="color:red;"></span> </td>
                      <td> <select class="form-control" id="brand" name="brands"> />
                          <option>Select Minorcategory first</option>
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <td> <strong>Resolution</strong> <span style="color:red;"></span> </td>
                      <td> <select class="form-control" id="resolution" name="resolution"> />
                          <option>Select Minorcategory first</option>
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <td> <strong>Lens</strong> <span style="color:red;"></span> </td>
                      <td> <select class="form-control" id="lens" name="lens"> />
                          <option>Select Minorcategory first</option>
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <td> <strong>IR Distance</strong> <span style="color:red;"></span> </td>
                      <td> <select class="form-control" id="irdistance" name="irdistance"> />
                          <option>Select Minorcategory first</option>
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <td> <strong>Camera type</strong> <span style="color:red;"></span> </td>
                      <td> <select class="form-control" id="camera" name="cameratype"> />
                          <option>Select Minorcategory first</option>
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <td> <strong>Body Material</strong> <span style="color:red;"></span> </td>
                      <td> <select class="form-control" id="bodymaterial" name="bodymaterial"> />
                          <option>Select Minorcategory first</option>
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <td> <strong>Video Channel</strong> <span style="color:red;"></span> </td>
                      <td> <select class="form-control" id="videochannel" name="videochannel"> />
                          <option>Select Minorcategory first</option>
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <td> <strong>Ports</strong> <span style="color:red;"></span> </td>
                      <td> <select class="form-control" id="povport" name="poeports"> />
                          <option>Select Minorcategory first</option>
                      </td>
                    </tr>
                    <tr>
                      <td> <strong>Switch Type</strong> <span style="color:red;"></span> </td>
                      <td> <select class="form-control" id="povtype" name="poetype"> />
                          <option>Select Minorcategory first</option>
                      </td>
                      </select>
                      </td>
                    </tr>
                    <tr>
                      <td> <strong>SATA Ports</strong> <span style="color:red;"></span> </td>
                      <td> <select class="form-control" id="sataports" name="sataports"> />
                          <option>Select Minorcategory first</option>
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <td> <strong>Length</strong> <span style="color:red;"></span> </td>
                      <td> <select class="form-control" id="length" name="length"> />
                        <option>Select Minorcategory first</option>
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <td> <strong>Screen Size</strong> <span style="color:red;"></span> </td>
                      <td> <select class="form-control" id="screensize" name="screensize"> />
                          <option>Select Minorcategory first</option>
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <td> <strong>LED Type</strong> <span style="color:red;"></span> </td>
                      <td> <select class="form-control" id="ledtype" name="ledtype"> />
                          <option>Select Minorcategory first</option>
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <td> <strong>Size</strong> <span style="color:red;"></span> </td>
                      <td> <select class="form-control" id="size" name="size_data"> />
                        <option>Select Minorcategory first</option>
                      </td>
                    </tr>
                    <tr>
                      <td> <strong>Night Vision</strong> <span style="color:red;"></span> </td>
                      <td> <select class="form-control" id="nightvision" name="nv_data"> />
                          <option>Select Minorcategory first</option>
                      </td>
                    </tr>
                    <tr>
                      <td> <strong>Inbuilt Audio</strong> <span style="color:red;"></span> </td>
                      <td> <select class="form-control" id="audiotype" name="audiotype"> />
                          <option>Select Minorcategory first</option>
                      </td>
                    </tr>
                    <tr>
                      <td> <strong>Max Limit</strong> <span style="color:red;">*</span> </td>
                      <td>
                        <input type="text" name="max" class="form-control" value="" required>
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

<script type="text/javascript">
  function valide_weight(evt) {
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode != 46 && charCode > 31 &&
      (charCode < 48 || charCode > 57))
      return false;

    return true;

  }
</script>


<script type="text/javascript" src=" <?php echo base_url()  ?>assets/slider/ajaxupload.3.5.js"></script>
<link href=" <? echo base_url()  ?>assets/cowadmin/css/jqvmap.css" rel='stylesheet' type='text/css' />
<script src="<?php echo base_url() ?>assets/admin/plugins/ckeditor/ckeditor.js"></script>

<script>
  $(document).ready(function() {
    $("#sid").change(function() {
      var vf = $(this).val();
      // var yr = $("#year_id option:selected").val();
      if (vf == "") {
        return false;

      } else {
        $('#mid option').remove();
        var opton = "<option value=''>Please Select </option>";
        $.ajax({
          url: base_url + "dcadmin/Products/getMinorcategory?isl=" + vf,
          // url:base_url+"dcadmin/Products/getMinorcategory?isl="+vf,
          data: '',
          type: "get",
          success: function(html) {
            if (html != "NA") {
              var s = jQuery.parseJSON(html);
              $.each(s, function(i) {
                opton += '<option value="' + s[i]['min_id'] + '">' + s[i]['min_name'] + '</option>';
              });
              $('#mid').append(opton);
              //$('#city').append("<option value=''>Please Select State</option>");

              //var json = $.parseJSON(html);
              //var ayy = json[0].name;
              //var ayys = json[0].pincode;
            } else {
              alert('No Minor category Found');
              return false;
            }

          }

        })
      }


    })
  });
</script>
<script>
  // Replace the <textarea id="editor1"> with a CKEditor

  // instance, using default configuration.

  CKEDITOR.replace('editor1');
  // CKEDITOR.replace( 'editor2' );
  // CKEDITOR.replace( 'editor3' );
  //
</script>

<script type="text/javascript">
  $(document).ready(function() {
    $('#gst').keyup(function() {

      var price = $('#sellingprice').val();
      // alert("hello" + price);
      var gst = $('#gst').val();
      //alert('hello '+ price +"gst"+gst);

      $('#gstprice').val(price * gst / 100);

      // var sprice=$('#gstprice').val();
      var v1 = parseInt($('#sellingprice').val());
      var v2 = parseInt($('#gstprice').val());
      var v3 = v1 + v2;
      $('#sp').val(v3);

    });

  });
</script>
<script>
  $(document).on('change', '#mid', function() {
    // Does some stuff and logs the event to the console
    // alert("u");
    $("#brand").html("");
    $("#resolution").html("");
    $("#lens").html("");
    $("#irdistance").html("");
    $("#camera").html("");
    $("#bodymaterial").html("");
    $("#videochannel").html("");
    $("#povport").html("");
    $("#povtype").html("");
    $("#sataports").html("");
    $("#length").html("");
    $("#screensize").html("");
    $("#ledtype").html("");
    $("#size").html("");
    $("#nightvision").html("");
    $("#audiotype").html("");
    var selectedminor = $("#mid").val();

    var base_url = "<?=base_url()?>";
    // alert(base_url);
    $.ajax({
      url: base_url + 'dcadmin/Products/set_filters',
      method: 'POST',
      data: {
        minorid: selectedminor,
      },
      dataType: 'json',
      success: function(response) {
        // alert(response);
        if (response.data == true) {

          var brands = response.brands;
          var resolution = response.resolution;
          var lens = response.lens;
          var irdistance = response.irdistance;
          var camera_type = response.camera_type;
          var body_material = response.body_material;
          var video_channel = response.video_channel;
          var pov_ports = response.pov_ports;
          var pov_type = response.pov_type;
          var sata_ports = response.sata_ports;
          var length = response.length;
          var screen_size = response.screen_size;
          var led_type = response.led_type;
          var size = response.size;
          var night_vision = response.night_vision;
          var audio_type = response.audio_type;
          if(brands.length == ""){
            options = '<option value="">No Brands found</option>';
            $("#brand").append(options);
          }else{
            brands = jQuery.parseJSON(brands);
            $.each(brands, function(i, item) {
              options = '<option value="' + item.id + '">' + item.name + '</option>';
              $("#brand").append(options);
              // // die();
            });
          }
          if(resolution.length == ""){
            options = '<option value="">No resolution found</option>';
            $("#resolution").append(options);
          }else{
            resolution = jQuery.parseJSON(resolution);
            $.each(resolution, function(i, item) {
              options = '<option value="' + item.id + '">' + item.name + '</option>';
              $("#resolution").append(options);
              // die();
            });
          }
          if(camera_type.length == ""){
            options = '<option value="">No Camera Type found</option>';
            $("#camera").append(options);
          }else{
              camera_type = jQuery.parseJSON(camera_type);
            $.each(camera_type, function(i, item) {
              options = '<option value="' + item.id + '">' + item.name + '</option>';
              $("#camera").append(options);
              // die();
            });
          }
          if(irdistance.length == ""){
            options = '<option value="">No IR Distance found</option>';
            $("#irdistance").append(options);
          }else{
              irdistance = jQuery.parseJSON(irdistance);
            $.each(irdistance, function(i, item) {
              options = '<option value="' + item.id + '">' + item.name + '</option>';
              $("#irdistance").append(options);
              // die();
            });
          }
          if(body_material.length == ""){
            options = '<option value="">No Body Material found</option>';
            $("#bodymaterial").append(options);
          }else{
              body_material = jQuery.parseJSON(body_material);
            $.each(body_material, function(i, item) {
              options = '<option value="' + item.id + '">' + item.name + '</option>';
              $("#bodymaterial").append(options);
              // die();
            });
          }
          if(lens.length == ""){
            options = '<option value="">No Lens found</option>';
            $("#lens").append(options);
          }else{
              lens = jQuery.parseJSON(lens);
            $.each(lens, function(i, item) {
              options = '<option value="' + item.id + '">' + item.name + '</option>';
              $("#lens").append(options);
              // die();
            });
          }
          if(video_channel.length == ""){
            options = '<option value="">No Video Channel found</option>';
            $("#videochannel").append(options);
          }else{
            video_channel = jQuery.parseJSON(video_channel);
            $.each(video_channel, function(i, item) {
              options = '<option value="' + item.id + '">' + item.name + '</option>';
              $("#videochannel").append(options);
              // die();
            });
          }
          if(pov_ports.length == ""){
            options = '<option value="">No POE Ports found</option>';
            $("#povport").append(options);
          }else{
            pov_ports = jQuery.parseJSON(pov_ports);
            $.each(pov_ports, function(i, item) {
              options = '<option value="' + item.id + '">' + item.name + '</option>';
              $("#povport").append(options);
              // die();
            });
          }
          if(pov_type.length == ""){
            options = '<option value="">No POE Type found</option>';
            $("#povtype").append(options);
          }else{
            pov_type = jQuery.parseJSON(pov_type);
            $.each(pov_type, function(i, item) {
              options = '<option value="' + item.id + '">' + item.name + '</option>';
              $("#povtype").append(options);
              // die();
            });
          }
          if(sata_ports.length == ""){
            options = '<option value="">No Sata Ports found</option>';
            $("#sataports").append(options);
          }else{
            sata_ports = jQuery.parseJSON(sata_ports);
            $.each(sata_ports, function(i, item) {
              options = '<option value="' + item.id + '">' + item.name + '</option>';
              $("#sataports").append(options);
              // die();
            });
          }
          if(length.length == ""){
            options = '<option value="">No Length found</option>';
            $("#length").append(options);
          }else{
            length = jQuery.parseJSON(length);
            $.each(length, function(i, item) {
              options = '<option value="' + item.id + '">' + item.name + '</option>';
              $("#length").append(options);
              // die();
            });
          }
          if(screen_size.length == ""){
            options = '<option value="">No Screeen Size  found</option>';
            $("#screensize").append(options);
          }else{
            screen_size = jQuery.parseJSON(screen_size);
            $.each(screen_size, function(i, item) {
              options = '<option value="' + item.id + '">' + item.name + '</option>';
              $("#screensize").append(options);
              // die();
            });
          }
          if(led_type.length == ""){
            options = '<option value="">No Led Type found</option>';
            $("#ledtype").append(options);
          }else{
            led_type = jQuery.parseJSON(led_type);
            $.each(led_type, function(i, item) {
              options = '<option value="' + item.id + '">' + item.name + '</option>';
              $("#ledtype").append(options);
              // die();
            });
          }
          if(size.length == ""){
            options = '<option value="">No Size found</option>';
            $("#size").append(options);
          }else{
            size = jQuery.parseJSON(size);
            $.each(size, function(i, item) {
              options = '<option value="' + item.id + '">' + item.name + '</option>';
              $("#size").append(options);
              // die();
            });
          }
          if(night_vision.length == ""){
            options = '<option value="">No Night Vison found</option>';
            $("#nightvision").append(options);
          }else{
            night_vision = jQuery.parseJSON(night_vision);
            $.each(night_vision, function(i, item) {
              options = '<option value="' + item.id + '">' + item.name + '</option>';
              $("#nightvision").append(options);
              // die();
            });
          }
          if(audio_type.length == ""){
            options = '<option value="">No Audio Type found</option>';
            $("#audiotype").append(options);
          }else{
            audio_type = jQuery.parseJSON(audio_type);
            $.each(audio_type, function(i, item) {
              options = '<option value="' + item.id + '">' + item.name + '</option>';
              $("#audiotype").append(options);
              // die();
            });
          }




        } else {
          alert('hiii');
        }
      }
    });


  });
</script>
