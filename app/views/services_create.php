<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Cadastrar Serviço - Avaliação Titan</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f3f6fb;
            color: #1f2937;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .card {
            width: min(620px, 90vw);
            background: #fff;
            border-radius: 14px;
            box-shadow: 0 18px 32px rgba(15, 23, 42, 0.1);
            padding: 28px;
        }
        h1 {
            margin-top: 0;
        }
        label {
            display: block;
            margin-bottom: 6px;
            font-weight: 700;
        }
        textarea, input {
            width: 100%;
            box-sizing: border-box;
            padding: 10px 12px;
            margin-bottom: 18px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 16px;
        }
        textarea {
            min-height: 110px;
        }
        .actions {
            display: flex;
            gap: 12px;
            align-items: center;
        }
        .btn {
            background: #2563eb;
            color: white;
            padding: 11px 16px;
            border: none;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 700;
            cursor: pointer;
        }
        .btn.link {
            background: #e5e7eb;
            color: #111827;
        }
        .alert-error {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fca5a5;
            padding: 10px 12px;
            border-radius: 8px;
            margin-bottom: 16px;
        }
    </style>
</head>
<body>
    <div class="card">
        <h1>Cadastrar Novo Serviço</h1>

        <?php if (!empty($_SESSION['flash_error'])): ?>
            <div class="alert-error"><?= htmlspecialchars($_SESSION['flash_error']) ?></div>
            <?php unset($_SESSION['flash_error']); ?>
        <?php endif; ?>

        <form action="/service/store" method="post">
            <div>
                <label for="description">Descrição</label>
                <textarea name="description" id="description" required></textarea>
            </div>
            <div>
                <label for="value">Valor (use ponto ou vírgula)</label>
                <input type="text" name="value" id="value" required />
            </div>
            <div class="actions">
                <button class="btn" type="submit">Salvar</button>
                <a class="btn link" href="/">Cancelar</a>
            </div>
        </form>
    </div>
</body>
</html>
