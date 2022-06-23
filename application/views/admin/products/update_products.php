<div class="content-wrapper">
  <section class="content-header">
    <h1>
      Update Products
    </h1>

  </section>
  <section class="content">
    <div class="row">
      <div class="col-lg-12">

        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-money fa-fw"></i>Update Products</h3>
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
              <form action=" <?php echo base_url()  ?>dcadmin/Products/add_products_data/<? echo base64_encode(2);?>/<?=$id;?>" method="POST" id="slide_frm" enctype="multipart/form-data">
                <div class="table-responsive">
                  <table class="table table-hover">
                    <tr>
                      <td> <strong>Product Name</strong> <span style="color:red;">*</span></strong> </td>
                      <td> <input type="text" name="productname" class="form-control" placeholder="" required value="<?=$products_data->productname?>" /> </td>
                    </tr>


                    <input type="hidden" name="category_id" value="<?=base64_decode($id1)?>">

                    <tr>
                      <td> <strong>Subcategory Name</strong> <span style="color:red;">*</span></strong> </td>
                      <td>
                        <select class="form-control" id="sid" name="subcategory_id">
                          <?

  foreach($subcategory_data->result() as $value) {?>
                          <option value="<?=$value->id;?>" <?php if($products_data->subcategory_id == $value->id){ echo "selected"; } ?>><?=$value->subcategory;?></option>
                          <? }?>
                        </select>


                      </td>
                    </tr>
                    <tr>
                      <td> <strong>Minor Category Name</strong> <span style="color:red;">*</span></strong> </td>
                      <td>
                        <select class="form-control" id="mid" name="minorcategory_id">
                          <?

  foreach($minorcategory_data->result() as $value) {?>
                          <option value="<?=$value->id;?>" <?php if($products_data->minorcategory_id == $value->id){ echo "selected"; } ?>><?=$value->minorcategoryname;?></option>
                          <? }?>
                        </select>


                      </td>
                    </tr>

                    <tr>
                      <td> <strong>Image</strong> <span style="color:red;"><br />1447X799</span></strong> </td>
                      <td> <input type="file" name="image" class="form-control" placeholder="" value="<?=$products_data->image?>" /> </td>
                      <td>
                        <?php if($products_data->image!=""){  ?>
                        <img id="slide_img_path" height=50 width=100 src="<?php echo base_url() ?><?php echo $products_data->image; ?>">
                        <?php }else {  ?>
                        Sorry No image Found
                        <?php } ?>
                      </td>
                    </tr>
                    <tr>
                      <td> <strong>Image 1</strong> <span style="color:red;"><br />1447X799</span></strong> </td>
                      <td> <input type="file" name="image1" class="form-control" placeholder="" value="<?=$products_data->image1?>" /> </td>
                      <td>
                        <?php if($products_data->image1!=""){  ?>
                        <img id="slide_img_path" height=50 width=100 src="<?php echo base_url() ?><?php echo $products_data->image1; ?>">
                        <?php }else {  ?>
                        Sorry No image Found
                        <?php } ?>
                      </td>
                    </tr>
                    <tr>
                      <td> <strong>Video 1</strong> <span style="color:red;"><br />Landscape</span></td>
                      <td> <input type="file" name="video1" class="form-control" placeholder="" value="<?=$products_data->video1?>" />
                       </td>
                      <td>
                        <?php if($products_data->video1!=""){  ?>
                        <video id="slide_img_path" height=50 width=100 src="<?php echo base_url() ?><?php echo $products_data->video1; ?>" muted autoplay poster=""></video><br />
                          <a href="<?=base_url()?>dcadmin/Products/remove_video/<?php echo base64_encode($products_data->id) ?>/video1">Remove</a>
                          <?php }else {  ?>
                          Sorry No Video Found
                          <?php } ?>
                      </td>
                    </tr>
                    <tr>
                      <td> <strong>Video 2</strong> <span style="color:red;"><br />Landscape</span> </td>
                      <td> <input type="file" name="video2" class="form-control" placeholder="" value="<?=$products_data->video2?>" /></td>
                      <td>
                        <?php if($products_data->video2!=""){  ?>
                        <!-- <img id="slide_img_path" height=50 width=100  src="<?php echo base_url() ?><?php echo $products_data->video2; ?>"> -->
                        <video id="slide_img_path" height=50 width=100 src="<?php echo base_url() ?><?php echo $products_data->video2; ?>" muted autoplay poster=""></video><br />
                          <a href="<?=base_url()?>dcadmin/Products/remove_video/<?php echo base64_encode($products_data->id) ?>/video2">Remove</a>
                          <?php }else {  ?>
                          Sorry No Video Found
                          <?php } ?>
                      </td>
                    </tr>
                    <!-- <tr>
                      <td> <strong>Price</strong> <span style="color:red;">*</span></strong> </td>
                      <td> <input type="number" name="mrp" required class="form-control" placeholder="" value="<?=$products_data->mrp?>" /> </td>
                    </tr> -->
                   <tr>
<td> <strong>Price</strong>  <span style="color:red;">*</span></strong> </td>
<td> <input type="number" required name="sellingprice" id="sellingprice"  class="form-control" placeholder=""  value="<?=$products_data->sellingprice?>" />  </td>
</tr>
<!--<tr>
<td> <strong>Gst %</strong>  <span style="color:red;"></span></strong> </td>
<td> <input type="number" name="gst" id="gst"  class="form-control" placeholder=""  value="<?=$products_data->gstrate?>" />  </td>
</tr>
<tr>
<td> <strong>Gst Price</strong>  <span style="color:red;"></span></strong> </td>
<td> <input type="text" name="gstprice" id="gstprice"  class="form-control" placeholder=""  value="<?=$products_data->gstprice?>" />  </td>
</tr> -->
                    <!-- <tr>
                      <td> <strong>Selling price</strong> <span style="color:red;">*</span></strong> </td>
                      <td> <input type="number" name="sp" id="sp" class="form-control" placeholder="" required value="<?=$products_data->sellingpricegst?>" /> </td>
                    </tr> -->




                    <tr>
                      <td> <strong>Product Description</strong> <span style="color:red;">*</span></strong> </td>
                      <td> <textarea name="productdescription" required id="editor1" rows="3" cols="80"><?=$products_data->productdescription?></textarea> </td>
                    </tr>
                    <tr>
                      <td> <strong>Model No.</strong> <span style="color:red;">*</span></strong> </td>
                      <td> <input type="text" name="modelno" required class="form-control" placeholder="" value="<?=$products_data->modelno?>" /> </td>
                    </tr>
                    <tr>
                      <td> <strong>Inventory</strong> <span style="color:red;">*</span></strong> </td>
                      <td> <input type="number" name="Inventory" class="form-control" placeholder="" value="<? if(!empty($inventory_data->quantity)){ echo $data1=$inventory_data->quantity;}else { echo $data1="";}?>" /> </td>
                    </tr>
                    <tr>
                      <td> <strong>Weight</strong> <span style="color:red;">*<br/>in grams</span></strong> </td>
                      <td> <input type="number" name="weight" class="form-control" placeholder="" value="<?=$products_data->weight?>" /> </td>
                    </tr>
                    <td> <strong>Feature Product</strong> <span style="color:red;">*</span></strong> </td>
                    <td> <select class="form-control" id="featurepid" name="feature_product" value="<?=$products_data->feature_product?>"> />
                        <option value="yes">Yes</option>
                        <option value="no">No</option>
                      </select>
                    </td>
                    </tr>
                    <tr>
                      <td> <strong>Most selling Product</strong> <span style="color:red;">*</span></strong> </td>
                      <td> <select class="form-control" id="polpularpid" name="popular_product" value="<?=$products_data->popular_product?>"> />
                          <option value="yes">Yes</option>
                          <option value="no">No</option>
                        </select>
                      </td>
                    </tr>




                    <tr>
                      <td> <strong>Brand</strong> <span style="color:red;">*</span></strong> </td>
                      <td> <select class="form-control" id="brand" name="brands" value="<?=$products_data->brand?>"> />
                          <!-- <option value="" selected>Select Brand</option> -->
                          <?php foreach ($brands_data as $brands) { ?>
                          <option value="<?=$brands['id'];?>" <?php if($products_data->brand == $brands['id']){ echo "selected"; } ?>><?=$brands['name'];?></option>
                          <? } ?>
                        </select>
                      </td>
                    </tr>

                    <tr>
                      <td> <strong>Resolution</strong> <span style="color:red;">*</span></strong> </td>
                      <td> <select class="form-control" id="resolution" name="resolution" value="<?=$products_data->resolution?>"> />
                          <!-- <option value="" selected>Select Resolution</option> -->
                          <?php foreach ($resolution_data as $resolution) { ?>
                          <option value="<?=$resolution['id'];?>" <?php if($products_data->resolution == $resolution['id']){ echo "selected"; } ?>><?=$resolution['name'];?></option>
                          <? } ?>
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <td> <strong>Lens</strong> <span style="color:red;">*</span></strong> </td>
                      <td> <select class="form-control" id="lens" name="lens" value="<?=$products_data->lens?>"> />
                          <!-- <option value="" selected>Select Lens</option> -->
                          <?php foreach ($lens_data as $lens) { ?>
                          <option value="<?=$lens['id'];?>" <?php if($products_data->lens == $lens['id']){ echo "selected"; } ?>><?=$lens['name'];?></option>
                          <? } ?>
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <? //print_r($brands_data);die();?>
                      <td> <strong>IR Distance</strong> <span style="color:red;">*</span></strong> </td>
                      <td> <select class="form-control" id="irdistance" name="irdistance" value="<?=$products_data->irdistance?>"> />
                          <!-- <option value="" selected>Select IR Distance</option> -->
                          <?php foreach ($irdistance_data as $distance) { ?>
                          <option value="<?=$distance['id'];?>" <?php if($products_data->irdistance == $distance['id']){ echo "selected"; } ?>><?=$distance['name'];?></option>
                          <? } ?>
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <td> <strong>Camera type</strong> <span style="color:red;">*</span></strong> </td>
                      <td> <select class="form-control" id="camera" name="cameratype" value="<?=$products_data->cameratype?>"> />
                          <!-- <option value="" selected>Select Camera type</option> -->
                          <?php foreach ($camera_type as $camera) { ?>
                          <option value="<?=$camera['id'];?>" <?php if($products_data->cameratype == $camera['id']){ echo "selected"; } ?>><?=$camera['name'];?></option>
                          <? } ?>
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <td> <strong>Body Material</strong> <span style="color:red;">*</span></strong> </td>
                      <td> <select class="form-control" id="bodymaterial" name="bodymaterial" value="<?=$products_data->bodymaterial?>"> />
                          <!-- <option value="" selected>Select Body Material</option> -->
                          <?php foreach ($body_material as $body) { ?>
                          <option value="<?=$body['id'];?>" <?php if($products_data->bodymaterial == $body['id']){ echo "selected"; } ?>><?=$body['name'];?></option>
                          <? } ?>
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <td> <strong>Video Channel</strong> <span style="color:red;">*</span></strong> </td>
                      <td> <select class="form-control" id="videochannel" name="videochannel" value="<?=$products_data->videochannel?>"> />
                          <!-- <option value="" selected>Select Video Channel</option> -->
                          <?php foreach ($video_channel as $video) { ?>
                          <option value="<?=$video['id'];?>" <?php if($products_data->videochannel == $video['id']){ echo "selected"; } ?>><?=$video['name'];?></option>
                          <? } ?>
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <td> <strong>POE Ports</strong> <span style="color:red;">*</span></strong> </td>
                      <td> <select class="form-control" id="povport" name="poeports" value="<?=$products_data->poeports?>"> />
                          <!-- <option value="" selected>Select POE Ports</option> -->
                          <?php foreach ($pov_ports as $port1) { ?>
                          <option value="<?=$port1['id'];?>" <?php if($products_data->poeports == $port1['id']){ echo "selected"; } ?>><?=$port1['name'];?></option>
                          <? } ?>
                      </td>
                    </tr>
                    <tr>
                      <td> <strong>POE Type</strong> <span style="color:red;">*</span></strong> </td>
                      <td> <select class="form-control" id="povtype" name="poetype" value="<?=$products_data->poetype?>"> />
                          <!-- <option value="" selected>Select POE Type</option> -->
                          <?php foreach ($pov_type as $port) { ?>
                          <option value="<?=$port['id'];?>" <?php if($products_data->poetype == $port['id']){ echo "selected"; } ?>><?=$port['name'];?></option>
                          <? } ?>
                      </td>
                      </select>
                      </td>
                    </tr>
                    <tr>
                      <td> <strong>SATA Ports</strong> <span style="color:red;">*</span></strong> </td>
                      <td> <select class="form-control" id="sataports" name="sataports" value="<?=$products_data->sataports?>"> />
                          <!-- <option value="" selected>Select SATA Ports</option> -->
                          <?php foreach ($sata_ports as $sata) { ?>
                          <option value="<?=$sata['id'];?>" <?php if($products_data->sataports == $sata['id']){ echo "selected"; } ?>><?=$sata['name'];?></option>
                          <? } ?>
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <td> <strong>Length</strong> <span style="color:red;">*</span></strong> </td>
                      <td> <select class="form-control" id="length" name="length" value="<?=$products_data->length?>"> />
                          <!-- <option value="" selected>Select Length</option> -->
                          <?php foreach ($length_data as $length) { ?>
                          <option value="<?=$length['id'];?>" <?php if($products_data->length == $length['id']){ echo "selected"; } ?>><?=$length['name'];?></option>
                          <? } ?>
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <td> <strong>Screen Size</strong> <span style="color:red;">*</span></strong> </td>
                      <td> <select class="form-control" id="screensize" name="screensize" value="<?=$products_data->screensize?>"> />
                          <!-- <option value="" selected>Select Screen Size</option> -->
                          <?php foreach ($screen_size as $screen) { ?>
                          <option value="<?=$screen['id'];?>" <?php if($products_data->screensize == $screen['id']){ echo "selected"; } ?>><?=$screen['name'];?></option>
                          <? } ?>
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <td> <strong>LED Type</strong> <span style="color:red;">*</span></strong> </td>
                      <td> <select class="form-control" id="ledtype" name="ledtype" value="<?=$products_data->ledtype?>"> />
                          <!-- <option value="" selected>Select LED Type</option> -->
                          <?php foreach ($led_type as $led) { ?>
                          <option value="<?=$led['id'];?>" <?php if($products_data->ledtype == $led['id']){ echo "selected"; } ?>><?=$led['name'];?></option>
                          <? } ?>
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <td> <strong>Size</strong> <span style="color:red;">*</span></strong> </td>
                      <td> <select class="form-control" id="size" name="size_data" value="<?=$products_data->size?>"> />
                          <!-- <option value="" selected>Select Size</option> -->
                          <?php foreach ($size_data as $size) { ?>
                          <option value="<?=$size['id'];?>" <?php if($products_data->size == $size['id']){ echo "selected"; } ?>><?=$size['name'];?></option>
                          <? } ?>
                      </td>
                    </tr>
                    <tr>
                      <td> <strong>Night Vision</strong> <span style="color:red;"></span> </td>
                      <td> <select class="form-control" id="nightvision" name="nv_data"> />
                          <!-- <option value="" selected>Select Night Vision</option> -->
                          <?php foreach ($night_vision as $night) { ?>
                          <option value="<?=$night['id'];?>" <?if($night['id']==$products_data->night_vision){echo "selected";}?>><?=$night['name'];?></option>
                          <? } ?>
                      </td>
                    </tr>
                    <tr>
                      <td> <strong>Audio type</strong> <span style="color:red;"></span> </td>
                      <td> <select class="form-control" id="audiotype" name="audiotype"> />
                          <!-- <option value="" selected>Select Audio Type</option> -->
                          <?php foreach ($audio_type as $audio) { ?>
                          <option value="<?=$audio['id'];?>" <?if($audio['id']==$products_data->audio_type){echo "selected";}?>><?=$audio['name'];?></option>
                          <? } ?>
                      </td>
                    </tr>
                    <tr>
                      <td> <strong>Max Limit</strong> <span style="color:red;">*</span></strong> </td>
                      <td>
                        <input type="text" name="max" required class="form-control" value="<?=$products_data->max?>" required>
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
      //alert("hello" + price);
      var gst = $('#gst').val();
      //alert('hello '+ price +"gst"+gst);

      $('#gstprice').val(price * gst / 100);

      // var sprice=$('#gstprice').val();
      var v1 = parseInt($('#sellingprice').val());
      var v2 = parseInt($('#gstprice').val());
      var v3 = v1 + v2;
      $('#sp').val(v3);


    });
    $('#sellingprice').keyup(function() {

      var price = $('#sellingprice').val();
      //alert("hello" + price);
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
