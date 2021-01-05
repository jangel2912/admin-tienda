<?php

namespace App\Database;

use App\User;
use App\Models\Shop\PaymentMethod\Cash;
use App\Models\Shop\SaleGoal;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Class Tables
 * @package App\Database
 */
class Tables
{
    /**
     * Establecemos la conexion que se usara
     *
     * @var \App\Database\Connection
     */
	private $connection;

    /**
     * Tables constructor.
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;

        (new Connection($this->user));
        $this->connection = Schema::connection('mysql_shop');
	}

    /**
     * Creamos la tabla Favoritos
     */
	public function favorite()
	{
		if (!$this->connection->hasTable('favoritos')) {
			$this->connection->create('favoritos', function(Blueprint $table) {
				$table->increments('id');
				$table->integer('id_cliente')->unsigned();
				$table->integer('id_producto')->unsigned();
				$table->timestamps();
			});
		}
	}

	/**
	 * Creamos la tabla del Carrito de Compras
	 */
	public function shoppingCart()
	{
		if (!$this->connection->hasTable('carrito_compras')) {
			$this->connection->create('carrito_compras', function(Blueprint $table) {
				$table->increments('id');
				$table->integer('id_producto')->unsigned();
				$table->integer('id_cliente')->unsigned();
				$table->integer('cantidad')->unsigned();
				$table->timestamps();
			});
		}
	}

	/**
	 * Agregamos el token a los clientes
	 */
	public function customers()
	{
		if (!$this->connection->hasColumn('clientes', 'remember_token')) {
			$this->connection->table('clientes', function(Blueprint $table) {
				$table->rememberToken();
			});
		}
	}

	/**
	 * Creamos la tabla de los Tokens de Epayco de los Clientes
	 */
	public function epaycoTokenCustomers()
	{
		if (!$this->connection->hasTable('epayco_token_customers')) {
			$this->connection->create('epayco_token_customers', function(Blueprint $table) {
				$table->increments('id');
				$table->string('token_id', 45);
				$table->integer('id_cliente')->unsigned();
				$table->timestamps();
			});
		}
	}

	public function scriptChat()
	{
		if (!$this->connection->hasTable('scriptchat')) {
			$this->connection->create('scriptchat', function(Blueprint $table) {
				$table->increments('id');
				$table->text('html')->nullable();
				$table->text('javascript')->nullable();
				$table->timestamps();
			});
		}
	}

	/**
	 * Agregamos los campos de Fecha a la tabla
	 */
	public function onlineVentaProd()
	{
		if (!$this->connection->hasColumn('online_venta_prod', 'created_at')) {
			$this->connection->table('online_venta_prod', function(Blueprint $table) {
				$table->timestamps();
			});
		}
	}

	/**
	 * Logins de los clientesption
	 */
	public function logsLogin()
	{
		if (!$this->connection->hasTable('logs_login')) {
			$this->connection->create('logs_login', function(Blueprint $table) {
				$table->increments('id');
				$table->string('ip', 45)->nullable();
				$table->string('browser', 255)->nullable();
				$table->timestamps();
			});
		}
	}

	/**
	 * Tabla de metas [description]
	 */
	public function goalsSales()
	{
		if (!$this->connection->hasTable('meta_ventas')) {
			$this->connection->create('meta_ventas', function(Blueprint $table) {
				$table->increments('id');
				$table->double('monto', 20, 2);
				$table->timestamps();
			});

			$goals = new SaleGoal;
			$goals->monto = 1000000;
			$goals->save();
		}
	}

	/**
	 * Tabla para las credenciales de PayU
	 */
	public function payu()
	{
		if (!$this->connection->hasTable('payu_credentials')) {
			$this->connection->create('payu_credentials', function(Blueprint $table) {
				$table->increments('id');
				$table->string('merchant_id', 100);
				$table->string('account_id', 100);
				$table->string('api_key', 100);
				$table->boolean('active')->default(false);
				$table->timestamps();
			});
        }

        if (!$this->connection->hasColumn('payu_credentials', 'payu_test_mode')) {
            $this->connection->table('payu_credentials', function(Blueprint $table) {
                $table->boolean('payu_test_mode')->default(false);
            });
        }
	}

    /**
     * Tabla para credenciales de Wompi
     */
    public function wompi()
    {
        if ($this->connection->hasColumn('wompi_credentials', 'access_token')) {
			$this->connection->table('wompi_credentials', function(Blueprint $table) {
				$table->renameColumn('access_token', 'private_key');
			});
        }

        if (!$this->connection->hasTable('wompi_credentials')) {
            $this->connection->create('wompi_credentials', function(Blueprint $table) {
                $table->increments('id');
                $table->string('public_key', 100);
                $table->string('private_key', 100);
                $table->boolean('active')->default(false);
                $table->timestamps();
            });
        }
    }

	/**
	 * Tabla para credenciales de EpayCO
	 */
	public function epayco()
	{
		if (!$this->connection->hasTable('epayco_credentials')) {
			$this->connection->create('epayco_credentials', function(Blueprint $table) {
				$table->increments('id');
				$table->string('client_id', 100);
				$table->string('public_key', 100);
				$table->string('private_key', 100);
				$table->boolean('active')->default(false);
				$table->timestamps();
			});
		}
	}

    /**
     * Tabla para credenciales de MercadoPago
     */
    public function mercadopago()
    {
        if (!$this->connection->hasTable('mercadopago_credentials')) {
            $this->connection->create('mercadopago_credentials', function(Blueprint $table) {
                $table->increments('id');
                $table->string('public_key', 100);
                $table->string('access_token', 100);
                $table->boolean('active')->default(false);
                $table->timestamps();
            });
        }

        if ($this->connection->hasTable('mercadopago_credentials') && !$this->connection->hasColumn('mercadopago_credentials', 'mercadopago_country')) {
			$this->connection->table('mercadopago_credentials', function(Blueprint $table) {
				$table->string('mercadopago_country')->default("co");
			});
        }
    }

	/**
	 * Tabla para credenciales de PayPal
	 */
	public function paypal()
	{
		if (!$this->connection->hasTable('paypal_credentials')) {
			$this->connection->create('paypal_credentials', function(Blueprint $table) {
				$table->increments('id');
				$table->string('client_id', 100);
				$table->string('secret_id', 100)->nullable();
				$table->boolean('active')->default(false);
				$table->timestamps();
			});
		}
	}

    /**
     * Tabla para credenciales de OpenPay
     */
    public function openpay()
    {
        if (!$this->connection->hasTable('openpay_credentials')) {
            $this->connection->create('openpay_credentials', function(Blueprint $table) {
                $table->increments('id');
                $table->string('client_id', 100);
                $table->string('public_key', 100);
                $table->string('private_key', 100);
                $table->boolean('active')->default(false);
                $table->timestamps();
            });
        }
    }

    /**
     *
     */
    public function cash()
    {
        if (!$this->connection->hasTable('cash_credentials')) {
            $this->connection->create('cash_credentials', function(Blueprint $table) {
                $table->increments('id');
                $table->boolean('active')->default(true);
                $table->timestamps();
            });

            $cash = new Cash;
            $cash->active = true;
            $cash->save();
        }
    }

	/**
	 * Tabla para almacenar las transacciones de PayU
	 */
	public function payuTransaction()
	{
		if (!$this->connection->hasTable('payu')) {
			$this->connection->create('payu', function(Blueprint $table) {
				$table->increments('id');
				$table->string('merchant_name', 100)->nullable();
				$table->string('merchant_address', 255)->nullable();
				$table->string('telephone', 45)->nullable();
				$table->string('merchant_url', 45)->nullable();
				$table->integer('transactionState');
				$table->string('lapTransactionState', 45);
				$table->string('message', 255);
				$table->string('referenceCode', 45);
				$table->string('reference_pol', 45)->nullable();
				$table->string('transactionId', 45)->nullable();
				$table->string('description', 100)->nullable();
				$table->text('extra1', 45)->nullable();
				$table->text('extra2', 45)->nullable();
				$table->text('extra3', 45)->nullable();
				$table->integer('polTransactionState')->nullable();
				$table->string('signature', 45)->nullable();
				$table->integer('polResponseCode')->nullable();
				$table->string('lapResponseCode', 45)->nullable();
				$table->integer('polPaymentMethod')->nullable();
				$table->string('lapPaymentMethod', 45)->nullable();
				$table->integer('polPaymentMethodType')->nullable();
				$table->string('lapPaymentMethodType', 45)->nullable();
				$table->integer('installmentsNumber')->nullable();
				$table->double('value', 20, 2);
				$table->string('currency', 10);
				$table->timestamps();
			});
		}
	}

	/**
	 * Modificamos las columnas de la taba redes
	 */
	public function socialNetworks()
	{
		Schema::connection('mysql_vendty')->table('redes', function(Blueprint $table) {
			$table->string('drible', 500)->nullable()->change();
			$table->string('facebook', 500)->nullable()->change();
			$table->string('google', 500)->nullable()->change();
			$table->string('instagram', 500)->nullable()->change();
			$table->string('linkedin', 500)->nullable()->change();
			$table->string('twitter', 500)->nullable()->change();
			$table->string('youtube', 500)->nullable()->change();
			$table->string('pinterest', 500)->nullable()->change();
		});
	}

	/**
	 * Agregamos el producto destado
	 */
	public function addFeaturedProduct()
	{
		if (!$this->connection->hasColumn('producto', 'destacado_tienda')) {
			$this->connection->table('producto', function(Blueprint $table) {
				$table->boolean('destacado_tienda')->default(false);
			});
		}
	}

	/**
	 * Agregamos los campos de Fecha a la tabla
	 */
	public function scriptchatTimestamps()
	{
		if (!$this->connection->hasColumn('scriptchat', 'created_at')) {
			$this->connection->table('scriptchat', function(Blueprint $table) {
				$table->timestamps();
			});
		}
	}

    /**
     * Creamos la tabla de visitas
     */
	public function visits()
	{
		if (!$this->connection->hasTable('visits')) {
			$this->connection->create('visits', function(Blueprint $table) {
				$table->increments('id');
				$table->ipAddress('ip');
				$table->timestamps();
			});
		}
	}

	/**
	 * [addTaxOnlineSaleProd description]
	 */
	public function addTaxOnlineSaleProd()
	{
		if (!$this->connection->hasColumn('online_venta_prod', 'impuesto')) {
			$this->connection->table('online_venta_prod', function(Blueprint $table) {
				$table->integer('impuesto')->nullable()->after('precio');
			});
		}
	}

	/**
	 * [changeLastNameOnlineSale description]
	 */
	public function changeLastNameOnlineSale()
	{
		$this->connection->table('online_venta', function(Blueprint $table) {
			$table->string('apellidos')->nullable()->change();
			$table->string('direccion')->nullable()->change();
			$table->string('metodo_pago', 50)->change();
			$table->dateTime('fecha')->change();
		});
	}

    /**
     *
     */
	public function contactusStore()
    {
        if (!$this->connection->hasTable('tienda_contactanos')) {
            $this->connection->create('tienda_contactanos', function(Blueprint $table) {
                $table->increments('id');
                $table->text('google_maps')->nullable();
                $table->string('address', 200)->nullable();
                $table->string('prefix_phone', 10)->nullable();
                $table->string('phone', 30)->nullable();
                $table->string('prefix_cellphone', 10)->nullable();
                $table->string('cellphone', 30)->nullable();
                $table->string('prefix_whatsapp', 10)->nullable();
                $table->string('whatsapp', 30)->nullable();
                $table->string('whatsapp_default_message', 250)->nullable();
                $table->string('email', 100)->nullable();
                $table->timestamps();
            });
        } else {
            if (!$this->connection->hasColumn('tienda_contactanos', 'prefix_phone')) {
                $this->connection->table('tienda_contactanos', function(Blueprint $table) {
                    $table->string('prefix_phone', 10)->nullable();
                });
            }

            if (!$this->connection->hasColumn('tienda_contactanos', 'prefix_cellphone')) {
                $this->connection->table('tienda_contactanos', function(Blueprint $table) {
                    $table->string('prefix_cellphone', 10)->nullable();
                });
            }

            if (!$this->connection->hasColumn('tienda_contactanos', 'cellphone')) {
                $this->connection->table('tienda_contactanos', function(Blueprint $table) {
                    $table->string('cellphone', 30)->nullable();
                });
            }

            if (!$this->connection->hasColumn('tienda_contactanos', 'prefix_whatsapp')) {
                $this->connection->table('tienda_contactanos', function(Blueprint $table) {
                    $table->string('prefix_whatsapp', 10)->nullable();
                });
            }

            if (!$this->connection->hasColumn('tienda_contactanos', 'whatsapp')) {
                $this->connection->table('tienda_contactanos', function(Blueprint $table) {
                    $table->string('whatsapp', 30)->nullable();
                });
            }

            if (!$this->connection->hasColumn('tienda_contactanos', 'whatsapp_default_message')) {
                $this->connection->table('tienda_contactanos', function(Blueprint $table) {
                    $table->string('whatsapp_default_message', 250)->nullable();
                });
            }
        }
    }

    public function envios()
    {
        if (!$this->connection->hasTable('envios')) {
            $this->connection->create('envios', function(Blueprint $table) {
                $table->increments('id');
                $table->string('nombre', 45);
                $table->double('valor', 20, 2)->nullable();
                $table->boolean('activo');
                $table->timestamps();
            });
        }
    }

    public function envios_gratis_desde()
    {
        if (!$this->connection->hasTable('envios_gratis_desde')) {
            $this->connection->create('envios_gratis_desde', function(Blueprint $table) {
                $table->increments('id');
                $table->double('valor', 20, 2);
                $table->double('minimo', 20, 2);
                $table->timestamps();
            });
        }
    }

    public function envios_por_destino()
    {
        if (!$this->connection->hasTable('envios_por_destino')) {
            $this->connection->create('envios_por_destino', function(Blueprint $table) {
                $table->increments('id');
                $table->string('origen', 100);
                $table->string('destino', 100);
                $table->double('valor', 20, 2);
                $table->timestamps();
            });
        }
    }

    public function envios_por_destino_length()
    {
        $this->connection->table('envios_por_destino', function ($table) {
            $table->string('origen', 100)->change();
            $table->string('destino', 100)->change();
        });
    }

    /**
     * Agregamos el campo shop a promociones
     */
    public function promotions()
    {
        if (!$this->connection->hasColumn('promociones', 'shop')) {
            $this->connection->table('promociones', function(Blueprint $table) {
                $table->boolean('shop')->default(false);
            });
        }
    }

    /**
     *
     */
    public function long_description_product()
    {
        if (!$this->connection->hasColumn('producto', 'descripcion_larga')) {
            $this->connection->table('producto', function(Blueprint $table) {
                $table->text('descripcion_larga')->nullable()->after('descripcion');
            });
        }
    }

    /**
     *
     */
    public function showStock()
    {
        if (!$this->connection->hasColumn('producto', 'mostrar_stock')) {
            $this->connection->table('producto', function(Blueprint $table) {
                $table->boolean('mostrar_stock')
                    ->default(false)
                    ->after('vendernegativo');
            });
        }
    }

    /**
     *
     */
    public function tiendaContactanosRowsLength()
    {
        $this->connection->table('tienda_contactanos', function ($table) {
            $table->string('phone', 30)->change();
            $table->string('cellphone', 30)->change();
            $table->string('whatsapp', 30)->change();
            $table->string('prefix_phone', 10)->change();
            $table->string('prefix_cellphone', 10)->change();
            $table->string('prefix_whatsapp', 10)->change();
        });
    }

    public function mercadopagoAccessTokenLength()
    {
        $this->connection->table('mercadopago_credentials', function ($table) {
            $table->string('access_token', 191)->change();
        });
    }

    /**
     *
     */
    public function templateStatus()
    {
        if (!Schema::connection('mysql_vendty')->hasColumn('plantillas', 'active')) {
            Schema::connection('mysql_vendty')->table('plantillas', function(Blueprint $table) {
                $table->boolean('active')->default(true);
            });
        }

        if (!Schema::connection('mysql_vendty')->hasColumn('plantillas', 'orden')) {
            Schema::connection('mysql_vendty')->table('plantillas', function(Blueprint $table) {
                $table->integer('orden')->default(0);
            });
        }
    }

    /**
     *
     */
    public function shopCategory()
    {
        if (!$this->connection->hasColumn('categoria', 'tienda')) {
            $this->connection->table('categoria', function(Blueprint $table) {
                $table->boolean('tienda')->default(false);
            });
        }
    }

	public function onlineSales()
	{
		if (!$this->connection->hasColumn('online_venta', 'almacen_id')) {
			$this->connection->table('online_venta', function(Blueprint $table) {
				$table->integer('almacen_id')->default(1);
			});
		}
		if (!$this->connection->hasColumn('online_venta', 'origen')) {
			$this->connection->table('online_venta', function(Blueprint $table) {
                $table->string('origen', 20);
			});
        }
		if (!$this->connection->hasColumn('online_venta', 'poblacion')) {
			$this->connection->table('online_venta', function(Blueprint $table) {
                $table->string('poblacion', 20);
			});
		}
	}

    /**
     *
     */
    public function attributes()
    {
        if (!$this->connection->hasColumn('producto', 'referencia_id')) {
            $this->connection->table('producto', function(Blueprint $table) {
                $table->integer('referencia_id')->unsigned()->nullable();
            });
        }

        if (!$this->connection->hasTable('producto_referencia')) {
            $this->connection->create('producto_referencia', function(Blueprint $table) {
                $table->integer('id', true);
                $table->string('nombre', 254);
                $table->text('descripcion', 65535)->nullable();
                $table->text('descripcion_larga', 65535)->nullable();
                $table->string('thumbnail')->nullable();
                $table->string('imagen', 254)->nullable();
                $table->string('imagen1', 254)->nullable();
                $table->string('imagen2', 254)->nullable();
                $table->string('imagen3', 254)->nullable();
                $table->string('imagen4', 254)->nullable();
                $table->string('imagen5', 254)->nullable();
                $table->boolean('imagenes')->default(true);
            });
        } else if (!$this->connection->hasColumn('producto_referencia', 'imagenes')) {
            $this->connection->table('producto_referencia', function(Blueprint $table) {
                $table->boolean('imagenes')->default(true);
            });
        }

        if (!$this->connection->hasTable('producto_referencia_atributo')) {
            $this->connection->create('producto_referencia_atributo', function(Blueprint $table) {
                $table->integer('id', true);
                $table->string('nombre_atributo', 150);
                $table->integer('producto_referencia_id')->unsigned();
            });
        }

        if (!$this->connection->hasTable('producto_referencia_atributo_detalle')) {
            $this->connection->create('producto_referencia_atributo_detalle', function(Blueprint $table) {
                $table->integer('id', true);
                $table->string('nombre_detalle', 150);
                $table->integer('producto_referencia_atributo_id')->unsigned();
            });
        }

        if (!$this->connection->hasTable('producto_referencia_atributo_detalle_producto')) {
            $this->connection->create('producto_referencia_atributo_detalle_producto', function(Blueprint $table) {
                $table->integer('id', true);
                $table->integer('producto_referencia_atributo_detalle1_id')->unsigned();
                $table->integer('producto_referencia_atributo_detalle2_id')->unsigned()->nullable();
                $table->integer('producto_referencia_atributo_detalle3_id')->unsigned()->nullable();
                $table->integer('producto_referencia_atributo_detalle4_id')->unsigned()->nullable();
                $table->integer('producto_referencia_atributo_detalle5_id')->unsigned()->nullable();
                $table->integer('producto_referencia_atributo_detalle6_id')->unsigned()->nullable();
                $table->integer('producto_referencia_atributo_detalle7_id')->unsigned()->nullable();
                $table->integer('producto_referencia_atributo_detalle8_id')->unsigned()->nullable();
                $table->integer('producto_referencia_atributo_detalle9_id')->unsigned()->nullable();
                $table->integer('producto_referencia_atributo_detalle10_id')->unsigned()->nullable();
                $table->integer('producto_id')->unsigned();
            });
        }

        if ($this->connection->hasColumn('producto_referencia', 'precio_compra')) {
            $this->connection->table('producto_referencia', function(Blueprint $table) {
                $table->dropColumn('precio_compra');
            });
        }

        if ($this->connection->hasColumn('producto_referencia', 'precio_venta')) {
            $this->connection->table('producto_referencia', function(Blueprint $table) {
                $table->dropColumn('precio_venta');
            });
        }

        if ($this->connection->hasColumn('producto_referencia', 'activo')) {
            $this->connection->table('producto_referencia', function(Blueprint $table) {
                $table->dropColumn('activo');
            });
        }

        if ($this->connection->hasColumn('producto_referencia', 'tienda')) {
            $this->connection->table('producto_referencia', function(Blueprint $table) {
                $table->dropColumn('tienda');
            });
        }

        if ($this->connection->hasColumn('producto_referencia', 'vender_negativo')) {
            $this->connection->table('producto_referencia', function(Blueprint $table) {
                $table->dropColumn('vender_negativo');
            });
        }

        if ($this->connection->hasColumn('producto_referencia', 'mostrar_stock')) {
            $this->connection->table('producto_referencia', function(Blueprint $table) {
                $table->dropColumn('mostrar_stock');
            });
        }

        if ($this->connection->hasColumn('producto_referencia', 'destacado_tienda')) {
            $this->connection->table('producto_referencia', function(Blueprint $table) {
                $table->dropColumn('destacado_tienda');
            });
        }

        if ($this->connection->hasColumn('producto_referencia', 'categoria_id')) {
            $this->connection->table('producto_referencia', function(Blueprint $table) {
                $table->dropColumn('categoria_id');
            });
        }

        if ($this->connection->hasColumn('producto_referencia', 'unidad_id')) {
            $this->connection->table('producto_referencia', function(Blueprint $table) {
                $table->dropColumn('unidad_id');
            });
        }

        if ($this->connection->hasColumn('producto_referencia', 'impuesto_id')) {
            $this->connection->table('producto_referencia', function(Blueprint $table) {
                $table->dropColumn('impuesto_id');
            });
        }

        if ($this->connection->hasColumn('producto_referencia', 'proveedor_id')) {
            $this->connection->table('producto_referencia', function(Blueprint $table) {
                $table->dropColumn('proveedor_id');
            });
        }

        if ($this->connection->hasColumn('producto_referencia_atributo', 'atributo_id')) {
            $this->connection->table('producto_referencia_atributo', function(Blueprint $table) {
                $table->dropColumn('atributo_id');
            });
        }

        if ($this->connection->hasColumn('producto_referencia_atributo_detalle', 'atributo_detalle_id')) {
            $this->connection->table('producto_referencia_atributo_detalle', function(Blueprint $table) {
                $table->dropColumn('atributo_detalle_id');
            });
        }

        if ($this->connection->hasColumn('producto_referencia_atributo_detalle', 'producto_id')) {
            $this->connection->table('producto_referencia_atributo_detalle', function(Blueprint $table) {
                $table->dropColumn('producto_id');
            });
        }
    }

    /**
     * Tabla para credenciales de Kushki
     */
    public function kushki()
    {
        if (!$this->connection->hasTable('kushki_credentials')) {
            $this->connection->create('kushki_credentials', function(Blueprint $table) {
                $table->increments('id');
                $table->string('merchant_public_id', 100);
                $table->string('merchant_private_id', 100);
                $table->boolean('active')->default(false);
                $table->timestamps();
            });
        }

        if (!$this->connection->hasColumn('kushki_credentials', 'kushki_environment')) {
            $this->connection->table('kushki_credentials', function(Blueprint $table) {
                $table->boolean('kushki_environment')->default(false);
            });
        }
    }


    /**
    * Adicionar campo notas_adicionales
    */
    public function notasAdicionales()
    {
        if ($this->connection->hasTable('online_venta') && !$this->connection->hasColumn('online_venta', 'notas_adicionales')) {
            $this->connection->table('online_venta', function(Blueprint $table) {
                $table->text('notas_adicionales', 500)->nullable();
            });
        }
    }
    /**
     * Tabla para credenciales de Kushki
     */
    public function paymentez()
    {
        if (!$this->connection->hasTable('paymentez_credentials')) {
            $this->connection->create('paymentez_credentials', function(Blueprint $table) {
                $table->increments('id');
                $table->string('paymentez_app_code_client', 100);
                $table->string('paymentez_app_key_client', 100);
                $table->string('paymentez_app_code_server', 100);
                $table->string('paymentez_app_key_server', 100);
                $table->string('paymentez_environment')->default("stg");
                $table->boolean('active')->default(false);
                $table->timestamps();
            });
        }
    }

    public function cupones(){

        //incluir_productos
        //incluir_categorias
        //if (!$this->connection->hasColumn('cupon_cliente', 'coupon_value')) {}
        if ($this->connection->hasTable('cupon') &&
        (!$this->connection->hasColumn('cupon', 'incluir_productos') &&
        !$this->connection->hasColumn('cupon', 'incluir_categorias'))) {
            $this->connection->drop('cupon_cliente');
            $this->connection->drop('cupon_categoria');
            $this->connection->drop('cupon_producto');
            $this->connection->drop('cupon');
        }

        if (!$this->connection->hasTable('cupon')) {
            $this->connection->create('cupon', function(Blueprint $table) {
                $table->increments('id');
                $table->string('nombre', 100);
                $table->text('descripcion')->nullable();
                $table->enum('tipo', array('descuento_en_porsentaje', 'descuento_fijo_en_carrito', 'descuento_fijo_de_producto'));
                $table->date('fecha_caducidad');
                $table->double('importe', 20, 2);
                $table->double('gasto_minimo', 20, 2);
                $table->double('gasto_maximo', 20, 2);
                $table->boolean('uso_individual')->default(false);
                $table->boolean('incluir_productos')->default(false);
                $table->boolean('incluir_categorias')->default(false);
                $table->text('correos_electronicos')->nullable();
                $table->integer('limites_uso');
                $table->integer('limites_uso_usuario');
                $table->integer('cantidad_usos');
                $table->timestamps();
            });
        }

        if (!$this->connection->hasTable('cupon_producto')) {
            $this->connection->create('cupon_producto', function(Blueprint $table) {
                $table->increments('id');
                $table->integer('producto_id');
                $table->integer('cupon_id')->unsigned();
                $table->enum('tipo', array('incluido', 'no_incluido'));
                $table->timestamps();

                $table->foreign('producto_id')->references('id')->on('producto')->onDelete('cascade');
                $table->foreign('cupon_id')->references('id')->on('cupon')->onDelete('cascade');
            });
        }

        if (!$this->connection->hasTable('cupon_categoria')) {
            $this->connection->create('cupon_categoria', function(Blueprint $table) {
                $table->increments('id');
                $table->integer('categoria_id');
                $table->integer('cupon_id')->unsigned();
                $table->enum('tipo', array('incluido', 'no_incluido'));
                $table->timestamps();

                $table->foreign('categoria_id')->references('id')->on('categoria')->onDelete('cascade');
                $table->foreign('cupon_id')->references('id')->on('cupon')->onDelete('cascade');
            });
        }

        if (!$this->connection->hasTable('cupon_cliente')) {
            $this->connection->create('cupon_cliente', function(Blueprint $table) {
                $table->increments('id');
                $table->integer('id_cliente');
                $table->integer('cupon_id')->unsigned();
                $table->integer('online_venta_id');
                $table->double('coupon_value', 20, 2)->nullable();
                $table->timestamps();

                $table->foreign('id_cliente')->references('id_cliente')->on('clientes')->onDelete('cascade');
                $table->foreign('cupon_id')->references('id')->on('cupon')->onDelete('cascade');
                $table->foreign('online_venta_id')->references('id')->on('online_venta')->onDelete('cascade');
            });
        }
    }

     /**
     * Tabla para adiciones y modificaciones en restaurantes
     */
    public function onlineVentaRestaurant()
    {
        if (!$this->connection->hasTable('online_venta_prod_adition')) {
            $this->connection->create('online_venta_prod_adition', function(Blueprint $table) {
                $table->increments('id');
                $table->integer('online_venta_prod_id');
                $table->integer('producto_adicional_id');
                $table->integer('qty')->default(0);
                $table->timestamps();

                $table->foreign('online_venta_prod_id')->references('id')->on('online_venta_prod')->onDelete('cascade');
                $table->foreign('producto_adicional_id')->references('id')->on('producto_adicional')->onDelete('cascade');
            });
        }

        if (!$this->connection->hasTable('online_venta_prod_modification')) {
            $this->connection->create('online_venta_prod_modification', function(Blueprint $table) {
                $table->increments('id');
                $table->integer('online_venta_prod_id');
                $table->integer('producto_modificacion_id');
                $table->timestamps();

                $table->foreign('online_venta_prod_id')->references('id')->on('online_venta_prod')->onDelete('cascade');
                $table->foreign('producto_modificacion_id')->references('id')->on('producto_modificacion')->onDelete('cascade');
            });
        }
    }


    /**
     * Tabla para almacenar los Horarios de entrega del restaurant
     */
    public function restaurant_schedule()
    {
        if (!$this->connection->hasTable('restaurant_schedule')) {
            $this->connection->create('restaurant_schedule', function(Blueprint $table) {
                $table->increments('id');
                $table->boolean('sunday')->default(true);
                $table->boolean('monday')->default(true);
                $table->boolean('tuesday')->default(true);
                $table->boolean('wednesday')->default(true);
                $table->boolean('thursday')->default(true);
                $table->boolean('friday')->default(true);
                $table->boolean('saturday')->default(true);
                $table->time('open_time')->default('00:00:00');
                $table->time('close_time')->default('00:00:00');
                $table->timestamps();
            });
        }

        if (!$this->connection->hasTable('online_venta_schedule')) {
            $this->connection->create('online_venta_schedule', function(Blueprint $table) {
                $table->increments('id');
                $table->integer('online_venta_id');
                $table->time('sale_time')->default('00:00:00');
                $table->date('sale_date');
                $table->timestamps();

                $table->foreign('online_venta_id')->references('id')->on('online_venta')->onDelete('cascade');
                
            });
        }

    }

    public function customers_city_length()
    {
        $this->connection->table('clientes', function ($table) {
            $table->text('poblacion')->change();
        });
    }

    public function online_sales_city_length()
    {
        $this->connection->table('online_venta', function ($table) {
            $table->text('poblacion', 100)->change();
        });

    }

	/**
	 * Ejecutamos todos los scripts
	 */
	public function runAll()
	{
		$this->favorite();
		$this->shoppingCart();
		$this->customers();
		$this->epaycoTokenCustomers();
		$this->scriptChat();
		$this->onlineVentaProd();
		$this->logsLogin();
		$this->goalsSales();
		$this->payu();
		$this->wompi();
		$this->epayco();
        $this->mercadopago();
		$this->paypal();
		$this->openpay();
		$this->cash();
		$this->payuTransaction();
		$this->socialNetworks();
		$this->addFeaturedProduct();
		$this->scriptchatTimestamps();
		$this->visits();
		$this->addTaxOnlineSaleProd();
		$this->changeLastNameOnlineSale();
		$this->contactusStore();
		$this->envios();
		$this->envios_gratis_desde();
		$this->envios_por_destino();
		$this->envios_por_destino_length();
		// $this->promotions();
		$this->long_description_product();
		$this->showStock();
        $this->mercadopagoAccessTokenLength();
        $this->templateStatus();
        $this->shopCategory();
        $this->onlineSales();
        $this->attributes();
        $this->tiendaContactanosRowsLength();
        $this->kushki();
        $this->paymentez();
        $this->cupones();
        $this->onlineVentaRestaurant();
        $this->notasAdicionales();
        $this->restaurant_schedule();
        $this->customers_city_length();
        $this->online_sales_city_length();
	}
}
