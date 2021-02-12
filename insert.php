<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$user = 'igor';
$pass = '1234';

$conn = new PDO('pgsql:host=postgres;dbname=igor', $user, $pass);
$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
$conn->setAttribute(PDO::ATTR_ORACLE_NULLS,PDO::NULL_EMPTY_STRING);

if (isset($_POST['name'])) {
    $sql = 'INSERT INTO users (id, name, email) VALUES (?, ?, ?);';
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(1, random_int(3, 10));
    $stmt->bindValue(2, $_POST['name']);
    $stmt->bindValue(3, $_POST['email']);
    
    try {
        if ($stmt->execute()) {
            echo '<p style="color: green">' . $_POST['name'] . ' foi inserido com sucesso! </p>';
        } else {
            echo '<p style="color: red"> Ocorreu um erro ao inserir o dado.</p>';
        }
    } catch (\Exception $e) {
        echo '<p style="color: red">' . $e->getMessage() . '</p>';
    }

    
}



$sql = "SELECT * FROM users";

$stmt = $conn->prepare($sql);
$stmt->execute();

$resultado = $stmt->fetchAll(PDO::FETCH_OBJ);


echo "<pre>";
foreach ($resultado as $user) {
    echo "Nome: " . $user->name . " <br>";
}




?>



<form action="" method="POST">    
    <input type="text" name="name" placeholder="Seu nome">
    <br>
    <input type="text" name="email" placeholder="Seu email">
    <br>
    <input type="submit" value="Enviar">
</form>