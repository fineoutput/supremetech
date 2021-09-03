<div class="content-wrapper">
        <section class="content-header">
           <h1>
          Add New Coupon
          </h1>
          <ol class="breadcrumb">
           <li><a href="<?php echo base_url() ?>dcadmin/dashboard"><i class="fa fa-dashboard"></i>Home</a></li>
            <li><a href="<?php echo base_url() ?>dcadmin/coupon/view_coupon"><i class="fa fa-dashboard"></i> All Coupon Codes </a></li>

          </ol>
        </section>
    <section class="content">
    <div class="row">
       <div class="col-lg-12">

                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title"><i class="fa fa-money fa-fw"></i> Add New Coupon</h3>
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
                                   <form action="<?php echo base_url() ?>dcadmin/coupon/add_coupon_data/<? echo base64_encode(1); ?>" method="POST" id="slide_frm" enctype="multipart/form-data">
                                <div class="table-responsive">
                                    <table class="table table-hover">

                      <tr>
                                                <td> <strong>Promocode</strong>  <span style="color:red;">*</span></strong> </td>
                                                <td>
                          <input type="text" name="promocode"  class="form-control" placeholder="" required value="" />
                                              </td>
                        </tr>
                        <tr>
                                                  <td> <strong>Start Date</strong>  <span style="color:red;">*</span></strong> </td>
                                                  <td>
                            <input type="date" name="start_date"  class="form-control" placeholder="" required value="" />
                                                </td>
                          </tr>
                          <tr>
                                                    <td> <strong>End Date</strong>  <span style="color:red;">*</span></strong> </td>
                                                    <td>
                              <input type="date" name="end_date"  class="form-control" placeholder="" required value="" />
                                                  </td>
                            </tr>
                            <tr>
                                                      <td> <strong>Minimum Cart Value</strong>  <span style="color:red;">*</span></strong> </td>
                                                      <td>
                                <input type="number" name="min_cart_amount"  class="form-control" placeholder="" required value="" />
                                                    </td>
                              </tr>
                              <tr>
                                                        <td> <strong>Maximum Discount Amount</strong>  <span style="color:red;">*</span></strong> </td>
                                                        <td>
                                  <input type="number" name="maximum_discount"  class="form-control" placeholder="" required value="" />
                                                      </td>
                                </tr>
                                <tr>
                                                          <td> <strong>Discount Percentage</strong>  <span style="color:red;">*</span></strong> </td>
                                                          <td>
                                    <input type="text" name="discount_percent"  class="form-control" placeholder="" required value="" />
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
