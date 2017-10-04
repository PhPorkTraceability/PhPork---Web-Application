<?php
include "../inc/functions.php"; 
    $db = new phpork_functions ();

$db->connect();

 mysql_select_db("freeze",$query);
if(isset($_POST['name']))
{
$name=trim($_POST['name']);
$query2=mysql_query("SELECT * FROM user WHERE user_name LIKE '%".$userName."%'");
echo "<ul>";
while($query3=mysql_fetch_array($query2))
{
?>

<li onclick='fill("<?php echo $query3['userName']; ?>")'><?php echo $query3['userName']; ?></li>
<?php
}
}
?>
</ul>