Ext.define("Ext.rtl.form.field.Spinner",{override:"Ext.form.field.Spinner",getTriggerData:function(){var a=this.callParent();if(this.getHierarchyState().rtl){a.childElCls=this._rtlCls}return a}});