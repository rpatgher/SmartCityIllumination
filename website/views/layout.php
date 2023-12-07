<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title?></title>
    <link rel="stylesheet" href="./build/css/app.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css" integrity="sha512-1sCRPdkRXhBV2PBLUdRb4tMg1w2YPf37qatUFeS7zlBy7jJI8Lf4VHwWfZZfpXtYSLy85pkm9GaYVYMfw5BC1A==" crossorigin="anonymous" referrerpolicy="no-referrer"/>
</head>
<body>
    <?php // session_start(); ?>
    <?php if($title !== 'Login'){ ?>
        <div class="full-page">
            <nav class="navbar">
                <div class="navbar__logo">
                    <a href="/"><i class="fa-solid fa-star"></i></a>
                </div>

                <ul class="navbar__ul">
                    <li>
                        <a href="/" class="navbar__link <?php echo $active_page === 'home' ? 'navbar__link--active' : '' ?>"><i class="fa-solid fa-house"></i></a>
                    </li>
                    <li>
                        <a href="/circuit" class="navbar__link <?php echo $active_page === 'circuit' ? 'navbar__link--active' : '' ?> "><i class="fa-solid fa-microchip"></i></a>
                    </li>
                    <li>
                        <a href="/graphs" class="navbar__link <?php echo $active_page === 'graphs' ? 'navbar__link--active' : '' ?> "><i class="fa-solid fa-chart-line"></i></a>
                    </li>
                </ul>

                <div class="navbar_logout">
                    <a href="/logout" class="navbar__link"><i class="fa-solid fa-sign-out"></i></a>
                </div>
            </nav>

            <main class="dashboard">
                <div class="dashboard__upperbar">
                    <div class="profile">
                        <div class="profile__name">
                            <p>Hi, <?php echo $_SESSION['name'] . ' ' . $_SESSION['last_name'] ?></p>
                        </div>
                        <div class="profile__image">
                            <img src="/build/img/<?php echo $_SESSION['image'] ?? 'user.png' ?>" alt="Profile Image">
                        </div>
                    </div>
                </div>
                <div class="dashboard__content">
                    <?php echo $content; ?>
                </div>
            </main>
        </div>
    <?php } else { ?>
        <?php echo $content; ?>
    <?php } ?>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <?php echo $scripts ?? ''; ?>
</body>
</html>