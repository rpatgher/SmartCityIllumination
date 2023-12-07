(function(){
    const onOffLeds = document.querySelectorAll('.circuit__button');
    const actionsBtns = document.querySelectorAll('.circuit__action');
    actionsBtns.forEach(btn => {
        btn.addEventListener('click', (e) => {
            let url = `http://10.49.74.251`;
            const action = btn.dataset.action;
            // console.log(action);
            if(action === 'emergency'){
                url += `/emergency=`;
                if(btn.classList.contains('circuit__action--active')){
                    btn.classList.remove('circuit__action--active');
                    url += `OFF`;
                }else{
                    const prevActive = document.querySelector('.circuit__action--active');
                    if(prevActive){
                        prevActive.classList.remove('circuit__action--active');
                    }
                    btn.classList.add('circuit__action--active');
                    url += `ON`;
                }
            }else{
                url += `/fullActive=`;
                if(btn.classList.contains('circuit__action--active')){
                    btn.classList.remove('circuit__action--active');
                    url += `ON`;
                }else{
                    const prevActive = document.querySelector('.circuit__action--active');
                    if(prevActive){
                        prevActive.classList.remove('circuit__action--active');
                    }
                    btn.classList.add('circuit__action--active');
                    url += `OFF`;
                }
            }
            mandarInstruccion(url);
        });
    });
    onOffLeds.forEach(btn => {
        btn.addEventListener('click', (e) => {
            const led = btn.dataset.ledId;
            console.log(led);
            let url = `http://10.49.74.251`;
            if(btn.classList.contains('circuit__button--active')){
                btn.classList.remove('circuit__button--active');
                btn.children[0].classList.remove('fa-solid');
                btn.children[0].classList.add('fa-regular');
                url += `/LED${led}=OFF`;
            }else{
                btn.classList.add('circuit__button--active');
                btn.children[0].classList.add('fa-solid');
                btn.children[0].classList.remove('fa-regular');
                url += `/LED${led}=ON`;
            }
            mandarInstruccion(url);
        });
    });


    function mandarInstruccion(url){
        console.log(url);
        fetch(url)
        .then(response => response.json())
        .then(data => console.log(data))
        .catch(err => console.log(err));
    }
})();