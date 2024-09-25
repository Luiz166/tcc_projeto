<?php
session_start();
require_once "../resources/conn.php";
?>

<?php
    $sql = "SELECT nome, email FROM usuario WHERE usuario_id = ?";
    $user_id = $_SESSION["user"];
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows > 0){
        $row = $result->fetch_assoc();
        $user_name = $row['nome'];
        $user_email = $row['email'];
    }else{
        $user_name = "Convidado";
        $user_email = $row['Convidado'];
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/Style/home.css">
    <link rel="stylesheet" href="/Style/profile.css">
    <title>Document</title>
</head>
<body>
    <div class="container">
        <header>
            <span>Perfil</span>
        </header>
        <section class="profile-section">  
            <div class="profile-info">
                <div class="profile-image">
                    <img src="/Resources/Icons/user-solid.svg" alt="user">
                </div>
                <span id="name">
                    <?php echo htmlspecialchars($user_name); ?>
                </span>
                <span id="email">
                    <?php echo htmlspecialchars($user_email); ?>
                </span>
            </div>
            <div class="options">
                <button id="change-name-button" class="change-name hover-darker">Mudar nome</button>
                <button id="change-password-button" class="change-password hover-darker">Mudar senha</button>
                <a href="/Resources/logout.php" class="logout hover-darker">Sair</a>
            </div>
        </section>
        <footer class="navigation-bar">
            <div class="navigation-bar-items">
                <a href="/View/home.php">
                    <img src="/Resources/Icons/house-solid.svg" alt="">
                </a>
                <a href="/View/statistics.php">
                    <img src="/Resources/Icons/chart-simple-solid.svg" alt="">
                </a>
                <a href="/View/wallet.php">
                    <img src="/Resources/Icons/wallet-solid.svg" alt="">
                </a>
                <a href="#">
                    <img src="/Resources/Icons/user-solid.svg" alt="">
                </a>
            </div>
        </footer>
    </div>
    <div class="overlay"></div>
    <section class="change-name-container">
        <span>Mudar nome</span>
        <form action="" class="registerForm" method="post">
            <?php 
            if(isset($_POST["nameSubmit"])){
                $newName = $_POST['new-name'];

                $userId = $_SESSION['user'];
                $sql = 'UPDATE usuario SET nome = ? WHERE usuario_id = ?';
                if ($stmt = $conn->prepare($sql)){
                    $stmt->bind_param('si', $newName, $userId);
                    
                    if($stmt->execute()){
                        echo "Nome atualizado.";
                        header("Location: " . $_SERVER['PHP_SELF']);
                        exit();
                    }else{
                        echo "Erro atualizando nome: " . $stmt->error;
                    }
                    $stmt->close();
                }else{
                    echo "Erro preparando a query: " . $conn->error;
                }
            }
            ?>
            <div class="floating-label-group">
                <input class="floating-input" type="text" required name="new-name" id="" placeholder=" ">
                <label class="floating-label">Novo nome</label>
            </div>
            <input class="registerBtn" type="submit" name="nameSubmit" value="Mudar">
        </form>
    </section>
    <section class="change-password-container">
        <span>Mudar senha</span>
        <form action="" class="registerForm" method="post">
            <?php 
            if(isset($_POST["passwordSubmit"])){
                $newPassword = $_POST["new-password"];
                $error = array();
                $newPasswordHash = password_hash($newPassword, PASSWORD_DEFAULT);
                $userId = $_SESSION["user"];
                if(strlen($newPassword)<8){
                    array_push($error, "A senha deve ter no mínimo 8 caracteres.");
                }
                if(count($error) > 0){
                    foreach($error as $errors){
                        echo "<div class='error message'>$errors</div>";
                    }
                }else{
                    $sql = 'UPDATE usuario SET senha = ? WHERE usuario_id = ?';
                    if($stmt = $conn->prepare($sql)){
                        $stmt->bind_param('si', $newPasswordHash, $userId);

                        if($stmt->execute()){
                            echo "Senha atualizada";
                            header("Location: " . $_SERVER['PHP_SELF']);
                            exit();
                        }else{
                            echo "Erro atualizando senha: " . $stmt->error;
                        }
                        $stmt->close();
                    }else{
                        echo "Erro preparando a query: " . $conn->error;
                    }
                }
            }
            ?>
            <div class="floating-label-group">
                <input class="floating-input" type="password" required name="new-password" id="" placeholder=" ">
                <label class="floating-label">Nova senha</label>
            </div>
            <input class="registerBtn" type="submit" name="passwordSubmit" value="Mudar">
        </form>
    </section>
    <script src="/Resources/profile.js"></script>
</body>
</html>