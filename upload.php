<?php

include '/core/user.php';

$user = new users();

$temp = explode(".", $_FILES["file"]["name"]);

$extension = end($temp);  //extracting extentions of the file

if ($extension == "csv") {
  if ($_FILES["file"]["error"] > 0) {
    echo "01";            //File upload error code
  } else {
  	//
      move_uploaded_file($_FILES["file"]["tmp_name"], 
      	"upload/".$_FILES["file"]["name"]);

      $address = 'upload/'.$_FILES["file"]["name"];
      if($user->entry($address))
		echo '11';            //Success code
	  else
	  	echo '00';          //Database insert error code
  }
} else {
  echo "10";               //File Extension error code


?>