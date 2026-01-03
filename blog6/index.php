<?php include "include/header.php";

if(isset($_GET['categoryId'])){
    $categoryId=$_GET['categoryId'];
    $posts=$conn->query("select * from posts where category_id=$categoryId");
}else
{
    $posts=$conn->query("select * from posts");
} 
?>

            <main>
                <!-- Slider Section -->
                <?php include "include/slider.php"; ?>

                <!-- Content Section -->
                <section class="mt-4">
                    <div class="row">
                        <!-- Posts Content -->
                        <div class="col-lg-8">
                            <?php if($posts->rowCount()>=1): ?>
                            <div class="row g-3">
                                <?php foreach($posts as $post):
                                    $category_id=$post['category_id'];
                                    $category=$conn->query("select * from categories where id=$category_id")->fetch();                
                                ?>
                                <div class="col-sm-6">
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
                                                class="card-text text-secondary pt-3"
                                            >
                                                <?= substr($post['body'],0,255);?>
                                            </p>
                                            <div
                                                class="d-flex justify-content-between align-items-center"
                                            >
                                                <a
                                                    href="single.php?postId=<?= $post['id'] ?>"
                                                    class="btn btn-sm btn-dark"
                                                    >مشاهده</a
                                                >

                                                <p class="fs-7 mb-0">
                                                   نویسنده :<?= $post['author']?>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                
                                </div>
                                <?php endforeach ?>
                            </div>
                            
                            <?php else: ?>
                                <div class="row g-3">
                                    <div class="alert alert-danger" role="alert">
                                        مطلب مورد نظر یافت نشد!!!
                                    </div>
                                </div>
                            <?php endif ?>
                        </div>

                        <!-- Sidebar Section -->
                        <?php include "include/sidebar.php"; ?>
                    </div>
                </section>
            </main>

            <!-- Footer Section -->
            <?php include "include/footer.php"; ?>
