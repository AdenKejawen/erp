Ext.define("Com.GatotKaca.ERP.store.Language",{extend:"Ext.data.Store",model:"Com.GatotKaca.ERP.model.Language",autoLoad:false,autoSync:false,proxy:{type:"ajax",api:{read:BASE_URL+"language/getlist"},actionMethods:{read:"POST"},extraParams:{query:""},reader:{type:"json",root:"data",successProperty:"success"},writer:{type:"json",writeAllFields:true,root:"data",encode:true}}});