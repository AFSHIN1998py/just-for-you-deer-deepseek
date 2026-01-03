<?php include "../../includes/header.php"; 
$inputErrorTitle='';

if(isset($_POST['sendCategory']))
{
    $title=$_POST['title'];
    if(empty($title))
        $inputErrorTitle="لطفا عنوان را وارد کنید";
    else{
        $creatCategory=$conn->prepare("insert into categories (title) values(:title)");
        $creatCategory->execute(["title"=>$title]);
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
                        <h1 class="fs-3 fw-bold">ایجاد دسته بندی</h1>
                    </div>

                    <!-- Posts -->
                    <div class="mt-4">
                        <form class="row g-4" method="post">
                            <div class="col-12 col-sm-6 col-md-4">
                                <label class="form-label">عنوان دسته بندی</label>
                                <input type="text" name="title" class="form-control" />
                            </div>
                            <?php if(!empty($inputErrorTitle)): ?>
                            <div class="alert alert-danger"> <?= $inputErrorTitle ?> </div>
                            <?php endif ?>

                            <div class="col-12">
                                <button type="submit" name="sendCategory" class="btn btn-dark">
                                     ایجاد
                                </button>
                            </div>
                        </form>
                    </div>
                </main>
            </div>
        </div>

        <?php include "../../includes/footer.php"; ?>