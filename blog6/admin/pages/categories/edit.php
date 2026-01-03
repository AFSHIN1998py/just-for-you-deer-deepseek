<?php include "../../includes/header.php"; 
if(isset($_GET['id']))
{
    $id=$_GET['id'];
    $category=$conn->query("select * from categories where id=$id")->fetch();
}

$inputErrorTitle='';

if(isset($_POST['editCategory']))
{
    $title=$_POST['title'];
    $id=$_POST['id'];
    if(empty($title))
        $inputErrorTitle="لطفا عنوان را وارد کنید";
    else{
        $updateCategory=$conn->prepare("update categories set title=:title where id=:id");
        $updateCategory->execute(["title"=>$title, "id"=>$id]);
        header("Location:index.php");
    }
}
?>

        <div class="container-fluid">
            <div class="row">
                <!-- Sidebar Section -->
                <?php include "../../includes/sidebar.php"; ?>

                <!-- Main Section -->
                <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                    <div
                        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom"
                    >
                        <h1 class="fs-3 fw-bold">ویرایش دسته بندی</h1>
                    </div>

                    <!-- Posts -->
                    <div class="mt-4">
                        <form class="row g-4" method="post">
                            <div class="col-12 col-sm-6 col-md-4">
                                <label class="form-label">عنوان دسته بندی</label>
                                <input type="text" name="title" class="form-control" value="<?= $category['title']?>" />
                            </div>
                            <?php if(!empty($inputErrorTitle)): ?>
                            <div class="alert alert-danger"> <?= $inputErrorTitle ?> </div>
                            <?php endif ?>

                            <div class="col-12">
                                <input type="hidden" name="id" value="<?=$id ?>">
                                <button type="submit" name="editCategory" class="btn btn-dark">
                                 ویرایش  
                                </button>
                            </div>
                        </form>
                    </div>
                </main>
            </div>
        </div>

        <?php include "../../includes/footer.php"; ?>