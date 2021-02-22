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
                <th>Icon Name</th>
                <th>Category Name</th>
                <th>Created At</th>
                <th>Action</th>
              </tr>
              <!-- TABLE TITLE -->
              <!-- ITEMS -->
              <tr v-for="(category, i2) in categoryList" :key="category.id">
                <td>{{ category.id }}</td>
                <td >
                  <img :src="category.iconImage" alt="icon">
                </td>
                <td>{{ category.categoryName}}</td>
                <td>{{ category.created_at }}</td>
                <td>
                  <Button
                    type="info"
                    size="small"
                    @click="showEditModal(category, i2)"
                    >Edit</Button
                  >
                  <Button
                    type="error"
                    size="small"
                    :loading="category.isDeleting"
                    @click="showDeleteModal(category, i2)"
                    >Delete</Button
                  >
                </td>
              </tr>
            </table>
          </div>
        </div>
        <Modal
          v-model="addModal"
          title="Add Category"
          :mask-closable="false"
          :closable="true"
        >
          <Input name="categoryName" type="text" v-model="data.categoryName" />
          <div class="space">
            <Upload 
             ref="uploads"
              :on-success="handleSuccess"
              :on-error="handleError"
              :max-size="2048"
              :on-format-error="handleFormatError"
              :on-exceeded-size="handleMaxSize"
              :format="['jpg', 'jpeg', 'png']"
              multiple
              type="drag"
              :headers="{
                'x-csrf-token': token,
                'X-Requested-With': 'XMLHttpRequest',
              }"
              action="/app/upload"
            >
              <div style="padding: 20px 0">
                <Icon type="ios-cloud-upload" size="52" style="color: #3399ff">
                </Icon>
                <p>Click or drag files here to upload</p>
              </div>
            </Upload>
            <div class="image_thumb" v-if="data.iconImage">
              <Icon @click="deleteImage" type="ios-cloud-upload" size="52" style="color:#3399ff">
              </Icon>
              <p>Click or drag files here upload </p>
            </div>
          </div>
          <div slot="footer">
            <Button type="default" @click="addModal = false">Close</Button>
            <Button
              type="primary"
              @click="addCategory"
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
    </div>
  </div>
</template>
<script>
export default {
  data() {
    return {
      data: {
        iconImage: "",
        categoryName: "",
      },
      categoryList: [],
      addModal: false,
      editModal: false,
      isAdding: false,
      editData: {
        tagName: "",
      },
      index: -1,
      showDeleteModalResult: false,
      isDeleting: false,
      deleteItem: {},
      deleteIndex: -1,
      token: "",
    };
  },
  methods: {
    async addCategory() {
      
       if (this.data.categoryName.trim() == "") {
        return this.e("Category name is required");
      }
      if (this.data.iconImage.trim() == "") {
        return this.e("İcon is required");
      }
      this.data.iconImage=`/uploads/${this.data.iconImage}`
      const res = await this.callApi("post", "app/create_category", this.data);
      console.log(res);
      if (res.status === 201) {
        this.categoryList.unshift(res.data);
        this.s("Success");
        this.addModal = false;
        this.data.categoryName = "";
        this.data.iconImage = "";
      } else {
        if (res.status == 422) {
          if (res.data.errors.category) {
            this.e(res.data.errors.categoryName[0]);
          }
        } else {
          this.swr();
        }
      }
    },
    async editTag() {
      if (this.editData.categoryName.trim() == "") {
        return this.e("Tag name is required");
      }
      const res = await this.callApi("put", "app/edit_tag", this.editData);
      //console.log(res);
      if (res.status === 200) {
        this.categoryList[this.index].categoryName = this.editData.categoryName;
        //this.tags.unshift(res.data);
        this.s("Tag has been edited successfully");
        this.editModal = false;
      } else {
        if (res.status == 422) {
          if (res.data.errors.categoryName) {
            this.e(res.data.errors.categoryName[0]);
          }
        } else {
          this.swr();
        }
      }
    },
    showEditModal(tag, index) {
      let obj = {
        id: tag.id,
        tagName: tag.tagName,
      };
      this.editData = obj;
      this.editModal = true;
      this.index = index;
    },
    async deleteTag() {
      /* if(!confirm('Are you sure you want to delete this tags ?')){
        return
       // 
      }*/
      //tag.isDeleting=true
      //this.$set(tag,'isDeleting',true)
      this.isDeleting = true;
      const res = await this.callApi("post", "app/delete_tag", this.deleteItem);
      if (res.status === 200) {
        this.tags.splice(this.i, 1);
        this.s("Tag has been deleted successfully");
        this.showDeleteModalResult = false;
      } else {
        this.swr();
      }
      this.isDeleting = false;
      this.showDeleteModalResult = false;
    },
    showDeleteModal(tag, i2) {
      this.deleteItem = tag;
      this.deleteIndex = i2;
      this.showDeleteModalResult = true;
    },
    handleSuccess(res, file) {
      this.data.iconImage = res;
    },
    handleError() {
      this.$Notice.warning({
        title: "The file format is incorrect",
        desc: `${file.errors.file.length ? file.errors.file[0]:'something went wrong'}`,
      });
    },
    handleFormatError(file) {
      this.$Notice.warning({
        title: "The file format is incorrect",
        desc:
          "File format of " +
          file.name +
          " is incorrect, please select jpg or png.",
      });
    },
    handleMaxSize(file) {
      this.$Notice.warning({
        title: "Exceeding file size limit",
        desc: "File  " + file.name + " is too large, no more than 2M.",
      });
    },
    async deleteImage(){
      let image=this.data.iconImage
      this.data.iconImage=""
      this.$refs.uploads.clearFiles()
      const res = await this.callApi('post','app/delete_image',{imageName:image})
      if(res.status!=200){
        this.data.iconImage=image
        this.swr()
      }
    }
  },
  async created() {
    const res = await this.callApi("get", "app/get_category");
    this.token = window.Laravel.csrfToken;
    if (res.status === 200) {
      this.categoryList = res.data;
    } else {
      this.swr();
    }
    console.log(res)
  },
};
</script>