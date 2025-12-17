<?php
session_start();
require_once __DIR__ . '/fungsi.php';
require_once __DIR__ . '/koneksi.php';

if (isset($_POST["txtNim"])) {
    $arrBiodata = [
        "nim" => $_POST["txtNim"] ?? "",
        "nama" => $_POST["txtNmLengkap"] ?? "",
        "tempat" => $_POST["txtT4Lhr"] ?? "",
        "tanggal" => $_POST["txtTglLhr"] ?? "",
        "hobi" => $_POST["txtHobi"] ?? "",
        "pasangan" => $_POST["txtPasangan"] ?? "",
        "pekerjaan" => $_POST["txtKerja"] ?? "",
        "ortu" => $_POST["txtNmOrtu"] ?? "",
        "kakak" => $_POST["txtNmKakak"] ?? "",
        "adik" => $_POST["txtNmAdik"] ?? ""
    ];
    $_SESSION["biodata"] = $arrBiodata;
    redirect_ke('index.php#about');
}

elseif (isset($_POST["check_access"])) {
    $jawaban_user = bersihkan($_POST['initialCaptcha'] ?? '');
    
    $num1_session = $_SESSION['captcha_num1'] ?? 0;
    $num2_session = $_SESSION['captcha_num2'] ?? 0;
    $jawaban_benar = $num1_session + $num2_session;

    if ($jawaban_user == $jawaban_benar) {
        $_SESSION['verified'] = true;
        unset($_SESSION['captcha_num1'], $_SESSION['captcha_num2']); 
    } else {
        $_SESSION['verified'] = false;
        $_SESSION['captcha_error'] = 'Jawaban verifikasi salah. Silakan coba lagi.';
        unset($_SESSION['captcha_num1'], $_SESSION['captcha_num2']); 
    }
    redirect_ke('index.php'); 
}

elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!($_SESSION['verified'] ?? false)) {
        redirect_ke('index.php'); 
    }
    
    if (isset($_POST["txtNama"])) {
        $nama  = bersihkan($_POST['txtNama'] ?? '');
        $email = bersihkan($_POST['txtEmail'] ?? '');
        $pesan = bersihkan($_POST['txtPesan'] ?? '');

        $errors = [];

        if ($nama === '') {
            $errors[] = 'Nama wajib diisi.';
        } elseif (strlen($nama) < 3) {
            $errors[] = 'Nama minimal 3 karakter.';
        }

        if ($email === '') {
            $errors[] = 'Email wajib diisi.';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Format e-mail tidak valid.';
        }

        if ($pesan === '') {
            $errors[] = 'Pesan wajib diisi.';
        } elseif (strlen($pesan) < 10) {
            $errors[] = 'Pesan minimal 10 karakter.';
        }
        
        if (!empty($errors)) {
            $_SESSION['old'] = [
                'cnama' => $nama,
                'cemail' => $email,
                'cpesan' => $pesan,
            ];
            
            $_SESSION['flash_error'] = implode('<br>', $errors);
            redirect_ke('index.php#contact');
        }

        $sql = "INSERT INTO tbl_tamu (cnama, cemail, cpesan) VALUES (?, ?, ?)";
        
        if ($stmt = mysqli_prepare($conn, $sql)) {
            
            mysqli_stmt_bind_param($stmt, "sss", $nama, $email, $pesan);
            
            if (mysqli_stmt_execute($stmt)) {
                $_SESSION['flash_sukses'] = 'Pesan Anda berhasil dikirim!';
            } else {
                $_SESSION['flash_error'] = 'Gagal menyimpan pesan ke database: ' . mysqli_error($conn);
            }
            
            mysqli_stmt_close($stmt);
        } else {
            $_SESSION['flash_error'] = 'Gagal menyiapkan query: ' . mysqli_error($conn);
        }
        
        redirect_ke('index.php#contact');
    }
}

redirect_ke('index.php');
?>