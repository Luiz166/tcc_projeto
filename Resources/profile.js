changeNameBtn = document.querySelector('#change-name-button');
changePasswordBtn = document.querySelector('#change-password-button');

containerChangeName = document.querySelector('.change-name-container');
containerChangePassword = document.querySelector('.change-password-container');

changeNameBtn.addEventListener('click', () => {
    containerChangeName.style.display = "flex";
});

changePasswordBtn.addEventListener('click', () => {
    containerChangePassword.style.display= "flex";
})