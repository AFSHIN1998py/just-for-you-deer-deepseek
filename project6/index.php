<?php
include "includes/header.php";



// بررسی لاگین
if(!isset($_SESSION['user_id'])) {
    header("Location: pages/auth/login.php");
    exit();
}

// آمارهای مورد نیاز
$total_users = $conn->query("SELECT COUNT(*) as total FROM users")->fetch(PDO::FETCH_ASSOC)['total'];
$total_products = $conn->query("SELECT COUNT(*) as total FROM products")->fetch(PDO::FETCH_ASSOC)['total'];
$total_orders = $conn->query("SELECT COUNT(*) as total FROM orders")->fetch(PDO::FETCH_ASSOC)['total'];
?>

<!DOCTYPE html>
<html dir="rtl" lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>داشبورد فروشگاه</title>
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <!-- استایل‌های خاص شما -->
</head>
<body>
    <!-- هدر سایت -->

    <div class="container-fluid">
        <div class="row">
            <!-- سایدبار -->
            <?php include "includes/sidebar.php"; ?>

            <!-- محتوای اصلی -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between pt-3 pb-2 mb-3 border-bottom">
                    <h2>داشبورد</h2>
                </div>

                <!-- ۳ کارت آمار -->
                <div class="row mb-4">
                    <div class="col-md-4 mb-3">
                        <div class="card">
                            <div class="card-body text-center">
                                <h5 class="card-title">کاربران</h5>
                                <h3><?php echo $total_users; ?></h3>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-4 mb-3">
                        <div class="card">
                            <div class="card-body text-center">
                                <h5 class="card-title">کالاها</h5>
                                <h3><?php echo $total_products; ?></h3>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-4 mb-3">
                        <div class="card">
                            <div class="card-body text-center">
                                <h5 class="card-title">سفارشات کل</h5>
                                <h3><?php echo $total_orders; ?></h3>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- جدول سفارشات تایید نشده -->
                <?php
                $pending_orders = $conn->query("
                    SELECT o.id, u.fullname, o.date, 
                           (SELECT COUNT(*) FROM order_items WHERE order_id = o.id) as items_count
                    FROM orders o 
                    JOIN users u ON o.user_id = u.id 
                    WHERE o.status = 0 
                    ORDER BY o.date DESC 
                    LIMIT 10
                ");
                ?>
                
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">آخرین سفارشات (تایید نشده)</h5>
                        <a href="pages/orders/" class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-list"></i> مشاهده همه
                        </a>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th width="60">ردیف</th>
                                        <th>نام و نام خانوادگی</th>
                                        <th>تاریخ ثبت سفارش</th>
                                        <th>تعداد اقلام</th>
                                        <th width="120">عملیات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if($pending_orders->rowCount() > 0): ?>
                                        <?php 
                                        $counter = 1;
                                        while($order = $pending_orders->fetch(PDO::FETCH_ASSOC)): 
                                        ?>
                                        <tr>
                                            <td><?php echo $counter++; ?></td>
                                            <td><?php echo $order['fullname']; ?></td>
                                            <td><?php echo date('Y/m/d - H:i', strtotime($order['date'])); ?></td>
                                            <td>
                                                <span class="badge bg-info"><?php echo $order['items_count']; ?> عدد</span>
                                            </td>
                                            <td>
                                                <a href="pages/orders/view.php?id=<?php echo $order['id']; ?>" 
                                                   class="btn btn-sm btn-outline-primary">
                                                    <i class="bi bi-eye"></i> مشاهده
                                                </a>
                                            </td>
                                        </tr>
                                        <?php endwhile; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="5" class="text-center text-muted py-4">
                                                هیچ سفارش تایید نشده‌ای وجود ندارد.
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- اسکریپت‌های Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>