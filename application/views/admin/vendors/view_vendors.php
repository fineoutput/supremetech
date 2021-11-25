  <div class="content-wrapper">
        <section class="content-header">
           <h1>
           Vendors
          </h1>
          <ol class="breadcrumb">
           <li><a href="<?php echo base_url() ?>dcadmin/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?php echo base_url() ?>dcadmin/vendors/view_vendors"><i class="fa fa-dashboard"></i> All Vendors </a></li>
            <li class="active">View Vendors</li>
          </ol>
        </section>
          <section class="content">
          <div class="row">
             <div class="col-lg-12">
                 <!-- <a class="btn btn-info cticket" href="dcadmin/vendors/add_vendors" role="button" style="margin-bottom:12px;"> Add Vendors </a> -->
                              <div class="panel panel-default">
                                  <div class="panel-heading">
                                      <h3 class="panel-title"><i class="fa fa-money fa-fw"></i>View Vendors</h3>
                                  </div>
                                     <div class="panel panel-default">

                                            <? if(!empty($this->session->flashdata('smessage'))){ ?>
                                                  <div class="alert alert-success alert-dismissible">
                                              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                              <h4><i class="icon fa fa-check"></i> Alert!</h4>
                                            <? echo $this->session->flashdata('smessage'); ?>
                                            </div>
                                              <? }
                                               if(!empty($this->session->flashdata('emessage'))){ ?>
                                               <div class="alert alert-danger alert-dismissible">
                                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                            <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                                          <? echo $this->session->flashdata('emessage'); ?>
                                          </div>
                                            <? } ?>


                                  <div class="panel-body">
                                      <div class="box-body table-responsive no-padding">
                                      <table class="table table-bordered table-hover table-striped" id="userTable">
                                          <thead>
                                              <tr>
                                                  <th>#</th>
                                                  <th>Full Name</th>
                                                  <th>Company Name</th>

                                                  <th>Date Of Birth</th>
                                                  <th>Address</th>
                                                  <th>city</th>
                                                  <th>State</th>
                                                  <th>Contact Number</th>
                                                  <th>GST IN</th>
                                                  <th>images</th>
                                                  <th>Images2</th>

                                                  <th>Registration date</th>
                                                  <th>Status</th>
                                                  <th>Request Status</th>
                                                  <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                  <?php $i=1; foreach($vendors_data->result() as $data) { ?>
                        <tr>
                            <td><?php echo $i ?> </td>
                            <td><?php echo $data->name ?></td>
                            <td><?php echo $data->company_name ?></td>
                            <td><?php echo $data->dob ?></td>
                            <td><?php echo $data->address ?></td>
                            <td><?php echo $data->district ?></td>
                            <td><?php echo $data->state ?></td>
                            <td><?php echo $data->phone ?></td>
                            <td><?php echo $data->gstin ?></td>
                            <td>
                            <?php if($data->image1!=""){ ?>
                            <img id="slide_img_path" height=50 width=100 src="<?php echo base_url().$data->image1
                            ?>" >
                            <?php }else { ?>
                            Sorry No File Found
                            <?php } ?>
                            </td>
                            <td>
                            <?php if($data->image2!=""){ ?>
                            <img id="slide_img_path" height=50 width=100 src="<?php echo base_url().$data->image2
                            ?>" >
                            <?php }else { ?>
                            Sorry No File Found
                            <?php } ?>
                            </td>
                            <td><?php echo $data->date ?></td>



                              <td><?php if($data->is_active==1){ ?>
        <p class="label bg-green" >Active</p>

    <?php } else { ?>
        <p class="label bg-yellow" >Inactive</p>


<?php		}   ?>
      </td>
      <td>
        <?php if($data->status==1){ ?>
        <p class="label bg-green">Approved</p>
      <?php } elseif($data->status==2){ ?>
        <p class="label bg-yellow">Pending</p>
      <?php	} elseif($data->status==3){ ?>
            <p class="label bg-red">Rejected</p>
      <?php	}   ?>
      </td>
                    <td>
<div class="btn-group" id="btns<?php echo $i ?>">
<div class="btn-group">
<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false"> Action <span class="caret"></span></button>
<ul class="dropdown-menu" role="menu">

<?php if($data->is_active==1){ ?>
<li><a href="<?php echo base_url() ?>dcadmin/vendors/updatevendorsStatus/<?php echo base64_encode($data->id) ?>/inactive">Inactive</a></li>
<?php } else { ?>
<li><a href="<?php echo base_url() ?>dcadmin/vendors/updatevendorsStatus/<?php echo base64_encode($data->id) ?>/active">Active</a></li>
<?php		}   ?>
<?php if($data->status==1){ ?>
<li><a href="<?php echo base_url() ?>dcadmin/vendors/updateVendorRequestStatus/<?php echo base64_encode($data->id) ?>/pending">Pending</a></li>
<li><a href="<?php echo base_url() ?>dcadmin/vendors/updateVendorRequestStatus/<?php echo base64_encode($data->id) ?>/reject">Reject</a></li>
<?php } elseif($data->status==2){ ?>
<li><a href="<?php echo base_url() ?>dcadmin/vendors/updateVendorRequestStatus/<?php echo base64_encode($data->id) ?>/approved">Approved</a></li>
<li><a href="<?php echo base_url() ?>dcadmin/vendors/updateVendorRequestStatus/<?php echo base64_encode($data->id) ?>/reject">Reject</a></li>
<?php	}elseif($data->status==3){ ?>
<li><a href="<?php echo base_url() ?>dcadmin/vendors/updateVendorRequestStatus/<?php echo base64_encode($data->id) ?>/pending">Pending</a></li>
<li><a href="<?php echo base_url() ?>dcadmin/vendors/updateVendorRequestStatus/<?php echo base64_encode($data->id) ?>/approved">Approved</a></li>
<?php		}   ?>
<!-- <li><a href="dcadmin/vendors/update_vendors/">Edit</a></li>
<li><a href="javascript:;" class="dCnf" mydata="">Delete</a></li> -->
</ul>
</div>
</div>

<div style="display:none" id="cnfbox<?php echo $i ?>">
<p> Are you sure delete this </p>
<a href="<?php echo base_url() ?>dcadmin/vendors/delete_vendors/<?php echo base64_encode($data->id); ?>" class="btn btn-danger" >Yes</a>
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
      <script src="<?php echo base_url() ?>assets/admin/plugins/datatables/jquery.dataTables.js"></script>
      <script src="<?php echo base_url() ?>assets/admin/plugins/datatables/dataTables.bootstrap.js"></script>
      <script type="text/javascript">

       $(document).ready(function(){
      $('#userTable').DataTable({
               responsive: true,
               // bSort: true
       });

      $(document.body).on('click', '.dCnf', function() {
       var i=$(this).attr("mydata");
       console.log(i);

       $("#btns"+i).hide();
       $("#cnfbox"+i).show();

      });

       $(document.body).on('click', '.cans', function() {
       var i=$(this).attr("mydatas");
       console.log(i);

       $("#btns"+i).show();
       $("#cnfbox"+i).hide();
      })

       });

       </script>
      <!-- <script type="text/javascript" src="<?php echo base_url() ?>assets/slider/ajaxupload.3.5.js"></script>
      <script type="text/javascript" src="<?php echo base_url() ?>assets/slider/rs.js"></script>	  -->
