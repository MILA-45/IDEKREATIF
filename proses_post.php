<?php
include 'config.php';
//Memulai sesi php
session_start();

//Mendapatkan ID pengguna dari sesi
$userId = $_SESSION["user_id"];

//Mendapatkan ID pengguna dari sesi
if (isset($_POST['simpan'])){
//Mendapatkan form untuk menambahkan postingan baru
    $postTitle = $_POST["post_title"]; //judul postingan
    $content = $_POST["content"]; //konten postingan
    $categoryId = $_POST["category_id"]; //id kategori

    //Mengatur direktori penyimpanan file gambar
    $imageDir = "assets/img/uploads/";
    $imageName = $_FILES["image"]["name"]; //nama file gambar
    $imagePath = $imageDir . basename($imageName); //path lengkap gambar

    //Memindahkan file gambar yang di unggah ke direktori tujuan
    if (move_uploaded_file($_FILES["image"]["tmp_name"], $imagePath)){
      
        $query = "INSERT INTO posts (post_title, content, created_at, category_id, user_id, image_path) VALUES ('$postTitle', '$content', NOW(), $categoryId, $userId, '$imagePath')";

        if ($conn->query($query)===TRUE){

            $_SESSION['notification']=[
                'type' => 'primary',
                'message' =>'Post successfully added.'
            ];
        }else{

            $_SESSION['notificaton']=[
                'type' =>'danger',
                'message' =>'Error adding post'. $conn->error
            ];
        }
    }else{

        $_SESSION['notificaton']=[
            'type'=>'danger',
            'message'=>'Failed to upload image.'
        ];
        }
        header('Location: kategori.php');
        exit();
    }
?>