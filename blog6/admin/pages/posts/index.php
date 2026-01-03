<?php include "../../includes/header.php";
$posts=$conn->query("select * from posts");
if(isset($_GET['id']) and isset($_GET['table']))
{
    deleting($_GET['id'],$_GET['table']);
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
                        <h1 class="fs-3 fw-bold">پست ها</h1>

                        <div class="btn-toolbar mb-2 mb-md-0">
                            <a href="./create.php" class="btn btn-sm btn-dark">
                                ایجاد پست
                            </a>
                        </div>
                    </div>

                    <!-- posts -->
                    <div class="mt-4">
                        <h4 class="text-secondary fw-bold"></h4>
                        <div class="table-responsive small">
                            <table class="table table-hover align-middle">
                                <thead>
                                    <tr>
                                        <th>ردیف</th>
                                        <th>id</th>
                                        <th>عنوان</th>
                                        <th>نویسنده</th>
                                        <th>عملیات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $row=1;
                                    foreach($posts as $post): ?>
                                    <tr>
                                    <th>
                                        <?= $row++ ?></th>
                                        <td><?= $post['id']?></td>
                                        <td><?= $post['title']?></td>
                                        <td><?= $post['author']?></td>
                                        <td>
                                            <a
                                                href="edit.php?id=<?= $post['id']?>"
                                                class="btn btn-sm btn-outline-dark"
                                                >ویرایش</a
                                            >
                                            <a
                                                href="index.php?id=<?= $post['id']?>&table=posts"                                                class="btn btn-sm btn-outline-danger"
                                                >حذف</a
                                            >
                                        </td>
                                    </tr>
                                    <?php endforeach ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </main>
            </div>
        </div>

        <?php include "../../includes/footer.php";?>
