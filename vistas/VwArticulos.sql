CREATE OR REPLACE
    ALGORITHM = UNDEFINED 
    DEFINER = `root`@`localhost` 
    SQL SECURITY DEFINER
VIEW `dbalmacen`.`VwArticulos` AS
    SELECT 
        `ats`.`Id` AS `Id`,
        ats.Clave,
        ats.Nombre,
        ats.PartidaId,
        pts.nombre
        
    FROM
        `dbalmacen`.`Articulos` AS `ats`
	INNER JOIN Partidas AS pts ON (ats.PartidaId = pts.Id)