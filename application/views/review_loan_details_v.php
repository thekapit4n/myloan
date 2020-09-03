	<h2 class="font-weight-700"><span>Review Loan Application</span></h2>
	<?php 
		if(isset($row) && is_object($row))
		{
		?>
		<table class="table table-bordered">
			<tbody>
				<tr>
					<th scope="row" style="width: 25%;">Total Loan Amount :</th>
					<td><?php echo (isset($row->currency) && $row->currency != '') ? $row->currency : "" ?> <?php echo (isset($row->total_amount_loan) && $row->total_amount_loan != '') ? number_format($row->total_amount_loan,2) : "" ?></td>
				</tr>
				<tr>
					<th scope="row" style="width: 25%;">Currency Description :</th>
					<td><?php echo (isset($row->currency_desc) && $row->currency_desc != '') ? $row->currency_desc : "" ?></td>
				</tr>
				<tr>
					<th scope="row" style="width: 25%;">Start Loan date :</th>
					<td><?php echo (isset($row->start_date_loan) && $row->start_date_loan != '') ? date('d/m/Y', strtotime($row->start_date_loan)) : "" ?></td>
				</tr>
				<tr>
					<th scope="row" style="width: 25%;">End Loan date :</th>
					<td><?php echo (isset($row->end_date_loan) && $row->end_date_loan != '') ? date('d/m/Y', strtotime($row->end_date_loan)) : "" ?></td>
				</tr>
				<tr>
					<th scope="row" style="width: 25%;">Loan Terms :</th>
					<td><?php echo (isset($row->loan_terms) && $row->loan_terms != '') ? $row->loan_terms : "" ?> <?php echo (isset($row->loan_terms_types) && $row->loan_terms_types != '') ? $row->loan_terms_types : "" ?></td>
				</tr>
				<tr>
					<th scope="row" style="width: 25%;">Number of Weeks :</th>
					<td><?php echo (isset($row->total_weeks) && $row->total_weeks != '') ? $row->total_weeks : "" ?> Week(s)</td>
				</tr>
				<?php 
					if(isset($row->total_paid_by_weeks) && isset($row->total_paid_forlast) && isset($row->total_weeks) && $row->total_weeks > 1  && $row->total_paid_by_weeks != $row->total_paid_forlast)
					{
					?>
						<tr>
							<th scope="row" style="width: 25%;">Total Paid Weeks 1 to <?php echo $row->total_weeks - 1 ?>:</th>
							<td><?php echo (isset($row->currency) && $row->currency != '') ? $row->currency : "" ?> <?php echo (isset($row->total_paid_by_weeks) && $row->total_paid_by_weeks != '') ? number_format($row->total_paid_by_weeks,2) : "" ?></td>
						</tr>
						<tr>
							<th scope="row" style="width: 25%;">Total Paid Week <?php echo $row->total_weeks ?> :</th>
							<td><?php echo (isset($row->currency) && $row->currency != '') ? $row->currency : "" ?> <?php echo (isset($row->total_paid_forlast) && $row->total_paid_forlast != '') ? number_format($row->total_paid_forlast,2) : "" ?></td>
						</tr>
					<?php
					}
					else
					{
					?>
						<tr>
							<th scope="row" style="width: 25%;">Total Paid per Week :</th>
							<td><?php echo (isset($row->currency) && $row->currency != '') ? $row->currency : "" ?> <?php echo (isset($row->total_paid_by_weeks) && $row->total_paid_by_weeks != '') ? number_format($row->total_paid_by_weeks,2) : "" ?></td>
						</tr>
					<?php
					}
				?>
				<tr>
					<th colspan="2"><button type="button" class="btn btn-success btn-apply-loan" data-typeprocess="apply">Apply</button></th>
				</tr>
			</tbody>
		</table>
	<?php
		}
		else
		{
			echo "No data to be display";
		}
	
	?>
	
