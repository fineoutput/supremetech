<div class="content-wrapper">
        <section class="content-header">
           <h1>
          Add New Blog
          </h1>
          <ol class="breadcrumb">
           <li><a href="<?php echo base_url() ?>admin/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?php echo base_url() ?>admin/college"><i class="fa fa-dashboard"></i> All Blog </a></li>
    
          </ol>
        </section>
		<section class="content">
		<div class="row">
       <div class="col-lg-12">
				   <a class="btn btn-info cticket" href="<?php echo base_url() ?>admin/home/blog" role="button" style="margin-bottom:12px;"> Back</a>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title"><i class="fa fa-money fa-fw"></i> Add New Blog</h3>
                            </div>
                            <div class="panel-body">
                                <div class="col-lg-10">
                                   <form action="<?php echo base_url() ?>admin/home/add_blog_data" method="POST" id="slide_frm" >
                                <div class="table-responsive">
                                    <table class="table table-hover">
	                                        
											<tr>
                                                <td> <strong>Blog Title</strong>  <span style="color:red;">*</span></strong> </td>
                                                <td>
													<input type="text" name="title"  class="form-control" placeholder="Blog Title" required value="" />
	                                            </td>
    										</tr>
												<tr>
                                                <td> <strong>Highlight Short Description</strong>  <span style="color:red;">*</span></strong> </td>
                                                <td>
												
										<textarea class="form-control" rows="5" name="highlight" placeholder="Maximum One Line" required></textarea>
	                                            </td>
    										</tr>
											<tr>
                                                <td> <strong>Short Description</strong>  <span style="color:red;">*</span></strong> </td>
                                                <td>
												
										<textarea class="form-control" rows="5" name="short" placeholder="Maximum Two Three Lines" required></textarea>
	                                            </td>
    										</tr>
											<tr>
                                                <td> <strong>Long Description</strong>  <span style="color:red;">*</span></strong> </td>
                                                <td>
														<textarea id="editor1" name="long" rows="10" cols="80" ></textarea>
	                                            </td>
    										</tr>
											<tr>
                                                <td> <strong>Keywords</strong>  <span style="color:red;">*</span></strong> </td>
                                                <td>
														<input type="text" name="keyword"  class="form-control" placeholder="Enter Keywords with comma" required value="" />
	                                            </td>
    										</tr>
												<tr>
                                                <td> <strong>Meta Description</strong>  <span style="color:red;">*</span></strong> </td>
                                                <td>
												
										<textarea class="form-control" rows="5" name="meta" placeholder="Maximum Two Three Lines" required></textarea>
	                                            </td>
    										</tr>
										
											<tr class="st1">
												<td> <strong>Image</strong> </td>
												<td>
													<div id="uploader">

															<p>Your browser doesn't have Flash, Silverlight or HTML5 support.</p>

														</div>
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
	  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
	  
	  <script src="<?php echo base_url() ?>assets/admin/plugins/ckeditor/ckeditor.js"></script>
	  	<script type="text/javascript" src="<?php echo base_url() ?>assets/slider/ajaxupload.3.5.js"></script>	  
				<link href="<? echo base_url() ?>assets/cowadmin/css/jqvmap.css" rel='stylesheet' type='text/css' />

	
							<script src="<?php echo base_url() ?>assets/admin/plugins/ckeditor/ckeditor.js"></script>

<script type="text/javascript" src="<?php echo base_url() ?>assets/admin/plup/js/plupload.full.min.js"></script>	

<script type="text/javascript" src="<?php echo base_url() ?>assets/admin/plup/js/jquery.plupload.queue/jquery.plupload.queue.js"></script>	

<link rel="stylesheet" href="<?php echo base_url() ?>assets/admin/plup/js/jquery.plupload.queue/css/jquery.plupload.queue.css" type="text/css" media="screen" />
<script>

                // Replace the <textarea id="editor1"> with a CKEditor

                // instance, using default configuration.

                CKEDITOR.replace( 'editor1' );

            </script>
	  <script type="text/javascript">

$(document).ready(function(){

	$("#uploader").pluploadQueue({
		
		

		// General settings

		runtimes : 'html5,flash,silverlight,html4',

		url : base_url+'admin/home/image_uploadmutiple',

		chunk_size: '1mb',

		rename : true,

		dragdrop: true,

		

		filters : {

			// Maximum file size

			max_file_size : '10mb',

			// Specify what files to browse for

			mime_types: [

				{title : "Image files", extensions : "jpg,gif,png,bmp,pdf,xls,doc,docx,xlsx"}				

			]

		},



		// Resize images on clientside if we can

		//resize : {width : 800, height : 240, quality : 90},

	

		flash_swf_url : base_url+'assets/admin/pulp/js/Moxie.swf',

		silverlight_xap_url : base_url+'assets/admin/pulp/js/Moxie.xap'		

	});

	

	var uploaderqueue = $('#uploader').pluploadQueue();



        uploaderqueue.bind('FileUploaded',function(up, file, info)

     		{

			if(info.length != 0)

			{

					if(info.response == "error")

					{

					alert("Oops something went wrong. Please try again");

					location.reload();

					}else

					{

					var get_data=$.parseJSON(info.response);

					console.log(get_data);

					

					var input = document.createElement("input");



					input.setAttribute("type", "hidden");



					input.setAttribute("name", "image[]");

	

					//console.log(get_data.new_name);

					input.setAttribute("value",get_data.new_name);

					$("#slide_frm").append(input);

		

					}		

			}else

				{

				alert("Oops something went wrong. Please try again");

				}

			});	
			
			});
			</script>
<style>
label{
	margin:5px;
}
</style>
<!-- <script type="text/javascript" src="<?php echo base_url() ?>assets/slider/ajaxupload.3.5.js"></script>	  
<script type="text/javascript" src="<?php echo base_url() ?>assets/slider/rs.js"></script>	  -->
	  