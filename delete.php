<?php
include('db.php');
if(isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM tblEvent WHERE id='$id';DELETE FROM tblEventOccurrence WHERE eventId='$id';";
    $stmt = $con->prepare($sql);
    $stmt->execute();    
    header('location: events.php');
}
?>