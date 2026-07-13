ALTER TABLE `incidencias`
  ADD COLUMN `codigo` varchar(20) NULL AFTER `id_incidencia`,
  ADD COLUMN `modulo_afectado` varchar(100) NULL AFTER `estado`,
  ADD COLUMN `impacto` enum('bajo','medio','alto','critico') NULL AFTER `categoria`,
  ADD COLUMN `urgencia` enum('bajo','medio','alto','critico') NULL AFTER `impacto`,
  ADD COLUMN `remitente` varchar(150) NULL AFTER `urgencia`,
  ADD COLUMN `correo_remitente` varchar(150) NULL AFTER `remitente`,
  ADD COLUMN `asunto_correo` varchar(200) NULL AFTER `correo_remitente`,
  ADD COLUMN `fecha_recepcion` datetime NULL AFTER `asunto_correo`,
  ADD COLUMN `origen` enum('correo','manual') NOT NULL DEFAULT 'manual' AFTER `fecha_recepcion`,
  ADD COLUMN `correo_message_id` varchar(255) NULL AFTER `origen`,
  ADD COLUMN `id_usuario_cierre` int(11) NULL AFTER `id_usuario_asignado`,
  ADD COLUMN `fecha_cierre` datetime NULL AFTER `id_usuario_cierre`;

SET @n := 0;

UPDATE `incidencias`
SET `codigo` = CONCAT('INC-', DATE_FORMAT(COALESCE(`created_at`, NOW()), '%Y%m%d'), '-', LPAD((@n := @n + 1), 2, '0')),
    `impacto` = COALESCE(`impacto`, 'medio'),
    `urgencia` = COALESCE(`urgencia`, 'medio'),
    `fecha_recepcion` = COALESCE(`fecha_recepcion`, `created_at`, NOW()),
    `asunto_correo` = COALESCE(`asunto_correo`, `titulo`),
    `origen` = COALESCE(`origen`, 'manual')
WHERE `codigo` IS NULL;

ALTER TABLE `incidencias`
  MODIFY `codigo` varchar(20) NOT NULL,
  MODIFY `id_usuario_creador` int(11) NULL,
  MODIFY `estado` enum('abierto','en_proceso','resuelto','pendiente','clasificacion','asignado','en_diagnostico','en_resolucion','validacion','cerrado') NOT NULL DEFAULT 'pendiente';

UPDATE `incidencias`
SET `estado` = CASE `estado`
  WHEN 'abierto' THEN 'pendiente'
  WHEN 'en_proceso' THEN 'en_diagnostico'
  WHEN 'resuelto' THEN 'validacion'
  ELSE `estado`
END;

ALTER TABLE `incidencias`
  MODIFY `estado` enum('pendiente','clasificacion','asignado','en_diagnostico','en_resolucion','validacion','cerrado') NOT NULL DEFAULT 'pendiente',
  ADD UNIQUE KEY `idx_incidencias_codigo` (`codigo`),
  ADD UNIQUE KEY `idx_incidencias_correo_message_id` (`correo_message_id`),
  ADD KEY `idx_incidencias_estado` (`estado`),
  ADD KEY `idx_incidencias_prioridad` (`prioridad`),
  ADD KEY `idx_incidencias_modulo` (`modulo_afectado`),
  ADD KEY `idx_incidencias_asignado` (`id_usuario_asignado`),
  ADD KEY `idx_incidencias_cierre` (`id_usuario_cierre`);

ALTER TABLE `incidencia_comentarios`
  ADD COLUMN `tipo` enum('comentario','respuesta') NOT NULL DEFAULT 'comentario' AFTER `comentario`,
  ADD COLUMN `enviado_por_correo` tinyint(1) NOT NULL DEFAULT 0 AFTER `tipo`,
  ADD COLUMN `correo_destino` varchar(150) NULL AFTER `enviado_por_correo`,
  ADD COLUMN `fecha_envio_correo` datetime NULL AFTER `correo_destino`,
  MODIFY `id_usuario` int(11) NULL;
