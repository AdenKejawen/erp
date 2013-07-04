Ext.define("Com.GatotKaca.ERP.module.GeneralSetup.view.forms.Education",{extend:"Ext.form.Panel",alias:"widget.formeducation",id:"formeducation",border:true,autoHeight:true,layout:{type:"vbox",align:"stretch"},plugins:{ptype:"datatip"},title:"Education Detail",bodyStyle:"padding: 5px; background : transparent;",labelWidth:55,width:"100%",items:[{name:"education_id",xtype:"hidden"},{xtype:"fieldset",title:"Education Information",defaults:{fieldAlign:"left",anchor:"100%",layout:{type:"hbox"}},items:[{xtype:"fieldcontainer",fieldLabel:"Description",combineErrors:true,hideLabel:true,beforeLabelTextTpl:REQUIRED,msgTarget:"side",layout:{type:"hbox"},defaults:{hideLabel:false,labelWidth:77},items:[{fieldLabel:"Name",xtype:"textfield",beforeLabelTextTpl:REQUIRED,emptyText:"Education Name",tooltip:"Education Name",flex:3,allowBlank:false,name:"education_name",margins:"0px 5px 0px 0px"},{fieldLabel:"Level",beforeLabelTextTpl:REQUIRED,xtype:"numberfield",name:"education_level",tooltip:"Education Level",allowBlank:false,maxValue:99,minValue:1,flex:1,margins:"0px 5px 0px 0px"},{fieldLabel:"Status",tooltip:"Is Active?",beforeLabelTextTpl:REQUIRED,xtype:"checkboxfield",name:"education_status",flex:1,checked:true}]}]}],tbar:[{text:"Save",iconCls:"icon-disk",action:"save"},{text:"Reset",iconCls:"icon-error",action:"reset"}]});