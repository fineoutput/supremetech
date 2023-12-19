  <div class="content-wrapper">
    <section class="content-header">
      <h1>
        <?= $heading ?> Vendors
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url() ?>dcadmin/home"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">View <?= $heading ?> Vendors</li>
      </ol>
    </section>
    <section class="content">
      <div class="row">
        <div class="col-lg-12">
          <!-- <a class="btn custom_btn" href="dcadmin/Vendors/add_vendors" role="button" style="margin-bottom:12px;"> Add Vendors </a> -->
          <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title"><i class="fa fa-money fa-fw"></i>View <?= $heading ?> Vendors</h3>
            </div>
            <div class="panel panel-default">
              <?php if (!empty($this->session->flashdata('smessage'))) { ?>
                <div class="alert alert-success alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                  <h4><i class="icon fa fa-check"></i> Alert!</h4>
                  <?php echo $this->session->flashdata('smessage'); ?>
                </div>
              <?php }
              if (!empty($this->session->flashdata('emessage'))) { ?>
                <div class="alert alert-danger alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                  <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                  <?php echo $this->session->flashdata('emessage'); ?>
                </div>
              <?php } ?>
              <div class="panel-body">
                <div class="box-body table-responsive no-padding">
                  <table class="table table-bordered table-hover table-striped" id="printTable">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Full Name</th>
                        <th>Company Name</th>
                        <th>Email</th>
                        <th>Address</th>
                        <th>District</th>
                        <th>City</th>
                        <th>State</th>
                        <th>Zipcode</th>
                        <th>Contact Number</th>
                        <th>GST IN</th>
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
  <script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>
  <script type="text/javascript">
    // buttons: [
    //     'copy', 'csv', 'excel', 'pdf', 'print'
    // ]
    $(document).ready(function() {
      $('#printTable').DataTable({
        processing: true,
        searching: true,
        serverSide: true,
        ajax: '<?= base_url() ?>dcadmin/Vendors/get_vendors/' + <?= $is_active ?>,
        responsive: true,
        "bStateSave": true,
        "fnStateSave": function(oSettings, oData) {
          localStorage.setItem('offersDataTables', JSON.stringify(oData));
        },
        "fnStateLoad": function(oSettings) {
          return JSON.parse(localStorage.getItem('offersDataTables'));
        },
        dom: 'Bfrtip',
        buttons: [{
            extend: 'copyHtml5',
            exportOptions: {
              columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11] //number of columns, excluding # column
            }
          },
          {
            extend: 'csvHtml5',
            exportOptions: {
              columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11]
            }
          },
          {
            extend: 'excelHtml5',
            exportOptions: {
              columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11]
            }
          },
          {
            extend: 'pdfHtml5',
            exportOptions: {
              columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11]
            }
          },
          {
            extend: 'print',
            exportOptions: {
              columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11]
            }
          },
        ]
      });
      $(document.body).on('click', '.dCnf', function() {
        var i = $(this).attr("mydata");
        console.log(i);
        $("#btns" + i).hide();
        $("#cnfbox" + i).show();
      });
      $(document.body).on('click', '.cans', function() {
        var i = $(this).attr("mydatas");
        console.log(i);
        $("#btns" + i).show();
        $("#cnfbox" + i).hide();
      })
    });
  </script>
  <!-- <script type="text/javascript" src="<?php echo base_url() ?>assets/slider/ajaxupload.3.5.js"></script>
      <script type="text/javascript" src="<?php echo base_url() ?>assets/slider/rs.js"></script>	  -->