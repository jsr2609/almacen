#Limpiar BD
delete from EntradaDetalles where Id > 0;
delete from Entradas where Id > 0;
delete from Salidas where Id > 0;
delete from Existencias where Id > 0;

#Elminar Catalogos
delete from Articulos where Id > 0;
delete from Partidas where Id > 0;
delete from Programas where Id > 0;