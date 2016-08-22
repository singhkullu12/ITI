<?php
class feeControllers extends CI_Controller{
	

	
	
	function checkID(){
		$studID=$this->input->post("teacherid");
		$myString=$this->input->post("fsd");
		if(strlen($myString) > 0){
			$myArray = explode(',', $myString);
			$fsd = $myArray[0];
			$month = $myArray[1];
			
			$this->load->model("feeModel");
			$var=$this->feeModel->getStudData($studID);
			$far=$this->feeModel->getFname($studID);
			$far = $far->row();
			
			$data['month'] = $month;
			$data['fsd'] = $fsd;
			$data['var'] = $var;
			$data['far'] = $far;
			$this->load->view("ajax/feeDetail",$data);
		}
		else{
			?>
				<div class="alert alert-block alert-danger fade in">
					<button data-dismiss="alert" class="close" type="button">
						&times;
					</button>
					<p>
						Please select Finance Start Date for further fee collect proccess.... :)
					</p>
				</div>
			<?php
		}
	}
	
	function getFsd(){
		
		$studid=$this->input->post("teacherid");
		$this->db->where("student_id",$studid);
		$check = $this->db->get("feedue");
		if($check->num_rows() > 0)
		{
			$v=$check->row();
			if($v->remain !=0.00)
			{
				echo " Your Fee is Due from previous Months Please Pay first it and Try Again!";
			}
			else{
				$this->db->select("finance_start_date as fsd");
				$fsd1 = $this->db->get("general_settings")->row()->fsd;
				$count = 0;
				$studID = $this->input->post("teacherid");
				$detail = $this->db->query("SELECT SUM(diposit_month) as month,finance_start_date FROM `fee_deposit` WHERE student_id='$studID' GROUP BY finance_start_date");
				if($detail->num_rows() > 0){
					?>
								<div class="form-group">
				                      <label for="inputStandard" class="col-lg-4 control-label">
				                      		Select FSD <span style="color:#F00">*</span>
				                      </label>
				                      <div class="col-lg-7">
				                      		<select id="fsd12" class="form-control">
				                      			<option value="">-select FSD-</option>
                      			<?php foreach($detail->result() as $row):?>
	                      			<?php if($row->month<12)
	                      			{?><option value="<?php echo $row->finance_start_date.",$row->month"; ?>">
	                      			<?php echo date("d-M-y", strtotime($row->finance_start_date)); 
	                      			$count++;
	                      			}else{ if($row->month==12){}?>
	                      		<?php }  ?>
	                      			
	                      		<?php  ?>
                      			<?php endforeach;?>
                      			<?php if($count == 0): ?>
                      					<option value="<?php echo $fsd1.",0"; ?>">
	                      					<?php echo date("d-M-y", strtotime($fsd1));?>
	                      				</option>
	                      		<?php endif; ?>
				                      		</select>
				                      </div>
				                      <script>
				                      $("#fsd12").change(function(){
				      					var teacherid = $("#studid").val();
				      					var fsd = $("#fsd12").val();
				      					//alert(teacherid+" -> "+fsd);
				      					//alert(teacherid)checkID,validId;
					      					if(fsd != ""){
					      						$('#studid').prop('disabled',true);
						      					$.post("<?php echo site_url("index.php/feeControllers/checkID") ?>",{teacherid : teacherid, fsd : fsd}, function(data){
						      						$("#validId").html(data);
						      						});
						                      }
						                      else{
						                    	  $('#studid').prop('disabled',false);
						                    	  $.post("<?php echo site_url("index.php/feeControllers/checkID") ?>",{teacherid : teacherid, fsd : fsd}, function(data){
							      						$("#validId").html(data);
							      						});
						                      }
				    					});
				                      </script>
				                </div>
							<?php
						}
						else{
							$this->load->model("feeModel");
							$var=$this->feeModel->getStudData($studID);
								if($var->num_rows()>0):
									$this->db->select("finance_start_date as fsd");
									$fsd = $this->db->get("general_settings")->row()->fsd;
									?>
										<input type="hidden" value="<?php echo $fsd.",0"; ?>" id="fsd12" />
										<button class="btn btn-info btn-squared btn-lg" id="fee">
				                        	Proceed for Fee <i class="fa fa-arrow-circle-right"></i>
				                        </button>
				                        <script>
					                      $("#fee").click(function(){
					                     
					      					var teacherid = $("#studid").val();
					      					var fsd = $("#fsd12").val();
					      					//alert(teacherid+" -> "+fsd);
					      					//alert(teacherid)checkID,validId;
					      					$.post("<?php echo site_url("index.php/feeControllers/checkID") ?>",{teacherid : teacherid, fsd : fsd}, function(data){
					      						$("#validId").html(data);
					      						});
					      					});
				                      </script>
									<?php
								else:
								?>
									<div class="alert alert-block alert-danger fade in">
										<button data-dismiss="alert" class="close" type="button">
											&times;
										</button>
										<h4 class="alert-heading"><i class="fa fa-times"></i> Error!</h4>
										<p>
											This student id <b><?php echo $studID;?></b> is not avaliable in database try another.....
										</p>
									</div>
								<?php
								endif;
						}
				
				
			}
		}else{
		$this->db->select("finance_start_date as fsd");
		$fsd1 = $this->db->get("general_settings")->row()->fsd;
		
		$count = 0;
		
		$studID = $this->input->post("teacherid");
		$detail = $this->db->query("SELECT SUM(diposit_month) as month,finance_start_date FROM `fee_deposit` WHERE student_id='$studID' GROUP BY finance_start_date");
		if($detail->num_rows() > 0){
			?>
				<div class="form-group">
                      <label for="inputStandard" class="col-lg-4 control-label">
                      		Select FSD <span style="color:#F00">*</span>
                      </label>
                      <div class="col-lg-7">
                      		<select id="fsd12" class="form-control">
                      			<option value="">-select FSD-</option>
                      			<?php foreach($detail->result() as $row):?>
	                      			<?php if($row->month<12)
	                      			{?><option value="<?php echo $row->finance_start_date.",$row->month"; ?>">
	                      			<?php echo date("d-M-y", strtotime($row->finance_start_date)); 
	                      			$count++;
	                      			}else{ if($row->month==12){}?>
	                      		<?php }  ?>
	                      			
	                      		<?php  ?>
                      			<?php endforeach;?>
                      			<?php if($count == 0): ?>
                      					<option value="<?php echo $fsd1.",0"; ?>">
	                      					<?php echo date("d-M-y", strtotime($fsd1));?>
	                      				</option>
	                      		<?php endif; ?>
                      		</select>
                      </div>
                      <script>
                      $("#fsd12").change(function(){
      					var teacherid = $("#studid").val();
      					var fsd = $("#fsd12").val();
      					//alert(teacherid+" -> "+fsd);
      					//alert(teacherid)checkID,validId;
	      					if(fsd != ""){
	      						$('#studid').prop('disabled',true);
		      					$.post("<?php echo site_url("index.php/feeControllers/checkID") ?>",{teacherid : teacherid, fsd : fsd}, function(data){
		      						$("#validId").html(data);
		      						});
		                      }
		                      else{
		                    	  $('#studid').prop('disabled',false);
		                    	  $.post("<?php echo site_url("index.php/feeControllers/checkID") ?>",{teacherid : teacherid, fsd : fsd}, function(data){
			      						$("#validId").html(data);
			      						});
		                      }
    					});
                      </script>
                </div>
			<?php
		}
		else{
			$this->load->model("feeModel");
			$var=$this->feeModel->getStudData($studID);
				if($var->num_rows()>0):
					$this->db->select("finance_start_date as fsd");
					$fsd = $this->db->get("general_settings")->row()->fsd;
					?>
						<input type="hidden" value="<?php echo $fsd.",0"; ?>" id="fsd12" />
						<button class="btn btn-info btn-squared btn-lg" id="fee">
                        	Proceed for Fee <i class="fa fa-arrow-circle-right"></i>
                        </button>
                        <script>
	                      $("#fee").click(function(){
	                    
	      					var teacherid = $("#studid").val();
	      					var fsd = $("#fsd12").val();
	      					//alert(teacherid+" -> "+fsd);
	      					//alert(teacherid)checkID,validId;
	      					$.post("<?php echo site_url("index.php/feeControllers/checkID") ?>",{teacherid : teacherid, fsd : fsd}, function(data){
	      						$("#validId").html(data);
	      						});
	      					});
                      </script>
					<?php
				else:
				?>
					<div class="alert alert-block alert-danger fade in">
						<button data-dismiss="alert" class="close" type="button">
							&times;
						</button>
						<h4 class="alert-heading"><i class="fa fa-times"></i> Error!</h4>
						<p>
							This student id <b><?php echo $studID;?></b> is not avaliable in database try another.....
						</p>
					</div>
				<?php
				endif;
		}}
	}
	
	function payFee(){
		// Calculate naxt month start	
		$oneTime = $this->input->post("one_time");
		$studentId = $this->input->post("stuId");
		
		$diposit_month = sizeof($this->input->post("diposit_month"));
		$month = $this->input->post("month");
		$fsd = $this->input->post("fsd");
		$totalMonth = $diposit_month + $month;
		$till_date = date("Y-m-d",strtotime("$fsd + $totalMonth month"));
		//echo $till_date;
		// Calculate naxt month end
		
		//invoice number logic start
			$invoice = $this->db->count_all("invoice_serial");
			$invoice_number = $invoice + 1000;
			$invoiceDetail = array(
					"invoice_no" => $invoice_number,
					"reason" => "Fee Deposit",
					"invoice_date" => date("Y-m-d")
			);
			$this->db->insert("invoice_serial",$invoiceDetail);
		//invoice number logic end
		
		// Fee detail insert Start	
		$fields = $this->db->list_fields('fee_shedule');
		foreach($fields as $field):
			if($field != "id" && $field != "student_id"):
				$fee["$field"] = $_POST["$field"];
			endif;
		endforeach;
		$fee["student_id"] = $this->input->post("stuId");
		$fee["payment_mode"] = $this->input->post("payment_mode");
		$fee["other_fee_reason"] = $this->input->post("other_fee_reason");
		$fee["previous_balance"] = $this->input->post("pb");
		$fee["previous_stock_balance"] = $this->input->post("previous_stock_balance");
		$fee["total"] = $this->input->post("total");
		$fee["paid"] = $this->input->post("paid");
		$fee["current_balance"] = $this->input->post("cb");
		$fee["sub_total"] = $this->input->post("sub_total");
		$fee["diposit_month"] = $diposit_month;
		$fee["diposit_date"] = date('Y-m-d');
		$fee['till_diposit'] = $till_date;
		$fee['invoice_no'] = $invoice_number;
		$fee['finance_start_date'] = $fsd;
		$this->db->insert("fee_deposit",$fee);
		// Fee detail insert Start
		
		
		
		if($this->input->post("one_time")){
		// Fee Schudling fee start
		$feeSehedule["student_id"] = $this->input->post("stuId");
		foreach($fields as $field):
			if($field != "id" && $field != "student_id"):
				$feeSehedule["$field"] = $_POST["$field"];
	        endif;
        endforeach;
        
        $this->db->where("student_id",$studentId);
        $isStudent = $this->db->get("fee_shedule")->num_rows();
        
	        if($isStudent > 0){
	        	$this->db->where("student_id",$studentId);
	        	$this->db->update("fee_shedule",$feeSehedule);
	        }else{
	        	$this->db->insert("fee_shedule",$feeSehedule);
	        }
		//  Fee Schudling End
		
        //one_time_fee fee code Start
        $fields1 = $this->db->list_fields('one_time_fee');
        $oneTimeFee["student_id"] = $this->input->post("stuId");
        if(isset($_POST["one_time"])){
        	foreach($fields1 as $field):
        	if($field != "id" && $field != "student_id" && $field != "diposit_date"):
        	$oneTimeFee["$field"] = $_POST["$field"];
        	endif;
        	endforeach;
        }
	       $this->db->insert("one_time_fee",$oneTimeFee);
        //one_time_fee fee code end
		} // End onetime fee condition
		
//-----------------------------------------------------------------------------------------------
		
		// Fee bank Detail  code
		if($this->input->post("dipositorName1")){
			$dipositerName = $_POST["dipositorName1"];
		}
		elseif($this->input->post("dipositorName2")){
			$dipositerName = $_POST["dipositorName2"];
		}
		elseif($this->input->post("dipositorName3")){
			$dipositerName = $_POST["dipositorName3"];
		}
		else{
			$dipositerName = $_POST["dipositorName"];
		}
		//echo $dipositerName."Pushpendra tum topa ho...";
		
		
		if($this->input->post("transactionNumber")){
			$transactionNumber = $_POST["transactionNumber"];
		}
		else{
			$transactionNumber = $_POST["transactionNumber1"];
		}
		

		if(isset($_POST["diposit_date1"])){
			$diposit_date = $_POST["diposit_date1"];
		}
		else if(isset($_POST["diposit_date2"])){
			$diposit_date = $_POST["diposit_date2"];
		}
		else{
			$diposit_date = date("Y-m-d");
		}
		$bank_detail = array(
			"student_id" => $this->input->post("stuId"),
			"school_ac" => $this->input->post("schoolAC"),
			"depositor_name" => $dipositerName,
			"fee_amount" => $this->input->post("paid"),
			"cheque_bank" => $this->input->post("chequebank"),
			"cheque_number" => $this->input->post("chequeNumber"),
			"challan_number" => $this->input->post("challanNumber"),
			"deposit_date" => $diposit_date,
			"transaction_no" => $transactionNumber,
			"invoice_no" => $invoice_number
		);
		// end Fee bank detail code
		$op1 = $this->db->query("select closing_balance from opening_closing_balance where opening_date='".date('Y-m-d')."'")->row();
		$balance = $op1->closing_balance;
		$close1 = $balance + $this->input->post("paid");
		$dayBook = array(
				"paid_to" =>$this->input->post("stuId"),
				"paid_by" =>$this->session->userdata("username"),
				"reason" => "Fee Deposit",
				"dabit_cradit" => "Credit",
				"amount" => $this->input->post("paid"),
				"closing_balance" => $close1,
				"pay_date" => date('Y-m-d'),
				"pay_mode" => $this->input->post("payment_mode"),
				"invoice_no" => $invoice_number
		);
				
		if($this->db->insert("fee_bank_detail",$bank_detail) && $this->db->insert('day_book',$dayBook)):
		
			//---------------------------------------------- Opening Colsing Balance Start -----------------------------------------
			$bal = array(
					"closing_balance" => $close1
			);
			$this->db->where("opening_date",date('Y-m-d'));
			$this->db->update("opening_closing_balance",$bal);
			//---------------------------------------------- Opening Colsing Balance End -------------------------------------------
			
			$psbd = array(
					"balance" => "0.00"
			);
			
			$this->db->where("sno",$this->input->post("stockId"));
			$this->db->update("sale_info",$psbd);
			
			//---------------------------------------------- CHECK SMS SETTINGS -----------------------------------------
			$totfee = $this->input->post("total");
			$paid = $this->input->post("paid");
			$current_balance = $this->input->post("cb");
			$val=$this->db->get("sms_setting")->row();
			$senderiD=$val->sender_id;
			$authkey=$val->auth_key;
			
			$isSMS = $this->db->get("sms")->row()->fee_submit;
			
			//---------------------------------------------- END CHECK SMS SETTINGS -----------------------------------------
			if($isSMS == 'yes'){
				$this->load->helper("sms");
				$student_id = $this->input->post("stuId");
				$this->db->where("student_id",$student_id);
				$var=$this->db->get("guardian_info")->row();
				$fmobile=$var->f_mobile;
				$this->db->where("status","Active");
				$this->db->where("student_id",$student_id);
				$stu=$this->db->get("student_info")->row();
				$stuname=$stu->first_name;
				$msg = "Dear Parent your child ".$stuname.",Fee of Month ".date("M",strtotime("$till_date - 1 month")).",is diposited of Rs.".$paid."/-with balance Rs.".$current_balance."/-.For more info visit:".$val->web_url;
				sms($authkey, $msg,$senderiD,$fmobile);
				redirect("invoiceController/fee/$invoice_number/$studentId/$oneTime/yes");
			}
			else{
				redirect("invoiceController/fee/$invoice_number/$studentId/$oneTime");
			}
		else:
			redirect("login/collectFee/feeFalse");
		endif;
	}
	
	function feeReport(){
		//$data['fsd'] = $this->db->get("general_setting");
		$data['fsd'] = $this->input->post("fsd");
		$data['cla'] = $this->input->post("classv");
		$data['sec'] = $this->input->post("section");
		$this->load->view("ajax/feeReport",$data);
	}
				  			
		function fullDetail(){
		 	$v = $this->uri->segment(3);
		 	$this->load->model("feeModel");
		 	$da=$this->feeModel->fulldetail($v);
		 	$data['request']=$da->result();
		 	$data['pageTitle'] = 'Fee Report';
		 	$data['smallTitle'] = 'Fee Report';
		 	$data['mainPage'] = 'Fee';
		 	$data['subPage'] = 'Fee Report';
		 	$data['title'] = 'Fee Report';
		 	$data['headerCss'] = 'headerCss/feeCss';
		 	$data['footerJs'] = 'footerJs/feeJs';
		 	$data['mainContent'] = 'personal';
		 	$this->load->view("includes/mainContent", $data);
		}	

		function enterDeufee(){
			
			$invoice = $this->db->count_all("invoice_serial");
			$invoice_number = $invoice + 1000;
			$invoiceDetail = array(
					"invoice_no" => $invoice_number,
					"reason" => "Fee Due",
					"invoice_date" => date("Y-m-d")
			);
			$this->db->insert("invoice_serial",$invoiceDetail);
			$studid=$this->input->post("studentId");
		$feeDueData = array(
				"student_id" => $this->input->post("studentId"),
				"student_name" => $this->input->post("studentName"),
				"total_due" => $this->input->post("remain"),
				"paid" => $this->input->post("paid"),
				"remain" => $this->input->post("remain"),
				"description" => $this->input->post("desc"),
				"ddate" => date("Y-m-d"),
				'invoice_no'=>$invoice_number
		);
		$paid=$this->input->post("paid");
		$cv =	$this->db->query("SELECT current_balance FROM fee_deposit WHERE student_id = '$studid' order by `id` desc limit 1")->row();
		$psv =	$this->db->query("SELECT previous_stock_balance FROM fee_deposit WHERE student_id = '$studid' order by `id` desc limit 1")->row();
		$pri = $pri + $cv->current_balance + $psv->previous_stock_balance;
		$remain12=$pri-$paid;
		$da=array(
				'current_balance'=>$remain12
		);
		
		$this->db->where("student_id",$studid);
		$this->db->update("fee_deposit",$da);
		
		$this->load->model("feeduemodel");
		$var = $this->feeduemodel->enterDetail($feeDueData,$studid);
		$op1 = $this->db->query("select closing_balance from opening_closing_balance where opening_date='".date('Y-m-d')."'")->row();
		$Clbalance = $op1->closing_balance;
		$amount=$this->input->post("paid");
		$cbal=$Clbalance+$amount;
		$bal = array(
				"closing_balance" => $cbal
		);
		$this->db->where("opening_date",date('Y-m-d'));
		$this->db->update("opening_closing_balance",$bal);
		
		$daybookdata=array(
				'paid_to'=>$this->input->post("studentId"),
				'paid_by'=>"Admin",
				'reason'=>$this->input->post("desc"),
				'dabit_cradit'=>"Cradit",
				'amount'=>$this->input->post("paid"),
				'closing_balance'=>$cbal,
				'pay_date'=>date('Y-m-d'),
				'pay_mode'=>"Cash",
				'invoice_no'=>$invoice_number
		);
		$this->db->insert("day_book",$daybookdata);
		$isSMS = $this->db->get("sms")->row()->fee_submit;
		$amount1=$this->input->post("paid");
		$totdue=$this->input->post("totdue");
		$balance=$this->input->post("remain");
		$val=$this->db->get("sms_setting")->row();
		$senderiD=$val->sender_id;
		$authkey=$val->auth_key;
		//---------------------------------------------- END CHECK SMS SETTINGS -----------------------------------------
		if($isSMS == 'yes'){
			$this->load->helper("sms");
			$student_id = $this->input->post("studentId");
			$this->db->where("student_id",$student_id);
			$var=$this->db->get("guardian_info")->row();
			$fmobile=$var->f_mobile;
			$this->db->where("status","Active");
			$this->db->where("student_id",$student_id);
			$stu=$this->db->get("student_info")->row();
			$stuname=$stu->first_name;
			$msg = "Dear Parent ".$amount1.",is diposited of total.".$totdue."/-with balance Rs.".$balance."/-.Trinity Kerala group of Education For more info visit:".$val->web_url."@@9450720126";
			sms($authkey, $msg,$senderiD,$fmobile);
		}
		redirect(base_url()."invoiceController/printDueFee/".$invoice_number);
	}		
		
		public function checkDetails(){
			$msg = '<div class="alert alert-info"><button data-dismiss="alert" class="close">&times;</button><strong>New Entry :) </strong></div>';
			$studentId = $this->input->post("studentId");
			$this->load->model("feeduemodel");
			$var = $this->feeduemodel->checkStock($studentId);
			if($var->num_rows() > 0){
				foreach ($var->result() as $row){
					 $sname = $row->student_name;
					 $tdue =$row->total_due;
						$itemData = array(
							"student_id" =>$row->student_id,
							"studentName" =>$sname,
							"totdue" =>$tdue,
							"msg" => ""
					);
				}
			}
			else{
				$var = $this->feeduemodel->checkStock2($studentId);
				if($var->num_rows() > 0){
					foreach ($var->result() as $row){
						$sname = $row->first_name." ".$row->midd_name." ".$row->last_name;
						$tdue =0.00;
						$itemData = array(
							"student_id" =>$row->student_id,
							"studentName" =>$sname,
							"totdue" =>$tdue,
							"msg" => $msg
						);
				}
			}
			}
			echo (json_encode($itemData));
		}
		
		
		function printDueById(){
			$var= $this->input->post("billNo");
			$this->db->where("student_id",$var);
			$filter=$this->db->get("feedue2");
			if($filter->num_rows()>0)
			{
				?><table class="table table-bordered table-striped">
				<tr> 
					<th>S.no</th>
					<th>Student Id</th>
					<th>Student Name</th>
					<th>Total due</th>
					<th>Paid</th>
					
					<th>Date</th>
					<th>Invoice No</th>
				</tr>
				<?php $i =1 ;foreach($filter->result() as $f):?>
				<tr>
				<td><?php echo $i;?></td>
				<td><?php echo $f->student_id;?></td>
				<td><?php echo $f->student_name;?></td>
				<td><?php echo $f->total_due;?></td>
				<td><?php echo $f->paid;?></td>
				<td><?php $inv = $f->invoice_no; echo $f->ddate;?></td>
				<td>
				<a href="<?php echo base_url()?>index.php/invoiceController/printDueFee/<?php echo $inv;?>" target="_blank" class="btn btn-blue">
								Print Invoice
							</a>
				</td>
				</tr>
				<?php $i++; endforeach;?>
				</table><?php 
		}
		else{
		echo "No Value Found In table";
		}
		}
		
		function deleteFee(){
			$invoiceNo = $this->uri->segment(3);
			$student_id = $this->uri->segment(4);
			$fristfee = $this->uri->segment(5);
			$this->db->where('invoice_no', $invoiceNo);
			$val = $this->db->get("day_book")->row();
			$op1 = $this->db->query("select closing_balance from opening_closing_balance where opening_date='".date('Y-m-d')."'")->row();
			$balance = $op1->closing_balance;
			$close1 = $balance - $val->amount;
			$data = array(
					paid_to => "student",
					paid_by => "admin",
					reason => " Wrong Fee Entered",
					dabit_cradit => "Debit",
					amount => $val->amount,
					closing_balance => $close1,
					pay_date => date("Y-m-d"),
					pay_mode => "Software",
					invoice_no => "Delete Fee"
					
			);
			$bal = array(
					"closing_balance" => $close1
			);
			$this->db->where("opening_date",date('Y-m-d'));
			$this->db->update("opening_closing_balance",$bal);
			$this->db->insert("day_book",$data);
			$this->db->where('invoice_no', $invoiceNo);
			$this->db->where('student_id', $student_id);
			$this->db->delete('fee_deposit');
			if($fristfee=="true"){
				$this->db->where('student_id', $student_id);
				$this->db->delete('fee_shedule');
				$this->db->where('student_id', $student_id);
				$this->db->delete('one_time_fee');
			}
			redirect(base_url()."index.php/feeControllers/fullDetail/".$student_id); 
			
		}
		function deleteFeedue2(){
			$invoiceNo = $this->uri->segment(3);
			$student_id = $this->uri->segment(4);
			$fristfee = $this->uri->segment(5);
			$this->db->where('invoice_no', $invoiceNo);
			if($val = $this->db->get("day_book")->row()){
			$op1 = $this->db->query("select closing_balance from opening_closing_balance where opening_date='".date('Y-m-d')."'")->row();
			$balance = $op1->closing_balance;
			$close1 = $balance - $val->amount;
			$data = array(
					'paid_to' => "student",
					'paid_by' => "admin",
					'reason' => " Wrong Fee Entered",
					'dabit_cradit' => "Debit",
					'amount' => $val->amount,
					'closing_balance' => $close1,
					'pay_date' => date("Y-m-d"),
					'pay_mode' => "Software",
					'invoice_no' => "Delete Fee"
			
			);
			$bal = array(
					"closing_balance" => $close1
			);
			
			
			$this->db->where("opening_date",date('Y-m-d'));
			$this->db->update("opening_closing_balance",$bal);
			
			$this->db->insert("day_book",$data);
			}
			$this->db->where('invoice_no', $invoiceNo);
			$this->db->where('student_id', $student_id);
			$this->db->delete('feedue2');
			//$data1 = array(
					//"current_balance" => $val->amount
			///); 
			
			//$sno = $this->db->query("SELECT * FROM fee_deposit WHERE student_id ='".$student_id."' ORDER BY ID DESC limit 1")->row();
			//$this->db->where("id",$sno->id);
			//if($this->db->update("fee_deposit",$data1)){
			redirect(base_url()."index.php/feeControllers/fullDetail/".$student_id);
			//}
			//else{
			//	echo "Wrong Value";
			//}
		}
		function transReport(){
			$data['fsd'] = $this->input->post("fsd");
			$data['cla'] = $this->input->post("classv");
			$data['sec'] = $this->input->post("section");
			$this->load->view("ajax/transport",$data);
			}
			
		function updateFeeS(){
			$stuid = $this->input->post("stuid");
			$tutionfee = $this->input->post("tutionfee");
			$computer_fee = $this->input->post("computer_fee");
			$transport_fee = $this->input->post("transport_fee");
			$other_fee = $this->input->post("other_fee");
			$data = array(
					'Tution_Fee'	=> $tutionfee,
					'Computer_Fee'	=> $computer_fee,
					'Exam' => $transport_fee,
					'Transport_Fee' => $transport_fee,
					'Others_Fee' => $other_fee
			);
			$this->db->where("student_id",$stuid);
			
			if($this->db->update("fee_shedule",$data))
			{	
				echo "Updated";
			}
			else
			{
				echo "Error";
			}	
		}
	}