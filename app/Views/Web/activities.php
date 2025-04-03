<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Agenda de Atividades</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet"/>

    <style>
        body {
            background-color: #f1f5f9;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
    </style>


</head>
<body>
<?php $session = session(); ?>
<?= view('Partials/navbar', ["title" => "activities"]) ?>

<div class="container py-5">
    <h2 class="mb-4 text-center">Suas Atividades</h2>

    <div class="row">
        <div class="col-12 mb-5">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div id="openRegistrations" style="display: none !important;">
                <a href="javascript:void(0);"
                   class="btn btn-primary rounded-circle d-flex align-items-center justify-content-center"
                   style=" width: 40px; height: 40px; font-size: 1.5rem;" data-bs-toggle="modal"
                   data-bs-target="#createActivityModal">
                    +
                </a>
                </div>
                <div class="modal fade" id="createActivityModal" tabindex="-1" aria-labelledby="createActivityModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="createActivityModalLabel">Criar Atividade</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="createActivityForm" method="POST" action="/activities/create" enctype="multipart/form-data">
                                    <input type="hidden" name="user_id" value="<?= $session->get('user')['id']  ?>">
                                    <div class="mb-3">
                                        <label for="activityName" class="form-label">Nome da Atividade</label>
                                        <input type="text" class="form-control" id="activityName" name="name" required value="<?= old('name') ?>">
                                        <div id="nameError" class="text-danger"></div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="activityDescription" class="form-label">Descrição</label>
                                        <textarea class="form-control" id="activityDescription" name="description" required><?= old('description') ?></textarea>
                                        <div id="descriptionError" class="text-danger"></div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="startDateTime" class="form-label">Data e Hora de Início</label>
                                        <input type="datetime-local" class="form-control" id="startDateTime" name="start_datetime" required value="<?= old('start_datetime') ?>">
                                        <div id="startError" class="text-danger"></div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="endDateTime" class="form-label">Data e Hora de Término</label>
                                        <input type="datetime-local" class="form-control" id="endDateTime" name="end_datetime" required value="<?= old('end_datetime') ?>">
                                        <div id="endError" class="text-danger"></div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="status" class="form-label">Status</label>
                                        <select class="form-select" id="status" name="status" required>
                                            <option value="pending" <?= old('status') === 'pending' ? 'selected' : '' ?>>Pendente</option>
                                            <option value="completed" <?= old('status') === 'completed' ? 'selected' : '' ?>>Concluída</option>
                                            <option value="cancelled" <?= old('status') === 'cancelled' ? 'selected' : '' ?>>Cancelada</option>
                                        </select>
                                        <div id="statusError" class="text-danger"></div>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                                        <button type="submit" class="btn btn-primary">Salvar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="editActivityModal" tabindex="-1" aria-labelledby="editActivityModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editActivityModalLabel">Editar Atividade</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="editActivityForm">
                                    <!-- ID da Atividade (oculto) -->
                                    <input type="hidden" id="editActivityId" name="id">

                                    <!-- Nome da Atividade -->
                                    <div class="mb-3">
                                        <label for="editActivityName" class="form-label">Nome da Atividade</label>
                                        <input type="text" class="form-control" id="editActivityName" name="name" required>
                                    </div>

                                    <!-- Descrição -->
                                    <div class="mb-3">
                                        <label for="editActivityDescription" class="form-label">Descrição</label>
                                        <textarea class="form-control" id="editActivityDescription" name="description" required></textarea>
                                    </div>

                                    <!-- Data e Hora de Início -->
                                    <div class="mb-3">
                                        <label for="editStartTime" class="form-label">Data e Hora de Início</label>
                                        <input type="datetime-local" class="form-control" id="editStartTime" name="start_time" required>
                                    </div>

                                    <!-- Data e Hora de Término -->
                                    <div class="mb-3">
                                        <label for="editEndTime" class="form-label">Data e Hora de Término</label>
                                        <input type="datetime-local" class="form-control" id="editEndTime" name="end_time" required>
                                    </div>

                                    <!-- Status -->
                                    <div class="mb-3">
                                        <label for="editStatus" class="form-label">Status</label>
                                        <select class="form-select" id="editStatus" name="status" required>
                                            <option value="pending">Pendente</option>
                                            <option value="completed">Concluída</option>
                                            <option value="cancelled">Cancelada</option>
                                        </select>
                                    </div>

                                    <!-- Botões -->
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                                        <button type="button" id="saveActivityChanges" class="btn btn-primary">Salvar Alterações</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="table-responsive shadow rounded mb-3" id="activitiesTableContainer" style="display: none;">
                <table class="table table-bordered table-hover align-middle mb-0">
                    <thead class="table-dark">
                    <tr class="text-center">
                        <th>Nome</th>
                        <th>Status</th>
                        <th>Início</th>
                        <th>Término</th>
                        <th>Ações</th>
                    </tr>
                    </thead>
                    <tbody id="activitiesTableBody">
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-between" id="paginationContainer" style="display: none !important;">
                <button id="prevPage" class="btn btn-secondary">Anterior</button>
                <button id="nextPage" class="btn btn-secondary">Próximo</button>
            </div>

            <div id="noDataMessage" style="display: none;">
                <p class="text-center">Não há atividades registradas.</p>
                <button class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#createActivityModal">Adicionar Atividade</button>
            </div>

        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    let currentPage = 1;

    function loadActivities(page = 1) {
        $.ajax({
            url: '/activities/getActivities',
            method: 'GET',
            data: { page: page },
            success: function (response) {
                const activities = response.activities;
                const pager = response.pager;

                if (activities.length === 0) {

                    $('#activitiesTableContainer').hide();
                    $('#paginationContainer').hide();
                    $('#openRegistrations').hide();
                    $('#noDataMessage').show();
                } else {

                    let activitiesHTML = '';
                    activities.forEach(activity => {
                        activitiesHTML += `
                        <tr>
                            <td>${activity.name}</td>
                            <td><span class="badge bg-${activity.status === 'completed' ? 'success' : activity.status === 'pending' ? 'warning' : 'danger'}">${activity.status}</span></td>
                            <td>${activity.start_time}</td>
                            <td>${activity.end_time}</td>
                            <td class="text-center">
                                <button class="btn btn-sm btn-primary me-1 editActivityBtn" data-id="${activity.id}" data-name="${activity.name}" data-description="${activity.description}" data-start_time="${activity.start_time}" data-end_time="${activity.end_time}" data-status="${activity.status}" >Editar</button>
                                <button class="btn btn-sm btn-danger deleteActivityBtn" data-id="${activity.id}">Excluir</button>
                            </td>
                        </tr>
                    `;
                    });

                    $('#activitiesTableBody').html(activitiesHTML);


                    $('#activitiesTableContainer').show();
                    $('#paginationContainer').show();
                    $('#openRegistrations').show();
                    $('#noDataMessage').hide();
                }
                currentPage = page;
            },
            error: function () {
                alert('Erro ao carregar as atividades.');
            }
        });
    }
    loadActivities(currentPage);

    $('#prevPage').click(function () {
        if (currentPage > 1) {
            loadActivities(currentPage - 1);
        }
    });

    $('#nextPage').click(function () {
        loadActivities(currentPage + 1);
    });

</script>

<script>
    $(document).ready(function () {
        $(document).on('click', '.editActivityBtn', function () {
            const id = $(this).data('id');
            const name = $(this).data('name');
            const description = $(this).data('description');
            const start_time = $(this).data('start_time');
            const end_time = $(this).data('end_time');
            const status = $(this).data('status');

            $('#editActivityId').val(id);
            $('#editActivityName').val(name);
            $('#editActivityDescription').val(description);
            $('#editStartTime').val(start_time);
            $('#editEndTime').val(end_time);
            $('#editStatus').val(status);

            $('#editActivityModal').modal('show');
        });

        $('#saveActivityChanges').click(function () {
            const activityData = {
                id: $('#editActivityId').val(),
                name: $('#editActivityName').val(),
                description: $('#editActivityDescription').val(),
                start_time: $('#editStartTime').val(),
                end_time: $('#editEndTime').val(),
                status: $('#editStatus').val(),
            };

            $.ajax({
                url: '/activities/update',
                method: 'POST',
                data: activityData,
                success: function (response) {
                    if (response.success) {
                        alert('Atividade atualizada com sucesso!');
                        $('#editActivityModal').modal('hide');
                        loadActivities(currentPage);

                    } else {
                        alert('Erro ao atualizar atividade.');
                    }
                },
                error: function () {
                    alert('Erro ao fazer a requisição.');
                }
            });
        });
    });


</script>

<script>
    $(document).on('click', '.deleteActivityBtn', function () {
        const activityId = $(this).data('id');

        if (confirm('Tem certeza que deseja excluir esta atividade?')) {
            $.ajax({
                url: `/activities/delete/${activityId}`,
                method: 'DELETE',
                success: function (response) {
                    if (response.success) {
                        alert('Atividade excluída com sucesso!');
                        loadActivities(currentPage);
                    } else {
                        alert('Erro ao excluir a atividade.');
                    }
                },
                error: function () {
                    alert('Erro ao fazer a requisição.');
                }
            });
        }
    });

</script>

<script>
    $(document).ready(function () {

        $('#createActivityForm').on('submit', function (e) {
            e.preventDefault();

            $('#nameError').text('');
            $('#descriptionError').text('');
            $('#startError').text('');
            $('#endError').text('');
            $('#statusError').text('');

            var formData = new FormData(this);

            $.ajax({
                url: '/activities/create',
                type: 'POST',
                data: formData,
                dataType: 'json',
                contentType: false,
                processData: false,
                success: function (response) {
                    if (response.success) {
                        $('#createActivityModal').modal('hide');
                        $('#createActivityForm')[0].reset();
                        alert(response.message);
                        loadActivities();
                    } else if (response.errors) {
                        if (response.errors.name) {
                            $('#nameError').text(response.errors.name);
                        }
                        if (response.errors.description) {
                            $('#descriptionError').text(response.errors.description);
                        }
                        if (response.errors.start_datetime) {
                            $('#startError').text(response.errors.start_datetime);
                        }
                        if (response.errors.end_datetime) {
                            $('#endError').text(response.errors.end_datetime);
                        }
                        if (response.errors.status) {
                            $('#statusError').text(response.errors.status);
                        }
                    }
                },
                error: function () {
                    alert('Ocorreu um erro ao tentar salvar a atividade. Tente novamente mais tarde.');
                }
            });
        });
    });
</script>

</body>
</html>
