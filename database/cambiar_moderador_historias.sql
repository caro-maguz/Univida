-- Migración: Cambiar moderación de historias de administrador a psicólogo
-- Fecha: 2025-11-15
-- Descripción: Cambia la clave foránea fk_moderador de administrador a psicólogo

USE univida;

-- PASO 1: Limpiar datos existentes (IMPORTANTE: ejecutar primero)
-- Las IDs de administrador no coinciden con las IDs de psicólogo
UPDATE historia SET fk_moderador = NULL WHERE fk_moderador IS NOT NULL;

-- PASO 2: Encontrar y eliminar la clave foránea existente
-- Primero, verificar el nombre de la constraint:
-- SELECT CONSTRAINT_NAME FROM information_schema.KEY_COLUMN_USAGE 
-- WHERE TABLE_SCHEMA = 'univida' AND TABLE_NAME = 'historia' AND COLUMN_NAME = 'fk_moderador';

-- Eliminar la constraint (ajustar el nombre si es diferente)
SET @constraint_name = (
    SELECT CONSTRAINT_NAME 
    FROM information_schema.KEY_COLUMN_USAGE 
    WHERE TABLE_SCHEMA = 'univida' 
    AND TABLE_NAME = 'historia' 
    AND COLUMN_NAME = 'fk_moderador'
    AND CONSTRAINT_NAME != 'PRIMARY'
    LIMIT 1
);

SET @sql = CONCAT('ALTER TABLE historia DROP FOREIGN KEY ', @constraint_name);
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- PASO 3: Crear nueva clave foránea apuntando a psicólogo
ALTER TABLE historia
ADD CONSTRAINT fk_historia_moderador_psicologo
FOREIGN KEY (fk_moderador) REFERENCES psicologo(id_psicologo)
ON DELETE SET NULL
ON UPDATE CASCADE;

SELECT 'Migración completada exitosamente. Ahora los psicólogos pueden moderar historias.' AS Resultado;
