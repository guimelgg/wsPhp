-- Script Date: 17/01/2018 05:08 p.m. 
SELECT 1;
PRAGMA foreign_keys=OFF;
BEGIN TRANSACTION;
CREATE TABLE [VtaPrecio] (
  [PREC_PrecID] INTEGER  NOT NULL
, [PREC_LpreID] int  NOT NULL
, [PREC_ProdID] int  NOT NULL
, [PREC_Precio] money NOT NULL
, [PREC_Estatus] nchar(1) DEFAULT 'A'  NOT NULL
, [PREC_UsuaID] int  NOT NULL
, [PREC_UsuaDate] datetime current_timestamp NOT NULL
, [PREC_Descuento] money NULL
, CONSTRAINT [PK__VtaPrecio__00000000000004BB] PRIMARY KEY ([PREC_PrecID])
);
CREATE TABLE [VtaPedidoDet] (
  [DEPE_DepeID] INTEGER  NOT NULL
, [DEPE_PediID] int  NOT NULL
, [DEPE_ProdID] int  NOT NULL
, [DEPE_Pedido] money NULL
, [DEPE_Surtido] money NULL
, [DEPE_Precio] money NULL
, [DEPE_Obs] nvarchar(500)  NULL
, [DEPE_DescP] money NULL
, [DEPE_IvaP] money NULL
, [DEPE_PvarID] int  NULL
, [DEPE_PrecID] int  NULL
, [DEPE_PromID] int  NULL
, [DEPE_Desc] nvarchar(600)  NULL
, [DEPE_FactID] int  NULL
, [DEPE_LcreID] int  NULL
, [DEPE_FEntrega] datetime NULL
, [DEPE_Estatus] nchar(1) DEFAULT 'A'  NOT NULL
, [DEPE_UsuaID] int  NOT NULL
, [DEPE_UsuaDate] datetime current_timestamp NOT NULL
, CONSTRAINT [PK__VtaPedidoDet__00000000000005EE] PRIMARY KEY ([DEPE_DepeID])
);
CREATE TABLE [VtaPedido] (
  [PEDI_PediID] INTEGER  NOT NULL
, [PEDI_Numero] int  NOT NULL
, [PEDI_FechaReg] datetime current_timestamp NOT NULL
, [PEDI_FechaEnv] datetime current_timestamp NULL
, [PEDI_AlmacenID] int  NULL
, [PEDI_SubTotal] money NULL
, [PEDI_Descuento] money NULL
, [PEDI_Iva] money NULL
, [PEDI_Total] money NULL
, [PEDI_ClieID] int  NULL
, [PEDI_DireID] int  NULL
, [PEDI_OCompra] nvarchar(200)  NULL
, [PEDI_Obs] nvarchar(500)  NULL
, [PEDI_BackOrder] tinyint DEFAULT 0 NULL
, [PEDI_MonedaID] int  NULL
, [PEDI_Estatus] nvarchar(20) DEFAULT 'COTIZACION'  NOT NULL
, [PEDI_UsuaID] int  NOT NULL
, [PEDI_UsuaDate] datetime current_timestamp NOT NULL
, CONSTRAINT [PK__VtaPedido__000000000000061A] PRIMARY KEY ([PEDI_PediID])
);
CREATE TABLE [VtaListaDePrecio] (
  [LPRE_LpreID] INTEGER  NOT NULL
, [LPRE_LineaID] int  NULL
, [LPRE_Nombre] nvarchar(50)  NOT NULL
, [LPRE_Desc] nvarchar(200)  NULL
, [LPRE_MonedaID] int  NULL
, [LPRE_Estatus] nchar(1) DEFAULT 'A'  NOT NULL
, [LPRE_UsuaID] int  NOT NULL
, [LPRE_UsuaDate] datetime current_timestamp NOT NULL
, CONSTRAINT [PK_VtaListaDePrecio] PRIMARY KEY ([LPRE_LpreID])
);
CREATE TABLE [VtaCliente] (
  [CLIE_clieID] INTEGER  NOT NULL
, [CLIE_clave] int  NULL
, [CLIE_DigVer] tinyint NULL
, [CLIE_Nombre] nvarchar(250)  NOT NULL
, [CLIE_RFC] nvarchar(15)  NULL
, [CLIE_RefBanc] nvarchar(250)  NULL
, [CLIE_TipoPersona] nvarchar(20)  NULL
, [CLIE_MetodoPago] nvarchar(25) DEFAULT 'NO IDENTIFICADO'  NULL
, [CLIE_CtaPago] nvarchar(25)  NULL
, [CLIE_PlazaID] int  NULL
, [CLIE_PromotorID] int  NULL
, [CLIE_GiroID] int  NULL
, [CLIE_RetIva] money DEFAULT 0 NULL
, [CLIE_RetIsr] money DEFAULT 0 NULL
, [CLIE_TasaIva] money DEFAULT 0.16 NOT NULL
, [CLIE_UsoCFDI] nvarchar(3) DEFAULT 'P01'  NULL
, [CLIE_Estatus] nvarchar(50) DEFAULT 'A'  NOT NULL
, [CLIE_UsuaID] int  NOT NULL
, [CLIE_UsuaDate] datetime current_timestamp NOT NULL
, CONSTRAINT [PK_Cliente] PRIMARY KEY ([CLIE_clieID])
);
CREATE TABLE [TempExiPXC] (
  [ProdID] int  NULL
, [ContID] int  NULL
, [Existencia] money NULL
, [PvarID] int  NULL
);
CREATE TABLE [ProProcesoProducto] (
  [PRPT_PrptID] INTEGER  NOT NULL
, [PRPT_ProcesoID] int  NOT NULL
, [PRPT_Tipo] nvarchar(50)  NOT NULL
, [PRPT_TipoID] int  NOT NULL
, [PRPT_Orden] smallint NULL
, [PRPT_Notas1] nvarchar(500)  NULL
, [PRPT_Notas2] nvarchar(500)  NULL
, [PRPT_PadreID] int  NULL
, [PRPT_HerramientaID] int  NULL
, [PRPT_Estatus] nchar(1) DEFAULT 'A'  NOT NULL
, [PRPT_UsuaID] int  NOT NULL
, [PRPT_UsuaDate] datetime current_timestamp NOT NULL
, CONSTRAINT [PK_ProProceso] PRIMARY KEY ([PRPT_PrptID])
);
CREATE TABLE [ProProcesoMaquina] (
  [PRMA_PrmaID] INTEGER  NOT NULL
, [PRMA_ProcesoID] int  NOT NULL
, [PRMA_MaquinaID] int  NOT NULL
, [PRMA_TSetup] money NULL
, [PRMA_TOperacion] money NULL
, [PRMA_DatosAux1] nvarchar(50)  NULL
, [PRMA_DatosAux2] nvarchar(50)  NULL
, [PRMA_DatosAux3] nvarchar(50)  NULL
, [PRMA_Estatus] nvarchar(25) DEFAULT 'A'  NOT NULL
, [PRMA_UsuaID] int  NOT NULL
, [PRMA_UsuaDate] datetime current_timestamp NOT NULL
, CONSTRAINT [PK_ProMaquina] PRIMARY KEY ([PRMA_PrmaID])
);
CREATE TABLE [ProOrdenDet] (
  [ODET_OdetID] INTEGER  NOT NULL
, [ODET_OrdeID] int  NULL
, [ODET_EmpleadoID] int  NULL
, [ODET_EmpleadoTipo] nvarchar(20) DEFAULT 'INDIVIDUAL'  NOT NULL
, [ODET_DptoID] int  NULL
, [ODET_ProcesoID] int  NULL
, [ODET_MaquinaID] int  NULL
, [ODET_UltimaEntrega] bit DEFAULT 0 NULL
, [ODET_Tiempo] money NULL
, [ODET_Cantidad] money NULL
, [ODET_Merma] money NULL
, [ODET_Horario] nchar(1) DEFAULT 'O'  NULL
, [ODET_Costo] money NULL
, [ODET_FechaFin] datetime NULL
, [ODET_Estatus] nchar(1) DEFAULT 'A'  NULL
, [ODET_UsuaDate] datetime current_timestamp NULL
, [ODET_UsuaID] int  NULL
, CONSTRAINT [PK_ProOrdenDet] PRIMARY KEY ([ODET_OdetID])
);
CREATE TABLE [ProOrden] (
  [ORDE_OrdeID] INTEGER  NOT NULL
, [ORDE_ProdID] int  NOT NULL
, [ORDE_PvarID] int DEFAULT 0  NOT NULL
, [ORDE_CantSolicitada] money NOT NULL
, [ORDE_CantTerminada] money NULL
, [ORDE_Folio] nvarchar(50)  NOT NULL
, [ORDE_FechaSolicitada] datetime current_timestamp NOT NULL
, [ORDE_FechaTerminada] datetime NULL
, [ORDE_Tipo] nvarchar(50) DEFAULT 'PEDIDO'  NOT NULL
, [ORDE_TipoID] int  NOT NULL
, [ORDE_AlmacenID] int  NOT NULL
, [ORDE_Costo] money NULL
, [ORDE_Estatus] nvarchar(20) DEFAULT 'ABIERTA'  NOT NULL
, [ORDE_UsuaID] int  NOT NULL
, [ORDE_UsuaDate] datetime current_timestamp NOT NULL
, CONSTRAINT [PK_ProOrden] PRIMARY KEY ([ORDE_OrdeID])
);
CREATE TABLE [ProActividad] (
  [ACTI_ActiID] INTEGER  NOT NULL
, [ACTI_OdetID] int  NOT NULL
, [ACTI_AcciID] int  NOT NULL
, [ACTI_Notas] nchar(300)  NULL
, [ACTI_Cantidad] money DEFAULT 0 NOT NULL
, [ACTI_Merma] money DEFAULT 0 NOT NULL
, [ACTI_Estatus] nchar(1) DEFAULT 'A'  NOT NULL
, [ACTI_UsuaID] int  NOT NULL
, [ACTI_UsuaDate] datetime current_timestamp NOT NULL
, CONSTRAINT [PK__ProActiv__F7AA3C9F1E790AC8] PRIMARY KEY ([ACTI_ActiID])
);
CREATE TABLE [paraUsuario] (
  [USUA_Perfil] bit NOT NULL
, [USUA_nombCorto] nvarchar(15)  NOT NULL
, [USUA_pwd] nvarchar(200)  NOT NULL
, [USUA_Paterno] nvarchar(20)  NOT NULL
, [USUA_Materno] nvarchar(20)  NOT NULL
, [USUA_Nombre] nvarchar(100)  NOT NULL
, [USUA_date] datetime current_timestamp NOT NULL
, [USUA_PerfilPadreID] int  NULL
, [USUA_Idioma] nvarchar(20)  NULL
, [USUA_Moneda] nvarchar(3)  NULL
, [USUA_Email] nvarchar(200)  NULL
, [USUA_ModPas] bit NULL
, [USUA_Estatus] nchar(1) DEFAULT 'A'  NOT NULL
, [USUA_usuaID] INTEGER  NOT NULL
, CONSTRAINT [PK__paraUsuario__00000000000001A0] PRIMARY KEY ([USUA_usuaID])
);
CREATE TABLE [paraPermisoVario] (
  [PERC_PercId] INTEGER  NOT NULL
, [PERC_CataID] int  NOT NULL
, [PERC_UsuaId] int  NOT NULL
, [PERC_Estatus] nchar(1) DEFAULT 'A'  NOT NULL
, [PERC_UsuaDate] datetime current_timestamp NOT NULL
, CONSTRAINT [PK_paraPermisoVario] PRIMARY KEY ([PERC_PercId])
);
CREATE TABLE [paraPermiso] (
  [PERM_permID] INTEGER  NOT NULL
, [PERM_UsuaID] int  NOT NULL
, [PERM_ModuID] int  NOT NULL
, [PERM_perfID] int  NULL
, [PERM_Tipo] nchar(1) DEFAULT 'F'  NOT NULL
, [PERM_Acceso] nchar(5)  NOT NULL
, [PERM_Estatus] nchar(1) DEFAULT 'A'  NOT NULL
, [PERM_Date] datetime current_timestamp NOT NULL
, CONSTRAINT [PK__paraPermiso__0000000000000198] PRIMARY KEY ([PERM_permID])
);
CREATE TABLE [paraModulo] (
  [MODU_Clave] nvarchar(20)  NULL
, [MODU_Texto] nvarchar(100)  NOT NULL
, [MODU_Imagen] nvarchar(100)  NULL
, [MODU_Tipo] nchar(1)  NOT NULL
, [MODU_Accion] nvarchar(100)  NULL
, [MODU_TextoIng] nvarchar(100)  NULL
, [MODU_Sistema] nvarchar(20)  NULL
, [MODU_Estatus] nchar(1) DEFAULT 'A'  NOT NULL
, [MODU_Date] datetime current_timestamp NOT NULL
, [MODU_Param1] nvarchar(50)  NULL
, [MODU_moduID] INTEGER  NOT NULL
, CONSTRAINT [PK__paraModulo__0000000000000190] PRIMARY KEY ([MODU_moduID])
);
CREATE TABLE [paraCatalogo] (
  [CATA_Tipo] nvarchar(50)  NOT NULL
, [CATA_Desc1] nvarchar(500)  NULL
, [CATA_Desc2] nvarchar(500)  NULL
, [CATA_Desc3] nvarchar(500)  NULL
, [CATA_Desc4] nvarchar(500)  NULL
, [CATA_Code1] int  NULL
, [CATA_Code2] int  NULL
, [CATA_Estatus] nchar(1) DEFAULT 'A'  NOT NULL
, [CATA_UsuaDate] datetime current_timestamp NOT NULL
, [CATA_UsuaID] int  NOT NULL
, [CATA_CataID] INTEGER  NOT NULL
, CONSTRAINT [PK__paraCatalogo__00000000000006B4] PRIMARY KEY ([CATA_CataID])
);
CREATE TABLE [InvUbicacion] (
  [UBIC_Clave] nvarchar(50)  NOT NULL
, [UBIC_AlmaID] int  NULL
, [UBIC_L1] nvarchar(3)  NULL
, [UBIC_L2] nvarchar(3)  NULL
, [UBIC_L3] nvarchar(3)  NULL
, [UBIC_L4] nvarchar(3)  NULL
, [UBIC_Estatus] nchar(1) DEFAULT 'A'  NOT NULL
, [UBIC_UbicCataID] INTEGER  NOT NULL
, [UBIC_UsuaDate] datetime current_timestamp NULL
, CONSTRAINT [PK_InvUbicacion] PRIMARY KEY ([UBIC_UbicCataID])
);
CREATE TABLE [InvSelectivo] (
  [INSE_Fecha] datetime NOT NULL
, [INSE_ProdID] int  NOT NULL
, [INSE_ContID] int  NULL
, [INSE_Existencia] money NOT NULL
, [INSE_Real] money NULL
, [INSE_AlmacenID] int  NOT NULL
, [INSE_InseID] INTEGER  NOT NULL
, [INSE_Estatus] nchar(1) DEFAULT 'A'  NULL
, [INSE_UsuaDate] datetime current_timestamp NULL
, CONSTRAINT [PK_InvSelectivo] PRIMARY KEY ([INSE_InseID])
);
CREATE TABLE [InvProductoContenedor] (
  [PTCO_contID] int  NOT NULL
, [PTCO_ProdId] int  NOT NULL
, [PTCO_Existencia] money NULL
, [PTCO_Estatus] nchar(1) DEFAULT 'A'  NOT NULL
, [PTCO_PtcoId] INTEGER  NOT NULL
, [PTCO_PvarID] int  NULL
, [PTCO_UsuaDate] datetime current_timestamp NULL
, CONSTRAINT [PK_InvProductoContenedor] PRIMARY KEY ([PTCO_PtcoId])
);
CREATE TABLE [InvProductoAlmacenDemanda] (
  [PTDE_PtalId] int  NOT NULL
, [PTDE_Demanda] money NULL
, [PTDE_Venta] money NULL
, [PTDE_Fecha] datetime NULL
, [PTDE_PtdeId] INTEGER  NOT NULL
, [PTDE_Estatus] nchar(1) DEFAULT 'A'  NULL
, [PTDE_UsuaDate] datetime current_timestamp NULL
, CONSTRAINT [PK_InvProductoAlmacenDemanda] PRIMARY KEY ([PTDE_PtdeId])
);
CREATE TABLE [InvProductoAlmacen] (
  [PTAL_ProdID] int  NULL
, [PTAL_AlmacenCataID] int  NULL
, [PTAL_Existencia] money NULL
, [PTAL_Demanda] money NULL
, [PTAL_Rm] money NULL
, [PTAL_EnOrden] money NULL
, [PTAL_EnOrdenFec] datetime NULL
, [PTAL_Ordenar] money NULL
, [PTAL_TipoRm] nvarchar(20)  NULL
, [PTAL_TiempoMinimo] money NULL
, [PTAL_TiempoMaximo] money NULL
, [PTAL_MesesRm] smallint NULL
, [PTAL_FechaRm] datetime NULL
, [PTAL_Obs] nvarchar(400)  NULL
, [PTAL_CuotaMensual] money NULL
, [PTAL_Estatus] nchar(1) DEFAULT 'A'  NOT NULL
, [PTAL_PtalID] INTEGER  NOT NULL
, [PTAL_UsuaDate] datetime NULL
, [PTAL_UsuaID] int  NULL
, [PTAL_PvarID] int  NULL
, CONSTRAINT [PK_InvProductoAlmacen] PRIMARY KEY ([PTAL_PtalID])
);
CREATE TABLE [InvProdLineaAlmacen] (
  [PLAL_ProdLineaCataID] int  NOT NULL
, [PLAL_AlmacenCataID] int  NOT NULL
, [PLAL_Estatus] nchar(1) DEFAULT 'A'  NOT NULL
, [PLAL_PlalID] INTEGER  NOT NULL
, [PLAL_UsuaDate] datetime current_timestamp NULL
, CONSTRAINT [PK__InvProdLineaAlmacen__0000000000000361] PRIMARY KEY ([PLAL_PlalID])
);
CREATE TABLE [InvMovimientoDet] (
  [MODT_modtID] INTEGER  NOT NULL
, [MODT_MoinID] int  NOT NULL
, [MODT_ProdID] int  NOT NULL
, [MODT_ContID] int  NULL
, [MODT_Cantidad] money NOT NULL
, [MODT_Costo] money NULL
, [MODT_ReferID] int  NULL
, [MODT_Obs] ntext NULL
, [MODT_Estatus] nchar(1) DEFAULT 'A'  NOT NULL
, [MODT_UsuaID] int  NULL
, [MODT_UsuaDate] datetime current_timestamp NULL
, [MODT_PvarID] int  NULL
, CONSTRAINT [PK__InvMovimientoDet__0000000000000688] PRIMARY KEY ([MODT_modtID])
);
CREATE TABLE [InvMovimiento] (
  [MOIN_MoinId] INTEGER  NOT NULL
, [MOIN_AlmacenCataID] int  NOT NULL
, [MOIN_TipoMovCataID] int  NOT NULL
, [MOIN_Folio] int  NOT NULL
, [MOIN_SubFolio] int  NOT NULL
, [MOIN_Fecha] datetime NOT NULL
, [MOIN_Obs] nvarchar(500)  NULL
, [MOIN_Referencia] nvarchar(50)  NULL
, [MOIN_Estatus] nchar(1) DEFAULT 'A'  NOT NULL
, [MOIN_UsuaID] int  NULL
, [MOIN_UsuaDate] datetime current_timestamp NULL
, CONSTRAINT [PK__InvMovimiento__00000000000006BA] PRIMARY KEY ([MOIN_MoinId])
);
CREATE TABLE [InvFisicoDet] (
  [IFDT_IfdtId] INTEGER  NOT NULL
, [IFDT_InfiId] int  NOT NULL
, [IFDT_ProdId] int  NOT NULL
, [IFDT_ContId] int  NULL
, [IFDT_Cantidad] money NOT NULL
, [IFDT_Kardex] money NULL
, [IFDT_Obs] nvarchar(300)  NULL
, [IFDT_Estatus] nchar(1) DEFAULT 'A'  NOT NULL
, [IFDT_UsuaID] int  NULL
, [IFDT_UsuaDate] datetime current_timestamp NULL
, [IFDT_PvarID] int  NULL
, [IFDT_Costo] money NULL
, CONSTRAINT [PK__InvFisicoDet__00000000000006EC] PRIMARY KEY ([IFDT_IfdtId])
);
CREATE TABLE [InvFisico] (
  [INFI_InfiId] INTEGER  NOT NULL
, [INFI_AlmaId] int  NOT NULL
, [INFI_Folio] int  NULL
, [INFI_Fecha] datetime NULL
, [INFI_ASalidaId] int  NULL
, [INFI_AEntradaId] int  NULL
, [INFI_Obs] nvarchar(500)  NULL
, [INFI_Estatus] nchar(1) DEFAULT 'A'  NULL
, [INFI_UsuaID] int  NULL
, [INFI_UsuaDate] datetime current_timestamp NULL
, CONSTRAINT [PK__InvFisico__000000000000071B] PRIMARY KEY ([INFI_InfiId])
);
CREATE TABLE [InvCosto] (
  [CTOC_PtalId] int  NOT NULL
, [CTOC_CostoMes] money NULL
, [CTOC_CostoPr] money NULL
, [CTOC_Entradas] money NULL
, [CTOC_Salidas] money NULL
, [CTOC_InvInicial] money NULL
, [CTOC_Fecha] datetime NULL
, [CTOC_UsuaId] int  NULL
, [CTOC_UsuaDate] datetime current_timestamp NULL
, [CTOC_CtocID] INTEGER  NOT NULL
, [CTOC_Estatus] nchar(1) DEFAULT 'A'  NULL
, CONSTRAINT [PK_InvCosto] PRIMARY KEY ([CTOC_CtocID])
);
CREATE TABLE [InvContenedor] (
  [CONT_clave] nvarchar(100)  NOT NULL
, [CONT_ubicCataID] int  NOT NULL
, [CONT_peso] money NULL
, [CONT_L1] nvarchar(3)  NULL
, [CONT_L2] nvarchar(3)  NULL
, [CONT_L3] nvarchar(3)  NULL
, [CONT_L4] nvarchar(3)  NULL
, [CONT_L5] nvarchar(3)  NULL
, [CONT_Estatus] nchar(1) DEFAULT 'A'  NOT NULL
, [CONT_UsuaDate] datetime current_timestamp NULL
, [CONT_contID] INTEGER  NOT NULL
, CONSTRAINT [PK__InvContenedor__000000000000048C] PRIMARY KEY ([CONT_contID])
);
CREATE TABLE [IngProductoVariable] (
  [PVAR_PvarID] INTEGER  NOT NULL
, [PVAR_ProdID] int  NOT NULL
, [PVAR_CodBarras] nvarchar(20)  NULL
, [PVAR_Valor1] nvarchar(50)  NULL
, [PVAR_Valor2] nvarchar(150)  NULL
, [PVAR_Valor3] nvarchar(50)  NULL
, [PVAR_Estatus] nchar(1) DEFAULT 'A'  NOT NULL
, [PVAR_UsuaID] int  NOT NULL
, [PVAR_UsuaDate] datetime current_timestamp NOT NULL
, CONSTRAINT [PK__IngProductoVariable__000000000000050D] PRIMARY KEY ([PVAR_PvarID])
);
CREATE TABLE [IngProductoContenido] (
  [ICON_IConID] INTEGER  NOT NULL
, [ICON_ProdIDP] int  NOT NULL
, [ICON_PvarIDP] int  NOT NULL
, [ICON_ProdIDH] int  NOT NULL
, [ICON_PvarIDH] int  NOT NULL
, [ICON_Cantidad] money NOT NULL
, [ICON_Estatus] nchar(1) DEFAULT 'A'  NOT NULL
, [ICON_UsuaID] int  NOT NULL
, [ICON_UsuaDate] datetime current_timestamp NOT NULL
, CONSTRAINT [PK_IngProductoContenido] PRIMARY KEY ([ICON_IConID])
);
CREATE TABLE [IngProductoAux] (
  [PROA_ProaID] INTEGER  NOT NULL
, [PROA_ProdID] int  NOT NULL
, [PROA_Tipo] nvarchar(50)  NULL
, [PROA_ValorTxt] nvarchar(300)  NULL
, [PROA_ValorNum] money NULL
, [PROA_Estatus] nchar(1) DEFAULT 'A'  NULL
, [PROA_UsuaID] int  NULL
, [PROA_UsuaDate] datetime current_timestamp NULL
, CONSTRAINT [PK__IngProdu__857E6589A97E1889] PRIMARY KEY ([PROA_ProaID])
);
CREATE TABLE [IngProducto] (
  [PROD_ProdID] INTEGER  NOT NULL
, [PROD_Clave] nvarchar(50)  NOT NULL
, [PROD_Desc2] nvarchar(500)  NULL
, [PROD_Desc3] nvarchar(500)  NULL
, [PROD_CodBarras] nvarchar(20)  NULL
, [PROD_Estatus] nchar(1) DEFAULT 'A'  NULL
, [PROD_UsuaID] int  NULL
, [PROD_UsuaDate] datetime current_timestamp NULL
, [PROD_LineaID] int  NULL
, [PROD_Clas1ID] int  NULL
, [PROD_Clas2ID] int  NULL
, [PROD_Clas3ID] int  NULL
, [PROD_Desc1] nvarchar(500)  NULL
, [PROD_Unidad] nvarchar(25)  NULL
, [PROD_CostoPromedio] money NULL
, [PROD_CostoUltimo] money NULL
, [PROD_EstatusID] int  NULL
, [PROD_PIva] money NULL
, [PROD_DescVenta] nvarchar(500)  NULL
, CONSTRAINT [PK_IngProducto] PRIMARY KEY ([PROD_ProdID])
);
CREATE TABLE [Direccion] (
  [DIRE_DireID] INTEGER  NOT NULL
, [DIRE_ClieID] int  NULL
, [DIRE_ProvID] int  NULL
, [DIRE_Calle] nvarchar(100)  NOT NULL
, [DIRE_Ext] nvarchar(20)  NOT NULL
, [DIRE_Int] nvarchar(20)  NULL
, [DIRE_Colonia] nvarchar(100)  NOT NULL
, [DIRE_CiudadID] int  NULL
, [DIRE_Municipio] nvarchar(50)  NOT NULL
, [DIRE_CP] nvarchar(5)  NULL
, [DIRE_Email] nvarchar(1000)  NULL
, [DIRE_Email2] nvarchar(1000)  NULL
, [DIRE_Telefono] nvarchar(40)  NULL
, [DIRE_Tipo] nvarchar(50) DEFAULT 'FISCAL'  NULL
, [DIRE_Aux1] nvarchar(500)  NULL
, [DIRE_Aux2] nvarchar(500)  NULL
, [DIRE_Estatus] nchar(1) DEFAULT 'A'  NOT NULL
, [DIRE_UsuaDate] datetime current_timestamp NOT NULL
, [DIRE_UsuaID] int  NULL
, CONSTRAINT [PK_Direccion] PRIMARY KEY ([DIRE_DireID])
);
CREATE TABLE [CxpMovimientoDet] (
  [MOCD_MocdID] INTEGER  NOT NULL
, [MOCD_AbonoID] int  NOT NULL
, [MOCD_CargoID] int  NOT NULL
, [MOCD_Monto] money NOT NULL
, [MOCD_Fecha] datetime NOT NULL
, [MOCD_Tc] money DEFAULT 1 NOT NULL
, [MOCD_Estatus] nchar(10) DEFAULT 'A'  NOT NULL
, [MOCD_UsuaID] int  NOT NULL
, [MOCD_UsuaDate] datetime current_timestamp NOT NULL
, CONSTRAINT [PK_CxpMovimientoDet] PRIMARY KEY ([MOCD_MocdID])
);
CREATE TABLE [CxpMovimiento] (
  [MOCC_MoccID] INTEGER  NOT NULL
, [MOCC_ProvID] int  NULL
, [MOCC_TipoID] int  NULL
, [MOCC_OdcpID] int  NULL
, [MOCC_Fecha] datetime NULL
, [MOCC_Vence] datetime NULL
, [MOCC_Aplica] datetime NULL
, [MOCC_Monto] money NULL
, [MOCC_Saldo] money NULL
, [MOCC_Iva] money NULL
, [MOCC_Folio] int  NULL
, [MOCC_Obs] nvarchar(250)  NULL
, [MOCC_ClasID] int  NULL
, [MOCC_Referencia] nvarchar(600)  NULL
, [MOCC_RetIva] money DEFAULT 0 NULL
, [MOCC_RetIsr] money DEFAULT 0 NULL
, [MOCC_Estatus] nvarchar(20) DEFAULT 'A'  NULL
, [MOCC_UsuaID] int  NULL
, [MOCC_UsuaDate] datetime current_timestamp NULL
, CONSTRAINT [PK_CxpMovimiento] PRIMARY KEY ([MOCC_MoccID])
);
CREATE TABLE [CxpLineaCredito] (
  [LCRE_LcreID] INTEGER  NOT NULL
, [LCRE_ProvID] int  NULL
, [LCRE_Fecha] datetime current_timestamp NOT NULL
, [LCRE_Concepto] nvarchar(50)  NOT NULL
, [LCRE_Monto] money DEFAULT 0 NOT NULL
, [LCRE_Plazo] smallint DEFAULT 0 NULL
, [LCRE_MonedaID] int  NULL
, [LCRE_Estatus] nchar(1) DEFAULT 'A'  NOT NULL
, [LCRE_UsuaID] int  NOT NULL
, [LCRE_UsuaDate] datetime current_timestamp NOT NULL
, CONSTRAINT [PK_opLineaCreditop] PRIMARY KEY ([LCRE_LcreID])
);
CREATE TABLE [CxpFactura] (
  [PCFD_PcfdID] INTEGER  NOT NULL
, [PCFD_MoccID] int  NULL
, [PCFD_CFDxml] ntext NOT NULL
, [PCFD_Folio] nvarchar(50)  NULL
, [PCFD_Uuid] nvarchar(100)  NOT NULL
, [PCFD_Pdf] image NULL
, [PCFD_Estatus] nchar(1) DEFAULT 'A'  NOT NULL
, [PCFD_UsuaID] int  NOT NULL
, [PCFD_UsuaDate] datetime current_timestamp NOT NULL
, CONSTRAINT [PK_CxpFactura] PRIMARY KEY ([PCFD_PcfdID])
);
CREATE TABLE [CxcTipoCambio] (
  [TICA_TicaID] INTEGER  NOT NULL
, [TICA_MonedaID] int  NOT NULL
, [TICA_TC] money NOT NULL
, [TICA_Fecha] datetime NOT NULL
, [TICA_UsuaDate] datetime current_timestamp NOT NULL
);
CREATE TABLE [CxcMovimientoDet] (
  [MOCD_MocdID] INTEGER  NOT NULL
, [MOCD_AbonoID] int  NOT NULL
, [MOCD_CargoID] int  NOT NULL
, [MOCD_Monto] money NOT NULL
, [MOCD_Fecha] datetime NOT NULL
, [MOCD_Tc] money DEFAULT 1 NOT NULL
, [MOCD_CargoNvoSaldo] money NULL
, [MOCD_Parcialidad] smallint NULL
, [MOCD_Estatus] nchar(10) DEFAULT 'A'  NOT NULL
, [MOCD_UsuaID] int  NOT NULL
, [MOCD_UsuaDate] datetime current_timestamp NOT NULL
, CONSTRAINT [PK_CxcMovimientoDet] PRIMARY KEY ([MOCD_MocdID])
);
CREATE TABLE [CxcMovimiento] (
  [MOCC_MoccID] INTEGER  NOT NULL
, [MOCC_ClieID] int  NULL
, [MOCC_TipoID] int  NULL
, [MOCC_FactID] int  NULL
, [MOCC_Fecha] datetime NULL
, [MOCC_Vence] datetime NULL
, [MOCC_Aplica] datetime NULL
, [MOCC_Monto] money NULL
, [MOCC_Saldo] money NULL
, [MOCC_Iva] money NULL
, [MOCC_Folio] int  NULL
, [MOCC_Obs] nvarchar(250)  NULL
, [MOCC_ClasID] int  NULL
, [MOCC_Referencia] nvarchar(250)  NULL
, [MOCC_RetIva] money DEFAULT 0 NULL
, [MOCC_RetIsr] money DEFAULT 0 NULL
, [MOCC_Tc] money DEFAULT 1 NULL
, [MOCC_MonedaID] int DEFAULT 4  NULL
, [MOCC_Estatus] nvarchar(20) DEFAULT 'A'  NULL
, [MOCC_UsuaID] int  NULL
, [MOCC_UsuaDate] datetime current_timestamp NULL
, CONSTRAINT [PK_CxcMovimiento] PRIMARY KEY ([MOCC_MoccID])
);
CREATE TABLE [CxcLineaCredito] (
  [LCRE_LcreID] INTEGER  NOT NULL
, [LCRE_Tipo] nvarchar(50) DEFAULT 'LINEA'  NULL
, [LCRE_ClieID] int  NULL
, [LCRE_LpreID] int  NULL
, [LCRE_LineaID] int  NULL
, [LCRE_Fecha] datetime current_timestamp NOT NULL
, [LCRE_Concepto] nvarchar(50)  NOT NULL
, [LCRE_Monto] money DEFAULT 0 NOT NULL
, [LCRE_Plazo] smallint DEFAULT 0 NULL
, [LCRE_Descuento] money NULL
, [LCRE_MonedaID] int DEFAULT 4  NULL
, [LCRE_Estatus] nchar(1) DEFAULT 'A'  NOT NULL
, [LCRE_UsuaID] int  NOT NULL
, [LCRE_UsuaDate] datetime current_timestamp NOT NULL
, CONSTRAINT [PK_opLineaCredito] PRIMARY KEY ([LCRE_LcreID])
);
CREATE TABLE [CxcFacturaDirecta] (
  [FADI-FadiID] INTEGER  NOT NULL
, [FADI_FactID] int  NOT NULL
, [FADI_SatClave] nvarchar(10)  NOT NULL
, [FADI_SatUnidad] nvarchar(10)  NOT NULL
, [FADI_RetIva] money DEFAULT 0 NOT NULL
, [FADI_RetIsr] money DEFAULT 0 NOT NULL
, [FADI_Iva] money NOT NULL
, [FADI_Cantidad] money NOT NULL
, [FADI_Precio] money NOT NULL
, [FADI_Descuento] money NULL
, [FADI_Clave] nvarchar(50)  NULL
, [FADI_Descripcion] nvarchar(1000)  NULL
, [FADI_Estatus] nchar(1) DEFAULT 'A'  NOT NULL
, [FADI_UsuaDate] datetime current_timestamp NOT NULL
, [FADI_UsuaID] int  NOT NULL
, CONSTRAINT [PK_CxcFacturaDirecta] PRIMARY KEY ([FADI-FadiID])
);
CREATE TABLE [CxcFacturaCancelada] (
  [CANC_CancID] INTEGER  NOT NULL
, [CANC_FactID] int  NOT NULL
, [CANC_Uuid] nvarchar(100)  NULL
, [CANC_Codigo] nchar(10)  NULL
, [CANC_Acuse] ntext NULL
, [CANC_Motivo] nvarchar(250)  NULL
, [CANC_Detalle] nvarchar(600)  NULL
, [CANC_UsuaDate] datetime current_timestamp NOT NULL
, [CANC_PacDate] datetime NULL
, CONSTRAINT [PK_CxcFacturaCancela] PRIMARY KEY ([CANC_CancID])
);
CREATE TABLE [CxcFactura] (
  [FACT_FactID] INTEGER  NOT NULL
, [FACT_SerieID] int  NOT NULL
, [FACT_PediID] int  NOT NULL
, [FACT_ClieID] int  NOT NULL
, [FACT_DireID] int  NOT NULL
, [FACT_ClasID] int  NOT NULL
, [FACT_Num] int  NOT NULL
, [FACT_LcreID] int  NULL
, [FACT_Fecha] datetime NOT NULL
, [FACT_Venc] datetime NULL
, [FACT_Flete] money DEFAULT 0 NOT NULL
, [FACT_SubTotal] money NOT NULL
, [FACT_Descuento] money NOT NULL
, [FACT_Iva] money NOT NULL
, [FACT_Total] money NOT NULL
, [FACT_Tc] money DEFAULT 1 NOT NULL
, [FACT_CFDxml] ntext NULL
, [FACT_CFDCadena] ntext NULL
, [FACT_Uuid] nvarchar(100)  NULL
, [FACT_TimbID] int  NULL
, [FACT_Notas] nvarchar(500)  NULL
, [FACT_Referencia] nvarchar(200)  NULL
, [FACT_MonedaID] int DEFAULT 4  NULL
, [FACT_Estatus] nvarchar(50) DEFAULT 'ACTIVA'  NOT NULL
, [FACT_UsuaID] int  NOT NULL
, [FACT_UsuaDate] datetime current_timestamp NOT NULL
, [FACT_33Uso] nvarchar(3) DEFAULT 'P01'  NULL
, [FACT_33MetodoPago] nvarchar(3) DEFAULT 'PPD'  NULL
, [FACT_33FormaPago] nvarchar(2) DEFAULT '99'  NULL
, CONSTRAINT [PK_CxcFactura] PRIMARY KEY ([FACT_FactID])
);
CREATE TABLE [CxcCfdiDocRel] (
  [DORE_DoreID] INTEGER  NOT NULL
, [DORE_FactID] int  NOT NULL
, [DORE_FacRelID] int  NOT NULL
, [DORE_Tipo] nvarchar(50)  NOT NULL
, [DORE_Notas] nvarchar(500)  NULL
, [DORE_Estatus] nchar(1) DEFAULT 'A'  NOT NULL
, [DORE_UsuaDate] datetime current_timestamp NOT NULL
, [DORE_UsuaID] int  NOT NULL
, CONSTRAINT [PK_CxcCfdiDocRel] PRIMARY KEY ([DORE_DoreID])
);
CREATE TABLE [Contacto] (
  [CONT_ContID] INTEGER  NOT NULL
, [CONT_ClieID] int  NOT NULL
, [CONT_ProvID] int  NULL
, [CONT_Nombre] nvarchar(200)  NOT NULL
, [CONT_Cargo] nvarchar(200)  NULL
, [CONT_Email] nvarchar(60)  NULL
, [CONT_Telefono] nvarchar(100)  NULL
, [CONT_Horario] nvarchar(100)  NULL
, [CONT_Estatus] nchar(1) DEFAULT 'A'  NOT NULL
, [CONT_UsuaID] int  NULL
, [CONT_UsuaDate] datetime current_timestamp NOT NULL
, CONSTRAINT [PK_opContacto] PRIMARY KEY ([CONT_ContID])
);
CREATE TABLE [ComProveedor] (
  [PROV_ProvID] INTEGER  NOT NULL
, [PROV_clave] int  NULL
, [PROV_Nombre] nvarchar(250)  NOT NULL
, [PROV_RFC] nvarchar(15)  NULL
, [PROV_RefBanc] nvarchar(250)  NULL
, [PROV_TipoPersona] nvarchar(20)  NULL
, [PROV_MetodoPago] nvarchar(25) DEFAULT 'NO IDENTIFICADO' NULL
, [PROV_CtaPago] nvarchar(25)  NULL
, [PROV_Estatus] nchar(1) DEFAULT 'A'  NOT NULL
, [PROV_UsuaID] int  NOT NULL
, [PROV_UsuaDate] datetime current_timestamp NOT NULL
, CONSTRAINT [PK_PROVnte] PRIMARY KEY ([PROV_ProvID])
);
CREATE TABLE [ComProductoProveedor] (
  [PTPR_PtprID] INTEGER  NOT NULL
, [PTPR_ProdID] int  NOT NULL
, [PTPR_PvarID] int DEFAULT 0  NULL
, [PTPR_ProvID] int  NOT NULL
, [PTPR_Default] bit DEFAULT 0 NOT NULL
, [PTPR_ClaveProv] nvarchar(50)  NULL
, [PTPR_MonedaID] int  NOT NULL
, [PTPR_UnidadID] int  NULL
, [PTPR_Precio] money NULL
, [PTPR_Fecha] datetime current_timestamp NOT NULL
, [PTPR_Obs] nvarchar(500)  NULL
, [PTPR_Estatus] nchar(1) DEFAULT 'A'  NOT NULL
, [PTPR_UsuaID] int  NOT NULL
, [PTPR_UsuaDate] datetime current_timestamp NOT NULL
, CONSTRAINT [PK_ComProductoProveedor] PRIMARY KEY ([PTPR_PtprID])
);
CREATE TABLE [ComOrdenCompraDet] (
  [OCDT_OcdtID] INTEGER  NOT NULL
, [OCDT_OdcpID] int  NOT NULL
, [OCDT_PtprID] int  NOT NULL
, [OCDT_MonedaID] int  NOT NULL
, [OCDT_UnidadID] int  NULL
, [OCDT_PvarID] int  NULL
, [OCDT_Cantidad] money NOT NULL
, [OCDT_CantRecibida] money DEFAULT 0 NULL
, [OCDT_CantFacturada] money NULL
, [OCDT_FechaEnt] datetime NULL
, [OCDT_Precio] money NULL
, [OCDT_DescP] money NULL
, [OCDT_IvaP] money NULL
, [OCDT_Obs] nvarchar(500)  NULL
, [OCDT_Descripcion] nvarchar(500)  NULL
, [OCDT_ValorAux] nvarchar(400)  NULL
, [OCDT_Obs2] nvarchar(500)  NULL
, [OCDT_Estatus] nchar(1) DEFAULT 'A'  NOT NULL
, [OCDT_UsuaID] int  NOT NULL
, [OCDT_UsuaDate] datetime current_timestamp NOT NULL
, CONSTRAINT [PK_ComOrdenCompraDet] PRIMARY KEY ([OCDT_OcdtID])
);
CREATE TABLE [ComOrdenCompra] (
  [ODCP_OdcpID] INTEGER  NOT NULL
, [ODCP_AlmacenID] int  NULL
, [ODCP_ProvID] int  NULL
, [ODCP_DireID] int  NULL
, [ODCP_Folio] money NULL
, [ODCP_Fecha] datetime current_timestamp NULL
, [ODCP_Obs] nvarchar(500)  NULL
, [ODCP_Solicitante] nvarchar(200)  NULL
, [ODCP_SubTotal] money NULL
, [ODCP_Descuento] money NULL
, [ODCP_Iva] money NULL
, [ODCP_Total] money NULL
, [ODCP_Factura] nvarchar(50)  NULL
, [ODCP_FacturaFecha] datetime NULL
, [ODCP_Referencia] nvarchar(50)  NULL
, [ODCP_EntID] int  NULL
, [ODCP_Aux1] nvarchar(100)  NULL
, [ODCP_Estatus] nvarchar(50) DEFAULT 'A'  NULL
, [ODCP_UsuaID] int  NULL
, [ODCP_UsuaDate] datetime current_timestamp NULL
, CONSTRAINT [PK_ComOrdenCompra] PRIMARY KEY ([ODCP_OdcpID])
);
CREATE TABLE [cComplemento] (
  [COMP_CompID] INTEGER  NOT NULL
, [COMP_Tipo] nvarchar(50)  NOT NULL
, [COMP_TipoID] int  NOT NULL
, [COMP_Valor1] nvarchar(500)  NULL
, [COMP_Valor2] nvarchar(200)  NULL
, [COMP_Valor3] nvarchar(200)  NULL
, [COMP_Estatus] nchar(1) DEFAULT 'A'  NOT NULL
, [COMP_UsuaID] int  NOT NULL
, [COMP_UsuaDate] datetime current_timestamp NOT NULL
, CONSTRAINT [PK_cComplemento] PRIMARY KEY ([COMP_CompID])
);
CREATE TABLE [cAsignar] (
  [ASIG_AsigID] INTEGER  NOT NULL
, [ASIG_Origen] nvarchar(50)  NOT NULL
, [ASIG_OrigenID] int  NOT NULL
, [ASIG_Destino] nvarchar(50)  NOT NULL
, [ASIG_DestinoID] int  NOT NULL
, [ASIG_Valor1] nvarchar(100)  NULL
, [ASIG_Valor2] nvarchar(100)  NULL
, [ASIG_Valor3] nvarchar(100)  NULL
, [ASIG_Estatus] nchar(1) DEFAULT 'A'  NOT NULL
, [ASIG_UsuaID] int  NOT NULL
, [ASIG_UsuaDate] datetime current_timestamp NOT NULL
, CONSTRAINT [PK_cAsignar] PRIMARY KEY ([ASIG_AsigID])
);
CREATE TABLE [VtaCajaDet] (
  [CAJD_CajdID] INTEGER  NOT NULL
, [CAJD_CajaID] int  NOT NULL
, [CAJD_MonedaID] int  NOT NULL
, [CAJD_FCobroID] int  NOT NULL
, [CAJD_Importe] money NOT NULL
, [CAJD_PediID] int  NULL
, [CAJD_Estatus] nchar(1) DEFAULT 'A'  NOT NULL
, [CAJD_UsuaID] int  NOT NULL
, [CAJD_UsuaDate] datetime current_timestamp NOT NULL
, [CAJD_Referencia] nvarchar(100)  NULL
, [CAJD_ReferID] int  NULL
, CONSTRAINT [PK__VtaCajaDet__000000000000063C] PRIMARY KEY ([CAJD_CajdID])
);
CREATE TABLE [VtaCaja] (
  [CAJA_CajaID] INTEGER  NOT NULL
, [CAJA_NombreID] int  NOT NULL
, [CAJA_FechaApertura] datetime current_timestamp NOT NULL
, [CAJA_FechaCierre] datetime NULL
, [CAJA_UsuaID] int  NOT NULL
, [CAJA_UsuaDate] datetime current_timestamp NOT NULL
, [CAJA_Estatus] nchar(15) DEFAULT 'ABIERTA'  NULL
, CONSTRAINT [PK__VtaCaja__0000000000000659] PRIMARY KEY ([CAJA_CajaID])
);
CREATE TABLE [paraBdSincroniza] (
  [BDSI_UsuaID] int  NULL
, [BDSI_Esquema] datetime NULL
, [BDSI_Sistema] int  NULL
, [BDSI_Datos] datetime NULL
);
CREATE TABLE [paraBdEsquema] (
	[BDES_BdesID] int NOT NULL
,	[BDES_Fecha] datetime current_timestamp NOT NULL
,	[BDES_Script] nvarchar(900) NOT NULL
, CONSTRAINT [PK__paraBdEsquema__0000000000000659] PRIMARY KEY ([BDES_BdesID])
);

CREATE INDEX [PkUbicNoRepetidos] ON [InvUbicacion] ([UBIC_Clave] ASC,[UBIC_AlmaID] ASC,[UBIC_Estatus] ASC);
CREATE UNIQUE INDEX [NoRepetidosInvProductoContenedor] ON [InvProductoContenedor] ([PTCO_contID] ASC,[PTCO_ProdId] ASC,[PTCO_Estatus] ASC,[PTCO_PvarID] ASC);
CREATE UNIQUE INDEX [PTALNoRepetidos] ON [InvProductoAlmacen] ([PTAL_ProdID] ASC,[PTAL_AlmacenCataID] ASC,[PTAL_Estatus] ASC,[PTAL_PvarID] ASC);
CREATE INDEX [PK_ContNoRepetidos] ON [InvContenedor] ([CONT_clave] ASC,[CONT_ubicCataID] ASC,[CONT_Estatus] ASC);
CREATE UNIQUE INDEX [IX_IngProductoVariableProdIdValorUnico] ON [IngProductoVariable] ([PVAR_ProdID] ASC,[PVAR_Valor1] ASC,[PVAR_Valor2] ASC,[PVAR_Estatus] ASC);
CREATE INDEX [_dta_index_IngProducto_56_1557580587__K9_K2_K5_K6_1_13] ON [IngProducto] ([PROD_LineaID] ASC,[PROD_Clave] ASC,[PROD_CodBarras] ASC,[PROD_Estatus] ASC);
CREATE UNIQUE INDEX [NoDuplicadosClaveEstatus] ON [IngProducto] ([PROD_Clave] ASC,[PROD_Estatus] ASC);
COMMIT;

