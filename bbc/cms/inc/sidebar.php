<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
  <!-- Sidebar - Brand -->
  <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
    <div class="sidebar-brand-icon">
      <i class="fas fa-home"></i>
    </div>
    <div class="sidebar-brand-text mx-3">BBC Admin</div>
  </a>
  <!-- Divider -->
  <hr class="sidebar-divider my-0">
  <!-- Nav Item - Dashboard -->
  <li class="nav-item">
    <a class="nav-link" href="index.php">
      <i class="fas fa-fw fa-tachometer-alt"></i>
      <span>Dashboard</span></a>
  </li>
  <?php
  $role = $_SESSION['role'];
  if($role == 'admin'){
  ?>
  <!-- Divider -->
  <hr class="sidebar-divider">
  <li class="nav-item">
    <a class="nav-link" href="category.php">
      <i class="fas fa-fw fa-sitemap"></i>
      <span>Category Manager</span></a>
  </li>
  <hr class="sidebar-divider d-none d-md-block">
  <li class="nav-item">
    <a class="nav-link" href="video.php">
      <i class="fas fa-fw fa-video"></i>
      <span>Videos Manager</span></a>
  </li>
  <hr class="sidebar-divider d-none d-md-block">
  <li class="nav-item">
    <a class="nav-link" href="users.php">
      <i class="fas fa-fw fa-user-alt"></i>
      <span>Users Manager</span></a>
  </li>
  <?php
}?>
  <hr class="sidebar-divider d-none d-md-block">
  <li class="nav-item">
    <a class="nav-link" href="news.php">
      <i class="fas fa-fw fa-newspaper"></i>
      <span>News Manager</span></a>
  </li>
  <hr class="sidebar-divider d-none d-md-block">

  <li class="nav-item">
    <a class="nav-link" href="gallery.php">
      <i class="fas fa-fw fa-images"></i>
      <span>Gallery Manager</span></a>
  </li>
  <hr class="sidebar-divider d-none d-md-block">

  <li class="nav-item">
    <a class="nav-link" href="ad.php">
      <i class="fas fa-fw fa-ad"></i>
      <span>Advertisement</span></a>
  </li>


  <!-- Divider -->
  <hr class="sidebar-divider d-none d-md-block">

  <!-- Sidebar Toggler (Sidebar) -->
  <div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
  </div>

</ul>
<!-- End of Sidebar -->