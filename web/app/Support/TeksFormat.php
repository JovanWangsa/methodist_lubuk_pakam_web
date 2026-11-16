<?php

namespace App\Support;

use Illuminate\Support\HtmlString;

class TeksFormat
{
    /**
     * Mengubah penanda sederhana di teks konten menjadi HTML yang aman:
     * **tebal** menjadi <strong>, *miring* menjadi <em>. Teks lain di-escape.
     */
    public static function inline(?string $teks): HtmlString
    {
        $aman = e($teks ?? '');
        $aman = preg_replace('/\*\*(.+?)\*\*/s', '<strong>$1</strong>', $aman);
        $aman = preg_replace('/\*(.+?)\*/s', '<em>$1</em>', $aman);

        return new HtmlString($aman);
    }
}
