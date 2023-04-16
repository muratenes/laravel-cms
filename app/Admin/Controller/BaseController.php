<?php

namespace App\Admin\Controller;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;

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

    public function table(Request $request, string $model, Builder $builder)
    {
        $adminModel = (new ('App\\Admin\\Models\\' . $model));
        $fields = $adminModel->getFields();

        if (request()->ajax()) {
            return DataTables::of($adminModel->getModel()::query())->toJson();
        }

        foreach ($fields as $field) {
            if (! $field->showOnList) {
                continue;
            }

            $builder->addColumn($field->getTableColumn());
        }

        return view('list', [
            'html' => $builder,
        ]);

        //        return response()->json($items);
    }
}
