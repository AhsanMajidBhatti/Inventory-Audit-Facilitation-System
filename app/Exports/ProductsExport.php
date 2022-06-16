<?php

namespace App\Exports;

use App\Models\Depreciation;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProductsExport implements FromCollection, WithHeadings
{
    use Exportable;
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $dept = Depreciation::select(DB::raw("ARRAY_AGG(cost) as costing")->orderBy('id')->groupBy('product_id'))->get()
            ->map(function ($attendances) {
                $costs = explode(',', $attendances->costing);
                return $costs;
            });
        
//         $dept = Depreciation::get('name');
        $product = Product::all();
        $product->makeHidden(['id', 'status', 'depreciation', 'inactive_date', 'created_at', 'updated_at']);
        $result = new Collection();
        foreach ($product as $key => $value) {
            if (!empty($dept->toArray())) {
                $result[$key] = array_merge($value->toArray(), $dept[$key]);
            } else {
                $result[$key] = $value->toArray();
            }
        }
        return $result;
    }

    public function headings(): array
    {
        // $dept = Depreciation::select(DB::raw("GROUP_CONCAT(name) as naming"))->groupBy('product_id')->distinct()->get()
        //     ->map(function ($attendances) {
        //         $names = explode(',', $attendances->naming);
        //         return $names;
        //     });
        $dept = Depreciation::distinct()->get('name');
        $temp = array();
        foreach ($dept as $key => $value) {
            array_push($temp, $value->{"name"});
        }
        $products = ['SNo', 'name', 'category', 'description', 'dateofpurchase', 'cost', 'disposal_cost', 'assigned', 'condition', 'book_value', 'deptrate', 'NBV', 'disposal_depreciation', 'accumulated_dept'];

        if (!empty($dept->toArray())) {

            return array_merge($products, (array)$temp);
        } else {
            return $products;
        }
    }
}
