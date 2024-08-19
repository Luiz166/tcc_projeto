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
        <div class="profile-info">
            <div class="profile-image">
                <img src="/Resources/Icons/user-solid.svg" alt="user">
            </div>
            <span id="name">
                Nome
            </span>
            <span id="email">
                email@email.com
            </span>
        </div>
        <div class="options">
            <button id="change-name-button" class="change-name">Mudar nome</button>
            <button id="change-password-button" class="change-password">Mudar senha</button>
            <a href="" class="logout">Sair</a>
        </div>
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
        <form action="" class="registerForm">
            <div class="floating-label-group">
                <input class="floating-input" type="text" name="" id="" placeholder=" ">
                <label class="floating-label">Novo nome</label>
            </div>
            <input class="registerBtn" type="submit" value="Mudar">
        </form>
    </section>
    <section class="change-password-container">
        <span>Mudar senha</span>
        <form action="" class="registerForm">
            <div class="floating-label-group">
                <input class="floating-input" type="password" name="" id="" placeholder=" ">
                <label class="floating-label">Nova senha</label>
            </div>
            <input class="registerBtn" type="submit" value="Mudar">
        </form>
    </section>
    <script src="/Resources/profile.js"></script>
</body>
</html>