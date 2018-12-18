<?php
/**
 * Created by PhpStorm.
 * User: arnaud
 * Date: 18/12/18
 * Time: 10:13
 */

namespace App\Http\Controllers\Endpoints\Delcampe;


use App\Http\Services\DelcampeService;
use App\Item;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Orchestra\Parser\Xml\Facade as XmlParser;

class SellerItemUpdateEndpointController
{

    /**
     * @var DelcampeService
     */
    private $delcampeService;

    public function __construct(DelcampeService $delcampeService)
    {
        $this->delcampeService = $delcampeService;
    }

    public function __invoke(Request $request, $token)
    {
        if ($token != config('delcampe.endpoint_token')) {
            throw new BadRequestHttpException('Bad origin');
        }

        $xml = XmlParser::extract($request->get('delcampeNotification'));
        $itemFromXml = $xml->parse([
            'id_item' => ['uses' => 'Notification_Data.id_item'],
            'personal_reference' => ['uses' => 'Notification_Data.personal_reference']
        ]);

        $itemFromXml = $this->delcampeService->getItem($itemFromXml['id_item']);

        Item::updateOrCreate(
            ['id_item' => intval($itemFromXml['id_item'])],
            [
                'id_country'=> $itemFromXml['id_country'],
                'id_category' => $itemFromXml['id_category'],
                'title' => $itemFromXml['title'],
                'subtitle' => $itemFromXml['subtitle'],
                'personal_reference' => $itemFromXml['personal_reference'],
                'description' => $itemFromXml['description'],
                'price_starting' => $itemFromXml['price_starting'],
                'fixed_price' => $itemFromXml['fixed_price'],
                'price_present' => $itemFromXml['price_present'],
                'price_increment' => $itemFromXml['price_increment'],
                'currency' => $itemFromXml['currency'],
                'date_end' => Carbon::createFromFormat('Y-m-d H:i:s', $itemFromXml['date_end']),
                'duration' => $itemFromXml['duration'],
                'renew' => $itemFromXml['renew'],
                'bids' => $itemFromXml['bids'],
                'option_boldtitle' => $itemFromXml['option_boldtitle'] ?? false,
                'option_coloredborder' => $itemFromXml['option_coloredborder'] ?? false,
                'option_highlight' => $itemFromXml['option_highlight'] ?? false,
                'option_keepoptionsonrenewal' => $itemFromXml['option_keepoptionsonrenewal'] ?? false,
                'option_lastminutebidding' => $itemFromXml['option_lastminutebidding'] ?? false,
                'option_privatebidding' => $itemFromXml['option_privatebidding'] ?? false,
                'option_subtitle' => $itemFromXml['option_subtitle'] ?? false,
                'option_topcategory' => $itemFromXml['option_topcategory'] ?? false,
                'option_toplisting' => $itemFromXml['option_toplisting'] ?? false,
                'option_topmain' => $itemFromXml['option_topmain'] ?? false,
            ]
        );

        $logfileName = storage_path().'/app/log/feedbackFromDelcampeApi' . date('Ymd') . '.log';

        $logFileHandler = fopen($logfileName, 'a');
        //chmod ($logFileHandler, 0666);
        fwrite($logFileHandler, date('H:i:s') . ' | ' . json_encode($itemFromXml) . "\n");
        fclose($logFileHandler);
    }
}