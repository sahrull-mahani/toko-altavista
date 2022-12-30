<?= $this->extend('layout/_template') ?>

<?= $this->section('contentAdmin') ?>
<section class="content-header">
  <h1>
    Edit Menu
    <small>Control panel</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="/admin"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="">Program Kegiatan</li>
    <li class="">Edit</li>
    <li class="active"><?= $program['judul'] ?></li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <div class="box box-warning">
    <div class="box-header with-border">
      <h3 class="box-title">Input Program</h3>

      <div class="box-tools pull-right">
        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
        </button>
      </div>
      <!-- /.box-tools -->
    </div>
    <!-- /.box-header -->
    <div class="box-body">

      <!-- /.box-header -->
      <div class="box-body">
        <form action="/program/edit_program_process" method="post" enctype="multipart/form-data">
          <?= csrf_field() ?>

          <input type="hidden" name="programID" value="<?= $program['id'] ?>">
          <input type="hidden" name="nama_gambar" value="<?= $program['gambar'] ?>">

          <div class="form-group <?= ($validation->hasError('judul')) ? 'has-error' : '' ?>">
            <label>Judul</label>
            <input type="text" class="form-control" placeholder="Enter ..." name="judul" value="<?= old('judul') ? old('judul') : $program['judul'] ?>">
            <small class="text-danger"><?= $validation->getError('judul') ?></small>
          </div>

          <!-- tools box -->
          <h3 class="box-title">Tuliskan Ageanda Kegiatan
            <small class="text-danger"><?= $validation->getError('isi_program') ?></small>
          </h3>
          <!-- /. tools -->
          <!-- /.box-header -->
          <div class="box-body pad">
            <textarea id="textarea" placeholder="Place some text here" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" name="isi_program"><?= old('isi_program') ? old('isi_program') : $program['isi_program'] ?></textarea>
          </div>

          <input id="input-id" type="file" name="gambar[]" accept=".jpg, .png, image/jpeg, image/png" multiple>
          <small class="text-danger"><?= $validation->getError('gambar') ?></small>

          <!-- checkbox -->
          <div class="form-group">
            <div class="checkbox">
              <label>
                <input type="checkbox" name="publish" <?= old('publish') ? 'checked' : ($program['published_at'] == null ? '' : 'checked') ?>>
                Publish
              </label>
            </div>
          </div>

          <button type="submit" class="btn btn-primary">UPDATE</button>
        </form>
      </div>

    </div>
    <!-- /.box-body -->
  </div>
</section>

<?= $this->endSection() ?>