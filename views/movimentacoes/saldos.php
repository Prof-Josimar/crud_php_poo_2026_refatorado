<div class="card shadow">
    <div class="card-header bg-primary text-white"><h4 class="mb-0"><?= e($titulo) ?></h4></div>
    <div class="card-body">
        <table class="table table-striped table-hover align-middle">
            <thead class="table-dark"><tr><th>ID</th><th>Nome</th><th>Saldo Atual</th><th></th></tr></thead>
            <tbody>
            <?php foreach ($resumos as $r): ?>
                <tr>
                    <td><?= e($r['idPessoa']) ?></td>
                    <td><?= e($r['nome']) ?></td>
                    <td class="<?= $r['saldo'] < 0 ? 'text-danger' : '' ?>"><?= moeda($r['saldo']) ?></td>
                    <td><a href="/movimentacoes/extrato/<?= (int) $r['idPessoa'] ?>" class="btn btn-info btn-sm">Ver Extrato</a></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
