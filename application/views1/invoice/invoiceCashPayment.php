<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
	
	<title>Cash Invoice</title>
	
	<link rel='stylesheet' type='text/css' href='<?php echo base_url(); ?>assets/css/invoice_css/style.css' />
	<link rel='stylesheet' type='text/css' href='<?php echo base_url(); ?>assets/css/invoice_css/print.css' media="print" />
	<script type='text/javascript' src='<?php echo base_url(); ?>assets/js/invoice_js/jquery-1.3.2.min.js'></script>
	<script type='text/javascript' src='<?php echo base_url(); ?>assets/js/invoice_js/example.js'></script>
	
</head>

<body>

	<div id="page-wrap">

		<?php 
	$school_info = mysql_query("select * from general_settings");
	$info = mysql_fetch_object($school_info);
?>		
		<table style="width: 100%">
			<tr>
				<td width="10%" style="border: none;">
					<img src="<?php echo base_url();?>assets/images/empImage/<?php echo $this->session->userdata("logo");?>" alt="" width="100" />
				</td>
				<td style="border: none;">
					<h1 align="center" style="text-transform:uppercase;"><?php echo $info->your_school_name; ?></h1>
			        <h3 align="center" style="font-variant:small-caps;">
						<?php echo $info->address_1." ".$info->address_2." ".$info->city; ?>
			        </h3>
			        <h3 align="center" style="font-variant:small-caps;">
						<?php echo $info->state." - ".$info->pin; ?>
			        </h3>
			        <h3 align="center" style="font-variant:small-caps;">
						<?php if(strlen($info->phone_number > 0 )){echo "Phone : ".$info->phone_number.", ";} ?>
			            <?php echo "Mobile : ".$info->mobile_number; ?>
			        </h3>
				</td>
			</tr>
		</table>
		
		
		<div style="clear:both"></div>
		
		<div id="customer">
        	<div style="display:inline-block;">
<?php
	$id = $this->uri->segment(3);
	
	$rowb = $this->db->query("select * from cash_payment where receipt_no = $id")->row();
	$id_name = $rowb->id_name;
	$valid_id = $rowb->valid_id;
	if(strlen($valid_id) > 0):
		$empInfo = $this->db->query("select * from employee_info where emp_no = $valid_id")->row();
	endif;
?>
            <table>
                    <tr><td style="border:none;"><strong>To</strong></td></tr>
                    <tr>
                    	<td style="border:none;">
                        	<?php $i = $id_name; ?>
                        	<?php if(strlen($valid_id) > 0):
								echo $empInfo->first_name." ".$empInfo->mid_name." ".$empInfo->last_name;
							endif;?>
                    		<strong><?php echo $rowb->name; ?></strong>
                        </td>
                    </tr>
                    <tr>
                    	<td style="border:none;">
                        	<?php echo '<strong>Mobile No. :</strong>'.$rowb->phone_no; ?>
                        	<?php if(strlen($valid_id) > 0):
					echo $empInfo->mobile;
				endif;?>
                        </td>
                    </tr>
            </table>
			</div>
            <div style="display:inline-block; float:right">
            <table>
                <tr>
                    <td class="meta-head" colspan="2"><h3>Cash Payment</h3></td>
                </tr>
                <tr>
                    <td class="meta-head">
                    	<?php
							
								echo 'Reciept No. :';
							?>
                    </td>
                    <td><?php echo $id; ?></td>
                </tr>
                <tr>
                    <td class="meta-head">Date</td>
                    <td><?php echo $rowb->date; ?></td>
                </tr>
            </table>
            </div>
		
		</div>
		
		<table id="items">
		
		  <tr>
		       <th width="5%">No.</th>
               <th width="12%">id_name</th>
               <th width="10%">valid_id</th>
               <th width="9%">name</th>
               <th width="11%">phone_no</th>
               <th width="30%">reason</th>
               <th width="12%">amount</th>
               <th width="11%">date</th>
		  </tr>
		  <tr class="item-row">
		      <td><?php echo 1; ?></td>
		      <td><?php echo $rowb->id_name; ?></td>
		      <td><?php echo $rowb->valid_id; ?></td>
		      <td><?php echo $rowb->name; ?></td>
		      <td>
		      	<?php echo $rowb->phone_no; ?>
		      	<?php if(strlen($valid_id) > 0):
					echo $empInfo->mobile;
				endif;?>
		      </td>
		      <td><?php echo $rowb->reason; ?></td>
              <td><?php echo $rowb->amount; ?></td>
		      <td><?php echo $rowb->date; ?></td>
		  </tr>
		</table>
		
		<div id="terms">
		  <h5>Terms</h5>
		  <textarea>NET 30 Days. Finance Charge of 1.5% will be made on unpaid balances after 30 days.</textarea>
		</div>
	
	</div>
	<br/><br/>
	<div class="invoice-buttons">
    	<button class="btn btn-default margin-right" type="button" onclick="window.print();" >
        	<i class="fa fa-print padding-right-sm"></i> Print Reciept
        </button>
    </div>
</body>

</html>