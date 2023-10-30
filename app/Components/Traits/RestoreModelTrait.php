<?php

namespace App\Components\Traits;

use Illuminate\Support\Facades\Log;

trait RestoreModelTrait
{
    public function restoreModelTrait($id, $model)
    {
        try {
            $data = $model->find($id);
            $data->trang_thai = 1;
            $data->save();
            return response()->json([
                'code' => 200,
                'message' => 'success'
            ], 200);
        } catch (\Exception $exception) {
            Log::error('Message: ' . $exception->getMessage() . ' --- Line : ' . $exception->getLine());
            return response()->json([
                'code' => 500,
                'message' => 'fail'
            ], 500);
        }
    }
}
