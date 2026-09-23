<div class="card shadow">
    <div class="card-header bg-primary text-white"><h4 class="mb-0">Todas as movimentações</h4></div>
    <div class="card-body">
        <table class="table table-striped table-hover align-middle">
            <thead class="table-dark">
                <tr><th>ID</th><th>Nome</th><th>Crédito</th><th>Débito</th><th>Data</th><th>Observação</th><th></th></tr>
            </thead>
            <tbody>
            <?php foreach ($movs as $m): ?>
                <tr>
                    <td><?= e($m['id']) ?></td>
                    <td><?= e($m['nome']) ?></td>
                    <td><?= moeda($m['Credito']) ?></td>
                    <td><?= moeda($m['Debito']) ?></td>
                    <td><?= e($m['DataOperacao']) ?></td>
                    <td><?= e($m['Observacao']) ?></td>
                    <td><a href="/movimentacoes/extrato/<?= (int) $m['idPessoa'] ?>" class="btn btn-info btn-sm">Ver Extrato</a></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
