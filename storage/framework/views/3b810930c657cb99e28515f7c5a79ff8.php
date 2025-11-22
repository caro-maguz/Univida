<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Editar Historia</title>
    <link rel="icon" type="image/png" href="<?php echo e(asset('img/Logo.png')); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Delius&display=swap');
        *{font-family:'Delius',cursive;}
        body{background:#f5f8fb;margin:0;padding:30px;}
        h1{color:#004aad;margin-bottom:8px;}
        .back{display:inline-flex;align-items:center;gap:8px;color:#004aad;text-decoration:none;font-weight:600;margin-bottom:14px;}
        form{background:#fff;padding:26px;border-radius:18px;max-width:800px;margin:0 auto;box-shadow:0 4px 14px rgba(0,0,0,.08);}    .group{margin-bottom:18px;}
        label{display:block;font-weight:600;margin-bottom:6px;color:#2c3e50;}
        textarea{width:100%;min-height:240px;padding:12px;border:1px solid #cfd8dc;border-radius:12px;font-size:14px;resize:vertical;}
        .hint{font-size:13px;color:#667;margin-top:6px;}
        .note{background:#e3f2fd;color:#0f172a;border:1px solid #bbdefb;padding:12px;border-radius:12px;margin:10px 0;}
        .row{display:flex;gap:16px;flex-wrap:wrap;margin-top:14px;}
        .box{flex:1;background:#fff;border-radius:14px;padding:14px;box-shadow:0 4px 12px rgba(0,0,0,.06);}    .badge{display:inline-block;padding:4px 10px;border-radius:12px;font-size:11px;font-weight:700;}
        .warn{background:#fff7cc;color:#8a6d00;}
        .ok{background:#dcfce7;color:#14532d;}
        .err{background:#ffe2e2;color:#7f1d1d;}
        .actions{display:flex;gap:12px;justify-content:flex-end;margin-top:12px;}
        button,a.button{background:#004aad;color:#fff;padding:12px 20px;border:none;border-radius:14px;font-weight:600;cursor:pointer;text-decoration:none;display:inline-flex;align-items:center;gap:8px;}
        .cancel{background:#e3f2fd;color:#004aad;}
        .cancel:hover{background:#bbdefb;}
        button:hover,a.button:hover{background:#003b89;}
    </style>
</head>
<body>
    <a href="<?php echo e(route('psychologist.historias.index')); ?>" class="back"><i class="fas fa-arrow-left"></i> Volver</a>
    <h1>Editar Historia #<?php echo e($historia->id); ?></h1>

    <form action="<?php echo e(route('psychologist.historias.update', $historia->id)); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>

        <div class="group">
            <label for="contenido">Contenido de la historia *</label>
            <textarea id="contenido" name="contenido" required><?php echo e(old('contenido', $historia->contenido)); ?></textarea>
            <?php $__errorArgs = ['contenido'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="hint" style="color:#c62828"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            <div class="hint">Mínimo 10 caracteres</div>
        </div>

        <div class="note">
            <i class="fas fa-info-circle"></i>
            Al editar una historia, solo se modifica el contenido. El estado de moderación permanece igual.
        </div>

        <div class="actions">
            <a href="<?php echo e(route('psychologist.historias.index')); ?>" class="button cancel"><i class="fas fa-times"></i> Cancelar</a>
            <button type="submit"><i class="fas fa-save"></i> Guardar cambios</button>
        </div>
    </form>

    <div class="row">
        <div class="box">
            <h4 style="margin:0 0 8px;color:#2c3e50">Información de la historia</h4>
            <p style="margin:6px 0"><strong>Estado:</strong>
                <?php if($historia->estado === 'pendiente'): ?>
                    <span class="badge warn">Pendiente</span>
                <?php elseif($historia->estado === 'aprobada'): ?>
                    <span class="badge ok">Aprobada</span>
                <?php else: ?>
                    <span class="badge err">Rechazada</span>
                <?php endif; ?>
            </p>
            <p style="margin:6px 0"><strong>Fecha de envío:</strong> <?php echo e($historia->created_at->format('d/m/Y H:i')); ?></p>
            <?php if($historia->usuario): ?>
                <p style="margin:6px 0"><strong>Usuario:</strong> <?php echo e($historia->usuario->nombre ?? 'Anónimo'); ?></p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\univida\resources\views/psychologist/historias/edit.blade.php ENDPATH**/ ?>