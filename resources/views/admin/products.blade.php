<div class="p-2">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <h1 class="">Products</h1>
        </div>
      </div>
    </div>
  </div>
  <div class="py-2">
    <div class="container">
      <div class="row">
        <div class="col-md-6">
          <form class="form-inline" method="post" action="">
            <input type="text" name="search" class="form-control search-text" placeholder="Search by name" value="{{$search}}">
            <button type="submit" class="btn btn-primary btn-search">Search</button>
          </form>
        </div>
        <div class="col-md-4">
          <div class="btn-group text-right">
            <button class="btn btn-primary dropdown-toggle btn-filter" data-toggle="dropdown"><i class="fa fa-filter" aria-hidden="true"></i> Filter&nbsp;</button>
            <div class="dropdown-menu">
              <a class="dropdown-item" href="/admin/?filter=WOMEN">Category Women</a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="/admin/?filter=MEN">Category Men</a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="/admin/?filter=">All Items</a>
            </div>
          </div>
        </div>
        <div class="">
          <div class="btn-group text-right">
            <button class="btn btn-primary btn-refresh"><i class="fa fa-refresh"></i> Refresh&nbsp;</button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="py-3">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <table class="table">
            <thead>
              <tr>
                <th>Category</th>
                <th>Sku</th>
                <th>Name</th>
                <th>Description</th>
                <th>Qty</th>
                <th>Price</th>
                <th>Image</th>
                <th>Details</th>
                <th>Edit</th>
                <th>Delete</th>
              </tr>
            </thead>
            <tbody>
            
            @foreach($products as $product)
              <tr>
                <td>{{$product->category}}</td>
                <td>{{$product->sku}}</td>
                <td>{{$product->name}}</td>
                <td>{{$product->description}}</td>
                <td>{{$product->qty}}</td>
                <td>${{$product->price}}</td>
                <td><img src='{{$product->image}}' width="75" height="75"></td>
                <td><button class="btn btn-primary btn-details" data-toggle="modal" data-target="#DetailsModal" data-id="{{$product->id}}" data-sku="{{$product->sku}}">Details</button></td>
                <td><button class="btn btn-primary btn-edit" data-toggle="modal" data-target="#EditModal" data-id="{{$product->id}}" data-sku="{{$product->sku}}" data-json="{{json_encode($product)}}">Edit</button></td>
                <td><button class="btn btn-danger btn-delete" data-id="{{$product->id}}">Delete</button></td>
              </tr>
            @endforeach

            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>



  <div class="modal fade" id="EditModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
    <form id="myForm" class="" method="post" action="" enctype='multipart/form-data'>
      <div class="modal-header">
        <h5 class="modal-title">Editing Product Sku <span class="modal-edit-name"></span></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
        <div class="col-md-12">
            <input type="hidden" name="id" value="">
            <div class="form-group"> <label>Sku</label>
              <input type="text" name="sku" class="form-control" disabled> </div>
            <div class="form-group"> <label>Name</label>
              <input type="text" name="name" class="form-control"> </div>
            <div class="form-group"> <label>Description</label>
              <input type="text" name="description" class="form-control" maxlength="100"> </div>
            <div class="form-group"> <label>Qty</label>
              <input type="text" name="qty" class="form-control"> </div>
            <div class="form-group"> <label>Price</label>
              <input type="text" name="price" class="form-control"> </div>
            <div class="form-group"> <label>Image</label>
              <input type="file" name="image" class="form-control" placeholder="Enter image" accept="image/*"> </div>  
              {{csrf_field()}} 
        </div>
      </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary btn-save">Save Changes</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
      </form>
    </div>
  </div>
</div>


  <div class="modal fade" id="DetailsModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
    <form id="myForm" class="" method="post" action="" enctype='multipart/form-data'>
      <div class="modal-header">
        <h5 class="modal-title">Details for Product Sku <span class="modal-edit-name"></span></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
        <div class="col-md-12">
            <input type="hidden" name="id" value="">
            <div class="form-group"> <label>Frame Shape</label>
              <input type="text" name="frameshape" class="form-control"> 
            </div>
            <div class="form-group"> <label>Frame Type</label>
              <input type="text" name="frametype" class="form-control"> 
            </div>
            <div class="form-group"> <label>Category</label>
              <select name="category">
                <option value="WOMEN">WOMEN</option>
                <option value="MEN">MEN</option>
              </select> 
            </div>
            <div class="form-group"> <label>Material</label>
              <input type="text" name="material" class="form-control"> 
            </div>
              {{csrf_field()}} 
            
        </div>
      </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary btn-save" disabled>Save Changes</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
      </form>
    </div>
  </div>
</div>

