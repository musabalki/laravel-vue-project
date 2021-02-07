<template> 
    <div>
        <h1>
            Hook
        </h1>
        <h2 >My name is {{name}}</h2>
    </div>
</template>

<script>
export default {
    data(){
        return {
            name:'sadek'
        }
    },
    created(){
        console.log("created")
    },
    mounted(){
        console.log("mounted")
    }
}
</script>