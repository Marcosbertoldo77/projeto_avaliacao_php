<?php

class ServiceController extends Controller
{
    private function ensureAuth(): ?array
    {
        if (empty($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }

        $userModel = new User();
        return $userModel->findById((int)$_SESSION['user_id']);
    }

    public function index(): void
    {
        $user = $this->ensureAuth();

        $filters = [];
        if (!empty($_GET['status'])) $filters['status'] = $_GET['status'];
        if (!empty($_GET['description'])) $filters['description'] = $_GET['description'];
        if (!empty($_GET['user_name'])) $filters['user_name'] = $_GET['user_name'];
        if (!empty($_GET['start']) && !empty($_GET['end'])) {
            $filters['start'] = $_GET['start'];
            $filters['end'] = $_GET['end'];
        }

        $serviceModel = new Service();
        $services = $serviceModel->all($filters);
        $total = $serviceModel->totalValueByUser((int)$user['id']);
        $pending = $serviceModel->latestPendingByUser((int)$user['id'], 5);

        $this->view('dashboard/index', [
            'user' => $user,
            'services' => $services,
            'total' => $total,
            'pending' => $pending,
            'filters' => $filters
        ]);
    }

    public function create(): void
    {
        $this->ensureAuth();
        $this->view('services/create');
    }

    public function edit(): void
    {
        $this->ensureAuth();
        $id = (int)($_GET['id'] ?? 0);
        if ($id <= 0) {
            $_SESSION['flash_error'] = 'ID inválido.';
            header('Location: /');
            exit;
        }

        $serviceModel = new Service();
        $service = $serviceModel->findById($id);
        if (!$service) {
            $_SESSION['flash_error'] = 'Serviço não encontrado.';
            header('Location: /');
            exit;
        }

        $this->view('services/edit', ['service' => $service]);
    }

    public function store(): void
    {
        $user = $this->ensureAuth();

        $description = trim($_POST['description'] ?? '');
        $value = $_POST['value'] ?? '';

        if ($description === '' || $value === '') {
            $_SESSION['flash_error'] = 'Descrição e valor são obrigatórios.';
            header('Location: /service/create');
            exit;
        }

        $value = (float)str_replace([',',' '], ['.',''], $value);

        $serviceModel = new Service();
        $serviceModel->create((int)$user['id'], $description, $value);

        $_SESSION['flash_success'] = 'Serviço cadastrado com sucesso.';
        header('Location: /');
        exit;
    }

    public function update(): void
    {
        $this->ensureAuth();

        $id = (int)($_POST['id'] ?? 0);
        $description = trim($_POST['description'] ?? '');
        $value = $_POST['value'] ?? '';

        if ($id <= 0 || $description === '' || $value === '') {
            $_SESSION['flash_error'] = 'Dados inválidos para atualização.';
            header('Location: /');
            exit;
        }

        $value = (float)str_replace([',',' '], ['.',''], $value);
        $serviceModel = new Service();
        $ok = $serviceModel->update($id, $description, $value);

        if ($ok) {
            $_SESSION['flash_success'] = 'Serviço atualizado com sucesso.';
        } else {
            $_SESSION['flash_error'] = 'Falha ao atualizar o serviço.';
        }

        header('Location: /');
        exit;
    }

    public function delete(): void
    {
        $this->ensureAuth();

        $id = (int)($_POST['id'] ?? 0);
        if ($id <= 0) {
            $_SESSION['flash_error'] = 'ID inválido.';
            header('Location: /');
            exit;
        }

        $serviceModel = new Service();
        $ok = $serviceModel->delete($id);

        if ($ok) {
            $_SESSION['flash_success'] = 'Serviço removido com sucesso.';
        } else {
            $_SESSION['flash_error'] = 'Falha ao remover o serviço.';
        }

        header('Location: /');
        exit;
    }

    public function finalize(): void
    {
        $user = $this->ensureAuth();

        $id = (int)($_POST['id'] ?? 0);
        if ($id <= 0) {
            $_SESSION['flash_error'] = 'ID inválido.';
            header('Location: /');
            exit;
        }

        $serviceModel = new Service();
        $service = $serviceModel->findById($id);

        if (!$service) {
            $_SESSION['flash_error'] = 'Serviço não encontrado.';
            header('Location: /');
            exit;
        }

        $value = (float)$service['value'];
        $commission = 0.0;

        if ($value <= 250.00) {
            $commission = $value * 0.05;
        } elseif ($value <= 1000.00) {
            $commission = $value * 0.07;
        } elseif ($value <= 10000.00) {
            $commission = $value * 0.10;
        } else {
            $commission = $value * 0.20;
        }

        $commission = round($commission, 2);

        $ok = $serviceModel->finalize($id, $commission);

        if ($ok) {
            $userModel = new User();
            $owner = $userModel->findById((int)$service['user_id']);

            if ($owner && !empty($owner['email'])) {
                $subject = 'Seu serviço foi finalizado';
                $message = "<p>Olá " . htmlspecialchars($owner['name']) . ",</p>";
                $message .= "<p>O serviço '" . htmlspecialchars($service['description']) . "' foi finalizado. Valor: R$ " . number_format($value,2,',','.') . ". Comissão: R$ " . number_format($commission,2,',','.') . "</p>";
                Mailer::send($owner['email'], $subject, $message);
            }

            $_SESSION['flash_success'] = 'Serviço finalizado com sucesso.';
        } else {
            $_SESSION['flash_error'] = 'Falha ao finalizar o serviço.';
        }

        header('Location: /');
        exit;
    }
}
