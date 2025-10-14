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

function setUpBarChart(id, data_chart) {
    let data_preparation = months.map(m => {
        return {
            month : m,
            total : 0
        }
    });
    data_chart.forEach(({ created_at }) => {
        const month = months[new Date(created_at).getMonth()];
        data_preparation = data_preparation.map(data => {
            if(data.month == month) data.total +=1;
            return data;
        });
    });
    return new Chart(
        document.getElementById(id),
        {
            type: 'bar',
            data: {
                labels: data_preparation.map(dt => dt.month),
                datasets: [
                    {
                        label: 'Jumlah Calon Peserta Didik',
                        data: data_preparation.map(dt => dt.total),
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


// setUpChart('piechart', dataset_transactions['uniform']);

function getBarCharts(){
    try{
        barChartOptions.forEach( data => setUpBarChart(data.idElement, data.data) );
    }catch(error){
       console.log(error)
    }
}

function initCharts(){
   getBarCharts();
}

// document.querySelectorAll('.chart-action').forEach(action => {
//     Array.from(action.children).forEach(btn => {
//         btn.addEventListener('click', () => {
//             btn.classList.toggle('btn-submit')
//         });
//     })
// });

initCharts();
