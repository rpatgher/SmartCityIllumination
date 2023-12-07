(function(){
    const ctx = document.getElementById('myChartVoltage');
    const timeBtns = document.querySelectorAll('.graph__button');
    const filter = document.querySelector('#filter');
    let filterTime = 'seconds';
    let labels;
    let currentDate = new Date();

    filter.addEventListener('change', (e) => {
        day = e.target.value;
        currentDate = new Date(`2023-11-${day}`);
        readData();
    });

    timeBtns.forEach(btn => {
        btn.addEventListener('click', (e) => {
            timeBtns.forEach(btn => btn.classList.remove('graph__button--active'));
            e.target.classList.add('graph__button--active');
            filterTime = e.target.dataset.filterTime;
            readData();
        });
    });

    async function readData(){
        const url = '/api/data';
        const response = await fetch(url);
        const data = await response.json();
        updateInfo(data);
    }

    function updateInfo(data){
        const hours = Array.from(new Set(data.map(d => d.time.split(' ')[1].split(':')[0]))).sort();
        const minutes = Array.from(new Set(data.map(d => d.time.split(' ')[1].split(':')[1]))).sort();
        const seconds = Array.from(new Set(data.map(d => d.time.split(' ')[1].split(':')[2]))).sort();
        const time = {'hours': hours, 'minutes' : minutes, 'seconds' : seconds};
        labels = time[filterTime];

        const formattedDate = currentDate.toISOString().split('T')[0];
        const filteredData = data.filter(d => d.time.split(' ')[0] == formattedDate);
        let ledData = [];
        for(let i = 0; i < 4; i++){
            const led = filteredData.filter(d => d.led == (i + 1));
            const d = led.map(l => l.power_mW);
            const l = {label: `Led ${i + 1}`, data: d, borderWidth: 1};
            ledData.push(l);
        }
        updateCharts(ledData);
    }

    function updateCharts(ledData){
        ledData.forEach((led, i) => {
            chart.data.labels = labels;
            chart.data.datasets[i].data = led.data;
            chart.update();
        });
    }

    readData();


    
    const chart = new Chart(ctx, {
        type: 'scatter',
        data: {
            labels: [],
            color: '#FFFFFF',
            datasets: [{
                label: 'Led 1',
                data: [],
                borderWidth: 1
            }, {
                label: 'Led 2',
                data: [],
                borderWidth: 1
            }, {
                label: 'Led 3',
                data: [],
                borderWidth: 1
            }, {
                label: 'Led 4',
                data: [],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    text: 'Power in Time',
                    color: '#FFFFFF'
                }
            },
            color: '#FFFFFF',
        },
    });
    
})();