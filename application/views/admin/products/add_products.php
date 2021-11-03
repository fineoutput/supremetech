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
                                          <form action=" <?php echo base_url()  ?>dcadmin/products/add_products_data/<? echo base64_encode(1);  ?>" method="POST" id="slide_frm" enctype="multipart/form-data">
                                       <div class="table-responsive">
                                           <table class="table table-hover">


  <tr>
<td> <strong>Product Name</strong>  <span style="color:red;">*</span></strong> </td>
<td> <input type="text" name="productname"  class="form-control" placeholder="" required value="" />  </td>
</tr>

<input type="hidden" name="category_id" value="<?=base64_decode($id)?>">

  <!-- <tr>
<td> <strong>Category </strong>  <span style="color:red;">*</span></strong> </td>
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
<td> <strong>Subcategory </strong>  <span style="color:red;">*</span></strong> </td>
<td>
  <select class="form-control" id="sid" name="subcategory_id">
      <option value="">Please select subcategory</option>
      <?

       foreach($subcategory_data->result() as $value) {?>
         <option value="<?=$value->id;?>"><?=$value->subcategory;?></option>
       <? }?>
  </select>


  </td>
</tr>
  <tr>
<td> <strong>Minor Category</strong>  <span style="color:red;">*</span></strong> </td>
<td>
    <select class="form-control" id="mid" name="minorcategory_id">

    </select>
  </td>
</tr>

  <tr>
<td> <strong>image</strong>  <span style="color:red;"></span></strong> </td>
<td> <input type="file" name="image"  class="form-control" placeholder=""  value="" />  </td>
</tr>
  <tr>
<td> <strong>image1</strong>  <span style="color:red;"></span></strong> </td>
<td> <input type="file" name="image1"  class="form-control" placeholder=""  value="" />  </td>
</tr>
  <tr>
<td> <strong>Video1</strong>  <span style="color:red;"></span></strong> </td>
<td> <input type="file" name="video1"  class="form-control" placeholder=""  value="" />  </td>
</tr>
  <tr>
<td> <strong>Video2</strong>  <span style="color:red;"></span></strong> </td>
<td> <input type="file" name="video2"  class="form-control" placeholder=""  value="" />  </td>
</tr>
  <tr>
<td> <strong>MRP</strong>  <span style="color:red;"></span></strong> </td>
<td> <input type="text" name="mrp"  class="form-control" placeholder=""  value="" />  </td>
</tr>
  <tr>
  <tr>
<td> <strong>Selling Price</strong>  <span style="color:red;">*</span></strong> </td>
<td> <input type="text" name="sellingprice"  class="form-control" placeholder="" required value="" />  </td>
</tr>
  <tr>
<td> <strong>Product Description</strong>  <span style="color:red;">*</span></strong> </td>
<td> <textarea name="productdescription" id="editor1" rows="3" cols="80"></textarea>  </td>
</tr>
  <tr>
<td> <strong>Model No.</strong>  <span style="color:red;">*</span></strong> </td>
<td> <input type="text" name="modelno"  class="form-control" placeholder="" required value="" />  </td>
</tr>
  <tr>
<td> <strong>Inventory</strong>  <span style="color:red;">*</span></strong> </td>
<td> <input type="text" name="Inventory"  class="form-control" placeholder="" required value="" />  </td>
</tr>
  <tr>
<td> <strong>weight</strong>  <span style="color:red;">*</span></strong> </td>
<td> <input type="text" name="weight"  class="form-control" placeholder="" required value="" />  </td>
</tr>
  <tr>
<td> <strong>Feature Product</strong>  <span style="color:red;">*</span></strong> </td>
<td> <select class="form-control" id="featurepid" name="feature_product"> />
     <option value="yes">Yes</option>
     <option value="no">No</option>
     </select>
 </td>
</tr>
  <tr>
<td> <strong>Most selling Product</strong>  <span style="color:red;">*</span></strong> </td>
<td> <select class="form-control" id="polpularpid" name="popular_product"> />
     <option value="yes">Yes</option>
     <option value="no">No</option>
     </select>
 </td>
</tr>




  <tr>
<td> <strong>Brand</strong>  <span style="color:red;"></span></strong> </td>
<td> <select class="form-control" id="polpularpid" name="brands"> />
  <option value="" selected>Select Brand</option>
  <?php foreach ($brand_data->result() as $brands) { ?>
     <option value="<?=$brands->id;?>"><?=$brands->name;?></option>
   <? } ?>
     </select>
 </td>
</tr>
  <tr>
<td> <strong>Resolution</strong>  <span style="color:red;"></span></strong> </td>
<td> <select class="form-control" id="polpularpid" name="resolution"> />
  <option value="" selected>Select Resolution</option>
  <?php foreach ($resolution_data->result() as $resolution) { ?>
     <option value="<?=$resolution->id;?>"><?=$resolution->filtername;?></option>
   <? } ?>
     </select>
 </td>
</tr>
  <tr>
<td> <strong>Lens</strong>  <span style="color:red;"></span></strong> </td>
<td> <select class="form-control" id="polpularpid" name="lens"> />
  <option value="" selected>Select Lens</option>
  <?php foreach ($lens_data->result() as $lens) { ?>
     <option value="<?=$lens->id;?>"><?=$lens->filtername;?></option>
   <? } ?>
     </select>
 </td>
</tr>
  <tr>
<td> <strong>IR Distance</strong>  <span style="color:red;"></span></strong> </td>
<td> <select class="form-control" id="polpularpid" name="irdistance"> />
  <option value="" selected>Select IR Distance</option>
  <?php foreach ($distance_data->result() as $distance) { ?>
     <option value="<?=$distance->id;?>"><?=$distance->filtername;?></option>
   <? } ?>
     </select>
 </td>
</tr>
  <tr>
<td> <strong>Camera type</strong>  <span style="color:red;"></span></strong> </td>
<td> <select class="form-control" id="polpularpid" name="cameratype"> />
  <option value="" selected>Select Camera type</option>
  <?php foreach ($camera_data->result() as $camera) { ?>
     <option value="<?=$camera->id;?>"><?=$camera->filtername;?></option>
   <? } ?>
     </select>
 </td>
</tr>
  <tr>
<td> <strong>Body Material</strong>  <span style="color:red;"></span></strong> </td>
<td> <select class="form-control" id="polpularpid" name="bodymaterial"> />
  <option value="" selected>Select Body Material</option>
  <?php foreach ($body_data->result() as $body) { ?>
     <option value="<?=$body->id;?>"><?=$body->filter_name;?></option>
   <? } ?>
     </select>
 </td>
</tr>
  <tr>
<td> <strong>Video Channel</strong>  <span style="color:red;"></span></strong> </td>
<td> <select class="form-control" id="polpularpid" name="videochannel"> />
  <option value="" selected>Select Video Channel</option>
  <?php foreach ($video_data->result() as $video) { ?>
     <option value="<?=$video->id;?>"><?=$video->filter_name;?></option>
   <? } ?>
     </select>
 </td>
</tr>
  <tr>
<td> <strong>POE Ports</strong>  <span style="color:red;"></span></strong> </td>
<td> <select class="form-control" id="polpularpid" name="poeports"> />
  <option value="" selected>Select POE Ports</option>
  <?php foreach ($port_data->result() as $port) { ?>
     <option value="<?=$port->id;?>"><?=$port->filter_name;?></option>
   <? } ?>
 </td>
</tr>
  <tr>
<td> <strong>POE Type</strong>  <span style="color:red;"></span></strong> </td>
<td> <select class="form-control" id="polpularpid" name="poetype"> />
  <option value="" selected>Select POE Type</option>
  <?php foreach ($port_data->result() as $port) { ?>
     <option value="<?=$port->id;?>"><?=$port->filter_name;?></option>
   <? } ?>
 </td>
     </select>
 </td>
</tr>
  <tr>
<td> <strong>SATA Ports</strong>  <span style="color:red;"></span></strong> </td>
<td> <select class="form-control" id="polpularpid" name="sataports"> />
  <option value="" selected>Select SATA Ports</option>
  <?php foreach ($sata_data->result() as $sata) { ?>
     <option value="<?=$sata->id;?>"><?=$sata->filter_name;?></option>
   <? } ?>
     </select>
 </td>
</tr>
  <tr>
<td> <strong>Length</strong>  <span style="color:red;"></span></strong> </td>
<td> <select class="form-control" id="polpularpid" name="length"> />
  <option value="" selected>Select Length</option>
  <?php foreach ($length_data->result() as $length) { ?>
     <option value="<?=$length->id;?>"><?=$length->filter_name;?></option>
   <? } ?>
     </select>
 </td>
</tr>
  <tr>
<td> <strong>Screen Size</strong>  <span style="color:red;"></span></strong> </td>
<td> <select class="form-control" id="polpularpid" name="screensize"> />
  <option value="" selected>Select Screen Size</option>
  <?php foreach ($screen_data->result() as $screen) { ?>
     <option value="<?=$screen->id;?>"><?=$screen->filter_name;?></option>
   <? } ?>
     </select>
 </td>
</tr>
  <tr>
<td> <strong>LED Type</strong>  <span style="color:red;"></span></strong> </td>
<td> <select class="form-control" id="polpularpid" name="ledtype"> />
  <option value="" selected>Select LED Type</option>
  <?php foreach ($led_data->result() as $led) { ?>
     <option value="<?=$led->id;?>"><?=$led->filter_name;?></option>
   <? } ?>
     </select>
 </td>
</tr>
  <tr>
<td> <strong>Size</strong>  <span style="color:red;"></span></strong> </td>
<td> <select class="form-control" id="polpularpid" name="size_data"> />
  <option value="" selected>Select Size</option>
  <?php foreach ($size_data->result() as $size) { ?>
     <option value="<?=$size->id;?>"><?=$size->filter_name;?></option>
   <? } ?>
 </td>
</tr>




                                 <tr>
                                   <td colspan="2" >
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
$(document).ready(function(){
  	$("#sid").change(function(){
		var vf=$(this).val();
    // var yr = $("#year_id option:selected").val();
		if(vf==""){
			return false;

		}else{
			$('#mid option').remove();
			  var opton="<option value=''>Please Select </option>";
			$.ajax({
				url:base_url+"dcadmin/products/getMinorcategory?isl="+vf,
				// url:base_url+"dcadmin/products/getMinorcategory?isl="+vf,
				data : '',
				type: "get",
				success : function(html){
						if(html!="NA")
						{
							var s = jQuery.parseJSON(html);
							$.each(s, function(i) {
							opton +='<option value="'+s[i]['min_id']+'">'+s[i]['min_name']+'</option>';
							});
							$('#mid').append(opton);
							//$('#city').append("<option value=''>Please Select State</option>");

                      //var json = $.parseJSON(html);
                      //var ayy = json[0].name;
                      //var ayys = json[0].pincode;
						}
						else
						{
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

CKEDITOR.replace( 'editor1' );
// CKEDITOR.replace( 'editor2' );
// CKEDITOR.replace( 'editor3' );
//
</script>
