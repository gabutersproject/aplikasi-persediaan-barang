<?php
$db_host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "";

$koneksi = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

if(mysqli_connect_errno()){
    echo 'Gagal melakukan koneksi ke Database : '.mysqli_connect_error();
}
?>
 
            <?php
                      
// Fungsi header dengan mengirimkan raw data excel
header("Content-type: application/vnd-ms-excel");
 
// Mendefinisikan nama file ekspor "hasil-export.xls"
header("Content-Disposition: attachment; filename=stokbarang.xls");
 
// memanggil query dari database
                             
            $sqlshow = mysqli_query($koneksi,"SELECT a.kode_barang,a.nama_barang,a.stok,a.kode_lokasi,a.satuan,b.kode_lokasi,b.nama_lokasi FROM is_barang as a INNER JOIN lokasi as b ON a.kode_lokasi=b.kode_lokasi "); 
        
            ?>
      
 
    <h3>Data Barang</h3>
      
    <table>
    
            <tr>
            
             <td width="0px">Tanggal : <?php echo date("d-m-Y") ?></td>  
             
             
         </tr>
    </table>    
         
        <table bordered="1">  
            <thead bgcolor="eeeeee" align="center">
            <tr bgcolor="eeeeee" >
               <th>No</th>
               <th>Kode Barang</th>
               <th>Nama Barang</th>
               <th>Satuan</th>
               <th>Stok</th>
               <th>Lokasi</th>
              </tr>
            </thead>
            <tbody>
         
                    
        </tbody>

        </div>
    </div>
</div>
   <?php
                        
                        //Menampilkan data dari database
                            $rowshow = mysqli_fetch_assoc($sqlshow);
                              
                                $nomor=0;
                            while($rowshow = mysqli_fetch_assoc($sqlshow)){                     
                                 $nomor++;
                                echo '<tr>';
                                echo '<td>'.$nomor.'</td>';
                                echo '<td>'.$rowshow['kode_barang'].'</td>';
                                echo '<td>'.$rowshow['nama_barang'].'</td>';
                                echo '<td>'.$rowshow['satuan'].'</td>';
                                echo '<td>'.$rowshow['stok'].'</td>';
                                echo '<td>'.$rowshow['nama_lokasi'].'</td>';
                                echo '</tr>';
                            }
                                         
                     ?>
  </table>   
