<?php
require_once 'inc/header.php';
require_once 'inc/checklogin.php';

$news = new News;

$act = 'add';
if (isset($_GET, $_GET['id']) && !empty($_GET['id'])) {
    $act = "update";
    $id = (int) $_GET['id'];
    if ($id <= 0) {
        redirect('./news.php', 'error', "Invalid Categoory ID");
    }

    $news_info = $news->getRowById($id);
    if (!$news_info) {
        redirect('./news.php', 'error', "News does not Exist or Deleted");
    }
}
?>
<link rel="stylesheet" href="<?php echo ADMIN_CSS_URL . '/summernote-bs4.min.css' ?>">

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
                <h1 class="h3 mb-4 text-gray-800">News <?php echo ucfirst($act); ?> Form
                </h1>
                <hr>
                <div class="row">
                    <div class="col-12">
                        <form action="process/news.php" method="post" enctype="multipart/form-data" class="form">
                            <div class="form-group row">
                                <label for="" class="col-sm-3">Title: </label>
                                <div class="col-sm-9">
                                    <input type="text" value="<?php echo @$news_info[0]->title ?>" id="title" required placeholder="Enter News Title..." name="title" class="form-control form-control-sm">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="col-sm-3">Summary: </label>
                                <div class="col-sm-9">
                                    <textarea name="summary" id="summary" required rows="5" placeholder="Enter News Summary." style="resize:none;" class="form-control form-control-sm"><?php echo @$news_info[0]->summary ?></textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="col-sm-3">Description: </label>
                                <div class="col-sm-9">
                                    <textarea name="description" id="description" rows="5" placeholder="Enter News Description." class="form-control form-control-sm"><?php echo @$news_info[0]->description ?></textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="col-sm-3">Category:</label>
                                <div class="col-sm-9">
                                    <select name="cat_id" id="cat_id" required class="form-control from-control-sm">
                                        <option value="" disabled selected>-- Select Any One --</option>
                                        <?php
                                        $category = new Category;
                                        $all_cats = $category->getAllRows();
                                        if ($all_cats) {
                                            foreach ($all_cats as $cat_info) {
                                        ?>
                                                <option value="<?php echo $cat_info->id ?>" <?php echo (isset($news_info) && $news_info[0]->cat_id == $cat_info->id) ? 'selected' : '' ?>>
                                                    <?php echo $cat_info->title; ?>
                                                </option>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="col-sm-3">States:</label>
                                <div class="col-sm-9">
                                    <select name="state" id="state" required class="form-control from-control-sm">
                                        <?php
                                        foreach ($state as $db_key => $state_name) {
                                        ?>
                                            <option value="<?php echo $db_key ?>" <?php echo (isset($news_info) && $news_info[0]->state == $db_key) ? 'selected' : '' ?>>
                                                <?php echo $state_name ?>
                                            </option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="col-sm-3">Location: </label>
                                <div class="col-sm-9">
                                    <input type="text" value="<?php echo @$news_info[0]->location ?>" id="location" placeholder="Enter News Location..." name="location" class="form-control form-control-sm">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="col-sm-3">Date: </label>
                                <div class="col-sm-9">
                                    <input type="date" value="<?php echo @$news_date[0]->date ?>" id="news_date" required placeholder="Enter News date..." name="news_date" class="form-control form-control-sm">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="col-sm-3">Source: </label>
                                <div class="col-sm-9">
                                    <input type="text" value="<?php echo @$news_info[0]->source ?>" id="source" placeholder="Enter News Source..." name="source" class="form-control form-control-sm">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="col-sm-3">Is Featured: </label>
                                <div class="col-sm-9">
                                    <input type="checkbox" name="is_featured" value="1"> Yes
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="col-sm-3">Status:</label>
                                <div class="col-sm-9">
                                    <select name="status" id="status" required class="form-control from-control-sm">
                                        <option value="active" <?php echo (isset($news_info) && $news_info[0]->status == 'active') ? 'selected' : '' ?>>Active</option>
                                        <option value="inactive" <?php echo (isset($news_info) && $news_info[0]->status == 'inactive') ? 'selected' : '' ?>>In-Active</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="col-sm-3">Reporter:</label>
                                <div class="col-sm-9">
                                    <select name="reporter_id" id="reporter_id" required class="form-control from-control-sm">
                                        <option value="" disabled selected>-- Select Any one --</option>
                                        <?php
                                        $user = new User;
                                        $all_reporter = $user->getUserByType('reporter');
                                        if ($all_reporter) {
                                            foreach ($all_reporter as $user_info) {
                                        ?>
                                                <option value="<?php echo $user_info->id ?>" <?php echo (isset($news_info) && $news_info[0]->reporter_id == $user_info->id) ? 'selected' : '' ?>>
                                                    <?php echo $user_info->name; ?>
                                                </option>
                                        <?php
                                            }
                                        }
                                        ?>
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
                                    if ($act == 'update' && $news_info[0]->image != null && file_exists(UPLOAD_PATH . 'news/' . $news_info[0]->image)) {
                                    ?>
                                        <img src="<?php echo UPLOAD_URL . 'news/' . $news_info[0]->image; ?>" alt="" class="img img-fluid img-thumbnail">
                                    <?php
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="offset-3 col-sm-9">
                                    <input type="hidden" name="news_id" value="<?php echo @$news_info[0]->id ?>">
                                    <input type="hidden" name="old_image" value="<?php echo @$news_info[0]->image ?>">
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
<script src="<?php echo ADMIN_JS_URL . '/summernote-bs4.min.js' ?>"></script>
<script>
    $('#description').summernote({
        height: 200
    });
</script>