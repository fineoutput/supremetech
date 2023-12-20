<div class="content-wrapper">
  <section class="content-header">
    <h1>
      View Products
    </h1>
  </section>
  <section class="content">
    <div class="row">
      <div class="col-lg-12">
        <a class="btn custom_btn" href="<?php echo base_url() ?>dcadmin/Products/add_products/<?= $id ?>" role="button" style="margin-bottom:12px;"> Add products</a>
        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-money fa-fw"></i>View products</h3>
          </div>
          <div class="panel panel-default">
            <? if (!empty($this->session->flashdata('smessage'))) { ?>
              <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-check"></i> Alert!</h4>
                <? echo $this->session->flashdata('smessage'); ?>
              </div>
            <? }
            if (!empty($this->session->flashdata('emessage'))) { ?>
              <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
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
                      <th>Product Name</th>
                      <th>Subcategory</th>
                      <th>Minor Category</th>
                      <th>image</th>
                      <th>Image 1</th>
                      <th>Video 1</th>
                      <th>Video 2</th>
                      <th>T3 Price</th>
                      <th>T3 Max Limit</th>
                      <th>T2 Price</th>
                      <th>T2 Min Limit</th>
                      <th>T2 Max Limit</th>
                      <th>Product Description</th>
                      <th>Model No.</th>
                      <th>Inventory</th>
                      <th>weight</th>
                      <th>Featured Product</th>
                      <th>Popular Product</th>
                      <th>Status</th>
                      <th>Action</th>
                    </tr>
                  </thead>
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
  label {
    margin: 5px;
  }
</style>
<script src="<?php echo base_url() ?>assets/admin/plugins/datatables/jquery.dataTables.js"></script>
<script src="<?php echo base_url() ?>assets/admin/plugins/datatables/dataTables.bootstrap.js"></script>
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
  $(document).ready(function() {
    $('#printTable').DataTable({
      processing: true,
      searching: true,
      serverSide: true,
      ajax: {
        url: '<?= base_url() ?>dcadmin/Products/get_products',
        type: 'POST',
        data: function(d) {
          // Add the required parameters to the request
          d.order = d.order || [{
            column: 0,
            dir: 'asc'
          }]; // Default sorting
          d.columns = d.columns || [{
            data: '0'
          }];
          d.status = <?= $id2 ?> || 1; // DataTables draw counter
          d.draw = d.draw || 1; // DataTables draw counter
          d.start = d.start || 0; // Paging first record indicator
          d.length = d.length || 50; // Number of records that the table can display in the current draw
          d.search = d.search || ''; // Global search value

          // You can add more parameters if needed

          return d;
        }
      },
      responsive: true,
      "bStateSave": true,
      "fnStateSave": function(oSettings, oData) {
        localStorage.setItem('offersDataTables', JSON.stringify(oData));
      },
      "fnStateLoad": function(oSettings) {
        return JSON.parse(localStorage.getItem('offersDataTables'));
      },
      dom: 'Bfrtip',
    
    });

    // Click event for confirmation
    $(document.body).on('click', '.dCnf', function() {
      var i = $(this).attr("mydata");
      console.log(i);
      $("#btns" + i).hide();
      $("#cnfbox" + i).show();
    });

    // Click event for canceling confirmation
    $(document.body).on('click', '.cans', function() {
      var i = $(this).attr("mydatas");
      console.log(i);
      $("#btns" + i).show();
      $("#cnfbox" + i).hide();
    });
  });
</script>
<!-- <script type="text/javascript" src="<?php echo base_url()
                                          ?>assets/slider/ajaxupload.3.5.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/slider/rs.js"></script> -->