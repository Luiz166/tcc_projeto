const ctx = document.getElementById("myChart");

new Chart(ctx, {
    type: 'line',
    data: {
      labels: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
      datasets: [{
        label: 'Receita Mensal',
        data: [1000, 1200, 900, 1400, 1230, 1000, 1100, 900, 1500, 1300, 1100, 1200],
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
