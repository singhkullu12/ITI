<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
	
	<title>Student Profile</title>
	
	<link rel='stylesheet' type='text/css' href='<?php echo base_url(); ?>assets/css/invoice_css/style.css' />
	<link rel='stylesheet' type='text/css' href='<?php echo base_url(); ?>assets/css/invoice_css/print.css' media="print" />
	<script type='text/javascript' src='<?php echo base_url(); ?>assets/js/invoice_js/jquery-1.3.2.min.js'></script>
	<script type='text/javascript' src='<?php echo base_url(); ?>assets/js/invoice_js/example.js'></script>

	<style type="text/css">
		table tr th{
			text-align: left;
		}
	</style>
	
</head>

<body>

	<div id="page-wrap" style="border: 1px solid #FFF; width:1000px;">
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
		
		<?php
 
	$id = $this->uri->segment(3);
	$this->db->where("student_id",$id);
	$detail = $this->db->get("student_info")->row();
	
	$this->db->where("student_id",$id);
	$g_detail = $this->db->get("guardian_info")->row();
?>
		
		<table id="items">
			<tr style="border: none;">
				<td style="border: none;">
					<div style="width: 140px; height: 150px; border: 1px solid #ccc;">
						<?php if(strlen($detail->photo > 0)):?>
							<img alt="<?php echo $detail->first_name;?>" height="148" width="138" src="<?php echo base_url()?>assets/images/stuImage/<?php echo $detail->photo;?>" />
						<?php else:?>
							<?php if($detail->gender == 'Male'):?>
								<img alt="<?php echo $detail->first_name;?>" height="148" width="138" src="<?php echo base_url()?>assets/images/stuImage/stuMale.png" />	
							<?php endif;?>
							<?php if($detail->gender == 'Female'):?>
								<img alt="<?php echo $detail->first_name;?>" height="148" width="138" src="<?php echo base_url()?>assets/images/stuImage/stuFemale.png" />	
							<?php endif;?>
						<?php endif;?>
					</div>
				</td>
				<td style="border: none;">
					<div style="width: 140px; height: 150px; border: 1px solid #ccc;">
						<?php if(strlen($g_detail->f_photo > 0)):?>
							<img alt="<?php echo $g_detail->father_full_name;?>" height="148" width="138" src="<?php echo base_url()?>assets/images/stuImage/<?php echo $g_detail->f_photo;?>" />
						<?php else:?>
								<img alt="<?php echo $g_detail->father_full_name;?>" height="148" width="138" src="<?php echo base_url()?>assets/images/empImage/empMale.png" />	
						<?php endif;?>
					</div>
				</td>
				<td colspan="2" style="border: none;">
					<div style="width: 140px; height: 150px; border: 1px solid #ccc;">
						<?php if(strlen($g_detail->m_photo > 0)):?>
							<img alt="<?php echo $g_detail->mother_full_name;?>" height="148" width="138" src="<?php echo base_url()?>assets/images/stuImage/<?php echo $g_detail->m_photo;?>" />
						<?php else:?>
								<img alt="<?php echo $g_detail->mother_full_name;?>" height="148" width="138" src="<?php echo base_url()?>assets/images/empImage/empFemale.png" />	
						<?php endif;?>
					</div>
				</td>
			</tr>
			<tr>
				<th>Student ID</th>
				<td><?php echo $detail->student_id; ?></td>
				<th>Scholer No</th>
				<td><?php echo $detail->scholer_no; ?></td>
			</tr>
			<tr>
				<th>Board Register No</th>
				<td><?php $detail->board_register_no;?></td>
				<th>Admission Date</th>
				<td><?php echo $detail->adm_date;?></td>
			</tr>
			<tr>
				<th>Student Name</th>
				<td><?php echo $detail->first_name." ".$detail->midd_name." ".$detail->last_name;?></td>
				<th>Date of Birth</th>
				<td><?php echo $detail->date_ob;?></td>
			</tr>
			<tr>
				<th>Class Section</th>
				<td><?php echo $detail->class_id." - ".$detail->section;?></td>
				<th>Gender</th>
				<td><?php echo $detail->gender;?></td>
			</tr>
			<tr>
				<th>Blood Group</th>
				<td><?php echo $detail->bloodgp;?></td>
				<th>Birth Place</th>
				<td><?php echo $detail->birth_place;?></td>
			</tr>
			<tr>
				<th>Nationality</th>
				<td><?php echo $detail->nationality;?></td>
				<th>Mother Tongue</th>
				<td><?php echo $detail->mother_tongue;?></td>
			</tr>
			<tr>
				<th>Category</th>
				<td><?php $detail->category;?></td>
				<th>Religion</th>
				<td><?php echo $detail->religion;?></td>
			</tr>
			<tr>
				<th>Address 1</th>
				<td><?php echo $detail->address1;?></td>
				<th>Address 2</th>
				<td><?php echo $detail->address2;?></td>
			</tr>
			<tr>
				<th>City</th>
				<td><?php echo $detail->city;?></td>
				<th>State</th>
				<td><?php echo $detail->state;?></td>
			</tr>
			<tr>
				<th>Country</th>
				<td><?php echo $detail->country." - ".$detail->pin_code;?></td>
				<th>Phone</th>
				<td></td>
			</tr>
			<tr>
				<th>Mobile</th>
				<td><?php echo $detail->mobile; ?></td>
				<th>Email</th>
				<td><?php echo $detail->email;?></td>
			</tr>
			<tr>
				<th>Username</th>
				<td><?php echo $detail->username; ?></td>
				<th>Password</th>
				<td><?php $detail->password;?></td>
			</tr>
			<tr>
				<th colspan="4" style="text-align: center;">-------- PARANTS INFORMATION --------</th>
			</tr>
			<tr>
				<th>Father Name</th>
				<td><?php echo $g_detail->father_full_name; ?></td>
				<th>Mother Name</th>
				<td><?php echo $g_detail->mother_full_name;?></td>
			</tr>
			<tr>
				<th>Caretaker Name</th>
				<td><?php echo $g_detail->caretaker_name; ?></td>
				<th>Caretaker Relation</th>
				<td><?php echo $g_detail->caretaker_relation;?></td>
			</tr>
			<tr>
				<th>Father Education</th>
				<td><?php echo $g_detail->father_education; ?></td>
				<th>Mother Education</th>
				<td><?php echo $g_detail->mother_education;?></td>
			</tr>
			<tr>
				<th>Father Occupation</th>
				<td><?php echo $g_detail->father_occupation;?></td>
				<th>Mother Occupation</th>
				<td><?php echo $g_detail->mother_occupation;?></td>
			</tr>
			<tr>
				<th>Family Annual Income</th>
				<td><?php echo $g_detail->family_annual_income;?></td>
				<th>Address</th>
				<td><?php echo $g_detail->address; ?></td>
			</tr>
			<tr>
				<th>City</th>
				<td><?php echo $g_detail->city; ?></td>
				<th>State</th>
				<td><?php echo $g_detail->state; ?></td>
			</tr>
			<tr>
				<th>Country</th>
				<td><?php echo $g_detail->country." - ".$g_detail->pin; ?></td>
				<th>Phone</th>
				<td><?php echo $g_detail->phone; ?></td>
			</tr>
			<tr>
				<th>Father Mobile</th>
				<td><?php echo $g_detail->f_mobile;?></td>
				<th>Mother Mobile</th>
				<td><?php echo $g_detail->m_mobile; ?></td>
			</tr>
			<tr>
				<th>Father Email</th>
				<td><?php echo $g_detail->f_email; ?></td>
				<th>Mother Email</th>
				<td><?php echo $g_detail->m_email?></td>
			</tr>
		</table>
		
		
	<div class="invoice-buttons">
    	<button class="btn btn-default margin-right" type="button" onclick="window.print();" >
        	<i class="fa fa-print padding-right-sm"></i> Print Profile
        </button>
    </div>
	</div>
	
</body>

</html>