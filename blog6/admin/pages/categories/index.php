<?php include "../../includes/header.php";
$categories=$conn->query("select * from categories");
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
                        <h1 class="fs-3 fw-bold">دسته بندی ها</h1>

                        <div class="btn-toolbar mb-2 mb-md-0">
                            <a href="./create.php" class="btn btn-sm btn-dark">
                                ایجاد دسته بندی
                            </a>
                        </div>
                    </div>

                    <!-- Categories -->
                    <div class="mt-4">
                        <h4 class="text-secondary fw-bold"></h4>
                        <div class="table-responsive small">
                            <table class="table table-hover align-middle">
                                <thead>
                                    <tr>
                                        <th>ردیف</th>
                                        <th>id</th>
                                        <th>عنوان</th>
                                        <th>عملیات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $row=1;
                                    foreach($categories as $category): ?>
                                    <tr>
                                    <th>
                                        <?= $row++ ?></th>
                                        <td><?= $category['id']?></td>
                                        <td><?= $category['title']?></td>
                                        <td>
                                            <a
                                                href="edit.php?id=<?= $category['id']?>"
                                                class="btn btn-sm btn-outline-dark"
                                                >ویرایش</a
                                            >
                                            <a
                                                href="index.php?id=<?= $category['id']?>&table=categories"                                                class="btn btn-sm btn-outline-danger"
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
