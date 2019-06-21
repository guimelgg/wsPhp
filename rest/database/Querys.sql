/*
SELECT PROD_Clave as Clave,PVAR_Valor1 AS SubClave,PVAR_Valor2,IFDT_Cantidad AS Fisico,IFDT_Kardex as Kardex
,CASE WHEN IFDT_Costo IS NULL THEN PROD_CostoPromedio WHEN IFDT_Costo=0 THEN PROD_CostoPromedio ELSE IFDT_Costo END as Costo 
FROM InvFisico INNER JOIN InvFisicoDet ON INFI_InfiId=IFDT_InfiId AND INFI_Estatus<>'B' AND INFI_Fecha='2018-02-08' 
AND INFI_AlmaId=34 
INNER JOIN IngProducto ON IFDT_ProdId=PROD_ProdID 
LEFT JOIN IngProductoVariable ON IFDT_PvarID=PVAR_PvarID

SELECT strftime('%Y/%m/%d %H:%M:%S',datetime('now','localtime'));

SELECT strftime('%Y-%m-%d %H:%M:%S',datetime('now','localtime'));


*/
 SELECT CAJD_CajaID,CAJD_MonedaID,CAJD_FCobroID,CAJD_Importe,CAJD_PediID,CAJD_UsuaID,strftime('%d/%m/%Y %H:%M',CAJD_UsuaDate) CAJD_UsuaDate,CAJD_Referencia,CAJD_CajdID 
 FROM VtaCajaDet WHERE CAJD_CajaID =33 AND CAJD_Estatus IN ('A','I') AND CAJD_Importe>0 ORDER BY CAJD_CajdID DESC;

SELECT Forma.CATA_CataID AS CAJD_FCobroID,Moneda.CATA_CataID as CAJD_MonedaID,0 as CAJD_Importe 
FROM paraCatalogo as Forma,paraCatalogo as Moneda WHERE Forma.CATA_Tipo='FORMA DE COBRO' and Moneda.CATA_Tipo='MONEDA' AND Moneda.CATA_Desc1='M.N';


 SELECT Forma.CATA_CataID AS CAJD_FCobroID,Moneda.CATA_CataID as CAJD_MonedaID,0 as CAJD_Importe 
 FROM paraCatalogo as Forma,paraCatalogo as Moneda WHERE Forma.CATA_Tipo='FORMA DE COBRO' and Moneda.CATA_Tipo='MONEDA' AND Moneda.CATA_Desc1='M.N';

 SELECT CATA_Desc1 as Valor,CATA_CataID as ValorID, CATA_Code1,CATA_Code2,CATA_Desc2,CATA_Desc3,Cata_Desc4 
 FROM paraCatalogo  WHERE CATA_Estatus<>'B' AND CATA_Tipo LIKE 'FORMA DE COBRO' ORDER BY CATA_Desc1


 SELECT * FROM VtaCajaDet WHERE CAJD_Referencia='PRUEBA' 

 SELECT * FROM VtaCajaDet WHERE CAJD_CajaID=41
 AND CAJD_UsuaDate>'2019-05-20'
 ORDER BY CAJD_CajdID DESC