<?php
    if(isset($_POST['update_p'])){
        
        include("../../../config/connection.php");
        header("Content-type:application/json");
        
        $rePrice = "/^([0-9]*[.])?[0-9]+$/";

        $greske = [];
        $code=null;
        $data=[];

        $prodid = $_POST['id_p'];
        $name = $_POST['name'];
        $desc = $_POST['desc'];
        $price = $_POST['price'];
        
        $file = $_FILES['file'];
        $fileName= $file['name'];
        $tmpName= $file['tmp_name'];
        $fileSize= $file['size'];
        $fileType= $file['type'];
        $fileError= $file['error'];
        
        $thumbFile = $_FILES['filecopy'];
        $thumbFileName= $thumbFile['name'];
        $thumbTmpName= $thumbFile['tmp_name'];
        $thumbFileSize= $thumbFile['size'];
        $thumbFileType= $thumbFile['type'];
        $thumbFileError= $thumbFile['error'];
        $uploadDir = "../../../assets/";

        $max_size=3;
        $max_size_bytes=$max_size*1024*1024;

        if($fileType!='image/jpg' && $fileType!='image/jpeg' && $fileType!='image/gif' && $fileType!='image/png') {
            array_push($greske, "Unrecognised picture format.");
        }
        if($fileSize>$max_size_bytes) {
            array_push($greske, "Picture too large.");
        }

        // $ogNewName = "img/".time().$fileName;
        // $ogFilePath = $uploadDir.$ogNewName;
        // $result1 = move_uploaded_file($tmpName,$ogFilePath);

        // obrada manje slike (thumbnail)

        list($width, $height) = getimagesize($thumbTmpName);
        $newWidth = 100;
        $proportion_rate = $width / $newWidth;
        $newHeight = $height * $proportion_rate;

        if( $thumbFileType== "image/jpeg" ) {
            $existing_pic= imagecreatefromjpeg($thumbTmpName); 
        } elseif( $thumbFileType== "image/gif" ) {
            $existing_pic= imagecreatefromgif($thumbTmpName);
        } elseif( $thumbFileType== "image/png" ) { 
            $existing_pic= imagecreatefrompng($thumbTmpName); 
        }

        $empty_pic = imagecreatetruecolor($newWidth,$newHeight);
        imagecopyresampled($empty_pic, $existing_pic, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
        $thumbnail = $empty_pic;

        $thumb_name = "img/".time()."_small_".$thumbFileName;

        $compression = 75;
        if( $thumbFileType== "image/jpeg" ) {
            imagejpeg($thumbnail,$thumb_name,$compression);
        } elseif( $thumbFileType== "image/gif" ) {
            imagejpeg($thumbnail,$thumb_name);
        } elseif( $thumbFileType== "image/png" ) { 
            imagejpeg($thumbnail,$thumb_name);
        }
        
        $ogNewName = "img/".time().$fileName;
        $ogFilePath = $uploadDir.$ogNewName;
        $result1 = move_uploaded_file($tmpName,$ogFilePath);
        $thumbFilePath = $uploadDir.$thumb_name;
        $result2 = move_uploaded_file($thumbTmpName,$thumbFilePath);

        if(count($greske)) {
            $code=422;
            $data=$greske;
        }
        else {
            
            

            $query1 = "UPDATE img SET src = :src, thumbnail = :thumb WHERE id_p = :id_p";
            $stmt1 = $konekcija->prepare($query1);
            $stmt1->bindParam(':src', $ogNewName);
            $stmt1->bindParam(':thumb', $thumb_name);
            $stmt1->bindParam(':id_p', $prodid);
            try{
                $code = $stmt1->execute() ? 201 : 500;
            }
            catch(PDOException $e){
                $code = 500;
                $data = $e;
            }
        }

        // -------------------

        if(!preg_match($rePrice,$price)) {
            array_push($greske, "Polje za cenu nije u dobrom formatu");
        }

        if(count($greske)){
            $code=422;
            $data=$greske;
        }
        else{
                try{
                        $query2 = "UPDATE product SET name = :name, description = :desc, price = :price WHERE id_p = :id_p";
                        $stmt2 = $konekcija->prepare($query2);
                        $stmt2->bindParam(':name', $name);
                        $stmt2->bindParam(':desc', $desc);
                        $stmt2->bindParam(':price', $price);
                        $stmt2->bindParam(':id_p', $prodid);
                        try{
                            $code = $stmt2->execute() ? 201 : 500;
                            $data[]=["uspesno"];
                        }
                        catch(PDOException $e){
                            $code = 500;
                            $data = $e;
                        }
                    }
                catch(PDOException $e){
                    $code=409;
                }
            }
        http_response_code($code);
        echo json_encode($data);
    }
?>