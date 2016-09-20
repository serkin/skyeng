<div class="site-index" ng-controller="DictionaryController">

    <div class="jumbotron">
        <h1>Словарь</h1>
    </div>

    <div class="body-content">

        <div class="row" ng-init="step = 'login';">

            <div ng-show="step == 'login'">
                <form ng-submit = "LoginForm.$valid && createUser()" name="LoginForm">
                    Ваше имя: <input type="text" name="username" ng-model = "username" required>
                    <button ng-disabled = "LoginForm.$invalid">Начать тест</button>
                </form>
            </div>



            <div ng-show="step == 'question'">
                <h2 class="dictionary-task-question ng-cloak">{{test.question.word}}</h2>
                <div class="answers">
                    <p ng-repeat="word in test.answers">
                    <input type="radio"
                        ng-model="id_chosen_word" value="{{word.id_word}}"
                        ng-click="sendAnswer(word.id_word)"> {{word.word}}
                    </p>
                </div>
            </div>


            <div ng-show="step == 'review'">
                <p>Правильных ответов: <span class="result-rate">{{review.questionsCompleted}}</span></p>
                <p>Ошибок: <span class="result-fault-cnt">{{review.questionsFailed}}</span></p>
                <div class="result-fault-list">
                    <span class="label label-danger fault-word" ng-repeat="word in review.failedAnswers">{{word}}</span>
                </div>
            </div>


            <div ng-show="step != 'login'">
                <hr>
                <p class="text-center"><button type="button" class="btn btn-default btn-xs btn-reset" ng-click="newChallenge()">Начать заново</button></p>
            </div>

        </div>
    </div>
</div>
