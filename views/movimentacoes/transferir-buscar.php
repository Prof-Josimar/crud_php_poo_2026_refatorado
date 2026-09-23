<div class="card shadow">
    <div class="card-header bg-primary text-white">
        <h4 class="mb-1">Escolha o destino da transferência</h4>
        <div>Origem: <?= e($origem['nome']) ?> (ID <?= (int) $origem['id'] ?>)</div>
    </div>
    <div class="card-body">
        <form method="get" action="/transferencias/<?= (int) $origem['id'] ?>" class="mb-4">
            <div class="input-group">
                <input type="text" name="nome" class="form-control" placeholder="Digite o nome do destinatário"
                       value="<?= e($termo) ?>" autofocus>
                <button type="submit" class="btn btn-success">Pesquisar</button>
            </div>
        </form>

        <?php if ($pessoas): ?>
            <table class="table table-striped table-hover align-middle">
                <thead class="table-dark"><tr><th>ID</th><th>Nome</th><th></th></tr></thead>
                <tbody>
                <?php foreach ($pessoas as $p): ?>
                    <tr>
                        <td><?= e($p['id']) ?></td>
                        <td><?= e($p['nome']) ?></td>
                        <td><a href="/transferencias/<?= (int) $origem['id'] ?>/<?= (int) $p['id'] ?>" class="btn btn-primary btn-sm">Selecionar</a></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        <?php elseif ($buscou): ?>
            <div class="alert alert-warning mb-0">Nenhum resultado encontrado.</div>
        <?php endif; ?>
    </div>
</div>
