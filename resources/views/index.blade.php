<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Proyectos</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; background: #f4f4f4; }
        h1 { color: #333; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 10px; }
        th { background: #eee; }
        button { padding: 5px 10px; }
        input { padding: 5px; margin: 5px; }
    </style>
</head>
<body>

    <h1>Listado de Proyectos</h1>

    <div>
        <label>Título: <input type="text" id="titulo"></label>
        <label>Descripción: <input type="text" id="descripcion"></label>
        <button onclick="crearProyecto()">Crear Proyecto</button>
    </div>

    <table id="proyectos">
        <thead>
            <tr>
                <th>ID</th>
                <th>Título</th>
                <th>Descripción</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>

    <script>
        const token = localStorage.getItem('jwt');
        const apiUrl = 'http://127.0.0.1:8000/api/proyectos';

        async function cargarProyectos() {
            const res = await fetch(apiUrl, {
                headers: { 'Authorization': 'Bearer ' + token }
            });
            const data = await res.json();

            const tbody = document.querySelector('#proyectos tbody');
            tbody.innerHTML = '';

            data.forEach(p => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${p.id}</td>
                    <td>${p.titulo}</td>
                    <td>${p.descripcion || ''}</td>
                    <td><button onclick="eliminarProyecto(${p.id})">Eliminar</button></td>
                `;
                tbody.appendChild(row);
            });
        }

        async function crearProyecto() {
            const titulo = document.getElementById('titulo').value;
            const descripcion = document.getElementById('descripcion').value;

            const res = await fetch(apiUrl, {
                method: 'POST',
                headers: {
                    'Authorization': 'Bearer ' + token,
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ titulo, descripcion })
            });

            if (res.status === 201) {
                alert('Proyecto creado con éxito');
                cargarProyectos();
            } else {
                const error = await res.json();
                alert('Error: ' + JSON.stringify(error));
            }
        }

        async function eliminarProyecto(id) {
            const confirmacion = confirm('¿Eliminar este proyecto?');
            if (!confirmacion) return;

            const res = await fetch(`${apiUrl}/${id}`, {
                method: 'DELETE',
                headers: {
                    'Authorization': 'Bearer ' + token
                }
            });

            if (res.status === 204) {
                alert('Proyecto eliminado');
                cargarProyectos();
            } else {
                alert('Error al eliminar');
            }
        }

        cargarProyectos();
    </script>

</body>
</html>
