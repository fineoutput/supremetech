
        <div class="content-wrapper">
        <section class="content-header">
        <h1>
          View Products
        </h1>
        </section>
        <section class="content">
        <div class="row">
        <div class="col-lg-12">
        <a class="btn btn-info cticket" href="<?php echo base_url() ?>dcadmin/products/add_products"
        role="button" style="margin-bottom:12px;"> Add products</a>
        <div class="panel panel-default">
        <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-money fa-fw"></i>View products</h3>
        </div>
        <div class="panel panel-default">

        <? if(!empty($this->session->flashdata('smessage'))){ ?>
        <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4><i class="icon fa fa-check"></i> Alert!</h4>
        <? echo $this->session->flashdata('smessage'); ?>
        </div>
        <? }
        if(!empty($this->session->flashdata('emessage'))){ ?>
        <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4><i class="icon fa fa-ban"></i> Alert!</h4>
        <? echo $this->session->flashdata('emessage'); ?>
        </div>
        <? } ?>


        <div class="panel-body">
        <div class="box-body table-responsive no-padding">
        <table class="table table-bordered table-hover table-striped" id="userTable">
        <thead>
        <tr>
        <th>#</th>

 	 <th>Product Name</th>
 	 <th>Category</th>
 	 <th>Subcategory</th>
 	 <th>Minor Category</th>
 	 <th>image</th>
 	 <th>image1</th>
 	 <th>image2</th>
 	 <th>image3</th>
 	 <th>MRP</th>
 	 <th>Selling Price</th>
 	 <th>Product Description</th>
 	 <th>Model No.</th>


        <th>Status</th>
        <th>Action</th>
        </tr>
        </thead>
        <tbody>
        <?php $i=1; foreach($products_data->result() as $data) { ?>
        <tr>
        <td><?php echo $i ?> </td>
        <td><?php echo $data->productname?></td>


 <?
            $this->db->select('*');
$this->db->from('tbl_category');
$this->db->where('id',$data->category_id);
// print_r($data->category_id);
// exit;
$category_data= $this->db->get()->row();
// print_r($category_data);
// exit;
$category_name=$category_data->category;
?>
 <?
            $this->db->select('*');
$this->db->from('tbl_subcategory');
$this->db->where('id',$data->subcategory_id);
$subcategory_data= $this->db->get()->row();
// print_r($subcategory_data);
// exit;
$subcategory_name=$subcategory_data->subcategory;
?>
 <?
            $this->db->select('*');
$this->db->from('tbl_minorcategory');
$this->db->where('id',$data->minorcategory_id);
$minorcategory_data= $this->db->get()->row();
// print_r($subcategory_data);
// exit;
$minorcategory_name=$minorcategory_data->minorcategoryname;
?>
 	 <td><?php echo $category_name?></td>
 	 <td><?php echo $subcategory_name?></td>
 	 <td><?php echo $minorcategory_name?></td>

        <td>
        <?php if($data->image!=""){ ?>
        <img id="slide_img_path" height=50 width=100 src="<?php echo base_url().$data->image
        ?>" >
        <?php }else { ?>
        Sorry No File Found
        <?php } ?>
        </td>


        <td>
        <?php if($data->image1!=""){ ?>
        <img id="slide_img_path" height=50 width=100 src="<?php echo base_url().$data->image1
        ?>" >
        <?php }else { ?>
        Sorry No File Found
        <?php } ?>
        </td>


        <td>
        <?php if($data->image2!=""){ ?>
        <img id="slide_img_path" height=50 width=100 src="<?php echo base_url().$data->image2
        ?>" >
        <?php }else { ?>
        Sorry No File Found
        <?php } ?>
        </td>


        <td>
        <?php if($data->image3!=""){ ?>
        <img id="slide_img_path" height=50 width=100 src="<?php echo base_url().$data->image3
        ?>" >
        <?php }else { ?>
        Sorry No File Found
        <?php } ?>
        </td>

	 <td><?php echo $data->mrp ?></td>
	 <td><?php echo $data->sellingprice ?></td>
 	 <td><?php echo $data->productdescription ?></td>
 	 <td><?php echo $data->modelno ?></td>





        <td><?php if($data->is_active==1){ ?>
        <p class="label bg-green" >Active</p>

        <?php } else { ?>
        <p class="label bg-yellow" >Inactive</p>


        <?php } ?>
        </td>
        <td>
        <div class="btn-group" id="btns<?php echo $i ?>">
        <div class="btn-group">
        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
        Action <span class="caret"></span></button>
        <ul class="dropdown-menu" role="menu">

        <?php if($data->is_active==1){ ?>
        <li><a href="<?php echo base_url() ?>dcadmin/products/updateproductsStatus/<?php echo
        base64_encode($data->id) ?>/inactive">Inactive</a></li>
        <?php } else { ?>
        <li><a href="<?php echo base_url() ?>dcadmin/products/updateproductsStatus/<?php echo
        base64_encode($data->id) ?>/active">Active</a></li>
        <?php } ?>
        <li><a href="<?php echo base_url() ?>dcadmin/products/update_products/<?php echo
        base64_encode($data->id) ?>">Edit</a></li>
        <li><a href="javascript:;" class="dCnf" mydata="<?php echo $i ?>">Delete</a></li>
        </ul>
        </div>
        </div>

        <div style="display:none" id="cnfbox<?php echo $i ?>">
        <p> Are you sure delete this </p>
        <a href="<?php echo base_url() ?>dcadmin/products/delete_products/<?php echo
        base64_encode($data->id); ?>" class="btn btn-danger" >Yes</a>
        <a href="javasript:;" class="cans btn btn-default" mydatas="<?php echo $i ?>" >No</a>
        </div>
        </td>
        </tr>
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
        $('#userTable').DataTable({
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
        <!-- <script type="text/javascript" src="<?php echo base_url()
        ?>assets/slider/ajaxupload.3.5.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>assets/slider/rs.js"></script> -->
