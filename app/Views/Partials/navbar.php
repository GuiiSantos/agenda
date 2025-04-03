<?php $session = session(); ?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Agenda</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link <?= $title === 'activities' ? 'active' : '' ?>" href="/activities">Atividades </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $title === 'calendar' ? 'active' : '' ?>" href="/calendar">Calendário</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('/logout') ?>">Sair</a>
                </li>
            </ul>

            <!-- Alinhar para a direita -->
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="#"><?= 'Olá, ' . $session->get('user')['login'] ?></a>
                </li>
            </ul>
        </div>

    </div>
</nav>
