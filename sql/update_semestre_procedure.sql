-- Archivo: update_semestre_procedure.sql
USE gd;
DROP PROCEDURE IF EXISTS actualizar_semestre_grupos;
DELIMITER $$
CREATE PROCEDURE actualizar_semestre_grupos()
BEGIN
  DECLARE v_sem INT;
  -- Actualiza el semestre y marca como egresado si corresponde
  UPDATE grupo
  SET
    semestre = CASE
      WHEN FLOOR(TIMESTAMPDIFF(MONTH, MAKEDATE(anio_inicio,1), CURDATE()) / 6) + 1 <= 6
           THEN FLOOR(TIMESTAMPDIFF(MONTH, MAKEDATE(anio_inicio,1), CURDATE()) / 6) + 1
      ELSE 6
    END,
    status = CASE
      WHEN FLOOR(TIMESTAMPDIFF(MONTH, MAKEDATE(anio_inicio,1), CURDATE()) / 6) + 1 > 6
           THEN 'egresado'
      ELSE status
    END
  WHERE status <> 'egresado';
END$$
DELIMITER ;

-- Uso: CALL actualizar_semestre_grupos();
