<div class="modal fade" id="modal-product" tabindex="-1" aria-labelledby="modal-product" aria-hidden="true">
  <div class="modal-dialog modal-xl">
        <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Pilih Product</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="closeModal()"></button>
      </div>
      <div class="modal-body">
            <table class="table table-striped table-bordered table-product">
              <thead>
                <th width="5%">No</th>
                <th width="10%">Kode</th>
                <th>Name</th>
                <th>Harga Beli</th>
                <th><i class="fa fa-cog"></i></th>
              </thead>
              <tbody>
                  @foreach ($products as $key => $item)
                      <tr>
                        <td width="5%">{{$key+1}}</td>
                        <td width="10%"> <span class="badge badge-success"> {{$item->product_code}} </span></td>
                        <td>{{$item->product_name}}</td>
                        <td>{{format_uang($item->buy_price)}}</td>
                        <td width="8%">
                          <a href="#" class="btn btn-primary btn-sm btn-flat"><i class="fa fa-check-circle" onclick="pilihProduct('{{$item->id_product}}', '{{$item->product_code}}')"></i>
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
    $('#modal-product').modal('hide');
  }
</script>