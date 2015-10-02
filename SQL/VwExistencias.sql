-- View: almacen.vwexistencias

-- DROP VIEW almacen.vwexistencias;

CREATE OR REPLACE VIEW almacen.vwexistencias AS 
 SELECT ats.id,
    ets.programaid,
    eds.id AS entradadetalleid,
    eds.existencia,
    ets.tipocompra AS tipoentrada,
    exs.cantidad,
    exs.total,
    ats.clave,
    ats.nombre,
    ats.presentacionnombre AS articulopresentacionnombre,
    ats.partidaid,
    pts.clave AS partidaclave,
    pts.nombre AS partidanombre,
    ats.presentacionid,
    pss.nombre AS presentacionnombre,
    ats.activo
   FROM almacen.entradadetalles eds
     LEFT JOIN almacen.entradas ets ON eds.entradaid = ets.id
     LEFT JOIN almacen.articulos ats ON eds.articuloid = ats.id
     LEFT JOIN almacen.existencias exs ON exs.articuloid = ats.id
     LEFT JOIN almacen.partidas pts ON ats.partidaid = pts.id
     LEFT JOIN almacen.presentaciones pss ON ats.presentacionid = pss.id;

ALTER TABLE almacen.vwexistencias
  OWNER TO postgres;
