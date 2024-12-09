<?php 
require_once 'template/header.php';
require_once 'config/database.php';

if(isset($_SESSION['logged_in'])){
  header('location: index.php');
}

$errors = [];
$companyName = '';
$email = '';
$region = '';
$sectorType = null;

if($_SERVER['REQUEST_METHOD']=='POST'){

  $sectorType = isset($_POST['sectorType']) ? $_POST['sectorType'] : null;
  $allowedOptions = ['حكومي', 'خاص', 'غير ربحي']; 
  if (!in_array($sectorType, $allowedOptions)) {
      $errors['sectorType'] = "نوع القطاع مطلوب";
  }
  $companyName = mysqli_real_escape_string($mysqli ,$_POST['companyName']);
  $email = mysqli_real_escape_string($mysqli ,$_POST['email']);
  $region = mysqli_real_escape_string($mysqli ,$_POST['region']);
  $sectorType = mysqli_real_escape_string($mysqli, $_POST['sectorType']);
  $password = mysqli_real_escape_string($mysqli ,$_POST['password']);
  $password_confirmtion = mysqli_real_escape_string($mysqli ,$_POST['password_confirmtion']);

  if (empty($companyName)) { $errors['companyName'] = "اسم الشركة مطلوب"; }
  if (empty($email)) { $errors['email'] = "البريد الإلكتروني مطلوب"; }
  if (empty($region)) { $errors['region'] = "المنطقة مطلوبة"; }
if (empty($sectorType)) {$errors['sectorType'] = "نوع القطاع مطلوب";
    }  if (empty($password)) { $errors['password'] = "كلمة المرور مطلوبة"; }
  if (empty($password_confirmtion)) { $errors['password_confirmtion'] = "تأكيد كلمة المرور مطلوب"; }
  if ($password != $password_confirmtion) { $errors['password_match'] = "كلمات المرور غير متطابقة"; }


  if(!count($errors)){
    $userExists = $mysqli->query("SELECT Company_Email FROM company WHERE Company_Email = '$email' LIMIT 1");
    if($userExists->num_rows){
      $errors['email_match'] = "البريد الإلكتروني مستخدم سابقا";
    }
  }

  if(!count($errors)){
    $password = password_hash($password, PASSWORD_DEFAULT);
    $query = "INSERT INTO company (Company_Name, Company_Email, Region, Sector_Type,password) VALUES ('$companyName', '$email','$region','$sectorType', '$password')";
    $mysqli->query($query);

    $_SESSION['logged_in'] = true;
    $_SESSION['user_id'] = $mysqli->insert_id;
    $_SESSION['user_type'] = 'company';
    $_SESSION['company_name'] = $companyName;
    $_SESSION['success_messege'] = "Welcome to our website, $companyName";

    header('location: index.php');
  }
}
?>

<div class="container-fluid my-5 p-0 overflow-hidden">
  <p class="text-center fs-3 fw-bold">إنشاء حساب جديد كشركة</p>
  <div class="d-flex justify-content-center">
    <div class="card pt-2 px-5 mb-3 shadow rounded w-75">
      <div class="card-body">
        <form action="" method="post">
          <div class="form-group">
            <label class="fw-semibold p-2" for="companyName">اسم الشركة </label>
            <input type="text" class="form-control" id="companyName" name="companyName" placeholder="أدخل اسم الشركة" value="<?= $companyName ?>" aria-describedby="companyName-error">
            <?php if(isset($errors['companyName'])): ?>
              <div class="text-danger"><?= $errors['companyName'] ?></div>
            <?php endif; ?>
          </div>

          
          <div class="form-group">
            <label class="fw-semibold p-2" for="email">البريد الإلكتروني لجهة العمل</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="أدخل البريد الإلكتروني" value="<?= $email ?>" aria-describedby="email-error email-match-error">
            <?php if(isset($errors['email'])): ?>
              <div class="text-danger"><?= $errors['email'] ?></div>
            <?php elseif(isset($errors['email_match'])): ?>
              <div class="text-danger"><?= $errors['email_match'] ?></div>
            <?php endif; ?>
          </div>
          <div class="form-group">
            <label class="fw-semibold p-2" for="region">المنطقة</label>
            <input type="text" class="form-control" id="region" name="region" placeholder="أدخل المنطقة" value="<?= $region ?>" aria-describedby="region-error">
            <?php if(isset($errors['region'])): ?>
              <div class="text-danger"><?= $errors['region'] ?></div>
            <?php endif; ?>
          </div>
          
          <div class="form-group">
          <label class="fw-semibold p-2" for="sectorType">نوع القطاع</label>
          <select class="form-select" id="sectorType" name="sectorType" aria-label="">
            <option selected>اختر نوع القطاع</option>
            <option value="حكومي">حكومي</option>
            <option value="خاص">خاص</option>
            <option value="غير ربحي">غير ربحي</option>
            </select>
            <?php if(isset($errors['sectorType'])): ?>
              <div class="text-danger"><?= $errors['sectorType'] ?></div>
            <?php endif; ?>
          </div>

          

          <div class="form-group">
            <label class="fw-semibold p-2" for="password">كلمة المرور</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="أدخل كلمة المرور" aria-describedby="password-error">
            <?php if(isset($errors['password'])): ?>
              <div class="text-danger"><?= $errors['password'] ?></div>
            <?php endif; ?>
          </div>

          <div class="form-group">
            <label class="fw-semibold p-2" for="password_confirmtion">تأكيد كلمة المرور</label>
            <input type="password" class="form-control" id="password_confirmtion" name="password_confirmtion" placeholder="أدخل تأكيد كلمة المرور" aria-describedby="password_confirmtion-error password-match-error">
            <?php if (isset($errors['password_confirmtion'])): ?>
              <div id="password_confirmtion-error" class="text-danger"><?= $errors['password_confirmtion'] ?></div>
            <?php elseif (isset($errors['password_match'])): ?>
              <div id="password-match-error" class="text-danger"><?= $errors['password_match'] ?></div>
            <?php endif; ?>
          </div>

          <div class="form-group">
            <button type="submit" class="btn btn-primary mt-5 fw-semibold p-2 w-100">إنشاء حساب</button>
          </div>
        </form>  
          <div class="text-center p-4 mt-1 fw-semibold"> لديك حساب بالفعل؟  <a  class="text-decoration-none text-primary" href="login.php"> تسجيل الدخول  </a></div>
          
      </div>
    </div>
  </div>
</div>

<?php require_once 'template/footer.php'; ?>
