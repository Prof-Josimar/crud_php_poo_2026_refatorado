<div class="card shadow border-danger mx-auto" style="max-width:420px;">
    <div class="card-body text-center">
        <h4 class="text-danger mb-3">⚠ Atenção!</h4>
        <p>Isto apaga <strong>todas as pessoas e todas as movimentações</strong>.<br>
           Para confirmar, resolva o desafio:</p>
        <form method="post" action="/pessoas/excluir-todas">
            <?= csrf_field() ?>
            <label class="form-label fs-5"><?= e($desafio) ?> =</label>
            <input type="number" name="resposta" class="form-control mb-3" required autofocus>
            <button type="submit" class="btn btn-danger w-100">Excluir Tudo</button>
            <a href="/pessoas" class="btn btn-link mt-2">Cancelar</a>
        </form>
    </div>
</div>
