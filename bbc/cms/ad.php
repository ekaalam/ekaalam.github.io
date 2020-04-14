<?php
require_once 'inc/header.php';
require_once 'inc/checklogin.php';
$ad = new Advertisement;
?>
<link rel="stylesheet" href="<?php echo ADMIN_CSS_URL . '/datatables.min.css' ?>">
<!-- Page Wrapper -->
<div id="wrapper">
  <?php require_once 'inc/sidebar.php'; ?>
  <!-- Content Wrapper -->
  <div id="content-wrapper" class="d-flex flex-column">
    <!-- Main Content -->
    <div id="content">
      <?php require_once 'inc/topnav.php'; ?>
      <!-- Begin Page Content -->
      <div class="container-fluid">
        <?php flash(); ?>
        <!-- Page Heading -->
        <h1 class="h3 mb-4 text-gray-800">Advertisement List
          <a href="ad-form.php" class="btn btn-sm btn-success float-right">
            <i class="fa fa-plus"> Add Advertisement</i>
          </a>
        </h1>
        <hr>
        <div class="row">
          <div class="col-12">
            <table class="table table-hover table-sm">
              <thead class="thead-dark">
                <th>S.N</th>
                <th>Title</th>
                <th>Link</th>
                <th>Postion</th>
                <th>Status</th>
                <th>Created at</th>
                <th>Action</th>
              </thead>
              <tbody>
                <?php
                $all_rows = $ad->getAllRows();
                if ($all_rows) {
                  foreach ($all_rows as $key => $ad_info) {
                ?>
                    <tr>
                      <td><?php echo $key + 1 ?></td>
                      <td><?php echo $ad_info->title ?></td>
                      <td><?php echo $ad_info->link ?></td>
                      <td>
                        <span class="badage badge-<?php echo ($ad_info->status == 'active') ? 'success' : 'danger' ?>"><?php echo ucfirst($ad_info->status) ?></span>
                      </td>
                      <td><?php echo date("Y-m-d", strtotime($ad_info->created_at)) ?></td>
                      <td>
                        <a href="ad-form.php?id=<?php echo $ad_info->id; ?>" class="btn btn-success btn-sm" style="border-radius: 50%;">
                          <i class="fa fa-edit"></i>
                        </a>
                        <a href="process/ad.php?id=<?php echo $ad_info->id; ?>" onclick="return confirm('Are you sure you want to delete this ad?');" class="btn btn-danger btn-sm" style="border-radius: 50%;">
                          <i class="fa fa-trash"></i>
                        </a>
                      </td>
                    </tr>
                <?php
                  }
                }
                ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <!-- /.container-fluid -->
    </div>
    <!-- End of Main Content -->
    <?php require_once 'inc/copy.php'; ?>
  </div>
  <!-- End of Content Wrapper -->
</div>
<!-- End of Page Wrapper -->
<?php require_once 'inc/logoutmodal.php'; ?>
<?php require_once 'inc/footer.php'; ?>
<script src="<?php echo ADMIN_JS_URL . '/datatables.min.js' ?>"></script>
<script>
  $('.table').DataTable();
</script>