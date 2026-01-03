<?php include "../../includes/header.php"; 
$categories=$conn->query("select * from categories");
$inputErrorTitle='';
$inputErrorAuthor='';
$inputErrorImage='';
$inputErrorBody='';

if(isset($_POST['sendPost']))
{
    $title=$_POST['title'];
    $author=$_POST['author'];
    $category=$_POST['category'];
    $imageName=$_FILES['image']['name'];
    $imageTmpName=$_FILES['image']['tmp_name'];
    $body=$_POST['body'];
    if(empty($title))
        $inputErrorTitle="لطفا عنوان را وارد کنید";
    if(empty($author))
        $inputErrorAuthor="لطفا نویسنده را وارد کنید";
    if(empty($imageName))
        $inputErrorImage="لطفا عکس را وارد کنید";
    if(empty($body))
        $inputErrorBody="لطفا متن را وارد کنید";
    if(!empty($title) and !empty($author) and !empty($imageName) and !empty($body))
    {
        $imageName=$imageName.time();
        move_uploaded_file($imageTmpName, "../../../assets/images/ $imageName");
        $creatPost=$conn->prepare("insert into posts (title,body,author,image,category_id) values(:title,:body,:author,:image,:category)");
        $creatPost->execute(["title"=>$title,"body"=>$body,"author"=>$author,"image"=>$imageName,"category"=>$category]);
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
                        <h1 class="fs-3 fw-bold">ایجاد مقاله</h1>
                    </div>

                    <!-- Posts -->
                    <div class="mt-4">
                        <form class="row g-4" method="post" enctype="multipart/form-data">
                            <div class="col-12 col-sm-6 col-md-4">
                                <label class="form-label">عنوان مقاله</label>
                                <input type="text" name="title" class="form-control" />
                                <?php if(!empty($inputErrorTitle)): ?>
                                <div class="alert alert-danger"> <?= $inputErrorTitle ?> </div>
                                <?php endif ?>
                            </div>

                            <div class="col-12 col-sm-6 col-md-4">
                                <label class="form-label">نویسنده مقاله</label>
                                <input type="text" name="author" class="form-control" />
                                <?php if(!empty($inputErrorAuthor)): ?>
                                <div class="alert alert-danger"> <?= $inputErrorAuthor ?> </div>
                                <?php endif ?>
                            </div>

                            <div class="col-12 col-sm-6 col-md-4">
                                <label class="form-label"
                                    >دسته بندی مقاله</label
                                >
                                <select class="form-select" name="category">
                                    <?php foreach($categories as $category): ?>
                                    <option value="<?= $category['id'] ?>"><?= $category['title'] ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>

                            <div class="col-12 col-sm-6 col-md-4">
                                <label for="formFile" class="form-label"
                                    >تصویر مقاله</label
                                >
                                <input class="form-control" name="image" type="file" />
                                <?php if(!empty($inputErrorImage)): ?>
                                <div class="alert alert-danger"> <?= $inputErrorImage ?> </div>
                                <?php endif ?>
                            </div>

                            <div class="col-12">
                                <label for="formFile" class="form-label"
                                    >متن مقاله</label
                                >
                                <textarea
                                    class="form-control"
                                    name="body"
                                    rows="6"
                                ></textarea>
                                <?php if(!empty($inputErrorBody)): ?>
                                <div class="alert alert-danger"> <?= $inputErrorBody ?> </div>
                                <?php endif ?>
                            </div>

                            <div class="col-12">
                                <button type="submit" name="sendPost" class="btn btn-dark">
                                     ایجاد
                                </button>
                            </div>
                        </form>
                    </div>
                </main>
            </div>
        </div>

        <?php include "../../includes/footer.php"; ?>