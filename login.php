<?php 
require_once 'template/header.php';
require_once 'config/database.php';

if(isset($_SESSION['logged_in'])){
  header('location: index.php');
}

$errors = [];
$email = '';

if($_SERVER['REQUEST_METHOD']=='POST'){

  $email = mysqli_real_escape_string($mysqli ,$_POST['email']);
  $password = mysqli_real_escape_string($mysqli ,$_POST['password']);
  // query بكذا تكون البيانات نظيفه نقدر نسوي
  
  // رسائل تطلع للمستخدم لاخطاء التعبئة
  if (empty($email)) { $errors['email'] = "البريد الإلكتروني مطلوب"; }
  if (empty($password)) { $errors['password'] = "كلمة المرور مطلوبة"; }

  // بعد ما يتاكد من تعبئة الحقول يروح يسوي طلب من قاعدة البيانات
  //التحقق من وجود المستخدم قبل تسجيل الدخول
  if(!count($errors)){
    
    $query = "(SELECT 'applicant' AS user_type, applicant_id AS id, applicant_firstname AS name, applicant_email AS email, password 
     FROM applicant WHERE applicant_email = ?) 
    UNION 
    (SELECT 'company' AS user_type, Company_Email AS id, Company_Name AS name, Company_Email AS email, password 
     FROM company WHERE Company_Email = ?)";
    $userExists = $mysqli->prepare($query);
    $userExists->bind_param('ss', $email, $email);
    $userExists->execute();
    $result = $userExists->get_result(); // Get the result set

    if(!$result->num_rows){
      
      $errors['email_Exists'] = "البريد الإلكتروني غير موجود";

    } else {
      $userfound = $result->fetch_assoc();
      
        if(password_verify($password, $userfound['password'])){
            $_SESSION['logged_in'] = true ;
            $_SESSION['user_id'] = $userfound['id'];
            $_SESSION['user_name'] = $userfound['name'];
            $_SESSION['user_type'] = $userfound['user_type'];
            $_SESSION['success_messege'] = "Welcome back you are logged in , $userfound[name] and you are $userfound[user_type]";
            header('location: index.php');
        }
        else {
            $errors['verification'] = "البريد الإلكتروني أو كلمة المرور غير صحيحة";  
        }
    }
  }
}
?>

<div class="container-fluid m-0 p-0 ">
    <div class="row h-100">
        <!-- Left Section -->
        <div class="col-7 position-relative" style="height: 100vh;">
            <div class="position-absolute top-50 start-50 translate-middle w-75 z-3">
                <p class="text-center pt-5 fs-3 fw-bold">تسجيل الدخول</p>
                <div class="card p-2 py-4 shadow bg-body-tertiary rounded">
                    <div class="card-body">
                        
                        <!-- Login Form -->
                        <form action="" method="post">
                            <div class="form-group">
                                <label class="fw-semibold p-2" for="email">البريد الإلكتروني</label>
                                <input type="email" class="form-control" placeholder="أدخل البريد الإلكتروني" id="email" name="email" value="<?= $email ?>">
                                <?php if(isset($errors['email'])): ?>
                                <div class="text-danger"><?= $errors['email'] ?></div>
                                <?php endif; ?>
                                <?php if(isset($errors['email_Exists'])): ?>
                                <div class="text-danger"><?= $errors['email_Exists'] ?></div>
                                <?php endif; ?>
                            </div>
                            <div class="form-group">
                                <label class="fw-semibold p-2" for="password">كلمة المرور</label>
                                <input type="password" class="form-control" placeholder="أدخل كلمة المرور" id="password" name="password">
                                <?php if(isset($errors['password'])): ?>
                                <div class="text-danger"><?= $errors['password'] ?></div>
                                <?php endif; ?>
                                <?php if(isset($errors['verification'])): ?>
                                <div class="text-danger"><?= $errors['verification'] ?></div>
                                <?php endif; ?>
                            </div>
                            <div class="d-flex justify-content-between mt-2 p-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="flexCheckDefault">
                                    <label class="form-check-label fw-semibold" for="flexCheckDefault">تذكرني</label>
                                </div>
                                <div class="text-primary fw-semibold">نسيت كلمة المرور؟</div>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary fw-semibold w-100">تسجيل الدخول</button>
                                <div class="text-center pt-4 fw-semibold">ليس لديك حساب ؟ 
                                <div class="btn-group dropend">
                                <button type="button" class="dropdown-toggle btn btn-link text-decoration-none p-0 text-primary" data-bs-toggle="dropdown" aria-expanded="false">
                                إنشاء حساب
                                </button>
                                <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="student_register.php">إنشاء حساب كطالب</a></li>
                                <li><a class="dropdown-item" href="company_register.php">إنشاء حساب كشركة</a></li>
                                </ul>
                                </div>
                                    
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Background Image -->
            <div class="position-absolute bottom-0 end-0 z-1">
                <img src="http://localhost/mueen/images/frame4.png" class="img-fluid" alt="" style="width:500px; height:500px;">
            </div>
        </div>

        <!-- Right Section -->
        <div class="col-5 z-0 p-0 position-relative login-page-side" >
                <img src="http://localhost/mueen/images/online security.png"  class="position-absolute top-50 start-50 translate-middle img-fluid" alt="">
        </div>
    </div>
</div>


<?php
require_once 'template/footer.php'; ?>