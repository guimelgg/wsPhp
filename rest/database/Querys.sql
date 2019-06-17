/*
SELECT PROD_Clave as Clave,PVAR_Valor1 AS SubClave,PVAR_Valor2,IFDT_Cantidad AS Fisico,IFDT_Kardex as Kardex
,CASE WHEN IFDT_Costo IS NULL THEN PROD_CostoPromedio WHEN IFDT_Costo=0 THEN PROD_CostoPromedio ELSE IFDT_Costo END as Costo 
FROM InvFisico INNER JOIN InvFisicoDet ON INFI_InfiId=IFDT_InfiId AND INFI_Estatus<>'B' AND INFI_Fecha='2018-02-08' 
AND INFI_AlmaId=34 
INNER JOIN IngProducto ON IFDT_ProdId=PROD_ProdID 
LEFT JOIN IngProductoVariable ON IFDT_PvarID=PVAR_PvarID
*/

SELECT date('2019-05-15','+14 day');