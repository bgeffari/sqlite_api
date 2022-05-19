<?php
$db = new SQLite3('fg_data.db', SQLITE3_OPEN_CREATE | SQLITE3_OPEN_READWRITE);

if(isset($_GET['get_alarms']) && isset($_GET['profile_id'])){
    $profile_id = trim($_GET['profile_id']);
    $query = "SELECT json_group_array(json_array(id, title, sun, mon, tue, wed, thu, start_time, end_time, start_file, end_file)) as result from alarms where profile_id='".$profile_id."'";

$result = $db->querySingle($query, true);

echo  $result["result"];


    
}elseif(isset($_GET['timedate'])){

    $result = time()."|Next Alarm AAA|Active Profile (Profile 1)" ;
    echo json_encode(explode("|",$result));


}elseif(isset($_GET['profiles'])){

$query = "SELECT json_group_array(json_array(id, profile)) as result from profiles ";

$result = $db->querySingle($query, true);

echo  $result["result"];


}elseif(isset($_POST['update_alarm']) && isset($_POST['title']) && isset($_POST['id']) && (count($_POST) > 10)){

    $sql = "UPDATE alarms SET title='{$_POST['title']}', sun={$_POST['sun']}, mon={$_POST['mon']}, tue={$_POST['tue']}, wed={$_POST['wed']}, thu={$_POST['thu']}, start_time='{$_POST['start_time']}', end_time='{$_POST['end_time']}', start_file='{$_POST['start_file']}', end_file='{$_POST['end_file']}' where id={$_POST['id']}";
    $query = $db->exec($sql) ;

 if($query )   {
    
    echo "update OK";
 }else{
    echo "update error";
 }

 

}elseif(isset($_POST['insert_alarm']) && isset($_POST['title']) && isset($_POST['profile_id']) && (count($_POST) > 10)){



    $sql = "INSERT INTO alarms (title, sun, mon, tue, wed, thu, start_time, end_time, start_file, end_file, profile_id) VALUES ('{$_POST['title']}', {$_POST['sun']}, {$_POST['mon']}, {$_POST['tue']}, {$_POST['wed']}, {$_POST['thu']}, '{$_POST['start_time']}', '{$_POST['end_time']}', '{$_POST['start_file']}', '{$_POST['end_file']}', '{$_POST['profile_id']}')";
    $query = $db->exec($sql) ;

    if($query )   {
       
       echo "insert OK";
    }else{
       echo "insert error";
    }
 


}else{

    echo "Error: use currect API parameters";

}




$db->close();

?>