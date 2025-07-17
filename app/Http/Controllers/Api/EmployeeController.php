<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Traits\ApiResponder;
use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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

    public function store(StoreEmployeeRequest $request)
    {
        $validated = $request->validated();

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('public/employees');
            $validated['image'] = Storage::url($path);
        }

        Employee::create($validated);

        return $this->success(null, 'Employee created successfully.');
    }

    public function show(Employee $employee)
    {
        return $this->success($employee);
    }

    public function update(UpdateEmployeeRequest $request, Employee $employee)
    {
        $validated = $request->validated();

        if ($request->hasFile('image')) {
            if ($employee->image) {
                Storage::delete(str_replace('/storage', 'public', $employee->image));
            }

            $path = $request->file('image')->store('public/employees');
            $validated['image'] = Storage::url($path);
        }

        $employee->update($validated);

        return $this->success(null, 'Employee updated successfully.');
    }

    public function destroy(Employee $employee)
    {
        if ($employee->image) {
            Storage::delete(str_replace('/storage', 'public', $employee->image));
        }

        $employee->delete();

        return $this->success(null, 'Employee deleted successfully.');
    }

}
