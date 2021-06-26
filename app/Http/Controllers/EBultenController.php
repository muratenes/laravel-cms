<?php

namespace App\Http\Controllers;

use App\Http\Requests\EbultenCreateRequest;
use App\Repositories\Interfaces\EBultenInterface;

class EBultenController extends Controller
{
    private EBultenInterface $_bultenService;

    public function __construct(EBultenInterface $bultenService)
    {
        $this->_bultenService = $bultenService;
    }

    public function createEBulten(EbultenCreateRequest $request)
    {
        try {
            $data = $request->only('email');
            $item = $this->_bultenService->create($data);
            if ($item) {
                return back()->with('message', __('lang.congratulations_you_have_successfully_registered_for_the_newsletter'));
            }

            return back()->withErrors(__('lang.error_message'));
        } catch (\Exception $exception) {
            return back()->withErrors(__('lang.error_message'));
        }
    }
}
