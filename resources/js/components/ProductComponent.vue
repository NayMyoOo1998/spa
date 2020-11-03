<template>
  <div class="container my-5">
    <div class="row">
      <div class="col-md-12">
        <div class="row justify-content-end">
          <div class="col-md-4 mb-2">
            <button class="btn btn-outline-primary" @click="create">
              <i class="fas fa-plus"></i> Create
            </button>
          </div>
          <div class="col-md-4">
            <form @submit.prevent="view()">
              <div class="input-group">
                <input
                  type="search"
                  name="search"
                  id="search"
                  class="form-control"
                  placeholder="Search"
                  v-model="search"
                />
                <div class="input-group-append">
                  <button type="submit" class="btn btn-primary">
                    <i class="fas fa-search"></i>
                  </button>
                </div>
              </div>
            </form>
          </div>
        </div>

        <div class="row py-3">
          <div class="col-md-4">
            <div class="card">
              <h4 class="card-header">{{ isEditMode ? "Edit" : "Create" }}</h4>
              <div class="card-body">
                <alert-error :form="product" :message="message"></alert-error>

                <form
                  @submit.prevent="isEditMode ? update() : store()"
                  @keydown="product.onKeydown($event)"
                >
                  <div class="form-group">
                    <label for="name">Name</label>
                    <input
                      type="text"
                      name="name"
                      id="name"
                      class="form-control"
                      v-model="product.name"
                      :class="{ 'is-invalid': product.errors.has('name') }"
                    />
                    <has-error :form="product" field="name"></has-error>
                  </div>
                  <div class="form-group">
                    <label for="price">Price</label>
                    <input
                      type="text"
                      name="price"
                      id="price"
                      class="form-control"
                      v-model="product.price"
                      :class="{ 'is-invalid': product.errors.has('price') }"
                    />
                    <has-error :form="product" field="price"></has-error>
                  </div>
                  <button class="btn btn-primary" type="submit">
                    <i class="fas fa-save"></i> Save
                  </button>
                </form>
              </div>
            </div>
          </div>

          <div class="col-md-8">
            <table class="table text-center">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Name</th>
                  <th>Price</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(product, index) in products.data" :key="index">
                  <td>{{ index + 1 }}</td>
                  <td>{{ product.name }}</td>
                  <td>$ {{ product.price }}</td>
                  <td>
                    <button
                      class="btn btn-outline-info btn-sm"
                      @click="edit(product)"
                    >
                      <i class="fas fa-edit"></i> Edit
                    </button>
                    <button
                      class="btn btn-outline-danger btn-sm"
                      @click="destory(product.id)"
                    >
                      <i class="fas fa-trash"></i> Delete
                    </button>
                  </td>
                </tr>
              </tbody>
            </table>
            <pagination
              :data="products"
              @pagination-change-page="view"
            ></pagination>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "ProductComponent",
  data() {
    return {
      isEditMode: false,
      search: "",
      message: "",
      products: {},
      product: new Form({
        id: "",
        name: "",
        price: "",
      }),
    };
  },

  methods: {
    // searchProduct(){
    //   axios.get('/api/products?search=' + this.search)
    //   .then(res => {
    //     this.products = res.data;
    //   })
    // },

    view(page = 1) {
      this.$Progress.start();
      let loader = this.$loading.show({
        loader: 'bars',
        color: 'blue',
      });
      axios
        .get(`/api/products?page=${page}&search=${this.search}`)
        .then((res) => {
          this.products = res.data;
          
          setTimeout(()=>{
            this.$Progress.finish();
            loader.hide();
          },2000);
        })
        .catch((err) => {
          this.$Progress.finish();
          loader.hide();
        });
    },
    create() {
      this.isEditMode = false;
      this.product.reset();
    },

    store() {
      this.product
        .post("/api/products")
        .then((res) => {
          this.view();
          Toast.fire({
            icon: "success",
            title: "Created successfully",
          });
          this.product.reset();
        })
        .catch((errors) => {
          this.message = errors.response.data.message;
          console.log(errors.response.data.message);
        });
    },

    edit(product) {
      (this.isEditMode = true), (this.product.id = product.id);
      // this.product.name = product.name;
      // this.product.price = product.price;
      this.product.fill(product);
    },

    update() {
      this.product.put(`/api/products/${this.product.id}`).then((res) => {
        this.view();
        Toast.fire({
          icon: "success",
          title: "Updated successfully",
        });
        this.product.reset();
      });
    },

    destory(id) {
      Swal.fire({
        title: "Are You Sure ?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Delete",
      }).then((result) => {
        if (result.isConfirmed) {
          axios.delete(`/api/products/${id}`).then((res) => {
            this.view();
            Swal.fire({
              title: "Deleted!",
              icon: "success",
            });

            Toast.fire({
              icon: "success",
              title: "Deleted successfully",
            });
          });
        }
      });
    },
  },

  created() {
    this.view();
  },
};
</script>