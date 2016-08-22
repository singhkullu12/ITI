<?php
if($cla == "all" && $sec == "all"):
$this->db->where("status","Active");
	$student = $this->db->get("student_info");
elseif($cla != "all" && $sec == "all"):
$this->db->where("status","Active");
	$this->db->where("shift",$cla);
	$student = $this->db->get("student_info");
else:
$this->db->where("status","Active");
	$this->db->where("shift",$cla);
	$this->db->where("unit",$sec);
	$student = $this->db->get("student_info");
endif;
?>
<?php if($student->num_rows() > 0): 
	$isData = $this->db->count_all("fee_deposit"); 
	if($isData > 0):
?>
		<br/><br/>
		<div class="row">
			<div class="col-md-12 space20">
				<div class="btn-group pull-right">
					<button data-toggle="dropdown" class="btn btn-green dropdown-toggle">
						Export <i class="fa fa-angle-down"></i>
					</button>
					<ul class="dropdown-menu dropdown-light pull-right">
						<li>
							<a href="#" class="export-excel" data-table="#sample-table-2" data-ignoreColumn ="3,4">
								Export to Excel
							</a>
						</li>
					</ul>
				</div>
			</div>
		</div>
		<div class="table-responsive">
			<table class="table table-striped table-hover" id="sample-table-2">
				<thead>
					<tr>
						<th>S.no.</th>
						<th>Student Name</th>
						<th>Father Mobile</th>
						<th>Student Id</th>
						<th>Father Name</th>
						
						<th>Fee line</th>
						<th>Total Paid</th>
						<th>Total Due</th>
						<th>Full Detail</th>
					</tr>
				</thead>
				<?php 
				
				    $color = array(
					    "progress-bar-danger",
					    "progress-bar-success",
					    "progress-bar-warning",
					    "progress-partition-green",
					    "partition-azure",
					    "partition-blue",
					    "partition-orange",
					    "partition-purple",
					    "progress-bar-danger",
					    "progress-bar-success",
					    "progress-partition-green",
					    "partition-purple"
				    );
				    $count = 1;
				    $tot=0.00;?>
				<tbody>
				<?php 
				
				    $color = array(
					    "progress-bar-danger",
					    "progress-bar-success",
					    "progress-bar-warning",
					    "progress-partition-green",
					    "partition-azure",
					    "partition-blue",
					    "partition-orange",
					    "partition-purple",
					    "progress-bar-danger",
					    "progress-bar-success",
					    "progress-partition-green",
					    "partition-purple"
				    );
				    $count = 1;
				    $tot=0.00;
				    foreach($student->result() as $stuDetail):
				    $stu_id = $stuDetail->enroll_num;
				    $this->db->where("student_id",$stu_id);
				    $rows = $this->db->get("guardian_info")->row();
				    $total = $this->db->query("SELECT SUM(diposit_month) as totalMonth, SUM(paid) as totalPaid from fee_deposit WHERE student_id = '$stu_id' AND finance_start_date='$fsd'")->row(); ?>
					<tr>
			  			<td><?php echo $count;?></td>
			  			<td><?php echo $stuDetail->name;?></td>
			  			<td><?php echo$stuDetail->f_mobile;?></td>
			  			<td><?php echo $stu_id;?>
			  			
			  			<td><?php echo $stuDetail->father_full_name;?></td>
			  			
			  			<td>
							<?php $month = $total->totalMonth;?>
							<?php if($month > 12){$month = $month - 12;} ?>
			                <?php for($i = 0; $i<$month; $i++):?>
				               <span class="label label-success" style="line-height:20px;">
				               		<?php echo date("M-y",strtotime("$fsd + $i month"));?>
				               </span>
			                <?php endfor; ?>
						</td>
			  			<td><?php 
			  			$stamp1 = date("Y-m-d");
			  			$stamp=strtotime($stamp1);
			  			$dayc=date("d", $stamp);
			  			$day1=date("m", $stamp);
			  			if($day1<4){
			  				$day1=$day1+12;
			  			}
			  			$mth = $day1-3;
			  			$fm = $mth-$month;
						$fc=0.00;
						
						$pri=0.00;
			  			$fd = $this->db->query("SELECT * from fee_deposit  WHERE student_id = '$stu_id' AND finance_start_date='$fsd' limit 1 ")->row(); 
			  			if($fd)	{
			  			$fc = $fc + $fd->Tution_Fee;
			  				$fc = $fc + $fd->Library_Fee;
			  			
			  			
			  				$fc = $fc + $fd->Practical_Fee;
			  				$fc = $fc + $fd->Session_Fee;
			  				
			  				$fc = $fc + $fd->Bag_Fee;
			  				$fc = $fc + $fd->Book_Fee;
			  				$fc = $fc + $fd->Copy_Fee;
			  				$fc = $fc + $fd->Tour_Fee;
			  				$fc = $fc + $fd->Late_Fee;
			  				$fc = $fc + $fd->Absenty_Fee;
			  		
			  			$cv =	$this->db->query("SELECT current_balance FROM fee_deposit WHERE student_id = '$stu_id' order by `id` desc limit 1")->row();
			  			$psv =	$this->db->query("SELECT previous_stock_balance FROM fee_deposit WHERE student_id = '$stu_id' order by `id` desc limit 1")->row();
			  			$pri = $pri + $cv->current_balance + $psv->previous_stock_balance; 
			  			}			
			  			echo $total->totalPaid;?></td>
			  			<td><?php if($fm>1){
			  				$tot=$tot+$fc*$fm+$pri;
			  				echo $fc*$fm+$pri;
			  			}else{
			  				if(($fm==1)&&($dayc>16)){
			  					$tot=$tot+$fc+$pri;
			  					echo $fc+$pri;
			  				}
			  				else{
			  					if($pri>0){
			  						$tot=$tot+$pri;
			  						echo $pri;
			  					}else{
			  					echo "NotDue";
			  					}
			  				}
			  			} ?></td>
			  			<td>
							<a href="<?php echo base_url()?>index.php/feeControllers/fullDetail/<?php echo $stu_id;?>" target="_blank" class="btn btn-blue">
								View Detail
							</a>
			  			</td>
			  		</tr>
			  		<?php $count++; ?>
			  		<?php endforeach;?>
			  		<tr>
			  		<td></td>
			  		<td>Total Due</td>
			  		<td></td>
			  		<td></td>
			  		<td></td>
			  		<td></td>
			  		<td></td>
			  		<td><?php echo $tot;?></td>
			  		<td></td>
			  		
			  		</tr>
				</tbody>
			</table>
		</div>
		<?php else: ?>
		<br/><br/>
			<div class="alert alert-block alert-danger fade in">
				<button data-dismiss="alert" class="close" type="button">
					&times;
				</button>
				<h4 class="alert-heading"><i class="fa fa-times"></i> Error! <?php echo $student->num_rows();?></h4>
				<p>
					No record found from Fee database please submit fee first of this class &amp; section... 
				</p>
			</div>
		<?php endif; ?>
<?php else: // if student_info not return any value... ?>
	<br/><br/>
	<div class="alert alert-block alert-danger fade in">
		<button data-dismiss="alert" class="close" type="button">
			&times;
		</button>
		<h4 class="alert-heading"><i class="fa fa-times"></i> Error! <?php echo $student->num_rows();?></h4>
		<p>
			No record found from this class and section... 
		</p>
		<p>
			Make sure students are avaliable in this class section... :)
		</p>
	</div>
<?php endif; ?>


<script>
	TableExport.init();
</script>