<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Editar Serviço - Avaliação Titan</title>
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
    </style>
</head>
<body>
    <div class="card">
        <h1>Alterar Serviço</h1>

        <form action="/service/update" method="post">
            <input type="hidden" name="id" value="<?= htmlspecialchars($service['id']) ?>" />

            <div>
                <label for="description">Descrição</label>
                <textarea name="description" id="description" required><?= htmlspecialchars($service['description']) ?></textarea>
            </div>
            <div>
                <label for="value">Valor</label>
                <input type="text" name="value" id="value" value="<?= htmlspecialchars((string)$service['value']) ?>" required />
            </div>

            <div class="actions">
                <button class="btn" type="submit">Salvar Alterações</button>
                <a class="btn link" href="/">Cancelar</a>
            </div>
        </form>
    </div>
</body>
</html>
