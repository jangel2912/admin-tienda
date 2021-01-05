<?php

namespace App\Http\Controllers\API\Auth;

use App\User;
use App\Database\Tables;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\Shop\Option;
use App\Models\Shop\PaymentMethod\Cash;
use App\Models\Shop\SaleGoal;
use App\Models\Vendty\Shop;
use App\Models\Vendty\SocialNetwork;
use App\Shop\ContactUs;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class RegisterController extends Controller
{
    protected function register(RegisterRequest $request)
    {
        $dominio_local = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $request->shopname));
        $shop = Shop::where('dominio_local', $dominio_local)->first();

        if (!is_null($shop)) {
            for ($i = 0; $i < 1000000; $i++) {
                $dominio_substr = substr($dominio_local, 0, 50 - strlen(strval($i)));
                $shop = Shop::where('dominio_local', $dominio_substr . $i)->first();
                if (is_null($shop)) {
                    $dominio_local = $dominio_substr . $i;
                    break;
                }
            }
        }

        try {
            $client = new Client();

            $res = $client->request('POST', env('ROUTE_API') . '/register', [
                'form_params' => [
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'app' => 'tienda',
                    'store' => 'https://' . $dominio_local . env('APP_LOCAL_DOMAIN'),
                    'nit' => $request->nit,
                    'ally' => isset($data['ally']) ? $data['ally'] : null,
                ]
            ]);

            if ($res->getStatusCode() == 200) {
                $user = User::where('email', $request->email)->first();
                (new Tables($user))->runAll();
                $shop = new Shop;
                $shop->id_user = $user->id;
                $shop->id_db = $user->db_config_id;
                $shop->id_almacen = 1;
                $shop->dominio_local = $dominio_local;
                $shop->shopname = $request->shopname;
                $shop->correo = $request->email;
                $shop->description = 'Tienda';

                for ($i = 1; $i <= 2; $i++) {
                    $slider = 'slider' . $i;

                    if (!is_dir(public_path('uploads/'. $user->dbConfig->base_dato . '/sliders/'))) {
                        mkdir(public_path('uploads/'. $user->dbConfig->base_dato . '/sliders/'), 0777, true);
                    }

                    if (File::copy(public_path('/img/' . $slider . '.jpg'), public_path('uploads/'. $user->dbConfig->base_dato . '/sliders/' . $slider . '.jpg'))) {
                        $shop->$slider = $user->dbConfig->base_dato . '/sliders/' . $slider . '.jpg';
                    }
                }

                $shop->save();
                $cash = Cash::first();

                if (is_null($cash)) {
                    $cash = new Cash;
                }

                $cash->active = true;
                $cash->save();
                $social = SocialNetwork::where('id_user', $user->id)->first();

                if (is_null($social)) {
                    $social = new SocialNetwork;
                }

                $social->id_user = $user->id;
                $social->id_db = $user->db_config_id;
                $social->id_almacen = $shop->id_almacen;
                $social->facebook = 'https://faceboook.com';
                $social->instagram = 'https://instagram.com';
                $social->twitter = 'https://twitter.com';
                $social->save();
                $contactUs = ContactUs::first();

                if (is_null($contactUs)) {
                    $contactUs = new ContactUs;
                }

                $contactUs->cellphone = $request->phone;
                $contactUs->email = $request->email;
                $contactUs->save();
                $goals = SaleGoal::first();

                if (is_null($goals)) {
                    $goals = new SaleGoal;
                }

                $goals->monto = 0;
                $goals->save();

                if (isset($request->nit)) {
                    $option = new Option;
                    $option->set('nit', $request->nit);
                }

                $this->insertProdutcsTable($user);

                return response()->json([
                    'user' => $user,
                    'warehouse' => $shop,
                ]);
            }
        } catch(Exception $ex) {

        }

        return response()->json([
            'status' => false,
        ]);
    }

    /**
     * Insertamos 4 productos por defecto
     */
    protected function insertProdutcsTable($user)
    {
        DB::connection('mysql_shop')->table('producto')->insert(array(
            array(
                'imagen' => 'product1.jpg',
                'categoria_id' => '1',
                'codigo' => '001',
                'nombre' => 'PRODUCTO 1',
                'precio_compra' => '20000',
                'precio_venta' => '33000',
                'stock_minimo' => '0',
                'stock_maximo' => '0',
                'fecha_vencimiento' => '',
                'ubicacion' => '',
                'ganancia' => '0',
                'mostrar_stock' => '0',
                'destacado_tienda' => '1',
                'tienda' => '1',
                'descripcion' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec ut leo nec mi pulvinar posuere.;',
                'descripcion_larga' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec ut leo nec mi pulvinar posuere. Pellentesque vel tortor varius, sagittis dolor tristique, mattis sapien. Morbi diam risus, iaculis in eros quis, fermentum accumsan massa. Ut id felis eget nibh volutpat tincidunt non vitae nisl. Integer dapibus ultricies nibh id luctus. Quisque tempus felis sed purus pulvinar congue. Donec sed enim at quam lacinia ornare. Proin sed nunc eu felis luctus suscipit vitae finibus dui. Fusce augue ligula, tincidunt ac ante eu, consectetur dignissim elit. Vivamus sollicitudin nisl dolor, eget bibendum mauris laoreet sit amet. Aliquam sagittis lacus quis lacus dapibus suscipit. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae;',
            ),
            array(
                'imagen' => 'product2.jpg',
                'categoria_id' => '1',
                'codigo' => '002',
                'nombre' => 'PRODUCTO 2',
                'precio_compra' => '2000',
                'precio_venta' => '5500',
                'stock_minimo' => '0',
                'stock_maximo' => '0',
                'fecha_vencimiento' => '',
                'ubicacion' => '',
                'ganancia' => '0',
                'mostrar_stock' => '0',
                'destacado_tienda' => '1',
                'tienda' => '1',
                'descripcion' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec ut leo nec mi pulvinar posuere.;',
                'descripcion_larga' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec ut leo nec mi pulvinar posuere. Pellentesque vel tortor varius, sagittis dolor tristique, mattis sapien. Morbi diam risus, iaculis in eros quis, fermentum accumsan massa. Ut id felis eget nibh volutpat tincidunt non vitae nisl. Integer dapibus ultricies nibh id luctus. Quisque tempus felis sed purus pulvinar congue. Donec sed enim at quam lacinia ornare. Proin sed nunc eu felis luctus suscipit vitae finibus dui. Fusce augue ligula, tincidunt ac ante eu, consectetur dignissim elit. Vivamus sollicitudin nisl dolor, eget bibendum mauris laoreet sit amet. Aliquam sagittis lacus quis lacus dapibus suscipit. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae;',
            ),
            array(
                'imagen' => 'product3.jpg',
                'categoria_id' => '1',
                'codigo' => '003',
                'nombre' => 'PRODUCTO 3',
                'precio_compra' => '22000',
                'precio_venta' => '36000',
                'stock_minimo' => '0',
                'stock_maximo' => '0',
                'fecha_vencimiento' => '',
                'ubicacion' => '',
                'ganancia' => '0',
                'mostrar_stock' => '0',
                'destacado_tienda' => '1',
                'tienda' => '1',
                'descripcion' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec ut leo nec mi pulvinar posuere.;',
                'descripcion_larga' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec ut leo nec mi pulvinar posuere. Pellentesque vel tortor varius, sagittis dolor tristique, mattis sapien. Morbi diam risus, iaculis in eros quis, fermentum accumsan massa. Ut id felis eget nibh volutpat tincidunt non vitae nisl. Integer dapibus ultricies nibh id luctus. Quisque tempus felis sed purus pulvinar congue. Donec sed enim at quam lacinia ornare. Proin sed nunc eu felis luctus suscipit vitae finibus dui. Fusce augue ligula, tincidunt ac ante eu, consectetur dignissim elit. Vivamus sollicitudin nisl dolor, eget bibendum mauris laoreet sit amet. Aliquam sagittis lacus quis lacus dapibus suscipit. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae;',
            ),
            array(
                'imagen' => 'product4.jpg',
                'categoria_id' => '1',
                'codigo' => '004',
                'nombre' => 'PRODUCTO 4',
                'precio_compra' => '9000',
                'precio_venta' => '17000',
                'stock_minimo' => '0',
                'stock_maximo' => '0',
                'fecha_vencimiento' => '',
                'ubicacion' => '',
                'ganancia' => '0',
                'mostrar_stock' => '0',
                'destacado_tienda' => '1',
                'tienda' => '1',
                'descripcion' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec ut leo nec mi pulvinar posuere.;',
                'descripcion_larga' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec ut leo nec mi pulvinar posuere. Pellentesque vel tortor varius, sagittis dolor tristique, mattis sapien. Morbi diam risus, iaculis in eros quis, fermentum accumsan massa. Ut id felis eget nibh volutpat tincidunt non vitae nisl. Integer dapibus ultricies nibh id luctus. Quisque tempus felis sed purus pulvinar congue. Donec sed enim at quam lacinia ornare. Proin sed nunc eu felis luctus suscipit vitae finibus dui. Fusce augue ligula, tincidunt ac ante eu, consectetur dignissim elit. Vivamus sollicitudin nisl dolor, eget bibendum mauris laoreet sit amet. Aliquam sagittis lacus quis lacus dapibus suscipit. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae;',
            )
        ));

        DB::connection('mysql_shop')->table('stock_actual')->insert(array(
            array(
                'almacen_id' => 1,
                'producto_id' => 1,
                'unidades' => 10,
            ),
            array(
                'almacen_id' => 1,
                'producto_id' => 2,
                'unidades' => 10,
            ),
            array(
                'almacen_id' => 1,
                'producto_id' => 3,
                'unidades' => 10,
            ),
            array(
                'almacen_id' => 1,
                'producto_id' => 4,
                'unidades' => 10,
            )
        ));

        for ($i = 1; $i <= 4; $i++) {
            $product = 'product' . $i;

            if (!is_dir(public_path('uploads/'. $user->dbConfig->base_dato . '/imagenes_productos/'))) {
                mkdir(public_path('uploads/'. $user->dbConfig->base_dato . '/imagenes_productos/'), 0777, true);
            }

            File::copy(public_path('/img/' . $product . '.jpg'), public_path('uploads/'. $user->dbConfig->base_dato . '/imagenes_productos/' . $product . '.jpg'));
        }
    }
}
