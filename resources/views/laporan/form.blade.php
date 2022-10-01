<div class="modal fade" id="modal-form" tabindex="-1" aria-labelledby="modal-form" aria-hidden="true">
    <div class="modal-dialog">
        <form method="get" action="{{route('laporan.refresh')}}" class="form-horizontal">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Periode Laporan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        onclick="closeModal()"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Tanggal Awal:</label>
                        <div class="input-group date" id="reservationdate" data-target-input="nearest">
                            <input type="date" name="tanggal_awal" id="tanggal_awal" class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Tanggal Akhir:</label>
                        <div class="input-group date" id="reservationdate2" data-target-input="nearest">
                            <input type="date" name="tanggal_akhir" id="tanggal_akhir" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="btn-close" type="button" class="btn btn-sm btn-flat btn-secondary"
                        data-bs-dismiss="modal" onclick="closeModal()">Close</button>
                    <button type="submit" class="btn btn-sm btn-flat btn-primary">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    function closeModal() {
        $('#modal-form').modal('hide');
    }

</script>
