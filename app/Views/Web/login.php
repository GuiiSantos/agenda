<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Login - Agenda</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
        }

        .login-container {
            max-width: 400px;
            margin: 5% auto;
            background-color: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }

        .form-control:focus {
            border-color: #0d6efd;
            box-shadow: none;
        }

        .btn-primary {
            width: 100%;
        }

        .logo {
            text-align: center;
            font-size: 1.8rem;
            font-weight: bold;
            margin-bottom: 1rem;
            color: #0d6efd;
        }

        .form-text {
            font-size: 0.9rem;
        }
    </style>
</head>
<body>

<div class="login-container">
    <?php if (session()->getFlashdata('success')): ?>
        <div id="successAlert" class="alert alert-success">
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('erro')): ?>
        <div class="alert alert-danger">
            <?= session()->getFlashdata('erro') ?>
        </div>
    <?php endif; ?>

    <div class="logo">Agenda</div>

    <form method="post" action="/authenticate">
        <div class="mb-3">
            <label for="login" class="form-label">Usuário</label>
            <input type="text" class="form-control" id="login" name="login" value="<?= old('login') ?>" required>
            <!-- Exibe erro de validação se houver -->
            <?php if (isset($validation) && $validation->getError('login')): ?>
                <div class="text-danger"><?= $validation->getError('login') ?></div>
            <?php endif; ?>
        </div>

        <div class="mb-3">
            <label for="senha" class="form-label">Senha</label>
            <input type="password" class="form-control" id="senha" name="senha" required>
            <!-- Exibe erro de validação se houver -->
            <?php if (isset($validation) && $validation->getError('senha')): ?>
                <div class="text-danger"><?= $validation->getError('senha') ?></div>
            <?php endif; ?>
        </div>

        <button type="submit" class="btn btn-primary">Entrar</button>

        <div class="text-center mt-3">
            <span class="form-text text-muted">Ainda não tem conta? <a href="/register">Cadastre-se</a></span>
        </div>
    </form>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const successAlert = document.getElementById('successAlert');

        if (successAlert) {
            setTimeout(function () {
                successAlert.style.display = 'none';
            }, 2000);
        }
    });
</script>
</body>
</html>
