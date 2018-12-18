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

    /**
     * @return Collection
     */
    public function getNotificationConfig()
    {
        $response = $this->client->get('http://rest.delcampe.net/notification/settings',
            ['query' => [
                'token' => $this->token,
            ]
        ]);

        $xml = XmlParser::extract($response->getBody()->getContents());

        $response = collect($xml->parse([
            'notifications' => ['uses' => 'Notification_Data.body.notification_settings[id_notification,channel,type,destination,active]']
        ])['notifications']);

        return $response;
    }

    public function setNotificationSetting($type, $destination) {
        $this->client->post('http://rest.delcampe.net/notification/settings', [
            'query' => [
                'token' => $this->token,
            ],
            'form_params' => [
                'notificationType' => $type,
                'destination'      => $destination
            ],
            'debug' => true
        ]);

        return true;
    }

    public function deleteNotificationSetting($id) {
        $this->client->delete('http://rest.delcampe.net/notification/'.$id, [
            'query' => [
                'token' => $this->token,
            ]
        ]);

        return true;
    }

    public function getItem($id)
    {
        $response = $this->client->get('http://rest.delcampe.net/item/'.$id,
            ['query' => [
                'token' => $this->token,
            ]
        ]);

        $xml = XmlParser::extract($response->getBody()->getContents());

        return $xml->parse([
            'id_item' => ['uses' => 'Notification_Data.body.item.id_item'],
            'id_country' => ['uses' => 'Notification_Data.body.item.id_country'],
            'id_category' => ['uses' => 'Notification_Data.body.item.id_category'],
            'title' => ['uses' => 'Notification_Data.body.item.title'],
            'subtitle' => ['uses' => 'Notification_Data.body.item.subtitle'],
            'personal_reference' => ['uses' => 'Notification_Data.body.item.personal_reference'],
            'description' => ['uses' => 'Notification_Data.body.item.description' ],
            'price_starting' => ['uses' => 'Notification_Data.body.item.price_starting'],
            'fixed_price' => ['uses' => 'Notification_Data.body.item.fixed_price'],
            'price_present' => ['uses' => 'Notification_Data.body.item.price_present'],
            'price_increment' => ['uses' => 'Notification_Data.body.item.price_increment'],
            'currency' => ['uses' => 'Notification_Data.body.item.currency'],
            'date_end' => ['uses' => 'Notification_Data.body.item.date_end'],
            'duration' => ['uses' => 'Notification_Data.body.item.duration'],
            'prefered_end_day' => ['uses' => 'Notification_Data.body.item.prefered_end_day'],
            'prefered_end_hour' => ['uses' => 'Notification_Data.body.item.prefered_end_hour'],
            'qty' => ['uses' => 'Notification_Data.body.item.qty'],
            'renew' => ['uses' => 'Notification_Data.body.item.renew'],
            'bids' => ['uses' => 'Notification_Data.body.item.bids'],
            'option_boldtitle' => ['uses' => 'Notification_Data.body.item.option_boldtitle'],
            'option_coloredborder' => ['uses' => 'Notification_Data.body.item.option_coloredborder'],
            'option_highlight' => ['uses' => 'Notification_Data.body.item.option_highlight'],
            'option_keepoptionsonrenewal' => ['uses' => 'Notification_Data.body.item.option_keepoptionsonrenewal'],
            'option_lastminutebidding' => ['uses' => 'Notification_Data.body.item.option_lastminutebidding'],
            'option_privatebidding' => ['uses' => 'Notification_Data.body.item.option_privatebidding'],
            'option_subtitle' => ['uses' => 'Notification_Data.body.item.option_subtitle'],
            'option_topcategory' => ['uses' => 'Notification_Data.body.item.option_topcategory'],
            'option_toplisting' => ['uses' => 'Notification_Data.body.item.option_toplisting'],
            'option_topmain' => ['uses' => 'Notification_Data.body.item.option_topmain'],
        ]);
    }
}