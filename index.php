<?php
session_start();
if(isset($_SESSION["user"])){
    header("Location: ./View/home.php");
    exit();
}
require_once "./resources/conn.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="/Style/indexNew.css">
    <link rel="apple-touch-icon" href="./templateIcon.png">
    <link rel="manifest" href="manifest.json">
    <title>My Finances</title>
</head>

<body>

    <div class="container" id="container">
        <div class="form-container sign-up">
            <form method="POST">
            <?php 
            if(isset($_POST["register"])){
                $fullName = $_POST["name"];
                $email = $_POST["email"];
                $password = $_POST["password"];
                $confirmPassword = $_POST["confirm-password"];
                $error = array();

                $passwordHash = password_hash($password, PASSWORD_DEFAULT);

                if(strlen($password)<8){
                    array_push($error, "Senha deve ter no mínimo 8 caracteres");
                }

                if($password !== $confirmPassword){
                    array_push($error, "A senha não corresponde.");
                }

                $sql = "SELECT * FROM usuario WHERE email = '$email'";
                $result = mysqli_query($conn, $sql);
                $rowCount = mysqli_num_rows($result);
                if($rowCount>0){
                    array_push($error, "Email já existe");
                }
                if(count($error) > 0){
                    foreach($error as $errors){
                        echo "<div class='error message'>$errors</div>";
                    }
                }else{
                    $sql = "INSERT INTO usuario (nome, email, senha) VALUES ( ?, ?, ? )";
                    $stmt = mysqli_stmt_init($conn);
                    $prepareStmt = mysqli_stmt_prepare($stmt, $sql);
                    if($prepareStmt){
                        mysqli_stmt_bind_param($stmt, "sss", $fullName, $email, $passwordHash);
                        mysqli_stmt_execute($stmt);
                        echo "<div class='succesfull message'>Você foi registrado.</div>";
                        exit();
                    }else{
                        die("Ocorreu um erro.");
                    }
                }
            }
            ?>
                <h1>Crie sua conta</h1>
                <input type="text" name="name" placeholder="Nome">
                <input type="email" name="email" placeholder="E-mail">
                <input type="password" name="password" placeholder="Senha">
                <input type="password" name="confirm-password" placeholder="Confirme a senha">
                <input class="formBtn" name="register" type="submit" value="Criar"/>
            </form>
        </div>
        <div class="form-container sign-in">
            <form action="" method="POST">
                <?php
                 if(isset($_POST["login"])){
                    $email = $_POST["email"];
                    $password = $_POST["password"];
                    $sql = "SELECT * FROM usuario WHERE email = '$email'";
                    $result = mysqli_query($conn, $sql);
                    $user = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    if ($user){
                        if(password_verify($password, $user["senha"])){
                            session_start();
                            $user_id = $user["usuario_id"];
                            $_SESSION['user'] = $user_id;
                            header("Location: ./View/home.php");
                            exit();
                        }else{
                            echo "<div class='message error'>Senha incorreta</div>";
                        }
                    }else{
                        echo "<div class='message error'>O email não existe</div>";
                    }
                }
                ?>
                <h1>Entrar</h1>
                <input type="email" name="email" require placeholder="E-mail">
                <input type="password" name="password" require placeholder="Senha">
                <input class="formBtn" type="submit" name="login" value="Entrar"/>
            </form>
        </div>
        <div class="toggle-container">
            <div class="toggle">
                <div class="toggle-panel toggle-left">
                    <h1>Bem-vindo de volta!</h1>
                    <p>Preencha todos os dados para usar o site</p>
                    <button class="hidden" id="login">Entrar</button>
                </div>
                <div class="toggle-panel toggle-right">
                    <h1>Olá, amigo!</h1>
                    <p>Cadastre-se com seus dados pessoais para usar o site</p>
                    <button class="hidden" id="register">Cadastrar</button>
                </div>
            </div>
        </div>
    </div>

    <script src="index.js"></script>
</body>

</html>