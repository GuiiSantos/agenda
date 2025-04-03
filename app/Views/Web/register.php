<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro - Agenda Eletrônica</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Estilo adicional -->
    <style>
        body {
            background-color: #f0f2f5;
        }

        .register-container {
            max-width: 450px;
            margin: 5% auto;
            background-color: white;
            padding: 2.5rem;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.05);
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

<div class="register-container">
    <div class="logo">Criar Conta</div>

    <form method="post" action="/createAccount">
        <div class="mb-3">
            <label for="login" class="form-label">Nome de Usuário</label>
            <input type="text" class="form-control" id="login" name="login" required>

            <?php if ($validation->getError('login')): ?>
                <div class="text-danger"><?= $validation->getError('login') ?></div>
            <?php endif; ?>

        </div>

        <div class="mb-3">
            <label for="senha" class="form-label">Senha</label>
            <input type="password" class="form-control" id="senha" name="senha" required minlength="4">

            <?php if ($validation->getError('senha')): ?>
                <div class="text-danger"><?= $validation->getError('senha') ?></div>
            <?php endif; ?>
        </div>

        <?php if (isset($erro)): ?>
            <div class="alert alert-danger"><?= $erro ?></div>
        <?php endif; ?>


        <button type="submit" class="btn btn-primary">Cadastrar</button>

        <div class="text-center mt-3">
            <span class="form-text text-muted">Já possui conta? <a href="/login">Entrar</a></span>
        </div>
    </form>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
