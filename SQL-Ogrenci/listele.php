<?php
require_once("connect.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <title>Liste</title>
    <style>
        .table {
            border-collapse: collapse;
            width: 50%;
            margin: auto;
            margin-bottom: 30px;
            border-color: grey;
        }

        tr,
        th {
            text-align: center;
            border: 1px solid lightgrey;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }

        .table tbody tr:hover {
            background-color: lightgrey;

        }

        .row {
            text-align: center;
            margin: 50px;
        
        }

        .alert-danger {
            background-color: red;
            margin: 5px;
            text-align: center;
            color: white;
            width: 50%;
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
        .btn-info{
            border-radius: 3rem;
            margin-bottom:10px;
            text-decoration: none;
            border: none;
            text-align: center;
            background-color: #0066cc;
            color:white;
            width: 50%;
            display: block; /* Butonu bir blok olarak görüntülemek için */
            margin: 0 auto; /* Yatayda ortalamak için */
            text-align: center; /* Metni yatayda ortalamak için */
            line-height: 2; /* Dikeyde ortalamak için */
           
        }

        .container0 {
            margin-top: 5%;
            border: 1px solid black;
            box-shadow: 0px 0px 41px -4px rgba(0, 0, 0, 0.75);

        }
        .cont{
            margin-top: -5px;
        }

        
    </style>
</head>

<body>
    <div class="container0">
<div class="row">
            <div class="col">
                <h1 class="display-1" style="text-align:center; color:black">Tüm Öğrenciler </h1>
            </div>
        </div>
    <table class="table">
        <thead class="table-dark">
            <th>No</th>
            <th>Ad</th>
            <th>Soyad</th>
            <th>Sınıf</th>
            <th>İşlem</th>

        </thead>
        <tbody>
            <?php
            $s = $db->prepare("SELECT * FROM PHP_Ogrenci");
            $exec = $s->execute();
            $s->fetch(PDO::FETCH_ASSOC);
            foreach ($s as $student) {
                echo "<tr>";
                echo "<td>" .$student['No']  . "</td>";
                echo "<td>" . $student['Ad'] . "</td>";
                echo "<td>" . $student['Soyad'] . "</td>";
                echo "<td>" . $student['Sınıf'] . "</td>";
                echo  "<td><a href='listele.php?no={$student['No']}&delete=ok'><button name='sil' class='btn-sil'>Sil</button></a> <a href='guncelle.php?no={$student['No']}&guncelle=ok'><button name='duzenle' class='btn-d'>Düzenle</button></a></td>";
                echo "</tr>";
            };
            if (isset($_GET['delete'])=='ok') {
                $sorgu=$db->prepare("DELETE FROM PHP_Ogrenci where No=:no");
                $delete=$sorgu->execute(array(
                    'no'=>$_GET['no']
                ));
                if($delete){
                    header("Location:listele.php");
                    exit;
                }
            }


            ?>
        </tbody>
    </table>
    <div class="cont"><a href='index.php'><button name='anasayfa' class='btn-info'>Ana Sayfa</button></a></div><br>
    </div>
</body>

</html>