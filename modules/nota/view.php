<?php

include 'class/class.php'

?>  

<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    <i class="fa fa-sign-in icon-title"></i> Cetak Faktur Keluar

 
  </h1>

</section>
<div class="row">
    <div class="col-md-12">
        <!-- Advanced Tables -->
        <div class="panel panel-default">
            <div class="panel-heading">
                Cetak Faktur Keluar
            </div>
            <div class="panel-body">
                <div class="table">
                    <table id="dataTables1" class="table table-striped table-bordered table-hover" id="tabelku">
                        
						<thead>
                            <tr>
                                <th>No</th>
                                <th>Kode Transaksi</th>
                                <th>Tanggal Keluar</th>
                                <th>Kode Project</th>
                                <th>Penerima</th>
                                <th>Alamat</th>
                                <th>Total barang</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php  
                                $brg = $barangkeluar->tampil_keluar();
                                foreach ($brg as $index => $data) {
                            ?>
                            <tr class="odd gradeX">
                                <td><?php echo $index + 1; ?></td>
                                <td><?php echo $data['kode_transaksi']; ?></td>
                                <td><?php echo $data['tanggal_keluar']; ?></td>
                                <td><?php echo $data['kdproject']; ?></td>
                                <td><?php echo $data['penerima']; ?></td>
                                <td><?php echo $data['alamat']; ?></td>
                                <td><?php echo $data['total_keluar']; ?></td>
                                <td>
                                    
                                    <a href="modules/nota/cetakfakturkeluar.php?oid=<?= base64_encode($data['kode_transaksi']) ?>&id-uid=<?= base64_encode($data['penerima']) ?>&prj=<?= base64_encode($data['kdproject']) ?>&almt=<?= base64_encode($data['alamat']) ?>&inf=<?= base64_encode($data['kode_transaksi']) ?>&uuid=<?= base64_encode(date("d-m-Y",strtotime($data['tanggal_keluar']))) ?>" target="_blank" class="btn bluetbl"><span class="btn-hapus-tooltip"></span><i class="fa fa-print"></i></a> 
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>

                    </table>
                </div>   
            </div>
        </div>
        <!--End Advanced Tables -->
    </div>
</div>
