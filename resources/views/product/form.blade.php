<div class="modal fade" id="modal-form" tabindex="-1" aria-labelledby="modal-form" aria-hidden="true">
  <div class="modal-dialog modal-lg" width="500px">
    <form method="post" class="form-horizontal">
        @csrf
        @method('POST')
        <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Modal title</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="closeModal()"></button>
      </div>
      <div class="modal-body">
        <div class="form-group row">
            <label for="product_name" class="col-md-2" control-label>Product Name</label>
            <div class="col-md-10">
                <input type="text" name="product_name" id="product_name" class="form-control" required>
            </div>
        </div>
        <div class="form-group row">
            <label for="id_category" class="col-md-2" control-label>Category</label>
            <div class="col-md-10">
                <select name="id_category" id="id_category" class="form-control" required>
                  <option value="">Select Category</option>
                  @foreach ($categorys as $key => $item)
                      <option value="{{$key}}">{{$item}}</option>
                  @endforeach
                </select>
            </div>
        </div>        
        <div class="form-group row">
            <label for="merk" class="col-md-2" control-label>Merk</label>
            <div class="col-md-10">
                <input type="text" name="merk" id="merk" class="form-control" required>
            </div>
        </div>
        <div class="form-group row">
            <label for="buy_price" class="col-md-2" control-label>Buy Price</label>
            <div class="col-md-10">
                <input type="number" name="buy_price" id="buy_price" class="form-control" required>
            </div>
        </div>
        <div class="form-group row">
            <label for="discount" class="col-md-2" control-label>Disc</label>
            <div class="col-md-10">
                <input type="number" name="discount" id="discount" class="form-control" value="0">
            </div>
        </div>
        <div class="form-group row">
            <label for="sell_price" class="col-md-2" control-label>Sell Price</label>
            <div class="col-md-10">
                <input type="number" name="sell_price" id="sell_price" class="form-control" required>
            </div>
        </div>
        <div class="form-group row">
            <label for="stock" class="col-md-2" control-label>Stock</label>
            <div class="col-md-10">
                <input type="number" name="stock" id="stock" class="form-control" required value="0">
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button id="btn-close" type="button" class="btn btn-sm btn-flat btn-secondary" data-bs-dismiss="modal" onclick="closeModal()">Close</button>
        <button id="submit-form" type="submit" class="btn btn-sm btn-flat btn-primary">Save</button>
      </div>
    </div>
    </form>
  </div>
</div>

<script>
  function closeModal(){
    $('#modal-form').modal('hide');
  }
</script>