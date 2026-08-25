<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Login - Avaliação Titan</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #f5f7fb, #eaf0ff);
            color: #1f2937;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }
        .card {
            width: min(420px, 90vw);
            background: #fff;
            border-radius: 18px;
            box-shadow: 0 18px 38px rgba(15, 23, 42, 0.12);
            padding: 32px 28px;
        }
        h1 {
            margin-top: 0;
            text-align: center;
            color: #0f172a;
        }
        label {
            display: block;
            margin-bottom: 6px;
            font-weight: 600;
        }
        input {
            width: 100%;
            box-sizing: border-box;
            padding: 12px 14px;
            border: 1px solid #d1d5db;
            border-radius: 10px;
            margin-bottom: 16px;
            font-size: 16px;
        }
        button {
            width: 100%;
            background: #2563eb;
            color: #fff;
            border: none;
            border-radius: 10px;
            padding: 12px;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
        }
        .error {
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
        <h1>Login</h1>

        <?php if (!empty($error)): ?>
            <div class="error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form action="/login" method="post">
            <div>
                <label for="email">Email</label>
                <input type="email" name="email" id="email" required placeholder="Digite seu email" />
            </div>
            <div>
                <label for="password">Senha</label>
                <input type="password" name="password" id="password" required placeholder="Digite sua senha" />
            </div>
            <div>
                <button type="submit">Entrar</button>
            </div>
        </form>
    </div>
</body>
</html>
