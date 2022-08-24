{{-- Supplier --}}
<div class="modal fade" id="modal-supplier" tabindex="-1" aria-labelledby="modal-supplier" aria-hidden="true">
  <div class="modal-dialog modal-xl">
        <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Pilih Supplier</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="closeModal()"></button>
      </div>
      <div class="modal-body">
            <table class="table table-striped table-bordered table-supplier">
              <thead>
                <th>No</th>
                <th>Name</th>
                <th>Telephone</th>
                <th>Alamat</th>
                <th><i class="fa fa-cog"></i></th>
              </thead>
              <tbody>
                  @foreach ($suppliers as $key => $item)
                      <tr>
                        <td width="5%">{{$key+1}}</td>
                        <td>{{$item->name}}</td>
                        <td>{{$item->address}}</td>
                        <td>{{$item->telephone}}</td>
                        <td width="8%">
                          <a href="{{route('buyying.create', $item->id_supplier)}}" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-check-circle"></i>
                            Pilih</a>
                        </td>
                      </tr>
                  @endforeach
              </tbody>
            </table>
      </div>
  </div>
</div>

<script>
  function closeModal(){
    $('#modal-form').modal('hide');
  }
</script>