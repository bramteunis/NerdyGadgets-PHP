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
  height: 310px;
  position: absolute;
  left: 350px;
  margin-left: -3px;
  top: 128px;
}

.vl2 {
  border-left: 3px solid black;
  height: 310px;
  position: absolute;
  left: 875px;
  margin-left: -3px;
  top: 128px;
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

<h2>Winkelmand</h2>
<h3><button type="submit" style="float: right">Verder winkelen</button></h3>
<table>
  <tr>
    <th>Bestaande klant</th>
    <th>Nieuwe klant</th>
	<th>Bestellen als gast</th>
  </tr>
  <tr>
    <td> <label for="uname"> </label>
    <input type="text" placeholder="Email-adres" name="uname" required> </td>
    <td> <label for="uname"> </label>
    <input type="text" placeholder="Email-adres" name="uname" required> </td>
	<td> <label for="uname"> </label>
    <input type="text" placeholder="Email-adres" name="uname" required> </td>
  </tr>
  <tr>
    <td> <label for="psw"> </label>
    <input type="password" placeholder="Wachtwoord" name="psw" required> </td>
    <td> <label for="psw"> </label>
    <input type="naam" placeholder="Volledige naam" name="uname" required> </td>
	<td> <label for="psw"> </label>
    <input type="naam" placeholder="Volledige naam" name="uname" required> </td>
  </tr>
  <tr>
	<td> <button type="submit">Inloggen</button> </td>
	<td> <button type="submit">Aanmelden</button> </td>
	<td> <button type="submit">Verder gaan</button> </td>
</table>
<div class="vl"></div>
<div class="vl2"></div>
</body>
</html>
