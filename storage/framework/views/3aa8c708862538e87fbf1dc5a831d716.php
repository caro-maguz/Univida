<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Gestión de Historias</title>
    <link rel="icon" type="image/png" href="<?php echo e(asset('img/Logo.png')); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Delius&display=swap');
        *{ font-family:'Delius', cursive; }
        body{ background:#f5f8fb; margin:0; padding:20px; }
        h1{ color:#004aad; margin-bottom:8px; }
        .subtitle{ color:#667; margin-bottom:16px; }
        .top-bar{ display:flex; justify-content:space-between; align-items:center; margin-bottom:16px; }
        a.button, button.button{ background:#004aad; color:#fff; padding:10px 18px; border-radius:14px; text-decoration:none; font-weight:600; border:none; cursor:pointer; display:inline-flex; align-items:center; gap:8px; }
        a.button:hover, button.button:hover{ background:#003b89; }
        .back{ color:#004aad; text-decoration:none; font-weight:600; }
        .flash{ background:#e6ffed; border:1px solid #b7f2c7; padding:10px 14px; border-radius:10px; margin-bottom:14px; color:#064e1b; font-size:14px; }
        .stats{ display:grid; grid-template-columns:repeat(3,1fr); gap:12px; margin:12px 0 18px; }
        .stat{ background:#fff; border-radius:14px; padding:14px; box-shadow:0 4px 12px rgba(0,0,0,.06); }
        .stat h4{ margin:0; color:#2c3e50; font-size:14px; }
        .stat p{ margin:6px 0 0; font-size:22px; font-weight:700; }
        table{ width:100%; border-collapse:collapse; background:#fff; border-radius:14px; overflow:hidden; box-shadow:0 4px 12px rgba(0,0,0,.08); }
        th,td{ padding:12px 14px; font-size:14px; }
        th{ background:#e9f2fb; text-align:left; color:#2c3e50; font-weight:600; }
        tbody tr:nth-child(even){ background:#f7fbff; }
        tbody tr:hover{ background:#eef6ff; }
        .badge{ display:inline-block; padding:4px 10px; border-radius:12px; font-size:11px; font-weight:700; }
        .badge.warn{ background:#fff7cc; color:#8a6d00; }
        .badge.ok{ background:#dcfce7; color:#14532d; }
        .badge.err{ background:#ffe2e2; color:#7f1d1d; }
        .actions{ display:flex; gap:8px; justify-content:flex-end; }
        .btn-small{ padding:6px 10px; border-radius:10px; font-size:12px; text-decoration:none; display:inline-flex; align-items:center; gap:6px; border:none; cursor:pointer; }
        .btn-view{ background:#0288d1; color:#fff; }
        .btn-approve{ background:#16a34a; color:#fff; }
        .btn-reject{ background:#d32f2f; color:#fff; }
        .btn-edit{ background:#f59e0b; color:#fff; }
        .btn-delete{ background:#ef4444; color:#fff; }
        .empty{ padding:40px; text-align:center; color:#667; }
    </style>
</head>
<body>
    <div class="top-bar">
        <div>
            <h1>Gestión de Historias</h1>
            <p class="subtitle">Modera las historias enviadas por los usuarios</p>
        </div>
        <a href="<?php echo e(route('administrador.dashboard')); ?>" class="back">← Volver al panel</a>
    </div>

    <?php if(session('success')): ?>
        <div class="flash"><i class="fas fa-check-circle"></i> <?php echo e(session('success')); ?></div>
    <?php endif; ?>

    <div class="stats">
        <div class="stat">
            <h4>⏳ Pendientes</h4>
            <p><?php echo e($historias->where('estado', 'pendiente')->count()); ?></p>
        </div>
        <div class="stat">
            <h4>✅ Aprobadas</h4>
            <p><?php echo e($historias->where('estado', 'aprobada')->count()); ?></p>
        </div>
        <div class="stat">
            <h4>❌ Rechazadas</h4>
            <p><?php echo e($historias->where('estado', 'rechazada')->count()); ?></p>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Contenido</th>
                <th>Estado</th>
                <th>Usuario</th>
                <th>Fecha envío</th>
                <th>Moderador</th>
                <th style="text-align:right">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $historias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $historia): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><strong>#<?php echo e($historia->id); ?></strong></td>
                    <td style="max-width:420px"><?php echo e(\Illuminate\Support\Str::limit($historia->contenido, 100)); ?></td>
                    <td>
                        <?php if($historia->estado === 'pendiente'): ?>
                            <span class="badge warn">Pendiente</span>
                        <?php elseif($historia->estado === 'aprobada'): ?>
                            <span class="badge ok">Aprobada</span>
                        <?php else: ?>
                            <span class="badge err">Rechazada</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if($historia->usuario): ?>
                            <small><?php echo e($historia->usuario->nombre ?? 'Anónimo'); ?></small>
                        <?php else: ?>
                            <small style="color:#999">Sin usuario</small>
                        <?php endif; ?>
                    </td>
                    <td><small><?php echo e($historia->created_at->format('d/m/Y H:i')); ?></small></td>
                    <td>
                        <?php if($historia->moderador): ?>
                            <small><?php echo e($historia->moderador->nombre); ?></small>
                        <?php else: ?>
                            <small style="color:#999">—</small>
                        <?php endif; ?>
                    </td>
                    <td>
                        <div class="actions">
                            <a class="btn-small btn-view" href="<?php echo e(route('administrador.historias.show', $historia->id)); ?>"><i class="fas fa-eye"></i> Ver</a>

                            <?php if($historia->estado === 'pendiente'): ?>
                                <form action="<?php echo e(route('administrador.historias.aprobar', $historia->id)); ?>" method="POST" style="display:inline">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="btn-small btn-approve"><i class="fas fa-check"></i> Aprobar</button>
                                </form>

                                <form id="rechazar-<?php echo e($historia->id); ?>" action="<?php echo e(route('administrador.historias.rechazar', $historia->id)); ?>" method="POST" style="display:inline">
                                    <?php echo csrf_field(); ?>
                                    <input type="hidden" name="motivo_rechazo" value="" />
                                    <button type="button" class="btn-small btn-reject" onclick="rechazarHistoria('<?php echo e($historia->id); ?>', '<?php echo e(\Illuminate\Support\Str::limit(addslashes($historia->contenido), 80)); ?>')">
                                        <i class="fas fa-times"></i> Rechazar
                                    </button>
                                </form>
                            <?php endif; ?>

                            <a class="btn-small btn-edit" href="<?php echo e(route('administrador.historias.edit', $historia->id)); ?>"><i class="fas fa-edit"></i> Editar</a>
                            <form action="<?php echo e(route('administrador.historias.destroy', $historia->id)); ?>" method="POST" style="display:inline" onsubmit="return confirm('¿Eliminar esta historia?')">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="btn-small btn-delete"><i class="fas fa-trash"></i> Eliminar</button>
                            </form>
                        </div>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="7" class="empty">
                        <i class="fas fa-inbox"></i> No hay historias registradas.
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <script>
        function rechazarHistoria(id, preview){
            const motivo = prompt('Motivo del rechazo para la historia:\n\n' + preview + '\n\nEscribe el motivo (mínimo 10 caracteres):');
            if(motivo === null){ return; }
            if(!motivo || motivo.trim().length < 10){
                alert('Debes escribir un motivo válido (mínimo 10 caracteres).');
                return;
            }
            const form = document.getElementById('rechazar-' + id);
            if(form){
                form.querySelector('input[name="motivo_rechazo"]').value = motivo.trim();
                form.submit();
            }
        }
    </script>
</body>
</html>

<?php /**PATH C:\xampp\htdocs\univida\resources\views/administrador/historias/index.blade.php ENDPATH**/ ?>