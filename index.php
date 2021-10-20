<?php 
    include('db.php');
    if(isset($_POST['submit'])) {
       $title = $_POST['title'];
       $startDate = $_POST['startDate'];
       $endDate = $_POST['endDate'];
       $sql = "INSERT INTO tblEvent (title, startdate, enddate) VALUES ('$title', '$startDate', '$endDate')";
       $stmt = $con->prepare($sql);
       $stmt->execute();
       $eventId = $con->lastInsertId();

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
        
       $sql = "INSERT INTO tblEventOccurrence (eventId, isEvery, occurrenceValue) VALUES ($eventId, $isEvery, '$occurrenceValue')";
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
                <strong>Add Event Page</strong>
            </td>
        </tr>
        <tr>
            <td>
                Event Title:
            </td>
            <td>
                <input type="text" name="title" required/>
            </td>
        </tr>
        <tr>
            <td>
                Start Date:
            </td>
            <td>
            <input type="date" name="startDate" required>
            </td>
        </tr>
        <tr>
            <td>
                End Date:
            </td>
            <td>               
                <input type="date" name="endDate" required>
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
                <input id="Radiobutton2" name="repeatGroup" type="radio" value="radio1" autocomplete="off" checked/>
                <label
                    for="radio1" checked><span style="font-size: 10pt; font-family: Verdana">Repeat</span></label>
                &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                <select id="lstRepeatType" class="textbox-medium" name="lstRepeatType"
                    style="font-size: x-small; width: 100px; font-family: Verdana" tabindex="10">
                    <option selected="selected" value="1">Every</option>
                    <option value="2">Every Other</option>
                    <option value="3">Every Third</option>
                    <option value="4">Every Fourth</option>
                </select>
                <select id="lstEvery" class="textbox-medium" name="lstEvery" style="font-size: x-small;
                        width: 66px; font-family: Verdana" tabindex="10">
                    <option selected="selected" value="D">Day</option>
                    <option value="W">Week</option>
                    <option value="M">Month</option>
                    <option value="Y">Year</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>

            </td>
            <td>
                <input id="RadioButton3"  type="radio" value="radio2" name="repeatGroup"  autocomplete="off"/>
                <span
                    style="font-size: 10pt; font-family: Verdana">Repeat on the
                    <select id="lstRepeatOn" class="textbox-middle" name="lstRepeatOn" style="font-size: x-small;
        width: 68px; font-family: Verdana" tabindex="12">
                        <option selected="selected" value="FI">First</option>
                        <option value="S">Second</option>
                        <option value="T">Third</option>
                        <option value="FO">Fourth</option>
                    </select>
                </span>&nbsp;
                <select id="lstRepeatWeek" class="textbox-middle" name="lstRepeatWeek"
                    style="font-size: x-small; width: 56px; font-family: Verdana" tabindex="13">
                    <option selected="selected" value="SUN">Sun</option>
                    <option value="MON">Mon</option>
                    <option value="TUE">Tue</option>
                    <option value="WED">Wed</option>
                    <option value="THU">Thu</option>
                    <option value="FRI">Fri</option>
                    <option value="SAT">Sat</option>
                </select>
                of the
                <select id="lstRepeatMonth" class="textbox-middle" language="javascript" name="lstRepeatMonth" style="font-size: x-small; width: 80px;
                        font-family: Verdana" tabindex="14">
                    <option selected="selected" value="1">Month</option>
                    <option value="3">3 Months</option>
                    <option value="4">4 Months</option>
                    <option value="6">6 Months</option>
                    <option value="12">Year</option>
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