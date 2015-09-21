-- DROP VIEW vwarticulos;

CREATE OR REPLACE VIEW vwarticulos AS 
 SELECT ats.id,
    ats.clave,
    ats.nombre,
    ats.presentacionnombre AS articulopresentacionnombre,
    ats.partidaid,
    pts.clave AS partidaclave,
    pts.nombre AS partidanombre,
    ats.presentacionid,
    pss.nombre AS presentacionnombre,
    ats.activo
   FROM articulos ats
     LEFT JOIN partidas pts ON ats.partidaid = pts.id
     LEFT JOIN presentaciones pss ON ats.presentacionid = pss.id;

ALTER TABLE vwarticulos
  OWNER TO almacen;
