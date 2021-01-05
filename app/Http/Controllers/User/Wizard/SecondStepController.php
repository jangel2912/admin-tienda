<?php

namespace App\Http\Controllers\User\Wizard;

use App\Http\Controllers\Controller;
use App\Models\Vendty\Shop;
use App\Models\Vendty\Template;
use Illuminate\Http\Request;

class SecondStepController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Request $request)
    {
        $shop = auth_user()->dbConfig->shop;
        $layout = '';
        $business_type = 'retail';

        if(!is_null($request->business_type) && ($request->business_type == 'retail' || $request->business_type == 'restaurant')){
            $business_type = $request->business_type;
        }

        if (!is_null($shop)) {
            $layout = $shop->layout;
            $currentTemplate = Template::where('nombre', $layout)->first();

            if(!is_null($currentTemplate) && is_null($request->business_type)){
                $business_type = $currentTemplate->tipo_negocio;
            }
        }

        $templates = $this->getTemplateByBusinessType($business_type);

        return view('admin.wizard.secondstep', compact('layout', 'templates', 'business_type'));
    }

    private function getTemplateByBusinessType($business_type){
        $templates = Template::where('active', true)
            ->where('tipo_negocio', $business_type)
            ->orderBy("color", "asc")
            ->get();

        return  $templates;
    }
}
