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
              <tr v-for="tag in tags" :key="tag.id">
                <td>{{ tag.id }}</td>
                <td class="_table_name">{{ tag.tagName }}</td>
                <td>{{ tag.created_at }}</td>
                <td>
                  <Button type="info" size="small">Info</Button>
                  <Button type="error" size="small">Error</Button>
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
          <Input v-model="editData.tagName" name="tagName" type="text" v-model="editTagName" />
          <div slot="footer">
            <Button type="default" @click="editModal = false">Close</Button>
            <Button
              type="primary"
              @click="editTag"
              :disabled="isAdding"
              :loading="isAdding"
              >{{ isAdding ? "Adding..." : "Add" }}</Button
            >
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
      editModal:false,
      isAdding: false,
      editData:{
        tagName:''
      }
    };
  },
  methods: {
    async addTag() {
      if (this.data.tagName.trim() == "") {
        return this.e("Tag name is required");
      }
      const res = await this.callApi(
        "post",
        "app/create_tag",
        this.data
      );
	  console.log(res)
      if (res.status === 201) {
        this.tags.unshift(res.data)
        this.s("Success");
        this.addModal = false;
        this.data.tagName = "";
      } else {
        if(res.status==422){
          if(res.data.errors.tagName){
          this.e(res.data.errors.tagName[0])
          }
        }
        else{
          this.swr();
        }
      }
    },
  },
  async created() {
    const res = await this.callApi("get", "app/get_tag");
    if (res.status === 200) {
      this.tags = res.data
    }
	else{
		this.swr()
	}
  },
};
</script>