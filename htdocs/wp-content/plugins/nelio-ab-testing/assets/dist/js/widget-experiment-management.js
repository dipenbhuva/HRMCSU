(()=>{var e={n:t=>{var n=t&&t.__esModule?()=>t.default:()=>t;return e.d(n,{a:n}),n},d:(t,n)=>{for(var i in n)e.o(n,i)&&!e.o(t,i)&&Object.defineProperty(t,i,{enumerable:!0,get:n[i]})},o:(e,t)=>Object.prototype.hasOwnProperty.call(e,t),r:e=>{"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})}},t={};(()=>{"use strict";e.r(t);var n={};e.r(n),e.d(n,{initAlternativeEdition:()=>O,initControlEdition:()=>S});var i={};e.r(i),e.d(i,{initAlternativeEdition:()=>W,initControlEdition:()=>T});const r=window.wp.element;function o(e,t){t&&(r.createRoot?(0,r.createRoot)(t).render(e):(0,r.render)(e,t))}const a=window.wp.data,l=window.wp.blockEditor,c=window.nab.utils,u=window.lodash;var d,s=function(e,t,n){if(n||2===arguments.length)for(var i,r=0,o=t.length;r<o;r++)!i&&r in t||(i||(i=Array.prototype.slice.call(t,0,r)),i[r]=t[r]);return e.concat(i||Array.prototype.slice.call(t))},f=null!==(d=null===l.store||void 0===l.store?void 0:l.store.name)&&void 0!==d?d:"core/block-editor";function p(e){var t=document.getElementById("nab-widget-global-style");if(t){var n=e.reduce((function(e,t){return"".concat(e,"\n#block-").concat(t," { display: none; }")}),"");t.textContent=n}}function m(e){var t=e.attributes.id;return"string"==typeof t&&t.startsWith("nab_alt_sidebar")}const b=window.wp.apiFetch;var v=e.n(b);const w=window.wp.date,g=window.wp.url;var y=function(){return y=Object.assign||function(e){for(var t,n=1,i=arguments.length;n<i;n++)for(var r in t=arguments[n])Object.prototype.hasOwnProperty.call(t,r)&&(e[r]=t[r]);return e},y.apply(this,arguments)};const h=function(e){var t=e.url,n=e.path,i=(0,w.format)("YmjHi").substring(0,11)+"0";return v()(y(y(y({},e),t&&{url:E(e)?(0,g.addQueryArgs)(t,{nabts:i}):t}),n&&{path:(0,g.addQueryArgs)(n,{nabts:i})}))};var E=function(e){var t,n;return!!(null===(t=e.url)||void 0===t?void 0:t.includes("/wp-json/"))||!!(null===(n=e.url)||void 0===n?void 0:n.includes("rest_route"))||!!Object.keys(e).includes("rest_route")};const _=window.wp.components,x=window.wp.i18n,C=window.nab.components;var A=function(e){var t=e.experiment,n=e.alternative,i=(0,r.useState)(!1),o=i[0],a=i[1],l=(0,r.useState)(!1),c=l[0],u=l[1],d=o?(0,x._x)("Duplicating…","text (widgets)","nelio-ab-testing"):(0,x._x)("Duplicate","command","nelio-ab-testing");return r.createElement(r.Fragment,null,r.createElement(_.Button,{variant:"secondary",onClick:function(){return u(!0)}},(0,x._x)("Duplicate Control Widgets","command","nelio-ab-testing")),r.createElement(C.ConfirmationDialog,{title:(0,x._x)("Duplicate Control Widgets?","title","nelio-ab-testing"),text:(0,x._x)("This will overwrite any widgets you may have in this variant with those included in your theme. Are you sure you want to continue?","user","nelio-ab-testing"),confirmLabel:d,isConfirmEnabled:!o,isCancelEnabled:!o,isDismissible:!o,isOpen:c,onCancel:function(){return u(!1)},onConfirm:function(){o||(a(!0),h({path:(0,g.addQueryArgs)("/nab/v1/widget/duplicate-control",{experiment:t,alternative:n}),method:"PUT"}).finally((function(){return window.location.reload()})))}}))};function S(){var e,t;e=[],t=(0,u.debounce)((function(){var t=(0,a.select)(f).getBlocks().filter((function(e){return"core/widget-area"===e.name})),n=t.map((function(e){return e.clientId}));if(!(0,c.areEqual)(e,n)){e=n;var i=t.filter(m).map((function(e){return e.clientId}));p(i)}}),100),(0,a.subscribe)(t),t()}function O(e){!function(e){e=s(s([],e,!0),["wp_inactive_widgets"],!1);var t=[],n=(0,u.debounce)((function(){var n=(0,a.select)(f).getBlocks().filter((function(e){return"core/widget-area"===e.name})),i=n.map((function(e){return e.clientId}));if(!(0,c.areEqual)(t,i)){t=i;var r=n.filter((function(t){var n=t.attributes.id;return!e.includes(n)})).map((function(e){return e.clientId}));p(r)}}),100);(0,a.subscribe)(n),n()}(e.sidebars),function(e){var t=0,n=function(){var i,a=document.querySelector(".edit-widgets-header__actions");!(null===(i=null==a?void 0:a.children)||void 0===i?void 0:i.length)&&t<40?setTimeout(n,250*++t):a&&function(t){var n=t.children[0];if(n){var i=document.createElement("div");t.insertBefore(i,n),o(r.createElement(A,{experiment:e.experiment,alternative:e.alternative}),i)}}(a)};n()}(e)}const D=window.nab.data;function j(){return Array.from(document.querySelectorAll("div[id^=nab_alt_sidebar_]"))}function k(){j().forEach((function(e){return function(e){var t=function(e){var t=e.replace(/^nab_alt_sidebar_[0-9]+_([^-]+-){4}[^-]+_/,"");return t===e?"":t}(e.getAttribute("id")||"");if(t){var n=document.getElementById(t);n&&e.parentElement&&n.parentElement&&(0,c.appendSibling)(e.parentElement,n.parentElement)}}(e)}))}var P=function(e){var t=e.experiment,n=e.alternative,i=B(),o=i[0],a=i[1],l=q(t,n),c=l[0],u=l[1];return r.createElement("span",null,r.createElement(_.Button,{className:"page-title-action",onClick:function(){return a(!0)},style:{height:"auto"}},(0,x._x)("Duplicate Control Widgets","command","nelio-ab-testing")),r.createElement(C.ConfirmationDialog,{title:(0,x._x)("Duplicate Control Widgets?","title","nelio-ab-testing"),text:(0,x._x)("This will overwrite any widgets you may have in this variant with those included in your theme. Are you sure you want to continue?","user","nelio-ab-testing"),confirmLabel:c?(0,x._x)("Duplicating…","text (widgets)","nelio-ab-testing"):(0,x._x)("Duplicate","command","nelio-ab-testing"),isConfirmEnabled:!c,isCancelEnabled:!c,isOpen:o,onCancel:function(){return a(!1)},onConfirm:u}))},B=function(){return(0,D.usePageAttribute)("widgets/isConfirmationDialogForWidgetDuplicationVisible",!1)},q=function(e,t){var n=(0,D.usePageAttribute)("widgets/isDuplicatingWidgets",!1),i=n[0],o=n[1];return(0,r.useEffect)((function(){i&&h({path:(0,g.addQueryArgs)("/nab/v1/widget/duplicate-control",{experiment:e,alternative:t}),method:"PUT"}).finally((function(){window.location.reload()}))}),[i]),[i,function(){return o(!0)}]};function T(){k(),j().forEach((function(e){e.parentElement&&(e.parentElement.style.display="none")}))}function W(e){var t;k(),Array.from(document.querySelectorAll(".sidebars-column-1 > .widgets-holder-wrap, .sidebars-column-2 > .widgets-holder-wrap")).forEach((function(e){return e.style.display="none"})),(0,u.filter)(e.sidebars.map((function(e){return document.getElementById(e)})),(function(e){return!!e})).forEach((function(e){e.parentElement&&(e.parentElement.style.display="block")})),(t=document.querySelector("#wpbody-content .wrap .wp-heading-inline"))&&(t.textContent=(0,x._x)("Widget Variant","text","nelio-ab-testing")),Array.from(document.querySelectorAll(".page-title-action")).forEach((function(e){return e.remove()})),function(e){var t=document.querySelector("#wpbody-content .wrap .wp-heading-inline"),n=document.createElement("div");o(r.createElement(P,{experiment:e.experiment,alternative:e.alternative}),n);var i=n.children[0],a=document.createElement("a");a.className="page-title-action",a.textContent=(0,x._x)("Back to Test","command","nelio-ab-testing"),a.setAttribute("href",e.links.experimentUrl),t&&((0,c.appendSibling)(a,t),i&&(0,c.appendSibling)(i,t))}(e)}var I,M=function(){return M=Object.assign||function(e){for(var t,n=1,i=arguments.length;n<i;n++)for(var r in t=arguments[n])Object.prototype.hasOwnProperty.call(t,r)&&(e[r]=t[r]);return e},M.apply(this,arguments)};window.nab=M(M({},(I=window)&&"object"==typeof I&&"nab"in I?window.nab:{}),{widgets:{blocks:n,classic:i}})})();var n=nab="undefined"==typeof nab?{}:nab;for(var i in t)n[i]=t[i];t.__esModule&&Object.defineProperty(n,"__esModule",{value:!0})})();