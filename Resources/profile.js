changeNameBtn = document.querySelector('#change-name-button');
changePasswordBtn = document.querySelector('#change-password-button');

containerChangeName = document.querySelector('.change-name-container');
containerChangePassword = document.querySelector('.change-password-container');
overlay = document.querySelector('.overlay');

changeNameBtn.addEventListener('click', () => {
    containerChangeName.style.display = "flex";
    overlay.style.display = "block";
});

changePasswordBtn.addEventListener('click', () => {
    containerChangePassword.style.display= "flex";
    overlay.style.display = "block";
})

overlay.onclick = () => {
    containerChangeName.style.display = "none";
    containerChangePassword.style.display = "none";
    overlay.style.display = "none";
}