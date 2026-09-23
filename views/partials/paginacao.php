<?php /** @var int $pagina @var int $totalPaginas */ ?>
<?php if ($totalPaginas > 1): ?>
<nav class="d-flex justify-content-center mt-3">
    <ul class="pagination">
        <?php if ($pagina > 1): ?>
            <li class="page-item"><a class="page-link" href="?pagina=<?= $pagina - 1 ?>">Anterior</a></li>
        <?php endif; ?>

        <?php for ($i = max(1, $pagina - 3); $i <= min($totalPaginas, $pagina + 3); $i++): ?>
            <li class="page-item <?= $i === $pagina ? 'active' : '' ?>">
                <a class="page-link" href="?pagina=<?= $i ?>"><?= $i ?></a>
            </li>
        <?php endfor; ?>

        <?php if ($pagina < $totalPaginas): ?>
            <li class="page-item"><a class="page-link" href="?pagina=<?= $pagina + 1 ?>">Próximo</a></li>
        <?php endif; ?>
    </ul>
</nav>
<?php endif; ?>
