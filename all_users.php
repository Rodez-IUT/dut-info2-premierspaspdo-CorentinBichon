<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="utf-8" />
		<title>all users </title>
	</head>
	<body>
	
	<?php
		$host = 'localhost';
		$db   = 'my_activities';
		$user = 'root';
		$pass = 'root';
		$charset = 'utf8mb4';
		$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
		$options = [
			PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
			PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
			PDO::ATTR_EMULATE_PREPARES   => false,
		];
		try {
			 $pdo = new PDO($dsn, $user, $pass, $options);
		} catch (PDOException $e) {
			 throw new PDOException($e->getMessage(), (int)$e->getCode());
		}
	?>

	
		
	<h1> All users </h1> </br> 
	
	<form action="all_users.php" method="get">
		
		<label for="lettre"> start with letter :  </label>
        <input type="text" name="lettre" id="lettre" value="<?php if ( isset($_GET['lettre'] )) {
																		echo $_GET['lettre'] ;
																	} else {
																		echo  " " ; 
																	} ?>"/>
		
		<label for="and_status_is"> and status is  </label>
		<select name="and_status_is">
			<option value="2">Active account</option>
			<option value="1">Waiting for account validation</option>
			<option value="3">Waiting for account deletion</option>
			
		</select>
	
		<input type="submit" value="ok"> </br>
	</form>

		
	<table> 
	    <tr> 
			<th> Id </th>
			<th> Username </th>
			<th> Email </th>
			<th> Status </th>
		</tr> </br> 
	<?php
		$maLettre = $_GET['lettre'] ;
		$maLettreIn = $_GET['lettre']."%" ;
		$monStatus = $_GET['and_status_is'] ;
		
		$stmt = $pdo->prepare("SELECT users.id as users_id, email, username, name 
							 FROM users 
							 JOIN status ON users.status_id = status.id 
							 WHERE username LIKE ?	AND users.status_id = ?						 
							 ORDER BY username");
							 
		$stmt->execute([$maLettreIn, $monStatus ]);
	
		
		while ($row = $stmt->fetch())
		{
			echo "<tr>
			        <td> $row[users_id] </td> 
					<td> $row[username] </td>
					<td> $row[email] </td>
					<td> $row[name] </td>";
					
				if ( $monStatus != "3" ) {
					echo "<td> <a href=\"all_users.php?lettre=$maLettre&and_status_is=$monStatus\"> Ask deletion </a> </td>";
				}	
			echo "</tr>" ;
		}
	?>
	</table>
	</body>
</html> 