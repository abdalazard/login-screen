<?php
include '../../db/Connection.php';

$email = $_POST['emailRegister'];
$password = MD5($_POST['passwordRegister']);

$database = new Connection;

$findUsers = "SELECT * FROM usuarios WHERE email LIKE '" . $email . "'";
$userExists = $database->toDatabase($findUsers);
if ($userExists) {
    $linhas = mysqli_num_rows($userExists);
    if ($linhas >= 1) {
        $msg =
            "<div class='bloco' style='background-color: red;'><h5 class='msg'>Usuário já existente na base de dados.</h5></div>";
        header('location: ../../index.php?msg=' . $msg);
    } else {
        $msg =
            "<div class='bloco' style='background-color: green;'><h5 class='msg'> Usuário cadastrado com sucesso!</h5></div>";
        $insertUser = "INSERT INTO usuarios VALUES(null, '" . $email . "', '" . $password . "')";
        $data = $database->toDatabase($insertUser);

        header('location: ../../index.php?msg=' . $msg);
    }
} else {
    $msg = "<div class='bloco'><h5 class='msg' style='background-color: red;'>Erro! Um problema foi detectado em sua tentativa de cadastro.</h5></div>";

    header('location: ../../index.php?msg=' . $msg);
}