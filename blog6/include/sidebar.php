<?php
$inputErrorName='';
$inputErrorEmail='';
$successSubscribe='';
if(isset($_POST['send']))
{
    $name=$_POST['name'];
    $email=$_POST['email'];
    if(empty($name)){
        $inputErrorName='لطفا نام خود را وارد کنید';
    }
    if(empty($email)){
        $inputErrorEmail='لطفا ایمیل خود را وارد کنید';
    }
    if(!empty($name) and !empty($email))
    {
        $insertSubscribes=$conn->prepare("insert into subscribes (name,email) values ('$name','$email')");
        $successSubscribe='اطلاعات با موفقیت ثبت شد';

    }
}
$categories=$conn->query("select * from categories order by id desc");
?>
<div class="col-lg-4">
                            <!-- Sesrch Section -->
                            <div class="card">
                                <div class="card-body">
                                    <p class="fw-bold fs-6">جستجو در وبلاگ</p>
                                    <form action="search.php" method="post">
                                        <div class="input-group mb-3">
                                            <input
                                                type="text"
                                                name="keyword"
                                                class="form-control"
                                                placeholder="جستجو ..."
                                            />
                                            <button
                                                class="btn btn-secondary"
                                                name="search"
                                                type="submit"
                                            >
                                                <i class="bi bi-search"></i>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <!-- Categories Section -->
                            <div class="card mt-4">
                                <div class="fw-bold fs-6 card-header">دسته بندی ها</div>
                                <ul class="list-group list-group-flush p-0">
                                    <?php foreach($categories as $category):?>
                                    <li class="list-group-item">
                                        <a
                                            class="link-body-emphasis text-decoration-none"
                                            href="index.php?categoryId= <?=$category['id']?>"
                                            ><?= $category['title'] ?>
                                            (
                                                <?php
                                                    echo counting($category['id'],'posts','category_id');
                                                ?>
                                            )
                                            </a
                                        >
                                    </li>
                                    <?php endforeach ?>
                                </ul>
                            </div>

                            <!-- Subscribue Section -->
                            <div class="card mt-4">
                                <div class="card-body">
                                    <p class="fw-bold fs-6">عضویت در خبرنامه</p>
                                    
                                    <?php if(!empty($successSubscribe)): ?>
                                    <div class="alert alert-success" role="alert">
                                        <?= $successSubscribe ?>
                                    </div>
                                    <?php endif ?>
                                
                                    <form action="index.php" method="post" >
                                        <div class="mb-3">
                                            <label class="form-label"
                                                >نام</label
                                            >
                                            <?php if(!empty($inputErrorName)): ?>
                                                <div style="color:red;">
                                                <?= $inputErrorName ?>                                                
                                                </div>
                                            <?php endif ?>
                                            <input
                                                type="text"
                                                name="name"
                                                class="form-control"
                                            />
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label"
                                                >ایمیل</label
                                            >
                                            <?php if(!empty($inputErrorEmail)): ?>
                                                <div style="color:red;">
                                                <?= $inputErrorEmail ?>
                                                </div>
                                            <?php endif ?>
                                            <input
                                                type="email"
                                                name="email"
                                                class="form-control"
                                            />
                                        </div>
                                        <div class="d-grid gap-2">
                                            <button
                                                type="submit"
                                                name="send"
                                                class="btn btn-secondary"
                                            >
                                                ارسال
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <!-- About Section -->
                            <div class="card mt-4">
                                <div class="card-body">
                                    <p class="fw-bold fs-6">درباره ما</p>
                                    <p class="text-justify">
                                        لورم ایپسوم متن ساختگی با تولید سادگی
                                        نامفهوم از صنعت چاپ و با استفاده از
                                        طراحان گرافیک است. چاپگرها و متون بلکه
                                        روزنامه و مجله در ستون و سطرآنچنان که
                                        لازم است و برای شرایط فعلی تکنولوژی مورد
                                        نیاز و کاربردهای متنوع با هدف بهبود
                                        ابزارهای کاربردی می باشد.
                                    </p>
                                </div>
                            </div>
                        </div>