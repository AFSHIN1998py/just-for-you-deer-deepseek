<?php include "include/header.php";

$inputErrorName="";
$inputErrorComment="";
$success="";
if(isset($_POST['sendComment']))
{
    $name=$_POST['name'];
    $postid=$_POST['postid'];
    $comment=$_POST['comment'];
    
    if(empty($name))
    {
        $inputErrorName='لطفا نام خود را وارد کنید';
    }
    if(empty($comment))
    {
        $inputErrorComment='لطفا متن خود را وارد کنید';
    }
    if(!empty($name) && !empty($comment))
    {
        $insertComment=$conn->prepare("insert into comments (name,comment, post_id) values (:name, :comment, :postid)");
        $insertComment->execute(["name"=>$name, "comment"=>$comment, "postid"=>$postid]);
        $success='نظر شما ثبت و پس از تایید نمایش داده میشود';
    }

}

if(isset($_GET['postId'])){
    $postId=$_GET['postId'];
    $post=$conn->query("select * from posts where id=$postId")->fetch();
    $category_id=$post['category_id'];
    $category=$conn->query("select * from categories where id=$category_id")->fetch();
}

?>


            <main>
                <!-- Content -->
                <section class="mt-4">
                    <div class="row">
                        <!-- Posts & Comments Content -->
                        <div class="col-lg-8">
                            <div class="row justify-content-center">
                                <!-- Post Section -->
                                <div class="col">
                                    <div class="card">
                                        <img
                                        src="assets/images/<?= $post['image']?>"
                                            class="card-img-top"
                                            alt="post-image"
                                        />
                                        <div class="card-body">
                                            <div
                                                class="d-flex justify-content-between"
                                            >
                                                <h5 class="card-title fw-bold">
                                                 <?= $post['title']?>
                                                </h5>
                                                <div>
                                                    <span
                                                        class="badge text-bg-secondary"
                                                        ><?= $category['title'] ?></span
                                                    >
                                                </div>
                                            </div>
                                            <p
                                                class="card-text text-secondary text-justify pt-3"
                                            >
                                                <?= $post['body']; ?>
                                            </p>
                                            <div>
                                                <p class="fs-6 mt-5 mb-0">
                                                    نویسنده :<?= $post['author']?>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <hr class="mt-4" />

                                <!-- Comment Section -->
                                <div class="col">
                                    <!-- Comment Form -->
                                    <div class="card">
                                        <div class="card-body">
                                            <p class="fw-bold fs-5">
                                                ارسال کامنت
                                            </p>
                                            <?php if(!empty($success)): ?>
                                            <div class="alert alert-success"> <?=$success?> </div>
                                            <?php endif ?>
                                            <form method="post">
                                                <div class="mb-3">
                                                    <label class="form-label"
                                                        >نام</label
                                                    >
                                                    <input
                                                        type="text"
                                                        name="name"
                                                        class="form-control"
                                                    />
                                                    <?php if(!empty($inputErrorName)):?>
                                                    <div class="alert alert-danger"><?= $inputErrorName ?></div>
                                                    <?php endif ?>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label"
                                                        >متن کامنت</label
                                                    >
                                                    <textarea
                                                        class="form-control"
                                                        name="comment"
                                                        rows="3"
                                                    ></textarea>
                                                    <?php if(!empty($inputErrorComment)):?>
                                                    <div class="alert alert-danger"><?= $inputErrorComment ?></div>
                                                    <?php endif ?>
                                                </div>
                                                <input type="hidden" name="postid" value="<?= $postId?>" >
                                                <button
                                                    type="submit"
                                                    name="sendComment"
                                                    class="btn btn-dark"
                                                >
                                                    ارسال
                                                </button>
                                            </form>
                                        </div>
                                    </div>

                                    <hr class="mt-4" />
                                    <!-- Comment Content -->
                                    <?php 
                                    $comments=$conn->query("select * from comments where post_id=$postId and status=1");
                                    ?>
                                    <p class="fw-bold fs-6">تعداد کامنت : 
                                        <?php
                                        if($comments->rowCount() > 0)
                                        {            
                                            echo $comments->rowCount();
                                        }else
                                        {
                                            echo 0;
                                        }?>
                                    </p>
                                    <?php foreach($comments as $comment): ?>

                                    <div class="card bg-light-subtle mb-3">
                                        <div class="card-body">
                                            <div
                                                class="d-flex align-items-center"
                                            >
                                                <img
                                                    src="./assets/images/profile.png"
                                                    width="45"
                                                    height="45"
                                                    alt="user-profle"
                                                />

                                                <h5
                                                    class="card-title me-2 mb-0"
                                                >
                                                    <?= $comment['name']?>
                                                </h5>
                                            </div>

                                            <p class="card-text pt-3 pr-3">
                                                <?= $comment['comment']?>
                                            </p>
                                        </div>
                                    </div>
                                    <?php endforeach ?>

                                </div>
                            </div>
                        </div>

                        <!-- Sidebar Section -->
                        <?php include "include/sidebar.php"; ?>
                    </div>
                </section>
            </main>

            <!-- Footer -->
            <?php include "include/footer.php"; ?>
