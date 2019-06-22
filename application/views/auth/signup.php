  <div class="container">

  	<div class="card o-hidden border-0 shadow-lg my-5 col-lg-8 mx-auto">
  		<div class="card-body p-0">
  			<!-- Nested Row within Card Body -->
  			<div class="row">
  				<div class="col-lg">
  					<div class="p-5">
  						<div class="text-center">
  							<h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
  						</div>
  						<form class="user" method="POST" action="<?= base_url('auth/signup'); ?>">
  							<div class="form-group">
  								<input name="name" type="text" value="<?= set_value('name'); ?>" class="form-control form-control-user" id="name" placeholder="Full Name">
  								<?= form_error('name', "<small class='text-danger pl-3'>", "</small>"); ?>
  							</div>
  							<div class="form-group">
  								<input name="email" type="text" value="<?= set_value('email'); ?>" class="form-control form-control-user" id="email" placeholder="Email Address">
  								<?= form_error('email', "<small class='text-danger pl-3'>", "</small>"); ?>
  							</div>
  							<div class="form-group row">
  								<div class="col-sm-6 mb-3 mb-sm-0">
  									<input name="password" type="password" class="form-control form-control-user" id="password" placeholder="Password">
  									<?= form_error('password', "<small class='text-danger pl-3'>", "</small>"); ?>
  								</div>
  								<div class="col-sm-6">
  									<input name="confirm_password" type="password" class="form-control form-control-user" id="confirm_password" placeholder="Repeat Password">
  									<?= form_error('confirm_password', "<small class='text-danger pl-3'>", "</small>"); ?>
  								</div>
  							</div>
  							<button type=' submit ' class="btn btn-primary btn-user btn-block">
  								Register Account
  							</button>
  						</form>
  						<hr>
  						<div class="text-center">
  							<a class="small" href="<?= base_url('auth/'); ?>forgotPassword">Forgot Password?</a>
  						</div>
  						<div class="text-center">
  							<a class="small" href="<?= base_url('auth/'); ?>">Already have an account? Login!</a>
  						</div>
  					</div>
  				</div>
  			</div>
  		</div>
  	</div>

  </div>
