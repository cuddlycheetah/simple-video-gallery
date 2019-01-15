const app = angular.module('mirrorviewer', [

])

app.controller('SeriesCtrl', function($scope, $rootScope, $http) {
    $http.get('/mirror/?series')
    .then(($data) => {
        let $series = $data.data
        $rootScope.series = $series
        $scope.series = $series
    })
    .catch(console.error)


    $scope.selectedIndex = ""
    $scope.selectedVideo = {file:"", thumb: ""}

    $scope.playEpisode = (data, i) => {
        $scope.selectedVideo = data
        $scope.selectedIndex = i
    }
})


document.querySelector('.removeByScript').remove()