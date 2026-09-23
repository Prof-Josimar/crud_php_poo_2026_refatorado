<div class="card shadow">
    <div class="card-header bg-primary text-white">
        <h4 class="mb-0">Extrato de <?= e($pessoa['nome']) ?> (ID <?= (int) $pessoa['id'] ?>)</h4>
    </div>
    <div class="card-body">
        <h5>Saldo atual: <span class="<?= $saldo < 0 ? 'text-danger' : 'text-success' ?>">R$ <?= moeda($saldo) ?></span></h5>
        <div class="d-flex gap-2 my-3">
            <a href="/movimentacoes/credito/<?= (int) $pessoa['id'] ?>" class="btn btn-success btn-sm">Depositar</a>
            <a href="/movimentacoes/debito/<?= (int) $pessoa['id'] ?>" class="btn btn-danger btn-sm">Sacar</a>
            <a href="/transferencias/<?= (int) $pessoa['id'] ?>" class="btn btn-primary btn-sm">Transferir</a>
        </div>
        <table class="table table-striped table-hover">
            <thead class="table-dark"><tr><th>ID</th><th>Crédito</th><th>Débito</th><th>Data</th><th>Observação</th></tr></thead>
            <tbody>
            <?php foreach ($movs as $m): ?>
                <tr>
                    <td><?= e($m['id']) ?></td>
                    <td><?= moeda($m['Credito']) ?></td>
                    <td><?= moeda($m['Debito']) ?></td>
                    <td><?= e($m['DataOperacao']) ?></td>
                    <td><?= e($m['Observacao']) ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
