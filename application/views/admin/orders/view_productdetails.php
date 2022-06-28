<div class="content-wrapper">
        <section class="content-header">
           <h1>
           Orders Details
          </h1>
          <ol class="breadcrumb">
           <li><a href="<?php echo base_url() ?>dcadmin/home"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="<?php echo base_url() ?>dcadmin/orders/view_orders"><i class="fa fa-dashboard"></i> All Orders </a></li>
            <li class="active">View Slider Images</li>
          </ol>
        </section>
          <section class="content">
          <div class="row">
             <div class="col-lg-12">
                 <a class="btn custom_btn" href="<?php echo base_url() ?>dcadmin/orders/view_orders" role="button" style="margin-bottom:12px;">Orders</a>
                              <div class="panel panel-default">
                                  <div class="panel-heading">
                                      <h3 class="panel-title"><i class="fa fa-money fa-fw"></i>View Order Details</h3>
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
                                      <table class="table table-bordered table-hover table-striped" id="printTable">
                                          <thead>
                                              <tr>
                                                  <th>#</th>
                                                  <th>Product Image</th>
                                                  <th>Product Title</th>
                                                  <th>Order Id</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                  <?php $i=1; foreach($orderdetails_data->result() as $data) { ?>
                        <tr>
                            <td><?php echo $i ?> </td>
                            <td>
                            <?php  $this->db->select('*');
                                          $this->db->from('tbl_products');
                                          $this->db->where('id',$data->product_id);
                                          $dsa= $this->db->get();
                                          $da=$dsa->row();
                                 if($da->image!=""){  ?>
          <img id="slide_img_path" height=100 width=100  src="<?php echo base_url() ?><?php echo $da->image ?>">
                            <?php }else {  ?>
                            Sorry No image Found
                            <?php } ?>
                              </td>
                            <td><?php $this->db->select('*');
                                          $this->db->from('tbl_products');
                                          $this->db->where('id',$data->product_id);
                                          $dsa= $this->db->get();
                                          $da=$dsa->row();
                                          echo $da->title; ?></td>

                              <td><?php echo $data->order_id ?> </td>
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
      $('#printTable').DataTable({
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
