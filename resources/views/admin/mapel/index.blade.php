@extends('layouts.admin')

@section('content')
<section role="main" class="content-body">
    <header class="page-header">
        <h2>Halaman Mata pelajaran</h2>
        <div class="right-wrapper text-right">
            <ol class="breadcrumbs">
                <li>
                    <a href="index.html">
                        <i class="fas fa-home"></i>
                    </a>
                </li>
                <li><span>Data Mata Pelajaran</span></li>
            </ol>
            <a class="sidebar-right-toggle"><i class="fas fa-chevron-left"></i></a>
        </div>
    </header>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="text-right">
                        <button class="btn btn-sm btn-success" id="tambah"><i class="fa fa-plus"></i> Tambah Data</button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped mb-0" id="datatable-default">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Mata Pelajaran</th>
                                    <th>Guru</th>
                                    <th>Kelas</th>
                                    <th>Materi</th>
                                    <th>Tanggal</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $d)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$d->mapel}}</td>
                                    <td>{{$d->instruktur->user->nama}}</td>
                                    <td>{{$d->deskripsi}}</td>
                                    <td>{{$d->pembahasan}}</td>
                                    <td>{{carbon\carbon::parse($d->tanggal)->translatedFormat('d F Y')}}</td>
                                    <td>
                                        <a href="{{Route('mapelEdit',['uuid' => $d->uuid])}}"
                                            class="btn btn-sm btn-primary m-1 "> <i class="fa fa-edit"></i></a>
                                        <button class="btn btn-sm btn-danger"
                                            onclick="Hapus('{{$d->uuid}}','{{$d->mapel}}')"> <i
                                                class="fa fa-trash"></i></button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="modal fade bd-example-modal-lg" id="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{Route('mapelStore')}}" method="post">
                    @csrf
                    <div class="form-group ">
                        <label class="">Guru</label>
                        <select name="instruktur_id" class="form-control" id="" >
                            <option value="">-- Pilih Guru --</option>
                            @foreach ($instruktur as $d)
                            <option value="{{$d->id}}">{{$d->user->nama}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group ">
                        <label class="">Mata Pelajaran</label>
                        <select name="mapel" id="mapel" class="form-control">
                            <option value="-- Pilih Mata Pelajaran --">-- Pilih Mata Pelajaran --</option>
                            <option value="B. Indonesia">B. Indonesia</option>
                            <option value="B. Jepang">B. Jepang</option>
                            <option value="Fisika">Fisika</option>
                            <option value="Kimia">Kimia</option>
                            <option value="Biologi">Biologi</option>
                            <option value="Sosiologi">Sosiologi</option>
                            <option value="Ekonomi">Ekonomi</option>
                            <option value="Geografi">Geografi</option>
                            <option value="Matematika">Matematika</option>
                        </select>
                    </div>
                    <div class="form-group ">
                        <label class="">Kelas</label>
                        <select name="deskripsi" id="keterangan" class="form-control">
                            <option value="-- Pilih Kelas --">-- Pilih Kelas --</option>
                            <option value="10 IPA 1">10 IPA 1</option>
                            <option value="10 IPA 2">10 IPA 2</option>
                            <option value="10 IPA 3">10 IPA 3</option>
                            <option value="11 IPS 1">11 IPS 1</option>
                            <option value="11 IPS 2">11 IPS 2</option>
                            <option value="11 IPS 3">11 IPS 3</option>
                            <option value="12 IPA 1">12 IPA 1</option>
                            <option value="12 IPA 2">12 IPA 2</option>
                            <option value="12 IPA 3">12 IPA 3</option>
                        </select>
                    </div>
                    <div class="form-group ">
                        <label class="">Materi yang dibahas</label>
                        <input class="form-control" name="pembahasan" id="pembahasan" required ></input>
                    </div>
                    <div class="form-group ">
                        <label class="">Tanggal</label>
                        <input type="date" name="tanggal" id="tanggal" required >
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>

@endsection
@section('scripts')
<script>
    $("#tambah").click(function(){
            $('#status').text('Tambah Data');
            $('#modal').modal('show');
        });

        function Hapus(uuid,nama) {
			Swal.fire({
			title: 'Anda Yakin?',
			text: " Menghapus Data Matapelajaran " + nama ,        
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Hapus',
			cancelButtonText: 'Batal'
		}).then((result) => {
			if (result.value) {
				url = "{{Route('mapelDestroy','')}}";
				window.location.href =  url+'/'+uuid ;			
			}
		})
        }
</script>
@endsection