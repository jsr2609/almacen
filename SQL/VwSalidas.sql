-- View: almacen.vwsalidas

-- DROP VIEW almacen.vwsalidas;

CREATE OR REPLACE VIEW almacen.vwsalidas AS 
 SELECT sds.id,
    sds.folio,
    sds.fecha,
    sds.tipoentradaid,
    sds.ejercicioid,
    sds.nombrequienrecibe,
    sds.programaid,
    pgs.clave AS programaclave,
    pgs.nombre AS programanombre,
    sds.activo
   FROM almacen.salidas sds
     JOIN almacen.programas pgs ON sds.programaid = pgs.id
  ORDER BY sds.id, sds.folio DESC;

ALTER TABLE almacen.vwsalidas
  OWNER TO almacen;
