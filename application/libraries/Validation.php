<?php

class Validation {

    function set_blank_parameter($parameter, $value = "string") {

        ///$PARAMETER=VALUE OF PARAMETER 
        ///$VALUE=PARAMATER IS STRING OF INT ,,BY DEFUKT VALUE IS STRING
        ////////////////////  SET BLANK(IF STRING THEN BLANK ,IF INT THEN 0 ) PARAMETER VALUE IF NOT EXIT
        if ($parameter == "") {
            if ($value == "int") {
                return 0;
            } else {
                return "";
            }
        } else {
            return $parameter;
        }
    }

    function is_parameter_blank($keyname, $parameter, $message = null) {
        //$KEYNAME=KEY OF PARAMAERER
        //$PARAMARER=VALUE OF PARAMERER
        //$MESSAGE=IF NEED CUSTOM MESSAGE IN ERROR
        /////////////  PARAMETER VALUE IS EXIT OR NOT WITH TRIM
        if (strlen(trim($parameter)) == 0) {
            if ($message == null) {
                $return = error_res("Please enter " . $keyname);
            } else {
                $return = error_res($message);
            }
            $return['statuscode'] = 403;
            echo json_encode($return);
            die;
        }
    }

    function is_parameter($keyname, $parameter, $message = null) {

        ///$KEYNAME=KEY NAME OF PARAMETE
        //$PARAMETER=VALUE OF PARAMETER
        //$MESSAFE=IF NEED CUSTOM MESSAFE IN ERROR RESPONSE
        //////////////// PARAMTER VALUE IS EXIT OR NOT WITHOUT TRIM
        if ($parameter == "") {
            if ($message == null) {
                $return = error_res("Please enter " . $keyname);
            } else {
                $return = error_res($message);
            }
            $return['statuscode'] = 403;
            echo json_encode($return);
            die;
        }
    }

    function is_numeric($keyname, $parameter, $message = null) {
        //$KEYNAME=KEYNAME OF PARAMETER
        //$PARAMTER=VALUE OF PARAMETER
        //$MESSAGE=IF NEED CUSTOM MESSAFE IN ERROR IN RESPONSE
        //////////////// NUMERIC DATA VALIDATION
        if ($parameter == "") {
            if ($message == null) {
                $return = error_res("Please enter " . $keyname);
            } else {
                $return = error_res($message);
            }
            $return['statuscode'] = 403;
            echo json_encode($return);
            die;
        }
        if (!is_numeric($parameter)) {

            if ($message == null) {
                $return = error_res("Please enter numeric " . $keyname);
            } else {
                $return = error_res($message);
            }
            $return['statuscode'] = 403;
            echo json_encode($return);
            die;
        }
    }

    function is_valid_email($keyname, $parameter, $message = null) {
        //$KEYNAME=KEY NAME OF EMAIL
        //$PARAMETER=VALUE OF EMAIL
        // EMAIL ADDRESS VALIDATION
        if (!filter_var($parameter, FILTER_VALIDATE_EMAIL)) {
            if ($message == null) {
                $return = error_res("Please enter valid " . $keyname);
            } else {
                $return = error_res($message);
            }
            $return['statuscode'] = 403;
            echo json_encode($return);
            die;
        }
    }

    function is_website($keyname, $parameter, $message = null) {
//$KEYNAME=KEY NAME OF WEBSITE
//PARAMETER= VALUE OF PARAMETER        
//////////// WEBSITE URL VALIDATION
        if (filter_var($parameter, FILTER_VALIDATE_URL) === false) {
            if ($message == null) {
                $return = error_res("Please enter valid " . $keyname);
            } else {
                $return = error_res($message);
            }
            $return['statuscode'] = 403;
            echo json_encode($return);
            die;
        }
    }

    function is_phone_number($keyname, $parameter, $message = null) {
        //$KEYNAME=KEY NAME OF PHONE NUMBER
        //$PARAMETER=VALUE OF PHONE NUMBER
        //$MESSAFE=IF NEED CUSTOM MESSAGE IN ERROR RESPONSE
        ////////////// PHONE NUMBER VALIDATION
        if (!preg_match('/^[0-9]{3}-[0-9]{3}-[0-9]{4}$/', $parameter)) {

            if ($message == null) {
                $return = error_res("Please enter valid " . $keyname);
            } else {
                $return = error_res($message);
            }
            $return['statuscode'] = 403;
            echo json_encode($return);
            die;
        }
    }

    function file_upload($file_key, $folder_path) {
//////////////////// MOVE TO UPLOAD FILE TO FOLDER
        //////////////$file_key=KEY NAME OF $_FILE
        //////////////$folder_path=PATH OF DESITINAMTION FOLDER

        if ($_FILES[$file_key]["name"] !== "") {
            $temp = explode(".", $_FILES[$file_key]["name"]);
            $extension = end($temp);

            $temp_name = date('YmdHis');
            $random1 = generateRandomString(5);
            $file_name = $temp_name . "_" . $random1 . "." . $extension;
            $file_path = $folder_path . "/" . $file_name;
            if (move_uploaded_file($_FILES[$file_key]['tmp_name'], $file_path)) {
                return $file_name;
            } else {
                return "";
            }
        } else {

            return "";
        }
    }

    function is_optional($keyname, $parameter) {
        ///$KEYNAME=KEY NAME OF PARAMETER
        //$PARAMETER=VALUE OF PARAMETER
/////////////// IF NEED OPTION VALUE THEN
//////////////////IF NEED BLANK VALUE IN REPSONSE THEN PASS PARAMETER VALUE=#@blank458*!$9
        if ($parameter == '#@blank458*!$9') {
            return "''";
        }

        if ($parameter == "") {
            return $keyname;
        } else {
            ///////////////REMOVE UNESCCESSARU SPACE AND ADD SPLACES FOR MYSQL
            return "'" . mysql_escape_string($parameter) . "'";
        }
    }

    function createThumbs($source_file, $folde_path, $max_width) {

        /////////// CREATE THUMB
        $max_height = $max_width;
        $temp_image_source_path = explode("/", $source_file);
        $image_name = end($temp_image_source_path);
        $dst_dir = $folde_path . "/" . $image_name;
        $quality = 100;
        $imgsize = getimagesize($source_file);
        $width = $imgsize[0];
        $height = $imgsize[1];
        $mime = $imgsize['mime'];
        switch ($mime) {
            case 'image/gif':
                $image_create = "imagecreatefromgif";
                $image = "imagegif";
                break;

            case 'image/png':
                $image_create = "imagecreatefrompng";
                $image = "imagepng";
                $quality = 7;
                break;

            case 'image/jpeg':
                $image_create = "imagecreatefromjpeg";
                $image = "imagejpeg";
                $quality = 80;
                break;
            default:
                return false;
                break;
        }
        $dst_img = imagecreatetruecolor($max_width, $max_height);
        ///////////////
        imagealphablending($dst_img, false);
        imagesavealpha($dst_img, true);
        ///IF IMAGE IS TRANSPERANT THEN THUMBNAI RESIZABLE IMAGE WILL TRANSPERANT ,,IF NOT USE THIS FUNCTION GET IMAGE BACKGROUD WHITE
        $transparent = imagecolorallocatealpha($dst_img, 255, 255, 255, 127);
        imagefilledrectangle($dst_img, 0, 0, $max_width, $max_height, $transparent);
        /////////////
        $src_img = $image_create($source_file);
        $width_new = $height * $max_width / $max_height;
        $height_new = $width * $max_height / $max_width;
        //if the new width is greater than the actual width of the image, then the height is too large and the rest cut off, or vice versa
        if ($width_new > $width) {
            //cut point by height
            $h_point = (($height - $height_new) / 2);
            //copy image
            imagecopyresampled($dst_img, $src_img, 0, 0, 0, $h_point, $max_width, $max_height, $width, $height_new);
        } else {
            //cut point by width
            $w_point = (($width - $width_new) / 2);
            imagecopyresampled($dst_img, $src_img, 0, 0, $w_point, 0, $max_width, $max_height, $width_new, $height);
        }
        $image($dst_img, $dst_dir, $quality);
        if ($dst_img)
            imagedestroy($dst_img);
        if ($src_img)
            imagedestroy($src_img);
    }

    function resize_and_crop($source_file, $dst_dir, $max_width, $max_height) {
        ///RESIZE AND CROP FUNCTIONLITY
        //  $max_height = $max_width;
        //    $temp_image_source_path = explode("/", $source_file);
        //  $image_name = end($temp_image_source_path);
        //$dst_dir = $folde_path . "/" . $image_name;

        $quality = 80;
        $imgsize = getimagesize($source_file);
        $width = $imgsize[0];
        $height = $imgsize[1];
        $mime = $imgsize['mime'];
        ///GET FUNCTION BY MIME TYPE OF IMAGE
        switch ($mime) {
            case 'image/gif':
                $image_create = "imagecreatefromgif";
                $image = "imagegif";
                break;

            case 'image/png':
                $image_create = "imagecreatefrompng";
                $image = "imagepng";
                $quality = 7;
                break;

            case 'image/jpeg':
                $image_create = "imagecreatefromjpeg";
                $image = "imagejpeg";
                $quality = 80;
                break;

            default:
                return false;
                break;
        }
        $dst_img = imagecreatetruecolor($max_width, $max_height);
        ///////////////IMAGINARY IMAGE CRATE FORM TRUE COLOR
        imagealphablending($dst_img, false);
        imagesavealpha($dst_img, true);
        $transparent = imagecolorallocatealpha($dst_img, 255, 255, 255, 127);
        imagefilledrectangle($dst_img, 0, 0, $max_width, $max_height, $transparent);
        /////////////
        $src_img = $image_create($source_file);
        $width_new = $height * $max_width / $max_height;
        $height_new = $width * $max_height / $max_width;
        //if the new width is greater than the actual width of the image, then the height is too large and the rest cut off, or vice versa
        if ($width_new > $width) {
            //CUT POINT BY HEIGHT
            $h_point = (($height - $height_new) / 2);
            //COPY IMAGE
            imagecopyresampled($dst_img, $src_img, 0, 0, 0, $h_point, $max_width, $max_height, $width, $height_new);
        } else {
            //CUT POINT BY WIDTH
            $w_point = (($width - $width_new) / 2);
            imagecopyresampled($dst_img, $src_img, 0, 0, $w_point, 0, $max_width, $max_height, $width_new, $height);
        }
        $image($dst_img, $dst_dir, $quality);
        if ($dst_img)
            imagedestroy($dst_img);
        if ($src_img)
            imagedestroy($src_img);
    }

}
