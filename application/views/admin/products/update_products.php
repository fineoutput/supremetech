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
<td> <strong>Product Name</strong>  <span style="color:red;">*</span></strong> </td>
<td> <input type="text" name="productname"  class="form-control" placeholder="" required value="<?=$products_data->productname?>" />  </td>
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
<td> <strong>Subcategory Name</strong>  <span style="color:red;">*</span></strong> </td>
<td>
<select class="form-control" id="sid" name="subcategory_id">
  <?

  foreach($subcategory_data->result() as $value) {?>
  <option value="<?=$value->id;?>"<?php if($products_data->subcategory_id == $value->id){ echo "selected"; } ?>><?=$value->subcategory;?></option>
  <? }?>
</select>


</td>
</tr>
<tr>
<td> <strong>Minor Category Name</strong>  <span style="color:red;">*</span></strong> </td>
<td>
<select class="form-control" id="mid" name="minorcategory_id">
  <?

  foreach($minorcategory_data->result() as $value) {?>
  <option value="<?=$value->id;?>"<?php if($products_data->minorcategory_id == $value->id){ echo "selected"; } ?>><?=$value->minorcategoryname;?></option>
  <? }?>
</select>


</td>
</tr>

<tr>
<td> <strong>image</strong>  <span style="color:red;">*</span></strong> </td>
<td> <input type="file" name="image"  class="form-control" placeholder=""  value="<?=$products_data->image?>" />  </td>
<td>
    <?php if($products_data->image!=""){  ?>
<img id="slide_img_path" height=50 width=100  src="<?php echo base_url() ?><?php echo $products_data->image; ?>">
<?php }else {  ?>
Sorry No image Found
<?php } ?>
  </td>
</tr>
<tr>
<td> <strong>Image 1</strong>  <span style="color:red;">*</span></strong> </td>
<td> <input type="file" name="image1"  class="form-control" placeholder=""  value="<?=$products_data->image1?>" />  </td>
<td>
    <?php if($products_data->image1!=""){  ?>
<img id="slide_img_path" height=50 width=100  src="<?php echo base_url() ?><?php echo $products_data->image1; ?>">
<?php }else {  ?>
Sorry No image Found
<?php } ?>
  </td>
</tr>
<tr>
<td> <strong>Video 1</strong>  <span style="color:red;">*</span></strong> </td>
<td> <input type="file" name="video1"  class="form-control" placeholder=""  value="<?=$products_data->image2?>" />  </td>
<td>
    <?php if($products_data->image2!=""){  ?>
      <video id="slide_img_path"  height=50 width=100 src="<?php echo base_url() ?><?php echo $products_data->image2; ?>" autoplay poster="">
<?php }else {  ?>
Sorry No image Found
<?php } ?>
  </td>
</tr>
<tr>
<td> <strong>Video 2</strong>  <span style="color:red;">*</span></strong> </td>
<td> <input type="file" name="video1"  class="form-control" placeholder=""  value="<?=$products_data->image2?>" />  </td>

<td>
    <?php if($products_data->image3!=""){  ?>
<!-- <img id="slide_img_path" height=50 width=100  src="<?php echo base_url() ?><?php echo $products_data->image3; ?>"> -->
<video id="slide_img_path"  height=50 width=100 src="<?php echo base_url() ?><?php echo $products_data->image3; ?>" autoplay poster="">
<?php }else {  ?>
Sorry No image Found
<?php } ?>
  </td>
</tr>
<tr>
<td> <strong>MRP</strong>  <span style="color:red;">*</span></strong> </td>
<td> <input type="text" name="mrp"  class="form-control" placeholder=""  value="<?=$products_data->mrp?>" />  </td>
</tr>
<tr>
<td> <strong>Selling Price</strong>  <span style="color:red;">*</span></strong> </td>
<td> <input type="text" name="sellingprice"  class="form-control" placeholder=""  value="<?=$products_data->sellingprice?>" />  </td>
</tr>
<tr>
<td> <strong>Product Description</strong>  <span style="color:red;">*</span></strong> </td>
<td> <textarea name="productdescription" id="editor1" rows="3" cols="80"><?=$products_data->productdescription?></textarea>  </td>
</tr>
<tr>
<td> <strong>Model No.</strong>  <span style="color:red;">*</span></strong> </td>
<td> <input type="text" name="modelno"  class="form-control" placeholder=""  value="<?=$products_data->modelno?>" />  </td>
</tr>
<tr>
<td> <strong>Inventory</strong>  <span style="color:red;">*</span></strong> </td>
<td> <input type="text" name="Inventory"  class="form-control" placeholder=""  value="<? if(!empty($inventory_data->quantity)){ echo $data1=$inventory_data->quantity;}else { echo $data1="";}?>" />  </td>
</tr>
<tr>
<td> <strong>Weight</strong>  <span style="color:red;">*</span></strong> </td>
<td> <input type="text" name="weight"  class="form-control" placeholder=""  value="<?=$products_data->weight?>" />  </td>
</tr>
<td> <strong>Feature Product</strong>  <span style="color:red;">*</span></strong> </td>
<td> <select class="form-control" id="featurepid" name="feature_product"   value="<?=$products_data->feature_product?>"> />
     <option value="yes">Yes</option>
     <option value="no">No</option>
     </select>
 </td>
</tr>
  <tr>
<td> <strong>Most selling Product</strong>  <span style="color:red;">*</span></strong> </td>
<td> <select class="form-control" id="polpularpid" name="popular_product"  value="<?=$products_data->popular_product?>"> />
     <option value="yes">Yes</option>
     <option value="no">No</option>
     </select>
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
$("#cid").change(function(){
var vf=$(this).val();
// var yr = $("#year_id option:selected").val();
if(vf==""){
return false;

}else{
$('#sid option').remove();
var opton="<option value=''>Please Select </option>";
$.ajax({
url:base_url+"dcadmin/products/getSubcategory?isl="+vf,
data : '',
type: "get",
success : function(html){
if(html!="NA")
{
var s = jQuery.parseJSON(html);
$.each(s, function(i) {
opton +='<option value="'+s[i]['sub_id']+'">'+s[i]['sub_name']+'</option>';
});
$('#sid').append(opton);
//$('#city').append("<option value=''>Please Select State</option>");

//var json = $.parseJSON(html);
//var ayy = json[0].name;
//var ayys = json[0].pincode;
}
else
{
alert('No Subcategory Found');
return false;
}

}

})
}


})
});
</script>
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
