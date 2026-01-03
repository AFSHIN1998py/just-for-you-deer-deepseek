<?php include "../../includes/header.php";
$comments=$conn->query("select * from comments");
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
                        <h1 class="fs-3 fw-bold">کامنت ها</h1>
                    </div>

                    <!-- Comments -->
                    <div class="mt-4">
                        <h4 class="text-secondary fw-bold">کامنت های اخیر</h4>
                        <div class="table-responsive small">
                            <table class="table table-hover align-middle">
                                <thead>
                                    <tr>
                                        <th>ردیف</th>
                                        <th>id</th>
                                        <th>نام</th>
                                        <th>متن کامنت</th>
                                        <th>عملیات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $row=1;
                                    foreach($comments as $comment): ?>
                                    <tr>
                                        <th><?= $row++ ?></th>
                                        <td><?= $comment['id']?></td>
                                        <td><?= $comment['name']?></td>
                                        <td><?= $comment['comment']?></td>
                                        <td> 
                                            <?php if($comment['status']==1): ?>
                                            <a
                                                href="#"
                                                class="btn btn-sm btn-outline-dark disabled"
                                                >تایید شده</a
                                            >
                                            <?php else: ?>
                                            <a
                                                href="index.php?commentid=<?=$comment['id'] ?>"
                                                class="btn btn-sm btn-outline-info"
                                                >در انتظار تایید</a
                                            >
                                            <?php endif ?>
                                            <a
                                                href="index.php?id=<?= $comment['id']?>&table=comments"
                                                class="btn btn-sm btn-outline-danger"
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

        <script
            src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm"
            crossorigin="anonymous"
        ></script>
    </body>
</html>
