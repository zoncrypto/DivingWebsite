<?php
require_once "../app/dbconfig.php";

$sql = "SELECT date, name, id FROM diveevents";
        
if ($result = mysqli_query($link, $sql)) {
    // Fetch each row with the dive spot details
        $i = 1; 
        while ($row = mysqli_fetch_row($result)) {
        $year = substr($row[0], 0, 4);
        $month = substr($row[0], 5, 2) - 1;
        $day = substr($row[0], 8, 2);  
        $event_calendar[$i] = [$year, $month, $day, $row[1], $row[2]]; // result array with embedded the array of date and name of event to display on calendar
        $i++;
        }
        mysqli_free_result($result);
}


// Close connection
mysqli_close($link);

?>