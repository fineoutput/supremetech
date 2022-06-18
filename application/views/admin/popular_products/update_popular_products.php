<div class="content-wrapper">
  <section class="content-header">
    <h1>
      Update Popular_products
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo base_url() ?>dcadmin/home"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li><a href="<?php echo base_url() ?>dcadmin/Popular_products/view_popular_products"><i class="fa fa-dashboard"></i> All Popular Products </a></li>
    </ol>
  </section>
  <section class="content">
    <div class="row">
      <div class="col-lg-12">

        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-money fa-fw"></i> Update Popular_products </h3>
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
              <form action=" <?php echo base_url(); ?>dcadmin/Popular_products/add_popular_products_data/<?php echo base64_encode(2); ?>/<?=$id;?>" method="POST" id="slide_frm" enctype="multipart/form-data">
                <div class="table-responsive">
                  <table class="table table-hover">
                    <tr>
                      <td> <strong>image </strong> <span style="color:red;">*</span></strong> </td>
                      <td> <input type="file" name="image" class="form-control" placeholder="" />
                        <?php if ($popular_products_data->image!="") { ?> <img id="slide_img_path" height=200 width=300 src="<?php echo base_url().$popular_products_data->image; ?> "> <?php } else { ?> Sorry No File Found <?php } ?> </td>
                    </tr>
                    <tr>
                      <td> <strong>image1</strong> <span style="color:red;">*</span></strong> </td>
                      <td> <input type="file" name="image1" class="form-control" placeholder="" />
                        <?php if ($popular_products_data->image1!="") { ?> <img id="slide_img_path" height=200 width=300 src="<?php echo base_url().$popular_products_data->image1; ?> "> <?php } else { ?> Sorry No File Found <?php } ?> </td>
                    </tr>
                    <tr>
                      <td> <strong>image2</strong> <span style="color:red;">*</span></strong> </td>
                      <td> <input type="file" name="image2" class="form-control" placeholder="" />
                        <?php if ($popular_products_data->image2!="") { ?> <img id="slide_img_path" height=200 width=300 src="<?php echo base_url().$popular_products_data->image2; ?> "> <?php } else { ?> Sorry No File Found <?php } ?> </td>
                    </tr>image2
                    <tr>
                      <td> <strong>image3</strong> <span style="color:red;">*</span></strong> </td>
                      <td> <input type="file" name="image3" class="form-control" placeholder="" />
                        <?php if ($popular_products_data->image3!="") { ?> <img id="slide_img_path" height=200 width=300 src="<?php echo base_url().$popular_products_data->image3; ?> "> <?php } else { ?> Sorry No File Found <?php } ?> </td>
                    </tr>
                    <!-- <tr>
<td> <strong>image4</strong>  <span style="color:red;">*</span></strong> </td>
<td> <input type="file" name="image4"  class="form-control" placeholder="" />
<?php if ($popular_products_data->image4!="") { ?> <img id="slide_img_path" height=200 width=300 src="<?php echo base_url().$popular_products_data->image4; ?> "> <?php } else { ?> Sorry No File Found <?php } ?>  </td>
</tr> -->
                    <tr>
                      <td> <strong>Product Description</strong> <span style="color:red;">*</span></strong> </td>
                      <td> <input type="text" name="productdescription" class="form-control" placeholder="" required value="<?=$popular_products_data->productdescription;?>" /> </td>
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
