Ext.define("Com.GatotKaca.ERP.module.HumanResources.view.grids.Experience",{extend:"Ext.grid.Panel",alias:"widget.gridexperience",store:"Com.GatotKaca.ERP.module.HumanResources.store.Experience",id:"gridexperience",layout:{type:"fit"},bodyStyle:"background : transparent",title:"Experiences List",border:true,columns:[{xtype:"rownumberer",width:"5%"},{text:"From",dataIndex:"experience_start",xtype:"datecolumn",format:DATE_FORMAT,width:"11%"},{text:"To",dataIndex:"experience_end",xtype:"datecolumn",format:DATE_FORMAT,width:"11%"},{text:"Job Title",dataIndex:"experience_jobtitle",width:"33%"},{text:"Company",dataIndex:"experience_company",width:"39%"}]});