<?php include 'includes/header-link.php'; ?>

<div id="main-wrapper">


	<?php include 'includes/header2.php' ?>

	<?php include 'includes/dash-top-header.php' ?>

	<div class="goodup-dashboard-wrap gray px-4 py-5">
		<?php include 'includes/dash-side-header.php' ?>
		<div class="goodup-dashboard-content">
			<div class="dashboard-tlbar d-block mb-5">
				<div class="row">
					<div class="colxl-12 col-lg-12 col-md-12">
						<h1 class="ft-medium"><?= sessionId('sahar') ? "My" : "Complete Your"; ?> Profile</h1>
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb">
								<li class="breadcrumb-item text-muted"><a href="#">Home</a></li>
								<li class="breadcrumb-item text-muted"><a href="#">Dashboard</a></li>
								<li class="breadcrumb-item"><a href="#" class="theme-cl">My Profile</a></li>
							</ol>
						</nav>
					</div>
				</div>
			</div>

			<div class="dashboard-widg-bar d-block">
				<div class="row">
					<div class="col-xl-12 col-lg-2 col-md-12 col-sm-12">
						<form method="POST" id="myform" enctype="multipart/form-data">
							<?php if ($msg = $this->session->flashdata('msg')) :
								$msg_class = $this->session->flashdata('msg_class') ?>
								<div class="row">
									<div class="col-lg-12">
										<div class="alert  <?= $msg_class; ?>"><?= $msg; ?></div>
									</div>
								</div>
							<?php
								$this->session->unset_userdata('msg');
							endif; ?>

							<input type="hidden" name="rgid" value="<?= sessionId('login_user_id') ?>">

							<div class="submit-form">
								<!-- Listing Info -->
								<div class="dashboard-list-wraps bg-white rounded mb-4">
									<div class="dashboard-list-wraps-head br-bottom py-3 px-3">
										<div class="dashboard-list-wraps-flx">
											<h4 class="mb-0 ft-medium fs-md"><i class="fa fa-file me-2 theme-cl fs-sm"></i>Company Info</h4>
										</div>
									</div>

									<div class="dashboard-list-wraps-body py-3 px-3">
										<div class="row">
											<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
												<div class="form-group">
													<label class="mb-1">Company Name</label>
													<input type="text" class="form-control rounded" placeholder="Enter your company name" value="<?= (($datacomrow != '') ? $datacomrow['0']['company_name'] : '') ?>" name="company_name" required />
												</div>
											</div>
											<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
												<div class="form-group">
													<label class="mb-1">Company Tagline</label>
													<input type="text" class="form-control rounded" placeholder="Enter Your company tagline " name="company_tagline" value="<?= (($datacomrow != '') ? $datacomrow['0']['company_tagline'] : '') ?>" required />
												</div>
											</div>
											<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
												<div class="form-group">
													<label class="mb-1">Your Name</label>
													<input type="text" class="form-control rounded" placeholder="Enter your name " name="company_person" value=" <?= (($datacomrow != '') ? $datacomrow['0']['company_person'] : sessionId('login_user_name')) ?>" required />
												</div>
											</div>
											<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
												<div class="form-group">
													<label class="mb-1">Your Designation</label>
													<input type="text" class="form-control rounded" placeholder="Enter your destignation" name="company_designation" value="<?= (($datacomrow != '') ? $datacomrow['0']['company_designation'] : '') ?>" required />
												</div>
											</div>
											<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
												<div class="form-group">
													<label class="mb-1">Mobile</label>
													<input type="text" class="form-control rounded" placeholder="Enter your number" name="company_contact" maxlength="10" required value="<?= (($datacomrow != '') ? $datacomrow['0']['company_contact'] : sessionId('login_user_contact')) ?>"  readonly/>
												</div>
											</div>
											<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
												<div class="form-group">
													<label class="mb-1">Email</label>
													<input type="text" class="form-control rounded" placeholder="Enter your email" name="company_email" value="<?= (($datacomrow != '') ? $datacomrow['0']['company_email'] : sessionId('login_user_emailid')) ?>" required   />
												</div>
											</div>
											<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
												<div class="form-group">
													<label class="mb-1">Whatsapp</label>
													<input type="text" class="form-control rounded" placeholder="Enter your whatsapp number" name="company_whatsapp" value="<?= (($datacomrow != '') ? $datacomrow['0']['company_whatsapp'] : '') ?>" maxlength="10" required />
												</div>
											</div>
											<div class="col-xl-6 col-lg-12 col-md-12 col-sm-12">
												<div class="form-group">
													<label class="mb-1">Website (Optional)</label>
													<input type="text" class="form-control rounded" placeholder="Your website link" value="<?= (($datacomrow != '') ? $datacomrow['0']['company_website_url'] : '') ?>" name="company_website_url" />
												</div>
											</div>
										</div>
									</div>
								</div>

								<!-- Location Info -->
								<div class="dashboard-list-wraps bg-white rounded mb-4">
									<div class="dashboard-list-wraps-head br-bottom py-3 px-3">
										<div class="dashboard-list-wraps-flx">
											<h4 class="mb-0 ft-medium fs-md"><i class="fas fa-map-marker-alt me-2 theme-cl fs-sm"></i>Company Category</h4>
										</div>
									</div>

									<div class="dashboard-list-wraps-body py-3 px-3">
										<div class="row">
											<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
												<div class="form-group">
													<label class="mb-1">Category</label>

													<select class="form-control" name="company_category" id="company_category" required>
														<option>Select Category</option>
														<?php
														if (!empty($category)) {
															foreach ($category as $cat_row) {

														?>
																<option value="<?= $cat_row['cate_id'] ?>" <?php if ($datacomrow != '') { ?> <?= (($datacomrow['0']['company_category'] ==  $cat_row['cate_id']) ? 'Selected' : '') ?> <?php } ?>>
																	<?= $cat_row['category'] ?></option>
														<?php
															}
														}
														?>
													</select>


												</div>
											</div>
											<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
												<div class="form-group">
													<label class="form-label">Sub Category <span style="color:red;font-size:12px;" id="company_city_msg"></span></label>

													<?php
													print_R($datacomrow);
													if ($datacomrow != '') {	?>

														<select name="company_subcategory" class="form-control">

															<?php
															$subcate = getAllRow('company_subcategory');

															if (!empty($subcate)) {
																foreach ($subcate as $cat_row) {

															?>
																	<option value="<?= $cat_row['subcat_id'] ?>" <?php if ($datacomrow != '') { ?> <?= (($datacomrow['0']['company_subcategory'] ==  $cat_row['subcat_id']) ? 'Selected' : '') ?> <?php } ?>>
																		<?= $cat_row['subcategory'] ?></option>
															<?php }
															} ?>

														</select>


													<?php } else { ?>



														<select name="company_subcategory" class="form-control" id="company_subcategory" required>
															<option value="">Select Sub Category</option>
														</select>


													<?php } ?>
												</div>
											</div>
										</div>
									</div>
								</div>




								<!-- Image & Gallery Option -->
								<div class="dashboard-list-wraps bg-white rounded mb-4">
									<div class="dashboard-list-wraps-head br-bottom py-3 px-3">
										<div class="dashboard-list-wraps-flx">
											<h4 class="mb-0 ft-medium fs-md"><i class="fa fa-camera me-2 theme-cl fs-sm"></i>Image</h4>
										</div>
									</div>

									<div class="dashboard-list-wraps-body py-3 px-3">
										<div class="row">
											<!-- Logo -->
											<div class="col-lg-6 col-md-6">
												<div class="form-group">
													<label for="formFileLg" class="form-label">Upload Company Logo</label>



													<?php
													if ($datacomrow != '') {
													?>
														<input type="file" class="form-control rounded" name="company_logo_temp" />
														<input type="hidden" class="form-control" name="company_logo" value="<?= $datacomrow[0]['company_logo']  ?>" />

														<img src="<?= base_url() ?>uploads/company/<?= $datacomrow[0]['company_logo'] ?>" class="logo-preview" alt="company-logo">
													<?php
													} else {
													?>
														<input class="form-control rounded" type="file" name="company_logo" required>
													<?php }
													?>

												</div>
											</div>
											<div class="col-lg-6 col-md-6">
												<div class="form-group">
													<label for="formFileLg" class="form-label">Upload Company Banner</label>
													<?php
													if ($datacomrow != '') {
													?>
														<input type="file" class="form-control rounded" name="company_banner_temp" />
														<input type="hidden" class="form-control" name="company_banner" value="<?= $datacomrow[0]['company_banner']  ?>" />

														<img src="<?= base_url() ?>uploads/company/<?= $datacomrow[0]['company_banner'] ?>" class="logo-preview" alt="company-logo">
													<?php
													} else {
													?>
														<input class="form-control rounded" type="file" name="company_banner" required>
													<?php }
													?>
												</div>
											</div>

										</div>
									</div>
								</div>

								<!-- Location Info -->
								<div class="dashboard-list-wraps bg-white rounded mb-4">
									<div class="dashboard-list-wraps-head br-bottom py-3 px-3">
										<div class="dashboard-list-wraps-flx">
											<h4 class="mb-0 ft-medium fs-md"><i class="fas fa-map-marker-alt me-2 theme-cl fs-sm"></i>Location Info</h4>
										</div>
									</div>

									<div class="dashboard-list-wraps-body py-3 px-3">
										<div class="row">
											<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
												<div class="form-group">
													<label class="mb-1">State</label>

													<select class="form-control" name="company_state" id="state" required>
														<option>Select State</option>
														<?php
														if (!empty($state_list)) {
															foreach ($state_list as $state_row) {
														?>
																<option value="<?= $state_row['state_id'] ?>" <?php if ($datacomrow != '') { ?> <?= (($datacomrow['0']['company_state'] ==  $state_row['state_id']) ? 'Selected' : '') ?> <?php } ?>>

																	<?= $state_row['state_name'] ?></option>
														<?php
															}
														}
														?>
													</select>



												</div>
											</div>
											<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
												<div class="form-group">
													<label class="form-label">City <span style="color:red;font-size:12px;" id="company_city_msg"></span></label>

													<?php if ($datacomrow != '') {	?>


														<select name="company_city" class="form-control" id="city">

															<?php
															$city = getAllRow('tbl_cities');

															if (!empty($city)) {
																foreach ($city as $row) {

															?>
																	<option value="<?= $row['id'] ?>" <?php if ($datacomrow != '') { ?> <?= (($datacomrow['0']['company_city'] ==  $row['id']) ? 'Selected' : '') ?> <?php } ?>>
																		<?= $row['name'] ?></option>
															<?php }
															} ?>

														</select>


													<?php } else { ?>



														<select name="company_city" class="form-control" id="city" required>
															<option value="">Select State first</option>
														</select>


													<?php } ?>




												</div>
											</div>
											<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
												<div class="form-group">
													<label class="mb-1">Address</label>
													<input type="text" class="form-control rounded" placeholder="Enter Your address here" value="<?= (($datacomrow != '') ? $datacomrow['0']['company_address'] : '') ?>" name="company_address" required />
												</div>
											</div>
											<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
												<div class="form-group">
													<label class="mb-1">Pin Code</label>
													<input type="text" class="form-control rounded" placeholder="Pin code" value="<?= (($datacomrow != '') ? $datacomrow['0']['pin_code'] : '') ?>" name="pin_code" required />
												</div>
											</div>

										</div>
									</div>
								</div>




								<div class="dashboard-list-wraps bg-white rounded mb-4">
									<div class="dashboard-list-wraps-head br-bottom py-3 px-3">
										<div class="dashboard-list-wraps-flx">
											<h4 class="mb-0 ft-medium fs-md"><i class="fa fa-user-friends me-2 theme-cl fs-sm"></i>Social Links (Optional)</h4>
										</div>
									</div>

									<div class="dashboard-list-wraps-body py-3 px-3">
										<div class="row">
											<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
												<div class="form-group">
													<label class="mb-1"><i class="ti-facebook theme-cl me-1"></i>Facebook</label>

													<input type="text" class="form-control rounded" placeholder="https://www.facebook.com/sahardirectory/" value="<?= (($datacomrow != '') ? $datacomrow['0']['company_facebook'] : 'https://www.facebook.com/sahardirectory/') ?>" name="company_facebook" />

												</div>
											</div>
											<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
												<div class="form-group">
													<label class="mb-1"><i class="ti-twitter theme-cl me-1"></i>Twitter</label>
													<input type="text" class="form-control rounded" placeholder="https://twitter.com/SaharDirectory/" value="<?= (($datacomrow != '') ? $datacomrow['0']['company_twitter'] : 'https://twitter.com/SaharDirectory/') ?>" name="company_twitter" />

												</div>
											</div>
											<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
												<div class="form-group">
													<label class="mb-1"><i class="ti-instagram theme-cl me-1"></i>Instagram</label>

													<input type="text" class="form-control rounded" placeholder="https://instagram.com/" value="<?= (($datacomrow != '') ? $datacomrow['0']['company_instagram'] : 'https://instagram.com/') ?>" name="company_instagram" />

												</div>
											</div>
											<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
												<div class="form-group">
													<label class="mb-1"><i class="ti-linkedin theme-cl me-1"></i>Linkedin</label>

													<input type="text" class="form-control rounded" placeholder="https://linkedin.com/" value="<?= (($datacomrow != '') ? $datacomrow['0']['company_linkedin'] : 'https://linkedin.com/') ?>" name="company_linkedin" />

												</div>
											</div>
											<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
												<div class="form-group">
													<label class="mb-1"><i class="ti-youtube theme-cl me-1"></i>Youtube</label>

													<input type="text" class="form-control rounded" placeholder="https://www.youtube.com/SaharDirectory" value="<?= (($datacomrow != '') ? $datacomrow['0']['company_youtube'] : 'https://www.youtube.com/SaharDirectory') ?>" name="company_youtube" />

												</div>
											</div>
											<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
												<div class="form-group">
													<label class="mb-1"><i class="icofont-telegram theme-cl me-1"></i>Telegram</label>

													<input type="text" class="form-control rounded" placeholder="https://www.telegram.com/sahardirectory" value="<?= (($datacomrow != '') ? $datacomrow['0']['company_telegram'] : 'https://www.telegram.com/sahardirectory') ?>" name="company_telegram" />

												</div>
											</div>
											<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
												<div class="form-group">
													<button type="submit" class="btn theme-bg rounded text-light">Update Profile</button>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>

			</div>

			<!-- footer -->


		</div>



	</div>


	<a id="tops-button" class="top-scroll" title="Back to top" href="#"><i class="ti-arrow-up"></i></a>



	<?php include 'includes/footer-bottom.php' ?>

</div>

<script>
	$(document).on('change', '#state', function() {
		var state = $(this).val();
		$.ajax({
			method: "POST",
			url: "<?= base_url('home/getcity') ?>",
			data: {
				state: state
			},
			success: function(response) {
				// console.log(response);
				$('#city').html(response);
			}
		});
	});

	$(document).on('change', '#company_category', function() {
		var company_category = $(this).val();
		$.ajax({
			method: "POST",
			url: "<?= base_url('home/select_subcat') ?>",
			data: {
				company_category: company_category
			},
			success: function(datas) {
				// console.log(response);
				$('#company_subcategory').html(datas);
			}
		});
	});



	Dropzone.options.singleLogo = {
		maxFiles: 1,
		accept: function(file, done) {
			console.log("uploaded");
			done();
		},
		init: function() {
			this.on("maxfilesexceeded", function(file) {
				alert("No more files please!");
			});
		}
	};

	Dropzone.options.featuredImage = {
		maxFiles: 1,
		accept: function(file, done) {
			console.log("uploaded");
			done();
		},
		init: function() {
			this.on("maxfilesexceeded", function(file) {
				alert("No more files please!");
			});
		}
	};

	Dropzone.options.gallery = {
		accept: function(file, done) {
			console.log("uploaded");
			done();
		},
		init: function() {
			this.on("maxfilesexceeded", function(file) {
				alert("No more files please!");
			});
		}
	};
</script>
<?php include 'includes/footer-link.php' ?>