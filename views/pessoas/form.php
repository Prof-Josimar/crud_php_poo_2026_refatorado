<?php use App\Utils\Formatter; ?>
<div class="card shadow">
    <div class="card-header bg-primary text-white"><h4 class="mb-0"><?= e($titulo) ?></h4></div>
    <div class="card-body">

        <?php if ($erros): ?>
            <div class="alert alert-danger">
                <ul class="mb-0"><?php foreach ($erros as $erro): ?><li><?= e($erro) ?></li><?php endforeach; ?></ul>
            </div>
        <?php endif; ?>

        <form action="<?= e($acao) ?>" method="post">
            <?= csrf_field() ?>

            <div class="mb-3">
                <label class="form-label" for="nome">Nome</label>
                <input type="text" id="nome" name="nome" class="form-control" maxlength="100" required autofocus
                       placeholder="Digite o nome" value="<?= e($pessoa['nome']) ?>">
            </div>
            <div class="mb-3">
                <label class="form-label" for="telefone">Telefone</label>
                <input type="text" id="telefone" name="telefone" class="form-control" maxlength="20"
                       placeholder="(21) 99999-9999" value="<?= e(Formatter::formatTelefone($pessoa['telefone'])) ?>">
            </div>
            <div class="mb-3">
                <label class="form-label" for="cpf">CPF</label>
                <input type="text" id="cpf" name="cpf" class="form-control" maxlength="14" required
                       placeholder="000.000.000-00" value="<?= e(Formatter::formatCpf($pessoa['cpf'])) ?>">
            </div>
            <div class="mb-3">
                <label class="form-label" for="endereco">Endereço</label>
                <textarea id="endereco" name="endereco" class="form-control" rows="3" maxlength="255"
                          placeholder="Rua, número, bairro"><?= e($pessoa['endereco']) ?></textarea>
            </div>

            <div class="d-flex gap-3">
                <button type="submit" class="btn btn-success">Salvar</button>
                <a href="/pessoas" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
