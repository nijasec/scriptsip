<?php
 class Logger {

    private
        $file,
        $timestamp,
        $link;

    public function __construct($filename) {
        $this->file = $filename;
$this->link = mysqli_connect("localhost", "1401014", "322855", "1401014");
    }

    public function setTimestamp($format) {
        $this->timestamp = date($format)." &raquo; ";
    }

    public function putLog($insert) {
        if (isset($this->timestamp)) {
           // file_put_contents($this->file, $this->timestamp.$insert."<br>", FILE_APPEND);

 
// Check connection
if($this->link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

 $dname=$_POST['dname'];
$dlocalip=$_POST['dlocalip'];
$dpublicip=$_SERVER['REMOTE_ADDR']; 
// Attempt insert query execution

$sql = "INSERT INTO devicedata VALUES   
            (NULL,'$dname', '$dlocalip', '$dpublicip',NULL)";
if(mysqli_query($this->link, $sql)){
    echo "Records added successfully.";
} else{
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($this->link);
}
 





        } else {
            trigger_error("Timestamp not set", E_USER_ERROR);
        }
    }

    public function getLog() {
        $content = "empytry";//@file_get_contents($this->file);
       $sql = "SELECT * FROM devicedata ORDER BY d_id DESC";
if($result = mysqli_query($this->link, $sql)){
    if(mysqli_num_rows($result) > 0){
        echo "<table border='1'>";
            echo "<tr>";
                echo "<th>id</th>";
                echo "<th>Device Name</th>";
                echo "<th>Local Ip</th>";
                echo "<th>Public Ip</th>";  echo "<th>Time stamp</th>";
             
            echo "</tr>";
        while($row = mysqli_fetch_array($result)){
            echo "<tr>";
                echo "<td>" . $row['d_id'] . "</td>";
                echo "<td>" . $row['d_name'] . "</td>";
                echo "<td>" . $row['d_localip'] . "</td>";
                echo "<td>" . $row['d_publicip'] . "</td>";
                echo "<td>" . $row['d_date'] . "</td>";

            echo "</tr>";
        }
        echo "</table>";
        // Free result set
        mysqli_free_result($result);
    } else{
        echo "No records matching your query were found.";
    }
} else{
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($this->link);
}
 


        return $content;
    }
public function __destruct()
{
// Close connection
mysqli_close($this->link);
}

}

$log = new Logger("log.txt");
$log->setTimestamp("D M d 'y h.i A");
if ($_SERVER['REQUEST_METHOD'] === 'POST')
    $log->putLog("Successful Login: 1");
else
$log->getLog();
								
