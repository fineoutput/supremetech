<div class="content-wrapper">
  <section class="content-header">
    <h1>
      Add New Slider Image
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo base_url() ?>dcadmin/home"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li><a href="<?php echo base_url() ?>dcadmin/Slider/view_slider"><i class="fa fa-dashboard"></i> All Slider Images </a></li>
    </ol>
  </section>
  <section class="content">
    <div class="row">
      <div class="col-lg-12">

        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-money fa-fw"></i> Add New Slider Image</h3>
          </div>

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
            <div class="col-lg-10">
              <form action="<?php echo base_url() ?>dcadmin/Slider/add_slider_data/<? echo base64_encode(2); ?>/<?= $id ?>" method="POST" id="slide_frm" enctype="multipart/form-data">
                <div class="table-responsive">
                  <table class="table table-hover">
                    <tr>
                      <td> <strong>Web Image</strong> <span style="color:red;">*<br />1920X620px</span></strong> </td>
                      <td>
                        <input type="file" name="web_image" class="form-control" placeholder=""  value="" />
                        <?php if($slider->web_image!=""){  ?>
                        <img id="slide_img_path" height=50 width=100 src="<?php echo base_url() ?><?php echo $slider->web_image; ?>">
                        <?php }else {  ?>
                        Sorry No image Found
                        <?php } ?>
                      </td>
                    </tr>
                    <tr>
                      <td> <strong>Mobile Image</strong> <span style="color:red;">*<br />840X1206px</span></strong> </td>
                      <td>
                        <input type="file" name="mob_image" class="form-control" placeholder=""  value="" />
                        <?php if($slider->mob_image!=""){  ?>
                        <img id="slide_img_path" height=50 width=100 src="<?php echo base_url() ?><?php echo $slider->mob_image; ?>">
                        <?php }else {  ?>
                        Sorry No image Found
                        <?php } ?>
                      </td>
                    </tr>
                    <!-- <tr>
                      <td> <strong>Link</strong> <span style="color:red;">*</span></strong> </td>
                      <td>
                        <input type="url" name="link" class="form-control" placeholder="" required value="<?= $slider->link; ?>" />
                      </td>
                    </tr> -->
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


<script type="text/javascript" src="<?php echo base_url() ?>assets/slider/ajaxupload.3.5.js"></script>
<link href="<? echo base_url() ?>assets/cowadmin/css/jqvmap.css" rel='stylesheet' type='text/css' />
