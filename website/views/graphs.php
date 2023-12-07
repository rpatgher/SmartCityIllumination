<div class="graph graph--power">
    <div class="graph__header">
        <h2 class="graph__heading graph__heading--power">Power - Time</h2>
        <div class="graph__filters">
            <div class="graph__filter">
                <label for="graph__filter--day">Day:</label>
                <select name="graph__filter--day" id="filter">
                    <option disabled selected>--Choose a Day--</option>
                    <?php foreach($days as $day): ?>
                        <option value="<?= $day ?>"><?= $day ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            
        </div>
    </div>
    <div class="graph__chart">
        <div class="graph__canvas graph__canvas--power">
            <canvas id="myChartVoltage"></canvas>
            <div class="graph__options">
                <button class="graph__button graph__button--active" data-filter-time="seconds">Seconds</button>
                <button class="graph__button" data-filter-time="minutes">Minutes</button>
                <button class="graph__button" data-filter-time="hours">Hours</button>
            </div>
        </div>
    </div>
</div>




<?php  
$scripts = "
    <script src='/build/js/charts.js'></script>
    ";
?>