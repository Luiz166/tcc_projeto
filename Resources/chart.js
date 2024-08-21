const ctx = document.getElementById("myChart");



let myChart = new Chart(ctx, {
  type: 'line',
  data: {
    labels: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
    datasets: [{
      label: 'Receita',
      data: [],
      borderWidth: 1
    }]
  },
  options: {
    scales: {
      y: {
        beginAtZero: true
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

