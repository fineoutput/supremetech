<div class="content-wrapper">
        <section class="content-header">
           <h1>
        Blog
          </h1>
          <ol class="breadcrumb">
           <li><a href="<?php echo base_url() ?>admin/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?php echo base_url() ?>admin/college"><i class="fa fa-dashboard"></i> All Blogs </a></li>
            <li class="active">View Detail College</li>
          </ol>
        </section>
		<section class="content">
		<div class="row">
       <div class="col-lg-12">
				   <a class="btn btn-info cticket" href="<?php echo base_url() ?>admin/home/add_blog" role="button" style="margin-bottom:12px;"> Add Blog</a>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title"><i class="fa fa-money fa-fw"></i>Blog</h3>
                            </div>
                               <div class="panel panel-default">
                           
                            <div class="panel-body">
                                <div class="">
                                    <table class="table table-bordered table-hover table-striped" id="userTable">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Blog Title </th>
                                                <th>Short Des. </th>
                                                <th>Long Des. </th>
												<th>Images</th>
												<th>Keywords</th>
												<th>Date</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
										<?php $i=1; foreach($blog_data->result() as $data) { ?>
                                            <tr>
                                                <td><?php echo $i ?> </td>
                                                <td><?php echo $data->title ?></td>
                                                <td><?php echo $data->short_des ?></td>
                                                <td><a href="<? echo base_url() ?>admin/home/blog_des/<? echo base64_encode($data->blog_id); ?>" target="_blank" class="btn btn-info" role="button">View Description</a></td>
												<td><a href="<? echo base_url() ?>admin/home/blog_image/<? echo base64_encode($data->blog_id); ?>" target="_blank" class="btn btn-info" role="button">View Images</a></td>
												<td><?php echo $data->keywords ?></td>
												<td><?php echo $data->date ?></td>
                                                <td><?php if($data->is_active==1){ ?>
													<p class="label pull-right bg-green" >Active</p>
													
											<?php } else { ?>
													<p class="label pull-right bg-yellow" >Inactive</p>
												
												
									<?php		}   ?>
												</td>
                                                <td>
												<div class="btn-group" id="btns<?php echo $i ?>">
													<div class="btn-group">
														<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false"> Action <span class="caret"></span></button>
													  <ul class="dropdown-menu" role="menu">
														
														<?php if($data->is_active==1){ ?>
														<li><a href="<?php echo base_url() ?>admin/course/updateStatus/<?php echo base64_encode($data->blog_id) ?>/inactive">Inactive</a></li>
														<?php } else { ?>
														<li><a href="<?php echo base_url() ?>admin/course/updateStatus/<?php echo base64_encode($data->blog_id) ?>/active">Active</a></li>
														<?php		}   ?>
														<li><a href="<?php echo base_url() ?>admin/course/updateCourse/<?php echo base64_encode($data->blog_id) ?>">Edit Blog</a></li>
														<li><a href="javascript:;" class="dCnf" mydata="<?php echo $i ?>">Delete Blog</a></li>
													  </ul>
													</div>
												</div>
													
													  <div style="display:none" id="cnfbox<?php echo $i ?>">
															<p> Are you sure delete this </p>
															<a href="<?php echo base_url() ?>admin/course/deleteCourse/<?php echo base64_encode($data->blog_id); ?>" class="btn btn-danger" >Yes</a>
															<a href="javasript:;" class="cans btn btn-default" mydatas="<?php echo $i ?>" >No</a>
													  </div>
												</td>
                                            </tr>
										<?php $i++; } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        </div>

                    </div>
                    </div>
        </section>
      </div>
	  
	
<style>
label{
	margin:5px;
}
</style>
<!-- <script type="text/javascript" src="<?php echo base_url() ?>assets/slider/ajaxupload.3.5.js"></script>	  
<script type="text/javascript" src="<?php echo base_url() ?>assets/slider/rs.js"></script>	  -->
	  