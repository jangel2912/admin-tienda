<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\SettingBasicUpdateRequest;
use App\Http\Requests\SettingLogosUpdateRequest;
use App\Http\Requests\SettingDomainsUpdateRequest;
use App\Http\Requests\SettingSlidersUpdateRequest;
use App\Imports\ShippingImport;
use App\Models\Shop\PaymentMethod\EPayco;
use App\Models\Shop\PaymentMethod\PayPal;
use App\Models\Shop\PaymentMethod\PayU;
use App\Models\Shop\SaleGoal;
use App\Models\Shop\RestaurantSchedule;
use App\Models\Shop\ScriptChat;
use App\Models\Shop\Warehouse;
use App\Models\Vendty\Template;
use App\Repositories\Facades\Vendty\Shop;
use App\Repositories\Shop\Option;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Image;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class SettingsController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getBasic()
    {
        $shop = auth_user()->dbConfig->shop;
        $url = !empty($shop->dominio) ? "https://".$shop->dominio : "https://".$shop->dominio_local.".vendty.com";
        $goals = SaleGoal::first();
        $warehouses = Warehouse::where('bodega', false)->get();
        $countries = collect(include resource_path('countries/all.php'));
        $currencies = collect(include resource_path('currencies/all.php'));
        $timezones = collect(include resource_path('timezones/all.php'));
        $default_timezone = option('zona_horaria');

    	return view('admin.settings.basic', compact('shop', 'warehouses', 'countries', 'currencies', 'goals', 'url', 'timezones', 'default_timezone'));
    }

    public function getQrcodePdf(){
        $shop = auth_user()->dbConfig->shop;
        $url = !empty($shop->dominio) ? "https://".$shop->dominio : "https://".$shop->dominio_local.".vendty.com";
        $qrcode = base64_encode(\QrCode::format('svg')->size(400)->errorCorrection('H')->generate($url));
        $result = [
            'shop' => $shop,
            'url' => $url,
            'qrcode' => $qrcode
        ];
        $pdf = PDF::loadView('admin.settings.qrcodepdf', $result);
        return $pdf->download("{$shop->shopname}.pdf");
    }

    public function downloadQrCode(){
        $shop = auth_user()->dbConfig->shop;
        $url = !empty($shop->dominio) ? "https://".$shop->dominio : "https://".$shop->dominio_local.".vendty.com";

        $image = \QrCode::format('png')
            ->size(400)
                ->errorCorrection("H")
                    ->generate($url);

        return response($image)
            ->header('Content-type', 'image/png')
                ->header('Content-Disposition', 'attachment; filename="'.$shop->shopname.'.png"');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getLogo()
    {
        $shop = auth_user()->dbConfig->shop;
    	return view('admin.settings.logos', compact('shop'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getDomains()
    {
        $shop = auth_user()->dbConfig->shop;

    	return view('admin.settings.domains', compact('shop'));
    }

    /**
     * Actualizamos la información general de la tienda
     *
     * @param SettingBasicUpdateRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function setBasic(SettingBasicUpdateRequest $request)
    {
        $shop = auth_user()->dbConfig->shop;

        $option = new Option;
        $option->set('tipo_moneda', $request->currency);
        $option->set('moneda_empresa', $request->currency);
        $option->set('simbolo', $request->symbol);
        $option->set('zona_horaria', $request->timezone);
        auth_user()->pais = $request->country;
        auth_user()->save();

    	$shop->id_almacen = $request->warehouse;
        $shop->correo = $request->correo;
        $shop->shopname = $request->shopname;

        $dominio_local = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $request->dominio_local));
        $shop->dominio_local = $dominio_local;

        if ($shop->save()) {

            $goals = SaleGoal::first();
            if (is_null($goals)) {
                $goals = new SaleGoal;
            }

            $goals->monto = $request->monto;
            $goals->save();

            if (!is_null(auth_user()->dbConfig->dbActive)) {
                //auth_user()->dbConfig->dbActive->tienda_dominio = $shop->dominio;
                $rest =  substr(env('DNS_HOST') . '/' . $shop->shopname, 0, 45);
                auth_user()->dbConfig->dbActive->tienda_dominio_interno = $rest;
                auth_user()->dbConfig->dbActive->tienda_estado = $shop->activo;
                auth_user()->dbConfig->dbActive->save();
            }

            return back()->with('success', '¡Los datos se actualizaron con éxito!');
        } else {
            return back()->with('error', message('error'));
        }
    }

    /**
     * Actualizamos las dominios de la tienda
     *
     * @param SettingBasicUpdateRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function setDomains(SettingDomainsUpdateRequest $request)
    {
        $shop = auth_user()->dbConfig->shop;
        $shop->dominio = $request->dominio;

        if ($shop->save()) {
            if (!is_null(auth_user()->dbConfig->dbActive)) {
                auth_user()->dbConfig->dbActive->tienda_dominio = $shop->dominio;
                auth_user()->dbConfig->dbActive->tienda_dominio_interno = env('DNS_HOST') . '/' . $shop->shopname;
                auth_user()->dbConfig->dbActive->tienda_estado = $shop->activo;
                auth_user()->dbConfig->dbActive->save();
            }

            return back()->with('success', '¡Los datos se actualizaron con éxito!');
        } else {
            return back()->with('error', message('error'));
        }
    }

    /**
     * Mostramos los sliders de la tienda
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getSliders()
    {
        return view('admin.settings.sliders');
    }

    /**
     * Mostramos la información SEO de la tienda
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getSeo()
    {
        $shop = auth_user()->dbConfig->shop;
        $google_analytics = $shop->google_analytics;
        $seo_description = $shop->seo_description;
        $seo_keywords = $shop->seo_keywords;
        $facebook_pixel = $shop->facebook_pixel;
        $google_tag_manager_id = $shop->google_tag_manager_id;
        $google_search_console_id = $shop->google_search_console_id;

        return view('admin.settings.seo', compact('google_analytics', 'seo_description', 'seo_keywords', 'facebook_pixel', 'google_tag_manager_id', 'google_search_console_id'));
    }

    /**
     * Actualizamos la información SEO de la tienda
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function setSeo(Request $request)
    {
        $this->validate($request, [
            'google_analytics' => 'nullable|string|max:50',
            'seo_description' => 'nullable|string|max:250',
            'seo_keywords' => 'nullable|string|max:250',
            'facebook_pixel' => 'nullable|string|max:500',
            'google_tag_manager_id' => 'nullable|string|max:250',
            'google_search_console_id' => 'nullable|string|max:250',
        ]);

        $shop = auth_user()->dbConfig->shop;
        $shop->google_analytics = $request->google_analytics;
        $shop->seo_description = $request->seo_description;
        $shop->seo_keywords = $request->seo_keywords;
        $shop->facebook_pixel = $request->facebook_pixel;
        $shop->google_tag_manager_id = $request->google_tag_manager_id;
        $shop->google_search_console_id = $request->google_search_console_id;

        if ($shop->save()) {
            return back()->with('success', '¡Los datos se actualizaron con éxito!');
        } else {
            return back()->with('error', message('error'));
        }
    }

    /**
     * Mostramos la información de Envio de la tienda
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getShipping()
    {
        return view('admin.settings.shipping.all-free');
    }

    /**
     * Actualizamos la información de Envio de la tienda
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function setShipping(Request $request)
    {
        Excel::import(new ShippingImport, $request->file('excel'));
        return back()->with('success', '¡La información de los envíos se cargaron con éxito!');
    }

    /**
     * Mostramos la información del script del chat de la tienda
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getScriptChat()
    {
        $scriptchat = ScriptChat::first();
        return view('admin.settings.scriptchat', compact('scriptchat'));
    }

    /**
     * Actualizamos la información del script del chat de la tienda
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function setScriptChat(Request $request)
    {
        $this->validate($request, [
            'javascript' => 'nullable|string|max:1000',
        ]);

        $scriptchat = ScriptChat::first();
        if (is_null($scriptchat)) {
            $scriptchat = new ScriptChat;
        }

        $scriptchat->javascript = $request->javascript;
        if ($scriptchat->save()) {
            return back()->with('success', '¡Los datos se actualizaron con éxito!');
        } else {
            return back()->with('error', message('error'));
        }
    }

    /**
     * Mostramos las plantillas de la tienda
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getTemplates(Request $request)
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

        return view('admin.settings.templates', compact('layout', 'templates', 'business_type'));
    }

    private function getTemplateByBusinessType($business_type){
        $templates = Template::where('active', true)
            ->where('tipo_negocio', $business_type)
            ->orderBy("color", "asc")
            ->get();

        return  $templates;
    }

    /**
     * Actualizamos la plantilla de la tienda
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function setTemplates(Request $request)
    {
    	$template = Template::where([['id', $request->id], ['active', 1]])->first();

    	if (Shop::update(['layout' => $template->nombre])) {
            return response()->json([
                'status' => true,
                'template' => $template,
            	'description' => '¡Los datos se actualizaron con éxito!'
            ]);
        } else {
            return response()->json([
            	'status' => false,
            	'description' => '¡Ha ocurrido un error, intentelo de nuevo o contacte con soporte técnico!'
            ]);
        }
    }

    /**
     * Subir el logo de la tienda
     *
     * @param Request $request
     * @return Boolean
     */
    public function uploadImage(Request $request)
    {

        $shop = auth_user()->dbConfig->shop;
        $image = $request->image;
        $base64_image = $request->base64_image;
        $image_s3 = base64_decode($base64_image);


        $extension = explode('/', mime_content_type($base64_image))[1];
        $directory = public_path('uploads/' . auth_user()->dbConfig->base_dato . '/images');
        $routeNewImage = $directory . '/' . $image . '.' . $extension;

        if ($shop->$image) {
            $routeImage = 'public/uploads/' . $shop->$image;
            if (Storage::delete($routeImage)) {
                $shop->$image = null;
            }
        }

        if (!file_exists($directory)) {
            mkdir($directory, 0777, true);
        }

        if (Image::make(file_get_contents($base64_image))->save($routeNewImage)) {
            $shop->$image = auth_user()->dbConfig->base_dato . '/images/' . $image . '.' . $extension;

            $storage = Storage::disk('s3')->put(
                auth_user()->dbConfig->base_dato . '/images/'.$image . '.' . $extension,
                file_get_contents($base64_image)
            );

            return response()->json(['status' => $shop->save()]);
        }



        return response()->json(['status' => false]);
    }

    /**
     * Subir el favicon de la tienda
     *
     * @param Request $request
     * @return Boolean
     */
    public function uploadFaviconImage(SettingLogosUpdateRequest $request)
    {
        $shop = auth_user()->dbConfig->shop;

        $favicon = null;
        if ($request->hasFile('favicon')) {
            $favicon = $request->file('favicon')->store(auth_user()->dbConfig->base_dato . '/favicon', 'uploads');
        }

        if (!is_null($favicon)) {
            $shop->favicon = $favicon;
        }

        if($shop->save()){
            return response()->json(['status' => true, 'favicon' => image_path($shop->favicon)]);
        }

        return response()->json(['status' => false]);

    }

    /**
     * Eliminamos imagenes de la tienda
     *
     * @param Request $request
     * @return Boolean
     */
    public function deleteImage(Request $request)
    {
        $shop = auth_user()->dbConfig->shop;
        $image = $request->image;

        if ($shop->$image) {
            $routeImage = 'public/uploads/' . $shop->$image;
            if (Storage::delete($routeImage)) {
                $shop->$image = null;
                return response()->json(['status' => $shop->save()]);
            }
        }

        return response()->json(['status' => false]);
    }

    /**
     * Mostramos los horarios seleccionados
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getSingleSchedule($id)
    {
        $schedule = RestaurantSchedule::where(['id' => $id])->first();
        if(!is_null($schedule)){
            return response()->json($schedule);
        }
        return response()->json(['status' => false]);
    }

    /**
     * Mostramos los horarios seleccionados
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getSchedule(Request $request)
    {

        $schedule = RestaurantSchedule::get();
        return view('admin.settings.schedule', compact('schedule'));
    }

    /**
     * Editamos los horarios
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function setSchedule(Request $request)
    {
        $this->validate($request, [
            'from' => 'date_format:H:i',
            'to' => 'date_format:H:i',
            'dates' =>  'array'
        ]);

        $weekDays = [
            'sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'
        ];

        $restaurantSchedule = new RestaurantSchedule();

        if($request->id != 0){
            $schedule = RestaurantSchedule::where(['id' => $request->id])->first();
            if(!is_null($schedule)){
                $restaurantSchedule = $schedule;
            }
        }

        $restaurantSchedule->open_time = $request->from;
        $restaurantSchedule->close_time = $request->to;
        $restaurantSchedule->sunday = 1;
        $restaurantSchedule->monday = 1;
        $restaurantSchedule->tuesday = 1;
        $restaurantSchedule->wednesday = 1;
        $restaurantSchedule->thursday = 1;
        $restaurantSchedule->friday = 1;
        $restaurantSchedule->saturday = 1;

        $excluded_dates = array_diff($weekDays, $request->dates);
        foreach($excluded_dates as $date) {
            switch($date){
                case 'sunday':
                    $restaurantSchedule->sunday = 0;
                break;
                case 'monday':
                    $restaurantSchedule->monday = 0;
                break;
                case 'tuesday':
                    $restaurantSchedule->tuesday = 0;
                break;
                case 'wednesday':
                    $restaurantSchedule->wednesday = 0;
                break;
                case 'thursday':
                    $restaurantSchedule->thursday = 0;
                break;
                case 'friday':
                    $restaurantSchedule->friday = 0;
                break;
                case 'saturday':
                    $restaurantSchedule->saturday = 0;
                break;
            }
        }

        try {
            $restaurantSchedule->save();
            $request->session()->flash('success', "¡Los datos se actualizaron con éxito!");
            return response()->json(['success' => true]);
        }
        catch(\Exception $e){
            // do task when error
            echo $e->getMessage();   // insert query
        }
    }

    /**
     * Eliminar un horario seleccionado
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function removeSchedule($id)
    {
        $schedule = RestaurantSchedule::where(['id' => $id])->first();
        if(!is_null($schedule)){
            $schedule->delete();
            return back()->with('success', '¡Horario eliminado correctamente!');
        }
        return back()->with('error', '¡Error al eliminar el horario!');
    }
}
