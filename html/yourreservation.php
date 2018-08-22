<?php
session_start();

include("header.php");


require_once 'login.php';
$conn = new mysqli($hn, $un, $pw, $db);


include("makereservation.php");

echo "<p>Below is your existing reservation record</p>";

$uid=$_SESSION['uid'];

$query = "SELECT * FROM reservation where cusid = '$uid'";

$result = mysqli_query($conn,$query);

$rows = $result->num_rows;

for ($j = 0 ; $j < $rows ; ++$j)
{
    $result->data_seek($j);
    $row = $result->fetch_array(MYSQLI_NUM);

    echo <<<_END
  <pre><div class="record">
    Reservation ID $row[0]
    Check-in  Date $row[1]
    Check-out Date $row[2]
    Room Type      $row[3]
    Quantity       $row[4]
    Total          $row[5]
  </pre>
  <form action="yourreservation.php" method="post">
  <input type="hidden" name="delete" value="yes">
  <input type="hidden" name="rsvid" value="$row[0]">
  <input type="submit" value="Cancel Reservation # $row[0]"></form></div>
_END;
}


if (isset($_POST['delete']) && isset($_POST['rsvid']))
{
    $rid = get_post($conn, 'rsvid');
    $query  = "DELETE FROM reservation WHERE reservationid='$rid'";

    $result = $conn->query($query);
    $message = "You have just cancelled reservation ".$rid."!";
   if($result){
       echo "<script type='text/javascript'>alert('$message');</script>";
       echo "<p>$message</p>";}

   else {echo "DELETE failed: $query<br>" .
       $conn->error . "<br><br>";}
}


//echo" You just booked room type". $_SESSION['type'];


function get_post($conn, $var)
{
    return $conn->real_escape_string($_POST[$var]);
}
?>


