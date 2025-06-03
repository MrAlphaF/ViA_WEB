<?php 

include_once "db.php";

$current_page = basename($_SERVER['PHP_SELF']);

// Check if current page is even in the stats table
$sth = $dbh->prepare('SELECT page_name, view_count FROM stats WHERE page_name = :pagename;');
$sth->execute(array(':pagename' => $current_page));

$result = $sth->fetchAll();
$rowcount = count($result); // Count if any matching rows are found for the page

if (!$rowcount > 0) {
    $sql = $dbh->prepare("INSERT INTO stats (page_name, view_count) VALUES (:pagename, 1);");
    $sql->execute( array(':pagename' => $current_page) );
}
else {
    // Update existing view count by grabbing the view_count column value from $result and adding 1 to it. 
    // Uses MySQL's CURTIME() function for last access time
    $sql = $dbh->prepare("UPDATE stats SET view_count = :new_viewcount, last_viewed = CURTIME() WHERE page_name = :pagename");
    $sql->execute( array(':new_viewcount' => $result[0][1] + 1, ':pagename' => $current_page));
}

?>