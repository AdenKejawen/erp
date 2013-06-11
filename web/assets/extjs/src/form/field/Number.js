Ext.define("Ext.form.field.Number",{extend:"Ext.form.field.Spinner",alias:"widget.numberfield",alternateClassName:["Ext.form.NumberField","Ext.form.Number"],allowDecimals:true,decimalSeparator:".",submitLocaleSeparator:true,decimalPrecision:2,minValue:Number.NEGATIVE_INFINITY,maxValue:Number.MAX_VALUE,step:1,minText:"The minimum value for this field is {0}",maxText:"The maximum value for this field is {0}",nanText:"{0} is not a valid number",negativeText:"The value cannot be negative",baseChars:"0123456789",autoStripChars:false,initComponent:function(){var a=this;a.callParent();a.setMinValue(a.minValue);a.setMaxValue(a.maxValue)},getErrors:function(c){var b=this,e=b.callParent(arguments),d=Ext.String.format,a;c=Ext.isDefined(c)?c:this.processRawValue(this.getRawValue());if(c.length<1){return e}c=String(c).replace(b.decimalSeparator,".");if(isNaN(c)){e.push(d(b.nanText,c))}a=b.parseValue(c);if(b.minValue===0&&a<0){e.push(this.negativeText)}else{if(a<b.minValue){e.push(d(b.minText,b.minValue))}}if(a>b.maxValue){e.push(d(b.maxText,b.maxValue))}return e},rawToValue:function(b){var a=this.fixPrecision(this.parseValue(b));if(a===null){a=b||null}return a},valueToRaw:function(c){var b=this,a=b.decimalSeparator;c=b.parseValue(c);c=b.fixPrecision(c);c=Ext.isNumber(c)?c:parseFloat(String(c).replace(a,"."));c=isNaN(c)?"":String(c).replace(".",a);return c},getSubmitValue:function(){var a=this,b=a.callParent();if(!a.submitLocaleSeparator){b=b.replace(a.decimalSeparator,".")}return b},onChange:function(){this.toggleSpinners();this.callParent(arguments)},toggleSpinners:function(){var c=this,d=c.getValue(),b=d===null,a;if(c.spinUpEnabled||c.spinUpDisabledByToggle){a=b||d<c.maxValue;c.setSpinUpEnabled(a,true)}if(c.spinDownEnabled||c.spinDownDisabledByToggle){a=b||d>c.minValue;c.setSpinDownEnabled(a,true)}},setMinValue:function(b){var a=this,c;a.minValue=Ext.Number.from(b,Number.NEGATIVE_INFINITY);a.toggleSpinners();if(a.disableKeyFilter!==true){c=a.baseChars+"";if(a.allowDecimals){c+=a.decimalSeparator}if(a.minValue<0){c+="-"}c=Ext.String.escapeRegex(c);a.maskRe=new RegExp("["+c+"]");if(a.autoStripChars){a.stripCharsRe=new RegExp("[^"+c+"]","gi")}}},setMaxValue:function(a){this.maxValue=Ext.Number.from(a,Number.MAX_VALUE);this.toggleSpinners()},parseValue:function(a){a=parseFloat(String(a).replace(this.decimalSeparator,"."));return isNaN(a)?null:a},fixPrecision:function(d){var c=this,b=isNaN(d),a=c.decimalPrecision;if(b||!d){return b?"":d}else{if(!c.allowDecimals||a<=0){a=0}}return parseFloat(Ext.Number.toFixed(parseFloat(d),a))},beforeBlur:function(){var b=this,a=b.parseValue(b.getRawValue());if(!Ext.isEmpty(a)){b.setValue(a)}},setSpinUpEnabled:function(b,a){this.callParent(arguments);if(!a){delete this.spinUpDisabledByToggle}else{this.spinUpDisabledByToggle=!b}},onSpinUp:function(){var a=this;if(!a.readOnly){a.setSpinValue(Ext.Number.constrain(a.getValue()+a.step,a.minValue,a.maxValue))}},setSpinDownEnabled:function(b,a){this.callParent(arguments);if(!a){delete this.spinDownDisabledByToggle}else{this.spinDownDisabledByToggle=!b}},onSpinDown:function(){var a=this;if(!a.readOnly){a.setSpinValue(Ext.Number.constrain(a.getValue()-a.step,a.minValue,a.maxValue))}},setSpinValue:function(c){var b=this,a;if(b.enforceMaxLength){if(b.fixPrecision(c).toString().length>b.maxLength){return}}b.setValue(c)}});