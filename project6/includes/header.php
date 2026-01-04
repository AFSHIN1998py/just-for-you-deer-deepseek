<?php 
session_start();
include "db.php";
include "function.php";
// $usertype=$conn->query("select * from users");

if(!isset($_SESSION['user_id'])) {
    header("Location: pages/auth/login.php");
    exit();
}
?>

<!DOCTYPE html>
<html dir="rtl" lang="fa">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>پنل فروشگاه</title>

        <link
            rel="stylesheet"
            href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css"
        />
        <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css"
            rel="stylesheet"
            integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9"
            crossorigin="anonymous"
        />

        <link rel="stylesheet" href="./assets/css/style.css" />
    </head>

    <body>
        <header
            class="navbar sticky-top bg-secondary flex-md-nowrap p-0 shadow-sm"
        >
            <a
                class="navbar-brand col-md-3 col-lg-2 me-0 px-3 fs-5 text-white"
                href="index.html"
                >پنل ادمین</a
            >
            <span class="text-light me-3">
                    <?=$_SESSION['fullname']?> خوش امدید    
                </span>
            <div class="d-flex align-items-center">
                <span class="text-dark me-3">
                    <i class="bi bi-person-circle me-1"></i>
                    <?php echo $_SESSION['fullname'] ?? 'کاربر'; ?>
                </span>
                
            </div>

            <button
                class="ms-2 nav-link px-3 text-white d-md-none"
                type="button"
                data-bs-toggle="offcanvas"
                data-bs-target="#sidebarMenu"
            >
                <i class="bi bi-justify-left fs-2"></i>
            </button>
        </header>