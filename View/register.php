<?php 
include '../resources/conn.php';
require '../resources/helper.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Style/index.css">
    <link rel="stylesheet" href="../Style/login-register.css">
    <title>Document</title>
</head>
<body>
    <div class="container">

        <section class="esquerdaImg">
            <img src="/Resources/Img/woman-lookingphone.jpg" alt="woman-lookingphone">
        </section>
        <section class="direitaForm">
            <span>Começa a salvar seu dinheiro!</span>
            <div class="formImg">
                <img src="/Resources/Img/registerImg.png">
            </div>
            <form class="registerForm" action="" method="post">
            <?php 
            if(isset($_POST["submit-button"])){
                $fullName = $_POST["name"];
                $email = $_POST["email"];
                $password = $_POST["password"];
                $confirmPassword = $_POST["confirm-password"];
                $error = array();

                if(strlen($password)<8){
                    array_push($error, "Senha deve ter no mínimo 8 caracteres");
                }

                if($password !== $confirmPassword){
                    array_push($error, "A senha não corresponde.");
                }
                if(count($error) > 0){
                    foreach($error as $errors){
                        echo "<div class='error-message'>$errors</div>";
                    }
                }else{

                }
            }
            ?>
                <div class="floating-label-group">
                    <input type="text" name="name" class="floating-input" placeholder=" " id="" required>
                    <label class="floating-label">Nome Completo<w/label>
                </div>
                <div class="floating-label-group">
                    <input type="email" name="email" class="floating-input" placeholder=" " id="" required>
                    <label class="floating-label">Email</label>
                </div>
                <div class="floating-label-group">
                    <input type="password" name="password" class="floating-input" placeholder=" " id="" required>
                    <label class="floating-label">Senha</label>
                </div>
                <div class="floating-label-group">
                    <input type="password" name="confirm-password" class="floating-input" placeholder=" " id="" required>
                    <label class="floating-label">Confirmar senha</label>
                </div>
                <input type="submit" class="registerBtn" name="submit-button" value="Cadastrar">
                <span>Já tem uma conta? <a href="/View/login.html">Entrar</a></span>
            </form>
        </section>
    </div>
</body>
</html>