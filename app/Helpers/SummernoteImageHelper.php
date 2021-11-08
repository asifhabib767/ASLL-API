<?php

namespace App\Helpers;


class SummernoteImageHelper
{
    public static function summernoteImageUpload($details)
    {
        $dom = new \DOMDocument();
        $dom->preserveWhiteSpace = false;
        $dom->loadHtml($details, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD | LIBXML_NOERROR | LIBXML_NOWARNING);
        $images = $dom->getelementsbytagname('img');

        //loop over img elements, decode their base64 src and save them to public folder,
        //and then replace base64 src with stored image URL.
        foreach ($images as $k => $img) {
            $data = $img->getattribute('src');

            list($type, $data) = explode(';', $data);
            list(, $data)      = explode(',', $data);

            $data = base64_decode($data);
            $image_name = time() . $k . '.png';
            $path = public_path() . '/images/posts/' . $image_name;
            file_put_contents($path, $data);
            $img->removeattribute('src');
            $img->setattribute('src', $image_name);
        }
        return $dom;
    }
}
