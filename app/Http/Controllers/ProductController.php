<?php

namespace App\Http\Controllers;

use App\Exports\ProductsExport;
use App\Models\Depreciation;
use App\Models\Product;
use Illuminate\Http\Client\Request as ClientRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat\DateFormatter;

class ProductController extends Controller
{
    public function create(Request $request)
    {
        // $validation = Validator::make($request->all());

        // if ($validation->fails()) {
        //     return response()->json(['invalid' => $validation->errors()]);
        // }

        $product = new Product();
        $product->SNo = $request->SNo;
        $product->name = $request->name;
        $product->category = $request->category;
        $product->description = $request->description;

        $product->status = $request->selected;
        if ($request->selected === 'InActive') {
            $product->inactive_date = date('Y-m-d');
        }
        // $product->dateofpurchase = date('Y-m-d', $request->dateofpurchase);
        // $product->dateofpurchase = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($request->dateofpurchase)->format('Y-m-d');
        $product->dateofpurchase = $request->dateofpurchase;
        $product->assigned = $request->assigned;
        $product->condition = $request->condition;
        $product->cost = $request->cost;
        $product->disposal_cost = $request->dcost;
        $product->book_value = $request->bvalue;
        $product->deptrate = $request->deptrate;
        $product->depreciation = $request->depreciation;
        $product->accumulated_dept = $request->accumulated_dept;
        $product->NBV = $request->NBV;
        $product->save();


        foreach ($request->inputs as $key => $value) {
            Depreciation::create([
                'product_id' => $product->id,
                'name' => $value['depreciationname'],
                'cost' => $value['depreciationcost'],
            ]);
        }

        return response()->json([
            'data' => $product,
            'message' => 'Product Created Successfully'
        ]);
        // return response()->json($request->inputs);
    }

    public function index(Request $request)
    {
        $query = $request->input('q');
        if (!empty($query)) {
            $products = Product::where('SNo', 'LIKE', "%" . $query . "%")
                ->orWhere('name', 'LIKE', "%" . $query . "%")
                ->orWhere('category', 'LIKE', "%" . $query . "%")
                ->orWhere('status', 'LIKE', "%" . $query . "%")
                ->orWhere('dateofpurchase', 'LIKE', "%" . $query . "%")
                ->orWhere('assigned', 'LIKE', "%" . $query . "%")
                ->orWhere('condition', 'LIKE', "%" . $query . "%")->paginate(5);
        } else {
            $products = Product::paginate(5);
        }
        return response()->json($products);
    }

    public function view($id)
    {
        $product = Product::where('SNo', $id)->first();
        $dep = Depreciation::where('product_id', $product->id)->get();
        return response()->json([$product, $dep]);
    }

    public function update(Request $request, $id)
    {
        // $validation = Validator::make($request->all());

        // if ($validation->fails()) {
        //     return response()->json(['invalid' => $validation->errors()]);
        // }

        $product = Product::where('SNo', $id)->first();
        $product->name = $request[0]['name'];
        $product->category = $request[0]['category'];
        $product->description = $request[0]['description'];
        $product->status = $request[0]['status'];
        if ($request[0]['status'] === 'InActive') {
            $product->inactive_date = date('Y-m-d');
        }
        $product->dateofpurchase = $request[0]['dateofpurchase'];
        $product->assigned = $request[0]['assigned'];
        $product->condition = $request[0]['condition'];
        $product->cost = $request[0]['cost'];
        $product->disposal_cost = $request[0]['disposal_cost'];
        $product->book_value = $request[0]['book_value'];
        $product->deptrate = $request[0]['deptrate'];
        $product->depreciation = $request[0]['depreciation'];
        $product->accumulated_dept = $request[0]['accumulated_dept'];
        $product->NBV = $request[0]['NBV'];
        $product->save();

        $dept = Depreciation::where('product_id', '=', $product->id)->get();

        for ($i = 0; $i < count($request[1]); $i++) {
            $dept[$i]['name'] = $request[1][$i]['name'];
            $dept[$i]['cost'] = $request[1][$i]['cost'];
            $dept[$i]->save();
        }

        return response()->json('Product Updated Successfully');
    }

    public function delete($id)
    {
        $product = Product::where('SNo', $id)->first();
        if ($product->status == 'Active') {
            $product->status = 'InActive';
            $product->inactive_date = date('Y-m-d');
        } else {
            $product->status = 'Active';
        }
        $product->save();
        return response()->json([
            'data' => $product,
            'message' => 'Product Status Updated Successfully'
        ]);
    }

    public function allproduct(Request $request)
    {
        $allproducts = Product::all();
        return response()->json($allproducts->count());
    }

    public function getAllColumn(Request $request)
    {
        $products = new Product();

        $exclude_columns = ['id', 'status', 'inactive_date', 'created_at', 'updated_at'];

        $table = $products->getTable();
        $columns = Schema::getColumnListing($table);
        $columns = array_diff($columns, $exclude_columns);

        return $columns;
    }

    public function exceldata(Request $request)
    {
        Product::truncate();

        $dept = Depreciation::all();

        if (!empty($dept)) {
            Depreciation::truncate();
        }

        $allkeys = array_keys($request["0"]);
        $allvalues = array_values($request["0"]);

        $completedata = [];
        $onlydepreciationdata = array();


        for ($i = 0; $i < count($allkeys); $i++) {
            foreach ($request["1"] as $key => $value) {

                if ($allvalues[$i] === "depreciation") {
                    $onlydepreciationdata[$allkeys[$i]][] = $value[$allkeys[$i]] ? $value[$allkeys[$i]] : "NULL";
                } else {
                    $completedata[$allvalues[$i]][] = $value[$allkeys[$i]];
                }
            }
        }

        for ($i = 0; $i < count($request["1"]); $i++) {
            Product::insertOrIgnore([
                "SNo" => $completedata["SNo"][$i],
                "name" => isset($completedata["name"]) ? $completedata["name"][$i] : "",
                "category" => isset($completedata["category"]) ? $completedata["category"][$i] : "",
                "description" => isset($completedata["description"]) ? $completedata["description"][$i] : "",
                "cost" => isset($completedata["cost"]) ? $completedata["cost"][$i] : "",
                "NBV" => isset($completedata["NBV"]) ? $completedata["NBV"][$i] : "",
                // "dateofpurchase" => isset($completedata["dateofpurchase"]) ? DateFormatter::format($completedata["dateofpurchase"][$i], 'Y-m-d') : "0000-00-00",
                "dateofpurchase" => isset($completedata["dateofpurchase"]) ? \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($completedata["dateofpurchase"][$i])->format('Y-m-d') : null,
                "disposal_cost" => isset($completedata["disposal_cost"]) ? $completedata["disposal_cost"][$i] : "",
                "deptrate" => isset($completedata["deptrate"]) ? $completedata["deptrate"][$i] : "",
                "disposal_depreciation" => isset($completedata["disposal_depreciation"]) ? $completedata["disposal_depreciation"][$i] : "",
                "accumulated_dept" => isset($completedata["accumulated_dept"]) ? $completedata["accumulated_dept"][$i] : "",
                "book_value" => isset($completedata["book_value"]) ? $completedata["book_value"][$i] : "",
                "assigned" => isset($completedata["assigned"]) ? $completedata["assigned"][$i] : "",
                "condition" => isset($completedata["condition"]) ? $completedata["condition"][$i] : "",
                "status" => "Active",
            ]);
            $product = Product::where('SNo', $completedata["SNo"][$i])->first();

            foreach ($onlydepreciationdata as $key => $value) {
                Depreciation::insertOrIgnore([
                    'product_id' => $product->id,
                    'name' => $key,
                    'cost' => $onlydepreciationdata[$key][$i],
                ]);
            }
        }
    }

    public function exportdata(Request $request)
    {
        return Excel::download(new ProductsExport, 'ExportFile.xlsx');
    }

    public function search($id)
    {
        // $product = Product::where('SNo', '=', $id)->first();
        $product = Product::where('SNo', '=', $id)->first();
        if ($product) {
            $dep = Depreciation::where('product_id', $product->id)->get();
        }

        if ($product && $dep) {
            return response()->json(['message' => [$product, $dep]]);
        } else {
            return response()->json(['message' => 'error']);
        }
    }

    public function locationupd($id, Request $request)
    {
        $product = Product::where('SNo', '=', $id)->first();
        $product->assigned = str_replace("_", " ", key($request->all()));;

        $product->save();

        return response()->json(['message' => 'Location Updated Successfully']);
    }
}