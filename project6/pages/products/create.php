<?php
include "../../includes/header.php";

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $category_id = $_POST['category_id'];
    $price = $_POST['price'];
    $count = $_POST['count'];
    $description = $_POST['description'];
    $status = isset($_POST['status']) ? 1 : 0;
    
    $image = '';
    if(isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $file_name = time() . '_' . basename($_FILES['image']['name']);
        $target_path = "../../assets/images/" . $file_name;
        
        if(move_uploaded_file($_FILES['image']['tmp_name'], $target_path)) {
            $image = $file_name;
        }
    }
    
    if(empty($title) || empty($category_id) || empty($price) || empty($count)) {
        echo "<script>alert('لطفا همه فیلدهای الزامی را پر کنید!');</script>";
    } else {
        $sql = "INSERT INTO products (category_id, title, image, date, price, count, description, status) 
                VALUES ($category_id, '$title', '$image', NOW(), $price, $count, '$description', $status)";
        
        if($conn->query($sql)) {
            echo "<script>alert('محصول با موفقیت افزوده شد!'); window.location='index.php';</script>";
        } else {
            echo "<script>alert('خطا در افزودن محصول!');</script>";
        }
    }
}
$categories = $conn->query("SELECT * FROM categories ORDER BY title");
?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between pt-3 pb-2 mb-3 border-bottom">
        <h2>افزودن محصول جدید</h2>
        <a href="index.php" class="btn btn-secondary btn-sm">بازگشت</a>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="POST" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">عنوان محصول <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control" required>
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label">دسته‌بندی <span class="text-danger">*</span></label>
                        <select name="category_id" class="form-select" required>
                            <option value="">انتخاب کنید</option>
                            <?php while($cat = $categories->fetch(PDO::FETCH_ASSOC)): ?>
                                <option value="<?php echo $cat['id']; ?>">
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
                        <input type="number" name="price" class="form-control" required min="0">
                    </div>
                    
                    <div class="col-md-4 mb-3">
                        <label class="form-label">تعداد موجودی <span class="text-danger">*</span></label>
                        <input type="number" name="count" class="form-control" required min="0">
                    </div>
                    
                    <div class="col-md-4 mb-3">
                        <label class="form-label">عکس محصول</label>
                        <input type="file" name="image" class="form-control" accept="image/*">
                    </div>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">توضیحات</label>
                    <textarea name="description" class="form-control" rows="3"></textarea>
                </div>
                
                <div class="mb-3 form-check">
                    <input type="checkbox" name="status" class="form-check-input" id="status" checked>
                    <label class="form-check-label" for="status">وضعیت فعال</label>
                </div>
                
                <button type="submit" class="btn btn-primary">ذخیره محصول</button>
                <a href="index.php" class="btn btn-light">انصراف</a>
                
            </form>
        </div>
    </div>
</main>

<?php include "../../includes/footer.php"; ?>