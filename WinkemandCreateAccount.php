<?php
include __DIR__ . "/header.php";
?>
<!DOCTYPE html>
<html>
<head>
<style>
table {
  border: 3px solid black;
}

table {
  width: 100%;
}

th, td {
  padding: 15px;
  text-align: left;
}

td {
  height: 50px;
  vertical-align: middle;
}

input[type=text] {
	border: none;
	border-bottom: 2px solid black;
}

input[type=password] {
	border: none;
	border-bottom: 2px solid black;
}

input[type=naam] {
	border: none;
	border-bottom: 2px solid black;
}

.vl {
  border-left: 3px solid black;
  height: 59%;
  position: absolute;
  left: 29%;
  margin-left: -3px;
  top: 41%;
}

.vl2 {
  border-left: 3px solid black;
  height: 59%;
  position: absolute;
  left: 60%;
  margin-left: -3px;
  top: 41%;
}

button {
  background-color: #white;
  color: black;
  padding: 14px 20px;
  margin: 8px 0;
  border: none;
  cursor: pointer;
  width: 170px;
}

button:hover {
  opacity: 0.6;
}

</style>
</head>
<body>

<h2 style='color:black'>Winkelmand</h2>
<h3><button onclick="window.location.href='index.php'">Verder winkelen</button></h3>
<form action="afrekenen.php" method="post">	
<table>
  <tr style='color:black;'>
    <th>Bestaande klant</th>
    <th>Nieuwe klant</th>
	<th>Bestellen als gast</th>
  </tr>
  <tr>
    <td> <label for="uname"> </label>
    <input type="text" placeholder="Email-adres" name="uname1"> </td>
    <td> <label for="uname"> </label>
    <input type="text" placeholder="Email-adres" name="uname2"> </td>
	<td> <label for="uname"> </label>
    <input type="text" placeholder="Email-adres" name="uname3"> </td>
  </tr>
  <tr>
    <td> <label for="psw"> </label>
    <input type="password" placeholder="Wachtwoord" name="psw1"> </td>
    <td> <label for="psw"> </label>
    <input type="text" placeholder="Volledige naam" name="uname1"> </td>
	<td> <label for="psw"> </label>
    <input type="text" placeholder="Volledige naam" name="uname2"> </td>
  </tr>
  <tr>
        
	<td style='color:black'> <button type="submit" name='Inloggen' style='color:black;'>Inloggen</button> </td>
	<td style='color:black'> <button type="submit" name='Aanmelden' style='color:black;'>Aanmelden</button> </td>
	<td style='color:black'> <button type="submit" style='color:black;'>Verder gaan</button></td>
	
</table>
</form>
<div class="vl"></div>
<div class="vl2"></div>
</body>
</html>

