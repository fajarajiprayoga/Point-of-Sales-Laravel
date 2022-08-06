<div class="modal fade" id="modal-form" tabindex="-1" aria-labelledby="modal-form" aria-hidden="true">
  <div class="modal-dialog">
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
            <label for="name" class="col-md-2" control-label>Name</label>
            <div class="col-md-10">
                <input type="text" name="name" id="name" class="form-control" required autofocus>
            </div>
        </div>
        <div class="form-group row">
            <label for="address" class="col-md-2" control-label>Address</label>
            <div class="col-md-10">
                <input type="text" name="address" id="address" class="form-control" autofocus>
            </div>
        </div>
        <div class="form-group row">
            <label for="telephone" class="col-md-2" control-label>Telephone</label>
            <div class="col-md-10">
                <input type="text" name="telephone" id="telephone" class="form-control" required autofocus>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button id="btn-close" type="button" class="btn btn-sm btn-flat btn-secondary" data-bs-dismiss="modal" onclick="closeModal()">Close</button>
        <button type="submit" class="btn btn-sm btn-flat btn-primary">Save</button>
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