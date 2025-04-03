<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Calendário</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet"/>

    <style>
        body {
            background-color: #f1f5f9;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        #calendar {
            background: #ffffff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
            margin-bottom: 40px;
            min-height: 500px;
        }

        .fc-toolbar-title {
            font-size: 1.6rem;
            font-weight: 600;
            color: #1e293b;
        }

        .fc-button {
            background-color: #3b82f6;
            border: none;
            padding: 6px 12px;
            font-size: 0.9rem;
            border-radius: 8px;
            color: white;
            transition: all 0.2s ease-in-out;
        }

        .fc-button:hover {
            background-color: #2563eb;
        }

        .fc-button-primary:disabled {
            background-color: #94a3b8;
        }

        .fc-col-header-cell-cushion {
            color: #475569;
            font-weight: 500;
            padding: 12px 0;
        }

        .fc-daygrid-day-number {
            font-weight: 600;
            font-size: 0.85rem;
            color: #64748b;
            padding: 6px;
        }

        /* Estilo base dos eventos */
        .fc-event {
            font-size: 0.8rem;
            border-radius: 6px;
            padding: 3px 5px;
            border: none;
            color: white;
        }

        /* Cores por status */
        .fc-event.status-pendente {
            background-color: #facc15; /* Amarelo */
            color: #1e293b;
        }

        .fc-event.status-concluida {
            background-color: #22c55e; /* Verde */
        }

        .fc-event.status-cancelada {
            background-color: #ef4444; /* Vermelho */
        }

        /* Responsividade */
        @media (max-width: 768px) {
            #calendar {
                padding: 16px;
            }

            .fc-toolbar-title {
                font-size: 1.2rem;
            }
        }
        .calendar-box {
            background: #ffffff;
            border-radius: 12px;
            padding: 20px;
        }

        .fc-event.status-pendente {
            background-color: #facc15;
            color: #1e293b;
        }

        .fc-event.status-concluida {
            background-color: #22c55e;
            color: white;
        }

        .fc-event.status-cancelada {
            background-color: #ef4444;
            color: white;
        }

    </style>


</head>
<body>
<?php $session = session(); ?>
<?= view('Partials/navbar', ["title" => "calendar"]) ?>

<div class="container py-5">
    <h2 class="mb-4 text-center">Calendário</h2>

    <div class="row">
        <div class="col-12">
            <div class="calendar-box shadow rounded p-3 bg-white">
                <div id="calendar"></div>
            </div>
        </div>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const calendarEl = document.getElementById('calendar');

        const calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            locale: 'pt-br',
            height: 500,
            events: function (info, successCallback, failureCallback) {

                $.ajax({
                    url: '/activities/getCalendarActivities',
                    method: 'GET',
                    success: function (response) {
                        successCallback(response);
                    },
                    error: function () {
                        failureCallback('Erro ao carregar os eventos.');
                    }
                });
            }
        });

        calendar.render();
    });
</script>
</body>
</html>
