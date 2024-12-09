<?php 
require_once 'template/header.php';
require_once 'config/database.php';

if(!isset($_GET['name']) or !$_GET['name']){
    die("missing id parameter");
  }

 $st = $mysqli->prepare("SELECT r.request_id, r.request_date, r.job_id, c.job_name, a.applicant_firstname, a.applicant_email, a.CV_file , a.university_major
        FROM request r JOIN applicant a ON r.applicant_id = a.applicant_id
        JOIN job c ON r.job_id = c.job_id where c.company_name = ? and r.request_status = 'in progress';");
 $st->bind_param('s', $companyName);
 $companyName = $_GET['name'];
 $st->execute();
 $requests = $st->get_result()->fetch_all(MYSQLI_ASSOC);


 if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $requestId = $_POST['request_id'];
    $action = $_POST['action'];
    $status = $action === 'accept' ? 'Accepted' : ($action === 'reject' ? 'Rejected' : '');

    if ($status) {
        // Prepare and execute the update query
        $stmt = $mysqli->prepare("UPDATE request SET request_status = ? WHERE request_id = ?");
        $stmt->bind_param("si", $status, $requestId);
        $stmt->execute();

        echo "<script>location.href = 'action_request.php?name=<?= $companyName ?>'</script>";
        die();
        
    }
}
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
        <div class="card-header text-bg-primary">
            <!-- أعدله -->
            <div class="container px-5" style="height: 60px ; background-repeat: repeat-x; background-position: right; background-image: url('http://localhost/mueen/images/image-removebg.png')"></div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table m-0">
                    <thead>
                        <tr>
                            <th scope="col" class="fw-light text-center">الاسم</th>
                            <th scope="col" class="fw-light text-center">تاريخ الطلب</th>
                            <th scope="col" class="fw-light text-center">التخصص</th>
                            <th scope="col" class="fw-light text-center">البريد الإلكتروني</th>
                            <th scope="col" class="fw-light text-center"> المسمى الوظيفي</th>
                            <th scope="col" class="fw-light text-center">التفاصيل</th>
                            <th scope="col" class="fw-light text-center">قبول الطلب </th>
                            <th scope="col" class="fw-light text-center">رفض الطلب</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                        <?php foreach ($requests as $request) {     ?>
                            <td scope="row"> <?php echo $request['applicant_firstname'];?></td>
                            <td><?= $request['request_date'] ?></td>
                            <td><?= $request['university_major']?></td>
                            <td><?php echo $request['applicant_email'];?></td>
                            <td><?php echo $request['job_name'];?></td>
                            <td><a href="http://localhost/mueen<?php echo $request['CV_file']; ?>"   target="_blank" class="btn btn-outline-primary btn-sm">استعراض السيرة الذاتية</a></td>
                            <td>
                                <form method="POST" action="" onsubmit="return confirm('Are you sure you want to accept this request?');">
                                    <input type="hidden" name="request_id" value="<?php echo $request['request_id']; ?>">
                                    <input type="hidden" name="action" value="accept">
                                    <button type="submit" class="btn btn-outline-success btn-sm">
                                        قبول <i class="bi bi-check2"></i>
                                    </button>
                                </form>
                            </td>
                            <td>
                                <form method="POST" action="" onsubmit="return confirm('Are you sure you want to reject this request?');">
                                    <input type="hidden" name="request_id" value="<?php echo $request['request_id']; ?>">
                                    <input type="hidden" name="action" value="reject">
                                    <button type="submit" class="btn btn-outline-danger btn-sm">
                                        رفض <i class="bi bi-x-lg"></i>
                                    </button>
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

