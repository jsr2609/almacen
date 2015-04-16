use dbalmacen;
CREATE OR REPLACE
    ALGORITHM = UNDEFINED 
    DEFINER = `root`@`localhost` 
    SQL SECURITY DEFINER
VIEW `dbalmacen`.`VwEntradas` AS
    SELECT 
        `ets`.`Id` AS `Id`,
        ets.Folio,
        ets.Fecha,
        ets.TipoEntradaId,
        ets.PedidoNumero,
        ets.FacturaNumero,
        ets.EjercicioId,
        ets.ProgramaId,
        pgs.Clave AS ProgramaClave,
        pgs.Nombre AS ProgramaNombre,
        ets.ProveedorId,
        pvs.Rfc as ProveedorRfc,
        pvs.Nombre AS ProveedorNombre,
        ets.Activa
    FROM
        `dbalmacen`.`Entradas` `ets`
    INNER JOIN Programas AS pgs ON (ets.ProgramaId = pgs.Id)
    INNER JOIN Proveedores AS pvs ON (ets.ProveedorId = pvs.id)