<?php

// Cuma override key yang perlu diubah - key lain otomatis diisi dari default
// package-nya sendiri (Laravel gabungkan lewat mergeConfigFrom).

return [
    // Default Spatie MediaLibrary cuma 10MB - dinaikkan supaya video (maks 50MB
    // menurut validasi kita di PenawaranController/PermintaanController) tidak
    // ditolak duluan oleh package ini sebelum sempat masuk ke validasi Laravel.
    'max_file_size' => 1024 * 1024 * 60, // 60 MB (kasih sedikit buffer di atas 50MB)
];
