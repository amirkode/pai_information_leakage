<?php
$server = 'localhost';
$username = 'santuy';
$password = '12345a';
$database = 'pai';

try{
	$conn = new PDO("mysql:host=$server;dbname=$database;", $username, $password);
} catch(PDOException $e){
	die( "Connection failed: " . $e->getMessage());
}