Ext.define("Ext.rtl.dom.Element_static",{override:"Ext.dom.Element",statics:{rtlUnitizeBox:function(f,e){var d=this.addUnits,c=this.parseBox(f);return d(c.top,e)+" "+d(c.left,e)+" "+d(c.bottom,e)+" "+d(c.right,e)},rtlParseBox:function(b){var b=Ext.dom.Element.parseBox(b),a;a=b.left;b.left=b.right;b.right=a;return b}}});