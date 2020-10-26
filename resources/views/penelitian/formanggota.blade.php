<div class="modal" id="modal-anggota" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
     
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"> &times; </span> </button>
                <h3 class="modal-title">Cari Anggota..</h3>
            </div>
            
            <div class="modal-body">
                <table class="table table-striped tabel-anggota">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NIDN</th>
                            <th>Nama</th>
                            <th>Pendidikan</th>
                            <th>Fungsional</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody {{ $no = 0 }}>
                        @foreach($peserta as $data)
                        <tr {{ $no++ }}>
                            <th>{{ $no }}</th>
                            <th>{{ $data->nidn }}</th>
                            <th>{{ $data->nama }}</th>
                            <th>{{ $data->pendidikan->pendidikan }}</th>
                            <th>{{ $data->fungsional->fungsional }}</th>
                            <th><a onclick="selectAnggota({{ $data->id }},'{{ $data->nidn }}','{{ $data->nama }}','{{ $data->fakultas->fakultas }} - {{ $data->universitas->pt }}','{{ $data->prodi->prodi }}','{{ $data->pendidikan->pendidikan }}','{{ $data->email }}', '{{ $data->foto }}')" class="btn btn-primary"><i class="fa fa-check-circle"></i> Pilih</a></th>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>