<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

	<!-- Sidebar - Brand -->
	<a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
		<div class="sidebar-brand-icon rotate-n-15">
			<i class="fas fa-code"></i>
		</div>
		<div class="sidebar-brand-text mx-3">LS Admin</div>
	</a>

	<!-- QUERY MENU -->
	<?php
	$role_id = $this->session->userdata('role_id');

	$queryMenu = "SELECT user_menus.id, user_menus.menu
			FROM user_menus JOIN user_access_menus
				ON user_menus.id = user_access_menus.menu_id
			WHERE user_access_menus.role_id = $role_id
			ORDER BY user_access_menus.menu_id ASC
			";
	$menus = $this->db->query($queryMenu)->result_array();
	?>

	<!-- Divider -->
	<hr class="sidebar-divider mt-3">
	<!-- Heading MENU -->
	<?php foreach ($menus as $menu) : ?>

		<div class='sidebar-heading'>
			<?= $menu['menu']; ?>
		</div>

		<!-- Sub Heading Sesuai MENU -->
		<?php
		$menuId = $menu['id'];
		$querySubMenu = "SELECT * 
								FROM user_sub_menus
							WHERE user_sub_menus.menu_id = $menuId AND user_sub_menus.is_active = 1
						";
		$subMenus = $this->db->query($querySubMenu)->result_array();
		$active = "";
		?>

		<?php foreach ($subMenus as $subMenu) : ?>
			<!-- Nav Item - Dashboard -->
			<?php
			if ($title == $subMenu['title']) {
				$active = " active";
			} else {
				$active = "";
			}
			?>
			<li class="nav-item<?= $active; ?>">
				<a class="nav-link pb-0 pt-2" href="<?= base_url($subMenu['url']); ?>">
					<i class="<?= $subMenu['icon']; ?>"></i>
					<span><?= $subMenu['title']; ?></span></a>
			</li>
		<?php endforeach; ?>

		<!-- Divider -->
		<hr class="sidebar-divider mt-3">

	<?php endforeach; ?>

	<li class="nav-item">
		<a class="nav-link" href="<?= base_url('auth/logout'); ?>">
			<i class="fas fa-fw fa-sign-out-alt"></i>
			<span>Logout</span></a>
	</li>

	<!-- Divider -->
	<hr class="sidebar-divider d-none d-md-block">

	<!-- Sidebar Toggler (Sidebar) -->
	<div class="text-center d-none d-md-inline">
		<button class="rounded-circle border-0" id="sidebarToggle"></button>
	</div>

</ul>
<!-- End of Sidebar -->
