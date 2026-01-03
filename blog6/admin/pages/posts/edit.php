<?php include "../../includes/header.php"; 
$categories=$conn->query("select * from categories");
if(isset($_GET['id']))
{
    $id=$_GET['id'];
    $post=$conn->query("select * from posts where id=$id")->fetch();
}
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
    $id=$_POST['id'];
    if(empty($title))
        $inputErrorTitle="لطفا عنوان را وارد کنید";
    if(empty($author))
        $inputErrorAuthor="لطفا نویسنده را وارد کنید";
    if(empty($imageName))
        $inputErrorImage="لطفا عکس را وارد کنید";
    if(empty($body))
        $inputErrorBody="لطفا متن را وارد کنید";
    if(!empty($title) and !empty($author) and !empty($body))
    {   
        if(!empty($imageName))
        {   
            $imageOld=$post['image'];
            unlink("../../../assets/images/$imageOld");
            $imageName=time().$imageName;
            move_uploaded_file($imageTmpName, "../../../assets/images/$imageName");
            $updatePost=$conn->query("UPDATE `posts` SET `title`='$title',`body`='$body',`category_id`='$category',`author`='$author',`image`='$imageName' WHERE  id=$id");
        }
        else{
            $updatePost=$conn->query("UPDATE `posts` SET `title`='$title',`body`='$body',`category_id`='$category',`author`='$author' WHERE  id=$id");
        }

        header("Location:index.php");
        exit;
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
                                <input type="text" value="<?= $post['title']?>" name="title" class="form-control" />
                                <?php if(!empty($inputErrorTitle)): ?>
                                <div class="alert alert-danger"> <?= $inputErrorTitle ?> </div>
                                <?php endif ?>
                            </div>

                            <div class="col-12 col-sm-6 col-md-4">
                                <label class="form-label">نویسنده مقاله</label>
                                <input type="text" value="<?= $post['author']?>" name="author" class="form-control" />
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
                                    <option 
                                    <?php
                                    if($category['id']==$post['category_id'])
                                        echo " selected "
                                    ?>
                                    value="<?= $category['id'] ?>"><?= $category['title'] ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>

                            <div class="col-12 col-sm-6 col-md-4">
                                <label for="formFile" class="form-label"
                                    >تصویر مقاله</label
                                >
                                <input class="form-control" name="image" type="file" />
                                <img src="../../../assets/images/<?= $post['image']?>" width="45" height="45" alt="">
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
                                    ><?= $post['body']?></textarea>
                                <?php if(!empty($inputErrorBody)): ?>
                                <div class="alert alert-danger"> <?= $inputErrorBody ?> </div>
                                <?php endif ?>
                            </div>

                            <div class="col-12">
                                <input type="hidden" name="id" value="<?=$id ?>">
                                <button type="submit" name="sendPost" class="btn btn-dark">
                                     ویرایش
                                </button>
                            </div>
                        </form>
                    </div>
                </main>
            </div>
        </div>

        <?php include "../../includes/footer.php"; ?>