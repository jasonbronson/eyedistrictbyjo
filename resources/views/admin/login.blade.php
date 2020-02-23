@include('admin.header')

<div class="py-5">
    <div class="container">
      <div class="row">
        <div class="col-md-3"> </div>
        <div class="col-md-6">
          <div class="card text-white p-5 bg-primary">
            <div class="card-body">
              <h1 class="mb-4">Login form</h1>
              <form action="/admin/login/">
                <div class="form-group"> <label>Email address</label>
                  <input type="email" class="form-control" name="email" placeholder="Enter email"> </div>
                <div class="form-group"> <label>Password</label>
                  <input type="password" class="form-control" name="password" placeholder="Password"> </div>
                <button type="submit" class="btn btn-secondary">Login</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

@include('admin.footer')

