Ext.define("Com.GatotKaca.ERP.module.GeneralSetup.store.Company",{extend:"Com.GatotKaca.ERP.store.Base",model:"Com.GatotKaca.ERP.model.Company",primary:"company_id",initial:"company_name",proxy:{type:"ajax",api:{read:BASE_URL+"company/getlist",destroy:BASE_URL+"company/delete"},actionMethods:{read:"POST"},extraParams:{status:"all"},reader:{type:"json",root:"data",successProperty:"success",totalProperty:"total"},writer:{type:"json",writeAllFields:true,root:"data",encode:true}}});