<?php $this->load->view('header_v'); ?> 
        <!-- WELCOME -->
        <section id="welcome" class="p-b-0">
            <div class="container">
                <div class="heading-text heading-section text-center m-b-40" data-animate="fadeInUp">
                    <h2>HI, <?php echo strtoupper($this->session->userdata('fullname')) ?> <br>WELCOME TO MYLOAN APPLICATION</h2>
                </div>
            </div>
        </section>
        <!-- end: WELCOME -->
        <!-- WHAT WE DO -->
        <section class="background-grey">
            <div class="container">
				<h2 class="font-weight-700"><span>Loan Application Form</span></h2>
				<div class="alert-div">
				</div>
                <form id="form-load">
					<div class="form-row">
						<div class="form-group col-md-6">
							<label for="inputEmail4">Fullname</label>
							<p><?php echo strtoupper($this->session->userdata('fullname')) ?></p>
							<input type="hidden" class="form-control form-control-sm" readonly name="userid" value="<?php echo strtoupper($this->session->userdata('userid')) ?>">
						</div>
					</div>
					<div class="h5 mb-4">Loan Details</div>
					<div class="form-row">
						<div class="form-group col-md-6">
							<label for="currencyInput">Currency</label>
							<select name="currency" class="form-control form-control-sm currency-opt">
								<option value="">Please Select Currency</option>
								<?php 
									if(isset($arr_currency) && sizeof($arr_currency) > 0)
									{
										foreach($arr_currency as $vCurrency)
										{
											if(is_string($vCurrency['sISOCode']) && is_string($vCurrency['sName']))
											{
										?>
											<option value="<?php echo $vCurrency['sISOCode'] ?>" data-currencydesc="<?php echo $vCurrency['sName'] ?>"><?php echo  $vCurrency['sISOCode'] . "-" . $vCurrency['sName']  ?></option>
										<?php
											}
										}
									}
								?>
							</select>
							<input type="hidden" class="form-control form-control-sm currency-desc" name="currency_desc">
						</div>
						<div class="form-group col-md-6">
							<label for="totalAmountLoanInput">Total Amount</label>
							<input type="text" class="form-control form-control-sm currency-input" id="totalAmountLoanInput" name="total_amount_loan">
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col-md-4">
							<label for="startDateLoanInput">Start Date</label>
							<input type="text" class="form-control form-control-sm start_date_loan" id="startDateLoanInput" name="start_date_loan" placeholder="Select start date loan">
						</div>
						<div class="form-group col-md-4">
							<label for="loanTermsInput">Loan terms</label>
							<input type="text" class="form-control form-control-sm int-input" id="loanTermsInput" name="loan_terms">
						</div>
						<div class="form-group col-md-4">
							<label for="loanTermsInput">Type of Loan Terms</label>
							<select name="loan_terms_types" class="form-control form-control-sm">
								<option value="years">Years</option>
								<option value="months">Months</option>
								<option value="weeks">Weeks</option>
							</select>
						</div>
					</div>
					<input type="hidden" class="form-control form-control-sm type-process-input" name="typeprocess">
					<button type="button" class="btn btn-warning btn-submitloan" data-typeprocess="review">Review</button>
				</form>
            </div> 
			<div class="container review-loan-container">
			
            </div>
        </section>
        <!-- END WHAT WE DO -->
<?php $this->load->view('footer_v'); ?> 
	<script type="text/javascript">
		function currency_option()
		{
			$('body').find('.currency-opt').select2({
				 theme: 'bootstrap4',
				placeholder: 'Please Select Currency'
			});
		}
		
		function datepicker_loan()
		{
			$('body').find('.start_date_loan').datepicker({
				format: 'dd/mm/yyyy',
				todayHighlight: true,
				orientation: "bottom left",
				autoclose: true
			});
		}
		
		function input_mask()
		{
			$("body").find('.int-input').inputmask({regex: "^[0-9]{1,6}?$", "placeholder": ""});
			$("body").find('.currency-input').inputmask('currency', {rightAlign: true});
		}
		
		function alert_respons(msg)
		{
			alerts = '<div role="alert" class="alert alert-danger alert-dismissible">';
			alerts += '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span> </button>';
			alerts += '<strong><i class="fa fa-warning"></i> &nbsp; Error</strong> <br/>' + msg;
			alerts += '</div>';
			$('body').find('.alert-div').html(alerts); 
		}
		
		$(function(){
			
			currency_option();
			datepicker_loan();
			input_mask();
			
			
			$('body').on('change', '.currency-opt', function(){
				var currencydesc = $(this).find(':selected').data('currencydesc');
				$('body').find('.currency-desc').val(currencydesc);
			});
			
			$('body').on('click', '.btn-submitloan', function(){
				var displayvalidating = 'Processing <i class="fa fa-spinner fa-spin"></i>';
				var displaysave = 'Review';
				var _thisbtn = $(this);
				var typeprocess = _thisbtn.data('typeprocess');
				$('body').find('.type-process-input').val(typeprocess);
				var dataform = $('body').find('#form-load').serialize();
				_thisbtn.html(displayvalidating);
				$('body').find('.review-loan-container').html("Processing ...");
				$('body').find('.alert-div').html(""); 
				$.ajax({
					url:"<?php echo base_url() ?>dashboard/loan_management/",
					method: "POST",
					dataType:'json',
					data:dataform,
					success: function(response){
						_thisbtn.html(displaysave);
						if(response.status == true)
						{
							if(response.html != '' && response.html !=  undefined)
								$('body').find('.review-loan-container').html(response.html);
						}
						else if(response.status == false)
						{
							$('body').find('.review-loan-container').html("");
							alert_respons(response.msg)
						}
					},
					error: function () {
						_thisbtn.html(displayvalidating);
						Swal.fire({
							icon: 'error',
							title: "Error!",
							text: 'Something went wrong on server side',
						})
					}
				});
			});
			
			$('body').on('click', '.btn-apply-loan', function(){
				var displayvalidating = 'Applying <i class="fa fa-spinner fa-spin"></i>';
				var displaysave = 'Apply';
				var _thisbtn = $(this);
				var typeprocess = _thisbtn.data('typeprocess');
				$('body').find('.type-process-input').val(typeprocess);
				
				var dataform = $('body').find('#form-load').serialize();
				_thisbtn.html(displayvalidating);
				$('body').find('.alert-div').html(""); 
				$.ajax({
					url:"<?php echo base_url() ?>dashboard/loan_management/",
					method: "POST",
					dataType:'json',
					data:dataform,
					success: function(response){
						_thisbtn.html(displaysave);
						if(response.status == 'applied')
						{
							$('body').find('.review-loan-container').html("<div class='row'><h4> Your loan application has been submitted. Now will be reviewed by Finance Department . <a href='<?php echo base_url() . 'dashboard/loan_listing' ?>'> View Myloan Listing</a></h4></div>");
							$('#form-load')[0].reset();
							$("#form-load .currency-opt").val('').trigger('change')
						}
						else if(response.status == false)
						{
							alert_respons(response.msg)
						}
					},
					error: function () {
						_thisbtn.html(displayvalidating);
						Swal.fire({
							icon: 'error',
							title: "Error!",
							text: 'Something went wrong on server side',
						})
					}
				});
			});
		});
	</script>
</body>
</html>