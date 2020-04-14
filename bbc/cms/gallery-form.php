<?php
require_once 'inc/header.php';
require_once 'inc/checklogin.php';
$gallery = new Gallery;
$gallery_images = new GalleryImages;
$act = 'add';
if (isset($_GET, $_GET['id']) && !empty($_GET['id'])) {
    $act = "update";
    $id = (int) $_GET['id'];
    if ($id <= 0) {
        redirect('./gallery.php', 'error', "Invalid Categoory ID");
    }
    $gallery_info = $gallery->getRowById($id);
    if (!$gallery_info) {
        redirect('./gallery.php', 'error', "Gallery does not Exist or Deleted");
    }
    $all_images = $gallery_images->getAllGalleryImages($id);
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
                <h1 class="h3 mb-4 text-gray-800">Gallery <?php echo ucfirst($act); ?> Form
                </h1>
                <hr>
                <div class="row">
                    <div class="col-12">
                        <form action="process/gallery.php" method="post" enctype="multipart/form-data" class="form">
                            <div class="form-group row">
                                <label for="" class="col-sm-3">Title: </label>
                                <div class="col-sm-9">
                                    <input type="text" value="<?php echo @$gallery_info[0]->title ?>" id="title" required placeholder="Enter Gallery Title..." name="title" class="form-control form-control-sm">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="col-sm-3">Summary: </label>
                                <div class="col-sm-9">
                                    <textarea name="summary" id="summary" rows="5" placeholder="Enter Gallery Summary." style="resize:none;" class="form-control form-control-sm"><?php echo @$gallery_info[0]->summary ?></textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="col-sm-3">Staus:</label>
                                <div class="col-sm-9">
                                    <select name="status" id="status" required class="form-control from-control-sm">
                                        <option value="active" <?php echo (isset($gallery_info) && $gallery_info[0]->status == 'active') ? 'selected' : '' ?>>Active</option>
                                        <option value="inactive" <?php echo (isset($gallery_info) && $gallery_info[0]->status == 'inactive') ? 'selected' : '' ?>>In-Active</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="col-sm-3">Featured Image:</label>
                                <div class="col-sm-4">
                                    <input type="file" name="image" id="image" accept="image/*">
                                </div>
                                <div class="col-sm-4">
                                    <?php
                                    if ($act == 'update' && $gallery_info[0]->image != null && file_exists(UPLOAD_PATH . 'gallery/' . $gallery_info[0]->image)) {
                                    ?>
                                        <img src="<?php echo UPLOAD_URL . 'gallery/' . $gallery_info[0]->image; ?>" alt="" class="img img-fluid img-thumbnail">
                                    <?php
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="col-sm-3">Related Image:</label>
                                <div class="col-sm-4">
                                    <input type="file" name="related_images[]" multiple accept="image/*">
                                </div>
                            </div>
                            <?php
                            if (isset($all_images) && !empty($all_images)) {
                            ?>
                                <div class="form-group row">
                                    <?php
                                    foreach ($all_images as $gallery_image) {
                                    ?>
                                        <div class="col-3">
                                            <img src="<?php echo UPLOAD_URL . '/gallery/' . $gallery_image->image ?>" class="img img-fluid img-thumbnail">
                                            <input name="del_image[]" type="checkbox" value="<?php echo $gallery_image->image ?>">Delete
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
                                    <input type="hidden" name="gallery_id" value="<?php echo @$gallery_info[0]->id ?>">
                                    <input type="hidden" name="old_image" value="<?php echo @$gallery_info[0]->image ?>">
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