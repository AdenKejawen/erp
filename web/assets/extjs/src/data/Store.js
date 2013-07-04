Ext.define("Ext.data.Store",{extend:"Ext.data.AbstractStore",alias:"store.store",requires:["Ext.data.StoreManager","Ext.data.Model","Ext.data.proxy.Ajax","Ext.data.proxy.Memory","Ext.data.reader.Json","Ext.data.writer.Json","Ext.data.PageMap","Ext.data.Group"],uses:["Ext.ModelManager","Ext.util.Grouper"],remoteSort:false,remoteFilter:false,remoteGroup:false,groupField:undefined,groupDir:"ASC",trailingBufferZone:25,leadingBufferZone:200,pageSize:undefined,currentPage:1,clearOnPageLoad:true,loading:false,sortOnFilter:true,buffered:false,purgePageCount:5,clearRemovedOnLoad:true,defaultPageSize:25,defaultViewSize:100,addRecordsOptions:{addRecords:true},statics:{recordIdFn:function(a){return a.internalId},recordIndexFn:function(a){return a.index},grouperIdFn:function(a){return a.id||a.property},groupIdFn:function(a){return a.key}},constructor:function(b){b=Ext.apply({},b);var d=this,f=b.groupers||d.groupers,a=b.groupField||d.groupField,c,e;e=b.data||d.data;if(e){d.inlineData=e;delete b.data}if(!f&&a){f=[{property:a,direction:b.groupDir||d.groupDir}];if(b.getGroupString||(d.getGroupString!==Ext.data.Store.prototype.getGroupString)){f[0].getGroupString=function(g){return d.getGroupString(g)}}}delete b.groupers;d.groupers=new Ext.util.MixedCollection(false,Ext.data.Store.grouperIdFn);d.groupers.addAll(d.decodeGroupers(f));d.groups=new Ext.util.MixedCollection(false,Ext.data.Store.groupIdFn);d.callParent([b]);if(d.buffered){d.data=new Ext.data.PageMap({store:d,keyFn:Ext.data.Store.recordIdFn,pageSize:d.pageSize,maxSize:d.purgePageCount,listeners:{clear:d.onPageMapClear,scope:d}});d.pageRequests={};d.remoteSort=d.remoteGroup=d.remoteFilter=true;d.sortOnLoad=false;d.filterOnLoad=false}else{d.data=new Ext.util.MixedCollection({getKey:Ext.data.Store.recordIdFn,maintainIndices:true});d.data.pageSize=d.pageSize}if(d.remoteGroup){d.remoteSort=true}d.sorters.insert(0,d.groupers.getRange());c=d.proxy;e=d.inlineData;if(!d.buffered&&!d.pageSize){d.pageSize=d.defaultPageSize}if(e){if(c instanceof Ext.data.proxy.Memory){c.data=e;d.read()}else{d.add.apply(d,[e])}if(d.sorters.items.length&&!d.remoteSort){d.group(null,null,true)}delete d.inlineData}else{if(d.autoLoad){Ext.defer(d.load,1,d,[typeof d.autoLoad==="object"?d.autoLoad:undefined])}}},onBeforeSort:function(){var a=this.groupers;if(a.getCount()>0){this.sort(a.items,"prepend",false)}},decodeGroupers:function(e){if(!Ext.isArray(e)){if(e===undefined){e=[]}else{e=[e]}}var d=e.length,f=Ext.util.Grouper,b,c,a=[];for(c=0;c<d;c++){b=e[c];if(!(b instanceof f)){if(Ext.isString(b)){b={property:b}}b=Ext.apply({root:"data",direction:"ASC"},b);if(b.fn){b.sorterFn=b.fn}if(typeof b=="function"){b={sorterFn:b}}a.push(new f(b))}else{a.push(b)}}return a},group:function(e,f,c){var d=this,b,a;if(e){d.sorters.removeAll(d.groupers.items);if(Ext.isArray(e)){a=e}else{if(Ext.isObject(e)){a=[e]}else{if(Ext.isString(e)){b=d.groupers.get(e);if(!b){b={property:e,direction:f||"ASC"};a=[b]}else{if(f===undefined){b.toggle()}else{b.setDirection(f)}}}}}if(a&&a.length){d.groupers.clear();d.groupers.addAll(d.decodeGroupers(a))}d.sorters.insert(0,d.groupers.items)}if(d.remoteGroup){if(d.buffered){d.data.clear();d.loadPage(1,{groupChange:true})}else{d.load({scope:d,callback:c?null:d.fireGroupChange})}}else{d.doSort(d.generateComparator());d.constructGroups();if(!c){d.fireGroupChange()}}},getGroupField:function(){var b=this.groupers.first(),a;if(b){a=b.property}return a},constructGroups:function(){var e=this,f=this.data.items,c=f.length,b=e.groups,a,d,g,h;b.clear();if(e.isGrouped()){for(d=0;d<c;++d){h=f[d];a=e.getGroupString(h);g=b.get(a);if(!g){g=new Ext.data.Group({key:a,store:e});b.add(a,g)}g.add(h)}}},clearGrouping:function(){var c=this,d=c.groupers.items,b=d.length,a;for(a=0;a<b;a++){c.sorters.remove(d[a])}c.groupers.clear();if(c.remoteGroup){if(c.buffered){c.data.clear();c.loadPage(1,{groupChange:true})}else{c.load({scope:c,callback:c.fireGroupChange})}}else{c.groups.clear();if(c.sorters.length){c.sort()}else{c.fireEvent("datachanged",c);c.fireEvent("refresh",c)}c.fireGroupChange()}},isGrouped:function(){return this.groupers.getCount()>0},fireGroupChange:function(){this.fireEvent("groupchange",this,this.groupers)},getGroups:function(b){var d=this.data.items,a=d.length,c=[],j={},f,g,h,e;for(e=0;e<a;e++){f=d[e];g=this.getGroupString(f);h=j[g];if(h===undefined){h={name:g,children:[]};c.push(h);j[g]=h}h.children.push(f)}return b?j[b]:c},getGroupsForGrouper:function(f,b){var d=f.length,e=[],a,c,h,j,g;for(g=0;g<d;g++){h=f[g];c=b.getGroupString(h);if(c!==a){j={name:c,grouper:b,records:[]};e.push(j)}j.records.push(h);a=c}return e},getGroupsForGrouperIndex:function(c,h){var f=this,g=f.groupers,b=g.getAt(h),a=f.getGroupsForGrouper(c,b),e=a.length,d;if(h+1<g.length){for(d=0;d<e;d++){a[d].children=f.getGroupsForGrouperIndex(a[d].records,h+1)}}for(d=0;d<e;d++){a[d].depth=h}return a},getGroupData:function(a){var b=this;if(a!==false){b.sort()}return b.getGroupsForGrouperIndex(b.data.items,0)},getGroupString:function(a){var b=this.groupers.first();if(b){return b.getGroupString(a)}return""},insert:function(f,a){var h=this,j=false,d,g,e,b=h.modelDefaults,c;if(!Ext.isIterable(a)){c=a=[a]}else{c=[]}g=a.length;if(g){for(d=0;d<g;d++){e=a[d];if(!e.isModel){e=h.createModel(e)}c[d]=e;if(b){e.set(b)}e.join(h);j=j||e.phantom===true}h.data.insert(f,c);if(h.snapshot){h.snapshot.addAll(c)}if(h.requireSort){h.suspendEvents();h.sort();h.resumeEvents()}if(h.isGrouped()){h.updateGroupsOnAdd(c)}h.fireEvent("add",h,c,f);h.fireEvent("datachanged",h);if(h.autoSync&&j&&!h.autoSyncSuspended){h.sync()}}return c},updateGroupsOnAdd:function(c){var e=this,b=e.groups,a=c.length,d,h,f,g;for(d=0;d<a;++d){g=c[d];h=e.getGroupString(g);f=b.getByKey(h);if(!f){f=b.add(new Ext.data.Group({key:h,store:e}))}f.add(g)}},updateGroupsOnRemove:function(c){var e=this,b=e.groups,a=c.length,d,h,f,g;for(d=0;d<a;++d){g=c[d];h=e.getGroupString(g);f=b.getByKey(h);if(f){f.remove(g);if(f.records.length===0){b.remove(f)}}}},updateGroupsOnUpdate:function(e,c){var h=this,a=h.getGroupField(),k=h.getGroupString(e),b=h.groups,f,d,g,j;if(c&&Ext.Array.indexOf(c,a)!==-1){if(h.buffered){Ext.Error.raise({msg:"Cannot move records between groups in a buffered store record"})}g=b.items;for(d=0,f=g.length;d<f;++d){j=g[d];if(j.contains(e)){j.remove(e);break}}j=b.getByKey(k);if(!j){j=b.add(new Ext.data.Group({key:k,store:h}))}j.add(e);h.data.remove(e);h.data.insert(h.data.findInsertionIndex(e,h.generateComparator()),e);for(d=0,f=this.getCount();d<f;d++){h.data.items[d].index=d}}else{b.getByKey(k).setDirty()}},add:function(a){var d=this,b,c,e;if(d.buffered){Ext.Error.raise({msg:"add method may not be called on a buffered store"})}if(Ext.isArray(a)){b=a}else{b=arguments}c=b.length;e=!d.remoteSort&&d.sorters&&d.sorters.items.length;if(e&&c===1){return[d.addSorted(d.createModel(b[0]))]}if(e){d.requireSort=true}b=d.insert(d.data.length,b);delete d.requireSort;return b},addSorted:function(a){var c=this,b=c.data.findInsertionIndex(a,c.generateComparator());c.insert(b,a);return a},createModel:function(a){if(!a.isModel){a=Ext.ModelManager.create(a,this.model)}return a},onUpdate:function(a,b,c){if(this.isGrouped()){this.updateGroupsOnUpdate(a,c)}},each:function(e,c){var f=this.data.items,b=f.length,a,g;for(g=0;g<b;g++){a=f[g];if(e.call(c||a,a,g,b)===false){break}}},remove:function(n,k,o){k=k===true;var s=this,h=false,d=s.snapshot,t=s.data,m=0,c,p=[],r=[],e=[],q,l,f,b,j,g,a=!o&&s.hasListeners.remove;if(n.isModel){n=[n];c=1}else{if(Ext.isIterable(n)){c=n.length}else{if(typeof n==="object"){j=true;m=n.start;c=n.end+1;g=c-m}}}if(!j){for(m=0;m<c;++m){b=n[m];if(typeof b=="number"){f=b;b=t.getAt(f)}else{f=s.indexOf(b)}if(b&&f>-1){p.push({record:b,index:f})}if(d){d.remove(b)}}p=Ext.Array.sort(p,function(u,i){var w=u.index,v=i.index;return w===i.index2?0:(w<v?-1:1)});m=0;c=p.length}for(;m<c;m++){if(j){b=t.getAt(m);f=m}else{q=p[m];b=q.record;f=q.index}r.push(b);e.push(f);l=b.phantom!==true;if(!k&&l){b.removedFrom=f;s.removed.push(b)}b.unjoin(s);f-=m;h=h||l;if(!j){t.removeAt(f);if(a){s.fireEvent("remove",s,b,f,!!k)}}}if(j){t.removeRange(n.start,g)}if(!o){s.fireEvent("bulkremove",s,r,e,!!k);s.fireEvent("datachanged",s)}if(!k&&s.autoSync&&h&&!s.autoSyncSuspended){s.sync()}},removeAt:function(a,c){var b=this,d=b.getCount();if(a<=d){if(arguments.length===1){b.remove([a])}else{if(c){b.remove({start:a,end:Math.min(a+c,d)-1})}}}},removeAll:function(b){var c=this,a=c.snapshot,d=c.data;if(a){a.removeAll(d.getRange())}if(c.buffered){if(d){if(b){c.suspendEvent("clear")}d.clear();if(b){c.resumeEvent("clear")}}}else{c.remove({start:0,end:c.getCount()-1},false,b);if(b!==true){c.fireEvent("clear",c)}}},load:function(a){var b=this;a=a||{};if(typeof a=="function"){a={callback:a}}a.groupers=a.groupers||b.groupers.items;a.page=a.page||b.currentPage;a.start=(a.start!==undefined)?a.start:(a.page-1)*b.pageSize;a.limit=a.limit||b.pageSize;a.addRecords=a.addRecords||false;if(b.buffered){a.limit=b.viewSize||b.defaultViewSize;return b.loadToPrefetch(a)}return b.callParent([a])},reload:function(l){var g=this,h,b,f,k,d,a,j,c,e=g.getCount();if(!l){l={}}if(g.buffered){delete g.totalCount;a=function(){if(g.rangeCached(h,b)){g.loading=false;g.data.un("pageAdded",a);c=g.data.getRange(h,b);g.fireEvent("load",g,c,true)}};j=Math.ceil((g.leadingBufferZone+g.trailingBufferZone)/2);h=l.start||(e?g.getAt(0).index:0);b=h+(l.count||(e?e:g.pageSize))-1;f=g.getPageFromRecordIndex(Math.max(h-j,0));k=g.getPageFromRecordIndex(b+j);g.data.clear(true);if(g.fireEvent("beforeload",g,l)!==false){g.loading=true;g.data.on("pageAdded",a);for(d=f;d<=k;d++){g.prefetchPage(d,l)}}}else{return g.callParent(arguments)}},onProxyLoad:function(b){var d=this,c=b.getResultSet(),a=b.getRecords(),e=b.wasSuccessful();if(d.isDestroyed){return}if(c){d.totalCount=c.total}d.loading=false;if(e){d.loadRecords(a,b)}if(d.hasListeners.load){d.fireEvent("load",d,a,e)}if(d.hasListeners.read){d.fireEvent("read",d,a,e)}Ext.callback(b.callback,b.scope||d,[a,b,e])},getNewRecords:function(){return this.data.filterBy(this.filterNew).items},getUpdatedRecords:function(){return this.data.filterBy(this.filterUpdated).items},filter:function(e,f){if(Ext.isString(e)){e={property:e,value:f}}var d=this,a=d.decodeFilters(e),b,g=d.sorters.length&&d.sortOnFilter&&!d.remoteSort,c=a.length;for(b=0;b<c;b++){d.filters.replace(a[b])}e=d.filters.items;if(e.length){if(d.remoteFilter){delete d.totalCount;if(d.buffered){d.data.clear();d.loadPage(1)}else{d.currentPage=1;d.load()}}else{d.snapshot=d.snapshot||d.data.clone();d.data=d.snapshot.filter(e);d.constructGroups();if(g){d.sort()}else{d.fireEvent("datachanged",d);d.fireEvent("refresh",d)}}d.fireEvent("filterchange",d,e)}},clearFilter:function(a){var b=this;b.filters.clear();if(b.remoteFilter){if(a){return}delete b.totalCount;if(b.buffered){b.data.clear();b.loadPage(1)}else{b.currentPage=1;b.load()}}else{if(b.isFiltered()){b.data=b.snapshot;delete b.snapshot;b.constructGroups();if(a!==true){b.fireEvent("datachanged",b);b.fireEvent("refresh",b)}}}b.fireEvent("filterchange",b,b.filters.items)},removeFilter:function(b,a){var c=this;if(!c.remoteFilter&&c.isFiltered()){if(b instanceof Ext.util.Filter){c.filters.remove(b)}else{c.filters.removeAtKey(b)}if(a!==false){if(c.filters.length){c.filter()}else{c.clearFilter()}}else{c.fireEvent("filterchange",c,c.filters.items)}}},addFilter:function(f,a){var e=this,b,c,d;b=e.decodeFilters(f);d=b.length;for(c=0;c<d;c++){e.filters.replace(b[c])}if(a!==false&&e.filters.length){e.filter()}else{e.fireEvent("filterchange",e,e.filters.items)}},isFiltered:function(){var a=this.snapshot;return !!(a&&a!==this.data)},filterBy:function(b,a){var c=this;c.snapshot=c.snapshot||c.data.clone();c.data=c.queryBy(b,a||c);c.fireEvent("datachanged",c);c.fireEvent("refresh",c)},queryBy:function(b,a){var c=this;return(c.snapshot||c.data).filterBy(b,a||c)},query:function(g,f,h,a,e){var d=this,b=d.createFilterFn(g,f,h,a,e),c=d.queryBy(b);if(!c){c=new Ext.util.MixedCollection()}return c},loadData:function(e,a){var d=e.length,c=[],b;for(b=0;b<d;b++){c.push(this.createModel(e[b]))}this.loadRecords(c,a?this.addRecordsOptions:undefined)},loadRawData:function(e,b){var d=this,a=d.proxy.reader.read(e),c=a.records;if(a.success){d.totalCount=a.total;d.loadRecords(c,b?d.addRecordsOptions:undefined)}},loadRecords:function(b,c){var g=this,d=0,f=b.length,h,e,a=g.snapshot;if(c){h=c.start;e=c.addRecords}if(!e){delete g.snapshot;g.clearData(true)}else{if(a){a.addAll(b)}}g.data.addAll(b);if(h!==undefined){for(;d<f;d++){b[d].index=h+d;b[d].join(g)}}else{for(;d<f;d++){b[d].join(g)}}g.suspendEvents();if(g.filterOnLoad&&!g.remoteFilter){g.filter()}if(g.sortOnLoad&&!g.remoteSort){g.sort(undefined,undefined,undefined,true)}g.resumeEvents();if(g.isGrouped()){g.constructGroups()}g.fireEvent("datachanged",g);g.fireEvent("refresh",g)},loadPage:function(c,a){var b=this;b.currentPage=c;a=Ext.apply({page:c,start:(c-1)*b.pageSize,limit:b.pageSize,addRecords:!b.clearOnPageLoad},a);if(b.buffered){a.limit=b.viewSize||b.defaultViewSize;return b.loadToPrefetch(a)}b.read(a)},nextPage:function(a){this.loadPage(this.currentPage+1,a)},previousPage:function(a){this.loadPage(this.currentPage-1,a)},clearData:function(d){var c=this,a,b;if(!c.buffered&&c.data){a=c.data.items;b=a.length;while(b--){a[b].unjoin(c)}}if(c.data){c.data.clear()}if(d!==true||c.clearRemovedOnLoad){c.removed.length=0}},loadToPrefetch:function(m){var h=this,e,b,k,c=m,j=m.start,a=m.start+m.limit-1,f=Math.min(a,m.start+(h.viewSize||m.limit)-1),g=h.getPageFromRecordIndex(Math.max(j-h.trailingBufferZone,0)),l=h.getPageFromRecordIndex(a+h.leadingBufferZone),d=function(){if(h.rangeCached(j,f)){h.loading=false;b=h.data.getRange(j,f);h.data.un("pageAdded",d);if(h.hasListeners.guaranteedrange){h.guaranteeRange(j,f,m.callback,m.scope)}if(m.callback){m.callback.call(m.scope||h,b,j,a,m)}h.fireEvent("datachanged",h);h.fireEvent("refresh",h);h.fireEvent("load",h,b,true);if(m.groupChange){h.fireGroupChange()}}};if(h.fireEvent("beforeload",h,m)!==false){delete h.totalCount;h.loading=true;if(m.callback){c=Ext.apply({},m);delete c.callback}h.on("prefetch",function(o,n,p,i){if(p){if((k=h.getTotalCount())){h.data.on("pageAdded",d);f=Math.min(f,k-1);l=h.getPageFromRecordIndex(Math.min(f+h.leadingBufferZone,k-1));for(e=g+1;e<=l;++e){h.prefetchPage(e,c)}}else{h.fireEvent("datachanged",h);h.fireEvent("refresh",h);h.fireEvent("load",h,n,true)}}else{h.fireEvent("load",h,n,false)}},null,{single:true});h.prefetchPage(g,c)}},prefetch:function(c){var e=this,a=e.pageSize,d,b;if(a){if(e.lastPageSize&&a!=e.lastPageSize){Ext.Error.raise("pageSize cannot be dynamically altered")}if(!e.data.pageSize){e.data.pageSize=a}}else{e.pageSize=e.data.pageSize=a=c.limit}e.lastPageSize=a;if(!c.page){c.page=e.getPageFromRecordIndex(c.start);c.start=(c.page-1)*a;c.limit=Math.ceil(c.limit/a)*a}if(!e.pageRequests[c.page]){c=Ext.apply({action:"read",filters:e.filters.items,sorters:e.sorters.items,groupers:e.groupers.items,pageMapGeneration:e.data.pageMapGeneration},c);b=new Ext.data.Operation(c);if(e.fireEvent("beforeprefetch",e,b)!==false){d=e.proxy;e.pageRequests[c.page]=d.read(b,e.onProxyPrefetch,e);if(d.isSynchronous){delete e.pageRequests[c.page]}}}return e},onPageMapClear:function(){var d=this,c=d.wasLoading,a=d.pageRequests,b,e;if(d.data.events.pageadded){d.data.events.pageadded.clearListeners()}d.loading=true;d.totalCount=0;for(e in a){if(a.hasOwnProperty(e)){b=a[e];delete a[e];delete b.callback}}d.fireEvent("clear",d);d.loading=c},prefetchPage:function(e,b){var d=this,a=d.pageSize||d.defaultPageSize,f=(e-1)*d.pageSize,c=d.totalCount;if(c!==undefined&&d.getCount()===c){return}d.prefetch(Ext.applyIf({page:e,start:f,limit:a},b))},onProxyPrefetch:function(b){var d=this,c=b.getResultSet(),a=b.getRecords(),f=b.wasSuccessful(),e=b.page;if(b.pageMapGeneration===d.data.pageMapGeneration){if(c){d.totalCount=c.total;d.fireEvent("totalcountchange",d.totalCount)}if(e!==undefined){delete d.pageRequests[e]}d.loading=false;d.fireEvent("prefetch",d,a,f,b);if(f){d.cachePage(a,b.page)}Ext.callback(b.callback,b.scope||d,[a,b,f])}},cachePage:function(b,e){var d=this,a=b.length,c;if(!Ext.isDefined(d.totalCount)){d.totalCount=b.length;d.fireEvent("totalcountchange",d.totalCount)}for(c=0;c<a;c++){b[c].join(d)}d.data.addPage(e,b)},rangeCached:function(b,a){return this.data&&this.data.hasRange(b,a)},pageCached:function(a){return this.data&&this.data.hasPage(a)},pagePending:function(a){return !!this.pageRequests[a]},rangeSatisfied:function(b,a){return this.rangeCached(b,a)},getPageFromRecordIndex:function(a){return Math.floor(a/this.pageSize)+1},onGuaranteedRange:function(d){var e=this,b=e.getTotalCount(),f=d.prefetchStart,a=(d.prefetchEnd>b-1)?b-1:d.prefetchEnd,c;a=Math.max(0,a);if(f>a){Ext.log({level:"warn",msg:"Start ("+f+") was greater than end ("+a+") for the range of records requested ("+f+"-"+d.prefetchEnd+")"+(this.storeId?' from store "'+this.storeId+'"':"")})}c=e.data.getRange(f,a);if(d.fireEvent!==false){e.fireEvent("guaranteedrange",c,f,a,d)}if(d.callback){d.callback.call(d.scope||e,c,f,a,d)}},guaranteeRange:function(e,a,d,c,b){b=Ext.apply({callback:d,scope:c},b);this.getRange(e,a,b)},prefetchRange:function(f,b){var d=this,c,a,e;if(!d.rangeCached(f,b)){c=d.getPageFromRecordIndex(f);a=d.getPageFromRecordIndex(b);d.data.maxSize=d.purgePageCount?(a-c+1)+d.purgePageCount:0;for(e=c;e<=a;e++){if(!d.pageCached(e)){d.prefetchPage(e)}}}},primeCache:function(d,a,c){var b=this;if(c===-1){d=Math.max(d-b.leadingBufferZone,0);a=Math.min(a+b.trailingBufferZone,b.totalCount-1)}else{if(c===1){d=Math.max(Math.min(d-b.trailingBufferZone,b.totalCount-b.pageSize),0);a=Math.min(a+b.leadingBufferZone,b.totalCount-1)}else{d=Math.min(Math.max(Math.floor(d-((b.leadingBufferZone+b.trailingBufferZone)/2)),0),b.totalCount-b.pageSize);a=Math.min(Math.max(Math.ceil(a+((b.leadingBufferZone+b.trailingBufferZone)/2)),0),b.totalCount-1)}}b.prefetchRange(d,a)},sort:function(){var a=this;if(a.buffered&&a.remoteSort){a.data.clear()}return a.callParent(arguments)},doSort:function(b){var e=this,a,d,c;if(e.remoteSort){if(e.buffered){e.data.clear();e.loadPage(1)}else{e.load()}}else{if(e.buffered){Ext.Error.raise({msg:"Local sorting may not be used on a buffered store"})}e.data.sortBy(b);if(!e.buffered){a=e.getRange();d=a.length;for(c=0;c<d;c++){a[c].index=c}}e.fireEvent("datachanged",e);e.fireEvent("refresh",e)}},find:function(e,d,g,f,a,c){var b=this.createFilterFn(e,d,f,a,c);return b?this.data.findIndexBy(b,null,g):-1},findRecord:function(){var b=this,a=b.find.apply(b,arguments);return a!==-1?b.getAt(a):null},createFilterFn:function(d,c,e,a,b){if(Ext.isEmpty(c)){return false}c=this.data.createValueMatcher(c,e,a,b);return function(f){return c.test(f.data[d])}},findExact:function(b,a,c){return this.data.findIndexBy(function(d){return d.isEqual(d.get(b),a)},this,c)},findBy:function(b,a,c){return this.data.findIndexBy(b,a,c)},collect:function(b,a,c){var d=this,e=(c===true&&d.snapshot)?d.snapshot:d.data;return e.collect(b,"data",a)},getCount:function(){return this.data.getCount()},getTotalCount:function(){return this.totalCount||0},getAt:function(a){return this.data.getAt(a)},getRange:function(c,f,j){if(j&&j.cb){j.callback=j.cb;Ext.Error.raise({msg:"guaranteeRange options.cb is deprecated, use options.callback"})}var g=this,h,b,d=g.totalCount-1,e=g.lastRequestStart,a,i;j=Ext.apply({prefetchStart:c,prefetchEnd:f},j);if(g.buffered){f=(f>=g.totalCount)?d:f;h=c===0?0:c-1;b=f===d?f:f+1;g.lastRequestStart=c;if(g.rangeCached(h,b)){g.onGuaranteedRange(j);i=g.data.getRange(c,f)}else{g.fireEvent("cachemiss",g,c,f);a=function(l,k){if(g.rangeCached(h,b)){g.fireEvent("cachefilled",g,c,f);g.data.un("pageAdded",a);g.onGuaranteedRange(j)}};g.data.on("pageAdded",a);g.prefetchRange(c,f)}g.primeCache(c,f,c<e?-1:1)}else{i=g.data.getRange(c,f);if(j.callback){j.callback.call(j.scope||g,i,c,f,j)}}return i},getById:function(b){var a=(this.snapshot||this.data).findBy(function(c){return c.getId()===b});if(this.buffered&&!a){Ext.Error.raise("getById called for ID that is not present in local cache")}return a},indexOf:function(a){return this.data.indexOf(a)},indexOfTotal:function(a){var b=a.index;if(b||b===0){return b}return this.indexOf(a)},indexOfId:function(a){return this.indexOf(this.getById(a))},first:function(a){var b=this;if(a&&b.isGrouped()){return b.aggregate(function(c){return c.length?c[0]:undefined},b,true)}else{return b.data.first()}},last:function(a){var b=this;if(a&&b.isGrouped()){return b.aggregate(function(d){var c=d.length;return c?d[c-1]:undefined},b,true)}else{return b.data.last()}},sum:function(c,a){var b=this;if(a&&b.isGrouped()){return b.aggregate(b.getSum,b,true,[c])}else{return b.getSum(b.data.items,c)}},getSum:function(b,e){var d=0,c=0,a=b.length;for(;c<a;++c){d+=b[c].get(e)}return d},count:function(a){var b=this;if(a&&b.isGrouped()){return b.aggregate(function(c){return c.length},b,true)}else{return b.getCount()}},min:function(c,a){var b=this;if(a&&b.isGrouped()){return b.aggregate(b.getMin,b,true,[c])}else{return b.getMin(b.data.items,c)}},getMin:function(b,f){var d=1,a=b.length,e,c;if(a>0){c=b[0].get(f)}for(;d<a;++d){e=b[d].get(f);if(e<c){c=e}}return c},max:function(c,a){var b=this;if(a&&b.isGrouped()){return b.aggregate(b.getMax,b,true,[c])}else{return b.getMax(b.data.items,c)}},getMax:function(c,f){var d=1,b=c.length,e,a;if(b>0){a=c[0].get(f)}for(;d<b;++d){e=c[d].get(f);if(e>a){a=e}}return a},average:function(c,a){var b=this;if(a&&b.isGrouped()){return b.aggregate(b.getAverage,b,true,[c])}else{return b.getAverage(b.data.items,c)}},getAverage:function(b,e){var c=0,a=b.length,d=0;if(b.length>0){for(;c<a;++c){d+=b[c].get(e)}return d/a}return 0},aggregate:function(g,j,e,f){f=f||[];if(e&&this.isGrouped()){var a=this.getGroups(),d=a.length,b={},h,c;for(c=0;c<d;++c){h=a[c];b[h.name]=this.getAggregate(g,j||this,h.children,f)}return b}else{return this.getAggregate(g,j,this.data.items,f)}},getAggregate:function(d,c,a,b){b=b||[];return d.apply(c||this,[a].concat(b))},onIdChanged:function(e,d,c,b){var a=this.snapshot;if(a){a.updateKey(b,c)}this.data.updateKey(b,c);this.callParent(arguments)},commitChanges:function(){var c=this,d=c.getModifiedRecords(),a=d.length,b=0;for(;b<a;b++){d[b].commit()}c.removed.length=0},filterNewOnly:function(a){return a.phantom===true},getRejectRecords:function(){return Ext.Array.push(this.data.filterBy(this.filterNewOnly).items,this.getUpdatedRecords())},rejectChanges:function(){var c=this,d=c.getRejectRecords(),a=d.length,b=0,e;for(;b<a;b++){e=d[b];e.reject();if(e.phantom){c.remove(e)}}d=c.removed;a=d.length;for(b=0;b<a;b++){e=d[b];c.insert(e.removedFrom||0,e);e.reject()}c.removed.length=0}},function(){Ext.regStore("ext-empty-store",{fields:[],proxy:"memory"})});