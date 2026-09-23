<?php use App\Utils\Formatter; ?>
<div class="card shadow">
    <div class="card-header bg-info text-white"><h4 class="mb-0">Detalhes da Pessoa</h4></div>
    <div class="card-body">
        <ul class="list-group">
            <li class="list-group-item"><strong>ID:</strong> <?= e($pessoa['id']) ?></li>
            <li class="list-group-item"><strong>Nome:</strong> <?= e($pessoa['nome']) ?></li>
            <li class="list-group-item"><strong>Telefone:</strong> <?= e(Formatter::formatTelefone($pessoa['telefone'])) ?></li>
            <li class="list-group-item"><strong>CPF:</strong> <?= e(Formatter::formatCpf($pessoa['cpf'])) ?></li>
            <li class="list-group-item"><strong>Endereço:</strong> <?= e($pessoa['endereco']) ?></li>
            <li class="list-group-item"><strong>Cadastrada em:</strong> <?= e($pessoa['createdAt']) ?></li>
            <li class="list-group-item"><strong>Atualizada em:</strong> <?= e($pessoa['updatedAt']) ?></li>
        </ul>
        <div class="mt-3 d-flex gap-2">
            <a href="/pessoas/<?= (int) $pessoa['id'] ?>/editar" class="btn btn-warning">Editar</a>
            <a href="/movimentacoes/extrato/<?= (int) $pessoa['id'] ?>" class="btn btn-primary">Extrato</a>
            <a href="/pessoas" class="btn btn-secondary">Voltar</a>
        </div>
    </div>
</div>
