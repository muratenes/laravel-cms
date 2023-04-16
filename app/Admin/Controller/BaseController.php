<?php

namespace App\Admin\Controller;

use Illuminate\Http\Request;

class BaseController
{
    public function index(Request $request)
    {
        $model = (new ('App\\Admin\\Models\\' . $request->get('model')));
        $items = $model->getItems();
        $fields = $model->getFields();

        return view('list', [
            'items'  => $items,
            'fields' => $fields,
        ]);
    }

    public function table(Request $request, string $model): \Illuminate\Http\JsonResponse
    {
        $model = (new ('App\\Admin\\Models\\' . $model));
        $items = $model->getItems();

        return response()->json($items);
    }
}
