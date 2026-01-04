<?php
// pages/products/index.php
include "../../includes/header.php";

// --- 1. آماده‌سازی پارامترهای فیلتر ---
$search = $_GET['search'] ?? '';
$category_id = $_GET['category'] ?? '';
$status = $_GET['status'] ?? '';

// --- 2. دریافت لیست دسته‌بندی‌ها برای dropdown ---
$categories = $conn->query("SELECT id, title FROM categories WHERE status=1 ORDER BY title");

// --- 3. ساخت شرط‌های دینامیک کوئری ---
$conditions = [];
$params = [];

if (!empty($search)) {
    $conditions[] = "p.title LIKE ?";
    $params[] = "%$search%";
}

if (!empty($category_id) && $category_id != 'all') {
    $conditions[] = "p.category_id = ?";
    $params[] = $category_id;
}

if (!empty($status) && $status != 'all') {
    $conditions[] = "p.status = ?";
    $params[] = ($status == 'active') ? 1 : 0;
}

$where_sql = '';
if (!empty($conditions)) {
    $where_sql = 'WHERE ' . implode(' AND ', $conditions);
}

// --- 4. اجرای کوئری اصلی با فیلترها ---
$sql = "SELECT p.*, c.title as cat_name 
        FROM products p 
        LEFT JOIN categories c ON p.category_id = c.id 
        $where_sql 
        ORDER BY p.id DESC";

if (!empty($params)) {
    $stmt = $conn->prepare($sql);
    $stmt->execute($params);
    $products = $stmt;
} else {
    $products = $conn->query($sql);
}

// --- 5. عملیات حذف شرطی (فقط اگر محصول در سفارشات نباشد) ---
if(isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    
    // بررسی اینکه آیا محصول در order_items وجود دارد یا نه
    $check_sql = "SELECT COUNT(*) as order_count FROM order_items WHERE product_id = $delete_id";
    $check_result = $conn->query($check_sql);
    $order_count = $check_result->fetch(PDO::FETCH_ASSOC)['order_count'];
    
    if($order_count == 0) {
        // اگر محصول در هیچ سفارشی نیست، حذف شود
        $conn->query("DELETE FROM products WHERE id = $delete_id");
        echo "<script>alert('محصول با موفقیت حذف شد!'); window.location='index.php';</script>";
    } else {
        // اگر محصول در سفارشات است، پیغام خطا نمایش داده شود
        echo "<script>alert('⚠️ این محصول در سفارشات استفاده شده و قابل حذف نیست!'); window.location='index.php';</script>";
    }
}
?>

<!-- محتوای اصلی -->
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between pt-3 pb-2 mb-3 border-bottom">
        <h2>مدیریت محصولات</h2>
        <a href="create.php" class="btn btn-success btn-sm">
            <i class="bi bi-plus-circle"></i> افزودن محصول
        </a>
    </div>

    <!-- --- نوار فیلتر پیشرفته --- -->
    <div class="card mb-4 border-primary">
        <div class="card-header bg-light">
            <h5 class="mb-0"><i class="bi bi-funnel"></i> فیلتر محصولات</h5>
        </div>
        <div class="card-body">
            <form method="GET" class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">عنوان محصول</label>
                    <input type="text" name="search" class="form-control" 
                           placeholder="جستجو..." value="<?php echo htmlspecialchars($search); ?>">
                </div>

                <div class="col-md-3">
                    <label class="form-label">دسته‌بندی</label>
                    <select name="category" class="form-select">
                        <option value="all">-- همه دسته‌بندی‌ها --</option>
                        <?php while($cat = $categories->fetch(PDO::FETCH_ASSOC)): ?>
                            <option value="<?php echo $cat['id']; ?>" 
                                <?php echo ($category_id == $cat['id']) ? 'selected' : ''; ?>>
                                <?php echo $cat['title']; ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label">وضعیت</label>
                    <select name="status" class="form-select">
                        <option value="all">-- همه وضعیت‌ها --</option>
                        <option value="active" <?php echo ($status == 'active') ? 'selected' : ''; ?>>فعال</option>
                        <option value="inactive" <?php echo ($status == 'inactive') ? 'selected' : ''; ?>>غیرفعال</option>
                    </select>
                </div>

                <div class="col-md-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-funnel-fill"></i> اعمال فیلتر
                    </button>
                </div>
            </form>
            
            <?php if(!empty($search) || !empty($category_id) || !empty($status)): ?>
            <div class="mt-3">
                <a href="index.php" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-x-circle"></i> پاک کردن فیلترها
                </a>
            </div>
            <?php endif; ?>
        </div>
    </div>
    <!-- --- پایان نوار فیلتر --- -->

    <!-- --- جدول محصولات با ستون‌های جدید --- -->
    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th width="50">ردیف</th>
                    <th>نام محصول</th>
                    <th>دسته‌بندی</th>
                    <th>وضعیت</th>
                    <th>موجودی</th>
                    <th>قیمت</th>
                    <th>عکس</th>
                    <th width="120">عملیات</th>
                </tr>
            </thead>
            <tbody>
                <?php if($products->rowCount() > 0): ?>
                    <?php 
                    $counter = 1;
                    while($row = $products->fetch(PDO::FETCH_ASSOC)): 
                    ?>
                    <tr>
                        <td><?php echo $counter++; ?></td>
                        <td><?php echo $row['title']; ?></td>
                        <td>
                            <span class="badge bg-secondary">
                                <?php echo $row['cat_name'] ?? 'بدون دسته'; ?>
                            </span>
                        </td>
                        <td>
                            <?php if($row['status'] == 1): ?>
                                <span class="badge bg-success">فعال</span>
                            <?php else: ?>
                                <span class="badge bg-danger">غیرفعال</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <span class="badge <?php echo $row['count'] > 0 ? 'bg-success' : 'bg-danger'; ?>">
                                <?php echo $row['count']; ?>
                            </span>
                        </td>
                        <td><?php echo number_format($row['price']); ?> تومان</td>
                        <td>
                            <?php if(!empty($row['image'])): ?>
                                <img src="../../assets/images/<?= $row['image']; ?>" 
                                     alt="<?php echo $row['title']; ?>" 
                                     style="width: 60px; height: 60px; object-fit: cover; border-radius: 5px;">
                            <?php else: ?>
                                <span class="text-muted">بدون عکس</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="edit.php?id=<?php echo $row['id']; ?>" 
                               class="btn btn-sm btn-outline-primary mb-1">
                               <i class="bi bi-pencil"></i> ویرایش
                            </a>
                            
                            <?php 
                            // بررسی می‌کنیم که آیا محصول در سفارشات است یا نه
                            $check_sql = "SELECT COUNT(*) as order_count FROM order_items WHERE product_id = " . $row['id'];
                            $check_result = $conn->query($check_sql);
                            $order_count = $check_result->fetch(PDO::FETCH_ASSOC)['order_count'];
                            ?>
                            
                            <?php if($order_count == 0): ?>
                                <!-- اگر محصول در سفارشات نیست، دکمه حذف فعال باشد -->
                                <a href="?delete=<?php echo $row['id']; ?>" 
                                   class="btn btn-sm btn-outline-danger"
                                   onclick="return confirm('آیا از حذف این محصول مطمئنید؟')">
                                   <i class="bi bi-trash"></i> حذف
                                </a>
                            <?php else: ?>
                                <!-- اگر محصول در سفارشات است، دکمه غیرفعال باشد -->
                                <button class="btn btn-sm btn-outline-secondary" disabled 
                                        title="این محصول در سفارشات استفاده شده و قابل حذف نیست">
                                    <i class="bi bi-trash"></i> حذف
                                </button>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8" class="text-center text-muted py-4">
                            <?php echo (empty($search) && empty($category_id) && empty($status)) 
                                ? 'هنوز محصولی اضافه نشده است.' 
                                : 'محصولی با این فیلترها یافت نشد.'; ?>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</main>

<?php include "../../includes/footer.php"; ?>