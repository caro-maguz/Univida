-- Script para corregir la codificación de la tabla frases_motivacionales
-- Ejecutar en phpMyAdmin o MySQL Workbench

-- 1. Cambiar la tabla a utf8mb4
ALTER TABLE frases_motivacionales 
CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- 2. Asegurar que la columna texto use utf8mb4
ALTER TABLE frases_motivacionales 
MODIFY texto VARCHAR(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL;

-- 3. Limpiar y reinsertar las frases con la codificación correcta
DELETE FROM frases_motivacionales;

INSERT INTO frases_motivacionales (texto, activo) VALUES 
('Ninguna forma de violencia es normal. Mereces respeto, siempre.', 1), 
('Lo que te incomoda también importa. Escucha tu voz.', 1), 
('Callar no te protege; hablar puede cambiarlo todo.', 1), 
('Nombrar lo que duele es el primer paso para sanar.', 1), 
('Tu historia merece ser escuchada, sin miedo ni juicio.', 1),
('Reconocer la violencia no te hace débil, te hace consciente.', 1), 
('Si algo no te hace sentir seguro(a), no lo ignores. Confía en tu intuición.', 1),
('No estás exagerando si algo te duele o te incomoda.', 1), 
('La violencia no tiene justificación, ni dentro ni fuera de la universidad.', 1), 
('La valentía también se ve en quien pide ayuda.', 1);

-- Verificar los resultados
SELECT '=== Frases motivacionales actualizadas ===' AS '';
SELECT id, texto, activo FROM frases_motivacionales;
