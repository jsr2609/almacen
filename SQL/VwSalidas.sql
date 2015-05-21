use dbalmacen;
CREATE OR REPLACE
    ALGORITHM = UNDEFINED
    DEFINER = `root`@`localhost`
    SQL SECURITY DEFINER
VIEW `VwSalidas` AS
    SELECT
        `ets`.`Id` AS `Id`,
        `ets`.`Folio` AS `Folio`,
        `ets`.`Fecha` AS `Fecha`,
        `ets`.`TipoEntradaId` AS `TipoEntradaId`,
        `ets`.`EjercicioId` AS `EjercicioId`,
        `ets`.`NombreQuienRecibe` AS `NombreQuienRecibe`,
        `ets`.`ProgramaId` AS `ProgramaId`,
        `pgs`.`Clave` AS `ProgramaClave`,
        `pgs`.`Nombre` AS `ProgramaNombre`,
        `ets`.`Activo` AS `Activo`
    FROM
        (`Salidas` `ets`
        JOIN `Programas` `pgs` ON ((`ets`.`ProgramaId` = `pgs`.`Id`)))
