(self.webpackChunk=self.webpackChunk||[]).push([[153],{8153:(e,t,a)=>{"use strict";a.r(t),a.d(t,{default:()=>B});var o=a(5166),r={class:"row"},s={class:"col-lg-6 col-sm-12"},c={class:"d-flex flex-column"},n={class:"input-group mb-3"},d={class:"btn btn-outline-secondary dropdown-toggle",type:"button","data-bs-toggle":"dropdown","aria-expanded":"false"},l=(0,o.createTextVNode)("Search Type: "),i={class:"dropdown-menu dropdown-menu-end"},p=(0,o.createVNode)("i",{class:"fas fa-search"},null,-1),u={class:"d-flex flex-wrap"},m={class:"mx-2 align-content-end"},y={class:"card",style:{width:"18rem"}},f={class:"card-body"},k={class:"card-title"},b={class:"card-subtitle mb-2"},h={key:0,class:"badge bg-danger"},w={key:1,class:"badge bg-warning"},N={key:2,class:"badge bg-success"},V={class:"card-subtitle mb-2 text-muted"},g={class:"card-subtitle mb-2 text-muted"},C={class:"card-subtitle mb-2 text-muted"},x={class:"card-subtitle mb-2 text-muted"},_={class:"card-text"};const v={props:["data"],data:function(){return{keyword:"",cases:{keyword:"",drop_down:"Company"},case_results:[]}},methods:{searchContract:function(){axios.post(this.data.search_contract,{keyword:this.keyword}).then((function(e){}))},searchCase:function(){var e=this;axios.post(this.data.search_cases,e.cases).then((function(t){e.case_results=t.data}))}},render:function(e,t,a,v,B,S){return(0,o.openBlock)(),(0,o.createBlock)(o.Fragment,null,[(0,o.createVNode)("div",r,[(0,o.createVNode)("div",s,[(0,o.createVNode)("div",c,[(0,o.createVNode)("div",n,[(0,o.withDirectives)((0,o.createVNode)("input",{type:"text",class:"form-control","aria-label":"Text input with dropdown button","onUpdate:modelValue":t[1]||(t[1]=function(e){return B.cases.keyword=e}),placeholder:"Type In Keyword..."},null,512),[[o.vModelText,B.cases.keyword]]),(0,o.createVNode)("button",d,[l,(0,o.createVNode)("b",null,(0,o.toDisplayString)(B.cases.drop_down),1)]),(0,o.createVNode)("ul",i,[(0,o.createVNode)("li",null,[(0,o.createVNode)("a",{class:"dropdown-item",href:"#",onClick:t[2]||(t[2]=function(e){return B.cases.drop_down="Company"})},"Company")]),(0,o.createVNode)("li",null,[(0,o.createVNode)("a",{class:"dropdown-item",href:"#",onClick:t[3]||(t[3]=function(e){return B.cases.drop_down="Worker"})},"Worker")]),(0,o.createVNode)("li",null,[(0,o.createVNode)("a",{class:"dropdown-item",href:"#",onClick:t[4]||(t[4]=function(e){return B.cases.drop_down="Employer"})},"Employer")])]),(0,o.createVNode)("button",{class:"btn btn-primary",type:"button",onClick:t[5]||(t[5]=function(){return S.searchCase&&S.searchCase.apply(S,arguments)})},[p])])])])]),(0,o.createVNode)("div",u,[((0,o.openBlock)(!0),(0,o.createBlock)(o.Fragment,null,(0,o.renderList)(B.case_results,(function(e){return(0,o.openBlock)(),(0,o.createBlock)("div",m,[(0,o.createVNode)("div",y,[(0,o.createVNode)("div",f,[(0,o.createVNode)("h5",k,"Case No. "+(0,o.toDisplayString)(e.atnsia_no),1),(0,o.createVNode)("h6",b,["suspended"==e.status?((0,o.openBlock)(),(0,o.createBlock)("span",h,"Suspended")):(0,o.createCommentVNode)("",!0),"warning"==e.status?((0,o.openBlock)(),(0,o.createBlock)("span",w,"Warning")):(0,o.createCommentVNode)("",!0),"lifted"==e.status?((0,o.openBlock)(),(0,o.createBlock)("span",N,"Lifted")):(0,o.createCommentVNode)("",!0)]),(0,o.createVNode)("h6",V,"Case Officer / Welof: "+(0,o.toDisplayString)(e.case_officer),1),(0,o.createVNode)("h6",g,"Company: "+(0,o.toDisplayString)(e.company.name),1),(0,o.createVNode)("h6",C,"Employer: "+(0,o.toDisplayString)(e.employer.name),1),(0,o.createVNode)("h6",x,"Worker: "+(0,o.toDisplayString)(e.worker.last_name)+", "+(0,o.toDisplayString)(e.worker.first_name),1),(0,o.createVNode)("p",_,(0,o.toDisplayString)(e.complaint),1)])])])})),256))])],64)}},B=v}}]);
//# sourceMappingURL=153.js.map?id=65bfcb6468546abda36a