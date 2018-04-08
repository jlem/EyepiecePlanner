<?php namespace EPP\Domain\Model\Eyepiece;

class EyepieceRepository
{
    public function __construct(Eyepiece $model)
    {
        $this->model = $model;
    }

    public function getAllAlt()
    {
        return $this->model->with(['productLine', 'manufacturer'])
            ->select(['eyepieces.*'])
            ->join('product_lines', 'product_lines.id', '=', 'eyepieces.product_line_id')
            ->join('manufacturers', 'manufacturers.id', '=', 'eyepieces.manufacturer_id')
            ->orderBy('manufacturers.name', 'ASC')
            ->orderBy('product_lines.name', 'ASC')
            ->orderBy('eyepieces.focal_length', 'ASC')
            ->get();
    }

    public function getAll()
    {
        return $this->model->with(['productLine', 'manufacturer'])
            ->join('product_lines', 'product_lines.id', '=', 'eyepieces.product_line_id')
            ->join('manufacturers', 'manufacturers.id', '=', 'eyepieces.manufacturer_id')
            ->select([
                'eyepieces.id',
                'eyepieces.apparent_field',
                'eyepieces.focal_length',
                'eyepieces.eye_relief',
                'eyepieces.field_stop',
                'eyepieces.price',
                'eyepieces.region',
                'eyepieces.barrel_size',
                'eyepieces.is_discontinued',
                'manufacturers.name as manufacturer_name',
                'product_lines.name as product_name'
            ])
            ->orderBy('manufacturers.name', 'ASC')
            ->orderBy('product_lines.name', 'ASC')
            ->orderBy('eyepieces.focal_length', 'ASC')
            ->get()
            ->map(function($eyepiece) {
                $eyepiece->is_discontinued = (boolean)$eyepiece->is_discontinued;
                return $eyepiece;
            });
    }

    public function getJSONList()
    {
        return str_replace('")', '&quot;)', $this->getAll()->toJson());
    }
}