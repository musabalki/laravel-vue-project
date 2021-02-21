<template>
  <div>
    <div class="content">
      <div class="container-fluid">
        <!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
        <div
          class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20"
        >
          <p class="_title0">
            Tags
            <Button type="info" @click="addModal = true"
              ><Icon type="md-add" /> Add Tag</Button
            >
          </p>

          <div class="_overflow _table_div">
            <table class="_table">
              <!-- TABLE TITLE -->
              <tr>
                <th>ID</th>
                <th>Tag Name</th>
                <th>Created At</th>
                <th>Action</th>
              </tr>
              <!-- TABLE TITLE -->
              <!-- ITEMS -->
              <tr v-for="(tag,i2) in tags" :key="tag.id">
                <td>{{ tag.id }}</td>
                <td class="_table_name">{{ tag.tagName }}</td>
                <td>{{ tag.created_at }}</td>
                <td>
                  <Button type="info" size="small" @click="showEditModal(tag,i2)"
                    >Edit</Button
                  >
                  <Button type="error" size="small" :loading="tag.isDeleting" @click="showDeleteModal(tag,i2)">Delete</Button>
                </td>
              </tr>
            </table>
          </div>
        </div>
        <Modal
          v-model="addModal"
          title="Add Modal"
          :mask-closable="false"
          :closable="true"
        >
          <Input name="tagName" type="text" v-model="data.tagName" />
          <div slot="footer">
            <Button type="default" @click="addModal = false">Close</Button>
            <Button
              type="primary"
              @click="addTag"
              :disabled="isAdding"
              :loading="isAdding"
              >{{ isAdding ? "Adding..." : "Add" }}</Button
            >
          </div>
        </Modal>
        <Modal
          v-model="editModal"
          title="Edit tag"
          :mask-closable="false"
          :closable="true"
        >
          <Input v-model="editData.tagName" type="text" />
          <div slot="footer">
            <Button type="default" @click="editModal = false">Close</Button>
            <Button
              type="primary"
              @click="editTag"
              :disabled="isAdding"
              :loading="isAdding"
              >{{ isAdding ? "Editing..." : "Edit tag" }}</Button
            >
          </div>
        </Modal>
        <Modal v-model="showDeleteModalResult" width="360">
        <p slot="header" style="color:#f60;text-align:center">
            <Icon type="ios-information-circle"></Icon>
            <span>Delete confirmation</span>
        </p>
        <div style="text-align:center">
            <p>After this task is deleted, the downstream 10 tasks will not be implemented.</p>
            <p>Will you delete it?</p>
        </div>
        <div slot="footer">
            <Button type="error" size="large" long :disabled="isDeleting"  :loading="isDeleting"  @click="deleteTag" >Delete</Button>
        </div>
    </Modal>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  data() {
    return {
      data: {
        tagName: "",
      },
      tags: [],
      addModal: false,
      editModal: false,
      isAdding: false,
      editData: {
        tagName: "",
      },
      index:-1,
      showDeleteModalResult:false,
      isDeleting:false,
      deleteItem:{},
      deleteIndex:-1
      
    };
  },
  methods: {
    async addTag() {
      if (this.data.tagName.trim() == "") {
        return this.e("Tag name is required");
      }
      const res = await this.callApi("post", "app/create_tag", this.data);
      console.log(res);
      if (res.status === 201) {
        this.tags.unshift(res.data);
        this.s("Success");
        this.addModal = false;
        this.data.tagName = "";
      } else {
        if (res.status == 422) {
          if (res.data.errors.tagName) {
            this.e(res.data.errors.tagName[0]);
          }
        } else {
          this.swr();
        }
      }
    },
    async editTag() {
      if (this.editData.tagName.trim() == "") {
        return this.e("Tag name is required");
      }
      const res = await this.callApi("put", "app/edit_tag", this.editData);
      //console.log(res);
      if (res.status === 200) {
        this.tags[this.index].tagName=this.editData.tagName
        //this.tags.unshift(res.data);
        this.s("Tag has been edited successfully");
        this.editModal = false;
      } else {
        if (res.status == 422) {
          if (res.data.errors.tagName) {
            this.e(res.data.errors.tagName[0]);
          }
        } else {
          this.swr();
        }
      }
    },
    showEditModal(tag,index){
      let obj = {
        id: tag.id,
        tagName:tag.tagName
      }
      this.editData=obj
      this.editModal=true
      this.index=index
    },
    async deleteTag(){
     /* if(!confirm('Are you sure you want to delete this tags ?')){
        return
       // 
      }*/
      //tag.isDeleting=true
      //this.$set(tag,'isDeleting',true)
      this.isDeleting=true
      const res = await this.callApi('post','app/delete_tag',this.deleteItem)
      if(res.status===200){
          this.tags.splice(this.i,1)
          this.s('Tag has been deleted successfully')
          this.showDeleteModalResult=false
      }
      else{
        this.swr()
      }
      this.isDeleting=false
      this.showDeleteModalResult=false
    },
    showDeleteModal(tag,i2){
      this.deleteItem=tag;
      this.deleteIndex=i2
      this.showDeleteModalResult=true;
    }
  },
  async created() {
    const res = await this.callApi("get", "app/get_tag");
    if (res.status === 200) {
      this.tags = res.data;
    } else {
      this.swr();
    }
  },
};
</script>