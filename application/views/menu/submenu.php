			<!-- Begin Page Content -->
			<div class="container-fluid">

				<!-- Page Heading -->
				<h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

				<div class="row">
					<div class="col-lg-12">
						<?php if (validation_errors()) : ?>
							<div class='alert alert-danger'>
								<?= validation_errors(); ?>
							</div>
						<?php endif; ?>
						<?= $this->session->flashdata('message'); ?>

						<a href="" class=" btn btn-primary mb-3 tambahDataSubMenu" data-toggle="modal" data-target="#modalSubMenu">Add New Submenu</a>
						<table class="table table-hover">
							<thead>
								<tr>
									<th scope="col">id</th>
									<th scope="col">Menu</th>
									<th scope="col">Title</th>
									<th scope="col">Url</th>
									<th scope="col">Icon</th>
									<th scope="col">Active</th>
									<th scope="col">Action</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($submenus as $submenu) : ?>
									<tr>
										<th scope="row"><?= $submenu['id']; ?></th>
										<td><?= $submenu['menu']; ?></td>
										<td><?= $submenu['title']; ?></td>
										<td><?= $submenu['url']; ?></td>
										<td><?= $submenu['icon']; ?></td>
										<td><?= $submenu['is_active'] == 0 ? "Tidak aktif" : "Aktif"; ?></td>
										<td>
											<a href="<?= base_url('menu/submenu/edit/') . $submenu['id']; ?>" class="badge badge-success mr-2 editDataMenu" data-toggle="modal" data-target="#modalSubMenu" data-id="<?= $submenu['id']; ?>">Edit</a>
											<a href="<?= base_url('menu/submenu/delete/') . $submenu['id']; ?>" class="badge badge-danger" onclick="return confirm('Apakah kamu yakin ingin menghapus menu ini?')">Delete</a> </td>
									</tr> <?php endforeach; ?>
							</tbody>
						</table>
					</div>
				</div>
			</div> <!-- /.container-fluid -->

			</div>
			<!-- End of Main Content -->
			<!-- Modal -->
			<div class="modal fade" id="modalSubMenu" tabindex="-1" role="dialog">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="judulModalSubMenu">Add New Submenu</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<form method="POST" action="<?= base_url('menu/submenu'); ?>">
							<div class="modal-body">
								<div class='form-group'>
									<select name='menu_id' class='form-control'>
										<?php foreach ($menus as $menu) : ?>
											<option value='<?= $menu["id"]; ?>'><?= $menu['menu']; ?></option>
										<?php endforeach; ?>
									</select>
								</div>
								<div class='form-group'>
									<input type='text' class='form-control' id='menu' name='submenu' placeholder='Submenu title' />
								</div>
								<div class='form-group'>
									<input type='text' class='form-control' id='menu' name='url' placeholder='Url Submenu' />
								</div>
								<div class='form-group'>
									<input type='text' class='form-control' id='menu' name='icon' placeholder='Icon Submenu' />
								</div>
								<div class='form-group'>
									<select name='is_active' class='form-control'>
										<option value='0'>Tidak aktif</option>
										<option value='1'>Aktif</option>
									</select>
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
