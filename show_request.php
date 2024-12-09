<?php 
require_once 'template/header.php';
require_once 'config/database.php';

if(!isset($_GET['name']) or !$_GET['name']){
    die("missing id parameter");
  }

 $st = $mysqli->prepare("SELECT r.request_id, r.request_date, r.job_id, c.job_name, a.applicant_firstname, a.applicant_email, a.CV_file , a.university_major
FROM request r
JOIN applicant a ON r.applicant_id = a.applicant_id
JOIN job c ON r.job_id = c.job_id
where c.company_name = ? and r.request_status = 'Accepted';");

 $st->bind_param('s', $companyName);
 $companyName = $_GET['name'];
 $st->execute();
 $user = $st->get_result()->fetch_all(MYSQLI_ASSOC);

// delete button and query
    if(isset($_POST['request_id'])){

        $st = $mysqli->prepare("delete from request where request_id = ?");
          $st->bind_param('i', $requestId);
          $requestId = $_POST['request_id'];
          $st->execute();
      
          echo "<script>location.href = 'show_request.php?name=<?= $companyName ?>'</script>";
          die();
        }
?>
<link rel="stylesheet" href="css/table.css">

<div class="container pt-5">
    <div class="d-flex justify-content-between">
        <img src="http://localhost/mueen/src/img/back.png" class="rounded-circle" alt="" width="65" height="65">
        <form class="align-self-end" role="search">
            <input class="form-control me-2" type="search" placeholder=" ابحث" aria-label="Search">
        </form>
        <div class="gap-3 align-self-end">
            <!-- <button class="btn text-primary fs-5"><i class="bi bi-bell"></i></button> -->
            <button class="btn btn-light text-danger fw-medium" onclick="document.location='logout.php'">تسجيل الخروج</button>
        </div>
    </div>
    <div class="card mt-3 pb-4 mb-5 bg-light">
        <div class="card-header text-bg-primary" >
            <div class="container px-5" style="height: 60px ; background-repeat: repeat-x; background-position: right; background-image: url('http://localhost/mueen/src/img/image-removebg.png')"></div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table m-0">
                    <thead >
                        <tr>
                            <th scope="col" class="fw-light text-center text-secondary">الاسم</th>
                            <th scope="col" class="fw-light text-center">تاريخ الطلب</th>
                            <th scope="col" class="fw-light text-center">التخصص</th>
                            <th scope="col" class="fw-light text-center">البريد الإلكتروني</th>
                            <th scope="col" class="fw-light text-center"> المسمى الوظيفي</th>
                            <th scope="col" class="fw-light text-center">التفاصيل</th>
                            <th scope="col" class="fw-light text-center">حذف البيانات</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                        <?php foreach ($user as $job) {     ?>
                            <td scope="row"> <?php echo $job['applicant_firstname'];?></td>
                            <td><?= $job['request_date'] ?></td>
                            <td><?= $job['university_major']?></td>
                            <td><?php echo $job['applicant_email'];?></td>
                            <td><?php echo $job['job_name'];?></td>
                            <td><a href="http://localhost/mueen<?php echo $job['CV_file']; ?>" target="_blank" class="btn btn-outline-primary btn-sm">استعراض السيرة الذاتية</a></td>
                            <td>
                                <form method="POST" action="" onsubmit="return confirm('Are you sure you want to reject this request?');">
                                    <input type="hidden" name="request_id" value="<?php echo $job['request_id']; ?>">
                                    <button type="submit" class="btn btn-outline-danger btn-sm"> حذف <i class="bi bi-trash3"></i></button>
                                </form>
                            </td>
                        </tr>
                       <?php }?>
                       
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<?php
require_once 'template/footer.php'; ?>

