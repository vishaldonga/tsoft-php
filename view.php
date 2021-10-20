<?php
include('db.php');
if(isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM tblEvent LEFT JOIN tblEventOccurrence ON tblEvent.id = tblEventOccurrence.eventId WHERE tblEvent.id='$id'";
    $stmt = $con->prepare($sql);
    $stmt->execute();
    
    $arrData = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $title = $arrData[0]['title'];
    $isEvery = $arrData[0]['isEvery'];
    $startDate = $arrData[0]['startdate'];
    $endDate = $arrData[0]['enddate'];
    $occurrenceValue = $arrData[0]['occurrenceValue'];
    $arrOccurrenceValue = explode(",", $occurrenceValue);
    $date = date_create($startDate);
    $endDate = date_create($endDate);
    $dateArray = [];
    echo $arrOccurrenceValue[0];
    if ($isEvery) {        
        array_push($dateArray, array($date->format('l'), $date->format('Y-m-d')));
        while ($date < $endDate) {
            switch($arrOccurrenceValue[1]) {
                case 'D' : $date = date_add($date,date_interval_create_from_date_string($arrOccurrenceValue[0] ." days"));
                    break;
                case 'W' : $date = date_add($date,date_interval_create_from_date_string($arrOccurrenceValue[0] ." weeks"));
                    break;
                case 'M' : $date = date_add($date,date_interval_create_from_date_string($arrOccurrenceValue[0] ." months"));
                    break;
                case 'Y' : $date = date_add($date,date_interval_create_from_date_string($arrOccurrenceValue[0] ." year"));
                    break;
            }
            array_push($dateArray, array($date->format('l'), $date->format('Y-m-d')));
        }
    } else {
        // while ($date < $endDate) {
        $dayIndex = 0;
        $dayFrequency = "";
        switch($arrOccurrenceValue[0]) {
            case 'FI' : $dayFrequency = "first";
                break;
            case 'S' : $dayFrequency = "second";
                break;
            case 'T' : $dayFrequency = "third";
                break;
            case 'FO' : $dayFrequency = "fourth";
                break;
        }
        switch($arrOccurrenceValue[1]) {
            case 'SUN' : $dayIndex = "Sunday";
                break;
            case 'MON' : $dayIndex = "Monday";
                break;
            case 'TUE' : $dayIndex = "Tuesday";
                break;
            case 'WED' : $dayIndex = "Wednesday";
                break;
            case 'THU' : $dayIndex = "Thursday";
                break;
            case 'FRI' : $dayIndex = "Friday";
                break;
            case 'SAT' : $dayIndex = "Saturday";
                break;
        }
        $date = date("Y-m-d", strtotime("$dayFrequency $dayIndex of ". date('M', strtotime($date->format('Y-m-d')))));
        array_push($dateArray, array($dayIndex, $date));
        $date = date_add(date_create($date),date_interval_create_from_date_string($arrOccurrenceValue[2] ." months"));
    }


}
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
                <strong>Event View Page</strong>
            </td>
        </tr>
        <tr>
            <td>
                <?php echo $title; ?>
            </td>
        </tr>
        <tr>
            <td>

            </td>
            <td>
                <table border="1">
                    <?php foreach($dateArray as $record) { ?>
                    <tr>
                        <td>
                            <?php echo $record[1] ?>
                        </td>
                        <td style="width: 100px">
                            <?php echo $record[0] ?>
                        </td>
                    </tr>
                    <?php } ?>
                </table>
            </td>
        </tr>
        <tr>
            <td>

            </td>
            <td>
                Total Recurrence Event: <?php echo count($dateArray) ?>
            </td>
        </tr>
</table>
</body>
</html>