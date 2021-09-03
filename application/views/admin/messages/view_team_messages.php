<div class="content-wrapper">
        <section class="content-header">
           <h1>
          Messages
          </h1>
          <ol class="breadcrumb">
           <li><a href="<?php echo base_url() ?>admin/dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?php echo base_url() ?>admin/college"><i class="fa fa-dashboard"></i> All Messages </a></li>

          </ol>
        </section>
    <section class="content">
    <div class="row">
       <div class="col-lg-12">

<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-money fa-fw"></i>Messages</h3>
    </div>
    <div class="panel-body">
        <div class="col-lg-10">
          <div class='col-md-10 '>
            <!-- DIRECT CHAT -->
            <div class="box box-warning direct-chat direct-chat-warning">
              <div class="box-header with-border">
                <h3 class="box-title">Chat</h3>
                <div class="box-tools pull-right">
                  <span data-toggle="tooltip" title="3 New Messages" class='badge bg-yellow'>3</span>
                  <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                  <button class="btn btn-box-tool" data-toggle="tooltip" title="Contacts" data-widget="chat-pane-toggle"><i class="fa fa-comments"></i></button>
                  <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
              </div><!-- /.box-header -->
              <div class="box-body">
                <!-- Conversations are loaded here -->
                <div class="direct-chat-messages">
<?php
if(!empty($team_msg->result()))
{

$i=1;
foreach($team_msg->result() as $data) { ?>
                  <!-- Message. Default to the left -->
                  <?
                  // echo $data->to_id;
                  if($data->to_id==$usr_id){
                    ?>
                    <div class="direct-chat-msg">
                      <div class='direct-chat-info clearfix'>
                        <span class='direct-chat-name pull-left'><?
            $this->db->select('*');
            $this->db->from('tbl_team');
            $this->db->where('id',$id);
            $dsa= $this->db->get();
            $da=$dsa->row();
            echo $da->name;

                        ?></span>
                        <span class='direct-chat-timestamp pull-right'><?
                        $newdate = new DateTime($data->date);
                        echo $newdate->format('d-m-Y h:i:s A');

                        ?></span>
                      </div><!-- /.direct-chat-info -->
                      <?
                      if(!empty($da->image)){
                        ?>
                          <img class="direct-chat-img" src="<? echo base_url() ?>assets/uploads/team/<? echo $da->image; ?>" alt="message user image" /><!-- /.direct-chat-img -->
                          <?
                      }
                      else{
                        ?>
                          <img class="direct-chat-img" src="<? echo base_url() ?>assets/admin/team/avatar.png" alt="message user image" /><!-- /.direct-chat-img -->
                          <?
                      }
                    ?>
                      <div class="direct-chat-text">
                        <? echo $data->msg; ?>
                      </div><!-- /.direct-chat-text -->
                    </div><!-- /.direct-chat-msg -->
                    <?

                  }
if($data->to_id==$id){
      ?>

                  <!-- Message to the right -->
                  <div class="direct-chat-msg right">
                    <div class='direct-chat-info clearfix'>
                      <span class='direct-chat-name pull-right'>
                        <?
                        $this->db->select('*');
                        $this->db->from('tbl_team');
                        $this->db->where('id',$usr_id);
                        $dsa= $this->db->get();
                        $da=$dsa->row();
                        echo $da->name;
                        ?>
                      </span>
                      <span class='direct-chat-timestamp pull-left'><?
                      $newdate = new DateTime($data->date);
                      echo $newdate->format('d-m-Y h:i:s A');
                      ?></span>
                    </div><!-- /.direct-chat-info -->
                    <?
                    if(!empty($da->image)){
                      ?>
                        <img class="direct-chat-img" src="<? echo base_url() ?>assets/uploads/team/<? echo $da->image; ?>" alt="message user image" /><!-- /.direct-chat-img -->
                        <?
                    }
                    else{
                      ?>
                        <img class="direct-chat-img" src="<? echo base_url() ?>assets/admin/team/avatar.png" alt="message user image" /><!-- /.direct-chat-img -->
                        <?
                    }
                  ?>
                    <div class="direct-chat-text">
                      <? echo $data->msg ?>
                    </div><!-- /.direct-chat-text -->
                  </div><!-- /.direct-chat-msg -->
<?
}
 $i++;
}


?>




                </div><!--/.direct-chat-messages-->


                <!-- Contacts are loaded here -->
                <div class="direct-chat-contacts">
                  <ul class='contacts-list'>
                    <?php $i=1; foreach($team_data->result() as $data) {
                      $imgr=$data->image;
                      ?>
                    <li>
                      <a href='<? echo base_url() ?>admin/messages/view_team_messages/<? echo base64_encode($data->id); ?>'>
                        <? if (!empty($imgr)) {
                          ?>

                        <img class='contacts-list-img' src='<? echo base_url() ?>assets/uploads/team/<? echo $imgr; ?>'/>
                        <?
                      }
                        else{
                          ?>
                            <img class='contacts-list-img' src='<? echo base_url() ?>assets/admin/team/avatar.png'/>
                        <?
                        }
                          ?>
                        <div class='contacts-list-info'>
                          <span class='contacts-list-name'>
                           <?php echo $data->name; ?>

                          </span>
                          <!-- <span class='contacts-list-msg'>How have you been? I was...</span> -->
                        </div><!-- /.contacts-list-info -->
                      </a>
                    </li><!-- End Contact Item -->
                    <?php $i++; }
}
                    ?>

                  </ul><!-- /.contatcts-list -->
                </div><!-- /.direct-chat-pane -->
              </div><!-- /.box-body -->
              <div class="box-footer">
                <form action="<? echo base_url() ?>admin/messages/send_msg/<? echo base64_encode($id); ?>" method="post">
                  <div class="input-group">
                    <input type="text" name="msg" placeholder="Type Message ..." class="form-control"/>
                    <span class="input-group-btn">
                      <button type="submit" class="btn btn-warning btn-flat">Send</button>
                    </span>
                  </div>
                </form>
              </div><!-- /.box-footer-->
            </div><!--/.direct-chat -->
          </div><!-- /.col -->








                                </div>

                              </div>

                              </div>

                              </div>
                              </div>

                              </section>
                              </div>

                              <!-- <script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script> -->


                              <!-- <script type="text/javascript" src="<?php echo base_url() ?>assets/slider/ajaxupload.3.5.js"></script>
                              <script type="text/javascript" src="<?php echo base_url() ?>assets/slider/rs.js"></script>	  -->
