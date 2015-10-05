select pgs.clave, pgs.nombre, ats.clave, exs.cantidad, exs.total from existencias exs
inner join articulos ats on (exs.articuloid = ats.id)
inner join programas pgs on (exs.programaid = pgs.id);