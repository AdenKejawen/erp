Ext.define("Com.GatotKaca.ERP.store.Group",{extend:"Ext.data.Store",model:"Com.GatotKaca.ERP.module.Utilities.model.Group",autoLoad:false,autoSync:false,proxy:{type:"ajax",api:{read:BASE_URL+"utilities/role/getgroup"},actionMethods:{read:"POST"},reader:{type:"json",root:"data",successProperty:"success"},writer:{type:"json",writeAllFields:true,root:"data",encode:true}}});