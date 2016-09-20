<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\db\Query;

class Challenge extends ActiveRecord
{
    const MAX_POSSIBLE_QUESTIONS = 5;
    
    /**
     * @return string the name of the table associated with this ActiveRecord class.
     */
    public static function tableName()
    {
        return 'challenge';
    }


    /**
     * @return array
     */
    public function format() {
        return [
            'id_challenge'          => $this->id_challenge,
            'questions_total'       => $this->amount,
            'questions_completed'   => $this->getTotalCompletedQuestions(),
            'questions_failed'      => $this->getTotalFailedQuestions(),
            'failed_answers'        => $this->getAllFailedWords()
        ];
    }


    /**
     * Gets challenge total completed questions
     * 
     * @return int
     */
    private function getTotalCompletedQuestions() {

        return (int)(new Query())
            ->from('history')
            ->where('correct=1')
            ->andWhere('id_challenge = :id_challenge', [':id_challenge' => $this->id_challenge])
            ->count();

    }


    /**
     * Get challenge total failed answers
     * 
     * @return int
     */
    private function getTotalFailedQuestions() {
        return (int)(new Query())
            ->from('history')
            ->where('correct=0')
            ->andWhere('id_challenge = :id_challenge', [':id_challenge' => $this->id_challenge])
            ->count();
    }

    /**
     * Gets list of failed words
     * 
     * @return mixed
     */
    private function getAllFailedWords() {
        return array_column(
                (new Query())
                    ->select(['w.word'])
                    ->from('history h')
                    ->leftJoin('word w', 'w.id_word = h.id_word')
                    ->where('h.correct=0')
                    ->andWhere('h.id_challenge = :id_challenge', [':id_challenge' => $this->id_challenge])
                    ->all(),
                'word');
    }


    /**
     * Gets next challenge question
     * 
     * @return array
     */
    public function getNextQuestion() {

        $out = [];

        $question = (new Query())
            ->select(['t.id_word1','t.id_word2', 'w.word', 'w.id_language'])
            ->from('translation t')

            ->leftJoin('history h', 'h.id_word = t.id_word1 or h.id_word = t.id_word2')
            ->leftJoin('word w', 'w.id_word = t.id_word1 or w.id_word = t.id_word2')
            ->where('h.id_word is null')
            ->groupBy('w.id_language')
            ->orderBy('RAND()')
            ->all();


        if(!empty($question)) {

            $out['question'] = [
                'word' => $question[0]['word'],
                'id_word' => (int)$question[0]['id_word1']
            ];

            $out['answers'] = (new Query())
                ->select(['w.word', 'w.id_word'])
                ->from('word w')
                ->where('w.id_word not in ( :id_word1, :id_word2)', [':id_word1' => $question[0]['id_word1'],':id_word2' => $question[0]['id_word2']])
                ->andWhere('w.id_language = :id_language', [':id_language' => (int)$question[1]['id_language']])
                ->limit(3)
                ->all();

            $out['answers'][] = [
                'word' => $question[1]['word'],
                'id_word' => (int)$question[0]['id_word2']
            ];

            shuffle($out['answers']);
        }

        return $out;

    }


    /**
     * Checks whether answer is correct
     * 
     * @param int $idWord1
     * @param int $idWord2
     * 
     * @return bool
     */
    public function isAnswerCorrect($idWord1, $idWord2) {

        return (bool)(new Query())
            ->select(['id_word1'])
            ->from('translation')
            ->where('id_word1 = :id_word1 and id_word2 = :id_word2')
            ->orWhere('id_word1 = :id_word2 and id_word2 = :id_word1')
            ->addParams([':id_word1' => $idWord2, ':id_word2' => $idWord1])
            ->one();

    }

    /**
    public function getMaxPossibleQuestions() {
        return (int) (new \yii\db\Query())
            ->from('word')
            ->count() / 2;
    }
     */
}
