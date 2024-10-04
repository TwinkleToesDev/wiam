<?php

namespace app\controllers;

use Yii;
use yii\db\Exception;
use yii\helpers\VarDumper;
use yii\rest\Controller;
use app\models\LoanRequest;
use yii\web\Response;

class RequestController extends Controller
{
    public function behaviors(): array
    {
        $behaviors = parent::behaviors();
        $behaviors['contentNegotiator']['formats']['application/json'] = Response::FORMAT_JSON;
        return $behaviors;
    }

    /**
     * @throws Exception
     */
    public function actionCreate(): array
    {
        $request = Yii::$app->request;

        $loanRequest = new LoanRequest();
        $loanRequest->load($request->bodyParams, '');

        $hasApprovedRequest = LoanRequest::find()
            ->where(['user_id' => $loanRequest->user_id, 'status' => 'approved'])
            ->exists();

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
