<?php include_once "partials/scripts.php" ?>
<?php 
if (isset($_POST['button_create'])){
    $database = new Database();
    $db = $database->getConnection();
   

    $validateSQL = "SELECT * FROM bagian WHERE nama_bagian = ?";
    $stmt = $db->prepare($validateSQL);
    $stmt->bindParam(1, $_POST['nama_bagian']);
    $stmt->execute();
    if($stmt->rowCount() > 0){
        
    }else{
    $insertSQL = "INSERT B.*, K.nama_lengkap nama_kepala_bagian, L.nama_lokasi nama_lokasi_bagian INTO SET bagian B LEFT JOIN karyawan K ON B.karyawan_id = K.id LEFT JOIN lokasi L ON B.lokasi_id = L.id";
    $stmt = $db->prepare($insertSQL);
    $stmt->bindParam(1, $_POST['nama_bagian']);
    $stmt->bindParam(2, $_POST['nama_kepala_bagian']);
    $stmt->bindParam(3, $_POST['nama_lokasi_bagian']);
    if ($stmt->execute()){
        $_SESSION['hasil'] =true;
        $_SESSION['pesan'] ="Berhasil Simpan Data";
    } else {
        $_SESSION['hasil'] =false;
        $_SESSION['pesan'] ="Gagal Simpan Data";
    }
    echo "<meta http-equiv='refresh' content='0;url=?page=bagianread'>";
    }
    
    
}
?>
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            <h1>Tambah Data Bagian</h1>
            </div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="?page=home"></a>Home</li>
                <li class="breadcrumb-item"><a href="?page=bagianread">bagian</a></li>
                <li class="breadcrumb-item active">Tambah Data</li>
            </ol>
            </div>
           
    </div>
</div>   
</section> 
<section class="content">
    <div class="card">
        <div class="card-header">
            <h3 class="card-titl">Tambah Bagian</h3>
        </div>
        <div class="card-body">
            <form method="POST">
                <div class="form-group">
                    <label for="nama_bagian">Nama Bagian</label>
                    <input type="text" class="form-control" name="nama_bagian">
                </div>
                <div class="form-group">
                    <label for="karyawan_id">Kepala Bagian</label>
                    <select class="form-control" name="karyawan_id">
                        <option value="">--Kepala Bagian--</option>
                        <?php 
                        $selectSQL= "SELECT * FROM karyawan";
                        $stmt_karyawan = $db->prepare($selectSQL);
                        $stmt_karyawan->execute();

                        while ($row_karyawan = $stmt_karyawan ->fetch(PDO::FETCH_ASSOC)) {
                            $selected = $row_karyawan["id"] == $row["karyawan_id"] ? " selected" : "";
                            echo "<option value=\"" . $row_karyawan["id"] . "\" " . $selected . ">" . $row_karyawan["nama_lengkap"] . "</option>";
                        }
                        ?>
                    </select>
                        
                </div>
                
                <a href="?page=bagianread" class="btn btn-danger btn-sm float-right">
                    <i class="fa fa-times"></i> Batal
                </a>
                <button type="submit" name="button_create" class="btn btn-success btn-sm float-right">
                    <i class="fa fa-save"></i> Simpan
                </button>
            </form>
        </div>
    </div>
</section>
