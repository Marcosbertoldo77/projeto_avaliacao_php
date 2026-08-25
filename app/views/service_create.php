<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Cadastrar Serviço - Avaliação Titan</title>
</head>
<body>
    <h1>Cadastrar Novo Serviço</h1>

    <?php if (!empty($_SESSION['flash_error'])): ?>
        <p style="color: red"><?= htmlspecialchars($_SESSION['flash_error']) ?></p>
        <?php unset($_SESSION['flash_error']); ?>
    <?php endif; ?>

    <form action="/service/store" method="post">
        <div>
            <label for="description">Descrição</label><br/>
            <textarea name="description" id="description" rows="4" cols="50" required></textarea>
        </div>
        <div>
            <label for="value">Valor (use ponto ou vírgula)</label><br/>
            <input type="text" name="value" id="value" required />
        </div>
        <div>
            <button type="submit">Salvar</button>
            <a href="/">Cancelar</a>
        </div>
    </form>
</body>
</html>