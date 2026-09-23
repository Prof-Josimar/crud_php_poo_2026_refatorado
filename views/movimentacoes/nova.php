<div class="card shadow">
    <div class="card-header bg-primary text-white"><h4 class="mb-0">Nova movimentação — escolha a pessoa</h4></div>
    <div class="card-body">
        <form method="get" action="/movimentacoes/nova" class="mb-4">
            <div class="input-group">
                <input type="text" name="nome" class="form-control" placeholder="Digite o nome" value="<?= e($termo) ?>" autofocus>
                <button type="submit" class="btn btn-success">Pesquisar</button>
            </div>
        </form>

        <?php if ($pessoas): ?>
            <table class="table table-striped table-hover align-middle">
                <thead class="table-dark"><tr><th>ID</th><th>Nome</th><th>Movimentar</th></tr></thead>
                <tbody>
                <?php foreach ($pessoas as $p): ?>
                    <tr>
                        <td><?= e($p['id']) ?></td>
                        <td><?= e($p['nome']) ?></td>
                        <td class="d-flex gap-2">
                            <a href="/movimentacoes/credito/<?= (int) $p['id'] ?>" class="btn btn-success btn-sm">Depositar</a>
                            <a href="/movimentacoes/debito/<?= (int) $p['id'] ?>" class="btn btn-danger btn-sm">Sacar</a>
                            <a href="/transferencias/<?= (int) $p['id'] ?>" class="btn btn-primary btn-sm">Transferir</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        <?php elseif ($buscou): ?>
            <div class="alert alert-warning mb-0">Nenhum resultado encontrado.</div>
        <?php endif; ?>
    </div>
</div>
