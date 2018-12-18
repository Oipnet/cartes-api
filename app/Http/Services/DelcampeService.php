<?php
/**
 * Created by PhpStorm.
 * User: arnaud
 * Date: 17/12/18
 * Time: 13:09
 */

namespace App\Http\Services;


use GuzzleHttp\Client;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Orchestra\Parser\Xml\Facade as XmlParser;

class DelcampeService
{
    /**
     * @var Client
     */
    private $client;
    /**
     * @var Facade
     */
    private $xmlParser;

    public function __construct(Client $client)
    {
        $this->client = $client;

        $response = $this->client->post('http://rest.delcampe.net/seller', ['query' => ['apikey' => config('delcampe.api_key')]]);

        $xml = XmlParser::extract($response->getBody()->getContents());
        $response = $xml->parse([
            'token' => ['uses' => 'Notification_Data.body.token']
        ]);

        $this->token = $response['token'];
    }

    public function getAuctions()
    {
        $continue = true;
        $start = 0;
        $numberOfItem=1000;
        $items = new Collection();

        while ($continue) {
            $response = $this->client->get('http://rest.delcampe.net/item/auction/opened',
                ['query' => [
                    'token' => $this->token,
                    'startingItem' => $start,
                    'numberOfItems' => $numberOfItem
                ]
            ]);

            $xml = XmlParser::extract($response->getBody()->getContents());
            $response = collect($xml->parse([
                'items' => ['uses' => 'Notification_Data.body.item[personal_reference,title]']
            ])['items']);

            $response->each(function($item) use ($items) {
               $items->push([
                   'id' => $item['personal_reference'],
                   'title' => $item['title'],
               ]);
            });

            $start += $numberOfItem;

            if ($response->count() < $numberOfItem) {
                $continue = false;
            }
        }

        $columns = ['id', 'title'];
        $file = fopen(storage_path().'/app/auctions.csv', 'w');
        fputcsv($file, $columns, ';');

        foreach($items as $item) {
            fputcsv($file, $item, ';');
        }
        fclose($file);
    }

    public function getFixedPrice()
    {
        $continue = true;
        $start = 0;
        $numberOfItem=1000;
        $items = new Collection();

        while ($continue) {
            $response = $this->client->get('http://rest.delcampe.net/item/fixedprice/opened',
                ['query' => [
                    'token' => $this->token,
                    'startingItem' => $start,
                    'numberOfItems' => $numberOfItem
                ]
                ]);

            $xml = XmlParser::extract($response->getBody()->getContents());
            $response = collect($xml->parse([
                'items' => ['uses' => 'Notification_Data.body.item[personal_reference,title]']
            ])['items']);

            $response->each(function($item) use ($items) {
                $items->push([
                    'id' => $item['personal_reference'],
                    'title' => $item['title'],
                ]);
            });

            $start += $numberOfItem;

            if ($response->count() < $numberOfItem) {
                $continue = false;
            }
        }

        $columns = ['id', 'title'];
        $file = fopen(storage_path().'/app/fixedprices.csv', 'w');
        fputcsv($file, $columns, ';');

        foreach($items as $item) {
            fputcsv($file, $item, ';');
        }
        fclose($file);
    }

    public function getNotificationConfig()
    {
        $response = $this->client->get('http://rest.delcampe.net/notification/settings',
            ['query' => [
                'token' => $this->token,
            ]
        ]);

        dd($response->getBody()->getContents());
    }

    public function setNotificationSetting($type) {
        $response = $this->client->post('http://rest.delcampe.net/notification/settings', [
            'query' => [
                'token' => $this->token,
            ],
            'form_params' => [
                'notificationType' => $type,
                'destination'      => 'http://b58d239c.ngrok.io/endpoint/delcampe/items/update/my-super-token'
            ],
            'debug' => true
        ]);

        dd($response->getBody()->getContents());
    }
}