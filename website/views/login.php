<div class="alerts">
    <?php
        // debuguear($alerts);
        foreach($alerts as $key => $alert):
            foreach($alert as $message):
    ?>
        <div class="alerta alerta__<?php echo $key; ?>"><?php echo $message; ?></div>

    <?php 
            endforeach;
        endforeach;
    ?>
</div>

<div class="login">
    <h1 class="login__heading">Login</h1>
    <form action="/login" class="login__form" method="POST">
        <div class="login__campo">
            <label for="username">Username: </label>
            <input type="text" placeholder="Username" id="username" name="username">
        </div>
        <div class="login__campo">
            <label for="password">Password: </label>
            <input type="password" placeholder="Password" id="password" name="password">
        </div>

        <div class="login__campo login__campo--subimt">
            <input type="submit" value="Login">
        </div>
    </form>
</div>

<?php 
// $scripts = "<script src='/build/js/deleteAlerts.js'></script>";
?>