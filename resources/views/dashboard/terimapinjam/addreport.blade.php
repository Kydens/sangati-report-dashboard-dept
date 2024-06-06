@extends('layout.AppLayout')

@section('content')
    <div class="container">
        <div class="row my-3">
            <h2 class="mb-4">Tambah Berkas</h2>
            <form method="post" action="{{ route('report.store') }}" autocomplete="off">
                @csrf
                <div class="mb-3">
                    <label for="pengirim" class="form-label">Pengirim</label>
                    <input type="text" class="form-control" id="pengirim" name="pengirim"
                        placeholder="Masukkan Nama Pengirim" value="{{ old('pengirim') }}" required autofocus>
                    @if ($errors->has('penerima'))
                        <span class="text text-danger">{{ $errors->first('penerima') }}</span>
                    @endif
                </div>
                <div class="input-group mb-5">
                    <label class="input-group-text" for="pengirim_dept_id">Pilih</label>
                    <select class="form-control" id="pengirim_dept_id" name="pengirim_dept_id" required>
                        <option selected>-- Bagian Departemen --</option>
                        @foreach ($departemens as $item)
                            <option value="{{ $item->id }}">{{ $item->nama_departemen }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="penerima" class="form-label">Penerima</label>
                    <input type="text" class="form-control" id="penerima" name="penerima"
                        placeholder="Masukkan Nama Penerima" value="{{ old('penerima') }}" required>
                    @if ($errors->has('penerima'))
                        <span class="text text-danger">{{ $errors->first('penerima') }}</span>
                    @endif
                </div>
                <div class="input-group mb-5">
                    <label class="input-group-text" for="pengirim_dept_id">Pilih</label>
                    <select class="form-control" id="pengirim_dept_id" name="penerima_dept_id" required>
                        <option selected>-- Bagian Departemen --</option>
                        @foreach ($departemens as $item)
                            <option value="{{ $item->id }}">{{ $item->nama_departemen }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="perusahaa_berkas" class="form-label">Perusahaan dan Jenis Berkas</label>
                    <div class="d-flex flex-column gap-3">
                        <div class="input-group">
                            <label class="input-group-text" for="perusahaan_id">Pilih</label>
                            <select class="form-control" id="perusahaan_id" name="perusahaan_id" required>
                                <option selected>-- Nama Perusahaan --</option>
                                @foreach ($perusahaans as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama_perusahaan }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="input-group">
                            <label class="input-group-text" for="tanda_terimapinjam_id">Pilih</label>
                            <select class="form-control" id="tanda_terimapinjam_id" name="tanda_terimapinjam_id" required>
                                <option selected>-- Jenis Berkas --</option>
                                @foreach ($berkass as $item)
                                    <option value="{{ $item->id }}">{{ $item->jenis }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="d-flex flex-column">
                    <div class="d-flex gap-3 align-items-start mb-4">
                        <div class="col-sm-3">
                            <label for="item" class="form-label">Item</label>
                            <input type="text" class="form-control" id="nama_item" name="nama_item[]"
                                placeholder="Masukkan Nama Barang" value="{{ old('nama_item[]') }}" required>
                        </div>
                        <div class="col-sm-2">
                            <label for="quantity" class="form-label">Quantity</label>
                            <input type="text" class="form-control" id="quantity" name="quantity[]"
                                placeholder="Minimal 1" value="{{ old('quantity[]') }}" required>
                            <div class="form-text">Tambahkan keterangan: <br> pcs, box, dan-lain</div>
                            @if ($errors->has('quantity'))
                                <span class="text text-danger">{{ $errors->first('quantity') }}</span>
                            @endif
                        </div>
                        <div class="col-sm-4">
                            <label for="quantity" class="form-label">Detail Item</label>
                            <input type="text" class="form-control" id="quantity" name="detail[]"
                                placeholder="Detail item seperti merk, serial, dan lain-lain"
                                value="{{ old('detail[]') }}">
                            <div class="form-text">*Opsional</div>
                        </div>
                    </div>
                    <div id="items-container"></div>
                </div>
                <div class="mb-3 d-flex align-items-center gap-2">
                    <button type="button" id="add-item" class="btn btn-outline-dark" style="padding:6px 12p">
                        Tambah item
                    </button>
                    <button type="button" id="delete-item" class="btn btn-danger" style="padding:6px 12px;">
                        Hapus Item
                    </button>
                </div>
                <div class="mb-3">
                    <button type="submit" class="btn btn-dark d-flex align-items-center gap-3">
                        <i class="lni lni-printer"></i>
                        Preview dan Cetak
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('#add-item').click(function() {
                var newItemRow = $(`
                <div class="d-flex gap-3 align-items-start mb-3 item-row">
                    <div class="col-sm-3">
                        <label for="item" class="form-label">Item</label>
                        <input type="text" class="form-control" name="nama_item[]" placeholder="Masukkan Nama Barang" required>
                        <div class="form-text">Masukkan dalam pcs, box, rim, dan-lain</div>
                    </div>
                    <div class="col-sm-2">
                        <label for="quantity" class="form-label">Quantity</label>
                        <input type="text" class="form-control" name="quantity[]" placeholder="Minimal 1" required>
                        <div class="form-text">Tambahkan keterangan: <br> pcs, box, dan-lain</div>
                        @if ($errors->has('quantity'))
                            <span class="text text-danger">{{ $errors->first('quantity') }}</span>
                        @endif
                    </div>
                    <div class="col-sm-4">
                        <label for="quantity" class="form-label">Detail Item</label>
                        <input type="text" class="form-control" name="detail[]" placeholder="Opsional">
                    </div>
                </div>
            `);
                $('#items-container').append(newItemRow);
            });

            $('#delete-item').click(function() {
                $('.item-row').last().remove();
            })
        });
    </script>
@endsection
