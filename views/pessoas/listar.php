<div class="card shadow">
    <div class="card-header bg-primary text-white">
        <h4 class="mb-0">Lista de Pessoas <small>(<?= (int) $total ?>)</small></h4>
    </div>
    <div class="card-body">
        <?php if ($pessoas): ?>
            <?php App\Core\View::partial('pessoas/_tabela', compact('pessoas')) ?>
            <?php App\Core\View::partial('partials/paginacao', compact('pagina', 'totalPaginas')) ?>
        <?php else: ?>
            <div class="alert alert-warning mb-0">Nenhuma pessoa cadastrada.</div>
        <?php endif; ?>
    </div>
</div>
