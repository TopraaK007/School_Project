<?php
require_once("connect.php");


if (isset($_POST['ekle'])) {
    $sorgu=$db->prepare("INSERT INTO PHP_Ogrenci (Ad,Soyad,Sınıf) 
    VALUES(:ad,:soyad,:sinif)");
    $insert=$sorgu->execute(array(
        'ad' => $_POST['name'],
        'soyad' => $_POST['surname'],
        'sinif' => $_POST['class']
    ));
    if ($insert) {
        echo "<div class='alert'>
        <div class='alert alert-success' role='alert'>
         Kayıt Başarılı!
      </div>
      </div>";
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yeni Ekle</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <style>
        .center-content {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 500px; 
        }
        .card{
            width: 50%;
            padding: 50px;
            border-radius: 40px;
            border-color: grey;
            box-shadow:0px 0px 41px -4px rgba(0,0,0,0.75);
        }
        .form-control{
            border-color: lightgray
        }
        .btn-danger{
            width:100%;
        }
        *{
            
            overflow-y: hidden;
            overflow-x: hidden;
        }  
        .alert{
            display: flex;
            justify-content: center;
            
        }  
        .alert-success{
            background-color: green;
            margin: 5px;
            text-align: center;
            color: white;
            width: 50%;
        }
        
        .btn-info{
            margin-top: 1rem;
            width:100%;
            color: white;
        }
      
    </style>
</head>

<body>
        <div class="row">
            <div class="col">
                <h1 class="display-1" style="text-align:center; color:black">Öğrenci Ekle </h1>
            </div>
        </div>
    <div class="center-content">
    <div class="card">
        <form action="ekle.php" method="POST">
            <div class="row mb-3">
                <label for="inputEmail3" class="col-sm-2 col-form-label">Ad:</label>
                <div class="col-sm-10">
                    <input type="text" name="name" class="form-control" id="inputEmail3" required>
                </div>
            </div>
            <div class="row mb-3">
                <label for="inputPassword3" class="col-sm-2 col-form-label">Soyad:</label>
                <div class="col-sm-10">
                    <input type="text" name="surname" class="form-control" id="inputPassword3" required>
                </div>
            </div>
            <div class="row mb-3">
                <label for="inputPassword3" class="col-sm-2 col-form-label">Sınıf:</label>
                <div class="col-sm-10">
                    <input type="text" name="class" class="form-control" id="inputPassword3" required>
                </div>
            </div>
          
            <button type="submit" name="ekle" class="btn btn-danger">Yeni Ekle</button>
        </form>
        <a href="index.php"><button type="submit" name="ekle" class="btn btn-info">Anasayfa</button></a>
    </div>
    </div>
</body>

</html>

