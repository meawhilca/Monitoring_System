new Chart(document.getElementById('budgetChart'), {
    type: 'doughnut',
    data: {
        labels: ['Expenses', 'Remaining'],
        datasets: [{
            data: [total, remaining],
            backgroundColor: [
                'rgba(255, 99, 132, 0.8)',
                'rgba(0, 255, 200, 0.8)'
            ],
            borderWidth: 0
        }]
    },
    options: {
        cutout: '70%',
        plugins: {
            legend: {
                labels: { color: '#fff' }
            }
        }
    }
});

new Chart(document.getElementById('pieChart'), {
    type: 'doughnut',
    data: {
        labels: ['Expenses', 'Remaining'],
        datasets: [{
            data: [total, remaining],
            backgroundColor: [
                'rgba(255, 99, 132, 0.8)',
                'rgba(0, 255, 200, 0.8)'
            ],
            borderWidth: 0
        }]
    },
    options: {
        plugins: {
            legend: {
                labels: { color: '#fff' }
            }
        }
    }
});

new Chart(document.getElementById('barChart'), {
    type: 'bar',
    data: {
        labels: ['Budget', 'Expenses', 'Remaining'],
        datasets: [{
            data: [budget, total, remaining],
            backgroundColor: ['#00eaff', '#ff4d6d', '#00ffb3'],
            borderRadius: 10
        }]
    },
    options: {
        plugins: {
            legend: { display: false }
        },
        scales: {
            x: { ticks: { color: '#fff' } },
            y: { ticks: { color: '#fff' } }
        }
    }
}); 