<div class="content-wrapper">
    <section class="content-header">
      <h1>
      Accepted Orders
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url() ?>dcadmin/home"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">View  Accepted Orders</li>
      </ol>
    </section>
    <section class="content">
      <div class="row">
        <div class="col-lg-12">
          <!-- <a class="btn custom_btn" href="dcadmin/Vendors/add_vendors" role="button" style="margin-bottom:12px;"> Add Vendors </a> -->
          <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title"><i class="fa fa-money fa-fw"></i>View Accepted Orders</h3>
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
                    <th>Order_id</th>
                    <th>User</th>
                    <th>Total Amount</th>
                    <th>Total Order Weight</th>
                    <th>User mob.</th>
                    <th>Address</th>
                    <th>District</th>
                    <th>City</th>
                    <th>State</th>
                    <th>pincode</th>
                    <th>payment type</th>
                    <th>Last updated date</th>
                    <th>order date</th>
                    <th>Bank Receipt</th>
                    <th>order status</th>
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
      function newexportaction(e, dt, button, config) {
        var self = this;
        var oldStart = dt.settings()[0]._iDisplayStart;
        dt.one('preXhr', function(e, s, data) {
          // Just this once, load all data from the server...
          data.start = 0;
          data.length = 2147483647;
          dt.one('preDraw', function(e, settings) {
            // Call the original action function
            if (button[0].className.indexOf('buttons-copy') >= 0) {
              $.fn.dataTable.ext.buttons.copyHtml5.action.call(self, e, dt, button, config);
            } else if (button[0].className.indexOf('buttons-excel') >= 0) {
              $.fn.dataTable.ext.buttons.excelHtml5.available(dt, config) ?
                $.fn.dataTable.ext.buttons.excelHtml5.action.call(self, e, dt, button, config) :
                $.fn.dataTable.ext.buttons.excelFlash.action.call(self, e, dt, button, config);
            } else if (button[0].className.indexOf('buttons-csv') >= 0) {
              $.fn.dataTable.ext.buttons.csvHtml5.available(dt, config) ?
                $.fn.dataTable.ext.buttons.csvHtml5.action.call(self, e, dt, button, config) :
                $.fn.dataTable.ext.buttons.csvFlash.action.call(self, e, dt, button, config);
            } else if (button[0].className.indexOf('buttons-pdf') >= 0) {
              $.fn.dataTable.ext.buttons.pdfHtml5.available(dt, config) ?
                $.fn.dataTable.ext.buttons.pdfHtml5.action.call(self, e, dt, button, config) :
                $.fn.dataTable.ext.buttons.pdfFlash.action.call(self, e, dt, button, config);
            } else if (button[0].className.indexOf('buttons-print') >= 0) {
              $.fn.dataTable.ext.buttons.print.action(e, dt, button, config);
            }
            dt.one('preXhr', function(e, s, data) {
              // DataTables thinks the first item displayed is index 0, but we're not drawing that.
              // Set the property to what it was before exporting.
              settings._iDisplayStart = oldStart;
              data.start = oldStart;
            });
            // Reload the grid with the original page. Otherwise, API functions like table.cell(this) don't work properly.
            setTimeout(dt.ajax.reload, 0);
            // Prevent rendering of the full data to the DOM
            return false;
          });
        });
        // Requery the server with the new one-time export settings
        dt.ajax.reload();
      }
      $('#printTable').DataTable({
        processing: true,
        searching: true,
        serverSide: true,
        ajax: {
          url: '<?= base_url() ?>dcadmin/Orders/get_accept_order',
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
           // DataTables draw counter
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
        buttons: [{
            extend: 'copyHtml5',
            exportOptions: {
              columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14 ,15, 16]
            },
            "titleAttr": 'Excel',
            "action": newexportaction
          },
          {
            extend: 'csvHtml5',
            exportOptions: {
              columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14 ,15, 16]
            },
            "titleAttr": 'Excel',
            "action": newexportaction
          },
          {
            extend: 'excelHtml5',
            exportOptions: {
              columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14 ,15 ,16],
            },
            "titleAttr": 'Excel',
            "action": newexportaction

          },
          {
            extend: 'pdfHtml5',
            exportOptions: {
              columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16],
            },
            "titleAttr": 'Excel',
            "action": newexportaction
          },
          {
            extend: 'print',
            exportOptions: {
              columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16]
            },
            "titleAttr": 'Excel',
            "action": newexportaction
          },
        ],

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
  <!-- <script type="text/javascript" src="<?php echo base_url() ?>assets/slider/ajaxupload.3.5.js"></script>
      <script type="text/javascript" src="<?php echo base_url() ?>assets/slider/rs.js"></script>	  -->