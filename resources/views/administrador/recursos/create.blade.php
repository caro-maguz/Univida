<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Crear Recurso</title>
  <link rel="icon" type="image/png" href="{{ asset('img/Logo.png') }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Delius&display=swap');
    *{font-family:'Delius',cursive;}
    body{background:#f5f8fb;margin:0;padding:30px;}
    h1{color:#004aad;margin-bottom:20px;}
    form{background:#fff;padding:26px;border-radius:18px;max-width:640px;margin:0 auto;box-shadow:0 4px 14px rgba(0,0,0,.08);}    .group{margin-bottom:18px;}
    label{display:block;font-weight:600;margin-bottom:6px;color:#2c3e50;}
    input[type=text],input[type=url],textarea,select{width:100%;padding:12px;border:1px solid #cfd8dc;border-radius:12px;font-size:14px;}
    textarea{min-height:120px;resize:vertical;}
    .actions{display:flex;gap:12px;margin-top:10px;}
    button,a.button{background:#004aad;color:#fff;padding:12px 20px;border:none;border-radius:14px;font-weight:600;cursor:pointer;text-decoration:none;display:inline-flex;align-items:center;gap:8px;}
    button:hover,a.button:hover{background:#003b89;}
    .back{background:#e3f2fd;color:#004aad;}
    .back:hover{background:#bbdefb;}
    .error{color:#c62828;font-size:13px;margin-top:4px;}
  </style>
</head>
<body>
  <h1>Nuevo Recurso</h1>
  <p><a href="{{ route('administrador.recursos.index') }}" class="button back"><i class="fas fa-arrow-left"></i> Volver</a></p>

  <form action="{{ route('administrador.recursos.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="group">
      <label for="titulo">Título *</label>
      <input type="text" id="titulo" name="titulo" value="{{ old('titulo') }}" required>
      @error('titulo')<div class="error">{{ $message }}</div>@enderror
    </div>
    <div class="group">
      <label for="descripcion">Descripción</label>
      <textarea id="descripcion" name="descripcion">{{ old('descripcion') }}</textarea>
      @error('descripcion')<div class="error">{{ $message }}</div>@enderror
    </div>
    <div class="group">
      <label for="fk_tipo_recurso">Tipo *</label>
      <select name="fk_tipo_recurso" id="fk_tipo_recurso" required>
        <option value="">Seleccione...</option>
        @foreach($tipos as $t)
          <option value="{{ $t->id_tipo_recurso }}" @selected(old('fk_tipo_recurso') == $t->id_tipo_recurso)>{{ $t->nombre }}</option>
        @endforeach
      </select>
      @error('fk_tipo_recurso')<div class="error">{{ $message }}</div>@enderror
    </div>
    <div class="group">
      <label for="enlace">Enlace externo (opcional)</label>
      <input type="url" id="enlace" name="enlace" placeholder="https://..." value="{{ old('enlace') }}">
      @error('enlace')<div class="error">{{ $message }}</div>@enderror
    </div>
    <div class="group">
      <label for="archivo">Archivo</label>
      <input type="file" id="archivo" name="archivo" accept=".pdf,.doc,.docx,.txt,.zip,.ppt,.pptx">
      @error('archivo')<div class="error">{{ $message }}</div>@enderror
    </div>
    <div class="actions">
      <button type="submit"><i class="fas fa-save"></i> Guardar</button>
    </div>
  </form>
</body>
</html>
