/*

SELECT * FROM InvProductoContenedor WHERE PTCO_UsuaDate > '2018-12-30' ORDER BY PTCO_UsuaDate DESC

CREATE TEMP VIEW TempInvPxC AS
SELECT InvProductoContenedor.PTCO_PtcoId PtcoId, InvMovimientoDet.MODT_ContID contID,InvMovimientoDet.MODT_ProdID ProdId
,ifnull(MIN(InvProductoContenedor.PTCO_Existencia),0)+SUM(InvMovimientoDet.MODT_Cantidad) Existencia,InvMovimientoDet.MODT_PvarID PvarID
FROM  InvMovimientoDet LEFT JOIN InvProductoContenedor ON InvMovimientoDet.MODT_ProdID=InvProductoContenedor.PTCO_ProdId 
AND InvMovimientoDet.MODT_ContID=InvProductoContenedor.PTCO_contID AND InvMovimientoDet.MODT_PvarID=InvProductoContenedor.PTCO_PvarID
AND InvProductoContenedor.PTCO_Estatus<>'B'
WHERE InvMovimientoDet.MODT_Cantidad<>0
AND InvMovimientoDet.MODT_Estatus<>'B'
AND InvMovimientoDet.MODT_MoinID=13979
GROUP BY InvProductoContenedor.PTCO_PtcoId,InvMovimientoDet.MODT_ContID,InvMovimientoDet.MODT_ProdID,InvMovimientoDet.MODT_PvarID;

SELECT * FROM TempInvPxC;

INSERT OR REPLACE INTO InvProductoAlmacen(PTAL_PtalID,PTAL_AlmacenCataID,PTAL_ProdId,PTAL_Existencia,PTAL_PvarID,PTAL_UsuaDate)
SELECT InvProductoAlmacen.PTAL_PtalID,34,ProdId,SUM(Existencia),PvarID,strftime('%Y/%m/%d %H:%M:%S',datetime('now','localtime')) 
FROM TempInvPxC LEFT JOIN InvProductoAlmacen ON InvProductoAlmacen.PTAL_ProdID=TempInvPxC.ProdId AND InvProductoAlmacen.PTAL_AlmacenCataID=34
AND InvProductoAlmacen.PTAL_PvarID=TempInvPxC.PvarID AND InvProductoAlmacen.PTAL_Estatus='A'
GROUP BY InvProductoAlmacen.PTAL_PtalID,ProdId,PvarID;


15669

SELECT * FROM InvMovimiento WHERE InvMovimiento.MOIN_MoinId=15669


SELECT * FROM InvProductoContenedor WHERE PTCO_UsuaDate > '2019-05-30' ORDER BY PTCO_UsuaDate DESC;

            SELECT * FROM InvProductoAlmacen where InvProductoAlmacen.PTAL_UsuaDate > '2019-05-30'
            ORDER BY InvProductoAlmacen.PTAL_ProdID, InvProductoAlmacen.PTAL_PvarID;

            SELECT * FROM IngProducto WHERE IngProducto.PROD_PRODID=119;

            SELECT * FROM IngProductoVariable WHERE PVAR_PVARID=2049;




SELECT AUX.PTAL_PTALID,InvProductoAlmacen.PTAL_PTALID
FROM InvProductoAlmacen INNER JOIN 
(

*/

UPDATE InvFisico 
                     SET INFI_AEntradaId=0,INFI_ASalidaId=15670,INFI_Estatus='V'
                    ,INFI_UsuaDate=strftime('%Y/%m/%d %H:%M:%S',datetime('now','localtime')) , INFI_UsuaID=1 WHERE INFI_AlmaId=73 AND INFI_Fecha=2019-06-10 16:45:59 AND INFI_Estatus<>'B';

