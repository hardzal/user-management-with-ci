			<!-- Begin Page Content -->
			<div class="container-fluid">

				<!-- Page Heading -->
				<h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

				<div class="row">
					<div class="col-lg-6">
						<?= $this->session->flashdata('message'); ?>

						<form method="POST" action="<?= base_url('user/changepassword'); ?>">
							<div class="form-group">
								<label for="current_password">Current Password</label>
								<input type='password' name='current_password' class='form-control' id='current_password' name='current_password' />
								<?= form_error('current_password', '<small class="text-danger pl-3">', '</small>'); ?>
							</div>

							<div class='form-group'>
								<label for="new_password">New Password</label>
								<input type='password' name='new_password' class='form-control' id='new_password' name='new_password' />
								<?= form_error('new_password', '<small class="text-danger pl-3">', '</small>'); ?>
							</div>

							<div class='form-group'>
								<label for="confirm_password">Confirm Password</label>
								<input type='password' name='confirm_password' class='form-control' id='confirm_password' name='confirm_password' />
								<?= form_error('confirm_password', '<small class="text-danger pl-3">', '</small>'); ?>
							</div>

							<div class='form-group'>
								<button type='submit' class='btn btn-primary'>Change Password</button>
							</div>
						</form>

					</div>
				</div>


			</div>
			<!-- /.container-fluid -->

			</div>
			<!-- End of Main Content -->
