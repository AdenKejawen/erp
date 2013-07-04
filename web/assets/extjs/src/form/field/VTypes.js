Ext.define("Ext.form.field.VTypes",(function(){var c=/^[a-zA-Z_]+$/,d=/^[a-zA-Z0-9_]+$/,b=/^(")?(?:[^\."])(?:(?:[\.])?(?:[\w\-!#$%&'*+/=?^_`{|}~]))*\1@(\w[\-\w]*\.){1,5}([A-Za-z]){2,6}$/,a=/(((^https?)|(^ftp)):\/\/((([\-\w]+\.)+\w{2,3}(\/[%\-\w]+(\.\w{2,})?)*(([\w\-\.\?\\\/+@&#;`~=%!]*)(\.\w{2,})?)*)|(localhost|LOCALHOST))\/?)/i;return{singleton:true,alternateClassName:"Ext.form.VTypes",email:function(e){return b.test(e)},emailText:'This field should be an e-mail address in the format "user@example.com"',emailMask:/[\w.\-@'"!#$%&'*+/=?^_`{|}~]/i,url:function(e){return a.test(e)},urlText:'This field should be a URL in the format "http://www.example.com"',alpha:function(e){return c.test(e)},alphaText:"This field should only contain letters and _",alphaMask:/[a-z_]/i,alphanum:function(e){return d.test(e)},alphanumText:"This field should only contain letters, numbers and _",alphanumMask:/[a-z0-9_]/i}}()));