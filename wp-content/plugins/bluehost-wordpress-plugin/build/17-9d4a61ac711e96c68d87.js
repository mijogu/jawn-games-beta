(window.webpackJsonp_bluehost_wordpress_plugin=window.webpackJsonp_bluehost_wordpress_plugin||[]).push([[17],{135:function(e,t,r){"use strict";r.d(t,"a",(function(){return u})),r.d(t,"b",(function(){return O})),r.d(t,"c",(function(){return j})),r.d(t,"d",(function(){return v})),r.d(t,"e",(function(){return _})),r.d(t,"f",(function(){return w})),r.d(t,"g",(function(){return S}));var n=r(38),c=r.n(n),a=r(4),s=r.n(a),o=r(1),l=r(5);function u(){var e=arguments.length>0&&void 0!==arguments[0]?arguments[0]:[],t=Object(o.useState)(e),r=s()(t,2),n=r[0],a=r[1];function u(e){a([].concat(c()(n),[e]))}function i(e){return n.includes(e)}function b(e){a(Object(l.without)(n,e))}function p(e){i(e)?b(e):u(e)}return[{favorites:n},{addFavorite:u,hasFavorite:i,removeFavorite:b,setFavorites:a,toggleFavorite:p}]}var i=r(134),b=r.n(i),p=r(18),m=r.n(p),d=r(16),h=r.n(d);function O(){var e=arguments.length>0&&void 0!==arguments[0]?arguments[0]:"themes",t=arguments.length>1&&void 0!==arguments[1]?arguments[1]:{},r=Object(o.useState)(!1),n=s()(r,2),c=n[0],a=n[1],l=Object(o.useState)(!1),u=s()(l,2),i=u[0],p=u[1],d=Object(o.useState)(!1),O=s()(d,2),j=O[0],f=O[1],g=Object(o.useState)(e),v=s()(g,2),_=v[0],w=v[1],E=Object(o.useState)(t),y=s()(E,2),N=y[0],S=y[1],k=Object(o.useState)({}),P=s()(k,2),C=P[0],x=P[1];return Object(o.useEffect)((function(){!function(){var e=b()(m.a.mark((function e(){var t,r,n,c,o,l,u;return m.a.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:for(a(!1),p(!1),f(!0),e.prev=3,t=new URLSearchParams(""),r=0,n=Object.entries(N);r<n.length;r++)c=s()(n[r],2),o=c[0],l=c[1],t.append(o,l);return e.next=8,h()({path:"/mojo/v1/"+_+"?"+t.toString()});case 8:u=e.sent,x(u),e.next=16;break;case 12:e.prev=12,e.t0=e.catch(3),p(!0),x(e.t0);case 16:f(!1),a(!0);case 18:case"end":return e.stop()}}),e,null,[[3,12]])})));return function(){return e.apply(this,arguments)}}()()}),[_,N]),[{done:c,isError:i,isLoading:j,params:N,payload:C},{setType:w,setParams:S}]}function j(e){return[function(t,r){switch(r){case"favorites":return function(t){return Object(l.filter)(t,(function(t){return e.includes(t.id)}))}(t);default:return t}}]}var f=r(139),g=r.n(f);function v(){var e=arguments.length>0&&void 0!==arguments[0]?arguments[0]:"",t=Object(o.useState)(e),r=s()(t,2),n=r[0],c=r[1];function a(e){return n?new g.a(e,{threshold:.1,keys:["name","short_description","features","tags"]}).search(n):e}return[{query:n},{search:a,setQuery:c}]}function _(){function e(e){return e.sort((function(e,t){return e.created_timestamp>t.created_timestamp?1:e.created_timestamp<t.created_timestamp?-1:e.name<t.name?1:-1}))}function t(t){return Object(l.reverse)(e(t))}function r(e){return Object(l.sortBy)(e,(function(e){return parseInt(e.prices.single_domain_license,10)}))}function n(e){return Object(l.reverse)(r(e))}function c(e){return e.sort((function(e,t){return e.sales_count>t.sales_count?1:e.sales_count<t.sales_count?-1:e.name<t.name?1:-1}))}function a(e){return Object(l.reverse)(c(e))}return[function(s){var o=arguments.length>1&&void 0!==arguments[1]?arguments[1]:"sales",l=arguments.length>2&&void 0!==arguments[2]?arguments[2]:"desc";switch(s=Object.values(s),o){case"date":return"desc"===l?t(s):e(s);case"price":return"desc"===l?n(s):r(s);default:return"desc"===l?a(s):c(s)}}]}function w(){var e=arguments.length>0&&void 0!==arguments[0]?arguments[0]:[],t=arguments.length>1&&void 0!==arguments[1]?arguments[1]:12,r=arguments.length>2&&void 0!==arguments[2]?arguments[2]:1,n=Object(o.useState)(e),c=s()(n,2),a=c[0],u=c[1],i=Object(o.useState)([]),b=s()(i,2),p=b[0],m=b[1],d=Object(o.useState)(t),h=s()(d,2),O=h[0],j=h[1],f=Object(o.useState)([]),g=s()(f,2),v=g[0],_=g[1],w=Object(o.useState)(1),E=s()(w,2),y=E[0],N=E[1],S=Object(o.useState)(r),k=s()(S,2),P=k[0],C=k[1];return Object(o.useEffect)((function(){var e=Object(l.chunk)(a,O);_(e),N(e.length)}),[a]),Object(o.useEffect)((function(){m(v[P-1])}),[v,P]),[{items:p,itemsPerPage:O,pageCount:y,pageNumber:P},{setCollection:u,setItemsPerPage:j,setPageNumber:C}]}var E=r(19),y=r.n(E),N=r(2);function S(){var e=Object(o.useState)(null),t=s()(e,2),r=t[0],n=t[1],c=Object(o.useState)(null),a=s()(c,2),l=a[0],u=a[1],i=Object(o.useState)(null),p=s()(i,2),d=p[0],O=p[1],j=Object(o.useState)(null),f=s()(j,2),g=f[0],v=f[1],_=Object(o.useState)(!1),w=s()(_,2),E=w[0],S=w[1],k=Object(o.useState)(!1),P=s()(k,2),C=P[0],x=P[1],T=Object(o.useState)(!1),D=s()(T,2),F=D[0],L=D[1],U=Object(o.useState)(null),q=s()(U,2),V=q[0],W=q[1],I=Object(o.useState)(null),R=s()(I,2),B=R[0],M=R[1],A=Object(o.useState)(null),H=s()(A,2),Y=H[0],J=H[1],Q=Object(o.useState)(null),z=s()(Q,2),G=z[0],Z=z[1],K=Object(o.useState)(null),X=s()(K,2),$=X[0],ee=X[1],te=Object(o.useState)(null),re=s()(te,2),ne=re[0],ce=re[1],ae=Object(o.useState)(""),se=s()(ae,2),oe=se[0],le=se[1],ue=Object(N.__)("An unknown error has occurred.","bluehost-wordpress-plugin"),ie=function(){var e=b()(m.a.mark((function e(t){var r;return m.a.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return x(!1),L(!0),O(null),e.prev=3,e.next=6,h()(t);case 6:if(!(r=e.sent).hasOwnProperty("status")||"error"!==r.status){e.next=9;break}throw new Error(r.message);case 9:return L(!1),e.abrupt("return",r);case 13:return e.prev=13,e.t0=e.catch(3),L(!1),x(!0),O(("object"===y()(e.t0)?e.t0.message:e.t0)||ue),e.abrupt("return",null);case 19:case"end":return e.stop()}}),e,null,[[3,13]])})));return function(_x){return e.apply(this,arguments)}}(),be=function(e){e.hasOwnProperty("stagingExists")&&v(e.stagingExists),e.hasOwnProperty("currentEnvironment")&&u("production"===e.currentEnvironment),e.hasOwnProperty("productionDir")&&W(e.productionDir),e.hasOwnProperty("productionThumbnailUrl")&&M(e.productionThumbnailUrl),e.hasOwnProperty("productionUrl")&&J(e.productionUrl),e.hasOwnProperty("stagingDir")&&Z(e.stagingDir),e.hasOwnProperty("stagingThumbnailUrl")&&ee(e.stagingThumbnailUrl),e.hasOwnProperty("stagingUrl")&&ce(e.stagingUrl),e.hasOwnProperty("creationDate")&&n(e.creationDate)};function pe(){return(pe=b()(m.a.mark((function e(){var t;return m.a.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return S(!0),e.next=3,ie({path:"/bluehost/v1/staging",method:"POST"});case 3:(t=e.sent)&&(be(t),O(t.message),x("error"===t.status)),S(!1);case 6:case"end":return e.stop()}}),e)})))).apply(this,arguments)}function me(){return(me=b()(m.a.mark((function e(){return m.a.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return e.next=2,ie({path:"/bluehost/v1/staging",method:"DELETE"});case 2:e.sent&&(v(!1),O(Object(N.__)("Staging website destroyed.","bluehost-wordpress-plugin")));case 4:case"end":return e.stop()}}),e)})))).apply(this,arguments)}function de(){return(de=b()(m.a.mark((function e(t){var r;return m.a.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return le(t),e.next=3,ie({path:"/bluehost/v1/staging/switch-to?env=".concat(t)});case 3:(r=e.sent)&&r.hasOwnProperty("load_page")&&(window.location.href=r.load_page);case 5:case"end":return e.stop()}}),e)})))).apply(this,arguments)}function he(){return(he=b()(m.a.mark((function e(){return m.a.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return e.next=2,ie({path:"/bluehost/v1/staging/clone",method:"POST"});case 2:e.sent&&O(Object(N.__)("Website cloned successfully.","bluehost-wordpress-plugin"));case 4:case"end":return e.stop()}}),e)})))).apply(this,arguments)}function Oe(){return(Oe=b()(m.a.mark((function e(){var t,r=arguments;return m.a.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return t=r.length>0&&void 0!==r[0]?r[0]:"all",e.next=3,ie({path:"/bluehost/v1/staging/deploy?type=".concat(t),method:"POST"});case 3:e.sent&&O(Object(N.__)("Changes deployed successfully.","bluehost-wordpress-plugin"));case 5:case"end":return e.stop()}}),e)})))).apply(this,arguments)}return Object(o.useEffect)((function(){ie({path:"/bluehost/v1/staging"}).then(be)}),[]),[{creationDate:r,hasStaging:g,isCreatingStaging:E,isError:C,isProduction:l,isLoading:F,notice:d,productionDir:V,productionThumbnailUrl:B,productionUrl:Y,stagingDir:G,stagingThumbnailUrl:$,stagingUrl:ne,switchingTo:oe},{cloneEnv:function(){return he.apply(this,arguments)},createEnv:function(){return pe.apply(this,arguments)},deleteEnv:function(){return me.apply(this,arguments)},deployChanges:function(){return Oe.apply(this,arguments)},setNotice:O,switchToEnv:function(e){return de.apply(this,arguments)}}]}},136:function(e,t,r){},137:function(e,t,r){},138:function(e,t,r){"use strict";r.d(t,"a",(function(){return h})),r.d(t,"b",(function(){return f})),r.d(t,"c",(function(){return T}));var n=r(14),c=r.n(n),a=r(1),s=r(8),o=r(26),l=r(2),u=r(3),i=r.n(u),b=r(5),p=r(133),m=r(9),d=r(12),h=function(e){var t=e.type,r=void 0===t?"base":t,n=e.descriptivePageTitle,u=void 0!==n&&n,h=c()(e,["type","descriptivePageTitle"]),O=document.querySelector(".bwa-route-contents"),j=Object(m.useLocation)(),f=Object(d.useSelect)((function(e){return e("bluehost/plugin").getTopLevelPages()}),[]);if(null==f)return!1;var g=function(){var e=Object(l.__)("Bluehost WordPress Plugin","bluehost-wordpress-plugin"),t=document.querySelector("h2");return!1!==u?u:null!==t?t.innerText:e};return Object(a.useEffect)((function(){var e,t,r,n,c;Object(s.e)(f),Object(s.d)((e=!1,t=j.pathname,(r=Object(b.keyBy)(f,"path"))[t]?e=r[t].slug:f.forEach((function(r){t.includes(r.path)&&(e=r.slug)})),e)),O.focus({preventScroll:!0}),n=j,c=g(),void 0!==n.state&&void 0!==n.state.redirect&&"unspecified-or-root"===n.state.redirect||Object(p.speak)(c,"assertive"),Object(s.h)(j,g())}),[j.pathname]),Object(a.createElement)("section",{className:i()(["component-template-"+r,"base-template","animated","fadeIn","page-fade-speed",h.className?h.className:null])},Object(a.createElement)(o.l,null),h.children)},O=r(11),j=r.n(O),f=(r(136),function(e){var t=e.type,r=void 0===t?"common":t,n=e.children,s=c()(e,["type","children"]);return Object(a.createElement)(h,j()({type:r},s),n)}),g=r(10),v=r.n(g),_=r(38),w=r.n(_),E=r(4),y=r.n(E),N=(r(137),r(6)),S=r(135),k=r(7);function P(e,t){var r=Object.keys(e);if(Object.getOwnPropertySymbols){var n=Object.getOwnPropertySymbols(e);t&&(n=n.filter((function(t){return Object.getOwnPropertyDescriptor(e,t).enumerable}))),r.push.apply(r,n)}return r}function C(e){for(var t=1;t<arguments.length;t++){var r=null!=arguments[t]?arguments[t]:{};t%2?P(Object(r),!0).forEach((function(t){v()(e,t,r[t])})):Object.getOwnPropertyDescriptors?Object.defineProperties(e,Object.getOwnPropertyDescriptors(r)):P(Object(r)).forEach((function(t){Object.defineProperty(e,t,Object.getOwnPropertyDescriptor(r,t))}))}return e}var x=[{label:Object(l.__)("Popular","bluehost-wordpress-plugin"),value:"sort-sales-desc"},{label:Object(l.__)("Price (High to Low)","bluehost-wordpress-plugin"),value:"sort-price-desc"},{label:Object(l.__)("Price (Low to High)","bluehost-wordpress-plugin"),value:"sort-price-asc"},{label:Object(l.__)("Date Added","bluehost-wordpress-plugin"),value:"sort-date-desc"}],T=function(e){var t=e.type,r=void 0===t?"marketplace":t,n=e.className,s=void 0===n?"":n,u=e.isLoading,b=e.payload,p=e.render,m=e.marketplaceType,d=void 0===m?"themes":m,h=c()(e,["type","className","isLoading","payload","render","marketplaceType"]),O=Object(S.a)(),g=y()(O,2),v=g[0].favorites,_=g[1],E=_.hasFavorite,P=_.toggleFavorite,T=Object(S.c)(v),D=y()(T,1)[0],F=Object(S.f)(),L=y()(F,2),U=L[0],q=U.items,V=U.itemsPerPage,W=U.pageCount,I=U.pageNumber,R=L[1],B=R.setCollection,M=R.setPageNumber,A=Object(a.useState)("sort-sales-desc"),H=y()(A,2),Y=H[0],J=H[1],Q=Object(S.e)(),z=y()(Q,1)[0],G=Object(S.d)(),Z=y()(G,2),K=Z[0].query,X=Z[1],$=X.search,ee=X.setQuery;return s=i()("bluehost-marketplace",s),Object(a.useEffect)((function(){var e=b.items||[],t=Y.split("-"),r=y()(t,3),n=r[0],c=r[1],a=r[2];e="filter"===n?D(z(e,"sales"),c):z(e,c,a),e=$(e,K),B(e),M(1)}),[b,Y,K]),Object(a.useEffect)((function(){window.scrollTo(0,0)}),[I]),Object(a.createElement)(f,j()({type:r,className:s,marketplaceType:d},h),Object(a.createElement)("section",{className:"".concat(s,"__header")},Object(a.createElement)("div",{className:"".concat(s,"__header-primary")},Object(a.createElement)(N.d,{level:"h2",size:1,className:"marketplace-page-title"},function(e){switch(e){case"plugins":return Object(l.__)("Premium Plugins","bluehost-wordpress-plugin");case"services":return Object(l.__)("Premium Services","bluehost-wordpress-plugin");default:return Object(l.__)("Premium Themes","bluehost-wordpress-plugin")}}(d)),Object(a.createElement)("div",{className:"".concat(s,"__pagination-container")},Object(a.createElement)(N.g,{callback:M,currentPage:I,pageCount:W}))),Object(a.createElement)("div",{className:"".concat(s,"__header-secondary")},Object(a.createElement)(o.q,{value:K,onChange:ee}),Object(a.createElement)(N.c,{id:"sort-filter",label:Object(l.__)("Sort By","bluehost-wordpress-plugin"),onChange:function(e){return J(e)},options:x,value:Y,width:178}))),Object(a.createElement)("div",{className:"".concat(s,"__content")},u?Object(a.createElement)(o.p,null,w()(Array(V).keys()).map((function(e){return Object(a.createElement)(o.o,{key:e})}))):q&&q.length?Object(a.createElement)(o.p,null,q.map((function(e){return p({item:C(C({},e),{},{marketplaceType:d}),hasFavorite:E,toggleFavorite:P})}))):"filter-favorites"===Y?Object(a.createElement)("div",{className:"bluehost-no-results"},Object(a.createElement)(k.v,null),Object(a.createElement)("h2",null,Object(l.__)("You don't have any favorites yet.","bluehost-wordpress-plugin")),Object(a.createElement)("p",null,Object(l.__)("Add favorites by starring items you like.","bluehost-wordpress-plugin")),Object(a.createElement)("a",{href:"#",onClick:function(e){e.preventDefault(),J("sort-sales-desc")}},function(){switch(d){case"plugins":return Object(l.__)("View Plugins","bluehost-wordpress-plugin");case"services":return Object(l.__)("View Services","bluehost-wordpress-plugin");default:return Object(l.__)("View Themes","bluehost-wordpress-plugin")}}())):Object(a.createElement)(o.i,null)),Object(a.createElement)("footer",{className:"".concat(s,"__footer")},Object(a.createElement)("div",{className:"".concat(s,"__ad")}),Object(a.createElement)(N.g,{callback:M,currentPage:I,pageCount:W})))}},161:function(e,t,r){"use strict";t.a=r.p+"images/blue-sky-group.55b18632.png"},209:function(e,t,r){},261:function(e,t,r){"use strict";r.r(t);var n=r(1),c=(r(209),r(6)),a=r(7),s=r(138),o=r(167),l=r.n(o),u=r(4),i=r.n(u),b=r(252),p=r(262),m=r(265),d=r(10),h=r.n(d),O=r(3),j=r.n(O);function f(e){var t,r=e.className,c=e.group,a=e.isChecked,s=e.onChange,o=e.value;return Object(n.createElement)("label",{className:j()((t={btn:!0,"btn-secondary":!0},h()(t,"".concat(r,"__option"),!0),h()(t,"--is-active",a),t))},Object(n.createElement)("input",{checked:a,className:"".concat(r,"__option-field"),name:c,onClick:function(){a&&s("")},onChange:function(){s(o)},type:"radio",value:o}),Object(n.createElement)("span",{className:"".concat(r,"__option-field-label")},o))}function g(e){var t=e.className,r=e.defaultValue,c=void 0===r?"":r,a=e.group,s=e.onChange,o=e.options,l=Object(n.useState)(c),u=i()(l,2),b=u[0],p=u[1];return Object(n.createElement)("div",{className:"".concat(t,"__group")},o.map((function(e,r){return Object(n.createElement)(f,{className:t,group:a,isChecked:b===e,key:r,value:e,onChange:function(e){p(b!==e?e:""),s(e)}})})))}function v(e){var t=e.className,r=void 0===t?"resources-search-filters":t,c=e.defaultValue,a=e.group,s=e.label,o=e.onChange,l=e.options;return Object(n.createElement)("div",{className:r},Object(n.createElement)("span",{className:"".concat(r,"__label screen-reader-text")},s),Object(n.createElement)(g,{className:r,defaultValue:c,group:a,onChange:o,options:l}))}var _=r(2),w=r(250),E=Object(w.a)((function(e){var t=e.defaultRefinement,r=e.onSubmit,c=e.refine,s=Object(n.useState)(t),o=i()(s,2),l=o[0],u=o[1];return Object(n.createElement)("form",{action:"",className:"resources-search-form",noValidate:!0,onSubmit:function(e){e.preventDefault(),c(l),r(l)},role:"search"},Object(n.createElement)("input",{type:"text",placeholder:Object(_.__)("Search Resources","bluehost-wordpress-plugin"),value:l,onChange:function(e){return u(e.target.value)},"aria-label":Object(_.__)("Search","bluehost-wordpress-plugin")}),Object(n.createElement)("button",{type:"submit"},Object(n.createElement)(a.F,null),Object(n.createElement)("span",{className:"screen-reader-text"},Object(_.__)("Search Resources","bluehost-wordpress-plugin"))))})),y=r(263),N=r(251),S=r(8);function k(e,t){return e.length<=t?e:e.substr(0,t)+"..."}var P=function(e){var t=e.hasMore,r=e.onClick;return t?Object(n.createElement)("div",{className:"button-container"},Object(n.createElement)("button",{className:"components-button bluehost is-secondary is-link",onClick:r},Object(_.__)("More","bluehost-wordpress-plugin"))):null},C=Object(y.a)((function(e){e.hasMore;var t=e.hits,r=e.refineNext;return t.length?Object(n.createElement)(n.Fragment,null,Object(n.createElement)("div",{className:"resources-search-results"},t.map((function(e,t){var r=e.permalink,c=e.content,a=e.post_title,s=new URL(r);return s.host="bluehost.com",Object(n.createElement)("a",{className:"resource-card",href:Object(S.a)(s.toString(),{utm_content:"help_resource_card",utm_term:a}),key:t,rel:"noreferrer noopener",target:"_blank"},Object(n.createElement)("div",{className:"resource-card__title",dangerouslySetInnerHTML:{__html:a}}),Object(n.createElement)("div",{className:"resource-card__description",dangerouslySetInnerHTML:{__html:k(c,100)}}))}))),Object(n.createElement)(P,{hasMore:!1,onClick:r})):Object(n.createElement)("p",{className:"resource-search-no-results"},Object(_.__)("There were no results for your query. Please try again.","bluehost-wordpress-plugin"))})),x=Object(N.a)((function(){return Object(n.createElement)(C,null)})),T=r(231),D=r.n(T),F=r(5),L=D()("AVE0JWZU92","92e960b820b03fb532d5f440191ec0fe"),U=Object(b.a)(),q=function(){Object(n.useRef)(!0);var e=Object(n.useState)(""),t=i()(e,2),r=t[0],c=t[1],a=Object(n.useState)({query:r}),s=i()(a,2),o=s[0],l=s[1],u=Object(n.useState)(["post_type:post"]),b=i()(u,2),d=b[0],h=b[1],O=Object(n.useState)("Websites"),j=i()(O,2),f=j[0],g=j[1];return Object(n.useEffect)((function(){h(f?["post_type:post","taxonomies.category:".concat(f)]:["post_type:post"])}),[f]),Object(n.useEffect)((function(){Object(S.g)({action:"resource-center-search",data:{query:{text:r,category:f}}})}),[r,f]),Object(n.createElement)(n.Fragment,null,Object(n.createElement)(p.a,{indexName:"bh_rc_searchable_posts",searchClient:L,searchState:o,onSearchStateChange:l},Object(n.createElement)(m.a,{hitsPerPage:6,filters:Object(F.join)(d," AND "),distinct:!0}),Object(n.createElement)(E,{defaultRefinement:r,onSubmit:function(e){return c(e)}}),Object(n.createElement)(v,{defaultValue:f,group:"taxonomies.user_level_tax",label:Object(_.__)("Filter by","bluehost-wordpress-plugin"),onChange:function(e){return g(e)},options:["Websites","Marketing","Business"]}),Object(n.createElement)(x,{cache:U})))},V=r(161);t.default=function(){return Object(n.createElement)(s.a,{className:"page-help"},Object(n.createElement)(c.d,{level:"h2",size:0},Object(_.__)("Help","bluehost-wordpress-plugin")),Object(n.createElement)("div",{className:"clouds"},Object(n.createElement)("div",{className:"section-intro"},Object(n.createElement)("div",{style:{maxWidth:"1600px",margin:"0 auto"}},Object(n.createElement)("div",{className:"chat-button-container"},Object(n.createElement)(c.b,{className:"chat-button",href:Object(S.a)("https://helpchat.bluehost.com/",{utm_content:"help_chat_button",utm_term:"Chat with us"}),isPrimary:!0,rel:"noopener noreferrer",target:"_blank"},Object(_.__)("Chat with us","bluehost-wordpress-plugin")," ",Object(n.createElement)(a.h,{className:"chat-icon"})))),Object(n.createElement)("h3",{className:"section-title"},Object(_.__)("From DIY to full-service help","bluehost-wordpress-plugin")),Object(n.createElement)("p",{className:"section-description"},Object(_.__)("Feeling stuck? Choose how much help you'd like, from how-to articles to your own website concierge.","bluehost-wordpress-plugin"))),Object(n.createElement)("div",{className:"section-blue-sky"},Object(n.createElement)("div",{className:"section-title"},Object(n.createElement)(a.d,null),Object(n.createElement)("span",{className:"screen-reader-text"},Object(_.__)("Blue Sky","bluehost-wordpress-plugin"))),Object(n.createElement)("div",{className:"media-block"},Object(n.createElement)("div",{className:"media-block__media"},Object(n.createElement)("div",{className:"react-player-container"},Object(n.createElement)(l.a,{className:"react-player",height:"100%",light:V.a,playIcon:Object(n.createElement)("span",null),url:"https://www.youtube.com/embed/QEir4T7VweY",width:"100%"}))),Object(n.createElement)("div",{className:"media-block__details"},Object(n.createElement)("div",{className:"media-block__title"},Object(_.__)("Get your own website guide","bluehost-wordpress-plugin")),Object(n.createElement)("div",{className:"media-block__description"},Object(_.__)("Our WordPress experts can jump in wherever you need help, teaching you how to build, grow, and maintain your website.","bluehost-wordpress-plugin")),Object(n.createElement)(c.b,{className:"media-block__button",href:"#/marketplace/services/blue-sky",isSecondary:!0,onClick:function(){window.scrollTo(0,0)}},Object(_.__)("Get Blue Sky","bluehost-wordpress-plugin")))))),Object(n.createElement)("div",{className:"section-featured-services"},Object(n.createElement)("div",{className:"section-title"},Object(_.__)("Let us do it for you","bluehost-wordpress-plugin")),Object(n.createElement)("p",{className:"section-description"},Object(_.__)("What can we help you achieve today?","bluehost-wordpress-plugin")),Object(n.createElement)("div",{className:"featured-services"},Object(n.createElement)("div",{className:"featured-services-list"},Object(n.createElement)("div",{className:"featured-service"},Object(n.createElement)("div",{className:"featured-service__image"},Object(n.createElement)(a.j,null)),Object(n.createElement)("div",{className:"featured-service__title"},Object(_.__)("Full-Service Website","bluehost-wordpress-plugin")),Object(n.createElement)("div",{className:"featured-service__description"},Object(_.__)("Ongoing marketing assistance and design","bluehost-wordpress-plugin")),Object(n.createElement)(c.b,{className:"featured-service__button","data-testid":"full-service",href:"https://www.bluehost.com/solutions/full-service#full-service",isSecondary:!0,utmContent:"help_full_service"},Object(_.__)("Learn more","bluehost-wordpress-plugin"))),Object(n.createElement)("div",{className:"featured-service"},Object(n.createElement)("div",{className:"featured-service__image"},Object(n.createElement)(a.D,null)),Object(n.createElement)("div",{className:"featured-service__title"},Object(_.__)("SEO Services","bluehost-wordpress-plugin")),Object(n.createElement)("div",{className:"featured-service__description"},Object(_.__)("Fine tune your website for better visibility","bluehost-wordpress-plugin")),Object(n.createElement)(c.b,{className:"featured-service__button","data-testid":"seo-services",href:"https://www.bluehost.com/solutions/full-service#seo-services",isSecondary:!0,utmContent:"help_seo_services"},Object(_.__)("Learn more","bluehost-wordpress-plugin"))),Object(n.createElement)("div",{className:"featured-service"},Object(n.createElement)("div",{className:"featured-service__image"},Object(n.createElement)(a.g,null)),Object(n.createElement)("div",{className:"featured-service__title"},Object(_.__)("Our experts can help","bluehost-wordpress-plugin")),Object(n.createElement)("div",{className:"featured-service__description"},Object(_.__)("Consult with an expert to figure out the best next steps.","bluehost-wordpress-plugin")),Object(n.createElement)(c.b,{className:"featured-service__button",href:"https://www.bluehost.com/solutions/full-service#request-form",isSecondary:!0,utmContent:"help_request_consultation"},Object(_.__)("Request a consultation","bluehost-wordpress-plugin")))))),Object(n.createElement)("div",{className:"section-resources"},Object(n.createElement)("div",{className:"section-title"},Object(_.__)("DIY","bluehost-wordpress-plugin")),Object(n.createElement)("p",{className:"section-description"},Object(_.__)("Checkout our resource center for helpful how-to articles and guides.","bluehost-wordpress-plugin")),Object(n.createElement)("div",{className:"resources-search"},Object(n.createElement)(q,null),Object(n.createElement)(c.a,{className:"button-container"},Object(n.createElement)(c.b,{href:"https://www.bluehost.com/resources/",isSecondary:!0,utmContent:"help_visit_resource_center"},Object(_.__)("Visit resource center","bluehost-wordpress-plugin"))))),Object(n.createElement)("footer",{className:"help-footer"},Object(n.createElement)("a",{className:"call-to-action",href:"tel:8884014678"},Object(n.createElement)(a.f,{className:"footer-icon"}),Object(n.createElement)("span",null,Object(_.__)("888-401-4678","bluehost-wordpress-plugin"))),Object(n.createElement)("a",{className:"call-to-action",href:Object(S.a)("https://helpchat.bluehost.com/",{utm_content:"help_chat_link",utm_term:"Chat with us"})},Object(n.createElement)(a.h,{className:"footer-icon"}),Object(n.createElement)("span",null,Object(_.__)("Chat with us","bluehost-wordpress-plugin")))))}}}]);