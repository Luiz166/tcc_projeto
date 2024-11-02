addTransactionBtn = document.querySelector('.add-button');
overlay = document.querySelector('.overlay');
addTransactionContainer = document.querySelector('.add-transaction-container');

parcelaCheck = document.querySelector('#parcela_check')
parcelaInputDiv = document.querySelector('#parcela_div')

addTransactionBtn.addEventListener("click", () => {
    overlay.style.display = "block"
    addTransactionContainer.style.display = "flex"
})

overlay.onclick = () => {
    overlay.style.display = "none"
    addTransactionContainer.style.display = "none"
}

parcelaCheck.addEventListener("change", (e) => {
    if(e.currentTarget.checked){
        parcelaInputDiv.style.display = "block"
    }
    else{
        parcelaInputDiv.style.display = "none"
    }
})