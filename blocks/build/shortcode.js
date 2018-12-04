!function(e){var t={};function n(r){if(t[r])return t[r].exports;var o=t[r]={i:r,l:!1,exports:{}};return e[r].call(o.exports,o,o.exports,n),o.l=!0,o.exports}n.m=e,n.c=t,n.d=function(e,t,r){n.o(e,t)||Object.defineProperty(e,t,{enumerable:!0,get:r})},n.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},n.t=function(e,t){if(1&t&&(e=n(e)),8&t)return e;if(4&t&&"object"==typeof e&&e&&e.__esModule)return e;var r=Object.create(null);if(n.r(r),Object.defineProperty(r,"default",{enumerable:!0,value:e}),2&t&&"string"!=typeof e)for(var o in e)n.d(r,o,function(t){return e[t]}.bind(null,o));return r},n.n=function(e){var t=e&&e.__esModule?function(){return e.default}:function(){return e};return n.d(t,"a",t),t},n.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},n.p="",n(n.s=0)}([function(e,t,n){"use strict";var r,o,i,l,a,u,c,f,s=function(){function e(e,t){for(var n=0;n<t.length;n++){var r=t[n];r.enumerable=r.enumerable||!1,r.configurable=!0,"value"in r&&(r.writable=!0),Object.defineProperty(e,r.key,r)}}return function(t,n,r){return n&&e(t.prototype,n),r&&e(t,r),t}}();r=window.wp,o=r.blocks.registerBlockType,i=r.element,l=i.Component,a=i.Fragment,u=r.components,c=u.SelectControl,f=u.Spinner,o("egoi-for-wp/shortcode",{title:"E-goi - Formulários",description:"Shortcode dos formularios criados no plugin do E-goi",category:"embed",icon:React.createElement("svg",{viewBox:"0 0 372 271",fill:"none",xmlns:"http://www.w3.org/2000/svg"},React.createElement("path",{d:"M249.006 3.05893L123.184 0.355957L118.309 270.653L164.883 224.495L257.823 214.203L249.006 3.05893Z",fill:"#00AEDA"}),React.createElement("path",{d:"M103.057 2.53906L110.111 217.737C81.2745 223.039 19.3487 213.995 2.85594 135.193C-13.6368 56.3905 62.7071 13.8707 103.057 2.53906Z",fill:"#00AEDA"}),React.createElement("path",{d:"M265.07 40.5884L267.456 210.564C296.292 215.866 357.285 211.083 370.251 149.435C383.217 87.7864 305.524 51.1923 265.07 40.5884Z",fill:"#00AEDA"})),keywords:["egoi","e-goi","shortcode"],attributes:{form:{type:"string",default:null}},edit:function(e){function t(e){!function(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}(this,t);var n=function(e,t){if(!e)throw new ReferenceError("this hasn't been initialised - super() hasn't been called");return!t||"object"!=typeof t&&"function"!=typeof t?e:t}(this,(t.__proto__||Object.getPrototypeOf(t)).apply(this,arguments));return n.props=e,n.state={forms:null,loading:!0},n}return function(e,t){if("function"!=typeof t&&null!==t)throw new TypeError("Super expression must either be null or a function, not "+typeof t);e.prototype=Object.create(t&&t.prototype,{constructor:{value:e,enumerable:!1,writable:!0,configurable:!0}}),t&&(Object.setPrototypeOf?Object.setPrototypeOf(e,t):e.__proto__=t)}(t,l),s(t,[{key:"componentDidMount",value:function(){var e=this;$.get(ajax_url,{action:"get_egoi_forms"}).done(function(t){var n=JSON.parse(t);if(null!=n){var r=[{label:"Selecione",value:""}];for(var o in n){var i=n[o];r.push({label:i.title+" ("+i.id+")",value:i.shortcode})}e.setState(function(){return{forms:r}})}e.setState(function(){return{loading:!1}})})}},{key:"render",value:function(){var e=this.props,t=e.attributes.form,n=e.setAttributes,r=(e.isSelected,this.state.forms),o=this.state.loading;return React.createElement(a,null,null==r&&o&&React.createElement("div",{style:{display:"flex",alignItems:"center",justifyContent:"center",height:"65px",backgroundColor:"rgba(139,139,150,.1)"}},React.createElement(f,null)),null!=r&&!o&&React.createElement(c,{label:"Selecione um formulários",value:t,options:r,onChange:function(e){n({form:e})}}),null==r&&!o&&React.createElement("p",null,"Ainda não tem formulários criados no plugin do E-goi."))}}]),t}(),save:function(e){var t=e.attributes.form;return React.createElement(a,null,t)}})}]);