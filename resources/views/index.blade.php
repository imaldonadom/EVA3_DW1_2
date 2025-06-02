<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Gestión de Proyectos</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    body { font-family: Arial; padding: 2rem; background: #f0f0f0; }
    h1 { color: #333; }
    table { border-collapse: collapse; width: 100%; margin-top: 1rem; }
    table, th, td { border: 1px solid #999; }
    th, td { padding: 0.5rem; text-align: left; }
    form input, form button { margin: 0.5rem 0; padding: 0.5rem; }
    .error { color: red; }
  </style>
</head>
<body>
  <h1>Gestión de Proyectos</h1>

  <form id="formulario">
    <input type="text" id="titulo" placeholder="Título" required><br>
    <textarea id="descripcion" placeholder="Descripción"></textarea><br>
    <button type="submit">Agregar Proyecto</button>
  </form>

  <h2>Lista de Proyectos</h2>
  <table>
    <thead>
      <tr>
        <th>ID</th>
        <th>Título</th>
        <th>Descripción</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody id="tabla-proyectos">
      <!-- Proyectos aparecerán aquí -->
    </tbody>
  </table>

  <script>
    const API = '/api/proyectos'; // Ajusta si no estás sirviendo desde mismo host
    const token = localStorage.getItem('jwt') || '';

    async function cargarProyectos() {
      const res = await fetch(API, {
        headers: { 'Authorization': 'Bearer ' + token }
      });
      const datos = await res.json();
      const tabla = document.getElementById('tabla-proyectos');
      tabla.innerHTML = '';
      datos.forEach(p => {
        const fila = `<tr>
          <td>${p.id}</td>
          <td>${p.titulo}</td>
          <td>${p.descripcion || ''}</td>
          <td><button onclick="eliminar(${p.id})">Eliminar</button></td>
        </tr>`;
        tabla.innerHTML += fila;
      });
    }

    async function eliminar(id) {
      await fetch(`${API}/${id}`, {
        method: 'DELETE',
        headers: { 'Authorization': 'Bearer ' + token }
      });
      cargarProyectos();
    }

    document.getElementById('formulario').addEventListener('submit', async e => {
      e.preventDefault();
      const titulo = document.getElementById('titulo').value;
      const descripcion = document.getElementById('descripcion').value;
      await fetch(API, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Authorization': 'Bearer ' + token
        },
        body: JSON.stringify({ titulo, descripcion })
      });
      e.target.reset();
      cargarProyectos();
    });

    cargarProyectos();
  </script>
</body>
</html>
