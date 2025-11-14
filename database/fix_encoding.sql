-- Fix tipo_violencia encoding
DELETE FROM tipo_violencia;
INSERT INTO tipo_violencia (nombre, descripcion) VALUES 
('Física', 'Violencia que causa daño físico'),
('Psicológica', 'Violencia emocional o psicológica'),
('Sexual', 'Violencia de índole sexual');

-- Fix tipos_recurso if needed
DELETE FROM tipos_recurso;
INSERT INTO tipos_recurso (nombre, descripcion) VALUES 
('Protocolos', 'Documentos y procedimientos oficiales'),
('Contactos de emergencia', 'Números y contactos de ayuda'),
('Material educativo', 'Recursos informativos y educativos');

SELECT 'Datos corregidos:' AS '';
SELECT * FROM tipo_violencia;
SELECT * FROM tipos_recurso;

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
('La valentía también se ve en quien pide ayuda.', 1) 
ON DUPLICATE KEY UPDATE texto=VALUES(texto);

INSERT INTO pregunta_test (enunciado) VALUES 
('Alguien en tu entorno te insulta, humilla o ridiculiza constantemente?'),
 ('Has recibido comentarios que te hacen sentir inferior, incapaz o sin valor?'), 
 ('Has sido amenazado/a o intimidado/a por alguien cercano?'), 
 ('Te hacen sentir culpable por cosas que no son tu responsabilidad?'), 
 ('Te han alejado de tus amigos, familia o personas importantes para ti?'), 
 ('Alguien controla excesivamente tus actividades, decisiones o forma de vestir?'), 
 ('Invaden tu privacidad revisando tus pertenencias, mensajes o redes sociales sin permiso?'), 
 ('Sientes miedo constante de expresar tus opiniones o hacer enojar a alguien?'), 
 ('Has recibido empujones, jalones, sacudidas o agarrones violentos?'), 
 ('Has sido golpeado/a, abofeteado/a o agredido/a físicamente?');

INSERT INTO pregunta_test (enunciado) VALUES 
 ('Han destruido o lanzado objetos cerca de ti para intimidarte?'), 
 ('Te han impedido salir, te han encerrado o bloqueado el paso físicamente?'), 
 ('Has sido presionado/a u obligado/a a realizar actos sexuales contra tu voluntad?'), 
 ('Has experimentado tocamientos o acercamientos sexuales no deseados?'), 
 ('Han ignorado tu negativa o te han hecho sentir culpable por no acceder a demandas sexuales?'), 
 ('Has recibido comentarios ofensivos, humillantes o acoso de índole sexual?'), 
 ('Alguien controla completamente tus recursos económicos o te exige rendir cuentas de cada gasto?'), 
 ('Te impiden trabajar, estudiar o desarrollarte profesionalmente?'), 
 ('Han tomado o usado tu dinero, tarjetas o propiedades sin tu autorización?'), 
 ('Te niegan recursos para cubrir necesidades básicas como alimentación, salud o educación?');