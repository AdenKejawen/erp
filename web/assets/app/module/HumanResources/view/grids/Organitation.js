Ext.define("Com.GatotKaca.ERP.module.HumanResources.view.grids.Organitation",{extend:"Ext.grid.Panel",alias:"widget.gridorganitation",store:"Com.GatotKaca.ERP.module.HumanResources.store.Organitation",id:"gridorganitation",layout:{type:"fit"},bodyStyle:"background : transparent",title:"Organitation List",border:true,columns:[{xtype:"rownumberer",width:"5%"},{text:"From",dataIndex:"org_start",xtype:"datecolumn",format:DATE_FORMAT,width:"9%"},{text:"To",dataIndex:"org_end",xtype:"datecolumn",format:DATE_FORMAT,width:"9%"},{text:"Scope",dataIndex:"org_categories",width:"21%"},{text:"Position",dataIndex:"org_position",width:"21%"},{text:"Name",dataIndex:"org_name",width:"33%"}]});