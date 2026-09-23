<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistema Financeiro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="/assets/css/app.css" rel="stylesheet">
</head>
<body class="d-flex flex-column min-vh-100">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow">
    <div class="container-fluid">
        <a class="navbar-brand" href="/">Sistema Financeiro</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSistema">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSistema">
            <ul class="navbar-nav me-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">Pessoas</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="/pessoas/novo">Cadastrar</a></li>
                        <li><a class="dropdown-item" href="/pessoas">Listar</a></li>
                        <li><a class="dropdown-item" href="/pessoas/pesquisar">Pesquisar</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="/pessoas/excluir-todas">Excluir Todas</a></li>
                    </ul>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">Movimentações</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="/movimentacoes/nova">Nova</a></li>
                        <li><a class="dropdown-item" href="/movimentacoes">Listar</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="/movimentacoes/saldos-positivos">Saldos Positivos</a></li>
                        <li><a class="dropdown-item" href="/movimentacoes/saldos">Saldo Resumido</a></li>
                    </ul>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">Faker</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="/faker/pessoas">Gerar Pessoas</a></li>
                        <li><a class="dropdown-item" href="/faker/usuarios">Usuários Faker</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

<main class="flex-grow-1 container mt-4">
    <?php foreach (flash_pull() as $f): ?>
        <div class="alert alert-<?= e($f['tipo']) ?> alert-dismissible fade show">
            <?= e($f['mensagem']) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endforeach; ?>

    <?= $content ?>
</main>

<footer class="bg-dark text-white text-center py-3 mt-4">
    <p class="mb-1">&copy; <?= date('Y') ?> - Sistema Financeiro</p>
    <p id="relogio" class="mb-0"></p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="/assets/js/relogio.js"></script>
</body>
</html>
