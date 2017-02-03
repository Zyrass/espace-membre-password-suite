<?php
try {
    $bdd = new PDO ('mysql:host=localhost; dbname=tuto', 'root', '');
} catch (Exception $e) {
    die("Error : " . $e->getMessage());
}
