Ext.define("GatotKacaErp.module.HumanResources.view.grids.CareerHistory",{extend:"Ext.grid.Panel",alias:"widget.gridcareerhistory",store:"GatotKacaErp.module.HumanResources.store.CareerHistory",id:"gridcareerhistory",layout:{type:"fit"},bodyStyle:"background : transparent",title:"Career List",border:true,columns:[{xtype:"rownumberer",width:"5%"},{text:"Date",dataIndex:"career_date",xtype:"datecolumn",format:"d-m-Y",width:"15%"},{text:"Number",dataIndex:"career_refno",width:"25%"},{text:"Old JobTitle",dataIndex:"old_jobtitlename",width:"27%"},{text:"New JobTitle",dataIndex:"new_jobtitlename",width:"27%"}]});