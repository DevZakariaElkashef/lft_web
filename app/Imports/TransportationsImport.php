<?php

namespace App\Imports;

use App\Models\Company;
use App\Models\CompanyTransportation;
use App\Models\Container;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class TransportationsImport implements ToCollection, WithHeadingRow, WithValidation
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        foreach ($collection as $key => $row) {
            $containers = Container::where('type', 'LIKE', '%'. $row['container'] .'%')->first();
            $company    = (isset(request()->company_id) && !is_null(request()->company_id)) ? Company::find(request()->company_id) : Company::where('name', 'LIKE', '%'.$row['company'].'%')->first();
            $data       = [
                'container_id'  => $containers?->id,
                'container_data'=> $container ?? '',
                'company_id'    => $company?->id,
                'company_data'  => $company ?? '',
                'departure'     => $row['departure'] ?? '',
                'loading'       => $row['loading'] ?? '',
                'aging'         => $row['aging'] ?? '',
                'price'         => $row['price'] ?? '',
            ];

            CompanyTransportation::create($data);
        }
    }

    public function chunkSize(): int
    {
        return 1000;
    }


    /**
    * @return array
    */
    public function rules(): array
    {
        return [
            'company'   => (isset(request()->company_id) && !is_null(request()->company_id)) ? ['sometimes', 'nullable'] : ['required', 'string', 'max:255'],
            'container' => ['required', 'string', 'max:255'],
            'departure' => ['required', 'string', 'max:255'],
            'loading'   => ['required', 'string', 'max:255'],
            'aging'     => ['required', 'string', 'max:255'],
            'price'     => ['required', 'numeric'],
        ];

    }

    /**
     * @return array
    */
    //public function customValidationAttributes()
    //{
    //    return ['1' => 'email'];
    //}
}
