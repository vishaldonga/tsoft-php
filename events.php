<?php
    include('db.php');
    $sql = "SELECT * FROM tblEvent LEFT JOIN tblEventOccurrence ON tblEvent.id = tblEventOccurrence.eventId";
    $stmt = $con->prepare($sql);
    $stmt->execute();
    $arrData = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body>
    <table>
        <tr>
            <td colspan="2">
                <strong>Event List Page</strong>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <table>
                    <tr>
                        <td width="20">
                            <strong>No</strong>
                        </td>
                        <td width="150">
                            <strong>Title</strong>
                        </td>
                        <td width="250">
                            <strong>Dates</strong>
                        </td>
                        <td width="250">
                            <strong>Occurrence</strong>
                        </td>
                        <td width="200">
                            <strong>Actions</strong>
                        </td>
                    </tr>
                    <?php foreach($arrData as $i=>$record) { ?>
                    <tr>
                        <td>
                            <?php echo $i + 1 ?>
                        </td>
                        <td>
                            <?php echo $record['title'] ?>
                        </td>
                        <td>
                        <?php echo $record['startdate'] . " to " . $record['enddate'] ?>
                        </td>
                        <td>
                            <?php 
                                $arrOccuranceValue = explode(",", $record['occurrenceValue']);
                                if ($record['isEvery']) {
                                    $repeatType = "";
                                    $repeatMode = "";
                                    switch($arrOccuranceValue[0]) {
                                        case '1' : $repeatType = "Every"; break;
                                        case '2' : $repeatType = "Every Other"; break;
                                        case '3' : $repeatType = "Every Third"; break;
                                        case '4' : $repeatType = "Every Fourth"; break;
                                    }
                                    switch($arrOccuranceValue[1]) {
                                        case 'D' : $repeatMode = "Day"; break;
                                        case 'W' : $repeatMode = "Week"; break;
                                        case 'M' : $repeatMode = "Month"; break;
                                        case 'Y' : $repeatMode = "Year"; break;
                                    }
                                    echo $repeatType . " " . $repeatMode;
                                } else {
                                    $repeatType = "";
                                    $repeatWeek = "";
                                    $repeatMonth = "";
                                    switch($arrOccuranceValue[0]) {
                                        case 'FI' : $repeatType = "First"; break;
                                        case 'S' : $repeatType = "Second"; break;
                                        case 'T' : $repeatType = "Third"; break;
                                        case 'FO' : $repeatType = "Fourth"; break;
                                    }
                                    switch($arrOccuranceValue[1]) {
                                        case 'SUN' : $repeatWeek = "Sunday"; break;
                                        case 'MON' : $repeatWeek = "Monday"; break;
                                        case 'TUE' : $repeatWeek = "Tuesday"; break;
                                        case 'WED' : $repeatWeek = "Wednesday"; break;
                                        case 'THU' : $repeatWeek = "Thursday"; break;
                                        case 'FRI' : $repeatWeek = "Friday"; break;
                                        case 'SAT' : $repeatWeek = "Saturday"; break;
                                    }
                                    switch($arrOccuranceValue[2]) {
                                        case '1' : $repeatMonth = "Month"; break;
                                        case '3' : $repeatMonth = "3 Month"; break;
                                        case '4' : $repeatMonth = "4 Month"; break;
                                        case '6' : $repeatMonth = "6 Month"; break;
                                        case '12' : $repeatMonth = "Year"; break;
                                    }
                                    echo "Every " . $repeatType . " " . $repeatWeek . " of the " . $repeatMonth;
                                }
                            ?>
                        </td>
                        <td>
                            <a href="view.php?id=<?php echo $record['id'] ?>">View</a>
                            <a href="edit.php?id=<?php echo $record['id'] ?>">Edit</a>
                            <a href="delete.php?id=<?php echo $record['id'] ?>">Delete</a>
                        </td>
                    </tr>
                    <?php } ?>
                </table>
            </td>
        </tr>
</table>
</body>
</html>