
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Dashboard
          </h1>
          <ol class="breadcrumb">
            <li class="active"><i class="fa fa-dashboard"></i> Home</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <!-- Info boxes -->
          <div class="row">
            <div class="col-md-3 col-sm-6 col-xs-12">
              <a href="<?=base_url()?>dcadmin/Vendors/view_vendors">
              <div class="info-box">
                <span class="info-box-icon bg-purple"><i class="ionicons ion-android-happy"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">TOTAL VENDORS</span>
                  <span class="info-box-number">
                    <?$this->db->select('*');
                    $this->db->from('tbl_users');
                    $total_vendors = $this->db->count_all_results();
                    echo $total_vendors;
                    ?>
                  </span>
                </div><!-- /.info-box-content -->
              </div></a><!-- /.info-box -->
            </div><!-- /.col -->
            <div class="col-md-3 col-sm-6 col-xs-12">
              <a href="<?=base_url()?>dcadmin/Vendors/view_vendors">
              <div class="info-box">
                <span class="info-box-icon bg-yellow"><i class="ionicons ion-android-people"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">PENDING VENDOR REQUESTS</span>
                  <span class="info-box-number">
                    <?$this->db->select('*');
                    $this->db->from('tbl_users');
                    $this->db->where('is_active', 0);
                    $pending_vendors = $this->db->count_all_results();
                    echo $pending_vendors;
                    ?>
                  </span>
                </div><!-- /.info-box-content -->
              </div></a><!-- /.info-box -->
            </div><!-- /.col -->
            <div class="col-md-3 col-sm-6 col-xs-12">
              <a href="<?=base_url()?>dcadmin/Vendors/view_vendors">
              <div class="info-box">
                <span class="info-box-icon bg-aqua"><i class="ionicons ion-ios-checkmark-outline"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">APPROVED VENDORS</span>
                  <span class="info-box-number"><?$this->db->select('*');
                  $this->db->from('tbl_users');
                  $this->db->where('is_active', 1);
                  $approved_vendors = $this->db->count_all_results();
                  echo $approved_vendors;
                  ?></span>
                </div><!-- /.info-box-content -->
              </div></a><!-- /.info-box -->
            </div><!-- /.col -->
            <div class="col-md-3 col-sm-6 col-xs-12">
              <a href="javascript:void(0)">
              <div class="info-box">
                <span class="info-box-icon bg-orange"><i class="ionicons ion-bag"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">TOTAL ORDERS</span>
                  <span class="info-box-number"><?$this->db->select('*');
                  $this->db->from('tbl_order1');
                  $total_orders = $this->db->count_all_results();
                  echo $total_orders; ?></span>
                </div><!-- /.info-box-content -->
              </div></a><!-- /.info-box -->
            </div><!-- /.col -->
            <!-- fix for small devices only -->
            <div class="clearfix visible-sm-block"></div>

            <div class="col-md-3 col-sm-6 col-xs-12">
              <a href="<?=base_url()?>dcadmin/Orders/view_orders">
              <div class="info-box">
                <span class="info-box-icon bg-green"><i class="ionicons ion-bag"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">NEW ORDERS</span>
                  <span class="info-box-number"><?$this->db->select('*');
                  $this->db->from('tbl_order1');
                  $this->db->where('order_status', 1);
                  $new_orders = $this->db->count_all_results();
                  echo $new_orders;
                  ?></span>
                </div><!-- /.info-box-content -->
              </div></a><!-- /.info-box -->
            </div><!-- /.col -->
              <div class="col-md-3 col-sm-6 col-xs-12">
                <a href="<?=base_url()?>dcadmin/Orders/view_hold_orders">
                <div class="info-box">
                  <span class="info-box-icon bg-blue"><i class="ionicons ion-android-bookmark"></i></span>
                  <div class="info-box-content">
                    <span class="info-box-text">ON HOLD ORDERS</span>
                    <span class="info-box-number"><?$this->db->select('*');
                    $this->db->from('tbl_order1');
                    $this->db->where('order_status', 6);
                    $onhold = $this->db->count_all_results();
                    echo $onhold;?></span>
                  </div><!-- /.info-box-content -->
                </div></a><!-- /.info-box -->
              </div><!-- /.col -->
            <div class="col-md-3 col-sm-6 col-xs-12">
              <a href="<?=base_url()?>dcadmin/Inventory/view_icategory">
              <div class="info-box">
                <span class="info-box-icon bg-grey"><i class="ion ion-ios-cart-outline"></i></span>
                <div class="info-box-content">
                  <span class="info-box-text">OUT OF STOCK PRODUCTS</span>
                  <span class="info-box-number"><?$this->db->select('*');
                  $this->db->from('tbl_inventory');
                  $this->db->where('quantity', 0);
                  $out_O_stock = $this->db->count_all_results();
                  echo $out_O_stock;?></span>
                </div><!-- /.info-box-content -->
              </div></a><!-- /.info-box -->
            </div><!-- /.col -->

          </div><!-- /.row -->


        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->


    </div><!-- ./wrapper -->
