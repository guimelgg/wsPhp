-- SQLite
--13979
--SELECT * FROM TempExiPXC
--SELECT * FROM InvMovimiento ORDER BY InvMovimiento.MOIN_MoinId DESC

/*

CREATE TEMPORARY TABLE TempInvPxC AS

SELECT *
FROM InvProductoContenedor INNER JOIN TempInvPxC ON TempInvPxC.PtcoId=InvProductoContenedor.InvProductoContenedor.PTCO_PtcoId;


UPDATE InvProductoContenedor 
SET (PTCO_Existencia) = (SELECT Existencia FROM TempInvPxC 
                        WHERE TempInvPxC.PtcoId=InvProductoContenedor.PTCO_PtcoId)
WHERE InvProductoContenedor.PTCO_PtcoId IN (SELECT TempInvPxC.PtcoId FROM TempInvPxC);

SELECT *
FROM InvProductoContenedor INNER JOIN TempInvPxC ON TempInvPxC.PtcoId=InvProductoContenedor.PTCO_PtcoId;

INSERT INTO InvProductoContenedor(PTCO_PtcoId, PTCO_contID,PTCO_ProdId,PTCO_Existencia,PTCO_PvarID,PTCO_UsuaDate)

INSERT INTO InvProductoContenedor(PTCO_PtcoId, PTCO_contID,PTCO_ProdId,PTCO_Existencia,PTCO_PvarID,PTCO_UsuaDate)
SELECT PtcoId,contID,ProdId,Existencia,PvarID,strftime('%Y/%m/%d %H:%M:%S',datetime('now','localtime')) FROM TempInvPxC;

SELECT * FROM InvMovimiento WHERE InvMovimiento.MOIN_MoinId=13979

DELETE FROM InvProductoContenedor WHERE InvProductoContenedor.PTCO_PtcoId IN (SELECT PtcoId FROM TempInvPxC WHERE PtcoId>0);
INSERT INTO InvProductoContenedor(PTCO_contID,PTCO_ProdId,PTCO_Existencia,PTCO_PvarID,PTCO_UsuaDate)
SELECT contID,ProdId,Existencia,PvarID,strftime('%Y/%m/%d %H:%M:%S',datetime('now','localtime')) FROM TempInvPxC WHERE PtcoId>0;

INSERT OR REPLACE INTO InvProductoContenedor(PTCO_PtcoId, PTCO_contID,PTCO_ProdId,PTCO_Existencia,PTCO_PvarID,PTCO_UsuaDate)
SELECT PtcoId,contID,ProdId,Existencia,PvarID,strftime('%Y/%m/%d %H:%M:%S',datetime('now','localtime')) FROM TempInvPxC;



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

*/
SELECT * FROM InvProductoAlmacen WHERE InvProductoAlmacen.PTAL_UsuaDate> '2018-12-30' ORDER BY PTAL_UsuaDate DESC
