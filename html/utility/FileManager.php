<?php

    class FileManager{

        private $imgPath = "../img/";
        private $allowedImageTypes = [
                    'image/png' => 'png',
                    'image/jpeg' => 'jpg'
                ];
         

        public $err = false;

        public function path()
        {
            echo getcwd();
        }

        public function uploadImage($fileName)
        {
            if (!isset($_FILES[$fileName])) {
                $err = "Hiba a fájl feltöltésekor";
                return false;
            }


            $filepath = $_FILES[$fileName]['tmp_name'];
            $fileSize = filesize($filepath);
            $fileinfo = finfo_open(FILEINFO_MIME_TYPE);
            $filetype = finfo_file($fileinfo, $filepath);

            if ($fileSize === 0) {
                $err = "A fájl üres";
                unlink($filepath);
                return false;
            }
            

            if ($fileSize > 10485760) {
                $err = "A fájl túl nagy. Max méret: 10MB";
                unlink($filepath);
                return false;
            }

            if(!in_array($filetype, array_keys($this->allowedImageTypes))) {
                $err = "Nem megengedett fájlkiterjesztés";
                unlink($filepath);
                return false;
            }
            

            $basename = basename($_FILES[$fileName]["name"]);
            $extension = $this->allowedImageTypes[$filetype];
            $newPath = $this->imgPath . $basename;

            

            if (file_exists($newPath)) {
                
            

                if ($this->checkDuplicate($this->imgPath, $filepath)) {
                    //echo "Dupe\n";
                    $err = false;
                    unlink($filepath);
                    $sanitizedPath = filter_var($newPath, FILTER_SANITIZE_STRING);
                    return $sanitizedPath;
                } else {
                    $newPath = $this->getIndexedName($this->imgPath, basename($basename, "." . $extension), $extension);
                }
            }

            $sanitizedPath = filter_var($newPath, FILTER_SANITIZE_STRING);


            if (!copy($filepath, $sanitizedPath )) {
                unlink($filepath);
                $err = "Hiba a fájl mentésekor";
                return false;
            }
            unlink($filepath);
             
            $err = false;
            return $newPath;
        }

        private function checkDuplicate($directoryPath, $newFilePath)
        {
            $size = filesize($newFilePath);
            $hash = md5_file($newFilePath);

            $dir = new DirectoryIterator($directoryPath);
            foreach ($dir as $fileinfo) {
                if (!$fileinfo->isDot() && $fileinfo->getSize() == $size && md5_file($fileinfo->getRealPath())) {
                    return true;
                }
            }

            return false;
        }

        private function getIndexedName($folder, $fileName, $extension)
        {
            $i = 0;
            $newPath = $folder . $fileName . "(" . $i . ")." . $extension;
            while (file_exists($newPath)) {
                $i++;
                $newPath = $folder .  $fileName . "(" . $i . ")." . $extension;
            }

            return $newPath;
        }

        private function saveFile($fileName)
        {
            
        }

    }
?>