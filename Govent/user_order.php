<?php
require_once("../connect_server.php");

$sql = "SELECT * FROM user_order";

$result = $conn->query($sql);
$rows = $result->fetch_all(MYSQLI_ASSOC);
?>

<pre>
    <?php print_r($rows); ?>
</pre>