@extends('backend/layout/main')

@section('content')
    <div class="container-fluid">
        <h1 class="h3 mb-2 text-gray-800">Form Tambah Menu</h1>
        <div class="card shadow mb-4">
            <div class="card-body">
                <form action="{{ route('menu.prosesTambah') }}" method="post">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Nama Menu</label>
                        <input type="text" name="nama_menu" placeholder="Nama Menu" value="{{ old('nama_menu') }}" class="form-control @error('nama_menu') is-invalid @enderror">
                        @error('nama_menu')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Jenis Menu</label>
                        <div class="radio">
                            <input type="radio" value="page" name="jenis_menu" id="page">
                            <label for="page">Page</label>
                            <input type="radio" value="url" name="jenis_menu" id="url">
                            <label for="url">URL</label>
                        </div>
                        @error('jenis_menu')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3" id="url_tampil" style="display: none;">
                        <label class="form-label">URL</label>
                        <input type="url" name="link_url" class="form-control" value="{{old('link_url')}}" placeholder="URL">
                    </div>
                    <div class="mb-3" id="page_tampil" style="display: none;">
                        <label class="form-label">Page</label>
                        <select name="link_page" class="form-control" id="link_page">
                            @foreach ($page as $row)
                            <option value="{{$row->id_page}}">{{$row->judul_page}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Target Menu</label>
                        <div class="radio">
                            <input type="radio" value="_self" name="target_menu" id="self">
                            <label for="self">Tab Saat Ini</label>
                            <input type="radio" value="_blank" name="target_menu" id="blank">
                            <label for="blank">Tab Baru</label>
                        </div>
                        @error('jenis_menu')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Parent Menu</label>
                        <select name="parent_menu" class="form-control" id="parent_menu">
                            <option selected value="">Pilih Parent</option>
                            @foreach ($parent as $row)
                            <option value="{{$row->id_menu}}">{{$row->nama_menu}}</option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">Tambah</button>
                    <a href="{{ route('menu.index') }}" class="btn btn-secondary">Kembali</a>
                </form>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function(){
            $('input[type=radio][name=jenis_menu]').change(function() {
                if (this.value === 'url') {
                    $('#url_tampil').show();
                    $('#page_tampil').hide();
                }
                else if (this.value === 'page') {
                    $('#url_tampil').hide();
                    $('#page_tampil').show();
                }
            });
        });
    </script>
@endsection
