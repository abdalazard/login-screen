<?php
session_start();

include '../../db/Connection.php';

$email = $_POST['email'];
$password = MD5($_POST['password']);

$database = new Connection;

$findUsers = "SELECT * FROM usuarios WHERE email LIKE '" . $email . "' AND pass LIKE '" . $password . "'";
$userExists = $database->toDatabase($findUsers);
if (!$userExists) {
    $msg = "<h5>Erro na tentativa de login!</h5>";

    header('location: ../../index.php?msg=' . $msg);
} else {
    $linhas = mysqli_num_rows($userExists);
    if ($linhas >= 1) {
        $data = mysqli_fetch_array($userExists);
        if (!strcmp($password, $data['pass'])) {
            $_SESSION['id'] = $data['id'];
            $_SESSION['email'] = $data['email'];

            header('location: ../../pages/dashboard/dashboard.php?');
        }
    } else {
        $msg = "<h5>Dados incorretos!</h5>";
        header('location: ../../index.php?msg=' . $msg);
    }
}