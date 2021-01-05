<?php

if (!function_exists('auth_user')) {

    /**
     * @return \Illuminate\Contracts\Auth\Authenticatable|\App\User|null
     */
    function auth_user()
    {
        return auth()->user();
    }
}

if (!function_exists('url_shop')) {

    /**
     * @return string
     */
    function url_shop()
    {
        $shop = auth_user()->shop;

        if (!is_null($shop)) {
            $dominio = $shop->dominio;
            $dominio_local = $shop->dominio_local;

            if (env('APP_ENV') !== 'local') {
                if (!is_null($dominio) && $dominio !== '') {
                    return 'https://' . $dominio;
                } else if (ctype_alnum($dominio_local)) {
                    return 'https://' . $dominio_local . env('APP_LOCAL_DOMAIN');
                }
            }

            return env('APP_STORE') . '/' . $dominio_local;
        }

        return null;
    }
}

if (!function_exists('message')) {

    /**
     * @param string $type
     * @param string|null $message
     * @return string
     */
    function message(string $type, string $message = null)
    {
        if ($type = 'error') {
            if (!is_null($message)) {
                return $message;
            }

            return 'Ha ocurrido un error, por favor intentelo de nuevo. Si el error persiste comuniquese con nuestro equipo de soporte tecnico.';
        }
    }
}

if (!function_exists('validate_shipping')) {

    /**
     *
     */
    function validate_shipping()
    {
        $shipping = \App\Models\Shop\Shipping\Shipping::all();

        if ($shipping->count() == 0) {
            $shipping = new \App\Models\Shop\Shipping\Shipping;
            $shipping->nombre = "envios_todos_gratis";
            $shipping->valor = null;
            $shipping->activo = true;
            $shipping->save();

            $shipping = new \App\Models\Shop\Shipping\Shipping;
            $shipping->nombre = "envios_todos_por";
            $shipping->valor = 100000;
            $shipping->activo = false;
            $shipping->save();

            $shipping = new \App\Models\Shop\Shipping\Shipping;
            $shipping->nombre = "envios_gratis_desde";
            $shipping->valor = null;
            $shipping->activo = false;
            $shipping->save();

            $shipping = new \App\Models\Shop\Shipping\Shipping;
            $shipping->nombre = "envios_por_destino";
            $shipping->valor = null;
            $shipping->activo = false;
            $shipping->save();
        }
    }
}

if (!function_exists('parse_shop_domain')) {

    /**
     * @param string $domain
     * @return mixed|string
     */
    function parse_shop_domain(string $domain)
    {
        $domain = trim($domain);
        $domain = strtolower($domain);
        $domain = str_replace('https://', '', $domain);
        $domain = str_replace('http://', '', $domain);
        $domain = str_replace('www.', '', $domain);
        $domain = str_replace('/', '', $domain);

        return $domain;
    }
}

if (!function_exists('option')) {

    /**
     * Obtenemos los valores de las opciones del usuario
     *
     * @param string $option
     * @return mixed
     */
    function option(string $option)
    {
        $opt = new \App\Repositories\Shop\Option;

        return $opt->get($option);
    }
}

if (!function_exists('amount_format')) {

    /**
     * @param string $amount
     * @return string
     */
    function amount_format(string $amount)
    {
        $symbol = option('simbolo');
        $decimals = option('decimales_moneda');
        $dec_point = option('tipo_separador_decimales');
        $thousands_sep = option('tipo_separador_miles');

        $symbol = ($symbol != '') ? $symbol : '$';
        $decimals = ($decimals != '') ? $decimals : 0;
        $dec_point = ($dec_point != '') ? $dec_point : ',';
        $thousands_sep = ($thousands_sep != '') ? $thousands_sep : '.';

        return $symbol . '' .number_format($amount, $decimals, $dec_point, $thousands_sep);
    }
}

if (!function_exists('product_path')) {

    /**
     * @param string|null $image
     * @return string
     */
    function product_path(string $image = null) {
        $default_image = env('APP_URL') . '/img/product-default.png';

        if (is_null($image)) {
            return $default_image;
        }

        try {
            $url = env('ROUTE_IMAGES_PRODUCTS');
            $db = "";
            $prefix = substr($image, 0, 11);

            if ($prefix !== 'vendty2_db_') {
                $db = \Illuminate\Support\Facades\Config::get('database.connections.mysql_shop.database');
            }

            if (File::exists(public_path("uploads/{$db}/imagenes_productos/{$image}"))) {
                return "{$url}/{$db}/imagenes_productos/{$image}";
            }

            if (File::exists(public_path("uploads/{$image}"))) {
                return "{$url}/{$image}";
            }

            return $default_image;
        } catch (Exception $exception) {
            return $default_image;
        }
    }
}

if (!function_exists('image_path')) {

    /**
     * @param string|null $image
     * @return string
     */
    function image_path(string $image = null, $type = 'default')
    {
        $default_image = '/img/default.png';

        if ($type === 'logo') {
            $default_image = '/img/260x80.png';
        } else if ($type === 'slider') {
            $default_image = '/img/1200x340.png';
        }

        if (is_null($image)) {
            return $default_image;
        }

        try {
            $url = env('UPLOADS_URL');

            if (File::exists(public_path("uploads/{$image}"))) {
                return "{$url}/{$image}";
            }

            return $default_image;
        } catch (Exception $exception) {
            return $default_image;
        }
    }
}

if (!function_exists('sanitize_file_name')) {
    function sanitize_file_name ($string) {
        //remove non alpha numeric characters
        $string = strtolower(preg_replace('/[^A-Za-z0-9 ]/', '', $string));

        //replace more than one space to underscore
        $string = preg_replace('/([\s])\1+/', '_', $string );

        //convert any single spaces to underscrore
        $string = str_replace(' ', '_',$string);

        return $string;
    }
}

if (!function_exists('get_active_template_obj')) {

    /**
     * @param string $view
     * @return Template
     */
    function get_active_template_obj()
    {
        $shop = auth_user()->dbConfig->shop;

        $template = App\Models\Vendty\Template::where('active', true)
                ->where('nombre', $shop->layout)
                    ->first();

        return $template;
    }
}

if (!function_exists('get_mb_strtolower_utf8')) {

    /**
     * @param string $item
     * @return string
     */
    function get_mb_strtolower_utf8($item) {
        return mb_strtolower($item, 'UTF-8');
    }
}
