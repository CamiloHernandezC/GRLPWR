<div class="py-3 mb-3">
    <div>
    <h3>Últimas Clases:</h3>
    </div>
<div class="themed-block col-12 col-md-10 mx-auto mt-4 p-2">
    <div class="table-container">
        <table style="border-spacing: 10px;">
            <thead>
            <tr>
                <th>Fecha</th>

                <th>Evento</th>
            </tr>

            </thead>
            <tbody>
            @foreach($lastSessions as $session)
                <tr>
                    <td>{{ $session->fecha_inicio }}</td>
                    <td>{{ $session->event->nombre }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>

<style>
    .table-container {
        margin: 0 auto;
        width: 30%;
    }

    table {
        border-collapse: separate;
    }

    th, td {
        padding: 10px;
    }
</style>