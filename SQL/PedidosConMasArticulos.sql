SELECT no_pedido, count(no_pedido), ejercicio, compra
  FROM qry_detalles_pedidos where ejercicio = 2015 group by no_pedido, ejercicio, compra order by count(no_pedido) DESC;
