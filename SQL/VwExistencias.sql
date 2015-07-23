CREATE 
    ALGORITHM = UNDEFINED 
    DEFINER = `root`@`localhost` 
    SQL SECURITY DEFINER
VIEW `vwexistencias` AS
    SELECT 
        `ats`.`Id` AS `Id`,
        `ets`.`ProgramaId` AS `ProgramaId`,
        `eds`.`Id` AS `EntradaDetalleId`,
        `eds`.`Existencia` AS `Existencia`,
        `ets`.`TipoEntradaId` AS `TipoEntrada`,
        `exs`.`Cantidad` AS `Cantidad`,
        `ats`.`Clave` AS `Clave`,
        `ats`.`Nombre` AS `Nombre`,
        `ats`.`PartidaId` AS `PartidaId`,
        `pts`.`Clave` AS `PartidaClave`,
        `pts`.`Nombre` AS `PartidaNombre`,
        `ats`.`PresentacionId` AS `PresentacionId`,
        `pss`.`Nombre` AS `PresentacionNombre`,
        `ats`.`Activo` AS `Activo`
    FROM
        (((((`entradadetalles` `eds`
        JOIN `entradas` `ets` ON ((`eds`.`EntradaId` = `ets`.`Id`)))
        JOIN `articulos` `ats` ON ((`eds`.`ArticuloId` = `ats`.`Id`)))
        JOIN `existencias` `exs` ON ((`exs`.`ArticuloId` = `ats`.`Id`)))
        JOIN `partidas` `pts` ON ((`ats`.`PartidaId` = `pts`.`Id`)))
        JOIN `presentaciones` `pss` ON ((`ats`.`PresentacionId` = `pss`.`Id`)))
    GROUP BY `ats`.`Id`