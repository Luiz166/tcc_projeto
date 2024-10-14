<?php 
session_start();
if(isset($_SESSION["user"])){
    header("Location: home.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/Style/index.css">
    <link rel="stylesheet" href="/Style/login-register.css">
    <title>Document</title>
</head>
<body>
    <div class="container">
        <section class="esquerdaImg">
            <img src="/Resources/Img/happy-woman-smiling.jpg" alt="happy-woman-smiling">
        </section>
        <div class="direitaForm">
            <span>Bem-vindo de volta!</span>
            <div class="formImg">
                <img src="/Resources/Img/loginImg.png">
            </div>
            <form action="" class="registerForm" method="post">
                <?php 
                    if(isset($_POST["login"])){
                        $email = $_POST["email"];
                        $password = $_POST["password"];
                        require_once "../Resources/conn.php";
                        $sql = "SELECT * FROM usuario WHERE email = '$email'";
                        $result = mysqli_query($conn, $sql);
                        $user = mysqli_fetch_array($result, MYSQLI_ASSOC);
                        if ($user){
                            if(password_verify($password, $user["senha"])){
                                session_start();
                                $user_id = $user["usuario_id"];
                                $_SESSION['user'] = $user_id;
                                header("Location: home.php");
                                exit();
                            }else{
                                echo "<div class='message error'>Senha incorreta</div>";
                            }
                        }else{
                            echo "<div class='message error'>O email não existe</div>";
                        }
                    }
                ?>
                <div class="floating-label-group">
                    <input type="email" name="email" class="floating-input" placeholder=" " id="">
                    <label class="floating-label">Email</label>
                </div>
                <div class="floating-label-group">
                    <input type="password" name="password" class="floating-input" placeholder=" " id="">
                    <label class="floating-label">Senha</label>
                </div>
                <input class="registerBtn" type="submit" name="login" value="Entrar">
                <span>Não tem uma conta? <a href="/View/register.php">Criar conta</a></span>
            </form>
        </div>
    </div>
</body>
</html>