<?php

 class Upload {

   protected $uploadDir ; // المجلد اللي بيرفع فيه الملف
   protected $defaultUploadDir = 'uploads'; // المجلد الافتراضي اللي بيرفع فيه الملف
   public $file ;
   public $fileName ;
   public $filePath ;
   protected $rootDir ;// المتغير ذا يحدد وين موجود التطبيق حقك ب السيرفر مش دايم ترفع الصور عندك في السيرفر في احتمال ترفعها برا السيرفر حقك
   protected $errors = [];

   public function __construct($uploadDir , $rootDir = false)
   {
       if($rootDir){
         $this->rootDir = $rootDir;
       }else {
        // اذا المستخدم ما حدد مجلد الروت راح يكون هذا المسار هو الروت دايركتوري لرفع الملفات
            $this->rootDir = $_SERVER['DOCUMENT_ROOT'] .'/' . 'mueen';
       }
       $this->filePath = $uploadDir;
       $this->uploadDir = $this->rootDir.'/'.$uploadDir;

   }
   // هنا يتحقق من الاخطاء برفع الملف
   protected function validate(){

     if(!$this->isSizeAllowed()){
       array_push($this->errors, 'File size not allowed');
     }elseif (!$this->isMimeAllowed()) {
       array_push($this->errors, 'File type not allowed');
     }

     return $this->errors;
   }

   // يتاكد من الملجد هل هو موجود او لا ، اذا كان مو موجود بيسوي واحد جديد
   protected function createUploadDir(){
    if(!is_dir($this->uploadDir)){
        umask(0);
        echo "Creating directory at: " . $this->uploadDir;  // Debug line
        if(!mkdir($this->uploadDir, 0775, true)){  // `true` enables recursive directory creation
            array_push($this->errors, 'Could not create upload dir');
            return false;
        }
    }
    return true;
}


 // هنا اجمع كل الاخطاء علشان يرجعون لي من مكان واحد
   public function upload(){

     $this->fileName = $this->file['name'];
     $this->filePath .= '/'.$this->fileName;

     if($this->validate()){

       return $this->errors;

     }elseif(!$this->createUploadDir()){
       return $this->errors;
     }
     elseif(!move_uploaded_file($this->file['tmp_name'], $this->uploadDir.'/'.$this->fileName)){
       array_push($this->errors, 'Errors uploading your file');
     }
     return $this->errors;
   }

    // التحقق هل الملف المرفوع من الامتدادات المسموحة أم لا
   protected function isMimeAllowed(){


     $fileMimeType = mime_content_type($this->file['tmp_name']);
     if($fileMimeType ===! 'application/pdf'){
        return false;
     }
     return true;

   }

   // التحقق من حجم الملف
   protected function isSizeAllowed(){

     $maxFileSize = 10 * 1024 * 1024 ;
     $fileSize = $this->file['size'];

     if($fileSize > $maxFileSize){
      return false;
     }
    return true;
 }
}
