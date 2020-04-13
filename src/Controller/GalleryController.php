<?php

class GalleryController extends Controller
{
    static public function view(array $pathFragments)
    {
        require_once __DIR__ . '/../../templates/gallery.php';
    }
}
