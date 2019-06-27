SELECT  * FROM VtaPedido WHERE PEDI_PediID>12370 order by PEDI_PediID desc
SELECT * FROM VtaPedidoDet WHERE DEPE_PediID=12386

SELECT * FROM paraCatalogo WHERE CATA_Tipo='ALMACENMOV' AND paraCatalogo.CATA_Desc1='SAL.VENTA' AND paraCatalogo.CATA_Estatus<>'B'

SELECT * FROM InvMovimiento WHERE MOIN_Fecha>'2019-06-26' ORDER BY MOIN_MoinId DESC
MOIN_TipoMovCataID=39 AND MOIN_Estatus<>'B' AND MOIN_Referencia='12384'

SELECT * FROM InvMovimientoDet WHERE MODT_MoinID=15678

UPDATE VtaPedido SET PEDI_Estatus= 'A' ,PEDI_UsuaDate=strftime('%Y-%m-%d %H:%M:%S',datetime('now','localtime')) 
 WHERE PEDI_PediID =12384


 SELECT * FROM InvMovimientoDet WHERE MODT_Estatus='B' AND MODT_MoinID=15676 

 SELECT * FROM VtaCajaDet WHERE CAJD_UsuaDate>'2018-06-25' ORDER BY CAJD_CajdID DESC