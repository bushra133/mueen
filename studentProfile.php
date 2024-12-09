<!-- 
ناقص حذف الملف 
وصورة العرض 
ورسائل الاخطاء 
اضافة حقل الجنس ذكر او انثى علشان الصورة وهل نحتاج اضافتها او لا 
-->
<?php 
require_once 'template/header.php';
require_once 'config/database.php';
require_once 'upload.php';

$st = $mysqli->prepare("select * from applicant where applicant_id= ? limit 1");
$st->bind_param('i', $userId);
$userId = $_SESSION['user_id'];
$st->execute();
$user = $st->get_result()->fetch_assoc();

$errors = [];

$userid = $user['applicant_id'];
$firstName = $user['applicant_firstname'];
$lastName = $user['applicant_lastname'];
$email = $user['applicant_email'];
$university = $user['university_name'];
$major = $user['university_major'];
$region = $user['Region'];
$CvFile = isset($user['CV_file']) ? basename($user['CV_file']) : null;
$CoopFile = isset($user['Coop_file']) ? basename($user['Coop_file']) : null;

if($_SERVER['REQUEST_METHOD']=='POST'){

  $firstName = $_POST['firstName'];
  $lastName = $_POST['lastName'];
  $email = $_POST['email'];
  $university = $_POST['university'];
  $major = $_POST['major'];
  $region = $_POST['Region'];

  if (empty($firstName)) { $errors['firstName'] = "الاسم الأول مطلوب"; }
  if (empty($lastName)) { $errors['lastName'] = "الاسم الأخير مطلوب"; }
  if (empty($email)) { $errors['email'] = "البريد الإلكتروني مطلوب"; }
  if (empty($university)) { $errors['university'] = "الجامعة مطلوبة"; }
  if (empty($major)) { $errors['major'] = "التخصص مطلوب"; }
  if (empty($region)) { $errors['Region'] = "المنطقة مطلوبة"; }

 
  // upload CV file 
  if (isset($_FILES['fileCv']) && $_FILES['fileCv']['error'] == UPLOAD_ERR_OK) {
    $uploadCv = new Upload('/uploads/files');
    $uploadCv->file = $_FILES['fileCv'];
    $errors = $uploadCv->upload();
    // Check if the file path was successfully set after uploading
    if (!$errors) {
        $cvFilePath = $uploadCv->filePath;  // Store the uploaded file path
    } else {
        $cvFilePath = null;  // Set to null if upload failed
    }
  } 
  else {
    $cvFilePath = null;  // No file uploaded
  }

  // upload Coop file 
  if (isset($_FILES['fileCoop']) && $_FILES['fileCoop']['error'] == UPLOAD_ERR_OK) {
    $uploadCoop = new Upload('/uploads/files');
    $uploadCoop->file = $_FILES['fileCoop'];
    $errors = $uploadCoop->upload();
    // Check if the file path was successfully set after uploading
    if (!$errors) {
        $coopFilePath = $uploadCoop->filePath;  // Store the uploaded file path
    } else {
        $coopFilePath = null;  // Set to null if upload failed
    }
  } 
  else {
    $coopFilePath = null;  // No file uploaded
  }

  if(!count($errors)){

    $st = $mysqli->prepare("update applicant set applicant_firstname = ? , applicant_lastname = ? , applicant_email = ? ,university_name = ? , university_major = ? , Region = ?, CV_file = IFNULL(?, CV_file), Coop_file = IFNULL(?, Coop_file) where applicant_id = ?");
    $st->bind_param('ssssssssi', $firstName, $lastName, $email, $university, $major, $region, $cvFilePath , $coopFilePath, $userid);
    $st->execute();

    if($st->error){
      array_push($errors, $st->error);
    } else {
      echo "<script>location.href = 'studentprofile.php'</script>";
    }
  }
}
?>

<div class="container pt-5">
  <div class="d-flex justify-content-between">
      <div class="fs-5 fw-bold"> مرحباَ <?= $firstName ?> </div>
      <div class="text-primary fs-4 fw-semibold">الملف الشخصي</div>
      <div class="d-inline-flex gap-3">
          <button class="btn btn-light text-primary fs-5" onclick="document.location='applicant_request.php?id=<?= $userid ?>'"><i class="bi bi-bell"></i>
          </button>
          <button class="btn btn-light text-danger fw-medium" onclick="document.location='logout.php'">تسجيل الخروج</button>
      </div>
  </div>
  <div class="card mt-3 pb-4 mb-5" >
    <div class="card-header text-bg-primary" >
      <div class="container px-5" style="height: 60px ; background-repeat: repeat-x; background-position: right; background-image: url('http://localhost/mueen/image-removebg.png')">
      </div>
    </div>
    <div class="card-body">
      <div class="d-flex justify-content-between mt-2 p-2">
        <div class="d-inline-flex">
          <img src="http://localhost/mueen/src/img/back.png" class="rounded-circle" alt="" width="75" height="75">
          <div class="mt-3 mx-2">
            <span class="mx-4 fw-bold"><?= $firstName," ", $lastName ?><br><span class="mx-2 fw-light"><?= $email ?></span></span>
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
            <label class="form-label fw-medium" for="firstName">الإسم الأول</label>
              <input type="text" id="firstName" name="firstName"  class="form-control" value="<?= $firstName ?>" disabled />
            </div>
          </div>
          <div class="col">
            <div class="form-outline">
            <label class="form-label fw-medium" for="lastName">الإسم الأخير</label>
              <input type="text" id="lastName" name="lastName" class="form-control" value="<?= $lastName ?>" disabled />
            </div>
          </div>
        </div>
        <div class="row mt-3">
          <div class="col">
            <div  class="form-outline">
            <label class="form-label fw-medium" for="university">الجامعة</label>
              <input type="text" id="university" name="university" class="form-control" value="<?= $university ?>" disabled />
            </div>
          </div>
          <div class="col">
            <div class="form-outline">
            <label class="form-label fw-medium" for="Region">المنطقة</label>
              <input type="text" id="Region" name="Region" class="form-control" value="<?= $region ?>" disabled />
            </div>
          </div>
        </div>
        <div class="row mt-3">
          <div class="col">
            <div  class="form-outline">
            <label class="form-label fw-medium" for="email">البريد الإلكتروني</label>
              <input type="text" id="email" name="email"  class="form-control" value="<?= $email ?>" disabled />
            </div>
          </div>
          <div class="col">
            <div class="form-outline">
            <label class="form-label fw-medium" for="major">التخصص</label>
              <input type="text" id="major" name="major" class="form-control" value="<?= $major ?>" disabled />
            </div>
          </div>
        </div>
        <div class="row mt-3">
          <div class="col"><!-- First Column: CV Upload -->
            <div class="form-outline">
              <label class="form-label fw-medium" for="fileCv">السيرة الذاتية</label>
              <div class="d-flex align-items-center gap-2"> 
                <label for="fileCv" class="btn btn-secondary bg-primary-subtle text-primary fw-medium border p-2"> اختر الملف <i class="bi bi-box-arrow-in-down mx-1"></i></label>
                <input type="file" id="fileCv" name="fileCv" style="display: none;" accept=".pdf" onchange="showFileName('fileCv')" disabled>
                  <div class="flex-grow-1 border border-secondary border-opacity-50 rounded p-1">
                    <div class="d-flex justify-content-between align-items-center">
                      <div class="d-flex align-items-center">
                        <i class="bi bi-file-earmark-text-fill fs-4 px-2 text-secondary opacity-50"></i>
                        <span class="text-muted px-2 d-inline-block text-truncate" style="max-width: 150px;">
                        <?php  if(isset($CvFile))  {?>
                          <div id="fileCvfileExist"><?= $CvFile?></div>
                        <?php } else {  ?>
                          <div id="fileCvErrorMessage" >لا يوجد ملف مرفق</div>
                        <?php } ?>
                          <div id="fileCvName"></div>
                        </span>
                      </div>
                      <div class="d-flex justify-content-end" id="fileCvFileButtons">
                        <i class="bi bi-trash3 fs-4 px-2 text-danger opacity-50"></i>
                        <button type="button" class="btn p-0" onclick="triggerFileChange('fileCv')" aria-label="Change File">
                            <i class="bi bi-arrow-repeat fs-4 px-2 text-success opacity-50"></i>
                        </button>
                      </div>
                    </div>
                  </div>
              </div>
            </div>
          </div>
          <div class="col"> <!-- Second Column: Training Letter Upload -->
            <div class="form-outline"> 
              <label class="form-label fw-medium" for="fileCoop">خطاب التدريب</label>
              <div class="d-flex align-items-center gap-2">
                <label for="fileCoop" class="btn btn-secondary bg-primary-subtle text-primary fw-medium border p-2"> اختر الملف <i class="bi bi-box-arrow-in-down mx-1"></i></label>
                <input type="file" id="fileCoop" name="fileCoop" style="display: none;" accept=".pdf" onchange="showFileName('fileCoop')" disabled>
                  <div class="flex-grow-1 border border-secondary border-opacity-50 rounded p-1">
                    <div class="d-flex justify-content-between align-items-center">
                      <div class="d-flex align-items-center">
                        <i class="bi bi-file-earmark-text-fill fs-4 px-2 text-secondary opacity-50"></i>
                        <span class="text-muted px-2  d-inline-block text-truncate" style="max-width: 150px;">
                        <?php  if(isset($CoopFile))  {?>
                          <div id="fileCoopfileExist"><?= $CoopFile?></div>
                        <?php } else {  ?>
                          <div id="fileCoopErrorMessage">لا يوجد ملف مرفق</div>
                        <?php } ?>
                          <div id="fileCoopName"></div>
                      </div>
                      <div class="d-flex justify-content-end" id="fileCoopFileButtons">
                        <i class="bi bi-trash3 fs-4 px-2 text-danger opacity-50"></i>
                        <button type="button" class="btn p-0" onclick="triggerFileChange('fileCoop')" aria-label="Change File">
                            <i class="bi bi-arrow-repeat fs-4 px-2 text-success opacity-50"></i>
                        </button>
                      </div>
                    </div>
                  </div> 
              </div>
            </div>
          </div>
        </div>
        <div class="d-flex d-flex justify-content-end mt-3">
          <button type="submit" id="saveButton" class=" btn btn-outline-primary mt-3 fw-medium" style="display: none;">حفظ التغييرات</button>
        </div>
      </form>
    </div>

  </div>
</div>
<script>
  
    // Your JavaScript code here
    const errorMessageCv = document.getElementById('fileCvErrorMessage');
    const fileButtonsCv = document.getElementById('fileCvFileButtons');
    if(errorMessageCv){
      fileButtonsCv.classList.add('d-none');
    }
    const errorMessageCoop = document.getElementById('fileCoopErrorMessage');
    const fileButtonsCoop = document.getElementById('fileCoopFileButtons');
    if(errorMessageCoop){
      fileButtonsCoop.classList.add('d-none');
    }
    
  document.getElementById("editButton").addEventListener("click", function(event) {
    event.preventDefault();
    const inputs = document.querySelectorAll("form input, form button");
    
    inputs.forEach(input => input.removeAttribute("disabled"));
    
    // Show the Save button
    document.getElementById("saveButton").style.display = "block";
    
    
    // Hide the Edit button
    this.style.display = "none";
  });
document.getElementById('fileCv').addEventListener('change', function () {
    const fileNameSpan = document.getElementById('fileCvName');
    if (this.files.length > 0) {
        fileNameSpan.textContent = this.files[0].name; // Display the file name
    } else {
        fileNameSpan.textContent = ''; // Clear the span if no file is selected
    }
});
  function triggerFileChange(inputId) {
    const fileInput = document.getElementById(inputId);
    if (fileInput) {
        fileInput.click();
    } else {
        console.error(`File input with ID "${inputId}" not found.`);
    }
}

function showFileName(inputId) {
    // Get the file input and corresponding span elements
    const fileInput = document.getElementById(inputId);
    const fileNameSpan = document.getElementById(inputId + "Name");
    const fileExist = document.getElementById(inputId + "fileExist");
    const error = document.getElementById(inputId +"ErrorMessage");
    const buttons = document.getElementById(inputId +"FileButtons");

    // Display the selected file name
    if (fileInput.files.length > 0) {
        fileNameSpan.textContent = fileInput.files[0].name; // Show new file name
        if (fileExist) {
            fileExist.style.display = "none"; // Hide the existing file element
        }
        if (error) {
          error.style.display = "none"; // Hide the existing file element
           if(error.style.display = "none"){
            buttons.classList.remove('d-none');
           }
          
        }
    } else {
        fileNameSpan.textContent = ""; // Clear the new file name display
        if (fileExist) {
            fileExist.style.display = ""; // Show the existing file element again
        }
        if (error) {
          error.style.display = ""; // Show the existing file element again
        }
    }
}
</script>

<?php
require_once 'template/footer.php'; ?>

