SELECT  * FROM VtaPedido WHERE PEDI_PediID>12370

UPDATE VtaPedido 
SET PEDI_FechaEnv=strftime('%Y-%m-%d %H:%M:%S',datetime('now','localtime'))
,PEDI_UsuaDate=strftime('%Y-%m-%d %H:%M:%S',datetime('now','localtime'))
WHERE PEDI_PediID=12379

SELECT * FROM VtaPedidoDet WHERE DEPE_PediID=12378


SELECT * FROM InvMovimiento WHERE MOIN_MoinId=15671

SELECT * FROM InvMovimientoDet WHERE MODT_MoinID=15671

CREATE TEMP VIEW TempInvPxC AS
            SELECT  InvMovimientoDet.MODT_ContID contID,InvMovimientoDet.MODT_ProdID ProdId,SUM(InvMovimientoDet.MODT_Cantidad) Existencia,InvMovimientoDet.MODT_PvarID PvarID
            FROM InvMovimientoDet WHERE InvMovimientoDet.MODT_MoinID=15675 AND InvMovimientoDet.MODT_Cantidad<>0
             AND InvMovimientoDet.MODT_Estatus<>'B'             
             GROUP BY InvMovimientoDet.MODT_ContID,InvMovimientoDet.MODT_ProdID,InvMovimientoDet.MODT_PvarID;