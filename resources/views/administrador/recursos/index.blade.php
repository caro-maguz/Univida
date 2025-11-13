<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Recursos - Admin</title>
  <link rel="icon" type="image/png" href="{{ asset('img/Logo.png') }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Delius&display=swap');
    *{font-family:'Delius',cursive;}
    body{background:#f5f8fb;margin:0;padding:20px;}
    h1{color:#004aad;margin-bottom:20px;}
    .top-bar{display:flex;justify-content:space-between;align-items:center;margin-bottom:16px;}
    a.button, button.button{background:#004aad;color:#fff;padding:10px 18px;border-radius:14px;text-decoration:none;font-weight:600;border:none;cursor:pointer;display:inline-flex;align-items:center;gap:8px;}
    a.button:hover, button.button:hover{background:#003b89;}
    table{width:100%;border-collapse:collapse;background:#fff;border-radius:14px;overflow:hidden;box-shadow:0 4px 12px rgba(0,0,0,.08);}    th,td{padding:12px 14px;font-size:14px;}
    th{background:#e9f2fb;text-align:left;color:#2c3e50;font-weight:600;}
    tbody tr:nth-child(even){background:#f7fbff;}
    tbody tr:hover{background:#eef6ff;}
    .actions{display:flex;gap:10px;}
    .tag{display:inline-block;padding:4px 10px;border-radius:12px;font-size:11px;font-weight:600;background:#e3f2fd;color:#004aad;}
    .empty{padding:40px;text-align:center;color:#667;}
    .flash{background:#e6ffed;border:1px solid #b7f2c7;padding:10px 14px;border-radius:10px;margin-bottom:14px;color:#064e1b;font-size:14px;}
    form.delete{display:inline;}
    form.delete button{background:#d32f2f;color:#fff;padding:6px 12px;border:none;border-radius:10px;font-size:12px;cursor:pointer;}
    form.delete button:hover{background:#b71c1c;}
    .edit-link{background:#0288d1;color:#fff;padding:6px 12px;border-radius:10px;font-size:12px;text-decoration:none;}
    .edit-link:hover{background:#026aa1;}
  </style>
</head>
<body>
  <h1>Gestión de Recursos</h1>
  <div class="top-bar">
    <div>
      <a href="{{ route('administrador.dashboard') }}" style="color:#004aad;text-decoration:none;font-weight:600;">← Volver al panel</a>
    </div>
    <a href="{{ route('administrador.recursos.create') }}" class="button"><i class="fas fa-plus"></i> Nuevo Recurso</a>
  </div>

  @if(session('success'))
    <div class="flash">{{ session('success') }}</div>
  @endif

  <table>
    <thead>
      <tr>
        <th>ID</th>
        <th>Título</th>
        <th>Tipo</th>
        <th>Descripción</th>
        <th>Enlace / Archivo</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      @forelse($recursos as $r)
        <tr>
          <td>{{ $r->id_recurso }}</td>
          <td>{{ $r->titulo }}</td>
          <td><span class="tag">{{ $r->tipoRecurso->nombre ?? '—' }}</span></td>
          <td style="max-width:260px">{{ \Illuminate\Support\Str::limit($r->descripcion, 90) }}</td>
          <td>
            @if($r->enlace)
              <a href="{{ $r->enlace }}" target="_blank" rel="noopener">Abrir</a>
            @else
              <span style="color:#999">Sin enlace</span>
            @endif
          </td>
          <td class="actions">
            <a class="edit-link" href="{{ route('administrador.recursos.edit', $r->id_recurso) }}">Editar</a>
            <form class="delete" action="{{ route('administrador.recursos.destroy', $r->id_recurso) }}" method="POST" onsubmit="return confirm('¿Eliminar este recurso?')">
              @csrf
              @method('DELETE')
              <button type="submit"><i class="fas fa-trash"></i></button>
            </form>
          </td>
        </tr>
      @empty
        <tr><td colspan="6" class="empty">No hay recursos cargados.</td></tr>
      @endforelse
    </tbody>
  </table>
</body>
</html>
