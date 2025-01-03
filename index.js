const container = document.getElementById('container');
const registerBtn = document.getElementById('register');
const loginBtn = document.getElementById('login');

const responsiveLoginBtn = document.getElementById('loginBtn');
const responsiveRegisterBtn = document.getElementById('registerBtn');

registerBtn.addEventListener('click', () => {
    container.classList.add("active");
});

loginBtn.addEventListener('click', () => {
    container.classList.remove("active");
});

responsiveRegisterBtn.addEventListener('click', () => {
    container.classList.add("active");
})

responsiveLoginBtn.addEventListener('click', () => {
    container.classList.remove("active");
})

if ('serviceWorker' in navigator) {
    navigator.serviceWorker.register('/service-worker.js')
        .then(registration => {
            console.log('Service Worker registrado com sucesso:', registration);
        })
        .catch(error => {
            console.log('Falha ao registrar o Service Worker:', error);
        });
}

console.log(('serviceWorker' in navigator));