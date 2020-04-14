<?php
require_once 'inc/header.php';
require_once 'inc/checklogin.php';
$ad = new Advertisement;
$act = 'add';
if (isset($_GET, $_GET['id']) && !empty($_GET['id'])) {
    $act = "update";
    $id = (int) $_GET['id'];
    if ($id <= 0) {
        redirect('./ad.php', 'error', "Invalid Categoory ID");
    }
    $ad_info = $ad->getRowById($id);
    if (!$ad_info) {
        redirect('./ad.php', 'error', "Advertisement does not Exist or Deleted");
    }
    $ad_posn = $ad_postion->getAdvertisementByPosition($id);
}
?>
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
                <h1 class="h3 mb-4 text-gray-800">Advertisement <?php echo ucfirst($act); ?> Form
                </h1>
                <hr>
                <div class="row">
                    <div class="col-12">
                        <form action="process/ad.php" method="post" enctype="multipart/form-data" class="form">
                            <div class="form-group row">
                                <label for="" class="col-sm-3">Title: </label>
                                <div class="col-sm-9">
                                    <input type="text" value="<?php echo @$ad_info[0]->title ?>" id="title" required placeholder="Enter Advertisement Title..." name="title" class="form-control form-control-sm">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="col-sm-3">Link: </label>
                                <div class="col-sm-9">
                                    <textarea name="link" id="link" rows="5" placeholder="Enter Advertisement Link." style="resize:none;" class="form-control form-control-sm"><?php echo @$ad_info[0]->link ?></textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="col-sm-3">Staus:</label>
                                <div class="col-sm-9">
                                    <select name="status" id="status" required class="form-control from-control-sm">
                                        <option value="active" <?php echo (isset($ad_info) && $ad_info[0]->status == 'active') ? 'selected' : '' ?>>Active</option>
                                        <option value="inactive" <?php echo (isset($ad_info) && $ad_info[0]->status == 'inactive') ? 'selected' : '' ?>>In-Active</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="col-sm-3">Image:</label>
                                <div class="col-sm-4">
                                    <input type="file" name="image" id="image" accept="image/*">
                                </div>
                                <div class="col-sm-4">
                                    <?php
                                    if ($act == 'update' && $ad_info[0]->image != null && file_exists(UPLOAD_PATH . 'ad/' . $ad_info[0]->image)) {
                                    ?>
                                        <img src="<?php echo UPLOAD_URL . 'ad/' . $ad_info[0]->image; ?>" alt="" class="img img-fluid img-thumbnail">
                                    <?php
                                    }
                                    ?>
                                </div>
                            </div>
                    </div>
                    <?php
                    if (isset($ad_posn) && !empty($ad_posn)) {
                    ?>
                        <div class="form-group row">
                            <?php
                            foreach ($ad_posn as $ad_image) {
                            ?>
                                <div class="col-3">
                                    <img src="<?php echo UPLOAD_URL . '/ad/' . $ad_image->image ?>" class="img img-fluid img-thumbnail">
                                    <input name="del_image[]" type="checkbox" value="<?php echo $ad_image->image ?>">Delete
                                </div>
                            <?php
                            }
                            ?>
                        </div>
                    <?php
                    }
                    ?>
                    <div class="form-group row">
                        <div class="offset-3 col-sm-9">
                            <input type="hidden" name="ad_id" value="<?php echo @$ad_info[0]->id ?>">
                            <input type="hidden" name="old_image" value="<?php echo @$ad_info[0]->image ?>">
                            <button class="btn btn-danger" type="reset">
                                <i class="fa fa-trash">Re-set</i>
                            </button>
                            <button class="btn btn-success" type="submit">
                                <i class="fa fa-paper-plane">Submit</i>
                            </button>
                        </div>
                    </div>
                    </form>
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