<div class="circuit">
    <div class="circuit__actions">
        <!-- <div class="circuit__action circuit__action--apagar" data-action="fullActive">
            <p>Apagar Todo</p>
        </div> -->
        <div class="circuit__action circuit__action--prender" data-action="emergency">
            <p>Prender Todo</p>
        </div>
    </div>
    <div class="circuit__image">
        <img src="/build/img/circuit.png" alt="Circuit">
        <div class="circuit__buttons">
            <?php foreach($leds as $led): ?>    
                <div class="circuit__button circuit__button--<?php echo $led->id ?> <?php echo ($led->active === '1') ? 'circuit__button--active' : ''; ?>" data-led-id="<?php echo $led->id; ?>">
                    <?php if($led->active === '1'){ ?>
                        <i class="fa-solid fa-lightbulb"></i>
                    <?php }else{ ?>
                        <i class="fa-regular fa-lightbulb"></i>
                    <?php } ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>


<?php
$scripts = "
    <script src='/build/js/onOffLeds.js'></script>
";