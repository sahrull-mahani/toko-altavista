<div class="alert alert-info alert-dismissible  text-center">
    <h5><i class="icon fas fa-info"></i> <?= $nama ?></h5>
</div>
<div class="form-group row mode2">
    <label for="type" class="col-sm-3 col-form-label">Type</label>
    <div class="col-sm-9 item">
        <?php $defaults = array('' => '==Pilih Type==');
        $options = array(
            'umum' => 'umum',
            'kue' => 'kue',
        );
        echo form_dropdown('type[]', $defaults + $options, (isset($get->type)) ? $get->type : '', 'class="form-control" id="type" required');
        ?>
    </div>
</div>
<div class="form-group row mode2">
    <label for="id_owner" class="col-sm-3 col-form-label">Pemilik</label>
    <div class="col-sm-9 item">
        <select id="id_owner" name="id_owner[]" class="custom-select">
            <option value="" selected disabled>Pilih Pemilik</option>
            <?php foreach ($pemilik as $row) : ?>
                <option value="<?= $row->id ?>" <?= isset($get) ? ($get->id_owner == $row->id ? 'selected' : '') : '' ?>><?= ucwords($row->nama) ?></option>
            <?php endforeach ?>
        </select>
    </div>
</div>
<div class="form-group row mode2">
    <label for="kode_barang" class="col-sm-3 col-form-label">Kode Barang</label>
    <div class="col-sm-9 item">
        <input type="text" class="form-control" id="kode_barang" name="kode_barang[]" value="<?= (isset($get->kode_barang)) ? $get->kode_barang : ''; ?>" placeholder="Kode Barang" required />
    </div>
</div>
<div class="form-group row mode2">
    <label for="nama_barang" class="col-sm-3 col-form-label">Nama Barang</label>
    <div class="col-sm-9 item">
        <input type="text" class="form-control" id="nama_barang" name="nama_barang[]" value="<?= (isset($get->nama_barang)) ? $get->nama_barang : ''; ?>" placeholder="Nama Barang" required />
    </div>
</div>
<div class="form-group row mode2">
    <label for="harga" class="col-sm-3 col-form-label">Harga</label>
    <div class="col-sm-9 item">
        <input type="text" class="form-control uang" id="harga" name="harga[]" value="<?= (isset($get->harga)) ? $get->harga : ''; ?>" placeholder="Harga" required />
    </div>
</div>
<div class="form-group row mode2">
    <label for="stok" class="col-sm-3 col-form-label">Stok</label>
    <div class="col-sm-9 item">
        <input type="text" class="form-control" id="stok" name="stok[]" value="<?= (isset($get->stok)) ? $get->stok : ''; ?>" placeholder="Stok" required />
    </div>
</div>
<input type="hidden" name="id[]" value="<?= (isset($get->id)) ? $get->id : ''; ?>" />

<script>
    $(function() {
        $(".uang").keyup(function(e) {
            $(this).val(formatRupiah($(this).val(), 'Rp. '));
        });
    });
    /* Fungsi formatRupiah */
    function formatRupiah(angka, prefix) {
        var number_string = angka.replace(/[^,\d]/g, '').toString(),
            split = number_string.split(','),
            sisa = split[0].length % 3,
            rupiah = split[0].substr(0, sisa),
            ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        // tambahkan titik jika yang di input sudah menjadi angka ribuan
        if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
    }
</script>