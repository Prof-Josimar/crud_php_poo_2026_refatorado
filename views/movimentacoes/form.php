<div class="card shadow">
    <div class="card-header bg-primary text-white">
        <h4 class="mb-1"><?= e($config['titulo']) ?></h4>
        <div><?= $destino ? 'Origem' : 'Pessoa' ?>: <?= e($pessoa['nome']) ?> (ID <?= (int) $pessoa['id'] ?>)</div>
        <?php if ($destino): ?>
            <div>Destino: <?= e($destino['nome']) ?> (ID <?= (int) $destino['id'] ?>)</div>
        <?php endif; ?>
    </div>
    <div class="card-body">
        <?php if ($erro): ?><div class="alert alert-danger"><?= e($erro) ?></div><?php endif; ?>

        <form method="post" action="<?= e($acao) ?>">
            <?= csrf_field() ?>
            <div class="mb-3">
                <label for="valor" class="form-label">Valor</label>
                <input type="number" step="0.01" min="0.01" name="valor" id="valor" class="form-control" required autofocus
                       value="<?= e($_POST['valor'] ?? '') ?>">
            </div>

            <?php if ($observacao !== null): ?>
                <div class="mb-3">
                    <label for="observacao" class="form-label">Observação</label>
                    <input type="text" name="observacao" id="observacao" class="form-control" maxlength="255"
                           value="<?= e($observacao) ?>">
                </div>
            <?php endif; ?>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-success">Gravar</button>
                <a href="/movimentacoes/extrato/<?= (int) $pessoa['id'] ?>" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
