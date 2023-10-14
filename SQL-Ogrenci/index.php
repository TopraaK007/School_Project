<?php
session_start();
require_once("connect.php");

if(isset($_POST['devam'])) {
    $limit = $_POST['limit'] + 5;
    $s=$db->prepare("SELECT COUNT(*) FROM PHP_Ogrenci");
    $exec=$s->execute();
    $rw=$s->fetchColumn();
    if ($rw<$limit) {
        $limit="bitti";
    }
    if ($rw=0) {
        echo   "<div class='alert alert-danger' role='alert'>
        Sistemde Kayıtlı Öğrenci Bulunmamaktadır Lütfen Ekleyiniz!
         </div>";
    }
    if(isset($_GET['delete'])!="ok"){
    header("Location: index.php?limit=$limit");
    exit;
}
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <style>
        table {
            border-collapse: collapse;
            width: 50%;
            margin: auto;
            margin-bottom: 20px;


        }

        td,
        th {
            text-align: center;
            border: 1px solid lightgrey;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }

        table tr:hover {
            background-color: lightgrey;

        }

        label {
            text-align: center;
            padding: 10px;
            font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
        }

        .alert-danger {
            background-color: red;
            margin: auto;
            text-align: center;
            color: white;
            width: 50%;
            margin-top: 10px;
        }

        .alert {
            display: flex;
            justify-content: center;
        }

        .btn-sil {
            background-color: yellow;
            border: none;
            border-radius: 1rem;
            color: #f2f2f2;
            transition: transform 0.3s ease;
        }

        .btn-d {
            background-color: #19ba11;
            border: none;
            border-radius: 20px;
            color: #f2f2f2;
            transition: transform 0.3s ease;
        }

        button:hover {

            transform: scale(1.5);

        }

        .container0 {
            margin-top: 4%;
            border: 1px solid black;
            box-shadow: 0px 0px 41px -4px rgba(0, 0, 0, 0.75);
            overflow-x: hidden;
        }

        .search {
            margin-left: 10px;
        }

        .btn-secondary {
            display: block;
            margin: auto;
            margin-bottom: 10px;
            width: 25%;
        }
    </style>
</head>

<body>
    <?php
    if (isset($_SESSION['durum']) && $_SESSION['durum'] === true) {
        echo '<div class="alert alert-success" id="success-message">Güncelleme başarılı.</div>';
        unset($_SESSION['durum']);
    }
    ?>

    <script>
        // Başarı mesajını 5 saniye sonra otomatik olarak kaldır
        setTimeout(function() {
            var successMessage = document.getElementById('success-message');
            if (successMessage) {
                successMessage.style.display = 'none';
            }
        }, 4000); // 5 saniye
    </script>
    <div class="container0">
        <div class="row">
            <div class="col">
                <h1 class="display-1" style="text-align:center; color:black">Sorgulama </h1>
            </div>
        </div>
        <div class="container">
            <div class="row justify-content-center mt-3">
                <div class="col-12 col-md-8 col-lg-6 d-flex justify-content-center align-items-center p-3">
                    <form action="index.php?arama=ok" method="POST" class="d-flex">
                        <input class="search" type="text" placeholder="Öğrenci Numarasını Gir." style="border-radius:7px; border: 2px solid lightblue;width: 400px;" name="ogrenciNo" required>
                        <input class="btn btn-info mx-2" type="submit" style="color:white;" name="ogrenciAra" value="arama">
                    </form>
                    <a href="ekle.php"><input class="btn btn-danger mx-2" type="submit" style="color:white;" name="ogrenciEkle" value="Yeni Ekle"></a>
                    <a href="listele.php"><input class="btn btn-success mx-2" type="submit" style="color:white;" name="listele" value="Tümünü Listele"></a><br>
                </div>
            </div>
        </div>
        <?php  

        
      


      if (isset($_GET['limit'])) {
        $limit = $_GET['limit'];
        if ($limit=="bitti") {
            $s=$db->prepare("SELECT COUNT(*) FROM PHP_Ogrenci");
            $exec=$s->execute();
            $rw=$s->fetchColumn();
            $limit=$rw; 
        }
        
    } else {
        $limit=6;
    }
    
    if(isset($_GET['arama'])){
        if (isset($_POST['ogrenciAra'])) {
            $ogrenciNo = $_POST["ogrenciNo"];
            $s=$db->query("SELECT * FROM PHP_Ogrenci where Ad like '%$ogrenciNo%' or No like '%$ogrenciNo%'
             or Soyad like '%$ogrenciNo%' or Sınıf like '%$ogrenciNo%'");
            $s->execute();
            $searchResults = $s->fetchAll(PDO::FETCH_ASSOC);
        if ($searchResults) {
            echo "<table>
                <thead>
                    <tr>
                        <th>Ad</th>
                        <th>Soyad</th>
                        <th>Sınıf</th>
                        <th>No</th>
                        <th>İşlem</th>
                    </tr>
                </thead>
                <tbody>";
    
            foreach ($searchResults as $row) {
                echo "<tr>";
                echo "<td>" . $row['Ad'] . "</td>";
                echo "<td>" . $row['Soyad'] . "</td>";
                echo "<td>" . $row['Sınıf'] . "</td>";
                echo "<td>" . $row['No'] . "</td>";
                echo  "<td><a href='index.php?no={$row['No']}&delete=ok'><button name='sil' class='btn-sil'>Sil</button></a> <a href='duzenle.php?no={$row['No']}&guncelle=ok'><button class='btn-d'>Düzenle</button></a></td>";
                echo "</tr>";
            }
    
            echo "</tbody></table>";
        } else {
            echo   "<div class='alert alert-danger' role='alert'>
            Sonuç Bulunamadı!
             </div>";
        }
        }  
    }else {
        
    if (isset($_GET['delete']) == 'ok') {
        $sorgu = $db->prepare("DELETE FROM PHP_Ogrenci where No=:no");
        $delete = $sorgu->execute(array(
            'no' => $_GET['no']
        ));
        if ($delete) {
            $p = $db->prepare("SELECT TOP $limit * FROM PHP_Ogrenci");
    $e = $p->execute();
    if ($e) {
        $p->fetch(PDO::FETCH_ASSOC);
        echo "<table>
            <thead>
                <tr>
                    <th>Ad</th>
                    <th>Soyad</th>
                    <th>Sınıf</th>
                    <th>No</th>
                    <th>İşlem</th>
                </tr>
            </thead>
            <tbody>";
    
        foreach ($p as $row) {
            echo "<tr>";
            echo "<td>" . $row['Ad'] . "</td>";
            echo "<td>" . $row['Soyad'] . "</td>";
            echo "<td>" . $row['Sınıf'] . "</td>";
            echo "<td>" . $row['No'] . "</td>";
            echo  "<td><a href='index.php?limit={$limit}&no={$row['No']}&delete=ok'><button name='sil' class='btn-sil'>Sil</button></a> <a href='duzenle.php?no={$row['No']}&guncelle=ok'><button class='btn-d'>Düzenle</button></a></td>";
            echo "</tr>";
        }
    
        echo "</tbody></table>";
        
        // Diğer Sonuçlar butonuna tıklanırsa, yeni limit değerini gönderin
        echo "<form action='index.php' method='POST'><input type='hidden' name='limit' value='$limit'>";
        echo "<button type='submit' name='devam' class='btn btn-secondary'>Diğer Sonuçlar</button></form>";
          
        }
    }
    }
    else {
        $_GET['delete']="no";
    }
}
if(isset($_GET['arama'])){
    if (isset($_POST['ogrenciAra'])) {
        
       exit;    
     }    
}else {
    
    if($_GET['delete']!="ok"){
    $p = $db->prepare("SELECT TOP $limit * FROM PHP_Ogrenci");
    $e = $p->execute();
    if ($e) {
        $p->fetch(PDO::FETCH_ASSOC);
        echo "<table>
            <thead>
                <tr>
                    <th>Ad</th>
                    <th>Soyad</th>
                    <th>Sınıf</th>
                    <th>No</th>
                    <th>İşlem</th>
                </tr>
            </thead>
            <tbody>";
    
        foreach ($p as $row) {
            echo "<tr>";
            echo "<td>" . $row['Ad'] . "</td>";
            echo "<td>" . $row['Soyad'] . "</td>";
            echo "<td>" . $row['Sınıf'] . "</td>";
            echo "<td>" . $row['No'] . "</td>";
            echo  "<td><a href='index.php?limit={$limit}&no={$row['No']}&delete=ok'><button name='sil' class='btn-sil'>Sil</button></a> <a href='duzenle.php?no={$row['No']}&guncelle=ok'><button class='btn-d'>Düzenle</button></a></td>";
            echo "</tr>";
        }
    
        echo "</tbody></table>";
        
        // Diğer Sonuçlar butonuna tıklanırsa, yeni limit değerini gönderin
        echo "<form action='index.php' method='POST'><input type='hidden' name='limit' value='$limit'>";
        echo "<button type='submit' name='devam' class='btn btn-secondary'>Diğer Sonuçlar</button></form>";
    } else {
        echo "<div class='alert'>
                    <div class='alert alert-danger' role='alert'>
                        Hiç Öğrenci Bulunmuyor!
                  </div>
                  </div>";
    }
}
}
    




?>


    </div>
</body>

</html>