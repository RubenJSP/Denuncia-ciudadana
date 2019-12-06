<?php
	function connectDB() 
		{
			$dsn = 'mysql:host=localhost;dbname=denuncias';
			$username = 'root';
			$password = '';
			return new PDO($dsn, $username);
		}
?>