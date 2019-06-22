			<!-- Begin Page Content -->
			<div class="container-fluid">

				<!-- Page Heading -->
				<h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

				<div class="row">
					<div class="col-lg-6">
						<?= form_error('role', '<div class="alert alert-danger">', '</div>'); ?>

						<?= $this->session->flashdata('message'); ?>

						<a href="" class=" btn btn-primary mb-3 tambahDataRole" data-toggle="modal" data-target="#modalRole">Add New Role</a>
						<table class="table table-hover">
							<thead>
								<tr>
									<th scope="col">id</th>
									<th scope="col">Role</th>
									<th scope="col">Action</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($roles as $role) : ?>
									<tr>
										<th scope="row"><?= $role['id']; ?></th>
										<td><?= $role['role']; ?></td>
										<td>
											<a href="<?= base_url('admin/roleaccess/') . $role['id']; ?>" class="badge badge-warning mr-2">access</a>
											<a href="<?= base_url('admin/role/edit/') . $role['id']; ?>" class="badge badge-success mr-2 editDataRole" data-toggle="modal" data-target="#modalRole" data-id="<?= $role['id']; ?>">Edit</a>
											<a href="<?= base_url('admin/role/delete/') . $role['id']; ?>" class="badge badge-danger" onclick="return confirm('Apakah kamu yakin ingin menghapus role ini?')">Delete</a> </td>
									</tr> <?php endforeach; ?>
							</tbody>
						</table>
					</div>
				</div>
			</div> <!-- /.container-fluid -->

			</div>
			<!-- End of Main Content -->
			<!-- Modal -->
			<div class="modal fade" id="modalRole" tabindex="-1" role="dialog">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="judulModalRole">Add New Role</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<form method="POST" action="<?= base_url('admin/roles'); ?>">
							<div class="modal-body">
								<div class='form-group'>
									<input type='text' class='form-control' id='role' name='role' placeholder='Role name' />
									<input type="hidden" name="id" id="id" />
								</div>
							</div>
							<div class="modal-footer">
								<button type="submit" class="btn btn-secondary" data-dismiss="modal">Close</button>
								<button type="submit" class="btn btn-primary submitButton">Save changes</button>
							</div>
						</form>
					</div>
				</div>
			</div>
