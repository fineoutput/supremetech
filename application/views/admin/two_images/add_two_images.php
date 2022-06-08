<div class="content-wrapper">
  <section class="content-header">
    <h1>
      Add New Two Images
    </h1>
    <ol class="breadcrumb">
    <li><a href="<?php echo base_url() ?>dcadmin/home"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="<?php echo base_url() ?>dcadmin/Two Images/view_two_images"><i class="fa fa-dashboard"></i> View Two Images</a></li>
    </ol>
  </section>
  <section class="content">
    <div class="row">
      <div class="col-lg-12">

        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-money fa-fw"></i> Add New Two Images</h3>
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
              <form action=" <?php echo base_url()  ?>dcadmin/two_images/add_two_images_data/<?php echo base64_encode(1);  ?>" method="POST" id="slide_frm" enctype="multipart/form-data">
                <div class="table-responsive">
                  <table class="table table-hover">
                    <tr>
                      <td> <strong>Image1</strong> <span style="color:red;">*</span></strong> </td>
                      <td> <input type="file" name="image1" class="form-control" placeholder="" required value="" /> </td>
                    </tr>
                    <tr>
                      <td> <strong>Image2</strong> <span style="color:red;">*</span></strong> </td>
                      <td> <input type="file" name="image2" class="form-control" placeholder="" required value="" /> </td>
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
<link href=" <?php echo base_url()  ?>assets/cowadmin/css/jqvmap.css" rel='stylesheet' type='text/css' />
