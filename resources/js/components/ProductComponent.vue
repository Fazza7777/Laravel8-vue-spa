<template>
    <div class="container my-4">
        <div class="row justify-content-end mb-3">
            <div class="col-4">
              <button class="btn btn-primary" @click="create()">
                <i class="fas fa-plus-circle mr-1"></i>  Create
              </button>
            </div>
            <div class="col-4">
               <form @submit.prevent="showproduct()">
                   <div class="input-group">
                       <input v-model="search" type="text" class="form-control" placeholder="Search">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                   </div>
               </form>
            </div>
        </div>
        <div class="row">
            <div class="col-4">
               <div class="card">
                   <div class="card-header">
                      <h4>{{status ? 'Edit' : 'Create'}}</h4>
                   </div>
                   <div class="card-body">
                    <alert-error :form="product" :message="message"></alert-error>
                     <form @submit.prevent=" status ? updateProduct() : addProduct() " @keydown="product.onKeydown($event)">
                         <div class="form-group">
                             <label>Name</label>
                             <input type="text" class="form-control" v-model="product.name" :class="{ 'is-invalid': product.errors.has('name') }">
                             <has-error :form="product" field="name"></has-error>
                         </div>
                          <div class="form-group">
                             <label>Price</label>
                             <input type="number" class="form-control" v-model="product.price" :class="{ 'is-invalid': product.errors.has('price') }">
                              <has-error :form="product" field="price"></has-error>
                         </div>
                         <button  class="btn btn-primary"><i class="fas fa-save mr-1"></i> Save</button>
                     </form>
                   </div>
               </div>
            </div>
            <div class="col-8">
              <div class="mb-2 float-right">
                <pagination :data="products" @pagination-change-page="showproduct"></pagination>
              </div>
              <table class="table">
                  <thead>
                      <tr>
                          <th>ID</th>
                          <th>Name</th>
                          <th>Price</th>
                          <th>Action</th>
                      </tr>
                  </thead>
                  <tbody>
                      <tr v-for="product in products.data" :key="product.id">
                          <td>{{product.id}}</td>
                          <td>{{product.name}}</td>
                          <td>{{product.price}}</td>
                          <td>
                              <button @click="productEdit(product)" class="btn btn-sm btn-success"><i class="fas fa-edit mr-1"></i> Edit</button>
                              <button @click="productDelete(product.id)" class="btn btn-sm btn-danger"><i class="fas fa-trash-alt mr-1"></i> Delete</button>
                          </td>
                      </tr>

                  </tbody>
              </table>
            </div>
        </div>

    </div>
</template>
<script>

export default {
    name:"product-component",
    data(){
        return{

            products:{},
            product:new Form({
                id:'',
                name:'',
                price:''
            }),
            status:false,
            search:'',
            message:''
        }
    },
    methods:{

      showproduct(page = 1){
         let loader = this.$loading.show()
         this.$Progress.start()
         axios.get(`/api/product?page=${page}&search=${this.search}`)
        .then(res=>{
            loader.hide()
             this.products = res.data
             this.$Progress.finish()
        })
        .catch(error=>this.$Progress.fail())
      },
      addProduct(){
         this.product.post('/api/product')
        .then(res=>{
            this.showproduct()
            this.product = { name:'', price:''}
            Toast.fire({
                icon: 'success',
                title: 'Add successfully'
            })
        })
        .catch(error=>this.message = error.response.data.message)
      },
      create(){
        this.product.clear()
        this.status = false
       // this.product = { id:'',name:'', price:''}
         this.product.reset()
      },
      productEdit(product){
        this.product.clear()
        this.status = true
        // this.product.id = product.id
        // this.product.name = product.name
        // this.product.price = product.price
        this.product.fill(product)
      },
      updateProduct(){
         this.product.put(`/api/product/${this.product.id}`)
         .then(res=>{
              this.status = false
            //  this.product = { id:'',name:'', price:''}
              this.product.reset()
                Toast.fire({
                icon: 'success',
                title: 'Update successfully'
              })
              this.showproduct()
         })
        .catch(error=>this.message = error.response.data.message)
      },
      productDelete(id){
          Swal.fire({
            title: 'Are you sure?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.delete(`/api/product/${id}`)
                    .then(res=>{
                        this.showproduct()
                        Swal.fire({ title:'Deleted!', icon:'success' })
                        Toast.fire({
                            icon: 'success',
                            title: 'Deleted successfully'
                        })
                    })
                }
            })

      }
    },
    created(){
        this.showproduct()
    }
}
</script>
