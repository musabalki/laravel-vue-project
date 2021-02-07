<template> 
    <div>
        <h1>the number is {{views}}</h1>
        <button @click="updateCounter(1)">
            Increase
        </button>
        <button @click="updateCounter(-1)">
            Decrease
        </button>
        <br>
        <br>
        <div v-for="(blog) in blogs" :key="blog.id">
            <h1>{{blog.title}}</h1>
            <h2>{{blog.post}}</h2>
        </div>
        <br>
        <br>
        <div>
            <h1 v-if="showItem">Show this item if "showitem" is true</h1>
            <h1 v-else>Show this item if "showitem" is false</h1>
        </div>
        <button @click="changeShowItem">Change</button>
    </div>
</template>

<script>
export default {
    data(){
        return {
           views: 0,
           blogs:[],
           showItem:false
        }
    },
    methods:{
        updateCounter(count){
            this.views+=count;
        },
        changeShowItem(){
            this.showItem=!this.showItem
        }
    },
    created(){
        this.views=100;
        let posts=[
            {title:'this is blog title 1',post:'this is blog post 1',id:1},
               {title:'this is blog title 2',post:'this is blog post 2',id:2},
               {title:'this is blog title 3',post:'this is blog post 3',id:3},
               {title:'this is blog title 4',post:'this is blog post 4',id:4}
        ]
        this.blogs=posts;
    }
}
</script>