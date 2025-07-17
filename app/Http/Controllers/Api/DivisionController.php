<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Traits\ApiResponder;
use App\Models\Division;
use Illuminate\Http\Request;

class DivisionController extends Controller
{
    use ApiResponder;

    public function index(Request $request)
    {
        $query = Division::query();

        if ($request->has('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        $divisions = $query->paginate(10);

        $data = [
            'divisions' => $divisions->items(),
            'pagination' => [
                'total' => $divisions->total(),
                'per_page' => $divisions->perPage(),
                'current_page' => $divisions->currentPage(),
                'last_page' => $divisions->lastPage(),
                'from' => $divisions->firstItem(),
                'to' => $divisions->lastItem(),
            ],
        ];

        return $this->success($data);
    }
}
