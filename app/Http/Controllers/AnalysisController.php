<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Depreciation;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

use function PHPSTORM_META\map;

class AnalysisController extends Controller
{
    public function fetchData(Request $request)
    {
        // if ($request->get('conditionselect') === "COUNT") {
        //     $products = Product::where($request[1], 'LIKE', '%' . $request->get('categoryselect') . '%')
        //         ->count($request[1]);
        // } else if ($request->get('conditionselect') === "SUM") {
        //     $products = Product::where($request[1], 'LIKE', '%' . $request->get('categoryselect') . '%')
        //         ->sum("cost");
        // }
        if ($request[1] === 'depreciation') {
            $productscondition1 = Depreciation::where('name', "LIKE", '%' . $request[0]['categoryselect'] . '%')->count('name');
            $productscondition2 = Depreciation::where('name', 'LIKE', '%' . $request[0]['categoryselect'] . '%')->sum('cost');
        } else {
            $productscondition1 = Product::where($request[1], "=", $request[0]['categoryselect'])->count($request[1]);
            $productscondition2 = Product::where($request[1], "=", $request[0]['categoryselect'])->sum('cost');
        }
        return response()->json($request[0]['conditionselect'] === "sum" ? $productscondition2 : $productscondition1);

        // $productscondition1 = Depreciation::where('name', 'LIKE', '%Depreciation 2014-15%')->sum('cost');
        // return response()->json($productscondition1);
    }

    public function fetchOption(Request $request)
    {
        $Categorylist = $request->get('option') === "depreciation" ?
            Depreciation::select("name AS " . $request->get('option'))->distinct()->get() :
            Product::select($request->get('option'))->distinct()->get();


        return response()->json($Categorylist);
    }

    public function chartslist()
    {
        $chartlabellist = Product::orderBy('name', 'ASC')->get('name');
        return response()->json($chartlabellist);
    }

    public function chartscostlist()
    {
        $chartcostlist = Product::get('cost')->toArray();
        return response()->json($chartcostlist);
    }
}