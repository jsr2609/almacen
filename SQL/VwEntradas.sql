-- View: vwentradas

-- DROP VIEW vwentradas;

CREATE OR REPLACE VIEW vwentradas AS 
 SELECT ets.id,
    ets.folio,
    ets.fecha,
    ets.tipocompra AS tipocompraid,
    ets.pedidonumero,
    ets.facturanumero,
    ets.ejercicioid,
    ets.programaid,
    pgs.clave AS programaclave,
    pgs.nombre AS programanombre,
    ets.proveedorid,
    pvs.rfc AS proveedorrfc,
    pvs.nombre AS proveedornombre,
    ets.activa
   FROM entradas ets
     JOIN programas pgs ON ets.programaid = pgs.id
     JOIN proveedores pvs ON ets.proveedorid = pvs.id;

ALTER TABLE vwentradas
  OWNER TO almacen;
