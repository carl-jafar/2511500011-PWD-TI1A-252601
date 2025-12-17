<?php
    session_start();
    require __DIR__ . './koneksi.php';
    require_once __DIR__ . '/fungsi.php';

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        $_SESSION['flash_error'] = 'Akses tidak valid.';
        redirect_ke('read.php');
    }

    $cid = filter_input(INPUT_POST, 'cid', FILTER_VALIDATE_INT,[
        'options' => ['min_range' => 1]
    ]);

    if(!$cid) {
        $_SESSION['flash_error'] = 'CID Tidak Valid.';
        redirect_ke('edit.php?cid='. (int)$cid);
    }

    $nama = berishkan($_POST['txtNamaEd'] ?? '');
    $email = bersihkan($_POST['txtEmailEd'] ?? '');
    $pesan = bersihkan($_POST['txtPesanEd'] ?? '');
    $captcha = bersihkan($_POST['txtCaptcha'] ?? '');

    $errors = []; #array untuk menampung semua error yang ada

    if ($nama === '') {
        $errors[] = 'Nama wajib diisi.';
    }

    if ($email === '') {
        $errors[] = 'EMAIL wajib diisi.';
    }

    if ($pesan === '') {
        $errors[] = 'Pesan wajib diisi.';
    }

    if ($captcha === '') {
        $errors[] = 'Pertanyaan wajib diisi.';
    }

    if (mb_strlen($nama) < 3) {
        $errors[] = 'Nama minimal 3 karakter.';
    }

    if (mb_strlen($pesan) < 10) {
        $errors[] = 'Pesan minimal 10 karakter.';
    }

    if ($captcha!=="6") {
        $errors[] = 'jawaban' . $captcha . 'captcha salah.';
    }

    