<?php
require_once('connect.php');

$conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

if(isset($_POST['name']) && isset($_POST['email']) && isset($_POST['password']))
{
    $query="INSERT INTO users (name,email,password) VALUES(:n,:e,:p)";
    $stm=$conn->prepare($query);
    $stm->execute (array(
        ':n'=>$_POST['name'],
        ':e'=>$_POST['email'],
        ':p'=>$_POST['password']));

}

if(isset($_POST['del']) && isset($_POST['user_id']))
{
    $q="DELETE FROM `users` WHERE user_id=:i";
    $stm=$conn->prepare($q);
    $stm->execute (array(
        ':i'=>$_POST['user_id']));
}

?>



<html>
    <body>
<table border="1">
    <tr><td><strong>name</strong></td>
    <td><strong>email</strong></td>
    <td><strong>password</strong></td></tr>
    <?php


    try{
    $stm=$conn->query("SELECT * FROM users");}
    catch (Exception $e){
        echo("err msg:".$e->getMessage());
        return;
    }
    while ( $row = $stm->fetch(PDO::FETCH_ASSOC))
    {
        echo("<tr><td>");
        echo($row['name']);
        echo("</td><td>");
        echo($row['email']);
        echo("</td><td>");
        echo($row['password']);
        echo("</td><td>");
        echo('<form method="post"><input type="hidden"');
        echo('name="user_id" value="'.$row['user_id'].'">'."\n");
        echo("<input type='submit' value='delete' name='del'>");
        echo("</form>");
        echo("</td></tr>");
    }

    ?>
</table>
<br><br>
<form method="POST">
    <table>
    <tr><td><label><strong>Name</strong></td><td><input type='text' name='name'></label></td></tr>
    <tr><td><label><strong>Email</strong></td><td><input type='text' name='email'></label></td></tr>
    <tr><td><label><strong>Password</strong></td><td><input type='password' name='password'></label></td></tr>
    <tr><td><input type="submit" name="sub" value='Add User'></td></tr>
</table>
</form>

</body>
</html>