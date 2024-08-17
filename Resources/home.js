addTransactionBtn = document.querySelector('.add-button');
overlay = document.querySelector('.overlay');
addTransactionContainer = document.querySelector('.add-transaction-container');

addTransactionBtn.addEventListener("click", () => {
    overlay.style.display = "block"
    addTransactionContainer.style.display = "flex"
})

overlay.onclick = () => {
    overlay.style.display = "none"
    addTransactionContainer.style.display = "none"
}