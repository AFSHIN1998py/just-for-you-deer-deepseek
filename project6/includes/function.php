<?php
function checkLogin() {
    if (!isset($_SESSION['user_id'])) {
        header('Location: ../pages/auth/login.php');
        exit();
    }
}
function enToFa($number) {
    $en = array('0','1','2','3','4','5','6','7','8','9');
    $fa = array('۰','۱','۲','۳','۴','۵','۶','۷','۸','۹');
    return str_replace($en, $fa, $number);
}

function formatPrice($price) {
    return enToFa(number_format($price)) . ' تومان';
}
?>