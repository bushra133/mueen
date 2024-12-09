<?php 
require_once 'template/header.php';
require_once 'config/database.php';

if(isset($_SESSION['logged_in'])){
  header('location: index.php');
}

$errors = [];
$firstName = '';
$lastName = '';
$email = '';
$university = '';
$major = '';

if($_SERVER['REQUEST_METHOD']=='POST'){

  $firstName = mysqli_real_escape_string($mysqli ,$_POST['firstName']);
  $lastName = mysqli_real_escape_string($mysqli ,$_POST['lastName']);
  $email = mysqli_real_escape_string($mysqli ,$_POST['email']);
  $university = mysqli_real_escape_string($mysqli ,$_POST['university']);
  $major = mysqli_real_escape_string($mysqli ,$_POST['major']);
  $password = mysqli_real_escape_string($mysqli ,$_POST['password']);
  $password_confirmtion = mysqli_real_escape_string($mysqli ,$_POST['password_confirmtion']);

  if (empty($firstName)) { $errors['firstName'] = "الاسم الأول مطلوب"; }
  if (empty($lastName)) { $errors['lastName'] = "الاسم الأخير مطلوب"; }
  if (empty($email)) { $errors['email'] = "البريد الإلكتروني مطلوب"; }
  if (empty($university)) { $errors['university'] = "الجامعة مطلوبة"; }
  if (empty($major)) { $errors['major'] = "التخصص مطلوب"; }
  if (empty($password)) { $errors['password'] = "كلمة المرور مطلوبة"; }
  if (empty($password_confirmtion)) { $errors['password_confirmtion'] = "تأكيد كلمة المرور مطلوب"; }
  if ($password != $password_confirmtion) { $errors['password_match'] = "كلمات المرور غير متطابقة"; }


  if(!count($errors)){
    $userExists = $mysqli->query("SELECT applicant_id, applicant_email FROM applicant WHERE applicant_email = '$email' LIMIT 1");
    if($userExists->num_rows){
      $errors['email_match'] = "البريد الإلكتروني مستخدم سابقا";
    }
  }

  if(!count($errors)){
    $password = password_hash($password, PASSWORD_DEFAULT);
    $query = "INSERT INTO applicant (applicant_firstname, applicant_lastname, applicant_email, password, university_name, university_major) VALUES ('$firstName', '$lastName', '$email', '$password', '$university', '$major')";
    $mysqli->query($query);

    $_SESSION['logged_in'] = true;
    $_SESSION['user_id'] = $mysqli->insert_id;
    $_SESSION['user_type'] = 'applicant';
    $_SESSION['user_name'] = $firstName;
    $_SESSION['success_messege'] = "Welcome to our website, $firstName";

    header('location: index.php');
  }
}
?>

<div class="container-fluid my-5 p-0 overflow-hidden">
  <p class="text-center fs-3 fw-bold">إنشاء حساب جديد كطالب</p>
  <div class="d-flex justify-content-center">
    <div class="card pt-2 px-5 mb-3 shadow rounded w-75">
      <div class="card-body">
        <form action="" method="post">
          <div class="form-group">
            <label class="fw-semibold p-2" for="firstName">الإسم الأول</label>
            <input type="text" class="form-control" id="firstName" name="firstName" placeholder="أدخل الإسم الأول" value="<?= $firstName ?>" aria-describedby="firstName-error">
            <?php if(isset($errors['firstName'])): ?>
              <div class="text-danger"><?= $errors['firstName'] ?></div>
            <?php endif; ?>
          </div>

          <div class="form-group">
            <label class="fw-semibold p-2" for="lastName">الإسم الأخير</label>
            <input type="text" class="form-control" id="lastName" name="lastName" placeholder="أدخل الإسم الأخير" value="<?= $lastName ?>" aria-describedby="lastName-error">
            <?php if(isset($errors['lastName'])): ?>
              <div class="text-danger"><?= $errors['lastName'] ?></div>
            <?php endif; ?>
          </div>

          <div class="form-group">
            <label class="fw-semibold p-2" for="email">البريد الإلكتروني</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="أدخل البريد الإلكتروني" value="<?= $email ?>" aria-describedby="email-error email-match-error">
            <?php if(isset($errors['email'])): ?>
              <div class="text-danger"><?= $errors['email'] ?></div>
            <?php elseif(isset($errors['email_match'])): ?>
              <div class="text-danger"><?= $errors['email_match'] ?></div>
            <?php endif; ?>
          </div>

          <div class="form-group">
            <label class="fw-semibold p-2" for="university">الجامعة</label>
            <input type="text" class="form-control" id="university" name="university" placeholder="أدخل الجامعة" value="<?= $university ?>" aria-describedby="university-error">
            <?php if(isset($errors['university'])): ?>
              <div class="text-danger"><?= $errors['university'] ?></div>
            <?php endif; ?>
          </div>

          <div class="form-group">
            <label class="fw-semibold p-2" for="major">التخصص</label>
            <input type="text" class="form-control" id="major" name="major" placeholder="أدخل التخصص" value="<?= $major ?>" aria-describedby="major-error">
            <?php if(isset($errors['major'])): ?>
              <div class="text-danger"><?= $errors['major'] ?></div>
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
          <div class="d-flex align-items-center my-3">
            <hr class="flex-grow-1">
            <span class="mx-2 text-muted">أو </span>
            <hr class="flex-grow-1">
          </div>
          <div class="text-center">
            <button class="btn btn-light border border-primary px-5">تسجيل الدخول بواسطة قوقل <img src="images/image.png" style="width:20px; height:20px;" alt=""></button>
            <div class="text-center pt-3 fw-semibold"> لديك حساب بالفعل ؟ <a  class="text-decoration-none text-primary" href="login.php"> تسجيل الدخول  </a></div>
          </div>
      </div>
    </div>
  </div>
</div>

<?php require_once 'template/footer.php'; ?>
