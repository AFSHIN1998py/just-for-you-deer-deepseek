<?php include "includes/header.php";
$products=$conn->query("select * from products");
$users=$conn->query("select * from users");
$orders=$conn->query("select * from orders");
$order_items=$conn->query("select * from order_items");


?>


        <div class="container-fluid">
            <div class="row">
                <!-- Sidebar Section -->
                <?php include "includes/sidebar.php"; ?>

                <!-- Main Section -->
                <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                    <div
                        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom"
                    >
                        <h1 class="fs-3 fw-bold">تعداد کربران(<?= $users->rowCount() ?>)</h1>
                        <h1 class="fs-3 fw-bold">تعداد کالا($)</h1>
                        <h1 class="fs-3 fw-bold">سفارشات(<?= $orders->rowCount() ?>)</h1>
                    </div>

                    <!-- Recently Posts -->
                    <div class="mt-4">
                        <h4 class="text-secondary fw-bold">مقالات اخیر</h4>
                        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                            <h1 class="fs-3 fw-bold">سفارشات(<?= $orders->rowCount() ?>)</h1>
                            <table class="table table-hover align-middle">
                                <thead>
                                    <tr>
                                        <th>ردیف</th>
                                        <th>نام و نام خانوادگی</th>
                                        <th>تاریخ</th>
                                        <th>سفارشات</th>
                                        <th>عملیات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $row=1;  
                                    foreach($orders as $order): ?>    
                                    <tr>
                                        <td><?= $row++ ?></td>
                                        <td></td>
                                        <td><?= $order['date'] ?></td>
                                        <td>محمد رضا ملک</td>
                                        <td>
                                            <a
                                                href="#"
                                                class="btn btn-sm btn-outline-dark"
                                                >مشاهده</a
                                            >
                                        </td>
                                    </tr>
                                        
                                    <?php endforeach ?>
                                </tbody>
                            </table>
                        </div>
                    </div><br><br><br>

                    <!-- Recently Comments -->

                    <!-- Categories -->
                    <div class="mt-4">
                        <h4 class="text-secondary fw-bold">دسته بندی</h4>
                        <div class="table-responsive small">
                            <table class="table table-hover align-middle">
                                <thead>
                                    <tr>
                                        <th>ردیف</th>
                                        <th>نام و نام خانوادگی</th>
                                        <th>تاریخ</th>
                                        <th>سفارشات</th>
                                        <th>عملیات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th>1</th>
                                        <th>علی کریمی</th>
                                        <th>10.10.1444</th>
                                        <td>11</td>
                                        <td>
                                            <a
                                                href="#"
                                                class="btn btn-sm btn-outline-dark"
                                                >مشاهده</a
                                            >
                                            <a
                                                href="#"
                                                class="btn btn-sm btn-outline-danger"
                                                >حذف</a
                                            >
                                        </td>
                                    </tr>
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </main>
            </div>
        </div>
        <?php include "includes/footer.php"; ?>
