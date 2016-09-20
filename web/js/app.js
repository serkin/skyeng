(function(){
    angular.module("Skyeng", ['ngCookies'])
        .controller("DictionaryController", ['$scope', '$http','$cookies', function($scope, $http, $cookies){

            $scope.createUser = function(){
                $http.post('/users', {
                    name: $scope.username
                }).success(function(response){
                    if (response.id_user) {
                        $cookies.put('token', response.token);
                        $scope.newChallenge();
                    }
                });
            };

            $scope.newChallenge = function(){
                $http.post('/challenges', {
                    token: $cookies.get('token')
                }).success(function(response){
                    if (response.id_challenge) {
                        $scope.idChallenge = response.id_challenge;
                        $scope.getNextQuestion();
                    }
                });
            };

            $scope.getNextQuestion = function(){
                $http.get('/challenges/'+$scope.idChallenge+'/question').success(function(response){
                    if (!response.error) {

                        $scope.test = response;
                        $scope.id_word = response.question.id_word;
                        $scope.step = 'question';
                        $('.answer-btn').attr('disabled', false)
                            .removeClass('btn-success')
                            .removeClass('btn-danger');

                    }
                });
            };


            $scope.sendAnswer = function(id_chosen_word){

                $http.post('/challenges/'+$scope.idChallenge+'/question', {
                    id_word: $scope.id_word,
                    id_chosen_word: id_chosen_word,
                    token: $cookies.get('token')
                }).success(function(response){
                    if (response.is_correct) {

                        // button success

                    } else {

                        // button danger
                    }

                    setTimeout(function(){
                        $scope.checkChallenge();
                    }, 350);
                });
            };

            $scope.checkChallenge = function(){
                $http.get('/challenges/'+$scope.idChallenge).success(function(response){
                    if (response.id_challenge) {

                        if(response.questions_failed >= 3 || (response.questions_failed + response.questions_completed) >= response.questions_total) {

                            $scope.review = {};
                            $scope.review.questionsCompleted = response.questions_completed;
                            $scope.review.questionsFailed = response.questions_failed;
                            $scope.review.failedAnswers = response.failed_answers;

                            $scope.step = 'review';
                        } else {
                            $scope.getNextQuestion();
                        }
                    }
                });
            };

        }]);
})();
