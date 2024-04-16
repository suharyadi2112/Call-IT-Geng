@extends('partial.layout.main')
@section('title', 'Pengaduan')
@section('content')
<div class="page-inner">
	<h4 class="page-title">Jadwal Oncall</h4>
    @include('partial.layout.error_message')
	<div class="row">
        <div class="col-md-12">
            <div class="card">
                
                <div class="card-body">
                    <div id="calendar">
                    </div>
                </div>
            </div>
        </div>
    </div>



</div>

  <div class="modal fade" id="modalOncall" tabindex="-1" role="dialog" aria-labelledby="modalOncallLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <form id="postForm" name="postForm">
            @csrf
            <div class="modal-header">
            <h5 class="modal-title" id="title">Jadwal Oncall</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="type" name="type"/>
                <input type="hidden" id="id" name="id"/>
                <div class="form-group">
                    <label for="nama">Nama Worker</label>
                    <select name="id_user" id="id_user" class="form-control form-control-border border-width-2" style="width: 100%">
                        <option value="">-- Pilih Orang --</option>
                        @foreach ($user_worker as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="nama">Tipe Oncall</label>
                    <select name="tipe_oncall" id="tipe_oncall" class="form-control form-control-border border-width-2" style="width: 100%">
                        <option value="oncall">Oncall</option>
                        <option value="onsite">Onsite</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="nama">Tanggal</label>
                    <input type="date" name="tanggal_oncall" id="tanggal_oncall" class="form-control form-control-border border-width-2">
                </div>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            <button type="button" class="btn btn-danger" id="delBtn">Hapus</button>
            <button type="submit" id="saveBtn" class="btn btn-primary">Simpan Perubahan</button>
            </div>
        </form>
      </div>
    </div>
  </div>

@endsection

@push('style')


	
@endpush

@push('script')
<script src="{{ asset('/assets/js/plugin/moment/moment.min.js') }}"></script>
<script src="{{ asset('/assets/js/plugin/fullcalendar/fullcalendar.min.js') }}"></script>
<script src="{{ asset('/assets/js/plugin/fullcalendar/locale/id.js') }}"></script>
{{-- <script src="{{ asset('/assets/js/plugin/select2/select2.full.min.js') }}"></script> --}}
<script>
    $(document).ready(function () {

        // $(["#worker", "#tipe"]).select2({
        //     placeholder: "-- Pilih Input --",
        //     theme: 'bootstrap',
        // });


        var date = new Date();
        var d = date.getDate();
        var m = date.getMonth();
        var y = date.getFullYear();
        var className = Array('fc-primary', 'fc-danger', 'fc-black', 'fc-success', 'fc-info', 'fc-warning', 'fc-danger-solid', 'fc-warning-solid', 'fc-success-solid', 'fc-black-solid', 'fc-success-solid', 'fc-primary-solid');

        $calendar = $('#calendar');
        $calendar.fullCalendar({
            height: 500,
            selectable : true,
            selectHelper: true,
            showNonCurrentDates : false,
            locale: 'id',
            dayNamesShort: ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'],
            events: function(start, end, timezone, callback) {
                $.ajax({
                    url: '{{ route("jadwal-oncall.get") }}',
                    method: 'GET',
                    success: function(data) {
                        var events = [];
                        data.forEach(function(item) {
                            var className = (item.tipe_oncall === 'oncall') ? 'fc-primary-solid' : 'fc-danger-solid';
                            events.push({
                                id: item.id,
                                id_user: item.detailoncallusers[0].id,
                                title: item.detailoncallusers[0].name + ' (' + item.tipe_oncall + ')',
                                start: item.tanggal_oncall,
                                className: className
                            });
                        });
                        callback(events);
                    },
                    error: function(data) {
                        alert('Terjadi kesalahan saat mengambil data acara!');
                    }
                });
            },
            eventClick: function(event) {
                var tipe = (event.className[0] === 'fc-primary-solid') ? 'oncall' : 'onsite';
                $('#title').html('Edit Jadwal Oncall');
                $('#id').val(event.id);
                $('#type').val('edit');
                $('#tipe_oncall').val(tipe);
                $('#id_user').val(event.id_user);
                $('#tanggal_oncall').val(event.start.format());
                $('#delBtn').show();
                $('#modalOncall').modal('show');
            },
            
            select: function(start) {
                $('#modalOncall').modal('show');
                $('#type').val('add');
                $('#title').html('Tambah Jadwal Oncall');
                $('#tanggal_oncall').val(start.format());
            },

        });

        function handleFormSubmit(isDelete) {
            return function (e) {
                e.preventDefault();
                var form = $(this);
                var url = '{{ route("jadwal-oncall.store") }}';
                var data = form.serialize();
                var $btn = isDelete ? $('#delBtn') : $('#saveBtn');

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: data,
                    beforeSend: function () {
                        $btn.html('<i class="fa fa-spinner fa-spin"></i> ' + (isDelete ? 'Menghapus...' : 'Memuat...'));
                        $btn.attr('disabled', true);
                    },
                    success: function (response) {
                        $('#modalOncall').modal('hide');
                        $btn.html(isDelete ? 'Hapus' : 'Simpan Perubahan');
                        $btn.attr('disabled', false);
                        $calendar.fullCalendar('refetchEvents');
                        swal({
                            title: 'Sukses',
                            text: response.message,
                            icon: 'success',
                            button: 'Ok'
                        });
                    },
                    error: function (response, xhr) {
                        $btn.html(isDelete ? 'Hapus' : 'Simpan Perubahan');
                        $btn.attr('disabled', false);
                        var res = response.responseJSON.errors;
                        var err = '';
                        $.each(res, function(key, value) {
                            $.each(value, function(i, error) {
                                err += error + '<br>';
                            });
                        });
                        swal({
                            title: 'Eror',
                            content: {
                                element: "div",
                                attributes: {
                                    innerHTML: err
                                },
                            },
                            icon: 'error',
                            button: 'Ok'
                        });
                    }
                });
            };
        }

        $(document).on('submit', '#postForm', handleFormSubmit(false));

        $(document).on('click', '#delBtn', function (e) {
            e.preventDefault();
            $('#type').val('delete');
            swal({
                title: 'Hapus Data',
                text: "Apakah anda yakin ingin menghapus data ini?",
                type: 'warning',
                buttons:{
                    cancel: {
                        visible: true,
                        text: 'Batal',
                        className: 'btn btn-secondary',
                    },
                    confirm: {
                        text : 'Hapus',
                        className : 'btn btn-danger'
                    },
                }
            }).then((Delete) => {
                if (Delete) {
                    $('#postForm').submit();
                } else {
                    swal.close();
                }
            });
        });

        $('#modalOncall').on('hidden.bs.modal', function () {
            $('#postForm').trigger('reset');

            // hidden button delete
            $('#delBtn').hide();
        });

    });
</script>
@endpush