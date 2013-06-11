Ext.define("GatotKacaErp.module.GeneralSetup.view.grids.JobLevel",{extend:"Ext.grid.Panel",store:"GatotKacaErp.module.GeneralSetup.store.JobLevel",requires:["Ext.ux.CheckColumn"],alias:"widget.gridjoblevel",id:"gridjoblevel",layout:{type:"fit"},bodyStyle:"background : transparent",title:"Job Level List",border:true,columns:[{xtype:"rownumberer",width:"11%"},{text:"Name",dataIndex:"joblevel_name",width:"50%"},{text:"Level",dataIndex:"joblevel_level",width:"17%"},{text:"Active?",dataIndex:"joblevel_status",width:"17%",xtype:"checkcolumn",processEvent:function(){return false}}],tbar:[{fieldLabel:"Search",xtype:"textfield",enableKeyEvents:true,labelWidth:55,width:"100%",action:"search"}],bbar:["->",{text:"Refresh",xtype:"button",iconCls:"icon-arrow_refresh",action:"refresh"}]});