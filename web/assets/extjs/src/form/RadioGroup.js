Ext.define("Ext.form.RadioGroup",{extend:"Ext.form.CheckboxGroup",alias:"widget.radiogroup",requires:["Ext.form.field.Radio"],allowBlank:true,blankText:"You must select one item in this group",defaultType:"radiofield",groupCls:Ext.baseCSSPrefix+"form-radio-group",getBoxes:function(a){return this.query("[isRadio]"+(a||""))},checkChange:function(){var b=this.getValue(),a=Ext.Object.getKeys(b)[0];if(Ext.isArray(b[a])){return}this.callParent(arguments)},setValue:function(d){var h,f,e,g,c,a,b;if(Ext.isObject(d)){for(b in d){if(d.hasOwnProperty(b)){h=d[b];f=this.items.first();e=f?f.getFormId():null;g=Ext.form.RadioManager.getWithValue(b,h,e).items;a=g.length;for(c=0;c<a;++c){g[c].setValue(true)}}}}return this}});