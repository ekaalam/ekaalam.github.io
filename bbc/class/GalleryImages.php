<?php
final class GalleryImages extends Database
{
    use DataTraits;
    public function __construct()
    {
        parent::__construct();
        $this->table = "gallery_images";
    }
    public function getAllGalleryImages($id)
    {
        $args = array(
            'where' => array(
                'gallery_id' => $id
            )
        );
        return $this->select($args);
    }
    public function deleteImageByName($image_name)
    {
        $args = array(
            'where' => array(
                'image' => $image_name
            )
        );
        return $this->delete($args);
    }
}
