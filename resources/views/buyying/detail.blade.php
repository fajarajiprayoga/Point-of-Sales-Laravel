@extends('layouts.master')

@section('title')
Pembelian Detail
@endsection

@section('breadcrumb')
@parent
<li class="breadcrumb-item active">Pembelian Detail</li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <a href="{{route('buyying.index')}}" class="btn btn-sm btn-flat btn-primary">Back</a>
                </div>
                <div class="card-body table-responsive">
                    <div class="col-lg-6">
                        @foreach ($data as $item)
                        <div class="form-group row">
                            <label for="product" class="col-lg-2 control-label">Product</label>
                            <div class="col-lg-9">
                                <input type="text" name="product" id="product" class="form-control"
                                    value="{{$item->product->product_name}}" readonly>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="buy_price" class="col-lg-2 control-label">Buy Price</label>
                            <div class="col-lg-9">
                                <input type="text" name="buy_price" id="" value="{{$item->buy_price}}"
                                    class="form-control" readonly>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="price_total" class="col-lg-2 control-label">Price Total</label>
                            <div class="col-lg-9">
                                <input type="text" name="price_total" id="" value="{{$item->buy_price}}"
                                    class="form-control" readonly>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="count" class="col-lg-2 control-label">Count</label>
                            <div class="col-lg-9">
                                <input type="text" name="count" id="" value="{{$item->count}}" class="form-control"
                                    readonly>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="subtotal" class="col-lg-2 control-label">Sub Total</label>
                            <div class="col-lg-9">
                                <input type="text" name="subtotal" id="" value="{{$item->subtotal}}"
                                    class="form-control" readonly>
                            </div>
                        </div>
                        <hr>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>

</script>
@endpush
