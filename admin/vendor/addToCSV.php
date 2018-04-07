<?php

$fp = file('../../database/data.csv', FILE_SKIP_EMPTY_LINES);
$last_row = array_pop($fp);
$data = str_getcsv($last_row);



$target_dir = "../../img/product/";
$target_file = $target_dir . basename($_FILES["file"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["file"]["tmp_name"]);
    if($check !== false) {
        
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
}
// Check if file already exists
if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}
// Check file size
if ($_FILES["file"]["size"] > 3145728) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    
		$id = ($data[0]+1);
		$name = $_POST['name'];
		$code = $_POST['code'];
		$disc = $_POST['disc'];
		$price = $_POST['price'];
		move_uploaded_file($_FILES["file"]["tmp_name"], $target_file);
		$list = array($id.",".$name.",".$code.",".$disc.",".basename( $_FILES["file"]["name"]).",".$price);
		$file = fopen("../../database/data.csv","a");

		foreach ($list as $line)
		  {
		  fputcsv($file,explode(',',$line));
		  }

		header("Location: ../add_product.html");
}

//fputcsv($file,explode(',',$line));

?>