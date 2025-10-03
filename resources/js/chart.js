import Chart from 'chart.js/auto';

const months = [
    'January',
    'Febuary',
    'Maret',
    'April',
    'May',
    'June',
    'July',
    'August',
    'September',
    'October',
    'November',
    'Desember'
];

function setUpChart(id= 'piechart', dataset) {
    const category = {
        uniform : 'Seragam',
        attribute : 'Attribut'
    }
    const totalTransaction = dataset.reduce((acc, current) => acc + Number(current.total) ,0)
    const data = dataset.map(d => {
        return {
            category : category[d.category],
            persentase : Math.round(d.total / totalTransaction * 100)
        }
    });
    return new Chart(
        document.getElementById(id),
        {
            type: 'pie',
            data: {
                labels: data.map(d => d.category),
                datasets: [
                    {
                        label: 'Persentase',
                        data: data.map(d => d.persentase),
                        backgroundColor: [
                            "#5c74dbff",
                            "#273b98",
                        ]
                    },
                ]
            }
        }
    );
}

function setUpTransactionBar(id, dataset_transactions) {
    const dataTransaction = months.map(m => {
        return {
            month : m,
            total : 0
        }
    });
    dataset_transactions.forEach(({ created_at, total_products }) => {
        dataTransaction[new Date(created_at).getMonth()].total = Number(total_products)
    });
    return new Chart(
        document.getElementById(id),
        {
            type: 'bar',
            data: {
                labels: dataTransaction.map(dt => dt.month),
                datasets: [
                    {
                        label: 'Jumlah Pembelian',
                        data: dataTransaction.map(dt => dt.total),
                        backgroundColor: [
                            "#5c74dbff",
                            "#273b98"
                        ],
                    },
                ]
            }
        }
    );
}

setUpTransactionBar('linechart', dataset_transactions['transaction'])
setUpChart('piechart', dataset_transactions['uniform']);

document.querySelectorAll('.chart-action').forEach(action => {
    Array.from(action.children).forEach(btn => {
        btn.addEventListener('click', () => {
            btn.classList.toggle('btn-submit')
        });
    })
});
