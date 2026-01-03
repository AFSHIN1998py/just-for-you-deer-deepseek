<?php include "include/header.php";
if(isset($_POST['search']))
{
    $keyword=$_POST['keyword'];
    $search=$conn->prepare("select * from posts where title like :keyword");
    $search->execute(["keyword"=>"%$keyword%"]);
}
?>

            <main>
                <!-- Content Section -->
                <section class="mt-4">
                    <div class="row">
                        <div class="row">
                                <div class="col">
                                    <div class="alert alert-secondary">
                                        پست های مرتبط با کلمه [ <?= $keyword ?> ]
                                    </div>
                                    <?php if(empty($search->rowCount())): ?>
                                    <div class="alert alert-danger">
                                        مقاله مورد نظر پیدا نشد !!!!
                                    </div>
                                    <?php endif ?>
                                </div>
                        </div>
                        <!-- Posts Content -->
                        <div class="col-lg-8">
                            <div class="row g-3">
                                <?php foreach($search as $post):
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
                        </div>

                        <!-- Sidebar Section -->
                        <?php include "include/sidebar.php"; ?>
                    </div>
                </section>
            </main>

            <!-- Footer Section -->
            <?php include "include/footer.php"; ?>
