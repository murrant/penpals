(window.webpackJsonp=window.webpackJsonp||[]).push([[0],{0:function(t,e,s){s("bUC5"),t.exports=s("pyCd")},"0O3m":function(t,e,s){"use strict";s.r(e);var n={name:"PenpalList",data:function(){return{penpals:[]}},mounted:function(){var t=this;axios.get("ajax/users").then((function(e){return t.penpals=e.data.penpals}))}},a=s("KHd+"),r=Object(a.a)(n,(function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("ul",t._l(t.penpals,(function(e){return s("li",[t._v(t._s(e.first_name)+" "+t._s(e.last_name))])})),0)}),[],!1,null,"7f504999",null);e.default=r.exports},"2+Tj":function(t,e,s){var n=s("UD4e");"string"==typeof n&&(n=[[t.i,n,""]]);var a={hmr:!0,transform:void 0,insertInto:void 0};s("aET+")(n,a);n.locals&&(t.exports=n.locals)},"7eC/":function(t,e,s){"use strict";s.r(e);var n={name:"AddressListItem",props:{address:{type:Object,required:!0}},data:function(){return{completed:null!==this.address.completed}},watch:{completed:function(){this.$emit("address-completed",{id:this.address.id,value:this.completed})}}},a=(s("GrRG"),s("KHd+")),r=Object(a.a)(n,(function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("div",{staticClass:"address-panel row"},[s("div",[s("div",{staticClass:"card-group"},t._l(t.address.residents,(function(t){return s("resident",{key:t.id,attrs:{resident:t}})})),1),t._v(" "),s("mailing-address",{attrs:{address:t.address}})],1),t._v(" "),s("div",[s("input",{directives:[{name:"model",rawName:"v-model",value:t.completed,expression:"completed"}],staticClass:"form-control",attrs:{type:"checkbox"},domProps:{checked:Array.isArray(t.completed)?t._i(t.completed,null)>-1:t.completed},on:{change:function(e){var s=t.completed,n=e.target,a=!!n.checked;if(Array.isArray(s)){var r=t._i(s,null);n.checked?r<0&&(t.completed=s.concat([null])):r>-1&&(t.completed=s.slice(0,r).concat(s.slice(r+1)))}else t.completed=a}}})])])}),[],!1,null,"3b399297",null);e.default=r.exports},"9P+s":function(t,e,s){"use strict";s.r(e);var n={name:"AddressList",props:{name:{type:String,required:!0}},data:function(){return{addresses:[]}},mounted:function(){var t=this;axios.get("ajax/address").then((function(e){return t.addresses=e.data.addresses}))},computed:{assigned:function(){return this.addresses.filter((function(t){return null===t.completed}))},completed:function(){return this.addresses.filter((function(t){return null!==t.completed}))}},methods:{changeCompleted:function(t){var e=this;axios.put("ajax/address/"+t.id,{completed:t.value}).then((function(t){e.addresses=e.addresses.map((function(e){return e.id===t.data.id&&(e.completed=t.data.completed),e}))}))},chunk:function(t,e){return t.reduce((function(t,s,n){return(n%e?t[t.length-1].push(s):t.push([s]))&&t}),[])}}},a=(s("HLKQ"),s("KHd+")),r=Object(a.a)(n,(function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("div",{staticClass:"container"},[s("div",{staticClass:"row non-printable"},[s("div",{staticClass:"col-lg-8 col-md-10 col-sm-12 offset-lg-2 offset-md-1"},[s("div",{staticClass:"card"},[s("div",{staticClass:"card-header"},[t._v("Assigned PenPals ("+t._s(t.assigned.length)+")")]),t._v(" "),s("div",{staticClass:"card-body"},[t.assigned.length>0?s("div",{staticClass:"list-header"},[t._m(0),t._v(" "),t._m(1)]):s("div",[t._v("\n                        All letters sent! :D"),s("br"),t._v(" "),s("a",{staticClass:"btn btn-primary",attrs:{role:"button",href:"/address-request/create"}},[t._v("Request More")])]),t._v(" "),t._l(t.assigned,(function(e){return s("address-list-item",{key:e.id,attrs:{address:e},on:{"address-completed":t.changeCompleted}})}))],2)])])]),t._v(" "),t._m(2),t._v(" "),s("div",{staticClass:"row mt-3 non-printable"},[s("div",{staticClass:"col-lg-8 col-md-10 col-sm-12 offset-lg-2 offset-md-1"},[s("div",{staticClass:"card"},[s("div",{staticClass:"card-header"},[t._v("Completed ("+t._s(t.completed.length)+")")]),t._v(" "),t.completed.length>0?s("div",{staticClass:"card-body"},[t._m(3),t._v(" "),t._l(t.completed,(function(e){return s("address-list-item",{key:e.id,attrs:{address:e},on:{"address-completed":t.changeCompleted}})}))],2):t._e()])])]),t._v(" "),s("div",{staticClass:"printable"},[s("h3",[t._v("Penpals for: "+t._s(this.name))]),t._v(" "),s("table",t._l(t.chunk(this.assigned,2),(function(e){return s("tr",t._l(e,(function(t){return s("td",{staticStyle:{padding:"30px","font-size":"1.3em"}},[s("mailing-address",{attrs:{address:t}})],1)})),0)})),0)])])}),[function(){var t=this.$createElement,e=this._self._c||t;return e("div",[e("h4",[this._v("PenPal")])])},function(){var t=this.$createElement,e=this._self._c||t;return e("div",{staticStyle:{"justify-self":"end"}},[e("h4",[this._v("Mail Sent?")])])},function(){var t=this.$createElement,e=this._self._c||t;return e("div",{staticClass:"row mt-3 non-printable"},[e("div",{staticClass:"col-lg-8 col-md-10 col-sm-12 offset-lg-2 offset-md-1"},[this._v("\n            If you would like to request more addresses, take a picture of your letters before you mail them!\n        ")])])},function(){var t=this.$createElement,e=this._self._c||t;return e("div",{staticClass:"list-header"},[e("div",[e("h4",[this._v("PenPal")])]),this._v(" "),e("div",{staticStyle:{"justify-self":"end"}},[e("h4",[this._v("Mail Sent?")])])])}],!1,null,"0d86d7f8",null);e.default=r.exports},"9Wh1":function(t,e,s){window._=s("LvDl");try{window.Popper=s("8L3F").default,window.$=window.jQuery=s("EVdn"),s("SYky")}catch(t){}window.axios=s("vDqi"),window.axios.defaults.headers.common["X-Requested-With"]="XMLHttpRequest",window.toastr=s("hUol"),"serviceWorker"in navigator&&navigator.serviceWorker.getRegistrations().then((function(t){var e=!0,s=!1,n=void 0;try{for(var a,r=t[Symbol.iterator]();!(e=(a=r.next()).done);e=!0){a.value.unregister().then((function(){return self.clients.matchAll()})).then((function(t){t.forEach((function(t){t.url&&"navigate"in t&&t.navigate(t.url)}))}))}}catch(t){s=!0,n=t}finally{try{e||null==r.return||r.return()}finally{if(s)throw n}}}))},D3tQ:function(t,e,s){"use strict";var n=s("t0ra");s.n(n).a},DS06:function(t,e,s){"use strict";var n=s("NmzX");s.n(n).a},FHMg:function(t,e,s){"use strict";s.r(e);var n={name:"Resident",props:{resident:{type:Object,require:!0}},data:function(){return{shown:!1}},computed:{primary:function(){return"Primary"===this.resident.relation}}},a=(s("D3tQ"),s("KHd+")),r=Object(a.a)(n,(function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("div",{staticClass:"card"},[s("div",{class:{"card-header":!0,"bg-info":t.primary,"text-light":t.primary},on:{click:function(e){t.shown=!t.shown}}},[t._v("\n        "+t._s(t.resident.name)+"\n    ")]),t._v(" "),s("div",{directives:[{name:"show",rawName:"v-show",value:t.shown,expression:"shown"}],staticClass:"card-body"},[s("div",[t._v("Age: "+t._s(t.resident.age_range))]),t._v(" "),s("div",[t._v("Gender: "+t._s(t.resident.gender))]),t._v(" "),t.primary?t._e():s("div",[t._v("Relation: "+t._s(t.resident.relation))])])])}),[],!1,null,"27aae9a0",null);e.default=r.exports},GrRG:function(t,e,s){"use strict";var n=s("2+Tj");s.n(n).a},HLKQ:function(t,e,s){"use strict";var n=s("Ohjs");s.n(n).a},IC88:function(t,e,s){"use strict";s.r(e);var n={name:"AddressRequest",props:{request:Object,penpal:Object,sent:Number,previous:Array},data:function(){return{amount:this.request.amount,reason:"",pending:!0}},methods:{submitApproval:function(t){var e=this,s=new FormData;s.append("amount",this.amount),s.append("message",this.reason);var n="/address-request/"+this.request.id+"/"+t;axios.post(n,s).then((function(t){return e.pending=!1}))}}},a=(s("DS06"),s("KHd+")),r=Object(a.a)(n,(function(){var t=this,e=t.$createElement,s=t._self._c||e;return t.pending?s("div",{staticClass:"card mb-3"},[s("div",{staticClass:"card-header"},[s("h4",[t._v(t._s(t.penpal.first_name)+" "+t._s(t.penpal.last_name))]),t._v("\n        "+t._s(t.penpal.email)),s("br"),t._v("\n        Total Sent: "+t._s(t.sent)+"\n    ")]),t._v(" "),s("div",{staticClass:"card-body"},[s("div",{staticClass:"row"},[t._m(0),t._v(" "),s("div",{staticClass:"col"},[s("img",{staticClass:"proof img-fluid",attrs:{src:"/img/"+t.request.image}})])]),t._v(" "),t.previous.length>0?s("div",{staticClass:"row"},[t._m(1),t._v(" "),s("div",{staticClass:"col-12"},t._l(t.previous,(function(t){return s("img",{staticClass:"previous-images img-fluid",attrs:{src:"/img/"+t}})})),0)]):t._e(),t._v(" "),s("div",{staticClass:"row"},[t._m(2),t._v(" "),s("div",{staticClass:"col"},[s("p",{staticClass:"card-text"},[t._v(t._s(t.request.note))])])]),t._v(" "),s("div",{staticClass:"row"},[s("div",{staticClass:"col"},[s("label",[t._v(" Addresses\n                    "),s("input",{directives:[{name:"model",rawName:"v-model",value:t.amount,expression:"amount"}],staticClass:"form-control",attrs:{type:"number",name:"amount"},domProps:{value:t.amount},on:{input:function(e){e.target.composing||(t.amount=e.target.value)}}})])])]),t._v(" "),s("div",{staticClass:"row"},[s("div",{staticClass:"col"},[s("label",[t._v(" Message (Give a reason if denying)\n                    "),s("textarea",{directives:[{name:"model",rawName:"v-model",value:t.reason,expression:"reason"}],staticClass:"form-control",attrs:{type:"text",name:"reason",placeholder:"Message",cols:"70",rows:"5"},domProps:{value:t.reason},on:{input:function(e){e.target.composing||(t.reason=e.target.value)}}})])])]),t._v(" "),s("div",{staticClass:"row"},[s("div",{staticClass:"col"},[s("button",{staticClass:"btn btn-primary",attrs:{type:"submit"},on:{click:function(e){return t.submitApproval("approve")}}},[t._v("Approve")]),t._v("\n                 \n                "),s("button",{staticClass:"btn btn-primary",attrs:{type:"submit"},on:{click:function(e){return t.submitApproval("deny")}}},[t._v("Deny")])])])])]):t._e()}),[function(){var t=this.$createElement,e=this._self._c||t;return e("div",{staticClass:"col-12"},[e("h5",[this._v("Proof of letters sent")])])},function(){var t=this.$createElement,e=this._self._c||t;return e("div",{staticClass:"col-12 mt-3"},[e("h5",[this._v("Previous request images")])])},function(){var t=this.$createElement,e=this._self._c||t;return e("div",{staticClass:"col-12 mt-3"},[e("h5",[this._v("Message from requester")])])}],!1,null,"8c978d74",null);e.default=r.exports},NmzX:function(t,e,s){var n=s("xkbp");"string"==typeof n&&(n=[[t.i,n,""]]);var a={hmr:!0,transform:void 0,insertInto:void 0};s("aET+")(n,a);n.locals&&(t.exports=n.locals)},Ohjs:function(t,e,s){var n=s("eUzT");"string"==typeof n&&(n=[[t.i,n,""]]);var a={hmr:!0,transform:void 0,insertInto:void 0};s("aET+")(n,a);n.locals&&(t.exports=n.locals)},UD4e:function(t,e,s){(t.exports=s("I1BE")(!1)).push([t.i,"\n.address-panel[data-v-3b399297] {\n    display: grid;\n    grid-template-columns: auto 80px;\n    /*grid-gap: 10px;*/\n    margin-bottom: 25px;\n}\n.resident-panel[data-v-3b399297] {\n    display: grid;\n    grid-gap: 10px;\n}\n",""])},anru:function(t,e,s){"use strict";s.r(e);var n={name:"Address",props:{address:{type:Object,required:!0}},computed:{addressLines:function(){var t=[];t.push(this.address.address_number+" "+(this.address.unit?this.address.unit+" ":"")+this.address.street);var e=[this.address.building,this.address.floor,this.address.room,this.address.additional].filter((function(t){return t}));return e.length>0&&t.push(e.join(" ")),t.push(this.address.city+", "+this.address.state+" "+this.address.zip+(this.address.zip4?"-"+this.address.zip4:"")),t}}},a=s("KHd+"),r=Object(a.a)(n,(function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("div",{staticClass:"address"},t._l(t.addressLines,(function(e){return s("div",[t._v(t._s(e))])})),0)}),[],!1,null,"ad4be120",null);e.default=r.exports},bUC5:function(t,e,s){s("9Wh1"),window.Vue=s("XuX8"),Vue.component("address-list",s("9P+s").default),Vue.component("address-list-item",s("7eC/").default),Vue.component("address-request",s("IC88").default),Vue.component("mailing-address",s("anru").default),Vue.component("penpal-list",s("0O3m").default),Vue.component("resident",s("FHMg").default);new Vue({el:"#app"})},eUzT:function(t,e,s){(t.exports=s("I1BE")(!1)).push([t.i,"\n.list-header[data-v-0d86d7f8] {\n    display: grid;\n    grid-template-columns: repeat(2, 1fr);\n}\ntable[data-v-0d86d7f8] {\n    width: 100%;\n}\n",""])},hBuT:function(t,e,s){(t.exports=s("I1BE")(!1)).push([t.i,"\n.card-header[data-v-27aae9a0] {\n    cursor: pointer;\n    font-weight: bold;\n}\n",""])},pyCd:function(t,e){},t0ra:function(t,e,s){var n=s("hBuT");"string"==typeof n&&(n=[[t.i,n,""]]);var a={hmr:!0,transform:void 0,insertInto:void 0};s("aET+")(n,a);n.locals&&(t.exports=n.locals)},xkbp:function(t,e,s){(t.exports=s("I1BE")(!1)).push([t.i,"\n.proof[data-v-8c978d74] {\n    max-height: 300px;\n}\n.previous-images[data-v-8c978d74] {\n    max-height: 100px;\n    max-width: 100px;\n    margin: 4px;\n}\n",""])}},[[0,1,2]]]);