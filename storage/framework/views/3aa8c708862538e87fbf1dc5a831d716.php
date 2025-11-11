

<?php $__env->startSection('title', 'Gestión de Historias'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="mb-1">📖 Gestión de Historias</h2>
                    <p class="text-muted">Moderar historias enviadas por los usuarios</p>
                </div>
                <a href="<?php echo e(route('administrador.dashboard')); ?>" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left"></i> Regresar
                </a>
            </div>

            <?php if(session('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle"></i> <?php echo e(session('success')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <!-- Estadísticas rápidas -->
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="card bg-warning text-dark">
                        <div class="card-body">
                            <h5 class="card-title">⏳ Pendientes</h5>
                            <h2 class="mb-0"><?php echo e($historias->where('estado', 'pendiente')->count()); ?></h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-success text-white">
                        <div class="card-body">
                            <h5 class="card-title">✅ Aprobadas</h5>
                            <h2 class="mb-0"><?php echo e($historias->where('estado', 'aprobada')->count()); ?></h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-danger text-white">
                        <div class="card-body">
                            <h5 class="card-title">❌ Rechazadas</h5>
                            <h2 class="mb-0"><?php echo e($historias->where('estado', 'rechazada')->count()); ?></h2>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabla de historias -->
            <div class="card shadow">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Contenido</th>
                                    <th>Estado</th>
                                    <th>Usuario</th>
                                    <th>Fecha Envío</th>
                                    <th>Moderador</th>
                                    <th class="text-end">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $historias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $historia): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td><strong>#<?php echo e($historia->id); ?></strong></td>
                                        <td>
                                            <div style="max-width: 400px;">
                                                <?php echo e(Str::limit($historia->contenido, 100)); ?>

                                            </div>
                                        </td>
                                        <td>
                                            <?php if($historia->estado === 'pendiente'): ?>
                                                <span class="badge bg-warning text-dark">
                                                    <i class="fas fa-clock"></i> Pendiente
                                                </span>
                                            <?php elseif($historia->estado === 'aprobada'): ?>
                                                <span class="badge bg-success">
                                                    <i class="fas fa-check"></i> Aprobada
                                                </span>
                                            <?php else: ?>
                                                <span class="badge bg-danger">
                                                    <i class="fas fa-times"></i> Rechazada
                                                </span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if($historia->usuario): ?>
                                                <small><?php echo e($historia->usuario->nombre ?? 'Anónimo'); ?></small>
                                            <?php else: ?>
                                                <small class="text-muted">Sin usuario</small>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <small><?php echo e($historia->created_at->format('d/m/Y H:i')); ?></small>
                                        </td>
                                        <td>
                                            <?php if($historia->moderador): ?>
                                                <small><?php echo e($historia->moderador->nombre); ?></small>
                                            <?php else: ?>
                                                <small class="text-muted">-</small>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-end">
                                            <div class="btn-group btn-group-sm">
                                                <a href="<?php echo e(route('administrador.historias.show', $historia->id)); ?>" 
                                                   class="btn btn-info" title="Ver detalle">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                
                                                <?php if($historia->estado === 'pendiente'): ?>
                                                    <form action="<?php echo e(route('administrador.historias.aprobar', $historia->id)); ?>" 
                                                          method="POST" class="d-inline">
                                                        <?php echo csrf_field(); ?>
                                                        <button type="submit" class="btn btn-success" title="Aprobar">
                                                            <i class="fas fa-check"></i>
                                                        </button>
                                                    </form>
                                                    <button type="button" class="btn btn-danger" 
                                                            data-bs-toggle="modal" 
                                                            data-bs-target="#rechazarModal<?php echo e($historia->id); ?>"
                                                            title="Rechazar">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                <?php endif; ?>

                                                <a href="<?php echo e(route('administrador.historias.edit', $historia->id)); ?>" 
                                                   class="btn btn-warning" title="Editar">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                
                                                <form action="<?php echo e(route('administrador.historias.destroy', $historia->id)); ?>" 
                                                      method="POST" class="d-inline"
                                                      onsubmit="return confirm('¿Eliminar esta historia?')">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('DELETE'); ?>
                                                    <button type="submit" class="btn btn-danger" title="Eliminar">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- Modal para rechazar -->
                                    <div class="modal fade" id="rechazarModal<?php echo e($historia->id); ?>" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form action="<?php echo e(route('administrador.historias.rechazar', $historia->id)); ?>" method="POST">
                                                    <?php echo csrf_field(); ?>
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Rechazar Historia</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p><strong>Historia:</strong></p>
                                                        <p class="text-muted"><?php echo e(Str::limit($historia->contenido, 150)); ?></p>
                                                        
                                                        <div class="mb-3">
                                                            <label for="motivo_rechazo" class="form-label">
                                                                Motivo del rechazo <span class="text-danger">*</span>
                                                            </label>
                                                            <textarea name="motivo_rechazo" 
                                                                      id="motivo_rechazo" 
                                                                      class="form-control" 
                                                                      rows="3" 
                                                                      required
                                                                      placeholder="Explica por qué se rechaza esta historia..."></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                        <button type="submit" class="btn btn-danger">
                                                            <i class="fas fa-times"></i> Rechazar Historia
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="7" class="text-center py-5 text-muted">
                                            <i class="fas fa-inbox fa-3x mb-3"></i>
                                            <p>No hay historias registradas</p>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\univida\resources\views/administrador/historias/index.blade.php ENDPATH**/ ?>