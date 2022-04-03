<?php
class Upload
{
    protected $uploadDir;
    protected $defaultUploadDir = 'uploads';
    public $file;
    public $fileName;
    public $filePath;
    public $rootDir;
    public $errors = [];

    public function __construct($uploadDir, $rootDir = false)
    {
        if ($rootDir) {
            $this->rootDir = $rootDir;
        } else {
            $this->rootDir = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'project_php';

        }
        $this->filePath  = $uploadDir;
        $this->uploadDir = $this->rootDir . '/' . $uploadDir;

    }
    protected function isMimeAllowed()
    {
        $allowed = [
            'jpg' => 'image/jpeg',
            'png' => 'image/png',
            'gif' => 'image/gif',
        ];
         $fileMainType = mime_content_type($this->file['tmp_name']);

        if (!in_array($fileMainType, $allowed)) {
            return false;
        }
        return true;
    }

    protected function validate()
    {
        if (!$this->isSizeAllow()) {
            array_push($this->errors, 'حجم ملف كبير');
        }
        if (!$this->isMimeAllowed()) {
            array_push($this->errors, 'امتداد الملف ممنوع');
        }
        return $this->errors;
    }

    protected function createUploadDir()
    {
        if (!is_dir($this->uploadDir)) {
            umask(0);
            if (!mkdir(!$this->uploadDir, 0775)) {
                array_push($this->errors, 'error uploading');
                return false;
            }
        }
        return true;
    }

    public function upload()
    {

        $this->fileName = time() . $this->file['name'];

        $this->filePath .= '/' . $this->fileName;

        if ($this->validate()) {
            return $this->errors;
        } elseif (!$this->createUploadDir()) {
            return $this->errors;
        } elseif (!move_uploaded_file($this->file['tmp_name'], $this->uploadDir . '/' . $this->fileName)) {
            array_push($this->errors, 'Error uploading your file');
        }
         return $this->errors;
    }
    protected function isSizeAllow()
    {
         $maxSize  = 50 * 1024;
        $fileSize = $this->file['size'];
        if ($fileSize > $maxSize) {
            return false;
        }
        return true;
    }

};
