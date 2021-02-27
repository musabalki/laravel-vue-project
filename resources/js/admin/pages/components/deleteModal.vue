<template>
    <div>
        <Modal :value="getDeleteModalObj.showDeleteModal" width="360">
          <p slot="header" style="color: #f60; text-align: center">
            <Icon type="ios-information-circle"></Icon>
            <span>Delete confirmation</span>
          </p>
          <div style="text-align: center">
            <p>
              After this task is deleted, the downstream 10 tasks will not be
              implemented.
            </p>
            <p>Will you delete it?</p>
          </div>
          <div slot="footer">
            <Button
              type="error"
              size="large"
              long
              :disabled="isDeleting"
              :loading="isDeleting"
              @click="deleteTag"
              >Delete</Button
            >
          </div>
        </Modal>
    </div>
</template>

<script>
import {mapGetters} from 'vuex'
export default {
    data(){
        return{
            isDeleting:false,
        }
    },
    methods:{
        async deleteTag(){
            this.isDeleting=true
            const res=await this.callApi('post',getDeleteModalObj.deleteUrl,this.deleteItem)
            if(res.status===200){
                this.
            }
        }
    },
    computed:{
        ...mapGetters(['getDeleteModalObj'])
    }
}
</script>