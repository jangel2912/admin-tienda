<?php
/**
 * Created by adminshop.
 * User: Rafael Moreno
 * Date: 28/02/2019
 * Time: 4:32 PM
 */

namespace App\Tools;


use App\Models\Vendty\Shop;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Process\Process;

/**
 * Class Domain
 * @package App\Tools
 */
class Domain
{
    /**
     * @param string $domain
     * @return bool
     */
    public function validate(string $domain)
    {
        $domain = parse_shop_domain($domain);

        $dns = collect(dns_get_record($domain));
        $a = $dns->where('type', 'A')->where('ip', env('DNS_IP'))->first();
        $cname = $dns->where('type', 'CNAME')->where('target', env('DNS_HOST'))->first();

        return (!is_null($a) || !is_null($cname));
    }

    /**
     * @param string $domain
     */
    public function process(string $domain)
    {
        $domain = parse_shop_domain($domain);

        $domains = Shop::whereNotNull('dominio')->get();
        $domains = $domains->pluck('dominio');

        $goods = collect([]);

        $domains->each(function ($domain) use (&$goods) {
            try {
                if ($domain != "") {

                    $dns = collect(dns_get_record($domain));
                    $a = $dns->where('type', 'A')->where('ip', env('DNS_IP'))->first();
                    $cname = $dns->where('type', 'CNAME')->where('target', env('DNS_HOST'))->first();

                    if (!is_null($a) || !is_null($cname)) {
                        $goods->push($domain);
                    }
                }
            } catch (\Exception $exception) {
                Log::error($exception);
            }
        });

        if ($domain !== '') {
            $goods->push($domain);
        }

        $this->command($goods);
    }

    /**
     * @param Collection $domains
     */
    private function command(Collection $domains)
    {
        if (env('APP_ENV') == 'production') {

            $command = "sudo certbot --apache --agree-tos --email arnulfo@vendty.com --expand --reinstall --no-redirect --apache-vhost-root /etc/apache2/sites-enabled/000-default.conf -d tienda.vendty.com,posapi.vendty.com,admintienda.vendty.com,apibeta.vendty.com,{$domains->implode(',')}";
            Log::notice($command);
            $process = new Process($command);
            $process->run();

            Log::notice($process->getOutput());
        }
    }
}
