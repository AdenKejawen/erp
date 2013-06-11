Ext.define("Ext.data.reader.Reader",{requires:["Ext.data.ResultSet","Ext.XTemplate"],alternateClassName:["Ext.data.Reader","Ext.data.DataReader"],mixins:{observable:"Ext.util.Observable"},totalProperty:"total",successProperty:"success",root:"",implicitIncludes:true,readRecordsOnFailure:true,isReader:true,applyDefaults:true,lastFieldGeneration:null,constructor:function(a){var b=this;b.mixins.observable.constructor.call(b,a);b.fieldCount=0;b.model=Ext.ModelManager.getModel(b.model);b.accessExpressionFn=Ext.Function.bind(b.createFieldAccessExpression,b);if(b.model&&b.model.prototype.fields){b.buildExtractors()}this.addEvents("exception")},setModel:function(a,c){var b=this;b.model=Ext.ModelManager.getModel(a);if(a){b.buildExtractors(true)}if(c&&b.proxy){b.proxy.setModel(b.model,true)}},read:function(a){var b;if(a){b=a.responseText?this.getResponseData(a):this.readRecords(a)}return b||this.nullResultSet},readRecords:function(c){var d=this,h,b,a,f,e,g,i;if(d.lastFieldGeneration!==d.model.prototype.fields.generation){d.buildExtractors(true)}d.rawData=c;c=d.getData(c);h=true;b=0;a=[];if(d.successProperty){g=d.getSuccess(c);if(g===false||g==="false"){h=false}}if(d.messageProperty){i=d.getMessage(c)}if(d.readRecordsOnFailure||h){f=Ext.isArray(c)?c:d.getRoot(c);if(f){e=f.length}if(d.totalProperty){g=parseInt(d.getTotal(c),10);if(!isNaN(g)){e=g}}if(f){a=d.extractData(f);b=a.length}}return new Ext.data.ResultSet({total:e||b,count:b,records:a,success:h,message:i})},extractData:function(j){var h=this,d=[],b=h.model,a=j.length,e,c,g,f;if(!j.length&&Ext.isObject(j)){j=[j];a=1}for(f=0;f<a;f++){c=j[f];if(!c.isModel){g=new b(undefined,h.getId(c),c,e={});g.phantom=false;h.convertRecordData(e,c,g);d.push(g);if(h.implicitIncludes){h.readAssociated(g,c)}}else{d.push(c)}}return d},readAssociated:function(g,e){var d=g.associations.items,f=0,a=d.length,c,b,j,h;for(;f<a;f++){c=d[f];b=this.getAssociatedDataRoot(e,c.associationKey||c.name);if(b){h=c.getReader();if(!h){j=c.associatedModel.proxy;if(j){h=j.getReader()}else{h=new this.constructor({model:c.associatedName})}}c.read(g,h,b)}}},getAssociatedDataRoot:function(b,a){return b[a]},getFields:function(){return this.model.prototype.fields.items},getData:Ext.identityFn,getRoot:Ext.identityFn,getResponseData:function(a){Ext.Error.raise("getResponseData must be implemented in the Ext.data.reader.Reader subclass")},onMetaChange:function(e){var d=this,b=e.fields||d.getFields(),c,a;d.metaData=e;d.root=e.root||d.root;d.idProperty=e.idProperty||d.idProperty;d.totalProperty=e.totalProperty||d.totalProperty;d.successProperty=e.successProperty||d.successProperty;d.messageProperty=e.messageProperty||d.messageProperty;a=e.clientIdProperty;if(d.model){d.model.setFields(b,d.idProperty,a);d.setModel(d.model,true)}else{c=Ext.define("Ext.data.reader.Json-Model"+Ext.id(),{extend:"Ext.data.Model",fields:b,clientIdProperty:a});if(d.idProperty){c.idProperty=d.idProperty}d.setModel(c,true)}},getIdProperty:function(){return this.idProperty||this.model.prototype.idProperty},buildExtractors:function(b){var f=this,i=f.getIdProperty(),h=f.totalProperty,e=f.successProperty,g=f.messageProperty,d,c,a;if(b===true){delete f.convertRecordData}if(f.convertRecordData){return}if(h){f.getTotal=f.createAccessor(h)}if(e){f.getSuccess=f.createAccessor(e)}if(g){f.getMessage=f.createAccessor(g)}if(i){c=f.model.prototype.fields.get(i);if(c){a=c.mapping;i=(a!==undefined&&a!==null)?a:i}d=f.createAccessor(i);f.getId=function(j){var k=d.call(f,j);return(k===undefined||k==="")?null:k}}else{f.getId=function(){return null}}f.convertRecordData=f.buildRecordDataExtractor();f.lastFieldGeneration=f.model.prototype.fields.generation},recordDataExtractorTemplate:["var me = this\n","    ,fields = me.model.prototype.fields\n","    ,value\n","    ,internalId\n",'<tpl for="fields">','    ,__field{#} = fields.get("{name}")\n',"</tpl>",";\n","return function(dest, source, record) {\n",'<tpl for="fields">','    value = {[ this.createFieldAccessExpression(values, "__field" + xindex, "source") ]};\n','<tpl if="hasCustomConvert">','    dest["{name}"] = value === undefined ? __field{#}.convert(__field{#}.defaultValue, record) : __field{#}.convert(value, record);\n','<tpl elseif="defaultValue !== undefined">',"    if (value === undefined) {\n","        if (me.applyDefaults) {\n",'<tpl if="convert">','            dest["{name}"] = __field{#}.convert(__field{#}.defaultValue, record);\n',"<tpl else>",'            dest["{name}"] = __field{#}.defaultValue\n',"</tpl>","        };\n","    } else {\n",'<tpl if="convert">','        dest["{name}"] = __field{#}.convert(value, record);\n',"<tpl else>",'        dest["{name}"] = value;\n',"</tpl>","    };\n","<tpl else>","    if (value !== undefined) {\n",'<tpl if="convert">','        dest["{name}"] = __field{#}.convert(value, record);\n',"<tpl else>",'        dest["{name}"] = value;\n',"</tpl>","    }\n","</tpl>","</tpl>",'<tpl if="clientIdProp">','    if (record && (internalId = {[ this.createFieldAccessExpression({mapping: values.clientIdProp}, null, "source") ]})) {\n','        record.{["internalId"]} = internalId;\n',"    }\n","</tpl>","};"],buildRecordDataExtractor:function(){var c=this,a=c.model.prototype,b={clientIdProp:a.clientIdProperty,fields:a.fields.items};c.recordDataExtractorTemplate.createFieldAccessExpression=c.accessExpressionFn;return Ext.functionFactory(c.recordDataExtractorTemplate.apply(b)).call(c)},destroyReader:function(){var a=this;delete a.proxy;delete a.model;delete a.convertRecordData;delete a.getId;delete a.getTotal;delete a.getSuccess;delete a.getMessage}},function(){var a=this.prototype;Ext.apply(a,{nullResultSet:new Ext.data.ResultSet({total:0,count:0,records:[],success:true,message:""}),recordDataExtractorTemplate:new Ext.XTemplate(a.recordDataExtractorTemplate)})});