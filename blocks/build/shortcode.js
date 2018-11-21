!function(e){var t={};function n(o){if(t[o])return t[o].exports;var r=t[o]={i:o,l:!1,exports:{}};return e[o].call(r.exports,r,r.exports,n),r.l=!0,r.exports}n.m=e,n.c=t,n.d=function(e,t,o){n.o(e,t)||Object.defineProperty(e,t,{enumerable:!0,get:o})},n.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},n.t=function(e,t){if(1&t&&(e=n(e)),8&t)return e;if(4&t&&"object"==typeof e&&e&&e.__esModule)return e;var o=Object.create(null);if(n.r(o),Object.defineProperty(o,"default",{enumerable:!0,value:e}),2&t&&"string"!=typeof e)for(var r in e)n.d(o,r,function(t){return e[t]}.bind(null,r));return o},n.n=function(e){var t=e&&e.__esModule?function(){return e.default}:function(){return e};return n.d(t,"a",t),t},n.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},n.p="",n(n.s=0)}([function(e,t,n){"use strict";var o,r,l,i,a,u,c,s,f,p=function(){function e(e,t){for(var n=0;n<t.length;n++){var o=t[n];o.enumerable=o.enumerable||!1,o.configurable=!0,"value"in o&&(o.writable=!0),Object.defineProperty(e,o.key,o)}}return function(t,n,o){return n&&e(t.prototype,n),o&&e(t,o),t}}();o=window.wp,r=o.blocks.registerBlockType,(l=o.editor).InspectorControls,l.MediaUpload,l.InnerBlocks,i=o.element,a=i.Component,u=i.Fragment,(c=o.components).Button,c.PanelBody,c.TextControl,c.TextareaControl,c.CheckboxControl,s=c.SelectControl,f=c.Spinner,r("blocos/shortcode",{title:"E-goi - Formulários",description:"Shortcode dos formularios criados no plugin do E-goi",category:"embed",icon:React.createElement("svg",{viewBox:"0 0 372 271",fill:"none",xmlns:"http://www.w3.org/2000/svg"},React.createElement("path",{d:"M249.006 3.05893L123.184 0.355957L118.309 270.653L164.883 224.495L257.823 214.203L249.006 3.05893Z",fill:"#00AEDA"}),React.createElement("path",{d:"M103.057 2.53906L110.111 217.737C81.2745 223.039 19.3487 213.995 2.85594 135.193C-13.6368 56.3905 62.7071 13.8707 103.057 2.53906Z",fill:"#00AEDA"}),React.createElement("path",{d:"M265.07 40.5884L267.456 210.564C296.292 215.866 357.285 211.083 370.251 149.435C383.217 87.7864 305.524 51.1923 265.07 40.5884Z",fill:"#00AEDA"})),keywords:["egoi","e-goi","shortcode"],attributes:{form:{type:"string",default:null}},edit:function(e){function t(e){!function(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}(this,t);var n=function(e,t){if(!e)throw new ReferenceError("this hasn't been initialised - super() hasn't been called");return!t||"object"!=typeof t&&"function"!=typeof t?e:t}(this,(t.__proto__||Object.getPrototypeOf(t)).apply(this,arguments));return n.props=e,n.state={forms:null,loading:!0},n}return function(e,t){if("function"!=typeof t&&null!==t)throw new TypeError("Super expression must either be null or a function, not "+typeof t);e.prototype=Object.create(t&&t.prototype,{constructor:{value:e,enumerable:!1,writable:!0,configurable:!0}}),t&&(Object.setPrototypeOf?Object.setPrototypeOf(e,t):e.__proto__=t)}(t,a),p(t,[{key:"componentDidMount",value:function(){var e=this;$.get(ajax_url,{action:"get_egoi_forms"}).done(function(t){var n=JSON.parse(t);if(null!=n){var o=[{label:"Selecione",value:""}];for(var r in n){var l=n[r];o.push({label:l.title+" ("+l.id+")",value:l.shortcode})}e.setState(function(){return{forms:o}})}e.setState(function(){return{loading:!1}})})}},{key:"render",value:function(){var e=this.props,t=e.attributes.form,n=e.setAttributes,o=(e.isSelected,this.state.forms),r=this.state.loading;return React.createElement(u,null,null==o&&r&&React.createElement("div",{style:{display:"flex",alignItems:"center",justifyContent:"center",height:"65px",backgroundColor:"rgba(139,139,150,.1)"}},React.createElement(f,null)),null!=o&&!r&&React.createElement(s,{label:"Selecione um formulários",value:t,options:o,onChange:function(e){n({form:e})}}),null==o&&!r&&React.createElement("p",null,"Ainda não tem formulários criados no plugin do E-goi."))}}]),t}(),save:function(e){var t=e.attributes.form;return React.createElement(u,null,t)}})}]);