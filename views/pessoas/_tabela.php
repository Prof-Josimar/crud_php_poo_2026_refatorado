<?php use App\Utils\Formatter; ?>
<table class="table table-striped table-hover align-middle">
    <thead class="table-dark">
        <tr><th>ID</th><th>Nome</th><th>Telefone</th><th>CPF</th><th>Endereço</th><th>Ações</th></tr>
    </thead>
    <tbody>
    <?php foreach ($pessoas as $p): ?>
        <tr>
            <td><?= e($p['id']) ?></td>
            <td><?= e($p['nome']) ?></td>
            <td><?= e(Formatter::formatTelefone($p['telefone'])) ?></td>
            <td><?= e(Formatter::formatCpf($p['cpf'])) ?></td>
            <td><?= e($p['endereco']) ?></td>
            <td>
                <div class="d-flex gap-2">
                    <a href="/pessoas/<?= (int) $p['id'] ?>" class="btn btn-info btn-sm">Detalhes</a>
                    <a href="/pessoas/<?= (int) $p['id'] ?>/editar" class="btn btn-warning btn-sm">Editar</a>
                    <form action="/pessoas/<?= (int) $p['id'] ?>/excluir" method="post"
                          onsubmit="return confirm('Tem certeza que deseja excluir esta pessoa?');">
                        <?= csrf_field() ?>
                        <button type="submit" class="btn btn-danger btn-sm">Excluir</button>
                    </form>
                </div>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
