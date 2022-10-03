  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      <i class="fa fa-home icon-title"></i> Beranda
    </h1>
    <ol class="breadcrumb">
      <li><a href="?module=beranda"><i class="fa fa-home"></i> Beranda</a></li>
    </ol>
  </section>
  
  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-lg-12 col-xs-12">
        <div class="alert alert-info alert-dismissable">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          <p style="font-size:15px">
            <i class="icon fa fa-user"></i> Selamat datang <strong><?php echo $_SESSION['nama_user']; ?></strong> di Aplikasi Persediaan Barang.
          </p>        
        </div>
      </div>
    </div>
   
    <!-- Small boxes (Stat box) -->
    <div class="row">
      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div style="background-color:#00c0ef;color:#fff" class="small-box">
          <div class="inner">
            <?php  
            // fungsi query untuk menampilkan data dari tabel barang
            $query = mysqli_query($mysqli, "SELECT COUNT(kode_barang) as jumlah FROM is_barang")
                                            or die('Ada kesalahan pada query tampil Data barang: '.mysqli_error($mysqli));

            // tampilkan data
            $data = mysqli_fetch_assoc($query);
            ?>
            <h3><?php echo $data['jumlah']; ?></h3>
            <p>Data barang</p>
          </div>
          <div class="icon">
            <i class="fa fa-folder"></i>
          </div>
          <?php  
          if ($_SESSION['hak_akses']!='Manajer') { ?>
            <a href="?module=barang" class="small-box-footer" title="Tambah Data" data-toggle="tooltip"><i class="fa fa-plus"></i></a>
          <?php
          } else { ?>
            <a class="small-box-footer"><i class="fa"></i></a>
          <?php
          }
          ?>
        </div>
      </div><!-- ./col -->

      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div style="background-color:#00a65a;color:#fff" class="small-box">
          <div class="inner">
            <?php   
            // fungsi query untuk menampilkan data dari tabel barang masuk
            $query = mysqli_query($mysqli, "SELECT COUNT(kode_transaksi) as jumlah FROM is_barang_masuk")
                                            or die('Ada kesalahan pada query tampil Data barang Masuk: '.mysqli_error($mysqli));

            // tampilkan data
            $data = mysqli_fetch_assoc($query);
            ?>
            <h3><?php echo $data['jumlah']; ?></h3>
            <p>Data Barang Masuk</p>
          </div>
          <div class="icon">
            <i class="fa fa-sign-in"></i>
          </div>
          <?php  
          if ($_SESSION['hak_akses']!='Manajer') { ?>
            <a href="?module=barang_masuk" class="small-box-footer" title="Tambah Data" data-toggle="tooltip"><i class="fa fa-plus"></i></a>
          <?php
          } else { ?>
            <a class="small-box-footer"><i class="fa"></i></a>
          <?php
          }
          ?>
        </div>
      </div><!-- ./col -->

      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div style="background-color:#f39c12;color:#fff" class="small-box">
          <div class="inner">
            <?php  
            // fungsi query untuk menampilkan data dari tabel barang
            $query = mysqli_query($mysqli, "SELECT COUNT(kode_barang) as jumlah FROM is_barang")
                                            or die('Ada kesalahan pada query tampil Data barang: '.mysqli_error($mysqli));

            // tampilkan data
            $data = mysqli_fetch_assoc($query);
            ?>
            <h3><?php echo $data['jumlah']; ?></h3>
            <p>Laporan Stok barang</p>
          </div>
          <div class="icon">
            <i class="fa fa-file-text-o"></i>
          </div>
          <a href="?module=lap_stok" class="small-box-footer" title="Cetak Laporan" data-toggle="tooltip"><i class="fa fa-print"></i></a>
        </div>
      </div><!-- ./col -->

      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div style="background-color:#dd4b39;color:#fff" class="small-box">
          <div class="inner">
            <?php   
            // fungsi query untuk menampilkan data dari tabel barang masuk
            $query = mysqli_query($mysqli, "SELECT COUNT(kode_transaksi) as jumlah FROM is_barang_masuk")
                                            or die('Ada kesalahan pada query tampil Data barang Masuk: '.mysqli_error($mysqli));

            // tampilkan data
            $data = mysqli_fetch_assoc($query);
            ?>
            <h3><?php echo $data['jumlah']; ?></h3>
            <p>Laporan Barang Masuk</p>
          </div>
          <div class="icon">
            <i class="fa fa-clone"></i>
          </div>
          <a href="?module=lap_barang_masuk" class="small-box-footer" title="Cetak Laporan" data-toggle="tooltip"><i class="fa fa-print"></i></a>
        </div>
      </div><!-- ./col -->

        <div class="col-md-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Berita / Pengumuman Internal <span class="small">Gudang</span></h3>
        </div>
        <div class="box-body">
          <ul class="list-unstyled">
            <li>
              <h4>
                <b>Data Barang Masuk (2)</b> <span class="badge bg-purple">PENTING</span><br/>
                <span class="small">Oleh : <b>Operator</b> - 28-7-2018 00:00</span><br/><br/>

                <b>Laporan Barang Masuk (2)</b> <span class="badge bg-purple">PENTING</span><br/>
                <span class="small">Oleh : <b>Operator</b> - 28-7-2018 00:00 </span>
              </h4>
              <hr/>
            </li>
          </ul>
        </div>
      </div>
    </div>
   <!--  <div class="col-md-6">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Pengiriman hari ini</h3>
        </div>
        <div class="box-body">
          
        </div>
      </div>
    </div> -->
  </div>



    </div><!-- /.row -->


  </section><!-- /.content -->
