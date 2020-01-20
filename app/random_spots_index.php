<?php
// Include config file
require_once "../app/dbconfig.php";
require_once "../app/twig.php";
 
 
// Prepare a select statement
$sql = "SELECT id, name, depth, type FROM divespots  ORDER BY RAND() LIMIT 3;";
        
if ($result = mysqli_query($link, $sql)) {
    // Fetch each row with the dive spot details
        $i = 1; 
        while ($row = mysqli_fetch_row($result)) {
          
        $spots[$i] = [$row[0], $row[1], $row[2], $row[3]]; // result array with embedded the array of a dive spot details.
                                                                // ex. $result[1][0] : the id of the first dive spot of the query.
        $sql2 = "SELECT image FROM images WHERE divespotID = $row[0] ORDER BY RAND() LIMIT 1;";
        if ($result2 = mysqli_query($link, $sql2)){
            $row2 = mysqli_fetch_row($result2);
            array_push($spots[$i] ,$row2[0]);
            mysqli_free_result($result2);
        }
        $i++;
        }
        mysqli_free_result($result);
}
        
        
//Store each spot information in variables
//spot 1
$id1 = $spots[1][0];
$name1 = $spots[1][1];
$depth1 = $spots[1][2];
$type1 = $spots[1][3];
$img1 = $spots[1][4];


//spot 2
$id2 = $spots[2][0];
$name2 = $spots[2][1];
$depth2 = $spots[2][2];
$type2 = $spots[2][3];
$img2 = $spots[2][4];

//spot 3
$id3 = $spots[3][0];
$name3 = $spots[3][1];
$depth3 = $spots[3][2];
$type3 = $spots[3][3];
$img3 = $spots[3][4];

// Close connection
 //mysqli_close($link);    /*commented out, to keep the link active for files that call this php*/

?>