(function(){
    function updateTime(){
        const currentDate = new Date();
        document.querySelector('.hour').textContent = currentDate.getHours().toString().padStart(2, '0');
        document.querySelector('.minutes').textContent = currentDate.getMinutes().toString().padStart(2, '0');
        document.querySelector('.seconds').textContent = currentDate.getSeconds().toString().padStart(2, '0');
        document.querySelector('.ampm').textContent = currentDate.toLocaleString().split(' ')[2];
        updateDate(currentDate);
    }

    function updateDate(currentDate){
        document.querySelector('.long-date').textContent = currentDate.toDateString();
    }


    updateTime();
    setInterval(updateTime, 1000);
    
})();