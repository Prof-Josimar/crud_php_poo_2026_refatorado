<div class="card shadow">
    <div class="card-header bg-primary text-white"><h4 class="mb-0">Pesquisar Pessoa</h4></div>
    <div class="card-body">
        <form method="get" action="/pessoas/pesquisar" class="mb-4">
            <div class="input-group">
                <input type="text" name="nome" class="form-control" placeholder="Digite o nome"
                       value="<?= e($termo) ?>" autofocus>
                <button type="submit" class="btn btn-success">Pesquisar</button>
            </div>
        </form>

        <?php if ($pessoas): ?>
            <?php App\Core\View::partial('pessoas/_tabela', compact('pessoas')) ?>
        <?php elseif ($buscou): ?>
            <div class="alert alert-warning mb-0">Nenhum resultado encontrado.</div>
        <?php endif; ?>
    </div>
</div>
