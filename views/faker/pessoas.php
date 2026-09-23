<div class="card shadow">
    <div class="card-header bg-primary text-white"><h4 class="mb-0">Gerar Pessoas com Faker</h4></div>
    <div class="card-body">
        <form action="/faker/pessoas" method="post">
            <?= csrf_field() ?>
            <div class="mb-3">
                <label class="form-label" for="quantidade">Quantidade de pessoas</label>
                <input type="number" id="quantidade" name="quantidade" class="form-control" min="1" max="1000" value="10" required autofocus>
                <div class="form-text">De 1 a 1000.</div>
            </div>
            <button type="submit" class="btn btn-success">Gerar Pessoas</button>
        </form>
    </div>
</div>
