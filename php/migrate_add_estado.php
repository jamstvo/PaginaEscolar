<?php
    /**
     * Script de migración rápido para añadir la columna `estado` a la tabla `docente`.
     * Úsalo SOLO en entorno de desarrollo. Ejecutar desde CLI:
     *   php php/migrate_add_estado.php
     * O abrir en el navegador: http://tu-servidor/PaginaEscolar/php/migrate_add_estado.php
     */

    require_once "main.php";

    try{
        $db = conexion();

        // Comprobar si la columna ya existe
        $stmt = $db->query("SHOW COLUMNS FROM docente LIKE 'estado'");
        $col = $stmt->fetchAll();

        if(count($col) > 0){
            echo "La columna 'estado' ya existe en la tabla 'docente'.\n";
            exit;
        }

        // Añadir columna con valor por defecto 'ACTIVO'
        $sql = "ALTER TABLE docente ADD COLUMN estado VARCHAR(20) NOT NULL DEFAULT 'ACTIVO'";
        $db->exec($sql);

        echo "Columna 'estado' añadida correctamente.\n";
    }catch(PDOException $e){
        echo "Error en la migración: " . $e->getMessage() . "\n";
        exit(1);
    }

    $db = null;
?>
