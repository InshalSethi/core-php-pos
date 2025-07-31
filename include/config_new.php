<?php
   
  
include "data.php";


function upload($file_id, $folder="", $types="") {
    if(!$_FILES[$file_id]['name']) return array('','No file specified');

     $file_title = $_FILES[$file_id]['name'];
    //Get file extension
    $ext_arr = explode(".",basename($file_title));
    $ext = strtolower($ext_arr[count($ext_arr)-1]); //Get the last extension

    //Not really uniqe - but for all practical reasons, it is
    $uniqer = substr(md5(uniqid(rand(),1)),0,5);
    $file_name = $uniqer . '_' . $file_title;//Get Unique Name

    $all_types = explode(",",strtolower($types));
    if($types) {
        if(in_array($ext,$all_types));
        else {
            $result = "'".$_FILES[$file_id]['name']."' is not a valid file."; //Show error if any.
            return array('',$result);
        }
    }

    //Where the file must be uploaded to
    if($folder) $folder .= '/';//Add a '/' at the end of the folder
    $uploadfile = $folder . $file_name;

    $result = '';
    //Move the file from the stored location to the new location
    if (!move_uploaded_file($_FILES[$file_id]['tmp_name'], $uploadfile)) {
        $result = "Cannot upload the file '".$_FILES[$file_id]['name']."'"; //Show error if any.
        if(!file_exists($folder)) {
            $result .= " : Folder don't exist.";
        } elseif(!is_writable($folder)) {
            $result .= " : Folder not writable.";
        } elseif(!is_writable($uploadfile)) {
            $result .= " : File not writable.";
        }
        $file_name = '';
        
    } else {
        if(!$_FILES[$file_id]['size']) { //Check if the file is made
            @unlink($uploadfile);//Delete the Empty file
            $file_name = '';
            $result = "Empty file found - please use a valid file."; //Show the error message
        } else {
            chmod($uploadfile,0777);//Make it universally writable.
        }
    }

    return array($file_name,$result);
}

/*if (isset($_POST['submit'])) {

     $email =$_POST['email'];
    $user_name = $_POST['user_name'];
    $password = $_POST['password'];
    $status = $_POST['optionsRadiosInline'];
    
    $email = mysqli_real_escape_string($conn,trim($_POST['email']));
    $user_name = mysqli_real_escape_string($conn,trim($_POST['user_name']));
    $password = mysqli_real_escape_string($conn,trim($_POST['password']));
    $status = mysqli_real_escape_string($conn,trim($_POST['optionsRadiosInline']));

    $a= new crud();
   

/*$upd=array('username'=>'root',
'password'=>'12345678',
'email'=>'badshah@gmail.com');*/
//$a->update('user',$upd,array('id=3','id=4','id=5','id=6'));
//$a->delete('user',' id = 1');
/*$ins=array('',$email,$user_name,$password,$status);
if($a->insert('register',$ins,null)==true)
{
 echo "Inserted";    
}
else {
    echo "Not Inserted";
}*/

//$ab=$a->select('member');
//while($a=$ab->fetch_array()){
 // echo $a[0]." ".$a[1]." ".$a[2]."<br />";
//}
//}

 function createslug($slug){

   $lettersNumbersSpacesHypens  = '/[^\-\s\pN\pL]+/u';
  $spacesDuplcateHypens = '/[\-\s]+/';
   $slug = preg_replace($lettersNumbersSpacesHypens,'',mb_strtolower($slug,'UTF-8'));
    $slug =preg_replace( $spacesDuplcateHypens,'-',$slug);
     $slug = trim($slug,'-');
   return $slug;

}
?>