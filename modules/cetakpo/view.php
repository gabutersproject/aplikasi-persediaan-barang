<?php

include 'class/class.php'

?>  

<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    <i class="fa fa-sign-in icon-title"></i> Cetak Purchase Order

 
  </h1>

</section>
<div class="row">
    <div class="col-md-12">
        <!-- Advanced Tables -->
        <div class="panel panel-default">
            <div class="panel-heading">
                Cetak Purchase Order
            </div>
            <div class="panel-body">
                <div class="table">
                    <table id="dataTables1" class="table table-striped table-bordered table-hover" id="tabelku">
                        
						<thead>
                            <tr>
                                <th>No</th>
                                <th>Kode Purchase</th>
                                <th>Tanggal PO</th>
                                <th>Kode Project</th>
                                <th>Supplier</th
                                <th>Total barang</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php  
                                $brg = $purchase->tampil_purchase();
                                foreach ($brg as $index => $data) {
                            ?>
                            <tr class="odd gradeX">
                                <td><?php echo $index + 1; ?></td>
                                <td><?php echo $data['kode_purchase']; ?></td>
                                <td><?php echo $data['tanggal_po']; ?></td>
                                <td><?php echo $data['kode_project']; ?></td
                                <td><?php echo $data['kode_supplier']; ?></td>
                                <td><?php echo $data['total']; ?></td>
                                <td>
                                    
                                    <a href="modules/cetakpo/cetakfakturkeluar.php?oid=<?= base64_encode($data['kode_purchase']) ?>&id-uid=<?= base64_encode($data['kode_project']) ?>&inf=<?= base64_encode($data['kode_purchase']) ?>&uuid=<?= base64_encode(date("d-m-Y",strtotime($data['tanggal_po']))) ?>" target="_blank" class="btn bluetbl"><span class="btn-hapus-tooltip"></span><i class="fa fa-print"></i></a> 
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
