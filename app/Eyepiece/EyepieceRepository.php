<?php namespace EPP\Eyepiece;

class EyepieceRepository
{
    public function __construct(Eyepiece $model)
    {
        $this->model = $model;
    }

    public function getJSONList()
    {
        $eyepieces = $this->model->with(['productLine', 'manufacturer'])
            ->join('product_lines', 'product_lines.id', '=', 'eyepieces.product_line_id')
            ->join('manufacturers', 'manufacturers.id', '=', 'eyepieces.manufacturer_id')
            ->select([
                'eyepieces.id',
                'eyepieces.apparent_field',
                'eyepieces.focal_length',
                'eyepieces.eye_relief',
                'eyepieces.field_stop',
                'eyepieces.barrel_size',
                'manufacturers.name as manufacturer_name',
                'product_lines.name as product_name'
            ])
            ->orderBy('manufacturers.name', 'ASC')
            ->orderBy('product_lines.name', 'ASC')
            ->orderBy('eyepieces.focal_length', 'ASC')
            ->get()
            ->toJson();

        return str_replace('")', '&quot;)', $eyepieces);
    }
}