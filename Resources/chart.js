const ctx = document.getElementById("myChart");



let myChart = new Chart(ctx, {
  type: 'line',
  data: {
    labels: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
    datasets: [{
      label: 'Receita',
      data: [],
      borderWidth: 1,
      fill: true
    }]
  },
  options: {
    scales: {
      y: {
        beginAtZero: true,
        ticks: {
          color: '#ccc'
        },
        grid: {
          color: '#323755'
        }
      },
      x: {
        ticks: {
          color: '#ccc'
        },
        grid: {
          color: '#323755'
        }
      }
    }
  }
});


function updateChart(periodo) {
  fetch(`../Resources/getDataChart.php?periodo=${periodo}`)
    .then(response => response.json())
    .then(data => {
      myChart.data.labels = data.labels;
      myChart.data.datasets[0].data = data.dados;
      myChart.update();
    })
}

let btnSemana = document.getElementById("btn-semana");
let btnMes = document.getElementById("btn-mes");
let btnAno = document.getElementById("btn-ano");


btnSemana.addEventListener('click', function () {
  updateChart('semana');
  btnSemana.classList.add('selected');
  btnMes.classList.remove('selected');
  btnAno.classList.remove('selected');
});

btnMes.addEventListener('click', function () {
  updateChart('mes');
  btnSemana.classList.remove('selected');
  btnMes.classList.add('selected');
  btnAno.classList.remove('selected');
});

btnAno.addEventListener('click', function () {
  updateChart('ano');
  btnSemana.classList.remove('selected');
  btnMes.classList.remove('selected');
  btnAno.classList.add('selected');
});

console.log(myChart.defaults);

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

