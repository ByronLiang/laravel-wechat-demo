<template>
    <draggable v-model="listSample" :move="getdata" @update="datadragEnd" @sort="handleSort">
        <!-- <transition-group> -->
            <div v-for="element in listSample" :key="element.id" :drag-id="element.id" style="cursor:pointer; height:80px;">
                {{element.name}}
            </div>
<!--         </transition-group> -->
        <el-button type="primary" @click="add" style="center">Add</el-button>
        <el-button type="primary" @click="showIndex" style="center">Submit</el-button>
    </draggable>
</template>
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.6.1/Sortable.min.js"></script>
<script>
    import {Collapse, Button} from 'element-ui';
    import draggable from 'vuedraggable';
    export default {
        components: {
            ElCollapse: Collapse,
            ElButton: Button,
            draggable
        },
        props: ['dataList'],
        data() {
            return {
                listSample: this.dataList,
                activeNames: ['1'],
                sortOptions: {
                    group: 'sample',
                    animation: 150,
                },
                list3:[
                        {name:"John", id:1},
                        {name:"Joao", id:2},
                        {name:"Jean", id:3},
                        {name:"Gerard", id:4}
                    ],
                list2:[
                    {name:"Juan", id:5, num: 1},
                    {name:"Edgard", id:6, num: 2},
                    {name:"Johnson", id:7, num: 3}
                ],
                tags: [
                    { title: "Consistency", name: '1', description: "Consistent with real life: in line with the process and logic of real life, and comply with languages and habits that the users are used to" },
                    { title: "Feedback", name: '2', description: "Operation feedback: enable the users to clearly perceive their operations by style updates and interactive effects" },
                    { title: "Efficiency", name: '3', description: "Simplify the process: keep operating process simple and intuitive" },
                    { title: "Controllability", name: '4', description: "Decision making: giving advices about operations is acceptable, but do not make decisions for the users" },
                ]
            };
        },
        methods:{
            showIndex() {
                console.log(this.listSample);
            },
            getdata (evt) {
                console.log(evt.draggedContext.element.id)
            },
            handleSort(evt) {
                console.log('onSort.foo:', [evt.item, evt.from]);
                console.log(evt.item.getAttribute('drag-id') + ', ' + evt.oldIndex);
                console.log(evt.from.getAttribute('drap-id') + ', ' + evt.newIndex);
            },
            datadragEnd (evt) {
                console.log('拖动前的索引 :' + evt.oldIndex);
                console.log(evt.item.getAttribute('drag-id'));
                console.log('拖动后的索引 :' + evt.newIndex);
                console.log(this.dataList[evt.oldIndex]);
                console.log(this.dataList[evt.newIndex]);
                console.log(this.tags)
            },
            handleChange() {
                console.log('times are changing');
            },
            inputChanged(value) {
              this.activeNames = value;
            },
            getComponentData() {
              return {
                on: {
                  change: this.handleChange,
                  input: this.inputChanged
                },
                props: {
                  value: this.activeNames
                }
              };
            },
            add: function(){
                this.list2.push({name:'Juan'});
            },
            replace: function(){
                this.list=[{name:'Edgard'}]
            },
            clone: function(el){
                return {
                    name : el.name + ' cloned'
                }
            },
            log: function (evt){
                console.log(evt)
            }
        }
    };
</script>
