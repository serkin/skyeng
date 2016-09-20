<?php

namespace app\controllers;

use Yii;
use app\models\Challenge;
use app\models\History;

class ChallengeController extends BaseController
{

    public $enableCsrfValidation = false;

    public function actionCreate()
    {

        $user = $this->getUserFromRequest();

        if(!$user) {
            return $this->responseWithError('Please provide valid token');
        }

        $challenge = new Challenge();

        $challenge->amount =  Challenge::MAX_POSSIBLE_QUESTIONS;
        $challenge->id_user = $user->id_user;
        $challenge->save();

        // TODO: Fix getting question query then we can save history and let user finish any of his previous challenges

        History::deleteAll();

        //


        return $this->responseWithSuccess($challenge->format());
        
    }

    /**
     * @param $id
     * @return array
     */
    public function actionView($id)
    {

        $challenge = Challenge::findOne($id);

        return $challenge
            ? $this->responseWithSuccess($challenge->format())
            : $this->responseWithError('Challenge not found');
        
    }

    /**
     * @param $id
     * @return array
     */
    public function actionQuestion($id) {

        $challenge = Challenge::findOne($id);

        if(!$challenge) {
            return $this->responseWithError('Challenge not found');
        }

        $question = $challenge->getNextQuestion();

        return $question
            ? $this->responseWithSuccess($question)
            : $this->responseWithError('No questions left');
    }


    /**
     * @param $id
     * @return array
     */
    public function actionAnswer($id) {

        $user = $this->getUserFromRequest();

        if(!$user) {
            return $this->responseWithError('Please provide valid token');
        }

        $challenge = Challenge::findOne($id);

        if(!$challenge) {
            return $this->responseWithError('Challenge not found');
        }

        if($challenge->id_user != $user->id_user) {
            return $this->responseWithError('You can answer only your questions');
        }

        $request = Yii::$app->request;


        foreach(['id_word', 'id_chosen_word'] as $value) {

            if($request->getBodyParam($value) === null) {
                return $this->responseWithError('Fields: id_word, id_chosen_word are missing');
            }
        }

        $history = new History();
        $history->id_challenge = $id;
        $history->id_chosen_word = (int)$request->getBodyParam('id_chosen_word');
        $history->id_word = (int)$request->getBodyParam('id_word');
        $history->correct = (int)$challenge->isAnswerCorrect($history->id_word, $history->id_chosen_word);

        try {

            $history->save();

            return $this->responseWithSuccess(['is_correct' => (bool)$history->correct]);

        } catch (\Exception $exe) {
            return $this->responseWithError('Question expired or provided data is invalid');
        }
    }
}
