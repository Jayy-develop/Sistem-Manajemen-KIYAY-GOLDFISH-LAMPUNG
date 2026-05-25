<?php
require 'function/koneksi.php';

// Create image folder if not exists
$img_folder = __DIR__ . '/assets/img/ikan/';
if (!is_dir($img_folder)) {
    mkdir($img_folder, 0755, true);
}

// Sample data jenis ikan
$jenis = [
    'Oranda',
    'Ryukin', 
    'Ranchu',
    'Mata Balon',
    'Black Moor',
    'Fantail',
    'Lionhead',
    'Telescope'
];

// Insert jenis ikan
foreach ($jenis as $j) {
    $check = query("SELECT * FROM jenisIkan WHERE jenisIkan = '$j'");
    if (empty($check)) {
        query("INSERT INTO jenisIkan (jenisIkan) VALUES ('$j')");
        echo "✅ Jenis: $j<br>";
    }
}

echo "<br><strong>Menambahkan Data Ikan...</strong><br>";

// Sample ikan data
$ikan_data = [
    // Oranda
    ['jenis' => 'Oranda', 'ukuran' => '10 cm', 'gender' => 'Male', 'stok' => 5, 'harga' => 150000, 'deskripsi' => 'Oranda merah sehat berkualitas'],
    ['jenis' => 'Oranda', 'ukuran' => '12 cm', 'gender' => 'Female', 'stok' => 7, 'harga' => 180000, 'deskripsi' => 'Oranda premium kontes'],
    ['jenis' => 'Oranda', 'ukuran' => '14 cm', 'gender' => 'Male', 'stok' => 3, 'harga' => 220000, 'deskripsi' => 'Oranda jumbo impor Jepang'],
    
    // Ryukin
    ['jenis' => 'Ryukin', 'ukuran' => '9 cm', 'gender' => 'Male', 'stok' => 9, 'harga' => 120000, 'deskripsi' => 'Ryukin bungkuk berkualitas'],
    ['jenis' => 'Ryukin', 'ukuran' => '11 cm', 'gender' => 'Female', 'stok' => 8, 'harga' => 140000, 'deskripsi' => 'Ryukin merah putih premium'],
    ['jenis' => 'Ryukin', 'ukuran' => '13 cm', 'gender' => 'Male', 'stok' => 4, 'harga' => 180000, 'deskripsi' => 'Ryukin jumbo kontes'],
    
    // Ranchu
    ['jenis' => 'Ranchu', 'ukuran' => '8 cm', 'gender' => 'Male', 'stok' => 12, 'harga' => 100000, 'deskripsi' => 'Ranchu ekor pendek sehat'],
    ['jenis' => 'Ranchu', 'ukuran' => '10 cm', 'gender' => 'Female', 'stok' => 10, 'harga' => 130000, 'deskripsi' => 'Ranchu impor berkualitas tinggi'],
    ['jenis' => 'Ranchu', 'ukuran' => '12 cm', 'gender' => 'Male', 'stok' => 6, 'harga' => 170000, 'deskripsi' => 'Ranchu jumbo premium'],
    
    // Mata Balon
    ['jenis' => 'Mata Balon', 'ukuran' => '7 cm', 'gender' => 'Male', 'stok' => 12, 'harga' => 90000, 'deskripsi' => 'Mata balon kuning cerah'],
    ['jenis' => 'Mata Balon', 'ukuran' => '8 cm', 'gender' => 'Female', 'stok' => 13, 'harga' => 110000, 'deskripsi' => 'Mata balon premium kontras'],
    ['jenis' => 'Mata Balon', 'ukuran' => '10 cm', 'gender' => 'Male', 'stok' => 8, 'harga' => 150000, 'deskripsi' => 'Mata balon jumbo impor'],
    
    // Black Moor
    ['jenis' => 'Black Moor', 'ukuran' => '9 cm', 'gender' => 'Male', 'stok' => 9, 'harga' => 125000, 'deskripsi' => 'Black Moor hitam pekat sehat'],
    ['jenis' => 'Black Moor', 'ukuran' => '11 cm', 'gender' => 'Female', 'stok' => 8, 'harga' => 150000, 'deskripsi' => 'Black Moor kontes kualitas'],
    ['jenis' => 'Black Moor', 'ukuran' => '13 cm', 'gender' => 'Male', 'stok' => 5, 'harga' => 190000, 'deskripsi' => 'Black Moor jumbo premium'],
    
    // Fantail
    ['jenis' => 'Fantail', 'ukuran' => '8 cm', 'gender' => 'Male', 'stok' => 10, 'harga' => 110000, 'deskripsi' => 'Fantail ekor lebar indah'],
    ['jenis' => 'Fantail', 'ukuran' => '10 cm', 'gender' => 'Female', 'stok' => 7, 'harga' => 140000, 'deskripsi' => 'Fantail premium multi warna'],
    
    // Lionhead
    ['jenis' => 'Lionhead', 'ukuran' => '8 cm', 'gender' => 'Male', 'stok' => 6, 'harga' => 130000, 'deskripsi' => 'Lionhead kepala besar indah'],
    ['jenis' => 'Lionhead', 'ukuran' => '10 cm', 'gender' => 'Female', 'stok' => 5, 'harga' => 160000, 'deskripsi' => 'Lionhead premium impor'],
    
    // Telescope
    ['jenis' => 'Telescope', 'ukuran' => '7 cm', 'gender' => 'Male', 'stok' => 11, 'harga' => 95000, 'deskripsi' => 'Telescope mata menonjol unik'],
    ['jenis' => 'Telescope', 'ukuran' => '9 cm', 'gender' => 'Female', 'stok' => 9, 'harga' => 125000, 'deskripsi' => 'Telescope premium kontras'],
];

// Function to generate placeholder image
function generatePlaceholderImage($filename, $text, $color) {
    $width = 300;
    $height = 300;
    
    $image = imagecreatetruecolor($width, $height);
    
    // RGB colors for different types
    $colors = [
        'red' => imagecolorallocate($image, 220, 50, 50),
        'orange' => imagecolorallocate($image, 255, 140, 0),
        'yellow' => imagecolorallocate($image, 255, 215, 0),
        'black' => imagecolorallocate($image, 30, 30, 30),
        'silver' => imagecolorallocate($image, 192, 192, 192),
        'white' => imagecolorallocate($image, 255, 255, 255),
    ];
    
    $bg_color = isset($colors[$color]) ? $colors[$color] : imagecolorallocate($image, 100, 150, 200);
    $text_color = imagecolorallocate($image, 255, 255, 255);
    
    imagefilledrectangle($image, 0, 0, $width, $height, $bg_color);
    
    // Add text
    $font = 5; // Built-in font
    $textWidth = strlen($text) * imagefontwidth($font);
    $x = ($width - $textWidth) / 2;
    $y = ($height - imagefontheight($font)) / 2;
    
    imagestring($image, $font, $x, $y, $text, $text_color);
    
    imagepng($image, $filename);
    imagedestroy($image);
}

// Color map for jenis
$color_map = [
    'Oranda' => 'red',
    'Ryukin' => 'orange',
    'Ranchu' => 'yellow',
    'Mata Balon' => 'silver',
    'Black Moor' => 'black',
    'Fantail' => 'white',
    'Lionhead' => 'orange',
    'Telescope' => 'yellow',
];

// Get jenis_id mapping
$jenis_map = [];
$jenis_result = query("SELECT idJenisIkan, jenisIkan FROM jenisIkan");
foreach ($jenis_result as $j) {
    $jenis_map[$j['jenisIkan']] = $j['idJenisIkan'];
}

// Insert ikan with placeholder images
$count = 0;
foreach ($ikan_data as $ikan) {
    $jenis_name = $ikan['jenis'];
    $idJenisIkan = $jenis_map[$jenis_name];
    
    // Generate image filename
    $img_name = strtolower(str_replace(' ', '_', $jenis_name)) . '_' . ($count + 1) . '.png';
    $img_path = $img_folder . $img_name;
    
    // Generate placeholder image
    $color = $color_map[$jenis_name] ?? 'white';
    generatePlaceholderImage($img_path, $jenis_name . ' ' . $ikan['ukuran'], $color);
    
    // Insert to database
    $sql = "INSERT INTO ikan (idJenisIkan, ukuran, gender, stokIkan, harga, deskripsi, gambarIkan)
            VALUES ({$idJenisIkan}, '{$ikan['ukuran']}', '{$ikan['gender']}', {$ikan['stok']}, {$ikan['harga']}, '{$ikan['deskripsi']}', '$img_name')";
    
    query($sql);
    $count++;
    
    echo "✅ {$jenis_name} ({$ikan['ukuran']}) - Rp " . number_format($ikan['harga'], 0, ',', '.') . " - Stock: {$ikan['stok']}<br>";
}

echo "<br><strong style='color:green; font-size:18px;'>✅ Total $count Data Ikan Berhasil Ditambahkan!</strong><br>";
echo "<br><a href='landing/' style='padding:10px 20px; background:#007bff; color:white; text-decoration:none; border-radius:5px;'>Lihat Produk</a>";
?>
