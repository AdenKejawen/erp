Ext.define("Ext.rtl.layout.container.Absolute",{override:"Ext.layout.container.Absolute",adjustWidthAnchor:function(c,b){if(this.owner.getHierarchyState().rtl){var d=this.targetPadding,a=b.getStyle("right");return c-a+d.right}else{return this.callParent(arguments)}}});