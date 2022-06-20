<!DOCTYPE html>
<html>
<html lang="en">
<input type="hidden" value="<?php if (!empty($order1_data)) {
    echo $order1_data->total_amount;
}?>" id="tot_amnt">
<head>
 <meta charset="utf-8">
 <meta name="viewport" content="width=device-width, initial-scale=1">
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
<!-- Css file include -->
<link rel="stylesheet" type="text/css" href="css/style.css">
	<title>Supremetech Bill</title>
</head>
<body style="padding-top:75px;">
<div class="container main_container">
	<div class="row">
		<div class="col-sm-6 oswal_logo">
		<img src="https://www.supremetechnocom.com/application/views/website/themes/supreme/assets/img/logo.png" class="img-fluid" style="width:150px;">
		</div>
		<div class="col-sm-6 content_part">Tax Invoice/Bill of Supply/Cash Memo
			<p>(Original for Recipient)</p>
		</div>
	</div><br>

<div class="container">
	<div class="row">
		<div class="col-sm-6"><span class="font-weight-bold ">Sold By</span><br>
<span class="seller_details">Supremetech <br>

Rajasthan<br>India
<br><br>
		www.supremetech.com<br></span>
		</div>

		<div class="col-sm-6 billing_content"><span class="font-weight-bold ">Billing Address:</span><br>
      <!-- code here -->
<?php

            $this->db->select('*');
$this->db->from('tbl_users');
$this->db->where('id', $order1_data->user_id);
$usr_dat= $this->db->get()->row();

if (!empty($usr_dat)) {
    $user_name= $usr_dat->name;
    $user_email= $usr_dat->email;
    $user_contact= $usr_dat->phone;
} else {
    $user_name="";
    $user_email="";
    $user_contact="";
}
?>


User: <?=$user_name;?>
<br>Email: <?=$user_email;?>
<br>Contact: <?=$user_contact;?><br>


      <?php
  if (!empty($order1_data)) {
      //             $this->db->select('*');
      // $this->db->from('tbl_user_address');
      // $this->db->where('id',$order1_data->address_id);
      // $address= $this->db->get()->row();
      //  $addres= $address->address;
      //  // $location_addres= $address->location_address;
      //  // $doorflat= $address->doorflat;
      //  // $landmark= $address->landmark;
      // if(!empty($addres)){
      //     echo $addres;
      //   }else{
      //     echo "no address";
      //   }
      //   $state=$address->state;
      //   $city=$address->city;
      //   $zipcode=$address->zipcode;
      //
      //
      // }

      $address=$order1_data->street_address;
      $this->db->select('*');
      $this->db->from('all_states');
      $this->db->where('id', $order1_data->state);
      $state_data = $this->db->get()->row();
      if(!empty($state_data)){
        $state= $state_data->state_name;
      }else{
        $state="";
      }

      $city=$order1_data->city;
      $zipcode=$order1_data->pincode;
  }

      ?>

		</div>
	</div>

<br>
<div class="row">
	<div class="col-sm-6"></div>
<div class="col-sm-6 shipping_content"><span class="font-weight-bold ">Shipping Address:</span>	<br>

Address: <?php
// if(empty($location_addres)){
//   echo $addres;
// }else{
//   echo $doorflat.", ".$landmark.", ".$location_addres;
// }

if (!empty($address)) {
    echo $address;
} else {
    echo "no address";
}
?> <br>

Place of supply: <?php echo $city;?><br>
Place of delivery: <?php echo $city.", ".$state;?><br>
Zipcode: <?php echo $zipcode;?><br>
</div>
</div>
<div class="row">
	<div class="col-sm-6">Order No: &nbsp; <?php if (!empty($order1_data)) {
    echo $order1_data->id;
}?><br>
<p> Order Date:  &nbsp;
   <?php if (!empty($order1_data)) {
    $source = $order1_data->date;
    $date = new DateTime($source);
    echo $date->format('F j, Y, g:i a');
}?>
	</div><br> <br>




</div>
</div>





<div class="container">

  <table class="table table-black">
    <thead class="product_table">

      <tr>
        <th>SNo.</th>
        <th>Product</th>
        <!-- <th>HSN Code</th> -->
        <!-- <th>Unit Name</th> -->
        <th>Unit Price</th>
        <th>Qty</th>

        <th>Total Amount</th>
      </tr>
    </thead>
    <tbody>
  <?php
  $total_weight = 0;
  $total_gst_percentt = 0;
  $total_gst_pricee = 0;
if (!empty($order2_data)) {
    $i=1;
    foreach ($order2_data->result() as $data) { ?>
      <tr class="product_table2">
       <td><?php echo $i;?></td>
        <td><?php
        $this->db->select('*');
$this->db->from('tbl_products');
$this->db->where('id', $data->product_id);
$product_data= $this->db->get()->row();
if (!empty($product_data)) {
    // $hsn_code= $product_data->hsn_code;
    echo $product_name= $product_data->productname;
} else {
    $product_name= "";
}

        ?></td>


        <td>
          <?php
          if (!empty($product_data)) {
              // $hsn_code= $product_data->hsn_code;
              echo "₹ ".$product_price= $product_data->sellingprice;
          } else {
              $product_price= "";
          }

?>

        </td>
        <td ><?php echo $data->quantity;?></td>
        <!-- <td>9%</td>
        <td>CGST</td>
        <td>200</td> -->
        <?php
        // $this->db->select('*');
        //  $this->db->from('tbl_user_address');
        //  $this->db->where('id',$order1_data->address_id);
        //  $deliver_state= $this->db->get()->row();


        ?>


        <td><?php echo "₹ ".$data->total_amount;?></td>
      </tr>
  <?php $i++;}
}?>
  <tr>
    <th colspan="4">Total Weight</th>
    <th class="product_table"><?php $total_weight = 0; foreach($order2_data->result() as $order_weight){
      $this->db->select('*');
      $this->db->from('tbl_products');
      $this->db->where('id', $order_weight->product_id);
      $pro_da = $this->db->get()->row();
      if(!empty($pro_da)){
      $total_weight = ($order_weight->quantity*$pro_da->weight) + $total_weight;
    }else{
      $total_weight = $total_weight;
    }
    }
    if($total_weight > 1000){
      echo $total_weight/1000;
      echo " kg";
    }else{
      echo $total_weight." gm";
    }
    ?></th>

  </tr>
      <tr>
        <th>Total</th>
        <th class="product_table" ><?php if (!empty($order1_data)) {
    echo "";
}?></th>
        <th class="product_table" colspan="2"><?php if (!empty($order1_data)) {
    echo "";
}?></th>

        <th class="product_table"><?php if (!empty($order1_data)) {
    echo "₹ ".$order1_data->total_amount;
}?></th>
      </tr>

      <tr>


      </tr>


      <?php if (!empty($order1_data->promocode) && $order1_data->promocode != "Apply coupon") {
    $this->db->select('*');
    $this->db->from('tbl_promocode');
    $this->db->where('id', $order1_data->promocode);
    $promo_da= $this->db->get()->row();

    if (!empty($promo_da)) {
        $peomocode_id= $promo_da->id;
        $promocode_name= $promo_da->promocode;
    } else {
        $peomocode_id="";
        $promocode_name="";
    } ?>
        <tr>
          <th colspan="9">Promocode:<?=$promocode_name; ?> </th>
          <th class="product_table"><?php if (!empty($order1_data)) {
        echo " ";
    } ?></th>
          <th class="product_table"><?php if (!empty($order1_data->promocode)) {
        $this->db->select('*');
        $this->db->from('tbl_promocode');
        $this->db->where('id', $order1_data->promocode);
        $promo_da= $this->db->get()->row();
        if (!empty($promo_da)) {
            $percent= $promo_da->percent;
            $db_promocode_maximum_gift_amount= $promo_da->maximum_gift_amount;
            // $f_amount= $order1_data->total_amount + $order1_data->order_shipping_amount;
            $f_amount= $order1_data->total_amount ;

            $promocodes_discount= $f_amount * $percent/100;
            $promo_discount= round($promocodes_discount);

            //check maximum gift amount
            if ($promo_discount > $db_promocode_maximum_gift_amount) {
                $promo_discount = $db_promocode_maximum_gift_amount;
            }
        } else {
            $promo_discount= 0;
        }
        "- ₹ ".$promo_discount;
    } else {
        echo "-₹ 0";
    } ?>

<!-- from table order1  start-->

<?php if (!empty($order1_data)) {
        echo "- ₹ ".$order1_data->promo_deduction_amount;
    } else {
        echo "-₹ 0";
    } ?>

<!-- from table order1  end-->

          </th>

        </tr>
      <?php
}?>


      <tr>
        <th colspan="4">SubTotal</th>
        <th class="product_table"><?php if (!empty($order1_data)) {
        echo "₹ ".$order1_data->total_amount;
    }?></th>

      </tr>



    </tbody>
    </table>

      <h6 class="amount_content" >Amount in Words:<br>
      <span id="checks123" style="text-transform: capitalize;font-style: revert;"></span></h6><br>




      <h4 class="oswal_head"><br><br>

      Authorized Signatory </h4>

      </tr>

</div>


<h5 class="warning" style="margin-left: 15px;">Whether tax is payable under reverse charge-No</h5>


</div>
</body>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>
 //alert('Changed!')

       $('#gst_percentage').keyup(function() {
       // alert("Key up detected");

       var total_price = $("#mrp").val();
       //var gst_percentage = $("#gst_percentage").val();$(this).val
       var gst_percentage = $(this).val();
       var gst_price = (total_price*gst_percentage)/100;
       var total_gst_price = parseInt(total_price) + parseInt(gst_price);
       //alert(total_gst_price);
       $('#gst_percentage_price').val(gst_price);
       $('#selling_price').val(total_gst_price);

     });

 </script>

<script>

window.onload = function() {

  var unit_mrp = $(".unit_mrp").text();
  var unit_qty = $(".qty").text();
  //var gst_percentage = $("#gst_percentage").val();$(this).val

  var total_unit_mrp = parseInt(unit_mrp) * parseInt(unit_qty);
  //alert(total_gst_price);
  $('.net_unit_mrp').text(total_unit_mrp);

  var total_amount= document.getElementById("tot_amnt").value;
  //alert(total_amount);
  inWords(total_amount);
  window.print();
};



var a = ['','one ','two ','three ','four ', 'five ','six ','seven ','eight ','nine ','ten ','eleven ','twelve ','thirteen ','fourteen ','fifteen ','sixteen ','seventeen ','eighteen ','nineteen '];
var b = ['', '', 'twenty','thirty','forty','fifty', 'sixty','seventy','eighty','ninety'];

function inWords (num) {
    if ((num = num.toString()).length > 9) return 'overflow';
    n = ('000000000' + num).substr(-9).match(/^(\d{2})(\d{2})(\d{2})(\d{1})(\d{2})$/);
    if (!n) return; var str = '';
    str += (n[1] != 0) ? (a[Number(n[1])] || b[n[1][0]] + ' ' + a[n[1][1]]) + 'crore ' : '';
    str += (n[2] != 0) ? (a[Number(n[2])] || b[n[2][0]] + ' ' + a[n[2][1]]) + 'lakh ' : '';
    str += (n[3] != 0) ? (a[Number(n[3])] || b[n[3][0]] + ' ' + a[n[3][1]]) + 'thousand ' : '';
    str += (n[4] != 0) ? (a[Number(n[4])] || b[n[4][0]] + ' ' + a[n[4][1]]) + 'hundred ' : '';
    str += (n[5] != 0) ? ((str != '') ? 'and ' : '') + (a[Number(n[5])] || b[n[5][0]] + ' ' + a[n[5][1]]) + 'only ' : '';
    //return str;
    // alert(str);
    $("#checks123").text(str);

}
</script>

</html>
