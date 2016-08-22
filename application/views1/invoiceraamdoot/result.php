<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

	<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
	
	<title><?php echo $title; ?></title>

	<link rel='stylesheet' type='text/css' href='<?php echo base_url(); ?>assets/css/invoice_css/style.css' />
	<link rel='stylesheet' type='text/css' href='<?php echo base_url(); ?>assets/css/invoice_css/prin_result.css' media="print" />
	<script type='text/javascript' src='<?php echo base_url(); ?>assets/js/invoice_js/jquery-1.3.2.min.js'></script>
	<script type='text/javascript' src='<?php echo base_url(); ?>assets/js/invoice_js/example.js'></script>
	
	<style type="text/css">

	@media print
	{
			body * { visibility: hidden; }
			#printcontent * { visibility: visible; }
			#printcontent { position: absolute; top: 40px; left: 30px; }
	    }
    .nob{
    	border: none;
    }
	</style>
	
    <script>
        function convert_number(number)
        {
            if ((number < 0) || (number > 999999999))
            {
                return "Number is out of range";
            }
            var Gn = Math.floor(number / 10000000);  /* Crore */
            number -= Gn * 10000000;
            var kn = Math.floor(number / 100000);     /* lakhs */
            number -= kn * 100000;
            var Hn = Math.floor(number / 1000);      /* thousand */
            number -= Hn * 1000;
            var Dn = Math.floor(number / 100);       /* Tens (deca) */
            number = number % 100;               /* Ones */
            var tn= Math.floor(number / 10);
            var one=Math.floor(number % 10);
            var res = "";

            if (Gn>0){
                res += (convert_number(Gn) + " Crore");
            }
            if (kn>0){
                res += (((res=="") ? "" : " ") +
                    convert_number(kn) + " Lakhs");
            }
            if (Hn>0){
                res += (((res=="") ? "" : " ") +
                    convert_number(Hn) + " Thousand");
            }

            if (Dn){
                res += (((res=="") ? "" : " ") +
                    convert_number(Dn) + " hundred");
            }


            var ones = Array("", "One", "Two", "Three", "Four", "Five", "Six","Seven", "Eight", "Nine", "Ten", "Eleven", "Twelve", "Thirteen","Fourteen", "Fifteen", "Sixteen", "Seventeen", "Eightteen","Nineteen");
            var tens = Array("", "", "Twenty", "Thirty", "Fourty", "Fifty", "Sixty","Seventy", "Eigthy", "Ninety");

            if (tn>0 || one>0)
            {
                if (!(res==""))
                {
                    res += " and ";
                }
                if (tn < 2)
                {
                    res += ones[tn * 10 + one];
                }
                else
                {

                    res += tens[tn];
                    if (one>0)
                    {
                        res += ("-" + ones[one]);
                    }
                }
            }

            if (res=="")
            {
                res = "zero";
            }
            return res;
        }

    </script>
</head>

<body>
	<div id="printcontent" align="center">
	<br/><br/><br/>
	<div id="page-wrap" style="width:800px; border: 1px solid black; outline: 1px solid black; solid #333;">
<?php
	$school_info = mysql_query("select * from general_settings");
	$info = mysql_fetch_object($school_info);
?>		
		<table style="width: 95%">
			<tr>
				<td width="10%" style="border: none;" rowspan="2">
					<img src="<?php echo base_url();?>assets/images/empImage/logo.png" alt="" width="140" />
				</td>
				<td style="border: none;">
					<h1 style=margin-left:80px; ><b><?php echo $info->your_school_name; ?></b></h1>
			        <h3  style=margin-left:135px;>
						<?php echo $info->address_1." ".$info->address_2." ".$info->city; ?>
			        </h3>
			        <h3  style="font-variant:small-caps; margin-left:170px;">
						<?php echo $info->state." - ".$info->pin; ?>
			        </h3>
			        <h3  style="font-variant:small-caps; margin-left:105px;">
						<?php if(strlen($info->phone_number > 0 )){echo "Phone : ".$info->phone_number.", ";} ?>
			            <?php echo "Mobile : ".$info->mobile_number; ?>
			        </h3>
				</td>
			</tr>
			<tr>
				<td style="border: none;">
					
						<h2  style="border: 2px solid #000; padding: 5px; width: 250px; margin-left:125px;">
							&nbsp;&nbsp;&nbsp;&nbsp;MARK SHEET (2015-16) 
						</h2>
					
				</td>
			</tr>
		</table>
        <hr/>
		<div style="clear:both"></div>
		
		<div id="customer">
        	<div style="display:inline-block; float:left; margin-left:5px;">
            <table> 
                    <tr>
                    	<td style="border:none;  line-height: 20px;">
                    		Student Name : <strong><?php echo $rowc->first_name." ".$rowc->last_name; ?></strong>
                        </td>
                    </tr>
                    <tr>
                    	<td style="border:none; line-height: 20px;">
                    		Mother's Name : <strong><?php echo $pInfo->mother_full_name; ?></strong>
                        </td>
                    </tr>
                    <tr>
                    	<td style="border:none; line-height: 20px;">
                        	<?php echo 'Class : <strong>'.$rowc->class_id.' - '.$rowc->section.'</strong>';	?>
                        </td>
                    </tr>
                    
            </table>
			</div>
			
			<div style="display:inline-block; float:right; margin-right:5px;">
            <table>
                <tr>
                    	<td style="border:none; line-height: 20px;">
                    		<img src="<?php echo base_url();?>assets/images/stuImage/<?php echo $rowc->photo; ?>"  alt="" width="90" />
                        </td>
                    </tr>
                   
            </table>
            </div>
			
			
			
			
            <div style="display:inline-block; float:center; margin-right:5px;">
            <table>
                <tr>
                    	<td style="border:none; line-height: 20px;">
                    		Father's Name : <strong><?php echo $pInfo->father_full_name; ?></strong>
                        </td>
                    </tr>
                    <tr>
                    	<td style="border:none; line-height: 20px;">
                    		Date of Birth : <strong><?php echo date("d-m-Y",strtotime($rowc->date_ob)); ?></strong>
                        </td>
                    </tr>
                <tr>
                    	<td style="border:none; line-height: 12px;">
                        	<?php echo 'Student Id : <strong>'.$rowc->student_id.'</strong>';	?>
                        </td>
                    </tr>
            </table>
            </div>
		
		</div>
		<h3>
		<table id="items" align="center"  style="width:100%; margin-top:0px; alignment-adjust:central;">
		  	<tr>
		  		<th style="width:05%;">Sr. No.</th>
		  		<th>Subject</th>
		  		
		  		<th  style="width:20%;">
		  		<table ><tr><td style="border-left:none;border-right:none;" colspan="2">TERM - 1</td></tr>
		  		<tr><td style="border-left:none;border-bottom:none; width:35%;">FA-1</td>
		  			<td style="border-right:none;border-bottom:none; width:35%;">FA-2</td>
		  			<td style="border-right:none;border-bottom:none; width:35%;">SA-1</td>
		  			<td style="border-right:none;border-bottom:none; width:35%;">Total</td>
		  			
		  		</tr></table>
		  	</th>
		  		<th  style="width:20%;">
		  		<table ><tr><td style="border-left:none;border-right:none;" colspan="2">TERM - 2</td></tr>
		  		<tr><td style="border-left:none;border-bottom:none; width:35%;">FA-3</td>
		  			<td style="border-right:none;border-bottom:none; width:35%;">FA-4</td>
		  			<td style="border-right:none;border-bottom:none; width:35%;">SA-2</td>
		  			<td style="border-right:none;border-bottom:none; width:35%;">Total</td>
		  			
		  		</tr></table>
		  	</th>
		  		
		  		<th style="width:40%;"><table >
		  									<tr>
		  										<td style="border-left:none;border-right:none;" colspan="2">TERM - 1 + TERM - 2 </td>
		  									</tr>
		  									<tr>
		  										<td style="border-left:none;border-bottom:none; width:35%;">FA (TOTAL)</td>
		  										<td style="border-left:none;border-bottom:none; width:35%;">SA (TOTAL)</td>
		  										<td style="border-left:none;border-bottom:none; width:35%;">MM (TOTAL)</td>
		  										<td style="border-left:none;border-bottom:none; width:35%;">G. (TOTAL)</td>
		  										<td style="border-left:none;border-bottom:none; width:35%;">G. (TOTAL)</td>
		  									</tr>
		  								</table>
		  		</th>
		  		
		  	</tr>
		  	<?php 
		  	$per = 0;
		  		$i = 1;
		  		$j = 1;
		  		$gross = 0;
		  		$gross1 = 0;
		  		$gross2 = 0;
		  		$rowtot=0;
		  		$totoutofrow=0;
		  		$tot1 = 0;$tot2 = 0;$tot3 = 0;$tot4 = 0;$tot5 = 0;$tot6 = 0;$tot7 = 0;$tot8 = 0;$tot9 = 0;
		  		$total = 0;
		  		$this->db->where("class_id",$rowc->class_id);
		  		$this->db->where("section",$rowc->section);
		  		$var  = $this->db->get("subject")->result();
		  		foreach($var as $row):
		  			echo '<tr>';
		  			echo "<td style='text-align: center;'>".$i."</td>";
		  			echo "<td>".$row->subject."</td>";?>
		  			<td>
		  			<?php 
		  			$examName = $this->db->get("exam_name")->result();
		  			foreach($examName as $ex):
				  		
				  		$this->db->where("stu_id",$rowc->student_id);
				  		$this->db->where("subject",$row->subject);
				  		$this->db->where("exam_name",$ex->exam_name);
				  		$var1  = $this->db->get("exam_info");
				  		$num = $var1->num_rows();
					  		if($num > 0) {
					  			$result = $var1->row();
					  			if(is_numeric($result->marks)){
					  				if($j == 1){
					  					$tot1 += $result->marks;
					  					$gross1 += $result->out_of;
					  					$rowtot +=$result->marks;
					  					$totoutofrow += $result->out_of;
					  				}
					  				if($j == 2){
					  					$tot2 += $result->marks;
					  					$gross2 += $result->out_of;
					  					$rowtot +=$result->marks;
					  					$totoutofrow += $result->out_of;
					  				}
					  				if($j == 3){
					  					$tot3 += $result->marks;
					  					$rowtot +=$result->marks;
					  					$totoutofrow += $result->out_of;
					  				}
					  				if($j == 4){
					  					$tot4 += $result->marks;
					  					$gross += $result->out_of;
					  					$rowtot +=$result->marks;
					  					$totoutofrow += $result->out_of;
					  				}
					  				if($j == 5){
					  					$tot5 += $result->marks;
					  					$rowtot +=$result->marks;
					  					$totoutofrow += $result->out_of;
					  				}
					  				if($j == 6){
					  					$tot6 += $result->marks;
					  					$rowtot +=$result->marks;
					  					$totoutofrow += $result->out_of;
					  				}
					  				if($j == 7){
					  					$tot7 += $result->marks;
					  					$rowtot +=$result->marks;
					  					$totoutofrow += $result->out_of;
					  				}
					  				if($j == 8){
					  					$tot8 += $result->marks;
					  					$rowtot +=$result->marks;
					  					$totoutofrow += $result->out_of;
					  					
					  				}
					  				$val = $result->marks;
					  			}else{
					  				$val = 0;
					  			}
					  			if ($result->Attendance=='P')
					  			{
					  				if($result->marks > 9)
					  				{
					  					echo $result->marks;
					  				}
						  			else
						  			{
						  				echo $result->marks;
						  			
						  			}
					  			}
					  			else
					  			{
					  				echo "AB";
					  			}
					  			
					  			$total = $total + $result->marks;
					  		}
					  		
					  		else{ 
					  			echo "00";
						  			}
					  		$j++;
					endforeach;?>
					</td>
					<?php 
				  		$tot9 += $total;
				  		$total = 0;
				  		?>
				  <?php 	$j = 1;	$rowtot=0;
				  		$totoutofrow=0;			  		
		  			echo '</tr>';
		  		$i++; 
		  		
		  		endforeach; 
		  	?>
		  
		  
		  	</table>
		  	</h3>
		 <h3> 	<table style="width:100%;">
		  	<tr>
		  		<td style="border-left:none; width:30%;">
		  			<table class="nob">
			  			<tr>
			  				<td class="nob"><br /><br /><br />Signature Class Teacher</td>
			  			</tr>
			  			<tr>
			  				
			  			</tr>
			  			<tr>
			  				<td class="nob" > Date :</td>
			  				<td class="nob" ><br /><br /><br /> </td>
			  			</tr>
		  			</table>
		  		</td>
		  		<td style = "width:35%;">
		  		<table>
			  			
			  			<tr>
			  				<td class="nob">Result :</td>
			  				<td class="nob"><?php $perv=$tot1+$tot2;
			  						$gros=$gross2+$gross1;
			  						if($perv != 0 && $gros != 0){
			  							$per = round(($perv*100)/$gros, 2);
			  							}else{ echo 0; }
			  						?><span style="text-decoration: underline;">
			  						<?php if($per > 33){
			  						echo "PASS";
			  						}else{
			  						echo "FAIL";} ?>
			  					</span></td>
			  			</tr> 
			  			<tr>
			  				<td class="nob">Percentage:</td>
			  				<td class="nob"><span style="text-decoration: underline;">
			  						<b><?php $perv=$tot1+$tot2;
			  						$gros=$gross2+$gross1;
			  						if($perv != 0 && $gros != 0){
			  							echo $per = round(($perv*100)/$gros, 2);
			  							}else{ echo 0; }
			  						?> %&nbsp;
			  							
			  						</b>
			  					</span></td>
			  			</tr> 
			  			<tr>
			  				<td class="nob"> Division :</td>
			  				<td class="nob"><span style="text-decoration: underline;"> <?php if($per >59){echo "First";}else{ if(($per >45) && ($per <60)){ echo "SECOND ";}else{if(($per < 45) && ($per > 33)){echo "THIRD";}else{echo "FAIL";}}}?></span></td>
			  			</tr>
			  			<tr>
			  				<td class="nob">Rank:</td>
			  				<td class="nob">_______</td>
			  			</tr>
		  			</table>
		  			
		  		</td>
		  		<td style="border-right:none; width:35%;">
		  			<table>
			  			<tr>
			  				
			  			</tr>
			  			
			  			<tr>
			  				
			  			</tr> 
			  			<tr>
			  			<td class="nob"></td>
			  				<td class="nob "></br></br></br></br>Signature Principal</td>
			  				
			  			</tr>
		  			</table>
		  		</td>
		  	</tr>
		</table>
		</h3>
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