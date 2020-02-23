
  <div class="p-2">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <h1 class="">Add Products</h1>
        </div>
      </div>
    </div>
  </div>
  <div class="py-5">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <form method="post" action="" id="myForm" enctype='multipart/form-data'>
            <div class="form-group"> <label>Sku</label>
              <input type="text" name="sku" class="form-control" placeholder="Enter sku"> </div>
            <div class="form-group"> <label>Name</label>
              <input type="text" name="name" class="form-control" placeholder="Enter name"> </div>
            <div class="form-group"> <label>Description</label>
              <input type="text" name="description" class="form-control" placeholder="Enter description" maxlength="100"> </div>
            <div class="form-group"> <label>Qty</label>
              <input type="text" name="qty" class="form-control" placeholder="Enter qty"> </div>
            <div class="form-group"> <label>Price</label>
              <input type="text" name="price" class="form-control" placeholder="Enter price"> </div>
            <div class="form-group"> <label>Image</label>
              <input type="file" name="image" class="form-control" placeholder="Enter image" accept="image/*"> </div>  
            
              {{csrf_field()}}
            <button type="submit" class="btn btn-primary btn-save">Save</button>
          </form>
        </div>
      </div>
    </div>
  </div>