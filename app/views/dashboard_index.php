<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Avaliação Titan</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f3f6fb;
            color: #1f2937;
        }
        .container {
            max-width: 1200px;
            margin: 32px auto;
            padding: 0 20px 40px;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
            margin-bottom: 20px;
        }
        h1 {
            margin: 0;
            color: #0f172a;
        }
        .nav {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .btn {
            display: inline-block;
            background: #2563eb;
            color: white;
            text-decoration: none;
            padding: 10px 16px;
            border-radius: 8px;
            font-weight: 600;
            border: none;
            cursor: pointer;
        }
        .btn.secondary {
            background: #e5e7eb;
            color: #111827;
        }
        .summary {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 18px;
            margin-bottom: 24px;
        }
        .card {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 10px 24px rgba(15, 23, 42, 0.08);
            padding: 18px 20px;
        }
        .value {
            font-size: 1.8rem;
            font-weight: 700;
            margin-top: 8px;
            color: #0f172a;
        }
        .filters {
            background: #fff;
            border-radius: 12px;
            padding: 18px;
            box-shadow: 0 10px 24px rgba(15, 23, 42, 0.05);
            margin-bottom: 18px;
        }
        .filters form {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 12px;
            align-items: end;
        }
        label {
            display: block;
            font-weight: 600;
            margin-bottom: 6px;
        }
        input, select {
            width: 100%;
            box-sizing: border-box;
            padding: 10px 12px;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            font-size: 14px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 10px 24px rgba(15, 23, 42, 0.05);
        }
        th, td {
            border-bottom: 1px solid #e5e7eb;
            padding: 12px 10px;
            text-align: left;
            vertical-align: top;
        }
        th {
            background: #eef2ff;
        }
        .alert-success {
            background: #dcfce7;
            color: #166534;
            border: 1px solid #86efac;
            padding: 12px 14px;
            border-radius: 8px;
            margin-bottom: 16px;
        }
        .alert-error {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fca5a5;
            padding: 12px 14px;
            border-radius: 8px;
            margin-bottom: 16px;
        }
        .action-group {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            align-items: center;
        }
        .action-group form {
            margin: 0;
        }
        .mini-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .mini-list li {
            padding: 8px 0;
            border-bottom: 1px solid #e5e7eb;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Dashboard</h1>
            <div class="nav">
                <a class="btn" href="/service/create">Adicionar Novo Serviço</a>
                <a class="btn secondary" href="/logout">Sair</a>
            </div>
        </div>

        <div class="card">
            <p><strong>Usuário:</strong> <?= htmlspecialchars($user['name']) ?> (<?= htmlspecialchars($user['email']) ?>)</p>
            <p><strong>Data:</strong> <?= date('d/m/Y') ?></p>
        </div>

        <?php if (!empty($_SESSION['flash_success'])): ?>
            <div class="alert-success"><?= htmlspecialchars($_SESSION['flash_success']) ?></div>
            <?php unset($_SESSION['flash_success']); ?>
        <?php endif; ?>
        <?php if (!empty($_SESSION['flash_error'])): ?>
            <div class="alert-error"><?= htmlspecialchars($_SESSION['flash_error']) ?></div>
            <?php unset($_SESSION['flash_error']); ?>
        <?php endif; ?>

        <div class="summary">
            <div class="card">
                <div>Valor total dos serviços</div>
                <div class="value">R$ <?= number_format($total,2,',','.') ?></div>
            </div>
            <div class="card">
                <div>Serviços pendentes</div>
                <div class="value"><?= count($pending) ?></div>
            </div>
        </div>

        <div class="card" style="margin-bottom: 18px;">
            <h3>Últimos serviços pendentes</h3>
            <?php if (!empty($pending)): ?>
                <ul class="mini-list">
                    <?php foreach ($pending as $p): ?>
                        <li><?= htmlspecialchars($p['description']) ?> - R$ <?= number_format($p['value'],2,',','.') ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>Nenhum serviço pendente.</p>
            <?php endif; ?>
        </div>

        <div class="filters">
            <h3>Filtros</h3>
            <form method="get" action="/">
                <div>
                    <label>Descrição</label>
                    <input type="text" name="description" value="<?= htmlspecialchars($filters['description'] ?? '') ?>"/>
                </div>
                <div>
                    <label>Usuário</label>
                    <input type="text" name="user_name" value="<?= htmlspecialchars($filters['user_name'] ?? '') ?>"/>
                </div>
                <div>
                    <label>Status</label>
                    <select name="status">
                        <option value="">Todos</option>
                        <option value="Pendente" <?= (isset($filters['status']) && $filters['status']==='Pendente') ? 'selected' : '' ?>>Pendente</option>
                        <option value="Finalizado" <?= (isset($filters['status']) && $filters['status']==='Finalizado') ? 'selected' : '' ?>>Finalizado</option>
                    </select>
                </div>
                <div>
                    <label>Período início</label>
                    <input type="date" name="start" value="<?= htmlspecialchars($filters['start'] ?? '') ?>"/>
                </div>
                <div>
                    <label>Período fim</label>
                    <input type="date" name="end" value="<?= htmlspecialchars($filters['end'] ?? '') ?>"/>
                </div>
                <div>
                    <button class="btn" type="submit">Filtrar</button>
                </div>
            </form>
        </div>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Descrição</th>
                    <th>Status</th>
                    <th>Valor</th>
                    <th>Usuário</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($services as $s): ?>
                    <tr>
                        <td><?= htmlspecialchars($s['id']) ?></td>
                        <td><?= htmlspecialchars($s['description']) ?></td>
                        <td><?= htmlspecialchars($s['status']) ?></td>
                        <td>R$ <?= number_format($s['value'],2,',','.') ?></td>
                        <td><?= htmlspecialchars($s['user_name'] ?? '') ?></td>
                        <td>
                            <div class="action-group">
                                <form action="/service/edit" method="get">
                                    <input type="hidden" name="id" value="<?= htmlspecialchars($s['id']) ?>" />
                                    <button class="btn secondary" type="submit">Alterar</button>
                                </form>

                                <form action="/service/delete" method="post">
                                    <input type="hidden" name="id" value="<?= htmlspecialchars($s['id']) ?>" />
                                    <button class="btn secondary" type="submit">Excluir</button>
                                </form>

                                <?php if ($s['status'] === 'Pendente'): ?>
                                    <form action="/service/finalize" method="post">
                                        <input type="hidden" name="id" value="<?= htmlspecialchars($s['id']) ?>" />
                                        <button class="btn" type="submit">Finalizar</button>
                                    </form>
                                <?php else: ?>
                                    <span>Finalizado em <?= htmlspecialchars($s['finished_at'] ?? '') ?><br/>Comissão: R$ <?= number_format((float)$s['commission'],2,',','.') ?></span>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
