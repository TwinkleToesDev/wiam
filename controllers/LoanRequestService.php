<?php

namespace app\controllers;

use Yii;

class LoanRequestService
{
    public function create($loanRequest): array
    {
        if ($loanRequest->validate() && $loanRequest->save()) {
            Yii::$app->response->statusCode = 201;
            return [
                'result' => true,
                'id' => $loanRequest->id,
            ];
        } else {
            Yii::$app->response->statusCode = 400;
            return [
                'result' => false,
                'errors' => $loanRequest->errors
            ];
        }
    }
}
