<div class="container">

	<!-- Outer Row -->
	<div class="row justify-content-center">

		<div class="col-lg-8">

			<div class="card o-hidden border-0 shadow-lg my-5">
				<div class="card-body p-0">
					<!-- Nested Row within Card Body -->
					<div class="row">
						<div class="col-lg">
							<div class="p-5">
								<div class="text-center">
									<h1 class="h4 text-gray-900 mb-2">Change Password</h1>
									<h5 class='mb-3'><?= $this->session->userdata('reset_email'); ?></h5>
								</div>

								<?= $this->session->flashdata('message'); ?>

								<form method="POST" action="<?= base_url('auth/changepassword'); ?>" class="user">
									<div class="form-group">
										<input type="password" class="form-control form-control-user" id="password" name="password" placeholder="New Password" />
										<?= form_error('password', '<small class="text-danger pl-3">', "</small>"); ?>
									</div>
									<div class="form-group">
										<input type="password" class="form-control form-control-user" id="confirm_password" name="confirm_password" placeholder="Confirm Password" />
										<?= form_error('confirm_password', '<small class="text-danger pl-3">', "</small>"); ?>
									</div>
									<button type='submit' class="btn btn-primary btn-user btn-block">
										Change Password
									</button>
								</form>
								<hr>
								<div class="text-center">
									<a class="small" href="<?= base_url('auth/signup'); ?>">Create an Account!</a>
								</div>
								<div class="text-center">
									<a class="small" href="<?= base_url('auth'); ?>">Already have an account? Login!</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

		</div>

	</div>

</div>
