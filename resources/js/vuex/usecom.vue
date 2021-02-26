<template>
    <div>
        <div class="content">
            <div class="container-fluid">
                <h1>usecom</h1>
                <h4>current counter:{{counter}}</h4>
                <comA></comA>
                <comB></comB>
                <comC></comC>{{$store.state.counter}}
                <button @click="changeCounter()">ddd</button>
            </div>
        </div>
    </div>
</template>
<script>
import comA from "./comA"
import comB from "./comB"
import comC from "./comC"
//Vue.component('comA',require('./components/comA.vue'))
import {mapGetters} from "vuex"
export default {
    date(){
        return {

        }
    },
    computed:{
        //...mapGetters(['getCounter'])
        ...mapGetters({
            'counter':'getCounter'
        })
    },
    methods:{
        changeCounter(){
            this.$store.commit('changeTheCounter',1)
        }
    },
    components:{
        comA,comB,comC
    }
}
</script>