<div class="content-wrapper">
  <section class="content-header">
    <h1>
      Add New Sellers
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo base_url() ?>dcadmin/home"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      <li><a href="<?php echo base_url() ?>dcadmin/Vendors/view_vendors"><i class="fa fa-dashboard"></i> All Vendors </a></li>
      <li class="active">View Vendors</li>
    </ol>
  </section>
  <section class="content">
    <div class="row">
      <div class="col-lg-12">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-money fa-fw"></i> Add New Seller</h3>
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
              <form action="<?php echo base_url() ?>dcadmin/Vendors/add_vendors_data/<? echo base64_encode(2); ?>/<?= $id ?>" method="POST" id="slide_frm" enctype="multipart/form-data">
                <div class="table-responsive">
                  <table class="table table-hover">
                    <tr>
                      <td> <strong>Full Name</strong> <span style="color:red;">*</span></strong> </td>
                      <td>
                        <input type="text" name="name" class="form-control" placeholder="" required value="<?= $vendors->name; ?>" />
                      </td>
                    </tr>
                    <tr>
                      <td> <strong>Company Name</strong> <span style="color:red;">*</span></strong> </td>
                      <td>
                        <input type="text" name="company_name" class="form-control" placeholder="" value="<?= $vendors->company_name; ?>" />
                      </td>
                    </tr>
                    <tr>
                      <td> <strong>Email</strong> <span style="color:red;">*</span></strong> </td>
                      <td>
                        <input type="email" name="email" class="form-control" placeholder="" required value="<?= $vendors->email; ?>" />
                      </td>
                    </tr>
                    <tr>
                      <td> <strong>Address</strong> <span style="color:red;">*</span></strong> </td>
                      <td>
                        <input type="text" name="address" class="form-control" placeholder="" required value="<?= $vendors->address; ?>" />
                      </td>
                    </tr>
                    <tr>
                      <td> <strong>District</strong> <span style="color:red;">*</span></strong> </td>
                      <td>
                        <input type="text" name="district" class="form-control" placeholder="" value="<?= $vendors->district; ?>" />
                      </td>
                    </tr>
                    <tr>
                <td> <strong>City</strong> <span style="color:red;">*</span></strong> </td>
                <td>
                  <input type="text" name="city" class="form-control" placeholder="" value="<?= $vendors->city; ?>" />
                </td>
              </tr>
              <tr>
                <td> <strong>State</strong> <span style="color:red;">*</span></strong> </td>
                <td>
                  <input type="text" name="state" class="form-control" placeholder="" value="<?= $vendors->state; ?>" />
                </td>
              </tr>
              <tr>
                <td> <strong>Zipcode</strong> <span style="color:red;">*</span></strong> </td>
                <td>
                  <input type="text" name="zipcode" class="form-control" placeholder="" value="<?= $vendors->zipcode; ?>" />
                </td>
              </tr>
              <tr>
                <td> <strong>Contact Number</strong> <span style="color:red;">*</span></strong> </td>
                <td>
                  <input type="number" name="phone" class="form-control" placeholder="" required value="<?= $vendors->phone; ?>" />
                </td>
              </tr>
              <tr>
                <td> <strong>GST IN</strong> <span style="color:red;">*</span></strong> </td>
                <td>
                  <input type="text" name="gstin" class="form-control" placeholder="" required value="<?= $vendors->gstin; ?>" />
                </td>
              </tr>
              <tr>
                    <td> <strong> Visiting card </strong> <span style="color:red;"><br />Big: 2220px X 1000px<br /></span></strong> </td>
                    <td>
                      <input type="file" name="image1" class="form-control" placeholder="" value="<?=$vendors->image1?>" />
                      <?php if ($vendors->image1!="") {  ?>
                      <img id="slide_img_path" height=250 width=250 src="<?php echo base_url().$vendors->image1 ?>">
                      <?php } else {  ?>
                      Sorry No image Found
                      <?php } ?>
                    </td>
                  </tr>
                    <tr>
                      <td> <strong>Registration date</strong> <span style="color:red;">*</span></strong> </td>
                      <td>
                        <input type="text" name="date" class="form-control" placeholder="" value="<?= $vendors->date; ?>" />
                      </td>
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
<script type="text/javascript" src="<?php echo base_url() ?>assets/slider/ajaxupload.3.5.js"></script>
<link href="<? echo base_url() ?>assets/cowadmin/css/jqvmap.css" rel='stylesheet' type='text/css' />
