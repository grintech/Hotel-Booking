<?php
namespace Modules\Template\Blocks;
class Image extends BaseBlock
{
    public function __construct()
    {
        $this->setOptions([
            'settings' => [
               [
                   'id'    => 'bav',
                   'type'  => 'uploader',
                   'label' => __('Image Uploader')
               ],
            ]
        ]);
    }

    public function getName()
    {
        return __('Image');
    }

    public function content($model = [])
    {
        return view('Template::frontend.blocks.image', $model);
    }
}