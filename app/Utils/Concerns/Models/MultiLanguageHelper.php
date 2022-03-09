<?php

namespace App\Utils\Concerns\Models;

use App\Models\Ayar;
use App\Models\MultiLanguage;
use Illuminate\Database\Eloquent\Model;

trait MultiLanguageHelper
{
    /**
     * get MultiLanguage::class data initial value.
     *
     * @param Model $model
     *
     * @return array
     */
    public function getInitialDataColumnValue(Model $model): array
    {
        return collect($model::LANG_FIELDS)->mapWithKeys(function ($key) {
            return [$key => ''];
        })->toArray();
    }

    /**
     *  updateOrCrate model other language instances.
     *
     * @param \Illuminate\Http\Request $request
     * @param Model                    $model
     */
    private function syncModelForOtherLanguages(\Illuminate\Http\Request $request, Model $model)
    {
        foreach (Ayar::otherActiveLanguages() as $language) {
            $data = $this->getInitialDataColumnValue($model);

            if ($request->hasAny($model::LANG_FIELDS)) {
                foreach ($model::LANG_FIELDS as $field) {
                    $data[$field] = $request->get("{$field}_{$language[0]}");
                }
                MultiLanguage::updateOrCreate(
                    ['lang' => $language[0], 'languageable_id' => $model->id, 'languageable_type' => \get_class($model)],
                    ['data' => $data]
                );
            } else {
                MultiLanguage::create([
                    'lang'              => $language[0],
                    'languageable_id'   => $model->id,
                    'languageable_type' => \get_class($model),
                    'data'              => $data,
                ]);
            }
        }
    }
}
