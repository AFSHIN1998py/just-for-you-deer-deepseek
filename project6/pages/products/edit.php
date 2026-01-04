<?php
include "../../includes/header.php";

$id = $_GET['id'] ?? 0;
$product = $conn->query("SELECT * FROM products WHERE id = $id")->fetch(PDO::FETCH_ASSOC);

if(!$product) {
    echo "<script>alert('محصول یافت نشد!'); window.location='index.php';</script>";
    exit();
}

// پردازش فرم ویرایش
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $category_id = $_POST['category_id'];
    $price = $_POST['price'];
    $count = $_POST['count'];
    $description = $_POST['description'];
    $status = isset($_POST['status']) ? 1 : 0;
    
    // آپلود عکس جدید (اگر انتخاب شده)
    $image = $product['image']; // نگه داشتن عکس قبلی
    
    if(isset($_FILES['new_image']) && $_FILES['new_image']['error'] == 0) {
        $file_name = time() . '_' . basename($_FILES['new_image']['name']);
        $target_path = "../../assets/images/" . $file_name;
        
        if(move_uploaded_file($_FILES['new_image']['tmp_name'], $target_path)) {
            // حذف عکس قدیمی اگر وجود دارد
            if(!empty($product['image']) && file_exists("../../uploads/" . $product['image'])) {
                unlink("../../uploads/" . $product['image']);
            }
            $image = $file_name;
        }
    }
    
    // بررسی فیلدهای الزامی
    if(empty($title) || empty($category_id) || empty($price) || empty($count)) {
        echo "<script>alert('لطفا همه فیلدهای الزامی را پر کنید!');</script>";
    } else {
        $sql = "UPDATE products SET 
                title = '$title',
                category_id = $category_id,
                image = '$image',
                price = $price,
                count = $count,
                description = '$description',
                status = $status
                WHERE id = $id";
        
        if($conn->query($sql)) {
            echo "<script>alert('محصول با موفقیت ویرایش شد!'); window.location='index.php';</script>";
        } else {
            echo "<script>alert('خطا در ویرایش محصول!');</script>";
        }
    }
}

// دریافت همه دسته‌بندی‌ها
$categories = $conn->query("SELECT * FROM categories ORDER BY title");
?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between pt-3 pb-2 mb-3 border-bottom">
        <h2>ویرایش محصول</h2>
        <a href="index.php" class="btn btn-secondary btn-sm">بازگشت</a>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="POST" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">عنوان محصول <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control" value="<?php echo $product['title']; ?>" required>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label">دسته‌بندی <span class="text-danger">*</span></label>
                        <select name="category_id" class="form-select" required>
                            <option value="">انتخاب کنید</option>
                            <?php 
                            while($cat = $categories->fetch(PDO::FETCH_ASSOC)): 
                                $selected = ($cat['id'] == $product['category_id']) ? 'selected' : '';
                            ?>
                                <option value="<?php echo $cat['id']; ?>" <?php echo $selected; ?>>
                                    <?php echo $cat['title']; ?>
                                    <?php if($cat['status'] == 0): ?> (غیرفعال) <?php endif; ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">قیمت (تومان) <span class="text-danger">*</span></label>
                        <input type="number" name="price" class="form-control" value="<?php echo $product['price']; ?>" required min="0">
                    </div>
                    
                    <div class="col-md-4 mb-3">
                        <label class="form-label">تعداد موجودی <span class="text-danger">*</span></label>
                        <input type="number" name="count" class="form-control" value="<?php echo $product['count']; ?>" required min="0">
                    </div>
                    
                    <div class="col-md-4 mb-3">
                        <label class="form-label">عکس فعلی</label>
                        <?php if(!empty($product['image'])): ?>
                            <div class="mb-2">
                                <img src="../../uploads/<?php echo $product['image']; ?>" 
                                     style="width: 100px; height: 100px; object-fit: cover; border: 1px solid #ddd;">
                            </div>
                        <?php endif; ?>
                        <label class="form-label">عکس جدید (اختیاری)</label>
                        <input type="file" name="new_image" class="form-control" accept="image/*">
                    </div>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">توضیحات</label>
                    <textarea name="description" class="form-control" rows="3"><?php echo $product['description']; ?></textarea>
                </div>
                
                <div class="mb-3 form-check">
                    <input type="checkbox" name="status" class="form-check-input" id="status" 
                        <?php echo ($product['status'] == 1) ? 'checked' : ''; ?>>
                    <label class="form-check-label" for="status">وضعیت فعال</label>
                </div>
                
                <button type="submit" class="btn btn-primary">ذخیره تغییرات</button>
                <a href="index.php" class="btn btn-light">انصراف</a>
            </form>
        </div>
    </div>
</main>

<?php include "../../includes/footer.php"; ?>