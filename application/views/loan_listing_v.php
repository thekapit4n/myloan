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
									<th>Total Loan Amount</th>
									<th>Currency Description</th>
									<th>Loan terms</th>
									<th>Total Weeks</th>
									<th>Start Date Loan</th>
									<th>End Date Loan</th>
									<th>Loan Status</th>
									<th class="text-center">Total Paid</th>
									<th class="text-center">Total Balance</th>
									<th class="text-center">Action</th>
								</tr>
							</thead>
							<tbody>
								<?php 
									if(isset($query) && is_object($query) && $query->num_rows() > 0)
									{
										foreach($query->result() as $rowloan)
										{
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
												<td><?php echo $rowloan->currency . " " . number_format($rowloan->total_amount_loan,2) ?></td>
												<td><?php echo $rowloan->currency_desc ?></td>
												<td><?php echo $rowloan->loan_terms . " " . $rowloan->loan_terms_types ?></td>
												<td><?php echo $rowloan->total_weeks  ?></td>
												<td><?php echo date('d/m/Y', strtotime($rowloan->start_date_loan))  ?></td>
												<td><?php echo date('d/m/Y', strtotime($rowloan->end_date_loan))  ?></td>
												<td><?php echo $rowloan->loan_status  ?></td>
												<td class="text-right"><?php echo $rowloan->currency . " " . number_format($rowloan->total_paid,2) ?></td>
												<td class="text-right"><?php echo $rowloan->currency . " " . number_format($rowloan->total_balance,2) ?></td>
												<td>
													<?php 
														if($this->session->has_userdata('usertype') && $this->session->userdata('usertype') == 'superadmin' && strtolower($rowloan->loan_status) == 'pending')
														{
														?>
															<button type="button" class="btn btn-sm btn-success">Approve</button>
															<button type="button" class="btn btn-sm btn-danger">Disapprove</button>
														<?php
														}
														elseif($this->session->has_userdata('usertype') && $this->session->userdata('usertype') == 'user')
														{
															if(strtolower($rowloan->loan_status) == 'approve')
															{
															?>
																<button type="button" class="btn btn-sm btn-info">Pay</button>
															<?php
															}
														}
													?>
												</td>
											</tr>
										<?php
										}
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
		
	</script>
</body>
</html>