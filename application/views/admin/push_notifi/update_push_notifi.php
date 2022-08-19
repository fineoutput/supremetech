<div class="content-wrapper">
<section class="content-header">
   <h1>
  Update Push Notification
  </h1>
  <ol class="breadcrumb">
   <li><a href="<?php echo base_url() ?>dcadmin/Home"><i class="fa fa-dashboard"></i> Dashboard</a></li>
   <li><a href="<?php echo base_url() ?>dcadmin/Push_notifi/view_push_notifi"><i class="fa fa-dashboard"></i> View Push Notification</a></li>
  </ol>
</section>
<section class="content">
<div class="row">
<div class="col-lg-12">

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><i class="fa fa-money fa-fw"></i> Update Push Notification </h3>
                    </div>

                             <? if(!empty($this->session->flashdata('smessage'))){  ?>
                                  <div class="alert alert-success alert-dismissible">
                              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                              <h4><i class="icon fa fa-check"></i> Alert!</h4>
                             <? echo $this->session->flashdata('smessage');  ?>
                            </div>
                               <? }
                               if(!empty($this->session->flashdata('emessage'))){  ?>
                               <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                           <? echo $this->session->flashdata('emessage');  ?>
                          </div>
                             <? }  ?>


                    <div class="panel-body">
                        <div class="col-lg-10">
                           <form action=" <?php echo base_url(); ?>dcadmin/Push_notifi/add_push_notifi_data/<? echo base64_encode(2); ?>/<?=$id;?>" method="POST" id="slide_frm" enctype="multipart/form-data">
                        <div class="table-responsive">
                            <table class="table table-hover">
                              <tr>
                            <td> <strong>Title</strong>  <span style="color:red;">*</span></strong> </td>
                            <td> <input type="text" name="title"  class="form-control" placeholder="" required value="<?=$push_notifi_data?>" />  </td>
                            </tr>
<tr>
<td> <strong>Image</strong> </td>
<td> <input type="file" name="image"  class="form-control" placeholder="" />
<?php if($push_notifi_data->image!=""){ ?> <img id="slide_img_path" height=200 width=300 src="<?php echo base_url().$push_notifi_data->image; ?> "> <?php }else{ ?> Sorry No File Found <?php } ?>  </td>
</tr>
<tr>
<td> <strong>Content</strong>  <span style="color:red;"></span></strong> </td>
<td> <input type="text" name="content"  class="form-control" placeholder="" value="<?=$push_notifi_data->content;?>" />  </td>
</tr>


                  <tr>
                    <td colspan="2" >
                      <input type="submit" class="btn custom_btn" value="save">
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
<link href=" <? echo base_url()  ?>assets/cowadmin/css/jqvmap.css" rel='stylesheet' type='text/css' />
