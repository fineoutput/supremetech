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
              <form action=" <?php echo base_url()  ?>dcadmin/products/add_products_data/<? echo base64_encode(2);?>/<?=$id;?>" method="POST" id="slide_frm" enctype="multipart/form-data">
                <div class="table-responsive">
                  <table class="table table-hover">
                    <tr>
                      <td> <strong>Product Name</strong> <span style="color:red;">*</span></strong> </td>
                      <td> <input type="text" name="productname" class="form-control" placeholder="" required value="<?=$products_data->productname?>" /> </td>
                    </tr>


                    <input type="hidden" name="category_id" value="<?=base64_decode($id1)?>">
                    <!-- <tr>
<td> <strong>Category Name</strong>  <span style="color:red;">*</span></strong> </td>
<td>
          <select class="form-control" id="cid" name="category_id">
          <option value="">Please select category</option>

          <?

          foreach($category_data->result() as $value) {?>
          <option value="<?=$value->id;?>"<?php if($products_data->category_id == $value->id){ echo "selected"; } ?>><?=$value->category;?></option>
          <? }?>
</select>
</td>
</tr> -->

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
                      <td> <strong>Image</strong> <span style="color:red;">*</span></strong> </td>
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
                      <td> <strong>Image 1</strong> <span style="color:red;">*</span></strong> </td>
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
                      <td> <strong>Video 1</strong> <span style="color:red;">*</span></strong> </td>
                      <td> <input type="file" name="video1" class="form-control" placeholder="" value="<?=$products_data->video1?>" /> </td>
                      <td>
                        <?php if($products_data->video1!=""){  ?>
                        <video id="slide_img_path" height=50 width=100 src="<?php echo base_url() ?><?php echo $products_data->video1; ?>" autoplay poster="">
                          <?php }else {  ?>
                          Sorry No image Found
                          <?php } ?>
                      </td>
                    </tr>
                    <tr>
                      <td> <strong>Video 2</strong> <span style="color:red;">*</span></strong> </td>
                      <td> <input type="file" name="video2" class="form-control" placeholder="" value="<?=$products_data->video2?>" /> </td>

                      <td>
                        <?php if($products_data->video2!=""){  ?>
                        <!-- <img id="slide_img_path" height=50 width=100  src="<?php echo base_url() ?><?php echo $products_data->video2; ?>"> -->
                        <video id="slide_img_path" height=50 width=100 src="<?php echo base_url() ?><?php echo $products_data->video2; ?>" autoplay poster="">
                          <?php }else {  ?>
                          Sorry No image Found
                          <?php } ?>
                      </td>
                    </tr>
                    <tr>
                      <td> <strong>Price</strong> <span style="color:red;">*</span></strong> </td>
                      <td> <input type="number" name="mrp" required class="form-control" placeholder="" value="<?=$products_data->mrp?>" /> </td>
                    </tr>
                   <tr>
<td> <strong>Selling Price</strong>  <span style="color:red;">*</span></strong> </td>
<td> <input type="number" name="sellingprice" id="sellingprice"  class="form-control" placeholder=""  value="<?=$products_data->sellingprice?>" />  </td>
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
                      <td> <strong>Weight</strong> <span style="color:red;">*</span></strong> </td>
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
                      <td> <select class="form-control" id="polpularpid" name="brands" value="<?=$products_data->brand?>"> />
                          <!-- <option value="" selected>Select Brand</option> -->
                          <?php foreach ($brand_data->result() as $brands) { ?>
                          <option value="<?=$brands->id;?>" <?php if($products_data->brand == $brands->id){ echo "selected"; } ?>><?=$brands->name;?></option>
                          <? } ?>
                        </select>
                      </td>
                    </tr>

                    <tr>
                      <td> <strong>Resolution</strong> <span style="color:red;">*</span></strong> </td>
                      <td> <select class="form-control" id="polpularpid" name="resolution" value="<?=$products_data->resolution?>"> />
                          <!-- <option value="" selected>Select Resolution</option> -->
                          <?php foreach ($resolution_data->result() as $resolution) { ?>
                          <option value="<?=$resolution->id;?>" <?php if($products_data->resolution == $resolution->id){ echo "selected"; } ?>><?=$resolution->filtername;?></option>
                          <? } ?>
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <td> <strong>Lens</strong> <span style="color:red;">*</span></strong> </td>
                      <td> <select class="form-control" id="polpularpid" name="lens" value="<?=$products_data->lens?>"> />
                          <option value="" selected>Select Lens</option>
                          <?php foreach ($lens_data->result() as $lens) { ?>
                          <option value="<?=$lens->id;?>" <?php if($products_data->lens == $lens->id){ echo "selected"; } ?>><?=$lens->filtername;?></option>
                          <? } ?>
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <td> <strong>IR Distance</strong> <span style="color:red;">*</span></strong> </td>
                      <td> <select class="form-control" id="polpularpid" name="irdistance" value="<?=$products_data->irdistance?>"> />
                          <option value="" selected>Select IR Distance</option>
                          <?php foreach ($distance_data->result() as $distance) { ?>
                          <option value="<?=$distance->id;?>" <?php if($products_data->irdistance == $distance->id){ echo "selected"; } ?>><?=$distance->filtername;?></option>
                          <? } ?>
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <td> <strong>Camera type</strong> <span style="color:red;">*</span></strong> </td>
                      <td> <select class="form-control" id="polpularpid" name="cameratype" value="<?=$products_data->cameratype?>"> />
                          <option value="" selected>Select Camera type</option>
                          <?php foreach ($camera_data->result() as $camera) { ?>
                          <option value="<?=$camera->id;?>" <?php if($products_data->cameratype == $camera->id){ echo "selected"; } ?>><?=$camera->filtername;?></option>
                          <? } ?>
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <td> <strong>Body Material</strong> <span style="color:red;">*</span></strong> </td>
                      <td> <select class="form-control" id="polpularpid" name="bodymaterial" value="<?=$products_data->bodymaterial?>"> />
                          <option value="" selected>Select Body Material</option>
                          <?php foreach ($body_data->result() as $body) { ?>
                          <option value="<?=$body->id;?>" <?php if($products_data->bodymaterial == $body->id){ echo "selected"; } ?>><?=$body->filter_name;?></option>
                          <? } ?>
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <td> <strong>Video Channel</strong> <span style="color:red;">*</span></strong> </td>
                      <td> <select class="form-control" id="polpularpid" name="videochannel" value="<?=$products_data->videochannel?>"> />
                          <option value="" selected>Select Video Channel</option>
                          <?php foreach ($video_data->result() as $video) { ?>
                          <option value="<?=$video->id;?>" <?php if($products_data->videochannel == $video->id){ echo "selected"; } ?>><?=$video->filter_name;?></option>
                          <? } ?>
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <td> <strong>POE Ports</strong> <span style="color:red;">*</span></strong> </td>
                      <td> <select class="form-control" id="polpularpid" name="poeports" value="<?=$products_data->poeports?>"> />
                          <option value="" selected>Select POE Ports</option>
                          <?php foreach ($port_data->result() as $port1) { ?>
                          <option value="<?=$port1->id;?>" <?php if($products_data->poeports == $port1->id){ echo "selected"; } ?>><?=$port1->filter_name;?></option>
                          <? } ?>
                      </td>
                    </tr>
                    <tr>
                      <td> <strong>POE Type</strong> <span style="color:red;">*</span></strong> </td>
                      <td> <select class="form-control" id="polpularpid" name="poetype" value="<?=$products_data->poetype?>"> />
                          <option value="" selected>Select POE Type</option>
                          <?php foreach ($port_data->result() as $port) { ?>
                          <option value="<?=$port->id;?>" <?php if($products_data->poetype == $port->id){ echo "selected"; } ?>><?=$port->filter_name;?></option>
                          <? } ?>
                      </td>
                      </select>
                      </td>
                    </tr>
                    <tr>
                      <td> <strong>SATA Ports</strong> <span style="color:red;">*</span></strong> </td>
                      <td> <select class="form-control" id="polpularpid" name="sataports" value="<?=$products_data->sataports?>"> />
                          <option value="" selected>Select SATA Ports</option>
                          <?php foreach ($sata_data->result() as $sata) { ?>
                          <option value="<?=$sata->id;?>" <?php if($products_data->sataports == $sata->id){ echo "selected"; } ?>><?=$sata->filter_name;?></option>
                          <? } ?>
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <td> <strong>Length</strong> <span style="color:red;">*</span></strong> </td>
                      <td> <select class="form-control" id="polpularpid" name="length" value="<?=$products_data->length?>"> />
                          <option value="" selected>Select Length</option>
                          <?php foreach ($length_data->result() as $length) { ?>
                          <option value="<?=$length->id;?>" <?php if($products_data->length == $length->id){ echo "selected"; } ?>><?=$length->filter_name;?></option>
                          <? } ?>
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <td> <strong>Screen Size</strong> <span style="color:red;">*</span></strong> </td>
                      <td> <select class="form-control" id="polpularpid" name="screensize" value="<?=$products_data->screensize?>"> />
                          <option value="" selected>Select Screen Size</option>
                          <?php foreach ($screen_data->result() as $screen) { ?>
                          <option value="<?=$screen->id;?>" <?php if($products_data->screensize == $screen->id){ echo "selected"; } ?>><?=$screen->filter_name;?></option>
                          <? } ?>
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <td> <strong>LED Type</strong> <span style="color:red;">*</span></strong> </td>
                      <td> <select class="form-control" id="polpularpid" name="ledtype" value="<?=$products_data->ledtype?>"> />
                          <option value="" selected>Select LED Type</option>
                          <?php foreach ($led_data->result() as $led) { ?>
                          <option value="<?=$led->id;?>" <?php if($products_data->ledtype == $led->id){ echo "selected"; } ?>><?=$led->filter_name;?></option>
                          <? } ?>
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <td> <strong>Size</strong> <span style="color:red;">*</span></strong> </td>
                      <td> <select class="form-control" id="polpularpid" name="size_data" value="<?=$products_data->size?>"> />
                          <option value="" selected>Select Size</option>
                          <?php foreach ($size_data->result() as $size) { ?>
                          <option value="<?=$size->id;?>" <?php if($products_data->size == $size->id){ echo "selected"; } ?>><?=$size->filter_name;?></option>
                          <? } ?>
                      </td>
                    </tr>
                    <tr>
                      <td> <strong>Night Vision</strong> <span style="color:red;"></span> </td>
                      <td> <select class="form-control" id="nightvision" name="nv_data"> />
                          <option value="" selected>Select Night Vision</option>
                          <?php foreach ($nv_data->result() as $night) { ?>
                          <option value="<?=$night->id;?>" <?if($night->id==$products_data->night_vision){echo "selected";}?>><?=$night->filtername;?></option>
                          <? } ?>
                      </td>
                    </tr>
                    <tr>
                      <td> <strong>Audio type</strong> <span style="color:red;"></span> </td>
                      <td> <select class="form-control" id="audiotype" name="audiotype"> />
                          <option value="" selected>Select Audio Type</option>
                          <?php foreach ($audio_type_data->result() as $audio) { ?>
                          <option value="<?=$audio->id;?>" <?if($audio->id==$products_data->audio_type){echo "selected";}?>><?=$audio->filtername;?></option>
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
          url: base_url + "dcadmin/products/getMinorcategory?isl=" + vf,
          // url:base_url+"dcadmin/products/getMinorcategory?isl="+vf,
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
