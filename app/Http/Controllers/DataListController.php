<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Employer;
use App\Models\Worker;
use Illuminate\Http\Request;

class DataListController extends Controller
{
    public function agencies(Request $request)
    {
        $modal = Company::query()->select(['id', 'name as text'])
            ->where('name', 'like', "%{$request->q}%")
            ->get()
            ->toArray();

        return ['results' => $modal];
    }

    public function employers(Request $request)
    {
        $modal = Employer::query()->select(['id', 'name as text'])
            ->where('name', 'like', "%{$request->q}%")
            ->get()
            ->toArray();

        return ['results' => $modal];
    }

    public function workers(Request $request)
    {
        $modal = Worker::query()->selectRaw("id, CONCAT(last_name, ', ', first_name) as text")
            ->where('first_name', 'like', "%{$request->q}%")
            ->orWhere('last_name', 'like', "%{$request->q}%")
            ->get()
            ->toArray();

        return ['results' => $modal];
    }
}
