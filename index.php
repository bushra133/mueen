<?php require_once 'template/header.php';
require_once 'config/database.php';
?>
<link rel="stylesheet" href="css/Homepage.css" />
 
<div class="container my-5 bg-gradient">
      <div class="row align-items-center">
        <div class="col-md-6">
          <h1 class="display-6 font-weight-bold ms-3">
            استثمر في مستقبلك، تدرب وابتكر!
          </h1>
          <p class="lead font-weight-normal">
            شركاتنا الرائدة تنتظرك سجّل الآن وابدأ رحلتك المهنية
          </p>
          <br />
          <br />
          <a
            href="student_register.php"
            class="btn btn-primary"
            style="width: 170px; height: 42px; font-size: 18px"
          >
            سجل الآن
          </a>
        </div>
        <div class="col-md-6 text-center">
          <img
            src="images/Students at graduation ceremony.png"
            alt="حفل التخرج"
            style="width: 449px; height: 352px"
            class="img-fluid"
          />
        </div>
      </div>
    </div>
    <div class="container my-5 bg-light rounded">
      <div class="row align-items-center">
        <div class="col-md-6 text-center">
          <img
            src="images/Students on the way to class.png"
            alt="حفل التخرج"
            style="width: 300px; height: 200px"
            class="img-fluid"
          />
        </div>
        <div class="col-md-6 align-items-center">
          <h2 class="display-6 font-weight-bold ms-3">عن مُعين</h2>
          <h3 class="display-6 font-weight-normal text-right">
            الجسر بين التعليم وسوق العمل
          </h3>
          <p class="lead font-weight-normal text-right">
            منصة مُعين هي الوجهة الشاملة للطلاب الباحثين عن فرص تدريب مميزة،
            والمؤسسات الراغبة في استقطاب أبرز الكفاءات. نقدم لك قاعدة بيانات
            واسعة من البرامج التدريبية، وأدوات بحث متطورة، وخدمات مخصصة لضمان
            تجربة سلسة ومثمرة للمستخدم.
          </p>
        </div>
      </div>
    </div>

    <div class="container-fluid mb-5">
      <div class="text-center mt-5">
        <h3>ما يميزنا؟</h3>
      </div>
      <div class="row">
        <div class="col-md-3">
          <div class="box">
            <div class="our-services settings">
              <div class="icon">
                <img src="images/Searching the web on tablet.png" />
              </div>
              <p>محرك بحث متطور</p>
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="box">
            <div class="our-services speedup">
              <div class="icon"><img src="images/Search.png" /></div>
              <p>تتبع حالات الطلب</p>
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="box">
            <div class="our-services ssl">
              <div class="icon">
                <img src="images/handshake.png" height="90" width="130" />
              </div>
              <p class="features">الشراكات و التعاون</p>
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="box">
            <div class="our-services backups">
              <div class="icon">
                <img src="images/Applying to university online.png" />
              </div>
              <p>تقديم إلكتروني سهل</p>
            </div>
          </div>
        </div>
      </div>

      <div class="container vision-mission-section">
        <div class="row">
          <!--  بطاقة الرؤية  و الرسالة-->
          <div class="col-md-6 d-flex justify-content-center">
            <div class="card card-custom">
              <h4 class="card-title">رؤيتنا</h4>
              <p class="card-text">
                أن نكون المنصة الرائدة في المنطقة التي تربط بين الطلاب والشركات،
                ونوفر بيئة تعليمية عملية تساعد الطلاب على اكتساب الخبرات المهنية
                اللازمة لدخول سوق العمل.
              </p>
            </div>
          </div>

          <div class="col-md-6 d-flex justify-content-center">
            <div class="card card-custom">
              <h4 class="card-title">رسالتنا</h4>
              <p class="card-text">
                تمكين الطلاب من تحقيق أقصى استفادة من دراستهم من خلال توفير فرص
                تدريب عالية الجودة، ومساعدة الشركات على اكتشاف المواهب الشابة
                وتطويرها.
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="container partners-section text-center">
      <h3 class="mb-4">شركاؤنا</h3>
      <div class="scrolling-wrapper">
        <!-- صور الشركاء -->
        <img src="images/image 5.png" alt="Partner 1" />
        <img src="images/image 3.png" alt="Partner 2" />
        <img src="images/image 4.png" alt="Partner 3" />
        <img src="images/image 2.png" alt="Partner 4" />
        <img src="images/image 8.png" alt="Partner 5" />
        <img src="images/image 6.png" alt="Partner 6" />
      </div>
    </div>

    <div class="container my-5">
      <!-- قسم التعليقات -->
      <div class="comments-section">
        <h3 class="mb-4">تقييم مستخدمي مُعين</h3>

        <!-- عرض التعليقات كالبطاقات -->
        <div class="comment-card">
          <div class="d-flex align-items-start">
            <img src="images/Ellipse 5.png" alt="User Avatar" class="avatar" />
            <div>
              <h5 class="username">أمجاد شريف</h5>
              <small class="comment-date">12 نوفمبر 2024</small>
              <p class="comment-text">
                لقد استفدت كثيراً من منصة معين حيث تميزت بتقديم خيارات للتدريب
                والتواصل مع الشركات...
              </p>
            </div>
          </div>
        </div>

        <div class="comment-card">
          <div class="d-flex align-items-start">
            <img
              src="images/Ellipse 5-1.png"
              alt="User Avatar"
              class="avatar"
            />
            <div>
              <h5 class="username">بشرى المحيميد</h5>
              <small class="comment-date">10 نوفمبر 2024</small>
              <p class="comment-text">
                منصة معين هي الوجهة الأولى لاكتشاف فرص التدريب التي تتناسب مع
                تخصصي وتطلعاتي المهنية...
              </p>
            </div>
          </div>
        </div>

        <!-- إضافة تعليق جديد -->
        <div class="add-comment mt-4">
          <h5>أضف تعليقك</h5>
          <form>
            <div class="form-group">
              <textarea
                class="form-control"
                placeholder="اكتب تعليقك هنا..."
                required
              ></textarea>
            </div>
            <button type="submit" class="btn">إرسال</button>
          </form>
        </div>
      </div>
    </div>
<?php 
require_once 'template/footer.php'; ?>

