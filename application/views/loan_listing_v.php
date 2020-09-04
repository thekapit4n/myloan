<?php 
	$this->load->view('header_v'); 
	if(isset($arr_data) && is_array($arr_data) && sizeof($arr_data) > 0)
	{
		$query = (isset($arr_data['query']) && is_object($arr_data['query'])) ? $arr_data['query'] : false ; 
		$starting_row = (isset($arr_data['starting_row']) && $arr_data['starting_row'] != '') ? $arr_data['starting_row'] : "" ; 
		$stoping_row = (isset($arr_data['stoping_row']) && $arr_data['stoping_row'] != '') ? $arr_data['stoping_row'] : "" ; 
		$total_rows = (isset($arr_data['total_rows']) && $arr_data['total_rows'] != '') ? $arr_data['total_rows'] : "" ; 
		$pagination = (isset($arr_data['pagination']) && $arr_data['pagination'] != '') ? $arr_data['pagination'] : false;
		
		$count = 0;
		if($this->uri->segment(3)!= "" && is_numeric($this->uri->segment(3)) && $this->uri->segment(3) > 0){
			$count = $this->uri->segment(3);
		}
		elseif($this->uri->segment(4)!= "" && is_numeric($this->uri->segment(4)) && $this->uri->segment(4) > 0)
		{
			$count = $this->uri->segment(4);
		}
	}

?>
	<section class="background-grey">
		<div class="container">
			<h2 class="font-weight-700"><span>Loan Listing</span></h2>
		</div> 
		<div class="container-fluid">
			<div style="margin-right:5%; margin-left:5%">
				<div class="row">
					<div class="col-md-12">
						<p>
							Displaying <?php echo (isset($starting_row) && $starting_row != '') ? $starting_row : 0 ?> 
							to <?php echo (isset($stoping_row) && $stoping_row != '') ? $stoping_row : 0 ?> 
							of <?php echo (isset($total_rows) && $total_rows != '') ? $total_rows : 0 ?> entries
						</p>
					</div>
				</div>
				<div class="row">
					<div class="table-responsive">
						<table class="table table-bordered nobottommargin">
							<thead>
								<tr>
									<th>#</th>
									<?php 
										if($this->session->has_userdata('usertype') && $this->session->userdata('usertype') == 'superadmin')
										{
										?>
											<th>Fullname Applicant</th>
										<?php
										}
									?>
									<th>Currency Description</th>
									<th>Total Loan Amount</th>
									<th class="text-center">Total Paid</th>
									<th class="text-center">Total Balance</th>
									<th>Loan terms</th>
									<th>Total Weeks</th>
									<th style='width:16%'>Payment terms</th>
									<th>Start Date Loan</th>
									<th>End Date Loan</th>
									<th>Loan Status</th>
									
									<th class="text-center">Action</th>
								</tr>
							</thead>
							<tbody>
								<?php 
									if(isset($query) && is_object($query) && $query->num_rows() > 0)
									{
										foreach($query->result() as $rowloan)
										{
											$payweek = $rowloan->total_paid_by_weeks;
											$currenweek = $rowloan->current_no_weeks;
											if($currenweek == $rowloan->total_weeks)
											{
												$payweek = $rowloan->total_paid_forlast;
											}
										?>
											<tr>
												<td><?php echo ++$count ?></td>
												<?php 
													if($this->session->has_userdata('usertype') && $this->session->userdata('usertype') == 'superadmin')
													{
													?>
														<th><?php echo $rowloan->fullname ?></th>
													<?php
													}
												?>
												<td><?php echo $rowloan->currency_desc ?></td>
												<td><?php echo $rowloan->currency . " " . number_format($rowloan->total_amount_loan,2) ?></td>
												<td class="text-right"><?php echo $rowloan->currency . " " . number_format($rowloan->total_paid,2) ?></td>
												<td class="text-right"><?php echo $rowloan->currency . " " . number_format($rowloan->total_balance,2) ?></td>
												
												<td><?php echo $rowloan->loan_terms . " " . $rowloan->loan_terms_types ?></td>
												<td><?php echo $rowloan->total_weeks  ?></td>
												<td><?php 
													if($rowloan->total_paid_forlast != $rowloan->total_paid)
													{
													?>
														<ul class="list-unstyled">
															<li> Week 1 - Week <?php echo  $rowloan->total_weeks  - 1 ?> - amount to paid = <?php echo $rowloan->currency . " " . number_format($rowloan->total_paid_by_weeks,2) ?> </li>
															<li> Week <?php echo  $rowloan->total_weeks ?> -  amount to paid = <?php echo $rowloan->currency . " " . number_format($rowloan->total_paid_forlast,2) ?> </li>
														</ul>
													<?php
													}
													else
													{
													?>
														<ul class="list-unstyled">
															<li> Week <?php echo  $rowloan->total_weeks  - 1 ?> amount to paid = <?php echo $rowloan->currency . " " . number_format($rowloan->total_paid_by_weeks,2) ?> </li>
														</ul>
													<?php
													}
												?></td>
												<td><?php echo date('d/m/Y', strtotime($rowloan->start_date_loan))  ?></td>
												<td><?php echo date('d/m/Y', strtotime($rowloan->end_date_loan))  ?></td>
												<td><?php
													$defaultBadge = 'badge-primary';
													if($rowloan->loan_status == 'pending')
													{
														$defaultBadge = 'badge-info';
													}
													elseif($rowloan->loan_status == 'approve')
													{
														$defaultBadge = 'badge-success';
													}
													elseif($rowloan->loan_status == 'disapprove')
													{
														$defaultBadge = 'badge-danger';
													}
													?>
													<span class="badge badge-pill <?php echo $defaultBadge ?>"><?php echo $rowloan->loan_status  ?></span>
												</td>
												<td>
													<?php 
														if($this->session->has_userdata('usertype') && $this->session->userdata('usertype') == 'superadmin' && strtolower($rowloan->loan_status) == 'pending')
														{
														?>
															<button type="button" class="btn btn-sm btn-success btn-approval" data-typeapproval='approve' data-loanid='<?php echo $rowloan->id ?>'>Approve</button>
															<button type="button" class="btn btn-sm btn-danger btn-approval" data-typeapproval='dispprove' data-loanid='<?php echo $rowloan->id ?>'>Disapprove</button>
														<?php
														}
														elseif($this->session->has_userdata('usertype') && $this->session->userdata('usertype') == 'user')
														{
															if(strtolower($rowloan->loan_status) == 'approve' && $rowloan->total_balance > 0)
															{
															?>
																<button type="button" class="btn btn-sm btn-info btn-pay" data-loanid='<?php echo $rowloan->id ?>' data-amountpaid='<?php echo $payweek ?>' data-currentweek='<?php echo $currenweek ?>' data-currency='<?php echo $rowloan->currency ?>'>Pay</button>
															<?php
															}
														}
													?>
												</td>
											</tr>
										<?php
										}
									}
									else
									{
										echo "<tr><td colspan='" . (($this->session->has_userdata('usertype') && $this->session->userdata('usertype') == 'superadmin') ? 13 : 12 ) . "'> <center>No data available</center></td></tr>";
									}
								?>
							</tbody>
						</table>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<p>
							Displaying <?php echo (isset($starting_row) && $starting_row != '') ? $starting_row : 0 ?> 
							to <?php echo (isset($stoping_row) && $stoping_row != '') ? $stoping_row : 0 ?> 
							of <?php echo (isset($total_rows) && $total_rows != '') ? $total_rows : 0 ?> entries
						</p>
					</div>
				</div>
				<div class="row">
					<div class="col-md-8">
						<?php 
							echo (isset($pagination) && $pagination != '') ? $pagination : '' 
						?>
					</div>
				</div>
			</div>
		</div>
	</section>
<?php $this->load->view('footer_v'); ?>
	<script type="text/javascript">
		function repayment(loanid)
		{
			if(loanid > 0)
			{
				$.ajax({
					url:"<?php echo base_url() ?>dashboard/loan_repayment/",
					method: "POST",
					dataType: 'json',
					data:{'id' : loanid},
					success: function(response){
						if(response.status == true)
						{
							Swal.fire({
							  title: 'Success!',
							  text: response.msg,
							  icon: 'success',
							  showCancelButton: false,
							  confirmButtonColor: '#3085d6',
							  confirmButtonText: 'Ok'
							}).then((result) => {
							  if (result.value) {
								location.reload();
							  }
							});
						}
						else if(response.status == false)
						{
							Swal.fire({
								icon: 'error',
								title: "Error!",
								text: response.msg,
							});
						}
					},
					error: function () {
						Swal.fire({
							icon: 'error',
							title: "Error!",
							text: 'Something went wrong on server side',
						})
					}
				});
			}
			else
			{
				Swal.fire({
					icon: 'error',
					title: "Error!",
					text: 'loan id not set',
				})
			}
		}
		
		$(function(){
			$('body').on('click', '.btn-approval', function(){
				var typeprocess = $(this).data('typeapproval');
				var loanid = $(this).data('loanid');
				$.ajax({
					url:"<?php echo base_url() ?>crm/manage_approval/",
					method: "POST",
					dataType: 'json',
					data:{'type': typeprocess, 'id' : loanid},
					success: function(response){
						if(response.status == true)
						{
							Swal.fire({
							  title: 'Success!',
							  text: response.msg,
							  icon: 'success',
							  showCancelButton: false,
							  confirmButtonColor: '#3085d6',
							  confirmButtonText: 'Ok'
							}).then((result) => {
							  if (result.value) {
								location.reload();
							  }
							});
						}
						else if(response.status == false)
						{
							Swal.fire({
								icon: 'error',
								title: "Error!",
								text: response.msg,
							});
						}
					},
					error: function () {
						Swal.fire({
							icon: 'error',
							title: "Error!",
							text: 'Something went wrong on server side',
						})
					}
				});
			});
			
			$('body').on('click', '.btn-pay', function(){
				var amountpaid = $(this).data('amountpaid');
				var loanid = $(this).data('loanid');
				var currentweek = $(this).data('currentweek');
				var currency = $(this).data('currency');
				var displytext = "Date : <?php echo date('d/m/Y') ?><br/>";
				displytext += "Pay for Week : " + currentweek + "<br/>";
				displytext += "Amount to be paid  : " + currency+ " " + amountpaid + "<br/>";
				Swal.fire({
					title: 'Info!',
					icon: 'info',
					html: displytext,
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: 'Proceed Payment'
				}).then((result) => {
					if (result.value) {
						repayment(loanid)
					}
				});
				
				
			});
		});
	</script>
</body>
</html>