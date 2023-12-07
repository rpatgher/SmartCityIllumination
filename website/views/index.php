<!-- <h2 class="graph__heading graph__heading--main">Resumen</h2> -->
<div class="graphs">
    <div class="graph">
        <h3 class="graph__heading graph__heading--circle">Led 1</h3>
        <div class="graph__chart">
            <div class="graph__canvas">
                <div class="circle-graph" data-led-id="1">
                    <div class="circle-graph__circle">
                        <div class="circle-graph__cirle circle-graph__circle--inner">
                            <p>0%</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="graph">
        <h3 class="graph__heading graph__heading--circle">Led 2</h3>
        <div class="graph__chart">
            <div class="graph__canvas">
                <div class="circle-graph" data-led-id="2">
                    <div class="circle-graph__circle">
                        <div class="circle-graph__cirle circle-graph__circle--inner">
                            <p>0%</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="graph">
        <h3 class="graph__heading graph__heading--circle">Led 3</h3>
        <div class="graph__chart">
            <div class="graph__canvas">
                <div class="circle-graph" data-led-id="3">
                    <div class="circle-graph__circle">
                        <div class="circle-graph__cirle circle-graph__circle--inner">
                            <p>0%</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="graph">
        <h3 class="graph__heading graph__heading--circle">Led 4</h3>
        <div class="graph__chart">
            <div class="graph__canvas">
                <div class="circle-graph" data-led-id="4">
                    <div class="circle-graph__circle">
                        <div class="circle-graph__cirle circle-graph__circle--inner">
                            <p>0%</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="widgets">
    <div class="widgets__weather">
        <div class="widgets__weather-image">
            <img src="/build/img/weather.png" alt="Weather Image">
        </div>
        <div class="widgets__weather-info">
            <div class="weather-icons">
                <div class="weather-icons__icon">
                    <i class="fas fa-thermometer-half"></i>
                    <p>22 ºC</p>
                </div>

                <div class="weather-icons__icon">
                    <i class="fas fa-tint"></i>
                    <p>40 %</p>
                </div>

                <div class="weather-icons__icon">
                    <i class="fa-solid fa-sun"></i>
                    <p>80 %</p>
                </div>
            </div>
        </div>
    </div>
    <div class="widgets__time">
        <div class="widget-time">
            <div class="widget-time__date">
                <p class="long-date"></p>
            </div>
            <div class="widget-time__clock">
                <p class="hour"></p>
                <p>:</p>
                <p class="minutes"></p>
                <p>:</p>
                <div class="widget-time__seconds-box">
                    <p class="ampm"></p>
                    <p class="seconds"></p>
                </div>
            </div>
        </div>
    </div>
</div>


<?php  
$scripts = "
    <script src='/build/js/timeWeather.js'></script>
    <script src='/build/js/ledCharts.js'></script>
    <script src='/build/js/updateLed.js'></script>
";
?>