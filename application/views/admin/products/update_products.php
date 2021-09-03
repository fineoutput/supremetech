<div class="content-wrapper">
        <section class="content-header">
           <h1>
            Add New Product
          </h1>
          <ol class="breadcrumb">
           <li><a href="<?php echo base_url() ?>dcadmin/dashboard"><i class="fa fa-dashboard"></i>Home</a></li>
            <li><a href="<?php echo base_url() ?>dcadmin/products/view_products"><i class="fa fa-dashboard"></i> Products List</a></li>

          </ol>
        </section>
    <section class="content">
    <div class="row">
       <div class="col-lg-12">

                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title"><i class="fa fa-money fa-fw"></i> Add New Product</h3>
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
                                   <form action="<?php echo base_url() ?>dcadmin/products/add_product_data/<? echo base64_encode(2); ?>/<?= $id ?>" method="POST" id="slide_frm" enctype="multipart/form-data">
                                <div class="table-responsive">
                                    <table class="table table-hover">

                      <tr>
                                                <td> <strong>Title</strong>  <span style="color:red;">*</span></strong> </td>
                                                <td>
                          <input type="text" name="title"  class="form-control" placeholder="" required value="<?= $product->title; ?>" />
                                              </td>
                        </tr>
                        <tr>
                                                  <td> <strong>Model No</strong>  <span style="color:red;">*</span></strong> </td>
                                                  <td>
                            <input type="text" name="model_no"  class="form-control" placeholder="" required value="<?= $product->model_no; ?>" />
                                                </td>
                          </tr>
                            <tr>
                                                      <td> <strong>MRP</strong>  <span style="color:red;">*</span></strong> </td>
                                                      <td>
                                <input type="text" name="mrp"  class="form-control" placeholder="" required value="<?= $product->mrp; ?>" />
                                                    </td>
                              </tr>
                              <tr>
                                                        <td> <strong>Sell Price</strong>  <span style="color:red;">*</span></strong> </td>
                                                        <td>
                                  <input type="text" name="sell_price"  class="form-control" placeholder="" required value="<?= $product->sell_price; ?>" />
                                                      </td>
                                </tr>
                                <tr>
                                                          <td> <strong>Desription</strong>  <span style="color:red;">*</span></strong> </td>
                                                          <td>
                                    <textarea name="description"  class="form-control" placeholder="" required value=""><?php echo $product->description; ?></textarea>
                                                        </td>
                                  </tr>
                              <tr>
                                                        <td> <strong>Sub Category</strong>  <span style="color:red;">*</span></strong> </td>
                                                        <td>
                                  <select class="selectpicker form-control" name="subcategory_id" data-live-search="true" title=" Select Category * ">
                                          <?php foreach ($addsubcategories_data->result() as $value){ ?>
                                          <option value="<?php echo $value->id; ?>" <?= ($value->id == $product->subcategory_id) ? 'selected' : ''; ?>><?php echo $value->title; ?></option>
                                        <?php } ?>
                                  </select>
                                                      </td>
                                </tr>
                                <tr>
                                                          <td> <strong>Image</strong>  <span style="color:red;">*</span></strong> </td>
                                                          <td>
                                    <input type="file" name="image"  class="form-control" placeholder="" required value="<?= $product->title; ?>" />
                                                        </td>
                                                        <td>
                                                            <?php if($product->image!=""){  ?>
                                      <img id="slide_img_path" height=100 width=100  src="<?php echo base_url() ?><?php echo $product->image; ?>">
                                                        <?php }else {  ?>
                                                        Sorry No image Found
                                                        <?php } ?>
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


<script type="text/javascript" src="<?php echo base_url() ?>assets/slider/ajaxupload.3.5.js"></script>
<link href="<? echo base_url() ?>assets/cowadmin/css/jqvmap.css" rel='stylesheet' type='text/css' />
