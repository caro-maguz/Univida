<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Detalle de Historia</title>
    <link rel="icon" type="image/png" href="<?php echo e(asset('img/Logo.png')); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Delius&display=swap');
        *{font-family:'Delius',cursive;}
        body{background:#f5f8fb;margin:0;padding:30px;}
        h1{color:#004aad;margin-bottom:10px;}
        .back{display:inline-flex;align-items:center;gap:8px;color:#004aad;text-decoration:none;font-weight:600;margin-bottom:14px;}
        .card{background:#fff;border-radius:18px;max-width:900px;margin:0 auto;box-shadow:0 4px 14px rgba(0,0,0,.08);overflow:hidden;}
        .card-header{background:#004aad;color:#fff;padding:14px 18px;}
        .card-body{padding:18px;}
        .badge{display:inline-block;padding:6px 12px;border-radius:12px;font-size:12px;font-weight:700;}
        .warn{background:#fff7cc;color:#8a6d00;}
        .ok{background:#dcfce7;color:#14532d;}
        .err{background:#ffe2e2;color:#7f1d1d;}
        .section{margin-bottom:16px;}
        .content-box{background:#f7fbff;border:1px solid #e3f2fd;border-radius:12px;padding:12px;white-space:pre-wrap;}
        .grid{display:grid;grid-template-columns:repeat(2,1fr);gap:12px;}
        .actions{display:flex;gap:10px;justify-content:flex-end;margin-top:8px;}
        button,a.button{background:#004aad;color:#fff;padding:10px 16px;border:none;border-radius:12px;font-weight:600;cursor:pointer;text-decoration:none;display:inline-flex;align-items:center;gap:8px;}
        .approve{background:#16a34a;}
        .reject{background:#d32f2f;}
        .edit{background:#f59e0b;}
        .delete{background:#ef4444;}
        .muted{color:#6b7280}
    </style>
</head>
<body>
    <a href="<?php echo e(route('psychologist.historias.index')); ?>" class="back"><i class="fas fa-arrow-left"></i> Volver</a>
    <h1>📖 Historia #<?php echo e($historia->id); ?></h1>

    <div class="card">
        <div class="card-header">Detalle</div>
        <div class="card-body">
            <div class="section">
                <strong>Estado: </strong>
                <?php if($historia->estado === 'pendiente'): ?>
                    <span class="badge warn">Pendiente de moderación</span>
                <?php elseif($historia->estado === 'aprobada'): ?>
                    <span class="badge ok">Aprobada</span>
                <?php else: ?>
                    <span class="badge err">Rechazada</span>
                <?php endif; ?>
            </div>

            <div class="section">
                <strong>Contenido:</strong>
                <div class="content-box"><?php echo e($historia->contenido); ?></div>
            </div>

            <div class="grid section">
                <div>
                    <div class="muted">Usuario</div>
                    <div>
                        <?php if($historia->usuario): ?>
                            <?php echo e($historia->usuario->nombre ?? 'Anónimo'); ?>

                        <?php else: ?>
                            <span class="muted">Sin usuario registrado</span>
                        <?php endif; ?>
                    </div>
                </div>
                <div>
                    <div class="muted">Fecha de envío</div>
                    <div><?php echo e($historia->created_at->format('d/m/Y H:i:s')); ?></div>
                </div>
            </div>

            <?php if($historia->moderador): ?>
                <div class="grid section">
                    <div>
                        <div class="muted">Moderador</div>
                        <div><?php echo e($historia->moderador->nombre); ?></div>
                    </div>
                    <div>
                        <div class="muted">Fecha de moderación</div>
                        <div><?php echo e($historia->fecha_moderacion ? \Carbon\Carbon::parse($historia->fecha_moderacion)->format('d/m/Y H:i:s') : '-'); ?></div>
                    </div>
                </div>
            <?php endif; ?>

            <?php if($historia->estado === 'rechazada' && $historia->motivo_rechazo): ?>
                <div class="section" style="background:#ffe2e2;color:#7f1d1d;border:1px solid #fecaca;padding:12px;border-radius:12px;">
                    <strong>Motivo del rechazo:</strong>
                    <div><?php echo e($historia->motivo_rechazo); ?></div>
                </div>
            <?php endif; ?>

            <hr style="border:none;border-top:1px solid #eee;margin:14px 0;">
            <div class="actions">
                <?php if($historia->estado === 'pendiente'): ?>
                    <form action="<?php echo e(route('psychologist.historias.aprobar', $historia->id)); ?>" method="POST" style="display:inline">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="approve"><i class="fas fa-check"></i> Aprobar</button>
                    </form>
                    <form id="rechazar-actual" action="<?php echo e(route('psychologist.historias.rechazar', $historia->id)); ?>" method="POST" style="display:inline">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="motivo_rechazo" value="" />
                        <button type="button" class="reject" onclick="rechazarActual()"><i class="fas fa-times"></i> Rechazar</button>
                    </form>
                <?php endif; ?>

                <a href="<?php echo e(route('psychologist.historias.edit', $historia->id)); ?>" class="edit"><i class="fas fa-edit"></i> Editar</a>
                <form action="<?php echo e(route('psychologist.historias.destroy', $historia->id)); ?>" method="POST" style="display:inline" onsubmit="return confirm('¿Estás seguro de eliminar esta historia?')">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                    <button type="submit" class="delete"><i class="fas fa-trash"></i> Eliminar</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function rechazarActual(){
            const preview = `<?php echo e(\Illuminate\Support\Str::limit(addslashes($historia->contenido), 80)); ?>`;
            const motivo = prompt('Motivo del rechazo para la historia:\n\n' + preview + '\n\nEscribe el motivo (mínimo 10 caracteres):');
            if(motivo === null){ return; }
            if(!motivo || motivo.trim().length < 10){
                alert('Debes escribir un motivo válido (mínimo 10 caracteres).');
                return;
            }
            const form = document.getElementById('rechazar-actual');
            form.querySelector('input[name="motivo_rechazo"]').value = motivo.trim();
            form.submit();
        }
    </script>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\univida\resources\views/psychologist/historias/show.blade.php ENDPATH**/ ?>