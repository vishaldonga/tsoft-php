<?php 
    include('db.php');
    if(isset($_GET['id'])) {
        $id = $_GET['id'];
        $sql = "SELECT * FROM tblEvent LEFT JOIN tblEventOccurrence ON tblEvent.id = tblEventOccurrence.eventId WHERE tblEvent.id='$id'";
        $stmt = $con->prepare($sql);
        $stmt->execute();
        $arrData = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $title = $arrData[0]['title'];
        $startDate = $arrData[0]['startdate'];
        $endDate = $arrData[0]['enddate'];
        $isEvery = $arrData[0]['isEvery'];
        $occurrenceValue = $arrData[0]['occurrenceValue'];
        $arrOccurrenceValue = explode(",", $occurrenceValue);
    }
    if(isset($_POST['submit'])) {
        $id = $_POST['id'];
       $title = $_POST['title'];
       $startDate = $_POST['startDate'];
       $endDate = $_POST['endDate'];
       $sql = "UPDATE tblEvent SET title = '$title', startdate='$startDate', enddate='$endDate' WHERE id='$id'";

       $repeatGroup = $_POST['repeatGroup'];
        if ($repeatGroup == "radio1") {
            $repeatType = $_POST['lstRepeatType'];
            $every = $_POST['lstEvery'];
            $isEvery = 1;
            $occurrenceValue = $repeatType . "," . $every;
        } else {
            $repeatOn = $_POST['lstRepeatOn'];
            $repeatWeek = $_POST['lstRepeatWeek'];
            $repeatMonth = $_POST['lstRepeatMonth'];
            $isEvery = 0;
            $occurrenceValue = $repeatOn . "," . $repeatWeek . "," . $repeatMonth;
        }
        
       $sql .= ";UPDATE tblEventOccurrence SET isEvery =$isEvery, occurrenceValue='$occurrenceValue' WHERE eventId='$id'";;
       $stmt = $con->prepare($sql);
       $stmt->execute();
        header('location: events.php');
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
    <script>
        function submitForm() {
            const startDate = document.getElementsByName("startDate")[0].value;
            const endDate = document.getElementsByName("endDate")[0].value;
            if (Date.parse(startDate) > Date.parse(endDate)) {
                alert('Start Date can not be greater than End DAte');
                return false;
            }            
        }
    </script>
</head>
<body>
        <table>
            <form method="post" onsubmit="return submitForm()">
		<tr>
            <td colspan="2">
                <strong>Edit Event Page</strong>
            </td>
        </tr>
        <tr>
            <td>
                Event Title:
            </td>
            <td>
                <input type="hidden" name="id" value="<?php echo $id ?>" />
                <input type="text" name="title" value="<?php echo $title ?>" required/>
            </td>
        </tr>
        <tr>
            <td>
                Start Date:
            </td>
            <td>
            <input type="date" name="startDate" value="<?php echo $startDate ?>" required>
            </td>
        </tr>
        <tr>
            <td>
                End Date:
            </td>
            <td>               
                <input type="date" name="endDate" value="<?php echo $endDate ?>" required>
            </td>
        </tr>
        <tr>
            <td>

            </td>
            <td>

            </td>
        </tr>
        <tr>
            <td>Recurrence:
            </td>
            <td>
                <input id="Radiobutton2" name="repeatGroup" type="radio" value="radio1" autocomplete="off" <?php echo $isEvery ? 'checked' : '' ?>/>
                <label
                    for="radio1" checked="checked"><span style="font-size: 10pt; font-family: Verdana">Repeat</span></label>
                &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                <select id="lstRepeatType" class="textbox-medium" name="lstRepeatType"
                    style="font-size: x-small; width: 100px; font-family: Verdana" tabindex="10">
                    <option <?php if ($arrOccurrenceValue[0] == "1") echo "selected" ?> value="1">Every</option>
                    <option <?php if ($arrOccurrenceValue[0] == "2") echo "selected" ?> value="2">Every Other</option>
                    <option <?php if ($arrOccurrenceValue[0] == "3") echo "selected" ?> value="3">Every Third</option>
                    <option <?php if ($arrOccurrenceValue[0] == "4") echo "selected" ?> value="4">Every Fourth</option>
                </select>
                <select id="lstEvery" class="textbox-medium" name="lstEvery" style="font-size: x-small;
                        width: 66px; font-family: Verdana" tabindex="10" >
                    <option <?php if ($arrOccurrenceValue[1] == "D") echo "selected" ?> value="D">Day</option>
                    <option <?php if ($arrOccurrenceValue[1] == "W") echo "selected" ?> value="W">Week</option>
                    <option <?php if ($arrOccurrenceValue[1] == "M") echo "selected" ?> value="M">Month</option>
                    <option <?php if ($arrOccurrenceValue[1] == "Y") echo "selected" ?> value="Y">Year</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>

            </td>
            <td>
                <input id="RadioButton3"  type="radio" value="radio2" name="repeatGroup" autocomplete="off" <?php echo !$isEvery ? 'checked' : '' ?>/>
                <label
                    for="radio2" checked="checked"></label>
                <span
                    style="font-size: 10pt; font-family: Verdana">Repeat on the
                    <select id="lstRepeatOn" class="textbox-middle" name="lstRepeatOn" style="font-size: x-small;
        width: 68px; font-family: Verdana" tabindex="12">
                        <option <?php if ($arrOccurrenceValue[0] == "FI") echo "selected" ?> value="FI">First</option>
                        <option <?php if ($arrOccurrenceValue[0] == "S") echo "selected" ?> value="S">Second</option>
                        <option <?php if ($arrOccurrenceValue[0] == "T") echo "selected" ?> value="T">Third</option>
                        <option <?php if ($arrOccurrenceValue[0] == "FO") echo "selected" ?> value="FO">Fourth</option>
                    </select>
                </span>&nbsp;
                <select id="lstRepeatWeek" class="textbox-middle" name="lstRepeatWeek"
                    style="font-size: x-small; width: 56px; font-family: Verdana" tabindex="13">
                    <option <?php if ($arrOccurrenceValue[1] == "SUN") echo "selected" ?> value="SUN">Sun</option>
                    <option <?php if ($arrOccurrenceValue[1] == "MON") echo "selected" ?> value="MON">Mon</option>
                    <option <?php if ($arrOccurrenceValue[1] == "TUE") echo "selected" ?> value="TUE">Tue</option>
                    <option <?php if ($arrOccurrenceValue[1] == "WED") echo "selected" ?> value="WED">Wed</option>
                    <option <?php if ($arrOccurrenceValue[1] == "THU") echo "selected" ?> value="THU">Thu</option>
                    <option <?php if ($arrOccurrenceValue[1] == "FRI") echo "selected" ?> value="FRI">Fri</option>
                    <option <?php if ($arrOccurrenceValue[1] == "SAT") echo "selected" ?> value="SAT">Sat</option>
                </select>
                of the
                <select id="lstRepeatMonth" class="textbox-middle" language="javascript" name="lstRepeatMonth" style="font-size: x-small; width: 80px;
                        font-family: Verdana" tabindex="14" value="<?php ?>">
                    <option <?php if ($arrOccurrenceValue[2] == "1") echo "selected" ?> value="1">Month</option>
                    <option <?php if ($arrOccurrenceValue[2] == "3") echo "selected" ?> value="3">3 Months</option>
                    <option <?php if ($arrOccurrenceValue[2] == "4") echo "selected" ?> value="4">4 Months</option>
                    <option <?php if ($arrOccurrenceValue[2] == "6") echo "selected" ?> value="6">6 Months</option>
                    <option <?php if ($arrOccurrenceValue[2] == "12") echo "selected" ?> value="12">Year</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>

            </td>
            <td>

            </td>
        </tr>
        <tr>
            <td>

            </td>
            <td><input type="submit" value="submit" name="submit" />
            </td>
        </tr>
        <tr>
            <td>

            </td>
            <td>

            </td>
        </tr>
        </form>
        </table>
    </body>
</html>