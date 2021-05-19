<?php

namespace App\Http\Controllers;

use App\Http\Requests\NotificationRequest;
use App\Models\Application;
use App\Models\Logs;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class NotificationController extends Controller
{
    public function send(NotificationRequest $request){
        try {
            date_default_timezone_set('America/Recife');

            $params = $request->all();
            $params['category'] = $params['category'] ?? null;
            $params['datetime'] = now();
            
            $date = date('c', strtotime($params['datetime']));

            $response = Http::withBasicAuth(env('ZENVIA_USERNAME'), env('ZENVIA_PASSWORD'))
            ->withHeaders([ 'Content-Type: application/json', 'Accept: application/json' ])
            ->post(env('ZENVIA_URL'), [
                "sendSmsRequest" => [
                        "from" => $params['title'],
                        "to" => $params['phone'],
                        "schedule" => date('c', strtotime($date.' - 3 hours')),
                        "msg" =>  $params['message'],
                        "id" => $params['phone']."_".$date     
                    ]   
                ]
            );

            if($response->successful()){
                $partId = $response->Json()['sendSmsResponse']['parts'][0]['partId'] ?? null;
                $params['partId'] = $partId;

                $log = new Logs($params);
                $log->save();

                return response(['error' => false, 'message' => "SMS Enviado com sucess!"], 200);
            }else{
                if($response->clientError()) throw new Exception("Erro de cliente, existe alguns dados inconsistentes causando erro.");
                if($response->serverError()) throw new Exception("Erro de Servidor, serviço fora do ar ou em manutenção.");
            }

        } catch (\Exception $ex) {
            return response(['error' => true, 'message' => $ex->getMessage()], 400);
        }
    }

    public function get(Request $request){
        try {
            
            if(!$request->has('application_id')) throw new Exception('Nenhuma aplicação foi encontrada.');
            
            $application_id = $request->input('application_id');
            $logs = Application::find($application_id)->logs();

            if($request->has('date_start') && $request->has('date_end')) {
                $date_start = $request->input('date_start');
                $date_end = $request->input('date_end');

                $logs = $logs->whereDate('datetime', ' >= ', $date_start)
                ->whereDate('datetime', '<=', $date_end);
            }

            if($request->has('category')){
                $category = $request->input('category');
                $logs = $logs->where('category', $category);
            }

            $logs = $logs->get()->toArray();
            
            return response(['error' => false, 'data' => $logs ], 200);

        } catch (\Exception $ex) {
            return response(['error' => true, 'message' => $ex->getMessage()], 400);
        }
    }
}
