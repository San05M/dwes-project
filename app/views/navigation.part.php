<?php

use dwes\app\utils\Utils; ?>

<!--Navigation Part -->
<div class="nav-main">
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light">
            <a class="navbar-brand font-weight-bold" href="index.php">Projecto Sandra</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                    <a href="/" <?php if (Utils::esOpcionMenuActiva('/index') || Utils::esOpcionMenuActiva('/')) echo 'active'; ?>">Home</a>
                    </li>
                    <li class="nav-item">
                    <a href="/" <?php if (Utils::esOpcionMenuActiva('/galeria') || Utils::esOpcionMenuActiva('/')) echo 'active'; ?>">Galeria</a>
                    </li>
                    <li class="nav-item">
                    <a href="/"  <?php if (Utils::esOpcionMenuActiva('/perfil') || Utils::esOpcionMenuActiva('/')) echo 'active'; ?>">Perfil</a>
                    </li>
                </ul>

                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                    <a href="/"  <?php if (Utils::esOpcionMenuActiva('/login') || Utils::esOpcionMenuActiva('/')) echo 'active'; ?>">Login</a>
                    </li>
                    <li class="nav-item">
                    <a href="/"<?php if (Utils::esOpcionMenuActiva('/registro') || Utils::esOpcionMenuActiva('/')) echo 'active'; ?>">Home</a>
                    </li>
                    <li class="nav-item">
                    <a>Logout</a>
                    </li>
                </ul>
            </div>
        </nav>
        <!--end:Nav -->
    </div>
</div>
<!--end:Navigation -->