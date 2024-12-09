<?php 
require_once 'template/header.php';
require_once 'config/database.php';

if(!isset($_GET['id']) or !$_GET['id']){
    die("missing id parameter");
  }

 $st = $mysqli->prepare("SELECT r.request_date, c.job_name, c.company_name, r.request_status FROM request r 
    JOIN applicant a ON r.applicant_id = a.applicant_id JOIN job c ON r.job_id = c.job_id where a.applicant_id = ?;");
 $st->bind_param('i', $applicantId);
 $applicantId = $_GET['id'];
 $st->execute();
 $requests = $st->get_result()->fetch_all(MYSQLI_ASSOC);

?>
 
<link rel="stylesheet" href="css/table.css">

<div class="container pt-5">
    <div class="d-flex justify-content-between">
        <img src="http://localhost/mueen/images/back.png" class="rounded-circle" alt="" width="65" height="65">
        <form class="align-self-end" role="search">
            <input class="form-control me-2" type="search" placeholder=" ابحث" aria-label="Search">
        </form>
        <div class="gap-3 align-self-end">
            <button class="btn btn-light text-danger fw-medium" onclick="document.location='logout.php'">تسجيل الخروج</button>
        </div>
    </div>
    <div class="card mt-3 pb-4 mb-5 bg-light">
        <div class="card-header text-bg-primary" >
            <!-- تعديل -->
            <div class="container px-5" style="height: 60px ; background-repeat: repeat-x; background-position: right; background-image: url('http://localhost/mueen/images/image-removebg.png')"></div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table m-0">
                    <thead>
                        <tr>
                            <th scope="col" class="fw-light text-center">المسمى الوظيفي</th>
                            <th scope="col" class="fw-light text-center">اسم المنشأة</th>
                            <th scope="col" class="fw-light text-center">تاريخ التقديم</th>
                            <th scope="col" class="fw-light text-center">حالة التقديم </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                        <?php foreach ($requests as $request) {     ?>
                            <td scope="row"> <?php echo $request['job_name'];?></td>
                            <td><?= $request['company_name'] ?></td>
                            <td><?= $request['request_date']?></td>
                            <td>
                                <button class="btn <?php echo $request['request_status'] === 'in progress' ? 'btn btn-outline-primary btn-sm' : 
                                    ($request['request_status'] === 'Accepted' ? 'btn btn-outline-success btn-sm' : 'btn btn-outline-danger btn-sm'); ?>">
                                    <?php echo $request['request_status']; ?>
                                </button>
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

