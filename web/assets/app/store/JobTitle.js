Ext.define("GatotKacaErp.store.JobTitle",{extend:"Ext.data.Store",model:"GatotKacaErp.model.JobTitle",autoLoad:false,autoSync:false,proxy:{type:"ajax",api:{read:BASE_URL+"jobtitle/getlist"},actionMethods:{read:"POST"},reader:{type:"json",root:"data",successProperty:"success"},writer:{type:"json",writeAllFields:true,root:"data",encode:true}}});