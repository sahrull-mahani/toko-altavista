<div class="alert alert-info alert-dismissible  text-center">
    <h5><i class="icon fas fa-info"></i> <?= $nama ?></h5>
</div>
<div class="form-group row mode2">
    <label for="id_barang" class="col-sm-3 col-form-label">Id Barang</label>
    <div class="col-sm-9 item">
        <input type="text" class="form-control" id="id_barang" name="id_barang[]" value="<?= (isset($get->id_barang)) ? $get->id_barang : ''; ?>" placeholder="Id Barang" required />
    </div>
</div>
<div class="form-group row mode2">
    <label for="jumlah" class="col-sm-3 col-form-label">Jumlah</label>
    <div class="col-sm-9 item">
        <input type="text" class="form-control" id="jumlah" name="jumlah[]" value="<?= (isset($get->jumlah)) ? $get->jumlah : ''; ?>" placeholder="Jumlah" required />
    </div>
</div>
<input type="hidden" name="id[]" value="<?= (isset($get->id)) ? $get->id : ''; ?>" />