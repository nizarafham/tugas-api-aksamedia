<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Traits\ApiResponder;
use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    use ApiResponder;

    public function index(Request $request)
    {
        $query = Employee::query();

        if ($request->has('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        if ($request->has('division_id')) {
            $query->where('division_id', $request->division_id);
        }

        $employees = $query->paginate(10);

        $data = [
            'employees' => $employees->items(),
            'pagination' => [
                'total' => $employees->total(),
                'per_page' => $employees->perPage(),
                'current_page' => $employees->currentPage(),
                'last_page' => $employees->lastPage(),
                'from' => $employees->firstItem(),
                'to' => $employees->lastItem(),
            ],
        ];

        return $this->success($data);
    }
}
