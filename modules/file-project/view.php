<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    <i class="fa fa-folder-o icon-title"></i> Data barang

    <a class="btn btn-primary btn-social pull-right" href="?module=form_project&form=add" title="Tambah Data" data-toggle="tooltip">
      <i class="fa fa-plus"></i> Tambah
    </a>
   
   
  </h1>

</section>

<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-md-12">

    <?php  
    // fungsi untuk menampilkan pesan
    // jika alert = "" (kosong)
    // tampilkan pesan "" (kosong)
    if (empty($_GET['alert'])) {
      echo "";
    } 
    // jika alert = 1
    // tampilkan pesan Sukses "Data barang baru berhasil disimpan"
    elseif ($_GET['alert'] == 1) {
      echo "<div class='alert alert-success alert-dismissable'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
              <h4>  <i class='icon fa fa-check-circle'></i> Sukses!</h4>
              Data project baru berhasil disimpan.
            </div>";
    }
    // jika alert = 2
    // tampilkan pesan Sukses "Data barang berhasil diubah"
    elseif ($_GET['alert'] == 2) {
      echo "<div class='alert alert-success alert-dismissable'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
              <h4>  <i class='icon fa fa-check-circle'></i> Sukses!</h4>
              Data project berhasil diubah.
            </div>";
    }
    // jika alert = 3
    // tampilkan pesan Sukses "Data barang berhasil dihapus"
    elseif ($_GET['alert'] == 3) {
      echo "<div class='alert alert-success alert-dismissable'>
              <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
              <h4>  <i class='icon fa fa-check-circle'></i> Sukses!</h4>
              Data Project berhasil dihapus.
            </div>";
    }
    ?>
    
      <div class="box box-primary">
        <div class="box-body">
          <!-- tampilan tabel barang -->
          <table id="dataTables1" class="table table-bordered table-striped table-hover">
            <!-- tampilan tabel header -->
            <thead>
              <tr>
                <th class="center">No.</th>
                <th class="center">Kode Project</th>
                <th class="center">Nama Project</th>
                <th class="center">Tanggal Order</th>
                <th class="center">Tanggal Kirim</th>
                <th class="center">Nama Klien</th>
                <th class="center">Kontak</th>
                <th class="center">status</th>
                <th></th>
              </tr>
            </thead>
            <!-- tampilan tabel body -->
            <tbody>
            <?php  
            $no = 1;
            // fungsi query untuk menampilkan data dari tabel barang
             $query = mysqli_query($mysqli, "SELECT a.kode_project,a.tanggal_order,a.tanggal_kirim,a.nama_project,a.kode_klien,a.kontak,a.status,b.kode_klien,b.nama_klien
                                            FROM project as a INNER JOIN klien as b ON a.kode_klien=b.kode_klien ORDER BY kode_project DESC")
                                            or die('Ada kesalahan pada query tampil Data project: '.mysqli_error($mysqli));
            // tampilkan data
            while ($data = mysqli_fetch_assoc($query)) { 
             
              $tanggal         = $data['tanggal_kirim'];
              $exp             = explode('-',$tanggal);
              $tanggal_kirim   = $exp[2]."-".$exp[1]."-".$exp[0];

              $tanggal1         = $data['tanggal_order'];
              $exp1             = explode('-',$tanggal);
              $tanggal_order  = $exp1[2]."-".$exp1[1]."-".$exp1[0];
              // menampilkan isi tabel dari database ke tabel di aplikasi
              echo "<tr>
                      <td width='30' class='center'>$no</td>
                      <td width='80' class='center'>$data[kode_project]</td>
                      <td width='180'>$data[nama_project]</td>
                      <td width='60' class='center'>$tanggal_order</td>
                      <td width='60' class='center'>$tanggal_kirim</td>
                      <td width='60' class='center'>$data[nama_klien]</td>
                      <td width='60' class='center'>$data[kontak]</td>
                      <td width='60' class='center'>$data[status]</td>
                      <td class='center' width='80'>
                        <div>
                          <a data-toggle='tooltip' data-placement='top' title='Ubah' style='margin-right:5px' class='btn btn-primary btn-sm' href='?module=form_project&form=edit&id=$data[kode_project]'>
                              <i style='color:#fff' class='glyphicon glyphicon-edit'></i>
                          </a>";
            ?>
                          <a data-toggle="tooltip" data-placement="top" title="Hapus" class="btn btn-danger btn-sm" href="modules/project/proses.php?act=delete&id=<?php echo $data['kode_project'];?>" onclick="return confirm('Anda yakin ingin menghapus project <?php echo $data['nama_project']; ?> ?');">
                              <i style="color:#fff" class="glyphicon glyphicon-trash"></i>
                          </a>
            <?php
              echo "    </div>
                      </td>
                    </tr>";
              $no++;
            }
            ?>
            </tbody>
          </table>
        </div><!-- /.box-body -->
      </div><!-- /.box -->
    </div><!--/.col -->
  </div>   <!-- /.row -->
</section><!-- /.content
