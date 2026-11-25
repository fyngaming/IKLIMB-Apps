<?php

@mkdir(__DIR__.'/../public/icons', 0777, true);

foreach ([192, 512] as $size) {
    $im = imagecreatetruecolor($size, $size);
    $bg = imagecolorallocate($im, 6, 95, 70); // emerald-800
    $gold = imagecolorallocate($im, 212, 175, 55); // gold accent
    $white = imagecolorallocate($im, 255, 255, 255);
    $innerBg = imagecolorallocate($im, 4, 78, 53); // dark emerald

    imagefilledrectangle($im, 0, 0, $size, $size, $bg);

    // Decorative circle
    imagesetthickness($im, max(2, (int) ($size * 0.02)));
    imagearc($im, (int) ($size / 2), (int) ($size / 2), (int) ($size * 0.86), (int) ($size * 0.86), 0, 360, $gold);
    imagefilledellipse($im, (int) ($size / 2), (int) ($size / 2), (int) ($size * 0.82), (int) ($size * 0.82), $innerBg);

    // Crescent arc or emblem
    imagefilledellipse($im, (int) ($size * 0.5), (int) ($size * 0.38), (int) ($size * 0.28), (int) ($size * 0.28), $gold);
    imagefilledellipse($im, (int) ($size * 0.54), (int) ($size * 0.36), (int) ($size * 0.24), (int) ($size * 0.24), $innerBg);

    $str1 = 'IKLIMB';
    $str2 = 'PPIB';
    imagestring($im, 5, (int) (($size - strlen($str1) * 9) / 2), (int) ($size * 0.58), $str1, $gold);
    imagestring($im, 4, (int) (($size - strlen($str2) * 8) / 2), (int) ($size * 0.70), $str2, $white);

    imagepng($im, __DIR__.'/../public/icons/icon-'.$size.'.png');
    imagedestroy($im);
}

copy(__DIR__.'/../public/icons/icon-192.png', __DIR__.'/../public/favicon.ico');
echo "PWA Icons generated successfully.\n";
