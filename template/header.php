<?php
// هنا نبدأ الجلسة
session_start();
?>
<!DOCTYPE html>
<html dir="rtl" lang="Ar">
<head>
  <title>معين</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

<!--  Bootstrap CSS and JS  -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<!-- cairo font -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200..1000&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Press+Start+2P&display=swap" rel="stylesheet">

<!-- Font Awesome icons -->
<link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
      integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    />
  <!-- header css -->
<link rel="stylesheet" href="css/header.css?v=<?php echo time(); ?>">   

</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
      <div class="container-fluid">
        <!-- الشعار -->
        <a class="navbar-brand" href="#">
          <img
            src="images/white-logo2.png"
            alt="Logo"
            style="width: 100px; height: 50px"
          />
          <!-- ضع رابط الشعار هنا -->
        </a>
        <!-- زر المنيو لشاشات الهاتف -->
        <button
          class="navbar-toggler mx-3"
          type="button"
          data-toggle="collapse"
          data-target="#navbarNav"
          aria-controls="navbarNav"
          aria-expanded="false"
          aria-label="Toggle navigation"
        >
          <span class="navbar-toggler-icon"></span>
        </button>
        <!-- عناصر القائمة -->
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav ms-auto">
            <li class="nav-item">
              <a class="nav-link" href="index.php">الرئيسية</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">الأسئلة الشائعة</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">من نحن</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">تواصل معنا</a>
            </li>
          </ul>
          <!-- أزرار تسجيل الدخول وتسجيل جديد -->
          <div class="ms-3 me-2">
          <?php if(!isset($_SESSION['logged_in'])): ?>
            <a href="login.php" class="btn btn-light text-dark ms-3"
              >تسجيل الدخول</a>
            <span class="dropdown">
            <a href="" class="btn btn-outline-light dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">تسجيل جديد</a>
            <ul class="dropdown-menu dropdown-menu-start">
              <li><a class="dropdown-item" href="student_register.php">كطالب</a></li>
              <li><a class="dropdown-item" href="company_register.php">كشركة</a></li>
            </ul>
            </span>
          <?php  else:
          switch ($_SESSION['user_type']) {
            case 'applicant':?>
              <a href="studentProfile.php" class="btn btn-outline-light">لوحة التحكم</a>
          <?php break;
            case 'company':?>
              <a href="company_profile.php" class="btn btn-outline-light">لوحة التحكم</a>
          <?php break;  }?>
          <?php endif; ?>
          </div>
        </div>
      </div>
    </nav>