<?php
use App\Http\Controllers\BotManController;
use App\Http\Controllers\GoogleDriveController;
use BotMan\BotMan\Middleware\ApiAi;
use BotMan\BotMan\BotMan;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Outgoing\Question;
use BotMan\BotMan\Messages\Attachments\Image;
use BotMan\BotMan\Messages\Outgoing\OutgoingMessage;
use App\Product;
use App\TypeProduct;


$botman = resolve('botman');

$botman->hears('Hola', function ($bot) {
    $bot->reply('Hola! Soy Raphibot de Megaestruc, en qué puedo ayudarte?');
});
$botman->hears('ayuda', function ($bot) {
    $bot->reply('Tenemos un gran catálogo de servicios');
});

$botman->hears('carga_paletizada', function ($bot) {
    $bot->reply('Elejiste carga_paletizada');
});
$botman->hears('picking', function ($bot) {
    $bot->reply('Elejiste');
});
$botman->hears('mueble_metalico', function ($bot) {
    $bot->reply('Elejiste mueble_metalico');
});
$botman->hears('estructura_especial', function ($bot) {
    $bot->reply('Elejiste estructura_especial');
});




$botman->hears('hilos', GoogleDriveController::class.'@startConversation');







$botman->hears('Start conversation', BotManController::class.'@startConversation');

















$dialogflow = ApiAi::create('0f9adfb0ad9549adaccb8069b24eba9d')->listenForAction();

$botman->middleware->received($dialogflow);
$botman->hears('input.help', function (BotMan $bot) {
    
    $extras = $bot->getMessage()->getExtras();
    $apiReply = $extras['apiReply'];
    $apiAction = $extras['apiAction'];
    $apiIntent = $extras['apiIntent'];
    $producto = Product::where('type_id',1)->get();
    $bot->reply(Question::create('Te presento esta lista de categorías, seleccona el tipo de producto que buscas')->addButtons([
        Button::create($producto[0]['nombre'])->value($producto[0]['nombre']),
        Button::create($producto[1]['nombre'])->value($producto[1]['nombre']),
        Button::create($producto[2]['nombre'])->value($producto[2]['nombre']),
    ]));
    
     
})->middleware($dialogflow);

$botman->middleware->received($dialogflow);
$botman->hears('input.carga_paletizada', function (BotMan $bot) {
    
    $attachment = new Image('http://www.megaestruc.com/images/RACK%20CONVENCIONAL/rc1.jpg');

    $message = OutgoingMessage::create('')
                ->withAttachment($attachment);

    $extras = $bot->getMessage()->getExtras();
    $apiReply = $extras['apiReply'];
    $apiAction = $extras['apiAction'];
    $apiIntent = $extras['apiIntent'];

    $apiParameters = $extras['apiParameters'];
    if ($extras['apiParameters']) {
        $producto = $apiParameters['producto'];
        if ($producto) {
            $bot->reply("Qué deseas saber sobre {$producto}?");
        }
    }
    
    $bot->reply($message);
     
})->middleware($dialogflow);

$botman->middleware->received($dialogflow);
$botman->hears('input.cotizar', function (BotMan $bot) {
    
    $attachment = new Image('http://www.megaestruc.com/images/RACK%20CONVENCIONAL/rc1.jpg');

    $message = OutgoingMessage::create('')
                ->withAttachment($attachment);

    $extras = $bot->getMessage()->getExtras();
    $apiReply = $extras['apiReply'];
    $apiAction = $extras['apiAction'];
    $apiIntent = $extras['apiIntent'];

    $apiParameters = $extras['apiParameters'];
    if ($extras['apiParameters']) {
        
        if ($apiParameters['phone-number']) {
            $telefono = $apiParameters['phone-number'];
            $bot->reply("Tu número de celular es {$telefono}");
        }
    }
    
    $bot->reply($message);
     
})->middleware($dialogflow);