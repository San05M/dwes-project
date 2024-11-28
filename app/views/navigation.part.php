<?php require_once __DIR__ . '/../utils/utils.class.php'; ?>
<!--Navigation Part -->
<div class="nav-main">
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light">
            <a class="navbar-brand font-weight-bold" href="index.php">art.studio</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <?php if (esOpcionMenuActiva('/index') == true || esOpcionMenuActiva('/') == true)  echo '<li class="active lien">';
                        else echo '<li class=”0lien”>'; ?>
                        <a class="nav-link" href="/index">Principal</a>
                    </li>
                    </li>
                    <li class="nav-item">
                        <?php if (esOpcionMenuActiva('/project') == true) echo '<li class="active lien">';
                        else echo '<li class=”0lien”>'; ?>
                        <a class="nav-link" href="project.view.php">Projecto</a>
                    </li>
                    <li class="nav-item">
                        <?php if (esOpcionMenuActiva('/galeria') == true) echo '<li class="active lien">';
                        else echo '<li class=”0lien”>'; ?>
                        <a class="nav-link" href="galeria.view.php">Galeria</a>
                    </li>
                    <li class="nav-item">
                        <?php if (esOpcionMenuActiva('/about') == true) echo '<li class="active lien">';
                        else echo '<li class=”0lien”>'; ?>
                        <a class="nav-link" href="abou.view.phpt">Sobre nosotros</a>
                    </li>
                </ul>

                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <?php if (esOpcionMenuActiva('/contact') == true) echo '<li class="active lien">';
                        else echo '<li class=”0lien”>'; ?>
                        <a class="nav-link" href="contact.view.php">Contáctanos</a>
                    </li>
                </ul>
            </div>
        </nav>
        <!--end:Nav -->
    </div>
</div>
<!--end:Navigation -->