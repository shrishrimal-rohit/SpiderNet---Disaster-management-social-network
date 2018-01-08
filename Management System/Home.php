<?php
session_start();
include_once 'Dbconnect.php';

if (!isset($_SESSION['userSession'])) {
 header("Location: index.php");
}

$query = $DBcon->query("SELECT * FROM user WHERE user_id=".$_SESSION['userSession']);
$userRow=$query->fetch_array();
$DBcon->close();

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>SMARTNET PROJECT</title>
</head>
    
<style>
.button {
    background-color: #4CAF50;
    border: none;
    color: white;
    padding: 15px 32px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 4px 2px;
    cursor: pointer;
}
button {
    background-color: #4CAF50;
    border: none;
    color: white;
    padding: 15px 32px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 4px 2px;
    cursor: pointer;
}
input[type=submit]{
    display: block;
    margin-top: 0em;
    background-color: #4CAF50;
    border: none;
    color: white;
    padding: 15px 32px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 4px 2px;
    cursor: pointer;
}
</style>
<a href="logout.php?logout"><span class="glyphicon glyphicon-log-out"></span>&nbsp; Logout</a>
<body>
<h2>SpiderNet: Manage System</h2>
<p>
 <table>
  <tr>
    <th>List of Project</th>
    <th>Members</th>
  </tr>
  <tr>
    <td>1</td>
    <td>Hunter</td>
  </tr>
  <tr>
    <td>2</td>
    <td>Harsha</td>
  </tr>
    <tr>
    <td>3</td>
    <td>Rohit</td>
  </tr>
    <tr>
    <td>4</td>
    <td>Jason</td>
  </tr>
</table>
</p>
<br>
<h2>List of features provided by Manage System (Create/Terminate/List) as below :</h2>
<br>
<h2>Enter the number of OSSN instance to create and click Create Instances</h2>
<form method="post" action="/create">
    <input type="text" name="ins">
    <input type="submit" value="Create Instances" >
    </form><br>
<h2>To terminate all the instances, click below:</h2>
<a href="#" class="button" >Terminate All Instances</a><br>

<h2>To list all the instances, click below:</h2>
<form method="post" action="/list">
    <input type="submit" value="List all OSSN instances/Communities" ><br>
     <br>
</form>

<h2>To view the dashboard, click below:</h2>
<form method="post" action="/dashboard">
    <input type="submit" value="View Dashboard" ><br>
     <br>
</form>

</body>
</html>

