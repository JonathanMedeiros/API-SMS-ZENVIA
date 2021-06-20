<?php

namespace App\Http\Controllers;

use App\Http\Requests\EnableAndDisabledNotificationRequest;
use App\Models\Application;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    public function enableAndDisable(EnableAndDisabledNotificationRequest $request){
        try {
            $params = $request->all();

            $application = Application::find($params['application_id']);
            $application->active = $params['status'];
            $application->save();
    
            return response(['error' => false], 201);
        } catch (\Throwable $err) {
            return response(['error' => true, 'message' => $err->getMessage()], 400);
        }
    }

    public function getDetailApplication(Request $request){
        try {
            $params = $request->all();

            $application = Application::find($params['application_id']);
            unset($application['token']);
    
            return response(['error' => false, 'data' => $application], 201);
        } catch (\Throwable $err) {
            return response(['error' => true, 'message' => $err->getMessage()], 400);
        }
    }
}
