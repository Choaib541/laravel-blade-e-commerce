<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $sales_count = Sale::count();
        $income = Sale::sum("price");
        $users_count = User::count();
        $products_count = Product::count();
        $sales_per_month = $this->chart_ready(DB::select("SELECT count(id) as data, MONTH(created_at) AS month FROM sales GROUP BY MONTH(created_at) ORDER BY(month)"));
        $users_per_month = $this->chart_ready(DB::select("SELECT count(id) as data, MONTH(created_at) AS month FROM users GROUP BY MONTH(created_at) ORDER BY(month)"));
        $latest_orders = Sale::with(["user:id,name", "product:id,title"])->orderBy("id", "desc")->take(8)->get();

        return view("dashboard.index", [
            "sales_count" => $sales_count,
            "income" => $income,
            "users_count" => $users_count,
            "products_count" => $products_count,
            "sales_per_month" => $this->chart_ready($sales_per_month),
            "users_per_month" => $this->chart_ready($users_per_month),
            "latest_orders" => $latest_orders
        ]);
    }

    function chart_ready($sales_per_month)
    {
        $result = [];

        $sales = json_decode(json_encode($sales_per_month), true);

        for ($i = 1; $i < 13; $i++) {
            $does_not_exists = true;
            $current_sale = null;

            foreach ($sales as $sale) {
                if ($sale["month"] === $i) {
                    $does_not_exists = false;
                    $current_sale = $sale;
                    break;
                }
            }

            if ($does_not_exists) {
                $result[] = [
                    "month" => $i,
                    "data" => 0
                ];
            } else {
                $result[] = ["month" => $current_sale["month"], "data" => $current_sale["data"]];
            }
        }
        return $result;
    }
}
