<?php
require_once 'inc/header.php';
require_once 'inc/checklogin.php';
require_once 'inc/admin.php';
$users = new User;
$act = 'add';
if (isset($_GET, $_GET['id']) && !empty($_GET['id'])) {
    $act = "update";
    $id = (int) $_GET['id'];
    if ($id <= 0) {
        redirect('./users.php', 'error', "Invalid Categoory ID");
    }
    $user_info = $users->getRowById($id);
    if (!$user_info) {
        redirect('./users.php', 'error', "User does not Exist or Deleted");
    }
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
                <h1 class="h3 mb-4 text-gray-800">User <?php echo ucfirst($act); ?> Form
                </h1>
                <hr>
                <div class="row">
                    <div class="col-12">
                        <form action="process/users.php" method="post" enctype="multipart/form-data" class="form">
                            <div class="form-group row">
                                <label for="" class="col-sm-3">Name: </label>
                                <div class="col-sm-9">
                                    <input type="text" value="<?php echo @$user_info[0]->name ?>" id="title" required placeholder="Enter Your Name..." name="name" class="form-control form-control-sm">
                                </div>
                            </div>
                            <?php
                                if($act !== 'update'){?>
                            <div class="form-group row">
                                <label for="" class="col-sm-3">Email: </label>
                                <div class="col-sm-9">
                                    <input type="email" value="<?php echo @$user_info[0]->email ?>" id="email" required placeholder="Enter Your Email..." name="email" class="form-control form-control-sm">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="col-sm-3">Password: </label>
                                <div class="col-sm-9">
                                    <input type="password" id="password" required placeholder="Enter Your Password..." name="password" class="form-control form-control-sm">
                                    <span class="alert-danger" id="pass_error"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="col-sm-3">Re-Password: </label>
                                <div class="col-sm-9">
                                    <input type="password" id="re_password" required placeholder="Re-Enter Your Password..." name="re_password" class="form-control form-control-sm">
                                </div>
                            </div>
                                <?php } ?>
                            <div class="form-group row">
                                <label for="" class="col-sm-3">Staus:</label>
                                <div class="col-sm-9">
                                    <select name="status" id="status" required class="form-control from-control-sm">
                                        <option value="active" <?php echo (isset($user_info) && $user_info[0]->status == 'active') ? 'selected' : '' ?>>Active</option>
                                        <option value="inactive" <?php echo (isset($user_info) && $user_info[0]->status == 'inactive') ? 'selected' : '' ?>>In-Active</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="offset-3 col-sm-9">
                                    <input type="hidden" name="user_id" value="<?php echo @$user_info[0]->id ?>">
                                    <button class="btn btn-danger" type="reset">
                                        <i class="fa fa-trash">Re-set</i>
                                    </button>
                                    <button class="btn btn-success" type="submit" id='submit'>
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
<script>
    $('#re_password').keyup(function(){
        validatePassword();
    });
    function validatePassword(){
        var password = $('#password').val();
        var re_password = $('#re_password').val();
        if(password == re_password && password != ""){
            $('#pass_error').html('');
            $('#submit').removeAttr('disabled','disabled');
        }else{
            $('#pass_error').html('Password doesnot match');
            $('#submit').attr('disabled','disabled');
        }
    }
</script>