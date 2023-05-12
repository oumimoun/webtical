<?php
session_start();
// connect to database using PDO
require("config/connexion.php");
include("config/functions.php");

if (isset($_SESSION['loggedIn'])) {
    $username = $_SESSION['username'];
}
if (isset($_POST['action'])) {

    $idPub = $_POST['idPub'];
    $action = $_POST['action'];
    switch ($action) {
        case 'like':
            $vote_action = 'like';
            insert_like($username, $idPub);
            break;
        case 'unlike':
            delete_like($username, $idPub);
            break;
        default:
    }
    // execute query to effect changes in the database ...
    echo getRating($idPub);
    exit(0);
}
