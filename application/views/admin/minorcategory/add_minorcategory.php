<div class="content-wrapper">
               <section class="content-header">
                  <h1>
                 Add New minorcategory
                 </h1>

               </section>
           <section class="content">
           <div class="row">
              <div class="col-lg-12">

                               <div class="panel panel-default">
                                   <div class="panel-heading">
                                       <h3 class="panel-title"><i class="fa fa-money fa-fw"></i> Add New minorcategory</h3>
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
                                          <form action=" <?php echo base_url()  ?>dcadmin/minorcategory/add_minorcategory_data/<? echo base64_encode(1);  ?>" method="POST" id="slide_frm" enctype="multipart/form-data">
                                       <div class="table-responsive">
                                           <table class="table table-hover">
  <tr>
<td> <strong>Category</strong>  <span style="color:red;">*</span></strong> </td>
<td>
    <select class="form-control" id="cid" name="category_id">
      <option value="">Please select category</option>

      <?

       foreach($category_data->result() as $value) {?>
         <option value="<?=$value->id;?>"><?=$value->category;?></option>
       <? }?>
    </select>

</td>
</tr>
  <tr>
<td> <strong>Sub-Category</strong>  <span style="color:red;">*</span></strong> </td>
<td>
<select class="form-control" id="sid" name="subcategory_id">
  <option value="">Please select Subcategory</option>

  <?

   foreach($subcategory_data->result() as $value) {?>
     <option value="<?=$value->id;?>"><?=$value->subcategory;?></option>
   <? }?>
</select>
</td>
</tr>
  <tr>
<td> <strong>Minor Category</strong>  <span style="color:red;">*</span></strong> </td>
<td> <input type="" name="minorcategoryname"  class="form-control" placeholder="" required value="" />  </td>
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
     				url:base_url+"dcadmin/minorcategory/getSubcategory?isl="+vf,
     				// url:base_url+"dcadmin/products/getMinorcategory?isl="+vf,
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
    
