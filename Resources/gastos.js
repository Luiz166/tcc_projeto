const ctx = document.getElementById("myChart");



let myChart = new Chart(ctx, {
  type: 'doughnut',
  data: {
    datasets: [{
      label: 'Gasto bruto',
      data: [],
      borderWidth: 1,
      fill: true, 
      backgroundColor: ['#33E6F6', '#323755', '#33B0F6'],
      borderColor: ['#33E6F6', '#323755', '#33B0F6']
    }]
  },

  options: {
    responsive: true,
    plugins: {
      legend: {
        position: 'top',
      },
      title: {
        display: false,
        text: 'Chart.js Doughnut Chart'
      }
    }
    }
});


function updateChart() {
  fetch(`../Resources/getGastosChart.php`)
    .then(response => response.json())
    .then(data => {
      myChart.data.labels = data.labels;
      myChart.data.datasets[0].data = data.dados;
      myChart.update();
    })
}

updateChart()
addTransactionBtn = document.querySelector('.add-button');

const container = document.querySelector('.container');
const transactionContainer = document.querySelector('.add-transaction-container');

addTransactionBtn.addEventListener('click', () => {
    container.classList.add("fade-out");
    transactionContainer.classList.remove("hidden")
    transactionContainer.classList.add("fade-in")

    setTimeout(() => {
        container.classList.add("hidden");
        container.classList.remove("fade-out");
        transactionContainer.classList.remove("fade-in");
    }, 500)
})


parcelaCheck = document.querySelector('#parcela_check')
parcelaInputDiv = document.querySelector('#parcela_div')

parcelaCheck.addEventListener("change", (e) => {
    if(e.currentTarget.checked){
        parcelaInputDiv.style.display = "block"
    }
    else{
        parcelaInputDiv.style.display = "none"
    }
})

