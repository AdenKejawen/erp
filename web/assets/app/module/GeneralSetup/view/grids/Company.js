Ext.define("Com.GatotKaca.ERP.module.GeneralSetup.view.grids.Company",{extend:"Ext.grid.Panel",store:"Com.GatotKaca.ERP.module.GeneralSetup.store.Company",alias:"widget.gridcompany",id:"gridcompany",layout:{type:"fit"},bodyStyle:"background : transparent",title:"Company List",border:true,columns:[{xtype:"rownumberer",width:"11%"},{text:"Code",dataIndex:"company_code",width:"17%"},{text:"Parent",dataIndex:"company_pname",width:"35%"},{text:"Name",dataIndex:"company_name",width:"35%"}],tbar:[{fieldLabel:'<span data-qtip="Type a keyword and press enter">Search</span>',xtype:"textfield",emptyText:"Type a keyword and press enter",enableKeyEvents:true,labelWidth:55,width:"100%",action:"search"}],bbar:["->",{text:"Refresh",xtype:"button",iconCls:"icon-arrow_refresh",action:"refresh"}]});