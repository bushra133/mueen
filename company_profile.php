<?php 
require_once 'template/header.php';
require_once 'config/database.php';

$st = $mysqli->prepare("select * from company where Company_Email= ? limit 1");
$st->bind_param('s', $userId);
$userId = $_SESSION['user_id'];
$st->execute();
$user = $st->get_result()->fetch_assoc();

// الايميل هو المفتاح الرئيسي فممنوع تعديله
$errors = [];

$companyName = $user['Company_Name'];
$companyEmail = $user['Company_Email'];
$region = $user['Region'];
$sectorType = $user['Sector_Type'];

// استعلام عن الطلبات لتحديث حالة التنبيهات 
$stmt = $mysqli->query("SELECT * FROM request r JOIN job c ON r.job_id = c.job_id WHERE c.company_name = '$companyName' AND r.request_status = 'in progress'");


if($_SERVER['REQUEST_METHOD']=='POST'){

  $companyName = $_POST['companyName'];
  $companyEmail = $_POST['email'];
  $region = $_POST['Region'];
  $sectorType =  $_POST['sectorType'];


  if (empty($companyName)) { $errors['companyName'] = "الاسم الأول مطلوب"; }
  if (empty($companyEmail)) { $errors['email'] = "البريد الإلكتروني مطلوب"; }
  if (empty($sectorType)) { $errors['sectorType'] = "نوع القطاع مطلوب"; }
  if (empty($region)) { $errors['Region'] = "المنطقة مطلوبة"; }
  

  if (!count($errors)) {
    $companyExistsQuery = "SELECT 1 FROM company WHERE Company_Name = '$companyName' LIMIT 1";
    $result = $mysqli->query($companyExistsQuery);

    if ($result->num_rows > 0) {
        $errors['companyName_duplicate'] = "اسم الشركة موجود بالفعل";
    }
}
  if(!count($errors)){

    $st = $mysqli->prepare("update company set Company_Name = ? , Company_Email = ? , Region = ? ,Sector_Type = ? where  Company_Email = ?");
    $st->bind_param('sssss', $companyName, $companyEmail,  $region, $sectorType, $companyEmail);
    $st->execute();

    if($st->error){
      array_push($errors, $st->error);
    } else {
      echo "<script>location.href = 'company_profile.php'</script>";
    }
  }
}
?>

<div class="container pt-5">
    <div class="d-flex justify-content-between">
        <div class="fs-5 fw-bold"> مرحباَ <?= $companyName ?> </div>
        <div class="text-primary fs-4 fw-semibold">الملف الشخصي</div>
        <div class="d-inline-flex gap-3">
            <button  class="notification btn btn-light text-primary fs-5 position-relative" id="notification" onclick="document.location='action_request.php?name=<?= $companyName ?>'"><i class="bi bi-bell"></i>
            <?php if ($stmt->num_rows) { ?>
                <span class="position-absolute top-0 start-100 translate-middle badge border border-light rounded-circle bg-danger p-2"><span class="visually-hidden">unread messages</span></span>
            <?php  }?>
            </button>
            <button class="btn btn-light text-danger fw-medium" onclick="document.location='logout.php'">تسجيل الخروج</button>
        </div>
    </div>
    <div class="card mt-3 pb-4 mb-5">
        <div class="card-header text-bg-primary" >
            <div class="container px-5" style="height: 60px ; background-repeat: repeat-x; background-position: right; background-image: url('http://localhost/mueen/images/image-removebg.png')"></div>
        </div>
        <div class="card-body">
          <div class="d-flex justify-content-between mt-2 p-2">
            <div class="d-inline-flex">
              <img src="http://localhost/mueen/images/back.png" class="rounded-circle" alt="" width="75" height="75">
              <div class="mt-3 mx-2">
                <span class="mx-4 fw-bold"><?= $companyName ?><br><span class="mx-2 fw-light"><?= $companyEmail ?></span></span>
              </div>
            </div>
            <div>
              <button class="btn btn-outline-primary" id="editButton"> تعديل <i class="bi bi-pencil"></i></button>
            </div>
          </div>  
            
          <form class="mt-2 p-3" method="post" enctype="multipart/form-data">
            <?php if(count($errors)):?>
            <div class="alert alert-danger">
              <?php foreach ($errors as $error){ ?>
              <p> <?php echo $error ?></p>
              <?php  } ?>
            </div>
              <?php  endif;?>
            <div class="row">
              <div class="col">
                <div  class="form-outline">
                <label class="form-label fw-medium" for="companyName">اسم الشركة</label>
                  <input type="text" id="companyName" name="companyName"  class="form-control" value="<?= $companyName ?>" disabled />
                </div>
              </div>
              <div class="col">
                <div class="form-outline">
                    <label class="form-label fw-medium" for="sectorType">نوع القطاع</label>
                    <select class="form-control" id="sectorType" name="sectorType" aria-label="" disabled>
                        <option value="حكومي" <?= ($sectorType === "حكومي") ? 'selected' : '' ?>>حكومي</option>
                        <option value="خاص" <?= ($sectorType === "خاص") ? 'selected' : '' ?>>خاص</option>
                        <option value="غير ربحي" <?= ($sectorType === "غير ربحي") ? 'selected' : '' ?>>غير ربحي</option>
                    </select>
                </div>
              </div>
            </div>
            <div class="row mt-3">
              <div class="col">
                <div  class="form-outline">
                <label class="form-label fw-medium" for="email">البريد الإلكتروني</label>
                  <input type="text" id="email" name="email"  class="form-control" value="<?= $companyEmail ?>" disabled />
                </div>
              </div>
              <div class="col">
                <div class="form-outline">
                <label class="form-label fw-medium" for="Region">المنطقة</label>
                  <input type="text" id="Region" name="Region" class="form-control" value="<?= $region ?>" disabled />
                </div>
              </div>
            </div>
            <div class="row mt-3 d-flex justify-content-between">
              <div class="col-auto text_start">
                  <button for="fileCv" class="btn btn-secondary bg-primary-subtle text-primary mt-3 fw-medium border" onclick="document.location='show_request.php?name=<?= $companyName ?>'">
                      إضافة الفرص التدريبية <i class="bi bi-plus-lg ms-1"></i>
                  </button>
              </div>
              <div class="col-auto text-end">
                  <button type="submit" id="saveButton" class="btn btn-outline-primary mt-3 fw-medium" style="display: none;">
                      حفظ التغييرات
                  </button>
              </div>
            </div>
          </form>
            <div class="row p-3">
                <div class="form-outline">
                <button for="fileCv" class="btn btn btn-secondary bg-primary-subtle text-primary fw-medium border px-3"  onclick="document.location='show_request.php?name=<?= $companyName ?>'" >
                استعراض طلبات التدريب         
                </button>
                </div>
            </div>
    
        </div>
    </div>
</div>

<script>
  document.getElementById("editButton").addEventListener("click", function(event) {
    event.preventDefault();
    const inputs = document.querySelectorAll("form input, form button , form select");
    
    inputs.forEach(input => input.removeAttribute("disabled"));
    
    // Show the Save button
    document.getElementById("saveButton").style.display = "block";
    
    
    // Hide the Edit button
    this.style.display = "none";
  });
</script>

<?php
require_once 'template/footer.php'; ?>

