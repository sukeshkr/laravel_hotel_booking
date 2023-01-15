@extends('admin.layout.app-list')
@section('body')
<link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 ">
                <div class="x_panel">
                    <a href="{{route('hotel')}}" class="btn btn-info btn-sm" role="button" aria-disabled="true">Create Hotel</a>
                    <div class="x_content">
                        @if (session('success'))
                        <div class="alert alert-success btn-sm">
                            <strong>{{ session('success') }}</strong>
                        </div>
                        @endif
                        <table id="example" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Slno</th>
                                    <th>Hotel Name</th>
                                    <th>Location</th>
                                    <th>Description</th>
                                    <th>Image</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /page content -->
<!-- modal delete -->
<div class="modal fade" id="del-modal" tabindex="-1" role="dialog" aria-labelledby="smallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Are You Want to delete?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="smallBody">
                <div>
                    <button type="button" id="button-mod" class="btn btn-danger">Delete</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- modal delete -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
<script>
    $(document).ready(function () {
    $('#example').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url:'{{route('hotel.fetch')}}',
            dataType:'json',
            type:'GET',
        },
        columns:[
            {data:'slno'},
            {data:'name'},
            {data:'location'},
            {data:'description'},
            {data:'image'},
            {data:'actions'},
        ]
    });
});
</script>
<script>
    $(document).ready(function () {
        $('#del-modal').on('show.bs.modal', function (e) {
            var rowid = $(e.relatedTarget).data('id');
            $( "#button-mod" ).click(function() {
                $.ajax({
                    type: 'get',
                    url: "{{route('hotel.delete')}}",
                    data: 'rowid=' + rowid, //Pass $id
                    success: function (data) {
                        location.reload(true);
                    }
                });
            });
        });
    });
    </script>
@endsection
