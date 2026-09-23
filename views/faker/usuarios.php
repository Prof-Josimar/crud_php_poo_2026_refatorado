<div class="card shadow">
    <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
        <h4 class="mb-0">Usuários Faker (<?= count($usuarios) ?>)</h4>
        <form action="/faker/usuarios" method="post" class="m-0">
            <?= csrf_field() ?>
            <button type="submit" class="btn btn-light btn-sm">Gerar mais 10</button>
        </form>
    </div>
    <div class="card-body table-responsive">
        <table class="table table-striped table-hover table-sm">
            <thead class="table-dark">
                <tr><th>ID</th><th>Nome</th><th>Sobrenome</th><th>Email</th><th>Telefone</th><th>Endereço</th><th>Cidade</th>
                    <th>CEP</th><th>Empresa</th><th>Cargo</th><th>Nasc.</th><th>Cartão</th><th>IBAN</th><th>UUID</th></tr>
            </thead>
            <tbody>
            <?php foreach ($usuarios as $u): ?>
                <tr>
                    <?php foreach (['id','nome','sobrenome','email','telefone','endereco','cidade','cep','empresa','cargo','data_nascimento','numero_cartao','iban','uuid'] as $campo): ?>
                        <td><?= e($u[$campo]) ?></td>
                    <?php endforeach; ?>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
