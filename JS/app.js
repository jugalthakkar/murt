/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
angular.module('visualization', ['ngRoute','resultServices']).config(visualizationRouter);

function visualizationRouter($routeProvider) {
//    console.log($routeProvider);
    $routeProvider.when('/', {templateUrl: 'partials/results.html'});
    $routeProvider.when('/charting', {templateUrl: 'partials/charting.html'});
}


