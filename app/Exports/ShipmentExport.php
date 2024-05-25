<?php

namespace App\Exports;

use App\Models\Shipment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ShipmentExport implements FromCollection, ShouldAutoSize, WithHeadings
{
    public $ids;

    public function __construct($ids)
    {
        $this->ids = $ids;

    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Shipment::whereIn('id', $this->ids)->get()->map(function ($sihpment){
            return [
                'id' => $sihpment->id,
                'car_number' => $sihpment->car->car_number,
                'name' => $sihpment->name,
                'value' => $sihpment->value,
                'date' => $sihpment->date,
                'user' => $sihpment->user ? $sihpment->user->name : "",
                'addition' => $sihpment->addition
            ];
        });
    }

    public function headings(): array
    {
        return [
            '#',
            __("admin.car_number"),
            __('admin.name'),
            __('admin.value'),
            __('main.date'),
            __('main.added_by'),
            __('admin.addition')
        ];
    }
}
