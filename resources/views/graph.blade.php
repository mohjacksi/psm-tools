@extends('layouts.frontend')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                    <div style="margin-bottom: 10px;" class="row">
                        <div class="col-lg-12">

                        </div>
                    </div>
                <div class="card">
                    <div class="card-header">
                        <div id='sigma-container' style="width:600px; height:600px; background-color:#E1E1E1"></div>
                    </div>


            </div>
        </div>
    </div>
@endsection
@section('scripts')
    @parent
       <!-- Sigma core -->
       <script src="https://cdn.jsdelivr.net/npm/sigma@1.2.1/src/sigma.core.js"></script>
       <script src="https://cdn.jsdelivr.net/npm/sigma@1.2.1/src/conrad.js"></script>
       <script src="https://cdn.jsdelivr.net/npm/sigma@1.2.1/src/utils/sigma.utils.js"></script>
       <script src="https://cdn.jsdelivr.net/npm/sigma@1.2.1/src/utils/sigma.polyfills.js"></script>
       <script src="https://cdn.jsdelivr.net/npm/sigma@1.2.1/src/sigma.settings.js"></script>
       <script src="https://cdn.jsdelivr.net/npm/sigma@1.2.1/src/classes/sigma.classes.dispatcher.js"></script>
       <script src="https://cdn.jsdelivr.net/npm/sigma@1.2.1/src/classes/sigma.classes.configurable.js"></script>
       <script src="https://cdn.jsdelivr.net/npm/sigma@1.2.1/src/classes/sigma.classes.graph.js"></script>
       <script src="https://cdn.jsdelivr.net/npm/sigma@1.2.1/src/classes/sigma.classes.camera.js"></script>
       <script src="https://cdn.jsdelivr.net/npm/sigma@1.2.1/src/classes/sigma.classes.quad.js"></script>
       <script src="https://cdn.jsdelivr.net/npm/sigma@1.2.1/src/classes/sigma.classes.edgequad.js"></script>
       <script src="https://cdn.jsdelivr.net/npm/sigma@1.2.1/src/captors/sigma.captors.mouse.js"></script>
       <script src="https://cdn.jsdelivr.net/npm/sigma@1.2.1/src/captors/sigma.captors.touch.js"></script>
       <script src="https://cdn.jsdelivr.net/npm/sigma@1.2.1/src/renderers/sigma.renderers.canvas.js"></script>
       <script src="https://cdn.jsdelivr.net/npm/sigma@1.2.1/src/renderers/sigma.renderers.webgl.js"></script>
       <script src="https://cdn.jsdelivr.net/npm/sigma@1.2.1/src/renderers/sigma.renderers.svg.js"></script>
       <script src="https://cdn.jsdelivr.net/npm/sigma@1.2.1/src/renderers/sigma.renderers.def.js"></script>
       <script src="https://cdn.jsdelivr.net/npm/sigma@1.2.1/src/renderers/canvas/sigma.canvas.labels.def.js"></script>
       <script src="https://cdn.jsdelivr.net/npm/sigma@1.2.1/src/renderers/canvas/sigma.canvas.hovers.def.js"></script>
       <script src="https://cdn.jsdelivr.net/npm/sigma@1.2.1/src/renderers/canvas/sigma.canvas.nodes.def.js"></script>
       <script src="https://cdn.jsdelivr.net/npm/sigma@1.2.1/src/renderers/canvas/sigma.canvas.edges.def.js"></script>
       <script src="https://cdn.jsdelivr.net/npm/sigma@1.2.1/src/renderers/canvas/sigma.canvas.edges.curve.js"></script>
       <script src="https://cdn.jsdelivr.net/npm/sigma@1.2.1/src/renderers/canvas/sigma.canvas.edges.arrow.js"></script>
       <script src="https://cdn.jsdelivr.net/npm/sigma@1.2.1/src/renderers/canvas/sigma.canvas.edges.curvedArrow.js"></script>
       <script src="https://cdn.jsdelivr.net/npm/sigma@1.2.1/src/renderers/canvas/sigma.canvas.edgehovers.def.js"></script>
       <script src="https://cdn.jsdelivr.net/npm/sigma@1.2.1/src/renderers/canvas/sigma.canvas.edgehovers.curve.js"></script>
       <script src="https://cdn.jsdelivr.net/npm/sigma@1.2.1/src/renderers/canvas/sigma.canvas.edgehovers.arrow.js"></script>
       <script src="https://cdn.jsdelivr.net/npm/sigma@1.2.1/src/renderers/canvas/sigma.canvas.edgehovers.curvedArrow.js"></script>
       <script src="https://cdn.jsdelivr.net/npm/sigma@1.2.1/src/renderers/canvas/sigma.canvas.extremities.def.js"></script>
       <script src="https://cdn.jsdelivr.net/npm/sigma@1.2.1/src/middlewares/sigma.middlewares.rescale.js"></script>
       <script src="https://cdn.jsdelivr.net/npm/sigma@1.2.1/src/middlewares/sigma.middlewares.copy.js"></script>
       <script src="https://cdn.jsdelivr.net/npm/sigma@1.2.1/src/misc/sigma.misc.animation.js"></script>
       <script src="https://cdn.jsdelivr.net/npm/sigma@1.2.1/src/misc/sigma.misc.bindEvents.js"></script>
       <script src="https://cdn.jsdelivr.net/npm/sigma@1.2.1/src/misc/sigma.misc.bindDOMEvents.js"></script>
       <script src="https://cdn.jsdelivr.net/npm/sigma@1.2.1/src/misc/sigma.misc.drawHovers.js"></script>
       <!-- Sigma plugins -->
     <script src="https://cdn.jsdelivr.net/npm/sigma@1.2.1/plugins/sigma.layout.forceAtlas2/supervisor.js"></script>
       <script src="https://cdn.jsdelivr.net/npm/sigma@1.2.1/plugins/sigma.layout.forceAtlas2/worker.js"></script>
       <script src="https://cdn.jsdelivr.net/npm/sigma@1.2.1/plugins/sigma.renderers.edgeLabels/settings.js"></script>
       <script src="https://cdn.jsdelivr.net/npm/sigma@1.2.1/plugins/sigma.renderers.edgeLabels/sigma.canvas.edges.labels.def.js"></script>
       <script src="https://cdn.jsdelivr.net/npm/sigma@1.2.1/plugins/sigma.renderers.edgeLabels/sigma.canvas.edges.labels.curve.js"></script>
       <script src="https://cdn.jsdelivr.net/npm/sigma@1.2.1/plugins/sigma.renderers.edgeLabels/sigma.canvas.edges.labels.curvedArrow.js"></script>
       <script src="https://cdn.jsdelivr.net/npm/sigma@1.2.1/plugins/sigma.renderers.parallelEdges/utils.js"></script>
       <script src="https://cdn.jsdelivr.net/npm/sigma@1.2.1/plugins/sigma.renderers.parallelEdges/sigma.canvas.edges.curvedArrow.js"></script>
       <script src="https://cdn.jsdelivr.net/npm/sigma@1.2.1/plugins/sigma.renderers.parallelEdges/sigma.canvas.edgehovers.curvedArrow.js"></script>
       <script src="https://cdn.jsdelivr.net/npm/sigma@1.2.1/plugins/sigma.renderers.parallelEdges/sigma.canvas.edgehovers.curve.js"></script>
       <script src="https://cdn.jsdelivr.net/npm/sigma@1.2.1/plugins/sigma.renderers.parallelEdges/sigma.canvas.edges.labels.curve.js"></script>
       <script src="https://cdn.jsdelivr.net/npm/sigma@1.2.1/plugins/sigma.plugins.filter/sigma.plugins.filter.js"></script>



        <script type="module">

var s = new sigma(
  {
    renderer: {
      container: document.getElementById('sigma-container'),
      type: 'canvas'
    },
    settings: {
    	edgeLabelSize: 'proportional',
      minArrowSize: 5
    }
  }
);

// Create a graph object
var graph = {
  nodes: [
    { id:"KB01", label: "KB01", x: Math.random(),y: Math.random(), size: 1, color: '#EE651D' },
    { id:"KB05", label: "KB05", x: Math.random(),y: Math.random(), size: 1, color: '#EE651D' },
    { id:"KB03", label: "KB03", x: Math.random(),y: Math.random(), size: 1, color: '#EE651D' },
    { id:"KB13", label: "KB13", x: Math.random(),y: Math.random(), size: 1, color: '#EE651D' },
    { id:"KB07", label: "KB07", x: Math.random(),y: Math.random(), size: 1, color: '#EE651D' },
    { id:"KB09", label: "KB09", x: Math.random(),y: Math.random(), size: 1, color: '#EE651D' },
    { id:"KB08", label: "KB08", x: Math.random(),y: Math.random(), size: 1, color: '#EE651D' },
    { id:"KB10", label: "KB10", x: Math.random(),y: Math.random(), size: 1, color: '#EE651D' },
    { id:"KB11", label: "KB11", x: Math.random(),y: Math.random(), size: 1, color: '#EE651D' },
    { id:"KB12", label: "KB12", x: Math.random(),y: Math.random(), size: 1, color: '#EE651D' },
    { id:"KB14", label: "KB14", x: Math.random(),y: Math.random(), size: 1, color: '#EE651D' },
    { id:"KB06", label: "KB06", x: Math.random(),y: Math.random(), size: 1, color: '#EE651D' },
    { id:"KB04", label: "KB04", x: Math.random(),y: Math.random(), size: 1, color: '#EE651D' },
    { id:"KB02", label: "KB02", x: Math.random(),y: Math.random(), size: 1, color: '#EE651D' }
  ],
 edges: [
    { id: "e0", label:"04/03/2018",source:"KB13", target:"KB01", date:"04/03/2018",color: '#282c34', type:'curvedArrow', count:0, size:1},
    { id: "e1", label:"01/11/2019",source:"KB03", target:"KB01", date:"01/11/2019",color: '#282c34', type:'curvedArrow', count:0, size:1},
    { id: "e2", label:"01/12/2019",source:"KB05", target:"KB01", date:"01/12/2019",color: '#282c34', type:'curvedArrow', count:0, size:1},
    { id: "e3", label:"01/12/2019",source:"KB03", target:"KB01", date:"01/12/2019",color: '#282c34', type:'curvedArrow', count:1, size:1},
    { id: "e4", label:"01/14/2019",source:"KB05", target:"KB01", date:"01/14/2019",color: '#282c34', type:'curvedArrow', count:1, size:1},
    { id: "e5", label:"01/07/2019",source:"KB01", target:"KB02", date:"01/07/2019",color: '#282c34', type:'curvedArrow', count:0, size:1},
    { id: "e6", label:"01/08/2019",source:"KB01", target:"KB02", date:"01/08/2019",color: '#282c34', type:'curvedArrow', count:1, size:1},
    { id: "e7", label:"01/08/2019",source:"KB04", target:"KB02", date:"01/08/2019",color: '#282c34', type:'curvedArrow', count:0, size:1},
    { id: "e8", label:"06/03/2019",source:"KB06", target:"KB02", date:"06/03/2019",color: '#282c34', type:'curvedArrow', count:0, size:1},
    { id: "e9", label:"04/03/2018",source:"KB01", target:"KB03", date:"04/03/2018",color: '#282c34', type:'curvedArrow', count:0, size:1},
    { id: "e10", label:"01/13/2019",source:"KB05", target:"KB03", date:"01/13/2019",color: '#282c34', type:'curvedArrow', count:0, size:1},
    { id: "e11", label:"01/14/2019",source:"KB05", target:"KB03", date:"01/14/2019",color: '#282c34', type:'curvedArrow', count:1, size:1},
    { id: "e12", label:"01/05/2019",source:"KB06", target:"KB04", date:"01/05/2019",color: '#282c34', type:'curvedArrow', count:0, size:1},
    { id: "e13", label:"01/06/2019",source:"KB06", target:"KB04", date:"01/06/2019",color: '#282c34', type:'curvedArrow', count:1, size:1},
    { id: "e14", label:"04/02/2018",source:"KB03", target:"KB05", date:"04/02/2018",color: '#282c34', type:'curvedArrow', count:0, size:1},
    { id: "e15", label:"01/15/2018",source:"KB07", target:"KB05", date:"01/15/2018",color: '#282c34', type:'curvedArrow', count:0, size:1},
    { id: "e16", label:"01/16/2019",source:"KB07", target:"KB05", date:"01/16/2019",color: '#282c34', type:'curvedArrow', count:1, size:1},
    { id: "e17", label:"01/17/2019",source:"KB07", target:"KB05", date:"01/17/2019",color: '#282c34', type:'curvedArrow', count:2, size:1},
   { id: "e18", label:"01/17/2019",source:"KB09", target:"KB05", date:"01/17/2019",color: '#282c34', type:'curvedArrow', count:0, size:1},
   { id: "e19", label:"01/04/2019",source:"KB04", target:"KB06", date:"01/04/2019",color: '#282c34', type:'curvedArrow', count:0, size:1},
     { id: "e20", label:"01/05/2019",source:"KB04", target:"KB06", date:"01/05/2019",color: '#282c34', type:'curvedArrow', count:1, size:1},
    { id: "e21", label:"04/02/2018",source:"KB05", target:"KB07", date:"04/02/2018",color: '#282c34', type:'curvedArrow', count:0, size:1},
    { id: "e22", label:"01/18/2019",source:"KB09", target:"KB07", date:"01/18/2019",color: '#282c34', type:'curvedArrow', count:0, size:1},
    { id: "e23", label:"01/20/2019",source:"KB09", target:"KB07", date:"01/20/2019",color: '#282c34', type:'curvedArrow', count:1, size:1},
    { id: "e24", label:"01/02/2019",source:"KB06", target:"KB08", date:"01/02/2019",color: '#282c34', type:'curvedArrow', count:0, size:1},
    { id: "e25", label:"04/01/2018",source:"KB07", target:"KB09", date:"04/01/2018",color: '#282c34', type:'curvedArrow', count:0, size:1},
    { id: "e26", label:"01/17/2019",source:"KB05", target:"KB09", date:"01/17/2019",color: '#282c34', type:'curvedArrow', count:0, size:1},
    { id: "e27", label:"01/21/2019",source:"KB11", target:"KB09", date:"01/21/2019",color: '#282c34', type:'curvedArrow', count:0, size:1},
    { id: "e28", label:"01/22/2019",source:"KB11", target:"KB09", date:"01/22/2019",color: '#282c34', type:'curvedArrow', count:1, size:1},
    { id: "e29", label:"01/01/2019",source:"KB08", target:"KB10", date:"01/01/2019",color: '#282c34', type:'curvedArrow', count:0, size:1},
    { id: "e30", label:"03/29/2018",source:"KB09", target:"KB11", date:"03/29/2018",color: '#282c34', type:'curvedArrow', count:0, size:1},
    { id: "e31", label:"04/01/2018",source:"KB09", target:"KB11", date:"04/01/2018",color: '#282c34', type:'curvedArrow', count:1, size:1},
    { id: "e32", label:"01/23/2019",source:"KB05", target:"KB11", date:"01/23/2019",color: '#282c34', type:'curvedArrow', count:0, size:1},
    { id: "e33", label:"01/24/2019",source:"KB09", target:"KB11", date:"01/24/2019",color: '#282c34', type:'curvedArrow', count:2, size:1},
    { id: "e34", label:"01/24/2019",source:"KB05", target:"KB11", date:"01/24/2019",color: '#282c34', type:'curvedArrow', count:1, size:1},
    { id: "e35", label:"06/07/2019",source:"KB12", target:"KB11", date:"06/07/2019",color: '#282c34', type:'curvedArrow', count:0, size:1},
    { id: "e36", label:"06/08/2019",source:"KB14", target:"KB11", date:"06/08/2019",color: '#282c34', type:'curvedArrow', count:0, size:1},
    { id: "e37", label:"12/31/2018",source:"KB10", target:"KB12", date:"12/31/2018",color: '#282c34', type:'curvedArrow', count:0, size:1},
    { id: "e38", label:"03/29/2018",source:"KB11", target:"KB13", date:"03/29/2018",color: '#282c34', type:'curvedArrow', count:0, size:1},
    { id: "e39", label:"01/09/2019",source:"KB03", target:"KB13", date:"01/09/2019",color: '#282c34', type:'curvedArrow', count:0, size:1},
    { id: "e40", label:"01/10/2019",source:"KB01", target:"KB13", date:"01/10/2019",color: '#282c34', type:'curvedArrow', count:0, size:1},
    { id: "e41", label:"01/12/2019",source:"KB03", target:"KB13", date:"01/12/2019",color: '#282c34', type:'curvedArrow', count:1, size:1},
    { id: "e42", label:"06/04/2019",source:"KB08", target:"KB13", date:"06/04/2019",color: '#282c34', type:'curvedArrow', count:0, size:1},
    { id: "e43", label:"06/05/2019",source:"KB10", target:"KB13", date:"06/05/2019",color: '#282c34', type:'curvedArrow', count:0, size:1},
    { id: "e44", label:"12/29/2018",source:"KB12", target:"KB14", date:"12/29/2018",color: '#282c34', type:'curvedArrow', count:0, size:1}
  ]
}

import myJson from '/data.json' assert {type: 'json'};
console.log(myJson.nodes);
graph = myJson;
alert(graph.nodes[12].y);
// load the graph
s.graph.read(graph);
// draw the graph
s.refresh();
// launch force-atlas for 5sec
s.startForceAtlas2();
window.setTimeout(function() {s.killForceAtlas2()}, 2000);






function filter_edges (startdate,enddate) {
var start = new Date (startdate);
var end = new Date(enddate);
var filtered_edges = [];
graph.edges.forEach(function(obj) {
 var tdate = new Date (obj.date) ;
 if (tdate > start && tdate < end) {
   filtered_edges.push(obj);
  }
})
graph.edges = [];
graph.edges = filtered_edges.slice();

s.refresh();
// launch force-atlas for 5sec
s.startForceAtlas2();
window.setTimeout(function() {s.killForceAtlas2()}, 2000);
}
</script>










       @endsection
