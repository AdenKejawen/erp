Ext.define("Ext.rtl.grid.CellEditor",{override:"Ext.grid.CellEditor",getTreeNodeOffset:function(b){var a=this.callParent(arguments);if(this.editingPlugin.grid.isOppositeRootDirection()){a=-(b.getWidth()-a-b.child(this.treeNodeSelector).getWidth())}return a}});