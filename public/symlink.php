<?php
$targetFolder = __DIR__.'/../storage/app/public';
$linkFolder = __DIR__.'/storage';

if(file_exists($linkFolder)) {
    echo "Symlink sudah ada atau folder storage sudah ada di public.";
} else {
    try {
        symlink($targetFolder, $linkFolder);
        echo "Symlink berhasil dibuat! Silakan hapus file symlink.php ini demi keamanan.";
    } catch (Exception $e) {
        echo "Gagal membuat symlink: " . $e->getMessage();
    }
}
